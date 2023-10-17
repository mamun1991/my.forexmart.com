<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('mailer_model');
    }


    public function index()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        if($this->session->userdata('logged')) {
            $this->load->helper('language');

            $getReplyTo = $this->mailer_model->getAllReplyTo();

            $data['active_tab'] = 'setting';
            $data['active_sub_tab'] = 'reply-to';

            $this->template->title("ForexMart | Mailer Settings")
                ->set_layout('internal/mailer')
                ->prepend_metadata("

                            ")
                ->build('mailer/mailer_settings',$data);
        }else{
            redirect('signout');
        }
    }

    public function language()
    {
        if($this->session->userdata('logged')) {
            $this->load->helper('language');

            $data['active_tab'] = 'setting';
            $data['active_sub_tab'] = 'language';
            $data['language'] = $this->general_model->show('language')->result();


            $this->template->title("ForexMart | Mailer Settings")


                ->set_layout('internal/mailer')
                ->prepend_metadata("")
                ->build('mailer/language',$data);
        }else{
            redirect('signout');
        }
    }
    public function languageSave(){
        if($this->session->userdata('logged')) {
            $this->form_validation->set_rules('name', 'Language Name', 'trim|required|xss_clean|is_unique[language.name]');
            $this->form_validation->set_message('is_unique', 'This language is already in the list');

            if ($this->form_validation->run()) {
                $insert_data = array('name'=>$this->input->post('name',true));
               $id = $this->general_model->insert('language',$insert_data);
                $respons= array(
                    'respons'=> 'ok',
                    'name' => $this->input->post('name',true),
                    'id'    => $id
                );
                echo json_encode($respons);
            }else{

                $respons= array(
                    'respons'=> 'error',
                    'msg' => form_error('name')
                );
                echo json_encode($respons);
            }


        }else{
            redirect('signout');
        }

    }

    public function scheme()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        if($this->session->userdata('logged')) {
            $this->load->helper('language');

            $data['active_tab'] = 'setting';
            $data['active_sub_tab'] = 'scheme';

            $this->template->title("ForexMart | Mailer Settings")
                ->set_layout('internal/mailer')
                ->prepend_metadata("

                            ")
                ->build('mailer/scheme',$data);
        }else{
            redirect('signout');
        }
    }

}
