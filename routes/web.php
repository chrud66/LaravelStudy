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
    /*
    Route::get('github', [
        'as' => 'github.login',
        'uses' => 'Auth\LoginController@redirectToProvider'
    ]);

    Route::get('github/callback', [
        'as' => 'github.callback',
        'uses' => 'Auth\LoginController@handleProviderCallback'
    ]);
    */

    Route::get('{social?}', [
        'as' => 'social.login',
        'uses' => 'Auth\LoginController@redirectToProvider'
    ]);

    Route::get('{social?}/callback', [
        'as' => 'social.callback',
        'uses' => 'Auth\LoginController@handleProviderCallback'
    ]);
});

Route::get('locale', [
    'as' => 'locale',
    'uses' => 'WelcomeController@locale'
]);

Route::get('tags/{id}/articles', [
    'as' => 'tags.articles.index',
    'uses' => 'ArticlesController@index'
]);

Route::resource('articles', 'ArticlesController');

/* 개인정보처리방침 */
Route::get('privacy', function () {
    return '개인정보처리방침';
});

/* 서비스약관 */
Route::get('policy', function () {
    return '서비스약관';
});
