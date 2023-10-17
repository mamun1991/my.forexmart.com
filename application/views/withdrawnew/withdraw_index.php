<link type="text/css"  href="<?= $this->template->Css()?>deposit_finance_index_new.css" rel="stylesheet">

<?php
$this->load->view('finance_nav_new.php');
?>
<div class="col-sm-12 col-xs-12">
   


    <div style="margin-top: 15px;" class="row">
        <ul class="grp-list-payment">

 
            
                              <?php 
 
                              
                                if(FXPP::isPayomaPayMentAvailable('withdraw'))
                                {
                                ?>
            
                                 <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton01" data-url="withdrawtest/debit-credit-cards">
                                        <div class="img-holder"><span class="img-item img-debit-credit"></span></div>
                                       
										<div class="text-holder">
										<?= lang('trd_52');?> 
										</div>
										<label class="lbl-payment">Make A deposits</label>
                                    </a>
                                </li>

            
                                <?php }else if(FXPP::isZotapayPayMentAvailable()) {?>

                                
<!--                                  // FXPP-13853-->
<!--                                    <li>
                                        <a href="#bonusHolder" class="btn-img-payment" id="selectButton01" data-url="withdrawtest/zotapay-card" ptype="zotapay">
                                            <div class="img-holder"><span class="img-item img-mastercard"></span></div>
                                            <label class="lbl-payment">Withdraw via Mastercard</label>
                                        </a>
                                    </li>-->
                                <?php }?>
            
            

    


                             <?php if(FXPP::isIndonesianCountry() || IPLoc::Office()){ ?>

                                <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="withdrawtest/idr-local-bank-transfer">
                                        <div class="img-holder"><span class="img-item img-idr"></span></div>
                                        <div class="text-holder">
										<?= lang('with_07');?> 
										</div>
										<label class="lbl-payment">Make A deposits</label>
                                    </a>
                                </li>


                            <?php } ?>



                            <?php if(FXPP::isIndonesianCountry() || IPLoc::Office()){ ?>
                               
                               <li>
                                   <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="withdrawtest/local-depositor-idr">
                                       <div class="img-holder"><span class="img-item img-idr"></span></div>
                                       
									   <div class="text-holder">
										<?= lang('trd_47');?> 
										</div>
										<label class="lbl-payment">Make A deposits</label>
                                   </a>
                               </li>

                           <?php } ?>
                          

                            <?php if(FXPP::isMalaysianCountry()){ ?>
                                 <li>
                                        <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="withdrawtest/myr-local-bank-transfer">
                                            <div class="img-holder"><span class="img-item img-myr"></span></div>
											
									   <div class="text-holder">
										<?= lang('trd_50');?> 
										</div>
										<label class="lbl-payment">Make A deposits</label>
                                        </a>
                                   </li>

                            <?php } ?>

                                <?php if(!FXPP::isReferralsOfAccount('MYR')){ ?>
                                <?php if(FXPP::isMalaysianCountry()){ ?>
                                
                                <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton03" data-url="withdrawtest/local-depositor-myr">
                                        <div class="img-holder"><span class="img-item img-myr"></span></div>
										
										<div class="text-holder">
										<?= lang('trd_51');?> 
										</div>
										<label class="lbl-payment">Make A deposits</label>
                                    </a>
                                </li>
                            <?php }} ?>

                            <?php if(FXPP::isThailandCountry() || IPLoc::JustG()){ ?>
                                    <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="withdrawtest/thb-local-bank-transfer">
                                        <div class="img-holder"><span class="img-item img-myr"></span></div>
										
										<div class="text-holder">
										<?= lang('with_08');?> 
										</div>
										<label class="lbl-payment">Make A deposits</label>
                                    </a>
                                </li>

                            <?php } ?>

                            <?php if(IPLoc::JustG() || FXPP::isVietnamCountry()){ ?>
                               <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="withdrawtest/vnd-local-bank-transfer">
                                        <div class="img-holder"><span class="img-item img-vnd"></span></div>
										
										<div class="text-holder">
										<?= lang('with_09');?> 
										</div>
										<label class="lbl-payment">Make A deposits</label>
                                    </a>
                                </li>

                            <?php } ?>

                            <?php  if(FXPP::isNigerianCountry()) { ?>
                                <li>
                                    <a href="#bonusHolder" class="btn-img-payment" id="selectButton02" data-url="withdrawtest/bank-transfer-ngn">
                                        <div class="img-holder"><span class="img-item img-banktransfer"></span></div>
										
										<div class="text-holder">
										<?= lang('with_10');?> 
										</div>
										<label class="lbl-payment">Make A deposits</label>
                                    </a>
                                </li>

                            <?php } ?>




            <?php if(!FXPP::isEUClient()){?>
                            
                            <li>
                                <a href="#bonusHolder" class="btn-img-payment" id="selectButton04" data-url="withdrawtest/skrill">
                                    <div class="img-holder"><span class="img-item img-skrill"></span></div>
								
									<div class="text-holder">
									<?= lang('trd_53');?> 
									</div>
									<label class="lbl-payment">Make A deposits</label>
                                </a>
                            </li>


                            

                            <li>
                                <a href="#bonusHolder" class="btn-img-payment" id="selectButton05" data-url="withdrawtest/neteller">
                                    <div class="img-holder"><span class="img-item img-neteller"></span></div>
									
									<div class="text-holder">
									<?= lang('trd_54');?> 
									</div>
									<label class="lbl-payment">Make A deposits</label>
                                </a>
                            </li>
                            <?php }?>



            
            <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton06" data-url="withdrawtest/payco">
                    <div class="img-holder"><span class="img-item img-payco"></span></div>
					
					<div class="text-holder">
					<?= lang('trd_55');?> 
					</div>
					<label class="lbl-payment">Make A deposits</label>
                </a>
            </li>
            <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton07" data-url="withdrawtest/bitcoin">
                    <div class="img-holder"><span class="img-item img-bitcoin"></span></div>
					
					<div class="text-holder">
					<?= lang('trd_56');?> 
					</div>
					<label class="lbl-payment">Make A deposits</label>
                </a>
            </li>
            <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton08" data-url="withdrawtest/fasapay">
                    <div class="img-holder"><span class="img-item img-fasapay"></span></div>
					
					<div class="text-holder">
					<?= lang('trd_57');?> 
					</div>
					<label class="lbl-payment">Make A deposits</label>
                </a>
            </li>
                <?php if(!FXPP::isEUClient()){?>
            <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton09" data-url="withdrawtest/chinaunionpay">
                    <div class="img-holder"><span class="img-item img-union-pay"></span></div>
					
					<div class="text-holder">
					<?= lang('trd_58');?> 
					</div>
					<label class="lbl-payment">Make A deposits</label>
                </a>
            </li>
            <li>
                <a href="#bonusHolder" class="btn-img-payment" id="selectButton10" data-url="withdrawtest/alipay">
                    <div class="img-holder"><span class="img-item img-alipay"></span></div>
					
					<div class="text-holder">
					<?= lang('trd_59');?> 
					</div>
					<label class="lbl-payment">Make A deposits</label>
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