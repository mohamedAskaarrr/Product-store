<?php
namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Artisan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
// use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Basket;


class UsersController extends Controller {

	use ValidatesRequests;

    public function list(Request $request) {
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors('Please login to access this page.');
        }
        
        if(!auth()->user()->hasPermissionTo('show_users')) {
            abort(401, 'Unauthorized access.');
        }

        $query = User::query();
        if (auth()->user()->hasRole('Employee')){
            $query->role('Customer');
        }
        
        $query->when($request->keywords, 
            fn($q)=> $q->where("name", "like", "%$request->keywords%"));
        $users = $query->get();
        return view('users.list', compact('users'));
    }

	public function register(Request $request) {
        return view('users.register');
    }

    public function doRegister(Request $request) {

    	try {
    		$this->validate($request, [
	        'name' => ['required', 'string', 'min:5'],
	        'email' => ['required', 'email', 'unique:users'],
	        'password' => ['required'],//, 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()
	    	]);
    	}
    	catch(\Exception $e) {

    		return redirect()->back()->withInput($request->input())->withErrors('Invalid registration information.');
    	}

    	
    	$user =  new User();
	    $user->name = $request->name;
	    $user->email = $request->email;
	    $user->password = bcrypt($request->password); //Secure
	    $user->save();
        $user->assignRole('Customer');
        $user->givePermissionTo('add_fav');


        $title = "Verification Link";
        $token = Crypt::encryptString(json_encode(['id' => $user->id, 'email' => $user->email]));
        $link = route("verify", ['token' => $token]);
        try {
            \Log::info('Attempting to send verification email to: ' . $user->email);
            Mail::to($user->email)->send(new VerificationEmail($link, $user->name));
            \Log::info('Successfully sent verification email');
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email: ' . $e->getMessage());
            return redirect('/')->with('message', 'Registration complete. If you did not receive an email, please check your spam folder or contact support.');
        }
        return redirect('/');
       
    }

    public function login(Request $request) {
        return view('users.login');
    }

    public function doLogin(Request $request) {
    	
    	if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            return redirect()->back()->withInput($request->input())->withErrors('Invalid login information.');

            $user = User::where('email', $request->email)->first();
            if(!$user->email_verified_at) {
            Auth::logout();
            $encodedEmail = $request->email;
            return redirect()->back()
                ->withInput(['email' => $request->email])
                ->withErrors('Your email is not verified. <a href="' . route('resend.verification', ['email' => $encodedEmail]) . '">Click here to resend verification email</a>');
        }

        return redirect('/');
    }


    public function verify(Request $request) {
    $decryptedData = json_decode(Crypt::decryptString($request->token),true); 
    $user = User::find($decryptedData['id']);
    if(!$user) abort(401);
    $user->email_verified_at = Carbon::now();
    $user->save();
    
    // Clear any existing session before logging in
    Auth::logout();
    
    // Log in the user after verification
    Auth::login($user);
    
    return view('users.verified',compact('user'));
}

    public function resendVerification(Request $request) {
    $email = urldecode($request->query('email'));
    
    if (!$email) {
        return redirect()->route('login')
            ->withErrors('Email parameter is missing. Please try logging in again.');
    }
    
    \Log::info('Attempting to find user with email: ' . $email);
    
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        \Log::info('No user found with email: ' . $email);
        return redirect()->route('login')
            ->withErrors('User not found with email: ' . $email)
            ->withInput(['email' => $email]); 
    }
    
    $token = Crypt::encryptString(json_encode(['id' => $user->id, 'email' => $user->email]));
    $link = route("verify", ['token' => $token]);
    
    try {
        \Log::info('Attempting to send verification email to: ' . $user->email);
        Mail::to($user->email)->send(new VerificationEmail($link, $user->name));
        \Log::info('Successfully sent verification email');
    } catch (\Exception $e) {
        \Log::error('Failed to send verification email: ' . $e->getMessage());
        return redirect('/')->with('message', 'Registration complete. If you did not receive an email, please check your spam folder or contact support.');
    }
    
    return redirect()->route('login')
        ->with('success', 'Verification email has been resent to ' . $email . '. Please check your inbox.')
        ->withInput(['email' => $email]);
}

    public function doLogout(Request $request) {
    	
    	Auth::logout();

        return redirect('/');
    }

    public function profile(Request $request, User $user = null) {

        $user = $user ?? auth()->user();


        if (!$user) {
            return redirect()->route('login')->withErrors('You must be logged in to view your profile.');
        }

        if(auth()->id() != $user->id) {
            if(!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $permissions = [];
        foreach($user->permissions as $permission) {
            $permissions[] = $permission;
        }
        foreach($user->roles as $role) {
            foreach($role->permissions as $permission) {
                $permissions[] = $permission;
            }
        }

        return view('users.profile', compact('user', 'permissions'));
    }

    public function edit(Request $request, User $user = null) {
        $user = $user ?? auth()->user();
        if(auth()->id() != $user?->id) {
            if(!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        $roles = [];
        foreach(Role::all() as $role) {
            $role->taken = ($user->hasRole($role->name));
            $roles[] = $role;
        }

        $permissions = [];
        foreach(Permission::all() as $permission) {
            $permission->taken = $user->hasPermissionTo($permission->name);
            $permissions[] = $permission;
        }      

        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function save(Request $request, User $user) {
        if(auth()->id() != $user->id) {
            if(!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $request->validate([
            'name' => 'required|string|min:5',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'credit' => 'required|numeric|min:0',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        
        // Update credit if user has permission
        if(auth()->user()->hasPermissionTo('manage_customer_credit')) {
            $user->credit = $request->credit;
        }
        
        $user->save();

        if(auth()->user()->hasPermissionTo('show_users')) {
            // Sync roles using role names
            if($request->has('roles')) {
                $user->syncRoles($request->roles);
            }

            // Sync permissions using permission names
            if($request->has('permissions')) {
                $user->syncPermissions($request->permissions);
            }

            Artisan::call('cache:clear');
        }

        return redirect(route('profile', ['user'=>$user->id]))->with('success', 'User updated successfully');
    }

    public function delete(User $user)
    {
        if(!Auth::user() || !Auth::user()->hasRole('Admin')) {
            abort(401, 'Unauthorized action.');
        }

        try {
            $user->delete();
            return redirect()->route('users')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('users')->with('error', 'Failed to delete user');
        }
    }

    public function editPassword(Request $request, User $user = null) {

        $user = $user??auth()->user();
        if(auth()->id()!=$user?->id) {
            if(!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        return view('users.edit_password', compact('user'));
    }

    public function savePassword(Request $request, User $user) {

        if(auth()->id()==$user?->id) {
            
            $this->validate($request, [
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);

            if(!Auth::attempt(['email' => $user->email, 'password' => $request->old_password])) {
                
                Auth::logout();
                return redirect('/');
            }
        }
        else if(!auth()->user()->hasPermissionTo('edit_users')) {

            abort(401);
        }

        $user->password = bcrypt($request->password); //Secure
        $user->save();

        return redirect(route('profile', ['user'=>$user->id]));
    }

    public function unblockUser(User $user)
    {
        if (auth()->user()->role !== 'employee') {
            abort(403, 'Unauthorized');
        }

        $user->is_blocked = false;
        $user->login_attempts = 0;
        $user->save();

        return redirect()->back()->with('success', 'User has been unblocked.');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback() {
        try {
            $googleUser = Socialite::driver('google')->user();
            \Log::info('Google user data received', ['email' => $googleUser->email]);
            
            // First try to find a user with this Google ID
            $user = User::where('google_id', $googleUser->id)->first();
            
            if (!$user) {
                $user = User::where('email', $googleUser->email)->first();
                
                if ($user) {
                    \Log::info('Updating existing user with Google data');
                    $user->google_id = $googleUser->id;
                    $user->google_token = $googleUser->token;
                    $user->google_refresh_token = $googleUser->refreshToken;
                    $user->email_verified_at = now();
                    $user->save();
                } else {
                    \Log::info('Creating new user from Google data');
                    $user = User::create([
                        'google_id' => $googleUser->id,
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_token' => $googleUser->token,
                        'google_refresh_token' => $googleUser->refreshToken,
                        'email_verified_at' => now(),
                        'password' => bcrypt(Str::random(16))
                    ]);
                    $user->assignRole('Customer');
                }
            }
            
            Auth::login($user);
            return redirect('/');
            
        } catch (\Exception $e) {
            \Log::error('Google login error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return redirect()->route('login')
                ->withErrors(['email' => 'Google login failed: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        if(!auth()->user()->hasPermissionTo('admin_users')) {
            abort(401);
        }

        $roles = Role::all();
        $permissions = Permission::all();
        
        return view('users.create', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        if(!auth()->user()->hasPermissionTo('admin_users')) {
            abort(401);
        }

        $request->validate([
            'name' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        if($request->has('roles')) {
            // Convert role names to array and sync roles
            $roleNames = is_array($request->roles) ? $request->roles : [$request->roles];
            $user->syncRoles($roleNames);
        }

        if($request->has('permissions')) {
            // Convert permission names to array and sync permissions
            $permissionNames = is_array($request->permissions) ? $request->permissions : [$request->permissions];
            $user->syncPermissions($permissionNames);
        }

        // Clear the permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('users')->with('success', 'User created successfully');
    }

    // Add product function
    public function createProduct()
    {
        if(!auth()->user()->hasPermissionTo('add_products')) {
            abort(401);
        }
        return view('products.create');
    }

    // Update stock function
    public function updateStock(Request $request, Product $product)
    {
        if(!auth()->user()->hasPermissionTo('manage_inventory')) {
            abort(401);
        }
        
        $request->validate([
            'stock' => 'required|numeric|min:0'
        ]);
        
        $product->stock = $request->stock;
        $product->save();
        
        return redirect()->back()->with('success', 'Stock updated successfully');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function purchaseHistory(User $user)
    {
        if (!auth()->user() || (auth()->id() != $user->id && !auth()->user()->hasPermissionTo('show_users'))) {
            abort(403, 'Unauthorized');
        }

        $purchases = \DB::table('purchases')
            ->join('products', 'purchases.product_id', '=', 'products.id')
            ->where('purchases.user_id', $user->id)
            ->select(
                'purchases.*',
                'products.name as product_name',
                'products.photo as product_photo'
            )
            ->orderByDesc('purchases.created_at')
            ->get();

        return view('users.purchase_history', compact('user', 'purchases'));
    }

    public function processPurchase(Request $request, Product $product)
    {
        if(!auth()->user()) {
            return redirect()->route('login');
        }
        
        $request->validate([
            'quantity' => 'required|numeric|min:1|max:' . $product->stock
        ]);
        
        $totalPrice = $product->price * $request->quantity;
        
        if(auth()->user()->credit < $totalPrice) {
            return redirect()->back()->with('error', 'Insufficient credit');
        }
        
        DB::transaction(function() use ($product, $request, $totalPrice) {
            auth()->user()->decrement('credit', $totalPrice);
            
            $product->decrement('stock', $request->quantity);
            
            DB::table('purchases')->insert([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'total_price' => $totalPrice,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        });
        
        return redirect()->route('purchase.history')->with('success', 'Purchase completed successfully');
    }

    public function removeFromBasket(Product $product)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        
        $basketItem = Basket::where('user_id', $user->id)
                           ->where('product_id', $product->id)
                           ->first();
                           
        if ($basketItem) {
            $refundAmount = $product->price * $basketItem->quantity;
            
            DB::beginTransaction();
            try {
                $user->increment('credit', $refundAmount);
                
                $basketItem->delete();
                
                DB::commit();
                return redirect()->route('products.basket')->with('success', 'Product removed from basket and credit refunded');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('products.basket')->with('error', 'Failed to process refund');
            }
        }
        
        return redirect()->route('products.basket')->with('error', 'Product not found in basket');
    }

    public function updateBasketQuantity(Request $request, Product $product)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        
        $request->validate([
            'quantity' => 'required|numeric|min:1|max:' . $product->stock
        ]);
        
        Basket::where('user_id', $user->id)
              ->where('product_id', $product->id)
              ->update(['quantity' => $request->quantity]);
              
        return redirect()->route('products.basket')->with('success', 'Basket updated');
    }

    public function search(Request $request)
    {
        $query = Product::query();
        
        if($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        if($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        if($request->has('model')) {
            $query->where('model', 'like', '%' . $request->model . '%');
        }
        
        $products = $query->paginate(12);
        
        return view('products.search', compact('products'));
    }

    public function featured()
    {
        $products = Product::where('featured', true)->get();
        return view('products.featured', compact('products'));
    }

public function addReview(Request $request, Product $product)
{
    if(!auth()->user()) {
        return redirect()->route('login');
    }
    
    $request->validate([
        'rating' => 'required|numeric|min:1|max:5',
        'comment' => 'required|string|max:1000'
    ]);
    
    DB::table('reviews')->insert([
        'user_id' => auth()->id(),
        'product_id' => $product->id,
        'rating' => $request->rating,
        'comment' => $request->comment,
        'created_at' => now(),
        'updated_at' => now()
    ]);
    
    return redirect()->back()->with('success', 'Review added successfully');
}

public function settings() {
    return view('users.settings');
}

public function refundPurchase($purchaseId)
{
    if (!auth()->user() || !auth()->user()->hasPermissionTo('manage_refunds')) {
        abort(403, 'Unauthorized');
    }

    $purchase = DB::table('purchases')
        ->join('products', 'purchases.product_id', '=', 'products.id')
        ->where('purchases.id', $purchaseId)
        ->select('purchases.*', 'products.id as product_id', 'products.stock')
        ->first();

    if (!$purchase) {
        return redirect()->back()->with('error', 'Purchase not found');
    }

    DB::beginTransaction();
    try {
        DB::table('users')
            ->where('id', $purchase->user_id)
            ->increment('credit', $purchase->total_price);

        DB::table('products')
            ->where('id', $purchase->product_id)
            ->increment('stock', $purchase->quantity);

        DB::table('purchases')->where('id', $purchaseId)->delete();

        DB::commit();
        return redirect()->back()->with('success', 'Refund processed successfully');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to process refund');
    }
}
}
