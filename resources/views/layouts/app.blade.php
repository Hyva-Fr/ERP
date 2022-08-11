<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="msapplication-config" content="{{ config('app.url') }}/storage/media/favicons/browserconfig.xml">
        <meta name="theme-color" content="#ffffff">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title'){{ config('app.name', 'Laravel') }}</title>

        <link rel="apple-touch-icon" sizes="120x120" href="{{ config('app.url') }}/storage/media/favicons/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ config('app.url') }}/storage/media/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ config('app.url') }}/storage/media/favicons/favicon-16x16.png">
        <link rel="manifest" href="{{ config('app.url') }}/storage/media/favicons/site.webmanifest">
        <link rel="mask-icon" href="{{ config('app.url') }}/storage/media/favicons/safari-pinned-tab.svg">
        <link rel="shortcut icon" href="{{ config('app.url') }}/storage/media/favicons/favicon.ico">

        <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>

        <!-- Fontawesome -->
        <link href="https://site-assets.fontawesome.com/releases/v6.1.1/css/svg-with-js.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/3c48e7e948.js" crossorigin="anonymous"></script>

        <!-- jQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
    <body class="yellow" data-lt="{{ config('session.lifetime') }}">
        <main id="full-main">
            @yield('content')
        </main>
        <small id="full-small">
            <a target="_blank" href="{{ env('APP_HOME', 'https://hyva.com') }}">{!! svg('hyva-black', 'full-small-svg') !!}</a>
        </small>
        <script src="{{ mix('js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
