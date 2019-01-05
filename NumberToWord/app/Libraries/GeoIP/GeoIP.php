<?php
namespace App\Libraries;

use HttpException;

class GeoIP {

    /**
     * This function performs a remote request to an IP lookup service. We found out, the service with https protocol
     * is frequently overloaded, unlike the one using http protocol. That's why there is a fallback solution, which
     * sends a request to an unsafe server if the safe one fails.
     */
    public static function lookup($ip, $fallback = false)
    {
        try {
            $r = file_get_contents('https://freegeoip.net/json/' . $ip);
            return json_decode($r, true);
        } catch(HttpException $e) {
            if ($fallback) {
                return ['status' => 'error'];
            }
            else {
                return self::lookup($ip, true);
            }
        }
    }
}