<?php
/**
 * Created by PhpStorm.
 * User: Phuong
 * Date: 6/30/2017
 * Time: 2:52 PM
 */

namespace App\Http\Controllers;

use App;
use DB;
use PDO;
use URL;

class FeedController extends Controller
{
    protected function hashTag($storeName, $keyword, $location)
    {
        $result = '#' . $storeName . ' #' . $storeName . $keyword . ' #' . config('config.domain');
        if ($location == 'US' || $location == 'U1')
            $result .= ' #Coupons #Couponcode #Onlineshopping #Onlinecoupons #discountcouponcodes #promocodes'
            .' #Onlinesalecoupons #promotionalcouponcodes #freecouponcodes #discountcoupons #freepromocode #freeshipping #free';
        elseif ($location == 'GB' || $location == 'G1')
            $result .=' #MoneySaving #freedelivery #discountvouchercodes #promocodes #voucher'
                .' #vouchercodes #freevouchercodes #discountvoucher #freepromocode #free';
        return $result;
    }

    //https://github.com/RoumenDamianoff/laravel-feed
    public function stores()
    {
        // create new feed
        $feed = App::make("feed");

        // multiple feeds are supported
        // if you are using caching you should set different cache keys for your feeds

        // cache the feed for 60 minutes (second parameter is optional)
        $feed->setCache(60, 'feedStoresKey');

        // check if there is cached feed and build new only if is not
        if (!$feed->isCached()) {
            // creating rss feed with our most recent 20 posts
            DB::setFetchMode(PDO::FETCH_ASSOC);
            $stores = DB::connection()->table('stores')
                ->join('users as uc', 'uc.id', '=', 'stores.author')
                ->select('stores.id', 'stores.name', 'stores.short_description', 'stores.logo', 'stores.created_at', 'stores.updated_at', 'stores.status',
                    'stores.countrycode', 'stores.countryname', 'stores.alias', 'stores.custom_keywords',
                    'stores.meta_title', 'stores.meta_desc', 'stores.coupons', 'stores.cash_back_json',
                    'uc.username as author_created')
                ->where('stores.countrycode', '=', config('config.location'))
                ->where('stores.status', '=', 'published')
                ->orderBy('stores.updated_at', 'desc')->take(300)->get();
            DB::setFetchMode(PDO::FETCH_CLASS);
            // set your feed's title, description, link, pubdate and language
            $feed->title = config('config.domain').' Stores';
            $feed->description = config('config.domain').' Stores';
            $feed->logo = asset('images/logo.png');
            $feed->link = url('feed/stores');
            $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
            $feed->pubdate = $stores[0]['created_at'];
            $feed->lang = 'en';
            $feed->setShortening(true); // true or false
            $feed->setTextLimit(500); // maximum length of description text
            $seoConfig = $this->_submitHTTPGet(config('config.api_url').'seo_configs/?where[countrycode]=' . config('config.location'),[]);

            foreach ($stores as $store) {
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
                    foreach ($seoConfig as $s) {
                        if ($s['optionName'] == 'seo_storeTitle') {
                            $title = $s['optionValue'];
                        }
                        if ($s['optionName'] == 'seo_storeDesc') {
                            $metaDescription = $s['optionValue'];
                        }
                        if ($s['optionName'] == 'seo_storeKeyword') {
                            $metaKeyword = $s['optionValue'];
                        }
                        if ($s['optionName'] == 'seo_siteName') {
                            $siteName = $s['optionValue'];
                        }
                        if ($s['optionName'] == 'seo_siteDescription') {
                            $siteDesc = $s['optionValue'];
                        }
                        if ($s['optionName'] == 'seo_storeH1') {
                            $storeHeaderH1 = $s['optionValue'];
                        }
                        if ($s['optionName'] == 'seo_storeP') {
                            $storeHeaderP = $s['optionValue'];
                        }
                        if ($s['optionName'] == 'seo_disableStoreNoIndex') {
                            $disableNoindex = $s['optionValue'];
                        }

                        if ($s['optionName'] == 'seo_defaultStoreTitle') {
                            $seo_defaultStoreTitle = $s['optionValue'];
                        }
                        if ($s['optionName'] == 'seo_defaultStoreMetaDescription') {
                            $seo_defaultStoreMetaDescription = $s['optionValue'];
                        }
                        if ($s['optionName'] == 'seo_defaultStoreMetaKeyword') {
                            $seo_defaultStoreMetaKeyword = $s['optionValue'];
                        }
                        if ($s['optionName'] == 'seo_defaultH1Store') {
                            $seo_defaultH1Store = $s['optionValue'];
                        }
                        if ($s['optionName'] == 'seo_defaultPStore') {
                            $seo_defaultPStore = $s['optionValue'];
                        }
                    }
                    if (isset($disableNoindex)) {
                        $rs['disableNoindex'] = $disableNoindex;
                    }

                    $storeName = $store['name'];
                    $storeCoupons = json_decode($store['coupons'],true);
                    if (sizeof($storeCoupons) > 0) {
                        $couponTitle = $storeCoupons[0]['title'];
                        $couponDiscount = $storeCoupons[0]['discount'];
                    } else {
                        $couponTitle = '';
                        $couponDiscount = '';
                    }

                    $configSelfSeoTitle = (!empty($store['meta_title'])) ? $store['meta_title'] : null;
                    $configSelfSeoDesc  = (!empty($store['meta_desc'])) ? $store['meta_desc'] : null;
                    $storeCashBacks = json_decode($store['cash_back_json'],true);
                    $upToCashBack = sizeof($storeCashBacks) > 0 ? (!empty($storeCashBacks[0]['cash_back_percent']) ? $storeCashBacks[0]['cash_back_percent'].'%' : $storeCashBacks[0]['currency'].$storeCashBacks[0]['cash_back']) : '';
                    if (isset($title)) {
                        if (!$couponDiscount) {
                            $rs['title'] = $this->seoConvert($configSelfSeoTitle ? $configSelfSeoTitle : $seo_defaultStoreTitle, $siteName, $siteDesc, $storeName,
                                $couponTitle, $couponDiscount, $upToCashBack, true);
                        } else {
                            $rs['title'] = $this->seoConvert($configSelfSeoTitle ? $configSelfSeoTitle : $title, $siteName, $siteDesc, $storeName, $couponTitle,
                                $couponDiscount.$storeCoupons[0]['currency'], $upToCashBack, true);
                        }
                    }
                    if (isset($metaDescription)) {
                        if (!$couponDiscount) {
                            $rs['desc'] = $this->seoConvert($configSelfSeoDesc? $configSelfSeoDesc : $seo_defaultStoreMetaDescription, $siteName, $siteDesc, $storeName,
                                $couponTitle, $couponDiscount, $upToCashBack);
                        } else {
                            $rs['desc'] = $this->seoConvert($configSelfSeoDesc? $configSelfSeoDesc : $metaDescription, $siteName, $siteDesc, $storeName, $couponTitle,
                                $couponDiscount.$storeCoupons[0]['currency'], $upToCashBack);
                        }
                    }
                    if (isset($metaKeyword)) {
                        if (!$couponDiscount) {
                            $rs['keyword'] = $this->seoConvert($seo_defaultStoreMetaKeyword, $siteName, $siteDesc, $storeName,
                                $couponTitle, $couponDiscount, $upToCashBack);
                        } else {
                            $rs['keyword'] = $this->seoConvert($metaKeyword, $siteName, $siteDesc, $storeName, $couponTitle,
                                $couponDiscount.$storeCoupons[0]['currency'], $upToCashBack);
                        }
                    }
                    if (isset($storeHeaderH1)) {
                        if (!$couponDiscount) {
                            $rs['storeHeaderH1'] = $this->seoConvert($seo_defaultH1Store, $siteName, $siteDesc, $storeName, $couponTitle,
                                $couponDiscount, $upToCashBack);
                        } else {
                            $rs['storeHeaderH1'] = $this->seoConvert($storeHeaderH1, $siteName, $siteDesc, $storeName, $couponTitle,
                                $couponDiscount.$storeCoupons[0]['currency'], $upToCashBack);
                        }
                    }
                    if (isset($storeHeaderP)) {
                        if (!$couponDiscount) {
                            $rs['storeHeaderP'] = $this->seoConvert($seo_defaultPStore, $siteName, $siteDesc, $storeName, $couponTitle,
                                $couponDiscount, $upToCashBack);
                        } else {
                            $rs['storeHeaderP'] = $this->seoConvert($storeHeaderP, $siteName, $siteDesc, $storeName, $couponTitle,
                                $couponDiscount.$storeCoupons[0]['currency'], $upToCashBack);
                        }
                    }

                }
                $enclosure = ['url' => $store['logo']];
                // set item's title, author, url, pubdate, description, content, enclosure (optional)*
                $feed->add(
                    !empty($rs['title']) ? $rs['title'] : $store['name'],
                    $store['author_created'],
                    URL::to($store['alias'].config('config.suffix_coupon')),
                    $store['created_at'],
//                    $this->hashTag($store['name'], $store['custom_keywords'], config('config.location')). ' ' . (!empty($store['short_description']) ? $store['short_description'] : $rs['desc']),
                    (!empty($store['short_description']) ? $store['short_description'] : $rs['desc']),
                    $rs['desc'],
                    $enclosure
                );
            }

        }

