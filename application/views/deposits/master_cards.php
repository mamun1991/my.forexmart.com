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
#payment_providers_depended_box{display: none}    
</style>
 <h1>Deposit Options</h1>
            <ol class="breadcrumb internal-breadcrumb">
                <li><a href="<?= FXPP::loc_url('deposit');?>"><?= lang('trd_22'); ?></a></li>
                <li><a href="<?= FXPP::loc_url('deposit');?>"><?= lang('trd_28'); ?></a></li>
                <li class="active">Master Cards</li>
            </ol>
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



        <form action="" method="post" class="form-horizontal subSkrill paymentmethodformsumit">

            <div class="form-group" style="text-align: center;">
                <?php $display = $this->session->flashdata('nova2pay_status');if(isset($display)){?>
                    <div class="col-sm-9 alert <?= $display == '1' ? 'alert-danger' : 'alert-success'; ?> center" role="alert" style="margin-bottom: 15px;margin-top: 15px; margin-left:12%;">
                        <p><?= $display == '1' ? 'Transaction Declined.' : 'Transaction Successful.'; ?></p>
                    </div>
                <?php } ?>

               <img src="<?= $this->template->Images()?>mastercard.png" class="img-reponsive" width="250px"/>
            </div>



            <div class="form-group">
                <label class="col-sm-4 control-label">
                    Account Number
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                     <?php echo $input_account_number; ?>
                </div>
                <span class="col-sm-3 req">  <?php echo  form_error('account_number')?> </span>
            </div>
            
             <div class="form-group currency-input">
                <label class="col-sm-4 control-label">Payment providers<cite class="req">*</cite></label>
                <div class="col-sm-5">
               
                <select name="payment_providers" id="payment_providers" class="form-control round-0">
                    <option value="nova2pay" selected>Nova2pay</option>
                    <option value="payoma" >Payoma</option>
                    <option value="zotapay" >Zotapay</option>
                </select>
            
                    <span class="req">  <?php echo  form_error('payment_providers')?> </span>
                </div>
            </div>
            
            
            <div id="payment_providers_depended_box"> 
            
                <div id="payment_providers_depended_box_nova2pay"  class="payment_providers">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    <?=lang('s_03');?>
                                    <cite class="req">*</cite></label>
                                <div class="col-sm-5">
                                    <input name="amount" id="amount" type="text" class="form-control round-0 numeric depositamountcheck" placeholder="0.00" value="<?=floatval($deposit_amount)?>" <?php echo $disabled ?>>
                                    <span class="amount_error" style="color: red"> <?= form_error('amount') ?></span>
                                </div>
                            </div>
                            <div class="form-group currency-input">
                                <label class="col-sm-4 control-label">Currency<cite class="req">*</cite></label>
                                <div class="col-sm-5">

                                <select name="currency" id="currency" class="form-control round-0">
                                    <option value="USD" selected>USD</option>
                                </select>

                                    <span class="req">  <?php echo  form_error('currency')?> </span>
                                </div>
                            </div>

                    </div> 
                
                <div id="payment_providers_depended_box_payoma" class="payment_providers">
                        
                    
                     
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="alert alert-danger" role="alert" id="amountErrorVal" style="display: none"></div>
                                                </div>
                                            </div>
 

                                            <div class="form-group" style="text-align: center;">
                                                <img src="https://my.forexmart.com/assets/images/payoma.png" border="0" alt="" style="width: 165px; margin-bottom: 15px;">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    Currency                    <cite class="req">*</cite></label>
                                                <div class="col-sm-5">
                                                                                            <input name="account_number" id="accountNumber" value="USD - 58072429[764.30]" class="form-control round-0" readonly="" data-balance="764.3" data-accountnumber="58072429" data-currency="USD">                </div>

                                            </div>
                                                                <div style="margin-bottom:0px" class="form-group">

                                                    <label class="col-sm-4 control-label">
                                                        Card number
                                                        <cite class="req">*</cite></label>

                                                    <div class="col-sm-5">
                                                        <input autocomplete="off" maxlength="19" class="form-control round-0" type="text" name="card_number" id="card_number" required="">
                                                    </div>
                                                    <span class="CardFieldVal" style="color: red"> </span>
                                                    <div class="reqs card-num-error">
                                                                            </div>
                                                </div>



                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label"></label>


                                                    <div class="col-sm-5">


                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" value="1" name="card_number_save">
                                                                Save card number
                                                            </label>
                                                        </div>

                                                    </div>

                                                </div>


                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">
                                                        Color copy of front side of the card
                                                        <cite class="req">*</cite></label>

                                                    <div class="col-sm-5">
                                                        <input class="form-control round-0" type="file" name="front_side" id="front_side" required="" onchange="readFile(this,'front')">
                                                    </div>
                                                    <div class="reqs front-error">
                                                                            </div>
                                                </div>


                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">
                                                        Color copy of back side of the card
                                                        <cite class="req">*</cite></label>

                                                    <div class="col-sm-5">
                                                        <input class="form-control round-0" type="file" name="back_side" id="back_side" required="" onchange="readFile(this,'back')">
                                                    </div>
                                                    <div class="reqs back-error">
                                                                            </div>
                                                </div>





