<?php

use App\Http\Controllers\ApiTokenController;
use App\Http\Resources\Locality  as LocalityResource;
use App\Http\Resources\Raion as RaionResource;
use App\Locality;
use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/raion', function () {
             return  LocalityResource::collection(Locality::all());
});


Route::get('/locality/{id}', 'ApiTokenController@locality');
Route::get('/raion',  'ApiTokenController@raion');
Route::get('/ecocod', 'ApiTokenController@ecocod');

    //  /iban?ecocod={{}}&codlocal={{}}&raion={{}};

Route::get('/iban', 'ApiTokenController@iban');


// DEMO for CRUD methods
Route::group(['middleware' => 'isAdmin'], function() {
     Route::post('/add_iban', 'ApiTokenController@add_iban');
     Route::put('put_iban/{ibab}',  'ApiTokenController@put_iban');
     Route::get('/get_iban/{iban}', 'ApiTokenController@get_iban');
});

Route::group(['middleware' => 'isOperator'], function() {
    Route::get('/get_iban/{iban}', 'ApiTokenController@get_iban_operator');
});

//Route::post('add_iban/{iban}', 'ApiTokenController@add_iban' );
