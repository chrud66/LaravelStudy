<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Project;

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

        /*$tasks = Task::where('id', '>', 10)
                ->where('id', '<', 20)
                ->where('name', 'like', 'Ta%')
                ->orderBy('name', 'desc')
                ->skip(5)
                ->take(3)
                ->first();
        */

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

        /*foreach($tasks as $task) {
            echo "ID : " . $task->id . ", Name : " . $task->name . '<br/>';
        }*/

        //return $tasks;
        return response()->json($tasks, 200, [], JSON_PRETTY_PRINT);
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
