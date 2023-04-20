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
    'prefix' => 'v1',
    'namespace' => "App\Http\Controllers\Admin"

], function () {

    Route::post('login', 'AuthController@login');
    
    Route::group([
            'middleware' => ['auth:admin', 'scopes:admin']
        ], function () {

            Route::get('me', 'AuthController@me');

            /*
            * Position route
            */
            Route::group([
                'name' => 'Position',
                'prefix' => 'position',
            ], function () {

                Route::get('/', 'PositionController@index');
                Route::get('show/{id}', 'PositionController@show');
                Route::post('store', 'PositionController@store');
                Route::put('update/{id}', 'PositionController@update');
                Route::delete('destroy/{id}', 'PositionController@destroy');
            });

            /*
            * Employee route
            */
            Route::group([
                'name' => 'Employee',
                'prefix' => 'employee',
            ], function () {

                Route::get('/', 'EmployeeController@index');
                Route::get('show/{id}', 'EmployeeController@show');
                Route::post('store', 'EmployeeController@store');
                Route::put('update/{id}', 'EmployeeController@update');
                Route::delete('destroy/{id}', 'EmployeeController@destroy');
            });
            /*
            * TestContents route
            */
            Route::group([
                'name' => 'TestContent',
                'prefix' => 'test',
            ], function () {

                Route::get('/', 'TestContentController@index');
                Route::get('show/{id}', 'TestContentController@show');
                Route::post('store', 'TestContentController@store');
                Route::put('update/{id}', 'TestContentController@update');
                Route::delete('destroy/{id}', 'TestContentController@destroy');
            });

            /*
            * EmployeeTestController route
            */
            Route::group([
                'name' => 'EmployeeTestController',
                'prefix' => 'employee/test',
            ], function () {

                Route::get('/', 'EmployeeTestController@index');
                Route::get('show/{id}', 'EmployeeTestController@show');
            });

            /*
            * Model List route
            */
            Route::group([
                'prefix' => 'list',
                'name' => "ModelList",
            ], function () {

                Route::get('positions', 'ModelListController@position');       
            });
        });

});
