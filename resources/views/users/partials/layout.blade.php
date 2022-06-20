<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('title_meta')

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/images/favicon.png') }}" />
    <meta name="theme-color" content="#15803d" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="robots" content="noindex, nofollow" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    @yield('pluginCssLinks')

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('/scss/app.scss') }}" />
    @yield('pageStyle')
</head>

<body class="antialiased bg-gray-100">
    @include('users.partials.navigation')

    @yield('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @yield('pluginJsLinks')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    @yield('pageScript')
</body>

</html>
