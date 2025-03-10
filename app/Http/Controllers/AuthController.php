<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login request
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($request->only('email', 'password'))) {
            // Log the login activity
            Log::info('User logged in: ' . Auth::user()->email);

            // Return JSON response for AJAX
            return response()->json([
                'success' => true,
                'redirect' => route('dashboard'),
            ]);
        }

        // Return error response for failed login
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials',
        ], 401);
    }
}
