<style>
    .checkmodal{
        z-index: 10000;
        padding: 0px !important;
    }
    .checkmodal-content{
        top: 50%;
        width: 100%;
    }
    .checkmodal-modal-dialog{
        top: 20%;
    }
    .check-btn-explore{
        margin-top: 0px!important;
        padding: 10px 30px;
    }
    .check-p{
        text-align: center;
    }
    .check-modal-body{
        padding: 26px 65px 10px 65px;
    }
    .check-mrgntp{
        margin-top:60px;
    }
    .check-h3{
        font-weight: bold;
        font-family: times;
        text-align: center;
        margin-bottom: 20px;
    }
    .check-ps{
        font-size: 16px;
        text-align: center;
    }

    a.vrfy:hover{
        color: #FFF;
        text-decoration: none;
    }
    a.vrfy:link{
        color: #FFF;
        text-decoration: none;
    }
    a.vrfy:visited{
        color: #FFF;
        text-decoration: none;
    }
    a.vrfy:active{
        color: #FFF;
        text-decoration: none;
    }

</style>

<div class="checkmodal modal fade" id="NDBsuccess" tabindex="=-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="checkmodal-modal-dialog modal-dialog round-0 ">
        <div  class="checkmodal-content  modal-content round-0 ">
            <div class="check-modal-body modal-body">
                <h3 class="check-h3"> <?=lang('dpst_msg_ndb');?></h3>
                <?php /*
                <p class="check-ps">Your application has been processed and your (<?=$bonus?> USD) bonus has been credited to your account. </p>
                */ ?>
                <p class="check-ps"><?=lang('dpst_msg13');?></p>
                <p class="check-p check-mrgntp">
                    <button class="check-btn-explore btn-explore" class="close" data-dismiss="modal" aria-label="Close"><?=lang('dpst_msg_but');?></button>
                </p>
            </div>

        </div>
    </div>
</div>


<div class="checkmodal modal fade" id="NDBfailed" tabindex="=-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="checkmodal-modal-dialog modal-dialog round-0 ">
        <div  class="checkmodal-content  modal-content round-0 ">
            <div class="check-modal-body modal-body">
                <h3 class="check-h3"><?=lang('dpst_msg_ndb');?></h3>
                <p class="check-ps"><?=lang('dpst_msg14');?><a href="<?= $this->config->item('domain-www');?>/contact-us" target="_blank">support</a>.</p>
                <p class="check-p check-mrgntp">
                    <a href="<?= $this->config->item('domain-my');?>/profile/upload-documents" class="check-btn-explore btn-explore vrfy"><?=lang('dpst_msg14_a');?></a>
                    <button class="check-btn-explore btn-explore" class="close" data-dismiss="modal" aria-label="Close"><?=lang('dpst_msg_but');?></button>
                </p>
            </div>

        </div>
    </div>
</div>

<div class="checkmodal modal fade" id="NDBdone" tabindex="=-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="checkmodal-modal-dialog modal-dialog round-0 ">
        <div  class="checkmodal-content  modal-content round-0 ">
            <div class="check-modal-body modal-body">
                <h3 class="check-h3"><?=lang('dpst_msg_ndb');?></h3>
                <p class="check-ps"><?=lang('dpst_msg15');?></p>
                <p class="check-p check-mrgntp">
                    <button class="check-btn-explore btn-explore" class="close" data-dismiss="modal" aria-label="Close"><?=lang('dpst_msg_but');?></button>
                </p>
            </div>

        </div>
    </div>
</div>

<div class="checkmodal modal fade" id="NDBstandardaccountOnly" tabindex="=-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="checkmodal-modal-dialog modal-dialog round-0 ">
        <div  class="checkmodal-content  modal-content round-0 ">
            <div class="check-modal-body modal-body">
                <h3 class="check-h3"><?=lang('dpst_msg_ndb');?></h3>
                <p class="check-ps"><?=lang('dpst_msg5');?></p>
                <p class="check-p check-mrgntp">
                    <button class="check-btn-explore btn-explore" class="close" data-dismiss="modal" aria-label="Close"><?=lang('dpst_msg_but');?></button>
                </p>
            </div>

        </div>
    </div>
</div>

<div class="checkmodal modal fade" id="NDBLeverage200Only" tabindex="=-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="checkmodal-modal-dialog modal-dialog round-0 ">
        <div  class="checkmodal-content  modal-content round-0 ">
            <div class="check-modal-body modal-body">
                <h3 class="check-h3"><?=lang('dpst_msg_ndb');?></h3>
<!--                <p class="check-ps">Applicable only for Leverage 1:1 1:2 1:3 1:5 1:10 1:20 1:25 1:33 1:50 1:66 1:88 1:100 and 1:200</p>-->
                <p class="check-ps"><?=lang('dpst_msg16');?></p>
                <p class="check-p check-mrgntp">
                    <button class="check-btn-explore btn-explore" class="close" data-dismiss="modal" aria-label="Close"><?=lang('dpst_msg_but');?></button>
                </p>
            </div>

        </div>
    </div>
</div>


<div class="checkmodal modal fade" id="OneAccountOnly" tabindex="=-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="checkmodal-modal-dialog modal-dialog round-0 ">
        <div  class="checkmodal-content  modal-content round-0 ">
            <div class="check-modal-body modal-body">
                <h3 class="check-h3"><?=lang('dpst_msg_ndb');?></h3>
                <p class="check-ps"><?=lang('dpst_msg17');?></p>
                <p class="check-p check-mrgntp">
                    <button class="check-btn-explore btn-explore" class="close" data-dismiss="modal" aria-label="Close"><?=lang('dpst_msg_but');?></button>
                </p>
            </div>

        </div>
    </div>
</div>
