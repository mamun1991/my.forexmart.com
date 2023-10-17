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
    @media only screen and (max-width: 991px) {
        .notes-list {
            margin-bottom: 30px !important;
        }
    }
</style>
<!-- FXPP-7281 -->
<input type="hidden" name="micro_type" id="micro_type" value="<?php echo $micro; ?>">
<!-- FXPP-7281 -->
<h1>
    <?=lang('n_00');?>
</h1>
<div class="row tab-content">
    <div class="col-lg-11 col-centered tab-pane active" id="nt-tab">

        <form method="post" class="form-horizontal" style="margin-top: 50px;" id="neteller-request-form">

            <?php if($CurPendValidation['TradeError'] && !empty($CurPendValidation['TradeError']) ){?>
                <div class="form-group">
                    <div class="col-sm-12" style= "width: 65%;text-align: center; margin: 0 auto; float: none!important;">
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
                    <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?=$non_verified_notice?></div>
                </div>
            <?php }else if($error_msg){ ?>

                <?php if($error_msg == "Spanish client"): ?>

                    <?php echo FXPP::spanishValidationView("neteller"); ?>

                <?php else: ?>

                    <div class="form-group" style= "text-align: center;">
                        <!--<div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?/*=$error_msg*/?></div>-->
                        <?php if($error_msg){?>  <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$error_msg?></div> <?php } ?>
                    </div>

                <?php endif; ?>

            <?php } ?>

            <div class="form-group" style="text-align: center;">
                <img src="<?=$this->template->Images()?>neteller2.jpg" border="0" alt="" />
            </div>

            <div class="form-group">

                <label class="col-sm-6 control-label">
                    <?=lang('n_02');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="hidden" name="account_number" id="account_number" value="<?php echo $account['account_number'] ?>"/>
                    <input type="text" name="account_currency" id="account_currency" class="form-control round-0" value="<?php echo $account['currency_new'] . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'],2) . ']' ?>" placeholder="" disabled/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label">
                    <?=lang('n_03');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="amount" id="amount" value="<?php echo set_value('amount', $amount); ?>" class="form-control round-0 numeric depositamountcheck" placeholder="0.00"<?php echo $disabled ?>/>
                    <span class="req errorlineshow" id="neteller_amount"><?php echo  form_error('amount')?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label">
                    <?=lang('n_04');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="neteller_account" id="neteller_account" value="<?php echo set_value('neteller_account');?>"  class="form-control round-0"<?php echo $disabled ?>>
                    <span class="req" id="neteller_neteller_account"><?php echo  form_error('neteller_account')?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label">
                    <?=lang('n_05');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="neteller_secure_id" id="neteller_secure_id" value="<?php echo set_value('neteller_secure_id');?>" class="form-control round-0"<?php echo $disabled ?>>
                    <span class="req" id="neteller_verificationCode"><?php echo  form_error('neteller_secure_id')?></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-6 col-sm-5">
                    <button type="button" id="send-request" class="btn-submit"<?php echo $disabled ?>>
                        <?=lang('n_06');?>
                    </button>
                </div><div class="clearfix"></div>
            </div>
        </form>
    </div>

    <div class="col-md-7 col-centered tab-pane" style="margin-top: 10px;" id="nt-tab2">
        <form class="form-horizontal reg-frm">
            <div class="alert alert-info" role-alert>
                <i class="fa fa-info-circle"></i>
                <?=lang('n_07');?>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-6 control-label contest-label">
                    <?=lang('n_08');?>
                </label>
                <div class="col-sm-6">
                    <p class="bt-val" id="txtAccountNumber"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-6 control-label contest-label">
                    <?=lang('n_09');?>
                </label>
                <div class="col-sm-6">
                    <p class="bt-val" id="txtAmount"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-6 control-label contest-label">
                    <?=lang('n_10');?>
                </label>
                <div class="col-sm-6">
                    <p class="bt-val" id="txtAccount"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-6 control-label contest-label">
                    <?=lang('n_11');?>
                </label>
                <div class="col-sm-6">
                    <p class="bt-val" id="txtSecureId"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-6 control-label contest-label"></label>
                <div class="col-sm-6">
                    <button type="button" id="btnNetellerRequest" class="btn-submit">
                        <?=lang('n_12');?>
                    </button>
                    <button type="button" id="btnNetellerBack" class="btn-submit" style="margin-right: 10px;">
                        <?=lang('n_13');?>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-md-11 col-centered tab-pane" style="margin-top: 10px;" id="nt-tab3">
        <div class="panel panel-default round-0">
            <div class="panel-heading">
                <b>
                    <?=lang('n_14');?>
                </b>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8 col-centered">
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i>
                            <?=lang('n_15');?>
                        </div>
                        <form class="form-horizontal form-success">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-6 control-label">
                                    <?=lang('n_16');?>
                                </label>
                                <div class="col-sm-6">
                                    <p class="frm-val" id="txtNetellerSuccessAccountNumber"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-6 control-label">
                                    <?=lang('n_17');?>
                                </label>
                                <div class="col-sm-6">
                                    <p class="frm-val" id="txtNetellerSuccessAmount"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-6 control-label">
                                    <?=lang('n_18');?>
                                </label>
                                <div class="col-sm-6">
                                    <p class="frm-val" id="txtNetellerSuccessAccount"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-6 control-label">
                                    <?=lang('n_19');?>
                                </label>
                                <div class="col-sm-6">
                                    <p class="frm-val" id="txtNetellerSuccessReferenceNumber"></p>
                                </div>
                            </div>
                        </form>
                        <div class="btn-create-another">
                            <a href="<?php echo FXPP::loc_url('deposit/neteller')?>" class="create-another">
                                <?=lang('n_20');?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i>
    <?=lang('n_21');?>
</h1>
<table class="notes-list" style="margin-bottom: 150px;">
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td  class="r_">
            <p>
                <?=lang('n_22_0');?>
                <a href mailto="finance@forexmart.com">
                    <?=lang('n_22_1');?>
                </a>.
            </p>
        </td>
    </tr>
    <tr class="cb">
        <td  class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td  class="r_">
            <p>
                <?=lang('n_23');?>
            </p>
        </td>
    </tr>
</table>

<div id="modal-neteller-deposit" class="modal fade">
    <div class="modal-dialog modal_dialog_AS" style="width: 400px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">
                    <?=lang('n_24');?>
                </h4>
            </div>
            <div class="modal-body">
                <p id="modal-neteller-message">
                    <?=lang('n_25');?>
                </p>
            </div>

        </div>
    </div>
</div>
