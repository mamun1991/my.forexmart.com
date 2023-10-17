<style>
    .l_{
        float: left;
        width: 20px;
        margin: 1px 10px 0 7px;
    }
    .r_{
        width: 80%;
        float: left;
    }
    .cb{
        clear: both;
    }
    .internal-breadcrumb {
        margin-top: 15px;
        border-radius: 0px;
    }

</style>


        <div class="deposit-cards-holder">
            <h1><?= lang('trd_21'); ?></h1>
            <ol class="breadcrumb internal-breadcrumb">
                <li><a href="<?= FXPP::loc_url('withdraw');?>"><?= lang('trd_22'); ?></a></li>
                <li><a href="<?= FXPP::loc_url('withdraw');?>"><?= lang('trd_23'); ?></a></li>
                <li class="active"><?= lang('trd_24'); ?></li>
            </ol>

                <div class="debit-credit-row">

                    <?php if(IPLoc::Office()){ ?>
                    <!--<div class="debit-col">
                        <div class="debit-credit-holder">
                            <img src="<?//= $this->template->Images()?>emerchantpay.png" class="img-responsive">
                            <p> Online credit card processing provided by eMerchantPay offers merchants highly secure, PCI DSS compliant processing solutions in multiple currencies.</p>

                            <a id="submit_bonus"  href="<?//= FXPP::loc_url('withdraw/emerchantpay');?>"> Withdraw now</a>

                        </div>
                    </div>-->
                    <?php } ?>


                    <!--<div class="debit-col">
                        <div class="debit-credit-holder">
                            <img src="<?//= $this->template->Images()?>megatransfer.png" style="min-height: 80px;" class="img-responsive">
                            <p>Deposit money online conveniently using your credit/debit card with MegaTransfer. As long as you have your card, you can make any transaction possible with MegaTransfer at anytime anywhere.</p>

                            <a id="submit_bonus2"  href="<?//= FXPP::loc_url('withdraw/megatransfer_card').$url;?>"> Withdraw now</a>


                        </div>
                    </div>-->

                </div>
            <?php if(FXPP::isAccountFromEUCountry()){?>
                <div class="debit-credit-row">
                    <div class="debit-col">
                        <div class="debit-credit-holder">
                            <img src="<?= $this->template->Images()?>cardpay.png" class="img-responsive">
                            <p><?= lang('trd_25'); ?></p>

                            <a id="submit_bonus"  href="<?= FXPP::loc_url('withdraw/cardpay');?>"> <?= lang('trd_26'); ?></a>


                        </div>
                    </div>
                </div>
            <?php } ?>
            
            
            
            
            <?php  if(FXPP::isPayomaPayMentAvailable('withdraw')){ ?>
            <div class="debit-credit-row">
                <div class="debit-col">
                    <div class="debit-credit-holder">
                        <img src="<?= $this->template->Images()?>payoma.png" class="img-responsive">
                        <p> <?= lang('trd_27'); ?></p>

                        <a id="submit_bonus"  href="<?= FXPP::loc_url('withdraw/payoma');?>"> <?= lang('trd_23'); ?></a>


                    </div>
                </div>


            </div>
            <?php } ?>
            
            
            
            
            <div class="clearfix"></div>
        </div>



