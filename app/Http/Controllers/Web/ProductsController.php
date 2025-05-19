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

		$this->validate($request, [
	        'code' => ['required', 'string', 'max:32'],
	        'name' => ['required', 'string', 'max:128'],
	        'model' => ['required', 'string', 'max:256'],
	        'description' => ['required', 'string', 'max:1024'],
	        'price' => ['required', 'numeric'],
	    ]);

		$product = $product??new Product();
		$product->fill($request->all());
		$product->save();

		return redirect()->route('products_list');
	}

	public function delete(Request $request, Product $product)
	{
		if(!Auth::user() || !Auth::user()->hasRole('Admin')) {
			abort(401, 'Unauthorized action.');
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

    if ($user->credit < $product->price) {
        return redirect()->back()->with('warning', '⚠️ Not enough credit.');
    }

    if ($product->stock <= 0) {
        return redirect()->back()->with('warning', '⚠️ Product out of stock.');
    }

    // Start transaction
    DB::beginTransaction();
    try {
        // Deduct credit and stock
        DB::table('users')->where('id', $user->id)->decrement('credit', $product->price);
        DB::table('products')->where('id', $product->id)->decrement('stock', 1);

        // Find existing basket item or create new one
        $basket = Basket::where('user_id', $user->id)
                       ->where('product_id', $product->id)
                       ->first();

        if ($basket) {
            // Update quantity if item exists
            $basket->increment('quantity');
        } else {
            // Create new basket item
            Basket::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => 1
            ]);
        }

        DB::commit();
        return redirect()->route('products_list')->with('success', 'Product added to basket!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to add product to basket.');
    }
}





public function purchase(Product $product)
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('warning', 'You need to be logged in.');
    }

    if ($user->credit < $product->price) {
        return redirect()->back()->with('warning', '⚠️ Not enough credit.');
    }

    if ($product->stock <= 0) {
        return redirect()->back()->with('warning', '⚠️ Product out of stock.');
    }

    DB::table('users')->where('id', $user->id)->decrement('credit', $product->price);
    DB::table('products')->where('id', $product->id)->decrement('stock', 1);

	$user = Auth::user();

	$basket = Basket::firstOrCreate([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'product_name' => $product->name,
		
        'quantity' => 1

    ]);




	
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


public function checkout()
{
    $user = Auth::user();
    
    if (!$user) {
        return redirect()->route('login')->with('warning', 'You need to be logged in to checkout.');
    }

    $basketItems = Basket::where('user_id', $user->id)->get();
    
    if ($basketItems->isEmpty()) {
        return redirect()->route('products.basket')->with('warning', 'Your basket is empty.');
    }

    // Process the checkout (you can add your checkout logic here)
    // For now, we'll just clear the basket
    Basket::where('user_id', $user->id);
    
    return redirect()->route('products.basket')->with('success', 'Thank you for your purchase!');
}








public function addstock(Request $request, product $product)

{  
  
    if (auth()->user()->hasRole('Employee')){
        
    }
    
    $request->validate([
        'stock' => 'required|numeric|min:1'
    ]);


    $product->stock += $request->stock;

    // Save the updated credit balance
    $product->save();

    return redirect()->back()->with('success', 'Stock updated successfully!');

}
    // In your HomeController or relevant controller
   public function index()
   {
    $products = Product::where('featured', true)->take(3)->get();
    return view('home', compact('products'));
}


public function markAsFavorite($id)
{
    if (!auth()->user()->can('add_fav')) {
        abort(403, 'Unauthorized action.');
    }

    $product = Product::findOrFail($id);
    
    if (!$product->favorite) {
        $product->favorite = 1;
        $product->save();
    }

    return redirect()->back()->with('success', 'Product marked as favorite.');
}

public function removeFromBasket(Basket $basket)
{
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Please login to manage your basket.');
    }

    // Check if the basket item belongs to the current user
    if ($basket->user_id !== auth()->id()) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    try {
        // Get the product to calculate refund amount
        $product = Product::find($basket->product_id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        // Calculate refund amount
        $refundAmount = $product->price * $basket->quantity;

        // Start transaction
        DB::beginTransaction();
        try {
            // Refund the credit to the user
            auth()->user()->increment('credit', $refundAmount);
            
            // Return the stock
            $product->increment('stock', $basket->quantity);
            
            // Remove from basket
            $basket->delete();
            
            DB::commit();
            return redirect()->route('products.basket')->with('success', 'Item removed from basket and credit refunded.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to process refund.');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to remove item from basket.');
    }
    
}


public function showFavourites()
{
    if (!auth()->user()->can('add_favourite')) {
        abort(403, 'Unauthorized.');
    }

    $products = Product::where('favorite', 1)->get();

    return view('products.fav', compact('products'));
}






}