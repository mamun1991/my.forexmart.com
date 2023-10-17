<h1>
    <?= lang('mya_01'); ?>
</h1>
<?php $this->load->view('account_nav.php'); ?>

<style>
    .data-input-choice {
        float: left;
        height: 27px;
        width: 15%;
    }
    .form-group {
        margin-bottom: 30px!important;
    }
    .trading-form {
        text-align: left;
    }
    label.control-label-trading {
        margin-right: 15px;
    }
    .input-radio
    {
        padding-top: 7px;
        margin-top: 0;
        margin-bottom: 0;
        text-align: left;
        position: relative;
        display: inline-block;
        padding-left: 20px;
        vertical-align: middle;
        cursor: pointer;
        font-weight: normal;
    }

    .no-padding-column {
        padding-top: 12px !important;
    }
    div.padding-0{
        padding-top: 0px !important;
    }
    .span-01:lang(ru){
        width: 90%;
        text-align: left;
    }

</style>

<div role="tabpanel" class="tab-pane row col-centered hide-div" id="trading">
<div class="col-lg-10 col-md-10 col-centered">
<div class="form-holder registration-form-holder">
<div class="title-registration-form-holder">
    <img class="img" src="<?= $this->template->Images() ?>step.png" width="50" height="50"/>

    <h1><?= lang('reli_11'); ?></h1>
</div>
<div class="clearfix"></div>
<div class="form-horizontal form-max-holder">
<div class="form-group">
    <label for="inputEmail3"
           class="col-sm-4 control-label control-label-trading no-padding-column-label"><?= lang('reli_12'); ?><cite
            class="req">*</cite></label>

    <div class="col-sm-6 no-padding-column">
        <select class="form-control round-0 required" name="mt_account_set_id"
                id="mt_account_set_id"><?php echo $account_type; ?></select>
        <span class="error_p" id="error_mt_account_set_id"><?php echo form_error('mt_account_set_id'); ?></span>
    </div>
</div>
<div class="form-group">
    <label for="inputPassword3"
           class="col-sm-4 control-label control-label-trading no-padding-column-label"><?= lang('reli_13'); ?><cite
            class="req">*</cite></label>

    <div class="col-sm-6 no-padding-column">
        <select class="form-control round-0 required" name="mt_currency_base"
                id="mt_currency_base"><?php echo $account_currency_base; ?></select>
        <span class="error_p" id="error_mt_currency_base"><?php echo form_error('mt_currency_base'); ?></span>
    </div>
</div>

<div class="form-group">
    <label for="inputPassword3"
           class="col-sm-4 control-label control-label-trading no-padding-column-label"><?= lang('reli_14'); ?><cite
            class="req">*</cite></label>

    <div class="col-sm-6 no-padding-column">
        <input name="default_leverage" type="hidden" value="50">
        <select class="form-control round-0 required" name="leverage" id="xleverage">
            <?php echo $leverage; ?>
        </select>
        <span class="error_p" id="error_leverage"><?php echo form_error('leverage'); ?></span>
    </div>
</div>

<div class="form-group form-no-label-group">
    <label class="col-sm-4 no-data-label">&nbsp;</label>

    <div class="col-sm-6 no-padding-column">
        <div class="checkbox-data">
            <input
                name="swap_free"<?php echo isset($user_details['swap_free']) ? $user_details['swap_free'] ? ' checked' : '' : '' ?>
                value="1" type="checkbox"/>
            <span><?= lang('reli_15'); ?></span>
        </div>
    </div>
</div>
<div class="form-group block-form-group">
    <label
        class="col-sm-4 control-label control-label-trading no-padding-column-label trading-exp-label"><?= lang('reli_16'); ?>
        <cite class="req">*</cite></label>

    <div class="col-sm-6 paragraph-data no-padding-column"><p><?= lang('reli_17'); ?></p></div>
</div>
<div class="form-group form-no-data-group form-no-label-group no-margin-column">
    <label class="col-sm-4 no-data-label">&nbsp;</label>

    <div class="col-sm-6 no-padding-column">
        <div class="checkbox-data">
            <input id="agree-1" type="checkbox"
                   name="experience" <?php echo isset($user_details['trading_experience_value'][0]) ? $user_details['trading_experience_value'][0] ? ' checked' : '' : '' ?>
                   value="1"/>
            <span class="span-01"><?= lang('reli_n_18'); ?></span>
        </div>
    </div>
