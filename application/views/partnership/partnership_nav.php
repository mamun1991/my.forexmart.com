<style type="text/css">
    .between {
        width: auto !important;
    }

    .btn-get-afflink {
        border-radius: 0px !important;
        color: #fff !important;
    }

    .afflink-holder {
        display: none;
    }

    .agreement-holder {
        display: none;

    }

    .add10 {
        margin-bottom: 10px !important;
    }

    #agree {
        -webkit-appearance: checkbox !important;
    }

    #agreeBd {
        -webkit-appearance: checkbox !important;
    }
    @media screen and (max-width: 414px) {
        .btn-get-afflink {
            /*margin-left: 80px;*/
        }
    }


    @media screen and (max-width: 767px) {
        .affForm {
            text-align: center;
        }
        .affformChkbox{
            text-align: left;

        }
    }





.nav-tabs > li {
    float: left;
    margin-bottom: 2px;
}

</style>

<?php
$PartnershipAgreementStatus = $data['PartnershipAgreementStatus'];
$isMicro = false;





if( FXPP::isMicro($this->session->userdata('user_id') ) || FXPP::isNdb($this->session->userdata('user_id'))  ){  // if the account is ndb n cents.
    $isMicro = true;
}


  

?>


<?php if ($this->uri->segment(1) != 'graph') { ?>
    <style type="text/css">
        .dropdown-menu {
            left: auto !important;
            right: 0 !important;
        }

    </style>
<?php } ?>
<h1 class="add10">
    <?= lang('parnav_00'); ?>
</h1>










