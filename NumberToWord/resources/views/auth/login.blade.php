{{-- */$noRobot = true;/* --}}
@extends('app')

@section('content')
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '{{ config("config.social.facebook.appId") }}',
                xfbml      : true,
                version    : '{{ config("config.social.facebook.version") }}'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
<div class="container">
	<div class="row">
		<div style="padding-top: 15px;">
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>
				<div class="panel-body">
                    <div class="col-sm-6">

					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
                    @elseif (Session::has('msg'))
                        <div class="alert alert-info">
                            <ul>
                                <li>{{ Session::get('msg') }}</li>
                            </ul>
                        </div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail</label>
							<div class="col-md-8">
								<!-- <input type="email" class="form-control" name="email"
								pattern="^[^+]+$" title="Character plus (+) not allowed" required> -->
								<input type="email" class="form-control" name="email" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-8">
								<input type="password" class="form-control" name="password" required pattern=".{6,32}" title="Password must be 6 to 32 characters">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Remember Me
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<button type="submit" class="btn btn-submit">Login</button>

								<a class="btn btn-link" href="{{ url('/user/forgot-password') }}">Forgot Password?</a>
							</div>
						</div>
					</form>
                    </div>
                    <div class="col-xs-12 col-sm-1">
                        <div class="horizontal-divider"></div>
                    </div>
                    <div id="login-fb-wrapper" class="col-sm-5">
                        {{--<h4>Social network</h4>--}}
                        <a href="{{url('/login/facebook')}}" class="btn btn-block btn-social btn-facebook">
                            <i class="fa fa-facebook"></i> Sign in with Facebook
                        </a>
                        <a href="{{url('/login/google')}}" class="btn btn-block btn-social btn-google-plus">
                            <i class="fa fa-google-plus"></i> Sign in with Google
                        </a>
                        <a href="{{url('/login/twitter')}}" class="btn btn-block btn-social btn-twitter">
                            <i class="fa fa-twitter"></i> Sign in with Twitter
                        </a>
                        {{--<a href="{{url('/login/github')}}" class="btn btn-block btn-social btn-github">--}}
                            {{--<i class="fa fa-github"></i> Sign in with GitHub--}}
                        {{--</a>--}}
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
