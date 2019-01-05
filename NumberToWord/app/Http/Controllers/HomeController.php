<?php namespace App\Http\Controllers;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/
    var $dataCommon = array();

	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 */

    /**
     * @return \Illuminate\View\View
     */
	public function index()
	{

	    $this->dataCommon['common'] = array(
	        'logo'          => asset('images/DV-Logo.svg'),
	        'logoTitle'     => 'Discount Voucher Home Page'
	    );

	    $dataPage = array(
	        'seo'          => array(
	            'title'        => 'Discount Voucher Title',
	            'keywords'     => 'Discount Voucher keywords',
	            'description'  => 'Discount Voucher description',
	            'image'        => ''
	        ),
	        'adv_slider'   => array(

	        ),
	        'logo_slider'  =>array(

	        )
	    );
		return view('home', $dataPage, $this->dataCommon);
	}

}
