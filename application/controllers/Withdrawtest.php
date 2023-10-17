<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Withdrawtest extends MY_Controller {

    private $transaction_type = array(
        'BANK TRANSFER' => 'BT',
        'NETELLER' => 'NT',
        'SKRILL' => 'SK',
        'CREDIT CARD' => 'CC',
        'MEGATRANSFER CARD' => 'MTC',
        'UNIONPAY' => 'UP',
        'WEBMONEY' => 'WM',
        'PAXUM' => 'PX',
        'UKASH' => 'UK',
        'PAYCO' => 'PC',
        'FILSPAY' => 'FP',
        'CASHU' => 'CU',
        'PAYPAL' => 'PP',
        'QIWI' => 'QW',
        'MEGATRANSFER' => 'MT',
        'BITCOIN' => 'BC',
        'MONETA' => 'MN',
        'SOFORT' => 'SF',
        'YANDEXMONEY' => 'YAN',
        'FASAPAY' => 'FASA',
        'EMERCHANTPAY' => 'EPAY',
        'CHINAUNIONPAY' => 'CUP',
        'PAYOMA'=>'PAYOMA',
        'INPAY'=>'INPAY',
        'ALIPAY'=>'ALIPAY',
        'BANK_MYR'=>'BANK_MYR',
        'BANK_THB'=>'BANK_THB',
        'BANK_VND'=>'BANK_VND',
        'BANK_IDR'=>'BANK_IDR',
        'BANK_NGN'=>'BANK_NGN',
        'ZOTAPAY_MYR'=>'ZOTAPAY_MYR',
        'ZOTAPAY_IDR'=>'ZOTAPAY_IDR',
        'ZOTAPAY_VND'=>'ZOTAPAY_VND',
        'ZOTAPAY_THB'=>'ZOTAPAY_THB',
        'ZOTAPAY_CARD'=>'ZOTAPAY_CARD',
        'ASIA_VND'=>'ASIA_VND',
        'NOVA2PAY'=>'NOVA2PAY',

    );


    private $paymentType_status = array(
        'CREDIT CARD' => 1,
        'MEGATRANSFER CARD' => 2,
        'BANK TRANSFER'  => 3,
        'SKRILL'       => 4,
        'NETELLER'     => 5 ,
        'PAXUM'        => 6,
        'PAYPAL'       => 7,
        'WEBMONEY'     => 8,
        'PAYCO'        => 9,
        'QIWI'         => 10,
        'MEGATRANSFER' => 11,
        'BITCOIN'      => 12,
        'YANDEXMONEY'  => 13,
        'MONETA'       => 14,
        'SOFORT'       => 15,
        'SOFORT2'       => 20,
        'FASAPAY'      => 16,
        'EMERCHANTPAY' => 17,
        'CHINAUNIONPAY' => 18,
        'PAYOMA' => 19,
        'INPAY' => 20,
        'ALIPAY' => 21,
        'BANK_MYR' => 22,
        'BANK_THB'=>23,
        'BANK_VND'=>24,
        'BANK_IDR'=>25,
        'ASIA_VND'=>26,
    );

    private $currency_status = array(
        'USD'  => 1,
        'EUR'  => 2,
        'GBP'  => 3,
        'RUR'  => 4,
        'RUB'  => 4,
        'MYR'  => 5 ,
        'IDR'  => 6,
        'THB'  => 7,
        'CNY'  => 8,
        'Cents' => 9,
        'VND'   => 10,
    );

    private $comment_type = array(
        'withdraw' => 'W/D_'
    );

    private $comment_transaction_type = array(
        'BANK TRANSFER' => 'WIRE_TRANSFER_BOC_',
        'NETELLER' => 'NT_',
        'SKRILL' => 'SK_',
        'CREDIT CARD' => 'CP_',
        'MEGATRANSFER CARD' => 'MTC_',
        'UNIONPAY' => 'CUP_',
        'WEBMONEY' => 'WM_',
        'PAXUM' => 'PX_',
        'UKASH' => 'UK_',
        'PAYCO' => 'PC_',
        'FILSPAY' => 'FP_',
        'CASHU' => 'CU_',
        'PAYPAL' => 'PP_',
        'QIWI' => 'QIWI_',
        'MEGATRANSFER' => 'MT_',
        'YANDEXMONEY' => 'YM_',
        'BITCOIN' => 'BITCOIN_',
        'MONETA' => 'MN_',
        'SOFORT' => 'SF_',
        'TRANSIT_TRANSFER' => 'TR_',
        'FASAPAY' => 'FASA_',
        'EMERCHANTPAY' => 'EPAY_',
        'CHINAUNIONPAY' => 'CUP_',
        'PAYOMA'=>'PAYOMA_',
        'INPAY'=>'INPAY_',
        'ALIPAY'=>'ALIPAY_',
        'BANK_MYR'=>'BANK_MYR_',
        'BANK_THB'=>'BANK_THB_',
        'BANK_VND'=>'BANK_VND_',
        'BANK_IDR'=>'BANK_IDR_',
        'BANK_NGN'=>'BANK_NGN_',
        'ZOTAPAY'=>'ZP_',
        'ZOTAPAY_MYR'=>'ZP_',
        'ZOTAPAY_IDR'=>'ZP_',
        'ZOTAPAY_VND'=>'ZP_',
        'ZOTAPAY_THB'=>'ZP_',
        'ZOTAPAY_CARD'=>'ZPC_',
        'ASIA_VND'=>'ASIA_VND_',
        'NOVA2PAY'=>'NOVA2PAY_',
    );

    private $percent_deduction = 0.10;

    function __construct(){
        parent::__construct();
        $this->load->model('withdraw_model');
        $this->load->model('account_model');
        $this->load->model('deposit_model');
        $this->load->model('general_model');
        //        $this->load->library('Fx_mailer');
        //language
        $this->load->helper('language');
        $this->lang->load('withdraw');
        $this->lang->load('modal_message');
        $this->lang->load('its');
        $this->lang->load('currenttrades_lang'); 
        $this->load->library('Transaction');
        
        if(FXPP::prohibition(2))
        {
            redirect(base_url()); 
        }
        
    }

    public function index(){

        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $this->lang->load('depositwithdraw');
        $this->lang->load('sidebar');

        if ($this->session->userdata('logged')) {
            $user_id = $this->session->userdata('user_id');
            $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
            $data['login_type'] = $mtas3['login_type'];
            $data['title_page'] = lang('sb_li_2');
            if(FXPP::fmGroupType($_SESSION['account_number']) == 'ForexMart Pro'){
                $data['modal_pro_alert'] = $this->load->ext_view('modal', 'depositpro_alert', $data['data'], true);
            }
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $data['metadata_description'] = lang('wit_dsc');
            $data['metadata_keyword'] = lang('wit_kew');
            $css = $this->template->Css();
            $this->template->title(lang('wit_tit'))
                ->append_metadata_css("
                    <link rel='stylesheet' href='" . $css . "/finance-style.css'>
                    <link rel='stylesheet' href='" . $css . "/finance-style-v2.css'>
            ")
                ->set_layout('internal/main')
                ->prepend_metadata("")
                ->build('withdrawnew/withdraw_index', $data);
        }else{
            redirect('signout');
        }
    }
    private function index_v1(){

            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            $this->lang->load('depositwithdraw');
            $this->lang->load('sidebar');

            if ($this->session->userdata('logged')) {
                $user_id = $this->session->userdata('user_id');
                $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
                $data['login_type'] = $mtas3['login_type'];
                $data['title_page'] = lang('sb_li_2');
                if(FXPP::fmGroupType($_SESSION['account_number']) == 'ForexMart Pro'){
                    $data['modal_pro_alert'] = $this->load->ext_view('modal', 'depositpro_alert', $data['data'], true);
                }
                $data['active_tab'] = 'finance';
                $data['active_sub_tab'] = 'withdraw';
                $data['metadata_description'] = lang('wit_dsc');
                $data['metadata_keyword'] = lang('wit_kew');
                $css = $this->template->Css();
                $this->template->title(lang('wit_tit'))
                    ->append_metadata_css("
                        <link rel='stylesheet' href='" . $css . "/finance-style.css'>
                        <link rel='stylesheet' href='" . $css . "/finance-style-v2.css'>
                ")
                    ->set_layout('internal/main')
                    ->prepend_metadata("")
                    ->build('withdraw_finance', $data);
            }
        }


    public function index_old(){
        $this->lang->load('depositwithdraw');
        if($this->session->userdata('logged')) {

            $user_id = $this->session->userdata('user_id');
            $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
            $data['login_type'] = $mtas3['login_type'];

            $data['title_page'] = lang('sb_li_2');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $data['metadata_description'] = lang('wit_dsc');
            $data['metadata_keyword'] = lang('wit_kew');
            $this->template->title(lang('wit_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata("
                            ")
                ->build('withdraw',$data);

        }else{
            redirect('signout');
        }
    }

    public function test_comment(){
        if(!IPLoc::Office()) { redirect('signout'); }

        $new_date = new DateTime();
        $generated_transaction_number = $new_date->getTimestamp();
        $comment = $this->comment_type['withdraw'] . $this->comment_transaction_type['BANK TRANSFER'] . $generated_transaction_number;

        FXPP::print_data($comment);
    }

    public function bankTransfer(){
        if($this->session->userdata('logged')) {
            if(!IPLoc::Office()){redirect('');}
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';


            $user_id = $this->session->userdata('user_id');
            $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
            $data['login_type'] = $mtas3['login_type'];
            //            if(!IPLoc::Office()){
            //
            //                $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance();
            //                $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
            //                $getNdbBonus  = $this->getWithdrawBonusFee20($account['ndb_bonus']);
            //                $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
            //                $getTransactionFee = FXPP::getTransactionFee('BANK TRANSFER', $account['mt_currency_base']);
            //
            //                $data['fee_details'] = ($getTransactionFee['fee'] * 100).'% + '.$getTransactionFee['addons'].' '.$account['mt_currency_base'];
            //            }else{
            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));

            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

            if(!$this->session->userdata('login_type')){
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                //$user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }

            }else{
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }

            $getTransactionFee = FXPP::getTransactionFee('BANK TRANSFER', $account['currency']);
            // $data['fee_details'] = ($getTransactionFee['fee'] * 100).'% + '.$getTransactionFee['addons'].' '.$account['currency'];
            //            }
            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'%';


            $data['ndb_bonus']  = $getNdbBonus;

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(), FXPP::getUserCountryCode());

            $data['disable_input'] = $user_status;
            $data['bank_min_withdrawal'] = $this->amountConverter(50, 'USD', $account['currency']);

            $js = $this->template->Js();
            $data['metadata_description'] = 'Please fill in all the appropriate fields to facilitate withdrawal of funds by bank transfer.';
            $this->template->title("ForexMart | Witdrawal Funds | Bank Transfer")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/bank_transfer',$data);
        }else{
            redirect('signout');
        }
    }

    public function yandex(){
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            redirect(FXPP::loc_url('withdraw')); //FXPP-9351

            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));

            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

           /* if(!$this->session->userdata('login_type')){
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                //$user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            }else{
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/

            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $getTransactionFee = FXPP::getTransactionFee('YANDEXMONEY', $account['currency']);
            if($account['currency'] == 'RUB'){
                $account['currency'] = 'RUR';
            }
            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'% + '.$getTransactionFee['addons'].' '.$account['currency'];

            $data['ndb_bonus']  = 0;

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(), FXPP::getUserCountryCode());

            $data['disable_input'] = $user_status;
            $js = $this->template->Js();
            $data['metadata_description'] = 'Please fill in all the appropriate fields to facilitate withdrawal of funds by bank transfer.';
            $this->template->title("Withdrawal Option - Yandex.Money")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/yandex',$data);
        }else{
            redirect('signout');
        }
    }

    public function testtestterew(){
        $this->load->model('Settings_model');

        $getTransactionFee = FXPP::getTransactionFee('NETELLER', 'USD');
        FXPP::print_data($getTransactionFee);

    }

    public function neteller(){
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $user_id = $this->session->userdata('user_id');
            $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
            $data['login_type'] = $mtas3['login_type'];
            //            if(!IPLoc::Office()){
            //                $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance();
            //                $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
            //                $getNdbBonus  = $this->getWithdrawBonusFee20($account['ndb_bonus']);
            //                $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
            //                $getTransactionFee = FXPP::getTransactionFee('NETELLER', $account['mt_currency_base']);
            //            }else{
            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);
            /*if(!$this->session->userdata('login_type')){
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus =   $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            }else{
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/

            $getTransactionFee = FXPP::getTransactionFee('NETELLER', $account['currency']);
            //            }

            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;


            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'%';
            $data['micro'] = $this->account_model->isMicro($this->session->userdata('user_id'));
            $data['disable_input'] = $user_status;
            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary information to withdraw via Neteller.';
            $this->template->title("ForexMart | Witdrawal Funds | Neteller")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/neteller',$data);
        }else{
            redirect('signout');
        }
    }

    public function skrill(){
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $user_id = $this->session->userdata('user_id');
            $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
            $data['login_type'] = $mtas3['login_type'];

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

            /*if(!$this->session->userdata('login_type')){
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
               // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
//                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
//                    $user_status = true;
//                }
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            }else{
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/


            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;
            $data['disable_input'] = $user_status;

            $getTransactionFee = FXPP::getTransactionFee('SKRILL', $account['currency']);
            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

           // $data['skrill_fee_limit'] = $this->amountConverter(11.41, 'USD', $account['currency']);
            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'%';
           // $data['fee_details'] = 'System Fee: 1% + '.($getTransactionFee['fee'] * 100).'%';
            //            }





            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary information to withdraw via Skrill.';
            $this->template->title("ForexMart | Witdrawal Funds | Skrill")
                ->set_layout('internal/main')
                ->prepend_metadata("
                        <script src='" . $js . "jquery.autonumeric.js'></script>
                        <script src='" . $js . "bootbox.min.js'></script>
                        ")
                ->build('withdrawnew/skrill',$data);
        }else{
            redirect('signout');
        }
    }
    public function qiwi(){
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $user_id = $this->session->userdata('user_id');
            $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
            $data['login_type'] = $mtas3['login_type'];

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

           /* if(!$this->session->userdata('login_type')){
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
               // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            }else{
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/

            $getTransactionFee = FXPP::getTransactionFee('QIWI', $account['currency']);
            //            }

            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;
            $data['disable_input'] = $user_status;

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'%';

            $data['disable_input'] = $user_status;

            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary information to withdraw via QIWI.';
            $this->template->title("ForexMart | Witdrawal Funds | QIWI")
                ->set_layout('internal/main')
                ->prepend_metadata("
                        <script src='" . $js . "jquery.autonumeric.js'></script>
                        <script src='" . $js . "bootbox.min.js'></script>
                        ")
                ->build('withdrawnew/qiwi',$data);
        }else{
            redirect('signout');
        }
    }

    public function megatransfer(){
        if($this->session->userdata('logged')) {
            redirect(FXPP::loc_url('withdraw'));
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $user_id = $this->session->userdata('user_id');
            $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
            $data['login_type'] = $mtas3['login_type'];
            //            if(!IPLoc::Office()){
            //
            //                $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance();
            //                $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
            //                $getNdbBonus  = $this->getWithdrawBonusFee20($account['ndb_bonus']);
            //                $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
            //                $getTransactionFee = FXPP::getTransactionFee('MEGATRANSFER', $account['mt_currency_base']);
            //            }else{
            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

            /*if(!$this->session->userdata('login_type')){
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
               // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            }else{
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/

            $getTransactionFee = FXPP::getTransactionFee('MEGATRANSFER', $account['currency']);
            //            }


            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;
            $data['disable_input'] = $user_status;

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'%';

            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary information to withdraw via MegaTransfer.';
            $this->template->title("ForexMart | Witdrawal Funds | MegaTransfer")
                ->set_layout('internal/main')
                ->prepend_metadata("
                        <script src='" . $js . "jquery.autonumeric.js'></script>
                        <script src='" . $js . "bootbox.min.js'></script>
                        ")
                ->build('withdrawnew/megatransfer',$data);
        }else{
            redirect('signout');
        }
    }

    public function bitcoin() {
       
       // if(!IPLoc::Office()) { show_404('accessing'); }
       
        
        if ($this->session->userdata('logged')) {

//            Remove restriction: FXPP-11626
//            if(IPLoc::isIPandLanguageChina()){
//                redirect(FXPP::loc_url('withdraw'));
//            }
            $this->load->helper('language');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

            /*if (!$this->session->userdata('login_type')) {
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
               // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            } else {
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/

            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;
            $data['disable_input'] = $user_status;
            $getTransactionFee = FXPP::getTransactionFee('BITCOIN', $account['currency']);

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];
            $data['processing_fee'] = FXPP::bitcoinToWalletCurrency($account['currency'],0.0002); // processing fee 
            $data['free_fee_max_amount']= FXPP::bitcoinToWalletCurrency($account['currency'],0.001); // minimum amount without fee

            if( $this->account_model->isMicro($this->session->userdata('user_id'))){
                $data['processing_fee'] = $data['processing_fee'] *100;
                $data['free_fee_max_amount'] = $data['free_fee_max_amount'] *100;
            }

            //$data['fee_details'] = ($getTransactionFee['fee'] * 100) . '%';

            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'% + '.number_format($getTransactionFee['addons']).' '.$account['currency'];

            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary information to withdraw via Bitcoin.';
            $this->template->title("ForexMart | Witdrawal Funds | Bitcoin")
                ->set_layout('internal/main')
                ->prepend_metadata("
                        <script src='" . $js . "jquery.autonumeric.js'></script>
                        <script src='" . $js . "bootbox.min.js'></script>
                        ")
                ->build('withdrawnew/bitcoin', $data);
        } else {
            redirect('signout');
        }
    }


    public function bitcoin_old(){

        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance();
            $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));

            $data['ndb_bonus']  = $this->getWithdrawBonusFee20($account['ndb_bonus']);

            $getTransactionFee = FXPP::getTransactionFee('BITCOIN', $account['mt_currency_base']);

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'%';

            //$user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
            if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                $user_status = true;
            }
            $data['disable_input'] = $user_status;
            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary information to withdraw via Bitcoin.';
            $this->template->title("ForexMart | Witdrawal Funds | Bitcoin")
                ->set_layout('internal/main')
                ->prepend_metadata("
                        <script src='" . $js . "jquery.autonumeric.js'></script>
                        <script src='" . $js . "bootbox.min.js'></script>
                        ")
                ->build('withdrawnew/bitcoin',$data);
        }else{
            redirect('signout');
        }
    }


    public function test(){
        $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
        $currency = $this->general_model->getAccountCurrencyBase($account['mt_currency_base']);

        $account_number = $account['account_number'];
        $balance = number_format($account['amount'],2);
        $input_value = $currency.' - '.$account_number.'['.$balance.']';
        $inputbox_account_details = '<input name="account_number" id="accountNumber" value="'.$input_value.'" class="form-control round-0" readonly data-balance="'.$balance.'" data-accountnumber="'.$account_number.'" data-currency="'.$currency.'" />';

        return $inputbox_account_details;
    }


    public function debit_credit_cards(){

        /*  if(!IPLoc::Office()){

        }*/

        if ($this->session->userdata('logged')) {
            
            
                 if(!FXPP::isPayomaPayMentAvailable('withdraw') ) {
                     redirect(FXPP::loc_url('withdraw')); //FXPP-13573
                 }
            

           
            $data['amount'] = $this->input->post('amount1',true);

            $this->template->title("ForexMart | Withdraw - Debit/Credit Cards")
                ->set_layout('internal/main')
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."deposit.css'>
                 ")

                ->build('withdrawnew/choose_debit_credit_cards', $data);
        } else {
            redirect('signout');
        }
    }

    public function bank_wire_transfer(){

        if ($this->session->userdata('logged')) {

//            if(!IPLoc::Office()){
//                FXPP::LoginTypeRestriction();
//            }
            $data['amount'] = $this->input->post('amount1',true);

            $this->template->title("ForexMart | Withdraw - Bank Transfer")
                ->set_layout('internal/main')
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."deposit.css'>
                 ")

                ->build('withdrawnew/choose_bank_transfer', $data);
        } else {
            redirect('signout');
        }
    }
    public function cardpay(){
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $user_id = $this->session->userdata('user_id');
            $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
            $data['login_type'] = $mtas3['login_type'];
            //            if(!IPLoc::Office()){
            //                $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance();
            //                $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
            //                $getNdbBonus  = $this->getWithdrawBonusFee20($account['ndb_bonus']);
            //                $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
            //                $getTransactionFee = FXPP::getTransactionFee('CREDIT CARD', $account['mt_currency_base']);
            //                $data['fee_details'] = round($getTransactionFee['addons'], 2).' '.$account['mt_currency_base'];
            //            }else{
            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);
          /*  if(!$this->session->userdata('login_type')){
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus =  $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
               // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));

                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            }else{
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/
            $getTransactionFee = FXPP::getTransactionFee('CREDIT CARD', $account['currency']);
            //            }

            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;
            $data['disable_input'] = $user_status;

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];


            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary details to process withdrawal request.';
            $this->template->title("ForexMart | Witdrawal Funds | Debit/Credit Cards")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/debit_credit_cards',$data);
        }else{
            redirect('signout');
        }
    }

    public function emerchantpay(){
        if(!IPLoc::Office()){die();}
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $user_id = $this->session->userdata('user_id');
            $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
            $data['login_type'] = $mtas3['login_type'];

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));

            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);
           /* if(!$this->session->userdata('login_type')){
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus =  $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
              //  $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            }else{
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/
            $getTransactionFee = FXPP::getTransactionFee('EMERCHANTPAY', $account['currency']);


            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;
            $data['disable_input'] = $user_status;

            $data['fee'] = isset($getTransactionFee['fee']) ? $getTransactionFee['fee']:0;
            $data['add_on'] = isset($getTransactionFee['addons'])?$getTransactionFee['addons']:0;

            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary details to process withdrawal request.';
            $this->template->title("ForexMart | Witdrawal Funds | eMerchant")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/e-merchantpay',$data);
        }else{
            redirect('signout');
        }
    }

    public function addEmerchantPay(){
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('card_number', 'Card Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('card_name', 'Cardholder\'s name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('card_expiry_month', 'Cardholder\'s name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('card_expiry_year', 'Cardholder\'s name', 'trim|required|xss_clean');

            if($this->form_validation->run()){

                $card_number = $this->input->post('card_number',true);
                $card_name = $this->input->post('card_name',true);
                $card_expiry_month = $this->input->post('card_expiry_month',true);
                $card_expiry_year = $this->input->post('card_expiry_year',true);

                $counterpartData = array(
                    'card_number' => $card_number,
                    'card_name' => $card_name,
                    'expire_month' => $card_expiry_month,
                    'expire_year' => $card_expiry_year
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'EMERCHANTPAY',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                }else{
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'success' => $isSuccess,
                            'transaction_data' => $transaction_data,
                            'errorMsg' => $errorMsg
                        )
                    )
                );

        }
    }

    public function megatransfer_card(){
        // if(!IPLoc::Office()){redirect('');}
        if($this->session->userdata('logged')) {
            redirect(FXPP::loc_url('withdraw'));
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $data['card'] = "megatransfer";
            //            if(!IPLoc::Office()){
            //                $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance();
            //                $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
            //                $getNdbBonus  = $this->getWithdrawBonusFee20($account['ndb_bonus']);
            //                $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
            //                $getTransactionFee = FXPP::getTransactionFee('CREDIT CARD', $account['mt_currency_base']);
            //                $data['fee_details'] = round($getTransactionFee['addons'], 2).' '.$account['mt_currency_base'];
            //            }else{
            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);
          /*  if(!$this->session->userdata('login_type')){
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus =  $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
               // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            }else{
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/
            $getTransactionFee = FXPP::getTransactionFee('MEGATRANSFER CARD', $account['currency']);
            //            }

            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;
            $data['disable_input'] = $user_status;

            $data['fee'] = $getTransactionFee['fee'];
            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'% + '.number_format($getTransactionFee['addons']).' '.$account['currency'];
            $data['add_on'] = $getTransactionFee['addons'];


            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary details to process withdrawal request.';
            $this->template->title("ForexMart | Witdrawal Funds | Debit/Credit Cards")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/debit_credit_cards_megatransfer',$data);
        }else{
            redirect('signout');
        }
    }

    public function unionpay(){
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $data['getAllAccountNumber'] = FXPP::selectAccountNumber($this->session->userdata('user_id'));
            $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
            $getTransactionFee = FXPP::getTransactionFee('UNIONPAY', $account['mt_currency_base']);
            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];
            // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
            if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                $user_status = true;
            }
            $data['disable_input'] = $user_status;
            $js = $this->template->Js();
            $this->template->title("ForexMart | Witdrawal Funds | UnionPay")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/unionpay',$data);
        }else{
            redirect('signout');
        }
    }

    public function webmoney(){

        if ($this->session->userdata('logged')) {
            redirect(FXPP::loc_url('withdraw'));
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

            /*if (!$this->session->userdata('login_type')) {
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            } else {
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/

            $getTransactionFee = FXPP::getTransactionFee('WEBMONEY', $account['currency']);

            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;
            $data['disable_input'] = $user_status;

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['fee_details'] = ($getTransactionFee['fee'] * 100) . '%';


            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary information to withdraw via Webmoney.';
            $this->template->title("ForexMart | Witdrawal Funds | Webmoney")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/webmoney', $data);


        } else {
            redirect('signout');
        }

    }


    public function moneta(){
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

            /*if(!$this->session->userdata('login_type')){
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            }else{
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/

            $getTransactionFee = FXPP::getTransactionFee('MONETA', $account['currency']);

            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;
            $data['disable_input'] = $user_status;

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'%';

            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary information to withdraw via Moneta.';
            $this->template->title("ForexMart | Witdrawal Funds | Moneta")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/moneta',$data);


        }else{
            redirect('signout');
        }
    }


    public function sofort_old(){
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

            /*if(!$this->session->userdata('login_type')){
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            }else{
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/

            $getTransactionFee = FXPP::getTransactionFee('SOFORT', $account['currency']);

            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;
            $data['disable_input'] = $user_status;

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'%';


            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary information to withdraw via Sofort.';
            $this->template->title("ForexMart | Witdrawal Funds | Sofort")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/sofort',$data);


        }else{
            redirect('signout');
        }
    }

    public function sofort(){
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

            /*if(!$this->session->userdata('login_type')){
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            }else{
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/

            $getTransactionFee = FXPP::getTransactionFee('SOFORT', $account['currency']);

            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;
            $data['disable_input'] = $user_status;

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'%';
            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(), FXPP::getUserCountryCode());
            $data['bank_min_withdrawal'] = $this->amountConverter(50, 'USD', $account['currency']);
            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary information to withdraw via Sofort.';
            $this->template->title("ForexMart | Witdrawal Funds | Sofort")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/sofort2',$data);


        }else{
            redirect('signout');
        }
    }



    public function addSofort(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_bankSofort', 'Beneficiary\'s Bank', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_addressSofort', 'Beneficiary\'s Address', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_swiftSofort', 'Beneficiary\'s bank SWIFT', 'trim|required|xss_clean');
            // $this->form_validation->set_rules('beneficiary_account', 'Beneficiary\'s Account', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ibanoraccount_numberSofort', 'IBAN Or Account number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bic_codeSofort', 'BIC Code', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_streetSofort', 'Street', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_citySofort', 'City', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_stateSofort', 'State', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_countrySofort', 'Country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_postalSofort', 'Postal Code', 'trim|required|xss_clean');

            if($this->form_validation->run()){

                $beneficiary_bank = $this->input->post('beneficiary_bankSofort',true);
                $beneficiary_address = $this->input->post('beneficiary_addressSofort',true);
                $beneficiary_swift = $this->input->post('beneficiary_swiftSofort',true);
                //$beneficiary_account = $this->input->post('beneficiary_account',true);
                $beneficiary_iban = $this->input->post('ibanoraccount_numberSofort',true);
                $beneficiary_biccode = $this->input->post('bic_codeSofort',true);
                $beneficiary_street = $this->input->post('beneficiary_streetSofort',true);
                $beneficiary_city= $this->input->post('beneficiary_citySofort',true);
                $beneficiary_state = $this->input->post('beneficiary_stateSofort',true);
                $beneficiary_country = $this->input->post('beneficiary_countrySofort',true);
                $beneficiary_postal = $this->input->post('beneficiary_postalSofort',true);

                $counterpartData = array(
                    'beneficiary_bank' => $beneficiary_bank,
                    'beneficiary_address' => $beneficiary_address,
                    'beneficiary_swift' => $beneficiary_swift,
                    //'beneficiary_account' => $beneficiary_account,
                    'ibanoraccount_number' =>  $beneficiary_iban,
                    'bic_code' => $beneficiary_biccode,
                    'beneficiary_street' => $beneficiary_street,
                    'beneficiary_city' => $beneficiary_city,
                    'beneficiary_state' => $beneficiary_state,
                    'beneficiary_country' => $beneficiary_country,
                    'beneficiary_postal' => $beneficiary_postal
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'SOFORT',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);
                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                }else{
                    $isSuccess = false;

                    if(IPLoc::IPCrpAccVerify()){
                        $errorMsg = 'error in API';
                    } else{
                        $errorMsg = $withdrawalProcess['errorMsg'];
                    }
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );
        }
    }





    public function paxum(){
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';

            $user_id = $this->session->userdata('user_id');
            $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
            $data['login_type'] = $mtas3['login_type'];
            //            if(!IPLoc::Office()){
            //
            //                $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance();
            //                $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
            //                $getNdbBonus  = $this->getWithdrawBonusFee20($account['ndb_bonus']);
            //                $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
            //                $getTransactionFee = FXPP::getTransactionFee('PAXUM', $account['mt_currency_base']);
            //            }else{
            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

           /* if(!$this->session->userdata('login_type')){
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            }else{
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/

            $getTransactionFee = FXPP::getTransactionFee('PAXUM', $account['currency']);
            //            }


            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;
            $data['disable_input'] = $user_status;

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'%';

            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary information to withdraw via Paxum.';
            $this->template->title("ForexMart | Witdrawal Funds | Paxum")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/paxum',$data);
        }else{
            redirect('signout');
        }
    }

    public function ukash(){
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $data['getAllAccountNumber'] = FXPP::selectAccountNumber($this->session->userdata('user_id'));
            $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
            $getTransactionFee = FXPP::getTransactionFee('UKASH', $account['mt_currency_base']);
            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];
            // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
            if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                $user_status = true;
            }
            $data['disable_input'] = $user_status;
            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary information to withdraw via Ukash.';
            $this->template->title("ForexMart | Witdrawal Funds | Ukash")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/ukash',$data);
        }else{
            redirect('signout');
        }
    }

    public function payco(){
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            $this->load->model(array('partners_model','user_model'));
            //            $this->lang->load('depositwithdraw');
            $user_id = $this->session->userdata('user_id');
            $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
            $data['login_type'] = $mtas3['login_type'];
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';

            /*if(!IPLoc::Office()){
                $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance();
                $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus  = $this->getWithdrawBonusFee20($account['ndb_bonus']);
                $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                $getTransactionFee = FXPP::getTransactionFee('PAYCO', $account['mt_currency_base']);
            }else{*/
            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

            if(!$this->session->userdata('login_type')){
                $data['transit'] = '';
                $data['normal'] = 'active';
            }else{
                $its = $this->general_model->showssingle('internal_transfer','user_id',$this->session->userdata('user_id'),'*');
                $data['its'] = $its;
                if ($its) {
                    $data['transit'] = 'active';
                    $data['normal'] = '';
                    $data['its'] = $its;
                } else {
                    $data['transit'] = '';
                    $data['normal'] = 'active';
                }
            }

            $getTransactionFee = FXPP::getTransactionFee('PAYCO', $account['currency']);


            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;
            $data['disable_input'] = $user_status;

            //}

            // Internal Transit Service
            $data['mpr'] = $this->general_model->showssingle('manage_payco_registration','user_id',$this->session->userdata('user_id'),'*');
            $data['its_activated'] = $this->partners_model->getPartnerActivatedITSClients($this->session->userdata('user_id'));
            $data['partner_wallet'] = $this->partners_model->getTTPaycoWallet($this->session->userdata('user_id'))['wallet_number'];
            $referrals = $this->partners_model->getPartnerReferralsByPartnerID($this->session->userdata('user_id'));

            foreach ($referrals as $key => $value) {
                $check_mpr = $this->partners_model->getITSRegisteredPayCoAccountByUserId($value['users_id']);

                /*echo '<pre>';
                print_r($referrals);
                echo '</pre>';exit;*/

                if ($check_mpr) {
                    $data['referral_acc_num'][] = array(
                        'account_number'    =>  $value['account_number'],
                        'c_wallet_number'   =>  $this->partners_model->getTTPaycoWallet($value['users_id'])['wallet_number'],
                    );
                }
            }



            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'%';

            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary information to withdraw via PayCo.';
            $this->template->title("ForexMart | Witdrawal Funds | PayCo")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/payco',$data);
        }else{
            redirect('signout');
        }
    }

    public function filspay(){
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
            $getTransactionFee = FXPP::getTransactionFee('FILSPAY', $account['mt_currency_base']);
            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];
            // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
            if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                $user_status = true;
            }
            $data['disable_input'] = $user_status;
            $data['getAllAccountNumber'] = FXPP::selectAccountNumber($this->session->userdata('user_id'));
            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary information to withdraw via FilsPay.';
            $this->template->title("ForexMart | Witdrawal Funds | FILSPay")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/filspay',$data);
        }else{
            redirect('signout');
        }
    }

    public function cashu(){
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance();
            $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
            $getTransactionFee = FXPP::getTransactionFee('CASHU', $account['mt_currency_base']);
            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];
            // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
            if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                $user_status = true;
            }
            $data['disable_input'] = $user_status;
            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary information to withdraw via CashU.';
            $this->template->title("ForexMart | Witdrawal Funds | CashU")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/cashu',$data);
        }else{
            redirect('signout');
        }
    }

    public function paypal(){
        if($this->session->userdata('logged')) {
            redirect(FXPP::loc_url('withdraw')); //FXPP-9351

            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $user_id = $this->session->userdata('user_id');
            $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
            $data['login_type'] = $mtas3['login_type'];
            //            if(!IPLoc::Office()){
            //                $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance();
            //                $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
            //                $getNdbBonus = $this->getWithdrawBonusFee20($account['ndb_bonus']);
            //                $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
            //                $getTransactionFee = FXPP::getTransactionFee('PAYPAL', $account['mt_currency_base']);
            //
            //                $data['fee_details'] = ($getTransactionFee['fee'] * 100).'% + '.$getTransactionFee['addons'].' '.$account['mt_currency_base'];
            //            }else{
            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

           /* if(!$this->session->userdata('login_type')){
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            }else{
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/

            $getTransactionFee = FXPP::getTransactionFee('PAYPAL', $account['currency']);
            if($account['currency'] == 'RUB'){
                $account['currency'] = 'RUR';
            }
            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'% + '.$getTransactionFee['addons'].' '.$account['currency'];
            //            }


            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;
            $data['disable_input'] = $user_status;

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];



            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary information to withdraw via PayPal.';
            $this->template->title("ForextMart | Witdrawal Funds | Paypal")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/paypal',$data);
        }else{
            redirect('signout');
        }
    }

    public function addYandex(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('yandex_wallet', 'Yandex wallet', 'trim|required|xss_clean');

            if($this->form_validation->run()){

                $counterpartData = array(
                    'yandex_wallet' => $this->input->post('yandex_wallet',true)
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'YANDEXMONEY',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                }else{
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );
        }
    }

    public function addBankTransfer(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_bank', 'Beneficiary\'s Bank', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_address', 'Beneficiary\'s Address', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_swift', 'Beneficiary\'s bank SWIFT', 'trim|required|xss_clean');
            // $this->form_validation->set_rules('beneficiary_account', 'Beneficiary\'s Account', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ibanoraccount_number', 'IBAN Or Account number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bic_code', 'BIC Code', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_street', 'Street', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_city', 'City', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_state', 'State', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_country', 'Country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_postal', 'Postal Code', 'trim|required|xss_clean');

            if($this->form_validation->run()){

                $beneficiary_bank = $this->input->post('beneficiary_bank',true);
                $beneficiary_address = $this->input->post('beneficiary_address',true);
                $beneficiary_swift = $this->input->post('beneficiary_swift',true);
                //$beneficiary_account = $this->input->post('beneficiary_account',true);
                $beneficiary_iban = $this->input->post('ibanoraccount_number',true);
                $beneficiary_biccode = $this->input->post('bic_code',true);
                $beneficiary_street = $this->input->post('beneficiary_street',true);
                $beneficiary_city= $this->input->post('beneficiary_city',true);
                $beneficiary_state = $this->input->post('beneficiary_state',true);
                $beneficiary_country = $this->input->post('beneficiary_country',true);
                $beneficiary_postal = $this->input->post('beneficiary_postal',true);

                $counterpartData = array(
                    'beneficiary_bank' => $beneficiary_bank,
                    'beneficiary_address' => $beneficiary_address,
                    'beneficiary_swift' => $beneficiary_swift,
                    //'beneficiary_account' => $beneficiary_account,
                    'ibanoraccount_number' =>  $beneficiary_iban,
                    'bic_code' => $beneficiary_biccode,
                    'beneficiary_street' => $beneficiary_street,
                    'beneficiary_city' => $beneficiary_city,
                    'beneficiary_state' => $beneficiary_state,
                    'beneficiary_country' => $beneficiary_country,
                    'beneficiary_postal' => $beneficiary_postal
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'BANK TRANSFER',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);
                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                }else{
                    $isSuccess = false;

                    if(IPLoc::IPCrpAccVerify()){
                        $errorMsg = 'error in API';
                    } else{
                        $errorMsg = $withdrawalProcess['errorMsg'];
                    }
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );
        }
    }

    public function testW(){
        $full_name = $this->session->userdata('full_name');
        $clientEmail = $this->session->userdata('email');

        var_dump($full_name.' - '.$clientEmail);
        exit;


        $transactionType = 'BANK TRANSFER';
        $getTransactionFee = FXPP::getTransactionFee(5.19, $transactionType);
        var_dump($getTransactionFee);

    }

    public function addNeteller(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('neteller_id', 'Neteller ID', 'trim|required|xss_clean');

            if($this->form_validation->run()){

                $counterpartData = array(
                    'neteller_id' => $this->input->post('neteller_id',true)
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'NETELLER',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                }else{
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );
        }
    }

    public function addSkrill(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('skrill_account', 'Skrill account', 'trim|required|xss_clean');

            if($this->form_validation->run()) {

                $counterpartData = array(
                    'skrill_account' => $this->input->post('skrill_account',true)
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'SKRILL',
                    'counterpart' => $counterpartData,
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                }else{
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg,
                    )
                )
            );
        }
    }

    public function addQiwi(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('qiwi_id', 'Qiwi Id', 'trim|required|xss_clean');

            if($this->form_validation->run()) {

                $counterpartData = array(
                    'inv_number' => $this->input->post('qiwi_id',true)
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'QIWI',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                }else{
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );
        }
    }

    public function addMegatransfer(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('megatransfer_username', 'MegaTransfer username', 'trim|required|xss_clean');

            if($this->form_validation->run()) {

                $counterpartData = array(
                    'username' => $this->input->post('megatransfer_username',true)
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'MEGATRANSFER',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                }else{
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );
        }
    }

    public function addMegatransferCard(){
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('card_number', 'Card Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('card_name', 'Cardholder\'s name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('card_expiry_month', 'Cardholder\'s name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('card_expiry_year', 'Cardholder\'s name', 'trim|required|xss_clean');

            if($this->form_validation->run()){

                $card_number = $this->input->post('card_number',true);
                $card_name = $this->input->post('card_name',true);
                $card_expiry_month = $this->input->post('card_expiry_month',true);
                $card_expiry_year = $this->input->post('card_expiry_year',true);

                $counterpartData = array(
                    'card_number' => $card_number,
                    'card_name' => $card_name,
                    'card_expiry_month' => $card_expiry_month,
                    'card_expiry_year' => $card_expiry_year
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'MEGATRANSFER CARD',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                    $transaction_data['card_expiry_month'] = date('F', mktime(0, 0, 0, $card_expiry_month, 10)); // $card_expiry_month;
                    $transaction_data['card_expiry_year'] = $card_expiry_year;
                    $transaction_data['cardName'] = $card_name;
                }else{
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );

        }
    }
    public function addBitcoin(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('bitcoin_address', 'Bitcoin address', 'trim|required|xss_clean');

            if($this->form_validation->run()) {

                $counterpartData = array(
                    'username' => $this->input->post('bitcoin_address',true)
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'BITCOIN',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                }else{
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );
        }
    }

    public function addPaypal(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('paypal_account', 'Paypal account', 'trim|required|xss_clean');

            if($this->form_validation->run()){

                $counterpartData = array(
                    'paypal_account' => $this->input->post('paypal_account',true)
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'PAYPAL',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                }else{
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );
        }
    }

    public function test_validate(){
        $getAccountnumber = $this->account_model->getAccountsByUserId($this->session->userdata('user_id'));
        $webservice_config = array('server' => 'live_new');
//        $WebService2 = new WebService($webservice_config);
//        $WebService2->RequestAccountFunds($getAccountnumber[0]['account_number']);
//        $getTotalRealFund = $WebService2->get_result('TotalRealFund');
//        $getTotalBonusFund = $WebService2->get_result('TotalBonusFund');
//        $getEquity = $WebService2->get_result('Equity');

        if(IPLoc::APIUpgradeDevIP()){

            $this->load->library('WSV'); //New web service
            $WSV = new WSV();
            $WebService2 = $WSV->GetAccountFunds($getAccountnumber);

            if($WebService2->request_status === "RET_OK"){
                $getTotalRealFund  = $WebService2->result['TotalRealFund'];
                $getTotalBonusFund = $WebService2->result['TotalBonusFund'];
                $getEquity         = $WebService2->result['Equity'];
            }

        }else{

            $WebService2= new WebService($webservice_config);
            $WebService2->RequestAccountFunds($getAccountnumber);

            $getTotalRealFund  = $WebService2->get_result('TotalRealFund');
            $getTotalBonusFund = $WebService2->get_result('TotalBonusFund');
            $getEquity         = $WebService2->get_result('Equity');

        }

        var_dump($getEquity);
    }

    public function validateFunds($amountRequested){
        $getAccountnumber = $this->account_model->getAccountsByUserId($this->session->userdata('user_id'));

        $webservice_config = array('server' => 'live_new');
//        $WebService2 = new WebService($webservice_config);
//        $WebService2->RequestAccountFunds($getAccountnumber[0]['account_number']);
//        $getWithdrawableRealFund = $WebService2->get_result('Withrawable_RealFund');
//        $getWithdrawableBonusFund = $WebService2->get_result('Withrawable_BonusFund');

        if(IPLoc::APIUpgradeDevIP()){

            $this->load->library('WSV'); //New web service
            $WSV = new WSV();
            $WebService2 = $WSV->GetAccountFunds($getAccountnumber[0]['account_number']);

            if($WebService2->request_status === "RET_OK"){
                $getWithdrawableRealFund  = $WebService2->result['Withrawable_RealFund'];
                $getWithdrawableBonusFund = $WebService2->result['Withrawable_BonusFund'];
            }

        }else{

            $WebService2= new WebService($webservice_config);
            $WebService2->RequestAccountFunds($getAccountnumber[0]['account_number']);

            $getWithdrawableRealFund  = $WebService2->get_result('Withrawable_RealFund');
            $getWithdrawableBonusFund = $WebService2->get_result('Withrawable_BonusFund');

        }

        $addRealandBonus = $getWithdrawableRealFund + $getWithdrawableBonusFund;
        if($addRealandBonus >= $amountRequested){
            if($getWithdrawableBonusFund > 0){
                $equity = $WebService2->get_result('Equity');
                $margin = $WebService2->get_result('Margin');
                $withdrawableAmount = $equity - $margin - $getWithdrawableBonusFund - (0.20 * $getWithdrawableBonusFund);
                if($getWithdrawableRealFund >= $withdrawableAmount){
                    return true;
                }else{
                    $this->form_validation->set_message('validateFunds', 'Your account balance contains bonus funds of '.$getWithdrawableBonusFund.'. To withdraw bonuses, you have to send a request to bonuses@forexmart.com.');
                    return false;
                }

            }else{
                return true;
            }

        }else{
            $this->form_validation->set_message('validateFunds', 'Insufficient Fund.');
            return false;
        }

    }

    public function addDebitCredit(){
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('card_number', 'Card Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('card_name', 'Cardholder\'s name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('card_expiry_month', 'Cardholder\'s name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('card_expiry_year', 'Cardholder\'s name', 'trim|required|xss_clean');

            if($this->form_validation->run()){

                $card_number = $this->input->post('card_number',true);
                $card_name = $this->input->post('card_name',true);
                $card_expiry_month = $this->input->post('card_expiry_month',true);
                $card_expiry_year = $this->input->post('card_expiry_year',true);
                $card_opt = $this->input->post('card_opt',true);

                if($card_opt == 'zp'){
                    $withdrawal_type = 'ZOTAPAY_CARD';
                }else if($card_opt == 'np'){
                    $withdrawal_type = 'NOVA2PAY';
                }else{
                    $withdrawal_type = 'CREDIT CARD';
                }

                $counterpartData = array(
                    'card_number' => $card_number,
                    'card_name' => $card_name,
                    'card_expiry_month' => $card_expiry_month,
                    'card_expiry_year' => $card_expiry_year
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => $withdrawal_type,
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                }else{
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );

        }
    }

    public function addUnionpay(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_name', 'Amount to withdraw', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_account', 'Amount to withdraw', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_name', 'Amount to withdraw', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_branch', 'Amount to withdraw', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_province', 'Amount to withdraw', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_city', 'Amount to withdraw', 'trim|required|xss_clean');
            $isValidationError = true;
            if($this->form_validation->run()) {
                $account_number = $this->input->post('account_number',true);
                $amount_withdraw = $this->input->post('amount_withdraw',true);

                $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getTransactionFee = FXPP::getTransactionFee('UNIONPAY', $account['mt_currency_base']);
                $fee = $getTransactionFee['fee'];

                $amount_deducted = $amount_withdraw * $fee;
                $amount_receive = number_format($amount_withdraw + $amount_deducted, 2, '.', '');
                $beneficiary_name = $this->input->post('beneficiary_name',true);
                $bank_account = $this->input->post('bank_account',true);
                $bank_name = $this->input->post('bank_name',true);
                $bank_branch = $this->input->post('bank_branch',true);
                $bank_province = $this->input->post('bank_province',true);
                $bank_city = $this->input->post('bank_city',true);
                $user_id = $this->session->userdata('user_id');
                $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
                $new_date = new DateTime();
                $data = array(
                    'beneficiary_name' => $beneficiary_name,
                    'bank_account' => $bank_account,
                    'bank_name' => $bank_name,
                    'bank_branch' => $bank_branch,
                    'bank_province' => $bank_province,
                    'bank_city' => $bank_city
                );
                $transaction_id = $this->withdraw_model->insertWithdrawByTranType($this->transaction_type['UNIONPAY'], $data);
                if($transaction_id !== false){
                    $withdraw_data = array(
                        'account_number' => $account_number,
                        'user_id' => $user_id,
                        'date_withdraw' => $date,
                        'currency' => 'USD',
                        'reference_number' => $new_date->getTimestamp(),
                        'transaction_type' => $this->transaction_type['UNIONPAY'],
                        'amount' => $amount_withdraw,
                        'amount_deducted' => $amount_receive,
                        'status' => 0,
                        'transaction_id' => $transaction_id,
                        'fee' => $this->percent_deduction
                    );

                    $withdraw_id = $this->withdraw_model->insertWithdraw($withdraw_data);

                    $unionpay_data = $this->withdraw_model->getWithdrawById($withdraw_id, $this->transaction_type['UNIONPAY']);
                    if($unionpay_data !== false){
                        $transaction_data = array(
                            'amount_withdraw' => $unionpay_data['amount'],
                            'account_number' => $unionpay_data['account_number'],
                            'bank_account' => $unionpay_data['bank_account'],
                            'amount_receive' => $unionpay_data['amount_deducted'],
                            'transaction_number' => $unionpay_data['reference_number'],
                            'fee' => number_format($amount_withdraw * $fee, 2)
                        );
                        $isInsert = true;
                    }else{
                        $isInsert = false;
                    }
                }else{
                    $isInsert = false;
                }
            }else{
                $isValidationError = false;
                $transaction_data = array();
                $error = array(
                    'account_number' => form_error('account_number'),
                    'amount_withdraw' => form_error('amount_withdraw'),
                    'card_number' => form_error('card_number')
                );
                $isInsert = false;
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isInsert, 'transaction_data' => $transaction_data, 'error' => $error, 'validation_error' => $isValidationError, 'amounts' => array($amount_withdraw, $amount_deducted, $amount_receive))));
        }
    }

    public function addWebmoney(){


        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('webmoney_email', 'Email address', 'trim|required|xss_clean|valid_email');
            $this->form_validation->set_rules('webmoney_purse', 'WebMoney Purse', 'trim|required|xss_clean');

            if ($this->form_validation->run()) {

                $counterpartData = array(
                    'webmoney_purse' => $this->input->post('webmoney_purse', true),
                    'email_address' => $this->input->post('webmoney_email', true)
                );

                $withdrawalData = array(
                    'user_id'         => $this->session->userdata('user_id'),
                    'amount'          => $this->input->post('amount_withdraw', true),
                    'withdrawal_type' => 'WEBMONEY',
                    'counterpart'     => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if (!$withdrawalProcess['error']) {
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                } else {
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }

            } else {
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success'          => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg'         => $errorMsg
                    )
                )
            );
        }
    }


    public function addMoneta(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('moneta_account', 'Moneta Account', 'trim|required|xss_clean');



            if($this->form_validation->run()){

                $counterpartData = array(
                    'moneta_account' => $this->input->post('moneta_account',true)
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'MONETA',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                }else{
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );
        }
    }


    public function addSofort_old(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('sofort_account', 'Sofort Account', 'trim|required|xss_clean');



            if($this->form_validation->run()){

                $counterpartData = array(
                    'sofort_account' => $this->input->post('sofort_account',true)
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'SOFORT',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                }else{
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );
        }
    }



    public function addPaxum(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('paxum_id', 'Paxum Account ID', 'trim|required|xss_clean');

            if($this->form_validation->run()){

                $counterpartData = array(
                    'paxum_id' => $this->input->post('paxum_id',true)
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'PAXUM',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                }else{
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );
        }
    }

    public function addUkash(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('ukash_account', 'Ukash Account number', 'trim|required|xss_clean');
            $isValidationError = true;
            if($this->form_validation->run()) {
                $account_number = $this->input->post('account_number',true);
                $amount_withdraw = $this->input->post('amount_withdraw',true);

                $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getTransactionFee = FXPP::getTransactionFee('UKASH', $account['mt_currency_base']);
                $fee = $getTransactionFee['fee'];

                $amount_deducted = number_format($amount_withdraw + ($amount_withdraw * $fee), 2, '.', '');
                $ukash_account = $this->input->post('ukash_account',true);
                $user_id = $this->session->userdata('user_id');
                $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
                $new_date = new DateTime();
                $data = array(
                    'ukash_account' => $ukash_account
                );
                $transaction_id = $this->withdraw_model->insertWithdrawByTranType($this->transaction_type['UKASH'], $data);
                if($transaction_id !== false){
                    $withdraw_data = array(
                        'account_number' => $account_number,
                        'user_id' => $user_id,
                        'date_withdraw' => $date,
                        'currency' => 'USD',
                        'reference_number' => $new_date->getTimestamp(),
                        'transaction_type' => $this->transaction_type['UKASH'],
                        'amount' => $amount_withdraw,
                        'amount_deducted' => $amount_deducted,
                        'status' => 0,
                        'transaction_id' => $transaction_id,
                        'fee' => $this->percent_deduction
                    );

                    $withdraw_id = $this->withdraw_model->insertWithdraw($withdraw_data);

                    $ukash_data = $this->withdraw_model->getWithdrawById($withdraw_id, $this->transaction_type['UKASH']);
                    if($ukash_data !== false){
                        $transaction_data = array(
                            'amount_requested' => $ukash_data['amount'],
                            'account_number' => $ukash_data['account_number'],
                            'ukash_account' => $ukash_data['ukash_account'],
                            'transaction_number' => $ukash_data['reference_number'],
                            'fee' => number_format($amount_withdraw * $fee, 2)
                        );
                        $isInsert = true;
                    }else{
                        $isInsert = false;
                    }
                }else{
                    $isInsert = false;
                }
            }else{
                $isValidationError = false;
                $transaction_data = array();
                $error = array(
                    'account_number' => form_error('account_number'),
                    'amount_withdraw' => form_error('amount_withdraw'),
                    'ukash_account' => form_error('ukash_account')
                );
                $isInsert = false;
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isInsert, 'transaction_data' => $transaction_data, 'error' => $error, 'validation_error' => $isValidationError)));
        }
    }

    public function addPayCo(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('payco_wallet', 'PayCo Wallet', 'trim|required|xss_clean');

            if($this->form_validation->run()) {

                $counterpartData = array(
                    'wallet' => $this->input->post('payco_wallet',true)
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'PAYCO',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                }else{
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );
        }
    }

    public function addPayCoTransit(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_transfer', 'Amount to transfer', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('partner_wallet', 'Partner PayCo Wallet', 'trim|required|xss_clean');
            $this->form_validation->set_rules('client_wallet', 'Client PayCo Wallet', 'trim|required|xss_clean');

            if ($this->session->userdata('user_id') == 60247) {
                if($this->form_validation->run()) {

                    $transit_data = array(
                        'partner_account_number' => $this->input->post('partner_wallet'),
                        'client_account_number' => $this->input->post('client_wallet'),
                        'status' => 0, // 0 = request for withdraw, 1 = declined, 2 = approved
                        'note' => 'withdraw request'
                    );
                    $transit_id = $this->general_model->insert('transit_transfer', $transit_data);

                    $counterpartData = array(
                        'wallet' => $this->input->post('partner_wallet'),
                        'transit_id' => $transit_id
                    );

                    $withdrawalData = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'amount' => $this->input->post('amount_transfer'),
                        'withdrawal_type' => 'PAYCO',
                        'counterpart' => $counterpartData
                    );

                    $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                    if(!$withdrawalProcess['error']){
                        $isSuccess = true;
                        $transaction_data = $withdrawalProcess['transaction_data'];
                    }else{
                        $isSuccess = false;
                        $errorMsg = $withdrawalProcess['errorMsg'];
                    }

                }else{
                    $errorMsg = 'Your withdrawal request failed.';
                    $isSuccess = false;
                }
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );
        }
    }

    public function addFilsPay(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('filspay_number', 'FILSPay number', 'trim|required|xss_clean');
            $isValidationError = true;
            if($this->form_validation->run()) {
                $account_number = $this->input->post('account_number',true);
                $amount_withdraw = $this->input->post('amount_withdraw',true);

                $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getTransactionFee = FXPP::getTransactionFee('FILSPAY', $account['mt_currency_base']);
                $fee = $getTransactionFee['fee'];

                $amount_deducted = number_format($amount_withdraw + ($amount_withdraw * $fee), 2, '.', '');
                $filspay_number = $this->input->post('filspay_number',true);
                $user_id = $this->session->userdata('user_id');
                $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
                $new_date = new DateTime();
                $data = array(
                    'filspay_number' => $filspay_number
                );
                $transaction_id = $this->withdraw_model->insertWithdrawByTranType($this->transaction_type['FILSPAY'], $data);
                if($transaction_id !== false){
                    $withdraw_data = array(
                        'account_number' => $account_number,
                        'user_id' => $user_id,
                        'date_withdraw' => $date,
                        'currency' => 'USD',
                        'reference_number' => $new_date->getTimestamp(),
                        'transaction_type' => $this->transaction_type['FILSPAY'],
                        'amount' => $amount_withdraw,
                        'amount_deducted' => $amount_deducted,
                        'status' => 0,
                        'transaction_id' => $transaction_id,
                        'fee' => $this->percent_deduction
                    );

                    $withdraw_id = $this->withdraw_model->insertWithdraw($withdraw_data);

                    $filspay_data = $this->withdraw_model->getWithdrawById($withdraw_id, $this->transaction_type['FILSPAY']);
                    if($filspay_data !== false){
                        $transaction_data = array(
                            'amount_requested' => $filspay_data['amount'],
                            'account_number' => $filspay_data['account_number'],
                            'filspay_number' => $filspay_data['filspay_number'],
                            'transaction_number' => $filspay_data['reference_number'],
                            'fee' => number_format($amount_withdraw * $fee, 2)
                        );
                        $isInsert = true;
                    }else{
                        $isInsert = false;
                    }
                }else{
                    $isInsert = false;
                }
            }else{
                $isValidationError = false;
                $transaction_data = array();
                $error = array(
                    'account_number' => form_error('account_number'),
                    'amount_withdraw' => form_error('amount_withdraw'),
                    'filspay_number' => form_error('filspay_number')
                );
                $isInsert = false;
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isInsert, 'transaction_data' => $transaction_data, 'error' => $error, 'validation_error' => $isValidationError)));
        }
    }

    public function addCashU(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('cashu_account', 'CashU Account', 'trim|required|xss_clean');
            $isValidationError = true;
            if($this->form_validation->run()) {
                $account_number = $this->input->post('account_number',true);
                $amount_withdraw = $this->input->post('amount_withdraw',true);

                $account = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getTransactionFee = FXPP::getTransactionFee('CASHU', $account['mt_currency_base']);
                $fee = $getTransactionFee['fee'];

                $amount_deducted = number_format($amount_withdraw + ($amount_withdraw * $fee), 2, '.', '');
                $cashu_account = $this->input->post('cashu_account',true);
                $user_id = $this->session->userdata('user_id');
                $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
                $new_date = new DateTime();
                $data = array(
                    'cashu_account' => $cashu_account
                );
                $transaction_id = $this->withdraw_model->insertWithdrawByTranType($this->transaction_type['CASHU'], $data);
                if($transaction_id !== false){
                    $withdraw_data = array(
                        'account_number' => $account_number,
                        'user_id' => $user_id,
                        'date_withdraw' => $date,
                        'currency' => 'USD',
                        'reference_number' => $new_date->getTimestamp(),
                        'transaction_type' => $this->transaction_type['CASHU'],
                        'amount' => $amount_withdraw,
                        'amount_deducted' => $amount_deducted,
                        'status' => 0,
                        'transaction_id' => $transaction_id,
                        'fee' => $this->percent_deduction
                    );

                    $withdraw_id = $this->withdraw_model->insertWithdraw($withdraw_data);

                    $cashu_data = $this->withdraw_model->getWithdrawById($withdraw_id, $this->transaction_type['CASHU']);
                    if($cashu_data !== false){
                        $transaction_data = array(
                            'amount_requested' => $cashu_data['amount'],
                            'account_number' => $cashu_data['account_number'],
                            'cashu_account' => $cashu_data['cashu_account'],
                            'transaction_number' => $cashu_data['reference_number'],
                            'fee' => number_format($amount_withdraw * $fee, 2)
                        );
                        $isInsert = true;
                    }else{
                        $isInsert = false;
                    }
                }else{
                    $isInsert = false;
                }
            }else{
                $isValidationError = false;
                $transaction_data = array();
                $error = array(
                    'account_number' => form_error('account_number'),
                    'amount_withdraw' => form_error('amount_withdraw'),
                    'cashu_account' => form_error('cashu_account')
                );
                $isInsert = false;
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isInsert, 'transaction_data' => $transaction_data, 'error' => $error, 'validation_error' => $isValidationError)));
        }
    }

    public function getWithdrawBonusFee20($ndb_bonus){ // no longer use
        if($ndb_bonus > 0){

            //  return $ndb_bonus;
            return 0;
        }
        return 0;
    }

    public function getWithdrawableAmount(){

        $getAccountnumber = $this->account_model->getAccountsByUserId($this->session->userdata('user_id'));
        $webservice_config = array('server' => 'live_new');
//        $WebService2 = new WebService($webservice_config);
//        $WebService2->RequestAccountFunds($getAccountnumber[0]['account_number']);
//
//        $getWithdrawableBonusFund = $WebService2->get_result('Withrawable_BonusFund');
//        $equity = $WebService2->get_result('Equity');
//        $margin = $WebService2->get_result('Margin');

        if(IPLoc::APIUpgradeDevIP()){

            $this->load->library('WSV'); //New web service
            $WSV = new WSV();
            $WebService2 = $WSV->GetAccountFunds($getAccountnumber[0]['account_number']);

            if($WebService2->request_status === "RET_OK"){
                $getWithdrawableBonusFund = $WebService2->result['Withrawable_BonusFund'];
                $equity = $WebService2->result['Equity'];
                $margin = $WebService2->result['Margin'];
            }

        }else{

            $WebService2= new WebService($webservice_config);
            $WebService2->RequestAccountFunds($getAccountnumber[0]['account_number']);

            $getWithdrawableBonusFund = $WebService2->get_result('Withrawable_BonusFund');
            $equity = $WebService2->get_result('Equity');
            $margin = $WebService2->get_result('Margin');

        }

        $withdrawableAmount = 0;
        if($equity > 0){
            $withdrawableAmount = $equity - $margin - $getWithdrawableBonusFund - (0.20 * $getWithdrawableBonusFund);
        }

        return $withdrawableAmount;

    }


    
    
    public function validateAccountFundv2($requestData){
        $this->lang->load('modal_message',$this->session->userdata('site_lang')); // Please do not remove.

        $fundsData = FXPP::getAccountFunds($requestData['account_number']);

        $user_id       = $requestData['user_id'];
        $totalAmount   = (float) $requestData['totalAmount'];
        $feePlusAddons = $requestData['totalFee'];
        $feesOnly      = $requestData['fee'];
        $addonsOnly    = $requestData['addons'];

        $returnData = array(
            'error' => true,
            'errorMsg' => lang('m_wth_02'),
        );


        $fundsDetails = array(
            'getWithdrawableRealFund' => $fundsData['withrawableRealFund'],
            'equity' => $fundsData['equity'],
            'margin' => $fundsData['margin'],
            'totalfee' => $feePlusAddons,
            'feesOnly' => $feesOnly,
            'addonsOnly' => $addonsOnly,
            'amount' => $totalAmount
        );

        if($requestData['amountRequested'] <= 0 ){
            $returnData['errorMsg'] = 'Invalid amount. Please request an amount greater than zero.';
            $returnData['detailsfunds'] = $fundsDetails;
            return $returnData;

        }

        $bonusType = FXPP::getAccountBonusByType($requestData['account_number']);
        
        
       
            
         $totalContestBonus =0;
        //$totalContestBonus = $bonusType[7] + $bonusType[12];  // contest FM bonus | contest prize bonus
        
            if(isset($bonusType[7])){
                 $totalContestBonus = $bonusType[7] ;
            }
            
             if(isset($bonusType[12])){
                 $totalContestBonus = $totalContestBonus+$bonusType[12] ;
            }
        
            

        if($totalContestBonus > 0){
            if($totalAmount > $totalContestBonus){
                $returnData['errorMsg'] = lang('m_wth_01');
                $returnData['detailsfunds'] = $fundsDetails;
                return $returnData;
            }
        }


        
//         if(IPLoc::frz(true))
//        {
//            echo "<pre>";
//            print_r($fundsData);
//            echo "<br>";
//            echo $totalAmount."==============>".$fundsData['withrawableRealFund'];exit;
//        } 
//        
        

        if($totalAmount > $fundsData['withrawableRealFund']){
            $returnData['detailsfunds'] = $fundsDetails;
            $returnData['errorMsg']  = lang('m_wth_03') . $fundsData['withrawableRealFund'].' '.$requestData['currency']. lang('m_wth_04');
            return $returnData;

        }




        $returnData['error'] = false;
        $returnData['errorMsg'] = 'success';
        $returnData['amountProcess'] = $totalAmount;
        return $returnData;


    }

    public function validateAccountFund($requestData){
        $this->lang->load('modal_message',$this->session->userdata('site_lang')); // Please do not remove.

        $webservice_config = array('server' => 'live_new');
//        $WebService2 = new WebService($webservice_config);
//        $WebService2->RequestAccountFunds($requestData['account_number']);

        if(IPLoc::APIUpgradeDevIP()){

            $this->load->library('WSV'); //New web service
            $WSV = new WSV();
            $WebService2 = $WSV->GetAccountFunds($requestData['account_number']);

            if($WebService2->request_status === "RET_OK"){
                $getWithdrawableRealFund  = $WebService2->result['Withrawable_RealFund'];
                $Withrawable_BonusFund    = $WebService2->result['Withrawable_BonusFund'];
                $TotalRealFund            = $WebService2->result['TotalRealFund'];
                $equity                   = $WebService2->result['Equity'];
                $margin                   = $WebService2->result['Margin'];
            }

        }else{

            $WebService2= new WebService($webservice_config);
            $WebService2->RequestAccountFunds($requestData['account_number']);

            $getWithdrawableRealFund = $WebService2->get_result('Withrawable_RealFund');
            $Withrawable_BonusFund   = $WebService2->get_result('Withrawable_BonusFund');
            $TotalRealFund           = $WebService2->get_result('TotalRealFund');
            $equity                  = $WebService2->get_result('Equity');
            $margin                  = $WebService2->get_result('Margin');

        }

//        $getWithdrawableRealFund = $WebService2->get_result('Withrawable_RealFund');
//        $margin = $WebService2->get_result('Margin');

        $WebService3 = new WebService($webservice_config);
        $WebService3->request_live_account_balance($requestData['account_number']);
//        $equity = $WebService3->get_result('Equity');

//        $Withrawable_BonusFund = $WebService2->get_result('Withrawable_BonusFund');
//        $TotalRealFund = $WebService2->get_result('TotalRealFund');
        $user_id  = $requestData['user_id'];
        $totalAmount = (float) $requestData['totalAmount'];
        $feePlusAddons = $requestData['totalFee'];
        $feesOnly = $requestData['fee'];
        $addonsOnly = $requestData['addons'];
        $getUserDetail = $this->account_model->getUserDetailsByAccountNumber($requestData['account_number']);
        //$from = Date('Y/d/m H:i:s',strtotime($getUserDetail['ndba_acquired']));
        $WebService1 = new WebService($webservice_config);
        $data = array(
            'iLogin' => $requestData['account_number']
        );
//        $WebService1->request_account_details($data);
//        if ($WebService1->request_status === 'RET_OK') {
//            $from = $WebService1->get_result('RegDate');
//        }

        $newWebService = FXPP::GetAllAccountDetails($requestData['account_number']);
        if($newWebService['ErrorMessage'] === 'RET_OK'){
            $from = $newWebService['Data'][0]->RegDate;
        }

        $fundsDetails = array(
            'getWithdrawableRealFund' => $getWithdrawableRealFund,
            'equity' => $equity,
            'margin' => $margin,
            'totalfee' => $feePlusAddons,
            'feesOnly' => $feesOnly,
            'addonsOnly' => $addonsOnly,
            'from' => $from,
            'amount' => $totalAmount
        );

            $returnData = array(
            'error' => true,
            'errorMsg' => lang('m_wth_02'),
            'removeNDB' => false
             );



        if($equity < $totalAmount){
            $returnData['detailsfunds'] = $fundsDetails;
            return $returnData;
        }
        /*
         * Do not allow client to withdraw their bonuses
         * Other validation for NDB Accounts
         *  START
         */
        $getAccountBonusByType = FXPP::getAccountBonusByType($requestData['account_number']);
        $getForumBonus = $getAccountBonusByType[18];  // forum bonus


        $copyTradeBonus =  array(
            27 => 'COPYTRADING BONUS',
        );

        foreach($getAccountBonusByType as $key => $bonusAmt) {
            if (array_key_exists($key, $copyTradeBonus)) {
                $returnData['errorMsg'] = 'To withdraw copytrading bonus, you have to send a request to bonuses@forexmart.com.';
                $returnData['detailsfunds'] = $fundsDetails;
                return $returnData;

            }
        }




      /* if($getUserDetail['nodepositbonus'] != 1 && $getForumBonus <= 0  ) { //validate other bonuses except for  forum bonus, and NDB
            if ($getWithdrawableRealFund <= 0) {
                $returnData['errorMsg'] = 'To withdraw bonuses, you have to send a request to bonuses@forexmart.com.';
                return $returnData;
            }
        }*/


        $contestFmBonus = $getAccountBonusByType[12];  // contest FM bonus
        $contestBonus = $getAccountBonusByType[7];  // contest prize bonus
        $totalContestBonus = $contestBonus + $contestFmBonus;


        if($totalContestBonus > 0){
            if($totalAmount > $totalContestBonus){
                $returnData['errorMsg'] = lang('m_wth_01');
                $returnData['detailsfunds'] = $fundsDetails;
                return $returnData;
            }
        }


        if($getUserDetail['nodepositbonus'] != 1 ) { //validation for other bonuses except for NDB
            if ($getWithdrawableRealFund <= 0) { //must update
                $returnData['errorMsg'] = lang('m_wth_01');
                return $returnData;
            }
        }



        if($totalAmount > $getWithdrawableRealFund){
            $getThirtyPercentDepositBonus = $getAccountBonusByType[1];
            $getFiftyPercentDepositBonus = $getAccountBonusByType[10];
            if($getThirtyPercentDepositBonus > 0 || $getFiftyPercentDepositBonus > 0){
                $returnData['errorMsg']  = lang('m_wth_03') . $getWithdrawableRealFund.' '.$requestData['currency']. lang('m_wth_04');
                return $returnData;
            }
        }


        $getTotalNoDepositBonus = $getAccountBonusByType[2];

        $fundsDetails['Withrawable_BonusFund'] = $getTotalNoDepositBonus;


        /*
        * validation for NDB accounts
        *  START
        */

        if($getUserDetail['nodepositbonus'] == 1 ){

            $hascancelledNDBBonus = $this->withdraw_model->getWithdrawBonusDate($requestData['account_number'],1);

        if(!$hascancelledNDBBonus AND $getUserDetail['nodepositbonus'] == 1){

            $WebServiceTime = new WebService($webservice_config);
            $WebServiceTime->open_GetServerTime();
            $serverTime = $WebServiceTime->get_all_result();

            $serverTime = FXPP::getServerTime();

            $WebServiceTotalProfitFromRange = new WebService($webservice_config);
            $account_info2 = array(
                'iLogin'   =>   $requestData['account_number'],
                'from'     =>   $from,
                'to'       =>   $serverTime
            );

            $WebServiceTotalProfitFromRange->open_GetAccountTotalProfitFromRange($account_info2);

            if ($WebServiceTotalProfitFromRange->request_status === 'RET_OK') {
                $BonusProfitFull = $WebServiceTotalProfitFromRange->get_result('TotalProfit');
                $Commission = $WebServiceTotalProfitFromRange->get_result('TotalCommission');
                $Swap = $WebServiceTotalProfitFromRange->get_result('TotalSwaps');
            }

            $totalDeposit = $this->deposit_model->getTotalDeposit($user_id,2);

            if($BonusProfitFull > 0) {
                if ($totalDeposit <= 0) {
                    $returnData['detailsfunds'] = $fundsDetails;
                    $returnData['errorMsg'] = lang('m_wth_05');
                    return $returnData;
                }
            }

           $swapAndCommisson =  $Commission + $Swap;

            //Avoid negative values
            $totalEquity = $equity < 0 ? 0:$equity;
            if($getWithdrawableRealFund <= 0){
                $BonusProfitFull = 0;
            }else if($BonusProfitFull <= 0){
                $BonusProfitFull = 0;
            }

            $withdrawableAmount = $totalEquity - $margin - $getTotalNoDepositBonus -  $BonusProfitFull;

            $totalRealFundDeposit = $getWithdrawableRealFund -  $BonusProfitFull;

            //return funds details  for failed withdrawal
            $fundsDetails['BonusProfit'] = $BonusProfitFull;
            $fundsDetails['swap'] = $swapAndCommisson;
            $fundsDetails['withdrawableAmount'] = $withdrawableAmount;

            if($BonusProfitFull > 0) {
                if ($totalRealFundDeposit <= 0) {
                    $returnData['detailsfunds'] = $fundsDetails;
                    $returnData['errorMsg'] = lang('m_wth_05');
                    return $returnData;
                }
            }


            $totalWithdrawableAmountwithFee =  $withdrawableAmount + $feePlusAddons;

            if($withdrawableAmount <= 0){
                $returnData['detailsfunds'] = $fundsDetails;
                $returnData['errorMsg']  = lang('m_wth_01');
                return $returnData;
            }


            if($totalWithdrawableAmountwithFee <= 0){
                $returnData['detailsfunds'] = $fundsDetails;
                $returnData['errorMsg'] = lang('m_wth_06');
                return false;
            }

            if( $totalWithdrawableAmountwithFee < $totalAmount){
                $returnData['detailsfunds'] = $fundsDetails;
                $returnData['errorMsg']  = lang('m_wth_07') . $totalWithdrawableAmountwithFee.' '.$requestData['currency'];
                return $returnData;
            }

            $returnData['detailsfunds'] = $fundsDetails;
            $returnData['removeNDB'] = true;

        }else if($hascancelledNDBBonus  AND $getUserDetail['nodepositbonus'] == 1 ) {//validation  if  NDB is cancelled  and already made  a deposit to account

            $getWithdrawBonusDetails_v1 = $this->withdraw_model->getWithdrawBonusDate($requestData['account_number'], 2);
            $getWithdrawBonusDetails_v2 = $this->withdraw_model->getWithdrawBonusDate($requestData['account_number'], 1);

            if ($getWithdrawBonusDetails_v1['Is_realfund'] == 2) {

                $cancelledProfit = $getWithdrawBonusDetails_v1['Amount'];
                $to = Date('Y/d/m H:i:s', strtotime($getWithdrawBonusDetails_v1['Date']));
                $IsBonusProfitCancelled = true;

            } else if ($getWithdrawBonusDetails_v2['Is_realfund'] == 1) {

                $to = Date('Y/d/m H:i:s', strtotime($getWithdrawBonusDetails_v2['Date']));
                $IsBonusProfitCancelled = false;

            } else if (!$getWithdrawBonusDetails_v1 and !$getWithdrawBonusDetails_v2) {
                $returnData['errorMsg'] = lang('m_wth_05');

                return $returnData;
            }

            $data['to'] = DateTime::createFromFormat('Y/d/m H:i:s', date($to));

            $account_info = array(
                'iLogin' => $requestData['account_number'],
                'from'   => $from,
                'to'     => $data['to']->format('Y-m-d\TH:i:s')
            );

            $WebServiceTotalProfitFromRange = new WebService($webservice_config);
            $WebServiceTotalProfitFromRange->open_GetAccountTotalProfitFromRange($account_info);

            if ($WebServiceTotalProfitFromRange->request_status === 'RET_OK') {
                $BonusProfit = $WebServiceTotalProfitFromRange->get_result('TotalProfit');
                $Commission = $WebServiceTotalProfitFromRange->get_result('TotalCommission');
                $Swap = $WebServiceTotalProfitFromRange->get_result('TotalSwaps');
            }

            if ($BonusProfit <= 0) {
                $BonusProfit = 0;
            }
            $BonusProfitwithSwapComm = $BonusProfit + $Commission + $Swap;

            // subtract cancelled profit from client's total bonus profit (if client deposited amount is less than the total bonus profit)
            // clients real fund and total profit must be equals/proportion in NDB
            if ($IsBonusProfitCancelled) {
                $BonusProfitwithSwapComm = $BonusProfitwithSwapComm - $cancelledProfit;
            }

            $swapAndCommisson = $Commission + $Swap;
            $totalEquity = $equity <= 0 ? 0 : $equity;

            //make negative values  instead zero instead of negative
            if ($getWithdrawableRealFund <= 0) {
                $BonusProfitwithSwapComm = 0;
            } else if ($BonusProfitwithSwapComm <= 0) {
                $BonusProfitwithSwapComm = 0;
            }

            if ($getTotalNoDepositBonus < 0) {
                $getTotalNoDepositBonus = 0;
            }

            if (IPLoc::Office()) {
                $bonusCancelDetails = $this->withdraw_model->getBonusProfitDetails($requestData['account_number']);
                if ($bonusCancelDetails['IsCancel'] == 1) {
                    $BonusProfitwithSwapComm = 0;
                }
            }

            $withdrawableAmount = $totalEquity - $margin - $getTotalNoDepositBonus - $BonusProfitwithSwapComm;
            $totalWithdrawableAmountwithFee = $withdrawableAmount + $feePlusAddons;


            $withdraw_profit = array(
                'amount'         => $BonusProfitwithSwapComm,
                'account_number' => $requestData['account_number']
            );


            $withdrawableRoundTotalAmount = round($totalAmount, 2); // round amount for floating numbers
            $withdrawableRoundAmount = round($withdrawableAmount, 2);

            //return funds details  for failed withdrawal
            $fundsDetails['BonusProfitwithSwapComm'] = $BonusProfit;
            $fundsDetails['swap'] = $swapAndCommisson;
            $fundsDetails['cancelledProfit'] = $cancelledProfit;
            $fundsDetails['withdrawableRoundTotalAmount'] = $withdrawableRoundTotalAmount;
            $fundsDetails['withdrawableRoundAmount'] = $withdrawableRoundAmount;
            $fundsDetails['withdrawableAmount'] = $withdrawableAmount;

            if (IPLoc::Office()) {
                if (!$bonusCancelDetails and $BonusProfitwithSwapComm > 0) {
                    if ($withdrawableRoundAmount == $withdrawableRoundTotalAmount) {
                        $this->removeBonusProfit($withdraw_profit);
                    }
                }

                if ($withdrawableAmount <= 0) {
                    if ($getTotalNoDepositBonus > 0 or $BonusProfitwithSwapComm > 0) {
                        $returnData['detailsfunds'] = $fundsDetails;
                        $returnData['errorMsg'] = lang('m_wth_01');

                        return $returnData;
                    }
                }
            } else {
                if ($withdrawableAmount <= 0) {
                    $returnData['detailsfunds'] = $fundsDetails;
                    $returnData['errorMsg'] = lang('m_wth_01');
                }
            }


            if ($totalWithdrawableAmountwithFee <= 0) {
                $returnData['detailsfunds'] = $fundsDetails;
                $returnData['errorMsg'] = lang('m_wth_06');

                return false;
            }


            if ($totalWithdrawableAmountwithFee < $totalAmount) {
                $returnData['detailsfunds'] = $fundsDetails;
                $returnData['errorMsg'] = lang('m_wth_07') . $totalWithdrawableAmountwithFee . ' ' . $requestData['currency'];

                return $returnData;
            }

        }

    }

        // Withdraw Bonus Profit Logs**/
        $ndbProfitLogs = array(
            'Account_number' => $requestData['account_number'],
            'withdrawAmount' => $totalAmount - $feePlusAddons,
            'fee' => $feePlusAddons,
            'withdrawableAmount' => $withdrawableAmount,
            'Error' => $returnData,
            'TradingBonusProfitFull' => $BonusProfitFull,
            'SwapComm' => $swapAndCommisson,
            'ProfitFromrange' =>  $BonusProfitwithSwapComm,
            'NDB' => $getTotalNoDepositBonus,
            'equlity' => $equity,
            'bonuscanceldetails' => $bonusCancelDetails,
            'margin' => $margin,
            'cancelledProfit'=>$cancelledProfit,
            'TotalRealFund'=> $TotalRealFund ,
            'date_withdraw' => $to,
            'BonusDates1' => $account_info2,
            'BonusDates2' => $account_info,
            'getWithdrawableRealFund' => $getWithdrawableRealFund,
            'IsBonusProfitCancelled' => $IsBonusProfitCancelled

        );
        $encodeNdbProfitLogs = json_encode($ndbProfitLogs);
        $insertProfitLogs = array(
            'logs' => $encodeNdbProfitLogs,
            'User_Id' => $requestData['account_number']
        );

        $this->deposit_model->insertNdbCancellationLogs($insertProfitLogs);
        // End Logs**/
        $returnData['error'] = false;
        $returnData['errorMsg'] = 'success';
        $returnData['amountProcess'] = $totalAmount;
        return $returnData;
    }

    
    
// just tesing purpose don't use real transection     
     public function withdrawalProcess_test($withdrawalData){
        $this->load->library('Fx_mailer');
        $this->lang->load('modal_message',$this->session->userdata('site_lang')); // Please do not remove.

        $amount_withdraw = $withdrawalData['amount'];
        $userId = $withdrawalData['user_id'];
        $counterpart = $withdrawalData['counterpart'];
        $withdrawalType = $withdrawalData['withdrawal_type'];
        $getWithdrawalType = $this->transaction_type[$withdrawalType];

        $returnData = array(
            'error' => true,
            'errorMsg' => lang('m_wth_14'),
        );



        $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

        if(!$user_status){
            return $returnData;
        }

        $account = $this->account_model->getAccountNumber($userId);
        $currency = $account['currency'];
        $currencyStatus = $this->currency_status[$account['currency']];
        $isMicro = $this->account_model->isMicro($userId);
        if($isMicro){
            $currencyStatus = $this->currency_status['Cents'];
            $currency = $account['currency'].'c';
        }

        $account_number = $account['account_number'];


        if($withdrawalType === 'NETELLER'){
            $getTransactionFee = FXPP::getTransactionFee($withdrawalType, $account['currency'], $amount_withdraw);
        }else{
            $getTransactionFee = FXPP::getTransactionFee($withdrawalType, $account['currency']);
        }

        $totalFee = FXPP::roundno($amount_withdraw * $getTransactionFee['fee'], 2);
            

        if($withdrawalType === 'BITCOIN'){
            $processing_fee = FXPP::bitcoinToWalletCurrency($account['currency'],0.0002); // processing fee
            $free_fee_max_amount = FXPP::bitcoinToWalletCurrency($account['currency'],0.001); // minimum amount without fee

            if( $this->account_model->isMicro($this->session->userdata('user_id'))){
                $processing_fee = $processing_fee *100;
                $free_fee_max_amount = $free_fee_max_amount *100;
            }

            if($amount_withdraw >= $free_fee_max_amount){
                $totalFee = $totalFee + $processing_fee ;
                $getTransactionFee['fee'] = $totalFee;
            }


        }


        $totalFees = $totalFee + $getTransactionFee['addons'];

        $amount_deducted =  FXPP::roundno($amount_withdraw + $totalFees, 2);

        $requestData = array(
            'totalAmount' => $amount_deducted,
            'amountRequested' => $amount_withdraw,
            'totalFee' => $totalFees,
            'currency' => $account['currency'],
            'account_number' => $account_number,
            'addons' => $getTransactionFee['addons'],
            'fee' => $getTransactionFee['fee'],
            'user_id' => $userId
        );

            
            $validateAccountFund = $this->validateAccountFundv2($requestData);

            
            
            
            
        $dateFailed = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
        $insertWithdrawFailed = array(
            'transaction_id	' => 0,
            'status	' => 0,
            'amount	' => $amount_withdraw,
            'currency' => $currency,
            'user_id' => $userId,
            'payment_date' => $dateFailed,
            'transaction_type' => $getWithdrawalType,
            'payment_status	' => $this->paymentType_status[$withdrawalType],
            'currency_status' =>  $currencyStatus,
            'fee' => $totalFee,
            'isFailed' => 0,
            'type' => 'withdraw',
            'comment' => $validateAccountFund['errorMsg'],
            'details' =>  json_encode($validateAccountFund['detailsfunds'])
        );
        
        if($validateAccountFund['error']){
            $returnData['errorMsg'] = $validateAccountFund['errorMsg'];
           // $this->general_model->insert('no_status_transaction', $insertWithdrawFailed);
            return $returnData;
        }

     // generate reference number for MT4 Comment
        $new_date = new DateTime();
        $generated_transaction_number = $new_date->getTimestamp();
        $comment = $this->comment_type['withdraw'] . $this->comment_transaction_type[$withdrawalType] . $generated_transaction_number;

        $service_data = array(
            'Amount' => $amount_deducted,
            'Comment' => $comment,
            'Receiver' => 0,
            'AccountNumber' => $account_number,
            'ProcessByIP' => $this->input->ip_address()
        );



        $webservice_config = array(
            'server' => 'live_new'
        );

        $is_supporter = false;
        $WebService3 = new WebService($webservice_config);
        $WebService3->GetSupporterBonusFunds($account_number);
        if ($WebService3->request_status === 'RET_OK') {
            $supporter_full_count = $WebService3->get_result('SupporterFullCount');
            $supporter_part_count = $WebService3->get_result('SupporterPartCount');
            $supporter_count = $supporter_full_count + $supporter_part_count;
            if($supporter_count > 0){
                $is_supporter = true;
                $service_data['Comment'] = 'S_' . $this->comment_type['withdraw'] . $this->comment_transaction_type[$withdrawalType] . $generated_transaction_number;
            }else{
                $service_data['Comment'] = $this->comment_type['withdraw'] . $this->comment_transaction_type[$withdrawalType] . $generated_transaction_number;
            }
        }else{

            return $returnData;
        }
        
            
    }
            
    public function withdrawalProcess($withdrawalData){
        $this->load->library('Fx_mailer');
        $this->lang->load('modal_message',$this->session->userdata('site_lang')); // Please do not remove.

        $amount_withdraw = $withdrawalData['amount'];
        $userId = $withdrawalData['user_id'];
        $counterpart = $withdrawalData['counterpart'];
        $withdrawalType = $withdrawalData['withdrawal_type'];
        $getWithdrawalType = $this->transaction_type[$withdrawalType];

        $returnData = array(
            'error' => true,
            'errorMsg' => lang('m_wth_14'),
        );



        $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

        if(!$user_status){
            $returnData['errorMsg'] = "Please verify your account.";
            return $returnData;
        }

        $account = $this->account_model->getAccountNumber($userId);
        $currency = $account['currency'];
        $currencyStatus = $this->currency_status[$account['currency']];
        $isMicro = $this->account_model->isMicro($userId);
        if($isMicro){
            $currencyStatus = $this->currency_status['Cents'];
            $currency = $account['currency'].'c';
        }

        $account_number = $account['account_number'];


        if($withdrawalType === 'NETELLER'){
            $getTransactionFee = FXPP::getTransactionFee($withdrawalType, $account['currency'], $amount_withdraw);
        }else{
            $getTransactionFee = FXPP::getTransactionFee($withdrawalType, $account['currency']);
        }

        $totalFee = FXPP::roundno($amount_withdraw * $getTransactionFee['fee'], 2);

       /* if($withdrawalType === 'SKRILL'){
            $skrillSystemFee = $this->SkrillSystemFee($amount_withdraw, $account['currency']);
            $totalFee = $totalFee + $skrillSystemFee;
        }*/

        if($withdrawalType === 'BITCOIN'){
            $processing_fee = FXPP::bitcoinToWalletCurrency($account['currency'],0.0002); // processing fee
            $free_fee_max_amount = FXPP::bitcoinToWalletCurrency($account['currency'],0.001); // minimum amount without fee

            if( $this->account_model->isMicro($this->session->userdata('user_id'))){
                $processing_fee = $processing_fee *100;
                $free_fee_max_amount = $free_fee_max_amount *100;
            }

            if($amount_withdraw >= $free_fee_max_amount){
                $totalFee = $totalFee + $processing_fee ;
                $getTransactionFee['fee'] = $totalFee;
            }


        }


        $totalFees = $totalFee + $getTransactionFee['addons'];

        $amount_deducted =  FXPP::roundno($amount_withdraw + $totalFees, 2);

        $requestData = array(
            'totalAmount' => $amount_deducted,
            'amountRequested' => $amount_withdraw,
            'totalFee' => $totalFees,
            'currency' => $account['currency'],
            'account_number' => $account_number,
            'addons' => $getTransactionFee['addons'],
            'fee' => $getTransactionFee['fee'],
            'user_id' => $userId
        );


        //$validateAccountFund = $this->validateAccountFundv2($requestData); // removed validation of  fund

        $dateFailed = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));

        
        // generate reference number for MT4 Comment
        $new_date = new DateTime();
        $generated_transaction_number = $new_date->getTimestamp();
        $comment = $this->comment_type['withdraw'] . $this->comment_transaction_type[$withdrawalType] . $generated_transaction_number;

        $service_data = array(
            'Amount' => $amount_deducted,
            'Comment' => $comment,
            'Receiver' => 0,
            'AccountNumber' => $account_number,
            'ProcessByIP' => $this->input->ip_address()
        );



        $webservice_config = array(
            'server' => 'live_new'
        );

        $is_supporter = false;
        $WebService3 = new WebService($webservice_config);
        $WebService3->GetSupporterBonusFunds($account_number);
        if ($WebService3->request_status === 'RET_OK') {
            $supporter_full_count = $WebService3->get_result('SupporterFullCount');
            $supporter_part_count = $WebService3->get_result('SupporterPartCount');
            $supporter_count = $supporter_full_count + $supporter_part_count;
            if($supporter_count > 0){
                $is_supporter = true;
                $service_data['Comment'] = 'S_' . $this->comment_type['withdraw'] . $this->comment_transaction_type[$withdrawalType] . $generated_transaction_number;
            }else{
                $service_data['Comment'] = $this->comment_type['withdraw'] . $this->comment_transaction_type[$withdrawalType] . $generated_transaction_number;
            }
        }else{

            return $returnData;
        }


        $mt4_comment_type = 'Declined';
        $declinedCommentMt4 = $this->comment_type['withdraw'] . $this->comment_transaction_type[$withdrawalType] . $mt4_comment_type;
                        

        $WebService = new WebService($webservice_config);
        if($is_supporter){
            $WebService->WithdrawSupporterFullFund($service_data);
            $requestStatus = $WebService->request_status;
            $currentBalance =  $WebService->get_result('Balance');
            $ticket =  $WebService->get_result('Ticket');

        }else{
           
                $webResult  = FXPP::WithdrawRealFundV2($account_number,$amount_deducted,$comment,0,$declinedCommentMt4);
                $requestStatus = $webResult['requestResult'];
                $ticket =  $webResult['ticket'];

        }

        $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));

        if ($requestStatus != 'RET_OK') {
            $currentBalance =  $webResult['amount']  > 0 ? $webResult['amount'] : 0 ;

         
            $apiLogs = array(
                'Account_number' => $account_number,
                'UserId' => $userId,
                'Amount' => $amount_deducted,
                'ApiStatus' => $requestStatus,
                'Date' => $date,
                'WithdrawableFunds' => $currentBalance,
            );

            $this->general_model->insert('withdraw_api_logs', $apiLogs);
            $returnData['errorMsg'] = 'Not enough fund, Remaining withdrawable fund: '. $currentBalance;
            return $returnData;
        }else{
            $returnData['errorSrvcMsg'] = $requestStatus;
        }




        $transaction_id = $this->withdraw_model->insertWithdrawByTranType($getWithdrawalType, $counterpart);




        if(!$transaction_id){
            return $returnData;
        }

       // $result = $WebService->result;
        $withdraw_data = array(
            'account_number' => $account_number,
            'user_id' => $userId,
            'date_withdraw' => $date,
            'currency' => $currency,
            'reference_number' => $ticket,
            'transaction_type' => $getWithdrawalType,
            'amount' => $amount_withdraw,
            'amount_deducted' => $amount_deducted,
            'status' => 0,
            'transaction_id' => $transaction_id,
            'fee' => $getTransactionFee['fee'],
            'added_fee' => $getTransactionFee['addons'],
            'ref_num_mt4' => $generated_transaction_number,
            'payment_status'   => $this->paymentType_status[$withdrawalType],//FXPP-7618
            'currency_status'  => $currencyStatus, //FXPP-7618
            'conv_amount'  => $this->amountConverter($amount_withdraw,substr($currency, 0, 3),'USD'),
            'btc_rate'  => $free_fee_max_amount,
            'btc_rate2'  => $processing_fee,
        );


      
        $withdrawId = $this->withdraw_model->insertWithdraw($withdraw_data);
     

        if(!$withdrawId){   // FXPP-7765
            $insertWithdrawFailed['transaction_id'] = $transaction_id;
            $insertWithdrawFailed['comment'] = 'saving  withdrawal transaction failed '.$withdrawId;
            $this->general_model->insert('no_status_transaction', $insertWithdrawFailed);
        }

        $removeBonusArray = array(
            'Account_number' => $account_number,
            'UserId' => $userId,
            'Amount_deducted' => $amount_deducted,
            'Amount' => $amount_withdraw,
            'TransactionId' => $withdrawId,
            'TransactionType' => 'Withdraw'
        );


        /*
            $Transaction = new Transaction();
             $Transaction->RemoveBonus($removeBonusArray);            
        */



        $withdrawRequestMail = array(
            'Full_name' => $this->session->userdata('full_name'),
            'Email' =>$clientEmail = $this->session->userdata('email'),
            'Account_number' => $account_number,
            'Currency' => $account['currency'],
            'Amount' => $amount_withdraw,
            'Withdrawal_type' => $withdrawalType
        );

        Fx_mailer::withdraw($withdrawRequestMail);

        $fundsData = FXPP::getAccountFunds($account_number);
        if($fundsData['status'] === 'RET_OK' ) {
            $balance = $fundsData['balance'];


            FXPP::updateAccountTradingStatusV2($account_number,$userId,$balance); // for pro accounts


        }


        switch($withdrawalType){
            case 'NETELLER':
                $counterpartField = $counterpart['neteller_id'];
                break;
            case 'SKRILL':
                $counterpartField = $counterpart['skrill_account'];
                break;
            case 'PAYPAL':
                $counterpartField = $counterpart['paypal_account'];
                break;
            case 'PAXUM':
                $counterpartField = $counterpart['paxum_id'];
                break;
            case 'CREDIT CARD':
            case 'ZOTAPAY_CARD':
            case 'NOVA2PAY':   
                $counterpartField = $counterpart['card_number'];
                break;
            case 'MEGATRANSFER CARD':
                $counterpartField = $counterpart['card_number'];
                break;
            case 'BANK TRANSFER':
                // $counterpartField = $counterpart['beneficiary_account'];
                $counterpartField = $counterpart['ibanoraccount_number'];

                break;
            case 'PAYCO':
                $counterpartField = $counterpart['wallet'];
                break;
            case 'QIWI':
                $counterpartField = $counterpart['inv_number'];
                break;
            case 'MEGATRANSFER':
                $counterpartField = $counterpart['username'];
                break;
            case 'WEBMONEY':
                $counterpartField = $counterpart['webmoney_purse'];
                break;
            case 'MONETA':
                $counterpartField = $counterpart['moneta_account'];
                break;
            case 'SOFORT':
                $counterpartField = $counterpart['ibanoraccount_number'];
//                $counterpartField = $counterpart['sofort_account'];
                break;
            case 'YANDEXMONEY':
                $counterpartField = $counterpart['yandex_wallet'];
                break;
            case 'BITCOIN':
                $counterpartField = $counterpart['username'];
                break;
            case 'FASAPAY':
                $counterpartField = $counterpart['fasapay_account'];
                break;

            case 'EMERCHANTPAY':
                $counterpartField = $counterpart['card_number'];
                break;
            case 'CHINAUNIONPAY':
                $counterpartField = $counterpart['chinaUnionPay_account'];
                break;
            case 'ALIPAY':
                $counterpartField = $counterpart['aliPay_account'];
                break;
            case 'BANK_MYR':
            case 'BANK_VND':
            case 'BANK_IDR':
            case 'BANK_THB':
                $counterpartField = $counterpart['paytrust_account'];
                break;
            case 'INPAY':
                // $counterpartField = $counterpart['beneficiary_account'];
                $counterpartField = $counterpart['ibanoraccount_number'];
                break;
            case 'ZOTAPAY_MYR':
            case 'ZOTAPAY_IDR':
            case 'ZOTAPAY_VND':
            case 'ZOTAPAY_THB':
            case 'BANK_NGN':
            case 'ASIA_VND':
                $counterpartField = $counterpart['bank_account_number'];
                break;
         
        }


        // $ibanoraccount_number = isset($counterpart['ibanoraccount_number'])?$counterpart['ibanoraccount_number']:'';

        $transaction_data = array(
            'amount_requested' => $amount_withdraw,
            'account_number' => $account_number,
            'client_inf' => $counterpartField,
            'email_address' => $counterpart['card_name'],
            'transaction_number' => $ticket,
            'fee' => $totalFees
        );

        $returnData['error'] = false;
        $returnData['errorMsg'] = 'success';
        $returnData['transaction_data'] = $transaction_data;
        return $returnData;
    }

    public function removeBonus($params){

        $amount = $params['amount'];
        $account_number = $params['account_number'];
        $userId = $params['user_id'];
        $bonusId = $params['bonus_id'];
        $withdraw_id = $params['withdraw_id'];

        $comment = $this->comment_bonus_cancel[$bonusId];

        $service_data = array(
            'Amount' => $amount,
            'Comment' => $comment,
            'Receiver' => 0,
            'AccountNumber' => $account_number,
            'ProcessByIP' => $this->input->ip_address(),
            'bonusId' => $bonusId
        );

        $webservice_config = array(
            'server' => 'live_new'
        );

        $WebService = new WebService($webservice_config);
        $WebService->WithdrawBonusFund($service_data);
        $result = $WebService->result;
        if ($WebService->request_status === 'RET_OK') {
            $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
            $withdraw_data = array(
                'Account_number' => $account_number,
                'User_id' => $userId,
                'Date' => $date,
                'Ticket' => $result['Ticket'],
                'Amount' => $amount,
                'Bonus_id' => $bonusId,
                'Withdraw_trans_id' => $withdraw_id
            );

            $this->withdraw_model->insertWithdrawBonus($withdraw_data);
        }

        // end remove bonus default
    }

    public function newRemoveBonus($params){
        //        $params = null;

        //        $accountNumber = 101491; with 30% bonus
        //        $accountNumber = 146401; // with contest bonus
        //        $accountNumber = 104353; // with both 30% and NDB
        //        $user_id = 10211;

        $accountNumber = $params['Account_number'];
        $user_id = $params['UserId'];
        $withdraw_id = $params['WithdrawId'];

        $webservice_config = array('server' => 'live_new');
//        $WebService2 = new WebService($webservice_config);
//        $WebService2->RequestAccountFunds($accountNumber);

        if(IPLoc::APIUpgradeDevIP()){

            $this->load->library('WSV'); //New web service
            $WSV = new WSV();
            $WebService2 = $WSV->GetAccountFunds($accountNumber);

            if($WebService2->request_status === "RET_OK"){
                $getWithdrawableRealFund  = $WebService2->result['Withrawable_RealFund'];
            }

        }else{

            $WebService2= new WebService($webservice_config);
            $WebService2->RequestAccountFunds($accountNumber);

            $getWithdrawableRealFund = $WebService2->get_result('Withrawable_RealFund');

        }

//        $getWithdrawableRealFund = $WebService2->get_result('Withrawable_RealFund');
        $getAccountBonusByType = FXPP::getAccountBonusByType($accountNumber);

        $minimumBonus = 0.01;

        // 30% bonus removing process
        $getThirtyPercentBonus = $getAccountBonusByType[1];

        if($getThirtyPercentBonus > 0){
            if($getThirtyPercentBonus > $minimumBonus){

                $thirtyPercent = 0.30;
                $getThirtyPercentProportion = $getWithdrawableRealFund * $thirtyPercent;
                if($getThirtyPercentBonus > $getThirtyPercentProportion){
                    $getAmtBonusDeduct = $getThirtyPercentBonus - $getThirtyPercentProportion;

                    $bonusThirtyPrms = array(
                        'BonusAmt' => $getThirtyPercentBonus,
                        'BonusAmtToRemove' => $getAmtBonusDeduct
                    );
                    $thirtyBonusLeast = self::convertBonusToLeast($bonusThirtyPrms);

                    $removeThirtyBonusParams = array(
                        'amount' => $thirtyBonusLeast,
                        'account_number' => $accountNumber,
                        'user_id' => $user_id,
                        'bonus_id' => 1,
                        'withdraw_id' => $withdraw_id
                    );
                    self::removeBonus($removeThirtyBonusParams);
                }

            }
        }
        // end 30% bonus process

        // NDB removing process
        $getNDB = $getAccountBonusByType[2];
        if($getNDB > 0){
            if($getNDB > $minimumBonus){
                $bonusNDBPrms = array(
                    'BonusAmt' => $getNDB,
                    'BonusAmtToRemove' => $getNDB
                );
                $NDBonusLeast = self::convertBonusToLeast($bonusNDBPrms);

                $removeNDBParams = array(
                    'amount' => $NDBonusLeast,
                    'account_number' => $accountNumber,
                    'user_id' => $user_id,
                    'bonus_id' => 2,
                    'withdraw_id' => $withdraw_id
                );
                self::removeBonus($removeNDBParams);
            }
        }

        // end NDB process

        //      BONUS CONTEST MF PRIZE removing process
        $getContestBonus = $getAccountBonusByType[12];
        if($getContestBonus > 0){
            if($getContestBonus > $minimumBonus){

                $bonusContestPrms = array(
                    'BonusAmt' => $getContestBonus,
                    'BonusAmtToRemove' => $getContestBonus
                );
                $contestBonusLeast = self::convertBonusToLeast($bonusContestPrms);

                $removeContestBonusParams = array(
                    'amount' => $contestBonusLeast,
                    'account_number' => $accountNumber,
                    'user_id' => $user_id,
                    'bonus_id' => 12,
                    'withdraw_id' => $withdraw_id
                );
                self::removeBonus($removeContestBonusParams);

            }
        }
        //      end BONUS CONTEST MF PRIZE process

        // Support Bonus removing process
        $getSupportBonus = $getAccountBonusByType[8];
        if($getSupportBonus > 0){
            if($getWithdrawableRealFund <= 0){
                $bonusSupportPrms = array(
                    'BonusAmt' => $getSupportBonus,
                    'BonusAmtToRemove' => $getSupportBonus
                );
                $supportBonusLeast = self::convertBonusToLeast($bonusSupportPrms);

                $removeSupportBonusParams = array(
                    'amount' => $supportBonusLeast,
                    'account_number' => $accountNumber,
                    'user_id' => $user_id,
                    'bonus_id' => 8,
                    'withdraw_id' => $withdraw_id
                );
                self::removeBonus($removeSupportBonusParams);
            }
        }
        // End Support Bonus

    }


    public function convertBonusToLeast($bonusPrms){
        $bonusAmt = $bonusPrms['BonusAmt'];
        $BonusAmtToRemove = $bonusPrms['BonusAmtToRemove'];
        $leastBonus = 0.01;

        $testBonusRemoval = $bonusAmt - $BonusAmtToRemove;
        if($testBonusRemoval < $leastBonus){
            $BonusAmtToRemove = $bonusAmt - $leastBonus;
            return $BonusAmtToRemove;
        }


        return $BonusAmtToRemove;
    }

    public function withdrawremovebonus($params){
        $amount = $params['amount'];
        $account_number = $params['account_number'];
        $userId = $params['user_id'];
        $bonusId = $params['bonus_id'];

        $service_data = array(
            'Amount' => $amount,
            'Comment' => '',
            'Receiver' => 0,
            'AccountNumber' => $account_number,
            'ProcessByIP' => $this->input->ip_address(),
            'bonusId' => $bonusId
        );

        $webservice_config = array(
            'server' => 'live_new'
        );

        $WebService = new WebService($webservice_config);
        $WebService->WithdrawBonusFund($service_data);
        $result = $WebService->result;

        $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
        $withdraw_data = array(
            'Account_number' => $account_number,
            'User_id' => $userId,
            'Date' => $date,
            'Ticket' => $result['Ticket'],
            'Amount' => $amount
        );

        $WithdrawBonusId = $this->withdraw_model->insertWithdrawBonus($withdraw_data);
        if($WithdrawBonusId){
            $this->account_model->updateAmountNDBByUserId($userId, 0);
        }

    }

    public function withdrawremovebonusDebug($params){
        $amount = $params['amount'];
        $account_number = $params['account_number'];
        $userId = $params['user_id'];
        $bonusId = $params['bonus_id'];

        $service_data = array(
            'Amount' => 38,
            'Comment' => '',
            'Receiver' => 0,
            'AccountNumber' => $account_number,
            'ProcessByIP' => $this->input->ip_address(),
            'bonusId' => $bonusId
        );

        $webservice_config = array(
            'server' => 'live_new'
        );

        $WebService = new WebService($webservice_config);
        $WebService->WithdrawBonusFund($service_data);
        $result = $WebService->result;

        $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
        $withdraw_data = array(
            'Account_number' => $account_number,
            'User_id' => $userId,
            'Date' => $date,
            'Ticket' => $result['Ticket'],
            'Amount' => $amount
        );

        $WithdrawBonusId = $this->withdraw_model->insertWithdrawBonus($withdraw_data);
        // if($WithdrawBonusId){
        //     $this->account_model->updateAmountNDBByUserId($userId, 0);
        // }

    }


    public function SkrillSystemFee($amount, $currency){
        $skrillSystemFee = 0.01;
        switch($currency){
            case 'EUR':
                $limitAmountFee = 10;
                break;
            default:
                $limitAmountFee = $this->amountConverter(11.41, 'USD', $currency);
        }

        $computeSystemFee = $skrillSystemFee * $amount;
        if(!FXPP::isAccountFromEUCountry()) {
            if ($computeSystemFee >= $limitAmountFee) {
                $computeSystemFee = $limitAmountFee;
            }
        }

        return $computeSystemFee;

    }



    public function amountConverter($amount, $currencyFrom, $currencyTo){

        $webservice_config = array(
            'server' => 'converter'
        );

        $WebServiceA = new WebService($webservice_config);
        $convertDetails = array(
            'Amount' => $amount,
            'FromCurrency' => $currencyFrom,
            'ServiceLogin' => 505641,
            'ServicePassword' => '5fX#p8D^c89bQ',
            'ToCurrency' => $currencyTo
        );

        $ConvertCurrency = $WebServiceA->ConvertCurrency($convertDetails);
        $resultConvertCurrency = $ConvertCurrency['ConvertCurrencyResult'];
        if($ConvertCurrency['SOAPError'] === true || $resultConvertCurrency['Status'] === 'RET_OK' || $resultConvertCurrency['Status'] === 'RET_GAP'){
            $convertedAmount = $resultConvertCurrency['ToAmount'];
        }else{
            $convertCurrencies = FXPP::ForexData($currencyFrom, $currencyTo);
            $convertedAmount = $amount*$convertCurrencies['Rate'];
        }

      //  $convertedAmount = round($convertedAmount, 2);

        $convertedAmount = $convertedAmount;

        return $convertedAmount;
    }

    public function checkITSPIN() {
        if ($this->input->is_ajax_request() && $this->session->userdata('logged')) {
            $pin = $this->input->post('pin');
            $its_info = $this->general_model->showssingle('internal_transfer','user_id',$this->session->userdata('user_id'),'pin');
            if ($pin !== $its_info['pin']) {
                $isSuccess = false;
            } else {
                $isSuccess = true;
            }

            $partner_user_id = $this->session->userdata('user_id');

            // Check if Partner has a verified account
            $verifyPartner = $this->general_model->showssingle('users','id',$partner_user_id,'accountstatus');
            if ($verifyPartner['accountstatus'] == 0 || $verifyPartner['accountstatus'] == 2) {
                $verify_partner = 'To enable Transit Transfer, please have your account verified first.';
            } else {
                $verify_partner = '';
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'pin' => $its_info['pin'],
                        'verify' => $verify_partner,
                    )
                )
            );
        }
    }

    public function checkFMWalletBalance() {
        $result['result'] = false;

        $param = array(
            'wallet'        =>  'M598357205',
            'merchant_id'   =>  '225970729',
            'username'      =>  'Forexmart',
            'password'      =>  'MZM8eGH4P3',
        );

        $result = FXPP::PayCo_WalletBalance($param);

        if (isset($result['Message']) && ($result['Message'] == 'Success')) {
            if ($result['Data'] <= 0) {
                $result['result'] = true;
            }
        }

        return $result;
    }

    public function paycoWalletBalance($data) {
        $param = array(
            'wallet'        =>  $data['wallet'],
            'merchant_id'   =>  $data['merchant_id'],
            'username'      =>  $data['username'],
            'password'      =>  $data['password'],
        );

        $result = FXPP::PayCo_WalletBalance($param);

        return $result;
    }

    public function checkForexmartWallet() {
        if ($this->input->is_ajax_request() && $this->session->userdata('logged')) {
            $this->load->library('Fx_mailer');

            $fmMerchantID = '225970729';
            $fmWallet = 'M598357205';

            $dummyInfo = array(
                'wallet'        =>  $fmWallet,
                'merchant_id'   =>  $fmMerchantID,
                'username'      =>  'Forexmart',
                'password'      =>  'MZM8eGH4P3',
            );
            $result = FXPP::PayCo_WalletBalance($dummyInfo);

            if (isset($result['Data'])) {
                if ($result['Data'] < 1) {
                    // Send mail to notify ForexMart PayCo Wallet insufficient balance
                    $content['title'] = 'Transit Transfer Inaccessible';
                    $content['table'] = '';
                    $content['paragraph'] = '<p style="font-size: 16px;">Transit Transfer is not available as of now due to insufficient funds on ForexMart PayCo Wallet.</p>
                                             <p style="font-size: 16px;">Please immediately oversee this matter.</p>';
                    $email_data['subject'] = 'Transit Transfer - Insufficient Balance';
                    $email_data['content'] = Fx_mailer::custom_transit_transfer($content);

                    $this->sendMail($email_data);
                }
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'result' => $result
                    )
                )
            );
        }
    }

    public function checkWallet() {
        if ($this->input->is_ajax_request() && $this->session->userdata('logged')) {
            $type = $this->input->post('type');
            $isSuccess = false;
            $data = array(
                'wallet'        =>  $this->input->post('wallet'),
                'merchant_id'   =>  $this->input->post('merchant_id'),
                'username'      =>  $this->input->post('username'),
                'password'      =>  $this->input->post('password'),
            );
            $result = FXPP::PayCo_isWallet($data);

            if (isset($result['IsError'])) {
                switch ($result['Message']) {
                    case 'Wallet should be 10 characters long only':
                        $return['Message'] = 'Invalid PayCo Wallet Format';
                        break;
                    case 'Wallet does not exist':
                        $return['Message'] = 'Wallet does not exist under Merchant ID';
                        break;
                    case 'Invalid Parameter No hash':
                    case 'Invalid Access':
                        $return['Message'] = 'Invalid Merchant ID';
                        break;
                    case 'This method requires 2 parameters':
                        $return['Message'] = '';
                        break;
                    case 'Success':
                        $return['Message'] = 'Success';
                        $isSuccess = true;
                        break;
                }
            } else if (isset($result['error'])) {
                $return['Message'] = 'Invalid Username or Password';
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'result' => $return,
                        'data' => $result,
                        'type' => $type,
                        'success' => $isSuccess
                    )
                )
            );
        }
    }

    public function paycoErrorMessages($result) {
        $return = '';

        if (isset($result['IsError'])) {
            switch ($result['Message']) {
                case 'Wallet has insufficent funds for transaction':
                    $return['Message'] = $result['Message'];
                    break;
                case 'Wallet should be 10 characters long only':
                    $return['Message'] = 'Invalid PayCo Wallet Format';
                    break;
                case 'Wallet does not exist':
                    $return['Message'] = 'Wallet does not exist under Merchant ID';
                    break;
                case 'Invalid Parameter No hash':
                case 'Invalid Access':
                    $return['Message'] = 'Invalid Merchant ID';
                    break;
                case 'This method requires 2 parameters':
                    $return['Message'] = '';
                    break;
                case 'Success':
                    $return['Message'] = 'Success';
                    $return['isSuccess'] = true;
                    break;
            }
        } else if (isset($result['error'])) {
            $return['Message'] = 'Invalid Username or Password';
        }

        return $return;
    }

    public function WalletTransfer() {
        if (!$this->input->is_ajax_request()) {
            die('Not authorized!');
        }
        if ($this->session->userdata('logged')) {
            $this->load->model(array('user_model','partners_model'));
            $this->load->library('Fx_mailer');

            $errorMsg = '';
            $transfer_data = null;
            $isSuccess = false;

            if ($this->input->post('c_fm_account') == 'Other') {
                $client_acc_num = $this->input->post('c_fm_account_input');
            } else {
                $client_acc_num = $this->input->post('c_fm_account');
            }

            $client_info = $this->user_model->getUserIdbyAccountNumber($client_acc_num);
            $client_user_id = $client_info[0]['user_id'];

            $partner_user_id = $this->session->userdata('user_id');
            $partner_account = $this->partners_model->getAccountByUserId($partner_user_id);

            $resellerData = array(
                'amount'                =>  $this->input->post('amount_transfer'),
                'partner_wallet'        =>  $this->input->post('p_wallet'),
                'partner_user_id'       =>  $partner_user_id,
                'partner_account_number'=>  $partner_account,
                'client_wallet'         =>  $this->input->post('c_wallet'),
                'client_account_number' =>  $client_acc_num,
                'client_user_id'        =>  $client_user_id,
                'client_currency'       =>  $client_info[0]['mt_currency_base'],
            );

            $getClientPaycoResellerData = $this->getPaycoWalletAndResellerData($this->input->post('c_wallet'), $client_user_id, 'its');

            $resellerData['client_username'] = $getClientPaycoResellerData['username'];
            $resellerData['client_password'] = $getClientPaycoResellerData['password'];
            $resellerData['client_merchant_id'] = $getClientPaycoResellerData['merchant_id'];

            $getPartnerPaycoResellerData = $this->getPaycoWalletAndResellerData($this->input->post('p_wallet'), $partner_user_id, 'its');

            $resellerData['partner_username'] = $getPartnerPaycoResellerData['username'];
            $resellerData['partner_password'] = $getPartnerPaycoResellerData['password'];
            $resellerData['partner_merchant_id'] = $getPartnerPaycoResellerData['merchant_id'];

            $transferResult = $this->paycoWalletTransfer($resellerData);

            if (!$transferResult['error']) {
                $isSuccess = true;
            } else {
                $errorMsg = $transferResult['errorMsg'];
                $numberTransfer = $transferResult['countTransfer'];

                if ($numberTransfer > 0) {
                    $lastTransfer['Amount transferred:'] = $resellerData['amount'];

                    if ($numberTransfer == 1) {
                        $lastTransfer = array(
                            'From:' =>  'ForexMart',
                            'To:'   =>  'Partner',
                            'Partner Account:'  =>  $partner_account['reference_num'],
                            'Partner PayCo Wallet:' =>  $resellerData['partner_wallet'],
                        );
                    } else {
                        $lastTransfer = array(
                            'From:' =>  'Partner',
                            'To:'   =>  'Client',
                            'Partner Account:'  =>  $partner_account['reference_num'],
                            'Partner PayCo Wallet:' =>  $resellerData['partner_wallet'],
                            'Client Account:'  =>  $client_acc_num,
                            'Client PayCo Wallet:' =>  $resellerData['client_wallet'],
                        );
                    }

                    // Must send email to support to check the transfer done
                    $content['title'] = 'Transit Transfer Failed';
                    $content['table'] = $lastTransfer;
                    $content['paragraph'] = '<p style="font-size: 16px;">Transit transfer failed. Please immediately return credit to ForexMart PayCo Wallet.</p>
                                             <p style="font-size: 16px;">Below is details of the last transfer:</p>';
                    $email_data['subject'] = 'Transit Transfer - Failed Transfer';
                    $email_data['content'] = Fx_mailer::custom_transit_transfer($content);

                    $this->sendMail($email_data);
                }
            }

            $transfer_data = $transferResult['result'];
            $converted_amount = $resellerData['client_currency'] == $partner_account['currency'] ? $resellerData['amount'] . ' ' . $resellerData['client_currency'] : $transfer_data['WebService']['ConvertedAmount'] . ' ' . $resellerData['client_currency'] . ' [' . $resellerData['amount'] . ' ' . $partner_account['currency'] . ']';
            $data = array(
                'c_fm_account'      =>  $_POST['c_fm_account'] . ' [' . $resellerData['client_currency'] . ']',
                'converted_amount'  =>  $converted_amount,
            );

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'success'   => $isSuccess,
                            'result'    => $transfer_data,
                            'errorMsg'  => $errorMsg,
                            'data'      => $data,
                            'test'      => $resellerData,
                        )
                    )
                );
        }
    }






    // new
   
    public function requestFundTransfer(){
        if (!$this->input->is_ajax_request()) { die('Not authorized!'); }
        if (!$this->session->userdata('logged')) { redirect(''); }



        if($this->input->post('tranType') == 'transit-transfer'){
            $receiver = $this->input->post('c_fm_account') == 'Other' ?  $this->input->post('c_fm_account_input') :  $this->input->post('c_fm_account');
            $transferType = 1;
            $source = $this->session->userdata('account_number');
            $bonusType = $this->input->post('c_fm_bonus');
            $amountRequested = $this->input->post('amount_transfer');
        }elseif ($this->input->post('tranType') == 'partner-transfer'){
            $amountRequested = $this->input->post('partner-amount');
            $transferType = 2;
            $source = $this->session->userdata('account_number');
            $receiver = $this->input->post('partner-input');
        }else{
            $source = $this->input->post('req_client') == 'Other' ?  $this->input->post('req_client_input') :  $this->input->post('req_client');
            $receiver = $this->session->userdata('account_number');
            $transferType= 3;
            $securityCode = $this->input->post('sec_code');
            $amountRequested = $this->input->post('requested_amount');
        }



        $requestData = array(
            'optType' => $transferType,
            'source' => $source,
            'receiver' => $receiver,
            'amount' => $amountRequested,
            'securityCode' => $securityCode,
            'bonusType' => $bonusType,
        );




        $requestResult = $this->processFundTransfer($requestData);



        $this->output->set_content_type('application/json')
            ->set_output(
            json_encode(
                array(
                    'data'  =>  $requestResult
                )
            )
        );
    }





    // new
    public function processFundTransfer($request)
    {

        ini_set('max_execution_time', 600);
        $this->load->model('account_model');
        $this->load->library('Fx_mailer');

        $date = new DateTime();
        $generatedTnxNumber = $date->getTimestamp();

        $securityCode = $request['securityCode'];
        $amountRequested = $request['amount'];
        $sourceAccount = $request['source'];
        $receiverAccount = $request['receiver'];
        $loginAccount = $this->session->userdata('account_number'); //partner
        $optType = $request['optType'];
        $bonusType = $request['bonusType'];
        $success = false;
        $apiError = false;
        $partnerId = $this->session->userdata('user_id');
        $this->load->library('FXAPI');
        /*if(IPloc::IPOnlyForVenus()){
            FXAPI::getInstance(CABINET_STAGING_API);
        }*/

        if($optType == 3){
           $checkAmountTransferred = $this->checkAmountTransferred($loginAccount, $amountRequested);



            if (!$checkAmountTransferred['error'] && $checkAmountTransferred['account_with_limit']) {
                $isPending = false;

                $ret = FXAPI::RequestFundTransferFromCode_AC(array('Amount' => $amountRequested, 'Comment' => $generatedTnxNumber,'IsAccepted' => 1, 'Login' => $sourceAccount, 'Receiver' => $receiverAccount));
                $requestStatus = $ret['RET']; //status
                $receivedAmount = $ret['data']->Amount; //amount credited to receiver
                $rTicket = $ret['data']->Ticket; //receiver ticket
                $sTicket = '00000'; //ticket
                $emailReceiveAmt = $receivedAmount;
                $emailDeductedAmt = $amountRequested;
            } else {
                $isPending = true;
                $apiSecurityCode = $this->general_model->showssingle('its_security_code', 'security_code', $securityCode, 'api_security_code');
               // $declinedCommentMt4 = 'DPST_TR_' . $sourceAccount;

                $ret = FXAPI::RequestFundTransferFromCode(array('Amount' => $amountRequested, 'Comment' => $generatedTnxNumber, 'IsAccepted' => 0, 'Code' => $apiSecurityCode['api_security_code'], 'IsConfirm' => true));
                $requestStatus = $ret['RET']; //status
                $receivedAmount = $ret['data']->Amount; //amount to be deducted to sender
                $emailReceiveAmt = $amountRequested;
                $emailDeductedAmt = abs($receivedAmount);
                $sTicket = $ret['data']->Ticket; // sender ticket
                $rTicket = 00000; //ticket
            }

        }else{
            $isPending = false;
            
            

            $ret = FXAPI::SendMoney(array('Amount' => $amountRequested, 'Comment' => $generatedTnxNumber,'IsAccepted' => 1, 'Login' => $sourceAccount, 'Receiver' => $receiverAccount));
            $requestStatus = $ret['RET']; //status
            $receivedAmount = $ret['data']->Amount; //amount credited to receiver
            $rTicket = $ret['data']->Ticket; //ticket
            $emailReceiveAmt = $receivedAmount;
            $emailDeductedAmt = $amountRequested;
        }



        switch ($requestStatus) {
            case 'RET_NOT_ENOUGH_FUND':
            case 'RET_INSUFFICIENT_FUNDS':
                $withdrawableFund = $ret['data']->Amount;

                $errorMsg = 'Not enough fund, Remaining transferable fund: ' . $withdrawableFund;
                $apiError = true;
                break;
            case 'RET_TRANSFER_BLOCKED':

                $errorMsg = 'Fund transfer is blocked, Please try again after 5 seconds. Thank you';
                $apiError = true;

                break;
            case 'RET_OK':
                $success = true;

                if (!$isPending) { //instant transfer
                    $note = 'WITHDRAW_MT_TICKET_' . $sTicket . ' - DEPOSIT_MT_TICKET_ ' . $rTicket;
                    $partner_content['p1'] = 'Request for funds using Transfer is processed.<br> ';
                    $partner_content['partner_p1'] = 'Request for funds using Transfer is processed.<br> ';

                    $errorMsg = 'Successfully transfer funds from Client Account ' . $sourceAccount .
                        ' to Partner Account ' . $receiverAccount . '. ';
                    $transferStatus = $this->transit_transfer_status['Success'];

                    $ref_status = 1; //processed  ITS request ( only for partner with automatic fund transfer

                } else { // transfer with approval
                    $note = 'WITHDRAW_MT_TICKET_' . $sTicket . ' - DEPOSIT_MT_TICKET_';
                    $partner_content['partner_p1'] = 'You have sent the request for transfer from account ' . $sourceAccount . ' to your account ' . $receiverAccount . '.';
                    $partner_content['p1'] = 'You received the transfer from account ' . $sourceAccount . ' to your account ' . $receiverAccount . '.';

                    $errorMsg = 'Your Internal Transfer Request is under review. We will send you an email once the ITS has been processed. Thank you for your patience.';
                    $transferStatus = $this->transit_transfer_status['Verifying'];
                    $ref_status = 0; // pending  ITS request stored in transit_transfer_fund_request table in admin panel

                }


                if($optType == 3) {

                    /*   update security code  start  */
                    $update_security_code = array(
                        'partner_user_id' => $this->session->userdata('user_id'),
                        'status' => 1,
                        'date_used' => date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                    );
                    $this->general_model->updatemy('its_security_code', 'security_code', $securityCode, $update_security_code);





                    $table = 'transit_transfer_fund_request';
                    // save transfer request
                    $fund_transfer = array(
                        'amount_request' => $amountRequested, // actual requested amount
                        'receiver' => $receiverAccount,
                        'sender' => $sourceAccount,
                        'status' => $ref_status,
                        'referral_id' => $generatedTnxNumber,
                        'date_request' => date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                        'security_code' => $securityCode,
                        'api_security_code' => $apiSecurityCode['api_security_code'],
                        'transfer_amount' => $emailReceiveAmt , // processed amount deposited to partner
                        'deduct_amount' =>  $emailDeductedAmt, // processed amount deducted from client (converted or actual amount request)
                    );


                    $this->general_model->insert($table, $fund_transfer);


                }


                $save_transit = array(
                    'transaction_id' => $generatedTnxNumber,
                    'status' => $transferStatus,
                    'sender' => $sourceAccount,
                    'receiver' => $receiverAccount,
                    'amount_transfer' => $amountRequested,
                    'conv_amount' => abs($receivedAmount),
                    'date_transfer' => date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                    'referral_id' => $generatedTnxNumber,
                    'request_from_affiliate' => $optType === '1' ? 0 : 1,
                    'bonus_type' => $optType === '1' ? $bonusType : 'none',
                    'transaction_type' => $optType,
                    'note' => $note,

                );




                  $reference_id = $this->general_model->insert('transit_transfer', $save_transit);



                    //sendmail
                    $content['title'] = 'The Transfer - Accessed by Partner Account [' . $loginAccount . ']';



                    if ($optType == '3') { //request from client
                        $direction = "From Client " . $sourceAccount . " to  Partner  " . $receiverAccount;
                        $clientMsg = 'Dear client,<br>  You sent the  transfer from account ' . $sourceAccount . ' to account ' . $receiverAccount;
                        $partnerMsg = 'Dear partner,<br> You received the  transfer from   account ' . $sourceAccount . ' to your account ' . $receiverAccount;
                        $partnerInfo = $this->account_model->getAccountDetailsByAccountNumber($receiverAccount);
                        $clientInfo = $this->account_model->getAccountDetailsByAccountNumber($sourceAccount);
                        $receiverCurrency = $partnerInfo['currency'];
                        $SenderCurrency = $clientInfo['currency'];

                    } else if ($optType == '1') { //send to client
                        $direction = "From Partner " . $sourceAccount . " to  client  " . $receiverAccount;
                        $clientMsg = 'Dear client,<br>  You received the  transfer from account ' . $sourceAccount . ' to account your account ' . $receiverAccount;
                        $partnerMsg = 'Dear partner,<br> You have sent the request for  transfer from your account ' . $sourceAccount . ' to account ' . $receiverAccount;
                        $partnerInfo = $this->account_model->getAccountDetailsByAccountNumber($sourceAccount);
                        $clientInfo = $this->account_model->getAccountDetailsByAccountNumber($receiverAccount);
                        $receiverCurrency = $clientInfo['currency'];
                        $SenderCurrency = $partnerInfo['currency'];

                    } else { // send to partner
                        $direction = "From Partner " . $sourceAccount . " to  Partner  " . $receiverAccount;
                        $clientMsg = 'Dear partner,<br>  You received the  transfer from account ' . $sourceAccount . 'to account your account ' . $receiverAccount;
                        $partnerMsg = 'Dear partner,<br> You have sent the request for  transfer from your account ' . $sourceAccount . ' to account ' . $receiverAccount;
                        $partnerInfo = $this->account_model->getAccountDetailsByAccountNumber($sourceAccount);
                        $clientInfo = $this->account_model->getAccountDetailsByAccountNumber($receiverAccount);
                        $receiverCurrency = $clientInfo['currency'];
                        $SenderCurrency = $partnerInfo['currency'];
                    }

                          

                    if($optType == 1 && $bonusType != 'none') {


                            FXPP::DepositBonusNew($clientInfo['user_id'], $clientInfo['account_number'], $receivedAmount, 'ITS', $bonusType, $generatedTnxNumber);


                    }



                $content['table'] = array(
                        'IB’s Account:' => $partnerInfo['account_number'] . ' [' . $partnerInfo['currency'] . ']',
                        'Referral’s Account:' => $clientInfo['account_number'] . ' [' . $clientInfo['currency'] . ']',
                        'Amount:' => $emailDeductedAmt,
                        'Currency:' => $SenderCurrency,
                        'Converted amount:' => $emailReceiveAmt . ' ' . $receiverCurrency,
                        'Direction:' => $direction,
                        'Order Time (UTC+3):' => date('Y-m-d H:i:s'),

                    );


                    $cToFmContent['title'] = 'The Transfer Successful';
                    $cToFmContent['table'] = $content['table'];
                    $cToFmContent['paragraph'] = '<p>Visit this <a href="https://m7.forexmart.com/administration/manage-transfer-queue">page</a> on Admin Panel for more info.</p>
                                  <p style="font-size: 16px;">The transfer details:</p>';

                    $verifyClient = $this->general_model->showssingle('users', 'id', $clientInfo['user_id'], 'email');

                    $cToFM_mail['content'] = Fx_mailer::custom_transit_transfer($cToFmContent, 0, $clientMsg);

                    $cToFM_mail['to_email'] = $verifyClient['email']; // client email address
                    $this->sendTransactionDetails($cToFM_mail);
                    $cToFM_mail['content'] = Fx_mailer::custom_transit_transfer($cToFmContent, 0, $partnerMsg);

                    $cToFM_mail['to_email'] = $this->session->userdata('email'); // partner email adderess
                    $this->sendTransactionDetails($cToFM_mail);








        break;

      }


        if(!$success){


            if ($isPending) {
                /*   update security code  start  */

                $update_security_code = array(
                    'partner_user_id' => $partnerId,
                    'status' => 0,
                    'date_used' => date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                );
                $this->general_model->updatemy('its_security_code', 'security_code', $securityCode, $update_security_code);
            }

                /*   update security code  end  */

                if(!$apiError){
                    $errorMsg = lang('its_82');
                }


            $apiLogs = array(
                'Account_number' => $loginAccount,
                'UserId' => $partnerId,
                'Amount' => $amountRequested,
                'ApiStatus' => $requestStatus,
                'Date' => date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                'WithdrawableFunds' => $withdrawableFund,
            );

            $this->general_model->insert('withdraw_api_logs', $apiLogs);


        }

        $request_data = array(
            'actual_amount' => $amountRequested,
            'received_amount' => $emailReceiveAmt,
            'security_code' => $securityCode,
            'c_account' => $receiverAccount,
            'transaction_id' => $generatedTnxNumber,
            'for_approval' => $isPending,
            'is_success' => $success,
            'message' => $errorMsg,
            'checkAmountTransferred' => $checkAmountTransferred,
        );


        return $request_data;

    }




    public function WalletTransferModified_backup() {
        ini_set('max_execution_time', 600);
        if (!$this->input->is_ajax_request()) {
            die('Not authorized!');
        }
        if ($this->session->userdata('logged')) {
            
            
            
            $this->load->model(array('user_model','partners_model'));
            $this->load->library('Fx_mailer');

            $errorMsg = '';
            $transfer_data = null;
            $isSuccess = false;

            if ($this->input->post('c_fm_account') == 'Other') {
                $client_acc_num = $this->input->post('c_fm_account_input');
            } else {
                $client_acc_num = $this->input->post('c_fm_account');
            }

            $bonustype  = $this->input->post('c_fm_bonus');

            $client_info = $this->user_model->getUserIdbyAccountNumber($client_acc_num);
            $client_user_id = $client_info[0]['user_id'];

            $partner_user_id = $this->session->userdata('user_id');
            $partner_account = $this->partners_model->getAccountByUserId($partner_user_id);

            $trns_amount = $this->input->post('amount_transfer');
            $actual_amount = $trns_amount;
            $isMicro = $this->account_model->isMicro($client_user_id);




            $transaction_type=$this->input->post('tranType');

            if($transaction_type=='transit-transfer'){
                $transferType=1;
            }elseif ($transaction_type=='partner-transfer'){
                $transferType=2;
            }else{
                $transferType=3;
            }






            if ($isMicro) {
                $trns_amount = $trns_amount * 100;
            }

            $resellerData = array(
                'amount'                =>  $trns_amount,
                'partner_user_id'       =>  $partner_user_id,
                'partner_account_number'=>  $partner_account,
                'client_account_number' =>  $client_acc_num,
                'client_user_id'        =>  $client_user_id,
                'client_currency'       =>  $client_info[0]['mt_currency_base'],
                'bonus_type'            => $bonustype,
                'its_type'              => 1,
                'transaction_type'              => $transferType,
            );
            
        
            

                            $transferResult = $this->paycoWalletTransferModified($resellerData, 'partner');

                            if (!$transferResult['error']) {
                                $isSuccess = true;
                            } else {
                                $errorMsg = $transferResult['errorMsg'];
                            }

                            $transfer_data = $transferResult['result'];
                            $converted_amount = $resellerData['client_currency'] == $partner_account['currency'] ? $resellerData['amount'] . ' ' . $resellerData['client_currency'] : $transfer_data['WebService']['ConvertedAmount'] . ' ' . $resellerData['client_currency'] . ' [' . $resellerData['amount'] . ' ' . $partner_account['currency'] . ']';
                            $data = array(
                                'c_fm_account'      =>  $_POST['c_fm_account'] . ' [' . $resellerData['client_currency'] . ']',
                                'converted_amount'  =>  $converted_amount,
                                'actual_amount'     =>  $actual_amount,
                            );

                            $this->output->set_content_type('application/json')
                                ->set_output(
                                json_encode(
                                    array(
                                        'success'   => $isSuccess,
                                        'result'    => $transfer_data,
                                        'errorMsg'  => $errorMsg,
                                        'data'      => $data,
                                        'c_account' => $client_acc_num,
                                        'test'      => $resellerData,
                                        'test2'     => $transferResult['test'],
                                        'test3'     =>  $client_acc_num,
                                    )
                                )
                            );
            
             
            
        }
    } //send to client

    public function WalletTransferModified() { //send from partner to partner
        if (!$this->input->is_ajax_request()) {
            die('Not authorized!');
        }
        if ($this->session->userdata('logged')) {
            $this->load->model(array('user_model','partners_model'));
            $this->load->library('Fx_mailer');

            $errorMsg = '';
            $transfer_data = null;
            $isSuccess = false;

            $partner_user_id = $this->session->userdata('user_id');
            $partner_account = $this->partners_model->getAccountByUserId($partner_user_id);

            $type = $this->input->post('type');
            
            $bonustype  = $this->input->post('p_fm_bonus');
            
            if ($type == 'partner') {
                $amount_transfer = $this->input->post('partner-amount');
                $receiver_account_number = $this->input->post('partner-input');
                $receiver_details = $this->user_model->getPartnerByAccount($receiver_account_number);
                $receiver_id = $receiver_details['partner_id'];
                $receiver_currency = $receiver_details['currency'];
            } else {
                $amount_transfer = $this->input->post('amount_transfer');
                if ($this->input->post('c_fm_account') == 'Other') {
                    $receiver_account_number = $this->input->post('c_fm_account_input');
                } else {
                    $receiver_account_number = $this->input->post('c_fm_account');
                }
                $client_info = $this->user_model->getUserIdbyAccountNumber($receiver_account_number);
                $receiver_id = $client_info[0]['user_id'];
                $receiver_currency = $client_info[0]['mt_currency_base'];
            }



            $transaction_type=$this->input->post('tranType');
            if($transaction_type=='transit-transfer'){
                $transferType=1;
            }elseif ($transaction_type=='partner-transfer'){
                $transferType=2;
            }else{
                $transferType=3;
            }

            $resellerData = array(
                'amount'                    =>  $amount_transfer,
                'partner_user_id'           =>  $partner_user_id,
                'partner_account_number'    =>  $partner_account['reference_num'],
                'partner_currency'          =>  $partner_account['currency'],
                'receiver_account_number'   =>  $receiver_account_number,
                'receiver_user_id'          =>  $receiver_id,
                'receiver_currency'         =>  $receiver_currency,
                'transaction_type'          => $transferType,
                  'bonus_type'            => $bonustype,
                
            );

            $transferResult = $this->paycoWalletTransferModifiedTest($resellerData, 'partner');

            if (!$transferResult['error']) {
                $isSuccess = true;
            } else {
                $errorMsg = $transferResult['errorMsg'];
            }

            $transfer_data = $transferResult['result'];
            $converted_amount = $resellerData['receiver_currency'] == $partner_account['currency'] ? $resellerData['amount'] . ' ' . $resellerData['receiver_currency'] : $transfer_data['WebService']['ConvertedAmount'] . ' ' . $resellerData['receiver_currency'] . ' [' . $resellerData['amount'] . ' ' . $partner_account['currency'] . ']';
            $data = array(
                'c_fm_account'      =>  $_POST['c_fm_account'] . ' [' . $resellerData['client_currency'] . ']',
                'converted_amount'  =>  $converted_amount,
            );

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'success'   => $isSuccess,
                            'result'    => $transfer_data,
                            'errorMsg'  => $errorMsg,
                            'r_account' => $receiver_account_number,
                            'test'      => $resellerData,
                            'data'      => $data,
                        )
                    )
                );
        }
    }

    public function paycoWalletTransferModifiedTest($data, $type) {
        $this->load->library('Fx_mailer');

        // Return data
        $returnData = array(
            'error' => true,
            'errorMsg' => 'Transit Transfer failed. Please contact our support for more information.',
            'countTransfer' => 0,
        );

        // Partner Account Number
        $partner_account_number = $data['partner_account_number'];
        $partner_user_id = $data['partner_user_id'];

        // Receiver/Client Account Number
        $receiver_account_number = $data['receiver_account_number'];
        $receiver_user_id = $data['receiver_user_id'];

        // Converted amount, current date and currency
        $client_currency = $data['receiver_currency'];
        $partner_currency = $data['partner_currency'];

        if ($client_currency === $partner_currency) {
            $converted_amount = $data['amount'];
        } else {
            $converted_amount = $this->amountConverter($data['amount'], $data['partner_currency'], $client_currency);
        }

        // Send mail to Support to notify them that Partner is about to transfer and let them check the progress of transfer
        $content['title'] = 'Transit Transfer - Accessed by Partner Account ['.$partner_account_number.']';
        $content['table'] = array(
            'Partner Account:'      =>  $partner_account_number . ' [' . $data['partner_currency'] . ']',
            'Client Account:'       =>  $receiver_account_number . ' [' . $client_currency . ']',
            'Amount to transfer:'   =>  $data['amount'] . ' ' . $data['partner_currency'],
            'Converted amount:'     =>  $converted_amount . ' ' . $client_currency,
        );


        /**************************************Reseller Data**************************************/

        // Partner transfer to Client
        $account_numbers = array(
            'sender'        =>  $type === 'partner' ? $partner_account_number : $receiver_account_number,
            'receiver'      =>  $type === 'partner' ? $receiver_account_number : $partner_account_number,
            'amount'        =>  $data['amount'],
        );

        $date = new DateTime();
        $generated_transaction_number = $date->getTimestamp();

        $save_transit = array(
            'status'            =>  $this->transit_transfer_status['Pending'],
            'sender'            =>  $account_numbers['sender'],
            'receiver'          =>  $account_numbers['receiver'],
            'amount_transfer'   =>  $data['amount'],
            'conv_amount'       =>  $converted_amount,
            'date_transfer'     =>  date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
            'referral_id'       =>  $generated_transaction_number,
            'request_from_affiliate' => $type === 'partner' ? 0 : 1,
            'transaction_type'         => $data['transaction_type'],
            'bonus_type'         => $type === 'partner' ? $data['bonus_type'] : 'none',

        );

        $reference_id = $this->general_model->insert('transit_transfer',$save_transit);


        /*************************************Save to Transit Transfer Table*************************************/


        $updatePartnerToClient['transaction_id'] = $generated_transaction_number;
        $updatePartnerToClient['status'] = $this->transit_transfer_status['Success']; // success

        $cToFmContent['title'] = 'Transit Transfer Successful';
        $cToFmContent['table'] = $content['table'];
        $cToFmContent['paragraph'] = '<p>Visit this <a href="https://m7.forexmart.com/administration/manage-transfer-queue">page</a> on Admin Panel for more info.</p>
                                      <p style="font-size: 16px;">Transit transfer details:</p>';

        $cToFM_mail['subject'] = 'Transit Transfer - Successful Transfer';
        $cToFM_mail['content'] = Fx_mailer::custom_transit_transfer($cToFmContent);

        /***************************************************WEBSERVICE******************************************************/

        $withdraw_from_account = $type === 'partner' ? $partner_account_number : $receiver_account_number;
        $withdraw_from_uid = $type === 'partner' ? $partner_user_id : $receiver_user_id;

        $deposit_to_uid = $type === 'partner' ? $partner_user_id : $receiver_user_id;
        $deposit_to_account = $type === 'partner' ? $receiver_account_number : $partner_account_number;

        $comment = $this->comment_type['withdraw'] . $this->comment_transaction_type['TRANSIT_TRANSFER'] . $deposit_to_account .'_'. $generated_transaction_number;
        $withdraw_amount = $type === 'partner' ? $data['amount'] : $converted_amount;

        $service_data = array(
            'Amount' => $withdraw_amount,
            'Comment' => $comment,
            'Receiver' => 0,
            'AccountNumber' => $withdraw_from_account,
            'ProcessByIP' => $this->input->ip_address(),
        );

        $webservice_config = array('server' => 'live_new');



        if(IPLoc::APIUpgradeDevIP()){
            $res = FXPP::WithdrawRealFund($withdraw_from_account,$withdraw_amount,$comment,1);
            $wStatus = $res['requestResult'];
            $wTicket = $res['ticket'];
        }else{
            $WebService_Withdraw = new WebService($webservice_config);
            $WebService_Withdraw->WithdrawRealFund($service_data);
            $wStatus = $WebService_Withdraw->request_status;
            $wTicket =  $WebService_Withdraw->get_result('Ticket');
        }

        $transfer['WebService'] = $service_data;

        $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
        if ($wStatus != 'RET_OK') {

             $apiLogs = array(
                'Account_number' => $withdraw_from_account,
                'UserId' => $withdraw_from_uid,
                'Amount' => $withdraw_amount,
                'ApiStatus' => $wStatus,
                'Date' => $date
            );
            $this->general_model->insert('withdraw_api_logs', $apiLogs);

            switch ($wStatus) {
                case 'RET_INSUFFICIENT_FUNDS':
                case 'RET_NOT_ENOUGH_FUND':
//                    $WebService_checkFunds = new WebService($webservice_config);
//                    $WebService_checkFunds->RequestAccountFunds($withdraw_from_account);
//                    $result = $WebService_checkFunds->result;

                    if(IPLoc::APIUpgradeDevIP()){

                        $this->load->library('WSV'); //New web service
                        $WSV = new WSV();
                        $WebService_checkFunds = $WSV->GetAccountFunds($withdraw_from_account);

                        if($WebService_checkFunds->request_status === "RET_OK"){
                            $result = $WebService_checkFunds->result;
                        }

                    }else{

                        $WebService_checkFunds= new WebService($webservice_config);
                        $WebService_checkFunds->RequestAccountFunds($withdraw_from_account);

                        $result = $WebService_checkFunds->result;

                    }

                    if ($result['Withrawable_BonusFund'] > 0) {
                        $returnData['errorMsg'] = 'Account Number '. $withdraw_from_account .' has insufficient funds to transfer. Withrawable Real Fund Amount: '. $result['Withrawable_RealFund'];
                    } else {
                        $returnData['errorMsg'] = 'Account Number '. $withdraw_from_account .' has insufficient funds to transfer.';
                    }
                    break;
                default:
                    $returnData['errorMsg'] = 'Transit Transfer failed. Please contact our support for more information.';
            }

            $note['note'] = $returnData['errorMsg'];
        } else {
            $returnData['error'] = false;
            $returnData['errorMsg'] = 'success';

           // $result = $WebService_Withdraw->result;

            $WebService_Update_Balance1 = new WebService($webservice_config);
            $WebService_Update_Balance1->request_live_account_balance($withdraw_from_account);

            if( $WebService_Update_Balance1->request_status === 'RET_OK' ) {
                $balance1 = $WebService_Update_Balance1->get_result('Balance');
                if ($type === 'partner') {
                    $this->account_model->updateAccountBalance_partner($withdraw_from_account, $balance1);
                } else {
                    $this->account_model->updateAccountBalance($withdraw_from_account, $balance1);
                }

                $deposit_amount = $type === 'partner' ? $converted_amount : $data['amount'];

                // Deposit to Client or Partner ForexMart Account
//                $WebService_Deposit = new WebService($webservice_config);
                $account_number = $type == 'partner' ? $receiver_account_number : $partner_account_number;

//                if(IPLoc::APIUpgradeDevIP()){
                    $res = FXPP::DepositRealFund($account_number,$deposit_amount,'DPST_' . $this->comment_transaction_type['TRANSIT_TRANSFER'] . $withdraw_from_account .'_'. $generated_transaction_number);
                    $dStatus = $res['requestResult'];
                    $dTicket = $res['ticket'];
//                }else{
//                    $WebService_Deposit->update_live_deposit_balance($account_number, $deposit_amount, 'DPST_' . $this->comment_transaction_type['TRANSIT_TRANSFER'] . $withdraw_from_account .'_'. $generated_transaction_number);
//                    $dStatus = $WebService_Deposit->request_status;
//                    $dTicket = $WebService_Deposit->get_result('Ticket');
//                }

                if ($dStatus === 'RET_OK') {
                    $deposit_ticket = $dTicket;
                    $transfer['WebService']['ConvertedAmount'] = $converted_amount;

                    $this->general_model->updatemy('transit_transfer','id',$reference_id,$updatePartnerToClient);

                    $transfer['transaction_id'] = $generated_transaction_number;
                    $note['note'] = 'WITHDRAW_MT_TICKET_' . $wTicket . ' - DEPOSIT_MT_TICKET_ ' . $dTicket;

                    $WebService_Update_Balance2 = new WebService($webservice_config);
                    $WebService_Update_Balance2->request_live_account_balance($account_number);
                    if ($WebService_Update_Balance2->request_status === 'RET_OK') {
                        $balance2 = $WebService_Update_Balance2->get_result('Balance');
                        if ($type === 'partner') {
                            $this->account_model->updateAccountBalance($account_number, $balance2);
                        } else {
                            $this->account_model->updateAccountBalance_partner($account_number, $balance2);
                        }
                    }
                    //$this->sendMail($cToFM_mail);
                    
                    
                    
                    
                       // Auto Bonus Crediting
                    if ($type === 'partner') {  // partner to partner only                       
                        
                        //FXPP-13665  [reference]->13577
                        if(FXPP::isSpecailTransitTransferPartner()){                            
                        
//                            echo "<pre>";
//                            echo $account_number."===>".$deposit_amount."===>".$generated_transaction_number;
//                            print_r($data); exit;
                            
                            if ($data['bonus_type'] == 'fpb') {
                               FXPP::DepositBonus($data['partner_user_id'], $account_number, $deposit_amount, 'ITS', 'fpb', $generated_transaction_number);
                           }
                        }
                    }
                    
                    
                    
                    
                    
                    
                    
                } else {
                    $returnData['errorMsg'] = 'Transit Transfer failed. Please contact our support for more information.';
                    $note['note'] = $dStatus;
                }
                
                
                
                
                
                
                
                
                
                
            } else {
                $returnData['errorMsg'] = 'Transit Transfer failed. Please contact our support for more information.';
                $note['note'] = $WebService_Update_Balance1->request_status;
            }
        }
        
        
        

        $this->general_model->updatemy('transit_transfer','id',$reference_id,$note);

        $returnData['result'] = $transfer;
        $returnData['test'] = $wStatus;

        return $returnData;
    }

    protected function sendMailTest($details) {
        $this->load->library('email');
        $this->email->clear(TRUE);
        $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
        $this->email->to('jayhens.snow@gmail.com');
        $this->email->subject($details['subject']);
        $this->email->message($details['content']);
        $this->email->send();
    }

    protected function sendMail($details) {
       /* $this->load->library('email');
        $this->email->clear(TRUE);

        $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
        $this->email->to('finance@forexmart.com');
        $this->email->subject($details['subject']);
        $this->email->message($details['content']);
        $this->email->send();*/
        $this->load->library('Fx_mailer');
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        Fx_mailer::mysender('finance@forexmart.com',$details['subject'],$details['content'],$from,$returnPath);

    }


    protected function sendTransactionDetails($details) {
       /* $this->load->library('email');
        $this->email->clear(TRUE);

        $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
        $this->email->to($details['to_email']);
       // $this->email->bcc('bug.fxpp@gmail.com');
        $this->email->subject($details['subject']);
        $this->email->message($details['content']);
        $this->email->send();*/

        $this->load->library('Fx_mailer');
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        Fx_mailer::mysender($details['to_email'],$details['subject'],$details['content'],$from,$returnPath);

    }

    private $transit_transfer_status = array(
        'Pending'   =>  0,
        'Returned'  =>  1,
        'Success'   =>  2,
        'Failed'    =>  3,
        'Canceled'  =>  4,
        'Declined'  =>  5,
        'Verifying' =>  6,
    );

    public function paycoWalletTransfer($data) {
        $this->load->library('Fx_mailer');

        // Return data
        $returnData = array(
            'error' => true,
            'errorMsg' => 'Transit Transfer failed. Please contact our support for more information.',
            'countTransfer' => 0,
        );

        // Partner Account Number
        $partner_info = $data['partner_account_number'];
        $partner_account_number = $partner_info['reference_num'];
        $partner_user_id = $data['partner_user_id'];

        // Client Account Number
        $client_acc_num = $data['client_account_number'];
        $client_user_id = $data['client_user_id'];

        // Converted amount, current date and currency
        $client_currency = $data['client_currency'];
        $partner_currency = $partner_info['currency'];
        $payco_currency = 'USD';

        if ($client_currency === $partner_currency) {
            $converted_amount = $data['amount'];
        } else {
            $converted_amount = $this->amountConverter($data['amount'], $partner_info['currency'], $client_currency);
        }

        // Send mail to Support to notify them that Partner is about to transfer and let them check the progress of transfer
        $content['title'] = 'Transit Transfer - Accessed by Partner Account ['.$partner_account_number.']';
        $content['table'] = array(
            'Partner Account:'      =>  $partner_account_number . ' [' . $partner_info['currency'] . ']',
            'Partner PayCo Wallet:' =>  $data['partner_wallet'],
            'Client Account:'       =>  $client_acc_num . ' [' . $client_currency . ']',
            'Client PayCo Wallet:'  =>  $data['client_wallet'],
            'Amount to transfer:'   =>  $data['amount'] . ' ' . $partner_info['currency'],
            'Converted amount:'     =>  $converted_amount . ' ' . $client_currency,
        );

        // Check ForexMart Wallet Balance
        $checkFMBalance = $this->checkFMWalletBalance();
        if ($checkFMBalance['result']) {
            $returnData['errorMsg'] = 'Failed to transfer. Please contact support for more information.';

            // Send mail to notify ForexMart PayCo Wallet insufficient balance
            $insufficient_content['title'] = 'Transit Transfer Inaccessible';
            $insufficient_content['table'] = $content['table'];
            $insufficient_content['paragraph'] = '<p style="font-size: 16px;">Transit Transfer is not available as of now due to insufficient funds on ForexMart PayCo Wallet.</p>
                                             <p style="font-size: 16px;">Please immediately oversee this matter. Below is the details of attempted transfer:</p>';
            $insufficient_balance_mail['subject'] = 'Transit Transfer - Insufficient Balance';
            $insufficient_balance_mail['content'] = Fx_mailer::custom_transit_transfer($insufficient_content);

            $this->sendMail($insufficient_balance_mail);

            return $returnData;
        }

        /**************************************Reseller Data**************************************/

        // Forexmart transfer to Partner
        $fmToPartner = array(
            'sender'        =>  'M598357205',
            'receiver'      =>  $data['partner_wallet'],
            'username'      =>  'Forexmart',
            'password'      =>  'MZM8eGH4P3',
            'merchant_id'   =>  '225970729',
            'amount'        =>  $data['amount'],
            'currency'      =>  $payco_currency,
            'wallet_pin'    =>  153592,
        );

        // Partner transfer to Client
        $partnerToClient = array(
            'sender'        =>  $data['partner_wallet'],
            'receiver'      =>  $data['client_wallet'],
            'username'      =>  $data['partner_username'],
            'password'      =>  $data['partner_password'],
            'merchant_id'   =>  $data['partner_merchant_id'],
            'amount'        =>  $data['amount'],
            'currency'      =>  $payco_currency,
        );

        // Partner return transfer to FM
        $partnerToFm = array(
            'sender'        =>  $fmToPartner['receiver'],
            'receiver'      =>  $fmToPartner['sender'],
            'username'      =>  $partnerToClient['username'],
            'password'      =>  $partnerToClient['password'],
            'merchant_id'   =>  $partnerToClient['merchant_id'],
            'amount'        =>  $data['amount'],
            'currency'      =>  $payco_currency,
        );

        // Client transfer to Forexmart
        $clientToFM = array(
            'sender'        =>  $data['client_wallet'],
            'receiver'      =>  $fmToPartner['sender'],
            'username'      =>  $data['client_username'],
            'password'      =>  $data['client_password'],
            'merchant_id'   =>  $data['client_merchant_id'],
            'amount'        =>  $data['amount'],
            'currency'      =>  $payco_currency,
        );

        //  Transaction details to store in Transit Transfer table
        $insertFMToPartner = array(
            'transaction_id'    =>  0,
            'status'            =>  $this->transit_transfer_status['Pending'],
            'sender'            =>  'FM-' . $fmToPartner['sender'],
            'receiver'          =>  'PT-' . $fmToPartner['receiver'],
            'amount_transfer'   =>  $data['amount'],
            'conv_amount'       =>  $converted_amount,
            'date_transfer'     =>  date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
        );

        $date = new DateTime();
        $referral_id = $date->getTimestamp();

        $fm_ref_id = $this->general_model->insert('transit_transfer',$insertFMToPartner);

        $insertPartnerToClient = array(
            'transaction_id'    =>  0,
            'status'            =>  $this->transit_transfer_status['Pending'],
            'sender'            =>  'PT-' . $partnerToClient['sender'],
            'receiver'          =>  'CL-' . $partnerToClient['receiver'],
            'amount_transfer'   =>  $data['amount'],
            'conv_amount'       =>  $converted_amount,
            'date_transfer'     =>  date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
            'referral_id'       =>  $referral_id,
        );

        $partner_ref_id = $this->general_model->insert('transit_transfer',$insertPartnerToClient);

        $insertPartnerToFM = array(
            'transaction_id'    =>  0,
            'status'            =>  $this->transit_transfer_status['Pending'],
            'sender'            =>  'PT-' . $partnerToFm['sender'],
            'receiver'          =>  'FM-' . $partnerToFm['receiver'],
            'amount_transfer'   =>  $data['amount'],
            'conv_amount'       =>  $converted_amount,
            'date_transfer'     =>  date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
            'referral_id'       =>  $referral_id,
        );

        $insertClientToFM = array(
            'transaction_id'    =>  0,
            'status'            =>  $this->transit_transfer_status['Pending'],
            'sender'            =>  'CL-' . $clientToFM['sender'],
            'receiver'          =>  'FM-' . $fmToPartner['sender'],
            'amount_transfer'   =>  $data['amount'],
            'conv_amount'       =>  $converted_amount,
            'date_transfer'     =>  date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
            'referral_id'       =>  $referral_id,
        );

        $client_ref_id = $this->general_model->insert('transit_transfer',$insertClientToFM);

        /*************************************PayCo Transfer*************************************/

        // Transfer from Forexmart to Partner
        $transfer['FM'] = FXPP::PayCo_WalletTransfer($fmToPartner);

        /*$returnData['error'] = false;
        $returnData['errorMsg'] = 'success';
        $returnData['result'] = $transfer;
        $returnData['countTransfer'] = 3;

        return $returnData;*/

        if ($transfer['FM']['Message'] !== 'Success') {
            $updateFMToPartner['note'] = $fmToPartner['sender'].' - '.$transfer['FM']['Message'];
            $updateFMToPartner['status'] = $this->transit_transfer_status['Canceled'];

            $updateFMToPartnerWithReferral['note'] = $fmToPartner['sender'].' - '.$transfer['FM']['Message'];
            $updateFMToPartnerWithReferral['referral_id'] = $referral_id;
            $updateFMToPartnerWithReferral['status'] = $this->transit_transfer_status['Failed'];

            $this->general_model->updatemy('transit_transfer','id',$fm_ref_id,$updateFMToPartnerWithReferral);
            $this->general_model->updatemy('transit_transfer','id',$partner_ref_id,$updateFMToPartner);
            $this->general_model->updatemy('transit_transfer','id',$client_ref_id,$updateFMToPartner);

            return $returnData;
        } else {
            $updateFMToPartner['transaction_id'] = $transfer['FM']['Data']['transactionId'];
            $updateFMToPartner['status'] = $this->transit_transfer_status['Success']; // success
            $updateFMToPartner['referral_id'] = $referral_id;

            $this->general_model->updatemy('transit_transfer','id',$fm_ref_id,$updateFMToPartner);
        }

        // Transfer from Partner to Client
        $transfer['PT'] = FXPP::PayCo_WalletTransfer($partnerToClient);

        if ($transfer['PT']['Message'] !== 'Success') {
            // Transfer back from Partner to Forexmart
            $transfer['PT_return'] = FXPP::PayCo_WalletTransfer($partnerToFm);

            if ($transfer['PT_return']['Message'] !== 'Success') {

                // Must send an immediate mail to supports to return back transferred amount
                $pToFmContent['title'] = 'Return Transit Transfer [Partner-ForexMart] Failed';
                $pToFmContent['table'] = $content['table'];
                $pToFmContent['paragraph'] = '<p style="font-size: 16px;">Return Transit Transfer from Partner to ForexMart failed. Please immediately process transfer on Admin Panel to return the transferred money.</p>
                                             <p style="font-size: 16px;"> Below is the details of transfer:</p>';
                $pToFM_mail['subject'] = 'Transit Transfer - Failed Return Transfer';
                $pToFM_mail['content'] = Fx_mailer::custom_transit_transfer($pToFmContent);

                $this->sendMail($pToFM_mail);

                $insertPartnerToFM['note'] = 'Failed - ' . $transfer['PT']['Message'];
            } else {
                $insertPartnerToFM['transaction_id'] = $transfer['PT_return']['Data']['transactionId'];
                $insertPartnerToFM['status'] = $this->transit_transfer_status['Returned']; // return
                $insertPartnerToFM['note'] = 'Return - Transfer Cause: ' . $transfer['PT']['Message'];
            }

            $this->general_model->insert('transit_transfer',$insertPartnerToFM);

            $updatePartnerToFM['note'] = $insertPartnerToFM['note'];
            $updatePartnerToFM['status'] = $this->transit_transfer_status['Canceled'];

            $this->general_model->updatemy('transit_transfer','id',$partner_ref_id,$updatePartnerToFM);
            $this->general_model->updatemy('transit_transfer','id',$client_ref_id,$updatePartnerToFM);

            $returnData['countTransfer'] = 1;
            $returnData['result'] = $transfer;

            return $returnData;
        } else {
            $updatePartnerToClient['transaction_id'] = $transfer['PT']['Data']['transactionId'];
            $updatePartnerToClient['status'] = $this->transit_transfer_status['Success']; // success

            $this->general_model->updatemy('transit_transfer','id',$partner_ref_id,$updatePartnerToClient);
        }

        // Transfer from Client to Forexmart
        $transfer['CL'] = FXPP::PayCo_WalletTransfer($clientToFM);

        if ($transfer['CL']['Message'] !== 'Success') {
            // Repeat transfer from Client to Forexmart

            $transfer['CL_return'] = FXPP::PayCo_WalletTransfer($clientToFM);

            if ($transfer['CL_return']['Message'] !== 'Success') {
                $returnData['countTransfer'] = 2;

                // Must send an immediate mail to supports to return back transferred amount
                $cToFmContent['title'] = 'Return Transit Transfer [Client-ForexMart] Failed';
                $cToFmContent['table'] = $content['table'];
                $cToFmContent['paragraph'] = '<p style="font-size: 16px;">Return Transit Transfer from Client to ForexMart failed. Please immediately process transfer on Admin Panel to return the transferred money.</p>
                                              <p style="font-size: 16px;"> Below is the details of transfer:</p>';
                $cToFM_mail['subject'] = 'Transit Transfer - Failed Return Transfer';
                $cToFM_mail['content'] = Fx_mailer::custom_transit_transfer($cToFmContent);

                $this->sendMail($cToFM_mail);
            }

            $updateClientToFM['note'] = 'Failed - ' . $transfer['CL']['Message'];
            $updateClientToFM['status'] = $this->transit_transfer_status['Failed'];

            $this->general_model->updatemy('transit_transfer','id',$client_ref_id,$updateClientToFM);

            return $returnData;
        }

        if ($transfer['CL']['Message'] === 'Success') {
            $updateClientToFM['transaction_id'] = $transfer['CL']['Data']['transactionId'];
            $updateClientToFM['status'] = $this->transit_transfer_status['Success'];

            $CLtoFM_id = $client_ref_id;
            $this->general_model->updatemy('transit_transfer','id',$client_ref_id,$updateClientToFM);

            $cToFmContent['title'] = 'Transit Transfer Successful';
            $cToFmContent['table'] = $content['table'];
            $cToFmContent['paragraph'] = '<p>Visit this <a href="https://m7.forexmart.com/administration/manage-transfer-queue">page</a> on Admin Panel for more info.</p>
                                          <p style="font-size: 16px;">Transit transfer details:</p>';

            $cToFM_mail['subject'] = 'Transit Transfer - Successful Transfer';
            $cToFM_mail['content'] = Fx_mailer::custom_transit_transfer($cToFmContent);

            $this->sendMail($cToFM_mail);

            /***************************************************WEBSERVICE******************************************************/

            $new_date = new DateTime();
            $generated_transaction_number = $new_date->getTimestamp();
            $comment = $this->comment_type['withdraw'] . $this->comment_transaction_type['TRANSIT_TRANSFER'] . $generated_transaction_number;

            $service_data = array(
                'Amount' => $data['amount'],
                'Comment' => $comment,
                'Receiver' => 0,
                'AccountNumber' => $partner_account_number,
                'ProcessByIP' => $this->input->ip_address(),
            );

            $webservice_config = array(
                'server' => 'live_new'
            );

            // Withdraw from Partner's ForexMart Account
            $WebService = new WebService($webservice_config);
//            $WebService->WithdrawRealFund($service_data);

            if(IPLoc::APIUpgradeDevIP()){
                $res = FXPP::WithdrawRealFund($partner_account_number,$data['amount'],$comment,1);
                $wStatus = $res['requestResult'];
                $wTicket = $res['ticket'];
            }else{
                $WebService->WithdrawRealFund($service_data);;
                $wStatus = $WebService->request_status;
                $wTicket =  $WebService->get_result('Ticket');
            }

            $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));

            $transfer['WebService'] = $service_data;

            if ($wStatus != 'RET_OK') {

                $apiLogs = array(
                    'Account_number' => $partner_account_number,
                    'UserId' => $partner_user_id,
                    'Amount' => $data['amount'],
                    'ApiStatus' => $WebService->request_status,
                    'Date' => $date,
                    'WithdrawableFunds' => $WebService->get_result('Balance'),
                );
                $this->general_model->insert('withdraw_api_logs', $apiLogs);
            } else {

                $result = $WebService->result;

                $WebService2 = new WebService($webservice_config);
                $WebService2->request_live_account_balance($partner_account_number);

                if( $WebService2->request_status === 'RET_OK' ) {
                    $balance = $WebService2->get_result('Balance');
                    $this->account_model->updateAccountBalance($partner_account_number, $balance);

                    // Deposit to Client's ForexMart Account
//                    $WebService = new WebService($webservice_config);
                    $account_number = $client_acc_num;

//                    if(IPLoc::APIUpgradeDevIP()){
                        $res = FXPP::DepositRealFund($account_number, $converted_amount, 'DPST_' . $this->comment_transaction_type['TRANSIT_TRANSFER'] . $transfer['CL']['Data']['transactionId']);
                        $dStatus = $res['requestResult'];
                        $dTicket = $res['ticket'];
//                    }else{
//                        $WebService->update_live_deposit_balance($account_number, $converted_amount, 'DPST_' . $this->comment_transaction_type['TRANSIT_TRANSFER'] . $transfer['CL']['Data']['transactionId']);
//                        $dStatus = $WebService->request_status;
//                        $dTicket = $WebService->get_result('Ticket');
//                    }

                    if ($dStatus === 'RET_OK') {
                        $deposit_ticket = $dTicket;
                        $transfer['WebService']['ConvertedAmount'] = $converted_amount;
                        $WebService2 = new WebService($webservice_config);
                        $WebService2->request_live_account_balance($account_number);
                        if ($WebService2->request_status === 'RET_OK') {
                            $balance = $WebService2->get_result('Balance');
                            $this->account_model->updateAccountBalance($account_number, $balance);
                        }
                    }

                    $note['note'] = 'WITHDRAW_MT_TICKET_' . $wTicket . ' - DEPOSIT_MT_TICKET_ ' . $dTicket;

                    $this->general_model->updatemy('transit_transfer','id',$CLtoFM_id,$note);
                    $this->general_model->updatemy('transit_transfer','id',$fm_ref_id,$note);
                    $this->general_model->updatemy('transit_transfer','id',$partner_ref_id,$note);
                }
            }

        }

        $returnData['error'] = false;
        $returnData['errorMsg'] = 'success';
        $returnData['result'] = $transfer;
        $returnData['countTransfer'] = 3;

        return $returnData;
    }

    public function paycoWalletTransferModifiedNew($data, $type) {
        ini_set('max_execution_time', 600);
        $this->load->library('Fx_mailer');
        $this->load->model('partners_model');
        // Return data
        $returnData = array(
            'error' => true,
            'errorMsg' => 'Transit Transfer failed. Please contact our support for more information.',
            'countTransfer' => 0,
        );

        // Partner Account Number
        $partner_info = $data['partner_account_number'];
        $partner_account_number = $partner_info['reference_num'];
        $partner_user_id = $data['partner_user_id'];

        // Client Account Number
        $client_acc_num = $data['client_account_number'];
        $client_user_id = $data['client_user_id'];


        $its_type = $data['its_type'];




        $isMicro = $this->account_model->isMicro($client_user_id);

        // Converted amount, current date and currency
        $client_currency = $data['client_currency'];
        $partner_currency = $partner_info['currency'];
        $payco_currency = 'USD';

        if ($client_currency === $partner_currency) {
            $converted_amount = $data['amount'];
        } else {
            $converted_amount = $this->amountConverter($data['amount'], $partner_info['currency'], $client_currency);
        }


        // Send mail to Support to notify them that Partner is about to transfer and let them check the progress of transfer
       /* $transfer_Amount =  $data['amount'];
        $client_currency_2  = $client_currency;
        $converted_amount_1 = $converted_amount;

        if ($isMicro && $type === 'partner') { //sender is partner and reciever is micro client
            $client_currency_2 = $client_currency . 'c';
            $transfer_Amount = $data['amount'] / 100;
        }else if ($isMicro && $type === 'client') { //sender is partner and reciever is micro client
            $client_currency_2 = $client_currency . 'c';
            $converted_amount_1  = $data['converted_amount_micro']; //request from micro
        }*/


       /* $content['title'] = 'Transit Transfer - Accessed by Partner Account ['.$partner_account_number.']';
        $content['table'] = array(
            'Partner Account:'      =>  $partner_account_number . ' [' . $partner_info['currency'] . ']',
            'Client Account:'       =>  $client_acc_num . ' [' . $client_currency_2 . ']',
            'Amount to transfer:'   =>  $transfer_Amount . ' ' . $partner_info['currency'],
            'Converted amount:'     =>  $converted_amount_1 . ' ' . $client_currency_2,
        );*/


        /**************************************Reseller Data**************************************/

        // Partner transfer to Client
        $account_numbers = array(
            'sender'        =>  $type === 'partner' ? $partner_account_number : $client_acc_num,
            'receiver'      =>  $type === 'partner' ? $client_acc_num : $partner_account_number,
            'amount'        =>  $data['amount'],
            'currency'      =>  $payco_currency,
        );

        $date = new DateTime();
        $generated_transaction_number = $date->getTimestamp();

        $save_transit = array(
            'status'            =>  $this->transit_transfer_status['Pending'],
            'sender'            =>  $account_numbers['sender'],
            'receiver'          =>  $account_numbers['receiver'],
            'amount_transfer'   =>  $data['amount'],
            'conv_amount'       =>  $converted_amount,
            'date_transfer'     =>  date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
            'referral_id'       =>  $generated_transaction_number,
            'request_from_affiliate' => $type === 'partner' ? 0 : 1,
            'transaction_type'         => $data['transaction_type'],

        );

        $reference_id = $this->general_model->insert('transit_transfer',$save_transit);


        /*************************************Save to Transit Transfer Table*************************************/


        $updatePartnerToClient['transaction_id'] = $generated_transaction_number;
        $updatePartnerToClient['status'] = $this->transit_transfer_status['Success']; // success

        if($its_type <> 1) { // request fund from affiliates only
            if ($data['for_approval']) {
                $updatePartnerToClient['status'] = $this->transit_transfer_status['Verifying']; // In admin fund transfer queue
            }
        }

        /*$cToFmContent['title'] = 'Transit Transfer Successful';
        $cToFmContent['table'] = $content['table'];
        $cToFmContent['paragraph'] = '<p>Visit this <a href="https://m7.forexmart.com/administration/manage-transfer-queue">page</a> on Admin Panel for more info.</p>
                                      <p style="font-size: 16px;">Transit transfer details:</p>';

        $cToFM_mail['subject'] = 'Transit Transfer - Successful Transfer';
        $cToFM_mail['content'] = Fx_mailer::custom_transit_transfer($cToFmContent);*/

        /***************************************************WEBSERVICE******************************************************/
        //type = partner => sender is partner | reciever is client
        //type = client => sender is client | reciever is partner

        $withdraw_from_account = $type === 'partner' ? $partner_account_number : $client_acc_num;
        $withdraw_from_uid = $type === 'partner' ? $partner_user_id : $client_user_id;

        $deposit_to_uid = $type === 'partner' ? $partner_user_id : $client_user_id;
        $deposit_to_account = $type === 'partner' ? $client_acc_num : $partner_account_number;

        $comment = $this->comment_type['withdraw'] . $this->comment_transaction_type['TRANSIT_TRANSFER'] . $deposit_to_account .'_'. $generated_transaction_number;
        $withdraw_amount = $type === 'partner' ? $data['amount'] : $converted_amount;


        if ($isMicro && $type === 'partner') { //sender is partner and receiver is micro client
            $withdraw_amount = $withdraw_amount / 100;
        }else if ($isMicro && $type === 'client') { //sender is micro client and receiver is partner
            $withdraw_amount = $data['converted_amount_micro']; //request from micro
        }


        $service_data = array(
            'Amount' => $withdraw_amount,
            'Comment' => $comment,
            'Receiver' => 0,
            'AccountNumber' => $withdraw_from_account,
            'ProcessByIP' => $this->input->ip_address(),
        );

        $webservice_config = array('server' => 'live_new');

        // Withdraw from Partner's ForexMart Account
        $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
        $transfer['WebService'] = $service_data;

      //  if(IPLoc::APIUpgradeDevIP()){
            $res = FXPP::WithdrawRealFund($withdraw_from_account,$withdraw_amount,$comment,0);
            $wStatus = $res['requestResult'];
            $wTicket = $res['ticket'];
       /* }else{
            $WebService_Withdraw = new WebService($webservice_config);
            $WebService_Withdraw->WithdrawRealFund($service_data);
            $wStatus = $WebService_Withdraw->request_status;
            $wTicket =  $WebService_Withdraw->get_result('Ticket');
        }*/

        if ($wStatus != 'RET_OK') {
            $apiLogs = array(
                'Account_number' => $withdraw_from_account,
                'UserId' => $withdraw_from_uid,
                'Amount' => $withdraw_amount,
                'ApiStatus' => $wStatus,
                'Date' => $date,
                'WithdrawableFunds' =>0,
            );
            $this->general_model->insert('withdraw_api_logs', $apiLogs);

            switch ($wStatus) {
                case 'RET_NOT_ENOUGH_FUND':
                case 'RET_INSUFFICIENT_FUNDS':
//                    $WebService_checkFunds = new WebService($webservice_config);
//                    $WebService_checkFunds->RequestAccountFunds($withdraw_from_account);
//                    $result = $WebService_checkFunds->result;

                    if(IPLoc::APIUpgradeDevIP()){

                        $this->load->library('WSV'); //New web service
                        $WSV = new WSV();
                        $WebService_checkFunds = $WSV->GetAccountFunds($withdraw_from_account);

                        if($WebService_checkFunds->request_status === "RET_OK"){
                            $result = $WebService_checkFunds->result;
                        }

                    }else{

                        $WebService_checkFunds= new WebService($webservice_config);
                        $WebService_checkFunds->RequestAccountFunds($withdraw_from_account);

                        $result = $WebService_checkFunds->result;

                    }

                    if ($result['Withrawable_BonusFund'] > 0) {
                        $returnData['errorMsg'] = 'Account Number '. $withdraw_from_account .' has insufficient funds to transfer. Withrawable Real Fund Amount: '. $result['Withrawable_RealFund'];
                    } else {
                        $returnData['errorMsg'] = 'Account Number '. $withdraw_from_account .' has insufficient funds to transfer.';
                    }
                    break;
                default:
                    $returnData['errorMsg'] = 'Transit Transfer failed. Please contact our support for more information.';
            }

            $note['note'] = $returnData['errorMsg'];
        } else {
            $returnData['error'] = false;
            $returnData['errorMsg'] = 'success';

          //  $result = $WebService_Withdraw->result;

            $WebService_Update_Balance1 = new WebService($webservice_config);
            $WebService_Update_Balance1->request_live_account_balance($withdraw_from_account);

            if( $WebService_Update_Balance1->request_status === 'RET_OK' ) {
                $balance1 = $WebService_Update_Balance1->get_result('Balance');
                if ($type === 'partner') {
                    $this->account_model->updateAccountBalance_partner($withdraw_from_account, $balance1);
                } else {
                    $this->account_model->updateAccountBalance($withdraw_from_account, $balance1);
                    //if(IPLoc::OnlyTest()){
//                        FXPP::updateAccountTradingStatus($withdraw_from_account,$withdraw_from_uid,$balance1);
                   // }
                    if(IPLoc::APIUpgradeDevIP()){
                        FXPP::updateAccountTradingStatusV2($withdraw_from_account,$withdraw_from_uid,$balance1); // for pro accounts
                    }else{
                        FXPP::updateAccountTradingStatus($withdraw_from_account,$withdraw_from_uid,$balance1); // for pro accounts
                    }
                }

                $transfer['client_deduct_amount'] = $withdraw_amount;

                // Bonus Cancellation for client accounts [Request from Cleint Type]

                if ($type == 'client') {  // client to partner only
                    ### Remove Bonus From client account number ###
                    $removeBonusArray = array(
                        'Account_number'  => $withdraw_from_account,
                        'UserId'          => $withdraw_from_uid,
                        'Amount'          => $withdraw_amount,
                        'Amount_deducted' => $withdraw_amount,
                        'TransactionId'   => $generated_transaction_number,
                        'TransactionType' => 'ITS Transfer'
                    );

                        $Transaction = new Transaction();
                        $Transaction->RemoveBonus($removeBonusArray);
                    ### Remove Bonus From Source account number ###

                }


                   $deposit_amount = $type === 'partner' ? $converted_amount : $data['amount'];
                    $transfer['WebService']['ConvertedAmount'] = $converted_amount;

                    $this->general_model->updatemy('transit_transfer','id',$reference_id,$updatePartnerToClient);

                    $transfer['partner_transfer_amount'] = $deposit_amount;
                    $transfer['transaction_id'] = $generated_transaction_number;
                    $note['note'] = 'WITHDRAW_MT_TICKET_' . $wTicket . ' - DEPOSIT_MT_TICKET_ ';

                   // $this->sendMail($cToFM_mail);

            }else if($WebService_Update_Balance1->request_status != 'RET_OK') {

                $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
                $apiLogs = array(
                    'Account_number' => $withdraw_from_account,
                    'UserId' => $withdraw_from_uid,
                    'Amount' => $withdraw_amount,
                    'ApiStatus' => $WebService_Update_Balance1->request_status,
                    'Date' => $date,
                    'MethodName' => '(Sender) RequestAccountBalance',
                );
                $this->general_model->insert('api_methods_logs', $apiLogs);

                $returnData['errorMsg'] = 'Transit Transfer failed. Please contact our support for more information.';
                $note['note'] = 'API STATUS: ' . $WebService_Update_Balance1->request_status . ' Failed Transaction (RequestAccountBalance).';
                $this->general_model->updatemy('transit_transfer','referral_id',$generated_transaction_number,$note);

            }
        }

        $this->general_model->updatemy('transit_transfer','id',$reference_id,$note);

        $returnData['result'] = $transfer;
        $returnData['test'] = $wStatus;

        return $returnData;
    }

    public function paycoWalletTransferModified($data, $type) {
        ini_set('max_execution_time', 600);
        $this->load->library('Fx_mailer');
        $this->load->model('partners_model');
        // Return data
        $returnData = array(
            'error' => true,
            'errorMsg' => 'The Transfer failed. Please contact our support for more information.',
            'countTransfer' => 0,
        );

        // Partner Account Number
        $partner_info = $data['partner_account_number'];
        $partner_account_number = $partner_info['reference_num'];
        $partner_user_id = $data['partner_user_id'];

        // Client Account Number
        $client_acc_num = $data['client_account_number'];
        $client_user_id = $data['client_user_id'];


        $its_type = $data['its_type'];




        $isMicro = $this->account_model->isMicro($client_user_id);

        // Converted amount, current date and currency
        $client_currency = $data['client_currency'];
        $partner_currency = $partner_info['currency'];
        $payco_currency = 'USD';

        if ($client_currency === $partner_currency) {
            $converted_amount = $data['amount'];
        } else {
            $converted_amount = $this->amountConverter($data['amount'], $partner_info['currency'], $client_currency);
        }


        // Send mail to Support to notify them that Partner is about to transfer and let them check the progress of transfer
        $transfer_Amount =  $data['amount'];
        $client_currency_2  = $client_currency;
        $converted_amount_1 = $converted_amount;

        if ($isMicro && $type === 'partner') { //sender is partner and reciever is micro client
            $client_currency_2 = $client_currency . 'c';
            $transfer_Amount = $data['amount'] / 100;
        }else if ($isMicro && $type === 'client') { //sender is partner and reciever is micro client
            $client_currency_2 = $client_currency . 'c';
            $converted_amount_1  = $data['converted_amount_micro']; //request from micro
        }


        $content['title'] = 'The Transfer - Accessed by Partner Account ['.$partner_account_number.']';

        if ($type === 'client') {
            $direction =  "From Client ".$client_acc_num. " to  Client  ".$partner_account_number;
            $clientMsg = 'Dear client,<br>  You received the  transfer from account '.$client_acc_num.' to your account '.$partner_account_number;
            $partnerMsg = 'Dear partner,<br> You have sent the request for  transfer from  account '.$client_acc_num.' to your account '.$partner_account_number ;

        }else{
            $direction =  "From Partner ".$partner_account_number. " to  Client  ".$client_acc_num;
            $clientMsg = 'Dear client,<br>  You received the  transfer from account '.$partner_account_number.' to your account '.$client_acc_num;
            $partnerMsg = 'Dear partner,<br> You have sent the request for  transfer from your account '.$partner_account_number.' to account '.$client_acc_num ;

        }

        $content['table'] = array(
            'IB’s Account:'      =>  $partner_account_number . ' [' . $partner_info['currency'] . ']',
            'Referral’s Account:'       =>  $client_acc_num . ' [' . $client_currency_2 . ']',
            'Amount:'   =>  $transfer_Amount,
            'Currency:' =>  $partner_info['currency'],
            'Converted amount:'     =>  $converted_amount_1 . ' ' . $client_currency_2,
            'Direction:'=> $direction,
            'Order Time (UTC+3):' => date('Y-m-d H:i:s'),

        );



        /**************************************Reseller Data**************************************/

        // Partner transfer to Client
        $account_numbers = array(
            'sender'        =>  $type === 'partner' ? $partner_account_number : $client_acc_num,
            'receiver'      =>  $type === 'partner' ? $client_acc_num : $partner_account_number,
            'amount'        =>  $data['amount'],
            'currency'      =>  $payco_currency,
        );

        $date = new DateTime();
        $generated_transaction_number = $date->getTimestamp();

        $save_transit = array(
            'status'            =>  $this->transit_transfer_status['Pending'],
            'sender'            =>  $account_numbers['sender'],
            'receiver'          =>  $account_numbers['receiver'],
            'amount_transfer'   =>  $data['amount'],
            'conv_amount'       =>  $converted_amount,
            'date_transfer'     =>  date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
            'referral_id'       =>  $generated_transaction_number,
            'request_from_affiliate' => $type === 'partner' ? 0 : 1,
            'bonus_type'         => $type === 'partner' ? $data['bonus_type'] : 'none',
            'transaction_type'         => $data['transaction_type'],
        );

        $reference_id = $this->general_model->insert('transit_transfer',$save_transit);


        /*************************************Save to Transit Transfer Table*************************************/




        $updatePartnerToClient['transaction_id'] = $generated_transaction_number;
        $updatePartnerToClient['status'] = $this->transit_transfer_status['Success']; // success


        $cToFmContent['title'] = 'The Transfer Successful';
        $cToFmContent['table'] = $content['table'];
        $cToFmContent['paragraph'] = '<p>Visit this <a href="https://m7.forexmart.com/administration/manage-transfer-queue">page</a> on Admin Panel for more info.</p>
                                      <p style="font-size: 16px;">The transfer details:</p>';

        $cToFM_mail['subject'] = 'The Transfer - Successful Transfer';
        $cToFM_mail['content'] = Fx_mailer::custom_transit_transfer($cToFmContent);

        /***************************************************WEBSERVICE******************************************************/
        //type = partner => sender is partner | reciever is client
        //type = client => sender is client | reciever is partner

        $withdraw_from_account = $type === 'partner' ? $partner_account_number : $client_acc_num;
        $withdraw_from_uid = $type === 'partner' ? $partner_user_id : $client_user_id;

        $deposit_to_uid = $type === 'partner' ? $partner_user_id : $client_user_id;
        $deposit_to_account = $type === 'partner' ? $client_acc_num : $partner_account_number;

        $comment = $this->comment_type['withdraw'] . $this->comment_transaction_type['TRANSIT_TRANSFER'] . $deposit_to_account .'_'. $generated_transaction_number;
        $withdraw_amount = $type === 'partner' ? $data['amount'] : $converted_amount;


        if ($isMicro && $type === 'partner') { //sender is partner and receiver is micro client
            $withdraw_amount = $withdraw_amount / 100;
        }else if ($isMicro && $type === 'client') { //sender is micro client and receiver is partner
            $withdraw_amount = $data['converted_amount_micro']; //request from micro
        }


     


        $service_data = array(
            'Amount' => $withdraw_amount,
            'Comment' => $comment,
            'Receiver' => 0,
            'AccountNumber' => $withdraw_from_account,
            'ProcessByIP' => $this->input->ip_address(),
        );

        $webservice_config = array('server' => 'live_new');
        $transfer['WebService'] = $service_data;



        $res = FXPP::WithdrawRealFund($withdraw_from_account,$withdraw_amount,$comment,1);
        $wStatus = $res['requestResult'];
        $wTicket = $res['ticket'];


       // if(IPLoc::StatusTask()){
       
       /* }else{
            // Withdraw from Partner's ForexMart Account
            $WebService_Withdraw = new WebService($webservice_config);
            $WebService_Withdraw->WithdrawRealFund($service_data);
            $wStatus = $WebService_Withdraw->request_status;
            $wTicket =  $WebService_Withdraw->get_result('Ticket');
       }*/


        $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));

        if ($wStatus != 'RET_OK') {
            $apiLogs = array(
                'Account_number' => $withdraw_from_account,
                'UserId' => $withdraw_from_uid,
                'Amount' => $withdraw_amount,
                'ApiStatus' =>$wStatus,
                'Date' => $date,
                'WithdrawableFunds' =>0,
            );
            $this->general_model->insert('withdraw_api_logs', $apiLogs);

            switch ($wStatus) {
                case 'RET_INSUFFICIENT_FUNDS':
                case 'RET_NOT_ENOUGH_FUND':
                    if(IPLoc::APIUpgradeDevIP()){

                        $this->load->library('WSV'); //New web service
                        $WSV = new WSV();
                        $WebService_checkFunds = $WSV->GetAccountFunds($withdraw_from_account);

                        if($WebService_checkFunds->request_status === "RET_OK"){
                            $result = $WebService_checkFunds->result;
                        }

                    }else{

                        $WebService_checkFunds= new WebService($webservice_config);
                        $WebService_checkFunds->RequestAccountFunds($withdraw_from_account);

                        $result = $WebService_checkFunds->result;

                    }

                    if ($result['Withrawable_BonusFund'] > 0) {
                        $returnData['errorMsg'] = 'Account Number '. $withdraw_from_account .' has insufficient funds to transfer. Withrawable Real Fund Amount: '. $result['Withrawable_RealFund'];
                    } else {
                        $returnData['errorMsg'] = 'Account Number '. $withdraw_from_account .' has insufficient funds to transfer.';
                    }
                    break;
                default:
                    $returnData['errorMsg'] = 'The Transfer failed. Please contact our support for more information.';
            }

            $note['note'] = $returnData['errorMsg'];
        } else {
            $returnData['error'] = false;
            $returnData['errorMsg'] = 'success';

            //$result = $WebService_Withdraw->result;

            /* $WebService_Update_Balance1 = new WebService($webservice_config);
              $WebService_Update_Balance1->request_live_account_balance($withdraw_from_account);

              if( $WebService_Update_Balance1->request_status === 'RET_OK' ) {
                $balance1 = $WebService_Update_Balance1->get_result('Balance');
                 if ($type === 'partner') {
                     $this->account_model->updateAccountBalance_partner($withdraw_from_account, $balance1);
                 } else {
                     $this->account_model->updateAccountBalance($withdraw_from_account, $balance1);
               */

                    if(IPLoc::APIUpgradeDevIP()){
                        FXPP::updateAccountTradingStatusV2($withdraw_from_account,$withdraw_from_uid); // for pro accounts
                    }else{
                        FXPP::updateAccountTradingStatus($withdraw_from_account,$withdraw_from_uid); // for pro accounts
                    }

                //}

                $transfer['client_deduct_amount'] = $withdraw_amount;

                // Bonus Cancellation for client accounts [Request from Cleint Type]
//                if(IPLoc::IPOnlyForMe()) {
                    if ($type <> 'partner') {  // client to partner only
                        ### Remove Bonus From client account number ###
                        $removeBonusArray = array(
                            'Account_number'  => $withdraw_from_account,
                            'UserId'          => $withdraw_from_uid,
                            'Amount'          => $withdraw_amount,
                            'Amount_deducted' => $withdraw_amount,
                            'TransactionId'   => $generated_transaction_number,
                            'TransactionType' => 'ITS Transfer'
                        );

                        $Transaction = new Transaction();
                        $Transaction->RemoveBonus($removeBonusArray);
                        ### Remove Bonus From Source account number ###

                    }
//                }

                $deposit_amount = $type === 'partner' ? $converted_amount : $data['amount'];

                // Deposit to Client or Partner ForexMart Account
                $WebService_Deposit = new WebService($webservice_config);
                $account_number = $type == 'partner' ? $client_acc_num : $partner_account_number;

               // if(IPLoc::APIUpgradeDevIP()){
                    $res = FXPP::DepositRealFund($account_number,$deposit_amount,'DPST_' . $this->comment_transaction_type['TRANSIT_TRANSFER'] . $withdraw_from_account .'_'. $generated_transaction_number);
                    $dStatus = $res['requestResult'];
                    $dTicket = $res['ticket'];
                /*}else{
                    $WebService_Deposit->update_live_deposit_balance($account_number, $deposit_amount, 'DPST_' . $this->comment_transaction_type['TRANSIT_TRANSFER'] . $withdraw_from_account .'_'. $generated_transaction_number);
                    $dStatus = $WebService_Deposit->request_status;
                    $dTicket = $WebService_Deposit->get_result('Ticket');
                }*/

                if ($dStatus === 'RET_OK') {
                    $deposit_ticket = $dTicket;
                    $transfer['WebService']['ConvertedAmount'] = $converted_amount;

                    $this->general_model->updatemy('transit_transfer','id',$reference_id,$updatePartnerToClient);

                    $transfer['partner_transfer_amount'] = $deposit_amount;
                    $transfer['transaction_id'] = $generated_transaction_number;
                    $note['note'] = 'WITHDRAW_MT_TICKET_' . $wTicket . ' - DEPOSIT_MT_TICKET_ ' . $deposit_ticket;

                   /* $WebService_Update_Balance2 = new WebService($webservice_config);
                    $WebService_Update_Balance2->request_live_account_balance($account_number);
                    if ($WebService_Update_Balance2->request_status === 'RET_OK') {
                        $balance2 = $WebService_Update_Balance2->get_result('Balance');*/
                        if ($type === 'partner') {
                           // $this->account_model->updateAccountBalance($account_number, $balance2);

                            if(IPLoc::APIUpgradeDevIP()){
                                FXPP::updateAccountTradingStatusV2($account_number,$deposit_to_uid); // for pro accounts
                            }else{
                                FXPP::updateAccountTradingStatus($account_number,$deposit_to_uid); // for pro accounts
                            }
                        }
//                        } else {
//                            $this->account_model->updateAccountBalance_partner($account_number, $balance2);
//                        }
                   /* }else if($WebService_Update_Balance2->request_status != 'RET_OK'){

                        $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
                        $apiLogs = array(
                            'Account_number' => $account_number,
                            'UserId' => $deposit_to_uid,
                            'Amount' => $deposit_amount,
                            'ApiStatus' => $WebService_Update_Balance2->request_status,
                            'Date' => $date,
                            'MethodName' => '(Receiver) RequestAccountBalance',
                        );
                        $this->general_model->insert('api_methods_logs', $apiLogs);

                    }*/

                    $this->sendMail($cToFM_mail);




                        $cToFM_mail['content'] = Fx_mailer::custom_transit_transfer($cToFmContent,0,$clientMsg);
                        $verifyClient = $this->general_model->showssingle('users','id',$data['client_user_id'],'email');
                        $cToFM_mail['to_email'] = $verifyClient['email']; // client email address
                        $this->sendTransactionDetails($cToFM_mail);
                        $cToFM_mail['content'] = Fx_mailer::custom_transit_transfer($cToFmContent,0,$partnerMsg);

                        $cToFM_mail['to_email'] = $this->session->userdata('email'); // partner email adderess
                        $this->sendTransactionDetails($cToFM_mail);




                }else if($dStatus != 'RET_OK'){

                    $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
                    $apiLogs = array(
                        'Account_number' => $account_number,
                        'UserId' => $deposit_to_uid,
                        'Amount' => $deposit_amount,
                        'ApiStatus' => $dStatus,
                        'Date' => $date,
                        'MethodName' => 'DepositRealFund',
                    );
                    $this->general_model->insert('api_methods_logs', $apiLogs);

                    $note['note'] = 'API STATUS: ' . $dStatus . ' Failed Transaction (DepositRealFund).';
                    $this->general_model->updatemy('transit_transfer','referral_id',$generated_transaction_number,$note);
                    $returnData['errorMsg'] = 'Transit Transfer failed. Please contact our support for more information.';

                }

                        // Auto Bonus Crediting
                    if ($type === 'partner') {  // partner to client only
                        if ($data['bonus_type'] == 'tpb') {
                            FXPP::DepositBonus($data['client_user_id'], $account_number, $deposit_amount, 'ITS', $data['bonus_type'], $generated_transaction_number);
                        }
                        if ($data['bonus_type'] == 'twpb') {
                            FXPP::DepositBonus($data['client_user_id'], $account_number, $deposit_amount, 'ITS', 'twpb', $generated_transaction_number);
                        }
                        
                        //FXPP-13577
                        if(FXPP::isSpecailTransitTransferPartner()){                            
                        
                            if ($data['bonus_type'] == 'fpb') {
                               FXPP::DepositBonus($data['client_user_id'], $account_number, $deposit_amount, 'ITS', 'fpb', $generated_transaction_number);
                           }
                        }
                    }

                   // Auto NDB Bonus Cancellation to receiver account
                if ($type === 'partner') {  // partner to client only
                    $RequestLogintype = $this->account_model->getAccountLoginType($data['client_user_id']);
                    $bonuses = FXPP::getAccountBonusByType($account_number);
                    if ($RequestLogintype['login_type'] != 1) {
                        if ($deposit_amount > 0 AND $bonuses[2] > 0) {
                            FXPP::BonusProfitCancellation($data['client_user_id'], $account_number, $deposit_amount, $generated_transaction_number);
                        }
                    }
                }


            /*}else if($WebService_Update_Balance1->request_status != 'RET_OK') {

                $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
                $apiLogs = array(
                    'Account_number' => $withdraw_from_account,
                    'UserId' => $withdraw_from_uid,
                    'Amount' => $withdraw_amount,
                    'ApiStatus' => $WebService_Update_Balance1->request_status,
                    'Date' => $date,
                    'MethodName' => '(Sender) RequestAccountBalance',
                );
                $this->general_model->insert('api_methods_logs', $apiLogs);

                $returnData['errorMsg'] = 'Transit Transfer failed. Please contact our support for more information.';
                $note['note'] = 'API STATUS: ' . $WebService_Update_Balance1->request_status . ' Failed Transaction (RequestAccountBalance).';
                $this->general_model->updatemy('transit_transfer','referral_id',$generated_transaction_number,$note);

            }*/
        }

        $this->general_model->updatemy('transit_transfer','id',$reference_id,$note);

        $returnData['result'] = $transfer;
        $returnData['test'] = $wStatus;

        return $returnData;
    }


    public function paycoTransfer($data) {
        $success = '';
        $result = array();

        $array = array(
            'sender'        =>  $data['receiver'],
            'receiver'      =>  $data['sender'],
            'username'      =>  $data['username'],
            'password'      =>  $data['password'],
            'merchant_id'   =>  $data['merchant_id'],
            'pin'           =>  $data['pin'],
            'amount'        =>  $data['amount'],
            'currency'      =>  'USD',
        );

        while ($success != 'Success') {
            $result = FXPP::PayCo_WalletTransfer($array);
            $success = $result['Message'];
        }

        return $result;
    }

    public function checkWalletAccNumAndResellerData() {
        if (!$this->input->is_ajax_request()) {
            die('Not authorized!');
        }
        if ($this->session->userdata('logged')) {
            $this->load->model('user_model');

            $returnData = array(
                'p_wallet'          =>  array('error' => true,'error_message' => 'does not exist'),
                'c_wallet'          =>  array('error' => true,'error_message' => 'does not exist'),
                'c_fm_account'      =>  array('error' => true,'error_message' => 'does not exist'),
                'c_verify'          =>  array('error' => true,'error_message' => 'not verified'),
            );

            $partner_wallet = $this->input->post('partner_wallet');
            $p = $this->getPaycoWalletAndResellerData($partner_wallet, $this->session->userdata('user_id'), '');
            if ($p === true) {
                $returnData['p_wallet']['error'] = false;
                $returnData['p_wallet']['error_message'] = '';
            } else {
                $returnData['p_wallet']['error_message'] = $p;
            }

            $client_wallet = $this->input->post('client_wallet');
            $client_account_num = $this->input->post('client_account_num');
            $check_acc_num = $this->user_model->getUserIdbyAccountNumber($client_account_num);

            if ($check_acc_num) {
                $returnData['c_fm_account']['error'] = false;
                $returnData['c_fm_account']['error_message'] = '';
            } else {
                $returnData['c_fm_account']['error_message'] = 'is a Partner account or does not exist';
            }

            $c = $this->getPaycoWalletAndResellerData($client_wallet, $check_acc_num[0]['user_id'], '');

            if ($c === true) {
                $returnData['c_wallet']['error'] = false;
                $returnData['c_wallet']['error_message'] = '';
            } else {
                $returnData['c_wallet']['error_message'] = $c . ' under Account Number ' . $client_account_num;
            }

            // Check if Client has a verified account
            $verifyClient = $this->general_model->showssingle('users','id',$check_acc_num[0]['user_id'],'accountstatus');
            if ($verifyClient) {
                if ($verifyClient['accountstatus'] == 0 || $verifyClient['accountstatus'] == 2) {
                    $returnData['c_verify']['error_message'] = 'Account '. $client_account_num .' is not verified. Please have them verified their account first to use Transit Transfer.';
                } else {
                    $returnData['c_verify']['error_message'] = '';
                    $returnData['c_verify']['error'] = false;
                }
            } else {
                $returnData['c_verify']['error_message'] = 'Account '. $client_account_num . ' does not exist.';
            }

            $returnData['test'] = $verifyClient;

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'return' => $returnData,
                    )
                )
            );
        }
    }

    function getPaycoWalletAndResellerData($wallet, $user_id, $getResult = "") {
        $result = $this->general_model->showssingle3('payco_reseller_data','wallet_number',$wallet,'user_id',$user_id,'*');
        if ($result) {
            if ($getResult != "") {
                return $result;
            } else {
                if ($result['currency'] === 'USD') {
                    return true;
                } else {
                    return 'is not with USD currency';
                }
            }
        }
        return 'does not exist';
    }

    public function checkSecurityCode() {
        if (!$this->input->is_ajax_request()) { die('Not authorized!'); }
        if (!$this->session->userdata('logged')) { redirect(''); }

        $this->load->model('user_model');
        $this->load->model('partners_model');

        $isSuccess = false;
        $message = lang('its_68');

        $security_code = trim($this->input->post('sec_code'));
        $client_account_num = $this->input->post('client_account_num');
        $client_info = $this->user_model->getUserIdbyAccountNumber($client_account_num);
        $client_user_id = $client_info[0]['user_id'];


//       if(IPLoc::Office()){
           $validate = $this->validate_transfer($client_info[0]['user_id']);
//       }else{
//           $validate = false;
//       }

       if($validate){
           $message =  'Your affiliate account have not receive any transfers nor made any deposits to his/her account.';
       }else{
           
           

               $get_security_codes = $this->partners_model->getAffiliateSecurityCodeByCode($security_code);
               if ($get_security_codes) {
                   if($get_security_codes['status'] > 0) {
                       $message =  'Security Code is already used.';
                   }else{
                       if ($get_security_codes['affiliate_user_id'] == $client_user_id) {
                           if (!$this->partners_model->getSecurityCodeOnTransitTransfer($security_code)) {
                               $isSuccess = true;
                               $message = '';
                           }else{
                               $message =  'Security Code is already used.';
                           } 
                       }else{
                           $message =  'You are requesting fund from an incorrect affiliate account.';
                       }
                   }
                   
               }else{
                   // Invalid security code
                   $message =  'Security Code is invalid.';
               }
               $full_name = $this->general_model->showssingle('user_profiles', 'user_id', $client_user_id, 'full_name,user_id');


          /*
               $get_security_codes = $this->partners_model->getAffiliateSecurityCodeByUserId($client_user_id);
               if ($get_security_codes) {
                   if ($get_security_codes['security_code'] == $security_code) {
                       if (!$this->partners_model->getSecurityCodeOnTransitTransfer($security_code)) {


                           $isSuccess = true;
                           $message = '';


                       } else {
                           $message =  lang('its_69');
                       }
                   }
               }
               $full_name = $this->general_model->showssingle('user_profiles', 'user_id', $client_user_id, 'full_name,user_id');*/


       }
           
           
  
        $this->output->set_content_type('application/json')
            ->set_output(
            json_encode(
                array(
                    'success'   =>  $isSuccess,
                    'message'   =>  $message,
                    'test'      =>  $client_account_num,
                    'full_name' =>  $full_name['full_name'],
                )
            )
        );
    }




    public function checkSecurityCodeAfterSubmit() {
        if (!$this->input->is_ajax_request()) { die('Not authorized!'); }
        if (!$this->session->userdata('logged')) { redirect(''); }

        $this->load->model('user_model');
        $this->load->model('partners_model');
        $isSuccess = false;
        $message = lang('its_68');

        $security_code = trim($this->input->post('sec_code'));
        $client_account_num = $this->input->post('client_account_num');
        $client_info = $this->user_model->getUserIdbyAccountNumber($client_account_num);
        $client_user_id = $client_info[0]['user_id'];

        $validate = $this->validate_transfer($client_info[0]['user_id']);

        if($validate){
            $message =  'Your affiliate account have not receive any transfers nor made any deposits to his/her account.';
        }else{
            $get_security_codes = $this->partners_model->getAffiliateSecurityCodeByUserId($client_user_id);
            if ($get_security_codes) {
                if ($get_security_codes['security_code'] == $security_code) {
                    if (!$this->partners_model->getSecurityCodeOnTransitTransfer($security_code)) {

                        $partner_user_id = $this->session->userdata('user_id');

                        /*   update security code  start  */
                        $update_security_code = array(
                            'partner_user_id'   =>  $partner_user_id,
                            'status'            =>  1,
                            'date_used'         =>  date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                        );
                        $this->general_model->updatemy('its_security_code','security_code',$security_code,$update_security_code);

                        /*   update security code  end  */


                        $isSuccess = true;
                        $message = '';


                    } else {
                        $message =  lang('its_69');
                    }
                }
            }
            $full_name = $this->general_model->showssingle('user_profiles', 'user_id', $client_user_id, 'full_name,user_id');
        }





        $this->output->set_content_type('application/json')
            ->set_output(
                json_encode(
                    array(
                        'success'   =>  $isSuccess,
                        'message'   =>  $message,
                        'test'      =>  $client_account_num,
                        'full_name' =>  $full_name['full_name'],
                    )
                )
            );
    }












        public function RequestWalletTransfer() {
        if (!$this->input->is_ajax_request()) { die('Not authorized!'); }
        if (!$this->session->userdata('logged')) { redirect(''); }

        $this->load->model('user_model');
        $this->load->model('partners_model');
        $this->load->library('Fx_mailer');

        $date = new DateTime();
        $security_code = $this->input->post('sec_code');
        $amount_requested = $this->input->post('requested_amount');

        $client_acc_num = $this->input->post('req_client');
        $client_info = $this->user_model->getUserIdbyAccountNumber($client_acc_num);
        $client_user_id = $client_info[0]['user_id'];
        $client_wallet = $this->partners_model->getTTPaycoWallet($client_user_id)['wallet_number'];

        $partner_user_id = $this->session->userdata('user_id');
        $partner_account = $this->partners_model->getAccountByUserId($partner_user_id);
        $partner_wallet = $this->partners_model->getTTPaycoWallet($partner_user_id)['wallet_number'];

        if ($client_info[0]['mt_currency_base'] == $partner_account['currency']) {
            $converted_amount = $amount_requested;
        } else {
            $converted_amount = $this->amountConverter($amount_requested, $partner_account['currency'], $client_info[0]['mt_currency_base']);
        }

        $transit_transfer = array(
            'transaction_id'                =>  0,
            'amount_transfer'               =>  $amount_requested,
            'conv_amount'                   =>  $converted_amount,
            'sender'                        =>  'CL-'.$client_wallet,
            'receiver'                      =>  'PT-'.$partner_wallet,
            'status'                        =>  $this->transit_transfer_status['Pending'],
            'referral_id'                   =>  $date->getTimestamp(),
            'request_from_affiliate'        =>  1,
            'security_code'                 =>  $security_code,
            'date_requested_from_affiliate' =>  date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
        );
        $this->general_model->insert('transit_transfer',$transit_transfer);

        // Send mail to notify partnership with the request
        $content['title'] = 'Transit Transfer Request - Partner Account ['.$partner_account['reference_num'].']';
        $content['table'] = array(
            'Partner Account:'      =>  $partner_account['reference_num'] . ' [' . $partner_account['currency'] . ']',
            'Partner PayCo Wallet:' =>  $partner_wallet,
            'Client Account:'       =>  $client_acc_num . ' [' . $client_info[0]['mt_currency_base'] . ']',
            'Client PayCo Wallet:'  =>  $client_wallet,
            'Amount Request:'       =>  $amount_requested . ' ' . $partner_account['currency'],
            'Converted amount:'     =>  $converted_amount . ' ' . $client_info[0]['mt_currency_base'],
        );

        $message_content['table'] = $content['table'];
        $message_content['paragraph'] = '<p style="font-size: 15px;">Partner Account Number '.$partner_account['reference_num'].' is requesting for fund transfer using Transit Transfer from Account Number ' . $client_acc_num . '. Please see more details below and visit this <a href="https://m7.forexmart.com/administration/manage-transfer-queue?type=1">link.</a></p>';
        $email_data['subject'] = $content['title'];
        $email_data['content'] = Fx_mailer::custom_transit_transfer($message_content);

        $this->sendMailTest($email_data);

        $request_data = array(
            'amount_transfer'   =>  $amount_requested. ' ' .$partner_account['currency'],
            'conv_amount'       =>  $converted_amount. ' ' .$client_info[0]['mt_currency_base'],
            'referral_id'       =>  $transit_transfer['referral_id'],
            'security_code'     =>  $security_code,
            'account_num'       =>  $client_acc_num,
        );

        // Update Security Code
        $update_security_code = array(
            'partner_user_id'   =>  $partner_user_id,
            'status'            =>  1,
            'date_used'         =>  date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
        );
        $this->general_model->updatemy('its_security_code','security_code',$security_code,$update_security_code);

        $this->output->set_content_type('application/json')
            ->set_output(
                json_encode(
                    array(
                        'data'   =>  $request_data,
                    )
                )
            );

    }


    public function validateFundRequest($account_number){
        $resData = array(
            'hasError' => false,
            'errorMsg' => '',
        );
        $getAccountBonusByType = FXPP::getAccountBonusByType($account_number);

        $copyTradeBonus =  array(
            27 => 'COPYTRADING BONUS',
        );

        foreach($getAccountBonusByType as $key => $bonusAmt) {
            if (array_key_exists($key, $copyTradeBonus)) {
                $resData['errorMsg'] = 'To transfer copytrading bonus, you have to send a request to bonuses@forexmart.com.';
                $resData['hasError'] = true;

            }
        }

        return $resData;

    }


    public function RequestWalletTransferVerified() {

        if (!$this->input->is_ajax_request()) { die('Not authorized!'); }
        if (!$this->session->userdata('logged')) { redirect(''); }

        $this->load->model('user_model');
        $this->load->model('partners_model');
        $this->load->library('Fx_mailer');

        $date = new DateTime();
        $security_code = $this->input->post('sec_code');
        $amount_requested = $this->input->post('requested_amount');

        if($this->input->post('req_client') === 'Other'){
            $client_acc_num = $this->input->post('req_client_input');
        }else{
            $client_acc_num = $this->input->post('req_client');
        }

        $client_info = $this->user_model->getUserIdbyAccountNumber($client_acc_num);
        $client_user_id = $client_info[0]['user_id'];

        $partner_user_id = $this->session->userdata('user_id');
        $partner_account = $this->partners_model->getAccountByUserId($partner_user_id);

        $isMicro  = $this->account_model->isMicro($client_user_id);
        $amount_client_deduct = $amount_requested;
        if(IPLoc::Office()) {
            if ($isMicro) {
                $amount_client_deduct = $amount_client_deduct * 100;
            }
        }

        if ($client_info[0]['mt_currency_base'] == $partner_account['currency']) {
            $converted_amount = $amount_requested;
            $amount_client_deduct_conv = $amount_client_deduct;
        } else {
            $converted_amount = $this->amountConverter($amount_requested, $partner_account['currency'], $client_info[0]['mt_currency_base']);
            $amount_client_deduct_conv = $this->amountConverter($amount_client_deduct, $partner_account['currency'], $client_info[0]['mt_currency_base']);
        }

        $isSuccess = false;
        $errorMsg = 'Your transfer funds request from Client Account '. $client_acc_num .' was sent  to Finance Department and will be processed nearest time.';

        $config = array('server' => 'live_new');
        $WebService = new WebService($config);
        $account_info = array('iLogin' => $client_acc_num);
        $WebService->open_RequestAccountBalance($account_info);
        if ($WebService->request_status === 'RET_OK') {
            $balance = $WebService->get_result('Balance');
            $converted_amount_1 = $isMicro ? $amount_client_deduct_conv : $converted_amount;
            if ($converted_amount_1 > $balance) {
                $errorMsg = 'Transit Transfer failed. Client Account Number ' . $client_acc_num . ' has insufficient balance:'
                    . '<br>Requested Amount: ' . $amount_requested . ' ' . $partner_account['currency'] . ' (' . $converted_amount_1 . ' ' . $client_info[0]['mt_currency_base'] . ') Current Blance:'. $balance ;
            } else {
                $isSuccess = true;
                // Update Security Code
                $update_security_code = array(
                    'partner_user_id'   =>  $partner_user_id,
                    'status'            =>  1,
                    'date_used'         =>  date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                );
                $this->general_model->updatemy('its_security_code','security_code',$security_code,$update_security_code);

                $checkSecurityCode = $this->general_model->showssingle('transit_transfer_fund_request','security_code',$security_code,'*');

                if (!$checkSecurityCode) {
                    $fund_transfer = array(
                        'amount_request'    =>  $amount_requested,
                        'receiver'          =>  $partner_account['reference_num'],
                        'sender'            =>  $client_acc_num,
                        'status'            =>  0,  // Pending
                        'referral_id'       =>  $date->getTimestamp(),
                        'date_request'      =>  date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                        'security_code'     =>  $security_code,
                    );
                    $this->general_model->insert('transit_transfer_fund_request', $fund_transfer);
                }

            }
        }

        $request_data['is_success'] = $isSuccess;
        $request_data['message'] = $errorMsg;

        $this->output->set_content_type('application/json')
             ->set_output(
                json_encode(
                    array(
                        'data'  =>  $request_data,
                    )
                )
            );
    }

        public function RequestWalletTransferModified() {
        if (!$this->input->is_ajax_request()) { die('Not authorized!'); }
        if (!$this->session->userdata('logged')) { redirect(''); }
        ini_set('max_execution_time', 600);
        $this->load->model('user_model');
        $this->load->model('partners_model');
        $this->load->library('Fx_mailer');

        $date = new DateTime();
        $security_code = $this->input->post('sec_code');
        $amount_requested = $this->input->post('requested_amount');

        if($this->input->post('req_client') === 'Other'){
            $client_acc_num = $this->input->post('req_client_input');
        }else{
            $client_acc_num = $this->input->post('req_client');
        }



            $transferType=$this->input->post('tranType');




             $resValid = $this->validateFundRequest($client_acc_num);

             if($resValid['hasError']){
                 $isApproval = true;
                 $isSuccess = false;
                 $errorMsg = $resValid['errorMsg'];

                 /*   update security code  start  */
                 $partner_user_id = $this->session->userdata('user_id');
                 $update_security_code = array(
                     'partner_user_id' => $partner_user_id,
                     'status' => 0,
                     'date_used' => date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                 );
                 $this->general_model->updatemy('its_security_code', 'security_code', $security_code, $update_security_code);

                 /*   update security code  end  */



             }else{



                 $client_info = $this->user_model->getUserIdbyAccountNumber($client_acc_num);
                 $client_user_id = $client_info[0]['user_id'];

                 $partner_user_id = $this->session->userdata('user_id');
                 $partner_account = $this->partners_model->getAccountByUserId($partner_user_id);

//                 if (!$this->partners_model->getSecurityCodeOnTransitTransfer($security_code)) {

                     /*   update security code  start  */
                     $update_security_code = array(
                         'partner_user_id' => $partner_user_id,
                         'status' => 1,
                         'date_used' => date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                     );
                     $this->general_model->updatemy('its_security_code', 'security_code', $security_code, $update_security_code);

                     /*   update security code  end  */


                     $isMicro = $this->account_model->isMicro($client_user_id);
                     $amount_client_deduct = $amount_requested;
                     if ($isMicro) {
                         $amount_client_deduct = $amount_client_deduct * 100;
                     }

                     if ($client_info[0]['mt_currency_base'] == $partner_account['currency']) {
                         $converted_amount = $amount_requested;
                         $amount_client_deduct_conv = $amount_client_deduct;
                     } else {
                         $converted_amount = $this->amountConverter($amount_requested, $partner_account['currency'], $client_info[0]['mt_currency_base']);
                         $amount_client_deduct_conv = $this->amountConverter($amount_client_deduct, $partner_account['currency'], $client_info[0]['mt_currency_base']);
                     }
                     $request_status = $this->general_model->whereCondition('internal_transfer', array('user_id' => $partner_user_id), '*');
                     $isSuccess = false;
                     $errorMsg = 'Successfully transfer funds from Client Account ' . $client_acc_num .
                         ' to Partner Account ' . $partner_account['reference_num'] . '. ';

                     $checkAmountTransferred = $this->checkAmountTransferred($partner_account['reference_num'], $amount_requested);
                     $condition = (!$checkAmountTransferred['error']);
                     $msg = $checkAmountTransferred['message'];
                     $config = array('server' => 'live_new');
                     $WebService = new WebService($config);
                     $account_info = array('iLogin' => $client_acc_num);
                     $WebService->open_RequestAccountBalance($account_info);


                     if ($WebService->request_status === 'RET_OK') {
                         $balance = $WebService->get_result('Balance');
                         $converted_amount_1 = $isMicro ? $amount_client_deduct_conv : $converted_amount;

                         if ($converted_amount_1 > $balance) {

                             /*   update security code  start  */
                             $partner_user_id = $this->session->userdata('user_id');
                             $update_security_code = array(
                                 'partner_user_id' => $partner_user_id,
                                 'status' => 0,
                                 'date_used' => date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                             );
                             $this->general_model->updatemy('its_security_code', 'security_code', $security_code, $update_security_code);

                             /*   update security code  end  */

                             $errorMsg = lang('its_80') . $client_acc_num . lang('its_81')
                                 . '<br>' . lang('its_49') . $amount_requested . ' ' . $partner_account['currency'] . ' (' . $converted_amount_1 . ' ' . $client_info[0]['mt_currency_base'] . ')';



                         } else {
                             $resellerData = array(
                                 'amount' => $amount_requested,
                                 'partner_user_id' => $partner_user_id,
                                 'partner_account_number' => $partner_account,
                                 'client_account_number' => $client_acc_num,
                                 'client_user_id' => $client_user_id,
                                 'client_currency' => $client_info[0]['mt_currency_base'],
                                 'converted_amount_micro' => $amount_client_deduct_conv,
                                 'amount_requested_micro' => $amount_client_deduct,
                                 'transaction_type'          => $transferType,
                             );
                             // partner with defined limit
                             //and request  that will  not exceed daily limit.
                             if (!$checkAmountTransferred['error'] && $checkAmountTransferred['account_with_limit']) {
                                 $resellerData['for_approval'] = false;
                                 $isApproval = false;
                                 $transferResult = $this->paycoWalletTransferModified($resellerData, 'client');
                                 $partner_content['p1'] = 'Request for funds using Transfer is processed.<br> ';
                                 $partner_content['partner_p1'] = 'Request for funds using Transfer is processed.<br> ';

                                 //  $partner_content['details'] ='You have sent the request for transit transfer from your account '.$partner_account['reference_num'].' to account '.$client_acc_num.'.';
                                 $errorMsg = 'Successfully transfer funds from Client Account ' . $client_acc_num .
                                     ' to Partner Account ' . $partner_account['reference_num'] . '. ';
                             } else {
                                 //all partner request with no define  limit and those who exceeded daily limit are subject for approval in admin panel.
                                 $resellerData['for_approval'] = true;
                                 $isApproval = true;
                                 $transferResult = $this->paycoWalletTransferModifiedNew($resellerData, 'client');

                                 // $partner_content['details'] = 'Your transfer funds request from Client Account '. $client_acc_num .' was sent  to Finance Department and will be processed nearest time. <br> ';
                                 $partner_content['partner_p1'] = 'You have sent the request for transfer from account ' . $client_acc_num . ' to your account ' . $partner_account['reference_num'] . '.';
                                 $partner_content['p1'] = 'You received the transfer from account ' . $client_acc_num . ' to your account ' . $partner_account['reference_num'] . '.';
                                 //$errorMsg = 'Transfer is under processing of Finance department, Please wait until it is completed';// FXPP-11944
                                 $errorMsg = 'Your Internal Transfer Request is under review. We will send you an email once the ITS has been processed. Thank you for your patience.';

                             }

                             if (!$transferResult['error']) {
                                 $isSuccess = true;
                                 $client_basic_info = $this->user_model->getUserProfileByUserId($client_user_id);
                                 $partner_basic_info = $this->user_model->getUserProfileByUserId($partner_user_id);


                                 $request_data = array(
                                     'amount_transfer' => $amount_requested . ' ' . $partner_account['currency'],
                                     'conv_amount' => $converted_amount . ' ' . $client_info[0]['mt_currency_base'],
                                     'referral_id' => $transferResult['result']['transaction_id'],
                                     'security_code' => $security_code,
                                     'account_num' => $client_acc_num,
                                     'transferResult' => $transferResult,
                                     'resellerData' => $resellerData,
                                 );


                                 $table = 'transit_transfer_fund_request';
                                 if ($isApproval) {
                                     $ref_status = 0; // pending  ITS request stored in transit_transfer_fund_request table in admin panel
                                 } else {
                                     $ref_status = 1; //processed  ITS request ( only for partner with automatic fund transfer
                                 }

                                 // save transfer request
                                 $fund_transfer = array(
                                     'amount_request' => $amount_requested, // actual requested amount
                                     'receiver' => $partner_account['reference_num'],
                                     'sender' => $client_acc_num,
                                     'status' => $ref_status,  // Pending
                                     'referral_id' => $transferResult['result']['transaction_id'],
                                     'date_request' => date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                                     'security_code' => $security_code,
                                     'transfer_amount' => $transferResult['result']['partner_transfer_amount'], // processed amount deposited to partner
                                     'deduct_amount' => $transferResult['result']['client_deduct_amount'], // processed amount deducted from client (converted or actual amount request)
                                 );


                                 $this->general_model->insert($table, $fund_transfer);


                                 if ($isApproval) {
                                     //notify finance
                                     $client_currency_2 = $isMicro ? $client_info[0]['mt_currency_base'] . 'c' : $client_info[0]['mt_currency_base'];
                                     $content['title'] = 'Transit Transfer - Accessed by Partner Account [' . $partner_account['reference_num'] . ']';
                                     $content['table'] = array(
                                         'Partner Account:' => $partner_account['reference_num'] . ' [' . $partner_account['currency'] . ']',
                                         'Client Account:' => $client_acc_num . ' [' . $client_currency_2 . ']',
                                         'Amount to transfer:' => $amount_requested . ' ' . $partner_account['currency'],
                                         'Converted amount:' => $converted_amount_1 . ' ' . $client_currency_2,
                                     );

                                     $cToFmContent['title'] = 'Transit Transfer Successful';
                                     $cToFmContent['table'] = $content['table'];
                                     $cToFmContent['paragraph'] = '<p>Visit this <a href="https://m7.forexmart.com/administration/manage-transfer-queue">page</a> on Admin Panel for more info.</p>
                                      <p style="font-size: 16px;">Transit transfer details:</p>';

                                     $cToFM_mail['subject'] = 'Transit Transfer - Successful Transfer';
                                     $cToFM_mail['content'] = Fx_mailer::custom_transit_transfer($cToFmContent);

                                     $this->sendMail($cToFM_mail);

                                 }


                                 // Sending mail
                                 $subject = 'Request Funds using Transfer [ref#: ' . $transferResult['result']['transaction_id'] . ']';
                                 $partner_content['p2'] .= '<p>  Please check the details are correct:</p><p><table>
                                    
                                    <tr>
                                        <td>IB’s Account:</td>
                                        <td>' . $partner_account['reference_num'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>Referral’s Account:</td>
                                        <td>' . $client_acc_num . '</td>
                                    </tr>
                                    <tr>
                                        <td>Amount:</td>
                                        <td>' . $amount_requested . '</td>
                                    </tr>
                                    <tr>
                                        <td>Currency:</td>
                                        <td>' . $partner_account['currency'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>Direction:</td>
                                        <td> From Client ' . $client_acc_num . ' to Partner ' . $partner_account['reference_num'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>Order Time (UTC+3):</td>
                                        <td>' . date('Y-m-d H:i:s') . '</td>
                                    </tr>
                                    <tr>
                                        <td>Transaction Number:</td>
                                        <td>' . $transferResult['result']['transaction_id'] . '</td>
                                    </tr>
                                </table></p>';

                                 $partner_content['details'] = $partner_content['p1'] . $partner_content['p2'];
                                 $partner_content['subject'] = $subject;
                                 $partner_content['full_name'] = $client_basic_info['full_name'];

                                 $partner_mail['content'] = $this->load->view('email/transit_transfer_request_success', $partner_content, true);
                                 $partner_mail['email'] = $client_basic_info['email'];
                                 $this->email->clear(TRUE);
                                 $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
                                 $this->email->to($partner_mail['email']);
                                 //   $this->email->bcc('bug.fxpp@gmail.com');
                                 $this->email->subject($subject);
                                 $this->email->message($partner_mail['content']);
                                 $this->email->send();


                                 $this->email->clear(TRUE);
                                 $partner_content['full_name'] = $partner_basic_info['full_name'];
                                 $partner_mail['email'] = $partner_basic_info['email'];

                                 $partner_content['details'] = $partner_content['partner_p1'] . $partner_content['p2'];
                                 $partner_mail['content'] = $this->load->view('email/transit_transfer_request_success', $partner_content, true);
                                 $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
                                 $this->email->to($partner_mail['email']);
                                 //   $this->email->bcc('bug.fxpp@gmail.com');
                                 $this->email->subject($subject);
                                 $this->email->message($partner_mail['content']);
                                 $this->email->send();


                             } else {
                                 $errorMsg = lang('its_80') . $client_acc_num . lang('its_81')
                                     . '<br>' . lang('its_49') . $amount_requested . ' ' . $partner_account['currency'] . ' (' . $converted_amount_1 . ' ' . $client_info[0]['mt_currency_base'] . ')';
                             }


                         }
                     } else {

                         /*   update security code  start  */
                         $partner_user_id = $this->session->userdata('user_id');
                         $update_security_code = array(
                             'partner_user_id' => $partner_user_id,
                             'status' => 0,
                             'date_used' => date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                         );
                         $this->general_model->updatemy('its_security_code', 'security_code', $security_code, $update_security_code);

                         /*   update security code  end  */

                         $errorMsg = lang('its_82');

                     }


//                 }else{
//
//                     $errorMsg = 'Security Code Invalid.';
//                 }







             }




        $request_data['for_approval'] = $isApproval;
        $request_data['is_success'] = $isSuccess;
        $request_data['message'] = $errorMsg;

        $this->output->set_content_type('application/json')
            ->set_output(
            json_encode(
                array(
                    'data'  =>  $request_data,
                    'total' =>  $checkAmountTransferred,
                )
            )
        );
    }

    // if exceeded returns true else false

    public function checkAmountTransferred($account_number, $amount) {
        $this->load->model('partners_model');

        $returnData = array(
            'error'     =>  true,
            'message'   =>  '',
            'account_with_limit' =>  true,

        );


      //  if(IPLoc::Office()){

            $current_date = date('Y-m-d', strtotime(FXPP::getCurrentDateTime()));
            $checkAmountTransferred = $this->partners_model->checkAmountTransferred($account_number,$current_date);




            $sum = $amount + $checkAmountTransferred['total_transferred'];





            if( $limit_setting = $this->general_model->whereCondition('withdrawal_limit_setting',array('account_number'=>$account_number),'*')){

                if($limit_setting['limit']<$amount){ // limit is greater than the requested amount
                    $returnData['message'] = 'Allowed amount to be transferred should be equal or less than '.$limit_setting['limit'].' USD within 24 hour(s).';
                 return $returnData;
                }else{
                    $limit_amount = $limit_setting['limit'];
                }
            }else{
               // $limit_amount = 500;
                $returnData['account_with_limit']  = false;
            }






        /*    }else{


                // FXPP-9028
                if( $account_number == 262259 || $account_number == 192912 || $account_number == 306892){
                    if ($amount > 1000) {
                        $returnData['message'] = 'Allowed amount to be transferred should be equal or less than 1000 USD within 24 hour(s).';
                        return $returnData;
                    }

                }else if( $account_number == 299998){

                    if ($amount > 700) {
                        $returnData['message'] = 'Allowed amount to be transferred should be equal or less than 700 USD within 24 hour(s).';
                        return $returnData;
                    }

                }else{

                    if ($amount > 500) {
                        $returnData['message'] = 'Allowed amount to be transferred should be equal or less than 500 USD within 24 hour(s).';
                        return $returnData;
                    }
                }

                $current_date = date('Y-m-d', strtotime(FXPP::getCurrentDateTime()));
                $checkAmountTransferred = $this->partners_model->checkAmountTransferred($account_number,$current_date);
                $sum = $amount + $checkAmountTransferred['total_transferred'];

                if(IPLoc::Office()){
                    $limit_amount = 5000;
                }else{
                    // FXPP-9028
                    if( $account_number == 262259 || $account_number == 19291 || $account_number == 306892){
                        $limit_amount = 1000;
                    }else if($account_number == 299998){
                        $limit_amount = 700;
                    }else{
                        $limit_amount = 500;
                    }

                }

            } */




        if($limit_amount > 0){
            if ($sum > $limit_amount) {
                $returnData['message'] = 'Sum of total amount transferred and current amount to be transferred has reached the allowable funds to be transferred within 24 hour(s) (Less than or equal to 500 USD).';
                return $returnData;
            }
        }



        $returnData['error'] = false;
        $returnData['sum'] = $sum;
        return $returnData;
    }

    public function invite_friend(){
        error_reporting(E_ALL);
        if( !IPLoc::Office()){redirect('');}
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $id = $this->input->get('id');
            if($id){
                $invite_info = $this->general_model->whereCondition('invite_friends',array('user_id'=>$this->session->userdata('user_id'),'id'=>$id));

                if($invite_info){

//                    $partner_account_detail = $this->general_model->whereCondition('all_accounts',array('user_id'=>$invite_info['user_id_after_registration'],'account_type'=>'1'));
                    $partner_account_detail = $this->general_model->whereConditionQuery2( $invite_info['user_id_after_registration'],1);

                    $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));

                    $webservice_config = array(
                        'server' => 'live_new'
                    );
                    $WebService = new WebService($webservice_config);
                    $cash = 0;

                    $WebService->GetFristDipositTradedVolume(array('account_number'=>$partner_account_detail['account_number']));
                    if ($WebService->request_status === 'RET_OK') {
                        $vol = $WebService->get_result('TotalVolume');
                        //  $cash = (($vol / 0.1) * 3) ;
                        $vol =  number_format((floatval($vol) / 0.1) * 3 ,4);
                        $cash = $vol - ($invite_info['credit'] + $invite_info['withdraw']);

                        /* If withdraw is decline. withdraw status 2 is decline  */
                        /* if($withdraw = $this->general_model->whereCondition('withdraw',array('id'=>$invite_info['withdraw_id']))){
                            if($withdraw['status'] == 2){
                                $cash = $vol - ($invite_info['credit']);
                            }
                        }*/

                        if($cash>100){
                            $cash = 100;
                        }
                    }


                    $data['account_number'] = $account['account_number'];
                    $data['amount'] = number_format($cash,4);
                    $data['currency'] = $account['currency'];

                    if(!$this->session->userdata('login_type')){

                        // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                        if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                            $user_status = true;
                        }
                    }else{

                        $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
                    }

                    $data['disable_input'] = $user_status;
                    $data['fee'] = $this->settings_model->getAllTransactionFeeByType();
                    $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(), FXPP::getUserCountryCode());



                    $js = $this->template->Js();
                    $data['metadata_description'] = 'Provide the necessary information to withdraw via PayPal.';
                    $this->template->title("ForextMart | Witdrawal Funds | Paypal")
                        ->set_layout('internal/main')
                        ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                        ->build('withdrawnew/invite_friend',$data);

                }else{
                    redirect('invite-friend/statistics');
                }

            }else{
                redirect('invite-friend/statistics');
            }




        }else{
            redirect('signout');
        }
    }

    function getTransactionFee(){

        if ($this->input->is_ajax_request()) {

            $payment_system = $this->input->post('payment_system');
            $currency = $this->input->post('currency');
            $amount_withdraw = $this->input->post('amount');
            $getTransactionFee = FXPP::getTransactionFee($payment_system, $currency);
            $getTransactionFee['sys_fee']=0;
            if($payment_system === 'SKRILL'){
                $skrillSystemFee = $this->SkrillSystemFee($amount_withdraw, $currency);
                $getTransactionFee['sys_fee'] =  $skrillSystemFee;
            }
            echo json_encode($getTransactionFee);

        }else{
            exit('No direct script access allowed');
        }


    }


    public function addInviteFriendBonus()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $type = $this->input->post('type');


            if($type == 'BANK TRANSFER'){
                $this->form_validation->set_rules('beneficiaryAccount', 'Account Number', 'trim|required|xss_clean');

                $this->form_validation->set_rules('beneficiaryBank', 'Beneficiary\'s Bank', 'trim|required|xss_clean');
                $this->form_validation->set_rules('beneficiaryAddress', 'Beneficiary\'s Address', 'trim|required|xss_clean');
                $this->form_validation->set_rules('beneficiarySwift', 'Beneficiary\'s bank SWIFT', 'trim|required|xss_clean');
                $this->form_validation->set_rules('beneficiaryAccount', 'Beneficiary\'s Account', 'trim|required|xss_clean');
                $this->form_validation->set_rules('beneficiaryStreet', 'Street', 'trim|required|xss_clean');
                $this->form_validation->set_rules('beneficiaryCity', 'City', 'trim|required|xss_clean');
                $this->form_validation->set_rules('beneficiaryState', 'State', 'trim|required|xss_clean');
                $this->form_validation->set_rules('beneficiaryCountry', 'Country', 'trim|required|xss_clean');
                $this->form_validation->set_rules('beneficiaryPostal', 'Postal Code', 'trim|required|xss_clean');
            }

            if($type == 'CREDIT CARD'){

                $this->form_validation->set_rules('card_number', 'Card number', 'trim|numeric|required|xss_clean');
                $this->form_validation->set_rules('card_name', 'Card name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('card_expiry_month', 'Card expiry month', 'trim|required|xss_clean');
                $this->form_validation->set_rules('card_expiry_year', 'Card expiry year ', 'trim|required|xss_clean');
            }

            $this->form_validation->set_rules('amountWithdraw', 'Amount withdraw', 'trim|required|xss_clean');
            if($this->form_validation->run()){

                $invite_info = $this->general_model->whereCondition('invite_friends', array('user_id' => $this->session->userdata('user_id'), 'id' => $id));
//                $account_detail = $this->general_model->whereCondition('all_accounts', array('user_id' => $this->session->userdata('user_id'), 'account_type' => '1'));
                $account_detail =  $this->general_model->whereConditionQuery2( $this->session->userdata('user_id'),1);
//                $partner_account_detail = $this->general_model->whereCondition('all_accounts', array('user_id' => $invite_info['user_id_after_registration'], 'account_type' => '1'));
                $partner_account_detail = $this->general_model->whereConditionQuery2( $invite_info['user_id_after_registration'],1);



                if ($invite_info) {
                    $payment_account_number = $this->input->post('pay_account', true);
                    $webservice_config = array(
                        'server' => 'live_new'
                    );
                    $WebService = new WebService($webservice_config);
                    $cash = 0;
                    //  160674
                    $WebService->GetFristDipositTradedVolume(array('account_number' =>$partner_account_detail['account_number']));
                    if ($WebService->request_status === 'RET_OK') {
                        $vol = $WebService->get_result('TotalVolume');


                        $vol =  number_format((floatval($vol) / 0.1) * 3 ,4);
                        $cash = $vol - ($invite_info['credit'] + $invite_info['withdraw']);

                        /* If withdraw is decline. withdraw status 2 is decline  */
                        /*  if($withdraw = $this->general_model->whereCondition('withdraw',array('id'=>$invite_info['withdraw_id']))){
                            if($withdraw['status'] == 2){
                                $cash = $vol - ($invite_info['credit']);
                            }
                        }*/


                        if ($cash > 100) {
                            $cash = 100;
                        }
                    }
                    $withdrawalAmount = number_format($cash,4);

                    /*
                    $getTransactionFee = FXPP::getTransactionFee($type, $account_detail['currency']);
                    $withdrawalAmount = number_format($cash,4);
                    $skrillSystemFee = 0;
                    if($type === 'SKRILL'){
                        $skrillSystemFee = $this->SkrillSystemFee($cash, $account_detail['currency']);

                    }
                    $cash = $cash - (($cash*$getTransactionFee['fee'])+$getTransactionFee['addons']+ $skrillSystemFee);  */

                    if ($cash > 0) {

                        $payment_type = array(
                            'NETELLER' => "neteller_id",
                            'SKRILL' => "skrill_account",
                            'PAYPAL' => "paypal_account",
                            'PAXUM' => "paxum_id",
                            'CREDIT CARD' => "card_number",
                            'MEGATRANSFER CARD' => "card_number",
                            'BANK TRANSFER' => "beneficiary_account",
                            'PAYCO' => "wallet",
                            'QIWI' => "inv_number",
                            'MEGATRANSFER' => "username",
                            'WEBMONEY' => "webmoney_purse",
                            'MONETA' => "moneta_account",
                            'SOFORT' => "sofort_account",
                            'YANDEXMONEY' => "yandex_wallet"
                        );

                        if($type == 'CREDIT CARD'  || $type == 'MEGATRANSFER CARD'){
                            // card
                            $card_number = $this->input->post('card_number',true);
                            $card_name = $this->input->post('card_name',true);
                            $card_expiry_month = $this->input->post('card_expiry_month',true);
                            $card_expiry_year = $this->input->post('card_expiry_year',true);

                            $counterpartData = array(
                                'card_number' => $card_number,
                                'card_name' => $card_name,
                                'card_expiry_month' => $card_expiry_month,
                                'card_expiry_year' => $card_expiry_year
                            );
                            // end card
                        }elseif( $type == 'BANK TRANSFER'){


                            $beneficiary_bank = $this->input->post('beneficiaryBank',true);
                            $beneficiary_address = $this->input->post('beneficiaryAddress',true);
                            $beneficiary_swift = $this->input->post('beneficiarySwift',true);
                            $beneficiary_account = $this->input->post('beneficiaryAccount',true);
                            $beneficiary_street = $this->input->post('beneficiaryStreet',true);
                            $beneficiary_city= $this->input->post('beneficiaryCity',true);
                            $beneficiary_state = $this->input->post('beneficiaryState',true);
                            $beneficiary_country = $this->input->post('beneficiaryCountry',true);
                            $beneficiary_postal = $this->input->post('beneficiaryPostal',true);

                            $counterpartData = array(
                                'beneficiary_bank' => $beneficiary_bank,
                                'beneficiary_address' => $beneficiary_address,
                                'beneficiary_swift' => $beneficiary_swift,
                                'beneficiary_account' => $beneficiary_account,
                                'beneficiary_street' => $beneficiary_street,
                                'beneficiary_city' => $beneficiary_city,
                                'beneficiary_state' => $beneficiary_state,
                                'beneficiary_country' => $beneficiary_country,
                                'beneficiary_postal' => $beneficiary_postal
                            );

                        }elseif($type == "BITCOIN"){
                            $counterpartData = array(
                                'username' => $this->input->post('bitcoin_address',true)
                            );
                        }
                        else{
                            $counterpartData = array($payment_type[$type] => $payment_account_number);
                        }


                        $withdrawalData = array(
                            'user_id' => $this->session->userdata('user_id'),
                            'amount' => $cash,
                            'withdrawal_type' => $type,
                            'counterpart' => $counterpartData
                        );


                        $withdrawalProcess = $this->withdrawalProcessBonus($withdrawalData,$partner_account_detail['account_number']);

                        if (!$withdrawalProcess['error']) {
                            $isSuccess = true;
                            $transaction_data = $withdrawalProcess['transaction_data'];
                            $this->general_model->updatemyw2("invite_friends","user_id",$this->session->userdata('user_id'),"id",$id,array('withdraw'=>$withdrawalAmount,'withdraw_id'=>$transaction_data['withdraw_id']));

                        } else {
                            $isSuccess = false;
                            $errorMsg = $withdrawalProcess['errorMsg'];
                        }
                    }else{
                        $errorMsg = 'Your withdrawal amount is 0.';
                        $isSuccess = false;
                    }


                } else {
                    $errorMsg = 'Your withdrawal request failed.';
                    $isSuccess = false;
                }

            }else{
                $errorMsg = validation_errors();
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );
        }
    }

    public function withdrawalProcessBonus($withdrawalData,$partner_account = null){
        $this->load->library('Fx_mailer');
        $amount_withdraw = $withdrawalData['amount'];
        $userId = $withdrawalData['user_id'];
        $counterpart = $withdrawalData['counterpart'];
        $withdrawalType = $withdrawalData['withdrawal_type'];
        $getWithdrawalType = $this->transaction_type[$withdrawalType];

        $returnData = array(
            'error' => true,
            'errorMsg' => 'Your withdrawal request failed.'
        );

        if(!$this->session->userdata('login_type')){
            $user_status = $this->account_model->getAccountStatus($userId);
        }else{
            $user_status = $this->account_model->getVerificationStatus($userId);
        }

        if(!$user_status){
            return $returnData;
        }

        $account = $this->account_model->getAccountNumber($userId);
        $account_number = $account['account_number'];

        $getTransactionFee = FXPP::getTransactionFee($withdrawalType, $account['currency']);

        $totalFee = FXPP::roundno($amount_withdraw * $getTransactionFee['fee'], 4);

        if($withdrawalType === 'SKRILL'){
            $skrillSystemFee = $this->SkrillSystemFee($amount_withdraw, $account['currency']);
            $totalFee = $totalFee + $skrillSystemFee;
        }

        $totalFees = $totalFee + $getTransactionFee['addons'];

        $amount_deducted =  FXPP::roundno($amount_withdraw, 4);

        $amount_withdraw = FXPP::roundno($amount_withdraw - $totalFees, 4);  // change the amount to separate  for fee amount

        $requestData = array(
            'totalAmount' => $amount_deducted,
            'amountRequested' => $amount_withdraw,
            'totalFee' => $getTransactionFee['fee'],
            'currency' => $account['currency'],
            'account_number' => $account_number
        );



        // generate reference number for MT4 Comment
        $new_date = new DateTime();
        $generated_transaction_number = $new_date->getTimestamp();
        $comment = "BONUS FOR FRIEND ".$partner_account."_".$this->comment_type['withdraw'] . $this->comment_transaction_type[$withdrawalType] . $generated_transaction_number;

        $service_data = array(
            'Amount' => $amount_deducted,
            'Comment' => $comment,
            'Receiver' => 0,
            'AccountNumber' => $account_number,
            'ProcessByIP' => $this->input->ip_address()
        );

        $webservice_config = array(
            'server' => 'live_new'
        );
        $WebService = new WebService($webservice_config);
        $WebService->deposit_invite_A_friend_bonus($account_number, $amount_deducted, "BONUS FOR FRIEND  ".$partner_account);

        if ($WebService->request_status === 'RET_OK') {

            $WebService->withdraw_invite_A_friend_fund($service_data);

            $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));

            if ($WebService->request_status != 'RET_OK') {
                $WebService->deposit_invite_A_friend_bonus($account_number,-1*$amount_deducted, "BONUS FOR FRIEND  ".$partner_account);
                $apiLogs = array(
                    'Account_number' => $account_number,
                    'UserId' => $userId,
                    'Amount' => $amount_deducted,
                    'ApiStatus' => $WebService->request_status,
                    'Date' => $date
                );
                $this->general_model->insert('withdraw_api_logs', $apiLogs);
                return $returnData;
            }else{


                $returnData['errorSrvcMsg'] = $WebService->request_status;
            }

        }else{
            return $returnData;
        }





        $transaction_id = $this->withdraw_model->insertWithdrawByTranType($getWithdrawalType, $counterpart);
        if(!$transaction_id){
            return $returnData;
        }

        $result = $WebService->result;

        $withdraw_data = array(
            'account_number' => $account_number,
            'user_id' => $userId,
            'date_withdraw' => $date,
            'currency' => $account['currency'],
            'reference_number' => $result['Ticket'],
            'transaction_type' => $getWithdrawalType,
            'amount' => $amount_withdraw,
            'amount_deducted' => $amount_deducted,
            'status' => 0,
            'transaction_id' => $transaction_id,
            'fee' => $getTransactionFee['fee'],
            'added_fee' => $getTransactionFee['addons'],
            'ref_num_mt4' => $generated_transaction_number,
            'wd_txn_type'=>4
        );

        $withdrawId = $this->withdraw_model->insertWithdraw($withdraw_data);



        $withdrawRequestMail = array(
            'Full_name' => $this->session->userdata('full_name'),
            'Email' =>$clientEmail = $this->session->userdata('email'),
            'Account_number' => $account_number,
            'Currency' => $account['currency'],
            'Amount' => $amount_withdraw,
            'Withdrawal_type' => $withdrawalType
        );

        Fx_mailer::withdraw($withdrawRequestMail);

        $WebService2 = new WebService($webservice_config);
        $WebService2->request_live_account_balance($account_number);

        if( $WebService2->request_status === 'RET_OK' ) {
            $balance = $WebService2->get_result('Balance');
            $this->account_model->updateAccountBalance($account_number, $balance);
        }

        switch($withdrawalType){
            case 'NETELLER':
                $counterpartField = $counterpart['neteller_id'];
                break;
            case 'SKRILL':
                $counterpartField = $counterpart['skrill_account'];
                break;
            case 'PAYPAL':
                $counterpartField = $counterpart['paypal_account'];
                break;
            case 'PAXUM':
                $counterpartField = $counterpart['paxum_id'];
                break;
            case 'CREDIT CARD':
                $counterpartField = $counterpart['card_number'];
                break;
            case 'MEGATRANSFER CARD':
                $counterpartField = $counterpart['card_number'];
                break;
            case 'BANK TRANSFER':
                $counterpartField = $counterpart['beneficiary_account'];
                break;
            case 'PAYCO':
                $counterpartField = $counterpart['wallet'];
                break;
            case 'QIWI':
                $counterpartField = $counterpart['inv_number'];
                break;
            case 'MEGATRANSFER':
                $counterpartField = $counterpart['username'];
                break;
            case 'WEBMONEY':
                $counterpartField = $counterpart['webmoney_purse'];
                break;
            case 'MONETA':
                $counterpartField = $counterpart['moneta_account'];
                break;
            case 'SOFORT':
                $counterpartField = $counterpart['sofort_account'];
                break;
            case 'YANDEXMONEY':
                $counterpartField = $counterpart['yandex_wallet'];
                break;
            case 'BITCOIN':
                $counterpartField = $counterpart['username'];
                break;
        }

        $transaction_data = array(
            'amount_requested' => $amount_withdraw,
            'account_number' => $account_number,
            'client_inf' => $counterpartField,
            'transaction_number' => $result['Ticket'],
            'fee' => $totalFees,
            'withdraw_id' =>$withdrawId
        );

        $returnData['error'] = false;
        $returnData['errorMsg'] = 'success';
        $returnData['transaction_data'] = $transaction_data;
        return $returnData;
    }

    public function fasapay(){
        // Remove IP restriction when task is in live
        if($this->session->userdata('logged')) {
          //  redirect(FXPP::loc_url('withdraw'));
            $this->load->helper('language');

            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));

            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

            //  print_r($this->session->userdata('login_type')); exit;

            /*if(!$this->session->userdata('login_type')){
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));

                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            }else{
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/


            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $getTransactionFee = FXPP::getTransactionFee('FASAPAY', $account['currency']);
            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'% + '.$getTransactionFee['addons'].' '.$account['currency'];

            $data['ndb_bonus']  = 0;

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(), FXPP::getUserCountryCode());

            $data['disable_input'] = $user_status;

            $js = $this->template->Js();
            $data['metadata_description'] = 'Please fill in all the appropriate fields to facilitate withdrawal of funds by FasaPay.';
            $this->template->title("Withdrawal Option - FasPay")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/fasapay',$data);
        }else{
            redirect('signout');
        }
    }

    public function addFasaPay(){
        if ($this->input->is_ajax_request()) {
            // $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('fasa_account', 'FasaPay Account', 'trim|required|xss_clean');

            if($this->form_validation->run() !=false){
                $amount = $this->input->post('amount_withdraw',true);

                $counterpartData = array(
                    'fasapay_account' => $this->input->post('fasa_account',true)
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $amount,
                    'withdrawal_type' => 'FASAPAY',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if(!$withdrawalProcess['error']){
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                }else{
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg,
                    )
                )
            );
        }
    }


    public function chinaUnionPay() {
        if ($this->session->userdata('logged')) {
            $this->load->helper('language');

            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));

            if (IPLoc::IPCrpAccVerify()) {
                //  echo $this->db->last_query(); exit;
            }
            
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);


            /*if (!$this->session->userdata('login_type')) {
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            } else {
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/

            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $getTransactionFee = FXPP::getTransactionFee('CHINAUNIONPAY', $account['currency']);
            $data['fee_details'] = ($getTransactionFee['fee'] * 100) . '% + ' . $getTransactionFee['addons'] . ' ' . $account['currency'];

            $data['ndb_bonus'] = 0;
            $data['cup_details'] = $this->general_model->showssingle('chinaunionpay_deposit',"user_id",$this->session->userdata('user_id'),$select="*");

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(), FXPP::getUserCountryCode());

            $data['disable_input'] = $user_status;

            $js = $this->template->Js();
            $data['metadata_description'] = 'Please fill in all the appropriate fields to facilitate withdrawal of funds by China Union Pay.';
            $this->template->title("Withdrawal Option - China Union Pay")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/china_union_pay', $data);
        } else {
            redirect('signout');
        }
    }


    public function Alipay() {
        if ($this->session->userdata('logged')) {
            $this->load->helper('language');

            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));

            if (IPLoc::IPCrpAccVerify()) {
                //  echo $this->db->last_query(); exit;
            }

            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

            /*if (!$this->session->userdata('login_type')) {
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            } else {
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/


            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $getTransactionFee = FXPP::getTransactionFee('ALIPAY', $account['currency']);
            $data['fee_details'] = ($getTransactionFee['fee'] * 100) . '% + ' . $getTransactionFee['addons'] . ' ' . $account['currency'];

            $data['ndb_bonus'] = $getNdbBonus;
           // $data['cup_details'] = $this->general_model->showssingle('chinaunionpay_deposit',"user_id",$this->session->userdata('user_id'),$select="*");

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(), FXPP::getUserCountryCode());

            $data['disable_input'] = $user_status;

            $js = $this->template->Js();
            $data['metadata_description'] = 'Please fill in all the appropriate fields to facilitate withdrawal of funds by Alipay.';
            $this->template->title("Withdrawal Option - Alipay")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/aliPay', $data);
        } else {
            redirect('signout');
        }
    }


    public function PayTrust() {
        if ($this->session->userdata('logged')) {
            $this->load->helper('language');

            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));

            if (IPLoc::IPCrpAccVerify()) {
                //  echo $this->db->last_query(); exit;
            }

            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

            if (!$this->session->userdata('login_type')) {
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            } else {
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }

            $getTransactionFee = FXPP::getTransactionFee('BANK_MYR', $account['currency']);
            $data['fee_details'] = ($getTransactionFee['fee'] * 100) . '% + ' . $getTransactionFee['addons'] . ' ' . $account['currency'];

            $data['ndb_bonus'] = $getNdbBonus;
            $data['cup_details'] = $this->general_model->showssingle('chinaunionpay_deposit',"user_id",$this->session->userdata('user_id'),$select="*");

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(), FXPP::getUserCountryCode());

            $data['disable_input'] = $user_status;

            $js = $this->template->Js();
            $data['metadata_description'] = 'Please fill in all the appropriate fields to facilitate withdrawal of funds by PayTrust.';
            $this->template->title("Withdrawal Option - PayTrust")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build(FXPP::buildUpPage('withdraw/payTrust'), $data);
        } else {
            redirect('signout');
        }
    }

    public function bank_transfer_myr() {
        if ($this->session->userdata('logged')) {
            $this->load->helper('language');

            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));

            if (IPLoc::IPCrpAccVerify()) {
                //  echo $this->db->last_query(); exit;
            }

            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

           /* if (!$this->session->userdata('login_type')) {
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            } else {
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/

            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $getTransactionFee = FXPP::getTransactionFee('BANK_MYR', $account['currency']);
            $data['fee_details'] = ($getTransactionFee['fee'] * 100) . '% + ' . $getTransactionFee['addons'] . ' ' . $account['currency'];

            $data['ndb_bonus'] = 0;
            $data['cup_details'] = $this->general_model->showssingle('chinaunionpay_deposit',"user_id",$this->session->userdata('user_id'),$select="*");

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(), FXPP::getUserCountryCode());

            $data['disable_input'] = $user_status;

            $js = $this->template->Js();
            $data['metadata_description'] = 'Please fill in all the appropriate fields to facilitate withdrawal of funds by PayTrust.';
            $this->template->title("Withdrawal Option - Bank Transfer MYR")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build(FXPP::buildUpPage('withdraw/bank_myr'), $data);
        } else {
            redirect('signout');
        }
    }
    public function zotapay() {
        if ($this->session->userdata('logged')) {
            $this->load->helper('language');
            
         
           $data['currency'] = strtoupper($this->input->get('wallet_id', true));

            if(empty($data['currency'])){
                switch($this->session->userdata('country')){
                    case 'MY': $data['currency'] = 'MYR'; break;
                    case 'ID': $data['currency'] = 'IDR'; break;
                    case 'VN': $data['currency'] = 'VND'; break;
                    case 'TH': $data['currency'] = 'THB'; break;
                    default: 
                    redirect(FXPP::loc_url('withdraw'));
                    break;
                }
            }
            




            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));

            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            $bankType = strtoupper('ZOTAPAY_'.$data['currency']);

            $getTransactionFee = FXPP::getTransactionFee($bankType, $account['currency']);

            $data['fee_details'] = ($getTransactionFee['fee'] * 100) . '% + ' . $getTransactionFee['addons'] . ' ' . $account['currency'];

            $data['ndb_bonus'] = 0;

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(), FXPP::getUserCountryCode());

            $data['disable_input'] = $user_status;

            $js = $this->template->Js();
            $data['metadata_description'] = 'Please fill in all the appropriate fields to facilitate withdrawal of funds by ZotaPay.';
            $this->template->title("Withdrawal Option - Bank Transfer ZotaPay")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build(FXPP::buildUpPage('withdraw/zotapay'), $data);
        } else {
            redirect('signout');
        }
    }


    public function addZotapay() {
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('bank_account_number', 'Bank Account Number', 'trim|required|xss_clean');

            $this->form_validation->set_rules('bank_account_name', 'Bank account name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_name', 'Bank account name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_branch', 'Branch', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_province', 'Province', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_city', 'Bank city', 'trim|required|xss_clean');

            if ($this->form_validation->run()) {
                $amount = $this->input->post('amount_withdraw', true);

                $counterpartData = array(
                    'bank_account_number' => $this->input->post('bank_account_number', true),
                    'bank_account_name'=>$this->input->post('bank_account_name', true),
                    'bank_name'=>$this->input->post('bank_name', true),
                    'bank_branch'=>$this->input->post('bank_branch', true),
                    'bank_province'=>$this->input->post('bank_province', true),
                    'bank_city'=>$this->input->post('bank_city', true)

                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $amount,
                    'withdrawal_type' => strtoupper('ZOTAPAY_'. $this->input->post('wallet_currency', true)),
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if (!$withdrawalProcess['error']) {
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                } else {
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }
            } else {
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'success' => $isSuccess,
                            'transaction_data' => $transaction_data,
                            'errorMsg' => $errorMsg
                        )
                    )
                );
        }
    }



    public function addPayTrust(){
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('chinaUnionPay_account', 'China Union Pay Account', 'trim|required|xss_clean');

            $this->form_validation->set_rules('bank_account_name', 'Bank account name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_name', 'Bank account name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_branch', 'Branch', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_province', 'Province', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_city', 'Bank city', 'trim|required|xss_clean');

            if ($this->form_validation->run()) {
                $amount = $this->input->post('amount_withdraw', true);

                $counterpartData = array(
                    'paytrust_account' => $this->input->post('chinaUnionPay_account', true),
                    'bank_account_name'=>$this->input->post('bank_account_name', true),
                    'bank_name'=>$this->input->post('bank_name', true),
                    'bank_branch'=>$this->input->post('bank_branch', true),
                    'bank_province'=>$this->input->post('bank_province', true),
                    'bank_city'=>$this->input->post('bank_city', true)

                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $amount,
                    'withdrawal_type' => 'BANK_MYR',   // main  CHINAUNIONPAY
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if (!$withdrawalProcess['error']) {
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                } else {
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }
            } else {
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );
        }
    }


    public function addBankMyr() {
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('chinaUnionPay_account', 'China Union Pay Account', 'trim|required|xss_clean');

            $this->form_validation->set_rules('bank_account_name', 'Bank account name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_name', 'Bank account name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_branch', 'Branch', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_province', 'Province', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_city', 'Bank city', 'trim|required|xss_clean');

            if ($this->form_validation->run()) {
                $amount = $this->input->post('amount_withdraw', true);

                $counterpartData = array(
                    'paytrust_account' => $this->input->post('chinaUnionPay_account', true),
                    'bank_account_name'=>$this->input->post('bank_account_name', true),
                    'bank_name'=>$this->input->post('bank_name', true),
                    'bank_branch'=>$this->input->post('bank_branch', true),
                    'bank_province'=>$this->input->post('bank_province', true),
                    'bank_city'=>$this->input->post('bank_city', true)

                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $amount,
                    'withdrawal_type' => 'BANK_MYR',   // main  CHINAUNIONPAY
                    'counterpart' => $counterpartData
                );
                
                    
                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);    
                    
                    
                if (!$withdrawalProcess['error']) {
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                } else {
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }
            } else {
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                json_encode(
                    array(
                        'success' => $isSuccess,
                        'transaction_data' => $transaction_data,
                        'errorMsg' => $errorMsg
                    )
                )
            );
        }
    }


    public function addChinaUnionPay() {
        if ($this->input->is_ajax_request()) {



                $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
                $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
                $this->form_validation->set_rules('chinaUnionPay_account', 'China Union Pay Account', 'trim|required|xss_clean');

                $this->form_validation->set_rules('bank_account_name', 'Bank account name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('bank_name', 'Bank account name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('bank_branch', 'Branch', 'trim|required|xss_clean');
                $this->form_validation->set_rules('bank_province', 'Province', 'trim|required|xss_clean');
                $this->form_validation->set_rules('bank_city', 'Bank city', 'trim|required|xss_clean');




            if ($this->form_validation->run()) {
                $amount = $this->input->post('amount_withdraw', true);




                    $counterpartData = array(
                        'chinaUnionPay_account' => $this->input->post('chinaUnionPay_account', true),
                        'bank_account_name'=>$this->input->post('bank_account_name', true),
                        'bank_name'=>$this->input->post('bank_name', true),
                        'bank_branch'=>$this->input->post('bank_branch', true),
                        'bank_province'=>$this->input->post('bank_province', true),
                        'bank_city'=>$this->input->post('bank_city', true)

                    );


                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $amount,
                    'withdrawal_type' => 'CHINAUNIONPAY',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if (!$withdrawalProcess['error']) {
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                } else {
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }
            } else {
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'success' => $isSuccess,
                            'transaction_data' => $transaction_data,
                            'errorMsg' => $errorMsg
                        )
                    )
                );
        }
    }





    public function addAlipay() {
        if ($this->input->is_ajax_request()) {



            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('aliPay_account', 'Alipay Account', 'trim|required|xss_clean');

            $this->form_validation->set_rules('bank_account_name', 'Bank account name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_name', 'Bank account name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_branch', 'Branch', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_province', 'Province', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_city', 'Bank city', 'trim|required|xss_clean');




            if ($this->form_validation->run()) {
                $amount = $this->input->post('amount_withdraw', true);




                $counterpartData = array(
                    'aliPay_account' => $this->input->post('aliPay_account', true),
                    'bank_account_name'=>$this->input->post('bank_account_name', true),
                    'bank_name'=>$this->input->post('bank_name', true),
                    'bank_branch'=>$this->input->post('bank_branch', true),
                    'bank_province'=>$this->input->post('bank_province', true),
                    'bank_city'=>$this->input->post('bank_city', true)

                );


                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $amount,
                    'withdrawal_type' => 'ALIPAY',   // main  CHINAUNIONPAY
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                if (!$withdrawalProcess['error']) {
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                } else {
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }
            } else {
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'success' => $isSuccess,
                            'transaction_data' => $transaction_data,
                            'errorMsg' => $errorMsg
                        )
                    )
                );
        }
    }






    public function getTradingProfit($account_info){
        $webservice_config = array('server' => 'live_new');
        $account_info = array(
            'iLogin' =>$account_info['iLogin'],
            'from' =>  $account_info['from'],
            'to' =>  $account_info['to']
        );

        $WebService = new WebService($webservice_config);
        $WebService->open_GetAccountTradesHistory($account_info);
        $sum = array();
        $total =  0;

        if($WebService->request_status === 'RET_OK'){
            $tradatalist = (array) $WebService->get_result('TradeDataList');
            if($tradatalist){
                foreach ( $tradatalist['TradeData'] as $object){
                    array_push($sum,$object->Profit);
                }
                $total =  array_sum($sum);
            }
        }
        return $total;
    }


    public function removeBonusProfit($params){
        $removeBonusesComment =  array(
            2 => 'BONUS PROFIT CLEAN UP'
        );

        $depositMethods = array(
            2 => 'Deposit_NoDepositBonus'
        );

        $amount = $params['amount'];
        $account_number = $params['account_number'];
        $bonusId = 2;
        $comment = $removeBonusesComment[$bonusId];
        $fund_status = 1;

        $webservice_config = array(
            'server' => 'live_new'
        );

        $remove_amount = $amount * -1;

        $account_info = array(
            'Amount' => $remove_amount,
            'Comment' => $comment,
            'AccountNumber' => $account_number,
            'Method' => $depositMethods[$bonusId]
        );

        $WebService = new WebService($webservice_config);
        $WebService->RequestCommonMethodBonus($account_info);
        $result = $WebService->result;

        if ($WebService->request_status === 'RET_OK') {
            $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
            $withdraw_data = array(
                'Account_number' => $account_number,
                'BonusProfit' => $amount,
                'IsCancel' => 1,
                'DateCancel' => $date,
                'Ticket' => $result['Ticket'],
                'IsRealfund' => $fund_status
            );

            $this->withdraw_model->insertWithdrawBonusProfit($withdraw_data);

            $WebServiceRequestAccBalance = new WebService($webservice_config);
            $WebServiceRequestAccBalance->request_live_account_balance($account_number);
            if ($WebServiceRequestAccBalance->request_status === 'RET_OK') {
                $balance = $WebServiceRequestAccBalance->get_result('Balance');
                $this->account_model->updateAccountBalance($account_number, $balance);
            }
        }
    }

    public function testDep(){
        $user_id = '135835';
        $totalDeposit = $this->deposit_model->getTotalDeposit($user_id,2);
        var_dump($totalDeposit);
    }

    public function checkWalletAccNumAndResellerDataModifiedtesttest() {
        if (!$this->input->is_ajax_request()) {
            die('Not authorized!');
        }
        if ($this->session->userdata('logged')) {
            $this->load->model('user_model');

            $returnData = array(
                'error'         => true,
                'error_message' => '',
            );


            $type = $this->input->post('type');





            if ($type) {
                $account_number = $this->input->post('partner_account_num');
                $check_acc_num = $this->user_model->getPartnerByAccount($account_number);
                $errorMsg = 'Account Number is either Client account or does not exist';
            } else {
                $account_number = $this->input->post('client_account_num');
                $check_acc_num = $this->user_model->getUserIdbyAccountNumber($account_number);
                $errorMsg = 'Account Number is either Partner account or does not exist';
            }

            $current_account_number = $this->input->post('current_account_num');
            if ($account_number == $current_account_number) {
                $returnData['error_message'] = 'You cannot make transfer to your own account';
            } else {
                if ($check_acc_num) {
                    $returnData['error'] = false;
                    $returnData['error_message'] = '';
                } else {
                    $returnData['error_message'] = $errorMsg;
                }
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'return' => $returnData,
                            'check' => $check_acc_num,
                        )
                    )
                );
        }
    }
    
    
public function checkAccountIsActiveOrnotTestFun(){
    
if(IPLoc::frz())
{
    echo "<pre>";

        $account_number=$_GET['frzid'];

         $this->load->library('FXAPI');
         $input = array(
            'From'   =>  0 ,
            'Limit'  =>  100,
            'Offset' =>  0,
            'To'     =>  0,
            'Accounts'=>array($account_number));

         $api_return_data=array(
             'data'=>false,
         );

        $api_data = FXAPI::GetAccountDetails($input);

        if($api_data['RET']=='RET_OK')
        {
           $api_return_data['data']= $api_data['data']->Accounts->AccountData;
        }    

        print_r($api_return_data);



        exit;



}  

}
    

    public function checkWalletAccNumAndResellerDataModified() {
        if (!$this->input->is_ajax_request()) {
            die('Not authorized!');
        }


        if ($this->session->userdata('logged')) {
            $this->load->model('user_model');

            $returnData = array(
                'error'  => true,
                'error_message' => '',
            );

           


            $transaction_type=$this->input->post('tranType');

            if(IPLoc::IPOnlyForTq()){


            echo $transaction_type; echo 'test'; exit();

            }



            $type = $this->input->post('type');
            if ($type) {
                $account_number = $this->input->post('partner_account_num');
                $check_acc_num = $this->user_model->getPartnerByAccount($account_number);
                $errorMsg = lang('its_71'); //"Account Number is either Client account or does not exist";
            } else {
                $account_number = $this->input->post('client_account_num');
                $check_acc_num = $this->user_model->getUserIdbyAccountNumber($account_number);
                $errorMsg = lang('its_72');
            }

            $current_account_number = $this->input->post('current_account_num');
            if ($account_number == $current_account_number) {
                $returnData['error_message'] = lang('its_73');
            } else {
                if ($check_acc_num) {
                    $returnData['error'] = false;
                    $returnData['error_message'] = '';
                } else {
                    $returnData['error_message'] = $errorMsg;
                }
            }



                if (!$type) {  

                    
                    
                    $isDeleted = false;                    
                    /*-----------------------------------------------------new API [FXPP-13473]----------------------------------------------*/    
                    $this->load->library('FXAPI');
                        $input = array(
                           'From'   =>  0 ,
                           'Limit'  =>  100,
                           'Offset' =>  0,
                           'To'     =>  0,
                           'Accounts'=>array($account_number));

                        $api_return_data=array(
                            'data'=>false,
                        );

                       $api_data = FXAPI::GetAccountDetails($input);



                        if($api_data['RET']=='RET_OK')
                        {

                            $api_return_data['data']= $api_data['data']->Accounts->AccountData;
                        }else{

                            $isDeleted = true;
                            $returnData['error'] = true;
                            $returnData['error_message'] = 'Unfortunately, your receiver account has been archived after 90 days inactivity period. Please, contact support department at support@forexmart.com if you want to restore the account';
                        }



                    
                    /*-----------------------------------------------------new API end ----------------------------------------------*/
                    
                   
                    
