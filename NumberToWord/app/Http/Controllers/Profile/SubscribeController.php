<?php namespace App\Http\Controllers\Profile;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;

class SubscribeController extends Controller {
	public function __construct()
	{
		$this->middleware('auth');
		if (!Auth::guest()){
			$this->dataPage = [
				'active' => [
					'pro' => '',
					'sav' => '',
					'fav' => '',
					'pre' => '',
					'com' => '',
					'cas' => '',
					'ref' => '',
					'sub' => 'active'
				],
				'user' => Auth::user()->getAttributes()
			];
			$this->data['seoConfig']['title'] = 'Profile Center - ' . config('config.domain');
			$this->dataPage['showSignStep'] = false;
		}
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $this->data['categories'] = $this->_submitHTTPGet(config('config.api_url').'categories/?attributes[]=name&attributes[]=id',[
            'where[status]' => 'published',
            'order[column]'=>'name',
            'order[dir]'=>'ASC',
            'limit' => -1
        ]);

        $selfSubscribe = $this->_submitHTTPGet(config('config.api_url').'alerts/',[
            'where[userId]' => Auth::user()->id,
            'findType'=>'findOne',
        ]);

        if($selfSubscribe == null){
            $selfSubscribe = [
                'type'      => 'never',
                'storeIds'  => [],
                'categoryIds' => [],
                'systemAlert' => 0,
                'personAlert' => 0
            ];
        }else{
            //$selfSubscribe = json_decode($selfSubscribe);
            $selfSubscribe['storeIds']      = json_decode($selfSubscribe['storeIds']);
            $selfSubscribe['categoryIds']   = json_decode($selfSubscribe['categoryIds']);
        }
        $this->data['selfSubscribe'] = $selfSubscribe;
        /*echo "<pre>";
        print_r($this->data['selfSubscribe']['categoryIds']);
        echo "</pre>";
        die;*/
        /*$array = ["a", "b", "c"];
        if(in_array('a', $array)){
            echo "<pre>";
            print_r($this->data['selfSubscribe']['categoryIds']);
            echo "</pre>";
            die;
        }*/

        return view('profile.v2-subscribe')->with(array_merge($this->dataPage, $this->data));
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
	 * @param  Request $request
	 * @return Response
	 */
	public function update(Request $request)
	{
        $data = $request->all();
        $data['userId'] = Auth::user()->id;
        $result = $this->_submitHTTPPost(config('config.api_url') . 'alerts/createOrUpdate/', $data);
        if ($result['code'] != 0) {
            return response()->json(['status' => 'error','msg' => $result['msg']]);
        }
		return [
            'status' => 'success'
        ];
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
