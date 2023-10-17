<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct(){
        parent::__construct();
        

    }
    public function SetCookie(){
        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $data['cookie'] = array(
            'name'   => 'conceal',
            'value'  => rand(0,100),
            'expire' => time() + (10 * 365 * 24 * 60 * 60),
            'domain' => '.forexmart.com',
            'path'   => '/',
            'prefix' => '',
            'secure' => true,
            'httponly' => true,
        );
        $this->input->set_cookie($data['cookie'],true);
    }
    /** start external top navigation*/

    /** end external footer navigation*/
    public function FeedbackSendEmail(){
        $this->load->model('External_model');

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');

        $data['return']=false;
        $data['returnid']=false;

        if($this->form_validation->run()){

            $data['update']=array(
                'email'  => $this->input->post('email',true),
                'id'  => $this->session->feedbackid
            );
            $data['returnid']=$this->External_model->updateFeedbackemail($data['update']);
            $data['return']=true;
        }else{
            $data['return']=false;
        }

        if(validation_errors()){
            $data['return']=true;
        }

        if($data['return']){
            $data['call_modal']="
                    <script type='text/javascript'>
                        $(document).ready(function(){
                              $('#popfeedback').modal('show');

                              $('#FeedbackFormRating')
                                  .removeClass('formshow')
                                  .addClass('formhide');

                              $('#FeedbackFormSuccess')
                                   .removeClass('formhide')
                                  .addClass('formshow');

                               $('.modalfeedbackcontent')
                                    .removeClass('setsuccessheight');
                               $('#FeedbackFormDone')
                                  .removeClass('formshow')
                                  .addClass('formhide');
                        });
                    </script>
                ";

            if($data['returnid']!=false){
                $data['call_modal'].="
                    <script type='text/javascript'>
                        $(document).ready(function(){
                             $('#FeedbackFormRating')
                                  .removeClass('formshow')
                                  .addClass('formhide');
                               $('#FeedbackFormSuccess')
                                   .removeClass('formshow')
                                  .addClass('formhide');
                              $('.modalfeedbackcontent')
                                    .addClass('setsuccessheight');
                               $('#FeedbackFormDone')
                                 .removeClass('formhide')
                                    .addClass('formshow');
                               $('.modalfeedbackcontent').removeClass('setsuccessheight');
                        });
                    </script>
                ";
            }
        }else{
            $data['call_modal']="";
        }


        $data['data']='';
        $this->template->title("Home")
            ->append_metadata_js($data['call_modal'])
            ->set_layout('external/main')
            ->build('home');
    }
    public function feedback(){

        $this->lang->load('feedback');
        $this->load->model('External_model');

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('rate', 'Rating', 'required');
        $this->form_validation->set_rules('category', 'Category', 'trim|required');
        $this->form_validation->set_rules('textarea', 'Comment', 'trim|alpha_numeric');
        $data['return']=false;
        $data['returnid']=false;

        if($this->form_validation->run()){

            if (isset($_POST['feedback'])){
                $data['insert']=array(
                    'user_id' => ($this->session->userdata('user_id'))? $this->session->userdata('user_id') :0,
                    'rating' => $this->input->post( 'rate' ,true),
                    'category' => $this->input->post( 'category',true ),
                    'message' => $this->input->post( 'textarea',true )
                );

                $data['returnid']=$this->External_model->insertFeedback($data['insert']);

                if($data['returnid']!=false){
                    $this->session->set_userdata(array('feedbackid'  => $data['returnid']));
                }

                $data['return']=true;
            }
        }else{

            $data['return']=false;
            $this->session->unset_userdata('feedbackid');
        }


        if(validation_errors()){
            $data['return']=true;
        }

        if($data['return']){
            $data['call_modal']="
                    <script type='text/javascript'>
                        $(document).ready(function(){
                              $('#popfeedback').modal('show');
                        });
                    </script>
                ";

            if($data['returnid']!=false){
                $data['call_modal'].="
                    <script type='text/javascript'>
                        $(document).ready(function(){
                              $('#FeedbackFormRating')
                                  .removeClass('formshow')
                                  .addClass('formhide');
                               $('#FeedbackFormSuccess')
                                    .removeClass('formhide')
                                    .addClass('formshow');
                              $('.modalfeedbackcontent').addClass('setsuccessheight');
                        });
                    </script>
                ";
            }
        }else{
            $data['call_modal']="";
        }


        $data['data']='';
        $this->template->title("Home")
            ->append_metadata_js($data['call_modal'])
            ->set_layout('external/main')
            ->build('home');


    }

    public function getServerTime(){
//        $this->load->library('FXPP');
        echo FXPP::getServerTime();
        echo '<br/>';
        echo date('Y-m-d H:i:s');
        echo '<br/>';
        date_default_timezone_set('Europe/Minsk');
        echo date('Y-m-d H:i:s');
        echo '<br/>';
//        echo FXPP::getCurrentDateTime();
    }

}
