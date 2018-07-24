<!-- resources/views/articles/partial/form.blade.php -->
@section('style')
    {!! Html::style('/css/dropzone/dropzone.css') !!}
@endsection

<div class="form-group {{ $errors->has('title') ? 'has-error is-invalid' : '' }}">
    <label for="title">
        {{ __('forum.title') }}
    </label>
    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $article->title) }}" placeholder="{{ __('forum.title') }}" required>

    {!! $errors->first('title', '<span class="invalid-feedback">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('content') ? 'has-error is-invalid' : '' }}">

    <a href="#" class="help-block pull-right hidden-xs" id="md-caller">
        <small>
            {!! icon('preview') !!} {{ __('common.cheat_sheet') }}
        </small>
    </a>
    <label for="content">
        {{ __('forum.content') }}
    </label>
    <textarea name="content" id="content" rows="10" class="form-control" placeholder="{{ __('forum.content') }}" required>{{ old('content', $article->content) }}</textarea>

    {!! $errors->first('content', '<span class="invalid-feedback">:message</span>') !!}

    <div class="preview__forum">{{ markdown(old('content', __('common.markdown_preview'))) }}</div>
</div>

<div class="form-group">
    <label for="my-dropzone">
        Files
        <small class="text-muted">
            Click to attach files
            <i class="fa fa-chevron-down"></i>
        </small>
        <small class="text-muted" style="display: none;">
            Click to close pane
            <i class="fa fa-chevron-up"></i>
        </small>
    </label>
    <div id="my-dropzone" class="dropzone" style="display: none;"></div>
</div>

<div class="form-group">
    <label for="tags">{{ __('forum.tags') }}</label>

    <select name="tags[]" id="tags" multiple="multiple" class="form-control" required>
        @foreach($allTags as $tag)
        <option value="{{ $tag->id }}" {!! (in_array($tag->id, $article->tags->pluck('id')->toArray()) or in_array($tag->id, old('tags', []))) ? 'selected="selected"' : ''
            !!} > {{ $tag->name }}
        </option>
        @endforeach
    </select>

    {!! $errors->first('tags', '
    <span class="invalid-feedback">:message</span>') !!}
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

@if ($currentUser and $currentUser->isAdmin())
<div class="form-group">
    <div class="checkbox">
        <label>
            <input type="checkbox" name="pin" {{ $article->pin ? 'checked="checked"' : '' }}>
            {{ __('forum.pin') }}
        </label>
    </div>
</div>
@endif

@include('layouts.partial.markdown')

@section('script')
{!! Html::script('/js/dropzone/dropzone.js') !!}
<script>
    /* Modal window for Markdown Cheatsheet */
    $("#md-caller").on("click", function(e) {
        e.preventDefault();
        $("#md-modal").modal();
        return false;
    });

    $("select#tags").select2({
        placeholder: "{{ __('forum.tags_help') }}",
        maximumSelectionLength: 3,
        dropdownAutoWidth : true,
        width: "100%"
    });

    var form = $("form.form__forum").first(),
        dropzone  = $("div.dropzone"),
        dzControl = $("label[for=my-dropzone]>small");


    dzControl.on("click", function(e) {
        dropzone.fadeToggle(0);
        dzControl.fadeToggle(0);
    });

    var oldFilesInfo = JSON.parse('{!! isset($filesInfo) ? $filesInfo : "{}" !!}');
    Dropzone.autoDiscover = false;
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var myDropzone = new Dropzone("div#my-dropzone", {
        url: "/files",
        params: {
            _token: "{{ csrf_token() }}",
            articleId: "{{ $article->id }}"
        },
        dictDefaultMessage: "<div class=\"text-center text-muted\">" +
        "<h2>{{ __('forum.msg_dropfile') }}</h2>" +
        "<p>{{ __('forum.msg_dropfile_sub') }}</p></div>",
        addRemoveLinks: true,
        init: function () {
            thisDropzone = this;
            $.each(oldFilesInfo, function (key, file) {
                var mockFile = { _id: file.id, name: file.name, _name: file.name, size: file.size, type: file.size, _url: file.url, dataURL: file.url };

                // Call the default addedfile event handler
                thisDropzone.emit("addedfile", mockFile);

                // And optionally show the thumbnail of the file:
                //thisDropzone.emit("thumbnail", mockFile, file.url);
                thisDropzone.createThumbnailFromUrl(mockFile, thisDropzone.options.thumbnailWidth, thisDropzone.options.thumbnailHeight,thisDropzone.options.thumbnailMethod, true, function (thumbnail) {
                    thisDropzone.emit('thumbnail', mockFile, thumbnail);
                });
                thisDropzone.emit('complete', mockFile);
                thisDropzone.emit('processing', mockFile);
                thisDropzone.emit('success', mockFile);

                thisDropzone.files.push(mockFile);

            });
        },
        /*headers: {
            'x-csrf-token': CSRF_TOKEN,
        },*/
    });

    var handleImage = function(objId, imgUrl, remove) {
        var caretPos = document.getElementById(objId).selectionStart;
        var textAreaTxt = $("#" + objId).val();
        var txtToAdd = "![](" + imgUrl + ")";

        if (remove) {
            return;
        };

        $("#" + objId).val(
            textAreaTxt.substring(0, caretPos) +
            txtToAdd +
            textAreaTxt.substring(caretPos)
        );
    };

    myDropzone.on("success", function (file, data) {
        file._id = data.id;
        file._name = data.name;
        file._url = data.url;

        $("<input>", {
            type: "hidden",
            name: "attachments[]",
            class: "attachments",
            value: data.id
        }).appendTo(form);

        if (/^image/.test(data.type)) {
            handleImage('content', data.url);
        };
    });

    myDropzone.on("removedfile", function(file) {
        // When user removed a file from the Dropzone UI,
        // the image will be disappear in DOM level, but not in the service
        // The following code send ajax request to the server to handle that situation
        $.ajax({
            type: "POST",
            url: "/files/" + file._id,
            data: {
                _method: "DELETE",
                _token: CSRF_TOKEN,
            },
            success: function(file, data) {
                handleImage('content', file._url, true);
            },
        });
    });
</script>
@endsection