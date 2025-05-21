<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UsersController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::get('users', [UsersController::class, 'users']);
    Route::get('logout', [UsersController::class, 'logout']);
});
// Get users (protected by API auth)
// Route::get('/users', [UsersController::class, 'users'])->middleware('auth:api');

// // Logout route (protected by API auth)
// Route::get('/logout', [UsersController::class, 'logout'])->middleware('auth:api');