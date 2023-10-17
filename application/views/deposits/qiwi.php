
<h1>
    <?=lang('qiwi_00');?>
</h1>
<div class="row tab-content">
    <div class="col-lg-11 col-centered tab-pane active" id="nt-tab">

        <form method="post" action="" class="form-horizontal" style="margin-top: 50px;" >
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

            <?php if(IPLoc::Office()) {
                if (isset($eu_payment_status) && $eu_payment_status) {?>
                    <div class="form-group" id="error-payment" style="text-align: center;">
                        <div class="col-sm-8 alert alert-danger" role="alert" style="margin-left:15%;">
                            <?php echo $eu_error_message; ?>
                        </div>
                    </div>
                <?php }
            }?>



            <div class="form-group" style= "text-align: center;">
                <?php if(validation_errors() != false){?><div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?=validation_errors();?></div> <?php }
                if(isset($error)){?>  <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"> <?=$error;?></div> <?php }
                $stat = $this->session->flashdata('hpb_error');
                if(isset($stat)){?>  <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"> <?=$stat;?></div> <?php } ?>
            </div>


            <?php if($non_verified_notice){?>
                <div class="form-group" style= "text-align: center;">
                    <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?=$non_verified_notice?></div>
                </div>
            <?php }else{ ?>
                <div class="form-group" style= "text-align: center;">
                    <!--<div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?/*=$error_msg*/?></div>-->
                    <?php if($error_msg){?>

                        <?php if($error_msg == "Spanish client"): ?>

                            <?php echo FXPP::spanishValidationView("qiwi"); ?>

                        <?php else: ?>

                            <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$error_msg?></div>

                        <?php endif; ?>

                    <?php } ?>
                </div>
            <?php } ?>

            <div class="form-group" style="text-align: center;">
                <img src="<?= $this->template->Images()?>qiwilogo.png" border="0" alt="" style="width: 74px; margin-bottom: 15px;"/>
            </div>


            <div class="form-group">
                <label class="col-sm-6 control-label">
                    <?=lang('ym_05');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="customerNumber" id="customerNumber"  class="form-control round-0">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-6 control-label">
                    <?=lang('ym_04');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="sum" id="sum"  class="form-control round-0"   value="<?=floatval($amount)?>"  <?=$disabled?>>
                    <?php // if($bounusfiled == 1){ ?>
                    <input type="hidden" name="bounusfiled" id="bounusfiled"  class="form-control round-0"   value="<?=$bounusfiled?>" >
                    <?php //}?>
                </div>
            </div>



            <div class="form-group">
                <div class="col-sm-offset-6 col-sm-5">
                    <button type="submit" class="btn-submit" <?=$disabled?>>
                        <?=lang('ym_11');?>
                    </button>
                </div><div class="clearfix"></div>
            </div>
        </form>
    </div>





</div>


