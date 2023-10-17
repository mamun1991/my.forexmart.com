
<div class="inpay-main-holder" xmlns="http://www.w3.org/1999/html">
<div class="container-fluid order-block cancel-payment">
    <div class="container">
        <p><a id="link-cancel" href="javascript:void(0)">Click here to cancel your order</a></p>
    </div>
</div>
<div class="container fullheight">
    <div class="col-md-8 col-sm-8 payment-title">
        <h2>Make your Payment to <b>forexmart.com</b></h2>
        <br>
        <hr class="style-two">
        <h5>You have chosen to pay with your online bank account</h5>
        <hr class="style-one">
        <br>
    </div>
    <div class="col-md-4 col-sm-4 id-reg">
        <table class="table table-striped">
            <tbody>
            <tr>
                <td><b>Order#:</b></td>
                <td><?= $order_id; ?></td>
            </tr>
            <tr>
                <td><b>Product:</b></td>
                <td><?= $desc; ?></td>
            </tr>
            <tr>
                <td><b>Order Total: </b><a href="#"><span class="fa fa-info-circle green conv_invoice_amount " tool-tip-toggle="tooltip-info" data-original-title="Original invoice amount is <?= $amount . ' ' . $mt_currency ?>"></span></a></td>
                <td><span id="total-conv-amount"><?= $amount . ' ' . $mt_currency ?></span></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="col-md-12 option">
        <div class="setup-panel">
            <div class= "col-sm-4">
                <a href="#step-1" type="button" class="btn btn-step-on"><p><i class="fa fa-check"></i> 1. Select your bank</p></a>
            </div>
            <div class=" col-sm-4">
                <a href="#step-2" type="button" class="btn btn-step-off" disabled="disabled"><p><i class="fa fa-check"></i> 2. Send your payment</p></a>
            </div>
            <div class="col-sm-4">
                <a href="#step-3" type="button" class="btn btn-step-off" disabled="disabled"><p><i class="fa fa-check"></i> 3. Payment receipt</p></a>
            </div>
        </div>
    </div>


    <form class="form-horizontal" id ="frmDepositInpay"  name="frmDepositInpay" action="" method="post">

        <div class="setup-content" id="step-1">

            <div class="col-md-12">

                <div class="loc-text">
                    <div class="alert alert-danger" role="alert" id="create-inv-alert" style="display: none">
                        <span id = "create-inv-msg"></span>
                    </div>
                    <p>Choose the location and name of the bank where your account is held.</p>
                </div>
                <input type="hidden" name = "order_id" value="<?=$order_id?>">
                <input type="hidden" name = "mt_currency" value="<?=$mt_currency?>">
                <input type="hidden" name = "amount" value="<?=$amount?>">
                <div class="col-sm-12 form-reg">

                    <div class="col-sm-6 ">
                        <sup class="note-at-top">Your Country</sup>

                        <select class="form-control" id="payer_country" name="payer_country">
                            <?= $country_option ?>
                        </select>
                    </div>

                    <div class="col-sm-6">
                        <sup class="note-at-top">Your Bank</sup>
                        <select class="form-control" id="bank_name" name="bank_name">
                            <?= $bank_option ?>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-12">
                        <button class="btn btn-success nextBtn pull-right" type="button">Next</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="setup-content" id="step-2">

            <div class="col-sm-12 form-reg">
                <div class="col-sm-9">
                    <p>Open your online bank page in new window and pay using these details to make a domestic payment.</p>
                </div>
                <?php if(IPLoc::Office()){ ?>
                <div class="col-sm-3">
                    <button class="btn btn-success pull-right" id = "open-bank"  data-toggle="modal" data-target="#transfer-modal" type="button">Open your online bank</button>
                </div>
                <?php } ?>
                <br><br>
            </div>
            <div class="col-sm-6" id="box-bank-alert" style="display:none">
                <div class="alert alert-success" role="alert">
                   <span id = "bank-transfer-success"></span>
                </div>
            </div>

            <div class="col-sm-12 form-reg">
                <div class="form-group">
                    <label class="control-label col-sm-3 col-xs-12" for="payment_ref">Payment reference </label>
                    <div class="col-sm-6 col-sm-3-offset col-xs-12">
                        <input maxlength="32" type="text" class="form-control" id="payment_ref" name="payment_ref" disabled>
                        <sub class="note-at-top">Enter this unique reference in the message to the receiver for tracking purposes.</sub>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3 col-xs-12" for="currency">Currency </label>
                    <div class="col-sm-6 col-sm-3-offset col-xs-12">
                        <input maxlength="32" type="text" class="form-control" id="bank_currency" name="bank_currency" disabled>
                        <sub class="note-at-top">Make sure you're paying with this currency.</sub>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3 col-xs-12" for="amount">Amount </label>
                    <div class="col-sm-6 col-sm-3-offset col-xs-12">
                        <input maxlength="32" type="text" class="form-control" id="conv_amount" name="conv_amount" disabled>
                        <sub class="note-at-top">Transfer the exact amount shown.</sub>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3 col-xs-12" for="payee_address">Payee address </label>
                    <div class="col-sm-6 col-sm-3-offset col-xs-12">
                        <div class="grey" id="payee_address" contenteditable="false"></div>
                        <sub class="note-at-top">This is the full name and address oy your payee.</sub>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3 col-xs-12" for="payee_bank">Payee bank </label>
                    <div class="col-sm-6 col-sm-3-offset col-xs-12">
                        <div class="grey" id="payee_bank" contenteditable="false"></div>
                        <sub class="note-at-top">This is the local bank in the payees country.</sub>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3 col-xs-12" for="account">Account no.</label>
                    <div class="col-sm-6 col-sm-3-offset col-xs-12">
                        <input maxlength="32" type="text" class="form-control" id="bank_account_number" name="bank_account_number" disabled>
                    </div>
                </div>

                <div class="form-group non-sepa">
                    <label class="control-label col-sm-3 col-xs-12" for="swift">IBAN</label>
                    <div class="col-sm-6 col-sm-3-offset  col-xs-12">
                        <input maxlength="32" type="text" class="form-control" id="iban" name = "iban" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3 col-xs-12" for="swift">SWIFT/BIC</label>
                    <div class="col-sm-6 col-sm-3-offset  col-xs-12">
                        <input maxlength="32" type="text" class="form-control" id = "swift-bic" name = "swift-bic" disabled>
                    </div>
                </div>

                <br>
                <hr class="style-one">
            </div>

            <hr>

            <div class="col-sm-12 next-step">
                <p class="text-right">Confirm that your payment has been sent and get your receipt.</p>
                <button class="btn btn-success nextBtn pull-right" type="button">Confirm my payment</button>
            </div>

        </div>

        <div class="setup-content" id="step-3">
            <div class="col-sm-12 form-reg" id="inpay-message">

                <div class="col-sm-4 col-xs-12 text-right payment-text center"><i class="fa fa-5x fa-check-circle"></i></div>
                <div class="col-sm-8 col-xs-12 payment-text"><h4><span id="header-message"></span></h4></div>
                <div class="col-sm-12 text-center" id="main-message">
                    <div class="form-group form-success inpay-success" style="display: none;">
                        <label for="ReceivedAmount" class="col-sm-6 control-label">Received Amount:</label>
                        <div class="col-sm-3">
                            <p class="frm-val" id="txtAmountReceive"></p>
                        </div>
                        <label for="ReceivedCurrency" class="col-sm-6 control-label">Received Currency:</label>
                        <div class="col-sm-3">
                            <p class="frm-val" id="txtCurrencyReceive"></p>
                        </div>
                        <label for="Feference" class="col-sm-6 control-label">Reference:</label>
                        <div class="col-sm-3">
                            <p class="frm-val" id="txtReference"></p>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-sm-12 next-step text-center">
                <button class="btn btn-success" onClick="redirect();" type="button">Return</button>
            </div>

        </div>
