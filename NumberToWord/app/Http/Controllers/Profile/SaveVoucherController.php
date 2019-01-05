<?php namespace App\Http\Controllers\Profile;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Http\Request;
use Session;

class SaveVoucherController extends Controller {

    public function __construct()
    {
        // $this->middleware('auth');
        $this->dataPage =
            [
                'active' =>
                    [
                        'pro' => '',
                        'sav' => 'active',
                        'fav' => '',
                        'pre' => '',
                        'com' => '',
                        'cas' => '',
                        'ref' => '',
                        'sub' => ''
                    ]
            ];
        $this->data['seoConfig']['title'] = 'Save '. config('config.Coupon') .'s - Profile Center - ' . config('config.domain');
        if (!Auth::guest()){
            $this->dataPage['user'] = Auth::user()->getAttributes();
            $this->dataPage['showSignStep'] = false;
        }else{
            $this->dataPage['user'] = ['fullname' => 'Guest','bio' => ''];
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if(Auth::guest()){
            $result['coupons'] = [];
        }else{
            $result['coupons'] = $this->_submitHTTPGet(config('config.api_url') . 'coupons/getSaveCouponsV2/'.$this->dataPage['user']['id'].'/', [
                'c_limit' => 20,
                'c_offset' => 0
            ]);
            Session::forget('saved-coupons-more-'.$this->dataPage['user']['id']);
            if (Session::has('user.id')) {
                $query = '?';

                if (sizeof($result['coupons'])) {
                    foreach ($result['coupons'] as $c) {
                        $query .= 'uuids[]=' . $c['id'] . '&' . 'uuids[]=' . $c['s_id'] . '&';
                    }
                }

                $query .= 'userId=' . Session::get('user.id');
                $result['favourites'] = $this->_submitHTTPGet(config('config.api_url') . 'favourites/getFavourites' .$query,['c_location' => config('config.location')]);
            }
        }
        return view('profile.v2-saved-coupon')->with(array_merge($this->dataPage,$result, $this->data));
    }

    public function showMore(){
        if(Auth::guest()){
            $result['coupons'] = [];
            return response()->json(['status' => 'error','coupons' => []]);
        }else{
            $offset = Session::has('saved-coupons-more-'.$this->dataPage['user']['id']) ? Session::get('saved-coupons-more-'.$this->dataPage['user']['id']) : 40;
            $result['coupons'] = $this->_submitHTTPGet(config('config.api_url') . 'coupons/getSaveCouponsV2/'.$this->dataPage['user']['id'].'/', [
                'c_limit' => 20,
                'c_offset' => $offset - 20
            ]);
            if (!sizeof($result['coupons'])) return response()->json(['status' => 'error','coupons' => []]);
            if (Session::has('user.id')) {
                $query = '?';

                if (sizeof($result['coupons'])) {
                    foreach ($result['coupons'] as $c) {
                        $query .= 'uuids[]=' . $c['id'] . '&';
                    }
                }

                $query .= 'userId=' . Session::get('user.id');
                $result['favourites'] = $this->_submitHTTPGet(config('config.api_url') . 'favourites/getFavourites' .$query,['c_location' => config('config.location')]);
            }
            Session::put('saved-coupons-more-'.$this->dataPage['user']['id'],intval($offset) + 20);
        }
        return view('elements.v2-parent-box-store-coupon')->with($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
