<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- CSRF Token  -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LaraBBS') - Laravel进阶教程</title>

    <!--  Styles  -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="{{ route_class() }}-page">

        @include('layouts._header')

        <div class="container">

            @yield('content')

        </div>

        @include('layouts._footer')

    </div>

    <!-- Scripts  -->
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>

</html>