<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title')</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link href="/css/tomorrow-night.css" rel="stylesheet">
    @yield('style')
</head>
<body>
    @include('layouts.partial.navigation')

    @include('layouts.partial.flash_message')

    <div class="container" id="app">
        @yield('content')
    </div>

    @include('layouts.partial.footer')
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('script')
</body>
</html>
