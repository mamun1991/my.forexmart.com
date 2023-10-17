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
$this->load->view('finance_nav.php');
?>
<div class="tab-content acct-cont">
    <div class="section">
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab1">
                <div class="finance-deposit-container">
                    <div class="finance-payment-methods finance-payment-methods-first col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label><?= lang('PaymentMethods');?></label>
                        <select class="form-control" id="select-deposit-logo">

                            <?php if(IPLoc::for_id_only() || FXPP::isIndonesianCountry()){?>
                                <option value="idr" data-url="withdraw/local-depositor-idr"><?= lang('trd_47'); ?> </option>
                                <!-- <option value="paytrust" data-url="withdraw/payTrust">Withdraw via  PayTrust</option> -->
                            <?php }?>

                            <?php if(IPLoc::for_my_only() || FXPP::isMalaysianCountry()){ ?>
                                <option value="myr" data-url="withdraw/bank-transfer-myr"><?= lang('trd_50'); ?></option>
                                <option value="ldmyr" data-url="withdraw/local-depositor-myr"><?= lang('trd_51'); ?></option>
                                <!-- <option value="paytrust" data-url="withdraw/payTrust">Withdraw via  PayTrust</option> -->
                            <?php } ?>

  
                                
                            <option value="ddcc" data-url="withdraw/debit-credit-cards"><?= lang('trd_52'); ?></option>
                            <!-- <option value="bt" data-url="withdraw/bank-wire-transfer">Withdraw via Bank Transfer</option> -->
                            <?php  if(!FXPP::isEUClient()){?>
                            <option value="skl" data-url="withdraw/skrill"><?= lang('trd_53'); ?></option>
                            <option value="ntl" data-url="withdraw/neteller"><?= lang('trd_54'); ?></option>

                            <?php }?>
                            <option value="pco" data-url="withdraw/payco"><?= lang('trd_55'); ?></option>
                            <option value="btc" data-url="withdraw/bitcoin"><?= lang('trd_56'); ?></option>
                           
