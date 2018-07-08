<!-- resources/views/articles/index.blade.php -->
@extends('layouts.master')

@section('content')
    <div class="pb-2 mt-4 mb-2 border-bottom clearfix">
        <h4 class="pull-left">
            {{ __('forum.title_forum') }}
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
                <ul class="list-unstyled mt-3">
                    @forelse($articles as $article)
                        <li class="mb-3 border-bottom pb-3">
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
@endsection

@section('script')
<script>
    $('.pagination').addClass('justify-content-center');
</script>
@endsection