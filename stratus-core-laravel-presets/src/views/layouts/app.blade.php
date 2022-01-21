<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/security.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>

        window.Laravel = {!! json_encode([
                "apiToken" => auth()->user()->api_token ?? null,
                "env" => config('app.env'),
                "pusher_key" => config('broadcasting.connections.pusher.key'),
                "pusher_cluster" => config('broadcasting.connections.pusher.options.cluster'),
                ]) !!};

    </script>
    <style id="antiClickjack">body{display:none !important;}</style>
</head>

<body>
    <div id="app">
        @include("layouts._nav")

        <main class="py-4">
            <vue-snotify></vue-snotify>
            @include("layouts._messages")
            <!-- -->
            @yield('content')
        </main>
    </div>
</body>

</html>
