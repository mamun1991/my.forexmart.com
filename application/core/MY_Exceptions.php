<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Extending the default errors to always give JSON errors
 *
 * @author Oliver Smith
 */

class MY_Exceptions extends CI_Exceptions
{
    function __construct()
    {
        parent::__construct();
    }

    private function isOfficeIP(){
        $officeIp = array(
            '5.9.65.183',
            '78.46.195.217',
            '115.127.83.18',
            '78.46.79.174',       
            '182.163.102.47',
            '109.237.2.242 ',
            '81.4.164.118',
            '46.146.225.205',
            '88.198.94.228',       
             '83.219.143.110', 
             '81.4.164.118',  
             '159.69.88.248',
            '210.213.232.30', 
            '78.46.190.237', 
            '78.46.185.187',
            '152.32.105.198',
            '152.32.104.142',
            '130.105.209.200',
            '152.32.100.196',
            '49.12.5.139',
            '159.69.88.248' 
        );
        return in_array($_SERVER['REMOTE_ADDR'],$officeIp)?true:false;
    }

    /**
     * 404 Page Not Found Handler
     *
     * @param   string  the page
     * @param   bool    log error yes/no
     * @return  string
     */
    function show_404($page = '', $log_error = TRUE)
    {
        // By default we log this, but allow a dev to skip it
//        if ($log_error)
//        {
//            log_message('error', '404 Page Not Found --> '.$page);
//        }
//
//        header('Cache-Control: no-cache, must-revalidate');
//        header('Content-type: application/json');
//        header('HTTP/1.1 404 Not Found');
//
//        echo json_encode(
//            array(
//                'status' => FALSE,
//                'error' => 'Unknown method',
//            )
//        );


        if($page == "accessing"){
            require APPPATH . 'views/errors/html/error_accessing.php';
            exit;
        }else if($page == "maintenance"){
            require APPPATH . 'views/errors/html/error_maintenance.php';
            exit;
        }else if($page == "maintenance_smart_dollar"){
                require APPPATH . 'views/errors/html/error_maintenance_smart_dollar.php';
                exit;
        }else{
            require APPPATH . 'views/errors/html/error_404.php';
            exit;
        }


    }

    /**
     * General Error Page
     *
     * This function takes an error message as input
     * (either as a string or an array) and displays
     * it using the specified template.
     *
     * @access  private
     * @param   string  the heading
     * @param   string  the message
     * @param   string  the template name
     * @param   int     the status code
     * @return  string
     */
    function show_error($heading, $message, $template = 'error_general', $status_code = 500)
    {


        $date = date('Y-m-d').".log";
        $log = '<p>show error</P><p>'.(is_array($message) ? implode('</p><p>', $message) : $message).'</p> date: '.date('Y-m-d h:i:s')." IP: ".$_SERVER['REMOTE_ADDR']." URI: ".$_SERVER["REQUEST_URI"];
        file_put_contents('/var/www/html/my.forexmart.com/application/logs/'.$date, $log . PHP_EOL, FILE_APPEND);

        if($this->isOfficeIP){

        
        log_message('error', 'Error500[' . $_SERVER['REMOTE_ADDR'] . ']: ' . '<p>'.(is_array($message) ? implode('</p><p>', $message) : $message).'</p>');
        require APPPATH . 'views/errors/html/error_php_custom.php';

        echo "<script>console.log('error message: " , '<p>'.(is_array($message) ? implode('</p><p>', $message) : $message).'</p>' , "');</script>";
        exit();

        }
    }

    /**
     * Native PHP error handler
     *
     * @access  private
     * @param   string  the error severity
     * @param   string  the error string
     * @param   string  the error filepath
     * @param   string  the error line number
     * @return  string
     */
    function show_php_error($severity, $message, $filepath, $line)
    {

    

        $date = date('Y-m-d').".log";

        $log = "severity: ".$severity. " message:".$message." filepath: ".$filepath." line number:".$line." IP: ".$_SERVER['REMOTE_ADDR'].'date: '.date('Y-m-d h:i:s')." URI: ".$_SERVER["REQUEST_URI"];
        file_put_contents('/var/www/html/my.forexmart.com/application/logs/'.$date, $log . PHP_EOL, FILE_APPEND);


        if($this->isOfficeIP()){

        
        if(!in_array($severity, array(E_NOTICE, E_WARNING, E_PARSE))) {
            log_message('error', 'Error500[' . $_SERVER['REMOTE_ADDR'] . '] Severity: ' . $severity . ' --> ' . $message . ' ' . $filepath . ' ' . $line);
            require APPPATH . 'views/errors/html/error_php_custom.php';

            echo "<script>console.log('severity: " , $severity , "');</script>";
            echo "<script>console.log('message: " , $message , "');</script>";
            echo "<script>console.log('filepath: " , $filepath , "');</script>";
            echo "<script>console.log('line number: " , $line , "');</script>";
            exit();
        }
    }
    }

    function show_session_expired(){

        require APPPATH . 'views/errors/html/error_session_expired.php';
        exit;

    }
}

?>