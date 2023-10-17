<?php  $this->lang->load('datatable');?>


<style type="text/css">
    @media screen and (max-width: 767px){
        .col-md-7.col-sm-7.secButton {
            padding-top: 10px;
        }
    }

    /*Modal*/
    .modal-custom{
        /*min-height: 100%;*/
        /*position: absolute;*/
        /*top: 0;*/
        /*width: 100%;*/
        /*left: 0;*/
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
    }
    .modal-custom .modal-content{
        padding: 15px;
        line-height: 1.5;
    }
    .modal-custom .modal-header, .modal-custom .modal-footer{
        border:0;
        padding:0;
    }
    .modal-custom .close{
        /*position: absolute;*/
        top: 10px;
        right: 10px;
        color: red;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 1px solid red;
    }
    .modal-custom .modal-footer{
        text-align:center;
    }
    .img-center{
        display: block;
        margin:0 auto;
    }
    .img-info-modal{
        width:auto;
        height: 86px;
    }
    .btn-form{
        min-width: 150px;
        height:40px;
        letter-spacing: 1px;
    }

</style>





<?php include_once('partnership_nav.php') ?>

<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="commission">
        <div class="row">
            <div class="col-sm-12">
                <p class="part-text">
                </p>
            </div>
        </div>

        <div class="row" style="margin-top: 20px;margin-bottom: 70px;">
            <div class="ref-info col-md-12">
                <h4 class="col-md-offset-1"><?= lang('its_01') ?></h4>
                <div class="col-md-10 col-md-offset-1" style="padding-right: 30px; margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-md-5 col-sm-5">
                        <button class="open-trading" type="button" id="get-code"><?= lang('its_02') ?></button>
                    </div>
                    <div class="col-md-7 col-sm-7 secButton">
                        <input type="text" readonly name="security_code" id="security_code" value="<?=$security_code;?>" class="form-control input-md" placeholder="<?= lang('its_03') ?>" />
                    </div>
                </div>
            </div>
        </div>

        <h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i>
            <?=lang('ddcc_05');?>
        </h1>
        <table class="notes-list">
            <tr class="cb">
                <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
                <td class="r_">
                    <p>
                        <?= lang('its_04') ?>
                    </p>
                </td>
            </tr>
            <tr class="cb">
                <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
                <td class="r_">
                    <p>
                        <?= lang('its_05') ?>
                    </p>
                </td>
            </tr>
            <tr class="cb">
                <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
                <td class="r_">
                    <p>
                        <?= lang('its_06') ?>
                    </p>
                </td>
            </tr>
        </table>
    </div>
</div>

    <div id="its_model"  tabindex="-1" class="modal-custom modal-center modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document" style="
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title text-center"></h4>
                    <img src="<?= $this->template->Images()?>img-info-modal.png" class="img-center img-info-modal">
                </div>
                <div class="modal-body">
                    <p class="text-center manage-text"><?= lang('its_07') ?></p>
                    <p class="text-center message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="modal-close-btn"  class="btn btn-success btn-form" data-dismiss="modal"><?= lang('its_08') ?></button>
                </div>
            </div>
        </div>
    </div>


<script>
    var url = '<?= base_url(); ?>';

    $(document).ready(function () {
        $('#its').click(function () {
            $.ajax({
                type:       'post',
                url:        url+'partnership/affiliate_request',
                dataType:   'json',
                beforeSend: function () {
                    $(".loader-holder").show();
                },
                success: function (data) {
                    $(".loader-holder").hide();
                    $("#its_model").modal('show');
                    $(".its_send").show();
                    $('#its').remove();
                    $('.message').html(data.message);
                }
            });
        });

        $('#get-code').click(function () {
            $.ajax({
                type:       'post',
                url:        url+'partnership/getSecurityCode',
                dataType:   'json',
                beforeSend: function () {
                    $(".loader-holder").show();
                },
                success: function (x) {
                    $(".loader-holder").hide();
                    $('#security_code').val(x.code);
                    if (!x.success) {
                        $("#its_model").modal('show');
//                        $('.modal-header').html('<h1><?//= lang('its_09') ?>//</h1>');
                        $('.modal-title').html('<?= lang('its_09') ?>');
                        $('.manage-text').html('');
                        $('.message').html(x.message);
                    }
                }
            });
        });
    });
</script>