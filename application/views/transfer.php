<style type="text/css">
    .trns-holder{
        padding-top: 40px !important;
    }
    .finance_container{
        margin-top: 40px !important;
    }
    #form-transfer-review p{
        margin: 0px !important;
    }
    .btn-withdraw-option{
        margin: 5px !important;
    }
    .hor_center{
        text-align:center;
    }
    .acct-cont{

    }
    .cc{text-align: center;}

    /*.forMobile {*/
        /*display: none;*/
    /*}*/

    .border-red{
        border: 1px solid red;
    }


    @media screen and (max-width:767px){

        form#form-transfer-review {
            text-align: center;
        }

    }



    
#inputbonus_type_ten{margin-left: 30px;}  
#transfe_bonus_finance{display: none}

</style>
<?php $this->load->view('finance_nav.php');?>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active">
        <div class="row">
            <div class="col-sm-9 col-centered trns-holder arabic-trns-holder <?php echo ($blocked_account==true)?'ctm_pad':'' ?>">
                <?php if($blocked_account){ ?>
                    <style type="text/css">
                        .ctm_pad{
                            padding-top: 15px !important;
                        }
                    </style>
                    <div class="alert alert-info hor_center">
                        <?=lang('m_trns_04');?>
                    </div>
                <?php }else{?>
                        <?php if($process_state){ ?>
                        <form id="transfer_form" class="form-horizontal" method="POST">
                            <?php if (isset($_SESSION['preventndbtransfer']) and $_SESSION['preventndbtransfer']==true){ ?>
                              <!--  <div class="form-group">
                                    <div class="alert alert-danger cc" >
                                        <i class="fa fa-exclamation-circle"></i> <?//=lang('m_trns_05');?>
                                    </div>
                                </div>-->
                            <?php  unset($_SESSION['preventndbtransfer']); }?>
                              
                              
                   
                              
                              
                            <input type="hidden" name="hidden-lang" id="hidden-lang" value = "<?= FXPP::html_url()?>">
                           
                            <input type="hidden" name="bonus_type" id="bonus_type_ids" value=""/> 
                            
                            
                            <div class="form-group">
                                <label class="col-sm-4 lbl-txt <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-form-finance">
                                    <?=lang('tra_00');?>
                                    <cite class="req">*</cite></label>
                                <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-input-placeholder arabic-form-finance">
                                    <input type="text" maxlength="10" placeholder="<?=lang('tra_16');?>" name="account_receiver" class="form-control round-0 required-field numeric addMobileVersion accRecErr" id="account_receiver" value="<?php echo set_value('account_receiver')?>">


<!--                                     <input type="tel" maxlength="10" placeholder="--><?//=lang('tra_16');?><!--" name="account_receiver" class="form-control round-0 required-field numeric forMobile" id="account_receiver" value="--><?php //echo set_value('account_receiver')?><!--">-->


                                    <span class="error "><?php echo form_error('account_receiver')?></span>
                                </div>
                            </div>
                            
                            
                             <?php 
                            if(IPLoc::frzPM())
                            {
                            ?>
                            <div class="form-group" id="transfe_bonus_finance">
                                <label class="col-sm-4 lbl-txt <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-form-finance">
                                    Bonus
                                    <cite class="req"></cite></label>
                                <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?>  arabic-input-placeholder arabic-form-finance">
                                    <b id="inputbonus_type_b"> <input id="inputbonus_type" class="transfe_bonus_finance" type="radio" value="20" name="bonus_type_radio">  <b>20% BONUS</b> </b>
                                    <b id="inputbonus_type_ten_b"> <input id="inputbonus_type_ten" class="transfe_bonus_finance" type="radio" value="10" name="bonus_type_radio">  <b>10% BONUS</b> </b>
                                    <span class="error"></span>
                                </div>
                            </div>
                              <?php } ?>
                            
                            <div class="form-group">
                                <label class="col-sm-4 lbl-txt <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-form-finance">
                                    <?=lang('tra_01');?>
                                    <cite class="req">*</cite></label>
                                <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?>  arabic-input-placeholder arabic-form-finance">
                                    <input type="text" maxlength="10" placeholder="<?=lang('amount')?>" name="amount" class="form-control round-0 required-field numeric addMobileVersion amountErr" id="amount" value="<?php echo set_value('amount')?>">
<!--                                    <input type="tel" maxlength="10" placeholder="--><?//=lang('amount')?><!--" name="amount" class="form-control round-0 required-field numeric forMobile" id="amount" value="--><?php //echo set_value('amount')?><!--">-->
                                    <span class="error "><?php echo form_error('amount')?></span>
                                </div>
                            </div>
                            
                            <?php 
                            if(IPLoc::frzPM())
                            {
                            ?>
                             <div class="form-group" id="transfe_bonus_finance_readonly">
                                <label class="col-sm-4 lbl-txt <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-form-finance">
                                    You Get
                                    <cite class="req"></cite></label>
                                <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?>  arabic-input-placeholder arabic-form-finance">
                                   
                                    <input type="text"  id="getValue"   class="form-control round-0 required-field numeric transfe_bonus_finance_readonly"   value="0" readonly="readonly" disabled="disabled">
                                    <span class="error"></span>
                                </div>
                            </div>
                            <?php } ?>
                            
                            <div class="form-group">
                                <label class="col-sm-4 lbl-txt <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-form-finance">
                                    <?=lang('tra_02');?>
                                </label>
                                <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?>  arabic-input-placeholder arabic-form-finance">
                                    <textarea name="comment" placeholder="<?=lang('option');?>" id="comment" class="form-control"><?php echo set_value('comment')?></textarea>
                                </div>
                            </div>
                            
                            
                         
                            

                            <div class="form-group">
                                <div class="col-sm-10 arabic-btn-trnsfer-holder" style="text-align: <?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>;">
                                    <a class="btn-withdraw-option review-transfer">
                                        <?=lang('tra_03');?>
                                    </a>
                                </div>
                            </div>
                        </form>
                        <form class="form-horizontal" id="form-transfer-review" style="display: none;">
                            <div class="form-group">
                                <div class="alert alert-info" role-alert="" style="width: 75%;margin: 0 auto;">
                                    <i class="fa fa-info-circle"></i>

                                    <?=lang('tra_04');?>.

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6 control-label">
                                    <?=lang('tra_05');?>:
                                </label>
                                <div class="col-sm-6">
                                    <p class="frm-val" id="txtReviewAmount"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6 control-label">
                                    <?=lang('tra_06');?>:
                                </label>
                                <div class="col-sm-6">
                                    <p class="frm-val" id="txtReviewTransferTo"></p>
                                </div>
                            </div>
                            <div class="form-group" id="comment-container">
                                <label class="col-sm-6 control-label">
                                    <?=lang('tra_07');?>:
                                </label>
                                <div class="col-sm-6">
                                    <p class="frm-val" id="txtReviewComment"></p>
                                </div>
                            </div>

                            <div class="btn-create-another">
                                <a class="btn-withdraw-option back-transfer">
                                    <?=lang('tra_08');?>
                                </a> <a class="btn-withdraw-option complete-transfer">
                                    <?=lang('tra_09');?>
                                </a>
                            </div>
                        </form>
                    <?php }else{ ?>
                        <div class="panel panel-default round-0">
                            <div class="panel-heading">
                                <b>
                                    <?=lang('tra_10');?>
                                </b>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8 col-centered">
                                        <div class="alert alert-success" role="alert" style="text-align: center;">
                                            <i class="fa fa-check-circle"></i>
                                            <?=lang('tra_11');?>
                                        </div>
                                        <form class="form-horizontal form-success">

                                            <div class="form-group">
                                                <label class="col-sm-6 control-label">
                                                    <?=lang('tra_12');?>:
                                                </label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val" id="txtSuccessAmount"><?php echo $successData['amount'];?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-6 control-label">
                                                    <?=lang('tra_13');?>:
                                                </label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val" id="txtSuccessTransferTo"><?php echo $successData['account_receiver']; ?></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-6 control-label">
                                                    <?=lang('tra_14');?>:
                                                </label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val" id="txtSuccessTransactionId"><?php echo $transactionId; ?></p>
                                                </div>
                                            </div>

                                        </form>
                                        <div class="btn-create-another">
                                            <a href="<?php echo FXPP::loc_url('transfer')?>" class="create-another">
                                                <?=lang('tra_15');?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php }?>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        var win = $(this); //this = window
        if (win.width() > 768) {
            $(".addMobileVersion").prop("type", "text");
        } else {
            $(".addMobileVersion").prop("type", "tel");
        }
    });

    $(window).on('resize', function(){
        var win = $(this); //this = window
        if (win.width() > 768) {
            $(".addMobileVersion").prop("type", "text");
//            $('.addMobileVersion').attr();
            console.log('========='+win.width());
        } else {
            $(".addMobileVersion").prop("type", "tel");
            console.log('<<<<<<<<<<<<'+win.width());
        }
    });


    jQuery(document).ready(function(){
       jQuery('.btn-trnsfer').click(function(event){
           event.preventDefault();
           jQuery('#transferAlert').show();
       });
    });
    
    
  var forexmart = "<?php echo FXPP::ajax_url(); ?>";    
    
   
   
