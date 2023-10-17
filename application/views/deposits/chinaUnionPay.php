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
    .form-error-msg{
        text-align: center;
        margin: 10px;
    }
</style>

<h1><?=lang('dspt-t-5');?></h1>

<div class="row">
    <?php if($CurPendValidation['TradeError'] && !empty($CurPendValidation['TradeError']) ){?>
        <div class="form-group">
            <div class="col-sm-12" style= "width: 65%;text-align: center; margin: 0 auto; float: none!important;margin-top: 30px;">
                <?php if(!empty($CurPendValidation['TradeErrorMsg'])){?>
                    <div class="alert alert-danger" role="alert">
                        <?php  echo $CurPendValidation['TradeErrorMsg'];?>
                    </div>
                <?php }?>
            </div>
        </div>
    <?php } ?>
    <div class="col-lg-12 col-centered">
        <?php $er = form_error('amount'); ?>
        <?php if($hasError AND !empty($er)){
            ?>
            <div class="form-error-msg form-group">
                <div class="col-sm-12">
                    <div class="alert alert-danger" role="alert">
                        <?php echo  form_error('amount')?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php
        $display = $this->session->flashdata('d_mt_display');
        if(isset($display)){
            if($display){
            ?>
                <div class="form-group" style="margin-top: 50px;">
                    <div class="col-sm-10">
                        <div class="alert alert-success center" role="alert">
                            <p> <?=lang('dspt-err-2');?> <a href="/transaction-history"> <?=lang('dspt-err-2');?></a></p>
                        </div>
                    </div>
                </div>

            <?php } else { ?>

                <div class="form-group" style="margin-top: 50px;">
                    <div class="col-sm-10">
                        <div class="alert alert-danger center" role="alert">
                            <p>  <?=lang('dspt-err-1');?> </p>
                        </div>
                    </div>
                </div>


        <?php } }?>


            <form id = "chinaUnionPayForm" class="form-horizontal" method="POST" style="margin-top: 50px;">
                <input type="hidden"  name="base_url" id="base_url" value="<?php echo FXPP::ajax_url() ?>" />
                <input type="hidden" id="test_base_url" value="<?php echo $fail_lang2; ?>" />
                <?php if($non_verified_notice){?>
                    <div class="form-group" style= "text-align: center;">
                        <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?=$non_verified_notice?></div>
                    </div>
                <?php }else{ ?>
                    <div class="form-group" style= "text-align: center;">
                        <!--<div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?/*=$error_msg*/?></div>-->
                        <?php if($error_msg){?>  <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$error_msg?></div> <?php } ?>
                    </div>
                <?php } ?>
                <div class="form-group" style="text-align: center;">
                    <img src="<?= $this->template->Images()?>chinaUnionPay.png" class="img-reponsive" width="250px"/>
                </div>
                <div class="form-group">

                    <label class="col-sm-4 control-label">
                        <?=lang('ddcc_03-1');?>
                        <cite class="req">*</cite></label>

                    <div class="col-sm-5">
                        <input type="text" name="account_currency" id="account_currency" class="form-control round-0" value="<?php echo $account['currency_new'] . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'],2) . ']' ?>" placeholder="" disabled/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <?=lang('ddcc_03');?>
                        <cite class="req">*</cite></label>
                    <div class="col-sm-5">
                        <input type="text" name="amount" id="amount"    value="<?=floatval($amount)?>"  class="form-control round-0 numeric depositamountcheck" placeholder="0.00"<?php echo $disabled ?>/>
                    </div>
                    <div class="reqs amount-err col-md-offset-5 col-md-5 errorlineshow" style="margin-top: 0;"></div>
                </div>


                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <?=lang('with_04');?>
                        <cite class="req">*</cite></label>
                    <div class="col-sm-5">
                        <input type="text" name="cup_account_name" id="cup_account_name"  class="form-control round-0" />
                    </div>
                    <div class="reqs col-md-offset-5 col-md-5" style="margin-top: 0;"></div>
                    <?php echo  form_error('cup_account_name')?>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <?=lang('with_03');?>
                        <cite class="req">*</cite></label>
                    <div class="col-sm-5">
                        <input type="text" name="cup_bank_name" id="cup_bank_name"  class="form-control round-0" />
                    </div>
                    <div class="reqs col-md-offset-5 col-md-5" style="margin-top: 0;"></div>
                    <?php echo  form_error('cup_bank_name')?>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <?=lang('with_01');?>
                        <cite class="req">*</cite></label>
                    <div class="col-sm-5">
                        <input type="text" name="cup_bank_number" id="cup_bank_number"  class="form-control round-0 numeric" />
                    </div>
                    <div class="reqs col-md-offset-5 col-md-5" style="margin-top: 0;"></div>
                    <?php echo  form_error('cup_bank_number')?>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <?=lang('with_02');?>
                        <cite class="req">*</cite></label>
                    <div class="col-sm-5">
                        <input type="text" name="cup_branch" id="cup_branch"  class="form-control round-0" />
                    </div>
                    <div class="reqs col-md-offset-5 col-md-5" style="margin-top: 0;"></div>
                    <?php echo  form_error('cup_branch')?>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <?=lang('with_06');?>
                        <cite class="req">*</cite></label>
                    <div class="col-sm-5">
                        <input type="text" name="cup_province" id="cup_province"  class="form-control round-0" />
                    </div>
                    <div class="reqs col-md-offset-5 col-md-5" style="margin-top: 0;"></div>
                    <?php echo  form_error('cup_province')?>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <?=lang('with_05');?>
                        <cite class="req">*</cite></label>
                    <div class="col-sm-5">
                        <input type="text" name="cup_city" id="cup_city"  class="form-control round-0" />
                    </div>
                    <div class="reqs col-md-offset-5 col-md-5" style="margin-top: 0;"></div>
                    <?php echo  form_error('cup_city')?>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-5">
                        <button type="button" class="btn-submit" <?php echo $disabled ?>>
                            <?=lang('ddcc_04');?>
                        </button>
                    </div><div class="clearfix"></div>
                </div>
            </form>
    </div>

</div>

