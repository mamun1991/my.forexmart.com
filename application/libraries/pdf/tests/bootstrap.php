<?php
define("DOC_DIR", str_replace(DIRECTORY_SEPARATOR, '/', realpath(dirname(__FILE__))));
require_once DOC_DIR.'/pdf/vendor/autoload.php';


//Define constants
define( "PACKAGE_DIRECTORY", dirname( __DIR__ ) );

//Load composer packages
require PACKAGE_DIRECTORY . DIRECTORY_SEPARATOR . "vendor/autoload.php";


