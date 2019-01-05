<?php
namespace App\Http\Controllers;

class LinkExchangeController extends Controller{


    public function index($p = ''){
        $config = [
            'header' => 'Link Exchange ',
            'header_desc' => '<b><i>CouponMarathon.com</i></b> provides useful <b>coupons, deals, discounts, promo codes</b> and other attractive offers to help you save your pocket. Established by professional team, Coupons Plus Deals updates <i>thousands of verified</i><i><b> coupon codes</b></i><i> and</i><i><b> deals </b></i> on affiliated stores both online and in-store around the world.<br />
							If you run a commerce website, we welcome you to submit your URL for a reciprocal link exchange. We are happy to exchange reciprocal links with all websites all around the world.<br /><br /> 
							-	<b>Step 1:</b> Add our link to your site with following information:
									<ul>
										<li>Website URL: <u><a href ="https://CouponMarathon.com/">https://CouponMarathon.com/</a></u></li>
										<li>Anchor Text: Best discounts and coupons with CouponsPlusDeals</li>
										<li>Description: CouponsPlusDeals.com is an ultimate website which has partnership with more than 200,000 merchants worldwide, uploading their coupons and discounts for massive saving</li>
									</ul>
							
							Or simply copy the html code below:<br /><br />
							-	<b>Step 2:</b> Send your detail information including your <b>URL, Title, Description</b> and <b>Reciprocal Link to our site</b> via email at <i><u>marketing.couponsplusdeals@gmail.com</u></i>
							We look forward to hearing from you.<br /> 
							In case you want your link posted on our homepage, please directly contact me via emails to receive our Media Advertising Kit. <br />
							<hr/>
							',
            'element' => [
            ],
        ];
        $seoConfig = [
            'title' => 'Link Exchange',
            'desc' => ' Daily Coupons & Discounts - Couponsplusdeals.com'
        ];
//dd($config);
        return view('home-linkexchange')->with($config,$seoConfig);
    }



}