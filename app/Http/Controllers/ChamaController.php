<?php

namespace App\Http\Controllers;

use App\Models\Chama;
use Illuminate\Http\Request;

class ChamaController extends Controller
{
    public function index()
    {

    }

    public function show($id)
    {

    }

    public function store(Request $request)
    {
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

        // Return a response indicating success
        return response()->json([
            'message' => 'Chama created successfully',
            'chama' => $chama
        ], 201);

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
