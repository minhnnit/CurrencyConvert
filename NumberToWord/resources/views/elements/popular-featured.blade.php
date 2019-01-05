
<div class="main featured-stores">
    <div class="center-block"><h1 class="under-title">Featured Stores</h1></div>
<div class="content">
        @foreach ($featured as $k=>$st)
            @if($k%6===0)<div class="row rlink">@endif
                <?php $title_link = str_ireplace(' Coupons','',$st['name']); $title_link = isset($title_link{20})?substr($title_link,0,17).'...':$title_link;?>
                <div class="col-md-5 col-sm-5 col-lg-4 col-xl-2">
                    <a href="{{url('/' . $st['alias'])}}" title="{{ $st['name'] }}">{{$title_link}}</a>
                </div>
                <?php $k++;?>@if($k%6===0)</div>@endif
        @endforeach
</div>
</div>
