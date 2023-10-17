<link type="text/css"  href="<?= $this->template->Css()?>deposit_finance_index.css" rel="stylesheet">

<?php
$this->load->view('finance_nav.php');
?>
<div class="col-sm-12 col-xs-12">
   


    <div style="margin-top: 15px;" class="">
        <ul class="grp-list-payment">

 
            <?php 
if(IPLoc::Office() or FXPP::getAllowAccounts()){
?>
<li>
  <a href="#bonusHolder" class="btn-img-payment" id="selectButton00" data-url="withdraw/thunderXPay" ptype="thunderXPay">
      <div class="img-holder"><span class="img-item img-thunderxpay"></span></div>
      <label class="lbl-payment">Withdraw via ThunderXPay</label>
  </a>
</li>

<?php 
}
?>                                   
    
            
            
            
                              <?php 
 
                              
                                if(FXPP::isPayomaPayMentAvailable('withdraw'))
                                {
                                ?>
            
                                 <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton01" data-url="withdraw/debit-credit-cards">
                                        <div class="img-holder"><span class="img-item img-debit-credit"></span></div>
                                        <label class="lbl-payment"><?= lang('trd_52');?></label>
                                    </a>
                                </li>

            
                                <?php } ?>

                                
                                <?php  if(FXPP::isPaymentMethodAvailable('ZOTAPAY_CARD')) { ?>
                           

                                <li>
                                        <a href="#bonusHolder" class="btn-img-payment" id="selectButton01" data-url="withdraw/zotapay-card" ptype="zotapay">
                                            <div class="img-holder"><span class="img-item img-mastercard"></span></div>
                                            <label class="lbl-payment">Withdraw via Mastercard</label>
                                        </a>
                                    </li>
                                    
                             <?php } ?>

                             <?php  if(FXPP::isPaymentMethodAvailable('NOVA2PAY')) { ?>
                           

                               <li>
                                   <a href="#bonusHolder" class="btn-img-payment" id="selectButton01" data-url="withdraw/nova2pay" ptype="nova2pay">
                                       <div class="img-holder"><span class="img-item img-mastercard"></span></div>
                                       <label class="lbl-payment">Withdraw via Mastercard</label>
                                   </a>
                               </li>
                               
                           <?php } ?>
     
            
                    


                             <?php if(FXPP::isIndonesianCountry() || IPLoc::Office()){ ?>

                                <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="withdraw/idr-local-bank-transfer">
                                        <div class="img-holder"><span class="img-item img-idr"></span></div>
                                        <label class="lbl-payment"><?= lang('with_07');?></label>
                                    </a>
                                </li>


                            <?php } ?>



                            <?php if(FXPP::isIndonesianCountry() || IPLoc::Office()){ ?>
                               
                               <li>
                                   <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="withdraw/local-depositor-idr">
                                       <div class="img-holder"><span class="img-item img-idr"></span></div>
                                       <label class="lbl-payment"><?= lang('trd_47'); ?></label>
                                   </a>
                               </li>

                           <?php } ?>
                          

                            <?php if(FXPP::isMalaysianCountry()){ ?>
                                 <li>
                                        <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="withdraw/myr-local-bank-transfer">
                                            <div class="img-holder"><span class="img-item img-myr"></span></div>
                                            <label class="lbl-payment"><?= lang('trd_50'); ?></label>
                                        </a>
                                   </li>

                            <?php } ?>

                                <?php if(!FXPP::isReferralsOfAccount('MYR')){ ?>
                                <?php if(FXPP::isMalaysianCountry()){ ?>
                                
                                <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton03" data-url="withdraw/local-depositor-myr">
                                        <div class="img-holder"><span class="img-item img-myr"></span></div>
                                        <label class="lbl-payment"><?=lang('trd_51');?></label>
                                    </a>
                                </li>
                            <?php }} ?>

                            <?php if(FXPP::isThailandCountry() || IPLoc::JustG()){ ?>
                                    <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="withdraw/thb-local-bank-transfer">
                                        <div class="img-holder"><span class="img-item img-myr"></span></div>
                                        <label class="lbl-payment"><?= lang('with_08');?></label>
                                    </a>
                                </li>

                            <?php } ?>

                            <?php if(IPLoc::JustG() || FXPP::isVietnamCountry()){ ?>
                               <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="withdraw/vnd-local-bank-transfer">
                                        <div class="img-holder"><span class="img-item img-vnd"></span></div>
                                        <label class="lbl-payment"><?= lang('with_09');?></label>
                                    </a>
                                </li>

                            <?php } ?>

                            <?php  if(FXPP::isNigerianCountry()) { ?>
                                <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="withdraw/bank-transfer-ngn">
                                        <div class="img-holder"><span class="img-item img-banktransfer"></span></div>
                                        <label class="lbl-payment"><?= lang('with_10');?></label>
                                    </a>
                                </li>

                            <?php } ?>




            <?php if(!FXPP::isEUClient()){?>
                            
                            <li>
                                <a href="#bonusHolder" class="btn-img-payment" id="selectButton04" data-url="withdraw/skrill">
                                    <div class="img-holder"><span class="img-item img-skrill"></span></div>
                                    <label class="lbl-payment"><?= lang('trd_53');?></label>
                                </a>
                            </li>


                            

                            <li>
                                <a href="#bonusHolder" class="btn-img-payment" id="selectButton05" data-url="withdraw/neteller">
                                    <div class="img-holder"><span class="img-item img-neteller"></span></div>
                                    <label class="lbl-payment"><?= lang('trd_54'); ?></label>
                                </a>
                            </li>
                            <?php }?>



            
            <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton06" data-url="withdraw/payco">
                    <div class="img-holder"><span class="img-item img-payco"></span></div>
                    <label class="lbl-payment"><?= lang('trd_55');?></label>
                </a>
            </li>
            <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton07" data-url="withdraw/bitcoin">
                    <div class="img-holder"><span class="img-item img-bitcoin"></span></div>
                    <label class="lbl-payment"><?= lang('trd_56');?></label>
                </a>
            </li>
            <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton08" data-url="withdraw/fasapay">
                    <div class="img-holder"><span class="img-item img-fasapay"></span></div>
                    <label class="lbl-payment"><?= lang('trd_57');?></label>
                </a>
            </li>
                <?php if(!FXPP::isEUClient()){?>
            <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton09" data-url="withdraw/chinaunionpay">
                    <div class="img-holder"><span class="img-item img-union-pay"></span></div>
                    <label class="lbl-payment"><?= lang('trd_58');?></label>
                </a>
            </li>
            <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton10" data-url="withdraw/alipay">
                    <div class="img-holder"><span class="img-item img-alipay"></span></div>
                    <label class="lbl-payment"><?=lang('trd_59');?></label>
                </a>
            </li>
                <?php }?>
        </ul>
        <div class="bonus-holder" id="bonusHolder">
            <form class="form-horizontal form-bonus">
               
                <a class="btn btn-continue btn-center" href="#"><?= lang('with-p-05');?></a>
            </form>
        </div>
    </div>
</div>

<script>

    var base_url = "<?php echo FXPP::loc_url();?>";
    var bonusAtive = 1;
    var bonusTypeTxt = '';
    var url ='';
        $(document).ready(function(){        
            
           
            $('.btn-img-payment').on("click", function(e){
            	
                payment_type = $(this).attr('data-url');
                base_url=(base_url.charAt(base_url.length - 1)=="/")?base_url:base_url+"/";
                     url = base_url+payment_type;
                 $(".btn-continue").attr('href',url);
                 $('.btn-img-payment').removeClass('btn-highlight');
            	 $(this).addClass('btn-highlight');
                //  scroll to target
                var jump = $(this).attr('href');
                var new_position = $(jump).offset();
                $('html, body').stop().animate({ scrollTop: new_position.top }, 500);
                e.preventDefault();
            });    
           
        })     
    </script>