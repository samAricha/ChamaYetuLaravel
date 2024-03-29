<?php

namespace App\Http\Controllers;

use App\Models\TransactionType;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionTypeController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            $transactionTypes =  TransactionType::all();

            return $this->success(
                $transactionTypes,
                'Transaction Types successfully fetched',
                Response::HTTP_OK
            );


        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error fetching Transaction Types',
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
