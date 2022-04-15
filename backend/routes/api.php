<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TermControllerAdmin;
use App\Http\Controllers\TermControllerClient;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// ADMIN
Route::apiResource('/admin/terms', TermControllerAdmin::class);
Route::apiResource('/client/terms', TermControllerClient::class);
Route::get('/client/types', [TermControllerClient::class, 'types']);
