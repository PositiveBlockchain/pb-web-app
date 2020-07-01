<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PositiveBlockchain') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('site.webmanifest')}}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/vue.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('js/manifest.js') }}" defer></script>
    <script src="{{ asset('js/vendor.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="bg-gray-800 h-screen antialiased leading-none">
<div class="flex flex-col">
    @include('template.navbar-main')
    <div class="min-h-screen flex items-center justify-center">
        <div class="flex flex-col justify-around h-full">
            <div id="app">
                <h1 class="text-gray-400 text-center font-light tracking-wider md:text-4xl lg:text-4xl sm:text-4xl mb-6">
                    Blockchain Social Impact <br> Projects Dashboard
                </h1>
                <p class="text-center mb-5 text-gray-400"><small>This is a development version. Things might
                        break.</small></p>
                <App></App>
            </div>
        </div>
    </div>
    @include('template.footer')
</div>
</body>
</html>
