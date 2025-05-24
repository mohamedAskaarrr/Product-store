<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->check() || !(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Manager'))) {
            abort(403, 'Unauthorized');
        }
        return view('dashboard');
    }

    public function getMonthlyStats(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Manager'))) {
            abort(403, 'Unauthorized');
        }
        $start = now()->subMonth()->startOfDay();
        $end = now()->endOfDay();
        // Get all dates in the range
        $dates = collect();
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dates->push($date->format('Y-m-d'));
        }
        // Get sales, expenses, and profit grouped by date
        $sales = \DB::table('sales')
            ->selectRaw('date, SUM(total_amount) as total_sales')
            ->whereBetween('date', [$start, $end])
            ->groupBy('date')
            ->pluck('total_sales', 'date');
        $expenses = \DB::table('expenses')
            ->selectRaw('date, SUM(amount) as total_expenses')
            ->whereBetween('date', [$start, $end])
            ->groupBy('date')
            ->pluck('total_expenses', 'date');
        $profits = \DB::table('profit')
            ->selectRaw('date, net_profit')
            ->whereBetween('date', [$start, $end])
            ->pluck('net_profit', 'date');
        // Build result for each day
        $data = $dates->map(function($date) use ($sales, $expenses, $profits) {
            return [
                'date' => $date,
                'total_sales' => (float)($sales[$date] ?? 0),
                'total_expenses' => (float)($expenses[$date] ?? 0),
                'net_profit' => (float)($profits[$date] ?? 0),
            ];
        });
        return response()->json($data);
    }
} 