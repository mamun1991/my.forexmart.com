  
    <script type="text/javascript">
        //     $(window).load(function() {
        // // If the web browser type is Safari
        //         if( navigator.userAgent.toLowerCase().indexOf('safari/') > -1)
        //         {
        //             $(".logo-con-saf").hide();
        //             $("#logo-saf-ap").append('<img src="<?= FXPP::html_url() == 'ru' ? $this->template->Images() . 'forexmart-logo-russian.svg' : $this->template->Images() . 'forexmart-logo.svg' ?>" class="img-reponsive logo logo-img logo-con-saf" usemap="#fxxpplaspalmas">');
        //         }
        //     });
        // removed FXPP-8712
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("head").append('<style>.hidden-menu { display: none;}.nd{padding-bottom: 9px!important;}.mg-top{margin-top: 13px;}</style>');
        });
    </script>
    <style>
        .drp-options > li > a {
            padding: 10px 8px !important;
        }
        #lang-nav-desk {
            width: 730px;
            padding: 40px;
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
        .langhr {
            padding: 5px 0px;
            margin-left: 40px;
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
        #other-text {
            color: #297fc1;
            display: none;
            cursor: pointer;
            font-weight: 400;
            font-size: 16px;
        }

        @media only screen and (max-width: 767px) {
            #other-text {
                color: #297fc1;
                display: block;
            }
            .btn-flag-dropdown li {
                width: auto;
                float: none;;
            }
            .other {
                display: none;
            }
            #lang-nav.dropdown-menu {
                left: unset !important;
                padding: 40px;
                margin: 0px;
                width: 230px;
                margin-top: 12px;
                margin-right: 18px;
            }


        }
    </style>

    <style rel="stylesheet" type="text/css">
        @media screen and (max-width: 768px) {
            li.search_mob {
                width: 15%;
            }
        }






        @media screen and (max-width: 665px) {

            .hidden-main-header.ext-arabic-hidden-main-header {
                border-bottom: none;
            }

            .extNavMenu {
                display: flex;
            }


            .drp-language {
                width: 90px;
            }

        }


        @media screen and (max-width: 370px) {

            .navbar-brand img {
                margin-top: 10px;
            }
        }














        @media screen and (min-width: 992px) {

            div#searchtop {
                display: none;
            }
        }




        @media screen and (min-width: 992px) and (max-width: 1200px){
            .logo {
                margin-top: -40px !important;
                transition: all ease 0.3s;
            }

        }

        @media screen and (max-width: 1199px){
            .nav>li>a {
                padding: 8px 17.1px !important;
            }

        }


        @media screen and (max-width: 767px){
            li.showAlways2 {
                padding-left: 10px !important;
            }

        }

        .logo {
            margin-top: -25px;
            transition: all ease 0.3s;
        }


        .logo-img {
            min-width: 122px;
        }










        .container.extNavMenu:lang(sa) {
            /*direction: ltr;*/
        }

        ul.nav.navbar-nav.navbar-right.ext-arabic-hidden-navbar-right.ryt:lang(sa)  {
            padding-left: 10px;
        }

        a#menu-navbar:lang(sa)  {
            padding-left: 30px;
        }

        img.img-reponsive.logo.ext-arabic-logo.logo-img:lang(sa) {
            min-width: 120px;
            min-height: 66px;
        }

        span#logo-saf-ap:lang(sa) {
            padding-bottom: 38px;
            margin-top: -5px;
        }


        .hidden-main-header.ext-arabic-hidden-main-header:lang(sa) {
            padding-bottom: 30px;
        }



        @media screen and (min-width: 992px) and (max-width: 1199px){


            ul.nav.navbar-nav.navbar-right.ext-arabic-hidden-navbar-right.ryt:lang(sa) {
                padding-left: 0px !important;
            }
            .hidden-main-header.ext-arabic-hidden-main-header:lang(sa) {
                padding-bottom: 0px;
            }
            .hidden-main-header.ext-arabic-hidden-main-header:lang(sa) {
                padding-bottom: 0px !important;
            }

            img.img-reponsive.logo.ext-arabic-logo.logo-img:lang(sa) {

                min-height: 100px;
                min-width: 320px;
            }



            .navbar-brand>img:lang(sa) {
                /*display: inline;*/
            }



        }

        @media screen and (min-width: 1200px) {

            ul.xnav.nav.navbar-nav.navbar-right.ext-arabic-navbar-right.ryt:lang(sa) {
                padding-top: 10px;
            }

            nav.login-navbar.navbar.navbar-default.hidden-navbar-default.nd.round-0:lang(sa) {
                padding-bottom: 0px !important;
            }
        }


        ul#lang-nav {
            top: 63px !important;
        }








        @media screen and (max-width: 767px) {
            .dropdown-menu:lang(sa) {
                right: unset !important;
                left: 0 !important;
                position: absolute !important;
            }

            #lang-nav.dropdown-menu:lang(sa) {
                left: 0 !important;
                padding: 40px;
                margin: 0px;
            }

            a#menu-navbar:lang(sa) {
                padding-left: 20px;
            }


            .dropdown-menu:lang(pk) {
                right: unset !important;
                left: 0 !important;
                position: absolute !important;
            }

            #lang-nav.dropdown-menu:lang(pk) {
                left: 0 !important;
                padding: 40px;
                margin: 0px;
            }

            a#menu-navbar:lang(pk) {
                padding-left: 20px;
            }


        }


        @media screen and (min-width: 768px){
            ul#lang-nav:lang(sa) {
                left: 0 !important;
                right: unset !important;
                float: right !important;
                padding: 40px;
            }

            ul#lang-nav:lang(pk) {
                left: 0 !important;
                right: unset !important;
                float: right !important;
                padding: 40px;
            }

            .ryt li:last-child:lang(sa) {
                margin-right: 10px;
            }

            .ryt li:last-child:lang(pk) {
                margin-right: 10px;
            }
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


        .ryt>li>.dropdown-menu {

            margin-top: -12px !important;

        }

        @media only screen and (max-width: 767px){
            #lang-nav.dropdown-menu {
                margin-right: -40px !important;
            }
        }

        @media screen and (min-width: 768px){
            ul#lang-nav {
                left: unset !important;
                right: 0 !important;
                float: right !important;
                width: 700px !important;
                padding: 25px !important;
            }
        }



    </style>



    <?php if($this->session->userdata('logged')){ ?>

        <style>

            @media screen and (min-width: 768px){
                li#loginname {
                    padding-left: 130px;
                }

                li#loginname:lang(sa)  {
                    padding-left: 0px;
                }
            }

            @media screen and (min-width: 768px) and (max-width: 1199px){
                li#loginname:lang(sa) {
                    padding-right: 100px;
                }

                li#loginname:lang(pk) {
                    padding-right: 100px;
                }

            }


        </style>

    <?php }?>








    <?php $this->load->library('IPLoc', null); ?>
    <nav class="login-navbar navbar navbar-default hidden-navbar-default nd round-0" >
        <div class="container extNavMenu">



            <div class="hidden-main-header ext-arabic-hidden-main-header">
                <div class="navbar-header ext-arabic-navbar-header page-scroll">
        <span class="navbar-brand page-scroll nb_custom ext-arabic-navbar-brand out_none mg-top" id="logo-saf-ap" >
            <img src="<?= FXPP::html_url() == 'ru' ? $this->template->Images() . 'forexmart-logo-russian.svg' : $this->template->Images() . 'forexmart-logo.svg' ?>" class="img-reponsive logo ext-arabic-logo logo-img" usemap="#fxxpplaspalmas" >
        </span>
                    <map name="fxxpplaspalmas">
                        <area shape="rect" coords="0,0,217,69" href="<?= FXPP::www_url(''); ?>" alt="ForexMart" class="nolinkline hit logo-img ">
                        <area shape="rect" coords="217,0,434,69" href="<?= FXPP::www_url('las-palmas'); ?>" alt="LasPalmas" class="nolinkline hit logo-img">
                    </map>












                    <div class="clearfix"></div>
                </div>
            </div>




            <div class="reg-holder ext-arabic-reg-holder sa-links-top">
                <ul class="xnav nav navbar-nav navbar-right ext-arabic-navbar-right ryt">
                    <?php if($this->session->userdata('logged')){?>
                        <li id="loginname" class="loginname-drop">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?=lang('xnv_hi');?> &#44;  <?=$this->session->userdata('full_name')?> <span class="caret "></span>
                            </a>
                            <ul class="dropdown-menu btn-flag-dropdown btn-user-dropdown" role="menu" id="usermenu">
                                <li><a href="<?= FXPP::my_url('my-account'); ?>"> <?=lang('xnv_goto');?></a></li>
                                <li class="divider"></li>
                                <li><a href="<?=FXPP::my_url('signout')?>"><?=lang('xnv_LO');?></a></li>
                            </ul>
                        </li>
                    <?php }  else{?>
                        <?php $router =& load_class('Router', 'core');
                        if(strtolower($router->fetch_class()=='signin')){ ?>

                        <?php }else{?>
                            <?php //if(IPLoc::Office()){ ?>


                            <?php switch(FXPP::html_url()){
                                case 'en':
                                case '':
                                case 'id':
                                case 'jp':
                                case 'de':
                                case 'fr':
                                case 'it':
                                case 'sa':
                                case 'es':
                                case 'pt':
                                case 'bg':
                                case 'my':
                                case 'pl':
                                case 'pk':
                                case 'sk':
                                case 'gr':
                                case 'cs':
                                case 'vn':
                                case 'zh': ?>

                                    <li >
                                        <a href="https://webterminal.forexmart.com/" target="_blank" class="mbtn btn-reg btn-reg2 custom-b  ">
                                            <?=lang('xnv_webtrader');?>
                                        </a>
                                    </li>

                                    <?php break;
                                case 'ru': ?>
                                    <li >
                                        <a href="https://webterminal.forexmart.com/" target="_blank" class="mbtn btn-reg btn-reg2 custom-b">
                                            <?=lang('xnv_webtrader');?>
                                        </a>
                                    </li>
                                    <?php break;
                                case 'bd': ?>
                                    <li >
                                        <a href="https://webterminal.forexmart.com/" target="_blank" class="mbtn btn-reg btn-reg2 custom-b">
                                            <?=lang('xnv_webtrader');?>
                                        </a>
                                    </li>
                                    <?php break;
                                default:
                                    ?>
                                    <li>
                                        <a href="https://webterminal.forexmart.com/">
                                            <img src="<?= $this->template->Images()?>webtrader-icon.png" class="links-icon" width="20" alt="" />
                                            <?=lang('xnv_webtrader');?>
                                        </a>
                                    </li>

                                    <?php
                                    break;
                            }
                            //} ?>


                            <li >
                                <a  href="<?= FXPP::my_url('partner/signin');?>" target="_blank" class="mbtn btn-partner-reg btn-partner-reg2 custom-a hidePartButton"> <?=lang('xnv_PL');?> </a>
                            </li>
                            <li >
                                <a href="<?= FXPP::my_url('client/signin');?>" target="_blank" class="mbtn btn-reg btn-reg2 custom-b hideClientButton"> <?=lang('xnv_CL');?></a>
                            </li>
                        <?php }   ?>
                        <li >
                            <a target="_blank" href="<?= FXPP::www_url('register'); ?>"  class="mbtn btn-login custom-mbl-c">
                                <?php // lang('ex_nav_reg'); ?>
                                <?=lang('xnv_R');?>
                            </a>
                        </li>
                    <?php }   ?>

                    <li class="showAlways2 show1">
                        <button id="langbtn" class="btn-reg btn-flag-reg btn btn-default dropdown-toggle flagbtn drp-language" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin: 0 !important;">

                            <?php
                            switch (FXPP::html_url()) {
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

                                case 'gr': ?>
                                    <span class="country-symbol">GR</span>
                                    <span class="i-round-flag fg-greek"></span>
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
                                case 'zh': ?>
                                    <span class="country-symbol">cn</span>
                                    <span class="i-round-flag fg-china"></span>
                                    <i class="fa fa-caret-down"></i>
                                    <?php break;
                                case 'bd': ?>
                                    <span class="country-symbol">BD</span>
                                    <span class="i-round-flag fg-bangladesh"></span>
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
                        <ul id="lang-nav-desk" class="dropdown-menu btn-flag-dropdown drp-options ttttt" style="display: none;">
                            <!--<span class="icon-image-triangle"></span>-->

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
                            <div class="clearfix langhr"><div id="other-text">Other...</div></div>
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
                            <li class="lang_cn">
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
                            <?php if(IPLoc::WhitelistPIPCandCC() ){ ?>
                                <li >
                                    <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/greek" class="drp-item">
                                        <span class="i-round-flag fg-greek"></span>
                                        <span class="country-name country-name-gr">Greek</span>
                                    </a>
                                </li>
                                <!--  whitelistcountry -->
                                <li class="lang_jp">
                                    <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/japanese" class="drp-item">
                                        <span class="i-round-flag fg-japan"></span>
                                        <span class="country-name country-name-jp">&#26085;&#26412;&#35486;</span>
                                    </a>
                                </li>
                                <!-- whitelistcountry-->
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
                                <div class="clearfix"></div>
                                <li class="lang_pk">
                                    <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/urdu" class="drp-item">
                                        <span class="i-round-flag fg-pakistan"></span>
                                        <span class="country-name country-name-pk">Urdu</span>
                                    </a>
                                </li>

                                <li class="lang_vn">
                                    <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/vietnam " class="drp-item">
                                        <span class="i-round-flag fg-vietnam "></span>
                                        <span class="country-name country-name-vn">Vietnam </span>
                                    </a>
                                </li>
                            <?php }else{?>
                                <li>
                                    <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/greek" class="drp-item">
                                        <span class="i-round-flag fg-greek"></span>
                                        <span class="country-name country-name-gr">Greek</span>
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
                                <li class="lang_vn">
                                    <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/urdu" class="drp-item">
                                        <span class="i-round-flag fg-pakistan"></span>
                                        <span class="country-name country-name-pk">Urdu</span>
                                    </a>
                                </li>

                                <div class="clearfix"></div>

                                <li>
                                    <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/vietnam " class="drp-item">
                                        <span class="i-round-flag fg-vietnam "></span>
                                        <span class="country-name country-name-vn">Vietnam </span>
                                    </a>
                                </li>

                            <?php } ?>

                        </ul>
                    </li>

                </ul>

            </div>





            <div class="hidden-reg-holder ext-arabic-hidden-reg-holder">
                <ul class="nav navbar-nav navbar-right ext-arabic-hidden-navbar-right ryt">

                    <?php if($this->session->userdata('logged')){?>
                        <li id="loginname" class="loginname-drop">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?=lang('xnv_hi');?> &#44;  <?=$this->session->userdata('full_name')?> <span class="caret "></span>
                            </a>
                            <ul class="dropdown-menu btn-flag-dropdown btn-user-dropdown" role="menu" id="usermenu">
                                <li><a href="<?= FXPP::my_url('my-account'); ?>"> <?=lang('xnv_goto');?></a></li>
                                <li class="divider"></li>
                                <li><a href="<?=FXPP::my_url('signout')?>"><?=lang('xnv_LO');?></a></li>
                            </ul>
                        </li>
                    <?php }  else{?>
                        <li id="wl2">
                            <a href="https://www.forexmart.com/webterminal" target="_blank" class="mbtn btn-reg btn-reg2 custom-mbl-b"><?=lang('xnv_webtrader');?>
                            </a>
                        </li>
                        <li id="pl2">
                            <a  href="<?= FXPP::my_url('partner/signin');?>" target="_blank" class="mbtn btn-partner-reg btn-partner-reg2 custom-a hidePartButton"> <?=lang('xnv_PL');?> </a>
                        </li>
                        <li id="cl2" >
                            <a href="<?= FXPP::my_url('client/signin');?>" target="_blank" class="mbtn btn-reg btn-reg2 btn-partner-reg custom-mbl-b hideClientButton">
                                <?=lang('xnv_CL');?>
                            </a></li>
                        <li id="r2">
                            <a target="_blank" href="<?= FXPP::www_url('register'); ?>"  class="mbtn btn-login custom-mbl-c">
                                <?php // lang('ex_nav_reg'); ?>
                                <?=lang('xnv_R');?>
                            </a>
                        </li>
                    <?php }   ?>


                    <li class="showAlways2 show2">
                        <button id="langbtn"  class="btn-reg btn-flag-reg btn btn-default dropdown-toggle flagbtn drp-language" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin: 0 !important;">

                            <?php
                            switch (FXPP::html_url()) {
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
                                case 'zh': ?>
                                    <span class="country-symbol">cn</span>
                                    <span class="i-round-flag fg-china"></span>
                                    <i class="fa fa-caret-down"></i>
                                    <?php break;
                                case 'bd': ?>
                                    <span class="country-symbol">BD</span>
                                    <span class="i-round-flag fg-bangladesh"></span>
                                    <i class="fa fa-caret-down"></i>
                                    <?php break;
                            }
                            ?>
                        </button>

                        <ul id="lang-nav" class="dropdown-menu btn-flag-dropdown drp-options">
                            <!--<span class="icon-image-triangle"></span>-->

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
                            <div class="clearfix langhr"><div id="other-text">Other...</div></div>
                            <div class="other">
                                <li class="lang_sa">
                                    <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/arabic" class="drp-item">
                                        <span class="i-round-flag fg-saudi-arabia"></span>
                                        <span class="country-name country-name-sa">Arabic</span>
                                    </a>
                                </li>
                                <li  class="lang_bd">
                                    <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/bangladesh" class="drp-item">
                                        <span class="i-round-flag fg-bangladesh"></span>
                                        <span class="country-name country-name-bd">Bangladesh</span>
                                    </a>
                                </li>
                                <li  class="lang_bg">
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
                                <li class="lang_jp">
                                    <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/japanese" class="drp-item">
                                        <span class="i-round-flag fg-japan"></span>
                                        <span class="country-name country-name-jp">&#26085;&#26412;&#35486;</span>
                                    </a>
                                </li>


                                <?php

                                /*



                                if(IPLoc::WhitelistPIPCandCC()){   ?>
                               <li class="lang_jp">
                                   <a href="<?= $this->config->item('domain-my'); ?>/LanguageSwitcher/switchLang/japanese" class="drp-item">
                                       <span class="i-round-flag fg-japan"></span>
                                       <span class="country-name country-name-jp">&#26085;&#26412;&#35486;</span>
                                   </a>
                               </li>
                               <?php }

                               */

                                ?>

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
            </div>



            <a class="toggletop menu-icon menu-button navbar-toggle ext-secondary-arabic-menu-button" id="menu-navbar" href="javascript:void(0)"></a>
        </div>

    </nav>
    <div id="nav" class="nav-holder">
        <div class="container index-container ext-arabic-index-container">
            <div class="secondary-navigation " style="-webkit-backface-visibility: hidden;">
                <div class="hidden-menu">
                    <div class="accordion" id="leftMenu">

                        <div class="accordion-group top-accordion-group hidden-top-accordion">
                            <div class="accordion-heading ext-arabic-accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#collapseZero">
                                    <i class="glyphicon glyphicon-menu-down"></i>
                                    <?php if($this->session->userdata('logged')){?>
                                        <?=lang('xnv_MyAcc');?>
                                    <?php }else{?>
                                        <?=lang('xnv_LogReg');?>
                                    <?php }   ?>
                                </a>
                            </div>
                            <div id="collapseZero" class="accordion-body collapse" style="height: 0px; ">
                                <div class="accordion-inner ext-arabic-accordion-inner">
                                    <ul>
                                        <?php if($this->session->userdata('logged')){?>
                                            <li>
                                                <a href="<?= FXPP::my_url('my-account'); ?>"><img src="<?= $this->template->Images()?>partners-icon.png" width="20" alt="" />  <?=lang('xnv_gotoMob');?></a>
                                            </li>
                                            <li>
                                                <a href="<?=FXPP::my_url('signout')?>"><img src="<?= $this->template->Images()?>partners-icon.png" width="20" alt="" /> <?=lang('xnv_LO');?></a>
                                            </li>
                                        <?php }else{?>
                                            <?php switch(FXPP::html_url()){
                                                case 'en':
                                                case '':
                                                case 'id':
                                                case 'jp':
                                                case 'de':
                                                case 'fr':
                                                case 'it':
                                                case 'sa':
                                                case 'es':
                                                case 'pt':
                                                case 'bg':
                                                case 'my':
                                                case 'pl':
                                                case 'pk':
                                                case 'cs':
                                                    ?>
                                                    <li class="active">
                                                        <a href="https://www.forexmart.com/webterminal" target="_blank">
                                                            <img src="<?= $this->template->Images()?>webtrader-icon.png" width="20" alt="" />  <?=lang('xnv_webtrader');?></a>
                                                    </li>
                                                    <?php break;
                                                case 'ru': ?>
                                                    <li class="active">
                                                        <a href="https://webtrader.forexmart.com/ru/login" target="_blank">
                                                            <img src="<?= $this->template->Images()?>webtrader-icon.png" width="20" alt="" />  <?=lang('xnv_webtrader');?></a>
                                                    </li>
                                                    <?php break;
                                                default:
                                                    ?>
                                                    <li class="active">
                                                        <a href="https://www.forexmart.com/webterminal" target="_blank">
                                                            <img src="<?= $this->template->Images()?>webtrader-icon.png" width="20" alt="" />  <?=lang('xnv_webtrader');?></a>
                                                    </li>
                                                    <?php
                                                    break;
                                            }
                                            //} ?>
                                            <li>
                                                <a href="<?= FXPP::my_url('partner/signin');?>" target="_blank" class="hidePartButton"><img src="<?= $this->template->Images()?>partners-icon.png" width="20" alt="" />  <?=lang('xnv_PL')?></a>
                                            </li>
                                            <li>
                                                <a href="<?= FXPP::my_url('client/signin');?>" target="_blank" class="hideClientButton"><img src="<?= $this->template->Images()?>client-icon.png" width="20" alt="" />  <?=lang('xnv_CL')?></a>
                                            </li>
                                            <li>
                                                <a href="<?= FXPP::www_url('register');?>" target="_blank"><img src="<?= $this->template->Images()?>register-icon.png" width="20" alt="" />  <?=lang('xnv_R')?></a>
                                            </li>
                                        <?php }   ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!--                    <div class="accordion-group">-->
                        <!--                        <div class="headerAll accordion-heading accordion-search-form">-->
                        <!--                            <div class="input-group expand" id="mobilesearch"  >-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!--                    </div>-->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <link href="<?php echo $this->template->Css()?>view-ext-nav.css" rel="stylesheet">
    <script type="text/javascript">
        $(document).ready(function () {
            $('.page-link').mouseover(function () {
                $($(this).data('target')).fadeIn("fast");

            })
            $('.page-link').mouseleave(function () {
                $($(this).data('target')).fadeOut("fast");
            });
            $(".hidden-menu").hide();
            $(".menu-button").show();
            $('.menu-button').click(function(){
                $(".hidden-menu").slideToggle();
            });
        });

        $(document).ready(function(){
            //$("#searchfield").attr("placeholder","<?=lang('search');?>");

            (function($){jQuery.expr[':'].Contains=function(a,i,m){return(a.textContent||a.innerText||"").toUpperCase().indexOf(m[3].toUpperCase())>=0;};function listFilter(header,list){var form=$("<form>").attr({"class":"filterformset","action":"#"}),input=$("<input>").attr({"id":"mysearchfield","class":"form-control round-0 filterinput","type":"text","placeholder":"<?=lang('search');?>"});$(form).append(input).appendTo(header);$(input).change(function(){var filter=$(this).val();if(filter){$(list).find("a:not(:Contains("+filter+"))").parent().slideUp();$(list).find("a:Contains("+filter+")").parent().slideDown();}else{$(list).find("li").slideDown();}return false;}).keyup(function(){if(!$("#mysearchfield").val().length==0){$(".searchscope").css('display','none');$("#searchloc").css('display','block');}else{$(".searchscope").css('display','block');$("#searchloc").css('display','none');}$(this).change();}).focus(function(){$(this).change();});}$(function(){listFilter($("#mobilesearch"),$(".list"));});}(jQuery));

        });

    </script>


    <script>

        $(document).on('click', 'div[id^="other-text"]', function() {
            $(".other").toggle();
        });

        var cntr = 0;

        $(document).click(function(event) {
            if (!$(event.target).is(".showAlways2")) {
                cntr = 0;
            }
        });

        $('.showAlways2').click(function(){
//    $("#lang-nav").slideToggle();

            //$('#lang-nav').show();

            if(isMoobile()){
                if($("#lang-nav").hasClass('opentab')){
                    $('#lang-nav').hide();
                    $("#lang-nav").removeClass('opentab');
                    if(cntr == 0){
                        $('#lang-nav').show();
                        $("#lang-nav").addClass('opentab');
                    }
                    cntr = 1;
                } else {
                    $('#lang-nav').show();
                    $("#lang-nav").addClass('opentab');
                    cntr = 1;
                }
            } else {


                if($("#lang-nav").hasClass('opentab')){
                    $('#lang-nav').hide();
                    $("#lang-nav").removeClass('opentab');
                } else {
                    $('#lang-nav').show();
                    $("#lang-nav").addClass('opentab');
                    console.log('tab open ----------'+cntr);
                }


            }


        });


        $("#lang-nav").mouseover(function () {
            $('#lang-nav').show();
            $("#lang-nav").addClass('opentab');
        });


        $("#lang-nav").mouseout(function () {
            $('#lang-nav').hide();
            $("#lang-nav").removeClass('opentab');
        });


        $(".flagbtn ").mouseover(function () {
            $('#lang-nav').show();
            $("#lang-nav").addClass('opentab');
        });

        $(".flagbtn ").mouseout(function () {
            $('#lang-nav').hide();
            $("#lang-nav").removeClass('opentab');
        });




        function isMoobile()
        {
            var width = $(window).width();

            if(width < 768)
                return true;
            else
                return false;

        }


        //
        //
        //$(window).resize(function () {
        //
        //    if(isMoobile()) {
        //
        //
        //
        //    }else{
        //
        //        $("#lang-nav").mouseover(function () {
        //            $('#lang-nav').show();
        //        });
        //
        //
        //        $("#lang-nav").mouseout(function () {
        //            $('#lang-nav').hide();
        //        });
        //
        //
        //        $(".flagbtn ").mouseover(function () {
        //            $('#lang-nav').show();
        //        });
        //
        //        $(".flagbtn ").mouseout(function () {
        //            $('#lang-nav').hide();
        //        });
        //
        //    }
        //});



        //$("#lang-nav").mouseover(function () {
        //
        //    $('#lang-nav').show();
        //
        //});
        //$("#lang-nav").mouseout(function () {
        //    $('#lang-nav').hide();
        //});

        //
        //$(".flagbtn ").mouseover(function () {
        //
        //    $('#lang-nav').show();
        //
        //});
        //$(".flagbtn ").mouseout(function () {
        //    $('#lang-nav').hide();
        //});



        //
        //$( ".flagbtn" ).mouseover(function() {
        //
        //    $('#lang-nav').show();
        //});
        //$( ".flagbtn" ).mouseout(function() {
        //    $('#lang-nav').hide();
        //});



    </script>


    <script>
        var lang='<?=FXPP::html_url()?>';

        if(lang==''){
            var lang='en';
        }
        $('.lang_'+lang).addClass('disabled_li');
        $('.country-name-'+lang).addClass('langStrong');



        $('#langbtn').click(function(){
            console.log('--toggle');
            $("#lang-nav-desk").toggle();
        });



        $(".showAlways2").mouseover(function () {
            console.log('--show');

            $("#lang-nav-desk").show();
        });
        $(".showAlways2").mouseout(function () {
            console.log('--hide');
            $("#lang-nav-desk").hide();
        });



    </script>





