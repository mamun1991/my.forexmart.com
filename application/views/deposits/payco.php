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
    .btn-reg-pc:hover {
        color: #fff;
    }
    .btn-reg-pc {
        text-decoration: none !important;
        cursor: pointer;
        text-align: center;
    }
    .modal-show-title {
        font-style: italic;
    }
    .modal-desc {
        font-size: 13px;
    }
    .center{
        text-align: center;
    }
    .reg-link-error, .error {
        color: #ff0000;
        font-family: Open Sans;
        font-size: 13px;
        margin-top: 7px;
    }
    @media screen and (max-width: 829px) {
        .btn-submit {
            padding: 7px 23px;
        }
    }
    @media screen and (max-width: 773px) {
        .btn-submit {
            padding: 7px 20px;
        }
    }
    @media screen and (max-width: 767px) {
        #input {
            padding-bottom: 15px;
        }
    }
    @media screen and (max-width: 399px) {
        .payco-img {
            width: 80px;
        }
        .modal-show-title {
            white-space: nowrap;
            font-size: 20px;
        }
    }
</style>
<?php

?>
<!--<h1><?/*=lang('dpc_00')*/?></h1>-->
<h1><?=lang('payco_h');?> </h1>
<?= $desc; ?>
<div class="row">
    <div class="col-lg-9 col-centered">

          
        <?php 
        $deposit_amount=0;
        if($amount>0)
        {
            $deposit_amount=$amount;
            
        }else{
           $deposit_amount= ($field_value)?$field_value['amount']:0;
        } 
        
        ?>
        
        
        <form id="PaycoForm" method="POST" class="form-horizontal subPayco paymentmethodformsumit">
            <?php if($hasError && !empty($hasError)){?>
                <div class="form-group" style="text-align: center; margin-top: 21px;">
                    <?php if(form_error('amount')){?>
                        <div class="col-sm-8 alert alert-danger" role="alert" style="margin-left:15%;">
                            <?php echo  form_error('amount'); ?>
                        </div>
                    <?php }?>
                </div>
            <?php } ?>
            
            <?php if(isset($prompt)){ ?>
                <div class="form-group">
                    <div class="col-sm-8" style= "margin-left:15%;">

                        <?php if(($prompt2)){ ?>
                            <br/>
                            <br/>
                            <div class="alert alert-success center" role="alert">
                                <?=$prompt?>
                                <br/>
                                <br/>
                                <span><?=lang('dpc_01')?> : <strong><?=$deposit['mt_ticket']?></strong></span>
                                <br/>
                                <span><?=lang('dpc_02')?> : <strong> <?=$payco['paytrans']?></span>
                                <br/>
                            </div>
                        <?php }else{ ?>
                            <br/>
                            <br/>
                            <div class="alert alert-danger center" role="alert">
                                <?=$prompt?>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            <?php } ?>

            <?php if($non_verified_notice){?>
                <div class="form-group" style= "text-align: center;">
                    <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?=$non_verified_notice?></div>
                </div>
            <?php }else if($error_msg){ ?>
                <div class="form-group" style= "text-align: center;">
                    <!--<div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?/*=$error_msg*/?></div>-->
                    <?php if($error_msg){?>

                        <?php if($error_msg == "Spanish client"): ?>

                            <?php echo FXPP::spanishValidationView("payco"); ?>

                        <?php else: ?>

                            <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$error_msg?></div>

                        <?php endif; ?>

                    <?php } ?>
                </div>
            <?php } ?>

            <div class="form-group" style="text-align: center;">
                <img src="<?= $this->template->Images()?>payco.png" class="img-reponsive bitcoin-logo" width="300px"/>
            </div>

            <div class="form-group">
                <!--<label class="col-sm-4 control-label"><?/*=lang('dpc_04')*/?><cite class="req">*</cite></label>-->
                <label class="col-sm-4 control-label"><?=lang('payco_01');?><cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <!--<input type="hidden" name="currency" id="currency" value="<?php //echo $account['currency'] ?>"/>-->
                    <?php echo $input_account_number; ?>
                </div>
                <div class="error_p col-sm-3" id="error_currency"><?php echo form_error('currency'); ?></div>

            </div>
            <div class="form-group">
                <!--<label class="col-sm-4 control-label"><?/*=lang('dpc_05')*/?><cite class="req">*</cite></label>-->
                <label class="col-sm-4 control-label"><?=lang('payco_02');?><cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="amount" class="form-control round-0 numeric depositamountcheck" value="<?=floatval($deposit_amount); ?>" id="amount" <?php echo $disabled ?>/>
                    <span class="CardFieldAmount errorlineshow" style="color: red"> </span>

                </div>
               
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Wallet Currency<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <select name="currency" class="form-control round-0">
                        <option value="USD" <?=($account['currency']=='USD')?'selected':''?> >USD</option>
                        <option value="IDR" <?=($account['currency']=='EUR')?'selected':''?> >EUR</option>
                        <option value="RUB" <?=($account['currency']=='RUB')?'selected':''?> >RUB</option>

                    </select>
                </div>
            </div>
            <div class="form-group">
                <?php if (($its != false) && ($mpr == false) && IPLoc::Office()) { ?>
                    <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-sm-7 col-md-7 col-lg-8">
                        <div class="col-lg-6 col-md-6 col-sm-5 pull-right block">
                            <button type="submit" class="btn-submit block"<?php echo $disabled ?>><?=lang('payco_bu');?></button>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-5 pull-right block">
                            <a class="btn-submit btn-reg-pc block" data-toggle="modal" data-target="#popup"><?=lang('cd_08');?></a>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-sm-offset-5 col-sm-4">
                        <button type="button" class="btn-submit paymentmethodformsumitbutton"<?php echo $disabled ?>><?=lang('payco_bu');?></button>




                    </div>
                <?php } ?>
                <div class="clearfix"></div>
            </div>

            <div class="modal fade" id="popup" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="">
                <div class="modal-dialog round-0">
                    <div class="modal-content round-0">
                        <div class="modal-header round-0">
                            <button type="button" class="close supresscookies" data-dismiss="modal" aria-label="Close" id="modal_close_top"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title modal-show-title">
                                <img src="https://my.forexmart.com/assets/images/payco.png" class="img-reponsive payco-img" width="95px">
                                <?=lang('cd_09');?>
                            </h4>
                        </div>
                        <div class="modal-body modal-show-body">
                            <div class="reg-div">
                                <div style="border-bottom: 1px solid #dfdfdf; padding-bottom: 5px; font-size: 15px;">
                                    <?=lang('cd_10');?>
                                <form action="" method="post" class="form-horizontal" id="myForm">
                                    <div class="form-group">
                                        <div class="col-sm-offset-1 col-md-offset-1 col-xs-12 col-sm-11 col-md-11">
                                            <h5> <?=lang('cd_11');?></h5>
                                            <div class="col-xs-12 col-sm-8 col-md-8" id="input">
                                                <input type="email" name="preferred_email" class="form-control" id="email_input">
                                            </div>
                                            <div class="col-xs-12 col-sm-3 col-md-3">
                                                <button type="button" class="btn-submit" id="btn-submit"><?=lang('cd_12');?></button>
                                            </div>
                                            <div class="reg-link-error col-md-11"></div>
                                        </div>
                                        <span class="clearfix"></span>
                                    </div>
                                </form>
                                <div style="font-size: 13px; border-top: 1px solid #dfdfdf; padding: 10px 15px 0px;">
                                    <span style="color: #ff0000;"><?=lang('cd_13');?>:</span><?=lang('cd_14');?> <span style="color: #ff0000;"><?=lang('cd_15');?></span> <?=lang('cd_16');?>
                                </div>
                            </div>
                            <div class="load-div">
                                <div class="small-loader col-md-12" style="display: none; text-align: center; font-weight: bold;">
                                    <img src="<?= $this->template->Images()?>small-loader.gif" width="38">
                                    <br/><?=lang('cd_17');?>
                                </div>
                                <span class="clearfix"></span>
                                <div class="msg-div"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="modal_close_bottom">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

</div>
<!--<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i><?/*=lang('ddcc_05')*/?></h1>-->
<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i><?=lang('payco_03');?></h1>
<table class="notes-list" style="margin-bottom: 150px;">
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <!--<td><p><?/*=lang('dpc_06')*/?></p></td>-->
        <td class="r_">
            <p>
                <?=lang('payco_03_1');?>

            </p>
        </td>
    </tr>
</table>

<input type="hidden" id="baseURL" value="<?= base_url(); ?>">
<script src="<?php echo base_url('assets/js/custom-its.js')?>"></script>

 