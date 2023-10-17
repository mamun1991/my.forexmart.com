<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/



//  Profile - TFA Security
$route['two-step-authentication'] = 'two-step-authentication';
$route['two-step-authentication/verify'] = 'two-step-authentication/verify';




if(in_array($_SERVER['SERVER_ADDR'], array('136.243.104.88','148.251.122.78'))){
 


        if (strstr($_SERVER['HTTP_HOST'], 'www.forexmart.com') or strstr($_SERVER['HTTP_HOST'], 'localhost') or strstr($_SERVER['HTTP_HOST'], 's-www.forexmart.com') ) {
            //var_dump($_SERVER['HTTP_HOST']);
            $route['profile/(:any)'] = '';
            $route['accounts/(:any)'] = '';
            $route['transactions/(:any)'] = '';
            $route['deposit/(:any)'] = '';
            $route['copytrade/(:any)'] = '';
            $route['forexcopy/(:any)'] = '';
            $route['profile/platform-access'] = 'profile/platform_access';
        }else {
        //My Profile
            $route['profile/company-details'] = 'profile/companyDetails';
            $route['profile/corporate-info-save']='profile/corporate_info_save';
            $route['profile/change-password'] = 'profile/change_password';
            $route['profile/change-password-v2'] = 'profile/change_password_v2'; //testing phase
            $route['profile/upload-documents'] = 'profile/upload_documents';
           // $route['(^(en|jp|ru|id|de|fr|it|sa|es|pt|sk|pl|pk|my|cz)\/)?profile/upload-documents-for-corporate-account'] = 'profile/upload_documents_for_corporate';
            $route["(^(en|jp|ru|id|de|fr|it|sa|es|pt|sk|pl|pk|my|bg|bd|cs|vn)\/)?profile/upload-documents-for-corporate-account"] = 'profile/upload_documents_for_corporate';
            $route['profile/platform-access'] = 'profile/platform_access';

        // under Accounts
            //deposits
        //    $route['my-account/open-demo-account'] = 'accounts/open_demo_account';
        //    $route['my-account/open-trading-account'] = 'accounts/open_trading_account';
            $route['deposit/paysera-canceled'] = 'deposit/paysera_canceled';
            $route['deposit/webmoney-canceled'] = 'deposit/webmoney_canceled';
            $route['(^(en|jp|ru|id|de|fr|it|sa|es|pt|sk|pl|pk|gr|my|bg|cs|zh|bd|vn)\/)?deposit/bank-transfer'] = 'deposit/bankTransfer';
            $route['deposit/megatransfer-credit-card-fail'] = 'deposit/megatransfer_creditcard_fail';
            $route['deposit/megatransfer-credit-card-success'] = 'deposit/megatransfer_creditcard_success';
            //withdraw
            $route['withdraw/bank-transfer'] = 'withdraw/bankTransfer';

        }



}else{
    
           // $route['profile/(:any)'] = '';
            $route['accounts/(:any)'] = '';
            $route['transactions/(:any)'] = '';
            $route['deposit/(:any)'] = '';
            $route['copytrade/(:any)'] = '';
            $route['forexcopy/(:any)'] = '';
            $route['profile/platform-access'] = 'profile/platform_access';
       
}


$route["copytrade/my-followers"] = 'CopyTrade/my_followers';

//$route["my-accounts"] = "accounts";
$route['default_controller'] = 'client';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

//$route['client/signin'] = 'signin';
//$route['partner/signin'] = 'partner';

$route['withdraw-funds'] = 'Home/withdraw_funds';
//$route['profile/platform-access'] = 'profile/platform_access';

/**external top navigation */

$route["why-choose-us"] = "Pages/whychooseus";
$route["licence-and-regulations"] = "Pages/licenceandregulations";
$route["contact-us"] = "Pages/contactus";
$route["faq"] = "Pages/faq";
$route["about-us"] = "Pages/AboutUs";

$route["Demo-Account"] = "Pages/demoaccounts";
$route["Live-Account"] = "Pages/liveaccounts";


/**external top navigation */

/**external footer */

