<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use Illuminate\Http\Request;

class ContributionController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'memberId' => 'required|string',
            'chamaId' => 'required|integer',
            'contributionDate' => 'required|date',
            'contributionAmount' => 'required|numeric',
        ]);

        try {
            Contribution::create([
                'member_id' => $validatedData['memberId'],
                'chama_id' => $validatedData['chamaId'],
                'contribution_date' => $validatedData['contributionDate'],
                'contribution_amount' => $validatedData['contributionAmount'],
            ]);

            return response()->json(['success' => true, 'message' => 'Contribution added successfully']);
        } catch (\Exception $e) {
            // Log the exception if needed
            return response()->json(['success' => false, 'message' => 'Error adding contribution'], 500);
        }
    }



    public function show($id)
    {

    }


    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
