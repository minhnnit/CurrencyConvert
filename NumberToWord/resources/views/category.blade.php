@extends('app')

@section('scripts')
    <script src="{{ asset('vendor/jquery/jquery-1.11.4.ui.min.js?ver=0001') }}" type="text/javascript"  async defer></script>
@endsection

@section('before-header')
    @include('elements.submitCodeForm')
@endsection

@section('content')
    <div class="container">
        <div class="row store-detail">
            @if(sizeof($data['slideshow']))
                <div class="row category-slider hidden-xs">
                    <!-- Big slide for adv banners-->
                    <div id="myAdvBanners" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            {{--*/$slideActive = 'active'; $sliderCount = 0;/*--}}
                            @foreach($data['slideshow'] as $slider)
                                <li data-target="#carousel-example-generic" data-slide-to="{{$sliderCount}}" class="{{$slideActive}}"></li>
                                {{--*/$slideActive = ''; $sliderCount++;/*--}}
                            @endforeach
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            {{--*/$slideActive = 'active';/*--}}
                            @foreach($data['slideshow'] as $slider)
                                <div class="item {{$slideActive}}">
                                    <a href="{{$slider['link']}}" target="{{$slider['target']}}" title="{{$slider['alt']}}" @if($slider['rel']) rel="{{$slider['rel']}}" @endif
                                    @if($slider['affiliate']) link_go="{{$slider['affiliate']}}" @endif >
                                        <img src="{{$slider['image']}}" alt="{{$slider['alt']}}"></a>
                                </div>
                                {{--*/$slideActive = '';/*--}}
                            @endforeach
                        </div>
                        <!-- Left and right controls -->
                        <a class="left carousel-control" href="#myAdvBanners" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myAdvBanners" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <!-- /end Big slide for adv banners-->
                </div>
            @endif
            <div class="row">
                <div class="col-md-3 hidden-sm hidden-xs">
                    @if(sizeof($data['topStores']))
                        <div class="box-selection-right no-padding">
                            <div class="box-header">
                                Top Services Stores
                            </div>
                            <div class="scrollbar-auto box-items-top-store">
                                <ul class="list-items-logo">
                                    @foreach($data['topStores'] as $ss)
                                        <li><a href="{{url('/'. $ss['alias'].config('config.suffix_coupon'))}}">
                                                <span class="list-items-logo-store"><img src="{{$ss['logo']}}" alt="{{$ss['name']}}"></span>
                                                <span class="list-items-name-store">{{$ss['name']}}</span>
                                                <span class="list-items-cash-back">
                                            @if (!empty($ss['cash_back_json']))
                                                        Up to {{$ss['cash_back_json']['currency'] == '%' ? $ss['cash_back_json']['value'].'%' : $ss['cash_back_json']['currency'].$ss['cash_back_json']['value']}} Cash Back
                                                    @endif
                                        </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    @if(sizeof($data['couponTypes']))
                        <div class="box-selection-right">
                            <div class="box-header">
                                Coupon type:
                            </div>
                            <div class="box-items">
                                <ul class="list-items scrollbar-auto">
                                    @foreach($data['couponTypes'] as $ct)
                                        <li>
                                            <label><input type="checkbox" class="filter-coupon-type" value="{{$ct['coupon_type']}}" {{in_array($ct['coupon_type'],Session::get('coupon_type_' . $data['alias'])) ? 'checked' : ''}} /> {{$ct['coupon_type']}} ({{$ct['count']}})</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    @if(sizeof($data['relatedCategories']))
                        <div class="box-selection-right">
                            <div class="box-header">
                                Related Categories
                            </div>
                            <div class="box-items">
                                <ul class="list-items scrollbar-auto">
                                    @foreach($data['relatedCategories'] as $ca)
                                        <li><a href="{{url('/category/'. $ca['alias'])}}">{{$ca['name']}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <div class="box-selection-right">
                        <div class="box-items">
                            <ul class="sub-break-crumb">
                                <li><a href="{{url('/')}}">Home</a></li>
                                <li><em>{{$data['name']}} {{config('config.coupon')}} code</em></li>
                            </ul>
                        </div>
                    </div>
                    @if(!empty($data['description']))
                    <div class="box-selection-right no-border">
                        <div class="box-header">
                            Description
                        </div>
                        <div class="box-items">
                            {!! html_entity_decode($data['description']) !!}
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="table">
                        <div class="store-header category-header">
                            <div class="col-store-header">
                                <h1><strong>{{$data['name']}}</strong> {{config('config.COUPON')}} CODES</h1>
                                <ul class="category-header-line hidden-md hidden-lg">
                                    @foreach($data['couponTypes'] as $ct)
                                        <li>
                                            <label><input type="checkbox" class="filter-coupon-type" value="{{$ct['coupon_type']}}" {{in_array($ct['coupon_type'],Session::get('coupon_type_' . $data['alias'])) ? 'checked' : ''}} /> {{$ct['coupon_type']}} ({{$ct['count']}})</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div>
                    {{-- */$coupons_item = 0;/* --}}
                    @foreach($data['coupons'] as $c)
                        @if($coupons_item == 1)
                            <!-- Box quick sign up for subscribe store  -->
                                <div class="subscribe-store-box">
                                    <div id="form-subscribe-store" class="row">
                                        <div class="col-sm-5 box-subscribe-title">
                                            <strong>Subscribe</strong> for {{$data['name']}} Coupon Alerts
                                        </div>
                                        <div class="col-sm-7 box-subscribe-desc">
                                            <form id="subscribe-category-form" action="{{url('/user/subscribeCategory')}}">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                                <input type="hidden" name="categoryId" value="{{$store['id']}}"/>
                                                <div class="input-group form-subscriber">
                                                    <input type="email" name="email" required class="form-control input-lg" placeholder="Enter your email...">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-theme btn-sign-up input-lg" type="submit">Subscribe</button>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row registered-subscriber hidden">
                                        <p>Thank you! You have been subscribe to receive alerts from {{$data['name']}} Coupon.</p>
                                    </div>
                                </div>
                            @endif
                            @include('elements.v2-box-store-coupon')
                            {{-- */$coupons_item++;/* --}}
                        @endforeach
                        @if (sizeof($data['coupons']) >= 20)
                            <a href="" class="load-more show-more-coupons"><i class="fa fa-arrow-circle-o-down"></i> Load More Coupons</a>
                            <!-- a href="javascript:;" class="load-more ajax-loading"><i class="fa fa-spinner fa-pulse"></i> Load More Coupons</a -->
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="{{isset($seoConfig['originTitle']) ? $seoConfig['originTitle'] : ''}}" id="originTitle">
    <input type="hidden" value="{{isset($seoConfig['originDesc']) ? $seoConfig['originDesc'] : ''}}" id="originDesc">
@endsection

@section('scripts-footer')
    <script>
        var widgetSubmitCoupon;
        var CaptchaCallback = function () {
            widgetSubmitCoupon = grecaptcha.render('reCaptchaSubmit', {'sitekey': '{{ $reCapcha_public_key }}'});
        };
        $(document).ready(function ($) {
            var $formSubscribe = $('#subscribe-category-form');
            $formSubscribe.on('submit', function (e) {
                e.preventDefault();
                var $that = $(this);
                $that.find("button[type='submit']").empty().append("<i class='fa fa-spinner fa-pulse'></i>").addClass('disabled');
                $.ajax({
                    type: 'post',
                    url: $that.attr('action'),
                    data: $that.serialize()
                }).done(function (data) {
                    if (data.status == 'success') {
                        $that[0].reset();
                        $that.find("button[type='submit']").empty().text("Successful!");
                        $("#form-subscribe-store").addClass('hidden');
                        $("div.registered-subscriber").removeClass('hidden');
                    } else if (data.status == 'error') {
                    }
                    setTimeout(function () {
                        $that.find("button[type='submit']").empty().text("Sign Up").removeClass('disabled');
                    }, 2000);
                });
            });

            /*
             Author:HaiHT
             */
            function saveSubmitedCouponsToLocalStorage(couponID){
                var localObj = {}; localObj.submitCoupons = [];
                // If exist submitCoupons ids in LS then push to localObj submitCoupons
                if(localStorage['submitCoupons']){
                    localObj.submitCoupons = (localStorage.submitCoupons).split(',');
                }
                // console.log('before submited coupon:', localObj.submitCoupons);
                // Check if browser support Web storage
                if(typeof(Storage) !== "undefined") {
                    localObj.submitCoupons.push(couponID);
                    localStorage['submitCoupons'] = localObj.submitCoupons;
                    // console.log('after submited coupon:',localStorage['submitCoupons']);
                } else {
                    console.log('No Web Storage support');
                }
            }

            $('.filter-coupon-type').on('click', function () {
                var $that = $(this);
                $.ajax({
                    type: 'get',
                    url: "{{url('/session/filterCoupon')}}",
                    data: {
                        alias : '{{$data['alias']}}',
                        coupon_type : $that.val(),
                        checked: $that.is(':checked')
                    }
                }).done(function (data) {
                    location.reload();
                });
            });

            $('.show-more-coupons').on('click', function (e) {
                e.preventDefault();
                var $that = $(this);
                $that.find('i.fa').addClass('fa-spinner fa-pulse').removeClass('fa-arrow-circle-o-down');
                $.ajax({
                    type: 'get',
                    url: '{{url('/category/showMoreCoupons')}}',
                    data: {categoryId : '{{$data['id']}}'}
                }).done(function (data) {
                    if (data.status == 'error') {
                        $that.remove();
                    } else {
                        $(data).insertBefore($that);
//                        initGlobal();
                        initGetCode();
                        truncateSomething();
                        $that.find('i.fa').removeClass('fa-spinner fa-pulse').addClass('fa-arrow-circle-o-down');
                    }
                });
            });
        });

    </script>
@endsection
