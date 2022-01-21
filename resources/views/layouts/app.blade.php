<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">


    <!-- Styles -->

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script>

        window.Laravel = {!! json_encode([
                "apiToken" => auth()->user()->api_token ?? null,
                "env" => config('app.env'),
                "pusher_key" => config('broadcasting.connections.pusher.key'),
                "feature_flags" => \FriendsOfCat\LaravelFeatureFlags\FeatureFlagsForJavascript::get(),
                "pusher_cluster" => config('broadcasting.connections.pusher.options.cluster'),
                ]) !!};

    </script>

    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">
    <link rel="manifest" href="/images/site.webmanifest">

    <style id="antiClickjack">body{display:none !important;}</style>
</head>

<body>
    <div id="app">
        @include("layouts._nav")

        <main class="py-4">
            @include("layouts._messages")
            <!-- -->
            @yield('content')
        </main>
    </div>
</body>
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/security.js') }}"></script>
</html>
