<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\TermControllerAdmin;
use App\Http\Controllers\TermControllerClient;

use \App\Http\Middleware\IdentifyAdmin;
use \App\Http\Middleware\AuthAdmin;



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


// auth
Route::post('/admin/register', [AuthenticationController::class, 'register']);
Route::post('/admin/login', [AuthenticationController::class, 'login']);

Route::group([
    'prefix'     => '/{admin_slug}',
    'middleware' => IdentifyAdmin::class,
], function () {
    // ADMIN
    Route::post('/admin/login', [AuthenticationController::class, 'login']);

    Route::group(['middleware' => ['auth:sanctum', AuthAdmin::class]], function () {
        Route::apiResource('/admin/terms', TermControllerAdmin::class);
        Route::post('/admin/terms/delete', [TermControllerAdmin::class, 'deleteMany']);
    });

    // zankrat se ne uporablja
    Route::post('/admin/terms/clear', [TermControllerAdmin::class, 'clearMany']);

    // client
    Route::apiResource('/client/terms', TermControllerClient::class);
    Route::get('/client/types', [TermControllerClient::class, 'types']);


});

