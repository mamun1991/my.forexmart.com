<link type="text/css"  href="<?= $this->template->Css()?>deposit_finance_index.css" rel="stylesheet">
<style type="text/css">
    #bonus_checkbox {
        text-align: center;
    }

    .f_hide{display:none;}
</style>

<div class="col-sm-12 col-xs-12">
   
<?php

$mt_set_id =  $this->session->userdata('mt_account_set_id'); 
if($staticId != 'logId'){
    $this->load->view('finance_nav.php');
}



$user_id=$this->session->userdata('user_id');
$account_number=$this->session->userdata('account_number');
$special_ten_per_bonus=false;

if(FXPP::isAllowFirstDepositBonus($user_id))
{
   $special_ten_per_bonus = 10;
}

if($account_number == 58075218){
    $special_ten_per_bonus = 10;
}

?>

    <div style="margin-top: 15px;" class="">
        <ul class="grp-list-payment">

            
                               
<?php 

if(IPLoc::Office()){
?>

<li>
  <a href="#bonusHolder" class="btn-img-payment" id="selectButton00" data-url="deposit/master-cards" ptype="master_cards">
      <div class="img-holder"><span class="img-item img-mastercard"></span></div>
      <label class="lbl-payment">Deposit via Mastercard</label>
  </a>
</li>

<?php } ?>

<?php 
if(FXPP::thunderXpayAllow()){
?>
<li>
  <a href="#bonusHolder" class="btn-img-payment" id="selectButton00" data-url="deposit/thunderXPay" ptype="thunderXPay">
      <div class="img-holder"><span class="img-item img-thunderxpay"></span></div>
      <label class="lbl-payment">Deposit via ThunderXPay</label>
  </a>
</li>

<?php 
}
?>                                   
                 
            

                                <?php 
                                if(FXPP::isPayomaPayMentAvailable())
                                {
                                ?>


                                    <li>
                                      <a href="#bonusHolder" class="btn-img-payment" id="selectButton01" data-url="deposit/debit-credit-cards" ptype="debit-credit-cards">
                                          <div class="img-holder"><span class="img-item img-debit-credit"></span></div>
                                          <label class="lbl-payment"><?= lang('DepositCredit');?></label>
                                      </a>
                                  </li>


                                <?php } ?>

 
                                  
                                   
                                <?php if(FXPP::isNova2PayMentAvailable()) {?>
                                  <li>
                                       <a href="#bonusHolder" class="btn-img-payment" id="selectButton01" data-url="deposit/nova2pay" ptype="nova2pay">
                                           <div class="img-holder"><span class="img-item img-nova2Pay"></span></div>
                                           <label class="lbl-payment">Deposit via Mastercard</label>
                                       </a>
                                   </li>
                                 <?php } ?> 
 
                                        
                            
                            
                            <?php //if(FXPP::isIndonesianCountry() || IPLoc::Office()){