</div>
<div class="form-group form-no-data-group form-no-label-group no-margin-column">
    <label class="col-sm-4 no-data-label">&nbsp;</label>

    <div class="col-sm-6 no-padding-column">
        <div class="checkbox-data">
            <input id="agree-2" type="checkbox"
                   name="experience" <?php echo isset($user_details['trading_experience_value'][0]) ? $user_details['trading_experience_value'][1] ? ' checked' : '' : '' ?>
                   value="2"/>
            <span><?= lang('reli_n_19'); ?></span>
        </div>
    </div>
</div>
<div class="form-group form-no-label-group no-margin-column">
    <label class="col-sm-4 no-data-label">&nbsp;</label>

    <div class="col-sm-6 no-padding-column">
        <div class="checkbox-data">
            <input id="agree-3" type="checkbox"
                   name="experience"<?php echo isset($user_details['trading_experience_value'][0]) ? $user_details['trading_experience_value'][2] ? ' checked' : '' : '' ?>
                   value="3"/>
            <span><?= lang('reli_n_20'); ?></span>
        </div>
    </div>
</div>
<div class="form-group form-no-label-group no-margin-column">
    <label class="col-sm-4 no-data-label">&nbsp;</label>

    <div class="col-sm-6 no-padding-column">
        <div class="checkbox-data">
            <input id="agree-4" type="checkbox"
                   name="experience"<?php echo isset($user_details['trading_experience_value'][0]) ? $user_details['trading_experience_value'][3] ? ' checked' : '' : '' ?>
                   value="4"/>
            <span><?= lang('reli_n_21'); ?></span>
        </div>
    </div>
</div>
<div class="form-group form-no-label-group">
    <label class="col-sm-4 no-data-label">&nbsp;</label>

    <div class="col-sm-6 paragraph-data no-padding-column">
        <p><?= lang('reli_22'); ?>?</p>
    </div>
    <label class="col-sm-4 control-label control-label-trading no-padding-column-label "><?= lang('reli_21'); ?><cite
            class="req">*</cite></label>

    <div class="col-sm-6 no-padding-column">
        <select class="form-control round-0 required" name="investment_knowledge"
                id="investment_knowledge"><?php echo $investment_knowledge; ?></select>
        <span class="error_p" id="error_investment_knowledge"><?php echo form_error('investment_knowledge'); ?></span>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4 control-label control-label-trading no-padding-column-label"><?= lang('reli_23'); ?>?<cite
            class="req">*</cite></label>

    <div class="col-sm-6 no-padding-column">
        <select class="form-control round-0 required" name="trade_duration"
                id="trade_duration"><?php echo $trade_duration; ?></select>
        <span class="error_p" id="error_trade_duration"><?php echo form_error('trade_duration'); ?></span>
    </div>
</div>

<div class="form-group block-form-group">
    <label class="col-sm-4 control-label  control-label-trading no-padding-column-label"><?= lang('reg_per_05'); ?>
        <cite class="req">*</cite></label>

    <div class="col-sm-6 no-padding-column">
        <select class="form-control round-0 required" name="number_of_trades"
                id="number_of_trades"><?php echo $number_of_trades; ?></select>
        <span class="error_p" id="error_number_of_trades"><?php echo form_error('number_of_trades'); ?></span>
    </div>
</div>

<div class="form-group block-form-group">
    <label
        class="col-sm-4 control-label control-label-trading no-padding-column-label trading-exp-label"><?= lang('reg_per_06'); ?>
        <cite class="req">*</cite></label>

    <div class="col-sm-6 paragraph-data no-padding-column">

        <div class="form-group form-no-data-group form-no-label-group no-margin-column">
            <div class="col-sm-12 no-padding-column padding-0">
                <div class="checkbox-data">
                    <label class="input-radio">
                        <input id="otc-1" type="radio" name="otc_meaning"
                               style="float: left; margin-left: -20px;" <?php echo isset($user_details['otc_meaning']) ? $user_details['otc_meaning'] ? ' checked' : '' : ' checked' ?>
                               value="1"/>
                        <?= lang('reg_per_07'); ?>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group form-no-data-group form-no-label-group no-margin-column">
            <div class="col-sm-12 no-padding-column" style="text-align:left;">
                <div class="checkbox-data">
                    <label class="input-radio">
                        <input id="otc-2" type="radio" name="otc_meaning"
                               style="float: left; margin-left: -20px;" <?php echo isset($user_details['otc_meaning']) ? $user_details['otc_meaning'] ? '' : ' checked' : '' ?>
                               value="2"/>
                        <?= lang('reg_per_08'); ?>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group form-no-label-group no-margin-column">
            <div class="col-sm-12 no-padding-column">
                <div class="checkbox-data">
                    <label class="input-radio">
                        <input id="otc-3" type="radio" style="float: left; margin-left: -20px;"
                               name="otc_meaning"<?php echo isset($user_details['otc_meaning']) ? $user_details['otc_meaning'] ? '' : ' checked' : '' ?>
                               value="3"/>
                        <?= lang('reg_per_09'); ?>
                    </label>
                </div>
            </div>
        </div>

    </div>
