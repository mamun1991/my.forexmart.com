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

            
            <li>
                        <a href="<?=FXPP::my_url('copytrade/rollover-commission')?>" id = "tab6" ><?= lang('trd_277'); ?></a>
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
                            <?= lang('trd_141'); ?>  <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('reg_trader_41'); ?>"></i>
                        </td>
                        <td style="padding-bottom: 9px;"><?=  $trader_data['conditions_values_1'] ? $copytermsDisplay : lang('trd_113'); ?></td>
                    </tr>
                    <tr class="commission_copier_payer">
                        <td class="right" style="width: 50%">
                            <?= lang('trd_142'); ?>  <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('reg_trader_42'); ?>"></i>
                        </td>
                        <td style="padding-bottom: 9px;"><?=  $trader_data['conditions_values_2'] ? $copytermsDisplay : lang('trd_113'); ?> </td>
                    </tr>
                    <tr class="commission_copier_payer">
                        <td class="right" style="width: 50%">
                            <?= lang('trd_115'); ?> <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('reg_trader_43'); ?>"></i>
                        </td>
                        <td style="padding-bottom: 9px;"><?=  $trader_data['conditions_values_10'] ? $copytermsDisplay : lang('trd_113'); ?> </td>
                    </tr>
                    <tr class="commission_copier_payer">
                        <td class="right" style="width: 50%">
                            <?= lang('trd_116'); ?>   <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('reg_trader_44'); ?>"></i>
                        </td>
                        <td style="padding-bottom: 9px;">  <?=  $trader_data['conditions_values_3'] ? $copytermsDisplay : lang('trd_113'); ?>   </td>
                    </tr>
                    <tr class="commission_copier_payer">
                        <td class="right" style="width: 50%">
                            <?= lang('trd_117'); ?>   <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('reg_trader_45'); ?>"></i>
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
                                            <td><?= lang('copytrade_06'); ?></td>
                                            <td class="center" style="padding-left: 10px;"><input type="radio" id="copy_settings_values_1_2" name="copy_settings_values_1" value="2" onclick="ResetCheckbox()"></td>
                                        </tr>
                                        <tr>
                                            <td style=""><?= lang('copytrade_07'); ?></td>
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
                                            <!--<td width="180px">Trader:</td>-->
                                            <td style="padding-right: 23px; text-align:center;padding-top: 10px;padding-bottom: 10px;">
                                                <input type="hidden" style="width: 137px;display:inline-block;" class="form-control" name="copy_settings_2_default" id="copy_settings_2_default" value="0.01">
                                                <input type="number" style="width: 137px;display:inline-block;" class="form-control" name="copy_settings_values_2" id="copy_settings_values_2" value="0.01" step=".01" min=".01" max="1000" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><span id="all_text"><?= lang('copytrade_08'); ?></span>
                                                <div style="display: none; color: red" id="eu_warning"><?= lang('copytrade_09'); ?></div></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="well" height="50%">
                                    <center>
                                        <?= lang('copytrade_10'); ?>			</center>
                                    <table class="center w100">
                                        <tbody><tr>
                                            <td width="180px">
                                                <?= lang('copytrade_11'); ?>                    </td>

                                            <td style="padding-right: 23px; text-align:center;">
                                                <select style="width: 120px;" class="form-control" name="copy_settings_values_3" id="icopy_settings_values_3" onchange="ResetSelectCopy()">
                                                    <option value="0"><?= lang('copytrade_12'); ?></option>
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
                                                <?= lang('copytrade_13'); ?>
                                            </td>
                                        </tr>
                                        </tbody></table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left; border: none;" class="well">
                                    <span  style="float: left; margin-right: 8px; height: 35px;"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                    <div><?= lang('copytrade_14'); ?></div>
                                    <div style="float: right">
                                        <a onclick="ShowHideSettings()">
                                            <label for="adv_settings" style="cursor: pointer;"><?= lang('copytrade_15'); ?></label>
                                        </a>
                                    </div>
                                    <input type="checkbox" name="use_adv_settings" id="adv_settings" style="display:none">
                                </td>
                            </tr>
                            <tr id="advanced_settings" style="display: none">
                                <td colspan="2" style="text-align: left; border: none;" class="well">
                                    <div class="simple-wnd">
                                        <div><?= lang('copytrade_16'); ?></div>
                                        <div id="advanced_settings_select">
                                            <select class="form-control" style="width: 200px;" name="limited_or_fixed" onchange="LimitOrFixed($(this).val())">
                                                <option value="0"><?= lang('copytrade_17'); ?></option>
                                                <option value="1"><?= lang('copytrade_18'); ?></option>
                                            </select>
                                        </div>
                                        <div style="" id="limited_lots_holder">
                                            <div>
                                                <div style="width: 50%; float:left"><?= lang('copytrade_19'); ?></div>
                                                <div style="width: 48%; float:right;">
                                                    <div class="row">
                                                        <div class="col-md-5" style="padding: 1px 10px!important;"><?= lang('copytrade_20'); ?></div>
                                                        <div class="col-md-5" style="padding: 3px;">
                                                         								<select name="min_lot_open" class="form-control" onchange="SetLimit()" style="">
										<option value="0.01">
											0.01                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.02">
											0.02                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.03">
											0.03                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.04">
											0.04                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.05">
											0.05                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.06">
											0.06                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.07">
											0.07                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.08">
											0.08                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.09">
											0.09                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.1">
											0.1                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.2">
											0.2                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.3">
											0.3                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.4">
											0.4                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.5">
											0.5                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.6">
											0.6                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.7">
											0.7                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.8">
											0.8                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="0.9">
											0.9                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="1">
											1                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="2">
											2                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="3">
											3                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="4">
											4                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="5">
											5                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="6">
											6                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="7">
											7                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="8">
											8                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="9">
											9                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="10">
											10                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="15">
											15                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="20">
											20                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="25">
											25                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="30">
											30                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="35">
											35                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="40">
											40                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="45">
											45                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="50">
											50                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="55">
											55                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="60">
											60                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="65">
											65                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="70">
											70                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="75">
											75                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="80">
											80                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="85">
											85                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="90">
											90                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="95">
											95                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="100">
											100                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="200">
											200                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="300">
											300                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="400">
											400                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="500">
											500                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="600">
											600                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="700">
											700                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="800">
											800                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="900">
											900                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="1000">
											1000                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
									</select>
								</div>
                                                    </div>
                                                </div>
                                                <div style="width: 48%; float:right">
                                                    <div class="row">
                                                        <div class="col-md-5" style="padding: 1px 10px!important;margin-top:-3px;"><?= lang('copytrade_22'); ?></div>
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
											5                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="6">
											6                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="7">
											7                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="8">
											8                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="9">
											9                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="10">
											10                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="15">
											15                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="20">
											20                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="25">
											25                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="30">
											30                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="35">
											35                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="40">
											40                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="45">
											45                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="50">
											50                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="55">
											55                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="60">
											60                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="65">
											65                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="70">
											70                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="75">
											75                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="80">
											80                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="85">
											85                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="90">
											90                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="95">
											95                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="100">
											100                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="200">
											200                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="300">
											300                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="400">
											400                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="500">
											500                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="600">
											600                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="700">
											700                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="800">
											800                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="900">
											900                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
										<option value="1000" selected="selected">
											1000                                                         <?= lang('reg_trader_46'); ?>                                                    </option>
									</select>
								</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="clear:both"></div>
                                            <div style="margin-top: 5px;"><?= lang('copytrade_22'); ?></div>
                                            <div>
                                                <div style="float: left;">
                                                    <input style="margin: 2px 0 0;" type="checkbox" id ="dont_copy" name="dont_copy" value="0">&nbsp;&nbsp;
                                                </div>
                                                <div>
                                                   <?= lang('copytrade_23'); ?>                                             <style>
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
                                                    </script>    <span style="margin-top:-6px;"  title="" class="tooltip-help" data-original-title="<?= lang('copytrade_24'); ?>">
                                   <i class="fa fa-question-circle" aria-hidden="true"></i>
                                </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="fixed_lot_holder" style="display: none">
                                            <div style="width: 50%; float:left"><?= lang('copytrade_25'); ?></div>
                                            <div style="width: 48%; float:right">
                                                <div style="float: left;"><?= lang('copytrade_26'); ?></div>
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
                                            <div style="margin-top: 5px;"><?= lang('copytrade_27'); ?></div>
                                        </div>
                                    </div>
                                    <div class="simple-wnd" style="margin-top: 5px;">
                                        <div>
                                            <?= lang('copytrade_28'); ?>
                                        </div>
                                        <div>
                                            <div style="float: left;">
                                                <input style="margin: 2px 0 0;" type="checkbox" id ="copy_options" name="copy_options" value="0">&nbsp;&nbsp;
                                            </div>
                                            <div>
                                                <?= lang('copytrade_29'); ?>                                                <style>
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
                                                </script>    <span style="margin-top:-6px;" title="" class="tooltip-help" data-original-title="<?= lang('copytrade_30'); ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    </div>
