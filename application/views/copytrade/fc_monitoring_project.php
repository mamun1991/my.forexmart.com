<style>
    .bal-eq-title{
        float:left;
    }

    .tooltip-help
    {
        width: 24px;
        height: 16px;
    
        display: inline-block;
        text-decoration: none;
        vertical-align: middle;
    }
    .table>thead {
        color: #fff;
        background-color: #373739;
    }

    .tooltip-help2
    {
        width: 17px;
        height: 17px;
       
        display: inline-block;
        text-decoration: none;
        vertical-align: middle;
    }
    
     .w100 td
     {
         line-height: 170% !important;
     }
    #advanced_settings_select div.selector{
        width: 163px;

    }
    #advanced_settings_select div.selector span{
        width: 120px;

    }
    #advanced_settings_select div.selector select{
        width: 160px;

    }



    @media only screen and (min-width: 0px)  and (max-width: 767px) {
        .chart-nav>li>a {
            margin-top: 12px;
        }
    }


    /*Modal*/
    .modal-custom{
        /*min-height: 100%;*/
        /*position: absolute;*/
        /*top: 0;*/
        /*width: 100%;*/
        /*left: 0;*/
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
    }
    .modal-custom .modal-content{
        padding: 15px;
        line-height: 1.5;
    }
    .modal-custom .modal-header, .modal-custom .modal-footer{
        border:0;
        padding:0;
    }
    .modal-custom .close{
        /*position: absolute;*/
        top: 10px;
        right: 10px;
        color: red;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 1px solid red;
    }
    .modal-custom .modal-footer{
        text-align:center;
    }
    .img-center{
        display: block;
        margin:0 auto;
    }
    .img-info-modal{
        width:auto;
        height: 86px;
    }
    .btn-form{
        min-width: 150px;
        height:40px;
        letter-spacing: 1px;
    }


</style>
<div class="section">

    <h1><?= lang('trd_136'); ?><span id="trader-proj-name"><?= $project; ?></span> <?= lang('trd_137'); ?></h1>
    <div class="acct-tab-holder">
        <ul role="tablist" class="main-tab">
			<li>
                    <a  href="<?=FXPP::my_url('copytrade')?>" id = "tab1"><?= lang('sb_li_12'); ?></a>
                </li>
   
                <li>
                    <a href="<?=FXPP::my_url('copytrade/my_subscription')?>" id = "tab2" ><?= lang('trd_74'); ?></a>
                </li>
                 
            <?php
            $active = $hide_subscription ? 'active' : '';
            if(FXPP::getCopytradeType() == 1){
                
                
                ?>
                <li class="<?= $active ?>">
                    <a href="<?=FXPP::my_url('copytrade/my_project')?>" id = "tab3" ><?= lang('trd_75'); ?></a>
                </li>
            <?php } ?>
                <li>
                    <a  href="<?=FXPP::my_url('copytrade/profile')?>" id = "tab4" ><?= lang('trd_76'); ?></a>
                </li>
                <li>
                    <a  href="<?=FXPP::my_url('copytrade/recommended-accounts')?>" id = "tab5" ><?= lang('trd_77'); ?></a>
                </li>
            <div class="clearfix"></div>
    </div>
   <div class="option_form" style="padding-top: 15px;">

    <div class=" spec-msg-pp">

        <h3 class="header-trader-inf" style="border: 0 !important"><?= lang('trd_138'); ?></h3>
        <p> <?php if(empty($fc_details['language_desc'])){ echo lang('trd_139');}else{ echo $fc_details['language_desc'];} ?></p>
        <div class="clearfix"></div>

        <div class="trader-settings copying_trade_terms">
            <h3><?= lang('trd_140'); ?></h3>
            <table cellpadding="0" cellspacing="0" class="table table_main table-striped simple-wnd">
                <tbody><tr class="commission_copier_payer">
                    <td class="right" style="width: 50%">
                        <?= lang('trd_141'); ?>  <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="Commission a Copytrading follower pays for every copied trade. It should not exceed the profit a follower gains from the trading of a Copytrading trader"></i>
                    </td>
                    <td style="padding-bottom: 9px;"><?=  $trader_data['conditions_values_1'] ? $copytermsDisplay : lang('trd_113'); ?></td>
                </tr>
                <tr class="commission_copier_payer">
                    <td class="right" style="width: 50%">
                        <?= lang('trd_142'); ?>  <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="Commission to be paid by a Follower for 0.01 lots of each trade closed with profit"></i>
                    </td>
                    <td style="padding-bottom: 9px;"><?=  $trader_data['conditions_values_2'] ? $copytermsDisplay : lang('trd_113'); ?> </td>
                </tr>
                <tr class="commission_copier_payer">
                    <td class="right" style="width: 50%">
                        <?= lang('trd_115'); ?> <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="Commission paid by a Copytrading follower for 0.01 lot of all copied trades, both profitable and losing ones. The amount of the commission can exceed the profit a follower gains from the trading of a Copytrading trader"></i>
                    </td>
                    <td style="padding-bottom: 9px;"><?=  $trader_data['conditions_values_10'] ? $copytermsDisplay : lang('trd_113'); ?> </td>
                </tr>
                <tr class="commission_copier_payer">
                    <td class="right" style="width: 50%">
                        <?= lang('trd_116'); ?>   <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="Profit share (%) to be paid by the Copytrading follower subsribed to this project"></i>
                    </td>
                    <td style="padding-bottom: 9px;">  <?=  $trader_data['conditions_values_3'] ? $copytermsDisplay : lang('trd_113'); ?>   </td>
                </tr>
                <tr class="commission_copier_payer">
                    <td class="right" style="width: 50%">
                        <?= lang('trd_117'); ?>   <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="A daily commission credited to the Trader’s account at the end of every day except Forex days off.
            As soon as the Follower applies for a subscription to the Trader’s orders and chooses a daily commission as a payment method, the system checks the Follower’s account for meeting the following requirements:
 - Amount of real funds shall be ten times larger than the daily commission amount set by the Trader;
 - Real funds exclude bonuses;
 - Real funds include only free margin.
 If the Follower fails to meet one or several requirements, the subscription request will be canceled.
On a subscription date Daily commission is paid only for the followers who subcribed before 18:00."></i>
                    </td>
                    <td style="padding-bottom: 9px;">  <?= $trader_data['conditions_values_4'] ? $copytermsDisplay : lang('trd_113');  ?> </td>
                </tr>

                </tbody>
            </table>
            <div class="content-delimetr"></div>
        </div>


 <?php
