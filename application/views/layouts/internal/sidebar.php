<?php $this->lang->load('sidebar'); $this->lang->load('sidechat');?>
<style type="text/css">
    .verified-custom, .verified-custom:hover{
        cursor: inherit;
    }




    i.fa.fa-check-square-o.fa-lg:lang(sa) {
        padding-left: 10px;
    }
   
    
    @media screen and (min-width: 768px) {
      .verified_no_doc_font_small{
            padding: 11px 1px 11px !important;
            font-size: 14px !important;
    }

    .btn-verified a:hover {
        text-decoration: none;
    }
    .verified_no_doc_font_small:hover {
        background: #c0c0c0 !important;
    }
}
  


    
</style>

<div class="col-lg-3 col-md-3 col-sm-12 int-side-nav arabic-side-navigation arabic-hidden-section-title side-border" style="margin-top:10px;">
    
	<?php if (IPLoc::Office() && isset($title_page)) { ?>
        <h1 class="testtest">
            <?//= $title_page; ?>
        </h1>
    <?php } ?>

    <button id="navbar-menu-2" type="button" class="navbar-toggle int-side-collapse arabic-int-side-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
	
    <?php if ($this->session->userdata('login_type') != 1) { ?>
        <?php $base_currency = FXPP::getCurrencybase_v2();?>
        <!-- chnace modal -->
        <div class="modal fade" id="chancemodal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="">
            <div class="modal-dialog round-0 chance-dialog chance-modal-dialog">
                <div class="modal-content round-0">
                    <div class="modal-header chance-tiltle-holder round-0">
                        <button type="button" class="close" id="close-chance" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title modal-show-title"><?= lang('sb_ch_mod_h4');?></h4>
                    </div>
                    <div class="modal-body modal-show-body chance-bg">
                        <div class="row">
                            <div class="col-md-12">
                                <?php $base_currency == 'EUR'?$currency_icon = '<i class="fa fa-eur" aria-hidden="true"></i>' :$currency_icon ='<i class="fa fa-usd" aria-hidden="true"></i> ';?>
                                <p class="modal-text chance-modal-content">
                                    <?= lang('sb_ch_mod_p1');?> <span><?=$currency_icon ?><?= lang('sb_ch_mod_amt1');?></span> <?= lang('sb_ch_mod_p2');?>
                                </p>
                                <h3 class="chance-modal-heading"><?=$currency_icon ?><?=lang('sb_ch_mod_h3')?></h3>
                                <span class="chancespan"><?=lang('sb_ch_mod_sp')?></span>
                                <div class="chance-btn">
                                    <a href="<?=site_url()?>deposit"><?=lang('sb_ch_mod_btn')?></a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- end modal -->

        <div id="showside" class="showside">
            <span></span>
        </div>

    <?php }?>
 
