<?php include_once('profile_nav.php') ?>

<style type="text/css">
    div.upload-docs-holder input[type="file"]{
        display: inline;
    }

    div.docs-id .alert{
        font-size: 12px;
        padding: 5px;
        width: 60%;
        margin-bottom: 10px;
    }
    div.docs-id-back .alert{
        font-size: 12px;
        padding: 5px;
        width: 80%;
        margin-bottom: 10px;
    }

    div.docs-proof .alert{
        margin: 0px auto;
        text-align: justify;
        font-size: 12px;
        padding: 5px;
        width: 34%;
        margin-bottom: 10px;
    }

    div.passport-info{
        width: 100%;
        margin: 10px 0px !important;
    }

    div.desc-cont{
        margin: 15px;
        border: 1.5px solid #B6B6B6;
        font-size: 13px;
    }
    div.desc-cont p{
        font-family: Open Sans;
        padding: 10px;
        font-size: 12px;
        margin: 0px !important;
    }

</style>

<div role="tabpanel" class="tab-pane" id="upload" style="margin-bottom: 20px;">
    <div class="row">
        <div class="col-md-12 upload-docs-holder">
            <h1>How would you like to submit your documents?</h1>
            <div role="tabpanel">upload-documents
                <div class="updocs-tabs" style="border: 1px solid #eee; background: #eee; margin-top: 10px;">
                    <ul>
                        <li><a href="#upl" aria-controls="upl" role="tab" data-toggle="tab" id="up" class="upload-active change-tab"><i class="fa fa-upload i-size"></i> Upload</a></li>
                        <li><a href="#email" aria-controls="email" role="tab" data-toggle="tab" id="em" class="change-tab"><i class="fa fa-envelope i-size"></i> Email</a></li>
                        <li><a href="#mobile" aria-controls="mobile" role="tab" data-toggle="tab" class="change-tab" id="pho"><i class="fa fa-mobile i-size"></i> Mobile Phone</a></li>
                    </ul><div class="clearfix"></div>
                </div>
                <div class="tab-content" style="border: 1px solid #eee;">
                    <div role="tabpanel" class="tab-pane active" id="upl" style="padding: 0 10px;">
                        <div class="options" style="border-bottom: 1px solid #eee;">
                            <div class="col-sm-1">
                                <h1 class="one">1</h1>
                            </div>
                            <div class="col-sm-6 docs-pass" style="padding: 0px !important;">
                                <p class="up-text"><cite class="req">*</cite> Colour copy of passport or the front of the ID <i style="color: blue;" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
<!--                                <div class="alert alert-info ">Upload file. Please wait...</div>-->
                                <div id="front-id" class="docs-id" style="display: <?php echo $checkUserDocsIDfront ? 'block' : 'none' ;?>;"><div class="alert alert-success">A document has already been uploaded.<br/>Click choose to upload again.</div></div>
                                <form method="POST" enctype="multipart/form-data" id="front-id" class="uploadimage">
                                    <input type="hidden" value="0" name="doc_type"/>
                                    <div class="formliststyle-uploadfile">
                                        <input type="file" name="filename" style="width: 210px;">
                                        <span class="docs-passport">
                                            <button type="submit" class="btn fileup btn-success">Upload File</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-5 docs-pass" style="margin-bottom: 15px;">
                                <p class="up-text"><cite class="req">*</cite> Colour copy of the back of the ID <i style="color: blue;" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
<!--                                                            <span class="btn btn-success fileinput-button fileup">-->
<!--                                                                <span><i class="fa fa-download"></i> Browse...</span>-->
                                                                <!-- The file input field used as target for the file upload widget -->
<!--                                                                <input id="fileupload" type="file" name="files[]" multiple>-->
<!--                                                            </span>-->
                                <div id="back-id" class="docs-id-back" style="display: <?php echo $checkUserDocsIDback ? 'block' : 'none' ;?>;"><div class="alert alert-success">A document has already been uploaded.<br/>Click choose to upload again.</div></div>
                                <form method="POST" id="back-id" enctype="multipart/form-data" class="uploadimage">
                                    <input type="hidden" value="1" name="doc_type"/>
                                    <div class="formliststyle-uploadfile">
                                        <input type="file" name="filename" style="width: 210px;">
                                        <span class="docs-passport">
                                            <button type="submit" class="btn fileup btn-success">Upload File</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-10 passport-info" style="margin-bottom: 15px;">
                                <p class="one-text">
                                    Attach a scanned copy of a valid passport, national ID, or driver's license. For national ID or driver's license, both front and back copies must be provided.
                                </p>
                            </div>
                            <div class="col-sm-3">
                                <ul class="requires">
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Your Full Name</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Unique number</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Date and Place of birth</li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul class="requires">
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Photograph</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Signature</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Nationality</li>
                                </ul>
                            </div>
                            <div class="col-sm-3" style="text-align: right;">
                                <img src="<?= $this->template->Images()?>id.png" class="img-responsive" width="150px">
                            </div><div class="clearfix"></div>
                            <p class="last-text">
                                Of course International Passports or National IDs are country specific and the information contained therein varies.<br>
                                Should you have any questions please do not hesitate to <cite class="req" style="font-style: normal;">contact us</cite>.
                            </p>
                        </div>
                        <div class="options" style="border-bottom: 1px solid #eee;">
                            <div class="col-sm-1">
                                <h1 class="one">2</h1>
                            </div>
                            <div class="col-sm-11" style="text-align: center;">
                                <p class="up-text"><cite class="req">*</cite> Proof of Residence <i style="color: blue;" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