</div>

</div>

<div class="modal fade" id="transfer-modal" tabindex="-1" role="dialog" aria-labelledby="transfer-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transfer-modal-title">Inpay online test bank transfer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body mx-3">
                <div class="md-form mb-5">
                    <label class="control-label" for="trans_reference">Reference</label>
                    <input type="text" id="trans_reference" class="form-control" disabled>
                </div>
                <div class="md-form mb-5">
                    <label class="control-label" for="trans_currency">Currency</label>
                    <input type="text" id="trans_currency" class="form-control" disabled>
                </div>
                <div class="md-form mb-5">
                    <label class="control-label" for="trans_amount">Amount</label>
                    <input type="text" id="trans_amount" class="form-control" disabled>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onClick="testBankTransfer();">Transfer</button>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn'),
            allPrevBtn = $('.prevBtn'),
            cancelLink =  $('.cancel-payment');

        allWells.hide();
        cancelLink.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-step-on').addClass('btn-step-off');
                $item.addClass('btn-step-on');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });

        allPrevBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

            prevStepWizard.removeAttr('disabled').trigger('click');
        });

        allNextBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                curInputs = curStep.find("input[type='text'],input[type='url'], input[type='tel'], input[type='number'], input[type='email'], input[type='date']"),
                isValid = true;

            $(".form-group").removeClass("has-error");
            for(var i=0; i<curInputs.length; i++){
                if (!curInputs[i].validity.valid){
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }

            if(curStepBtn == 'step-1'){
                sendRequest(isValid);
            }

            if(curStepBtn == 'step-2'){
                confirmPayment(isValid);
            }

        });

        $('div.setup-panel div a.btn-step-on').trigger('click');

        $( "#link-cancel" ).click(function () {
            var ref = $('#payment_ref').val();
            var url  = "<?php echo FXPP::ajax_url();?>";
            window.location.href = url + 'deposit/inpay-cancel?ref=' + ref;
        });

        $( "#open-bank" ).click(function () {
            var payment_ref   =   jQuery('#trans_reference').val($('#payment_ref').val());
            var bank_currency =   jQuery('#trans_currency').val($('#bank_currency').val());
            var conv_amount   =   jQuery('#trans_amount').val($('#conv_amount').val());
        });

    });

    function sendRequest(valid){
        if(valid) {
            jQuery.ajax({
                type: "POST",
                url:  "<?= FXPP::ajax_url('deposit/ajaxGetRequest')?>",
                data: jQuery('#frmDepositInpay').serialize(),
                dataType: 'json',
                beforeSend: function () {
                   jQuery('#loader-holder').show();
                },
                success: function (x) {
                    jQuery('#loader-holder').hide();
                    if(x.invoice.http_code){
                        jQuery('#create-inv-msg').html(x.invoice.message);
                        jQuery('#create-inv-alert').show();
                    }else{
                        jQuery('#conv_amount').val(x.invoice.invoice.transfer_amount);
                        jQuery('#total-conv-amount').html(x.invoice.invoice.transfer_amount + ' ' + x.data.currency);
                        jQuery('#bank_account_number').val(x.data.account);
                        jQuery('#payee_bank').html(x.data.bank_address);
                        jQuery('#payee_address').html(x.data.owner_address);
                        jQuery('#bank_currency').val(x.data.currency);
                        jQuery('#swift-bic').val(x.data.swift);
                        if (x.data.iban) {
                            jQuery('#iban').val(x.data.iban);
                        } else {
                            jQuery('.non-sepa').hide();
                        }

                        jQuery('#payment_ref').val(x.invoice.invoice.reference);
                        jQuery('#loader-holder').hide();
                        jQuery('div.setup-panel div a[href="#step-1"]').attr('disabled', 'disabled');
                        jQuery('div.setup-panel div a[href="#step-1"]').parent().next().children("a").removeAttr('disabled').trigger('click');
                        jQuery('.cancel-payment').show();
                    }


                },
                error: function (xhr, ajaxOptions, thrownError) {
                    jQuery('#loader-holder').hide();

                    console.log(xhr.status);
                    console.log(thrownError);
                    return false;
                }
            });
        }
    }

    function confirmPayment(valid) {
       if(valid) {
           var ref = $('#payment_ref').val();
            jQuery.ajax({
                type: "POST",
                url: "<?= FXPP::ajax_url('deposit/comfirmInpaypayment')?>",
                data: 'payment_ref=' + ref,
                dataType: 'json',
                beforeSend: function () {
                    $('#loader-holder').show();
                },
                success: function (x) {
                    jQuery('#loader-holder').hide();
                    if(x.data.http_code){
                        jQuery('#bank-transfer-success').html(x.data.message);
                        jQuery('#box-bank-alert').show();
                    }else{
                        if(x.data.status == 'pending'){
                            jQuery('#header-message').html("We have not received your payment yet");
                            jQuery('#main-message').html("<p>Please check your email. We have sent you the payment instruction.</p>" +
                                "<p>We will fund your account once we received your payment.</p>");

                        }else if(x.data.status == 'approved'){
                            jQuery('#header-message').html("Your payment has been confirmed.");
                            jQuery('#txtAmountReceive').html(x.data.received_sum);
                            jQuery('#txtCurrencyReceive').html(x.data.received_currency);
                            jQuery('#txtReference').html( x.payment_ref);
                            jQuery('.inpay-success').show();
                            jQuery('.cancel-payment').hide();
                        }
                        jQuery('div.setup-panel div a[href="#step-2"]').attr('disabled', 'disabled');
                        jQuery('div.setup-panel div a[href="#step-2"]').parent().next().children("a").removeAttr('disabled').trigger('click');
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#loader-holder').hide();
                    console.log(xhr.status);
                    console.log(thrownError);

                }
            });
         }
    }


    function testBankTransfer() {
          var ref = jQuery('#payment_ref').val();
                jQuery.ajax({
                    type: "POST",
                    url: "<?= FXPP::ajax_url('deposit/inpayTestTransfer')?>",
                    data: 'payment_ref=' + ref,
                    dataType: 'json',
                    beforeSend: function () {
                        jQuery('#loader-holder').show();
                    },
                    success: function (x) {
                        jQuery('#transfer-modal').modal('hide');
                        console.log(x);
                        jQuery('#loader-holder').hide();
                        if(x.result){
                            jQuery('#bank-transfer-success').html('You have transferred ' +  jQuery('#conv_amount').val() + ' with the reference: ' + jQuery('#payment_ref').val() + '.' );
                            jQuery('#box-bank-alert').show();
                            jQuery('.cancel-payment').hide();
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        jQuery('#transfer-modal').modal('hide');
                        jQuery('#loader-holder').hide();
                        console.log(xhr.status);
                        console.log(thrownError);

                    }
                });
         }

        function redirect(){

            var url  = "<?php echo FXPP::ajax_url();?>";
            window.location.href = url + 'deposit/inpay-return';
        }

        $(document).ready(function(){
            $('[tool-tip-toggle="tooltip-info"]').tooltip({
                placement : 'right'
            });
        });

</script>
