@extends('app')

@section('before-header')
@include('elements.submitCodeForm')
@endsection

@section('content')
    <div class="page-all-category">
        <div class="container">
            <ol class="cd-breadcrumb custom-separator" itemscope itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope
                    itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="{{url('/')}}">
                        <span itemprop="name">Home</span></a>
                    <meta itemprop="position" content="1" />
                </li>
                <li class="current" itemprop="itemListElement" itemscope
                    itemtype="http://schema.org/ListItem">
                    <em itemprop="name">All categories</em>
                    <meta itemprop="position" content="3" />
                </li>
            </ol>
        </div>
        <div class="container" >
            <div class="row page-boxer">
                <h3 class="lsi-header"><span>All CAtegories</span></h3>
                <div class="body-boxer clearfix" >
                    <div class="categories-list">
                        @foreach($categories as $c)
                            <div class="col-md-4 col-sm-6 col-sms-6 clearfix">
                        <span class="fa-stack fa-lg">
                          <i class="fa fa-square fa-stack-2x"></i>
                          <i class="{{$c['icon']}} fa-stack-1x fa-inverse"></i>
                        </span>
                                <ul>
                                    <li><h5><a href="{{ url('/category/'.$c['alias']) }}">{{$c['name']}}</a></h5></li>
                                    @foreach($c['stores'] as $s)
                                        <li><a href="{{url('/'.$s['alias'].config('config.suffix_coupon'))}}">{{$s['name']}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection