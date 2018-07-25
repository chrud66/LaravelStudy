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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['domain' => env('API_DOMAIN'), 'as' => 'api.', 'namespace' => 'Api'], function() {
    Auth::routes();

    Route::get('/', [
        'as'    => 'index',
        'uses'  => 'WelcomeController@index'
    ]);

    Route::group(['prefix' => 'v1', 'namespace' => 'V1'], function() {
        Route::get('/', [
            'as'    => 'v1.index',
            'uses'  => 'WelcomeController@index'
        ]);
    });
});
