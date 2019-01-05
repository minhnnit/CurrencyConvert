{{-- */$seoConfig['title'] = 'Reset Password | ' . config('config.domain'); $noRobot = true;/* --}}
@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div style="padding-top: 15px;">
			<div class="panel panel-default">
				<div class="panel-heading">Reset Password</div>
				<div class="panel-body">
					@if (session('status'))
						<div class="alert alert-success">
							{{ session('status') }}
						</div>
					@endif

					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" id="forgot-pass-form" role="form" method="POST" action="{{ url('/user/forgot-password') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-submit">
									Send Password Reset Link
								</button>
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
        var $form = $('#forgot-pass-form');
        $form.on('submit', function (e) {
            e.preventDefault();
            if ($form.valid()) {
                $('#forgot-pass-form button').empty().append("<i class='fa fa-spinner fa-pulse'></i>").addClass('disabled');
                $.ajax({
                    type: 'post',
                    url: $form.attr('action'),
                    data: $form.serialize()
                }).done(function (data) {
                    if (data.status == 'success') {
                        $form.empty().text("Please check your email to reset password.");
                    } else if (data.status == 'error') {
                        $('#email').closest('.form-group').removeClass('has-success').addClass('has-error');
                        $('#email').parent().find('span.help-block').remove();
                        $('#email').parent().append("<span class='help-block myErrorClass'>" + data.msg + "</span>");
                        $('#forgot-pass-form button').empty().text('Send Password Reset Link').removeClass('disabled');
                    }
                });
            }
        });
    });
    </script>
@endsection
