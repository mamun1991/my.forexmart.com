<?php

class MY_Loader extends CI_Loader {

    function ext_view($folder, $view, $vars = array(), $return = FALSE) {
        $this->_ci_view_paths = array_merge($this->_ci_view_paths, array(APPPATH . $folder . '/' => TRUE));
        if (method_exists($this, '_ci_object_to_array'))
        {
                return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
        } else {
                return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_prepare_view_vars($vars), '_ci_return' => $return));
        }
    }

}


