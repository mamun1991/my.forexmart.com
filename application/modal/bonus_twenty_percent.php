<style type="text/css">
    .account-number {
        font-weight: bold;
    }

    .btn-get-bonus {
        background: #29A643 none repeat scroll 0% 0%;
        color: #FFF;
        padding: 10px 50px;
        border: medium none;
        transition: all 0.3s ease 0s;
        margin: 2px;
    }

    .table-data {
        padding: 5px 40px;
    }

    #tblBonusThirtyPercentDeposit_paginate {
        text-align: right;
    }
</style>
<div class="modal fade" id="bonusTwentyPercent" tabindex="-1"  data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog round-0 ">
        <div  class="modal-content round-0 ">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center modal-show-title">
                    <?=lang('dpst_msg_20');?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row text-center">
                    <p> <?=lang('dpst_msg8');?> <span class="account-number"></span></p>
                </div>
                <div class="row table-responsive table-data">
                    <table class="table" id="tblBonusTwentyPercentDeposit">
                        <thead>
                        <tr>
                            <th style="width:150px;"><?=lang('dpst_msg8_a1');?> </th>
                            <th>Deposit</th>
                            <th><?=lang('dpst_msg8_a3');?></th>
                        </tr>
                        </thead>
                        <tbody id="tblBonusTwentyPercentDepositRows">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div id="hasBonusTwentyPercentDepositLoss" class="row table-responsive table-data" style="display:none">
                    <table class="table" id="tblBonusThirtyPercentDepositLoss">
                        <?php /*
                        <tr>
                            <th>Total Loss</th>
                            <th id="BonusThirtyPercentTotalLoss" style="color: red"></th>
                        </tr>
                        */ ?>
                        <tr>
                            <th><?=lang('dpst_msg8_a4');?></th>
                            <th id="BonusTwentyPercentClaimableAmount"></th>
                        </tr>
                        <tr>
                            <th><?=lang('dpst_msg8_a3');?></th>
                            <th id="BonusTwentyPercentClaimableBonus"></th>
                        </tr>
                    </table>
                </div>
                <div class="row text-center">
                    <p><?=lang('dpst_msg8_a5');?></p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" id="btnGetBonus20" class="btn-get-bonus"><?=lang('dpst_msg8_a6');?></a>
            </div>

        </div>
    </div>
</div>