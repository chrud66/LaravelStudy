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