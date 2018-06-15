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

Route::get('hello/task/loop', function () {
    $tasks = [
        ['name' => 'Response 클래스 분석', 'due_date' => '2015-06-01 11:22:33'],
        ['name' => '블레이드 예제 작성', 'due_date' => '2015-06-03 15:21:13'],
        ['name' => 'kck', 'due_date' => '2018-04-09 15:22:13'],
    ];
    $tasks2 = [
        ['name' => '클래스 분석', 'due_date' => '2015-06-01 11:22:33'],
        ['name' => '작성', 'due_date' => '2015-06-03 15:21:13'],
        ['name' => 'kcdcccsack', 'due_date' => '2018-04-09 15:22:13'],
    ];
    return view('hello.task2')
                ->with('tasks', $tasks)
                ->with('tasks2', $tasks2);
});

Route::get('hello/task3', 'TaskController@list3');

Route::get('hello/param/{id?}/{arg?}', 'TaskController@param');

Route::resource('impl', 'ImplicitController');

Route::resource('orm', 'OrmController')->names([
    'whereIn' => 'orm.whereIn'
]);

Route::group(['middleware' => ['web']], function () {
    Route::resource('orders', 'OrderController');
});

/*
Route::get('hello/task3', function() {
    $tasks = [
        ['name' => 'Response 클래스 분석', 'due_date' => '2015-06-01 11:22:33'],
        ['name' => '블레이드 예제 작성', 'due_date' => '2015-06-03 15:21:13'],
        ['name' => 'kck', 'due_date' => '2018-04-09 15:22:13'],
    ];
    $tasks2 = [
        ['name' => '클래스 분석', 'due_date' => '2015-06-01 11:22:33'],
        ['name' => '작성', 'due_date' => '2015-06-03 15:21:13'],
        ['name' => 'kcdcccsack', 'due_date' => '2018-04-09 15:22:13'],
    ];

    //$img = \Image::make(public_path().'/152308678670347.gif');
    //$img = \Image::make('../public/152308678670347.gif')->resize(100, 50)->save('resize_152308678670347.gif');

    return view('hello.task3')
                ->with('tasks', $tasks)
                ->with('tasks2', $tasks2);
                //->with('img', $img);

});
*/

Route::post('/hello', function () {
    return 'hello world';
});

Route::get('hello/tasks', function () {
    DB::listen(function ($event) {
        dump($event->sql);
        dump($event->bindings);
        dump($event->time);
    });

    //Eager 로딩 -> with() 메소드 사용
    //$tasks = \App\Task::with('project')->get();

    //Lazy Eager 로딩 -> load() 메소드 사용
    $tasks = \App\Task::paginate(5);
    $tasks->load('project');

    //dd($tasks);

    return view('hello.tasks', compact('tasks'));
});

Route::get('mail', function () {
    //메일 발송 테스트
    $to = 'chrud66@naver.com';
    $subject = 'Studying sending email in Laravel';

    $data = [
        'title' => 'Hi there',
        'body' => 'This is the body of an email message',
        'user' => App\User::find(1)
    ];

    return Mail::send('emails.welcom', $data, function ($message) use ($to, $subject){
        $message->to($to)->subject($subject);
    });

    //메일발송 queue 이용 테스트
    //Mail::to('chrud66@naver.com')->queue(new \App\Mail\WelcomMail);
});

Route::get('/home', 'HomeController@index')->name('home');


Auth::routes();
