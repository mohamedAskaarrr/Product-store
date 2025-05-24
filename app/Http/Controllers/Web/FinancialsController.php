<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FinancialsController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $user = auth()->user();
        if (!($user->can('manage_sales') || $user->can('manage_expenses') || $user->can('manage_profit'))) {
            abort(403, 'Unauthorized');
        }
        $sales = DB::table('sales')->orderByDesc('date')->get();
        $expenses = DB::table('expenses')->orderByDesc('date')->get();
        $profits = DB::table('profit')->orderByDesc('date')->get();
        return view('manage-financials', compact('sales', 'expenses', 'profits', 'user'));
    }
    // Sales CRUD
    public function storeSale(Request $request) {
        $this->authorize('manage_sales');
        $validated = $request->validate([
            'date' => 'required|date',
            'total_amount' => 'required|numeric',
            'total_products' => 'required|integer',
            'payment_method' => 'required|string',
            'status' => 'required|string',
        ]);
        DB::table('sales')->insert([
            'date' => $validated['date'],
            'total_amount' => $validated['total_amount'],
            'total_products' => $validated['total_products'],
            'payment_method' => $validated['payment_method'],
            'status' => $validated['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Update profit for this date
        $this->updateProfitForDate($validated['date']);
        return redirect()->route('manage.financials')->with('success', 'Sale added successfully.');
    }
    public function updateSale(Request $request, $id) { $this->authorize('manage_sales'); /* ... */ }
    public function deleteSale($id) { $this->authorize('manage_sales'); /* ... */ }
    public function showSale($id)
    {
        if (!auth()->user()->can('view_sales')) {
            abort(403, 'Unauthorized');
        }
        $sale = \DB::table('sales')->where('id', $id)->first();
        if (!$sale) abort(404);
        // Optionally fetch related purchases/products for this sale's date
        $products = \DB::table('purchases')
            ->join('products', 'purchases.product_id', '=', 'products.id')
            ->whereDate('purchases.created_at', $sale->date)
            ->select('products.*', 'purchases.quantity', 'purchases.total_price')
            ->get();
        return view('financials.sale-details', compact('sale', 'products'));
    }
    public function editSale($id)
    {
        if (!auth()->user()->can('manage_sales')) {
            abort(403, 'Unauthorized');
        }
        $sale = \DB::table('sales')->where('id', $id)->first();
        if (!$sale) abort(404);
        return view('financials.edit-sale', compact('sale'));
    }
    // Expenses CRUD
    public function storeExpense(Request $request) {
        $this->authorize('manage_expenses');
        $validated = $request->validate([
            'date' => 'required|date',
            'category' => 'required|string',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'status' => 'required|string',
        ]);
        DB::table('expenses')->insert([
            'date' => $validated['date'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'status' => $validated['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Update profit for this date
        $this->updateProfitForDate($validated['date']);
        return redirect()->route('manage.financials')->with('success', 'Expense added successfully.');
    }
    public function updateExpense(Request $request, $id) { $this->authorize('manage_expenses'); /* ... */ }
    public function deleteExpense($id) { $this->authorize('manage_expenses'); /* ... */ }
    public function showExpense($id)
    {
        if (!auth()->user()->can('view_expenses')) {
            abort(403, 'Unauthorized');
        }
        $expense = \DB::table('expenses')->where('id', $id)->first();
        if (!$expense) abort(404);
        return view('financials.expense-details', compact('expense'));
    }
    public function editExpense($id)
    {
        if (!auth()->user()->can('manage_expenses')) {
            abort(403, 'Unauthorized');
        }
        $expense = \DB::table('expenses')->where('id', $id)->first();
        if (!$expense) abort(404);
        return view('financials.edit-expense', compact('expense'));
    }
    // Profit CRUD
    public function storeProfit(Request $request) {
        $this->authorize('manage_profit');
        $validated = $request->validate([
            'date' => 'required|date',
            'total_sales' => 'required|numeric',
            'total_expenses' => 'required|numeric',
            'net_profit' => 'required|numeric',
        ]);
        DB::table('profit')->insert([
            'date' => $validated['date'],
            'total_sales' => $validated['total_sales'],
            'total_expenses' => $validated['total_expenses'],
            'net_profit' => $validated['net_profit'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('manage.financials')->with('success', 'Profit added successfully.');
    }
    public function updateProfit(Request $request, $id) { $this->authorize('manage_profit'); /* ... */ }
    public function deleteProfit($id) { $this->authorize('manage_profit'); /* ... */ }

    // Helper to update profit for a given date
    private function updateProfitForDate($date)
    {
        $total_sales = DB::table('sales')->where('date', $date)->sum('total_amount');
        $total_expenses = DB::table('expenses')->where('date', $date)->sum('amount');
        $net_profit = $total_sales - $total_expenses;
        // Upsert into profit table
        $exists = DB::table('profit')->where('date', $date)->exists();
        if ($exists) {
            DB::table('profit')->where('date', $date)->update([
                'total_sales' => $total_sales,
                'total_expenses' => $total_expenses,
                'net_profit' => $net_profit,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('profit')->insert([
                'date' => $date,
                'total_sales' => $total_sales,
                'total_expenses' => $total_expenses,
                'net_profit' => $net_profit,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
} 