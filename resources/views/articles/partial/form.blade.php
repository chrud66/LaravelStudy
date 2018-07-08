<!-- resources/views/articles/partial/form.blade.php -->

<div class="form-group">
    <label for="title">
        {{ __('forum.title') }}
    </label>
    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $article->title) }}">

    {!! $errors->first('title', '<span class="invalid-feedback">:message</span>') !!}
</div>

<div class="form-group">
    <label for="content">
        {{ __('forum.content') }}
    </label>
    <textarea name="content" id="content" rows="10" class="form-control">{{ old('content', $article->content) }}</textarea>

    {!! $errors->first('content', '<span class="invalid-feedback">:message</span>') !!}
</div>

<div class="form-group">
    @include('articles.partial.tagselector')
</div>

<div class="form-group">
    <div class="checkbox">
        <label>
            <input type="checkbox" name="notification" {{ $article->notification == 0 ?: 'checked' }} value="1">

            {{ __('forum.notification') }}
        </label>
    </div>
</div>