<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
<script src = "https://plus.google.com/js/client:platform.js" async defer></script>
<script>
    function copyExec(is) {
        var copyText = document.getElementById("code_text");
        copyText.select();
        document.execCommand("Copy");
        $(is).html('Copied!!!');
        setTimeout(function(){
            $('#d_clip_button').html('Copy Code');
        }, 2000);
    }
    $('#getCodeModal').on($.modal.CLOSE, function (e) {
        location.href = '{{ url('/'.$coupon['store']['alias']) }}';
    });
</script>
<meta name="google-signin-client_id" content="961032573596-k1buoevm65k2sjqeci2mur5j4ctkdcnr.apps.googleusercontent.com">
<a class="close close-sm" data-dismiss="modal" aria-label="Close" rel="modal:close"><i class="fa fa-times"></i></a>
<div class="modal-frame" id="modal-frame-get">
    <div class="modal-frame-left frame-coupon-info">
        <div class="modal-frame-left-small">
            <div class="frame-store-logo">
                <a data-dismiss="modal" aria-label="Close" rel="modal:close">
                    <img src="{{$coupon['store']['logo']}}" alt="{{$coupon['title']}}" style="max-width: 90px;max-height: 90px"/>
                </a>
            </div>
            <div class="col-xs-12">
                @include('GA.ga-dpf')
            </div>
            <div class="modal-frame-title-coupon">{{$coupon['title']}}</div>
            @if(!empty($coupon['store']['cashBackJson']) && sizeof($coupon['store']['cashBackJson']))
                <div class="modal-coupon-cash-back">{{$coupon['cashBack']}}</div>
            @endif
            @if(Auth::guest() && !empty($coupon['store']['cashBackJson']) && sizeof($coupon['store']['cashBackJson']))
                @if(!empty($coupon['coupon_code']))
                    <div class="modal-frame-box-get-code">
                        <div class="frame-code">{{substr($coupon['coupon_code'], -3, 3)}}</div>
                        <div class="frame-btn-sign-get-code">
                            <a class="btn-sign-get-code">Sign in to get code</a>
                        </div>
                    </div>
                @else
                    <div class="modal-frame-box-get-deal">
                        Sign in to get deal
                    </div>
                @endif
            @else
                @if(!empty($coupon['coupon_code']))
                    <div class="modal-frame-box-code">
                        <input class="frame-code input-select-code" id="code_text" value="{{$coupon['coupon_code']}}" readonly />
                        <div class="frame-btn-copy">
                            <a class="btn btn-copy-code" id="d_clip_button" data-clipboard-target="code_text" data-toggle="tooltip" data-placement="bottom"
                               title="Copy to clipboard" onclick="copyExec(this)">Copy Code</a>
                        </div>
                    </div>
                @else
                    <div class="modal-frame-box-get-deal no-code">
                        No code required
                    </div>
                @endif
            @endif
            <hr>
            @if($relateCp)
                <div class="coupon-relate">
                    <div class="maybe"><b>You may also like</b></div>
                    <div class="row">
                        @foreach($relateCp as $c)<?php $link = url("/coupon-detail/{$c->foreign_key_right}/" . str_slug($c->title, '-') . "/" . $coupon['store']['alias']); ?>
                            <div class="col-xs-4 col-md-4 col-lg-4 col-xl-4">
                                <a  title="{{$coupon['store']['name']}}" rel="nofollow" itemprop="name" class="title get-deal-btn location" data-href="{{$link}}" data-affiliate="{{$coupon['store']['affiliate_url']}}">
                                    <div>
                                        <img src="{{ $coupon['store']['logo'] }}">
                                    </div>
                                    <div class="c-title"><span class="c-line">{{ strlen($c->title)>25?substr($c->title,0,25).'...':$c->title }}</span></div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <ul class="frame-coupon-expire">
                @if(!empty($coupon['expireDate']))
                    <li>Expire on <span class="format-date">{{$coupon['expireDate']}}</span></li>
                @endif
                @if(!empty($coupon['number_used']))
                    <li>{{$coupon['number_used']}} Used Today</li>
                @endif
            </ul>
            <div class="row" id="modal-frame-btn">
                <div class="col-xs-8 frame-social-share">
                    <a id="fb-share-button" href="javascript:;" class="facebook"><i class="fa fa-facebook-square"></i></a>
                    <a class="twitter-share-button" id="twitter-share-button" target="_blank"><i class="fa fa-twitter-square"></i></a>
                    <g:plus action="share" onendinteraction="ggCallback" annotation = "none"></g:plus>
                </div>
                <div class="col-xs-4 frame-social-tools">
                    <a href="javascript:;" class="save-coupon save-cp-without-login item-save-icon click-to-save{{!empty($favourites[$coupon['id']]) ? ' saved' : ''}}" id="{{$coupon['id']}}"><i class="fa fa-check"></i></a>
                    <a class="like-coupon like like-btn btn-like" data-url="#like-popup-store-{{$coupon['id']}}" data-toggle="tooltip" title="Like
                        this" c_id="{{$coupon['id']}}" data-ui-popup-place="modal-frame-btn">
                        <i class="fa fa-thumbs-o-up"></i>
                    </a>
                    <a class="dislike-coupon dislike btn-dislike" data-toggle="tooltip" data-placement="top" title="Dislike this" c_id="{{$coupon['id']}}">
                        <i class="fa fa-thumbs-o-down"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var uid = '';
    var fbUserId = '';
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '{{ config("config.social.facebook.appId") }}',
            xfbml      : true,
            version    : '{{ config("config.social.facebook.version") }}'
        });
        FB.getLoginStatus(function(response){
            if (response.status === 'connected' || response.status === 'not_authorized') {
                logged();
                // console.log('FB userID:', response.authResponse.userID);
                fbUserId = response.authResponse.userID;
            }else{
                // user not logged in fb
                // notLogin();
            }
        })

    };
    function afterFbLoggedin(){
        logged();
        FB.getLoginStatus(function(response){
            fbUserId = response.authResponse.userID;
        })
    }
    function logged(){$('.facebook.btnFbLogin').hide();$('.facebook.btnFbShare').show();}
    function notLogin(){$('.facebook.btnFbLogin').show();$('.facebook.btnFbShare').hide();}
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!-- Google+ -->
<script>
    function getParam(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null){return null;}else{return results[1] || 0;}
    }
    /*Share to Google+*/
    window.___gcfg = {lang: 'en-US', parsetags: 'onload'};
    function ggCallback(jsonParam){
        // Save to db
        var data = {
            uid:getParam('uid'),
            via:'gg',
            fkr:getParam('c'),
            url:window.location.href
        };
        $.get('{{url("/shared/store")}}', data, function(response){
            console.log(response);
        })
    }
    function endShare(jsonParam){
        console.log('endshare:', jsonParam);
    }
    /*Sign in to Google*/
    ggNotLogin();
    function ggLogged(){$('.google.login').hide();$('.google.share').show();}
    function ggNotLogin(){$('.google.login').show();$('.google.share').hide();}
    function onSignIn(googleUser){
        var profile = googleUser.getBasicProfile();
        $('.btnShareGg').attr('href', 'https://plus.google.com/share?url=' + url + '&via=gg&uid=' + profile.getEmail());
        // $('link[rel="canonical"]').attr('href', url + '&via=gg&uid=' + profile.getEmail());
        $('meta[property="og:url"]').attr('content', url + '&via=gg&uid=' + profile.getEmail());
        ggLogged();
    }
