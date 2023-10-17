
<h1>
    <?=lang('paysera_00');?>
</h1>
<input type="hidden" id="base_url" value="<?php echo FXPP::ajax_url() ?>" />
<div class="row">
    <div class="col-lg-9 col-centered">
        <form class="form-horizontal" id="frm-paysera" method="POST" accept-charset="windows-1251">
            <?php if(!$incomplete){ ?>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="alert alert-danger" role="alert">
                            <p>In order to enable deposit option, you need to complete your Employment details</p>
                            <a href="https://my.forexmart.com/accounts/register"> Click here to enter your details </a>
                        </div>
                    </div>
                </div>
            <?php }else{
                if(!$user_status){ ?>
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
                <img src="<?= $this->template->Images()?>paysera.png" class="img-reponsive" width="250px"/>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('paysera_02');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="hidden" name="account_currency" id="currency" value="<?php echo $account['id'] ?>"/>
                    <input type="text" name="currency" id="currency" class="form-control round-0" value="<?php echo $account['currency'] . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'],2) . ']' ?>" placeholder="" disabled/>
                </div>
                <div class="reqs col-sm-3">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('paysera_03');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" id="amount" name="amount" class="form-control round-0 numeric depositamountcheck"<?php echo $disabled ?>>
                </div>
                <div class="reqs col-sm-3 errorlineshow">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('paysera_04');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" id="email" name="email_address" class="form-control round-0"<?php echo $disabled ?>>
                </div>
                <div class="reqs col-sm-3">
                </div>
            </div>
<!--            <div class="form-group">-->
<!--                <label class="col-sm-5 control-label">WMID<cite class="req">*</cite></label>-->
<!--                <div class="col-sm-7">-->
<!--                    <input type="text" class="form-control round-0">-->
<!--                </div>-->
<!--            </div>-->
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="button" class="btn-submit"<?php echo $disabled ?>>
                        <?=lang('paysera_05');?>
                    </button>
                </div><div class="clearfix"></div>
            </div>
        </form>
    </div>

</div>
<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i>
    <?=lang('paysera_06');?>
</h1>
<table class="notes-list" style="margin-bottom: 150px;">
    <tr>
        <td><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td>
            <p>
                <?=lang('paysera_07_0');?>
                <a href mailto="finance@forexmart.com">
                    <?=lang('paysera_07_1');?>
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