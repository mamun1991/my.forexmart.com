<style>
    .alert-danger p{
        display: inline;
    }

    @media  screen and (min-width: 1138px)  {
        .cup-label-acc{
            padding-right: 0px !important;
        }
    }

    .balanceClass {
        width: 170px;
        float: left;
    }

    .balanceClass:lang(sa) {
        width: 170px;
        float: right;
    }

    .balanceClass:lang(pk) {
        width: 170px;
        float: right;
    }

    .balanceClass p {
        margin-bottom: 0px;
    }

    .balanceClass h3 {
         margin-top: 0px;
         float: left;
     }

    .balanceClass h3:lang(sa) {
        margin-top: 0px;
        float: right;
    }

    .balanceClass h3:lang(pk) {
        margin-top: 0px;
        float: right;
    }

    .receiveTitle {
        width: 572px;
        background: #eee;
        height: 100px;
    }

    .receiveTitle h3 {
        width: 300px;
        float: left;
        margin: 20px 0px 0px;
        line-height: 34px;
    }

    .receiveTitle h3:lang(sa){
        float: right;
        text-align: right;
    }

    .receiveTitle h3:lang(pk){
        float: right;
        text-align: right;
    }

    .btn-withdraw-option {
        margin-top: 35px;
    }

    .btn-withdraw-option:lang(pk) {
        margin-left: 10px;
    }

    .btn-withdraw-option:lang(sa) {
        margin-left: 10px;
    }

    .withdrawOption {
        float: right;
    }

    .withdrawOption:lang(pk) {
        float: left;
    }

    .withdrawOption:lang(sa) {
        float: left;
    }

    .gla {
        float: none;
        font-size: 16px;
        margin: 6px 5px 0px 5px;
    }

    .balanceMar {
        margin-bottom: 40px;
    }

    .warningImage {
        float: left;
    }

    .warningText {
        float: left;
        margin-left: 10px;
        color: #BC8B00;
        font-size: 16px;
        line-height: 25px;
    }

    .form-horizontal .control-label {
        text-align: left !important;
    }

    .form-horizontal:lang(sa){
        text-align: right !important;
    }
    .form-horizontal:lang(pk){
        text-align: right !important;
    }

    .control-label:lang(pk){
        text-align: right !important;
    }

    .control-label:lang(sa){
        text-align: right !important;
    }

    .cautious:lang(sa){
        float: right;
    }

    .cautious:lang(pk){
        float: right;
    }

    .apiError {
        float: left;
        color: #BC8B00;
        font-size: 16px;
        width: 100%;
    }

    .apiError:lang(sa) {
        float: left;
        color: #BC8B00;
        font-size: 16px;
        width: 100%;
    }

    .apiError:lang(pk) {
        float: left;
        color: #BC8B00;
        font-size: 16px;
        width: 100%;
    }

