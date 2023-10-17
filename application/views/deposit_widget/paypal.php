<div class="col-lg-3 col-md-3 ">
    <div class="bankdep-holder arabic-bankdep-holder">
        <a href="<?= FXPP::loc_url('deposit/paypal');?>"><img src="<?= $this->template->Images()?>paypal.png" class="paypalimage img-reponsive" width="120px"></a>
        <p class="bankdep-text">
            <?= lang('paypal_desc');?>
            <br/>
            <a href="<?= FXPP::loc_url('deposit/paypal');?>">
                <?= lang('dpp_desc');?>
            </a>
        </p>
    </div>
</div>