<?php namespace App\Http\Controllers\Profile;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Http\Request;

class CommunityController extends Controller {

	private  $dataPage = array();

    public function __construct(){

        $this->middleware('auth');
        if (!Auth::guest()){
            $this->dataPage = array(
                'active' => array(
                    'pro' => '',
                    'sav' => '',
                    'fav' => '',
                    'pre' => '',
                    'com' => 'active',
					'cas' => '',
					'ref' => '',
					'sub' => ''
                ),
                'user' => Auth::user()->getAttributes(),
                'subactive' => array(
                    'dashboard' => '',
                    'submited' => '',
                    'help' => ''
                )
            );
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
        return $this->show('dashboard', $this->data);
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
        $idAcepted = array('dashboard', 'submited');
        if(in_array($id, $idAcepted)){
            $this->dataPage['subactive'][$id] = 'active';
        }else{
            abort(404);
        }

        $this->dataPage['submodule'] = $id;

        return view('profile.community')->with( array_merge($this->dataPage, $this->data));
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
