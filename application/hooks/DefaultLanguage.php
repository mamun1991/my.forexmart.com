<?php
class DefaultLanguage
{
    function initialize() {

        require_once APPPATH.'/helpers/geoiploc.php';
        $CI =& get_instance();
        $ip=$CI->input->ip_address();

        $siteLang=$CI->session->userdata('site_lang') ;


         if(!$siteLang){

            if($CI->input->valid_ip($ip)){
                $country = getCountryFromIP($ip);
            }



//        if($ip == '78.46.187.12'){

            if( $_SERVER['HTTP_REFERER'] == '' ){
                if( in_array(strtoupper($country), array('DE', 'BE', 'AT', 'LU', 'LI')) ){
                    $language = 'german';
                }elseif( in_array(strtoupper($country), array('CD', 'FR', 'CA', 'MG', 'CM', 'BF', 'NE', 'SN', 'ML', 'RW', 'HT', 'TD', 'GN', 'BI', 'BJ', 'TG', 'CF', 'CG', 'GA', 'KM', 'GQ', 'DJ', 'VU', 'SC', 'MC')) ){
                    $language = 'french';
                }elseif( in_array(strtoupper($country), array('ID')) ){
                    $language = 'indonesian';
                }elseif( in_array(strtoupper($country), array('IT', 'VA', 'SM')) ){
                    $language = 'italian';
                }elseif( in_array(strtoupper($country), array('JP')) ){
                    $language = 'japanese';
                }elseif( in_array(strtoupper($country), array('PT', 'AO', 'CV', 'GW', 'MZ', 'ST')) ){
                    $language = 'portuguese';
                }elseif( in_array(strtoupper($country), array('RU', 'AM', 'AZ', 'BY', 'KZ', 'KG', 'MD', 'TJ', 'TM', 'UA', 'UZ')) ){
                    $language = 'russuan';
                }elseif( in_array(strtoupper($country), array('ES', 'CR', 'DO', 'SV', 'GT', 'HN', 'NI', 'PA', 'AR', 'CL', 'CO', 'EC', 'PE', 'UY', 'VE')) ){
                    $language = 'spanish';
                }elseif( in_array(strtoupper($country), array('BG')) ){
                    $language = 'bulgarian';
                }elseif( in_array(strtoupper($country), array('MY', 'BN')) ){
                    $language = 'malay';
                }elseif( in_array(strtoupper($country), array()) ){
                    $language = 'urdu';
                }elseif( in_array(strtoupper($country), array('PL')) ){
                    $language = 'polish';
                }elseif( in_array(strtoupper($country), array('SK')) ){
                    $language = 'slovak';
                }elseif( in_array(strtoupper($country), array('CN','HK')) ){
                    $language = 'chinese';
                }elseif(in_array(strtoupper($country), array('BD'))){
                    $language = 'bangladesh';
                }elseif(in_array(strtoupper($country), array('CS'))){
                    $language = 'czech';
                }elseif(in_array(strtoupper($country), array('VN'))){
                    $language = 'vietnam ';
                }
                else{
                    $language = 'english';
                }

                $CI->session->set_userdata('site_lang', $language);
                switch($language){
                    case 'english':
                        $uri='';
                        break;
                    case 'arabic':
                        $uri='/sa';
                        break;
                    case 'french':
                        $uri='/fr';
                        break;
                    case 'german':
                        $uri='/de';
                        break;
                    case 'indonesian':
                        $uri='/id';
                        break;
                    case 'italian':
                        $uri='/it';
                        break;
                    case 'japanese':
                        $uri='/jp';
                        break;
                    case 'portuguese':
                        $uri='/pt';
                        break;
                    case 'russuan':
                        $uri='/ru';
                        break;
                    case 'spanish':
                        $uri='/es';
                        break;
                    case 'bulgarian':
                        $uri='/bg';
                    case 'czech':
                        $uri='/cs';
                        break;
                    case 'malay':
                        $uri='/my';
                        break;
                    case 'urdu':
                        $uri='/pk';
                        break;
                    case 'polish':
                        $uri='/pl';
                        break;
                    case 'slovak':
                        $uri='/sk';
                        break;
                    case 'chinese':
                        $uri='/zh';
                        break;
                    case 'bangladesh':
                         $uri='/bd';
                         break;

                    case 'vietnam':
                        $uri='/vn';
                        break;
                }
                if ( $parts = parse_url($_SERVER['REQUEST_URI'] ) ) {
                    if ($parts[ "path" ]!=''){
                        $uri_segement = explode("/",$parts[ "path" ]);
                        $urilist = array("en", "ru", "jp", "id","de","fr","it","sa","es","pt","bg","my","pk","pl","sk","zh","bd","vn");
                        if (in_array($uri_segement[1], $urilist)) {
                            $isURI=true;
                        }
                        $path='';
                        foreach($uri_segement as $key => $value){
//                            echo $key.' = '.$value;
                            if ($key>0){
                                if ($isURI){
                                    if ($key>1){
                                        $path .='/'.$value;
                                    }
                                }else{
                                    $path.='/'.$value;
                                }
                            }
                        }
                    }
                    if(array_key_exists('query', $parts)){
                        if($parts['query'] != ''){
                            $path .= '?' . $parts['query'];
                        }
                    }
                }

                $pageURLScheme = 'http';
                if ($_SERVER["HTTPS"] == "on") {$pageURLScheme .= "s";}
                $pageURLScheme .= "://";
                $pageURL = $pageURLScheme . $_SERVER["SERVER_NAME"].$uri.$path;
                $pageRefURL = $pageURLScheme . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
//                echo $country;
//                        if($ip == '78.46.187.12'){
//                            var_dump(parse_url($_SERVER['REQUEST_URI']));
//                        }
                if($pageRefURL <> $pageURL){
                    redirect($pageURL);
                }
            }
//        }





        } // site lang






    }
}