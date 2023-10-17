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

 <?php if(FXPP::isMasterCard()){   
      
      $this->load->view('deposits/master_cards_inner_tab.php');
      echo "</br></br>";
  } ?>


 
     <?php   if(!FXPP::isMasterCard()){   ?>
<h1>
    Deposit Option - Zotapay
</h1>

     <?php } ?>

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



        <form id="zotapay_deposit_form" action="" method="post" class="form-horizontal subSkrill paymentmethodformsumit">

   

            <?php 
            $display = !empty($this->session->flashdata('zotapay_transaction')) ? $this->session->flashdata('zotapay_transaction') : $apiMsg;
            if(isset($display)){
                ?>
                <div class="form-group" style="">
                    <div class="col-sm-10">
                        <div class="center alert <?= ($display == 'Transaction Successful.') ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                            <p> <?=$display?> </p>
                        </div>
                    </div>
                </div>

            <?php } ?>


 <?php   if(!FXPP::isMasterCard()){   ?>
            <div class="form-group" style="text-align: center;">
                <?php 
                    if($_GET['wallet_id']=="idr")
                    {?>
                        <img src="<?= $this->template->Images()?>payment_getway_logo/idr-cards.png" class="img-reponsive" width="250px"/>
                    <?php }else{
                ?>
                <img src="<?= $this->template->Images()?>payment_getway_logo/zp-bank-myr.png" class="img-reponsive" width="250px"/>
                    <?php } ?>
            </div>
            
 <?php } ?>            
            
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
           
      
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('s_03');?>
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

                <div class="form-group">
                <label class="col-sm-4 control-label">Currency<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <?php if($wallet_id){ ?>
                        <input name="currency" id="currency" type="text" class="form-control round-0" readonly>
                    <?php }else{ ?>
                        <select name="currency" id="currency" class="form-control round-0">
                            <option value="MYR" <?=($account['currency']=='MYR')?'selected':''?> >MYR</option>
                            <option value="THB" <?=($account['currency']=='THB')?'selected':''?> >THB</option>
                            <option value="VND" <?=($account['currency']=='VND')?'selected':''?> >VND</option>
                            <option value="IDR" <?=($account['currency']=='IDR')?'selected':''?> >IDR</option>

                        </select>
                    <?php } ?>
                    <span class="req">  <?php echo  form_error('currency')?> </span>
                </div>
            </div>
           
            <div class="form-group bank-opt">
                <label class="col-sm-4 control-label">Banks<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <select required name="banks" class="form-control" id="banks"></select>
                    <div class="reqs">
                        <?php echo form_error('banks'); ?>
                    </div>
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
            <div class="form-group">
                <label class="col-sm-4 control-label">Zip code<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input name="zip" id="zip" type="text"  class="form-control round-0" maxlength="10"  value="<?= $zip?>" <?php echo $disabled ?>>
                    <span class="zip_error" style="color: red"><?= form_error('zip') ?> </span>
                </div>
            </div>
        
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
       
        if(wallet_id){
            $("#currency").val(wallet_id);
        }

        exhange_currency();
        getBanks();

     
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
            getBanks();
          
           
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

        console.log(currencyFrom);
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


    function getBanks(currency){

        $.ajax({
            type: 'POST',
            url: '/deposit/requestZPBanks',
            data: {currency: $('#currency').val()},
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (response) {
                $('#banks').html(response.option);
            }
        });
    }


</script>