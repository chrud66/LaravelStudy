<!-- resources/views/articles/index.blade.php -->
@extends('layouts.master')

@section('content')
    <div class="pb-2 mt-4 mb-2 border-bottom">
        <h4>
            Forum
        </h4>

        <a href="{{ route('articles.create') }}" class="btn btn-primary pull-right">
            {!! icon('forum') !!} {{ __('forum.create') }}
        </a>
    </div>

    <div class="row container__forum">
        <div class="col-md-3 sidebar__forum">
            <aside>
                @include('layouts.partial.search')
                @include('tags.partial.index')
            </aside>
        </div>

        <div class="col-md-9">
            <article>
                @forelse($articles as $article)
                    @include('articles.partial.article', ['article' => $article])
                @empty
                    <p class="text-center">
                        {{ __('errors.not_found_description') }}
                    </p>
                @endforelse

                <div class="text-center">
                    {!! $articles->appends(Request::except('page'))->render() !!}
                </div>
            </article>
        </div>
    </div>
@endsection