<!--                            <option value="qwi" data-url="withdraw/qiwi">--><?//= lang('trd_69'); ?><!--</option>-->
                            <option value="fasapay" data-url="withdraw/fasapay"><?= lang('trd_57'); ?></option>
                            <option value="cup" data-url="withdraw/chinaunionpay"><?= lang('trd_58'); ?></option>
                            <option value="alipay" data-url="withdraw/alipay"><?= lang('trd_59'); ?></option>
                           
                           
                              <?php if(IPLoc::for_th_only() || FXPP::isThailandCountry()){ ?>                            
                                <option value="thb" data-url="withdraw/bank-transfer-thb">Withdraw via local bank transfer in THB</option> 
                            <?php } ?>

                        </select>
                    </div>
                    <div class="finance-image-rep col-lg-4 col-md-4 col-sm-4 col-xs-12" id="paymentMethodLogo">
                        <img id="idr" src="<?= $this->template->Images()?>indcard.png" class="img-responsive imgclslogo"/>
                        <img id="ldmyr" src="<?= $this->template->Images()?>myrcard.png" class="img-responsive imgclslogo"/>
                        <img id="myr" src="<?= $this->template->Images()?>myrcard.png" class="img-responsive imgclslogo"/>
                        <img id="thb" src="<?= $this->template->Images()?>thaibanks.png" class="img-responsive imgclslogo"/>
                        <img id="bt" src="<?= $this->template->Images()?>banktransfer.png" class="img-responsive imgclslogo"/>
                        <img id="ddcc" src="<?= $this->template->Images()?>ccard-new.png" class="img-responsive imgclslogo "/>
                        <img id="skl" src="<?= $this->template->Images()?>skrill.png" class="img-responsive imgclslogo"/>
                        <img id="ntl" src="<?= $this->template->Images()?>neteller.png" class="img-responsive imgclslogo"/>
                        <img id="pxm" src="<?= $this->template->Images()?>paxum.png" class="img-responsive imgclslogo"/>
                        <img id="ppl" src="<?= $this->template->Images()?>paypal.png" class="img-responsive imgclslogo"/>
                        <img id="web" src="<?= $this->template->Images()?>webmoney.png" class="img-responsive imgclslogo"/>
                        <img id="pco" src="<?= $this->template->Images()?>payco.png" class="img-responsive imgclslogo"/>
                        <img id="qwi" src="<?= $this->template->Images()?>qiwilogo.png" class="img-responsive imgclslogo"/>
                        <img id="mgt" src="<?= $this->template->Images()?>megatransfer.png" class="img-responsive imgclslogo"/>
                        <img id="btc" src="<?= $this->template->Images()?>bitcoinlogo.png" class="img-responsive imgclslogo"/>
                        <img id="ynx" src="<?= $this->template->Images()?>yandex.png" class="img-responsive imgclslogo"/>
                        <img id="mtr" src="<?= $this->template->Images()?>moneta.png" class="img-responsive imgclslogo"/>
                        <!--<img id="sft" src="<?/*= $this->template->Images()*/?>/sofortlogo.png" class="img-responsive imgclslogo imgclsdtl"/>-->
                        <img id="hwt" src="<?= $this->template->Images()?>hipaywalletlogo.png" class="img-responsive imgclslogo"/>
                        <img id="pmts" src="<?= $this->template->Images()?>epaymentslogo.png" class="img-responsive imgclslogo"/>
                        <img id="pmil" src="<?= $this->template->Images()?>paymilllogo.png" class="img-responsive imgclslogo"/>
                        <img id="fasapay" src="<?= $this->template->Images()?>/fasapay.png" class="img-responsive imgclslogo"/>
                        <img id="payoma" src="<?= $this->template->Images()?>payoma.png" class="img-responsive imgclslogo"/>
                        <img id="accentpay" src="<?= $this->template->Images()?>ecommpay.svg" class="img-responsive imgclslogo"/>
                        <img id="cup" src="<?= $this->template->Images()?>chinaUnionPay.png" class="img-responsive imgclslogo"/>

                        <img id="inp" src="<?= $this->template->Images()?>inpay_icon.png" class="img-responsive imgclslogo"/>
                        <img id="alipay" src="<?= $this->template->Images()?>alipay.png" class="img-responsive imgclslogo"/>
                        <img id="paytrust" src="<?= $this->template->Images()?>banktransfer.png" class="img-responsive imgclslogo"/>

                    </div>
                    <div class="finance-description col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <p id="idr" class="pDescription"><?= lang('idr_desc');?></p>
                        <p id="ldmyr" class="pDescription"><?= lang('trd_60'); ?></p>
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
                        <p id="payoma" class="pDescription"><?= lang('trd_61'); ?></p>
                        <p id="accentpay" class="pDescription"><?= lang('trd_62'); ?></p>
                        <p id="cup" class="pDescription"><?= lang('cup_desc');?></p>
                        <p id="inp" class="pDescription"> <?= lang('trd_63'); ?></p>
                        <p id="alipay" class="pDescription"> <?= lang('trd_64'); ?></p>
                        <p id="paytrust" class="pDescription"><?= lang('trd_65'); ?></p>
                    </div>
                </div>

                <div class="finance-deposit-second-container fdsc">
                    <div class="finance-total-amount col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top: 80px;float:right">
                        <a href=""  class="btn_class_disable btn-withdraw" id="proceed-link"><?=lang('trd_71')?></a>
                    </div>
                </div>

                <!-- START HIDDEN CONTAINER (SHOW WHEN IN MOBILE VERSION) -->
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 main-finance-deposit-container">
                    <div class="finance-deposit-holder">
                        <div class="finance-image-rep2 col-lg-4 col-md-4 col-sm-4 col-xs-12" id="paymentMethodLogo2">
                            <img id="idr"  src="<?= $this->template->Images()?>/indcard.png"          class="img-responsive imgclslogo2 "/>
                            <img id="myr"  src="<?= $this->template->Images()?>/myrcard.png"          class="img-responsive imgclslogo2 "/>
                            <img id="ldmyr" src="<?= $this->template->Images()?>/myrcard.png"         class="img-responsive imgclslogo"/>
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
                            <img id="fasapay" src="<?= $this->template->Images()?>/fasapay.png"      class="img-responsive imgclslogo2 "/>
                            <img id="payoma" src="<?= $this->template->Images()?>/payoma.png"      class="img-responsive imgclslogo2 "/>
                            <img id="cup" src="<?= $this->template->Images()?>/chinaUnionPay.png" class="img-responsive imgclslogo2"/>
                            <img id="inp" src="<?= $this->template->Images()?>/inpay_icon.png" class="img-responsive imgclslogo2"/>

                        </div>

                        <div class="finance-description2 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <p id="idr" class="pDescription2"><?= lang('idr_desc');?></p>
                            <p id="myr" class="pDescription2"><?= lang('myr_desc');?></p>
                            <p id="ldmyr" class="pDescription2"><?= lang('trd_66'); ?></p>
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
                            <p id="fasapay" class="pDescription2"><?= lang('fasapay_desc');?> </p>
                            <p id="payoma" class="pDescription2"><?= lang('trd_67'); ?> </p>
                            <p id="cup" class="pDescription2"><?= lang('cup_desc');?></p>
                            <p id="inp" class="pDescription2"> <?= lang('trd_68'); ?></p>
                        </div>


                        <div class="parent-fin-dep-content">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                                <label><?= lang('PaymentMethods');?></label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">

                                <select class="form-control" id="select-deposit-logo2">

                                    <?php if(IPLoc::for_id_only()  || FXPP::isIndonesianCountry()){?>
                                        <option value="idr" data-url="withdraw/local-depositor-idr"><?= lang('trd_47'); ?></option>
                                    <?php } ?>

                                    <?php if(IPLoc::for_my_only() || FXPP::isMalaysianCountry() ){ ?>
                                        <option value="myr" data-url="withdraw/bank-transfer-myr"><?= lang('trd_50'); ?></option>
                                        <option value="ldmyr" data-url="withdraw/local-depositor-myr"><?= lang('trd_51'); ?></option>
                                    <?php } ?>

                                    <option value="ddcc" data-url="withdraw/debit-credit-cards"><?= lang('trd_52'); ?></option>
                                    <!-- <option value="bt" data-url="withdraw/bank-wire-transfer">Withdraw via Bank Transfer</option> -->
                                    <?php  if(!FXPP::isEUClient()){?>
                                    <option value="skl" data-url="withdraw/skrill"><?= lang('trd_53'); ?></option>
                                    <option value="ntl" data-url="withdraw/neteller"><?= lang('trd_54'); ?></option>
                                    <option value="pco" data-url="withdraw/payco"><?= lang('trd_55'); ?></option>
                                    <option value="btc" data-url="withdraw/bitcoin"><?= lang('trd_56'); ?></option>
                                    <?php  }?>
                                   