</div>



    <div class="form-group trading-form block-form-group">
        <label class="col-sm-4 control-label control-label-trading no-padding-column-label trading-exp-label">With which
            possible ways can an open trading position be closed?<cite class="req">*</cite></label>

        <div class="col-sm-6 paragraph-data no-padding-column">

            <div class="form-group form-no-data-group form-no-label-group no-margin-column">
                <div class="col-sm-12 no-padding-column padding-0">
                    <div class="checkbox-data">
                        <label class="input-radio">
                            <input id="ways-1" type="radio" name="trading_ways"
                                   style="float: left; margin-left: -20px;" <?php echo isset($user_details['trading_ways']) ? $user_details['trading_ways'] ? ' checked' : '' : ' checked' ?>
                                   value="1"/>
                            With an order to ‘Take Profit’ or ‘Stop Loss’?
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group form-no-data-group form-no-label-group no-margin-column">
                <div class="col-sm-12 no-padding-column" style="text-align:left;">
                    <div class="checkbox-data">
                        <label class="input-radio">
                            <input id="ways-2" type="radio" name="trading_ways"
                                   style="float: left; margin-left: -20px;" <?php echo isset($user_details['trading_ways']) ? $user_details['trading_ways'] ? '' : ' checked' : '' ?>
                                   value="2"/>
                            With a request for withdrawal of funds from your account balance?
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group form-no-label-group no-margin-column">
                <div class="col-sm-12 no-padding-column">
                    <div class="checkbox-data">
                        <label class="input-radio">
                            <input id="ways-3" type="radio" style="float: left; margin-left: -20px;"
                                   name="trading_ways" <?php echo isset($user_details['trading_ways']) ? $user_details['trading_ways'] ? '' : ' checked' : '' ?>
                                   value="3"/>
                            With both the above.
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group form-no-label-group no-margin-column">
                <div class="col-sm-12 no-padding-column">
                    <div class="checkbox-data">
                        <label class="input-radio">
                            <input id="ways-4" type="radio" style="float: left; margin-left: -20px;"
                                   name="trading_ways" <?php echo isset($user_details['trading_ways']) ? $user_details['trading_ways'] ? '' : ' checked' : '' ?>
                                   value="4"/>
                            None of the above.
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group trading-form block-form-group">
        <label class="col-sm-4 control-label control-label-trading no-padding-column-label trading-exp-label">You have
            deposited GBP 3,000 in your trading account and bought 1 standard lot of CFDs on EURGBP at a price of 1.100.
            Which of the statements is true?<cite class="req">*</cite></label>

        <div class="col-sm-6 paragraph-data no-padding-column">

            <div class="form-group form-no-data-group form-no-label-group no-margin-column">
                <div class="col-sm-12 no-padding-column padding-0">
                    <div class="checkbox-data">
                        <label class="input-radio">
                            <input id="deposit_question_1" type="radio" name="deposit_question"
                                   style="float: left; margin-left: -20px;" <?php echo isset($user_details['deposit_question']) ? $user_details['deposit_question'] ? ' checked' : '' : ' checked' ?>
                                   value="1"/>
                            By opening the position of CFDs on EURGBP, I am buying a transferable security, which has
                            its price connected to the exchange rate of Euro to GBP.
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group form-no-data-group form-no-label-group no-margin-column">
                <div class="col-sm-12 no-padding-column" style="text-align:left;">
                    <div class="checkbox-data">
                        <label class="input-radio">
                            <input id="deposit_question_2" type="radio" name="deposit_question"
                                   style="float: left; margin-left: -20px;" <?php echo isset($user_details['deposit_question']) ? $user_details['deposit_question'] ? '' : ' checked' : '' ?>
                                   value="2"/>
                            If the price of EURGBP drops to 1.070, I would be making a loss of GBP 3,000 and my
                            available equity would be 0 (i.e. I will lose my initial investment).
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group form-no-label-group no-margin-column">
                <div class="col-sm-12 no-padding-column">
                    <div class="checkbox-data">
                        <label class="input-radio">
                            <input id="deposit_question_3" type="radio" style="float: left; margin-left: -20px;"
                                   name="deposit_question"<?php echo isset($user_details['deposit_question']) ? $user_details['deposit_question'] ? '' : ' checked' : '' ?>
                                   value="3"/>
                            If the price of EURGBP drops to 1.070, I would be making a loss of GBP 30,000 and my
                            available equity would be 0 (i.e. I will lose my initial investment).
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group form-no-label-group no-margin-column">
                <div class="col-sm-12 no-padding-column">
                    <div class="checkbox-data">
                        <label class="input-radio">
                            <input id="deposit_question_4" type="radio" style="float: left; margin-left: -20px;"
                                   name="deposit_question"<?php echo isset($user_details['deposit_question']) ? $user_details['deposit_question'] ? '' : ' checked' : '' ?>
                                   value="4"/>
                            None of the above.
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group trading-form block-form-group">
        <label class="col-sm-4 control-label control-label-trading no-padding-column-label trading-exp-label">When
            trading with a higher leverage which of the following applies?<cite class="req">*</cite></label>

        <div class="col-sm-6 paragraph-data no-padding-column">

            <div class="form-group form-no-data-group form-no-label-group no-margin-column">
                <div class="col-sm-12 no-padding-column padding-0">
                    <div class="checkbox-data">
                        <label class="input-radio">
                            <input id="trading_high_leverage_1" type="radio" name="trading_high_leverage"
                                   style="float: left; margin-left: -20px;" <?php echo isset($user_details['trading_high_leverage']) ? $user_details['trading_high_leverage'] ? ' checked' : '' : ' checked' ?>
                                   value="1"/>
                            Risk is reduced.
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group form-no-data-group form-no-label-group no-margin-column">
                <div class="col-sm-12 no-padding-column" style="text-align:left;">
                    <div class="checkbox-data">
                        <label class="input-radio">
                            <input id="trading_high_leverage_2" type="radio" name="trading_high_leverage"
                                   style="float: left; margin-left: -20px;" <?php echo isset($user_details['trading_high_leverage']) ? $user_details['trading_high_leverage'] ? '' : ' checked' : '' ?>
                                   value="2"/>
                            The profit and loss of a 1.00 lot position is multiplied.
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group form-no-label-group no-margin-column">
                <div class="col-sm-12 no-padding-column">
                    <div class="checkbox-data">
                        <label class="input-radio">
                            <input id="trading_high_leverage_3" type="radio" style="float: left; margin-left: -20px;"
                                   name="trading_high_leverage"<?php echo isset($user_details['trading_high_leverage']) ? $user_details['trading_high_leverage'] ? '' : ' checked' : '' ?>
                                   value="3"/>
                            Positions can be opened with more notional exposure than the available balance.
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group form-no-label-group no-margin-column">
                <div class="col-sm-12 no-padding-column">
                    <div class="checkbox-data">
                        <label class="input-radio">
                            <input id="trading_high_leverage_4" type="radio" style="float: left; margin-left: -20px;"
                                   name="trading_high_leverage"<?php echo isset($user_details['trading_high_leverage']) ? $user_details['trading_high_leverage'] ? '' : ' checked' : '' ?>
                                   value="4"/>
                            None of the above.
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <div class="form-group trading-form block-form-group">
        <label class="col-sm-4 control-label control-label-trading no-padding-column-label">How much margin is required
            to buy 1.00 lot (100K contact size) of EURUSD through an account that has 100:1 leverage? <cite class="req">*</cite></label>

        <div class="col-sm-6 no-padding-column">
            <select class="form-control round-0 required" name="margin" id="margin"><?php echo $margin; ?></select>
            <span class="error_p" id="error_margin"><?php echo form_error('margin'); ?></span>
        </div>
    </div>
    <div class="form-group block-form-group">
        <label class="col-sm-4 control-label control-label-trading no-padding-column-label">How much do you have to pay
            to buy 10 lots USD through an account that its leverage is 1:50?<cite class="req">*</cite></label>

        <div class="col-sm-6 no-padding-column">
            <select class="form-control round-0 required" name="buy_lots"
                    id="buy_lots"><?php echo $buy_lots; ?></select>
            <span class="error_p" id="error_buy_lots"><?php echo form_error('buy_lots'); ?></span>
        </div>
    </div>

    <div class="form-group block-form-group">
        <label class="col-sm-4 control-label control-label-trading no-padding-column-label">What are you average
            transaction sizes and leverage used when trading products connected to Rolling Spot Forex/CFDs on FX pairs/
            Indices or Commodities? <cite class="req">*</cite></label>

        <div class="col-sm-6 no-padding-column">
            <select class="form-control round-0 required" name="average_trans_size"
                    id="average_trans_size"><?php echo $average_trans_size; ?></select>
            <span class="error_p" id="error_average_trans_size"><?php echo form_error('average_trans_size'); ?></span>
        </div>
    </div>



