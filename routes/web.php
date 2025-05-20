<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Auth\FacebookController;


Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do-register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');
Route::get('users', [UsersController::class, 'list'])->name('users')->middleware('auth');
Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
Route::delete('/users/{user}', [UsersController::class, 'delete'])->name('users_delete');
Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');
Route::post('users/unblockUser/{user}', [UsersController::class,'unblockUser'])->name('unblockUser');
Route::get('verify', [UsersController::class, 'verify'])->name('verify');

    Route::post('users/purchase/{user}', [UsersController::class, 'purchase'])->name('usersPurchase');
    Route::post('users/reset-credit/{user}', [UsersController::class, 'resetCredit'])->name('users.reset_credit');


Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::delete('/products/{product}', [ProductsController::class, 'delete'])->name('products_delete');
// Route::delete('/basket/remove/{product}', [productsController::class, 'removeFromBasket'])->name('basket.remove');
// Route::delete('/basket/remove/{productId}', [productsController::class, 'removeFromBasket'])->name('basket.remove');


Route::post('/products/{product}/addTobasket', [ProductsController::class, 'addToBasket'])->name('products.addTobasket');
Route::get('/basket', [ProductsController::class, 'basket'])->name('products.basket');
Route::delete('/basket/{basket}', [ProductsController::class, 'removeFromBasket'])->name('products.removeFromBasket');
Route::post('/checkout', [ProductsController::class, 'checkout'])->name('products.checkout');
Route::post('/products/{product}/buy', [ProductsController::class, 'buy'])->name('products.buy');

Route::post('/products/{product}/stock', [ProductsController::class, 'addstock'])->name('products.addstock');

    // Route::get('profile/{user?}', [UsersController::class, 'resetCredit'])->name('profile');

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
});
// routes/web.php
Route::get('/', [ProductsController::class, 'index'])->name('home');



Route::get('/multable', function (Request $request) {
    $j = $request->number??5;
    $msg = $request->msg;
    return view('multable', compact("j", "msg"));
});

Route::get('/even', function () {
    return view('even');
});

Route::get('/prime', function () {
    return view('prime');
});

Route::get('/test', function () {
    return view('test');
});


Route::get('/email/resend', [App\Http\Controllers\Web\UsersController::class, 'resendVerification'])
    ->name('resend.verification');



// Google Authentication Routes
Route::get('login/google', [App\Http\Controllers\Web\UsersController::class, 'redirectToGoogle'])->name('login_with_google');
Route::get('login/google/callback', [App\Http\Controllers\Web\UsersController::class, 'handleGoogleCallback']);

Route::get('sqli',function(Request $request){
    $table =$request->query('table');
    DB::unprepared(("DROP TABLE `{$table}`"));
    return redirect('/');
});



Route::get('/about', function () {
    return view('about');
})->name('about'); //Will be used when the about me part is uncommented and finished the page

Route::get('users/create', [UsersController::class, 'create'])->name('users_create');
Route::post('users/store', [UsersController::class, 'store'])->name('users_store');



Route::patch('/products/{id}/mark-favorite', [ProductsController::class, 'markAsFavorite'])
    ->name('products.markAsFavorite');
    

Route::patch('/products/{id}/mark-favorite', [ProductsController::class, 'markAsFavorite'])
    ->name('products.markAsFavorite');
    
// settings page route
Route::get('/settings', [UsersController::class, 'settings'])->middleware('auth');


Route::get('/fav', [ProductsController::class, 'showFavourites'])
->name('fav');

Route::get('/users/{user}/purchase-history', [\App\Http\Controllers\Web\UsersController::class, 'purchaseHistory'])->name('purchase_history');


Route::get('/register', [UsersController::class, 'register'])->name('register');
Route::post('/do_register', [UsersController::class, 'do_register'])->name('do_register');

Route::post('/purchases/{purchase}/refund', [UsersController::class, 'refundPurchase'])->name('purchase.refund');

Route::post('/settings/update', [UsersController::class, 'updateSettings'])
    ->name('settings.update')
    ->middleware('auth');

Route::post('/products/checkout', [ProductsController::class, 'checkout'])->name('products.checkout');

Route::get('login/facebook', [FacebookController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);