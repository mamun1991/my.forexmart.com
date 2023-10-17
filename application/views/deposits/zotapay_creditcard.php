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
    .btn-card {
    color: #fff;
    background: #29a643;
    border: none;
    float: right;
    padding: 3px 6px;
  }



    .icon-container {
        position: absolute;
        /*right: 10px;*/
        left: 150px;
        top: calc(50% - 10px);
    }
    .icon-loader{
        position: relative;
        height: 20px;
        width: 20px;
        display: inline-block;
        animation: around 5.4s infinite;
    }

    @keyframes around {
        0% {
            transform: rotate(0deg)
        }
        100% {
            transform: rotate(360deg)
        }
    }

    .icon-loader::after, .icon-loader::before {
        content: "";
        background: white;
        position: absolute;
        display: inline-block;
        width: 100%;
        height: 100%;
        border-width: 2px;
        border-color: #333 #333 transparent transparent;
        border-style: solid;
        border-radius: 20px;
        box-sizing: border-box;
        top: 0;
        left: 0;
        animation: around 0.7s ease-in-out infinite;
    }

    .icon-loader::after {
        animation: around 0.7s ease-in-out 0.1s infinite;
        background: transparent;
    }





</style>
<h1>
    Deposit Option - Mastercard
</h1>
<div class="row">
    <div class="col-lg-9 col-centered">


     <?php
       $deposit_amount=0;
       $from_card_number= ($field_value)?$field_value['from_card_number']:"";
        if($amount>0)
        {
            $deposit_amount=$amount;
            
        }else{
            $deposit_amount= ($field_value)?$field_value['amount']:1;
        
        }

     ?>



        <form id="zotapay_deposit_form" action="" method="post" class="form-horizontal subSkrill paymentmethodformsumit">

   

       
        <?php 
            $display = !empty($this->session->flashdata('zotapay_transaction')) ? $this->session->flashdata('zotapay_transaction') : $apiMsg;
            if(isset($display)){
                ?>
                <div class="form-group">
                    <div class="col-sm-10">
                        <div class="center alert <?= ($display == 'Transaction Successful.') ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                            <p> <?=$display?> </p>
                        </div>
                    </div>
                </div>

            <?php } ?>


            <?php if (IPLoc::IPOnlyForVenus()) { ?>

            <?php if(count($card_numbers) == 0){  $disabled = "disabled"; ?>

            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                You have created a request to replenish your account with a card. Your card is checked and it can take up to three days. Please expect an email notification.
            </div>

            <?php } ?>
            <?php } ?>

            <div class="form-group" style="text-align: center;">
                <img src="<?= $this->template->Images()?>mastercard.png" class="img-reponsive" width="250px"/>
            </div>
            <div class="form-group" style="text-align: center;">
                <div class="col-sm-12">
                    <?php $disabled = "";  if($error_msg){ $disabled = "disabled"; ?>
                        <div class="alert alert-danger" role="alert" style=" margin-left: 15%; margin-right: 15%;">  <?=$error_msg?> </div>
                    <?php }?>
                </div>
            </div>



            <div class="form-group">
                <label class="col-sm-4 control-label">
                   Account Number
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <?php echo $input_account_number; ?>
                </div>

            </div>
           
           
            <input type = "hidden" value="CC" name="payment_type">
     
           
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('s_03');?> <i class="fa fa-question-circle" aria-hidden="true" data-html="true" data-toggle="tooltip" data-placement="top" title="Limit per transaction:
VISA - 500 USD <br>
Mastercard - 5500 USD <br>
JCB - 1650 USD"> </i>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <div class="icon-container" style="display: none;">
                        <i class="icon-loader"></i>
                    </div>
                    <input type="number" id="from_amount"  name ="from_amount" min="0" step="any" value="<?=floatval($amount)?>" class="form-control round-0 numeric" placeholder="0.00" style="width: 45%">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"></label>
                <div class="col-sm-5">
                    <input name="amount" id="amount" type="text" class="form-control round-0" readonly style="width: 45%">
                    <span class="amount_error" style="color: red"> <?= form_error('amount') ?></span>
                </div>
            </div>

                <div class="form-group currency-input">
                <label class="col-sm-4 control-label">Currency<cite class="req">*</cite></label>
                <div class="col-sm-5">
               
                <select name="currency" id="currency" class="form-control round-0">
                    <option value="USD" selected>USD</option>
                    <option value="EUR">EUR</option>
                </select>
            
                    <span class="req">  <?php echo  form_error('currency')?> </span>
                </div>
            </div>
     

            
            <div class="form-group">
                <label class="col-sm-4 control-label">First Name<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input name="first_name" id="first_name" type="text"   class="char-only form-control round-0"  maxlength="30"  value="<?= $first_name?>" <?php echo $disabled ?>>
                    <span class="firstname_error" style="color: red"><?= form_error('first_name') ?> </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Last Name<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input name="last_name" id="last_name" type="text" class=" char-only form-control round-0" maxlength="30"  value="<?= $last_name?>"<?php echo $disabled ?>>
                    <span class="lastname_error" style="color: red"><?= form_error('last_name') ?> </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Phone Number<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input name="phone_number" id="phone_number" type="text" class="form-control round-0"  maxlength="16" value="<?= $phone_number?>" <?php echo $disabled ?>>
                    <span class="phonenumber_error" style="color: red"><?= form_error('phone_number') ?> </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Address<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input name="address" id="address" type="text" class="form-control round-0"  maxlength="90" value="<?= $address?>" <?php echo $disabled ?>>
                    <span class="address_error" style="color: red"> <?= form_error('address') ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">City<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input name="city" id="city" type="text" class="form-control round-0"  maxlength="30" value="<?= $city?>" <?php echo $disabled ?>>
                    <span class="city_error" style="color: red"><?= form_error('city') ?> </span>
                </div>
            </div>
            <?php if($hasState){ ?>
            <div class="form-group">
                <label class="col-sm-4 control-label">State Code<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <select class="form-control round-0" name="state">
                        <?= $state_option ?>
                    </select>
                    <span class="state_error" style="color: red"><?= form_error('state') ?> </span>
                </div>
            </div>
            <?php } ?>
            <div class="form-group">
                <label class="col-sm-4 control-label">Zip code<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input name="zip" id="zip" type="text"  class="form-control round-0" maxlength="10"  value="<?= $zip?>" <?php echo $disabled ?>>
                    <span class="zip_error" style="color: red"><?= form_error('zip') ?> </span>
                </div>
            </div>

           <?php  if (IPLoc::IPOnlyForVenus() || $_SERVER['REMOTE_ADDR'] == '95.217.153.171' || $this->session->userdata('account_number') == '58071244') {?>
            <div class="form-group">

            <label class="col-sm-4 control-label">
                Card number
                <cite class="req">*</cite></label>

            <div class="col-sm-5">                        

                <select   name="card_number" id="card_number" class="form-control round-0">


            <?php if(isset($_GET['cd']) && strlen($_GET['cd'])>5){  ?>
                    <option value="<?php echo FXPP::decode($_GET['cd']);?>"><?php $d = FXPP::decode($_GET['cd']); 
                        echo substr($d,0,4). str_repeat('*', strlen($d) - 10) . substr($d, -4);
                    ?></option> 
                <?php }else{  ?>
                    <option value="">Select card number</option>   
            

            <?php foreach($card_numbers as $d){?>   
                    <option <?=($from_card_number)?($from_card_number==$d)?'selected':'':''?> value="<?php echo $d?>"><?php echo substr($d,0,4). str_repeat('*', strlen($d) - 10) . substr($d, -4);?></option>
                <?php }?>
                <?php }?>
            </select>

                <div class="reqs ">
                <span class="CardFieldValSelect"> </span>
                </div>
                <div class="reqs "><?php echo form_error('card_number'); ?></div>

            </div>



            <?php if(isset($_GET['cd']) && strlen($_GET['cd'])>5){  ?>
            <div class="col-sm-3"><a class="btn-card" href="card-documents?p=zp">Use another card</a></div>
            <?php } else{?>
                <div class="col-sm-2"><a class="btn-card" href="card-documents?p=zp"> Add card</a></div>
            <?php } ?>
           



            </div>

           <?php  } ?>
        
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="submit" class="btn-submit "<?php echo $disabled ?>>
                        <?=lang('s_04');?>
                    </button>





                </div><div class="clearfix"></div>
            </div>
        </form>
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
<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i>
    <?=lang('s_05');?>
