<?php 
$domain_lower = $GLOBALS['domain_lower'];
$domain_upper = $GLOBALS['domain_upper'];
$asset_domain = $GLOBALS['asset_domain'];
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ !empty($seo['title']) ? $seo['title'] : '' }}</title>
    @if(config('config.dev_mode'))
        <link href="{{ asset('vendor/bootstrap-3.3.4-dist/css/bootstrap.min.css'.$common['version_app']) }}" rel="stylesheet" type='text/css' />
        <link href="{{ asset('css/sass/app.css')}}" rel="stylesheet" type='text/css' />
        <link href="{{ asset('vendor/flexslider/css/flexslider.min.css'.$common['version_app']) }}" rel="stylesheet" type='text/css'/>
        <script src="{{ asset('vendor/jquery/jquery-1.11.3.min.js'.$common['version_app']) }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/bootstrap-3.3.4-dist/js/bootstrap.min.js'.$common['version_app']) }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/flexslider/js/jquery.flexslider-min.js'.$common['version_app']) }}" type="text/javascript"></script>
    @else
        <link href="{{ asset('static/css/frontend.min.css') }}" rel="stylesheet" type='text/css' />
        <link href="{{ asset('vendor/flexslider/css/flexslider.min.css'.$common['version_app']) }}" rel="stylesheet" type='text/css'/>
        <script src="{{ asset('vendor/jquery/jquery-1.11.3.min.js'.$common['version_app']) }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/bootstrap-3.3.4-dist/js/bootstrap.min.js'.$common['version_app']) }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/flexslider/js/jquery.flexslider-min.js'.$common['version_app']) }}" type="text/javascript"></script>
    @endif
    <meta name="title" content="{{ !empty($seo['metaTitle']) ? $seo['metaTitle'] : '' }}">
    <meta name="description" content="{{ !empty($seo['metaDescription']) ? $seo['metaDescription'] : '' }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style> .scholar-title {margin-top:10px !important;margin-bottom: 10px !important;}</style>
