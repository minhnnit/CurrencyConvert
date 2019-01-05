@extends('email-template.main-tmp')
@section('content')
    <table class="mail-body" cellpadding="0" cellspacing="0" border="0" width="600px" align="center">
        <tr class="header-ads">
            <td background="{{ asset('images/email-tmp/banner-600x700/welcome.jpg') }}" height="700px">
                <a href="{{url('/login')}}" class="get-btn">Log in</a>
                <a href="{{url('/register')}}" class="get-btn">SIGN UP</a>
            </td>
        </tr>
    </table>
@endsection