</h1>
<table class="notes-list" style="margin-bottom: 30px;">
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('s_06');?>
            </p>
        </td>
    </tr>
<!--    <tr class="cb">-->
<!--        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>-->
<!--        <td class="r_">-->
<!--            <p>-->
<!--                --><?//=lang('s_07');?>
<!--            </p>-->
<!--        </td>-->
<!--    </tr>-->
</table>




<script type="text/javascript">


    $(document).ready(function(){
        var wallet_id = '<?= strtoupper($wallet_id); ?>';
        
        exhange_currency();
        
        $('#zotapay_deposit_form').submit(function() {
            $('#loader-holder').show(); //show loader on submit
        });

        $(window).on('load', function () {
            $('#loader-holder').hide(); //hide loader on reload
        });


        $('#from_amount').bind('keyup input', function(){
            exhange_currency();
        });


        $('select#currency').on('change', function() {
            exhange_currency();
        });


        $(".char-only").keypress(function (e) {
            if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)){
                return true;
            }
            e.preventDefault();
            return false;
        });


        $("#phone_number").keypress(function (e) {
            // Allow: plus sign, backspace, delete, tab, escape, enter and .
            console.log(e.keyCode);
            if ($.inArray(e.keyCode, [43, 46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            /* if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
             e.preventDefault();
             }*/
            if(isNaN(String.fromCharCode(e.which))){
                e.preventDefault();
            }
        });

    });



    function exhange_currency() {
        var currencyFrom = '<?= $account['currency'] ?>',
            currencyTo =  $('#currency').val(),
            amountFrom = $('#from_amount').val(),
            convertedAmount = 0.00;

            if(currencyFrom == currencyTo){
                $('#amount').val(amountFrom);
                $('#to_amount').val(amountFrom);
            }else{

            $.ajax({
            type: "post",
            url: "/deposit/exchange_currency",
            data: 'amount='+amountFrom+'&currency_from='+currencyFrom+'&currency_to='+currencyTo,
            dataType: 'json',
            beforeSend: function(){
                $('.icon-container').show();
            },
            success: function(x) {
                $('.icon-container').hide();
                if(x.success){
                    convertedAmount = parseFloat(x.rate).toFixed(2);
                    $('#amount').val(convertedAmount);
                    $('#to_amount').val(convertedAmount);
                }else{
                    $('#amount').val(convertedAmount);
                    $('#to_amount').val(convertedAmount);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.icon-container').hide();
                console.log(xhr.status);
                console.log(thrownError);
            }
        });

        }


    }

    
</script>