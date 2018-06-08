<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;

class TaskController extends Controller
{
    //

    /**
    * 할 일 목록 출력
    * 
    * @return Response
    */
    public function list3()
    {
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
        return view('hello.task3')->with('tasks', $tasks)
                    ->with('tasks2', $tasks2);
    }

    public function param(Request $request, $id = 0, $arg = 'argument')
    {
        dump(['path' => $request->path(),
            'url' => $request->url(),
            'fullUrl' => $request->fullUrl(),
            'method' => $request->method(),
            'name' => $request->get('name'),
            'ajax' => $request->ajax(),
            'header' => $request->header(),
        ]);
        dump(['all' => $request->all()]);

        return ['id' => $id, 'arg' => $arg];
    }
}