<div class="info">
    <?php if(!$isMicro){?>

    <p class="txt-info"><?= lang('parnav_10'); ?></p>


    <?php if ($this->session->userdata('login_type') == 1){ ?>






    <div class="afflink-holder-partner" style="display: none">
        <p class="affiliate-code"> <?= lang('parnav_01'); ?>:
            <span><?php echo FXPP::www_url('register?id=' . $affiliate_code); ?></span>


        </p>

        <p> <?= lang('parnav_02'); ?>

            <?php if (FXPP::isEUUrl()) { ?>
                <a href="<?= base_url('/assets/pdf/ForexMarteu_Partnership_Agreement.pdf'); ?>"> <?php echo 'Terms of CPA agreement.'; ?> </a>
            <?php } else { ?>
                <?php if (FXPP::html_url() == 'ru') { ?>
                    <a href="<?= base_url('/assets/pdf/ForexMartPartnershipAgreement_russian.pdf'); ?>"> <?php echo lang('parnav_03'); ?> </a>.
                <?php } else { ?>
                    <a href="<?= base_url('/assets/pdf/ForexMartPartnershipAgreement.pdf'); ?>"><?php echo lang('parnav_03'); ?></a>.
                <?php
                }
            }?>

        </p>
    </div>


    <div class="PartnerAgreement-holder add10" style="display: none">
        <form>
            <div class="checkbox">
                <label>
                    <input type="checkbox" id="agreeBd"> <?= lang('parnav_11'); ?>
                    <?php if (FXPP::isEUUrl()) { ?>
                        <a href="<?= base_url('/assets/pdf/ForexMarteu_Partnership_Agreement.pdf'); ?>"> <?php echo 'Terms of CPA agreement.'; ?> </a>
                    <?php } else { ?>
                        <?php if (FXPP::html_url() == 'ru') { ?>
                            <a href="<?= base_url('/assets/pdf/ForexMartPartnershipAgreement_russian.pdf'); ?>"> <?php echo lang('parnav_03'); ?> </a>.
                        <?php } else { ?>
                            <a href="<?= base_url('/assets/pdf/ForexMartPartnershipAgreement.pdf'); ?>"><?php echo lang('parnav_03'); ?></a>.
                        <?php
                        }
                    }?>

                </label>
            </div>
            <input type="text" id="btn-afflinkbd" class="btn btn-get-afflink" disabled="disabled"
                   value="<?= lang('parnav_12'); ?>">
        </form>
    </div>


    <div style="display: none ; font-size: 17px;  color: #29A643; font-weight: bold; " class="afflinkBD">
    <p><?= lang('oth_com_13'); ?></p>
</div>

<div style="display: none; font-size: 17px;  font-weight: bold; " class="afflinkBDreject">
    <p> <?= lang('oth_com_14'); ?></p>
    </div>
	
<?php } else { ?>
    <div class="agreement-holder add10">
        <form class="affForm">
            <div class="checkbox affformChkbox">
                <label>
                    <input type="checkbox" id="agree"> <?= lang('parnav_11'); ?>
                    <?php if (FXPP::isEUUrl()) { ?>
                        <a href="<?= base_url('/assets/pdf/ForexMarteu_Partnership_Agreement.pdf'); ?>"> <?php echo 'Terms of CPA agreement.'; ?> </a>
                    <?php } else { ?>
                        <?php if (FXPP::html_url() == 'ru') { ?>
                            <a href="<?= base_url('/assets/pdf/ForexMartPartnershipAgreement_russian.pdf'); ?>"> <?php echo lang('parnav_03'); ?> </a>.
                        <?php } else { ?>
                            <a href="<?= base_url('/assets/pdf/ForexMartPartnershipAgreement.pdf'); ?>"><?php echo lang('parnav_03'); ?></a>.
                        <?php
                        }
                    }?>

                </label>
            </div>
            <input type="text" id="btn-afflink" class="btn btn-get-afflink" disabled="disabled"
                   value="<?= lang('parnav_12'); ?>">
        </form>
    </div>







    <div class="afflink-holder">
        <p class="affiliate-code"> <?= lang('parnav_01'); ?>:

            <span id="affCodeReq"></span>


        </p>


        <p> <?= lang('parnav_02'); ?>


            <?php if (FXPP::isEUUrl()) { ?>
                <a href="<?= base_url('/assets/pdf/ForexMarteu_Partnership_Agreement.pdf'); ?>"> <?php echo 'Terms of CPA agreement.'; ?> </a>
            <?php } else { ?>
                <?php if (FXPP::html_url() == 'ru') { ?>
                    <a href="<?= base_url('/assets/pdf/ForexMartPartnershipAgreement_russian.pdf'); ?>"> <?php echo lang('parnav_03'); ?> </a>.
                <?php } else { ?>
                    <a href="<?= base_url('/assets/pdf/ForexMartPartnershipAgreement.pdf'); ?>"><?php echo lang('parnav_03'); ?></a>.
                <?php
                }
            }?>

        </p>
    </div>






    <?php // if (IPLoc::Office()) {   echo'---------'.'<br>' ;  ?>
    <div class="affiliateCodeActiveBD" style="display: none">
        <p>

            <span id="affCodeReq"></span>

        </p>

        <p> <?= lang('parnav_02'); ?>

            <?php if (FXPP::isEUUrl()) { ?>
                <a href="<?= base_url('/assets/pdf/ForexMarteu_Partnership_Agreement.pdf'); ?>"> <?php echo 'Terms of CPA agreement.'; ?> </a>
            <?php } else { ?>
                <?php if (FXPP::html_url() == 'ru') { ?>
                    <a href="<?= base_url('/assets/pdf/ForexMartPartnershipAgreement_russian.pdf'); ?>"> <?php echo lang('parnav_03'); ?> </a>.
                <?php } else { ?>
                    <a href="<?= base_url('/assets/pdf/ForexMartPartnershipAgreement.pdf'); ?>"><?php echo lang('parnav_03'); ?></a>.
                <?php
                }
            }?>

        </p>
    </div>
    <p class="affiliateCodeReqSend" style="display: none; font-size: 17px;  color: #29A643; font-weight: bold; "> <?= lang('oth_com_15'); ?></p>



    <div style="display: none ; font-size: 17px; font-weight: bold; " class="afflinkBDrejectClient">
        <p> <?= lang('oth_com_16'); ?> </p>
    </div>


    <?php // echo'--------'.'<br>';   }?>








<?php } }?>
<p><?= lang('oth_com_17'); ?></p>
</div>