//                                        if(IPLoc::APIUpgradeDevIP()){
//                                            $webservice_config = array('server' => 'live_new');
//                                            $account_info = array('iLogin' => $account_number);
//                                            $WebServiceAD = $this->wsv->GetAccountDetailsSingle($account_info, $webservice_config);;
//                                            if ($WebServiceAD->result['IsDeleted'] == '1') {
//                                                $isDeleted = true;
//                                                $returnData['error'] = true;
//                                                $returnData['error_message'] = 'Unfortunately, your receiver account has been archived after 90 days inactivity period. Please, contact support department at support@forexmart.com if you want to restore the account.';
//
//                                        } else{ 
//                                            $webservice_config = array('server' => 'live_new');
//                                            $account_info = array('iLogin' => $account_number);
//                                            $WebServiceAD = new WebService($webservice_config);
//                                            $WebServiceAD->open_RequestAccountDetails($account_info);
//                                            if($WebServiceAD->request_status == 'RET_ACCOUNT_NOT_FOUND'){
//                                                $isDeleted = true;
//                                                $returnData['error'] = true;
//                                                $returnData['error_message'] = 'Unfortunately, your receiver account has been archived after 90 days inactivity period. Please, contact support department at support@forexmart.com if you want to restore the account';
//
//                                            }
//
//                                       }


                       
                       
                    $isMicro = $this->account_model->isMicro($check_acc_num[0]['user_id']);
                    $ForMarStaAcc = FXPP::get_standardgroup_v2($account_number);
                    $isNewAccountType = FXPP::fmGroupType($account_number);
                    $specailTransitAllow= FXPP::getTransitTransferAllowAccount($account_number);
                                  
                    $isPro = false;

                    if($isNewAccountType == 'ForexMart Pro'){
                        $isPro = true;
                    }



                    if ($ForMarStaAcc) {
                        $data['IsStandardAccount'] = true;
                    } else {
                        $data['IsStandardAccount'] = false;
                    }
                    $first_bonus_acquired = $this->deposit_model->getFirstPercentBonusAcquired($check_acc_num[0]['user_id']);
                    if(!$first_bonus_acquired){
                        $first_bonus_acquired = $this->deposit_model->getFirstPercentBonusAcquiredITS($account_number);
                        if($first_bonus_acquired['BonusType'] == 'tpb'){
                            $first_bonus_acquired['thirtypercentbonus'] = 1;
                        }
                        if($first_bonus_acquired['BonusType'] == 'fpb'){
                            $first_bonus_acquired['fiftypercentbonus'] = 1;
                        }
                        if($first_bonus_acquired['BonusType'] == 'twpb'){
                            $first_bonus_acquired['twentypercentbonus'] = 1;
                        }

                    }
                    $nodepositbonus = $this->general_model->showssingle2('users', 'id', $check_acc_num[0]['user_id'], 'nodepositbonus,created,createdforadvertising');
                    $bonus_selection = 'nobonus';
                    if ($nodepositbonus['nodepositbonus'] == 1) {
                        $bonus_selection = 'ndb';
                    } else {
                        if ($first_bonus_acquired) {
                            if ($first_bonus_acquired['fiftypercentbonus'] == 1) {
                                $bonus_selection = 'fpb';
                            } elseif ($first_bonus_acquired['thirtypercentbonus'] == 1) {
                                $bonus_selection = 'tpb';
                            } elseif ($first_bonus_acquired['hundredpercentbonus'] == 1) {
                                $bonus_selection = 'hpb';
                            } elseif ($first_bonus_acquired['fiftypercentlimitedbonus'] == 1) {
                                $bonus_selection = 'hpb';
                            } elseif ($first_bonus_acquired['twentypercentbonus'] == 1) {
                                $bonus_selection = 'twpb';
                            }
                        }
                    }
                }

               $full_name = $this->general_model->showssingle('user_profiles', 'user_id', $check_acc_num[0]['user_id'], 'full_name,user_id');


        }

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'return' => $returnData,
                            'check' => $check_acc_num,
                            'isMicro' => $isMicro,
                            'isStandard' => $data['IsStandardAccount'],
                            'specailTransitAllow'=>$specailTransitAllow,
                            'bonus_selection' => $bonus_selection,
                            'isNewAccountType' => $isNewAccountType,
                            'isPro' => $isPro,
                            'isDeleted' => $isDeleted,
                            'full_name' =>  $full_name['full_name'],
                        )
                    )
                );

    }

    public function getNetellerFee(){
        if (!$this->input->is_ajax_request()) { die('Not authorized!');}
        if ($this->session->userdata('logged')) {
            $userId = $this->session->userdata('user_id');
            $amount_withdraw = $this->input->post('amount');

            $account = $this->account_model->getAccountNumber($userId);
            $isMicro = $this->account_model->isMicro($userId);


            $fundData = FXPP::getAccountFunds($account['account_number']);
            $Balance = $fundData['balance'];
            $walletBalance = number_format($Balance, 2);

            $getTransactionFee = FXPP::getTransactionFee('NETELLER', $account['currency'], $amount_withdraw);

            $totalFee = FXPP::roundno($amount_withdraw * $getTransactionFee['fee'], 2);
            $totalFees = $totalFee + $getTransactionFee['addons'];
            $totalAmountDeduct = $amount_withdraw + $totalFees;
            $computeTotalBalance = $Balance - $totalAmountDeduct;

            if($computeTotalBalance > 0){
                $newBalance = $computeTotalBalance;
            }else{
                $newBalance = 0;
            }


            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'fee' => $getTransactionFee['fee'],
                            'add_ons' => $getTransactionFee['addons'],
                            'total_interest' => $totalFee,
                            'total_fees' => $totalFees,
                            'new_balance' => $newBalance,
                        )
                    )
                );
        }
    }

    public function payoma(){
        
            if(!FXPP::isPayomaPayMentAvailable('withdraw')) {
                show_404('accessing'); //FXPP-13573
            }

        

        


       if(FXPP::isEUUrl()){show_404('accessing');}
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $user_id = $this->session->userdata('user_id');
        
            $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
            $data['login_type'] = $mtas3['login_type'];

            //$data['partner_verified'] = true;

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

            $getTransactionFee = FXPP::getTransactionFee('PAYOMA', $account['currency']);
         

            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['disable_input'] = $user_status;



            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary details to process withdrawal request.';
            $this->template->title("ForexMart | Witdrawal Funds | payoma")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/payoma',$data);
        }else{
            redirect('signout');
        }
    }

    public function addPayoma(){
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('card_number', 'Card Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('card_name', 'Cardholder\'s name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('card_expiry_month', 'Cardholder\'s name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('card_expiry_year', 'Cardholder\'s name', 'trim|required|xss_clean');

            if($this->form_validation->run()){




                $card_number = $this->input->post('card_number',true);
                $card_name = $this->input->post('card_name',true);
                $card_expiry_month = $this->input->post('card_expiry_month',true);
                $card_expiry_year = $this->input->post('card_expiry_year',true);

                $counterpartData = array(
                    'card_number' => $card_number,
                    'card_name' => $card_name,
                    'card_expiry_month' => $card_expiry_month,
                    'card_expiry_year' => $card_expiry_year
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'PAYOMA',
                    'counterpart' => $counterpartData
                );

              //  $partner_verified = true;
                // FXPP-10320 disable clients that is under unverified partner/s account from submitting payoma withdrawal transactions until the partner has verified their accounts.
//                if($row = $this->account_model->isPartnerAcVerified($this->session->userdata('user_id')) ){
//                    if($row->accountstatus == 0){
//                        $partner_verified = false;
//                    }
//                }

               // if($partner_verified){
                    $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                    if(!$withdrawalProcess['error']){
                        $isSuccess = true;
                        $transaction_data = $withdrawalProcess['transaction_data'];
                    }else{
                        $isSuccess = false;
                        $errorMsg = $withdrawalProcess['errorMsg'];
                    }
//                }else{
//                    $isSuccess = false;
//                    $transaction_data = array();
//                    $errorMsg = "Your partner account is not verified";
//                }

               

            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'success' => $isSuccess,
                            'transaction_data' => $transaction_data,
                            'errorMsg' => $errorMsg
                        )
                    )
                );

        }
    }

    public function inpay(){


        redirect('withdraw');
        if($this->session->userdata('logged')) {
            $this->load->helper('language');
            //            $this->lang->load('depositwithdraw');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $user_id = $this->session->userdata('user_id');
            $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
            $data['login_type'] = $mtas3['login_type'];

            //$data['partner_verified'] = true;

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);
            if(!$this->session->userdata('login_type')){
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus =  $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }

                // FXPP-10320 disable clients that is under unverified partner/s account from submitting payoma withdrawal transactions until the partner has verified their accounts.
//                if($row = $this->account_model->isPartnerAcVerified($this->session->userdata('user_id')) ){
//                    if($row->accountstatus == 0){
//                        $data['partner_verified'] = false;
//                    }
//                }
            }else{
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }
            $getTransactionFee = FXPP::getTransactionFee('INPAY', $account['currency']);
            //            }

            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(), FXPP::getUserCountryCode());
            $data['ndb_bonus'] = $getNdbBonus;

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];
            $data['fee_details'] = ($getTransactionFee['fee'] * 100).'%';
            $data['disable_input'] = $user_status;



            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary details to process withdrawal request.';
            $this->template->title("ForexMart | Witdrawal Funds | Inpay")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/inpay',$data);
        }else{
            redirect('signout');
        }
    }

    public function addInpay(){
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_bank', 'Beneficiary\'s Bank', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_address', 'Beneficiary\'s Address', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_swift', 'Beneficiary\'s bank SWIFT', 'trim|required|xss_clean');
            // $this->form_validation->set_rules('beneficiary_account', 'Beneficiary\'s Account', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ibanoraccount_number', 'IBAN Or Account number', 'trim|required|xss_clean');
           // $this->form_validation->set_rules('bic_code', 'BIC Code', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_street', 'Street', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_city', 'City', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_state', 'State', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_country', 'Country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('beneficiary_postal', 'Postal Code', 'trim|required|xss_clean');

            if($this->form_validation->run()){

                $beneficiary_bank = $this->input->post('beneficiary_bank',true);
                $beneficiary_address = $this->input->post('beneficiary_address',true);
                $beneficiary_swift = $this->input->post('beneficiary_swift',true);
                //$beneficiary_account = $this->input->post('beneficiary_account',true);
                $beneficiary_iban = $this->input->post('ibanoraccount_number',true);
               // $beneficiary_biccode = $this->input->post('bic_code',true);
                $beneficiary_street = $this->input->post('beneficiary_street',true);
                $beneficiary_city= $this->input->post('beneficiary_city',true);
                $beneficiary_state = $this->input->post('beneficiary_state',true);
                $beneficiary_country = $this->input->post('beneficiary_country',true);
                $beneficiary_postal = $this->input->post('beneficiary_postal',true);

                $counterpartData = array(
                    'beneficiary_bank' => $beneficiary_bank,
                    'beneficiary_address' => $beneficiary_address,
                    'beneficiary_swift' => $beneficiary_swift,
                    //'beneficiary_account' => $beneficiary_account,
                    'ibanoraccount_number' =>  $beneficiary_iban,
                   // 'bic_code' => $beneficiary_biccode,
                    'beneficiary_street' => $beneficiary_street,
                    'beneficiary_city' => $beneficiary_city,
                    'beneficiary_state' => $beneficiary_state,
                    'beneficiary_country' => $beneficiary_country,
                    'beneficiary_postal' => $beneficiary_postal
                );

                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $this->input->post('amount_withdraw',true),
                    'withdrawal_type' => 'INPAY',
                    'counterpart' => $counterpartData
                );

               // $partner_verified = true;
                // FXPP-10320 disable clients that is under unverified partner/s account from submitting payoma withdrawal transactions until the partner has verified their accounts.
