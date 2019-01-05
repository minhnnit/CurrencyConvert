<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite as Socialite;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Session;
use URL;

class AuthController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers;

    public $redirectAfterLogout = '/';
    public $loginPath = '/login';
    public $redirectPath = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard $auth
     * @param  \Illuminate\Contracts\Auth\Registrar $registrar
     */
    public function __construct(Guard $auth, Registrar $registrar)
    {
        $this->auth = $auth;
        $this->registrar = $registrar;
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        $data['seoConfig']['title'] = 'Sign in to ' . config('config.Projectname') . ' | ' . config('config.domain');
        return view('auth.login', $data);
    }
    public function getRegister()
    {

        $data = $this->_submitHTTPGet(config('config.api_url') . 'users/getDataRegisterV2/', [
        ]);
        $data['seoConfig']['title'] = 'Register a new ' . config('config.Projectname') . ' account';
        return view('auth.register', $data);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        $check = $this->_submitHTTPGet(config('config.api_url') . 'auth/', [
            'account' => $credentials['email'],
            'password' => $credentials['password']
        ]);
        if (empty($check['error'])) {
            $data = $request->all();
            if(!empty($data['act']) && $data['act'] == 'getCode')
                Session::put('loginAfterGetCode', true);
            Session::put('user.email', $check['email']);
            $this->auth->loginUsingId($check['id'], $request->has('remember'));
            if(strpos($this->redirectPath(),'/user/reset-password/') !== false){
                return new RedirectResponse(url('/'));
            }else{
                return back();
            }
        }

        return redirect($this->loginPath())
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => $check['message']//$this->getFailedLoginMessage(),
            ]);
    }

    public function getLogout(Request $request)
    {
        $request->session()->flush();
        $this->auth->logout();
        $this->redirectAfterLogout = URL::previous();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    /**
     * Create a new authentication controller instance.
     *
     * @param array $data
     * @return mixed
     */
    private function registerWithSocial($data)
    {
        $check = $this->_submitHTTPGet(config('config.api_url').'users/',[
            'where[email]' => $data['email'],
            'findType'=>'findOne'
        ]);
        if (!empty($check['id'])) {
            $this->auth->loginUsingId($check['id'], true);
            return;
        }
        $data['isSocial'] = 1;
        $data['status'] = 'active';
        $data['domain'] = $this->getDomain();
        $data['password'] = '';//config('config.password_default');
        $data['password_confirmation'] = config('config.password_default');
        $data['go'] = $this->_getToken(6);
        $data['emailBody'] = view('email-template.welcome',[
            'button' => [
                'link' => url('/login'),
                'text' => 'Login'
            ]
        ])->render();
        $result = $this->_submitHTTPPost(config('config.api_url') . 'users/register', $data);
        if ($result['type'] == 'success' && !empty($result['id'])) {
            $this->auth->loginUsingId($result['id'], true);
        }
    }

    // To redirect facebook
    public function facebook_redirect(Request $request)
    {
        $data = $request->all();
        if(!empty($data['act']) && $data['act'] == 'getCode')
            Session::put('loginAfterGetCode', true);
        return Socialite::with('facebook')->redirect();
    }

    // to get authenticate user data
    public function facebook()
    {
        $user = (array)Socialite::with('facebook')->user();
        // Do your stuff with user data.
        $data['name'] = $user['name'];
        $data['email'] = $user['email'];
        $data['facebookId'] = $user['id'];
        $this->registerWithSocial($data);
        Session::put('redirectPath', URL::previous());
        if (strpos(back()->getTargetUrl(), strtolower(config('config.domain'))) === false)
            return redirect(Session::get('redirectPath'));
        else return back();
    }

    // To redirect google
    public function google_redirect(Request $request)
    {
        $data = $request->all();
        if(!empty($data['act']) && $data['act'] == 'getCode')
            Session::put('loginAfterGetCode', true);
        return Socialite::with('google')->redirect();
    }

    // to get authenticate user data
    public function google()
    {
        $user = (array)Socialite::with('google')->user();
        // Do your stuff with user data.
        $data['name'] = $user['name'];
        $data['email'] = $user['email'];
        $this->registerWithSocial($data);
        Session::put('redirectPath', URL::previous());
        if (strpos(back()->getTargetUrl(), strtolower(config('config.domain'))) === false)
            return redirect(Session::get('redirectPath'));
        else return back();
    }

    // To redirect twitter
    public function twitter_redirect(Request $request)
    {
        $data = $request->all();
        if(!empty($data['act']) && $data['act'] == 'getCode')
            Session::put('loginAfterGetCode', true);
        return Socialite::with('twitter')->redirect();
    }

    // to get authenticate user data
    public function twitter()
    {
        $user = (array)Socialite::with('twitter')->user();
        // Do your stuff with user data.
        $check = $this->_submitHTTPGet(config('config.api_url').'users/',[
            'where[username]' => strtolower($user['nickname']),
            'findType'=>'findOne'
        ]);
        Session::put('redirectPath', URL::previous());
        if ((!empty($check['id']) && empty($check['email'])) || empty($check['id'])) {
            $data['user']['name'] = $user['name'];
            $data['user']['username'] = $user['nickname'];
            return view('auth.loginTwitter')->with($data);
        }
        $data['name'] = $check['fullname'];
        $data['email'] = $check['email'];
        $this->registerWithSocial($data);
        if (strpos(back()->getTargetUrl(), strtolower(config('config.domain'))) === false)
            return redirect(Session::get('redirectPath'));
        else return back();
    }

    public function twitterConfirmEmail(Request $request){
        $data = $request->all();
        $this->registerWithSocial($data);
        if (strpos(back()->getTargetUrl(), strtolower(config('config.domain'))) === false)
            $redirectPath = Session::get('redirectPath');
        else $redirectPath = back()->getTargetUrl();
        response()->json(['status' => 'success','redirectUrl'=>$redirectPath]);
    }

    // To redirect github
    public function github_redirect()
    {
        return Socialite::with('github')->redirect();
    }

    // to get authenticate user data
    public function github()
    {
        $user = (array)Socialite::with('github')->user();
        // Do your stuff with user data.
        $data['name'] = $user['name'];
        $data['email'] = $user['email'];
        $this->registerWithSocial($data);
        Session::put('redirectPath', URL::previous());
        if (strpos(back()->getTargetUrl(), strtolower(config('config.domain'))) === false)
            return redirect(Session::get('redirectPath'));
        else return back();
    }
}
