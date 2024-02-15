<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\ChamaAccountController;
use App\Http\Controllers\ChamaController;
use App\Http\Controllers\ChamaMembersController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\MemberController;
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
});

Route::prefix('contributions')->group(function () {
    Route::apiResource('', ContributionController::class);
});
