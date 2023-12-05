<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
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
}
