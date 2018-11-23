<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title')</title>

    <link rel="stylesheet" href="{{ mix('css/admin.css') }}">
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

        <div class="container" id="app">
            @yield('content')
        </div>
        @include('Admin.layouts.partial.footer')
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('script')
    @yield('script2')
</body>

</html>