<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Password as PasswordFacade;
use Illuminate\Support\Str;

use App\Mail\VerificationEmail;
use App\Mail\PurchaseConfirmation;
use App\Mail\RefundRequestNotification;
use App\Mail\OrderRefunded;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Basket;
use App\Models\Order;

use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;

class UsersController extends Controller
{

    public function login(Request $request)
    {
        // if (!Auth::attempt($request->only('email', 'password'))) {
        //     return response()->json(['error' => 'Invalid credentials'], 401);
        // }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('API Token')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user->only('id', 'name', 'email')
        ]);
    }

    public function users(Request $request)
    {
        return response()->json([
            'users' => User::select('id', 'name', 'email')->get()
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logged out']);
    }
}

