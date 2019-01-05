@extends('app')

@section('scripts')
    <script src="{{ asset('vendor/jquery/jquery-1.11.4.ui.min.js'.$common['version_app']) }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/momentjs/moment.min.js'.$common['version_app']) }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/momentjs/moment-timezone-with-data.min.js'.$common['version_app']) }}" type="text/javascript"></script>
@endsection

@section('before-header')
    @include('elements.submitCodeForm')
@endsection

@section('content')
    <div class="list-top-voucher-items">
        <div class="container" >
            <div class="row top-voucher-lsi-items">
                <h3 class="lsi-header"><span><img src="{{asset('images/top-20-voucher.png') }}" /> &nbsp; Top Free {{config('config.Shipping')}}</span></h3>
                <div class="lsi-items" >
                    <!-- Box-top-stores -->
                    <div class="col-lg-6 col-md-8 hidden-sxs box-mdi-item">
                        <div class="box-top-stores">
                            <div class="lsi-top-stores" >
                                <h4 class="box-stores-title">TOP STORES</h4>
                                <div class="box-stores-desc">Subscribe to the Best of {{config('config.domain')}}!</div>
                            </div>
                            <div class="lsi-top-stores-list">
                                <ul class="flip-3d list-logos">
                                    @foreach ($newestStores as $s)
                                        @if (strtolower($s['coupon'][0]['type']) === 'coupon code')
                                            <li><a href="{{url('/'. $s['alias'].config('config.suffix_coupon'))}}" class="btn-coupon">
                                                    <figure class="hovered">
                                                        <img src="{{$s['logo']}}" alt="{{$s['name']}}"/>
                                                        <figcaption>
                                                            <samp class="btn-coupon-small">
                                                                @if ($s['coupon'][0]['exclusive'] == 1)
                                                                    <span class="exclu-stamp">Exclusive</span>
                                                                @endif
                                                                <strong>
                                                                    {{$s['coupon'][0]['discount']}}<sup>{{$s['coupon'][0]['currency']}}</sup>
                                                                </strong>
                                                                <span>Discount</span>
                                                            </samp>
                                                        </figcaption>
                                                    </figure>
                                                </a>
                                            </li>
                                        @elseif (strtolower($s['coupon'][0]['type']) === 'great offer')
                                            <li><a href="{{url('/' . $s['alias'] . config('config.suffix_coupon'))}}" class="btn-deal">
                                                    <figure class="hovered">
                                                        <img src="{{$s['logo']}}" alt="{{$s['name']}}"/>
                                                        <figcaption>
                                                            <samp class="btn-coupon-small">
                                                                @if ($s['coupon'][0]['exclusive'] == 1)
                                                                    <span class="exclu-stamp">Exclusive</span>
                                                                @endif
                                                                @if ($s['coupon'][0]['discount'] > 0)
                                                                    <strong>
                                                                        {{$s['coupon'][0]['discount']}}<sup>{{$s['coupon'][0]['currency']}}</sup>
                                                                    </strong>
                                                                    <span>Discount</span>
                                                                @else
                                                                    <strong>Great</strong>
                                                                    <span>Offer</span>
                                                                @endif
                                                            </samp>
                                                        </figcaption>
                                                    </figure>
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{url('/' . $s['alias'] . config('config.suffix_coupon'))}}" class="btn-free">
                                                    <figure class="hovered">
                                                        <img src="{{$s['logo']}}" alt="{{$s['name']}}"/>
                                                        <figcaption>
                                                            <samp class="btn-coupon-small">
                                                                @if ($s['coupon'][0]['exclusive'] == 1)
                                                                    <span class="exclu-stamp">Exclusive</span>
                                                                @endif
                                                                @if ($s['coupon'][0]['discount'] > 0)
                                                                    <strong>
                                                                        {{$s['coupon'][0]['discount']}}<sup>{{$s['coupon'][0]['currency']}}</sup>
                                                                    </strong>
                                                                    <span>Discount</span>
                                                                @else
                                                                    <strong>Free</strong>
                                                                    <span>{{config('config.Shipping')}}</span>
                                                                @endif
                                                            </samp>
                                                        </figcaption>
                                                    </figure>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div><!-- end box-top-stores -->
                    <!-- Item 01 Demo for Coupon has code -->
                    @foreach($coupons as $c)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-sms-6 box-lsi-item">
                            @include('elements.box-store-coupon')
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts-footer')
    <script>
        $('.format-date').each(function () {
            var $that = $(this);
            if ($that.text().indexOf('Z') > -1) {
                $that.text(moment.tz($that.text(), "{{Session::get('geoip-location')['timezone']}}").format('ll LT'));
            }else
                $that.text(moment.tz($that.text()+'Z', "{{Session::get('geoip-location')['timezone']}}").format('ll LT'));
        });
    </script>
@endsection