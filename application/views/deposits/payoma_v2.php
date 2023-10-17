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
    .btn-card {
    color: #fff;
    background: #29a643;
    border: none;
    float: right;
    padding: 3px 6px;
}


    .btn-submit {
        color: #fff;
        background: #29a643;
        border: none;
        float: right;
        padding: 7px 30px;
    }







</style>
<h1>
    Deposit Options -  Payoma
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
        
        <input type="hidden" id="base_url" value="<?php echo FXPP::ajax_url() ?>" />
        <form action="" method="post" class="form-horizontal subMob payFormSub" enctype="multipart/form-data" style="margin-top: 50px;">
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="alert alert-danger" role="alert" id="amountErrorVal" style="display: none"></div>
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

            <?php if(!$is_allowed_deposit){  $disabled = "disabled"; ?>

                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Sorry, but the following payment option is not available in your country.
                </div>

            <?php }else if(count($card_numbers) == 0){  $disabled = "disabled"; ?>
                
                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                     You have created a request to replenish your account with a card. Your card is checked and it can take up to three days. Please expect an email notification.
                </div>
                
            <?php }elseif(count($card_numbers)>0 && $allow_country){?>

                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Your Card is Approved. Card number( <?php echo join(', ',$card_numbers); ?>)
                </div>

            <?php }?>

            <div class="form-group" style="text-align: center;">
                <img src="<?= $this->template->Images()?>payoma.png" border="0" alt="" style="width: 165px; margin-bottom: 15px;"/>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('ddcc_02');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <?php
                    //$attr = 'id="currency" class="form-control round-0"' . $disabled;
                    ?>
                    <?php //echo form_dropdown('account_currency',Custom_library::getDepositCurrencyBase(),false,$attr);?>
                    <?php echo $input_account_number; ?>
                 </div>

            </div>


            <div class="form-group">
                <label class="col-sm-4 control-label">
                   Currency type
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <select name="currency_type" class="form-control round-0 payomacurrenytype">
                        <option <?php echo $account['currency'] == 'USD' ? "selected":"" ?>  value="USD">USD</option>
                        <option <?php echo $account['currency'] == 'EUR' ? "selected":"" ?> value="EUR">EUR</option>
                      
                            <option <?php echo $account['currency'] == 'RUB' ? "selected":"" ?> value="RUB">RUB</option>
                        
                    </select>
                   
               </div>

            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('ddcc_03');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="number" min="1" step="any"  name="amount" value="<?= floatval($deposit_amount) ?>"  id="amount" class="form-control round-0 numeric depositamountcheck"  placeholder="0.00"/>


                    <input type="hidden" name="bounusfiled" id="bounusfiled"  class="form-control round-0"   value="<?=$bounusfiled?>">
                    <div class="reqs errorlineshow">
                        <?php echo form_error('amount'); ?>
                    </div>
                </div>
            </div>


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
                    
                    </div>



                    <?php if(isset($_GET['cd']) && strlen($_GET['cd'])>5){  ?>
                    <div class="col-sm-3"><a class="btn-card" href="card-documents">Use another card</a></div>
                    <?php } else{?>
                        <div class="col-sm-2"><a class="btn-card" href="card-documents"> Add card</a></div>
                    <?php } ?>
                    <div class="reqs ">

                        <?php echo form_error('card_number'); ?>
                    </div>



                </div>


            
               



            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <?php /* ?>
                    <button type="submit" class="btn-submit" id="send2"<?php echo $disabled ?>>
                    Proceed
                    </button>
 */ ?>

                      <input type="submit" class="btn-submit" id="send2Sub"  value="Proceed"    <?php echo $disabled ?>  />

                </div><div class="clearfix"></div>
            </div>

        </form>

    </div>

</div>




<script type="text/javascript">

    $(document).on('click', '#send2Sub', function(){
        
      var isFormValid =  checkFormValidity();
      if(isFormValid){
         $('.payFormSub').submit();
      }
        
        
    });

    $(document).on('keydown','#amount',function (e) {
        var len = $(this).val().length;
        if (len == 0 && e.which === 190){
            e.preventDefault();
        }
    });

    function checkFormValidity(){
        if($('#card_number').val()){
            return true;
        } else {
            $('.CardFieldValSelect').html('Please select Card');
            return false;
        }
    }

</script>