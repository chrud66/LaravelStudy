<!-- resources/views/articles/create.blade.php -->
@extends('layouts.master')

@section('content')
<div class="pb-2 mt-4 mb-2 border-bottom">
    <h4>
        {!! icon('forum', null, 'margin-right:1rem') !!}
        <a href="{{ route('articles.index') }}">
            {{ __('forum.title_forum') }}
        </a>
        <small> / </small>
        {{ __('forum.create') }}
    </h4>
</div>

<div class="container__forum">
    <form action="{{ route('articles.store') }}" method="POST" role="form" class="form__forum">
        {!! csrf_field() !!}

        @include('articles.partial.form')

        <div class="form-group">
            <p class="text-center">
                <a href="{{ route('articles.create') }}" class="btn btn-default">
                    {!! icon('reset') !!} {{ __('common.reset') }}
                </a>

                <button type="submit" class="btn btn-primary my-submit">
                    {!! icon('plane') !!} {{ __('common.post') }}
                </button>
            </p>
        </div>
    </form>
</div>
@endsection