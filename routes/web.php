<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Auth\FacebookController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\FinancialsController;
use App\Http\Controllers\Auth\SocialAuthController;


Route::get('/', function () {
    if (auth()->check()) {
        $roles = auth()->user()->getRoleNames()->toArray();
        if (in_array('Admin', $roles) || in_array('Manager', $roles)) {
            return redirect()->route('dashboard');
        }
    }
    $email = emailFromLoginCertificate();
    if($email && !auth()->user()) {
        $user = User::where('email', $email)->first();
        if($user) Auth::login($user);
    }
    return view('home');
})->name('home');



Route::get('roles', [UsersController::class, 'createNewRole'])->name('AddRole');
Route::post('roles', [UsersController::class, 'storeNewRole'])->name('AddRole');


Route::get('defult-permission-change', [UsersController::class, 'showDefaultPermissionChange'])->name('Defultpermissionchange');
Route::post('defult-permission-change', [UsersController::class, 'updateDefaultPermissionChange'])->name('Defultpermissionchange.update');


/*






|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('login', [UsersController::class, 'login'])->name('login');

Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::post('logout', [UsersController::class, 'doLogout'])->name('do_logout');
Route::get('verify', [UsersController::class, 'verify'])->name('verify');
Route::get('/email/resend', [UsersController::class, 'resendVerification'])->name('resend.verification');

// Social Authentication
Route::get('/auth/google',
[UsersController::class, 'redirectToGoogle'])
->name('login_with_google');
Route::get('/auth/google/callback',
[UsersController::class, 'handleGoogleCallback']);

// GitHub Authentication (specific routes)
Route::get('/auth/github', [UsersController::class, 'redirectToGithub'])
    ->name('login_with_github');
Route::get('/auth/github/callback', [UsersController::class, 'handleGithubCallback']);

// Social Media Authentication Routes (for other providers)
Route::get('auth/{provider}/redirect', [SocialAuthController::class, 'redirectToProvider'])
    ->name('social.redirect')
    ->where('provider', '^(?!github$|google$).*$');
Route::get('auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])
    ->name('social.callback')
    ->where('provider', '^(?!github$|google$).*$');

/*
|--------------------------------------------------------------------------
| Registration Routes
|--------------------------------------------------------------------------
*/
Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do-register');
Route::get('/register', [UsersController::class, 'register'])->name('register');
Route::post('/register', [UsersController::class, 'doRegister'])->name('do_register');
/*
|--------------------------------------------------------------------------
| User Management Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // User Profile
    Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
    Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
    Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
    Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
    Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');
    
    // User Settings
    Route::get('/settings', [UsersController::class, 'settings'])->name('settings');
    Route::post('/settings/update', [UsersController::class, 'updateSettings'])->name('settings.update');
    
    // User Management (Admin)
    Route::get('users', [UsersController::class, 'list'])->name('users');
    Route::get('users/create', [UsersController::class, 'create'])->name('users_create');
    Route::post('users/store', [UsersController::class, 'store'])->name('users_store');
    Route::delete('/users/{user}', [UsersController::class, 'delete'])->name('users_delete');
    Route::post('users/unblockUser/{user}', [UsersController::class, 'unblockUser'])->name('unblockUser');
    Route::post('users/reset-credit/{user}', [UsersController::class, 'resetCredit'])->name('users.reset_credit');
    
    // Purchase History
    Route::get('/users/{user}/purchase-history', [UsersController::class, 'purchaseHistory'])->name('purchase_history');
    Route::post('/purchases/{purchase}/refund', [UsersController::class, 'refundPurchase'])->name('purchase.refund');
});

/*
|--------------------------------------------------------------------------
| Product Management Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Product CRUD
    Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
    Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
    Route::delete('/products/{product}', [ProductsController::class, 'delete'])->name('products_delete');
    Route::post('/products/{product}/stock', [ProductsController::class, 'addstock'])->name('products.addstock');
    
    // Product Favorites
    Route::patch('/products/{id}/mark-favorite', [ProductsController::class, 'markAsFavorite'])->name('products.markAsFavorite');
    Route::get('/fav', [ProductsController::class, 'showFavourites'])->name('fav');
    
    // Shopping Cart
    Route::post('/products/{product}/addTobasket', [ProductsController::class, 'addToBasket'])->name('products.addTobasket');
    Route::get('/basket', [ProductsController::class, 'basket'])->name('products.basket');
    Route::delete('/basket/{basket}', [ProductsController::class, 'removeFromBasket'])->name('products.removeFromBasket');
    
    // Checkout & Purchase
    Route::post('/checkout', [ProductsController::class, 'checkout'])->name('products.checkout');
    Route::post('/products/{product}/buy', [ProductsController::class, 'buy'])->name('products.buy');
    Route::post('users/purchase/{user}', [UsersController::class, 'purchase'])->name('usersPurchase');
});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
// Home & About
Route::get('/about', function () {
    // If not logged in, allow (guest)
    if (!auth()->check()) {
        return view('about');
    }
    // If Customer or Employee, allow
    $roles = auth()->user()->getRoleNames()->toArray();
    if (in_array('Customer', $roles) || in_array('Employee', $roles)) {
        return view('about');
    }
    // Otherwise, block
    abort(403, 'Unauthorized');
})->name('about');

// Public Product List
Route::get('products', [ProductsController::class, 'list'])->name('products_list');

/*
|--------------------------------------------------------------------------
| Development Routes (Remove in Production)
|--------------------------------------------------------------------------
*/
// Route::get('/', [App\Http\Controllers\Web\ProductsController::class, 'index'])->name('home');

