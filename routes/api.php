<?php

use App\Http\Controllers\Api\LinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::controller(LinkController::class)->group(function() {
    Route::get('links/index', 'index');
    Route::post('links/store', 'store');
    Route::get('links/getByNumberOfView/{id}', 'getByNumberOfView');
    Route::get('links/clickLink/{linkId}', 'clickLink');
});
