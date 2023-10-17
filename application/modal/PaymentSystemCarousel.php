<?php $this->lang->load('mdl_paymentsystemcarousel');?>
<div class="col-md-12 dep-main-holder" dir="ltr">
    <div class="deposits-holder">
        <h1><?=lang('pyc_1')?></h1>
        <div class="banks">
            <div id="demo">
                <div class="span12">
                    <div id="owl-demo" class="owl-carousel">

 

<?php 
// FXPP-13756


if(FXPP::isPayomaPayMentAvailable())
{?>
    
<div class="item">
    <a href="<?=$this->session->userdata('login_type') != 1? FXPP::loc_url('deposit?method=debit-credit-cards'): FXPP::loc_url('deposit/debit-credit-cards'); ?>">
        <img  class="lazyOwl visPay" data-src="<?= $this->template->Images()?>payment_getway_logo/debit-cards.png" alt="debit-cards" width="180" height="100"/>
    </a>
</div>    
                        
    
<?php }else if(FXPP::isZotapayPayMentAvailable()) {?>
    
<!--<div class="item">
    <a href="<?//$this->session->userdata('login_type') != 1? FXPP::loc_url('deposit?method=zotapay'): FXPP::loc_url('deposit/zotapay'); ?>">
        <img  class="lazyOwl zotapay" data-src="<?//$this->template->Images()?>mastercard.png" alt="mastercard" width="200" height="95"/>
    </a>
</div>   -->
<?php    
}
 ?>
                        
<?php                         

  if(FXPP::isReferralsOfAccount('IDR') || FXPP::isIndonesianCountry() || IPLoc::Office() || IPLoc::VPN_IP_Jenalie()){?>
                        
                        
<div class="item">
    <a href="<?=$this->session->userdata('login_type') != 1? FXPP::loc_url('deposit?method=idr-local-bank-transfer'): FXPP::loc_url('deposit/idr-local-bank-transfer'); ?>">
        <img  class="lazyOwl idr-local-bank-transfer" data-src="<?= $this->template->Images()?>payment_getway_logo/bca-idr.png" alt="idr-local-bank-transfer" width="180" height="120"/>
    </a>
</div>                           
 

<?php } ?>


 <?php if(IPLoc::JustG() || FXPP::isVietnamCountry()) { ?>

                        
<div class="item">
    <a href="<?=$this->session->userdata('login_type') != 1? FXPP::loc_url('deposit?method=vnd-local-bank-transfer'): FXPP::loc_url('deposit/vnd-local-bank-transfer'); ?>">
        <img  class="lazyOwl vnd-local-bank-transfer" data-src="<?= $this->template->Images()?>payment_getway_logo/vnd-cards.png" alt="vnd-local-bank-transfer" width="180" height="100"/>
    </a>
</div>                           
                        
    

<?php } ?>

 <?php if(!FXPP::isReferralsOfAccount('IDR')){ ?>
    <?php if(FXPP::isIndonesianCountry()){ ?>

                        
<div class="item">
    <a href="<?=$this->session->userdata('login_type') != 1? FXPP::loc_url('deposit?method=local-depositor-idr'): FXPP::loc_url('deposit/local-depositor-idr'); ?>">
        <img  class="lazyOwl local-depositor-idr" data-src="<?= $this->template->Images()?>payment_getway_logo/bca-idr.png" alt="local-depositor-idr" width="180" height="100"/>
    </a>
</div>                         
           

   <?php } }?>


 <?php if(FXPP::isMalaysianCountry()){ ?>
                               
<div class="item">
    <a href="<?=$this->session->userdata('login_type') != 1? FXPP::loc_url('deposit?method=myr-local-bank-transfer'): FXPP::loc_url('deposit/myr-local-bank-transfer'); ?>">
        <img  class="lazyOwl myr-local-bank-transfer" data-src="<?= $this->template->Images()?>payment_getway_logo/myr-cards.png" alt="myr-local-bank-transfer" width="180" height="100"/>
    </a>
</div>  
                        
     
<?php } ?>

                                
<?php if(!FXPP::isReferralsOfAccount('MYR')){ ?>
    <?php if(FXPP::isMalaysianCountry()){ ?>

<div class="item">
    <a href="<?=$this->session->userdata('login_type') != 1? FXPP::loc_url('deposit?method=local-depositor-myr'): FXPP::loc_url('deposit/local-depositor-myr'); ?>">
        <img  class="lazyOwl local-depositor-myr" data-src="<?= $this->template->Images()?>payment_getway_logo/myr-cards.png" alt="local-depositor-myr" width="180" height="100"/>
    </a>
</div>                          
         
    <?php }} ?>                              

                                
                                
<?php if(FXPP::isThailandCountry() || IPLoc::IPOnlyForG()){ ?>

<div class="item">
    <a href="<?=$this->session->userdata('login_type') != 1? FXPP::loc_url('deposit?method=thb-local-bank-transfer'): FXPP::loc_url('deposit/thb-local-bank-transfer'); ?>">
        <img  class="lazyOwl thb-local-bank-transfer" data-src="<?= $this->template->Images()?>payment_getway_logo/myr-cards.png" alt="thb-local-bank-transfer" width="180" height="100"/>
    </a>
</div>                          
 
<?php } ?>



