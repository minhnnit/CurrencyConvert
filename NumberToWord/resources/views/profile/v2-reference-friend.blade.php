@extends('profile.v2-profile-app')

@section('before-header')
    @include('elements.changeAvatarModal')
@endsection
@section('profile-content')

<div class="profile-box-default refer-profile-form">
    <div class="box-content">
        <div class="row">
            <div class="col-sm-4 tbl-step-refer">
                <div class="form-group text-center refer-step">
                    <div class="refer-img">
                        <img src="{{asset('/images/Profile_refer_step1.png')}}" />
                    </div>
                    <div class="reference-text">Refer a friend,<br> family or colleague</div>
                </div>
            </div>
            <div class="col-sm-4 tbl-step-refer">
                <div class="form-group text-center refer-step">
                    <div class="refer-img">
                        <img src="{{asset('/images/Profile_refer_step2.png')}}" />
                    </div>
                    <div class="reference-text">Your friend starts to<br> earn cash back</div>
                </div>
            </div>
            <div class="col-sm-4 tbl-step-refer">
                <div class="form-group text-center refer-step">
                    <div class="refer-img">
                        <img src="{{asset('/images/Profile_refer_step3.png')}}" />
                    </div>
                    <div class="reference-text">You get <b class="reference-bonus-text">$10</b> bonus<br> for each friend</div>
                </div>
            </div>
        </div>
        <div class="group-input-link">
            <div class="input-group-box">
                <div class="input-group">
                    <div class="input-group-addon icon-link" >
                        <label for="ipReferLink" class="fa fa-link"></label>
                    </div>
                    <input id="ipReferLink" type="text" value="{{ $referUrl }}" class="form-control input-lg reference-input" />
                    <div class="input-group-addon reference-button" data-clipboard-target="ipReferLink" id="copyReferLink">Copy</div>
                </div>
            </div>
        </div>
        <div class="row group-share-btn">
            <div class="col-xs-4 ref-share-button text-right no-margin-right">
                <div class="btn ref-btn-fb">
                    <i class="fa fa-facebook ref-share-icon margin-right-20 line-height-32"></i>
                    <div class="pull-right line-height-32 reference-share btn-fb-share" data-title="{{ $referUrl }}"
                         data-desc="Get $10 when signin DontPayAll.com" data-url="{{ $referUrl }}"
                         data-image="{{asset('images/Logo-Dontpayall.svg')}}">Share <span>link on Facebook</span></div>
                </div>
            </div>
            <div class="col-xs-4 ref-share-button ref-tw text-center">
                <div class="btn ref-btn-tw">
                    <i class="fa fa-twitter ref-share-icon margin-right-20 line-height-32"></i>
                    <div class="pull-right line-height-32 reference-share btn-tw-share twitter"
                         data-href="https://twitter.com/intent/tweet?text={{ $referUrl }}">Share <span>link on Twitter</span></div>
                    <!-- <a class="twitter popup" href="http://twitter.com/share">Tweet</a> -->
                </div>
            </div>
            <div class="col-xs-4 ref-share-button ref-gg text-left no-margin-left">
                <div class="btn ref-btn-gg ">
                    <i class="fa fa-google-plus ref-share-icon margin-right-20 line-height-32"></i>
                    <div class="pull-right line-height-32 reference-share btn-gg-share"
                         onclick="javascript:window.open(this.getAttribute('data-href'), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"
                         data-href="https://plus.google.com/share?url={{ $referUrl }}">Share <span>link on Google+</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts-footer')
<script type="text/javascript">
    /*Copy Refer Url*/
    var btn_copy = $('#copyReferLink');
    if(FlashDetect.installed){
        ZeroClipboard.config({moviePath: "{{ asset('static/js')}}" + "/ZeroClipboard.swf"});
        var clip = new ZeroClipboard(btn_copy);
        clip.on("load", function() {
            this.on("complete", function(event) {
                btn_copy.text('Copied');
            });
        });
        clip.on("error", function(event) {
            ZeroClipboard.destroy();
            alert('Error ZeroClipboard');
        });
    }
    /*Facebook*/
    window.fbAsyncInit = function(){
        FB.init({
            appId      : '{{ config("config.social.facebook.appId") }}',
            version    : '{{ config("config.social.facebook.version") }}'
            status: true,
            cookie: true,
            xfbml: true
        });
    };
    (function(d, debug){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if(d.getElementById(id)) {return;}
        js = d.createElement('script'); js.id = id;
        js.async = true;js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
        ref.parentNode.insertBefore(js, ref);}(document, /*debug*/ false));
    function postToFeed(title, desc, url, image){
        var obj = {
            method: 'feed',
            link: url,
            picture: image,
            name: title,
            description: desc
        };
        function callback(response){}
        FB.ui(obj, callback);
    }
    $('.btn-fb-share').click(function(){
        elem = $(this);
        postToFeed(elem.data('title'), elem.data('desc'), elem.data('url'), elem.data('image'));
        return false;
    });
    /*Twitter*/
    $('.btn-tw-share').click(function(event) {
        var width  = 575,
            height = 400,
            left   = ($(window).width()  - width)  / 2,
            top    = ($(window).height() - height) / 2,
            url    = $(this).attr('data-href'),
            opts   = 'status=1' +
                     ',width='  + width  +
                     ',height=' + height +
                     ',top='    + top    +
                     ',left='   + left;

        window.open(url, 'twitter', opts);
        return false;
    });

</script>
@endsection