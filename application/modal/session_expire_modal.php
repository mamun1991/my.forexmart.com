
<div class="modal fade" id="session_expire_modal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?=lang('session_01');?></h4>
            </div>
            <div class="modal-body">
                <p><?=lang('session_02');?></p>
                <p><?=lang('session_03');?> <span class="timeoutT" id="timeout">(0)</span>.</p>
            </div>
            <div class="modal-footer">
<!--                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeModal()">YES</button>-->
                <button type="button" class="btn btn-primary" onclick="closeModal()"><?=lang('session_04');?></button>
                <button type="button" class="btn btn-default" onclick="sessionLogout()"><?=lang('session_05');?></button>
            </div>
        </div>
    </div>
</div>



