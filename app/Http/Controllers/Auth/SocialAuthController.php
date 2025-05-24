<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            \Log::info("{$provider} user data received", ['email' => $socialUser->email]);

            // Find or create user
            $user = $this->findOrCreateUser($socialUser, $provider);

            // Log the user in
            Auth::login($user);

            return redirect('/')->with('success', 'Successfully logged in with ' . ucfirst($provider));
        } catch (Exception $e) {
            \Log::error("{$provider} login error: " . $e->getMessage());
            return redirect()->route('login')
                ->withErrors(['error' => "Failed to login with {$provider}. Please try again."]);
        }
    }

    protected function findOrCreateUser($socialUser, $provider)
    {
        // First try to find user by provider ID
        $user = User::where("{$provider}_id", $socialUser->id)->first();

        if (!$user) {
            // Then try to find by email
            $user = User::where('email', $socialUser->email)->first();

            if ($user) {
                // Update existing user with provider data
                $user->update([
                    "{$provider}_id" => $socialUser->id,
                    "{$provider}_token" => $socialUser->token,
                    "{$provider}_refresh_token" => $socialUser->refreshToken,
                    'email_verified_at' => now(),
                ]);
            } else {
                // Create new user
                $user = User::create([
                    "{$provider}_id" => $socialUser->id,
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    "{$provider}_token" => $socialUser->token,
                    "{$provider}_refresh_token" => $socialUser->refreshToken,
                    'email_verified_at' => now(),
                    'password' => bcrypt(Str::random(16))
                ]);
                $user->assignRole('Customer');
            }
        }

        return $user;
    }
} 