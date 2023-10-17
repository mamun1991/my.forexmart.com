<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . "/third_party/PHPWord.php";

class Word extends PHPWord {
    public function __construct() {
        parent::__construct();
    }
}