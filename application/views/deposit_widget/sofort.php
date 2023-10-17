<div class="col-lg-3 col-md-3">
    <div class="bankdep-holder arabic-bankdep-holder">
        <a href="<?= FXPP::loc_url('deposit/sofort');?>"><img src="<?= $this->template->Images()?>sofortlogo.png" class="img-reponsive" width="120px"></a>
        <p class="bankdep-text" style="margin-top: 32px;">
            
            <?= lang('Sofort_desc');?>
            <br/>
            <a href="<?= FXPP::loc_url('deposit/sofort');?>">
                <?= lang('ds_desc');?>
            </a>
        </p>
    </div>
</div>