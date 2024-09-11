<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import the User model
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login function for authenticating a user and returning an API token.
     */
    public function login(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to authenticate the user using the provided email and password
        if (Auth::attempt($request->only('email', 'password'))) {
            // Retrieve the authenticated user
            $user = Auth::user();
            
            // Generate a new API token for the user
            $token = $user->createToken('API Token')->plainTextToken;

            // Return success response with the generated token and user details
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token
            ], 200);
        }

        // Return error response if authentication fails
        return response()->json([
            'message' => 'Invalid email or password'
        ], 401);
    }

    /**
     * Register function for creating a new user account.
     */
    public function register(Request $request)
    {
        // Validate registration input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Generate API token for the newly registered user
        $token = $user->createToken('API Token')->plainTextToken;

        // Return the token and user information
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    /**
     * Logout function to revoke the user's current token.
     */
    public function logout(Request $request)
    {
        // Revoke the user's token
        $request->user()->currentAccessToken()->delete();

        // Return response
        return response()->json([
            'message' => 'Logged out successfully'
        ], 200);
    }
}
