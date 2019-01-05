<?php
/**
 * Created by PhpStorm.
 * User: Phuong
 * Date: 7/3/2015
 * Time: 11:06 AM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request as Re;

class DealController extends Controller
{
    public function index()
    {
        $data = $this->_submitHTTPGet(config('config.api_url') . 'deals/newestDeals/', [
            'limit' => 20,
            'c_location' => config('config.location')
        ]);
        $data['seoConfig']['title'] = 'Best Deals Online - Daily Deals - Plus Free Shipping!';
        $data['seoConfig']['desc'] = 'Save money on plenty of today�s best deals for TOP brands and apps. Even better, these deals are the best of the best you should pick and choose.';
        return view('dealsAll', $data);
    }
    public function showMore(Re $request){
        if ($request->ajax()) {
            $para = $request->all();
            $data['deals'] = $this->_submitHTTPGet(config('config.api_url') . 'deals/newestDeals/showMore/', [
                'page' => $para['page'],
                'categoryId' => $para['categoryId'],
                'limit' => 20,
                'c_location' => config('config.location')
            ]);
            if (!empty($data['deals']))
                return view('elements.deals-list',$data);
            else return response()->json(['status' => 'error','deals' => []]);
        } else return response()->json(['status' => 'error','deals' => []]);
    }
}