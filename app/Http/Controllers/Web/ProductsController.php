<?php
namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Basket;
use App\Mail\PurchaseConfirmation;


class ProductsController extends Controller {

	use ValidatesRequests;

	public function __construct()
    {
        $this->middleware('auth:web')->except('list');
    }

	public function index(): View
    {
        $products = Product::where('featured', true)->take(3)->get();
        return view('home', compact('products'));
    }

	public function list(Request $request): View {
		$query = Product::select("products.*");

		// Handle search
		$query->when($request->keyword, 
			fn($q) => $q->where("name", "like", "%{$request->keyword}%"));

		// Handle price filters
		$query->when($request->min_price, 
			fn($q) => $q->where("price", ">=", $request->min_price));
		
		$query->when($request->max_price, 
			fn($q) => $q->where("price", "<=", $request->max_price));
		
		// Handle sorting
		if ($request->has('sort')) {
			switch ($request->sort) {
				case 'price_asc':
					$query->orderBy('price', 'ASC');
					break;
				case 'price_desc':
					$query->orderBy('price', 'DESC');
					break;
				case 'name_asc':
					$query->orderBy('name', 'ASC');
					break;
				case 'name_desc':
					$query->orderBy('name', 'DESC');
					break;
			}
		}

		$products = $query->get();

		return view('products.list', compact('products'));
	}

	public function edit(Request $request, Product $product = null): View {

		if(!Auth::user()) return redirect('/');

		$product = $product??new Product();

		return view('products.edit', compact('product'));
	}

	public function save(Request $request, Product $product = null) {
		if ($product) {
			if (!auth()->user()->can('edit_products')) {
				abort(403, 'Unauthorized');
			}
		} else {
			if (!auth()->user()->can('add_products')) {
				abort(403, 'Unauthorized');
			}
		}

		$this->validate($request, [
	        'code' => ['required', 'string', 'max:32'],
	        'name' => ['required', 'string', 'max:128'],
	        'model' => ['required', 'string', 'max:256'],
	        'description' => ['required', 'string', 'max:1024'],
	        'price' => ['required', 'numeric'],
	    ]);

		$product = $product ?? new Product();
		$product->fill($request->except('stock'));

		// Only allow users with manage_inventory to set stock
		if (auth()->user()->can('manage_inventory') && $request->has('stock')) {
			$product->stock = $request->stock;
		}

		$product->save();

		return redirect()->route('products_list');
	}

	public function delete(Request $request, Product $product)
	{
		if(!Auth::user() || !Auth::user()->can('delete_products')) {
			abort(403, 'Unauthorized action.');
		}

		try {
			$product->delete();
			return redirect()->route('products_list')->with('success', 'Product deleted successfully');
		} catch (\Exception $e) {
			return redirect()->route('products_list')->with('error', 'Failed to delete product');
		}
	}










    public function addToBasket(Product $product)
    {
        $user = Auth::user();
    
        if (!$user) {
            return redirect()->route('login')->with('warning', 'You need to be logged in.');
        }
    
        if ($product->stock <= 0) {
            return redirect()->back()->with('warning', '⚠️ Product out of stock.');
        }
    
        $basket = Basket::where('user_id', $user->id)
                       ->where('product_id', $product->id)
                       ->first();
    
        if ($basket) {
            $basket->increment('quantity');
        } else {
            Basket::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'product_name' => $product->name
            ]);
        }
    
        return redirect()->route('products_list')->with('success', 'Product added to basket!');
    }




