<?php namespace App\Http\Controllers\Profile;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request as Re;

use Auth;
use Illuminate\Http\Request;
use Session;

class FavouriteController extends Controller {

    public function __construct()
    {
        // $this->middleware('auth');
        $this->dataPage =
            [
                'active' =>
                    [
                        'pro' => '',
                        'sav' => '',
                        'fav' => 'active',
                        'pre' => '',
                        'com' => '',
                        'cas' => '',
                        'ref' => '',
                        'sub' => ''
                    ]
            ];
        $this->data['seoConfig']['title'] = 'Favourite Stores - Profile Center - ' . config('config.domain');
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
            $result['stores'] = [];
            $result['recommended'] = [];
            $result['popular'] = [];
        }else{
            $result['stores'] = $this->_submitHTTPGet(config('config.api_url') . 'users/favouriteStores/'.$this->dataPage['user']['id'].'/', [
                'c_limit' => 18,
                'c_offset' => 0
            ]);
            Session::forget('favorite-stores-more-'.$this->dataPage['user']['id']);
            $result['recommended'] = $this->_submitHTTPGet(config('config.api_url') . 'users/suggestStore/'.$this->dataPage['user']['id'].'/',[
                'c_limit' => 18,
                'c_location' => config('config.location')]);
        }
        return view('profile.v2-favourite')->with(array_merge($this->dataPage,$result, $this->data));
    }
    public function showMore(){
        if(Auth::guest()){
            $result['coupons'] = [];
            return response()->json(['status' => 'error','coupons' => []]);
        }else{
            $offset = Session::has('favorite-stores-more-'.$this->dataPage['user']['id']) ? Session::get('favorite-stores-more-'.$this->dataPage['user']['id']) : 36;
            $result['stores'] = $this->_submitHTTPGet(config('config.api_url') . 'users/favouriteStores/'.$this->dataPage['user']['id'].'/', [
                'c_limit' => 18,
                'c_offset' => $offset - 18
            ]);
            if (!sizeof($result['stores'])) return response()->json(['status' => 'error','stores' => []]);
            Session::put('favorite-stores-more-'.$this->dataPage['user']['id'],intval($offset) + 20);
        }
        return view('elements.v2-parent-fav-stores')->with($result);
    }

    public function findStoreNotInFavourite(Re $request){
        if ($request->ajax()){
            $limit = 10;
            $keyword = $request->input('kw');
            $page = $request->input('page') > 0 ? $request->input('page') : 0;
            $page = $page * $limit;
            $data = $this->_submitHTTPPost(config('config.api_url') . 'users/findStoreNotInFavourite/',[
                'userId'=> $this->dataPage['user']['id'],
                'c_limit'=> $limit,
                'c_offset'=> $page,
                'keyword' => $keyword,
                'c_location' => config('config.location')
            ]);
            return response()->json(['status' => 'success','items' => $data]);
        }
        return response()->json(['status' => 'error','items' => []]);
    }

    public function getDataFromBrowser(Re $request){
        $data = $request->all();
        $ids = $data['ids'] ? $data['ids'] : [];
        $type = $data['type'] . '/';
        $API_PATH = config('config.api_url');

        if($ids && $type == 'stores/'){
            $arrFavs = explode(',', $ids);
            $result = $this->_submitHTTPGet($API_PATH . $type, [
                'attributes' => ['id','name','logo','alias'],
                'where[id][$in]' => $arrFavs,
                'limit' => 100,
            ]);
            return $result;
        }else if($ids && $type == 'coupons/'){
            $arrSaved = explode(',', $ids);
            $cond = '?include[stores]&include[properties]&include[properties][attribute][]=foreignKeyRight&';

            // return $this->_submitHTTPGet($API_PATH . $type . $cond, []);
            $rs['coupons'] = $this->_submitHTTPGet($API_PATH . $type . $cond, [
                'include[stores][attribute]' => ['name','logo','alias','storeUrl'],
                'where[id][$in]' => $arrSaved,
                'limit' => 100,
            ]);
            return view('elements.v2-parent-box-store-coupon-2')->with($rs);
        }
        else{
            return [];
        }
    }

    public function getCouponsFromSaved(Re $request){
        $data = $request->all();
        $cond = '';
        $glue = 'where[id][$in][]=';
        if($data['favs']){
            $arrFavs = explode(',', $data['favs']);
            $cond = '?' . $glue . implode('&' . $glue, $arrFavs);
            return $this->_submitHTTPGet(config('config.api_url'). 'stores/' . $cond, []);
        }else{
            return [];
        }
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
