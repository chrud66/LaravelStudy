@extends('layouts.master')
@section('style') {!! Html::style('/css/dropzone/dropzone.css') !!}
@endsection

@section('content')
<div class="container bg-white clearfix pt-4 pb-4">
    <div class="card mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h4>여러장의 이미지 파일들을 하나의 PDF 파일로 변환합니다.</h4>
                <h5>이미지파일은 JPG,PNG,GIF 파일만 가능합니다.</h5>
                <h6>-PDF의 생성 시 많은 시간이 소요될 수 있으므로 변환 버튼 클릭 후 잠시 기다려주세요.</h6>
            </div>
        </div>
    </div>
    <form action="{{ route('images-to-pdf.show', '/') }}" method="GET" role="form" class="form__pdf">
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

@section('script') {!! Html::script('/js/dropzone/dropzone.js') !!}
<script>
    var $upFiles = new Array();

    var form = $("form.form__pdf").first(),
        dropzone  = $("div.dropzone");
        baseUrl = form.attr('action');

    form.submit(function () {

        if($upFiles.length <= 0) {
            flash('danger', '첨부된 이미지가 없습니다.', 2500);
            return false;
        };

        $filesJson = JSON.stringify($upFiles);

        $.ajax({
            type: "POST",
            async: false,
            dataType: "json",
            url: "/images-to-pdf",
            data: {
                _token: "{{ csrf_token() }}",
                fileList: $filesJson,
            },
            success: function (res) {
                console.log(res);
                if(res.status === 'success') {
                    window.location.href = '/images-to-pdf/' + res.pdfName;
                } else {
                    flash('danger', '알 수 없는 에러가 발생했습니다.', 2500);
                }
            },
            error: function(res, error) {
                $resTxt = JSON.parse(res.responseText);
                flash('danger', $resTxt.message, 2500);
            }
        });

        return false;
    });

    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#my-dropzone", {
        url: "/images-to-pdf/file-upload",
        parallelUploads: 1,
        params: {
            _token: "{{ csrf_token() }}",
        },
        dictDefaultMessage: "<div class=\"text-center text-muted\">" +
        "<h2>이미지 파일들을 끌어다 놓으세요.</h2>" +
        "<p>(또는 여기를 클릭하여 파일을 선택하세요.)</p>",
        addRemoveLinks: true,
        acceptedFiles: "image/png, image/jpg, image/jpeg",
    });

    myDropzone.on("success", function (file, data) {
        file._id = data.id;
        file._name = data.name;
        file._url = data.url;

        $data = new Object();
        $data.name = file._name;

        $upFiles.push($data);

        //console.log($upFiles);

        //form.attr('action', baseUrl + '/' + file._name);
    });

    myDropzone.on("removedfile", function(file) {
        $fileName = file._name;
        $.ajax({
            type: "POST",
            url: "/images-to-pdf/file-destroy",
            data: {
                _method: "DELETE",
                _token: "{{ csrf_token() }}",
                fileName: $fileName,
            },
            success: function () {
                $upFiles = $.grep($upFiles, function(value) {
                    return value.name != $fileName;
                });

                //console.log($upFiles);
            }
        });
    });
</script>
@endsection