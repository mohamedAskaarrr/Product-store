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
use App\Mail\PurchaseConfirmation;
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
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You have been successfully logged out.');
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
            'role' => 'required|exists:roles,name',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        
        // Update credit if user has permission
        if(auth()->user()->hasPermissionTo('manage_customer_credit')) {
            $user->credit = $request->credit;
        }
        
        $user->save();

        if(auth()->user()->hasPermissionTo('show_users')) {
            // Sync only one role
            if($request->has('role')) {
                $user->syncRoles([$request->role]);
            }

            // Handle custom permissions: if any checked, assign; if none, remove all direct permissions
            if($request->has('permissions') && is_array($request->permissions) && count($request->permissions)) {
                $user->syncPermissions($request->permissions);
            } else {
                $user->syncPermissions([]); // Remove all direct permissions
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
            if (app()->environment('local')) {
                // Disable SSL verification for local development
                \Config::set('services.google.verify', false);
                \Config::set('services.google.guzzle', [
                    'verify' => false
                ]);
            }
            
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
            'role' => 'required|exists:roles,name',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $user->syncRoles([$request->role]);

        if($request->has('permissions')) {
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
        
        $query = $user->orders()->with('items.product')->orderByDesc('created_at');
        
        if (request()->filled('date')) {
            $query->whereDate('created_at', request('date'));
        }
        
        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }
        
        $orders = $query->get();
        return view('users.purchase_history', compact('user', 'orders'));
    }

    public function orderDetails($orderId)
    {
        $order = \App\Models\Order::with('items.product', 'user')->findOrFail($orderId);
        if (!auth()->user() || (auth()->id() != $order->user_id && !auth()->user()->hasPermissionTo('show_users'))) {
            abort(403, 'Unauthorized');
        }
        // Check for pending refund request
        $pendingRefundRequest = \DB::table('refund_requests')
            ->where('order_id', $order->id)
            ->where('status', 'pending')
            ->exists();
        $canRequestRefund = $order->status === 'completed' && !$pendingRefundRequest;
        return view('users.order_details', compact('order', 'pendingRefundRequest', 'canRequestRefund'));
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

    // Find the sale that matches date and payment method (and optionally status)
    $sale = DB::table('sales')
        ->where('date', date('Y-m-d', strtotime($purchase->created_at)))
        ->where('payment_method', $purchase->payment_method ?? 'credit') // fallback to 'credit' if not set
        // ->where('status', 'completed') // Uncomment if you want to match status too
        ->first();

    DB::beginTransaction();
    try {
        // Refund credit to user
        DB::table('users')
            ->where('id', $purchase->user_id)
            ->increment('credit', $purchase->total_price);

        // Restock product
        DB::table('products')
            ->where('id', $purchase->product_id)
            ->increment('stock', $purchase->quantity);

        // Deduct from the correct sale
        if ($sale) {
            $newTotalAmount = $sale->total_amount - $purchase->total_price;
            $newTotalProducts = $sale->total_products - $purchase->quantity;
            if ($newTotalAmount <= 0 || $newTotalProducts <= 0) {
                DB::table('sales')->where('id', $sale->id)->delete();
            } else {
                DB::table('sales')->where('id', $sale->id)->update([
                    'total_amount' => $newTotalAmount,
                    'total_products' => $newTotalProducts,
                    'updated_at' => now(),
                ]);
            }
        }

        // Delete the purchase
        DB::table('purchases')->where('id', $purchaseId)->delete();

        // Update profit for that date
        app(\App\Http\Controllers\Web\FinancialsController::class)->updateProfitForDate(date('Y-m-d', strtotime($purchase->created_at)));

        DB::commit();
        return redirect()->back()->with('success', 'Refund processed successfully');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to process refund');
    }
}

public function updateSettings(Request $request)
{
    try {
        $user = Auth::user();
        
        $data = [
            'email_offers' => $request->has('email_offers'),
            'order_updates' => $request->has('order_updates'),
            'data_sharing' => $request->has('data_sharing')
        ];

        if ($request->has('currency')) {
            $data['currency'] = $request->currency;
        }
        if ($request->has('language')) {
            $data['language'] = $request->language;
        }
        if ($request->has('theme')) {
            $data['theme'] = $request->theme;
        }

        $validated = validator($data, [
            'email_offers' => 'boolean',
            'order_updates' => 'boolean',
            'data_sharing' => 'boolean',
            'currency' => 'nullable|in:USD,EUR,EGP',
            'language' => 'nullable|in:en,ar',
            'theme' => 'nullable|in:dark,light'
        ])->validate();

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully'
        ]);
    } catch (\Exception $e) {
        \Log::error('Settings update error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to update settings: ' . $e->getMessage()
        ], 500);
    }
}