</style>
<?php
$disabled = $disable_input ? '' : ' disabled="disabled"';
if(IPLoc::Office()){
//    print_r($cup_details);

    $currency = array(
            'USD'  =>  'glyphicon-usd',
            'EUR'  =>  'glyphicon-euro',
            'GBP'  =>  'glyphicon-gbp',
            'RUB'  =>  'glyphicon-ruble',
    );

    $showCur = $currency[$getCurrency];

    if(!$showCur){
        $showCur = 'glyphicon-usd';
    }

}
?>
<?php $this->load->view('finance_nav.php');?>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="tab1">
        <div class="banktrans-option" id="bt">
            <div class="row tab-content">
                <div class="col-md-11 col-centered tab-pane active" id="bt-tab1">
                    <h4 class="with-title">Withdraw via local bank transfer in IDR <?php //echo lang('chinapay-opt-01') ?></h4>
                    <?php
                        if(IPLoc::Office()){
                            ?>
                            <div class="col-sm-12 balanceMar">
                                <div class="balanceClass">
                                    <p>Balance</p>
                                    <h3 class="totalBalance"><?= $getTotalRealFund?></h3><span class="glyphicon <?= $showCur?> gla" role="<?= $getCurrency; ?>" aria-hidden="true"></span>
                                </div>
                                <div class="balanceClass">
                                    <p>Available</p>
                                    <h3 class="availBalance"><?= $getWithrawableRealFund?></h3><span class="glyphicon  <?= $showCur?> gla" aria-hidden="true"></span>
                                </div>
                                <div class="balanceClass">
                                    <p>Bonuses</p>
                                    <h3 class="bonusBalance"><?= $getTotalBonusFund?></h3><span class="glyphicon  <?= $showCur?> gla" aria-hidden="true"></span>
                                </div>
                                <?php
                                    if($apiSystemError){
                                        if($apiSystemError2 === 'RET_TRANSFER_BLOCKED'){
                                            echo '<div class="apiError '.$apiSystemError2.'">Opps! You can not transfer balance from this account.</div>';
                                        } else {
                                            echo '<div class="apiError '.$apiSystemError2.'">Opps! System error. We are sorry for the inconvenience.</div>';
                                        }

                                    }
                                ?>

                            </div>
                            <?php
                        }
                    ?>
                    <?php echo form_open(base_url('/withdraw'), array('class' => 'form-horizontal reg-frm', 'id' => 'frmWithdrawIdr')) ?>
                    <?php if(!IPLoc::Office()){ ?>
                    <?php if(!$disable_input){ ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" role="alert"><?= lang('wbt_01') ?> <?php //echo lang('chinapay-opt-01') ?></div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div id="reqLabel" class="form-group">
                            <label class="col-sm-12 control-label contest-label req2"><span class="reqs1">*<?= lang('with-p-01') ?></span></label>
                        </div>
                    <?php } ?>

                    <div class="form-group" style="">
                        <label for="" class="col-sm-4 control-label contest-label"><?= lang('with-p-02') ?><span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <?php echo $getAllAccountNumber; ?>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <?php } else { ?>
                        <div class="form-group" style="display: none">
                            <label for="" class="col-sm-4 control-label contest-label"><?= lang('with-p-02') ?><span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <?php echo $getAllAccountNumber; ?>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="amountWithdraw" class="col-sm-4 cup-label-acc control-label contest-label"><?= lang('with-p-03') ?> <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="amount_withdraw" class="form-control round-0 numeric amountWithdraw disableButton" id="amountWithdraw" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3 amtWithdrawErr" id="amtWithdrawErr">

                        </div>

                    </div>

                    <div class="form-group">
                        <label for="fee" class="col-sm-4 cup-label-acc control-label contest-label"><?= lang('with-p-04') ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="tfee" class="form-control round-0 feeBalance" id="tfee" readonly>
                        </div>
                        <div class="col-sm-3"> <p class="fee-details"><?php echo $fee_details; ?></p></div>
                    </div>
                    <?php if(!IPLoc::Office()){ ?>
                    <div class="form-group">
                        <label for="new balance" class="col-sm-4 cup-label-acc control-label contest-label"><?= lang('with-p-004') ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="new_balance" class="form-control round-0" id="new_balance" readonly>
                        </div>
                    </div>
                    <?php } ?>




                    <div class="form-group">
                        <label for="yandex_wallet" class="col-sm-4 cup-label-acc control-label contest-label"> <?= lang('with_04') ?> <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bank_account_name" class="form-control round-0 disableButton" id="bank_account_name" placeholder="" value="<?php echo set_value('bank_account_name') ?>"<?php echo $disabled ?>>

                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="yandex_wallet" class="col-sm-4 cup-label-acc control-label contest-label"><?= lang('with_03') ?><span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bank_name" class="form-control round-0 disableButton" id="bank_name" placeholder="" value="<?php echo set_value('bank_name') ?>"<?php echo $disabled ?>>

                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="yandex_wallet" class="col-sm-4 cup-label-acc control-label contest-label"><?= lang('with_01') ?> <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="idr_account" class="form-control round-0 numeric disableButton" id="idr_account" placeholder="" value="<?php echo set_value('bank_account_number') ?>"<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="yandex_wallet" class="col-sm-4 cup-label-acc control-label contest-label"> <?= lang('with_02') ?>  <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bank_branch" class="form-control round-0 disableButton" id="bank_branch" placeholder="" value="<?php echo set_value('branch') ?>"<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="yandex_wallet" class="col-sm-4 cup-label-acc control-label contest-label">  <?= lang('with_06') ?> <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bank_province" class="form-control round-0 disableButton" id="bank_province" placeholder="" value="<?php echo set_value('province') ?>"<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="yandex_wallet" class="col-sm-4 cup-label-acc control-label contest-label">  <?= lang('with_05') ?> <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bank_city" class="form-control round-0 disableButton" id="bank_city" placeholder="" value="<?php echo set_value('city') ?>" <?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>



                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"></label>

                        <?php
                            if(IPLoc::Office()){
                                ?>
                                <div class="col-sm-5 receiveTitle">
                                    <h3>
                                        You will receive <br> <span class="glyphicon <?=$showCur?> gla" aria-hidden="true"></span><span class="amountReceive">0</span>
                                    </h3>
                                    <button id="btnIdrContinue" aria-controls="bt-tab2" role="tab" data-toggle="tab" disabled="disabled" class="btn-withdraw-option withdrawOption"<?php echo $disabled ?> > Confirm </button>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="col-sm-5">
                                    <a id="btnIdrContinue" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?> > <?= lang('with-p-05') ?> </a>
                                </div>
                                <?php
                            }
                        ?>


                    </div>
                    <div class="form-group">
                        <div class="cautious">
                            <img alt="warning" class="warningImage" src="<?= $this->template->Images()?>warning_yellow.png"/>
                            <p class="warningText">Please fill all fields</p>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab2">
                    <h4 class="with-title"> Withdraw via local bank transfer in IDR <?php //echo  lang('chinapay-opt-01') ?> </h4>
                    <form class="form-horizontal reg-frm">
                        <div class="alert alert-info" role-alert>
                            <i class="fa fa-info-circle"></i> You are about to withdraw funds to your local bank transfer IDR. This will be processed within 48 hours. Please make sure the information below is correct and complete. <?php //echo  lang('chinapay-opt-03') ?>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?= lang('with-p-06') ?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAccountNumber"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?= lang('with-p-07') ?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountWithdraw"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?= lang('with-p-08') ?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountDeducted"></p>
                            </div>
                        </div>




                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">  <?= lang('with_04') ?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBankAccountName"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"> <?= lang('with_03') ?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBankName"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">  <?= lang('with_01') ?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtIdrAccount"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"> <?= lang('with_02') ?><span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBankBranch"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">  <?= lang('with_06') ?><span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBankProvince"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">   <?= lang('with_05') ?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBankCity"></p>
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"></label>
                            <div class="col-sm-6">
                                <a id="btnIdrBack" aria-controls="bt-tab1" role="tab" data-toggle="tab" class="btn-withdraw-option" style="margin-right: 10px;"> <?=lang('wn_12');?> </a>
                                <a id="btnIdrSendRequest" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option"> <?=lang('wn_13');?> </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab3">
                    <h4 class="with-title">Withdraw via local bank transfer in IDR  <?php //echo  lang('chinapay-opt-01') ?>  </h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b> <?= lang('with-p-09') ?>  </b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-success" role="alert">
                                        <i class="fa fa-check-circle"></i> <?= lang('with-p-10') ?>
                                    </div>
                                    <form class="form-horizontal form-success">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?= lang('with-p-11') ?></label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtIdrSuccessAmountRequested"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?= lang('with-p-12') ?></label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSuccessFee"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?= lang('with-p-13') ?></label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtIdrSuccessForexAccountNumber"></p>
                                            </div>
                                        </div>




                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"> <?= lang('with_04') ?> : </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtBankAccountNameSuccess"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"> <?= lang('with_03') ?> : </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtBankNameSuccess"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"> <?= lang('with_01') ?>: </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtIdraccSuccess"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"> <?= lang('with_02') ?> : </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtBankBranchSuccess"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"> <?= lang('with_06') ?> : </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtBankProvinceSuccess"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"> <?= lang('with_05') ?> : </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtBankCitySuccess"></p>
                                            </div>
                                        </div>



                                    </form>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/bank-transfer-idr')?>" class="create-another"><?= lang('with-p-16') ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab4">
                    <h4 class="with-title">   Withdraw via local bank transfer in IDR <?php // echo lang('chinapay-opt-01') ?> </h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b> <?= lang('with-p-166') ?></b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-danger" role="alert">
                                        <i class="fa fa-exclamation-circle"></i> <span id="customError"></span>
                                    </div>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/bank-transfer-idr')?>" class="create-another"> <?= lang('with-p-16') ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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


<?php if(IPLoc::Office()){ ?>
<script>
    var site_url = '<?php echo FXPP::ajax_url(); ?>';

    var totalB = $('.totalBalance').html();
    var availB = $('.availBalance').html();
    var bonusB = $('.bonusBalance').html();



    $(document).on('keyup', '.amountWithdraw', function (e) {
        var value = $(this).val();
        if(!$.isNumeric(value)){
            $(".amtWithdrawErr").html('You entered the wrong value');
            return false;
        }
        var withdB = $('.amountWithdraw').val();
        var feeB = $('.feeBalance').attr('access');

        var newTb = (parseFloat(totalB)-parseFloat(value)).toFixed(2);
        var newAb = (parseFloat(availB)-parseFloat(value)).toFixed(2);
        var newBb = (parseFloat(bonusB)-parseFloat(value)).toFixed(2);
        var newFb = (parseFloat(withdB)-parseFloat(feeB)).toFixed(2);

        if(value <= 0 ){
            $('.totalBalance').html(totalB);
            $('.availBalance').html(availB);

        } else {
            $('.totalBalance').html(newTb);
            $('.availBalance').html(newAb);
        }

        if(parseFloat(value) > parseFloat(availB)){
            $(".amtWithdrawErr").html('You entered more than the available amount');
            $('.totalBalance').html(totalB);
            $('.availBalance').html(availB);
            $('.amountReceive').html('0');
            //$('.btn-withdraw-option').attr('disabled', 'disabled');
        } else {
            $(".amtWithdrawErr").html('');
            if(value <= 0 ){
                $('.amountReceive').html('0');
                $('.feeBalance').val('0');
            } else {
                $(".amountReceive").html(newFb);
            }
            //$('.btn-withdraw-option').removeAttr('disabled');

        }

//        console.log(feeB+':: amount value ::'+newFb);
        //console.log(value+':: amount value ::'+feeB);$('input.muskField').attr('maxlength', 7);
    });

    $(document).on('keyup keypress', '.disableButton', function (e) {
        var aw = $("#amountWithdraw").val();
        var ba = $("#bank_account_name").val();
        var bn = $("#bank_name").val();
        var ia = $("#idr_account").val();
        var bb = $("#bank_branch").val();
        var bp = $("#bank_province").val();
        var bc = $("#bank_city").val();

        if(parseFloat(aw) > parseFloat(availB)){
            $('.btn-withdraw-option').attr('disabled', 'disabled');
            $('.btn-withdraw-option').css('background', '#DDDDDD');

            $('#amountWithdraw').attr('maxlength', aw.length);
        } else {

            $('#amountWithdraw').removeAttr('maxlength');

            //$('.btn-withdraw-option').removeAttr('disabled');
            if(aw.length > 0 && ba.length > 0 && bn.length > 0 && ia.length > 0 && bb.length > 0 && bp.length > 0 && bc.length > 0 ) {
                $('.btn-withdraw-option').css('background', '#29a643');
                $('.btn-withdraw-option').removeAttr('disabled');


                $('.cautious').hide();
            } else {
                $('.btn-withdraw-option').css('background', '#DDDDDD');
                $('.btn-withdraw-option').attr('disabled', 'disabled');


                $('.cautious').show();
            }
        }


        //console.log('press:: '+ aw.length);
    });




</script>
<?php } ?>
<script src="<?php echo base_url('assets/js/custom-withdraw.js')?>"></script>