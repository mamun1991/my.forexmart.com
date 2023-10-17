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
    p{ margin: 0px 0px !important;}


    .exchange-curr-container{
        display: flex;
        align-items: center;
        justify-content: flex-start;
        flex-direction: row;
    }

    .exchange-curr-container input,
    .exchange-curr-container select,
    .exchange-curr-container label {
        margin-right:5px;
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
    <?php switch($currency){
//        case 'KES': $bank = 'Deposit option - Mpesa';   $logo = 'payment_getway_logo/bank-kes-logo.png';     $width = "250px"; break;    //FXPP-13427


        case 'MXN': $bank = 'Deposit via local bank transfer in Mexico';  $logo = 'payment_getway_logo/bank-mxn-logo.png';     $width = "250px"; break;
        case 'BRL': $bank = 'Deposit via local bank transfer in Brazil';  $logo = 'payment_getway_logo/bank-brl-logo.png';     $width = "250px"; break;
        case 'NGN': $bank = 'Deposit via local bank transfer in Nigeria'; $logo = 'banktransfer.png';     $width = "200px"; break;
        case 'UGX': $bank = 'Deposit via local bank transfer in Uganda';  $logo = 'payment_getway_logo/bank-ugx-ghs-logo.png'; $width = "120px"; break;
        case 'GHS': $bank = 'Deposit via local bank transfer in Ghana';   $logo = 'payment_getway_logo/bank-ugx-ghs-logo.png'; $width = "120px"; break;

    } ?>
    <?= $bank; ?>
</h1>
<div class="row">
    <div class="col-lg-9 col-centered">
        <input type="hidden" id="base_url" value="<?php echo FXPP::ajax_url() ?>" />
        <form  action="" method="post" class="form-horizontal"  style="margin-top: 50px;" enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-sm-12 center">
                    <?php  if(validation_errors()){ ?>
                        <div class="alert alert-danger" role="alert" id="amountErrorVal"> <?php echo validation_errors();?></div>
                    <?php }?>
                </div>
            </div>

            <?php
            $disabled = "";
            if($error_msg){
                $disabled = "disabled";
                ?>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="alert alert-danger" role="alert">
                            <?=$error_msg?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php  $disabled = false;
            $display = $this->session->flashdata('cardpay_transaction');
            if(isset($display)){
                ?>
                <div class="form-group" style="">
                    <div class="col-sm-10">
                        <div class="alert alert-success center" role="alert">
                            <p> <?=$display?> </p>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <?php  $disabled = false;
            // $display = $this->session->flashdata('cardpay_transaction');
            if(!empty($msg)){

                ?>
                <div class="form-group" style="">
                    <div class="col-sm-10">
                        <div class="alert <?= ($status == 2) ?  'alert-success': 'alert-danger';?> center" role="alert">
                            <p> <?=$msg;?> </p>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <div class="form-group" style="text-align: center;">
                <img src="<?= $this->template->Images().$logo;?>" class="img-reponsive" style="" width="<?=$width?>"/>
            </div>

            <div class="form-group" style="text-align: center;">

            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    Account Currency

                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <?php echo $input_account_number; ?>
              </div>

            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label"><?=lang('ddcc_03');?> <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <div class="exchange-curr-container">
                        <input type="hidden" name="bounusfiled" id="bounusfiled"  class="form-control round-0"   value="<?=$bounusfiled?>" >
                        <input type="hidden" name="amount" id="amount"  value="<?=floatval($amount)?>">
                        <input type="number" name="from_amount" id="from_amount" min="0" step="any" value="<?=floatval($amount)?>" class="form-control round-0 numeric depositamountcheck" placeholder="0.00" style="width: 45%">
                        <span><?= $account_currency; ?></span>
                    </div>
                </div>

                <div class="reqs amount-err col-md-offset-5 col-md-5 errorlineshow" style="margin-top: 0;">

                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"></label>
                <div class="col-sm-5">
                    <div class="exchange-curr-container">
                        <div class="icon-container" style="display: none;">
                            <i class="icon-loader"></i>
                        </div>
                        <input type="number" name="to_amount" id="to_amount" min="0" step="any" value="" class="form-control round-0 numeric depositamountcheck" readonly="" style="width: 45%">
                        <span> <?= $currency; ?> </span>
                    </div>
                </div>
                <div class="reqs amount-err col-md-offset-5 col-md-5 errorlineshow" style="margin-top: 0;">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Payment Method<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <select required name="methods" class="form-control" id="methods"></select>
                      <div class="reqs errorlineshow">
                        <?php echo form_error('methods'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="submit" class="btn-submit" id="send2"<?php echo $disabled ?>>
                        <?=lang('ddcc_04');?>
                    </button>
                </div><div class="clearfix"></div>
            </div>



           <!-- <div class="form-group">

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

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="submit" class="btn-submit" id="send2"<?php //echo $disabled ?>>
                        <?//=lang('ddcc_04');?>
                    </button>
                </div><div class="clearfix"></div>
            </div>-->

        </form>

    </div>

</div>

<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i>
    <?=lang('ddcc_05');?>
</h1>
<table class="notes-list">
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('ddcc_06');?>
            </p>
        </td>
    </tr>
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('ddcc_07');?>
            </p>
        </td>
    </tr>
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('ddcc_08');?>
            </p>
        </td>
    </tr>
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('ddcc_09');?>
            </p>
        </td>
    </tr>
</table>

<script>
    var fromcurrency = '<?= $account_currency; ?>';
    var toCurrency = '<?= $currency; ?>';
    $(document).ready(function(){

        getPaymentMethod(toCurrency);
        exhange_currency();

        $('#from_amount').bind('keyup input', function(){
            exhange_currency();
        });
        

    });

    


    function getPaymentMethod(currency){

        $.ajax({
            type: 'POST',
            url: '/deposit/requestPaymentMethods',
            data: {currency: toCurrency},
            dataType: 'json',
            beforeSend: function () {
               
            },
            success: function (response) {
                $('#methods').html(response.option);
            }
        });
    }

    function exhange_currency() {
        var amountFrom = $('#from_amount').val(),
            convertedAmount = 0.00;


        $.ajax({
            type: "post",
            url: "/deposit/exchange_currency",
            data: 'amount='+amountFrom+'&currency_from='+fromcurrency+'&currency_to='+toCurrency,
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
    
    </script>




 

