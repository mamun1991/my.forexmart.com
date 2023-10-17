<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotes extends CI_Controller {

    public function getForexQuotes()
    {
        if(function_exists('file_get_contents')){
            $forexquotes = file_get_contents("http://quotes.instaforex.com/get_quotes.php?m=json");
            echo $forexquotes;
        }
    }
}
