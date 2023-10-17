<?php include_once('partnership_nav.php') ?>

<style>
    .ref-info {
        margin-top: 20px;
    }
    input[type="radio"]:hover,
    input[type="radio"]:focus {
        -webkit-appearance: radio;
    }
    .reqs {
        margin-top: 17px;
    }
    #div-affiliate {
        display: block;
    }
    #div-non-affiliate {
        display: none;
    }
    #multiple {
        border: 1px solid #d6d6d6;
        padding-top: 10px;
        background-color: #f7f7f7;
        border-radius: 8px;
        margin-top: 20px;
        display: none;
    }
    .forms,
    #bt-tab4,
    #bt-tab4-1,
    #bt-tab5,
    #bt-tab6,
    #bt-tab7,
    #bt-tab8,
    #bt-tab9,
    #bt-tab10,
    #bt-tab12,
    #bt-tab13 {
        display: none;
    }
</style>

<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active ttttttt" id="commission">
        <div class="row">
            <div class="col-sm-12">
                <p class="part-text"></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-centered">
                <?php if (!(empty($status))) {
                    if($status['is_active'] == 0 && $status['status'] == 1){
                        echo "<div class='btn-login'>If you want to return your ITS transfers, you need to contact dealing@forexmart.com.</div>";
                    }else if($status['status'] == 0){
                        echo "<div class='btn-login'>".lang('its_13')."</div>";
                    } else if ($status['status'] == 1){ ?>
                        <div class="btn-login">
                           <?= lang('its_15') ?> <br/>
                        </div>
                        <div class="options">
                            <div class="ref-info col-md-12">
                                <div class="col-md-offset-3 col-md-7" style="border-top: 1px solid #d4d4d4;">
                                    <div class="radio" style="margin-bottom: 15px; border-bottom: 1px solid #d4d4d4;">
                                        <label style="font-size: 15px;font-weight: bold;"><input type="radio" name="type" value="transit-transfer" checked>  <?= lang('its_18') ?></label>
                                            <p class="col-md-offset-1" style="font-size:13px;"> <?= lang('its_19') ?> </p>
                                    </div>
                                    <div class="radio" style="border-bottom: 1px solid #d4d4d4;">
                                        <label style="font-size: 15px;font-weight: bold;"><input type="radio" name="type" value="partner-transfer"><?= lang('its_20') ?></label>
                                        <p class="col-md-offset-1" style="font-size:13px;"><?= lang('its_21') ?></p>
                                    </div>
                                    <div class="radio" style="border-bottom: 1px solid #d4d4d4;">
                                        <label style="font-size: 15px;font-weight: bold;"><input type="radio" name="type" value="request"><?= lang('its_22') ?></label>
                                        <input type="hidden" id = "partner-auto-transfer-fund" value="<?= $status['auto_transfer'] ?>">
                                        <p class="col-md-offset-1" style="font-size:13px;"><?= lang('its_23') ?> </p>
                                    </div>
                                    <span class="clearfix"></span>
                                    <button type="button" class="btn-withdraw-option pull-left" id="proceed_btn"><?= lang('its_24') ?></button>
                                </div>
                            </div>
                        </div>
                        <div class="forms tab-pane active" role="tabpanel">
                            <div class="col-md-11 col-centered tab-pane" id="bt-tab4">
                                <h4 class="with-title"></h4>
                                <div class="panel panel-default round-0">
                                    <div class="panel-heading">
                                        <b><?=lang('wpay_23');?></b>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12 col-centered">
                                                <div class="alert alert-danger" role="alert">
                                                    <span id="customError"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <div class="col-md-11 col-centered tab-pane" id="bt-tab4-1">
                                    <h4 class="with-title"></h4>
                                    <div class="panel panel-default round-0">
                                        <div class="panel-heading bt-tab4-head">
                                            <b><?=lang('part_int_1');?></b>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12 col-centered">
                                                    <div class="alert alert-success" role="alert">
                                                        <span id="customSuccess"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <div class="col-md-11 col-centered tab-pane" id="bt-tab5">
                                <h4 class="with-title"><?= lang('its_25') ?></h4>

                                <div class="col-sm-12"><div class="alert alert-danger" role="alert" style="display:none;" id="verify"></div></div>

                                <form class="form-horizontal" id="transit-form">
                                    <!--<div id="reqLabel" class="form-group">
                                        <label class="col-sm-12 control-label contest-label req2"><span class="reqs1">* Only verified Account Receiver/Referral will be displayed on 'Receiver Account Number'</span></label>
                                    </div>-->
                                    <div class="form-group">
                                        <label class="col-sm-5 control-label"><?=lang('wpay_03');?></label>
                                        <div class="col-md-5">
                                            <?php echo $getAllAccountNumber; ?>
                                        </div>
                                    </div>

                                    <div class="well">
                                        <p class="control-label" style="text-align: left; margin-bottom: 15px;"><?= lang('its_26') ?></p>
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <div class="col-md-12">
                                                <label class="control-label col-md-5"><?= lang('its_27') ?><span class="reqs1">*</span></label>
                                                <div class="col-md-5">
                                                    <select name="c_fm_account" class="form-control round-0 numeric" id="c_fm_account">
                                                        <option value="" data-wallet=""><?= lang('its_28') ?></option>
                                                        <?php foreach($referral_acc_num as $key => $value) { ?>
                                                            <option value="<?= $value['account_number'] ?>" data-wallet="<?= $value['c_wallet_number'] ?>"><?= $value['account_number'] ?></option>
                                                        <?php } ?>
                                                        <option value="Other" data-wallet="other"><?= lang('its_29') ?></option>
                                                    </select>
                                                    <input type="text" name="c_full_name" class="numeric form-control round-0" id="c_full_name" style="display: none;margin-top: 10px;" readonly />
                                                </div>
                                                <div class="small-loader col-md-2 pull-right" style="display: none;">
                                                    <img src="<?= $this->template->Images()?>small-loader.gif">
                                                </div>
                                            </div>
                                            <div class="reqs col-md-offset-5 col-md-5"></div>
                                            <div class="col-md-12">
                                                <div class="col-md-5 col-md-offset-5">
                                                    <input type="text" name="c_fm_account_input" class="numeric form-control round-0" id="c_fm_account_input" style="display: none;margin-top: 10px;" placeholder="<?= lang('its_30') ?>" />
                                                </div>
                                            </div>
                                            <div class="reqs col-md-offset-5 col-md-5"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label col-md-5"><?= lang('its_31') ?> <span class="reqs1">*</span></label>
                                            <div class="col-md-5">
                                                <input name="amount_transfer" type="text" class="form-control round-0 numeric" id="amount_transfer">
                                            </div>
                                        </div>
                                        <div class="reqs col-md-offset-5 col-md-5" style="margin-top: 0;"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label col-md-5"><?= lang('its_32') ?><span class="reqs1">*</span></label>
                                            <div class="col-md-5">
                                                <input name="transfer_nb" type="text" class="form-control round-0 numeric" id="transfer_nb" readonly>
                                            </div>
                                        </div>
                                        <div class="reqs col-md-offset-5 col-md-5"></div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label col-md-5"><?= lang('its_33') ?> <span class="reqs1">*</span></label>
                                            <div class="col-md-5">
                                                <select name="c_fm_bonus" class="form-control round-0" id="c_fm_bonus">
                                                    <option value="none" selected><?= lang('its_34') ?></option>

                                                    <option value="twpb">20%</option>
                                                    <option value="tpb">30%</option> 
                                                </select>
                                            </div>
                                        </div>
                                        <div id="bonus_err_extra_id" class="bonus_err reqs col-md-offset-5 col-md-5"></div>
                                    </div>

                                   <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label col-md-5"></label>
                                            <div class="col-md-5 bonus-agree-con" style="display: none;">
                                                <input type="checkbox" value="1" id="bonus_agree" name="agree" style="-moz-appearance: checkbox;-webkit-appearance: checkbox;"> <?=lang('i_agree_1');?><a href="https://www.forexmart.com/twenty-percent-bonus-agreement" class="agreement" target="_blank">
                                                    <span class="bonus-agreement-type"><?=lang('i_agree_2');?></span></a>
                                            </div>
                                        </div>
                                        <div class="agreement_err reqs col-md-offset-5 col-md-5"></div>
                                    </div>


                                    <div class="form-group" id="btn-div">
                                        <label for="" class="col-sm-4 control-label contest-label"></label>
                                        <div class="col-md-5">
                                            <a id="btnBackTransit" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?>><?= lang('its_35') ?></a>
                                            
                                            <a id="btnTransitSubmit" class="btn-withdraw-option"><?= lang('its_36') ?></a>
                                          
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-11 col-centered tab-pane" id="bt-tab6">
                                <h4 class="with-title"><?= lang('its_25') ?></h4>
                                <div class="alert alert-info" role-alert>
                                    <i class="fa fa-info-circle"></i> <?= lang('its_37') ?>
                                </div>
                                <div class="well">
                                    <table class="table table-bordered" style="background: #fff;">
                                        <tr>
                                            <td class="col-md-5 td-hd"><?= lang('its_38') ?> <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="transit_account_number"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-5 td-hd"><?= lang('its_31') ?> <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="p_amount_transfer"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-5 td-hd"><?= lang('its_27') ?> <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="c_tbl_acc_num"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-5 td-hd"><?= lang('receiver_name') ?><span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="c_tbl_rcvs_name"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-5 td-hd"><?= lang('its_39') ?><span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="c_tbl_bonustype"></span></td>
                                        </tr>

                                    </table>
                                    <div style="text-align: center;">
                                        <a id="btnBackTransitForm" aria-controls="bt-tab5" role="tab" data-toggle="tab" class="btn-withdraw-option"><?= lang('its_35') ?></a>
                                        <a id="btnPayCoTransitSendRequest" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option"><?= lang('its_40') ?></a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-11 col-centered tab-pane" id="bt-tab7">
                                <h4 class="with-title"><?=lang('wpay_0');?></h4>
                                <div class="panel panel-default round-0">
                                    <div class="panel-heading">
                                        <b><?=lang('wpay_15');?></b>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-10 col-centered">
                                                <div class="alert alert-success" role="alert">
                                                    <i class="fa fa-check-circle"></i> <?= lang('its_41') ?>
                                                </div>
                                                <form class="form-horizontal">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?= lang('its_42') ?></label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="resultAmountTransferred"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('its_43');?> <?=lang('wpay_19');?>:</label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="resultClientFMAccNum"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wpay_21');?>:</label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="resultTransactionNumber"></p>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-11 col-centered tab-pane" id="bt-tab8">
                                <h4 class="with-title"><?= lang('its_22') ?></h4>

                                <div class="col-sm-12"><div class="alert alert-danger" role="alert" style="display:none;" id="verify"></div></div>

                                <form class="form-horizontal" id="request-form">
                                    <div class="form-group">
                                        <label class="col-sm-5 control-label"><?=lang('wpay_03');?></label>
                                        <div class="col-md-5">
                                            <?php echo $getAllAccountNumber; ?>
                                        </div>
                                        <div class="reqs"></div>
                                    </div>

                                    <div class="well">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label col-md-5"><?= lang('its_44') ?> <span class="reqs1">*</span></label>
                                                <div class="col-md-5">
                                                    <select name="req_client" class="form-control round-0 numeric" id="req_client">
                                                        <option value="" data-wallet=""><?= lang('its_28') ?></option>
                                                        <?php foreach($referral_acc_num as $key => $value) { ?>
                                                            <option value="<?= $value['account_number'] ?>" data-wallet="<?= $value['c_wallet_number'] ?>"><?= $value['account_number'] ?></option>
                                                        <?php } ?>

                                                        <option value="Other" data-wallet="other"><?= lang('its_29') ?></option>
                                                    </select>
                                                    <input type="text" name="r_full_name" class="numeric form-control round-0" id="r_full_name" style="display: none;margin-top: 10px;" readonly />
                                                </div>
                                                <div class="small-loader col-md-2 pull-right" style="display: none;">
                                                    <img src="<?= $this->template->Images()?>small-loader.gif">
                                                </div>
                                            </div>
                                            <div class="reqs col-md-offset-5 col-md-5"></div>
                                            <div class="col-md-12">
                                                <div class="col-md-5 col-md-offset-5">
                                                    <input type="text" name="req_client_input" class="numeric form-control round-0" id="req_client_input" style="display: none;margin-top: 10px;" placeholder="<?= lang('its_30') ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label col-md-5"><?= lang('its_31') ?> <span class="reqs1">*</span></label>
                                                <div class="col-md-5">
                                                    <input name="requested_amount" type="text" class="form-control round-0 numeric" id="requested_amount">
                                                </div>
                                            </div>
                                            <div class="reqs col-md-offset-5 col-md-5"></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label col-md-5"><?= lang('its_03') ?> <span class="reqs1">*</span></label>
                                                <div class="col-md-5">
                                                    <input name="sec_code" type="text" maxlength="6" class="form-control round-0 numeric" id="security_code" >
                                                </div>
                                            </div>
                                            <div class="reqs sec_code col-md-offset-5 col-md-5"></div>
                                        </div>
                                    </div>

                                    <div class="form-group" id="btn-div">
                                        <label for="" class="col-sm-4 control-label contest-label"></label>
                                        <div class="col-md-5">
                                            <a id="btnBackRequest" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?>><?= lang('its_35') ?></a>
                                            <a id="btnRequestSubmit" class="btn-withdraw-option"><?= lang('its_36') ?></a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-11 col-centered tab-pane" id="bt-tab9">
                                <h4 class="with-title"><?= lang('its_22') ?></h4>
                                <div class="alert alert-info client-sender-info" role-alert>
                                    <i class="fa fa-info-circle"></i> <?= lang('its_45') ?>
                                </div>
                                <div class="well">
                                    <table class="table table-bordered" style="background: #fff;">
                                        <tr>
                                            <td class="col-md-5 td-hd"> <?= lang('its_46') ?> <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="rfa_c_acc_num"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-5 td-hd"><?= lang('client_name') ?><span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="rfa_client_name"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-5 td-hd"><?= lang('its_31') ?> <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="rfa_amount"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-5 td-hd"><?= lang('its_03') ?> <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="rfa_code"></span></td>
                                        </tr>

                                    </table>
                                    <div style="text-align: center;">
                                        <a id="btnBackRequestForm" aria-controls="bt-tab5" role="tab" data-toggle="tab" class="btn-withdraw-option"><?=lang('wpay_13');?></a>
                                        <a id="btnRequestWithdrawSubmit" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option"><?= lang('its_36') ?></a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-11 col-centered tab-pane" id="bt-tab10">
                                <h4 class="with-title"><?=lang('wpay_0');?></h4>
                                <div class="panel panel-default round-0">
                                    <div class="panel-heading">
                                        <b><?=lang('wpay_15');?></b>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-11 col-centered">
                                                <div class="alert alert-success" role="alert">
                                                    <i class="fa fa-check-circle"></i> <?= lang('its_47') ?>
                                                </div>
                                                <form class="form-horizontal">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?= lang('its_48') ?><?=lang('wpay_19');?>:</label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="affAccNum"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?= lang('its_49') ?></label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="reqAmount"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?= lang('its_50') ?></label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="convAmount"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?= lang('its_51') ?></label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="secCode"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?= lang('its_52') ?></label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="refNum"></p>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-11 col-centered tab-pane" id="bt-tab11">
                                <h4 class="with-title"><?= lang('its_53') ?></h4>

                                <div class="col-sm-12"><div class="alert alert-danger" role="alert" style="display:none;" id="partner-verify"></div></div>

                                <form class="form-horizontal" id="partner-transit-form">
                                    <!--<div id="reqLabel" class="form-group">
                                        <label class="col-sm-12 control-label contest-label req2"><span class="reqs1">* Only verified Account Receiver/Referral will be displayed on 'Receiver Account Number'</span></label>
                                    </div>-->
                                    <div class="form-group">
                                        <label class="col-sm-5 control-label"><?=lang('wpay_03');?></label>
                                        <div class="col-md-5">
                                            <?php echo $getAllAccountNumber; ?>
                                        </div>
                                        <div class="reqs"></div>
                                    </div>

                                    <div class="well">
                                        <p class="control-label" style="text-align: left; margin-bottom: 15px;"><?= lang('its_54') ?></p>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label col-md-5"><?= lang('its_27') ?> <span class="reqs1">*</span></label>
                                                <div class="col-md-5">
                                                    <input type="text" name="partner-input" class="numeric form-control round-0" id="partner-input" placeholder="<?= lang('its_30') ?> " />
                                                </div>
                                                <div class="small-loader col-md-2 pull-right" style="display: none;">
                                                    <img src="<?= $this->template->Images()?>small-loader.gif">
                                                </div>
                                            </div>
                                            <div class="reqs default_error col-md-offset-5 col-md-5 partner-input-error"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label col-md-5"><?= lang('its_31') ?>  <span class="reqs1">*</span></label>
                                            <div class="col-md-5">
                                                <input name="partner-amount" type="text" class="form-control round-0 numeric" id="partner-amount">
                                            </div>
                                        </div>
                                        <div class="reqs default_error col-md-offset-5 col-md-5 partner-amount-error" style="margin-top: 0;"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label col-md-5"><?= lang('its_32') ?>  <span class="reqs1">*</span></label>
                                            <div class="col-md-5">
                                                <input name="partner-balance" type="text" class="form-control round-0 numeric" id="partner-balance" readonly>
                                            </div>
                                        </div>
                                        <div class="reqs default_error col-md-offset-5 col-md-5"></div>
                                    </div>
                                    
                                    <?php 
                                    
                                    if(FXPP::isSpecailTransitTransferPartner()){  
                                    ?>
                                     <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label col-md-5"><?= lang('its_33') ?>  <span class="reqs1">*</span></label>
                                            <div class="col-md-5">
                                               <select name="p_fm_bonus" class="form-control round-0" id="p_fm_bonus">
                                                    <option value="none" selected><?= lang('its_34') ?></option>
                                                    <option value="fpb">50%</option> 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="reqs default_error col-md-offset-5 col-md-5 p_fm_bonus_error" style="margin-top: 0;"></div>
                                    </div>
                                    
                                    <?php } ?>
                                 
                                    <div class="form-group" id="btn-div">
                                        <label for="" class="col-sm-4 control-label contest-label"></label>
                                        <div class="col-md-5">
                                            <a id="btnBackTransit" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?>><?= lang('its_35') ?> </a>
                                            <a id="btnPartnerSubmit" class="btn-withdraw-option"><?= lang('its_36') ?> </a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-11 col-centered tab-pane" id="bt-tab12">
                                <h4 class="with-title"><?= lang('its_53') ?> </h4>
                                <div class="alert alert-info" role-alert>
                                    <i class="fa fa-info-circle"></i> <?= lang('its_55') ?>
                                </div>
                                <div class="well">
                                    <table class="table table-bordered" style="background: #fff;">
                                        <tr>
                                            <td class="col-md-5 td-hd"><?= lang('its_38') ?> <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="ptt_account_num"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-5 td-hd"><?= lang('its_31') ?> <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="ptt_amount_transfer"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-5 td-hd"><?= lang('its_27') ?> <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="ptt_receiver"></span></td>
                                        </tr>
                                         <tr>
                                            <td class="col-md-5 td-hd"><?= lang('its_39') ?> </td>
                                            <td class="col-md-7"><span id="p_tbl_bonustype"></span></td>
                                        </tr>
                                    </table>
                                    <div style="text-align: center;">
                                        <a id="btnBackPartnerForm" aria-controls="bt-tab5" role="tab" data-toggle="tab" class="btn-withdraw-option"><?=lang('its_35');?></a>
                                        <a id="btnPartnerTransfer" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option"><?= lang('its_40') ?> </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-11 col-centered tab-pane" id="bt-tab13">
                                <h4 class="with-title"><?=lang('wpay_0');?></h4>
                                <div class="panel panel-default round-0">
                                    <div class="panel-heading">
                                        <b><?=lang('wpay_15');?></b>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-10 col-centered">
                                                <div class="alert alert-success" role="alert">
                                                    <i class="fa fa-check-circle"></i> <?= lang('its_56') ?>
                                                </div>
                                                <form class="form-horizontal">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?= lang('its_57') ?></label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="ptt_result_amount"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?= lang('its_43') ?> <?=lang('wpay_19');?>:</label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="ptt_result_account"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wpay_21');?>:</label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="ptt_result_tid"></p>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class='btn-login'><?= lang('its_58') ?> <a href='#' style='color:#fff'>partnership@forexmart.com</a> <?= lang('its_59') ?></div>
                    <?php }
                } else { ?>
                    <button id="its" type="button" class="btn-login"> <?= lang('its_60') ?></button>
                    <div style="display: none" class='btn-login its_send'> <?= lang('its_61') ?></div>
                <?php } ?>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="its_model" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-centered">

                        <p class="manage-text"><b><?= lang('its_62') ?></b></p>
                        <div>
                            <div class="message"></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal-footer round-0">
                <button type="button" class="btn round-0" id="modal-close-btn" data-dismiss="modal" aria-label="Close"><?= lang('its_63') ?></button>
            </div>

        </div>
    </div>
