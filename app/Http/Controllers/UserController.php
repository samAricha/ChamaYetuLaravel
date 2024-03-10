<?php

namespace App\Http\Controllers;

use App\Models\ChamaMembers;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    use HttpResponses;


    public function index()
    {
        // Fetch the roles of the authenticated user
        $userRoles = Auth::user()->roles->pluck('name')->toArray();
        // Check if the user has the 'admin' role
        $isAdmin = in_array('admin', $userRoles);
        if (!$isAdmin){
            return $this->error(
                "user Unauthenticated",
                'Error Getting Users',
                ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        // Access user's name and ID
        $userName = Auth::user()->name;
        $userId = Auth::id();

        // Access user's roles
        $userRoles = Auth::user()->roles;

//        return $userId;

        try {
            $users =  User::all();

            return $this->success(
                $users,
                'Users successfully fetched',
                ResponseAlias::HTTP_OK
            );


        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error fetching Users',
                ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show($id)
    {

    }

    public function store(Request $request)
    {
        try {
            // Fetch the roles of the authenticated user
            $userRoles = Auth::user()->roles->pluck('name')->toArray();
            // Check if the user has the 'admin' role
            $isAdmin = in_array('admin', $userRoles);
            if (!$isAdmin){
                return $this->error(
                    "user Unauthenticated",
                    'Error Creating User',
                    ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
                );
            }
            $requestData = $request->all();
            $chamaaId = $requestData['chamaaId'];

            // Check if a user with the provided phone number already exists
            $existingUser = User::where('phone', $requestData['phone'])->first();


            // If a user with the phone number exists, use their ID for the member
            if ($existingUser) {
                $userId = $existingUser->id;

                return $this->success(
                    $existingUser,
                    'User Already exists',
                    ResponseAlias::HTTP_OK
                );
            } else {
                // If the user doesn't exist, create a new user
                $user = User::create([
                    'name' => $requestData['name'],
                    'email' => $requestData['email'],
                    'phone' => $requestData['phone'],
                    'password' => Hash::make($requestData['password']),
                ]);
                $user->assignRole('manager');

                return $this->success(
                    $user,
                    'System Admin successfully created',
                    ResponseAlias::HTTP_OK
                );
            }

        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error Creating User',
                ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
