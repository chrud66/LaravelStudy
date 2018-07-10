<!-- resources/views/articles/partial/form.blade.php -->
@section('style')
    {!! Html::style('/css/dropzone/dropzone.css') !!}
@endsection
<div class="form-group">
    <label for="title">
        {{ __('forum.title') }}
    </label>
    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $article->title) }}" placeholder="{{ __('forum.title') }}">

    {!! $errors->first('title', '<span class="invalid-feedback">:message</span>') !!}
</div>

<div class="form-group">
    <label for="content">
        {{ __('forum.content') }}
    </label>
    <textarea name="content" id="content" rows="10" class="form-control" placeholder="{{ __('forum.content') }}">{{ old('content', $article->content) }}</textarea>

    {!! $errors->first('content', '<span class="invalid-feedback">:message</span>') !!}
</div>

<div class="form-group">
    <label for="my-dropzone">Files</label>
    <div id="my-dropzone" class="dropzone"></div>
</div>

<div class="form-group">
    <label for="tags">{{ __('forum.tags') }}</label>

    <select name="tags[]" id="tags" multiple="multiple" class="form-control">
        @foreach($allTags as $tag)
        <option value="{{ $tag->id }}" {!! (in_array($tag->id, $article->tags->pluck('id')->toArray()) or in_array($tag->id, old('tags', []))) ? 'selected="selected"' : ''
            !!} > {{ $tag->name }}
        </option>
        @endforeach
    </select>

    {!! $errors->first('tags', '
    <span class="form-error">:message</span>') !!}
</div>

<div class="form-group">
    <div class="checkbox">
        <label>
            <input type="checkbox" name="notification"
            @if ($article->notification == 1 or old('notification') == 1) checked @endif value="1">

            {{ __('forum.notification') }}
        </label>
    </div>
</div>

@section('script')
{!! Html::script('/js/dropzone/dropzone.js') !!}
<script>
    $("select#tags").select2({
        placeholder: "{{ __('forum.tags_help') }}",
        maximumSelectionLength: 3,
        dropdownAutoWidth : true,
        width: "100%"
    });

    var form = $("form.form__forum").first(),
        dropzone  = $("div.dropzone"),
        dzControl = $("label[for=my-dropzone]>small");

    Dropzone.autoDiscover = false;
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var myDropzone = new Dropzone("div#my-dropzone", {
        url: "/files",
        headers: {
            'x-csrf-token': CSRF_TOKEN,
        },
    });

    myDropzone.on("success", function (file, data) {
        $("<input>", {
            type: "hidden",
            name: "attachments[]",
            class: "attachments",
            value: data.id
        }).appendTo(form);
    });
</script>
@endsection