//                                 if( $this->session->userdata('account_number') == '58008538' || $this->session->userdata('account_number') == '58037565' || $this->session->userdata('account_number') == '58050227' || $this->session->userdata('account_number') == '58039610'){
                                 if(FXPP::isReferralsOfAccount('IDR') || FXPP::isIndonesianCountry() || IPLoc::Office() || IPLoc::VPN_IP_Jenalie()){?>
                                <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="deposit/idr-local-bank-transfer" ptype="idr-local-bank-transfer">
                                        <div class="img-holder"><span class="img-item img-idr"></span></div>
                                        <label class="lbl-payment"><?= lang('idr');?></label>
                                    </a>
                                </li>

                            <?php } ?>

                            <?php //if($this->session->userdata('account_number') == '58039610' || $this->session->userdata('account_number') == '58059115' || IPLoc::JustG()) { ?>
                            <?php if(FXPP::isVietnamCountry()) { ?>

                                <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="deposit/vnd-local-bank-transfer" ptype="vnd-local-bank-transfer">
                                        <div class="img-holder"><span class="img-item img-vnd"></span></div>
                                        <label class="lbl-payment">Deposit via local bank transfer in Vietnam</label>
                                    </a>
                                </li>

                            <?php } ?>



                            <?php if(!FXPP::isReferralsOfAccount('IDR')){ ?>
                            <?php if(FXPP::isIndonesianCountry()){ ?>

                               <li>
                                   <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="deposit/local-depositor-idr" ptype="local-depositor-idr">
                                       <div class="img-holder"><span class="img-item img-idr"></span></div>
                                       <label class="lbl-payment">Local Depositor in Indonesia</label>
                                   </a>
                               </li>

                           <?php } }?>

                            <?php if(FXPP::isMalaysianCountry()){ ?>
                               

                                <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="deposit/myr-local-bank-transfer" ptype="myr-local-bank-transfer">
                                 <!--   <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="deposit/bank-transfer-myr" ptype="bank-transfer-myr">-->
                                        <div class="img-holder"><span class="img-item img-myr"></span></div>
                                        <label class="lbl-payment"><?= lang('myr');?></label>
                                    </a>
                                </li>
                            <?php } ?>

                                <?php if(!FXPP::isReferralsOfAccount('MYR')){ ?>
                                <?php if(FXPP::isMalaysianCountry()){ ?>
                                
                                <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton03" data-url="deposit/local-depositor-myr" ptype="local-depositor-myr">
                                        <div class="img-holder"><span class="img-item img-myr"></span></div>
                                        <label class="lbl-payment"><?=lang('lcl_depos');?></label>
                                    </a>
                                </li>
                            <?php }} ?>

                            <?php if(FXPP::isThailandCountry() || IPLoc::IPOnlyForG()){ ?>
                                
                                <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="deposit/thb-local-bank-transfer"  ptype="thb-local-bank-transfer">
                                        <div class="img-holder"><span class="img-item img-myr"></span></div>
                                        <label class="lbl-payment"><?=lang('lcl_bnk_tr');?></label>
                                    </a>
                                </li>
                            <?php } ?>

                          

                            <?php if(!FXPP::isEUClient()){?>
                            
                            <li>
                                <a href="#bonusHolder" class="btn-img-payment" id="selectButton04" data-url="deposit/skrill" ptype="skrill">
                                    <div class="img-holder"><span class="img-item img-skrill"></span></div>
                                    <label class="lbl-payment"><?= lang('skl');?></label>
                                </a>
                            </li>


                            

                            <li>
                                <a href="#bonusHolder" class="btn-img-payment" id="selectButton05" data-url="deposit/neteller" ptype="neteller">
                                    <div class="img-holder"><span class="img-item img-neteller"></span></div>
                                    <label class="lbl-payment">Deposit Neteller</label>
                                </a>
                            </li>
                            <?php }?>




            
            <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton06" data-url="deposit/payco" ptype="payco">
                    <div class="img-holder"><span class="img-item img-payco"></span></div>
                    <label class="lbl-payment"><?= lang('pco');?></label>
                </a>
            </li>
            <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton07" data-url="deposit/cryptocurrency" ptype="cryptocurrency">
                    <div class="img-holder"><span class="img-item img-bitcoin"></span></div>
                    <label class="lbl-payment"><?= lang('btc');?></label>
                </a>
            </li>
            <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton08" data-url="deposit/fasapay" ptype="fasapay">
                    <div class="img-holder"><span class="img-item img-fasapay"></span></div>
                    <label class="lbl-payment"><?= lang('fasap');?></label>
                </a>
            </li>
            <?php if(FXPP::isMexicanCountry() || IPLoc::IPOnlyForVenus()){ ?>
            <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton09" data-url="deposit/bank-transfer-mxn" ptype="bank-transfer-mxn">
                    <div class="img-holder"><span class="img-item img-mxn"></span></div>
                    <label class="lbl-payment">Deposit via Local Bank Transfer in Mexico</label>
                </a>
            </li>
            <?php } ?>
            
   
            <?php if(FXPP::isBrazilianCountry() || IPLoc::IPOnlyForVenus()){ ?>

            <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton10" data-url="deposit/bank-transfer-brl" ptype="bank-transfer-brl">
                    <div class="img-holder"><span class="img-item img-brl"></span></div>
                    <label class="lbl-payment">Deposit via Local Bank Transfer in Brazil</label>
                </a>
            </li>
            <?php } ?>
            <?php //if(FXPP::isNigerianCountry() || IPLoc::IPOnlyForVenus()){ ?>
           <!-- <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton11" data-url="deposit/bank-transfer-ngn" ptype="bank-transfer-ngn">
                    <div class="img-holder"><span class="img-item img-banktransfer"></span></div>
                    <label class="lbl-payment">Deposit via Local Bank Transfer in Nigeria</label>
                </a>
            </li>-->
            <?php //} ?>


            <?php //if( IPLoc::IPOnlyForVenus()){ //FXPP::isKenyaCountry() FXPP-13427 ?>
            <!--<li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton12" data-url="deposit/bank-transfer-kes" ptype="bank-transfer-ngn">
                    <div class="img-holder"><span class="img-item img-kes"></span></div>
                    <label class="lbl-payment">Deposit  Mpesa</label>
                </a>
            </li>-->
            <?php //} ?>
            <?php //if(FXPP::isGhanaCountry()){ ?>
            <!--<li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton13" data-url="deposit/bank-transfer-ghs" ptype="bank-transfer-ngn">
                    <div class="img-holder"><span class="img-item img-ghs"></span></div>
                    <label class="lbl-payment">Deposit via Local Bank Transfer in Ghana</label>
                </a>
            </li>-->
            <?php //} ?>
            <?php //if(FXPP::isUgandaCountry()){ ?>
            <!--<li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton14" data-url="deposit/bank-transfer-ugx" ptype="bank-transfer-ngn">
                    <div class="img-holder"><span class="img-item img-ugx"></span></div>
                    <label class="lbl-payment">Deposit via Local Bank Transfer in Uganda</label>
                </a>
            </li>-->
            <?php //} ?>

         

            <!-- FXPP-12712-->
            <!--  <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton09" data-url="deposit/china-union-pay" ptype="china-union-pay">
                    <div class="img-holder"><span class="img-item img-union-pay"></span></div>
                    <label class="lbl-payment"><?//= lang('cup');?></label>
                </a>
            </li>
            <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton10" data-url="deposit/alipay" ptype="alipay">
                    <div class="img-holder"><span class="img-item img-alipay"></span></div>
                    <label class="lbl-payment"><?//=lang('dep_alipay');?></label>
                </a>
            </li>-->
        </ul>

              <?php  
                    
                                
                            $bonus = 0;
                            $hide_class = 'f_hide';
                            if(in_array($mt_set_id,array(5,7))){
                                $bonus = 20;
                                $hide_class ='';
                            }else if($mt_set_id == 2){
                                    $bonus = 30;
                                    $hide_class = '';
                            }
                                
                               
                            if(IPLoc::frzPM() || IPLoc::VPN_IP_Jenalie())
                            {
//                                if($bonus!="" and $special_ten_per_bonus!=""){
//                                    $hide_class="";
//                                }
                            }
                                
                                
                ?>

        <div class="bonus-holder  <?php echo $hide_class; ?>" id="bonusHolder">
            <form class="form-horizontal form-bonus">
                <label style="display:none" class="form-checkbox noBonuslabel" ><?=lang('WithoutBonus');?>
                    <input    type="checkbox" id="noBonus" >
                    <span class="checkmark"></span>
                </label>


                <div  class="form-grp-holder" id="yesBonusHolder">

               


                    <div class="form-group" >
                        <label class="control-label col-sm-4 form-label"><?= lang('Bonus_label');?></label>
                        <div class="col-sm-8" style="text-align: left;" >

                        
                       
                        <div class="checkbox" id="bonus_checkbox">
                            
                              <?php 
                                if($bonus>0)
                                {?>

                                    <?php
                                        if(IPLoc::frzPM() || IPLoc::VPN_IP_Jenalie() || IPLoc::Office()){ ?>

                                            <label>

                                                <input id="inputbonus_type" type="checkbox" value="<?php echo $bonus;?>" name="bonus_type" >
                                                <b><?php echo $bonus."% BONUS";?></b>

                                            </label>

                                        <?php } else{ ?>

                                            <label>

                                                <input id="inputbonus_type" type="radio" value="<?php echo $bonus;?>" name="bonus_type" >
                                                <b><?php echo $bonus."% BONUS";?></b>

                                            </label>

                                        <?php } ?>
                            
                                <?php } ?>
                            
                            <?php 
                            
                             if(IPLoc::frzPM() || IPLoc::VPN_IP_Jenalie() || IPLoc::Office())
                             {   
                                if($special_ten_per_bonus && $bonus == 20)
                                {?>
                                    <label>

                                        <input id="inputbonus_type_ten" type="checkbox" value="<?php echo $special_ten_per_bonus;?>" name="inputbonus_type_ten" >
                                        <b><?php echo $special_ten_per_bonus."% BONUS";?></b>

                                    </label>
                            
                             <?php } } ?>
                        </div>

                        
                        
                        
                            
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4 form-label"><?= lang('DepositAmount');?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-input numeric" maxlength="9"  id="bonusAmount" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4 form-label"><?= lang('YouGet');?></label>
                        <div class="col-sm-8">
                            <input readonly type="text" class="form-control form-input" id="getValue" value="">
                        </div>
                    </div>
                </div>
                <a class="btn btn-continue btn-center" href="#"><?= lang('with-p-05');?></a>
            </form>
        </div>
        
        
        
        
    </div>
