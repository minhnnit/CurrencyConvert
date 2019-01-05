@extends('app')

@section('scripts')
    <script src="{{ asset('vendor/jquery/jquery-1.11.4.ui.min.js?ver=0001') }}" type="text/javascript"></script>
@endsection

@section('before-header')
    @include('elements.submitCodeForm')
@endsection

@section('content')
    <div class="ads-pager">
        <div class="ads-header" style="background-image:url({{asset('images-demo/bg-ads.jpg')}})">
            <div class="container">
                <div class="ads-logo"><img src="{{asset('images-demo/logo-stores/store-2.png')}}" /></div>
                <div class="ads-headline">Get the Best Six Flags Coupons</div>
                <div class="ads-desc">& our Best of RetailMeNot Email Newsletter. <a href="#">Privacy Policy</a></div>
                <div class="ads-form-search">
                    <form class="form">
                        <div class="input-group">
                            <input class="form-control input-search" placeholder="Your email address" />
                            <div class="input-group-btn"><button class="btn btn-search">Subcribe</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="ads-navbar">
            <div class="container">
                <div class="row">
                    <ul class="nav ads-navbar-control" role="tablist">
                        <li role="presentation" class="active"><a href="#tab-all" role="tab" data-toggle="tab">All (12)</a></li>
                        <li role="presentation"><a href="#tab-promo" role="tab" data-toggle="tab">Promo Code (8)</a></li>
                        <li role="presentation"><a href="#tab-sales" role="tab" data-toggle="tab">Sales (2)</a></li>
                        <li role="presentation"><a href="#tab-printables" role="tab" data-toggle="tab">Printables (2)</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="tab-content clearfix">
                    <div role="tabpanel" class="tab-pane active" id="tab-all">
                        <!-- Start import items -->
                        @for($i=1; $i<=12; $i++)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-sms-6 box-lsi-item">
                                @if($i % 4 == 0)
                                    @include('elements.box-lis-detail-demo1')
                                @elseif($i % 3 == 0)
                                    @include('elements.box-lis-detail-demo3')
                                @elseif($i % 2 == 0)
                                    @include('elements.box-lis-detail-demo2')
                                @else
                                    @include('elements.box-lis-detail-demo1')
                                @endif
                            </div>
                        @endfor
                        <!-- end import items -->
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab-promo">
                        <!-- Start import items -->
                        @for($i=1; $i<=4; $i++)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-sms-6 box-lsi-item">
                                @if($i % 4 == 0)
                                    @include('elements.box-lis-detail-demo1')
                                @elseif($i % 3 == 0)
                                    @include('elements.box-lis-detail-demo3')
                                @elseif($i % 2 == 0)
                                    @include('elements.box-lis-detail-demo2')
                                @else
                                    @include('elements.box-lis-detail-demo1')
                                @endif
                            </div>
                        @endfor
                        <!-- end import items -->
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab-sales">
                        <!-- Start import items -->
                        @for($i=1; $i<=2; $i++)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-sms-6 box-lsi-item">
                                @if($i % 4 == 0)
                                    @include('elements.box-lis-detail-demo1')
                                @elseif($i % 3 == 0)
                                    @include('elements.box-lis-detail-demo3')
                                @elseif($i % 2 == 0)
                                    @include('elements.box-lis-detail-demo2')
                                @else
                                    @include('elements.box-lis-detail-demo1')
                                @endif
                            </div>
                        @endfor
                        <!-- end import items -->
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab-printables">
                        <!-- Start import items -->
                        @for($i=3; $i<=4; $i++)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-sms-6 box-lsi-item">
                                @if($i % 4 == 0)
                                    @include('elements.box-lis-detail-demo1')
                                @elseif($i % 3 == 0)
                                    @include('elements.box-lis-detail-demo3')
                                @elseif($i % 2 == 0)
                                    @include('elements.box-lis-detail-demo2')
                                @else
                                    @include('elements.box-lis-detail-demo1')
                                @endif
                            </div>
                        @endfor
                        <!-- end import items -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection