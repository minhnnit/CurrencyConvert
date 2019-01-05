@extends('profile.profile-app')

@section('profile-content')
    <div class="pro-stats clearfix">
        <div class="stats-header">Community</div>
        <div class="com-nav clearfix">
            <ul>
                <li class="{{$subactive['dashboard']}}"><a href="{{url('/profile/community')}}">Dashboard</a></li>
                <li class="{{$subactive['submited']}}"><a href="{{url('/profile/community/submited')}}">Submited</a></li>
                <li class="{{$subactive['help']}}"><a href="./19.profile.FAQs.html">FAQs</a></li>
            </ul>
        </div>
    </div>
    @if($submodule == 'dashboard')
        <div class="information-box">
            <div class="headline-box">TOP 10 - Community Contributors</div>
            <div class="com-most-list clearfix">
                <div class="col-sm-6">
                    <div class="com-most-table">
                        <div class="cm-table-header">
                            <a href="javascript:void(0);" data-toggle="popover" data-placement="top" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?" class="glyphicon glyphicon-info-sign" aria-hidden="true"></a> Most Points
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">1</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">Kansizer212</a></div>
                            <div class="cm-table-cell-points"><strong>5,999</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">2</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">sophiaevans</a></div>
                            <div class="cm-table-cell-points"><strong>50</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">3</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">Lullabysizer</a></div>
                            <div class="cm-table-cell-points"><strong>5,999</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">4</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">RichardSmith</a></div>
                            <div class="cm-table-cell-points"><strong>5,999</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">5</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">Kansizer212</a></div>
                            <div class="cm-table-cell-points"><strong>5,999</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">6</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">sophiaevans</a></div>
                            <div class="cm-table-cell-points"><strong>50</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">7</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">Lullabysizer</a></div>
                            <div class="cm-table-cell-points"><strong>5,999</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">8</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">RichardSmith</a></div>
                            <div class="cm-table-cell-points"><strong>5,999</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">9</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">Kansizer212</a></div>
                            <div class="cm-table-cell-points"><strong>5,999</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">10</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">sophiaevans</a></div>
                            <div class="cm-table-cell-points"><strong>50</strong> points</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="com-most-table">
                        <div class="cm-table-header">
                            <a href="javascript:void(0);" data-toggle="popover" data-placement="top" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?" class="glyphicon glyphicon-info-sign" aria-hidden="true"></a> Most Points
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">1</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">Kansizer212</a></div>
                            <div class="cm-table-cell-points"><strong>5,999</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">2</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">sophiaevans</a></div>
                            <div class="cm-table-cell-points"><strong>50</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">3</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">Lullabysizer</a></div>
                            <div class="cm-table-cell-points"><strong>5,999</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">4</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">RichardSmith</a></div>
                            <div class="cm-table-cell-points"><strong>5,999</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">5</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">Kansizer212</a></div>
                            <div class="cm-table-cell-points"><strong>5,999</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">6</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">sophiaevans</a></div>
                            <div class="cm-table-cell-points"><strong>50</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">7</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">Lullabysizer</a></div>
                            <div class="cm-table-cell-points"><strong>5,999</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">8</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">RichardSmith</a></div>
                            <div class="cm-table-cell-points"><strong>5,999</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">9</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">Kansizer212</a></div>
                            <div class="cm-table-cell-points"><strong>5,999</strong> points</div>
                        </div>
                        <div class="cm-table-row">
                            <div class="cm-table-cell-order">10</div>
                            <div class="cm-table-cell-avatar">
                                <div class="cm-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="cm-username"><a href="#">sophiaevans</a></div>
                            <div class="cm-table-cell-points"><strong>50</strong> points</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="information-box">
            <div class="headline-box">Community Chat</div>
            <div class="com-most-list clearfix">
                <div class="col-sm-6">
                    <div class="cc-most-table">
                        <div class="cc-table-header">Community Chat</div>
                        <div class="cc-chat-box">
                            <form>
                                <textarea class="form-control" placeholder="Your message..."></textarea>
                                <button type="submit" class="btn dbtn btn-submits">Submit</button>
                            </form>
                            <ul class="cc-chat-content autoscroll">
                                <li><span>Lullaby: </span>Anyway, tightfirst, I comment to thanks you and am thanking HERE!</li>
                                <li><span>Lullaby: </span>Anyway, tightfirst, I comment to thanks you and am thanking HERE!</li>
                                <li><span>Lullaby: </span>Anyway, tightfirst, I comment to thanks you and am thanking HERE!</li>
                                <li><span>Lullaby: </span>Anyway, tightfirst, I comment to thanks you and am thanking HERE!</li>
                                <li><span>Lullaby: </span>Anyway, tightfirst, I comment to thanks you and am thanking HERE!</li>
                                <li><span>Lullaby: </span>Anyway, tightfirst, I comment to thanks you and am thanking HERE!</li>
                                <li><span>Lullaby: </span>Anyway, tightfirst, I comment to thanks you and am thanking HERE!</li>
                                <li><span>Lullaby: </span>Anyway, tightfirst, I comment to thanks you and am thanking HERE!</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="wo-most-table clearfix">
                        <div class="wo-table-header">Who's Online?</div>
                        <div class="wo-scroll autoscroll">
                            <div class="wo-table-row">
                                <div class="wo-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                                <div class="wo-user">
                                    <a href="#">Lullabysizer</a>
                                    <div><span>9999</span> points</div>
                                </div>
                            </div>
                            <div class="wo-table-row">
                                <div class="wo-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                                <div class="wo-user">
                                    <a href="#">Lullabysizer</a>
                                    <div><span>9999</span> points</div>
                                </div>
                            </div>
                            <div class="wo-table-row">
                                <div class="wo-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                                <div class="wo-user">
                                    <a href="#">Lullabysizer</a>
                                    <div><span>9999</span> points</div>
                                </div>
                            </div>
                            <div class="wo-table-row">
                                <div class="wo-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                                <div class="wo-user">
                                    <a href="#">Lullabysizer</a>
                                    <div><span>9999</span> points</div>
                                </div>
                            </div>
                            <div class="wo-table-row">
                                <div class="wo-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                                <div class="wo-user">
                                    <a href="#">Lullabysizer</a>
                                    <div><span>9999</span> points</div>
                                </div>
                            </div>
                            <div class="wo-table-row">
                                <div class="wo-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                                <div class="wo-user">
                                    <a href="#">Lullabysizer</a>
                                    <div><span>9999</span> points</div>
                                </div>
                            </div>
                            <div class="wo-table-row">
                                <div class="wo-avatar">
                                    <img src="{{asset('images-demo/avatars/avatar-01.jpg')}}" alt="" />
                                </div>
                                <div class="wo-user">
                                    <a href="#">Lullabysizer</a>
                                    <div><span>9999</span> points</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="information-box">
            <div class="headline-box">Community Chat</div>
            <div class="list-saved clearfix">
                @for($i=1; $i<=12; $i++)
                    <div class="col-md-4 col-sm-6 col-sms-6 box-lsi-item">
                        @if($i % 4 == 0)
                            @include('elements.box-lis-saved-demo4')
                        @elseif($i % 3 == 0)
                            @include('elements.box-lis-saved-demo3')
                        @elseif($i % 2 == 0)
                            @include('elements.box-lis-saved-demo2')
                        @endif
                    </div>
                @endfor
            </div>
        </div>
    @elseif($submodule == 'submited')
        <div class="information-box">
            <div class="headline-box">Your Scorecard</div>
            <div class="com-score-list clearfix">
                <div class="cs-table-row">
                    <div class="cs-tb-title"><i class="fa fa-cart-plus"></i> You’ve Saved Others</div>
                    <div class="cs-tb-value">$0</div>
                </div>
                <div class="cs-table-row">
                    <div class="cs-tb-title"><i class="fa fa-money"></i> Average Saved / Coupon</div>
                    <div class="cs-tb-value">$0.00</div>
                </div>
                <div class="cs-table-row">
                    <div class="cs-tb-title"><i class="fa fa-ticket"></i> Total Coupons Accepted</div>
                    <div class="cs-tb-value">0</div>
                </div>
                <div class="cs-table-row">
                    <div class="cs-tb-title"><i class="fa fa-barcode"></i> Codes</div>
                    <div class="cs-tb-value">$0</div>
                </div>
                <div class="cs-table-row">
                    <div class="cs-tb-title"><i>%</i> Sales</div>
                    <div class="cs-tb-value">0</div>
                </div>
                <div class="cs-table-row">
                    <div class="cs-tb-title"><i class="fa fa-print"></i> Printables</div>
                    <div class="cs-tb-value">0</div>
                </div>
                <div class="cs-table-row">
                    <div class="cs-tb-title"><i class="fa fa-star"></i> Thanks Your Received</div>
                    <div class="cs-tb-value">0</div>
                </div>
                <div class="cs-table-row">
                    <div class="cs-tb-title"><i class="fa fa-comments"></i> Comments</div>
                    <div class="cs-tb-value">0</div>
                </div>
                <div class="cs-table-row">
                    <div class="cs-tb-title"><i class="fa fa-thumbs-o-up"></i> Yes Votes</div>
                    <div class="cs-tb-value">0</div>
                </div>
                <div class="cs-table-row">
                    <div class="cs-tb-title"><i class="fa fa-thumbs-o-down fa-flip-horizontal"></i> No Votes</div>
                    <div class="cs-tb-value">0</div>
                </div>
            </div>
        </div>
        <div class="information-box">
            <div class="headline-box">Recently Submitted Coupon</div>
            <div class="list-saved clearfix">
                @for($i=1; $i<=12; $i++)
                    <div class="col-md-4 col-sm-6 col-sms-6 box-lsi-item">
                        @if($i % 4 == 0)
                            @include('elements.box-lis-saved-demo4')
                        @elseif($i % 3 == 0)
                            @include('elements.box-lis-saved-demo3')
                        @elseif($i % 2 == 0)
                            @include('elements.box-lis-saved-demo2')
                        @else
                            @include('elements.box-lis-saved-demo1')
                        @endif
                    </div>
                @endfor
            </div>
            <div class="title-sub-yet text-center">You haven't submitted any coupons yet.</div>
            <div class="cs-btn-submit-line text-center">
                <button type="button" class="black-button" data-toggle="modal" data-target="#submitCodeModal"><i class="fa fa-plus-circle"></i> Submit a Voucher</button>
            </div>
        </div>
    @endif
@endsection