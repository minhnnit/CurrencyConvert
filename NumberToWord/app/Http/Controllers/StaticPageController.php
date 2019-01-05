<?php
/**
 * Created by PhpStorm.
 * User: Phuong
 * Date: 6/11/2015
 * Time: 3:36 PM
 */

namespace App\Http\Controllers;
use DB;


class StaticPageController extends Controller{

    private function getPageContent($docKey, $pageTitle, $noIndex = false){
        $result = $this->_submitHTTPGet(config('config.api_url') . 'static_pages', [
            'c_location' => config('config.location'),
            'findType' => 'findOne',
            'where[docKey]' => $docKey,
            'where[domain]' => url().'/'
        ]);
        $result['title'] = $pageTitle;

        if($noIndex == true){
            $result['noRobot'] = true;
        }

        if(!isset($result['id'])){
            $result['docValue'] = 'Tada!';
        }
        return $result;
    }

    public function usingCoupon() {
        return view('static-page')->with($this->getPageContent('howToGuides', 'Using a ' . config('config.Coupon')));
    }

    public function submittingCoupon() {
        return view('static-page')->with($this->getPageContent('submit_coupon', 'Submitting a ' . config('config.Coupon')));
    }

    public function managingAccount() {
        return view('static-page')->with($this->getPageContent('careers', 'Managing my account'));
    }

    public function merchantHelp() {
        return view('static-page')->with($this->getPageContent('help', 'Merchant Help'));
    }

    public function termsPage() {
        return view('static-page')->with($this->getPageContent('terms', 'Terms & Conditions Conditions', true));
    }

    public function privacyPolicy() {
        return view('static-page')->with($this->getPageContent('privacy', 'Privacy Policy Cookie Policy', true));
    }

    public function customerSupport() {
        return view('static-page')->with($this->getPageContent('customer_support', 'Customer Support'));
    }

    public function advertise() {
        return view('static-page')->with($this->getPageContent('advertise', 'Advertise'));
    }

    public function media() {
        return view('static-page')->with($this->getPageContent('media', 'Media'));
    }

    public function press() {
        return view('static-page')->with($this->getPageContent('press', 'Press'));
    }

    public function investors() {
        return view('static-page')->with($this->getPageContent('investors', 'Investors'));
    }

    public function aboutUs() {
        return view('static-page')->with($this->getPageContent('about', 'About Us'));
    }

    public function dmca() {
        return view('static-page')->with($this->getPageContent('dmca', 'Digital Millennium Copyright Act'));
    }

    public function toArray($data) {
        return json_decode(json_encode($data,1),1);
    }
    public function scholarship() {
        $data = [
            'seo' => [
                'title' => strtoupper($GLOBALS['asset_domain']) . ' - Save for Future Scholarship',
                'metaTitle' => strtoupper($GLOBALS['asset_domain']) . ' - Save for Future Scholarship',
                'metaDescription' => 'Get $3000 "Save For Future" Scholarship with an essay about how coupons help you get discount when shopping'
            ],
            'googleForm' => 'https://docs.google.com/forms/d/1pMa5BgCn5xvEAu_Bb30P7RtpeJn3E8PXccmQO-t15tM',
            'officalRules' => 'https://drive.google.com/file/d/16HZuLG4kRkXNduVEsHM6pxXhJrPmrjZp/view'
        ];
        $source = DB::select( DB::raw('
            SELECT * FROM stores WHERE best_store = 1 OR show_in_homepage = 1 OR sticky = 1 order by created_at DESC LIMIT 60
        '));
        if(!empty($source)){
            $data['popularStores'] = $this->toArray($source);
        }

        return view('scholarship')->with($data);
    }

}