//getBonusType()   

$(document).on("input","#account_receiver",function(){
    var account_number=$(this).val();
    
    if(account_number.length>5)
    {
        var ajax_url=forexmart+"Transfer/getAccountTypeBonusData";
        
        
        $.post(ajax_url,{account_number:account_number},function(view){
            if(view.status)
            {
               // console.log(view);
                
                if(view.bonus==0 && view.specail_ten_bonus==0)
                {
                    $("#transfe_bonus_finance").hide(); 
                }
                else if(view.bonus>0 && view.specail_ten_bonus>0)
                { 
                    
                    $("#inputbonus_type").val(view.bonus);
                    $("#inputbonus_type_ten").val(view.specail_ten_bonus);
                    
                        $("#inputbonus_type_ten_b").show();
                        $("#inputbonus_type_b").show();
                    
                        $("#transfe_bonus_finance").show(); 
                }
                else{
                    
                     if(view.bonus==0)
                     {
                         $("#inputbonus_type").val(view.bonus);
                         $("#inputbonus_type_b").hide();
                         $("#inputbonus_type_ten_b").show();
                     }
                     
                     if(view.specail_ten_bonus==0)
                     {
                          $("#inputbonus_type_ten").val(view.specail_ten_bonus);
                         $("#inputbonus_type_ten_b").hide();
                         $("#inputbonus_type_b").show();
                     }
                    
                    $("#transfe_bonus_finance").show(); 
                }
               
                
                
                
            }     
            
        });
    }else{
        
         $("#getValue").val(0); 
         $("#transfe_bonus_finance").hide(); 
    }
    
});





    
 $(document).on("change","#inputbonus_type",function(e){
    
      calBonus();

});

