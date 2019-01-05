<?php
/**
 * Created by PhpStorm.
 * User: Phuong
 * Date: 6/10/2015
 * Time: 11:10 AM
 */

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request as Re;
use Session;
use Storage;


class UserController extends Controller
{

    public function register(Re $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if (empty($data['email'])) return response()->json(['status' => 'error!email is empty']);
            $data['isSocial'] = 0;
            $data['domain'] = $this->getDomain();
            $data['c_location'] = config('config.location');
            $data['emailBody'] = view('email-template.mail-render',[
                'content' => 'Thank you for register at '. $data['domain'] .'<p>To active your account, please click below button.</p>',
                'button' => [
                    'link' => url('/user/active-account/') .'?token=[[ token ]]',
                    'text' => 'Active Your Account'
                ]
            ])->render();
            $data['go'] = $this->_getToken(6);
            $check = $this->_submitHTTPPost(config('config.api_url') . 'users/registerV2', $data);
//            id: "e2b05e44-ff96-4e0e-90c9-c83c4cf74ade"
//            message: "Register account successfully"
//            status: 200
//            type: "success"
            if ($check['type'] == 'success') {
                Session::put('user.id', $check['id']);
                if (!empty($data['avatar'])) {
                    $fileUpload = $data['avatar'];
                    $pos  = strpos($fileUpload, ';');
                    $mime_type = explode(':', substr($fileUpload, 0, $pos))[1];
                    //input a row into the database to track the image (if needed)
                    $image = [
                        'id' => $check['id'],
                        'ext' => str_replace('image/','',$mime_type)
                    ];

                    //Use some method to generate your filename here. Here we are just using the ID of the image
                    $filename = $image['id'] . '-avatar';
                    list($type, $fileUpload) = explode(';', $fileUpload);
                    list(, $fileUpload)      = explode(',', $fileUpload);
                    $data = base64_decode($fileUpload);
                    //Push file to S3
                    Storage::disk('s3')->put($filename, $data, 'public');
                    $bucket = config('filesystems.disks.s3.bucket');
                    $s3 = Storage::disk('s3');
                    $avatarUrl = $s3->getDriver()->getAdapter()->getClient()->getObjectUrl($bucket, $filename);
                    $result = $this->_submitHTTPPost(config('config.api_url') . 'users/update/', [
                        'id' => $check['id'],
                        'avatar' => $avatarUrl
                    ]);
                }
            }
            return response()->json($check);
        }
    }

    public function activeAcc(Re $request)
    {
        $data = $request->all();
        $result = $this->_submitHTTPPost(config('config.api_url') . 'users/activeAccount', [
            'token' => $data['token'],
            'domain' => $this->getDomain(),
            'emailBody' => view('email-template.mail-render',['content' => 'Your account has been activated. Now, you can click <a href="'.url('/login').'">'
                .url('/login').'</a> to login.'])->render()
        ]);
        if ($result == 'true') {
            if (!empty($data['ref']))
                return view('auth/active', ['msg' => 'Your account were activated.','token' => $data['token']]);
            else
            return view('auth/active', ['msg' => 'Your account were activated.']);
        }
        return view('auth/active', ['msg' => $result['message']]);
    }

    public function subscribeHome(Re $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $this->_submitHTTPPost(config('config.api_url') . 'subscribes/new/subscribeHome/', [
                'email' => strtolower($data['email']),
                'domain' => $this->getDomain(),
                'c_location' => config('config.location'),
                'go' => $this->_getToken(6)
            ]);
            return response()->json(['status' => 'success']);
        }
    }

    public function subscribeStore(Re $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $data['isSocial'] = 0;
            $data['domain'] = $this->getDomain();
            $data['go'] = $this->_getToken(6);
//            $data['c_location'] = config('config.location');
//            $data['emailBody'] = view('email-template.mail-render',[
//                'content' => 'Thank you for register at '. $data['domain'] .'<p>To active your account, please click below button.</p>',
//                'button' => [
//                    'link' => url('/user/active-account/') .'?token=[[ token ]]&ref=subscribeStore',
//                    'text' => 'Active Your Account'
//                ]
//            ])->render();
//            $this->_submitHTTPPost(config('config.api_url') . 'users/register', $data);

            $result = $this->_submitHTTPPost(config('config.api_url') . 'subscribes/new/subscribeStore/', [
                'email' => strtolower($data['email']),
                'storeId' => $data['storeId'],
                'domain' => $data['domain'],
                'c_location' => config('config.location'),
                'go' => $data['go']
            ]);
            return response()->json(['status' => $result]);
        }
    }

    public function subscribeCategory(Re $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $this->_submitHTTPPost(config('config.api_url') . 'subscribes/new/subscribeCategory/', [
                'email' => strtolower($data['email']),
                'categoryId' => $data['categoryId'],
                'domain' => $this->getDomain(),
                'c_location' => config('config.location'),
                'go' => $this->_getToken(6)
            ]);
            return response()->json(['status' => 'success']);
        }
    }

    public function emailExists(Re $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $check = $this->_submitHTTPGet(config('config.api_url') . 'users/', [
                'where[email]' => $data['email'],
                'attributes[]' => 'id'
            ]);
            if (!empty($check)) {
                return response()->json(['status' => 'Exists']);
            } else  return response()->json(['status' => 'Not Exists']);
        }
        return response()->json(['status' => 'Exists']);
    }

    public function forgotPass(Re $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $result = $this->_submitHTTPPost(config('config.api_url') . 'users/lostPassword/', [
                'email' => strtolower($data['email']),
                'domain' => url('/'),//$this->getDomain()
                'emailBody' => view('email-template.reset-password')->render()
            ]);
            if (!empty($result['error'])) return response()->json(['status' => 'error', 'msg' => $result['message']]);
            return response()->json(['status' => 'success']);
        }
        return view('auth/password');
    }

    public function resetPass(Re $request)
    {
        $data = $request->all();
        if ($request->isMethod('post')) {
            $data = $request->all();
            $result = $this->_submitHTTPPost(config('config.api_url') . 'users/lostPassword/addNewPassword/', [
                'token' => $data['token'],
                'domain' => $this->getDomain(),
                'password' => $data['password'],
                'password_confirmation' => $data['password_confirmation'],
                'emailBody' => view('email-template.mail-render',['content' => 'Your password changed successfully. You can login now: <a href="'.url('/login').'">'.url('/login').'</a>'])->render()
            ]);
            if (!empty($result['message'])) {
                return view('auth/reset', [
                    'errors' => [$result['message']],
                    'token' => $data['token']
                ]);
            }else {
                Session::flash('msg', 'Change password successful! You can login now.');
                return redirect('/login');
            }
        }
        return view('auth/reset', $data);
    }

    public function saveAndFavourite(Re $request){
        if ($request->isMethod('get') && Auth::check()) {
            $data = $request->all();
            $data['user_id'] = $request->session()->get('user.id');
            $check = $this->_submitHTTPGet(config('config.api_url') . 'favourites/'.$data['type'].'/'.$data['user_id'].'/'.$data['object_id'].'/', []);
            if (!empty($check)) {
                return response()->json(['status' => 'success']);
            } else  return response()->json(['status' => 'error']);
        }
    }

    public function likeAction(Re $request){
        if ($request->isMethod('get') && Auth::check()) {
            $data = $request->all();
            $data['user_id'] = $request->session()->get('user.id');
            $check = $this->_submitHTTPGet(config('config.api_url') . 'likes/'.$data['type'].'/'.$data['user_id'].'/'.$data['object_id'].'/', []);
            if (!empty($check)) {
                return response()->json(['status' => 'success']);
            } else  return response()->json(['status' => 'error']);
        }
    }

    public function sendEmail(Re $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if (!empty($data['couponId'])) {
                $coupon = $this->_submitHTTPGet(config('config.api_url') . 'coupons/',[
                    'where[id]' => $data['couponId'],
                    'findType' => 'findOne'
                ]);
                if (!empty($coupon)) {
                    $this->_submitHTTPPost(config('config.api_url') . 'subscribes/new/subscribeStore/', [
                        'email' => strtolower($data['email']),
                        'storeId' => $coupon['storeId'],
                        'domain' => $this->getDomain(),
                        'c_location' => config('config.location'),
                        'go' => $this->_getToken(6)
                    ]);
                    $topCoupons = $this->_submitHTTPGet(config('config.api_url') . 'coupons/getTopFreeShipping2/', [
                        'c_location' => config('config.location')
                    ]);
                    $lastCoupon = $this->_submitHTTPGet(config('config.api_url') . 'home/', [
                        'c_location' => config('config.location')
                    ]);
                    $this->_submitHTTPPost(config('config.api_url') . 'email/',[
                        'mailTo' => $data['email'],
                        'mailBody' => view('email-template.subscribe-coupon',[
                            'link' => strtok($request->server('HTTP_REFERER'),'?') . '?c=' . $data['go'],
                            'coupon'=>$coupon,
                            'hotCoupons' => $topCoupons['coupons'],
                            'lastCoupons' => $lastCoupon['newestStores']
                        ])->render(),
                        'mailSubject' => $coupon['title']
                    ]);
                }
            }elseif (!empty($data['dealId'])) {
                $deal = $this->_submitHTTPGet(config('config.api_url') . 'deals/',[
                    'where[id]' => $data['dealId'],
                    'findType' => 'findOne'
                ]);
                if (!empty($deal)) {
                    $data['go'] = $this->_getToken(6);
                    $this->_submitHTTPPost(config('config.api_url') . 'subscribes/new/subscribeStore/', [
                        'email' => strtolower($data['email']),
                        'storeId' => $deal['storeId'],
                        'domain' => $this->getDomain(),
                        'c_location' => config('config.location'),
                        'go' => $data['go']
                    ]);
                    $topCoupons = $this->_submitHTTPGet(config('config.api_url') . 'coupons/getTopFreeShipping2/', [
                        'c_location' => config('config.location')
                    ]);
                    $lastCoupon = $this->_submitHTTPGet(config('config.api_url') . 'home/', [
                        'c_location' => config('config.location')
                    ]);
                    $this->_submitHTTPPost(config('config.api_url') . 'email/',[
                        'mailTo' => $data['email'],
                        'mailBody' => view('email-template.subscribe-deal',[
                            'link' => strtok($request->server('HTTP_REFERER'),'?'),
                            'deal'=>$deal,
                            'hotCoupons' => $topCoupons['coupons'],
                            'lastCoupons' => $lastCoupon['newestStores']
                        ])->render(),
                        'mailSubject' => $deal['title']
                    ]);
                }
            }

            return response()->json(['status' => 'success']);
        }
    }
    /*
    Author:HaiHT
    Send Local storage of registed user to API
    */
    public function sendLocalStorage(Re $request){
        $data = $request->all();
        if (!empty($data['data'])) {
            foreach ($data['data'] as $key => $value) {
                if($data['data'][$key]){
                    $data['data'][$key] = explode(',', $data['data'][$key]);
                }
            }
            $data['data'] = json_encode($data['data']);
            $result = $this->_submitHTTPPost(config('config.api_url') . 'users/importSaveCouponsAndFavouriteStores/', $data);
        }else $result = null;
        return $result ? ['status' => 'success','msg' => $result] : ['status' => 'error','msg' => $result];
    }

    public function sendLocalStorage_Get(Re $request){
        $data = $request->all();
        foreach ($data['data'] as $key => $value) {
            $data['data'][$key] = explode(',', $data['data'][$key]);
        }
        $data['data'] = json_encode($data['data']);
        $result = $this->_submitHTTPPost(config('config.api_url') . 'users/importSaveCouponsAndFavouriteStores/', $data);
        return $result ? ['status' => 'success','msg' => $result] : ['status' => 'error','msg' => $result];
    }

}