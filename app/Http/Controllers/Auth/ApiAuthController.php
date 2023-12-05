<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    use HttpResponses;



    public function register(RegisterUserRequest $request)
    {
        $validatedData = $request->validated();
        // Check for duplicate phone
        if (User::where('phone', $request['phone'])->exists()) {
            return $this->error([
                'message' => 'The phone has already been taken.',
                'errors' => [
                    'phone' => ['The phone has already been taken.']
                ]
            ], 'Registration failed', 422);
        }

        // Check for duplicate email
        if (User::where('email', $request['email'])->exists()) {
            return $this->error([
                'message' => 'The email has already been taken.',
                'email' => ['The email has already been taken.']
            ], 'Registration failed', 422);
        }




        // Create a new user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Return success response
        return $this->success([
            'user' => $user,
            'access_token' => $user->createToken('API Token')->plainTextToken
        ]);
    }



    public function login(LoginUserRequest $request)
    {
        $validatedData = $request->validated();

        // Check if the input is a phone number
        if ($this->isPhoneNumber($validatedData['username'])) {
            // Normalize the phone number (remove country code, format, etc.)
            $normalizedPhone = $this->normalizePhoneNumber($validatedData['username']);
            // Search for the user by normalized phone number
            $user = User::where('phone', $normalizedPhone)->first();
        } else {
            // Search for the user by email
            $user = User::where('email', $validatedData['username'])->first();
        }


        if (!$user || !Auth::attempt(['email' => $user->email, 'password' => $validatedData['password']])) {
            return $this->error('', 'Credentials do not match', 401);
        }

        return $this->success([
            'user' => $user,
            'access_token' => $user->createToken('API Token')->plainTextToken
        ]);
    }

    function isPhoneNumber($value)
    {
        // Check if $value is a valid numeric string
        return ctype_digit($value);
    }
    function normalizePhoneNumber($phoneNumber)
    {
        // Extract the last nine digits
        $lastNineDigits = substr($phoneNumber, -9);

        // Add "254" prefix
        $normalizedPhoneNumber = '254' . $lastNineDigits;

        return $normalizedPhoneNumber;
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->success([
            'message' => 'You have succesfully been logged out and your token has been removed'
        ]);
    }

    public function me(Request $request)
    {
        return $request->user();
    }

}