<div class="acct-tab-holder">
    <ul role="tablist" id="partnership-nav" class="nav nav-tabs partab arabic-main-tab arabic-partnership-main-tab">

        <?php if(!$isMicro){?>
            
        <?php if (!$data['isCPA'] && $PartnershipAgreementStatus->type_of_partnership != 'extra_commission') { ?>
            <li class="between"><a id="pn1" href="<?= FXPP::loc_url('partnership/commission'); ?>"
                                   class="<?php echo $data['active_sub_tab'] == 'commission' ? 'acct-active' : '' ?>">
                    <i class="fa fa-database"></i> <?= lang('parnav_04'); ?>
                </a></li>
        <?php } else if ($data['isCPA'] && $PartnershipAgreementStatus) { ?>
            <li class="between">
                <a id="pn1" href="<?= FXPP::loc_url('partnership/cpa'); ?>"
                   class="<?php echo $data['active_sub_tab'] == 'cpa' ? 'acct-active' : '' ?>">
                    <i class="fa fa-slideshare"></i> <?php if (FXPP::isEUUrl()) {
                        echo 'CPA';
                    } else {
                        echo lang('parnav_08');
                    } ?>
                </a>
            </li>
        <?php } ?>



                <li class="between"><a id="pn2" href="<?= FXPP::loc_url('partnership/clicks'); ?>"
                                       class="<?php echo $data['active_sub_tab'] == 'clicks' ? 'acct-active' : '' ?>">
                        <i class="fa fa-hand-o-up"></i>   <?= lang('parnav_05'); ?>
                    </a></li>

                <li class="between"><a id="pn3" href="<?= FXPP::loc_url('partnership/referrals'); ?>"
                                       class="<?php echo $data['active_sub_tab'] == 'referrals' ? 'acct-active' : '' ?>">
                        <i class="fa fa-slideshare"></i>  <?= lang('parnav_06'); ?>
                    </a></li>





        <?php }?>



        <?php if (!$PartnershipAgreementStatus) { ?>


            <?php if(!$isMicro){?>
            <li class="between"><a id="pn3" href="<?= FXPP::loc_url('graph'); ?>"
                                   class="<?php echo $data['active_sub_tab'] == 'graph' ? 'acct-active' : '' ?>">
                    <i class="fa fa-slideshare"></i>  <?= lang('parnav_13'); ?>
                </a></li>

        <?php }?>

            <li class="between">
                <a id="pn3" href="<?= FXPP::loc_url('partnership/affiliate-umbrella'); ?>"
                   class="<?php echo $data['active_sub_tab'] == 'affiliate-umbrella' ? 'acct-active' : '' ?>">
                    <i class="fa fa-slideshare"></i> <?= lang('oth_com_18'); ?>
                </a>
            </li>
        <?php } ?>


        <?php if ($PartnershipAgreementStatus){ ?>

        <li class="between view1"><a id="pn3" href="<?= FXPP::loc_url('graph'); ?>"
                                     class="<?php echo $data['active_sub_tab'] == 'graph' ? 'acct-active' : '' ?>">
                <i class="fa fa-slideshare"></i>  <?= lang('parnav_13'); ?>
            </a>
        </li>

        <?php if ($data['isCPA'] || $PartnershipAgreementStatus->type_of_partnership == 'extra_commission') { ?>

        <li class="between"><a id="pn4" href="<?= FXPP::loc_url('partnership/affiliate-custom-link'); ?>"
                                   class="<?php echo $data['active_sub_tab'] == 'affiliate' ? 'acct-active' : '' ?>">
                    <i class="fa fa-slideshare"></i> <?= lang('parnav_07'); ?>
                </a>
			</li>
        <?php } ?>
        <?php if ((IPLoc::WhitelistPIPCandCC() && $PartnershipAgreementStatus->type_of_partnership == 'extra_commission')) { ?>
            <li class="between"><a id="pn5" href="<?= FXPP::loc_url('partnership/extra-commission'); ?>"
                                         class="<?php echo $data['active_sub_tab'] == 'extra_commission' ? 'acct-active' : '' ?>">
                    <i class="fa fa-database"></i> <?= lang('parnav_09'); ?>
                </a></li>
        <?php } ?>

		<?php if (!$data['isCPA'] && $PartnershipAgreementStatus->type_of_partnership != 'extra_commission') { ?>
		<li class="between"><a id="pn4"
									  href="<?= FXPP::loc_url('partnership/affiliate-custom-link'); ?>"
									  class="<?php echo $data['active_sub_tab'] == 'affiliate' ? 'acct-active' : '' ?>">
				<i class="fa fa-slideshare"></i> <?= lang('parnav_07'); ?>
			</a></li>
		<?php } ?>
		<li class="between">
			<a id="pn4" href="<?= FXPP::loc_url('graph'); ?>" class="<?php echo $data['active_sub_tab'] == 'graph' ? 'acct-active' : '' ?>">
				<i class="fa fa-users"></i>  <?= lang('parnav_13'); ?>
			</a>
		</li>
		<li class="between">
			<a id="pn4" href="<?= FXPP::loc_url('partnership/internal-transfer'); ?>"
			   class="<?php echo $data['active_sub_tab'] == 'internal_transfer' ? 'acct-active' : '' ?>">
				<i class="fa fa-slideshare"></i> <? //=lang('parnav_07');?> <?= lang('oth_com_19'); ?>
			</a>
		</li>


        <li class="between"><a id="pn3" href="<?= FXPP::loc_url('partnership/referral-activities'); ?>"
                               class="<?php echo $data['active_sub_tab'] == 'referral_activities' ? 'acct-active' : '' ?>">
                <i class="fa fa-slideshare"></i>  <?= lang('oth_com_21'); ?>        </a></li>




            <?php if ((IPLoc::WhitelistPIPCandCC() && $PartnershipAgreementStatus->type_of_partnership == 'extra_commission')) { ?>
			<li class="between"><a id="pn5" href="<?= FXPP::loc_url('partnership/extra-commission'); ?>"
										  class="<?php echo $data['active_sub_tab'] == 'extra_commission' ? 'acct-active' : '' ?>">
					<i class="fa fa-database"></i>  <?=lang('parnav_007');?>
				</a></li>
		<?php } ?>
	
            
           


            

            <?php if(IPLoc::OpenAccounts()){?>
                <li class="between"><a id="pn3" href="<?= FXPP::loc_url('partnership/trading-history'); ?>"
                               class="<?php echo $data['active_sub_tab'] == 'trading-history' ? 'acct-active' : '' ?>">
                <i class="fa fa-slideshare"></i>  <?= lang('oth_com_22'); ?>       </a></li>
            <?php }?>

          
                <?php } ?>


            <div class="clearfix"></div>
    </ul>
    
