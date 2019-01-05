@extends('profile.profile-app')

@section('profile-content')
    <div class="pro-stats clearfix">
        <div class="stats-header">Favorite Stores</div>
        <div class="stats-content list-favorites clearfix">
            @foreach($stores as $s)
                <div class="fav-stores-ico">
                    <span class="remove-fav favorites" s_id="{{$s['id']}}"><i class="fa fa-heart"></i></span>
                    <a href="{{url('/'. $s['alias'].config('config.suffix_coupon'))}}"><img src="{{$s['logo']}}" alt="{{$s['name']}}" /></a>
                </div>
            @endforeach
            @if(empty($stores))
                <div class="col-sm-12">Oops! You have not added any store in your favorites list</div>
            @endif
        </div>
        @if (!Auth::guest())
            <div class="stats-header margin-top-15">Recommended Stores</div>
            <div class="stats-content clearfix">
                @foreach($recommended as $r)
                    <div class="fav-stores-ico">
                        <span class="remove-fav" s_id="{{$r['id']}}"><i class="fa fa-heart-o"></i></span>
                        <a href="{{url('/'. $r['alias'].config('config.suffix_coupon'))}}"><img src="{{$r['logo']}}" alt="{{$r['name']}}" /></a>
                    </div>
                @endforeach
            </div>
            <div class="pro-search-stores">
                <div class="psearchbox row clearfix">
                    <div class="col-sm-6 psearch-bar">
                        <div class="psearch-header"><span>Favourite More Stores?</span></div>
                        <div class="psearch-desc">See the best {{config('config.coupon')}}s from your favorite stores on your personalized homepage.</div>
                    </div>
                    <div class="col-sm-6 psearch-group">
                        <form id="search-store-form" action="{{url('/profile/findStoreNotInFavourite')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="sub-sets-input-search">
                                <i class="fa fa-search ss-ic-search"></i>
                                <input class="form-control" id="search-store" name="kw" type="text" placeholder="Search more than 50,000 stores">
                            </div>
                            <div class="psearch-group-desc">Popular Searches:
                                @foreach($popular as $p)
                                    <span><a href="javascript:void(0);" data-rel="{{$p['name']}}">{{$p['name']}}</a></span>
                                @endforeach
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        <div class="pro-search-result"></div>
        <div class="show-more-btn text-center hidden"><button class="btn btn-default btn-block btn-show-more-loader">Show More <i class="fa
        fa-arrow-circle-o-down"></i></button></div>
    </div>
