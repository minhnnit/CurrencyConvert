<!DOCTYPE html>
<html>
<head>
    @include('elements.head-seo')
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="p:domain_verify" content="995b13c05dc44be88c138fd4d07087f5"/>
    <meta name="fo-verify" content="af01f140-9ce6-4a5a-a4b5-e2327b37dbd4">
    <meta name="verify-admitad" content="a885bc8355" />
    <meta name="gb-site-verification" content="9cb94edb46a39a0159dd3e0666e64345dadf951b">
    <script type="text/javascript" src="http://classic.avantlink.com/affiliate_app_confirm.php?mode=js&authResponse=ee34c7e32a7e2799371a04fc3e40975354a5f968"></script>
    <!-- TradeDoubler site verification 2982804 -->
    @if(isset($noRobot))
        <meta name="robots" content="noindex, nofollow">
    @endif
<!-- Fonts -->
    @yield('fonts')
<!-- Stylesheet -->
<?php 
$asset_img = explode('.', $_SERVER['HTTP_HOST']=='localhost'?env('SITE_NAME'):$_SERVER['HTTP_HOST']); 
$asset_img = strtolower($asset_img[count($asset_img)-2]);
?>
    <link rel="shortcut" href="{{ asset('/images/'.$asset_img.'/favicon.ico') }}"/>
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/'.$asset_img.'/favicon.ico') }}"/>

    <script src="{{ asset('vendor/jquery/jquery-1.11.3.min.js'.$common['version_app']) }}" type="text/javascript"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('css/coupon.min.css') }}" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    @yield('add_head')
</head>
<body>
    <div class="header">
        <nav class="position-relative navtop">
            <div class="row top-bar">
                <div class="col-md-4 col-sm-4 col-lg-4">
                    <a class="logo" href="{{asset('/')}}">
                    <img class="logo-img" src="{{asset('/images/'.$asset_img.'/logo.png')}}" alt="logo {{$asset_img}}"/>
                    </a>
                </div>
                <div class="col-md-8 col-sm-8 col-lg-8">
                    <div class="search-top">
                            @include('elements.search-box')
                    </div>
                            {{--<div class="input-group-append">
                                <button class="search-go" type="submit" value="submit"><i class="icon-search"></i></button>
                            </div>--}}

                </div>
            </div>
        </nav>
    </div>
<div class="base">
