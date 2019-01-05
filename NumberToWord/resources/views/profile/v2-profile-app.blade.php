{{-- */$noRobot = true;/* --}}
@extends('app')

@section('before-header')
    @include('elements.submitCodeForm')
@endsection
@section('content')
    <div class="container">
        <div class="row page-profile">
            @if(Auth::check())
            <div class="profile-header">
                <div class="profile-avatar">
                    <div class="avatar">
                        <img src="{{!empty($user['avatar']) ? $user['avatar'].'?'.rand() : asset('/images/no-avatar.png')}}" alt="{{$user['fullname']}}" />
                    </div>
                </div>
                <div class="profile-title">
                    <h1>{{!empty($user['fullname']) ? $user['fullname'] : $user['username']}}</h1>
                    <small>Profile</small>
                </div>
            </div>
            @endif
            <div class="profile-nav-bar-box clearfix">
                @if(Auth::check())
                <ul class="profile-nav-bar col-xs-6 col-sm-12">
                    <li class="col-sm-2 {{$active['pro']}}"><a href="{{url('/profile')}}" rel="nofollow">Profile</a></li>
                    <li class="col-sm-2 {{$active['fav']}}"><a href="{{url('/profile/favouriteStores')}}" rel="nofollow">Favorite Stores</a></li>
                    <li class="col-sm-2 {{$active['sav']}}"><a href="{{url('/profile/saved'.config('config.Coupon').'s')}}" rel="nofollow">Saved Coupons</a></li>
                    <li class="col-sm-2 {{$active['cas']}}"><a href="{{url('/profile/cash-back')}}" rel="nofollow">Cash Back</a></li>
                    <li class="col-sm-2 {{$active['ref']}}"><a href="{{url('/profile/reference')}}" rel="nofollow">Refer A Friend</a></li>
                    <li class="col-sm-2 {{$active['sub']}}"><a href="{{url('profile/subscribe')}}" rel="nofollow">Subscribe</a></li>
                </ul>
                <div class="dropdown profile-nav-bar-other col-xs-6 visible-xs">
                    <a id="profile-nav-bar-other-dLabel" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Other Menu <span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="profile-nav-bar-other-dLabel">
                        <li class="{{$active['pro']}}"><a href="{{url('/profile')}}" rel="nofollow">Profile</a></li>
                        <li class="{{$active['fav']}}"><a href="{{url('/profile/favouriteStores')}}" rel="nofollow">Favorite Stores</a></li>
                        <li class="{{$active['sav']}}"><a href="{{url('/profile/saved'.config('config.Coupon').'s')}}" rel="nofollow">Saved Coupons</a></li>
                        <li class="{{$active['cas']}}"><a href="{{url('/profile/cash-back')}}" rel="nofollow">Cash Back</a></li>
                        <li class="{{$active['ref']}}"><a href="{{url('/profile/reference')}}" rel="nofollow">Refer A Friend</a></li>
                        <li class="{{$active['sub']}}"><a href="{{url('profile/subscribe')}}" rel="nofollow">Subscribe</a></li>
                    </ul>
                </div>
                @else
                    <ul class="profile-nav-bar">
                        <li class="col-xs-6 {{$active['fav']}}" style="display: list-item;"><a href="{{url('/profile/favouriteStores')}}" rel="nofollow">Favorite Stores</a></li>
                        <li class="col-xs-6 {{$active['sav']}}" style="display: list-item;"><a href="{{url('/profile/saved'.config('config.Coupon').'s')}}" rel="nofollow">Saved Coupons</a></li>
                    </ul>
                @endif
            </div>
            @yield('profile-content')
        </div>
    </div>
@endsection