<style>

    #select-deposit-logo{width: 100% !important;}

    .imgclslogo{
        display: block;
        max-height: 90px !important;
        max-width: 190px !important;
    }

    .imgclslogo2{
        display: block;
        max-height: 90px !important;
        max-width: 190px !important;
    }

    .finance-local-total-amount {
        display: table;
        float: none !important;
        margin: 0 auto;
    }
    .chk-bitcoin{
        margin-top: 0!important;
    }

    .chk-desc{
        margin-top: 5px;
    }

    .chk{
        margin-top: 10px!important;
    }

    .btc-bonus-type {
        padding: 0px !important;
    }

    #owl-demo .item{
        margin: 3px;
    }

    #owl-demo .item img{
        display: block;
        width: 100%;
        height: auto;
    }

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




    .check-deposit-unverified{
        background: #f5d0d0;
        border-radius: 4px;
        border: none;
        padding: 8px;
        text-align: center;
        margin-bottom:1%;
    }
    .pDescription{
        text-align: justify;
    }
</style>

<?php
if($staticId != 'logId'){
    $this->load->view('finance_nav.php');
}
?>
<!-- FXPP-6333 -->
<input type="hidden" name="micro_type" id="micro_type" value="<?php echo $micro; ?>">
<!-- FXPP-6333 -->
<div class="tab-content acct-cont">
    <!--	<div role="tabpanel" class="tab-pane active" id="tab1">-->
    <!--		--><?//=$show_deposit;?>
    <!--	</div>-->


    <div class="section">
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab1">
                <div class="finance-deposit-container">
                    <form action="" id="limited" method="">
                        <input type="hidden" id="amount1" name="amount1">
                        <input type="hidden" id="bounusfiled" name="bounusfiled">
                    </form>

                    <form action="" id="limited2" method="">
                        <input type="hidden" id="amount3" name="amount3">
                    </form>

                    <div class="finance-payment-methods finance-payment-methods-first col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label><?= lang('PaymentMethods');?></label>
                        <select class="form-control" id="select-deposit-logo">
                            <?php if(!FXPP::notAllowedPayomaDepositCountry()){?>
                                <option value="ddcc" data-url="deposit/debit-credit-cards"><?= lang('DepositCredit');?></option>
                            <?php }?>

                            <?php if(FXPP::isIndonesianCountry()){ ?>
                                <option value="ldidr" data-url="deposit/local-depositor-idr">Local Depositor in Indonesia</option>
                            <?php } ?>
                            <?php if($this->session->userdata('account_number') == '58008538' || $this->session->userdata('account_number') == '58037565' || $this->session->userdata('account_number') == '58050227'){?>
                               <option value="idr" data-url="deposit/bank-transfer-idr"><?= lang('idr');?></option>
                            <?php } ?>

                            <?php if(FXPP::isMalaysianCountry()){ ?>
                                <option value="myr" data-url="deposit/bank-transfer-myr"><?= lang('myr');?></option>
                            <?php } ?>

                            <?php if(FXPP::isMalaysianCountry()){ ?>
                                <option value="ldmyr" data-url="deposit/local-depositor-myr"><?=lang('lcl_depos');?></option>
                            <?php } ?>

                            <?php if(FXPP::isThailandCountry()){ ?>
                                <option value="thb" data-url="deposit/bank-transfer-thb"><?=lang('lcl_bnk_tr');?></option>
                            <?php } ?>

                            <!-- <option value="bt" data-url="deposit/bank-wire-transfer"><?//= lang('bt');?></option> -->

                            <?php if(!FXPP::isEUClient()){?>
                            <option value="skl" data-url="deposit/skrill"><?= lang('skl');?></option>
                            <option value="ntl" data-url="deposit/neteller"><?= lang('ntl');?></option>
                            <?php }?>
                            <option value="pco" data-url="deposit/payco"><?= lang('pco');?></option>
                            <option value="btc" data-url="deposit/cryptocurrency"><?= lang('btc');?></option>

                            
                            
                            <!--<option value="pxm" data-url="deposit/paxum"><?/*= lang('pxm');*/?></option>-->
                           <!-- <option value="ppl" data-url="deposit/paypal"><?//= lang('ppl');?></option> -->
                            <!--<option value="web" data-url="deposit/webmoney"><?//= lang('web');?></option>-->
                            
                            <!-- <option value="qwi" data-url="deposit/qiwi"><?//= lang('qwi');?></option> -->
                           <!-- <option value="mgt" data-url="deposit/megatransfer"><?= lang('mgt');?></option>-->
                            <?php if(IPLoc::Office()){   //!IPLoc::isIPandLanguageChina()){ ?>
                            <!--<option value="btc" data-url="deposit/bitcoin"><?//= lang('btc');?></option>-->
                            <?php } ?>
                           <!-- <option value="ynx" data-url="deposit/yandex"><?//= lang('ynx');?></option> -->
                           <!-- <option value="mtr" data-url="deposit/moneta"><?/*= lang('mtr');*/?></option>-->
                            <option value="fasapay" data-url="deposit/fasapay"><?= lang('fasap');?></option>
                            <option value="cup" data-url="deposit/china-union-pay"><?= lang('cup');?></option>
                            <?php
                            if(!FXPP::isAccountFromEUCountry()){ ?>
                                <!-- <option value="accentpay" data-url="deposit/accentpay"><?//=lang('dep_accen');?></option> -->
                            <?php } ?>

                            <option value="alipay" data-url="deposit/alipay"><?=lang('dep_alipay');?></option>


                            <!--            <option value="hwt">Deposit HiPay Wallet</option>-->
                            <!--            <option value="pmts">Deposit Payments</option>-->
                            <!--            <option value="pmil">Deposit Paymill</option>-->

                               <!-- <option value="inp" data-url="deposit/inpay">Deposit Inpay</option> -->

                              

                        </select>
                    </div>
                    <div class="finance-image-rep col-lg-4 col-md-4 col-sm-4 col-xs-12" id="paymentMethodLogo">
                        <img id="idr" src="<?= $this->template->Images()?>/indcard.png" class="img-responsive imgclslogo"/>
                        <img id="ldidr" src="<?= $this->template->Images()?>/indcard.png" class="img-responsive imgclslogo"/>
                        <img id="ldmyr" src="<?= $this->template->Images()?>/myrcard.png" class="img-responsive imgclslogo"/>
                        <img id="myr" src="<?= $this->template->Images()?>/myrcard.png" class="img-responsive imgclslogo"/>
                        <img id="thb" src="<?= $this->template->Images()?>/thaibanks.png" class="img-responsive imgclslogo"/>
                        <img id="bt" src="<?= $this->template->Images()?>/banktransfer.png" class="img-responsive imgclslogo"/>
                        <img id="ddcc" src="<?= $this->template->Images()?>/ccard-new.png" class="img-responsive imgclslogo "/>
                        <img id="skl" src="<?= $this->template->Images()?>/skrill.png" class="img-responsive imgclslogo"/>
                        <img id="ntl" src="<?= $this->template->Images()?>/neteller.png" class="img-responsive imgclslogo"/>
                        <img id="pxm" src="<?= $this->template->Images()?>/paxum.png" class="img-responsive imgclslogo"/>
                        <img id="ppl" src="<?= $this->template->Images()?>/paypal.png" class="img-responsive imgclslogo"/>
                        <img id="web" src="<?= $this->template->Images()?>/webmoney.png" class="img-responsive imgclslogo"/>
                        <img id="pco" src="<?= $this->template->Images()?>/payco.png" class="img-responsive imgclslogo"/>
                        <img id="qwi" src="<?= $this->template->Images()?>/qiwilogo.png" class="img-responsive imgclslogo"/>
                        <img id="mgt" src="<?= $this->template->Images()?>/megatransfer.png" class="img-responsive imgclslogo"/>
                        <img id="btc" src="<?= $this->template->Images()?>/bitcoinlogo.png" class="img-responsive imgclslogo"/>
                        <img id="ynx" src="<?= $this->template->Images()?>/yandex.png" class="img-responsive imgclslogo"/>
                        <img id="mtr" src="<?= $this->template->Images()?>/moneta.png" class="img-responsive imgclslogo"/>
                        <!--<img id="sft" src="<?/*= $this->template->Images()*/?>/sofortlogo.png" class="img-responsive imgclslogo imgclsdtl"/>-->
                        <img id="hwt" src="<?= $this->template->Images()?>/hipaywalletlogo.png" class="img-responsive imgclslogo"/>
                        <img id="pmts" src="<?= $this->template->Images()?>/epaymentslogo.png" class="img-responsive imgclslogo"/>
                        <img id="pmil" src="<?= $this->template->Images()?>/paymilllogo.png" class="img-responsive imgclslogo"/>
                        <img id="fasapay" src="<?= $this->template->Images()?>/fasapay.png" class="img-responsive imgclslogo"/>
                        <img id="payoma" src="<?= $this->template->Images()?>/payoma.png" class="img-responsive imgclslogo"/>
                        <img id="accentpay" src="<?= $this->template->Images()?>ecommpay.png" class="img-responsive imgclslogo"/>
                        <img id="cup" src="<?= $this->template->Images()?>/chinaUnionPay.png" class="img-responsive imgclslogo"/>
                        <img id="alipay" src="<?= $this->template->Images()?>alipay.png" class="img-responsive imgclslogo"/>

                        <img id="inp" src="<?= $this->template->Images()?>/inpay_icon.png" class="img-responsive imgclslogo"/>

                    </div>
                    <div class="finance-description col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <p id="idr" class="pDescription"><?= lang('idr_desc');?></p>
                        <p id="ldidr" class="pDescription"><?=lang('idr_desc');?></p>
                        <p id="ldmyr" class="pDescription"><?=lang('lcl_depos_des');?></p>
                        <p id="myr" class="pDescription"><?= lang('myr_desc');?></p>
                        <p id="thb" class="pDescription"><?=lang('lcl_bnk_tr_des');?></p>
                        <p id="bt" class="pDescription"><?= lang('BankTransfer_desc');?></p>
                        <p id="ddcc" class="pDescription "><?= lang('Visa_desc');?></p>
                        <p id="skl" class="pDescription"><?= lang('Skrill_desc');?></p>
                        <p id="ntl" class="pDescription"><?= lang('Neteller_desc');?></p>
                        <p id="pxm" class="pDescription"><?= lang('Paxum_desc');?></p>
                        <p id="ppl" class="pDescription"><?= lang('paypal_desc');?></p>
                        <p id="web" class="pDescription"><?= lang('WebMoney_desc');?></p>
                        <p id="pco" class="pDescription"><?= lang('PayCo_desc');?></p>
                        <p id="qwi" class="pDescription"><?= lang('QiWi_desc');?></p>
                        <p id="mgt" class="pDescription"><?= lang('MegaTransfer_desc');?></p>
                        <p id="btc" class="pDescription"><?= lang('Bitcoin_desc');?></p>
                        <p id="ynx" class="pDescription"><?= lang('YandexMoney_desc');?></p>
                        <p id="mtr" class="pDescription dddddd"><?= lang('Moneta_desc');?></p>
                        <!--<p id="sft" class="pDescription defaultDes"><?/*= lang('Sofort_desc');*/?></p>-->
                        <p id="hwt" class="pDescription"><?= lang('HipayWallet_desc');?></p>
                        <p id="pmts" class="pDescription"><?= lang('Payments_desc');?></p>
                        <p id="pmil" class="pDescription"><?= lang('Paymill_desc');?></p>
                        <p id="fasapay" class="pDescription"><?= lang('fasapay_desc');?></p>
                        <p id="payoma" class="pDescription"><?=lang('dep_payoma_des');?></p>
                        <p id="accentpay" class="pDescription"><?=lang('dep_accen_des');?></p>
                        <p id="cup" class="pDescription"><?= lang('cup_desc');?></p>
                        <p id="alipay" class="pDescription"> <?=lang('dep_alipay_des');?></p>
                        <p id="inp" class="pDescription"> <?=lang('dep_inpay_des');?></p>
                    </div>
                </div>

                <div class="hidden-finance-dep-local paymentforidr">
                    <?php if (!FXPP::isAccountFromEUCountry()) { ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 local-bank-content chk-desc">
                        <?php if(!FXPP::isNewMtGroup()){ ?>
                            <select class="form-control btc-bonus-type" name="btc_bonus_type" id="btcBonusType">
                                    <option selected value="tpb"><?=lang('30Bonus'); ?></option>
                                <?php if(FXPP::fmGroupType($_SESSION['account_number']) != 'ForexMart Pro'){?>
                                    <option value="twpb"><?=lang('20Bonus'); ?></option>
                                <?php } ?>
                                <!--<option value="fpb"><?//=lang('50Bonus'); ?></option>-->
                            </select>
                        <?php }else{?>
                            <?php if(!FXPP::isNewMtGroup()){ ?>
                                <input type="hidden" value = "tpb" id = "btcBonusType">
                            <?php } ?>
                            <?php if(FXPP::fmGroupType($_SESSION['account_number']) != 'ForexMart Pro'){?>
                                <input type="hidden" value = "twpb" id = "btcBonusType">
                            <?php } ?>
                        <?php }  ?>

                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 local-bank-content chk-desc">
                        <div class="checkbox chk-bitcoin">
                            <label>
                                <input type="checkbox" class="chk" id="btcCheck">
                                <?php if(!FXPP::isNewMtGroup()){ ?>
                                    <img src="<?= $this->template->Images()?>30-percent-bonus.png" id="chk-active" class="show-btc-img"/>
                                    <img src="<?= $this->template->Images()?>30-percent-bonus-inactive.png" style="display:none" id="chk-deactive" class="show-btc-img"/>
                                <?php } ?>
                                <?php if(FXPP::fmGroupType($_SESSION['account_number']) != 'ForexMart Pro'){?>
                                    <img src="<?= $this->template->Images()?>20-percent-bonus.png" id="chk-active" class="show-btc-img"/>
                                    <img src="<?= $this->template->Images()?>20-percent-bonus-inactive.png" style="display:none" id="chk-deactive" class="show-btc-img"/>
                                <?php } ?>

                            </label>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-10 col-sm-8 col-xs-8 local-bank-content">
                        <?php if(!FXPP::isNewMtGroup()){ ?>
                            <p id="text-bonus-btc-30"><?= lang('opportunity');?></p>
                        <?php } ?>
                        <?php if(FXPP::fmGroupType($_SESSION['account_number']) != 'ForexMart Pro'){?>
                            <p id="text-bonus-btc-20"><?= lang('opportunity20');?></p>
                        <?php } ?>

                    </div>
                    <?php } ?>
                    <div class="finance-total-amount finance-local-total-amount col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <button type="submit" id="submit_bonus"><?= lang('Proceed');?></button>
                    </div>
                </div>

                <div class="finance-deposit-second-container fdsc">
                    <?php if($acc_status['accountstatus']==0 && $error_msg){ ?>
                        <div class="check-deposit-unverified col-lg-12 col-md-11 col-xs-11 col-sm-11" style="display: none;">
                            <span><?=$error_msg?></span>
                            <span id="check-balance-unverified"></span>
                        </div>
                    <?php }?>
                    <div class="finance-dep-table-parent col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="finance-dep-table">
                            <table id="financetable">
                                <thead>
                                <th></th>
                                <th><?= lang('DepositAmount');?></th>
                                <th>
                                        <?php if (!FXPP::isAccountFromEUCountry()) { ?>
                                            <select class="form-control" name="bonus_type" id="bonusType">
                                                <?php if(FXPP::fmGroupType($_SESSION['account_number']) != 'ForexMart Pro'){?>
                                                    <option value="twpb"><?=lang('20Bonus'); ?></option>
                                                <?php } ?>

                                                <?php if (!FXPP::isNewMtGroup()) { ?>
                                                <option selected value="tpb"><?= lang('30Bonus'); ?></option>
                                                <?php } ?>
<!--                                                <option value="fpb">--><?//= lang('50Bonus'); ?><!--</option>-->
                                                <?php if (IPLoc::Office()) { ?>
                                                   <!-- <option value="rhpb"><?//= lang('100Bonus'); ?></option>-->
                                                <?php } ?>
                                            </select>
                                        <?php } ?>
                                </th>
                                <th><?= lang('YouGet');?></th>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($depositAmount as $value) {
                                    // $get = $value * 0.3;
                               if (FXPP::isNewMtGroup()) {
                                   $bonusVal = 20;
                               }else{
                                   $bonusVal = 30;
                               }
                                    $get = $value*$bonusVal/100;
                                    $get = $value+$get;
                                    
                                        $chance_amount = array(10000,5000,3000,1000,500);
                                        if($base_currency == 'RUB'){
                                            $chance_amount= array(1000000, 500000, 300000, 100000, 50000, 30000);
                                        }
                                    
                                    // echo number_format($value);
                                    echo "<tr>";
                                    echo '<td><input value=" ' . $value . ' "  name="bonus_deposit_amount" type="radio" class="radio_class"/></td>';
                                    echo "<td>".$currency." ".number_format($value)."</td>";


                                       if(!FXPP::isAccountFromEUCountry()){
                                          echo '<td><div class="checking-bonus"><input type="checkbox" class="ckbox_class" checked/></div></td>';
                                       }else{
                                          echo '<td><div class="checking-bonus"></div></td>';
                                       }

                                    echo '<td id="currencysign">'.$currency.' '.'<span class="get">'.number_format($get).'</span></td>';
                                    echo "</tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="finance-total-amount col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="finance-total-amount-left">
                            <input name="bonus_deposit_amount" type="radio" class="radio_class radio_id lastRadiobutton" />
                        </div>
                        <div class="finance-total-amount-right">
                            <label><?= lang('OtherAmount');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><?=$currency;?></div>
                                <input class="form-control" id="amount" name="amount" type="text" placeholder="<?=lang('amount')?>" disabled="disabled" />
                            </div>
                        </div>
                    </div>
                    <div class="finance-total-amount col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="finance-total-sub-amount">
                                <?php if (!FXPP::isAccountFromEUCountry()) { ?>
                                    <div class="finance-total-amount-left-child">
                                        <input type="checkbox" id="lastBox" class="other_ckbox" checked/>
                                    </div>
                                    <div class="finance-total-amount-right-child" id="img_show_percent">
                                        <div class="check-box-last">
                                           <?php if (FXPP::isNewMtGroup()) { ?>
                                               <img src="<?= $this->template->Images() ?>/20-percent-bonus.png" class="img-responsive img-other">
                                            <?php }else{ ?>
                                               <img src="<?= $this->template->Images() ?>/30-percent-bonus.png" class="img-responsive img-other">
                                            <?php } ?>

                                        </div>
                                    </div>

                                <?php } ?>

                        </div>

                            <div class="finance-total-sub-amount twenty-percent-panel">
                                <div class="finance-total-amount-left-child">
                                    <input type="checkbox" id="agree_checkbox_20" class="agree_checkbox_20" checked="">
                                </div>
                                <div class="finance-total-amount-right-child" id="img_show_percent">
                                    I agree with the <a href="https://www.forexmart.com/twenty-percent-bonus-agreement" class="agreement-20" target="_blank" style="color: #337AB7;background: none;padding: 0px; width: 100%;"><span class="bonus-agreement-type">20% bonus agreement  </span></a>
                                </div>

                            </div>


                    </div>
                    <div class="finance-total-amount col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label><?= lang('YouGet');?></label>
                        <div class="input-group">
                            <div class="input-group-addon"><?=$currency;?></div>
                            <input class="form-control" id="set_amount" name="amount" type="text" disabled="disabled" />
                        </div>
                        <button type="submit" class="btn_class_disable" id="submit_bonus"><?= lang('Proceed');?></button>
                    </div>
                    <?php if(FXPP::isEUUrl()){ ?>
                        <div class="regulatory-note col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <a target="_blank" href="<?=FXPP::www_url('cysec')?>"><?= lang('All_deposits');?></a><br>
                            <p style="color: #337ab7; text-align: center"> located at Spetson 23A, Leda Court, Block B, Office B203, 4000 Mesa Geitonia, Limassol Cyprus</p>
                        </div>
                    <?php  } ?>

                </div>

                <!-- START HIDDEN CONTAINER (SHOW WHEN IN MOBILE VERSION) -->
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 main-finance-deposit-container">
                    <div class="finance-deposit-holder">
                        <div class="finance-image-rep2 col-lg-4 col-md-4 col-sm-4 col-xs-12" id="paymentMethodLogo2">
                            <img id="idr"  src="<?= $this->template->Images()?>/indcard.png"          class="img-responsive imgclslogo2 "/>
                            <img id="myr"  src="<?= $this->template->Images()?>/myrcard.png"          class="img-responsive imgclslogo2 "/>
                            <img id="thb"  src="<?= $this->template->Images()?>/myrcard.png"          class="img-responsive imgclslogo2 "/>
                            <img id="bt"   src="<?= $this->template->Images()?>/banktransfer.png"     class="img-responsive imgclslogo2 "/>
                            <img id="ddcc" src="<?= $this->template->Images()?>/ccard.png"            class="img-responsive imgclslogo2  "/>
                            <img id="skl"  src="<?= $this->template->Images()?>/skrill.png"           class="img-responsive imgclslogo2 "/>
                            <img id="ntl"  src="<?= $this->template->Images()?>/neteller.png"         class="img-responsive imgclslogo2 "/>
                            <img id="pxm"  src="<?= $this->template->Images()?>/paxum.png"            class="img-responsive imgclslogo2 "/>
                            <img id="ppl"  src="<?= $this->template->Images()?>/paypal.png"           class="img-responsive imgclslogo2 "/>
                            <img id="web"  src="<?= $this->template->Images()?>/webmoney.png"         class="img-responsive imgclslogo2 "/>
                            <img id="pco"  src="<?= $this->template->Images()?>/payco.png"            class="img-responsive imgclslogo2 "/>
                            <img id="qwi"  src="<?= $this->template->Images()?>/qiwilogo.png"         class="img-responsive imgclslogo2 "/>
                            <img id="mgt"  src="<?= $this->template->Images()?>/megatransfer.png"     class="img-responsive imgclslogo2 "/>
                            <img id="btc"  src="<?= $this->template->Images()?>/bitcoinlogo.png"      class="img-responsive imgclslogo2 "/>
                            <img id="ynx"  src="<?= $this->template->Images()?>/yandex.png"           class="img-responsive imgclslogo2 " />
                            <img id="mtr"  src="<?= $this->template->Images()?>/moneta.png"           class="img-responsive imgclslogo2 "/>
                            <img id="sft"  src="<?= $this->template->Images()?>/sofortlogo.png"       class="img-responsive imgclslogo2 imgclsdtl"/>
                            <img id="hwt"  src="<?= $this->template->Images()?>/hipaywalletlogo.png"  class="img-responsive imgclslogo2 "/>
                            <img id="pmts" src="<?= $this->template->Images()?>/epaymentslogo.png"    class="img-responsive imgclslogo2 "/>
                            <img id="pmil" src="<?= $this->template->Images()?>/paymilllogo.png"      class="img-responsive imgclslogo2 "/>
                            <img id="fasapay2" src="<?= $this->template->Images()?>/fasapay.png"      class="img-responsive imgclslogo2 "/>
                            <img id="payoma2" src="<?= $this->template->Images()?>/payoma.png"      class="img-responsive imgclslogo2 "/>
                            <img id="cup" src="<?= $this->template->Images()?>/chinaUnionPay.png" class="img-responsive imgclslogo2"/>
                            <img id="inp" src="<?= $this->template->Images()?>/inpay_icon.png" class="img-responsive imgclslogo2"/>

                        </div>

                        <div class="finance-description2 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <p id="idr" class="pDescription2"><?= lang('idr_desc');?></p>
                            <p id="myr" class="pDescription2"><?= lang('myr_desc');?></p>
                            <p id="thb" class="pDescription2"><?= lang('myr_desc');?></p>
                            <p id="bt" class="pDescription2"><?= lang('BankTransfer_desc');?></p>
                            <p id="ddcc" class="pDescription2 "><?= lang('Visa_desc');?></p>
                            <p id="skl" class="pDescription2"><?= lang('Skrill_desc');?></p>
                            <p id="ntl" class="pDescription2"><?= lang('Neteller_desc');?></p>
                            <p id="pxm" class="pDescription2"><?= lang('Paxum_desc');?></p>
                            <p id="ppl" class="pDescription2"><?= lang('paypal_desc');?></p>
                            <p id="web" class="pDescription2"><?= lang('Payments_desc');?></p>
                            <p id="pco" class="pDescription2"><?= lang('PayCo_desc');?></p>
                            <p id="qwi" class="pDescription2"><?= lang('QiWi_desc');?></p>
                            <p id="mgt" class="pDescription2"><?= lang('MegaTransfer_desc');?></p>
                            <p id="btc" class="pDescription2"><?= lang('Bitcoin_desc');?></p>
                            <p id="ynx" class="pDescription2"><?= lang('YandexMoney_desc');?></p>
                            <p id="mtr" class="pDescription2"><?= lang('Moneta_desc');?></p>
                            <p id="sft" class="pDescription2 defaultDes2"><?= lang('Sofort_desc');?></p>
                            <p id="hwt" class="pDescription2"><?= lang('HipayWallet_desc');?></p>
                            <p id="pmts" class="pDescription2"><?= lang('Payments_desc');?></p>
                            <p id="pmil" class="pDescription2"><?= lang('Paymill_desc');?></p>
                            <p id="fasapay2" class="pDescription2"><?= lang('fasapay_desc');?> </p>
                            <p id="payoma" class="pDescription2">With Payoma, no need for manual processing. Transaction is fas

                                ter, safer and automatic. </p>
                             <p id="cup" class="pDescription2"><?= lang('cup_desc');?></p>
                             <p id="inp" class="pDescription2"> Inpay is a great way to pay online around the world using your local bank account.</p>
                        </div>


                        <div class="parent-fin-dep-content">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                                <label><?= lang('PaymentMethods');?></label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">

                                <select class="form-control" id="select-deposit-logo2">
                                    <?php if(!FXPP::notAllowedPayomaDepositCountry()){?>
                                        <option value="ddcc" data-url="deposit/debit-credit-cards"><?= lang('DepositCredit');?></option>
                                    <?php }?>


                                      <?php if(FXPP::isMalaysianCountry()){ ?>
                                        <option value="myr" data-url="deposit/bank-transfer-myr"><?= lang('myr');?></option>
                                    <?php } ?>

                                    <?php if(FXPP::isMalaysianCountry()){ ?>
                                         <option value="ldmyr" data-url="deposit/local-depositor-myr"><?=lang('lcl_depos');?></option>
                                    <?php } ?>


                                    <?php if(FXPP::isIndonesianCountry()){ ?>
                                        <option value="ldidr" data-url="deposit/local-depositor-idr">Local Depositor in Indonesia</option>
                                    <?php } ?>
                                    <?php if(IPLoc::Office() &&  FXPP::isIndonesianCountry()){?>
                                        <option value="idr" data-url="deposit/bank-transfer-idr"><?= lang('idr');?></option>
                                  <?php } ?>


                                    <?php if(FXPP::isThailandCountry()){?>
                                        <option value="thb" data-url="deposit/bank-transfer-thb"><?=lang('lcl_bnk_tr');?></option>
                                    <?php } ?>


                                    <!-- <option value="bt" data-url="deposit/bank-wire-transfer"><?//= lang('bt');?></option> -->

                                    <?php if(!FXPP::isEUClient()){?>
                                    <option value="skl" data-url="deposit/skrill"><?= lang('skl');?></option>
                                    <option value="ntl" data-url="deposit/neteller"><?= lang('ntl');?></option>


                                    <?php }?>
                                    <option value="pco" data-url="deposit/payco"><?= lang('pco');?></option>
                                    <option value="btc" data-url="deposit/cryptocurrency"><?= lang('btc');?></option>


                                    <?php if(IPLoc::Office()){?>
                                        <option value="pxm" data-url="deposit/paxum"><?= lang('pxm');?></option>
                                    <?php }?>
                                   <!-- <option value="ppl" data-url="deposit/paypal"><?//= lang('ppl');?></option>-->
                                   <!-- <option value="web" data-url="deposit/webmoney"><?//= lang('web');?></option>-->
                                   
                                    <!-- <option value="qwi" data-url="deposit/qiwi"><?//= lang('qwi');?></option> -->
                                   <!-- <option value="mgt" data-url="deposit/megatransfer"><?= lang('mgt');?></option>-->
                                    <?php if(IPLoc::Office()){   //!IPLoc::isIPandLanguageChina()){ ?>
                                    <!--<option value="btc" data-url="deposit/bitcoin"><?//= lang('btc');?></option>-->
                                    <?php }?>
                                   <!-- <option value="ynx" data-url="deposit/yandex"><?//= lang('ynx');?></option>-->
                                   <!-- <option value="mtr" data-url="deposit/moneta"><?/*= lang('mtr');*/?></option>-->


                                    <option value="fasapay2" data-url="deposit/fasapay"><?= lang('fasap');?></option>
                                    <?php if(!FXPP::isAccountFromEUCountry()){?>
                                       <!-- <option value="payoma2" data-url="deposit/payoma">Deposit Payoma</option>-->
                                    <?php }?>
                                    <?php
                                    if(!FXPP::isAccountFromEUCountry()){ ?>
                                        <option value="accentpay2" data-url="deposit/accentpay"><?=lang('dep_accen');?></option>
                                    <?php } ?>

                                     <option value="cup" data-url="deposit/china-union-pay"><?= lang('cup');?></option>

                                    <!--            <option value="hwt">Deposit HiPay Wallet</option>-->
                                    <!--            <option value="pmts">Deposit Payments</option>-->
                                    <!--            <option value="pmil">Deposit Paymill</option>-->

                                   <!-- <option value="inp" data-url="deposit/inpay">Deposit Inpay</option> -->

                                    <option value="alipay" data-url="deposit/alipay"><?=lang('dep_alipay');?></option>
                                   
                                </select>
                            </div>
                        </div>
                        <div class="fdsc">
                            <div class="parent-fin-dep-content">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                                    <label><?= lang('chose_amount');?></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                                    <select class="form-control finval" id="financetable" >
                                        <?php
                                        if (FXPP::isNewMtGroup()) {
                                            $bonusVal = 20;
                                        }else{
                                            $bonusVal = 30;
                                        }
                                        asort($depositAmount);
                                        foreach ($depositAmount as $value) {

                                            $get = $value*$bonusVal/100;
                                            $get = $value+$get;
                                            echo '<option value="'. $value .'" >'.$value.'</option>';
                                        }
                                        $cash = array_values($depositAmount)[0];
                                        $cash2 = $cash*$bonusVal/100;
                                        $cash2 = $cash2+$cash;

                                        ?>
                                        <option value="OtherAmount"><?= lang('OtherAmount');?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="parent-fin-dep-content">




                                <div style="display: none" class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input set_amount2Div">
                                    <input  type="text" class="form-control" id="set_amount2" name="set_amount2" value='10' disabled="disabled" placeholder="Enter Amount">
                                </div>



                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                                   <!-- <img src="<?/*= $this->template->Images()*/?>/30-percent-bonus.png" class="img-responsive">-->

                                        <?php if (!FXPP::isAccountFromEUCountry()) { ?>
                                            <label>Bonus</label>
                                            <select class="form-control" name="bonus_type" id="bonusType2">
                                                <?php if(FXPP::fmGroupType($_SESSION['account_number']) != 'ForexMart Pro'){?>
                                                    <option value="twpb"><?=lang('20Bonus'); ?></option>
                                                <?php } ?>
                                                <?php if(!FXPP::isNewMtGroup()){ ?>
                                                <option selected value="tpb"><?= lang('30Bonus'); ?></option>
                                                <?php }?>
                                               <!-- <option value="fpb"><?//= lang('50Bonus'); ?></option>-->
                                                <option value="none"><?= lang('WithoutBonus'); ?></option>
                                                <!--<option value="fpb"><?/*= lang('100Bonus'); */?></option>-->
                                            </select>
                                        <?php } ?>

                                </div>



                            </div>
                            <div class="parent-fin-dep-content">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                                    <label><?= lang('total');?></label>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                                    <input class="form-control" id="amount2" name="amount2" type="text" value='' disabled="disabled">
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input twenty-percent-panel-mobile" >
                                    <input class="" type="checkbox" id="agree_checkbox_20_mobile" checked="">
                                    I agree with the <a href="https://www.forexmart.com/twenty-percent-bonus-agreement" class="agreement-20" target="_blank" style="color: #337AB7;background: none;padding: 0px; width: 100%;"><span class="bonus-agreement-type">20% bonus agreement  </span></a>
                                </div>

                            </div>
                        </div>
                        <div class="parent-fin-dep-content">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input-button">
                                <button type="submit" id="submit_bonus2"><?= lang('Proceed');?></button>
                            </div>
                        </div>
<!--                        <a href="javascript:;">--><?//= lang('All_deposits');?><!--</a>-->
<!--                        <p style="color: #337ab7;float:right"> located at Spetson 23A, Leda Court, Block B, Office B203, 4000 Mesa Geitonia, Limassol Cyprus</p>-->
                    </div>
                </div>
                <!-- END HIDDEN CONTAINER (SHOW WHEN IN MOBILE VERSION) -->
            </div>
        </div>
    </div>
</div>
<?=$show_modal;?>
<?=$modal_bonus_alert?>

<script type="text/javascript">
    var isNewAccountType = '<?=$isNewAccountType?>';

function carListShowFromMyAccount()
{
     
       var url = document.URL;
        var urlx=url.substr(url.lastIndexOf('/') + 1) ;
         var paymentTypeID="";
        
        if(urlx.toLowerCase().indexOf("&minimum=")>= 0)
        {
              var res = urlx.split("?method=");
              var resSecondData = res[1].split("&minimum=");
              var min_stat = resSecondData[1];
              paymentTypeID=resSecondData[0]; 
              var substr = resSecondData[1].split('__');

            //  alert("Minimum deposit is at least "+substr[0]+" "+substr[1]);

            if(min_stat == '0'){
                $("#modalBonusAlert").find(".bonus-alert-title").html('<?= lang('trd_14'); ?>');
                $('.bonus-alert-message').html("<b style='font-size:14px'>Please verify your account <a href='<?=FXPP::my_url('profile/upload-documents')?>'>here</a>. </b>");
                $('#modalBonusAlert').modal('show');
            }else{
                $("#modalBonusAlert").find(".bonus-alert-title").html('<?= lang('trd_14'); ?>');
                $('.bonus-alert-message').html("<b style='color:red'><?= lang('trd_265'); ?>"+substr[0]+" "+substr[1]+" </b>");
                $('#modalBonusAlert').modal('show');
            }
            

                var xheight=(window.innerHeight/2);
              window.scrollTo(0,xheight);
        }
        else if(urlx.toLowerCase().indexOf("?method=")>= 0){
             var res = urlx.split("?method=");
               paymentTypeID=res[1];
        }
        
 
        if(paymentTypeID!="")
        {
            var langu = '<?php echo FXPP::html_url();?>';
            var typemethod = '<?php echo $_GET['method']; ?>';
           /* if(langu == 'zh' || typemethod == 'cup' ) {
                $('#select-deposit-logo option[value="cup"]').attr ('selected','selected');
                $('#select-deposit-logo2 option[value="cup"]').attr ('selected','selected');
                $('#select-deposit-logo option[value="sft"]').removeAttr('selected','selected');
                $('#select-deposit-logo2 option[value="sft"]').removeAttr('selected','selected');
                $("#paymentMethodLogo").find("img#cup").show();
                $("#paymentMethodLogo2").find("img#cup").show();
                $("#paymentMethodLogo").find("img#sft").hide();
                $("#paymentMethodLogo2").find("img#sft").hide();
                $(".finance-description").find('p#sft').hide();
                $(".finance-description2").find('p#sft').hide();
                $(".finance-description").find('p#cup').show();
                $(".finance-description2").find('p#cup').show();

            }
            if( typemethod != 'sft' && typemethod.length != 0 && langu != 'zh'){

                $("#paymentMethodLogo").find("img#sft").hide();
                $("#paymentMethodLogo2").find("img#sft").hide();
                $(".finance-description").find('p#sft').hide();
                $(".finance-description2").find('p#sft').hide();

            }
            if(typemethod.length == 0 && langu != 'zh'){

                $("#paymentMethodLogo").find("img#sft").show();
                $("#paymentMethodLogo2").find("img#sft").show();
                $(".finance-description").find('p#sft').show();
                $(".finance-description2").find('p#sft').show();

            }
            if(typemethod.length == 0 && langu == 'zh'){

                $("#paymentMethodLogo").find("img#cup").show();
                $("#paymentMethodLogo2").find("img#cup").show();
                $(".finance-description").find('p#cup').show();
                $(".finance-description2").find('p#cup').show();

            }else if(typemethod != 'cup' && typemethod.length != 0 &&  langu == 'zh'){

                $("#paymentMethodLogo").find("img#cup").hide();
                $("#paymentMethodLogo2").find("img#cup").hide();
                $(".finance-description").find('p#cup').hide();
                $(".finance-description2").find('p#cup').hide();

            }*/


//            $('#select-deposit-logo option[value="sft"]').removeAttr('selected','selected');
//            $('#select-deposit-logo2 option[value="sft"]').removeAttr('selected','selected');
//
//           $("#paymentMethodLogo").find("img").removeClass('imgclsdtl');
//           $("#paymentMethodLogo2").find("img").removeClass('imgclsdtl');
//           $("#paymentMethodLogo").find("img").hide();
//           $("#paymentMethodLogo2").find("img").hide();
//           $(".pDescription").removeClass('defaultDes');
//           $(".pDescription2").removeClass('defaultDes2');
            
           
            $('#select-deposit-logo option[value="'+paymentTypeID+'"]').attr('selected','selected');
            $('#select-deposit-logo2 option[value="'+paymentTypeID+'"]').attr('selected','selected');            
            $("p#"+paymentTypeID).addClass("defaultDes");           
            $("#paymentMethodLogo").find("#"+paymentTypeID).addClass("imgclsdtl");
            $("#paymentMethodLogo2").find("#"+paymentTypeID).addClass("imgclsdtl");
            $(".imgclsdtl").show();
            
             if(paymentTypeID == 'idr' || paymentTypeID == 'myr' || paymentTypeID == 'btc' || paymentTypeID == 'ldbtc'){
                $(".fdsc").hide();
                $(".paymentforidr").show();
                $("#submit_bonus").removeAttr("disabled");
            }

        }

}
    $(window).load(function(){
        $("#t1").addClass("acct-active");

        var langu = '<?php echo FXPP::html_url();?>';
        var typemethod = '<?php echo $_GET['method']; ?>';
        console.log(langu);
        console.log(typemethod);



        if( typemethod != 'sft' && typemethod.length != 0){

            $("#paymentMethodLogo").find("img#sft").hide();
            $("#paymentMethodLogo2").find("img#sft").hide();
            $(".finance-description").find('p#sft').hide();
            $(".finance-description2").find('p#sft').hide();

        }


        var checkOtherAcc=$('.finval').val();
        if (checkOtherAcc == 'OtherAmount') {

            $(".set_amount2Div").show();
            $("#set_amount2").removeAttr("disabled");
            $("#set_amount2").val('');
            $("#amount2").val('');
        }else{
            $(".set_amount2Div").hide();
        }



      /*  if(langu == 'zh' || typemethod == 'cup' ) {
            $('#select-deposit-logo option[value="cup"]').attr ('selected','selected');
            $('#select-deposit-logo2 option[value="cup"]').attr ('selected','selected');
            $('#select-deposit-logo option[value="sft"]').removeAttr('selected','selected');
            $('#select-deposit-logo2 option[value="sft"]').removeAttr('selected','selected');
            $("#paymentMethodLogo").find("img#cup").show();
            $("#paymentMethodLogo2").find("img#cup").show();
            $("#paymentMethodLogo").find("img#sft").hide();
            $("#paymentMethodLogo2").find("img#sft").hide();
            $(".finance-description").find('p#sft').hide();
            $(".finance-description2").find('p#sft').hide();
            $(".finance-description").find('p#cup').show();
            $(".finance-description2").find('p#cup').show();

        }
        if(typemethod.length == 0 && langu != 'zh'){
console.log(true);
            $("#paymentMethodLogo").find("img#sft").show();
            $("#paymentMethodLogo2").find("img#sft").show();
            $(".finance-description").find('p#sft').show();
            $(".finance-description2").find('p#sft').show();

        }
        if( typemethod != 'sft' && typemethod.length != 0 && langu != 'zh'){

            $("#paymentMethodLogo").find("img#sft").hide();
            $("#paymentMethodLogo2").find("img#sft").hide();
            $(".finance-description").find('p#sft').hide();
            $(".finance-description2").find('p#sft').hide();

        }
        if(typemethod.length == 0 && langu == 'zh'){

            $("#paymentMethodLogo").find("img#cup").show();
            $("#paymentMethodLogo2").find("img#cup").show();
            $(".finance-description").find('p#cup').show();
            $(".finance-description2").find('p#cup').show();

        }else if(typemethod != 'cup' && typemethod.length != 0 &&  langu == 'zh'){

            $("#paymentMethodLogo").find("img#cup").hide();
            $("#paymentMethodLogo2").find("img#cup").hide();
            $(".finance-description").find('p#cup').hide();
            $(".finance-description2").find('p#cup').hide();

        }*/




    });

    $(document).ready(function(){

        var langu = '<?php echo FXPP::html_url();?>';
        var typemethod = '<?php echo $_GET['method']; ?>';
       /* if(langu == 'zh' || typemethod == 'cup' ) {
            $('#select-deposit-logo option[value="cup"]').attr ('selected','selected');
            $('#select-deposit-logo2 option[value="cup"]').attr ('selected','selected');
            $('#select-deposit-logo option[value="sft"]').removeAttr('selected','selected');
            $('#select-deposit-logo2 option[value="sft"]').removeAttr('selected','selected');
            $("#paymentMethodLogo").find("img#cup").show();
            $("#paymentMethodLogo2").find("img#cup").show();
            $("#paymentMethodLogo").find("img#sft").hide();
            $("#paymentMethodLogo2").find("img#sft").hide();
            $(".finance-description").find('p#sft').hide();
            $(".finance-description2").find('p#sft').hide();
            $(".finance-description").find('p#cup').show();
            $(".finance-description2").find('p#cup').show();

        }
        if( typemethod != 'sft' && typemethod.length != 0 && langu != 'zh'){

            $("#paymentMethodLogo").find("img#sft").hide();
            $("#paymentMethodLogo2").find("img#sft").hide();
            $(".finance-description").find('p#sft').hide();
            $(".finance-description2").find('p#sft').hide();

        }
        if(typemethod.length == 0 && langu != 'zh'){

            $("#paymentMethodLogo").find("img#sft").show();
            $("#paymentMethodLogo2").find("img#sft").show();
            $(".finance-description").find('p#sft').show();
            $(".finance-description2").find('p#sft').show();

        }
        if(typemethod.length == 0 && langu == 'zh'){

            $("#paymentMethodLogo").find("img#cup").show();
            $("#paymentMethodLogo2").find("img#cup").show();
            $(".finance-description").find('p#cup').show();
            $(".finance-description2").find('p#cup').show();

        }else if(typemethod != 'cup' && typemethod.length != 0 &&  langu == 'zh'){

            $("#paymentMethodLogo").find("img#cup").hide();
            $("#paymentMethodLogo2").find("img#cup").hide();
            $(".finance-description").find('p#cup').hide();
            $(".finance-description2").find('p#cup').hide();

        }*/

        if( typemethod != 'sft' && typemethod.length != 0){

            $("#paymentMethodLogo").find("img#sft").hide();
            $("#paymentMethodLogo2").find("img#sft").hide();
            $(".finance-description").find('p#sft').hide();
            $(".finance-description2").find('p#sft').hide();

        }


        $(".imgclslogo").hide();
        $(".imgclslogo2").hide();
        $(".imgclsdtl").show();
        $(".fdsc").show();
        $(".paymentforidr").hide();
        $("#submit_bonus").removeAttr("disabled");
        $(".paymentforidr").css('border-top', '1px solid #eaeaea');
        $(".paymentforidr").css('padding-top', '20px');
       // $("option[value='ddcc']").attr('selected','selected');
    //   $('#select-deposit-logo option[value="sft"]').attr('selected','selected');

        carListShowFromMyAccount();// check is come form my-account

        $(".pDescription").hide();
        $(".defaultDes").show();

        $(".pDescription2").hide();
        $(".defaultDes2").show();

        $("input:radio").attr("checked", false);
        $(".btn_class_disable").attr("disabled","disabled"); //FXPP-8220

        <?php if (FXPP::isNewMtGroup()) { ?>
        $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/20-percent-bonus.png" class="img-responsive show-img"/>');
        <?php }else{?>
        $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive show-img"/>');
        <?php } ?>

      //mobile

        if($('#bonusType2').val() == 'twpb'){
            $('.twenty-percent-panel-mobile').show();
            $('#agree_checkbox_20_mobile').prop('checked', true);

            var mobile_def_amount = $('#set_amount2').val();
            $("#amount2").val(parseFloat(mobile_def_amount * 0.20)  + parseFloat(mobile_def_amount));

        }else{
            $('.twenty-percent-panel-mobile').hide();
        }

        if($('#bonusType2').val() == 'tpb') {
            var mobile_def_amount = $('#set_amount2').val();
            $("#amount2").val(parseFloat(mobile_def_amount * 0.30)  + parseFloat(mobile_def_amount));
        }

        var $t1 = $('#t1');
        var $t2 = $('#t2');
        var $t3 = $('#t3');
        var $t4 = $('#t4');

        var ta1 = [$t2, $t3, $t4];
        var ta2 = [$t1, $t3, $t4];
        var ta3 = [$t2, $t1, $t4];
        var ta4 = [$t2, $t1, $t3];
        $("#t1").click(function(){
            $("#t1").addClass("acct-active");
            $.each(ta1, function(){
                $(this).removeClass("acct-active");
            });
        });
        $("#t2").click(function(){
            $("#t2").addClass("acct-active");
            $.each(ta2, function(){
                $(this).removeClass("acct-active");
            });
        });
        $("#t3").click(function(){
            $("#t3").addClass("acct-active");
            $.each(ta3, function(){
                $(this).removeClass("acct-active");
            });
        });
        $("#t4").click(function(){
            $("#t4").addClass("acct-active");
            $.each(ta4, function(){
                $(this).removeClass("acct-active");
            });
        });

        $("#owl-demo").owlCarousel({
            items : 4,
            lazyLoad : true,
            navigation : true
        });

        $('.twenty-percent-panel').hide();

        $("select[name=bonus_type]").on("change", function() {
            if($(this).val() == 'twpb'){
                console.log('twenty');
                $('.twenty-percent-panel').show();
                $('#agree_checkbox_20').prop('checked', true);

            }else{
                $('.twenty-percent-panel').hide();
                $('#agree_checkbox_20').prop('checked', false);

            }
        });

        $("#lastBox").on('change', function() {
            if ($(this).is(':checked')) {
                $('.twenty-percent-panel').show();
                $('#agree_checkbox_20').prop('checked', true);
            } else {
                $('.twenty-percent-panel').hide();
                $('#agree_checkbox_20').prop('checked', false);
            }
        });


        $("select[name=bonus_type]").on("change", function() {
            if($(this).val() == 'twpb'){
                console.log('twenty');
                $('.twenty-percent-panel').show();
                $('#agree_checkbox_20').prop('checked', true);

            }else{
                $('.twenty-percent-panel').hide();
                $('#agree_checkbox_20').prop('checked', false);

            }
        });

    });


    $("#amount").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    $(document).on('click', '.other_ckbox', function(){
        if($(this).is(':checked')){
            var value = $("#amount").val();
            var parcent = percent_calculation(value);
            var total = parseFloat(parseFloat(value)+parseFloat(parcent));
            $("#set_amount").val(total);
           // get_total_bal();
            $(".radio_id").attr('id', total);
        }
        else{
            var value = $("#amount").val();

            $("#set_amount").val(value);
            $(".radio_id").attr('id', value);
          //  get_total_bal();
        }
    });

    var url = '';
    var val = '';
    var amount2='';

    $(document).on('change', '#select-deposit-logo', function(){
        var id = $(this).val();
        $(".imgclslogo").hide();
        $(".finance-image-rep #"+id).show();
        $(".pDescription").hide();
        $(".finance-description #"+id).show();
        if(id == 'idr' || id == 'myr' || id == 'btc' || id == 'ldbtc'){
            $(".fdsc").hide();
            $(".paymentforidr").show();
            $("#submit_bonus").removeAttr("disabled");
            if(id=='idr'){
                var btc_bonus_type = $('#btcBonusType').val();

               if(btc_bonus_type == 'twpb'){
                    $(".show-btc-img").remove();
                    $("#btcCheck").after('<img src="<?= $this->template->Images()?>/20-percent-bonus.png" id="chk-active" class="show-btc-img"/> <img src="<?= $this->template->Images()?>/20-percent-bonus-inactive.png" style="display:none" id="chk-deactive" class="show-btc-img"/>');
                    $('#text-bonus-btc-30').hide();
                    $('#text-bonus-btc-20').show();
                } else{
                    $(".show-btc-img").remove();
                    $("#btcCheck").after('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" id="chk-active" class="show-btc-img"/> <img src="<?= $this->template->Images()?>/30-percent-bonus-inactive.png" style="display:none" id="chk-deactive" class="show-btc-img"/>');
                   $('#text-bonus-btc-20').hide();
                   $('#text-bonus-btc-30').show();
                }
            }
        }
        else{
            $(".fdsc").show();
            $(".paymentforidr").hide();

            $(".btn_class_disable").attr("disabled","disabled"); //FXPP-8220
            $("input:radio").attr("checked", false);
            $(".ckbox_class").prop("checked", true);
            $(".other_ckbox").prop("checked", true);

            $("#amount").attr("disabled","disabled");
            $("#set_amount").val('');
           // get_total_bal();
            $(".show-img").hide();
            $(".img-other").hide();

            var bonus_type = $('#bonusType').val();
            console.log(bonus_type);
            if(bonus_type == 'fpb') {
                $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/50-percent-bonus.png" class="img-responsive show-img"/>');
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/50-percent-bonus.png" class="img-responsive img-other"/>');
                $('.twenty-percent-panel').hide();
            }
            else if(bonus_type == 'rhpb') {
                $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive show-img"/>');
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive img-other"/>');
                $('.twenty-percent-panel').hide();
            }
            else if(bonus_type == 'twpb') {
                $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/20-percent-bonus.png" class="img-responsive show-img"/>');
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/20-percent-bonus.png" class="img-responsive img-other"/>');
                $('.twenty-percent-panel').show();
            }
            else{
                $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive show-img"/>');
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive img-other"/>');
                $('.twenty-percent-panel').hide();
            }
        }
    });



    $(document).on('click', '.radio_class', function(){
        $(".btn_class_disable").removeAttr('disabled'); //FXPP-8220
        $('.radio_class').removeAttr('id');

        var value = $(this).val();
        var pct = percent_calculation(value);
        var radio_id = parseFloat(parseFloat(value)+parseFloat(pct));
        var text = $(this).closest('tr').find('td').eq(3).text();
        var re = text.replace('$ ','');
        // var radio_id = $(text).contains('$').remove();?
        $(this).attr('id',re);
        $('#set_amount').val(re);
       // get_total_bal();
    });

    $(document).on("click",'.ckbox_class',function(){

        $(this).closest('tr').find('.radio_class').removeAttr('id');
        //console.log("test");
        var val = $(this).closest('tr').find('.radio_class').val();
        var currencysign = '<?=$currency2;?>';

        if($(this).is(':checked')){
            $(this).closest('tr').find('.img-responsive').hide();
            var txt_amount = parseInt(parseInt(val)+percent_calculation(val));

            $(this).closest('tr').find('td').eq(3).html(currencysign + ' ' + txt_amount.toLocaleString());
            var bonus_type = $('#bonusType').val();
            if(bonus_type == 'fpb') {
                $(this).after('<img src="<?= $this->template->Images()?>/50-percent-bonus.png" class="img-responsive show-img"/>');
            }
            else if(bonus_type == 'rhpb') {
               $(this).after('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive show-img"/>');
             }
            else if(bonus_type == 'twpb') {
                $(this).after('<img src="<?= $this->template->Images()?>/20-percent-bonus.png" class="img-responsive show-img"/>');
            }
            else{
                $(this).after('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive show-img"/>');
            }
            var ckval = parseInt(parseInt(val)+ percent_calculation(val));
            $(this).closest('tr').find('.radio_class').attr('id',ckval);

            //radio_click_val = parseInt(parseInt(val)+ percent_calculation(val));

        }else{
            $(this).closest('tr').find('.img-responsive').hide();
            var txt_amount = parseInt(parseInt(val));

            $(this).closest('tr').find('td').eq(3).html(currencysign + ' ' + txt_amount.toLocaleString());
            var bonus_type = $('#bonusType').val();
            if(bonus_type == 'fpb') {
                $(this).after('<img src="<?= $this->template->Images()?>/50-percent-bonus-inactive.png" class="img-responsive show-img"/>');
            }
            else if(bonus_type == 'rhpb') {
              $(this).after('<img src="<?= $this->template->Images()?>/100-percent-bonus-inactive.png" class="img-responsive show-img"/>');
             }
            else if(bonus_type == 'twpb') {
                $(this).after('<img src="<?= $this->template->Images()?>/20-percent-bonus-inactive.png" class="img-responsive show-img"/>');
            }
            else{
                $(this).after('<img src="<?= $this->template->Images()?>/30-percent-bonus-inactive.png" class="img-responsive show-img"/>');
            }
            var ckval = parseInt(val);
            $(this).closest('tr').find('.radio_class').attr('id',ckval);
        }
        /* FXPP-6333 */
        if($(this).closest('tr').find('.radio_class').is(':checked')) {
            var ckval = $(this).closest('tr').find('.radio_class').attr('id');
            $('#set_amount').val(ckval);
           // get_total_bal();
        }
        /* FXPP-6333 */
    });

    $(document).on('click', '.other_ckbox', function(){
        if($(this).is(':checked')){
            $(".img-other").hide();
            var bonus_type = $('#bonusType').val();
            if(bonus_type == 'fpb') {
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/50-percent-bonus.png" class="img-responsive img-other"/>');
            }
            else if(bonus_type == 'rhpb') {
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive img-other"/>');
            }
            else if(bonus_type == 'twpb') {
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/20-percent-bonus.png" class="img-responsive img-other"/>');
            }
            else{
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive img-other"/>');
            }
        } else {
            $(".img-other").hide();
            var bonus_type = $('#bonusType').val();
            if(bonus_type == 'fpb') {
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/50-percent-bonus-inactive.png" class="img-responsive img-other"/>');
            }
            else if(bonus_type == 'rhpb') {
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/100-percent-bonus-inactive.png" class="img-responsive img-other"/>');
             }
            else if(bonus_type == 'twpb') {
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/20-percent-bonus-inactive.png" class="img-responsive img-other"/>');
            }
            else{
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/30-percent-bonus-inactive.png" class="img-responsive img-other"/>');
            }
        }
    });


    $(document).on('click', '.other_ckbox2', function(){
        if($(this).is(':checked')){
            $(".img-other2").hide();
            var bonus_type = $('#bonusType').val();
            if(bonus_type == 'fpb') {
                $("#img_show_percent2").append('<img src="<?= $this->template->Images()?>/50-percent-bonus.png" class="img-responsive img-other2" style="display: inline-block;"/>');
            }
           else if(bonus_type == 'rhpb') {
                 $("#img_show_percent2").append('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive img-other2" style="display: inline-block;"/>');
             }
            else if(bonus_type == 'twpb') {
                $("#img_show_percent2").append('<img src="<?= $this->template->Images()?>/20-percent-bonus.png" class="img-responsive img-other2" style="display: inline-block;"/>');
            }
            else
            {
                $("#img_show_percent2").append('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive img-other2" style="display: inline-block;"/>');
            }
            var value = $("#set_amount2").val();
            console.log(value);
            var parcent = percent_calculation(value);
            var total = parseFloat(parseFloat(value)+parseFloat(parcent));
            $("#amount2").val(total);
        } else {
            $("#amount2").val($("#set_amount2").val());
            $(".img-other2").hide();
            var bonus_type = $('#bonusType').val();
            if(bonus_type == 'fpb') {
                $("#img_show_percent2").append('<img src="<?= $this->template->Images()?>/50-percent-bonus-inactive.png" class="img-responsive img-other2" style="display: inline-block;"/>');
            }
            else if(bonus_type == 'rhpb') {
                    $("#img_show_percent2").append('<img src="<?= $this->template->Images()?>/100-percent-bonus-inactive.png" class="img-responsive img-other2" style="display: inline-block;"/>');
             }
            else if(bonus_type == 'twpb') {
                $("#img_show_percent2").append('<img src="<?= $this->template->Images()?>/20-percent-bonus-inactive.png" class="img-responsive img-other2" style="display: inline-block;"/>');
            }
            else{
                $("#img_show_percent2").append('<img src="<?= $this->template->Images()?>/30-percent-bonus-inactive.png" class="img-responsive img-other2" style="display: inline-block;"/>');
            }
        }
    });

    $(document).on('change', '.radio_class', function(){
        if($(".radio_id").is(':checked')){
            $("#amount").removeAttr('disabled');
        }
        else{
            $("#amount").attr('disabled', 'disabled');
        }
    });

    $(document).on('click', '.radio_id', function(){
        $('.btn_class_disable').attr('disabled', 'disabled');  //FXPP-8220
    });



    $(document).on("keyup","#amount",function(){

        var value = $(this).val();
        if(value.length > 0){
            $('.btn_class_disable').removeAttr('disabled');
        }
        else
        {
            $('.btn_class_disable').attr('disabled', 'disabled'); // FXPP-8220
        }

        var parcent = percent_calculation(value);
        var total = parseFloat(parseFloat(value)+parseFloat(parcent));

        if(isNaN(parseInt(value))){
            $("#set_amount").val('');
           // get_total_bal();
        }
        else{
            if($('.other_ckbox').is(':checked')){
                $("#set_amount").val(total);
                $(".radio_id").attr('id', value);
               // get_total_bal();
            }
            else{
                $("#set_amount").val(value);
                $(".radio_id").attr('id', value);
               // get_total_bal();
            }
        }
    });


    $(document).on('change', '#select-deposit-logo2', function(){
        var id = $(this).val();
        url = id;
        console.log(url);
        $(".imgclslogo2").hide();
        $(".finance-image-rep2 #"+id).show();
        $(".pDescription2").hide();
        $(".finance-description2 #"+id).show();

        if(id == 'idr' || id == 'myr' || id == 'btc'){
            $(".fdsc").hide();

            $("#submit_bonus").hide();
            $(".paymentforidr").hide();
            $(".local-bank-content").hide();
        }
        else{
            $(".fdsc").show();
            $(".paymentforidr").hide();

//            $(".btn_class_disable").attr("disabled","disabled"); FXPP-8220
            $("input:radio").attr("checked", false);
            $(".ckbox_class").prop("checked", true);
            $(".other_ckbox").prop("checked", true);

            $("#amount").attr("disabled","disabled");
            $("#set_amount").val('');
           // get_total_bal();
            $(".show-img").hide();
            $(".img-other").hide();

            var bonus_type = $('#bonusType').val();
            if(bonus_type == 'fpb'){
                $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/50-percent-bonus.png" class="img-responsive show-img"/>');
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/50-percent-bonus.png" class="img-responsive img-other"/>');
            }
            else if(bonus_type == 'rhpb') {

                $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive show-img"/>');
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive img-other"/>');
            }
            else if(bonus_type == 'twpb') {

                $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/20-percent-bonus.png" class="img-responsive show-img"/>');
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/20-percent-bonus.png" class="img-responsive img-other"/>');
            }
            else{
                $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive show-img"/>');
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive img-other"/>');
            }
        }
    });


    $(document).on('change', '#financetable', function(){

        var id = $(this).val();

        amount2=id;

            <?php if(FXPP::isAccountFromEUCountry()){ ?>
                var bonus_type = 'none';
            <?php }else{ ?>
               var bonus_type = $('#bonusType2').val();
            <?php } ?>


        if (amount2 == 'OtherAmount') {

            $(".set_amount2Div").show();

            $("#set_amount2").removeAttr("disabled");
            $("#set_amount2").val('');
            $("#amount2").val('');
        }else{

            $(".set_amount2Div").hide();

            $(".set_amount2").attr("disabled","disabled");
            if(bonus_type == 'fpb') {
                var get = amount2 * 50 / 100;
            }else if(bonus_type == 'none'){
                var get = 0;
            }
            else if(bonus_type == 'twpb'){
                var get = amount2 * 20 / 100;
            }else{
                var get= amount2*30/100;
            }
            var get2=  Number(get)+Number(amount2);


            $("#amount2").val(get2);
            $("#set_amount2").val(amount2);
        }
    });
     $('.twenty-percent-panel-mobile').hide();
    $(document).on("change",'#bonusType2',function(){

        <?php if(FXPP::isAccountFromEUCountry()){ ?>
            var bonus_type = 'none';
        <?php }else{ ?>
           var bonus_type = $('#bonusType2').val();
        <?php } ?>


        var id = $(".finval").val();
        var amt = 0;
        var  amount2=id;
        var otheramount = id;
        if (otheramount == 'OtherAmount'){
            amount2 = parseInt($("#set_amount2").val());
            if(isNaN(amount2)){amount2=0; }

        }else{
            amount2 = parseInt(id);
        }


        if(bonus_type == 'fpb'){
             amt= amount2*50/100;
        }else if(bonus_type == 'none'){
             amt= 0;
        }
        else if(bonus_type == 'twpb'){
            amt = amount2*20/100;
        }else{
            amt = amount2*30/100;
        }
        var get2=  amt+amount2;

        console.log(amt);
        $("#amount2").val(get2);
        $("#set_amount2").val(amount2);
        if (otheramount == 'OtherAmount') {
            $("#set_amount2").removeAttr("disabled");

        }else{
            $(".set_amount2").attr("disabled","disabled");
        }

        if($(this).val() == 'twpb'){
            console.log('twenty');
            $('.twenty-percent-panel-mobile').show();
            $('#agree_checkbox_20_mobile').prop('checked', true);

        }else{
            $('.twenty-percent-panel-mobile').hide();
            $('#agree_checkbox_20_mobile').prop('checked', false);

        }
    });

    $(document).on("keyup","#set_amount2",function(){
        var id = $(this).val();
        amount2=id;
        var get = 0;

        var bonus_type = '';

            <?php if(FXPP::isAccountFromEUCountry()){ ?>
              bonus_type = 'none';
            <?php }else{ ?>
             bonus_type = $('#bonusType2').val();
            <?php } ?>
        console.log(bonus_type);

            if(bonus_type == 'fpb'){
                get= amount2*50/100;
            }else if(bonus_type == 'none'){
                get= 0;
            }
            else if(bonus_type == 'twpb'){
                get= amount2*20/100;
            }else{
                get= amount2*30/100;
            }

        var get2=  Number(get)+Number(amount2);
        $("#amount2").val(get2);

    });

    $(document).on('click', '#submit_bonus', function(e){

        var myLength = $("#select-deposit-logo").val().length;
        var amount1 = '';
        var amount = '';

        if(myLength == 0){
            val = url;
        }else{
            val = $("#select-deposit-logo").val();
            console.log('val = else = ');
            console.log(val);
        }

        var bonustype = '';
        var bonus_type = $('#bonusType').val();

        if($('.radio_id').attr('id') != ''){
            amount1 = $('.radio_id').attr('id');
        }

        $("#financetable tbody tr").each(function(){
            if($(this).find('.radio_class').is(':checked'))
            {
                $('.radio_id').removeAttr('id');
                amount1 = $(this).find('.radio_class').attr('value');
                if($(this).find('.ckbox_class').is(':checked')){
                    if(bonus_type == 'fpb'){
                        bonustype = '?bonus=fpb';
                    }
                    else if(bonus_type == 'twpb'){
                        bonustype = '?bonus=twpb';
                    }
                    else if(bonus_type == 'rhpb'){    
                        bonustype = '?bonus=rhpb'; 
                   }
                    else{
                        bonustype = '?bonus=tpb';
                    }
                }
            }
        });

        if(amount1 == undefined ){
            if(amount2 == ''){
                amount = $("#set_amount2").val();
            }else{
                amount = amount2;
                console.log('this 2 amount ');
            }

        }else{
            amount = amount1;
        }

        if($(".lastRadiobutton").is(':checked'))
        {
            if($("#lastBox").is(':checked'))
            {
                if(bonus_type == 'fpb'){
                    bonustype = '?bonus=fpb';
                }
                else if(bonus_type == 'rhpb'){
                 bonustype = '?bonus=rhpb';
                }
                else if(bonus_type == 'twpb'){
                    bonustype = '?bonus=twpb';

                    if(!$("#agree_checkbox_20").is(':checked')) {
                        e.preventDefault();
                        $('.bonus-alert-message').html('<?= lang('trd_266');?>');
                        $('#modalBonusAlert').modal('show');
                        return false;
                    }

                }
                else{
                    bonustype = '?bonus=tpb';
                }
            }
            console.log('lastRadiobutton');
        }

        var bonusAtive=0;
        if(val == 'idr' || val == 'myr' || val == 'btc'){
            amount = '0';
            if($("#btcCheck").is(':checked')){
                bonusAtive = 1;
                bonus_type = $('#btcBonusType').val();
                if(bonus_type == 'fpb') {
                    bonustype = '?bonus=fpb';
                }else if(bonus_type == 'none') {
                    bonustype = '';
                }
                else if(bonus_type == 'twpb') {
                    bonustype = '?bonus=twpb';
                }else{
                    bonustype = '?bonus=tpb';
                }
            }
        }

        var getRedirectUrl = $("#select-deposit-logo option:selected").data('url');

        url = getRedirectUrl + bonustype;

        console.log(url+"testing");

        $("#limited").attr('action',url);
        $("#limited").attr('method','POST');
        $('#amount1').val(amount);

        if($(".lastRadiobutton").is(':checked')) {
            if($("#lastBox").is(':checked')) {
                bonusAtive=1;
            }
        }

        if(bonusAtive==0){
            $("#financetable tr").each(function(){
                if($(this).find('.radio_class').is(':checked')){
                    if($(this).find('.ckbox_class').is(':checked')){
                        bonusAtive=1;
                    }
                }
            });
        }

        $('#bounusfiled').val(bonusAtive);

        console.log(bonusAtive);


        <?php
        if($isSupporter){?>
        $('.bonus-alert-message').html('Deposit is not allowed in this supporter account. You can only make deposits to your other accounts that is not a supporter account');
        $('#modalBonusAlert').modal('show');
        return false;
        <?php }?>



        <?php if(!$IsStandardAccount && $loginType <> 1 ){?>
        if (bonusAtive == 1 && bonustype == '?bonus=fpb') {
            $('.bonus-alert-message').html('<?=lang('dpst_msg9_50');?>');
            $('#modalBonusAlert').modal('show');
            return false;
        }
        <?php }
        ?>

        console.log('<?=$bonus_selection?>');
        console.log(bonus_type);


        <?php if($bonus_selection == 'ndb'){ ?>
        if(bonusAtive == 1) {
            $('.bonus-alert-message').html('<?=lang('dpst_msg1');?>');
            $('#modalBonusAlert').modal('show');
        }
        <?php }elseif($bonus_selection == 'hdb'){ ?>
        $('#limited').submit();
        <?php }elseif($bonus_selection == 'tpb'){ ?>

            if(!isNewAccountType) {
                if (bonus_type == 'twpb') {
                    $('#limited').submit();
                    return true;
                }
            }


        <?php } ?>
        if(bonus_type != '<?=$bonus_selection?>'){
            if(bonusAtive == 1) {

                $('.bonus-alert-message').html('<?=lang('dpst_msg1');?>');
                $('#modalBonusAlert').modal('show');

            }else{
                $('#limited').submit();
            }
        }else{
            $('#limited').submit();
        }

        console.log(bonusAtive);

        if(bonusAtive !=1){
            $('#limited').submit();
        }
          console.log('submit123');
    });


    $(document).on('touchstart click', '#submit_bonus2', function(e){
        //alert('test alert');
        var amount1 = '';
        var amount = '';
       var bonusAtive = 1;
        var url = '';

       var val = $("#select-deposit-logo2").val();
        $('#bounusfiled').val(bonusAtive);

//        var bonus_type = $('#bonusType2').val();

        <?php if(FXPP::isAccountFromEUCountry()){ ?>
           var bonus_type = 'none';
        <?php }else{ ?>
           var bonus_type = $('#bonusType2').val();
        <?php } ?>


        if(bonus_type == 'twpb'){
            if (!$('#agree_checkbox_20_mobile').is(':checked')) {
                e.preventDefault();
                $('.bonus-alert-message').html('<?= lang('trd_266');?>');
                $('#modalBonusAlert').modal('show');
                return false;
            }
        }




        if($('.radio_id').attr('id') != ''){
            amount1 = $('.radio_id').attr('id');
        }

        $("#financetable tbody tr").each(function(){
            if($(this).find('.radio_class').is(':checked'))
            {
                $('.radio_id').removeAttr('id');
                amount1 = $(this).find('.radio_class').attr('value');
            }
        });


        if(amount1 == undefined ){
            if(amount2 == ''){
                amount = $("#set_amount2").val();
            }else{
                amount = amount2;
                console.log('this 2 amount ');
            }

        }else{
            amount = amount1;
        }

        if(val == 'idr'){
            url="<?= FXPP::loc_url('deposit/bank-transfer-idr'); ?>";
        }
        if(val == 'myr'){
            url="<?= FXPP::loc_url('deposit/bank-transfer-myr'); ?>";
        }
        if(val == 'bt'){
            url="<?= FXPP::loc_url('deposit/bank-transfer'); ?>";
        }
        if(val == 'ddcc'){
            url="<?= FXPP::loc_url('deposit/debit-credit-cards'); ?>";
        }
        if(val == 'skl'){
            url="<?= FXPP::loc_url('deposit/skrill'); ?>";
        }
        if(val == 'ntl'){
            url="<?= FXPP::loc_url('deposit/neteller'); ?>";
        }
        if(val == 'pxm'){
            url="<?= FXPP::loc_url('deposit/paxum'); ?>";
        }
        if(val == 'ppl'){
            url="<?= FXPP::loc_url('deposit/paypal'); ?>";
        }
        if(val == 'web'){
            url="<?= FXPP::loc_url('deposit/webmoney'); ?>";
        }
        if(val == 'pco'){
            url="<?= FXPP::loc_url('deposit/payco'); ?>";
        }
        if(val == 'qwi'){
            url="<?= FXPP::loc_url('deposit/qiwi'); ?>";
        }
        if(val == 'mgt'){
            url="<?= FXPP::loc_url('deposit/megatransfer'); ?>";
        }
        if(val == 'btc'){
            url="<?= FXPP::loc_url('deposit/cryptocurrency'); ?>";
            amount = '0';
        }
        if(val == 'ynx'){
            url="<?= FXPP::loc_url('deposit/yandex'); ?>";
        }
        if(val == 'mtr'){
            url="<?= FXPP::loc_url('deposit/moneta'); ?>";
        }
        if(val == 'sft'){
            url="<?= FXPP::loc_url('deposit/sofort'); ?>";
        }
        if(val == 'hwt'){
            url="<?= FXPP::loc_url('deposit/hipay'); ?>";
        }
        if(val == 'fasapay2'){
            url="<?= FXPP::loc_url('deposit/fasapay'); ?>";
        }
        if(val == 'payoma2'){
            url="<?= FXPP::loc_url('deposit/payoma'); ?>";
        }
        if(val == 'inp'){
            url="<?= FXPP::loc_url('deposit/inpay'); ?>";
        }
        if(val == 'ldmyr'){
            url="<?= FXPP::loc_url('deposit/local-depositor-myr'); ?>";
        }
        if(val == 'thb'){
            url="<?= FXPP::loc_url('deposit/bank-transfer-thb'); ?>";
        }
<!--        if(val == 'pmts'){-->
<!--            url="--><?//= FXPP::loc_url('deposit/payments'); ?><!--";-->
<!--        }-->
<!--        if(val == 'pmil'){-->
<!--            url="--><?//= FXPP::loc_url('deposit/paymill'); ?><!--";-->
<!--        }-->

        if(bonus_type == 'fpb') {
            bonustype = '?bonus=fpb';
        }
        else if(bonus_type == 'rhpb') {
           bonustype = '?bonus=rhpb';
        }
        else if(bonus_type == 'twpb') {
            bonustype = '?bonus=twpb';
        }
        else if(bonus_type == 'none') {
           bonustype = '';
        } else{
           bonustype = '?bonus=tpb';
        }

        url = url + bonustype;
console.log(url);

        $("#limited").attr('action',url);
        $("#limited").attr('method','POST');

        $('#amount1').val(amount);
        console.log('val = ');
        console.log(val);
        console.log('url = ');
        console.log(url);
        console.log('amount = ');
        console.log(amount);
        console.log('<?=$bonus_selection?>');


        <?php
//         if(IPLoc::Office()){
         if($isSupporter){?>


        $('.bonus-alert-message').html('<?= lang('trd_267');?>');
        $('#modalBonusAlert').modal('show');
        return false;


        <?php }?>

        if(bonus_type == 'none'){
            $('#limited').submit();
        }else{

            console.log(isNewAccountType);
            <?php if(FXPP::isAccountFromEUCountry()){ ?>
            bonusAtive = 0;
            <?php } else { ?>
            <?php if($bonus_selection == 'ndb'){ ?>
            bonusAtive = 0;
            if (bonusAtive == 1) {
                $('.bonus-alert-message').html('<?=lang('dpst_msg1');?>');
                $('#modalBonusAlert').modal('show');
            }
            <?php }elseif($bonus_selection == 'hdb'){ ?>
            $('#limited').submit();
               return true;
            <?php }elseif($bonus_selection == 'tpb'){ ?>


            if(!isNewAccountType) {
                if (bonus_type == 'twpb') {
                    $('#limited').submit();
                    return true;
                }
            }

            <?php } ?>
            if (bonus_type != '<?=$bonus_selection?>') {
                if (bonusAtive == 1) {
                    $('.bonus-alert-message').html('<?=lang('dpst_msg1');?>');
                    $('#modalBonusAlert').modal('show');
                } else {
                    $('#limited').submit();
                }
            } else {
                $('#limited').submit();
            }
            <?php
            }?>

            if(bonusAtive !=1){
                $('#limited').submit();
            }

        }



    });

    $(document).on('change', '#bonusType', function(){
        var bonus_type = $('#bonusType').val();
        var value = $('#amount').val();
        var currencysign = '<?=$currency;?>';

        $(".ckbox_class").prop("checked", true);
        $(".other_ckbox").prop("checked", true);

        $("#financetable tbody tr").each(function(){
            var val = $(this).find('.radio_class').val();
            $(this).find('.img-responsive').hide();
            var txt_amount = parseInt(parseInt(val)+percent_calculation(val));
            $(this).find('td').eq(3).html(currencysign + ' ' + txt_amount.toLocaleString());
            var bonus_type = $('#bonusType').val();
            if(bonus_type == 'fpb') {
                $(this).after('<img src="<?= $this->template->Images()?>/50-percent-bonus.png" class="img-responsive show-img"/>');
            }
            else if(bonus_type == 'rhpb') {
                $(this).after('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive show-img"/>');
            }
            else if(bonus_type == 'twpb') {
                $(this).after('<img src="<?= $this->template->Images()?>/20-percent-bonus.png" class="img-responsive show-img"/>');
            }
            else{
                $(this).after('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive show-img"/>');
            }
            var ckval = parseInt(parseInt(val)+ percent_calculation(val));
            $(this).find('.radio_class').attr('id',ckval);
        });

        if($(".lastRadiobutton").is(':checked')) {
            if (value.length > 0) {
                $('.btn_class_disable').removeAttr('disabled');
            } else {
                $('.btn_class_disable').attr('disabled', 'disabled'); //FXPP-8220
            }
        }

        var parcent = percent_calculation(value);
        var total = parseFloat(parseFloat(value)+parseFloat(parcent));

        if(isNaN(parseInt(value))){
            $("#set_amount").val('');
            //get_total_bal();
        }
        else{
            if($('.other_ckbox').is(':checked')){
                $("#set_amount").val(total);
                $(".radio_id").attr('id', value);
               // get_total_bal();
            }
            else{
                $("#set_amount").val(value);
                $(".radio_id").attr('id', value);
               // get_total_bal();
            }
        }

        if(bonus_type == 'fpb'){
            $(".show-img").remove();
            $(".img-other").remove();
            $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/50-percent-bonus.png" class="img-responsive show-img"/>');
            $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/50-percent-bonus.png" class="img-responsive img-other"/>');
        }
         else if(bonus_type == 'rhpb') {        
            $(".show-img").remove();
            $(".img-other").remove();
            $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive show-img"/>');
            $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive img-other"/>');
        }
        else if(bonus_type == 'twpb') {
            $(".show-img").remove();
            $(".img-other").remove();
            $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/20-percent-bonus.png" class="img-responsive show-img"/>');
            $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/20-percent-bonus.png" class="img-responsive img-other"/>');
        }
        else{
            $(".show-img").remove();
            $(".img-other").remove();
            $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive show-img"/>');
            $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive img-other"/>');
        }
    });

    $(document).on('change', '#btcBonusType', function(){
        var bonus_type = $('#btcBonusType').val();

        if(bonus_type == 'fpb'){
            $(".show-btc-img").remove();
            $("#btcCheck").after('<img src="<?= $this->template->Images()?>/50-percent-bonus.png" id="chk-active" class="show-btc-img"/> <img src="<?= $this->template->Images()?>/50-percent-bonus-inactive.png" style="display:none" id="chk-deactive" class="show-btc-img"/>');
        }
        else if(bonus_type == 'twpb'){
            $(".show-btc-img").remove();
            $("#btcCheck").after('<img src="<?= $this->template->Images()?>/20-percent-bonus.png" id="chk-active" class="show-btc-img"/> <img src="<?= $this->template->Images()?>/20-percent-bonus-inactive.png" style="display:none" id="chk-deactive" class="show-btc-img"/>');
            $('#text-bonus-btc-30').hide();
            $('#text-bonus-btc-20').show();
        }
        else{
            $(".show-btc-img").remove();
            $("#btcCheck").after('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" id="chk-active" class="show-btc-img"/> <img src="<?= $this->template->Images()?>/30-percent-bonus-inactive.png" style="display:none" id="chk-deactive" class="show-btc-img"/>');
            $('#text-bonus-btc-20').hide();
            $('#text-bonus-btc-30').show();
        }
    });

    function percent_calculation(value){
        var bonus_type = $('#bonusType').val();
        var result;
        if(bonus_type == 'fpb') {
            result = parseFloat(value) * 50 / 100;
        }
        else if(bonus_type == 'twpb') {
            result = parseFloat(value) * 20 / 100;
        }
         else if(bonus_type == 'rhpb') {
             result = parseFloat(value) * 100 / 100;
        }
        else{
            result = parseFloat(value) * 30 / 100;
        }
        return result;
    }
</script>
<?php //if(IPLoc::Office()){ ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.4/numeral.min.js"></script>
    <script type="text/javascript">
        function get_total_bal(){
            $(".check-deposit-unverified").hide();
            var set_amount = $("#set_amount").val();
            var bal = "<?=$total_balance?>";
            var total_bal =  parseFloat(set_amount.replace(/,/g, '')) + parseFloat(bal);
            if(parseFloat(total_bal)>=2000){
                var total = numeral(set_amount).format('0,0.00');
                var diff =  parseFloat(total_bal) - parseFloat('2000');
                diff = numeral(diff).format('0,0.00');
                if(parseFloat(diff)==0){ var desc = "reached the allowed amount of deposit."; }else{ var desc = "exceeded/reached the allowed amount of deposit by "+diff+" <?=$cur_base;?>";}
                var msg = "You have "+desc+". Please verify your account <a href='<?=FXPP::my_url('profile/upload-documents')?>'>here</a> ."
                $("#check-balance-unverified").html(msg);
                $(".check-deposit-unverified").show();
                console.log(total_bal);
            }
            console.log("testing FXPP-6768");
        }
    </script>
<?php //} ?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".chk").prop("checked", true);
        $('.chk').click(function(){
            if($('.chk').is(':checked')){
                $('#chk-active').show();
                $('#chk-deactive').hide();
                // alert('1');
            }else{
                $('#chk-deactive').show();
                $('#chk-active').hide();
                // alert('2');
            }
        });

    });
</script>
<?php if( FXPP::html_url() == 'de'){ ?>
<script type="text/javascript">
$(document).ready(function(){
       var url = document.URL;
        var urlx=url.substr(url.lastIndexOf('/') + 1) 
        if(urlx.toLowerCase().indexOf("?card=debit-credit")>= 0)
        {
               $('#select-deposit-logo option[value="ddcc"]').attr('selected','selected');
                $('#select-deposit-logo option[value="sft"]').removeAttr('selected');
                $('.finance-image-rep img').css('display','none');
                $('img#ddcc').css('display','block');
                $('.finance-description p').css('display','none');
                $('p#ddcc').css('display','block');
            
        }else{
    
    $('#select-deposit-logo option[value="sft"]').attr('selected','selected');
    $('#select-deposit-logo option[value="ddcc"]').removeAttr('selected');
    $('.finance-image-rep img').css('display','none');
    $('img#sft').css('display','block');
    $('.finance-description p').css('display','none');
    $('p#sft').css('display','block');
    }
});
    
</script>
<?php } ?>
