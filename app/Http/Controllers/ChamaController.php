<?php

namespace App\Http\Controllers;

use App\Models\Chama;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChamaController extends Controller
{
    use HttpResponses;

    public function index()
    {

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
