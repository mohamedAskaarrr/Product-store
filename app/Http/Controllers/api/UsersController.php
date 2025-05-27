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
use Illuminate\Support\Facades\Hash;

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
    use ValidatesRequests;

    /**
     * Handle user registration
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('app');

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token->accessToken,
            'user' => $user->getAttributes()
        ], 201);
    }

    public function login(Request $request)
    {
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => 'Invalid login info.'], 401);
        }

        $user = User::where('email', $request->email)
            ->select('id', 'name', 'email')->first();

        $token = $user->createToken('app');

        return response()->json(['token'=>$token->accessToken , 'user' => $user->getAttributes()]);
    }

    /**
     * Get list of users
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function users(Request $request)
    {
        $users = User::select('id', 'name', 'email')->get()->toArray();
        return response()->json(['users' => $users]);
    }

    /**
     * Handle user logout
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Delete a user account
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $id)
    {
        // Check if user exists
        $userToDelete = User::find($id);
        if (!$userToDelete) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Get the authenticated user
        $currentUser = $request->user();

        // Check if user is trying to delete themselves
        $isSelfDeletion = $currentUser->id === $userToDelete->id;

        // If not self-deletion, check if user has admin role
        if (!$isSelfDeletion && !$currentUser->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            DB::beginTransaction();

            // Revoke all tokens for the user being deleted
            $userToDelete->tokens()->delete();

            // If it's self-deletion, also revoke the current token
            if ($isSelfDeletion) {
                $currentUser->tokens()->delete();
            }

            // Delete the user
            $userToDelete->delete();

            DB::commit();

            return response()->json([
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User deletion failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete user'], 500);
        }
    }
}