//                if($row = $this->account_model->isPartnerAcVerified($this->session->userdata('user_id')) ){
//                    if($row->accountstatus == 0){
//                        $partner_verified = false;
//                    }
//                }

              //  if($partner_verified){
                    $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

                    if(!$withdrawalProcess['error']){
                        $isSuccess = true;
                        $transaction_data = $withdrawalProcess['transaction_data'];
                    }else{
                        $isSuccess = false;
                        $errorMsg = $withdrawalProcess['errorMsg'];
                    }
//                }else{
//                    $isSuccess = false;
//                    $transaction_data = array();
//                    $errorMsg = "Your partner account is not verified";
//                }



            }else{
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'success' => $isSuccess,
                            'transaction_data' => $transaction_data,
                            'errorMsg' => $errorMsg
                        )
                    )
                );

        }
    }

    public function validate_transfer($user_id){
        $getAccountnumber = $this->account_model->getAccountsByUserId($user_id);
        $getAccountBonusByType = FXPP::getAccountBonusByType($getAccountnumber[0]['account_number']);
        $getTotalNoDepositBonus = $getAccountBonusByType[2];

      $total_deposit = $this->deposit_model->getTotalDeposit($user_id,2);
      $total_transfer = $this->deposit_model->getTotalDepositTransit($getAccountnumber[0]['account_number'],2);
       $total_fund = $total_deposit + $total_transfer;

        if($getTotalNoDepositBonus > 0 && $total_fund <= 0){
            return true;
        }
        return false;

    }


    public function local_depositor_myr(){
        if ( IPLoc::for_my_only() || FXPP::isMalaysianCountry() || IPLoc::Office_and_Vpn()) {
            if ($this->session->userdata('logged')) {
                $data['isWithdraw'] = 'withdraw';
                $this->template->title(lang('dep_tit'))
                    ->set_layout('internal/main')
                    ->prepend_metadata("")
                    ->build('deposits/local_depositor_myr', $data);
            } else {
                redirect('signout');
            }
        } else {
            redirect(FXPP::loc_url('withdraw'));
        }
    }

    public function local_depositor_idr(){
        if ( IPLoc::for_id_only() || FXPP::isIndonesianCountry() || IPLoc::Office_and_Vpn()) {
            if ($this->session->userdata('logged')) {
                $data['isWithdraw'] = 'withdraw';
                $this->template->title(lang('dep_tit'))
                    ->set_layout('internal/main')
                    ->prepend_metadata("")
                    ->build('withdrawnew/local_bank_id', $data);
            } else {
                redirect('signout');
            }
        } else {
            redirect(FXPP::loc_url('withdraw'));
        }
    }


    public function  testlimit($user_id){

        $result = $this->validate_transfer($user_id);
        if ($result) {
            echo "Please deposit an amount equals or more than  the bonus profit.";
        } else {
            echo "Withdrawal Successful";
        }
    }

        public function withdrawalProcess2($withdrawalData){
            $this->load->library('Fx_mailer');
            $this->lang->load('modal_message',$this->session->userdata('site_lang')); // Please do not remove.

            $amount_withdraw = $withdrawalData['amount'];
            $userId = $withdrawalData['user_id'];
            $counterpart = $withdrawalData['counterpart'];
            $withdrawalType = $withdrawalData['withdrawal_type'];
            $getWithdrawalType = $this->transaction_type[$withdrawalType];

            $returnData = array(
                'error' => true,
                'errorMsg' => lang('m_wth_14'),
            );


            if(!$this->session->userdata('login_type')){
                $user_status = $this->account_model->getAccountStatus($userId);
            }else{
                $user_status = $this->account_model->getVerificationStatus($userId);
            }

            if(!$user_status){
                return $returnData;
            }

            $account = $this->account_model->getAccountNumber($userId);
            $currency = $account['currency'];
            $currencyStatus = $this->currency_status[$account['currency']];
            $isMicro = $this->account_model->isMicro($userId);
            if($isMicro){
                $currencyStatus = $this->currency_status['Cents'];
                $currency = $account['currency'].'c';
            }

            $account_number = $account['account_number'];


            if($withdrawalType === 'NETELLER'){
                $getTransactionFee = FXPP::getTransactionFee($withdrawalType, $account['currency'], $amount_withdraw);
            }else{
                $getTransactionFee = FXPP::getTransactionFee($withdrawalType, $account['currency']);
            }

            $totalFee = FXPP::roundno($amount_withdraw * $getTransactionFee['fee'], 2);

            if($withdrawalType === 'SKRILL'){
                $skrillSystemFee = $this->SkrillSystemFee($amount_withdraw, $account['currency']);
                $totalFee = $totalFee + $skrillSystemFee;
            }
            echo '<pre>';

            $totalFees = $totalFee + $getTransactionFee['addons'];
            var_dump($getTransactionFee['addons']);

            $amount_deducted =  FXPP::roundno($amount_withdraw + $totalFees, 2);

            $requestData = array(
                'totalAmount' => $amount_deducted,
                'amountRequested' => $amount_withdraw,
                'totalFee' => $totalFees,
                'currency' => $account['currency'],
                'account_number' => $account_number,
                'addons' => $getTransactionFee['addons'],
                'fee' => $getTransactionFee['fee'],
                'user_id' => $userId
            );
            print_r($requestData);


//        if(IPLoc::Office()){
//            echo "<pre>";
//            print_r('test_validateAccountFund<br>');
//            print_r($requestData);
//            echo "<br>";
//        }

            $validateAccountFund = $this->validateAccountFund($requestData);


//        if(IPLoc::Office()){
//            echo "<pre>";
//            print_r('test_validateAccountFund_after<br>');
//            print_r($validateAccountFund);
//        }
            $dateFailed = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
            $insertWithdrawFailed = array(
                'transaction_id	' => 0,
                'status	' => 0,
                'amount	' => $amount_withdraw,
                'currency' => $currency,
                'user_id' => $userId,
                'payment_date' => $dateFailed,
                'transaction_type' => $getWithdrawalType,
                'payment_status	' => $this->paymentType_status[$withdrawalType],
                'currency_status' =>  $currencyStatus,
                'fee' => $totalFee,
                'isFailed' => 0,
                'type' => 'withdraw',
                'comment' => $validateAccountFund['errorMsg'],
                'details' =>  json_encode($validateAccountFund['detailsfunds'])
            );
            if($validateAccountFund['error']){
                $returnData['errorMsg'] = $validateAccountFund['errorMsg'];
                $this->general_model->insert('no_status_transaction', $insertWithdrawFailed);
                return $returnData;
            }

            // generate reference number for MT4 Comment
            $new_date = new DateTime();
            $generated_transaction_number = $new_date->getTimestamp();
            $comment = $this->comment_type['withdraw'] . $this->comment_transaction_type[$withdrawalType] . $generated_transaction_number;

            $service_data = array(
                'Amount' => $amount_deducted,
                'Comment' => $comment,
                'Receiver' => 0,
                'AccountNumber' => $account_number,
                'ProcessByIP' => $this->input->ip_address()
            );

            print_r($service_data);



        }


        public function testamount(){
            $counterpartData = array(
                'card_number' => '12345',
                'card_name' => 'test',
                'card_expiry_month' => '123',
                'card_expiry_year' => '556'
            );

            $withdrawalData = array(
                'user_id' =>'341513',
                'amount' => 300,
                'withdrawal_type' => 'PAYOMA',
                'counterpart' => $counterpartData
            );

            $withdrawalProcess = $this->withdrawalProcess2($withdrawalData);
        }





