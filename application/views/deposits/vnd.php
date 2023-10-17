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
    .form-error-msg{
        text-align: center;
        margin: 10px;
    }
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



<h1>Deposit via local bank transfer in VND</h1>

<div class="row">



    <form id = "china_union_payForm" class="form-horizontal" method="POST" style="margin-top: 50px;margin-left: 10%;margin-right: 20%;">
        <div class="form-group" style= "text-align: center;">
            <?php  if(validation_errors()){ ?>
                <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;" role="alert" id="amountErrorVal"> <?php echo validation_errors();?></div>
            <?php }?>
        </div>




        <div class="form-group" style="text-align: center;">
            <div class="col-sm-12">
                <?php $disabled = "";  if($error_msg){ $disabled = "disabled"; ?>
                    <div class="alert alert-danger" role="alert" style=" margin-left: 15%; margin-right: 15%;">  <?=$error_msg?> </div>
                <?php }?>
            </div>
        </div>


        <?php  //$disabled = false;
        $display = $this->session->flashdata('msg');
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

        <?php  //$disabled = false;
        // $display = $this->session->flashdata('cardpay_transaction');
        if(!empty($msg)){
            ?>
            <div class="form-group" style="">
                <div class="col-sm-10">
                    <div class="alert alert-danger center" role="alert">
                        <p> <?=$msg;?> </p>
                    </div>
                </div>
            </div>

        <?php } ?>


        <div class="form-group">

            <label class="col-sm-4 control-label">
                <?=lang('ddcc_03-1');?>
                <cite class="req">*</cite></label>

            <div class="col-sm-5">
                <input type="text" name="account_currency" id="account_currency" class="form-control round-0" value="<?php echo $account['currency'] . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'],2) . ']' ?>" placeholder="" disabled/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label"><?=lang('ddcc_03');?> <cite class="req">*</cite></label>


            <div class="col-sm-5">
                <div class="exchange-curr-container">
                    <input type="hidden" name="amount" id="amount"  value="<?=floatval($amount)?>">

                    <input type="number" name="from_amount" id="from_amount" min="0" step="any" value="<?=floatval($amount)?>" class="form-control round-0 numeric depositamountcheck" placeholder="0.00" style="width: 45%">
                    <span><?= $account['currency'] ?></span>
                </div>
            </div>

            <!-- <div class="col-sm-5">
                        <input   type="number"  name="amount" id="amount"    value="<?//=floatval($amount)?>"  class="form-control round-0 numeric depositamountcheck" placeholder="0.00"<?php //echo $disabled ?>/>
                    </div>-->

            <div class="reqs amount-err col-md-offset-5 col-md-5 errorlineshow" style="margin-top: 0;">
                <?php echo  form_error('deposit_vnd_amt_validation')?>
                <?php echo  form_error('amount_amt_validation')?>
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
                    <span> VND </span>
                </div>
            </div>

            <!-- <div class="col-sm-5">
                        <input   type="number"  name="amount" id="amount"    value="<?//=floatval($amount)?>"  class="form-control round-0 numeric depositamountcheck" placeholder="0.00"<?php //echo $disabled ?>/>
                    </div>-->

            <div class="reqs amount-err col-md-offset-5 col-md-5 errorlineshow" style="margin-top: 0;">
                <?php echo  form_error('deposit_vnd_amt_validation')?>
                <?php echo  form_error('amount_amt_validation')?>
            </div>
        </div>



        <div class="form-group">
            <label class="col-sm-4 control-label">
                Full name
                <cite class="req">*</cite></label>
            <div class="col-sm-5">
                <input type="text" name="first_name" id="first_name"  class="form-control round-0" value ="<?= $full_name; ?>" required="" />
            </div>
            <div class="reqs col-md-offset-5 col-md-5" style="margin-top: 0;"></div>
            <?php echo  form_error('first_name')?>
        </div>




        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-5">
                <button type="submit" class="btn-submit" <?php echo $disabled ?>>
                    <?=lang('ddcc_04');?>
                </button>
            </div><div class="clearfix"></div>
        </div>


    </form>

    <div class="col-sm-12"></div>

</div>

<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i>
    <?=lang('n_21');?>
</h1>
<table class="notes-list" style="margin-bottom: 150px;">

    <tr class="cb">
        <td  class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td  class="r_">
            <p> Accept payments and transfers from consumer bank accounts locally and internationally, and reach more countries at no additional cost and minimal effort.</p>
            </p>
        </td>
    </tr>

    <tr class="cb">
        <td  class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td  class="r_">
            <p>
                Please pay attention that the actual exchange rate at a moment of transaction can slightly differ from the exchange rate in the form above due to the fluctuating rate used by a payment provider. However the difference is not significant.
            </p>
        </td>
    </tr>
</table>

<script type="text/javascript">

    var currency = '<?= $account['currency'] ?>';

    $(document).ready(function(){
        exhange_currency();


        $('#from_amount').bind('keyup input', function(){
            exhange_currency();
        });


    });


    function exhange_currency() {
        var currencyFrom = currency,
            currencyTo = 'VND',
            amountFrom = $('#from_amount').val(),
            convertedAmount = 0.00;


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
                    convertedAmount = parseFloat(x.rate).toFixed(5);
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
