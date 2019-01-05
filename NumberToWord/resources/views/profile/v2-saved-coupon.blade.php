<?php
/**
 * Created by PhpStorm.
 * User: Phuong
 * Date: 1/15/2016
 * Time: 10:09 AM
 */
?>
@extends('profile.v2-profile-app')
@section('scripts')
    <script src="{{ asset('vendor/jquery/jquery-1.11.4.ui.min.js'.$common['version_app']) }}" type="text/javascript" async defer></script>
@endsection
@section('profile-content')
    @if(Auth::guest() && (isset($disable) && $disable == false))
    <div class="profile-box-default not-saved-coupons" style="padding: 0 15px 15px;">
        <h3><b>Your Saved {{config('config.Coupon').'s'}} are only temporary</b></h3>
        <p><a href="{{ url('/login') }}" style="color: #854c99;">CREATE AN ACCOUNT</a> and we will keep them safe and sound, otherwise these will disappear after you leave.</p>
    </div>
    @endif
    @foreach($coupons as $c)
        @include('elements.v2-box-store-coupon')
    @endforeach
    @if(!sizeof($coupons))
        <div class="list-saved profile-box-default">
            <h3 style="text-align: center" >You have not added any coupons in your Saved list</h3>
            <br>
        </div>
    @endif
    @if (sizeof($coupons) >= 20)
        <a href="" class="load-more show-more-coupons"><i class="fa fa-arrow-circle-o-down"></i> Load More Coupons</a>
        <!-- a href="javascript:;" class="load-more ajax-loading"><i class="fa fa-spinner fa-pulse"></i> Load More Coupons</a -->
    @endif
@endsection
@section('scripts-footer')
    <script type="text/javascript">
        /*
         * CuongPH
         * Switch frame login <> sign up
         * */
        $(".btn-store-sign-in, .btn-coupon-sign-in").on('click', function(){
            $(this).parents('.modal-frame-box').css('left', '-100%');
        });
        $(".btn-store-sign-up, .btn-coupon-sign-up").on('click', function(){
            $(this).parents('.modal-frame-box').css('left', '0');
        });

        var widgetSubmitCoupon;
        var CaptchaCallback = function () {
            widgetSubmitCoupon = grecaptcha.render('reCaptchaSubmit', {'sitekey': '{{ $reCapcha_public_key }}'});
        };
        $(document).ready(function ($) {
            /*Load saved coupons from localStorage*/
            @if(Auth::guest())
            if(localStorage.saveCoupons){
                $.ajax({
                    type: 'GET',
                    url: "{{url('/profile/getDataFromBrowser/')}}",
                    data: {ids : localStorage.saveCoupons, type : 'coupons'}
                }).done(function (r) {
                    if(r){
//                        for(i = 0; i < r.length; i++){
//                            var item = r[i];
//
//                        }

                        $('.list-saved').empty().removeClass('profile-box-default').append(r + '<br>');
                        reAppendScripts();
                    }
                })
            }else $('.not-saved-coupons').hide();
            @endif
            // Re append scripts to coupons
            function reAppendScripts(){
                $('h3.lsi-item-title, div.lsi-item-content').each(function() {
                    var $el = $(this);

                    $el.truncate({
                        lines: 2,
                        lineHeight: 25
                    });
                    $el.on('mouseenter touchstart', function () {
                        $el.truncate('expand');
                        $el.addClass('extra');
                        return false;
                    });
                    $el.on('mouseleave touchend', function () {
                        $el.truncate('collapse');
                        $el.removeClass('extra');
                        return false;
                    });
                });
                initGetCode();
            }

            // Remove clicked coupon from localStorage.saveCoupons
            $(document).on('click', '.remove-cp-from-local', function(){
                console.log('before remove : ', localStorage.saveCoupons);
                removedId = $(this).attr('c_id');
                y = (localStorage.saveCoupons).split(',');
                y.splice( $.inArray(removedId, y), 1);
                localStorage.saveCoupons = y;
                console.log('after remove : ', localStorage.saveCoupons);
                $(this).parent().remove();
            });

            $('.show-more-coupons').on('click', function (e) {
                e.preventDefault();
                var $that = $(this);
                $that.find('i.fa').addClass('fa-spinner fa-pulse').removeClass('fa-arrow-circle-o-down');
                $.ajax({
                    type: 'get',
                    url: '{{url('/profile/showMoreSavedCoupons')}}'
                }).done(function (data) {
                    if (data.status == 'error') {
                        $that.remove();
                    } else {
                        $(data).insertBefore($that);
                        initGetCode();
                        truncateSomething();
                        $that.find('i.fa').removeClass('fa-spinner fa-pulse').addClass('fa-arrow-circle-o-down');
                    }
                });
            });
        });
    </script>
@endsection


