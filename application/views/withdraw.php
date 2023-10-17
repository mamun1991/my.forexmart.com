<?php $this->load->view('finance_nav.php');?>
<style>
    .webmoney
    {
        margin-top: 18px!important;
    }



</style>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="tab1">


        






        <div class="row">
                <?php if(IPLoc::for_my_only() || FXPP::isMalaysianCountry() || IPLoc::Office() ){ ?>
                <div class="col-lg-3 col-md-3">
                    <div class="bankdep-holder">
                        <a href="<?=FXPP::loc_url('withdraw/local_depositor_myr');?>" >
                            <img src="<?= $this->template->Images()?>/myrcard.png" class="img-reponsive" width="120px">
                        </a>
                        <p class="bankdep-text">
                            ForexMart local representative in Malaysia is happy to help you to proceed with bank transfer.<br>
                            <a href="<?=FXPP::loc_url('withdraw/local_depositor_myr');?>">Withdraw via local Depositor </a>
                        </p>
                    </div>
                </div>
               


                <!-- <div class="col-lg-3 col-md-3">
                    <div class="bankdep-holder">
                        <a href="#<?//= FXPP::loc_url('withdraw/banktransfer');?>"><img src="<?= $this->template->Images()?>indcard.png" class="img-reponsive" width="120px"></a>
                        <p class="bankdep-text ru-left">
                            <?//= lang('BankTransfer_desc');?>
                            Sekarang anda bisa mendepositokan dana ke akun ForexMart melalui bank lokal dengan mudah. Kami menerima transfer bank lokal dari seluruh bank terbesar di Indonesia.
                            <br/>
                            <a href="#<?//= FXPP::loc_url('withdraw/banktransfer');?>">
                                <?//= lang('Withdraw')." ".lang('BankTransfer');?>
                                <?= lang('idr');?>
                            </a>
                        </p>
                    </div>
                </div> -->

                <div class="col-lg-3 col-md-3">
                    <div class="bankdep-holder">
                        <a href="#<?= FXPP::loc_url('withdraw/banktransfer');?>"><img src="<?= $this->template->Images()?>myrcard.png" class="img-reponsive" width="120px"></a>
                        <p class="bankdep-text ru-left">
                        Accept payments and transfers from consumer bank accounts locally and internationally, and reach more countries at no additional cost and minimal effort.
                            <br/>
                            <a href="<?= FXPP::loc_url('withdraw/banktransfer');?>">
                                <?= lang('Withdraw')." ".lang('BankTransfer');?>
                                <?= lang('myr');?>
                            </a>
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3">
                </div>


            <?php }?>
        </div>
        <div class="row">    

           <!-- <div class="col-lg-3 col-md-3">
                <div class="bankdep-holder">
                    <a href="<?//= FXPP::loc_url('withdraw/banktransfer');?>"><img src="<?//= $this->template->Images()?>banktransfer.png" class="img-reponsive" width="150px"></a>
                    <p class="bankdep-text ru-left">
                        <?//= lang('BankTransfer_desc');?>
                        <br/>
                        <a href="<?//= FXPP::loc_url('withdraw/banktransfer');?>">
                            <?php if(IPLoc::Office()){ ?>
                                 Withdraw via Bank Transfer
                            <?php  } else{ ?>
                            <?//=lang('BankTransfer');?>
                            <?php  } ?>

                        </a>
                    </p>
                </div>
            </div>-->
            <!--r1 c1-->
            <div class="col-lg-3 col-md-3">
                <div class="bankdep-holder">
                    <a href="<?= FXPP::loc_url('withdraw/debit-credit-cards');?>">
                        <img src="<?= $this->template->Images()?>ccard-new.png" class="img-reponsive" width="150px">
                    </a>
                    <p class="bankdep-text ru-left">
                        <?= lang('Visa_desc');?>
                        <br/>
                        <a href="<?= FXPP::loc_url('withdraw/debit-credit-cards');?>">
                            <?php if(IPLoc::Office()){ ?>
                                Withdraw via Debit/Credit Cards
                            <?php  } else{ ?>
                                <?= lang('Withdraw')." ".lang('DebitCreditCards');?>
                            <?php  } ?>


                        </a>
                    </p>
                </div>



            </div>
            <!--r1 c2-->
            <div class="col-lg-3 col-md-3">
                <div class="bankdep-holder">
                    <a href="<?= FXPP::loc_url('withdraw/skrill');?>">
                        <img src="<?= $this->template->Images()?>skrill.png" class="img-reponsive" width="150px">
                    </a>
                    <p class="bankdep-text ru-left">
                        <?= lang('Skrill_desc');?>
                        <br/>
                        <a href="<?= FXPP::loc_url('withdraw/skrill');?>">
                            <?php if(IPLoc::Office()){ ?>
                                Withdraw via Skrill
                            <?php  } else{ ?>
                                <?=lang('Skrill');?>
                            <?php  } ?>


                        </a>
                    </p>
                </div>
            </div>
            <!--r1 c3-->
            <div class="col-lg-3 col-md-3">
                <div class="bankdep-holder">
                    <a href="<?= FXPP::loc_url('withdraw/neteller');?>">
                        <img src="<?= $this->template->Images()?>neteller.png" class="img-reponsive" width="150px">
                    </a>
                    <p class="bankdep-text ru-left">
                        <?= lang('Neteller_desc');?>
                        <br/>
                        <a href="<?= FXPP::loc_url('withdraw/neteller');?>">
                            <?php if(IPLoc::Office()){ ?>
                                Withdraw via Neteller
                            <?php  } else{ ?>
                                <?=lang('Neteller');?>
                            <?php  } ?>
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <!--r1 c4 sofort-->
            <?php if(FXPP::isAccountFromEUCountry()){ ?>
                <!--<div class="col-lg-3 col-md-3">
                    <div class="bankdep-holder webmoney">
                        <a href="<?/*= FXPP::loc_url('withdraw/sofort');*/?>">
                            <img src="<?/*= $this->template->Images()*/?>sofort.png" class="img-reponsive" style="color: red; width: 150px;">
                        </a>
                        <p class="bankdep-text ru-left">
                            <?/*= lang('Sofort_desc');*/?>
                            <br/>
                            <a href="<?/*= FXPP::loc_url('withdraw/sofort');*/?>">
                                <?php /*if(IPLoc::Office()){ */?>
                                    Withdraw via Sofort
                                <?php /* } else{ */?>
                                    <?/*= lang('Sofort')*/?>
                                <?php /* } */?>
                            </a>
                        </p>
                    </div>
                </div>-->
            <?php } ?>


            <!--r1 c4-->
            <?php if(!FXPP::isAccountFromEUCountry()){ ?>
            <!--<div class="col-lg-3 col-md-3">
                    <div class="bankdep-holder">
                        <a href="<?/*= FXPP::loc_url('withdraw/paxum');*/?>">
                            <img src="<?/*= $this->template->Images()*/?>paxum.png" class="img-reponsive" width="150px">
                        </a>
                        <p class="bankdep-text ru-left">
                            <?/*= lang('Paxum_desc');*/?>
                            <br/>
                            <a href="<?/*= FXPP::loc_url('withdraw/paxum');*/?>">
                                <?php/* if(IPLoc::Office()){ */?>
                                    Withdraw via Paxum
                                <?php  /*} else{ */?>
                                    <?/*=lang('Paxum');*/?>
                                <?php  /*}*/ ?>

                            </a>
                        </p>
                    </div>
                </div>-->
            <?php } ?>


            <?php if(!FXPP::isAccountFromEUCountry()){ ?>
                <div class="col-lg-3 col-md-3">
                    <div class="bankdep-holder">
                        <a href="<?= FXPP::loc_url('withdraw/fasapay'); ?>">
                            <img src="<?= $this->template->Images() ?>fasapay.png" class="img-reponsive" style="color: red;height: auto; width: 164px;">
                        </a>
                        <p class="bankdep-text ru-left">
                            <?= lang('fasapay_desc') ?>
                            <br/>
                            <a href="<?= FXPP::loc_url('withdraw/fasapay'); ?>">
                                Withdraw via Fasapay
                            </a>
                        </p>
                    </div>
                </div>
            <?php } ?>

            <?php if(!FXPP::isAccountFromEUCountry()){ ?>
                <div class="col-lg-3 col-md-3 ">
                    <div class="bankdep-holder">
                        <a href="<?= FXPP::loc_url('withdraw/qiwi');?>"><img src="<?= $this->template->Images()?>qiwilogo.png" class="img-reponsive" style="width: 58px; height: 70px;"></a>
                        <p class="bankdep-text">
                            <?= lang('QiWi_desc');?>
                            <br/>
                            <a href="<?= FXPP::loc_url('withdraw/qiwi');?>">
                                <?php if(IPLoc::Office()){ ?>
                                    Withdraw via QiWi
                                <?php  } else{ ?>
                                    <?=lang('QiWi');?>
                                <?php  } ?>


                            </a>
                        </p>
                    </div>
                </div>
            <?php } ?>


            <?php /*   // 0011   ?>

            <?php if(!FXPP::isAccountFromEUCountry()){ ?>
                <div class="col-lg-3 col-md-3">
                    <div class="bankdep-holder webmoney">
                        <a href="<?= FXPP::loc_url('withdraw/moneta');?>">
                            <img src="<?  $this->template->Images()?>moneta.png" class="img-reponsive" style="color: red; width: 150px;">
                        </a>
                        <p class="bankdep-text ru-left">
                            <?= lang('Moneta_desc');?>
                            <br/>
                            <a href="<?= FXPP::loc_url('withdraw/moneta');?>">
                                <?php if(IPLoc::Office()){ ?>
                                    Withdraw via Moneta.ru
                                <?php  } else{ ?>
                                    <?= lang('Moneta.ru')?>
                                <?php  } ?>

                            </a>
                        </p>
                    </div>
                </div>
            <?php } ?>


            <?php */ ?>





            <div class="col-lg-3 col-md-3">
                <div class="bankdep-holder">
                    <a href="<?= FXPP::loc_url('withdraw/chinaUnionPay'); ?>">
                        <img src="<?= $this->template->Images() ?>chinaUnionPay.png" class="img-reponsive" style="color: red;height: auto; width: 100px;">
                    </a>
                    <p class="bankdep-text ru-left">
                        <?= lang('cup_desc') ?>
                        <br/>
                        <a href="<?= FXPP::loc_url('withdraw/chinaUnionPay'); ?>">
                            <?= lang('chinapay') ?>
                        </a>
                    </p>
                </div>
            </div>


            <!--r2 c1-->
           <!-- <div class="col-lg-3 col-md-3">
                <div class="bankdep-holder">
                    <a href="<?//=FXPP::loc_url('withdraw/paypal');?>">
                        <img src="<?//= $this->template->Images()?>paypal.png" class="img-reponsive" width="150px">
                    </a>
                    <p class="bankdep-text ru-left">
                        <?//= lang('paypal_desc');?>
                        <br/>
                        <a href="<?//= FXPP::loc_url('withdraw/paypal');?>">
                            <?php if(IPLoc::Office()){ ?>
                                Withdraw via Paypal
                            <?php  } else{ ?>
                                <?//=lang('paypal');?>
                            <?php  } ?>

                        </a>
                    </p>
                </div>
            </div>-->






            <!--r1 c4-->
           <!-- <div class="col-lg-3 col-md-3">
                <div class="bankdep-holder">
                    <a href="<?//= FXPP::loc_url('withdraw/megatransfer');?>">
                        <img src="<?= $this->template->Images()?>megatransferlogo.png" class="img-reponsive" style="color: red; height: 38px; width: 150px;">
                    </a>
                    <p class="bankdep-text ru-left">
                        <?//= lang('MegaTransfer_desc');?>
                        <br/>
                        <a href="<?//= FXPP::loc_url('withdraw/megatransfer');?>">
                            <?php if(IPLoc::Office()){ ?>
                                Withdraw via MegaTransfer
                            <?php  } else{ ?>
                                <?//= lang('MegaTransfer');?>
                            <?php  } ?>

                        </a>
                    </p>
                </div>
            </div>-->

        </div>
        <div class="row">

            <!--r1 c5 webmoney-->

           <!-- <div class="col-lg-3 col-md-3">
                <div class="bankdep-holder webmoney">
                    <a href="<?//= FXPP::loc_url('withdraw/webmoney');?>">
                        <img src="<?//= $this->template->Images()?>webmoney.png" class="img-reponsive" style="color: red; width: 150px;">
                    </a>
                    <p class="bankdep-text ru-left">
                        <?//= lang('WebMoney_desc');?>
                        <br/>
                        <a href="<?//= FXPP::loc_url('withdraw/webmoney');?>">
                            <?php //if(IPLoc::Office()){ ?>
                                Withdraw via WebMoney
                            <?php // } else{ ?>
                                <?//= lang('WebMoney')?>
                            <?php // } ?>


                        </a>
                    </p>
                </div>
            </div>-->

            <!--r1 c4 moneta-->

            <?php if(!FXPP::isAccountFromEUCountry()){ ?>
            <div class="col-lg-3 col-md-3">
                    <div class="bankdep-holder">
                        <a href="<?= FXPP::loc_url('withdraw/payco');?>"><img src="<?= $this->template->Images()?>payco.png" class="img-reponsive" width="150px"></a>
                        <p class="bankdep-text ru-left">
                            <?= lang('PayCo_desc');?>
                            <br/>
                            <a href="<?= FXPP::loc_url('withdraw/payco');?>">
                                <?php if(IPLoc::Office()){ ?>
                                    Withdraw via PayCo
                                <?php  } else{ ?>
                                    <?=lang('PayCo');?>
                                <?php  } ?>

                            </a>
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3">
                    <div class="bankdep-holder">
                        <a href="<?= FXPP::loc_url('withdraw/alipay');?>"><img src="<?= $this->template->Images()?>alipay.png" class="img-reponsive" width="100px"></a>
                        <p class="bankdep-text ru-left">
                            Experience fast, easy and safe online payments
                            <br/>
                            <a href="<?= FXPP::loc_url('withdraw/alipay');?>">
                                    Withdraw via Alipay
                            </a>
                        </p>
                    </div>
                </div>


                <div class="col-lg-3 col-md-3">
                    <div class="bankdep-holder">
                        <a href="<?= FXPP::loc_url('withdraw/payTrust');?>"><img src="<?= $this->template->Images()?>banktransfer.png" class="img-reponsive" width="150px"></a>
                        <p class="bankdep-text ru-left">
                            Accept payments and transfers from consumer bank accounts locally and internationally, and reach more countries at no additional cost and minimal effort.
                            <br/>
                            <a href="<?= FXPP::loc_url('withdraw/payTrust');?>">
                                Withdraw via PayTrust
                            </a>
                        </p>
                    </div>
                </div>



            <?php } ?>



        </div>

        <div class="row">
                <div class="col-lg-3 col-md-3">

                <div class="bankdep-holder">
                    <a href="<?= FXPP::loc_url('withdraw/bank-wire-transfer');?>"><img src="<?= $this->template->Images()?>banktransfer.png" class="img-reponsive" width="150px"></a>
                    <p class="bankdep-text ru-left">
                        <?= lang('BankTransfer_desc');?>
                        <br/>
                        <a href="<?= FXPP::loc_url('withdraw/bank-wire-transfer');?>">
                            Withdraw via Bank Transfer
                        </a>
                    </p>
                </div>
            </div>
                

                <!-- <div class="col-lg-3 col-md-3">
                     <div class="bankdep-holder webmoney">
                         <a href="<?//= FXPP::loc_url('withdraw/yandex');?>">
                             <img src="<?//= $this->template->Images()?>yandex.png" class="img-reponsive" style="color: red;height: 60px; width: 150px;">
                         </a>
                         <p class="bankdep-text ru-left">
                         <?= lang('YandexMoney_desc')?><br/>
                             <a href="<?//= FXPP::loc_url('withdraw/yandex');?>">
                                 <?php if(IPLoc::Office()){ ?>
                                     Withdraw via YandexMoney
                                 <?php  } else{ ?>
                                     <?//= lang('YandexMoney')?>
                                 <?php  } ?>


                             </a>
                         </p>
                     </div>
                 </div>-->
           <!-- <?php /*if(!IPLoc::isIPandLanguageChina()){ */?>
            <div class="col-lg-3 col-md-3">
                <div class="bankdep-holder">
                    <a href="<?/*= FXPP::loc_url('withdraw/bitcoin');*/?>">
                        <img src="<?/*= $this->template->Images()*/?>bitcoinlogo.png" class="img-reponsive" style="color: red; width: 150px;">
                    </a>
                    <p class="bankdep-text ru-left">
                       <?/*= lang('Bitcoin_desc')*/?><br/>
                        <a href="<?/*= FXPP::loc_url('withdraw/bitcoin');*/?>">
                            <?php /*if(IPLoc::Office()){ */?>
                                Withdraw via Bitcoin
                            <?php /* } else{ */?>
                                <?/*= lang('Bitcoin')*/?>
                            <?php /* } */?>
                        </a>
                    </p>
                </div>
            </div>
            --><?php /*} */?>





        </div>

    </div>


</div>
<style type="text/css">
    /*** FXPP-2407 (start) ***/
    @media screen and (max-width: 991px) {
        .bankdep-text {
            margin: 20px 30% 10px;
        }
    }
    @media screen and (max-width: 990px) {
        .bankdep-text {
            margin: 20px 29% 10px;
        }
    }
    @media screen and (max-width: 500px) {
        .bankdep-text {
            margin: 20px 15% 10px;
        }
    }
    /*** FXPP-2407 (end) ***/
    .paypalimage{
        padding: 16px;
    }
    .ru-left{text-align: left}
    .bankdep-text{
        text-align: justify!important;
    }
</style>


