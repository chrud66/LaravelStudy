@extends('layouts.master')

@section('style')
    {!! Html::style('/css/dropzone/dropzone.css') !!}
@endsection

@section('content')
<div class="container bg-white clearfix pt-4">
    <form action="{{ route('pdf-to-img.allDownload') }}" method="post">
        @csrf

        <div class="card text-white bg-primary mb-4">
            <div class="card-body">
                <h4>필요한 이미지를 선택하여 다운로드 받거나 아래 버튼을 클릭하여 모든 이미지를 다운받을 수 있습니다.</h4>

                <button type="submit" class="btn btn-secondary btn-lg btn-block">
                    전체 이미지 다운로드 받기
                </button>
            </div>
        </div>

        <div class="row">
            @foreach ($arrImgName as $imgName)
            <input type="hidden" name="imgFiles[]" value="{{ $imgName }}">
            <div class="col-sm-4 mb-4">
                <div class="card">
                    <a href="{{ route('pdf-to-img.download', $imgName) }}"  target="_blank" class="d-block h-100">
                        <img src="{{ Storage::url('pdfs/images/' . $imgName) }}" alt="{{ $loop->iteration }} 페이지" class="card-img-top">
                        <div class="card-footer text-center">
                            {{ $loop->iteration }} 페이지 다운로드
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </form>
</div>
@endsection