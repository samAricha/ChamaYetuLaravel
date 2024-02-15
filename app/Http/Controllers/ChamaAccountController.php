<?php

namespace App\Http\Controllers;

use App\Models\ChamaAccount;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChamaAccountController extends Controller
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
                'chama_id' => 'required|exists:chamas,id',
                'account_name' => 'required|string',
            ]);

            // Create a new ChamaAccount instance
            $chamaAccount = new ChamaAccount();
            $chamaAccount->fill($request->all());
            $chamaAccount->save();

            return $this->success(
                $chamaAccount,
                'Chama account created successfully',
                Response::HTTP_OK
            );


        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error creating chamaa account',
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
