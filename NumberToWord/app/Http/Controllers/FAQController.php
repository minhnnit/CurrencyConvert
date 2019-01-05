<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class FAQController extends Controller {

    public function __construct()
    {
        $this->data['title'] = 'Frequently Asked Questions';
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$data['faqGroup'] = $this->_submitHTTPGet(config('config.api_url').'faq_groups/?include[faq_items][order][column]=ordering'
		 . '&include[faq_items][order][dir]=ASC'
		 . '&include[faq_items][where][status]=published'
		 . '&order[column]=ordering&order[dir]=ASC'
		 . '&where[status]=published&where[countrycode]=' . config('config.location'),[]);

		return view('v2-faq')->with( array_merge($data, $this->data) );
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
