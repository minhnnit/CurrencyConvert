<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- If you delete this meta tag, Half Life 3 will never be released. -->
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Daily Hot {{config('config.Project_Name')}}</title>
    <style type="text/css">
        *{margin:0;padding:0}
        *{font-family:"Helvetica Neue","Helvetica",verdana,Helvetica,Arial,sans-serif;}
        body{-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100% !important;height:100%;}
        .mail-header{margin:20px auto; border:0;width:600px;}
        .mail-header tr td{height:60px; vertical-align:middle; border-bottom:1px solid #dfdfdf;}
        .mail-header tr td:first-child{text-align:left;}
        .mail-header tr td:last-child{text-align:right;}
        .mail-header tr td a{text-decoration:none;}
        .mail-footer{margin:20px auto;}
        .mail-footer p{font-size:14px; color:#999; padding:3px 0;}
        .mail-footer a{color:#a3d3a5; text-decoration:none;}
        .mail-footer h4{ padding:25px 0 5px; color:#999;}
        .footer-line{border:0; border-bottom:3px solid #0cb71b; margin-bottom:15px;}
        .mail-body{margin:10px auto; width:600px;}
        .get-btn{display:inline-block;text-align:center; width:180px; border:1px solid #fff; text-decoration:none; color:#fff; margin:auto 5px 180px; padding:10px 0; font-weight:bold; text-transform:uppercase;}
        .header-ads{text-align:center; vertical-align:bottom;}
        .get-voucher{background-color:#0cb71b; border-radius:2px; padding:10px 50px; font-size:16px; font-weight:bold; color:#fff; display:inline-block; margin-bottom:60px; text-decoration:none;}
        .mail-content p{padding:10px 0; color:#555;}
    </style>
</head>
<body bgcolor="#fff" style='font-family:"Helvetica Neue","Helvetica",verdana,Helvetica,Arial,sans-serif;-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100% !important;height:100%;'>
@include('email-template.mail-header')
@yield('content')
@include('email-template.mail-footer')
</body>
</html>