<div class="tempBtn-holder">
        <?php echo FXPP::accStatusSideBtn(0); ?>
    </div>
    <div class="dl-holder arabic-dl-holder">

        <div class="side-nav-holder">
            <ul class="side-nav2 side-nav arabic-side-nav" role="tablist">

              
                <li role="presentation" >
                    <a id="s1" href="<?= FXPP::loc_url('my-account');?>" class=" <?=' bw '; ?><?=(($active_tab == 'accounts') || ($active_tab == 'profile') ) ? 'active-sidenav' : '';?>" ><i class="fa fa-user"></i><cite>
                            <?=lang('sb_li_0');?>
                        </cite></a>
                </li>
                <?php if($this->session->userdata('login_type') != 1){?>
                <li role="presentation" >
                    <a id="s1" href="<?= FXPP::loc_url('my-trading');?>" class=" <?=' bw '; ?><?=($active_tab == 'trading') ? 'active-sidenav' : '';?>" ><i class="fa fa-suitcase"></i><cite>
                          <?=lang('curtra_03');?>
                        </cite></a>
                </li>
                <?php } ?>



                <?php if($this->session->userdata('login_type') != 1){?>
                    <li role="presentation" >
                        <a id="s3" href="<?= FXPP::loc_url('deposit');?>" class=" <?=($active_tab == 'finance') ? 'active-sidenav' : '';?>"><i class="fa fa-money"></i><cite>
                                <?=lang('sb_li_2');?>
                            </cite></a>
                    </li>
                <?php }else{
                       ?>
                            <li role="presentation" >
                                <a id="s3" href="<?= FXPP::loc_url('deposit');?>" class=" <?=($active_tab == 'finance') ? 'active-sidenav' : '';?>"><i class="fa fa-money"></i><cite>
                                        <?=lang('sb_li_2');?>
                                    </cite></a>
                            </li>
                <?php  } ?>


                <?php if(!FXPP::isAccountFromEUCountry()) { 
                    $mt_set_id = $this->session->userdata('mt_account_set_id');
                     if($mt_set_id == 1 || $mt_set_id == 2 || $mt_set_id == 5  || $mt_set_id == 7 ){
                  // if(FXPP::fmGroupType($_SESSION['account_number']) != 'ForexMart Pro'){
                      ?>
                            <?php if ($this->session->userdata('login_type') != 1) { ?>
                                <li role="presentation">
                                    <a id="s4" href="<?= FXPP::loc_url('bonus/bonuses'); ?>"
                                       class="<?= ($active_tab == 'bonus') ? 'active-sidenav' : ''; ?>"><i
                                                class="fa fa-dollar"></i><cite>
                                            <?= lang('sb_li_3'); ?>
                                        </cite></a></li>
                        <?php } ?>
                    <?php }
                } ?>


                <?php
                      if ($this->session->userdata('login_type') == 1) {
                          if (FXPP::has30DollarPermission()){ ?>
                        <li role="presentation">
                            <a id="s4" href="<?= FXPP::loc_url('Credit_Bonus'); ?>"
                               class="<?= ($active_tab == 'credit-bonus-30') ? 'active-sidenav' : ''; ?>"><i
                                        class="fa fa-dollar"></i><cite>
                                    <?= lang('sb_li_10'); ?>
                                </cite>
                            </a>
                        </li>
                <?php } }  ?>


                <li role="presentation">
                    <a id="s5" href="<?= FXPP::loc_url('partnership/commission'); ?>"
                       class=" <?= ($active_tab == 'partnership') ? 'active-sidenav' : ''; ?>"><i
                            class="fa fa-users"></i>
                        <cite>
                            <?= lang('sb_li_4'); ?>
                        </cite>
                    </a>
                </li>




                <?php if($this->session->userdata('login_type') && $this->session->userdata('partner_type') != 'cpa' &&  $this->session->userdata('partner_type') != 'extra_commission' ){?>
                <li role="presentation" >
                    <a id="s6" href="<?= FXPP::loc_url('rebate-system');?>" class=" <?=($active_tab == 'rebate-system') ? 'active-sidenav' : '';?>"><i class="fa fa-line-chart"></i><cite>
                            <?=lang('sb_li_7');?>
                        </cite></a>
                </li>
                <?php } ?>

                <?php $this->load->library('IPLoc', null);?>
                <?php if(IPLoc::WhitelistPIPCandCC()){ ?>
                    <?php if(IPLoc::Office_and_Vpn_InviteFriend()){?>
                        <li role="presentation" >
                            <a id="s6" href="<?= FXPP::loc_url('invite-friend/invite-by-email');?>" class=" <?=($active_tab == 'invite-friend') ? 'active-sidenav' : '';?>"><i class="fa fa-tasks"></i><cite>
                                    <?=lang('sb_li_5');?>
                                </cite></a></li>
                    <?php }?>


                <?php }


                if(IPLoc::Office()){ ?>
                    <?php
                    $ms_notif = FXPP::mailSupportNotif();
                    ?>
                    <li role="presentation" >
                        <a id="s7"  href="<?= FXPP::loc_url('mail-support/my-mail');?>" class=" <?=($active_tab == 'mail-support') ? 'active-sidenav' : '';?>"><i class="fa fa-envelope"></i>
                            <cite>
                                <?=lang('sb_li_6'); ?>
                            </cite>
                            <span class="badge pull-right" style="<?= $ms_notif['totalNotification'] == 0 ? 'display: none' : ''; ?>"><?= $ms_notif['totalNotification']; ?></span>
                        </a>
                    </li>

<!--                    <li role="presentation" >-->
<!--                        <a href="--><?//= FXPP::loc_url('e-statement');?><!--" class="--><?//=($active_tab == 'e-statement') ? 'active-sidenav' : '';?><!--"><i class="fa fa-history"></i>-->
<!--                            <cite> --><?//=lang('sb_li_8');?><!--</cite>-->
<!--                        </a>-->
<!--                    </li>-->

                <?php } ?>
                


