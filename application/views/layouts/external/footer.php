

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

            @media only screen and (max-width: 768px) {
                .row{
                    margin-left: 0px;
                }
                .copyCust{
                    padding-left: 15px !important;
                }
            }

            .ftr-logo {
                color: #000;
                font-weight: 700;
            }



        </style>
        <div class="row ext-arabic-footer-row" style="width: 100%">

            <div class="col-sm-12 col-md-12 col-lg-12 sec logoLink" style="margin-bottom: 0;">
                <?php  if(!FXPP::isEUUrl()){ ?>
             <!--   <a href="https://www.forexmart.com/cysec"><img src="<?/*= $this->template->Images()*/?>cysec.png" class="img-responsive"></a>-->
                <?php  } ?>
              <!--  <a href="http://ec.europa.eu/finance/securities/isd/mifid/index_en.htm"><img src="<?/*= $this->template->Images()*/?>mifid.png" class="img-responsive "></a>-->
                <!--<a href="https://www.forexmart.com/bafin"><img src="<?/*= $this->template->Images()*/?>bafin.png" class="img-responsive"></a>
                <a href="https://www.forexmart.com/amf"><img src="<?/*= $this->template->Images()*/?>amf.png" class="img-responsive"></a>
                <a href="https://www.forexmart.com/fca"><img src="<?/*= $this->template->Images()*/?>fca.png" class="img-responsive"></a>
                <a href="https://www.forexmart.com/consob"><img src="<?/*= $this->template->Images()*/?>consob.png" class="img-responsive"></a>-->
            </div>
            <?php// if(IPLoc::Office()){?>
            <p class="footer-text ext-arabic-footer-text" style="padding-left:5px!important; margin-top: 0;">


                <!-- .com Footer -->
                <?php  if(FXPP::isEUUrl()){ ?>
                    <span class="company">www.forexmart.com </span> is operated by <b><?php echo FXPP::companyName();?></b> (registration number <a href="<?=FXPP::www_url('License');?>">266/15</a>).
                    <b><?php echo FXPP::companyName();?></b> (CY) is authorized and regulated by CySEC (Cyprus Securities and Exchange Commission, license number <a href="<?=FXPP::www_url('License');?>">266/15</a>), the website is <span class="company">www.forexmart.com</span>
                    <br><br>
                    
                    
                    <cite>
                        <?= lang('gen-rw'); ?>
                    </cite>
                    
                    
                    <?= lang('footer-gen-risk'); ?>

                <?php }else{


                    ?>

                        <span class="company "><?= lang('pn1-1'); ?></span>
                        <?= lang('new_with_foo_01'); ?><br><br> <?="This website is operated by"?> <span class="ftr-logo"><?php echo FXPP::companyName();?></span>  <?= lang('new_with_foo_04'); ?><br>
                        <?= lang('new_with_foo_05'); ?> <span class="ftr-logo"><?php echo FXPP::companyName();?>  </span>
                        <?= lang('new_with_foo_06'); ?> <br><br>

                        <cite>
                            <?= lang('gen-rw'); ?>
                        </cite>
                        <?= lang('footer-gen-risk'); ?>






                    <!-- .eu Footer -->

                <?php } ?>
            </p>




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

<style type="text/css">
    /*.btn-tel {*/
        /*width: 46px;*/
        /*height: 46px;*/
    /*}*/

    @media screen and (max-width:1212px) {
        /*.btn-tel {*/
            /*width: 35px;*/
            /*height: 35px;*/
        /*}*/
    }
</style>

<?php
$telegram = array(
    'ru' => 'forexmartru',
    'my' => 'forexmartmalaysia',
    'id' => 'forexmartindonesia'
);
?>

<div class="copyright-holder">
    <div class="container">
<!--        <div class="row" style="margin-left: 0px !important; margin-right: 0px !important;">-->
            <div class="row">
            <div class="col-md-9 copy coprig ext-arabic-footer-copy sa-right copyCust" style="padding-left: 0">
                <p>&copy; 2015-<?=date('Y');?>

                    <span class="ftr-logo"><?php echo FXPP::companyName();?></span>

            </div>
            <div class="col-md-3 social-media-holder sosmed ext-arabic-footer-social-media">
                <ul class="social-media">
                    <?php if(FXPP::html_url()=='ru'){ ?>
                        <li><a href="https://www.facebook.com/forexmartru" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://twitter.com/ForexMartRu" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://vk.com/forexmart" target="_blank"><i class="fa fa-vk"></i></a></li>
                        <?php /**<li><a href="https://plus.google.com/communities/111804080179853814370" target="_blank"><i class="fa fa-google-plus"></i></a></li>*/?>
                        <li>
                            <a href="https://t.me/<?=$telegram[FXPP::html_url()]?>">
                                <img src="<?= $this->template->Images()?>cabinet/telegram-new.png" class="btn-social btn-telegram btn-tel" title="Telegram" alt="" style="width:23px; height:23px;">
                            </a>
                        </li>
                    <?php }else{ ?>
                        <li><a href="<?= $this->config->item('domain-facebook');?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="<?= $this->config->item('domain-twitter');?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://www.linkedin.com/" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        <?php /**<li><a href="<?= $this->config->item('domain-googleplus');?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>*/?>

                        <?php if(FXPP::html_url()=='my' || FXPP::html_url()=='id'){ ?>
                            <li>
                                <a href="https://t.me/<?=$telegram[FXPP::html_url()]?>">
                                    <img src="<?= $this->template->Images()?>cabinet/telegram-new.png" class="btn-social btn-telegram btn-tel" title="Telegram" alt="" style="width:23px;">
                                </a>
                            </li>
                        <?php } ?>

                    <?php } ?>

                </ul>
            </div>
        </div>
    </div>
</div>

