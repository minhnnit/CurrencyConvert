@extends('app')

@section('content')
    @if(count($store['coupons']) > 0)
        @foreach($store['coupons'] as $k => $cp)
            @if($k < 6)
                <script type="application/ld+json">
                {
                    "@context": "http://schema.org",
                    "@type": "saleEvent",
                    "name": "{{ $cp['title'] }}",
                    "startDate": "{{ !empty($cp['created_at']) ? date("Y-m-d", strtotime($cp['created_at'])) : '2017-01-01' }}",
                    "endDate": "{{ date("Y-m-d", strtotime("+1 year")) }}",
                    "url": "{{ url($store['alias'] . config('config.suffix_coupon')) }}",
                    "image": "{{ !empty($cp['image']) ? $cp['image'] : ( !empty($store['social_image']) ? $store['social_image'] : $store['logo'] ) }}",
                    "location": {
                    "@type": "place",
                    "name": "{{ $store['name'] . ' ' . config('config.coupon') }}",
                    "url": "{{ $store['store_url'] }}",
                    "address": "{{ $store['name'] }}"
                    }
                    , "description": "{{ $cp['description'] }}"
                    , "offers": "{{ $cp['type'] }}"
                    , "organizer": "{{ $store['name'] }}"
                }
            </script>
            @endif
        @endforeach
    @endif

    <input type="hidden" value="{{isset($seoConfig['originTitle']) ? $seoConfig['originTitle'] : ''}}" id="originTitle">
    <input type="hidden" value="{{isset($seoConfig['originDesc']) ? $seoConfig['originDesc'] : ''}}" id="originDesc">
    <div class="container">
        <div class="row store-detail">
            <div class="row">
                <div class="col-md-3 hidden-sm hidden-xs">
                    <div class="store-information-right">
                        <div class="store-logo">
                            <div>
                                <a class="fav-without-login item-likes click-to-save{{!empty($favourites[$store['id']]) ? ' liked' : ''}}" id="{{$store['id']}}" data-toggle="tooltip" data-placement="top"
                                   title="{{!empty($favourites[$store['id']]) ? 'Favorited' : 'Add to favorites'}}"><i class="fa fa-heart"></i>
                                </a>
                                <img src="{{$store['logo']}}" alt="{{$store['name']}}">
                            </div>
                        </div>
                    </div>
                    <div class="box-selection-right">
                        <h3 class="box-header">
                            Coupon type:
                        </h3>
                        <div class="box-items">
                            <ul class="list-items">
                                <?php $cpCount=0; ?>
                                @foreach($store['couponType'] as $ct)
                                    <?php $cpCount+=(int)$ct['count']; ?>
                                    <li><label><input type="checkbox" class="filter-coupon-type" value="{{$ct['coupon_type']}}" {{in_array($ct['coupon_type'] ,Session::get('coupon_type_' . $store['alias'])) ? 'checked' : ''}} /> {{$ct['coupon_type']}} ({{$ct['count']}})</label></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @if(!empty($store['short_description']))
                        <div class="box-selection-right">
                            <h3 class="box-header">
                                About {{$store['name'] .' '. ($store['note'] === 'ngach' ? '' : $store['custom_keywords']) }}
                            </h3>
                            <div class="box-items desc-more">
                                {!!html_entity_decode($store['short_description'])!!}
                            </div>
                        </div>
                    @endif

                    <div class="box-selection-right">
                        <h3 class="box-header">
                            {{$store['name'] .' '. ($store['note'] === 'ngach' ? '' : $store['custom_keywords']) . ' Note'}}
                        </h3>
                        <div class="box-items">
                            Coupons Plus Deals has a source of coupons and deals provided by users and visitors daily. We target at building a must-visit website for consumers. Therefore, we have these coupons checked as soon as possible. However, due to the great number of coupons submitted every single day, invalid coupon codes are unavoidable. Coupons Plus Deals will continue to ensure that all coupon codes and deals are verified.
                        </div>
                    </div>

                    {{--GA--}}
                    <div class="box-selection-right ga-box">
                        @include('GA.ga-dpf')
                    </div>

                    @if(isset($store['similarStores']) && $store['similarStores'])
                        <div class="box-selection-right">
                            <h3 class="box-header">
                                Similar Stores
                            </h3>
                            <div class="box-items">
                                <ul class="list-items list-stores-box scrollbar-auto">
                                    @foreach ($store['similarStores'] as $ss)
                                        <li>
                                            <a href="{{url('/'. $ss['alias'].config('config.suffix_coupon'))}}">{{$ss['name']}}</a>
                                            @if (!empty($ss['cash_back_json']))<span>Up to {{$ss['cash_back_json']['currency'] == '%' ? $ss['cash_back_json']['value'].'%' : $ss['cash_back_json']['currency'].$ss['cash_back_json']['value']}} Cash Back</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    @if(isset($store['popularStores']) && $store['popularStores'])
                        <div class="box-selection-right">
                            <h3 class="box-header">
                                Popular Stores
                            </h3>
                            <div class="box-items">
                                <ul class="list-items list-stores-box scrollbar-auto">
                                    @foreach ($store['popularStores'] as $ss)
                                        <li>
                                            <a href="{{url('/'. $ss['alias'].config('config.suffix_coupon'))}}">{{$ss['name']}}</a>
                                            @if (!empty($ss['cash_back_json']))<span>Up to {{$ss['cash_back_json']['currency'] == '%' ? $ss['cash_back_json']['value'].'%' : $ss['cash_back_json']['currency'].$ss['cash_back_json']['value']}} Cash Back</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <div class="box-selection-right">
                        <h3 class="box-header">
                            <a name="area-submit-cp"></a>
                            Submit a new coupon and help others save!
                        </h3>
                        <div class="box-items"><form class="form" id="submit-box-form" action="{{url('/coupon/submitCoupon')}}" method="post">
                                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                <input type="hidden" name="storeId" value="{{$store['id']}}" />
                                <div class="form-group">
                                    <input type="text" name="storeName" class="form-control" value="{{$store['name']}}" disabled />
                                </div>
                                <div class="form-group">
                                    <input type="text" name="title" class="form-control submit-box-title required" placeholder="Enter title *"/>
                                </div>
                                <div class="form-group">
                                    <select name="couponType" id="couponType" class="form-control required" autocomplete="off">
                                        <option value="Coupon Code" selected="selected">{{config('config.Coupon')}} Code</option>
                                        <option value="Free Shipping">Free {{config('config.Shipping')}}</option>
                                        <option value="Great Offer">Great Offer</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control required coupon-code" name="couponCode"
                                           placeholder="Enter your code *"/>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control required" rows="8" name="description"
                                              placeholder="% discount, date of expiry, ongoing events...."></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control datepicker" name="expireDate"
                                           placeholder="Expire Date"/>
                                </div>
                                <div class="form-group">
                                    <div id="reCaptchaSubmit" class="g-recaptcha" style="overflow: hidden"></div>
                                    {{--@if (Session::has('user.id'))--}}
                                    <button type="submit" id="btn-submit-box" class="btn btn-block btn-submit">
                                        Submit {{config('config.coupon')}} code
                                    </button>
                                    {{--@else--}}
                                <!-- <a href="{{url('/login')}}">Please login before submit {{config('config.coupon')}}.</a> -->
                                    {{--@endif--}}
                                </div>
                            </form></div>
                    </div>
                    @if(!empty($store['recentReviews']))
                        <div class="box-selection-right">
                            <h3 class="box-header">
                                Recent Reviews
                            </h3>
                            <div class="box-items">
                                <div class="scrollbar-auto box-recent-review">
                                    @foreach($store['recentReviews'] as $ct)
                                        <div class="recent-review-item">
                                            <div class="review-comment">{{$ct['content']}}</div>
                                            <div class="review-info">By <span>{{$ct['fullname']}}</span> on {{date('d M Y',strtotime($ct['created_at']))}}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(!empty($store['category']))
                        <div class="box-selection-right no-border">
                            <div class="box-items">
                                <ul class="sub-break-crumb">
                                    <li><a href="{{url('/')}}">Home</a></li>
                                    <li><a href="{{url('/category/'.$store['category']['alias'])}}">{{$store['category']['name']}}</a></li>
                                    <li><em>{{$store['name'] .' '. ($store['note'] === 'ngach' ? '' : $store['custom_keywords']) }}</em></li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="table">
                        <div class="store-header row">
                            <div class="col-sm-3 hidden-md hidden-lg store-header-logo">
                                <div>
                                    <a class="fav-without-login item-likes click-to-save{{!empty($favourites[$store['id']]) ? ' liked' : ''}}" id="{{$store['id']}}" data-toggle="tooltip" data-placement="top"
                                       title="{{!empty($favourites[$store['id']]) ? 'Favorited' : 'Add to favorites'}}"><i class="fa fa-heart"></i>
                                    </a>
                                    <img src="{{$store['logo']}}" alt="{{$store['name']}}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-store-header">
                                <div class="coupon-item-box ga-box" style="margin-top: 0;background: none;border: none;">
                                    @include('GA.ga-dpf')
                                </div>
                            </div>
                            <div class="col-sm-9 col-store-header">
                                <h1><strong>{{$store['name']}}</strong> {{ $store['note'] === 'ngach' ? '' : $store['custom_keywords'] }}</h1>
                                <ul class="store-header-line store-header-line-dot">
                                    {{--<li>{{number_format($store['coupon_count'])}} Coupons </li>--}}
                                    <li>{{ $cpCount }} Coupons </li>
                                    @if($store['countCouponVerified'] > 0)
                                        <li>{{$store['countCouponVerified']}} Verified Coupons</li>
                                    @endif
                                    @if($store['todayCoupon'] > 0)
                                        <li>{{$store['todayCoupon']}} Added Today</li>
                                    @endif
                                </ul>
                                <ul class="store-header-line discount-type hidden-md hidden-lg">
                                    @foreach($store['couponType'] as $ct)
                                        <li><label><input type="checkbox" class="filter-coupon-type" value="{{$ct['coupon_type']}}" {{in_array($ct['coupon_type'],Session::get('coupon_type_' . $store['alias'])) ? 'checked' : ''}} /> {{$ct['coupon_type']}} ({{$ct['count']}})</label></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @if(!empty($store['head_description']))
                            <div class="box-store-desciprion">
                                {{--<h2 class="box-title">About {{ $store['name'] }}</h2>--}}
                                <div class="box-desc">{!! $store['head_description'] !!}</div>
                            </div>
                        @endif
                    </div>
                    <div id="store-detail-list-coupon">
                        <!-- Cash back information box has many case  -->
                        @if(sizeof($store['cash_back_json'])>1)
                            <div class="box-cash-back" id="box-cash-back-store">
                                <div class="box-cash-back-header">
                                    <h3>Up to {{!empty($store['cash_back_json'][0]['cash_back_percent']) ? $store['cash_back_json'][0]['cash_back_percent'].'%' : $store['cash_back_json'][0]['currency'].$store['cash_back_json'][0]['cash_back']}} Cash Back</h3>
                                    <span>(<a role="button" data-toggle="collapse" data-parent="#box-cash-back-store" href="#cash-back-term" aria-expanded="false"
                                              aria-controls="cash-back-term">Cash Back terms</a>)</span>
                                    <span class="shop-now-box">
                                    @if(Auth::guest())
                                            <a role="button" data-toggle="modal" data-target="#shop-now" class="btn-shop-now pull-right">Shop now <i class="fa fa-sort-desc fa-rotate-270"></i></a>
                                        @else
                                            <a href="{{url('/go/'.$store['go'])}}" target="_blank" class="btn-shop-now pull-right">Shop now <i class="fa fa-sort-desc fa-rotate-270"></i></a>
                                        @endif
                                </span>
                                </div>
                                <div class="panel-collapse collapse cash-back-info" id="cash-back-term">
                                    {!!html_entity_decode($store['cash_back_term'])!!}
                                </div>
                                <div class="box-cash-back-content">
                                    <div class="col-sm-5 box-column">
                                        <div id="limited-visibility" class="limited-visibility">
                                            <div class="table-cash-back">
                                                @foreach($store['cash_back_json'] as $cbj)
                                                    <div class="cash-back-row">
                                                        <div class="column-title ellipsis1">{{$cbj['description']}}</div>
                                                        <div class="column-value ellipsis1">{{!empty($cbj['cash_back_percent']) ? $cbj['cash_back_percent'].'%' : $cbj['currency'].$cbj['cash_back']}}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @if(sizeof($store['cash_back_json'])>3)
                                            <div id="cash-back-show-more" class="table-cash-back CB-show">
                                                <div class="CB-show-more cash-back-row">
                                                    <div class="column-title ellipsis1">Show more...</div>
                                                    <div class="column-value ellipsis1"><i class="fa fa-caret-down"></i></div>
                                                </div>
                                                <div class="CB-show-less cash-back-row">
                                                    <div class="column-title ellipsis1">Show less...</div>
                                                    <div class="column-value ellipsis1"><i class="fa fa-caret-up"></i></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-sm-7 box-column has-many-cash-back">
                                        <div class="box-cash-about">
                                            <div class="about-date">
                                                <div class="date-estimated-title">{{date('d F Y', strtotime("+30 days"))}}</div>
                                                <div class="date-estimated-desc">Estimated Payment Date<br />(if purchased today)
                                                    <a style="display: none" tabindex="0" class="btn-estimated" data-placement="top" role="button" data-toggle="popover" data-trigger="focus"
                                                       data-content="And here's some amazing content. It's very engaging. Right?">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="about-amount">
                                                <div class="date-estimated-title">${{number_format(time()/10%100000 + ($store['cash_back_total'] ? $store['cash_back_total'] : 0))}}</div>
                                                <div class="date-estimated-desc">Total Cash Back<br />earned to date</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif (sizeof($store['cash_back_json'])==1)
                        <!-- OR -->
                            <!-- Cash back information box has one case  -->
                            <div class="box-cash-back" id="box-cash-back-store">
                                <div class="box-cash-back-header">
                                    <h3>{{!empty($store['cash_back_json'][0]['cash_back_percent']) ? $store['cash_back_json'][0]['cash_back_percent'].'%' : $store['cash_back_json'][0]['currency'].$store['cash_back_json'][0]['cash_back']}} Cash Back</h3>
                                    <span>(<a role="button" data-toggle="collapse" data-parent="#box-cash-back-store" href="#cash-back-term-01" aria-expanded="false"
                                              aria-controls="cash-back-term">Cash Back terms</a>)</span>
                                    <span class="shop-now-box">
                                    @if(Auth::guest())
                                            <a role="button" data-toggle="modal" data-target="#shop-now" class="btn-shop-now pull-right">Get Cash Back <i class="fa fa-sort-desc fa-rotate-270"></i></a>
                                        @else
                                            <a href="{{url('/go/'.$store['go'])}}" target="_blank" class="btn-shop-now pull-right">Get Cash Back <i class="fa fa-sort-desc fa-rotate-270"></i></a>
                                        @endif
                                </span>
                                </div>
                                <div class="panel-collapse collapse cash-back-info" id="cash-back-term-01">
                                    {!!html_entity_decode($store['cash_back_term'])!!}
                                </div>
                                <div class="box-cash-back-content">
                                    <div class="box-column">
                                        <div class="box-cash-about">
                                            <div class="about-date">
                                                <div class="date-estimated-title">{{date('d F Y', strtotime("+30 days"))}}</div>
                                                <div class="date-estimated-desc">Estimated Payment Date<br />(if purchased today)
                                                    <a tabindex="0" class="btn-estimated" data-placement="top" role="button" data-toggle="popover" data-trigger="focus"
                                                       data-content="And here's some amazing content. It's very engaging. Right?">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="about-amount">
                                                <div class="date-estimated-title">${{number_format(time()/10%100000 + ($store['cash_back_total'] ? $store['cash_back_total'] : 0))}}</div>
                                                <div class="date-estimated-desc">Total Cash Back<br />earned to date</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(sizeof($store['cash_back_json']) && (isset($disable) && $disable == false))
                        <!-- Box quick sign up for subscribe store  -->
                            @include('elements.v2-subscribe-store-box')
                        @endif
                    <!-- Normal coupons -->
                        @if(sizeof($store['coupons']) === 0)
                            {{--<p>--}}
                            {{--We are updating  <strong>{{ $store['name'] }}</strong> {{config('config.coupon')}} at the moment. Since you are here with us, we do not want you to leave with nothing.--}}
                            {{--<a style="font-size: 24px" id="requestCoupon" data-toggle="modal" data-target="#modalRequestCoupon">Click here</a> to request a coupon and we will strive to update within 5 minutes.--}}
                            {{--</p>--}}
                            <div class="coupon-item-box col-xs-12 box-request-coupon">
                                <div class="col-xs-4 b-img">
                                    <img src="{{ asset('/images/sorry.png') }}">
                                </div>
                                <div class="col-xs-8 b-text">
                                    <div class="b-text-child">
                                        <p>There are no coupons or deals available for {{ $store['name'] }}. Please help!</p>
                                        <div style="text-align: center">
                                            <div class="_btn"><a class="__btn" href="#area-submit-cp">Submit coupon</a></div>
                                            <div class="_btn"><a class="__btn" id="requestCoupon" data-toggle="modal" data-target="#modalRequestCoupon">Request coupon</a></div>
                                            <div class="_btn"><a class="__btn" href="https://www.amazon.com/?&_encoding=UTF8&tag=668239901102-20">Find with Amazon</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{--CP STICKY TOP--}}
                            @if(count($arrStickyCp)>0)
                                <div class="suggested-list">
                                    <h2>TOP COUPONS</h2>
                                </div>
                            @endif
                            {{--verified--}}
                            @foreach($arrVerified as $k=>$c)
                                <?php $style="border:2px solid #0FD4B1;border-radius:4px" ?>
                                @include('elements.v2-box-coupon')
                                @if($k == 1)
                                    {{--GA--}}
                                    <div class="coupon-item-box ga-box" style="margin-top: 0;background: none;border: none;">
                                        @include('GA.ga-dpf')
                                    </div>
                                @endif
                            @endforeach
                            {{--top/hot--}}
                            @foreach($arrStickyCp as $k=>$c)
                                <?php $style="border:2px solid #0FD4B1;border-radius:4px" ?>
                                @include('elements.v2-box-coupon')
                                @if($k == 1)
                                    {{--GA--}}
                                    <div class="coupon-item-box ga-box" style="margin-top: 0;background: none;border: none;">
                                        @include('GA.ga-dpf')
                                    </div>
                                @endif
                            @endforeach
                            <?php $style="" ?>

                            {{--CP NORMAL--}}
                            @if(count($arrCouponsNormal)>0)
                                <div class="suggested-list">
                                    <h2>OTHER COUPONS</h2>
                                </div>
                            @endif
                            @foreach($arrCouponsNormal as $c)
                                <?php $style="border-radius:4px" ?>
                                @include('elements.v2-box-coupon')
                            @endforeach

                            @if(count($arrCouponsRemote)>0)
                                <div class="suggested-list">
                                    <h2>GIVE THEM A CHANCE</h2>
                                </div>
                            @endif
                            @foreach($arrCouponsRemote as $index=>$c)
                                @include('elements.v2-box-coupon')
                            @endforeach
                            {{--Display show more--}}
                            @if (sizeof($store['coupons']) >= 20)
                                <a href="" class="load-more show-more-coupons"><i class="fa fa-arrow-circle-o-down"></i> Load More Coupons</a>
                                <!-- a href="javascript:;" class="load-more ajax-loading"><i class="fa fa-spinner fa-pulse"></i> Load More Coupons</a -->
                            @endif
                        @endif
                    </div>
                    {{--Related stores--}}
                    @if (sizeof($store['relateStores']))
                        <div class="suggested-list">
                            <h2>PEOPLE WHO GOT {{strtoupper($store['name'])}} {{ $store['note'] === 'ngach' ? '' :  config('config.COUPON') . 'S' }} ALSO GOT</h2>
                        </div>
                        <div id="suggested-list-coupon">
                            <!-- Coupon 1st -->
                            @foreach($store['relateStores'] as $c)
                                @include('elements.v2-box-store-coupon')
                            @endforeach
                        </div>
                    @endif
                    {{--GA--}}
                    <div class="coupon-item-box ga-box" style="margin-top: 0;background: none;border: none;">
                        @include('GA.ga-dpf')
                    </div>

                    {{--Expire coupons--}}
                    @if(sizeof($store['expiredCoupons']))
                        <div class="hidden-xs">
                            <div class="suggested-list">
                                <h2>EXPIRED {{config('config.COUPON')}}S</h2>
                            </div>
                            <div class="row">
                                @foreach($store['expiredCoupons'] as $c)
                                    @include('elements.v2-box-expired-coupon')
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{--Box store description + how to use--}}
                    @if( $store['description'] && is_array(json_decode($store['description'])))
                        <div class="box-store-desciprion">
                            @foreach(json_decode($store['description']) as $d)
                                <h2 class="box-title">{!!html_entity_decode($d->title)!!}</h2>
                                <div class="box-desc">{!!html_entity_decode($d->description)!!}</div>
                            @endforeach
                        </div>
                    @else
                        <div class="box-store-desciprion">
                            <h2 class="box-title">About {{ $store['name'] }}</h2>
                            <div class="box-desc">{!! $store['description'] !!}</div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="modalRequestCoupon" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Message</h4>
                </div>
                <div class="modal-body">
                    <p>Thank you! Please reload this page after 5 minutes</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-footer')
    <script type="text/javascript">
        var widgetSubmitCoupon;
        var CaptchaCallback = function () {
            widgetSubmitCoupon = grecaptcha.render('reCaptchaSubmit', {'sitekey': '{{ $reCapcha_public_key }}'});
        };
        $(document).ready(function ($) {
            $('#cash-back-show-more').on('click', function(){
                var $that = this;
                var $obj = $('#limited-visibility');
                $($that).addClass('CB-showing');
                $($obj).addClass('unlimited');
                $($obj).addClass('scrollbar-auto').perfectScrollbar({useBothWheelAxes : true, useSelectionScroll : true});
            });

            /*
             * CuongPH
             * Switch frame login <> sign up
             * */
            $(".btn-store-sign-in, .btn-coupon-sign-in").on('click', function(){
                $(this).parents('.modal-frame-box').css('left', '-100%');
            });
            $(".btn-store-sign-up, .btn-coupon-sign-up").on('click', function(){
                $(this).parents('.modal-frame-box').css('left', '0');
            });
            var $validated = hasFormValidation();
            var $formSubscribe = $('.subscribe-store-form');
            $formSubscribe.on('submit', function (e) {
                var $that = $(this);
                e.preventDefault();
                if (!$validated ) {
                    $validated = validateEmailElement($that);
                }
                if($validated){
                    $that.find("button[type='submit']").empty().append("<i class='fa fa-spinner fa-pulse'></i>").addClass('disabled');
                    $.ajax({
                        type: 'post',
                        url: $that.attr('action'),
                        data: $that.serialize()
                    }).done(function (data) {
                        if (data.status) {
                            $that[0].reset();
                            $that.find("button[type='submit']").empty().text("Successful!");
                            $("#form-subscribe-store").addClass('hidden');
                            $("div.registered-subscriber").removeClass('hidden');
                        } else if (data.status == 'error') {
                        }
                        setTimeout(function () {
                            $that.find("button[type='submit']").empty().text("Sign Up").removeClass('disabled');
                        }, 2000);
                    });
                }
            });

            /**
             * Old JS for Submit coupon form
             * ****/

            var $form = $('#submit-box-form');
            var addCouponValidator = $form.validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 10,
                        maxlength: 200
                    },
                    description: {
                        minlength: 25,
                        maxlength: 500
                    },
                    couponCode: {
                        minlength: 2,
                        maxlength: 15
                    }
                },
                messages: {
                    title: {
                        required: 'Please enter the offer title.',
                        minlength: 'Please give more details for the title'
                    },
                    description: {
                        required: 'Please enter the offer details.',
                        minlength: 'Please add a little more detail about the offer.'
                    },
                    couponCode: {
                        minlength: 'That code looks a bit short. Please double check and try again.',
                        maxlength: 'That code looks a bit long. Please double check and try again.'
                    }
                },
                errorElement: "span", // contain the error msg in a small tag
                errorClass: 'help-block myErrorClass',
                focusInvalid: false,
                invalidHandler: function (form, validator) {
                    if (!validator.numberOfInvalids())
                        return;
                    $('html, body').animate({
                        scrollTop: $('#submit-box-form').offset().top - 100//$(validator.errorList[0].element).offset().top
                    }, 1000);

                },
                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.attr("type") == "radio" || element.attr("type") == "checkbox" || element.attr("type") == "file") { // for chosen elements, need to insert the error after the chosen container
                        error.insertAfter($(element).closest('.form-group').children('div').children().last());
                    } else if (element.hasClass("ckeditor")) {
                        error.appendTo($(element).closest('.form-group'));
                    } else if (element.parent().hasClass("input-group")) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                        // for other inputs, just perform default behavior
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    var elem = $(element);
                    if (elem.hasClass("select2-offscreen")) {
                        $("#s2id_" + elem.attr("id") + " ul").addClass(errorClass);
                    } else {
                        $(element).closest('.help-block').removeClass('valid');
                        // display OK icon
                        $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                        // add the Bootstrap error class to the control group
                    }
                },
                unhighlight: function (element, errorClass, validClass) {
                    // revert the change done by hightlight
                    var elem = $(element);
                    if (elem.hasClass("select2-offscreen")) {
                        $("#s2id_" + elem.attr("id") + " ul").removeClass(errorClass);
                    } else {
                        $(element).closest('.form-group').removeClass('has-error');
                        // set error class to the control group
                    }
                },
                success: function (label, element) {
                    label.addClass('help-block valid');
                    // mark the current input as valid and display OK icon
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                }
            });

            $form.on('submit', function (e) {
                e.preventDefault();
                if ($form.valid()) {
                    $form.find('button[type="submit"]').empty().append("<i class='fa fa-spinner fa-pulse'></i>").addClass('disabled');
                    $.ajax({
                        type: 'post',
                        url: $form.attr('action'),
                        data: $form.serialize(),
                        success: function (data) {
                            if (data.status == 'success') {
                                /*
                                 Author:HaiHT
                                 If submited success then add submited coupon id to local storage
                                 */
                                if(data.msg['id']){
                                    saveSubmitedCouponsToLocalStorage(data.msg['id']);
                                }
                                addCouponValidator.resetForm();
                                $form[0].reset();
                                $('.coupon-code').attr('placeholder', 'Enter your code *').rules('add', {
                                    required: true
                                });
                                $(".select-store").select2('data', null);
                                $form.find('button[type="submit"]').empty().text("SUBMITTED SUCCESSFULLY");
                                $form.find('button[type="submit"]').prev('span').remove();
                            } else if (data.status == 'error') {
                                $("<span class='help-block myErrorClass'>" + data.msg + "</span>").insertBefore($('#btn-submit-box'));
                            }
                            setTimeout(function () {
                                $form.find('button[type="submit"]').empty().text("SUBMIT {{config('config.coupon')}} CODE").removeClass('disabled');
                            },3000);
                            grecaptcha.reset(widgetSubmitCoupon);
                        }
                    });
                } else grecaptcha.reset(widgetSubmitCoupon)
            });

            $('#couponType').on('change', function () {
                var cur = $(this).val();
                if (cur == 'Coupon Code') {
                    $('.coupon-code').attr('placeholder', 'Enter your code *').rules('add', {
                        required: true
                    });
                } else if (cur == 'Free Shipping') {
                    $('.coupon-code').attr('placeholder', 'Enter your code').removeClass('required').rules('remove', 'required');
                } else if (cur == 'Great Offer') {
                    $('.coupon-code').attr('placeholder', 'Enter your code').removeClass('required').rules('remove', 'required');
                }
            });
            /*
             Author:HaiHT
             */
            function saveSubmitedCouponsToLocalStorage(couponID){
                var localObj = {}; localObj.submitCoupons = [];
                // If exist submitCoupons ids in LS then push to localObj submitCoupons
                if(localStorage['submitCoupons']){
                    localObj.submitCoupons = (localStorage.submitCoupons).split(',');
                }
                // console.log('before submited coupon:', localObj.submitCoupons);
                // Check if browser support Web storage
                if(typeof(Storage) !== "undefined") {
                    localObj.submitCoupons.push(couponID);
                    localStorage['submitCoupons'] = localObj.submitCoupons;
                    // console.log('after submited coupon:',localStorage['submitCoupons']);
                } else {
                    console.log('No Web Storage support');
                }
            }

            $('.filter-coupon-type').on('click', function () {
                var $that = $(this);
                $.ajax({
                    type: 'get',
                    url: "{{url('/session/filterCoupon')}}",
                    data: {
                        alias : '{{$store['alias']}}',
                        coupon_type : $that.val(),
                        checked: $that.is(':checked')
                    }
                }).done(function (data) {
                    location.reload();
                });
            });

            $('.show-more-coupons').on('click', function (e) {
                e.preventDefault();
                var $that = $(this);
                $that.find('i.fa').addClass('fa-spinner fa-pulse').removeClass('fa-arrow-circle-o-down');
                $.ajax({
                    type: 'get',
                    url: '{{url('/store/showMoreCoupons')}}',
                    data: {storeId : '{{$store['id']}}'}
                }).done(function (data) {
                    if (data.status == 'error') {
                        $that.remove();
                    } else {
                        $(data).insertBefore($that);
//                        initGlobal();
                        initGetCode();
                        truncateSomething();
                        $that.find('i.fa').removeClass('fa-spinner fa-pulse').addClass('fa-arrow-circle-o-down');
                    }
                });
            });

            /* Function request update coupon */
            $('#requestCoupon').click(function () {
                console.log('send request');
                $.ajax({
                    type: 'get',
                    url: '{{ url('/request-coupon') }}',
                    data: {
                        storeId : '{{$store['id']}}',
                        storeName : '{{$store['name']}}',
                        detail: window.location.href
                    }
                }).done(function (response) {
                    console.log(response);
                });
            });
        });
    </script>
    @include('elements.auto-update-coupon')
@endsection