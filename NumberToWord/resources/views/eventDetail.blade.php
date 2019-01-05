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
                <em itemprop="name">{{$event['name']}}</em>
                <meta itemprop="position" content="3" />
            </li>
        </ol>
    </div>
    <div class="deal-page-header">
        <div class="container">
            <div class="row" >
                <h1 class="header-deal-page">{{$event['name']}}</h1>
                <div class="jump-crumb"><strong>Filter Categories:</strong>
                    <ul class="header-line-crumb">
                        @foreach($categories as $index => $cate)
                            <li><a class="filter-by-category" category_id="{{$cate['id']}}">{{$cate['name']}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="deal-page-body">
        <div class="container">
            <div class="row">
                <div class="deal-group clearfix">
                    <div class="list-deal">
                        @foreach($deals as $d)
                            <a deal_id="{{$d['go']}}" class="popup-get-code">
                                <div class="col-md-3 col-sm-4 col-sms-6 deal-item">
                                    <div class="deal-img">
                                        <img src="{{$d['deal_image']}}" alt="{{$d['title']}}" >
                                        <div class="deal-logo">
                                            <img src="{{$d['s_logo']}}">
                                        </div>
                                    </div>
                                    <div class="deal-percent"><span class="deal-real">{{$d['origin_price'].$d['currency']}}</span><span class="deal-down">{{$d['discount_price'].$d['currency']}}</span></div>
                                    <div class="deal-title ellipsis2">{{$d['title']}}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-12 text-right">
                    <a class="show-more-deals @if(count($deals) < 36) hidden @endif"><i>Show more</i><i class="fa fa-arrow-circle-o-down fa-fw"></i></a>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="currentCatFilter">
@endsection
@section('footer-early')
    <!-- Popular Stores list -->
    @include('elements.popular-stores')
    <!-- /Popular Stores list -->
@endsection
@section('scripts-footer')
    <script>
        var $page = 1, $categoryId = '', $titleHeader = '';
        var $limit = 40;
        $('.show-more-deals').on('click', function () {
            $categoryId = $('#currentCatFilter').val();
            var $that = $(this);
            $that.find('i.fa').removeClass('fa-arrow-circle-o-down').addClass('fa-spinner fa-pulse');
            $.ajax({
                type: 'get',
                url: "{{url('/event')}}" + "/" + "{{$event['alias']}}" + "/showMore",
                data: {
                    limit : $limit,
                    alias : "{{$event['alias']}}",
                    categoryId : $categoryId,
                    countItem : $('.deal-item').length
                }
            }).done(function (data) {
                if (data.status == 'error') {
                    $that.hide();
                } else {
                    $limit = $limit + 4;
                    // $('.list-deal').append(data);
                    $('.list-deal').empty().append(data);
                    initGetCode();
                    $that.find('i.fa').removeClass('fa-spinner fa-pulse').addClass('fa-arrow-circle-o-down');
                }
            });
        });
        $('.filter-by-category[category_id]').on('click', function () {
            console.log($('.deal-item').length);
            var $that = $(this);
            $categoryId = $that.attr('category_id');
            $('.box-deal-title').text($that.text());
            $('.list-deal').empty().append('<h3><i class="fa fa-spinner fa-pulse"></i> Loading....</h3>');
            $.ajax({
                type: 'get',
                url: "{{url('/event')}}" + "/" + "{{$event['alias']}}" + "/showMore",
                data: {
                    limit : 0,
                    categoryId : $categoryId,
                    alias : "{{$event['alias']}}"
                }
            }).done(function (data) {
                if (data.status == 'error') {
                    $('.list-deal').empty().append('<h3>No result found. Please select other category.</h3>');
                    $('.show-more-deals').hide();
                } else {
                    $page = 2;
                    $('.show-more-deals').show();
                    $('.list-deal').empty().append(data);
                    $('.show-more-deals').find('i.fa').removeClass('fa-spinner fa-pulse').addClass('fa-arrow-circle-o-down');
                    initGetCode();
                }
                $('#currentCatFilter').val($categoryId);
            });
        });
        $('.back-to-top').click(function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });
    </script>
@endsection