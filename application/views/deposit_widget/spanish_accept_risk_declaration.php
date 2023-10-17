<?php
/**
 * Created by PhpStorm.
 * User: Zeta-Jenalie
 * Date: 8/18/2018
 * Time: 4:58 PM
 */
?>

<!---Spanish Accept Risk Declaration Form-->
<div id = "spanish-risk-decs-main" class="form-group spanish-risk-main">
    <div id="spanish-risk-desc-message" class="col-sm-<?=$col_sm?> alert alert-danger" role="alert" style= "margin-left:15%;">

        <?=FXPP::spanishDocumentStatus($this->session->userdata('user_id'))?>

        To enable Deposit page, please sign and upload a copy of the Spanish accept risk declaration form.

        <div class="col-sm-12 border-bottom-line" style="margin-bottom:10px; margin-top:10px;"></div>

        <div class="spanish-risk-links">
            <a href="<?=base_url()."assets/pdf/Spanish Accept risks declaration.pdf"; ?>" data-action="download" class="col-sm-4 spanish-action" download>Download Form <span style="float:right;">|</span></a>
            <a href="javascript:void(0);" data-action="email" class="col-sm-4 spanish-action">Send form to email <span style="float:right;">|</span></a>
            <a href="javascript:void(0);" id="upload-doc" class="col-sm-4">Upload form now</a>
        </div>

        <!---Upload Form-->
        <div class="col-sm-12 border-bottom-line upload-div" style="margin-bottom:10px; margin-top:10px; display:none;"></div>
        <div class="form-group col-sm-12 upload-div" style="display:none; margin-bottom:0px;">
            <input type="file" class="filestyle col-sm-8" id="file" name="file" data-buttonText="Upload">
            <button id="upload" class="btn-submit col-sm-4"><i class="fa fa-upload"></i>Upload</button>
        </div>
        <span class="upload-div" style="float:right; display:none; padding-right:25px;">(only accepts .pdf filetype)</span>
    </div>
</div>

<!---Modal-->
<div id="modal-send-spanish-doc" class="modal fade">
    <div class="modal-dialog modal_dialog_AS" style="width: 400px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">
                    Spanish Accept Risks Declaration
                </h4>
            </div>
            <div class="modal-body">
                <p id="modal-spanish-message"></p>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">

    var FM = "<?php echo FXPP::ajax_url();?>";

    $(".spanish-action").click(function () {

        $(".upload-div").css("display", "none");
        $(".loader-holder").show();

        var actionURL = FM + "deposit/sendSpanishRiskDecPDFtoClient";
        var action = $(this).data("action");
        var message = "";

        $.post(actionURL, {action: action}, function (data) {

            $(".loader-holder").hide();

//                console.log(data);

            message = "Spanish accept risks declaration form has been successfully ";
            message += (action === "download") ? "downloaded." : "sent to your email.";
            message += " After filling out the form, kindly upload a copy by clicking <b>Upload form now</b>.";

            $("#modal-spanish-message").html(message);
            $('#modal-send-spanish-doc').modal('show');

        });

    });

    $("#upload").on('click',(function(e) {
        e.preventDefault();

        var file_data = $('#file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);

        $.ajax({
            type: 'POST',
            url: FM + 'deposit/uploadSpanishDoc',
            dataType: 'json',
            data: form_data,
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false        // To send DOMDocument or non processed data file it is set to false
        }).done(function (response) {

                console.log(response);

            if(response.HasError == false){

                var pendingMsg = "Your form has been successfully sent to our review team. We will get back to "+
                    "you as soon as possible.";

                $("#spanish-risk-desc-message").html(pendingMsg);

            }else{

                $("#modal-spanish-message").html(response.message);
                $('#modal-send-spanish-doc').modal('show');

            }

        });

        return false;

    }));

    $("#upload-doc").click(function () {
        $(".upload-div").css("display", "");
    });
</script>