public function checkout()
{
    $user = Auth::user();
    if (!$user) {
        return redirect()->route('login')->with('warning', 'You need to be logged in to checkout.');
    }
    $basketItems = Basket::where('user_id', $user->id)
        ->join('products', 'basket.product_id', '=', 'products.id')
        ->select('basket.*', 'products.name as product_name', 'products.price', 'products.stock')
        ->get();
    if ($basketItems->isEmpty()) {
        return redirect()->route('products.basket')->with('warning', 'Your basket is empty.');
    }
    $totalCost = 0;
    foreach ($basketItems as $item) {
        $totalCost += $item->price * $item->quantity;
        if ($item->stock < $item->quantity) {
            return redirect()->route('products.basket')
                ->with('error', "Not enough stock available for {$item->product_name}");
        }
    }
    if ($user->credit < $totalCost) {
        return redirect()->route('products.basket')
            ->with('error', 'Insufficient credit to complete the purchase.');
    }
    DB::beginTransaction();
    try {
        $user->decrement('credit', $totalCost);
        // Create Order
        $order = new \App\Models\Order();
        $order->user_id = $user->id;
        $order->order_number = 'ORD-' . strtoupper(uniqid());
        $order->total_price = $totalCost;
        $order->status = 'completed';
        $order->save();
        // Create OrderItems and update stock
        $totalProducts = 0;
        foreach ($basketItems as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->price,
                'total_price' => $item->price * $item->quantity,
            ]);
            DB::table('products')
                ->where('id', $item->product_id)
                ->decrement('stock', $item->quantity);
            $totalProducts += $item->quantity;
        }
        // Insert a new sale for this order
        DB::table('sales')->insert([
            'order_id' => $order->id,
            'date' => $order->created_at ? $order->created_at->format('Y-m-d') : now()->format('Y-m-d'),
            'total_amount' => $order->total_price,
            'total_products' => $totalProducts,
            'payment_method' => 'credit',
            'status' => 'completed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Update profit for this order's date
        $orderDate = $order->created_at ? $order->created_at->format('Y-m-d') : now()->format('Y-m-d');
        $total_sales = DB::table('sales')->where('date', $orderDate)->where('status', '!=', 'refunded')->sum('total_amount');
        $total_expenses = DB::table('expenses')->where('date', $orderDate)->sum('amount');
        $net_profit = $total_sales - $total_expenses;
        $exists = DB::table('profit')->where('date', $orderDate)->exists();
        if ($exists) {
            DB::table('profit')->where('date', $orderDate)->update([
                'total_sales' => $total_sales,
                'total_expenses' => $total_expenses,
                'net_profit' => $net_profit,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('profit')->insert([
                'date' => $orderDate,
                'total_sales' => $total_sales,
                'total_expenses' => $total_expenses,
                'net_profit' => $net_profit,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        Basket::where('user_id', $user->id)->delete();
        DB::commit();
        // Send confirmation email if enabled
        if($user->order_updates) {
            try {
                $emailItems = $order->items->map(function($item) {
                    return (object) [
                        'name' => $item->product->name ?? 'N/A',
                        'quantity' => $item->quantity,
                        'price' => $item->unit_price,
                    ];
                });
                Mail::to($user->email)->send(new \App\Mail\PurchaseConfirmation(
                    $user,
                    $emailItems,
                    $totalCost,
                    $order->order_number
                ));
            } catch (\Exception $e) {
                \Log::error('Email sending error: ' . $e->getMessage());
            }
        }
        // TODO: Send refund email in refundOrder
        return redirect()->route('products.basket')
            ->with('success', 'Purchase completed successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Checkout error: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        return redirect()->route('products.basket')
            ->with('error', 'An error occurred during checkout. Please try again.');
    }
}

public function basket()
{
    $user = Auth::user();
    if (!$user) {
        return redirect()->route('login')->with('warning', 'You need to be logged in to view your basket.');
    }

    $basketItems = Basket::where('user_id', $user->id)
        ->join('products', 'basket.product_id', '=', 'products.id')
        ->select('basket.*', 'products.name', 'products.price', 'products.photo')
        ->get();

    return view('products.basket', compact('basketItems'));
}


public function addstock(Request $request, Product $product)

{  
  
    if (auth()->user()->hasRole('Supplier')){
        $product = Product::findOrFail($product->id);
    }
    
    $request->validate([
        'stock' => 'required|numeric|min:1'
    ]);


    $product->stock += $request->stock;

    $product->save();

    return redirect()->back()->with('success', 'Stock updated successfully!');

}

public function markAsFavorite($id)
{
    if (!auth()->user() || !auth()->user()->hasRole('Admin')) {
        abort(403, 'Only administrators can mark products as favorites.');
    }

    $product = Product::findOrFail($id);
    
    if (!$product->favourite) {
        $product->favourite = 1;
        $product->save();
    }

    return redirect()->back()->with('success', 'Product marked as favorite.');
}
public function removeFromBasket(Basket $basket)
{
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Please login to manage your basket.');
    }

    if ($basket->user_id !== auth()->id()) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    try {
        $basket->delete();
        return redirect()->route('products.basket')->with('success', 'Item removed from basket.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to remove item from basket.');
    }
}


public function showFavourites()
{
    if (!auth()->user() || !auth()->user()->hasRole('Admin')) {
        abort(403, 'Only administrators can view favorites.');
    }

    $user = auth()->user();
    $products = Product::where('favourite', 1)->get();

    return view('products.fav', compact('user', 'products'));
}




}