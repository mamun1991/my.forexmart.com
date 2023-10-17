<div class="col-lg-3 col-md-3 ">
    <div class="bankdep-holder arabic-bankdep-holder">
        <a href="<?= FXPP::loc_url('deposit/megatransfer');?>"><img src="<?= $this->template->Images()?>megatransferlogo_fordeposit.png" class="img-reponsive"  style="color: red; height: 25px; width: 164px;"></a>
        <p class="bankdep-text">
            <?= lang('MegaTransfer_desc');?>
            <br/>
            <a href="<?= FXPP::loc_url('deposit/megatransfer');?>">
                <?= lang('dmt_desc');?>
            </a>
        </p>
    </div>
</div>