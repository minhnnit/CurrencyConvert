<script>
    //Update coupon
    function nextStore() {
        $.ajax({
            type: 'POST',
            url: '{{ url('/next-update-from-lib') }}',
            data: {
                storeId: '{{ $store['id'] }}',
                _token: '{{ csrf_token() }}'
            }
        }).done(function (response) {
            $(document).unbind("ajaxStop");
            response = JSON.parse(response);
            if (typeof response.alias !== 'undefined') {
                window.location.href = '{{ url('/auto-update-from-lib') }}' + '/' + response.alias + '?update-coupon=1';
            } else {
                alert('stop');
            }
        });
    }

    var searchParams = new URLSearchParams(window.location.search);
    var param = searchParams.get('update-coupon');
    if(param){
            window.onload = function(){setTimeout(nextStore,1000);}
    }

</script>