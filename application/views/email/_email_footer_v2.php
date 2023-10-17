

    <?php $this->lang->load('email_footer');?>


    </div>



    <div class="footer" style="font-family: 'Open Sans',sans-serif; color:#addcfd; background: #06477b; padding-top: 5px; padding-bottom: 5px; padding-left: 20px; padding-right: 20px; text-align: justify">
        <div class="sponsorlogo-contact-holder" style="display: inline-block; width: 100%">
            <div class="sponsorship-logo-holder" style="display:inline-block; padding-top: 20px;">
                <a href="http://forexmart.com/" target="_blank"  style=" text-decoration: none; color:#0071d9;" >
                    <img src="https://www.forexmart.com/assets/images/fm-logo-sponsorship-blue.png" class="logos img-responsive">
                </a>
            </div>
            <div class="contact-holder" style="display:inline-block;float:right;text-align:right;">
                <ul style="list-style-type:none;">
                    <li style="font-size:12px; color: #addcfd">Phone: <b>443 300 104 195</b></li>
                    <li style="font-size:12px; color:#addcfd;">Email: <b><a style="text-decoration: none; color:#addcfd" href="mailto:support@forexmart.com" target="_blank">support@forexmart.com</a></b></li>
                    <li>
                        <ul class="social" style="margin-top:2px; margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;width:100%;text-align:right;list-style-type:none; font-size: 12px; color: #addcfd " >Follow us :

                            <li style="display:inline-block;font-size:12px; color: #addcfd" ><a href="https://www.facebook.com/forexmartofficial"><img alt="" height="16px"  src="https://www.forexmart.com/assets/images/icon-facebook-white.png" alt=""></a></li>
                            <li style="display:inline-block;font-size:12px; color: #addcfd" ><a href="https://twitter.com/ForexMartPage"><img alt="" height="16px" src="https://www.forexmart.com/assets/images/icon-twitter-white.png" alt=""></a></li>
                            <li style="display:inline-block;font-size:12px; color: #addcfd" ><a href="https://telegram.me/ForexMart_bot"><img alt=""  height="15px" src="https://www.forexmart.com/assets/images/fm-icon-telegram.png" alt=""></a></li>

                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <hr style="border-width:0.5px;border-style:solid;border-color:rgba(22,155,250,.2);" >
        <h5 style="text-align:center;" ><a href="https://www.forexmart.com/assets/pdf/Tradomart-SV/Terms%20and%20Conditions.pdf" style="color:#addcfd;font-weight:500;" >Terms and Condition</a> | <a href="https://www.forexmart.com/assets/pdf/Tradomart-SV/Privacy%20Policy.pdf" style="color:#addcfd;font-weight:500;" >Privacy Policy</a></h5>
        <p style="font-family:'Open Sans', sans-serif;font-size:10px;"><?= lang('new_ema_foo_01'); ?> <?= lang('new_with_foo_01'); ?></p>

        <p style="font-family:'Open Sans', sans-serif;font-size:10px;"><?= lang('new_with_foo_02'); ?> <?= lang('new_with_foo_03'); ?> <?= lang('new_with_foo_04'); ?> </p>

        <p style="font-family:'Open Sans', sans-serif;font-size:10px;"><?= lang('new_with_foo_05'); ?> <?= lang('new_with_foo_06'); ?> </p>

        <p style="font-family:'Open Sans', sans-serif;font-size:10px;"><?= lang('ema_foo_01'); ?>: <?=lang('new_ema_foo_12');?></p>


        <br>

        <hr style="border-width:0.5px;border-style:solid;border-color:rgba(22,155,250,.2);" >

        <div class="copyright">

            <p style="font-family:'Open Sans', sans-serif;text-align:center;font-size:11px;font-weight:600;">&copy; 2015-<?php echo date('Y')?> <b><?php echo lang('email_footer_11'); ?></b>
        </div>
    </div>
    </div>


    </body>
    </html>








    <?php

    //old

    /*




    <?php $this->lang->load('email_footer');?>


    </div>
    <hr style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgba(0,0,0,.1);width: 800px;margin: 10px auto;">
    <div class="footer" style="display:table;font-family:'Open Sans',sans-serif;font-size:14px;text-align:justify;color:#222;margin: 0 auto;padding-bottom:10px;padding-top:10px;max-width: 800px;">
        <div class="btn-trading-holder" style="width:100%;text-align:center;">
            <a href="<?php echo FXPP::my_url('deposit') ?>">
                <div class="btn-deposit" style="display:inline-block;width:calc(100% / 3.03);text-align:center;vertical-align:middle;-webkit-transition:.3s ease-in-out;transition:.3s ease-in-out;color:#fff;background-color:#2988ca;outline-color:#fff;outline-style:solid;outline-offset:-5px;">
                    <h4 style="font-size:16px;font-weight:500;">Deposit</h4>
                </div>
            </a>
            <a href="<?php echo FXPP::loc_url('register') ?>" target="_blank">
                <div class="btn-buy" style="display:inline-block;width:calc(100% / 3.03);text-align:center;vertical-align:middle;-webkit-transition:.3s ease-in-out;transition:.3s ease-in-out;background-color:#29a643;outline-color:#fff;outline-style:solid;outline-offset:-5px;color:#fff;">
                    <h4 style="font-size:16px;font-weight:500;">Get started today</h4>
                </div>
            </a>
            <a href="<?php echo FXPP::loc_url('') ?>" target="_blank">
                <div class="btn-sell" style="display:inline-block;width:calc(100% / 3.03);text-align:center;vertical-align:middle;-webkit-transition:.3s ease-in-out;transition:.3s ease-in-out;background-color:#cf2323;outline-color:#fff;outline-style:solid;outline-offset:-5px;color:#fff;">
                    <h4 style="font-size:16px;font-weight:500;">Find out details</h4>
                </div>
            </a>
        </div>
        <hr style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgba(0,0,0,.1);">
        <div class="footer-bottom" style="width:100%;text-align:center;padding-top:20px;padding-bottom:20px;">
            <div class="our-partner" style="display:inline-block;width:calc(100% / 3.2);text-align:center;vertical-align:top;">
                <h4>OUR PARTNER</h4>
                <a href="#" class="partner"><img alt="" src="<?= base_url() ?>assets/images/sponsorshiplogo.png" class="sponsorship-logo" style="width:120px;-webkit-filter:grayscale(100%);filter:grayscale(100%);-webkit-transition:.3s ease-in-out;transition:.3s ease-in-out;"></a>
            </div>
            <div class="follow-us" style="display:inline-block;width:calc(100% / 3.2);text-align:center;vertical-align:top;">
                <h4>FOLLOW US</h4>
                <ul class="social" style="padding-inline-start:0;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;width:100%;text-align:center;">
                    <li style="display:inline-block;margin-left: 0 !important;"><a href="https://www.facebook.com/ForexMart" style="display:inline-block;line-height:60px;width:50px;height:50px;border-radius:30px;background-color:#777;margin-top:0;margin-bottom:3px;margin-right:3px;margin-left:0;"><img src="<?= FXPP::www_url() ?>assets/images/icon-facebook-white.png" width="20"/></a></li>
                    <li style="display:inline-block;margin-left: 0 !important;"><a href="https://twitter.com/ForexMartPage" style="display:inline-block;line-height:60px;width:50px;height:50px;border-radius:30px;background-color:#777;margin-top:0;margin-bottom:3px;margin-right:3px;margin-left:0;"><img src="<?= FXPP::www_url() ?>assets/images/icon-twitter-white.png" width="20"/></a></li>
                    <!-- <li style="display:inline-block;margin-left: 0 !important;"><a href="https://plus.google.com/+Forexmartpage" style="display:inline-block;line-height:60px;width:50px;height:50px;border-radius:30px;background-color:#777;margin-top:0;margin-bottom:3px;margin-right:3px;margin-left:0;"><img src="<?//= FXPP::www_url() ?>assets/images/icon-google-plus-white.png" width="20"/></a></li>-->
                    <?php if(FXPP::isMalaysianCountry()){ ?>
                        <li style="display:inline-block;margin-left: 0 !important;"><a href="https://t.me/forexmartmalaysia" style="display:inline-block;line-height:60px;width:50px;height:50px;border-radius:30px;background-color:#777;margin-top:0;margin-bottom:3px;margin-right:3px;margin-left:0;">
                                <img alt="Telegram logo" style="background-size:contain!important;display:inline-block;height:18px;width:23px;" src="<?= FXPP::www_url() ?>assets/images/fm-icon-telegram.png"/>
                            </a>
                        </li>
                    <?php } else if(FXPP::isIndonesianCountry()) {?>
                        <li style="display:inline-block;margin-left: 0 !important;"><a href="https://t.me/forexmartindonesia" style="display:inline-block;line-height:60px;width:50px;height:50px;border-radius:30px;background-color:#777;margin-top:0;margin-bottom:3px;margin-right:3px;margin-left:0;">
                                <img alt="Telegram logo" style="background-size:contain!important;display:inline-block;height:18px;width:23px;" src="<?= FXPP::www_url() ?>assets/images/fm-icon-telegram.png"/>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="trade-anywhere" style="display:inline-block;width:calc(100% / 3.2);text-align:center;vertical-align:top;margin-left:30px;">
                <h4>TRADE ANYWHERE</h4>
                <a href="https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4" class="gplay"><img alt="" src="<?= base_url() ?>assets/images/googleplay.png" class="trade-img" style="width:120px;display:inline-block;opacity:.5;-webkit-transition:.3s ease-in-out;transition:.3s ease-in-out;"></a>
                <a href="https://itunes.apple.com/app/metatrader-4/id496212596?l=en&mt=8" class="appstore"><img  alt="" src="<?= base_url() ?>assets/images/appstore.png" class="trade-img" style="width:120px;display:inline-block;opacity:.5;-webkit-transition:.3s ease-in-out;transition:.3s ease-in-out;"></a>
            </div>

        </div>
        <div class="footer-warning">
            <p style="font-size:13px;"> <span class="span-label-blue" style="color: #2988ca;font-weight: bold;"><?= lang('new_ema_foo_01'); ?></span> <?= lang('new_with_foo_01'); ?></p>
            <p style="font-size:13px;">  <?= lang('new_with_foo_02'); ?> <b><?= lang('new_with_foo_03'); ?></b> <?= lang('new_with_foo_04'); ?> </p>
            <p style="font-size:13px;"><?= lang('new_with_foo_05'); ?> <b><?= lang('new_with_foo_03'); ?></b> <?= lang('new_with_foo_06'); ?></p>
            <p style="font-size:13px;"> <span style="font-weight: bold; color: #ff0000;"><?=lang('ema_foo_01');?></span> <?=lang('new_ema_foo_12');?> </p>
            <p style="font-size:13px;">&copy; 2015-<?php echo date('Y')?> <b><?php if(FXPP::isEUUrl()){?>
                        <img alt="" class="tradomart-ltd" alt="" src="<?=base_url()?>assets/images/tradomart/instant-trading-eu-ltd.png" width="126" height="11" style="margin-bottom: -2px;">
                    <?php }else{?>
                        <span style="font-weight: bold; color: #000;"><?php echo FXPP::companyName();?></span>

                    <?php }?></b>.
                <!-- <a href="#" class="unsubscribe" style="color:#999;float:right;" >Unsubscribe this email</a> -->
            </p>
        </div>
    </div>
    </div>
    </body>

    </html>







*/ ?>





