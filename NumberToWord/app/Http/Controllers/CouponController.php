<?php
/**
 * Created by PhpStorm.
 * User: Phuong
 * Date: 6/9/2015
 * Time: 1:53 PM
 */

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request as Re;
use App\Libraries\ReCaptcha;

class CouponController extends Controller
{
    public function top20Coupon()
    {
        $data = $this->_submitHTTPGet(config('config.api_url') . 'coupons/getTopCoupons2/', [
            'c_location' => config('config.location')
        ]);
        $data['seoConfig']['title'] = 'Free '.config('config.coupon').' codes online : Top of the best online '.config('config.coupon').' code in a day';
        $data['seoConfig']['desc'] = 'Get discounts with coupon and promo codes for thousands of online stores. We hand pick the best sales, promo codes, online & coupons for you.';
        return view('top20VoucherCode')->with($data);
    }

    public function top20FreeDelivery()
    {
        $data = $this->_submitHTTPGet(config('config.api_url') . 'coupons/getTopFreeShipping2/', [
            'c_location' => config('config.location')
        ]);
        return view('freeDelivery')->with($data);
    }

    public function submitCoupon(Re $request)
    {
        /*
        Edited by HaiHT
        */
        if ($request->isMethod('post')) {
            $rs = [];
            $reCaptcha = new ReCaptcha();
            $reCaptcha->ReCaptcha(config('config.reCapcha_secret_key'));
            $data = $request->all();
            // Ignore google captcha
            // if ($_POST["g-recaptcha-response"] || 1) {
            if ($_POST["g-recaptcha-response"]) {
                $data['c_location'] = config('config.location');
                $data['go'] = $this->_getToken(6);
                $data['author'] = $request->session()->get('user.id');
                if(!$data['author']){
                    $data['author'] = '';
                }
                $result = $this->_submitHTTPPost(config('config.api_url') . 'coupons/new/', $data);
                if($result == false){
                    $rs = ['status' => 'error', 'msg' => 'Error'];
                }else{
                    $rs = ['status' => 'success', 'msg' => $result];
                }
                return response()->json($rs);
            } else {
                $response = ['status' => 'error', 'msg' => 'Please enter Captcha code!'];
            }
            return response()->json($response);
        }
        return response()->json(['status' => 'error','msg' => 'Error!', 'detail' => 'Method GET not allowed']);
    }

}