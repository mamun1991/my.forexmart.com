
<?php $this->lang->load('mdl_editswapfree');?>
<!-- modal -->
<div class="modal fade" id="modaleditswap" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button"  id ="swap-dismiss" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modal-show-title">
                    <?=lang('esf_0');?>
<!--                    Edit Swap Free-->
                </h4>
            </div>
            <div class="modal-body modal-show-body">
                <div class="row">
                    <div class="col-md-12">
                        <p class="edit-swap-text"></p>
                        <p>
                        <p class="swap-free-agree" style="display: none">
                            I declare that I have carefully read and fully understood the entire text of the  <a href="https://www.forexmart.com/assets/pdf/Tradomart-SV/Swap-Free%20Trading%20Account%20Agreement.pdf" class="company" target="_blank">Swap-Free Trading Account Agreement</a>
                            with which I fully understand, accept, and agree.
                        </p>
                        <?=lang('esf_1');?>

<!--                            Do you want to continue?-->
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer round-0">
                <button type="button" id="cancel_swap" class="btn-green-default">
                    <?=lang('esf_3');?>
<!--                    No-->
                </button>
                <button type="button" id="update_swap" class="btn-green">
                    <?=lang('esf_2');?>
<!--                    Yes-->
                </button>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->