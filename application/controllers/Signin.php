<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends CI_Controller {

    public function __construct(){

        parent::__construct();
        $this->load->model('tank_auth/users');

    }

    public function signin()
    {
        $this->lang->load('tank_auth');
        $this->load->library('Tank_auth');
        if ($this->tank_auth->is_logged_in()) {									// logged in
            FXPP::update_account_balance();
            redirect('my-accounts');

        } elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
//            redirect('/auth/send_again/');
            redirect('/client/signin');

        } else {
            $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
                $this->config->item('use_username', 'tank_auth'));
            $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

            $this->form_validation->set_rules('username', 'Log in', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('remember', 'Remember me', 'integer');

            // Get login for counting attempts to login
            if ($this->config->item('login_count_attempts', 'tank_auth') AND
                ($login = $this->input->post('login',true))) {
                $login = $this->security->xss_clean($login);
            } else {
                $login = '';
            }

            /* $data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
             if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
                 if ($data['use_recaptcha'])
                     $this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
                 else
                     $this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
             }*/
            $data['errors'] = array();

            if ($this->form_validation->run()) {								// validation ok
                if ($this->tank_auth->login(
                    $this->form_validation->set_value('username'),
                    $this->form_validation->set_value('password'),
                    $this->form_validation->set_value('remember'),
                    $data['login_by_username'],
                    $data['login_by_email'])) {								// success
                    FXPP::update_account_balance();
                    FXPP::update_account_group();
                    redirect('my-accounts');
                } else {

                    $errors = $this->tank_auth->get_error_message();

                    $data['data']['errors']= $errors;


                    if (isset($errors['banned'])) {								// banned user
                        $this->_show_message(lang('auth_message_banned').' '.$errors['banned']);

                    } elseif (isset($errors['not_activated'])) {				// not activated user
//                        redirect('/auth/send_again/');

                    } else {													// fail
                        foreach ($errors as $k => $v)	$data['errors'][$k] = lang($v);
                    }
                }
            }

            /*$data['show_captcha'] = FALSE;
            if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
                $data['show_captcha'] = TRUE;
                if ($data['use_recaptcha']) {
                    $data['recaptcha_html'] = $this->_create_recaptcha();
                } else {
                    $data['captcha_html'] = $this->_create_captcha();
                }
            }*/


            $data['data']['username']=  array(
                'name'          => 'username',
                'id'            => 'inputEmail3',
                'value'         => set_value('username', ''),
                'type'          => 'text',
                'class'         => form_error('username')|| isset($errors['username']) ?'form-control round-0  red-border': 'form-control round-0 ' ,
                'placeholder'   => 'Email'
            );

            $data['data']['password'] =  array(
                'name'          => 'password',
                'id'            => 'pass',
                'value'         => set_value('password', ''),
                'type'          => 'password',
                'class'         =>  form_error('password')|| isset($errors['password']) ?'form-control round-0  red-border': 'form-control round-0 ' ,
                'placeholder'   => 'Password'
            );

            $data['data']['output_key']= '';
            $css = $this->template->Css();
            $js = $this->template->Js();
            $data['data']['output_key']= '';
            $data['data']['Error'] = true;
            $this->template->title("Sign in")
                ->append_metadata_css("
                        <link rel='stylesheet' href='".$css."/signin.min.css'>
                ")
                ->append_metadata_js("

                ")
                ->set_layout('external/main')
                ->build('signin',$data['data']);
        }
    }

    public function username_check($str){
        if (!is_null($user = $this->users->get_user_by_login( $this->input->post('username',true)))) {
            return true;
        }else{
            $this->form_validation->set_message('username_check', 'Incorrect username . Please try again.');
            return FALSE;
        }
    }
    public function password_check($str){
        $this->load->library('Tank_auth');
        if (!is_null($user = $this->users->get_user_by_loginaccount( $this->input->post('username',true)))) {
            $mydata=array(
                'new'=>$this->input->post('password',true),
                'old'=>$user->password
            );
            if(Tank_auth::compare($mydata)){
                $newdata = array(
                    'full_name'  => $user->full_name,
                    'email'     => $user->email,
                    'logged' => 1,
                    'user_id'	=> $user->id,
                    'username'	=> $user->username,
                    'status'	=> ($user->activated == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
                );
                $this->session->set_userdata($newdata);
                redirect('my-accounts');
                return true;
            }else{
                $this->form_validation->set_message('password_check', 'Incorrect password . Please try again.');
                return FALSE;
            }
        }
    }



}