</head>
<body>
<div class="base col-xs-12 container container-scholarship npdlr">
    <div class="child-container npdlr clearfix">
        <div class="head col-xs-12 npdlr">
            <div class="col-xs-12 logo">
                <p>
                    <a href="{{ url('/') }}"><img src="{{asset('/images/'.$GLOBALS['asset_domain'].'/logo.png')}}" ></a>
                </p>
            </div>
            <p class="p-0">
                <span class="green">$3000</span> {{ config('domains.' . $GLOBALS['asset_domain'])['scholarship']['siteName'] }} SCHOLARSHIP
            </p>
            <p class="p-1 text-block">
                Saving money is always a hot subject. {{ config('domains.' . $GLOBALS['asset_domain'])['scholarship']['siteName'] }} - a website which offers the latest coupons and discount codes for plenty of stores to help you get money off any purchases when shopping online.
                <br>And now in order to help cover part of your tuition fees, we want to offer a scholarship, any student can apply. We are looking for a candidate who can meet our requirements.
            </p>
            <div class="button-box">
                <a target="_blank" rel="nofollow" href="{{ config('domains.' . $GLOBALS['asset_domain'])['scholarship']['googleForm'] }}" class="btn-apply">
                    Click here to Submit
                </a>
            </div>
        </div>
    </div>

    <div class="container-2 npdlr clearfix">
        <div class="child-container-2 text-block">
            <p class="dog-image">
                <img src="{{ asset('/images/saveonomics@2x.png') }}">
            </p>
            <h3>{{ config('domains.' . $GLOBALS['asset_domain'])['scholarship']['siteName'] }} “Save for Future” Scholarship</h3>
            <div class="box-content">
                <b>$3000</b> scholarship will be awarded to only one student from anywhere around the world (US, UK, Canada, Australia, Singapore, Vietnam,...) to help him/her pay for his/her education. Just by applying for this scholarship, you’re already off to a great start!
            </div>
            <h4>Steps to apply</h4>
            <div class="box-content">
                <ul>
                    <li>Fill out the required form.</li>
                    <li>Make an essay about how you can save money in your daily life. You should focus on saving tips. If your ideas are unique and helpful, you will get higher chances to win this scholarship.</li>
                    <li>Submit your application when you’ve finished.</li>
                </ul>
            </div>
            <h4>Application deadline</h4>
            <div class="box-content">Candidates must submit their applications by <b>December 31, 2018</b></div>
            <p class="submit-form"><a target="_blank" href="{{ !empty($googleForm) ? $googleForm : '#' }}">>> SUBMIT YOUR APPLICATION HERE <<</a></p>
        </div>

        <div class="child-container-2 text-block">
            <h3>Application Requirements</h3>
            <div class="box-content">
                <ul>
                    <li>This scholarship is applicable to students worldwide.</li>
                    <li>You must submit your application by December 31, 2018.</li>
                    <li>You must answer all required questions in our application form.</li>
                    <li>Only 1 application per person</li>
                </ul>
                <div class="box-content">
                    Submitted materials will be under {{ config('domains.' . $GLOBALS['asset_domain'])['scholarship']['siteName'] }} ownership and will not be returned. View complete:
                    <a target="_blank" href="{{ config('domains.' . $GLOBALS['asset_domain'])['scholarship']['officalRules'] }}">Official Rules >></a>
                </div>
                <div class="box-content">Note: If you have any questions or issues please email <a>{{ config('domains.' . $GLOBALS['asset_domain'])['scholarship']['emailContact'] }}</a></div>
                <h4>How to win</h4>
                Your submission will be judged by the following criteria:
                <ul>
                    <li>Completeness of Submission <b>(10%)</b></li>
                    <li>Quality of your submission <b>(40%)</b></li>
                    <li>Uniqueness and practicality of your ideas <b>(50%)</b></li>
                </ul>
            </div>
        </div>

        {{--slide comments--}}
        <div class="child-container-2 text-block last">
            <h3>About {{ config('domains.' . $GLOBALS['asset_domain'])['scholarship']['siteName'] }}  “Save for Future” Scholarship</h3>
            <div class="flexslider-scholarship flexslider">
                <ul class="slides">
                    <li>
                        <div class="sld">
                            <p class="comment">“ Thanks {{ config('domains.' . $GLOBALS['asset_domain'])['scholarship']['siteName'] }} for sharing this scholarship with us ”</p>
                            <p class="author"><a target="_blank" href="https://wit.edu" rel="nofollow">Wentworth Institute of Technology</a></p>
                        </div>
                    </li>
                    <li>
                        <div class="sld">
                            <p class="comment">“ Hope you will have more scholarships for students who have financial difficulties ”</p>
                            <p class="author"><a target="_blank" href="http://www.bu.edu" rel="nofollow">University of Boston</a></p>
                        </div>
                    </li>
                    <li>
                        <div class="sld">
                            <p class="comment">“ Students from Hanoi can apply for this scholarship. It will help you a lot ”</p>
                            <p class="author"><a target="_blank" href="https://en.hust.edu.vn/home" rel="nofollow">Hanoi University of Science and Technology</a></p>
                        </div>
                    </li>
                    <li>
                        <div class="sld">
                            <p class="comment">“ Join to get this $3000 scholarship to relieve the burden of your family ”</p>
                            <p class="author"><a target="_blank" href="http://www.sp.edu.sg" rel="nofollow">Singapore Polytechnic</a></p>
                        </div>
                    </li>
                    <li>
                        <div class="sld">
                            <p class="comment">“ A great chance to reduce your tuition fees. Many thanks to {{ config('domains.' . $GLOBALS['asset_domain'])['scholarship']['siteName'] }} ”</p>
                            <p class="author"><a target="_blank" href="https://www.rau.ac.uk" rel="nofollow">Royal Agricultural University</a></p>
                        </div>
                    </li>
                    <li>
                        <div class="sld">
                            <p class="comment">“ Concordia University appreciates that {{ config('domains.' . $GLOBALS['asset_domain'])['scholarship']['siteName'] }} has offered this financial assistance to students who have financial problems. ”</p>
                            <p class="author"><a target="_blank" href="https://www.concordia.ca" rel="nofollow">Concordia University</a></p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        {{--Popular stores--}}
        @if(!empty($popularStores))
            <div class="text-block popular-stores">
                @include('elements.popular-stores')
            </div>
        @endif
</div>
</div>
<script>
    $(document).ready(function () {
        $('.flexslider-scholarship').flexslider({
            animation: "slide"
        });
    });
</script>
@include('enter-elements.footer')