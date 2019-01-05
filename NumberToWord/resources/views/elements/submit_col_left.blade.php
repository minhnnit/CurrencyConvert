<div class="big-left-col">
    <div class="left-col">
        <div class="t-counter">
            <p class="t-counter-num">{{$store['coupon_count']}}</p>
            <p>Coupons Available</p>
        </div>
        @if( !empty($store['couponType']) )
        <div class="filter">
            <div class="h3">Coupon Type:</div>
            <div class="l">
                @foreach($store['couponType'] as $ct)
                <a class="filter-item" data-value="price_off" data-type="discount_type">
                    <input type="checkbox" class="filter-coupon-type" value="{{$ct['coupon_type']}}" {{ !empty(Session::get('coupon_type_' . $store['alias'])) ? (in_array($ct['coupon_type'] ,Session::get('coupon_type_' . $store['alias'])) ? 'checked' : '') : '' }} />
                    <label>{{$ct['coupon_type']}}</label>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

@if(count($store['childStores'])>0)
    <div class="left-col col-related">
        <h3 class="box-header">
            Related stores
        </h3>
        <div>
            <ul class="list-related" id="style-2">
                @foreach($store['childStores'] as $ct)
                    <li><a class="filter-item" style="color:#337ab7" href="{{ url('/'.$ct->alias) }}" title="{{ $ct->name }}">{{ $ct->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="left-col">
@include('GA.ga-dpf')
</div>

@if(!empty($popularStores))
    <div class="left-col col-related">
        <h3 class="box-header">
            Popular stores
        </h3>
        <div>
            <ul class="list-related" id="style-2">
            @foreach ($popularStores as $k=>$st)
            <?php $title_link = str_ireplace(' Coupons','',$st['name']); $title_link = isset($title_link{20})?substr($title_link,0,17).'...':$title_link;?>
                        <li><a class="filter-item" href="{{url('/' . $st['alias'])}}" title="{{ $st['name'] }}">{{$title_link}}</a></li>
			@endforeach
            </ul>
        </div>
    </div>
@endif
<div class="left-col">
@include('GA.ga-dpf')
</div>

</div>