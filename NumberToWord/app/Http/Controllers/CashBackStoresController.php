<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Session;

class CashBackStoresController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
        $param = $request->all();
        $data = $this->_submitHTTPPost(config('config.api_url') . 'stores/cashBackStore/',[
            'filterName' => '',
            'filterCharacter' => '',
            'filterCategories' => [],
            'c_location' => config('config.location'),
            'c_limit' => 20,
            'c_offset' => 0
        ]);
		$data['seoConfig'] = [
			'title' => 'Get Top Cashback & cash back deals on all your purchases',
			'desc' => 'Find coupons and earn cash back at over 2600 stores including Amazon, 6pm, Udemy & more when shopping at '.config('config.domain').'. Earn up to 10% CashBack Shopping today!'
		];

        if (Session::has('user.id')) {
            $query = '?';

            if (sizeof($data['data']['topStoresCashBack'])) {
                foreach ($data['data']['topStoresCashBack'] as $s) {
                    $query .= 'uuids[]=' . $s['id'] . '&';
                }
            }

            if (!empty($data['data']['stores']) && sizeof($data['data']['stores']['rows'])) {
                foreach ($data['data']['stores']['rows'] as $s) {
                    $query .= 'uuids[]=' . $s['id'] . '&';
                }
            }

            $query .= 'userId=' . Session::get('user.id');
            $data['favourites'] = $this->_submitHTTPGet(config('config.api_url') . 'favourites/getFavourites' .$query,['c_location' => config('config.location')]);
        }
        Session::put('cash-back-stores-offset',0);
        Session::put('cash-back-stores-filter-char','');
        Session::put('cash-back-stores-filter-cat',[]);
		return view('cashBackStores')->with($data);
	}

    public function showMoreStores(Request $request){
        Session::put('cash-back-stores-offset',Session::has('cash-back-stores-offset') ? Session::get('cash-back-stores-offset') + 20 : 20);
//        $param = $request->all();
        $data = $this->_submitHTTPPost(config('config.api_url') . 'stores/cashBackStoreShowMore/',[
            'filterName' => '',
            'filterCharacter' => !empty(Session::get('cash-back-stores-filter-char')) ? Session::get('cash-back-stores-filter-char') : '',
            'filterCategories' => !empty(Session::get('cash-back-stores-filter-cat')) ? [Session::get('cash-back-stores-filter-cat')] : [],
            'c_location' => config('config.location'),
            'c_limit' => 20,
            'c_offset' => Session::get('cash-back-stores-offset')
        ]);

        if (Session::has('user.id')) {
            $query = '?';

            if (!empty($data['data']) && sizeof($data['data']['rows'])) {
                foreach ($data['data']['rows'] as $s) {
                    $query .= 'uuids[]=' . $s['id'] . '&';
                }
            }

            $query .= 'userId=' . Session::get('user.id');
            $data['favourites'] = $this->_submitHTTPGet(config('config.api_url') . 'favourites/getFavourites' .$query,['c_location' => config('config.location')]);
        }

        if (!empty($data) && $data['code'] == 0 && sizeof($data['data']['rows'])) {
            return response(view('elements.v2-parent-box-cash-back-store',$data));
        }
        else return response()->json(['status' => 'error']);
    }

    public function filterStores(Request $request){
        Session::put('cash-back-stores-offset',Session::has('cash-back-stores-offset') ? Session::get('cash-back-stores-offset') + 20 : 20);
        $param = $request->all();
        Session::put('cash-back-stores-filter-' . $param['type'],  $param['value']);
        $data = $this->_submitHTTPPost(config('config.api_url') . 'stores/cashBackStoreShowMore/',[
            'filterName' => '',
            'filterCharacter' => !empty(Session::get('cash-back-stores-filter-char')) ? Session::get('cash-back-stores-filter-char') : '',
            'filterCategories' => !empty(Session::get('cash-back-stores-filter-cat')) ? [Session::get('cash-back-stores-filter-cat')] : [],
            'c_location' => config('config.location'),
            'c_limit' => 20,
            'c_offset' => 0
        ]);

        if (Session::has('user.id')) {
            $query = '?';

            if (!empty($data['data']) && sizeof($data['data']['rows'])) {
                foreach ($data['data']['rows'] as $s) {
                    $query .= 'uuids[]=' . $s['id'] . '&';
                }
            }

            $query .= 'userId=' . Session::get('user.id');
            $data['favourites'] = $this->_submitHTTPGet(config('config.api_url') . 'favourites/getFavourites' .$query,['c_location' => config('config.location')]);
        }

        if (!empty($data) && $data['code'] == 0 && sizeof($data['data']['rows'])) {
            return response(view('elements.v2-parent-box-cash-back-store',$data));
        }
        else return response()->json(['status' => 'error']);
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