<!--                                    <option value="qwi" data-url="withdraw/qiwi">--><?//= lang('trd_69'); ?><!--</option>-->
                                    <option value="fasapay" data-url="withdraw/fasapay"><?= lang('trd_57'); ?></option>
                                    <option value="cup" data-url="withdraw/chinaunionpay"><?= lang('trd_58'); ?></option>

                                    <option value="alipay" data-url="withdraw/alipay"><?= lang('trd_59'); ?></option>

                                    <option value="paytrust" data-url="withdraw/payTrust"><?= lang('trd_70'); ?></option>
                                   
                                </select>
                            </div>
                        </div>
                        <div class="fdsc">
                        </div>
                        <div class="parent-fin-dep-content" style="text-align: center">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input-button">
                                <a href="" id="proceed-link2"><?= lang('trd_71'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END HIDDEN CONTAINER (SHOW WHEN IN MOBILE VERSION) -->
            </div>
        </div>
    </div>
</div>




<?php if(FXPP::fmGroupType($_SESSION['account_number']) == 'ForexMart Pro'){  echo $modal_pro_alert; ?>



 <script type="text/javascript">
        $(document).ready(function(){
            $('.pro-alert-message').html("<?= lang('trd_72'); ?>");
            $('.pro-alert-title').html("<?= lang('trd_73'); ?>");
            $('#modalProAlert').modal('show');
        });
    </script>


<?php } ?>



<script type="text/javascript">
    var newUrl;
    var baseUrl = '<?= FXPP::my_url()?>';
    $(".imgclslogo").hide();
    $(".pDescription").hide();

    //mobile
    $(".pDescription2").hide();
    $(".imgclslogo2").hide();



    <?php if(IPLoc::for_id_only()   || FXPP::isIndonesianCountry() || IPLoc::Office()){?>

        $(".finance-image-rep #idr").show();
        $(".finance-description #idr").show();
        $('#select-deposit-logo option[value="idr"]').attr ('selected','selected');
        newUrl  = $('#select-deposit-logo option[value="idr"]').data('url');
        $('#proceed-link').attr("href",baseUrl + newUrl); // Set herf value


        //mobile
        $(".finance-image-rep2 #idr").show();
        $(".finance-description2 #idr").show();
        $('#select-deposit-logo2 option[value="idr"]').attr ('selected','selected');
        newUrl  = $('#select-deposit-logo2 option[value="idr"]').data('url');
        $('#proceed-link2').attr("href",baseUrl + newUrl); // Set herf value

    <?php }else if(IPLoc::for_my_only() || FXPP::isMalaysianCountry()){ ?>

        $(".finance-image-rep #myr").show();
        $(".finance-description #myr").show();
        $('#select-deposit-logo option[value="myr"]').attr ('selected','selected');
        newUrl  = $('#select-deposit-logo option[value="myr"]').data('url');
        $('#proceed-link').attr("href",baseUrl + newUrl); // Set herf value


        $(".finance-image-rep2 #myr").show();
        $(".finance-description2 #myr").show();
        $('#select-deposit-logo2 option[value="myr"]').attr ('selected','selected');
        newUrl  = $('#select-deposit-logo2 option[value="myr"]').data('url');
        $('#proceed-link2').attr("href",baseUrl + newUrl); // Set herf value

     <?php }else{ ?>

        $(".finance-image-rep #ddcc").show();
        $(".finance-description #ddcc").show();
        $('#select-deposit-logo option[value="ddcc"]').attr ('selected','selected');
        newUrl  = $('#select-deposit-logo option[value="ddcc"]').data('url');
        $('#proceed-link').attr("href",baseUrl + newUrl); // Set herf value

        $(".finance-image-rep2 #ddcc").show();
        $(".finance-description2 #ddcc").show();
        $('#select-deposit-logo2 option[value="ddcc"]').attr ('selected','selected');
        newUrl  = $('#select-deposit-logo2 option[value="ddcc"]').data('url');
        $('#proceed-link2').attr("href",baseUrl + newUrl); // Set herf value

    <?php } ?>

    $(document).on('change', '#select-deposit-logo', function(){
        var id = $(this).val();
        console.log(id);
        $(".imgclslogo").hide();
        $(".finance-image-rep #"+id).show();
        $(".pDescription").hide();
        $(".finance-description #"+id).show();
         newUrl  = $('#select-deposit-logo option[value='+id+']').data('url');
        console.log(newUrl);
        $('#proceed-link').attr("href", baseUrl + newUrl); // Set herf value

    });

    $(document).on('change', '#select-deposit-logo2', function(){
        var id = $(this).val();
        $(".imgclslogo2").hide();
        $(".finance-image-rep2 #"+id).show();
        $(".pDescription2").hide();
        $(".finance-description2 #"+id).show();

        newUrl  = $('#select-deposit-logo2 option[value='+id+']').data('url');
        $('#proceed-link2').attr("href", baseUrl + newUrl); // Set herf value

    });


</script>


