@extends('app')

@section('scripts')
    <script src="{{ asset('vendor/jquery/jquery-1.11.4.ui.min.js'.$common['version_app']) }}" type="text/javascript" async defer></script>
@endsection

@section('content_main')
<div id="process" class="main">
    @foreach($dataConfig as $domain=>$v)
        @if(isset($v['run'])===false || $v['run'])
    <div class="row">
        <div class="col-5">
            {{$domain}}
        </div>
        {{--<div class="col-5">--}}
            {{--<span id="{{str_replace('.','-',$domain)}}">Loading...</span>--}}
        {{--</div>--}}
    </div>
        @endif
    @endforeach
</div>
@endsection


@section('scripts-footer')
    @include('elements.auto-update-coupon-v2')
@endsection