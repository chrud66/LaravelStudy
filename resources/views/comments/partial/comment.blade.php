@if ($isTrashed and ! $hasChild)

<!-- A trashed item but has no child -->

@elseif ($isTrashed and $hasChild)

    <div class="media media__item" data-id="{{ $comment->id }}">
        @include('users.partial.avatar', ['user' => $comment->author])

        <div class="media-body pl-3">
            <h4 class="media-heading">
                <span class="text-muted">???</span>
                <small>
                    {{ $comment->deleted_at->diffForHumans() }}
                </small>
            </h4>
            <p class="text-danger">{{ __('forum.deleted_comment') }}</p>

            @forelse ($comment->replies()->get() as $reply)
                @include('comments.partial.comment', [
                        'comment' => $reply,
                        'isReply'   => true,
                        'hasChild'  => count($reply->replies),
                        'isTrashed' => $reply->trashed()
                    ])
            @empty
            @endforelse
        </div>
    </div>
@else

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
            <div>
                <div class="clearfix">
                    <div class="btn-group pull-left" role="group">
                        <?php $voted = $comment->votes->contains('user_id', $currentUser->id); ?>
                        <button type="button" class="btn btn-default btn-sm btn__vote border bg-white" data-vote="up" title="Vote up" @if ($voted) {{ 'disabled="disabled"' }} @endif>
                            {!! icon('up', false) !!} <span>{{ $comment->up_count }}</span>
                        </button>

                        <button type="button" class="btn btn-default btn-sm btn__vote border bg-white" data-vote="down" title="Vote down" @if ($voted) {{ 'disabled="disabled"' }} @endif>
                            {!! icon('down', false) !!} <span>{{ $comment->down_count }}</span>
                        </button>
                    </div>

                    <div class="pull-right text-right">
                        @if (! $solved && $owner)
                        <button type="button" class="btn btn-default btn-sm btn__pick bg-white border" title="{{ __('forum.msg_pick_help') }}">
                            {!! icon('pick', false) !!}
                        </button>
                        @endif
                        <!-- "Reply" button is presented here -->
                        <button type="button" class="btn btn-info btn-sm btn__reply">
                        {!! icon('reply') !!} {{ __('common.reply') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if($currentUser and ($comment->isAuthor() or $currentUser->isAdmin()))
            @include('comments.partial.edit')
        @endif

        @if ($currentUser)
            @include('comments.partial.create', ['parentId' => $comment->id])
        @endif

        @forelse ($comment->replies()->get() as $reply)
            @include('comments.partial.comment', [
                'comment' => $reply,
                'isReply'   => true,
                'hasChild'  => count($reply->replies),
                'isTrashed' => $reply->trashed()
            ])
        @empty
        @endforelse
    </div>
</div>
@endif