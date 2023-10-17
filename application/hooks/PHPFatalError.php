<?php

class PHPFatalError {
    public function setHandler()
    {
        ini_set('display_error', 0);
        set_error_handler('myErrorHandler');
        set_exception_handler('myExceptionHandler');
        register_shutdown_function('handleShutdown');
    }
}

function handleShutdown()
{
    //shutdown
}

function myErrorHandler($errno, $errstr, $errfile, $errline, $vars)
{
//    $CI = & get_instance();
//    $errmsg[] = "PHP error: [$errno] $errstr";
//    $errmsg[] = "Error on line $errline in $errfile";
//    $CI->session->set_flashdata('error', $errmsg);
    //show_404();
}

function myExceptionHandler($exception) {
    
    echo "<script>console.log('Uncaught exception: " , $exception->getMessage(), "');</script>";
}