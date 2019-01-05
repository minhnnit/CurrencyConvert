<form class="form" id="submit-box-form" action="{{url('/coupon/submitCoupon')}}" method="post">
    <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <!-- <fieldset {{Session::has('user.id') ? '' : 'disabled'}}> -->
        <fieldset>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-6">
                        <!-- <div class="form-group">
                            @if($store['id'])
                            <input type="hidden" id="storeName" name="storeId" value="{{$store['id']}}" class="form-control required" {{Session::has
                            ('user.id') ? '' : 'disabled'}}/>
                            <input type="text" value="{{$store['name']}}" class="form-control" disabled />
                            @else
                            <input type="text" id="storeName" name="storeId" class="form-control required select-store" {{Session::has('user.id') ? '' : 'disabled'}}/>
                            @endif
                        </div> -->
                        <div class="form-group">
                            @if($store['id'])
                            <input type="hidden" id="storeName" name="storeId" value="{{$store['id']}}" class="form-control required" />
                            <input type="text" value="{{$store['name']}}" class="form-control" disabled />
                            @else
                            <input type="text" id="storeName" name="storeId" class="form-control required select-store" />
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="title" class="form-control submit-box-title required"
                                   placeholder="Enter title *"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <select name="couponType" id="couponType" class="form-control required" autocomplete="off">
                                <option value="Coupon Code" selected="selected">{{config('config.Coupon')}} Code</option>
                                <option value="Free Shipping">Free {{config('config.Shipping')}}</option>
                                <option value="Great Offer">Great Offer</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" class="form-control required coupon-code" name="couponCode"
                                   placeholder="Enter your code *"/>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control" name="eventId">
                                <option value="">Choose event (optional)</option>
                                {{--@foreach($events as $event)--}}
                                    <option value="{{--$event['id']--}}">{{--$event['name']--}}</option>
                                {{--@endforeach--}}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
            </div>-->
            <div class="col-sm-6">
                <div class="form-group">
                <textarea class="form-control required" rows="8" name="description"
                          placeholder="% discount, date of expiry, ongoing events...."></textarea>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <input type="text" class="form-control datepicker" name="expireDate"
                           placeholder="Expire Date"/>
                </div>
                <div class="form-group hidden-over">
                    <div id="reCaptchaSubmit" class="g-recaptcha"></div>
                    {{--@if (Session::has('user.id'))--}}
                    <button type="submit" id="btn-submit-box" class="btn btn-block btn-submit">
                        Submit {{config('config.coupon')}} code
                    </button>
                    {{--@else--}}
                    <!-- <a href="{{url('/login')}}">Please login before submit {{config('config.coupon')}}.</a> -->
                    {{--@endif--}}
                </div>
            </div>
    </fieldset>
</form>
<script>
    var widgetId1;
    var CaptchaCallback = function () {
        widgetId1 = grecaptcha.render('reCaptchaSubmit', {'sitekey': '{{ $reCapcha_public_key }}'});
    };
    $(document).ready(function() {
        function repoFormatResultStore(repo) {
            var markup = "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__title'>" + repo.name + "</div>";

            markup += "<div class='select2-result-repository__description'>" + repo.storeUrl + "</div>";
            markup += "</div>";
            return markup;
        }

        function repoFormatSelectionStore(repo) {
            return repo.name;
        }

        $(".select-store").select2({
            placeholder: "Only use store name suggest by us *",
            minimumInputLength: 2,
            // instead of writing the function to execute the request we use Select2's convenient helper
            ajax: {
                url: "{{url('/store/getStores/')}}",
                dataType: "json",
                quietMillis: 500,
                delay: 500,
                data: function (term, page) {
                    return {
                        // search term
                        q: term
                    };
                },
                results: function (data, page) {
                    // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to alter the remote JSON data
                    return {results: data.items};
                },
                cache: true
            },
            formatResult: repoFormatResultStore,
            formatSelection: repoFormatSelectionStore
        });

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
                        grecaptcha.reset(widgetId1);
                    }
                });
            } else grecaptcha.reset(widgetId1)
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
    });
</script>