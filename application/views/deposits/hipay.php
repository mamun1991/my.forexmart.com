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
    <?=lang('hpy_00');?>
</h1>
<div class="row">
    <div class="col-lg-9 col-centered">
        <form action="" method="post" class="form-horizontal" style="margin-top: 50px;">
            <?php
            $disabled = "";
            if($error_msg){
                $disabled = "disabled"
                ?>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="alert alert-danger" role="alert">
                            <?=$error_msg?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group" style="text-align: center;">
                <img src="<?= $this->template->Images()?>hipay-wallet.png" class="img-reponsive" width="350px"/>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('s_02');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="hidden" name="currency" id="currency" value="<?php echo $account['mt_currency_base'] ?>"/>
                    <input type="text" name="account_currency" id="account_currency" class="form-control round-0" value="<?php echo $account['currency'] . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'],2) . ']' ?>" placeholder="" disabled/>
                </div>
                <span class="col-sm-3 req">  <?php echo  form_error('currency')?> </span>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('s_03');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input name="amount" type="text" class="form-control round-0 numeric" placeholder="0.00"<?php echo $disabled ?>>
                    <span class="req">  <?php echo  form_error('amount')?> </span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="submit" class="btn-submit"<?php echo $disabled ?>>
                        <?=lang('s_04');?>
                    </button>
                </div><div class="clearfix"></div>
            </div>
        </form>
    </div>
</div>
<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i>
    <?=lang('s_05');?>
</h1>
<table class="notes-list" style="margin-bottom: 150px;">
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('hpy_02');?>
            </p>
        </td>
    </tr>
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('hpy_03');?>
            </p>
        </td>
    </tr>
</table>