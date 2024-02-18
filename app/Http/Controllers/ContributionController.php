<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContributionController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            $contributions =  Contribution::all();

            return $this->success(
                $contributions,
                'contributions successfully fetched',
                Response::HTTP_OK
            );


        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error fetching contributions',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'member_id' => 'required|exists:members,id',
                'chama_account_id' => 'required|exists:chama_accounts,id',
                'contribution_date' => 'required|date',
                'contribution_amount' => 'required|numeric|min:0',
            ]);

            // Create a new Contribution instance
            $contribution = new Contribution();
            $contribution->fill($request->all());
            $contribution->save();

            return $this->success(
                $contribution,
                'Contribution saved successfully',
                Response::HTTP_OK
            );


        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error saving contribution',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
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
