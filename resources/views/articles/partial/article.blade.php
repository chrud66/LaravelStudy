<!-- resources/views/articles/partial/article.blade.php -->
<div class="media">
    @include('users.partial.avatar', ['user' => $article->author])

    <div class="media-body">
        <h4 class="media-heading">
            {{ $article->title }}

            <a href="{{ route('articles.show', $article->id) }}"></a>
            @if($commentCount = $article->comments->count())
                {!! icon('comments') !!} {{ $commentCount }}
            @endif

            @if($article->solution_id)
            <span class="badge">
                {!! icon('check') !!} {{ __('forum.solved') }}
            </span>
            @endif
        </h4>

        <p class="text-muted">
            <a href="{{ gravatar_profile_url($article->author->email) }}" style="margin-right: 1rem;">
                {!! icon('user') !!} {{ $article->author->name }}
            </a>
            {!! icon('clock') !!} {{ $article->created_at->diffForHumans() }}
        </p>

        @include('tags.partial.list', ['tags' => $article->tags])
    </div>
</div>