<!--                --><?php //if(IPLoc::Office()){ ?>
<!--                    <li role="presentation" >-->
<!--                        <a href="--><?//= FXPP::loc_url('pamm');?><!--" class="--><?//=($active_tab == 'pamm') ? 'active-sidenav' : '';?><!--"><i class="fa fa-pie-chart"></i>-->
<!--                            <cite> PAMM </cite>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                --><?php //} ?>

                <?php if($this->session->userdata('login_type') == 1 && IPLoc::Office()){ ?>
                    <li role="presentation" >
                        <a id="s4" href="<?= FXPP::loc_url('promotional-materials');?>" class="<?=($active_tab == 'promotional-materials') ? 'active-sidenav' : '';?>"><i class="fa fa-dollar"></i><cite>
                                <?=lang('sb_li_9');?>
                            </cite></a></li>
                <?php } ?>
                <?php if(FXPP::isCashback($this->session->userdata('user_id')) && IPLoc::Office() ){ ?>
                <li role="presentation">
                    <a href="<?= FXPP::loc_url('cashback');?>"class="<?=($active_tab == 'cash-back') ? 'active-sidenav' : '';?>"><i class="fa fa-slideshare"></i>
                        <cite><?=lang('sb_li_11');?></cite>
                    </a>
                </li>
                <?php } ?>



                <?php if($this->session->userdata('login_type') != 1){ ?>
                    <li role="presentation">
                        <a href="<?= FXPP::loc_url('copytrade');?>"class="<?=($active_tab == 'copytrading') ? 'active-sidenav' : '';?>"><i class="fa fa-copy"></i>
                            <cite><?=lang('sb_li_12');?></cite>
                        </a>
                    </li>
                <?php } ?>


                <?php //if(FXPP::isSmartDollarCountry()){ ?>
                    <?php if($this->session->userdata('login_type') != 1){ ?>
                        <li role="presentation">
                            <a href="<?= FXPP::loc_url('smartdollar');?>" id = "btnSmartDollar" class="<?=($active_tab == 'smartdollar') ? 'active-sidenav' : '';?>"><i class="fa fa-usd"></i>
                                <cite><?=lang('sb_li_13');?></cite> <?php  echo isset($_COOKIE['forexmart_smart_click']) ? '' : '<span class="badge badge-smart-dollar" style="float:right; background-color:red;">New</span>'; ?>
                            </a>
                        </li>
                    <?php } ?>
                <?php //} ?>

                <?php /**  <li><a href="#"><i class="fa fa-tasks"></i><cite>Services</cite></a></li>*/?>
            </ul>

            <div class="clearfix"></div>
        </div>
