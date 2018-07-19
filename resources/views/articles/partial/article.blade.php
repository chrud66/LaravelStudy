<!-- resources/views/articles/partial/article.blade.php -->
<div class="media ">
    @include('users.partial.avatar', ['user' => $article->author])

    <div class="media-body pl-3">
        <h4 class="media-heading">
            <a href="{{ route('articles.show', $article->id) }}">
                {{ $article->title }}

                @if($commentCount = $article->comments->count())
                    {!! icon('comments') !!} {{ $commentCount }}
                @endif

                @if($article->solution_id)
                <span class="badge">
                    {!! icon('check') !!} {{ __('forum.solved') }}
                </span>
                @endif
            </a>
        </h4>

        <p class="text-muted mb-0">
            <a href="{{ gravatar_profile_url($article->author->email) }}" style="margin-right: 1rem;">
                {!! icon('user') !!} {{ $article->author->name }}
            </a>
            <span style="margin-right: 1rem;">
                {!! icon('clock') !!} {{ $article->created_at->diffForHumans() }}
            </span>

            <span style="margin-right: 1rem;">
                {!! icon('view_count') !!} {{ number_format($article->view_count) }}
            </span>
        </p>

        @include('tags.partial.list', ['tags' => $article->tags])
    </div>
</div>