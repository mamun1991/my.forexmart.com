<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/PHPMailer/class.phpmailer.php';
require_once dirname(__FILE__) . '/PHPMailer/class.smtp.php';

class Fxpp_email {

    function __construct(){
        FXPP::CI()->lang->load('FxMailer');
    }
    public static function NewestHeader()
    {
        $body = '<html>
                <head>

                </head>
                <body style="font-family: Helvetica Neue,Arial,sans-serif; font-size: 14px;line-height: 1.42857143; color: #333;background-color: #fff;">';
        $body .= '<div style="position: relative; margin: 0px auto;max-width: 800px;height: auto;">';
        $body .= '<div style="margin: 0 auto; width:100%;padding: 0!important">';
        $body .= '<div style="background:url(https://www.forexmart.com/assets/images/header-bg.png); width:100%!important; margin-top:2px; ;border-top: 3px solid #EAEAEA;">';
        $body .= '<img style="width:100%!important;" alt="mailing_v2-header" src="https://www.forexmart.com/assets/images/new_email_header.png">';
        $body .= '</div>';
        return $body;
    }

    public static function NewestFoooter($unsubscribe_key=false)
    {
        $body = '<div style="background:url(https://www.forexmart.com/assets/images/univ-bg-footer2.png);padding: 20px; padding-top: 5px;position: relative;border-top: 1px solid #002036;">';
        $body .= "<div style='padding: 0;width: 100%;float: none;display: block;'>";
        $body .= '<p style="line-height: 15px;color: #656565;font-size: 13px;text-align:justify;"><span style="font-weight: bold;color: #ff0000;">Risk Warning:</span> Foreign exchange is highly speculative and complex in nature, and may not be suitable for all investors. Forex trading may result to substantial gain or loss. Therefore, it is not advisable to invest money you cannot afford to lose. Before using the services offered by ForexMart, please acknowledge and understand the risks relative to forex trading. Seek financial advice, if necessary.';
        $body .= '<br><br>ForexMart is official partner of Las Palmas.';
        $body .= '<br><br><span style="font-weight: bold;color: #2988ca;">ForexMart</span> is the trading name of <img style="margin-bottom: 3px;vertical-align: middle;border: 0;" src="https://www.forexmart.com/assets/images/tradomart-ltd-small-black.png" width="101" height="10" alt="tradomart-ltd-small-black"> , a Cyprus based Investment Firm regulated by the Cyprus Securities Exchange (CySEC) with license number 266/15.';
        $body .= '<br><br><span style="font-weight: bold;color: #2988ca;">ForexMart</span> was awarded by ShowFx World as the Best Broker in Europe 2015 and Most Perspective Broker in Asia 2015.';
        $body .= '<br><br>International Finance Magazine (IFM) awarded ForexMart as "Best New Broker Europe 2016"';
        $body .= '<br><br>© 2015 - 2016 <img style="margin-bottom: 3px;vertical-align: middle;border: 0;" src="https://www.forexmart.com/assets/images/tradomart-ltd-small-black.png" width="101" height="10" alt="tradomart-ltd-small-black">';
        $body .= '</p>';
        $body .= '</div>';
        $body .= '<div style="width: 100%;float: none!important;display: table;margin: 0 auto;">
            <div style="margin: 0 auto;">
              <div style="width: 16.66%;float: left;display: table;">
                <a href="https://www.forexmart.com/cysec"><img src="https://www.forexmart.com/assets/images/mailer/cysec.png" alt="cysec" style="max-width: 80%;display: table;margin: 0 auto;"></a>
              </div>
              <div style="width: 16.66%;float: left;display: table;">
                <a href="https://www.forexmart.com/fca"><img src="https://www.forexmart.com/assets/images/mailer/fca.png" alt="fca" style="max-width: 80%;display: table;margin: 0 auto;"></a>
              </div>
              <div style="width: 16.66%;float: left;display: table;">
                <a href="https://www.forexmart.com/amf"><img src="https://www.forexmart.com/assets/images/mailer/autorite.png" alt="autorite" style="max-width: 80%;display: table;margin: 0 auto;"><a/>
              </div>
            </div>
              <div style="margin: 0 auto;">
              <div style="width: 16.66%;float: left;display: table;">
                <a href="https://ec.europa.eu/finance/securities/isd/mifid/index_en.htm"><img src="https://www.forexmart.com/assets/images/mailer/mifid.png" style="max-width: 80%;display: table;margin: 0 auto;" alt="mifid"></a>
              </div>
              <div style="width: 16.66%;float: left;display: table;">
                <a href="https://www.forexmart.com/bafin"><img src="https://www.forexmart.com/assets/images/mailer/bafin.png" style="max-width: 80%;display: table;margin: 0 auto;" alt="bafin"></a>
              </div>
              <div style="width: 16.66%;float: left;display: table;">
                <a href="https://www.forexmart.com/consob"><img src="https://www.forexmart.com/assets/images/mailer/consob.png" style="max-width: 80%;display: table;margin: 0 auto;" alt="consob"></a>
              </div>
            </div>
            </div>
          </div>';
        $body .= "</html>";
        return $body;
    }

    public static function ndb($s_data){

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
        $body = self::NewestHeader();
        //        $body = self::head();

        $subject = ' We have credited a Bonus to your account!';
        if($r_data['isUSDorEUR']==true){
            $etc_ccy =' ';
        }else {
            $etc_ccy =' ('.$r_data['bonus_negligible_view'].' '.$r_data['default_currency'].') ';
        }

        $body .=' <h2 style="text-align: center;color: #2988CA;">We have credited a Bonus to your account!</h2>
                    <p class="greetings" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555">
                       Dear Client,
                    </p>
                      <br/>
                    <p class="greetings" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555">
                       Congratulations!
                    </p>
                    <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                        Your account has been credited with '.$r_data['bonus'].' '.$r_data['users_currency'].' '.$etc_ccy.' Bonus which you can use to start trading immediately.
                     </p>

                    <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
                        Login -  '.$r_data['account_number'].' or   '.$r_data['Email'].'
                     </p>
  <br/>
                          <br/>
   <a href="https://my.forexmart.com/client/signin"><button type="button" style="width: 222px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin: 0;font: inherit;color: #fff;overflow: visible;text-transform: none;-webkit-appearance: button;cursor: pointer;font-family: inherit;font-size: inherit;line-height: inherit;border: none;padding: 10px 30px;background: #29a643;">
                           Go to cabinet
                        </button></a>
<br/>
<br/>
   <a href="https://webtrader.forexmart.com/login"><button type="button" style="width: 222px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin: 0;font: inherit;color: #fff;overflow: visible;text-transform: none;-webkit-appearance: button;cursor: pointer;font-family: inherit;font-size: inherit;line-height: inherit;border: none;padding: 10px 30px;background: #29a643;">
                           Login to Web Terminal
                        </button></a>
<br/>
<br/>
<a href="https://download.mql5.com/cdn/web/tradomart.ltd/mt4/forexmart4setup.exe"><button type="button" style="width: 222px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin: 0;font: inherit;color: #fff;overflow: visible;text-transform: none;-webkit-appearance: button;cursor: pointer;font-family: inherit;font-size: inherit;line-height: inherit;border: none;padding: 10px 30px;background: #29a643;">
                             Download MT4
                        </button></a>

                        <p style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
This is a wonderful opportunity to test our platform in real time without any investments.
                        </p>

 <p style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
   To learn more information about "No Deposit Bonus", click <a href="https://www.forexmart.com/no-deposit-bonus-agreement">here</a>.
 </p>
 <p style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
        Please do not hesitate to contact us if you have any concerns or inquiries regarding your account or our services.
 </p>
 <p style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
   We wish you luck in Trading!
                        </p>
                        <br/>
                        <p class="closing" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; line-height: 19px">
                            <span style="margin: 0 auto; font-weight: 600; color: #2988ca">
                                 Truly yours
                            </span>
                            <br/>
                                ForexMart Team
                        </p>
                        <br/>
                        <br/>
                    </div>';

        $body .= self::NewestFoooter();
        //$body .= self::foot();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        return  self::mysender($r_data['Email'],$subject,$body,$from,$returnPath);
    }



