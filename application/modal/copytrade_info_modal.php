<div id="cpy_modal"  tabindex="-1" class="modal-custom modal-center modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document" style=" position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%) !important;">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <img src="<?= $this->template->Images()?>img-info-modal.png" class="img-center img-info-modal">
            </div>
            <div class="modal-body">
                <p id="m_message" class="text-center"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-form" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>