//        $this->load->model('partners_model');
//        $partner_user_id = $this->session->userdata('user_id');
//      //  $request_status = $this->partners_model->getPartnerRequestTranferStatus($partner_user_id);
//        $request_status =  $this->general_model->whereCondition('internal_transfer',array('user_id'=>$partner_user_id),'*');
//       $res = $this->checkAmountTransferred($account_number, $amount);
//        $condition_2 = ($res['error'] && $request_status['auto_transfer'] == 1); // partner with auto transfer permission is now allowed to transfer even exceeding the limit but still their request is for approval.
//
//      var_dump($request_status['auto_transfer']);
//       // print_r($request_status);
//       if($request_status <> 1 || $condition_2 ){
//           echo "yes";
//       }else{
//           echo "no";
//       }



    public function profit($account){
        $profit =  FXPP::realProfit($account);
        var_dump($profit);
    }

    
    
    
    
    
    
    
     public function bank_transfer_thb() {
        if ($this->session->userdata('logged')) {
            $this->load->helper('language');

          if(IPLoc::for_th_only() || IPLoc::IPOnlyForVenus() || FXPP::isThailandCountry() || IPLoc::JustG()){
            
            
            
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
                   
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);


           /* if (!$this->session->userdata('login_type')) {
                $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                    $user_status = true;
                }
            } else {
                $getNdbBonus = 0;
                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
            }*/

              $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $getTransactionFee = FXPP::getTransactionFee('BANK_THB', $account['currency']);
            $data['fee_details'] = ($getTransactionFee['fee'] * 100) . '% + ' . $getTransactionFee['addons'] . ' ' . $account['currency'];

            $data['ndb_bonus'] = 0;
          //  $data['cup_details'] = $this->general_model->showssingle('chinaunionpay_deposit',"user_id",$this->session->userdata('user_id'),$select="*");

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];

            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(), FXPP::getUserCountryCode());

            $data['disable_input'] = $user_status;

            $js = $this->template->Js();
            $data['metadata_description'] = 'Please fill in all the appropriate fields to facilitate withdrawal of funds by THB.';
            $this->template->title("Withdrawal Option - Bank Transfer THB")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build(FXPP::buildUpPage('withdraw/bank_thb'), $data);
          
           } 
           else{
              redirect('signout');
             }  
            
        } else {
            redirect('signout');
        }
    }
    
      
    


  public function addBankThb() {
        if ($this->input->is_ajax_request()) {



                $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
                $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
                $this->form_validation->set_rules('thb_account', 'THB Account', 'trim|required|xss_clean');

                $this->form_validation->set_rules('bank_account_name', 'Bank account name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('bank_name', 'Bank account name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('bank_branch', 'Branch', 'trim|required|xss_clean');
                $this->form_validation->set_rules('bank_province', 'Province', 'trim|required|xss_clean');
                $this->form_validation->set_rules('bank_city', 'Bank city', 'trim|required|xss_clean');




            if ($this->form_validation->run()) {
                $amount = $this->input->post('amount_withdraw', true);




                    $counterpartData = array(
                        'paytrust_account' => $this->input->post('thb_account', true),
                        'bank_account_name'=>$this->input->post('bank_account_name', true),
                        'bank_name'=>$this->input->post('bank_name', true),
                        'bank_branch'=>$this->input->post('bank_branch', true),
                        'bank_province'=>$this->input->post('bank_province', true),
                        'bank_city'=>$this->input->post('bank_city', true)

                    );


                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $amount,
                    'withdrawal_type' => 'BANK_THB',
                    'counterpart' => $counterpartData
                );

            $withdrawalProcess = $this->withdrawalProcess($withdrawalData);
  

                if (!$withdrawalProcess['error']) {
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                } else {
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }
            } else {
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'success' => $isSuccess,
                            'transaction_data' => $transaction_data,
                            'errorMsg' => $errorMsg
                        )
                    )
                );
        }
    }




    public function btcFeeTest(){
        $processing_fee = FXPP::bitcoinToWalletCurrency('USD',0.0002); // processing fee
        var_dump($processing_fee);
        $free_fee_max_amount = FXPP::bitcoinToWalletCurrency('USD',0.001); // minimum amount without fee
            var_dump($free_fee_max_amount);
    }


    public function payment_asia() {
        if ($this->session->userdata('logged')) {
            $this->load->helper('language');

//            if(IPLoc::IPOnlyForG() || IPLoc::IPOnlyForVenus() || $this->session->userdata('account_number') == '58071244'){
            if(IPLoc::Office() || IPLoc::for_vn_only() || FXPP::isVietnamCountry()){



                $data['active_tab'] = 'finance';
                $data['active_sub_tab'] = 'withdraw';

                $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));

                $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);


                /*if (!$this->session->userdata('login_type')) {
                    $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                    $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                    // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                    if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                        $user_status = true;
                    }
                } else {
                    $getNdbBonus = 0;
                    $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
                }*/

                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

                $getTransactionFee = FXPP::getTransactionFee('ASIA_VND', $account['currency']);
                $data['fee_details'] = ($getTransactionFee['fee'] * 100) . '% + ' . $getTransactionFee['addons'] . ' ' . $account['currency'];

                $data['ndb_bonus'] = 0;
                //  $data['cup_details'] = $this->general_model->showssingle('chinaunionpay_deposit',"user_id",$this->session->userdata('user_id'),$select="*");

                $data['fee'] = $getTransactionFee['fee'];
                $data['add_on'] = $getTransactionFee['addons'];

                $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(), FXPP::getUserCountryCode());

                $data['disable_input'] = $user_status;

                $js = $this->template->Js();
                $data['metadata_description'] = 'Please fill in all the appropriate fields to facilitate withdrawal of funds by VND.';
                $this->template->title("Withdrawal Option - Bank Transfer VND")
                    ->set_layout('internal/main')
                    ->prepend_metadata(
                        "<script src='" . $js . "jquery.autonumeric.js'></script>
                        <script src='" . $js . "custom-withdraw.js'></script>"
                    )
                    ->build(FXPP::buildUpPage('withdraw/vnd_asia'), $data);

            }
            else{
                redirect('signout');
            }

        } else {
            redirect('signout');
        }
    }

    public function bank_transfer_vnd() {
        if ($this->session->userdata('logged')) {
            $this->load->helper('language');

            if(IPLoc::JustG() || IPLoc::IPOnlyForVenus() || IPLoc::for_vn_only() || FXPP::isVietnamCountry()){



                $data['active_tab'] = 'finance';
                $data['active_sub_tab'] = 'withdraw';

                $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));

                $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);


                /*if (!$this->session->userdata('login_type')) {
                    $getBonus = $this->account_model->getAccountsByUserIdRow($this->session->userdata('user_id'));
                    $getNdbBonus = $this->getWithdrawBonusFee20($getBonus['ndb_bonus']);
                    // $user_status = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
                    if( $this->account_model->getAccountStatus($this->session->userdata('user_id'))){
                        $user_status = true;
                    }
                } else {
                    $getNdbBonus = 0;
                    $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
                }*/

                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

                $getTransactionFee = FXPP::getTransactionFee('BANK_VND', $account['currency']);
                $data['fee_details'] = ($getTransactionFee['fee'] * 100) . '% + ' . $getTransactionFee['addons'] . ' ' . $account['currency'];

                $data['ndb_bonus'] = 0;
                //  $data['cup_details'] = $this->general_model->showssingle('chinaunionpay_deposit',"user_id",$this->session->userdata('user_id'),$select="*");

                $data['fee'] = $getTransactionFee['fee'];
                $data['add_on'] = $getTransactionFee['addons'];

                $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(), FXPP::getUserCountryCode());

                $data['disable_input'] = $user_status;

                $js = $this->template->Js();
                $data['metadata_description'] = 'Please fill in all the appropriate fields to facilitate withdrawal of funds by VND.';
                $this->template->title("Withdrawal Option - Bank Transfer VND")
                    ->set_layout('internal/main')
                    ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                    ->build(FXPP::buildUpPage('withdraw/bank_vnd'), $data);

            }
            else{
                redirect('signout');
            }

        } else {
            redirect('signout');
        }
    }

    public function addBankVnd() {
        if ($this->input->is_ajax_request()) {



            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('vnd_account', 'VND Account', 'trim|required|xss_clean');

            $this->form_validation->set_rules('bank_account_name', 'Bank account name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_name', 'Bank account name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_branch', 'Branch', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_province', 'Province', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_city', 'Bank city', 'trim|required|xss_clean');




            if ($this->form_validation->run()) {
                $amount = $this->input->post('amount_withdraw', true);




                $counterpartData = array(
                    'paytrust_account' => $this->input->post('vnd_account', true),
                    'bank_account_name'=>$this->input->post('bank_account_name', true),
                    'bank_name'=>$this->input->post('bank_name', true),
                    'bank_branch'=>$this->input->post('bank_branch', true),
                    'bank_province'=>$this->input->post('bank_province', true),
                    'bank_city'=>$this->input->post('bank_city', true)

                );


                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $amount,
                    'withdrawal_type' => 'BANK_VND',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);


                if (!$withdrawalProcess['error']) {
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                } else {
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }
            } else {
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'success' => $isSuccess,
                            'transaction_data' => $transaction_data,
                            'errorMsg' => $errorMsg
                        )
                    )
                );
        }
    }

    public function addBankVndAsia() {
        if ($this->input->is_ajax_request()) {



            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('vndasia_account', 'VND Account', 'trim|required|xss_clean');

            $this->form_validation->set_rules('bank_account_name', 'Bank account name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_name', 'Bank account name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_branch', 'Branch', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_province', 'Province', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_city', 'Bank city', 'trim|required|xss_clean');




            if ($this->form_validation->run()) {
                $amount = $this->input->post('amount_withdraw', true);




                $counterpartData = array(
                    'bank_account_number' => $this->input->post('vndasia_account', true),
                    'bank_account_name'=>$this->input->post('bank_account_name', true),
                    'bank_name'=>$this->input->post('bank_name', true),
                    'bank_branch'=>$this->input->post('bank_branch', true),
                    'bank_province'=>$this->input->post('bank_province', true),
                    'bank_city'=>$this->input->post('bank_city', true)

                );


                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $amount,
                    'withdrawal_type' => 'ASIA_VND',
                    'counterpart' => $counterpartData
                );



                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);

//                print_r($withdrawalProcess);
//                die();

                if (!$withdrawalProcess['error']) {
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                } else {
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }
            } else {
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'success' => $isSuccess,
                            'transaction_data' => $transaction_data,
                            'errorMsg' => $errorMsg
                        )
                    )
                );
        }
    }

    public function bank_transfer_idr() {
        if ($this->session->userdata('logged')) {

           // if(!FXPP::isReferralsOfAccount('IDR')){redirect(FXPP::my_url('my-account'));}
            if(IPLoc::Office() || IPLoc::for_id_only() || FXPP::isIndonesianCountry()) {

                $data['active_tab'] = 'finance';
                $data['active_sub_tab'] = 'withdraw';

                $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));

                $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

                if(IPLoc::Office()){
                    $this->load->library('WSV'); //New web service
                    $WSV = new WSV();
                    $WebService2 = $WSV->GetAccountFunds($account['account_number']);

                    //$resData = FXPP::getAccountFunds($account['account_number']);


                    if($WebService2['ErrorMessage'] === "RET_OK"){
                        $data['getTotalRealFund']               = $WebService2['Data']->TotalRealFund;
                        $data['getTotalBonusFund']              = $WebService2['Data']->TotalBonusFund;
                        $data['getWithrawableRealFund']         = $WebService2['Data']->Withrawable_RealFund;

                    } else {
                        $data['getTotalRealFund']               = 0;
                        $data['getTotalBonusFund']              = 0;
                        $data['getWithrawableRealFund']         = 0;
                        $data['apiSystemError']                 = true;
                        $data['apiSystemError2']                 = $WebService2['ErrorMessage'];
                    }

//                    echo '<pre>'; print_r($resData);
//                    echo '<pre>'; print_r($data);
//                     echo '<pre>'; print_r($WebService2);exit;
                }
                //exit();

        

                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

                $getTransactionFee = FXPP::getTransactionFee('BANK_IDR', $account['currency']);
                $data['fee_details'] = ($getTransactionFee['fee'] * 100) . '% + ' . number_format((float)$getTransactionFee['addons'], 2, '.', '') . ' ' . $account['currency'];
//                $data['fee_details'] = number_format((float)$datafee_details, 2, '.', '');

                $data['ndb_bonus'] = 0;
                $data['getCurrency'] = $this->session->userdata('currency');
                //$data['getCurrency'] = 'RUB';

                $data['fee'] = $getTransactionFee['fee'];
                $data['add_on'] = $getTransactionFee['addons'];

                $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(), FXPP::getUserCountryCode());

                $data['disable_input'] = $user_status;

                $js = $this->template->Js();
                $data['metadata_description'] = 'Please fill in all the appropriate fields to facilitate withdrawal of funds by IDR.';
                $this->template->title("Withdrawal Option - Bank Transfer IDR")
                    ->set_layout('internal/main')
                    ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                    ->build(FXPP::buildUpPage('withdraw/bank_idr'), $data);


            }
        } else {
            redirect('signout');
        }
    }





    public function addBankIdr() {
        if ($this->input->is_ajax_request()) {



            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('idr_account', 'IDR Account', 'trim|required|xss_clean');

            $this->form_validation->set_rules('bank_account_name', 'Bank account name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_name', 'Bank account name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_branch', 'Branch', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_province', 'Province', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_city', 'Bank city', 'trim|required|xss_clean');




            if ($this->form_validation->run()) {
                $amount = $this->input->post('amount_withdraw', true);




                $counterpartData = array(
                    'paytrust_account' => $this->input->post('idr_account', true),
                    'bank_account_name'=>$this->input->post('bank_account_name', true),
                    'bank_name'=>$this->input->post('bank_name', true),
                    'bank_branch'=>$this->input->post('bank_branch', true),
                    'bank_province'=>$this->input->post('bank_province', true),
                    'bank_city'=>$this->input->post('bank_city', true)

                );


                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $amount,
                    'withdrawal_type' => 'BANK_IDR',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);


                if (!$withdrawalProcess['error']) {
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                } else {
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }
            } else {
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'success' => $isSuccess,
                            'transaction_data' => $transaction_data,
                            'errorMsg' => $errorMsg
                        )
                    )
                );
        }
    }

    public function bank_transfer_ngn() {
        if ($this->session->userdata('logged')) {

            // if(!FXPP::isReferralsOfAccount('IDR')){redirect(FXPP::my_url('my-account'));}
            if(IPLoc::Office()  || FXPP::isNigerianCountry()) {

                $data['active_tab'] = 'finance';
                $data['active_sub_tab'] = 'withdraw';

                $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));

                $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);




                $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

                $getTransactionFee = FXPP::getTransactionFee('BANK_NGN', $account['currency']);
                $data['fee_details'] = ($getTransactionFee['fee'] * 100) . '% + ' . $getTransactionFee['addons'] . ' ' . $account['currency'];

                $data['ndb_bonus'] = 0;

                $data['fee'] = $getTransactionFee['fee'];
                $data['add_on'] = $getTransactionFee['addons'];

                $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(), FXPP::getUserCountryCode());

                $data['disable_input'] = $user_status;

                $js = $this->template->Js();
                $data['metadata_description'] = 'Please fill in all the appropriate fields to facilitate withdrawal of funds by IDR.';
                $this->template->title("Withdrawal Option - Bank Transfer NGN")
                    ->set_layout('internal/main')
                    ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                    ->build(FXPP::buildUpPage('withdraw/bank_ngn'), $data);


            }
        } else {
            redirect('signout');
        }
    }



    public function addBankNgn() {
        if ($this->input->is_ajax_request()) {



            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount_withdraw', 'Amount to withdraw', 'trim|numeric|required|xss_clean');
            $this->form_validation->set_rules('bank_accountnumber', 'Bank Account Number', 'trim|required|xss_clean');

            $this->form_validation->set_rules('bank_account_name', 'Bank account name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_name', 'Bank  name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_branch', 'Branch', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_province', 'Province', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_city', 'Bank city', 'trim|required|xss_clean');




            if ($this->form_validation->run()) {
                $amount = $this->input->post('amount_withdraw', true);




                $counterpartData = array(
                    'bank_account_number' => $this->input->post('bank_accountnumber', true),
                    'bank_account_name'=>$this->input->post('bank_account_name', true),
                    'bank_name'=>$this->input->post('bank_name', true),
                    'bank_branch'=>$this->input->post('bank_branch', true),
                    'bank_province'=>$this->input->post('bank_province', true),
                    'bank_city'=>$this->input->post('bank_city', true)

                );


                $withdrawalData = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'amount' => $amount,
                    'withdrawal_type' => 'BANK_NGN',
                    'counterpart' => $counterpartData
                );

                $withdrawalProcess = $this->withdrawalProcess($withdrawalData);


                if (!$withdrawalProcess['error']) {
                    $isSuccess = true;
                    $transaction_data = $withdrawalProcess['transaction_data'];
                } else {
                    $isSuccess = false;
                    $errorMsg = $withdrawalProcess['errorMsg'];
                }
            } else {
                $errorMsg = 'Your withdrawal request failed.';
                $isSuccess = false;
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'success' => $isSuccess,
                            'transaction_data' => $transaction_data,
                            'errorMsg' => $errorMsg
                        )
                    )
                );
        }
    }

    public function computeLotsRequired($acccount){

        $totalVolumeTraded = 0;
        $totalBonus = 0;
        $from = date('Y-m-d', strtotime('2015-01-01'));
        $to = date('Y-m-d', strtotime('now'));


        $account_info = array(
            'iLogin' => $acccount,
            'from'   =>  date('Y-m-d\T00:00:00', strtotime($from)),
            'to'     =>  date('Y-m-d\T23:59:59', strtotime($to)),
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->Open_GetMonthlyLots($account_info);

        switch($WebService->request_status){
            case 'RET_OK':
                $lostArray = $WebService->get_result('Lots');
                foreach ($lostArray->KeyValuePairOfdateTimedouble as $key => $val){
                    $totalVolumeTraded += $val->value;
                }
                break;

        }


        if($totalVolumeTraded > ($totalBonus * 0.02)){

        }else{


        }

    }






    public function idr_local_bank_transfer(){


        if ($this->session->userdata('logged')) {
            if(IPLoc::Office() || FXPP::isIndonesianCountry()) {

            $account = $this->account_model->getAccountByUserId($this->session->userdata('user_id'));
            $data['currency'] = $account['mt_currency_base'];
            $data['amount'] = $this->input->post_get('amount1', true);

            $this->template->title("ForexMart | Deposit - Bank transfer in IDR")
                ->set_layout('internal/main')
                ->append_metadata_css("
                       <link rel='stylesheet' href='" . $this->template->Css() . "deposit.css'>
                 ")
                ->build('withdrawnew/choose_bank_transfer_idr', $data);
            } else {
                redirect(FXPP::loc_url('withdraw'));
            }
        } else {
            redirect('signout');
        }
    }

    public function myr_local_bank_transfer(){

        if ($this->session->userdata('logged')) {
            if(IPLoc::Office() || FXPP::isMalaysianCountry()) {

            $account = $this->account_model->getAccountByUserId($this->session->userdata('user_id'));
            $data['currency'] = $account['mt_currency_base'];
            $data['amount'] = $this->input->post_get('amount1', true);

            $this->template->title("ForexMart | Deposit - Bank transfer in MYR")
                ->set_layout('internal/main')
                ->append_metadata_css("
                       <link rel='stylesheet' href='" . $this->template->Css() . "deposit.css'>
                 ")
                ->build('withdrawnew/choose_bank_transfer_myr', $data);
            } else {
                redirect(FXPP::loc_url('withdraw'));
            }
        } else {
            redirect('signout');
        }
    }

    public function thb_local_bank_transfer(){

        if ($this->session->userdata('logged')) {
            if(IPLoc::Office() || FXPP::isThailandCountry()) {

            $account = $this->account_model->getAccountByUserId($this->session->userdata('user_id'));
            $data['currency'] = $account['mt_currency_base'];
            $data['amount'] = $this->input->post_get('amount1', true);

            $this->template->title("ForexMart | Deposit - Bank transfer in THB")
                ->set_layout('internal/main')
                ->append_metadata_css("
                       <link rel='stylesheet' href='" . $this->template->Css() . "deposit.css'>
                 ")
                ->build('withdrawnew/choose_bank_transfer_thb', $data);
            } else {
                redirect(FXPP::loc_url('withdraw'));
            }
        } else {
            redirect('signout');
        }
    }


    public function vnd_local_bank_transfer(){

        if ($this->session->userdata('logged')) {
            if(IPLoc::Office() || FXPP::isVietnamCountry()) {
                $account = $this->account_model->getAccountByUserId($this->session->userdata('user_id'));
                $data['currency'] = $account['mt_currency_base'];
                $data['amount'] = $this->input->post_get('amount1', true);

                $this->template->title("ForexMart | Withdraw - Bank transfer in VND")
                    ->set_layout('internal/main')
                    ->append_metadata_css("
                       <link rel='stylesheet' href='" . $this->template->Css() . "deposit.css'>
                 ")
                    ->build('withdrawnew/choose_bank_transfer_vnd', $data);
            } else {
                redirect(FXPP::loc_url('withdraw'));
            }

        } else {
            redirect('signout');
        }
    }

    public function zotapay_card(){
        
           // FXPP-13853
        redirect('withdraw/');
        
        
        if($this->session->userdata('logged')) {
            if (!FXPP::isZotapayPayMentAvailable()) {
                show_404('accessing');
            }
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $user_id = $this->session->userdata('user_id');

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

            $getTransactionFee = FXPP::getTransactionFee('ZOTAPAY_CARD', $account['currency']);


            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));

            $data['ndb_bonus'] = 0;
            $data['disable_input'] = $user_status;

            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];


            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary details to process withdrawal request.';
            $this->template->title("ForexMart | Witdrawal Funds | Debit/Credit Cards")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/debit_credit_cards_zotapay',$data);
        }else{
            redirect('signout');
        }
    }


    public function nova2pay(){
        
        if($this->session->userdata('logged')) {
         
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'withdraw';
            $user_id = $this->session->userdata('user_id');
   
            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);
   
            $getTransactionFee = FXPP::getTransactionFee('NOVA2PAY', $account['currency']);
   
   
            $user_status = $this->account_model->getVerificationStatus($this->session->userdata('user_id'));
   
            $data['ndb_bonus'] = 0;
            $data['disable_input'] = $user_status;
   
            $data['fee'] = $getTransactionFee['fee'];
            $data['add_on'] = $getTransactionFee['addons'];
   
   
            $js = $this->template->Js();
            $data['metadata_description'] = 'Provide the necessary details to process withdrawal request.';
            $this->template->title("ForexMart | Witdrawal Funds | Debit/Credit Cards")
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $js . "jquery.autonumeric.js'></script>")
                ->build('withdrawnew/debit_credit_cards_nova2pay',$data);
        }else{
            redirect('signout');
        }
    }



    public function testBTC(){
        $amount_withdraw = '2960';

        $getTransactionFee = FXPP::getTransactionFee('BTC', 'USD');


        $totalFee = FXPP::roundno($amount_withdraw * $getTransactionFee['fee'], 2);
        $withdrawalType = 'BITCOIN';

        if($withdrawalType === 'BITCOIN'){
            $processing_fee = FXPP::bitcoinToWalletCurrency('USD',0.0002); // processing fee
           $free_fee_max_amount = FXPP::bitcoinToWalletCurrency('USD',0.001); // minimum amount without fee


            if($amount_withdraw >= $free_fee_max_amount){
                echo 'max-fee - ' .$free_fee_max_amount;
                echo '<br>';
               echo $totalFee = $totalFee + $processing_fee ;    echo '<br>';
                $getTransactionFee['fee'] = $totalFee;
            }


        }


      echo 'total fee -' . $totalFees = $totalFee + $getTransactionFee['addons'];  echo '<br>';

        echo   'amount-deducted - ' . $amount_deducted =  FXPP::roundno($amount_withdraw + $totalFees, 2);
        $totalBalance = 2964.07;


        if($amount_deducted > $totalBalance){
            echo 'not allowed';
        }else{
            echo 'allowed';
        }
    }


    private $isSupporter = false;

    private $bonusPercent =  array(
        'tpb'  => 0.30,
        'twpb' => 0.20,
        'fpb'  => 0.50,
    );
    private $bonusPercentByID =  array(
        '1'  => 0.30,
        '28' => 0.20,
        '10'  => 0.50,
    );

