<h1 class="main title" style="text-align:center;padding:35px;font-size: 35px">
    Popular Store
</h1>
<div class="footer link-popular">
    <div class="main">
        @foreach ($popularStores as $k=>$st)
            @if($k%6===0)<div class="row">@endif
                <?php $title_link = str_ireplace(' Coupons','',$st['name']); $title_link = isset($title_link{20})?substr($title_link,0,17).'...':$title_link;?>
                <div class="col-md-5 col-sm-5 col-lg-4 col-xl-2">
                    <a href="{{url('/' . $st['alias'])}}" title="{{ $st['name'] }}">{{$title_link}}</a>
                </div>
                <?php $k++;?>@if($k%6===0)</div>@endif
        @endforeach
    </div>
</div>