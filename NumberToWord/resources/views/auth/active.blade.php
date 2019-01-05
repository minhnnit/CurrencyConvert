{{-- */$seoConfig['title'] = 'Your Account - ' . config('config.domain');/* --}}
@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Active Account</div>
                    <div class="panel-body">
                        {{$msg}}
                        @if(!empty($token))
                            <br>
                        {{--<form class="form-horizontal" role="form" method="POST" action="{{ url('/user/reset-password/') }}">--}}
                            {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                            {{--<input type="hidden" name="token" value="{{ $token }}">--}}

                            {{--<div class="form-group">--}}
                                {{--<label class="col-md-4 control-label">Password</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<input type="password" class="form-control" name="password" required pattern=".{6,32}" title="Password must be 6 to 32 characters">--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group">--}}
                                {{--<label class="col-md-4 control-label">Confirm Password</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<input type="password" class="form-control" name="password_confirmation" required pattern=".{6,32}" title="Password must be 6 to 32 characters">--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group">--}}
                                {{--<div class="col-md-6 col-md-offset-4">--}}
                                    {{--<button type="submit" class="btn btn-submit">--}}
                                        {{--Reset Password--}}
                                    {{--</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
