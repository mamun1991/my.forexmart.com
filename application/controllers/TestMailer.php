<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TestMailer extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('account_model');
        $this->load->library('Fx_mailer');
    }

    public function index(){
        exit;
       // echo "test";
    }

        //INTERNAL


        public function forgot_password_v2($forgot_details){
          $CI->lang->load('FxMailer');
        $dear = (lang('fxm_for_pass_02_v2')=='')? lang('fxm_for_pass_07'):lang('fxm_for_pass_02_v2') ;
        $email = (lang('fxm_for_pass_03_v2')=='')?lang('fxm_for_pass_08'):lang('fxm_for_pass_03_v2');
        $account_number = (lang('fxm_for_pass_04_v2')=='')?lang('fxm_for_pass_09'):lang('fxm_for_pass_04_v2');
        $subject = lang('fxm_for_pass_00');

        $body = self::head_scheduler();
        $body .= '<div style="margin-top: 3px; border-top: 1px solid #2988CA; border-bottom: 1px solid #2988CA; padding-bottom: 30px;">';
        $body .= '<h2 style="font-family: Georgia, Times New Roman,serif;font-size: 22px;text-align: center;color: #2988CA;">'.lang('fxm_for_pass_01').'</h2>';
        $body .= '<label style="color: #000;font-size: 14px;float: left;margin-top: 30px;">'.$dear .' '.$forgot_details['full_name'].',</label>';
        $body .= '<p style="padding-top: 20px; line-height: 20px; font-size: 14px; clear: left;">';
        $body .= ' '.lang('fxm_for_pass_03').'<br/><br/>';
        $body .= ' '.lang('fxm_for_pass_04').'<br/><br/>';

        $body .= '<strong>'.$email. ':</strong>'.$forgot_details['Email'].'<br/>';
        $body .= '<strong>'.$account_number.':</strong>'.$forgot_details['Account_number'].'<br/><br/>';

        $body .= 'https://my.forexmart.com/reset-password/'.$forgot_details['Hash'].'<br/><br/>';
        $body .= '<br/>';
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">'.lang('fxm_for_pass_05').'</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">'.lang('fxm_for_pass_06').'</label>';
        $body .= '</div>';
        $body .= self::footer_scheduler();
        self::sender($forgot_details['Email'], $subject, $body, 'noreply@mail.forexmart.com', 'support@forexmart.com');
    }

     public static function footer_scheduler(){
        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $data =array();
        return $CI->load->view('email/_email_footer',$data,true);

        $body = '<div style="background:url(https://www.forexmart.com/assets/images/footer-bg.png); width:800px; margin-top:2px; height: 218px;border-top: 3px solid #EAEAEA;">';
        $body .= '<div style="width: 620px; float: left;">';
        $body .= '<div><p style="color: #5a5a5a;text-align: justify;font-size: 13px;">
                    <span style="font-weight: 600; color: #FF0000;"> '.lang('fxm_foo_sch_01').' </span>'.lang('fxm_foo_sch_02').' .</span></p></div>';
        $body .= '<div><p><span style="font-weight: 600;color:#2988ca;">'.lang('fxm_foo_sch_03').'</span>'.lang('fxm_foo_sch_04').'  <span style="font-weight: 600;color: #000;"> Tradomart Ltd </span> '.lang('fxm_foo_sch_05').' </p></div>';
        $body .= "<div><p><span style='font-weight: 600;color:#2988ca;'>".lang('fxm_foo_sch_06')."</span>
                    ".lang('fxm_foo_sch_07')."

                    </p></div>";
        $body .= '<p>&copy; 2015 <span class="span-black-label">Tradomart Ltd</span></p>';
        $body .= '</div>';
        $body .= '<div style="width: 180px;float: right;">';
        $body .= '<img width="124" height="76" src="https://www.forexmart.com/assets/images/cysec.png" style="width: auto;margin: 20px auto;display: block;">';
        $body .= '<img width="124" height="76" src="https://www.forexmart.com/assets/images/mifid.png" style="width: auto;margin: 20px auto;display: block;">';
        $body .= '</div>';
        $body .= '</div>';
        $body .= '</div></body></div>';
        return $body;
//        Risk Warning:
//        Foreign exchange is highly speculative and complex in nature, and may not be suitable for all investors. Forex trading may result to substantial gain or loss. Therefore, it is not advisable to invest money you cannot afford to lose. Before using the services offered by ForexMart, please acknowledge and understand the risks relative to forex trading. Seek financial advice, if necessary
//        ForexMart
//, a Cyprus Investment Firm regulated by the Cyprus Securities Exchange (CySEC) with license number 266/15.
//        ForexMart
//        was named by ShowFx World as the Best Broker in Europe 2015 and Most Perspective Broker in Asia 2015.
    }

    public static function sender($to, $subject, $message, $from, $returnpath){
        require_once dirname(__FILE__) . '/PHPMailer/class.phpmailer.php';
        $name = "ForexMart";
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.mail.forexmart.com";
        $mail->Port = 25;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPDebug = 1;
        $mail->Username = "noreply@mail.forexmart.com";
        $mail->Password = "6!1PN%xpyJOE0i";
        $mail->DKIM_domain = "forexmart.com";
        $mail->DKIM_selector = 'mail';
        $mail->AddReplyTo($returnpath, $name);
        $mail->SetFrom($from, $name);
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        $mail->AddAddress($to);

        if(!$mail->Send()){
            return false;
        }else{
            return true;
        }

    }


    //mailer for fx-mailer - moneyfall registration code
    public function mailer_mf_rc(){
        $email_data = array(
            'Title' =>'Thank you for signing up!',
            'FullName' => 'Test25-06',
            'Code'=> 'TestCode2506',
            'Email' => 'uness1954@gmail.com'
        );
       
       print_r($email_data); 
       Fx_mailer::MoneyFallRegistrationCode($email_data['Title'],$email_data);
  }

    //mailer for fx-mailer - moneyfall registration access
      public function mailer_mf_ra(){
        $email_data = array(
            'space'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
            'FullName' => 'Test25-06b',
            'Code'=> 'TestCode2506b',
            'Email' => 'uness1954@gmail.com',
            'AccountNumber'=> '25062506',
            'Password'=> 'PWD-06b',
            'InvestorPassword'=> 'INVSTRPWD06B',
        );
       
       print_r($email_data); 
       Fx_mailer::MoneyFallRegistrationAccess($email_data['Title'],$email_data);
  }

  //mailer for fx-mailer - forgot password
      public function mailer_forgotpwd(){
        $email_data = array(
            'Hash'=>'HashSample07',
            'Email' => 'uness1954@gmail.com',
        );
       
       print_r($email_data); 
       Fx_mailer::forgot_password($email_data);
  }

    //mailer for fx-mailer - forgot password new
      public function mailer_forgotpwd2(){
        $email_data = array(
            'Hash'=>'HashSample07',
            'Email' => 'uness1954@gmail.com',
            'Account_number' => '11111',
            'full_name' => 'AE Span Actual3',
        );
       
       print_r($email_data); 
       Fx_mailer::forgot_password_v2($email_data);
  }


    //mailer for fx-mailer - reset password
    public function mailer_resetpwd(){
        $email_data = array(
            'Account_number'=>'25062506',
            'new_password' => 'PWD-08',
            'Email' => 'uness1954@gmail.com',
        );
       
       print_r($email_data); 
       Fx_mailer::reset_password($email_data);
  }

      //mailer for fx-mailer - AccountVerificationVerifiedUser
    public function mailer_acv_vu(){
        $email_data = array(
            'Email' => 'uness1954@gmail.com',
            'AccountNumber' => '25092509',
            'FullName' => 'test25-09',

            'ClientName0' => 'cn09',
            'FileName0' => 'fn09',
            'DocIdx0' => 'doc09',

            'ClientName1' => 'cn19',
            'FileName1' => 'fn19',
            'DocIdx1' =>'doc19',

            'ClientName2' => 'cn29',
            'FileName2' => 'fn29',
            'DocIdx2' => 'doc29'
        );
       
       // print_r($email_data); 
       Fx_mailer::AccountVerificationVerifiedUser($email_data);
  }

      //mailer for fx-mailer - successful deposit
    public function mailer_depsuccess(){
        $email_data = array(
            'type' => 'type10',
            'amount' => 'amount10',
            'account_number' => '25102510',

            'ip' => 'ip10',
            'country' => 'country10',
            'agent' => 'agent10',

            'comment' => 'comment10',
            'count' => 'count10',

        );
       
       print_r($email_data); 
       Fx_mailer::test_successful_deposit($email_data);
  }

    protected $keyForEmail = 'Bj4mQBqP';
    protected $keyForMail = 'PKpSq706';


    public function internalLogin($username,$password){
        $ch = curl_init();
        $data = array(
            'username'=> $username,
            'password'=> $password
        );
            curl_setopt($ch, CURLOPT_URL,"https://my.forexmart.com/client/signin");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close ($ch);
        return $server_output;
    }



    public function automatedLogin(){
        $data = $this->encode($_GET['email'],$this->keyForEmail);
        $data1 = $this->decode($data,$this->keyForEmail);
        // echo $data;
        // echo '<br>';
        // echo $data1;
        $data2 = $this->encode($_GET['email'],$this->keyForMail);
        $data3 = $this->decode($data2,$this->keyForMail);
        // echo '<br>';
        // echo $data2;
        // echo '<br>';
        // echo $data3;

        echo "https://my.forexmart.com/TestMailer/mailTesting/".$data."/".$data2;



    }