<?php if(!FXPP::isEUClient()){?>

 <div class="item">
             <a href="<?=$this->session->userdata('login_type') != 1? FXPP::loc_url('deposit?method=skrill'): FXPP::loc_url('deposit/skrill'); ?>">
                 <img style="padding-left: 10px"  class="lazyOwl sklPay" data-src="<?= $this->template->Images()?>skrill.png" alt=" Skrill"  width="180" height="100"/>
             </a>
         </div>
       <div class="item">
           <a href="<?=$this->session->userdata('login_type') != 1? FXPP::loc_url('deposit?method=neteller') : FXPP::loc_url('deposit/neteller'); ?>">
               <img  class="lazyOwl netPay" data-src="<?= $this->template->Images()?>neteller.png" alt=" Neteller" width="180" height="100"/>
           </a>
       </div>
<?php }?>                        
                        


  <div class="item">
            <a href="<?=$this->session->userdata('login_type') != 1? FXPP::loc_url('deposit?method=payco') :FXPP::loc_url('deposit/payco'); ?>">
                <img class="lazyOwl payCo" data-src="<?= $this->template->Images()?>payco.png" alt=" PayCo" width="180" height="100"/>
            </a>
        </div>     
                        

   <div class="item">
         <a href="<?=$this->session->userdata('login_type') != 1? FXPP::loc_url('deposit?method=fasapay'):FXPP::loc_url('deposit/fasapay'); ?>">
             <img class="lazyOwl fpay"  data-src="<?= $this->template->Images()?>fasapay.png" width="180" height="100" alt="Fasapay">
         </a>
     </div> 
                        
     <div class="item">
         <a href="<?=$this->session->userdata('login_type') != 1? FXPP::loc_url('deposit?method=cryptocurrency'):FXPP::loc_url('deposit/cryptocurrency'); ?>">
             <img class="lazyOwl cryptocurrency"  data-src="<?= $this->template->Images()?>bitcoin.png" width="180" height="100"alt="cryptocurrency">
         </a>
     </div>                       

                       
 <?php if(FXPP::isMexicanCountry() || IPLoc::IPOnlyForVenus()){ ?>
                        

 <div class="item">
         <a href="<?=$this->session->userdata('login_type') != 1? FXPP::loc_url('deposit?method=bank-transfer-mxn'):FXPP::loc_url('deposit/bank-transfer-mxn'); ?>">
             <img class="lazyOwl bank-transfer-mxn"  data-src="<?= $this->template->Images()?>bank-mxn-logo.png" width="180" height="100" alt="bank-transfer-mxn">
         </a>
     </div>  
            
            <?php } ?>
            
            
                        
 <?php if(FXPP::isBrazilianCountry() || IPLoc::IPOnlyForVenus()){ ?>

   <div class="item">
         <a href="<?=$this->session->userdata('login_type') != 1? FXPP::loc_url('deposit?method=bank-transfer-brl'):FXPP::loc_url('deposit/bank-transfer-brl'); ?>">
             <img class="lazyOwl bank-transfer-brl"  data-src="<?= $this->template->Images()?>payment_getway_logo/bank-brl-logo.png" width="180" height="100" alt="bank-transfer-brl">
         </a>
     </div>  
                        
     <div class="item">
         <a href="<?=$this->session->userdata('login_type') != 1? FXPP::loc_url('deposit?method=bank-transfer-ngn'):FXPP::loc_url('deposit/bank-transfer-ngn'); ?>">
             <img class="lazyOwl bank-transfer-ngn"  data-src="<?= $this->template->Images()?>banktransfer.png" width="180" height="100" alt="bank-transfer-ngn">
         </a>
     </div>  
<?php } ?>  
                        
                            
 


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //if( $_SERVER['REMOTE_ADDR']==='120.29.75.242' || IPLoc::Office() ){ ?>
    <link rel='stylesheet' href='<?=$this->template->Css()?>additional-style.css'>
    <div class="col-md-12 account-types-holder">
        <div class="grp-items">

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <div class="item item-default">
                    <h2 class="item-title text-default">
                        <span class="subtitle"><?=lang('forexMart');?></span>
                        <div><?=lang('classic');?></div>
                    </h2>
                    <a class="btn-bordered bordered-default" href="<?php echo FXPP::www_url('account-type') ?>" target="_self"><?=lang('learn_more');?></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <div class="item item-primary">
                    <h2 class="item-title text-primary">
                        <span class="subtitle"><?=lang('forexMart');?></span>
                        <div><?=lang('pro');?></div>
                    </h2>
                    <a class="btn-bordered bordered-primary" href="<?php echo FXPP::www_url('account-type') ?>" target="_self"><?=lang('learn_more');?></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <div class="item item-success">
                    <h2 class="item-title text-success">
                        <span class="subtitle"><?=lang('forexMart');?></span>
                        <div><?=lang('cents');?></div>
                    </h2>
                    <a class="btn-bordered bordered-success" href="<?php echo FXPP::www_url('account-type') ?>" target="_self"><?=lang('learn_more');?></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <div class="item item-danger">
                    <h2 class="item-title text-danger">
                        <span class="subtitle"><?=lang('forexMart');?></span>
                        <div><?=lang('zero_spread');?></div>
                    </h2>
                    <a class="btn-bordered bordered-danger" href="<?php echo FXPP::www_url('account-type') ?>" target="_self"><?=lang('learn_more');?></a>
                </div>
            </div>
        </div>
    </div>
<?php// }?>

<script>
    $(function(){
        $("#owl-demo").owlCarousel({
            navigationText: ["<?=lang('pyc_2');?>","<?=lang('pyc_3');?>"],
            items : 4,
            lazyLoad : true,
            navigation : true,
            autoPlay: 3000, //Set AutoPlay to 3 seconds
        });
//        console.log( $(".owl-prev").text());
//        console.log( $(".owl-next").text());
//        $(".owl-prev").text("<?//=lang('pyc_2');?>//");
//        $(".owl-next").text("<?//=lang('pyc_3');?>//");
//        $("div.owl-prev").replaceWith("<?//=lang('pyc_2');?>//");
//        $("div.owl-next").replaceWith("<?//=lang('pyc_3');?>//");
    });
</script>