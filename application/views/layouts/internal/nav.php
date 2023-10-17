<?php 
$this->load->library('IPLoc', null); 
?>
<!DOCTYPE html>
<html lang="<?= FXPP::html_url() ?>" dir="<?= FXPP::lang_dir(); ?>">
<head >
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />

    <script>
    $(function(){
        $('#SearchInInternal').on('keyup',function(e){
            $("#navsearch").attr("href","<?= (FXPP::www_url());?>user/search/searchstring/"+ $('#SearchInInternal').val());
            if ($.trim($(this).val()).length != 0) {
                $("#navsearch").attr('target','_blank');
            }else{
                $("#navsearch").removeAttr('target');
                $("#navsearch").attr("href","javascript:void(0)");
            }
            if (e.keyCode == 13) {
                window.open("<?= (FXPP::www_url());?>user/search/searchstring/"+ $('#SearchInInternal').val(), '_blank');
            }
        });

        $(".form-control").keydown(function(e){
            if(e.keyCode == 13) {
                return false;
            }
        });

    });
</script>
<style type="text/css">









table.dataTable thead>tr>td.sorting,table.dataTable thead>tr>td.sorting_asc,table.dataTable thead>tr>td.sorting_desc,table.dataTable thead>tr>th.sorting,table.dataTable thead>tr>th.sorting_asc,table.dataTable thead>tr>th.sorting_desc{padding-right:1% !important;}th.sorting::after{content:""!important;display:none!important}





.navbar-right-internal li a.profile{
        margin-top: 8px!important;
    }
    .searchD{
        padding: 0;margin: 0
    }
    .searchA{
        padding: 15px;
    }
    .zeropadding{
        padding: 0 !important;
    }
    .nolinkline{

        outline: none;
    }
    .accta {
        padding-bottom: 5px!important;
        padding-top: 5px!important;
    }
    .col-search {
        padding-left: 0px;
    }
    .flag-drp-holder {
        display: none;
    }
    #img-dp {
        width: 30px;
        height: 30px;
    }
    /*.flag_pad{*/
        /*margin: 7px 0px;*/
    /*}*/
    @media screen and (max-width: 991px) {
        .int-logo{
            width: 250px;
        }
    }
    @media screen and (min-width: 776px) and (max-width: 964px) {
        .int-logo{
            margin-top: 4px;
        }
    }
    @media screen  and (max-width: 964px) {

        .int-logo{
            width: 250px;
            margin-top: 4px;
        }
    }
    @media screen and (max-width: 942px) {

        .int-logo{
            width: 250px;
        }
    }
    @media screen and (max-width: 800px) {

        .int-logo{
            width: 200px;
        }
    }
    @media screen and (max-width: 731px) {
        .int-logo{
            width: 200px;
        }
    }
    @media screen and (max-width: 556px) {
        .int-logo{
            width: 200px;
        }
    }
    @media screen and (max-width: 411px) {
        .int-logo{
            width: 200px;
        }
        .flag-drp{
                left: 11%!important;
            }
    }











    @media screen and (max-width: 320px) {
        /*.nav>li {
            display: inline-block;
        }*/
        /*.dropdown {
            width: 60%;
            float: left;
        }*/
        .flag_pad {
            width: 22%;
        }
        /*.navbar-default .navbar-nav .open .dropdown-menu>li>a {
            padding-left: 0;
        }*/
        .btn-flag {
            margin-top: 10px !important;
        }
        .flag-drp{
                left: 4%!important;
            }
    }
    @media screen and (max-width: 223px) {
        .int-logo{
            width: 155px;
            margin-top: 10px;
        }
    }
    @media screen and (max-width: 200px) {
        .int-logo{
            width: 100px;
        }
    }
    @media screen and (max-width: 150px) {
        .int-logo{
            width: 80px;
        }
    }


    @media screen and (max-width: 800px) {
        #searchcon{
            width: 90%;
            margin: auto;
        }
    }
    @media screen and (max-width: 715px) {

        #searchform{
            border: 0!important;
        }
        /*#nav_ul{*/
            /*width: 90%;*/
            /*margin: auto;*/
        /*}*/
        .flag_pad {
            margin: 7px 10px;
        }
    }
    @media screen and (max-width: 767px) {
        .int-logo:lang(sa) {
            margin-top: -6px;
        }
        .navbar-right-internal li a
        {
            padding-bottom: 10px!important;
            padding-top: 10px!important;
        }
        .btn-flag {
            margin: 0px !important;
        }
        .flag_pad {
            display: none!important;
        }
        .flag-drp
        {
            position: fixed!important;
            z-index: 9;
            left: 10px;
            top: 155px;
            width: 150px;
            float: right;
        }
        .flag-drp-holder {
            display: block;
        }
        .border-none {
            border: none;
        }
        .navbar-brand-internal{
            margin: 0;
            padding: 0 10px;
        }
        .navbar-brand-internal:lang(sa){
            float: right !important;
			position: relative;
        }
		.arabic-int-collapse {
			margin-top: 10px !important;
			float: right !important;
		}
        .int-logo{
            max-width: 160px!important;
            margin: 0;
        }
    }
    #nav_ul{
        /*height: 64px;*/
    }
    .int-logo{
        margin-left:18px;
    }

    /*.btn-reg:hover{*/
    /*background: #106BAA !important;*/
        /*color: #fff !important;*/
    /*}*/

    i.fa.fa-caret-down:hover {
        color: #2988ca ;
    }
    }

    .icon-image-triangle{
        top: -14px !important;
    }