public function checkout(Request $request)
{
    if(!auth()->user()) {
        return redirect()->route('login');
    }

    $user = auth()->user();
    $basketItems = Basket::where('user_id', $user->id)
                        ->with('product')
                        ->get();

    if($basketItems->isEmpty()) {
        return redirect()->route('products.basket')
            ->with('warning', 'Your basket is empty.');
    }

    $total = 0;
    foreach($basketItems as $item) {
        $total += $item->product->price * $item->quantity;
    }

    if($user->credit < $total) {
        return redirect()->route('products.basket')
            ->with('warning', 'Insufficient credit balance.');
    }

    DB::beginTransaction();
    try {
        // Deduct credit
        $user->decrement('credit', $total);

        // Create purchase records
        $orderId = 'ORD-' . strtoupper(uniqid());
        foreach($basketItems as $item) {
            DB::table('purchases')->insert([
                'user_id' => $user->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'total_price' => $item->product->price * $item->quantity,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Update product stock
            $item->product->decrement('stock', $item->quantity);
        }

        // Clear basket
        Basket::where('user_id', $user->id)->delete();

        // Send confirmation email if user has enabled order updates
        if($user->order_updates) {
            Mail::to($user->email)->send(new PurchaseConfirmation(
                $user,
                $basketItems->map(function($item) {
                    return (object)[
                        'name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price
                    ];
                }),
                $total,
                $orderId
            ));
        }

        DB::commit();
        return redirect()->route('purchase.history', $user->id)
            ->with('success', 'Purchase completed successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('products.basket')
            ->with('warning', 'An error occurred while processing your purchase. Please try again.');
    }
}

public function createNewRole()

    {
        if (!auth()->user() || !auth()->user()->hasPermissionTo('AddRole')) {
            abort(403, 'Unauthorized');
        }

        $permissions = Permission::orderBy('name')->get(); // Get all available permissions
        return view('AddRole', compact('permissions'));
    }

    
    public function storeNewRole(Request $request)
    {
        if (!auth()->user() || !auth()->user()->hasPermissionTo('AddRole')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array', // Permissions are optional
            'permissions.*' => 'exists:permissions,id' // Ensure submitted permission IDs exist
        ]);

        // Create the role (guard_name will default to 'web' or your default guard)
        $role = Role::create(['name' => $request->name]);

        // Assign permissions if any are selected
        if ($request->has('permissions') && !empty($request->permissions)) {
            // Ensure permissions are valid Permission model instances or their IDs/names
            $validPermissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($validPermissions);
        }

        // Redirect back to the create form with a success message,
        // or to another page like an admin dashboard.
        return redirect()->route('AddRole')
                         ->with('success', "Role '{$role->name}' created successfully!");
    }

    public function showForgotPasswordForm()
    {
        return view('users.forgot_password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $status = \Illuminate\Support\Facades\Password::sendResetLink(
            $request->only('email')
        );

        return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
                    ->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('users.reset_password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed'],//, Password::min(8)->numbers()->letters()->mixedCase()->symbols()
        ]);

        $status = \Illuminate\Support\Facades\Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        return $status === \Illuminate\Support\Facades\Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withInput($request->only('email'))
                    ->withErrors(['email' => __($status)]);
    }

















    public function showDefaultPermissionChange()
    {
        if (!auth()->check() || !auth()->user()->hasRole('Admin')) {
            abort(403, 'Unauthorized');
        }
        $roles = Role::all();
        $permissions = Permission::all();
        return view('Defultpermissionchange', compact('roles', 'permissions'));
    }

    public function updateDefaultPermissionChange(Request $request)
    {
        if (!auth()->check() || !auth()->user()->hasRole('Admin')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'array', // Each role's permissions is an array
        ]);
        $allRoles = Role::all();
        $inputPermissions = $request->permissions ?? [];
    
        foreach ($allRoles as $role) {
            $permissionIds = $inputPermissions[$role->id] ?? [];
            // Always get fresh permission names from the DB
            $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
            $role->syncPermissions($permissionNames);
            // Optionally, clear cache for the role
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        }
    
        return redirect()->route('Defultpermissionchange')->with('success', 'Default permissions updated successfully!');
    }

    public function refundOrder($orderId)
    {
        if (!auth()->user() || !auth()->user()->hasPermissionTo('manage_refunds')) {
            abort(403, 'Unauthorized');
        }
        $order = \App\Models\Order::with('items.product')->find($orderId);
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }
        if ($order->status === 'refunded' || $order->status === 'cancelled') {
            return redirect()->back()->with('warning', 'Order already refunded or cancelled.');
        }
        \DB::beginTransaction();
        try {
            // Refund credit to user
            \DB::table('users')->where('id', $order->user_id)->increment('credit', $order->total_price);
            // Restock all products
            foreach ($order->items as $item) {
                \DB::table('products')->where('id', $item->product_id)->increment('stock', $item->quantity);
            }
            // Mark order as refunded
            $order->status = 'refunded';
            $order->save();
            // Mark sale as refunded
            \DB::table('sales')->where('order_id', $order->id)->update(['status' => 'refunded', 'updated_at' => now()]);
            // Update profit for the order date
            $orderDate = $order->created_at ? $order->created_at->format('Y-m-d') : now()->format('Y-m-d');
            // Remove sale amount from sales table for that date
            $total_sales = \DB::table('sales')->where('date', $orderDate)->where('status', '!=', 'refunded')->sum('total_amount');
            $total_expenses = \DB::table('expenses')->where('date', $orderDate)->sum('amount');
            $net_profit = $total_sales - $total_expenses;
            $exists = \DB::table('profit')->where('date', $orderDate)->exists();
            if ($exists) {
                \DB::table('profit')->where('date', $orderDate)->update([
                    'total_sales' => $total_sales,
                    'total_expenses' => $total_expenses,
                    'net_profit' => $net_profit,
                    'updated_at' => now(),
                ]);
            } else {
                \DB::table('profit')->insert([
                    'date' => $orderDate,
                    'total_sales' => $total_sales,
                    'total_expenses' => $total_expenses,
                    'net_profit' => $net_profit,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            // Send refund email only if user has order_updates enabled
            if ($order->user->order_updates) {
                try {
                    $emailItems = $order->items->map(function($item) {
                        return (object) [
                            'name' => $item->product->name ?? 'N/A',
                            'quantity' => $item->quantity,
                            'price' => $item->unit_price,
                        ];
                    });
                    \Mail::to($order->user->email)->send(new \App\Mail\OrderRefunded(
                        $order->user,
                        $emailItems,
                        $order->total_price,
                        $order->order_number
                    ));
                } catch (\Exception $e) {
                    \Log::error('Refund email sending error: ' . $e->getMessage());
                }
            }
            \DB::commit();
            return redirect()->back()->with('success', 'Order refunded and products restocked.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Failed to refund order: ' . $e->getMessage());
        }
    }

    public function requestRefund(Request $request, $orderId)
    {
        $order = \App\Models\Order::with('user')->findOrFail($orderId);
        $user = auth()->user();
        if (!$user || $user->id !== $order->user_id || !$user->hasPermissionTo('request_refund')) {
            abort(403, 'Unauthorized');
        }
        if ($order->status === 'refunded' || $order->status === 'cancelled') {
            return redirect()->back()->with('warning', 'Order already refunded or cancelled.');
        }
        $pending = \DB::table('refund_requests')
            ->where('order_id', $order->id)
            ->where('status', 'pending')
            ->exists();
        if ($pending) {
            return redirect()->back()->with('warning', 'A refund request is already pending for this order.');
        }
        $request->validate([
            'reason' => 'nullable|string|max:1000',
        ]);
        \DB::table('refund_requests')->insert([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'reason' => $request->reason,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Generate a signed token for confirmation
        $token = \Str::random(48) . '-' . time();
        \Cache::put('refund_confirm_' . $order->id . '_' . $token, true, now()->addHours(6));
        // Send email to admin (use mail config or fallback)
        $adminEmail = config('mail.from.address') ?: 'yassinchinco@gmail.com';
        \Mail::to($adminEmail)->send(new \App\Mail\RefundRequestNotification($user, $order, $request->reason, $token));
        return redirect()->back()->with('success', 'Refund request submitted. Our team will review it soon.');
    }

    public function confirmRefund(Request $request, $orderId)
    {
        $order = \App\Models\Order::with('items.product', 'user')->findOrFail($orderId);
        $token = $request->query('token');
        if (!$token || !\Cache::pull('refund_confirm_' . $order->id . '_' . $token)) {
            return response('Invalid or expired confirmation link.', 403);
        }
        // Check for a pending refund request
        $refundRequest = \DB::table('refund_requests')
            ->where('order_id', $order->id)
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->first();
        if (!$refundRequest) {
            return response('No pending refund request found.', 404);
        }
        // Process the refund (reuse refundOrder logic)
        \DB::beginTransaction();
        try {
            \DB::table('users')->where('id', $order->user_id)->increment('credit', $order->total_price);
            foreach ($order->items as $item) {
                \DB::table('products')->where('id', $item->product_id)->increment('stock', $item->quantity);
            }
            $order->status = 'refunded';
            $order->save();
            \DB::table('sales')->where('order_id', $order->id)->update(['status' => 'refunded', 'updated_at' => now()]);
            $orderDate = $order->created_at ? $order->created_at->format('Y-m-d') : now()->format('Y-m-d');
            $total_sales = \DB::table('sales')->where('date', $orderDate)->where('status', '!=', 'refunded')->sum('total_amount');
            $total_expenses = \DB::table('expenses')->where('date', $orderDate)->sum('amount');
            $net_profit = $total_sales - $total_expenses;
            $exists = \DB::table('profit')->where('date', $orderDate)->exists();
            if ($exists) {
                \DB::table('profit')->where('date', $orderDate)->update([
                    'total_sales' => $total_sales,
                    'total_expenses' => $total_expenses,
                    'net_profit' => $net_profit,
                    'updated_at' => now(),
                ]);
            } else {
                \DB::table('profit')->insert([
                    'date' => $orderDate,
                    'total_sales' => $total_sales,
                    'total_expenses' => $total_expenses,
                    'net_profit' => $net_profit,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            // Mark refund request as completed
            \DB::table('refund_requests')->where('id', $refundRequest->id)->update([
                'status' => 'completed',
                'updated_at' => now(),
            ]);
            // Send refund email to user if enabled
            if ($order->user->order_updates) {
                try {
                    $emailItems = $order->items->map(function($item) {
                        return (object) [
                            'name' => $item->product->name ?? 'N/A',
                            'quantity' => $item->quantity,
                            'price' => $item->unit_price,
                        ];
                    });
                    \Mail::to($order->user->email)->send(new \App\Mail\OrderRefunded(
                        $order->user,
                        $emailItems,
                        $order->total_price,
                        $order->order_number
                    ));
                } catch (\Exception $e) {
                    \Log::error('Refund email sending error: ' . $e->getMessage());
                }
            }
            \DB::commit();
            return response('Refund processed successfully.', 200);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response('Failed to process refund: ' . $e->getMessage(), 500);
        }
    }

    public function redirectToGithub()
    {
        \Log::info('GitHub redirect method called');
        if (app()->environment('local')) {
            \Log::info('Local environment detected, disabling SSL verification');
            \Config::set('services.github.verify', false);
            \Config::set('services.github.guzzle', [
                'verify' => false
            ]);
        }
        try {
            return Socialite::driver('github')->redirect();
        } catch (\Exception $e) {
            \Log::error('GitHub redirect error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return redirect()->route('login')
                ->withErrors(['email' => 'GitHub login failed: ' . $e->getMessage()]);
        }
    }

    public function handleGithubCallback(Request $request)
    {
        try {
            if (app()->environment('local')) {
                \Config::set('services.github.verify', false);
                \Config::set('services.github.guzzle', [
                    'verify' => false
                ]);
            }

            $githubUser = Socialite::driver('github')->user();
            \Log::info('GitHub user data received', ['email' => $githubUser->email]);
            
            // First try to find a user with this GitHub ID
            $user = User::where('github_id', $githubUser->id)->first();
            
            if (!$user) {
                $user = User::where('email', $githubUser->email)->first();
                
                if ($user) {
                    \Log::info('Updating existing user with GitHub data');
                    $user->github_id = $githubUser->id;
                    $user->github_token = $githubUser->token;
                    $user->github_refresh_token = $githubUser->refreshToken;
                    $user->email_verified_at = now();
                    $user->save();
                } else {
                    \Log::info('Creating new user from GitHub data');
                    $user = User::create([
                        'github_id' => $githubUser->id,
                        'name' => $githubUser->name ?? $githubUser->nickname,
                        'email' => $githubUser->email,
                        'github_token' => $githubUser->token,
                        'github_refresh_token' => $githubUser->refreshToken,
                        'email_verified_at' => now(),
                        'password' => bcrypt(Str::random(16))
                    ]);
                    $user->assignRole('Customer');
                }
            }
            
            Auth::login($user);
            return redirect('/');
            
        } catch (\Exception $e) {
            \Log::error('GitHub login error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return redirect()->route('login')
                ->withErrors(['email' => 'GitHub login failed: ' . $e->getMessage()]);
        }
    }

}






