@extends('profile.profile-app')

@section('profile-content')

    <div class="pro-stats clearfix">
        <div class="stats-header">Stats <a href="{{url('/profile/edit')}}">Edit profile</a></div>
        <div class="stats-content clearfix">
            <ul>
                <li class="stat-point"><strong>0</strong>Points</li>
                <li>
                    <span>Community rank: 44188th</span>
                    <span>Points this week: 0</span>
                    <span>Coupons used: 0</span>
                </li>
                <li>
                    <span>Money saved: $0</span>
                    <span>Comments made: 0</span>
                    <span>Coupons submitted: 0</span>
                </li>
                <li>
                    <span>Coupons rejected: 1</span>
                    <span>Saved others: $0</span>
                    <span>Thank you's earned: 0</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="information-box">
        <div class="headline-box">Comments for Alan Thomas</div>
        <div class="person-info clearfix">
            <div class="per-btn">
                <button type="button">Delete</button>
                <button type="button">Reply</button>
            </div>
            <div class="per-avatar"><img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" /></div>
            <div class="per-info"><a href="#">Sophia Evans</a> posted one hour</div>
        </div>
        <div class="person-content">
            Welcome to the RetailMeNot Community!<br><br>
            As a part of the RetailMeNot Community, you can keep track of your savings, accumulate points for submitting coupons and
            earn badges for submitting and using coupons, commenting, and more. Plus, you can share tips with your fellow Community
            members and win prizes in our Community contests.<br>
            If you have any questions about the Community or about RetailMeNot, please let me know.<br>
            <br>
            Thanks!
        </div>
    </div>
    <div class="information-box">
        <div class="headline-box">Alan Thomas’S ACTIVITYS</div>
        <div class="person-use-line">LATEST COUPONS USED</div>
        <div class="person-content">
            <ul class="list-activitys">
                <li><a href="#">RetailMeNot Exclusive! Get $25 gift certificates for $4 and $15 gift certificates for $2.40! Visit restaurant.com for a list of participating restaurants in your area. Hurry, offer expires on 10/30/2014</a></li>
                <li><a href="#">RetailMeNot Exclusive! Get $25 gift certificates for $4 and $15 gift certificates for $2.40! Visit restaurant.com for a list of participating restaurants in your area. Hurry, offer expires on 10/30/2014</a></li>
                <li><a href="#">RetailMeNot Exclusive! Get $25 gift certificates for $4 and $15 gift certificates for $2.40! Visit restaurant.com for a list of participating restaurants in your area. Hurry, offer expires on 10/30/2014</a></li>
            </ul>
        </div>
        <div class="person-use-line">LATEST COUPONS USED</div>
        <div class="person-content">(No coupon comments made)</div>
    </div>

@endsection