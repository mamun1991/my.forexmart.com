<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->lang->load('register');
        $this->load->library('WSV'); //New web service

    }

    public function index()
    {
        
         redirect(FXPP::loc_url('registration'));

        if ($this->uri->segment(3) == "step2") {
            $this->form_validation->set_rules('street', 'Street', 'trim|required|xss_clean');
            $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
            $this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean');
            $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zip', 'Zip', 'trim|required|xss_clean');
            $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');

            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('re_password', 'Re-password', 'trim|required|xss_clean|matches[password]');
            $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('mt_account_set_id', 'Account type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('mt_currency_base', 'Account Currency Base', 'trim|required|xss_clean');
            $this->form_validation->set_rules('leverage', 'Leverage', 'trim|required|xss_clean');
           /* $this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');*/
          //  print_r($_POST); exit();

            if ($this->form_validation->run()) {

              // print_r($_POST); exit();

                $use_username = $this->config->item('use_username', 'tank_auth');
                $email_activation = $this->config->item('email_activation', 'tank_auth');
                $this->db->trans_start() ;
                $user_inser_data = $this->tank_auth->create_user(
                    $use_username ? $this->form_validation->set_value('username') : '',
                    $this->session->userdata('email_live'),
                    $this->form_validation->set_value('password'),
                    $email_activation,1,0);

                $user_id = $user_inser_data['user_id'];

                $this->session->set_userdata('country_code', $this->input->post('country',true));
                $profile = array(
                    'full_name' => $this->session->userdata('full_name_live'),
                    'user_id' => $user_id,
                    'country' => $this->input->post('country',true),
                    'street' => $this->input->post('street',true),
                    'city' => $this->input->post('city',true),
                    'state' => $this->input->post('state',true),
                    'zip' => $this->input->post('zip',true),
                    'dob' => $this->input->post('dob',true)

                );
                $this->general_model->insert('user_profiles', $profile); // Insert into user profile data.
                // leverage, mt_currency_base,mt_account_set_id,registration_ip,user_id
                $mt_account = array(
                    'leverage' => $this->input->post('leverage',true),
                    'amount' => $this->input->post('amount',true),
                    'mt_currency_base' => $this->input->post('mt_currency_base',true),
                    'mt_account_set_id' => $this->input->post('mt_account_set_id',true),
                    'registration_ip' => $_SERVER['REMOTE_ADDR'],
                    'user_id' => $user_id,
                    'mt_type' => 1
                );
                $this->general_model->insert('mt_accounts_set', $mt_account);

                $experiences = $this->input->post('experience',true);
                $experience = is_array($experiences)?join(",",$experiences):"";

                $trading_experience = array(
                    'investment_knowledge' => $this->input->post('investment_knowledge',true),
                    'risk' => $this->input->post('risk',true),
                    'experience' => $experience,
                    'user_id' => $user_id,
                    'technical_analysis' => $this->input->post('technical_analysis',true),
                );
                $this->general_model->insert('trading_experience', $trading_experience);

                // employment_status,industry,source_of_funds,estimated_annual_incomeestimated_net_worth,politically_exposed_person,education_level,user_id
                $employment_detail = array(
                    'employment_status' =>$this->input->post('mt_currency_base',true),
                    'industry' =>$this->input->post('industry',true),
                    'source_of_funds' =>$this->input->post('source_of_funds',true),
                    'estimated_annual_income' =>$this->input->post('estimated_annual_income',true),
                    'estimated_net_worth' =>$this->input->post('estimated_net_worth',true),
                    'politically_exposed_person' =>$this->input->post('politically_exposed_person',true),
                    'education_level' =>$this->input->post('education_level',true),
                    'user_id' =>$user_id
                );
                $this->general_model->insert('employment_details', $employment_detail);
                $this->db->trans_complete();
                $user_data = array(
                    'email' => $this->session->userdata('email_live'),
                    'full_name' => $this->session->userdata('full_name_live'),
                    'user_id' => $user_id,
                    'logged_in'	=> TRUE,
                    'logged' => 1
                );
                $this->session->set_userdata($user_data);

                redirect('my-account');




            }

            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries());
            $data['account_type'] = $this->general_model->selectOptionList($this->general_model->getAccountType());
            $data['account_currency_base'] = $this->general_model->selectOptionList($this->general_model->getAccountCurrencyBase());
            $this->load->model('user_model');
            $user = $this->user_model->getUserProfileByUserId($user_id);
            if(in_array(strtoupper($user['country']), array('PL'))){
                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 100));
            }else {
                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage());
            }
            $data['amount'] = $this->general_model->selectOptionList($this->general_model->getAmount());
            $data['employment_status'] = $this->general_model->selectOptionList($this->general_model->getEmploymentStatus());
            $data['industry'] = $this->general_model->selectOptionList($this->general_model->getIndustry());
            $data['source_of_funds'] = $this->general_model->selectOptionList($this->general_model->getSourceOfFunds());
            $data['estimated_annual_income'] = $this->general_model->selectOptionList($this->general_model->getEstimatedAnnualIncome());
            $data['estimated_net_worth'] = $this->general_model->selectOptionList($this->general_model->getEstimatedNetWorth());
            $data['investment_knowledge'] = $this->general_model->selectOptionList($this->general_model->getInvestmentKnowledge());
            $data['education_level'] = $this->general_model->selectOptionList($this->general_model->getEducationLevel());


            $this->template->title("ForexMart | Live Trading Account")
                ->set_layout('external/main')
                ->build('auth/register_live2',$data);

        } else {
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required|xss_clean');
            $this->form_validation->set_rules('full_name', 'Full name', 'trim|required|xss_clean');
            $this->form_validation->set_message('is_unique', 'This email is already used.');
            if ($this->form_validation->run()) {

                $user_data = array(
                    'email_live' => $this->input->post('email',true),
                    'full_name_live' => $this->input->post('full_name',true)
                );
                $this->session->set_userdata($user_data);
                redirect('register/index/step2');
            }


            $this->template->title("ForexMart | Live Trading Account")
                ->set_layout('external/main')
                ->build('auth/register_live1');
        }
    }
    public function passwordCheck(){
        $this->load->library('Tank_auth');
        if($this->input->post('status',true)=="demo")
        {
            $email = $this->session->userdata('email_demo');
        }
        else{
            $email =$this->session->userdata('email_live');
        }

        $users = $this->users->get_user_by_loginaccount( $email);

        if($users!= null){
            foreach($users as $user){
                $mydata=array(
                    'new'=>$this->input->post('pass',true),
                    'old'=>$user->password
                );

                if(Tank_auth::compare($mydata)){

                    echo true;
                    return true;

                }
            }
        }

    }

    public function demo()
    {

        if ($this->uri->segment(3) == "step2") {

//echo $this->session->userdata('email'); exit();
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('re_password', 'Re-password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('account_type', 'Account type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('currency', 'Account Currency Base', 'trim|required|xss_clean');
            $this->form_validation->set_rules('leverage', 'Leverage', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');
            if ($this->form_validation->run()) {

                $use_username = $this->config->item('use_username', 'tank_auth');
                $email_activation = $this->config->item('email_activation', 'tank_auth');

                $this->db->trans_start() ;
                $user_inser_data = $this->tank_auth->create_user(
                    $use_username ? $this->form_validation->set_value('username') : '',
                    $this->session->userdata('email_demo'),
                    $this->form_validation->set_value('password'),
                    $email_activation,0,0);

                $user_id = $user_inser_data['user_id'];
                //password, email,type,created
                /* $user = array(
                     'password'=> $this->input->post("password"),
                     'email' => $this->sesion->userdata('full_name'),
                     'type'  => "Demo",
                     'created' => date('Y-m-d H:i:s')
                 );*/

                //$user_id =$this->general_model->insert('users',$user);  // Insert user data
                // full_name,user_id,country,mt_account_set_id
                $profile = array(
                    'full_name' => $this->session->userdata('full_name_demo'),
                    'user_id' => $user_id,
                    'country' => $this->input->post('country',true),

                );
                $this->general_model->insert('user_profiles', $profile); // Insert into user profile data.
                // leverage, mt_currency_base,mt_account_set_id,registration_ip,user_id
                $mt_account = array(
                    'leverage' => $this->input->post('leverage',true),
                    'amount' => $this->input->post('amount',true),
                    'mt_currency_base' => $this->input->post('currency',true),
                    'mt_account_set_id' => $this->input->post('account_type',true),
                    'registration_ip' => $_SERVER['REMOTE_ADDR'],
                    'user_id' => $user_id,
                    'mt_type' => 0
                );
                $this->general_model->insert('mt_accounts_set', $mt_account);

                $trading_experience = array(
                    'instruments' => $this->input->post('instruments',true),
                    'risk' => $this->input->post('risk',true),
                    'experience' => $this->input->post('experience',true),
                    'user_id' => $user_id,
                    'technical_analysis' => $this->input->post('technical_analysis',true),
                );
                $this->general_model->insert('trading_experience', $trading_experience);

                $this->db->trans_complete();
                $user_data = array(
                    'email' => $this->session->userdata('email_demo'),
                    'full_name' => $this->session->userdata('full_name_demo'),
                    'user_id' => $user_id,
                    'logged_in'	=> TRUE,
                    'logged' => 1
                );
                $this->session->set_userdata($user_data);
                redirect('my-account');

            }
            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries());
            $data['account_type'] = $this->general_model->selectOptionList($this->general_model->getAccountType());
            $data['account_currency_base'] = $this->general_model->selectOptionList($this->general_model->getAccountCurrencyBase());
            $this->load->model('user_model');
            $user = $this->user_model->getUserProfileByUserId($user_id);
            if(in_array(strtoupper($user['country']), array('PL'))){
                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 100));
            }else {
                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage());
            }
            $data['amount'] = $this->general_model->selectOptionList($this->general_model->getAmount());

            $this->template->title("ForexMart | Demo Account")
                ->set_layout('external/main')
                ->build('auth/register_demo2',$data);

        } else {
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required|xss_clean');
            $this->form_validation->set_rules('full_name', 'Full name', 'trim|required|xss_clean');
            $this->form_validation->set_message('is_unique', 'This email is already used.');
            if ($this->form_validation->run()) {


                $user_data = array(
                    'email_demo' => $this->input->post('email',true),
                    'full_name_demo' => $this->input->post('full_name',true)
                );
                $this->session->set_userdata($user_data);
                redirect('register/demo/step2');
            }




            $this->template->title("ForexMart | Demo Account")
                ->set_layout('external/main')
                ->build('auth/register_demo1');
        }
    }

    public function test(){
        $nodepositbonus = $this->general_model->showssingle2($table='users',$field='id',$id=8929,$select='nodepositbonus,created,createdforadvertising');
        if(is_null($nodepositbonus['createdforadvertising'])){
            $data['datecreated']=$nodepositbonus['created'];
        }else{
            $data['datecreated']=$nodepositbonus['createdforadvertising'];
        }
        $account_details = $this->general_model->showssingle2($table='mt_accounts_set',$field='user_id',$id=8929,$select='mt_account_set_id');
        $datecreated=DateTime::createFromFormat('Y-m-d H:i:s',$data['datecreated']);
        $datedifference=$this->general_model->difference_day($datecreated->format('Y-m-d'),$datecurrent=date('Y-m-d'));

        if ($nodepositbonus['nodepositbonus']==1 OR $datedifference>7 OR $account_details['mt_account_set_id'] != 1){
            $data['data']['expireNoDeposit']=true;
        }else{
            $data['data']['expireNoDeposit']=false;
        }

        var_dump($data);
    }

}
