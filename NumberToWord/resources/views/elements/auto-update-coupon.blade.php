<script>
    // Get from dontpayfull
    function updateCoupon() {
        var storeUrl = '{{ $store['store_url'] }}';
        storeUrl = storeUrl.replace('https://','').replace('http://','').replace('www.','').replace('/','');
        // dpf
        server_1(storeUrl);
        // dp
        server_2(storeUrl);
        // updateCoupert
        server_3(storeUrl);

        godFather('{{ url('/store/updateCouponasion') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', null, 'Couponasion.com');
        godFather('{{ url('/store/updateCouponsherpa') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', null, 'Couponsherpa.com');
        godFather('{{ url('/store/updateCouponGoodSearch') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', null, 'GoodSearch.com');
        godFather('{{ url('/store/updatePromotioncode') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', null, 'Promotioncode.com');
        godFather('{{ url('/store/updateDealoupons') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', null, 'Dealoupons.com');
        godFather('{{ url('/store/updateBradsdeals') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', null, 'Bradsdeals.com');
        godFather('{{ url('/store/updateSavevy') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', storeUrl, 'Savevy.com');
        godFather('{{ url('/store/updateDealhack') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', null, 'Dealhack.com');
        godFather('{{ url('/store/updateCouponforless') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', storeUrl, 'Couponforless.com');
        godFather('{{ url('/store/update360couponcodes') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', storeUrl, '360couponcodes.com');
        godFather('{{ url('/store/updateCouponology') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', null, 'couponology.com');
        godFather('{{ url('/store/updateSlickdeals') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', null, 'Slickdeals.com');
        godFather('{{ url('/store/updateCouponlawn') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', null, 'Couponlawn.com');
        godFather('{{ url('/store/updateGetcouponcodes') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', null, 'Getcouponcodes.com');
        godFather('{{ url('/store/updateCoupontwo') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', storeUrl, 'Coupontwo.com');
        godFather('{{ url('/store/updateSavedoubler') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', null, 'savedoubler.com');
        godFather('{{ url('/store/updateCouponsgood') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', storeUrl, 'Couponsgood.com');
        godFather('{{ url('/store/updateCopypromocode') }}', '{{ $store['id'] }}', '{{ $store['alias'] }}', null, 'Copypromocode.com');
    }
    //    updateCoupon();

    function testAllowAjax(url) {
        $.ajax({
            type: 'get',
            url: '{{ url('/store/testAllowAjax') }}',
            data: {url:url}
        }).done(function (response) {})
    }
    //    testAllowAjax('http://copypromocode.com/coupons/udemy.html');

    $('#btnUpdate').click(function(){
        updateCoupon();
    });

    function server_1(storeUrl) {
        $.ajax({
            type: 'get',
            url: '{{ url('/store/updateCouponDPF') }}',
            data: {
                storeId : '{{$store['id']}}',
                storeUrl: storeUrl
            }
        }).done(function (response) {
            var l = response.length;
            var _token = '{{ csrf_token() }}';
            for(var i = 0; i < l; i++){
                var item = response[i];
                item._token = _token;
                item.storeId = '{{$store['id']}}';
                $.ajax({
                    type: 'post',
                    url: '{{ url('/store/updateCoupon/getCode') }}',
                    data: response[i]
                }).done(function (response) {
                });
            }
        });
    }
    function server_2(storeUrl) {
        $.ajax({
            type: 'get',
            url: '{{ url('/store/updateCouponDealSpot') }}',
            data: {
                storeId : '{{$store['id']}}',
                storeUrl: storeUrl
            }
        }).done(function (response) {
            var l = response.length;
            var _token = '{{ csrf_token() }}';
            for(var i = 0; i < l; i++){
                var item = response[i];
                item._token = _token;
                item.storeId = '{{$store['id']}}';
                $.ajax({
                    type: 'post',
                    url: '{{ url('/store/updateCoupon/addDealspotr') }}',
                    data: response[i]
                }).done(function (response) {
                });
            }
        });
    }
    function server_3(storeUrl) {
        $.ajax({
            type: 'get',
            url: '{{ url('/store/updateCoupert') }}',
            data: {
                storeId : '{{$store['id']}}',
                storeUrl: storeUrl
            }
        }).done(function (response) {
            var l = response.length;
            var _token = '{{ csrf_token() }}';
            for(var i = 0; i < l; i++){
                var item = response[i];
                item._token = _token;
                item.storeId = '{{$store['id']}}';
                $.ajax({
                    type: 'post',
                    url: '{{ url('/store/updateCoupon/addCoupert') }}',
                    data: response[i]
                }).done(function (response) {
                });
            }
        });
    }

    function godFather(ajaxPath, storeId, storeAlias, storeUrl,couponNote) {
        var data = {};
        if(storeAlias)
            data.storeAlias = storeAlias;
        if(storeId)
            data.storeId = storeId;
        if(storeUrl)
            data.storeUrl = storeUrl;
        $.ajax({
            type: 'get',
            url: ajaxPath,
            data: data
        }).done(function (response) {
            var l = response.length;
            var _token = '{{ csrf_token() }}';
            for(var i = 0; i < l; i++){
                var item = response[i];
                item._token = _token;
                item.storeId = '{{$store['id']}}';
                item.note = couponNote;
                $.ajax({
                    type: 'post',
                    url: '{{ url('/store/updateCoupon/addCouponasion') }}',
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
            url: '{{ url('/next-update') }}',
            data: {
                storeId: '{{ $store['id'] }}',
                _token: '{{ csrf_token() }}'
            }
        }).done(function (response) {
            $(document).unbind("ajaxStop");
            response = JSON.parse(response);
            if (typeof response.alias !== 'undefined') {
                //  var next = 'http://localhost:8080/Frontend/CouponsPlusDeals.com/public/' + response.alias + '-coupons' + '?update-coupon=1';
                // add param to update for next store
                window.location.href = '{{ url('/') }}' + '/' + response.alias + '?update-coupon=1';
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
        $(document).ajaxStop(function() {
            nextStore();
        });
    }

</script>