<div class="form-group block-form-group">
    <label class="col-sm-4 control-label control-label-trading no-padding-column-label"><?= lang('reg_per_10'); ?> <cite
            class="req">*</cite></label>

    <div class="col-sm-6 no-padding-column">
        <select class="form-control round-0 required" name="cfd_equity_stop_out_level"
                id="cfd_equity_stop_out_level"><?php echo $cfd_equity_stop_out_level; ?></select>
                    <span class="error_p"
                          id="error_cfd_equity_stop_out_level"><?php echo form_error('cfd_equity_stop_out_level'); ?></span>
    </div>
</div>


<div class="form-group block-form-group">
    <label class="col-sm-4 control-label control-label-trading no-padding-column-label"> <?= lang('reg_per_11'); ?>
        <cite class="req">*</cite></label>

    <div class="col-sm-6 no-padding-column">
        <select class="form-control round-0 required" name="cfd_higher_leverage"
                id="cfd_higher_leverage"><?php echo $cfd_higher_leverage; ?></select>
        <span class="error_p" id="error_cfd_higher_leverage"><?php echo form_error('cfd_higher_leverage'); ?></span>
    </div>
</div>

<div class="form-group block-form-group">
    <label class="col-sm-4 control-label control-label-trading no-padding-column-label"><?= lang('reg_per_12'); ?>
        <cite class="req">*</cite></label>

    <div class="col-sm-6 no-padding-column">
        <select class="form-control round-0 required" name="stop_out_level_50"
                id="stop_out_level_50"><?php echo $stop_out_level_50; ?></select>
        <span class="error_p" id="error_stop_out_level_50"><?php echo form_error('stop_out_level_50'); ?></span>
    </div>
