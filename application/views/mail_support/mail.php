<?php
$this->view('mail_support/nav');
$date_created = new DateTime($info['date_created']);
?>

<style>
    .table-responsive {
        overflow-x: visible;
    }
    .nondisplay {
        display: none;
    }
    .image-container {
        width: 80%;
        margin: auto;
    }
    #img {
        width: 100%;
        padding: 0 15px;
    }
    .uploaded-image {
        margin: 15px 0 10px 0;
    }
    .add-compose-holder:lang(sa) {
        text-align: left;
    }
    .attach {
        padding: 3px 24px;
    }
    .attach-holder {
        text-align: left;
    }
    .attach-holder:lang(sa) {
        text-align: right;
    }
</style>

<div class="tab-content acct-cont">
    <div class="col-sm-12">
        <h1 class="pull-left" style="margin-top: 10px"><?= $info['subject'] ?></h1>
        <h6 class="pull-right" style="margin-bottom: 0;margin-top: 20px;color: #999;"><?= lang('ms_25') . ': <b>' . $info['id'] . '</b>'; ?> | <?= lang('ms_17') . ': <b>' . $date_created->format('d M Y H:i A') . '</b>'; ?></h6>
        <span class="clearfix"></span>
    </div>
    <div class="table-responsive">
        <table class="table table-striped arabic-table-mail">
            <tbody>
            <?php foreach ($details as $value) {
                $date_posted = new DateTime($value['date_updated']);
                ?>
                <tr style="border-bottom: 1px solid #DDD;">
                    <td class="col-sm-4"><h5 style="margin-bottom: 3px;"><b><?= $value['user_type'] != 'Trader' ? ($value['user_type'] == 'All Department Support' ? 'General Support' : $value['user_type']) : $value['sender']; ?></b></h5><h6 style="color: #999;margin-top: 0;"><?= lang('ms_19') . ': ' . $date_posted->format('d M Y H:i A'); ?></h6></td>
                    <td class="col-sm-8" style="color: #666666;padding-top: 17px;">
                        <?= $value['message'] ?>
                        <div class="uploaded-image">
                            <?php foreach ($images as $row) {
                                if ($value['id'] == $row['mail_thread_id']) { ?>
                                    <div class="uploaded-image">
                                        <a data-toggle="modal" class="glyphicon glyphicon-picture" href="#open-modal" onclick="getFileSrc('<?= $row['image_hashed_name'] ?>')"> <i><?= $row['image_name'] ?></i></a>
                                    </div>
                                <?php }
                            }
                            ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <form action="<?= base_url('mail_support/updateMail') .'/'. $info['id'] ?>"  method="post" enctype="multipart/form-data" id="mailForm">
            <div id="compose-form" <?= $enable; ?>>
                <div class="col-sm-2"><?= lang('ms_20'); ?>:</div>
                <div class="col-sm-10" style="margin-bottom: 10px;">
                    <textarea name="textContent" id="textContent" ></textarea>
                    <span class="req" id="textcontent_error"><?= form_error('textContent')?> </span>
                </div>
                <div class="col-sm-2"><?= lang('ms_21'); ?>:</div>
                <div class="col-sm-2">
                    <span class="btn btn-success fileinput-button attach">
                        <span><i class="glyphicon glyphicon-plus"></i> Add</span>
                        <input type="button" name="add_file" id="add_file" class="form-control">
                    </span>
                </div>
                <div class="col-sm-7">
                    <!-- The global progress bar -->
                    <div id="progress" class="progress" style="padding:0; margin-top: 5px;">
                        <div class="progress-bar progress-bar-success progress-bar-striped" id="progress-bar">
                            <span id="width"></span>
                        </div>
                    </div>
                </div>
                <span class="clearfix"></span>
                <div class="col-sm-10 col-sm-offset-2 files" id="files"></div>
            </div>
            <div class="add-compose-holder">
                <button type="button" class="btn-add" id="reply"><?= lang('ms_18'); ?></button>
                <button type="submit" class="btn-add" id="send" style="display: none;"><?= lang('ms_04'); ?></button>
            </div>
            <input type="hidden" name="id[]" id="image_id" value="<?= set_value('id'); ?>">
        </form>
    </div>
</div>

<!--Modal-->
<div class="modal fade" id="open-modal" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog modal-lg round-0">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btn_close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title-sub"><?=lang('ms_22')?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="image-container"></div>
                </div>
            </div>
            <div class="modal-footer round-0">
                <button type="button" class="btn btn-primary round-0" data-dismiss="modal"><?=lang('ms_23')?></button>
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
                paddingBottom: '15px',
                textAlign: 'right'
            };
            var uploadInput = $('<div/>')
                .addClass('col-sm-2')
                .css(uploadStyle)
                .append(
                $('<button/>')
                    .addClass('btn btn-success btn-sm')
                    .attr('type', 'button')
                    .attr('onclick', 'javascript: sendFile($(this));')
                    .text('Upload')
            );
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

    function sendFile(element) {
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
                                    /*if (uploaded < 3) {
                                     divFiles.find('button').show();
                                     } else {
                                     divFiles.find('button').hide();
                                     }*/
                                    divFiles.find('button').hide();
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
        }
        element.parent().remove();
    }

    function getFileSrc(path) {
        var img = $('<img id="img">');
        var img_loc = '<?= $this->config->item('asset_user_images'); ?>';
        var pdf_loc = '<?= $this->config->item('asset_user_docs'); ?>';
        var get_type = path.split('.');
        var file_type = get_type[get_type.length - 1];

        if (file_type == 'pdf') {
            $('.modal-title-sub').text('View PDF File');
            $('.image-container').html('<label>Please close this pop up.</label>');
            window.open(pdf_loc + path, '_blank');
        } else {
            $('.modal-title-sub').text('<?=lang('ms_22')?>');
            $('.image-container').html(img);
            img.attr('src', img_loc + path);
        }
    }

    $(document).ready(function () {
        $('#textContent').summernote({
            height: 150,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['fullscreen']]
            ]
        });

        $(document).on("click", "#reply", function () {
            $('#compose-form').show();
            $('#send').show();
            $('#reply').hide();
        });

        $('#send').on("click", function (e) {
            var isEmpty = $('#textContent').summernote('isEmpty');
            if (!isEmpty) {
                $('#mailForm').submit();
            } else {
                alert('Please complete message fields.');
                var text_error = $('#textcontent_error');
                text_error.text('Message is required and cannot be empty');
                text_error.show();
                $('#textContent').focus();
                e.preventDefault();
            }
        });
    });
</script>