<?php /**
        <?php if($this->session->flashdata('virtual_account_message')){ echo '<div style="margin-top: 10px;">' . $this->session->flashdata('virtual_account_message') . '</div>'; } ?>
        <?php if(FXPP::hasCreateVirtualAccount()){ ?>
        <h1 class="accbal-title">ForexMart Virtual Account</h1>
        <div class="form-group">
            <div class="input-group">
                <input type="text" disabled="disabled" class="form-control round-0 txt-balance" placeholder="" Value="0.00">
                <div class="input-group-addon round-0 euro-sign"><select class="form-control">
                        <?php
                        $account_curreny = FXPP::getUserAccountCurrencyBase();
                        foreach( $account_curreny as $key => $value ){
                            echo "<option value=\"$key\">$value</option>";
                        }
                        ?>
                    </select></div>
            </div>
        </div>
        <?php } ?>
            <div class="btn-virtual-holder">

                <?php if(FXPP::canCreateVirtualAccount()){ ?>
                    <a href="#" class="btn-virtual" data-toggle="modal" data-target="#virtualModal">Create Virtual Account</a>
                <?php }else{ ?>
                    <a href="#" class="btn-virtual-disable">Create Virtual Account</a>
                <?php } ?>
            </div>
 * */?>

        <?php   /*---------------------- verified side bar tab/menu start -----------------------*/ ?>
        <div class="btn-verified">
            <?php echo FXPP::accStatusSideBtn(1); ?>
        </div>

        <?php   /*---------------------- verified side bar tab/menu close -----------------------*/ ?>




 
                    
                
    



