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
use App\Helpers\UpdateFromLib as HP;
use Mail;


class UpdateFromLibController extends Controller
{

    public function indexForUpdateCoupon($alias)
    {
        $sDetail = DB::table('stores')->where('alias','=',$alias)->where('countrycode','=','US')
            ->where('status','=','published')->first();

        $sDetail = (array)$sDetail;

        $allData = [];
        $allData['store'] = $sDetail;
        return $allData;
    }
    public function index(Re $request,$alias)
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
	
        $storeAlias = $alias;
        $dt = $this->indexForUpdateCoupon($storeAlias); //dd($dt);
	if(isset($dt['store']['id'])===false) {
		$running = DB::table('running_update_coupon')->where('alias', '=', $storeAlias)->get();
		if(isset($running[0]->storeid)) {
			$dt['store']=[];$dt['store']['id'] = $running[0]->storeid;
			}else $dt['store']['id'] = '';
			$dt['store']['name'] = 'not exists store';
			$dt['store']['social_image'] = '';
		 $dt['results'] = '<h1>Store Khong ton tai!</h1>';
	}else $dt['results'] = $this->checkAndInsert($dt['store']['id']);
        return view('updateFromLibrary')->with($dt);
    }
    //////////////////////////////////////////* Update coupon from target sites */


    public function checkAndInsert($storeId) {
		
        $hp = new HP;
        $result = $hp->getData($storeId);
	$insertStatus = '';
	if(!empty($result)) {
        $result = $hp->getUniqueOnly($result,$storeId);
	$insertStatus = $hp->insertCpToDB($result);
	}
        return ['status' => $insertStatus, 'result' => $result];

    }
	
	public function updateCouponNextStore(Re $request) {
        $storeid = $request->all()['storeId'];
        DB::update("update running_update_coupon set updated_coupon=1 where storeid=(?)",[$storeid]);
        $nextStore = DB::select('select storename,alias,storeid from running_update_coupon where updated_coupon=(?) order by random() limit 1', [0]);
		if(!empty($nextStore[0]) && is_null(DB::table('stores')->where('id', '=', $nextStore[0]->storeid)->first())) {
			DB::update("update running_update_coupon set updated_coupon=-1 where storeid=(?)",[$nextStore[0]->storeid]);	
		}
        if(empty($nextStore[0]))
            return json_encode([]);
        $nextStore = (array)$nextStore[0];
        return json_encode($nextStore);
    }



}