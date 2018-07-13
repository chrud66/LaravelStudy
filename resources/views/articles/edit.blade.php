<!-- resources/views/articles/edit.blade.php -->

@extends('layouts.master')

@section('content')
<div class="pb-2 mt-4 mb-2 border-bottom">
    <h4>
        {!! icon('forum', null, 'margin-right:1rem') !!}
        <a href="{{ route('articles.index') }}">
            {{ __('forum.title_forum') }}
        </a>
        <small> / </small>
        <a href="{{ route('articles.show', $article->id) }}">
            {{ $article->title }}
        </a>
        <small> / </small>
        Edit
    </h4>
</div>

<div class="container__forum">
    <form action="{{ route('articles.update', $article->id) }}" method="POST" role="form" class="form_forum">
        {!! csrf_field() !!}
        {!! method_field('PUT') !!}

        @include('articles.partial.form')

        <div class="form-group">
            <p class="text-center">
                <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-default">
                    {!! icon('reset') !!} Reset
                </a>
                <button type="submit" class="btn btn-primary">
                    {!! icon('plane') !!} Edit
                </button>
            </p>
        </div>
    </form>
</div>
@endsection