<?php if(!$this->session->userdata('login_type')){?>
        <div class="btn-deposit-holder">
<!--            <button class="btn-deposit"><?= lang('trd_232');?></button>-->
            <a href="<?= FXPP::loc_url('deposit');?>" class="btn-deposit">
                <?=lang('sb_a_1');?>
            </a>
        </div>
        
        
        
        
<?php 

if(!FXPP::prohibition(2))
{

?>          
        <div class="btn-withdraw-holder">
<!--            <button class="btn-withdraw">Withdraw Funds</button>-->
            <a href="<?= FXPP::loc_url('withdraw');?>" class="btn-withdraw">
                <?=lang('sb_a_2');?>
            </a>
        </div>


<?php 
}    
    
} ?>

        <?php if($this->session->userdata('login_type') == 0){?>
        <div class="btn-download-mt4">
                <a href="https://download.mql5.com/cdn/web/instant.trading.eu/mt4/forexmart4setup.exe" class="btnMt4"><i class="fa fa-download iconDownload" style="margin-right:10px;"></i><?=lang('sb_a_3');?></a>
        </div>
            <?php // if(IPLoc::Office()){?>
            <div class="btn-download-mt4" style="">
                <?php switch(FXPP::html_url()){
                    case 'en':
                    case '':
                        ?>
                        <a href="https://webterminal.forexmart.com/" target="_blank" class="btnMt4"><img style="width: 25px;" src="<?= $this->template->Images()?>webtrader-icon.png" class="links-icon" alt="" />  <?=lang('xnv_webtrader');?></a>
                        <?php break;
                    case 'ru': ?>
                        <a href="https://webterminal.forexmart.com/" target="_blank" class="btnMt4"><img style="width: 25px;" src="<?= $this->template->Images()?>webtrader-icon.png" class="links-icon" alt="" />  <?=lang('xnv_webtrader');?></a>
                        <?php break;
                    default: ?>
                        <a href="https://webterminal.forexmart.com/" target="_blank" class="btnMt4"><img style="width: 25px;" src="<?= $this->template->Images()?>webtrader-icon.png" class="links-icon" alt="" />  <?=lang('xnv_webtrader');?></a>
                        <?php break; } ?>
            </div>
            <?php// } ?>
        <?php } ?>
    
            <div style="margin:16.5px 0" class="ssl-img">
                <?php switch(FXPP::html_url()){
                    case 'en':
                    case '':
                        ?>
                        <img src="<?= $this->template->Images()?>ssl/ssl-en.jpg" style="width:100%">
                        <?php break;
                    case 'ru': ?>
                        <img src="<?= $this->template->Images()?>ssl/ssl-ru.png" style="width:100%">
                        <?php break;
                    case 'jp': ?>
                        <img src="<?= $this->template->Images()?>ssl/ssl-en.jpg" style="width:100%">
                        <?php break;
                    case 'de': ?>
                        <img src="<?= $this->template->Images()?>ssl/ssl-german.png" style="width:100%">
                        <?php break;
                    case 'id': ?>
                        <img src="<?= $this->template->Images()?>ssl/ssl-ind.png" style="width:100%">
                        <?php break;
                    case 'sa': ?>
                        <img src="<?= $this->template->Images()?>ssl/ssl-en.jpg" style="width:100%">
                        <?php break;
                    case 'fr': ?>
                        <img src="<?= $this->template->Images()?>ssl/ssl-fr.jpg" style="width:100%">
                        <?php break;
                    case 'es': ?>
                        <img src="<?= $this->template->Images()?>ssl/ssl-spanish.png" style="width:100%">
                        <?php break;
                    case 'it': ?>
                        <img src="<?= $this->template->Images()?>ssl/ssl-en.jpg" style="width:100%">
                        <?php break;
                    case 'pt': ?>
                        <img src="<?= $this->template->Images()?>ssl/ssl-portuguese.png" style="width:100%">
                        <?php break;
                    case 'bg': ?>
                        <img src="<?= $this->template->Images()?>ssl/ssl-bulgarian.png" style="width:100%">
                        <?php break;
                    case 'my': ?>
                        <img src="<?= $this->template->Images()?>ssl/ssl-malaysia.png" style="width:100%">
                        <?php break;
                    case 'pk': ?>
                        <img src="<?= $this->template->Images()?>ssl/ssl-en.jpg" style="width:100%">
                        <?php break;
                    case 'pl': ?>
                        <img src="<?= $this->template->Images()?>ssl/ssl-polish.png" style="width:100%">
                        <?php break;
                    case 'gr': ?>
                        <img src="<?= $this->template->Images()?>ssl/ssl-en.jpg" style="width:100%">
                        <?php break;
                }
                ?>
            </div>
        <?php if(IPLoc::Office()){?>
        <?php if(!$this->session->userdata('login_type') && !IPLoc::isEuropeanIP()){?>

           <!-- <div class="int-side-thirty-percent-bonus-v2">
                <a href="<?= FXPP::loc_url('bonus/bonuses');?>">
                    <img src="<?//= $this->template->Images()?>int-30-percent-bonus-small.gif" class="img-responsive"/>
                </a>
            </div>-->

        <?php } }?>


            <div class="chat-widget-container chat-hide" style="">
                <!-- <div class="chat-widget-header">
                    <a href="javascript:;" class="chat-widget-logo"><img src="images/chat-widget/logo.png" class="img-responsive"/></a>
                    <a href="javascript:;" class="chat-widget-button-close"></a>
                </div> -->
                <div class="chat-widget-body">
                    <div class="chat-widget-img-support">
                        <img src="<?= $this->template->Images()?>chat-widget-img_v2.png">
                    </div>
                    <div class="chat-widget-statement">
                        <div class="arrow-up"></div>
                        <div class="arrow-left"></div>
                        <div class="widget-content">
                            <?php echo (($this->uri->segment(1)=='deposit') ? lang('sc') : lang('sc1')); ?>
                        </div>
                    </div>
                </div>
                <div class="chat-widget-footer">
                    <a href="javascript:void(Tawk_API.toggle())"><button id="start-chat"><?=lang('sc2');?></button></a>
                </div>
            </div>

<script>
    $(document).ready(function(){
//        setTimeout(function(){
//             $('.chat-hide').slideToggle();
//        }, 1000);
    });
    /*
    $("#start-chat").on("click",function() {
        $('.purechat-widget-title-link').click();
    });
    */
</script>
<?php /**
        <div class="dls">
            <h1>Download platforms</h1>
            <ul class="platforms">
                <li>
                    <a href="#">
                        <img src="<?= $this->template->Images()?>fx1.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                        ForexMart Client Terminal<br><cite>MT4 Platform</cite>
                    </a>
                </li><div class="clearfix"></div>
                <li>
                    <a href="#">
                        <img src="<?= $this->template->Images()?>fx2.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                        ForexMart MultiTerminal<br><cite>Multi-MT4</cite>
                    </a>
                </li><div class="clearfix"></div>
                <li>
                    <a href="#">
                        <img src="<?= $this->template->Images()?>fx3.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                        ForexMart WebTrader<br><cite>MT4 Online</cite>
                    </a>
                </li><div class="clearfix"></div>
                <li>
                    <a href="#">
                        <img src="<?= $this->template->Images()?>fx4.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                        ForexMart iPhone<br><cite>Trader</cite>
                    </a>
                </li><div class="clearfix"></div>
                <li>
                    <a href="#">
                        <img src="<?= $this->template->Images()?>fx5.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                        ForexMart iPad<br><cite>Trader</cite>
                    </a>
                </li><div class="clearfix"></div>
                <li>
                    <a href="#">
                        <img src="<?= $this->template->Images()?>fx6.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                        ForexMart Android<br><cite>Transfer</cite>
                    </a>
                </li><div class="clearfix"></div>
            </ul>
        </div>
 **/ ?>
    </div>
	<div class="clearfix"></div>
</div>

<?php /**
<div class="modal fade" id="virtualModal" tabindex="-1" role="dialog" aria-labelledby="virtualModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <?php echo form_open('accounts/createVirtualAccount', array('role' => 'form', 'id' => 'createVirtualAccount')) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Create Virtual Account</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <label for="virtualCurreny" class="col-sm-4">Currency</label>
                        <div class="col-sm-8">
                        <select name="virtual_currency" class="form-control">
                        <?php
                            $account_curreny = FXPP::getAccountCurrencyBase();
                            foreach( $account_curreny as $key => $value ){
                                echo "<option value=\"$key\">$value</option>";
                            }
                        ?>
                        </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>
*/ ?>
<style type="text/css">
    .ssl-img img{
        width:100%;
    }
    .ssl-img{
            text-align: center;
        }
    @media screen and (max-width: 767px) {
        .section h1 {
            margin-top: 15px !important;
        }
            .ssl-img img{
                width: 40%!important;
            }
    }
        @media screen and (max-width: 500px) {
            .ssl-img img{
                width: 60%!important;
            }
    }
    @media screen and (min-width: 768px) and (max-width: 991px) {
            .ssl-img img{
                width: 40%!important;
            }
       }
    .side-nav-holder {
        margin-bottom: 0px;
        margin-top: 0px;
    }
    @media screen and (min-width: 995px) and (max-width: 1100px) {
        ul.side-nav2 li:lang(my){
            width: 100%;
            float: none;
            margin: 1px;

        }
        ul.side-nav2 li a:lang(my){
            text-align: left;
        }
        #s6:lang(my){
         font-size: 12px;
        }
    }
    @media screen and (min-width: 995px) and (max-width: 1126px)  {
         #s6:lang(my){
             font-size: 12px!important;
         }

     }
    @media screen and (min-width: 991px) {
        .dl-holder{display: block!important;}
    }
    @media screen and (max-width: 1000px) {
        ul.side-nav2 li{
            width: 100%;
            float: none;
            margin: 1px;

        }
        ul.side-nav2 li a{
            text-align: center;
        }
    }
    .chat-widget-footer a{text-decoration:none;}
</style>
<script type="text/javascript">
//    var highheight=0;
//
//    var s1=0;
//    var s2=0;
//    var s3=0;
//    var s4=0;
//    var s5=0;
//    var s6=0;
//    var s7=0;
//
    // $(document).ready(function(){
    //     $(".int-side-collapse").click(function(){
    //         $(".dl-holder").slideToggle("fast");
    //     });
    // });

