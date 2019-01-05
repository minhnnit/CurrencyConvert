<?php
/**
 * Created by PhpStorm.
 * User: Phuong
 * Date: 6/15/2015
 * Time: 4:53 PM
 */

namespace App\Http\Controllers;


use Auth;
use Illuminate\Http\Request;
use App\Libraries\ReCaptcha;
use Session;

class CommentController extends Controller
{

    public function postComment(Request $request)
    {
        if ($request->isMethod('post')) {
            $reCaptcha = new ReCaptcha();
            $reCaptcha->ReCaptcha(config('config.reCapcha_secret_key'));
            if ($_POST["g-recaptcha-response"]) {
                $data = $request->all();
                if (!empty($data['cmt1']) && !empty($data['cmt2'])) {
                    $data['content'] = 'Saved ' . $data['cmt1'] . ' on ' . $data['cmt2'];
                } else $data['content'] = $data['cmt3'];
                if (!empty($data['content'])) {
                    if (Auth::check()) {
                        $data['fullname'] = Auth::user()->getAttribute('fullname');
                        $data['user_id'] = $request->session()->get('user.id');
                    }else {
                        $data['user_id'] = '';
                        $data['fullname'] = 'anonymous';
                    }
                    if (!empty($data['location']) && $data['location']) {
                        $data['countrycode'] = Session::get('geoip-location')['isoCode'];
                        $data['cityCode'] = Session::get('geoip-location')['city'];
                    }else {
                        $data['countrycode'] = '';
                        $data['cityCode'] = '';
                    }
                    if (!empty($data['couponId'])) {
                        $check = $this->_submitHTTPGet(config('config.api_url') . 'comments/commentCoupon/'. $data['couponId'] . '/', [
                            'content' => base64_encode(htmlentities($data['content'])),
                            'userId' => $data['user_id'],
                            'countrycode' => $data['countrycode'],
                            'cityCode' => $data['cityCode'],
                            'fullname' => $data['fullname'],
                            'type' => $data['type']
                        ]);
                    } elseif (!empty($data['dealId'])) {
                        $check = $this->_submitHTTPGet(config('config.api_url') . 'comments/commentDeal/' . $data['dealId'] . '/', [
                            'content' => base64_encode(htmlentities($data['content'])),
                            'userId' => $data['user_id'],
                            'countrycode' => $data['countrycode'],
                            'cityCode' => $data['cityCode'],
                            'fullname' => $data['fullname'],
                            'type' => $data['type']
                        ]);
                    }
                }
                if (!empty($check)) {
                    return response()->json(['status' => 'success']);
                } else  return response()->json(['status' => 'error',
                    'msg' => 'There was an error encountered, please try again later.']);
            }else {
                $response = ['status' => 'error',
                    'msg' => 'Please enter Captcha code!'];
                return response()->json($response);
            }
        }
    }

    public function getComment(Request $request)
    {
        if ($request->isMethod('get')) {
            $data = $request->all();
            $limit = 20;
            if (!empty($data['limit'])) $limit = $data['limit'];
            $check = $this->_submitHTTPGet(config('config.api_url') . 'comments/', [
                'where[coupon_id]' => $data['coupon_id'],
                'where[status]' => 'published',
                'order[column]' => 'created_at',
                'order[dir]' => 'DESC',
                'limit' => $limit
            ]);
            if (!empty($check)) {
                return response()->json([
                    'status' => 'success',
                    'data' => $check
                ]);
            } else  return response()->json(['status' => 'error','data' => $check]);
        }
    }

    public function getCommentDeal(Request $request)
    {
        if ($request->isMethod('get')) {
            $data = $request->all();
            $check = $this->_submitHTTPGet(config('config.api_url') . 'comments/', [
                'include[users][attribute][]'=>'fullname',
                'where[deal_id]' => $data['deal_id'],
                'where[status]' => 'published'
            ]);
            if (!empty($check)) {
                return response()->json([
                    'status' => 'success',
                    'data' => $check
                ]);
            } else  return response()->json(['status' => 'error','data' => $check]);
        }
    }
}