@media screen and (max-width: 340px){

    .int-logo {
        max-width: 142px!important;
    }
}


.icon-container {
        position: absolute;
        /*right: 10px;*/
        left: 150px;
        top: calc(50% - 10px);
    }
    .icon-loader{
        position: relative;
        height: 20px;
        width: 20px;
        display: inline-block;
        animation: around 5.4s infinite;
    }

    @keyframes around {
        0% {
            transform: rotate(0deg)
        }
        100% {
            transform: rotate(360deg)
        }
    }

    .icon-loader::after, .icon-loader::before {
        content: "";
        background: white;
        position: absolute;
        display: inline-block;
        width: 100%;
        height: 100%;
        border-width: 2px;
        border-color: #333 #333 transparent transparent;
        border-style: solid;
        border-radius: 20px;
        box-sizing: border-box;
        top: 0;
        left: 0;
        animation: around 0.7s ease-in-out infinite;
    }

    .icon-loader::after {
        animation: around 0.7s ease-in-out 0.1s infinite;
        background: transparent;
    }


    @media only screen and (max-width: 768px) {
        .notification-item .item-title {
         color: #fff;
        }
        .notification-item .item-info {
         color: #fff;
        }
   }





</style>
    <?php //if($this->session->userdata('user_id')==102346){?>
    <style>
        @media screen and (max-width: 767px) {
            .btn_flag1_margin_top{
                margin-top:8px!important;
                margin-left: 88%!important;
            }
            .btn_flag1_margin_top img{
                width: 45px!important;
                height: 30px!important;
            }
            .pull-right{
                margin-top: 8px;
                margin-left:1%;
                float: left!important;
            }
            .flag-drp{
                left: 0%;
                top: 167px;
            }
			.searchBtn{
				margin-right: 0px !important;
			}
        }
        @media screen and (max-width: 650px) {
            .pull-right{
                margin-left:2%;
            }
        }
        @media screen and (max-width: 550px) {
            .pull-right{
                margin-left:3%;
            }
        }
        @media screen and (max-width: 450px) {
            .pull-right{
                margin-left:4.5%;
            }
        }
        @media screen and (max-width: 414px) {
            .pull-right{
                margin-left: 5%!important;
            }
            .btn_flag1_margin_top{
                margin-left: 82%!important;
            }
        }
        @media screen and (max-width: 375px) {
            .btn_flag1_margin_top{
                margin-left: 75%!important;
            }
        }
        @media screen and (max-width: 350px) {
            .pull-right{
                margin-left: 6%!important;
            }
        }
        @media screen and (max-width: 320px) {
            .pull-right{
                margin-left: 7%!important;
            }
            .btn_flag1_margin_top{
                margin-left: 55%!important;
            }
        }
        @media screen and (max-width: 290px) {
            .pull-right{
                float: right!important;
                margin-left: 8%!important;
            }
        }
        @media screen and (max-width: 245px) {
            .btn_flag1_margin_top{
                margin-left: 10%!important;
            }
        }
        @media screen and (max-width: 230px) {
            .btn_flag1_margin_top {
                margin-left: 0px!important;
            }
        }
        @media screen and (max-width: 274px){
            .flag-drp {
                left: 20px;
                top: 218px;
            }
        }
        @media screen and (max-width: 229px){
            .flag-drp {
                left: 10px;
                top: 240px;
            }
        }
        @media screen and (max-width: 200px){
            .flag-drp {
                top: 191px;
            }
        }
        @media screen and (max-width: 174px){
            .flag-drp {
                top: 238px;
            }
        }

        .navbar-form {
            padding-right: 10px !important;
        }





    </style>





    <style>

        .navbar-default{
           /*z-index: 9999999999999999999999 !important;*/
        }

        .flag_pad {
            margin-left: 20px;
        }

        .searchBtn{
            width: 66% !important;
            margin-right: 10px  !important;
            padding-left: 0px !important;
            max-width: 320px;

        }

        @media screen and (max-width: 365px) {
            .searchBtn{
                width: 62% !important;
                margin-right: 20px  !important;
                padding-left: 0px !important;

            }
        }


        @media screen and (max-width: 319.99px) {
            .searchBtn{
                width: 60% !important;
                margin-right: 20px  !important;
                padding-left: 0px !important;

            }
        }

        @media screen and (max-width: 768px) {
            .searchBtn:lang(sa){
                margin-right: 0px  !important;
				padding-right: 0 !important;
            }
        }


        @media screen and (min-width: 767.99px) {
            .flagBtnMob {
                display: none !important;
            }
        }



        .mobFlagIcon{
            float: right !important;
            margin-left: 0px !important;
        }

        @media screen and (max-width: 500px) and (min-width: 400px)  {
            .newUlFlag {
                left: 25% !important;
                margin-left: 0px !important;

            }


        }


        @media screen and (max-width: 610px) and (min-width: 500px)  {
            .newUlFlag {
                left: 45% !important;

            }


        }


        @media screen and (max-width: 768px) and (min-width: 610px)  {
            .newUlFlag {
                left: 52% !important;

            }











    </style>



    <style>


        .disabled_li{
            pointer-events:none;
            /*opacity:0.4;*/
            /*font-weight:bold !important;*/
        }

        .langStrong{
            font-weight: 700 !important;
        }

    </style>





    <?php// }?>

<script type="text/javascript">
    $(window).load(function() {
// If the web browser type is Safari
        if( navigator.userAgent.toLowerCase().indexOf('safari/') > -1)
        {
//            $(".logo-in-saf").hide();
            //alert('testing');

<!--            $("#logo-saf-in").append('<img src="--><?//= $this->template->Images() ?><!----><?//= FXPP::html_url() == 'ru' ? 'fxlogonewinternal-russian.png' : 'fxlogonewinternal.png' ?><!--" class="img-reponsive int-logo" style="height:107%;" alt="ForexMart and LasPalmas Logo logo-in-saf" usemap="#fxxpplaspalmas"/>');-->
        }
    });
</script>

</head>
<nav style="z-index: 999 !important;" class="navbar navbar-default navbar-internal round-0">
    <div class="container arabic-container arabic-top-header">
        <!-- Brand and toggle get grouped for better mobile display -->










        <div class="navbar-header arabic-navbar-header">






            <ul class="notification-mobile-holder" id="notifMobile">

            </ul>
           
            <button id="navbar-menu-1" type="button" class="navbar-toggle collapsed int-collapse arabic-int-collapse" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>




         <button id="mbl-lang-btn" style="float: left;  margin-top: 8px !important; width: 80px; background: #fff;  border: 1px solid #ececec; display: flex; align-items: center; justify-content: center; " class=" mobFlagIcon btn-flag btn-reg btn-flag-reg arabic-btn-flag-reg btn btn-default flagBtnMob  mobv" type="button">
                    <?php

                    switch(FXPP::html_url()){
                        case 'en':
                        case '':
                            ?>
                            <span class="country-symbol">EN</span>
                            <span class="i-round-flag fg-united-kingdom"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;
                        case 'ru': ?>
                            <span class="country-symbol">RU</span>
                            <span class="i-round-flag fg-russia"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;
                        case 'jp': ?>
                            <span class="country-symbol">JP</span>
                            <span class="i-round-flag fg-japan"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;
                        case 'de': ?>
                            <span class="country-symbol">DE</span>
                            <span class="i-round-flag fg-germany"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;
                        case 'id': ?>
                            <span class="country-symbol">ID</span>
                            <span class="i-round-flag fg-indonesia"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;
                        case 'sa': ?>
                            <span class="country-symbol">SA</span>
                            <span class="i-round-flag fg-saudi-arabia"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;
                        case 'fr': ?>
                            <span class="country-symbol">FR</span>
                            <span class="i-round-flag fg-france"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;
                        case 'es': ?>
                            <span class="country-symbol">ES</span>
                            <span class="i-round-flag fg-spain"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;
                        case 'pt': ?>
                            <span class="country-symbol">PT</span>
                            <span class="i-round-flag fg-portugal"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;
                        case 'bg': ?>
                            <span class="country-symbol">BG</span>
                            <span class="i-round-flag fg-bulgaria"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;
                        case 'bd': ?>
                            <span class="country-symbol">BD</span>
                            <span class="i-round-flag fg-bangladesh"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;
                        case 'my': ?>
                            <span class="country-symbol">MY</span>
                            <span class="i-round-flag fg-malaysia"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;
                        case 'pk': ?>
                            <span class="country-symbol">PK</span>
                            <span class="i-round-flag fg-pakistan"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;
                        case 'pl': ?>
                            <span class="country-symbol">PL</span>
                            <span class="i-round-flag fg-poland"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;
                        case 'cs': ?>
                            <span class="country-symbol">CZ</span>
                            <span class="i-round-flag fg-czech-republic"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;
                        case 'zh':
                            ?>
                            <span class="country-symbol">cn</span>
                            <span class="i-round-flag fg-china"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;

                        case 'gr':
                            ?>
                            <span class="country-symbol">gr</span>
                            <span class="i-round-flag fg-greek"></span>
                            <i class="fa fa-caret-down"></i>
                            <?php break;
                    }



                    ?>
                </button>

         <ul id="mbl-lang-nav" style=" position: absolute !important; margin-left: 15px!important; margin-top: 0px !important; z-index: 99999 !important; overflow: hidden !important;" class="newUlFlag btn-flag-dropdown arabic-btn-flag-dropdown flag-drp flagBtnMob">

                    <?php $this->load->library('IPLoc', null);?>
                    <li>
                        <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/english" class="drp-item">
                            <span class="i-round-flag fg-united-kingdom"></span>
                            <span class="country-name">english</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/malay" class="drp-item">
                            <span class="i-round-flag fg-malaysia"></span>
                            <span class="country-name">malay</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/indonesian" class="drp-item">
                            <span class="i-round-flag fg-indonesia"></span>
                            <span class="country-name">indonesian</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/russuan" class="drp-item">
                            <span class="i-round-flag fg-russia"></span>
                            <span class="country-name">&#1056;&#1091;&#1089;&#1089;&#1082;&#1080;&#1081;</span>
                        </a>
                    </li>
                    <div class="clearfix langhr"><div id="other-text">Other <i class="fa fa-caret-down"></i></div></div>
                    <div class="other">
                        <li>
                            <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/arabic" class="drp-item">
                                <span class="i-round-flag fg-saudi-arabia"></span>
                                <span class="country-name">Arabic</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/bangladesh" class="drp-item">
                                <span class="i-round-flag fg-bangladesh"></span>
                                <span class="country-name">Bangladesh</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/bulgarian" class="drp-item">
                                <span class="i-round-flag fg-bulgaria"></span>
                                <span class="country-name">Bulgarian</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->config->item('domain-my');?>/LanguageSwitcher/switchLang/chinese" class="drp-item">
                                <span class="i-round-flag fg-china"></span>
                                <span class="country-name">Chinese</span>
                            </a>
                        </li>
                        <div class="clearfix"></div>
                        <li>
                            <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/czech" class="drp-item">
                                <span class="i-round-flag fg-czech-republic"></span>
                                <span class="country-name">czech</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/spanish" class="drp-item">
                                <span class="i-round-flag fg-spain"></span>
                                <span class="country-name">Espa&#241;ol</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/french" class="drp-item">
                                <span class="i-round-flag fg-france"></span>
                                <span class="country-name">Fran&#231;ais</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/german" class="drp-item">
                                <span class="i-round-flag fg-germany"></span>
                                <span class="country-name">german</span>
                            </a>
                        </li>

                        <div class="clearfix"></div>
                        <li>
                            <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/greek" class="drp-item">
                                <span class="i-round-flag fg-greek"></span>
                                <span class="country-name">Greek</span>
                            </a>
                        </li>


                        <?php if(IPLoc::WhitelistPIPCandCC()){ ?>
                            <li>
                                <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/japanese" class="drp-item">
                                    <span class="i-round-flag fg-japan"></span>
                                    <span class="country-name">&#26085;&#26412;&#35486;</span>
                                </a>
                            </li>
                        <?php } ?>

                        <li>
                            <a  href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/polish" class="drp-item">
                                <span class="i-round-flag fg-poland"></span>
                                <span class="country-name">polish</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/portuguese" class="drp-item">
                                <span class="i-round-flag fg-portugal"></span>
                                <span class="country-name">Portugu&#234;s</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/urdu" class="drp-item">
                                <span class="i-round-flag fg-pakistan"></span>
                                <span class="country-name">Urdu</span>
                            </a>
                        </li>
                    </div>


                </ul>














            <a class="navbar-brand navbar-brand-internal arabic-navbar-brand-internal" id="logo-saf-in" href="#" style="margin-top:10px;">
                <img src="<?= $this->template->Images() ?><?= FXPP::html_url() == 'ru' ? 'fxlogonewinternal-russian-02.svg' : 'fxlogonewinternal-02.svg' ?>" class="img-reponsive int-logo logo-in-saf" alt="ForexMart and LasPalmas Logo" usemap="#fxxpplaspalmas" style="    max-width: 210px;"/>


                <map name="fxxpplaspalmas">
                    <area shape="rect" coords="0,0,217,69" href="<?= FXPP::www_url('');?>" alt="ForexMart" class="nolinkline">
                    <area shape="rect" coords="217,0,434,69" href="<?=  FXPP::www_url('las-palmas');?>" alt="LasPalmas" class="nolinkline">
                </map>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse arabic-navbar-collapse <?= FXPP::html_url() == 'sa' ? 'border-none' : '' ?>" id="bs-example-navbar-collapse-1">













            <ul id="nav_ul"  class="nav navbar-nav navbar-right navbar-right-internal arabic-navbar-right-internal drp-menu secondary-level-menu">


            <?php //if(IPloc::RolloverTest()){ ?>

                <li class="dropdown drp-notification">
                    <a href="#" id="drpBtnNotif" class="dropdown-toggle drp-dwn-notif dropdown-icon" data-toggle="dropdown" role="button" aria-expanded="false"><span class="icon-new icons icons-16px icons-notification"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><div class="notification-loader"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div></li>
                        <li>
                            <ul class="notification-list scrollbar scrollbar-thin">
                                <li>
                                    <div class="notification-header">
                                        <span class="title">Notifications</span>
                                        <button class="btn-link btn-setall pull-right" id="setAllRead">Set all as read</button>
                                    </div>
                                    <div class="notification-alert">Your notifications for the last 30 days</div>
                                </li>

                             
                            </ul>
                        </li>

                    </ul>
                </li>

               <?php //} ?>






                <li class="dropdown">
                    <a href="#" class="dropdown-toggle arabic-dropdown-toggle profile" data-toggle="dropdown" role="button" aria-expanded="false" style="">
                        <?php $image = $this->session->userdata('image');
                        if($this->session->userdata('oauth_id')){
                            $img = $image;
                        }else{

                             $avator_url=base_url('assets/images/avatar.png');
                             $img_url= base_url('assets/user_images/'.$image);

                            $img=(isset($image) && $image!='') ?$img_url:$avator_url;



                           // $img =  (isset($image) && $image!='') ? base_url('assets/user_images/' . $image) : $this->template->Images() . 'avatar.png';

                        }
                       ?>
                        <img src="<?=$img;?>" id="img-dp" class="img-responsive" style="float: left; margin-right: 8px; margin-top: -5px;">
                        <span  id="userProfilenameofheader">

                             <?php
                                 $fullNameText = $this->session->userdata('full_name');
                                 $updUserName = strlen($fullNameText) > 11 ? mb_substr($fullNameText,0,11, "utf-8")."..." : $fullNameText;
                             ?>
                             <?php echo  strlen($updUserName)>0?$updUserName:lang("sample_user");?>

                             <?php //  strlen($this->session->userdata('full_name'))>0?$this->session->userdata('full_name'):lang("sample_user");?>



                        </span>





                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu arabic-dropdown-menu" role="menu">


                        <li><a class="accta" href="<?php echo FXPP::loc_url('Signout');?>">
                                <?=lang('xnv_LO');?>
                            </a></li>


                    </ul>
                </li>
                <li class="flag_pad">
                        <button class="btn-flag btn-reg btn-flag-reg arabic-btn-flag-reg btn btn-default dropdown-toggle drp-language test" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin: 20px 0 0px 0 !important;">
                        <?php
                        switch(FXPP::html_url()){
                            case 'en':
                            case '':
                                ?>
                                <span class="country-symbol">EN</span>
                                <span class="i-round-flag fg-united-kingdom"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;
                            case 'ru': ?>
                                <span class="country-symbol">RU</span>
                                <span class="i-round-flag fg-russia"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;
                            case 'jp': ?>
                                <span class="country-symbol">JP</span>
                                <span class="i-round-flag fg-japan"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;
                            case 'de': ?>
                                <span class="country-symbol">DE</span>
                                <span class="i-round-flag fg-germany"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;
                            case 'id': ?>
                                <span class="country-symbol">ID</span>
                                <span class="i-round-flag fg-indonesia"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;
                            case 'sa': ?>
                                <span class="country-symbol">SA</span>
                                <span class="i-round-flag fg-saudi-arabia"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;
                            case 'fr': ?>
                                <span class="country-symbol">FR</span>
                                <span class="i-round-flag fg-france"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;
                            case 'es': ?>
                                <span class="country-symbol">ES</span>
                                <span class="i-round-flag fg-spain"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;
                            case 'pt': ?>
                                <span class="country-symbol">PT</span>
                                <span class="i-round-flag fg-portugal"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;
                            case 'bg': ?>
                                <span class="country-symbol">BG</span>
                                <span class="i-round-flag fg-bulgaria"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;
                            case 'bd': ?>
                                <span class="country-symbol">BD</span>
                                <span class="i-round-flag fg-bangladesh"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;
                            case 'my': ?>
                                <span class="country-symbol">MY</span>
                                <span class="i-round-flag fg-malaysia"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;
                            case 'pk': ?>
                                <span class="country-symbol">PK</span>
                                <span class="i-round-flag fg-pakistan"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;
                            case 'pl': ?>
                                <span class="country-symbol">PL</span>
                                <span class="i-round-flag fg-poland"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;
                            case 'cs': ?>
                                <span class="country-symbol">CZ</span>
                                <span class="i-round-flag fg-czech-republic"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;
                            case 'zh':
                                ?>
                                <span class="country-symbol">cn</span>
                                <span class="i-round-flag fg-china"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;

                            case 'gr':
                                ?>
                                <span class="country-symbol">gr</span>
                                <span class="i-round-flag fg-greek"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;

                            case 'vn': ?>
                                <span class="country-symbol">VN</span>
                                <span class="i-round-flag fg-vietnam"></span>
                                <i class="fa fa-caret-down"></i>
                                <?php break;


                        }
                        ?>
                    </button>
                            <ul id="lang-nav" class="dropdown-menu btn-flag-dropdown arabic-btn-flag-dropdown drp-options">
                             <li class="lang_en">
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/english" class="drp-item">
                                 <span class="i-round-flag fg-united-kingdom"></span>
                                 <span class="country-name country-name-en">english</span>
                             </a>
                         </li>
                         <li class="lang_my">
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/malay" class="drp-item">
                                 <span class="i-round-flag fg-malaysia"></span>
                                 <span class="country-name country-name-my">malay</span>
                             </a>
                         </li>

                         <li class="lang_id">
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/indonesian" class="drp-item">
                                 <span class="i-round-flag fg-indonesia"></span>
                                 <span class="country-name country-name-id">indonesian</span>
                             </a>
                         </li>
                         <li class="lang_ru">
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/russuan" class="drp-item">
                                 <span class="i-round-flag fg-russia"></span>
                                 <span class="country-name country-name-ru">&#1056;&#1091;&#1089;&#1089;&#1082;&#1080;&#1081;</span>
                             </a>
                         </li>
						<div class="clearfix langhr"><div id="other-text">Other <i class="fa fa-caret-down"></i></div></div>
						<div class="other">
                        <li class="lang_sa">
                            <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/arabic" class="drp-item">
                                <span class="i-round-flag fg-saudi-arabia"></span>
                                <span class="country-name country-name-sa">Arabic</span>
                            </a>
                        </li>
                         <li class="lang_bd">
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/bangladesh" class="drp-item">
                                 <span class="i-round-flag fg-bangladesh"></span>
                                 <span class="country-name country-name-bd">Bangladesh</span>
                             </a>
                         </li>
                         <li class="lang_bg">
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/bulgarian" class="drp-item">
                                 <span class="i-round-flag fg-bulgaria"></span>
                                 <span class="country-name country-name-bg">Bulgarian</span>
                             </a>
                         </li>
                         <li class="lang_zh">
                             <a href="<?= $this->config->item('domain-my');?>/LanguageSwitcher/switchLang/chinese" class="drp-item">
                                 <span class="i-round-flag fg-china"></span>
                                 <span class="country-name country-name-zh">Chinese</span>
                             </a>
                         </li>
						<div class="clearfix"></div>
                         <li class="lang_cs">
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/czech" class="drp-item">
                                 <span class="i-round-flag fg-czech-republic"></span>
                                 <span class="country-name country-name-cs">czech</span>
                             </a>
                         </li>
                         <li class="lang_es">
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/spanish" class="drp-item">
                                 <span class="i-round-flag fg-spain"></span>
                                 <span class="country-name country-name-es">Espa&#241;ol</span>
                             </a>
                         </li>
                         <li class="lang_fr">
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/french" class="drp-item">
                                 <span class="i-round-flag fg-france"></span>
                                 <span class="country-name country-name-fr">Fran&#231;ais</span>
                             </a>
                         </li>
                         <li class="lang_de">
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/german" class="drp-item">
                                 <span class="i-round-flag fg-germany"></span>
                                 <span class="country-name country-name-de">german</span>
                             </a>
                         </li>

						<div class="clearfix"></div>
                         <li>
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/greek" class="drp-item">
                                 <span class="i-round-flag fg-greek"></span>
                                 <span class="country-name">Greek</span>
                             </a>
                         </li>
                         <li class="lang_pl">
                             <a  href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/polish" class="drp-item">
                                 <span class="i-round-flag fg-poland"></span>
                                 <span class="country-name country-name-pl">polish</span>
                             </a>
                         </li>
                         <li class="lang_pt">
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/portuguese" class="drp-item">
                                 <span class="i-round-flag fg-portugal"></span>
                                 <span class="country-name country-name-pt">Portugu&#234;s</span>
                             </a>
                         </li>
                        <li class="lang_pk">
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/urdu" class="drp-item">
                                 <span class="i-round-flag fg-pakistan"></span>
                                 <span class="country-name country-name-pk">Urdu</span>
                             </a>
                        </li>

                        <div class="clearfix"></div>
                            <?php if(IPLoc::WhitelistPIPCandCC()){ ?>
                                <li  class="lang_jp">
                                    <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/japanese" class="drp-item">
                                        <span class="i-round-flag fg-japan"></span>
                                        <span class="country-name country-name-jp">&#26085;&#26412;&#35486;</span>
                                    </a>
                                </li>
                            <?php } ?>

                        <li class="lang_vn">
                            <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/vietnam " class="drp-item">
                                <span class="i-round-flag fg-vietnam "></span>
                                <span class="country-name country-name-vn">Vietnam </span>
                            </a>
                        </li>



				</div>
                    </ul>
                </li>

            </ul>







    <form id="searchform" class="navbar-form navbar-right nav-search border-none" role="search">
        <div class="form-group int-search-group row trt">


<?php /* ?>
                <button id="mbl-lang-btn" style="float: left; margin-left: 40px !important; margin-top: 8px !important;  " class="btn-flag btn-reg btn-flag-reg arabic-btn-flag-reg btn btn-default flagBtnMob  mobv" type="button">
                    <?php
                    switch(FXPP::html_url()){
                        case 'en':
                        case '':
                            ?>
                            <img src="<?= $this->template->Images()?>flag.png" width="35px" height="30"/>
                            <?php break;
                        case 'ru': ?>
                            <img src="<?= $this->template->Images()?>flags/russia.png" width="35px" height="30"/>
                            <?php break;
                        case 'jp': ?>
                            <img src="<?= $this->template->Images()?>flags/japan.png" width="35px" height="30"/>
                            <?php break;
                        case 'de': ?>
                            <img src="<?= $this->template->Images()?>flags/germany.png" width="35px" height="30"/>
                            <?php break;
                        case 'id': ?>
                            <img src="<?= $this->template->Images()?>flags/indonezia.png" width="35px" height="30"/>
                            <?php break;
                        case 'sa': ?>
                            <img src="<?= $this->template->Images()?>flags/saudiarabia.png" width="35px" height="30"/>
                            <?php break;
                        case 'bd': ?>
                            <img src="<?= $this->template->Images()?>flags/bangladesh.png" width="35px" height="30"/>
                            <?php break;
                        case 'fr': ?>
                            <img src="<?= $this->template->Images()?>flags/france.png" width="35px" height="30"/>
                            <?php break;
                        case 'es': ?>
                            <img src="<?= $this->template->Images()?>flags/spain.png" width="35px" height="30"/>
                            <?php break;
                        case 'it': ?>
                            <img src="<?= $this->template->Images()?>flags/italy.png" width="35px" height="30"/>
                            <?php break;
                        case 'pt': ?>
                            <img src="<?= $this->template->Images()?>flags/portugal.png" width="35px" height="30"/>
                            <?php break;
                        case 'bg': ?>
                            <img src="<?= $this->template->Images()?>flags/bulgaria.png" width="35px" height="30"/>
                            <?php break;
                        case 'my': ?>
                            <img src="<?= $this->template->Images()?>flags/malaysia.png" width="35px" height="30"/>
                            <?php break;
                        case 'pk': ?>
                            <img src="<?= $this->template->Images()?>flags/pakistan.png" width="35px" height="30"/>
                            <?php break;
                        case 'pl': ?>
                            <img src="<?= $this->template->Images()?>flags/poland.png" width="35px" height="30"/>
                            <?php break;
                        case 'cs':
                            ?>
                            <img src="<?= $this->template->Images()?>flags/czech.PNG" width="35px" height="30"/><!-- added -->
                            <?php break;
                        case 'gr': ?>
                            <img src="<?= $this->template->Images()?>flags/greece.png" width="35px" height="30"/>
                            <?php break;
                        case 'zh':
                            ?>
                            <img src="<?= $this->template->Images()?>flags/china.png" width="35px" height="30"/>
                            <?php break;
                    }
                    ?>
















                </button>
       <?php */ ?>


<style>
#lang-nav {
    width: 730px;
	padding: 40px;
}

