@extends('layouts.master')

@section('style')
    {!! Html::style('/css/dropzone/dropzone.css') !!}
@endsection

@section('content')
<div class="container bg-white clearfix pt-4">
    <form action="{{ route('pdf-to-img.allDownload') }}" method="post">
        @csrf

        <div class="card text-white bg-primary">
            <div class="card-body">
                <h4>필요한 이미지를 선택하여 다운로드 받으세요.</h4>

                <button type="submit" class="btn btn-secondary btn-lg btn-block">
                    전체 이미지 다운로드 받기
                </button>
            </div>
        </div>

        <div class="card-group pt-4">
            @foreach ($arrImgName as $imgName)
            <input type="hidden" name="imgFiles[]" value="{{ $imgName }}">
            <a href="{{ route('pdf-to-img.download', $imgName) }}"  target="_blank" class="d-block h-100 mb-4">
                <div class="card">
                    <img src="{{ Storage::url('pdfs/images/' . $imgName) }}" alt="{{ $loop->iteration }} 페이지" class="card-img-top">
                    <div class="card-footer text-center">
                        {{ $loop->iteration }} 페이지 다운로드
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </form>
</div>
@endsection