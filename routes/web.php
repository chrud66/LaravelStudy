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

Route::get('/', function () {
    return view('welcome');
});

Route::get('hello', function () {
    return 'Hello';
});

/*
Route::get('hello/world', function () {
    return 'Hello World';
});
*/

Route::get('hello/world/{name?}', function ($name = 'testname') {
    //return 'Hello World ' . $name;
    return response('Hello World ' . $name, 200)
        ->header('Content-Type', 'text/plain')
        ->header('Cache-Control', 'max-age=' . 60*60 . ', must-revalidate');date("Y-m-d A h:i:s");
});

Route::get('hello/world/{name}/{val}', function ($name, $val) {
    return 'Hello World ' . $name . ' : ' . $val;
});

route::get('hello/json', function () {
    $data = ['name' => 'My Name', 'Age' => '30'];

    return response()->json($data);
});

Route::get('/hello/html', function () {
/*
    $content = <<<HTML
    <!doctype html>
    <html lang="ko">
        <head>
            <meta charset="UTF-8">
            <title>Ok</title>
        </head>
        <body>
            <h1>라라벨이란?</h1>
            <h3>라라벨은 가장 모던하고 세련된 PHP 프레임워크이며, 유연하고 세련된 기능을 제공합니다. </h3>
        </body>
    </html>
HTML;

    return $content;
*/


    //return View::make('hello.hello');
    return view('hello.hello');
});

Route::get('hello/task', function () {
    /*$task = ['greeting' => '안녕하세요.', 'name' => 'kck', 'due_date' => date("Y-m-d A h:i:s")];
    return view('hello.task', compact('task'));*/
    return view('hello.task')->with('greeting', '안녕하세요')
                ->with('name', 'kck')
                ->with('due_date', date('Y-m-d h:i:s'))
                ->with('comment', '<script>alert("Welcome");</script>');
});

Route::get('hello/calc/{num}', function ($num) {
    return view('hello.calc')->with('num', $num);
});

route::post('/hello', function() {
    return 'hello world';
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
