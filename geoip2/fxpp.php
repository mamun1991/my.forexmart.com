<?php
    require_once 'vendor/autoload.php';
    use GeoIp2\Database\Reader;
    
    $data = array(
        'isoCode'=>'ZZ',
        'name'=>'',
        'city_name'=>'',
        'postal_code'=>'',
        'latitude'=>'',
        'longitude'=>''
    );

if(isset($_GET['ip']) && filter_var($_GET['ip'], FILTER_VALIDATE_IP)){

        $reader = new Reader('GeoLite2-City.mmdb');
        $record = $reader->city($_GET['ip']);
        $data = array(
            'isoCode'=>$record->country->isoCode,
            'name'=>$record->country->name,
            'city_name'=>$record->city->name,
            'postal_code'=>$record->postal->code,
            'latitude'=>$record->location->latitude,
            'longitude'=>$record->location->longitude
        );

       
}

header('Content-Type: application/json');
echo json_encode($data);