@extends('layouts.master')

@section('content')
<div class="pb-2 mt-4 mb-2 border-bottom">
    <h4>
        {!! icon('qr_code', null, 'margin-right:0.5rem') !!}
        <a href="{{ route('qr-code.index') }}">
            QR-Code 생성기
        </a>
    </h4>
</div>

<div class="container__forum">
    <form action="{{ route('articles.store') }}" method="POST" role="form" class="form__forum">
        {!! csrf_field() !!}

        <div class="form-group">
            <label for="qr-type">QR-Code 타입</label>
            <select name="qr-type" id="qr-type" class="form-control">
                <option value="url" selected="selected">URL 링크</option>
                <option value="email">이메일</option>
                <option value="geo">지도</option>
                <option value="phone">전화번호</option>
                <option value="sms">문자메세지</option>
                <option value="wifi">와이파이</option>
            </select>
        </div>
        <div class="form-group">
            <label for="url">URL 링크</label>
            <input type="url" class="form-control" id="url" aria-describedby="urlHelp" placeholder="URL을 입력해주세요" required/>
            <small id="urlHelp" class="form-text text-muted">URL을 입력하세요. example : http://www.naver.com</small>
        </div>
        <div class="form-group">
            <label for="email">이메일</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="이메일을 입력해주세요" required/>
            <small id="emailHelp" class="form-text text-muted">이메일을 입력하세요. example : abcd@gmail.com</small>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col">
                    <label for="geo1">위도</label>
                    <input type="number" class="form-control" id="geo1" aria-describedby="geo1Help" placeholder="위도를 입력해주세요" required/>
                    <small id="geo1Help" class="form-text text-muted">위도를 입력하세요. example : 37.822214</small>
                </div>
                <div class="col">
                    <label for="geo2">경도</label>
                    <input type="number" class="form-control" id="geo2" aria-describedby="geo2Help" placeholder="경도를 입력해주세요" required/>
                    <small id="geo2Help" class="form-text text-muted">경도를 입력하세요. example : -122.481769</small>
                </div>

            </div>
        </div>
        <div class="form-group">
            <label for="phone">전화번호</label>
            <input type="tel" class="form-control" id="phone" aria-describedby="phoneHelp" placeholder="전화번호를 입력해주세요" required/>
            <small id="phoneHelp" class="form-text text-muted">전화번호를 입력하세요. example : 010-1234-5678</small>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col">
                    <label for="sms1">문자메세지 번호</label>
                    <input type="tel" class="form-control" id="sms1" aria-describedby="sms1Help" placeholder="문자를 보낼 번호를 입력하세요" required/>
                    <small id="sms1Help" class="form-text text-muted">문자를 보낼 번호를 입력하세요. example : 010-1234-5678</small>
                </div>
                <div class="col">
                    <label for="sms2">문자메세지 내용</label>
                    <input type="text" class="form-control" id="sms2" aria-describedby="sms2Help" placeholder="문자메세지 내용을 입력해주세요" required/>
                    <small id="sms2Help" class="form-text text-muted">문자메세지 내용을 입력하세요.</small>
                </div>

            </div>
        </div>
        <div class="form-group">
            <label for="sms">문자메세지</label>
            <input type="tel" class="form-control" id="sms" aria-describedby="smsHelp" placeholder="전화번호를 입력해주세요" required/>
            <small id="phoneHelp" class="form-text text-muted">전화번호를 입력하세요. example : 010-1234-5678</small>
        </div>


        <div class="form-group">
            <p class="text-center">
                <a href="{{ route('qr-code.index') }}" class="btn btn-default">
                    {!! icon('reset') !!} {{ __('common.reset') }}
                </a>

                <button type="submit" class="btn btn-primary my-submit">
                    {!! icon('plane') !!} {{ __('common.post') }}
                </button>
            </p>
        </div>
    </form>
</div>
@endsection