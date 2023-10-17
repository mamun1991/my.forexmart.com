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

<h1><?=lang('dspt-t-6');?></h1>

<div class="row">
    <div class="col-lg-12 col-centered">
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


        <?php if(IPLoc::Office()) {
            if (isset($eu_payment_status) && $eu_payment_status) {?>
                <div class="form-group" id="error-payment" style="text-align: center;">
                    <div class="col-sm-8 alert alert-danger" role="alert" style="margin-left:15%;">
                        <?php echo $eu_error_message; ?>
                    </div>
                </div>
            <?php }
        }?>

        <?php
        $display = $this->session->flashdata('d_mt_display');
        if(isset($display)){
            if($display){
            ?>
                <div class="form-group" style="margin-top: 50px;">
                    <div class="col-sm-10">
                        <div class="alert alert-success center" role="alert">
                            <p><?=lang('dspt-err-2');?> <a href="/transaction-history"> <?=lang('dspt-err-3');?></a></p>
                        </div>
                    </div>
                </div>

            <?php } else { ?>

                <div class="form-group" style="margin-top: 50px;">
                    <div class="col-sm-10">
                        <div class="alert alert-danger center" role="alert">
                            <p> <?=lang('dspt-err-1');?></p>
                        </div>
                    </div>
                </div>


        <?php } }?>

            <input type="hidden" id="base_url" value="<?php echo FXPP::loc_url() ?>" />
            <form class="form-horizontal" method="POST" style="margin-top: 50px;" enctype="multipart/form-data" >
                <?php
                $disabled = "";
                if($error_msg && !$count_status){
                   // if(IPLoc::Office()){ print_r($count_status);print_r("test");}
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
                    <img src="<?= $this->template->Images()?>megatransferlogo.png" class="img-reponsive" width="250px"/>
                </div>
                <div class="form-group">

                    <label class="col-sm-4 control-label">
                        <?=lang('cd_06');?>
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
                    <?php if ($amount==NULL) { ?><span class="col-sm-3 req errorlineshow">  <?php echo  form_error('amount')?> </span><?php } ?>
                </div>



                <?php if(IPLoc::Office()){?>

                    <div class="form-group">

                        <label class="col-sm-4 control-label">
                            Color copy of front side of the card
                            <cite class="req">*</cite></label>

                        <div class="col-sm-5">
                            <input class="form-control round-0" type="file" name="front_side" id="front_side">
                        </div>
                    </div>


                    <div class="form-group">

                        <label class="col-sm-4 control-label">
                            Color copy of back side of the card
                            <cite class="req">*</cite></label>

                        <div class="col-sm-5">
                            <input class="form-control round-0" type="file" name="back_side" id="back_side">
                        </div>
                    </div>

                <?php } ?>


                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-5">
                        <button type="submit" class="btn-submit" <?php echo $disabled ?>>
                            <?=lang('ddcc_04');?>
                        </button>
                    </div><div class="clearfix"></div>
                </div>
            </form>
    </div>

</div>