</div>
<style>
.ulbg {
    background-color: #84c7f2;
}

@-moz-document url-prefix() {
    @media screen and (max-width: 786px) {
        ul.partab li:lang(en) {
            width: 100%;
            float: none;
            margin: 1px;
        }

        ul.partab li:lang(en) {
            text-align: center;
        }
    } @media screen and (max-width: 801px) {
    ul.partab li:lang(ru) {
        width: 100%;
        float: none;
        margin: 1px;
    }

    ul.partab li:lang(ru) {
        text-align: center;
    }
} @media screen and (max-width: 780px) {
    ul.partab li:lang(jp) {
        width: 100%;
        float: none;
        margin: 1px;
    }

    ul.partab li:lang(jp) {
        text-align: center;
    }
} @media screen and (max-width: 720px) {
    ul.partab li:lang(id) {
        width: 100%;
        float: none;
        margin: 1px;
    }

    ul.partab li:lang(id) {
        text-align: center;
    }
} @media screen and (max-width: 760px) {
    ul.partab li:lang(de) {
        width: 100%;
        float: none;
        margin: 1px;
    }

    ul.partab li:lang(de) {
        text-align: center;
    }
} @media screen and (max-width: 1160px) {
    ul.partab li:lang(fr) {
        width: 100%;
        float: none;
        margin: 1px;
    }

    ul.partab li:lang(fr) {
        text-align: center;
    }
} @media screen and (max-width: 820px) {
    ul.partab li:lang(it) {
        width: 100%;
        float: none;
        margin: 1px;
    }

    ul.partab li:lang(it) {
        text-align: center;
    }
} @media screen and (max-width: 790px) {
    ul.partab li:lang(es) {
        width: 100%;
        float: none;
        margin: 1px;
    }

    ul.partab li:lang(es) {
        text-align: center;
    }
} @media screen and (max-width: 1120px) {
    ul.partab li:lang(pt) {
        width: 100%;
        float: none;
        margin: 1px;
    }

    ul.partab li:lang(pt) {
        text-align: center;
    }
} @media screen and (max-width: 770px) {
    ul.partab li:lang(my) {
        width: 100%;
        float: none;
        margin: 1px;
    }

    ul.partab li:lang(my) {
        text-align: center;
    }
} @media screen and (min-width: 1150px) and (max-width: 5000px) {

    .view2 {
        display: block !important;
    }

    .view1 {
        display: none !important;
    }
} @media screen and (max-width: 1149px) {
    .view1 {
        display: block !important;
    }

    .view2 {
        display: none !important;
    }

    ul.partab li:lang(bg) {
        width: 100%;
        float: none;
        margin: 1px;
    }

    ul.partab li a:lang(bg) {
        text-align: center;
    }
}
}

