

<?php $this->lang->load('footer');?>


<footer style="background: #fbfafa;" xmlns="http://www.w3.org/1999/html">
    <div class="container arabic-container arabic-container-footer">
        <style type="text/css">.tradomart{margin-bottom:3px;padding:0!important}.fix-lbl{color:#fff!important}
            .logoLink{
                margin-bottom:20px;
                text-align: center;
            }
            .logoLink a{
                display: inline-block;
                padding: 10px 7px;
                vertical-align: text-bottom;
            }
            .logoLink a img{
                height: 67px;
            }
            .logoLink a{
                margin-right: 40px;
            }
            .ftr-logo {
                color: #000;
                font-weight: 700;
            }
            @media only screen and (max-width: 768px) {
                .copyCust{
                    padding-left: 15px !important;
                }
            }
        </style>
        <div class="row ext-arabic-footer-row ">
            
            <div class="col-sm-12 col-md-12 col-lg-12 sec logoLink" style="margin-bottom: 0">
               <!-- <a href="https://www.forexmart.com/cysec"><img src="<?/*= $this->template->Images()*/?>cysec.png" class="img-responsive"></a>
                <a href="http://ec.europa.eu/finance/securities/isd/mifid/index_en.htm"><img src="<?/*= $this->template->Images()*/?>mifid.png" class="img-responsive "></a>-->
               <!-- <a href="https://www.forexmart.com/bafin"><img src="<?/*= $this->template->Images()*/?>bafin.png" class="img-responsive"></a>
                <a href="https://www.forexmart.com/amf"><img src="<?/*= $this->template->Images()*/?>amf.png" class="img-responsive"></a>
                <a href="https://www.forexmart.com/fca"><img src="<?/*= $this->template->Images()*/?>fca.png" class="img-responsive"></a>
                <a href="https://www.forexmart.com/consob"><img src="<?/*= $this->template->Images()*/?>consob.png" class="img-responsive"></a>-->
            </div>


            <div class="col-lg-9 col-md-9 col-sm-9 ext-arabic-footer-text-parent" style="width:100%!important;">
                    <p class="footer-text ext-arabic-footer-text" style="margin-top: 0">

                        <!-- .com Footer  -->
                        <?php  if(FXPP::isEUUrl()){ ?>
                            <span class="company"><?= lang('pn2-1'); ?></span><?= lang('pn2-6'); ?>
                            <?php if(!IPLoc::isEuropeanIP()){?>
                                <span class="ftr-logo"><?php echo FXPP::companyName();?></span>
                            <?php }else{?>
                               <!-- <img alt="" width="101" height="10" src="<?/*= $this->template->Images() */?>tradomart/instant-trading-eu-ltd.png" alt="" class="trademart">-->
                                <span class="ftr-logo"><?php echo FXPP::companyName();?></span>
                            <?php }?>
                            <?php echo lang('pn2-7_2-eu-2'); ?>
                            <br><br>

                        <?php }else{ ?>
                         
                            <!-- .eu Footer  -->
                              
                               
                             <span class="company "><?= lang('pn1-1'); ?></span>
							 <?= lang('new_with_foo_04'); ?><br><br> <?= lang('new_with_foo_02'); ?> <span class="ftr-logo"><?php echo FXPP::companyName();?></span>  <?= lang('new_with_foo_04'); ?><br>
                        <?= lang('new_with_foo_05'); ?> <span class="ftr-logo"><?php echo FXPP::companyName();?></span>
                        <?= lang('new_with_foo_06'); ?>  <br><br>
				  
                             <?php /*?>   <span class="company"><?= lang('eu-site'); ?></span><?= lang('footer-01'); ?>  <span class="ftr-logo"><?php echo FXPP::companyName();?></span> <?= lang('footer-02'); ?><span class="ftr-logo"><?php echo FXPP::companyName();?></span>
                            <?= lang('footer-03'); ?> <span class="company"><?= lang('pn1-1'); ?></span>. <br><br>
							  <?php */?>
							  
							    
                            <cite>
                                <?= lang('gen-rw'); ?>
                            </cite>
                            <?= lang('footer-gen-risk'); ?>
                            
                        <?php } ?>
                
                
            </div>
        </div>
    </div>
    </div>
</footer>
<div id="loader-holder" class="loader-holder">
    <div class="loader">
        <div class="loader-inner ball-pulse">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>

<?php if (IPLoc::Office()) { ?>

    <div class="copyright-holder">
        <div class="container">
<!--            <div class="row" style="margin-left: 0px !important; margin-right: 0px !important; margin-top: -15px;">-->
                <div class="row" style="margin-top: -15px;">
                <div class="col-md-9 copy coprig ext-arabic-footer-copy sa-right copyCust" style="font-size: 13px;  padding-left: 0;  font-weight: 300; color: #6a6a6a; margin-top: 15px; display: block; text-align: left;" >
                     <p> &nbsp;&nbsp; &copy; 2015-<?=date('Y');?>

                        <span class="ftr-logo"><?php echo FXPP::companyName();?></span>


                </div>
                <div class="col-md-3 social-media-holder sosmed ext-arabic-footer-social-media">
                    <ul class="social-media" style="    list-style: none;    padding: 0;    text-align: center;">
                        <?php if(FXPP::html_url()=='ru'){ ?>
                            <li style="    display: inline-block;"><a style="    padding: 7px 10px;    display: block;    font-size: 20px;    color: #2988CA;    transition: all ease .3s; " href="https://www.facebook.com/forexmartru" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li style="    display: inline-block;"><a style="    padding: 7px 10px;    display: block;    font-size: 20px;    color: #2988CA;    transition: all ease .3s; " href="https://twitter.com/ForexMartRu" target="_blank"><i class="fa fa-twitter"></i></a></li>
                            <li style="    display: inline-block;"><a style="    padding: 7px 10px;    display: block;    font-size: 20px;    color: #2988CA;    transition: all ease .3s; " href="https://vk.com/forexmart" target="_blank"><i class="fa fa-vk"></i></a></li>
                            <?php /**<li style="    display: inline-block;"><a style="    padding: 7px 10px;    display: block;    font-size: 20px;    color: #2988CA;    transition: all ease .3s; " href="https://plus.google.com/communities/111804080179853814370" target="_blank"><i class="fa fa-google-plus"></i></a></li>*/?>
                        <?php }else{ ?>
                            <li style="    display: inline-block;"><a style="    padding: 7px 10px;    display: block;    font-size: 20px;    color: #2988CA;    transition: all ease .3s; " href="<?= $this->config->item('domain-facebook');?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li style="    display: inline-block;"><a style="    padding: 7px 10px;    display: block;    font-size: 20px;    color: #2988CA;    transition: all ease .3s; " href="<?= $this->config->item('domain-twitter');?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                            <li style="    display: inline-block;"><a style="    padding: 7px 10px;    display: block;    font-size: 20px;    color: #2988CA;    transition: all ease .3s; " href="https://www.linkedin.com/" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                            <?php /**<li style="    display: inline-block;"><a style="    padding: 7px 10px;    display: block;    font-size: 20px;    color: #2988CA;    transition: all ease .3s; " href="<?= $this->config->item('domain-googleplus');?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>*/?>
                        <?php } ?>

                    </ul>
                </div> 
            </div>
        </div>
    </div>

<?php } ?>
