<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            \Log::info('Facebook user data received', ['email' => $facebookUser->email]);
            
            // First try to find a user with this Facebook ID
            $user = User::where('facebook_id', $facebookUser->id)->first();
            
            if (!$user) {
                $user = User::where('email', $facebookUser->email)->first();
                
                if ($user) {
                    \Log::info('Updating existing user with Facebook data');
                    $user->facebook_id = $facebookUser->id;
                    $user->email_verified_at = now();
                    $user->save();
                } else {
                    \Log::info('Creating new user from Facebook data');
                    $user = User::create([
                        'facebook_id' => $facebookUser->id,
                        'name' => $facebookUser->name,
                        'email' => $facebookUser->email,
                        'email_verified_at' => now(),
                        'password' => bcrypt(Str::random(16))
                    ]);
                    $user->assignRole('Customer');
                }
            }
            
            Auth::login($user);
            return redirect('/');
            
        } catch (\Exception $e) {
            \Log::error('Facebook login error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return redirect()->route('login')
                ->withErrors(['email' => 'Facebook login failed: ' . $e->getMessage()]);
        }
    }
} 