</div>
<?=$show_modal;?>
<?=$modal_bonus_alert?>

<script>

    var test_phase = false;
    <?php if(IPLoc::VPN_IP_Jenalie() || IPLoc::frzPM() || IPLoc::Office()){ ?>
        test_phase = true;
    <?php } ?>

    // console.log(test_phase);

    var bonus = <?php echo $bonus;?>;
    var speacail_ten_per_bonus = '<?=$speacail_ten_per_bonus?>';
    
    
var autoSelect = '<?php echo isset($_GET['method'])?$_GET['method']:false; ?>';

var base_url = "<?php echo FXPP::loc_url();?>";
<?php if(IPLoc::VPN_IP_Jenalie()):?>
    base_url = "<?php echo FXPP::loc_url_new('');?>";
<?php endif;?>
 var isSupporter ="<?=$isSupporter?>";
 var IsStandardAccount ="<?=$IsStandardAccount?>";
 var loginType ="<?=$loginType?>";
 var dpst_msg9_50 ='<?=lang('dpst_msg9_50');?>';
 var bonus_selection='<?=$bonus_selection?>';
 var dpst_msg1= '<?=lang('dpst_msg1');?>';
var isNewAccountType='<?=$isNewAccountType?>';

var bonusAtive = 0;
var bonusTypeTxt = '';
var payment_type='';
var bonusType='';
var ptype="";
var max_deposit="100000000";
var max_deposit_mgs= "Maximum deposit amount is 100,000,000.";


