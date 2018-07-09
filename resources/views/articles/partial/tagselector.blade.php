<!-- resources/views/articles/partial/tagselector.blade.php -->

<div class="form-group">
    <label for="tags">{{ __('forum.tags') }}</label>
    <select name="tags[]" id="tags" multiple="multiple" class="form-control">
        @foreach($allTags as $tag)
        <option value="{{ $tag->id }}" {!! in_array($tag->id, $article->tags->pluck('id')->toArray()) ? 'select="select"' : '' !!} >
            {{ $tag->name }}
        </option>
        @endforeach
    </select>

    {!! $errors->first('tags', '<span class="form-error">:message</span>') !!}
</div>
@section('script')
<script>
    /*
    $("select#tags").select2({
    placeholder: "{{ __('forum.tags_help') }}",
    maximumSelectionLength: 3
    });
    */
</script>
@stop