<?php $this->lang->load('email_footer');?>


<?php 

$this->load->view('email/_email_footer_v2');

if(false){

?>


<div style="position: relative; border-top: 1px solid #2988ca; background-image: url(<?=base_url()?>assets/images/univ-bg-footer1.png); padding: 20px;padding-top: 5px;">
    <div style="width: 100%;padding: 0;">
        <p style="line-height: 15px;color: #656565;font-size: 13px;text-align: justify;">

            <?php if(FXPP::isEUUrl()){ ?>
            
                <span style="font-weight: bold; color: #ff0000;"><?=lang('ema_foo_01');?>:</span> <?=lang('ema_foo_02');?>.<br><br>
                <span class="span-label-blue" style="color: #2988ca;font-weight: bold;"> <?=lang('ema_foo_03');?></span> <?=lang('ema_foo_04');?>
                <img class="tradomart-ltd" src="<?=base_url()?>assets/images/tradomart/instant-trading-eu-ltd.png" width="126" height="11" style="margin-bottom: -3px;">.<br><br>
                
                     <span class="span-label-blue" style="color: #2988ca;font-weight: bold;"> <?=lang('ema_foo_03');?></span>  <?=lang('ema_foo_07');?>
            <br> <br><span class="span-label-blue" style="color: #2988ca;font-weight: bold;"> <?=lang('ema_foo_ru');?></span><?=lang('ema_foo_10');?>
                
            <?php }else{ ?>
              
                
          <span class="span-label-blue" style="color: #2988ca;font-weight: bold;"><?= lang('new_ema_foo_01'); ?></span> <?= lang('new_with_foo_01'); ?>
                 <br> <br>
                 <?= lang('new_with_foo_02'); ?> <b><?= lang('new_with_foo_03'); ?></b> <?= lang('new_with_foo_04'); ?>
                 <br>
                <?= lang('new_with_foo_05'); ?> <b><?= lang('new_with_foo_03'); ?></b> <?= lang('new_with_foo_06'); ?>
                <br><br>
                 <span style="font-weight: bold; color: #ff0000;"><?=lang('ema_foo_01');?></span> <?=lang('new_ema_foo_12');?> 
                
                
				<?php /*?><?= lang('new_ema_foo_04'); ?>    <span style="font-weight: bold; color: #000;">Tradomart SV Ltd</span> <?= lang('new_ema_foo_05'); ?><span style="font-weight: bold; color: #000;">Tradomart SV Ltd</span>
                <?= lang('new_ema_foo_06'); ?> <span class="span-label-blue" style="color: #2988ca;font-weight: bold;"><?= lang('new_ema_foo_01'); ?></span>.<?= lang('new_ema_foo_07'); ?><span class="span-label-blue" style="color: #2988ca;font-weight: bold;"><?= lang('new_ema_foo_01'); ?></span>
                <?= lang('new_ema_foo_08'); ?>  <span style="font-weight: bold; color: #000;">Instant Trading EU Ltd (CY)</span> <?= lang('new_ema_foo_09'); ?><a href="<?=FXPP::www_url('License');?>">266/15</a><?= lang('new_ema_foo_10'); ?> <a href="https://www.forexmart.eu/"><span class="span-label-blue" style="color: #2988ca;font-weight: bold;"><?= lang('new_ema_foo_02'); ?></span></a>.
                <?php */?>
                 
                
            <?php } ?>
       
            <br><br>
            <p style="line-height: 15px;color: #656565;font-size: 13px;text-align: justify;">&copy; 2015-<?= date('Y'); ?>
            <?php if(FXPP::isEUUrl()){?>
                <img class="tradomart-ltd" alt="" src="<?=base_url()?>assets/images/tradomart/instant-trading-eu-ltd.png" width="126" height="11" style="margin-bottom: -2px;">
            <?php }else{?>
                <span style="font-weight: bold; color: #000;">Tradomart SV Ltd</span>
            <?php }?>
        </p>
    </div>
    <div class="footer-payment-systems" style="width: 100%;display: table;margin: 0 auto;float: none!important;">
<!--        <div class="first-liner-footer-payment">-->
<!--            <div class="footer-payment-sys-child-new" style="width: 16.66%;float: left;display: table;">-->
<!--                <img src="--><?//=base_url()?><!--assets/images/cysec1.png" class="img-responsive" style="max-width: 80%;display: table;margin: 0 auto;">-->
<!--            </div>-->
<!--            <div class="footer-payment-sys-child-new" style="width: 16.66%;float: left;display: table;">-->
<!--                <img src="--><?//=base_url()?><!--assets/images/fca1.png" class="img-responsive" style="max-width: 80%;display: table;margin: 0 auto;">-->
<!--            </div>-->
<!--            <div class="footer-payment-sys-child-new" style="width: 16.66%;float: left;display: table;">-->
<!--                <img src="--><?//=base_url()?><!--assets/images/autorite1.png" class="img-responsive" style="max-width: 80%;display: table;margin: 0 auto;">-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="first-liner-footer-payment">-->
<!--            <div class="footer-payment-sys-child-new" style="width: 16.66%;float: left;display: table;">-->
<!--                <img src="--><?//=base_url()?><!--assets/images/mifid1.png" class="img-responsive" style="max-width: 80%;display: table;margin: 0 auto;">-->
<!--            </div>-->
<!--            <div class="footer-payment-sys-child-new" style="width: 16.66%;float: left;display: table;">-->
<!--                <img src="--><?//=base_url()?><!--assets/images/bafin1.png" class="img-responsive" style="max-width: 80%;display: table;margin: 0 auto;">-->
<!--            </div>-->
<!--            <div class="footer-payment-sys-child-new" style="width: 16.66%;float: left;display: table;">-->
<!--                <img src="--><?//=base_url()?><!--assets/images/consob1.png" class="img-responsive" style="max-width: 80%;display: table;margin: 0 auto;">-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>
<!--<div class="wrapper-unsubscribe-link" style="width: 100%;padding: 7px 0px;background: #e7e7e7;text-align: center;">
    <a href="javascript:;" style="text-decoration: underline;font-size: 12px;color: #565656;">Unsubscribe this email</a>
</div>-->

</div>
</div>

</body>
</html>

            <?php } ?>