$route["risk-disclosure"] = "Pages/RiskDisclosure";
$route["privacy-policy"] = "Pages/PrivacyPolicy";
$route["terms-and-conditions"] = "Pages/TermsandConditions";
$route["Partners"] = "Pages/Partners";

$route["company-news"] = "Pages/companynews";

$route["MetaTrader4"] = "Pages/forexmartmt4";
//$route["MetaTrader5"] = "Pages/forexmartmt5";

$route["Financial-Instruments"] = "Pages/instruments";
$route["Financial-Instruments/forex"] = "Pages/forex";
$route["Financial-Instruments/spots"] = "Pages/spotmetals";
$route["Financial-Instruments/futures"] = "Pages/futures";
$route["Financial-Instruments/shares"] = "Pages/shares";


$route['partnership/affiliate-custom-link'] = 'Partnership/affiliate_custom_link';

/**external footer */

/**feedback internal and external */

//$route["feedback"] = "Pages/feedback";
$route["(^(en|jp|ru|id|de|fr|it|sa|es|pt|sk|pl|pk|gr|my|bg|cs|zh|bd|vn)\/)?feedback"] = "Pages/feedback";
$route["feedback-email"] = "Pages/FeedbackSendEmail";
$route["deposit-withdraw-page"] = "Pages/DepositWithdraw";

/**feedback internal and external */

/**administration internal and external */
$route["administration-news"] = "Administration/News";
$route["administration-feedback"] = "Administration/Feedback";
$route["administration-useraccess"] = "Administration/Access";
/**administration internal and external */

/** Account Tab*/
//$route["my-account"] = "Accounts";
//$route["my-account/current-trades"] = "Accounts/current_trades";
//$route["my-account/history-of-trades"] = "Accounts/history_of_trades";
//$route["my-account/forex-calculator"] = "Accounts/forex_calculator";
//$route["my-account/vps"] = "Accounts/vps";
//$route["forex-calculator"] = "pages/calculator";
//$route["my-account/pending-orders"] = "Accounts/pendingOrders";



/** Finance Page */
//$route["transaction-history"] = "Transaction_history";

$prepended_lang = "(?:[a-zA-Z]{2}/)?";
$appended_lang  = "(?:[a-zA-Z]{2}/?)?";
$lang = "([a-zA-Z]{2}/)?";

/** Bonus Tab */
//$route['bonus/bonuses-statistic'] = 'bonus/bonuses_statistic';
//$route['bonuses'] = 'bonus/bonuses';

/** Invite a friend  Tab */

$route['invite-friend'] ="invite_friend/inviteByEmail";
$route['invite-friend/invite-by-email'] ="invite_friend/inviteByEmail";
$route['invite-friend/my-friends'] ="invite_friend/myFriends";
$route['invite-friend/statistics'] ="invite_friend/statistics";

//** Reset Password */

$route['forgot-password/reset-password'] = 'forgot_password/reset_password/$1';
$route["reset-password/(:any)"] = "Forgot_password/reset_password/$1";
$route["forgot-password"] = "Forgot_password";



 $route['(\w{2})/reset-password/(:any)'] = "Forgot_password/reset_password/$1";


/**Partnership page */

$route["partnership/extra-commission"] = "partnership/extra_commission";
$route["partnership/second-affiliates"] = "partnership/second_affiliates";
$route['(\w{2})/(.*)'] = '$2';
$route['(\w{2})'] = $route['default_controller'];

/** Mail Support */
$route["mail-support/my-mail"] = 'mail_support/my_mail';
$route["mail-support/compose"] = 'mail_support/compose';
$route["mail-support/mail"] = 'mail_support/mail';
//$route["mail-support/sent"] = 'mail_support/sent';

$route["deposit-limited-bonus"] = 'deposit/forexmart_limited_bonus';

$route["test-deposit-page"] = 'deposit/depositPage';

$route["ru/terms-and-conditions"] = 'Cabinet/terms_condition';
$route["get-trades"] = 'My_account/getTrades';
$route["deposit/debit-credit-cards"] = 'deposit/debit_credit_cards';





