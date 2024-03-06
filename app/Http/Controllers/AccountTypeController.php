<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use App\Models\TransactionType;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AccountTypeController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            $accountTypes =  AccountType::all();

            return $this->success(
                $accountTypes,
                'Account Types successfully fetched',
                ResponseAlias::HTTP_OK
            );


        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error fetching Account Types',
                ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
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
