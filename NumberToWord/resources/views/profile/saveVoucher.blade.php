@extends('profile.profile-app')

@section('profile-content')
    <div class="pro-stats clearfix">
        <div class="stats-header">Saved {{config('config.Coupon')}}s</div>
        <div class="list-saved">
            @foreach($coupons as $c)
                <div class="col-md-4 col-sm-6 col-sms-6 box-lsi-item">
                    <span class="remove-coupon" c_id="{{$c['id']}}"><i class="fa fa-times-circle fa-2x fa-fw"></i></span>
                    @include('elements.box-store-coupon-saved')
                </div>
            @endforeach
            @if(empty($coupons))
                <div class="col-sm-12 text-center">Oops! You have not added any {{config('config.Coupon')}} in your save list</div>
            @endif
        </div>
    </div>
@endsection
@section('scripts-footer')
    <script>
        $('.remove-coupon').one('click', function () {
            var $that = $(this);
            $.ajax({
                type: 'get',
                url: "{{url('/user/saveAndFavourite')}}",
                data: {object_id: $that.attr('c_id'), type: 'unFavouriteCoupon'}
            }).done(function (data) {
                if (data.status == 'success') {
                } else if (data.status == 'error') {
                }
            });
            $that.parent().remove();
        });

        /*Load saved coupons from localStorage*/
        if(localStorage.saveCoupons){
            $.ajax({
                type: 'GET',
                url: "{{url('/profile/getDataFromBrowser/')}}",
                data: {ids : localStorage.saveCoupons, type : 'coupons'},
                dataType : 'JSON'
            }).done(function (r) {
                if(r){
                    for(i = 0; i < r.length; i++){
                        var item = r[i];
                        $('.list-saved').append(item);
                    }
                    reAppendScripts();
                }
            })
        }
        // Re append scripts to coupons
        function reAppendScripts(){
            $('h3.lsi-item-title, div.lsi-item-content').each(function() {
                var $el = $(this);

                $el.truncate({
                    lines: 2,
                    lineHeight: 25
                });
                $el.on('mouseenter touchstart', function () {
                    $el.truncate('expand');
                    $el.addClass('extra');
                    return false;
                });
                $el.on('mouseleave touchend', function () {
                    $el.truncate('collapse');
                    $el.removeClass('extra');
                    return false;
                });
            });
            initGetCode();
        }

        // Remove clicked coupon from localStorage.saveCoupons
        $(document).on('click', '.remove-cp-from-local', function(){
            console.log('before remove : ', localStorage.saveCoupons);
            removedId = $(this).attr('c_id');
            y = (localStorage.saveCoupons).split(',');
            y.splice( $.inArray(removedId, y), 1);
            localStorage.saveCoupons = y;
            console.log('after remove : ', localStorage.saveCoupons);
            $(this).parent().remove();
        })
    </script>
@endsection
