<?php

namespace App\Http\Controllers;

use App\Models\Chama;
use App\Models\ChamaMembers;
use App\Models\Member;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ChamaMembersController extends Controller
{
    use HttpResponses;


    public function addMember(Request $request, $chamaId)
    {
        try {
            $userId = Auth::id();
            // Assuming $chamaId holds the Chama ID you have
            $chama = Chama::findOrFail($chamaId);

            // Check if the user is associated with this chama
            if ($chama->users()->wherePivot('user_id', $userId)->exists()) {
                // Now, you can retrieve the pivot record for this user and chama
                $pivotRecord = $chama->users()->wherePivot('user_id', $userId)->first()->pivot;

                // Now, you can get the role ID associated with this user in the context of the chama
                $roleId = $pivotRecord->role_id;

                if ($roleId < 3){
                    return $this->error(
                        null,
                        'Unauthorised User',
                        ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
                    );
                }
            } else {
                return $this->error(
                    null,
                    'Unauthorised User',
                    ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
                );
            }



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

            // Retrieve the chamaa instance
            $chama = Chama::findOrFail($chamaId);

            // Check if a member with the provided phone number already exists
            $existingMember = Member::where('phone', $request['phone'])->first();

            if ($existingMember) {
                // Member already exists, update their information if necessary
                $existingMember->update($request->all());

                // Check if the member is already attached to this chama
                if (!$chama->members()->where('member_id', $existingMember->id)->exists()) {
                    // If not attached, attach the member to this chama
                    $chama->members()->attach($existingMember->id);
                }

                return $this->success(
                    $existingMember,
                    'Member updated and attached to chama successfully',
                    ResponseAlias::HTTP_OK
                );
            } else {
                // Member doesn't exist, create a new member
                $member = new Member();
                $member->fill($request->all());
                $member->user_id = $userId;
                $member->save();

                // Attach the new member to the chama
                $chama = Chama::findOrFail($chamaId);
                $chama->members()->attach($member->id);

                return $this->success(
                    $member,
                    'Member created and attached to chama successfully',
                    ResponseAlias::HTTP_OK
                );
            }

        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error creating member',
                ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function index()
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            if ($user) {
                // Check if the user has any roles
                if ($user->roles->isNotEmpty()) {
                    // Assuming you're interested in the first role
                    $userRoles = $user->roles->pluck('id');

                    if (!$userRoles->contains(4)) {
                        return $this->error(
                            null,
                            'Unauthorized User',
                            ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
                        );
                    }
                } else {
                    return $this->error(
                        null,
                        'Unauthorised User',
                        ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
                    );
                }
            } else {
                return $this->error(
                    null,
                    'Unauthenticated User',
                    ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
                );
            }





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

    public function showChamaaMembers($chamaId)
    {

        try {
            $user = Auth::user();
            $userId = $user->id;
            $chama = Chama::findOrFail($chamaId);

            // Check if the user is associated with this chama
            if ($chama->users()->wherePivot('user_id', $userId)->exists()) {
                // Now, you can retrieve the pivot record for this user and chama
                $pivotRecord = $chama->users()->wherePivot('user_id', $userId)->first()->pivot;
                // Now, you can get the role ID associated with this user in the context of the chama
                $roleId = $pivotRecord->role_id;
                if (!$roleId != 4) {
                    return $this->error(
                        null,
                        'Unauthorized User',
                        ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
                    );
                }else{
                    $members = Member::whereHas('chamas', function ($query) use ($chamaId) {
                        $query->where('chama_id', $chamaId);
                    })->get();
                    
                    return $this->success(
                        $members,
                        'Contributions successfully fetched',
                        ResponseAlias::HTTP_OK
                    );

                }
            }else {
                return $this->error(
                    null,
                    'Unauthorised User',
                    ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
                );
            }

        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error fetching chamaa members',
                ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
            );
        }

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
