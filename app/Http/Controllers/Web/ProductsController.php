<?php
namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Basket;


class ProductsController extends Controller {

	use ValidatesRequests;

	public function __construct()
    {
        $this->middleware('auth:web')->except('list');
    }

	public function list(Request $request) {
        


		$query = Product::select("products.*");

		$query->when($request->keywords, 
		fn($q)=> $q->where("name", "like", "%$request->keywords%"));

		$query->when($request->min_price, 
		fn($q)=> $q->where("price", ">=", $request->min_price));
		
		$query->when($request->max_price, fn($q)=> 
		$q->where("price", "<=", $request->max_price));
		
		$query->when($request->order_by, 
		fn($q)=> $q->orderBy($request->order_by, $request->order_direction??"ASC"));

		$products = $query->get();

		return view('products.list', compact('products'));
	}

	public function edit(Request $request, Product $product = null) {

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
            'product_name' => $product->name,
            'quantity' => 1
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
        ->select('basket.*', 'products.price', 'products.stock')
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

        foreach ($basketItems as $item) {
            DB::table('products')
                ->where('id', $item->product_id)
                ->decrement('stock', $item->quantity);

            DB::table('purchases')->insert([
                'user_id' => $user->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'total_price' => $item->price * $item->quantity,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        Basket::where('user_id', $user->id)->delete();
        
        DB::commit();
        return redirect()->route('products.basket')
            ->with('success', 'Thank you for your purchase! Your basket has been cleared.');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Checkout error: ' . $e->getMessage());
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


public function addstock(Request $request, product $product)

{  
  
    if (auth()->user()->hasRole('Employee')){
        
    }
    
    $request->validate([
        'stock' => 'required|numeric|min:1'
    ]);


    $product->stock += $request->stock;

    $product->save();

    return redirect()->back()->with('success', 'Stock updated successfully!');

}
   public function index()
   {
    $products = Product::where('featured', true)->take(3)->get();
    return view('home', compact('products'));
}


public function markAsFavorite($id)
{


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
    $user = auth()->user();
    $products = Product::where('favourite', 1)->get();

    return view('products.fav', compact('user', 'products'));
}




}