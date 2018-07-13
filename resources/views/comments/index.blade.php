<!-- resources/views/comments/index.blade.php -->
<div class="container__forum">
    @if($currentUser)
        @include('comments.partial.create')
    @endif

    @forelse($comments as $comment)
        @include('comments.partial.comment', ['parentId' => $comment->id])
    @empty
    @endforelse
</div>