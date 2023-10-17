<style>
    .l_{
        float: left;
        width: 20px;
        margin: 1px 10px 0 7px;
    }
    .r_{
        width: 80%;
        float: left;
    }
    .cb{
        clear: both;
    }
</style>
<h1>
    <?=lang('webmon_00');?>
</h1>
<input type="hidden" id="base_url" value="<?php echo FXPP::ajax_url() ?>" />
<div class="row">
    <div class="col-lg-9 col-centered">
        <form class="form-horizontal" id="frm-webmoney" method="POST" accept-charset="windows-1251" style="margin-top: 50px;">
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="alert alert-danger" role="alert" id="amountErrorVal" style="display: none"></div>
                </div>
            </div>
            <input type="hidden" name="bonus_input" value="<?=$bonus_input;?>">
            <?php if(!$incomplete){ ?>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="alert alert-danger" role="alert">
                            <p>In order to enable deposit option, you need to complete your Employment details</p>
                            <a href="<?= FXPP::loc_url('my-account/register');?>"> Click here to enter your details </a>
                        </div>
                    </div>
                </div>
            <?php }else{
                if(!$user_status && !$count_status){ ?>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="alert alert-danger" role="alert">
                                <?=lang('n_01');?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="form-group" style="text-align: center;">
                <?php
                $display = $this->session->flashdata('wm_status');
                if(isset($display)){
                    ?>
                    <div class="alert alert-danger center" role="alert" style="margin-bottom: 30px;">
                        <p> Transaction has been cancelled. </p>
                    </div>
                <?php } ?>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('webmon_02');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="hidden" name="account_currency" id="currency" value="<?php echo $account['id'] ?>"/>
                    <input type="text" name="currency" id="currency" class="form-control round-0" value="<?php echo $account['currency_new'] . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'],2) . ']' ?>" placeholder="" disabled/>
                </div>
                <div class="reqs col-sm-3">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('webmon_03');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" id="amount" name="amount"  value="<?=floatval($amount)?>" class="form-control round-0 numeric depositamountcheck"<?php echo $disabled ?>>
                </div>
                <div class="reqs col-sm-3 errorlineshow" id="min_amount2">
                </div>
            </div>
            <!--<div class="form-group">
                <label class="col-sm-4 control-label">
                    <?/*=lang('webmon_04');*/?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" id="email" name="email_address" class="form-control round-0"<?php /*echo $disabled */?>>
                </div>
                <div class="reqs col-sm-3">
                </div>
            </div>-->
<!--            <div class="form-group">-->
<!--                <label class="col-sm-5 control-label">WMID<cite class="req">*</cite></label>-->
<!--                <div class="col-sm-7">-->
<!--                    <input type="text" class="form-control round-0">-->
<!--                </div>-->
<!--            </div>-->
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="button" class="btn-submit"<?php echo $disabled ?>>
                        <?=lang('webmon_05');?>
                    </button>
                </div><div class="clearfix"></div>
            </div>
        </form>
    </div>
</div>

<form id="frm-wmt" style="display: none;" method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp" accept-charset="windows-1251">
    <input type="hidden" name="LMI_PREREQUEST" value="1">
    <input type="hidden" name="LMI_PAYMENT_AMOUNT" id="payment_amount" value="">
    <input type="hidden" name="LMI_PAYMENT_DESC" id="desc" value="">
    <input type="hidden" name="LMI_PAYEE_PURSE" id="purse" value="">
    <input type="hidden" name="LMI_PAYMENT_NO" id="pin" value="">
    <!--<input type="hidden" name="LMI_SIM_MODE" id="mode" value="0">-->
    <input type="hidden" name="LMI_MODE" value="0">
    <input type="hidden" name="user_id" id="user_id" value="">
    <input type="hidden" name="trn_id" id="trn_id" value="">
    <input type="hidden" name="bonus" id="bonus" value="">
</form>

<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i>
    <?=lang('webmon_06');?>
</h1>
<table class="notes-list" style="margin-bottom: 150px;">
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('paysera_07_0');?>
                <a href mailto="finance@forexmart.com">
                    <?=lang('webmon_07_1');?>
                </a>
            </p>
        </td>
    </tr>
</table>
<?php /** Preloader Modal Start */ ?>
<div id="loader-holder" class="loader-holder">
    <div class="loader">
        <div class="loader-inner ball-pulse">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>
<?php /** Preloader Modal End */ ?>