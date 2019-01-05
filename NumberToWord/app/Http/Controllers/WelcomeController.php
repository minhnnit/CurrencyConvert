<?php namespace App\Http\Controllers;

use App\Http\Requests\Request;
use Session;
use Illuminate\Http\Request as Re;
use Redis;
use DB;

class WelcomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Welcome Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "marketing page" for the application and
    | is configured to only allow guests. Like most of the other sample
    | controllers, you are free to modify or remove it as you desire.
    |
    */


    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function toArray($data) {
        return json_decode(json_encode($data,1),1);
    }
    public function index(Re $request)
    {
        $dataSeo = array(
            'seo' => array(
                'title' => 'Discout Voucher Title index controller overrided',
                'keywords' => 'Discout Voucher keywords index controller overrided',
                'description' => 'Discout Voucher description index controller overrided',
                'image' => ''
            )
        );

        $dataPage = array(
            'dcCount' => 'Over 9,000',
        );
        $newestStore = DB::select( DB::raw('
            SELECT * FROM stores WHERE best_store = 1 order by created_at DESC
        '));// OR show_in_homepage = 1 OR sticky = 1
        $listStoreId = [];
        foreach($newestStore as $v) {
            $listStoreId [] = $v->id;
        }
        $listStoreId = "('" . implode("','", $listStoreId) . "')";
        $rsdata = DB::select( DB::raw("
                SELECT DISTINCT on (c.store_id) c.id,c.title,c.currency,c.exclusive,c.description,c.created_at,c.expire_date,c.discount,c.coupon_code AS code,c.coupon_type AS type,c.coupon_image AS image,c.sticky,c.verified,c.comment_count,c.latest_comments,c.number_used,c.cash_back,c.note,c.top_order,
                p.foreign_key_right AS go,
                s.*
                    FROM coupons c
                    LEFT JOIN stores s ON c.store_id = s.id
                    LEFT JOIN properties p ON c.id = p.foreign_key_left
                    WHERE 
					c.verified = 1
                    AND c.status = 'published'
					AND s.id in $listStoreId
                    ORDER BY c.store_id DESC limit 30
            "));// OR s.show_in_homepage = 1 OR s.sticky = 1

        /*$topCoupons = DB::select( DB::raw("
                SELECT c.id,c.store_id,c.title,c.currency,c.exclusive,c.description,c.created_at,c.expire_date,c.discount,c.coupon_code AS code,c.coupon_type AS type,c.coupon_image AS image,c.sticky,c.verified,c.comment_count,c.latest_comments,c.number_used,c.cash_back,c.note,c.top_order,
                p.foreign_key_right AS go,
                s.*
                    FROM coupons c
                    LEFT JOIN stores s ON c.store_id = s.id
                    LEFT JOIN properties p ON c.id = p.foreign_key_left
                    WHERE c.verified = 1
                    AND c.status = 'published'
                    ORDER BY c.created_at DESC LIMIT 18
            "));*/
        $data = [];
        $data['couponList'] = $rsdata;
        $data['topCoupons'] = $newestStore;
        $data['sliders'] = [];
        $data['topCashBack'] = [];
        $data['popularStores'] = DB::select( DB::raw('
            SELECT * FROM stores WHERE sticky=1 ORDER BY name LIMIT 60
        '));
        //dd($data['popularStores']);exit;
        $data = $this->toArray($data);
        //dd($data);
        /*if(isset($data['sliders']) && !empty($data['sliders'])){
            foreach($data['sliders'] as $key => $slider){
                if(strpos('?', $slider['link'])){
                    $slider['link'] .= '&click=homepage_slide';
                }else{
                    $slider['link'] .= '?click=homepage_slide';
                }
                $data['sliders'][$key] = $slider;
            }
        }*/

        /*
		$data['sliders'] = $this->_submitHTTPGet(config('config.api_url') . 'slide_show_items/show_in_home_page/', [
            'c_location' => config('config.location')
        ]);
		*/

        $data['showSignStep'] = false;

        /**
         * SEO Config
         */
	$seoConfig = $this->toArray(DB::select(DB::raw("SELECT * FROM seo_configs WHERE countrycode = '" .  config('config.location') . "'")));
	
       $siteName = '';
        $siteDesc = '';
        if (!empty($seoConfig)) {
            $rs = [];
            foreach ($seoConfig as $s) {
                if ($s['option_name'] == 'seo_homeTitle') {
                    $settingHomeTitle = $s['option_value'];
                }
                if ($s['option_name'] == 'seo_homeMetaDesc') {
                    $settingHomeMetaDesc = $s['option_value'];
                }
                if ($s['option_name'] == 'seo_homeMetaKeyword') {
                    $settingHomeMetaKeyword = $s['option_value'];
                }
                if ($s['option_name'] == 'seo_siteName') {
                    $siteName = $s['option_value'];
                }
                if ($s['option_name'] == 'seo_siteDescription') {
                    $siteDesc = $s['option_value'];
                }
                if ($s['option_name'] == 'seo_disableHomeNoIndex') {
                    $disableNoIndex = $s['option_value'];
                }
            }
            if (isset($disableNoIndex)) {
                $rs['disableNoindex'] = $disableNoIndex;
            }

            if (isset($settingHomeTitle)) {
                $settingHomeTitle = $this->seoConvert($settingHomeTitle, $siteName, $siteDesc);
                $rs['title'] = $settingHomeTitle;
            }
            if (isset($settingHomeMetaDesc)) {
                $settingHomeMetaDesc = $this->seoConvert($settingHomeMetaDesc, $siteName, $siteDesc);
                $rs['desc'] = $settingHomeMetaDesc;
            }
            if (isset($settingHomeMetaKeyword)) {
                $settingHomeMetaKeyword = $this->seoConvert($settingHomeMetaKeyword, $siteName, $siteDesc);
                $rs['keyword'] = $settingHomeMetaKeyword;
            }
            $data['seoConfig'] = $rs;
        }
	
	
	
/* 	
	$domain_config =  config('domains.' . $GLOBALS['asset_domain']);
	
        $data['disableNoindex'] = '';
        $data['seoConfig']['title'] =  $domain_config['seo']['title'];
        $data['seoConfig']['desc'] = $domain_config['seo']['description']; */

        return view('v2-welcome')->with(array_merge($dataPage, $dataSeo, $data));
    }

    public function search(Re $request){
        if($request->ajax()){
            $data = $request->all();
            $result = DB::select( DB::raw(
                "SELECT id,name,alias,description,logo,note
                    FROM stores
                    WHERE name ilike '%{$data['keyword']}%'
                    AND status = 'published'
                    AND countrycode='US'
                    ORDER BY 
                    CASE
                      WHEN (note != 'ngach' OR note is null)  THEN 3
                      WHEN note = 'ngach' THEN 1
                    END DESC
                    LIMIT 50
                    "
            ) );
            $result['stores'] = $result;

            $limitTitle = 50;
            $limitDes = 100;
            $searchResult = [];
            $count = 0;
            if (!empty($result['stores'])) {
                foreach ($result['stores'] as $k => $item) {
                    $searchResult[$k]['id'] = $item->id;
                    $searchResult[$k]['image'] = $item->logo;
                    $searchResult[$k]['title'] = (strlen($item->name) > $limitTitle) ? mb_substr($item->name, 0, $limitTitle) . '...' : $item->name;
                    $searchResult[$k]['description'] = (strlen($item->description) > $limitDes) ? mb_substr($item->description, 0, $limitDes) . '...' : $item->description;
                    $searchResult[$k]['alias'] = $item->alias;
                    $searchResult[$k]['type'] = 'store';
                }
            }
            if (!empty($result['coupons'])) {
                for ($i = 0; $i < sizeof($result['coupons']); $i++) {
                    $searchResult[$count]['id'] = $result['coupons'][$i]['id'];
                    $searchResult[$count]['coupon_type'] = strtoupper($result['coupons'][$i]['coupon_type']);
                    $searchResult[$count]['discount'] = $result['coupons'][$i]['discount'];
                    $searchResult[$count]['currency'] = $result['coupons'][$i]['currency'];
                    $searchResult[$count]['title'] = (strlen($result['coupons'][$i]['title']) > $limitTitle) ? mb_substr($result['coupons'][$i]['title'], 0, $limitTitle) . '...' : $result['coupons'][$i]['title'];
                    $searchResult[$count]['description'] = (strlen($result['coupons'][$i]['description']) > $limitDes) ? mb_substr($result['coupons'][$i]['description'], 0, $limitDes) . '...' : $result['coupons'][$i]['description'];
                    $searchResult[$count]['store_alias'] = $result['coupons'][$i]['s_alias'];
                    $searchResult[$count]['coupon_key'] = $result['coupons'][$i]['go'];
                    $searchResult[$count]['type'] = 'coupon';
                    $count++;
                }
            }
            if (!empty($result['deals'])) {
                for ($i = 0; $i < sizeof($result['deals']); $i++) {
                    $searchResult[$count]['id'] = $result['deals'][$i]['id'];
                    $searchResult[$count]['image'] = $result['deals'][$i]['deal_image'];
                    $searchResult[$count]['title'] = (strlen($result['deals'][$i]['title']) > $limitTitle) ? mb_substr($result['deals'][$i]['title'], 0, $limitTitle) . '...' : $result['deals'][$i]['title'];
                    $searchResult[$count]['description'] = (strlen($result['deals'][$i]['description']) > $limitDes) ? mb_substr($result['deals'][$i]['description'], 0, $limitDes) . '...' : $result['deals'][$i]['description'];
                    $searchResult[$count]['coupon_key'] = $result['deals'][$i]['go'];
                    $searchResult[$count]['type'] = 'deal';
                    $count++;
                }
            }

            $resp['items'] = $searchResult;
            return response()->json(['status' => 'success',
                'items' => $searchResult
            ]);
        }
    }
    public function searchFromApi(Re $request) {
        $data = $request->all();
        $rs = DB::select( DB::raw(
            "SELECT s.name,s.alias,s.logo,s.store_url,c.title,c.description
            FROM stores s JOIN coupons c on s.id=c.store_id
            WHERE alias like '%{$data['keyword']}%'
            LIMIT 1"
        ) );
        $rs['domain'] = $_SERVER['SERVER_NAME'];
        return $rs;
    }
}
