{{-- */$seoConfig['title'] = $title . ' - ' . config('config.domain');/* --}}
@extends('app')

@section('content_main')
    <div class="main">
        <ol class="cd-breadcrumb custom-separator" itemscope itemtype="http://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope
                itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="{{url('/')}}">
                    <span itemprop="name">Home</span></a>
                <meta itemprop="position" content="1" />
            </li>
            <li class="current" itemprop="itemListElement" itemscope
                itemtype="http://schema.org/ListItem">
                <em itemprop="name">{{$title}}</em>
                <meta itemprop="position" content="3" />
            </li>
        </ol>
    </div>
    <div class="show-page-text">
        <div class="container" >
            <div class="page-boxer">
                <h3 class="lsi-header"><span>{{$title}}</span></h3>
                <div class="row body-page-boxer clearfix" >
                    {!!html_entity_decode($docValue)!!}
                </div>
            </div>
        </div>
    </div>
@endsection