public function bonuses_statistic(){
		$this->load->model('General_model');
        $this->load->model('user_model');
        $this->g_m=$this->General_model;
        $this->load->model('Task_model');
        $this->t_m=$this->Task_model;
        $this->lang->load('bonus');
        $this->lang->load('modal_message');
        $this->lang->load('bonus'); 
		$this->load->model('account_model');
		
		FXPP::LoginTypeRestriction();            
	   
		$userId = $this->session->userdata('user_id');
		$currency = $this->session->userdata('currency');
		$account_number = $this->session->userdata('account_number');
		$accountsByUserIdRow = $this->account_model->getAccountsByUserIdRow($userId);
		
		FXPP::allowedBonuses($account_number);
		$getAccountSummaryDetails = self::getAccountSummaryDetailstest($account_number);    
		$getBonusId = self::getBonusId($account_number);  
		$data['accountSummaryDetails'] = $getAccountSummaryDetails;
echo '<pre>eeeeeee'; print_r($data['accountSummaryDetails']);
            
    }


    public static function getBonusId($account_number){
        $account_info = array(
            'iLogin' => $account_number
        );

        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAccountBonusBreakdown($account_info);
        return $WebService->get_all_result()->BonusBreakdownList->BonusData[0]->BonusId;

    }
   
   public function getAccountSummaryDetailsTest($account_number){


            FXPP::LoginTypeRestriction();

            $defaultData = array(
                'Balance' => 0,
                'Equity' => 0,
                'FreeMargin' => 0,
                'Withdrawable_RealFund' => 0,
                'Withdrawable_BonusSafe' => 0,
                'Total_Bonus' => 0
            );

            
            $fundsData = FXPP::getAccountFunds($account_number);


            $balance = $fundsData['balance'];

            if($fundsData['status'] != 'RET_OK'){
                return $defaultData;
            }

            if($balance < 0 ){
                return $defaultData;
            }

    
            $getWithdrawableRealFund  = $fundsData['withrawableRealFund'];
            $newMargin      = $fundsData['margin'];
            $newEquity      = $fundsData['equity'];
            $newRealBalance = $fundsData['balance'];
          
         

            //get withdrawable bonus with bonus safe - total balance - x - (x/.30)
            $totalBonusandChart = self::getTotalBonusTest($account_number);
            $getAccountBonusByType = FXPP::getAccountBonusByType($account_number);

             $totalbonus =  $getAccountBonusByType[1];
             $percent = .30;
             $bonusName = "30 percent";

            if (is_null($getAccountBonusByType[1])) {
                $totalbonus =  $getAccountBonusByType[10];
                $percent = .50;
                $bonusName = "50 percent";

            }
            if (is_null($getAccountBonusByType[10])) {
                $totalbonus =  $getAccountBonusByType[28];
                $percent = .20;
                $bonusName = "20 percent";

            }


            $totalBonus = $totalbonus;
            $bonusChart = $totalBonusandChart['bonusData'];
            $newBalance = $getWithdrawableRealFund + $totalBonus;

            $wdBonusSafe = $newBalance - $totalBonus - ($totalBonus / $percent);
            $defaultData['Total_Bonus'] = $totalBonus;

            $defaultData['Withdrawable_BonusSafe'] = ($wdBonusSafe < 0 ) ? 0 : number_format($wdBonusSafe, 2);


          
            $defaultData['Withdrawable_RealFund'] =  $getWithdrawableRealFund;
            $defaultData['Balance'] = $newBalance;
            $defaultData['bonusFund'] = $fundsData['bonusFund'];
            $defaultData['Equity'] = $newEquity;
            $defaultData['FreeMargin'] = $newMargin;
            $defaultData['Acct_Balance'] = $newRealBalance;
            $defaultData['bonusChart'] = $bonusChart;
            $defaultData['BonusName'] = $bonusName;

        return $defaultData;
        
    } 
            
    
}