<?php

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
Route::group([
    'prefix' => 'e1',
    'namespace' => "App\Http\Controllers\Employee"
], function () {

    /*
    * Model List route
    */
    Route::group([
        'prefix' => 'list',
        'name' => "ModelList",
    ], function () {

        Route::get('employee', 'ModelListController@employee');       
    });

    /*
    * Employee test create
    */
    Route::post('test/create', 'TestModeratorController@testSubmission');
    Route::post('test/check', 'TestModeratorController@testCheck');

   
});
