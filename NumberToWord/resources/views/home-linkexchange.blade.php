@extends('app')

@section('before-header')
    @include('elements.submitCodeForm')
@endsection
@section('content_main')
    <div class="container">
        <div class="main main-linkexchange">
            <h1>{{$header}}</h1>
            <div class="top-text">
                {!! html_entity_decode($header_desc) !!}
            </div>
            <div class="row box">
                @foreach ($element as $s)
                    @include('element-exchange.linkexchange-box')
                @endforeach
            </div>
        </div>
    </div>
@endsection
