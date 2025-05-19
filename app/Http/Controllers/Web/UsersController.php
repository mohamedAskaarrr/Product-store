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
          
        if(!auth()->user()->hasPermissionTo('show_users'))abort(401);

        $query = User::query();
        if (auth()->user()->hasRole('Employee')){
            $query->role('Customer');
        }
        
        if(!auth()->user()->hasPermissionTo('show_users'))abort(401);
        $query = User::select('*');
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
   
        $user = $user??auth()->user();
        if(auth()->id()!=$user?->id) {
            if(!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }
    
        $roles = [];
        foreach(Role::all() as $role) {
            $role->taken = ($user->hasRole($role->name));
            $roles[] = $role;
        }

        $permissions = [];
        $directPermissionsIds = $user->permissions()->pluck('id')->toArray();
        foreach(Permission::all() as $permission) {
            $permission->taken = in_array($permission->id, $directPermissionsIds);
            $permissions[] = $permission;
        }      

        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function save(Request $request, User $user) {
        // Add this debug code
        \Log::info('Roles being assigned: ' . json_encode($request->roles));
        
        if(auth()->id()!=$user->id) {
            if(!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $user->name = $request->name;
        $user->save();
        $user->credit += $request->credit;
        $user->save();

        if(auth()->user()->hasPermissionTo('show_users')) {
            $user->syncRoles($request->roles);
            $user->syncPermissions($request->permissions);

            Artisan::call('cache:clear');
        }

        return redirect(route('profile', ['user'=>$user->id]));
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












public function addCredit(Request $request, User $user)
{
    // Check if the authenticated user has the 'Employee' or 'Admin' role
    if (!auth()->user()->hasRole('Employee') && !auth()->user()->hasRole('Admin')) {
        return response()->json([
            'success' => false,
            'message' => 'You do not have permission to add credit to this user.'
        ], 403); // 403 Forbidden
    }

    // Validate the request to ensure 'credit' is a positive numeric value
    $request->validate([
        'credit' => 'required|numeric|gt:0' // Credit must be greater than 0
    ]);

    // Ensure the user has a valid credit value (set default to 0 if null)
    $user->credit = $user->credit ?? 0;

    // Add the new credit to the existing credit balance
    $user->credit += $request->credit;

    // Save the updated credit balance
    if ($user->save()) {
        // Return a success response with the updated credit balance
        return response()->json([
            'success' => true,
            'message' => 'Credit added successfully!',
            'new_credit' => $user->credit
        ]);
    }


    return response()->json([
        'success' => false,
        'message' => 'Failed to update credit.'
    ]);


    $user = User::where('email', $request->email)->first();

    if ($user && $user->is_blocked) {
        return back()->withErrors(['email' => 'Your account is blocked. Please contact an employee.']);
    }
    
    if (!Auth::attempt($credentials)) {
        if ($user) {
            $user->increment('login_attempts');
            if ($user->login_attempts >= 5) {
                $user->is_blocked = true;
                $user->save();
            }
        }
    
        return back()->withErrors(['email' => 'Invalid credentials.']);
    }
    
    // If login is successful:
    $user->login_attempts = 0; // reset attempts
    $user->save();
    



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
         
         // First try to find a user with this Google ID
         $user = User::where('google_id', $googleUser->id)->first();
         
         // If not found by Google ID, try to find by email
         if (!$user) {
             $user = User::where('email', $googleUser->email)->first();
             
             // If user exists but doesn't have Google ID, update it
             if ($user) {
                 $user->google_id = $googleUser->id;
                 $user->google_token = $googleUser->token;
                 $user->google_refresh_token = $googleUser->refreshToken;
                 $user->email_verified_at = now(); // Mark email as verified
                 $user->save();
             } else {
                 // Create a new user if none exists with this email
                 $user = User::create([
                     'google_id' => $googleUser->id,
                     'name' => $googleUser->name,
                     'email' => $googleUser->email,
                     'google_token' => $googleUser->token,
                     'google_refresh_token' => $googleUser->refreshToken,
                     'email_verified_at' => now(), // Mark email as verified
                     'password' => bcrypt(Str::random(16)) // Generate a random password
                 ]);
                 
                 // Assign the Customer role to the new user
                 $user->assignRole('Customer');
             }
         } else {
             // Update existing Google user with latest token info
             $user->google_token = $googleUser->token;
             $user->google_refresh_token = $googleUser->refreshToken;
             $user->save();
         }
         
        // Clear any existing session before logging in
        Auth::logout();
        
        // Log in the user 
        Auth::login($user);
    
        return redirect('/');
  }
  catch(\Exception $e) {
      // Log the error for debugging
      \Log::error('Google login error: ' . $e->getMessage());
      
      // Redirect to login page with error message
      return redirect()->route('login')->withErrors(['email' => 'Google login failed. Please try again.']);
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
        $user->syncRoles($request->roles);
    }

    if($request->has('permissions')) {
        $user->syncPermissions($request->permissions);
    }

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

// View product details
public function show(Product $product)
{
    return view('products.show', compact('product'));
}

// View purchase history
public function purchaseHistory()
{
    if(!auth()->user()) {
        return redirect()->route('login');
    }
    
    $purchases = DB::table('purchases')
        ->join('products', 'purchases.product_id', '=', 'products.id')
        ->where('purchases.user_id', auth()->id())
        ->select('purchases.*', 'products.name', 'products.photo')
        ->get();
        
    return view('products.purchase-history', compact('purchases'));
}

// Process purchase
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
        // Deduct user credit
        auth()->user()->decrement('credit', $totalPrice);
        
        // Reduce product stock
        $product->decrement('stock', $request->quantity);
        
        // Create purchase record
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

// Remove from basket
public function removeFromBasket(Product $product)
{
    $user = Auth::user();
    if (!$user) {
        return redirect()->route('login');
    }
    
    Basket::where('user_id', $user->id)
          ->where('product_id', $product->id)
          ->delete();
          
    return redirect()->route('products.basket')->with('success', 'Product removed from basket');
}

// Update basket quantity
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

// Advanced search
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

// Featured products
public function featured()
{
    $products = Product::where('featured', true)->get();
    return view('products.featured', compact('products'));
}

// Add review
public function addReview(Request $request, Product $product)
{
    if(!auth()->user()) {
        return redirect()->route('login');
    }
    
    $request->validate([
        'rating' => 'required|numeric|min:1|max:5',
        'comment' => 'required|string|max:1000'
    ]);
    
    // Note: You'll need to create a reviews table in the database
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
}