// if(FXPP::isCopyAccType(($parameters_account)?$parameters_account:$_SESSION['account_number'])=="0")
 if(!$hide_subscription){ // hide  only if _SESSION['account_number'] == params trader account
 ?>
        
        <div class="trader-settings" >
            <h3><?= lang('trd_143'); ?></h3>
            <form method="post" id="subscribe-form">
                <input type="hidden" name="account_number" value="<?=  $fc_details['UserId']; ?>">

                <table cellpadding="0" cellspacing="4" class="well">
                    <tbody><tr>
                        <td width="50%" rowspan="2" class="well" style="vertical-align: baseline; padding: 19px;">
                            <!-- Валютные пары для выбранные для копирования -->
                            <center><?= lang('trd_144'); ?></center>
                            <table cellpadding="0" cellspacing="0">
                                <tbody><tr>
                                    <td width="250"><?= lang('trd_145'); ?></td>
                                    <td class="center" style="padding-left: 10px;"><input type="radio" id="copy_settings_values_1_1" name="copy_settings_values_1" value="1" checked="" onclick="ResetCheckbox()"></td>
                                </tr>
                                <tr>
                                    <td>Major currency pairs (EURUSD, USDJPY, GBPUSD, USDCHF):</td>
                                    <td class="center" style="padding-left: 10px;"><input type="radio" id="copy_settings_values_1_2" name="copy_settings_values_1" value="2" onclick="ResetCheckbox()"></td>
                                </tr>
                                <tr>
                                    <td style="">Choose manually:</td>
                                    <td class="center" style="padding-left: 10px;">
                                        <input type="radio" id="hand" name="copy_settings_values_1" value="-1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table cellpadding="0" cellspacing="0" class="w100" id="i-quotes-list">
                                            <tbody><tr>

                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="4" id="qoute_4"  onclick="CheckedReset()">
                                                </td>
                                                <td style="padding-right:0px; width:120px">EUR/USD</td>

                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="8" id="qoute_8" onclick="CheckedReset()">
                                                </td>
                                                <td style="padding-right:0px; width:120px">GBP/USD</td>
                                            </tr><tr>
                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="16" id="qoute_16"  onclick="CheckedReset()">
                                                </td>
                                                <td style="padding-right:0px; width:120px">USD/JPY</td>

                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="32" id="qoute_32" onclick="CheckedReset()">
                                                </td>
                                                <td style="padding-right:0px; width:120px">USD/CHF</td>
                                            </tr><tr>
                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="64" id="qoute_64" onclick="CheckedReset()">
                                                </td>
                                                <td style="padding-right:0px; width:120px">USD/CAD</td>

                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="128" id="qoute_128" onclick="CheckedReset()">
                                                </td>
                                                <td style="padding-right:0px; width:120px">AUD/USD</td>
                                            </tr><tr>
                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="256" id="qoute_256" onclick="CheckedReset()">
                                                </td>
                                                <td style="padding-right:0px; width:120px">NZD/USD</td>

                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="512" id="qoute_512" onclick="CheckedReset()">
                                                </td>
                                                <td style="padding-right:0px; width:120px">EUR/JPY</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="1024" id="qoute_1024" onclick="CheckedReset()">
                                                </td>
                                                <td style="padding-right:0px; width:120px">EUR/CHF</td>

                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="2048" id="qoute_2048" onclick="CheckedReset()">
                                                </td>
                                                <td style="padding-right:0px; width:120px">EUR/GBP</td>
                                            </tr>
                                            </tbody></table>
                                    </td>
                                </tr>
                                </tbody></table>
                            <!-- /Валютные пары для выбранные для копирования -->
                        </td>

                        <td class="well">
                            <input type = "hidden" id="is_edit" value ="0">
                            <!-- Масштаб копирования -->
                            <center><?= lang('trd_146'); ?></center>
                            <table cellpadding="0" class="center w100">
                                <tbody><tr>
                                    <td width="180px">
                                        Trader:                        </td>
                                    <td style="padding-right: 23px; text-align:center;">
                                        <select style="width: 137px;" class="form-control" name="copy_settings_values_2_part_1" id="icopy_settings_values_2_part_1" onchange="ResetSelect(0,1)">
                                            <option value="0.01">
                                                0.01                                     lot deal                                </option>
                                            <option value="0.02">
                                                0.02                                     lot deal                                </option>
                                            <option value="0.03">
                                                0.03                                     lot deal                                </option>
                                            <option value="0.04">
                                                0.04                                     lot deal                                </option>
                                            <option value="0.05">
                                                0.05                                     lot deal                                </option>
                                            <option value="0.06">
                                                0.06                                     lot deal                                </option>
                                            <option value="0.07">
                                                0.07                                     lot deal                                </option>
                                            <option value="0.08">
                                                0.08                                     lot deal                                </option>
                                            <option value="0.09">
                                                0.09                                     lot deal                                </option>
                                            <option value="0.1">
                                                0.1                                     lot deal                                </option>
                                            <option value="0.2">
                                                0.2                                     lot deal                                </option>
                                            <option value="0.3">
                                                0.3                                     lot deal                                </option>
                                            <option value="0.4">
                                                0.4                                     lot deal                                </option>
                                            <option value="0.5">
                                                0.5                                     lot deal                                </option>
                                            <option value="0.6">
                                                0.6                                     lot deal                                </option>
                                            <option value="0.7">
                                                0.7                                     lot deal                                </option>
                                            <option value="0.8">
                                                0.8                                     lot deal                                </option>
                                            <option value="0.9">
                                                0.9                                     lot deal                                </option>
                                            <option value="1">
                                                1                                     lot deal                                </option>
                                            <option value="2">
                                                2                                     lot deal                                </option>
                                            <option value="3">
                                                3                                     lot deal                                </option>
                                            <option value="4">
                                                4                                     lot deal                                </option>
                                            <option value="5">
                                                5                                     lots deal                                </option>
                                            <option value="6">
                                                6                                     lots deal                                </option>
                                            <option value="7">
                                                7                                     lots deal                                </option>
                                            <option value="8">
                                                8                                     lots deal                                </option>
                                            <option value="9">
                                                9                                     lots deal                                </option>
                                            <option value="10">
                                                10                                     lots deal                                </option>
                                            <option value="15">
                                                15                                     lots deal                                </option>
                                            <option value="20">
                                                20                                     lots deal                                </option>
                                            <option value="25">
                                                25                                     lots deal                                </option>
                                            <option value="30">
                                                30                                     lots deal                                </option>
                                            <option value="35">
                                                35                                     lots deal                                </option>
                                            <option value="40">
                                                40                                     lots deal                                </option>
                                            <option value="45">
                                                45                                     lots deal                                </option>
                                            <option value="50">
                                                50                                     lots deal                                </option>
                                            <option value="55">
                                                55                                     lots deal                                </option>
                                            <option value="60">
                                                60                                     lots deal                                </option>
                                            <option value="65">
                                                65                                     lots deal                                </option>
                                            <option value="70">
                                                70                                     lots deal                                </option>
                                            <option value="75">
                                                75                                     lots deal                                </option>
                                            <option value="80">
                                                80                                     lots deal                                </option>
                                            <option value="85">
                                                85                                     lots deal                                </option>
                                            <option value="90">
                                                90                                     lots deal                                </option>
                                            <option value="95">
                                                95                                     lots deal                                </option>
                                            <option value="100">
                                                100                                     lots deal                                </option>
                                            <option value="200" selected="selected">
                                                200                                     lots deal                                </option>
                                            <option value="300">
                                                300                                     lots deal                                </option>
                                            <option value="400">
                                                400                                     lots deal                                </option>
                                            <option value="500">
                                                500                                     lots deal                                </option>
                                            <option value="600">
                                                600                                     lots deal                                </option>
                                            <option value="700">
                                                700                                     lots deal                                </option>
                                            <option value="800">
                                                800                                     lots deal                                </option>
                                            <option value="900">
                                                900                                     lots deal                                </option>
                                            <option value="1000">
                                                1000                                     lots deal                                </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>You:</td>
                                    <td style="padding-right: 23px; text-align:center;">
                                        <select style="width: 137px;" class="form-control" name="copy_settings_values_2_part_2" id="icopy_settings_values_2_part_2" onchange="ResetSelect(0,2)">
                                            <option value="0.01">
                                                0.01                                     lot deal                                </option>
                                            <option value="0.02">
                                                0.02                                     lot deal                                </option>
                                            <option value="0.03">
                                                0.03                                     lot deal                                </option>
                                            <option value="0.04">
                                                0.04                                     lot deal                                </option>
                                            <option value="0.05">
                                                0.05                                     lot deal                                </option>
                                            <option value="0.06">
                                                0.06                                     lot deal                                </option>
                                            <option value="0.07">
                                                0.07                                     lot deal                                </option>
                                            <option value="0.08">
                                                0.08                                     lot deal                                </option>
                                            <option value="0.09">
                                                0.09                                     lot deal                                </option>
                                            <option value="0.1">
                                                0.1                                     lot deal                                </option>
                                            <option value="0.2">
                                                0.2                                     lot deal                                </option>
                                            <option value="0.3">
                                                0.3                                     lot deal                                </option>
                                            <option value="0.4">
                                                0.4                                     lot deal                                </option>
                                            <option value="0.5">
                                                0.5                                     lot deal                                </option>
                                            <option value="0.6">
                                                0.6                                     lot deal                                </option>
                                            <option value="0.7">
                                                0.7                                     lot deal                                </option>
                                            <option value="0.8">
                                                0.8                                     lot deal                                </option>
                                            <option value="0.9">
                                                0.9                                     lot deal                                </option>
                                            <option value="1" selected="selected">
                                                1                                     lot deal                                </option>
                                            <option value="2">
                                                2                                     lot deal                                </option>
                                            <option value="3">
                                                3                                     lot deal                                </option>
                                            <option value="4">
                                                4                                     lot deal                                </option>
                                            <option value="5">
                                                5                                     lots deal                                </option>
                                            <option value="6">
                                                6                                     lots deal                                </option>
                                            <option value="7">
                                                7                                     lots deal                                </option>
                                            <option value="8">
                                                8                                     lots deal                                </option>
                                            <option value="9">
                                                9                                     lots deal                                </option>
                                            <option value="10">
                                                10                                     lots deal                                </option>
                                            <option value="15">
                                                15                                     lots deal                                </option>
                                            <option value="20">
                                                20                                     lots deal                                </option>
                                            <option value="25">
                                                25                                     lots deal                                </option>
                                            <option value="30">
                                                30                                     lots deal                                </option>
                                            <option value="35">
                                                35                                     lots deal                                </option>
                                            <option value="40">
                                                40                                     lots deal                                </option>
                                            <option value="45">
                                                45                                     lots deal                                </option>
                                            <option value="50">
                                                50                                     lots deal                                </option>
                                            <option value="55">
                                                55                                     lots deal                                </option>
                                            <option value="60">
                                                60                                     lots deal                                </option>
                                            <option value="65">
                                                65                                     lots deal                                </option>
                                            <option value="70">
                                                70                                     lots deal                                </option>
                                            <option value="75">
                                                75                                     lots deal                                </option>
                                            <option value="80">
                                                80                                     lots deal                                </option>
                                            <option value="85">
                                                85                                     lots deal                                </option>
                                            <option value="90">
                                                90                                     lots deal                                </option>
                                            <option value="95">
                                                95                                     lots deal                                </option>
                                            <option value="100">
                                                100                                     lots deal                                </option>
                                            <option value="200">
                                                200                                     lots deal                                </option>
                                            <option value="300">
                                                300                                     lots deal                                </option>
                                            <option value="400">
                                                400                                     lots deal                                </option>
                                            <option value="500">
                                                500                                     lots deal                                </option>
                                            <option value="600">
                                                600                                     lots deal                                </option>
                                            <option value="700">
                                                700                                     lots deal                                </option>
                                            <option value="800">
                                                800                                     lots deal                                </option>
                                            <option value="900">
                                                900                                     lots deal                                </option>
                                            <option value="1000">
                                                1000                                     lots deal                                </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <input type="hidden" id = "add_opt" name="add_opt" value="">

                                    <input type="hidden" id = "add_opt_value" name="add_opt_value" value="">

                                    <input type="hidden" id = "icopy_settings_values_2_total" name="icopy_settings_values_2_total" value="">
                                    <td colspan="2"><span id="all_text">If a trader opens a 1  lot deal, you will get a 1.43 lot deal copied to your account</span>.
                                        <div style="display: none; color: red" id="eu_warning">The Company does not recommend increasing the ratio of the copied lots:<br>
                                            Changing the copying ratio affects the lot size.<br>
                                            Increasing the ratio of the copied lots leads to increased marginal requirements, and vice versa.</div></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="well" height="50%">
                            <center>
                                Daily copying limit:			</center>
                            <table class="center w100">
                                <tbody><tr>
                                    <td width="180px">
                                        Choose the number<br> of trades:                    </td>

                                    <td style="padding-right: 23px; text-align:center;">
                                        <select style="width: 120px;" class="form-control" name="copy_settings_values_3" id="icopy_settings_values_3" onchange="ResetSelectCopy()">
                                            <option value="0">All</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>

                                </tr>
                                <tr>
                                    <td colspan="2">
                                        You copy <span id="traider_copy_deals"> all deals</span> of a Copytrading trader.
                                    </td>
                                </tr>
                                </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: left; border: none;" class="well">
                            <span  style="float: left; margin-right: 8px; height: 35px;"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                            <div>The advanced settings of subscription to copying positions of the Copytrading traders are designed for skilled Copytrading followers and allow fine adjusting the subscription parameters.</div>
                            <div style="float: right">
                                <a onclick="ShowHideSettings()">
                                    <label for="adv_settings" style="cursor: pointer;">View settings</label>
                                </a>
                            </div>
                            <input type="checkbox" name="use_adv_settings" id="adv_settings" style="display:none">
                        </td>
                    </tr>
                    <tr id="advanced_settings" style="display: none">
                        <td colspan="2" style="text-align: left; border: none;" class="well">
                            <div class="simple-wnd">
                                <div>Set the lot range:</div>
                                <div id="advanced_settings_select">
                                    <select class="form-control" style="width: 200px;" name="limited_or_fixed" onchange="LimitOrFixed($(this).val())">
                                        <option value="0">Lot range</option>
                                        <option value="1">Fixed lot</option>
                                    </select>
                                </div>
                                <div style="" id="limited_lots">
                                    <div>
                                        <div style="width: 50%; float:left">By using lot range feature, you will copy all the positions from Copytrading trader’s account within the selected diapason chosen by you in the settings.</div>
                                        <div style="width: 48%; float:right;">
                                            <div class="row">
                                                <div class="col-md-5" style="padding: 1px 10px!important;">Min lot:</div>
                                                <div class="col-md-5" style="padding: 3px;">
                                                    <select name="min_lot_open" class="form-control" onchange="SetLimit()" style="">
                                                        <option value="0.01">
                                                            0.01                                                         lot deal                                                    </option>
                                                        <option value="0.02">
                                                            0.02                                                         lot deal                                                    </option>
                                                        <option value="0.03">
                                                            0.03                                                         lot deal                                                    </option>
                                                        <option value="0.04">
                                                            0.04                                                         lot deal                                                    </option>
                                                        <option value="0.05">
                                                            0.05                                                         lot deal                                                    </option>
                                                        <option value="0.06">
                                                            0.06                                                         lot deal                                                    </option>
                                                        <option value="0.07">
                                                            0.07                                                         lot deal                                                    </option>
                                                        <option value="0.08">
                                                            0.08                                                         lot deal                                                    </option>
                                                        <option value="0.09">
                                                            0.09                                                         lot deal                                                    </option>
                                                        <option value="0.1">
                                                            0.1                                                         lot deal                                                    </option>
                                                        <option value="0.2">
                                                            0.2                                                         lot deal                                                    </option>
                                                        <option value="0.3">
                                                            0.3                                                         lot deal                                                    </option>
                                                        <option value="0.4">
                                                            0.4                                                         lot deal                                                    </option>
                                                        <option value="0.5">
                                                            0.5                                                         lot deal                                                    </option>
                                                        <option value="0.6">
                                                            0.6                                                         lot deal                                                    </option>
                                                        <option value="0.7">
                                                            0.7                                                         lot deal                                                    </option>
                                                        <option value="0.8">
                                                            0.8                                                         lot deal                                                    </option>
                                                        <option value="0.9">
                                                            0.9                                                         lot deal                                                    </option>
                                                        <option value="1">
                                                            1                                                         lot deal                                                    </option>
                                                        <option value="2">
                                                            2                                                         lot deal                                                    </option>
                                                        <option value="3">
                                                            3                                                         lot deal                                                    </option>
                                                        <option value="4">
                                                            4                                                         lot deal                                                    </option>
                                                        <option value="5">
                                                            5                                                         lots deal                                                    </option>
                                                        <option value="6">
                                                            6                                                         lots deal                                                    </option>
                                                        <option value="7">
                                                            7                                                         lots deal                                                    </option>
                                                        <option value="8">
                                                            8                                                         lots deal                                                    </option>
                                                        <option value="9">
                                                            9                                                         lots deal                                                    </option>
                                                        <option value="10">
                                                            10                                                         lots deal                                                    </option>
                                                        <option value="15">
                                                            15                                                         lots deal                                                    </option>
                                                        <option value="20">
                                                            20                                                         lots deal                                                    </option>
                                                        <option value="25">
                                                            25                                                         lots deal                                                    </option>
                                                        <option value="30">
                                                            30                                                         lots deal                                                    </option>
                                                        <option value="35">
                                                            35                                                         lots deal                                                    </option>
                                                        <option value="40">
                                                            40                                                         lots deal                                                    </option>
                                                        <option value="45">
                                                            45                                                         lots deal                                                    </option>
                                                        <option value="50">
                                                            50                                                         lots deal                                                    </option>
                                                        <option value="55">
                                                            55                                                         lots deal                                                    </option>
                                                        <option value="60">
                                                            60                                                         lots deal                                                    </option>
                                                        <option value="65">
                                                            65                                                         lots deal                                                    </option>
                                                        <option value="70">
                                                            70                                                         lots deal                                                    </option>
                                                        <option value="75">
                                                            75                                                         lots deal                                                    </option>
                                                        <option value="80">
                                                            80                                                         lots deal                                                    </option>
                                                        <option value="85">
                                                            85                                                         lots deal                                                    </option>
                                                        <option value="90">
                                                            90                                                         lots deal                                                    </option>
                                                        <option value="95">
                                                            95                                                         lots deal                                                    </option>
                                                        <option value="100">
                                                            100                                                         lots deal                                                    </option>
                                                        <option value="200">
                                                            200                                                         lots deal                                                    </option>
                                                        <option value="300">
                                                            300                                                         lots deal                                                    </option>
                                                        <option value="400">
                                                            400                                                         lots deal                                                    </option>
                                                        <option value="500">
                                                            500                                                         lots deal                                                    </option>
                                                        <option value="600">
                                                            600                                                         lots deal                                                    </option>
                                                        <option value="700">
                                                            700                                                         lots deal                                                    </option>
                                                        <option value="800">
                                                            800                                                         lots deal                                                    </option>
                                                        <option value="900">
                                                            900                                                         lots deal                                                    </option>
                                                        <option value="1000">
                                                            1000                                                         lots deal                                                    </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="width: 48%; float:right">
                                            <div class="row">
                                                <div class="col-md-5" style="padding: 1px 10px!important;margin-top:-3px;">Max lot:</div>
                                                <div class="col-md-5" style="padding: 3px;">
                                                    <select name="max_lot_open" class="form-control" onchange="SetLimit()">
                                                        <option value="0.01">
                                                            0.01                                                         lot deal                                                    </option>
                                                        <option value="0.02">
                                                            0.02                                                         lot deal                                                    </option>
                                                        <option value="0.03">
                                                            0.03                                                         lot deal                                                    </option>
                                                        <option value="0.04">
                                                            0.04                                                         lot deal                                                    </option>
                                                        <option value="0.05">
                                                            0.05                                                         lot deal                                                    </option>
                                                        <option value="0.06">
                                                            0.06                                                         lot deal                                                    </option>
                                                        <option value="0.07">
                                                            0.07                                                         lot deal                                                    </option>
                                                        <option value="0.08">
                                                            0.08                                                         lot deal                                                    </option>
                                                        <option value="0.09">
                                                            0.09                                                         lot deal                                                    </option>
                                                        <option value="0.1">
                                                            0.1                                                         lot deal                                                    </option>
                                                        <option value="0.2">
                                                            0.2                                                         lot deal                                                    </option>
                                                        <option value="0.3">
                                                            0.3                                                         lot deal                                                    </option>
                                                        <option value="0.4">
                                                            0.4                                                         lot deal                                                    </option>
                                                        <option value="0.5">
                                                            0.5                                                         lot deal                                                    </option>
                                                        <option value="0.6">
                                                            0.6                                                         lot deal                                                    </option>
                                                        <option value="0.7">
                                                            0.7                                                         lot deal                                                    </option>
                                                        <option value="0.8">
                                                            0.8                                                         lot deal                                                    </option>
                                                        <option value="0.9">
                                                            0.9                                                         lot deal                                                    </option>
                                                        <option value="1">
                                                            1                                                         lot deal                                                    </option>
                                                        <option value="2">
                                                            2                                                         lot deal                                                    </option>
                                                        <option value="3">
                                                            3                                                         lot deal                                                    </option>
                                                        <option value="4">
                                                            4                                                         lot deal                                                    </option>
                                                        <option value="5">
                                                            5                                                         lots deal                                                    </option>
                                                        <option value="6">
                                                            6                                                         lots deal                                                    </option>
                                                        <option value="7">
                                                            7                                                         lots deal                                                    </option>
                                                        <option value="8">
                                                            8                                                         lots deal                                                    </option>
                                                        <option value="9">
                                                            9                                                         lots deal                                                    </option>
                                                        <option value="10">
                                                            10                                                         lots deal                                                    </option>
                                                        <option value="15">
                                                            15                                                         lots deal                                                    </option>
                                                        <option value="20">
                                                            20                                                         lots deal                                                    </option>
                                                        <option value="25">
                                                            25                                                         lots deal                                                    </option>
                                                        <option value="30">
                                                            30                                                         lots deal                                                    </option>
                                                        <option value="35">
                                                            35                                                         lots deal                                                    </option>
                                                        <option value="40">
                                                            40                                                         lots deal                                                    </option>
                                                        <option value="45">
                                                            45                                                         lots deal                                                    </option>
                                                        <option value="50">
                                                            50                                                         lots deal                                                    </option>
                                                        <option value="55">
                                                            55                                                         lots deal                                                    </option>
                                                        <option value="60">
                                                            60                                                         lots deal                                                    </option>
                                                        <option value="65">
                                                            65                                                         lots deal                                                    </option>
                                                        <option value="70">
                                                            70                                                         lots deal                                                    </option>
                                                        <option value="75">
                                                            75                                                         lots deal                                                    </option>
                                                        <option value="80">
                                                            80                                                         lots deal                                                    </option>
                                                        <option value="85">
                                                            85                                                         lots deal                                                    </option>
                                                        <option value="90">
                                                            90                                                         lots deal                                                    </option>
                                                        <option value="95">
                                                            95                                                         lots deal                                                    </option>
                                                        <option value="100">
                                                            100                                                         lots deal                                                    </option>
                                                        <option value="200">
                                                            200                                                         lots deal                                                    </option>
                                                        <option value="300">
                                                            300                                                         lots deal                                                    </option>
                                                        <option value="400">
                                                            400                                                         lots deal                                                    </option>
                                                        <option value="500">
                                                            500                                                         lots deal                                                    </option>
                                                        <option value="600">
                                                            600                                                         lots deal                                                    </option>
                                                        <option value="700">
                                                            700                                                         lots deal                                                    </option>
                                                        <option value="800">
                                                            800                                                         lots deal                                                    </option>
                                                        <option value="900">
                                                            900                                                         lots deal                                                    </option>
                                                        <option value="1000" selected="selected">
                                                            1000                                                         lots deal                                                    </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div style="margin-top: 5px;">The volume of all trades opened on your account is limited to <span id="min">0.01                                                         lot deal</span> – <span id="max">1000                                                         lots deal</span>.</div>
                                    <div>
                                        <div style="float: left;">
                                            <input style="margin: 2px 0 0;" type="checkbox" id ="dont_copy" name="dont_copy" value="0">&nbsp;&nbsp;
                                        </div>
                                        <div>
                                            Don’t copy trades of bigger or smaller volume than set.                                            <style>
                                                .tooltip-help
                                                {
                                                    width: 24px;
                                                    height: 16px;
                                                
                                                    display: inline-block;
                                                    text-decoration: none;
                                                    vertical-align: middle;
                                                }

                                                .tooltip-help2
                                                {
                                                    width: 17px;
                                                    height: 17px;
                                                   
                                                    display: inline-block;
                                                    text-decoration: none;
                                                    vertical-align: middle;
                                                }
                                            </style>
                                          
                                            <script type="text/javascript">
                                                $(function()
                                                {
                                                    $('.tooltip-help_predelay').tooltip
                                                    ({
                                                        offset: [10, 2],
                                                        predelay: 1000
                                                    });
                                                });
                                            </script>
                                            <script type="text/javascript">
                                                $(function()
                                                {
                                                    $('.tooltip-help').tooltip
                                                    ({
                                                        offset: [10, 2]
                                                    });
                                                });
                                            </script>
                                            <script type="text/javascript">
                                                $(function()
                                                {
                                                    $('.tooltip-help2').tooltip
                                                    ({
                                                        offset: [10, 2]
                                                    });
                                                });
                                            </script>    <span style="margin-top:-6px;"  title="" class="tooltip-help" data-original-title="In case it is unchecked, the volume of all trades copied from the Copytrading trader account and exceeding set parameters will be limited to max and min lot size.">
                                   <i class="fa fa-question-circle" aria-hidden="true"></i>
                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div id="fixed_lot" style="display: none">
                                    <div style="width: 50%; float:left">By using fixed lot feature, you will copy all the positions from Copytrading trader’s account specified by you in the lot settings.</div>
                                    <div style="width: 48%; float:right">
                                        <div style="float: left;">Fixed lot:</div>
                                        <div style="float: right; margin-right: 40px; margin-top: -4px;">
                                            <select name="fixed_lot" class="form-control" onchange="SetFixedLot()">
                                                <option value="0.01">
                                                    0.01                                                     lot deal                                                </option>
                                                <option value="0.02">
                                                    0.02                                                     lot deal                                                </option>
                                                <option value="0.03">
                                                    0.03                                                     lot deal                                                </option>
                                                <option value="0.04">
                                                    0.04                                                     lot deal                                                </option>
                                                <option value="0.05">
                                                    0.05                                                     lot deal                                                </option>
                                                <option value="0.06">
                                                    0.06                                                     lot deal                                                </option>
                                                <option value="0.07">
                                                    0.07                                                     lot deal                                                </option>
                                                <option value="0.08">
                                                    0.08                                                     lot deal                                                </option>
                                                <option value="0.09">
                                                    0.09                                                     lot deal                                                </option>
                                                <option value="0.1">
                                                    0.1                                                     lot deal                                                </option>
                                                <option value="0.2">
                                                    0.2                                                     lot deal                                                </option>
                                                <option value="0.3">
                                                    0.3                                                     lot deal                                                </option>
                                                <option value="0.4">
                                                    0.4                                                     lot deal                                                </option>
                                                <option value="0.5">
                                                    0.5                                                     lot deal                                                </option>
                                                <option value="0.6">
                                                    0.6                                                     lot deal                                                </option>
                                                <option value="0.7">
                                                    0.7                                                     lot deal                                                </option>
                                                <option value="0.8">
                                                    0.8                                                     lot deal                                                </option>
                                                <option value="0.9">
                                                    0.9                                                     lot deal                                                </option>
                                                <option value="1" selected="selected">
                                                    1                                                     lot deal                                                </option>
                                                <option value="2">
                                                    2                                                     lot deal                                                </option>
                                                <option value="3">
                                                    3                                                     lot deal                                                </option>
                                                <option value="4">
                                                    4                                                     lot deal                                                </option>
                                                <option value="5">
                                                    5                                                     lots deal                                                </option>
                                                <option value="6">
                                                    6                                                     lots deal                                                </option>
                                                <option value="7">
                                                    7                                                     lots deal                                                </option>
                                                <option value="8">
                                                    8                                                     lots deal                                                </option>
                                                <option value="9">
                                                    9                                                     lots deal                                                </option>
                                                <option value="10">
                                                    10                                                     lots deal                                                </option>
                                                <option value="15">
                                                    15                                                     lots deal                                                </option>
                                                <option value="20">
                                                    20                                                     lots deal                                                </option>
                                                <option value="25">
                                                    25                                                     lots deal                                                </option>
                                                <option value="30">
                                                    30                                                     lots deal                                                </option>
                                                <option value="35">
                                                    35                                                     lots deal                                                </option>
                                                <option value="40">
                                                    40                                                     lots deal                                                </option>
                                                <option value="45">
                                                    45                                                     lots deal                                                </option>
                                                <option value="50">
                                                    50                                                     lots deal                                                </option>
                                                <option value="55">
                                                    55                                                     lots deal                                                </option>
                                                <option value="60">
                                                    60                                                     lots deal                                                </option>
                                                <option value="65">
                                                    65                                                     lots deal                                                </option>
                                                <option value="70">
                                                    70                                                     lots deal                                                </option>
                                                <option value="75">
                                                    75                                                     lots deal                                                </option>
                                                <option value="80">
                                                    80                                                     lots deal                                                </option>
                                                <option value="85">
                                                    85                                                     lots deal                                                </option>
                                                <option value="90">
                                                    90                                                     lots deal                                                </option>
                                                <option value="95">
                                                    95                                                     lots deal                                                </option>
                                                <option value="100">
                                                    100                                                     lots deal                                                </option>
                                                <option value="200">
                                                    200                                                     lots deal                                                </option>
                                                <option value="300">
                                                    300                                                     lots deal                                                </option>
                                                <option value="400">
                                                    400                                                     lots deal                                                </option>
                                                <option value="500">
                                                    500                                                     lots deal                                                </option>
                                                <option value="600">
                                                    600                                                     lots deal                                                </option>
                                                <option value="700">
                                                    700                                                     lots deal                                                </option>
                                                <option value="800">
                                                    800                                                     lots deal                                                </option>
                                                <option value="900">
                                                    900                                                     lots deal                                                </option>
                                                <option value="1000">
                                                    1000                                                     lots deal                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div style="margin-top: 5px;">All the trades on your account are opened within <span id="fixed_lot_span">1</span> lot.</div>
                                </div>
                            </div>
                            <div class="simple-wnd" style="margin-top: 5px;">
                                <div>
                                    Options copying:<br>
                                    The options bought on the Copytrading trader’s account are automatically copied to your trading account.<br>
                                </div>
                                <div>
                                    <div style="float: left;">
                                        <input style="margin: 2px 0 0;" type="checkbox" id ="copy_options" name="copy_options" value="0">&nbsp;&nbsp;
                                    </div>
                                    <div>
                                        Copy options from this Copytrading trader’s account.                                                <style>
                                            .tooltip-help
                                            {
                                                width: 24px;
                                                height: 16px;
                                                display: inline-block;
                                                text-decoration: none;
                                                vertical-align: middle;
                                            }

                                            .tooltip-help2
                                            {
                                                width: 17px;
                                                height: 17px;
                                                display: inline-block;
                                                text-decoration: none;
                                                vertical-align: middle;
                                            }
                                        </style>
                                       
                                     
                                        <script type="text/javascript">
                                            $(function()
                                            {
                                                $('.tooltip-help_predelay').tooltip
                                                ({
                                                    offset: [10, 2],
                                                    predelay: 1000
                                                });
                                            });
                                        </script>
                                        <script type="text/javascript">
                                            $(function()
                                            {
                                                $('.tooltip-help').tooltip
                                                ({
                                                    offset: [10, 2]
                                                });
                                            });
                                        </script>
                                        <script type="text/javascript">
                                            $(function()
                                            {
                                                $('.tooltip-help2').tooltip
                                                ({
                                                    offset: [10, 2]
                                                });
                                            });
                                        </script>    <span style="margin-top:-6px;" title="" class="tooltip-help" data-original-title="All the copied options will be displayed on the pages Current Trades and History of Trades of the section My Trading in your Client Cabinet.
- Upon early cancellation of an option by a Copytrading trader, the option will also be cancelled on your account. However, 10% of the option’s value will be charged.
- If the balance is insufficient, the option will not be copied to the Copytrading follower’s account.
- Options are copied based on the copying ratio. Thus, if the ratio is 1:2, a Copytrading trader’s option of a $10 value will be copied to your account as an option of a $20 value.
- Option’s minimum nominal value is $1, maximum - $1,000. If the option does not comply with these requirements, the closest nominal value will be used for copying.
- Selective restrictions on the instruments for copying do not apply to the options."><i class="fa fa-question-circle" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </div>
<!--                            <div class="simple-wnd" style="margin-top: 5px;">
                                <div>
                                    Inverse copying:<br>
                                </div>
                                <div>
                                    <div style="float: left;">
                                        <input style="margin: 2px 0 0;" type="checkbox" id="copy_inverse" name="copy_inverse" value="0"> &nbsp;&nbsp;
                                    </div>
                                    <div>
                                        Copy the trades opposite to those opened on Copytrading trader’s account.
                                        <span style="margin-top:-6px;"  title="" class="tooltip-help" data-original-title="By activating the inverse copying option, a Copytrading follower will trigger copying of the trades opposite to those opened by a Copytrading trader. Thus, BUY deals opened by a Copytrading trader will be copied as SELL deals to the follower’s account, whereas SELL deals will be copied as BUY deals. The new settings will be applied to the newly opened trades only (not the current ones) right after the activation.">
                                      <i class="fa fa-question-circle" aria-hidden="true"></i>
                                </span>
                                    </div>
                                </div>
                            </div>-->

                        </td>
                    </tr>
                    </tbody>
                </table>

                <center>
                    <input type="button" class="sprites btn btn-main" id="subscribeToTrader" value="Subscribe">
                </center>
            </form>
        </div>
        
    <?php }?>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

          <div class="clear-all"></div>


        <h2 class="header-trader-inf" style="border: 0 !important"><?= lang('trd_147'); ?></h2>
        <table cellspacing="0" cellpadding="0" class="table table_main table-striped">
            <thead>
            <tr>
                <th colspan="2" style="width: 50%; vertical-align: middle;"><strong><?= lang('trd_148'); ?></strong></th>
                <th colspan="2" style="width: 50%; vertical-align: middle;"><strong><?= lang('trd_149'); ?></strong><span style="font-weight: normal; font-style: italic; float: right"><?= lang('trd_150'); ?> <?= $fc_details['LastUpdate']; ?></span></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="width: 100px; vertical-align: middle;">Broker:</td>
                <td style="vertical-align: middle;">ForexMart</td>
                <td style="width: 180px; vertical-align: middle;">Simple rating:</td>
                <td style="width: 111px; max-width: 111px; vertical-align: middle;"><?=  isset($fc_details['SimpleRating']) ? $fc_details['SimpleRating']: 'N/A'; ?>  </td>
            </tr>
            <tr>
                <td style="width: 100px; vertical-align: middle;">Account number:</td>
                <td style="vertical-align: middle;"><?=   $fc_details['UserId']; ?></td>
                <td style="width: 180px; vertical-align: middle;">Balance:</td>
                <td style="vertical-align: middle;"><nobr><?=  $bal_details['LastBalance']; ?>  <?=  $fc_details['account_currency']; ?></nobr></td>
            </tr>
            <tr>
                <td style="width: 100px;vertical-align: middle;">Type:</td>
                <td style="vertical-align: middle;"><?=  $fc_details['account_type']; ?> </td>
                <td style="width: 180px; vertical-align: middle;">Equity:</td>
                <td style="vertical-align: middle;"><nobr><?=  $bal_details['LastEquity']; ?>&nbsp;<?=  $fc_details['account_currency']; ?></nobr></td>
            </tr>
            <tr>
                <td style="width: 100px;vertical-align: middle;">Project:</td>
                <td style="vertical-align: middle;"><?=   $fc_details['ProjectName']; ?></td>
                <td style="width: 180px; vertical-align: middle;">Open trades:</td>
                <td style="vertical-align: middle;"><?=  $bal_details['OpenTrades']; ?></td>
            </tr>
            <tr>
                <td style="width: 100px; vertical-align: middle;">Account name:</td>
                <td style="vertical-align: middle;"><span class="hidden-msg"><?=  $fc_details['AccountName']; ?></span></td>
                <td style="width: 180px;vertical-align: middle;">Total trades:</td>
                <td style="vertical-align: middle;"><?=  $bal_details['CloseTrades']; ?></td>
            </tr>
            <tr>
                <td style="width: 100px; vertical-align: middle;">Icq:</td>
                <td style="vertical-align: middle;"><?=  $fc_details['Icq']; ?></td>
                <td style="width: 180px; vertical-align: middle;">Balance increase per day:</td>
                <td style="vertical-align: middle;"><nobr><?=  $bal_details['BalancePerDay']; ?>&nbsp;<?=  $fc_details['account_currency']; ?></nobr></td>
            </tr>
            <tr>
                <td style="width: 100px; vertical-align: middle;">Phone:</td>
                <td style="vertical-align: middle;"><?=  $fc_details['Phone']; ?></td>
                <td style="width: 180px; vertical-align: middle;">Total balance increase:</td>
                <td style="vertical-align: middle;"><nobr><?= $bal_details['TotalBalanceIncrease']; ?>&nbsp;<?=  $fc_details['account_currency']; ?></nobr></td>
            </tr>
            <tr>
                <td style="width: 100px; vertical-align: middle;">Email:</td>
                <td style="vertical-align: middle;"><?=  $fc_details['Email']; ?></td>
                <td style="width: 180px; vertical-align: middle;">Equity increase per day:</td>
                <td style="vertical-align: middle;"><nobr><?=  $bal_details['EquityPerDay']; ?>&nbsp;<?=  $fc_details['account_currency']; ?></nobr></td>
            </tr>
            <tr>
                <td style="width: 100px; vertical-align: middle;">Skype:</td>
                <td style="vertical-align: middle;"><?=  $fc_details['Skype']; ?>&nbsp;</td>
                <td style="width: 180px; vertical-align: middle;">Total equity increase:</td>
                <td style="vertical-align: middle;"><nobr><?= $bal_details['TotalEquityIncrease']; ?>&nbsp;<?=  $fc_details['account_currency']; ?></nobr></td>
            </tr>
            <tr>
                <td style="width: 113px; vertical-align: middle;">Active followers: </td>
                <td style="vertical-align: middle;"><?=  $fc_details['ActiveFollowers']; ?></td>
                <td style="width: 180px;vertical-align: middle;">Forum topic:</td>
                <td style="vertical-align: middle;">
                    <a href=""><?=  $fc_details['ForumTopic']; ?></a>
                </td>
            </tr>
            </tbody>
        </table>


        <div class="content-delimetr"></div>

        <table class="table table_main table-striped">
            <thead>
            <tr>
                <th><?= lang('trd_151'); ?></th>
                <th><?= lang('trd_152'); ?></th>
                <th><?= lang('trd_153'); ?></th>
                <th><?= lang('trd_154'); ?></th>
                <th><?= lang('trd_155'); ?></th>
                <th><?= lang('trd_156'); ?></th>
                <th><?= lang('trd_157'); ?></th>
            </tr>
            </thead>
            <tbody class="body_project_profit">
            <tr>
                <td><?= $bal_details['DailyProfit']?></td>
                <td><?= $bal_details['WeeklyProfit']?></td>
                <td><?= $bal_details['MonthlyProfit']?></td>
                <td><?= $bal_details['Monthly3Profit']?></td>
                <td><?= $bal_details['Monthly6Profit']?></td>
                <td><?= $bal_details['Monthly9Profit']?></td>
                <td><?= $bal_details['TotalProfit']?></td>
            </tr>
            <tr>
                <td colspan="7">
                    <?= lang("trd_170"); ?>                                        </td>
            </tr>
            </tbody>
        </table>

        <div class="content-delimetr"></div>
        <div>