</div>



<div class="modal fade" id="checkSecurityModel" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-centered" style="text-align: center">

                        <p class="manage-text"><b><?= lang('its_68') ?></b></p>


                    </div>
                </div>
            </div>

            <div class="modal-footer round-0">
                <button type="button" class="btn round-0" id="modal-close-btn" data-dismiss="modal" aria-label="Close"><?= lang('its_63') ?></button>
            </div>

        </div>
    </div>
</div>




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


<script type="application/javascript">
    
var acc_num = 0;
var custom_input = $('#ref-id-custom');
var office = "<?=IPLoc::Office()?>";
var modal_title = "Registration";
var modal_btn = "Register";
var itemLess = 4;
var isSpecailTransitTransferPartner="<?= FXPP::isSpecailTransitTransferPartner()?>";
var url = '<?= base_url(); ?>';
  
  var transitAllowVar = {
    'account_number':false,
    'status':false,
    };

    $(document).on("click",'#its',function(){
        $(".loader-holder").show();

        $.post(url+"partnership/its_request",{},function(data){
            console.log(data);
            $("#its_model").modal('show');
            $(".its_send").show();
            $('#its').remove();
            $('.message').html(data.message);
            $(".loader-holder").hide();
        });
    });

    $(document).ready(function () {
        $('.payco-link').click(function (e) {
            var header_div =
                '<button type="button" class="close supresscookies" data-dismiss="modal" aria-label="Close" id="modal_close_top">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '<h4 class="modal-title modal-show-title"> ' +
                '<img src="https://my.forexmart.com/assets/images/payco.png" class="img-reponsive payco-img" width="95px">' + modal_title +
                '</h4>';
            var reg_div =
                '<div class="reg-div">' +
                '<div style="border-bottom: 1px solid #dfdfdf; padding-bottom: 5px; font-size: 15px;">' +
                'Use <b>PayCo Registration</b> to use Transit Transfer feature.' +
                '</div>' +
                '<form action="" method="post" class="form-horizontal" id="myForm">' +
                '<div">' +
                '<div class="col-sm-offset-1 col-md-offset-1 col-xs-12 col-sm-11 col-md-11">' +
                '<h5>Please enter your preferred PayCo Email below:</h5>' +
                '<div class="col-xs-12 col-sm-8 col-md-8" id="input">' +
                '<input type="email" name="preferred_email" class="form-control" id="email_input">' +
                '</div>' +
                '<div class="col-xs-12 col-sm-3 col-md-3">' +
                '<button type="button" class="btn-submit" id="btn-submit">' + modal_btn + '</button>' +
                '</div>' +
                '<div class="reqs col-md-11"></div>' +
                '</div>' +
                '</div>' +
                '</form><span class="clearfix">' +
                '</div>';
            var load_vid =
                '<div class="load-div">' +
                '<div class="small-loader col-md-12" style="display: none; text-align: center; font-weight: bold;">' +
                '<img src="<?= $this->template->Images()?>small-loader.gif" width="38">' +
                '<br/>Loading...' +
                '</div>' +
                '<span class="clearfix"></span>' +
                '<div class="msg-div"></div>' +
                '</div>';

            var email = '';

            $('.modal-header').html(header_div);
            $('.modal-body').html(reg_div);

            $('#btn-submit').click(function () {
                email = $('#email_input').val();

                if (!$('#email_input').val().length) {
                    $('#email_input').change(function () {
                        $(this).css('border-color', '#f11d1d');
                    }).trigger('change');
                    $('#email_input').focus();
                } else {
                    var url = '<?= base_url(); ?>';

                    $.ajax({
                        type:       'post',
                        url:        url + 'deposit/getPaycoRegURLToken',
                        data:       { email: email },
                        dataType:   'json',
                        beforeSend: function () {
                            $('.modal-body').html(load_vid);
                            $('.small-loader').show();
                        },
                        success: function (x) {
                            $('.small-loader').hide();
                            $('.modal-body').html(reg_div);
                            console.log(x);
                            if (x.success) {
                                $.ajax({
                                    type:       'post',
                                    url:        url + 'partnership/testValidate',
                                    dataType:   'json',
                                    data:       {token: x.result.data.Token, email: email, account_number: ''},
                                    beforeSend: function () {
                                        $('#loader-holder').show();
                                    },
                                    success: function (response) {
                                        $('#loader-holder').hide();
                                        console.log(response);
                                        $('.modal-body').html(load_vid);
                                        if (response.error) {
                                            $('.msg-div').html(response.message);
                                        } else {
                                            if (response.result.curl_result == 'Success') {
                                                $('.msg-div').html('Your registration is now on process. You will later receive an email from our Admin.');
                                            } else {
                                                $('.msg-div').html('Registration process failed. Please try again.');
                                            }
                                        }
                                    }
                                });
                            } else {
                                $('.modal-body').html(reg_div);

                                $email_exist = x.error.includes('Registration completed already for');

                                if ($email_exist) {
                                    $('#email_input').val(x.email);
                                    $('.reqs').html('PayCo account already exists for ' + x.email);
                                } else {
                                    $('.reqs').html(x.error);
                                }
                            }
                        }
                    });
                }
            });
        });
    });

    $(document).ready(function () {
        var url = '<?= base_url(); ?>';
        var id = '<?= $this->session->userdata('user_id');?>';
        console.log(id);

        $('#affiliate').click(function (e) {
            $('#div-affiliate').show();
            $('#div-non-affiliate').hide();
            $('#non-ref-account-number').val('');
            $('#non-ref-email').val('');
        });

        $('#non-affiliate').click(function (e) {
            $('#div-affiliate').hide();
            $('#div-non-affiliate').show();
            $('#account_number').val('');
            $('#ref-id-custom').val('');
        });

        $('#custom').click(function () {
            custom_input.attr('readonly', false);
            custom_input.attr('placeholder', 'New Email');
        });

        $('#default').click(function () {
            custom_input.attr('readonly', true);
            custom_input.attr('placeholder', '');
        });

        $('#acc-num').change( function (e) {
            $('#multiple').empty();
            acc_num = $(this).val();

            if (acc_num !== '') {
                $.ajax({
                    type:       'post',
                    dataType:   'json',
                    data:       {acc_num: acc_num},
                    url:        url+'partnership/getCustomEmail',
                    beforeSend: function () {
                        $('.small-loader').show();
                    },
                    success: function (data) {
                        $('.small-loader').hide();
                        console.log(data);
                        $('#ref-id').val(data.result.email);
                    }
                });
            } else {
                $('#ref-id').val('');
            }
        });

        $('#reg-btn').click(function () {
            $('#multiple').hide();
            $('#multiple').empty();
            acc_num = $('#acc-num').val();

            if (acc_num !== '') {
                $.ajax({
                    type:       'post',
                    dataType:   'json',
                    data:       {acc_num: acc_num},
                    url:        url+'partnership/getCustomEmail',
                    beforeSend: function () {
                        $('.small-loader').show();
                    },
                    success: function (data) {
                        $('.small-loader').hide();
                        console.log(data);
//                        if (office) {
//                            $('#ref-id').val(data.result);
//                        } else {
                            $.each(data.result, function (index, item) {
                                console.log(index);
                                console.log(item);
                                var node = $('<p/>').addClass('col-md-12');
                                var accountProp = {
                                    type:   'text',
                                    name:   'account_number',
                                    value:  item.account_number,
                                    readOnly:   'readonly'
                                };
                                var emailProp = {
                                    type:   'text',
                                    name:   'email',
                                    value:  item.email
                                };
                                var acctInput = $('<div/>')
                                    .addClass('col-md-5 col-md-offset-1')
                                    .append(
                                    $('<input/>')
                                        .addClass('form-control input-sm')
                                        .prop(accountProp)
                                );
                                var emailInput = $('<div/>')
                                    .addClass('col-md-5')
                                    .append(
                                    $('<input/>')
                                        .addClass('form-control input-sm')
                                        .prop(emailProp)
                                );
                                node.append(acctInput).append(emailInput);
                                node.appendTo($('#multiple'));
                                $('#multiple').show();
                            });
//                        }
                    }
                });
            } else {
                $('#ref-id').val('');
            }
        });

        $('#reg-submit').click(function () {
            var email = '';
            var show_modal = false;

            if ($('#affiliate').is(':checked')) {
                if ($('#custom').is(':checked')) {
                    if ($('#ref-id-custom').val().length == 0) {
                        $('.reqs').html('Required');
                        show_modal = false;
                    } else {
                        $('.reqs').html('');
                        show_modal = true;
                        email = $('#ref-id-custom').val();
                    }
                } else {
                    if ($('#ref-id').val().length != 0) {
                        show_modal = true;
                        email = $('#ref-id').val();
                    }
                }
            }
            if ($('#non-affiliate').is(':checked')) {
                if ($('#non-ref-account-number').val().length <= 0) {
                    $('.reqs').html('Required');
                    show_modal = false;
                } else if ($('#non-ref-email').val().length <= 0) {
                    $('.reqs').html('Required');
                    show_modal = false;
                } else {
                    $('.reqs').html('');
                    email = $('#non-ref-email').val();
                    acc_num = $('#non-ref-account-number').val();
                    show_modal = true;
                }
            }

            if (show_modal) {
                $.ajax({
                    type:       'post',
                    dataType:   'json',
                    data:       {email: email, acc_num: acc_num},
                    url:        url+'deposit/getPaycoRegURLToken',
                    beforeSend: function () {
                        $('#loader-holder').show();
                    },
                    success: function (x) {
                        $('#loader-holder').hide();
                        $('#its_model').modal('show');
                        if (x.success) {
//                            if (office) {
                                console.log(x);
                                $.ajax({
                                    type:       'post',
                                    url:        url + 'partnership/testValidate',
                                    dataType:   'json',
                                    data:       {token: x.result.data.Token, email: email, account_number: $('#acc-num').val()},
                                    beforeSend: function () {
                                        $('#loader-holder').show();
                                    },
                                    success: function (response) {
                                        $('#loader-holder').hide();
                                        console.log(response);
                                        if (response.error) {
                                            $('.msg-div').html(response.message);
                                        } else {
                                            if (response.result.curl_result == 'Success') {
                                                $('.manage-text').html('Affiliate registration is now on process. Admin will review registration and send affiliates an email for more information.');
                                            } else {
                                                $('.manage-text').html('Registration process failed. Please try again.');
                                            }
                                        }
                                    }
                                });
//                            } else {
//                                $('.manage-text').html('Sent Payco Registration link to mail ' + x.email);
//                            }
                        } else {
                            var email_exist = x.error.includes('Registration completed already for');

                            if (email_exist) {
                                $('#email_input').val(x.email);
                                $('.manage-text').html('PayCo account already exists for ' + x.email);
                            } else {
                                $('.manage-text').html(x.error);
                            }
                        }
                    }
                });
            }
        });

        $('#modal-close-btn').click(function () {
            custom_input.val('');
        });

        jQuery(".numeric").on("keypress keyup blur",function (event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        jQuery(".numeric").on("blur",function (event) {
            var value=$(this).val().replace(/[^0-9.,]*/g, '');
            value=value.replace(/\.{2,}/g, '.');
            value=value.replace(/\.,/g, ',');
            value=value.replace(/\,\./g, ',');
            value=value.replace(/\,{2,}/g, ',');
            value=value.replace(/\.[0-9]+\./g, '.');
            $(this).val(value)
        });

        $('#proceed_btn').click(function (e) {
            var type = $('input[name="type"]:checked').val();

            $('.options').hide();
            $('.forms').show();

            if (type === 'request') {
                $('#bt-tab8').show();
                $('#bt-tab5').hide();
                $('#bt-tab11').hide();
            } else if (type === 'transit-transfer') {
                $('#bt-tab5').show();
                $('#bt-tab8').hide();
                $('#bt-tab11').hide();
            } else {
                $('#bt-tab11').show();
                $('#bt-tab5').hide();
                $('#bt-tab8').hide();
            }
        });

        $('#btnBackTransit, #btnBackRequest').click(function () {
           $('.options').show();
            $('.forms').hide();
        });





        $('#c_fm_account').on('change', function () {
            
            var wallet = $(this).find(':selected').data('wallet');
            var c_wallet = $('#c_wallet'), c_fm_account_input = $('#c_fm_account_input');

                removeFiftyPer();

            $('#c_full_name').hide();
            $(this).closest('div.col-md-12').next('div.reqs').html('');

            if (wallet === 'other') {
                c_fm_account_input.show();
                c_fm_account_input.focus();
                $('#c_fm_account').val('Other');
            } else {
                if ($(this).val().length) {
                   
                   var v_account_number=$(this).val();
                   getPartnerAffiliateInfo(v_account_number);
                }

                $('#c_fm_account_input').closest('div.col-md-12').next('div.reqs').html('');
                c_wallet.prop('readonly',true);
                c_wallet.val(wallet);
                c_wallet.attr('placeholder','');
                c_fm_account_input.hide();
            }
        });




$('#c_fm_account_input').on('blur', function () {
    
     var v_account_number=$(this).val();
    getPartnerAffiliateInfo(v_account_number);
});



        $('#req_client').on('change', function () {
            var value = $(this).val();
            var r_full_name = $('#r_full_name');
            console.log(value);
            $('#r_full_name').hide();
            if (value === 'Other') {
                console.log('ok');
                $('#r_full_name').hide();
                $('#req_client_input').show();
                $('#req_client_input').focus();
                $('#req_client').val('Other');
            } else {
                if (value != '') {
                    $.ajax({
                        type: 'post',
                        url: url + 'partnership/getAffiliateInfo',
                        dataType: 'json',
                        data: {value: value},
                        beforeSend: function () {
                            $('.small-loader').show();
                        },
                        success: function (x) {
                            $('.small-loader').hide();
                            $('#r_full_name').show();
                            $('#r_full_name').val(x.full_name);
                        }
                    });
                }
            }

        });

        $('#amount_transfer, #partner-amount').on('keyup blur', function(e){
            var getId = e.currentTarget.id;
            var selectId = getId == 'amount_transfer' ? '#transfer_nb' : '#partner-balance';
            
            var amount = $(this).val().trim(),
                newBalance = 0;
            if(amount !== '' && amount.match(/^\d*\.?\d*$/)){
                var walletBalance = parseFloat($('#accountNumber').data('balance'));
                var computeTotalBalance = parseFloat(walletBalance) - parseFloat(amount);

                newBalance = computeTotalBalance > 0 ? computeTotalBalance : computeTotalBalance.toFixed(2);
                $(selectId).val(roundtoTwo(newBalance));
            }
        });

        $('#btnRequestSubmit').click(function () {

            $('#request-form :input').each(function(index, item) {
                var total_input = $('#request-form :input').length;

                if (!(item.name == 'r_full_name')) {
                    if (!$(this).val().length) {
                        $(this).closest('div.col-md-12').next('div.reqs').html('<p class="field-req"><?= lang('its_64') ?></p>');
                    } else {
                        $(this).closest('div.col-md-12').next('div.reqs').html('');

                        if (total_input - 2 === index) {
                            if ($('#requested_amount').val() < 2) {
                                $('#requested_amount').closest('div.col-md-12').next('div.reqs').html('<p class="field-req"><?= lang('its_65') ?></p>');
                            } else if ($('#security_code').val().length < 6) {
                                $('#security_code').closest('div.col-md-12').next('div.reqs').html('<p class="field-req"><?= lang('its_66') ?></p>');
                            } else {

                                var client_num, client_input;
                                if ($('#req_client').val() === 'Other') {
                                    client_num = $('#req_client_input').val();
                                    client_input = 'req_client_input';
                                } else {
                                    client_num = $('#req_client').val();
                                    client_input = 'req_client';
                                }


                                if(!$('#request-form p.field-req').length){
                                    $.ajax({
                                        type:       'POST',
                                        url:        url + 'withdraw/checkSecurityCode',
                                        dataType:   'json',
                                        data:       { sec_code: $('#security_code').val(), client_account_num: client_num },
                                        beforeSend: function() {
                                            $('#loader-holder').show();
                                        },
                                        success: function (x) {
                                            $('#loader-holder').hide();
                                            if (!x.success) {
                                                $('#security_code').closest('div.col-md-12').next('div.reqs').html('<p class="field-req">'+ x.message +'</p>');
                                            } else {
                                                if(!$('#request-form p.field-req').length){
                                                    $('#rfa_c_acc_num').html(client_num);
                                                    if ($('#req_client').val() === 'Other') {
                                                        $('.client-sender-info').html('<?= lang('its_67') ?>');
                                                    }

                                                    $('#rfa_amount').html($('#requested_amount').val() + ' ' + $('#accountNumber').data('currency'));
                                                    $('#rfa_code').html($('#security_code').val());
                                                    $('#rfa_client_name').html(x.full_name);

                                                    $('#bt-tab8').hide();
                                                    $('#bt-tab9').show();
                                                }
                                            }
                                        }
                                    });
                                }
                            }
                        }
                    }
                }
            });
        });


        $("select[name=c_fm_bonus]").on("change", function() {
            if($(this).val() == 'tpb'){
                console.log($(this).val());
                $('.bonus-agree-con').show();
                $('#bonus_agree').prop('checked', true);
                $('.bonus-agreement-type').html('30% bonus agreement');

            }else if($(this).val() == 'twpb'){
                console.log($(this).val());
                $('.bonus-agree-con').show();
                $('#bonus_agree').prop('checked', true);
                $('.bonus-agreement-type').html('20% bonus agreement');

            }else if($(this).val() == 'fpb'){
                console.log($(this).val());
                $('.bonus-agree-con').show();
                $('#bonus_agree').prop('checked', true);
                $('.bonus-agreement-type').html('50% bonus agreement');

            }else{
                $('.bonus-agree-con').hide();
            }
        });


        $("#bonus_agree").on('change', function() {
            if ($(this).is(':checked')) {
                $('#bonus_agree').val(1);
                $('#bonus_agree').closest('div.col-md-12').next('div.reqs').html('');
            } else {
                $('#bonus_agree').val(2);
            }
        });


$(document).on("click","#btnPartnerSubmit",function(){   
    

       var url = '<?= base_url(); ?>';
      var total_input = $('#partner-transit-form :input').length;
     
     $(".default_error").html("");
     
     var walletBalance = parseFloat($('#accountNumber').data('balance'));    
     var current_account_num=$('#accountNumber').data('accountnumber');
     var new_wallet_balance=$("#partner-balance").val();
     
     var  partner_account_num= $('#partner-input').val();
     var partner_amount=$("#partner-amount").val();
     
     var p_fm_bonus= $('#p_fm_bonus').val() ;
      
       

var main_balance=parseFloat(walletBalance);
var debit_amount = parseFloat(partner_amount);
var insufficient = (debit_amount>main_balance)? true : false;

      
      
     if(!partner_account_num.length)
     {
           $(".partner-input-error").html('<p class="field-req"><?= lang('its_64') ?></p>');
     }
     else if(partner_account_num.length<5)
     {
          $(".partner-input-error").html('<p class="field-req">Wrong partner account</p>');
     }
     else if(!partner_amount.length)
     {
          $(".partner-amount-error").html('<p class="field-req"><?= lang('its_64') ?></p>');  
     } 
     else if(parseFloat(partner_amount)<2)
     {
          $(".partner-amount-error").html('<p class="field-req"><?= lang('its_65') ?></p>');  
     }
     else if(main_balance<=0)
     {
          $(".partner-amount-error").html('<p class="field-req"><?= lang('its_70') ?></p>');  
     }
     else if(insufficient)
     {
          $(".partner-amount-error").html('<p class="field-req"><?= lang('its_70') ?></p>');  
     }
     else if(!checkFiftyPercentAllow(p_fm_bonus))
    {
         var p_fm_bonus_error='<p class="field-req">You are not allowed to access a 50% bonus.</p>';
         $("#p_fm_bonus_error").html(p_fm_bonus_error); 
    }
    else
    {
        $.ajax({
            type: 'POST',
            url: url + 'withdraw/checkWalletAccNumAndResellerDataModified',
            data: {
                current_account_num: current_account_num,
                partner_account_num: partner_account_num,
                type: 1
            },
            dataType: 'json',
            beforeSend: function () {
                $('#loader-holder').show();
            },
            success: function (x) {
                $('#loader-holder').hide();
                console.log(x);

                if (x.return.error) {
                    $('#partner-input').closest('div.col-md-12').next('div.reqs').html('<p class="field-req">'+ x.return.error_message +'.</p>');
                }
    //
                if(!$('#partner-transit-form p.field-req').length) {

                        if(p_fm_bonus == 'none')
                        {
                            var  bonustype = '<?= lang('it_s76') ?>';

                        }else if (p_fm_bonus == 'tpb') {

                            var  bonustype = '<?= lang('its_77') ?>';
                        }else if (p_fm_bonus == 'fpb') {

                             var bonustype = '<?= lang('its_78') ?>';
                        } 
                        else if(p_fm_bonus == 'twpb') {                                                                        
                            var  bonustype = '20 PERCENT BONUS';
                        }else{
                            var  bonustype = 'N/A';
                        }
    //                                                           

                        $('#p_tbl_bonustype').html(bonustype); 



                    $('#ptt_account_num').html(current_account_num);
                    $('#ptt_amount_transfer').html($('#partner-amount').val());
                    $('#ptt_receiver').html($('#partner-input').val());

                    $('#bt-tab11').hide();
                    $('#bt-tab12').show();
                }
            }
        });

      }
     
     
  });

        $('#btnBackTransitForm').click(function(){
            $('#bt-tab6').hide();
            $('#bt-tab5').show();
        });

        $('#btnBackRequestForm').click(function(){
            $('#bt-tab9').hide();
            $('#bt-tab8').show();
        });

        $('#btnBackPartnerForm').click(function () {
            $('#bt-tab12').hide();
            $('#bt-tab11').show();
        });

        $('#btnPayCoTransitSendRequest').click(function(){
           
            var tranType=$("input[type='radio'][name='type']:checked").val();
 

            if (id == 132478) {
                $.ajax({
                    type:"POST",
                  //  url: url+"withdraw/WalletTransferModified",                   
                    url: url+"withdraw/requestFundTransfer",
                    data: $('#transit-form').serialize() + '&tranType='+tranType,
                    dataType: 'json',
                    beforeSend: function(){
                        $('#loader-holder').show();
                    },
                    success: function(x){
                        $('#loader-holder').hide();


                            console.log(x);


                        if(x.data.is_success){
                            var transaction_id = x.data.transaction_id;

                            $('#resultAmountTransferred').html(x.data.actual_amount);
                            $('#resultClientFMAccNum').html(x.data.c_account);
                            $('#resultTransactionNumber').html(transaction_id);
                            $('#bt-tab6').hide();
                            $('#bt-tab7').show();
                        }else{
                            $('#customError').html(x.data.errorMsg);
                            $('#bt-tab6').hide();
                            $('#bt-tab4').show();
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('#loader-holder').hide();
                        $('[id^="bt-tab"]').removeClass('active');
                        $('#bt-tab4').addClass('active');
                        $('#customError').html('<?= lang('its_79') ?>');
                        console.log(xhr.status);
                        console.log(thrownError);
                    }
                });
            } else {

               
                $.ajax({
                    type:"POST",
                   // url: url+"withdraw/WalletTransferModified_backup",
                    url: url+"withdraw/requestFundTransfer",
                    data: $('#transit-form').serialize() + '&tranType='+tranType,
                    dataType: 'json',
                    beforeSend: function(){
                        $('#loader-holder').show();
                    },
                    success: function(x){
                        $('#loader-holder').hide();

                        if (id == 60247) {
                            console.log(x);
                        }

            
                        if(x.data.is_success){
                            var transaction_id = x.data.transaction_id;

                            $('#resultAmountTransferred').html(x.data.actual_amount);
                            $('#resultClientFMAccNum').html(x.data.c_account);
                            $('#resultTransactionNumber').html(transaction_id);
                            $('#bt-tab6').hide();
                            $('#bt-tab7').show();
                        }else{
                            $('#customError').html(x.data.errorMsg);
                            $('#bt-tab6').hide();
                            $('#bt-tab4').show();
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('#loader-holder').hide();
                        $('[id^="bt-tab"]').removeClass('active');
                        $('#bt-tab4').addClass('active');
                        $('#customError').html('<?= lang('its_79') ?>');
                        console.log(xhr.status);
                        console.log(thrownError);
                    }
                });
            }
        });

        $('#btnRequestWithdrawSubmit').click(function(){



            checkSecurityCodeAfterSubmit().done(function(data){


                 if (data.success){  // unique security code

                     //var tranType=$("input[type='radio'][name='type']:checked").val();
                     var tranType=3; // request client transfer



                     var url = '<?= base_url(); ?>';
                     var  ajax_url = '';
                     var partner_type =  $('#partner-auto-transfer-fund').val();
//                     console.log(partner_type);
                    /* if (id == 132478) {
                         ajax_url =  url+"withdraw/requestFundTransfer";
                     }else{
                         ajax_url =  url+"withdraw/RequestWalletTransferModified";
                     }*/
                     ajax_url =  url+"withdraw/requestFundTransfer";
                     $.ajax({
                         type:"POST",
                         url: ajax_url,
                         data: $('#request-form').serialize() + '&tranType='+tranType,
                         dataType: 'json',
                         beforeSend: function(){
                             $('#loader-holder').show();
                         },
                         success: function(x){

                             $('#loader-holder').hide();
                             $('#bt-tab9').hide();

                             if(!x.data.is_success){
                                 $('#bt-tab4').show();
                                 $('#customError').html(x.data.message);
                             }else {
                                 if(!x.data.for_approval) {

                                     $('#reqAmount').html(x.data.actual_amount);
                                     $('#convAmount').html(x.data.received_amount);
                                     $('#affAccNum').html(x.data.c_account);
                                     $('#secCode').html(x.data.security_code);
                                     $('#refNum').html(x.data.transaction_id);
                                     $('#bt-tab10').show();
                                 }else{
                                     $('#bt-tab4-1').show();
                                     $('#customSuccess').html(x.data.message)
                                 }
                             }

                         },
                         error: function (xhr, ajaxOptions, thrownError) {
                             $('#loader-holder').hide();
                             $('#bt-tab9').hide();
                             $('#bt-tab4').show();
                             $('#customError').html('<?= lang('its_79') ?>');
                             console.log(xhr.status);
                             console.log(thrownError);
                         }
                     });




                 }else{ // duplicate security code

                     $("#checkSecurityModel").modal('show');
                     $('#bt-tab9').hide();
                     $('#bt-tab8').show();
                 }



            });


        });







        $('#btnPartnerTransfer').click(function(){
            var url = '<?= base_url(); ?>';

            var tranType=$("input[type='radio'][name='type']:checked").val();

            $.ajax({
                type:"POST",
               // url: url+"withdraw/WalletTransferModified",
                url: url+"withdraw/requestFundTransfer",
                data: $('#partner-transit-form').serialize() + '&type=partner'+ '&tranType='+tranType,
                dataType: 'json',
                beforeSend: function(){
                    $('#loader-holder').show();
                },
                success: function(x){
                    $('#loader-holder').hide();

                    if (id == 60247) {
                        console.log(x);
                    }

                    if(x.data.is_success){
                        var transaction_id = x.data.transaction_id;

                        $('#ptt_result_amount').html(x.data.actual_amount);
                        $('#ptt_result_account').html(x.data.c_account);
                        $('#ptt_result_tid').html(transaction_id);
                        $('#bt-tab12').hide();
                        $('#bt-tab13').show();
                    }else{
                        $('#customError').html(x.data.message);
                        $('#bt-tab4').show();
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#loader-holder').hide();
                    $('[id^="bt-tab"]').removeClass('active');
                    $('#bt-tab4').addClass('active');
                    $('#customError').html('<?= lang('its_83') ?>');
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        });
    });




$(document).on("click","#btnTransitSubmit",function(){


    
            var url = '<?= base_url(); ?>';



            $('#transit-form :input').each(function(index, item) {
                var total_input = $('#transit-form :input').length;
               var c_fm_bonus= $('#c_fm_bonus').val() ;
              
              
                if (!(item.name == 'transfer_nb') && !(item.name == 'c_full_name')) {

                    var client_num, client_input;
                    if ($('#c_fm_account').val() === 'Other') {
                        client_num = $('#c_fm_account_input').val();
                        client_input = 'c_fm_account_input';
                    } else {
                        client_num = $('#c_fm_account').val();
                        client_input = 'c_fm_account';
                    }


                    if(item.name == 'agree'){
                        if ($("select[name=c_fm_bonus]").val()  == 'tpb' && $('#bonus_agree').is(':checked')=== false) {
                            console.log('agree bonus1');
                            $('#bonus_agree').val(2);
                            $('#bonus_agree').closest('div.col-md-12').next('div.reqs').html('<p class="field-req"><?= lang('its_64') ?></p>');

                        }else if ($("select[name=c_fm_bonus]").val()  == 'twpb' && $('#bonus_agree').is(':checked')=== false){
                            console.log('agree bonus2');
                            $('#bonus_agree').val(2);
                            $('#bonus_agree').closest('div.col-md-12').next('div.reqs').html('<p class="field-req"><?= lang('its_64') ?></p>');
                        }
                    }else if (!$(this).val().length && item.name !== 'c_fm_account_input') {
                        $(this).closest('div.col-md-12').next('div.reqs').html('<p class="field-req"><?= lang('its_64') ?></p>');
                    } else if (item.name === 'c_fm_account_input' && $('#c_fm_account').val() === 'Other' && !$('#c_fm_account_input').val().length) {
                        $(this).closest('div.col-md-12').next('div.reqs').html('<p class="field-req"><?= lang('its_64') ?></p>');
                    } 
                    else if(!checkFiftyPercentAllow(c_fm_bonus))
                    {

                        var bonus_err_extra_id_error='<p class="field-req">You are not allowed to access a 50% bonus.</p>';
                        $("#bonus_err_extra_id").html(bonus_err_extra_id_error); 

                    }
                    else {
                        $(this).closest('div.col-md-12').next('div.reqs').html('');
                         // console.log(index + '-' + item.name );
                        if (total_input - itemLess === index) {
                            $('#c_wallet').closest('div.col-md-12').next('div.reqs').html('');
                           // console.log($('#transit-form p.field-req').length);
                            if($('#bonus_agree').val() == 1){
                            if (!$('#transit-form p.field-req').length) {
                                var acct_num = $('#accountNumber')[0];
                                
                                        if (this.id == 'amount_transfer') {
                                            if ($(this).val().length) {
                                                var walletBalance = parseFloat($('#accountNumber').data('balance'));
                                                var debitAmount = parseFloat($(this).val());
                                                var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;

                                                if(!result) {
                                                    $('#amount_transfer').closest('div.col-md-12').next('div.reqs').html('<p class="field-req"><?= lang('its_70') ?></p>');
                                                } else {
                                                    if ($('#amount_transfer').val() < 2) {
                                                        $('#amount_transfer').closest('div.col-md-12').next('div.reqs').html('<p class="field-req"><?= lang('its_65') ?></p>');
                                                    } else {
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: url + 'withdraw/checkWalletAccNumAndResellerDataModified',
                                                            data: {
                                                                current_account_num: $('#accountNumber').data('accountnumber'),
                                                                client_account_num: client_num,
                                                                type: 0,
                                                                c_fm_bonus:c_fm_bonus
                                                            },
                                                            dataType: 'json',
                                                            beforeSend: function () {
                                                                $('#loader-holder').show();
                                                            },
                                                            success: function (x) {
                                                                $('#loader-holder').hide();


                                                                 console.log(x);


                                                                if (x.return.error) {
                                                                    //c_tbl_bonustype


                                                                    var errorMsg = x.return.error_message;

                                                                    if(errorMsg.search("archived") !== -1){
                                                                        errorMsg = "Unfortunately, your receiver account has been archived after 90 days inactivity period. Please, contact support department at <a href='mailto:support@forexmart.com'>support@forexmart.com</a> if you want to restore the account";
                                                                    }

                                                                    $('#' + client_input).closest('div.col-md-12').next('div.reqs').html('<p class="field-req">' + errorMsg + '.</p>');
                                                                }


                                                                if ($('#c_fm_bonus').val() != 'none') {

                                                                    if (x.isPro && $('#c_fm_bonus').val() == 'twpb') {
                                                                        $('.bonus_err').html('<p class="field-req">Your Receiver account is not allowed to be credited with 20% bonus.</p>');
                                                                    }

                                                                    if (x.isNewAccountType && $('#c_fm_bonus').val() == 'tpb') { // for New account > no 30% bonus but can be credited with 20% bonus
                                                                        $('.bonus_err').html('<p class="field-req">Your Receiver account is not allowed to be credited with 30% bonus.</p>');

                                                                    } else {
                                                                        if (!x.isNewAccountType) {
                                                                            if (x.bonus_selection == 'tpb' && $('#c_fm_bonus').val() == 'twpb') { //Old account credited 30% bonus but can be combined with 20% bonus.
                                                                                //allow
                                                                            } else {

                                                                                if (x.bonus_selection != 'nobonus') {
                                                                                    if ($('#c_fm_bonus').val() == 'tpb' && x.bonus_selection != 'tpb') {
                                                                                        $('.bonus_err').html('<p class="field-req">This account was already credited with other bonus type.To apply for this bonus, please open a new account.</p>');
                                                                                    } else if ($('#c_fm_bonus').val() == 'fpb' && x.bonus_selection != 'fpb') {
                                                                                        $('.bonus_err').html('<p class="field-req">This account was already credited with other bonus type.To apply for this bonus, please open a new account.</p>');
                                                                                    } else if ($('#c_fm_bonus').val() == 'twpb' && x.bonus_selection != 'twpb') {
                                                                                        $('.bonus_err').html('<p class="field-req">This account was already credited with other bonus type.To apply for this bonus, please open a new account.</p>');
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }

                                                                }



                                                               if(isSpecailTransitTransferPartner)
                                                               {


                                                                    if(!x.specailTransitAllow)
                                                                    {

                                                                        if (!x.isStandard) {
                                                                            if ($('#c_fm_bonus').val() == 'fpb') {
                                                                                $('.bonus_err').html('<p class="field-req"><?= lang('its_75') ?></p>');
                                                                            }
                                                                        }
                                                                    }


                                                                }else{

                                                                    if (!x.isStandard) {
                                                                            if ($('#c_fm_bonus').val() == 'fpb') {
                                                                                $('.bonus_err').html('<p class="field-req"><?= lang('its_75') ?></p>');
                                                                            }
                                                                        }

                                                                }


                                                                if (!$('#transit-form p.field-req').length) {
                                                                    $('#transit_account_number').html(acct_num.getAttribute('data-accountnumber'));
                                                                    $('#p_amount_transfer').html($('#amount_transfer').val());
                                                                    $('#p_tbl_wallet').html($('#p_wallet').val());

                                                                    $('#c_tbl_wallet').html($('#c_wallet').val());
                                                                    $('#c_tbl_acc_num').html(client_num);

                                                                    if ($('#c_fm_bonus').val() == 'none') {
                                                                        var bonustype = '<?= lang('it_s76') ?>';
                                                                    } else if ($('#c_fm_bonus').val() == 'tpb') {
                                                                        var bonustype = '<?= lang('its_77') ?>';
                                                                    } else if ($('#c_fm_bonus').val() == 'fpb') {
                                                                        var bonustype = '<?= lang('its_78') ?>';
                                                                    } else if ($('#c_fm_bonus').val() == 'twpb') {
                                                                        var bonustype = '20 PERCENT BONUS';
                                                                    }
        //                                                            var bonustype = ($('#c_fm_bonus').val()) == 'none' ? '<?//= lang('it_s76') ?>//'
        //                                                                : $('#c_fm_bonus').val() == 'tpb' ? '<?//= lang('its_77') ?>//'
        //                                                                    : '<?//= lang('its_78') ?>//';

                                                                    $('#c_tbl_bonustype').html(bonustype);
                                                                    $('#c_tbl_rcvs_name').html(x.full_name);

                                                                    $('#bt-tab5').hide();
                                                                    $('#bt-tab6').show();
                                                                }
                                                            }
                                                        });
                                                    }
                                                }
                                            }
                                        }
     
                            }
                          }
                        }
                    }
                }
            });
        });




function removeFiftyPer(optionValue='fpb'){
     $("#c_fm_bonus option[value='"+optionValue+"']").remove();
}


function getPartnerAffiliateInfo(v_account_number)
{
    $.ajax({
           type:       'post',
           url:        url + 'partnership/getAffiliateInfo',
           dataType:   'json',
           data:       { value: v_account_number },
           beforeSend: function() {
               $('.small-loader').show();
           },
           success: function (x) {
               $('.small-loader').hide();
               $('#c_full_name').show();
               $('#c_full_name').val(x.full_name);
               
               if(x.specailTransitAllow)
               {
                   
                   if(isSpecailTransitTransferPartner)
                   {
                   

                        optionText = '50%';
                        optionValue = 'fpb';  

                       removeFiftyPer(optionValue);

                        $('#c_fm_bonus').append($('<option>').val(optionValue).text(optionText));

                        transitAllowVar.account_number=v_account_number;
                        transitAllowVar.status=true;
                        console.log(transitAllowVar);
                } 

               }
           }
       });
    
}


function checkFiftyPercentAllow(c_fm_bonus){
    
    if(c_fm_bonus=="fpb")
    {
        if(isSpecailTransitTransferPartner)
        {
            return true;
        }else{
            return false;
        }    
        
    }else{
        return true;
    }     
      
    
}

 


    function roundtoTwo( value ){
        return +(Math.round(value + "e+2") + "e-2");
    }


    function checkSecurityCode(){
        var url = '<?= base_url(); ?>';
        if ($('#req_client').val() === 'Other') {
            client_num = $('#req_client_input').val();
        } else {
            client_num = $('#req_client').val();
        }
        return  $.ajax({
            type:       'POST',
            url:        url + 'withdraw/checkSecurityCode',
            dataType:   'json',
            data:       { sec_code: $('#security_code').val(), client_account_num: client_num },
            success: function (data) {
            }
        });

    }


    function checkSecurityCodeAfterSubmit(){
        var url = '<?= base_url(); ?>';
        if ($('#req_client').val() === 'Other') {
            client_num = $('#req_client_input').val();
        } else {
            client_num = $('#req_client').val();
        }
        return  $.ajax({
            type:       'POST',
            url:        url + 'withdraw/checkSecurityCodeAfterSubmit',
            dataType:   'json',
            data:       { sec_code: $('#security_code').val(), client_account_num: client_num },
            success: function (data) {
            }
        });

    }
    
    

</script>