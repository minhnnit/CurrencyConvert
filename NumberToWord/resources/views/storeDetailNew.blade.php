@extends('app')
@section('add_head')
    <link href="{{ asset('css/detail.css') }}" rel="stylesheet">
@endsection
@section('content_main')
    <div class="main-body">
        <div class="messages">
        </div>
        <div class="coupon" id="coupon-brand" itemscope="" itemtype="http://schema.org/Store">
            <div class="c-ccontent-top">
                @include('elements.store_info')
            </div>


            <div class="coupon-wrap">
                <div class="coupon-store">
                    <div class="m-c-w col-wrap">
                        @include('elements.submit_col_left')

                        <div class="main-col">
                            <div class="m-c-l">
                                <div class="c-r-list">
                                    <!-- start a item -->
                                    <?php $s=$store; $storeLink=1; ?>
                                    <div id="store-detail-list-coupon">
                                        <!-- Cash back information box has many case  -->
                                        @if(sizeof($store['cash_back_json'])>1)
                                            <div class="box-cash-back" id="box-cash-back-store">
                                                <div class="box-cash-back-header">
                                                    <h3>Up to {{!empty($store['cash_back_json'][0]['cash_back_percent']) ? $store['cash_back_json'][0]['cash_back_percent'].'%' : $store['cash_back_json'][0]['currency'].$store['cash_back_json'][0]['cash_back']}} Cash Back</h3>
                                                    <span>(<a role="button" data-toggle="collapse" data-parent="#box-cash-back-store" href="#cash-back-term" aria-expanded="false"
                                                              aria-controls="cash-back-term">Cash Back terms</a>)</span>
                                                    <span class="shop-now-box">
                                    @if(Auth::guest())
                                                            <a role="button" data-toggle="modal" data-target="#shop-now" class="btn-shop-now pull-right">Shop now <i class="fa fa-sort-desc fa-rotate-270"></i></a>
                                                        @else
                                                            <a href="{{url('/go/'.$store['go'])}}" target="_blank" class="btn-shop-now pull-right">Shop now <i class="fa fa-sort-desc fa-rotate-270"></i></a>
                                                        @endif
                                </span>
                                                </div>
                                                <div class="panel-collapse collapse cash-back-info" id="cash-back-term">
                                                    {!!html_entity_decode($store['cash_back_term'])!!}
                                                </div>
                                                <div class="box-cash-back-content">
                                                    <div class="col-sm-5 box-column">
                                                        <div id="limited-visibility" class="limited-visibility">
                                                            <div class="table-cash-back">
                                                                @foreach($store['cash_back_json'] as $cbj)
                                                                    <div class="cash-back-row">
                                                                        <div class="column-title ellipsis1">{{$cbj['description']}}</div>
                                                                        <div class="column-value ellipsis1">{{!empty($cbj['cash_back_percent']) ? $cbj['cash_back_percent'].'%' : $cbj['currency'].$cbj['cash_back']}}</div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        @if(sizeof($store['cash_back_json'])>3)
                                                            <div id="cash-back-show-more" class="table-cash-back CB-show">
                                                                <div class="CB-show-more cash-back-row">
                                                                    <div class="column-title ellipsis1">Show more...</div>
                                                                    <div class="column-value ellipsis1"><i class="fa fa-caret-down"></i></div>
                                                                </div>
                                                                <div class="CB-show-less cash-back-row">
                                                                    <div class="column-title ellipsis1">Show less...</div>
                                                                    <div class="column-value ellipsis1"><i class="fa fa-caret-up"></i></div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-sm-7 box-column has-many-cash-back">
                                                        <div class="box-cash-about">
                                                            <div class="about-date">
                                                                <div class="date-estimated-title">{{date('d F Y', strtotime("+30 days"))}}</div>
                                                                <div class="date-estimated-desc">Estimated Payment Date<br />(if purchased today)
                                                                    <a style="display: none" tabindex="0" class="btn-estimated" data-placement="top" role="button" data-toggle="popover" data-trigger="focus"
                                                                       data-content="And here's some amazing content. It's very engaging. Right?">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="about-amount">
                                                                <div class="date-estimated-title">${{number_format(time()/10%100000 + ($store['cash_back_total'] ? $store['cash_back_total'] : 0))}}</div>
                                                                <div class="date-estimated-desc">Total Cash Back<br />earned to date</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif (sizeof($store['cash_back_json'])==1)
                                        <!-- OR -->
                                            <!-- Cash back information box has one case  -->
                                            <div class="box-cash-back" id="box-cash-back-store">
                                                <div class="box-cash-back-header">
                                                    <h3>{{!empty($store['cash_back_json'][0]['cash_back_percent']) ? $store['cash_back_json'][0]['cash_back_percent'].'%' : $store['cash_back_json'][0]['currency'].$store['cash_back_json'][0]['cash_back']}} Cash Back</h3>
                                                    <span>(<a role="button" data-toggle="collapse" data-parent="#box-cash-back-store" href="#cash-back-term-01" aria-expanded="false"
                                                              aria-controls="cash-back-term">Cash Back terms</a>)</span>
                                                    <span class="shop-now-box">
                                    @if(Auth::guest())
                                                            <a role="button" data-toggle="modal" data-target="#shop-now" class="btn-shop-now pull-right">Get Cash Back <i class="fa fa-sort-desc fa-rotate-270"></i></a>
                                                        @else
                                                            <a href="{{url('/go/'.$store['go'])}}" target="_blank" class="btn-shop-now pull-right">Get Cash Back <i class="fa fa-sort-desc fa-rotate-270"></i></a>
                                                        @endif
                                </span>
                                                </div>
                                                <div class="panel-collapse collapse cash-back-info" id="cash-back-term-01">
                                                    {!!html_entity_decode($store['cash_back_term'])!!}
                                                </div>
                                                <div class="box-cash-back-content">
                                                    <div class="box-column">
                                                        <div class="box-cash-about">
                                                            <div class="about-date">
                                                                <div class="date-estimated-title">{{date('d F Y', strtotime("+30 days"))}}</div>
                                                                <div class="date-estimated-desc">Estimated Payment Date<br />(if purchased today)
                                                                    <a tabindex="0" class="btn-estimated" data-placement="top" role="button" data-toggle="popover" data-trigger="focus"
                                                                       data-content="And here's some amazing content. It's very engaging. Right?">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="about-amount">
                                                                <div class="date-estimated-title">${{number_format(time()/10%100000 + ($store['cash_back_total'] ? $store['cash_back_total'] : 0))}}</div>
                                                                <div class="date-estimated-desc">Total Cash Back<br />earned to date</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if(sizeof($store['cash_back_json']) && (isset($disable) && $disable == false))
                                        <!-- Box quick sign up for subscrbe store  -->
                                            @include('elements.v2-subscribe-store-box')
                                        @endif
                                    <!-- Normal coupons -->
                                        @if(sizeof($store['coupons']) === 0)
                                            {{--<p>--}}
                                            {{--We are updating  <strong>{{ $store['name'] }}</strong> {{config('config.coupon')}} at the moment. Since you are here with us, we do not want you to leave with nothing.--}}
                                            {{--<a style="font-size: 24px" id="requestCoupon" data-toggle="modal" data-target="#modalRequestCoupon">Click here</a> to request a coupon and we will strive to update within 5 minutes.--}}
                                            {{--</p>--}}
                                            <div class="coupon-item-box col-xs-12 box-request-coupon" style="border:1px solid #ccc">

                                            </div>
                                        @else
                                            @if(count($store['coupons'])>0)
                                                {{--   <div class="suggested-list">
                                                       <h2>TOP COUPONS</h2>
                                                   </div>--}}
                                            @endif
                                            @foreach($store['coupons'] as $k=>$c)
                                                <?php $style="border:2px solid #0FD4B1;border-radius:4px" ?>
                                                <?php $c=(array)$c; ?>
                                                @include('enter-elements.coupon-items-v')
                                                @if($k == 1)
                                                    {{--GA--}}
                                                    <div class="coupon-item-box ga-box" style="margin-top: 0;background: none;border: none;">
                                                        @include('GA.ga-dpf')
                                                    </div>
                                                @endif
                                            @endforeach
			@include('GA.ga-dpf')
                                            {{--Display show more--}}
                                            @if (($countcoupon=$store['coupon_count']) >= 20)
                                                <div class="more-coupon" id="show-more">
                                                    <p>Showing <span class="size-coupon">100</span> of <span class="length">{{$countcoupon}}</span></p>
                                                    <a class="btn show-coupon-btn load-more show-more-coupons"><i class="fa fa-arrow-circle-o-down"></i> Show Next <span class="next">100</span> Coupons</a>
                                                </div>
                                                <!-- a href="javascript:;" class="load-more ajax-loading"><i class="fa fa-spinner fa-pulse"></i> Load More Coupons</a -->
                                            @endif
                                        @endif
                                    </div>
                                <!--end a items -->
                                </div>



                            </div>
                        </div>
                        <!--end main col -->
                    </div>
                </div>
            </div>
        </div>
        @if(Route::current()->getParameter('couponGo'))
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
            <div class="modal" id="getCodeModal">
                <h1>Loading...</h1>
            </div>
            <a href="#getCodeModal" rel="modal:open" id="modal-click"></a>
            <script>
                $('#modal-click').on('click', function(){
                    $.ajax({
                        url: '{{url('/go/getCode/'.Route::current()->getParameter('couponGo'))}}',
                        dataType: 'text',
                        success: function(data) {
                            $('#getCodeModal').html('').append(data);
                        }
                    });
                });
                $('#modal-click').click();
            </script>
        @endif

        <script>
            var offsetPage = 100;
            var limitPage = 100;
            $(document).ready(function(){
                $('.filter-item').on('click', function () {
                    var $that = $(this).find('input:eq(0)');
                    $.ajax({
                        type: 'get',
                        url: "{{url('/session/filterCoupon')}}",
                        data: {
                            alias : '{{$store['alias']}}',
                            coupon_type : $that.val(),
                            checked: $that.is(':checked')
                        }
                    }).done(function (data) {
                        location.reload();
                    });
                    $(this).find('input').attr('checked',1);
                });
                $('.show-more-coupons').on('click', function (e) {
                    e.preventDefault();
                    var $that = $(this);
                    $that.find('i.fa').addClass('fa-spinner fa-pulse').removeClass('fa-arrow-circle-o-down');
                    $.ajax({
                        type: 'get',
                        url: '{{url('/store/showMoreCoupons')}}',
                        data: {storeId : '{{$store['id']}}', offset : offsetPage, limit : limitPage }
                    }).done(function (data) {
                        if (data.status == 'error') {
                            $that.remove();
                        } else {
                            $(data).insertBefore($('#show-more'));
                            moreTextBox();//func in footer
                            offsetPage += limitPage;
//                        initGlobal();
//                 initGetCode();
//                 truncateSomething();
                            $that.find('i.fa').removeClass('fa-spinner fa-pulse').addClass('fa-arrow-circle-o-down');
                            $('.size-coupon').text(parseInt($('.size-coupon').text())+100);
                        }
                    });
                });

                /* Function request update coupon */
                $('#requestCoupon').click(function () {
                    console.log('send request');
                    window.open('https://www.amazon.com/?&_encoding=UTF8&tag=668239901102-20');
                    $.ajax({
                        type: 'get',
                        url: '{{ url('/request-coupon') }}',
                        data: {
                            storeId : '{{$store['id']}}',
                            storeName : '{{$store['name']}}',
                            detail: window.location.href
                        }
                    }).done(function (response) {
                        console.log(response);
                    });
                });
            });
            /* show more content by haidang*/
            // Configure/customize these variables.

            $(document).ready(function() {
                reMoreText(80, '#store-detail-list-coupon .more')
                reMoreText();
                $("body").on('click', '.more .morelink', function(){
                    if($(this).hasClass("less")) {
                        $(this).removeClass("less");
                        $(this).html(moretext);
                    } else {
                        $(this).addClass("less");
                        $(this).html(lesstext);
                    }
                    $(this).parent().prev().toggle();
                    $(this).prev().toggle();
                    return false;
                });
            });
        </script>
        <script src="https://raw.githubusercontent.com/jedfoster/Readmore.js/master/readmore.min.js"></script>
        <script src="{{ asset('vendor/jquery-validate/jquery.validate.min.js') }}"></script>
        <script type="text/javascript">
            var widgetSubmitCoupon;
            var CaptchaCallback = function () {
                widgetSubmitCoupon = grecaptcha.render('reCaptchaSubmit', {'sitekey': '{{ $reCapcha_public_key }}'});
            };
            function hasFormValidation(){return"reportValidity"in document.createElement("form")}
            $(document).ready(function ($) {
                $('#cash-back-show-more').on('click', function(){
                    var $that = this;
                    var $obj = $('#limited-visibility');
                    $($that).addClass('CB-showing');
                    $($obj).addClass('unlimited');
                    $($obj).addClass('scrollbar-auto').perfectScrollbar({useBothWheelAxes : true, useSelectionScroll : true});
                });

                /**
                 * Old JS for Submit coupon form
                 * ****/

                var $form = $('#submit-box-form');
                var addCouponValidator = $form.validate({
                    rules: {
                        title: {
                            required: true,
                            minlength: 10,
                            maxlength: 200
                        },
                        description: {
                            minlength: 25,
                            maxlength: 500
                        },
                        couponCode: {
                            minlength: 2,
                            maxlength: 15
                        }
                    },
                    messages: {
                        title: {
                            required: 'Please enter the offer title.',
                            minlength: 'Please give more details for the title'
                        },
                        description: {
                            required: 'Please enter the offer details.',
                            minlength: 'Please add a little more detail about the offer.'
                        },
                        couponCode: {
                            minlength: 'That code looks a bit short. Please double check and try again.',
                            maxlength: 'That code looks a bit long. Please double check and try again.'
                        }
                    },
                    errorElement: "span", // contain the error msg in a small tag
                    errorClass: 'help-block myErrorClass',
                    focusInvalid: false,
                    invalidHandler: function (form, validator) {
                        if (!validator.numberOfInvalids())
                            return;
                        $('html, body').animate({
                            scrollTop: $('#submit-box-form').offset().top - 100//$(validator.errorList[0].element).offset().top
                        }, 1000);

                    },
                    errorPlacement: function (error, element) { // render error placement for each input type
                        if (element.attr("type") == "radio" || element.attr("type") == "checkbox" || element.attr("type") == "file") { // for chosen elements, need to insert the error after the chosen container
                            error.insertAfter($(element).closest('.form-group').children('div').children().last());
                        } else if (element.hasClass("ckeditor")) {
                            error.appendTo($(element).closest('.form-group'));
                        } else if (element.parent().hasClass("input-group")) {
                            error.insertAfter(element.parent());
                        } else {
                            error.insertAfter(element);
                            // for other inputs, just perform default behavior
                        }
                    },
                    highlight: function (element, errorClass, validClass) {
                        var elem = $(element);
                        if (elem.hasClass("select2-offscreen")) {
                            $("#s2id_" + elem.attr("id") + " ul").addClass(errorClass);
                        } else {
                            $(element).closest('.help-block').removeClass('valid');
                            // display OK icon
                            $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                            // add the Bootstrap error class to the control group
                        }
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        // revert the change done by hightlight
                        var elem = $(element);
                        if (elem.hasClass("select2-offscreen")) {
                            $("#s2id_" + elem.attr("id") + " ul").removeClass(errorClass);
                        } else {
                            $(element).closest('.form-group').removeClass('has-error');
                            // set error class to the control group
                        }
                    },
                    success: function (label, element) {
                        label.addClass('help-block valid');
                        // mark the current input as valid and display OK icon
                        $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                    }
                });

                $form.on('submit', function (e) {
                    e.preventDefault();
                    if ($form.valid()) {
                        $form.find('button[type="submit"]').empty().append("<i class='fa fa-spinner fa-pulse'></i>").addClass('disabled');
                        $.ajax({
                            type: 'post',
                            url: $form.attr('action'),
                            data: $form.serialize(),
                            success: function (data) {
                                if (data.status == 'success') {
                                    /*
                                     Author:HaiHT
                                     If submited success then add submited coupon id to local storage
                                     */
                                    if(data.msg['id']){
                                        saveSubmitedCouponsToLocalStorage(data.msg['id']);
                                    }
                                    addCouponValidator.resetForm();
                                    $form[0].reset();
                                    $('.coupon-code').attr('placeholder', 'Enter your code *').rules('add', {
                                        required: true
                                    });
                                    $(".select-store").select2('data', null);
                                    $form.find('button[type="submit"]').empty().text("SUBMITTED SUCCESSFULLY");
                                    $form.find('button[type="submit"]').prev('span').remove();
                                } else if (data.status == 'error') {
                                    $("<span class='help-block myErrorClass'>" + data.msg + "</span>").insertBefore($('#btn-submit-box'));
                                }
                                setTimeout(function () {
                                    $form.find('button[type="submit"]').empty().text("SUBMIT {{config('config.coupon')}} CODE").removeClass('disabled');
                                },3000);
                                grecaptcha.reset(widgetSubmitCoupon);
                            }
                        });
                    } else grecaptcha.reset(widgetSubmitCoupon)
                });

                $('#couponType').on('change', function () {
                    var cur = $(this).val();
                    if (cur == 'Coupon Code') {
                        $('.coupon-code').attr('placeholder', 'Enter your code *').rules('add', {
                            required: true
                        });
                    } else if (cur == 'Free Shipping') {
                        $('.coupon-code').attr('placeholder', 'Enter your code').removeClass('required').rules('remove', 'required');
                    } else if (cur == 'Great Offer') {
                        $('.coupon-code').attr('placeholder', 'Enter your code').removeClass('required').rules('remove', 'required');
                    }
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


                /* Function request update coupon */
                $('#requestCoupon').click(function () {
                    console.log('send request');
                    window.open('https://www.amazon.com/?&_encoding=UTF8&tag=668239901102-20');
                    $.ajax({
                        type: 'get',
                        url: '{{ url('/request-coupon') }}',
                        data: {
                            storeId : '{{$store['id']}}',
                            storeName : '{{$store['name']}}',
                            detail: window.location.href
                        }
                    }).done(function (response) {
                        console.log(response);
                    });
                });
            });
        </script>
    <!-- <script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script> -->
    @include('elements.auto-update-coupon')
@endsection