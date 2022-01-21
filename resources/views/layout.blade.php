<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name'))</title>
        <script defer src="{{ mix('js/app.js') }}"></script>
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <livewire:styles />
        <div id="app">
            @include('partials.header')
            <main role="main">
                <x-container class="pt-3">
                    @yield('content')
                </x-container>
            </main>
        </div>
        <x-logout-form />
        <livewire:scripts />
    </body>
</html>
