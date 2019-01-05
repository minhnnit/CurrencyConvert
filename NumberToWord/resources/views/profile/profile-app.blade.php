{{-- */$noRobot = true;/* --}}
@extends('app')

@section('before-header')
    @include('elements.submitCodeForm')
@endsection
@section('content')
    <div class="show-page-profle">
        <div class="container" >
            <div class="row page-boxer">
                <div class="page-prof" >
                    <div class="pro-header clearfix">
                        <div class="pro-avatar">
                            <img src="{{!empty($user['avatar']) ? $user['avatar'].'?'.rand() : asset('/images/no-avatar.png')}}" alt="{{$user['fullname']}}" />
                        </div>
                        <div class="pro-status">
                            <div class="pro-user">{{!empty($user['fullname']) ? $user['fullname'] : $user['username']}}</div>
                            <div class="pro-say">“{{$user['bio']}}”</div>
                        </div>
                    </div>
                    <div class="pro-nav">
                        <ul class="pro-nav-control">
                            <li class="pro {{$active['pro']}}"><a rel="nofollow" href="{{url('/profile')}}">My Profile</a></li>
                            <li class="sav {{$active['sav']}}"><a rel="nofollow" href="{{url('/profile/saved'.config('config.Coupon').'s')}}">SAVE {{config('config.COUPON')}}</a></li>
                            <li class="fav {{$active['fav']}}"><a rel="nofollow" href="{{url('/profile/favouriteStores')}}">FAVOURITE STORES</a></li>
                            <li class="pre {{$active['pre']}}"><a rel="nofollow" href="{{url('/profile/preference')}}">ACCOUNT PREFERENCE</a></li>
                            {{--<li class="com {{$active['com']}}"><a rel="nofollow" href="#">COMMUNITY</a></li> --}}{{--{{url('/profile/community')}}--}}
                        </ul>
                    </div>
                    @yield('profile-content')
                </div>
            </div>
        </div>
    </div>

@endsection