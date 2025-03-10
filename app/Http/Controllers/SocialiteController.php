<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialiteController extends Controller
{
    // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google callback
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        $this->registerOrLoginUser($user, 'google');
        return redirect()->route('dashboard');
    }

    // Redirect to Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Handle Facebook callback
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $this->registerOrLoginUser($user, 'facebook');
        return redirect()->route('dashboard');
    }

    // Register or login user
    protected function registerOrLoginUser($data, $provider)
    {
        // Check if the user already exists
        $user = User::where('email', $data->email)->first();

        if (!$user) {
            // Create a new user
            $user = User::create([
                'first_name' => $data->user['given_name'] ?? $data->name,
                'last_name' => $data->user['family_name'] ?? '',
                'email' => $data->email,
                'provider' => $provider,
                'provider_id' => $data->id,
                'password' => bcrypt(Str::random(16)), // Random password for SSO users
            ]);
        }

        // Log the user in
        Auth::login($user);

        // Log the login activity
        Log::info('User logged in via ' . $provider . ': ' . $user->email);
    }
}
