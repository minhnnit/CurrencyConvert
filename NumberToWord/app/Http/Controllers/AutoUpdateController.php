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
use App\Helpers\UpdateCoupon as HP;
use Mail;


class AutoUpdateController extends Controller
{

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

        $sDetail = (array)$sDetail;

        $allData = array_merge($dataPage, $dataSeo);
        $allData['store'] = $sDetail;
        return $allData;
    }
    public function index(Re $request,$alias)
    {
        $storeAlias = $alias;
        $dt = $this->indexForUpdateCoupon($storeAlias); //dd($dt);
		if(isset($dt['store']['id'])===false||!$dt['store']['id']) {
			$dt['storeNotExists'] = 1;
		}
        $dt['dataConfig'] = config('pullcoupon.site_list_action');//dd($dt['dataConfig']);
        return view('storeUpdateCoupon')->with($dt);
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

	public function updateCouponNextStore(Re $request) {
        $storeid = $request->all()['storeId'];
        if($storeid) DB::update("update running_update_coupon set updated_coupon=1 where storeid=(?)",[$storeid]);
        $nextStore = DB::select('select storename,alias,storeid from running_update_coupon where updated_coupon=(?) order by random() limit 1', [0]);
		if(!empty($nextStore[0]) && is_null(DB::table('stores')->where('id', '=', $nextStore[0]->storeid)->first())) {
			DB::update("update running_update_coupon set updated_coupon=-1 where storeid=(?)",[$nextStore[0]->storeid]);	
		}
        if(empty($nextStore[0]))
            return json_encode([]);
        $nextStore = (array)$nextStore[0];
        return json_encode($nextStore);
    }


    public function updateDomain(Re $request) {
        $rq = $request->all();
        $domainGet = $rq['domainGet'];
        $alias = $rq['alias'];
        $aliasDomain = $rq['aliasDomain'];
        $storeId = $rq['storeId'];

        $alias = $this->getAliasOfFather($alias);
        $hp = new HP;
        $data = $hp->getHtmlData($domainGet, $alias, $aliasDomain);
        $result = $hp->getUniqueOnly($data,$storeId);
        return $result;

    }

    public function addInsert(Re $request) {
        $params = $request->all();
        $note = !empty($params['note'])? $params['note'] : 'not set note';
        $hp = new HP;
        return $hp->insertCpToDB($params, $note);
    }

}