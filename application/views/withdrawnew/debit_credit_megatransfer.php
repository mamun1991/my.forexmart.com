<script>
/** DEBIT CREDIT CARDS START */
jQuery('#btnDebitCreditContinue').click(function(){

    var total_input = jQuery('#frmWithdrawDebitCredit :input').length;

    jQuery('#frmWithdrawDebitCredit :input').each(function(index){

        if(!jQuery(this).val().length){
            jQuery(this).closest('div.form-group').children('div.reqs').html('<p class="field-req">This field is required.</p>');
        }else{
            jQuery(this).closest('div.form-group').children('div.reqs').html('');
        }

        if(!jQuery('#debitCreditExpiryMonth').val().trim().length || !jQuery('#debitCreditExpiryYear').val().length){
            jQuery('#debitCreditExpiryMonth').closest('div.form-group').children('div.reqs').html('<p class="field-req">This field is required.</p>');
        }else{
            jQuery('#debitCreditExpiryMonth').closest('div.form-group').children('div.reqs').html('');
        }

        var d = new Date(),

                n = d.getMonth()+1,

                y = d.getFullYear();



            if( parseInt(jQuery('#debitCreditExpiryYear').val())<=y){

                if(parseInt(jQuery('#debitCreditExpiryMonth').val())<=n ){                                  /* Card is already expired translation output here */
                    jQuery('#debitCreditExpiryMonth').closest('div.form-group').children('div.reqs').html('<p class="field-req"><?=lang("wdcc_32");?></p>');
                }else{
                    if(!jQuery('#debitCreditExpiryMonth').val().length || !jQuery('#debitCreditExpiryYear').val().length){
                        jQuery('#debitCreditExpiryMonth').closest('div.form-group').children('div.reqs').html('<p class="field-req">This field is required.</p>');
                    }else{
                        jQuery('#debitCreditExpiryMonth').closest('div.form-group').children('div.reqs').html('');
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

                if(!jQuery('#frmWithdrawDebitCredit p.field-req').length){


                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);

                    //jQuery('#frmWithdrawDebitCredit :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtCardNumber').html(jQuery('#debitCreditCardNumber').val());
                    jQuery('#txtCardName').html(jQuery('#debitCreditCardName').val());
                    jQuery('#txtCardExpiry').html(jQuery('#debitCreditExpiryMonth option[value="' + jQuery('#debitCreditExpiryMonth').val() + '"]').text() + ' ' + jQuery('#debitCreditExpiryYear').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
});
</script>