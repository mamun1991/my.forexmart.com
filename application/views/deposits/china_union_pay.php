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

<h1><?=lang('dspt-t-5');?></h1>



<div class="row">

        <?php 
        $deposit_amount=0;
        
        if($amount>0)
        {
            $deposit_amount=$amount;
            
        }else{
           $deposit_amount= ($field_value)?$field_value['amount']:0;
           
        } 
 
        
        
        
        ?>


        <form id = "china_union_payForm" class="form-horizontal paymentmethodformsumit" method="POST" style="margin-top: 50px;">
            <input type="hidden"  name="base_url" id="base_url" value="<?php echo FXPP::ajax_url() ?>" />
            <input type="hidden" id="test_base_url" value="<?php echo $fail_lang2; ?>" />
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="alert alert-danger" role="alert" id="amountErrorVal" style="display: none"></div>
                </div>
            </div>
            <div class="form-group" style= "text-align: center;">
                <?php  if(validation_errors()){ ?>
                    <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;" role="alert" id="amountErrorVal"> <?php echo validation_errors();?></div>
                <?php }?>
            </div>
            

            <?php
            $disabled = "";
            if($non_verified_notice){?>
                <div class="form-group" style= "text-align: center;">
                    <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?=$non_verified_notice?></div>
                </div>
            <?php }else if($error_msg){
                $disabled = "disabled";
                ?>
                <div class="form-group" style= "text-align: center;">
                    <!--<div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?/*=$error_msg*/?></div>-->
                    <?php if($error_msg){?>

                        <?php if($error_msg == "Spanish client"): ?>

                            <?php echo FXPP::spanishValidationView("china_union_pay"); ?>

                        <?php else: ?>

                            <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$error_msg?></div>

                        <?php endif; ?>

                    <?php } ?>
                </div>
            <?php } ?>

            <?php // $disabled = false;
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

            <div class="form-group" style="text-align: center;">
                <img src="<?= $this->template->Images()?>chinaUnionPay.png" class="img-reponsive" width="150px"/>
            </div>
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
                    <input  type="number"  name="amount" id="amount" min="0" oninput="validate(this)"    value="<?=floatval($deposit_amount)?>"  step="any" class="form-control round-0  numeric depositamountcheck" placeholder="0.00"<?php echo $disabled ?>/>
                <div class="reqs amount-err errorlineshow" style="margin-top: 0;"><?php echo  form_error('amount')?></div>
                </div>
               
            </div>


  
            

            <div class="form-group">
                <label class="col-sm-4 control-label">
                    First name
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="first_name" id="first_name" value=" <?=($field_value)?$field_value['first_name']:""?>"  autocomplete="off"  maxlength="30"  class="form-control round-0 extra_field_validation" required="" />
                <div class="reqs error_first_name" style="margin-top: 0;"><?php echo  form_error('first_name')?></div>
                </div>
               
                
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    Last name
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="last_name" id="last_name" value="<?=($field_value)?$field_value['last_name']:""?>"  autocomplete="off" maxlength="30"  class="form-control round-0 extra_field_validation" required="" />
                <div class="reqs error_last_name" style="margin-top: 0;"> <?php echo  form_error('last_name')?></div>
                </div>
                
               
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    Address
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="address1" id="address1" maxlength="50"  value="<?=($field_value)?$field_value['address1']:""?>" class="form-control round-0 extra_field_validation" required="" />
                <div class="reqs error_address1" style="margin-top: 0;"><?php echo  form_error('address1')?></div>
                </div>
                
                
            </div>
             
            
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    City
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="city" id="city" value="<?=($field_value)?$field_value['city']:""?>" maxlength="30"  class="form-control round-0 extra_field_validation" required="" />
                <div class="reqs error_city" style="margin-top: 0;"><?php echo  form_error('city')?></div>
                </div>
                
                
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    Zip code
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="zip_code" id="zip_code"  value="<?=($field_value)?$field_value['zip_code']:""?>" maxlength="10"  class="form-control round-0 extra_field_validation" required=""/>
                <div class="reqs error_zip_code" style="margin-top: 0;"> <?php echo  form_error('zip_code')?></div>
                </div>
                
               
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">
                   Phone
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="phone"  id="phone" value="<?=($field_value)?$field_value['phone']:""?>" maxlength="13"  class="form-control round-0 extra_field_validation" required=""/>
                <div class="reqs error_phone" style="margin-top: 0;"><?php echo  form_error('phone')?></div>
                </div>
                
                
            </div>



            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="button" class="btn-submit paymentmethodformsumitbutton china_union_pay_submit_button" <?php echo $disabled ?>>
                        <?=lang('ddcc_04');?>
                    </button>
                </div><div class="clearfix"></div>
            </div>

            <div class="form-group">
                <div class="col-sm-2">
                    <div></div>
                </div>
                <div class="col-sm-8">
                    <div class="alert alert-info" role="alert"  >Please always use only actual recipient's bank details shown at the gateway page. ForexMart does not guarantee successful deposit in case other payment details are used.</div>
                </div>
            </div>
        </form>


</div>








<script>



    $('#first_name').on('keypress', function (event) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });


    $('#last_name').on('keypress', function (event) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });


    $('#phone').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });


    $('#first_name').bind("cut copy paste",function(e) {
        e.preventDefault();
    });

    $('#last_name').bind("cut copy paste",function(e) {
        e.preventDefault();
    });


     

    var validate = function(e) {
        var t = e.value;
        e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
    };




    

</script>