        // first param is the feed format
        // optional: second param is cache duration (value of 0 turns off caching)
        // optional: you can set custom cache key with 3rd param as string
        return $feed->render('rss');

        // to return your feed as a string set second param to -1
        // $xml = $feed->render('atom', -1);
    }
    public function coupons()
    {
        // create new feed
        $feed = App::make("feed");

        // multiple feeds are supported
        // if you are using caching you should set different cache keys for your feeds

        // cache the feed for 60 minutes (second parameter is optional)
        $feed->setCache(60, 'feedCouponsKey');

        // check if there is cached feed and build new only if is not
        if (!$feed->isCached()) {
            // creating rss feed with our most recent 20 posts
            $coupons = DB::connection()->table('coupons')
                ->join('stores as us', 'us.id', '=', 'coupons.store_id')
                ->join('properties as up', 'up.foreign_key_left', '=', 'coupons.id')
                ->join('users as uc', 'uc.id', '=', 'coupons.author')
                ->select('coupons.id', 'coupons.title', 'coupons.description', 'coupons.coupon_image', 'coupons.created_at', 'coupons.updated_at', 'coupons.status',
                    'coupons.countrycode', 'coupons.countryname', 'us.meta_title', 'us.meta_desc', 'us.status',
                    'coupons.store_id', 'us.alias AS store_alias', 'up.foreign_key_right AS go', 'us.logo as store_logo', 'us.name as store_name', 'us.custom_keywords',
                    'uc.username as author_created')
                ->where('coupons.countrycode', '=', config('config.location'))
                ->where('us.status', '=', 'published')
                ->where('coupons.status', '=', 'published')
                ->orderBy('coupons.updated_at', 'desc')->take(300)->get();

            // set your feed's title, description, link, pubdate and language
            $feed->title = config('config.domain').' Coupons';
            $feed->description = config('config.domain').' Coupons';
            $feed->logo = asset('images/logo.png');
            $feed->link = url('feed/coupons');
            $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
            $feed->pubdate = $coupons[0]->created_at;
            $feed->lang = 'en';
            $feed->setShortening(true); // true or false
            $feed->setTextLimit(250); // maximum length of description text
            foreach ($coupons as $coupon) {

                $enclosure = ['url' => !empty($coupon->coupon_image) ? $coupon->coupon_image : $coupon->store_logo];
                // set item's title, author, url, pubdate, description, content, enclosure (optional)*
                $feed->add(
                    $coupon->store_name . ' '. $coupon->custom_keywords . ' '. $coupon->title,
                    $coupon->author_created,
                    URL::to($coupon->store_alias.config('config.suffix_coupon')). '?c='.$coupon->go,
                    $coupon->created_at,
//                    $this->hashTag($coupon->store_name, $coupon->custom_keywords, config('config.location')). ' ' . $coupon->description,
                    $coupon->description,
                    $coupon->meta_desc,
                    $enclosure);
            }

        }

        // first param is the feed format
        // optional: second param is cache duration (value of 0 turns off caching)
        // optional: you can set custom cache key with 3rd param as string
        return $feed->render('rss');

        // to return your feed as a string set second param to -1
        // $xml = $feed->render('atom', -1);
    }
}