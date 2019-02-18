@extends('Admin.layouts.master')

@section('title')
    KCK - 게시판 설정 관리 > 게시판 생성
@endsection

@section('page_title_txt')
    게시판 설정 관리 > 게시판 생성
@endsection

@section('page_description_txt')
    신규 게시판을 생성합니다.
@endsection

@section('locate')
<li>{!! icon('arrow-right', 'admin-icon') !!}<a href="{{ route('admin.board.config.index') }}">게시판 설정 관리</a></li>
<li>{!! icon('arrow-right', 'admin-icon') !!}<a href="{{ route('admin.board.config.create') }}">게시판 생성</a></li>
@endsection

@section('content')
<div class="dashboard container-fluid">
    <div class="row">
        <div class="col-sm-12 mb-5">
            <div class="card">
                <form action="{{ route('admin.board.config.store') }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="boardId" class="col-sm-2 col-form-label">게시판 ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="boardId" name="boardId" placeholder="게시판 ID">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="boardName" class="col-sm-2 col-form-label">게시판 이름</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="boardName" name="boardName" placeholder="게시판 이름">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="게시판 유형" class="col-sm-2 col-form-label">게시판 Type</label>
                        <div class="col-sm-10">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="boardList" name="boardType" class="custom-control-input" value="1">
                                <label class="custom-control-label" for="boardList">리스트형 게시판</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="boardGallery" name="boardType" class="custom-control-input" value="2">
                                <label class="custom-control-label" for="boardGallery">겔러리형 게시판</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection