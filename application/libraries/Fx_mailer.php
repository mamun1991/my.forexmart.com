<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/PHPMailer/class.phpmailer.php';
require_once dirname(__FILE__) . '/PHPMailer/class.smtp.php';
class Fx_mailer {

    function __construct(){
        FXPP::CI()->lang->load('FxMailer');
    }

    public static function head_internal(){
        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $data = array();
        return $CI->load->view('email/_email_internal_email_header', $data, true);
    }

    public static function partners_registration($partnership_login, $partnership_affiliate){

        $subject = "ForexMart Partnership Program";

        $from = "partners@mail.forexmart.com";
        $returnpath = "partners@mail.forexmart.com";
        $body = self::myhead($subject, 1);
        $body .= '<div style="margin: 0 auto; padding: 15px; box-sizing: border-box; border-bottom: 1px solid #2988ca; padding-bottom: 60px">';
        $body .= '<p>';
        $body .= "Dear ".$partnership_login['fullname'].",";
        $body .= "</p>";
        $body .= "<p>Welcome to ForexMart, the world's most trusted trading partner! We express our profound gratitude for jump-starting your business with us.</p>";
        $body .= "<p>Please take note of your account details below. Keep your account details safe and secure at all times.</p>";
        $body .= "<span style='margin-left: 20px;'>Username: </span>".$partnership_login['email']."<br/>";
        $body .= "<span style='margin-left: 20px;'>Password: </span>".$partnership_login['password']."<br/>";
        $body .= "<p>Take note of this code when you begin referring clients.</p>";
        $body .= "<span style='margin-left: 20px;'>Affiliate Code: </span>".$partnership_affiliate['affiliate_code']."<br/>";
        $body .= "<p>Do not forget to verify your account. Click here to begin the verification process. Provide a scanned copy of your valid ID or passport, along with proof of residence. Accepted image file formats include .jpeg, .gif, .pdf, and .png</p>";
        $body .= "<div style='margin: 30px 0px;'><a href='https://my.forexmart.com/partner/signin' style='background: #29a643; color: #fff;border: none;padding: 7px 50px;transition: all ease 0.3s;text-decoration: none;'> Login to your account </a></div>";
        $body .= "All the best,<br/>ForexMart Support";
        $body .= "</div>";
        $body .= self::myfoot();
        self::fx_sender_partner($partnership_login['email'], $subject, $body, $from, $returnpath);
    }

    public static function partnersdetails($email, $details, $user_profile){
        $strWeb ="";
        if(empty($details['websites'])){
            $strWeb = 'N/A';
        }else{
            foreach(json_decode($details['websites'],true) as $test){
                $strWeb .= "<a href='".urldecode($test)."'>".urldecode($test)."</a> ";
            }
        }

        $message = empty($details['message']) ? 'N/A' : $details['message'];
        $subject = "Partners request [ref#:".$details['reference_num']."]";
        $to = "partners@mail.forexmart.com";
        $from = "notification@mail.forexmart.com";
        $returnpath = "notification@mail.forexmart.com";
        $body = "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /></head><body>";
        $body .= "<div>";
        $body .= "Full Name: ".$user_profile['full_name']."<br/>";
        $body .= "Email: ".$email."<br/>";
        $body .= "Phone number: ".$details['phone_number']."<br/>";
        $body .= "Country of Residence: ".$user_profile['country']."<br/>";
        $body .= "Target Country of Business: ".$details['target_country']."<br/>";
        $body .= "Website: ".$strWeb."<br/>";
        $body .= "Message: ".$message."<br/>";
        $body .= "</div>";
        $body .= "</body></html>";
        self::fx_notification_partner($to, $subject, $body, $from, $returnpath);
    }

    public static function fx_sender_partner($to, $subject, $message, $from, $returnpath){
      //  require_once dirname(__FILE__) . '/PHPMailer/class.phpmailer.php';
        $name = "ForexMart";
        $mail = new PHPMailer();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.mail.forexmart.com";
        $mail->Port = 25;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPDebug = 0;
        $mail->Username = "partners@mail.forexmart.com";
        $mail->Password = "TBGYWmHwt7";
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

    public static function fx_notification_partner($to, $subject, $message, $from, $returnpath){
       // require_once dirname(__FILE__) . '/PHPMailer/class.phpmailer.php';
        $name = "ForexMart";
        $mail = new PHPMailer();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.mail.forexmart.com";
        $mail->Port = 25;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPDebug = 0;
        $mail->Username = "notification@mail.forexmart.com";
        $mail->Password = "t9EE+gV2;g~=|z";
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

    public static function sender($to, $subject, $message, $from, $returnpath,$bcc=false){
       // require_once dirname(__FILE__) . '/PHPMailer/class.phpmailer.php';
        $name = "ForexMart";
        $mail = new PHPMailer();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.mail.forexmart.com";
        $mail->Port = 25;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPDebug = 0;
        $mail->Username = "noreply@mail.forexmart.com";
        $mail->Password = "6!1PN%xpyJOE0i";
        $mail->DKIM_domain = "forexmart.com";
        $mail->DKIM_selector = 'mail';
        $mail->AddReplyTo($returnpath, $name);
        $mail->SetFrom($from, $name);
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        $mail->AddAddress($to);
        if($bcc) {
            $mail->addBCC($bcc);
        }

        if(!$mail->Send()){
            return false;
        }else{
            return true;
        }

    }


    public static function senderInternal($to, $subject, $message,$bcc=false){
        // require_once dirname(__FILE__) . '/PHPMailer/class.phpmailer.php';
         $name = "ForexMart";
         $mail = new PHPMailer();
         $mail->SMTPOptions = array(
             'ssl' => array(
                 'verify_peer' => false,
                 'verify_peer_name' => false,
                 'allow_self_signed' => true
             )
         );
         $mail->IsSMTP();
         $mail->CharSet = "UTF-8";
         $mail->SMTPAuth = true;
         $mail->Host = "smtp.mail.forexmart.com";
         $mail->Port = 25;
         $mail->SMTPSecure = 'tls';
         $mail->SMTPDebug = 0;
         $mail->Username = "internal@mail.forexmart.com";
         $mail->Password = "b2YMPQj6UL";
         $mail->DKIM_domain = "forexmart.com";
         $mail->DKIM_selector = 'mail';
         $mail->AddReplyTo('internal@mail.forexmart.com', $name);
         $mail->SetFrom('internal@mail.forexmart.com', $name);
         $mail->Subject = $subject;
         $mail->MsgHTML($message);
         $mail->AddAddress($to);
         if($bcc) {
            $mail->addBCC($bcc);
         }
 
         if(!$mail->Send()){
             return false;
         }else{
             return true;
         }
 
     }
 
    public static function MoneyFallRegistrationCode($title,$data){

        $data['insert'] = array(
            'Title' =>'Thank you for signing up!',
            'FullName' =>$data['data']['Fullname'],
            'Code' =>$data['Code'],
            'Email' =>$data['Email']
        );


        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $body = self::myhead($title);
        $date = date("F j, Y h:i:s A");
        $subject = 'ForexMart MoneyFall Confirmation ';
        $body .='       <div class="content-grid" style="margin: 0 auto; padding: 15px; box-sizing: border-box; border-bottom: 1px solid #2988ca; padding-bottom: 60px">
                        <p class="greetings" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555">

                        '.lang("hi").' '.$data['FullName'].',

                        </p>
                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                            '.lang("p1-0").'
                        </p>
                        <br/>'.lang("p1-1-0").'
                        <br/>'.lang("p1-1-1").'  <span style="font-weight:bold">'.$data['Code'].'</span>
                        <br/>
                        <br/>
                        <br/><a style="text-decoration: none;color: #FFF;font-family: Open Sans;font-size: 17px;font-weight: 600;background: #29A643 none repeat scroll 0% 0%;padding: 10px 20px;transition: all 0.3s ease 0s;" href="'.site_url("confirm/code").'" >Confirm Now</a>
                        <br/>
                        <p class="last-word" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify">
                            '.lang("forcode").' <a style="margin: 0 auto; color: #2988ca; text-decoration: none" href="./#NOP" onclick="return false" rel="noreferrer">  '.lang("supportmail").'</a>.
                        </p>
                        <p class="closing" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; line-height: 19px">
                            '.lang("thankyou").'<br style="margin: 0 auto">
                             '.lang("closing").'<br style="margin: 0 auto">
                            <span style="margin: 0 auto; font-weight: 600; color: #2988ca">'.lang("ForexMart").'</span> '.lang("team").'
                        </p>
                    </div>';
        $body .= self::myfoot();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($data['Email'],$subject,$body,$from,$returnPath);

    }
    public static function MoneyFallRegistrationAccess($title,$data){
        $data['space']='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $body = self::myhead($title);
        $date = date("F j, Y h:i:s A");
        $subject = 'ForexMart MT4 Demo account details ';
        $body .='       <div class="content-grid" style="margin: 0 auto; padding: 15px; box-sizing: border-box; border-bottom: 1px solid #2988ca; padding-bottom: 60px">
                        <p class="greetings" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555">

                        '.lang("hi").' '.$data['FullName'].',

                        </p>
                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                            '.lang("code").'
                        </p>
                        <br/> '.$data['space'].' <strong>'.lang("AccountNumber").'</strong> :  '.$data['AccountNumber'].'
                        <br/> '.$data['space'].' <strong>Trader password</strong> :  '.$data['Password'].'
                        <br/> '.$data['space'].' <strong>Investor password</strong> :  '.$data['InvestorPassword'].'
                        <br/> '.$data['space'].' <strong>MT4 Demo Server</strong> :  ' . MONEYFALL_SERVER_DEMO . '
                        <br/> '.$data['space'].'
        <p style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;line-height: 19px;">
        '.$data['space'].'
        Please store your login details safe and secure at all times.
        </p>

        <p style="font-size: 14px;font-family: Arial sans-serif;font-weight: 400;color: #555;margin: 25px 0px 30px 0px;text-align: justify;">
        '.$data['space'].'
        <a href="https://download.mql5.com/cdn/web/tradomart.ltd/mt4/forexmart4setup.exe" style="background: none repeat scroll 0 0 #2988ca; border: 1px solid #2988ca; color: #fff; font-family: Arial; font-size: 15px; font-weight: 500; padding: 8px 25px; transition: all 0.3s ease 0s; text-decoration: none;">
            Download MT4 desktop platform
        </a>
        </p>

        <p style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;line-height: 19px;">
            You may visit our <a target="_blank" href="https://www.forexmart.com/faq"> Frequently Asked Questions</a>
            for more technical information. We wish you a successful trading!</p>

        <p style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
            For more information please do not hesitate to contact us at <a href="#" style="margin: 0 auto;color: #2988ca;text-decoration: none;">support@forexmart.com</a>.
        </p>
                        <p class="closing" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; line-height: 19px">
                          '.lang("thankyou").'<br style="margin: 0 auto">
                          '.lang("closing").'<br style="margin: 0 auto">
                          <span style="margin: 0 auto; font-weight: 600; color: #2988ca">'.lang("ForexMart").'</span> '.lang("team").'
                        </p>
                    </div>';
        $body .= self::myfoot();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($data['Email'],$subject,$body,$from,$returnPath);
    }

    public static function sample($title,$data){
        $body = self::myhead($title);
        $subject = 'Registration Code';
        $body .='       <div class="content-grid" style="margin: 0 auto; padding: 15px; box-sizing: border-box; border-bottom: 1px solid #2988ca; padding-bottom: 60px">
                        <p class="greetings" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555">Hi tester,</p>
                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                            Epsum factorial non deposit quid pro quo hic escorol. Olypian quarrels et gorilla congolium sic ad nauseum. Souvlaki ignitus carborundum e pluribus unum. Defacto lingo est igpay atinlay.
                        </p>
                        <p class="last-word" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify">
                            For more information please do not hesitate to contact us at <a style="margin: 0 auto; color: #2988ca; text-decoration: none" href="./#NOP" onclick="return false" rel="noreferrer">support@forexmart.com</a>.
                        </p>
                        <p class="closing" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; line-height: 19px">
                            Thank you<br style="margin: 0 auto">
                            With best regards,<br style="margin: 0 auto">
                            <span style="margin: 0 auto; font-weight: 600; color: #2988ca">ForexMart</span> Team
                        </p>
                    </div>';
        $body .= self::myfoot();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($data['Email'],$subject,$body,$from,$returnPath);
    }

    public static function myhead($title,$type=0){
        //$type = 0 - client , 1 - partner
        $type = $type ? 'partner' : 'client';
        $CI =& get_instance();
        $CI->lang->load('FxMailer');

        $body = '<html>
                      <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <title>'.lang("FMtitle").'</title>

                     </head>
                     <body style="font-size: 14px; font-family: Arial; font-weight: 400; color: #555">';

        $body .='<div class="main-wrapper" style="margin: 0 auto; width: 615px">';

        $body .=' <div class="header-grid" style="margin: 0 auto; width: 100%; min-height: 10px; background: #2988ca; display: block; padding: 7px 15px; box-sizing: border-box">
                        <div class="logo-holder" style="margin: 0 auto">
                            <a style="margin: 0 auto;text-decoration: none;" href="https://www.forexmart.com/"><span style="font-size: 30px;color: #FFF">ForexMart</span></a>
                            <cite class="slogan" style="margin: 0 auto; font-family: Arial; font-size: 14px; font-weight: 400; color: #fff; font-style: normal; margin-left: 7px">'.lang("think").'<span style="margin: 0 auto; font-weight: 600"> '.lang("big").'</span>.'.lang("tradeforex").'</cite>
                            <a target="_blank" href="https://my.forexmart.com/partner/'.$type.'/signin" class="btn-sign" style="margin: 0 auto; float: right; background: none; border: 1px solid #fff; color: #fff; padding: 7px 15px; font-family: Open Sans; transition: all ease 0.3s">'.lang("signin").'</a>
                        </div><div class="clear" style="margin: 0 auto; clear: both"></div>
                    </div>

                    <h1 class="h1" style="margin: 0 auto; font-family: Georgia; font-weight: 400; font-size: 25px; color: #2988ca; margin-top: 30px; margin-bottom: 30px; border-bottom: 1px solid #2988ca; padding-bottom: 10px; padding-left: 15px">'.$title.'</h1>';

        $body .="<div  id='container' style='height:auto;margin:-1px auto 0px auto; border-top:none;'>";

        return $body;

    }

    

    public static function myfoot(){

        $CI =& get_instance();
        $CI->lang->load('FxMailer');

        $body ='<div class="risk-grid" style="margin: 0 auto; padding: 15px">
                    <p style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; text-align: justify; line-height: 19px">
                        <cite style="margin: 0 auto; font-style: normal; color: #ff0000; font-weight: 600">'.lang("RW").'</cite>'.lang("RWmsg-0").'
                        <span style="margin: 0 auto; color: #2988ca; font-weight: 600">'.lang("ForexMart").'</span>'.lang("RWmsg-1").'
                        <br style="margin: 0 auto"><br style="margin: 0 auto">
                        '.lang("RWmsg-2").'
                    </p>
                </div>

                    <div class="copy-grid" style="margin: 0 auto; padding: 15px; border-top: 3px solid #2988ca">
                        <div class="copy" style="margin: 0 auto; float: left">
                            <p style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; text-align: justify">'.lang("cpyright").'</p>
                        </div>
                    </div>

                <div class="clear" style="margin: 0 auto; clear: both"></div>';
        $body .='</div></body></html>';
        return $body;

    }
    public static function head1(){
        $full='
              <div class="main-wrapper" style="margin: 0 auto; width: 615px">
                    <div class="header-grid" style="margin: 0 auto; width: 100%; min-height: 10px; background: #2988ca; display: block; padding: 7px 15px; box-sizing: border-box">
                        <div class="logo-holder" style="margin: 0 auto">
                            <a style="margin: 0 auto" href="https://www.forexmart.com/" onclick="return false" rel="noreferrer">
                            <img src="https://doc-00-48-docs.googleusercontent.com/docs/securesc/ha0ro937gcuc7l7deffksulhg5h7mbp1/s7va2bhli5pq113n03vndom1n8u6nt54/1438927200000/14982723203090231498/*/0B-HO8-A8uEj6d0hZR3hDZmt6Q3M" class="logo" style="margin: 0 auto; width: 150px"></a>
                            <cite class="slogan" style="margin: 0 auto; font-family: Arial; font-size: 14px; font-weight: 400; color: #fff; font-style: normal; margin-left: 7px">Think <span style="margin: 0 auto; font-weight: 600">BIG</span>. Trade Forex</cite>
                            <button class="btn-sign" style="margin: 0 auto; float: right; background: none; border: 1px solid #fff; color: #fff; padding: 7px 15px; font-family: Open Sans; transition: all ease 0.3s">Sign in</button>
                        </div><div class="clear" style="margin: 0 auto; clear: both"></div>
                    </div>

                    <h1 class="h1" style="margin: 0 auto; font-family: Georgia; font-weight: 400; font-size: 25px; color: #2988ca; margin-top: 30px; margin-bottom: 30px; border-bottom: 1px solid #2988ca; padding-bottom: 10px; padding-left: 15px">Lorem Ipsum</h1>

                    <div class="content-grid" style="margin: 0 auto; padding: 15px; box-sizing: border-box; border-bottom: 1px solid #2988ca; padding-bottom: 60px">
                        <p class="greetings" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555">Hi tester,</p>
                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                            Epsum factorial non deposit quid pro quo hic escorol. Olypian quarrels et gorilla congolium sic ad nauseum. Souvlaki ignitus carborundum e pluribus unum. Defacto lingo est igpay atinlay.
                        </p>
                        <p class="last-word" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify">
                            For more information please do not hesitate to contact us at <a style="margin: 0 auto; color: #2988ca; text-decoration: none" href="./#NOP" onclick="return false" rel="noreferrer">support@forexmart.com</a>.
                        </p>
                        <p class="closing" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; line-height: 19px">
                            Thank you<br style="margin: 0 auto">
                            With best regards,<br style="margin: 0 auto">
                            <span style="margin: 0 auto; font-weight: 600; color: #2988ca">ForexMart</span> Team
                        </p>
                    </div>

                <div class="risk-grid" style="margin: 0 auto; padding: 15px">
                    <p style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; text-align: justify; line-height: 19px">
                        <cite style="margin: 0 auto; font-style: normal; color: #ff0000; font-weight: 600">Risk Warning:</cite> Foreign exchange is highly speculative and complex in nature, and may not be suitable for all investors. Forex trading may result to substantial gain or loss. Therefore, it is not advisable to invest money you cannot afford to lose. Before using the services offered by <span style="margin: 0 auto; color: #2988ca; font-weight: 600">ForexMart</span>, please acknowledge and understand the risks relative to forex trading. Seek financial advice, if necessary.<br style="margin: 0 auto"><br style="margin: 0 auto">
                        Tradomart Ltd is regulated by Cyprus Securities and Exchange Commission(CySEC) under licence no. 266/15.
                    </p>
                </div>

                    <div class="copy-grid" style="margin: 0 auto; padding: 15px; border-top: 3px solid #2988ca">
                        <div class="copy" style="margin: 0 auto; float: left">
                            <p style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; text-align: justify">� 2015 Tradomart</p>
                        </div>
                        <div class="social-links" style="margin: 0 auto; float: right">
                            <ul style="margin: 0 auto; list-style: none">
                                <li style="margin: 0 auto; display: inline-block; padding: 0 7px"><a style="margin: 0 auto; color: #2988ca; font-size: 20px" href="./#NOP" onclick="return false" rel="noreferrer">
                                        <img src="https://doc-0o-48-docs.googleusercontent.com/docs/securesc/ha0ro937gcuc7l7deffksulhg5h7mbp1/4a82nljmfpeth5kssrhgeicjs02u2i27/1439172000000/14982723203090231498/*/0B-HO8-A8uEj6QlpfaEltU0dzN3c"></a></li>
                                <li style="margin: 0 auto; display: inline-block; padding: 0 7px"><a style="margin: 0 auto; color: #2988ca; font-size: 20px" href="./#NOP" onclick="return false" rel="noreferrer">
                                        <img src="https://doc-0c-48-docs.googleusercontent.com/docs/securesc/ha0ro937gcuc7l7deffksulhg5h7mbp1/he6dnf0ki9626cmtciai4am3sn3mqphb/1439179200000/14982723203090231498/*/0B-HO8-A8uEj6X3AzMVROaWJwTW8"></a></li>
                                <li style="margin: 0 auto; display: inline-block; padding: 0 7px"><a style="margin: 0 auto; color: #2988ca; font-size: 20px" href="./#NOP" onclick="return false" rel="noreferrer">
                                        <img src="https://doc-0o-48-docs.googleusercontent.com/docs/securesc/ha0ro937gcuc7l7deffksulhg5h7mbp1/mqiirabnhlt97819h1kcck418m18kosg/1439179200000/14982723203090231498/*/0B-HO8-A8uEj6aGQ2T091aEFLeWM"></a></li>
                                <li style="margin: 0 auto; display: inline-block; padding: 0 7px"><a style="margin: 0 auto; color: #2988ca; font-size: 20px" href="./#NOP" onclick="return false" rel="noreferrer">
                                        <img src="https://doc-0c-48-docs.googleusercontent.com/docs/securesc/ha0ro937gcuc7l7deffksulhg5h7mbp1/he6dnf0ki9626cmtciai4am3sn3mqphb/1439179200000/14982723203090231498/*/0B-HO8-A8uEj6X3AzMVROaWJwTW8"></a></li>
                            </ul>
                        </div>
                    </div>

                <div class="clear" style="margin: 0 auto; clear: both"></div>
            </div>
        ';
    }
    public static function AccountVerificationDecline($data){
        $sentdata = array(
            'Title' => $data['Title'],
            'Email' => $data['Email'],
            'SelectedReason' => $data['SelectedReason'],
            'ReasonExplanation' => $data['ReasonExplanation'],
            'DocumentFilename' => $data['DocumentFilename'],
            'FullName' => $data['FullName']
        );

        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $body = self::myhead($sentdata['Title']);
        $date = date("F j, Y h:i:s A");
        $subject = 'Declined Document '.$date;;
        $body .='       <div class="content-grid" style="margin: 0 auto; padding: 15px; box-sizing: border-box; border-bottom: 1px solid #2988ca; padding-bottom: 60px">
                        <p class="greetings" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555">

                        '.lang("hi").' '.$data['FullName'].',

                        </p>
                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                                Reason for declining document
                        </p>
                        <br/> Selected reason : <strong>'.$sentdata['SelectedReason'].'</strong>
                        <br/> Explained reason : <strong>'.$sentdata['ReasonExplanation'].'</strong>
                        <br/> Document  : <strong>'.$sentdata['DocumentFilename'].'</strong>
                        <br/>
                        <br/>
                        <p class="last-word" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify">
                           '.lang("forcode").'  <a style="margin: 0 auto; color: #2988ca; text-decoration: none" href="./#NOP" onclick="return false" rel="noreferrer">'.lang("supportmail").'</a>.
                        </p>
                        <p class="closing" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; line-height: 19px">
                          '.lang("thankyou").'<br style="margin: 0 auto">
                          '.lang("closing").'<br style="margin: 0 auto">
                          <span style="margin: 0 auto; font-weight: 600; color: #2988ca">'.lang("ForexMart").'</span> '.lang("team").'
                        </p>
                    </div>';
        $body .= self::myfoot();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($sentdata['Email'],$subject,$body,$from,$returnPath);
    }
    public static function AccountVerificationApprove($data){
        $sentdata = array(
            'Title' => 'Account verification status has been approved.',
            'Email' => $data['Email'],
            'FullName' => $data['FullName']
        );

        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $body = self::myhead($sentdata['Title']);
        $date = date("F j, Y h:i:s A");
        $subject = 'Account Verification of user has been approved '.$date;;
        $body .='       <div class="content-grid" style="margin: 0 auto; padding: 15px; box-sizing: border-box; border-bottom: 1px solid #2988ca; padding-bottom: 60px">
                        <p class="greetings" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555">
                        '.lang("hi").' '.$data['FullName'].',
                        </p>
                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px"></p>
                        <br/>
                        <br/> Your account has been verified.
                        <br/>
                        <p class="closing" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; line-height: 19px">
                          '.lang("thankyou").'<br style="margin: 0 auto">
                          '.lang("closing").'<br style="margin: 0 auto">
                          <span style="margin: 0 auto; font-weight: 600; color: #2988ca">'.lang("ForexMart").'</span> '.lang("team").'
                        </p>
                    </div>';
        $body .= self::myfoot();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($sentdata['Email'],$subject,$body,$from,$returnPath);
    }

    public function mass_mailer_scheduler($to, $replyto, $from, $pass, $message){
       // require_once dirname(__FILE__) . '/PHPMailer/class.phpmailer.php';
        $name = "ForexMart";
        $subject = "ForexMart";
        $mail = new PHPMailer();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "mail.contact.forexmart.com";
        $mail->Port = 25;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPDebug = 0;
        $mail->Username = $from;
        $mail->Password = $pass;
        $mail->DKIM_domain = "contact.forexmart.com";
        $mail->DKIM_selector = 'mail';
        $mail->AddReplyTo($replyto, $name);
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

    public function testlayoutsender($to, $replyto, $from, $pass, $body, $subject){
      //  require_once dirname(__FILE__) . '/PHPMailer/class.phpmailer.php';
        $name = "ForexMart";
        $mail = new PHPMailer();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;
        $mail->Host = "mail.contact.forexmart.com";
        $mail->Port = 25;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPDebug = 0;
        $mail->Username = $from;
        $mail->Password = $pass;
        $mail->DKIM_domain = "forexmart.com";
        $mail->DKIM_selector = 'mail';
        $mail->AddReplyTo($replyto, $name);
        $mail->SetFrom($from, $name);
        $mail->Subject = $subject;
        $mail->MsgHTML($body);
        $mail->AddAddress($to);

        if(!$mail->Send()){
            return false;
        }else{
            return true;
        }
    }

    public static function head_scheduler(){
        $CI =& get_instance();
        $CI->lang->load('FxMailer');

        $data =array();
        return $CI->load->view('email/_email_header',$data,true);



        $body = '<html>
                    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
                    <body style="font-family: Helvetica Neue,Arial,sans-serif;">';
        $body .= '<div style="position: relative;width: 800px;margin: 0px auto;">';
        $body .= '<div style="background:#2988ca; padding:10px; max-width:100%;">';
        $body .= '<div style="max-width:100%;">';
        $body .= '<img style="width:100%; height: auto; display:block;" src="https://www.forexmart.com/assets/images/new_email_header.png">';
        $body .= '</div>';
        $body .= '</div>';
        return $body;
    }


    public static function hederInternal(){
        $CI =& get_instance();
        return $CI->load->view("email/_email_internal_email_header", array(), true);
        
    }


    public static function footer_scheduler(){
        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $data =array();
        return $CI->load->view('email/_email_footer',$data,true);

        $body = '<div style="background:url(https://www.forexmart.com/assets/images/footer-bg.png); width:800px; margin-top:2px; height: 218px;border-top: 3px solid #2988ca;">';
        $body .= '<div style="width: 620px; float: left;">';
			
	/*	
        $body .= '<div><p style="color: #5a5a5a;text-align: justify;font-size: 13px;">
                    <span style="font-weight: 600; color: #FF0000;"> '.lang('fxm_foo_sch_01').' </span>'.lang('fxm_foo_sch_02').' .</span></p></div>';
					
        $body .= '<div><p><span style="font-weight: 600;color:#2988ca;">'.lang('fxm_foo_sch_03').'</span>'.lang('fxm_foo_sch_04').'  <span style="font-weight: 600;color: #000;"> Instant Trading EU Ltd </span> '.lang('fxm_foo_sch_05').' </p></div>';
		
        $body .= "<div><p><span style='font-weight: 600;color:#2988ca;'>".lang('fxm_foo_sch_06')."</span>
                    ".lang('fxm_foo_sch_07')."
                    </p></div>";
			*/


        $body .= "<div><p><span style='font-weight: 600;color:#2988ca;'>ForexMart</span> brand is authorized and regulated in various jurisdictions.</p></div>";
		$body .= "<div><p>This website is operated by <b>Tradomart SV Ltd.</b> (Reg No.23071, IBC 2015) with registered address at Shamrock Lodge, Murray Road, Kingstown, Saint Vincent and the Grenadines.</p>
		
		</div>";
		
		$body .= "<div><p>Restricted Regions: <b>Tradomart SV Ltd</b> does not provide services for the residents of certain countries, such as the United States, North Korea, Iran, Cuba, Sudan, Syria and some other regions.</p></div>";
		
		$body .= '<div><p style="color: #5a5a5a;text-align: justify;font-size: 13px;">
                        <span style="font-weight: 600; color: #FF0000;"> Risk Warning: </span>Foreign exchange is highly speculative and complex in nature, and may not be suitable for all investors. Forex trading may result in a substantial gain or loss. Therefore, it is not advisable to invest money you cannot afford to lose. Before using the services offered by ForexMart, please acknowledge the risks associated with forex trading. Seek independent financial advice if necessary. Please note that neither past performance nor forecasts are reliable indicators of future results.</span></p></div>';


	 			
					
        $body .= '<br><p>&copy; 2015 <span class="span-black-label">Instant Trading EU Ltd</span></p>';
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

    public static function head_smart_dollar(){
        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $data = array('title' => 'smart_dollar');
        return $CI->load->view('email/_email_header_v2', $data, true);

    }

    public function head_scheduler_v3()
    {
        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $data = array('title' => 'smart_dollar');
        return $CI->load->view('email/_email_header_v3', $data, true);

    }

    public function foot_middle_v3(){
        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $data = array();

        return $CI->load->view('email/_email_middel_section', $data, true);

    }

    public function foot_scheduler_v3(){
        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $data = array();

        return $CI->load->view('email/_email_footer_v3', $data, true);

    }

    public static function footer_smart_dollar()
    {
        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $data = array();

        return $CI->load->view('email/_email_footer_v2', $data, true);
    }

    public function testlayout($to, $replyto, $from, $pass, $message, $subject){
        $body = self::head_scheduler();
        $body .= '<div style="margin-top: 3px; border-top: 1px solid #2988CA; border-bottom: 1px solid #2988CA; padding-bottom: 30px;">';
        $body .= '<h2 style="font-family: Georgia, Times New Roman,serif;font-size: 22px;text-align: center;color: #2988CA;">'.$subject.'</h2>';
        $body .= '<label style="color: #000;font-size: 14px;float: left;margin-top: 30px;">Dear Trader,</label>';
        $body .= '<p style="padding-top: 20px; line-height: 20px; font-size: 14px; clear: left;">';
        $body .= $message;
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">All the best,</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">ForexMart Team</label>';
        $body .= '</div>';
        $body .= self::footer_scheduler();
        self::testlayoutsender($to, $replyto, $from, $pass, $body, $subject);
    }

    public function forgot_password($forgot_details){
        $body = self::head_scheduler();
        $body .= '<div style="margin-top: 3px;   padding-bottom: 30px;">';
        $body .= '<h2 style="font-family: Georgia, Times New Roman,serif;font-size: 22px;text-align: center;color: #2988CA;">
'.lang('fxm_for_pass_01').'

</h2>';
        $body .= '<label style="color: #000;font-size: 14px;float: left;margin-top: 30px;">
'.lang('fxm_for_pass_02').'
</label>';
        $body .= '<p style="padding-top: 20px; line-height: 20px; font-size: 14px; clear: left;">';
        $body .= '
'.lang('fxm_for_pass_03').'

<br/><br/>';
        $body .= '
'.lang('fxm_for_pass_04').'

<br/><br/>';
        $body .= 'https://my.forexmart.com/reset-password/'.$forgot_details['Hash'].'<br/><br/>';
        $body .= '<br/>';
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">
'.lang('fxm_for_pass_05').'

</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">
'.lang('fxm_for_pass_06').'

</label>';
        $body .= '</div>';
        $body .= self::footer_scheduler();
//        self::testlayoutsender($forgot_details['Email'], 'support@forexmart.com', 'noreply@mail.forexmart.com', 'XR5u9zD6uR', $body, 'ForexMart Password Reset');
        self::sender($forgot_details['Email'], 'ForexMart Password Reset', $body, 'noreply@mail.forexmart.com', 'support@forexmart.com');
    }

    public function reset_password($reset_details){
        $body = self::head_scheduler();
        $body .= '<div style="margin-top: 3px;  padding-bottom: 30px;">';
        $body .= '<h2 style="font-size: 22px;text-align: center;color: #2988CA;">
'.lang('fxm_res_pass_01').'

</h2>';
        $body .= '<label style="color: #5A5A5A;font-size: 14px;float: left;margin-top: 30px;">
'.lang('fxm_res_pass_02').'
</label>';
        $body .= '<p style="padding-top: 20px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">';
        $body .= '
'.lang('fxm_res_pass_03').'

<br/><br/>';
        $body .= 'Account Number : ' . $reset_details['Account_number'].'<br>';
        $body .= 'New Password   : ' . $reset_details['new_password'];
        $body .= '<br/>';
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">
'.lang('fxm_res_pass_04').'

</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">
'.lang('fxm_res_pass_05').'

</label>';
        $body .= '</div>';
        $body .= self::footer_scheduler();
//        self::testlayoutsender($reset_details['Email'], 'support@forexmart.com', 'noreply@mail.forexmart.com', 'XR5u9zD6uR', $body, 'ForexMart New Password');
        self::sender($reset_details['Email'], 'ForexMart New Password', $body, 'noreply@mail.forexmart.com', 'support@forexmart.com');
    }

    public static function withdraw($withdraw_data){
        $subject = 'Withdrawal Request [Account #: '.$withdraw_data['Account_number'].']';
        $body = self::head_scheduler();
        $body .= '<div style="margin-bottom: 30px;">';
        $body .= '<label style="margin-top:20px; color: #5A5A5A;font-size: 14px;float: left;">Dear '.$withdraw_data['Full_name'].',</label>';
        $body .= '<p style="padding-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">';
        $body .= "<p style='font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;'>We have received your request to withdraw ".$withdraw_data['Amount']." ".$withdraw_data['Currency']." from your ForexMart Account via ".$withdraw_data['Withdrawal_type'].".</p>";
        $body .= "<p style='font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;'>Our Finance Team is now processing your request. You may refer to the processing time <a href='https://www.forexmart.com/deposit-withdraw-page'>here</a>.</p>";
        $body .= '</p>';
        $body .= '<label style="line-height: 20px; clear: left;color: #5A5A5A;text-align: justify; color: #5A5A5A;font-size: 14px;">All the Best</label>';
        $body .= '<label style="line-height: 20px; clear: left;color: #5A5A5A;text-align: justify; color: #5A5A5A;font-size: 14px;display: block;">ForexMart Team</label>';
        $body .= '</div>';


        $body .= self::footer_scheduler();
        self::sender($withdraw_data['Email'], $subject, $body, 'noreply@mail.forexmart.com', 'support@forexmart.com');
    }







    public static function AccountVerificationVerifiedUser($data){
        //FXPP865
        $sentdata = array(
            'Email' => $data['Email'],
            'AccountNumber' => $data['AccountNumber'],
            'FullName' => $data['FullName'],

            'ClientName0' => $data['ClientName0'],
            'FileName0' => $data['FileName0'],
            'DocIdx0' => $data['DocIdx0'],

            'ClientName1' => $data['ClientName1'],
            'FileName1' => $data['FileName1'],
            'DocIdx1' => $data['DocIdx1'],

            'ClientName2' => $data['ClientName2'],
            'FileName2' => $data['FileName2'],
            'DocIdx2' => $data['DocIdx2'],
        );

        $CI =& get_instance();
        $body = self::head();
        $date = date("F j, Y h:i:s A");
        $subject = 'ForexMart Verification - Approved [ '.$sentdata['AccountNumber'].' ] ';
        $body .='
                       <h2 style="text-align: center;color: #2988CA;"> '.lang('fxm_acc_ver_ver_use_doc_01').'  </h2>
                        <p class="greetings" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555">

                       '.lang('fxm_acc_ver_ver_use_doc_02').' '.$data['FullName'].',

                        </p>
                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">

                        <br/> '.lang('fxm_acc_ver_ver_use_doc_03').'  <br/>
                        <br/> '.lang('fxm_acc_ver_ver_use_doc_04').'  <br/><br/>

                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="'.$CI->config->item('domain-my').'/assets/user_docs/'.$sentdata['FileName0'].'"><strong> '.$sentdata['ClientName0'].' </strong></a>

                        <br/>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="'.$CI->config->item('domain-my').'/assets/user_docs/'.$sentdata['FileName1'].'"><strong> '.$sentdata['ClientName1'].' </strong></a>

                        <br/>

                        <br/> '.lang('fxm_acc_ver_ver_use_doc_05').'

                         <br/><br/>

                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="'.$CI->config->item('domain-my').'/assets/user_docs/'.$sentdata['FileName2'].'"><strong> '.$sentdata['ClientName2'].' </strong></a>

                        <br/>
                        <br/> '.lang('fxm_acc_ver_ver_use_doc_06').'
                        <br/>
                         <br/> '.lang('fxm_acc_ver_ver_use_doc_07').'
                        <br/></p>
                        <p class="last-word" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify">
                           '.lang("forcode").'  <a style="margin: 0 auto; color: #2988ca; text-decoration: none" href="./#NOP" onclick="return false" rel="noreferrer">'.lang("supportmail").'</a>.
                        </p>
                        <p class="closing" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; line-height: 19px">
                          <br style="margin: 0 auto">
                          '.lang('fxm_acc_ver_ver_use_doc_08').'

                          <br style="margin: 0 auto">
                          <span style="margin: 0 auto; font-weight: 600; color: #2988ca">'.lang("ForexMart").'</span> '.lang("team").'
                        </p>
                    </div>';
        $body .= self::foot();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($sentdata['Email'],$subject,$body,$from,$returnPath);
    }

    public static function foot(){
        $CI =& get_instance();
        return $CI->load->view("email/_email_footer", array(), true);
        
    }

    public static function foot_v1(){

        $body = '<div style="background:url(https://www.forexmart.com/assets/images/footer-bg.png); width:800px; margin-top:2px; height: 218px;border-top: 3px solid #EAEAEA;">';
        $body .= '<div style="width: 620px; float: left;">';

        if(FXPP::isEUUrl()) {
            $body .= '<div><p style="color: #5a5a5a;text-align: justify;font-size: 13px;"><span style="font-weight: 600; color: #FF0000;">' . lang('fxm_foot_01') . '</span>' . lang('fxm_foot_02') . '</span></p></div>';
        }else{
            $body .= '<div><p style="color: #5a5a5a;text-align: justify;font-size: 13px;">
                    <span style="font-weight: 600; color: #FF0000;">' . lang('new_fxm_foo_11') . ' </span> ' . lang('new_fxm_foo_12') . ' </span></p></div>';
        }

        if(FXPP::isEUUrl()) {
            $body .= '<div><p><span style="font-weight: 600;color:#2988ca;"> ' . lang('fxm_foot_03') . ' </span> ' . lang('fxm_foot_04') . ' <img height="12" width="130" style="margin-bottom: -1px;vertical-align: middle" src="https://www.forexmart.com/assets/images/tradomart/instant-trading-eu-ltd.png">.</p></div>';
        }else{
            $body .= '<div><p>
                        <a href="https://www.forexmart.com"><span style="font-weight: 600;color:#2988ca;"> '. lang('new_fxm_foo_03') .' </span> </a> 
                         ' . lang('new_fxm_foo_04') . ' <span style="font-weight: bold;color:#000;">Tradomart SV Ltd</span> ' . lang('new_fxm_foo_05') .' 
                        <span style="font-weight: bold;color:#000;">Tradomart SV Ltd</span> '. lang('new_fxm_foo_06') .' <span style="font-weight: 600;color:#2988ca;">
                         '. lang('new_fxm_foo_01').'</span>. ' . lang('new_fxm_foo_07').'<span style="font-weight: 600;color:#2988ca;">'. lang('new_fxm_foo_01').'</span>
                         '. lang('new_fxm_foo_08') .'<span style="font-weight: bold; color: #000;">Instant Trading EU Ltd (CY)</span>'. lang('new_fxm_foo_09').'
                        <a href="https://www.forexmart.com/License">266/15</a>'.lang('new_fxm_foo_10').'<a href="https://www.forexmart.eu"><span style="font-weight: 600;color:#2988ca;">'. lang('new_fxm_foo_02').'</span></a>
                     </p></div>';
        }

      //  $body .= "<div><p><span style='font-weight: 600;color:#2988ca;'> " .lang('fxm_foot_06'). " </span>".lang('fxm_foot_07') ." </p></div>";

        if(FXPP::isEUUrl()) {
            $body .= '<p>&copy; '. '2015-'. date('Y') . ' <img style="margin-bottom: 3px;vertical-align: middle" height="12" width="130" src="https://www.forexmart.com/assets/images/tradomart/instant-trading-eu-ltd.png"></p>';
        }else{
            $body .= '<p>&copy; '. '2015-'. date('Y') . ' <span style="font-weight: bold; color: #000;">Tradomart SV Ltd</span></p>';
        }

        $body .= '</div>';
        $body .= '<div style="width: 180px;float: right;">';
        $body .= '<img width="124" height="76" src="https://www.forexmart.com/assets/images/cysec.png" style="width: auto;margin: 20px auto;display: block;">';
        $body .= '<img width="124" height="76" src="https://www.forexmart.com/assets/images/mifid.png" style="width: auto;margin: 20px auto;display: block;">';
        $body .= '</div>';
        $body .= '</div>';
        $body .= '</div></body></div>';
        return $body;
    }


    public static function foot_old(){

        $body = '<div style="background:url(https://www.forexmart.com/assets/images/footer-bg.png); width:800px; margin-top:2px; height: 218px;border-top: 3px solid #EAEAEA;">';
        $body .= '<div style="width: 620px; float: left;">';
        $body .= '<div><p style="color: #5a5a5a;text-align: justify;font-size: 13px;">
                    <span style="font-weight: 600; color: #FF0000;">
                    '.lang('fxm_foot_01').'

                    </span>
                    '.lang('fxm_foot_02').'

                    </span></p></div>';

//        Risk Warning:
//                           Foreign exchange is highly speculative and complex in nature, and may not be suitable for all investors. Forex trading may result to substantial gain or loss. Therefore, it is not advisable to invest money you cannot afford to lose. Before using the services offered by ForexMart, please acknowledge and understand the risks relative to forex trading. Seek financial advice, if necessary.
        if(FXPP::isEUUrl()) {
            $body .= '<div><p><span style="font-weight: 600;color:#2988ca;">
  ' . lang('fxm_foot_03') . '

</span>
' . lang('fxm_foot_04') . '

<img height="12" width="130" style="margin-bottom: -1px;vertical-align: middle" src="https://www.forexmart.com/assets/images/tradomart/instant-trading-eu-ltd.png">.

</p></div>';
        }else{
            $body .= '<div><p><span style="font-weight: 600;color:#2988ca;">
  ' . lang('fxm_foot_03') . '

</span>
' . lang('fxm_foot_04') . '

<img height="12" width="130" style="margin-bottom: -1px;vertical-align: middle" src="https://www.forexmart.com/assets/images/tradomart/instant-trading-eu-ltd.png">
' . lang('fxm_foot_05') . '

</p></div>';
        }
//        ForexMart
//        is a trading name of
//        , a Cyprus Investment Firm regulated by the Cyprus Securities Exis a trading name ofchange (CySEC) with license number 266/15.
        $body .= "<div><p><span style='font-weight: 600;color:#2988ca;'>
".lang('fxm_foot_06')."

</span>
".lang('fxm_foot_07')."

 </p></div>";
//        ForexMart
//         was named by ShowFx World as the Best Broker in Europe 2015 and Most Perspective Broker in Asia 2015.
        $body .= '<p>&copy;
'.lang('fxm_foot_08').'
<img style="margin-bottom: 3px;vertical-align: middle" height="12" width="130" src="https://www.forexmart.com/assets/images/tradomart/instant-trading-eu-ltd.png"></p>';
//        2015
        $body .= '</div>';
        $body .= '<div style="width: 180px;float: right;">';
        $body .= '<img width="124" height="76" src="https://www.forexmart.com/assets/images/cysec.png" style="width: auto;margin: 20px auto;display: block;">';
        $body .= '<img width="124" height="76" src="https://www.forexmart.com/assets/images/mifid.png" style="width: auto;margin: 20px auto;display: block;">';
        $body .= '</div>';
        $body .= '</div>';
        $body .= '</div></body></div>';
        return $body;
    }
    public static function head(){
        $CI =& get_instance();
        $head = $CI->load->view("email/_email_header", array(), true);
        $div = '<div style="margin: 0 auto; padding: 10px 0; box-sizing: border-box; border-bottom: 1px solid #2988ca; padding-bottom: 60px;border-bottom: 1px solid #2988CA;padding-bottom: 20px;margin-top: 3px;border-top: 1px solid #2988CA;">';
        return $head.$div;
    }
    public static function head_v1(){
        $body = '<html>
                    <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
                    <body style="font-family: Helvetica Neue,Arial,sans-serif;">';
        $body .= '<div style="position: relative;width: 800px;margin: 0px auto;">';
        $body .= '<div style="background:#2988ca;padding:10px 0;width: auto;">';
        $body .= '<img style="margin-left: 10px;width:600px;" src="https://www.forexmart.com/assets/images/new_email_header.png"> <div style=" text-align: center; width: 140px;float: right;right: 0px;margin-top: 10px;"><a
        href="https://my.forexmart.com/partner/signin"
        style="background: #29a643;color: #fff;border: none;padding: 11px 47px;transition: all ease 0.3s;text-decoration: none;font-size: 14px;float: left;">
        Login

    </a> <br>

    <a href="https://my.forexmart.com/forgot-password" >Forgotten details?</a>
</div>';
        $body .= '</div>';
        $body .= '<div style="margin: 0 auto; padding: 10px 0; box-sizing: border-box; border-bottom: 1px solid #2988ca; padding-bottom: 60px;border-bottom: 1px solid #2988CA;padding-bottom: 20px;margin-top: 3px;border-top: 1px solid #2988CA;">';

        return $body;
    }
    public static function partners_agreement($data){

        $sd = array(
            'full_name' => $data['full_name'],
            'a_n' => $data['account_number'],
            'a_l' => $data['affiliate_link'],
            'a_c' => $data['country'],
            'd' => $data['date'],
            'to' =>'partnership@forexmart.com'

        );

        $body = self::head_internal();
        $subject = "Client's Request for Affiliate Link [ ".$data['account_number']." ] ";
        $body .='
                       <h2 style="text-align: center;color: #2988CA;"> Client&#39;s Request for Affiliate Link  </h2>

                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                            <table border="1" cellspacing="0" cellpadding="0"  style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;text-align: center;line-height: 19px; width: 100%">
                                <tr>
                                    <td>
                                        Full Name
                                    </td>
                                    <td>
                                        '.$sd['full_name'].'
                                    </td>
                                </td>
                                <tr>
                                    <td>
                                        Account Number
                                    </td>
                                    <td>
                                      '.$sd['a_n'].'
                                    </td>
                                </tr>
                                 <tr>
                                     <td>
                                        Country of Residence
                                    </td>
                                    <td>
                                      '.$sd['a_c'].'
                                    </td>
                                 </tr>
                                <tr>
                                    <td>
                                        Affiliate Link
                                    </td>
                                    <td>
                                      '.$sd['a_l'].'
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Date
                                    </td>
                                    <td>
                                      '.$sd['d'].'
                                    </td>
                                </tr>
                            </table>


                            <p class="closing" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; line-height: 19px">
                              <br style="margin: 0 auto">
                              '.lang('fxm_pa_00').'
                              <br style="margin: 0 auto">
                              <span style="margin: 0 auto; font-weight: 600; color: #2988ca">'.lang("fxm_pa_01").'</span>
                            </p>
                        </p>
                    </div>';
      
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender_partnership($sd['to'],$subject,$body,$from,$returnPath);

    }

    public static function successful_deposit($data,$currency=null) {
        $ci =& get_instance();
        $ci->lang->load('successful_deposit_email');
        $deposit_currency = is_null($currency)?"USD":$currency;

        $date_now = $data['deposit_date'];
        $body = self::hederInternal();
        $subject = '['.$data['type'].']['.$data['amount'].' '.$deposit_currency.'] - ACC ['.$data['account_number'].']';
        $body .= "<div class='wrapper-body' style='-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px; display: inline-block'>
                    <h2 class='h1' style='margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-top: 30px;margin-bottom: 30px;border-bottom: 1px solid #2988ca;padding-bottom: 10px;padding-left: 15px;'>".lang('sde_06') .' ['.$data['type'].']['.$data['amount'].' '.$deposit_currency.'] - ACC ['.$data['account_number'].']'."</h2>
                    <table cellspacing='0' border='1'>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_07')."</td>
                            <td>".$date_now."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_00')."</td>
                            <td>".$data['amount']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_01')."</td>
                            <td>".$data['account_number']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Depositor's Name</td>
                            <td>".$data['full_name']."</td>
                        </tr>
                        
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_02')."</td>
                            <td>".$data['ip']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_03')."</td>
                            <td>".$data['country']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_04')."</td>
                            <td>".$data['agent']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_05')."</td>
                            <td>".$data['comment']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_08')."</td>
                            <td>".$data['count']."</td>
                        </tr>
                    </table>
                </div>";


          Fx_mailer::senderInternal('auto-reports@forexmart.com',$subject, $body);
      



        // Send a notification to finance@forexmart.com for deposits over 15,000 in FXPP
            if($data['amount'] >= 15000){

               
                Fx_mailer::senderInternal('finance@forexmart.com',$subject, $body);
            }
        //

    }

    public static function successful_deposit_test($data,$currency=null) {
        $ci =& get_instance();
        $ci->lang->load('successful_deposit_email');
        $deposit_currency = is_null($currency)?"USD":$currency;

        $date_now = $data['deposit_date'];
        $body = self::hederInternal();
        $subject = 'Test ['.$data['type'].']['.$data['amount'].' '.$deposit_currency.'] - ACC ['.$data['account_number'].']';
        $body .= "<div class='wrapper-body' style='-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px; display: inline-block'>
                    <h2 class='h1' style='margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-top: 30px;margin-bottom: 30px;border-bottom: 1px solid #2988ca;padding-bottom: 10px;padding-left: 15px;'>".lang('sde_06') .' ['.$data['type'].']['.$data['amount'].' '.$deposit_currency.'] - ACC ['.$data['account_number'].']'."</h2>
                    <table cellspacing='0' border='1'>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_07')."</td>
                            <td>".$date_now."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_00')."</td>
                            <td>".$data['amount']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_01')."</td>
                            <td>".$data['account_number']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Depositor's Name</td>
                            <td>".$data['full_name']."</td>
                        </tr>
                        
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_02')."</td>
                            <td>".$data['ip']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_03')."</td>
                            <td>".$data['country']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_04')."</td>
                            <td>".$data['agent']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_05')."</td>
                            <td>".$data['comment']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_08')."</td>
                            <td>".$data['count']."</td>
                        </tr>
                    </table>
                </div>";


             Fx_mailer::senderInternal('jayhens.snow@gmail.com',$subject, $body);



    }



    public static function successful_deposit2($data,$currency=null) {
        $ci =& get_instance();
        $ci->lang->load('successful_deposit_email');
        $deposit_currency = is_null($currency)?"USD":$currency;
        $date_now = date('Y-m-d H:i:s', strtotime('now'));
        $body = self::head();
        $subject = 'Test ['.$data['type'].']['.$data['amount'].' '.$deposit_currency.'] - ACC ['.$data['account_number'].']';
       // $subject = 'Test ['.$data['type'].']['.$data['amount'].'] - ACC ['.$data['account_number'].']';
        $body .= "<div class='wrapper-body' style='-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px; display: inline-block'>
                    <h2 class='h1' style='margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-top: 30px;margin-bottom: 30px;border-bottom: 1px solid #2988ca;padding-bottom: 10px;padding-left: 15px;'>".lang('sde_06') .' ['.$data['type'].']['.$data['amount'].'] - ACC ['.$data['account_number'].']'."</h2>
                    <table cellspacing='0' border='1'>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_07')."</td>
                            <td>".$date_now."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_00')."</td>
                            <td>".$data['amount']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_01')."</td>
                            <td>".$data['account_number']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_02')."</td>
                            <td>".$data['ip']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_03')."</td>
                            <td>".$data['country']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_04')."</td>
                            <td>".$data['agent']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_05')."</td>
                            <td>".$data['comment']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_08')."</td>
                            <td>".$data['count']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_08')."</td>
                            <td>".$data['user_tags']."</td>
                        </tr>
                    </table>
                </div>";
        $body .= self::foot();

        $config = array(
            'mailtype'=> 'html',
            'protocol'=> 'smtp',
            'smtp_host'=> 'smtp.mail.forexmart.com',
            'smtp_user'=> 'internal@mail.forexmart.com',
            'smtp_pass'=> 'b2YMPQj6UL',
            'smtp_port'=> 25,
        );

        $ci->load->library('email');
        if($config != null){
            $ci->email->initialize($config);
        }
        $ci->email->set_newline("\r\n");
        $ci->email->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $ci->SMTPDebug = 0;
        $ci->email->from('internal@mail.forexmart.com', 'ForexMart Deposits');
        $ci->email->to('jayhens.snow@gmail.com');
        $ci->email->bcc('vela.nightclad@gmail.com');
        $ci->email->subject($subject);
        $ci->email->message($body);
        if($ci->email->send()){
        }else{
            echo $ci->email->print_debugger();
        }
    }

    public static function FXPP_11949($data,$currency=null) {
        $ci =& get_instance();
        $ci->lang->load('successful_deposit_email');
        $deposit_currency = is_null($currency)?"USD":$currency;
        $date_now = date('Y-m-d H:i:s', strtotime('now'));
        $body = self::head();
        $subject = 'Test ['.$data['type'].']['.$data['amount'].' '.$deposit_currency.'] - ACC ['.$data['account_number'].']';
        // $subject = 'Test ['.$data['type'].']['.$data['amount'].'] - ACC ['.$data['account_number'].']';
        $body .= "<div class='wrapper-body' style='-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px; display: inline-block'>
                    <h2 class='h1' style='margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-top: 30px;margin-bottom: 30px;border-bottom: 1px solid #2988ca;padding-bottom: 10px;padding-left: 15px;'>".lang('sde_06') .' ['.$data['type'].']['.$data['amount'].'] - ACC ['.$data['account_number'].']'."</h2>
                    <table cellspacing='0' border='1'>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_07')."</td>
                            <td>".$date_now."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_00')."</td>
                            <td>".$data['amount']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_01')."</td>
                            <td>".$data['account_number']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_02')."</td>
                            <td>".$data['ip']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_03')."</td>
                            <td>".$data['country']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_04')."</td>
                            <td>".$data['agent']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_05')."</td>
                            <td>".$data['comment']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_08')."</td>
                            <td>".$data['count']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_08')."</td>
                            <td>".$data['user_tags']."</td>
                        </tr>
                    </table>
                </div>";
        $body .= self::foot();

        

        Fx_mailer::senderInternal('forexmart.tester5@gmail.com',$subject,$body);
    }

    public static function test_successful_deposit($data) {
        $ci =& get_instance();
        $ci->lang->load('successful_deposit_email');

        $date_now = date('Y-m-d H:i:s', strtotime('now'));
        $body = self::head();
        $subject = '['.$data['type'].']['.$data['amount'].'] - ACC ['.$data['account_number'].']';
        $body .= "<div class='wrapper-body' style='-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px; display: inline-block'>
                    <h2 class='h1' style='margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-top: 30px;margin-bottom: 30px;border-bottom: 1px solid #2988ca;padding-bottom: 10px;padding-left: 15px;'>".lang('sde_06') .' ['.$data['type'].']['.$data['amount'].'] - ACC ['.$data['account_number'].']'."</h2>
                    <table cellspacing='0' border='1'>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_07')."</td>
                            <td>".$date_now."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_00')."</td>
                            <td>".$data['amount']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_01')."</td>
                            <td>".$data['account_number']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_02')."</td>
                            <td>".$data['ip']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_03')."</td>
                            <td>".$data['country']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_04')."</td>
                            <td>".$data['agent']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_05')."</td>
                            <td>".$data['comment']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>".lang('sde_08')."</td>
                            <td>".$data['count']."</td>
                        </tr>
                    </table>
                </div>";
        $body .= self::foot();

        $config = array(
            'mailtype'=> 'html',
            'protocol'=> 'smtp',
            'smtp_host'=> 'smtp.mail.forexmart.com',
            'smtp_user'=> 'internal@mail.forexmart.com',
            'smtp_pass'=> 'b2YMPQj6UL',
            'smtp_port'=> 25,
        );

        $ci->load->library('email');
        if($config != null){
            $ci->email->initialize($config);
        }
        $ci->email->set_newline("\r\n");

        $ci->email->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $ci->SMTPDebug = 0;
        $ci->email->from('internal@mail.forexmart.com', 'ForexMart Deposits');
        $ci->email->to('vela.nightclad@gmail.com');
        $ci->email->bcc('iahrpel@gmail.com');
        $ci->email->subject('Testing');
        $ci->email->message($body);
        if($ci->email->send()){
        }else{
            echo $ci->email->print_debugger();
        }
    }

    public static function sender_partnership($to, $subject, $message, $from, $returnpath){
      //  require_once dirname(__FILE__) . '/PHPMailer/class.phpmailer.php';
        $name = "ForexMart";
        $mail = new PHPMailer();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->CharSet = "UTF-8";
        $mail->Host = "smtp.mail.forexmart.com";
        $mail->Port = 25;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPDebug = 0;
        $mail->Username = "noreply@mail.forexmart.com";
        $mail->Password = "6!1PN%xpyJOE0i";
        $mail->DKIM_domain = "forexmart.com";
        $mail->DKIM_selector = 'mail';
        $mail->AddReplyTo($returnpath, $name);
        $mail->AddBCC('spam.fxpp@gmail.com', $name);
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

    public static function failed_deposit($data) {
        $ci =& get_instance();
        $ci->lang->load('successful_deposit_email');

        $body = self::hederInternal();
        $subject = 'Failed Deposit Report ['.$data['payment_type'].'] - Acct['.$data['account_number'].']';

        $body .= "<div class='wrapper-body' style='-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;padding-bottom: 20px; display: inline-block;width: 100%;'>
                    <h2 class='h1' style='margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-bottom: 30px;border-bottom: 1px solid #2988ca;padding-bottom: 10px;padding-left: 15px;'>Failed Deposit - Acct[" . $data['account_number'] . "]</h2>
                    <table cellspacing='0' border='1'>
                        <tr>
                            <td style='font-weight: bold'>Account number</td>
                            <td>".$data['account_number']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Time</td>
                            <td>".$data['time']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Payment System</td>
                            <td>".$data['payment_type']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Reason</td>
                            <td>".$data['reason']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Country</td>
                            <td>".$data['country']."</td>
                        </tr>
                    </table>
                </div>";

       
        Fx_mailer::senderInternal('failed-deposit-report@forexmart.com',$subject, $body);
    }

    public static function test_failed_deposit($data) {
        $ci =& get_instance();
        $ci->lang->load('successful_deposit_email');

        $body = self::head();
        $subject = 'Failed Deposit Report ['.$data['payment_type'].'] - Acct['.$data['account_number'].']';

        $login_type = isset($data['login_type']) ? ($data['login_type'] ? 'Yes' : 'No') : 'N/A';

        $body .= "<div class='wrapper-body' style='-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;padding-bottom: 20px; display: inline-block;width: 100%;'>
                    <h2 class='h1' style='margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-bottom: 30px;border-bottom: 1px solid #2988ca;padding-bottom: 10px;padding-left: 15px;'>Failed Deposit - Acct[" . $data['account_number'] . "]</h2>
                    <table cellspacing='0' border='1'>
                        <tr>
                            <td style='font-weight: bold'>Account number</td>
                            <td>".$data['account_number']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Time</td>
                            <td>".$data['time']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Payment System</td>
                            <td>".$data['payment_type']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Reason</td>
                            <td>".$data['reason']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Country</td>
                            <td>".$data['country']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Partner Account</td>
                            <td>".$login_type."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Test Account</td>
                            <td>Yes</td>
                        </tr>
                    </table>
                </div>";

        $config = array(
            'mailtype'=> 'html'
        );

        $ci->load->library('email');
        if($config != null){
            $ci->email->initialize($config);
        }
        $ci->email->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $ci->SMTPDebug = 0;
        $ci->email->from('noreply@mail.forexmart.com', $subject);
        $ci->email->to('jayhens.snow@gmail.com');
        $ci->email->subject($subject);
        $ci->email->message($body);
        $ci->email->send();
    }

    public static function partners_agreement_test($data){

        $sd = array(
            'full_name' => $data['full_name'],
            'a_n' => $data['account_number'],
            'a_l' => $data['affiliate_link'],
            'a_c' => $data['country'],
            'd' => $data['date'],
            'to' =>'partnership@forexmart.com'

        );

        $body = self::head_internal();
        $subject = "Client's Request for Affiliate Link [ ".$data['account_number']." ] ";
        $body .='
                       <h2 style="text-align: center;color: #2988CA;"> Client&#39;s Request for Affiliate Link  </h2>

                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                            <table border="1" cellspacing="0" cellpadding="0"  style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;text-align: center;line-height: 19px; width: 100%">
                                <tr>
                                    <td>
                                        Full Name
                                    </td>
                                    <td>
                                        '.$sd['full_name'].'
                                    </td>
                                </td>
                                <tr>
                                    <td>
                                        Account Number
                                    </td>
                                    <td>
                                      '.$sd['a_n'].'
                                    </td>
                                </tr>
                                 <tr>
                                     <td>
                                        Country of Residence
                                    </td>
                                    <td>
                                      '.$sd['a_c'].'
                                    </td>
                                 </tr>
                                <tr>
                                    <td>
                                        Affiliate Link
                                    </td>
                                    <td>
                                      '.$sd['a_l'].'
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Date
                                    </td>
                                    <td>
                                      '.$sd['d'].'
                                    </td>
                                </tr>
                            </table>


                            <p class="closing" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; line-height: 19px">
                              <br style="margin: 0 auto">
                              '.lang('fxm_pa_00').'
                              <br style="margin: 0 auto">
                              <span style="margin: 0 auto; font-weight: 600; color: #2988ca">'.lang("fxm_pa_01").'</span>
                            </p>
                        </p>
                    </div>';
        $body .= self::foot();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";

        self::sender_partnership('trowabarton00005@gmail.com',$subject,$body,$from,$returnPath);
    }

    public function change_password($s_data){
        $r_data = array(
            'account_number' =>$s_data['account_number'],
            'Email' =>$s_data['Email'],
            'new_password' =>$s_data['new_password'],
            'type' =>$s_data['type'],
        );

        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $body = self::head();

        $subject = (lang('fxm_ch_pass_00')=="")?"Client's Request for Change Password":lang('fxm_ch_pass_00');
        $data['1']=(lang('fxm_ch_pass_01')=="")? "ForexMart Password Change" : lang('fxm_ch_pass_01');
        $data['2']=(lang("fxm_ch_pass_02")=="")?'Dear ':lang("fxm_ch_pass_02");
        $data['3']=(lang('fxm_ch_pass_03')=="")?'Your request for password reset was successful.':lang('fxm_ch_pass_03');
        $data['3_1']=(lang('fxm_ch_pass_03_1')=="")?'Username':lang('fxm_ch_pass_03_1');


        $data['4']=(lang('fxm_ch_pass_04_1')=="")?'New Password':lang('fxm_ch_pass_04_1');

        $data['6']=(lang("fxm_ch_pass_04_3")=="")?'For more information please do not hesitate to contact us at':lang("fxm_ch_pass_04_3");
        $data['7']=(lang("fxm_ch_pass_05")=="")?'All the best,':lang("fxm_ch_pass_05");
        $data['8']=(lang("fxm_ch_pass_06")=="")?'ForexMart Team':lang("fxm_ch_pass_06");


        $body .='
                        <h2 style="text-align: center;color: #2988CA;">
                         '.  $data['1'] .'
                         </h2>

                        <p class="greetings" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555">
                            '.$data['2'].' '.$_SESSION['full_name'].',
                        </p>

                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                            '.$data['3'].'
                         </p>

                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                            '.$data['3_1'].' : '.$r_data['account_number'].' or '.$r_data['Email'].'
                         </p>

                         <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                            '.$data['4'].' : '.$r_data['new_password'].' <br/>
                        </p>

                        <p style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
                              '.$data['6'].'
                            <a href="#" style="margin: 0 auto;color: #2988ca;text-decoration: none;">support@forexmart.com</a>.
                        </p>
                        <br/>
                        <p class="closing" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; line-height: 19px">
                            <span style="margin: 0 auto; font-weight: 600; color: #2988ca">
                            '.$data['7'].'
                            </span>
                            <br/>
                            '.$data['8'].'
                        </p>
                    </div>';



        $body .= self::foot();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($r_data['Email'],$subject,$body,$from,$returnPath);
    }

    public function change_password_v2($s_data){
        $r_data = array(
            'account_number' =>$s_data['account_number'],
            'Email' =>$s_data['Email'],
            'new_password' =>$s_data['new_password'],
            'type' =>$s_data['type'],
        );

        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $body = self::head();

        $subject = (lang('fxm_ch_pass_00')=="")?"Client's Request for Change Password":lang('fxm_ch_pass_00');
        $data['1']=(lang('fxm_ch_pass_01')=="")? "ForexMart Password Change" : lang('fxm_ch_pass_01');
        $data['2']=(lang("fxm_ch_pass_02")=="")?'Dear ':lang("fxm_ch_pass_02");
        $data['3']=(lang('fxm_ch_pass_03')=="")?'Your request for password reset was successful.':lang('fxm_ch_pass_03');
        $data['3_1']=(lang('fxm_ch_pass_03_1')=="")?'Username':lang('fxm_ch_pass_03_1');


        $data['4']=(lang('fxm_ch_pass_04_1')=="")?'New Password':lang('fxm_ch_pass_04_1');

        $data['6']=(lang("fxm_ch_pass_04_3")=="")?'For more information please do not hesitate to contact us at':lang("fxm_ch_pass_04_3");
        $data['7']=(lang("fxm_ch_pass_05")=="")?'All the best,':lang("fxm_ch_pass_05");
        $data['8']=(lang("fxm_ch_pass_06")=="")?'ForexMart Team':lang("fxm_ch_pass_06");


        $body .='
                        <h2 style="text-align: center;color: #2988CA;">
                         '.  $data['1'] .'
                         </h2>

                        <p class="greetings" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555">
                            '.$data['2'].' '.$_SESSION['full_name'].',
                        </p>

                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                            '.$data['3'].'
                         </p>

                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                            Account Number : '.$r_data['account_number'].' 
                         </p>

                         <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                            '.$data['4'].' : '.$r_data['new_password'].' <br/>
                        </p>

                        <p style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
                              '.$data['6'].'
                            <a href="#" style="margin: 0 auto;color: #2988ca;text-decoration: none;">support@forexmart.com</a>.
                        </p>
                        <br/>
                        <p class="closing" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; line-height: 19px">
                            <span style="margin: 0 auto; font-weight: 600; color: #2988ca">
                            '.$data['7'].'
                            </span>
                            <br/>
                            '.$data['8'].'
                        </p>
                    </div>';



        $body .= self::foot();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($r_data['Email'],$subject,$body,$from,$returnPath);
    }

    public function inactive_users($s_data){
        $r_data = array(
            'account_number' =>$s_data['account_number'],
            'Email' =>$s_data['Email'],
        );

        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $body = self::head();

        $subject = ' We have credited a Bonus to your account!';

        $body .='
                        <h2 style="text-align: center;color: #2988CA;">
                                 We have credited a Bonus to your account!
                         </h2>

                        <p class="greetings" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555">
                           Dear Client,
                        </p>
                          <br/>
                        <p class="greetings" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555">
                           Congratulations!
                        </p>
                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                            We have great news for you! Your account has been credited with $10 Mini bonus. With this you could trade immediately and test our platform.
                         </p>

                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                            Login -  '.$r_data['account_number'].' or   '.$r_data['Email'].'
                         </p>
  <br/>
                          <br/>
   <a href="https://my.forexmart.com/client/signin"><button type="button" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin: 0;font: inherit;color: #fff;overflow: visible;text-transform: none;-webkit-appearance: button;cursor: pointer;font-family: inherit;font-size: inherit;line-height: inherit;width: 184px;;border: none;padding: 10px 30px;background: #29a643;">
                              GO TO CABINET
                        </button></a>

                        <p style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
This is a wonderful opportunity to test our platform in real time without any investments. Profits can  be withdrawn immediately.
                        </p>

                          <p style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
To learn more information about mini-bonus, you could visit <a href="https://www.forexmart.com/no-deposit-bonus-agreement">here</a>. Please do not hesitate to contact us if you have any concerns or inquiries regarding your account or our services.
                        </p>
 <p style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
Thank you for staying with us. We wish you luck in Trading!
                        </p>
                        <br/>
                        <p class="closing" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; line-height: 19px">
                            <span style="margin: 0 auto; font-weight: 600; color: #2988ca">
                                 Truly yours
                            </span>
                            <br/>
                                ForexMart Team
                        </p>
                    </div>';

        $body .= self::foot();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        return  self::mysender($r_data['Email'],$subject,$body,$from,$returnPath);
    }

    public static function mysender($to, $subject, $message, $from, $returnpath){
      //  require_once dirname(__FILE__) . '/PHPMailer/class.phpmailer.php';
        $name = "ForexMart";
        $mail = new PHPMailer();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.mail.forexmart.com";
        $mail->Port = 25;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPDebug = 0;
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
    public function forgot_password_v2($forgot_details){
        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $dear = (lang('fxm_for_pass_02_v2')=='')? lang('fxm_for_pass_07'):lang('fxm_for_pass_02_v2') ;
        $email = (lang('fxm_for_pass_03_v2')=='')?lang('fxm_for_pass_08'):lang('fxm_for_pass_03_v2');
        $account_number = (lang('fxm_for_pass_04_v2')=='')?lang('fxm_for_pass_09'):lang('fxm_for_pass_04_v2');
        $subject = lang('fxm_for_pass_00');

        $body = self::head_scheduler();
        $body .= '<div style="margin-top: 3px;  padding-bottom: 30px;">';
        $body .= '<h2 style="font-family: Georgia, Times New Roman,serif;font-size: 22px;text-align: center;color: #2988CA;">'.lang('fxm_for_pass_01').'</h2>';
        $body .= '<label style="color: #000;font-size: 14px;float: left;margin-top: 30px;">'.$dear .' '.$forgot_details['full_name'].',</label>';
        $body .= '<p style="padding-top: 20px; line-height: 20px; font-size: 14px; clear: left;">';
        $body .= ' '.lang('fxm_for_pass_03').'<br/><br/>';
        $body .= ' '.lang('fxm_for_pass_04').'<br/><br/>';

        $body .= '<strong>'.$email. ':</strong>'.$forgot_details['Email'].'<br/>';
        $body .= '<strong>'.$account_number.':</strong>'.$forgot_details['Account_number'].'<br/><br/>';

        $body .= FXPP::loc_url('reset-password')."/".$forgot_details['Hash'].'<br/><br/>';
        $body .= '<br/>';
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">'.lang('fxm_for_pass_05').'</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">'.lang('fxm_for_pass_06').'</label>';
        $body .= '</div>';
        $body .= self::footer_scheduler();
        self::sender($forgot_details['Email'], $subject, $body, 'noreply@mail.forexmart.com', 'support@forexmart.com');
    }

    public static function custom_transit_transfer($data,$finance=1,$message='') {
        $body = self::head();
        $table = '';
        $display = $data['table'] == '' ? 0 : 1;

        if ($data['table'] != '') {
            foreach ($data['table'] as $key => $value) {
                $table .= "<tr>
                            <td style='font-weight: bold;width: 145px;'>" . $key . "</td>
                            <td>" . $value . "</td>
                          </tr>";
            }
        }

        $paragraph = $finance == 1? $data['paragraph'] :  '<p>'. $message.' </p><p style="font-weight: bold;">Please check the details are correct: </p>';

        $body .= "<h2 class='h1' style='margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-top: 5px;padding-bottom: 10px;padding-left: 15px;'>".$data['title']."</h2>
                <div class='wrapper-body' style='-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px; display: inline-block; width: 100%;'>"
                    . $paragraph .
                    "<table width='100%' cellpadding='3' cellspacing='0' border='0'>"
                        . $table .
                    '</table>
                    <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
        This letter was generated automatically and doesn’t require any response. <br>
        If you have any questions, please contact our <a href="https://www.forexmart.com/contact-us">support team</a>. 
      
        </p>


        <p class="closing" style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;line-height: 19px;">
        Sincerely, <br style="margin: 0 auto;">
            <span style="margin: 0 auto;font-weight: 600;color: #2988ca;">Automatic Notification Service.</span>
        </p>

                </div>';
        $body .= self::foot();

        return $body;
    }

    public static function custom_sendmail_support($data) {
        $body = self::head();

        $body .= "<h2 class='h1' style='margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-top: 5px;padding-bottom: 10px;padding-left: 15px;'>".$data['title']."</h2>
                  <div class='wrapper-body' style='-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px; display: inline-block; width: 100%;'>"
            . $data['paragraph'] .
            "</div>";
        $body .= self::foot();

        return $body;
    }

    public function ndb($s_data){

        $r_data = array(
            'account_number' => $s_data['account_number'],
            'Email' => $s_data['email'],
            'bonus' => $s_data['bonus'],
            'isUSDorEUR' => $s_data['isUSDorEUR'],
            'users_currency' => $s_data['users_currency'],
            'default_currency' => $s_data['default_currency'],
            'bonus_negligible_view' => $s_data['bonus_negligible_view']
        );

        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $body = self::head();

        $subject = ' We have credited a Bonus to your account!';
        if($r_data['isUSDorEUR']==true){
            $etc_ccy =' ';
        }else {
            $etc_ccy =' ('.$r_data['bonus_negligible_view'].' '.$r_data['default_currency'].') ';
        }

        $body .=' <h2 style="text-align: center;color: #2988CA;">
                      We have credited a Bonus to your account!
                  </h2>

                        <p class="greetings" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555">
                           Dear Client,
                        </p>
                          <br/>
                        <p class="greetings" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555">
                           Congratulations!
                        </p>
                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                            We have great news for you! Your account has been credited with '.$r_data['bonus'].' '.$r_data['users_currency'].' '.$etc_ccy.' bonus. With this you could trade immediately and test our platform.
                         </p>

                        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                            Login -  '.$r_data['account_number'].' or   '.$r_data['Email'].'
                         </p>
  <br/>
                          <br/>
   <a href="https://my.forexmart.com/client/signin"><button type="button" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin: 0;font: inherit;color: #fff;overflow: visible;text-transform: none;-webkit-appearance: button;cursor: pointer;font-family: inherit;font-size: inherit;line-height: inherit;width: 184px;;border: none;padding: 10px 30px;background: #29a643;">
                              GO TO CABINET
                        </button></a>

                        <p style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
This is a wonderful opportunity to test our platform in real time without any investments. Profits can  be withdrawn immediately.
                        </p>

                          <p style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
To learn more information about no deposit bonus, you could visit <a href="https://www.forexmart.com/no-deposit-bonus-agreement">here</a>. Please do not hesitate to contact us if you have any concerns or inquiries regarding your account or our services.
                        </p>
 <p style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
Thank you for staying with us. We wish you luck in Trading!
                        </p>
                        <br/>
                        <p class="closing" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; line-height: 19px">
                            <span style="margin: 0 auto; font-weight: 600; color: #2988ca">
                                 Truly yours
                            </span>
                            <br/>
                                ForexMart Team
                        </p>
                    </div>';

        $body .= self::foot();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        return  self::mysender($r_data['Email'],$subject,$body,$from,$returnPath);

    }
    public static function withdrawal_decline($withdraw_data){
        $subject = 'Declined Withdrawal [Account #: '.$withdraw_data['account_number'].']';
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        $body = self::head_withdraw_recall();
        $body .= '<div style="margin-bottom: 30px;">';
        $body .= '<label style="margin-top:20px; color: #5A5A5A;font-size: 14px;float: left;">Dear '.$withdraw_data['full_name'].',</label>';
        $body .= '<p style="padding-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">';
        $body .= "<p style='font-size: 14px; clear: left;color: #5A5A5A;text-align: justify;'>Your withdrawal request has been declined.</p>";
        $body .= "<p style='font-size: 14px; clear: left;color: #5A5A5A;text-align: justify;'>Account number: ".$withdraw_data['account_number']."</p>";
        $body .= "<p style='font-size: 14px; clear: left;color: #5A5A5A;text-align: justify;'>Amount requested: ".$withdraw_data['amount']." ".$withdraw_data['currency']."</p>";
        $body .= "<p style='font-size: 14px; clear: left;color: #5A5A5A;text-align: justify;'>Date requested: ".$withdraw_data['date_withdraw']."</p>";
        $body .= "<p style='font-size: 14px; clear: left;color: #5A5A5A;text-align: justify;'>Date declined: ".$withdraw_data['date_processed']."</p>";
        $body .= "<p style='font-size: 14px; clear: left;color: #5A5A5A;text-align: justify;'>Reason for decline: ".$withdraw_data['reason']."</p>";
        $body .= '</p>';
        $body .= '<label style="line-height: 20px; clear: left;color: #5A5A5A;text-align: justify; color: #5A5A5A;font-size: 14px;">Thank you for choosing ForexMart!</label>';
        $body .= '<label style="line-height: 20px; clear: left;color: #5A5A5A;text-align: justify; color: #5A5A5A;font-size: 14px;display: block;">ForexMart Team</label>';
        $body .= '</div>';
        $body .= self::foot_withdraw_recall();
        self::sender_recall($withdraw_data['email'], $subject, $body, $from, $returnPath);
    }
    public static function sender_recall($to, $subject, $message, $from, $returnpath,$bcc=null){
       // require_once dirname(__FILE__) . '/PHPMailer/class.phpmailer.php';
        $name = "ForexMart";
        $mail = new PHPMailer();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.mail.forexmart.com";
        $mail->Port = 25;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPDebug = 0;
        $mail->Username = "noreply@mail.forexmart.com";
        $mail->Password = "6!1PN%xpyJOE0i";
        if(!is_null($bcc)){
            $mail->AddBCC($bcc);
        }
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
    public static function head_withdraw_recall(){
        $body = '<html>
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    </head>
                    <body style="font-family: Helvetica Neue,Arial,sans-serif;">';
        $body .= '<div style="position: relative;width: 800px;margin: 0px auto;">';
        $body .= '<div style="background:#2988ca;padding:10px 0;width: auto;">';
        $body .= '<img style="margin-left: 10px;" src="https://www.forexmart.com/assets/images/new_email_header.png">';
        $body .= '</div>';
        $body .= '<div style="margin: 0 auto; padding: 15px; box-sizing: border-box; border-bottom: 1px solid #2988ca; padding-bottom: 60px;border-bottom: 1px solid #2988CA;padding-bottom: 20px;margin-top: 3px;border-top: 1px solid #2988CA;">';

        return $body;
    }
	
	
	
	
    public static function foot_withdraw_recall(){
        $body = '<div style="background:url(https://www.forexmart.com/assets/images/footer-bg.png); width:800px; margin-top:2px; height: 218px;border-top: 3px solid #EAEAEA;">';
        $body .= '<div style="width: 620px; float: left;">';
        
	 					
       
/*	    $body .= '<div><p><span style="font-weight: 600;color:#2988ca;">ForexMart</span> is a trading name of <img height="12" width="130" style="margin-bottom: 3px;vertical-align: middle" src="https://www.forexmart.com/assets/images/tradomart/instant-trading-eu-ltd.png">, a Cyprus Investment Firm regulated by the Cyprus Securities Exchange (CySEC) with license number 266/15.</p></div>';
		 */
		
	/*	 $body .= '<div><p><span style="font-weight: 600;color:#2988ca;">ForexMart</span> ForexMart brand is authorized and regulated in various jurisdictions.</p> <p>This website is operated by <b> Tradomart SV Ltd. </b> (Reg No.23071, IBC 2015) with registered address at Shamrock Lodge, Murray Road, Kingstown, Saint Vincent and the Grenadines. </p>   <p>Restricted Regions: <b>Tradomart SV Ltd</b> does not provide services for the residents of certain countries, such as the United States, North Korea, Iran, Myanmar, Cuba, Sudan, Syria and some other regions. </p>  </div>';*/
		
		
	    $body .= "<div><p><span style='font-weight: 600;color:#2988ca;'>ForexMart</span> brand is authorized and regulated in various jurisdictions.</p></div>";
		$body .= "<div><p>This website is operated by <b>Tradomart SV Ltd.</b> (Reg No.23071, IBC 2015) with registered address at Shamrock Lodge, Murray Road, Kingstown, Saint Vincent and the Grenadines.</p></div>";
		
		$body .= "<div><p>Restricted Regions: <b>Tradomart SV Ltd</b> does not provide services for the residents of certain countries, such as the United States, North Korea, Iran, Cuba, Sudan, Syria and some other regions.</p></div>";
		
		$body .= '<div><p style="color: #5a5a5a;text-align: justify;font-size: 13px;">
                        <span style="font-weight: 600; color: #FF0000;"> Risk Warning: </span>Foreign exchange is highly speculative and complex in nature, and may not be suitable for all investors. Forex trading may result into substantial gain or loss. Therefore, it is not advisable to invest money you cannot afford to lose. Before using the services offered by ForexMart, please acknowledge and understand the risks relative to forex trading. Seek independent financial advice if necessary. Please, note that neither past performance nor future forecasts constitute a reliable indicator of guaranteed results.</span></p></div>';
   
	   $body .= '<br><p>&copy; 2015 <img style="margin-bottom: 3px;vertical-align: middle" height="12" width="130" src="https://www.forexmart.com/assets/images/tradomart/instant-trading-eu-ltd.png"></p>';
		 
		 
        $body .= '</div>';
        $body .= '<div style="width: 180px;float: right;">';
        $body .= '<img width="124" height="76" src="https://www.forexmart.com/assets/images/cysec.png" style="width: auto;margin: 20px auto;display: block;">';
        $body .= '<img width="124" height="76" src="https://www.forexmart.com/assets/images/mifid.png" style="width: auto;margin: 20px auto;display: block;">';
        $body .= '</div>';
        $body .= '</div>';
        $body .= '</div></body></div>';
        return $body;
    }
    public static function refund_issue_ru($withdraw_data){
        $subject = 'Деньги были возвращены на ваш счет';
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        $body = self::head_withdraw_recall();
        $body .= '<div style="margin-bottom: 30px;">';
        $body .= '<label style="margin-top:20px; color: #5A5A5A;font-size: 14px;float: left;">Уважаемый Клиент,</label>';
        $body .= '<p style="padding-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">';
        $body .= "<p style='font-size: 14px; clear: left;color: #5A5A5A;text-align: justify;'>Информируем вас о том, что при заявке на вывод средств деньги были возвращены обратно на счет. Возврат средств производится для защиты торгового счета от онлайн-мошенничества, в основном, при использовании клиентом различных кошельков и платежных систем для пополнения счета и вывода средств. <br>
Для получения более подробной информации по этому вопросу, пожалуйста, свяжитесь с финансовым отделом ФорексМарт по электронному адресу: finance@forexmart.com. </p>";
        $body .= "<br><p style='font-size: 14px; clear: left;color: #5A5A5A;text-align: justify;'> Приносим извинения за доставленные неудобства.</p>";
        $body .= '</p>';
        $body .= '<label style="line-height: 20px; clear: left;color: #5A5A5A;text-align: justify; color: #5A5A5A;font-size: 14px;">С наилучшими пожеланиями,</label>';
        $body .= '<label style="line-height: 20px; clear: left;color: #5A5A5A;text-align: justify; color: #5A5A5A;font-size: 14px;display: block;">Команда ФорексМарт</label>';
        $body .= '</div>';
        $body .= self::foot_withdraw_recall();
        self::sender($withdraw_data['email'], $subject, $body, $from, $returnPath);
    }
    public static function refund_issue($withdraw_data){
        $subject = 'Money has been returned to your account';
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        $body = self::head_withdraw_recall();
        $body .= '<div style="margin-bottom: 30px;">';
        $body .= '<label style="margin-top:20px; color: #5A5A5A;font-size: 14px;float: left;">Dear Client,</label>';
        $body .= '<p style="padding-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">';
        $body .= "<p style='font-size: 14px; clear: left;color: #5A5A5A;text-align: justify;'>We would like to inform you that your request for withdrawal has been refunded. Refunds usually happen in order to protect your trading accounts from online fraud, and mostly, have a connection with clients using various wallets and payment systems when making deposits and withdrawals. For more details regarding this particular issue, kindly contact ForexMart’s finance department at finance@forexmart.com.</p>";

        $body .= "<br><p style='font-size: 14px; clear: left;color: #5A5A5A;text-align: justify;'> We would like to apologize for this inconvenience.</p>";
        $body .= '</p>';
        $body .= '<label style="line-height: 20px; clear: left;color: #5A5A5A;text-align: justify; color: #5A5A5A;font-size: 14px;">Best regards</label>';
        $body .= '<label style="line-height: 20px; clear: left;color: #5A5A5A;text-align: justify; color: #5A5A5A;font-size: 14px;display: block;">ForexMart Team</label>';
        $body .= '</div>';
        $body .= self::foot_withdraw_recall();
        self::sender($withdraw_data['email'], $subject, $body, $from, $returnPath);
    }

    public static function successfulSpanishUpload($to, $clientEmail, $uploadDetails) {
        $ci =& get_instance();

        $subject = "Signed Spanish Accept Risks Declaration";
        $link    = "https://my.forexmart.com/assets/user_docs/". $uploadDetails['uploaded_filename'];

        $body = self::head();
        $body .= "<div class='wrapper-body' style='-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box; margin-top: 3px;border-bottom: 1px solid #2988ca;padding-bottom: 20px;'>
                    <h2 class='h1' style='margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-top: 10px;margin-bottom: 30px;border-bottom: 1px solid #2988ca;padding-bottom: 10px;padding-left: 15px; text-align:center;'>Signed Spanish Accept Risks Declaration Request</h2>
                    <table cellspacing='0' cellpadding='4' border='0'>
                            <tr>
                                <td style='font-weight:bold; font-size:14px;'>Client Email:</td>
                                <td style='font-size:14px;'>$clientEmail</td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold; font-size:14px;'>Account Number:</td>
                                <td style='font-size:14px;'>{$uploadDetails['account_number']}</td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold; font-size:14px;'>Filename:</td>
                                <td style='font-size:14px;'><a href='$link'>{$uploadDetails['uploaded_filename']}</a></td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold; font-size:14px;'>Uploaded Date:</td>
                                <td style='font-size:14px;'>{$uploadDetails['uploaded_date']}</td>
                            </tr>
                        </table>
                </div>";

        

        Fx_mailer::senderInternal($to,$subject, $body);

    }



    public function forex_copy_deactivate($s_data){
        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $subject = 'Your participation in the  Copytrading system is over.';

        $userType = ($s_data['isTrader']) ? 'Trader' : 'Follower';

        $body = self::head_scheduler();
        $body .= '<div style="margin-top: 3px; border-top: 1px solid #2988CA; border-bottom: 1px solid #2988CA; padding-bottom: 30px;">';
        $body .= '<label style="color: #5A5A5A;font-size: 14px;float: left;margin-top: 20px;">Dear Client,</label>';
        $body .= '<label style="color: #5A5A5A;font-size: 14px;float: left;margin-top: 30px;">Your request to terminate the participation in the  Copytrading system as a  Copytrading '. $userType .' has been successfully processed.</label>';
        $body .= '<p style="font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">You can resume your participation in the  Copytrading system anytime.';
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">Sincerely yours,</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">ForexMart company </label>';
        $body .= '</div>';
        $body .= self::footer_scheduler();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($s_data['email'],$subject,$body,$from,$returnPath);
    }


    public function forex_copy_rolloverstatus($s_data){
        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $opt = ($s_data['type'] == 1) ? 'from manual to automatic.' : 'from automatic to manual.';
        $message = ($s_data['type'] == 1) ? 'The commission will be credited automatically every 1st of the month at 02:00 (GMT +2).' : 'To withdraw the commission received, go to my subscriptions page and use the corresponding button.';
        $subject = 'You have changed the rollover credits '.$opt;


        $body = self::head_scheduler();
        $body .= '<div style="margin-top: 3px; border-top: 1px solid #2988CA; border-bottom: 1px solid #2988CA; padding-bottom: 30px;">';
        $body .= '<label style="color: #5A5A5A;font-size: 14px;float: left;margin-top: 20px;">Dear Client,</label>';
        $body .= '<p style="font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">You have changed the rollover credits '.$opt.' <br> '.$message;
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">Sincerely yours,</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">ForexMart company </label>';
        $body .= '</div>';
        $body .= self::footer_scheduler();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($s_data['email'],$subject,$body,$from,$returnPath);
    }





    public function forex_copy_trader_subscribe($s_data){

        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $subject = 'The registration as a  Copytrading Trader has been successfully completed.';

        $body = self::head_scheduler();
        $body .= '<div style="margin-top: 3px; border-top: 1px solid #2988CA; border-bottom: 1px solid #2988CA; padding-bottom: 30px;">';
        $body .= '<label style="color: #5A5A5A;font-size: 14px;float: left;margin-top: 30px;">Dear Client,</label>';
        $body .= '<p style=" padding-top: 15px; margin-top: 30px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">The registration in the  Copytading system as a  Copytading Trader was successful. Now your trading account is added to the public monitoring list. The system of  Copytrading is fully automated.</a>';
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">Good luck in trading,</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">ForexMart company </label>';
        $body .= '</div>';
        $body .= self::footer_scheduler();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($s_data['email'],$subject,$body,$from,$returnPath);
    }


    public function forex_copy_follower_register($s_data){
        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $subject = 'The registration as a Copytrading Investor has been successfully completed.';

        $body = self::head_scheduler();
        $body .= '<div style="margin-top: 3px; border-top: 1px solid #2988CA; border-bottom: 1px solid #2988CA; padding-bottom: 30px;">';
        $body .= '<label style="color: #5A5A5A;font-size: 14px;float: left;margin-top: 30px;">Dear Client,</label>';
      
        $body.='<p style=" padding-top: 15px; margin-top: 30px; font-size: 14px; line-height:5px; clear: left;color: #5A5A5A;text-align: left;">Full Name : '.$s_data['full_name'].'</p>';
        $body.='<p style="font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: left;">Account Number : '.$s_data['account_number'].'</p>';
       
        $body .= '<p  style=" padding-top: 15px; margin-top:0px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">Your registration in the  Copytrading system as a Investor has been successful.
                       Now you can access to the monitoring list of Copytrading Traders and copying terms of providing their services.';
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">Good luck in trading,</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">ForexMart company </label>';
        $body .= '</div>';
        $body .= self::footer_scheduler();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($s_data['email'],$subject,$body,$from,$returnPath);

    }
    public function forex_copy_follower_subscribe($s_data){
        
        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $subject = 'Your subscription is activated!';

        $body = self::head_scheduler();
        $body .= '<div style="margin-top: 3px; border-top: 1px solid #2988CA; border-bottom: 1px solid #2988CA; padding-bottom: 30px;">';
        $body .= '<label style="color: #5A5A5A;font-size: 14px;float: left;margin-top: 30px;">Dear Client,</label>';
        $body .= '<p  style=" padding-top: 15px; margin-top: 30px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">We are glad to say that your subscription to the trading account of Copytrading trader ' . $s_data['trader_account'] . '
                has been successfully made.  Copying of the chosen trader’s orders will start automatically.';
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">Good luck in trading,</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">ForexMart company </label>';
        $body .= '</div>';
        $body .= self::footer_scheduler();
        
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        $res =  self::sender($s_data['email'],$subject,$body,$from,$returnPath);
        return $res;
    }

    public function forex_copy_follower_unsubscribe($s_data){

        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $subject = 'You have successfully unsubscribed from the account of Copytrading Trader '. $s_data['trader_account'];

        $body = self::head_scheduler();
        $body .= '<div style="margin-top: 3px; border-top: 1px solid #2988CA; border-bottom: 1px solid #2988CA; padding-bottom: 30px;">';
        $body .= '<label style="color: #5A5A5A;font-size: 14px;float: left;margin-top: 30px;">Dear Client,</label>';
        $body .= '<p style=" padding-top: 15px; margin-top: 30px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">We inform that your subscription to the trading account of Copytrading Trader <strong>' . $s_data['trader_account'] . '</strong> has been successfully canceled.
               If you decide to follow this or some other Copytrading Trader again, it can easily be done in the settings of your Profile.';
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">Good luck in trading,</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">ForexMart company </label>';
        $body .= '</div>';
        $body .= self::footer_scheduler();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        $res = self::sender($s_data['email'],$subject,$body,$from,$returnPath);
        return $res;
       
    }

    public function notify_subscribe_to_master($s_data){

        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $subject = 'You have a new follower!';

        $body = self::head_scheduler();
        $body .= '<div style="margin-top: 3px; border-top: 1px solid #2988CA; border-bottom: 1px solid #2988CA; padding-bottom: 30px;">';
        $body .= '<label style="color: #5A5A5A;font-size: 14px;float: left;margin-top: 30px;">Dear Client,</label>';
        $body .= '<p style=" padding-top: 15px; margin-top: 30px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">We inform you that a new follower account number '.$s_data['follower_account'].'  has been subscribed to your trading account aimed at copying your orders within the ForexMart Copytrading system. All the details you can see in your Profile.';
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">Good luck in trading,</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">ForexMart company </label>';
        $body .= '</div>';
        $body .= self::footer_scheduler();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($s_data['email'],$subject,$body,$from,$returnPath);
    }

    public function notify_unsubscribe_to_master($s_data){


        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $subject = 'The Follower ' .$s_data['follower_account'] . ' has unsubscribed from your trading account.';

        $body = self::head_scheduler();
        $body .= '<div style="margin-top: 3px; border-top: 1px solid #2988CA; border-bottom: 1px solid #2988CA; padding-bottom: 30px;">';
        $body .= '<label style="color: #5A5A5A;font-size: 14px;float: left;margin-top: 30px;">Dear Client,</label>';
        $body .= '<p  style=" padding-top: 15px; margin-top: 30px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">We inform you that the client <strong>'. $s_data['follower_account'] . '</strong>  has stopped to follow your trading account within the ForexMart Copytrading system and canceled the subscription.All the details you can see in your Profile.';
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">Good luck in trading,</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">ForexMart company </label>';
        $body .= '</div>';
        $body .= self::footer_scheduler();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($s_data['email'],$subject,$body,$from,$returnPath);
    }




    public function forex_smartdollar_request($s_data, $smart_data){
        $r_data = array(
            'email' => $s_data['email'],
        );

        $CI =& get_instance();
        $subject = 'You have created a request for crediting Smart Dollars';

        $body = self::head_scheduler_v3();
        $body .= '<div style="margin-top: 40px;">';
        $body .= '<h1 class="text-center" style="color: #06477b;font-weight: 500;text-align: center;margin-top: 30px;">You have created a request for crediting Smart Dollars</h1>';
        $body .= '<label style=" font-size: 14px;float: left;margin-top: 30px; margin-bottom:20px">Dear Client,</label>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">You clicked the <b>cash out</b> button, thereby creating a request for crediting ' . $smart_data['amount'] . ' <b>Smart Dollars</b> to your trading account.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">We remind you that within a month you need to trade '. $smart_data['lots_to_trade'] .'/10 lots, otherwise the request will not be executed.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">To see the detailed conditions and remaining number of lots, visit the special page:';
        $body .= '</p>';
        $body .= '</div>';
        $body .= self::foot_middle_v3();
        $body .= self::foot_scheduler_v3();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($r_data['email'],$subject,$body,$from,$returnPath);
    }

    public function forex_smartdollar_request_id($s_data, $smart_data){
        $r_data = array(
            'email' => $s_data['email'],
        );

        $CI =& get_instance();
        $subject = 'Anda telah membuat permintaan untuk kredit Smart Dollars';

        $body = self::head_scheduler_v3();
        $body .= '<div style="margin-top: 40px;">';
        $body .= '<h1 class="text-center" style="color: #06477b;font-weight: 500;text-align: center;margin-top: 30px;">Anda telah membuat permintaan untuk kredit Smart Dollars</h1>';
        $body .= '<label style=" font-size: 14px;float: left;margin-top: 30px; margin-bottom:20px">Klien yang terhormat,</label>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">Anda telah mengklik tombol <b>cash out</b>, membuat permintaan untuk kredit ' . $smart_data['amount'] . ' <b>Smart Dollars</b> ke akun trading Anda.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">Kami mengingatkan Anda bahwa dalam sebulan Anda harus melakukan trading '. $smart_data['lots_to_trade'] .'/10 lot, jika tidak maka permintaan tidak akan dieksekusi.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">Untuk melihat syarat terperinci dan jumlah lot yang tersisa, kunjungi halaman khusus:';
        $body .= '</p>';
        $body .= '</div>';
        $body .= self::foot_middle_v3();
        $body .= self::foot_scheduler_v3();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($r_data['email'],$subject,$body,$from,$returnPath);
    }

    public function forex_smartdollar_request_my($s_data, $smart_data){
        $r_data = array(
            'email' => $s_data['email'],
        );

        $CI =& get_instance();
        $subject = 'Anda telah membuat permintaan untuk mengkreditkan Dolar Pintar';

        $body = self::head_scheduler_v3();
        $body .= '<div style="margin-top: 40px;">';
        $body .= '<h1 class="text-center" style="color: #06477b;font-weight: 500;text-align: center;margin-top: 30px;">Anda telah membuat permintaan untuk mengkreditkan Dolar Pintar</h1>';
        $body .= '<label style=" font-size: 14px;float: left;margin-top: 30px; margin-bottom:20px">Pelanggan Yang Dihormati,</label>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">Anda perlu klik butang <b>pengeluaran duit</b>, dengan itu membuat permintaan untuk mengkreditkan ' . $smart_data['amount'] . ' <b>Dolar Pintar</b> ke akaun perdagangan anda.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">Kami mengingatkan anda bahawa dalam masa sebulan anda perlu menukar '. $smart_data['lots_to_trade'] .'/10 lot, jika tidak, permintaan tersebut tidak akan dilaksanakan.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">Untuk melihat keadaan terperinci dan jumlah lot yang tinggal, lawati halaman khas:';
        $body .= '</p>';
        $body .= '</div>';
        $body .= self::foot_middle_v3();
        $body .= self::foot_scheduler_v3();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($r_data['email'],$subject,$body,$from,$returnPath);
    }

    public function forex_smartdollar_complete($s_data){
        $r_data = array(
            'email' => $s_data['email'],
        );

        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $subject = 'Smart Dollars request has been completed.';

        $body = self::head_smart_dollar();
        $body .= '<div style="margin-top: 3px; border-top: 1px solid #2988CA; border-bottom: 1px solid #2988CA; padding-bottom: 30px;">';
        $body .= '<label style=" font-size: 14px;float: left;margin-top: 30px;">Dear Client,</label>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">Congratulations, your <b>Smart Dollars</b> request has been successfully completed.</a>';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">To get money visit your personal account. There you are to click on the <b>Withdraw</b> button opposite the completed application, after which the funds will automatically be credited to your account.</a>';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">If you have any questions, don\'t hesitate to contact our Support team.</a>';
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">We wish you a successful trading,</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">ForexMart team</label>';
        $body .= '</div>';
        $body .= self::footer_smart_dollar();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($r_data['email'],$subject,$body,$from,$returnPath);
    }

    public function forex_smartdollar_cancel($s_data, $smart_data){
        $r_data = array(
            'email' => $s_data['email'],
        );

        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $subject = 'Smart Dollars crediting request has been cancelled.';

        $body = self::head_smart_dollar();
        $body .= '<div style="margin-top: 3px; border-top: 1px solid #2988CA; border-bottom: 1px solid #2988CA; padding-bottom: 30px;">';
        $body .= '<label style="color: #5A5A5A;font-size: 14px;float: left;margin-top: 30px;">Dear Client,</label>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">Unfortunately, your request for crediting <b>Smart Dollars</b> has not been completed, because within the month since its creation you did not manage to trade the necessary number of lots.</a>';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">You can find detailed information on a special page in your account.</a>';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">You can create a new request at any time, but do not forget that for its completion it is necessary to trade ' . $smart_data['lots_to_trade'] . '/10 lots.</a>';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">If you still have questions, contact our Support team.</a>';
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">We wish you a successful trading,</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">ForexMart team</label>';
        $body .= '</div>';
        $body .= self::footer_smart_dollar();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($r_data['email'],$subject,$body,$from,$returnPath);
    }

    public function forex_smartdollar_reminder($s_data, $smart_data){
        $r_data = array(
            'email' => $s_data['email'],
        );

        $CI =& get_instance();
        $subject = 'Don’t forget to trade the required number of lots to receive Smart Dollars.';

        $body = self::head_smart_dollar();
        $body .= '<div style="margin-top: 3px; border-top: 1px solid #2988CA; border-bottom: 1px solid #2988CA; padding-bottom: 30px;">';
        $body .= '<label style="color: #5A5A5A;font-size: 14px;float: left;margin-top: 30px;">Dear Client,</label>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">We remind you, that only one week is left to process the request № '. $smart_data['ticket_number'] .' for crediting <b>Smart Dollars</b></a>.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">To complete the request and get the specified funds into your account, you have to trade '. $smart_data['lots_to_trade'] .' lots.</a>';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">You can find detailed information in your personal account. If you still have questions, contact our Support team.</a>';
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">We wish you a successful trading,</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">ForexMart team</label>';
        $body .= '</div>';
        $body .= self::footer_smart_dollar();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($r_data['email'],$subject,$body,$from,$returnPath);
    }

    public function forex_smartdollar_month($s_data, $smart_data){
        $r_data = array(
            'email' => $s_data['email'],
        );

        $CI =& get_instance();
        $subject = 'How many Smart Dollars have you earned per month?';

        $body = self::head_smart_dollar();
        $body .= '<div style="margin-top: 3px; border-top: 1px solid #2988CA; border-bottom: 1px solid #2988CA; padding-bottom: 30px;">';
        $body .= '<label style="color: #5A5A5A;font-size: 14px;float: left;margin-top: 30px;">Dear Client,</label>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">For the period of '. $smart_data['start_date'] .' to '. $smart_data['end_date'] .', you created '. $smart_data['number_cashout_requests'] .' requests for the overall amount of '. $smart_data['total_number_cashout_requests'] .' <b>Smart Dollars</b>.</a>';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">During the reporting period, you made '. $smart_data['number_trades'] .' trading operations with a total volume of '. $smart_data['total_lots'] .' lots, having received Z real dollars in your trading account.</a>';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">You currently have '. $smart_data['number_expired_cashout'] .' uncompleted requests totaling '. $smart_data['total_number_expired_cashout'] .' <b>Smart Dollars</b></a>.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left;color: #5A5A5A;text-align: justify;">You can find detailed information in your personal account. If something is not clear to you, ask our Support team a question.</a>';
        $body .= '</p>';
        $body .= '<label style="color: #000;font-size: 14px;">We wish you a successful trading,</label>';
        $body .= '<label style="color: #000;font-size: 14px;display: block;">ForexMart team</label>';
        $body .= '</div>';
        $body .= self::footer_smart_dollar();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($r_data['email'],$subject,$body,$from,$returnPath);
    }

    public function forex_smartdollar_loyal($s_data, $smart_data){
        $r_data = array(
            'email' => $s_data['email'],
        );

        $CI =& get_instance();
        $subject = 'Your status in the Smart Dollars loyalty program has been increased';

        $body = self::head_scheduler_v3();
        $body .= '<div style="margin-top: 40px;">';
        $body .= '<h1 class="text-center" style="color: #06477b;font-weight: 500;text-align: center;margin-top: 30px;">Your status in the Smart Dollars loyalty program has been increased</h1>';
        $body .= '<label style=" font-size: 14px;float: left;margin-top: 30px; margin-bottom:20px">Dear Client,</label>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">Congratulations, your status in the loyalty program has been upgraded to ' . $smart_data['account_level'] . '. Now for each traded lot you will receive ' . $smart_data['account_level_pip'] .' <b>Smart Dollars</b></a>.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">Since the beginning of participation in the program, you have already traded ' . $smart_data['account_level_lot'] . ' lots and earned ' . $smart_data['amount'] . ' <b>Smart Dollars</b>, of which you have successfully transferred to your trading account.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">See detailed statistics of requests in your personal account.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">To upgrade your status up to the next stage, you have to trade ' . $smart_data['next_level_lot'] . ' lots.';
        $body .= '</p>';
        $body .= '</div>';
        $body .= self::foot_middle_v3();
        $body .= self::foot_scheduler_v3();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($r_data['email'],$subject,$body,$from,$returnPath);
    }

    public function forex_smartdollar_loyal_id($s_data, $smart_data){
        $r_data = array(
            'email' => $s_data['email'],
        );

        $CI =& get_instance();
        $subject = 'Status Anda di program loyalitas Smart Dollars telah ditingkatkan';

        $body = self::head_scheduler_v3();
        $body .= '<div style="margin-top: 40px;">';
        $body .= '<h1 class="text-center" style="color: #06477b;font-weight: 500;text-align: center;margin-top: 30px;">Status Anda di program loyalitas Smart Dollars telah ditingkatkan</h1>';
        $body .= '<label style=" font-size: 14px;float: left;margin-top: 30px; margin-bottom:20px">Klien yang terhormat,</label>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">Selamat, status Anda dalam program loyalitas telah ditingkatkan ke ' . $smart_data['account_level'] . '. Kini, untuksetiap lot yang diperdagangkan, Anda akan menerima ' . $smart_data['account_level_pip'] .' <b>Smart Dollars</b></a>.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">Sejak awal partisipasi dalam program ini, Anda telah memperdagangkan ' . $smart_data['account_level_lot'] . ' lot dan mendapatkan ' . $smart_data['amount'] . ' <b>Smart Dollars</b>, dengan telah berhasil Anda transfer ke akun trading Anda.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">Lihat rincian statistik permintaan di akun pribadi Anda.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">Untuk meningkatkan status Anda ke tahap berikutnya, Anda harus memperdagangkan ' . $smart_data['next_level_lot'] . ' lot.';
        $body .= '</p>';
        $body .= '</div>';
        $body .= self::foot_middle_v3();
        $body .= self::foot_scheduler_v3();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($r_data['email'],$subject,$body,$from,$returnPath);
    }

    public function forex_smartdollar_loyal_my($s_data, $smart_data){
        $r_data = array(
            'email' => $s_data['email'],
        );

        $CI =& get_instance();
        $subject = 'Status anda dalam program kesetiaan Dolar Pintar telah di naik taraf';

        $body = self::head_scheduler_v3();
        $body .= '<div style="margin-top: 40px;">';
        $body .= '<h1 class="text-center" style="color: #06477b;font-weight: 500;text-align: center;margin-top: 30px;">Status anda dalam program kesetiaan Dolar Pintar telah di naik taraf</h1>';
        $body .= '<label style=" font-size: 14px;float: left;margin-top: 30px; margin-bottom:20px">Pelanggan Yang Dihormati,</label>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">Tahniah, status anda dalam program kesetiaan telah di naik taraf menjadi ' . $smart_data['account_level'] . '. Sekarang untuk setiap lot yang diperdagangkan, anda akan menerima ' . $smart_data['account_level_pip'] .' <b>Dolar Pintar</b></a>.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">Sejak awal penyertaan dalam program ini, anda telah memperdagangkan ' . $smart_data['account_level_lot'] . ' lot dan memperoleh ' . $smart_data['amount'] . ' <b>Dolar Pintar</b>, di mana anda berjaya memindahkan ke akaun perdagangan anda.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">Lihat statistik permintaan terperinci di akaun peribadi anda.';
        $body .= '</p>';
        $body .= '<p style=" padding-top: 5px; margin-top: 10px; font-size: 14px; line-height: 20px; clear: left; text-align: justify;">Untuk menaik taraf status anda ke peringkat seterusnya, anda perlu menjual ' . $smart_data['next_level_lot'] . ' lot.';
        $body .= '</p>';
        $body .= '</div>';
        $body .= self::foot_middle_v3();
        $body .= self::foot_scheduler_v3();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        self::sender($r_data['email'],$subject,$body,$from,$returnPath);
    }

    public static function registration_data($data) {
        $ci =& get_instance();
        $body = self::hederInternal();
        $subject = 'Registration Report';
        $body .= "<div class='wrapper-body' style='-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px; display: inline-block'>
                    <h2 class='h1' style='margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-top: 30px;margin-bottom: 30px;border-bottom: 1px solid #2988ca;padding-bottom: 10px;padding-left: 15px;'>Registration Report</h2>
                    <table cellspacing='0' border='1'>
                        <tr>
                            <td style='font-weight: bold'>Full Name</td>
                            <td>".$data['full_name']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Email</td>
                            <td>".$data['email']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Registration Date</td>
                            <td>".$data['registration_date']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Country</td>
                            <td>".$data['country']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Status</td>
                            <td>".$data['status']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Step/Internal</td>
                            <td>".$data['step']."</td>
                        </tr>
                    </table>
                </div>";

       

       

        Fx_mailer::senderInternal('webpage@forexmart.com',$subject, $body);

    }


    public static function copytradeReport($data) {

        $body = self::hederInternal();
        $body .= "<div class='wrapper-body' style='-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px; display: inline-block'>
                    <h2 class='h1' style='margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-top: 30px;margin-bottom: 30px;border-bottom: 1px solid #2988ca;padding-bottom: 10px;padding-left: 15px;'>Copytrading Report</h2>
                    <table cellspacing='0' border='1'>
                       <tr>
                            <td style='font-weight: bold'>Account Number</td>
                            <td>".$data['account_number']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Full Name</td>
                            <td>".$data['full_name']."</td>
                        </tr>
                   
                        <tr>
                            <td style='font-weight: bold'>Report Date</td>
                            <td>".$data['report_date']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Action</td>
                            <td>".$data['action']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Error</td>
                            <td>".$data['error']."</td>
                        </tr>
                       
                    </table>
                </div>";






        $subject = 'Copytrading  Report';

        $to  = 'webpage@forexmart.com';
        $bcc =  'jimmy@forexmart.com';


        self::senderInternal($to, $subject, $body,$bcc);

        self::senderInternal('jayhens.snow@gmail.com', $subject, $body,''); 

    }

    public static function testAPI($data){

        $subject = $data['subject'];

        $body = self::head_scheduler_v3();
        $body .= $subject['body'];
        $body .= self::foot_middle_v3();
        $body .= self::foot_scheduler_v3();

        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";

        self::sender($data['email'],$subject,$body,$from,$returnPath);
    }

    
      public static function validateEmail($from, $email)
    {
        require_once dirname(__FILE__) . '/PHPMailer/smtp-validate-email.php';

        $validator = new SMTP_Validate_Email($email, $from);
        $smtp_results = $validator->validate();
        // var_dump($smtp_results);exit;
        return $smtp_results;
    }
     
    public static function FMsender($to, $subject, $message)
    {
      //  require_once dirname(__FILE__) . '/PHPMailer/class.phpmailer.php';
        $name = "ForexMart";
        $mail = new PHPMailer();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.mail.forexmart.com";
        $mail->Port = 25;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPDebug = false;
        $mail->Hostname = 'forexmart.com';
        $mail->Username = "noreply@mail.forexmart.com";
        $mail->Password = "6!1PN%xpyJOE0i";
        $mail->AddReplyTo("noreply@mail.forexmart.com", $name);
        $mail->SetFrom("noreply@mail.forexmart.com", $name);
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        $mail->AddAddress($to);



        if (!$mail->Send()) {
            return $mail->ErrorInfo;
        } else {
            return true;
        }

    }

    public static function pending_deposit_with_issues($data, $email) {
        $ci =& get_instance();

        $body = self::head();
        $subject = 'Pending Deposit ('.$data['account_number'].')';

        $body .= "<div class='wrapper-body' style='-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;padding-bottom: 20px; display: inline-block;width: 100%;'>
                    <h2 class='h1' style='margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-bottom: 30px;border-bottom: 1px solid #2988ca;padding-bottom: 10px;padding-left: 15px;'>Pending Deposit (" . $data['account_number'] . ")</h2>
                    <center>
                    <table cellspacing='0' border='1'>
                        <tr>
                            <td style='font-weight: bold'>Account number</td>
                            <td>".$data['account_number']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Date of transaction</td>
                            <td>".$data['time']."</td>
                        </tr>                 
                        <tr>
                            <td style='font-weight: bold'>Amount</td>
                            <td>".$data['amount']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Payment System</td>
                            <td>".$data['payment_type']."</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold'>Transaction Id</td>
                            <td>".$data['transaction_id']."</td>
                        </tr>
                    </table>
                    </center>
                </div>";
        $body .= self::foot();

        self::FMsender($email, $subject, $body);
    }

}