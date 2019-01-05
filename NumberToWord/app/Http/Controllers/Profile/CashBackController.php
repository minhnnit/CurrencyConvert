<?php namespace App\Http\Controllers\Profile;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Config;
use Session;
use Input;

class CashBackController extends Controller {
    public function __construct()
    {
        $this->middleware('auth');
        if (!Auth::guest()){
            /*$userInfo = $this->_submitHTTPGet(config('config.api_url') . 'users/', [
                'findType' => 'findOne',
                'where[email]' => Session::get('user.email')
            ]);*/
            $this->dataPage = [
                'active' => [
                    'pro' => '',
                    'sav' => '',
                    'fav' => '',
                    'pre' => '',
                    'com' => '',
                    'cas' => 'active',
                    'ref' => '',
                    'sub' => ''
                ],
                'user' => Auth::user()->getAttributes()
                //'user' => $userInfo
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
        $this->questions =
        [
            [
                'anchor' => 'what-cash-back-answer',
                'id' => 'what-is-cash-back',
                'question' => 'What is cash back?',
                'answer' => 'Updating...'
            ],
            [
                'anchor' => 'how-cash-back-answer',
                'id' => 'how-cash-back',
                'question' => 'How to get cash back?',
                'answer' => 'Updating...'
            ],
            [
                'anchor' => 'how-get-bonus-answer',
                'id' => 'how-get-bonus',
                'question' => 'How to get New Member Bonus?',
                'answer' => 'Updating...'
            ],
            [
                'anchor' => 'which-store-bonus-answer',
                'id' => 'which-store-bonus',
                'question' => 'Which stores have cash back?',
                'answer' => 'Updating...'
            ]
        ];
        $this->dataPage['descriptionTotal'] = [
            '' => 'descTotalRecevied',
            '' => 'descTotalProcessing',
            '' => 'descTotalPending',
            '' => 'descTotalAvailable',
        ];
        $this->dataPage['questions'] = $this->questions;
        /*----------------------------------------------------------------------------------------------------------------*/

        $params = Input::all();

        $start = isset($params['startDate']) ? $params['startDate'] : null;
        $end = isset($params['endDate']) ? $params['endDate'] : null;
        $slStatus = isset($params['status']) ? $params['status'] : -1;

        $this->dataPage['status'] = $slStatus;
        $this->dataPage['start'] = $start;
        $this->dataPage['end'] = $end;

        $page = isset($params['page']) ? $params['page'] : 1;
        $itemOnePage = 10;
        // $itemOnePage = 3;
        $offset = $page == 1 ? 0 : $itemOnePage * ($page - 1);
        $this->dataPage['currentPage'] = $page;

        $filter = [
            'userId' => $this->dataPage['user']['id'],
            'c_limit' => $itemOnePage,
            'c_offset' => $offset
        ];
        if($start)
            $filter['startDate'] = $start;
        if($end)
            $filter['endDate'] = $end;
        if($slStatus != -1)
            $filter['status'] = $slStatus;

        $dataUser = $this->_submitHTTPPost(config('config.api_url') . 'cashBack/balanceAndPayment/', $filter);
        $this->dataPage['cashBackUser'] = $dataUser['data'];

        /*var_dump($this->dataPage['cashBackUser']); die;*/

        $this->dataPage['pageList'] = ceil($this->dataPage['cashBackUser']['paymentHistory']['count'] / $itemOnePage);


        $this->dataPage['currentTotal'] = $itemOnePage * $page;
        if($this->dataPage['cashBackUser']['paymentHistory']['count'] < $this->dataPage['currentTotal']){
            $this->dataPage['currentTotal'] = $this->dataPage['cashBackUser']['paymentHistory']['count'];
        }

        $data = array_merge($this->dataPage, $this->data);
        return view('profile.v2-cash-back')->with($data);
	}

	/**
	 * Show history of personal cash back.
	 *
	 * @return Response
	 */
	public function history(){
        $arrStatus = [
            'All Status' => -1,
            'Processing...' => 'process',
            'Success' => 'success',
            'Cancelled' => 'cancel',
            'Paid' => 'paid'
        ];
        $this->dataPage['arrStatus'] = $arrStatus;

        $params = Input::all();

        $start = isset($params['start']) ? $params['start'] : null;
        $end = isset($params['end']) ? $params['end'] : null;
        $slStatus = isset($params['slStatus']) ? $params['slStatus'] : -1;

        $this->dataPage['slStatus'] = $slStatus;
        $this->dataPage['start'] = $start;
        $this->dataPage['end'] = $end;

        $page = isset($params['page']) ? $params['page'] : 1;
        $itemOnePage = 10;
        // $itemOnePage = 3;
        $offset = $page == 1 ? 0 : $itemOnePage * ($page - 1);
        $this->dataPage['currentPage'] = $page;

        $filter = [
            'userId' => $this->dataPage['user']['id'],
            'c_limit' => $itemOnePage,
            'c_offset' => $offset
        ];
        if($start)
            $filter['startDate'] = $start;
        if($end)
            $filter['endDate'] = $end;
        if($slStatus != -1)
            $filter['status'] = $slStatus;

        $transactionHistory = $this->dataPage['transactionHistory'] = $this->_submitHTTPPost(config('config.api_url')
            . 'cashBack/transactionHistory/', $filter);

        $this->dataPage['transHis'] = $transactionHistory['data'];

        $this->dataPage['currentTotalOrderPaid'] = 0;
        $this->dataPage['currentTotalOrderCashback'] = 0;
        if(count($transactionHistory['data']['orders']['rows'])){
            foreach ($transactionHistory['data']['orders']['rows'] as $key => $value) {
                $this->dataPage['currentTotalOrderPaid'] += $value['saleAmount'];
                $this->dataPage['currentTotalOrderCashback'] += $value['cashBack'];
            }
        }

        $this->dataPage['pageList'] = ceil($this->dataPage['transHis']['orders']['count'] / $itemOnePage);


        $this->dataPage['currentTotal'] = $itemOnePage * $page;
        if($this->dataPage['transHis']['orders']['count'] < $this->dataPage['currentTotal']){
            $this->dataPage['currentTotal'] = $this->dataPage['transHis']['orders']['count'];
        }

        $this->dataPage['transStatus'] = [
            'processing' => 'process',
            'success' => 'success',
            'cancelled' => 'cancel',
            'paid' => 'paid'
        ];
        $this->dataPage['transStatusText'] = [
            'Processing...' => 'process',
            'Success!' => 'success',
            'Cancelled' => 'cancel',
            'Paid' => 'paid'
        ];
        $this->dataPage['descriptionStatus'] = [
            "" => 'process',
            "" => 'success',
            "" => 'cancel',
            "" => 'paid',
            "" => 'descBigScreen',
            "" => 'descSmallScreen'
        ];

        $data = array_merge($this->dataPage, $this->data);
        return view('profile.v2-cash-back-history')->with($data);
    }

    public function changePaypalEmail(Request $request)
    {
        $credentials = $request->only('password', 'email');
        $changePaypalEmailTo = $credentials['email'];
        $email = $this->dataPage['user']['email'];
        $password = $request->get('password');

        $check = $this->_submitHTTPGet(config('config.api_url') . 'auth/', [
            'account' => $email,
            'password' => $credentials['password']
        ]);

        if(isset($check['error'])){
            Session::flash('status', 'error');
            return redirect()->back();
        }else{
            $update = $this->_submitHTTPPost(config('config.api_url') . 'users/update/', [
                'id' => $this->dataPage['user']['id'],
                'emailPaypal' => $changePaypalEmailTo
            ]);
            Auth::user()->fresh();
            Session::flash('status', 'success');
            return redirect()->back();
        }
    }

    public function withdraw(Request $request){
        $credentials = $request->only('password', 'totalCashback', 'email', 'emailPaypal');
        $password = $credentials['password'];
        $totalCashback = $credentials['totalCashback'];
        $emailUser = $credentials['email'];
        $emailPaypal = $credentials['emailPaypal'];

        $check = $this->_submitHTTPGet(config('config.api_url') . 'auth/', [
            'account' => $emailUser,
            'password' => $credentials['password']
        ]);
        if(isset($check['error'])){
            Session::flash('withdrawStatus', 'error');
            return redirect()->back();
        }else{
            $data = [
                'userId' => $this->dataPage['user']['id'],
                'email' => $emailPaypal,
                'paymentMethod' => 'paypal'
            ];
            $requestCashback = $this->_submitHTTPPost(config('config.api_url') . 'cashBack/withDraw/', $data);
            if($requestCashback['msg'] == 'Success'){
                Session::flash('withdrawStatus', 'success');
            }else{
                Session::flash('withdrawStatus', 'error');
            }

            return redirect()->back();
        }
    }
}
