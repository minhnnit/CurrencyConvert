@extends('profile.v2-profile-app')

@section('scripts')
    <script src="{{asset('js/crop-component.js')}}" type="text/javascript" async defer></script>
@endsection
@section('before-header')
    @include('elements.changeAvatarModal')
@endsection
@section('profile-content')
    <div class="profile-box-default edit-profile-form">
        <h3 class="box-header has-collapse" data-toggle="collapse" href="#collapse-profile-details" aria-expanded="true">Details <i class="fa fa-caret-up"></i></h3>
        <div id="collapse-profile-details" class="collapse in">
            <div class="box-content">
                <form id="edit-profile-form" class="form-horizontal pro-e-form" method="post" action="{{url('/profile/edit')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group text-center">
                                <div class="details-avatar">
                                    <img src="{{!empty($user['avatar']) ? $user['avatar'] : asset('/images/no-avatar.png')}}" id="pro-e-avar" />
                                    <small data-provide="cropSelector"><i class="fa fa-pencil"></i></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-xs-3 control-label">Username</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control required" required name="username" id="username" value="{{$user['username']}}" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fullName" class="col-xs-3 control-label">Full name<span class="requirement">*</span></label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="fullname" required id="fullName" value="{{$user['fullname']}}" placeholder="Full name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="gender" class="col-xs-3 control-label">Gender<span class="requirement">*</span></label>
                                <div class="col-xs-9">
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="-1" disabled {{!empty($user['gender']) ? '' : 'selected'}}>Select your gender </option>
                                        <option value="1" {{$user['gender'] === 1 ? 'selected' : ''}}> Male </option>
                                        <option value="0" {{$user['gender'] === 0 ? 'selected' : ''}}> Female </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="birthday" class="col-xs-3 control-label">Birthday<span class="requirement">*</span></label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control format-date-input birthday" name="birthday" required id='birthday' placeholder="Your Birthday" value="{{$user['birthday']}} " />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="address" class="col-xs-3 control-label">Address<span class="requirement">*</span></label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="address" id="address" required  value="{{$user['address']}}" placeholder="Address">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="country" class="col-xs-3 control-label">Country<span class="requirement">*</span></label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="country" required id="country" value="{{$user['country']}}" placeholder="Country">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="zipcode" class="col-xs-3 control-label">Zip Code</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="zipcode" id="zipcode" value="{{$user['zipcode']}}" placeholder="Zip Code">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-xs-3 control-label">Phone</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="phone" id="phone" value="{{$user['phone']}}" placeholder="Phone">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="website" class="col-xs-3 control-label">Website</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control url" name="website" id="website" value="{{$user['website']}}" placeholder="http://your-website.com">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hobbies" class="col-xs-3 control-label">Hobbies<span class="requirement">*</span></label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="hobbies" required id="hobbies" value="{{$user['hobbies']}}" placeholder="Shopping, Gaming, Sports...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bio" class="col-xs-3 control-label">Bio</label>
                                <div class="col-xs-9">
                                    <textarea class="form-control resize-v profile-bio-input" name="bio" id="bio" placeholder="Write your brief bio...">{{$user['bio']}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-theme btn-update">Update</button>
                        <div class="pro-notes">Notes: Please fill in all the fields with (<span class="requirement">*</span>) and your <a href="{{url('/profile/cash-back')}}">Payment Address</a> to complete your profile! </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="profile-box-default edit-profile-form">
        <h3 class="box-header has-collapse collapsed" data-toggle="collapse" href="#collapse-profile-change-pass" aria-expanded="false">Change email & password <i class="fa fa-caret-up"></i></h3>
        <div id="collapse-profile-change-pass" class="collapse">
            <div class="box-content">
                <form id="edit-email-password-form" class="form-horizontal pro-e-form" method="post" autocomplete="off" action="{{url('/profile/preference/changeEmail')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-lg-3 col-xs-4 control-label">Current Email</label>
                                <div class="col-lg-9 col-xs-8">
                                    <div class="field-input">{{$user['email']}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="newEmail" class="col-lg-3 col-xs-4 control-label">New Email</label>
                                <div class="col-lg-9 col-xs-8">
                                    <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Enter the new email address">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cEmail" class="col-lg-3 col-xs-4 control-label">Confirm Email</label>
                                <div class="col-lg-9 col-xs-8">
                                    <input type="email" class="form-control" name="confirmEmail" id="confirmEmail" placeholder="Re-enter the new email address">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="currentPassword" class="col-lg-3 col-xs-4 control-label">Current Password</label>
                                <div class="col-lg-9 col-xs-8">
                                    <input type="password" class="form-control" name="currentPassword" id="currentPassword" placeholder="Enter your current password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="newpassword" class="col-lg-3 col-xs-4 control-label">New Password</label>
                                <div class="col-lg-9 col-xs-8">
                                    <input type="password" class="form-control" name="passwordNew" id="passwordNew" placeholder="Enter your new password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword" class="col-lg-3 col-xs-4 control-label">Confirm Password</label>
                                <div class="col-lg-9 col-xs-8">
                                    <input type="password" class="form-control" name="passwordNewConfirm" id="passwordNewConfirm" placeholder="Confirm your new password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-theme btn-update">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="profile-box-default">
        <h3 class="box-header has-collapse collapsed" data-toggle="collapse" href="#collapse-profile-social" aria-expanded="false">Social networks <i class="fa fa-caret-up"></i></h3>
        <div id="collapse-profile-social" class="collapse">
            <div class="box-content social-form">
                <form id="edit-social-form" class="form-horizontal pro-e-form" method="post" autocomplete="off" action="{{url('/profile/edit')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="social-facebook" class="col-xs-1 control-label"><span class="icon-social facebook"><i class="fa fa-facebook"></i></span></label>
                                <div class="col-xs-11">
                                    <input type="text" class="form-control url" name="linkFacebook" id="social-facebook" value="{{$user['link_facebook']}}" placeholder="https://www.facebook.com/user_id">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="social-twitter" class="col-xs-1 control-label"><span class="icon-social twitter"><i class="fa fa-twitter"></i></span></label>
                                <div class="col-xs-11">
                                    <input type="text" class="form-control url" name="linkTwitter" id="social-twitter" value="{{$user['link_twitter']}}" placeholder="https://twitter.com/user_id">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="social-google" class="col-xs-1 control-label"><span class="icon-social google"><i class="fa fa-google-plus"></i></span></label>
                                <div class="col-xs-11">
                                    <input type="text" class="form-control url" name="linkGoogleplus" id="social-google" value="{{$user['link_googleplus']}}" placeholder="https://plus.google.com/user_id">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 social-form-control">
                            <button type="submit" class="btn btn-theme btn-update">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts-footer')
    <script type="text/javascript">
        $('.format-date-input').each(function () {
            var $that = $(this);
            if (!moment($that.val()).isValid()) return;
            $that.val(moment($that.val()).format('DD MMM YYYY'));
            /*if ($that.val().indexOf('Z') > -1) {
                $that.val(moment.tz(Date.parse($that.val()), "Europe/London").format('DD MMM YYYY'));
            }else{
                $that.val(moment.tz(Date.parse($that.val())+'Z', "Europe/London").format('DD MMM YYYY'));
            }*/
        });
        var $form = $('#edit-profile-form');
        var editProfileValidator = $form.validate({
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
        $form.on('submit', function (e) {
            e.preventDefault();
            if ($form.valid()) {
                $form.find('button[type="submit"]').empty().append("<i class='fa fa-spinner fa-pulse'></i> Saving").addClass('disabled');
                $.ajax({
                    type: 'post',
                    url: $form.attr('action'),
                    data: $form.serialize()
                }).done(function (data) {
                    if (data.status == 'success') {
                        $form.find('button[type="submit"]').parent().find('div.alert').remove();
                        $form.find('button[type="submit"]').empty().text('Saved');
                    } else if (data.status == 'error') {
                        $form.find('button[type="submit"]').parent().prepend('<div class="alert" role="alert" class="alert-danger">'+data.msg+'</div>');
                    }
                    setTimeout(function () {
                        $form.find('button[type="submit"]').empty().text('Update').removeClass('disabled');
                    },2000);
                });
            }

        });
        function handAvatar(fileData){
            $("#pro-e-avar").attr('src', fileData);
            $.ajax({
                type: 'post',
                url: '{{url('/profile/upload-avatar')}}',
                data: {file : fileData, _token: '{{csrf_token()}}'}
            }).done(function (data) {
                if (data.status == 'success') {
                    $('.profile-avatar>.avatar').find('img').attr('src',data.avatarUrl + '?' + Math.floor((Math.random() * 100) + 1));
                } else if (data.status == 'error') {
                }
            });
        }
        var $formEmail = $('#edit-email-password-form');
        var changeEmailValidator = $formEmail.validate({
            rules: {
                email: {
//                    required: true,
                    email: true,
                    minlength: 5,
                    maxlength: 100
                },
                confirmEmail: {
//                    required: true,
                    email: true,
                    minlength: 5,
                    maxlength: 100,
                    equalTo: "#inputEmail"
                },
                currentPassword : {
                    required: true,
                    minlength: 6,
                    maxlength: 32
                },
                passwordNew : {
//                    required: true,
                    minlength: 6,
                    maxlength: 32
                },
                passwordNewConfirm : {
//                    required: true,
                    minlength: 6,
                    maxlength: 32,
                    equalTo: "#passwordNew"
                }
            },
            messages: {
                passwordNewConfirm: {
                    equalTo: "These passwords don't match. Try again?"
                }
            },
            errorElement: "span", // contain the error msg in a small tag
            errorClass: 'help-block myErrorClass',
            focusInvalid: false,
            invalidHandler: function (form, validator) {
                if (!validator.numberOfInvalids())
                    return;
                $('html, body').animate({
                    scrollTop: $formEmail.offset().top - 100//$(validator.errorList[0].element).offset().top
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
        var $resetPasswordInputs = function(){
            $('input[type=password]').val('');
        };
        $formEmail.on('submit', function (e) {
            e.preventDefault();
            if ($formEmail.valid()) {
                var that = $('#inputEmail');
                if (that.val()) {
                    $.ajax({
                        type: 'get',
                        url: '{{url('/user/emailExists')}}',
                        data: {email : that.val()}
                    }).done(function (data) {
                        if (data.status == 'Not Exists') {
                            that.parent().find('.check-email').remove();
                            that.closest('.form-group').addClass('has-success').removeClass('has-error');
                            that.parent().append("<span class='check-email help-block'>This email doesn't not exists.</span>");
                            $formEmail.find('button[type="submit"]').empty().append("<i class='fa fa-spinner fa-pulse'></i> Saving").addClass('disabled');
                            $.ajax({
                                type: 'post',
                                url: $formEmail.attr('action'),
                                data: $formEmail.serialize()
                            }).done(function (data) {
                                if (data.status == 'success') {
                                    $formEmail.find('button[type="submit"]').parent().find('div.alert').remove();
                                    $formEmail.find('button[type="submit"]').empty().text('Saved');
                                    $('.pro-pre-change-mailbox .pro-pre-desc span').text(that.val());
                                    $resetPasswordInputs();
                                } else if (data.status == 'error') {
                                    $formEmail.find('button[type="submit"]').parent().find('div.alert').remove();
                                    $formEmail.find('button[type="submit"]').parent().prepend('<div class="alert alert-danger" role="alert" class="alert-danger">'+data.msg+'</div>');
                                }
                                setTimeout(function () {
                                    $formEmail.find('button[type="submit"]').empty().text('Update').removeClass('disabled');
                                },5000);
                            });
                        } else if (data.status == 'Exists') {
                            that.parent().find('.check-email').remove();
                            that.closest('.form-group').removeClass('has-success').addClass('has-error');
                            that.parent().append("<span class='check-email help-block myErrorClass'>This email exists.Please enter a other email.</span>");
                        }
                    });
                }else {
                    $formEmail.find('button[type="submit"]').empty().append("<i class='fa fa-spinner fa-pulse'></i> Saving").addClass('disabled');
                    $.ajax({
                        type: 'post',
                        url: $formEmail.attr('action'),
                        data: $formEmail.serialize()
                    }).done(function (data) {
                        if (data.status == 'success') {
                            $formEmail.find('button[type="submit"]').parent().find('div.alert').remove();
                            $formEmail.find('button[type="submit"]').empty().text('Saved');
                            $('.pro-pre-change-mailbox .pro-pre-desc span').text(that.val());
                            $resetPasswordInputs();
                        } else if (data.status == 'error') {
                            $formEmail.find('button[type="submit"]').parent().find('div.alert').remove();
                            $formEmail.find('button[type="submit"]').parent().prepend('<div class="alert alert-danger" role="alert" class="alert-danger">'+data.msg+'</div>');
                        }
                        setTimeout(function () {
                            $formEmail.find('button[type="submit"]').empty().text('Update').removeClass('disabled');
                        },5000);
                    });
                }
            }
        });
        var $formSocial = $('#edit-social-form');
        var editSocialValidator = $formSocial.validate({
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
        $formSocial.on('submit', function (e) {
            e.preventDefault();
            if ($formSocial.valid()) {
                $formSocial.find('button[type="submit"]').empty().append("<i class='fa fa-spinner fa-pulse'></i> Saving").addClass('disabled');
                $.ajax({
                    type: 'post',
                    url: $formSocial.attr('action'),
                    data: $formSocial.serialize()
                }).done(function (data) {
                    if (data.status == 'success') {
                        $formSocial.find('button[type="submit"]').parent().find('div.alert').remove();
                        $formSocial.find('button[type="submit"]').empty().text('Saved');
                    } else if (data.status == 'error') {
                        $formSocial.find('button[type="submit"]').parent().prepend('<div class="alert" role="alert" class="alert-danger">'+data.msg+'</div>');
                    }
                    setTimeout(function () {
                        $formSocial.find('button[type="submit"]').empty().text('Update').removeClass('disabled');
                    },2000);
                });
            }

        });
    </script>
@endsection