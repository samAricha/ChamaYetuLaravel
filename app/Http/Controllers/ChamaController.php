<?php

namespace App\Http\Controllers;

use App\Models\Chama;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ChamaController extends Controller
{
    use HttpResponses;

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
                ResponseAlias::HTTP_OK
            );


        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error saving Chamaa',
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
