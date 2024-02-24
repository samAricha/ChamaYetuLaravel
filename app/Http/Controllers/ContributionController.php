<?php

namespace App\Http\Controllers;

use App\Models\Chama;
use App\Models\ChamaAccount;
use App\Models\Contribution;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ContributionController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            if ($user) {
                // Check if the user has any roles
                if ($user->roles->isNotEmpty()) {
                    // Assuming you're interested in the first role
                    $userRoles = $user->roles->pluck('id');

                    if (!$userRoles->contains(4)) {
                        return $this->error(
                            null,
                            'Unauthorized User',
                            ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
                        );
                    }
                } else {
                    return $this->error(
                        null,
                        'Unauthorised User',
                        ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
                    );
                }
            } else {
                return $this->error(
                    null,
                    'Unauthenticated User',
                    ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            $contributions =  Contribution::all();

            return $this->success(
                $contributions,
                'contributions successfully fetched',
                ResponseAlias::HTTP_OK
            );


        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error fetching contributions',
                ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function store(Request $request)
    {
        try {
            $userId = Auth::id();

            $chamaaAccountId = $request['chama_account_id'];
            // Assuming $accountId holds the account_id you have
            $chamaAccount = ChamaAccount::findOrFail($chamaaAccountId);
            // Now you can access the chama_id
            $chamaId = $chamaAccount->chama_id;
            // Assuming $chamaId holds the Chama ID you have
            $chama = Chama::findOrFail($chamaId);

            // Check if the user is associated with this chama
            if ($chama->users()->wherePivot('user_id', $userId)->exists()) {
                // Now, you can retrieve the pivot record for this user and chama
                $pivotRecord = $chama->users()->wherePivot('user_id', $userId)->first()->pivot;

                // Now, you can get the role ID associated with this user in the context of the chama
                $roleId = $pivotRecord->role_id;

                if ($roleId < 3){
                    return $this->error(
                        null,
                        'Unauthorised User',
                        ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
                    );
                }
            } else {
                return $this->error(
                    null,
                    'Unauthorised User',
                    ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
                );
            }





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
                ResponseAlias::HTTP_OK
            );

        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error saving contribution',
                ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
            );
        }


    }



    public function show($contributionId)
    {

    }


    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
