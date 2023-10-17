<style type="text/css">
    .btn-register {
        background: #29A643 none repeat scroll 0% 0%;
        color: #FFF;
        padding: 10px 50px;
        border: medium none;
        transition: all 0.3s ease 0s;
        margin: 2px;
    }
    #modalBonusTwentyPercentAlert .modal-footer {
        text-align: center;
    }
</style>

<div class="modal fade" id="modalBonusTwentyPercentAlert" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center modal-show-title">
                    <?=lang('dpst_msg_20');?>
                </h4>
            </div>
            <div class="modal-body modal-show-body">
                <div class="text-center">
                    <p><?=lang('dpst_msg9_20');?></p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="center-block">
                    <a href="<?php echo $this->config->item('domain-www') . '/register'; ?>" class="btn-register"><?=lang('dpst_msg9_20');?></a>
                </div>
            </div>
        </div>
    </div>
</div>