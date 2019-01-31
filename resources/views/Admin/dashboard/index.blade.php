@extends('Admin.layouts.master')

@section('page_title_txt')
    대시보드
@endsection

@section('page_description_txt')
@endsection

@section('locate')
    <li>{!! icon('arrow-right', 'admin-icon') !!}<a href="{{ route('admin.dashboard.index') }}">대시보드</a></li>
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
                                <button type="button" id="redo-user-chart" class="btn btn-outline-dark btn-lg">{!! icon('redo', 'admin-icon') !!}</button>
                                <div class="card-text">
                                    <canvas id="user-chart"></canvas>
                                    <h5 class="pt-4 card-title h1 text-center font-weight-bold">유저 현황</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <button type="button" id="redo-site-chart" class="btn btn-outline-dark btn-lg">{!! icon('redo', 'admin-icon') !!}</button>
                                <div class="card-text">
                                    <canvas id="site-chart"></canvas>
                                    <h5 class="pt-4 card-title h1 text-center font-weight-bold">접속 유형</h5>
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

                    <div class="pt-4">
                        <button type="button" id="redo-connector-chart" class="btn btn-outline-dark btn-lg">{!! icon('redo', 'admin-icon') !!}</button>

                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary active btn-lg">
                                <input type="radio" name="chartOptions" id="day" value="day">
                                일별
                            </label>
                            <label class="btn btn-secondary btn-lg">
                                <input type="radio" name="chartOptions" id="month" value="month">
                                월별
                            </label>
                            <label class="btn btn-secondary btn-lg">
                                <input type="radio" name="chartOptions" id="year" value="year">
                                연도별
                            </label>
                        </div>
                    </div>

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
        data: [0, 0],
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

var getUserData = function(redoFlag) {
    $.ajax({
        url: '{{ route("admin.dashboard.userChartData") }}',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            newUserChart.data.datasets[0].data = data;
            newUserChart.update();
            dataGetSuccess(redoFlag);
            btnRemoveClass(redoUserBtnId, btnRotateClass);
        },
        error: function() {
            dataGetFail(redoFlag);
            btnRemoveClass(redoUserBtnId, btnRotateClass);
        }
    });
};

var siteCtx = $('#site-chart');
var siteData = {
    labels: ['직접 접속','기타 접속'],
    datasets: [{
        data: [0, 0],
        backgroundColor: ['#1ca8dd', '#1bc98e']
    }]
};

var newSiteChart = new Chart(siteCtx, {
    type: 'doughnut',
    data: siteData,
    options: {
        legend: {
            display: false,
        }
    }
});

var getSiteData = function(redoFlag) {
    $.ajax({
        url: '{{ route("admin.dashboard.siteChartData") }}',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            newSiteChart.data.datasets[0].data = data;
            newSiteChart.update();
            dataGetSuccess(redoFlag);
            btnRemoveClass(redoSiteBtnId, btnRotateClass);
        },
        error: function() {
            dataGetFail(redoFlag);
            btnRemoveClass(redoSiteBtnId, btnRotateClass);
        }
    });
};

var connectorCtx = $('#connector-chart');
var connectorData = {
    labels: ['', '', '', '', '', '', ''],
    datasets: [{
        data: [0, 0, 0, 0, 0, 0, 0],
        backgroundColor: ['#1ca8dd', '#1bc98e', '#FCA8DD', '#8041D9', '#4C4C4C', '#6799FF', '#FAED7D']
    }]
};

var newConnectorChart = new Chart(connectorCtx, {
    type: 'bar',
    data: connectorData,
    options: {
        legend: {
            display: false,
        },
        scales: {
            yAxes: [{
                display: true,
                ticks: {
                    suggestedMin: 0,
                    beginAtZero: true
                }
            }]
        }
    }
});

var getConnectorData = function(redoFlag, chartOption) {
    $.ajax({
        url: '{{ route("admin.dashboard.connectorChartData") }}',
        method: 'GET',
        data: 'chartOption=' + chartOption,
        dataType: 'json',
        success: function(data) {
            newConnectorChart.data.labels = data.labels;
            newConnectorChart.data.datasets[0].data = data.datas;
            newConnectorChart.update();
            dataGetSuccess(redoFlag);
            btnRemoveClass(redoConnectorBtnId, btnRotateClass);
        },
        error: function() {
            dataGetFail(redoFlag);
            btnRemoveClass(redoConnectorBtnId, btnRotateClass);
        }
    });
};

var dataGetSuccess = function(redoFlag) {
    if(redoFlag) {
        flash('success', '새로고침 되었습니다.', '3000');
    }
};

var dataGetFail = function(redoFlag) {
    flash('danger', '차트 데이터를 받아오는데 실패하였습니다. 다시 시도해주세요.', '3000');
}

var btnRemoveClass = function(targetId, targetClass) {
    $('#'+targetId).removeClass(targetClass);
};

var btnAddClass = function(targetId, targetClass) {
    $('#'+targetId).addClass(targetClass);
}

var checkRunRedo = function(targetId, targetClass) {
    if($('#'+targetId).hasClass(targetClass)) {
        return false;
    };
    return true;
}

$('#'+redoUserBtnId).click(function () {
    if(checkRunRedo(redoUserBtnId, btnRotateClass)) {
        btnAddClass(redoUserBtnId, btnRotateClass);
        getUserData(true);
    };
});

$('#'+redoSiteBtnId).click(function () {
    if(checkRunRedo(redoSiteBtnId, btnRotateClass)) {
        btnAddClass(redoSiteBtnId, btnRotateClass);
        getSiteData(true);
    };
});

$('#'+redoConnectorBtnId).click(function () {
    if(checkRunRedo(redoConnectorBtnId, btnRotateClass)) {
        btnAddClass(redoConnectorBtnId, btnRotateClass);
        getConnectorData(true, $(this).parent().find('label.active > input').val());
    };
});

$('input[name="chartOptions"]').change(function () {
    if(checkRunRedo(redoConnectorBtnId, btnRotateClass)) {
        btnAddClass(redoConnectorBtnId, btnRotateClass);
        getConnectorData(true, $(this).val());
    };
});

getUserData(false);
getSiteData(false);
getConnectorData(false, '');
</script>
@endsection