$(document).on("change","#inputbonus_type_ten",function(e){
 
      calBonus();

});
   
    
    
 
$(document).on("keyup","#amount",function(e){
    
       var total_amt=0; 
       var amt_data= $(this).val();
       var amt =(isNanVal(amt_data))?0:parseFloat(amt_data); 
      
        calBonus();
});   
    


 function calBonus(){
  
        
    var bonusType_data = 0;
    if($("#inputbonus_type").is(':checked')){
           //console.log("========================>one");
        bonusType_data = $('#inputbonus_type').val();
    }
  
    if($("#inputbonus_type_ten").is(':checked')){
          // console.log("========================>two");
        bonusType_data = $('#inputbonus_type_ten').val();
    }
   
   
   
      //console.log("========================>"+bonusType_data);
     
               
               var bonusType =(isNanVal(bonusType_data))?0:parseFloat(bonusType_data);
     
               
               var amt_data=$('#amount').val();
               var amt =(isNanVal(amt_data))?0:parseFloat(amt_data);       
        
                var bonusAmt = amt+((bonusType*amt)/100);
                
                bonusAmt =(isNanVal(bonusAmt))?0:parseFloat(bonusAmt);                    
                 
                $('#getValue').val(bonusAmt);
 }



 
 function isNanVal(amount){  
   amount=parseFloat(amount);
   return Number.isNaN(amount) ;
 
}


function getBonusType()
{


        var bonusType_data = 0;

        if($("#inputbonus_type").is(':checked')){
        bonusType_data = $('#inputbonus_type').val();
        }

        if($("#inputbonus_type_ten").is(':checked')){
        bonusType_data = $('#inputbonus_type_ten').val();
        }


        var bonusType =(isNanVal(bonusType_data))?0:parseFloat(bonusType_data);

        var bonusTypeTxt=false;          

                         switch (bonusType) {
                             case 30: bonusTypeTxt = 'tpb';                         
                                 break;
                            case 20: bonusTypeTxt = 'twpb';                         
                                 break;    
                           case 10: bonusTypeTxt = 'tenpb';                         
                                 break;    
                             default:
                                 break;
                         }

        return bonusTypeTxt;    
    
}

 //bonus_type_ids
</script>