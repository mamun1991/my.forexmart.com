<?php 
require_once 'geoip2/vendor/autoload.php';

use GeoIp2\Database\Reader;

class FXIP{
    public static function getCountryCode($IP){              
        $reader = new Reader("geoip2/GeoLite2-City.mmdb");
        
        $record = $reader->city($IP);
       
        return $record->country->isoCode;
    }
}