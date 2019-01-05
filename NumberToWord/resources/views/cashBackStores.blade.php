<?php
/**
 * Created by PhpStorm.
 * User: Hung Cuong
 * Date: 12/29/2015
 * Time: 2:28 PM
 */
 ?>
@extends('app')
@section('scripts')
    <script src="{{ asset('vendor/jquery/jquery-1.11.4.ui.min.js'.$common['version_app']) }}" type="text/javascript" async defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="row cash-back-stores">
            <div class="row">
                <div class="col-md-9 header-cash-back-stores">
                    <h1><strong>Cash Back</strong> Stores</h1>
                </div>
                <div class="col-md-3 cash-back-col-left">
                    <div class="box-selection-right clearfix">
                        <h3 class="box-header clearfix">
                            <strong>Filter by A-Z</strong>
                            <span class="filter-caret">
                                <a role="button" id="parent-collapse-alpha-filter" class="collapsed" data-toggle="collapse" href="#cash-store-alpha-filter" aria-expanded="false"><i class="fa fa-caret-up"></i></a>
                            </span>
                        </h3>
                        <div id="cash-store-alpha-filter" data-parent="#parent-collapse-alpha-filter" class="box-items alpha-filter collapse">
                            <div class="filter-box">
                                <a class="filter-by-char-9" onclick="addQSParm('char',9)">0-9</a>
                                <a class="filter-by-char-a" onclick="addQSParm('char','a')">A</a>
                                <a class="filter-by-char-b" onclick="addQSParm('char','b')">B</a>
                                <a class="filter-by-char-c" onclick="addQSParm('char','c')">C</a>
                                <a class="filter-by-char-d" onclick="addQSParm('char','d')">D</a>
                                <a class="filter-by-char-e" onclick="addQSParm('char','e')">E</a>
                                <a class="filter-by-char-f" onclick="addQSParm('char','f')">F</a>
                                <a class="filter-by-char-g" onclick="addQSParm('char','g')">G</a>
                                <a class="filter-by-char-h" onclick="addQSParm('char','h')">H</a>
                                <a class="filter-by-char-i" onclick="addQSParm('char','i')">I</a>
                                <a class="filter-by-char-j" onclick="addQSParm('char','j')">J</a>
                                <a class="filter-by-char-k" onclick="addQSParm('char','k')">K</a>
                                <a class="filter-by-char-l" onclick="addQSParm('char','l')">L</a>
                                <a class="filter-by-char-m" onclick="addQSParm('char','m')">M</a>
                                <a class="filter-by-char-n" onclick="addQSParm('char','n')">N</a>
                                <a class="filter-by-char-o" onclick="addQSParm('char','o')">O</a>
                                <a class="filter-by-char-p" onclick="addQSParm('char','p')">P</a>
                                <a class="filter-by-char-q" onclick="addQSParm('char','q')">Q</a>
                                <a class="filter-by-char-r" onclick="addQSParm('char','r')">R</a>
                                <a class="filter-by-char-s" onclick="addQSParm('char','s')">S</a>
                                <a class="filter-by-char-t" onclick="addQSParm('char','t')">T</a>
                                <a class="filter-by-char-u" onclick="addQSParm('char','u')">U</a>
                                <a class="filter-by-char-v" onclick="addQSParm('char','v')">V</a>
                                <a class="filter-by-char-w" onclick="addQSParm('char','w')">W</a>
                                <a class="filter-by-char-x" onclick="addQSParm('char','x')">X</a>
                                <a class="filter-by-char-y" onclick="addQSParm('char','y')">Y</a>
                                <a class="filter-by-char-z" onclick="addQSParm('char','z')">Z</a>
                                <a class="filter-by-char-" onclick="addQSParm('char','')">All</a>
                            </div>
                        </div>
                    </div>
                    <div class="box-selection-right clearfix">
                        <h3 class="box-header clearfix">
                            <strong>Filter by Category</strong>
                            <span class="filter-caret">
                                <a role="button" id="parent-collapse-category-filter" class="collapsed" data-toggle="collapse" href="#cash-store-category-filter" aria-expanded="false"><i class="fa fa-caret-up"></i></a>
                            </span>
                            <span class="selected-category" style="display: none;"><a><i class="fa fa-close" onclick="addQSParm('cat','')"></i></a></span>
                        </h3>
                        <div id="cash-store-category-filter" data-parent="#parent-collapse-category-filter" class="box-items collapse">
                            <ul class="scrollbar-auto filter-box category-filter">
                                <li><a class="filter-by-cat-" onclick="addQSParm('cat','')">Show All</a></li>
                                @foreach($data['categories'] as $cat)
                                <li><a class="filter-by-cat-{{$cat['id']}}" onclick="addQSParm('cat','{{$cat['id']}}')">{{$cat['name']}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="box-selection-right no-border hidden-sm hidden-xs">
                        <div class="box-items">
                            <ul class="sub-break-crumb">
                                <li><a href="{{url('/')}}">Home</a></li>
                                <li><em>Cash Back Stores</em></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="cash-back-stores-list-box">
                        <div class="cash-back-slider">
                            <div class="flexslider" id="best-cash-back-slider">
                                <ul class="slides">
                                    @foreach($data['topStoresCashBack'] as $ts)
                                    <li>
                                        <div class="best-store-cash-back">
                                            <div class="title">
                                                <a class="fav-without-login item-likes click-to-save{{!empty($favourites[$ts['id']]) ? ' liked' : ''}}" id="{{$ts['id']}}" data-toggle="tooltip" data-placement="top"
                                                   title="{{!empty($favourites[$ts['id']]) ? 'Favorited' : 'Add to favorites'}}"><i class="fa fa-heart"></i>
                                                </a>
                                                <span class="cash-amount">
                                                    @if(!empty($ts['cashBackJson']))
                                                    Up to {{$ts['cashBackJson']['currency'] == '%' ? $ts['cashBackJson']['cash_back_percent'].'%' : $ts['cashBackJson']['currency'].$ts['cashBackJson']['cash_back']}} cash back
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="logo">
                                                <a href="{{url('/'. $ts['alias'].config('config.suffix_coupon'))}}">
                                                    <img alt="{{$ts['name']}}" title="{{$ts['name']}}" src="{{$ts['logo']}}" />
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="cash-back-stores-list">
                            @if(!empty($data['stores']) && sizeof($data['stores']['rows']))
                            @foreach($data['stores']['rows'] as $s)
                                @include('elements.v2-box-cash-back-store')
                            @endforeach
                            @else
                                <h3 style="text-align: center">Not Found</h3>
                            @endif
                        </div>
                    </div>
                    @if(!empty($data['stores']) && sizeof($data['stores']['rows']) >= 20)
                    <a class="load-more show-more-stores"><i class="fa fa-arrow-circle-o-down"></i> Load More Stores</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-footer')
    <script type="text/javascript">
        function addQSParm(paramName, paramValue)
        {
            if (paramName == 'char' && paramValue) {
                $('#cash-store-alpha-filter a').removeClass('active');
                $('.filter-by-char-'+paramValue).addClass('active');
            }
            if (paramName == 'cat' && paramValue) {
                $('span.selected-category').show();
                $('span.selected-category a').empty().prepend($('.filter-by-cat-'+paramValue).text() + '<i class="fa fa-close" onclick="addQSParm(\'cat\',\'\')"></i>');
            }else if (paramName == 'cat' && paramValue == '') $('span.selected-category').hide();
            $('.cash-back-stores-list').empty().append('<h3 class="text-center"><i class="fa fa-spinner fa-pulse"></i> Loading....</h3>');
            $('.show-more-stores').hide();
            $.ajax({
                type: 'get',
                url: '{{url('/cash-back-stores/filterStores')}}',
                data : {
                    type : paramName,
                    value : paramValue
                }
            }).done(function (data) {
                if (data.status == 'error') {
                    $('.cash-back-stores-list').empty().append('<h3 class="text-center">No result found.</h3>');
                } else {
                    $('.cash-back-stores-list').empty().append(data);
//                        initGlobal();
                    initGetCode();
                    truncateSomething();
                    $('.show-more-stores').show();
                }
            });
        }
        (function() {
//            var exist_char = getUrlVars()['char'];
//            if (exist_char) $('.filter-by-char-'+exist_char).addClass('active');
//
//            var exist_cat = getUrlVars()['cat'];
//            if (exist_cat) {
//                $('span.selected-category').show();
//                $('span.selected-category a').prepend($('.filter-by-cat-'+exist_cat).text());
//            }else $('span.selected-category').hide();
            // store the slider in a local variable
            var $window = $(window), flexslider;
            // tiny helper function to add breakpoints
            function getGridSize() {
                return (window.innerWidth < 480) ? 1 : (window.innerWidth < 767) ? 2 : (window.innerWidth < 1200) ? 3 : 4;
            }
            $window.load(function() {
                $('#best-cash-back-slider').flexslider({
                    animation: "slide",
                    animationLoop: true,
                    itemWidth: 210,
                    itemMargin: 5,
                    controlNav: false,
                    directionNav: true,
                    pauseOnHover: true,
                    minItems: getGridSize(), // use function to pull in initial value
                    maxItems: getGridSize(), // use function to pull in initial value
                    start: function(slider){
                        flexslider = slider;
                    }
                });
            });
            // check grid size on resize event
            $window.resize(function() {
                var gridSize = getGridSize();
                flexslider.vars.minItems = gridSize;
                flexslider.vars.maxItems = gridSize;
            });

            $('.show-more-stores').on('click', function (e) {
                e.preventDefault();
                var $that = $(this);
                $that.find('i.fa').addClass('fa-spinner fa-pulse').removeClass('fa-arrow-circle-o-down');
                $.ajax({
                    type: 'get',
                    url: '{{url('/cash-back-stores/showMoreStores')}}'
                }).done(function (data) {
                    if (data.status == 'error') {
                        $that.remove();
                    } else {
                        $('.cash-back-stores-list').append(data);
//                        initGlobal();
                        initGetCode();
                        truncateSomething();
                        $that.find('i.fa').removeClass('fa-spinner fa-pulse').addClass('fa-arrow-circle-o-down');
                    }
                });
            });

        }());
    </script>
@endsection
