<?php
if(isset($store['logo'])===false) $store = $s;
$isCode=strtolower($c['type']) === 'coupon code';
$aff_url = $s['affiliate_url']?:$s['store_url'];
$linkGo = url("/coupon-detail/{$c['go']}/" . str_slug($c['title'], '-') . "/" . $s['alias']);

?><div class="coupon-item c-r-item" itemscope="" itemprop="makesoffer" itemtype="http://schema.org/Offer">
    <div class="wrap <?php $isSale=strtolower($c['type']) === 'coupon code';?>{{$isSale?'':'sale'}}">
        <div class="count">
            <div class="off">
                <div class="off-info">
                    <img src="{{$store['logo']}}" width="105px">
                </div>
            </div>
        </div>
        <div class="info">
            <a title="{{$store['name']}}" rel="nofollow" itemprop="name" class="title get-deal-btn popup-get-code" data-link="{{ $linkGo }}" data-affiliate="{{$store['affiliate_url']}}">{{$c['title']}}</a>
            <div class="content">
                @if(isset($c['description']))
                    <div class="text more" itemprop="description">
                        {{$c['description']}}
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
            </div>
        </div>
        <div class="operate valign-wrapper">
            <span class="item-middle">
            @if($isSale)
                    <a class="btn h-btn get-deal-btn popup-get-code" data-link="{{ $linkGo }}" data-affiliate="{{$store['affiliate_url']}}"><p>DISCOVER</p><span>Show Code</span></a>
                @else
                    <a class="btn t-btn get-deal-btn popup-get-code" data-link="{{ $linkGo }}" data-affiliate="{{$store['affiliate_url']}}"><span class="get-deal">Get the Deal</span></a>
                @endif
            </span>
        </div>
    </div>
</div>