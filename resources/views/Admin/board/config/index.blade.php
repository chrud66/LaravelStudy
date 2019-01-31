@extends('Admin.layouts.master')
@section('title')
    KCK - 게시판 설정 관리
@endsection

@section('page_title_txt')
    게시판 설정 관리
@endsection

@section('page_description_txt')
@endsection


@section('locate')
<li>{!! icon('arrow-right', 'admin-icon') !!}<a href="{{ route('admin.board.config.index') }}">게시판 설정 관리</a></li>
@endsection

@section('content')
<div class="dashboard container-fluid">
    <div class="row">
        <div class="col-sm-12 mb-5">
            <div class="card">
                <div class="card-header h1 font-weight-bold">
                    게시판 설정 관리
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>선택</th>
                                <th>번호</th>
                                <th>게시판 ID</th>
                                <th>게시판 이름</th>
                                <th>생성일</th>
                                <th>수정일</th>
                                <th>수정자</th>
                                <th>상태</th>
                                <th>수정</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="9" class="text-center">
                                    생성된 게시판이 없습니다.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection