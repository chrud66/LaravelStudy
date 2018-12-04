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
        <div class="col-md-12 col-xs-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title h1 font-weight-bold">
                        통계
                    </h4>
                    <small class="text-info">
                        기능구현을 위해 랜덤값을 적용하였습니다.
                    </small>
                    <div class="card-deck pt-4">
                        <div class="card">
                            <div class="card-body">
                                <button type="button" id="redo-user-chart" class="btn btn-outline-dark">{!! icon('redo', 'admin-icon') !!}</button>
                                <div class="card-text">
                                    <canvas id="user-chart"></canvas>
                                    <h5 class="pt-4 card-title h1 text-center font-weight-bold">유저 현황</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <button type="button" id="redo-site-chart" class="btn btn-outline-dark">{!! icon('redo', 'admin-icon') !!}</button>
                                <div class="card-text">
                                    <canvas id="site-chart"></canvas>
                                    <h5 class="pt-4 card-title h1 text-center font-weight-bold">접속자 통계</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title h1 font-weight-bold">
                        접속자 통계
                    </h4>
                    <small class="text-info">
                        기능구현을 위해 랜덤값을 적용하였습니다.
                    </small>

                    <button type="button" id="redo-connector-chart" class="btn btn-outline-dark">{!! icon('redo', 'admin-icon') !!}</button>

                    <div class="card-text pt-4">
                        <canvas id="connector-chart"></canvas>
                        <h5 class="pt-4 card-title h1 text-center font-weight-bold">접속자 통계</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="/js/chart/Chart.min.js"></script>
<script>
const redoUserBtnId = 'redo-user-chart';
const redoSiteBtnId = 'redo-site-chart';
const redoConnectorBtnId = 'redo-connector-chart';
const btnRotateClass = 'btn-rotate';

var userCtx = $('#user-chart');
var userChartData = {
    labels: [ '신규 회원','탈퇴 회원'],
    datasets: [{
        data: [10, 20],
        backgroundColor: ['#1ca8dd', '#1bc98e']
    }]
};


var newUserChart = new Chart(userCtx, {
    type: 'doughnut',
    data: userChartData,
    options: {
        legend: {
            display: false,
        }
    }
});

var siteCtx = $('#site-chart');
var siteData = {
    labels: [ '직접 접속','기타 접속'],
    datasets: [{
        data: [100, 2000],
        backgroundColor: ['#1ca8dd', '#1bc98e']
    }]
}

var newSiteChart = new Chart(siteCtx, {
    type: 'doughnut',
    data: siteData,
    options: {
        legend: {
            display: false,
        }
    }
});

var connectorCtx = $('#connector-chart');
var connectorData = {
    labels: ['2018-11-28', '2018-11-29', '2018-11-30', '2018-12-01', '2018-12-02', '2018-12-04', '2018-12-04'],
    datasets: [{
        data: [100, 1344, 234, 560, 923, 548, 145],
        backgroundColor: ['#1ca8dd', '#1bc98e', '#FCA8DD', '#8041D9', '#4C4C4C', '#6799FF', '#FAED7D']
    }]
}

var newConnectorChart = new Chart(connectorCtx, {
    type: 'bar',
    data: connectorData,
    options: {
        legend: {
            display: false,
        }
    }
})



var getUserData = function(redoFlag) {
    $.ajax({
        url: '/Admin/dashboard/get-user-data',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data);

            if(redoFlag) {
                flash('success', '새로고침 되었습니다.', '3000');
            }
            btnRemoveClass(redoUserBtnId, btnRotateClass);
        },
        error: function() {
            flash('danger', '데이터를 받아오는데 실패하였습니다. 다시 시도해주세요.', '3000');;
            btnRemoveClass(redoUserBtnId, btnRotateClass);
        }
    });
};

var btnRemoveClass = function(targetId, targetClass) {
    $('#'+targetId).removeClass(targetClass);
};

var btnAddClass = function(targetId, targetClass) {
    $('#'+targetId).addClass(targetClass);
}

$('#redo-user-chart').click(function () {
    btnAddClass(redoUserBtnId, btnRotateClass);
    getUserData(true);
});

getUserData(false);
//getSiteData();
//getConnectorData();


</script>
@endsection