<!--            <ul class="nav nav-tabs chart-nav" role="tablist" style="margin-bottom: 1px;">-->
<!--                <li role="presentation" class="active"><a href="#balance_equity" aria-controls="balance_equity" role="tab" onclick="ChangeTypeData(1)" data-toggle="tab">Balance / Equity</a></li>-->
<!--                <li role="presentation"><a href="#profit_equity" aria-controls="profit_equity" role="tab" onclick="ChangeTypeData(2)" data-toggle="tab">Profit percent</a></li>-->
<!--            </ul>-->

            <ul class="nav nav-pills" style="margin-bottom: 15px;">
                <li class="tab-balance active"><a href="#balance_equity" onclick="ChangeTypeData(1)" data-toggle="tab" style="border-radius: 0px;padding-top: 20px;"><?= lang('trd_158'); ?></a></li>
                <li class="tab-profit" style="width: 130px;"><a href="#profit_equity" onclick="ChangeTypeData(2)" data-toggle="tab" style="border-radius: 0px;padding-top: 20px;">Profit</a></li>
            </ul>
            <div class="option_form" style="border: 1px solid #BBB5B7;">

                <!-- График -->


                <!-- Выбор даты -->
                <div class="col-md-12">
                    <div class="row" style="width: 100%; padding-top: 3px; padding-bottom: 3px; width: 847px;">
                      <!--  <div class="col-md-2 col-xs-6 col-lg-2 col-sm-6">
                            <b><?//= lang('from'); ?>:</b>
                        </div>
                        <div class="col-md-3 col-xs-6 col-lg-3 col-sm-6">
                            <input type="text" id="datepicker_from" class="datetimepicker form-control" style="width: 150px" value="">
                        </div>
                        <div class="col-md-2 col-xs-6 col-lg-2 col-sm-6">
                            <b><?//= lang('to'); ?>:</b>
                        </div>
                        <div class="col-md-3 col-xs-6 col-lg-3 col-sm-6">
                            <input type="text" id="datepicker_to" style="width: 150px" class="datetimepicker form-control" value="">
                        </div>
                        <div class="col-md-2 col-xs-12 col-lg-2 col-sm-12" style="float:right">
                            <input type="button" id="apply" class="btn btn-main" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Apply&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">
                        </div>-->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="user-graphic" style="width: 100%; height: 441px" class="text-center">
                                <div id="balance_equity" style="width: 100%; height: 441px;"></div>
                                <div id="profit_equity" style="width: 100%; height: 441px;display:none"></div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
      </div>
  </div>
