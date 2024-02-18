<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Loan;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoanController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            $loans =  Loan::all();

            return $this->success(
                $loans,
                'loans successfully fetched',
                Response::HTTP_OK
            );


        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error fetching loans',
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
