<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 2/22/17
 * Time: 4:29 PM
 */

class Cashback extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('partners_model');
        $user_id = $this->session->userdata('user_id');
      /*  if($type = $this->general_model->showt1w1("partnership",'partner_id',$user_id,'*')){
            if($type['type_of_partnership']=="cpa" || $type['type_of_partnership']=="extra_commission"){
                redirect(FXPP::my_url('my-account'));
            }
        }*/

        if(!FXPP::isCashback($user_id)){redirect();}



    }



    public function index() {
        if($this->session->userdata('logged')){
            $this->load->library('IPLoc', null);

            $this->lang->load('myaccount');

            $user_id = $this->session->userdata('user_id');



            $data['active_tab'] = 'rebate-system';
            $data['page'] = 'cash_back/statistics';
            $data['nav'] = 'statistics';
            $data['referrals'] = $this->partners_model->getReferralsNDB($user_id);

            $data['login_type'] = $this->session->userdata('login_type');
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
            $this->template->title(lang('mya_tit'))
                ->append_metadata_css('')
                ->append_metadata_js('')
                ->set_layout('internal/main')
                ->build('cash_back/navigation', $data);

        }else{
            redirect('signout');
        }
    }

    public function statisticsData() {
        if($this->session->userdata('logged')){
            $this->load->library('IPLoc', null);
            $user_id = $this->session->userdata('user_id');
            $account_number =  239789 ;
            $from = $this->input->post('from',true);
            $to = $this->input->post('to',true);

            if($data= $this->partners_model->getCashbackStatisticsData($from,$to,$this->session->userdata('account_number'),$account_number)){

                $arr = array();
                foreach($data as $d){
                    if($d->num >0){
                        $arr[]= "[". strtotime($d->p_date)*1000 .", ".$d->num."]";
                    }

                }
                echo "[".join(",",$arr)."]";
            }



        }else{
            redirect('signout');
        }
    }



} 