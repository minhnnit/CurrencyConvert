@extends('app')

@section('scripts')
    <script src="{{ asset('vendor/jquery/jquery-1.11.4.ui.min.js?ver=0001') }}" type="text/javascript"></script>
@endsection

@section('before-header')
    @include('elements.submitCodeForm')
@endsection

@section('content')
    <div class="list-top-voucher-items">
        <div class="container" >
            <div class="row top-voucher-lsi-items">
                <h3 class="lsi-header"><span><img src="{{asset('images/top-20-voucher.png') }}" /> &nbsp; Top VOUCHERS</span></h3>
                <div class="lsi-items" >
                    <!-- Box-top-stores -->
                    <div class="col-lg-6 col-md-8 hidden-sxs box-mdi-item">
                        <div class="box-top-stores">
                            <div class="lsi-top-stores" >
                                <h4 class="box-stores-title">TOP STORES</h4>
                                <div class="box-stores-desc">Subscribe to the Best of DiscountsVoucher.co.uk!</div>
                            </div>
                            <div class="lsi-top-stores-list">
                                <ul class="flip-3d list-logos">
                                    <li><a href="{{url('/store-detail')}}" class="btn-coupon">
                                            <figure class="hovered">
                                                <img src="{{asset('images-demo/logo-stores/store-1.png') }}" alt="" />
                                                <figcaption>
                                                    <samp class="btn-coupon-small">
                                                        <span class="exclu-stamp">Exclusive</span>
                                                        <strong>50<sup>%</sup></strong>
                                                        <span>Discount</span>
                                                    </samp>
                                                </figcaption>
                                            </figure></a>
                                    </li>
                                    <li><a href="{{url('/store-detail')}}" class="btn-deal">
                                            <figure class="hovered">
                                                <img src="{{asset('images-demo/logo-stores/store-2.png') }}" alt="" />
                                                <figcaption>
                                                    <samp class="btn-coupon-small">
                                                        <strong>10<sup>%</sup></strong>
                                                        <span>Discount</span>
                                                    </samp>
                                                </figcaption>
                                            </figure></a>
                                    </li>
                                    <li><a href="{{url('/store-detail')}}" class="btn-free">
                                            <figure class="hovered">
                                                <img src="{{asset('images-demo/logo-stores/store-3.png') }}" alt="" />
                                                <figcaption>
                                                    <samp class="btn-coupon-small">
                                                        <span class="exclu-stamp">Exclusive</span>
                                                        <strong>Free</strong>
                                                        <span>delivery</span>
                                                    </samp>
                                                </figcaption>
                                            </figure></a>
                                    </li>
                                    <li><a href="{{url('/store-detail')}}" class="btn-coupon">
                                            <figure class="hovered">
                                                <img src="{{asset('images-demo/logo-stores/store-4.png') }}" alt="" />
                                                <figcaption>
                                                    <samp class="btn-coupon-small">
                                                        <strong>55<sup>%</sup></strong>
                                                        <span>Discount</span>
                                                    </samp>
                                                </figcaption>
                                            </figure></a>
                                    </li>
                                    <li><a href="{{url('/store-detail')}}" class="btn-deal">
                                            <figure class="hovered">
                                                <img src="{{asset('images-demo/logo-stores/store-5.png') }}" alt="" />
                                                <figcaption><samp class="btn-coupon-small">
                                                        <span class="exclu-stamp">Exclusive</span>
                                                        <strong>30<sup>%</sup></strong>
                                                        <span>Discount</span>
                                                    </samp>
                                                </figcaption>
                                            </figure></a>
                                    </li>
                                    <li><a href="{{url('/store-detail')}}" class="btn-coupon">
                                            <figure class="hovered">
                                                <img src="{{asset('images-demo/logo-stores/store-1.png') }}" alt="" />
                                                <figcaption>
                                                    <samp class="btn-coupon-small">
                                                        <span class="exclu-stamp">Exclusive</span>
                                                        <strong>50<sup>%</sup></strong>
                                                        <span>Discount</span>
                                                    </samp>
                                                </figcaption>
                                            </figure></a>
                                    </li>
                                    <li><a href="{{url('/store-detail')}}" class="btn-deal">
                                            <figure class="hovered">
                                                <img src="{{asset('images-demo/logo-stores/store-2.png') }}" alt="" />
                                                <figcaption>
                                                    <samp class="btn-coupon-small">
                                                        <strong>10<sup>%</sup></strong>
                                                        <span>Discount</span>
                                                    </samp>
                                                </figcaption>
                                            </figure></a>
                                    </li>
                                    <li><a href="{{url('/store-detail')}}" class="btn-free">
                                            <figure class="hovered">
                                                <img src="{{asset('images-demo/logo-stores/store-3.png') }}" alt="" />
                                                <figcaption>
                                                    <samp class="btn-coupon-small">
                                                        <span class="exclu-stamp">Exclusive</span>
                                                        <strong>Free</strong>
                                                        <span>delivery</span>
                                                    </samp>
                                                </figcaption>
                                            </figure></a>
                                    </li>
                                    <li><a href="{{url('/store-detail')}}" class="btn-coupon">
                                            <figure class="hovered">
                                                <img src="{{asset('images-demo/logo-stores/store-4.png') }}" alt="" />
                                                <figcaption>
                                                    <samp class="btn-coupon-small">
                                                        <strong>55<sup>%</sup></strong>
                                                        <span>Discount</span>
                                                    </samp>
                                                </figcaption>
                                            </figure></a>
                                    </li>
                                    <li><a href="{{url('/store-detail')}}" class="btn-deal">
                                            <figure class="hovered">
                                                <img src="{{asset('images-demo/logo-stores/store-5.png') }}" alt="" />
                                                <figcaption>
                                                    <samp class="btn-coupon-small">
                                                        <span class="exclu-stamp">Exclusive</span>
                                                        <strong>30<sup>%</sup></strong>
                                                        <span>Discount</span>
                                                    </samp>
                                                </figcaption>
                                            </figure></a>
                                    </li>
                                    <li><a href="{{url('/store-detail')}}" class="btn-free">
                                            <figure class="hovered">
                                                <img src="{{asset('images-demo/logo-stores/store-3.png') }}" alt="" />
                                                <figcaption>
                                                    <samp class="btn-coupon-small">
                                                        <span class="exclu-stamp">Exclusive</span>
                                                        <strong>Free</strong>
                                                        <span>delivery</span>
                                                    </samp>
                                                </figcaption>
                                            </figure></a>
                                    </li>
                                    <li><a href="{{url('/store-detail')}}" class="btn-coupon">
                                            <figure class="hovered">
                                                <img src="{{asset('images-demo/logo-stores/store-4.png') }}" alt="" />
                                                <figcaption>
                                                    <samp class="btn-coupon-small">
                                                        <strong>55<sup>%</sup></strong>
                                                        <span>Discount</span>
                                                    </samp>
                                                </figcaption>
                                            </figure></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- end box-top-stores -->
                    <!-- Item 01 Demo for Coupon has code -->
                    @for($i=1; $i<=20; $i++)
                        {{-- */$rand = rand(1,1)/* --}}
                        <div class="col-lg-3 col-md-4 col-sm-6 col-sms-6 box-lsi-item">
                            @include('elements.box-lsi-store-demo' . $rand)
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
@endsection