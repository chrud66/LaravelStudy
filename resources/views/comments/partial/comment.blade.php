<div class="media media__item" data-id="{{ $comment->id }}">
    @include('users.partial.avatar', ['user' => $comment->author])

    <div class="media-body pl-3">
        @if($currentUser and ($comment->isAuthor() or $currentUser->isAdmin()))
            @include('comments.partial.control')
        @endif

        <h4 class="media-heading">
            <!-- Gravatar and comment generated time are presented here -->
            <a href="{{ gravatar_profile_url($comment->author->email) }}">
                {{ $comment->author->name }}
            </a>
            <small>
                {{ $comment->created_at->diffForHumans() }}
            </small>
        </h4>

        {!! markdown($comment->content) !!}

        @if($currentUser)
            <p class="text-right">
                @if (! $solved && $owner)
                    <button type="button" class="btn btn-default btn-sm btn__pick bg-white border" title="{{ __('forum.msg_pick_help') }}">
                        {!! icon('pick', false) !!}
                    </button>
                @endif
                <!-- "Reply" button is presented here -->
                <button type="button" class="btn btn-info btn-sm btn__reply">
                {!! icon('reply') !!} {{ __('common.reply') }}
                </button>
            </p>
        @endif

        @if($currentUser and ($comment->isAuthor() or $currentUser->isAdmin()))
            @include('comments.partial.edit')
        @endif

        @if ($currentUser)
            @include('comments.partial.create', ['parentId' => $comment->id])
        @endif

        @forelse ($comment->replies()->latest()->get() as $reply)
            @include('comments.partial.comment', ['comment' => $reply])
        @empty
        @endforelse
    </div>
</div>