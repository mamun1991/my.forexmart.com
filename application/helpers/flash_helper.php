<?php
function flash_message( $id, $message, $flag = false ){
    $CI = & get_instance();
    if( $flag == 1 ){
        $message = '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok-sign" style="color: #3c763d" aria-hidden="true"></span> ' . $message . '</div>';
    }else{
        $message = '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ' . $message . '</div>';
    }

    $CI->session->set_flashdata($id, $message);
}
?>