</div>


<div class="form-group block-form-group">
    <label class="col-sm-4 control-label control-label-trading  no-padding-column-label"> <?= lang('reg_per_13'); ?>
        <cite class="req">*</cite></label>

    <div class="col-sm-6 no-padding-column">
        <div class="data-input-choice">
            <input
                value="1"<?php echo isset($user_details['politically_exposed_person']) ? $user_details['politically_exposed_person'] ? ' checked' : '' : '' ?>
                id="politically_exposed_person1" type="radio" class="rdo-btn-required"
                name="politically_exposed_person"/>
            <span><?= lang('reli_ye'); ?></span>
        </div>
        <div class="data-input-choice">
            <input
                value="0"<?php echo isset($user_details['politically_exposed_person']) ? $user_details['politically_exposed_person'] ? '' : ' checked' : ' checked' ?>
                id="politically_exposed_person" type="radio" class="rdo-btn-required"
                name="politically_exposed_person"/>
            <span><?= lang('reli_no'); ?></span>
        </div>
                    <span class="error_p"
                          id="error_politically_exposed_person"><?php echo form_error('politically_exposed_person'); ?></span>
    </div>
</div>


<div class="form-group block-form-group">
    <label class="col-sm-4 control-label control-label-trading no-padding-column-label"><?= lang('reli_25'); ?><cite
            class="req">*</cite></label>

    <div class="col-sm-6 no-padding-column">
        <div class="data-input-choice">
            <input
                value="1"<?php echo isset($user_details['risk']) ? $user_details['risk'] ? ' checked' : '' : ' checked' ?>
                id="risk1" type="radio" class="rdo-btn-required" name="risk"/>
            <span><?= lang('reli_ye'); ?></span>
        </div>
        <div class="data-input-choice">
            <input value="0"<?php echo isset($user_details['risk']) ? $user_details['risk'] ? '' : ' checked' : '' ?>
                   id="risk" type="radio" class="rdo-btn-required" name="risk"/>
            <span><?= lang('reli_no'); ?></span>
        </div>
        <span class="error_p" id="error_risk"><?php echo form_error('risk'); ?></span>
    </div>
</div>
<div class="form-group block-form-group">
    <label class="col-sm-4 control-label control-label-trading no-padding-column-label"><?= lang('reg_per_14'); ?><cite
            class="req">*</cite></label>

    <div class="col-sm-6 no-padding-column">
        <div class="data-input-choice">
            <input
                value="1"<?php echo isset($user_details['bankruptcy']) ? $user_details['bankruptcy'] ? ' checked' : '' : ' checked' ?>
                id="bankruptcy1" type="radio" class="rdo-btn-required" name="bankruptcy"/>
            <span><?= lang('reli_ye'); ?></span>
        </div>
        <div class="data-input-choice">
            <input
                value="0"<?php echo isset($user_details['bankruptcy']) ? $user_details['bankruptcy'] ? '' : ' checked' : '' ?>
                id="bankruptcy" type="radio" class="rdo-btn-required" name="bankruptcy"/>
            <span><?= lang('reli_no'); ?></span>
        </div>
        <span class="error_p" id="error_bankruptcy"><?php echo form_error('bankruptcy'); ?></span>
    </div>
</div>

<div class="form-group block-form-group">
    <label class="col-sm-4 control-label control-label-trading no-padding-column-label"><?= lang('reg_per_15'); ?>
        <cite class="req">*</cite></label>

    <div class="col-sm-6 no-padding-column">
        <div class="data-input-choice">
            <input
                value="1"<?php echo isset($user_details['seminar_attended']) ? $user_details['seminar_attended'] ? ' checked' : '' : ' checked' ?>
                id="seminar_attended1" type="radio" class="rdo-btn-required" name="seminar_attended"/>
            <span><?= lang('reli_ye'); ?></span>
        </div>
        <div class="data-input-choice">
            <input
                value="0"<?php echo isset($user_details['seminar_attended']) ? $user_details['seminar_attended'] ? '' : ' checked' : '' ?>
                id="seminar_attended" type="radio" class="rdo-btn-required" name="seminar_attended"/>
            <span><?= lang('reli_no'); ?></span>
        </div>
        <span class="error_p" id="error_attended_seminar"><?php echo form_error('seminar_attended'); ?></span>
    </div>
</div>

<div class="form-group block-form-group">
    <label class="col-sm-4 control-label control-label-trading no-padding-column-label"><?= lang('reg_per_16'); ?>
        <cite class="req">*</cite></label>

    <div class="col-sm-6 no-padding-column">
        <div class="data-input-choice">
            <input
                value="1"<?php echo isset($user_details['trading_leverage_experience']) ? $user_details['trading_leverage_experience'] ? ' checked' : '' : '' ?>
                id="trading_leverage_experience1" type="radio" class="rdo-btn-required"
                name="trading_leverage_experience"/>
            <span><?= lang('reli_ye'); ?></span>
        </div>
        <div class="data-input-choice">
            <input
                value="0"<?php echo isset($user_details['trading_leverage_experience']) ? $user_details['trading_leverage_experience'] ? '' : ' checked' : ' checked' ?>
                id="trading_leverage_experience" type="radio" class="rdo-btn-required"
                name="trading_leverage_experience"/>
            <span><?= lang('reli_no'); ?></span>
                        <span class="error_p"
                              id="error_trading_leverage_experience"><?php echo form_error('trading_leverage_experience'); ?></span>
        </div>
    </div>
