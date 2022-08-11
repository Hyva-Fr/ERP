<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <x-head.tinymce-config/>
    
    @stack('styles')

    <script>
        let formsTypes = @json(getFormsTypes())
    </script>

</head>
<body data-lt="{{ config('session.lifetime') }}">
    <div id="loader">
        <span></span>
    </div>
    @include('vendor.session-out.notify')
    @include('commons.header')
    @include('commons.aside')
    <main id="logged-main">
        {!! breadCrumbs() !!}
        @yield('content')
    </main>
    @include('commons.footer')
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
