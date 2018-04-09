@extends('layouts.master')
@section('title')
    할일 목록
@endsection

@section('content')
    <!--img src="/152308678670347.gif" style="min-width:100px; min-height:100px; max-width:11000px; max-height:10000px;"/-->
    <table class="table">
        <thead>
            <tr>
                <th>할 일</th>
                <th>기 한</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr>
                <td>{{ $task['name'] }}</td>
                <td>{{ $task['due_date'] }}</td>
            </tr>
            @endforeach
            @foreach ($tasks2 as $task)
            <tr>
                <td>{{ $task['name'] }}</td>
                <td>{{ $task['due_date'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
