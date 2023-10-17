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
    p{ margin: 0px 0px !important;}
    .in_active{
        display:none;
    }
    .active{
        display:block;
    }


</style>
<h1>
    <?= lang('trd_12'); ?>
</h1>
<div class="row">
    <div class="col-lg-9 col-centered">
        <input type="hidden" id="base_url" value="<?php echo FXPP::ajax_url() ?>" />
        <form action="" method="post" id="frmDepositInpay" class="form-horizontal"  style="margin-top: 50px;">
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="alert alert-danger" role="alert" id="amountErrorVal" style="display: none"></div>
                </div>
            </div>

            <?php if($CurPendValidation['TradeError'] && !empty($CurPendValidation['TradeError']) ){?>
                <div class="form-group">
                    <div class="col-sm-12" style= "margin-top: 21px;">
                        <?php if(!empty($CurPendValidation['TradeErrorMsg'])){?>
                            <div class="alert alert-danger" role="alert">
                                <?php  echo $CurPendValidation['TradeErrorMsg'];?>
                            </div>
                        <?php }?>
                    </div>
                </div>
            <?php } ?>

            <?php if($non_verified_notice){?>
                <div class="form-group" style= "text-align: center;">
                    <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$non_verified_notice?></div>
                </div>
            <?php }else{ ?>
                <div class="form-group" style= "text-align: center;">
                    <?php if($error_msg){?>

                        <?php if($error_msg == "Spanish client"): ?>

                            <?php echo FXPP::spanishValidationView("inpay"); ?>

                        <?php else: ?>

                            <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$error_msg?></div>

                        <?php endif; ?>

                    <?php } ?>
                </div>
            <?php } ?>

            <?php
            $display = $this->session->flashdata('msg');
            if(isset($display)){
                ?>
                <div class="form-group" style="">
                    <div class="col-sm-10">
                        <div class="alert alert-success center" role="alert">
                            <p> <?=$display?> </p>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <?php
            // $display = $this->session->flashdata('cardpay_transaction');
            if(isset($msg)){
                if($msg==1){?>
                    <div class="form-group" style="">
                        <div class="col-sm-10">
                            <div class="alert alert-danger center" role="alert">
                                <p> Transaction  </p>
                            </div>
                        </div>
                    </div>
              <?php  }else{ ?>
                <div class="form-group" style="">
                    <div class="col-sm-10">
                        <div class="alert alert-danger center" role="alert">
                            <p> <?=$msg;?> </p>
                        </div>
                    </div>
                </div>

            <?php }} ?>

            <div class="form-group" style="text-align: center;">
                <img src="<?= $this->template->Images()?>inpay_icon.png" border="0" alt="" style="margin-bottom: 15px;"/>
            </div>
            <div class="col-md-11 col-centered tab-pane setup-content active" id="bt-tab1">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <?=lang('ddcc_02');?>
                        <cite class="req">*</cite></label>
                    <div class="col-sm-5">
                        <input type="text" name="currency" id="currency" class="form-control round-0" value="<?php echo $account['currency'] . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'],2) . ']' ?>" placeholder="" disabled/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <?=lang('ddcc_03');?>
                        <cite class="req">*</cite></label>
                    <div class="col-sm-5">
                        <input type="text" name="amount" value="<?php echo set_value('amount', $amount); ?>"  id="amount" class="form-control round-0 numeric depositamountcheck"<?php echo $disabled ?>/>
                        <input type="hidden" name="bounusfiled" id="bounusfiled"  class="form-control round-0"   value="<?=$bounusfiled?>" >
                        <div class="reqs errorlineshow">
                            <?php echo form_error('amount'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-5">
                        <button type="submit" class="btn-submit" id="btnDpstInpayContinue"<?php echo $disabled ?>>
                            <?=lang('ddcc_04');?>
                        </button>
                    </div><div class="clearfix"></div>
                </div>
           </div

        </form>

    </div>

</div>


