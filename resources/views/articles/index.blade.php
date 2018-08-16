<!-- resources/views/articles/index.blade.php -->
@extends('layouts.master')

@section('content')
    <div class="pb-2 mt-4 mb-2 border-bottom clearfix">
        <h4 class="float-left">
            {{ __('forum.title_forum') }}
        </h4>

        <a href="{{ route('articles.create') }}" class="btn btn-primary float-right">
            {!! icon('forum') !!} {{ __('forum.create') }}
        </a>

        <div class="btn-group float-right sort__forum">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                {!! icon('sort') !!} Sort by <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                @foreach (['created_at' => 'Age' , 'view_count' => 'View'] as $column => $name)
                <li class="dropdown-item {{ Request::input('s') == $column ? 'active' : '' }}">
                    {!! link_for_sort($column, $name) !!}
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="row container__forum">
        <div class="col-md-3 sidebar__forum">
            <aside>
                @include('articles.partial.search')
                @include('tags.partial.index')
            </aside>
        </div>

        <div class="col-md-9">
            <article>
                <ul class="list-unstyled mt-3">
                    @forelse($articles as $article)
                        <li class="mb-3 border-bottom">
                            @include('articles.partial.article', ['article' => $article])
                        </li>
                    @empty
                        <li>
                            <p class="text-center">
                                {{ __('errors.not_found_description') }}
                            </p>
                        </li>
                    @endforelse

                <div class="text-center">
                    {!! $articles->appends(Request::except('page'))->render() !!}
                </div>
            </article>
        </div>
    </div>

    <div class="nav__forum">
        <a type="button" role="button" class="btn btn-sm btn-danger text-white">{{ __('forum.button_toc') }}</a>
    </div>
@endsection

@section('script')
<script>
    $('.pagination').addClass('justify-content-center');
</script>
@endsection