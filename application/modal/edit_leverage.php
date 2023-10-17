<!-- modal -->
<style>
    .bg2865{
        min-height: 0px!important;
    }
</style>
<div class="modal fade" id="modaleditleverage" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modal-show-title"></h4>
            </div>
            <div class="modal-body modal-show-body bg2865 bg">
                <div class="row">
                    <div class="col-md-12">
                        <p class="edit-leverage-text"> <span id="leverage_from"></span> <span id="to"> </span>  <span id="leverage_to"></span></p>
                        <p id="want-changes"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer round-0">
                <button type="button" id="cancel_leverage" class="btn-green-default"></button>
                <button type="button" id="update_leverage" class="btn-green"></button>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->
<script>
    var translations='<?= json_encode(FXPP::getTranslations());?>';
    data = JSON.parse(translations)

    $(".modal-header .modal-show-title").html(data.edit_leverage)
    $(".modal-body .edit-leverage-text").html(data.about_leverage)
    $("#to").html(data.to)
    $("#want-changes").html(data.want_changes)
    $("#cancel_leverage").html(data.no)
    $("#update_leverage").html(data.yes)
</script>