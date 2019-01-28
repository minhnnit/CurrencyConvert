<!doctype html>
<html ⚡>
<head>
    <meta charset="UTF-8">
    <title>Currency Conversion</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <link rel="canonical" href="https://uncompiled.github.io/amp-bootstrap/" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="description" content="Sample Bootstrap Site">
    <meta name="author" content="Web Developer">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <!-- AMP boilerplate -->
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://code.responsivevoice.org/responsivevoice.js"></script>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <script async custom-element="amp-audio" src="https://cdn.ampproject.org/v0/amp-audio-0.1.js"></script>


    <!-- Bootstrap core CSS is replaced with amp-custom style tag -->
    <style amp-custom>/*!
 /*!
 * Bootstrap v3.3.7 (http://getbootstrap.com)
 * Copyright 2011-2016 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 *//*! normalize.css v3.0.3 | MIT License | github.com/necolas/normalize.css */
        html{font-family:sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}body{margin:0}footer,header,main,section{display:block}audio{display:inline-block;vertical-align:baseline}audio:not([controls]){display:none;height:0}[hidden]{display:none}a{background-color:transparent}a:active,a:hover{outline:0}b{font-weight:700}h1{margin:.67em 0;font-size:2em}img{border:0}button,input,optgroup,select{margin:0;font:inherit;color:inherit}button{overflow:visible}button,select{text-transform:none}button,html input[type=button],input[type=reset],input[type=submit]{-webkit-appearance:button;cursor:pointer}button[disabled],html input[disabled]{cursor:default}button::-moz-focus-inner,input::-moz-focus-inner{padding:0;border:0}input{line-height:normal}input[type=checkbox],input[type=radio]{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding:0}input[type=number]::-webkit-inner-spin-button,input[type=number]::-webkit-outer-spin-button{height:auto}input[type=search]{-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;-webkit-appearance:textfield}input[type=search]::-webkit-search-cancel-button,input[type=search]::-webkit-search-decoration{-webkit-appearance:none}optgroup{font-weight:700}table{border-spacing:0;border-collapse:collapse}td,th{padding:0}/*! Source: https://github.com/h5bp/html5-boilerplate/blob/master/src/css/main.css */@media print{*,:after,:before{color:#000!important;text-shadow:none!important;background:0 0!important;-webkit-box-shadow:none!important;box-shadow:none!important}a,a:visited{text-decoration:underline}a[href]:after{content:" (" attr(href) ")"}a[href^="#"]:after,a[href^="javascript:"]:after{content:""}thead{display:table-header-group}img,tr{page-break-inside:avoid}img{max-width:100%!important}h2,h3,p{orphans:3;widows:3}h2,h3{page-break-after:avoid}.label{border:1px solid #000}.table{border-collapse:collapse!important}.table td,.table th{background-color:#fff!important}}@font-face{font-family:'Glyphicons Halflings';src:url(../fonts/glyphicons-halflings-regular.eot);src:url(../fonts/glyphicons-halflings-regular.eot?#iefix) format('embedded-opentype'),url(../fonts/glyphicons-halflings-regular.woff2) format('woff2'),url(../fonts/glyphicons-halflings-regular.woff) format('woff'),url(../fonts/glyphicons-halflings-regular.ttf) format('truetype'),url(../fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular) format('svg')}*{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}:after,:before{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}html{font-size:10px;-webkit-tap-highlight-color:transparent}body{font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.42857143;color:#333;background-color:#fff}button,input,select{font-family:inherit;font-size:inherit;line-height:inherit}a{color:#337ab7;text-decoration:none}a:focus,a:hover{color:#23527c;text-decoration:underline}a:focus{outline:5px auto -webkit-focus-ring-color;outline-offset:-2px}img{vertical-align:middle}[role=button]{cursor:pointer}.h1,.h2,.h3,.h4,.h5,.h6,h1,h2,h3,h4,h5,h6{font-family:inherit;font-weight:500;line-height:1.1;color:inherit}.h1,.h2,.h3,h1,h2,h3{margin-top:20px;margin-bottom:10px}.h4,.h5,.h6,h4,h5,h6{margin-top:10px;margin-bottom:10px}.h1,h1{font-size:36px}.h2,h2{font-size:30px}.h3,h3{font-size:24px}.h4,h4{font-size:18px}.h5,h5{font-size:14px}.h6,h6{font-size:12px}p{margin:0 0 10px}.lead{margin-bottom:20px;font-size:16px;font-weight:300;line-height:1.4}@media (min-width:768px){.lead{font-size:21px}}.text-left{text-align:left}.text-right{text-align:right}.text-center{text-align:center}ul{margin-top:0;margin-bottom:10px}ul ul{margin-bottom:0}.list-unstyled{padding-left:0;list-style:none}.container{padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:768px){.container{width:750px}}@media (min-width:992px){.container{width:970px}}@media (min-width:1200px){.container{width:1170px}}.container-fluid{padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.row{margin-right:-15px;margin-left:-15px}.col-lg-1,.col-lg-10,.col-lg-11,.col-lg-12,.col-lg-2,.col-lg-3,.col-lg-4,.col-lg-5,.col-lg-6,.col-lg-7,.col-lg-8,.col-lg-9,.col-sm-1,.col-sm-10,.col-sm-11,.col-sm-12,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-xs-1,.col-xs-10,.col-xs-11,.col-xs-12,.col-xs-2,.col-xs-3,.col-xs-4,.col-xs-5,.col-xs-6,.col-xs-7,.col-xs-8,.col-xs-9{position:relative;min-height:1px;padding-right:15px;padding-left:15px}.col-xs-1,.col-xs-10,.col-xs-11,.col-xs-12,.col-xs-2,.col-xs-3,.col-xs-4,.col-xs-5,.col-xs-6,.col-xs-7,.col-xs-8,.col-xs-9{float:left}.col-xs-12{width:100%}.col-xs-11{width:91.66666667%}.col-xs-10{width:83.33333333%}.col-xs-9{width:75%}.col-xs-8{width:66.66666667%}.col-xs-7{width:58.33333333%}.col-xs-6{width:50%}.col-xs-5{width:41.66666667%}.col-xs-4{width:33.33333333%}.col-xs-3{width:25%}.col-xs-2{width:16.66666667%}.col-xs-1{width:8.33333333%}.col-xs-pull-12{right:100%}.col-xs-pull-11{right:91.66666667%}.col-xs-pull-10{right:83.33333333%}.col-xs-pull-9{right:75%}.col-xs-pull-8{right:66.66666667%}.col-xs-pull-7{right:58.33333333%}.col-xs-pull-6{right:50%}.col-xs-pull-5{right:41.66666667%}.col-xs-pull-4{right:33.33333333%}.col-xs-pull-3{right:25%}.col-xs-pull-2{right:16.66666667%}.col-xs-pull-1{right:8.33333333%}.col-xs-pull-0{right:auto}.col-xs-offset-12{margin-left:100%}.col-xs-offset-11{margin-left:91.66666667%}.col-xs-offset-10{margin-left:83.33333333%}.col-xs-offset-9{margin-left:75%}.col-xs-offset-8{margin-left:66.66666667%}.col-xs-offset-7{margin-left:58.33333333%}.col-xs-offset-6{margin-left:50%}.col-xs-offset-5{margin-left:41.66666667%}.col-xs-offset-4{margin-left:33.33333333%}.col-xs-offset-3{margin-left:25%}.col-xs-offset-2{margin-left:16.66666667%}.col-xs-offset-1{margin-left:8.33333333%}.col-xs-offset-0{margin-left:0}@media (min-width:768px){.col-sm-1,.col-sm-10,.col-sm-11,.col-sm-12,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9{float:left}.col-sm-12{width:100%}.col-sm-11{width:91.66666667%}.col-sm-10{width:83.33333333%}.col-sm-9{width:75%}.col-sm-8{width:66.66666667%}.col-sm-7{width:58.33333333%}.col-sm-6{width:50%}.col-sm-5{width:41.66666667%}.col-sm-4{width:33.33333333%}.col-sm-3{width:25%}.col-sm-2{width:16.66666667%}.col-sm-1{width:8.33333333%}.col-sm-pull-12{right:100%}.col-sm-pull-11{right:91.66666667%}.col-sm-pull-10{right:83.33333333%}.col-sm-pull-9{right:75%}.col-sm-pull-8{right:66.66666667%}.col-sm-pull-7{right:58.33333333%}.col-sm-pull-6{right:50%}.col-sm-pull-5{right:41.66666667%}.col-sm-pull-4{right:33.33333333%}.col-sm-pull-3{right:25%}.col-sm-pull-2{right:16.66666667%}.col-sm-pull-1{right:8.33333333%}.col-sm-pull-0{right:auto}.col-sm-offset-12{margin-left:100%}.col-sm-offset-11{margin-left:91.66666667%}.col-sm-offset-10{margin-left:83.33333333%}.col-sm-offset-9{margin-left:75%}.col-sm-offset-8{margin-left:66.66666667%}.col-sm-offset-7{margin-left:58.33333333%}.col-sm-offset-6{margin-left:50%}.col-sm-offset-5{margin-left:41.66666667%}.col-sm-offset-4{margin-left:33.33333333%}.col-sm-offset-3{margin-left:25%}.col-sm-offset-2{margin-left:16.66666667%}.col-sm-offset-1{margin-left:8.33333333%}.col-sm-offset-0{margin-left:0}}@media (min-width:1200px){.col-lg-1,.col-lg-10,.col-lg-11,.col-lg-12,.col-lg-2,.col-lg-3,.col-lg-4,.col-lg-5,.col-lg-6,.col-lg-7,.col-lg-8,.col-lg-9{float:left}.col-lg-12{width:100%}.col-lg-11{width:91.66666667%}.col-lg-10{width:83.33333333%}.col-lg-9{width:75%}.col-lg-8{width:66.66666667%}.col-lg-7{width:58.33333333%}.col-lg-6{width:50%}.col-lg-5{width:41.66666667%}.col-lg-4{width:33.33333333%}.col-lg-3{width:25%}.col-lg-2{width:16.66666667%}.col-lg-1{width:8.33333333%}.col-lg-pull-12{right:100%}.col-lg-pull-11{right:91.66666667%}.col-lg-pull-10{right:83.33333333%}.col-lg-pull-9{right:75%}.col-lg-pull-8{right:66.66666667%}.col-lg-pull-7{right:58.33333333%}.col-lg-pull-6{right:50%}.col-lg-pull-5{right:41.66666667%}.col-lg-pull-4{right:33.33333333%}.col-lg-pull-3{right:25%}.col-lg-pull-2{right:16.66666667%}.col-lg-pull-1{right:8.33333333%}.col-lg-pull-0{right:auto}.col-lg-offset-12{margin-left:100%}.col-lg-offset-11{margin-left:91.66666667%}.col-lg-offset-10{margin-left:83.33333333%}.col-lg-offset-9{margin-left:75%}.col-lg-offset-8{margin-left:66.66666667%}.col-lg-offset-7{margin-left:58.33333333%}.col-lg-offset-6{margin-left:50%}.col-lg-offset-5{margin-left:41.66666667%}.col-lg-offset-4{margin-left:33.33333333%}.col-lg-offset-3{margin-left:25%}.col-lg-offset-2{margin-left:16.66666667%}.col-lg-offset-1{margin-left:8.33333333%}.col-lg-offset-0{margin-left:0}}table{background-color:transparent}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}table col[class*=col-]{position:static;display:table-column;float:none}table td[class*=col-],table th[class*=col-]{position:static;display:table-cell;float:none}label{display:inline-block;max-width:100%;margin-bottom:5px;font-weight:700}input[type=search]{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}input[type=checkbox],input[type=radio]{margin:4px 0 0;line-height:normal}input[type=file]{display:block}input[type=range]{display:block;width:100%}select[multiple],select[size]{height:auto}input[type=checkbox]:focus,input[type=file]:focus,input[type=radio]:focus{outline:5px auto -webkit-focus-ring-color;outline-offset:-2px}.form-control{display:block;width:100%;height:34px;padding:6px 12px;font-size:14px;line-height:1.42857143;color:#555;background-color:#fff;background-image:none;border:1px solid #ccc;border-radius:4px;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s}.form-control:focus{border-color:#66afe9;outline:0;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6)}.form-control::-moz-placeholder{color:#999;opacity:1}.form-control:-ms-input-placeholder{color:#999}.form-control::-webkit-input-placeholder{color:#999}.form-control::-ms-expand{background-color:transparent;border:0}.form-control[disabled],.form-control[readonly]{background-color:#eee;opacity:1}.form-control[disabled]{cursor:not-allowed}input[type=search]{-webkit-appearance:none}@media screen and (-webkit-min-device-pixel-ratio:0){input[type=date].form-control,input[type=datetime-local].form-control,input[type=month].form-control,input[type=time].form-control{line-height:34px}.input-group-sm input[type=date],.input-group-sm input[type=datetime-local],.input-group-sm input[type=month],.input-group-sm input[type=time],input[type=date].input-sm,input[type=datetime-local].input-sm,input[type=month].input-sm,input[type=time].input-sm{line-height:30px}.input-group-lg input[type=date],.input-group-lg input[type=datetime-local],.input-group-lg input[type=month],.input-group-lg input[type=time],input[type=date].input-lg,input[type=datetime-local].input-lg,input[type=month].input-lg,input[type=time].input-lg{line-height:46px}}.form-group{margin-bottom:15px}input[type=checkbox][disabled],input[type=radio][disabled]{cursor:not-allowed}.input-sm{height:30px;padding:5px 10px;font-size:12px;line-height:1.5;border-radius:3px}select.input-sm{height:30px;line-height:30px}select[multiple].input-sm{height:auto}.form-group-sm .form-control{height:30px;padding:5px 10px;font-size:12px;line-height:1.5;border-radius:3px}.form-group-sm select.form-control{height:30px;line-height:30px}.form-group-sm select[multiple].form-control{height:auto}.input-lg{height:46px;padding:10px 16px;font-size:18px;line-height:1.3333333;border-radius:6px}select.input-lg{height:46px;line-height:46px}select[multiple].input-lg{height:auto}.form-group-lg .form-control{height:46px;padding:10px 16px;font-size:18px;line-height:1.3333333;border-radius:6px}.form-group-lg select.form-control{height:46px;line-height:46px}.form-group-lg select[multiple].form-control{height:auto}.form-horizontal .form-group{margin-right:-15px;margin-left:-15px}@media (min-width:768px){.form-horizontal .control-label{padding-top:7px;margin-bottom:0;text-align:right}}@media (min-width:768px){.form-horizontal .form-group-lg .control-label{padding-top:11px;font-size:18px}}@media (min-width:768px){.form-horizontal .form-group-sm .control-label{padding-top:6px;font-size:12px}}.btn{display:inline-block;padding:6px 12px;margin-bottom:0;font-size:14px;font-weight:400;line-height:1.42857143;text-align:center;white-space:nowrap;vertical-align:middle;-ms-touch-action:manipulation;touch-action:manipulation;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;background-image:none;border:1px solid transparent;border-radius:4px}.btn:active:focus,.btn:focus{outline:5px auto -webkit-focus-ring-color;outline-offset:-2px}.btn:focus,.btn:hover{color:#333;text-decoration:none}.btn:active{background-image:none;outline:0;-webkit-box-shadow:inset 0 3px 5px rgba(0,0,0,.125);box-shadow:inset 0 3px 5px rgba(0,0,0,.125)}.btn[disabled]{cursor:not-allowed;-webkit-box-shadow:none;box-shadow:none;opacity:.65}.btn-default{color:#333;background-color:#fff;border-color:#ccc}.btn-default:focus{color:#333;background-color:#e6e6e6;border-color:#8c8c8c}.btn-default:hover{color:#333;background-color:#e6e6e6;border-color:#adadad}.btn-default:active{color:#333;background-color:#e6e6e6;border-color:#adadad}.btn-default:active:focus,.btn-default:active:hover{color:#333;background-color:#d4d4d4;border-color:#8c8c8c}.btn-default:active{background-image:none}.btn-default[disabled]:focus,.btn-default[disabled]:hover{background-color:#fff;border-color:#ccc}.btn-group-lg>.btn,.btn-lg{padding:10px 16px;font-size:18px;line-height:1.3333333;border-radius:6px}.btn-group-sm>.btn,.btn-sm{padding:5px 10px;font-size:12px;line-height:1.5;border-radius:3px}.btn-group-xs>.btn,.btn-xs{padding:1px 5px;font-size:12px;line-height:1.5;border-radius:3px}.btn-group{position:relative;display:inline-block;vertical-align:middle}.btn-group>.btn{position:relative;float:left}.btn-group>.btn:active,.btn-group>.btn:focus,.btn-group>.btn:hover{z-index:2}.btn-group .btn+.btn,.btn-group .btn+.btn-group,.btn-group .btn-group+.btn,.btn-group .btn-group+.btn-group{margin-left:-1px}.btn-group>.btn:first-child{margin-left:0}.btn-group>.btn:last-child:not(:first-child){border-top-left-radius:0;border-bottom-left-radius:0}.btn-group>.btn-group{float:left}.btn-group>.btn-group:not(:first-child):not(:last-child)>.btn{border-radius:0}.btn-group>.btn-group:first-child:not(:last-child)>.btn:last-child{border-top-right-radius:0;border-bottom-right-radius:0}.btn-group>.btn-group:last-child:not(:first-child)>.btn:first-child{border-top-left-radius:0;border-bottom-left-radius:0}[data-toggle=buttons]>.btn input[type=checkbox],[data-toggle=buttons]>.btn input[type=radio],[data-toggle=buttons]>.btn-group>.btn input[type=checkbox],[data-toggle=buttons]>.btn-group>.btn input[type=radio]{position:absolute;clip:rect(0,0,0,0);pointer-events:none}.input-group{position:relative;display:table;border-collapse:separate}.input-group[class*=col-]{float:none;padding-right:0;padding-left:0}.input-group .form-control{position:relative;z-index:2;float:left;width:100%;margin-bottom:0}.input-group .form-control:focus{z-index:3}.input-group-lg>.form-control,.input-group-lg>.input-group-addon,.input-group-lg>.input-group-btn>.btn{height:46px;padding:10px 16px;font-size:18px;line-height:1.3333333;border-radius:6px}select.input-group-lg>.form-control,select.input-group-lg>.input-group-addon,select.input-group-lg>.input-group-btn>.btn{height:46px;line-height:46px}select[multiple].input-group-lg>.form-control,select[multiple].input-group-lg>.input-group-addon,select[multiple].input-group-lg>.input-group-btn>.btn{height:auto}.input-group-sm>.form-control,.input-group-sm>.input-group-addon,.input-group-sm>.input-group-btn>.btn{height:30px;padding:5px 10px;font-size:12px;line-height:1.5;border-radius:3px}select.input-group-sm>.form-control,select.input-group-sm>.input-group-addon,select.input-group-sm>.input-group-btn>.btn{height:30px;line-height:30px}select[multiple].input-group-sm>.form-control,select[multiple].input-group-sm>.input-group-addon,select[multiple].input-group-sm>.input-group-btn>.btn{height:auto}.input-group .form-control,.input-group-addon,.input-group-btn{display:table-cell}.input-group .form-control:not(:first-child):not(:last-child),.input-group-addon:not(:first-child):not(:last-child),.input-group-btn:not(:first-child):not(:last-child){border-radius:0}.input-group-addon,.input-group-btn{width:1%;white-space:nowrap;vertical-align:middle}.input-group-addon{padding:6px 12px;font-size:14px;font-weight:400;line-height:1;color:#555;text-align:center;background-color:#eee;border:1px solid #ccc;border-radius:4px}.input-group-addon.input-sm{padding:5px 10px;font-size:12px;border-radius:3px}.input-group-addon.input-lg{padding:10px 16px;font-size:18px;border-radius:6px}.input-group-addon input[type=checkbox],.input-group-addon input[type=radio]{margin-top:0}.input-group .form-control:first-child,.input-group-addon:first-child,.input-group-btn:first-child>.btn,.input-group-btn:first-child>.btn-group>.btn,.input-group-btn:last-child>.btn-group:not(:last-child)>.btn{border-top-right-radius:0;border-bottom-right-radius:0}.input-group-addon:first-child{border-right:0}.input-group .form-control:last-child,.input-group-addon:last-child,.input-group-btn:first-child>.btn-group:not(:first-child)>.btn,.input-group-btn:first-child>.btn:not(:first-child),.input-group-btn:last-child>.btn,.input-group-btn:last-child>.btn-group>.btn{border-top-left-radius:0;border-bottom-left-radius:0}.input-group-addon:last-child{border-left:0}.input-group-btn{position:relative;font-size:0;white-space:nowrap}.input-group-btn>.btn{position:relative}.input-group-btn>.btn+.btn{margin-left:-1px}.input-group-btn>.btn:active,.input-group-btn>.btn:focus,.input-group-btn>.btn:hover{z-index:2}.input-group-btn:first-child>.btn,.input-group-btn:first-child>.btn-group{margin-right:-1px}.input-group-btn:last-child>.btn,.input-group-btn:last-child>.btn-group{z-index:2;margin-left:-1px}.label{display:inline;padding:.2em .6em .3em;font-size:75%;font-weight:700;line-height:1;color:#fff;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25em}a.label:focus,a.label:hover{color:#fff;text-decoration:none;cursor:pointer}.label:empty{display:none}.btn .label{position:relative;top:-1px}.label-default{background-color:#777}.label-default[href]:focus,.label-default[href]:hover{background-color:#5e5e5e}@-webkit-keyframes progress-bar-stripes{from{background-position:40px 0}to{background-position:0 0}}@-o-keyframes progress-bar-stripes{from{background-position:40px 0}to{background-position:0 0}}@keyframes progress-bar-stripes{from{background-position:40px 0}to{background-position:0 0}}.list-group{padding-left:0;margin-bottom:20px}.clearfix:after,.clearfix:before,.container-fluid:after,.container-fluid:before,.container:after,.container:before,.form-horizontal .form-group:after,.form-horizontal .form-group:before,.row:after,.row:before{display:table;content:" "}.clearfix:after,.container-fluid:after,.container:after,.form-horizontal .form-group:after,.row:after{clear:both}.pull-right{float:right!important}.pull-left{float:left!important}.hidden{display:none!important}@media (max-width:767px){.hidden-xs{display:none!important}}@media (min-width:768px) and (max-width:991px){.hidden-sm{display:none!important}}@media (min-width:1200px){.hidden-lg{display:none!important}}
        /*# sourceMappingURL=bootstrap.min.css.map */
        /* Custom CSS */
        body {
            font-family: Lato;
        }

        .header-content {
            text-align: center;
        }

        .header-content {
            background: #fff;
            height: 60px;
            padding: 0 15px;
            border-bottom: 1px solid #ccc;
        }

        .header-content img {
            height: 37px;
        }

        .logo-header {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 13px 0;
        }

        .convert-number-left h3 {
            text-align: center;
        }

        .inputCurrency {
            height: 42px;
            width: auto;
            display: unset;
        }

        .inputCurrency-nb {
            height: 42px;
            font-weight: 700;
        }

        .btn-padding {
            padding: 10px 5px 10px 5px;
            margin-bottom: 3px;
        }

        .display-text-audio {
            margin: 10px 0 10px 0;
        }

        .speakout-digit {
            margin-bottom: 10px;
        }

        #convert {
            color: #FFFFFF;
        }

        .fa-arrow-right {
            margin-left: 3px;
        }

        .mg-bottom-5 {
            margin-bottom: 5px;
        }

        .lead {
            float: left;
            overflow: hidden;
            font-size: 16px;
            height: 231px;
            width: 100%;
        }

        .more {
            cursor: pointer;
            color: #38c5cb;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .color-blue {
            color: #55552b;
        }

        #footer {
            padding-top: 0;
            background: #f2f2f2;
            padding-bottom: 5px;
        }

        #footer .footer-left {
            text-align: center;
            color: #555;
            padding-top: 35px;
        }

        #footer .footer-left ul {
            margin-bottom: 0;
            float: none;
            display: inline-block;
        }

        #footer .footer-right {
            margin-top: 15px;
            text-align: center;
            color: #555;
        }

        #footer .footer-left a {
            display: inline-block;
            font-size: 14px;
            padding: 0 8px;
            border-right: 1px solid #ccc;
            color: #555;
            text-decoration: none;
        }

        .convert-button {
            text-align: center;
            margin-top: 10px;
        }

        .button-convert-first {
            text-align: center;
            margin-top: 5px;
        }

        .relate-number {
            font-size: 16px;
        }

        .random-number {
            margin-top: 10px;
        }

        .darkgrey {
            color: #202221;
        }

        .bg-convert {
            background-color: skyblue;
        }

        .row.default:last-child {
            padding-bottom: 30px;
        }

        .row.default:first-child {
            padding-top: 75px;
        }

        .row.default {
            padding: 10px 0;
        }

        .row h1:first-child {
            margin-top: 0;
        }

        h1 {
            margin: 30px 0;
        }

        .fs-16px {
            font-size: 16px;
        }

        #currency-converter {
            padding-top: 10px;
            padding-bottom: 0;
        }

        .converter-box {
            border-radius: 3px;
            box-shadow: 0 0 10px 0 rgba(50, 50, 50, .5);
        }

        .bg-lightgrey {
            background-color: #f4f7f9;
        }

        /*neu xoa thi bat dau tu dong nay tro xuong*/
        .converter-box #calculator {
            padding-top: 15px !important;
        }

        .converter-box #calculator {
            margin: 0;
            padding: 0 15px;
            -webkit-border-bottom-right-radius: 3px;
            -moz-border-radius-bottomright: 3px;
            border-bottom-right-radius: 3px;
            -webkit-border-bottom-left-radius: 3px;
            -moz-border-radius-bottomleft: 3px;
            border-bottom-left-radius: 3px;
        }

        #currency-converter form#currency-form select {
            height: 100%;
            background-color: #fff;
            padding: 11px 12px;
            font-weight: 700;
        }

        #currency-converter .form-control {
            width: 100%;
        }

        #currency-form #convert {
            width: 100%;
        }

        .btn-wf-blue {
            color: #202221;
            border-color: #00e6d4;
            background-color: #00e6d4;
        }

        .currency-res {
            padding: 0 0 40px 0;
            margin: 30px 0;
        }

        .thead-color {
            background-color: #004fa3;
            color: #FFFFFF;
        }

        tr {
            cursor: pointer;
        }

        table {
            border-left: solid 1px #e7e7e7;
            border-right: solid 1px #e7e7e7;
        }

        .speak-audio {
            background-color: aliceblue;
            border: 0;
            padding: 5px 10px;
        }

        .table > tbody > tr > td {
            border-bottom: solid 1px #e7e7e7;
        }
        .table
        {
            font-size: 15px;
        }

        header {
            position: fixed;
            width: 100%;
            z-index: 111;
        }

        .image {
            background-image: url("../public/img/1.jpg");
            background-repeat: no-repeat;
            min-height: 220px !important;
            background-size: cover;
            background-position: center top;
            top: 0;
            left: 0;
            width: 100%;
        }

        .sidebar-bg {
            background-image: url("../public/img/currency-wallpaper-hd-49531-51206-hd-wallpapers.jpg");
            background-repeat: no-repeat;
            min-height: 457px !important;
            background-size: cover;
            background-position: center top;
            top: 0;
            left: 0;
            width: 100%;
            color: #333;
        }

        .sidebar-bg a {
            color: #FFFFFF;
            font-weight: 700;
        }

        .spellout-number {
            padding: 21px;
            color: #FFFFFF;
        }

        .text-white {
            font-size: 16px;
            border: none;
            color: greenyellow;
        }

        .relate-number {
            font-size: 16px;
            color: #fff;
            background-color: #45c5cb;
            line-height: 54px;
            font-weight: 700;
        }

        .h3-title {
            color: #fff;
            background-color: #45c5cb;
            line-height: 54px;
            font-weight: 700;
        }

        .sidebar-fs {
            font-size: 23px;
            color: #FFFFFF;
        }
        * {box-sizing: border-box;}

        .panel-wrapper {
            position: relative;
        }

        .btn-more {
            color: #fff;
            background: #000;
            border-radius: 1.5em;
            left: 30%;
            padding: 1em;
            text-decoration: none;
            width: 40%;
        }
        .show, .hide {
            position: absolute;
            bottom: -1em;
            z-index: 100;
            text-align: center;
        }

        .hide {display: none;}
        .show:target {display: none;}
        .show:target ~ .hide {display: block;}
        .show:target ~ .panel {
            max-height: 4000px;
        }
        .show:target ~ .fade {
            margin-top: 0;
        }

        .panel {
            position: relative;
            max-height: 255px;
            overflow: hidden;
            transition: max-height .5s ease;
            margin-bottom: 70px;
        }
        .fade {
            background: linear-gradient(to bottom, rgba($bg-color,0) 0%,rgba($bg-color,1) 75%);
            height: 100px;
            margin-top: -100px;
            position: relative;
        }

        #hide
        {
            bottom: 83px;
        }

        .randomNumber
        {
            padding-left: 5px;
        }

    </style>
