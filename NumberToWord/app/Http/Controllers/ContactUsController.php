<?php namespace App\Http\Controllers;

use Illuminate\Http\Request as Re;

class ContactUsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['reCapcha_public_key'] = config('config.reCapcha_public_key');
        return view('contactUs')->with($data);
    }

    public function sendContact(Re $request){
        if (isset($_POST["g-recaptcha-response"])) {
            $data = $request->all();
            $data['domain'] = $this->getDomain();
            $data['c_location'] = config('config.location');
            $data['keywords'] = 'keyword';
            $result = $this->_submitHTTPPost(config('config.api_url') . 'contacts/new/', $data);
            if (!empty($result) && $result) {
                return response()->json(['status' => 'success']);
            } else  return response()->json(['status' => 'error']);
        }else {
            return response()->json(['status' => 'error', 'msg' => 'Please enter Captcha code!']);
        }
    }

}
