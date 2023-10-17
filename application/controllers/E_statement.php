<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class E_statement extends MY_Controller
{
    private $js;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('account_model');
        $this->load->model('General_model');
        $this->load->model('Account_model');
        $this->g_m=$this->General_model;
        $this->user_id = $this->session->userdata('user_id');
        $this->js    = $this->template->Js();
        $this->load->library('Transaction');
    }

    public function index(){

        $this->load->library('IPLoc', null);
        if(!IPLoc::Office()){
            redirect('');
        }

        if($this->session->userdata('logged')) {

            $data['title_page'] = lang('sb_li_8');
            $data['active_tab'] = 'e-statement';
            $this->template->title(' ForexMart | E-statement ')
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                       <link rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 ")
                ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                          </script>
                       <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                       <script src='".$this->template->Js()."Moment.js'></script>
                       <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                       <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                 ")
                ->set_layout('internal/main')
                ->build('E_statement',$data);
        }
    }

    public function generate_epayments(){

        $getData = null;
        $pFrom = $this->input->post('from',true);
        $pTo = $this->input->post('to',true);
        $pFileType = $this->input->post('file_type',true);
        $pTransactionType = $this->input->post('transaction_type',true);

        $from = DateTime::createFromFormat('Y/m/d', date($pFrom));
        $to = DateTime::createFromFormat('Y/m/d', date($pTo));

        $mtAccountsSetData = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');

        $Transaction = new Transaction();
        $getAllTransactionData = $Transaction->getAllTransactionData($pTransactionType, $mtAccountsSetData['account_number'], $from->format('Y-m-d\TH:i:s'), $to->format('Y-m-d\TH:i:s'));

        switch($pFileType){
            case 'word':
                $this->word($getAllTransactionData);
                break;

            case 'pdf':
                $_SESSION['pdf-file'] = $getAllTransactionData;
                break;

            default:
                $this->excel($getAllTransactionData);
                break;
        }

        echo json_encode(true);

    }

    public function download_file(){

        header('Location:'.base_url().'assets/user_docs/'.$_SESSION['e-payments-file'].'');

    }

    public function excel($getAllTransactionData){
        $getAccountsByUserIdRow = $this->Account_model->getAccountsByUserIdRow($this->user_id);
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

        $filename = $getAccountsByUserIdRow['account_number'].'-'.strtotime('now').'.xlsx';
        $_SESSION['e-payments-file'] = $filename;

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $asset_user_docs=$this->config->item('asset_user_docs');
        
        $objWriter->save($asset_user_docs.$filename.'');
        ob_end_clean();
    }

    public function pdf(){
        $this->load->library('PDF_MC_Table');
        $pdf=new PDF_MC_Table();
        $pdf->AddPage();
        $pdf->SetFont('Arial','',12);
        $pdf->SetWidths(array(32,32,32,32,32,32));
        $header = array('Type', 'Transaction', 'Account', 'Amount', 'Pay System', 'Date');
        $pdf->Header($header);

        $realFundDeposit = $_SESSION['pdf-file'];

        foreach($realFundDeposit as $data){
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

    public function getTransactionsRecord($params){

        $getData = null;

        $transactionTypes = array(
            'REAL_FUND_DEPOSIT' => array(),
            'REAL_FUND_WITHDRAW' => array(),
            'REAL_FUND_TRANSFER' => array(),
            'BONUS_FUND_30PERCENT_DEPOSIT' => array(),
            'BONUS_FUND_NO_DEPOSIT' => array()
        );

        $from = DateTime::createFromFormat('Y/d/m', date($params['from']));
        $to = DateTime::createFromFormat('Y/d/m', date($params['to']));
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

    public function word($realFundDeposit){

        $getAccountsByUserIdRow = $this->Account_model->getAccountsByUserIdRow($this->user_id);

        $this->load->library('word');
        $section = $this->word->createSection(array('orientation'=>'landscape'));

        // Define table style arrays
        $styleTable = array('borderSize'=>6, 'borderColor'=>'006699', 'cellMargin'=>80);
        $styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF', 'align' => 'center');

        // Define cell style arrays
        $styleCell = array('valign'=>'center');
        $styleCellBTLR = array('valign'=>'center', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);

        // Define font style for first row
        $fontStyle = array('bold'=>true, 'align'=>'center');

        // Add table style
        $this->word->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);

        // Add table
        $table = $section->addTable('myOwnTableStyle');

        // Add row
        $table->addRow(500);

        // Add cells
        $table->addCell(1200, $styleCell)->addText('Type', $fontStyle, array('align' => 'center'));
        $table->addCell(2500, $styleCell)->addText('Transaction', $fontStyle, array('align' => 'center'));
        $table->addCell(1200, $styleCell)->addText('Account', $fontStyle, array('align' => 'center'));
        $table->addCell(1200, $styleCell)->addText('Amount', $fontStyle, array('align' => 'center'));
        $table->addCell(1500, $styleCell)->addText('Pay System', $fontStyle, array('align' => 'center'));
        $table->addCell(1500, $styleCell)->addText('Date', $fontStyle, array('align' => 'center'));

        if($realFundDeposit){
            $countTransaction = count($realFundDeposit);
            for($i = 0; $i <= $countTransaction; $i++) {
                $table->addRow();
                $convertStamp = date("Y-m-d H:i:s", strtotime($realFundDeposit[$i]['Stamp']));
                $table->addCell(1200)->addText($realFundDeposit[$i]['FundType'], '',array('align' => 'center'));
                $table->addCell(2500)->addText($realFundDeposit[$i]['Operation'], '', array('align' => 'center'));
                $table->addCell(1200)->addText($realFundDeposit[$i]['AccountNumber'], '', array('align' => 'center'));
                $table->addCell(1200)->addText(round($realFundDeposit[$i]['Amount'], 2), '',array('align' => 'center'));
                $table->addCell(1500)->addText('N/A', '', array('align' => 'center'));
                $table->addCell(1500)->addText($convertStamp, '', array('align' => 'center'));
            }
        }



        $filename = $getAccountsByUserIdRow['account_number'].'-'.strtotime('now').'.docx';
        $_SESSION['e-payments-file'] = $filename;

        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $objWriter = PHPWord_IOFactory::createWriter($this->word, 'Word2007');
        $asset_user_docs=$this->config->item('asset_user_docs');
        $objWriter->save($asset_user_docs.$filename.'');

        ob_end_clean();
    }
}