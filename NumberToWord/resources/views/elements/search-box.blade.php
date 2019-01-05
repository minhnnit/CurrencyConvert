<div class="search-input">
    <span class="input-group">
    <input type="text" id="search-any" class="form-control search-form-header input-search" placeholder="Enter brand e.g pizza express, argos">
    <span class="input-group-append"><button type="submit" class="btn btn-search"><em class="fa fa-search fa-lg"></em></button></span>
    </span>
</div>
<link rel="stylesheet" type="text/css" href="{{asset('vendor/select2/select2.min.css')}}">
<script src="{{asset('vendor/select2/select2.min.js')}}"></script>
<script>
    $( document ).ready(function(){
        $(".search-form-header").select2({
            placeholder: "Search for Stores...",
            minimumInputLength: 2,
            multiple: true,
            ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                url: "{{url('/search/')}}",
                dataType: 'json',
                quietMillis: 250,
                data: function (term, page) { // page is the one-based page number tracked by Select2
                    return {
                        keyword: term, //search term
                        page: page // page number
                    };
                },
                results: function (data, page) {
                    var more = (page * 30) < data.total_count; // whether or not there are more results available

                    // notice we return the value of more so Select2 knows if more results can be loaded
                    return { results: data.items, more: more };
                },
                cache: true
            },
            formatResult: searchFormatResult, // omitted for brevity, see the source of this page
            formatSelection: searchFormatSelection,  // omitted for brevity, see the source of this page
            dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
            escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
        }).on("select2-selecting", function(e) {
            if (e.object.type == 'store') {
                window.location = "{{url('/')}}" + '/' + e.object.alias + '';
            } else if (e.object.type == 'coupon') {
                window.open("{{url('/')}}" + '/' + e.object.store_alias + '?c=' + e.object.coupon_key, '_blank');
                window.open("{{url('/go/')}}" + '/' + e.object.coupon_key, '_self');
            } else {
                window.open('?d=' + e.object.coupon_key, '_blank');
                window.open("{{url('/go/')}}" + '/' + e.object.coupon_key, '_self');
            }
        });
        function searchFormatResult(repo) {
            var markup = '';
            if (repo.type == 'store' || repo.type == 'deal') {
                markup = '<div class="row">' +
                    //            '<div class="col-sm-4"><img class="img-responsive" src="' + repo.image + '" /></div>' +
                    '<div class="col-sm-12">' +
                    '<div class="">' +
                    '<div><b>' + repo.title + '</b></div>' +
                    //            '<div>' + repo.description + '</div>' +
                    '</div></div></div>';
            } else {
                markup = '<div class="row">' +
                    '<div class="col-sm-4">';
                if (repo.coupon_type == 'COUPON CODE') {
                    markup += '<figcaption class="search-coupon"><samp class="btn-coupon-small">';
                    if (repo.exclusive == 1)
                        markup += '<span class="exclu-stamp">Exclusive</span>';
                    markup += '<strong>' + repo.discount
                        + '<sup>'+repo.currency+'</sup>'
                        + '</strong><span>Discount</span></samp></figcaption>'
                } else if (repo.coupon_type == 'FREE SHIPPING') {
                    markup += '<figcaption class="search-free"><samp class="btn-coupon-small">';
                    if (repo.exclusive == 1)
                        markup += '<span class="exclu-stamp">Exclusive</span>';
                    markup += '<strong>Free</strong><span>{{config('config.Shipping')}}</span></samp></figcaption>'
                } else {
                    markup += '<figcaption class="search-deal"><samp class="btn-coupon-small">';
                    if (repo.exclusive == 1)
                        markup += '<span class="exclu-stamp">Exclusive</span>';
                    markup += '<strong>Great</strong><span>Offer</span></samp></figcaption>'
                }
                markup += '</div>' +
                    '<div class="col-sm-8">' +
                    '<div class="">' +
                    '<div><b>' + repo.title + '</b></div>' +
                    '<div>' + repo.description + '</div>' +
                    '</div></div></div>';
            }
            return markup;
        }

        function searchFormatSelection(repo) {
            return repo.title;
        }
    });
</script>