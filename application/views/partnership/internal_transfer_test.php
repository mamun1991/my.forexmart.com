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
    <div role="tabpanel" class="tab-pane active" id="commission">
        <div class="row">
            <div class="col-sm-12">
                <p class="part-text"></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-centered">
                <?php if (!(empty($status))) {
                    if($status['status'] == 0){
                        echo "<div class='btn-login'>Internal transfer service request already sent.</div>";
                    } else if ($status['status'] == 1){ ?>
                        <div class="btn-login">
                            You're now granted with umbrella status. <br/>
                        </div>
                        <div class="options">
                            <div class="ref-info col-md-12">
                                <div class="col-md-offset-3 col-md-7" style="border-top: 1px solid #d4d4d4;">
                                    <div class="radio" style="margin-bottom: 15px; border-bottom: 1px solid #d4d4d4;">
                                        <label style="font-size: 15px;font-weight: bold;"><input type="radio" name="type" value="transit-transfer" checked> Send to Client</label>

                                        <?php if(IPLoc::Office()){?>
                                            <p class="col-md-offset-1" style="font-size:13px;">You are now registered to an Umbrella account and can now transfer to your affiliated Clients/Non Affiliate Clients </p>
                                        <?php }else{ ?>
                                            <p class="col-md-offset-1" style="font-size:13px;">You are now registered to an Umbrella account and can now transfer to your affiliated Clients </p>
                                        <?php } ?>
                                    </div>
                                    <div class="radio" style="border-bottom: 1px solid #d4d4d4;">
                                        <label style="font-size: 15px;font-weight: bold;"><input type="radio" name="type" value="partner-transfer"> Send to other Partner</label>
                                        <p class="col-md-offset-1" style="font-size:13px;">You can now transfer funds to other Partner</p>
                                    </div>
                                    <div class="radio" style="border-bottom: 1px solid #d4d4d4;">
                                        <label style="font-size: 15px;font-weight: bold;"><input type="radio" name="type" value="request"> Request from Client</label>
                                        <p class="col-md-offset-1" style="font-size:13px;">You can now request credit from client by transferring credit using Transit Transfer </p>
                                    </div>
                                    <span class="clearfix"></span>
                                    <button type="button" class="btn-withdraw-option pull-left" id="proceed_btn">Continue</button>
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

                            <div class="col-md-11 col-centered tab-pane" id="bt-tab5">
                                <h4 class="with-title">Transit Transfer</h4>

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
                                        <p class="control-label" style="text-align: left; margin-bottom: 15px;">Fill up the receiver's ForexMart Account information below:</p>
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <div class="col-md-12">
                                                <label class="control-label col-md-5">Receiver Account Number <span class="reqs1">*</span></label>
                                                <div class="col-md-5">
                                                    <select name="c_fm_account" class="form-control round-0 numeric" id="c_fm_account">
                                                        <option value="" data-wallet="">Select Account Number</option>
                                                        <?php foreach($referral_acc_num as $key => $value) { ?>
                                                            <option value="<?= $value['account_number'] ?>" data-wallet="<?= $value['c_wallet_number'] ?>"><?= $value['account_number'] ?></option>
                                                        <?php } ?>
                                                        <option value="Other" data-wallet="other">Other</option>
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
                                                    <input type="text" name="c_fm_account_input" class="numeric form-control round-0" id="c_fm_account_input" style="display: none;margin-top: 10px;" placeholder="Enter Account Number" />
                                                </div>
                                            </div>
                                            <div class="reqs col-md-offset-5 col-md-5"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label col-md-5">Amount <span class="reqs1">*</span></label>
                                            <div class="col-md-5">
                                                <input name="amount_transfer" type="text" class="form-control round-0 numeric" id="amount_transfer">
                                            </div>
                                        </div>
                                        <div class="reqs col-md-offset-5 col-md-5" style="margin-top: 0;"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label col-md-5">New Balance <span class="reqs1">*</span></label>
                                            <div class="col-md-5">
                                                <input name="transfer_nb" type="text" class="form-control round-0 numeric" id="transfer_nb" readonly>
                                            </div>
                                        </div>
                                        <div class="reqs col-md-offset-5 col-md-5"></div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label col-md-5">Bonus <span class="reqs1">*</span></label>
                                            <div class="col-md-5">
                                                <select name="c_fm_bonus" class="form-control round-0" id="c_fm_bonus">
                                                    <option value="none" selected>None</option>
                                                    <option value="tpb">30%</option>
                                                    <option value="fpb">50%</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="bonus_err reqs col-md-offset-5 col-md-5"></div>
                                    </div>


                                    <div class="form-group" id="btn-div">
                                        <label for="" class="col-sm-4 control-label contest-label"></label>
                                        <div class="col-md-5">
                                            <a id="btnBackTransit" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?>>Back</a>
                                            <a id="btnTransitSubmit" class="btn-withdraw-option">Submit</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-11 col-centered tab-pane" id="bt-tab6">
                                <h4 class="with-title">Transit Transfer</h4>
                                <div class="alert alert-info" role-alert>
                                    <i class="fa fa-info-circle"></i> You are about to transfer funds to client user using Transit Transfer. Please make sure the information below is correct.
                                </div>
                                <div class="well">
                                    <table class="table table-bordered" style="background: #fff;">
                                        <tr>
                                            <td class="col-md-5 td-hd">Your Account Number <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="transit_account_number"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-5 td-hd">Amount <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="p_amount_transfer"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-5 td-hd">Receiver Account Number <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="c_tbl_acc_num"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-5 td-hd">Bonus Type<span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="c_tbl_bonustype"></span></td>
                                        </tr>
<!--                                        <tr>-->
<!--                                            <td class="col-md-5 td-hd">Bonus Amount<span class="reqs1">*</span></td>-->
<!--                                            <td class="col-md-7"><span id="c_tbl_bonusamount"></span></td>-->
<!--                                        </tr>-->
                                    </table>
                                    <div style="text-align: center;">
                                        <a id="btnBackTransitForm" aria-controls="bt-tab5" role="tab" data-toggle="tab" class="btn-withdraw-option"><?=lang('wpay_13');?></a>
                                        <a id="btnPayCoTransitSendRequest" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option">Transfer</a>
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
                                                    <i class="fa fa-check-circle"></i> Your Transit Transfer is successful. Below are transaction details:
                                                </div>
                                                <form class="form-horizontal">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label">Amount transferred:</label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="resultAmountTransferred"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label">Receiver <?=lang('wpay_19');?>:</label>
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
                                <h4 class="with-title">Request From Client</h4>

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
                                                <label class="control-label col-md-5">Affiliate Account Number <span class="reqs1">*</span></label>
                                                <div class="col-md-5">
                                                    <select name="req_client" class="form-control round-0 numeric" id="req_client">
                                                        <option value="" data-wallet="">Select Account Number</option>
                                                        <?php foreach($referral_acc_num as $key => $value) { ?>
                                                            <option value="<?= $value['account_number'] ?>" data-wallet="<?= $value['c_wallet_number'] ?>"><?= $value['account_number'] ?></option>
                                                        <?php } ?>
                                                        <?php if(IPLOC::IPOnlyForMe()){ ?>
                                                            <option value="Other" data-wallet="other">Other</option>
                                                        <?php } ?>
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
                                                    <input type="text" name="req_client_input" class="numeric form-control round-0" id="req_client_input" style="display: none;margin-top: 10px;" placeholder="Enter Account Number" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label col-md-5">Amount <span class="reqs1">*</span></label>
                                                <div class="col-md-5">
                                                    <input name="requested_amount" type="text" class="form-control round-0 numeric" id="requested_amount">
                                                </div>
                                            </div>
                                            <div class="reqs col-md-offset-5 col-md-5"></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label col-md-5">Security Code <span class="reqs1">*</span></label>
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
                                            <a id="btnBackRequest" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?>>Back</a>
                                            <a id="btnRequestSubmit" class="btn-withdraw-option">Submit</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-11 col-centered tab-pane" id="bt-tab9">
                                <h4 class="with-title">Request From Client</h4>
                                <div class="alert alert-info client-sender-info" role-alert>
                                    <i class="fa fa-info-circle"></i> You are about to request funds from your Affiliate. Please make sure the information below are correct.
                                </div>
                                <div class="well">
                                    <table class="table table-bordered" style="background: #fff;">
                                        <tr>
                                            <td class="col-md-5 td-hd">Client Account Number <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="rfa_c_acc_num"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-5 td-hd">Amount <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="rfa_amount"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-5 td-hd">Security Code <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="rfa_code"></span></td>
                                        </tr>
                                    </table>
                                    <div style="text-align: center;">
                                        <a id="btnBackRequestForm" aria-controls="bt-tab5" role="tab" data-toggle="tab" class="btn-withdraw-option"><?=lang('wpay_13');?></a>
                                        <a id="btnRequestWithdrawSubmit" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option">Submit</a>
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
                                                    <i class="fa fa-check-circle"></i> Your request for funds through Transit Transfer is successful. Below are transaction details:
                                                </div>
                                                <form class="form-horizontal">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label">Affiliate <?=lang('wpay_19');?>:</label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="affAccNum"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label">Requested Amount:</label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="reqAmount"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label">Converted Amount:</label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="convAmount"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label">Security Code:</label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="secCode"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label">Reference Number:</label>
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
                                <h4 class="with-title">Partner Transit Transfer</h4>

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
                                        <p class="control-label" style="text-align: left; margin-bottom: 15px;">Fill up the partner's ForexMart Account information below:</p>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label col-md-5">Receiver Account Number <span class="reqs1">*</span></label>
                                                <div class="col-md-5">
                                                    <input type="text" name="partner-input" class="numeric form-control round-0" id="partner-input" placeholder="Enter Account Number" />
                                                </div>
                                                <div class="small-loader col-md-2 pull-right" style="display: none;">
                                                    <img src="<?= $this->template->Images()?>small-loader.gif">
                                                </div>
                                            </div>
                                            <div class="reqs col-md-offset-5 col-md-5"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label col-md-5">Amount <span class="reqs1">*</span></label>
                                            <div class="col-md-5">
                                                <input name="partner-amount" type="text" class="form-control round-0 numeric" id="partner-amount">
                                            </div>
                                        </div>
                                        <div class="reqs col-md-offset-5 col-md-5" style="margin-top: 0;"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label col-md-5">New Balance <span class="reqs1">*</span></label>
                                            <div class="col-md-5">
                                                <input name="partner-balance" type="text" class="form-control round-0 numeric" id="partner-balance" readonly>
                                            </div>
                                        </div>
                                        <div class="reqs col-md-offset-5 col-md-5"></div>
                                    </div>
                                    <div class="form-group" id="btn-div">
                                        <label for="" class="col-sm-4 control-label contest-label"></label>
                                        <div class="col-md-5">
                                            <a id="btnBackTransit" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?>>Back</a>
                                            <a id="btnPartnerSubmit" class="btn-withdraw-option">Submit</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-11 col-centered tab-pane" id="bt-tab12">
                                <h4 class="with-title">Partner Transit Transfer</h4>
                                <div class="alert alert-info" role-alert>
                                    <i class="fa fa-info-circle"></i> You are about to transfer funds to other partner user using Transit Transfer. Please make sure the information below is correct.
                                </div>
                                <div class="well">
                                    <table class="table table-bordered" style="background: #fff;">
                                        <tr>
                                            <td class="col-md-5 td-hd">Your Account Number <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="ptt_account_num"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-5 td-hd">Amount <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="ptt_amount_transfer"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-5 td-hd">Receiver Account Number <span class="reqs1">*</span></td>
                                            <td class="col-md-7"><span id="ptt_receiver"></span></td>
                                        </tr>
                                    </table>
                                    <div style="text-align: center;">
                                        <a id="btnBackPartnerForm" aria-controls="bt-tab5" role="tab" data-toggle="tab" class="btn-withdraw-option"><?=lang('wpay_13');?></a>
                                        <a id="btnPartnerTransfer" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option">Transfer</a>
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
                                                    <i class="fa fa-check-circle"></i> Your Partner Transit Transfer is successful. Below are transaction details:
                                                </div>
                                                <form class="form-horizontal">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label">Amount transferred:</label>
                                                        <div class="col-sm-6">
                                                            <p class="frm-val" id="ptt_result_amount"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 control-label">Receiver <?=lang('wpay_19');?>:</label>
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
                        <div class='btn-login'>Request for ITS is declined. Please check your email or contact <a href='#' style='color:#fff'>partnership@forexmart.com</a> for more details.</div>
                    <?php }
                } else { ?>
                    <button id="its" type="button" class="btn-login"> Request for ITS</button>
                    <div style="display: none" class='btn-login its_send'>Internal transfer service request already sent.</div>
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

                        <p class="manage-text"><b>Request for Internal transfer service(ITS)</b></p>
                        <div>
                            <div class="message"></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal-footer round-0">
                <button type="button" class="btn round-0" id="modal-close-btn" data-dismiss="modal" aria-label="Close">close</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalBonusAlert" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center bonus-alert-title"></h4>
            </div>
            <div class="modal-body modal-show-body">
                <div class="text-center bonus-alert-message"></div>
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
    var office = '<?=IPLoc::Office()?>';
    var modal_title = 'Registration';
    var modal_btn = 'Register';

    $(document).on("click",'#its',function(){
        $(".loader-holder").show();

        $.post("its_request",{},function(data){
            console.log(data);
            $("#its_model").modal('show');
            $(".its_send").show();
            $('#its').remove();
            $('.message').html(data.message);
            $(".loader-holder").hide();
        });
    });

    $(document).ready(function () {
        $('input.c_fm_bonus[type=checkbox]').on('change', function() {
            $(this).siblings('input[type="checkbox"]').prop('checked', false);
        });


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

            $('#c_full_name').hide();
            $(this).closest('div.col-md-12').next('div.reqs').html('');

            if (wallet === 'other') {
                c_fm_account_input.show();
                c_fm_account_input.focus();
                $('#c_fm_account').val('Other');
            } else {
                if ($(this).val().length) {
                    $.ajax({
                        type:       'post',
                        url:        url + 'partnership/getAffiliateInfo',
                        dataType:   'json',
                        data:       { value: $(this).val() },
                        beforeSend: function() {
                            $('.small-loader').show();
                        },
                        success: function (x) {
                            $('.small-loader').hide();
                            $('#c_full_name').show();
                            $('#c_full_name').val(x.full_name);
                        }
                    });
                }

                $('#c_fm_account_input').closest('div.col-md-12').next('div.reqs').html('');
                c_wallet.prop('readonly',true);
                c_wallet.val(wallet);
                c_wallet.attr('placeholder','');
                c_fm_account_input.hide();
            }
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
                var computeTotalBalance = walletBalance - parseFloat(amount);

                newBalance = computeTotalBalance > 0 ? computeTotalBalance : computeTotalBalance.toFixed(2);
                $(selectId).val(roundtoTwo(newBalance));
            }
        });

        $('#btnRequestSubmit').click(function () {

            $('#request-form :input').each(function(index, item) {
                var total_input = $('#request-form :input').length;

                if (!(item.name == 'r_full_name')) {
                    if (!$(this).val().length) {
                        $(this).closest('div.col-md-12').next('div.reqs').html('<p class="field-req">This field is required.</p>');
                    } else {
                        $(this).closest('div.col-md-12').next('div.reqs').html('');

                        if (total_input - 2 === index) {
                            if ($('#requested_amount').val() < 2) {
                                $('#requested_amount').closest('div.col-md-12').next('div.reqs').html('<p class="field-req">Amount should be greater or equal to 2.</p>');
                            } else if ($('#security_code').val().length < 6) {
                                $('#security_code').closest('div.col-md-12').next('div.reqs').html('<p class="field-req">Please enter valid Security Code format (6 digits).</p>');
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
                                                        $('.client-sender-info').html('You are about to request funds from Non-Affiliate Account. Please make sure the information below are correct.');
                                                    }

                                                    $('#rfa_amount').html($('#requested_amount').val() + ' ' + $('#accountNumber').data('currency'));
                                                    $('#rfa_code').html($('#security_code').val());

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

        $('#btnTransitSubmit').click(function () {
            var url = '<?= base_url(); ?>';
            $('#transit-form :input').each(function(index, item) {
                var total_input = $('#transit-form :input').length;
                if (!(item.name == 'transfer_nb') && !(item.name == 'c_full_name')) {

                    var client_num, client_input;
                    if ($('#c_fm_account').val() === 'Other') {
                        client_num = $('#c_fm_account_input').val();
                        client_input = 'c_fm_account_input';
                    } else {
                        client_num = $('#c_fm_account').val();
                        client_input = 'c_fm_account';
                    }

                    if (!$(this).val().length && item.name !== 'c_fm_account_input') {
                        $(this).closest('div.col-md-12').next('div.reqs').html('<p class="field-req">This field is required.</p>');
                    } else if (item.name === 'c_fm_account_input' && $('#c_fm_account').val() === 'Other' && !$('#c_fm_account_input').val().length) {
                        $(this).closest('div.col-md-12').next('div.reqs').html('<p class="field-req">This field is required.</p>');
                    } else {
                        $(this).closest('div.col-md-12').next('div.reqs').html('');
                        if (total_input - 3 === index) {
                            $('#c_wallet').closest('div.col-md-12').next('div.reqs').html('');
//
                            console.log(($('#transit-form p.field-req').length));

                            if(!$('#transit-form p.field-req').length){
                                var acct_num = $('#accountNumber')[0];
                                console.log(this.id);
                                if(this.id == 'amount_transfer'){
                                    if($(this).val().length){
                                        var walletBalance = parseFloat($('#accountNumber').data('balance'));
                                        var debitAmount = parseFloat($(this).val());
                                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                                        if (!result) {
                                            $('#amount_transfer').closest('div.col-md-12').next('div.reqs').html('<p class="field-req"> Insufficient fund.</p>');
                                        } else {
                                            if ($('#amount_transfer').val() < 2) {
                                                $('#amount_transfer').closest('div.col-md-12').next('div.reqs').html('<p class="field-req">Amount should be greater or equal to 2.</p>');
                                            } else {
                                                $.ajax({
                                                    type: 'POST',
                                                    url: url + 'withdraw/checkWalletAccNumAndResellerDataModifiedtest',
                                                    data: {
                                                        current_account_num: $('#accountNumber').data('accountnumber'),
                                                        client_account_num: client_num,
                                                        type: 0
                                                    },
                                                    dataType: 'json',
                                                    beforeSend: function () {
                                                        $('#loader-holder').show();
                                                    },
                                                    success: function (x) {
                                                        console.log(x);
                                                        console.log( $('#c_fm_bonus').val());
                                                        console.log(x.bonus_selection);
                                                        $('#loader-holder').hide();
                                                        if (x.return.error) {
                                                            $('#' + client_input).closest('div.col-md-12').next('div.reqs').html('<p class="field-req">' + x.return.error_message + '.</p>');
                                                        }
                                                        if ($('#c_fm_bonus').val() != 'none') {
                                                            if (x.bonus_selection != 'nobonus') {
                                                                if ($('#c_fm_bonus').val() == 'tpb' && x.bonus_selection != 'tpb') {
                                                                    $('.bonus_err').html('<p class="field-req">Bonuses cannot be mixed in one account.</p>');
                                                                }else if ($('#c_fm_bonus').val() == 'fpb' && x.bonus_selection != 'fpb') {
                                                                    $('.bonus_err').html('<p class="field-req">Bonuses cannot be mixed in one account.</p>');
                                                                    }
                                                                }
                                                            }

                                                        if (!x.isStandard) {
                                                            if ( $('#c_fm_bonus').val() == 'fpb') {
                                                                $('.bonus_err').html('<p class="field-req">Receiver client is not eligible to claim the 50% bonus. Applicable only for ForexMart Standard Account.</p>');
                                                            }
                                                        }
                                                        if (!$('#transit-form p.field-req').length) {
                                                            $('#transit_account_number').html(acct_num.getAttribute('data-accountnumber'));
                                                            $('#p_amount_transfer').html($('#amount_transfer').val());
                                                            $('#p_tbl_wallet').html($('#p_wallet').val());

                                                            $('#c_tbl_wallet').html($('#c_wallet').val());
                                                            $('#c_tbl_acc_num').html(client_num);


//                                                            if(x.isMicro){
//                                                                var amount_receive = $('#amount_transfer').val() * 100;
//                                                            }else{
//                                                                var amount_receive = $('#amount_transfer').val();
//                                                            }


                                                            var bonustype = ($('#c_fm_bonus').val()) == 'none' ? 'NONE'
                                                                : $('#c_fm_bonus').val() == 'tpb' ? '30 PERCENT BONUS'
                                                                    : '50 PERCENT BONUS';


//                                                            var bonusAmount = ($('#c_fm_bonus').val()) == 'none' ? parseFloat(0 * amount_receive )
//                                                                             : $('#c_fm_bonus').val() == 'tpb' ? parseFloat(30 * amount_receive)
//                                                                             : parseFloat(50 * amount_receive);
//                                                            console.log(bonusAmount);

                                                            $('#c_tbl_bonustype').html(bonustype);
//                                                            $('#c_tbl_bonusamount').html(parseFloat(bonusAmount.toFixed(2)));

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
            });
        });

        $('#btnPartnerSubmit').click(function () {
            var url = '<?= base_url(); ?>';
            $('#partner-transit-form :input').each(function(index, item) {
                var total_input = $('#partner-transit-form :input').length;
                if (!(item.name == 'partner-balance')) {

                    if (!$(this).val().length) {
                        $(this).closest('div.col-md-12').next('div.reqs').html('<p class="field-req">This field is required.</p>');
                    } else {
                        $(this).closest('div.col-md-12').next('div.reqs').html('');

                        if (total_input - 2 === index) {
                            if(!$('#partner-transit-form p.field-req').length){
                                var acct_num = $('#accountNumber')[0];

                                if(this.id == 'partner-amount'){
                                    if($(this).val().length){
                                        var walletBalance = parseFloat($('#accountNumber').data('balance'));
                                        var debitAmount = parseFloat($(this).val());
                                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;

                                        if (!result) {
                                            $('#partner-amount').closest('div.col-md-12').next('div.reqs').html('<p class="field-req"> Insufficient fund.</p>');
                                        } else {
                                            if ($('#partner-amount').val() < 2) {
                                                $('#partner-amount').closest('div.col-md-12').next('div.reqs').html('<p class="field-req">Amount should be greater or equal to 2.</p>');
                                            } else {
                                                $.ajax({
                                                    type: 'POST',
                                                    url: url + 'withdraw/checkWalletAccNumAndResellerDataModified',
                                                    data: {
                                                        current_account_num: $('#accountNumber').data('accountnumber'),
                                                        partner_account_num: $('#partner-input').val(),
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
                                                            $('#ptt_account_num').html(acct_num.getAttribute('data-accountnumber'));
                                                            $('#ptt_amount_transfer').html($('#partner-amount').val());
                                                            $('#ptt_receiver').html($('#partner-input').val());

                                                            $('#bt-tab11').hide();
                                                            $('#bt-tab12').show();
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
            });
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
            var url = '<?= base_url(); ?>';

            if (id == 60247) {
                $.ajax({
                    type:"POST",
                    url: url+"withdraw/WalletTransferModified",
                    data: $('#transit-form').serialize() + '&type=client',
                    dataType: 'json',
                    beforeSend: function(){
                        $('#loader-holder').show();
                    },
                    success: function(x){
                        $('#loader-holder').hide();
                        console.log(x);

                        if(x.success){
                            var transaction_id = x.result.transaction_id;

                            $('#resultAmountTransferred').html(x.data.converted_amount);
                            $('#resultClientFMAccNum').html(x.r_account);
                            $('#resultTransactionNumber').html(transaction_id);
                            $('#bt-tab6').hide();
                            $('#bt-tab7').show();
                        }else{
                            $('#customError').html(x.errorMsg);
                            $('#bt-tab6').hide();
                            $('#bt-tab4').show();
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('#loader-holder').hide();
                        $('[id^="bt-tab"]').removeClass('active');
                        $('#bt-tab4').addClass('active');
                        $('#customError').html('Transit transfer failed. Please try again or contact us for more information.');
                        console.log(xhr.status);
                        console.log(thrownError);
                    }
                });
            } else {
                $.ajax({
                    type:"POST",
                    url: url+"withdraw/WalletTransferModified_backup",
                    data: $('#transit-form').serialize(),
                    dataType: 'json',
                    beforeSend: function(){
                        $('#loader-holder').show();
                    },
                    success: function(x){
                        $('#loader-holder').hide();

                        if (id == 60247) {
                            console.log(x);
                        }

                        if(x.success){
                            var transaction_id = x.result.transaction_id;

                            $('#resultAmountTransferred').html(x.data.converted_amount);
                            $('#resultClientFMAccNum').html(x.c_account);
                            $('#resultTransactionNumber').html(transaction_id);
                            $('#bt-tab6').hide();
                            $('#bt-tab7').show();
                        }else{
                            $('#customError').html(x.errorMsg);
                            $('#bt-tab6').hide();
                            $('#bt-tab4').show();
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('#loader-holder').hide();
                        $('[id^="bt-tab"]').removeClass('active');
                        $('#bt-tab4').addClass('active');
                        $('#customError').html('Transit transfer failed. Please try again or contact us for more information.');
                        console.log(xhr.status);
                        console.log(thrownError);
                    }
                });
            }
        });

        $('#btnRequestWithdrawSubmit').click(function(){
            var url = '<?= base_url(); ?>';

            $.ajax({
                type:"POST",
                url: url+"withdraw/RequestWalletTransferModified",
                data: $('#request-form').serialize(),
                dataType: 'json',
                beforeSend: function(){
                    $('#loader-holder').show();
                },
                success: function(x){
                    if (id == 60247) {
                        console.log(x);
                    }

                    $('#loader-holder').hide();
                    $('#bt-tab9').hide();

                    if (!x.data.is_success) {
                        $('#bt-tab4').show();
                        $('#customError').html(x.data.message);
                    } else {
                        $('#reqAmount').html(x.data.amount_transfer);
                        $('#convAmount').html(x.data.conv_amount);
                        $('#affAccNum').html(x.data.account_num);
                        $('#secCode').html(x.data.security_code);
                        $('#refNum').html(x.data.referral_id);
                        $('#bt-tab10').show();
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#loader-holder').hide();
                    $('#bt-tab9').hide();
                    $('#bt-tab4').show();
                    $('#customError').html('Transit Transfer request failed. Please try again or contact us for more information.');
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        });

        $('#btnPartnerTransfer').click(function(){
            var url = '<?= base_url(); ?>';

            $.ajax({
                type:"POST",
                url: url+"withdraw/WalletTransferModified",
                data: $('#partner-transit-form').serialize() + '&type=partner',
                dataType: 'json',
                beforeSend: function(){
                    $('#loader-holder').show();
                },
                success: function(x){
                    $('#loader-holder').hide();

                    if (id == 60247) {
                        console.log(x);
                    }

                    if(x.success){
                        var transaction_id = x.result.transaction_id;

                        $('#ptt_result_amount').html(x.data.converted_amount);
                        $('#ptt_result_account').html(x.r_account);
                        $('#ptt_result_tid').html(transaction_id);
                        $('#bt-tab12').hide();
                        $('#bt-tab13').show();
                    }else{
                        $('#customError').html(x.errorMsg);
                        $('#bt-tab4').show();
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#loader-holder').hide();
                    $('[id^="bt-tab"]').removeClass('active');
                    $('#bt-tab4').addClass('active');
                    $('#customError').html('Partner transit transfer failed. Please try again or contact us for more information.');
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        });
    });

    function roundtoTwo( value ){
        return +(Math.round(value + "e+2") + "e-2");
    }
</script>