<!--                                                            <span class="btn btn-success fileinput-button fileup" style="margin-bottom: 10px;">-->
<!--                                                                <span><i class="fa fa-download"></i> Browse...</span>-->
                                                                <!-- The file input field used as target for the file upload widget -->
<!--                                                                <input id="fileupload" type="file" name="files[]" multiple>-->
<!--                                                            </span>-->
                                <div id="proof-residence" class="docs-proof" style="display: <?php echo $checkUserDocsResidence ? 'block' : 'none' ;?>;"><div class="alert alert-success">A document has already been uploaded.<br/>Click choose to upload again.</div></div>
                                <form method="POST" id="proof-residence" enctype="multipart/form-data" class="uploadimage">
                                    <input type="hidden" value="2" name="doc_type"/>
                                    <div class="formliststyle-uploadfile">
                                        <input type="file" name="filename">
                                        <span class="docs-passport">
                                            <button type="submit" class="btn fileup btn-success">Upload File</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <p class="one-text">
                                Submit a scanned copy of the most recent proof of billing (e.g., utility bill, credit card statement, bank statement, etc.) no later than six months past. The document should include the following details:
                            </p>
                            <div class="col-sm-9">
                                <ul class="requires">
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Name</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Residential Address (street name & number, city and country)</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Date of issue</li>
                                </ul>
                            </div>
                            <div class="col-sm-3" style="text-align: right;">
                                <img src="<?= $this->template->Images()?>bill.png" class="img-responsive" width="100px">
                            </div><div class="clearfix"></div>
                            <p class="last-text">
                                Example of such documents include: water, electricity, gas or telephone bills, bank statement, any letter issued from a recognised public authority (such as income tax assessment order - subject to the satisfaction of the firm). Should you have any questions please do not hesitate to <cite class="req" style="font-style: normal;">contact us<cite>.
                            </p>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="email" style="padding: 0 10px;">
                        <div class="options" style="border-bottom: 1px solid #eee;">
                            <div class="col-sm-1">
                                <h1 class="one">1</h1>
                            </div>
                            <div class="col-sm-6">
                                <p class="up-text"><cite class="req">*</cite> Colour copy of passport or the front of the ID</p>
                            </div>
                            <div class="col-sm-5" style="margin-bottom: 15px;">
                                <p class="up-text"><cite class="req">*</cite> Colour copy of the back of the ID</p>
                            </div>
                            <p class="send-email" style="margin-bottom: 20px;">Send documents by email to: <cite class="req" style="font-style: normal; font-weight: 600;">support@mail.forexmart.com</cite></p>
                            <p class="one-text">
                                Attach a scanned copy of a valid passport, national ID, or driver's license. For national ID or driver's license, both front and back copies must be provided.
                            </p>
                            <div class="col-sm-3">
                                <ul class="requires">
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Your Full Name</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Unique number</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Date and Place of birth</li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul class="requires">
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Photograph</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Signature</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Nationality</li>
                                </ul>
                            </div>
                            <div class="col-sm-3" style="text-align: right;">
                                <img src="<?= $this->template->Images()?>id.png" class="img-responsive" width="150px">
                            </div><div class="clearfix"></div>
                            <p class="last-text">
                                Of course International Passports or National IDs are country specific and the information contained therein varies.<br>
                                Should you have any questions please do not hesitate to <cite class="req" style="font-style: normal;">contact us</cite>.
                            </p>
                        </div>
                        <div class="options" style="border-bottom: 1px solid #eee;">
                            <div class="col-sm-1">
                                <h1 class="one">2</h1>
                            </div>
                            <div class="col-sm-11" style="text-align: center;">
                                <p class="up-text"><cite class="req">*</cite> Proof of Residence</p>
                                <p class="send-email" style="margin-bottom: 20px;">Send documents by email to: <cite class="req" style="font-style: normal; font-weight: 600;">support@mail.forexmart.com</cite></p>
                            </div>
                            <p class="one-text">
                                Submit a scanned copy of the most recent proof of billing (e.g., utility bill, credit card statement, bank statement, etc.) no later than six months past. The document should include the following details:
                            </p>
                            <div class="col-sm-9">
                                <ul class="requires">
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Name</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Residential Address (street name & number, city and country)</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Date of issue</li>
                                </ul>
                            </div>
                            <div class="col-sm-3" style="text-align: right;">
                                <img src="<?= $this->template->Images()?>bill.png" class="img-responsive" width="100px">
                            </div><div class="clearfix"></div>
                            <p class="last-text">
                                Example of such documents include: water, electricity, gas or telephone bills, bank statement, any letter issued from a recognised public authority (such as income tax assessment order - subject to the satisfaction of the firm). Should you have any questions please do not hesitate to <cite class="req" style="font-style: normal;">contact us<cite>.
                            </p>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="mobile" style="padding: 0 10px;">

                        <div class="desc-cont">
                            <p>If you prefer to take a picture of required documents from your mobile device, you can capture the image of your Proof of ID and Proof of Address and forward both to support@mail.forexmart.com. You must submit your document using the e-mail address you have registered with ForexMart.</p>
                        </div>

                        <div class="options" style="border-bottom: 1px solid #eee;">
                            <div class="col-sm-1">
                                <h1 class="one">1</h1>
                            </div>
                            <div class="col-sm-6">
                                <p class="up-text"><cite class="req">*</cite> Colour copy of passport or the front of the ID</p>
                            </div>
                            <div class="col-sm-5" style="margin-bottom: 15px;">
                                <p class="up-text"><cite class="req">*</cite> Colour copy of the back of the ID</p>
                            </div>
                            <p class="send-email">Send documents by email to: <cite class="req" style="font-style: normal; font-weight: 600;">support@mail.forexmart.com</cite></p>
                            <p style="font-weight: 600; margin-bottom: 20px; text-align: center;">Subject: "Your email address"</p>
                            <p class="one-text">
                                Attach a scanned copy of a valid passport, national ID, or driver's license. For national ID or driver's license, both front and back copies must be provided.
                            </p>
                            <div class="col-sm-3">
                                <ul class="requires">
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Your Full Name</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Unique number</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Date and Place of birth</li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul class="requires">
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Photograph</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Signature</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Nationality</li>
                                </ul>
                            </div>
                            <div class="col-sm-3" style="text-align: right;">
                                <img src="<?= $this->template->Images()?>id.png" class="img-responsive" width="150px">
                            </div><div class="clearfix"></div>
                            <p class="last-text">
                                Of course International Passports or National IDs are country specific and the information contained therein varies.<br>
                                Should you have any questions please do not hesitate to <cite class="req" style="font-style: normal;">contact us</cite>.
                            </p>
                        </div>
                        <div class="options" style="border-bottom: 1px solid #eee;">
                            <div class="col-sm-1">
                                <h1 class="one">2</h1>
                            </div>
                            <div class="col-sm-11" style="text-align: center;">
                                <p class="up-text"><cite class="req">*</cite> Proof of Residence</p>
                                <p class="send-email">Send documents by email to: <cite class="req" style="font-style: normal; font-weight: 600;">support@mail.forexmart.com</cite></p>
                                <p style="font-weight: 600; margin-bottom: 20px;">Subject: "Your email address"</p>
                            </div>
                            <p class="one-text">
                                A copy of a proof of residence (e.g utility bill) not more than six months old required in order to verify your permanent residential address. The document should, as a minimum, demonstrate the following information:
                            </p>
                            <div class="col-sm-9">
                                <ul class="requires">
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Name</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Residential Address (street name & number, city and country)</li>
                                    <li><i class="fa fa-caret-right" style="color: #ff0000;"></i> Date of issue</li>
                                </ul>
                            </div>
                            <div class="col-sm-3" style="text-align: right;">
                                <img src="<?= $this->template->Images()?>bill.png" class="img-responsive" width="100px">
                            </div><div class="clearfix"></div>
                            <p class="last-text">
                                Example of such documents include: water, electricity, gas or telephone bills, bank statement, any letter issued from a recognised public authority (such as income tax assessment order - subject to the satisfaction of the firm). Should you have any questions please do not hesitate to <cite class="req" style="font-style: normal;">contact us<cite>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        var forexmart = "<?php echo FXPP::ajax_url();?>";
        $(".uploadimage").on('submit',(function(e) {
            e.preventDefault();
            var id = this.id;
            $('div#'+id).show();
            $('div#'+id).html('<div class="alert alert-info">Uploading file. Please wait...</div>');
            $.ajax({
                type: 'POST',
                url: forexmart+'profile/uploadDocuments/'+$.now(),
                dataType: 'json',
                data: new FormData(this),
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false        // To send DOMDocument or non processed data file it is set to false
            }).done(function(response){
                if(response.error){
                    if(response.msgError === '<p>The filetype you are attempting to upload is not allowed.</p>'){
                        var rtnError = 'The file type you are attempting to upload is not allowed. The format should be in <strong>gif</strong>, <strong>jpg</strong>, or <strong>png</strong>.';
                    }else{
                        var rtnError = response.msgError;
                    }
                    $('div#'+id).html('<div class="alert alert-danger">'+rtnError+'</div>');
                }else{
                    $('div#'+id).html('<div class="alert alert-success">The file was uploaded successfully.</div>');
                }
            });
        }));

        $('.change-tab').click(function(){
            if( ! $(this).hasClass("upload-active") ){
                $('a.change-tab').removeClass("upload-active");
                $(this).addClass("upload-active");
            }
        });

        $(document).ready(function(){
            $('.tooltip-upload-docs').tooltip({title: "<p align='left' style='padding: 5px !important;'>The field is optional. In this field you may enter the affiliate code of a partner who referred you to the company.</p>", html: true, placement: "right"});
        });
    });
</script>