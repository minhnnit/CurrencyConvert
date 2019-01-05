<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Session;
use Torann\GeoIP\GeoIP;

use Illuminate\Config\Repository;
use Illuminate\Session\Store as SessionStore;
use URL;

abstract class Controller extends BaseController
{

    use DispatchesCommands, ValidatesRequests;

    public function __construct(Repository $config, SessionStore $session, Request $request)
    {

        if (!Session::has('user.id') && Auth::check()) {
            Session::put('user.id', Auth::user()->getAttribute('id'));
            Session::put('user.email', Auth::user()->getAttribute('email'));
            Session::put('user.go', Auth::user()->getAttribute('go'));
            $data['userId'] = Session::get('user.id');
        }
        if (strpos(URL::current(), "login") === false) {
            Session::put('redirectPath', URL::current());
        }
        else {
            Session::put('redirectPath', URL::previous());
        }
        if (!Session::has('geoip-location')) {
            $location = geoip()->getLocation();
            Session::put('geoip-location', $location);
        }
        $used_coupon = $request->input('c');
        if (!empty($used_coupon)) {
            $data['ip'] = Session::get('geoip-location')['ip'];
            $data['date'] = date('Y-m-d');
            $data['country_code'] = Session::get('geoip-location')['isoCode'];
            $data['cityCode'] = Session::get('geoip-location')['city'];
            $data['c_location'] = config('config.location');
            $data['fromUrl'] = URL::current();
            if (Auth::check()) $data['userId'] = Session::get('user.id');
            $data['couponId'] = $used_coupon;
            $this->_submitHTTPPost(config('config.api_url') . 'log_used_codes/click-get-code/coupon/', $data);
        }
        $used_deal = $request->input('d');
        if (!empty($used_deal)) {
            $data['ip'] = Session::get('geoip-location')['ip'];
            $data['date'] = date('Y-m-d');
            $data['country_code'] = Session::get('geoip-location')['isoCode'];
            $data['cityCode'] = Session::get('geoip-location')['city'];
            $data['c_location'] = config('config.location');
            $data['fromUrl'] = URL::current();
            if (Auth::check()) $data['userId'] = Session::get('user.id');
            $data['dealId'] = $used_deal;
            $this->_submitHTTPPost(config('config.api_url') . 'log_used_codes/click-get-code/deal/', $data);
        }
        $this->getDomainFolder();
    }

    public function getDomainFolder() {
        if(isset($GLOBALS['asset_folder'])===false) {
            $host_explode = explode('.', strpos($_SERVER['HTTP_HOST'], '.') === false ? env('SITE_NAME') : $_SERVER['HTTP_HOST']);
            $c_host = count($host_explode);
            $GLOBALS['domain_lower'] = $domain_lower = $host_explode[$c_host - 2] . '.' . $host_explode[$c_host - 1];
            $GLOBALS['domain_upper'] = strtoupper($domain_lower);
            $GLOBALS['asset_domain'] = $asset_folder = strtolower($host_explode[$c_host - 2]);
        }
		return $asset_folder;
    }
    public function getDomain()
    {
        if (isset($_SERVER['HTTPS'])) {
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        } else {
            $protocol = 'http';
        }
        return $protocol . "://" . $_SERVER['HTTP_HOST'];
    }

    function _encodeQS($data)
    {
        $req = "";

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $v) $req .= $key . '[]=' . urlencode(stripslashes($v)) . '&';
            }else
            $req .= $key . '=' . urlencode(stripslashes($value)) . '&';
        }
        // Cut the last '&'
        $req = rtrim($req, '&');
        return $req;
    }

    function _submitHTTPGet($path, $data, $saveFile = false)
    {
        if ($saveFile) {
            $file = 'log_send_data.txt';
            if(!is_dir(dirname($file)))
                mkdir(dirname($file).'/', 777, TRUE);
            file_put_contents($file, '');

            // Open the file to get existing content
            $current = file_get_contents($file);
            // Append a new person to the file
            $current .= json_encode($data);
            // Write the contents back to the file
            file_put_contents($file, $current);
        }
        $data['_token'] = 'd20PF0C7WH0TXpp5p277352lR0RD3jpT';
        $req = $this->_encodeQS($data);
        if (!empty($req) && (strpos($path,'?') === false)) $req = '?' . $req;
        else if (!empty($req)) $req = '&' . $req;
        $response = json_decode(file_get_contents($path . $req), true);
        return $response;
    }

    function _submitHTTPPost($path, $data, $saveFile = false)
    {
        if ($saveFile) {
            $file = 'log_send_data.txt';
            if(!is_dir(dirname($file)))
                mkdir(dirname($file).'/', 777, TRUE);
            file_put_contents($file, '');

            // Open the file to get existing content
            $current = file_get_contents($file);
            // Append a new person to the file
            $current .= json_encode($data);
            // Write the contents back to the file
            file_put_contents($file, $current);
        }
        $data['_token'] = 'd20PF0C7WH0TXpp5p277352lR0RD3jpT';
        $req = $this->_encodeQS($data);
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //execute post
        $result = curl_exec($ch);

        //Do something
        //var_dump($result)

        //close connection
        curl_close($ch);
        return json_decode($result,true);
    }

    public function replaceKeyword($str, $key, $replaceValue) {
        if (strpos($str, $key) >= 0) {
            $str = str_replace($key, $replaceValue, $str);
        }
        return $str;
    }

    public function seoConvert($str, $siteName, $siteDesc, $title = '', $cpTitle = '', $cpDiscount = '', $cashBack = '', $isTitle = false) {
        $str = $this->replaceKeyword($str, '%%sitename%%', $siteName);
        $str = $this->replaceKeyword($str, '%%currentmonth%%', date('F'));
        $str = $this->replaceKeyword($str, '%%currentyear%%', date('Y'));
        $str = $this->replaceKeyword($str, '%%sitedesc%%', $siteDesc);
        $str = $this->replaceKeyword($str, '%%sep%%', '-');
        $str = $this->replaceKeyword($str, '%%title%%', $title);
        $str = $this->replaceKeyword($str, '%%StickyCouponTitle%%', $cpTitle);
        $str = $this->replaceKeyword($str, '%%StickyCouponDiscountValue%%', $cpDiscount);

        if(!$isTitle){
            $str = $this->replaceKeyword($str, '%%CashBack%%',  $cashBack ? ' - Earn up to ' . $cashBack . ' Cash Back ' : '');
        }else{
            $str = $this->replaceKeyword($str, '%%CashBack%%', $cashBack ? ' - Up to ' . $cashBack . ' Cash Back ' : '');
        }
        return $str;
    }

    public function _redirect($alias, $controller = '', $params = []){
        if($alias !== strtolower($alias)){
            $alias = strtolower($alias);
            if(!empty($controller)){
                $alias = $controller . $alias;
            }
            if(count($params) > 0){
                $alias = $alias . '?' . $this->_encodeQS($params);
            }
        }
        return $alias;
    }

    protected function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 0) return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public function _getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[$this->crypto_rand_secure(0,strlen($codeAlphabet))];
        }
        return $token;
    }
}