// for later
    // sending email https://my.forexmart.com/TestMailer/mailTesting/Sf6jcFd-fBD4qJohAj5GZ4WqTycg8qR7Yu450Sccj08/B7fD4PREXxAh-1SMwfRKWCCoFYQATldgEFVV2Pg9qjs
    // if send update dateAuth


    public function mailTesting(){
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        ini_set('memory_limit', '-1');
        $email = $this->decode( $this->uri->segment(3), $this->keyForEmail ) ;
        if ( $email == $this->decode( $this->uri->segment(4), $this->keyForMail ) ) {
            $this->load->model('Mailer_model');    
    // check if with in range of 2 weeks.

            // print_r($this->Mailer_model->checkIfSendLessThanTwoWeeks($email));
            // exit;
            if ( $this->Mailer_model->checkIfSendLessThanTwoWeeks($email) ) {
                // echo "successful";
                // exit;
                $accountnumber = $this->Mailer_model->getLatestAccountNumber($email);
                $this->redirectToCabinet($accountnumber);
            }else{
                show_404();

            }
        }else{
            show_404();
        }

    }

    public function redirectToCabinet($accountnumber){
        $this->load->model('cabinet_model');
        $this->load->library('TFA');
        $user_info = $this->cabinet_model->getUserInfoByAccount($accountnumber) ;
        $this->session->set_userdata('AccountType', 0);
        $strLogin = $accountnumber;
        $strPassowrd = $service_data['strPassword'];
        $this->tfa->TFAProcess($user_info->id, $strLogin, $strPassowrd);
        $this->session->set_userdata(array(
            'full_name'  => $user_info->full_name,
            'user_id'   => $user_info->id,
            'username'  => $user_info->username,
            'email'     =>$user_info->email,
            'logged_in' => TRUE,
            'logged' => 1,
            'status'    => 1,
            'administration'    => $user_info->administration,
            'login_type' => $user_info->login_type,
            'readOnly'=>true
        ));
        redirect(FXPP::my_url('my-account'));
    }



    public  function encode($value, $key){ 
        
        if(!$value){return false;}
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encode($crypttext)); 
    }
    
    public function decode($value,$key){
        
        if(!$value){return false;}
        $crypttext = $this->safe_b64decode($value); 
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }

    private  function safe_b64encode($string) {

        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }
 
    private function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }



    //mailer for fx-mailer - AccountVerificationVerifiedUser
    public function testfooter(){

        echo Fx_mailer::footer_scheduler();
        echo Fx_mailer::foot_withdraw_recall();
        echo Fx_mailer::myfoot();
    }

    public function TestPendingDeposit(){

        $data = array(
            "account_number" => 58050126,
            "time" => date('Y-m-d H:i:s'),
            "payment_type" => "Sample",
            "amount" => 10,
            "reason" => "Test"
        );

        Fx_mailer::pending_deposit_with_issues($data);
    }

}


    