<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;

// Remove this duplicate route:
// Route::get('/users', function(Request $request){
//     return $request->user();
// })->middleware('auth:api');

Route::post('/login', [UsersController::class, 'login']);
Route::get('/users', [UsersController::class, 'users']); // Keep this one
Route::get('/logout', [UsersController::class, 'logout']); // Keep this one
