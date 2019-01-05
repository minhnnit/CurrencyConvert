<script>
    // Get from dontpayfull
    function updateCoupon() {
		@if(isset($storeNotExists)===false)
        var storeUrl = '{{ $store['store_url'] }}';
        storeUrl = storeUrl.replace('https://','').replace('http://','').replace('www.','').replace('/','');

        @foreach($dataConfig as $domain=>$v)
        @if(isset($v['run'])===false || $v['run'])
        godFather('{{url('/auto-get-pull')}}?domainGet={{$domain}}&alias={{ $store['alias'] }}&aliasDomain='+storeUrl+'&storeId={{ $store['id'] }}', '{{$v['note']?:$domain}}');
        @endif
        @endforeach
		@endif

    }
//    updateCoupon();


    $('#btnUpdate').click(function(){
        updateCoupon();
    });


    function godFather(ajaxPath, couponNote) {
        $.ajax({
            type: 'get',
            url: ajaxPath,
            timeout: 45000
        }).done(function (response) {
            var l = response.length;
            var _token = '{{ csrf_token() }}';
            for(var i = 0; i < l; i++){
                var item = response[i];
                item._token = _token;
                item.storeId = '{{ isset($store['id'])?$store['id']:'' }}';
                item.note = couponNote;
                $.ajax({
                    type: 'post',
                    url: '{{ url('/auto-insert-db') }}',
                    data: item
                }).done(function (response) {
                });
            }
        });
    }

    //Update coupon
    function nextStore() {
        $.ajax({
            type: 'get',
            url: '{{ url('/next-update-pull-coupon') }}',
            data: {
                storeId: '{{ isset($store['id'])?$store['id']:'' }}',
                _token: '{{ csrf_token() }}'
            }
        }).done(function (response) {
            $(document).unbind("ajaxStop");
            response = JSON.parse(response);
            if (typeof response.alias !== 'undefined') {
                //  var next = 'http://localhost:8080/Frontend/CouponsPlusDeals.com/public/' + response.alias + '-coupons' + '?update-coupon=1';
                // add param to update for next store
                window.location.href = '{{ url('/pull-coupon') }}' + '/' + response.alias + '?update-coupon=1';
            } else {
                console.log('stop');
            }
        });
    }
    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null){
            return null;
        }else{
            return decodeURI(results[1]) || 0;
        }
    };
    var searchParams = new URLSearchParams(window.location.search);
    var param = searchParams.get('update-coupon');
    if(param){
        updateCoupon();
        $(document).{{isset($store['id'])===false?'ready':'ajaxStop'}}(function() {
            nextStore();
        });
    }

</script>