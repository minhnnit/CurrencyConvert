<div class="c-ccontent-top"><?php $storeAff = isset($store['affiliate_url']{1})?$store['affiliate_url']:$store['store_url'];?>
    <div class="m-c-w p-top">
        <div class="c-t-logo">
            <a class="loc-open" href="{{url('/go/'.$store['alias'])}}" data-href="{{$storeAff}}" rel="nofollow" title="{{$store['name']}}">

                <div class="wrap">
                    <div class="img-wrap">
                        <img class="brand-poster-img" itemprop="image" src="{{$store['logo']}}" alt="{{$store['name']}}" title="{{$store['name']}}">
                    </div>
                </div>

            </a>
        </div>
        <div class="c-t-center">
            <h4>{{$store['name']}}</h4>
            <div class="store-rating" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
                <div class="o-line">
                    <div class="rating-stars">
                        <div class="star active" data-value="1" title="Poor"></div>
                        <div class="star active" data-value="2" title="Fair"></div>
                        <div class="star active" data-value="3" title="Good"></div>
                        <div class="star active" data-value="4" title="Very Good"></div>
                        <div class="star active" data-value="5" title="Excellent"></div>
                    </div>
                    <span>Rate it!</span>
                </div>
                <div class="r-line">
                    <div>
                    <span class="rating-record"><span class="rating-score" itemprop="ratingValue">5.0</span> / <span class="rating-count" itemprop="reviewCount">{{rand(1000,30000)}}</span> Voted</span>
                    <meta itemprop="worstRating" content="0">
                    <meta itemprop="bestRating" content="5">
                    <span class="rating-result">
                    </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="c-t-right">
            <ul>
                <li class="li-img"><i class="check-o-icon"></i></li>
                <li> verified coupons</li>
                <li class="li-margin"></li>
                <li>{{rand(10000,20000)}} used today</li>
            </ul>
            <a class="btn btn-o" rel="nofollow" target="_blank" onclick="window.open('{{$storeAff}}','_blank')">Visit Website</a>
        </div>
    </div>
    {{--@if(isset($store['head_description']{10}))--}}
        {{--<div class="main store-description m-c-w">--}}
        {{--<p class="more">--}}
        {{--{!!html_entity_decode($store['head_description'])!!}--}}
        {{--</p>--}}
        {{--</div>--}}
    {{--@endif--}}
<?php /*        @if(isset($store['short_description']{10}))
            <?php $short_desc = json_decode($store['short_description']);?>
            @if(empty($short_desc))
                    <div class="main store-description m-c-w">
                        <p class="more">
                        {!!html_entity_decode($store['short_description'])!!}
                        </p>
                    </div>
            @else
                    @foreach($short_desc as $val)
                        @if(isset($val->title)&&!empty($val->title)&&isset($val->description)&&!empty($val->description))
                    <div class="main store-description m-c-w">
                        <h3>{{$val->title}}</h3>
                        <p class="more">
                            {!!  html_entity_decode($val->description) !!}
                        </p>
                    </div>
                        @endif
                    @endforeach
            @endif
        @endif */ ?>
</div>
<div class="m-c-w top-adsense">@include('GA.ga-dpf')</div>