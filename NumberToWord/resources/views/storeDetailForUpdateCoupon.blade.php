@extends('app')

@section('scripts')
    <script src="{{ asset('vendor/jquery/jquery-1.11.4.ui.min.js'.$common['version_app']) }}" type="text/javascript" async defer></script>
@endsection

@section('scripts-footer')
    <script type="text/javascript">
        var widgetSubmitCoupon;
        var CaptchaCallback = function () {
            widgetSubmitCoupon = grecaptcha.render('reCaptchaSubmit', {'sitekey': '{{ $reCapcha_public_key }}'});
        };
        $(document).ready(function ($) {
            $('#cash-back-show-more').on('click', function(){
                var $that = this;
                var $obj = $('#limited-visibility');
                $($that).addClass('CB-showing');
                $($obj).addClass('unlimited');
                $($obj).addClass('scrollbar-auto').perfectScrollbar({useBothWheelAxes : true, useSelectionScroll : true});
            });

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
            var $validated = hasFormValidation();
            var $formSubscribe = $('.subscribe-store-form');
            $formSubscribe.on('submit', function (e) {
                var $that = $(this);
                e.preventDefault();
                if (!$validated ) {
                    $validated = validateEmailElement($that);
                }
                if($validated){
                    $that.find("button[type='submit']").empty().append("<i class='fa fa-spinner fa-pulse'></i>").addClass('disabled');
                    $.ajax({
                        type: 'post',
                        url: $that.attr('action'),
                        data: $that.serialize()
                    }).done(function (data) {
                        if (data.status) {
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
                }
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

            $('.filter-coupon-type').on('click', function () {
                var $that = $(this);
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
            });

            $('.show-more-coupons').on('click', function (e) {
                e.preventDefault();
                var $that = $(this);
                $that.find('i.fa').addClass('fa-spinner fa-pulse').removeClass('fa-arrow-circle-o-down');
                $.ajax({
                    type: 'get',
                    url: '{{url('/store/showMoreCoupons')}}',
                    data: {storeId : '{{$store['id']}}'}
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

            /* Function request update coupon */
            $('#requestCoupon').click(function () {
                console.log('send request');
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
    @include('elements.auto-update-coupon')
@endsection