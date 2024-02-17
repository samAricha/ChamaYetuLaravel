<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Role;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            $roles =  Role::all();

            return $this->success(
                $roles,
                'Roles successfully fetched',
                Response::HTTP_OK
            );


        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error fetching Roles',
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
