@extends('app')

@section('before-header')
    @include('elements.submitCodeForm')
@endsection

@section('content')
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
                <em itemprop="name">Daily deals</em>
                <meta itemprop="position" content="3" />
            </li>
        </ol>
    </div>
    <div class="deal-page-header">
        <div class="container">
            <div class="row" >
                <h1 class="header-deal-page">DAILY DEALS</h1>
                <div class="jump-crumb hidden-xs">
                    <ul class="header-line-crumb">
                        <li><a class="filter-by-category active" category_id="">All categories</a></li>
                        @foreach($categories as $index => $cate)
                            <li><a class="filter-by-category" category_id="{{$cate['id']}}">{{$cate['name']}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="text-center visible-xs-block">
                    <select class="filter-by-category form-control">
                        <option value="">All categories</option>
                        @foreach($categories as $index => $cate)
                            <option value="{{$cate['id']}}">{{$cate['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="deal-page-body">
        <div class="container">
            <div class="row">
                <div class="deal-group clearfix">
                    <div class="list-deal row">
                        @foreach($deals as $d)
                            @include('elements.v2-box-deal')
                        @endforeach
                    </div>
                </div>
                <a href="" class="load-more show-more-deals @if(count($deals) < 20) hidden @endif"><i class="fa fa-arrow-circle-o-down"></i> Load More Coupons</a>
            </div>
        </div>
    </div>
@endsection
@section('footer-early')
    <!-- Popular Stores list -->
    @include('elements.popular-stores')
    <!-- /Popular Stores list -->
@endsection
@section('scripts-footer')
    <script>
        var $page = 2, $categoryId = '', $titleHeader = '';
        $('.show-more-deals').on('click', function (e) {
            e.preventDefault();
            var $that = $(this);
            $that.find('i.fa').removeClass('fa-arrow-circle-o-down').addClass('fa-spinner fa-pulse');
            $.ajax({
                type: 'get',
                url: '{{url('/deal/showMore')}}',
                data: {page : $page, categoryId: $categoryId}
            }).done(function (data) {
                if (data.status == 'error') {
                    $that.hide();
                } else {
                    $page ++;
                    $('.list-deal').append(data);
                    initGetCode();
                    truncateSomething();
                    $that.find('i.fa').removeClass('fa-spinner fa-pulse').addClass('fa-arrow-circle-o-down');
                }
            });
        });
        $('.filter-by-category[category_id]').on('click', function () {
            var $that = $(this);
            $categoryId = $that.attr('category_id');
            $('.show-more-deals').hide();
            $('.filter-by-category[category_id]').removeClass('active');
            $that.addClass('active');
            $('.box-deal-title').text($that.text());
            $('.list-deal').empty().append('<h3 class="text-center"><i class="fa fa-spinner fa-pulse"></i> Loading....</h3>');
            $.ajax({
                type: 'get',
                url: '{{url('/deal/showMore')}}',
                data: {page : 1, categoryId: $categoryId}
            }).done(function (data) {
                if (data.status == 'error') {
                    $('.list-deal').empty().append('<h3>No result found. Please choice other category.</h3>');
                } else {
                    $page = 2;
                    $('.show-more-deals').show();
                    $('.list-deal').empty().append(data);
                    $('.show-more-deals').find('i.fa').removeClass('fa-spinner fa-pulse').addClass('fa-arrow-circle-o-down');
                    initGetCode();
                    truncateSomething();
                }
            });
        });
        $('select.filter-by-category').on('change', function () {
            var $that = $(this);
            $categoryId = $that.val();
            $('.show-more-deals').hide();
            $('.list-deal').empty().append('<h3 class="text-center"><i class="fa fa-spinner fa-pulse"></i> Loading....</h3>');
            $.ajax({
                type: 'get',
                url: '{{url('/deal/showMore')}}',
                data: {page : 1, categoryId: $categoryId}
            }).done(function (data) {
                if (data.status == 'error') {
                    $('.list-deal').empty().append('<h3>No result found. Please choice other category.</h3>');

                } else {
                    $page = 2;
                    $('.show-more-deals').show();
                    $('.list-deal').empty().append(data);
                    $('.show-more-deals').find('i.fa').removeClass('fa-spinner fa-pulse').addClass('fa-arrow-circle-o-down');
                    initGetCode();
                    truncateSomething();
                }
            });
        });
        $('.back-to-top').click(function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });
    </script>
@endsection