<?php

namespace App\Http\Controllers;

use App\Models\Chama;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ChamaController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            $chamaas =  Chama::all();


            return $this->success(
                $chamaas,
                'Chamaas successfully fetched',
                Response::HTTP_OK
            );


        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error fetching Chamaas',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show($id)
    {

    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'chama_name' => 'required|string',
                'chama_description' => 'required|string',
                'date_formed' => 'required|date',
            ]);

            // Create a new chama instance
            $chama = new Chama();
            $chama->fill($request->all());
            $chama->save();

            // Get User-id of requester
            $userId = Auth::id();
            // Attach the user to the chamaa role
            $chama->users()->attach($userId, ['role_id' => 3]);


            return $this->success(
                $chama,
                'Chama created successfully',
                Response::HTTP_OK
            );


        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error saving Chamaa',
                Response::HTTP_INTERNAL_SERVER_ERROR
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