@media screen and (max-width: 770px) and (-webkit-min-device-pixel-ratio: 0) {
    .view1 {
        display: block !important;
    }

    .view2 {
        display: none !important;
    }

    ul.partab li:lang(en) {
        width: 100%;
        float: none;
        margin: 1px;

    }

    ul.partab li a:lang(en) {
        text-align: center;
    }
}

@media screen and (max-width: 780px) and (-webkit-min-device-pixel-ratio: 0) {
    ul.partab li:lang(ru) {
        width: 100%;
        float: none;
        margin: 1px;

    }

    ul.partab li a:lang(ru) {
        text-align: center;
    }
}

@media screen and (max-width: 850px) and (-webkit-min-device-pixel-ratio: 0) {
    ul.partab li:lang(jp) {
        width: 100%;
        float: none;
        margin: 1px;

    }

    ul.partab li a:lang(jp) {
        text-align: center;
    }
}

@media screen and (max-width: 690px) and (-webkit-min-device-pixel-ratio: 0) {
    ul.partab li:lang(id) {
        width: 100%;
        float: none;
        margin: 1px;

    }

    ul.partab li a:lang(id) {
        text-align: center;
    }
}

@media screen and (max-width: 770px) and (-webkit-min-device-pixel-ratio: 0) {
    ul.partab li:lang(de) {
        width: 100%;
        float: none;
        margin: 1px;

    }

    ul.partab li a:lang(de) {
        text-align: center;
    }
}

@media screen and (max-width: 1080px) and (-webkit-min-device-pixel-ratio: 0) {
    ul.partab li:lang(fr) {
        width: 100%;
        float: none;
        margin: 1px;

    }

    ul.partab li a:lang(fr) {
        text-align: center;
    }
}

@media screen and (max-width: 750px) and (-webkit-min-device-pixel-ratio: 0) {
    ul.partab li:lang(it) {
        width: 100%;
        float: none;
        margin: 1px;

    }

    ul.partab li a:lang(it) {
        text-align: center;
    }
}

@media screen and (max-width: 840px) and (-webkit-min-device-pixel-ratio: 0) {
    ul.partab li:lang(es) {
        width: 100%;
        float: none;
        margin: 1px;

    }

    ul.partab li a:lang(es) {
        text-align: center;
    }
}

@media screen and (max-width: 1090px) and (-webkit-min-device-pixel-ratio: 0) {
    ul.partab li:lang(pt) {
        width: 100%;
        float: none;
        margin: 1px;

    }

    ul.partab li a:lang(pt) {
        text-align: center;
    }
}

@media screen and (min-width: 770px) and (max-width: 5000px)and (-webkit-min-device-pixel-ratio: 0) {
    .view2 {
        display: block !important;
    }

    .view1 {
        display: none !important;
    }
}

@media screen and (max-width: 1126px) and (-webkit-min-device-pixel-ratio: 0) {
    ul.partab li:lang(bg) {
        width: 100%;
        float: none;
        margin: 1px;

    }

    ul.partab li a:lang(bg) {
        text-align: center;
    }
}

@media screen and (max-width: 750px) and (-webkit-min-device-pixel-ratio: 0) {
    ul.partab li:lang(my) {
        width: 100%;
        float: none;
        margin: 1px;

    }

    ul.partab li a:lang(my) {
        text-align: center;
    }
}

.partner-menu {
    max-height: 17px;
}

.main-tab li {
    float: left;
    width: 20% !important;
    border-right: 2px solid #fff;
}

textarea:hover,
input:hover,
textarea:active,
input:active,
textarea:focus,
input:focus,
button:focus,
button:active,
button:hover {
    outline: 0px !important;
    -webkit-appearance: none;
}

h3 {
    /*font-family: 'Georgia';*/
    font-size: 24px;
}

.linesidebar {
    padding-left: 15px;
    display: block;
    border-left: 1px solid rgba(192, 192, 192, .8);

}

.btn-sidebar {
    /*font-family: 'Raleway';*/
    display: block;
    background-color: #eeeeee;
    padding: 10px 10px 10px 20px;
    font-size: 14px;
    font-weight: 600;
}

.btn-sidebar:hover, .side-active {
    background-color: #c0c0c0;
}

