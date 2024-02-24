<?php

use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\ChamaAccountController;
use App\Http\Controllers\ChamaController;
use App\Http\Controllers\ChamaMembersController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [ApiAuthController::class, 'register']);
Route::post('/auth/login', [ApiAuthController::class, 'login']);



Route::post('/save/member', [MemberController::class, 'createMember']);
Route::post('/save/contribution', [ContributionController::class, 'store']);



//Route::middleware(['auth:api', 'role:admin'])->group(function () {
Route::middleware('auth:sanctum')->group(function () {


    Route::prefix('chamaas')->group(function () {
        Route::apiResource('', ChamaController::class);
    });

    Route::prefix('chamaa_accounts')->group(function () {
        Route::apiResource('', ChamaAccountController::class);
    });

    Route::prefix('members')->group(function () {
        Route::apiResource('', MemberController::class);
    });

    Route::prefix('chamaa_members')->group(function () {
        Route::apiResource('', ChamaMembersController::class);
        Route::post('add/member/{chamaa_id}', [ChamaMembersController::class, 'addMember']);
    });

    Route::prefix('contributions')->group(function () {
        Route::apiResource('', ContributionController::class);
    });

    Route::prefix('investments')->group(function () {
        Route::apiResource('', InvestmentController::class);
    });

    Route::prefix('loans')->group(function () {
        Route::apiResource('', LoanController::class);
    });

    Route::prefix('transactions')->middleware('auth:sanctum')->group(function () {
        Route::apiResource('', TransactionController::class);
    });

    Route::prefix('account_types')->group(function () {
        Route::apiResource('', AccountTypeController::class);
    });

    Route::prefix('transaction_types')->middleware('auth:sanctum')->group(function () {
        Route::apiResource('', TransactionTypeController::class);
    });

});
