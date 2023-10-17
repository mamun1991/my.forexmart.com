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
</style>

<!--<h1>--><?//= lang('idr');?><!--</h1>-->
<h1>Deposit via local bank transfer in VND</h1>

<div class="row">



    <form id = "china_union_payForm" class="form-horizontal" method="POST" style="margin-top: 50px;">
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
        if(isset($msg)){
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

                <?php echo $input_account_number; ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">
                <?=lang('ddcc_03');?>
                <cite class="req">*</cite></label>
            <div class="col-sm-5">
                <input   type="number"  name="amount" id="amount"    value="<?=floatval($amount)?>"  class="form-control round-0 numeric" placeholder="0.00"<?php echo $disabled ?>/>
            </div>
            <div class="reqs amount-err col-md-offset-5 col-md-5" style="margin-top: 0;">
                <?php echo  form_error('deposit_vnd_amt_validation')?>
            </div>
        </div>



        <div class="form-group">
            <label class="col-sm-4 control-label">
                Full name
                <cite class="req">*</cite></label>
            <div class="col-sm-5">
                <input type="text" name="first_name" id="first_name"  class="form-control round-0" required="" />
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

    <div class="col-sm-12">
        <div class="alert alert-info center" role="alert">
            <p> Accept payments and transfers from consumer bank accounts locally and internationally, and reach more countries at no additional cost and minimal effort.</p>
        </div>
    </div>

</div>

