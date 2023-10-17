<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hosting extends CI_Controller {
    public function analytics(){
        header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60*2)));
        $str= file_get_contents('https://www.google-analytics.com/analytics.js',FILE_USE_INCLUDE_PATH);
        $str = ltrim($str, '﻿');
        echo $str;
    }
    public function watch(){
        header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60)));
        $str = '';
        $str = ltrim($str, '﻿');
        echo $str;
    }
    public function purechat(){
        header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60)));
        $str= file_get_contents('https://cdnva2.purechat.com/app/VisitorWidget/Widget/4de4c451-78d0-49e7-806d-138590c89b55/46/_WidgetJPCB1.js');
        echo $str;
    }
}
