<?php

namespace App\Http\Controllers;

use App\Models\Chama;
use App\Models\Member;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
