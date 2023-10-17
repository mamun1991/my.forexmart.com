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
</style>

    

 <?php if(FXPP::isMasterCard()){   
      
      $this->load->view('deposits/master_cards_inner_tab.php');
       echo "</br></br>";
  } ?>


   
    
     <?php   if(!FXPP::isMasterCard()){   ?>
        <h1>
            Deposit Options - Nova2Pay
        </h1>
     <?php } ?>


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



        <form action="" method="post" class="form-horizontal payFormSub paymentmethodformsumit">

        

            <div class="form-group" style="text-align: center;">
                <?php $display = $this->session->flashdata('nova2pay_status');if(isset($display)){?>
                    <div class="col-sm-9 alert <?= $display == '1' ? 'alert-danger' : 'alert-success'; ?> center" role="alert" style="margin-bottom: 15px;margin-top: 15px; margin-left:12%;">
                        <p><?= $display == '1' ? 'Transaction Declined.' : 'Transaction Successful.'; ?></p>
                    </div>
                <?php } ?>

                <?php 
                    if(!FXPP::isMasterCard()){
                ?>
               <img src="<?= $this->template->Images()?>mastercard.png" class="img-reponsive" width="250px"/>
                    <?php } ?>
            </div>

            <?php if (FXPP::cardUsers()) { ?>

            <?php if(count($card_numbers) == 0){  $disabled = "disabled"; ?>

            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                You have created a request to replenish your account with a card. Your card is checked and it can take up to three days. Please expect an email notification.
            </div>

            <?php } ?>
            
            <?php } ?>

            <div class="form-group">
                <label class="col-sm-4 control-label">
                    Account Number
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                     <?php echo $input_account_number; ?>
                </div>
                <span class="col-sm-3 req">  <?php echo  form_error('account_number')?> </span>
            </div>
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

            <?php if(FXPP::cardUsers()){ ?>
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
            <div class="col-sm-3"><a class="btn-card" href="card-documents?p=np">Use another card</a></div>
            <?php } else{?>
                <div class="col-sm-2"><a class="btn-card" href="card-documents?p=np"> Add card</a></div>
            <?php } ?>
           



            </div>

           <?php  } ?>
            
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="button" id="send2Sub" class="btn-submit" <?php echo $disabled ?>>
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

      
<script type="text/javascript">
    $(document).on('click', '#send2Sub', function(){
        
       <?php if (FXPP::cardUsers()){ ?>
  
        var cardNumb=$('#card_number').val();
        if(cardNumb!=''){

            $('.payFormSub').submit();
        }else{
            $('.CardFieldValSelect').html('Please select Card');
            return false;
        }

        <?php  }else{ ?>

            $('.payFormSub').submit();
       <?php } ?>
        
    });

    $(document).on('keydown','#amount',function (e) {
        var len = $(this).val().length;
        if (len == 0 && e.which === 190){
            e.preventDefault();
        }
    });

</script>



