<style type="text/css">
    .account-number {
        font-weight: bold;
    }

    .btn-make-deposit {
        background: #29A643 none repeat scroll 0% 0%;
        color: #FFF;
        padding: 10px 10px;
        border: medium none;
        transition: all 0.3s ease 0s;
        margin: 2px;
    }
    #modalBonusNoDepositAlert .modal-footer {
        text-align: center;
    }
	
</style>

<div class="modal fade" id="modalBonusNoDepositAlert" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center modal-show-title" id="modalBonusNoDepositAlertTitle">
                    <?=lang('dpst_msg_30');?>
                </h4>
            </div>
            <div class="modal-body modal-show-body">
                <div class="text-center tpb-body">
                    <p><?=lang('dpst_msg10');?> <span class="account-number"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="center-block">
                    
                    <?php if (FXPP::html_url() == 'en') {
                        $urlLang=  'deposit';
                    }else{
                        $urlLang=  FXPP::html_url().'/deposit';
                    }?>

                    <a href="<?php echo base_url($urlLang) ?>" id="btnMakeDeposit" class="btn-make-deposit"><?=lang('dpst_msg10_a');?></a>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalBonusNoDepositAlert_fifty" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center modal-show-title" id="modalBonusNoDepositAlertTitle">
                    <?=lang('dpst_msg_50');?>
                </h4>
            </div>
            <div class="modal-body modal-show-body">
                <div class="text-center" id="message-body"> <?=lang('dpst_msg11');?></div>
            </div>
            <div class="modal-footer">
                <div class="center-block">
                    <a href="<?php echo base_url('deposit') ?>" id="btnMakeDeposit" class="btn-make-deposit"> <?=lang('dpst_msg10_a');?></a>
                </div>
            </div>
        </div>
    </div>
</div>