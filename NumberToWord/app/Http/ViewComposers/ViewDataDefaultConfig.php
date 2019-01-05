<?php namespace App\Http\ViewComposers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Session;
use Illuminate\Support\Facades\Redis;
use Auth;

class ViewDataDefaultConfig extends Controller
{

    /**
     * The data repository implementation.
     *
     * @var DataRepository
     */
    protected $dataCommon;
    protected $dataSeo;


    function __construct()
    {
        $this->dataCommon = array(
            'logo' => asset('images/logo.png'),
            'logoTitle' => config('config.Project_Name').' without controller defined',
            'version_app' => ''//'?ver=0001'
        );

        $this->dataSeo = array(
            'title' =>  config('config.Project_Name').' without controller defined',
            'keywords' =>  config('config.Project_Name').' without controller defined',
            'description' =>  config('config.Project_Name').' without controller defined',
            'image' => ''
        );
    }

    protected function getDefaultStore(){
        return $store = array(
            'id' => 0,
            'name' => '',
            'social_image' => '',
            'description' => ''
        );
    }

    protected function getFavoritesOfUser()
    {
//        $data = array(
//            'favoritesCoupon' => 0,
//            'favoritesStore' => 0
//        );
//        if(Session::has('user.id')){
//            $data['favoritesCoupon'] = $this->_submitHTTPGet(config('config.api_url') . 'favourites/', [
//                'findType' => 'count',
//                'where[key]' => 'coupon',
//                'where[userId]' => Session::get('user.id')
//            ]);
//            $data['favoritesStore'] = $this->_submitHTTPGet(config('config.api_url') . 'favourites/', [
//                'findType' => 'count',
//                'where[key]' => 'store',
//                'where[userId]' => Session::get('user.id')
//            ]);
//        }
//        return $data;
        $data = [
            'favoritesCoupon' => [],
            'favoritesStore' => []
        ];

        if(Auth::check()){
            $userInfo = Auth::user()->getAttributes();
            $userId = $userInfo['id'];

            $userFaved = $this->_submitHTTPGet(config('config.api_url') . 'users/favouriteStores/' . $userId, [
                'c_location' => config('config.location')
            ]);

            if(count($userFaved) > 0){
                $arrFaved = [];
                foreach ($userFaved as $uf) {
                    array_push($arrFaved, $uf['id']);
                }
                $data['favoritesStore'] = $arrFaved;
            }

            $userSaved = $this->_submitHTTPGet(config('config.api_url') . 'coupons/getSaveCoupons/' . $userId, [
                'c_location' => config('config.location')
            ]);
            if(count($userSaved) > 0){
                $arrSaved = [];
                foreach ($userSaved as $uf) {
                    array_push($arrSaved, $uf['id']);
                }
                $data['favoritesCoupon'] = $arrSaved;
            }
        }
        return $data;
    }

    /**
     * Bind default data to the View.
     *
     * @param  View $view
     * @return void
     * @author CuongPH MCCorp
     */
    public function compose(View $view)
    {
        if (!$view->offsetExists('common')) {
            $view->with('common', $this->dataCommon);
        }
        if (!$view->offsetExists('seo')) {
            $view->with('seo', $this->dataSeo);
        }
        if (!$view->offsetExists('store')) {
            $view->with('store', $this->getDefaultStore());
        }
        if (!$view->offsetExists('favorite')) {
            $view->with('favorite', $this->getFavoritesOfUser());
        }
        if (!$view->offsetExists('reCapcha_public_key')) {
            $view->with('reCapcha_public_key', config('config.reCapcha_public_key'));
        }
//        $redis = Redis::connection();
//        if (!$redis->exists('events')) {
//            $data['events'] = $this->_submitHTTPGet(config('config.api_url') . 'events/',[
//                'where[status]'=>'published',
//                'attributes[]=id&attributes[]' => 'name']);
//            $redis->set('events',$data['events']);
//        }
        /*$data['events'] = $this->_submitHTTPGet(config('config.api_url') . 'events/', [
            'where[status]' => 'published',
            'attributes[]=id&attributes[]' => 'name']);
        $view->with('events', $data['events']);*/
    }

}

?>