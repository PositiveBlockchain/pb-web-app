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
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="bg-gray-800 h-screen antialiased leading-none">
<div class="flex flex-col">
   @include('template.navbar-main')
    <div class="min-h-screen flex items-center justify-center">
        <div class="flex flex-col justify-around h-full">
            <div id="app">
                <h1 class="text-gray-400 text-center font-light tracking-wider md:text-4xl lg:text-4xl sm:text-4xl mb-6">
                    Blockchain Social Impact <br> Projects   Dashboard
                </h1>
                <p class="text-center mb-5 text-gray-400"><small>This is a development version. Things might break.</small></p>
                <App></App>
                <footer class="mt-5">
                    <nav class="bg-gray-900 shadow mb-8 py-6 px-4">
                        <div class="container mx-auto px-6 md:px-0">
                            <div class="flex items-center justify-center">
                                <ul class="list-reset">
                                    <li class="inline pr-8">
                                        <a href="https://positiveblockchain.io"
                                           class="no-underline hover:underline text-sm font-normal text-gray-400 uppercase"
                                           title="Documentation">PositiveBlockchain.io</a>
                                    </li>
                                    <li class="inline pr-8">
                                        <a href="https://github.com/PositiveBlockchain/pb-web-app"
                                           class="no-underline hover:underline text-sm font-normal text-gray-400 uppercase"
                                           title="Github project">Github</a>
                                    </li>
                                    <li class="inline pr-8">
                                        <a href="https://positiveblockchain.io/about"
                                           class="no-underline hover:underline text-sm font-normal text-gray-400 uppercase"
                                           title="News">About PB</a>
                                    </li>
                                    <li class="inline pr-8">
                                        <a href="https://twitter.com/PositiveBlock"
                                           class="no-underline hover:underline text-sm font-normal text-gray-400 uppercase"
                                           title="Nova">Twitter</a>
                                    </li>
                                    <li class="inline pr-8">
                                        <a href="https://www.youtube.com/channel/UCfUUntxXsz0k1N1oCb7w1ZA"
                                           class="no-underline hover:underline text-sm font-normal text-gray-400 uppercase"
                                           title="PositiveBlockchain YouTube">YouTube</a>
                                    </li>
                                    <li class="inline pr-8">
                                        <a href="https://www.linkedin.com/company/positiveblockchain-io"
                                           class="no-underline hover:underline text-sm font-normal text-gray-400 uppercase"
                                           title="PositiveBlockchain LinkedIn">LinkedIn</a>
                                    </li>
                                    <li class="inline pr-8">
                                        <a href="https://chainist.de/"
                                           class="no-underline hover:underline text-sm font-normal text-gray-400 uppercase"
                                           title="Chainist.de Website">Hosted and co-developed by chainist.de</a>
                                    </li>
                                </ul>
                                </div>
                            </div>
                        </div>
                    </nav>

                </footer>

            </div>
        </div>
    </div>
</div>
</body>
</html>
