<?php
/**
 * Created by PhpStorm.
 * User: Phuong
 * Date: 6/5/2015
 * Time: 2:51 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request as Re;
use Session;
use URL;
use DB;

class GoController extends Controller{

    public function index($code){
        $params = explode('pickMe=', $code);
        $code = $params[0];

        if(count($params) > 1){
            /* get tracking name and value */
            $strTracking = explode('+', $params[1]);
            $trkValue = $strTracking[1];
            $sidName = $strTracking[2];
        }

        Session::forget('loginAfterGetCode');
        $property = $this->_submitHTTPGet(config('config.api_url') . 'properties/',[
            'where[foreignKeyRight]'=>$code,
            'findType'=>'findOne'
        ]);

        if (empty($property['foreignKeyLeft'])) return response(view('errors.404'), 404);
        if ($property['key'] == 'store') {
            $store = $this->_submitHTTPGet(config('config.api_url') . 'stores/',[
                'where[id]'=>$property['foreignKeyLeft'],
                'findType'=>'findOne',
                'c_location' => config('config.location')
            ]);
            if (empty($store)) return response(view('errors.404'), 404);
            if (!empty($store['affiliateUrl'])) {
                $product_url = $store['affiliateUrl'];
            } else $product_url = $store['storeUrl'];
            if (Session::has('user.id')) {
                if(!empty($store['sidName'])) $sid = $store['sidName'];
                else $sid = 'sid';
                $sid .= '=' . Session::get('user.go') . '-' . $code . '-' . config('config.location');
                if (strpos($product_url,'?') === false) $product_url .= '?' . $sid;
                else $product_url .= '&' . $sid;
            }
        } elseif ($property['key'] == 'deal') {
            $deal = $this->_submitHTTPGet(config('config.api_url') . 'deals/',[
                'where[id]'=>$property['foreignKeyLeft'],
                'include[stores]&findType'=>'findOne',
                'c_location' => config('config.location')
            ]);
            if (empty($deal)) return response(view('errors.404'), 404);
            $store = $deal['store'];
            if (!empty($deal['productLink'])) {
                $product_url = $deal['productLink'];
            } else {
                if (!empty($store['affiliateUrl'])) {
                    $product_url = $store['affiliateUrl'];
                } else $product_url = $store['storeUrl'];
            }
            if (Session::has('user.id')) {
                $property_store = $this->_submitHTTPGet(config('config.api_url') . 'properties/',[
                    'where[foreignKeyLeft]'=>$store['id'],
                    'where[key]'=>'store',
                    'findType'=>'findOne'
                ]);
                if(!empty($store['sidName'])) $sid = $store['sidName'];
                else $sid = 'sid';
                $sid .= '=' . Session::get('user.go') . '-' . $property_store['foreignKeyRight']. '-' . $code . '-' . config('config.location');
                if (strpos($product_url,'?') === false) $product_url .= '?' . $sid;
                else $product_url .= '&' . $sid;
            }
        } else {
            $coupon = $this->_submitHTTPGet(config('config.api_url') . 'coupons/',[
                'where[id]'=>$property['foreignKeyLeft'],
                'include[stores]&findType'=>'findOne',
                'c_location' => config('config.location')
            ]);
            if (empty($coupon)) return response(view('errors.404'), 404);
            $store = $coupon['store'];
            if (!empty($coupon['productLink'])) {
                $product_url = $coupon['productLink'];
            } else {
                if (!empty($store['affiliateUrl'])) {
                    $product_url = $store['affiliateUrl'];
                } else $product_url = $store['storeUrl'];
            }
            if (Session::has('user.id')) {
                $property_store = $this->_submitHTTPGet(config('config.api_url') . 'properties/',[
                    'where[foreignKeyLeft]'=>$store['id'],
                    'where[key]'=>'store',
                    'findType'=>'findOne'
                ]);
                if(!empty($store['sidName'])) $sid = $store['sidName'];
                else $sid = 'sid';
                $sid .= '=' . Session::get('user.go') . '-' . $property_store['foreignKeyRight']. '-' . $code . '-' . config('config.location');
                if (strpos($product_url,'?') === false) $product_url .= '?' . $sid;
                else $product_url .= '&' . $sid;
            }
        }
        if(!empty($sidName)){
            if(strpos($product_url, $sidName) !== false){
                $product_url = preg_replace("#".$sidName."=.*&#", $sidName.'='.$trkValue.'&', $product_url);
            }else{
                if (strpos($product_url,'?') === false){
                    $product_url .= '?' . $sidName . '=' . $trkValue;
                }else{
                    $product_url .= '&' . $sidName . '=' . $trkValue;
                }
            }
        }

        return redirect($product_url);
    }

    public function detail($code){
        /*$property = $this->_submitHTTPGet(config('config.api_url') . 'properties/',[
            'where[foreignKeyRight]'=>$code,
            'findType'=>'findOne'
        ]);*/
	$property = DB::select( DB::raw("
	SELECT * FROM properties where foreign_key_right = '$code' limit 1
	"));
	$property = (array)$property[0];
        if (empty($property['foreign_key_left'])) return response(view('errors.404'), 404);
        session()->set('redirectPath', URL::previous());
        if ($property['key'] == 'deal') {
			
          /* $deal = $this->_submitHTTPGet(config('config.api_url') . 'deals/',[
                'where[id]'=>$property['foreignKeyLeft'],
                'include[stores]&findType'=>'findOne',
                'c_location' => config('config.location')
            ]); */
	$deal = (array)DB::select( DB::raw("
		SELECT * FROM deals WHERE id = '{$property['foreign_key_left']}' and countrycode = '".config('config.location')."'
	"))[0];
            if (empty($deal)) return response(view('errors.404'), 404);
            $deal['like'] = Session::has('user.id') ? $this->_submitHTTPGet(config('config.api_url') . 'likes/getLikes?uuids[]=' .$deal['id'] . '&userId=' . Session::get('user.id'),[]) : [];
            $deal['favourites'] = $this->_submitHTTPGet(config('config.api_url') . 'favourites/getFavourites?uuids[]=' . $deal['id'] . '&userId=' . Session::get('user.id'),[]);
            return view('elements.v2_modal_get_deal',['deal' =>$deal, 'favourites' => $deal['favourites']]);
        } else {
           /* $coupon = $this->_submitHTTPGet(config('config.api_url') . 'coupons/',[
                'where[id]'=>$property['foreignKeyLeft'],
                'include[stores]&findType'=>'findOne',
                'c_location' => config('config.location')
            ]); */
		$coupon = (array)DB::select( DB::raw("
		SELECT * FROM coupons WHERE id = '{$property['foreign_key_left']}' AND countrycode = '".config('config.location')."'
		"))[0];
		$store = (array)DB::select( DB::raw("
		SELECT * FROM stores WHERE id = '{$coupon['store_id']}'
		"))[0]; //dd($store);
            $relateCp = DB::select( DB::raw(
                "SELECT c.title,p.foreign_key_right
                    FROM coupons c
                    LEFT JOIN properties p ON c.id = p.foreign_key_left
                    WHERE c.store_id = '{$coupon['store_id']}'
                    AND c.status = 'published'
                    AND (c.expire_date >= NOW() OR c.expire_date IS NULL)
                    ORDER BY 
                    CASE 
                        WHEN c.verified = 1 THEN 5 
                        WHEN c.sticky = 'top' THEN 4 
                        WHEN c.sticky = 'hot' THEN 3 
                        WHEN c.sticky = 'none' THEN 2 
                        WHEN c.sticky IS NULL THEN 1 
                    END DESC, c.top_order ASC, c.created_at DESC
                    LIMIT 3
                    "
            ) );
			
            if (empty($coupon)) return response(view('errors.404'), 404);
		$coupon['store'] = $store;
            $coupon['like'] = Session::has('user.id') ? $this->_submitHTTPGet(config('config.api_url') . 'likes/getLikes?uuids[]=' .$coupon['id'] . '&userId=' . Session::get('user.id'),[]) : [];
            $coupon['favourites'] = [];//$this->_submitHTTPGet(config('config.api_url') . 'favourites/getFavourites?uuids[]=' . $coupon['id'] . '&userId=' . Session::get('user.id'),[]);
            return view('elements.v2_modal_get_coupon',['coupon'=>$coupon, 'favourites' => $coupon['favourites'], 'relateCp' => $relateCp]);
        }
    }

    public function logGetCode(Re $request){
        $data = $request->all();
        $data['ip'] = Session::get('geoip-location')['ip'];
        $data['date'] = date('Y-m-d');
        $data['country_code'] = Session::get('geoip-location')['isoCode'];
        $data['cityCode'] = Session::get('geoip-location')['city'];
        $data['c_location'] = config('config.location');
        if (!empty($data['couponId'])) {
            $this->_submitHTTPPost(config('config.api_url') . 'log_used_codes/click-get-code/coupon/', $data);
        }else
            $this->_submitHTTPPost(config('config.api_url') . 'log_used_codes/click-get-code/deal/', $data);

        return true;
    }
}