</script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script>
    /*Get tags value*/
    var image = $('meta[property="og:image"]').attr('content');
    var url = $('meta[property="og:url"]').attr('content');

    // Set og: properties for FB share
    $(document).ready(function(){
        /*Dynamic set fb tags*/
        $('meta[property="og:title"]').attr('content', $('.item-title').text());
        $('meta[property="og:description"]').attr('content', $.trim($('.item-description').text()));
        $('meta[property="og:image"]').attr('content', $('.item-image.img-responsive').attr('src'));

        $('#fb-share-button').click(function() {
            uid = fbUserId;
            var shareUrl = url + '&via=fb&uid=' + uid;
            FB.ui({
                method: 'share',
                href: shareUrl,
                display: 'popup',
                redirect_uri: url,
                picture: image
            }, function(response){
                if(typeof response === 'undefined' || response.error_code){
                    console.log('Error:', response);
                }else{
                    if((shareUrl).indexOf('&uid=') > -1){
                        var data = {
                            uid:getParam('uid'),
                            via:getParam('via'),
                            fkr:getParam('c'),
                            url:window.location.href
                        };
                        $.get('{{url("/shared/store")}}', data, function(response){
                            console.log(response);
                        })
                    }
                }
            });
        });

        $('.btnShareGg').click(function(response){
            window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;
        })

        // Save clicked social share
        // if((window.location.href).indexOf('&uid=') > -1){
        var data = {
            uid:getParam('uid'),
            via:getParam('via'),
            fkr:getParam('c'),
            url:window.location.href
        };
        $.get('{{url("/shared/update")}}', data, function(response){
            console.log(response);
        })
        // }

        /*Twitter*/
        $.getScript("http://platform.twitter.com/widgets.js", function(){
            function TweetEvent(event){
                if (event) {
                    // Save to db
                    var data = {
                        uid:getParam('uid'),
                        via:'tw',
                        fkr:getParam('c'),
                        url:window.location.href
                    };
                    $.get('{{url("/shared/store")}}', data, function(response){
                        console.log(response);
                    })
                }
            }
            twttr.events.bind('tweet', TweetEvent);
        });
    })
</script>
<style>/*--*/
    .modal-frame-title-coupon {font-size: 18px; font-weight: bold}
    .coupon-relate,.modal-frame {text-align: center}
    .coupon-relate { border-top: 1px solid #cacaca;}
    .coupon-relate img {max-width: 100px;}

    .modal-frame .frame-coupon-info .modal-frame-box-code .input-select-code {
        font-size: 17px;
        color: #7FBA00;
        background-color: #E0E0E0;
        border: none;
        box-shadow: none;
        -webkit-box-shadow: none;
    }
    .modal-frame .frame-coupon-info .modal-frame-box-code .frame-code {
        display: table-cell;
        line-height: 46px;
        width: auto;
        vertical-align: middle;
        text-align: center;
    }

    .modal-frame .frame-coupon-info .modal-frame-box-code .frame-btn-copy {
        position: relative;
        display: table-cell;
        vertical-align: middle;
        text-align: center;
        min-width: 105px;
    }
    .frame-btn-copy .btn { padding: 7px}
    .coupon-relate .c-title {font-size: 14px;}
    .coupon-relate .maybe {padding-bottom: 23px;padding-top:15px;}
    .modal-frame-title-coupon {font-size: 18px; font-weight: bold}
    .coupon-relate,.modal-frame {text-align: center}
    .coupon-relate { border-top: 1px solid #cacaca;}
    .coupon-relate img {max-width: 90px;margin-bottom: 15px}
    .coupon-relate {margin-bottom: 10px;}
    .frame-coupon-info .frame-store-logo {max-height: 100px !important; margin:auto;margin-bottom: 15px}
    .frame-store-logo img {max-width: 100%;max-height: 100%}
	.no-code {width: 100% !important}
</style>