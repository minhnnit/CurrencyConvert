<?php
$isCode=strtolower($c['type']) === 'coupon code';
$aff_url = $s['affiliate_url']?:$s['store_url'];
$linkGo = url("/coupon-detail/{$c['go']}/" . str_slug($c['title'], '-') . "/" . $s['alias']);
?><div class="col-xl-6 col-xs-6 col-lg-6 col-md-6 col-sm-6 padding-0">
    <div class="cp-item">
        <div class="brand-logo">
            <a href="{{url('/' . $s['alias'])}}" ><img src="{{$s['logo']}}" alt="{{$s['name']}}" /></a>
        </div>
        <div class="row cp-info">
            <div class="col-xl-7 col-xs-7 col-md-7 col-md-7 col-lg-7 cp-r-info">
                <div title="{{$s['name']}}" rel="nofollow" class="cp-title popup-get-code cp-title-home" data-link="{{$linkGo}}" data-affiliate="{{ $aff_url }}">
                    {{$c['title']}}
                </div>
                <div class="cp-menu">
                    @if($c['verified'])<span class="verified"><i class="check-icon"></i> Verified</span> | @endif
                    <span class="cp-link location" data-href="{{url('/' . $s['alias'])}}"><a href="">Visit Store >></a></span>
                </div>
            </div>
            <div class="col-xl-5 col-xs-5 col-md-5 col-md-5 col-lg-5 padding-0">
                <div class="cp-code-btn">
                    <div class="wrap-btn">
                        <div class="button-outer popup-get-code" data-link="{{$linkGo}}" data-affiliate="{{$aff_url}}">
                            @if($isCode)
                                <a class="btn btn-green get-code">Show Code</a>
                                <div class="peel-under">
                                    {{$c['code']}}
                                </div>
                            @else
                                <a class="btn btn-green">Get Deal</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>