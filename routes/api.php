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

Route::group(['domain' => env('API_DOMAIN'), 'as' => 'api.', 'namespace' => 'Api'], function () {
    //Auth::routes();

    Route::get('/', [
        'as'    => 'index',
        'uses'  => 'WelcomeController@index'
    ]);

    Route::post('register', [
        'as' => 'register',
        'uses' => 'Auth\RegisterController@store'
    ]);

    Route::post('login', [
        'as' => 'login',
        'uses' => 'Auth\LoginController@login'
    ]);

    Route::post('password/email', [
        'as' => 'password.email',
        'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail',
    ]);

    Route::post('auth/refresh', [
        'as' => 'sessions.refresh',
        'uses' => 'Auth\LoginController@refresh',
    ]);

    Route::group(['prefix' => 'v1', 'as' => 'v1.', 'namespace' => 'V1'], function () {
        Route::get('/', [
            //'as'    => 'v1.index',
            'as'    => 'index',
            'uses'  => 'WelcomeController@index'
        ]);

        /* Forum */
        Route::get('tags/{slug}/articles', [
            'as' => 'tags.articles.index',
            'uses' => 'ArticlesController@index'
        ]);

        Route::resource('articles', 'ArticlesController', ['except' => ['create', 'edit']]);
        Route::resource('comments', 'CommentsController', ['except' => ['create', 'edit']]);

        Route::get('download/{fileName}', function ($fileName) {
            $path = attachment_path($fileName);
            if (\File::exists($path)) {
                return response()->download($path);
            } else {
                flash()->error('File Not Exists');
                return back();
            }
        })->name('download');
    });
});