.btn-sidebar a {
    text-decoration: none;
    color: #222;
}

.btn-bottom {
    display: block;
    background-color: #c0c0c0;
    padding: 7px 10px 7px 10px;
    margin-top: 30px;
    text-align: center;
    font-size: 20px;
    text-decoration: none;
    color: #fff;
}

.btn-bottom a {
    /*font-family: 'Raleway';*/
    text-decoration: none;
    color: #fff;
    font-size: 16px;
    font-weight: 500;
}

.btn-menu {
    /*font-family: 'Raleway';*/
    display: block;
    background-color: #84c7f2;
    padding: 10px 10px 10px 10px;
    font-size: 14px;
    font-weight: 600;
    color: #222;
    text-align: center;
    margin-left: 2px;
    margin-right: 2px;
}

.menu-icon {
    max-width: 26px;
    padding-right: 10px;
    color: #2489cf;
}

.btn-process {
    margin-left: -40px;
}

.btn-process ul {
    list-style-type: none;
}

.btn-process ul li {
    display: inline-block;
    background-color: #2887c9;
    padding: 10px 10px 10px 10px;
}

.btn-process li a {
    text-decoration: none;
    /*font-family: 'Raleway';*/
    font-weight: 500;
    color: #fff;
    font-size: 13px;
}

.header-icon {
    max-width: 20px;
}

.no-padding {
    padding: 0 !important;
}

.square {
    display: block;
    border: 1px solid rgba(192, 192, 192, .4);
    padding: 20px 20px 20px 20px;
    margin-right: 2px;
}

.square_inside {
    display: block;
    border: 1px solid rgba(192, 192, 192, .4);
    padding: 5px 20px 5px 20px;
}

.square_inside h4 {
    /*font-family: 'Raleway';*/
    font-size: 18px;
    font-weight: 500;
    text-align: center;
    margin-top: 5px;
}

.blank {
    height: 260px;
}

.line {
    border-top: 1px solid rgba(192, 192, 192, .4);
    padding-top: 5px;
    font-size: 12px;
    text-align: center;

}

.extra {
    padding-top: 25px;
    font-size: 9px;
    color: rgba(150, 150, 150, .9);
    text-align: right;
}

.searchbox {
    margin-top: 10px;
    /*font-family: 'Raleway';*/
    font-weight: 600;
    font-size: 13px;
    color: #888;
}

.tab-headbottom {
    background-color: #a0a0a0;
    color: #fff;
    margin-top: 5px;
}

.tab-headbottom ul {
    list-style-type: none;
    padding-left: 0px;
    padding-right: 0px;
}

.tab-headbottom ul li {
    display: inline-block;
    padding: 10px 45px 10px 50px;
}

.text-center {
    text-align: center;
}

.nav-tabs {
    border-bottom: none;
}

.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
    color: #fff;
    cursor: default;
    background-color: #146aa7;
    border: 1px solid #ddd;
    border-bottom-color: transparent;
    font-size: 13px;
}

.nav-tabs > li > a {
    margin-right: 2px;
    line-height: 1.42857143;
    border: 1px solid transparent;
    border-radius: 0px 0px 0 0;
    background-color: #84c7f2;
    font-size: 12px;
    color: #222;
}

<?php /* removed task  */ ?>
/*.nav>li>a {position: relative;display: block;padding: 10px 5px;}*/
<?php /* removed task  */ ?>
.between {
    width: 29.33%;
}

.btn-get-afflink {
    border-radius: 0px !important;
    color: #fff !important;
}

.btn-get-afflink:lang(ru) {
    border-radius: 0px !important;
    color: #fff !important;
    width: 230px !important;
}

.afflink-holder {
    display: none;
}

.afflink-holder-bd {
    display: none;
}

.agreement-holder {
    margin-bottom: 10px;
}
#partnership-nav.nav > li > a {
    padding: 10px 10px;
}
</style>


