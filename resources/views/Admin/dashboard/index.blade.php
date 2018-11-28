@extends('Admin.layouts.master')

@section('page_title_txt')
    대시보드
@endsection

@section('page_description_txt')
@endsection

@section('locate')
    <li>{!! icon('arrow-right', 'admin-icon') !!}<a href="{{ route('admin.dashboard') }}">대시보드</a></li>
@endsection

@section('content')
<div class="dashboard container-fluid">
    <div class="row">
        <div class="col-md-6 col-xs-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title h1 font-weight-bold">시스템 정보</h5>
                    <p class="card-text">
                        <ul>
                            <li>
                                WebServer : {{ $_SERVER['SERVER_SOFTWARE'] }}
                            </li>
                            <li>
                                PHP Version : {{ (float)phpversion() }}
                            </li>
                            <li>
                                Debug Mode : {{ config('app.debug') ? 'TRUE' : 'FALSE' }}
                            </li>
                            <li>
                                Cache Driver : {{ config('cache.default') }}
                            </li>
                            <li>
                                Document Root : {{ $_SERVER["DOCUMENT_ROOT"] }}
                            </li>
                            <li>
                                Maintenance : {{ app()->isDownForMaintenance() ? 'On':'Off' }}
                            </li>
                            <li>
                                TimeZone : {{ config('app.timezone') }}
                            </li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title h1 font-weight-bold">디스크 정보</h5>
                    <p class="card-text">
                        <ul>
                            <li>
                                전체 용량 : {{ $storageData['total'] }}
                            </li>
                            <li>
                                사용 용량 : {{ $storageData['use'] }}
                            </li>
                            <li>
                                남은 용량 : {{ $storageData['free'] }}
                            </li>
                            <li>
                                사용 퍼센트 : {{ $storageData['percentUse'] }}
                            </li>
                            <li>
                                남은 퍼센트 : {{ $storageData['percentFree'] }}
                            </li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title h1 font-weight-bold">주간 접속자</h5>
                    <p class="card-text">
                        text
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title h1 font-weight-bold">신규 등록글</h5>
                    <p class="card-text">
                        text
                    </p><p class="card-text">
                        text
                    </p><p class="card-text">
                        text
                    </p><p class="card-text">
                        text
                    </p><p class="card-text">
                        text
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection