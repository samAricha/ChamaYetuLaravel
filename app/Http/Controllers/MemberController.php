<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    use HttpResponses;

    public function createMember(Request $request)
    {
        $requestData = $request->all();

        // Check if a user with the provided phone number already exists
        $existingUser = User::where('phone', $requestData['phone'])->first();

        // If a user with the phone number exists, use their ID for the member
        if ($existingUser) {
            $userId = $existingUser->id;
        } else {
            // If the user doesn't exist, create a new user
            $user = User::create([
                'name' => $requestData['name'],
                'email' => $requestData['email'],
                'phone' => $requestData['phone'],
                'password' => Hash::make($requestData['password']),
            ]);
            $user->assignRole('user');

            $userId = $user->id;
        }

        $member = new Member();
        $member->user_id = $userId;
        $member->first_name = $requestData['firstName'];
        $member->last_name = $requestData['lastName'];
        $member->phone = $requestData['phone'];
        $member->date_joined = $requestData['dateJoined'];
        $member->save();

        if ($member->save()) {
            // Member creation successful
            return response()->json([
                'success' => true,
                'message' => 'Member created successfully'
            ]);
        } else {
            // Member creation failed
            return response()->json([
                'success' => false,
                'message' => 'Failed to create member'
            ]);
        }
    }


    public function index()
    {

//        // Access user's name and ID
//        $userName = Auth::user()->name;
//        $userId = Auth::id();
//
//        // Access user's roles
//        $userRoles = Auth::user()->roles;
//
//        return $userId;

        try {
            $members =  Member::all();

            return $this->success(
                $members,
                'Members successfully fetched',
                Response::HTTP_OK
            );


        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error fetching Members',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show($id)
    {

    }

    public function store(Request $request)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
