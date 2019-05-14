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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('test', function () {
    //echo env('APP_URL');
    phpinfo();
    exit;
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

/* Comments */
Route::post('comments/{id}/vote', 'CommentsController@vote');
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

/* pdf to image convert */
Route::get('pdf-to-img/download/{fileName}', 'PdfToImgController@download')->name('pdf-to-img.download');
Route::post('pdf-to-img/all-download', 'PdfToImgController@allDownload')->name('pdf-to-img.allDownload');
Route::resource('pdf-to-img', 'PdfToImgController')->only('index', 'show');
Route::resource('pdf-files', 'PdfFilesController')->only('store', 'destroy');

/* images to pdf convert */
Route::resource('images-to-pdf', 'ImagesToPdfController')->only('index', 'show', 'store');
Route::get('images-to-pdf/download/{fileName}', 'ImagesToPdfController@download')->name('images-to-pdf.download');
Route::post('images-to-pdf/file-upload', 'ImagesToPdfController@fileUpload')->name('images-to-pdf.file-upload');
Route::delete('images-to-pdf/file-destroy', 'ImagesToPdfController@fileDestroy')->name('images-to-pdf.file-destory');

/* QR Code generate */
Route::resource('qr-code', 'QrCodeController')->only('index', 'show');

/* Admin Page */
//Route::name('admin.')->namespace('Admin')->prefix('Admin')->middleware(['auth'])->group(function () {
Route::name('admin.')->namespace('Admin')->prefix('Admin')->middleware(['auth', 'role:최고 관리자|관리자'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard.index');
    });

    Route::name('dashboard.')->namespace('dashboard')->prefix('dashboard')->group(function () {
        Route::get('/', 'DashboardController@index')->name('index');
        Route::get('user-chart-data', 'DashboardController@getUserChartData')->name('userChartData');
        Route::get('site-chart-data', 'DashboardController@getSiteChartData')->name('siteChartData');
        Route::get('connector-chart-data', 'DashboardController@getConnectorChartData')->name('connectorChartData');
    });

    Route::name('board.')->namespace('board')->prefix('board')->group(function () {
        Route::namespace('config')->group(function () {
            Route::resource('config', 'ConfigController');
        });
    });
});

/* 개인정보처리방침 */
/*Route::get('privacy', function () {
    return '개인정보처리방침';
});*/

/* 서비스약관 */
/*Route::get('policy', function () {
    return '서비스약관';
});*/
