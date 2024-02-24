<?php

namespace App\Http\Controllers;

use App\Models\Chama;
use App\Models\ChamaMembers;
use App\Models\Member;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ChamaMembersController extends Controller
{
    use HttpResponses;


    public function addMember(Request $request, $chamaId)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'phone' => 'required|string',
                'date_joined' => 'required|date',
                // Add other validation rules as needed
            ]);


            // Check if a user with the provided phone number already exists
            $existingUser = User::where('phone', $request['phone'])->first();

            // If a user with the phone number exists, use their ID for the member
            if ($existingUser) {
                $userId = $existingUser->id;
            } else {
                // If the user doesn't exist, create a new user
                $user = User::create([
                    'name' => $request['first_name'],
                    'phone' => $request['phone'],
                    'password' => Hash::make($request['password']),
                ]);
                $user->assignRole('user');
                $userId = $user->id;
            }

            // Retrieve the chama instance
            $chama = Chama::findOrFail($chamaId);

            // Create the new member
            $member = new Member();
            $member->fill($request->all());
            $member->user_id = $userId;
            $member->save();

            // Attach the member to the chama
            $chama->members()->attach($member->id);


            return $this->success(
                $member,
                'Member created successfully',
                Response::HTTP_OK
            );


        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error creating member',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function index()
    {
        try {
            $chamaaMembers =  ChamaMembers::all();

            return $this->success(
                $chamaaMembers,
                'Chamaa members successfully fetched',
                Response::HTTP_OK
            );


        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error fetching Chamaa members',
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