<?php if ($this->session->userdata('login_type') == 1) { ?>


    <script type="text/javascript">
        var pblc = [];
        var prvt = [];
        var site_url = "<?=FXPP::ajax_url('')?>";

        $(document).ready(function () {
            prvt["data"] = {};
            pblc['request'] = $.ajax({
                dataType: 'json',
                url: '/query/partner-agreement-bdpartner',
                method: 'POST',
                data: prvt["data"]
            });
            pblc['request'].done(function (data) {
                if (data.bdUsers == 'BD') {
                    //console.log(data.partnerApproved);
                    if (data.partnerApproved == 1) {
                        $('.afflinkBD').show();
                    } else if (data.partnerApproved == 2) {
                        $('.afflink-holder-partner').show();
                    } else if (data.partnerApproved == 3) {
                        $('.afflinkBDreject').show();
                    } else {
                        $('.PartnerAgreement-holder').show();
                    }
                } else {
                    $('.afflink-holder-partner').show();
                }
            });

            pblc['request'].fail(function (jqXHR, textStatus) {
            });

        });


        $('#btn-afflinkbd').css("background", "#a0a0a0");
        $('#agreeBd').click(function () {
            if ($(this).is(':checked')) {
                $('#btn-afflinkbd').removeAttr('disabled');
                $('#btn-afflinkbd').css("background", "#29a643");
            } else {
                $('#btn-afflinkbd').attr('disabled', true);
                $('#btn-afflinkbd').css("background", "#a0a0a0");
            }
        });


        $('#btn-afflinkbd').click(function () {
            prvt["data"] = {};
            pblc['request'] = $.ajax({
                dataType: 'json',
                url: '/query/partnership-affiliate-request',
                method: 'POST',
                data: prvt["data"]
            });
            pblc['request'].done(function (data) {

                console.log(data.updatedSuccess);
                if (data.updatedSuccess) {
                    $('.PartnerAgreement-holder').hide();
                    $('.afflinkBD').show();
                }
            });

            pblc['request'].fail(function (jqXHR, textStatus) {
            });
        });


    </script>




<?php } else { ?>
    <script type="text/javascript">
        var pblc = [];
        var prvt = [];
        var site_url = "<?=FXPP::ajax_url('')?>";

        $(document).ready(function () {


            $('#btn-afflink').css("background", "#a0a0a0");

            $('#agree').click(function () {

                if ($(this).is(':checked')) {
                    $('#btn-afflink').removeAttr('disabled');
                    $('#btn-afflink').css("background", "#29a643");
                } else {
                    $('#btn-afflink').attr('disabled', true);
                    $('#btn-afflink').css("background", "#a0a0a0");
                }

            });


            $('#btn-afflink').click(function () {

                var bdacc = "<?= $bdUser[country] ?>";

                //console.log(bdacc+'test 123456789');

                prvt["data"] = {};
                pblc['request'] = $.ajax({
                    dataType: 'json',
                    url: '/query/partner-agreement-update',
                    method: 'POST',
                    data: prvt["data"]
                });
                pblc['request'].done(function (data) {
                    if (data.isUpdated) {

                      var affLink="https://www.forexmart.com/register?id="+data.affiliate_code_req;
                      $('#affCodeReq').html(affLink);


                        if (data.bdUserCheck == 'BD') {

                            $('.affiliateCodeReqSend').show();
                            $('.afflink-holder').hide();
                            $('.agreement-holder').hide();
                        } else {

                            $('.afflink-holder').show();
                            $('.agreement-holder').hide();

                        }


                    }
                });
                pblc['request'].fail(function (jqXHR, textStatus) {

                });
            });

            //onload request affiliate agreement

            prvt["data"] = {};
            pblc['request'] = $.ajax({
                dataType: 'json',
                url: '/query/partner-agreement',
                method: 'POST',
                data: prvt["data"]
            });
            pblc['request'].done(function (data) {

                if (data.IsCheckedAgreement) {
                    if (data.bdUser == 'BD') {

                        if (data.bdUserAdminApproved == 2) {

                            var affLink="https://www.forexmart.com/register?id="+data.affiliate_code_req;
                            $('#affCodeReq').html(affLink);

                            $('.affiliateCodeActiveBD').show();
                        } else if (data.bdUserAdminApproved == 3) {
                            $('.afflinkBDrejectClient').show();
                        } else {

                            $('.affiliateCodeReqSend').show();
                        }
                    } else {


                        var affLink="https://www.forexmart.com/register?id="+data.affiliate_code_req;
                        $('#affCodeReq').html(affLink);


                        $('.agreement-holder').hide();
                        $('.afflink-holder').show();
                    }


                } else {


                    $('.agreement-holder').show();
                    $('.afflink-holder').hide();
                }
            });
            pblc['request'].fail(function (jqXHR, textStatus) {

            });
        });
    </script>
<?php } ?>