// Route::get('/register', [App\Http\Controllers\Web\UsersController::class, 'doregister'])->name('register');




Route::get('/cryptography', function (Request $request) {
    $data = $request->data??"Welcome to Cryptography";
    $action = $request->action??"Encrypt";
    $result = $request->result??"";
    $status = "Failed";
    if($request->action=="Encrypt") {
        $temp = openssl_encrypt($request->data, 'aes-128-ecb', 'thisisasecretkey', OPENSSL_RAW_DATA, '');
        if($temp) {
        $status = 'Encrypted Successfully';
        $result = base64_encode($temp);
        }
        
    }
    else if($request->action=="Decrypt") {
        $temp = base64_decode($request->data);
        $result = openssl_decrypt($temp, 'aes-128-ecb', 'thisisasecretkey', OPENSSL_RAW_DATA, '');
        if($result) $status = 'Decrypted Successfully';
        }

    else if($request->action=="Hash") {
            $temp = hash('sha256', $request->data);
            $result = base64_encode($temp);
            $status = 'Hashed Successfully';
            }

    else if($request->action=="Sign") {
                $path = storage_path('app/private/seifwaheed559@gmail.com.pfx');
                $password = 'kalikali';
                $certificates = [];
                $pfx = file_get_contents($path);
                openssl_pkcs12_read($pfx, $certificates, $password);
                $privateKey = $certificates['pkey'];
                $signature = '';
                if(openssl_sign($request->data, $signature, $privateKey, 'sha256')) {
                $result = base64_encode($signature);
                $status = 'Signed Successfully';
                }
               }
    else if($request->action=="Verify") {
                $signature = base64_decode($request->result);
                $path = storage_path('app/public/seifwaheed559@gmail.com.crt');
                $publicKey = file_get_contents($path);
                if(openssl_verify($request->data, $signature, $publicKey, 'sha256')) {
                    $status = 'Verified Successfully';
                }
            }
           
    return view('cryptography', compact('data', 'result', 'action', 'status'));
   })->name('cryptography');
   
// Password Reset Routes
Route::get('forgot-password', [UsersController::class, 'showForgotPasswordForm'])
    ->name('password.request');
Route::post('forgot-password', [UsersController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::get('reset-password/{token}', [UsersController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('reset-password', [UsersController::class, 'reset'])
    ->name('password.update');
   
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'getMonthlyStats'])->name('dashboard.data');
    Route::get('/manage-financials', [FinancialsController::class, 'index'])->name('manage.financials');
    Route::post('/manage-financials/sales', [FinancialsController::class, 'storeSale'])->name('manage.financials.sales.store');
    Route::put('/manage-financials/sales/{id}', [FinancialsController::class, 'updateSale'])->name('manage.financials.sales.update');
    Route::delete('/manage-financials/sales/{id}', [FinancialsController::class, 'deleteSale'])->name('manage.financials.sales.delete');
    Route::post('/manage-financials/expenses', [FinancialsController::class, 'storeExpense'])->name('manage.financials.expenses.store');
    Route::put('/manage-financials/expenses/{id}', [FinancialsController::class, 'updateExpense'])->name('manage.financials.expenses.update');
    Route::delete('/manage-financials/expenses/{id}', [FinancialsController::class, 'deleteExpense'])->name('manage.financials.expenses.delete');
    Route::post('/manage-financials/profit', [FinancialsController::class, 'storeProfit'])->name('manage.financials.profit.store');
    Route::put('/manage-financials/profit/{id}', [FinancialsController::class, 'updateProfit'])->name('manage.financials.profit.update');
    Route::delete('/manage-financials/profit/{id}', [FinancialsController::class, 'deleteProfit'])->name('manage.financials.profit.delete');
    Route::get('/manage-financials/sales/{id}', [FinancialsController::class, 'showSale'])->name('manage.financials.sales.show');
    Route::get('/manage-financials/expenses/{id}', [FinancialsController::class, 'showExpense'])->name('manage.financials.expenses.show');
    Route::get('/manage-financials/sales/{id}/edit', [FinancialsController::class, 'editSale'])->name('manage.financials.sales.edit');
    Route::get('/manage-financials/expenses/{id}/edit', [FinancialsController::class, 'editExpense'])->name('manage.financials.expenses.edit');
});
   
Route::get('/orders/{order}/details', [UsersController::class, 'orderDetails'])->name('order.details');
Route::post('/orders/{order}/refund', [UsersController::class, 'refundOrder'])->name('order.refund');
Route::post('/orders/{order}/request-refund', [UsersController::class, 'requestRefund'])->name('order.requestRefund');
Route::get('/orders/{order}/confirm-refund', [UsersController::class, 'confirmRefund'])->name('order.confirmRefund');
   
// Terms and Privacy
Route::get('/terms', function () {
    return view('legal.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('legal.privacy');
})->name('privacy');
   