</div>




<!--<div id="confirmModal" class="modal fade">-->
<!--    <div class="modal-dialog">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <h4 class="modal-title conf-modal-title"></h4>-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<!--            </div>-->
<!---->
<!--            <div class="modal-body">-->
<!--                <p class="conf-modal-desc"></p>-->
<!--            </div>-->
<!---->
<!---->
<!--            <div class="modal-footer">-->
<!--                <input type="button" class="btn btn-default"  data-dismiss="modal" value="Cancel">-->
<!--                <input type="button" class="btn btn-danger" id ='confirm' value="Confirm">-->
<!--            </div>-->
<!---->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->


    <div id="cpy_modal"  tabindex="-1" class="modal-custom modal-center modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document" style="
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title">Modal title</h5> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <img src="<?= $this->template->Images()?>img-info-modal.png" class="img-center img-info-modal">
                </div>
                <div class="modal-body">
                    <p id="m_message" class="text-center"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-form" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmModal"  tabindex="-1" class="modal-custom modal-center modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document" style="
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title">Modal title</h5> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title conf-modal-title text-center"></h4>
                    <img src="<?= $this->template->Images()?>img-info-modal.png" class="img-center img-info-modal">
                </div>
                <div class="modal-body">
                    <p id="m_message" class="text-center conf-modal-desc"></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default"  data-dismiss="modal" value="Cancel">
                    <input type="button" class="btn btn-danger" id ='confirm' value="Confirm">
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript">
    var chart;
    var profit;
    var url = '<?php echo base_url();?>';
    var user_id = '<?=   $fc_details['UserId']; ?>';
    var con_id = '<?=  $connection; ?>';
    var is_trader = '<?= $IsTrader ?>';
    var is_hide = '<?= $hide_subscription ?>';
    var is_subscribe= '<?= $is_subscribe ?>';

    var date_from = "<?php echo date("Y-m-d",strtotime("- 1 month"));?>";
    var date_to = "<?php echo date("Y-m-d");?>";
    var isInvalidRatio = false;


    $(document).ready
    (
        function(){
            //$("select.selectForm").uniform();

            if(is_trader == 1){

            }else{
                $('.copying_trade_terms').hide();
            }
            if(is_hide){ // if monitor account is not trader
                $('#subscribeToTrader').hide();
            }else{
                $('#subscribeToTrader').show();
                ResetSelect();
                ResetSelectCopy();
                SetLimit();
                SetFixedLot();



                if(is_subscribe){ // is account subscribe already?
                    ShowConditions(user_id,con_id);
                }

            }



//            $(window).resize(function() {
//                var width = $('#balance_equity').width();
//                var height = $('#balance_equity').height();
//                console.log(width);
//                console.log(height);
//
//                GeneratechartBalance();
//
//            });



            $("input[name='dont_copy']").on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).val(1);
                } else {
                    $(this).val(0);
                }
            });
            $("input[name='copy_options']").on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).val(1);
                } else {
                    $(this).val(0);
                }
            });
            $("input[name='copy_inverse']").on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).val(1);
                } else {
                    $(this).val(0);
                }
            });


                $('.tooltip-help_predelay').tooltip({
                    offset: [10, 2],
                    predelay: 1000
                });


                $('.tooltip-help').tooltip({
                    offset: [10, 2]
                });

                $('.tooltip-help2').tooltip({
                    offset: [10, 2]
                });



            $('[data-toggle="tooltip"]').tooltip();

            $('#datepicker_from').datetimepicker({
                format: 'YYYY/DD/MM',
                defaultDate: date_from
            });

            $('#datepicker_to').datetimepicker({
                format: 'YYYY/DD/MM',
                defaultDate: date_to
            });

            $("#datepicker_from").on("dp.change", function (e) {
                $('#datepicker_to').data("DateTimePicker").minDate(e.date);
            });

            $("#datepicker_to").on("dp.change", function (ev) {
                $('#datepicker_from').data("DateTimePicker").maxDate(ev.date);
            });


         profit = new Highcharts.Chart({
//        $('#balance_equity').highcharts({
                chart: {
                    zoomType: 'x',
                    renderTo: 'profit_equity',
                    style: {
                        overflow: 'visible'
                    }
                },
                title: {
                    text: '<div class="profit-title"><?= lang("trd_130"); ?> : <?=  $fc_details['UserId']; ?>  -  <?=$project?></div>',
                    align: 'left'
                },
                subtitle: {
                    text: ''
                },
                credits: {enabled: false},
                xAxis: {
                    type: 'datetime',
                    labels: {
                        formatter: function () {
                            return Highcharts.dateFormat('%Y-%m-%d', this.value);
                        }
                    }
                },
                yAxis: [
                    {
                        title: {
                            text: ''
                        }
                    },
                    {
                        title: {
                            text: ''
                        },
                    }
                ],
                tooltip: {
                    shared: true,
                    backgroundColor: 'rgba(255, 255, 255, 0.90)',
                    borderWidth: 1,
                    borderColor: '#DDD',
                    borderRadius: 0,
                    shadow: false,
                    useHTML: true,
                    hideDelay: 0,
                    shared: true,
                    padding: 0,
                    style: {
                        color: '#333',
                        fontSize: '12px'
                    },
                    pointFormat: '{series.name}: <strong>{point.y}</strong>',
                    positioner: function (w, h, point) {
                        return { x: point.plotX - w / 2, y: point.plotY - h};
                    },
                    formatter: function () {
                        var tip = '<strong>' + Highcharts.dateFormat('%Y-%m-%d %H:%M', this.x) + '</strong><br/>';
                        $.each(this.points, function (k,point) {
                            tip += '<b><span style="color: ' + point.series.color + '">' + point.series.name + '</span></b>: ' + point.y.toFixed(2) + '<br/>';
                        });
                        return tip;
                    }
                },

                plotOptions: {
                    spline: {
                        marker: {
                            enabled: true
                        }
                    },
                    series: {
                        animation: true,
                        lineWidth: 1,
                        shadow: false,
                        states: {
                            hover: {
                                lineWidth: 2
                            }
                        },
                        marker: {
                            radius: 1,
                            states: {
                                hover: {
                                    radius: 2
                                }
                            }
                        },
                        fillOpacity: 0.25
                    },
                    column: {
                        color: '#33',
                        borderColor: '#333'
                    },
                    line: {
                        marker: {
                            symbol: 'circle',
                            radius: 1,
                            enabled: false
                        }
                    }
                },
             series: [
                 {name: "PROFIT", color: "#0C9700", data:[]}]

            });


         chart = new Highcharts.Chart({
//        $('#balance_equity').highcharts({
                chart: {
                    zoomType: 'x',
                    renderTo: 'balance_equity',
                    style: {
                        overflow: 'visible'
                    }
                },
                title: {
                    text: '<div class="bal-eq-title"><?= lang("trd_160"); ?> : <?=  $fc_details['UserId']; ?>  -   <?=$project?></div>',
                    align: 'left'

                },
                subtitle: {
                    text: ''
                },
                credits: {enabled: false},
                xAxis: {
                    type: 'datetime',
                    labels: {
                        formatter: function () {
                            return Highcharts.dateFormat('%Y-%m-%d', this.value);
                        }
                    }
                },
                yAxis: [
                    {
                        title: {
                            text: ''
                        }
                    },
                    {
                        title: {
                            text: '<?= lang("trd_169"); ?>'
                        },
                        opposite: true
                    }
                ],
                tooltip: {
                    shared: true,
                    backgroundColor: 'rgba(255, 255, 255, 0.90)',
                    borderWidth: 1,
                    borderColor: '#DDD',
                    borderRadius: 0,
                    shadow: false,
                    useHTML: true,
                    hideDelay: 0,
                    shared: true,
                    padding: 0,
                    style: {
                        color: '#333',
                        fontSize: '12px'
                    },
                    pointFormat: '{series.name}: <strong>{point.y}</strong>',
                    positioner: function (w, h, point) {
                        return { x: point.plotX - w / 2, y: point.plotY - h};
                    },
                    formatter: function () {
                        var tip = '<strong>' + Highcharts.dateFormat('%Y-%m-%d %H:%M', this.x) + '</strong><br/>';
                        $.each(this.points, function (k,point) {
                            tip += '<b><span style="color: ' + point.series.color + '">' + point.series.name + '</span></b>: ' + point.y.toFixed(2) + '<br/>';
                        });
                        return tip;
                    }
                },

                plotOptions: {
                    spline: {
                        marker: {
                            enabled: true
                        }
                    },
                    series: {
                        animation: true,
                        lineWidth: 1,
                        shadow: false,
                        states: {
                            hover: {
                                lineWidth: 2
                            }
                        },
                        marker: {
                            radius: 1,
                            states: {
                                hover: {
                                    radius: 2
                                }
                            }
                        },
                        fillOpacity: 0.25
                    },
                    column: {
                        color: '#33',
                        borderColor: '#333'
                    },
                    line: {
                        marker: {
                            symbol: 'circle',
                            radius: 1,
                            enabled: false
                        }
                    }
                },
                series: [
                    {name: "<?= lang('trd_167'); ?>", color: "#0C9700", data:[]},
                    {name: "<?= lang('trd_168'); ?>", color: "#C21500", data:[], visible: false},
//                    {
//                        name: "SALDO",
//                        dashStyle: "shortdot",
//                        color: "#858585",
//                        data: [],
//                        visible: false
//                    },
                    {
                        yAxis: 1,
                        name: "<?= lang('trd_169'); ?>",
                        type: "column",
                        color: "#4CB0FA",
                        data: [],
                        visible: false
                    }]
            });
            GeneratechartBalance(date_from,date_to);
        });

    $(document).on("click","#subscribeToTrader",function(event){

        var proceed = true;
        if($('#hand').is(':checked')) {
            var countChecked  = $("[name='quotes[]']:checked").length;
            if(countChecked == 0) {
                proceed = false;
            }
        }

        if(isInvalidRatio){

            $('#m_message').html('Sorry, you have chosen wrong copying ratio. Please change the ratio.');
            $('#cpy_modal').modal('show');
            proceed = false;
            return false;
        }

        if(proceed) {
            var projectName = '<?= $project; ?>';
            var accountType = '<?=  $fc_details['account_type']; ?>';
            var copy_edit = $('#is_edit').val();
            if(copy_edit == '0'){
                $('.conf-modal-title').html('<?= lang("trd_161"); ?>');
            }else{
                $('.conf-modal-title').html('<?= lang("trd_162"); ?>');
            }
            $('.conf-modal-desc').html('<?= lang("trd_163"); ?>');
            $('#confirmModal')
                .modal({ backdrop: 'static', keyboard: false })
                .on('click', '#confirm', function (e) {
                    if(copy_edit == '0'){
                        $.ajax({
                            type: 'POST',
                            url: url + 'copytrade/subscribeToTrader',
                            data: $('#subscribe-form').serialize(),
                            beforeSend: function () {
                                $('#loader-holder').show();
                                $('.subscribed').show();
                            }
                        }).done(function (response) {
                            $('#confirmModal').modal('hide');
                            $('#loader-holder').hide();
                            if (response.success) {
                                $("#subscribeToTrader").attr('value', 'Edit');
                                $('#is_edit').val(1);
                                $('#m_message').html('<?= lang("trd_164"); ?>');
                            } else {
                                if(response.err_msg == 'TYPE_NOT_THE_SAME'){
                                    $('#m_message').html("&ldquo;" + projectName + "&rdquo; uses &ldquo;" + accountType + "&rdquo; account in his trading strategy, register same &ldquo;account type&rdquo; to follow this Project.");
                                }else{
                                    $('#m_message').html(response.err_msg);
                                }
                            }
                            $('#cpy_modal').modal('show');

                        });
                        e.stopImmediatePropagation();
                        return false;
                    }else{
                        //update
                        UpdateCopySetting(con_id,user_id);
                        e.stopImmediatePropagation();
                        return false;

                    }
                    event.stopImmediatePropagation();
                    return false;
                });
        }else{


            $('#m_message').html('Please choose trading instruments to copy.');
            $('#cpy_modal').modal('show');

        }

        event.stopImmediatePropagation();
        return false;
    });

    $(document).on("click", "#apply", function () {


        var  from = $('#datepicker_from').val(),
            to = $('#datepicker_to').val(),
            type = $('.chart-nav li.active a').attr('href');


        if(type == '#profit_equity'){
            $('#balance_equity').hide();
            $('#profit_equity').show();
           // generatechartProfit(from,to);
            generatechartProfit();
        }else{
            GeneratechartBalance();
            //GeneratechartBalance(from,to);
            $('#profit_equity').hide();
            $('#balance_equity').show();
        }


    });

    function ShowQuotes() {
        document.getElementById('i-quotes-list').style.display = 'block';
    }
    function HideQuotes() {
        document.getElementById('i-quotes-list').style.display = 'none';
    }
    function ResetSelect(totalLots = 0,selectType = 1) {
        var a =  $('#icopy_settings_values_2_part_2').val();
        var b =  $('#icopy_settings_values_2_part_1').val();

        var c = a/b;
        var d = c;

        if(d == 0) d = 0.01;
        $('#copier').text(d);
        var lot = " lot deal";
        if(totalLots > 0){
            $('#icopy_settings_values_2_total').val(totalLots);
        }else{
            $('#icopy_settings_values_2_total').val(d);
        }

        if (d > 1000) {
            isInvalidRatio = true;
            if(d > 1000) {$('#all_text').text("Sorry, you have chosen wrong copying ratio. Please change the ratio");}
        } else {
            isInvalidRatio = false;
            if(d < 1) {lot = " lot deal"}
            else if(d == 1) {lot = " lot deal"}
            else if(d == 2) {lot = " lot deal"}
            else if(d == 3) {lot = " lot deal"}
            else if(d == 4) {lot = " lot deal"}
            else if(d == 5) {lot = " lots deal"}
            else if(d == 6) {lot = " lots deal"}
            else if(d == 7) {lot = " lots deal"}
            else if(d == 8) {lot = " lots deal"}
            else if(d == 9) {lot = " lots deal"}
            else if(d == 10) {lot = " lots deal"}
            else if(d > 10) {lot = " lots deal"};

            var copy_word = " copied to your account";
            if(d == 1) {copy_word = " copied to your account"}
            if(selectType == 2){
                var opt = $('#add_opt').val();
                var optVal = $('#add_opt_value').val();
                if(opt == 1){
                    // $('#copy_settings_values_2_part_2_'+ connection + 'option[value="' + optVal +'"]').remove();
                    $('#copy_settings_values_2_part_2').find('option:last').remove();
                }
            }
            if(totalLots > 0){
                totalLots = parseFloat(totalLots).toFixed(2);
                $('#icopy_settings_values_2_part_1').val(1);
                if(totalLots % 1 == 0){ // if whole number
                    totalLots = parseInt(totalLots); //remove decimal places
                }

                var exists = false;
                $('#icopy_settings_values_2_part_2 option').each(function(){
                    if (this.value == totalLots) {
                        exists = true;

                    }
                });
                if(!exists){
                    $('#add_opt').val(1);
                    $('#add_opt_value').val(totalLots);
                    $('select#copy_settings_values_2_part_2').append('<option value="'+totalLots+'" selected="selected">'+ totalLots + ' lot deal </option>');

                    $('#icopy_settings_values_2_part_2').append('<option value="'+totalLots+'" selected="selected">'+ totalLots + ' lot deal </option>');
                }else{
                    $('#add_opt').val(2);
                    $('#icopy_settings_values_2_part_2').val(totalLots)
                }

                $('#all_text').text("If a trader opens a " + '1' + " " + " lot deal" + ", you will get a " + totalLots + lot + copy_word);
            }else{
                $('#all_text').text("If a trader opens a " + '1' + " " + " lot deal" + ", you will get a " + parseFloat(d).toFixed(3) + lot + copy_word  );

            }

           // $('#all_text').text("If a trader opens a " + '1' + " " + " lot deal" + ", you will get a " + parseFloat(d).toFixed(3) + lot + copy_word  );
        }
    }
    function ResetSelectCopy() {

        var xy = $('#icopy_settings_values_3').val();
        var xd = Math.round(xy % 10);
        //alert(xy);
        var xc = "";
        if(xd == 1) {xc = " deal"}
        else if(xd == 2) {xc = " deals"}
        else if(xd == 3) {xc = " deals"}
        else if(xd == 4) {xc = " deals"}
        else if(xd == 5) {xc = " deals"}
        else if(xd == 6) {xc = " deals"}
        else if(xd == 7) {xc = " deals"}
        else if(xd == 8) {xc = " deals"}
        else if(xd == 9) {xc = " deals"}
        else if(xd == 0 & xy != 0) {xc = " deals"}
        else if(xy == 0) {xc = " all deals"}
        ;
        if(xy != 0) {
            $('#traider_copy_deals').text(xy + xc);
        } else {
            $('#traider_copy_deals').text(xc);
        }
    }
    function ResetCheckbox() {
        $(".check_quotes").removeAttr("checked");
    }
    function CheckedReset() {
        $("#hand").attr("checked","checked");
    }
    function ShowConditions(trader,con){
        console.log('request');
            $.ajax({
                type:'POST',
                url:url+'copytrade/show_conditions',
                data:{trader:trader,page:1,connection:con},
                beforeSend:function(){
                    $('#loader-holder').show();
                }
            }).done(function(response){
                console.log("success1");
                var cpSetting2 = response.copysetting_2;
               if(!response.isEmpty){
                   $.each( response.copysetting, function( key, value ) {
                       console.log( key + ": " + value );

                       switch(key){
                           case 'copy_settings_values_1':
                               if(value == 1){
                                   $("input#copy_settings_values_1_1").prop("checked", true);
                               }
                               if(value == 2){
                                   $("input#copy_settings_values_1_2").prop("checked", true);
                               }
                               if(value < 1){
                                   $("input#hand").prop("checked", true);
                               }
                               break;

                           case 'quotes':
                               $.each( value, function( key_q, value_q ) {
                                   $("input#qoute_" + value_q ).prop("checked", true);
                               });
                               break;
                           case 'copy_settings_values_2_part_1':
                           case 'copy_settings_values_2_part_2':
                           case 'copy_settings_values_3':
                           case 'min_lot_open':
                           case 'max_lot_open':
                           case 'limited_or_fixed':
                           case 'dont_copy':
                           case 'copy_inverse':
                           case 'copy_options':
                               $('select[name= "'+key+'"]').val(value);
                               SetLimit();
                               break;
                           case 'dont_copy':
                           case 'fixed_lot':
                           case 'copy_options':
                           case 'copy_inverse':
                           case 'min_lot_open':
                           case 'max_lot_open':
                           case 'limited_or_fixed':
                               $("#" + key ).prop("checked", true);
                               ResetSelect(cpSetting2);

                               break;

                           case 'icopy_settings_values_2_total':
                               $('input[name="'+key+'"]').val(cpSetting2);
                               break;
                       }

                       $('label[for=adv_settings]').html('View settings');

                       $("#subscribeToTrader").attr('value', 'Edit')
                       $('#is_edit').val(1);

                   });
               }
               
                $('#loader-holder').hide();

            });

    }
    function UpdateCopySetting(con_id,trader){

            $.ajax({
                type: 'POST',
                url: "/copytrade/UpdateCopySettingsv2",
                data: $('#subscribe-form').serialize()+'&trader='+trader +'&connection_id='+ con_id + '&page='+1,
                beforeSend: function () {
                    $('#loader-holder').show();
                    $('.subscribed').show();
                }
            }).done(function (response) {
                $('#confirmModal').modal('hide');
                $('#loader-holder').hide();
                if (response.success) {
                    $('#m_message').html('<?= lang("trd_135"); ?>');
                } else {
                    $('#m_message').html(response.err_msg);
                }
                $('#cpy_modal').modal('show');

            });


    }
    function ChangeTypeData(id) {
        if(id == 2){
            $('#balance_equity').hide();
            $('#profit_equity').show();
            generatechartProfit();
           // generatechartProfit(date_from,date_to);
        }else{
            GeneratechartBalance();
           // GeneratechartBalance(date_from,date_to);
            $('#profit_equity').hide();
            $('#balance_equity').show();
        }
    }
    function GeneratechartBalance() {
        //chart.setSize($('#balance_equity').width(), $('#balance_equity').height());
        $.ajax({
            type: 'POST',
            url: url + 'copytrade/getBalanceHistoryNew/'+ user_id,
            //data: {from:from,to:to},
            dataType: 'json',
            beforeSend: function () {
                // $('#loader-holder').show();
             chart.showLoading();
             chart.hideNoData();
            },
            success: function (data) {
                chart.hideLoading();
                if(data){
                    var seriesLength = chart.series.length;
                    for(var i = seriesLength - 1; i > -1; i--) {
                        chart.series[i].remove();
                    }





                    chart.redraw();
                    chart.addSeries({
                        name: '<?= lang("trd_167"); ?>',
                        data: data.data_balance,
                        color: "#0C9700",
                    });
                    chart.addSeries({
                        name: '<?= lang("trd_168"); ?>',
                        data: data.data_equity,
                        color: "#C21500",
                        visible: false,
                    });
//                chart.addSeries({
//                    name: 'SALDO',
//                    dashStyle: "shortdot",
//                    data: data.data_balance,
//                    color: "#858585",
//                    visible: false,
//                });
                    chart.addSeries({
                        name: '<?= lang("trd_169"); ?>',
                        yAxis: 1,
                        type: "column",
                        data: data.data_margin,
                        color: "#4CB0FA",
                        visible: false,
                    });
                }else{
                    chart.hideNoData();
                    chart.showNoData('<?= lang("trd_166"); ?>');
                }


               // chart(data.data_balance,data.data_margin,data.data_equity);
                // $('#loader-holder').hide();
                if (!chart.hasData()) {
                    chart.hideNoData();

                    chart.showNoData('<?= lang("trd_166"); ?>');
                }
            }
        });


    }
    function generatechartProfit() {

        $.ajax({
            type: 'POST',
            url: url + 'copytrade/getProfitHistoryNew/'+ user_id,
            //data: {from:from,to:to},
            dataType: 'json',
            beforeSend: function () {
                // $('#loader-holder').show();
                profit.hideNoData();
             profit.showLoading();
            },
            success: function (data) {
                profit.series[0].remove(true);
                profit.addSeries({
                    name: 'PROFIT',
                    data: data.data_profit,
                    color: "#0C9700",
                });


               // chart(data.data_balance,data.data_margin,data.data_equity);
                // $('#loader-holder').hide();
                profit.hideLoading();
                if (!profit.hasData()) {
                    profit.hideNoData();

                    profit.showNoData('<?= lang("trd_166"); ?>');
                }
            }
        });


    }
    function LimitOrFixed(val) {
        if(val == 0) {
            $('#limited_lots').show();
            $('#fixed_lot').hide();
        } else {
            $('#limited_lots').hide();
            $('#fixed_lot').show();
        }
    }
    function SetLimit() {
        $('#min').html(jQuery.trim($('select[name=min_lot_open] option:selected').text()));
        $('#max').html(jQuery.trim($('select[name=max_lot_open] option:selected').text()));
    }
    function SetFixedLot() {
        $('#fixed_lot_span').html(jQuery.trim($('select[name=fixed_lot]').val()));
    }
    function ShowHideSettings() {
        $('#advanced_settings').toggle();
        if($('#adv_settings').is(':checked')) {
            $('label[for=adv_settings]').html('View settings');
        } else {
            $('label[for=adv_settings]').html('Hide settings');
        }
    }
</script>


