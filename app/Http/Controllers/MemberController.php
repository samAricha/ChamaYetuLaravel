<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MemberController extends Controller
{
    use HttpResponses;

    public function createMember(Request $request)
    {
        $requestData = $request->all();

        $member = new Member();
        $member->first_name = $requestData['firstName'];
        $member->last_name = $requestData['lastName'];
        $member->contact_information = $requestData['contactInformation'];
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
