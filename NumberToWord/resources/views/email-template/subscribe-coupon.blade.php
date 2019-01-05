@extends('email-template.main-tmp')
@section('content')
    <table class="mail-body" cellpadding="0" cellspacing="0" border="0" width="600px" align="center" style="margin:10px auto; width:600px;">
        <tr class="header-ads">
            <td style="text-align:center; vertical-align:bottom;" background="{{ asset('images/email-tmp/banner-600x260/save-now.jpg') }}" height="260px">
                <a href="{{$link . '&type=email'}}" style="background-color:#a85dc2; border-radius:2px; padding:15px 100px; font-size:16px; font-weight:bold; color:#fff; display:inline-block; margin-bottom:60px; text-decoration:none;">Get {{config('config.Coupon')}}</a>
            </td>
        </tr>
        <tr class="content-ads">
            <td>
                <h3 style="color:#333; padding:15px 0 0;">{{$coupon['title']}} </h3>
                @if(!empty($coupon['expire_date']))
                <p style="color:#999; font-style:italic; padding:10px 0; text-align:justify; line-height:22px; font-size:14px;">Expire: {{date_format($coupon['expire_date'],"d M Y")}}</p>
                @endif
                <p style="padding:10px 0; text-align:justify; color:#666; line-height:22px; font-size:14px;">{{$coupon['description']}}</p>
            </td>
        </tr>
        @if(!empty($hotCoupons))
        <tr class="voucher-title">
            <td style="padding:15px 0;">
                <h2 style="border-top: 1px solid #dfdfdf; border-bottom:1px solid #dfdfdf; padding:5px; color:#333; text-align:center; ">HOT {{config('config.COUPON')}}</h2>
            </td>
        </tr>
        <tr class="voucher-box">
            <td>
                <table class="hot-voucher-box" style="border:10px solid #e7e5e5; padding:10px 0;" cellpadding="0" cellspacing="0" border="0" width="600px">
                    @foreach($hotCoupons as $index => $c)
                        @if($index >= 4) @break @endif
                        @if($index % 2 === 0)
                            <tr>
                        @endif
                        @if(strtolower($c['coupon_type']) === 'coupon code')
                            <td style="padding:10px 10px;color: #31a65b">
                        @elseif(strtolower($c['coupon_type']) === 'great offer')
                            <td style="padding:10px 10px;color: #d65b5b">
                        @else
                            <td style="padding:10px 10px;color: #5cb7ce">
                        @endif
                            <div class="box-item-small code" style="height:100px; padding:10px; background-color:#e7e5e5;">
                                <div style="border-radius:2px; background-color:#fff;display:table-cell; width:100px; height:100px;">
                                    <img src="{{ $c['s_logo'] }}" style="width:100px; height:auto; max-height: 100px; margin:auto;" alt="{{$c['s_name']}}"/></div>
                                <div class="percen" style="display:table-cell; vertical-align:middle; font-size:20px;text-transform:uppercase; text-align:center;">
                                    @if(strtolower($c['coupon_type']) === 'coupon code' || !empty($c['discount']))
                                        <span style="font-size:55px; font-weight:lighter;">{{$c['discount']}}<sup style="font-size:22px;">{{$c['currency']}}</sup></span> Discount
                                    @elseif(strtolower($c['coupon_type']) === 'great offer')
                                        <span style="font-size:30px; font-weight:lighter;">Great</span> Offer
                                    @else
                                        <span style="font-size:30px; font-weight:lighter;">Free</span> {{config('config.Shipping')}}
                                    @endif
                                </div>
                            </div>
                            <p style="font-size:13px; padding:15px 0; line-height:20px; font-weight:bold;"><a style="color:#000; text-decoration:none;" href="{{url('/' . $c['s_alias'] . config('config.suffix_coupon'))}}" target="_blank">Ultra-Handy 10-Ft Micro USB Cable, 2 Pack <span class="hilight" style="color:#0cb71b;">(40% off)</span></a></p>
                        </td>
                        @if($index % 2 === 1)
                            </tr>
                        @endif
                    @endforeach
                </table>
            </td>
        </tr>
        @endif
        @if(!empty($lastCoupons))
        <tr class="voucher-title">
            <td style="padding:15px 0;">
                <h2 style="border-top: 1px solid #dfdfdf; border-bottom:1px solid #dfdfdf; padding:5px; color:#333; text-align:center; ">LATEST {{config('config.COUPON')}}</h2>
            </td>
        </tr>
        <tr>
            <td>
                <table class="list-lg" style="width:600px; margin:auto;">
                    @foreach($lastCoupons as $index => $s)
                        @if($index >= 4) @break @endif
                        @if($index % 2 === 0)
                            <tr>
                                <td style="text-align:left;padding:10px 0;">
                        @else <td style="text-align:right;padding:10px 0;">
                        @endif
                            <div class="box-item-lg" style="width:230px; height:400px; border:1px solid #dfdfdf; border-radius:2px; padding:25px; text-align:center; display:inline-block;">
                                <div class="image-auto" style="display:inline-block; width:200px; height:200px;">
                                    <img src="{{$s['logo']}}" style="max-width:100%; max-height:100%; width:auto; height:auto; top:0; right:0; bottom:0;left:0; position:absolute; margin:auto;" width="150" height="147"  alt="{{$s['name']}}"/>
                                </div>
                                <div class="percen-lg" style="">
                                    @if(strtolower($s['coupons'][0]['type']) === 'coupon code' || !empty($c['discount']))
                                    <div style="color: #0cb71b;{{!empty($s['coupons'][0]['exclusive']) ? 'background-image:url("'.asset('images/email-tmp/exclusive.png').'");' : ''}}float:left;width:100px; height:88px; border:1px dashed #dfdfdf; border-radius:2px;text-align:center;font-size:16px; text-transform:uppercase; overflow:hidden;padding-top:12px; background-position:left top; background-repeat:no-repeat;">
                                        <strong style="font-size:40px; font-weight:lighter;">{{$s['coupons'][0]['discount']}}<sup style="font-size:20px;">{{$s['coupons'][0]['currency']}}</sup></strong> Discount
                                    @elseif(strtolower($s['coupons'][0]['type']) === 'great offer')
                                    <div style="color: #d65b5b;{{!empty($s['coupons'][0]['exclusive']) ? 'background-image:url("'.asset('images/email-tmp/exclusive.png').'");' : ''}}float:left;width:100px; height:88px; border:1px dashed #dfdfdf; border-radius:2px;text-align:center;font-size:16px; text-transform:uppercase; overflow:hidden;padding-top:12px; background-position:left top; background-repeat:no-repeat;">
                                        <strong style="font-size:30px; font-weight:lighter;">Great</strong> Offer
                                    @else
                                    <div style="color: #5cb7ce;{{!empty($s['coupons'][0]['exclusive']) ? 'background-image:url("'.asset('images/email-tmp/exclusive.png').'");' : ''}}float:left;width:100px; height:88px; border:1px dashed #dfdfdf; border-radius:2px;text-align:center;font-size:16px; text-transform:uppercase; overflow:hidden;padding-top:12px; background-position:left top; background-repeat:no-repeat;">
                                        <strong style="font-size:30px; font-weight:lighter;">Free</strong> {{config('config.Shipping')}}
                                    @endif
                                    </div>
                                    @if(strtolower($s['coupons'][1]['type']) === 'coupon code' || !empty($c['discount']))
                                        <div style="color: #0cb71b;{{!empty($s['coupons'][1]['exclusive']) ? 'background-image:url("'.asset('images/email-tmp/exclusive.png').'");' : ''}}float:right;width:100px; height:88px; border:1px dashed #dfdfdf; border-radius:2px;text-align:center;font-size:16px; text-transform:uppercase; overflow:hidden;padding-top:12px; background-position:left top; background-repeat:no-repeat;">
                                            <strong style="font-size:40px; font-weight:lighter;">{{$s['coupons'][1]['discount']}}<sup style="font-size:20px;">{{$s['coupons'][1]['currency']}}</sup></strong> Discount
                                    @elseif(strtolower($s['coupons'][1]['type']) === 'great offer')
                                        <div style="color: #d65b5b;{{!empty($s['coupons'][1]['exclusive']) ? 'background-image:url("'.asset('images/email-tmp/exclusive.png').'");' : ''}}float:right;width:100px; height:88px; border:1px dashed #dfdfdf; border-radius:2px;text-align:center;font-size:16px; text-transform:uppercase; overflow:hidden;padding-top:12px; background-position:left top; background-repeat:no-repeat;">
                                            <strong style="font-size:30px; font-weight:lighter;">Great</strong> Offer
                                    @else
                                        <div style="color: #5cb7ce;{{!empty($s['coupons'][1]['exclusive']) ? 'background-image:url("'.asset('images/email-tmp/exclusive.png').'");' : ''}}float:right;width:100px; height:88px; border:1px dashed #dfdfdf; border-radius:2px;text-align:center;font-size:16px; text-transform:uppercase; overflow:hidden;padding-top:12px; background-position:left top; background-repeat:no-repeat;">
                                            <strong style="font-size:30px; font-weight:lighter;">Free</strong> {{config('config.Shipping')}}
                                    @endif
                                    </div>
                                </div>
                                <div class="item-title" style="min-height:62px;display:block; clear:both; text-align:left; padding-top:20px; font-size:13px; line-height:20px; font-weight:bold;">{{$s['coupons'][0]['title']}}</div>
                                <div class="item-btn" style="padding:15px 0; text-align:left;"><a href="{{url('/' . $s['alias'] . config('config.suffix_coupon'))}}" target="_blank" class="btn-getcode" style="background-image:url('{{asset('images/email-tmp/btn-bg.png')}}');width:142px; height:30px; font-weight:lighter; color:#fff; display:inline-block; text-align:center; text-decoration:none; text-transform:uppercase; line-height:30px; font-size:14px;">Get Code</a></div>
                            </div>
                        </td>
                        @if($index % 2 === 1)
                            </tr>
                        @endif
                    @endforeach
                </table>
            </td>
        </tr>
        @endif
    </table>
@endsection