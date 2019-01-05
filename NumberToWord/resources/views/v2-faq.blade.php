{{-- */$seoConfig['title'] = $title . ' - ' . config('config.domain');/* --}}
@extends('app')

@section('before-header')
    @include('elements.submitCodeForm')
@endsection

@section('content')
    <div class="container">
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
    <div class="faq-body">
        <div class="container" >
            <div class="row page-boxer">
                <h3 class="lsi-header"><span>{{$title}}</span></h3>
                <div class="faq-box-default clearfix" >
                    @foreach($faqGroup as $i => $g)
                    <div class="faq-group">
                        <h3 class="faq-group-header">{{$g['g_name']}}</h3>
                        <div class="fqa-group-content">
                            <ul class="cash-helper" id="cash-helper-{{$i}}" role="tablist" aria-multiselectable="true">
                                @foreach($g['faq_items'] as $j => $q)
                                    @if($q['type'] == 'text')
                                    <li class="panel">
                                        <div role="tab" id="heading-{{$i . '-' . $j}}">
                                            <a class="label-controls collapsed" href="#{{$i . '-' . $j . '-' .$q['id']}}" id="{{$q['id']}}" role="button" data-toggle="collapse" data-parent=".cash-helper"
                                               aria-expanded="false">{{$q['question']}}</a>
                                        </div>
                                        <div id="{{$i . '-' . $j . '-' .$q['id']}}" class="collapse" role="tabpanel" aria-labelledby="heading-{{$i . '-' . $j}}">
                                            <div class="answer-content">
                                                {!!html_entity_decode($q['answer'])!!}
                                            </div>
                                        </div>
                                    </li>
                                    @else
                                    <li class="panel">
                                        <a class="label-controls collapsed" href="{{$q['answer']}}" target="_faq-helper">{{$q['question']}}</a>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection