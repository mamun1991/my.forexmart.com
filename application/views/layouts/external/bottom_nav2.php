


<?php
switch(FXPP::html_url()){
    case '': $country_lang = ''; break;
    case 'en': $country_lang = ''; break;
    case 'ru': $country_lang = 'ru'; break;
    case 'jp': $country_lang = 'jp'; break;
    case 'de': $country_lang = 'de'; break;
    case 'id': $country_lang = 'id'; break;
    case 'sa': $country_lang = 'sa'; break;
    case 'fr': $country_lang = 'fr'; break;
    case 'es': $country_lang = 'es'; break;
    case 'pt': $country_lang = 'pt'; break;
    case 'bg': $country_lang = 'bg'; break;
    case 'bd': $country_lang = 'bd'; break;
    case 'my': $country_lang = 'my'; break;
    case 'pk': $country_lang = 'pk'; break;
    case 'pl': $country_lang = 'pl'; break;
    case 'cs': $country_lang = 'cs'; break;
    case 'zh': $country_lang = 'zh'; break;
    case 'sk': $country_lang = 'sk'; break;
}

if (!$country_lang){
    $file_location = $_SERVER['DOCUMENT_ROOT']. 'assets/pdf/forexmart_eu/';
} else {
    $file_location = $_SERVER['DOCUMENT_ROOT']. 'assets/pdf/forexmart_eu/'. $country_lang.'/';
}


if (file_exists($file_location . '/Policy_Privacy_Policy_forexmart.eu_V1.0_291118.pdf') && ($country_lang != '' )) {
    $Policy_Privacy_pdf = $this->template->pdf() .  'forexmart_eu/' . $country_lang . '/'. rawurlencode('Policy_Privacy_Policy_forexmart.eu_V1.0_291118.pdf');
} else {
    $Policy_Privacy_pdf = $this->template->pdf() .  'forexmart_eu/' . rawurlencode('Policy_Privacy_Policy_forexmart.eu_V1.0_291118.pdf');
}


if (file_exists($file_location . '/terms_and_conditions.pdf') && ($country_lang != '' )) {
    $Terms_and_Conditions_pdf = $this->template->pdf() .  'forexmart_eu/' . $country_lang . '/'. rawurlencode('terms_and_conditions.pdf');
} else {
    $Terms_and_Conditions_pdf = $this->template->pdf() .  'forexmart_eu/' . rawurlencode('terms_and_conditions.pdf');
}


if (file_exists($file_location . '/Risk_Disclosure_Statement_forexmart.eu_V1.0_291118.pdf') && ($country_lang != '' )) {
    $Risk_Disclosure_pdf = $this->template->pdf() .  'forexmart_eu/' . $country_lang . '/'. rawurlencode('Risk_Disclosure_Statement_forexmart.eu_V1.0_291118.pdf');
} else {
    $Risk_Disclosure_pdf = $this->template->pdf() .  'forexmart_eu/' . rawurlencode('Risk_Disclosure_Statement_forexmart.eu_V1.0_291118.pdf');
}
?>



<link href="<?= $this->template->Css() ?>bottom-nav2.css" rel="stylesheet">


<!--<div class="col-sm-12 mbl-quick-links" >-->
<!--    <h3 >--><?//= lang('btm_nav_frx_txt1'); ?><!--</h3>-->
<!--</div>-->

<?php
if ($_SERVER['SERVER_NAME'] === 'my.forexmart.com') {
    $flag_img	= $this->template->Images().'eu.UK.flag.png';
    $phone_number	= '+44 330 0104 195';
    $phone_number_val = '+443300104195';
    $ulClass = "comCustom";

} else if ($_SERVER['SERVER_NAME'] === 'my.forexmart.eu') {
    $flag_img	= $this->template->Images().'UK-icon.png';
    $phone_number	= '+44 207 1933 236';
    $phone_number_val = '+35725057236';
    $ulClass = "euCustom";
}
?>


<?php

  ?>


    <style>

        .infoFootright {
            font-family: 'Open Sans';
        }

        .frameDiv {
            height: 200px;
            white-space: nowrap;
            text-align: center; margin: 1em 0;
        }

        .helperSpan {
            display: inline-block;
            height: 100%;
            vertical-align: middle;
        }


        .QuickLinkDiv{
            height: 260px;
            background-color:#0A4C7A;
            font-size: 15px;
            font-weight: lighter;
            color: #929292;
        }



        .fxLogoFoot{
            height: 115px;
            width: auto;
            padding: 10px;
        }

        .quickMenu{
            color:#F2F5F8;
            list-style-type: none;
            padding-left: 0px;
            line-height: 2.5;
            font-weight: lighter;
            white-space: ;
        }


        .quickMenu2{
            color:#F2F5F8;
            list-style-type: none;
            padding-left: 0px;
            line-height: 2.5;
            font-weight: lighter;
            white-space: nowrap;
        }

        .contactusDivFoot{
            background-color: #308113;
            font-weight: 500;
            color: #fff;
            padding: 5px 0px;
            width: 150px;
            font-size: 14px;
            text-align: center;
            margin-top: 15px;
        }

        a.quickAlink:hover{
            color: #a6ceed !important;
        }

        .quickAlinkInfo:hover{
            color: #a6ceed !important;
        }


        .footNotecopyright{
            height: 55px;
            background-color: #0A4C7A;
            color: white;
            text-align: center;
            font-weight: 500;
            padding-top: 10px;
            font-family: 'Open Sans';
        }

        .footRestriction{
            height: auto;
            background-color: #308113;
            color: white;
            padding: 20px;
            font-weight: 500;
            font-size: 14px;
            min-height: 220px;
            text-align: left;
        }


        @media screen and (min-width: 768px) and (max-width: 967px) {
            .QuickLinkDiv {
                height: 300px;

            }

            img.grow-add-shadow {
                padding-top: 4px;
            }


            .footRestriction{
                min-height: 300px !important;
                margin-top: -45px;

            }
            .quickNewsDiv {
                white-space: nowrap;
            }


            .frameDiv {
                height: 215px;
            }
        }


        @media (max-width: 767px)  {
            /*.infoFootright{*/
            /*float: right;*/
            /*}*/


            .QuickLinkDiv {
                height: auto;
                padding-bottom: 40px;
            }



            .QickLinkH{
                text-align: center;
            }
            .quickMenu {
                padding-top: 20px;
                width: 60%;
                margin-left: 27%;
                white-space: nowrap;
            }

            .row.infoFootright {
                text-align: center;
                padding-top: 20px;
            }

            .contactbtnDiv {
                text-align: -webkit-center;
            }


            .IconFootDiv {
                display: grid;
            }

            a.playIconFoot {
                padding-top: 10px;
            }



        }

        @media screen and (min-width: 451px) and (max-width: 600px) {
            .quickMenu {
                margin-left: 35%;
            }

        }

        @media screen and (min-width: 601px) and (max-width: 767px) {
            .quickMenu {
                margin-left: 38%;
            }

        }

        @media (max-width: 992px) {
            .footRestriction {
                min-height: 210px;

            }
        }

        @media (min-width: 774px) {
            .twitterFooterAnchor{
                padding-left: 5px;
            }
        }




        img.iconImgCon:hover {
            opacity: 0.3;
        }

        .contactusDivFoot:hover {
            opacity: 0.8;
        }


    </style>





<style>



    @media (max-width: 767px)  {
        .fxLogoFoot {
            height: 145px;
        }

        .QickLinkH {
            text-align: center;
            font-size: 32px;
            font-weight: 600;
        }

        .QuickLinkDiv {
            font-size: 20px;
        }

        .contactusDivFoot {
            padding: 10px 0px;
            width: 165px;
            font-size: 20px;
        }

        img.grow-add-shadow {
            height: 50px !important;
        }

        img.iconImgCon {
            height: 30px !important;
        }

        a.playIconFoot {
            padding-top: 25px;
            padding-bottom: 40px;
        }

        .footResctricetRegion {
            font-size: 18px !important;
            padding-top: 20px;
        }

        .footNotecopyright {
            font-size: 18px;
        }

        .conNumber {
            padding-bottom: 15px;
        }

        .feedBck {
            padding-bottom: 15px;
        }

        .contactbtnDiv {
            padding-bottom: 15px;
        }

        .socialIco {
            padding-bottom: 15px;
        }


        div.outer {
            position: relative;
            height: 250px;
        }

        div.inner2 {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%,-50%);
        }

        h3.QickLinkH {
            padding-bottom: 30px;
        }

        .QuickLinkDiv:lang(ru) {
            font-size: 17px;
        }


    }





</style>



    <?php
    if(FXPP::html_url() && FXPP::html_url() !='en'  ){
        $langUrl=FXPP::html_url().'/';
    }

    ?>


    <div class="QuickLinkDiv"  >

        <div  class="col-sm-1">
        </div>




        <div  class=" col-sm-6 ">


            <div class="row">

                <div  class=" col-sm-4 " style="text-align: center">

                    <div class=frameDiv>
                        <span class="helperSpan"></span>

                            <img class="fxLogoFoot" style="" alt="Logo" src="https://www.forexmart.com/assets/images/forexmartlogo_new.png" >


                    </div>
                </div>


                <div  class=" col-sm-8  d-flex justify-content-center">
                    <h3 class="QickLinkH" style="color: #85A6BD"><?= lang('btm_nav_frx_txt1'); ?></h3>


                    <div class="outer mobQuick">
                        <div class="inner2">

                            <ul class="quickMenu2" >

                                <li> — <a class="quickAlink" style="color:#F2F5F8" href="https://www.forexmart.com/<?=$langUrl?>news" > <?= lang('bn_li_news'); ?> </a>   </li>
                                <li> — <a class="quickAlink" style="color:#F2F5F8" href="https://www.forexmart.com/<?=$langUrl?>legal-documentation">  <?= lang('bn_li_ld'); ?> </a> </li>
                                <li> — <a class="quickAlink" style="color:#F2F5F8" href="https://www.forexmart.com/assets/pdf/Tradomart-SV/Risk-Disclosure.pdf"> <?= lang('bn_li_rd'); ?>  </a></li>
                                <li> — <a class="quickAlink" style="color:#F2F5F8"  href="https://www.forexmart.com/assets/pdf/Tradomart-SV/Terms-and-ConditionsV2.pdf"> <?= trim(lang('bn_li_tnc')); ?> </a> </li>
                                <li> — <a class="quickAlink" style="color:#F2F5F8" href="https://www.forexmart.com/assets/pdf/Tradomart-SV/Privacy-Policy.pdf">   <?= trim(lang('bn_li_pp')); ?> </a> </li>
                            </ul>
                        </div>




                    </div>













                </div>

            </div>



        </div>












        <div  class="col-sm-1">  </div>

        <div  class="col-sm-3">
            <div class="row infoFootright">

                <div class="conNumber" style="margin-top: 20px; " >
                    <img src="https://www.forexmart.com/assets/images/eu_flag_foot.png" class="img-reponsive" width="32"  alt="">
                    <a style="color:#F2F5F8; text-decoration: none; "  href="tel:+443300104195">
                        <span style="color: white; font-weight: 500;" class="quickAlinkInfo"> + 443 300 104 195</span>
                    </a>
                </div>


                <div class="contactbtnDiv">

                    <a style="color:#F2F5F8; text-decoration: none"  href="https://www.forexmart.com/<?=$langUrl?>contact-us">
                    <div class="contactusDivFoot"  >
                            <img style="height: 20px; width: auto" src="https://www.forexmart.com/assets/images/call_footer.png" class="img-reponsive"  alt="">
                            <span ><?= lang('bn_li_cu'); ?></span>

                    </div>
                    </a>

                </div>



                <div class="feedBck" style="margin-top: 15px;">
                    <img style="height: 25px; width: auto"   src="https://www.forexmart.com/assets/images/feedback_footer.png" class="img-reponsive" width="32" title="tel" alt="">
                    <span style="color: white; cursor: pointer" >

                                <a style="color:#F2F5F8; text-decoration: none"  href="#popfeedback"   class="quickAlinkInfo"  data-toggle="modal" data-target="#popfeedback">
                                       <?= lang('bn_li_f'); ?>
                                </a>
                            </span>

                </div>





                <div class="socialIco" style="padding-top: 15px"  >

                    <a style="padding: 5px;" href="https://www.facebook.com/forexmartofficial">
                        <img class="iconImgCon" style="height: 23px; width: auto"  src="https://www.forexmart.com/assets/images/facebook_footer.png" >
                    </a>

                    <a class="twitterFooterAnchor" style="padding: 5px;" href="https://twitter.com/ForexMartPage">
                        <img class="iconImgCon" style="height: 20px; width: auto" src="https://www.forexmart.com/assets/images/twitter_footer.png"  >
                    </a>

                    <?php

                    $telegram = array(
                        'ru' => 'forexmartru',
                        'my' => 'forexmartmalaysia',
                        'id' => 'forexmartindonesia'
                    );

                    if(array_key_exists(FXPP::html_url(), $telegram)){ ?>
                        <a style="padding: 5px;" href="https://t.me/<?=$telegram[FXPP::html_url()]?>">
                            <img class="iconImgCon" style="height: 20px; width: auto" src="https://www.forexmart.com/assets/images/telegram_footer.png" >

                        </a>
                        <?php if(FXPP::html_url() === 'ru'){ ?>
                            <a style="padding: 5px;" href="https://vk.com/forexmart">
                                <img class="iconImgCon" style="height: 20px; width: auto" src="https://www.forexmart.com/assets/images/vk_footer.png"  >
                            </a>
                        <?php } ?>
                    <?php } ?>

                </div>














                <div class="IconFootDiv" style="padding-top: 20px" >
                    <a class="appIconFoot" href="https://itunes.apple.com/app/metatrader-4/id496212596?l=en&mt=8" target="_blank">
                        <img style="height: 35px;"  alt="App store" src="https://www.forexmart.com/assets/images/appstore_footer.png" class="grow-add-shadow ">
                    </a>
                    <a class="playIconFoot" href="https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4" target="_blank">
                        <img style="height: 35px;" alt="google play" src="https://www.forexmart.com/assets/images/google_footer.png" class="grow-add-shadow">
                    </a>
                </div>

            </div>
        </div>






        <div  class="col-sm-1">
        </div>


    </div>


<?php


    /*


    ?>



    <div class="quick-links">
        <div class="container quick">
            <div class="col-md-2 col-sm-12 col-xs-12 quick-links-holder">
                <h3 ><?= lang('btm_nav_frx_txt1'); ?></h3>
            </div>
            <div class="col-md-8 col-sm-6 col-xs-6 terms">
                <ul class="terms-nav">
                    <li>
                        <a href="<?=FXPP::www_url('legal-documentation')?>">
                            <?= lang('bn_li_ld'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?=FXPP::www_url('risk-disclosure')?>">
                            <?= lang('bn_li_rd'); ?>
                        </a>
                    </li>
                    <li><a href="<?=FXPP::www_url('privacy-policy')?>">
                            <?= trim(lang('bn_li_pp')); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?=FXPP::www_url('terms-and-conditions')?>">
                            <?= trim(lang('bn_li_tnc')); ?>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 feedback">
                <ul class="contactFeedback" >

                    <li>
                        <?php if (!FXPP::isEUUrl()) : ?>
                            <label class="f16">
                                <a href="tel:<?= $phone_number; ?>">
                                    <img src="<?= $flag_img; ?>" width="25">
                                    <?= $phone_number; ?>
                                </a>
                            </label>
                        <?php else : ?>
                            <a href="tel:<?= $phone_number; ?>">
                                <img src="<?= $flag_img; ?>" width="25">
                                <?= $phone_number; ?>
                            </a>
                        <?php endif; ?>
                    </li>

                    <li>
                        <a id="fee_ba" href="#popfeedback" class="mar0500 opt a3" data-toggle="modal" data-target="#popfeedback">
                            <span class="customfeedback4190 img-4190"><img src="https://my.forexmart.com/assets/images/feedback-icon4.svg" class="customfeedback4190-2 img-4190"></span>
                            <span class="spn-4190" style="display: inline-block;padding-top: 2px;vertical-align: middle;"><?= lang('bn_li_f'); ?></span>
                        </a>
                    </li>
                    <li>
                        <a id="con_us" href="<?= FXPP::loc_url('contact-us') ?>">
                            <i class="fa fa-phone phone foot-bullet"></i><?= lang('bn_li_cu'); ?>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </div>





<?php


}

*/

