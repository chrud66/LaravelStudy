@extends('layouts.master')

@section('style')
    {!! Html::style('/css/dropzone/dropzone.css') !!}
@endsection

@section('content')
<div class="container bg-white clearfix pt-4 pb-4">
    <div class="card mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h4>PDF파일을 JPG이미지로 변환합니다.</h4>
                <h6>-이미지 변환에는 PDF의 크기에 따라 많은 시간이 소요될 수 있으므로 변환 버튼 클릭 후 잠시 기다려주세요.</h6>
            </div>
        </div>
    </div>
    <form action="{{ route('pdf-to-img.show', '') }}" method="GET" role="form" class="form__pdf">
        <div class="form-group">
            <div id="my-dropzone" class="dropzone"></div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block">
                변환 하기
            </button>
        </div>
    </form>
</div>
@endsection


@section('script')
{!! Html::script('/js/dropzone/dropzone.js') !!}
<script>
    var form = $("form.form__pdf").first(),
        dropzone  = $("div.dropzone");
        baseUrl = form.attr('action');

    Dropzone.autoDiscover = false;
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var myDropzone = new Dropzone("div#my-dropzone", {
        url: "/pdf-files",
        params: {
            _token: "{{ csrf_token() }}",
        },
        dictDefaultMessage: "<div class=\"text-center text-muted\">" +
        "<h2>PDF 파일을 끌어다 놓으세요.</h2>" +
        "<p>(또는 여기를 클릭하여 파일을 선택하세요.)</p>" +
        "<p>(1개의 PDF 파일만 업로드 하실 수 있습니다.)</p></div>",
        addRemoveLinks: true,
        acceptedFiles: "application/pdf",
        maxFiles: 1,
    });

    myDropzone.on("success", function (file, data) {
        file._id = data.id;
        file._name = data.name;
        file._url = data.url;

        form.attr('action', baseUrl + '/' + file._name);
    });

    myDropzone.on("removedfile", function(file) {
        $.ajax({
            type: "POST",
            url: "/pdf-files/" + file._id,
            data: {
                _method: "DELETE",
                _token: CSRF_TOKEN,
            }
        });
    });
</script>
@endsection