<!--
                                            <div class="form-group">
                                                <div class="col-sm-offset-4 col-sm-5">
                                                        <input type="button" data-toggle="modal" class="btn-submit" id="send2" value="Send Request">
                                                </div><div class="clearfix"></div>
                                            </div>-->


                    
                    
                    
                    </div>
                
                    <div id="payment_providers_depended_box_zotapay"  class="payment_providers">
                        
                       

                                                <div class="form-group" style="text-align: center;">
                                                                    <img src="https://my.forexmart.com/assets/images/payment_getway_logo/zp-bank-myr.png" class="img-reponsive" width="250px">
                                                                    </div>
                                                <div class="form-group" style="text-align: center;">
                                                    <div class="col-sm-12">
                                                                        </div>
                                                </div>



                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">
                                                       Account Number
                                                        <cite class="req">*</cite></label>
                                                    <div class="col-sm-5">
                                                        <input name="account_number" id="accountNumber" value="USD - 58072429[764.30]" class="form-control round-0" readonly="" data-balance="764.3" data-accountnumber="58072429" data-currency="USD">                </div>

                                                </div>


                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">
                                                        Deposit Amount                    <cite class="req">*</cite></label>
                                                    <div class="col-sm-5">
                                                        <div class="icon-container" style="display: none;">
                                                            <i class="icon-loader"></i>
                                                        </div>
                                                        <input type="number" id="from_amount" name="from_amount" min="0" step="any" value="0" class="form-control round-0 numeric" placeholder="0.00" style="width: 45%">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"></label>
                                                    <div class="col-sm-5">
                                                        <input name="amount" id="amount" type="text" class="form-control round-0" readonly="" style="width: 45%">
                                                        <span class="amount_error" style="color: red"> </span>
                                                    </div>
                                                </div>

                                                    <div class="form-group">
                                                    <label class="col-sm-4 control-label">Currency<cite class="req">*</cite></label>
                                                    <div class="col-sm-5">
                                                                                <select name="currency" id="currency" class="form-control round-0">
                                                                <option value="MYR">MYR</option>
                                                                <option value="THB">THB</option>
                                                                <option value="VND">VND</option>
                                                                <option value="IDR">IDR</option>

                                                            </select>
                                                                            <span class="req">   </span>
                                                    </div>
                                                </div>

                                                <div class="form-group bank-opt">
                                                    <label class="col-sm-4 control-label">Banks<cite class="req">*</cite></label>
                                                    <div class="col-sm-5">
                                                        <select required="" name="banks" class="form-control" id="banks"><option value="CIMB">CIMB Bank</option><option value="HLB">Hong Leong Bank</option><option value="PBB">Public Bank</option><option value="RHB">RHB Bank</option><option value="MBB">Maybank</option><option value="AMB">AmBank Group</option><option value="BIMB">BIMB Bank</option></select>
                                                        <div class="reqs">
                                                                                </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">First Name<cite class="req">*</cite></label>
                                                    <div class="col-sm-5">
                                                        <input name="first_name" id="first_name" type="text" class="char-only form-control round-0" maxlength="30" value="testt">
                                                        <span class="firstname_error" style="color: red"> </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Last Name<cite class="req">*</cite></label>
                                                    <div class="col-sm-5">
                                                        <input name="last_name" id="last_name" type="text" class=" char-only form-control round-0" maxlength="30" value="no">
                                                        <span class="lastname_error" style="color: red"> </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Phone Number<cite class="req">*</cite></label>
                                                    <div class="col-sm-5">
                                                        <input name="phone_number" id="phone_number" type="text" class="form-control round-0" maxlength="16" value="01729123434">
                                                        <span class="phonenumber_error" style="color: red"> </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Address<cite class="req">*</cite></label>
                                                    <div class="col-sm-5">
                                                        <input name="address" id="address" type="text" class="form-control round-0" maxlength="90" value="house# 16,Road#4, mirpur-10,, dhaka-1216, dhaka-1216">
                                                        <span class="address_error" style="color: red"> </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">City<cite class="req">*</cite></label>
                                                    <div class="col-sm-5">
                                                        <input name="city" id="city" type="text" class="form-control round-0" maxlength="30" value="Dhaka">
                                                        <span class="city_error" style="color: red"> </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Zip code<cite class="req">*</cite></label>
                                                    <div class="col-sm-5">
                                                        <input name="zip" id="zip" type="text" class="form-control round-0" maxlength="10" value="1216">
                                                        <span class="zip_error" style="color: red"> </span>
                                                    </div>
                                                </div>

<!--                                                <div class="form-group">
                                                    <div class="col-sm-offset-4 col-sm-5">
                                                        <button type="submit" class="btn-submit ">
                                                            Send Request                    </button>


                                                    </div><div class="clearfix"></div>
                                                </div>
                                            -->
                        
                        
                        
                    </div>
                
                
            </div>   

            
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="button" class="btn-submit paymentmethodformsumitbutton"<?php echo $disabled ?>>
                        <?=lang('s_04');?>
                    </button>


                </div><div class="clearfix"></div>
            </div>
            
            
        </form>
    </div>

</div>
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
 
</table>




 <script>
var pay_pvd_key="<?=$selected_providers?>";     
var payment_providers= {
   nova2pay:'payment_providers_depended_box_nova2pay',
   payoma:'payment_providers_depended_box_payoma',
   zotapay:'payment_providers_depended_box_zotapay'
    };
    
paymentProvidersRun(pay_pvd_key);    
    
$(document).on("click","#payment_providers",function(){
     
var pay_pvd_key= $(this).val();   
    paymentProvidersRun(pay_pvd_key);
}) ;    
     
     
function  paymentProvidersRun(pay_pvd_key){
     
    $(".payment_providers").hide();
    $("#"+payment_providers[pay_pvd_key]).show();
    
    $("#payment_providers_depended_box").show();
    
}    
</script>     