<?php
if(isset($store['logo'])===false) $store = $s;
else $s = $store;
$isCode=strtolower($c['type']) === 'coupon code';
$aff_url = $s['affiliate_url']?:$s['store_url'];
$linkGo = url("/coupon-detail/{$c['go']}/" . str_slug($c['title'], '-') . "/" . $s['alias']);
?><div class="padding-0">
    <div class="cp-item">
        <div class="brand-logo">
            <img src="{{$s['logo']}}" alt="{{$s['name']}}" />
        </div>
        <div class="row cp-info">
            <div class="col-xl-7 col-xs-7 col-md-7 col-md-7 col-lg-7 cp-r-info">
                <div title="{{$s['name']}}" rel="nofollow" class="cp-title popup-get-code" data-link="{{$linkGo}}" data-affiliate="{{ $aff_url }}">
                    {{$c['title']}}
                </div>
                @if(isset($c['description']{0}))
                    <div class="content">
                    <div class="desc text" itemprop="description">
                        <p class="limit">
                            {{$c['description']}}
                        </p>
                    </div>
                    </div>
                @endif
                <div class="cp-menu">
                    @if($c['verified'])<span class="verified"><i class="check-icon"></i> Verified</span>@endif
                    @if(!empty($c['expire_date'])) | <span class="expr">Expires {{date('d M Y h:i a',strtotime($c['expire_date']))}}</span> | @endif
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