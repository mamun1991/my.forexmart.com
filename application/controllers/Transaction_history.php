<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction_history extends MY_Controller {

    private $transaction_type = array(
        'BOC' => 'BANK OF CYPRUS',
        'BT' => 'BANK TRANSFER',
        'NT' => 'NETELLER',
        'SK' => 'SKRILL',
        'CC' => 'CREDIT CARD',
        'UP' => 'UNIONPAY',
        'WM' => 'WEBMONEY',
        'PX' => 'PAXUM',
        'UK' => 'UKASH',
        'PC' => 'PAYCO',
        'FP' => 'FILSPAY',
        'CU' => 'CASHU',
        'PP' => 'PAYPAL',
        'QW' => 'QIWI',
        'MT' => 'MEGATRANSFER',
        'MTC' => 'MEGATRANSFER CARD',
        'BC' => 'BITCOIN',
        'CP'=> 'CARDPAY',
        'MN'=> 'MONETA',
        'SF'=> 'SOFORT',
        'CUP'=> 'CHINAUNIONPAY',
        'WIRE_TRANSFER_SL' => 'MegaTransfer SiauLiu',
        'WIRE_TRANSFER_SP' => 'MegaTransfer Sparkasse',
        'WIRE_TRANSFER_PC' => 'Piraeus Cyprus',
        'WIRE_TRANSFER_BOC' => 'Bank of Cyprus',
        'WIRE_TRANSFER_EC' => 'Eurobank Cyprus',
        'N/A' => 'N/A',
        'TR' => 'TRANSIT TRANSFER',
        'FASAPAY'=>'FASAPAY',
        'FASA'=>'FASAPAY',
        'PAYOMA'=>'PAYOMA',
         'BANK_MYR'=>'BANK_MYR',
        'BANK_THB'=>'BANK_THB',
        'BANK_VND'=>'BANK_VND',
        'BANK_IDR'=>'BANK_IDR',
    );
    private $bonus_comments = array(
        0 => '',
        1 => 'FOREXMART WELCOME BONUS 30%',
        2 => 'FOREXMART NO DEPOSIT BONUS',
        10 => 'FOREXMART WELCOME BONUS 50%',
        12 => 'FOREXMART_CONTEST_MF'
    );

    private $comment_transaction_type = array(
        'BT' => 'WIRE_TRANSFER_BOC_',
        'NT' => 'NT_',
        'SK' => 'SK_',
        'CC' => 'CP_',
        'UP' => 'CUP_',
        'WM' => 'PS_',
        'PX' => 'PX_',
        'UK' => 'UK_',
        'PC' => 'PC_',
        'FP' => 'FP_',
        'CU' => 'CU_',
        'PP' => 'PP_',
        'QW' => 'QIWI_',
        'MT' => 'MT_',
        'MTC' => 'MTC_',
        'CUP' => 'CUP_',
        'YANDEXMONEY' => 'YAN_',
        'BITCOIN' => 'BITCOIN_',
        'BANK_MYR'=>'BANK_MYR_',
        'BANK_THB'=>'BANK_THB_',
        'BANK_VND'=>'BANK_VND_',
        'BANK_IDR'=>'BANK_IDR_',
    );

    private $tnx_comment = array(
        'BT'              => 'BANK TRANSFER',
        'NT'              => 'NETELLER',
        'SK'              => 'SRILL',
        'CP'              => 'CARDPAY',
        'CUP'             => 'CHINAUNIONPAY',
        'WM'              => 'WEBMONEY',
        'PX'              => 'PAXUM',
        'UK'              => 'UKASH',
        'PC'              => 'PAYCO',
        'FP'              => 'FILSPAY',
        'CU'              => 'CASHU',
        'PP'              => 'PAYPAL',
        'QW'              => 'QIWI',
        'MT'              => 'MEGATRANSFER',
        'MTCC'            => 'MEGATRANSFER_CC',
        'YAN'             => 'YANDEXMONEY',
        'BITCOIN'         => 'BITCOIN',
        'TR'              => 'TRANSIT_TRANSFER',
        'FASAPAY'         => 'FASAPAY',
        'FASA'         => 'FASAPAY',
        'EPAY'            => 'EMERCHANTPAY',
        'PAYOMA'          => 'PAYOMA',
        'ACCENTPAY'       => 'ACCENTPAY',
        'INPAY'           => 'INPAY_',
        'BANK_MYR'        => 'BANK_MYR',
        'BANK_THB'        => 'BANK_THB',
        'BANK_IDR'        => 'BANK_IDR',
        'BANK_VND'        => 'BANK_VND',
        'BANK_MXN'        => 'BANK_MXN',
        'BANK_BRL'        => 'BANK_BRL',
        'BANK_NGN'        => 'BANK_NGN',
        'BANK_KES'        => 'BANK_KES',
        'BANK_UGX'        => 'BANK_UGX',
        'BANK_GHS'        => 'BANK_GHS',
        'ALIPAY'          => 'ALIPAY',
        'ZP'              =>'ZOTAPAY',
        'PAYMENT_ASIA'    =>'PAYMENT_ASIA',
        'PAYONEER'        =>'PAYONEER',
    );
    private $comment_type = array(
        'withdraw' => 'W/D_',
        'deposit' => 'DPST_'
    );
    public function __construct(){
        parent::__construct();
        $this->load->model('Withdraw_model');
        $this->load->model('deposit_model');
        $this->load->model('General_model');

        $this->load->model('user_model');
        $this->load->model('account_model');
        $this->load->model('General_model');
        $this->load->model('Account_model');

        $this->user_id = $this->session->userdata('user_id');
        $this->load->library('Transaction');
        $this->g_m=$this->General_model;

    }

    private function getFinanceTxn(){
        $user_id = $this->session->userdata('user_id');
        $account_number = $this->session->userdata('account_number');
        $txn = array();
        if($txnResultArray = $this->general_model->whereConditionArray('withdraw',array('user_id'=>$user_id))){
            foreach($txnResultArray as $d){
                $txn[$d['reference_number']] = $d;
            }
        }

        if($txnResultArray = $this->general_model->whereConditionArray('transit_transfer',array('status'=>2,'receiver'=>$account_number))){
            foreach($txnResultArray as $d){
                $txn[$d['transaction_id']] = $d;
            }
        }

        if($txnResultArray = $this->general_model->whereConditionArray('deposit',array('status'=>2,'user_id'=>$user_id))){
            foreach($txnResultArray as $d){
                $txn[$d['mt_ticket']] = $d;
            }
        }

        return $txn;


    }

    public function index()
    {
        $this->newTransactionHistory();

    }

    public function index_v2()
    {
        $this->lang->load('transactionhistory');
        $this->lang->load('datatable');
        $this->load->library('IPLoc', null);
        if($_SERVER['REMOTE_ADDR']=='49.12.5.139') {
            $this->newTransactionHistory();
        }else {


            if ($this->session->userdata('logged')) {
                $user_id = $this->session->userdata('user_id');
                $mtas3 = $this->general_model->showssingle($table = 'users', $id = 'id', $field = $user_id, $select = 'login_type');
                $data['login_type'] = $mtas3['login_type'];
//                $data['from'] = DateTime::createFromFormat('Y/d/m', date('2015/5/5'));
//                $data['to'] = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m') . ' 23:59:59');

                $from = date('Y-m-d\TH:i:s', strtotime('2015/5/5'));
                $to = date('Y-m-d\TH:i:s', strtotime('today'.' 23:59:59'));

                if ($this->session->userdata('login_type') == 1) {
                    $data['mtas'] = $this->g_m->showssingle2($table = 'partnership', $field = 'partner_id', $id = $_SESSION['user_id'], $select = 'reference_num');
                    $data['mtas']['account_number'] = $data['mtas']['reference_num'];
                } else {
                    $data['mtas'] = $this->g_m->showssingle2($table = 'mt_accounts_set', $field = 'user_id', $id = $_SESSION['user_id'], $select = 'account_number');
                }


                $ticketArray = $this->getFinanceTxn();

                $account_info = array(
                    'iLogin' => $data['mtas']['account_number'],
                    'from' => $from,
                    'to' => $to
                    //'from' => $data['from']->format('Y-m-d\TH:i:s'),
                    //'to' => $data['to']->format('Y-m-d\TH:i:s')
                );
                $webservice_config = array('server' => 'live_new');
                $WebService = new WebService($webservice_config);
                $WebService->open_RequestAccountFinanceRecordsByDate($account_info);

                $withdrawalCommentsKey = array(
                    'comment_w1' => 'withdrawal',
                    'comment_w2' => 'w/d'
                );

//            if(IPLoc::OnlyTest()){
//                echo '<pre>';
//               var_dump( $WebService->get_result('FinanceRecords')); exit();
//            }

                switch ($WebService->request_status) {
                    case 'RET_OK':
                        $tradatalist = (array)$WebService->get_result('FinanceRecords');
                        $data['holder1'] = ''; /*Bonus*/
                        $data['holder2'] = ''; /*Deposit*/
                        $data['holder3'] = ''; /*Withdraw*/
                        $data['holder4'] = ''; /*Transfer*/
                        $data['holder5'] = ''; /*Pamm*/

                        if (IPLoc::Office()) {
                            // echo '<pre>'; print_r($tradatalist); die();
                        }

                        foreach ($tradatalist['FinanceRecordData'] as $object) {
                            if ($object->FundType == 'BONUS') {

                                $dtTyp = "'$object->FundType'";
                                $dtTrans = "'$object->Comment'";
                                $dtAcc = "'$object->AccountNumber'";
                                $dtAmnt = "'$object->Amount'";
                                $dtDte = "'$object->Stamp'";

                                $dtDetails = 'Details';

                                $data['data']['bonus'] = true;

                                $data['holder1'] .= '<tr onclick="mobViewDetails(' . $dtTyp . ',' . $dtTrans . ',' . $dtAcc . ',' . $dtAmnt . ',' . $dtDte . ')">';
                                $data['holder1'] .= '<td class="crTradesMob">' . $object->FundType . '</td>';       //type
                                $data['holder1'] .= '<td class="showDetailsMob">' . $object->Comment . '</td>';      //transaction
                                $data['holder1'] .= '<td class="crTradesMob">' . $object->AccountNumber . '</td>';  //account
                                $data['holder1'] .= '<td>' . $object->Amount . '</td>';         //amount
                                //$data['holder1'].='<td>N/A</td>';                         //pay system
                                $data['holder1'] .= '<td class="crTradesMob">' . $object->Stamp . '</td>';          //date

                                $data['holder1'] .= '<td class="crTradesWeb crTradesWebStyle">' . $dtDetails . '</td>';
                                $data['holder1'] .= '</tr>';


                            }
                            if (IPLoc::Office()) {
                                //  $a = $WebService->open_Deposit_NoDepositBonus($account_info);
                                //echo 'ffff'; print_r($a);
                            }

                            if ($object->FundType == 'REAL' and $object->Operation == 'BONUS_SUPPORTER_FULL') {
                                if ($object->Amount < 0) {
                                    $getWithdrawalTransactionByTicket = $ticketArray[$object->Ticket]; // $this->Withdraw_model->getWithdrawalTransactionByTicket($object->Ticket);
                                    $convertStamp = date("Y-m-d H:i:s", strtotime($object->Stamp));

                                    if ($getWithdrawalTransactionByTicket) {

                                        if ($getWithdrawalTransactionByTicket['status'] > 0) {
                                            switch ($getWithdrawalTransactionByTicket['status']) {
                                                case 1:
                                                    $withdrawalStatus = 'Processed';
                                                    break;
                                                case 2:
                                                    if ($getWithdrawalTransactionByTicket['decline_reference_number'] > 0) {
                                                        $withdrawalStatus = $getWithdrawalTransactionByTicket['recall'] ? 'Recalled' : 'Requested';
                                                    } else {
                                                        $withdrawalStatus = 'Requested';
                                                    }

                                                    break;
                                                default:
                                                    $withdrawalStatus = 'N/A';
                                            }

                                            if (!empty($object->Comment)) {
                                                $date_recalled = $getWithdrawalTransactionByTicket['date_recalled'] ? $getWithdrawalTransactionByTicket['date_recalled'] : $getWithdrawalTransactionByTicket['date_withdraw'];
                                                if ($getWithdrawalTransactionByTicket['recall'] == 1) {
                                                    $recall_comment = 'Recalled last ' . $date_recalled;
                                                } else {
                                                    $recall_comment = $object->Comment;
                                                }
                                                if (IPLoc::Office()) {
                                                    $recall_comment = $recall_comment . ' com1=' . $object->Comment;
                                                }
                                                $comment = '<a href="javascript:void(0);" class="view-comment" data-wcomment="' . $recall_comment . '">View</a>';
                                            } else {
                                                $comment = 'N/A';
                                            }

                                            if (!empty($getWithdrawalTransactionByTicket["transaction_type"])) {
                                                $transactionType = $this->transaction_type[strtoupper($getWithdrawalTransactionByTicket["transaction_type"])];
                                            } else {
                                                $transactionType = 'N/A';
                                            }


                                            $wtTyp = "'$object->FundType'";
                                            $wtAcc = "'$object->AccountNumber'";
                                            $wtAmnt = "'$object->Amount'";
                                            $wtTrans = "'$transactionType'";
                                            $wtDte = "'$convertStamp'";
                                            $wtStatus = "'$withdrawalStatus'";

                                            if (!empty($object->Comment)) {
                                                $wtCmts = "'$object->Comment'";
                                            } else {
                                                $wtCmts = "'N/A'";

                                            }

                                            $wtcall = "'--'";
                                            $wtDetails = 'Details';

                                            $data['data']['withdraw'] = true;
                                            $data['holder3'] .= '<tr onclick="mobViewDetailsWithdraw(' . $wtTyp . ',' . $wtAcc . ',' . $wtAmnt . ',' . $wtTrans . ',' . $wtDte . ',' . $wtStatus . ',' . $wtCmts . ',' . $wtcall . ')">';
                                            $data['holder3'] .= '<td class="crTradesMob">' . $object->FundType . '</td>';       //type
                                            $data['holder3'] .= '<td>' . $object->AccountNumber . '</td>';  //account
                                            $data['holder3'] .= '<td>' . $object->Amount . '</td>';         //amount
                                            $data['holder3'] .= '<td class="crTradesMob">' . $transactionType . '</td>';                         //pay system
                                            $data['holder3'] .= '<td class="crTradesMob">' . $convertStamp . '</td>';          //date
                                            $data['holder3'] .= '<td class="crTradesMob">' . $withdrawalStatus . '</td>';          //status
                                            $data['holder3'] .= '<td class="crTradesMob">' . $comment . '</td>';
                                            $data['holder3'] .= '<td class="crTradesWeb crTradesWebStyle">' . $wtDetails . '</td>';
                                            $data['holder3'] .= '</tr>';
                                        }

                                    } else {
                                        $data['data']['withdraw'] = true;


                                        $wt3Typ = "'$object->FundType'";
                                        $wt3Acc = "'$object->AccountNumber'";
                                        $wt3Amnt = "'$object->Amount'";
                                        $wt3Trans = "'N/A'";
                                        $wt3Dte = "'$convertStamp'";
                                        $wt3Status = "'N/A'";
                                        $wt3Cmts = "' '";
                                        $wt3call = "' '";
                                        $wt3Details = 'Details';


                                        $data['holder3'] .= '<tr onclick="mobViewDetailsWithdraw(' . $wt3Typ . ',' . $wt3Acc . ',' . $wt3Amnt . ',' . $wt3Trans . ',' . $wt3Dte . ',' . $wt3Status . ',' . $wt3Cmts . ',' . $wt3call . ')">';
                                        $data['holder3'] .= '<td class="crTradesMob">' . $object->FundType . '</td>';       //type
//                            $data['holder3'].='<td>'.$object->Operation.'</td>';      //transaction
                                        $data['holder3'] .= '<td>' . $object->AccountNumber . '</td>';  //account
                                        $data['holder3'] .= '<td>' . $object->Amount . '</td>';         //amount

                                        $data['holder3'] .= '<td class="crTradesMob">N/A</td>';                         //pay system
                                        $data['holder3'] .= '<td class="crTradesMob">' . $convertStamp . '</td>';          //date
                                        $data['holder3'] .= '<td class="crTradesMob">N/A</td>';          //status
                                        $data['holder3'] .= '<td class="crTradesWeb crTradesWebStyle">' . $wt3Details . '</td>';

                                        $data['holder3'] .= '</tr>';
                                    }
                                } else {

                                    $data['data']['bonus'] = true;


                                    $dt2Typ = "'$object->FundType'";
                                    $dt2Trans = "'$object->Comment'";
                                    $dt2Acc = "'$object->AccountNumber'";
                                    $dt2Amnt = "'$object->Amount'";
                                    $pay2Sys = "'N/A'";
                                    $dt2Dte = "'$object->Stamp'";
                                    $dt2Details = 'Details';


                                    $data['holder2'] .= '<tr onclick="mobViewDetails(' . $dt2Typ . ',' . $dt2Trans . ',' . $dt2Acc . ',' . $dt2Amnt . ',' . $dt2Dte . ',' . $pay2Sys . ')">';
                                    $data['holder2'] .= '<td class="crTradesMob">' . $object->FundType . '</td>';       //type
                                    $data['holder2'] .= '<td>' . $object->Comment . '</td>';      //transaction
                                    $data['holder2'] .= '<td class="crTradesMob">' . $object->AccountNumber . '</td>';  //account
                                    $data['holder2'] .= '<td>' . $object->Amount . '</td>';         //amount
                                    $data['holder2'] .= '<td class="crTradesMob">N/A</td>';         //amount
                                    $data['holder2'] .= '<td class="crTradesMob">' . $object->Stamp . '</td>';          //date
                                    $data['holder2'] .= '<td class="crTradesWeb crTradesWebStyle">' . $dt2Details . '</td>';
                                    $data['holder2'] .= '</tr>';
                                }
                            }
//
                            if ($object->Operation == 'REAL_FUND_DEPOSIT' || $object->Operation == 'FEE_COMPENSATION' || $object->Operation == 'AFFILIATE_FEE' || $object->Operation == 'REFUND' || $object->Operation == 'SUB_IB_COMMISSION') {
//                            if(strlen($object->Comment) >= 5){
//                                if(substr($object->Comment, 0, 5) == 'FEES_'){
//                                    $operation = 'Covered Fee';
//                                }else{
//                                    $operation = $object->Operation;
//                                }
//                            }else{
//                                $operation = $object->Operation;
//                            }

                                if (strpos(strtolower($object->Comment), $withdrawalCommentsKey['comment_w1']) !== false OR strpos(strtolower($object->Comment), $withdrawalCommentsKey['comment_w2']) !== false) {

                                    $convertStamp = date("Y-m-d H:i:s", strtotime($object->Stamp));
                                    $getWithdrawalTransactionByTicket = $ticketArray[$object->Ticket];//$this->Withdraw_model->getWithdrawalTransactionByDeclineTicket($object->Ticket);

                                    if (!empty($object->Comment)) {
                                        $date_recalled = $getWithdrawalTransactionByTicket['date_recalled'] ? $getWithdrawalTransactionByTicket['date_recalled'] : $getWithdrawalTransactionByTicket['date_withdraw'];
                                        if ($getWithdrawalTransactionByTicket['recall'] == 1) {
                                            $recall_comment = 'Recalled last ' . $date_recalled;
                                        } else {
                                            $recall_comment = 'Withdrawal request declined last ' . $getWithdrawalTransactionByTicket['date_withdraw'];
                                        }
//                                        if(IPLoc::Office()){
////                                            echo "<pre>";print_r($getWithdrawalTransactionByTicket);
//                                            $recall_comment = $recall_comment.' com2='.$object->Comment; }
                                        $comment = '<a href="javascript:void(0);" class="view-comment" data-wcomment="' . $recall_comment . '">View</a>';
                                    } else {
                                        $comment = 'N/A';
                                    }

                                    if (!empty($getWithdrawalTransactionByTicket["transaction_type"])) {
                                        $transactionType = $this->transaction_type[strtoupper($getWithdrawalTransactionByTicket["transaction_type"])];
                                    } else {
                                        $transactionType = 'N/A';
                                    }

                                    $rstat = $getWithdrawalTransactionByTicket['recall'] == 1 ? 'YES' : 'NO';
                                    $data['data']['withdraw'] = true;


                                    $wteTyp = "'$object->FundType'";
                                    $wteAcc = "'$object->AccountNumber'";
                                    $wteAmnt = "'$object->Amount'";
                                    $wteTrans = "'$transactionType'";
                                    $wteDte = "'$convertStamp'";
                                    $wteStatus = "'Declined'";

                                    if (!empty($object->Comment)) {
                                        $wteCmts = "'$recall_comment'";
                                    } else {
                                        $wteCmts = "'N/A'";
                                    }

                                    $wtecall = "'$rstat'";
                                    $wteDetails = 'Details';


                                    $data['holder3'] .= '<tr onclick="mobViewDetailsWithdraw(' . $wteTyp . ',' . $wteAcc . ',' . $wteAmnt . ',' . $wteTrans . ',' . $wteDte . ',' . $wteStatus . ',' . $wteCmts . ',' . $wtecall . ')">';
                                    $data['holder3'] .= '<td class="crTradesMob">' . $object->FundType . '</td>';       //type
//                            $data['holder3'].='<td>'.$object->Operation.'</td>';      //transaction

                                    $data['holder3'] .= '<td>' . $object->AccountNumber . '</td>';  //account
                                    $data['holder3'] .= '<td>' . $object->Amount . '</td>';         //amount
                                    $data['holder3'] .= '<td class="crTradesMob">' . $transactionType . '</td>';                         //pay system

                                    $data['holder3'] .= '<td class="crTradesMob">' . $convertStamp . '</td>';          //date
                                    $data['holder3'] .= '<td class="crTradesMob">Declined</td>';          //status
                                    $data['holder3'] .= '<td class="crTradesMob">' . $comment . '</td>';
                                    $data['holder3'] .= '<td class="crTradesMob">' . $rstat . '</td>';                    //active
                                    $data['holder3'] .= '<td class="crTradesWeb crTradesWebStyle">' . $wteDetails . '</td>';

                                    $data['holder3'] .= '</tr>';

                                } else {
                                    $depositTransaction = isset($ticketArray[$object->Ticket]) ? $ticketArray[$object->Ticket] : false;// $this->deposit_model->getDepositTransactionByTicket($object->Ticket);
                                    if ($depositTransaction) {
                                        $transactionType = strtoupper($depositTransaction["transaction_type"]);
                                    } else {
                                        $transactionType = 'N/A';
                                    }


                                    if (substr($object->Comment, 0, 8) === 'DPST_TR_') {
                                        $transID = substr($object->Comment, 15, 10);
                                        // $isITSProcessed = $this->Withdraw_model->getRequestFundTransactionStatus($transID);
                                        $transactionType = 'A/T';

                                    }

                                    /*    if(IPLoc::IPOnlyForMe())
                                        {
                                            if($isITSProcessed['status'] == 2 && $this->session->userdata('login_type') == 1){
                                                $data['data']['deposit'] = true;
                                                $data['holder2'] .= '<tr>';
                                                $data['holder2'] .= '<td>' . $object->FundType . '</td>';       //type
                                                $data['holder2'] .= '<td>' . $object->Comment . '</td>';      //transaction
                                                $data['holder2'] .= '<td>' . $object->AccountNumber . '</td>';  //account
                                                $data['holder2'] .= '<td>' . $object->Amount . '</td>';         //amount
                                                $data['holder2'] .= '<td>' . $transactionType . '</td>';                         //pay system
                                                $data['holder2'] .= '<td>' . $object->Stamp . '</td>';          //date
                                                $data['holder2'] .= '</tr>';

                                            }else if($this->session->userdata('login_type') <> 1){
                                                $data['data']['deposit'] = true;
                                                $data['holder2'] .= '<tr>';
                                                $data['holder2'] .= '<td>' . $object->FundType . '</td>';       //type
                                                $data['holder2'] .= '<td>' . $object->Comment . '</td>';      //transaction
                                                $data['holder2'] .= '<td>' . $object->AccountNumber . '</td>';  //account
                                                $data['holder2'] .= '<td>' . $object->Amount . '</td>';         //amount
                                                $data['holder2'] .= '<td>' . $transactionType . '</td>';                         //pay system
                                                $data['holder2'] .= '<td>' . $object->Stamp . '</td>';          //date
                                                $data['holder2'] .= '</tr>';
                                            }
                                            */
                                    //   }else{

//
//                                        if(IPLoc::IPOnlyForVenus()){
//                                            echo $object->Comment; echo $object->AccountNumber;
//                                        }


                                    $dtTyp = "'$object->FundType'";
                                    $dtTrans = "'$object->Comment'";
                                    $dtAcc = "'$object->AccountNumber'";
                                    $dtAmnt = "'$object->Amount'";
                                    $paySys = "'$transactionType'";
                                    $dtDte = "'$object->Stamp'";

                                    $dtDetails = 'Details';

                                    $data['data']['deposit'] = true;
                                    $data['holder2'] .= '<tr onclick="mobViewDetails(' . $dtTyp . ',' . $dtTrans . ',' . $dtAcc . ',' . $dtAmnt . ',' . $dtDte . ',' . $paySys . ')">';
                                    $data['holder2'] .= '<td class="crTradesMob">' . $object->FundType . '</td>';       //type
                                    $data['holder2'] .= '<td>' . $object->Comment . '</td>';      //transaction
                                    $data['holder2'] .= '<td class="crTradesMob">' . $object->AccountNumber . '</td>';  //account
                                    $data['holder2'] .= '<td>' . $object->Amount . '</td>';         //amount
                                    $data['holder2'] .= '<td class="crTradesMob">' . $transactionType . '</td>';                         //pay system
                                    $data['holder2'] .= '<td class="crTradesMob">' . $object->Stamp . '</td>';          //date
                                    $data['holder2'] .= '<td class="crTradesWeb crTradesWebStyle">' . $dtDetails . '</td>';
                                    $data['holder2'] .= '</tr>';
                                    //   }


                                }


                            }


                            if (IPLoc::Office()) {

                                if ($object->Operation == 'INVITE_FRIEND_BONUS') {

                                    $getWithdrawalTransactionByTicket = $ticketArray[$object->Ticket];// $this->Withdraw_model->getWithdrawalTransactionByTicket($object->Ticket);
                                    $data['last_query'] = $this->db->last_query();
                                    $convertStamp = date("Y-m-d H:i:s", strtotime($object->Stamp));

                                    if ($getWithdrawalTransactionByTicket) {

                                        if ($getWithdrawalTransactionByTicket['status'] > 0) {
                                            switch ($getWithdrawalTransactionByTicket['status']) {
                                                case 1:
                                                    $withdrawalStatus = 'Processed';
                                                    break;
                                                case 2:
                                                    $withdrawalStatus = 'Declined';
                                                    break;
//                                        default:  $withdrawalStatus = 'N/A'; brea
                                            }

                                            if (!empty($object->Comment)) {
                                                $date_recalled = $getWithdrawalTransactionByTicket['date_recalled'] ? $getWithdrawalTransactionByTicket['date_recalled'] : $getWithdrawalTransactionByTicket['date_withdraw'];
                                                if ($getWithdrawalTransactionByTicket['recall'] == 1) {
                                                    $recall_comment = 'Recalled last ' . $date_recalled;
                                                } else {
                                                    switch ($getWithdrawalTransactionByTicket['status']) {
                                                        case 1:
                                                            $comm = 'Withdrawn last ' . $getWithdrawalTransactionByTicket['date_withdraw'];
                                                            break;
                                                        case 2:
                                                            $comm = 'Withdrawal request declined last ' . $date_recalled;
                                                            break;
                                                    }
                                                    $recall_comment = $comm;
                                                }

                                                $comment = '<a href="javascript:void(0);" class="view-comment" data-wcomment="' . $recall_comment . '">View</a>';
                                            } else {
                                                $comment = 'N/A';
                                            }

                                            if (!empty($getWithdrawalTransactionByTicket["transaction_type"])) {
                                                $transactionType = $this->transaction_type[strtoupper($getWithdrawalTransactionByTicket["transaction_type"])];
                                            } else {
                                                $transactionType = 'N/A';
                                            }
                                            // $recalledStatus = $this->Withdraw_model->getRecalledStatus($object->Ticket);

                                            //   $rstat = $getWithdrawalTransactionByTicket['recall']==1?'YES':'NO';

                                            $data['data']['withdraw_inv_friend'] = true;
                                            $data['inv_friend'] .= '<tr>';
                                            $data['inv_friend'] .= '<td>' . $object->FundType . '</td>';       //type

                                            $data['inv_friend'] .= '<td>' . $object->AccountNumber . '</td>';  //account
                                            $data['inv_friend'] .= '<td>' . $object->Amount . '</td>';         //amount
                                            $data['inv_friend'] .= '<td>' . $transactionType . '</td>';                         //pay system
                                            $data['inv_friend'] .= '<td>' . $convertStamp . '</td>';          //date
                                            $data['inv_friend'] .= '<td>' . $withdrawalStatus . '</td>';          //status
                                            $data['inv_friend'] .= '<td>' . $comment . '</td>';

                                            $data['holder3'] .= '</tr>';


                                        }

                                    } else {

                                        $data['data']['withdraw_inv_friend'] = true;
                                        $data['inv_friend'] .= '<tr>';
                                        $data['inv_friend'] .= '<td>' . $object->FundType . '</td>';       //type
//                            $data['holder3'].='<td>'.$object->Operation.'</td>';      //transaction
                                        $data['inv_friend'] .= '<td>' . $object->AccountNumber . '</td>';  //account
                                        $data['inv_friend'] .= '<td>' . $object->Amount . '</td>';         //amount
                                        $data['inv_friend'] .= '<td>N/A</td>';                         //pay system
                                        $data['inv_friend'] .= '<td>' . $convertStamp . '</td>';          //date
                                        $data['inv_friend'] .= '<td>N/A</td>';          //status
                                        $data['inv_friend'] .= '<td>' . $comment . '</td>';          //status
                                        $data['inv_friend'] .= '</tr>';
                                    }

                                }

                            }


                            if ($object->Operation == 'REAL_FUND_WITHDRAW') {

                                $getWithdrawalTransactionByTicket = $ticketArray[$object->Ticket]; //$this->Withdraw_model->getWithdrawalTransactionByTicket($object->Ticket);
                                $convertStamp = date("Y-m-d H:i:s", strtotime($object->Stamp));

                                if ($getWithdrawalTransactionByTicket) {

                                    if ($getWithdrawalTransactionByTicket['status'] > 0) {
//                                    switch($getWithdrawalTransactionByTicket['status']){
//                                        case 1:
//                                            $withdrawalStatus = 'Processed';
//                                            break;
//                                        case 2:
//                                            if($getWithdrawalTransactionByTicket['decline_reference_number'] > 0){
//                                                $withdrawalStatus = $getWithdrawalTransactionByTicket['recall'] ? 'Recalled' : 'Requested';
//                                            }else{
//                                                $withdrawalStatus = 'Requested';
//                                            }
//
//                                            break;
//                                        default:
//                                            $withdrawalStatus = 'N/A';
//                                    }
                                        switch ($getWithdrawalTransactionByTicket['status']) {
                                            case 1:
                                                $withdrawalStatus = 'Processed';
                                                break;
                                            case 2:
                                                $withdrawalStatus = 'Declined';
                                                break;
//                                        default:  $withdrawalStatus = 'N/A'; brea
                                        }

                                        if (!empty($object->Comment)) {
                                            $date_recalled = $getWithdrawalTransactionByTicket['date_recalled'] ? $getWithdrawalTransactionByTicket['date_recalled'] : $getWithdrawalTransactionByTicket['date_withdraw'];
                                            if ($getWithdrawalTransactionByTicket['recall'] == 1) {
                                                $recall_comment = 'Recalled last ' . $date_recalled;
                                            } else {
                                                switch ($getWithdrawalTransactionByTicket['status']) {
                                                    case 1:
                                                        $comm = 'Proccessed last ' . $getWithdrawalTransactionByTicket['date_processed'];
                                                        break;
                                                    case 2:
                                                        $comm = 'Withdrawal request declined last ' . $date_recalled;
                                                        break;
                                                }
                                                $recall_comment = $comm;
                                            }
//                                        if(IPLoc::Office()){
////                                            echo "<pre>"; print_r($getWithdrawalTransactionByTicket);
//                                            $recall_comment = $recall_comment.' com3='.$object->Comment; }
                                            $comment = '<a href="javascript:void(0);" class="view-comment" data-wcomment="' . $recall_comment . '">View</a>';
                                        } else {
                                            $comment = 'N/A';
                                        }

                                        if (!empty($getWithdrawalTransactionByTicket["transaction_type"])) {
                                            $transactionType = $this->transaction_type[strtoupper($getWithdrawalTransactionByTicket["transaction_type"])];
                                        } else {
                                            $transactionType = 'N/A';
                                        }
                                        //   $recalledStatus = $this->Withdraw_model->getRecalledStatus($object->Ticket);
//                                    print_r($recalledStatus);
                                        $rstat = $getWithdrawalTransactionByTicket['recall'] == 1 ? 'YES' : 'NO';
//                                    if(IPLoc::Office()){
//
//                                        if($recalledStatus == true){
//                                            $data['data']['withdraw']=true;
//                                            $data['holder3'].='<tr>';
//                                            $data['holder3'].='<td>'.$object->FundType.'</td>';       //type
//                                            //                            $data['holder3'].='<td>'.$object->Operation.'</td>';      //transaction
//                                            $data['holder3'].='<td>'.$object->AccountNumber.'</td>';  //account
//                                            $data['holder3'].='<td>'.$object->Amount.'</td>';         //amount
//                                            $data['holder3'].='<td>'.$transactionType.'</td>';                         //pay system
//                                            $data['holder3'].='<td>'.$convertStamp.'</td>';          //date
//                                            $data['holder3'].='<td>'.$withdrawalStatus.'</td>';          //status
//                                            $data['holder3'].='<td>'.$comment.'</td>';
//                                            $data['holder3'].='<td>YES</td>';                    //active
//                                            $data['holder3'].='</tr>';
//                                        }
//                                    } else{
                                        $data['data']['withdraw'] = true;

                                        $wte2Typ = "'$object->FundType'";
                                        $wte2Acc = "'$object->AccountNumber'";
                                        $wte2Amnt = "'$object->Amount'";
                                        $wte2Trans = "'$transactionType'";
                                        $wte2Dte = "'$convertStamp'";
                                        $wte2Status = "'$withdrawalStatus'";

                                        if (!empty($object->Comment)) {
                                            $wte2Cmts = "'$recall_comment'";
                                        } else {
                                            $wte2Cmts = "'N/A'";
                                        }

                                        $wte2call = "'$rstat'";
                                        $wte2Details = 'Details';


                                        $data['holder3'] .= '<tr onclick="mobViewDetailsWithdraw(' . $wte2Typ . ',' . $wte2Acc . ',' . $wte2Amnt . ',' . $wte2Trans . ',' . $wte2Dte . ',' . $wte2Status . ',' . $wte2Cmts . ',' . $wte2call . ')">';
                                        $data['holder3'] .= '<td class="crTradesMob">' . $object->FundType . '</td>';       //type
                                        //                            $data['holder3'].='<td>'.$object->Operation.'</td>';      //transaction

                                        $data['holder3'] .= '<td>' . $object->AccountNumber . '</td>';  //account
                                        $data['holder3'] .= '<td>' . $object->Amount . '</td>';         //amount
                                        $data['holder3'] .= '<td class="crTradesMob">' . $transactionType . '</td>';

                                        //pay system
                                        $data['holder3'] .= '<td class="crTradesMob">' . $convertStamp . '</td>';          //date
                                        $data['holder3'] .= '<td class="crTradesMob">' . $withdrawalStatus . '</td>';          //status
                                        $data['holder3'] .= '<td class="crTradesMob">' . $comment . '</td>';
                                        $data['holder3'] .= '<td class="crTradesMob">' . $rstat . '</td>';
//                                        if(IPLoc::Office()){
//                                            $data['holder3'].='<td><p class="tabRecall" rel="'.$object->Ticket.'">Recall</p></td>';                    //active
//                                        }
                                        $data['holder3'] .= '<td class="crTradesWeb crTradesWebStyle">' . $wte2Details . '</td>';
                                        $data['holder3'] .= '</tr>';
//                                    }


                                    }

                                } else {


                                    if ((substr($object->Comment, 0, 7) == 'W/D_TR_')) {
                                        $transID = substr($object->Comment, 14, 10);
                                    }
                                    if ((substr($object->Comment, 0, 12) == 'DECLINED_TR_')) {
                                        $transID = substr($object->Comment, 19, 10);
                                    }
                                    $resultTransaction = $ticketArray[$transID]; //$this->Withdraw_model->getRequestDeclineFundTransaction($transID);
                                    $comm = $object->Comment;
                                    if ($resultTransaction && strlen($transID) > 1) {
                                        $paymentType = 'ITS';
                                        $paymentStat = 'Declined';
                                        $comment = '<a href="javascript:void(0);" txnid="' . $transID . '" class="view-comment" data-wcomment="' . $resultTransaction['decline_reason'] . '">View</a>';
                                    } else {
                                        $paymentType = 'N/A';
                                        $paymentStat = 'N/A';
                                        $comment = '<a href="javascript:void(0);" txnid="' . $transID . '" class="view-comment" data-wcomment="' . $comm . '">View</a>';

                                    }


                                    $data['data']['withdraw'] = true;

                                    $wte3Typ = "'$object->FundType'";
                                    $wte3Acc = "'$object->AccountNumber'";
                                    $wte3Amnt = "'$object->Amount'";
                                    $wte3Trans = "'$paymentType'";
                                    $wte3Dte = "'$convertStamp'";
                                    $wte3Status = "'$paymentStat'";

                                    if ($resultTransaction && strlen($transID) > 1) {
                                        $wte3Cmts = "'$resultTransaction[decline_reason]'";
                                    } else {
                                        $wte3Cmts = "'$object->Comment'";
                                    }
                                    $wte3call = "' '";
                                    $wte3Details = 'Details';


                                    $data['holder3'] .= '<tr onclick="mobViewDetailsWithdraw(' . $wte3Typ . ',' . $wte3Acc . ',' . $wte3Amnt . ',' . $wte3Trans . ',' . $wte3Dte . ',' . $wte3Status . ',' . $wte3Cmts . ',' . $wte3call . ')">';
                                    $data['holder3'] .= '<td class="crTradesMob">' . $object->FundType . '</td>';       //type
//                            $data['holder3'].='<td>'.$object->Operation.'</td>';      //transaction
                                    $data['holder3'] .= '<td>' . $object->AccountNumber . '</td>';  //account
                                    $data['holder3'] .= '<td>' . $object->Amount . '</td>';         //amount

                                    $data['holder3'] .= '<td class="crTradesMob">' . $paymentType . '</td>';                         //pay system
                                    $data['holder3'] .= '<td class="crTradesMob">' . $convertStamp . '</td>';          //date
                                    $data['holder3'] .= '<td class="crTradesMob">' . $paymentStat . '</td>';          //status
                                    $data['holder3'] .= '<td class="crTradesMob">' . $comment . '</td>';
                                    $data['holder3'] .= '<td class="crTradesMob"></td>';
                                    $data['holder3'] .= '<td class="crTradesWeb crTradesWebStyle">' . $wte3Details . '</td>';
                                    $data['holder3'] .= '</tr>';
                                }

                            }


                            if ($object->Operation == 'REAL_FUND_TRANSFER') {
                                /*2*/

                                if (strpos($object->Comment, 'INTERNAL_TRANSFER_FROM_') !== false) {

                                    $data['trans_to'] = $object->AccountNumber;
                                    $data['trans_from'] = str_replace('INTERNAL_TRANSFER_FROM_', '', $object->Comment);
                                } else if (strpos($object->Comment, 'OWN_MONEY_FROM_') !== false) {

                                    $data['trans_to'] = $object->AccountNumber;
                                    $data['trans_from'] = str_replace('OWN_MONEY_FROM_', '', $object->Comment);
                                } else {

                                    $data['trans_from'] = $object->AccountNumber;
                                    $data['trans_to'] = $object->AccountReceiver;
                                }


                                $trnsfTyp = "'$object->FundType'";
                                $trnsTransaction = "'$object->Operation'";
                                $trnsfAccFrm = "'$data[trans_from]'";
                                $trnsfAccTo = "'$data[trans_to]'";
                                $trnsfAmount = "'$object->Amount'";
                                $trnsfDate = "'$object->Stamp'";
                                $transferDetails = 'Details';


                                $data['data']['transfer'] = true;

                                $data['holder4'] .= '<tr onclick="mobViewDetailsTransfer(' . $trnsfTyp . ',' . $trnsTransaction . ',' . $trnsfAccFrm . ',' . $trnsfAccTo . ',' . $trnsfAmount . ',' . $trnsfDate . ')">';
                                $data['holder4'] .= '<td class="crTradesMob">' . $object->FundType . '</td>';       //type
                                $data['holder4'] .= '<td>' . $object->Operation . '</td>';      //transaction
                                $data['holder4'] .= '<td class="crTradesMob">' . $data['trans_from'] . '</td>';  //account to
                                $data['holder4'] .= '<td class="crTradesMob">' . $data['trans_to'] . '</td>';  //account from
                                $data['holder4'] .= '<td>' . $object->Amount . '</td>';         //amount
                                $data['holder4'] .= '<td class="crTradesMob">' . $object->Stamp . '</td>';          //date
                                $data['holder4'] .= '<td class="crTradesWeb crTradesWebStyle">' . $transferDetails . '</td>';

                                $data['holder4'] .= '</tr>';
                            }

                            if (IPLoc::Office()) {

                                if (strpos($object->Operation, 'PAMM') !== false) {
                                    $data['data']['pamm'] = true;
                                    $data['holder5'] .= '<tr>';
                                    $data['holder5'] .= '<td>' . $object->AccountNumber . '</td>';
                                    $data['holder5'] .= '<td>' . $object->FundType . '</td>';
                                    $data['holder5'] .= '<td>' . $object->Ticket . '</td>';
                                    $data['holder5'] .= '<td>' . $object->Amount . '</td>';
                                    $data['holder5'] .= '<td>' . date("Y-m-d H:i:s", strtotime($object->Stamp)) . '</td>';
                                    $data['holder5'] .= '<td>' . $object->Comment . '</td>';
                                    $data['holder5'] .= '</tr>';
                                }
                            }

                        }
//                    if(IPLoc::Office()){ //joy
//                        exit;
//                    }
                        break;
                    default:
                        $data['holder0'] = '';

                }

                if ($WebService->request_status === 'RET_OK') {


                    $financeRecords = $WebService->get_result('FinanceRecords');
                    foreach ($financeRecords->FinanceRecordData as $object) {
                        if ($object->Operation === 'REAL_FUND_WITHDRAW') {
                            $resultTransaction = $ticketArray[$object->Ticket]; //$this->Withdraw_model->getWithdrawalTransactionByTicket($object->Ticket);
                            $convertStamp = date("Y-m-d H:i:s", strtotime($object->Stamp));
//                        if(IPLoc::Office()){ //joy
//                            $data['withdrawFinance'].= "<tr id='test'}'>"
//                                ."<td class='FundType' align='center'>test</td>"
//                                ."<td class='Operation' align='center'>test</td>"
//                                ."<td class='AccountNumber'>test</td>"
//                                ."<td class='Amount'>test</td>"
//                                ."<td class='PaySystem'>test</td>"
//                                ."<td class='Stamp'>test</td>"
//                                ."<td class='Recall'><a class='btn-withdraw-option recall-action' data-ticket='test'>Recall</a></td>"
//                                ."</tr>";
//                        }else {
                            if ($resultTransaction) {
                                if ($resultTransaction['status'] == 0) {
                                    $data['withdrawFinance'] .= "<tr id=" . $object->Ticket . "}'>"
                                        . "<td class='FundType' align='center'>" . $object->FundType . "</td>"
                                        . "<td class='Operation' align='center'>" . $object->Operation . "</td>"
                                        . "<td class='AccountNumber'>" . $object->AccountNumber . "</td>"
                                        . "<td class='Amount'>" . $object->Amount . "</td>"
                                        . "<td class='PaySystem'>" . $this->transaction_type[strtoupper($resultTransaction['transaction_type'])] . "</td>"
                                        . "<td class='Stamp'>" . $convertStamp . "</td>"
                                        . "<td class='Recall'><a class='btn-withdraw-option recall-action hide-when-recalled' data-ticket=" . $object->Ticket . ">Recall</a></td>"
                                        . "</tr>";
                                }
                            }
//                        }
                        }
                    }
                }
//            if(IPLoc::Office()){ //joy
//                print_r($data['withdrawFinance']);
//                        exit;
//                    }

                //  edit by user 21

//            if(IPLoc::Office()){
//                $data['withdrawFinance_te21'] .= "<tr id=asdf}'>"
//                                        . "<td class='FundType' align='center'>tesr</td>"
//                                        . "<td class='Operation' align='center'>tesr</td>"
//                                        . "<td class='AccountNumber'>tesr</td>"
//                                        . "<td class='Amount'>asdfadsf</td>"
//                                        . "<td class='PaySystem'>asdfadsf</td>"
//                                        . "<td class='Stamp'>adfasdf</td>"
//                                        . "<td class='Recall'><a class='btn-withdraw-option recall-action' data-ticket=adsfasdf>Recall</a></td>"
//                                        . "</tr>";
//            }

                //  edit by user 21

                $data['holderincomplete'] = '';
                $data['title_page'] = lang('sb_li_2');
                //$data['active_tab'] = 'transaction-history';
                $data['active_tab'] = 'finance';
                $data['active_sub_tab'] = 'transaction-history';

                $data['metadata_description'] = lang('frahis_dsc');
                $data['metadata_keyword'] = lang('frahis_kew');
                $this->template->title(lang('frahis_tit'))
                    ->set_layout('internal/main')
                    ->append_metadata_css("
                       <link rel='stylesheet' href='" . $this->template->Css() . "dataTables.bootstrap2.css'>
                       <link rel='stylesheet' href='" . $this->template->Css() . "bootstrap-datetimepicker.css'>
                 ")
                    ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                          </script>
                        <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                       <script src='" . $this->template->Js() . "bootbox.min.js'></script>
                       <script src='" . $this->template->Js() . "Moment.js'></script>
                       <script src='" . $this->template->Js() . "bootstrap-datetimepicker.min.js'></script>
                       <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                 ")
                    ->build('transaction_history', $data);
                unset($data);
            } else {
                redirect('signout');
            }
        }//end if not vpn
    }

    public function index_v3()
    {
        $this->lang->load('transactionhistory');
        $this->lang->load('datatable');
        $this->load->library('IPLoc', null);
        if ($this->session->userdata('logged')) {

                $data['holderincomplete'] = '';
                $data['title_page'] = lang('sb_li_2');

                $data['active_tab'] = 'finance';
                $data['active_sub_tab'] = 'transaction-history';

                $data['metadata_description'] = lang('frahis_dsc');
                $data['metadata_keyword'] = lang('frahis_kew');
                $this->template->title(lang('frahis_tit'))
                    ->set_layout('internal/main')
                    ->append_metadata_css("
                       <link rel='stylesheet' href='" . $this->template->Css() . "dataTables.bootstrap2.css'>
                       <link rel='stylesheet' href='" . $this->template->Css() . "bootstrap-datetimepicker.css'>
                 ")
                    ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                          </script>
                        <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                       <script src='" . $this->template->Js() . "bootbox.min.js'></script>
                       <script src='" . $this->template->Js() . "Moment.js'></script>
                       <script src='" . $this->template->Js() . "bootstrap-datetimepicker.min.js'></script>
                       <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                 ")
                    ->build('transaction_history_v2', $data);
                unset($data);
            } else {
                redirect('signout');
            }

    }


    public function updateWithdrawTransaction(){
        if(!$this->input->is_ajax_request()){die('Not authorized!');}
        if($this->input->post()){
          $ticket = $this->input->post('ticket',true);

                $updateData = array('recall' => 1,'date_recalled'=>FXPP::getServerTime() );
                $this->Withdraw_model->updateWithdrawalDetails($ticket, $updateData);
                $ticketInfo = $this->Withdraw_model->GetWithdrawalDetails($ticket);
                $update_queue = $this->all_withdrawalqueue_update_cabinet($ticketInfo['id']);
                if($update_queue['error']){
                    echo false;
                }else{
                    echo true;
                }
        }
        echo false;
    }
    public function requestPendingTnx(){
        $userId = $this->session->userdata('user_id');
        $start =  $this->input->post('start',true);
        $length = $this->input->post('length',true);
        $draw = $this->input->post('draw',true);
        $ctr = $length + 1;
        $recordsTotal = $this->Withdraw_model->CountAllWithdrawalTransaction(0,$userId);
        $getWithdrawTransactions = $this->Withdraw_model->GetAllWithdrawalTransaction(0, $start, $length,$userId);

        $pendingData  = array();
        if($getWithdrawTransactions){
            foreach($getWithdrawTransactions as $v){
                $convertStamp = date("Y-m-d H:i:s", strtotime($v['date_withdraw']));
                $recall = $v['recall'];
                $recalled = $recall ? 'Yes' : "<button class='btn-withdraw-option recall-action' data-ticket='".$v['reference_number']."' data-transId='".$v['wId']."'>Recall</button>";
                if ($v['status']== 0) {

                    $wAmount= ($v['amount_deducted'] * -1);
                    $pcPay=$this->transaction_type[$v['transaction_type']];
                    $wType = "REAL";
                    $tempArray = array(
                        'DT_RowId' => $v['wId'],
                        $ctr++,
                        $wType,
                        'WITHDRAW',
                        $wAmount." ".$v['currency'],
                        $pcPay,
                        $convertStamp,
                        $recalled,
                    );

                    $pendingData[] = $tempArray;



                }



            }




        }



        $result = array(
            'draw'              => (int) $draw,
            'recordsTotal'      => (int) $recordsTotal['Count'],
            'recordsFiltered'   => (int) $recordsTotal['Count'],
            'data'              => $pendingData
        );


        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function  requestBalanceTnx()
    {
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        if ($this->session->userdata('logged')) {
            $accountNumber = $this->session->userdata('account_number');
            $draw = (int) $this->input->post('draw');
            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $dateFrom = $this->input->post('from');
            $dateTo = $this->input->post('to');
            $dateFrom = isset($dateFrom) ? FXPP::unixTime($dateFrom) : 0;
            $dateTo = isset($dateTo) ? FXPP::unixTime($dateTo) : FXPP::unixTime(date('Y-m-d 23:59:59', strtotime('now')));
            $ctr = $start + 1;
            $requestData = array('Offset' => $start, 'Limit' => $length, 'From' => $dateFrom, 'To' => $dateTo, 'AccountNumber' => $accountNumber);


            $this->load->library("WSV");
            $WSV = new WSV();

            $requestRes = $WSV->GetFinanceOpHistory($requestData)['Data'];

//            if(IPLoc::StatusTask()){
//                $requestRes = $WSV->GetFinanceOpHistoryV2($requestData)['Data'];
//            }

            $dataCount = $requestRes->DataCount;
            $tradesData = $requestRes->Transactions;
                                                    
            
            $pendingList = array();
            if ($dataCount > 0) {
                foreach ($tradesData->FinanceOpData as $key => $value) {


                    $isMicroAcc = FXPP::isMicroAccountChk($value->Login);

                    if($isMicroAcc){
                        $usdCents= ' USD (cents)';
                    }


                    $tnxComment = strtoupper($value->Comment);

                    //check if declined transaction
                    if((strpos($tnxComment, 'DECLINED') !== false) || (strpos(strtoupper($tnxComment), 'RECALLED') !== false)){ // standard type
                        $tnxStatus = FXPP::TransactionStatus(2);
                        $isDeclined = true;
                    }else{
                        $isDeclined = false;
                        $tnxStatus = FXPP::TransactionStatus(1);
                    }

//                    if(IPLoc::StatusTask()){
//                        $tnxStatus = FXPP::TransactionStatus($value->IsAccepted);
//                    }

                    // get transaction type
                    $tnxTypeExplode = explode("_", $tnxComment);
                    if($tnxTypeExplode[0] == 'DPST' || $tnxTypeExplode[0] == 'FEES' || $tnxTypeExplode[0] == 'W/D'){
                        if($tnxTypeExplode[1] == 'BANK'){
                            $tnxType = $this->tnx_comment[strtoupper($tnxTypeExplode[1] . '_' . $tnxTypeExplode[2])];
                        }else{
                            $tnxType = $this->tnx_comment[strtoupper($tnxTypeExplode[1])];
                        }
                    }

                    $OperationTypeId = ($tnxType == 'TRANSIT_TRANSFER') ? 'TRANSIT_TRANSFER_REAL_FUND' : $value->OperationTypeId;
                    if((strpos($OperationTypeId, 'BONUS') !== false) || (strpos(strtoupper($OperationTypeId), 'TRANSFER_REAL_FUND') !== false) || empty($tnxType)){ 
                        $tnxType = 'N/A';
                    }

                    // get receiver and sender
                    $fn = $this->getFundStatusPerOperationType($OperationTypeId);
                    if($OperationTypeId == 'TRANSIT_TRANSFER_REAL_FUND'){ // Transit transfer

                        if($value->Amount > 0){
                            $sender = $isDeclined ? 0 : $tnxTypeExplode[2];
                            $receiver = $accountNumber;
                        }else{
                            $sender = $accountNumber;
                            $receiver =  $isDeclined ? 0 : $tnxTypeExplode[2];
                        }
                    }
                    if($OperationTypeId == 'TRANSFER_REAL_FUND'){ // Internal Transfer
                        $sender = $value->TransferAccountSender;
                        $receiver = $value->TransferAccountReceiver;
                    }
                    // additional info
                    $dt = array(
                        'TransType'     => $fn['TransType'],
                        'Comment'       => $value->Comment,
                        'Ticket'       => $value->Ticket,
                        'TransferAccountSender' =>$sender,
                        'TransferAccountReceiver' => $receiver,

                    );
                    $tnxDetails = $this->getTnxDetails($dt);


                    $tempArray = array(
                        $ctr,
                        $fn['FundType'], //REAL | BONUS
                        $tnxStatus,
                        $fn['TransType'],
                        $tnxType,
                        $value->Amount . $usdCents,
                        gmdate("Y-m-d H:i:s", $value->ProcessTime),
                        "<button   id='btn-view-" . $value->Ticket . "' data-info='".$tnxDetails."' class='btn-view-trans-details' type='button'>View Details</button>",

                    );

                    $ctr ++;
                    $pendingList[] = $tempArray;
                }
            }

            $result = array(
                'draw'            => $draw,
                'recordsTotal'    => (int) $dataCount,
                'recordsFiltered' => (int) $dataCount,
                'data'            => $pendingList
            );


            $this->output->set_content_type('application/json')->set_output(json_encode($result));


        }
    }


    public function getTnxDetails($args){
        switch($args['TransType']){
            case 'Deposit':
                $recall = 'NO';

                $comment = (!empty($args['Comment']))? $args['Comment'] : "N/A";
                if((strpos($comment, 'Recalled') !== false)){
                    $recall = 'YES';

                }
                if($recall == 'YES'){
                    $details = "<p>
                                    Ticket: ".$args['Ticket']."<br>\n
                                    Comment: ".$comment."<br>\n                            
                                    Recall: ".$recall."<br>\n
                                    </p>";
                    break;
                }else{
                    $details = "<p>
                                    Ticket: ".$args['Ticket']."<br>\n
                                    Comment: ".$args['Comment']."<br>\n                               
                                    </p>";
                }

                break;
            case 'Withdraw':
                $recall = 'NO';
                if((strpos($args['Comment'], 'Recalled') !== false)){
                    $recall = 'YES';

                }

                $comment = (!empty($args['Comment']))? $args['Comment'] : "N/A";
                $details = "<p>
                                    Ticket: ".$args['Ticket']."<br>\n
                                    Comment: ".$comment."<br>\n                            
                                    Recall: ".$recall."<br>\n
                                    </p>";
                break;
            case 'Transfer':
                $details = "<p>
                                    Ticket: ".$args['Ticket']."<br>\n
                                    Comment: ".$args['Comment']."<br>\n
                                    Transfer From: ".$args['TransferAccountSender']."<br>\n
                                    Transfer To: ".$args['TransferAccountReceiver']."<br>\n
                                    </p>";
                break;
            default:
                $details = "<p>
                                    Ticket: ".$args['Ticket']."<br>\n
                                    Comment: ".$args['Comment']."<br>\n                               
                                    </p>";
                break;
        }
        return $details;

    }
    
    public function all_withdrawalqueue_update_cabinet($id)
    {
        $returnData = array(
            'error' => true,
            'message' => 'Your recall request failed.',
        );


        $error = true;
        $message = null;
        $action = 'Declined';
        $transId = $id;
        $comment = 'Recalled in Client Cabinet';
        if (isset($transId) && !empty($transId)) {
            switch ($action) {
                case 'Processed':
                    $actionStat = 1;
                    break;
                case 'Declined':
                    $actionStat = 2;
                    break;
            }



            $getWithdrawalRequestClient = $this->Withdraw_model->getWithdrawalRequestClient($transId);
            if(!$getWithdrawalRequestClient){
                return $returnData;
            }



            if ($getWithdrawalRequestClient) {
                $amount = number_format($getWithdrawalRequestClient['amount'], 2, '.', '');
                $withdrawalType = $getWithdrawalRequestClient['transaction_type'];
                $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
                $withdraw_data = array(
                    'full_name' => $getWithdrawalRequestClient['full_name'],
                    'account_number' => $getWithdrawalRequestClient['account_number'],
                    'date_withdraw' => $getWithdrawalRequestClient['date_withdraw'],
                    'amount' => number_format($getWithdrawalRequestClient['amount'], 2, '.', ''),
                    'currency' => $getWithdrawalRequestClient['currency'],
                    'email' => $getWithdrawalRequestClient['email'],
                    'withdrawal_type' => $this->transaction_type[$withdrawalType],
                    'date_processed' => $date
                );

                if ($actionStat == 1) {
//                        APPROVED
                } else {
                    /* Invite friend bonus Declined, wd_txn_type=4 is Invite friend bonus withdraw*/
                    if ($getWithdrawalRequestClient['wd_txn_type'] == 4) {
                        $withdraw_data['reason'] = $comment;
                        $requestDetails = array(
                            'status' => $actionStat,
                            'comment' => $comment,
                            'decline_reference_number' => ""
                        );
                        $this->Withdraw_model->processTransactionRequest($transId, $requestDetails);
                        $this->Withdraw_model->updateInviteFriend($getWithdrawalRequestClient['amount_deducted'],$getWithdrawalRequestClient['user_id'],$transId);
                    } else {

                        $amountDeducted = $getWithdrawalRequestClient['amount_deducted'];
                        if ($getWithdrawalRequestClient['recall']) {
                            $mt4_comment_type = 'Recalled';
                        } else {
                            $mt4_comment_type = 'Declined';
                        }

                        $declinedCommentMt4 = $this->comment_type['withdraw']. $this->comment_transaction_type[$withdrawalType] . $mt4_comment_type;
                        $service_config = array(   'server' => 'live_new'  );
//                        $WebService = new WebService($service_config);

//                        if(IPLoc::APIUpgradeDevIP()){
                            $WebServiceNew = FXPP::DepositRealFund($getWithdrawalRequestClient['account_number'], $amountDeducted, $declinedCommentMt4);
                            $requestResult = $WebServiceNew['requestResult'];
                            $ticket        = $WebServiceNew['ticket'];
//                        }else{
//                            $WebService->update_live_deposit_balance($getWithdrawalRequestClient['account_number'], $amountDeducted, $declinedCommentMt4);
//                            $requestResult = $WebService->request_status;
//                            $ticket        = $WebService->get_result('Ticket');
//                        }

                        if ($requestResult === 'RET_OK') {
                            $transTicket = $ticket;
                            $this->credit_back_bonus($transId);
                            $withdraw_data['reason'] = $comment;
//                            print_r('line 613'); echo "<br>";

                            $requestDetails = array(
                                'status' => $actionStat,
                                'comment' => $comment,
                                'decline_reference_number' => $transTicket
                            );
//                            print_r($requestDetails); echo "<br>";
//                            print_r('line 621'); echo "<br>";
                            $this->Withdraw_model->processTransactionRequest($transId, $requestDetails);

                            $this->load->library('Fx_mailer');
                            Fx_mailer::withdrawal_decline($withdraw_data);

//                            print_r('line 622'); echo "<br>";
                            $WebService2 = new WebService($service_config);
                            $WebService2->request_live_account_balance($getWithdrawalRequestClient['account_number']);
                            if ($WebService2->request_status === 'RET_OK') {
//                                print_r('line 627'); echo "<br>";
                                $balance = $WebService2->get_result('Balance');
                                $this->Withdraw_model->updateAccountBalance($getWithdrawalRequestClient['account_number'], $balance);
                            }
//                            print_r('line 630'); echo "<br>";

                        }else{
                            //error
                            $requestDetails = array(
                                'status' => 0,
                            );
                            $this->Withdraw_model->processTransactionRequest($transId, $requestDetails);
//                            print_r('RET_NOTTTTT');echo "<br>";
//                            print_r($WebService->request_status);echo "<br>";
                        }

                    }
//                    print_r('line 638'); echo "<br>";
                    $language_ru = array("AZ","UZ","BY","KZ","KG","MD","TJ","AM","TM","UA","RU");
                    if(in_array($getWithdrawalRequestClient['country'],$language_ru)){
                        //if($getWithdrawalRequestClient['country']=='RU'){
                        Fx_mailer::refund_issue_ru(array('email'=>$getWithdrawalRequestClient['email']));
                    }else{
                        Fx_mailer::refund_issue(array('email'=>$getWithdrawalRequestClient['email']));
                    }


                }

                $this->load->model('Adminslogs_model');
                $logsPrms = array(
                    'Amount' => number_format($getWithdrawalRequestClient['amount'], 2, '.', ''),
                    'Action' => $action,
                    'Comment' => $comment,
                    'Manager_IP' => $this->input->ip_address(),
                );
//                print_r('line 659'); echo "<br>";
                $logsData = array(
                    'users_id' => $_SESSION['user_id'],
                    'page' => 'Transaction History - Pending Transaction Recall, Internal Cabinet',
                    'date_processed' => FXPP::getCurrentDateTime(),
                    'processed_users_id' => $getWithdrawalRequestClient['user_id'],
                    'data' => json_encode($logsPrms),
                    'processed_users_id_accountnumber' => $getWithdrawalRequestClient['account_number'],
                    'comment' => $action,
                    'admin_fullname' => $_SESSION['full_name'],
                    'admin_email' => $_SESSION['email'],
                );
                $this->Adminslogs_model->insertmy($table = "admin_log", $logsData);
            }
//            print_r('line 659'); echo "<br>";

            $withdraw_detail = $this->Withdraw_model->getWithdrawById_recall($transId);
            if ($withdraw_detail) {
                $currency = $withdraw_detail['currency'];
                $amount = $withdraw_detail['amount'];
                $conv_amount = $this->get_convert_amount($currency, $amount);
                $this->Withdraw_model->updateConvertedAmountById($transId, $conv_amount);
            }
            $error = false;
        } else {
            $error = true;
            $message = 'Something went wrong. Please try again.';
        }


            $returnData['error'] = $error;
            $returnData['message'] = $message;

        return $returnData;

//        echo json_encode($returnArray);
//        exit;
    }
    private function get_convert_amount($currency, $amount) {
        if ($currency == 'USD') {
            $conv_amount = $amount;
        } else {

            $currency_convert_config = array(
                'server' => 'converter',
                'service_id' => '505641',
                'service_password' => '5fX#p8D^c89bQ'
            );

            $WebService = new WebService($currency_convert_config);
            $data = array(
                'amount' => $amount,
                'from_currency' => strtoupper(trim($currency)),
                'to_currency' => 'USD'
            );

            $WebService->convert_currency_amount($data);
            if ($WebService->request_status === 'RET_OK' || $WebService->request_status === 'RET_GAP') {
                $converted_amount = $WebService->get_result('ToAmount');
                $conv_amount = number_format($converted_amount, 2);
            } else {
                $conv_amount = $amount;
            }
        }

        return $conv_amount;
    }
    public function credit_back_bonus($wTransactionId)
    {
//        print_r('credit_back_bonus'); echo "<br>";
        $getWithdrawBonusByTransId = $this->Withdraw_model->getWithdrawBonusByTransId($wTransactionId);
        if ($getWithdrawBonusByTransId) {
            foreach ($getWithdrawBonusByTransId as $data) {
//                print_r('credit_back_bonus-middle'); echo "<br>";
                $bonusPrms = array(
                    'Amount' => $data['Amount'],
                    'Account_number' => $data['Account_number'],
                    'Bonus_id' => $data['Bonus_id'],
                    'Withdraw_bonus_id' => $data['Id'],
                    'Is_RealFund' => $data['Is_realfund']
                );

                $this->processFMBonus($bonusPrms);
            }
        }
//        print_r('credit_back_bonus-end'); echo "<br>";

    }
    public function processFMBonus($bonusData)
    {
//        print_r('processFMBonus'); echo "<br>";
        $amount = $bonusData['Amount'];
        $account_number = $bonusData['Account_number'];
        $bonus_id = $bonusData['Bonus_id'];
        $comment = $this->bonus_comments[$bonus_id];
        $withdraw_bonus_id = $bonusData['Withdraw_bonus_id'];

        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);

        $reqResult = '';
        $bonusTicket = 0;

        switch ($bonus_id) {
            case 2:
                //No Deposit Bonus
                $account_info = array(
                    'Login' => $account_number,
                    'FundTransferAccountReciever' => $account_number,
                    'Amount' => $amount,
                    'Comment' => $comment,
                    'ProcessByIP' => $this->input->ip_address()
                );
                $WebService->open_Deposit_NoDepositBonus($account_info);
                break;
            case 12:
                // Forex Contest Bonus
                $WebService->credit_mf_Prize($account_number, $amount, $comment);
                break;
            case 1:
                $account_info = array(
                    'AccountNumber' => $account_number,
                    'Amount' => $amount,
                    'Comment' => $comment,
                    'ProcessByIP' => $this->input->ip_address()
                );

//                if(IPLoc::APIUpgradeDevIP() || IPLoc::Office()){
                    $webserviceResult =  FXPP::CreditBonus('BONUS_30_PERCENT', $amount, $comment, $account_number);
                    $reqResult   = $webserviceResult['ErrorMessage'];
                    $bonusTicket = $webserviceResult['Data']->Ticket;
//                }else{
//                    $WebService->open_Deposit_30PercentBonus($account_info);
//                    $reqResult   = $WebService->request_status;
//                    $bonusTicket = $WebService->get_result('Ticket');
//                }
                break;
            case 10:
                $account_info = array(
                    'AccountNumber' => $account_number,
                    'Amount' => $amount,
                    'Comment' => $comment,
                    'ProcessByIP' => $this->input->ip_address()
                );

//                if(IPLoc::APIUpgradeDevIP() || IPLoc::Office()){
                    $webserviceResult =  FXPP::CreditBonus('BONUS_50_PERCENT', $amount, $comment, $account_number);
                    $reqResult   = $webserviceResult['ErrorMessage'];
                    $bonusTicket = $webserviceResult['Data']->Ticket;
//                }else{
//                    $WebService->open_Deposit_50_PercentBonus($account_info);
//                    $reqResult   = $WebService->request_status;
//                    $bonusTicket = $WebService->get_result('Ticket');
//                }
                break;
            case 3:
                $account_info = array(
                    'AccountNumber' => $account_number,
                    'Amount' => $amount,
                    'Comment' => $comment,
                    'ProcessByIP' => $this->input->ip_address()
                );

//                if(IPLoc::APIUpgradeDevIP() || IPLoc::Office()){
                    $webserviceResult =  FXPP::CreditBonus('BONUS_20_PERCENT', $amount, $comment, $account_number);
                    $reqResult   = $webserviceResult['ErrorMessage'];
                    $bonusTicket = $webserviceResult['Data']->Ticket;
//                }else{
//                    $WebService->open_Deposit_20PercentBonus($account_info);
//                    $reqResult   = $WebService->request_status;
//                    $bonusTicket = $WebService->get_result('Ticket');
//                }
                break;
        }

        if ($reqResult === 'RET_OK') {
//            $bonusTicket = $WebService->get_result('Ticket');
            $this->Withdraw_model->updateBonus($withdraw_bonus_id, $bonusTicket);
        }
//        print_r('processFMBonus-end'); echo "<br>";

    }


    public function cell(){

        require_once dirname(__FILE__) . "/third_party/PHPExcel.php";
        $objPHPExcel = new PHPExcel();
// Create a first sheet, representing sales data
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Something');

// Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Name of Sheet 1');

// Create a new worksheet, after the default sheet
        $objPHPExcel->createSheet();

// Add some data to the second sheet, resembling some different data types
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'More data');

// Rename 2nd sheet
        $objPHPExcel->getActiveSheet()->setTitle('Second sheet');

// Redirect output to a client’s web browser (Excel5)
        ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="myfile.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }


    public function test_excel(){

        $this->load->library('excel');
        $getTransactionsRecord = $this->getTransactionsRecord();
//        $realFundDeposit = array();
        $realFundDeposit = $getTransactionsRecord['REAL_FUND_DEPOSIT'];

        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Forexmart Transactions');

        //set row heading
        $this->excel->getActiveSheet()->setCellValue('A1', 'Type');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Transaction');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Account');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Amount');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Pay System');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Date');

        for($col = ord('A'); $col <= ord('G'); $col++){
            //set column dimension
            $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
            //change the font size
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

            $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        }
        $this->excel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1:F1')->getFont()->setSize(14);
        $this->excel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        if($realFundDeposit){
            $row = 2;
            foreach($realFundDeposit as $data){

                $convertStamp = date("Y-m-d H:i:s", strtotime($data['Stamp']));

                $this->excel->getActiveSheet()->setCellValue('A'.$row, $data['FundType']);
                $this->excel->getActiveSheet()->setCellValue('B'.$row, $data['Operation']);
                $this->excel->getActiveSheet()->setCellValue('C'.$row, $data['AccountNumber']);
                $this->excel->getActiveSheet()->setCellValue('D'.$row, $data['Amount']);
                $this->excel->getActiveSheet()->setCellValue('E'.$row, 'N/A');
                $this->excel->getActiveSheet()->setCellValue('F'.$row, $convertStamp);
                $row++;
            }
        }else{
            $this->excel->getActiveSheet()->mergeCells('A2:F2');
            $this->excel->getActiveSheet()->setCellValue('A2', 'No record found');
            $this->excel->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        }

        ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="myfile.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');

    }

    public function test_pdf(){
        $this->load->library('PDF_MC_Table');
        $pdf=new PDF_MC_Table();
        $pdf->AddPage();
        $pdf->SetFont('Arial','',12);
//Table with 20 rows and 4 columns
        $pdf->SetWidths(array(32,32,32,32,32,32));
        $header = array('Type', 'Transaction', 'Account', 'Amount', 'Pay System', 'Date');
        $pdf->Header($header);
        $getTransactionsRecord = $this->getTransactionsRecord();
//        $realFundDeposit = array();
        $realFundDeposit = $getTransactionsRecord['REAL_FUND_DEPOSIT'];

        foreach($realFundDeposit as $data){
            $convertStamp = date("Y-m-d H:i:s", strtotime($data['Stamp']));
            $pdf->Row(
                array(
                    $data['FundType'],
                    $data['Operation'],
                    $data['AccountNumber'],
                    $data['Amount'],
                    'N/A',
                    $convertStamp
                )
            );
        }

        $pdf->Output();
    }

    public function getTransactionsRecord(){

        $getData = null;

        $transactionTypes = array(
            'REAL_FUND_DEPOSIT' => array(),
            'REAL_FUND_WITHDRAW' => array(),
            'REAL_FUND_TRANSFER' => array(),
            'BONUS' => array()
        );

        $from = DateTime::createFromFormat('Y/d/m', date('2015/5/5'));
        $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m').' 23:59:59');
        $mtAccountsSetData = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
        $account_info = array(
            'iLogin' => $mtAccountsSetData['account_number'],
            'from' => $from->format('Y-m-d\TH:i:s'),
            'to' => $to->format('Y-m-d\TH:i:s')
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->open_RequestAccountFinanceRecordsByDate($account_info);

        if($WebService->request_status === 'RET_OK'){
            $financeRecordEncode = json_encode($WebService->get_result('FinanceRecords'));
            $financeRecord = json_decode($financeRecordEncode, true);

            $operations = array_column($financeRecord['FinanceRecordData'], 'Operation');

            $array_keys = array_keys($transactionTypes);

            foreach($operations as $key => $o){

                if(in_array($o, $array_keys)){
                    $transactionTypes[$o][] = $financeRecord['FinanceRecordData'][$key];
                }

            }

        }
        return $transactionTypes;
    }

    public function dt()
    {
        $this->lang->load('transactionhistory');
        $this->load->library('IPLoc', null);


        if($this->session->userdata('logged')) {

            $data['from'] = DateTime::createFromFormat('Y/d/m', date('2015/5/5'));
            $data['to'] = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m').' 23:59:59');
            $data['mtas'] = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
            $account_info = array(
                'iLogin' => $data['mtas']['account_number'],
                'from' => $data['from']->format('Y-m-d\TH:i:s'),
                'to' => $data['to']->format('Y-m-d\TH:i:s')
            );
            $webservice_config = array('server' => 'live_new');
            $WebService = new WebService($webservice_config);
            $WebService->open_RequestAccountFinanceRecordsByDate($account_info);

            $withdrawalCommentsKey = array(
                'comment_w1' => 'withdrawal',
                'comment_w2' => 'w/d'
            );

            switch($WebService->request_status){
                case 'RET_OK':
                    $tradatalist = (array) $WebService->get_result('FinanceRecords');
                    $data['holder1']='';
                    $data['holder2']='';
                    $data['holder3']='';
                    $data['holder4']='';
                    $data['holder5']='';
                    foreach ( $tradatalist['FinanceRecordData'] as $object){

                        if ($object->FundType=='BONUS'){
                            $data['data']['bonus']=true;
                            $data['holder1'].='<tr>';
                            $data['holder1'].='<td>'.$object->FundType.'</td>';       //type
                            $data['holder1'].='<td>'.$object->Comment.'</td>';      //transaction
                            $data['holder1'].='<td>'.$object->AccountNumber.'</td>';  //account
                            $data['holder1'].='<td>'.$object->Amount.'</td>';         //amount
//                            $data['holder1'].='<td>N/A</td>';                         //pay system
                            $data['holder1'].='<td>'.$object->Stamp.'</td>';          //date
                            $data['holder1'].='</tr>';
                        }
                        if ($object->Operation=='REAL_FUND_DEPOSIT'){
//                            if(strlen($object->Comment) >= 5){
//                                if(substr($object->Comment, 0, 5) == 'FEES_'){
//                                    $operation = 'Covered Fee';
//                                }else{
//                                    $operation = $object->Operation;
//                                }
//                            }else{
//                                $operation = $object->Operation;
//                            }

                            if (strpos(strtolower($object->Comment), $withdrawalCommentsKey['comment_w1'] ) !== false OR strpos(strtolower($object->Comment), $withdrawalCommentsKey['comment_w2'] ) !== false) {

                                $convertStamp = date("Y-m-d H:i:s", strtotime($object->Stamp));
                                $getWithdrawalTransactionByTicket = $this->Withdraw_model->getWithdrawalTransactionByDeclineTicket($object->Ticket);

                                if(!empty($object->Comment)){
                                    $date_recalled = $getWithdrawalTransactionByTicket['date_recalled']?$getWithdrawalTransactionByTicket['date_recalled']:$getWithdrawalTransactionByTicket['date_withdraw'];
                                    if($getWithdrawalTransactionByTicket['recall']==1){
                                        $recall_comment = 'Recalled last '.$date_recalled;
                                    }else{
                                        $recall_comment = $object->Comment;
                                    }
                                    if(IPLoc::Office()){ $recall_comment = $recall_comment.' com4='.$object->Comment; }
                                    $comment = '<a href="javascript:void(0);" class="view-comment" data-wcomment="'.$recall_comment.'">View</a>';
                                }else{
                                    $comment = 'N/A';
                                }

                                if(!empty($getWithdrawalTransactionByTicket["transaction_type"])){
                                    $transactionType = $this->transaction_type[strtoupper($getWithdrawalTransactionByTicket["transaction_type"])];
                                }else{
                                    $transactionType = 'N/A';
                                }

                                $data['data']['withdraw']=true;
                                $data['holder3'].='<tr>';
                                $data['holder3'].='<td>'.$object->FundType.'</td>';       //type
//                            $data['holder3'].='<td>'.$object->Operation.'</td>';      //transaction
                                $data['holder3'].='<td>'.$object->AccountNumber.'</td>';  //account
                                $data['holder3'].='<td>'.$object->Amount.'</td>';         //amount
                                $data['holder3'].='<td>'.$transactionType.'</td>';                         //pay system
                                $data['holder3'].='<td>'.$convertStamp.'</td>';          //date
                                $data['holder3'].='<td>Declined</td>';          //status
                                $data['holder3'].='<td>'.$comment.'</td>';
                                $data['holder3'].='</tr>';

                            }else{
                                $depositTransaction = $this->deposit_model->getDepositTransactionByTicket($object->Ticket);
                                if($depositTransaction){
                                    $transactionType = strtoupper($depositTransaction["transaction_type"]);
                                }else{
                                    $transactionType = 'N/A';
                                }
                                $data['data']['deposit']=true;
                                $data['holder2'].='<tr>';
                                $data['holder2'].='<td>'.$object->FundType.'</td>';       //type
                                $data['holder2'].='<td>'.$object->Comment.'</td>';      //transaction
                                $data['holder2'].='<td>'.$object->AccountNumber.'</td>';  //account
                                $data['holder2'].='<td>'.$object->Amount.'</td>';         //amount
                                $data['holder2'].='<td>'.$transactionType.'</td>';                         //pay system
                                $data['holder2'].='<td>'.$object->Stamp.'</td>';          //date
                                $data['holder2'].='</tr>';
                            }


                        }
                        if ($object->Operation=='REAL_FUND_WITHDRAW'){

                            $getWithdrawalTransactionByTicket = $this->Withdraw_model->getWithdrawalTransactionByTicket($object->Ticket);
                            $convertStamp = date("Y-m-d H:i:s", strtotime($object->Stamp));

                            if($getWithdrawalTransactionByTicket){

                                if($getWithdrawalTransactionByTicket['status'] > 0){
                                    switch($getWithdrawalTransactionByTicket['status']){
                                        case 1:
                                            $withdrawalStatus = 'Processed';
                                            break;
                                        case 2:
                                            if($getWithdrawalTransactionByTicket['decline_reference_number'] > 0){
                                                $withdrawalStatus = $getWithdrawalTransactionByTicket['recall'] ? 'Recalled' : 'Requested';
                                            }else{
                                                $withdrawalStatus = 'Requested';
                                            }

                                            break;
                                        default:
                                            $withdrawalStatus = 'N/A';
                                    }

                                    if(!empty($object->Comment)){
                                        $date_recalled = $getWithdrawalTransactionByTicket['date_recalled']?$getWithdrawalTransactionByTicket['date_recalled']:$getWithdrawalTransactionByTicket['date_withdraw'];
                                        if($getWithdrawalTransactionByTicket['recall']==1){
                                            $recall_comment = 'Recalled last '.$date_recalled;
                                        }else{
                                            $recall_comment = $object->Comment;
                                        }
                                        if(IPLoc::Office()){ $recall_comment = $recall_comment.' com5='.$object->Comment; }
                                        $comment = '<a href="javascript:void(0);" class="view-comment" data-wcomment="'.$recall_comment.'">View</a>';
                                    }else{
                                        $comment = 'N/A';
                                    }

                                    if(!empty($getWithdrawalTransactionByTicket["transaction_type"])){
                                        $transactionType = $this->transaction_type[strtoupper($getWithdrawalTransactionByTicket["transaction_type"])];
                                    }else{
                                        $transactionType = 'N/A';
                                    }

                                    $data['data']['withdraw']=true;
                                    $data['holder3'].='<tr>';
                                    $data['holder3'].='<td>'.$object->FundType.'</td>';       //type
//                            $data['holder3'].='<td>'.$object->Operation.'</td>';      //transaction
                                    $data['holder3'].='<td>'.$object->AccountNumber.'</td>';  //account
                                    $data['holder3'].='<td>'.$object->Amount.'</td>';         //amount
                                    $data['holder3'].='<td>'.$transactionType.'</td>';                         //pay system
                                    $data['holder3'].='<td>'.$convertStamp.'</td>';          //date
                                    $data['holder3'].='<td>'.$withdrawalStatus.'</td>';          //status
                                    $data['holder3'].='<td>'.$comment.'</td>';
                                    $data['holder3'].='</tr>';
                                }

                            }else{
                                $data['data']['withdraw']=true;
                                $data['holder3'].='<tr>';
                                $data['holder3'].='<td>'.$object->FundType.'</td>';       //type
//                            $data['holder3'].='<td>'.$object->Operation.'</td>';      //transaction
                                $data['holder3'].='<td>'.$object->AccountNumber.'</td>';  //account
                                $data['holder3'].='<td>'.$object->Amount.'</td>';         //amount
                                $data['holder3'].='<td>N/A</td>';                         //pay system
                                $data['holder3'].='<td>'.$convertStamp.'</td>';          //date
                                $data['holder3'].='<td>N/A</td>';          //status
                                $data['holder3'].='</tr>';
                            }

                        }

                        if ($object->Operation=='REAL_FUND_TRANSFER'){
                            /*1*/
                            if (strpos($object->Comment, 'INTERNAL_TRANSFER_FROM_') !== false) {
                                $data['trans_to']  = $object->AccountNumber;
                                $data['trans_from'] = str_replace('INTERNAL_TRANSFER_FROM_','',$object->Comment);
                            }else{

                                $data['trans_from']= $object->AccountNumber;
                                $data['trans_to']= $object->AccountReceiver;
                            }

                            $data['data']['transfer']=true;
                            $data['holder4'].='<tr>';
                            $data['holder4'].='<td>'.$object->FundType.'</td>';       //type
                            $data['holder4'].='<td>'.$object->Operation.'</td>';      //transaction
                            $data['holder4'].='<td>'. $data['trans_from'].'</td>';  //account from
                            $data['holder4'].='<td>'. $data['trans_to'].'</td>';  //account to
                            $data['holder4'].='<td>'.$object->Amount.'</td>';         //amount
                            $data['holder4'].='<td>'.$object->Stamp.'</td>';          //date
                            $data['holder4'].='</tr>';
                        }

                        if (strpos($object->Operation, 'PAMM') !== false) {
                            $data['data']['pamm']=true;
                            $data['holder5'].='<tr>';
                            $data['holder5'].='<td>'.$object->AccountNumber.'</td>';
                            $data['holder5'].='<td>'.$object->FundType.'</td>';
                            $data['holder5'].='<td>'.$object->Ticket.'</td>';
                            $data['holder5'].='<td>'.$object->Amount.'</td>';
                            $data['holder5'].='<td>'.$object->Stamp.'</td>';
                            $data['holder5'].='<td>'.$object->Comment.'</td>';
                            $data['holder5'].='</tr>';
                        }

                    }
                    break;
                default:
                    $data['holder0']='';

            }

            if($WebService->request_status === 'RET_OK'){


                $financeRecords = $WebService->get_result('FinanceRecords');
                foreach($financeRecords->FinanceRecordData as $object){
                    if($object->Operation === 'REAL_FUND_WITHDRAW'){
                        $resultTransaction = $this->Withdraw_model->getWithdrawalTransactionByTicket($object->Ticket);
//                        $convertStamp = date("Y-M-d H:i:s", strtotime($object->Stamp));
//                        $convertStamp = new DateTime($object->Stamp);
                        $convertStamp = DateTime::createFromFormat('Y-m-d\TH:i:s',$object->Stamp);

                        if($resultTransaction){
                            if($resultTransaction['status'] == 0){
                                $data['withdrawFinance'].= "<tr id=".$object->Ticket."}'>"
                                    ."<td class='FundType' align='center'>".$object->FundType."</td>"
                                    ."<td class='Operation' align='center'>".$object->Operation."</td>"
                                    ."<td class='AccountNumber'>".$object->AccountNumber."</td>"
                                    ."<td class='Amount'>".$object->Amount."</td>"
                                    ."<td class='PaySystem'>".$this->transaction_type[strtoupper($resultTransaction['transaction_type'])]."</td>"
                                    ."<td class='Stamp'>".$convertStamp->format('Y-M-d H:i:s')."</td>"
                                    ."<td class='Recall'><a class='btn-withdraw-option recall-action' data-ticket=".$object->Ticket.">Recall</a></td>"
                                    ."</tr>";
                            }
                        }
                    }
                }
            }

            $data['holderincomplete']='';
            $data['title_page'] = lang('sb_li_2');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'transaction-history';

            $data['metadata_description'] = lang('frahis_dsc');
            $data['metadata_keyword'] = lang('frahis_kew');
            $this->template->title(lang('frahis_tit'))
                ->set_layout('internal/main')
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 ")
                ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                          </script>
                        <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                       <script src='".$this->template->Js()."bootbox.min.js'></script>
                       <script src='".$this->template->Js()."Moment.js'></script>
                       <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                       <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                 ")

                ->build('transaction_history_dt',$data);
            unset($data);
        }else{
            redirect('signout');
        }
    }

    public function excel($tranType){

        $pTransactionType = ucfirst($tranType);
        if( $this->session->userdata('login_type') == 1){
            $getAccountsByUserIdRow = $this->Account_model->getAccountByPartnerId($this->user_id);
            //$getAccountsByUserIdRow['account_number'] = $getAccountsByUserIdRow['reference_num'];
        }else{
            $getAccountsByUserIdRow = $this->Account_model->getAccountsByUserIdRow($this->user_id);
        }

        $account_number = $getAccountsByUserIdRow['account_number'];
        $from = DateTime::createFromFormat('Y/m/d', date('2015/5/5'));
        $to = DateTime::createFromFormat('Y/m/d H:i:s', date('Y/m/d').' 23:59:59');

        $Transaction = new Transaction();
        $getAllTransactionData = $Transaction->getAllTransactionData($pTransactionType, $account_number, $from->format('Y-m-d\TH:i:s'), $to->format('Y-m-d\TH:i:s'));

        $this->load->library('excel');

        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Forexmart Transactions - '.$getAccountsByUserIdRow['account_number']);

        //set row heading
        $this->excel->getActiveSheet()->setCellValue('A1', 'Type');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Transaction');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Account');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Amount');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Pay System');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Date');

        for($col = ord('A'); $col <= ord('G'); $col++){
            //set column dimension
            $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
            //change the font size
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

            $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        }
        $this->excel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1:F1')->getFont()->setSize(14);
        $this->excel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        if($getAllTransactionData){
            $row = 2;
            foreach($getAllTransactionData as $data){

                $convertStamp = date("Y-m-d H:i:s", strtotime($data['Stamp']));

                $this->excel->getActiveSheet()->setCellValue('A'.$row, $data['FundType']);
                $this->excel->getActiveSheet()->setCellValue('B'.$row, $data['Operation']);
                $this->excel->getActiveSheet()->setCellValue('C'.$row, $data['AccountNumber']);
                $this->excel->getActiveSheet()->setCellValue('D'.$row, round($data['Amount'], 2));
                $this->excel->getActiveSheet()->setCellValue('E'.$row, 'N/A');
                $this->excel->getActiveSheet()->setCellValue('F'.$row, $convertStamp);
                $row++;
            }
        }else{
            $this->excel->getActiveSheet()->mergeCells('A2:F2');
            $this->excel->getActiveSheet()->setCellValue('A2', 'No record found');
            $this->excel->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        ob_end_clean();

        $filename = $account_number.'-'.strtotime('now').'.xlsx';
        $_SESSION['e-payments-file'] = $filename;

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');

    }


    public function yandex_export_csv($ticket){ //withdrawalqueue/yandex_payout
        $transaction_details = $this->Account_model->getWithdrawalTransactionYandex_payout($ticket);
        $filename = $ticket . '-' . strtotime('now') . '.csv';
        $this->load->library('excel');

        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Forexmart Transactions - '.$ticket);

        //set row heading
        $this->excel->getActiveSheet()->setCellValue('A1', 'Reference Number');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Client Name');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Forexmart Account Number');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Amount Requested');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Amount Deducted');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Date Requested');

        for($col = ord('A'); $col <= ord('G'); $col++){
            //set column dimension
            $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
            //change the font size
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

            $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        }
        $this->excel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1:F1')->getFont()->setSize(14);
        $this->excel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        if($transaction_details){
            $row = 2;
            foreach($transaction_details as $data){

                $convertStamp = date("Y-m-d H:i:s", strtotime($data['date_withdraw']));

                $this->excel->getActiveSheet()->setCellValue('A'.$row, $data['reference_number']);
                $this->excel->getActiveSheet()->setCellValue('B'.$row, $data['full_name']);
                $this->excel->getActiveSheet()->setCellValue('C'.$row, $data['account_number']);
                $this->excel->getActiveSheet()->setCellValue('D'.$row, round($data['amount'], 2));
                $this->excel->getActiveSheet()->setCellValue('E'.$row, round($data['amount_deducted'], 2));
                $this->excel->getActiveSheet()->setCellValue('F'.$row, $convertStamp);
                $row++;
            }
        }else{
            $this->excel->getActiveSheet()->mergeCells('A2:F2');
            $this->excel->getActiveSheet()->setCellValue('A2', 'No record found');
            $this->excel->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        ob_end_clean();


        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');

    }

    public function pdf($tranType){

        $pTransactionType = ucfirst($tranType);
        if( $this->session->userdata('login_type') == 1){
            $getAccountsByUserIdRow = $this->Account_model->getAccountByPartnerId($this->user_id);
            //$getAccountsByUserIdRow['account_number'] = $getAccountsByUserIdRow['reference_num'];
        }else{
            $getAccountsByUserIdRow = $this->Account_model->getAccountsByUserIdRow($this->user_id);
        }
        //$getAccountsByUserIdRow = $this->Account_model->getAccountsByUserIdRow($this->user_id);

        $account_number = $getAccountsByUserIdRow['account_number'];
        $from = DateTime::createFromFormat('Y/m/d', date('2015/5/5'));
        $to = DateTime::createFromFormat('Y/m/d H:i:s', date('Y/m/d').' 23:59:59');

        $Transaction = new Transaction();
        $getAllTransactionData = $Transaction->getAllTransactionData($pTransactionType, $account_number, $from->format('Y-m-d\TH:i:s'), $to->format('Y-m-d\TH:i:s'));

        $this->load->library('PDF_MC_Table');
        $pdf=new PDF_MC_Table();
        $pdf->AddPage();
        $pdf->SetFont('Arial','',12);
        $pdf->SetWidths(array(32,32,32,32,32,32));
        $header = array('Type', 'Transaction', 'Account', 'Amount', 'Pay System', 'Date');
        $pdf->Header($header);

        foreach($getAllTransactionData as $data){
            $convertStamp = date("Y-m-d H:i:s", strtotime($data['Stamp']));
            $pdf->Row(
                array(
                    $data['FundType'],
                    $data['Operation'],
                    $data['AccountNumber'],
                    round($data['Amount'], 2),
                    'N/A',
                    $convertStamp
                )
            );
        }

        $pdf->Output();
    }
    public function getAllWithdrawals(){
//       if(IPLoc::Office()){
//           $user_id = 156131;
//       }else{
           $user_id = $this->session->userdata('user_id');
     //}
        $statusId = array();
        $statusId[] = 0;
        switch($_POST['tab']){
            case 'Request':
                $statusId[] = 0;
                break;
            case 'Processed':
                $statusId[] = 1;
                break;
            case 'Declined':
                $statusId[] = 2;
                break;
        }

        $recordsTotal = $this->Withdraw_model->CountAllWithdrawalTransaction($statusId,$user_id);
        $getWithdrawTransactions = $this->Withdraw_model->GetAllWithdrawalTransaction($statusId, $_POST['start'], $_POST['length'],$user_id);

        $data = array();

        foreach($getWithdrawTransactions as $details){
            $recall = $details['recall'];
            //$recalled = $recall ? 'Yes' : 'No';

            $recalled = $recall ? 'Yes' : "<a class='btn-withdraw-option recall-action' data-ticket='".$details['reference_number']."'>Recall</a>";


            switch($_POST['tab']){
                case 'Request':
                    $tempArray = array(
                        'DT_RowId' => $details['wId'],
                        $details['reference_number'],
                        $details['full_name'],
                        $details['account_number'],
                        $details['amount']." ".$details['currency'],
                        $details['amount_deducted']." ".$details['currency'],
                        $this->transaction_type[$details['transaction_type']],
                        $details['date_withdraw'],
                        $recalled
                    );
                    break;
                case 'Processed':
                    $tempArray = array(
                        'DT_RowId' => $details['wId'],
                        $details['reference_number'],
                        $details['full_name'],
                        $details['account_number'],
                        $details['amount']." ".$details['currency'],
                        $details['amount_deducted']." ".$details['currency'],
                        $this->transaction_type[$details['transaction_type']],
                        $details['date_withdraw']
                    );
                    break;
                case 'Declined':
                    $tempArray = array(
                        'DT_RowId' => $details['wId'],
                        $details['reference_number'],
                        $details['full_name'],
                        $details['account_number'],
                        $details['amount']." ".$details['currency'],
                        $details['amount_deducted']." ".$details['currency'],
                        $this->transaction_type[$details['transaction_type']],
                        $details['date_withdraw']
                    );
                    break;
            }

            $transInfo = array(
                'Id' => $details['wId'],
                'clientName' => $details['full_name'],
                'referenceNumber' => $details['reference_number'],
                'transactionType' => $this->transaction_type[$details['transaction_type']]
            );

//            switch($_POST['tab']){
//                case 'Request':
//                    if($recall){
//                    //    $action = "<a href='#' data-info='".json_encode($transInfo)."' class='decline-link' data-toggle='modal' data-target='#decline_modal'>Decline</a>";
//                    }else{
//                    //    $action = "<a href='javascript:void(0)' data-info='".json_encode($transInfo)."' class='approve-link'>Approve</a> | <a href='#' data-info='".json_encode($transInfo)."' class='decline-link' data-toggle='modal' data-target='#decline_modal'>Decline</a>";
//                    }
//
//                    array_push($tempArray, $action);
//                    break;
//                case 'Processed':
//                    array_push($tempArray, $_POST['tab']);
//                    break;
//                case 'Declined':
//                    $actionPro = $recall ? 'Recalled' : $_POST['tab'];
//                    array_push($tempArray, $actionPro);
//                    break;
//            }
            $data[] = $tempArray;
        }
        $result = array(
            'draw'              => (int) $_POST['draw'],
            'recordsTotal'      => (int) $recordsTotal['Count'],
            'recordsFiltered'   => (int) $recordsTotal['Count'],
            'data'              => $data
        );

        echo json_encode($result);
    }
    
    
    
    public function getBalanceOperation(){
        $user_id = $this->session->userdata('user_id');
        $draw = (int) $this->input->post('draw');

        $start = $this->input->post('start');
        $length = $this->input->post('length');
       // $search = $this->input->post('extra_search');
       // $sort = $this->input->post('sort');

        $this->load->library('WSV');
        $args = array(
            'Limit' => $length,
            'Offset' => $start,
        );
        $WSV = new WSV();
        $requestResult = $WSV->GetFinanceOpHistoryV2($args);
        $requestStatus = $requestResult['ErrorMessage'];
        $dataCount = $requestStatus->DataCount; //total count
        $traderData = $requestStatus->Transactions->MonitorAccountData;
        if($requestStatus == 'RET_OK'){




            $pendingList = array();
            foreach ($traderData as $key => $value) {
//                $tempArray = array(
//
//                );
//                $data1[] = $tempArray;
            }
        }


    }


    public function getPendingWithdrawalsV2(){
        $user_id = $this->session->userdata('user_id');
        $statusId = array();
        $statusId[] = 0;
//        switch($_POST['tab']){
//            case 'Request':$statusId[] = 0;break;
//            case 'Processed':$statusId[] = 1;break;
//            case 'Declined':$statusId[] = 2;break;
//        }
        $recordsTotal = $this->Withdraw_model->CountAllWithdrawalTransaction($statusId,$user_id);
        $getWithdrawTransactions = $this->Withdraw_model->GetAllWithdrawalTransaction($statusId, $_POST['start'], $_POST['length'],$user_id);
        $data1 = array();
        $from = date('Y-m-d\TH:i:s', strtotime('2015/5/5'));
        $to = date('Y-m-d\TH:i:s', strtotime('today'.' 23:59:59'));


        if($getWithdrawTransactions){

//            echo '<pre>';
//            print_r($getWithdrawTransactions); exit();
            $ctr = 1;
                foreach($getWithdrawTransactions as $v){
                        //$resultTransaction = $this->Withdraw_model->getWithdrawalTransactionByTicket($object->Ticket);
                        $convertStamp = date("Y-m-d H:i:s", strtotime($v['date_withdraw']));
                        $recall = $v['recall'];
                        $recalled = $recall ? 'Yes' : "<button class='btn-withdraw-option recall-action' data-ticket='".$v['reference_number']."' data-transId='".$v['wId']."'>Recall</button>";
                        if ($v['status']== 0) {

                                $wAmount= ($v['amount_deducted'] * -1);
                                $tcAmount= $wAmount." ".$v['currency'];
                                $pcPay=$this->transaction_type[$v['transaction_type']];
                            
                                $wTicket = $v['reference_number'];
                                $wType = "REAL";
                                $wAccount = $v['account_number'];

                                $cRef="'$wTicket'";
                                $cType="'$wType'";
                                $cTrns="'WITHDRAW'";
                                $cAcc="'$wAccount'";
                                $cAmnt="'$tcAmount'";
                                $cPay="'$pcPay'";
                                $cdate="'$convertStamp'";
                                //$view_details = '<button class="btn-withdraw-option"  onclick="openTransectionDetails('.$cRef.','.$cType.','.$cTrns.','.$cAcc.','.$cAmnt.','.$cPay.','.$cdate.')">Details</button> ';

                                $tempArray = array(
                                    'DT_RowId' => $v['wId'],
                                    //$wTicket,
                                    $ctr++,
                                    $wType,
                                    'WITHDRAW',
                                   // $wAccount,
                                    $wAmount." ".$v['currency'],
                                    $pcPay,
                                    $convertStamp,
                                    $recalled,
                                    //$view_details
                                );


                                $transInfo = array(
                                    'Id' => $v['wId'],
                                    'clientName' => $this->session->userdata('full_name'),
                                    'referenceNumber' => $v['reference_number'],
                                    'transactionType' => $this->transaction_type[$v['transaction_type']]
                                );
                                $data1[] = $tempArray;
                            


                        }
                    


                }



            
        }



        $result = array(
            'draw'              => (int) $_POST['draw'],
            'recordsTotal'      => (int) $recordsTotal['Count'],
            'recordsFiltered'   => (int) $recordsTotal['Count'],
            'data'              => $data1
        );

        echo json_encode($result);
//        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
    public function getPendingWithdrawals(){
        $user_id = $this->session->userdata('user_id');
//        if(IPLoc::IPOnlyForMe()){
//            print_r($user_id);exit;
//        }
        $statusId = array();
        $statusId[] = 0;
        switch($_POST['tab']){
            case 'Request':$statusId[] = 0;break;
            case 'Processed':$statusId[] = 1;break;
            case 'Declined':$statusId[] = 2;break;
        }
        $recordsTotal = $this->Withdraw_model->CountAllWithdrawalTransaction($statusId,$user_id);
        $getWithdrawTransactions = $this->Withdraw_model->GetAllWithdrawalTransaction($statusId, $_POST['start'], $_POST['length'],$user_id);
        $data1 = array();
      //  $data['from'] = DateTime::createFromFormat('Y/d/m', date('2015/5/5'));
      //  $data['to'] = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m').' 23:59:59');

        $from = date('Y-m-d\TH:i:s', strtotime('2015/5/5'));
        $to = date('Y-m-d\TH:i:s', strtotime('today'.' 23:59:59'));
        $account_info = array(
            'iLogin' => $getWithdrawTransactions[0]['account_number'],
            'from' => $from,
            'to' => $to
        );


        if($getWithdrawTransactions){
            $webservice_config = array('server' => 'live_new');
            $WebService = new WebService($webservice_config);
            $WebService->open_RequestAccountFinanceRecordsByDate($account_info);
            if($WebService->request_status === 'RET_OK'){
                $financeRecords = $WebService->get_result('FinanceRecords');
                foreach($financeRecords->FinanceRecordData as $object){
                    if($object->Operation === 'REAL_FUND_WITHDRAW'){
                        $resultTransaction = $this->Withdraw_model->getWithdrawalTransactionByTicket($object->Ticket);
                        $convertStamp = date("Y-m-d H:i:s", strtotime($object->Stamp));
                        $recall = $resultTransaction['recall'];
                        $recalled = $recall ? 'Yes' : "<a class='btn-withdraw-option recall-action' data-ticket='".$resultTransaction['reference_number']."' data-transId='".$resultTransaction['id']."'>Recall</a>";
                        if ($resultTransaction) {
                            if ($resultTransaction['status'] == 0) {

                                $tcAmount=$object->Amount." ".$resultTransaction['currency'];
                                $pcPay=$this->transaction_type[$resultTransaction['transaction_type']];

                                $cRef="'$object->Ticket'";
                                $cType="'$object->FundType'";
                                $cTrns="'WITHDRAW'";
                                $cAcc="'$object->AccountNumber'";
                                $cAmnt="'$tcAmount'";
                                $cPay="'$pcPay'";
                                $cdate="'$convertStamp'";
                                $view_details = '<button class="btn-withdraw-option "  onclick="penTransectionDetails('.$cRef.','.$cType.','.$cTrns.','.$cAcc.','.$cAmnt.','.$cPay.','.$cdate.')">Details</button> ';

                                    $tempArray = array(
                                        'DT_RowId' => $resultTransaction['id'],
                                        $object->Ticket,
                                        $object->FundType,
                                        'WITHDRAW',
                                        $object->AccountNumber,
                                        $object->Amount." ".$resultTransaction['currency'],
                                        $this->transaction_type[$resultTransaction['transaction_type']],
                                        $convertStamp,
                                        $recalled,
                                        $view_details
                                    );


                                $transInfo = array(
                                    'Id' => $resultTransaction['id'],
                                    'clientName' => $this->session->userdata('full_name'),
                                    'referenceNumber' => $resultTransaction['reference_number'],
                                    'transactionType' => $this->transaction_type[$resultTransaction['transaction_type']]
                                );
                                $data1[] = $tempArray;
                            }


                        }





                    }

                }



            }
        }



        $result = array(
            'draw'              => (int) $_POST['draw'],
            'recordsTotal'      => (int) $recordsTotal['Count'],
            'recordsFiltered'   => (int) $recordsTotal['Count'],
            'data'              => $data1
        );

        echo json_encode($result);
//        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }


    public function getPendingRequestFundTransfer(){
        $user_id = $this->session->userdata('user_id');
        $account = $this->account_model->getAccountByPartnerId2($user_id);
//        if(IPLoc::IPOnlyForMe()){
//            print_r($user_id);exit;
//        }
        $statusId = array();
        $statusId[] = 6; //verifying
        switch($_POST['tab']){
            case 'Request':$statusId[] = 6;break;
            case 'Processed':$statusId[] = 1;break;
            case 'Declined':$statusId[] = 2;break;
        }
        $recordsTotal = $this->Withdraw_model->CountAllRequestTransitTransferTransaction($statusId,$account['account_number']);
        $getWithdrawTransactions = $this->Withdraw_model->GetAllRequestTransitTransferTransaction($statusId, $_POST['start'], $_POST['length'],$account['account_number']);
        $data1 = array();
        $data['from'] = DateTime::createFromFormat('Y/d/m', date('2015/5/5'));
        $data['to'] = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m').' 23:59:59');
        $account_info = array(
            'iLogin' => $getWithdrawTransactions[0]['receiver'],
            'from' => $data['from']->format('Y-m-d\TH:i:s'),
            'to' => $data['to']->format('Y-m-d\TH:i:s')
        );


        if($getWithdrawTransactions){
            $webservice_config = array('server' => 'live_new');
            $WebService = new WebService($webservice_config);
            $WebService->open_RequestAccountFinanceRecordsByDate($account_info);
            if($WebService->request_status === 'RET_OK'){
                $financeRecords = $WebService->get_result('FinanceRecords');
                foreach($financeRecords->FinanceRecordData as $object){
                    if(substr($object->Comment,0,8) === 'DPST_TR_'){
                        $transID = substr($object->Comment,15,10);
                        $resultTransaction = $this->Withdraw_model->getRequestFundTransactionByTransactionID($transID);
                        $convertStamp = date("Y-m-d H:i:s", strtotime($object->Stamp));
                        $recall = $resultTransaction['recall'];
//                        $recalled = $recall ? 'Yes' : "<a class='btn-withdraw-option recall-action' data-ticket='".$resultTransaction['receiver']."' data-transId='".$resultTransaction['id']."'>Recall</a>";
                        if ($resultTransaction) {
                            if ($resultTransaction['status'] == 6) {
                                $tempArray = array(
                                    'DT_RowId' => $resultTransaction['id'],
                                    $object->Ticket,
                                    $object->FundType,
                                    $object->Comment,
                                    $object->AccountNumber,
                                    $object->Amount." ".$account['currency'],
                                    'N/A',
                                    $convertStamp,
//                                    $recalled
                                );
                                $transInfo = array(
                                    'Id' => $resultTransaction['id'],
                                    'clientName' => $this->session->userdata('full_name'),
                                    'referenceNumber' => $resultTransaction['receiver'],
                                    'transactionType' => 'ITS'
                                );
                                $data1[] = $tempArray;
                            }
                        }
                    }

                }
            }
        }


        $result = array(
            'draw'              => (int) $_POST['draw'],
            'recordsTotal'      => (int) $recordsTotal['Count'],
            'recordsFiltered'   => (int) $recordsTotal['Count'],
            'data'              => $data1
        );

        echo json_encode($result);
//        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function recallUpdateStatus()
    {
       $ticket = $this->input->post('ticket');
        if($ticket){
            $updateData = array(
                'recall' => 1
            );
            $this->Withdraw_model->updateWithdrawalDetails($ticket, $updateData);

            echo 'done';
        } else {
            echo '';
        }

    }
            
    
    public function newTransactionHistory(){


            $this->lang->load('transactionhistory');
            $this->lang->load('datatable');
            $this->load->library('IPLoc', null);


            if($this->session->userdata('logged')) {
                $user_id = $this->session->userdata('user_id');
                $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
                $data['login_type'] = $mtas3['login_type'];

                if( $this->session->userdata('login_type') == 1){
                    $data['mtas'] = $this->g_m->showssingle2($table='partnership',$field='partner_id',$id=$_SESSION['user_id'],$select='reference_num');
                    $data['mtas']['account_number'] = $data['mtas']['reference_num'];
                }else{
                    $data['mtas'] = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
                }

                $withdrawalCommentsKey = array(
                    'comment_w1' => 'withdrawal',
                    'comment_w2' => 'w/d'
                );


                $data['holderincomplete']='';
                $data['title_page'] = lang('sb_li_2');
                $data['active_tab'] = 'finance';
               // $data['active_tab'] = 'transaction-history';
                $data['active_sub_tab'] = 'transaction-history';

                $data['metadata_description'] = lang('frahis_dsc');
                $data['metadata_keyword'] = lang('frahis_kew');
                $this->template->title(lang('frahis_tit'))
                    ->set_layout('internal/main')
                    ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 ")
                    ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                            var recordType='".$data['active_sub_tab']."',
                                base_url ='".base_url()."';
                          </script>
                        <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                       <script src='".$this->template->Js()."bootbox.min.js'></script>
                       <script src='".$this->template->Js()."Moment.js'></script>
                       <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                       <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                 ")

                    ->build('new_transaction_history',$data);
                unset($data);
            }else{
                redirect('signout');
            }



    }
    public function newDownloadExcel(){

        require_once APPPATH . "libraries/third_party/PHPExcel/Writer/PDF.php";
        require_once APPPATH . "libraries/third_party/PHPExcel/PHPExcel.php";

        $pTransactionType = ucfirst('Transactions');
        if( $this->session->userdata('login_type') == 1){
            $getAccountsByUserIdRow = $this->Account_model->getAccountByPartnerId($this->user_id);
            //$getAccountsByUserIdRow['account_number'] = $getAccountsByUserIdRow['reference_num'];
        }else{
            $getAccountsByUserIdRow = $this->Account_model->getAccountsByUserIdRow($this->user_id);
        }

        $account_number = $getAccountsByUserIdRow['account_number'];

        $this->load->library('WSV');
        $WSV = new WSV();
        $args = array('AccountNumber' => $_SESSION['account_number'],       'Limit' => 10,    'Offset' => 0,   );
        $x = ( $WSV->GetFinanceOpHistoryV2($args)['ErrorMessage']=='RET_OK') ? $WSV->GetFinanceOpHistoryV2($args)['Data']: array() ;
        $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
        $args['Limit'] = $res['count'];
        $y = ( $WSV->GetFinanceOpHistoryV2($args)['ErrorMessage']=='RET_OK') ? $WSV->GetFinanceOpHistoryV2($args)['Data']: array() ;
        $getAllTransactionData = isset($y->Transactions) ? $y->Transactions : '';

//        $this->load->library('excel');

        $objPHPExcel = new PHPExcel();

        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Forexmart Transactions-'.$getAccountsByUserIdRow['account_number']);

        //set row heading
        $this->excel->getActiveSheet()->setCellValue('A1', '#');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Fund Type');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Fund Status');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Operation Type');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Amount');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Date');
        $this->excel->getActiveSheet()->setCellValue('G1', 'Details');

        for($col = ord('A'); $col <= ord('H'); $col++){
            //set column dimension
            $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
            //change the font size
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

            $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        }
        $this->excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setSize(14);
        $this->excel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        if($getAllTransactionData){
            $row = 2;
            $ctr = 1;
            foreach($getAllTransactionData->FinanceOpData as $data){
                $d = $this->getFundStatusPerOperationType($data->OperationTypeId);
                $dt = $this->getBalOpsDetails($data);

                $this->excel->getActiveSheet()->setCellValue('A'.$row, $ctr);
                $this->excel->getActiveSheet()->setCellValue('B'.$row, $d['FundType']);
                $this->excel->getActiveSheet()->setCellValue('C'.$row, $d['Status']);
                $this->excel->getActiveSheet()->setCellValue('C'.$row, $d['TransType']);
                $this->excel->getActiveSheet()->setCellValue('E'.$row, round($data->Amount, 2));
                $this->excel->getActiveSheet()->setCellValue('F'.$row, gmdate("Y-m-d H:i:s", $data->ProcessTime));
                $this->excel->getActiveSheet()->setCellValue('G'.$row, $dt);
                $row++;
                $ctr++;
            }
        }else{
            $this->excel->getActiveSheet()->mergeCells('A2:G2');
            $this->excel->getActiveSheet()->setCellValue('A2', 'No record found');
            $this->excel->getActiveSheet()->getStyle('A2:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        ob_end_clean();

        $filename = $account_number.'-'.strtotime('now').'.xlsx';
        $_SESSION['e-payments-file'] = $filename;

        header('Content-type: application/vnd.ms-excel’');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');

    }
    public function newDownloadPdf(){

        $pTransactionType = ucfirst('Transactions');
        if( $this->session->userdata('login_type') == 1){
            $getAccountsByUserIdRow = $this->Account_model->getAccountByPartnerId($this->user_id);
        }else{
            $getAccountsByUserIdRow = $this->Account_model->getAccountsByUserIdRow($this->user_id);
        }

        $account_number = $getAccountsByUserIdRow['account_number'];
        $this->load->library('WSV');
        $WSV = new WSV();
        $args = array('AccountNumber' => $_SESSION['account_number'],       'Limit' => 10,    'Offset' => 0,   );
        $x = ( $WSV->GetFinanceOpHistoryV2($args)['ErrorMessage']=='RET_OK') ? $WSV->GetFinanceOpHistoryV2($args)['Data']: array() ;
        $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
        $args['Limit'] = $res['count'];
        $y = ( $WSV->GetFinanceOpHistoryV2($args)['ErrorMessage']=='RET_OK') ? $WSV->GetFinanceOpHistoryV2($args)['Data']: array() ;
        $getAllTransactionData = isset($y->Transactions) ? $y->Transactions : '';

        $this->load->library('PDF_MC_Table');
        $pdf=new PDF_MC_Table();
        $pdf->AddPage();
        $pdf->SetFont('Arial','',10);
        $pdf->SetWidths(array(32,32,32,32,32,32));
        $header = array('Fund Type', 'Fund Status', 'Operation Type', 'Amount', 'Date', 'Reference #');
        $pdf->Header($header);
        foreach($getAllTransactionData->FinanceOpData as $data){
            $d = $this->getFundStatusPerOperationType($data->OperationTypeId);
            $pdf->Row(
                array(
                    $d['FundType'],
                    $d['Status'],
                    $d['TransType'],
                    round($data->Amount, 2),
                    gmdate("Y-m-d H:i:s", $data->ProcessTime),
                    $data->Ticket,
                )
            );
        }

        $pdf->Output();
    }
    public function getFundStatusPerOperationType($OperationTypeId){
        $operationType = array(
            'BONUS_30PERCENT'       => array( 'desc'=> 'PERCENT BONUS',         'status' => 3 , 'fundType' => 2),
            'BONUS_NO_DEPOSIT'      => array( 'desc'=> 'NO DEPOSIT BONUS',      'status' => 3 , 'fundType' => 2),
            'DEPOSIT_REAL_FUND'     => array( 'desc'=> 'DEPOSIT REAL FUND',     'status' => 1 , 'fundType' => 1),
            'WITHDRAW_REAL_FUND'    => array( 'desc'=> 'WITHDRAW REAL FUND',    'status' => 1 , 'fundType' => 1),
            'TRANSFER_REAL_FUND'    => array( 'desc'=> 'FUND TRANSFER',         'status' => 1 , 'fundType' => 1),
            'TRANSIT_TRANSFER_REAL_FUND'    => array( 'desc'=> 'FUND TRANSFER',         'status' => 1 , 'fundType' => 1),
            'BONUS_CONTEST_PRIZE'   => array( 'desc'=> 'CONTEST PRIZE BONUS',   'status' => 4 , 'fundType' => 2),
            'BONUS_SUPPORTER_PART'  => array( 'desc'=> 'SUPPORTER PART BONUS',  'status' => 4 , 'fundType' => 2),
            'BONUS_SHOWFX'          => array( 'desc'=> 'SHOWFX BONUS',          'status' => 4 , 'fundType' => 2),
            'BONUS_50PERCENT'       => array( 'desc'=> '50 PERCENT BONUS',      'status' => 3 , 'fundType' => 2),
            'PAMM_INVESTMENT'       => array( 'desc'=> 'PAMM INVESTMENT FUND',  'status' => 4 , 'fundType' => 1),
            'BONUS_CONTEST_MF_PRIZE'=> array( 'desc'=> 'FOREXMART_CONTEST_MF',  'status' => 4 , 'fundType' => 2),
            'BONUS_SUPPORTER_FULL'  => array( 'desc'=> 'SUPPORTER FULL',        'status' => 1 , 'fundType' => 1),
            'BONUS_100_PERCENT'     => array( 'desc'=> '100 PERCENT BONUS',     'status' => 4 , 'fundType' => 2),
            'COMMISSION_ADJUSTMENT' => array( 'desc'=> 'COMMISSION ADJUSTMENTS','status' => 1 , 'fundType' => 1),
            'BONUS_100_PERCENT_CONSTANT' => array( 'desc'=> '100 PERCENT CONSTANT BONUS', 'status' => 4 , 'fundType' => 2),
            'INVITE_FRIEND_BONUS'   => array( 'desc'=> 'INVITE A FRIEND BONUS', 'status' => 1 , 'fundType' => 1),
            'FORUM_BONUS'           => array( 'desc'=> 'FORUM BONUS',           'status' => 3 , 'fundType' => 2),
            'SUB_IB_COMMISSION'     => array( 'desc'=> 'SUB IB COMMISSION',     'status' => 1 , 'fundType' => 1),
            'BONUS_PROFIT'          => array( 'desc'=> 'BONUS PROFIT',          'status' => 3 , 'fundType' => 1),
            'ERROR_ORDER_CANCEL'    => array( 'desc'=> 'ERROR ORDER CANCELLATION', 'status' => 4 , 'fundType' => 2),
            'BONUS_70PERCENT'       => array( 'desc'=> '70 PERCENT BONUS',      'status' => 3 , 'fundType' => 2),
            'FEE_COMPENSATION'      => array( 'desc'=> 'FEE COMPENSATION',      'status' => 1 , 'fundType' => 1),
            'AFFILIATE_FEE'         => array( 'desc'=> 'AFFILIATE FEE',         'status' => 1 , 'fundType' => 1),
            'REFUND'                => array( 'desc'=> 'REFUND',                'status' => 1 , 'fundType' => 1),
            'DELETED_TICKET'        => array( 'desc'=> 'DELETED TICKET',        'status' => 1 , 'fundType' => 1),
            'BONUS_FOREXCOPY'       => array( 'desc'=> 'BONUS FOREXCOPY',       'status' => 4 , 'fundType' => 2),
            'BONUS_20PERCENT'       => array( 'desc'=> 'BONUS_20PERCENT',       'status' => 3 , 'fundType' => 2),
        );
        $status = array(
            '1' => 'WITHDRAWABLE_FULL',
            '2' => 'WITHDRAWABLE_HALF',
            '3' => 'WITHDRAWABLE_PARTIAL',
            '4' => 'NON_WITHDRAWABLE',
            '5' => 'NO_PERMISSION',
        );
        switch($OperationTypeId){
            case 'DEPOSIT_REAL_FUND': $tType = "Deposit"; break;
            case 'WITHDRAW_REAL_FUND': $tType = "Withdraw"; break;
            case 'TRANSFER_REAL_FUND': $tType = "Transfer"; break;
            case 'TRANSIT_TRANSFER_REAL_FUND': $tType = "Transfer"; break;
            default: $tType = "Bonus"; break;
        }

        return array(
            'Description' =>  isset($operationType[$OperationTypeId]['desc']) ? $operationType[$OperationTypeId]['desc'] : 'N/A',
            'FundType' => $operationType[$OperationTypeId]['fundType']==1? 'REAL': 'BONUS',
            'Status' => isset($status[$operationType[$OperationTypeId]['status']]) ? $status[$operationType[$OperationTypeId]['status']] : "N/A",
            'TransType' => $tType,
        );
    }

    public function getBalOpsDetails($a){
        $ticketArray = $this->getFinanceTxn();
        $withdrawalCommentsKey = array(
            'comment_w1' => 'withdrawal',
            'comment_w2' => 'w/d'
        );
        $d = $this->getFundStatusPerOperationType($a->OperationTypeId);
        $details = "<p>Ticket:".$a->Ticket."\nComment:".$a->Comment."\n</p>";
        if($d['FundType']=="BONUS"){
            $d['TransType'] = "Bonus";
        }else{
            if($d['FundType']=='REAL' && $a->OperationTypeId=='BONUS_SUPPORTER_FULL' ){
                if($a->Amount < 0){
                    $d['TransType'] = "Withdraw";
                    $getWithdrawalTransactionByTicket = $ticketArray[$a->Ticket]; // $this->Withdraw_model->getWithdrawalTransactionByTicket($object->Ticket);
                    if($getWithdrawalTransactionByTicket){
                        if($getWithdrawalTransactionByTicket['status'] > 0){
                            switch($getWithdrawalTransactionByTicket['status']){
                                case 1:     $stat = 'Processed';  break;
                                case 2:     $stat =( ($getWithdrawalTransactionByTicket['decline_reference_number'] > 0) && ( $getWithdrawalTransactionByTicket['recall'] ) ) ? 'Recalled' : 'Requested';  break;
                                default:    $stat = 'N/A'; break;
                            }
                            if(!empty($a->Comment)){
                                $date_recalled = $getWithdrawalTransactionByTicket['date_recalled']?$getWithdrawalTransactionByTicket['date_recalled']:$getWithdrawalTransactionByTicket['date_withdraw'];
                                if($getWithdrawalTransactionByTicket['recall']==1){
                                    $comment = 'Recalled last '.$date_recalled;
                                }else{
                                    $comment = $a->Comment;
                                }
                                if(IPLoc::Office()){ $comment = $comment.' com1='.$a->Comment; }
                            }else{
                                $comment = 'N/A';
                            }
                            $pSystem = (!empty($getWithdrawalTransactionByTicket["transaction_type"])) ?  $this->getTp[strtoupper($getWithdrawalTransactionByTicket["transaction_type"])] : "N/A";
                        }
                    }else{
                        $pSystem = "N/A";
                        $stat = "N/A";
                    }
                }else{
                    $d['TransType'] = "Bonus";
                }

            }


            if(in_array($a->OperationTypeId, array("REAL_FUND_DEPOSIT", "FEE_COMPENSATION", "AFFILIATE_FEE" , "REFUND", "SUB_IB_COMMISSION"))){


                if (strpos(strtolower($a->Comment), $withdrawalCommentsKey['comment_w1'] ) !== false OR strpos(strtolower($a->Comment), $withdrawalCommentsKey['comment_w2'] ) !== false) {
                    $d['TransType'] = "Withdraw";
                    $getWithdrawalTransactionByTicket = $ticketArray[$a->Ticket];
                    if(!empty($a->Comment)){
                        $date_recalled = $getWithdrawalTransactionByTicket['date_recalled']?$getWithdrawalTransactionByTicket['date_recalled']:$getWithdrawalTransactionByTicket['date_withdraw'];
                        if($getWithdrawalTransactionByTicket['recall']==1){
                            $comment = 'Recalled last '.$date_recalled;
                        }else{
                            $comment = 'Withdrawal request declined last '.$getWithdrawalTransactionByTicket['date_withdraw'];
                        }
                    }else{
                        $comment = 'N/A';
                    }
                    $pSystem = (!empty($getWithdrawalTransactionByTicket["transaction_type"]))? $this->transaction_type[strtoupper($getWithdrawalTransactionByTicket["transaction_type"])] : 'N/A';
                    $recall = $getWithdrawalTransactionByTicket['recall']==1?'YES':'NO';
                    $stat = "Declined";
                }else{
                    $d['TransType'] = "Deposit";
                    $depositTransaction = isset($ticketArray[$a->Ticket])?$ticketArray[$a->Ticket]:false;
                    $pSystem = ($depositTransaction) ?  strtoupper($depositTransaction["transaction_type"]):'N/A';


                    if(substr($a->Comment,0,8) === 'DPST_TR_') {
                        $transID = substr($a->Comment, 15, 10);
                        $pSystem = 'A/T';
                    }
                }

            }


            if ($a->OperationTypeId=='WITHDRAW_REAL_FUND'){
                $getWithdrawalTransactionByTicket = $ticketArray[$a->Ticket];
                if($getWithdrawalTransactionByTicket){
                    if($getWithdrawalTransactionByTicket['status'] > 0){
                        switch($getWithdrawalTransactionByTicket['status']){
                            case 1:  $stat = 'Processed';  break;
                            case 2:  $stat =  'Declined'; break;
//                                        default:  $withdrawalStatus = 'N/A'; brea
                        }
                        if(!empty($a->Comment)){
                            $date_recalled = $getWithdrawalTransactionByTicket['date_recalled']?$getWithdrawalTransactionByTicket['date_recalled']:$getWithdrawalTransactionByTicket['date_withdraw'];
                            if($getWithdrawalTransactionByTicket['recall']==1){
                                $comment = 'Recalled last '.$date_recalled;
                            }else{
                                switch($getWithdrawalTransactionByTicket['status']){
                                    case 1: $comment = 'Proccessed last '.$getWithdrawalTransactionByTicket['date_processed']; break;
                                    case 2: $comment = 'Withdrawal request declined last '.$date_recalled; break;
                                }
                                $comment = $comment;
                            }
                        }else{
                            $comment = 'N/A';
                        }
                        $pSystem = (!empty($getWithdrawalTransactionByTicket["transaction_type"])) ?  $this->getTp[strtoupper($getWithdrawalTransactionByTicket["transaction_type"])] : "N/A";
                        $recall = $getWithdrawalTransactionByTicket['recall']==1?'YES':'NO';
                    }
                }else{
                    if((substr($a->Comment,0,7) == 'W/D_TR_')){                 $transID = substr($a->Comment, 14, 10);     }
                    if((substr($a->Comment,0,12) == 'DECLINED_TR_')) {          $transID = substr($a->Comment, 19, 10);     }
                    $resultTransaction = $ticketArray[$transID]; //$this->Withdraw_model->getRequestDeclineFundTransaction($transID);
                    $comm = $a->Comment;
                    if($resultTransaction && strlen($transID)>1){
                        $pSystem = 'ITS';
                        $stat = 'Declined';
                        $comment = $resultTransaction['decline_reason'];
                    }else{
                        $pSystem = 'N/A';
                        $stat = 'N/A';
                        $comment = $comm;
                    }
                }
            }



        }//END IF REAL FUND
        switch($d['TransType']){
            case 'Deposit':
                $pSystem = isset($pSystem)? $pSystem : "N/A";
                $details = "<p>
                                    Ticket:".$a->Ticket."\n
                                    Comment:".$a->Comment."\n
                                    Payment System:".$pSystem."\n
                                    </p>";
                break;
            case 'Withdraw':
                $pSystem = isset($pSystem)? $pSystem : "N/A";
                $recall = isset($recall)? $recall : "";
                $stat = isset($stat)? $stat : "N/A";
                $comment = (!empty($a->Comment))? $comment : "N/A";
                $details = "<p>
                                    Ticket:".$a->Ticket."\n
                                    Comment:".$comment."\n
                                    Payment System:".$pSystem."\n
                                    Status:".$stat."\n
                                    Recall:".$recall."\n
                                    </p>";
                break;
            case 'Transfer':
                $details = "<p>
                                    Ticket:".$a->Ticket."\n
                                    Comment:".$a->Comment."\n
                                    Transfer From:".$a->TransferAccountSender."\n
                                    Transfer To:".$a->TransferAccountReceiver."\n
                                    </p>";
                break;
            default:
                $details = $details;
                break;
        }
        return $details;
    }

}