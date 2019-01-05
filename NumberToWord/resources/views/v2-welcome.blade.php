@extends('app')

@section('content_main')
<div class="main">
    <div class="top-title">
        All Coupon Code & Discount for 30,000 Online Stores!
    </div>
    <div class="top-slide">
        <div class="top-box-items row">
        @foreach ($topCoupons as $index => $s)
            @if(!empty($s)&& $index <18)
                <?php $c = $s;?>
                @if($index < 12)
                    @include('enter-elements.coupon-home-top')
                @endif
            @endif
        @endforeach
        </div>
    </div>
</div>
    <!-- main content -->

<div class="top-title">
    Top Discount Codes
</div>
    <div class="main">
        <div class="row">
                <!-- start a item -->
                @foreach ($couponList as $index => $s)
                    @if(!empty($s))
                            <?php $c = $s;?>
                        @if($index === 3 || $index === 6)
                            <div class="col-xl-6 col-xs-6 col-lg-6 col-md-6 col-sm-6 padding-0 centered">
                                    @include('GA.ga-dpf')
                            </div>
                        @else
                            @include('enter-elements.coupon-items')
                        @endif
                    @endif
                @endforeach
                <!--end a items -->
        </div>
    </div>
    @include('enter-elements.popular-store')
@endsection

@section('scripts-footer')
@endsection


