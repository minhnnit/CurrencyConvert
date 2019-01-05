<table class="mail-footer" style="margin:20px auto;" cellpadding="0" cellspacing="0" border="0" width="600px" align="center">
    <tr>
        <td colspan="2"><hr class="footer-line" style="border:0; border-bottom:3px solid #a85dc2; margin-bottom:15px;" /></td>
    </tr>
    <tr>
        <td>
            <p style="font-size:14px; color:#999; padding:3px 0;">{{config('config.ProjectName')}}® is a registered trademark of BOGO CO., LTD.</p>
            <p style="font-size:14px; color:#999; padding:3px 0;">Contact number: +84 (4) 322 008 869</p>
            <p style="font-size:14px; color:#999; padding:3px 0;">© 2012 - {{date("Y",time())}}. All rights reserved.</p>
            <p style="font-size:14px; color:#999; padding:3px 0;">Visit us at <a href="http://www.{{config('config.domain')}}" target="_blank">{{config('config.domain')}}</a> | Meet our team at <a href="http://www.{{config('config.domain')}}" target="_blank">{{config('config.domain')}}</a></p>
        </td>
        <td><img src="{{ asset('images/email-tmp/logo-small.png') }}" width="50" height="50"  alt=""/></td>
    </tr>
</table>