@extends('profile.profile-app')

@section('profile-content')
    <div class="pro-preference clearfix">
        <div class="pro-pre-change-mailbox">
            <div class="pro-pre-headline">Change Email Address</div>
            <div class="pro-pre-desc">Your are currently registered with this email address: <span>{{$user['email']}}</span></div>
            <form class="form-horizontal pro-pre-form" id="change-email-form" action="{{url('/profile/preference/changeEmail')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="inputEmail" class="col-sm-3 control-label">New Email <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" name="email" id="inputEmail" placeholder="New Email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail2" class="col-sm-3 control-label">Confirm Email <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" name="confirmEmail" id="inputEmail2" placeholder="Confirm Email" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9 text-right">
                        <span class="alert"></span>
                        <button type="submit" class="btn dbtn btn-submits">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="pro-pre-change-passbox">
            <div class="pro-pre-headline">Change Password</div>
            <div class="pro-pre-desc">Please use this form to change your password. Your new password must be at least 6 characters long.</div>
            <form class="form-horizontal pro-pre-form" id="change-password-form" action="{{url('/profile/preference/changePassword')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @if(!empty($user['password']))
                <div class="form-group">
                    <label for="inputPassword1" class="col-sm-3 control-label">Current Password <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="passwordOld" id="inputPassword1" placeholder="Current Password" required>
                    </div>
                </div>
                @endif
                <div class="form-group">
                    <label for="inputPassword2" class="col-sm-3 control-label">New Password <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="passwordNew" id="inputPassword2" placeholder="New Password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label">Confirm Password <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="passwordNewConfirm" id="inputPassword3" placeholder="Confirm Password" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9 text-right">
                        <span class="alert"></span>
                        <button type="submit" class="btn dbtn btn-submits">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="pro-pre-deal-alertbox">
            <div class="pro-pre-headline"><strong>!</strong> COUPON/DEAL ALERTS</div>
            <div class="pro-pre-desc">Get the newest deals/coupons. Select and customize email alerts from your favorite stores.</div>
            <div class="subcri-settings row">
                <div class="col-md-4 col-sm-6 col-sms-6 custome-alert">
                    <div class="sub-sets-header">
                        <strong>1</strong><span>Customize Your Alert</span>
                    </div>
                    <div class="sub-sets-title">How often:</div>
                    <div class="sub-sets-box">
                        <!-- <form > -->
                            <div class="radio">
                                <label>
                                @if($alerts && $alerts['type'] == 'daily')
                                    <input type="radio" name="alerts" value="daily" checked="true" />
                                @else
                                    <input type="radio" name="alerts" value="daily" />
                                @endif
                                    Daily Updates
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                @if($alerts && $alerts['type'] == 'weekly')
                                    <input type="radio" name="alerts" value="weekly" checked="true" />
                                @else
                                    <input type="radio" name="alerts" value="weekly" />
                                @endif
                                    Weekly Updates
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                @if($alerts && $alerts['type'] == 'never')
                                    <input type="radio" name="alerts" value="never" checked="true" />
                                @else
                                    <input type="radio" name="alerts" value="never" />
                                @endif
                                    Never (Stop All Alerts)
                                </label>
                            </div>
                            <div class="sub-sets-subtitle">Favourite Stores:</div>
                            <div class="checkbox">
                               <!--  <label>
                                   <input type="checkbox" name="falerts" value="1" />
                                   Add My Favourite Stores To Alerts
                               </label> -->
                                <label>
                                @if($alerts['systemAlerts'] == 1)
                                    <input type="checkbox" id="sysAlerts" value="1" checked="true" />
                                @else
                                    <input type="checkbox" id="sysAlerts" value="1" />
                                @endif
                                    Receive email update from us
                                </label>
                            </div>
                            <button type="submit" id="btnSaveAlert" class="btn btn-default dbtn btn-submits">Save changes</button>
                            <br/>
                            <label class="text-success" id="lblMessage"></label>
                        <!-- </form> -->
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-sms-6 search-alert">
                    <div class="sub-sets-header">
                        <strong>2</strong><span>Stores In Favourite</span>
                    </div>
                    <!-- <div class="sub-sets-title">Select Featured Stores:</div> -->
                    <div class="sub-sets-box">
                        <!-- <select class="form-control">
                            <option disabled selected>Categories</option>
                            <option value="">&nbsp; Apparel & Accessories</option>
                            <option value="">&nbsp; Arts & Entertainment</option>
                            <option value="">&nbsp; Automotive</option>
                            <option value="">&nbsp; Beauty & Personal Care</option>
                        </select>
                        <p>Or Search</p>
                        <div class="sub-sets-input-search">
                            <i class="fa fa-search ss-ic-search"></i>
                            <input type="text" class="form-control" placeholder="ex. Home Depot" />
                        </div> -->
                        <div class="sub-sets-result-search">
                            <ul class="ul-list autoscroll listFav">
                            @if($stores)
                                @foreach($stores as $s)
                                    <li><a id="{{$s['id']}}" class="favStore">{{$s['name']}}</a></li>
                                @endforeach
                            @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6  col-sms-6 current-alert">
                    <div class="sub-sets-header">
                        <strong>3</strong><span>Your Selected Stores</span>
                    </div>
                    <div class="sub-sets-current">
                        <ul class="list-selected-stores">
                        @if($alerts)
                            @foreach($alerts['storeIds'] as $s)
                            <li><span class="removeSelected">x</span><a id="{{$s['id']}}">{{$s['name']}}</a></li>
                            @endforeach
                        @endif
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts-footer')
    <script>
        var $formEmail = $('#change-email-form');
        var changeEmailValidator = $formEmail.validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    minlength: 5,
                    maxlength: 100
                },
                confirmEmail: {
                    required: true,
                    email: true,
                    minlength: 5,
                    maxlength: 100,
                    equalTo: "#inputEmail"
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
        $formEmail.on('submit', function (e) {
            e.preventDefault();
            if ($formEmail.valid()) {
                var that = $('#inputEmail');
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
                                $formEmail.find('button[type="submit"]').parent().find('span.alert').remove();
                                $formEmail.find('button[type="submit"]').empty().text('Saved');
                                $('.pro-pre-change-mailbox .pro-pre-desc span').text(that.val());
                            } else if (data.status == 'error') {
                                $formEmail.find('button[type="submit"]').parent().find('span.alert').addClass('alert-danger').text(data.msg);
                            }
                            setTimeout(function () {
                                $formEmail.find('button[type="submit"]').empty().text('Save changes').removeClass('disabled');
                            },2000);
                        });
                    } else if (data.status == 'Exists') {
                        that.parent().find('.check-email').remove();
                        that.closest('.form-group').removeClass('has-success').addClass('has-error');
                        that.parent().append("<span class='check-email help-block myErrorClass'>This email exists.Please enter a other email.</span>");
                    }
                });

            }
        });
        var $formPass = $('#change-password-form');
        var changePassValidator = $formPass.validate({
            rules: {
                passwordOld : {
                    required: true,
                    minlength: 6,
                    maxlength: 32
                },
                passwordNew : {
                    required: true,
                    minlength: 6,
                    maxlength: 32
                },
                passwordNewConfirm : {
                    required: true,
                    minlength: 6,
                    maxlength: 32,
                    equalTo: "#inputPassword2"
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
                    scrollTop: $formPass.offset().top - 100//$(validator.errorList[0].element).offset().top
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
        $formPass.on('submit', function (e) {
            e.preventDefault();
            if ($formPass.valid()) {
                $formPass.find('button[type="submit"]').empty().append("<i class='fa fa-spinner fa-pulse'></i> Saving").addClass('disabled');
                $.ajax({
                    type: 'post',
                    url: $formPass.attr('action'),
                    data: $formPass.serialize()
                }).done(function (data) {
                    if (data.status == 'success') {
                        $formPass.find('button[type="submit"]').parent().find('span.alert').remove();
                        $formPass.find('button[type="submit"]').empty().text('Saved');
                    } else if (data.status == 'error') {
                        $formPass.find('button[type="submit"]').parent().find('span.alert').addClass('alert-danger').text(data.msg);
                    }
                    setTimeout(function () {
                        $formPass.find('button[type="submit"]').empty().text('Save changes').removeClass('disabled');
                    },2000);
                });
            }
        });
        $(document).ready(function($){
            $('.listFav').on('click', '.favStore', function(e){
                var $this = $(this);
                var item = '<li><span class="removeSelected">x</span>'+'<a id="'+$this.attr('id')+'">'+$this.text()+'</a></li>';
                $('.list-selected-stores').append(item);
                $this.parent().remove();
            })

            $('.list-selected-stores').on('click', 'span', function(e){
                var item = '<li><a id="'+$(this).next().attr('id')+'" class="favStore">'+$(this).next().text()+'</a></li>';
                $('.listFav').append(item);
                $(this).parent().remove();
            })
            /*Save change alert*/
            $('#btnSaveAlert').click(function(){
                $(this).prop('disabled', true);
                var $m = $('#lblMessage');$m.hide();

                var $strSelectedStores = '';
                $('.list-selected-stores li a').each(function(index){
                    $strSelectedStores += $(this).attr('id') + ',';
                })
                $strSelectedStores = $strSelectedStores.substr(0, $strSelectedStores.length - 1);

                var $type = $('input[name="alerts"]:checked').val();
                var $system_alerts = $('#sysAlerts').is(':checked') ? 1:0;

                var $data = {
                    _token : '{{ csrf_token() }}',
                    userId : "{{$user['id']}}",
                    type : $type,
                    storeIds : $strSelectedStores,
                    systemAlerts : $system_alerts
                };

                jQuery.post("{{url('/preference/saveAlert')}}", $data, function(response){
                    if(response.code == 0){
                        $m.text(response.msg);
                    }else{
                        $m.text('Error! Empty data');
                    }
                    $m.fadeIn('slow');
                    $('#btnSaveAlert').prop('disabled', false);

                })
            })
        })
    </script>
@endsection