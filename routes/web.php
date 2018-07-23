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
    echo env('APP_URL');
    //return view('test');
});


Route::get('/', [
    'as' => 'root',
    'uses' => 'WelcomeController@index'
]);

/* Social Register Or Login */
Route::get('social/{provider}', [
    'as' => 'social.login',
    'uses' => 'Auth\SocialController@execute'
]);

Route::post('register', [
    'as' => 'register',
    'uses' => 'Auth\RegisterController@store'
]);

Route::get('locale', [
    'as' => 'locale',
    'uses' => 'WelcomeController@locale'
]);

/* tag search */
Route::get('tags/{id}/articles', [
    'as' => 'tags.articles.index',
    'uses' => 'ArticlesController@index'
]);

/* Forum Route */

Route::put('articles/{article}/pick', [
    'as' => 'articles.pick-best-comment',
    'uses' => 'ArticlesController@pickBest'
]);
Route::resource('articles', 'ArticlesController');

/* File Upload */
Route::resource('files', 'AttachmentsController')->only('store', 'destroy');

Route::resource('comments', 'CommentsController')->only('store', 'update', 'destroy');

Route::get('download/{fileName}', function ($fileName) {
    $path = attachment_path($fileName);
    if (\File::exists($path)) {
        return response()->download($path);
    } else {
        flash()->error('File Not Exists');
        return back();
    }
})->name('download');

/* 개인정보처리방침 */
/*Route::get('privacy', function () {
    return '개인정보처리방침';
});*/

/* 서비스약관 */
/*Route::get('policy', function () {
    return '서비스약관';
});*/
