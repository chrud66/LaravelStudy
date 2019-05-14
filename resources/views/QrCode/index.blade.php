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
                <option value="btc">비트코인 전송</option>
                <option value="email">이메일</option>
                <option value="geo">지도</option>
                <option value="phone">전화번호</option>
                <option value="sms">문자메세지</option>
                <option value="wifi">와이파이</option>
            </select>
        </div>
        <div class="form-group">
            <label for="url">URL 링크</label>
            <input type="number" class="form-control" id="btc" aria-describedby="btcHelp" placeholder="전송할 비트코인을 입력해주세요" max="100" min="0"  step="0.0001"/>
            <small id="btcHelp" class="form-text text-muted">전송할 비트코인을 입력해주세요. example : 0.0034</small>
        </div>
        <div class="form-group">
            <label for="btc">비트코인 전송</label>
            <input type="number" class="form-control" id="btc" aria-describedby="btcHelp" placeholder="전송할 비트코인을 입력해주세요" max="100" min="0"  step="0.0001"/>
            <small id="btcHelp" class="form-text text-muted">전송할 비트코인을 입력해주세요. example : 0.0034</small>
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