<!doctype html>
<html>
<head>
    <title>{{ $seo['title'] }}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="{{ $seo['keywords'] }}" />
    <meta name="description" content="{{ $seo['description'] }}" />
    @if ($seo['image'])
        <meta property="og:image" content="{{ $seo['image'] }}" />
        @endif
                <!-- Fonts -->
        @yield('fonts')
        <!-- Stylesheet -->
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link href="{{ asset('vendor/bootstrap-3.3.4-dist/css/bootstrap.min.css?ver=0001') }}" rel="stylesheet" type='text/css' />
    <link href="{{ asset('css/404.css?ver=0001') }}" rel="stylesheet" type='text/css' />
</head>
<body class="page-notfound">
<div class="notfound">
    <img src="{{ asset('images/404.png') }}" alt="Page Not found!" />
    <div class="gohome-notfound"><a href="{{url('/')}}" title="Back to home"><img src="{{ asset('images/404-home-btn.png') }}" alt="Go home"></a></div>
    <div class="groups-logo">
        <div class="top-partner">
            <a href="#"><figure><img src="{{ asset('images-demo/logo-stores/store-5.png') }}" /></figure></a>
        </div>
        <div class="top-partner">
            <a href="#"><figure><img src="{{ asset('images-demo/logo-stores/store-3.png') }}" /></figure></a>
        </div>
        <div class="top-partner">
            <a href="#"><figure><img src="{{ asset('images-demo/logo-stores/store-2.png') }}" /></figure></a>
        </div>
    </div>
</div>
</body>
</html>