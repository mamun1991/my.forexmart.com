<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 2/25/16
 * Time: 12:33 PM
 */

class Spread_projects extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('partners_model');
        $this->lang->load('partnership');
        //if(!IPLoc::Office()){redirect('');}
        if(!$this->session->userdata('logged')){redirect('');}

    }
    public $periodicity = array('1'=>'Daily','2'=>'Weekly','3'=>'Monthly');

                                public $spread = array(
                                        "251"=>"2.5 pips",
                                        "301"=>"3.0 pips",
                                        "351"=>"3.5 pips",
                                        "401"=>"4.0 pips",
                                        );
    public function index() {
        $this->load->library('IPLoc', null);
        if($this->session->userdata('logged') ){


            $this->lang->load('myaccount');


            $user_id = $this->session->userdata('user_id');
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }

            $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            $data['isCPA'] = $this->isCPA;
            $data['title_page'] = lang('sb_li_4');
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = '';
            $data['affiliate_code'] =  $affiliate_code[0]['affiliate_code'];
            $data['affiliate_codes'] = $affiliate_code;
            $data['www'] = $this->config->item('domain-www');

           // $this->form_validation->set_rules('project_name', 'Project Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('spread', 'Spread', 'trim|required|xss_clean');


            if ($this->form_validation->run()) {

                $insertData =  array(
                    'project_name'=>'Default Project',
                    'spread' => $this->input->post('spread'),
                    'user_id'=> $user_id,
                    'status'=>1,
                    'created_date'=> date('Y-m-d H:i:s')
                );
                $this->general_model->conditionalDelete('spread_projects',array('user_id'=>$user_id,'spread'=>$insertData['spread']));
                $this->general_model->insert('spread_projects',$insertData);
            }

            $data['active_tab'] = 'spread-projects';
            $data['active_sub_tab'] = 'accounts';
            $data['page'] = 'spread_project/default';
            $data['nav'] = 'default';
            $data['project']= $this->general_model->show('spread_projects','user_id',$user_id,'','id,desc')->row();
            $data['spread']= $this->general_model->selectOptionList($this->spread,$data['project']->spread);
            $data['spread_list'] = $this->spread;

            $data['login_type'] = $this->session->userdata('login_type');
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
            $this->template->title(lang('mya_tit'))
                ->append_metadata_css('')
                ->append_metadata_js('')
                ->set_layout('internal/main')
                ->build('spread_project/navigation', $data);

        }else{
            redirect('signout');
        }
    }
    public function update(){
        if($this->session->userdata('logged')){
            $id = $this->input->post('id');
            $updateData = array(
                'periodicity' => $this->input->post('periodicity'),
                'status'    => $this->input->post('st')
            );

            if($updateData['status'] == 0){
                $this->general_model->conditionalDelete('spread_projects',array('id'=>$id));
            }else{
                $this->general_model->updatemy('spread_projects','id',$id,$updateData);
            }




        }else{
            redirect('signout');
        }
    }
    public function individual_project() {
        if($this->session->userdata('logged')){
            $this->load->library('IPLoc', null);

            $this->lang->load('myaccount');

            $user_id = $this->session->userdata('user_id');
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }

            $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            $data['isCPA'] = $this->isCPA;
            $data['title_page'] = lang('sb_li_4');
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = '';
            $data['affiliate_code'] =  $affiliate_code[0]['affiliate_code'];
            $data['affiliate_codes'] = $affiliate_code;
            $data['www'] = $this->config->item('domain-www');
                $data['rebate']= $this->general_model->show('individual_spread','user_id',$user_id,'','id,desc')->result();
            $data['affiliate_code_all']= $this->general_model->show('partnership_affiliate_code','partner_id',$user_id,'','id,desc')->result();

            $this->form_validation->set_rules('project_name', 'Project name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('affiliate_code', 'Affiliate code', 'trim|required|xss_clean|is_unique[individual_spread.affiliate_code]');

            if ($this->form_validation->run()) {

               if(count($data['rebate'])<11){
                        $insertData = array( 'spread'=>$this->input->post('spread'),
                            'project_name'=>$this->input->post('project_name'),
                            'affiliate_code'=>$this->input->post('affiliate_code'),
                            'user_id'=>$user_id,
                            'date_created'=>date('Y-m-d H:i:s'));

                        /*$partner_affiliate = array(
                            'affiliate_code'=>$this->input->post('affiliate_code'),
                            'partner_id' => $user_id,
                            'individual_spread'=>1
                        );

                         $this->general_model->insert('partnership_affiliate_code',$partner_affiliate);*/

                        $this->general_model->conditionalDelete('individual_spread',array('user_id'=>$insertData['user_id'],'spread'=>$insertData['spread'],'project_name'=>$insertData['project_name']));
                        $this->general_model->insert('individual_spread',$insertData);
                   redirect('spread_projects/individual_project');
               }


            }


            $data['referrals'] = $this->partners_model->getReferralsNDB($user_id);



            $data['project'] = $this->partners_model->getRebateProject($user_id);

            $data['periodicity'] = $this->periodicity;
            $data['active_tab'] = 'spread-projects';
            $data['page'] = 'spread_project/personal_rebate';
            $data['nav'] = 'personal_rebate';
            $data['spread']= $this->general_model->selectOptionList($this->spread);
            $data['spread_list'] = $this->spread;

            $data['login_type'] = $this->session->userdata('login_type');
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
            $this->template->title(lang('mya_tit'))
                ->append_metadata_css('')
                ->append_metadata_js('')
                ->set_layout('internal/main')
                ->build('spread_project/navigation', $data);

        }else{
            redirect('signout');
        }
    }
    public function statistics() {
        if($this->session->userdata('logged')){
            $this->load->library('IPLoc', null);

            $this->lang->load('myaccount');

            $user_id = $this->session->userdata('user_id');



            $data['active_tab'] = 'spread-projects';
            $data['page'] = 'rebate_system/statistics';
            $data['nav'] = 'statistics';

            $data['login_type'] = $this->session->userdata('login_type');
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
            $this->template->title(lang('mya_tit'))
                ->append_metadata_css('')
                ->append_metadata_js('')
                ->set_layout('internal/main')
                ->build('spread_project/navigation', $data);

        }else{
            redirect('signout');
        }
    }
    public function separate_spread_delete(){
        if($this->session->userdata('logged')){
            $id = $this->input->get('id',true);
            $user_id = $this->session->userdata('user_id');

            $this->general_model->conditionalDelete('individual_spread',array(
                'id' => $id,
                'user_id'    => $user_id
            ));

            redirect('spread-projects/individual-project');

        }else{
            redirect('signout');
        }
    }

    public function rebate_Affiliate_Link(){
        $this->load->library('IPLoc', null);
       // if(!IPLoc::Office()){redirect('');}

        if($this->session->userdata('logged')){


            $this->lang->load('myaccount');

            $user_id = $this->session->userdata('user_id');

            $this->form_validation->set_rules('account', 'Account number', 'trim|required|xss_clean');

            if ($this->form_validation->run()) {

                $insertData = array( 'rebate'=>$this->input->post('rebate'),
                    'account_number'=>$this->input->post('account'),
                    'periodicity'=>$this->input->post('periodicity'),
                    'user_id'=>$user_id,
                    'date_created'=>date('Y-m-d H:i:s'));

                $this->general_model->delete('personal_rebate','account_number',$this->input->post('account'));
                $this->general_model->insert('personal_rebate',$insertData);


            }


            $data['referrals'] = $this->partners_model->getReferralsNDB($user_id);



            $data['project'] = $this->partners_model->getRebateProject($user_id);
            $data['rebate']= $this->partners_model->getRebateAccountList($user_id);
            $data['periodicity'] = $this->periodicity;
            $data['active_tab'] = 'spread-projects';
            $data['page'] = 'rebate_system/personal_rebate';
            $data['nav'] = 'personal_rebate';

            $data['login_type'] = $this->session->userdata('login_type');
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
            $this->template->title(lang('mya_tit'))
                ->append_metadata_css('')
                ->append_metadata_js('')
                ->set_layout('internal/main')
                ->build('spread_project/navigation', $data);

        }else{
            redirect('signout');
        }

    }
}


