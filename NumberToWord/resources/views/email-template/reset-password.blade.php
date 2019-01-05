@extends('email-template.main-tmp')
@section('content')
    <table class="mail-body" cellpadding="0" cellspacing="0" border="0" width="600px" align="center" style="margin:10px auto; width:600px;">
        <tr class="mail-content">
            <td>
                <p style="padding:10px 0; color:#555;">Dear [[ fullname ]]!</p>
                <p style="padding:10px 0; color:#555;">We received a request to reset the password associated with this e-mail address. If you made this request, please
                    follow the instructions below.</p>
                <p style="padding:10px 0; color:#555;">Click the link below to reset your password using our secure server:</p>
                <p style="padding:10px 0; color:#555;"><a href="{{url('/user/reset-password/?token=')}}[[ token ]]" class="get-voucher" style="background-color:#a85dc2;
                border-radius:2px; padding:10px 50px; font-size:16px; font-weight:bold; color:#fff; display:inline-block; margin-bottom:40px; text-decoration:none;"> {{url
                ('/user/reset-password/?token=')}}[[ token ]]</a></p>
                <p style="padding:10px 0; color:#555;">If clicking the link doesn't seem to work, you can copy and paste the link into your browser's address window, or
                    retype it there. Once you have returned to MostCoupon.com, we will give instructions for resetting your password.</p>
                <p style="padding:10px 0; color:#555;">MostCoupon.com will never e-mail you and ask you to disclose or verify your MostCoupon.com password, credit card, or banking account number. If you
                    receive a suspicious e-mail with a link to update your account information, do not click on the link--instead, report the e-mail to MostCoupon.com for
                    investigation. Thanks for visiting MostCoupon.com!</p>
            </td>
        </tr>
    </table>
@endsection