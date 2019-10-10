<?php

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

Route::post('/login', 'API\V1\AuthController@login');
// Route::post('/register', 'API\V1\AuthController@register');


Route::group(['middleware' => 'auth:api'], function(){

    //logout
    Route::get('/logout', 'API\V1\AuthController@logout');

    //users crud
    Route::apiResource('users', 'API\V1\UserController');
    Route::apiResource('addresses', 'API\V1\AddressController');
    Route::apiResource('companies', 'API\V1\CompanyController');
    Route::apiResource('branches', 'API\V1\BranchController');
    Route::apiResource('divisions', 'API\V1\DivisionController');

    //bank account crud
    Route::get('/bank_account', 'API\V1\BanksController@index');
    Route::post('/bank_account', 'API\V1\BanksController@store');
    Route::put('/bank_account/{uuid}', 'API\V1\BanksController@update');
    Route::get('/bank_account/{uuid}', 'API\V1\BanksController@show');
    Route::delete('/bank_account/{uuid}', 'API\V1\BanksController@destroy');
    
    //document crud
    Route::get('/documents', 'API\V1\DocumentsController@index');
    Route::post('/documents', 'API\V1\DocumentsController@store');
    Route::put('/documents/{uuid}', 'API\V1\DocumentsController@update');
    Route::get('/documents/{uuid}', 'API\V1\DocumentsController@show');
    Route::delete('/documents/{uuid}', 'API\V1\DocumentsController@destroy');
});