#lang-nav.drp-options li {
    width: 160px;
    float: left;
}
.drp-options li {
    border-bottom: 0px solid #ececec;
}
.navbar-right-internal li ul li a:hover{
	background: #fff !important;
	color: #297fc1 !important;
}


.dropdown-toggle.btn-default {
	background: #fff !important;
}
.topnavmenu .dropdown-menu {
}
.topnavmenu #flagmenu1.dropdown-menu {
	background: #fff;
	opacity: 1;
	padding: 40px;
}
.btn-flag-dropdown li {
    width: 150px;
    float: left;
}
.dropdown-menu.btn-flag-dropdown > li > a {
    color: #333;
}
.drp-options li {
    border-bottom: 0px solid #ececec;
}
.langhr hr {
	margin-top: 10px;
	margin-bottom: 10px;
}
.topnavmenu .dropdown-menu {
    top: 55px;
}
.drp-options li a:hover{
	background: #fff !important;
	color: #297fc1;
}
.country-name, .country-symbol {
    text-transform: capitalize;
	font-size: 16px;
	font-weight: 400;
}

.dropdown-toggle.btn-flag-reg:hover {
    color: #333 !important;
}

.other {
    color: #0b4b7b;
}

.other a{
	padding: 10px 8px;	
    font-weight: 300;
    color: #333;
	text-decoration: none;
}
a.drp-item {
    font-weight: 300;
    color: #333;
	font-size: 16px;
}
#other-text {
	color: #297fc1;
	display: none;
	cursor: pointer;
	font-weight: 400;
	font-size: 16px;
    padding-bottom: 15px;
    padding-left: 40px;
}
#mbl-lang-nav {
    background: #fff;
    display: none;
}
ul#mbl-lang-nav {
    list-style: none;
}
.country-name, .country-symbol {
    text-transform: capitalize;
    color: #333;
    font-size: 16px;
    font-weight: 300;
}
.navbar-right-internal li ul li a {
	padding: 10px 8px !important;
}
@media only screen and (max-width: 786px) {
	.flag-drp {
		width: 230px;
	}
	#other-text {
		color: #297fc1;
		display: block;
	}

    /*#other-text {*/
        /*color: #297fc1;*/
        /*display: none;*/
        /*cursor: pointer;*/
        /*font-weight: 400;*/
        /*font-size: 16px;*/
        /*padding-bottom: 15px;*/
        /*padding-left: 40px;*/
    /*}*/



	.btn-flag-dropdown li {
		width: auto;
		float: none;;
	}
	#mbl-lang-nav > li > a,
	.dropdown-menu > li > a {
		font-size: 14px;
		padding: 10px;
		color: #333;
	}	
	.other {
		display: none;
	}
	#mbl-lang-nav.dropdown-menu {
		left: 0 !important;
		right: 0 !important;
	}
	.flag-drp {
		top: 100%;
	}
}
</style>
                
                <ul style="float: right; margin-top: 8px !important; " id="searchcon" class="input-group searchBtn">
                    <input type="text" class="form-control round-0" id="SearchInInternal" placeholder="<?=lang('search');?>">
                    <li class="input-group-addon round-0 zeropadding">
                        <a id="navsearch" class="searchA" href="javascript:void(0)" >
                            <i class="fa fa-search">
                            </i>
                        </a>
                    </li>
                </ul>




