<?php $this->view('mail_support/nav'); ?>
<style>
    #textContent{
        width:100%!important;
    }
    #compose-form {
        display: block;
    }
    .alert {
        display: none;

    }
    .add-compose-holder:lang(sa) {
        text-align: left !important;
    }
    .attach {
        padding: 3px 24px;
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
<div class="tab-content acct-cont">
    <div class="row" id="compose-form">
        <form action="<?php base_url('mail_support/compose') ?>"  method="post" enctype="multipart/form-data" id="mailForm">
            <div class="col-md-11 col-centered compose-text-holder">
                <div class="alert alert-success col-sm-12" role="alert" style="margin-bottom: 0; padding: 10px;<?= $message; ?>;" ><b><?= lang('ms_02'); ?>!</b> <?= lang('ms_03'); ?></div>
                <div class="col-sm-8">
                    <input name="subject" class="form-control round -0 compose-text" placeholder="Subject" type="text" style="margin-bottom: 15px;" required value="<?= set_value('subject'); ?>">
                    <span class="req"><?= form_error('subject')?> </span>
                </div>
                <div class="col-sm-4">
                    <select required name="email" id="selectEmail" class="form-control round -0 compose-text" style="margin-bottom: 15px;">
                        <option value=""><?= lang('ms_05'); ?></option>
                        <?php foreach ($contact_emails as $value) { ?>
                            <option value="<?= $value['id']; ?>" <?php echo set_select('email', $value['id']); ?>><?= $value['email'] ?></option>
                        <?php } ?>
                    </select>
                    <span class="req"><?= form_error('subject')?> </span>
                </div>
                <div class="col-sm-12">
                    <textarea name="textContent" id="textContent" value="<?= set_value('textContent'); ?>"></textarea>
                    <span class="req" id="textcontent_error"><?= form_error('textContent')?> </span>
                </div>
                <?php $this->load->library('IPLoc', null);
                if(IPLoc::Office()){ ?>
                    <div class="col-sm-12 attach-holder" style="text-align: left; margin-bottom: 5px; padding-left: 0;">
                        <i style="color: #29A643; vertical-align: middle; margin: 5px 0; padding-left: 15px; float: left;" id="tip_note" class="tooltip-upload-docs glyphicon glyphicon-question-sign" data-original-title="" title=""></i>
                        <div class="col-sm-2">
                            <span class="btn btn-success fileinput-button attach">
                                <span><i class="glyphicon glyphicon-plus"></i> Add</span>
                                <input type="button" name="add_file" id="add_file" class="form-control">
                            </span>
                        </div>
                        <div class="col-sm-9">
                            <!-- The global progress bar -->
                            <div id="progress" class="progress" style="padding:0; margin-top: 5px;">
                                <div class="progress-bar progress-bar-success progress-bar-striped" id="progress-bar">
                                    <span id="width"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 files" id="files"></div>
                <?php } else { ?>
                    <div class="col-sm-6 attach-holder">
                        <span class="btn btn-success fileinput-button attach">
                            <span><i class="fa fa-paperclip clip"></i></span>
                            <input type="file" name="fileupload" class="form-control">
                        </span>
                    </div>
                <?php } ?>
                <?php if(IPLoc::Office()){ ?>
                    <div class="col-sm-12 add-compose-holder">
                        <button type="submit" class="btn-add" id="submitButton" ><?= lang('ms_04'); ?></button>
                    </div>
                <?php } else { ?>
                    <div class="col-sm-6 add-compose-holder">
                        <button type="submit" class="btn-add"><?= lang('ms_04'); ?></button>
                    </div>
                <?php } ?>
                <input type="hidden" name="id[]" id="image_id" value="<?= set_value('id'); ?>">
            </div>
        </form>
    </div>
</div>

    <div id="cpy_modal"  tabindex="-1" class="modal-custom modal-center modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document" style="
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
">
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

<script type="text/javascript">
    var progressbar = $('#progress');
    var divFiles = $('#files');
    var uploaded = 0;
    var image_id = [];
    var url = '<?= base_url()?>';

    $(function () {
        progressbar.hide();
        $('#tip_note').tooltip({title: "<p align='left' style='padding: 5px !important;'><?=lang('ms_24')?></p>", html: true, placement: "<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>"});

        $('#add_file').click(function () {

            $('#submitButton').prop('disabled',true);

            var inputProp = {
                type:   'file',
                name:   'fileupload[]',
                accept: 'image/x-png, image/png, image/jpg, image/jpeg, application/pdf'
            };
            var input = $('<div/>')
                .addClass('col-sm-9')
                .append(
                $('<input/>')
                    .addClass('form-control input-sm')
                    .prop(inputProp)
                );
            var trashStyle = {
                cursor: 'pointer',
                textAlign: 'right'
            };
            var removeInput =  $('<a/>')
                .addClass('col-xs-2 col-sm-1 input-sm')
                .attr('onclick', 'javascript: removeInput($(this));')
                .css(trashStyle)
                .append(
                $('<i/>')
                    .addClass('glyphicon glyphicon-trash')
                );
            var uploadStyle = {
                paddingTop: '15px',
                paddingBottom: '15px'
            };
            var uploadInput = $('<div/>')
                .addClass('col-sm-8')
                .css(uploadStyle)
                .append(
                    $('<div/>')
                        .addClass('col-sm-2')
                        .append(
                            $('<button/>')
                                .addClass('btn btn-success btn-sm')
                                .attr('type', 'button')
                                .attr('onclick', 'javascript: sendFile();')
                                .text('Upload')
                        )
                )
                .append(
                    $('<span/>')
                        .addClass('col-sm-6 upload-label')
                        .css({'font-size':'13px','padding-left':'10px','color':'#929292','padding-top':'7px'})
                        .text('Please upload first before sending.')
                );

            $('.upload-label').show();

            var node = $('<p/>')
                .addClass('col-sm-12');


            if (divFiles[0].childElementCount == 0) {
                uploadInput.appendTo($('#files'));
            }
            if (divFiles[0].childElementCount < 4) {
                divFiles.find('button').show();
                node.append(removeInput).append(input);
                node.appendTo($('#files'));
            }
        });
    });

    function sendFile() {
        var $this = $('input[name="fileupload[]"]');
        var noFile = 0;

        $.each($this, function (index1, file1) {
            if (file1.files.length == 0) {
                noFile++;
            }
            if (noFile >= 3) {
                alert('Please select at least one (1) image.');
            } else if (noFile == 0) {
                progressbar.show();
                $.each(file1.files, function (index2, file2) {
                    var form_data = new FormData();
                    form_data.append('fileupload', file2);
                    uploaded++;

                    $.ajax({
                        type: "POST",
                        url: url+"mail_support/uploadMailImage",
                        data: form_data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        xhr: function () {
                            var xhr = $.ajaxSettings.xhr();
                            var progress_bar = $('#progress-bar');

                            if (xhr.upload) {
                                xhr.upload.addEventListener('progress', function (e) {
                                    progress_bar.addClass('progress-bar-success');
                                    progress_bar.removeClass('progress-bar-danger');

                                    if (e.lengthComputable) {
                                        var percentComplete = (e.loaded / e.total) * 100;
                                        $('div.progress > div.progress-bar').css({ "width": percentComplete + '%' });
                                        $('#width').text(Math.round(percentComplete) + '%');
                                    }
                                }, false);
                                xhr.upload.addEventListener("load", function (e) {
                                    divFiles.find('button').hide();
                                    divFiles.find('span').hide();
                                });
                                xhr.upload.addEventListener("error", function (e) {
                                    progress_bar.removeClass('progress-bar-success');
                                    progress_bar.addClass('progress-bar-danger');
                                    $('#width').text('There was an error on uploading image(s). Please try again.');
                                });
                            }
                            return xhr;
                        },
                        success: function (data) {
                            console.log(data);
                            var json = $.parseJSON(data);
                            var input = $(file1);
                            var parent = $(input[0].parentElement)[0].parentElement;
                            var cancel_prop = {
                                dataToggle: 'tooltip',
                                title:  'Delete uploaded image'
                            };
                            var cancel_upload = $('<a/>')
                                .addClass('col-xs-2 col-sm-1 input-sm')
                                .attr('onclick', 'cancelUpload($(this), "' + json.hashed_file + '", "' + json.id + '")')
                                .prop(cancel_prop)
                                .css('cursor', 'pointer')
                                .append(
                                $('<i/>')
                                    .addClass('glyphicon glyphicon-remove')
                            );
                            var file_name = $('<i/>').text(json.file_name);
                            var file_size = $('<span/>').text(' (' + json.file_size + ')');
//
                            console.log(json);
                            image_id.push(json.id);
                            $('#image_id').val(image_id);

                            $(parent).empty();

                            cancel_upload.appendTo(parent);
                            file_name.appendTo(parent);
                            file_size.appendTo(parent);

                            $('#submitButton').prop('disabled',false);
                        }
                    });
                });
            }
        });
    }

    function cancelUpload(element, image_name, id) {
        var input;
        var numCreatedElement = divFiles[0].childElementCount;

        uploaded--;
        $.ajax({
            url: url+"mail-support/delete_mail_image_uploaded/" + image_name,
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (numCreatedElement <= 2) {
                    var progress_bar = $('#progress-bar');
                    progress_bar.parent().hide();
                    divFiles.find('span').hide();
                    $('div.progress > div.progress-bar').css({ "width": '0px' });
                }
                element.parent().remove();
                console.log(data);
            }
        });
        // Remove id from input hidden
        input = image_id.indexOf(parseInt(id));
        if (input != -1) {
            image_id.splice(input, 1);
            $('#image_id').val(image_id);
        }
    }

    function removeInput(element) {
        var numCreatedElement = divFiles[0].childElementCount;

        if (numCreatedElement <= 2) {
            divFiles.find('button').hide();
            divFiles.find('span').hide();
            $('#submitButton').prop('disabled',false);
        }
        element.parent().remove();
    }

    $(document).ready(function () {
        $(".alert-success").delay(300).addClass("in").fadeOut(8000);
        //var isEmpty = $('#textContent').summernote('isEmpty');

        $('.compose').bind( "click", function() {
            $('.compose').css("display","none")
        });
        $('.cancel-compose').bind( "click", function() {
            $('.compose').css("display","block");
            $('#compose-form').css("display","none");
        });
        $('#textContent').summernote({
            height: 375
        });

        $(document).on("click", ".open-compose", function () {
            $('textarea#textContent').text('');
            $('input[name=subject]').val('');
            $("select[name=reply_to]").val('');
            $('#textContent').summernote('reset');
            $("#compose-form").show();
        });

        $('#submitButton').on("click", function (e) {
            var isEmpty = $('#textContent').summernote('isEmpty');
            if ($('#subject').val() == "" || $('#selectEmail').val() == "") {
                    $('#m_message').html('Please complete subject, email or message fields.');
                    $('#cpy_modal').modal('show');

                $('#textcontent_error').show();
            } else if (!isEmpty) {
                $('#mailForm').submit();
            } else {
                $('#m_message').html('Please complete subject, email or message fields.');
                $('#cpy_modal').modal('show');
                var text_error = $('#textcontent_error');
                text_error.text('Message is required and cannot be empty');
                text_error.show();
                $('#textContent').focus();
                e.preventDefault();
            }
        });
    });
</script>