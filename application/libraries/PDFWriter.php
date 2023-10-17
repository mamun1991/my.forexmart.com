<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('fpdf/fpdf.php');
require_once('fpdf/fpdi.php');

class PDFWriter
{
    function generateBankTransferPDF( $file_path = false, $file_name = '', $info = array() ){
        
         if($file_path==false){
            $file_path = '/var/www/upload/user_docs/'; //'./assets/user_docs/';
        }
        
        
        $pdf = new FPDI();
// add a page
        $pdf->AddPage();
// set the source file
        $bank_SiauLiu = FALSE;
        if($info['bank_id'] == 3) {
            $pdf->setSourceFile("./assets/pdf/bank-transfer-form-for-sparkasse.pdf");
        }else if($info['bank_id'] == 2) {
            if($info['currency'] == 'EUR' || $info['currency'] == 'GBP' || $info['currency'] == 'USD'){
                $pdf->setSourceFile("./assets/pdf/bank-transfer-form-for-sparkasse.pdf");
                $bank_SiauLiu = TRUE;
            }else{
                $pdf->setSourceFile("./assets/pdf/bank-transfer-form.pdf");
            }
        }else{
            $pdf->setSourceFile("./assets/pdf/bank-transfer-form.pdf");
        }

// import page 1
        $tplIdx = $pdf->importPage(1);
// use the imported page and place it at point 10,10 with a width of 100 mm
        $pdf->useTemplate($tplIdx, 5, 5, 200);

// now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetFontSize(10);


            if($info['bank_id'] == 3 || $bank_SiauLiu) {
                if (array_key_exists('full_name', $info)) {
                    $pdf->SetXY(37, 65);
                    $pdf->Write(0, $info['full_name']);
                }
                if (array_key_exists('bank_name', $info)) {
                    $pdf->SetXY(37, 72);
                    $pdf->Write(0, $info['bank_name']);
                }
                if (array_key_exists('amount', $info)) {
                    $pdf->SetXY(33, 79);
                    $pdf->Write(0, number_format($info['amount'], 2));
                }
                if (array_key_exists('currency', $info)) {
                    $pdf->SetXY(36, 86);
                    $pdf->Write(0, strtoupper($info['currency']));
                }


                //ELECTRONIC WIRE FUND TRANSFER DETAILS

                if (array_key_exists('beneficiary_account_name', $info)) {
                    $pdf->SetXY(65.5, 119);
                    $pdf->Write(0, $info['beneficiary_account_name']);
                }
                if (array_key_exists('beneficiary_bank_name', $info)) {
                    $pdf->SetXY(59, 125.75);
                    $pdf->Write(0, $info['beneficiary_bank_name']);
                }
                $pdf->SetFontSize(9);
                if (array_key_exists('beneficiary_bank_address', $info)) {
                    $pdf->SetXY(44, 133);
                    $pdf->Write(0, $info['beneficiary_bank_address']);
                }
                $pdf->SetFontSize(10);
                if (array_key_exists('bank_iban', $info)) {
                    $pdf->SetXY(27, 140.4);
                    $pdf->Write(0, $info['bank_iban']);
                }
                if (array_key_exists('bank_account_number', $info)) {
                    $pdf->SetXY(50, 147.8);
                    $pdf->Write(0, $info['bank_account_number']);
                }
                if (array_key_exists('beneficiary_swift', $info)) {
                    $pdf->SetXY(34, 154.8);
                    $pdf->Write(0, $info['beneficiary_swift']);
                }
                if (array_key_exists('currency', $info)) {
                    $pdf->SetXY(36, 162.8);
                    $pdf->Write(0, strtoupper($info['currency']));
                }
                if (array_key_exists('comment', $info)) {
                    $pdf->SetXY(36, 169.5);
                    $pdf->Write(0, strtoupper($info['comment']));
                }

                if (array_key_exists('currency', $info)) {
                    $pdf->SetXY(153, 240);
                    $pdf->Write(0, date('m/d/Y', strtotime($info['date_now'])));
                }
                if (file_exists($file_path . $file_name)) {
                    unlink($file_path . $file_name);
                }

            } else {

                if( array_key_exists('full_name', $info) ){
                    $pdf->SetXY(36, 70);
                    $pdf->Write(0, $info['full_name']);
                }
                if( array_key_exists('bank_name', $info) ) {
                    $pdf->SetXY(38, 76.65);
                    $pdf->Write(0, $info['bank_name']);
                }
                if( array_key_exists('amount', $info) ) {
                    $pdf->SetXY(33, 83.3);
                    $pdf->Write(0, number_format($info['amount'],2));
                }
                if( array_key_exists('currency', $info) ) {
                    $pdf->SetXY(36, 89.95);
                    $pdf->Write(0, strtoupper($info['currency']));
                }

                //ELECTRONIC WIRE FUND TRANSFER DETAILS

                if( array_key_exists('beneficiary_account_name', $info) ) {
                    $pdf->SetXY(65.5, 121);
                    $pdf->Write(0, $info['beneficiary_account_name']);
                }
                if( array_key_exists('beneficiary_bank_name', $info) ) {
                    $pdf->SetXY(59, 127.75);
                    $pdf->Write(0, $info['beneficiary_bank_name']);
                }
                $pdf->SetFontSize(9);
                if( array_key_exists('beneficiary_bank_address', $info) ) {
                    $pdf->SetXY(44, 135);
                    $pdf->Write(0, $info['beneficiary_bank_address']);
                }
                $pdf->SetFontSize(10);
                if( array_key_exists('bank_iban', $info) ) {
                    $pdf->SetXY(27, 142.4);
                    $pdf->Write(0, $info['bank_iban']);
                }
                if( array_key_exists('bank_account_number', $info) ) {
                    $pdf->SetXY(50, 149.8);
                    $pdf->Write(0, $info['bank_account_number']);
                }
                if( array_key_exists('beneficiary_swift', $info) ) {
                    $pdf->SetXY(34, 157.8);
                    $pdf->Write(0, $info['beneficiary_swift']);
                }
                if( array_key_exists('currency', $info) ) {
                    $pdf->SetXY(35, 165.8);
                    $pdf->Write(0, strtoupper($info['currency']));
                }

                if (array_key_exists('currency', $info)) {
                    $pdf->SetXY(153, 240);
                    $pdf->Write(0, date('m/d/Y', strtotime($info['date_now'])));
                }
                if (file_exists($file_path . $file_name)) {
                    unlink($file_path . $file_name);
                }
        }
        $pdf->Output($file_path . $file_name, 'F');
    }

    function generateImagePDF($file_path = false, $file_name = ''){
        
        if($file_path==false){
            $file_path = '/var/www/upload/user_docs/'; //'./assets/user_docs/';
        }
        
        $pdf = new FPDI();
//        $pdf->SetProtection(array('print'));
// add a page
        $pdf->AddPage();
// set the source file
        $pdf->setSourceFile("./assets/user_docs/ad55194505bd5b0f93c565a2c0000d8f804f60a6fde4802ee84c431ade29f96233e25048694d3179e2e312da039f089a.pdf");
// import page 1
        $tplIdx = $pdf->importPage(1);
// use the imported page and place it at point 10,10 with a width of 100 mm
        $pdf->useTemplate($tplIdx, 5, 5, 200);

// now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetFontSize(10);
        $pdf->Image('.assets/images/watermark.png',10,10,-300);
        if (file_exists($file_path . $file_name)) {
            unlink($file_path . $file_name);
        }
        $pdf->Output($file_path . $file_name, 'F');
    }
}