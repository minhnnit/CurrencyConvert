<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request as Re;
use Redis;
use Session;
use App\Store;
use App\Coupon;
use Webpatser\Uuid\Uuid;
use App\Property;
use DB;
use App\Helpers\PullCoupon as HP;
use Mail;

class StoreController extends Controller
{
    public function nameWithKeyword($name) {
        if(stripos($name, ' coupon') || stripos($name, ' coupons')){
            return $name .= ' & Promo codes';
        }elseif(stripos($name, ' promo')){
            return $name .= ' & Discount codes';
        }elseif(stripos($name, ' voucher')){
            return $name .= ' & Coupon codes';
        }elseif(stripos($name, ' discount')){
            return $name .= ' & Coupon codes';
        }else{
            return $name .= ' Coupons & Promo codes';
        }
    }

    public function checkStringInLastPosition($str,$findMe) {
        /* Kiem tra -coupon co o cuoi cung cua alias ko */
        $l = strlen($str);
        if(strrpos($findMe,'-coupons') === 0)
            return false;
        $t = strrpos($findMe,'-coupons') + strlen($findMe); // 8 la length cua -coupons
        if($l === $t){
            return true;
        }
        return false;
    }

    public function indexForUpdateCoupon($alias)
    {
        $dataSeo = [
            'seo' => [
                'title' => 'Discount Voucher Title index controller overwrite',
                'keywords' => 'Discount Voucher keywords index controller overwrite',
                'description' => 'Discount Voucher description index controller overwrite',
                'image' => ''
            ]
        ];

        $dataPage = ['dcCount' => '9,419'];

        $sDetail = DB::table('stores')->where('alias','=',$alias)->where('countrycode','=','US')
            ->where('status','=','published')->first();

        /* neu la store bo */
//        if($sDetail && $sDetail->note != 'ngach' && strpos($alias, '-coupons') === false){
//            if($this->checkStringInLastPosition($alias,'-coupons') === false){
//                return 1;
//            }
//        }else{
//            if($sDetail){
//                $alias = str_replace('-coupons','',$alias);
//                $sDetail = DB::table('stores')->where('alias','=',$alias)->where('countrycode','=','US')
//                    ->where('status','=','published')->first();
//            }else{
//                if(empty($sDetail)){
//                    $alias = str_replace('-coupons','',$alias);
//                    $sDetail = DB::table('stores')->where('alias','=',$alias)->where('countrycode','=','US')
//                        ->where('status','=','published')->first();
//                }else{
//                    $sDetail = DB::table('stores')->where('alias','=',$alias)->where('countrycode','=','US')
//                        ->where('status','=','published')->first();
//                }
//            }
//        }

        $sDetail = (array)$sDetail;

        $allData = array_merge($dataPage, $dataSeo);
        $allData['store'] = $sDetail;
        $allData['store']['coupons'] = [];
        $allData['store']['relateStores'] = [];
        $allData['store']['expiredCoupons'] = [];
        $allData['store']['similarStores'] = [];
        $allData['arrVerified'] = [];
        $allData['arrStickyCp'] = [];
        $allData['arrCouponsNormal'] = [];
        $allData['arrCouponsRemote'] = [];
        return $allData;
    }
    public function withSlugTitle(Re $request, $couponGo, $couponTitle, $alias = '') {
        $data = [];
        $data['seoConfig']['disableNoindex'] = 2;
        //title
        $getCgo = DB::select(DB::raw(
            "SELECT c.title FROM coupons c
            LEFT JOIN properties p ON c.id = p.foreign_key_left
            WHERE p.foreign_key_right = '{$couponGo}'
            "
        ));
        if (!empty($getCgo[0]->title)){
            $data['seoConfig']['title'] = $getCgo[0]->title;
        }else{
            $data['seoConfig']['title'] = '';
            return 'Coupon not found';
        }
        //end title
        return $this->index($request, $alias, $couponGo)->with($data);
    }
    public function index(Re $request,$alias)
    {
        
        $storeAlias = $alias;
        if(!empty($_GET['update-coupon'])){
            $storeAlias = $alias;
            $dt = $this->indexForUpdateCoupon($storeAlias);
//            if($dt === 1)
//                return redirect(url('/' . $storeAlias . '-coupons?update-coupon=1'));
            return view('storeDetailForUpdateCoupon')->with($dt);
        }
        if($alias !== strtolower($alias)){
            $alias = $this->_redirect($alias, '', $request->all());
            return redirect($alias);
        }
        $dataSeo = [
            'seo' => [
                'title' => 'Discount Voucher Title index controller overwrite',
                'keywords' => 'Discount Voucher keywords index controller overwrite',
                'description' => 'Discount Voucher description index controller overwrite',
                'image' => ''
            ]
        ];

        $dataPage = ['dcCount' => '9,419'];

        if (!Session::has('coupon_type_' . $storeAlias)) Session::put('coupon_type_' . $storeAlias, []);
        $store = DB::table('stores')->select('stores.id AS id','name','logo','social_image','store_url','alias','affiliate_url','categories_id','best_store','custom_keywords','coupon_count','description','short_description','head_description','properties.foreign_key_right AS go','meta_title','meta_desc','cash_back_json','cash_back_total','cash_back_term','sid_name','update_coupon_from','note','store_url')
            ->leftJoin('properties', 'stores.id','=', 'properties.foreign_key_left')
            ->where('stores.alias','=',$storeAlias)
            ->where('stores.countrycode','=','US')
            ->first();
        /* neu la store bo */
        if($store && $store->note != 'ngach' && strpos($storeAlias, '-coupons') === false && strpos($request->path(), 'coupon-detail') === false){
            if($this->checkStringInLastPosition($storeAlias,'-coupons') === false){
                return redirect(url('/' . $storeAlias . '-coupons'));
            }
        }
        if(!$store){
            $storeAlias = str_replace('-coupons','', $storeAlias);
            $store = DB::table('stores')->select('stores.id AS id','name','logo','social_image','store_url','alias','affiliate_url','categories_id','best_store','custom_keywords','coupon_count','description','short_description','head_description','properties.foreign_key_right AS go','meta_title','meta_desc','cash_back_json','cash_back_total','cash_back_term','sid_name','update_coupon_from','note','store_url')
                ->leftJoin('properties', 'stores.id','=', 'properties.foreign_key_left')
                ->where('stores.alias','=',$storeAlias)
                ->where('stores.countrycode','=','US')
                ->first();
        }
        //dd($store);
        $store = (array)$store;
        $coupons = [];
        $childStores = [];
        $expiredCoupons = [];
        if($store){

            $storeId = $store['id'];
            $storeName = $this->nameWithKeyword($store['name']);
            $store['name'] = $storeName;
            $coupon_count = DB::select( DB::raw("SELECT COUNT(*) FROM coupons WHERE store_id = '$storeId'"));
            $store['coupon_count'] = isset($coupon_count[0]->count)?$coupon_count[0]->count:0;

            $filterType = '';
            if(Session::has('coupon_type_' . $storeAlias)) {
                $ssType = Session::get('coupon_type_' . $storeAlias);
                if(!empty($ssType)) {
                    $addType = array();
                    foreach($ssType as $v) {
                        $addType[] = "c.coupon_type = '$v'";
                    }
                    $filterType = "AND (".implode(' OR ', $addType) . ")";
                }
            }
            $coupons = DB::select( DB::raw(
                "SELECT c.id,c.title,c.currency,c.exclusive,c.description,c.created_at,c.expire_date,c.discount,c.coupon_code AS code,c.coupon_type AS type,c.coupon_image AS image,c.sticky,c.verified,c.comment_count,c.latest_comments,c.number_used,c.cash_back,c.note,c.top_order,p.foreign_key_right AS go
                    FROM coupons c
                    LEFT JOIN properties p ON c.id = p.foreign_key_left
                    WHERE c.store_id = '{$storeId}'
                    AND c.status = 'published'
                    $filterType
                    AND (c.expire_date >= NOW() OR c.expire_date IS NULL)
                    ORDER BY 
                    CASE 
                        WHEN c.verified = 1 THEN 5 
                        WHEN c.sticky = 'top' THEN 4 
                        WHEN c.sticky = 'hot' THEN 3 
                        WHEN c.sticky = 'none' THEN 2 
                        WHEN c.sticky IS NULL THEN 1 
                    END DESC,
                    c.coupon_type ASC,
                    c.top_order ASC,
                    c.created_at DESC,
                    c.title ASC
                    LIMIT 100
                    "
            ) );
            $expiredCoupons = DB::select( DB::raw(
                "SELECT c.id,c.title,c.currency,c.exclusive,c.description,c.created_at,c.expire_date,c.discount,c.coupon_code AS code,c.coupon_type AS type,c.coupon_image AS image,c.sticky,c.verified,c.comment_count,c.latest_comments,c.number_used,c.cash_back,c.note,c.top_order,p.foreign_key_right AS go
                    FROM coupons c
                    LEFT JOIN properties p ON c.id = p.foreign_key_left
                    WHERE c.store_id = '{$storeId}'
                    AND c.status = 'published'
                    AND c.expire_date <= NOW()
                    ORDER BY 
                    CASE 
                        WHEN c.verified = 1 THEN 5 
                        WHEN c.sticky = 'top' THEN 4 
                        WHEN c.sticky = 'hot' THEN 3 
                        WHEN c.sticky = 'none' THEN 2 
                        WHEN c.sticky IS NULL THEN 1 
                    END DESC, 
                    c.top_order ASC, 
                    c.created_at DESC,
                    c.title ASC
                    LIMIT 100
                    "
            ) );
            //dd($coupons);
            $childStores = DB::select( DB::raw(
                "SELECT name,alias
                    FROM stores
                    where store_url='{$store['store_url']}'
                    AND countrycode='US'
                    AND alias != '$storeAlias'
                    AND status='published'
                    "
            ) );
        }

        $data['store'] = $store;
        $data['store']['coupons'] = (array)$coupons;
        $data['store']['expiredCoupons'] = (array)$expiredCoupons;
        $data['store']['childStores'] = (array)$childStores;
        $data['store']['relateStores'] = [];
        $data['popularStores'] = $this->toArray(DB::select( DB::raw("
            SELECT * FROM stores WHERE sticky=1
            ORDER BY 
                    CASE
                      WHEN (note != 'ngach' OR note is null)  THEN 3
                      WHEN note = 'ngach' THEN 1
                    END DESC LIMIT 60
        ")));
        /* If 404 store */
        if (empty($store)){
            return response(view('errors.404'), 404);
//            return redirect('/');
        }

        /* If is open modal coupon detail */
        $re = $request->input('c');
        if (!empty($re) && !empty($data['store']['coupons'])) {
            $getCodeCoupon = $this->_submitHTTPGet(config('config.api_url') . 'coupons/getCouponWithLinkGo/'.$re.'/',[
                'c_location' => config('config.location')
            ]);
            if (!empty($getCodeCoupon)) {
                array_unshift($data['store']['coupons'], $getCodeCoupon);
            }
        }
        /*  */
        Session::forget('store-detail-more-'.$data['store']['id']);
        if (Session::has('store-detail-more-'.$data['store']['id'])) {
            $limit = intval(Session::get('store-detail-more-'.$data['store']['id']));
            $result = $this->_submitHTTPPost(config('config.api_url') . 'stores/storeDetailV2ShowMore/',[
                'storeId' => $data['store']['id'],
                'c_location' => config('config.location'),
                'c_limit' => $limit,
                'c_offset' => 100,
                'couponTypes' => Session::get('coupon_type_' . $storeAlias)
            ]);

            if (!empty($result) && $result['code'] == 0) $data['store']['coupons'] = array_merge($data['store']['coupons'],$result['data']);
        }

        if (Session::has('user.id')) {
            $query = '?';
            $query .= 'uuids[]=' . $data['store']['id'] . '&';
            if (sizeof($data['store']['coupons'])) {
                foreach ($data['store']['coupons'] as $s) {
                    $query .= 'uuids[]=' . $s['id'] . '&';
                }
            }
            $data['likes'] = '';
//            $this->_submitHTTPGet(config('config.api_url') . 'likes/getLikes' .$query . 'userId=' . Session::get('user.id'),['c_location' => config('config.location')]);
//            if (sizeof($data['store']['relateStores'])) {
//                foreach ($data['store']['relateStores'] as $s) {
//                    $query .= 'uuids[]=' . $s['id'] . '&';
//                }
//            }

        }
        /* SEO config */
        $seoConfig = DB::select(DB::raw("SELECT * FROM seo_configs LIMIT 1"))[0];
        $seoConfig = (array)$seoConfig;
//        $seoConfig = null;
        if (!empty($seoConfig)) {
            $rs = [];
            $title = '';
            $metaDescription = '';
            $metaKeyword = '';
            $siteName = '';
            $siteDesc = '';
            $storeHeaderH1 = '';
            $storeHeaderP = '';
            $disableNoindex = '';
            $seo_defaultStoreTitle = '';
            $seo_defaultStoreMetaDescription = '';
            $seo_defaultStoreMetaKeyword = '';
            $seo_defaultH1Store = '';
            $seo_defaultPStore = '';
            $s = $seoConfig;
            if ($s['option_name'] == 'seo_storeTitle') {
                $title = $s['option_value'];
            }
            if ($s['option_name'] == 'seo_storeDesc') {
                $metaDescription = $s['option_value'];
            }
            if ($s['option_name'] == 'seo_storeKeyword') {
                $metaKeyword = $s['option_value'];
            }
            if ($s['option_name'] == 'seo_siteName') {
                $siteName = $s['option_value'];
            }
            if ($s['option_name'] == 'seo_siteDescription') {
                $siteDesc = $s['option_value'];
            }
            if ($s['option_name'] == 'seo_storeH1') {
                $storeHeaderH1 = $s['option_value'];
            }
            if ($s['option_name'] == 'seo_storeP') {
                $storeHeaderP = $s['option_value'];
            }
            if ($s['option_name'] == 'seo_disableStoreNoIndex') {
                $disableNoindex = $s['option_value'];
            }

            if ($s['option_name'] == 'seo_defaultStoreTitle') {
                $seo_defaultStoreTitle = $s['option_value'];
            }
            if ($s['option_name'] == 'seo_defaultStoreMetaDescription') {
                $seo_defaultStoreMetaDescription = $s['option_value'];
            }
            if ($s['option_name'] == 'seo_defaultStoreMetaKeyword') {
                $seo_defaultStoreMetaKeyword = $s['option_value'];
            }
            if ($s['option_name'] == 'seo_defaultH1Store') {
                $seo_defaultH1Store = $s['option_value'];
            }
            if ($s['option_name'] == 'seo_defaultPStore') {
                $seo_defaultPStore = $s['option_value'];
            }
            if (isset($disableNoindex)) {
                $rs['disableNoindex'] = $disableNoindex;
            }

            $storeName = $data['store']['name'];
            if (sizeof($data['store']['coupons']) > 0) {
                $firstCp = $data['store']['coupons'][0];
                $firstCp = (array)$firstCp;
                $couponTitle = $firstCp['title'];
                $couponDiscount = $firstCp['discount'];
            } else {
                $couponTitle = '';
                $couponDiscount = '';
            }

            $configSelfSeoTitle = (isset($data['store']['meta_title']) && $data['store']['meta_title']) ? $data['store']['meta_title'] : null;
            $configSelfSeoDesc  = (isset($data['store']['meta_desc']) && $data['store']['meta_desc']) ? $data['store']['meta_desc'] : null;
            $upToCashBack = sizeof($data['store']['cash_back_json']) > 0 ? (!empty($data['store']['cash_back_json'][0]['cash_back_percent']) ? $data['store']['cash_back_json'][0]['cash_back_percent'].'%' : $data['store']['cash_back_json'][0]['currency'].$data['store']['cash_back_json'][0]['cash_back']) : '';
            if (isset($title)) {
                if (!$couponDiscount) {
                    $rs['title'] = $this->seoConvert($configSelfSeoTitle ? $configSelfSeoTitle : $seo_defaultStoreTitle, $siteName, $siteDesc, $storeName,
                        $couponTitle, $couponDiscount, $upToCashBack, true);
                } else {
                    $firstCp = $data['store']['coupons'][0];
                    $firstCp = (array)$firstCp;
                    $rs['title'] = $this->seoConvert($configSelfSeoTitle ? $configSelfSeoTitle : $title, $siteName, $siteDesc, $storeName, $couponTitle,
                        $couponDiscount.$firstCp['currency'], $upToCashBack, true);
                }
            }
            if (isset($metaDescription)) {
                if (!$couponDiscount) {
                    $rs['desc'] = $this->seoConvert($configSelfSeoDesc? $configSelfSeoDesc : $seo_defaultStoreMetaDescription, $siteName, $siteDesc, $storeName,
                        $couponTitle, $couponDiscount, $upToCashBack);
                } else {
                    $firstCp = $data['store']['coupons'][0];
                    $firstCp = (array)$firstCp;
                    $rs['desc'] = $this->seoConvert($configSelfSeoDesc? $configSelfSeoDesc : $metaDescription, $siteName, $siteDesc, $storeName, $couponTitle,
                        $couponDiscount.$firstCp['currency'], $upToCashBack);
                }
            }
            if (isset($metaKeyword)) {
                if (!$couponDiscount) {
                    $rs['keyword'] = $this->seoConvert($seo_defaultStoreMetaKeyword, $siteName, $siteDesc, $storeName,
                        $couponTitle, $couponDiscount, $upToCashBack);
                } else {
                    $firstCp = $data['store']['coupons'][0];
                    $firstCp = (array)$firstCp;
                    $rs['keyword'] = $this->seoConvert($metaKeyword, $siteName, $siteDesc, $storeName, $couponTitle,
                        $couponDiscount.$firstCp['currency'], $upToCashBack);
                }
            }
            if (isset($storeHeaderH1)) {
                if (!$couponDiscount) {
                    $rs['storeHeaderH1'] = $this->seoConvert($seo_defaultH1Store, $siteName, $siteDesc, $storeName, $couponTitle,
                        $couponDiscount, $upToCashBack);
                } else {
                    $firstCp = $data['store']['coupons'][0];
                    $firstCp = (array)$firstCp;
                    $rs['storeHeaderH1'] = $this->seoConvert($storeHeaderH1, $siteName, $siteDesc, $storeName, $couponTitle,
                        $couponDiscount.$firstCp['currency'], $upToCashBack);
                }
            }
            if (isset($storeHeaderP)) {
                if (!$couponDiscount) {
                    $rs['storeHeaderP'] = $this->seoConvert($seo_defaultPStore, $siteName, $siteDesc, $storeName, $couponTitle,
                        $couponDiscount, $upToCashBack);
                } else {
                    $firstCp = $data['store']['coupons'][0];
                    $firstCp = (array)$firstCp;
                    $rs['storeHeaderP'] = $this->seoConvert($storeHeaderP, $siteName, $siteDesc, $storeName, $couponTitle,
                        $couponDiscount.$firstCp['currency'], $upToCashBack);
                }
            }
            $data['seoConfig'] = $rs;
            if (isset($siteName)) {
                $data['siteName'] = $siteName;
            }

            $isOpenPopup = strpos($_SERVER['REQUEST_URI'], '?c=');
            if($isOpenPopup){
                $couponFKR = substr($_SERVER['REQUEST_URI'], $isOpenPopup + 3, 6);
                $foundCp = $this->_submitHTTPGet(config('config.api_url').'properties/?where[foreignKeyRight]=' . $couponFKR
                    .'&findType=findOne&where[key]=coupon' . '&attributes[]=foreignKeyLeft', []);
                $openingCoupon = $this->_submitHTTPGet(config('config.api_url').'coupons/?where[id]=' . $foundCp['foreignKeyLeft']
                    .'&findType=findOne', []);
                $openingCouponTitle = $openingCoupon['title'];
                $openingCouponDesc = $openingCoupon['description'];

                $data['seoConfig']['originTitle'] = $data['seoConfig']['title'];
                $data['seoConfig']['originDesc'] = $data['seoConfig']['desc'];
                $data['seoConfig']['title'] = $openingCouponTitle;
                $data['seoConfig']['desc'] = $openingCouponDesc;
            }
        }
        /*  */

        /*
                $data['slidersc'] = $this->_submitHTTPGet(config('config.api_url') . 'slide_show_items/show_in_store_detail/', [
                    'c_location' => config('config.location')
                ]);
        */



//re title charming :v
        $maxDiscount = 0;
        foreach($coupons as $items) {
            $discount = (int)$items->discount;
            if($items->currency == '%' && $discount>$maxDiscount) $maxDiscount = $discount;
        }
        if($maxDiscount===0) { $ar = [30,40,50,60,70,80,90]; $ak = array_rand($ar); $maxDiscount = $ar[$ak]; }
        $store_domain = str_replace(['http://','https://','www.'],'', $store['store_url']);
        $seoTitle = "$maxDiscount% Off $store_domain Coupons & Promo Codes, ".date("F Y");
        $data['seoConfig']['title'] = $seoTitle;
//end retitle


        $allData = array_merge($dataPage, $dataSeo, $data);
        $allData['siteName'] = env('SITE_NAME','');
        $allData['store']['couponType'] = [
            ['coupon_type' => 'Coupon Code'],
            ['coupon_type' => 'Deal Type'],
            ['coupon_type' => 'Great Offer']
        ];
        $allData['store']['countCouponVerified'] = 10;
        $allData['store']['todayCoupon'] = 2;
        $allData['store']['expiredCoupons'] = [];
        return view('storeDetailNew')->with($allData);
    }

    public function getStores(Re $request)
    {
        if ($request->ajax()){
            $keyword = $request->input('q');
            $data = $this->_submitHTTPGet(config('config.api_url') . 'stores/',[
                'where[$or][storeUrl][$ilike]'=>'%'.$keyword.'%',
                'where[$or][name][$ilike]'=>'%'.$keyword.'%',
                'where[status]'=>'published',
                'where[countrycode]'=> config('config.location'),
                'attributes[]=id&attributes[]=name&attributes[]'=>'storeUrl',
                'c_location' => config('config.location')
            ]);
            return response()->json(['items' => $data]);
        }
        return response()->json(['items' => []]);
    }

    public function toArray($data) {
        return json_decode(json_encode($data,1),1);
    }
    public function showMoreCoupons(Re $request){
        $storeId = $request->input('storeId');
        //$offset = !empty($request->input('offset')) ? (int)$request->input('offset') : 0;
        $store = DB::table('stores')->select('stores.id AS id','name','logo','social_image','store_url','alias','affiliate_url','categories_id','best_store','custom_keywords','coupon_count','description','short_description','head_description','properties.foreign_key_right AS go','meta_title','meta_desc','cash_back_json','cash_back_total','cash_back_term','sid_name','update_coupon_from','note','store_url')
            ->leftJoin('properties', 'stores.id','=', 'properties.foreign_key_left')
            ->where('stores.id','=',$storeId)
            ->where('stores.countrycode','=','US')
            ->first();
        $store = (Array)$store;
        $storeAlias = $store['alias'];
        if ($request->ajax() && !empty($store)){
            $limit = (int)$request->input('limit');
            $offset = (int)$request->input('offset');

            $filterType = '';
            if(Session::has('coupon_type_' . $storeAlias)) {
                $ssType = Session::get('coupon_type_' . $storeAlias);
                if(!empty($ssType)) {
                    $addType = array();
                    foreach($ssType as $v) {
                        $addType[] = "c.coupon_type = '$v'";
                    }
                    $filterType = "AND (".implode(' OR ', $addType) . ")";
                }
            }
            $coupons = DB::select( DB::raw(
                "SELECT c.id,c.title,c.currency,c.exclusive,c.description,c.created_at,c.expire_date,c.discount,c.coupon_code AS code,c.coupon_type AS type,c.coupon_image AS image,c.sticky,c.verified,c.comment_count,c.latest_comments,c.number_used,c.cash_back,c.note,c.top_order,p.foreign_key_right AS go
                    FROM coupons c
                    LEFT JOIN properties p ON c.id = p.foreign_key_left
                    WHERE c.store_id = '{$storeId}'
                    AND c.status = 'published'
                    $filterType
                    AND (c.expire_date >= NOW() OR c.expire_date IS NULL)
                    ORDER BY 
                    CASE 
                        WHEN c.verified = 1 THEN 5 
                        WHEN c.sticky = 'top' THEN 4 
                        WHEN c.sticky = 'hot' THEN 3 
                        WHEN c.sticky = 'none' THEN 2 
                        WHEN c.sticky IS NULL THEN 1 
                    END DESC,
                    c.coupon_type ASC,
                    c.top_order ASC,
                    c.created_at DESC,
                    c.title ASC
                    OFFSET $offset LIMIT $limit
                    "
            ) );
            $coupons = $this->toArray($coupons);
            //dd($coupons);
            $data = [
                "code" => !empty($coupons)?0:1,
                "err" => null,
                "msg" => "Success",
                "data" => $coupons
            ];
            if (!empty($data) && $data['code'] == 0 && sizeof($data['data']) > 0) {
                //Session::put('store-detail-more-'.$storeId,intval($offset) + 100);
                return response(view('elements.v2-parent-box-coupon',['coupons' => $data['data'], 'store' => $store ]));
            }
            else return response()->json(['status' => 'error','coupons' => []]);
        }
        return response()->json(['status' => 'error','coupons' => []]);
    }

    public function searchStores(Re $request)
    {
        if ($request->ajax()){
            $keyword = $request->input('kw');
            $data = $this->_submitHTTPPost(config('config.api_url') . 'stores/search/',[
                'keyword' => $keyword,
                'c_location' => config('config.location')
            ]);
            return response()->json(['status' => 'success','items' => $data]);
        }
        return response()->json(['status' => 'error','items' => []]);
    }

    public function filterCoupon(Re $request){
        if ($request->ajax()){
            $params = $request->all();
            $filterCouponByType = Session::has('coupon_type_' . $params['alias']) ? Session::get('coupon_type_' . $params['alias']) : [];
            if ($params['checked'] && !in_array($params['coupon_type'],$filterCouponByType)) {
                array_push($filterCouponByType,$params['coupon_type']);
            }else $filterCouponByType = array_diff($filterCouponByType, [$params['coupon_type']]);
            Session::put('coupon_type_' . $params['alias'],$filterCouponByType);
            return response()->json(['status' => 'success','data' => $filterCouponByType]);
        }
        return response()->json(['status' => 'error']);
    }

    public function requestCoupon(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        $storeName = $params['storeName'];
        $storeUrlDetail = $params['detail'];
        $obj = Store::find($storeId);
        if($obj){
            $obj->count_request_coupon = $obj->count_request_coupon + 1;
            $rs = $obj->save();
            Mail::send('emails.request-coupon', ['name' => $storeName, 'detail' => $storeUrlDetail, 'id' => $storeId], function($message)
            {
                $message->to(env('MAIL_REQUEST_COUPON_TO','haiht369@gmail.com'), 'HaiHT')->subject('Find me coupon');
            });
        }else{
            $rs = false;
        }
        return json_encode($rs);
    }

    //////////////////////////////////////////* Update coupon from target sites */
    private function getAliasOfFather($storeAlias) {
        $check = DB::select("select id,store_url,note from stores where alias=? and countrycode='US' limit 1", [$storeAlias]);
        $findFather = DB::select("select id,name,alias,store_url,note from stores where store_url=? and countrycode='US' and id != ? and (note is null or note != 'ngach')",[$check[0]->store_url, $check[0]->id]);
        if(!empty($findFather)){
            return $findFather[0]->alias;
        }
        $storeAlias = str_replace('-coupons','',$storeAlias);
        return $storeAlias;
    }

    public function testAllowAjax(Re $request) {
        $url = $request->all()['url'];
        $hp = new HP();
        $html = $hp->getHtmlViaProxy($url);
        return $html;
    }

    public function updateCouponDPF(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        $storeUrl = $params['storeUrl'];
        $updateCouponFrom = !empty($params['updateCouponFrom']) ? $params['updateCouponFrom']:'';
        $hp = new HP();
        if(strpos($updateCouponFrom, 'dontpayfull.com') !== false){
            $data = $this->getDontPayFull($updateCouponFrom);
            $result = $hp->getUniqueOnly($data,$storeId);
        }else{
            $updateCouponFrom = 'https://www.dontpayfull.com/at/' . $storeUrl;
            $data = $this->getDontPayFull($updateCouponFrom);
            $result = $hp->getUniqueOnly($data,$storeId);
        }
        return $result;
    }

    public function getDontPayFull($url) {
        $hp = new HP();
        $html = $hp->getHtmlViaProxy($url);
        $arr = [];
        /* couponbird */
        /*
        foreach ($html->find('.new-coupon-field') as $item) {
            $title = trim($item->find('.new-coupon-field-title',0)->plaintext);
            $cpId = $item->find('.new-coupon-field-title a',0)->href;
            $cpId = explode('/', $cpId)[2];
            $urlGetCode = $updateCouponFrom . '/?key=' . $cpId;
            $htmlCode = new \Htmldom($urlGetCode);
            $code = $html->find('.new-coupon-btn',0)->plaintext;
            echo $code.'\n';
        }
         */
        foreach ($html->find('.obox') as $item) {
            $title = trim($item->find('h3',0)->plaintext);
            if($item->find('.odescription')){
                $desc = trim($item->find('.odescription',0)->plaintext);
            }else{
                $desc = '';
            }

            if($item->find('.ocode',0)){
                $code = trim($item->find('.ocode',0)->plaintext);
            }else{
                $code = '';
            }
            if($item->find('.percent__label')){
                $discountValue = trim($item->find('.percent__label',0)->plaintext);
            }else{
                $discountValue = '';
            }
            $dataCpId = $item->{'data-id'};
            $verify = $item->find('.verified',0) ? 1 : 0;

            $a = [];
            $a['title'] = $title;
            $a['desc'] = $desc;
            $a['code'] = $code;
            $a['discount'] = $discountValue;
            $a['data-id'] = $dataCpId;
            $a['verify'] = $verify;
            array_push($arr,$a);
        }
        return $arr;
    }

    public function updateCouponDealSpot(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        $storeUrl = $params['storeUrl'];
        $hp = new HP();
        $data = $hp->getDealspotr($storeUrl);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function updateCouponCoupert(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        $storeUrl = $params['storeUrl'];
        $hp = new HP();
        $data = $hp->getCoupert($storeUrl);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function UpdateCouponCouponasion(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        /* check if is child then get alias of father */
        $storeAlias = $this->getAliasOfFather($params['storeAlias']);
        $hp = new HP();
        $data = $hp->getCouponasion($storeAlias);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function UpdateCouponsherpa(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        /* check if is child then get alias of father */
        $storeAlias = $this->getAliasOfFather($params['storeAlias']);
        $hp = new HP();
        $data = $hp->getCouponsherpa($storeAlias);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function updateCouponGoodSearch(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        /* check if is child then get alias of father */
        $storeAlias = $this->getAliasOfFather($params['storeAlias']);
        $hp = new HP();
        $data = $hp->getGoodSearch($storeAlias);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function updatePromotioncode(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        /* check if is child then get alias of father */
        $storeAlias = $this->getAliasOfFather($params['storeAlias']);
        $hp = new HP();
        $data = $hp->getPromotioncode($storeAlias);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function updateDealoupons(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        /* check if is child then get alias of father */
        $storeAlias = $this->getAliasOfFather($params['storeAlias']);
        $hp = new HP();
        $data = $hp->getDealoupons($storeAlias);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function updateBradsdeals(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        /* check if is child then get alias of father */
        $storeAlias = $this->getAliasOfFather($params['storeAlias']);
        $hp = new HP();
        $data = $hp->getBradsdeals($storeAlias);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function updateSavevy(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        $storeUrl = $params['storeUrl'];
        $hp = new HP();
        $data = $hp->getSavevys($storeUrl);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function updateDealhack(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        /* check if is child then get alias of father */
        $storeAlias = $this->getAliasOfFather($params['storeAlias']);
        $hp = new HP();
        $data = $hp->getDealhack($storeAlias);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function updateCouponforless(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        $storeUrl = $params['storeUrl'];
        $hp = new HP();
        $data = $hp->getCouponforless($storeUrl);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function update360couponcodes(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        $storeUrl = $params['storeUrl'];
        $hp = new HP();
        $data = $hp->get360couponcodes($storeUrl);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function updateCouponology(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        /* check if is child then get alias of father */
        $storeAlias = $this->getAliasOfFather($params['storeAlias']);
        $hp = new HP();
        $data = $hp->getCouponology($storeAlias);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function updateSlickdeals(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        /* check if is child then get alias of father */
        $storeAlias = $this->getAliasOfFather($params['storeAlias']);
        $hp = new HP();
        $data = $hp->getSlickdeals($storeAlias);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function updateCouponlawn(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        /* check if is child then get alias of father */
        $storeAlias = $this->getAliasOfFather($params['storeAlias']);
        $hp = new HP();
        $data = $hp->getCouponlawn($storeAlias);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function updateGetcouponcodes(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        /* check if is child then get alias of father */
        $storeAlias = $this->getAliasOfFather($params['storeAlias']);
        $hp = new HP();
        $data = $hp->getGetcouponcodes($storeAlias);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function updateCoupontwo(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        $storeUrl = $params['storeUrl'];
        $hp = new HP();
        $data = $hp->getGetCoupontwo($storeUrl);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function updateSavedoubler(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        /* check if is child then get alias of father */
        $storeAlias = $this->getAliasOfFather($params['storeAlias']);
        $hp = new HP();
        $data = $hp->getSavedoubler($storeAlias);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function updateCouponsgood(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        $storeUrl = $params['storeUrl'];
        $hp = new HP();
        $data = $hp->getCouponsgood($storeUrl);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    public function updateCopypromocode(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        /* check if is child then get alias of father */
        $storeAlias = $this->getAliasOfFather($params['storeAlias']);
        $hp = new HP();
        $data = $hp->getCopypromocode($storeAlias);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }


    public function updateCouponCodeHome(Re $request) {
        $params = $request->all();
        $storeId = $params['storeId'];
        $storeUrl = $params['storeUrl'];
        $hp = new HP();
        $data = $hp->getCouponCodeHome($storeUrl);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;
    }

    /*  */

    public function getCodeFromDPF(Re $request) {
        $params = $request->all();
        $dataId = $params['data-id'];
        $pathGetCodeFromDontPayFull = 'https://www.dontpayfull.com/coupons/getcoupon/?id=' . $dataId;
        $hp = new HP();
        $html = $hp->getHtmlViaProxy($pathGetCodeFromDontPayFull);
        $code = '';
        if($html->find('#copy-button', 0)){
            $code = $html->find('#copy-button', 0)->{'data-clipboard-text'};
        }
        $params['code'] = $code;
        $result = $hp->insertCpToDB($params,'dontpayfull.com');
        return $result;
    }

    public function addDealspotr(Re $request) {
        $params = $request->all();
        $hp = new HP();
        return $hp->insertCpToDB($params, 'dealspotr');
    }

    public function addCoupert(Re $request) {
        $params = $request->all();
        $hp = new HP();
        return $hp->insertCpToDB($params, 'Coupert');
    }

    public function addCouponasion(Re $request) {
        $params = $request->all();
        $hp = new HP();
        $note = !empty($params['note']) ? $params['note'] : 'not set note';
        return $hp->insertCpToDB($params, $note);
    }

    public function updateCouponNextStore(Re $request) {
        $storeid = $request->all()['storeId'];
        DB::update('update running_update_coupon set updated_coupon=1 where storeid=(?)',[$storeid]);
        $nextStore = DB::select('select storename,alias from running_update_coupon where updated_coupon=(?) order by random() limit 1', [0]);
        if(empty($nextStore[0]))
            return json_encode([]);
        $nextStore = (array)$nextStore[0];
        return json_encode($nextStore);
    }
}