<?php namespace App\Http\Controllers\Profile;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Http\Request;

class PreferenceController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
        if (!Auth::guest()){
            $this->dataPage = [
                'active' => [
                    'pro' => '',
                    'sav' => '',
                    'fav' => '',
                    'pre' => 'active',
                    'com' => '',
					'cas' => '',
					'ref' => '',
					'sub' => ''
                ],
                'user' => Auth::user()->getAttributes()
            ];
            $this->data['seoConfig']['title'] = 'Profile Center - ' . config('config.domain');
            $this->data['alerts'] = $this->getAlert($this->dataPage['user']['id']);
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
		$results['stores'] = $result['stores'] = $this->_submitHTTPGet(config('config.api_url') . 'users/favouriteStores/'.$this->dataPage['user']['id'].'/', []);
		// unset store id already exist in alert
		if($results['stores'] && $this->data['alerts']){
			foreach ($results['stores'] as $k=>$s) {
				foreach ($this->data['alerts']['storeIds'] as $a) {
					if($s['id'] == $a['id']){
						unset($results['stores'][$k]);
					}
				}
			}
		}

        return view('profile.preference')->with(array_merge($this->dataPage, $results, $this->data));
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

    public function changeEmail(Request $request){
        if ($request->isMethod('post')) {
            $data = array_filter($request->all());
            $data['id'] = $this->dataPage['user']['id'];
            if (!empty($data['email'])) {
                $data['checkPassword'] = 1;
                $result = $this->_submitHTTPPost(config('config.api_url') . 'users/update/', $data);
                if (!empty($result['type']) && $result['type'] == 'error') {
                    return response()->json(['status' => 'error','msg' => $result['message']]);
                }
            }
            if (!empty($data['passwordNew'])) {
                if (empty($this->dataPage['user']['password'])) $data['isSocial'] = 1;
                $result = $this->_submitHTTPPost(config('config.api_url') . 'users/changePassword/', $data);
                if (!empty($result['type']) && $result['type'] == 'error') {
                    return response()->json(['status' => 'error','msg' => $result['message']]);
                }
            }
            return response()->json(['status' => 'success']);
        }
    }

    public function changePassword(Request $request){
        if ($request->isMethod('post')) {
            $data = array_filter($request->all());
            $data['id'] = $this->dataPage['user']['id'];
            if (empty($this->dataPage['user']['password'])) $data['isSocial'] = 1;
            $result = $this->_submitHTTPPost(config('config.api_url') . 'users/changePassword/', $data);
            if (!empty($result['type']) && $result['type'] == 'error') {
                return response()->json(['status' => 'error','msg' => $result['message']]);
            }else return response()->json(['status' => 'success']);
        }
    }

    public function getAlert($userId){
    	$alerts = $this->_submitHTTPGet(config('config.api_url').'alerts/',[
            'where[userId]' => $userId,
            'findType'=>'findOne'
        ]);
        if($alerts['storeIds']){
        	$cond = '';
        	$glue = 'where[id][$in][]=';
        	$alerts['storeIds'] = explode(',', $alerts['storeIds']);
        	foreach ($alerts['storeIds'] as $k=>$v) {
        		$cond .= $glue . $v;
        		if($k < count($alerts['storeIds'])){
        			$cond .= '&';
        		}
        	}
			$arrStores = $this->_submitHTTPGet(config('config.api_url').'stores/?'.$cond, []);
	        $alerts['storeIds'] = $arrStores;
        }
        return $alerts;
    }

    public function saveAlert(Request $request){
    	return $this->_submitHTTPPost(config('config.api_url') . 'alerts/createOrUpdate/', $request->all());
    }
}
