<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('home', 'HomeController@index')->name('home');

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('test', function () {
    return view('test');
});

Route::get('/', [
    'as' => 'root',
    'uses' => 'WelcomeController@index'
]);

Route::group(['prefix' => 'login', 'as' => 'login.'], function () {
    /* Social Login */
    Route::get('github', [
        'as' => 'github.login',
        'uses' => 'Auth\LoginController@redirectToProvider'
    ]);

    Route::get('github/callback', [
        'as' => 'github.callback',
        'uses' => 'Auth\LoginController@handleProviderCallback'
    ]);
});