     public static function ct_subscribe($s_data){
        $r_data = array(
            'email' => $s_data['email'],
        );
        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $body = self::NewestHeader();
        $subject = 'Copytrade subscription is activated!';

        $body .='
        <br/>
        <br/>
        <h2 style="text-align: center;color: #2988CA;"></h2>
        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
            Dear client,
        </p>
        <br/>
       <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
            Welcome!
        </p>
        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
           &nbsp;&nbsp;&nbsp;
           &nbsp;&nbsp;&nbsp;
           You are now subscribed to ForexMart’s CopyTrade service. Your account will automatically copy trades in real time from the best players in ForexMart. It is primarily designed to provide an alternative method for traders to established their trades guided by an actual strategy that was proven to be profitable over time. You can enjoy the following benefits:
        </p>
        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  - &nbsp;make your trading experience easier and hassle-free.
        </p>
        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  - &nbsp;gives you more opportunities
        </p>
        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  - &nbsp;Increase revenue by investing on skills of experienced traders
        </p>
        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  - &nbsp;Manage risks efficiently and limit potential losses
        </p>
        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
            If you have any questions, you can reach our customer support at support@forexmart.com to know more about CopyTrade and other services. You are also free to unsubscribe at any time, just visit our page  <a href="'.FXPP::loc_url('copytrade').'">here</a>.
        </p>
        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
           Thank you for subscribing! We look forward to a successful working relationship in the future.
        </p>

        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: right; line-height: 19px">
            <span style="margin: 0 auto; font-weight: 600; color: #2988ca">
               Warmest regards,
            </span>
            <br/>
                ForexMart team &nbsp;&nbsp;
        </p>
            <br/>
            <br/>
        </div>';

        $body .= self::NewestFoooter();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        return  self::mysender($r_data['email'],$subject,$body,$from,$returnPath);
    }

    public static function ct_unsubscribe($s_data){

        $r_data = array(
            'email' => $s_data['email'],
            'AN' => $s_data['AN'],
            'MAN' => $s_data['MAN']
        );

        $CI =& get_instance();
        $CI->lang->load('FxMailer');
        $body = self::NewestHeader();
        $subject = 'Your CopyTrade subscription is stopped!';

        $body .='
        <br/>
        <br/>
        <h2 style="text-align: center;color: #2988CA;"></h2>
        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
          Dear client,
        </p>
        <br/>
       <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
        Greetings!
        </p>
        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
            This is to inform you that your CopyTrade subscription has been stopped.
             We received your request to cancel the subscription under the <strong>'.$r_data['AN'].'</strong> to <strong>'.$r_data['MAN'].'</strong>.
        </p>
        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
            Should you wish to continue the CopyTrade subscription, you may reapply by visiting this <a href="'.FXPP::loc_url('copytrade').'">page</a>. However, there are underlying conditions that we require to resubscribe.
            To know more, you may read all the terms and conditions indicated <a href="'.FXPP::loc_url('copytrade#link-copytrade').'">here</a>.
        </p>
        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
            If you have other concerns, you could reach our customer support at support@forexmart.com and we will gladly assist you.
        </p>
         <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: justify; line-height: 19px">
             We are eagerly waiting to work with you again. Thank you very much!
        </p>

        <p class="letter-body" style="margin: 0 auto; font-size: 14px; font-family: Arial; font-weight: 400; color: #555; margin-top: 15px; text-align: right; line-height: 19px">
            <span style="margin: 0 auto; font-weight: 600; color: #2988ca">
               Sincerely yours,
            </span>
            <br/>
                ForexMart team &nbsp;&nbsp;
        </p>
            <br/>
            <br/>
        </div>';

        $body .= self::NewestFoooter();
        $returnPath = "noreply@mail.forexmart.com";
        $from = "noreply@mail.forexmart.com";
        return  self::mysender($r_data['email'],$subject,$body,$from,$returnPath);
    }





    public static function mysender($to, $subject, $message, $from, $returnpath){
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
}