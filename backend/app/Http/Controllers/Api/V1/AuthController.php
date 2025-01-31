<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Nette\Schema\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect']
            ]);
        }

        if(!Hash::check($request->password, $user->password)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect']
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function register(Request $request)
    {
        $request->merge([
            'password_confirmation' => $request->passwordConfirmation ?? null,
        ]);

        $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'phoneNb' => 'nullable|string|max:17',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'message' => 'A user with this email already exists'
            ], 409);
        }
        $user = User::create([
            'firstname' => $request->firstName,
            'lastname' => $request->lastName,
            'phone_nb' => $request->phoneNb ?? null,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user->only(['id', 'name', 'email']),
        ], 201);
    }
}