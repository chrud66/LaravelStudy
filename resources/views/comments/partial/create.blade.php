<!-- resources/views/comments/partial/create.blade.php -->

<div class="media media__create mb-4" style="{{ isset($parentId) ? 'display:none;' : 'display:block;' }}">
    @include('users.partial.avatar', ['user' => $currentUser])
    <div class="media-body">
        <form action="{{ route('comments.store') }}" method="post" role="form" class="form-horizontal form-create-comment">
            {!! csrf_field() !!}
            <input type="hidden" name="commentable_type" value="{{ $commentableType }}">
            <input type="hidden" name="commentable_id" value="{{ $commentableId }}">
            @if (isset($parentId))
                <input type="hidden" name="parent_id" value="{{ $parentId }}">
            @endif


            <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}" style="width:100%; margin: auto;">
                <textarea name="content" class="form-control forum__content">{{ old('content') }}</textarea>
                {!! $errors->first('content', '<span class="form-error">:message</span>') !!}
                <!--
                <div class="preview__forum">{{ markdown(old('content', __('common.markdown_preview'))) }}</div>
                -->
            </div>

            <p class="text-right" style="margin:0;">
                <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 1rem;">
                {!! icon('plane') !!} {{ __('common.post') }}
                </button>
            </p>
            <!-- Other HTML form Tag -->
        </form>
    </div>
</div>