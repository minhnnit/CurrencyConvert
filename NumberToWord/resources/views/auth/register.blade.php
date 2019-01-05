{{-- */$noRobot = true;/* --}}
@extends('app')
@section('scripts')
    <script src="{{asset('js/crop-component.js')}}" type="text/javascript" async defer></script>
    <script src="{{ asset('vendor/jquery/jquery-1.11.4.ui.min.js'.$common['version_app']) }}" type="text/javascript" async defer></script>
@endsection
@section('before-header')
    @include('elements.changeAvatarModal')
@endsection
@section('content')
    <div class="container">
        <div class="row page-register">
            <div class="page-header">
                <h1 class="page-title">Sign Up</h1>
            </div>
            <div class="table-step">
                <ul id="register-step" class="step-by-step clearfix">
                    <li class="col-sm-3 active" data-current="#step-0" data-target="#step-1">
                        <div>1<span>. Registration</span> <i class="fa fa-check"></i></div>
                    </li>
                    <li class="col-sm-3" data-current="#step-1" data-target="#step-2">
                        <div>2<span>. Favorites</span> <i class="fa fa-check"></i></div>
                    </li>
                    <li class="col-sm-3" data-current="#step-2" data-target="#step-3">
                        <div>3<span>. Personal Info</span> <i class="fa fa-check"></i></div>
                    </li>
                    <li class="col-sm-3" data-current="#step-3" data-target="#step-0">
                        <div>4<span>. Finish</span> <i class="fa fa-check"></i></div>
                    </li>
                </ul>
            </div>
            <form id="register-form" class="form-horizontal pro-e-form" method="post" action="{{ url('/register') }}" autocomplete="off">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                <input style="display:none" type="text" name="fakeusernameremembered"/>
                <input style="display:none" type="password" name="fakepasswordremembered"/>
                <div id="step-0" class="register-box-default sign-up-account">
                    <div class="box-content">
                        <div class="row sign-up-form">
                            <div class="col-md-3 col-sm-2 hidden-xs">&nbsp;</div>
                            <div class="col-md-6 col-sm-8">
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <input type="email" id="sign-username" class="form-control" placeholder="Email address (*)" aria-describedby="sign-username" required name="email">
                                        <label class="input-group-addon envelope-input" for="sign-username"><i class="fa fa-envelope"></i></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <input type="password" id="sign-password" class="form-control" placeholder="Password (*)" aria-describedby="sign-password" name="password">
                                        <label class="input-group-addon password-input" for="sign-password"><i class="fa fa-lock"></i></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <input type="password" id="sign-re-password" class="form-control" placeholder="Re-type your password" aria-describedby="sign-re-password" name="password_confirmation">
                                        <label class="input-group-addon password-input" for="sign-re-password"><i class="fa fa-lock"></i></label>
                                    </div>
                                </div>
                                <div class="sign-up-policy text-center margin-bottom-35">
                                    <p>By joining, you agree to the <a href="{{url('/TermsPage')}}">Terms & Conditions</a> and <a href="{{url('/PrivacyPolicy')}}">Privacy Policy</a>.</p>
                                    <div class="sign-up-social">
                                        <div class="or-text">or Sign Up with</div>
                                        <div class="social-buttons">
                                            <a href="{{url('/login/facebook')}}" class="facebook"><i class="fa fa-facebook-square"></i></a>
                                            <a href="{{url('/login/twitter')}}" class="twitter"><i class="fa fa-twitter-square"></i></a>
                                            <a href="{{url('/login/google')}}" class="google"><i class="fa fa-google-plus-square"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-2 hidden-xs"></div>
                        </div>
                        <div class="form-footer">
                            <button type="button" class="btn btn-theme btn-update" onclick="nextStep()">Next</button>
                        </div>
                    </div>
                </div>
                <div id="step-1" class="register-box-default favorite-select hidden">
                    <div class="box-content">
                        <div class="box-stores-select">
                            <div class="box-title">Select your favorite stores:</div>
                            <div class="row box-stores-list">
                                @foreach($data['cashBackStores'] as $index => $s)
                                <div class="col-lg-2 col-sm-3 col-xs-6 item-store{{($index > 3) ? ' visible-lg' : ' '}}">
                                    <div class="logo-box">
                                        <div class="store-logo">
                                            <a id="{{$s['id']}}" class="item-likes fav-without-login item-likes click-to-save"><i class="fa fa-heart"></i></a>
                                            <img src="{{$s['logo']}}" alt="{{$s['name']}}" />
                                        </div>
                                    </div>
                                    <div class="store-title">
                                        <div class="store-name">{{$s['name']}}</div>
                                        @if (!empty($s['cash_back_json']['currency']))
                                        <div class="cash-title">Up to {{$s['cash_back_json']['currency'] == '%' ? $s['cash_back_json']['cash_back_percent'].'%' : $s['cash_back_json']['currency'].$s['cash_back_json']['cash_back']}} Cash Back</div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="box-categories-select">
                            <div class="box-title">Subscribe to your favorite categories:</div>
                            <div class="categories-box scrollbar-auto">
                                <ul class="box-categories-list clearfix">
                                    @foreach($data['categories'] as $c)
                                    <li class="col-lg-3 col-sm-4 col-xs-6">
                                        <label>
                                            <input type="checkbox" name="categoriesId[]" value="{{$c['id']}}">
                                            {{$c['name']}}</label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="form-footer">
                            <a href="javascript:skipStep();" class="btn-skip">Skip</a>
                            <button type="button" class="btn btn-theme btn-update"  onclick="skipStep()">Next</button>
                        </div>
                    </div>
                </div>
                <div id="step-2" class="register-box-default edit-profile-form hidden">
                    <div class="box-content">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group text-center">
                                    <div class="details-avatar">
                                        <img src="{{asset('/images/no-avatar.png')}}" id="pro-e-avar" />
                                        <input type="hidden" name="avatar" id="register-avatar" value="">
                                        <small data-provide="cropSelector"><i class="fa fa-pencil"></i></small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="username" class="col-xs-3 control-label">Username</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control required" required name="username" id="username" value="" placeholder="Username">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fullName" class="col-xs-3 control-label">Full name</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="fullname" id="fullName" value="" placeholder="Full name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gender" class="col-xs-3 control-label">Gender</label>
                                    <div class="col-xs-9">
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="-1" disabled >Select your gender </option>
                                            <option value="1"> Male </option>
                                            <option value="0"> Female </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="birthday" class="col-xs-3 control-label">Birthday</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control format-date-input birthday" name="birthday" id='birthday' placeholder="Your Birthday" value="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="address" class="col-xs-3 control-label">Address</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="address" id="address" value="" placeholder="Address">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="country" class="col-xs-3 control-label">Country</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="country" id="country" value="" placeholder="Country">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="zipcode" class="col-xs-3 control-label">Zip Code</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="zipcode" id="zipcode" value="" placeholder="Zip Code">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="col-xs-3 control-label">Phone</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="phone" id="phone" value="" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="website" class="col-xs-3 control-label">Website</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control url" name="website" id="website" value="" placeholder="http://your-website.com">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="hobbies" class="col-xs-3 control-label">Hobbies</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="hobbies" id="hobbies" value="" placeholder="Shopping, Gaming, Sports...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bio" class="col-xs-3 control-label">Bio</label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control resize-v profile-bio-input" name="bio" id="bio" placeholder="Write your brief bio..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn-link btn-skip">Skip</button>
                            <button type="submit" class="btn btn-theme btn-update">Next</button>
                        </div>
                    </div>
                </div>
            </form>
            <div id="step-3" class="register-box-default sign-up-success hidden">
                <div class="box-content">
                    <div class="success-title">
                        Sign Up Success!
                    </div>
                    <div class="success-info">
                        <p>Your account has been created and an email was sent to the address you provided (<strong id="register-email"></strong>).
                        Please click on the link in that email to verify your email address and activate your account. Thanks.</p>
                        <div class="note">Shop now to get $10 new member bonus</div>
                    </div>
                    <div class="form-footer text-center">
                        <a type="button" class="btn btn-theme btn-update" href="{{url('/')}}">Start Shopping!</a>
                    </div>
                </div>
            </div>
            <div id="loading-step" class="register-box-default">
                <div class="box-content box-loading">
                    <i class="fa fa-spinner fa-pulse"></i>&nbsp;&nbsp;&nbsp; Loading...
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#sign-username').blur(function () {
            var that = $('#sign-username');
            if (that.val())
            $.ajax({
                type: 'get',
                url: '{{url('/user/emailExists')}}',
                data: {email: that.val()}
            }).done(function (data) {
                if (data.status == 'Not Exists') {
                    that.closest('.form-group').find('.check-email').remove();
                    that.closest('.form-group').addClass('has-success').removeClass('has-error');
                    that.closest('.form-group').append("<span class='check-email help-block'>This email doesn't exists!</span>");
                } else if (data.status == 'Exists') {
                    that.closest('.form-group').find('.check-email').remove();
                    that.closest('.form-group').removeClass('has-success').addClass('has-error');
                    that.closest('.form-group').append("<span class='check-email help-block'>This email already exists.Please enter an other email!</span>");
                }
            });
        });
        var $form = $('#register-form');
        var addRegisterValidator = $form.validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        minlength: 5,
                        maxlength: 100
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 32
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 6,
                        maxlength: 32,
                        equalTo: "#sign-password"
                    }
                },
                errorElement: "span", // contain the error msg in a small tag
                errorClass: 'help-block myErrorClass',
                focusInvalid: false,
                invalidHandler: function (form, validator) {
                    if (!validator.numberOfInvalids())
                        return;
                    $('html, body').animate({
                        scrollTop: $form.offset().top - 100//$(validator.errorList[0].element).offset().top
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
        function handAvatar(fileData){
            $("#pro-e-avar").attr('src', fileData);
            $("#register-avatar").val(fileData);
            /*$.ajax({
             type: 'post',
             url: '{{url('/profile/upload-avatar')}}',
             data: {file : fileData, _token: '{{csrf_token()}}'}
             }).done(function (data) {
             if (data.status == 'success') {
             $('.profile-avatar>.avatar').find('img').attr('src',data.avatarUrl + '?' + Math.floor((Math.random() * 100) + 1));
             } else if (data.status == 'error') {
             }
             });*/
        }
        function nextStep(){
            //All action will be here before to next
            var that = $('#sign-username');
            if (that.val())
                $.ajax({
                    type: 'get',
                    url: '{{url('/user/emailExists')}}',
                    data: {email : that.val()}
                }).done(function (data) {
                    if (data.status == 'Not Exists') {
                        that.closest('.form-group').find('.check-email').remove();
                        that.closest('.form-group').addClass('has-success').removeClass('has-error');
                        that.closest('.form-group').append("<span class='check-email help-block'>This email doesn't exists!</span>");
                        $('#username').val(that.val());
                        $('#register-email').text(that.val());
                        //Call skipStep for next
                        if ($form.valid()) {
                            skipStep();
                        }
                    } else if (data.status == 'Exists') {
                        that.closest('.form-group').find('.check-email').remove();
                        that.closest('.form-group').removeClass('has-success').addClass('has-error');
                        that.closest('.form-group').append("<span class='check-email help-block'>This email already exists.Please enter an other email!</span>");
                        return;
                    }
                });
            else if (!$form.valid()) {
                return;
            }
        }
        function skipStep(){
            var $element        = $("#register-step");
            var $loading        = $("#loading-step");
            var $currentStep    = null;
            var $nextStep       = null;
            $($element).find('li').each(function(){
                var $that = this;
                if($nextStep !== null){
                    $($currentStep).addClass('hidden');
                    $($loading).show();
                    $($that).addClass('active');
                    $($nextStep).removeClass('hidden');
                    $($loading).hide();
                    return false;
                }else if($($that).hasClass('active')){
                    $nextStep   = $($that).attr('data-target');
                    $currentStep = $($that).attr('data-current');
                    $($nextStep).addClass('hidden');
                    $($that).removeClass('active').addClass('complete');
                }
            });
        }
        $form.on('submit', function (e) {
            e.preventDefault();
            var that = $('#email');
            if ($form.valid()) {
//                $form.find('button[type="submit"].btn-update').empty().append("<i class='fa fa-spinner fa-pulse'></i>").addClass('disabled');
                $.ajax({
                    type: 'post',
                    url: $form.attr('action'),
                    data: $form.serialize()
                }).done(function (data) {

                    if (data.status == '200') {
                        /*Send local storage of this user to api*/
                        var localUserData = {
                            email : that.val(),
                            data : localStorage,
                            _token : $('#_token').val()
                        };
                        $.ajax({
                            type: 'post',
                            url: "{{url('/user/saveLocalStorage/')}}",
                            data : localUserData
                        }).done(function (resp) {
                            if(resp.status == 'success'){
                                localStorage.clear();
                            }
                        });
                        /*End*/
                        skipStep();
//                        $form.empty().text("Register successful! Please check your email to active account.");
                    } else if (data.status == 'error') {
                    }
//                    $form.find('button[type="submit"].btn-update').empty().append("Next").removeClass('disabled');
                });
            }
        });
    </script>
@endsection
