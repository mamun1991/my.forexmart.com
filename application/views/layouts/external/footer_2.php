<?php $this->lang->load('footer');?>

<style type="text/css">
    .fa-set a:hover {
        text-decoration: none;
    }




    .footNotecopyright{
        height: 90px;
        background-color: #0A4C7A;
        color: white;
        text-align: center;
        font-weight: 500;

    }

    @media screen and (min-width: 768px) and (max-width: 900px) {

        .footNotecopyright:lang(ru) {
            height: 110px;
        }
    }



    @media screen and (max-width:768px){
        .footNotecopyright{
            height: 50px;
        }

    }


    .footRestriction{
        height: auto;
        background-color: #308113;
        color: white;
        padding: 20px;
        font-weight: 500;
        font-size: 16px;
        min-height: 240px;
        text-align: left;
    }


    .contentFooter{
        font-weight: lighter;
        text-align: justify;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .footResctricetRegion{
        font-size: 16px !important;
    }


    @media screen and (max-width:1200px){
        .contentFooter{
            font-weight: lighter;
            text-align: justify;
            display: inline-flex ;
            justify-content: center;
            align-items: center;
        }

    }



    @media (max-width: 767px)  {

        .footResctricetRegion {
            font-size: 18px !important;
            padding-top: 20px;
        }
    }


</style>



<?php


  ?>

    <div class="footRestriction contentFooter"  style=""  >


        <div  class="col-sm-1">
        </div>

        <div  class="col-sm-10 "  >



            <?php if( FXPP::html_url()=='ru'){ ?>

                <p class="footResctricetRegion" >
                    <?=lang('foot_frx_ru_1'); ?><br>
                    <?=lang('foot_frx_ru_2'); ?>   <b><?php echo FXPP::companyName();?></b> <?=lang('foot_frx_ru_3'); ?>
                </p>
                <p class="footResctricetRegion">
                    <?=lang('foot_frx_ru_4'); ?>

                </p>


<?php /* ?>
            <p class="footResctricetRegion">
            <span class="blue-text"><?= lang('pn1-1'); ?> </span>
            <?=lang('foot_frx_txt1'); ?><br>
            <?=lang('foot_frx_txt2'); ?> <b><?php echo FXPP::companyName();?></b>
            <?=lang('foot_frx_txt3'); ?><br><br>
            </p>

            <p class="footResctricetRegion" >
                <?=lang('foot_frx_txt4'); ?>
                <?=lang('foot_frx_txt5'); ?>
            </p>
  <?php */ ?>








                <?php }else{ ?>
            <p class="footResctricetRegion" >

                <span class="blue-text"><?= lang('pn1-1'); ?> </span>
                <?=lang('new_with_foo_01'); ?><br><br>
                <?=lang('new_with_foo_02'); ?> <b><label class="f16"><?php echo FXPP::companyName();?></label></b>
                <?=lang('new_with_foo_04'); ?>
            </p>

            <p class="footResctricetRegion">
                <?=lang('new_with_foo_05'); ?> <b><label class="f16"><?php echo FXPP::companyName();?></label></b>
                <?=lang('new_with_foo_06'); ?>

                <?php } ?>




        </div>


        <div  class="col-sm-1">
        </div>






    </div>


    <div class="footNotecopyright" >


        &copy; 2015-<?= date('Y'); ?> <b><?php echo FXPP::companyName();?></b>
    </div>


    <div style="height: 25px; background-color: #0A4C7A">
    </div>





<?php


    /*

    ?>



    <div class="footer-desc">
        <div class="container">
            <div class="col-sm-8 footer-left">
                <p>
                    <?php  if(FXPP::isEUUrl()){ ?>
                        <span class="blue-text"><?=lang('foot_frx_txt_eu_01'); ?></span><?=lang('foot_frx_txt_eu_02'); ?>  <br><br>
                        <span class="blue-text"><?=lang('foot_frx_txt_eu_01'); ?></span><?=lang('foot_frx_txt_eu_03'); ?>
                        <br><br>
                    <?php }else{
                    ?>






                    <?php if( FXPP::html_url()=='ru'){ ?>

                    <span class="blue-text"><?= lang('pn1-1'); ?> </span>
                    <?=lang('foot_frx_txt1'); ?><br>
                    <?=lang('foot_frx_txt2'); ?> <b><?php echo FXPP::companyName();?></b>
                    <?=lang('foot_frx_txt3'); ?><br><br>
                </p>

                <p>
                    <?=lang('foot_frx_txt4'); ?>
                    <?=lang('foot_frx_txt5'); ?>



                    <?php }else{ ?>

                    <span class="blue-text"><?= lang('pn1-1'); ?> </span>
                    <?=lang('new_with_foo_01'); ?><br><br>
                    <?=lang('new_with_foo_02'); ?> <b><label class="f16"><?php echo FXPP::companyName();?></label></b>
                    <?=lang('new_with_foo_04'); ?>
                </p>

                <p>
                    <?=lang('new_with_foo_05'); ?> <b><label class="f16"><?php echo FXPP::companyName();?></label></b>
                    <?=lang('new_with_foo_06'); ?>

                    <?php } ?>











                    <?php } ?>
                </p>
                <br>
                <p>&copy; 2015-<?= date('Y'); ?> <b><label class="f16"><?php echo FXPP::companyName();?></label></b></p>

                <?php if(FXPP::isEUUrl()){
                    if($deposit_page){ ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 ext-arabic-footer-text-parent padding_for_it_lang no-left no-right" style="">
                            <p class="footer-text ext-arabic-footer-text">
                                <span class="ftr-logo"><b><?php echo FXPP::companyName();?></b>, </span> Address: 23A Leda Court, Block B, Office B203, 4000 Mesa Geitonia, Limassol, Cyprus, CySEC License Number: 266/15,
                                Company Registration Number: 266937.
                            </p>
                        </div>
                    <?php }}?>
            </div>
            <div class="col-sm-4 footer-right">
                <h4><?=lang('fx-mb-app'); ?></h4>
                <div class="temp-right">
                    <a href="https://itunes.apple.com/app/metatrader-4/id496212596?l=en&mt=8" target="_blank"><img alt="App store" src="<?= $this->template->Images()?>footer_logo/appstore_new.svg" class="grow-add-shadow temp-right-pad"></a>
                    <a href="https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4" target="_blank"><img alt="google play" src="<?= $this->template->Images()?>footer_logo/googleplay_new.svg" class="grow-add-shadow"></a>
                </div>
                <div class="temp-right fa-set">
                    <?php //if(IPLoc::isProgrammersIP()){ ?>
                    <!--                 <a href="https://www.facebook.com/forexmartofficial"><i class="fa fa-2x fa-facebook-square"></i></a>-->
                    <!--                 <a href="https://twitter.com/ForexMartPage"><i class="fa fa-2x fa-twitter-square"></i></a>-->
                    <a href="https://www.facebook.com/forexmartofficial">
                        <img src="<?= $this->template->Images()?>home/fa-tacebook.svg" class="img-reponsive tel-icon-f tel_iconu" style="width:27px; padding-bottom:12px;">
                        <img src="<?= $this->template->Images()?>home/fa-facebook-hover.svg" class="img-reponsive tel-icon-f tel_iconu tel-hover-f" style="display:none; width:27px; padding-bottom:12px;">
                    </a>

                    <a href="https://twitter.com/ForexMartPage">
                        <img src="<?= $this->template->Images()?>home/fa-twitter.svg" class="img-reponsive tel-icon-t tel_iconu" style="width:27px; padding-bottom:12px;">
                        <img src="<?= $this->template->Images()?>home/fa-twitter-hover.svg" class="img-reponsive tel-icon-t tel_iconu tel-hover-t" style="display:none; width:27px; padding-bottom:12px;">
                    </a>
                    <?php //}else{ ?>
                    <!--                 <a href="https://www.facebook.com/ForexMart"><i class="fa fa-2x fa-facebook-square"></i></a>-->
                    <!--                 <a href="https://twitter.com/ForexMartPage"><i class="fa fa-2x fa-twitter-square"></i></a>-->
                    <!--                 <a href="https://plus.google.com/+Forexmartpage"><i class="fa fa-2x fa-google-plus-square"></i></a>-->
                    <?php //} ?>
                    <?php

                    $telegram = array(
                        'ru' => 'forexmartru',
                        'my' => 'forexmartmalaysia',
                        'id' => 'forexmartindonesia'
                    );

                    if(array_key_exists(FXPP::html_url(), $telegram)){ ?>
                        <a href="https://t.me/<?=$telegram[FXPP::html_url()]?>">
                            <img src="<?= $this->template->Images()?>home/fa-telegram.svg" class="img-reponsive tel-icon tel_iconu" style="width:27px; padding-bottom:12px;">
                            <img src="<?= $this->template->Images()?>home/fa-telegram-hover.svg" class="img-reponsive tel-icon tel_iconu tel-hover" style="display:none; width:27px; padding-bottom:12px;">
                        </a>
                        <?php if(FXPP::html_url() === 'ru'){ ?>
                            <!--                     <a href="https://vk.com/forexmart"><i class="fa fa-2x fa-vk"></i></a>-->

                            <a href="https://vk.com/forexmart">
                                <img src="<?= $this->template->Images()?>home/fa-vk.svg" class="img-reponsive tel-icon-v tel_iconu" style="width:27px; padding-bottom:12px;">
                                <img src="<?= $this->template->Images()?>home/fa-vk-hover.svg" class="img-reponsive tel-icon-v tel_iconu tel-hover-v" style="display:none; width:27px; padding-bottom:12px;">
                            </a>
                        <?php } ?>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>


<?php }


*/


?>

