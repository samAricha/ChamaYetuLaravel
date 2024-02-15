<?php

namespace App\Http\Controllers;

use App\Models\Chama;
use App\Models\Member;
use Illuminate\Http\Request;

class ChamaMembersController extends Controller
{

    public function addMember(Request $request, $chamaId)
    {
        // Validate the incoming request
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'contact_information' => 'required|string',
            'date_joined' => 'required|date',
            // Add other validation rules as needed
        ]);

        // Retrieve the chama instance
        $chama = Chama::findOrFail($chamaId);

        // Create the new member
        $member = new Member();
        $member->fill($request->all());
        $member->save();

        // Attach the member to the chama
        $chama->members()->attach($member->id);

        // Return a response indicating success
        return response()->json([
            'message' => 'Member created successfully',
            'member' => $member,
            'chama' => $chama
        ], 201);
    }

    public function index()
    {

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
