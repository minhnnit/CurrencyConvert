<!DOCTYPE html>
<html>
<head>
    @include('elements.head-seo')
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="p:domain_verify" content="995b13c05dc44be88c138fd4d07087f5"/>
    <meta name="fo-verify" content="938156fd-e887-467b-8ba6-f68e1108c97a">
    <meta name="verify-admitad" content="a885bc8355" />
    <meta name="gb-site-verification" content="9cb94edb46a39a0159dd3e0666e64345dadf951b">
    <!-- TradeDoubler site verification 2982804 -->
    @if(isset($noRobot))
        <meta name="robots" content="noindex, nofollow">
    @endif
<!-- Fonts -->
    @yield('fonts')
<!-- Stylesheet -->
    <link rel="shortcut" href="{{ asset('/images/'.$asset_img.'/favicon.ico') }}?v=2"/>
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/'.$asset_img.'/favicon.ico') }}?v=2"/>

    <script src="{{ asset('vendor/jquery/jquery-1.11.3.min.js'.$common['version_app']) }}" type="text/javascript"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style1.css') }}" rel="stylesheet">
    @yield('add_head')
    {!! $settings['header'] !!}
</head>
<body>
<div class="header">
    <nav class="position-relative navtop">
        <div class="row top-bar">
            <div class="mobi-center col-xs-4 col-md-4 col-sm-4 col-lg-4 centered">
                <a href="{{asset('/')}}" class="logo">
                    <img src="{{asset('/images/'.$asset_img.'/logo.png')}}" alt="logo {{$asset_img}}"/>
                </a>
            </div>
            <div class="col-xs-8 col-md-8 col-sm-8 col-lg-8 centered">
                <div class="search-top">
                    @include('elements.search-box')
                </div>
            </div>
        </div>
    </nav>
</div>