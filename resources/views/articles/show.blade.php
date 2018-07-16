<!-- resources/views/articles/show.blade.php -->

@extends('layouts.master')

@section('content')
    <div class="pb-2 mt-4 mb-2 border-bottom">
        <h4>
            {!! icon('forum', null, 'margin-right:1rem') !!}
            <a href="{{ route('articles.index') }}">
                {{ __('forum.title_forum') }}
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

        <div class="col-md-9 bg-white">
            <article class="p-3">
                @include('articles.partial.article', ['article' => $article])

                @include('attachments.partial.list', ['attachments' => $article->attachments])
                <p>
                    {!! markdown($article->content) !!}
                </p>

                @if(auth()->user() and (auth()->user()->isAdmin() or $article->isAuthor()))
                <div class="text-center">
                    <form action="{{ route('articles.destroy', $article->id) }}" method="post" class="d-inline">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}

                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDelete" >
                            {!! icon('delete') !!} Delete
                        </button>


                        <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteLabel">Delete</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {{ __('common.confirm_delete') }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('common.close') }}</button>
                                        <button type="submit" class="btn btn-primary">{{ __('common.delete') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-info">
                        {!! icon('pencil') !!} Edit
                    </a>
                </div>
                @endif
            </article>

            <article class="mt-4 mb-4 p-2">
                @include('comments.index')
            </article>
        </div>
    </div>
@endsection