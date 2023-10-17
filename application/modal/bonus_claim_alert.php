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
    #modalBonusSupporterAlert{
        text-align: center;
    }
</style>

<div class="modal fade" id="modalBonusClaimAlert" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center modal-show-title" id="modalBonusClaimAlertTitle">
                    <?=lang('dpst_msg_30');?>
                </h4>
            </div>
            <div class="modal-body modal-show-body">
                <div class="text-center">
                    <p><?=lang('dpst_msg7');?></p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalStandardAccountBonus" tabindex="=-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog round-0">
        <div  class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center modal-show-title" id="modalStandardAccountBonusTitle">
                    <?=lang('dpst_msg_30');?>
                </h4>
            </div>
            <div class="modal-body modal-show-body">
                <div class="text-center">
                    <p><?=lang('dpst_msg5');?></p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="center-block">
                    <button class="btn" data-dismiss="modal" aria-label="Close"><?=lang('dpst_msg_but');?></button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalBonusDelayAlert" tabindex="=-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog round-0">
        <div  class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center modal-show-title" id="modalBonusDelayTitle">
                    <?=lang('dpst_msg_30');?>
                </h4>
            </div>
            <div class="modal-body modal-show-body">
                <div class="text-center">
                    <p><?=lang('dpst_msg6');?></p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="center-block">
                    <button class="btn" data-dismiss="modal" aria-label="Close"><?=lang('dpst_msg_but');?></button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalBonusSupporterAlert" tabindex="=-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog round-0">
        <div  class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center modal-show-title" id="modalBonusSupportTitle">

                </h4>
            </div>
            <div class="modal-body modal-show-body supporter_msg_body">
                <div class="text-center">

                </div>
            </div>
            <div class="modal-footer">
                <div class="center-block">
                    <button class="btn" data-dismiss="modal" aria-label="Close"><?=lang('dpst_msg_but');?></button>
                </div>
            </div>
        </div>
    </div>
</div>