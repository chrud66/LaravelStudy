<div class="media media__item" data-id="{{ $comment->id }}">
    @include('users.partial.avatar', ['user' => $comment->author])

    <div class="media-body">
        @if($currentUser and ($comment->isAuthor() or $currentUser->isAdmin()))
            @include('comments.partial.control')
        @endif

        <h4 class="media-heading">
            <!-- Gravatar and comment generated time are presented here -->
        </h4>
        <p>{!! markdown($comment->content) !!}</p>

        @if($currentUser)
            <p class="text-right">
                <!-- "Reply" button is presented here -->
            </p>
        @endif

        @if($currentUser and ($comment->isAuthor() or $currentUser->isAdmin()))
            @include('comments.partial.edit')
        @endif

        @if ($currentUser)
            @include('comments.partial.create', ['parentId' => $comment->id]);
        @endif

        @forelse ($comment->replies as $reply)
            @include('comments.partial.comment', ['comment' => $reply])
        @empty
        @endforelse
    </div>
</div>