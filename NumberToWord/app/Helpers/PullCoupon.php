<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use App\Store;
use App\Coupon;
use Tinify\Exception;
use Webpatser\Uuid\Uuid;
use App\Property;
use DB;

class PullCoupon
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

    public function getHtmlViaProxy($url) {
        $proxies = explode('|', env('PROXIES'));
        $randKey = array_rand($proxies, 1);
        $randomOneProxy = $proxies[$randKey];
        $proxy = 'https://' . $randomOneProxy;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        if(!empty($proxies)){
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);

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

        /* thay doi top_order de hien thi theo thu tu ra frontend */
        $order = [
            'dealspotr',
            'dontpayfull.com',
            'Bradsdeals.com',
            'Couponsherpa.com',
            'Dealhack.com',
            'Promotioncode.com',
            'Slickdeals.com',
            'GoodSearch.com',
            'Dealoupons.com',
            'Couponforless.com',
            '360couponcodes.com',
            'couponology.com',
            'Couponlawn.com',
            'Getcouponcodes.com',
            'Coupontwo.com',
            'Couponasion.com',
            'Couponsgood.com',
            'savedoubler.com'
        ];
        $startFrom = 10;
        foreach ($order as $k => $item) {
            if ($note === $item){
                $obj->top_order = $startFrom + $k;
            }
        }

        $obj->note = $note;
        $a['addCoupon'] = $obj->save();

        $p = new Property();
        $p->id = \Webpatser\Uuid\Uuid::generate();
        $p->foreign_key_left = $obj->id;
        $p->foreign_key_right = $this->_getToken(6);
        $p->key = 'coupon';
        $a['addUuid'] = $p->save();
        array_push($result, $a);
        return $result;
    }

    public function getDealspotr($url) {
        $url = 'https://dealspotr.com/promo-codes/' . $url;
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = 'article[class="_2MVK XXrY _2PB0 alRj o0mP _2loO"]';
        $_title = 'h3';
        $_code = 'span[class="UC_R _3hVW _37am"]';
        $_discount = '._3u8b';
        $_verify = '._2JwW._3O93._3J5g._1cK2._2Rzo._1U5y';
        /* end */

        foreach ($html->find($_box) as $item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
            }else{
                $title = '';
            }

            $desc = '';
            if($item->find($_code,0))
                $code = trim($item->find($_code,0)->plaintext);
            else
                $code = '';
            if($item->find($_discount,0))
                $discountValue = $item->find($_discount,0)->plaintext;
            else
                $discountValue = '';
            if($item->find($_verify,0)){
                $verify = 1;
            }else{
                $verify = 0;
            }

            $a = [];
            $a['title'] = $title;
            $a['desc'] = $desc;
            $a['code'] = $code;
            $a['discount'] = str_replace('Sale','',$discountValue);
            $a['verify'] = 1;

            array_push($arr,$a);
        }
        return $arr;
    }
    public function getCoupert($url) {
        $url = 'https://www.coupert.com/us/' . $url;
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = 'div[class="coupon-list"]';
        $_title = 'div[class="offer-text"] a';
        $_code = 'div[class="cou-btn"] a';
        $_discount = '.code-num';
        $_verify = '';
        /* end */

        foreach ($html->find($_box) as $item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
            }else{
                $title = '';
            }

            $desc = '';
            if($item->find($_code,0))
                $code = str_replace('Get Deal','',str_replace(' Get Code','', trim($item->find($_code,0)->plaintext)));
            else
                $code = '';
            if($item->find($_discount,0))
                $discountValue = str_replace('  OFF','',trim($item->find($_discount,0)->plaintext));
            else
                $discountValue = '';
            if($item->find($_verify,0)){
                $verify = 1;
            }else{
                $verify = 0;
            }

            $a = [];
            $a['title'] = $title;
            $a['desc'] = $desc;
            $a['code'] = $code;
            $a['discount'] = str_replace('Sale','',$discountValue);
            $a['verify'] = $verify;

            // Dont get cp of relate store
            if( !$item->find('img') )
                array_push($arr,$a);
        }
        return $arr;
    }
    public function getCouponsherpa($alias) {
        $url = 'https://www.couponsherpa.com/' . $alias;
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = 'div[class="box own"]';
        $_title = 'h3';
        $_code = 'div[class="coupon_code"] div[class="code"]';
        $_discount = '.deal div';
        $_verify = '';
        /* end */

        foreach ($html->find($_box) as $item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
            }else{
                $title = '';
            }

            $desc = '';
            if($item->find($_code,0))
                $code = trim($item->find($_code,0)->plaintext);
            else
                $code = '';
            if($item->find($_discount,0)){
                $discountValue = str_replace('Promo Code','',trim($item->find($_discount,0)->plaintext));
                $discountValue = str_replace(' %Off','',$discountValue);
            }
            else
                $discountValue = '';
            if($item->find($_verify,0)){
                $verify = 1;
            }else{
                $verify = 0;
            }

            $a = [];
            $a['title'] = $title;
            $a['desc'] = $desc;
            $a['code'] = $code;
            $a['discount'] = str_replace('Sale','',$discountValue);
            $a['verify'] = $verify;

            array_push($arr,$a);
        }
        return $arr;
    }
    public function getCouponasion($alias) {
        $url = "https://www.couponasion.com/store/$alias.html";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = '.coupon_list';
        $_title = 'p[class="title"]';
        $_code = '.coupon_btn .code';
        $_discount = '.amount';
        $_verify = '';
        /* end */

        foreach ($html->find($_box) as $item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
            }else{
                $title = '';
            }

            $desc = '';
            if($item->find($_code,0))
                $code = trim($item->find($_code,0)->plaintext);
            else
                $code = '';
            if($item->find($_discount,0))
                $discountValue = trim($item->find($_discount,0)->plaintext);
            else
                $discountValue = '';
            if($item->find($_verify,0)){
                $verify = 1;
            }else{
                $verify = 0;
            }

            $a = [];
            $a['title'] = $title;
            $a['desc'] = $desc;
            $a['code'] = $code;
            $a['discount'] = str_replace('Sale','',$discountValue);
            $a['verify'] = $verify;

            array_push($arr,$a);
        }
        return $arr;
    }
    public function getGoodSearch($alias) {
        $url = "https://www.goodsearch.com/coupons/$alias";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = '.deal-item';
        $_title = 'span[class="title"]';
        $_code = 'span[class="code"]';
        $_discount = 'span[class="span_text"]';
        $_verify = '.verified';
        /* end */

        foreach ($html->find($_box) as $item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
            }else{
                $title = '';
            }

            $desc = '';
            if($item->find($_code,0))
                $code = trim($item->find($_code,0)->plaintext);
            else
                $code = '';
            if($item->find($_discount,0)){
                $discountValue = trim($item->find($_discount,0)->plaintext);
                $discountValue = str_replace('ONSALE','',$discountValue);
                $discountValue = str_replace('OFF','',$discountValue);
            } else
                $discountValue = '';
            if($item->find($_verify,0)){
                $verify = 1;
            }else{
                $verify = 0;
            }

            $a = [];
            $a['title'] = $title;
            $a['desc'] = $desc;
            $a['code'] = $code;
            $a['discount'] = str_replace('Sale','',$discountValue);
            $a['verify'] = $verify;

            array_push($arr,$a);
        }
        return $arr;
    }
    public function getPromotioncode($alias) {
        $url = "https://www.promotioncode.org/$alias";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = '.click';
        $_title = 'p';
        $_code = '.click-view span';
        $_discount = '.';
        $_verify = '.spr-star';
        /* end */

        foreach ($html->find($_box) as $item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
            }else{
                $title = '';
            }

            $desc = '';
            if($item->find($_code,0))
                $code = trim($item->find($_code,0)->plaintext);
            else
                $code = '';
            if($item->find($_discount,0)){
                $discountValue = trim($item->find($_discount,0)->plaintext);
                $discountValue = str_replace('ONSALE','',$discountValue);
                $discountValue = str_replace('OFF','',$discountValue);
            } else
                $discountValue = '';
            if($item->find($_verify,0)){
                $verify = 1;
            }else{
                $verify = 0;
            }

            $a = [];
            $a['title'] = $title;
            $a['desc'] = $desc;
            $a['code'] = $code;
            $a['discount'] = str_replace('Sale','',$discountValue);
            $a['verify'] = $verify;

            array_push($arr,$a);
        }
        return $arr;
    }
    public function getDealoupons($alias) {
        $url = "http://dealoupons.com/coupons/$alias";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = '.item';
        $_title = 'h3';
        $_code = '.link-holder a';
        $_discount = '';
        $_verify = '';
        $_desc = '.desc .more';
        /* end */

        foreach ($html->find($_box) as $k=>$item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
            }else{
                $title = '';
            }

            if($item->find($_desc)){
                $desc = $item->find($_desc,0)->plaintext;
            }else{
                $desc = '';
            }

            if($item->find($_code,0)){
                $code = trim($item->find($_code,0)->{'data-clipboard-text'});
                $code = str_replace('Get Deal','',$code);
            } else
                $code = '';

            $discountValue = '';
            if($_discount){
                if($item->find($_discount,0)){
                    $discountValue = trim($item->find($_discount,0)->plaintext);
                    $discountValue = str_replace('ONSALE','',$discountValue);
                    $discountValue = str_replace('OFF','',$discountValue);
                }
            }

            $verify = 0;
            if($_verify){
                if($item->find($_verify,0)){
                    $verify = 1;
                }
            }

            $a = [];
            $a['title'] = $title;
            $a['desc'] = $desc;
            $a['code'] = $code;
            $a['discount'] = str_replace('Sale','',$discountValue);
            $a['verify'] = $verify;

            array_push($arr,$a);
        }
        return $arr;
    }
    public function getBradsdeals($alias) {
        $url = "https://www.bradsdeals.com/coupons/$alias";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = 'li[class="block coupon"]';
        $_title = 'h3 a';
        $_code = '.coupon-code';
        $_discount = '';
        $_verify = '';
        $_desc = '.coupon-description';
        /* end */

        foreach ($html->find($_box) as $k=>$item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
            }else{
                $title = '';
            }

            if($item->find($_desc)){
                $desc = trim($item->find($_desc,0)->plaintext);
            }else{
                $desc = '';
            }

            if($item->find($_code,0)){
                $code = trim($item->find($_code,0)->plaintext);
            } else
                $code = '';

            $discountValue = '';
            if($_discount){
                if($item->find($_discount,0)){
                    $discountValue = trim($item->find($_discount,0)->plaintext);
                    $discountValue = str_replace('ONSALE','',$discountValue);
                    $discountValue = str_replace('OFF','',$discountValue);
                }
            }

            $verify = 0;
            if($_verify){
                if($item->find($_verify,0)){
                    $verify = 1;
                }
            }

            $a = [];
            $a['title'] = $title;
            $a['desc'] = $desc;
            $a['code'] = $code;
            $a['discount'] = str_replace('Sale','',$discountValue);
            $a['verify'] = $verify;

            array_push($arr,$a);
        }
        return $arr;
    }
    public function getSavevys($domain) {
        $url = "http://www.savevy.com/store/$domain";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];
        if( $html->find('.red_error_h2',0) ){
            return $arr;
        }

        /* config DOM */
        $_box = '.media';
        $_title = 'h3';
        $_code = 'a[class="hint hint--right"]';
        $_discount = '';
        $_verify = '';
        $_desc = '.index_coupon_code p';
        /* end */

        foreach ($html->find($_box) as $k=>$item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
            }else{
                $title = '';
            }

            if($item->find($_desc)){
                $desc = trim($item->find($_desc,0)->plaintext);
            }else{
                $desc = '';
            }

            if($item->find($_code,0)){
                $code = trim($item->find($_code,0)->{'code'});
            } else
                $code = '';

            $discountValue = '';
            if($_discount){
                if($item->find($_discount,0)){
                    $discountValue = trim($item->find($_discount,0)->plaintext);
                    $discountValue = str_replace('ONSALE','',$discountValue);
                    $discountValue = str_replace('OFF','',$discountValue);
                }
            }

            $verify = 0;
            if($_verify){
                if($item->find($_verify,0)){
                    $verify = 1;
                }
            }

            if($title){
                $a = [];
                $a['title'] = $title;
                $a['desc'] = $desc;
                $a['code'] = $code;
                $a['discount'] = str_replace('Sale','',$discountValue);
                $a['verify'] = $verify;

                array_push($arr,$a);
            }
        }
        return $arr;
    }
    public function getDealhack($domain) {
        $url = "https://dealhack.com/coupons/udemy/$domain";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = '.item-holder';
        $_title = '.entry-title span';
        $_code = '.hidden-code';
        $_discount = 'div[class="free-gift text"]';
        $_verify = '';
        $_desc = '';
        /* end */

        foreach ($html->find($_box) as $k=>$item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
            }else{
                $title = '';
            }

            if($item->find($_desc)){
                $desc = trim($item->find($_desc,0)->plaintext);
            }else{
                $desc = '';
            }

            if($item->find($_code,0)){
                $code = trim($item->find($_code,0)->plaintext);
            } else
                $code = '';

            $discountValue = '';
            if($_discount){
                if($item->find($_discount,0)){
                    $discountValue = trim($item->find($_discount,0)->plaintext);
                    $discountValue = str_replace('Off','',$discountValue);
                }
            }

            $verify = 0;
            if($_verify){
                if($item->find($_verify,0)){
                    $verify = 1;
                }
            }

            if($title){
                $a = [];
                $a['title'] = $title;
                $a['desc'] = $desc;
                $a['code'] = $code;
                $a['discount'] = str_replace('Sale','',$discountValue);
                $a['verify'] = $verify;

                array_push($arr,$a);
            }
        }
        return $arr;
    }
    public function getCouponforless($domain) {
        $url = "http://couponforless.com/store/$domain";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = '.offer-item';
        $_title = 'h3 a';
        $_code = '.code a';
        $_discount = '';
        $_verify = '';
        $_desc = '.offer-description';
        /* end */

        foreach ($html->find($_box) as $k=>$item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
            }else{
                $title = '';
            }

            if($item->find($_desc)){
                $desc = trim($item->find($_desc,0)->plaintext);
            }else{
                $desc = '';
            }

            if($item->find($_code,0)){
                $code = trim($item->find($_code,0)->{'data-clipboard-text'});
            } else
                $code = '';

            $discountValue = '';
            if($_discount){
                if($item->find($_discount,0)){
                    $discountValue = trim($item->find($_discount,0)->plaintext);
                    $discountValue = str_replace('Off','',$discountValue);
                }
            }

            $verify = 0;
            if($_verify){
                if($item->find($_verify,0)){
                    $verify = 1;
                }
            }

            if($title){
                $a = [];
                $a['title'] = $title;
                $a['desc'] = $desc;
                $a['code'] = $code;
                $a['discount'] = str_replace('Sale','',$discountValue);
                $a['verify'] = $verify;

                array_push($arr,$a);
            }
        }
        return $arr;
    }
    public function get360couponcodes($domain) {
        $url = "https://www.360couponcodes.com/$domain";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = '.coupon-details';
        $_title = 'h3 a';
        $_code = '#description2';
        $_discount = '';
        $_verify = '';
        $_desc = '';
        /* end */

        foreach ($html->find($_box) as $k=>$item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
            }else{
                $title = '';
            }

            if($item->find($_desc)){
                $desc = trim($item->find($_desc,0)->plaintext);
            }else{
                $desc = '';
            }

            if($item->find($_code,0)){
                $code = trim($item->find($_code,0)->plaintext);
            } else
                $code = '';

            $discountValue = '';
            if($_discount){
                if($item->find($_discount,0)){
                    $discountValue = trim($item->find($_discount,0)->plaintext);
                    $discountValue = str_replace('Off','',$discountValue);
                }
            }

            $verify = 0;
            if($_verify){
                if($item->find($_verify,0)){
                    $verify = 1;
                }
            }

            if($title){
                $a = [];
                $a['title'] = $title;
                $a['desc'] = $desc;
                $a['code'] = $code;
                $a['discount'] = str_replace('Sale','',$discountValue);
                $a['verify'] = $verify;

                array_push($arr,$a);
            }
        }
        return $arr;
    }
    public function getCouponology($alias) {
        $url = "http://www.couponology.com/$alias-coupon";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = 'article';
        $_title = 'h3';
        $_code = "span[id^='couponcontent1_CurrentPromoListView_Label2_']";
        $_discount = '';
        $_verify = '.featured-coupon';
        $_desc = '.couponDescription';
        /* end */

        foreach ($html->find($_box) as $k=>$item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
            }else{
                $title = '';
            }

            if($item->find($_desc)){
                $desc = trim($item->find($_desc,0)->plaintext);
            }else{
                $desc = '';
            }

            if($item->find($_code,0)){
                $code = trim($item->find($_code,0)->plaintext);
            } else
                $code = '';

            $discountValue = '';
            if($_discount){
                if($item->find($_discount,0)){
                    $discountValue = trim($item->find($_discount,0)->plaintext);
                    $discountValue = str_replace('ONSALE','',$discountValue);
                    $discountValue = str_replace('OFF','',$discountValue);
                }
            }

            $verify = 0;
            if($_verify){
                if($item->find($_verify,0)){
                    $verify = 1;
                }
            }

            if($title){
                $a = [];
                $a['title'] = $title;
                $a['desc'] = $desc;
                $a['code'] = $code;
                $a['discount'] = str_replace('Sale','',$discountValue);
                $a['verify'] = $verify;

                array_push($arr,$a);
            }
        }
        return $arr;
    }
    public function getSlickdeals($alias) {
        $url = "https://slickdeals.net/coupons/$alias/";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = 'div[class="item"]';
        $_title = 'span[class="title cpbtn"]';
        $_code = ".buttonRight a";
        $_discount = '.intro .top';
        $_verify = '.verified';
        $_desc = '.extra';
        /* end */

        foreach ($html->find($_box) as $k=>$item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
            }else{
                $title = '';
            }

            if($item->find($_desc)){
                $desc = trim($item->find($_desc,0)->plaintext);
            }else{
                $desc = '';
            }

            if($item->find($_code,0)){
                $code = trim($item->find($_code,0)->{'data-clipboard-text'});
            } else
                $code = '';

            $discountValue = '';
            if($_discount){
                if($item->find($_discount,0)){
                    $discountValue = trim($item->find($_discount,0)->plaintext);
                    $discountValue = str_replace('ONSALE','',$discountValue);
                    $discountValue = str_replace('OFF','',$discountValue);
                }
            }

            $verify = 0;
            if($_verify){
                if($item->find($_verify,0)){
                    $verify = 1;
                }
            }

            if($title){
                $a = [];
                $a['title'] = $title;
                $a['desc'] = $desc;
                $a['code'] = $code;
                $a['discount'] = str_replace('Sale','',$discountValue);
                $a['verify'] = $verify;

                array_push($arr,$a);
            }
        }
        return $arr;
    }
    public function getCouponlawn($alias) {
        $url = "http://couponlawn.com/store-coupons/$alias-coupons/";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = '.item';
        $_title = 'h3';
        $_code = ".code-cover a";
        $_discount = '';
        $_verify = '';
        $_desc = '.desc';
        /* end */

        foreach ($html->find($_box) as $k=>$item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
                $title = trim(strip_tags($title));
            }else{
                $title = '';
            }

            if($item->find($_desc)){
                $desc = trim($item->find($_desc,0)->plaintext);
            }else{
                $desc = '';
            }

            if($item->find($_code,0)){
                $code = trim($item->find($_code,0)->{'data-rel'});
            } else
                $code = '';

            $discountValue = '';
            if($_discount){
                if($item->find($_discount,0)){
                    $discountValue = trim($item->find($_discount,0)->plaintext);
                    $discountValue = str_replace('ONSALE','',$discountValue);
                    $discountValue = str_replace('OFF','',$discountValue);
                }
            }

            $verify = 0;
            if($_verify){
                if($item->find($_verify,0)){
                    $verify = 1;
                }
            }

            if($title){
                $a = [];
                $a['title'] = $title;
                $a['desc'] = $desc;
                $a['code'] = $code;
                $a['discount'] = str_replace('Sale','',$discountValue);
                $a['verify'] = $verify;

                array_push($arr,$a);
            }
        }
        return $arr;
    }
    public function getGetcouponcodes($alias) {
        $url = "https://getcouponcodes.com/coupon-code/$alias";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];
        if( $html->find('font',0) && $html->find('font',0)->plaintext ){
            return $arr;
        }

        /* config DOM */
        $_box = '.item';
        $_title = '.itemdesc';
        $_code = ".code-text";
        $_discount = '';
        $_verify = '';
        $_desc = '#note_box';
        /* end */

        foreach ($html->find($_box) as $k=>$item) {
            if( $item->find('.dealmess',0) ){
                if($item->find($_title)){
                    $title = trim($item->find($_title,0)->plaintext);
                    $title = trim(strip_tags($title));
                }else{
                    $title = '';
                }

                if($item->find($_desc)){
                    $desc = trim($item->find($_desc,0)->plaintext);
                }else{
                    $desc = '';
                }

                if($item->find($_code,0)){
                    $code = trim($item->find($_code,0)->plaintext);
                } else
                    $code = '';

                $discountValue = '';
                if($_discount){
                    if($item->find($_discount,0)){
                        $discountValue = trim($item->find($_discount,0)->plaintext);
                        $discountValue = str_replace('ONSALE','',$discountValue);
                        $discountValue = str_replace('OFF','',$discountValue);
                    }
                }

                $verify = 0;
                if($_verify){
                    if($item->find($_verify,0)){
                        $verify = 1;
                    }
                }

                if($title){
                    $a = [];
                    $a['title'] = $title;
                    $a['desc'] = $desc;
                    $a['code'] = $code;
                    $a['discount'] = str_replace('Sale','',$discountValue);
                    $a['verify'] = $verify;

                    array_push($arr,$a);
                }
            }
        }
        return $arr;
    }
    public function getGetCoupontwo($domain) {
        $url = "http://www.coupontwo.com/coupons/$domain";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = '.media-body';
        $_title = 'h3';
        $_code = ".coupon_code_box a";
        $_discount = '';
        $_verify = '';
        $_desc = 'p';
        /* end */

        foreach ($html->find($_box) as $k=>$item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
                $title = trim(strip_tags($title));
            }else{
                $title = '';
            }

            if($item->find($_desc)){
                try{
                    $desc = trim($item->find($_desc,1)->plaintext);
                }catch (\Exception $ex){
                    $desc = '';
                }
            }else{
                $desc = '';
            }

            if($item->find($_code,0)){
                $code = trim($item->find($_code,0)->{'code'});
            } else
                $code = '';

            $discountValue = '';
            if($_discount){
                if($item->find($_discount,0)){
                    $discountValue = trim($item->find($_discount,0)->plaintext);
                    $discountValue = str_replace('ONSALE','',$discountValue);
                    $discountValue = str_replace('OFF','',$discountValue);
                }
            }

            $verify = 0;
            if($_verify){
                if($item->find($_verify,0)){
                    $verify = 1;
                }
            }

            if($title){
                if($item->find('a',0)->{'target'} == '_blank'){
                    $a = [];
                    $a['title'] = $title;
                    $a['desc'] = $desc;
                    $a['code'] = $code;
                    $a['discount'] = str_replace('Sale','',$discountValue);
                    $a['verify'] = $verify;

                    array_push($arr,$a);
                }
            }
        }
        return $arr;
    }
    public function getSavedoubler($alias) {
        $url = "https://www.savedoubler.com/$alias-promo-codes.html";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = '.offer-item';
        $_title = '.offer-title';
        $_code = ".offer-btn-wrap a";
        $_discount = '.offer-anchor span';
        $_verify = '';
        $_desc = '';
        /* end */

        foreach ($html->find($_box) as $k=>$item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
                $title = trim(strip_tags($title));
            }else{
                $title = '';
            }

            if($item->find($_desc)){
                $desc = trim($item->find($_desc,0)->plaintext);
            }else{
                $desc = '';
            }

            if($item->{'data-code'}){
                $code = $item->{'data-code'};
            } else
                $code = '';

            $discountValue = '';
            if($_discount){
                if($item->find($_discount,0)){
                    $discountValue = trim($item->find($_discount,0)->plaintext);
                    $discountValue = str_replace('Free','',$discountValue);
                    $discountValue = str_replace('Great','',$discountValue);
                }
            }

            $verify = 0;
            if($_verify){
                if($item->find($_verify,0)){
                    $verify = 1;
                }
            }

            if($title){
                $a = [];
                $a['title'] = $title;
                $a['desc'] = $desc;
                $a['code'] = $code;
                $a['discount'] = $discountValue;
                $a['verify'] = $verify;

                array_push($arr,$a);
            }
        }
        return $arr;
    }
    public function getCouponsgood($domain) {
        $url = "http://www.couponsgood.com/coupons/$domain";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = '.store_coupons_small';
        $_title = '.store_coupons_title_jump_left a';
        $_code = "input[type='hidden']";
        $_discount = '';
        $_verify = '';
        $_desc = '';
        /* end */

        foreach ($html->find($_box) as $k=>$item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
                $title = trim(strip_tags($title));
            }else{
                $title = '';
            }

            if($item->find($_desc)){
                try{
                    $desc = trim($item->find($_desc,1)->plaintext);
                }catch (\Exception $ex){
                    $desc = '';
                }
            }else{
                $desc = '';
            }

            if($item->find($_code,0)){
                $code = trim($item->find($_code,0)->value);
            } else
                $code = '';

            $discountValue = '';
            if($_discount){
                if($item->find($_discount,0)){
                    $discountValue = trim($item->find($_discount,0)->plaintext);
                    $discountValue = str_replace('ONSALE','',$discountValue);
                    $discountValue = str_replace('OFF','',$discountValue);
                }
            }

            $verify = 0;
            if($_verify){
                if($item->find($_verify,0)){
                    $verify = 1;
                }
            }

            if($title){
                $a = [];
                $a['title'] = $title;
                $a['desc'] = $desc;
                $a['code'] = $code;
                $a['discount'] = str_replace('Sale','',$discountValue);
                $a['verify'] = $verify;

                array_push($arr,$a);
            }
        }
        return $arr;
    }
    public function getCopypromocode($alias) {
        $url = "http://copypromocode.com/coupons/$alias.html";
        $html = $this->getHtmlViaProxy($url);
        $arr = [];

        /* config DOM */
        $_box = '.offer-item';
        $_title = '.offer-title';
        $_code = ".offer-btn-wrap a";
        $_discount = '.offer-anchor span';
        $_verify = '';
        $_desc = '';
        /* end */

        foreach ($html->find($_box) as $k=>$item) {
            if($item->find($_title)){
                $title = trim($item->find($_title,0)->plaintext);
                $title = trim(strip_tags($title));
            }else{
                $title = '';
            }

            if($item->find($_desc)){
                $desc = trim($item->find($_desc,0)->plaintext);
            }else{
                $desc = '';
            }

            if($item->{'data-code'}){
                $code = $item->{'data-code'};
            } else
                $code = '';

            $discountValue = '';
            if($_discount){
                if($item->find($_discount,0)){
                    $discountValue = trim($item->find($_discount,0)->plaintext);
                    $discountValue = str_replace('Free','',$discountValue);
                    $discountValue = str_replace('Great','',$discountValue);
                }
            }

            $verify = 0;
            if($_verify){
                if($item->find($_verify,0)){
                    $verify = 1;
                }
            }

            if($title){
                $a = [];
                $a['title'] = $title;
                $a['desc'] = $desc;
                $a['code'] = $code;
                $a['discount'] = $discountValue;
                $a['verify'] = $verify;

                array_push($arr,$a);
            }
        }
        return $arr;
    }

    /*  */
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