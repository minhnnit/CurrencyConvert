<?php namespace App\Http\Controllers\Profile;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

use Auth;
use Illuminate\Http\Request;
use Storage;
use Validator;

class HomeController extends Controller {

    public function __construct()
    {
//        $this->middleware('auth');
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
					'sub' => ''
                ],
                'user' => Auth::user()->getAttributes()
            ];
            $this->dataPage['seoConfig']['title'] = 'Profile Center - ' . config('config.domain');
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
        return new RedirectResponse(url('/profile/edit'));
        //redirect because this page be come late.
        //return view('profile.home-profile')->with($this->dataPage);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
     * @param Request $request
     * @return mixed
	 */
	public function edit(Request $request)
	{
		// set active tab is Profile tab
		$this->dataPage['active']['pro'] = 'active';
        if ($request->isMethod('post') && Auth::check()) {
            //remove empty values from array
            $data = $request->all();//array_filter($request->all());
            $data['id'] = $this->dataPage['user']['id'];

            $result = $this->_submitHTTPPost(config('config.api_url') . 'users/update/', $data);
            if (!empty($result['type']) && $result['type'] == 'error') {
                return response()->json(['status' => 'error','msg' => $result['message']]);
            }else{
                Auth::user()->fresh();
                return response()->json(['status' => 'success']);
            }
        }
		return view('profile.v2-edit-profile')->with($this->dataPage);
	}

    public function uploadAvatar(Request $request)
    {
        if(!$request->has('file'))
            return response()->json(['error' => 'No File Sent']);

//        if(!$request->file('file')->isValid())
//            return response()->json(['error' => 'File is not valid']);
//
//        $file = $request->file('file');
//        $v = Validator::make(
//            $request->all(),
//            ['file' => 'required|mimes:jpeg,bmp,png,jpg|max:8000']
//        );
//
//        if($v->fails())
//            return response()->json(['error' => $v->errors()]);
        $fileUpload = $request->input('file');
        $pos  = strpos($fileUpload, ';');
        $mime_type = explode(':', substr($fileUpload, 0, $pos))[1];
        //input a row into the database to track the image (if needed)
        $image = [
            'id' => $this->dataPage['user']['id'],
            'ext' => str_replace('image/','',$mime_type)
        ];

        //Use some method to generate your filename here. Here we are just using the ID of the image
        $filename = $image['id'] . '-avatar';
        list($type, $fileUpload) = explode(';', $fileUpload);
        list(, $fileUpload)      = explode(',', $fileUpload);
        $data = base64_decode($fileUpload);
        //Push file to S3
        Storage::disk('s3')->put($filename, $data, 'public');
        $bucket = config('filesystems.disks.s3.bucket');
        $s3 = Storage::disk('s3');
        $avatarUrl = $s3->getDriver()->getAdapter()->getClient()->getObjectUrl($bucket, $filename);
        $result = $this->_submitHTTPPost(config('config.api_url') . 'users/update/', [
            'id' => $this->dataPage['user']['id'],
            'avatar' => $avatarUrl
        ]);
        //Use this line to move the file to local storage & make any thumbnails you might want
        //$request->file('file')->move('/full/path/to/uploads', $filename);

        //Thumbnail as needed here. Then use method shown above to push thumbnails to S3

        //If making thumbnails uncomment these to remove the local copy.
        //if(Storage::disk('s3')->exists('uploads/' . $filename))
        //Storage::disk()->delete('uploads/' . $filename);

        //If we are still here we are good to go.
        return response()->json(['status' => 'success', 'avatarUrl' => $avatarUrl]);
    }

	public function reference(){
		$this->dataPage['active']['ref'] = 'active';
		$userId = $this->dataPage['user']['id'];
		$referUrl = url('/?ref=' . $userId);
		$this->dataPage['referUrl'] = $referUrl;
		return view('profile.v2-reference-friend')->with($this->dataPage);
	}

}
