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
    <h1><?= lang('trd_44'); ?></h1>
    <ol class="breadcrumb internal-breadcrumb">
        <li><a href="<?= FXPP::loc_url('withdraw');?>"><?= lang('trd_22'); ?></a></li>
        <li><a href="<?= FXPP::loc_url('withdraw');?>"><?= lang('trd_23'); ?></a></li>
        <li class="active"><?= lang('trd_45'); ?></li>
    </ol>

        <div class="debit-credit-row">

            <div class="debit-col">
                <div class="debit-credit-holder">
                    <img src="<?= $this->template->Images() ?>inpay_icon.png" class="img-reponsive" style="height: 51px;">
                    <p><?= lang('trd_46'); ?></p>

                    <a id="submit_bonus"  href="<?= FXPP::loc_url('withdraw/inpay');?>"> <?= lang('trd_26'); ?></a>

                </div>
            </div>
        </div>

    <div class="clearfix"></div>
</div>



