<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Transaction;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            $transactions =  Transaction::all();

            return $this->success(
                $transactions,
                'Transactions successfully fetched',
                Response::HTTP_OK
            );


        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error fetching Transactions',
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
