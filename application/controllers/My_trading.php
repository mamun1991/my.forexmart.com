<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_trading extends MY_Controller {



    public function __construct(){
        parent::__construct();
        $this->load->model('account_model');
        $this->lang->load('modal_message');
        $this->lang->load('currenttrades');
        $this->lang->load('historyoftrades');
        $this->lang->load('datatable');  	
    }



    public function index(){
       // $this->current_trades();
                
        $this->NewGetOpenTrades();
    }

    //old

    public function current_trades(){
        //$this->lang->load('currenttrades');
        if($this->session->userdata('logged')){

           // if($_SERVER['REMOTE_ADDR']=='49.12.5.139') {
                $this->NewGetOpenTrades();
          /*  }else {

                $webservice_config = array('server' => 'live_new');
                $WebService = new WebService($webservice_config);
                $data['mtas'] = $this->g_m->showssingle2($table = 'mt_accounts_set', $field = 'user_id', $id = $_SESSION['user_id'], $select = 'account_number');
                $account_info = array(
                    'iLogin' => $data['mtas']['account_number']
                );

                $WebService->open_GetAccountActiveTrades($account_info);

                switch ($WebService->request_status) {
                    case 'RET_OK':
                        $tradatalist = (array)$WebService->get_result('TradeDataList');
                        if ($tradatalist) {
                            $opened = '';
                            foreach ($tradatalist['TradeData'] as $object) {


                                if (floatval($object->Volume) != 0) {
                                    $data['volume'] = (floatval($object->Volume) / 100);
                                } else {
                                    $data['volume'] = floatval($object->Volume);
                                }


                                $crTic = "'$object->OrderTicket'";
                                $crTrd = "'$object->TradeType'";
                                $crVol = "'$data[volume]'";
                                $crSym = "'$object->Symbol'";
                                $crOprc = "'$object->OpenPrice'";
                                $crStls = "'$object->StopLoss'";
                                $crTkprft = "'$object->TakeProfit'";
                                $crClprc = "'$object->ClosePrice'";
                                $crSwps = "'N/A'";
                                $crPrf = "'$object->Profit'";

                                $crDetails = 'Details';


                                $opened .= '<tr onclick="mobDetailsCloseTrades(' . $crTic . ',' . $crTrd . ',' . $crVol . ',' . $crSym . ',' . $crOprc . ',' . $crStls . ',' . $crTkprft . ',' . $crClprc . ',' . $crSwps . ',' . $crPrf . ')">';

                                $opened .= '<td>' . $object->OrderTicket . '</td>';
                                $opened .= '<td>' . $object->TradeType . '</td>';
                                $opened .= '<td>' . $data['volume'] . '</td>';


                                $opened .= '<td class="crTradesMob">' . $object->Symbol . '</td>';

                                $opened .= '<td  class="crTradesMob">' . $object->OpenPrice . '</td>';
                                $opened .= '<td  class="crTradesMob">' . $object->StopLoss . '</td>';
                                $opened .= '<td  class="crTradesMob">' . $object->TakeProfit . '</td>';
                                $opened .= '<td  class="crTradesMob">' . $object->ClosePrice . '</td>';
                                $opened .= '<td  class="crTradesMob">N/A</td>';
                                $opened .= '<td  class="crTradesMob">' . $object->Profit . '</td>';
                                $opened .= '<td class="crTradesWeb crTradesWebStyle">' . $crDetails . '</td>';


                                $opened .= '</tr>';
                            }

                            $data['Opened'] = $opened;
                        } else {
                            $data['Opened'] = '';

                        }
                        break;
                    default:
                        $data['data']['error'] = true;
                }

                $data['title_page'] = lang('sb_li_0');
                $data['active_tab'] = 'trading';
                $data['active_sub_tab'] = 'current-trades';
                $data['active_sub_sub_tab'] = 'current_trades';

                $data['metadata_description'] = lang('curtra_dsc');
                $data['metadata_keyword'] = lang('curtra_kew');
                $this->template->title(lang('curtra_tit'))
                    ->append_metadata_css("
                       <link rel='stylesheet' href='" . $this->template->Css() . "dataTables.bootstrap2.css'>
                       <link rel='stylesheet' href='" . $this->template->Css() . "loaders.css'>
                 ")
                    ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                          </script>
                       <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                       <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                 ")
                    ->set_layout('internal/main')
                    ->build('current_trades', $data);
            }*/
        }else{
            redirect('signout');
        }
    }
    public function pending_orders(){
       // $this->lang->load('currenttrades');
        if($this->session->userdata('logged')){
            $webservice_config = array('server' => 'live_new');
            $WebService = new WebService($webservice_config);
            $data['mtas'] = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
            $account_info = array(
                'iLogin' =>$data['mtas']['account_number']

            );
            $WebService->GetAccounPendingOrders($account_info);
            switch($WebService->request_status){
                case 'RET_OK':
                    $tradatalist = (array) $WebService->get_result('TradeDataList');
                    if($tradatalist){
                        $opened='';
                        foreach ( $tradatalist['TradeData'] as $object){
                            $opened.='<tr>';
                            $opened.='<td>'.$object->OrderTicket.'</td>';
                            $opened.='<td>'.$object->TradeType.'</td>';
                            $opened.='<td>'.number_format((float) $object->Volume,2).'</td>';
                            $opened.='<td>'.$object->Symbol.'</td>';
                            $opened.='<td>'.$object->OpenPrice.'</td>';
                            $opened.='<td>'.number_format((float) $object->StopLoss,5).'</td>';
                            $opened.='<td>'.number_format((float) $object->TakeProfit,5).'</td>';
                            $opened.='<td>'.$object->ClosePrice.'</td>';
                            $opened.='<td>N/A</td>';
                            $opened.='<td>'.number_format((float) $object->Profit,5).'</td>';
                            $opened.='</tr>';
                        }

                        $data['Opened']= $opened;
                    }else{
                        $data['Opened']='';
                    }
                    break;
                default:
                    $data['data']['error']=true;
            }

            $data['active_tab'] = 'trading';
            $data['active_sub_tab'] = 'current-trades';
            $data['active_sub_sub_tab'] = 'pending_orders';
            $this->template->title("ForexMart | Pending Orders")

                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                       <link rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                 ")
                ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                          </script>
                       <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                       <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                 ")
                ->set_layout('internal/main')

                ->build('pending_orders', $data);

        }else{
            redirect('signout');
        }
    }
    public function history_of_trades(){
        $this->lang->load('historyoftrades');
        if($this->session->userdata('logged')){
            //if( // $_SESSION['user_id']==356895 || $_SESSION['account_number']=='58027933' ||
             //   $_SERVER['REMOTE_ADDR']=='49.12.5.139') {
                $this->NewGetHistoryTrades();
           /* }else {
                $data['title_page'] = lang('sb_li_0');
                $data['active_tab'] = 'trading';
                $data['active_sub_tab'] = 'history-of-trades';
                $data['metadata_description'] = lang('hot_dsc');
                $data['metadata_keyword'] = lang('hot_kew');
                $this->template->title(lang('hot_tit'))
                    ->append_metadata_css("
                       <link rel='stylesheet' href='" . $this->template->Css() . "dataTables.bootstrap2.css'>
                       <link rel='stylesheet' href='" . $this->template->Css() . "loaders.css'>
                       <link rel='stylesheet' href='" . $this->template->Css() . "bootstrap-datetimepicker.css'>
                 ")
                    ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};

                          </script>
                       <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                       <script src='" . $this->template->Js() . "Moment.js'></script>
                       <script src='" . $this->template->Js() . "bootstrap-datetimepicker.min.js'></script>
                       <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                 ")
                    ->set_layout('internal/main')
                    ->build('history_of_trades', $data);
            }*/
        }else{
            redirect('signout');
        }
    }
    public function HistoryOfTrades(){

        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $data['from'] = DateTime::createFromFormat('Y/d/m', $this->input->post('from',true));
        $data['none'] = DateTime::createFromFormat('Y/d/m', date('2015/5/5'));
        $data['to'] = DateTime::createFromFormat('Y/d/m H:i:s', $this->input->post('to',true).' 23:59:59');

        $data['mtas'] = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
        $data['data']['accountnumber']=$data['mtas']['account_number'];
        $account_info = array(
            'iLogin' => $data['mtas']['account_number'],
            // 'iLogin' =>'101491',
            'from' => $this->input->post('from',true) !=''? $data['from']->format('Y-m-d\TH:i:s'):Null ,
            'to' => $this->input->post('to',true) !=''?$data['to']->format('Y-m-d\TH:i:s'):Null
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->open_GetAccountTradesHistory($account_info);
        switch($WebService->request_status){
            case 'RET_OK':
                $tradatalist = (array) $WebService->get_result('TradeDataList');
                if($tradatalist){
                    $closed='';
                    foreach ( $tradatalist['TradeData'] as $object){

                        if (floatval($object->Volume)!=0 ){
                            $data['volume']=(floatval($object->Volume)/100);
                        }else{
                            $data['volume']=floatval($object->Volume);
                        }


                        $clDetails='Details';

                        $cTic="'$object->OrderTicket'";
                        $cTrd="'$object->TradeType'";
                        $cVol="'$data[volume]'";
                        $cSym="'$object->Symbol'";

                        $openPrc=number_format((float)$object->OpenPrice, $object->Digits, '.', '');
                        $StopLoss=number_format((float)$object->StopLoss, $object->Digits, '.', '');
                        $TakeProfit=number_format((float)$object->TakeProfit, $object->Digits, '.', '');
                        $ClosePrice=number_format((float)$object->ClosePrice, $object->Digits, '.', '');

                        $OpPrc="'$openPrc'";
                        $stLos="'$StopLoss'";
                        $tkPrf="'$TakeProfit'";
                        $clPrc="'$ClosePrice'";
                        $swps="'N/A'";
                        $prf="'$object->Profit'";



                        $closed.='<tr onclick="mobDetailsCloseTrades('.$cTic.','.$cTrd.','.$cVol.','.$cSym.','.$OpPrc.','.$stLos.','.$tkPrf.','.$clPrc.','.$swps.','.$prf.')">';
                        $closed.='<td>'.$object->OrderTicket.'</td>';
                        $closed.='<td>'.$object->TradeType.'</td>';
                        $closed.='<td>'. $data['volume'].'</td>';
                        $closed.='<td class="crTradesMob">'.$object->Symbol.'</td>';
                        $closed.='<td class="crTradesMob">'.number_format((float)$object->OpenPrice, $object->Digits, '.', '') .'</td>';
                        $closed.='<td class="crTradesMob">'.number_format((float)$object->StopLoss, $object->Digits, '.', '') .'</td>';
                        $closed.='<td class="crTradesMob">'.number_format((float)$object->TakeProfit, $object->Digits, '.', '') .'</td>';
                        $closed.='<td class="crTradesMob">'.number_format((float)$object->ClosePrice, $object->Digits, '.', '') .'</td>';
                        $closed.='<td class="crTradesMob">N/A</td>';
                        $closed.='<td class="crTradesMob">'.$object->Profit.'</td>';
                        $closed.='<td class="crTradesWeb crTradesWebStyle">'.$clDetails.'</td>';

                        $closed.='</tr>';
                    }
                    $data['data']['CancelledPendingOrder']= '';
                    $data['data']['Closed']= $closed;
                }else{
                    $data['data']['CancelledPendingOrder']= '';
                    $data['data']['Closed']= '';
                }
                break;
            default:
                $data['data']['error']=true;
        }
        $account_info2 = array(
            'iLogin' => $data['mtas']['account_number'],
            'from' => $this->input->post('from',true) !=''? $data['from']->format('Y-m-d\TH:i:s'):$data['none']->format('Y-m-d\TH:i:s') ,
            'to' => $this->input->post('to',true) !=''?$data['to']->format('Y-m-d\TH:i:s'):$data['none']->format('Y-m-d\TH:i:s')
        );
        $WebServiceBalOpe = new WebService($webservice_config);
        $WebServiceBalOpe->open_RequestAccountFinanceRecordsByDate($account_info2);

        switch($WebServiceBalOpe->request_status){
            case 'RET_OK':
                $tradatalist = (array) $WebServiceBalOpe->get_result('FinanceRecords');

                if($tradatalist){
                    $holder1='';
                    $holder2='';
                    $holder3='';
                    $holder4='';
                    $data['data']['bonus']=false;
                    $data['data']['deposit']=false;
                    $data['data']['withdraw']=false;
                    $data['data']['transfer']=false;
                    foreach ( $tradatalist['FinanceRecordData'] as $object){

                        if ($object->FundType=='BONUS'){
                            $data['data']['bonus']=true;


                            $boTic="'$object->Ticket'";
                            $boType="'$object->FundType'";
                            $boAmnt="'$object->Amount'";
                            $boSts="'$object->Status'";
                            $boStmp="'$object->Stamp'";
                            $boOpertn="'$object->Operation'";
                            $boTable="'Bonus'";
                            $boDetails='Details';

                            $holder1.='<tr onclick="mobDetailsBalOperation('.$boTic.','.$boType.','.$boAmnt.','.$boSts.','.$boStmp.','.$boOpertn.','.$boTable.')">';
                            $holder1.='<td>'.$object->Ticket.'</td>';
                            $holder1.='<td class="crTradesMob">'.$object->FundType.'</td>';
                            $holder1.='<td>'.$object->Amount.'</td>';
                            $holder1.='<td class="crTradesMob" >'.$object->Status.'</td>';
                            $holder1.='<td class="crTradesMob" >'.$object->Stamp.'</td>';
                            $holder1.='<td class="crTradesMob" >'.$object->Operation.'</td>';
                            $holder1.='<td class="crTradesWeb crTradesWebStyle">'.$boDetails.'</td>';

                            $holder1.='</tr>';
                        }
                        if ($object->Operation=='REAL_FUND_DEPOSIT'){
                            $data['data']['deposit']=true;

                            $deTic="'$object->Ticket'";
                            $deType="'$object->FundType'";
                            $deAmnt="'$object->Amount'";
                            $deSts="'$object->Status'";
                            $deStmp="'$object->Stamp'";
                            $deOpertn="'$object->Operation'";
                            $deTable="'Deposit'";
                            $deDetails='Details';

                            $holder2.='<tr onclick="mobDetailsBalOperation('.$deTic.','.$deType.','.$deAmnt.','.$deSts.','.$deStmp.','.$deOpertn.','.$deTable.')">';
                            $holder2.='<td>'.$object->Ticket.'</td>';
                            $holder2.='<td class="crTradesMob">'.$object->FundType.'</td>';
                            $holder2.='<td>'.$object->Amount.'</td>';
                            $holder2.='<td class="crTradesMob">'.$object->Status.'</td>';
                            $holder2.='<td class="crTradesMob">'.$object->Stamp.'</td>';
                            $holder2.='<td class="crTradesMob">'.$object->Operation.'</td>';
                            $holder2.='<td class="crTradesWeb crTradesWebStyle">'.$deDetails.'</td>';

                            $holder2.='</tr>';
                        }
                        if ($object->Operation=='REAL_FUND_WITHDRAW'){
                            $data['data']['withdraw']=true;

                            $wtTic="'$object->Ticket'";
                            $wtType="'$object->FundType'";
                            $wtAmnt="'$object->Amount'";
                            $wtSts="'$object->Status'";
                            $wtStmp="'$object->Stamp'";
                            $wtOpertn="'$object->Operation'";
                            $wtTable="'Withdraw'";
                            $wtDetails='Details';

                            $holder3.='<tr onclick="mobDetailsBalOperation('.$wtTic.','.$wtType.','.$wtAmnt.','.$wtSts.','.$wtStmp.','.$wtOpertn.','.$wtTable.')">';
                            $holder3.='<td>'.$object->Ticket.'</td>';
                            $holder3.='<td class="crTradesMob">'.$object->FundType.'</td>';
                            $holder3.='<td>'.$object->Amount.'</td>';
                            $holder3.='<td class="crTradesMob">'.$object->Status.'</td>';
                            $holder3.='<td class="crTradesMob">'.$object->Stamp.'</td>';
                            $holder3.='<td class="crTradesMob">'.$object->Operation.'</td>';
                            $holder3.='<td class="crTradesWeb crTradesWebStyle">'.$wtDetails.'</td>';
                            $holder3.='</tr>';

                        }
                        if ($object->Operation=='REAL_FUND_TRANSFER'){
                            $data['data']['transfer']=true;

                            $tnsTic="'$object->Ticket'";
                            $tnsType="'$object->FundType'";
                            $tnsAmnt="'$object->Amount'";
                            $tnsSts="'$object->Status'";
                            $tnsStmp="'$object->Stamp'";
                            $tnsOpertn="'$object->Operation'";
                            $tnsTable="'Transfer'";
                            $tnsDetails='Details';

                            $holder4.='<tr onclick="mobDetailsBalOperation('.$tnsTic.','.$tnsType.','.$tnsAmnt.','.$tnsSts.','.$tnsStmp.','.$tnsOpertn.','.$tnsTable.')">';
                            $holder4.='<td>'.$object->Ticket.'</td>';
                            $holder4.='<td class="crTradesMob">'.$object->FundType.'</td>';
                            $holder4.='<td>'.$object->Amount.'</td>';
                            $holder4.='<td class="crTradesMob">'.$object->Status.'</td>';
                            $holder4.='<td class="crTradesMob">'.$object->Stamp.'</td>';
                            $holder4.='<td class="crTradesMob">'.$object->Operation.'</td>';
                            $holder4.='<td class="crTradesWeb crTradesWebStyle">'.$tnsDetails.'</td>';
                            $holder4.='</tr>';
                        }
                    }
                    $data['data']['BalOpe_bonus'] = $holder1;
                    $data['data']['BalOpe_deposit'] = $holder2;
                    $data['data']['BalOpe_withdraw'] = $holder3;
                    $data['data']['BalOpe_transfer'] = $holder4;
                }else{
                    $data['data']['BalOpe_bonus'] = '';
                    $data['data']['BalOpe_deposit'] = '';
                    $data['data']['BalOpe_withdraw'] = '';
                    $data['data']['BalOpe_transfer'] = '';
                }
                break;
            default:
                $data['data']['error2']=true;
                $data['data']['bonus']=false;
                $data['data']['deposit']=false;
                $data['data']['withdraw']=false;
                $data['data']['transfer']=false;
        }

        echo json_encode($data['data']);
        unset($data);

    }
    public function CancelledPendingOrders(){

        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $data['from'] = DateTime::createFromFormat('Y/d/m', $this->input->post('from',true));
        $data['none'] = DateTime::createFromFormat('Y/d/m', date('2015/5/5'));
        $data['to'] = DateTime::createFromFormat('Y/d/m H:i:s', $this->input->post('to',true).' 23:59:59');

        $data['mtas'] = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
        $data['data']['accountnumber']=$data['mtas']['account_number'];
        $account_info = array(
            'iLogin' => $data['mtas']['account_number'],
            //'iLogin' =>'101926',
            'from' => $this->input->post('from',true) !=''? $data['from']->format('Y-m-d\TH:i:s'):Null ,
            'to' => $this->input->post('to',true) !=''?$data['to']->format('Y-m-d\TH:i:s'):Null
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAccountCancelledPendingOrders($account_info);
        switch($WebService->request_status){
            case 'RET_OK':
                $tradatalist = (array) $WebService->get_result('TradeDataList');
                if($tradatalist){
                    $closed='';
                    foreach ( $tradatalist['TradeData'] as $object){

                        if (floatval($object->Volume)!=0 ){
                            $data['volume']=(floatval($object->Volume)/100);
                        }else{
                            $data['volume']=floatval($object->Volume);
                        }


                        $closed.='<tr>';
                        $closed.='<td>'.$object->OrderTicket.'</td>';
                        $closed.='<td>'.$object->TradeType.'</td>';
                        $closed.='<td>'.number_format((float) $data['volume'],2).'</td>';
                        $closed.='<td>'.$object->Symbol.'</td>';
                        $closed.='<td>'.number_format((float)$object->OpenPrice, $object->Digits, '.', '') .'</td>';
                        $closed.='<td>'.number_format((float)$object->StopLoss, $object->Digits, '.', '') .'</td>';
                        $closed.='<td>'.number_format((float)$object->TakeProfit, $object->Digits, '.', '') .'</td>';
                        $closed.='<td>'.number_format((float)$object->ClosePrice, $object->Digits, '.', '') .'</td>';
                        $closed.='<td>N/A</td>';
                        $closed.='<td>'.number_format((float) $object->Profit,5).'</td>';
                        $closed.='</tr>';
                    }
                    $data['data']['CancelledPendingOrder']= '';
                    $data['data']['Closed']= $closed;
                }else{
                    $data['data']['CancelledPendingOrder']= '';
                    $data['data']['Closed']= '';
                }
                break;
            default:
                $data['data']['error']=true;
        }


        echo json_encode($data['data']);
        unset($data);

    }

    /*NEW API FXPP-11977 , FXPP-11978 , FXPP-11979*/

    public function NewGetOpenTrades(){
       // $this->lang->load('currenttrades');
        //if( //$_SESSION['user_id']==356895 || $_SESSION['account_number']=='58027933' ||
          //  $_SERVER['REMOTE_ADDR']=='49.12.5.139') {
            if($this->session->userdata('logged')){

                $paymentData = $this->session->userdata('goToPayment');
                //if(IPLoc::Office()){
                    if($paymentData){
                        if($paymentData == 'card'){
                            redirect(FXPP::my_url('deposit'));
                        } else {
                            redirect(FXPP::my_url('deposit/'.$paymentData));
                        }

                    } 


                //}

                $data['title_page'] = lang('sb_li_0');
                $data['active_tab'] = 'trading';
                $data['active_sub_tab'] = 'current-trades';
                $data['active_sub_sub_tab'] = 'current_trades';

                $data['metadata_description'] = lang('curtra_dsc');
                $data['metadata_keyword'] = lang('curtra_kew');
                $this->template->title("ForexMart | Current Trades")
                    ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                 ")
                    ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                            var recordType='".$data['active_sub_tab']."',
                                base_url ='".base_url()."';
                          </script>
                       <script src='".$this->template->Js()."new_trades.js'></script>
                 ")
                    ->set_layout('internal/main')
                    ->build('new_history_of_trades',$data);
            }else{
                redirect('signout');
            }

       // }
    }
    public function NewGetHistoryTrades(){
      ///  if( //$_SESSION['user_id']==356895 || $_SESSION['account_number']=='58027933' ||
          //  $_SERVER['REMOTE_ADDR']=='49.12.5.139') {
            if($this->session->userdata('logged')){

                $data['active_tab'] = 'trading';
                $data['active_sub_tab'] = 'history-of-trades';
                $data['metadata_description'] = 'Review all closed and cancelled deals for a specific time period.';
                $this->template->title("ForexMart | History of Trades")
                    ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                 ")
                    ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                            var recordType='".$data['active_sub_tab']."',
                                base_url ='".base_url()."',
                                re_ip='".$_SERVER["REMOTE_ADDR"]."',
                                dta_tbl_07='".lang('dta_tbl_07')."',
                                dta_tbl_02='".lang('dta_tbl_02')."',
                                dta_tbl_01='".lang('dta_tbl_01')."',
                                dta_tbl_14='".lang('dta_tbl_14')."',
                                dta_tbl_15='".lang('dta_tbl_15')."';
                          </script>
                       <script src='".$this->template->Js()."new_trades.js'></script>
                       <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                       <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                 ")
                    ->set_layout('internal/main')
                    ->build('new_history_of_trades',$data);
            }else{
                redirect('signout');
            }

        //}
    }
    public function getTrades(){
        if ($this->input->is_ajax_request()) {
            ini_set("soap.wsdl_cache_enabled", "0");
//            $this->load->library('SVC');

			$data = array();
            $this->load->library('WSV');
            $tradeType = $_POST['recType'];
            $rowPerPage = 10;
            $hasError = false;
            $errorMsg = "";
            $page = ($_POST['page'] != 0) ? ( ($_POST['page'] - 1) * $rowPerPage ) : $_POST['page'];
            $WSV = new WSV();
            $args = array(
                'AccountNumber' => $_SESSION['account_number'],
                'isCPA' => $this->isCPA,
                'Limit' => $rowPerPage,
                'Offset' => $page,
                'recType' => $tradeType,
            );

            if($_POST['recType']=='commission'){
                $dateFr = $_POST['from'];
                $dateT = $_POST['to'];
                $dateFrom = FXPP::unixTime($dateFr.' 00:00:00');
                $dateTo =  FXPP::unixTime($dateT.' 23:59:59');
                $args['From'] = $dateFrom;
                $args['To'] = $dateTo;
                $rowPerPage = $_POST['rowNum'];
                $args['Limit'] = $rowPerPage;
                $page = ($_POST['page'] != 0) ? ( ($_POST['page'] - 1) * $rowPerPage ) : $_POST['page'];
                $args['Offset'] =$page;
            }

            if($tradeType=='history-of-trades'){
                $x = ( $WSV->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $WSV->GetTradeHistory($args)['Data']: $WSV->GetTradeHistory($args) ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                $hasError = ( $WSV->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetTradeHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;

            }else if($tradeType=='current-trades'){
                $x = ( $WSV->GetOpenTrades($args)['ErrorMessage']=='RET_OK') ? $WSV->GetOpenTrades($args)['Data']: array() ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                $hasError = ( $WSV->GetOpenTrades($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetTradeHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;

            }else if( in_array($tradeType,array('balance-operations', 'transaction-history','pending-transactions') ) ){
                $x = ( $WSV->GetFinanceOpHistoryV2($args)['ErrorMessage']=='RET_OK') ? $WSV->GetFinanceOpHistoryV2($args)['Data']: array() ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                if($tradeType=='pending-transactions'){  $args['Limit'] = $res['count']; }
                $y = ( $WSV->GetFinanceOpHistoryV2($args)['ErrorMessage']=='RET_OK') ? $WSV->GetFinanceOpHistoryV2($args)['Data']: array() ;
                $res['record'] = isset($y->Transactions) ? $y->Transactions : '';
                $hasError = ( $WSV->GetFinanceOpHistoryV2($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetFinanceOpHistoryV2($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
            }else if($tradeType=='commission'){
                $args['AccountNumber'] = 0;
                $x = ( $WSV->GetCommissionHistory($args)['ErrorMessage']=='RET_OK') ? $WSV->GetCommissionHistory($args)['Data']: $WSV->GetCommissionHistory($args) ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                $hasError = ( $WSV->GetCommissionHistory($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetCommissionHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
                $dataResult['totalCom'] = isset($x->TotalFromRange) ? $x->TotalFromRange : 0;
//                if($_SESSION['account_number']=='58027933' && $_SERVER['REMOTE_ADDR']=='49.12.5.139'){
//                        echo "<pre>";
//                        print_r($x);
//                        print_r($args); die();
//                    }

            }else{
                $x = ( $WSV->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $WSV->GetTradeHistory($args)['Data']: array() ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                $hasError = ( $WSV->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetTradeHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
            }


            $result = $this->populate($res, $args);
            $dataResult['result'] = $result;
            $dataResult['hasError'] = $hasError;
            $dataResult['errorMsg'] = $errorMsg;
            $this->output->set_content_type('application/json')
                ->set_output(json_encode( $dataResult ));
        }
    }

    public function getHistoryTradeRecord(){

        if ($this->input->is_ajax_request()) {

            ini_set("soap.wsdl_cache_enabled", "0");

            $this->load->library('WSV');
			$data = array();
            $tradeType = $_POST['recordType'];
            $rowPerPage = $_POST['length'];
            $hasError = false;
            $errorMsg = "";
            $page = is_numeric($_POST['page']) ? $_POST['page'] : 1;
            $WSV = new WSV();
            $args = array(
                'AccountNumber' => $_SESSION['account_number'],
                'isCPA' => $this->isCPA,
                'Limit' => $rowPerPage,
                'Offset' => $_POST['start'],
                'recType' => 'history-of-trades',
            );

            if($_POST['recType']=='commission'){
                $dateFr = $_POST['from'];
                $dateT = $_POST['to'];
                $dateFrom = FXPP::unixTime($dateFr.' 00:00:00');
                $dateTo =  FXPP::unixTime($dateT.' 23:59:59');
                $args['From'] = $dateFrom;
                $args['To'] = $dateTo;
                $rowPerPage = $_POST['length'];
                $args['Limit'] = $rowPerPage;
                $page = ($_POST['page'] != 0) ? ( ($_POST['page'] - 1) * $rowPerPage ) : $_POST['page'];
                $args['Offset'] = $_POST['length'];
            }
//            if($_POST['recType']=='transaction-history'){
//
//
//                $dateFr = $_POST['from'];
//                $dateT = $_POST['to'];
//                $dateFrom = FXPP::unixTime($dateFr.' 00:00:00');
//                $dateTo =  FXPP::unixTime($dateT.' 23:59:59');
//                $args['From'] = $dateFrom;
//                $args['To'] = $dateTo;
//
//
//
//            }

            if($_POST['recType']=='history-of-trades'){
                $dateFr = $_POST['from'];
                $dateT = $_POST['to'];
                $dateFrom = FXPP::unixTime($dateFr.' 00:00:00');
                $dateTo =  FXPP::unixTime($dateT.' 23:59:59');
                $args['From'] = $dateFrom;
                $args['To'] = $dateTo;
            }

            if($tradeType=='history-of-trades'){
                $x = ( $WSV->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $WSV->GetTradeHistory($args)['Data']: $WSV->GetTradeHistory($args) ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                $hasError = ( $WSV->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetTradeHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
              
                

            }else if($tradeType=='current-trades'){

                $x = ( $WSV->GetOpenTrades($args)['ErrorMessage']=='RET_OK') ? $WSV->GetOpenTrades($args)['Data']: array() ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                $hasError = ( $WSV->GetOpenTrades($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetTradeHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;

            }else if( in_array($tradeType,array('balance-operations', 'transaction-history','pending-transactions') ) ){
                $x = ( $WSV->GetFinanceOpHistoryV2($args)['ErrorMessage']=='RET_OK') ? $WSV->GetFinanceOpHistoryV2($args)['Data']: array() ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                if($tradeType=='pending-transactions'){  $args['Limit'] = $res['count']; }
                $y = ( $WSV->GetFinanceOpHistoryV2($args)['ErrorMessage']=='RET_OK') ? $WSV->GetFinanceOpHistoryV2($args)['Data']: array() ;
                $res['record'] = isset($y->Transactions) ? $y->Transactions : '';
                $hasError = ( $WSV->GetFinanceOpHistoryV2($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetFinanceOpHistoryV2($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
            }else if($tradeType=='commission'){
                $args['AccountNumber'] = 0;
                $x = ( $WSV->GetCommissionHistory($args)['ErrorMessage']=='RET_OK') ? $WSV->GetCommissionHistory($args)['Data']: $WSV->GetCommissionHistory($args) ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                $hasError = ( $WSV->GetCommissionHistory($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetCommissionHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
                $dataResult['totalCom'] = isset($x->TotalFromRange) ? $x->TotalFromRange : 0;

            }else{
                $x = ( $WSV->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $WSV->GetTradeHistory($args)['Data']: array() ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                $hasError = ( $WSV->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetTradeHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
            }


            //  $result = $this->populate($res, $args);
            $type = $tradeType;
            $records = $res['record'];
            $rowNum = $args['Offset'];
            $count = isset( $res['count'] )?  $res['count']: 0;

            $tbl = '';
            $ctr = intval($rowNum) + 1;

            if($type=='commission'){
                if($count>1){
                    foreach ($records->TradeRecord as $a){
                        $tempArray = array(
                            'DT_RowId' => $ctr,
                            $ctr,
                            gmdate("Y-m-d H:i:s", $a->CloseTime),
                            $a->CommissionAgent,
                            $a->Login,
                            $a->Symbol,
                            $a->Order,
                        );
                        $ctr++;

                    }
                }
            }else if($type=='current-trades'){

                if($count>1){
                    foreach ($records->TradeRecord as $a){

                        //$data['volume'] = (floatval($a->Volume)!=0 )?(floatval($a->Volume)/100) : floatval($a->Volume);

                        if(IPLoc::VPN_IP_Jenalie()){
                            $tempArray = array(
                                'DT_RowId' => $ctr,
                                $ctr,
                                $a->Order,
                                $this->getTradeType($a->Cmd),
                                number_format(($a->Volume),2),
                                $a->Symbol,
                                $a->OpenPrice,
                                $a->ClosePrice,
                                gmdate("Y-m-d H:i:s", $a->OpenTime),
                                gmdate("Y-m-d H:i:s", $a->CloseTime),
                                $a->Sl,
                                $a->Tp,
                                $a->Swaps,
                                $a->Profit,
                            );
                        }else{
                            $tempArray = array(
                                'DT_RowId' => $ctr,
                                $ctr,
                                $a->Order,
                                $this->getTradeType($a->Cmd),
                                number_format(($a->Volume),2),
                                $a->Symbol,
                                $a->OpenPrice,
                                $a->ClosePrice,
                                gmdate("Y-m-d H:i:s", $a->OpenTime),
                                gmdate("Y-m-d H:i:s", $a->CloseTime),
                                $a->Sl,
                                $a->Tp,
                                $a->Profit,
                            );
                        }

                        $ctr++;
                    }
                }

            }else if($type=='history-of-trades'){

                if($count>1){
                    foreach ($records->TradeRecord as $a){

                        //$volume = (floatval($a->Volume)!=0 )?(floatval($a->Volume)/100) : floatval($a->Volume);

                        if(IPLoc::VPN_IP_Jenalie()){
                            $tempArray = array(
                                'DT_RowId' => $ctr,
                                $ctr,
                                $a->Order,
                                $this->getTradeType($a->Cmd),
                                number_format(($a->Volume),2),
                                $a->Symbol,
                                $a->OpenPrice,
                                $a->ClosePrice,
                                gmdate("Y-m-d H:i:s", $a->OpenTime),
                                gmdate("Y-m-d H:i:s", $a->CloseTime),
                                $a->Sl,
                                $a->Tp,
                                $a->Swaps,
                                $a->Profit,
                            );
                        }else{
                            $tempArray = array(
                                'DT_RowId' => $ctr,
                                $ctr,
                                $a->Order,
                                $this->getTradeType($a->Cmd),
                                number_format(($a->Volume),2),
                                $a->Symbol,
                                $a->OpenPrice,
                                $a->ClosePrice,
                                gmdate("Y-m-d H:i:s", $a->OpenTime),
                                gmdate("Y-m-d H:i:s", $a->CloseTime),
                                $a->Sl,
                                $a->Tp,
                                $a->Profit,
                            );
                        }

                        $data[] = $tempArray;

                        $ctr++;
                    }
                }

            }else {
                if ($count > 1) {
                    $pendingTrans = 0;
                    foreach ($records->FinanceOpData as $a) {
                        $d = $this->getFundStatusPerOperationType($a->OperationTypeId);
                        $dt = $this->getBalOpsDetails($a);
                        if($type=='balance-operations'){
                            $tempArray = array(
                                'DT_RowId' => $ctr,
                                $ctr,
                                $a->Ticket,
                                $d['FundType'],
                                $d['TransType'],
                                $a->Amount,
                                $d['Status'],
                                gmdate("Y-m-d H:i:s", $a->ProcessTime),
                                $d['Description'],
                            );
                        }else if($type=='transaction-history'){
                            $tempArray = array(
                                'DT_RowId' => $ctr,
                                $ctr,
                                $d['FundType'],
                                $d['Status'],
                                $d['TransType'],
                                $a->Amount,
                                gmdate("Y-m-d H:i:s", $a->ProcessTime),
                                "<button id='btn-view-" . $a->Ticket . "' data-info='".$dt."' class='btn-view-trans-details' type='button'>View Details</button>",
                            );
                            $data[] = $tempArray;

                        }else if($type=='history-of-trades'){
                            $tempArray = array(
                                'DT_RowId' => 1,
                                $ctr,
                                $d['FundType'],
                                $d['Status'],
                                $d['TransType'],
                                $a->Amount,
                                gmdate("Y-m-d H:i:s", $a->ProcessTime),
                                "<button id='btn-view-" . $a->Ticket . "' data-info='".$dt."' class='btn-view-trans-details' type='button'>View Details</button>",
                            );
                            $data[] = $tempArray;

                        }else if($type=='pending-transactions'){



                            if($a->OperationTypeId == "WITHDRAW_REAL_FUND"){


                                //FXPP-12929
                                if($this->checkPendingTranSection($a->Ticket,$a->Comment))
                                {
                                    $tempArray = array(
                                        'DT_RowId' => $ctr,
                                        $ctr,
                                        $d['FundType'],
                                        $d['Status'],
                                        $d['TransType'],
                                        $a->Amount,
                                        gmdate("Y-m-d H:i:s", $a->ProcessTime),
                                        "<button id='btn-view-" . $a->Ticket . "' data-info='".$dt."' class='btn-view-trans-details' type='button'>View Details</button>",
                                    );
                                    $pendingTrans++;
                                }

                            }
                        }

                        $ctr++;
                    }


                    if($type=='pending-transactions'){
                        return $res = array('tbl'=> ($pendingTrans>0)?$tbl:'<tr><td colspan="7">'.lang('dta_tbl_01').'</td></tr>' , 'countPending'=> $pendingTrans);
                    }

                }
            }

            $result = array(
                'draw' => (int)$this->input->post('draw',true),
                'recordsTotal' => (int)$res['count'],
                'recordsFiltered' => (int)$res['count'],
                'data' => $data
            );

            echo json_encode($result);
        }
    }
    public function populate($data,$raw){


        $this->load->library('pagination');
        $rowPerPage = $raw['Limit'];
        $rowNum = $raw['Offset'];
        $data1['count'] = isset( $data['count'] )?  $data['count']: 0;

        $config['base_url'] = base_url().'get-trades';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $data1['count'] ;
        $config['page'] = $rowNum;
        $config['per_page'] = $rowPerPage;
        $config['use_page_numbers'] = TRUE;
        $config['first_link']       = 'first';
        $config['prev_link']        = 'prev';
        $config['last_link']        = 'last';
        $config['next_link']        = 'next';
        $config['full_tag_open']    = '<ul class="tab-pagination pagination pagination-md">';
        $config['full_tag_close']   = '</ul>';
        $config['first_tag_open']   = '<li class="latest-page">';
        $config['prev_tag_open']    = '<li class="latest-page">';
        $config['last_tag_open']    = '<li class="latest-page">';
        $config['next_tag_open']    = '<li class="latest-page paginate-next">';
        $config['first_tag_close']  = '</li>';
        $config['prev_tag_close']   = '</li>';
        $config['last_tag_close']   = '</li>';
        $config['next_tag_close']   = '</li>';
        $config['cur_tag_open']     = '<li class="latest-page active"><a id="curPage" class="first" data-ci-pagination-page="1">';
        $config['cur_tag_close']    = '</a></li>';
        $config['num_tag_open']     = '<li class="latest-page">';
        $config['num_tag_close']    = '</li>';
        $config['num_links'] = 20;

        $this->pagination->initialize($config);
        $data1['pagination'] = $this->pagination->create_links();
        $data1['result'] =  $this->formatRaw($data['record'] , $rowNum, $raw['recType'], $data1['count']) ;

        if($raw['recType']=='pending-transactions'){
            $data1['result'] = $data1['result']['tbl'];
            $data1['count'] = $data1['result']['countPending'];
        }

        $c = (intval($rowNum) + 1);
        $t =  ($rowNum+$rowPerPage) ;
        $t = ($t>=intval($data1['count']) )? $data1['count']: $t;
        $data1['showing'] = "Showing ".$c." to ".($t)." of ".$data1['count']." entries";
        $data1['row'] = $rowNum;
        $data1['rowPerPage'] = $data['rowPerPage'];

        return $data1;
    }
    public function formatRaw($records, $rowNum, $type, $count){
        $tbl = '';
        $ctr = intval($rowNum) + 1;
        if($type=='commission'){
            if($count>1){
                foreach ($records->TradeRecord as $a){

                    $tbl .= "<tr>";
                    $tbl .= "<td>".$ctr."</td>";
                    $tbl .= "<td>".gmdate("Y-m-d H:i:s", $a->CloseTime)."</td>";
                    $tbl .= "<td>".$a->CommissionAgent."</td>";
                    $tbl .= "<td>".$a->Login."</td>";
                    $tbl .= "<td>".$a->Symbol."</td>";
                    $tbl .= "<td>".$a->Order."</td>";
                    $tbl .= "</tr>";
                    $ctr++;
                }
            }else{
                $tbl .= '<tr><td colspan="6">No data available.</td></tr>';
            }
        }else if($type=='current-trades' || $type=='history-of-trades'){

            if($count>1){
                foreach ($records->TradeRecord as $a){

                    $data['volume'] = (floatval($a->Volume)!=0 )?(floatval($a->Volume)/100) : floatval($a->Volume);

                    $tbl .= "<tr>";
                    $tbl .= "<td>".$ctr."</td>";
                    $tbl .= "<td>".$a->Order."</td>";
                    $tbl .= "<td>".$this->getTradeType($a->Cmd)."</td>";
                    $tbl .= "<td>".$data['volume']."</td>";
                    $tbl .= "<td>".$a->Symbol."</td>";
                    $tbl .= "<td>".$a->OpenPrice."</td>";
                    $tbl .= "<td>".$a->Sl."</td>";
                    $tbl .= "<td>".$a->Tp."</td>";
                    $tbl .= "<td>".$a->ClosePrice."</td>";
                    $tbl .= "<td>N/A</td>";
                    $tbl .= "<td>".$a->Profit."</td>";
                    $tbl .= "</tr>";
                    $ctr++;
                }
            }else{
                $tbl .= '<tr><td colspan="11">No data available.</td></tr>';
            }

        }else {

            if ($count > 1) {
                $pendingTrans = 0;
                foreach ($records->FinanceOpData as $a) {
                    $d = $this->getFundStatusPerOperationType($a->OperationTypeId);
                    $dt = $this->getBalOpsDetails($a);
                    if($type=='balance-operations'){
                        $tbl .= "<tr>";
                        $tbl .= "<td>" . $ctr . "</td>";
                        $tbl .= "<td>" . $a->Ticket . "</td>";
                        $tbl .= "<td>" . $d['FundType'] . "</td>";
                        $tbl .= "<td>" . $a->Amount . "</td>";
                        $tbl .= "<td>" . $d['Status'] . "</td>";
                        $tbl .= "<td>" . gmdate("Y-m-d H:i:s", $a->ProcessTime) . "</td>";
                        $tbl .= "<td>" . $d['Description'] . "</td>";
                        $tbl .= "</tr>";
                    }else if($type=='transaction-history'){
                        $tbl .= "<tr>";
                        $tbl .= "<td>" . $ctr . "</td>";
                        $tbl .= "<td>" . $d['FundType'] . "</td>";
                        $tbl .= "<td>" . $d['Status'] . "</td>";
                        $tbl .= "<td>" . $d['TransType'] . "</td>";
                        $tbl .= "<td>" . $a->Amount . "</td>";
                        $tbl .= "<td>" . gmdate("Y-m-d H:i:s", $a->ProcessTime) . "</td>";
                        $tbl .= "<td><button id='btn-view-" . $a->Ticket . "' data-info='".$dt."' class='btn-view-trans-details' type='button'>View Details</button></td>";
                        $tbl .= "</tr>";
                    }else if($type=='pending-transactions'){
                        if($a->OperationTypeId === 'WITHDRAW_REAL_FUND'){
                            $this->load->model('Withdraw_model');
                            $resultTransaction = $this->Withdraw_model->getWithdrawalTransactionByTicket($a->Ticket);
                            if ($resultTransaction) {
                                if ($resultTransaction['status'] == 0) {
                                    $tbl .= "<tr>";
                                    $tbl .= "<td>" . $ctr . "</td>";
                                    $tbl .= "<td>" . $d['FundType'] . "</td>";
                                    $tbl .= "<td>" . $d['Status'] . "</td>";
                                    $tbl .= "<td>" . $d['TransType'] . "</td>";
                                    $tbl .= "<td>" . $a->Amount . "</td>";
                                    $tbl .= "<td>" . gmdate("Y-m-d H:i:s", $a->ProcessTime) . "</td>";
                                    $tbl .= "<td><button id='btn-view-" . $a->Ticket . "' data-info='".$dt."' class='btn-view-trans-details' type='button'>View Details</button></td>";
                                    $tbl .= "</tr>";
                                    $pendingTrans++;
                                }
                            }
                        }
                    }

                    $ctr++;
                }
                if($type=='pending-transactions'){
                    return $res = array('tbl'=> ($pendingTrans>0)?$tbl:'<tr><td colspan="7">No data available.</td></tr>' , 'countPending'=> $pendingTrans);
                }
            } else {
                $col = ($type=='transaction-history')? 6:7;
                $tbl .= '<tr><td colspan="7">No data available.</td></tr>';
            }

        }
        return $tbl;
    }
    public function getFundStatusPerOperationType($OperationTypeId){
        $operationType = array(
            'BONUS_30PERCENT'       => array( 'desc'=> 'PERCENT BONUS',         'status' => 3 , 'fundType' => 2),
            'BONUS_NO_DEPOSIT'      => array( 'desc'=> 'NO DEPOSIT BONUS',      'status' => 3 , 'fundType' => 2),
            'DEPOSIT_REAL_FUND'     => array( 'desc'=> 'DEPOSIT REAL FUND',     'status' => 1 , 'fundType' => 1),
            'WITHDRAW_REAL_FUND'    => array( 'desc'=> 'WITHDRAW REAL FUND',    'status' => 1 , 'fundType' => 1),
            'TRANSFER_REAL_FUND'    => array( 'desc'=> 'FUND TRANSFER',         'status' => 1 , 'fundType' => 1),
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
            default: $tType = "Bonus"; break;
        }

        return array(
            'Description' =>  isset($operationType[$OperationTypeId]['desc']) ? $operationType[$OperationTypeId]['desc'] : 'N/A',
            'FundType' => $operationType[$OperationTypeId]['fundType']==1? 'REAL': 'BONUS',
            'Status' => isset($status[$operationType[$OperationTypeId]['status']]) ? $status[$operationType[$OperationTypeId]['status']] : "N/A",
            'TransType' => $tType,
        );
    }
    public function getTradeType($id){
        switch ($id){
            case 0: $type = 'BUY'; break;
            case 1: $type = 'SELL'; break;
            case 2: $type = 'BUY LIMIT'; break;
            case 3: $type = 'SELL LIMIT'; break;
            case 4: $type = 'BUY STOP'; break;
            case 5: $type = 'SELL STOP'; break;
            case 6: $type = 'BALANCE'; break;
            case 7: $type = 'CREDIT'; break;
            default : $type = 'BUY'; break;
        }
        RETURN $type;
    }
    public function getTraderPassword($accountNumber){
        $client = $this->General_model->showssingle('mt_accounts_set',$field="account_number",$id=$accountNumber,'*');
        $partner = $client ? $client['trader_password'] : $this->General_model->showssingle('partnership',$field="reference_num",$id=$accountNumber,'*')['trader_password'];

        return $pass = $partner ? $partner : 0;
    }
    public function getCommisionFromAllReferrals(){
        if( //$_SESSION['user_id']==356895 || $_SESSION['account_number']=='58027933' ||
            $_SERVER['REMOTE_ADDR']=='49.12.5.139') {
            if($this->session->userdata('logged')){
                $this->load->model('partners_model');
                $user_id = $this->session->userdata('user_id');

                if($this->isCPA){  redirect(FXPP::my_url('partnership/cpa'));     }


                $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
                $affiliate_code = ($sub_partner) ? $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']) : $this->partners_model->getAffiliateCodeById($user_id);


                $isReqforCode=$this->partners_model->isReqaffcode($user_id);
                $data['isReqforCode'] = $isReqforCode;

                $isApprovedRecCode=$this->partners_model->isApprovedReqCode($user_id);
                $data['isApprovedRecCode'] = $isApprovedRecCode;
                $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
                $data['isCPA'] = $this->isCPA;
                $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];



                $data['active_tab'] = 'partnership';
                $data['active_sub_tab'] = 'commission';
                $data['metadata_description'] = lang('com_dsc');
                $data['metadata_keyword'] = lang('com_kew');
                $this->template->title(lang('com_tit'))
                    ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                 ")
                    ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                            var recordType='".$data['active_sub_tab']."',
                                dtDay ='".date('Y-m-d',strtotime('now'))."',
                                dtWeek ='".date('Y-m-d',strtotime('-1 week'))."',
                                dtMonth ='".date('Y-m-d',strtotime('-1 month'))."',
                                base_url ='".base_url()."';
                          </script>
                       <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                       <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                 ")
                    ->set_layout('internal/main')
                    ->build('partnership/new_commission',$data);
            }else{
                redirect('signout');
            }
        }
    }
    public function getBalOpsDetails($a){
        $ticketArray = $this->getFinanceTxn();
        $withdrawalCommentsKey = array(
            'comment_w1' => 'withdrawal',
            'comment_w2' => 'w/d'
        );
        $d = $this->getFundStatusPerOperationType($a->OperationTypeId);
        $details = "<p>Ticket:".$a->Ticket."<br><br>Comment:".$a->Comment."<br></p>";
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
                                    Ticket:".$a->Ticket."<br><br>
                                    Comment:".$a->Comment."<br><br>
                                    Payment System:".$pSystem."<br>
                                    </p>";
                break;
            case 'Withdraw':
                $pSystem = isset($pSystem)? $pSystem : "N/A";
                $recall = isset($recall)? $recall : "";
                $stat = isset($stat)? $stat : "N/A";
                $comment = (!empty($a->Comment))? $comment : "N/A";
                $details = "<p>
                                    Ticket:".$a->Ticket."<br><br>
                                    Comment:".$comment."<br><br>
                                    Payment System:".$pSystem."<br><br>
                                    Status:".$stat."<br><br>
                                    Recall:".$recall."<br>
                                    </p>";
                break;
            case 'Transfer':
                $details = "<p>
                                    Ticket:".$a->Ticket."<br><br>
                                    Comment:".$a->Comment."<br><br>
                                    Transfer From:".$a->TransferAccountSender."<br><br>
                                    Transfer To:".$a->TransferAccountReceiver."<br>
                                    </p>";
                break;
            default:
                $details = $details;
                break;
        }
        return $details;
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
    public function getTp($tp){
        $transaction_type = array(
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
            'PAYOMA'=>'PAYOMA'
        );
        return $transaction_type[$tp];
    }

}