?>








<script type="text/javascript">
    $(document).ready(function() {

        $("#owl-demo").owlCarousel({
            autoPlay: 3000, //Set AutoPlay to 3 seconds
            items : 5,
            lazyLoad : true,
            navigation : false
        });
        $('.play').on('click',function(){
            owl.trigger('autoplay.play.owl',[1000])
        });
        $('.stop').on('click',function(){
            owl.trigger('autoplay.stop.owl')
        })
    });
</script>
<script type="text/javascript">
    //    $(".footer-toggle").click(function() {
    ////        $(".footer-hide-menu").toggle( 300, function() {
    ////        });
    //        $(".footer-hide-menu").toggle();
    //    });
    $(".footer-toggle").click(function() {
        $(".mar-t").toggle();
    });
</script>

<script>
    var language = '<?=FXPP::html_url()?>';
    $(document).ready(function(){
        str = language.replace(/\s/g, '');
        if (str === 'it' ){

            $("#botnav_right").removeClass("col-sm-4");
            $("#botnav_right").addClass("col-sm-5");

            $("#botnav_left").removeClass("col-lg-8");
            $("#botnav_left").removeClass("col-md-8");
            $("#botnav_left").removeClass("col-sm-8");
            $("#botnav_left").addClass("col-sm-7");
            $("#botnav_left").addClass("col-sm-7");
            $("#botnav_left").addClass("col-sm-7");
        }
        if (str === 'id' ){

            $("#botnav_right").removeClass("col-sm-4");
            $("#botnav_right").addClass("col-sm-5");

            $("#botnav_left").removeClass("col-lg-8");
            $("#botnav_left").removeClass("col-md-8");
            $("#botnav_left").removeClass("col-sm-8");
            $("#botnav_left").addClass("col-sm-7");
            $("#botnav_left").addClass("col-sm-7");
            $("#botnav_left").addClass("col-sm-7");
        }
        if (str === 'de' ){

            $("#botnav_right").removeClass("col-sm-4");
            $("#botnav_right").addClass("col-sm-5");

            $("#botnav_left").removeClass("col-lg-8");
            $("#botnav_left").removeClass("col-md-8");
            $("#botnav_left").removeClass("col-sm-8");
            $("#botnav_left").addClass("col-sm-7");
            $("#botnav_left").addClass("col-sm-7");
            $("#botnav_left").addClass("col-sm-7");
        }
        if (str === 'es' ){

            $("#botnav_right").removeClass("col-sm-4");
            $("#botnav_right").addClass("col-sm-5");

            $("#botnav_left").removeClass("col-lg-8");
            $("#botnav_left").removeClass("col-md-8");
            $("#botnav_left").removeClass("col-sm-8");
            $("#botnav_left").addClass("col-sm-7");
            $("#botnav_left").addClass("col-sm-7");
            $("#botnav_left").addClass("col-sm-7");
        }
        if (str === 'pt' ){

            $("#botnav_right").removeClass("col-sm-4");
            $("#botnav_right").addClass("col-sm-5");

            $("#botnav_left").removeClass("col-lg-8");
            $("#botnav_left").removeClass("col-md-8");
            $("#botnav_left").removeClass("col-sm-8");
            $("#botnav_left").addClass("col-sm-7");
            $("#botnav_left").addClass("col-sm-7");
            $("#botnav_left").addClass("col-sm-7");
        }
    });

</script>