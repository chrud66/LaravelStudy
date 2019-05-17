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
        <div class="center-block">
            {!! QrCode::size(500)->generate(Request::url()); !!}
        </div>

        <div class="p3">
            <a href="{{ route('qr-code.index') }}" class="btn btn-primary btn-lg btn-block">
                {!! icon('reset') !!} 돌아가기
            </a>
        </div>
    </div>
@endsection