@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Info</div>
                    <div class="panel-body">
                        <div class="alert-danger"></div>

                        <form id="confirm-twitter-email-form" class="form-horizontal" role="form" method="POST" action="{{ url('/login/twitter-confirm') }}">
                            <p>Thank you for register with account twitter. Please confirm your email and enjoy.</p>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token">
                            <input type="hidden" name="username" value="{{ $user['username'] }}">
                            <input type="hidden" name="name" value="{{ $user['name'] }}">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Email</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" id="email">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-submit">
                                        Confirm
                                    </button>
                                    <a href="{{url('/')}}" class="btn btn-default">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var $form = $('#confirm-twitter-email-form');
            var addRegisterValidator = $form.validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        minlength: 5,
                        maxlength: 100
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
            $form.on('submit', function (e) {
                e.preventDefault();
                if ($form.valid()) {
                    $form.find("button[type='submit']").addClass('disabled');
                    $.ajax({
                        type: 'get',
                        url: '{{url('/user/emailExists')}}',
                        data: $form.serialize()
                    }).done(function (data) {
                        if (data.status == 'Not Exists') {
                            $.ajax({
                                type: 'post',
                                url: $form.attr('action'),
                                data: $form.serialize()
                            }).done(function (data) {
                                if (data.status == 'success') {
                                    if (localStorage) {
                                        var localUserData = {
                                            email : $('#email').val(),
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
                                    }
                                    /*End*/
                                    window.open(data.redirectUrl);
                                } else if (data.status == 'error') {
                                }
                            });
                        } else if (data.status == 'Exists') {
                            $form.find("button[type='submit']").removeClass('disabled');
                            $('.alert-danger').addClass('alert').append('<strong>Whoops!</strong> This email exists. Please enter a other email!<br><br>');
                        }
                    });

                }
            });
        });
    </script>
@endsection
