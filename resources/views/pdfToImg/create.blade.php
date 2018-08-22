@extends('layouts.master')

@section('style')
    {!! Html::style('/css/dropzone/dropzone.css') !!}
@endsection

@section('content')
<form action="{{ route('pdf-to-img.store') }}" method="POST" role="form" class="form__pdf">
    {!! csrf_field() !!}

    <div class="form-group">
        <div id="my-dropzone" class="dropzone"></div>
    </div>
</form>
@endsection


@section('script')
{!! Html::script('/js/dropzone/dropzone.js') !!}
<script>
    var form = $("form.form__pdf").first(),
        dropzone  = $("div.dropzone");

    Dropzone.autoDiscover = false;
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var myDropzone = new Dropzone("div#my-dropzone", {
        url: "/pdf-files",
        params: {
            _token: "{{ csrf_token() }}",
        },
        dictDefaultMessage: "<div class=\"text-center text-muted\">" +
        "<h2>PDF 파일을 끌어다 놓으세요.</h2>" +
        "<p>(또는 여기를 클릭하여 파일을 선택하세요.)</p></div>",
        addRemoveLinks: true,
        acceptedFiles: "application/pdf",
    });

    myDropzone.on("success", function (file, data) {
        file._id = data.id;
        file._name = data.name;
        file._url = data.url;

        console.log(data);
    });
</script>
@endsection