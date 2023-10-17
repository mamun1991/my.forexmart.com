<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LanguageSwitcher  extends CI_Controller{
    public function __construct() {
        parent::__construct();
    }

    function switchLang($language = "") {


        $language = ($language != "") ? $language : "english";
        $this->session->set_userdata('site_lang', $language);
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
                break;
            case 'malay':
                $uri='/my';
                break;
            case 'polish':
                $uri='/pl';
                break;
             case 'urdu':
                $uri='/pk';
                break;
            case 'greek':
                $uri='/gr';
                break;
            case 'czech':
                $uri = '/cs';
                break;
            case 'chinese':
                $uri = '/zh';
                break;
            case 'bangladesh':
                $uri = '/bd';
                break;
            case 'vietnam':
                $uri = '/vn';
                break;

        }

        if ( $parts = parse_url($_SERVER['HTTP_REFERER'] ) ) {
            if ($parts[ "path" ]!=''){
                $uri_segement = explode("/",$parts[ "path" ]);
                $urilist = array("en", "ru", "jp", "id","de","fr","it","sa","es","pt","bg","my","pl","pk","gr","cs","zh","bd","vn");
                if (in_array($uri_segement[1], $urilist)) {
                    $isURI=true;
                }
                $path='';
                foreach($uri_segement as $key => $value){
                    echo $key.' = '.$value;
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
        }
        
            
            
        if($_SERVER['SERVER_NAME']=="localhost"){            
            $redi_url="http://localhost/my.forexmart.com".$uri.$path;
            redirect($redi_url);
            
        }else{
        redirect($parts[ "scheme" ] . "://" . $parts[ "host" ].$uri.$path);    
        }
        
        
    }

}