<?php /*  ?>
<ul id="mbl-lang-nav" style=" position: absolute !important; margin-left: 15px!important; margin-top: 0px !important; z-index: 99999 !important; overflow: hidden !important;" class="btn-flag-dropdown arabic-btn-flag-dropdown flag-drp flagBtnMob">

                    <?php $this->load->library('IPLoc', null);?>
 <li>
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/english" class="drp-item">
                                 <span class="i-round-flag fg-united-kingdom"></span>
                                 <span class="country-name">english</span>
                             </a>
                         </li>
                         <li>
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/malay" class="drp-item">
                                 <span class="i-round-flag fg-malaysia"></span>
                                 <span class="country-name">malay</span>
                             </a>
                         </li>

                         <li>
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/indonesian" class="drp-item">
                                 <span class="i-round-flag fg-indonesia"></span>
                                 <span class="country-name">indonesian</span>
                             </a>
                         </li>
                         <li>
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/russuan" class="drp-item">
                                 <span class="i-round-flag fg-russia"></span>
                                 <span class="country-name">&#1056;&#1091;&#1089;&#1089;&#1082;&#1080;&#1081;</span>
                             </a>
                         </li>
						<div class="clearfix langhr"><div id="other-text">Other <i class="fa fa-caret-down"></i></div><hr></div>
						<div class="other">
                        <li>
                            <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/arabic" class="drp-item">
                                <span class="i-round-flag fg-saudi-arabia"></span>
                                <span class="country-name">Arabic</span>
                            </a>
                        </li>
                         <li>
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/bangladesh" class="drp-item">
                                 <span class="i-round-flag fg-bangladesh"></span>
                                 <span class="country-name">Bangladesh</span>
                             </a>
                         </li>
                         <li>
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/bulgarian" class="drp-item">
                                 <span class="i-round-flag fg-bulgaria"></span>
                                 <span class="country-name">Bulgarian</span>
                             </a>
                         </li>
                         <li>
                             <a href="<?= $this->config->item('domain-my');?>/LanguageSwitcher/switchLang/chinese" class="drp-item">
                                 <span class="i-round-flag fg-china"></span>
                                 <span class="country-name">Chinese</span>
                             </a>
                         </li>
						<div class="clearfix"></div>
                         <li>
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/czech" class="drp-item">
                                 <span class="i-round-flag fg-czech-republic"></span>
                                 <span class="country-name">czech</span>
                             </a>
                         </li>
                         <li>
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/spanish" class="drp-item">
                                 <span class="i-round-flag fg-spain"></span>
                                 <span class="country-name">Espa&#241;ol</span>
                             </a>
                         </li>
                         <li>
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/french" class="drp-item">
                                 <span class="i-round-flag fg-france"></span>
                                 <span class="country-name">Fran&#231;ais</span>
                             </a>
                         </li>
                         <li>
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/german" class="drp-item">
                                 <span class="i-round-flag fg-germany"></span>
                                 <span class="country-name">german</span>
                             </a>
                         </li>

						<div class="clearfix"></div>
                         <li>
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/greek" class="drp-item">
                                 <span class="i-round-flag fg-greek"></span>
                                 <span class="country-name">Greek</span>
                             </a>
                         </li>


                         <?php if(IPLoc::WhitelistPIPCandCC()){ ?>
                        <li>
                            <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/japanese" class="drp-item">
                                <span class="i-round-flag fg-japan"></span>
                                <span class="country-name">&#26085;&#26412;&#35486;</span>
                            </a>
                        </li>
                        <?php } ?>

                         <li>
                             <a  href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/polish" class="drp-item">
                                 <span class="i-round-flag fg-poland"></span>
                                 <span class="country-name">polish</span>
                             </a>
                         </li>
                         <li>
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/portuguese" class="drp-item">
                                 <span class="i-round-flag fg-portugal"></span>
                                 <span class="country-name">Portugu&#234;s</span>
                             </a>
                         </li>
                        <li>
                             <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/urdu" class="drp-item">
                                 <span class="i-round-flag fg-pakistan"></span>
                                 <span class="country-name">Urdu</span>
                             </a>
                        </li>
				</div>


                </ul>

   <?php */ ?>



        </div>
    </form>






        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>




<script>
$(document).on('click', 'div[id^="other-text"]', function() {
	console.log('uuuuuuu');
	$(".other").toggle();	
});
$('#mbl-lang-btn').click(function(){
	$("#mbl-lang-nav").toggle();
});








$('#navbar-menu-1').click(function(){
    $("#mbl-lang-nav").hide();
});
$('.flagBtnMob').click(function(){
    console.log('okkkkk');

    $("#bs-example-navbar-collapse-1").removeClass('in');

});








</script>



<script>
    var lang='<?=FXPP::html_url()?>';

    if(lang==''){
        var lang='en';
    }
    $('.lang_'+lang).addClass('disabled_li');
    $('.country-name-'+lang).addClass('langStrong');

</script>