</div>

    <div class="form-group block-form-group">
        <label class="col-sm-4 control-label control-label-trading no-padding-column-label">I have read, understood, and
            agree to the terms of business. <cite class="req">*</cite></label>

        <div class="col-sm-6 no-padding-column">
            <div class="data-input-choice">
                <input
                    value="1"<?php echo isset($user_details['bus_terms']) ? $user_details['bus_terms'] ? ' checked' : '' : '' ?>
                    id="bus_terms1" type="radio" class="rdo-btn-required" name="bus_terms"/>
                <span><?= lang('reli_ye'); ?></span>
            </div>
            <div class="data-input-choice">
                <input
                    value="0"<?php echo isset($user_details['bus_terms']) ? $user_details['bus_terms'] ? '' : ' checked' : ' checked' ?>
                    id="bus_terms" type="radio" class="rdo-btn-required" name="bus_terms"/>
                <span><?= lang('reli_no'); ?></span>
                <span class="error_p" id="error_bus_terms"><?php echo form_error('bus_terms'); ?></span>
            </div>
        </div>
    </div>
    <div class="form-group block-form-group">
        <label class="col-sm-4 control-label control-label-trading no-padding-column-label">I have read and understood
            the risk Disclosure Policy which is located at
            <a target="_blank" href="https://www.forexmart.com/assets/pdf/EU/Risk%20Disclosure.pdf">Risk Disclosure</a>.<cite
                class="req">*</cite></label>

        <div class="col-sm-6 no-padding-column">
            <div class="data-input-choice">
                <input
                    value="1"<?php echo isset($user_details['risk_disc_terms']) ? $user_details['risk_disc_terms'] ? ' checked' : '' : '' ?>
                    id="risk_disc_terms1" type="radio" class="rdo-btn-required" name="risk_disc_terms"/>
                <span><?= lang('reli_ye'); ?></span>
            </div>
            <div class="data-input-choice">
                <input
                    value="0"<?php echo isset($user_details['risk_disc_terms']) ? $user_details['risk_disc_terms'] ? '' : ' checked' : ' checked' ?>
                    id="risk_disc_terms" type="radio" class="rdo-btn-required" name="risk_disc_terms"/>
                <span><?= lang('reli_no'); ?></span>
                <span class="error_p" id="error_risk_disc_terms"><?php echo form_error('risk_disc_terms'); ?></span>
            </div>
        </div>
    </div>
    <div class="form-group block-form-group">
        <label class="col-sm-4 control-label control-label-trading no-padding-column-label">I agree and acknowledge that
            the company may execute an order on my behalf outside a regulated market or multi-lateral
            trading facility ( as such terms are defined by FCA rules).<cite class="req">*</cite></label>

        <div class="col-sm-6 no-padding-column">
            <div class="data-input-choice">
                <input
                    value="1"<?php echo isset($user_details['fca_terms']) ? $user_details['fca_terms'] ? ' checked' : '' : '' ?>
                    id="fca_terms1" type="radio" class="rdo-btn-required" name="fca_terms"/>
                <span><?= lang('reli_ye'); ?></span>
            </div>
            <div class="data-input-choice">
                <input
                    value="0"<?php echo isset($user_details['fca_terms']) ? $user_details['fca_terms'] ? '' : ' checked' : ' checked' ?>
                    id="fca_terms" type="radio" class="rdo-btn-required" name="fca_terms"/>
                <span><?= lang('reli_no'); ?></span>
                <span class="error_p" id="error_fca_terms"><?php echo form_error('fca_terms'); ?></span>
            </div>
        </div>
    </div>
    <div class="form-group block-form-group">
        <label class="col-sm-4 control-label control-label-trading no-padding-column-label">I have read and understood
            the Order Execution Policy, Conflicts of Interest Policy
            which is located at <a target="_blank" href="https://www.forexmart.com/legal-documentation">https://www.forexmart.com/legal-documentation</a>.<cite
                class="req">*</cite></label>

        <div class="col-sm-6 no-padding-column">
            <div class="data-input-choice">
                <input
                    value="1"<?php echo isset($user_details['gen_bus_terms']) ? $user_details['gen_bus_terms'] ? ' checked' : '' : '' ?>
                    id="gen_bus_terms1" type="radio" class="rdo-btn-required" name="gen_bus_terms"/>
                <span><?= lang('reli_ye'); ?></span>
            </div>
            <div class="data-input-choice">
                <input
                    value="0"<?php echo isset($user_details['gen_bus_terms']) ? $user_details['gen_bus_terms'] ? '' : ' checked' : ' checked' ?>
                    id="gen_bus_terms" type="radio" class="rdo-btn-required" name="gen_bus_terms"/>
                <span><?= lang('reli_no'); ?></span>
                <span class="error_p" id="error_gen_bus_terms"><?php echo form_error('gen_bus_terms'); ?></span>
            </div>
        </div>
    </div>
    <div class="form-group block-form-group">
        <label class="col-sm-4 control-label control-label-trading no-padding-column-label"> I agree and acknowledge
            that in the case of a limit order in shares admitted to trading on a regulated market which are not
            immediately executed, the company is not bound to facilitate the earliest possible execution of that order
            by making it public in an easily accessible manner.<cite class="req">*</cite></label>

        <div class="col-sm-6 no-padding-column">
            <div class="data-input-choice">
                <input
                    value="1"<?php echo isset($user_details['limit_order_terms']) ? $user_details['limit_order_terms'] ? ' checked' : '' : '' ?>
                    id="limit_order_terms1" type="radio" class="rdo-btn-required" name="limit_order_terms"/>
                <span><?= lang('reli_ye'); ?></span>
            </div>
            <div class="data-input-choice">
                <input
                    value="0"<?php echo isset($user_details['limit_order_terms']) ? $user_details['limit_order_terms'] ? '' : ' checked' : ' checked' ?>
                    id="limit_order_terms" type="radio" class="rdo-btn-required" name="limit_order_terms"/>
                <span><?= lang('reli_no'); ?></span>
                <span class="error_p" id="error_limit_order_terms"><?php echo form_error('limit_order_terms'); ?></span>
            </div>
        </div>
    </div>
    <div class="form-group block-form-group">
        <label class="col-sm-4 control-label control-label-trading no-padding-column-label"> I consider the company's
            offered product(s)(as relevant) as being suitable products for me.<cite class="req">*</cite></label>

        <div class="col-sm-6 no-padding-column">
            <div class="data-input-choice">
                <input
                    value="1"<?php echo isset($user_details['comp_prod_terms']) ? $user_details['comp_prod_terms'] ? ' checked' : '' : '' ?>
                    id="comp_prod_terms1" type="radio" class="rdo-btn-required" name="comp_prod_terms"/>
                <span><?= lang('reli_ye'); ?></span>
            </div>
            <div class="data-input-choice">
                <input
                    value="0"<?php echo isset($user_details['comp_prod_terms']) ? $user_details['comp_prod_terms'] ? '' : ' checked' : ' checked' ?>
                    id="comp_prod_terms" type="radio" class="rdo-btn-required" name="comp_prod_terms"/>
                <span><?= lang('reli_no'); ?></span>
                <span class="error_p" id="error_comp_prod_terms"><?php echo form_error('comp_prod_terms'); ?></span>
            </div>
        </div>
    </div>
    <div class="form-group block-form-group">
        <label class="col-sm-4 control-label control-label-trading no-padding-column-label"> I have read and understood
            the Key Information Document about products being offered to me.
            <a target="_blank"
               href="https://www.forexmart.com/assets/pdf/Key%20Information%20Document%20for%20CFDs.pdf">Key Information
                Document for CFDs.pdf</a><cite class="req">*</cite></label>

        <div class="col-sm-6 no-padding-column">
            <div class="data-input-choice">
                <input
                    value="1"<?php echo isset($user_details['key_info_terms']) ? $user_details['key_info_terms'] ? ' checked' : '' : '' ?>
                    id="key_info_terms1" type="radio" class="rdo-btn-required" name="key_info_terms"/>
                <span><?= lang('reli_ye'); ?></span>
            </div>
            <div class="data-input-choice">
                <input
                    value="0"<?php echo isset($user_details['key_info_terms']) ? $user_details['key_info_terms'] ? '' : ' checked' : ' checked' ?>
                    id="key_info_terms" type="radio" class="rdo-btn-required" name="key_info_terms"/>
                <span><?= lang('reli_no'); ?></span>
                <span class="error_p" id="error_key_info_terms"><?php echo form_error('key_info_terms'); ?></span>
            </div>
        </div>
    </div>






