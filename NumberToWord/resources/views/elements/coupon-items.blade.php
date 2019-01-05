<?php

$isCode=strtolower($c['type']) === 'coupon code';
$aff_url = $s['affiliate_url']?:$s['store_url'];
$linkGo = url("/coupon-detail/{$c['go']}/" . str_slug($c['title'], '-') . "/" . $s['alias']);

?><div class="coupon-item c-r-item" itemscope="" itemprop="makesoffer" itemtype="http://schema.org/Offer">
    <div class="wrap {{$isCode?'':'sale'}}">
        <div class="count">
            <div class="off">
                <div class="off-info">
                    <img src="{{$s['logo']}}" width="105px">
                </div>
            </div>
        </div>
        <div class="info">
            <b>{{$s['name']}}</b><br/>
            <a title="{{$s['name']}}" rel="nofollow" itemprop="name" class="title get-deal-btn popup-get-code" data-link="{{$linkGo}}" data-affiliate="{{ $aff_url }}">{{$c['title']}}</a>
            <div class="content">
                @if(isset($storeLink)!==false&&isset($c['description']{0}))
                    <div class="text" itemprop="description">
                        <p class="limit">
                            {{$c['description']}}
                        </p>
                    </div>
                @endif
                @if($c['verified'])
                    <div class="verify-tag">
                        <i class="check-icon"></i>
                        Verified <span>• {{rand(1000,10000)}} used this deal</span>
                        @if(!empty($c['exclusive']))
                            <i class="fa fa-chevron-circle-down"></i>
                            <span class="verified">Exclusive </span>
                        @endif
                    </div>
                @endif
                    @if(isset($storeLink)===false)
                    <div class="extra">
                        <div class="time-tip" itemprop="validThrough">
                            <a class="get-deal-btn popup-get-code" data-link="{{$linkGo}}" data-affiliate="{{$aff_url}}">See all Coupons in Stores >></a>
                        </div>
                    </div>
                    @endif
            </div>
            {{--<div class="extra">
                <div class="time-tip" itemprop="validThrough">
                    <span class="stat-line">Expires {{date('d M Y h:i a',strtotime($c['expire_date']))}}</span>
                </div>
            </div>--}}
        </div>
        <div class="operate valign-wrapper">
            <span class="item-middle">
            @if($isCode)
                    <a class="btn h-btn get-deal-btn popup-get-code" data-link="{{$linkGo}}" data-affiliate="{{$aff_url}}"><p>DISCOVER</p><span>Show Code</span></a>
                @else
                    <a class="btn t-btn get-deal-btn popup-get-code" data-link="{{$linkGo}}" data-affiliate="{{$aff_url}}"><span class="get-deal">Get the Deal</span></a>
                @endif
            </span>
        </div>
    </div>
</div>