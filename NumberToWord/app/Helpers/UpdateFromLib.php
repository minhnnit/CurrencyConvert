<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use App\Store;
use App\Coupon;
use Tinify\Exception;
use Webpatser\Uuid\Uuid;
use App\Property;
use DB;
use Illuminate\Support\Facades\Config;


class UpdateFromLib
{

    /* coupon title/description template */
    public function getTemplate($getWhat) {
        $pair = DB::select("select content from sample_coupon_title_description where type=? order by random() limit 1", [$getWhat]);
        return $pair[0]->content;
    }



    public function getHtmlViaProxy($url, $ref='') {
     //   $proxies = explode('|', env('PROXIES'));
   //     $randKey = array_rand($proxies, 1);
  //      $randomOneProxy = $proxies[$randKey];
 //       $proxy = 'https://' . $randomOneProxy;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
//        curl_setopt($ch, CURLOPT_PROXY, $proxy);
//        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
curl_setopt($ch, CURLOPT_USERPWD, "bogo:khongnoiduoc");
        if($ref) curl_setopt($ch, CURLOPT_REFERER, $ref);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:52.0) Gecko/20100101 Firefox/52.0");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);
        //echo $curl_scraped_page;exit;
        //$html = new \Htmldom();
        //$html->load($curl_scraped_page);
        return $curl_scraped_page;
    }


    public function insertCpToDB($params) {
	$coupons = $params['coupons'];
	if(empty($coupons)||isset($coupons[0]->title{0})===false) {return '';exit;}
	$result = [];
        /* Add coupon */
$time_created = date("Y-m-d H:i:s");
foreach($coupons as $i=>$cp) {	
	$a = [];
        $obj = new Coupon();
	foreach($cp as $name=>$vl) {
		if($name!='properties') if($vl) $obj->{"$name"} = $vl;
	}
	$obj->created_at = $time_created;
	$obj->updated_at = $time_created;
        $a['addCoupon'] = $obj->save();

if(!Property::where('id', '=', $cp->properties->id)->exists()) {
		$p = new Property();
		foreach($cp->properties as $name=>$vl) {
			if($vl) $p->{"$name"} = $vl;
		}
			$a['addProperties'] = $p->save();
		$result[$cp->properties->id][] = $a;
	}
}	
        return $result;
}


	public function getData($store_id) {
		$data = $this->getHtmlViaProxy('https://couponslibrary.com/update-from-lib?sid=' . $store_id);
		//dd($data);
		return (array)json_decode($data);		
	}

    public function getUniqueOnly($arrsAll, $storeId) {
	$arr = $arrsAll['coupons'];//dd($arr);
	$insertThem = [];
	$insertThem['coupons'] = [];
        if(count($arr) > 0){
	$cps = [];
	$unic = 0; $lim = 50;
	foreach($arr as $i=>$item) {
		if($unic<$lim) {
		    if(!Coupon::where('id', '=', $item->id)->exists())
            {
                $cps[] = $item;
                $unic++;
            }
    }else break;
		}
			if(!empty($cps)) $insertThem['coupons'] = $cps;
        }
        return $insertThem;
    }

	
		
}