<!--                                    <div class="simple-wnd" style="margin-top: 5px;">
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
                            <input type="button" class="sprites btn btn-main" rel="subscribe" id="subscribeToTrader" value="Subscribe">
                        </center>
                    </form>
                </div>

            <?php }?>

























            <div class="clear-all"></div>


            <h2 class="header-trader-inf" style="border: 0 !important"><?= lang('trd_147'); ?></h2>
            <div role="tabpanel" class="tab-pane table-responsive active">

                <table cellspacing="0" cellpadding="0" class="table table_main table-striped">
                    <thead>
                    <tr>
                        <th colspan="2" style="width: 50%; vertical-align: middle;"><strong><?= lang('trd_148'); ?></strong></th>
                        <th colspan="2" style="width: 50%; vertical-align: middle;"><strong><?= lang('trd_149'); ?></strong><span style="font-weight: normal; font-style: italic; float: right"><?= lang('trd_150'); ?> <?= $fc_details['LastUpdate']; ?></span></th>
                    </tr>
                    </thead>
                    <tbody>
                        
                     <tr>
                        <td style="width: 100px; vertical-align: middle;"><?= lang('copytrade_30'); ?></td>
                        <td style="vertical-align: middle;"><?= lang('copytrade_31'); ?></td>
                        <td style="width: 180px; vertical-align: middle;"><?= lang('copytrade_32'); ?></td>
                        <td style="width: 111px; max-width: 111px; vertical-align: middle;"><?=$fc_details['ActiveFollowers'] ?>  </td>
                    </tr>
                     
                        
                    <tr>
                        <td style="width: 100px; vertical-align: middle;"><?= lang('copytrade_33'); ?></td>
                        <td style="vertical-align: middle;"><?= FXPP::isHiddenItem($fc_details['UserId']); ?></td>
                        <td style="width: 180px; vertical-align: middle;"><?= lang('copytrade_34'); ?></td>
                        <td style="vertical-align: middle;"><nobr><?=  $bal_details['LastBalance']; ?>  <?=  $fc_details['account_currency']; ?></nobr></td>
                    </tr>
                    <tr>
                        <td style="width: 100px;vertical-align: middle;"><?= lang('copytrade_35'); ?></td>
                        <td style="vertical-align: middle;"><?=  $fc_details['account_type']; ?> </td>
                        <td style="width: 180px; vertical-align: middle;"><?= lang('copytrade_36'); ?></td>
                        <td style="vertical-align: middle;"><nobr><?=  $bal_details['LastEquity']; ?>&nbsp;<?=  $fc_details['account_currency']; ?></nobr></td>
                    </tr>
                    <tr>
                        <td style="width: 100px;vertical-align: middle;"><?= lang('copytrade_37'); ?></td>
                        <td style="vertical-align: middle;"><?=   $fc_details['ProjectName']; ?></td>
                        <td style="width: 180px; vertical-align: middle;"><?= lang('copytrade_38'); ?></td>
                        <td style="vertical-align: middle;"><?=  $bal_details['OpenTrades']; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 100px; vertical-align: middle;"><?= lang('copytrade_33'); ?></td>
                        <td style="vertical-align: middle;"><span class="hidden-msg"><?= FXPP::isHiddenItem($fc_details['AccountName']); ?></span></td>
                        <td style="width: 180px;vertical-align: middle;"><?= lang('copytrade_39'); ?></td>
                        <td style="vertical-align: middle;"><?=  $bal_details['CloseTrades']; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 100px; vertical-align: middle;"><?= lang('copytrade_4'); ?></td>
                        <td style="vertical-align: middle;"><?= FXPP::isHiddenItem($fc_details['Icq']); ?></td>
                        <td style="width: 180px; vertical-align: middle;"><?= lang('copytrade_41'); ?></td>
                        <td style="vertical-align: middle;"><nobr><?=  $bal_details['BalancePerDay']; ?>&nbsp;<?=  $fc_details['account_currency']; ?></nobr></td>
                    </tr>
                    <tr>
                        <td style="width: 100px; vertical-align: middle;"><?= lang('copytrade_42'); ?></td>
                        <td style="vertical-align: middle;"><?= FXPP::isHiddenItem($fc_details['Phone']); ?></td>
                        <td style="width: 180px; vertical-align: middle;"><?= lang('copytrade_43'); ?></td>
                        <td style="vertical-align: middle;"><nobr><?= $bal_details['TotalBalanceIncrease']; ?>&nbsp;<?=  $fc_details['account_currency']; ?></nobr></td>
                    </tr>
                    <tr>
                        <td style="width: 100px; vertical-align: middle;"><?= lang('copytrade_44'); ?></td>
                        <td style="vertical-align: middle;"><?= FXPP::isHiddenItem($fc_details['Email']); ?></td>
                        <td style="width: 180px; vertical-align: middle;"><?= lang('copytrade_45'); ?></td>
                        <td style="vertical-align: middle;"><nobr><?=  $bal_details['EquityPerDay']; ?>&nbsp;<?=  $fc_details['account_currency']; ?></nobr></td>
                    </tr>
                    <tr>
                        <td style="width: 100px; vertical-align: middle;"><?= lang('copytrade_46'); ?></td>
                        <td style="vertical-align: middle;"><?=  FXPP::isHiddenItem($fc_details['Skype']); ?>&nbsp;</td>
                        <td style="width: 180px; vertical-align: middle;"><?= lang('copytrade_47'); ?></td>
                        <td style="vertical-align: middle;"><nobr><?= $bal_details['TotalEquityIncrease']; ?>&nbsp;<?=  $fc_details['account_currency']; ?></nobr></td>
                    </tr>
                    </tbody>
                </table>

            </div>


            <div class="content-delimetr"></div>


            <div role="tabpanel" class="tab-pane table-responsive active">
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
            </div>

            <div class="content-delimetr"></div>
            <div>
                <!--            <ul class="nav nav-tabs chart-nav" role="tablist" style="margin-bottom: 1px;">-->
                <!--                <li role="presentation" class="active"><a href="#balance_equity" aria-controls="balance_equity" role="tab" onclick="ChangeTypeData(1)" data-toggle="tab">Balance / Equity</a></li>-->
                <!--                <li role="presentation"><a href="#profit_equity" aria-controls="profit_equity" role="tab" onclick="ChangeTypeData(2)" data-toggle="tab">Profit percent</a></li>-->
                <!--            </ul>-->

                <ul class="nav nav-pills" style="margin-bottom: 15px;">
                    <li class="tab-balance active"><a href="#balance_equity" onclick="ChangeTypeData(1)" data-toggle="tab" style="border-radius: 0px;padding-top: 20px;"><?= lang('trd_158'); ?></a></li>
                    <li class="tab-profit" style="width: 130px;"><a href="#profit_equity" onclick="ChangeTypeData(2)" data-toggle="tab" style="border-radius: 0px;padding-top: 20px;"><?= lang('copytrade_48'); ?></a></li>
                </ul>
                <div class="option_form" style="border: 1px solid #BBB5B7;">

                    <!-- График -->


                    <!-- Выбор даты -->
                    <div class="col-md-12">
                        <div class="row" style="width: 100%; padding-top: 3px; padding-bottom: 3px;">
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
                <button type="button" class="btn btn-success btn-form" data-dismiss="modal"><?= lang('copytrade_49'); ?></button>
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
                <input type="button" class="btn btn-default"  data-dismiss="modal" value="<?= lang('copytrade_50'); ?>">
                <input type="button" class="btn btn-danger" id ='confirm' value="<?= lang('copytrade_51'); ?>">
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
               // ResetSelect();
                ResetSelectCopy();
                SetLimit();
                SetFixedLot();

                $('#copy_settings_values_2').bind('keyup input', function(){
                    CalculateRatio();
                });


                if(is_subscribe){ // is account subscribe already?
                    ShowConditions(con_id);
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
                lang: {
					viewFullscreen:'<?= lang("copytrade_52"); ?>',
                    printChart: '<?= lang("copytrade_53"); ?>',
                    downloadPNG: '<?= lang("copytrade_54"); ?>',
                    downloadJPEG: '<?= lang("copytrade_55"); ?>',
                    downloadPDF: '<?= lang("copytrade_56"); ?>',
                    downloadSVG: '<?= lang("copytrade_57"); ?>',
                    /*contextButtonTitle: '<?= lang("copytrade_52"); ?>Context menu..'*/
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

var is_edit_subscribed=0;
    $(document).on("click","#subscribeToTrader",function(event){

        var proceed = true;
        if($('#hand').is(':checked')) {
            var countChecked  = $("[name='quotes[]']:checked").length;
            if(countChecked == 0) {
                proceed = false;
            }
        }
        $('#copy_settings_values_2').css('border','');
        if($('#copy_settings_values_2').val().length === 0){
            $('#copy_settings_values_2').css('border','2px solid red');
            proceed = false;
            return false;
        }

       if(con_id.length === 0 &&  $('#is_edit').val() == 1){
          // for update copysetting only
        
            $('#m_message').html('Connection Id not found, Please try again later or contact support.');
            $('#cpy_modal').modal('show');
            proceed = false;
            return false;
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
             var rel_edit=$("#subscribeToTrader").attr('rel');
            rel_edit=rel_edit.replace(/\s/g, "");
          
            copy_edit=(parseInt(copy_edit)==parseInt(0))?((rel_edit=="edit")?1:0):copy_edit;
            
            
            if(copy_edit == '0'){
                $('.conf-modal-title').html('<?= lang("trd_161"); ?>');
            }else{
                $('.conf-modal-title').html('<?= lang("trd_162"); ?>');
            }
            $('.conf-modal-desc').html('<?= lang("trd_163"); ?>');
            $('#confirmModal')
                .modal({ backdrop: 'static', keyboard: false })
                .on('click', '#confirm', function (e) {
                    
                   
           
                    copy_edit=(copy_edit=='0')?(is_edit_subscribed==1)?1:0:copy_edit;
                    
                     
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
                                
                             //     console.log(response);
                                
                                var sub_data=response.data;
                           
                                is_edit_subscribed=1;
                                is_subscribe=sub_data.is_subscribe;
                               con_id= sub_data.connection;
      
                                console.log(" connection id>>>",con_id);
                                
                                $("#subscribeToTrader").attr('value', 'Edit');
                                  $("#subscribeToTrader").attr('rel', 'edit');
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
    function ShowConditions(conId){
        $.ajax({
            type:'POST',
            url:url+'copytrade/show_conditions',
            data:{connection:conId},
            beforeSend:function(){
                $('#loader-holder').show();
            }
        }).done(function(response){
            
             
            
            
             var cpSetting3 = response.copysetting_3;
             
                var cpSetting2 = response.copysetting_2;
                var cpSetting1 = response.copysetting_1;
                var cpSetting5 = response.copysetting_5;
                var cpSetting6 = response.copysetting_6;
                var cpSetting7 = response.copysetting_7;
                var cpSetting8 = response.copysetting_8;
                var cpSetting9 = response.copysetting_9;

                 ResetCheckbox();
                //currency instrument
                
                
                if(cpSetting3!=""){ 
                   
                    $('#icopy_settings_values_3 option[value="'+cpSetting3+'"]').attr("selected", "selected");
                }
                
                
                
                if(cpSetting1 == 1){
                    $("#copy_settings_values_1_1").prop("checked", true);
                }else if(cpSetting1 == 2){
                    $("#copy_settings_values_1_2").prop("checked", true);
                }else{
                    $("#hand").prop("checked", true);
                    var i;
                    for (i = 0; i < response.currency_code.length; i++) {
                        $("#qoute_"+ response.currency_code[i]).prop("checked", true);
                    }

                }


                $("#copy_settings_2_default").val(cpSetting2); //ratio default
                $("#copy_settings_values_2").val(cpSetting2); //ratio
                CalculateRatio();

                if(cpSetting5 == cpSetting6){
                    $('select[name= "limited_or_fixed"]').val(1); // fixed lot
                    LimitOrFixed(1);
                    SetFixedLot();
                    $('select[name=fixed_lot]').val(cpSetting5);
                }else{
                    $('select[name= "limited_or_fixed"]').val(0); //  lot range
                    LimitOrFixed(0);
                    //max lot
                    $('select[name= "max_lot_open"]').val(cpSetting5);
                    //min  lot
                    $('select[name= "min_lot_open"]').val(cpSetting6);
                    SetLimit();
                }

                $('#dont_copy').val(cpSetting7);
                $('#copy_options').val(cpSetting8);
                $('#copy_inverse').val(cpSetting9);
                if(cpSetting7 == 1){
                    $("#dont_copy").prop("checked", true);
                }
                if(cpSetting8 == 1){
                    $("#copy_options").prop("checked", true);
                }
                if(cpSetting9 == 1){
                    $("#copy_inverse").prop("checked", true);
                }

                $("#subscribeToTrader").attr('value', 'Edit')
                $('#is_edit').val(1);
                $('label[for=adv_settings]').html('View settings');

            $('#loader-holder').hide();

        });

    }
    function UpdateCopySetting(con_id,trader){

        $.ajax({
            type: 'POST',
            url: "/copytrade/UpdateCopySettings",
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
            $('#limited_lots_holder').show();
            $('#fixed_lot_holder').hide();
        } else {
            $('#limited_lots_holder').hide();
            $('#fixed_lot_holder').show();
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

    function CalculateRatio(){
        var d = $('#copy_settings_values_2').val();
        if(d == 0) d = 0.01;
        if (d > 1000) {
            isInvalidRatio = true;
            if(d > 1000) {$('#all_text').text("Sorry, you have chosen wrong copying ratio. Please change the ratio.");}
        } else {
            isInvalidRatio = false;
           var  lot = (d > 1) ? " lots deal" : " lot deal"
            $('#all_text').text("If a trader opens a vvvvv " + '1' + " " + " lot deal" + ", you will get a " + d + lot + " copied to your account.");

     }

    }
    
    
   
   
    $(document).on("blur","#copy_settings_values_2",function(){
    
    // Can be entered value less than 0.1, more than 1000 - they are saved
  var val_amt=$(this).val();
  val_amt=parseFloat(val_amt);
  var def_min=0.1;
  var def_max=1000;
  if(val_amt<parseFloat(def_min))
  {
      $(this).val(def_min);
  }
  else if(val_amt>parseFloat(def_max))
  {
      $(this).val(def_max);
  }
     
 });
    
    
</script>


