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

class UpdateCoupon
{

    /* coupon title/description template */
    public function getTemplate($getWhat) {
        $pair = DB::select("select content from sample_coupon_title_description where type=? order by random() limit 1", [$getWhat]);
        return $pair[0]->content;
    }

    protected function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 0) return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public function _getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[$this->crypto_rand_secure(0,strlen($codeAlphabet))];
        }
        return $token;
    }

    public function getHtmlViaProxy($url, $ref='', $yesproxy='') {


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
//        if($yesproxy) {
//            $proxies = $this->getConfig('proxy_list');
//            $randKey = array_rand($proxies, 1);
//            $randomOneProxy = $proxies[$randKey];
//            $proxy = 'https://' . $randomOneProxy;
//            curl_setopt($ch, CURLOPT_PROXY, $proxy);
//        }
// curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
        if($ref) curl_setopt($ch, CURLOPT_REFERER, $ref);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:52.0) Gecko/20100101 Firefox/52.0");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);
        //echo $curl_scraped_page;exit;
        $html = new \Htmldom();
        $html->load($curl_scraped_page);
        return $html;
    }


    public function insertCpToDB($params,$note) {

        if(empty($params['title'])){
            return ['empty title'];
        }
        $dc = $params['discount'];
        $dc = str_replace('%','',$dc);
        $dc = str_replace('$','',$dc);
        $dc = str_replace(' Off','',$dc);
        $currency = strpos($params['discount'], '%') !== false ? '%' : (strpos($params['discount'], '$') !== false ? '$' : '');
        $result = [];
        /* Add coupon */
        $obj = new Coupon();
        $obj->id = Uuid::generate();
        $obj->title = $params['title'];
        if(empty($params['desc'])){
            $objStore = DB::table('stores')->where('id','=',$params['storeId'])->first();
            if($objStore){
                $descriptionSample = $this->getTemplate('description');
                $descriptionSample = str_replace('[storename]',$objStore->name,$descriptionSample);
                $descriptionSample = str_replace('[value]',$dc ? $dc : '80%',$descriptionSample);
                $obj->description = $descriptionSample;
            }
        }else{
            $obj->description = $params['desc'];
        }

        $obj->status = 'published';
        $obj->coupon_type = $params['code'] ? 'Coupon Code' : 'Deal Type';
        $obj->coupon_code = $params['code'];
        $obj->discount = $dc;
        $obj->currency = $currency;
        $obj->created_at = date('Y-m-d H:i:s');
        $obj->updated_at = date('Y-m-d H:i:s');
        if(isset($params['expired']{0})) {
            $timeFm = strtotime($params['expired']);
            if ($timeFm) $obj->expire_date = date("Y-m-d H:i:s", $timeFm);
        }
        $obj->store_id = $params['storeId'];
        $obj->author = env('DEFAULT_AUTHOR');
        if(!empty($params['note'])){
            $obj->note = $params['note'];
        }
        if(!empty($params['verify'])){
            $obj->verified = $params['verify'];
        }else{
            $obj->verified = 0;
        }
	
	//$dataConfig = $this->getConfig();
	//$item_order = array_search($note, $dataConfig);
        /* thay doi top_order de hien thi theo thu tu ra frontend */
	$cf_order = $this->getConfig('top_order');
        $startFrom = $cf_order['start'];
        $order = $cf_order['order'];
	
        foreach ($order as $k => $item) {
            if (strtolower($note) === strtolower($item)){
                $obj->top_order = $startFrom + $k;
            }
        }
	

        if($note) $obj->note = $note;
        $a['addCoupon'] = $obj->save();

        $p = new Property();
        $uuidString = \Webpatser\Uuid\Uuid::generate();
        if( !is_string($uuidString) && isset($uuidString->string{0})) $uuidString = $uuidString->string;
        $p->id = $uuidString;
        $p->foreign_key_left = $obj->id;
        $p->foreign_key_right = $this->_getToken(6);
        $p->key = 'coupon';
        $a['addUuid'] = $p->save();
        array_push($result, $a);
        return $result;
    }


    public function detectFunc($needDetect, $item='', $item2='') {
        if(is_callable($needDetect)) return $needDetect($item, $item2);
        else return $needDetect;
    }
    public $data_config = [];
	public function getConfig($action='site_list_action') {
		if(isset($this->data_config[$action])===false)
			$this->data_config[$action] = config('pullcoupon.'.$action);
		return $this->data_config[$action];
	}
    public $dataTamp = [];
    public function getHtmlData($domainGet, $alias='', $aliasDomain='') {
        $alias = $alias?:$aliasDomain;
        $aliasDomain = $aliasDomain?:$alias;

        $dataConfig = $this->getConfig();
        if(isset($dataConfig[$domainGet])===false) return [];

        $thisData = $dataConfig[$domainGet];
        //to call back, function closure, limit is 2 level of array [ [ [] ] ], can config ['func' => function($arg) { $this->. .... }]
        foreach($thisData as $k=>$v) {
            if(!is_array($v)) {
                if(is_callable($v)) {
                    $getXCB = $v->bindTo($this, get_class($this));
                    $thisData[$k] = $getXCB;
                }
            }else {
                foreach($v as $i=>$s) {
                    if(!is_array($s)) {
                        if (is_callable($s)) {
                            $getXCB = $s->bindTo($this, get_class($this));
                            $thisData[$k][$i] = $getXCB;
                        }
                    }else {
                        foreach($s as $j=>$h)
                        if (is_callable($h)) {
                            $getXCB = $h->bindTo($this, get_class($this));
                            $thisData[$k][$i][$j] = $getXCB;
                        }
                    }
                }
            }
        }


        if(!$thisData['url']) return [];
        $url = str_replace(['[alias]','[domain]'], [$alias, $aliasDomain], $this->detectFunc($thisData['url'], $alias, $aliasDomain) );
        //$needGet = $thisData['get'];
        $ref = isset($thisData['ref'])? str_replace(['[alias]','[domain]'], [$alias, $aliasDomain], $this->detectFunc($thisData['ref'], $alias, $aliasDomain)) : $url;
        $html = $this->getHtmlViaProxy($url, $ref, (isset($thisData['proxy'])&&$thisData['proxy']?1:''));
        if(isset($thisData['useTamp']['html'])) $this->dataTamp['html'] = $html;
        //echo $html->innertext;exit;

        //box item setting
        if(is_callable($thisData['box'])) $itemTop = $thisData['box']($html);
        else if(!isset($thisData['box']['find'])) $itemTop = $html->find($thisData['box']);
        else {
            if (isset($thisData['box']['parent'])) {
                $itemTop = $html->find($thisData['box']['parent'], isset($thisData['box']['pindex'])?$thisData['box']['pindex']:0);
                if($itemTop) $itemTop = $itemTop->find($thisData['box']['find']);
            }else $itemTop = $html->find($thisData['box']['find']);
        }



        //cant get box item -> log file error
        if(!$itemTop) {
            /*$errfile = config_path(). '/pullcoupon/error_site.json';
            $dfg = file_exists($errfile)?json_decode(file_get_contents($errfile)):new \stdClass();
            $dfg->{$domainGet} = ['alias'=>$alias, 'domain'=>$aliasDomain];
            file_put_contents($errfile, json_encode($dfg));*/
            return [];
        }

        //get data item
        $arr = [];
        foreach($itemTop as $k=>$items) {
            $a = [];
            foreach($thisData['get'] as $name=>$v) {
                if(!$v)
                    $a[$name] = '';
                else if(is_array($v)){
                    if (isset($v['this'])) $a[$name] = $items;
                    else $a[$name] = $items->find($v['find'], isset($v['index'])?$v['index']:0);
                    if (isset($v['func']) && is_callable($v['func'])) {
                        if ($a[$name]) $a[$name] = $v['func']($a[$name]);
                        else $a[$name] = '';
                    }else if($a[$name]) $a[$name] = isset($v['attr']) ? $a[$name]->{"{$v['attr']}"} : $a[$name]->plaintext;
                    else $a[$name] = '';
                }else {
                    $a[$name] = $items->find($v,0);
                    if($a[$name]) $a[$name] = $a[$name]->plaintext;
                    else $a[$name] = '';
                }
                $a[$name] = trim($a[$name]);
            }
            if(isset($a['title']{0})) array_push($arr, $a);
        }

        //dd($arr);
        return $arr;

    }



    public function getUniqueOnly($arr, $storeId) {
        $insertThem = [];
        if(count($arr) > 0){
            $arrTitles = [];
            foreach ($arr as $item) {
                array_push($arrTitles, $item['title']);
            }
            $findExistedRecords = Coupon::whereIn('title', $arrTitles)->where('store_id', '=', $storeId)->get(['title']);
            $temp = [];
            foreach ($findExistedRecords as $f) {
                array_push($temp, $f->title);
            }
            $findExistedRecords = $temp;
            // find records not exist in db
            foreach ($arr as $r) {
                if(!in_array($r['title'], $findExistedRecords)){
                    $r['storeId'] = $storeId;
                    array_push($insertThem, $r);
                }
            }
        }
        return $insertThem;
    }



}