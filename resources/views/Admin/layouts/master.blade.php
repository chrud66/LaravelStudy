<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title')</title>

    <link rel="stylesheet" href="{{ mix('css/admin/admin.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    <style>
        body {
            min-width: 400px;
        }
    </style>
    @yield('style')
    @yield('style2')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('topScript')
    @yield('topScript2')
</head>

<body class="admin-body">
    <div class="admin-wrap">
        @include('Admin.layouts.partial.header')
        @include('Admin.layouts.partial.navigation')
        @include('layouts.partial.flash_message')

        <div class="transition" id="content">
            <div class="ct">
                <div class="title-area container-fluid">
                    @section('page_head')
                    <div class="row">
                        <div class="col-sm-12">
                            @section('page_title')
                                <h2>
                                    @section('page_title_txt')
                                        관리자 페이지
                                    @show
                                </h2>
                            @show
                            @section('page_description')
                                <small>
                                    @section('page_description_txt')
                                        관리자 페이지 설명
                                    @show
                                </small>
                            @show
                        </div>
                    </div>
                    <div class="row locate">
                        <div class="col-sm-12">
                            <ul>
                                <li>
                                    <a href="{{ route('admin.') }}">Home</a>
                                </li>
                                @section('locate')
                                @show
                                @yield('add_locate')
                            </ul>
                        </div>
                    </div>
                    @show
                </div>

                <div class="container">
                    @yield('content')
                </div>
            </div>
        </div>
        @include('Admin.layouts.partial.footer')
    </div>
    <div class="dim"></div>
    <script src="{{ mix('js/admin/admin.js') }}"></script>
    <script src="{{ mix('js/allscripts.js') }}"></script>
    @yield('script')
    @yield('script2')
</body>

</html>