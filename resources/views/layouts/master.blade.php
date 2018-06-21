<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title> @yield('title')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <!--link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.css" rel="stylesheet"-->
    <link href="/css/tomorrow-night.css" rel="stylesheet">
    @yield('style')
</head>
<body>
    <div class="container" id="app">
        @yield('content')
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