//
//    $(window).load(function() {
//        s1 = parseFloat($('#s1').height());
//        s2 = parseFloat($('#s2').height());
//        s3 = parseFloat($('#s3').height());
//        s4 = parseFloat($('#s4').height());
//        s5 = parseFloat($('#s5').height());
//        s6 = parseFloat($('#s6').height());
//        s7 = parseFloat($('#s7').height());
//        if(isNaN(s7)){
//            s7=0;
//        }
//        if(isNaN(s6)){
//           s6=0;
//        }
//        if(isNaN(s3)){
//            s3=0;
//        }
//        if(isNaN(s4)){
//            s4=0;
//        }
//        highheight=Math.round(Math.max(s1,s2,s3,s4,s5,s6,s7));
//
//        $('#s1').height(highheight);
//        $('#s2').height(highheight);
//        $('#s3').height(highheight);
//        $('#s4').height(highheight);
//        $('#s5').height(highheight);
//        $('#s6').height(highheight);
//        $('#s7').height(highheight);
//
//    });
//    $(window).resize(function() {
//        s1 = parseFloat($('#s1').height());
//        s2 = parseFloat($('#s2').height());
//        s3 = parseFloat($('#s3').height());
//        s4 = parseFloat($('#s4').height());
//        s5 = parseFloat($('#s5').height());
//        s6 = parseFloat($('#s6').height());
//        s7 = parseFloat($('#s7').height());
//
//        if(isNaN(s7)){
//            s7=0;
//        }
//        if(isNaN(s6)){
//            s6=0;
//        }
//        if(isNaN(s3)){
//            s3=0;
//        }
//        if(isNaN(s4)){
//            s4=0;
//        }
//        highheight=Math.round(Math.max(s1,s2,s3,s4,s5,s6,s7));
//
//
//        $('#s1').height(highheight);
//        $('#s2').height(highheight);
//        $('#s3').height(highheight);
//        $('#s4').height(highheight);
//        $('#s5').height(highheight);
//        $('#s6').height(highheight);
//        $('#s7').height(highheight);
//    });


</script>
<script type="text/javascript">
/**
 * jQuery.browser.mobile (http://detectmobilebrowser.com/)
 *
 * jQuery.browser.mobile will be true if the browser is a mobile device
 *
 **/
(function(a){(jQuery.browser=jQuery.browser||{}).mobile=/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);

if(jQuery.browser.mobile)
{
   $('.btn-download-mt4').css('display','none');
}
else
{
var isiPad = /ipad/i.test(navigator.userAgent.toLowerCase());
    if (isiPad)
    {
      $('.btn-download-mt4').css('display','none');
    }
   
}
</script>

<script>
    $(document).ready(function() {
//        // $("#chancemodal").modal('show');
//        $("#clickchance").click(function(){
//            $("#chance").hide();
//        });

        $(".a-flast-child").click(function(){
            $('#chancemodal').modal('show')
        });
        $(".ls-img3").click(function(){
            $('#chancemodal').modal('show')
        });
        $(".side-fix-landscape").click(function(){
            $('#chancemodal').modal('show')
        });

        $(".int-side-collapse").click(function(){
            $(".dl-holder").slideToggle("fast");
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    });
    $(document).ready(function () {
        $('.hideside').click(function () {
            $('.side-fix-holder').css('display', 'none');
            $('.showside').css('right', '0');
        });
        $('.showside').click(function () {
            $(this).css('right', '-20px');
            $('.side-fix-holder').css('display', 'block');
        });
    });

</script>
<script type="text/javascript">
    $(document).ready(function() {
        jQuery('#chance').delay(2000).slideDown();
        jQuery('#chanceclose').click(function (e) {
            e.preventDefault();
            jQuery('#chance').slideUp();
        });

        jQuery('#s3').click(function () {
            $('.side-fix-holder').css('display', 'none');
        });




    });


</script> 



<?= $this->load->ext_view('modal', 'account_verification_popup_modal', '', TRUE); ?>