<div class="form-group" style="position:relative;">
    <label class="col-sm-4 control-label control-label-trading no-padding-column-label"><?= lang('reli_34'); ?></label>

    <div class="col-sm-6 no-padding-column">
        <input maxlength="10" type="text" class="form-control affiliate-form-control round-0"
               placeholder="<?= lang('reli_34'); ?>" name="affiliateCodeStr" value="<?php echo $referral_code; ?>">
        <input type="hidden" name="affiliate_code" id="affiliate_code" value="<?php echo $referral_code; ?>">
        <input type="hidden" name="isSubscribe" id="isSubscribe" value="0">
        <span class="error_p" id="error_affiliate_code"></span> <span class="error_p" id="error_affiliate_code"></span>

        <div><i style="margin-top:-23px!important; color: red; float:right;"
                class="tooltip-affiliate glyphicon glyphicon-question-sign" data-original-title="" title=""></i></div>
    </div>
</div>

<input type="hidden" name="trading_points" id="trading_points" value=""/>
<input type="hidden" name="URL"
       value="<?php echo $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>"/>

<div class="form-group">
    <div class="offset-buttons-holder">
        <div class="anchor-back-button">
            <a href="#personal" class="trading-back" aria-controls="personal" role="tab" data-toggle="tab"
               id="back"><?= lang('reli_ba'); ?></a>
        </div>
        <div class="anchor-submit-button">
            <a href="javascript:void(0)" aria-controls="account" role="tab" data-toggle="tab" class="trading-next">
                <button id="trading-next" type="button" class="btn-submit"><?= lang('reli_ne'); ?></button>
            </a>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
</div>
</div>
</div>
</div>
