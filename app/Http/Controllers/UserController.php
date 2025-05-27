<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ...existing methods...

    public function register()
    {
        return view('users.register');
    }

    public function do_register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'message' => 'User already logged out or does not exist'
            ], 200);
        }

        // If using API token (Passport)
        if (method_exists($user, 'token')) {
            $token = $user->token();
            if ($token) {
                $token->revoke();
                return response()->json([
                    'message' => 'Successfully logged out (API)'
                ]);
            }
        }

        // If using web session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Successfully logged out (web)'
        ]);
    }

    // ...existing methods...
}