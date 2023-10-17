<link href="<?= $this->template->Css()?>view-searchlocation.css" rel="stylesheet">
<?php  $this->lang->load('Search'); ?>
<?php
$description="";
$domain_www = $this->config->item('domain-www');
$domain_my = $this->config->item('domain-my');
$uri='';
$array = array(
    //external
    // ABOUT
    array(
        lang('s_1-a').'
         <span class="display-n">'.
        lang('s_1-b').
            '</span>'
    ,lang('s_1-b')
    ,$domain_www
    ,'home')
,array(
        lang('s_2-a').'
        <span class="display-n">'.
        lang('s_2-b').
            '</span>'
    ,lang('s_2-b')
    ,$domain_www
    ,'about-us')
,array(
        lang('s_3-a').'
     <span class="display-n">'.
        lang('s_3-b').
            '</span>'
    ,lang('s_3-b')
    ,$domain_www
    ,'company-news'),
    array(
        lang('s_4-a').'
 <span class="display-n">'.
        lang('s_4-b').
            '</span>'
    ,lang('s_4-b')
    ,$domain_www
    ,'why-choose-us')
,array(
        lang('s_5-a').'
 <span class="display-n">'.
        lang('s_5-b').
            '</span>'
    ,lang('s_5-b')
    ,$domain_www
    ,'deposit-withdraw-page')
,array(
        lang('s_6-a').'
 <span class="display-n">'.
        lang('s_6-b').
            '</span>'
    ,lang('s_6-b')
    ,$domain_www
    ,'licence-and-regulations')
,array(
        lang('s_7-a').'
 <span class="display-n">'.
        lang('s_7-b').
            '</span>'
    ,lang('s_7-b')
    ,$domain_www
    ,'account-verification')
,array(
        lang('s_8-a').'
 <span class="display-n">'.
        lang('s_8-b').
            '</span>'
    ,lang('s_8-b')
    ,$domain_www
    ,'las-palmas')
    //FOREX account types
,array(
        lang('s_9-a').'
     <span class="display-n">'.
        lang('s_9-b').
            '</span>'
    ,lang('s_9-b')
    ,$domain_www
    ,'account-type')
    //FOREX account types demo
,array(
        lang('s_10-a').'
 <span class="display-n">'.
        lang('s_10-b').
            '</span>'
    ,lang('s_10-b')
    ,$domain_www
    ,'demo-account')
    //FOREX account types  ForexMart Standard
,array(
        lang('s_11-a').'
 <span class="display-n">'.
        lang('s_11-b').
            '</span>'
    ,lang('s_11-b')
    ,$domain_www
    ,'live-account')
    //FOREX account types  ForexZero Spread
,array(
        lang('s_12-a').'
 <span class="display-n">'.
        lang('s_12-b').
            '</span>'
    ,lang('s_12-b')
    ,$domain_www
    ,'live-account')
    //FOREX Trading Platforms
,array(
        lang('s_13-a').'
    <span class="display-n">'.
        lang('s_13-b').
            '</span>'
    ,lang('s_13-b')
    ,$domain_www
    ,'metatrader4')
    //FOREX Instruments  forex
,array(
        lang('s_14-a').'
 <span class="display-n">'.
        lang('s_14-b').
            '</span>'
    ,lang('s_14-b')
    ,$domain_www
    ,'financial-instruments/forex')
    //FOREX Instruments  shares
,array(
        lang('s_15-a').'
 <span class="display-n">'.
        lang('s_15-b').
            '</span>'
    ,lang('s_15-b')
    ,$domain_www
    ,'financial-instruments/shares')
    //FOREX Instruments Spot Metals
,array(
        lang('s_16-a').'
 <span class="display-n">'.
        lang('s_16-b').
            '</span>'
    ,lang('s_16-b')
    ,$domain_www
    ,'financial-instruments/spots')
    //BONUS AND OFFERS
,array(
        lang('s_17-a').'
 <span class="display-n">'.
        lang('s_17-b').
            '</span>'
    ,lang('s_17-b')
    ,$domain_www
    ,/* 'bonuses' */ )
    //BONUS AND OFFERS Welcome Bonus 30%
,array(
        lang('s_18-a').'
 <span class="display-n">'.
        lang('s_18-b').
            '</span>'
    ,lang('s_18-b')
    ,$domain_www
    ,'thirty-percent-bonus')

    //BONUS AND OFFERS No Deposit Bonus
,array(
        lang('s_19-a').'
 <span class="display-n">'.
        lang('s_19-b').
            '</span>'
    ,lang('s_19-b')
    ,$domain_www
    ,'no-deposit-bonus')

    //Partnership

    //Partnership Affiliate Program
,array(
        lang('s_20-a').'
 <span class="display-n">'.
        lang('s_20-b').
            '</span>'
    ,lang('s_20-b')
    ,$domain_www
    ,/* 'partnership/advantages' */ )
,array(
        lang('s_21-a').'
 <span class="display-n">'.
        lang('s_21-b').
            '</span>'
    ,lang('s_21-b')
    ,$domain_www
    ,'affiliate-link')
,array(
        lang('s_22-a').'
 <span class="display-n">'.
        lang('s_22-b').
            '</span>'
    ,lang('s_22-b')
    ,$domain_www
    ,'commission-specification')

    //Partnership Types of Partnership
    //Friend Referral
,array(
        lang('s_23-a').'
 <span class="display-n">'.
        lang('s_23-b').
            '</span>'
    ,lang('s_23-b')
    ,$domain_www
    ,'partnership/friend-referrer')
    //Webmaster
,array(
        lang('s_24-a').'
 <span class="display-n">'.
        lang('s_24-b').
            '</span>'
    ,lang('s_24-b')
    ,$domain_www
    ,'partnership/webmaster')
    //Online Partner
,array(
        lang('s_25-a').'
 <span class="display-n">'.
        lang('s_25-b').
            '</span>'
    ,lang('s_25-b')
    ,$domain_www
    ,'partnership/online-partner')
    //Local online partner
,array(
        lang('s_26-a').'
   <span class="display-n">'.
        lang('s_26-b').
            '</span>'
    ,lang('s_26-b')
    ,$domain_www
    ,'local-online-partner')
    //Local office partner
,array(
        lang('s_27-a').'
 <span class="display-n">'.
        lang('s_27-b').
            '</span>'
    ,lang('s_27-b')
    ,$domain_www
    ,'partnership/local-office-partner')
    //Partnership Partnership registration
,array(
        lang('s_28-a').'
   <span class="display-n">'.
        lang('s_28-b').
            '</span>'
    ,lang('s_28-b')
    ,$domain_www
    ,'partnership/friend-referrer')
    //Partnership Materials
,array(
        lang('s_29-a').'
    <span class="display-n">'.
        lang('s_29-b').
            '</span>'
    ,lang('s_29-b')
    ,$domain_www
    ,'banners')
,array(
        lang('s_30-a').'
 <span class="display-n">'.
        lang('s_30-b').
            '</span>'
    ,lang('s_30-b')
    ,$domain_www
    ,'banners')
    //CONTEST
    //registration
,array(
        lang('s_31-a').'
 <span class="display-n">'.
        lang('s_31-b').
            '</span>'
    ,lang('s_31-b')
    ,$domain_www
    ,'money-fall')
    //CONTEST
    //Ratings
,array(
        lang('s_32-a').'
 <span class="display-n">'.
        lang('s_32-b').
            '</span>'
    ,lang('s_32-b')
    ,$domain_www
    ,'contest/ratings')
    //CONTEST
    //Winners
,array(
        lang('s_33-a').'
 <span class="display-n">'.
        lang('s_33-b').
            '</span>'
    ,lang('s_33-b')
    ,$domain_www
    ,'contest/winners')
    //CONTEST
    //Contest Rules
,array(
        lang('s_34-a').'
 <span class="display-n">'.
        lang('s_34-b').
            '</span>'
    ,lang('s_34-b')
    ,$domain_www
    ,'contest/contest-rules')
    //TOOLS
    //Free VPS Hosting
,array(
        lang('s_35-a').'
 <span class="display-n">'.
        lang('s_35-b').
            '</span>'
    ,lang('s_35-b')
    ,$domain_www
    ,'vps-hosting')
    //TOOLS
    //Forex Chart
,array(
        lang('s_36-a').'
 <span class="display-n">'.
        lang('s_36-b').
            '</span>'
    ,lang('s_36-b')
    ,$domain_www
    ,'forex-charts')

    //SUPPORT
    // Contact us
,array(
        lang('s_37-a').'
     <span class="display-n">'.
        lang('s_37-b').
            '</span>'
    ,lang('s_37-b')
    ,$domain_www
    ,'contact-us')
    //SUPPORT
    // FAQ
,array(
        lang('s_38-a').'
 <span class="display-n">'.
        lang('s_38-b').
            '</span>'
    ,lang('s_38-b')
    ,$domain_www
    ,'faq')
    //SUPPORT
    // Forex Glossary
,array(
        lang('s_39-a').'
 <span class="display-n">'.
        lang('s_39-b').
            '</span>'
    ,lang('s_39-b')
    ,$domain_www
    ,'')
    //SUPPORT
    // Legal Dcoumentation
,array(
        lang('s_40-a').'
 <span class="display-n">'.
        lang('s_40-b').
            '</span>'
    ,lang('s_40-b')
    ,$domain_www
    ,'legal-documentation')
,array(
        lang('s_41-a').'
  <span class="display-n">'.
        lang('s_41-b').
            '</span>'
    ,lang('s_41-b')
    ,$domain_www
    ,'Live-Account')
,array(
        lang('s_42-a').'
    <span class="display-n">'.
        lang('s_42-b').
            '</span>'
    ,lang('s_42-b')
    ,$domain_www
    ,'Privacy-Policy')
,array(
        lang('s_43-a').'
 <span class="display-n">'.
        lang('s_43-b').
            '</span>'
    ,lang('s_43-b')
    ,$domain_www
    ,'Risk-Disclosure')
,array(
        lang('s_44-a').'
 <span class="display-n">'.
        lang('s_44-b').
            '</span>'
    ,lang('s_44-b')
    ,$domain_www
    ,'Terms-and-Conditions')
,array(
        lang('s_45-a').'
 <span class="display-n">'.
        lang('s_45-b').
            '</span>'
    ,lang('s_45-b')
    ,$domain_www
    ,'best-execution-policy')
,array(
        lang('s_46-a').'
 <span class="display-n">'.
        lang('s_46-b').
            '</span>'
    ,lang('s_46-b')
    ,$domain_www
    ,'complaint-handling-procedure')
,array(
        lang('s_47-a').'
 <span class="display-n">'.
        lang('s_47-b').
            '</span>'
    ,lang('s_47-b')
    ,$domain_www
    ,'conflict-of-interest-policy')
,array(
        lang('s_48-a').'
   <span class="display-n">'.
        lang('s_48-b').
            '</span>'
    ,lang('s_48-b')
    ,$domain_www
    ,'customer-categorisation')
,array(
        lang('s_49-a').'
 <span class="display-n">'.
        lang('s_49-b').
            '</span>'
    ,lang('s_49-b')
    ,$domain_www
    ,'investor-compensation-fund')
,array(
        lang('s_50-a').'
    <span class="display-n">'.
        lang('s_50-b').
            '</span>'
    ,lang('s_50-b')
    ,$domain_www
    ,'services')
,array(
        lang('s_51-a').'
 <span class="display-n">'.
        lang('s_51-b').
            '</span>'
    ,lang('s_51-b')
    ,$domain_www
    ,'terms-of-use')

    //internal

,array(
        lang('s_52-a').'
   <span class="display-n">'.
        lang('s_52-b').
            '</span>'
    ,lang('s_52-b')
    ,$domain_my
    ,'accounts')
    //side nav My Account
,array(
        lang('s_53-a').'
        <span class="display-n">'.
        lang('s_53-b').
            '</span>'
    ,lang('s_53-b')
    ,$domain_my
    ,'accounts/register')
,array(
        lang('s_54-a').'
    <span class="display-n">'.
        lang('s_54-b').
            '</span>'
    ,lang('s_54-b')
    ,$domain_my
    ,'my-account/current-trades')
,array(
        lang('s_55-a').'
 <span class="display-n">'.
        lang('s_55-b').
            '</span>'
    ,lang('s_55-b')
    ,$domain_my
    ,'my-account/current-trades')
,array(
        lang('s_56-a').'
 <span class="display-n">'.
        lang('s_56-b').
            '</span>'
    ,lang('s_56-b')
    ,$domain_my
    ,'my-account/forex-calculator')
    //side nav My Profile
,array(
        lang('s_57-a').'
  <span class="display-n">'.
        lang('s_57-b').
            '</span>'
    ,lang('s_57-b')
    ,$domain_my
    ,'profile/edit')
,array(
        lang('s_58-a').'
  <span class="display-n">'.
        lang('s_58-b').
            '</span>'
    ,lang('s_58-b')
    ,$domain_my
    ,'profile/change-password')
,array(
        lang('s_59-a').'
    <span class="display-n">'.
        lang('s_59-b').
            '</span>'
    ,lang('s_59-b')
    ,$domain_my
    ,'profile/upload-documents')
//,array(
//        lang('s_60-a').'
//         <label class="display-n">'.
//        lang('s_60-b').
//     '</span>'
//    ,lang('s_60-b')
//    ,$domain_my
//    ,/* 'profile/platform-access' */ )
//
//    //side nav Finance

,array(
        lang('s_61-a').'
 <span class="display-n">'.
        lang('s_61-b').
            '</span>'
    ,lang('s_61-b')
    ,$domain_my
    ,'deposit')

,array(
        lang('s_62-a').'
 <span class="display-n">'.
        lang('s_62-b').
            '</span>'
    ,lang('s_62-b')
    ,$domain_my
    ,'withdraw')

,array(
        lang('s_63-a').'
 <span class="display-n">'.
        lang('s_63-b').
            '</span>'
    ,lang('s_63-b')
    ,$domain_my
    ,'transfer')

,array(
        lang('s_64-a').'
 <span class="display-n">'.
        lang('s_64-b').
            '</span>'
    ,lang('s_64-b')
    ,$domain_my
    ,'transaction-history')

    //side nav Bonus

,array(
        lang('s_65-a').'
 <span class="display-n">'.
        lang('s_65-b').
            '</span>'
    ,lang('s_65-b')
    ,$domain_my
    ,'bonus/bonuses')
,array(
        lang('s_66-a').'
 <span class="display-n">'.
        lang('s_66-b').
            '</span>'
    ,lang('s_66-b')
    ,$domain_my
    ,'bonus/bonuses'),

    //side nav Partnertship
    array(
        lang('s_67-a').'
 <span class="display-n">'.
        lang('s_67-b').
            '</span>'
    ,lang('s_67-b')
    ,$domain_my
    ,'partnership/commission')
,array(
        lang('s_68-a').'
 <span class="display-n">'.
        lang('s_68-b').
            '</span>'
    ,lang('s_68-b')
    ,$domain_my
    ,'partnership/clicks')
,array(
        lang('s_69-a').'
 <span class="display-n">'.
        lang('s_69-b').
            '</span>'
    ,lang('s_69-b')
    ,$domain_my
    ,'withdraw')
,array(
        lang('s_70-a').'
 <span class="display-n">'.
        lang('s_70-b').
            '</span>'
    ,lang('s_70-b')
    ,$domain_my
    ,'partnership/referrals')
,array(
        lang('s_71-a').'
 <span class="display-n">'.
        lang('s_71-b').
            '</span>'
    ,lang('s_71-b')
    ,'www'
    ,'las-juva')
,array(
        lang('s_72-a').'
 <span class="display-n">'.
        lang('s_72-b').
            '</span>'
    ,lang('s_72-b')
    ,'www'
    ,'deposit-insurance')
,array(
        lang('s_73-a').'
 <span class="display-n">'.
        lang('s_73-b').
            '</span>'
    ,lang('s_73-b')
    ,'www'
    ,'awards')
,array(
        lang('s_74-a').'
 <span class="display-n">'.
        lang('s_74-b').
            '</span>'
    ,lang('s_74-b')
    ,'www'
    ,'account-type')
,array(
        lang('s_75-a').'
 <span class="display-n">'.
        lang('s_75-b').
            '</span>'
    ,lang('s_75-b')
    ,'www'
    ,'tiket-raffle')
,array(
        lang('s_76-a').'
 <span class="display-n">'.
        lang('s_76-b').
            '</span>'
    ,lang('s_76-b')
    ,'www'
    ,'partnership/cpa')
,array(
        lang('s_77-a').'
 <span class="display-n">'.
        lang('s_77-b').
            '</span>'
    ,lang('s_77-b')
    ,'www'
    ,/* 'logos'*/ )
,array(
        lang('s_78-a').'
 <span class="display-n">'.
        lang('s_78-b').
            '</span>'
    ,lang('s_78-b')
    ,'www'
    ,'currency-conversion')
,array(
        lang('s_79-a').'
 <span class="display-n">'.
        lang('s_79-b').
            '</span>'
    ,lang('s_79-b')
    ,'www'
    ,'forex-calculator')
,array(
        lang('s_80-a').'
 <span class="display-n">'.
        lang('s_80-b').
            '</span>'
    ,lang('s_80-b')
    ,'www'
    ,'how-to-get-started')
//,array(
//        lang('s_81-a').'
//       <span class="display-n">'.
//        lang('s_81-b').
//       '</span>'
//    ,lang('s_81-b')
//    ,'www'
//    ,'call back')
,array(
        lang('s_82-a').'
 <span class="display-n">'.
        lang('s_82-b').
            '</span>'
    ,lang('s_82-b')
    ,$domain_my
    ,'client/signin')
,array(
        lang('s_83-a').'
 <span class="display-n">'.
        lang('s_83-b').
            '</span>'
    ,lang('s_83-b')
    ,$domain_my
    ,'partner/signin')
,array(
        lang('s_83x-a').'
 <span class="display-n">'.
        lang('s_83x-b').
            '</span>'
    ,lang('s_83x-b')
    ,$domain_my
    ,'forgot-password')
,array(
        lang('s_84-a').'
 <span class="display-n">'.
        lang('s_84-b').
            '</span>'
    ,lang('s_84-b')
    ,$domain_my
    ,'profile/sms_security')
,array(
        lang('s_85-a').'
 <span class="display-n">'.
        lang('s_85-b').
            '</span>'
    ,lang('s_85-b')
    ,$domain_my
    ,'deposit/bank-transfer')
,array(
        lang('s_86-a').'
 <span class="display-n">'.
        lang('s_86-b').
            '</span>'
    ,lang('s_86-b')
    ,$domain_my
    ,'deposit/debit-credit-cards')
,array(
        lang('s_87-a').'
 <span class="display-n">'.
        lang('s_87-b').
            '</span>'
    ,lang('s_87-b')
    ,$domain_my
    ,'deposit/skrill')
,array(
        lang('s_88-a').'
   <span class="display-n">'.
        lang('s_88-b').
            '</span>'
    ,lang('s_88-b')
    ,$domain_my
    ,'deposit/neteller')
,array(
        lang('s_89-a').'
 <span class="display-n">'.
        lang('s_89-b').
            '</span>'
    ,lang('s_89-b')
    ,$domain_my
    ,'deposit/paxum')
,array(
        lang('s_89-a').'
 <span class="display-n">'.
        lang('s_89-b').
            '</span>'
    ,lang('s_89-b')
    ,$domain_my
    ,'deposit/webmoney')
,array(
        lang('s_90-a').'
    <span class="display-n">'.
        lang('s_90-b').
            '</span>'
    ,lang('s_90-b')
    ,$domain_my
    ,'deposit/paypal')
,array(
        lang('s_91-a').'
    <span class="display-n">'.
        lang('s_91-b').
            '</span>'
    ,lang('s_91-b')
    ,$domain_my
    ,'deposit/hipay')
,array(
        lang('s_92-a').'
       <span class="display-n">'.
        lang('s_92-b').
            '</span>'
    ,lang('s_92-b')
    ,$domain_my
    ,'deposit/payco')
,array(
        lang('s_93-a').'
 <span class="display-n">'.
        lang('s_93-b').
            '</span>'
    ,lang('s_93-b')
    ,$domain_my
    ,'deposit/sofort')
//,array(
//        lang('s_94-a').'
//        <span class="display-n">'.
//        lang('s_94-b').
//      '</span>''
//    ,lang('s_94-b')
//    ,$domain_my
//    /*,'deposit/yandexMoney' */ )
,array(
        lang('s_95-a').'
     <span class="display-n">'.
        lang('s_95-b').
            '</span>'
    ,lang('s_95-b')
    ,$domain_my
    ,'deposit/qiWi')
//,array(
//        lang('s_96-a').'
//         <span class="display-n">'.
//        lang('s_96-b').
//        '</span>'
//    ,lang('s_96-b')
//    ,$domain_my
//        /* ,'deposit/paymill'*/)
//,array(
//        lang('s_97-a').'
//         <span class="display-n">'.
//        lang('s_97-b').
//   '</span>'
//    ,lang('s_97-b')
//    ,$domain_my
//   /* ,'deposit/payments' */ )
,array(
        lang('s_98-a').'
        <span class="display-n">'.
        lang('s_98-b').
            '</span>'
    ,lang('s_98-b')
    ,$domain_my
    ,'deposit/megatransfer')
,array(
        lang('s_99-a').'
        <span class="display-n">'.
        lang('s_99-b').
            '</span>'
    ,lang('s_99-b')
    ,$domain_my
    ,'transfer')
,array(
        lang('s_100-a').'
      <span class="display-n">'.
        lang('s_100-b').
            '</span>'
    ,lang('s_100-b')
    ,$domain_my
    ,'invite-friend/invite-by-email')
,array(
        lang('s_101-a').'
       <span class="display-n">'.
        lang('s_101-b').
            '</span>'
    ,lang('s_101-b')
    ,$domain_my
    ,'invite-friend/my-friends')
,array(
        lang('s_102-a').'
         <span class="display-n">'.
        lang('s_102-b').
            '</span>'
    ,lang('s_102-b')
    ,$domain_my
    ,'invite-friend/statistics')
,array(
        lang('s_103-a').'
     <span class="display-n">'.
        lang('s_103-b').
            '</span>'
    ,lang('s_103-b')
    ,$domain_my
    ,'mail-support/compose')
,array(
        lang('s_104-a').'
   <span class="display-n">'.
        lang('s_104-b').
            '</span>'
    ,lang('s_104-b')
    ,$domain_my
    ,'mail-support/my-mail')
,array(
        lang('s_105-a').'
 <span class="display-n">'.
        lang('s_105-b').
            '</span>'
    ,lang('s_105-b')
    ,$domain_my
    ,'rebate-system')
,array(
        lang('s_106-a').'
        <span class="display-n">'.
        lang('s_106-b').
            '</span>'
    ,lang('s_106-b')
    ,$domain_my
    ,'rebate-system/personal-rebate')
,array(
        lang('s_107-a').'
          <span class="display-n">'.
        lang('s_107-b').
            '</span>'
    ,lang('s_107-b')
    ,$domain_my
    ,'rebate-system/statistics')
,array(
        lang('s_108-a').'
      <span class="display-n">'.
        lang('s_108-b').
            '</span>'
    ,lang('s_108-b')
    ,$domain_my
    ,'withdraw/debit-credit-cards')
,array(
        lang('s_109-a').'
    <span class="display-n">'.
        lang('s_109-b').
            '</span>'
    ,lang('s_109-b')
    ,$domain_my
    ,'withdraw/skrill')
,array(
        lang('s_110-a').'
       <span class="display-n">'.
        lang('s_110-b').
            '</span>'
    ,lang('s_110-b')
    ,$domain_my
    ,'withdraw/neteller')
,array(
        lang('s_111-a').'
     <span class="display-n">'.
        lang('s_111-b').
            '</span>'
    ,lang('s_111-b')
    ,$domain_my
    ,'withdraw/paxum')

,array(
        lang('s_112-a').'
    <span class="display-n">'.
        lang('s_112-b').
        '</span>'
    ,lang('s_112-b')
    ,$domain_my
    ,'withdraw/paypal')
);




$content='';
foreach ($array as $key => $value) {
    $content .= ' <li class="specificwidth">';
    $content .= '<a target="_blank" href="'.$value[2].'/'.$value[3].'" class="question" aria-expanded="false" >'.$value[0].'</a>';
    $content .= ' <p class="answer" >';
    $content .= ' '. $value[1].' ';
    $content .= ' </p>';
    $content .= '</li>';
}
?>

<div id="searchloc" class="reg-form-holder" style="display: none">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <h1 class="license-title col-md-8">Search Results</h1>

                </div>
                <div class="qa-holder">
                    <ul class="list">
                        <?= $content ?>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>