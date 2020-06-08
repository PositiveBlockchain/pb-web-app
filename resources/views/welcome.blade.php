<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PositiveBlockchain') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="bg-gray-100 h-screen antialiased leading-none">
<div class="flex flex-col">
    <nav class="bg-blue-900 shadow mb-8 py-6">
        <div class="container mx-auto px-6 md:px-0">
            <div class="flex items-center justify-center">
                <div class="mr-6">
                    <a href="http://positiveblockchain.local" class="text-lg font-semibold text-gray-100 no-underline">
                        PB Dashboard
                    </a>
                </div>
                <div class="flex-1 text-right">
                    <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="#">Home</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="min-h-screen flex items-center justify-center">
        <div class="flex flex-col justify-around h-full">
            <div id="app">
                <h1 class="text-gray-600 text-center font-light tracking-wider text-5xl mb-6">
                    {{ config('app.name', 'PositiveBlockchain') }} API & Web App
                </h1>
                <App></App>
                <footer class="mt-5">
                    <ul class="list-reset">
                        <li class="inline pr-8">
                            <a href="https://positiveblockchain.io"
                               class="no-underline hover:underline text-sm font-normal text-teal-800 uppercase"
                               title="Documentation">PositiveBlockchain.io</a>
                        </li>
                        <li class="inline pr-8">
                            <a href="https://github.com/PositiveBlockchain/pb-web-app"
                               class="no-underline hover:underline text-sm font-normal text-teal-800 uppercase"
                               title="Laracasts">Github</a>
                        </li>
                        <li class="inline pr-8">
                            <a href="https://positiveblockchain.io/about"
                               class="no-underline hover:underline text-sm font-normal text-teal-800 uppercase"
                               title="News">About PB</a>
                        </li>
                        <li class="inline pr-8">
                            <a href="https://twitter.com/PositiveBlock"
                               class="no-underline hover:underline text-sm font-normal text-teal-800 uppercase"
                               title="Nova">Twitter</a>
                        </li>
                        <li class="inline pr-8">
                            <a href="https://www.youtube.com/channel/UCfUUntxXsz0k1N1oCb7w1ZA"
                               class="no-underline hover:underline text-sm font-normal text-teal-800 uppercase"
                               title="Forge">YouTube</a>
                        </li>
                        <li class="inline pr-8">
                            <a href="https://www.linkedin.com/company/positiveblockchain-io"
                               class="no-underline hover:underline text-sm font-normal text-teal-800 uppercase"
                               title="Vapor">LinkedIn</a>
                        </li>
                        <li class="inline pr-8">
                            <a href="https://chainist.de/"
                               class="no-underline hover:underline text-sm font-normal text-teal-800 uppercase"
                               title="GitHub">Hosted and co-developed by chainist.de</a>
                        </li>
                    </ul>
                </footer>

            </div>
        </div>
    </div>
</div>
</body>
</html>
