<style type="text/css">
    @media screen and (max-width: 320px){
        #btn1{
            width: 100%;
        }
    }

    #mod_close{
        margin-top: 0%;
    }

    #reg-success-modal{
        padding-right: 40px!important;
    }
    .ndb-disabled {
        cursor: default;
        opacity: 0.6;
    }
    
    
 
@media only screen and (min-width: 992px) and (max-width: 2450px)  {
   .bonuspagebutton{padding-left: 15px !important;} 
  
}    
  
@media only screen and (min-width: 768px) and (max-width: 991px)  {
   .bonuspagebutton{padding-left: 24px !important;} 
  
}       

@media only screen and (min-width: 220px) and (max-width: 767px)  {
   .bonuspagebutton{padding-left: 9px!important} 
  
}   
.bonusnineninePercent{width: 99% !important}
.bonusnineninePercent a{width:30% !important}
</style>

<?php include_once('bonus_nav.php') ?>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="tab1">
        <div class="row">
            <div class="col-md-12">

                <p class="bonus-text">
                    <?php $this->load->library('IPLoc', null); ?>
                    <?= lang('bon_desc1');?>
                </p>
                <?php $active_tpb = ''; $active_twpb = ''; ?>

                <?php 
                      
                      $mt_set_id = $this->session->userdata('mt_account_set_id');

                      ?>
                <div class="cur-trades-tab arabic-cur-trades-tab bonuspagebutton">
                  <ul class="nav nav-tabs ">
                      <?php //if(!FXPP::isNewMtGroup()){ 
                          if($mt_set_id == 1 || $mt_set_id == 2 ){ 
                          
                          $active_tpb = 'active'; ?>
                      <li id="tpdb"   class="<?= $active_tpb ?> bonusnineninePercent"><a id="atab-sub1" aria-expanded="false" href="#tab-sub1" aria-controls="cur" role="tab" data-toggle="tab" class="btnBonus btnList hvr-curl-top-right"><?= lang('bon_00');?></a></li>
                      <?php } ?>

                   <!--    <li id="fpdb" class="a"><a id="atab-sub2" aria-expanded="false" href="#tab-sub2" aria-controls="pend" role="tab" data-toggle="tab" class="btnBonus btnList hvr-curl-top-right"><?//= lang('bon_14');?></a></li>-->
                      <?php
                      //if(FXPP::fmGroupType($_SESSION['account_number']) != 'ForexMart Pro'){
                      if($mt_set_id == 5){
                          
                          $active_twpb = 'active'; ?>
                      <li id="twpdb" class="active bonusnineninePercent"><a id="atab-sub4" aria-expanded="false" href="#tab-sub4" aria-controls="cur" role="tab" data-toggle="tab" class="btnBonus bonusnineninePercent btnList hvr-curl-top-right"><?= lang('trd_217');?></a></li>
                      <?php } ?>

                      



                            <?php $err='';

                        if($isSupporter){
                            $err = lang('trd_218');
                        }else{

                            if($NDB_has_been_claimed && !$acquireFrom){
                                if(IPLoc::Office()){
                                    $err = lang('ndb_pup2'). $NDB_has_been_claimed_date;
                                } else {
                                    $err = lang('trd_219') . $NDB_has_been_claimed_date;
                                }
                            }else  if($has_rqstd_ndb) {
                                if (IPLoc::Office()) {
                                    $err = lang('ndb_pup1');
                                } else {
                                    $err = lang('trd_220');
                                }
                            }else{
                                if($IsAcquiredFromOtherAccount){
                                    if(!$acquireFrom){
                                        if(IPLoc::Office()){
                                            $err = lang('ndb_pup3');
                                        } else {
                                            $err = lang('trd_221');
                                        }
                                    }else{
                                        $afrom =  $acquireFrom[0]['account_number'];
//                                        if(IPLoc::Office()) {
//                                            $err = 'No deposit Bonus has been acquired from account number:  <strong>' . $afrom . '</strong>';
////                                            print_r($category_acquire);
//                                        } else {
                                            $err = lang('ndb_pup4') .'<strong>' . $afrom . '</strong>';
//                                        }
                                    }
                                }else {
                                    if ($expireNoDeposit) {
//                                        if(IPLoc::Office()){ print_r($expireNoDeposit_msg);exit;}
                                        $err = $expireNoDeposit_msg;
                                    } else if (!$valid_for_nodepositbonus) {
                                        if(IPLoc::Office()){
                                            $err = lang('ndb_pup9');
                                        }else{
                                            $err = lang('trd_222');
                                        }
                                    }
                                }
                            }  }?>
                            <?php if($err!=''){ ?>
                              <!--  <li id="" class=""><a href="#" class="btnBonus btnList hvr-curl-top-right ndb-disabled"> <?//= lang('bon_01');?></a></li>-->
                            <?php }else{ ?>
                                <?php if($IsAcquiredFromOtherAccount==false){?>
                                    <?php if($has_rqstd_ndb==false){?>
                                        <?php if($valid_for_nodepositbonus==true){?>
                                          <!--  <li id="ndb" class=""><a id="atab-sub3" aria-expanded="false" href="#tab-sub3" aria-controls="pend" role="tab" data-toggle="tab" class="btnBonus btnList1 hvr-curl-top-right"> <?//= lang('bon_01');?></a></li>-->
                                        <?php }?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                  </ul>
                </div>
                <div class="clearfix"></div>
           
                <div id="reg-success-modal" class="alert alert-success alert-dismissible fade in" data-backdrop="static" role="alert" style="display: none; text-align: center">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" id="mod_close"><span aria-hidden="true">&times;</span></button>
                    <div id='nodepesit-crediting-message'>
                    </div>
                </div>
                <div class="tab-content cur-tab-cont">

                        <div role="tabpanel" class="tab-pane table-responsive <?= $active_tpb ?>" id="tab-sub1">
                            <div class="col-sm-12 arabic-bonus-tab-pane">
                                <h3 class="bonus-tab-sub">
                                    <?= lang('bon_02'); ?>
                                </h3>
                                <h3 class="bonus-tab-sub">
                                    <?= lang('bon_03'); ?>
                                </h3>
                                <p class="bonus-text-tab">
                                    <?= lang('bon_04'); ?>
                                </p>
                                <?= form_open('bonus/thirtypercentbonus', array('id' => 'form_TPB', 'class' => 'bonus_form'), ''); ?>
                                <input id="agree-checkbox" name="tpdba" type="checkbox">
                                <?= lang('bon_05'); ?>
                                <a href="<?= FXPP::www_url() ?>thirty-percent-bonus-agreement" class="agreement"
                                   target="_blank">
                                    <?= lang('bon_06'); ?>
                                </a>
                                <div class="btn-get-bonus-holder arabic-btn-get-bonus-holder">
                                    <button id="btn1" name="btn1" class="btn-get-bonus dsbld" disabled>
                                        <?= lang('bon_07'); ?>
                                    </button>
                                </div>
                                <?= form_close() ?>
                            </div>
                        </div>


                    <?php
                    // 50% bonus
                    ?>
                        <div role="tabpanel" class="tab-pane table-responsive" id="tab-sub2">
                            <div class="col-sm-12 arabic-bonus-tab-pane">
                                <h3 class="bonus-tab-sub">
                                    <?= lang('bon_15');?>
                                </h3>
                                <h3 class="bonus-tab-sub">
                                    <?= lang('bon_03');?>
                                </h3>
                                <p class="bonus-text-tab">
                                    <?= lang('bon_04');?>
                                </p>
                                <?= form_open('bonus/fiftypercentbonus',array('id' => 'form_FPB','class'=> ''),''); ?>
                                <input id="agree-checkbox" name="fpdba" type="checkbox">
                                <?= lang('bon_05');?>
                                <a href="<?= FXPP::www_url()?>fifty-percent-bonus-agreement" class="agreement"  target="_blank" >
                                    <?= lang('bon_16');?>
                                </a>
                                <div class="btn-get-bonus-holder arabic-btn-get-bonus-holder">
                                    <button id="btn3" name="btn3" class="btn-get-bonus dsbld" disabled>
                                        <?= lang('bon_07');?>
                                    </button>
                                </div>
                                <?= form_close()?>
                            </div>
                        </div>

                    <?php
                    // 20% bonus

                        ?>
                        <div role="tabpanel" class="tab-pane table-responsive  <?= $active_twpb ?>" id="tab-sub4">
                            <div class="col-sm-12 arabic-bonus-tab-pane">
                                <h3 class="bonus-tab-sub">
                                    <?= lang('bon_17'); ?>
                                </h3>
                                <h3 class="bonus-tab-sub">
                                    <?= lang('bon_03'); ?>
                                </h3>
                                <p class="bonus-text-tab">
                                    <?= lang('bon_04'); ?>
                                </p>
                                <?= form_open('bonus/twentypercentbonus', array('id' => 'form_TWPB', 'class' => 'bonus_form'), ''); ?>
                                <input id="agree-checkbox" name="twpdba" type="checkbox">
                                <?= lang('bon_05'); ?>
                                <a href="<?= FXPP::www_url() ?>twenty-percent-bonus-agreement" class="agreement"
                                   target="_blank">
                                  <?= lang('trd_223');?>
                                </a>
                                <div class="btn-get-bonus-holder arabic-btn-get-bonus-holder">
                                    <button id="btn4" name="btn4" class="btn-get-bonus dsbld" disabled>
                                        <?= lang('bon_07'); ?>
                                    </button>
                                </div>
                                <?= form_close() ?>
                            </div>
                        </div>



                        <?php if($expireNoDeposit==true){?>

                        <?php }elseif ($prohibit==true){?>
                                <div role="tabpanel" class="tab-pane table-responsive " id="tab-sub3" >
                                    <div class="col-sm-12 expireNoDeposit">
                                        <div class="alert alert-info">
                                            <?php
                                            $this->config->load('ndb_prohibit');
                                            echo $this->config->item('prohibition_message');
                                            ?>
                                        </div>
                                    </div>
                                </div>
                        <?php }else{ ?>
                            <?php if($has_rqstd_ndb==false){ ?>
                                <?php if($valid_for_nodepositbonus==true){?>
                                <div role="tabpanel" class="tab-pane table-responsive " id="tab-sub3" >
                                    <div class="col-sm-12 expireNoDeposit">
                                        <h3 class="bonus-tab-sub">
                                            <?= lang('bon_08');?>
                                        </h3>
                                        <p class="bonus-text-tab">
                                            <?= lang('bon_09');?>
                                        </p>
                                        <p class="bonus-text-tab">
                                            <?= lang('bon_10');?>
                                            <b><?=$bonus;?> <?=$users_currency;?> <?= ($isUSDorEUR==true)? '': ' ('. $bonus_negligible_view.' '.$default_currency.')' ?>  </b>
                                        </p>

                                        <input id="agree-checkbox" name="ndba" type="checkbox">
                                        <?= lang('bon_11');?>
                                        <a href="<?= $this->template->pdfviewer()?>?file=<?= $this->template->pdf()?>No Deposit Bonus.pdf#zoom=page-width" class="agreement" target="_blank" >
                                            <?= lang('bon_12');?>
                                        </a>
                                        <span class="ndba">
                                        </span>
                                        <div class="btn-get-bonus-holder">
                                            <button id="btn2" name="btn2" class="btn-get-bonus dsbld" disabled>
                                                <?= lang('bon_13');?>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                </div>

            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab2">
        <div class="row">
            <div class="col-md-12">
                <p class="bonus-text">
                </p>
                <h3 class="acct-sum-title arabic-acct-sum-title">
                   <?= lang('trd_224');?> 
                </h3>
                <div class="row acct-sum-holder">
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-10 col-md-10 col-xs-12' : '' ?> col-sm-10 arabic-bonus-statistics">
                        <p><?= lang('trd_225');?></p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-2 col-md-2 col-xs-12' : '' ?> col-sm-2 arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-10 col-md-10 col-xs-12' : '' ?> col-sm-10 arabic-bonus-statistics">
                        <p><?= lang('trd_82');?></p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-2 col-md-2 col-xs-12' : '' ?> col-sm-2 arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-10 col-md-10 col-xs-12' : '' ?> col-sm-10 arabic-bonus-statistics">
                        <p><?= lang('trd_226');?></p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-2 col-md-2 col-xs-12' : '' ?> col-sm-2 arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-10 col-md-10 col-xs-12' : '' ?> col-sm-10 arabic-bonus-statistics">
                        <p><?= lang('trd_227');?></p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-2 col-md-2 col-xs-12' : '' ?> col-sm-2 arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-10 col-md-10 col-xs-12' : '' ?> col-sm-10 arabic-bonus-statistics">
                        <p><?= lang('trd_228');?></p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-2 col-md-2 col-xs-12' : '' ?> col-sm-2 arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-10 col-md-10 col-xs-12' : '' ?> col-sm-10 arabic-bonus-statistics">
                        <p class="calc-bonus"><?= lang('trd_229');?></p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-2 col-md-2 col-xs-12' : '' ?> col-sm-2 arabic-bonus-statistics arabic-bonus-bottom">
                        <p></p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-10 col-md-10 col-xs-12' : '' ?> col-sm-10 arabic-bonus-statistics">
                        <p><?= lang('trd_230');?></p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-2 col-md-2 col-xs-12' : '' ?> col-sm-2 arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00 USD</p>
                    </div>
                </div>
                <div class="btn-text-holder row arabic-btn-text-holder">
                    <div class="col-sm-5 <?= FXPP::html_url() == 'sa' ? 'col-lg-5 col-md-5 col-xs-12' : '' ?> arabic-bonus-statistics">
                        <input class="form-control round-0" placeholder="Amount (USD)" type="text">
                    </div>
                    <div class="col-sm-3 <?= FXPP::html_url() == 'sa' ? 'col-lg-3 col-md-3 col-xs-12' : '' ?> arabic-bonus-statistics">
                        <button class="btn-acct-calc"><?= lang('trd_231');?></button>
                    </div>
                </div>
                <h3 class="acct-sum-title arabic-acct-sum-title"><?= lang('trd_234');?></h3>
                <p class="bonus-text bonus-text-sub">
                    <?= lang('trd_233');?>
                </p>
                <h3 class="acct-sum-title arabic-acct-sum-title"><?= lang('trd_234');?></h3>
                <div class="row acct-sum-holder">
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-bonus-statistics">
                        <p><?= lang('trd_235');?></p>
                    </div>
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00</p>
                    </div>
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-bonus-statistics">
                        <p><?= lang('trd_236');?></p>
                    </div>
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00</p>
                    </div>
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-bonus-statistics">
                        <p><?= lang('trd_237');?></p>
                    </div>
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00</p>
                    </div>
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-bonus-statistics">
                        <p><?= lang('trd_238');?></p>
                    </div>
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-bonus-statistics">
                        <p class="txt-strong"><?= lang('trd_239');?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="successful-registration-bonus" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content bonus-modal-container-two ex-modal-content round-0">
            <div class="modal-header ex-modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title-sub ex-modal-title"><?=lang('dpst_msg_ndb');?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!--<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 bonus-modal-img">
                        <img src="images/bonus-modal-icon-2.png" class="img-responsive"/>
                    </div>-->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-deposit-bonus-col-centered">
                        <p><?= lang('trd_240');?></p>
                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 no-deposit-bonus-input">
                            <label><?= lang('perdet_08');?></label>
                            <input id="phone" type="text" class="form-control round-0" >
                        </div>

                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 no-deposit-bonus-input">
                            <button type="button" id="reg-btn"><?= lang('trd_241');?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="nodeposit-verification" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content bonus-modal-container-two ex-modal-content round-0">
            <div class="modal-header ex-modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title-sub ex-modal-title"><?=lang('dpst_msg_ndb');?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-deposit-bonus-col-centered">
                        <p><?= lang('trd_242');?></p>
                       
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="successful-registration-bonus-no-deposite-bonus" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content bonus-modal-container-two ex-modal-content round-0">
            <div class="modal-header ex-modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title-sub ex-modal-title"><?= lang('bon_val2');?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-deposit-bonus-col-centered">
                        <div id="reg-modal-2" class="alert alert-danger alert-dismissible fade in" role="alert" style="display: none; text-align: center">
                            <?= lang('bon_val1');?>
                        </div>
                        <p>
                           <?= lang('bon_val1');?>
                        </p>
                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 no-deposit-bonus-input">
                            <label><?= lang('bon_val4');?></label>
                            <input id="phone2" type="text" class="form-control round-0">
                        </div>

                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 no-deposit-bonus-input" id="btn_container">
                            <button type="button" id="reg-btn2"><?= lang('trd_241');?></button>
                            <button type="button" id="skip-btn"><?= lang('trd_243');?></button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?=$check?>
<?=$modal_bonus_thirty_percent?>
<?=$modal_bonus_twenty_percent?>
<?=$modal_bonus_fifty_percent?>
<?=$modal_bonus_alert?>
<?=$modal_bonus_no_deposit_alert?>
<?=$modal_bonus_claim_alert?>
<?=$modal_bonus_thirty_percent_alert?>
<?=$modal_bonus_twenty_percent_alert?>
<?=$modal_bonus_fifty_percent_alert?>

<style type="text/css">

        .no-deposit-bonus-col-centered p{
            margin: auto;
            text-align: center;
        }


    .main-tab li a {
        background: #85C7F3 none repeat scroll 0% 0%;
        color: #333;
        display: block;
        padding: 10px;
        transition: all 0.3s ease 0s;
    }
    .btn-get-bonus-holder {
        text-align: left!important;
    }
    /* arabic start */
    .btn-get-bonus-holder:lang(sa) {
        text-align: right!important;
    }
    #form_TPB:lang(sa) {
        text-align: right!important;
    }
    #form_TWPB:lang(sa) {
        text-align: right!important;
    }
    .error{
        color:red;
        font-weight: normal!important;
    }

    .agreement:hover{
        color: #2988CA;
        text-decoration: none;
    }
    .agreement:link{
        color: #2988CA;
        text-decoration: none;
    }
    .agreement:visited{
        color: #2988CA;
        text-decoration: none;
    }
    .agreement:active{
        color: #2988CA;
        text-decoration: none;
    }
    .btn-get-bonus-holder {
        margin-top: 10px!important;
    }

    .dsbld{
  /*      background-color: gray!important;*/
    }
    .dsbld:hover{
/*        background-color: gray!important;
        text-decoration: none;*/
    }
    .dsbld:link{
/*        background-color: gray!important;
        text-decoration: none;*/
    }
    .dsbld:visited{
/*        background-color: gray!important;
        text-decoration: none;*/
    }
    .dsbld:active{
/*        background-color: gray!important;
        text-decoration: none;*/
    }
    .btn-explore {
        padding: 15px 20px;
        font-size: 17px;
        font-family: Open Sans;
        font-weight: 600;
        margin-top: 100px;
        border: 1px solid #1B8E33;
        background: #29A643 none repeat scroll 0% 0%;
        color: #FFF;
        transition: all 0.3s ease 0s;
    }
    .sr{
        margin-right: 7px;
    }
    .cur-tab-cont{
        margin-top: 20px;
    }
</style>
<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js" ></script>
<link rel="stylesheet" src="https://cdn.datatables.net/1.10.9/css/dataTables.bootstrap.min.css"/>
<link type="text/css"  href="<?= $this->template->Css()?>ndb-registration-style.css" rel="stylesheet">
<script type='text/javascript'>

    <?php if($active_tpb && $active_twpb){ ?>
        $('li#twpdb').removeClass('active')
        $('div#tab-sub4').removeClass('active'); //20% panel
    <?php } ?>

console.log("<?=$test?>");
var ndbcall=0;

        $(document).on("click","#fpdb,#tpdb","#twpdb",function(){
            $('a#atab-sub3').removeClass('cur-active');
        });

        $(document).on("click","#btn2",function(){

            $("#successful-registration-bonus-no-deposite-bonus").modal('show');

        });
        $(document).on("click","#btn222",function(){

            $("#nodeposit-verification").modal('show');

        });
        $(document).on("click","#ndb",function(){
            $('a#atab-sub3').addClass('cur-active');
            $('a#atab-sub1').removeClass('cur-active');
            $('a#atab-sub2').removeClass('cur-active');
            $('a#atab-sub4').removeClass('cur-active');
        });

        $(document).on("click","#reg-btn",function(){
            $('#loader-holder').show();
            var id = $("#phone").val();
            var site_url="<?=FXPP::ajax_url('bonus/updatedFB')?>";

            $.post(site_url,{id:id},function(){
                $("#successful-registration-bonus").modal('hide');
                $('#loader-holder').hide();
            })
        });

        $(document).on("click","#reg-btn2",function(){
            $('#loader-holder').show();
            var id = $("#phone2").val();
            var FBurl = /^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/;
            var VKurl = /^(https?:\/\/)?vk.com\/[a-zA-Z0-9(\.\?)?]/;

            var url_validator = false;
       
        if(id.match(FBurl)){url_validator = true; }
        if(id.match(VKurl)){url_validator = true;}
        if (url_validator) {
                var site_url="<?=FXPP::ajax_url('bonus/updatedFB')?>";
                
                $.post(site_url,{id:id},function(){
                $("#successful-registration-bonus-no-deposite-bonus").modal('hide');
                nodepositbonus();

            })
        } else {
            // alert("We must not use this info.");
              $("#reg-modal-2").show();
        }   
        
        $('#loader-holder').hide();
// end
     })

        $(document).on("click","#skip-btn",function(){
            $('#loader-holder').show();
            var id = $("#phone").val();
            var site_url="<?=FXPP::ajax_url('bonus/updatedFB')?>";

            $.post(site_url,{id:id},function(){
                $("#successful-registration-bonus-no-deposite-bonus").modal('hide');
                 nodepositbonus();
                <?php if(IPLoc::Office_for_NDB()){?>

                <?php }else{?>
                    $("#reg-success-modal").show();
                <?php }?>
            })
            $('#loader-holder').hide();
        })

     function nodepositbonus() {
//         var id = "test";
//         var site_url="<?//=FXPP::ajax_url('bonus/nodepositbonus')?>//";
//         $.post(site_url,{id:id},function(){
//             $('#loader-holder').hide();
//         })
         if (ndbcall==0){
             ndbcall=ndbcall+1;
             $('#loader-holder').show();
             var prvt = [];
             prvt["data"] = {
             };

             var site_url="<?=FXPP::ajax_url('')?>";
             pblc['request'] = $.ajax({
                 dataType: 'json',
                 url:site_url+"bonus/nodepositbonus_autocrediting",
                 method: 'POST',
                 data: prvt["data"]
             });
             pblc['request'].done(function( data ) {

                 $('#loader-holder').hide();

                 if (data.request==true){
                     $('li#ndb').css('display','none');
                     $('div#tab-sub3').css('display','none');
                     $('a#atab-sub1').removeClass('cur-active');
                     $('a#atab-sub1').addClass('cur-active');
                     $('a#atab-sub2').removeClass('cur-active');
                     $('a#atab-sub4').removeClass('cur-active');
                     $('a#atab-sub3').removeClass('cur-active');
                     $('div#tab-sub1').addClass('active');
                     UpdateRequest();

                     $("div#nodepesit-crediting-message").html('<?=lang('trd_244');?>');

                 } else{

                     $("div#nodepesit-crediting-message").html('<?=lang('trd_245');?>');

                 }

                 $("#reg-success-modal").show();

             });
         }else{

         }
    }

    function UpdateRequest(){
        setTimeout(
            function(){
                $('#ndbsuccess').hide();
                location.reload();

            }, 10000);
    }
    var pblc = [];
    var site_url="<?=FXPP::ajax_url('')?>";
    var tblBonus = $('#tblBonusThirtyPercentDeposit').DataTable(
        {"order": [[ 0, "desc" ]]}
    );
    pblc['request'] = null;
    pblc['form_NDB'] = null;
    pblc['form_TPB'] = null;
    pblc['form_TWPB'] = null;

    $().ready(function() {

        $("input[name='tpdba']").change(function() {
            if(this.checked) {
                // $("#successful-registration-bonus").modal('show');
                $("#btn1").prop("disabled", false);
                $("#btn1").removeClass("dsbld");
            }else{
                $("#btn1").prop("disabled", true);
                $("#btn1").addClass("dsbld");
            }
        });

        $("input[name='twpdba']").change(function() {
            if(this.checked) {
                // $("#successful-registration-bonus").modal('show');
                $("#btn4").prop("disabled", false);
                $("#btn4").removeClass("dsbld");
            }else{
                $("#btn4").prop("disabled", true);
                $("#btn4").addClass("dsbld");
            }
        });

        $("input[name='fpdba']").change(function() {
            if(this.checked) {
                // $("#successful-registration-bonus").modal('show');
                $("#btn3").prop("disabled", false);
                $("#btn3").removeClass("dsbld");
            }else{
                $("#btn3").prop("disabled", true);
                $("#btn3").addClass("dsbld");
            }
        });
        $("input[name='ndba']").change(function() {
            if(this.checked) {
                $("#btn2").prop("disabled", false);
                $("#btn2").removeClass("dsbld");
            }else{
                $("#btn2").prop("disabled", true);
                $("#btn2").addClass("dsbld");
            }
        });
        pblc['form_NDB'] = $('#form_NDB').validate({
            errorPlacement: function(error, element) {
                error.insertAfter(".ndba");
            },
            rules:{
                ndba: { required: true }
            },
            messages: {
            }, submitHandler: function(form) {

                var prvt = [];
                prvt["data"] = {
                };
                $('#loader-holder').show();
                pblc['request'] = $.ajax({
                    dataType: 'json',
                    url:form.action,
                    method: 'POST',
                    data: prvt["data"]
                });

                pblc['request'].done(function( data ) {
                    if (data.IsAcquiredFromOtherAccount) {

                        $('#OneAccountOnly').modal('show');

                    } else {

                        if (data.Implemented){
                            $('#NDBdone').modal('show');

                        }else {


                            if (data.IsStandardAccount == false) {

                                $('#NDBstandardaccountOnly').modal('show');

                            } else {

                                if (data.IsVerified && data.IsStandardAccount == true) {
                                    $('#NDBsuccess').modal('show');
                                    $('li#ndb').removeClass('active');
                                    $('a#atab-sub2').removeClass('cur-active');
                                    $('li#tpdb').addClass('active');
                                    $('a#atab-sub1').addClass('cur-active');
                                    $('div#tab-sub1').addClass('active');
                                    $('.expireNoDeposit').css('display', 'none');
                                } else {
                                    $('#NDBfailed').modal('show')
                                }

                            }
                        }

                    }
                    $('#loader-holder').hide();
                });

                pblc['request'].fail(function( jqXHR, textStatus ) {
                    $('#loader-holder').hide();
                });

                pblc['request'].always(function( jqXHR, textStatus ) {
                    $('#loader-holder').hide();
                    UpdateRequest();
                });
            }
        });

        pblc['form_TPB'] = $('#form_TPB').validate({
            errorPlacement: function(error, element) {
                error.insertAfter(".tpdba");
            },
            rules:{
                tpdba: {required: true}
            },
            messages: {
            }, submitHandler: function(form) {

                var prvt = [];
                prvt["data"] = {
                };
                pblc['request'] = $.ajax({
                    dataType: 'json',
                    url:form.action,
                    method: 'POST',
                    data: prvt["data"],
                    beforeSend: function(){
                        $('#loader-holder').show();
                    }
                });

                pblc['request'].done(function( data ) {
                    $('span.account-number').html(data.account_number);
                    if (!data.isSupporter){
                    if (!data.bonus_delay){
                    if(data.can_claim){
                        if(data.nodepositbonus!=1){
                            if(data.has_deposit){
                                tblBonus.destroy();
                                $('#tblBonusThirtyPercentDepositRows').html(data.bonus_data);
                                tblBonus = $('#tblBonusThirtyPercentDeposit').DataTable({
                                    "order": [[ 0, "desc" ]],
//                            "bSort": false,
//                            "ordering": false,
                                    "info":     false,
                                    dom: 'rtp<"clear">'
                                });
                                if(data.has_loss){
                                    tblBonus.column(2).visible(false);
                                    <?php //$('#BonusFiftyPercentTotalLoss').html(data.total_loss); ?>
                                    $('#BonusThirtyPercentClaimableAmount').html(data.claimable_amount);
                                    $('#BonusThirtyPercentClaimableBonus').html(data.claimable_bonus);
                                    $('#hasBonusThirtyPercentDepositLoss').show();
                                }else{
                                    tblBonus.column(2).visible(true);
                                    $('#hasBonusThirtyPercentDepositLoss').hide();
                                }

                                $('#loader-holder').hide();
                                $('#bonusThirtyPercent').modal('show');
                            }else if(data.has_tpb){
                                $('#loader-holder').hide();
                                $('#modalBonusNoDepositAlertTitle').html('<?=lang('dpst_msg_30');?>');
                                $('.tpb-body').html('<?= lang('trd_246');?>');
                                $('#modalBonusNoDepositAlert').modal('show');
                            }else{
                                $('#loader-holder').hide();
                                $('#modalBonusNoDepositAlertTitle').html('<?=lang('dpst_msg_30');?>');
                                $('#modalBonusNoDepositAlert').modal('show');
                            }
                        }else{
//                            if(data.is_verified!=0){
//                            var msg = '<?//=lang('dpst_msg11_30');?>//';
                             if(data.nodepositbonus==1)
                            { var msg = '<?=lang('dpst_msg7');?>';}
                            $('#loader-holder').hide();
                            $('#modalBonusNoDepositAlertTitle').html('<?=lang('dpst_msg_30');?>');
                            $('.tpb-body').html(msg);
                            $("div.modal-footer").hide();
                            $('#modalBonusNoDepositAlert').modal('show');
                        }
                    }else{
                        $('#loader-holder').hide();
                        $('#modalBonusClaimAlertTitle').html('<?=lang('dpst_msg_30');?>');
                        $('#modalBonusClaimAlert').modal('show');
                    }
                }else{
                    $('#loader-holder').hide();
                    $('#modalBonusDelayTitle').html('<?=lang('dpst_msg_30');?>');
                    $('#modalBonusDelayAlert').modal('show');
                }
            }else{

                $('#loader-holder').hide();
                $('#modalBonusSupportTitle').html('<?= lang('trd_247');?>');
                $('.supporter_msg_body').html('<?= lang('trd_248');?>');
                $('#modalBonusSupporterAlert').modal('show');
            }
        });

                pblc['request'].fail(function( jqXHR, textStatus ) {
                    $('#loader-holder').hide();
                });
            }
        });



        $('#btnGetBonus').on('click', function(){
            pblc['request'] = $.ajax({
                dataType: 'json',
                url: site_url+"bonus/getBonusThirtyPercent",
                method: 'POST',
                beforeSend: function(){
                    $('#loader-holder').show();
                }
            });

            pblc['request'].done(function( data ) {
                if(data.success){
                    $('#bonusThirtyPercent').modal('hide');
                    $('.bonus-alert-title').html('<?=lang('dpst_msg_30');?>');
                    $('.bonus-alert-message').html(data.message);
                    $('#modalBonusAlert').modal('show');
                }else{
                    $('#bonusThirtyPercent').modal('hide');
                    if(data.has_no_deposit_bonus){
                        $('#modalBonusThirtyPercentAlert').modal('show');
                    }else{
                        if(data.has_deposit){
                            $('.bonus-alert-title').html('<?=lang('dpst_msg_30');?>');
                            $('.bonus-alert-message').html(data.message);
                            $('#modalBonusAlert').modal('show');
                        }else{
                            $('#modalBonusNoDepositAlert').modal('show');
                        }
                    }
                }
                $('#loader-holder').hide();
            });

            pblc['request'].fail(function( jqXHR, textStatus ) {
                $('#loader-holder').hide();
            });
        });


        <?php
        // 20% bonus
        ?>

        pblc['form_TWPB'] = $('#form_TWPB').validate({
            errorPlacement: function(error, element) {
                error.insertAfter(".twpdba");
            },
            rules:{
                twpdba: {required: true}
            },
            messages: {
            }, submitHandler: function(form) {

                var prvt = [];
                prvt["data"] = {
                };
                pblc['request'] = $.ajax({
                    dataType: 'json',
                    url:form.action,
                    method: 'POST',
                    data: prvt["data"],
                    beforeSend: function(){
                        $('#loader-holder').show();
                    }
                });

                pblc['request'].done(function( data ) {
                    $('span.account-number').html(data.account_number);
                    if (!data.isSupporter){
                        if (!data.bonus_delay){
                            if(data.can_claim){
                                if(data.nodepositbonus!=1){
                                    if(data.has_deposit){
                                        tblBonus.destroy();
                                        $('#tblBonusTwentyPercentDepositRows').html(data.bonus_data);
                                        tblBonus = $('#tblBonusTwentyPercentDeposit').DataTable({
                                            "order": [[ 0, "desc" ]],
//                            "bSort": false,
//                            "ordering": false,
                                            "info":     false,
                                            dom: 'rtp<"clear">'
                                        });
                                        if(data.has_loss){
                                            tblBonus.column(2).visible(false);
                                            <?php //$('#BonusFiftyPercentTotalLoss').html(data.total_loss); ?>
                                            $('#BonusTwentyPercentClaimableAmount').html(data.claimable_amount);
                                            $('#BonusTwentyPercentClaimableBonus').html(data.claimable_bonus);
                                            $('#hasBonusTwentyPercentDepositLoss').show();
                                        }else{
                                            tblBonus.column(2).visible(true);
                                            $('#hasBonusTwentyPercentDepositLoss').hide();
                                        }

                                        $('#loader-holder').hide();
                                        $('#bonusTwentyPercent').modal('show');
                                    }else if(data.has_tpb){
                                        $('#loader-holder').hide();
                                        $('#modalBonusNoDepositAlertTitle').html('<?=lang('dpst_msg_20');?>');
                                        $('.tpb-body').html('<?= lang('trd_249');?>');
                                        $('#modalBonusNoDepositAlert').modal('show');
                                    }else{
                                        $('#loader-holder').hide();
                                        $('#modalBonusNoDepositAlertTitle').html('<?=lang('dpst_msg_20');?>');
                                        $('#modalBonusNoDepositAlert').modal('show');
                                    }
                                }else{
//                            if(data.is_verified!=0){
//                            var msg = '<?//=lang('dpst_msg11_30');?>//';
                                    if(data.nodepositbonus==1)
                                    { var msg = '<?=lang('dpst_msg7');?>';}
                                    $('#loader-holder').hide();
                                    $('#modalBonusNoDepositAlertTitle').html('<?=lang('dpst_msg_20');?>');
                                    $('.tpb-body').html(msg);
                                    $("div.modal-footer").hide();
                                    $('#modalBonusNoDepositAlert').modal('show');
                                }
                            }else{
                                $('#loader-holder').hide();
                                $('#modalBonusClaimAlertTitle').html('<?=lang('dpst_msg_20');?>');
                                $('#modalBonusClaimAlert').modal('show');
                            }
                        }else{
                            $('#loader-holder').hide();
                            $('#modalBonusDelayTitle').html('<?=lang('dpst_msg_20');?>');
                            $('#modalBonusDelayAlert').modal('show');
                        }
                    }else{

                        $('#loader-holder').hide();
                        $('#modalBonusSupportTitle').html('<?= lang('trd_247');?>');
                        $('.supporter_msg_body').html('<?= lang('trd_250');?>');
                        $('#modalBonusSupporterAlert').modal('show');
                    }
                });

                pblc['request'].fail(function( jqXHR, textStatus ) {
                    $('#loader-holder').hide();
                });
            }
        });



        $('#btnGetBonus20').on('click', function(){
            pblc['request'] = $.ajax({
                dataType: 'json',
                url: site_url+"bonus/getBonusTwentyPercent",
                method: 'POST',
                beforeSend: function(){
                    $('#loader-holder').show();
                }
            });

            pblc['request'].done(function( data ) {
                if(data.success){
                    $('#bonusTwentyPercent').modal('hide');
                    $('.bonus-alert-title').html('<?=lang('dpst_msg_20');?>');
                    $('.bonus-alert-message').html(data.message);
                    $('#modalBonusAlert').modal('show');
                }else{
                    $('#bonusTwentyPercent').modal('hide');
                    if(data.has_no_deposit_bonus){
                        $('#modalBonusTwentyPercentAlert').modal('show');
                    }else{
                        if(data.has_deposit){
                            $('.bonus-alert-title').html('<?=lang('dpst_msg_20');?>');
                            $('.bonus-alert-message').html(data.message);
                            $('#modalBonusAlert').modal('show');
                        }else{
                            $('#modalBonusNoDepositAlert').modal('show');
                        }
                    }
                }
                $('#loader-holder').hide();
            });

            pblc['request'].fail(function( jqXHR, textStatus ) {
                $('#loader-holder').hide();
            });
        });
        <?php
        // 50% bonus
        ?>


        pblc['form_FPB'] = $('#form_FPB').validate({
            errorPlacement: function(error, element) {
                error.insertAfter(".fpdba");
            },
            rules:{
                fpdba: {required: true}
            },
            messages: {
            }, submitHandler: function(form) {

                var prvt = [];
                prvt["data"] = {
                };
                pblc['request'] = $.ajax({
                    dataType: 'json',
                    url:form.action,
                    method: 'POST',
                    data: prvt["data"],
                    beforeSend: function(){
                        $('#loader-holder').show();
                    }
                });

                pblc['request'].done(function( data ) {
                    $('span.account-number').html(data.account_number);
                    console.log('FPB');
                    console.log(data);
                    if (!data.isSupporter){
                    if (!data.bonus_delay){
                    if(data.can_claim){
                        if(data.has_deposit){
                        console.log(data);
                            console.log('50% bonus');
                            //if( (data.is_verified==1) || (data.non_verified=='')) {
                            if( (data.nodepositbonus != 1)) {
                                if(data.is_standard){
                                    tblBonus.destroy();
                                    $('#tblBonusFiftyPercentDepositRows').html(data.bonus_data);
                                    tblBonus = $('#tblBonusFiftyPercentDeposit').DataTable({
                                        "order": [[ 0, "desc" ]],
                                        "info":     false,
                                        dom: 'rtp<"clear">'
                                    });

                                    if(data.has_loss){
                                        tblBonus.column(2).visible(false);
                                        <?php //$('#BonusFiftyPercentTotalLoss').html(data.total_loss); ?>
                                        $('#BonusFiftyPercentClaimableAmount').html(data.claimable_amount);
                                        $('#BonusFiftyPercentClaimableBonus').html(data.claimable_bonus);
                                        $('#hasBonusFiftyPercentDepositLoss').show();
                                    }else{
                                        tblBonus.column(2).visible(true);
                                        $('#hasBonusFiftyPercentDepositLoss').hide();
                                    }

                                    $('#loader-holder').hide();
                                    $('#bonusFiftyPercent').modal('show');
                                }else{
                                    $('#loader-holder').hide();
                                    $('#modalStandardAccountBonusTitle').html('<?=lang('dpst_msg_50');?>');
                                    $('#modalStandardAccountBonus').modal('show');
                                }
                            }else{
                                $('#loader-holder').hide();
                                $('#modalBonusNoDepositAlertTitle').html('<?=lang('dpst_msg_30');?>');
                                $('#message-body').html('<?=lang('dpst_msg7');?>');
                                $('#modalBonusNoDepositAlert_fifty').modal('show');
                            }
                        }else{
                            $('#loader-holder').hide();
                            $('#modalBonusNoDepositAlertTitle').html('<?=lang('dpst_msg_50');?>');
                            $('#modalBonusNoDepositAlert').modal('show');
                        }
                    }else{
                        $('#loader-holder').hide();
                        $('#modalBonusClaimAlertTitle').html('<?=lang('dpst_msg_50');?>');
                        $('#modalBonusClaimAlert').modal('show');
                    }
                }else{
                    $('#loader-holder').hide();
                    $('#modalBonusDelayTitle').html('<?=lang('dpst_msg_50');?>');
                    $('#modalBonusDelayAlert').modal('show');
                }
            }else{
                $('#loader-holder').hide();
                $('#modalBonusSupportTitle').html('<?= lang('trd_247');?>');
                $('.supporter_msg_body').html('<?= lang('trd_251');?>');
                $('#modalBonusSupporterAlert').modal('show');
            }
                });

                pblc['request'].fail(function( jqXHR, textStatus ) {
                    $('#loader-holder').hide();
                });
            }
        });



        $('#btnGetFBonus').on('click', function(){
            pblc['request'] = $.ajax({
                dataType: 'json',
                url: site_url+"bonus/getBonusFiftyPercent",
                method: 'POST',
                beforeSend: function(){
                    $('#loader-holder').show();
                }
            });

            pblc['request'].done(function( data ) {
                if(data.success){
                    $('#bonusFiftyPercent').modal('hide');
                    $('.bonus-alert-title').html('<?=lang('dpst_msg_50');?>');
                    $('.bonus-alert-message').html(data.message);
                    $('#modalBonusAlert').modal('show');
                }else{
                    $('#bonusFiftyPercent').modal('hide');
                    if(data.has_no_deposit_bonus){
                        $('#modalBonusFiftyPercentAlert').modal('show');
                    }else{
                        if(data.has_deposit){
                            $('.bonus-alert-title').html('<?=lang('dpst_msg_50');?>');
                            $('.bonus-alert-message').html(data.message);
                            $('#modalBonusAlert').modal('show');
                        }else{
                            $('#modalBonusNoDepositAlert').modal('show');
                        }
                    }
                }
                $('#loader-holder').hide();
            });

            pblc['request'].fail(function( jqXHR, textStatus ) {
                $('#loader-holder').hide();
            });
        });
    });
$(document).on("click",".ndb-disabled",function(){
console.log('<?php echo $isSupporter ?>');
var hasSupporterBonus = '<?php echo $isSupporter ?>';
    if(hasSupporterBonus){
        $('#modalBonusNoDepositAlert_error_messages').modal('show');
        $('#modalBonusNoDepositAlert_error_messages div.modal-body').html('You are not allowed to claim no deposit bonus in this supporter account.');
    }else{
        $('#modalBonusNoDepositAlert_error_messages').modal('show');
        $('#modalBonusNoDepositAlert_error_messages div.modal-body').html('<?=$err?>');
    }

});
    $(document).on("click",'#close-modalBonusNoDepositAlert_error_messages',function(){
        $('#modalBonusNoDepositAlert_error_messages').modal('hide');
        console.log('close ndb error');
    });
</script>
<?= $this->load->ext_view('modal', 'nodepositbonus', $bonus, TRUE); ?>
<?php /** Preloader Modal Start */ ?>
<div id="loader-holder" class="loader-holder">
    <div class="loader">
        <div class="loader-inner ball-pulse">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>

<?php /** Preloader Modal End */ ?>
<!-- Modal -->
<div class="modal fade" id="modalBonusNoDepositAlert_error_messages" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="javascript:void(0)" id="close-modalBonusNoDepositAlert_error_messages" class="close">&times;</a>
                <h4 class="modal-title text-center modal-show-title"><?=lang('dpst_msg_ndb');?></h4>
            </div>
            <div class="modal-body text-center">
            </div>
        </div>

    </div>
</div>