</head>
<body>
<header>
    <div class="header-content">
        <div class="logo-header">
            <a href="{{ url('/') }}">
                <amp-img src="../public/img/Back-To-Homepage-button.png" alt="" width="88.8" height="37"></amp-img>
            </a>
        </div>
    </div>
</header>
<div class="container-fluid bg-convert text-left darkgrey">
    <div class="row default">
        <div class="col-sm-5 col-sm-offset-1">
            <h1>Currency Converter</h1>
            <p class="fs-16px">Fill in the currency to convert</p>
        </div>
        <div class="col-sm-4 col-sm-offset-1">
            <p>Select the currency and enter the amount you have. Then select the currency you would like and click
                'Convert'. You'll see how much the recipient account would get based on <b>Currency Converter Api.</b>
            </p>
            <div class="converter-container">
                <div class="converter-box bg-lightgrey" id="currency-converter">
                    <h3 class="text-center">Currency Converter</h3>
                    <div id="calculator" class="row">
                        <form id="currency-form" class="form-horizontal" action="{{ url('/convertCurrency') }}"
                        >
                            <div class=" form-group ">
                                <div class="col-xs-12">
                                    <select name="from_currency"
                                            class="form-control col-lg-3" required="">
                                        <optgroup id="sell_currency-optgroup-Common currencies"
                                                  label="Common currencies">
                                            <option value="AUD">AUD Australian Dollar</option>
                                            <option value="CAD">CAD Canadian Dollar</option>
                                            <option value="EUR">EUR Euro</option>
                                            <option value="GBP">GBP British Pound</option>
                                            <option value="USD" selected="selected">USD United States Dollar</option>
                                            <option value="ZAR">ZAR South African Rand</option>
                                        </optgroup>
                                        <optgroup id="sell_currency-optgroup-Other currencies" label="Other currencies">
                                            <option value="AED">AED United Arab Emirates Dirham</option>
                                            <option value="ALL">ALL Albanian Lek</option>
                                            <option value="AMD">AMD Armenian Dram</option>
                                            <option value="ANG">ANG Netherlands Antillean Guilder</option>
                                            <option value="AOA">AOA Angolan Kwanza</option>
                                            <option value="ARS">ARS Argentine Peso</option>
                                            <option value="AUD">AUD Australian Dollar</option>
                                            <option value="AZN">AZN Azerbaijan New Manat</option>
                                            <option value="BAM">BAM Bosnia Herzegovina Marka</option>
                                            <option value="BBD">BBD Barbados Dollars</option>
                                            <option value="BDT">BDT Bangladesh Taka</option>
                                            <option value="BGN">BGN Bulgarian lev</option>
                                            <option value="BHD">BHD Bahrain dinars</option>
                                            <option value="BIF">BIF Burundian Franc</option>
                                            <option value="BMD">BMD Bermudian Dollar</option>
                                            <option value="BND">BND Brunei Dollar</option>
                                            <option value="BOB">BOB Bolivian Boliviano</option>
                                            <option value="BRL">BRL Brazilian Real</option>
                                            <option value="BSD">BSD Bahamian Dollar</option>
                                            <option value="BWP">BWP Botswana Pula</option>
                                            <option value="BYN">BYN New Belarusian ruble</option>
                                            <option value="BZD">BZD Belize Dollar</option>
                                            <option value="CAD">CAD Canadian Dollar</option>
                                            <option value="CDF">CDF Congolese Franc</option>
                                            <option value="CHF">CHF Swiss Franc</option>
                                            <option value="CLP">CLP Chilean Peso</option>
                                            <option value="CNH">CNH Chinese Offshore Yuan</option>
                                            <option value="CNY">CNY Chinese Yuan</option>
                                            <option value="COP">COP Colombian Peso</option>
                                            <option value="CRC">CRC Costa Rican Colon</option>
                                            <option value="CVE">CVE Cape Verde Escudo</option>
                                            <option value="CZK">CZK Czech Koruna</option>
                                            <option value="DJF">DJF Djibouti Franc</option>
                                            <option value="DKK">DKK Danish Kroner</option>
                                            <option value="DOP">DOP Dominican Peso</option>
                                            <option value="DZD">DZD Algerian Dinar</option>
                                            <option value="EGP">EGP Egyptian Pound</option>
                                            <option value="ERN">ERN Eritrean Nakfa</option>
                                            <option value="ETB">ETB Ethiopian Birr</option>
                                            <option value="EUR">EUR Euro</option>
                                            <option value="FJD">FJD Fijian Dollars</option>
                                            <option value="GBP">GBP British Pound</option>
                                            <option value="GEL">GEL Georgian Lari</option>
                                            <option value="GHS">GHS Ghanaian Cedi</option>
                                            <option value="GMD">GMD Gambian Dalasi</option>
                                            <option value="GNF">GNF Guinean Franc</option>
                                            <option value="GTQ">GTQ Guatemalan Quetzal</option>
                                            <option value="GYD">GYD Guyanese Dollar</option>
                                            <option value="HKD">HKD Hong Kong Dollar</option>
                                            <option value="HNL">HNL Honduran Lempira</option>
                                            <option value="HRK">HRK Croatian Kuna</option>
                                            <option value="HTG">HTG Haitian Gourde</option>
                                            <option value="HUF">HUF Hungarian Forint</option>
                                            <option value="IDR">IDR Indonesian Rupiah</option>
                                            <option value="ILS">ILS Israeli New Shekel</option>
                                            <option value="INR">INR Indian Rupees</option>
                                            <option value="IQD">IQD Iraqi Dinar</option>
                                            <option value="ISK">ISK Icelandic Kronur</option>
                                            <option value="JMD">JMD Jamaican Dollar</option>
                                            <option value="JOD">JOD Jordan Dinar</option>
                                            <option value="JPY">JPY Japanese Yen</option>
                                            <option value="KES">KES Kenyan Shilling</option>
                                            <option value="KHR">KHR Cambodian Riel</option>
                                            <option value="KRW">KRW South Korean Won</option>
                                            <option value="KWD">KWD Kuwaiti Dinar</option>
                                            <option value="KYD">KYD Cayman Island Dollar</option>
                                            <option value="KZT">KZT Kazakhstani Tenge</option>
                                            <option value="LAK">LAK Laos Kip</option>
                                            <option value="LBP">LBP Lebanese Pound</option>
                                            <option value="LKR">LKR Sri Lankan Rupee</option>
                                            <option value="LRD">LRD Liberian Dollar</option>
                                            <option value="LSL">LSL Lesotho Loti</option>
                                            <option value="MAD">MAD Moroccan Dirham</option>
                                            <option value="MGA">MGA Malagsy Ariary</option>
                                            <option value="MKD">MKD Macedonian Denar</option>
                                            <option value="MNT">MNT Mongolian Tugrik</option>
                                            <option value="MRO">MRO Mauritanian Ouguiya</option>
                                            <option value="MUR">MUR Mauritian Rupees</option>
                                            <option value="MWK">MWK Malawian Kwacha</option>
                                            <option value="MXN">MXN Mexican Peso</option>
                                            <option value="MYR">MYR Malaysian Ringgit</option>
                                            <option value="MZN">MZN Mozambican Metical</option>
                                            <option value="NAD">NAD Namibian Dollar</option>
                                            <option value="NGN">NGN Nigerian Naira</option>
                                            <option value="NIO">NIO Nicaraguan Cordoba</option>
                                            <option value="NOK">NOK Norwegian Krone</option>
                                            <option value="NPR">NPR Nepalese Rupee</option>
                                            <option value="NZD">NZD New Zealand Dollar</option>
                                            <option value="OMR">OMR Omani Riyal</option>
                                            <option value="PEN">PEN Peruvian Nuevo Sol</option>
                                            <option value="PGK">PGK Papua New Guinean Kina</option>
                                            <option value="PHP">PHP Philippine Peso</option>
                                            <option value="PKR">PKR Pakistan Rupees</option>
                                            <option value="PLN">PLN Polish Zlotych</option>
                                            <option value="PYG">PYG Paraguayan Guarani</option>
                                            <option value="QAR">QAR Qatari Rial</option>
                                            <option value="RON">RON Romanian Lei</option>
                                            <option value="RSD">RSD Serbian Dinar</option>
                                            <option value="RUB">RUB Russian ruble</option>
                                            <option value="RWF">RWF Rwandan Franc</option>
                                            <option value="SAR">SAR Saudi Arabian Riyal</option>
                                            <option value="SBD">SBD Solomon Islands Dollar</option>
                                            <option value="SCR">SCR Seychelles Rupee</option>
                                            <option value="SEK">SEK Swedish Kronor</option>
                                            <option value="SGD">SGD Singapore Dollar</option>
                                            <option value="SLL">SLL Sierra Leonean Leone</option>
                                            <option value="SRD">SRD Surinamese Dollar</option>
                                            <option value="STD">STD Sao Tome &amp; Principe Dobra</option>
                                            <option value="SZL">SZL Swaziland Lilangeni</option>
                                            <option value="THB">THB Thai Baht</option>
                                            <option value="TND">TND Tunisian dinar</option>
                                            <option value="TOP">TOP Tongan Pa'anga</option>
                                            <option value="TRY">TRY Turkish Lira</option>
                                            <option value="TTD">TTD Trinidad and Tobago Dollars</option>
                                            <option value="TWD">TWD Taiwan New Dollar</option>
                                            <option value="TZS">TZS Tanzanian Shilling</option>
                                            <option value="UGX">UGX Ugandan Shilling</option>
                                            <option value="USD" selected="selected">USD United States Dollar</option>
                                            <option value="UYU">UYU Uruguayan Peso</option>
                                            <option value="VEF">VEF Venezuelan Bolivar Fuerte</option>
                                            <option value="VND">VND Vietnamese Dong</option>
                                            <option value="VUV">VUV Vanuatu Vatu</option>
                                            <option value="WST">WST Samoan Tala</option>
                                            <option value="XAF">XAF Cameroon Central African Franc</option>
                                            <option value="XCD">XCD East Carribean Dollar</option>
                                            <option value="XOF">XOF Central African States CFA Fra</option>
                                            <option value="XPF">XPF French Pacific Franc</option>
                                            <option value="ZAR">ZAR South African Rand</option>
                                            <option value="ZMW">ZMW Zambian Kwacha</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="sell-amount form-group ">
                                <div class="col-xs-12">
                                    <div class="input-group">
                                        <input type="number" placeholder="Currency" name="amount" id="amount"
                                               class="form-control inputCurrency" value="1"/><span
                                                class="input-group-addon"><span
                                                    class="icon-refresh no-margin"><b>Amount</b></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class=" form-group ">
                                <div class="col-xs-12">
                                    <select name="to_currency"
                                            class="form-control col-lg-3" required="">
                                        <optgroup id="buy_currency-optgroup-Common currencies"
                                                  label="Common currencies">
                                            <option value="AUD">AUD Australian Dollar</option>
                                            <option value="CAD">CAD Canadian Dollar</option>
                                            <option value="EUR">EUR Euro</option>
                                            <option value="GBP" selected="selected">GBP British Pound</option>
                                            <option value="USD">USD United States Dollar</option>
                                            <option value="ZAR">ZAR South African Rand</option>
                                        </optgroup>
                                        <optgroup id="buy_currency-optgroup-Other currencies" label="Other currencies">
                                            <option value="AED">AED United Arab Emirates Dirham</option>
                                            <option value="ALL">ALL Albanian Lek</option>
                                            <option value="AMD">AMD Armenian Dram</option>
                                            <option value="ANG">ANG Netherlands Antillean Guilder</option>
                                            <option value="AOA">AOA Angolan Kwanza</option>
                                            <option value="ARS">ARS Argentine Peso</option>
                                            <option value="AUD">AUD Australian Dollar</option>
                                            <option value="AZN">AZN Azerbaijan New Manat</option>
                                            <option value="BAM">BAM Bosnia Herzegovina Marka</option>
                                            <option value="BBD">BBD Barbados Dollars</option>
                                            <option value="BDT">BDT Bangladesh Taka</option>
                                            <option value="BGN">BGN Bulgarian lev</option>
                                            <option value="BHD">BHD Bahrain dinars</option>
                                            <option value="BIF">BIF Burundian Franc</option>
                                            <option value="BMD">BMD Bermudian Dollar</option>
                                            <option value="BND">BND Brunei Dollar</option>
                                            <option value="BOB">BOB Bolivian Boliviano</option>
                                            <option value="BRL">BRL Brazilian Real</option>
                                            <option value="BSD">BSD Bahamian Dollar</option>
                                            <option value="BWP">BWP Botswana Pula</option>
                                            <option value="BYN">BYN New Belarusian ruble</option>
                                            <option value="BZD">BZD Belize Dollar</option>
                                            <option value="CAD">CAD Canadian Dollar</option>
                                            <option value="CDF">CDF Congolese Franc</option>
                                            <option value="CHF">CHF Swiss Franc</option>
                                            <option value="CLP">CLP Chilean Peso</option>
                                            <option value="CNH">CNH Chinese Offshore Yuan</option>
                                            <option value="CNY">CNY Chinese Yuan</option>
                                            <option value="COP">COP Colombian Peso</option>
                                            <option value="CRC">CRC Costa Rican Colon</option>
                                            <option value="CVE">CVE Cape Verde Escudo</option>
                                            <option value="CZK">CZK Czech Koruna</option>
                                            <option value="DJF">DJF Djibouti Franc</option>
                                            <option value="DKK">DKK Danish Kroner</option>
                                            <option value="DOP">DOP Dominican Peso</option>
                                            <option value="DZD">DZD Algerian Dinar</option>
                                            <option value="EGP">EGP Egyptian Pound</option>
                                            <option value="ERN">ERN Eritrean Nakfa</option>
                                            <option value="ETB">ETB Ethiopian Birr</option>
                                            <option value="EUR">EUR Euro</option>
                                            <option value="FJD">FJD Fijian Dollars</option>
                                            <option value="GBP" selected="selected">GBP British Pound</option>
                                            <option value="GEL">GEL Georgian Lari</option>
                                            <option value="GHS">GHS Ghanaian Cedi</option>
                                            <option value="GMD">GMD Gambian Dalasi</option>
                                            <option value="GNF">GNF Guinean Franc</option>
                                            <option value="GTQ">GTQ Guatemalan Quetzal</option>
                                            <option value="GYD">GYD Guyanese Dollar</option>
                                            <option value="HKD">HKD Hong Kong Dollar</option>
                                            <option value="HNL">HNL Honduran Lempira</option>
                                            <option value="HRK">HRK Croatian Kuna</option>
                                            <option value="HTG">HTG Haitian Gourde</option>
                                            <option value="HUF">HUF Hungarian Forint</option>
                                            <option value="IDR">IDR Indonesian Rupiah</option>
                                            <option value="ILS">ILS Israeli New Shekel</option>
                                            <option value="INR">INR Indian Rupees</option>
                                            <option value="IQD">IQD Iraqi Dinar</option>
                                            <option value="ISK">ISK Icelandic Kronur</option>
                                            <option value="JMD">JMD Jamaican Dollar</option>
                                            <option value="JOD">JOD Jordan Dinar</option>
                                            <option value="JPY">JPY Japanese Yen</option>
                                            <option value="KES">KES Kenyan Shilling</option>
                                            <option value="KHR">KHR Cambodian Riel</option>
                                            <option value="KRW">KRW South Korean Won</option>
                                            <option value="KWD">KWD Kuwaiti Dinar</option>
                                            <option value="KYD">KYD Cayman Island Dollar</option>
                                            <option value="KZT">KZT Kazakhstani Tenge</option>
                                            <option value="LAK">LAK Laos Kip</option>
                                            <option value="LBP">LBP Lebanese Pound</option>
                                            <option value="LKR">LKR Sri Lankan Rupee</option>
                                            <option value="LRD">LRD Liberian Dollar</option>
                                            <option value="LSL">LSL Lesotho Loti</option>
                                            <option value="MAD">MAD Moroccan Dirham</option>
                                            <option value="MGA">MGA Malagsy Ariary</option>
                                            <option value="MKD">MKD Macedonian Denar</option>
                                            <option value="MNT">MNT Mongolian Tugrik</option>
                                            <option value="MRO">MRO Mauritanian Ouguiya</option>
                                            <option value="MUR">MUR Mauritian Rupees</option>
                                            <option value="MWK">MWK Malawian Kwacha</option>
                                            <option value="MXN">MXN Mexican Peso</option>
                                            <option value="MYR">MYR Malaysian Ringgit</option>
                                            <option value="MZN">MZN Mozambican Metical</option>
                                            <option value="NAD">NAD Namibian Dollar</option>
                                            <option value="NGN">NGN Nigerian Naira</option>
                                            <option value="NIO">NIO Nicaraguan Cordoba</option>
                                            <option value="NOK">NOK Norwegian Krone</option>
                                            <option value="NPR">NPR Nepalese Rupee</option>
                                            <option value="NZD">NZD New Zealand Dollar</option>
                                            <option value="OMR">OMR Omani Riyal</option>
                                            <option value="PEN">PEN Peruvian Nuevo Sol</option>
                                            <option value="PGK">PGK Papua New Guinean Kina</option>
                                            <option value="PHP">PHP Philippine Peso</option>
                                            <option value="PKR">PKR Pakistan Rupees</option>
                                            <option value="PLN">PLN Polish Zlotych</option>
                                            <option value="PYG">PYG Paraguayan Guarani</option>
                                            <option value="QAR">QAR Qatari Rial</option>
                                            <option value="RON">RON Romanian Lei</option>
                                            <option value="RSD">RSD Serbian Dinar</option>
                                            <option value="RUB">RUB Russian ruble</option>
                                            <option value="RWF">RWF Rwandan Franc</option>
                                            <option value="SAR">SAR Saudi Arabian Riyal</option>
                                            <option value="SBD">SBD Solomon Islands Dollar</option>
                                            <option value="SCR">SCR Seychelles Rupee</option>
                                            <option value="SEK">SEK Swedish Kronor</option>
                                            <option value="SGD">SGD Singapore Dollar</option>
                                            <option value="SLL">SLL Sierra Leonean Leone</option>
                                            <option value="SRD">SRD Surinamese Dollar</option>
                                            <option value="STD">STD Sao Tome &amp; Principe Dobra</option>
                                            <option value="SZL">SZL Swaziland Lilangeni</option>
                                            <option value="THB">THB Thai Baht</option>
                                            <option value="TND">TND Tunisian dinar</option>
                                            <option value="TOP">TOP Tongan Pa'anga</option>
                                            <option value="TRY">TRY Turkish Lira</option>
                                            <option value="TTD">TTD Trinidad and Tobago Dollars</option>
                                            <option value="TWD">TWD Taiwan New Dollar</option>
                                            <option value="TZS">TZS Tanzanian Shilling</option>
                                            <option value="UGX">UGX Ugandan Shilling</option>
                                            <option value="USD">USD United States Dollar</option>
                                            <option value="UYU">UYU Uruguayan Peso</option>
                                            <option value="VEF">VEF Venezuelan Bolivar Fuerte</option>
                                            <option value="VND">VND Vietnamese Dong</option>
                                            <option value="VUV">VUV Vanuatu Vatu</option>
                                            <option value="WST">WST Samoan Tala</option>
                                            <option value="XAF">XAF Cameroon Central African Franc</option>
                                            <option value="XCD">XCD East Carribean Dollar</option>
                                            <option value="XOF">XOF Central African States CFA Fra</option>
                                            <option value="XPF">XPF French Pacific Franc</option>
                                            <option value="ZAR">ZAR South African Rand</option>
                                            <option value="ZMW">ZMW Zambian Kwacha</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input type="text" id="responseConvert"
                                           class="color-blue form-control inputCurrency" readonly value="{{!empty($data['paramConvert']) ? $data['paramConvert'] : ''}}">
                                </div>
                            </div>
                            <div class=" form-group ">
                                <div class="col-xs-12">
                                    <button id="convert" type="submit" class="btn btn-wf-blue s125 btn btn-default">
                                        <b>Convert</b><i
                                                class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div id="main">
        <div class="col-lg-9 col-xs-12">
            <div class="convert-number-left">
                <h3 class="h3-title">SPELLOUT NUMBER</h3>
                <div class="image">
                    <div class="spellout-number">
                        <p class="text-center"><b>Input Number</b></p>
                        <form action="{{ url('/numberMobile') }}">
                            <input type="number" class="form-control inputCurrency-nb text-center" required=""
                                   id="numberInput" name="numberInput"
                                   value="{{!empty($data["numberInput"]) ? $data["numberInput"] : '1'}}">
                            <div class="button-convert-first">
                                <button class="btn btn-default btn-padding" type="submit" id="getAllResults"><b>Convert
                                        Number To Word</b>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="number-type">
                        <div>
                            <table class="table text-white">
                                <thead>
                                <tr>
                                    <th>Spellout</th>
                                    <th>Value</th>
                                    <th>Audio</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><span><b>Spellout each digits of number input</b></span></td>
                                    <td>
                                        <span class="eachNumberToWordAudio"><b>{{!empty($data["convertDigits"]) ? $data["convertDigits"] : 'one'}}</b></span>
                                    </td>
                                    <td><input class="speak-audio"
                                               onclick="responsiveVoice.speak($('.eachNumberToWordAudio').text());"
                                               type='button' value='🔊'/></td>
                                </tr>
                                <tr>
                                    <td><span><b>Spellout rule-based format</b></span></td>
                                    <td><span
                                                class="allNumberToWordAudio"><b>{{!empty($data["convertNumber"]) ? $data["convertNumber"] : 'one'}}</b></span>
                                    </td>
                                    <td><input class="speak-audio"
                                               onclick="responsiveVoice.speak($('.allNumberToWordAudio').text());"
                                               type='button'
                                               value='🔊'/></td>
                                </tr>
                                <tr>
                                    <td><b>Even numbers in input string</b></td>
                                    <td><span><b>{{!empty($data["evenNumber"]) ? $data["evenNumber"] : ''}}</b></span>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Odd numbers in input string</b></td>
                                    <td><span><b>{{!empty($data["oddNumber"]) ? $data["oddNumber"] : '1'}}</b></span></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Min number in input string</b></td>
                                    <td><span><b>{{!empty($data["minNumber"]) ? $data["minNumber"] : '1'}}</b></span></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Sum all digits in input string</b></td>
                                    <td><span><b>{{!empty($data["arraySum"]) ? $data["arraySum"] : '1'}}</b></span></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-12 ">
            <h3 class="relate-number text-center">RELATE AND RANDOM NUMBER</h3>
            <div class="sidebar-bg">
                <div class="text-center sidebar-fs">
                    <span>
                        @if(!empty($data["numberAdd"]))
                            @foreach(($data["numberAdd"]) as $el)
                                <a href="{{url('/')}}/{{$el}}-numbers">
                                <span class="relateNumber">{{$el}}</span>
                            </a>
                            @endforeach
                        @endif
                    </span>
                    <span>
                         @if(!empty($data["numberSub"]))
                            @foreach(($data["numberSub"]) as $el)
                                <a href="{{url('/')}}/{{$el}}-numbers">
                                <span class="relateNumber">{{$el}}</span>
                            </a>
                            @endforeach
                        @endif
                    </span>
                </div>
                <div class="span-currency random-number text-center">
                    <span class="sidebar-fs"><b>Random Numbers:</b></span>
                    <div class="sidebar-fs">
                        @if(!empty($data['randomNumber']))
                            @foreach(($data['randomNumber']) as $vl)
                                <a href="{{url('/')}}/{{$vl}}-numbers">
                                    <span class="randomNumber">{{$vl}}</span>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <section class="currency-res" tabindex="-1">
        <h3 class="h3-title text-center">CURRENCIES TO AUDIO</h3>
        <div class="panel-wrapper">
            <a href="#show" class="show btn-more" id="show">Show More</a>
            <a href="#hide" class="hide btn-more" id="hide">Show Less</a>
            <div class="panel">
                <table class="table">
                    <thead class="thead-color">
                    <tr>
                        <th>Currencies</th>
                        <th>Currencies to text</th>
                        <th>Audio</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($listCurrency))
                        @foreach($listCurrency as $v => $v_value)
                            <tr>
                                <td><span class="span-currency"><b>{{$v}}</b></span></td>
                                <td>
                                    <span class="span-currency {{$v}}">{{!empty($data["convertNumber"]) ? $data["convertNumber"] : 'one'}} {{$v_value}}</span>
                                </td>
                                <td><input class="speak-audio" onclick="responsiveVoice.speak($('.{{$v}}').text());"
                                           type='button' value='🔊'/></td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="fade"></div>
        </div>
    </section>
</div>
<footer id="footer">
    <div class="footer-left clear-fix">
        <ul class="clearfix list-unstyled">
            <li class="pull-left"><a href="#">About Us</a></li>
            <li class="pull-left"><a href="#">Privacy Policy</a></li>
            <li class="pull-left"><a href="#">Terms of Service</a></li>
            <li class="pull-left"><a href="#">Contact</a></li>
        </ul>
    </div>
    <div class="footer-right">
        © Copyright 2018. All Rights Reserved.
    </div>
</footer>

<input type="hidden" value="{{ url('/') }}" id="home">
</body>
</html>