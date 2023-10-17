<?php
$disabled = $disable_input ? '' : ' disabled="disabled"';
?>

<?php $this->load->view('finance_nav.php');?>
    <style>
        .alert-danger p{
            display: inline;
        }
        p.fee-details{
            padding-top: 2%;
        }
    </style>
    <div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="tab1">
    <div class="banktrans-option" id="bt">
    <div class="row tab-content">
    <div class="col-md-11 col-centered tab-pane active" id="bt-tab1">
        <h4 class="with-title"> Withdrawal Option - eMerchant </h4>
        <?php echo form_open(base_url('withdraw/addEmerchantPay'), array('class' => 'form-horizontal reg-frm', 'id' => 'frmWithdrawEmerchantpay')) ?>

        <?php if(!$disable_input){ ?>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="alert alert-danger" role="alert"> <?=lang('wdcc_01');?></div>
                </div>
            </div>
        <?php }else{ ?>
            <div id="reqLabel" class="form-group">
                <label class="col-sm-12 control-label contest-label req2"><span class="reqs1">*  <?=lang('wdcc_02');?></span></label>
            </div>
        <?php } ?>
        <div class="form-group">
            <label for="" class="col-sm-4 control-label contest-label"> <?=lang('wdcc_03');?>  <span class="reqs1">*</span></label>
            <div class="col-sm-5">
                <?php echo $getAllAccountNumber; ?>
            </div>
            <div class="reqs col-sm-3">
            </div>
        </div>

        <input type="hidden" name="amount_deducted" value="0">
        <div class="form-group">
            <label for="amountWithdraw" class="col-sm-4 control-label contest-label"> <?=lang('wdcc_04');?> <span class="reqs1">*</span></label>
            <div class="col-sm-5">
                <input type="text" name="amount_withdraw" class="form-control round-0 numeric" id="amountWithdraw" placeholder=""<?php echo $disabled ?>>

            </div>
            <div class="reqs col-sm-3" id="amtWithdrawErr">
            </div>
        </div>

        <div class="form-group">
            <label for="fee" class="col-sm-4 control-label contest-label">Fee</label>
            <div class="col-sm-5">
                <input type="text" name="tfee" class="form-control round-0" id="tfee" readonly>
            </div>
            <div class="col-sm-3"> <p class="fee-details"><?php echo $fee_details; ?></p></div>
        </div>
        <div class="form-group">
            <label for="new balance" class="col-sm-4 control-label contest-label"><?= lang('with-p-004');?></label>
            <div class="col-sm-5">
                <input type="text" name="new_balance" class="form-control round-0" id="new_balance" readonly>
            </div>
        </div>

        <div class="form-group">
            <label for="emerchantNumber" class="col-sm-4 control-label contest-label"> <?=lang('wdcc_05');?>  <span class="reqs1">*</span></label>
            <div class="col-sm-5">
                <input type="text" name="card_number" class="form-control round-0 numeric" id="emerchantNumber" placeholder=""<?php echo $disabled ?>>
            </div>
            <div class="reqs col-sm-3">
            </div>
        </div>
        <div class="form-group">
            <label for="emerchatName" class="col-sm-4 control-label contest-label"> <?=lang('wdcc_06');?> <span class="reqs1">*</span></label>
            <div class="col-sm-5">
                <input type="text" name="card_name" class="form-control round-0" id="emerchatName" placeholder=""<?php echo $disabled ?>>
            </div>
            <div class="reqs col-sm-3">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-4 control-label contest-label"> <?=lang('wdcc_07');?> <span class="reqs1">*</span></label>
            <div class="col-sm-5">
                <div class="row">
                    <div class="col-sm-6">
                        <select id="emerchatExpiryMonth" name="card_expiry_month" class="form-control round-0" >
                            <option value=""> <?=lang('wdcc_08');?> </option>
                            <?php
                            for ($m = 1; $m <= 12; $m++) {
                                $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                echo '<option value="' . $m . '">' . $month . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <select id="emerchatExpiryYear" name="card_expiry_year" class="form-control round-0" >
                            <option value=""> <?=lang('wdcc_09');?> </option>
                            <?php
                            $year = date('Y', strtotime(FXPP::getCurrentDateTime()));
                            for ($y = 0; $y <= 10; $y++) {
                                echo '<option value="' . ($year + $y) . '">' . ($year + $y) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="reqs col-sm-3">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-4 control-label contest-label"></label>
            <div class="col-sm-5">
                <a id="btnemerchatContinue" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?>>  <?=lang('wdcc_10');?></a>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
    <div class="col-md-11 col-centered tab-pane" id="bt-tab2">
        <h4 class="with-title"> Withdrawal Option - eMerchant</h4>
        <form class="form-horizontal reg-frm">
            <div class="alert alert-info" role-alert>
                <i class="fa fa-info-circle"></i>  You are about to withdraw funds to your eMerchant pay. This will take 2 to 4 business days. Please make sure the information below is correct and complete.
            </div>
            <div class="form-group">
                <label for="" class="col-sm-6 control-label contest-label"> <?=lang('wdcc_12');?> <span class="reqs1">*</span></label>
                <div class="col-sm-6">
                    <p class="bt-val" id="txtAccountNumber"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-6 control-label contest-label"> <?=lang('wdcc_13');?><span class="reqs1">*</span></label>
                <div class="col-sm-6">
                    <p class="bt-val" id="txtAmountWithdraw"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-6 control-label contest-label"> <?=lang('wdcc_14');?> <span class="reqs1">*</span></label>
                <div class="col-sm-6">
                    <p class="bt-val" id="txtAmountDeducted"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-6 control-label contest-label"> <?=lang('wdcc_15');?> <span class="reqs1">*</span></label>
                <div class="col-sm-6">
                    <p class="bt-val" id="txtCardNumber"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-6 control-label contest-label"> <?=lang('wdcc_16');?> <span class="reqs1">*</span></label>
                <div class="col-sm-6">
                    <p class="bt-val" id="txtCardName"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-6 control-label contest-label"> <?=lang('wdcc_17');?><span class="reqs1">*</span></label>
                <div class="col-sm-6">
                    <p class="bt-val" id="txtCardExpiry"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-6 control-label contest-label"></label>
                <div class="col-sm-6">
                    <a id="btnemerchatBack" aria-controls="bt-tab1" role="tab" data-toggle="tab" class="btn-withdraw-option"> <?=lang('wdcc_18');?></a>
                    <a id="btnemerchatSendRequest" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option"> <?=lang('wdcc_19');?></a>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-11 col-centered tab-pane" id="bt-tab3">
        <h4 class="with-title"> Withdrawal Option - eMerchant</h4>
        <div class="panel panel-default round-0">
            <div class="panel-heading">
                <b> <?=lang('wdcc_20');?></b>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8 col-centered">
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> <?=lang('wdcc_21');?>
                        </div>
                        <form class="form-horizontal form-success">
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label"> <?=lang('wdcc_22');?>:</label>
                                <div class="col-sm-6">
                                    <p class="frm-val" id="emerchantpaySuccessAmountRequested"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-6 control-label"> <?=lang('wdcc_23');?>:</label>
                                <div class="col-sm-6">
                                    <p class="frm-val" id="txtSuccessFee"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label"> <?=lang('wdcc_24');?>:</label>
                                <div class="col-sm-6">
                                    <p class="frm-val" id="emerchantpaySuccessAccountNumber"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label"> <?=lang('wdcc_25');?>:</label>
                                <div class="col-sm-6">
                                    <p class="frm-val" id="emerchantpaySuccessCardNumber"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label"> <?=lang('wdcc_26');?>:</label>
                                <div class="col-sm-6">
                                    <p class="frm-val" id="emerchantpaySuccessTransactionNumber"></p>
                                </div>
                            </div>
                        </form>
                        <div class="btn-create-another">
                            <a href="<?php echo base_url('withdraw/emerchantpay')?>" class="create-another"> <?=lang('wdcc_27');?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-11 col-centered tab-pane" id="bt-tab4">
        <h4 class="with-title"> Withdrawal Option - eMerchant</h4>
        <div class="panel panel-default round-0">
            <div class="panel-heading">
                <b> <?=lang('wdcc_28');?></b>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8 col-centered">
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i> <span id="customError"></span>
                        </div>
                        <div class="btn-create-another">
                            <a href="<?php echo base_url('withdraw/emerchantpay')?>" class="create-another"> <?=lang('wdcc_29');?></a>
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

 <script src="<?php echo base_url('assets/js/custom-withdraw.js')?>"></script>

<script>
    /** DEBIT CREDIT CARDS START */
    var fee = jQuery('#fee').val();
    var ndb_bonus = jQuery('#ndb_bonus').val();
    var add_on = jQuery('#add_on').val();

    jQuery('#btnemerchatContinue').click(function(){

        var total_input = jQuery('#frmWithdrawEmerchantpay :input').length;

        jQuery('#frmWithdrawEmerchantpay :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html('<p class="field-req">This field is required.</p>');
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(!jQuery('#emerchatExpiryMonth').val().trim().length || !jQuery('#emerchatExpiryMonth').val().length){
                jQuery('#emerchatExpiryMonth').closest('div.form-group').children('div.reqs').html('<p class="field-req">This field is required.</p>');
            }else{
                jQuery('#emerchatExpiryMonth').closest('div.form-group').children('div.reqs').html('');
            }

            var d = new Date(),

                n = d.getMonth()+1,

                y = d.getFullYear();



            if( parseInt(jQuery('#emerchatExpiryYear').val())<=y){

                if(parseInt(jQuery('#emerchatExpiryYear').val())<=n ){                                  /* Card is already expired translation output here */
                    jQuery('#emerchatExpiryYear').closest('div.form-group').children('div.reqs').html('<p class="field-req"><?=lang("wdcc_32");?></p>');
                }else{
                    if(!jQuery('#emerchatExpiryYear').val().length || !jQuery('#debitCreditExpiryYear').val().length){
                        jQuery('#emerchatExpiryYear').closest('div.form-group').children('div.reqs').html('<p class="field-req">This field is required.</p>');
                    }else{
                        jQuery('#emerchatExpiryYear').closest('div.form-group').children('div.reqs').html('');
                    }
                }

            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    // var debitAmount = parseFloat($(this).val());
                    var debitAmount = parseFloat($(this).val()) + parseFloat($("#tfee").val());
                    var result = (walletBalance >= debitAmount) ? true : false;
                    if(!result){
                        jQuery('#amtWithdrawErr').html('<p class="field-req"> Not enough funds.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){

                if(!jQuery('#frmWithdrawEmerchantpay p.field-req').length){


                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);

                    //jQuery('#frmWithdrawDebitCredit :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtCardNumber').html(jQuery('#emerchantNumber').val());
                    jQuery('#txtCardName').html(jQuery('#emerchatName').val());
                    jQuery('#txtCardExpiry').html(jQuery('#emerchatExpiryMonth option[value="' + jQuery('#emerchatExpiryMonth').val() + '"]').text() + ' ' + jQuery('#emerchatExpiryYear').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });


    jQuery('#btnemerchatBack').click(function(){
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnemerchatSendRequest').click(function(){
        jQuery('#frmWithdrawEmerchantpay :input').each(function(index){
            var total_input = jQuery('#frmWithdrawEmerchantpay :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html('<p class="field-req">This field is required.</p>');
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(!jQuery('#emerchatExpiryMonth').val().length || !jQuery('#emerchatExpiryYear').val().length){
                jQuery('#emerchatExpiryMonth').closest('div.form-group').children('div.reqs').html('<p class="field-req">This field is required.</p>');
            }else{
                jQuery('#emerchatExpiryMonth').closest('div.form-group').children('div.reqs').html('');
            }



            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawEmerchantpay p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addEmerchantPay",
                        data: jQuery('#frmWithdrawEmerchantpay').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#emerchantpaySuccessAmountRequested').html(amount_requested);
                                jQuery('#emerchantpaySuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#emerchantpaySuccessCardNumber').html(x.transaction_data.client_inf);
                                jQuery('#emerchantpaySuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            jQuery('#bt-tab4').addClass('active');
                            console.log(xhr.status);
                            console.log(thrownError);
                        }
                    });
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
    /** DEBIT CREDIT CARDS END */
    /** END E-merchant**/


</script>