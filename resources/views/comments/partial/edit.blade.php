<!-- resources/views/comments/partial/edit.blade.php -->

<div class="media media__edit mb-4 border-bottom">
    <div class="media-body">
        <form action="{{ route('comments.update', $comment->id) }}" method="post" role="form" class="form-horizontal">
            {!! csrf_field() !!}
            {!! method_field('PUT') !!}

            <div class="form-group" style="width: 100%; margin: auto;">
                <textarea name="content" class="form-control" style="width: 100%; padding: 1rem;">{{ old('content', $comment->content) }}</textarea>
            </div>

            <p class="text-right">
                <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 1rem;">
                    {!! icon('plane') !!} Edit
                </button>
            </p>
        </form>
    </div>
</div>