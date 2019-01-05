<?php
/**
 * Created by PhpStorm.
 * User: Phuong
 * Date: 1/14/2016
 * Time: 11:11 AM
 */
?>
@extends('profile.v2-profile-app')
@section('scripts')
    <script src="{{ asset('vendor/jquery/jquery-1.11.4.ui.min.js'.$common['version_app']) }}" type="text/javascript" async defer></script>
@endsection
@section('profile-content')
    <div class="profile-box-default favourite-profile favorited-stores">
        @foreach($stores as $s)
            <div class="col-md-2 col-sm-3 fav-store-box">
                <div class="fav-store">
                    <a class="fav-without-login item-likes click-to-save likes-btn liked" id="{{$s['id']}}" data-toggle="tooltip" data-placement="top"
                       title=""><i class="fa fa-heart"></i>
                    </a>
                    <a href="{{url('/'. $s['alias'].config('config.suffix_coupon'))}}"><img src="{{$s['logo']}}" alt="{{$s['name']}}"></a>
                </div>
            </div>
        @endforeach
            @if (sizeof($stores) >= 18)
                <div class="col-sm-12" style="float: left;width: 100%">
                    <a href="" class="load-more show-more-stores"><i class="fa fa-arrow-circle-o-down"></i> Load More Coupons</a>
                </div>
                <!-- a href="javascript:;" class="load-more ajax-loading"><i class="fa fa-spinner fa-pulse"></i> Load More Coupons</a -->
            @endif
        @if(!sizeof($stores))
            <h3 style="text-align: center;margin-bottom: 35px;">You have not added any stores in your Favorite list</h3>
        @endif
    </div>
    @if (Auth::check())
    <div class="profile-box-default favourite-profile">
        <h1 class="box-header has-collapse collapsed" data-toggle="collapse" href="#collapse-recommend-stores" aria-expanded="true">Recommended Stores <i class="fa fa-caret-up"></i></h1>
        <div id="collapse-recommend-stores" class="collapse in">
            @for($i = 0; $i< min(sizeof($recommended),12);$i++)
                <div class="col-md-2 col-sm-3 fav-store-box">
                    <div class="fav-store">
                        <a class="fav-without-login item-likes click-to-save likes-btn" id="{{$recommended[$i]['id']}}" data-toggle="tooltip" data-placement="top"
                           title=""><i class="fa fa-heart"></i>
                        </a>
                        <a href="{{url('/'. $recommended[$i]['alias'].config('config.suffix_coupon'))}}"><img src="{{$recommended[$i]['logo']}}" alt="{{$recommended[$i]['name']}}"></a>
                    </div>
                </div>
            @endfor
            <div class="col-sm-offset-4 col-sm-4 fav-search-store">
                <br>
                <form id="search-store-form" action="{{url('/profile/findStoreNotInFavourite')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="search-store" name="kw" placeholder="Search more than 50,000 stores">
                        <span class="fa fa-search ss-ic-search form-control-feedback" ></span>
                    </div>
                </form>
            </div>
            <div class="pro-search-result"></div>
        </div>
    </div>
    @endif
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
            $form.find('.fa').removeClass('fa-search').addClass('fa-spinner');
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
                $form.find('.fa').removeClass('fa-spinner').addClass('fa-search');
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
                content += '<div class="col-sm-6 clearfix">'
                        + '<div class="fav-store">'
                        + '<a class="fav-without-login item-likes click-to-save likes-btn" id="' + item.id + '" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-heart"></i>'
                        + '</a>'
                        + "<a href='"+ "{{url('/')}}/" + item.alias +"{{config('config.suffix_coupon')}}'><img src='"+ item.logo + "' alt='"+ item.name +"' /></a>"
                        + '</div>'
                        + '<div class="fav-res-info">'
                        + '<div class="fave-resin-header ellipsis2">'+ item.name +'</div>'
                        + '<div class="fave-resin-desc ellipsis2"> Coupons: '+ item.coupon_count + '</div>'
                        + '</div>';
                content += '</div>'
            }
            $result.append(content);
            $('.item-likes').flyingItem({
                hasIgnore:'liked',
                titleChange:'Favorited'
            });
            $('.item-save-icon').flyingItem({hasIgnore:'saved', titleChange:'Saved'});
        }

        $('.show-more-stores').on('click', function (e) {
            e.preventDefault();
            var $that = $(this);
            $that.find('i.fa').addClass('fa-spinner fa-pulse').removeClass('fa-arrow-circle-o-down');
            $.ajax({
                type: 'get',
                url: '{{url('/profile/showMoreFavoriteStores')}}'
            }).done(function (data) {
                if (data.status == 'error') {
                    $that.remove();
                } else {
                    $(data).insertBefore($that.parent());
                    initGetCode();
                    $that.find('i.fa').removeClass('fa-spinner fa-pulse').addClass('fa-arrow-circle-o-down');
                }
            });
        });

        /*Load fav stores from localStorage if user not logged in*/
        @if (Auth::guest())
        if(localStorage.favouriteStores)
            $.ajax({
            type: 'GET',
            url: "{{url('/profile/getDataFromBrowser/')}}",
            data: {ids : localStorage.favouriteStores, type : 'stores'}
            }).done(function (r) {
                if(r){
                    var div = "";
                    @if(isset($disable) && $disable == false)
                    div = "<h3><b>Your Favorited Stores are only temporary</b></h3>"
                            + '<p><a href="{{ url('/login') }}" style="color: #854c99;">CREATE AN ACCOUNT</a> and we will keep them safe and sound, otherwise these will disappear after you leave.</p>';
                    @endif
                    for(var i = 0; i < r.length; i++){
                        div += '<div class="col-md-2 col-sm-3 fav-store-box">'
                                + '<div class="fav-store">'
                                + '<a class="fav-without-login item-likes click-to-save likes-btn liked" id="'+ r[i]['id'] +'" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-heart"></i>'
                                + '</a>'
                                + '<a href="{{url('/')}}/' + r[i]['alias'] + '{{config("config.suffix_coupon")}}"><img src="'+ r[i]['logo'] +'" alt="'+ r[i]['name'] +'"></a>'
                                + '</div>'
                                + '</div>';
                    }
                    $('.favorited-stores').empty().append(div);
                    $('.item-likes').flyingItem({
                        hasIgnore:'liked',
                        titleChange:'Favorited'
                    });
                    $('.item-save-icon').flyingItem({hasIgnore:'saved', titleChange:'Saved'});
                }
            });
        // Remove clicked store from localStorage.favouriteStores
        $(document).on('click', '.remove-fav', function(){
            removedId = $(this).attr('s_id');
            y = (localStorage.favouriteStores).split(',');
            y.splice( $.inArray(removedId, y), 1);
            localStorage.favouriteStores = y;
            $(this).find('i').attr('class', 'fa fa-heart-o');
        });
        @endif
    </script>
@endsection