@endsection
@section('scripts-footer')
    <script type="text/javascript">
        var xhr;
        var $page = 0;
        var $form = $('#search-store-form');
        $form.on('submit', function (e) {
            if(xhr && xhr.readystate != 4){
                xhr.abort();
            }
            e.preventDefault();
            $form.find('i.fa').removeClass('fa-search').addClass('fa-spinner fa-pulse');
            xhr = $.ajax({
                type: 'post',
                url: $form.attr('action'),
                data: $form.serialize()
            }).done(function (data) {
                var $result = $('.pro-search-result');
                if (data.status == 'success') {
                    $page = 1;
                    if (data.items.length > 0) {
                        $result.empty();
                        bindSearchDataResult(data)
                    }else{
                        $('.show-more-btn').addClass('hidden');
                        $result.empty().append('<h3>No Search Result</h3>');
                    }
                } else if (data.status == 'error') {}
                $form.find('i.fa').removeClass('fa-spinner fa-pulse').addClass('fa-search');
            });
        });

        $('.btn-show-more-loader').on('click', function(){
            loadMoreSearchResult();
        });

        $('#search-store').keyup(function(){
            if($('#search-store').val().length > 1){
                $('#search-store-form').submit();
            }
        });

        $('.psearch-group-desc>span>a').on('click', function(){
            $that = $(this);
            $('#search-store').val($that.attr('data-rel'));
            $('#search-store-form').submit();
        });

        function loadMoreSearchResult(){
            if(xhr && xhr.readystate != 4){
                xhr.abort();
            }
            $page++;
            $loadmore = $('.show-more-btn').find('i.fa');
            $loadmore.removeClass('fa-arrow-circle-o-down').addClass('fa-spinner fa-pulse');
            $.ajax({
                type: 'post',
                url: $form.attr('action'),
                data: $form.serialize() + '&page=' + $page
            }).done(function (data) {
                var $result = $('.pro-search-result');
                if (data.status == 'success') {
                    if (data.items.length > 0) {
                        bindSearchDataResult(data)
                    }else{
                        $('.show-more-btn').addClass('hidden');
                    }
                } else if (data.status == 'error') {}
                $loadmore.removeClass('fa-spinner fa-pulse').addClass('fa-arrow-circle-o-down');
            });
        }

        function bindSearchDataResult(data){
            var $result = $('.pro-search-result');
            var content = '';
            var item = null;
            for(var i = 0;i < data.items.length; i++) {
                item = data.items[i];
                content += '<div class="fav-res-item clearfix">'
                + '<div class="fav-stores-ico">'
                + "<a href='"+ "{{url('/')}}/" + item.alias +"{{config('config.suffix_coupon')}}'><img src='"+ item.logo + "' alt='"+ item.name +"' /></a>"
                + '</div>'
                + '<div class="fav-res-info">'
                + '<div class="fave-resin-header ellipsis2">'+ item.name +'</div>'
                + '<div class="fave-resin-desc ellipsis2"> Coupons: '+ item.coupon_count +' / Deals: ' + item.deal_count + '</div>'
                + '</div>';
                content += '<div class="fav-btn-item"><button class="btn btn-block btn-fav add-to-favorites" id="'+item.id+'"><i class="fa fa-heart"></i> &nbsp;Add to Favorites</button></div>';
                content += '</div>'
            }
            $result.append(content);
            if(data.items.length == 10){
                $('.show-more-btn').removeClass('hidden');
            }else{
                $('.show-more-btn').addClass('hidden');
            }
            initGlobal();
            initFavorite();
        }

        function initFavorite(){
            $('.remove-fav.favorites').unbind('click').one('click', function () {
                var $that = $(this);
                $.ajax({
                    type: 'get',
                    url: "{{url('/user/saveAndFavourite')}}",
                    data: {object_id: $that.attr('s_id'), type: 'unFavouriteStore'}
                }).done(function (data) {
                    if (data.status == 'success') {
                    } else if (data.status == 'error') {}
                });
                $that.find('i').removeClass('fa-heart').addClass('fa-heart-o');
                $that.removeClass('favorites');
                initFavorite()
            });

            $(".remove-fav:not('.favorites')").unbind('click').one('click', function () {
                var $that = $(this);
                $.ajax({
                    type: 'get',
                    url: "{{url('/user/saveAndFavourite')}}",
                    data: {object_id: $that.attr('s_id'), type: 'favouriteStore'}
                }).done(function (data) {
                    if (data.status == 'success') {
                    } else if (data.status == 'error') {}
                });
                $that.find('i').removeClass('fa-heart-o').addClass('fa-heart');
                $that.addClass('favorites');
                initFavorite()
            });

            $('.btn-fav.add-to-favorites').unbind('click').one('click',function () {
                var $that = $(this);
                $that.addClass('btn-added').removeClass('add-to-favorites').empty().append('<i class="fa fa-heart"></i> &nbsp;Added');
                $.ajax({
                    type: 'get',
                    url: "{{url('/user/saveAndFavourite')}}",
                    data: {object_id: $that.attr('id'), type: 'favouriteStore'}
                }).done(function (data) {
                    if (data.status == 'success') {
                        var $storeAdded = $that.parents('.fav-res-item');
                        var content = '<div class="fav-stores-ico">'
                                + '<span class="remove-fav favorites" s_id="'+ $that.attr('id') +'"><i class="fa fa-heart"></i></span>'
                                + '<a href="'+$storeAdded.find('.fav-stores-ico > a').attr('href')+'"><img src="'+$storeAdded.find('.fav-stores-ico > a > img').attr('src')+'" alt="'+$storeAdded.find('.fav-stores-ico > a > img').attr('alt')+'" /></a>'
                                + '</div>';
                        $('.stats-content.list-favorites').append(content);
                        initFavorite()
                    } else if (data.status == 'error') {}
                });
            });
        }

        initFavorite();

        /*Load fav stores from localStorage if user not logged in*/
        @if (Auth::guest())
            $.ajax({
                type: 'GET',
                url: "{{url('/profile/getDataFromBrowser/')}}",
                data: {ids : localStorage.favouriteStores, type : 'stores'}
            }).done(function (r) {
                if(r){
                    for(i = 0; i < r.length; i++){
                        div = '<div class="fav-stores-ico"><span class="remove-fav favorites" s_id="'
                        + r[i]['id'] + '"> <i class="fa fa-heart"></i></span>' + '<a href="{{url()}}'
                        + r[i]['alias'] + '{{config("config.suffix_coupon")}}">' + '<img src="'
                        + r[i]['logo'] + '" alt="'
                        + r[i]['name'] + '"/></a></div>';

                        $('.list-favorites').append(div);
                    }
                }
            })
            // Remove clicked store from localStorage.favouriteStores
            $(document).on('click', '.remove-fav', function(){
                removedId = $(this).attr('s_id');
                y = (localStorage.favouriteStores).split(',');
                y.splice( $.inArray(removedId, y), 1);
                localStorage.favouriteStores = y;
                $(this).find('i').attr('class', 'fa fa-heart-o');
            })
        @endif
    </script>
@endsection
