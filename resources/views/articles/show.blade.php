<!-- resources/views/articles/show.blade.php -->

@extends('layouts.master')

@section('content')
    <div class="pb-2 mt-4 mb-2 border-bottom">
        <h4>
            {!! icon('forum', null, 'margin-right:1rem') !!}
            <a href="{{ route('articles.index') }}">
                {{ trans('forum.title_forum') }}
            </a>
            <small> / </small>
            {{ $article->title }}
        </h4>
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
                @include('articles.partial.article', ['article' => $article])

                <p>
                    {!! markdown($article->count) !!}
                </p>

                @if(auth()->user()->isAdmin() or $article->isAuthor())
                <div class="text-center">
                    <form action="{{ route('artivles.destroy', $article->id) }}" method="post">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}

                        <button type="submit" class="btn btn-danger">
                            {!! icon('delete') !!} Delete
                        </button>
                    </form>
                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-info">
                        {!! icon('pencil') !!} Edit
                    </a>
                </div>
                @endif
            </article>

            <article>
                Comment here
            </article>
        </div>
    </div>
@endsection