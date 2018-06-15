@extends('layouts.master')
@section('title')
     테스크 리스트 - 이거(Eager)로딩 테스트
@endsection

@section('content')
    <h1>List of Tasks</h1>
    <hr>
    <ul>
        @forelse($tasks as $task)
        <li>
            {{ $task->name }}
            <small>
                by {{ $task->project->name }}
            </small>
        </li>
        @empty
            <p>There is no article!</p>
        @endforelse
    </ul>
    @if($tasks)
    <div class="text-center">
        {!! $tasks->render() !!}
    </div>
    @endif
@endsection