<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ApiAuthController extends Controller
{
    use HttpResponses;



    public function register(RegisterUserRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $validated = $request->validate([
                'email' => ['required'],
                'name' => ['required'],
                'phone' => ['required'],
            ]);
            // Check for duplicate phone
            if (User::where('phone', $validatedData['phone'])->exists()) {
                return $this->error(
                    null,
                    'The phone has already been taken.',
                    422
                );
            }

            // Check for duplicate email
            if (User::where('email', $validatedData['email'])->exists()) {
                return $this->error(
                    null,
                    'The email has already been taken.',
                    422
                );
            }


            // Create a new user
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'password' => Hash::make($validatedData['password']),
            ]);
            $user->assignRole('user');

            // Return success response
            return $this->success([
                'user' => $user,
                'access_token' => $user->createToken('API Token')->plainTextToken
            ]);


        } catch (\Exception $e) {
            return $this->error(
                null,
                $e->getMessage(),
                Response::HTTP_OK,
                'Error creating user',
            );
        }
    }



    public function login(LoginUserRequest $request)
    {
        try {
            $validatedData = $request->validated();


            $validated = $request->validate([
                'password' => ['required'],
                'username' => ['required'],
            ]);

            $user = null;


            // Check if the input is a phone number
            if ($this->isPhoneNumber($validatedData['username'])) {
                // Normalize the phone number (remove country code, format, etc.)
                $normalizedPhone = $this->normalizePhoneNumber($validatedData['username']);
                // Search for the user by normalized phone number
                $user = User::with('roles')->where('phone', $normalizedPhone)->first();
            } else {
                // Search for the user by email
                $user = User::with('roles')->where('email', $validatedData['username'])->first();
            }

            if (!$user) {
                return $this->error('User not found.', 'Login failed', 404);
            }


            if (!$user || !Auth::attempt(['email' => $user->email, 'password' => $validatedData['password']])) {
                return $this->error('', 'Credentials do not match', 401);
            }

            return $this->success([
                'user' => $user,
                'access_token' => $user->createToken('API Token')->plainTextToken
            ]);


        } catch (\Exception $e) {
            return $this->error(
                null,
                $e->getMessage(),
                $e->getCode(),
                'Error login in',
            );
        }

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