var payment_method_min_deposit ={
    "debit-credit-cards":"1",    
    "skrill":"1",
    "neteller":"1",
    "payco":"1",
    "cryptocurrency":"5",
    "fasapay":"0.10",
    "alipay":"14.30",
    "bank-transfer-myr":"11.80", 
    "local-depositor-idr":"1",
    "bank-transfer-idr":"1",
    "local-depositor-idr":"1",   
    "local-depositor-myr":"1",
    "bank-transfer-thb":"1",
    "china-union-pay":"1",   
    
    };
 
 
 

 

$(document).ready(function(){


    if(autoSelect){
        console.log('auto select');
        $("[ptype='"+autoSelect+"']").closest('.btn-img-payment').click();
    }
    jQuery(".numeric").on("keypress keyup blur",function (event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    jQuery(".numeric").on("cut copy paste",function (event) {
        //if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
       // }
    });


    jQuery(".numeric").on("blur",function (event) {
        var value=$(this).val().replace(/[^0-9.,]*/g, '');
        value=value.replace(/\.{2,}/g, '.');
        value=value.replace(/\.,/g, ',');
        value=value.replace(/\,\./g, ',');
        value=value.replace(/\,{2,}/g, ',');
        value=value.replace(/\.[0-9]+\./g, '.');
        $(this).val(value)
    });
   
     noBonusCheckBox();
    
}) ;

function redirect(){
    if(bonus === 0){
        payment_type = $(".btn-img-payment").attr('data-url'); 
        window.location.replace(base_url+payment_type);
    }
}
    
    
$(document).on("click",".btn-img-payment",function(e){
    
   
    payment_type = $(this).attr('data-url'); 


    if(bonus === 0){   

    
        if(payment_type == 'deposit/zotapay'){
            window.location.replace(base_url+payment_type+'?type=cc');
            //url = base_url+payment_type+'?bonus='+bonusTypeTxt+'&amount1='+amt+'&addBonus='+additional_bonus +'&type=cc';
        }else{
            window.location.replace(base_url+payment_type);
        }

    }

         ptype = $(this).attr('ptype'); 
         console.log(ptype); 
          url();
        $('.btn-img-payment').removeClass('btn-highlight');
        $(this).addClass('btn-highlight');
       //  scroll to target
       var jump = $(this).attr('href');
       var new_position = $(jump).offset();
       $('html, body').stop().animate({ scrollTop: new_position.top }, 500);
       e.preventDefault();

      calBonus();

    
}) ;

$(document).on("click","#noBonus",function(e){
    
        noBonusCheckBox();   
    
});

    var test_phase = false;
    <?php if(IPLoc::VPN_IP_Jenalie() || IPLoc::frzPM()){ ?>
    test_phase = true;
    <?php } ?>
 

$(document).on("keyup","#bonusAmount",function(e){


    var total_amt=0;
       var amt_data= $(this).val();
       var amt =(isNanVal(amt_data))?0:parseFloat(amt_data); 
      
      total_amt=total_amt+amt;
      if(total_amt>parseFloat(max_deposit))
      { 
            $('.bonus-alert-message').html(max_deposit_mgs);
            $('#modalBonusAlert').modal('show');
            $(this).val(parseFloat(max_deposit));
            e.preventDefault();
            return false;
         
      }else{
      
    
              calBonus();
                url();
          }
});

$(document).on("change","#inputbonus_type",function(e){
    
      calBonus();
     url();
    
});

$(document).on("change","#inputbonus_type_ten",function(e){
    
     calBonus();
     url();
    
});



$(document).on("click",".btn-continue",function(e){

     showMessage(e);
    
});



function noBonusCheckBox()
{
  
          $('#yesBonusHolder').hide();           
           if($("#noBonus").is(':checked')) 
           {
               $('#yesBonusHolder').hide();
               bonusAtive = 0;
           }else{
                           
            
                $('#yesBonusHolder').show();
               bonusAtive = 1;
           }

            if($("#inputbonus_type").is(':checked')){
                bonusAtive = 1;
            } else {
                bonusAtive = 0;
            }


           calBonus();
           url();
    
}


 function calBonus(){
  
        
    var bonusType_data = 0;
    if($("#inputbonus_type").is(':checked')){
            bonusType_data = $('#inputbonus_type').val();
    }
  
    // if($("#inputbonus_type_ten").is(':checked')){
    //     bonusType_data = $('#inputbonus_type_ten').val();
    // }
   
   
   
   

               
               var bonusType = (isNanVal(bonusType_data))?0:parseFloat(bonusType_data);

                if(test_phase){
                    if($("#inputbonus_type_ten").is(':checked')){
                        var getAddBonus = $("#inputbonus_type_ten").val();
                        var tenPercent = (isNanVal(getAddBonus))?0:parseFloat(getAddBonus);
                        var withAdditionalBonus = bonusType + tenPercent;

                        bonusType = parseFloat(withAdditionalBonus);
                    }
                }
               
               var amt_data=$('#bonusAmount').val();
               var amt =(isNanVal(amt_data))?0:parseFloat(amt_data);       
        
                var bonusAmt = amt+((bonusType*amt)/100);

                
                bonusAmt =(isNanVal(bonusAmt))?0:parseFloat(bonusAmt);                    
                 
                $('#getValue').val(bonusAmt);

               
 }

    function url(){

        <?php if(IPLoc::VPN_IP_Jenalie()):?>
        console.log("FXMAIN-746: "+base_url);
        <?php endif;?>
 
	base_url=(base_url.charAt(base_url.length - 1)=="/")?base_url:base_url+"/";
  
               var url = payment_type;
              

                
                // var bonusType_data=$('#inputbonus_type').val();

                var bonusType_data = 0;
                
                if($("#inputbonus_type").is(':checked')){
                    bonusType_data = $('#inputbonus_type').val();
                }

                var additional_bonus = 0;
                if(test_phase){
                    if($("#inputbonus_type_ten").is(':checked')){
                        // bonusType_data = $('#inputbonus_type_ten').val();
                        additional_bonus = 1;
                    }
                }
                
               var bonusType =(isNanVal(bonusType_data))?0:parseFloat(bonusType_data);
                
               var amt_data=$('#bonusAmount').val();
               var amt =(isNanVal(amt_data))?0:parseFloat(amt_data);       
                 
               
                 switch (bonusType) {
                     case 30: bonusTypeTxt = 'tpb';                         
                         break;
                    case 20: bonusTypeTxt = 'twpb';                         
                         break;    
                   // case 10: bonusTypeTxt = 'tenpb';
                   //       break;
                     default:
                         break;
                 }
//console.log(base_url+payment_type+'?bonus='+bonusTypeTxt+'&amount1='+amt);
 

                 if(!$("#noBonus").is(':checked')){ 
                     if(bonusType>0){
                        // url = base_url+payment_type+'?bonus='+bonusTypeTxt+'&amount1='+amt;

                         //url = base_url+payment_type+'?bonus='+bonusTypeTxt+'&amount1='+amt+'&addBonus='+additional_bonus;
                         url = payment_type+'?bonus='+bonusTypeTxt+'&amount1='+amt+'&addBonus='+additional_bonus;
                         if(payment_type == 'deposit/zotapay'){
                           //  url = base_url+payment_type+'?bonus='+bonusTypeTxt+'&amount1='+amt+'&addBonus='+additional_bonus +'&type=cc';
                             url = payment_type+'?bonus='+bonusTypeTxt+'&amount1='+amt+'&addBonus='+additional_bonus +'&type=cc';
                         }

                     }else{

                         if(test_phase){
                    
                             if($("#inputbonus_type_ten").is(':checked')){
                                // url = base_url+payment_type+'?bonus=na&amount1='+amt+'&addBonus='+additional_bonus;
                                 url = payment_type+'?bonus=na&amount1='+amt+'&addBonus='+additional_bonus;
                                 if(payment_type == 'deposit/zotapay'){
                                   //  url = base_url+payment_type+'?bonus=na&amount1='+amt+'&addBonus='+additional_bonus+'&type=cc';
                                     url = payment_type+'?bonus=na&amount1='+amt+'&addBonus='+additional_bonus+'&type=cc';
                                 }

                             }else{
                                 
                                   url = payment_type+'?amount1='+amt;
                                 
                                if(payment_type == 'deposit/zotapay'){
                                   // url = base_url+payment_type+'?amount1='+amt+'&type=cc';
                                     url = payment_type+'?amount1='+amt+'&type=cc';
                                 }
                             }
                             
                            
                         }else{
                             //url = base_url+payment_type+'?amount1='+amt;
                             url = payment_type+'?amount1='+amt;
                             if(payment_type == 'deposit/zotapay'){
                                 //url = base_url+payment_type+'?amount1='+amt+'&type=cc';
                                  url = payment_type+'?amount1='+amt+'&type=cc';
                             }
                         }

                     }
                     
                    
                 }else{
                     url = payment_type;
                     if(payment_type == 'deposit/zotapay'){
                         url = base_url+payment_type+'?type=cc'
                     }

                 }
    
//console.log(url,"===========>");
url=base_url+url;
                 $(".btn-continue").attr('href',url);


            }
            
  

 
      function showMessage(e){
          
          
            
                var e_bonusAmount_data=$('#bonusAmount').val();
               var e_bonusAmount =(isNanVal(e_bonusAmount_data))?0:parseFloat(e_bonusAmount_data);
                
         

         if(!ptype) {
             var mgs = "Please select payment method.";
               $('.bonus-alert-message').html(mgs);
               $('#modalBonusAlert').modal('show'); 
               e.preventDefault();
               return false;
        }
        if(e_bonusAmount >  100000000){
            var mgs =max_deposit_mgs;
            $('.bonus-alert-message').html(mgs);
            $('#modalBonusAlert').modal('show');
            e.preventDefault();
            return false;
        }
        if(bonusAtive) {


          

            var min_amount_depo = parseFloat(payment_method_min_deposit[ptype]);

           if(e_bonusAmount < min_amount_depo){
               var mgs = "Please enter minimum deposit amount " + min_amount_depo + " ";

               if(ptype=='cryptocurrency'){
                   var mgs = "The minimum deposit is " + min_amount_depo + " USD/EUR";
               }

               $('.bonus-alert-message').html(mgs);
               $('#modalBonusAlert').modal('show');
               document.getElementById("bonusAmount").focus();
               e.preventDefault();
               return false;
           } 
       }

        // set url
        url();

          if(isSupporter) {
              $('.bonus-alert-message').html('Deposit is not allowed in this supporter account. You can only make deposits to your other accounts that is not a supporter account');
              $('#modalBonusAlert').modal('show');
              e.preventDefault();
              return false;
              
          }
          
         if(!IsStandardAccount && loginType !=1) {
             if (bonusAtive == 1 && bonusTypeTxt == 'fpb') {
                   $('.bonus-alert-message').html(dpst_msg9_50);
                   $('#modalBonusAlert').modal('show');
                   e.preventDefault();
                   return false;
             }
             
         } 
         
         
         if(bonus_selection=='ndb')
         {
              if(bonusAtive == 1) {
                    $('.bonus-alert-message').html(dpst_msg1);
                    $('#modalBonusAlert').modal('show');
                    e.preventDefault();
                     return false;
                }
             
         }
         else if(bonus_selection=='hdb')
         {
             
         }
         else if(bonus_selection=='tpb')
         {
             
               if(!isNewAccountType) 
               {
                        if (bonusType == 'twpb') 
                        {
                           
                        }
               }
         }



 
          if(bonus_selection != 'hdb'){
              if(bonusTypeTxt != bonus_selection)
              {
                  if(bonusAtive == 1) {

                      $('.bonus-alert-message').html(dpst_msg1);
                      $('#modalBonusAlert').modal('show');
                      e.preventDefault();
                      console.log(bonus_selection + bonusTypeTxt)
                      return false;

                  }


              }
          }

         
          
         
         
 } //show message end
 
 
 function isNanVal(amount){  
   amount=parseFloat(amount);
   return Number.isNaN(amount) ;
 
}
 
 
 
 
 
 
 
 /*
    // old programmer code...
    
        $(document).ready(function(){        
            calBonus();
           // var payment_type = base_url+"deposit/debit-credit-cards";
            $('.btn-img-payment').on("click", function(e){
            	
                payment_type = $(this).attr('data-url');
                url();
                 $('.btn-img-payment').removeClass('btn-highlight');
            	 $(this).addClass('btn-highlight');
                //  scroll to target
                var jump = $(this).attr('href');
                var new_position = $(jump).offset();
                $('html, body').stop().animate({ scrollTop: new_position.top }, 500);
                e.preventDefault();
            });         
            $('#noBonus').click(function(){ 
                $('#yesBonusHolder').hide();           
                if ($(this).is(':checked')) {
                    $('#yesBonusHolder').hide();
                    bonusAtive = 0;
                }else{
                    $('#yesBonusHolder').show();
                    bonusAtive = 1;
                }

                calBonus();
                url();
            });

            $('#bonusAmount').on('keyup',function(){
                calBonus();
                url();

            })

            $('#inputbonus_type').on('change',function(){
                calBonus();
                url();

            })

            

            function calBonus(){
                var bonusType = parseFloat( $('#inputbonus_type').val());
                var amt = parseFloat($('#bonusAmount').val());
                var bonusAmt = amt+((bonusType*amt)/100);
                if(isNaN(bonusAmt)){bonusAmt=0;}
                $('#getValue').val( parseFloat(bonusAmt));
            }

           function url(){
 
					base_url=(base_url.charAt(base_url.length - 1)=="/")?base_url:base_url+"/";


               var url = payment_type;
              
                var bonusType = $('#inputbonus_type').val();
                var amt = $('#bonusAmount').val();
                 
                 switch (bonusType) {
                     case '30': bonusTypeTxt = 'tpb';                         
                         break;
                    case '20': bonusTypeTxt = 'twpb';                         
                         break;    
                 
                     default:
                         break;
                 }

 

                 if(!$("#noBonus").is(':checked')){                   
                    url = base_url+payment_type+'?bonus='+bonusTypeTxt+'&amount1='+amt;
                 }else{
                     url = base_url+payment_type;
                 }

                 $(".btn-continue").attr('href',url);


            }




            function showMessage(e){
              //  if($isSupporter){?>
                $('.bonus-alert-message').html('Deposit is not allowed in this supporter account. You can only make deposits to your other accounts that is not a supporter account');
                $('#modalBonusAlert').modal('show');
                e.preventDefault();
                 // }



                 //if(!$IsStandardAccount && $loginType <> 1 ){?>
                if (bonusAtive == 1 && bonusTypeTxt == 'fpb') {
                    $('.bonus-alert-message').html('lang('dpst_msg9_50');');
                    $('#modalBonusAlert').modal('show');
                    e.preventDefault();
                }
                 //}


            

                 //if($bonus_selection == 'ndb'){ ?>
                if(bonusAtive == 1) {
                    $('.bonus-alert-message').html('lang('dpst_msg1');?>');
                    $('#modalBonusAlert').modal('show');
                    e.preventDefault();
                }
                 //}elseif($bonus_selection == 'hdb'){ ?>
              
                 //}elseif($bonus_selection == 'tpb'){ ?>

                    if(!isNewAccountType) {
                        if (bonus_type == 'twpb') {
                           
                        }
                    }


                 // } ?>
                if(bonus_type != '$bonus_selection?>'){
                    console.log(bonus_type)
                    console.log('=$bonus_selection?>');
                    if(bonusAtive == 1) {

                        $('.bonus-alert-message').html('lang('dpst_msg1');?>');
                        $('#modalBonusAlert').modal('show');
                        e.preventDefault();

                }

              
                }
            }

            $(".btn-continue").on("click",function(e){
                showMessage(e);
            })
            
        }) 
        
        */




    document.getElementById('bonusAmount').addEventListener('change', function (e) {
        if(this.value < 1){
            this.value = 0;
            $('#getValue').val('0');
        }
    });



    </script>