<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Project;
use App\Role;
use App\User;
use App\Picture;

class OrmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$tasks = Task::all();
        //$id = 100;
        //$tasks = Task::findOrFail($id);

        /*$count = Project::count();
        $sum = Task::sum('id');
        $max = Task::max('id');
        $min = Task::min('id');

        $max = Task::where('created_at', '>', \Carbon\Carbon::now()->subDays(7))->max('id');

        echo $count . '<br/>' . $sum . '<br/>' . $max . '<br/>' . $min;
        */

        /*
        $sql = Task::where('id', '>', 10)
                ->where('id', '<', 20)
                ->where('name', 'like', 'Ta%')
                ->orderBy('name', 'desc')
                ->skip(5)
                ->take(3)
                ->toSql();

        //dump($sql);

        $bind = Task::where('id', '>', 10)
                ->where('id', '<', 20)
                ->where('name', 'like', 'Ta%')
                ->orderBy('name', 'desc')
                ->skip(5)
                ->take(3)
                ->getBindings();
        //dump($bind);
        */

        /*$tasks = Task::where('id', '>', 10)
                ->where('id', '<', 20)
                ->where('name', 'like', 'Ta%')
                ->orderBy('name', 'desc')
                ->skip(5)
                ->take(3)
                ->first();


        $tasks = Task::whereNotIn('id', [1, 5, 7])
                ->get();



        $tasks = Task::whereNotBetween('id', [1, 7])
                ->get();

        $tasks = Task::whereNull('description')
                ->get();

        $tasks = Task::where('id', '=', 10)
                ->OrWhere(function ($query) {
                    $query->where('name', 'like', 'Ta%')
                        ->where('id', '>', 3)
                        ->where('id', '<', 7);
                })
                ->get();

        foreach($tasks as $task) {
            echo "ID : " . $task->id . ", Name : " . $task->name . '<br/>';
        }

        //return response()->json($tasks, 200, [], JSON_PRETTY_PRINT);
        */

        /*
        //insert
        $task = new Task;

        $task->name = '예제 작성';
        $task->project_id = 1;
        $task->description = 'insert 예제 작성';

        $ret = $task->save();

        return response()->json(['result' => $ret, 'task' => $task], 200, [], JSON_PRETTY_PRINT);
        */

        //update
        /*
        $task = Task::find(121);

        $task->name = '갱신2 - 예제 작성';
        $task->project_id = 1;
        $task->description = '갱신2 - insert 예제 작성';

        $ret = $task->save();
        return response()->json(['result' => $ret, 'task' => $task], 200, [], JSON_PRETTY_PRINT);
        */

        /*
        //update 2
        $param = [
            'name' => '갱신5 - 예제 작성',
            'project_id' => 1,
            'description' => '갱신5 - insert 예제 작성'
        ];

        $before = Task::find(121);
        $ret = Task::find(121)->update($param);

        $after = Task::find(121);
        return response()->json(['result' => $ret, 'before' => $before, 'after' => $after], 200, [], JSON_PRETTY_PRINT);
        */

        /*
        //insert2
        $param = [
            'name' => '예제 작성',
            'project_id' => 1,
            'description' => 'insert mass 예제 작성'
        ];

        $task = Task::create($param);

        return response()->json($task, 200, [], JSON_PRETTY_PRINT);
        */

        /*
        //delete
        $task = Task::findOrFail(123);

        $ret = $task->delete();

        return response()->json(['ret' => $ret], 200, [], JSON_PRETTY_PRINT);
        */

        /*
        //delete2
        //$ret = Task::destroy(120,121,122,123,124);
        $ret = Task::destroy([120,121,122,123,124]);
        return response()->json(['ret' => $ret], 200, [], JSON_PRETTY_PRINT);
        */

        /*
        //delete3
        //소프트 델리트 적용으로 삭제 날짜 업데이트
        $ret = Task::where('id', '>', 100)->where('id', '<', 110)->delete();

        return response()->json(['ret' => $ret], 200, [], JSON_PRETTY_PRINT);
        */

        /*
        //소프트 삭제된 레코드 가져오기
        $tasks = Task::withTrashed()->where('id', '>', 99)->get(); //삭제 & 정상데이터
        $tasks = Task::onlyTrashed()->where('id', '>', 99)->get(); //삭제된 데이터만

        return response()->json($tasks, 200, [], JSON_PRETTY_PRINT);
        */

        /*
        //소프트 삭제된 데이터 복구
        $ret = Task::withTrashed()->find(108)->restore();

        return response()->json(['ret' => $ret], 200, [], JSON_PRETTY_PRINT);
        */

        /*
        //소프트 삭제된 데이터 영구삭제
        $ret = Task::withTrashed()->find(108)->forceDelete();

        return response()->json(['ret' => $ret], 200, [], JSON_PRETTY_PRINT);
        */

        //https://atom.io/packages/php-integrator-base-legacy-php56
        //->여기 들어가서 한국어 번역으로 보고 패키지 설치할거 더 설치하기

        //쿼리 스코프 사용
        /*
        $tasks = Task::dueIn7Days()
                ->take(100)
                ->orderBy('due_date', 'desc')
                ->get();

        return response()->json($tasks, 200, [], JSON_PRETTY_PRINT);

        $tasks = Task::dueInDays(1000)
                ->take(100)
                ->orderBy('due_date', 'desc')
                ->get();

        return response()->json($tasks, 200, [], JSON_PRETTY_PRINT);
        */

        /*
        //모델 이벤트 자동 account 암호화
        $user = \App\User::create([
            'name' => 'Test',
            'account' => '1234567890',
            'email' => 'abc@gmail.com',
            'password'=>'abc',
        ]);
        return response()->json($user, 200, [], JSON_PRETTY_PRINT);
        */

        /*
        // 입력시 mutator 자동 호출
        $u1 = \App\User::create([
            'name' => 'Test',
            'account' => '123456789011111',
            'email' => 'abcd@gmail.com',
            'password'=>'abc',
        ]);

        dump($u1);

        $u2 = \App\User::find($u1->id);
        // accessor 호출
        dump($u2->account);
        */

        /*
        //Many To Many
        $users = Role::findOrFail(2)->users()->orderBy('name')->get();
        dd($users);
        */

        /*
        //Has Many Through
        $tasks = User::findOrFail(10)->tasks()->orderBy('created_at')->get();
        dump($tasks);
        */

        /*$pic = Picture::find(2);
        $imageable = $pic->imageable;
        dump($imageable);*/

        $task = new \App\Task(['name' => 'example task']);
        $prj = \App\Project::find(8);
        $task = $prj->tasks()->save($task);



        //return $tasks;
    }

    private function findWhereIn() {
        echo 'findWhereIn';
        $tasks = Task::whereIn('id', [1, 5, 7])
                ->get();

        dump(response()->json($tasks, 200, [], JSON_PRETTY_PRINT));
        //return response()->json($tasks, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        switch ($id){
          case 'whereIn':
            echo $id . '<br/><br/>';
           $this->findWhereIn();
           break;
          case 'bar':
           $this->bar();
           break;
         default:
           abort(404,'bad request');
           break;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
