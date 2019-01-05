<?php namespace App\Http\Controllers;

use Illuminate\Http\Request as Re;
use Session;

class CategoriesController extends Controller {

    public function detail(Re $request, $alias)
    {
        if($alias !== strtolower($alias)){
            $alias = $this->_redirect($alias, '/category/', $request->all());
            return redirect($alias);
        }
        if (!Session::has('coupon_type_' . $alias)) Session::put('coupon_type_' . $alias, []);
        $data = $this->_submitHTTPPost(config('config.api_url') . 'categories/categoryDetail/', [
            'alias' => $alias,
            'c_location' => config('config.location'),
            'couponTypes' => Session::get('coupon_type_' . $alias)
        ]);
        if ($data['code'] == 1 || empty($data)) return response(view('errors.404'), 404);
        Session::forget('category-detail-more-'.$data['data']['id']);
        if (Session::has('category-detail-more-'.$data['data']['id'])) {
            $limit = intval(Session::get('category-detail-more-'.$data['data']['id']));
            $result = $this->_submitHTTPPost(config('config.api_url') . 'categories/categoryDetailShowMore/',[
                'storeId' => $data['data']['id'],
                'c_location' => config('config.location'),
                'c_limit' => $limit,
                'c_offset' => 20,
                'couponTypes' => Session::get('coupon_type_' . $alias)
            ]);

            if (!empty($result) && $result['code'] == 0) $data['data']['coupons'] = array_merge($data['data']['coupons'],$result['data']);
        }
        $title = $data['data']['name'];
        $seoConfig = $this->_submitHTTPGet(config('config.api_url').'seo_configs/?where[countrycode]=' . config('config.location'),[]);
        $siteName = '';
        $siteDesc = '';
        $seo_CatTitle = 'All Categories - ' . config('config.domain');
        $seo_CatDesc = '';
        if (!empty($seoConfig)) {
            foreach ($seoConfig as $s) {
                if ($s['optionName'] == 'seo_CatTitle') {
                    $seo_CatTitle = $s['optionValue'];
                }
                if ($s['optionName'] == 'seo_CatDesc') {
                    $seo_CatDesc = $s['optionValue'];
                }
                if ($s['optionName'] == 'seo_siteName') {
                    $siteName = $s['optionValue'];
                }
                if ($s['optionName'] == 'seo_siteDescription') {
                    $siteDesc = $s['optionValue'];
                }
                if ($s['optionName'] == 'seo_DisableCatNoIndex') {
                    $disableNoIndex = $s['optionValue'];
                }
            }
            if (isset($disableNoIndex)) {
                $data['seoConfig']['disableNoindex'] = $disableNoIndex;
            }
            if (isset($seo_CatTitle)) {
                $seo_CatTitle = $this->seoConvert($seo_CatTitle, $siteName, $siteDesc, $title);
            }
            if (isset($seo_CatDesc)) {
                $seo_CatDesc = $this->seoConvert($seo_CatDesc, $siteName, $siteDesc, $title);
            }
        }
        $data['seoConfig']['title'] = $seo_CatTitle;
        $data['seoConfig']['desc'] = $seo_CatDesc;

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

        /*$data['sliders'] = $this->_submitHTTPGet(config('config.api_url') . 'slide_show_items/show_in_home_page/', [
            'c_location' => config('config.location')
        ]);*/

        return view('category')->with($data);
    }

    public function all()
    {
        $title = 'All Categories';
        $seoConfig = $this->_submitHTTPGet(config('config.api_url').'seo_configs/?where[countrycode]=' . config('config.location'),[]);
        $siteName = '';
        $siteDesc = '';
        $seo_CatTitle = 'All Categories - ' . config('config.domain');
        $seo_CatDesc = '';
        if (!empty($seoConfig)) {
            foreach ($seoConfig as $s) {
                if ($s['optionName'] == 'seo_CatTitle') {
                    $seo_CatTitle = $s['optionValue'];
                }
                if ($s['optionName'] == 'seo_CatDesc') {
                    $seo_CatDesc = $s['optionValue'];
                }
                if ($s['optionName'] == 'seo_siteName') {
                    $siteName = $s['optionValue'];
                }
                if ($s['optionName'] == 'seo_siteDescription') {
                    $siteDesc = $s['optionValue'];
                }
            }
            if (isset($seo_CatTitle)) {
                $seo_CatTitle = $this->seoConvert($seo_CatTitle, $siteName, $siteDesc, $title);
            }
            if (isset($seo_CatDesc)) {
                $seo_CatDesc = $this->seoConvert($seo_CatDesc, $siteName, $siteDesc, $title);
            }
        }
        $data['seoConfig']['title'] = $seo_CatTitle;
        $data['seoConfig']['desc'] = $seo_CatDesc;
        $data['categories'] = $this->_submitHTTPGet(config('config.api_url') . 'categories/allCategoriesAndStore/', [
            'c_location' => config('config.location')
        ]);
        return view('categoriesAll')->with($data);
    }

    public function showMoreCoupons(Re $request){
        $categoryId = $request->input('categoryId');
        $category = $this->_submitHTTPGet(config('config.api_url') . 'categories/',[
            'where[id]'=>$categoryId,
            'findType'=>'findOne',
            'c_location' => config('config.location')
        ]);
        if ($request->ajax() && !empty($category)){
            $limit = Session::has('category-detail-more-'.$categoryId) ? Session::get('category-detail-more-'.$categoryId) : 40;
            $data = $this->_submitHTTPPost(config('config.api_url') . 'categories/categoryDetailShowMore/',[
                'categoryId' => $categoryId,
                'c_location' => config('config.location'),
                'c_limit' => 20,
                'c_offset' => $limit - 20,
                'couponTypes' => Session::get('coupon_type_' . $category['alias'])
            ]);
            if (!empty($data) && $data['code'] == 0 && sizeof($data['data']) > 0) {
                Session::put('category-detail-more-'.$categoryId,intval($limit) + 20);
                return response(view('elements.v2-parent-box-store-coupon',['coupons' => $data['data']]));
            }
            else return response()->json(['status' => 'error','coupons' => []]);
        }
        return response()->json(['status' => 'error','coupons' => []]);
    }
}
