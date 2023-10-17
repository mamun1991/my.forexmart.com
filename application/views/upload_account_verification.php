<?php include_once('profile_nav.php') ?>
<?php $this->lang->load('bootstrap');?>
<style>@media (min-width: 768px) .col-sm-4 { width: 25%!important; } .custom-span span {  margin-left: 2px!important;  font-size: 12px;  }
        /*.re-apply-div{  color: #a94442;background-color: #f2dede;border-color: #ebccd1;padding: 6px; text-align: center;margin: 0px 20px;border: 1px solid transparent;border-radius: 4px;  }*/
        .disable-verification-incomplete,.notice-profile-documents-match,.contact-support,.re-apply-div{color: #a94442;background-color: #f2dede;border-color: #ebccd1;padding: 6px; text-align: center;margin: 10px; margin-bottom:5px;border: 1px solid transparent;border-radius: 4px;}
        #tbl_decline_reason td{
            word-break: break-all;
            border:1px solid #cecece;
            text-align: center;
        }
        #tbl_decline_reason th{
            background: #9c9c9c;
            color: #ffffff;
            border: 1px solid #cecece;
            text-align: center;
        }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        <?php if($isComplete==false){?>
        $(".upload-verification-documents-page button.btn-up-file").attr("disabled",true);
        $(".upload-verification-documents-page input.filestyle").attr("disabled",true);
        $(".upload-verification-documents-page button").css({ 'background':'#bcbcbc'});
        <?php } ?>
        <?php if($account_status==2){?>
        $(".upload-verification-documents-page button.btn-up-file").attr("disabled",true);
        $(".upload-verification-documents-page input.filestyle").attr("disabled",true);
        $(".upload-verification-documents-page button").css({ 'background':'#bcbcbc'});
        $("button").css({ 'background':'#bcbcbc'});
        $("#reapply_personalverification").attr("disabled",false);
        <?php } ?>
    });
    $(document).ready(function(){
        $('.tooltip-upload-docs').tooltip({title: "<p align='left' style='padding: 5px !important;'>Accepted file format are pdf, png, jpg, gif and bmp</p>", html: true, placement: "right"});
    });
</script>
<div role="tabpanel" class="tab-pane tab-up tab-panes upload-verification-documents-page" id="tab3">
    <div class="row">
        <div class="col-md-12 upload-docs-holder">

            <div class="col-md-12 options">
                <?php if($isComplete==false && $account_status!=1){?>
                    <div class="disable-verification-incomplete"><p style="font-size: 14px;"><?=lang('tooltip_07_1');?></p></div>
                <?php } ?>
                <?php if($account_status!=1){ ?>
                    <div class="notice-profile-documents-match"><p style="font-size: 14px;"><?=lang('tooltip_07_2');?><a href="<?=FXPP::loc_url('Profile/edit');?>"><?=lang('tooltip_07_3');?></a> <?=lang('tooltip_07_4');?></p></div>
                <?php }else if($applicationnumber>=2 && $account_status==2){?>
                    <div class="contact-support"><p style="font-size: 14px;"><?=lang('tooltip_07_5');?></div>
                <?php }  ?>
                <?php if($hasDeclinedDocs){?>
                    <div class="re-apply-div"><p style="font-size: 14px;"><?=lang('tooltip_07_6');?><a href="javascript:void(0)" id="view-reason-of-decline"><?=lang('tooltip_07_7');?></a> | <a href="<?=FXPP::loc_url('profile/upload-verification-documents/1')?>" target="_self"> <?=lang('tooltip_07_8');?></a>
                            <?php if($personalver_appnum<2){ ?> | <a id="reapply_personalverification"><?=lang('tooltip_07_9');?></a> <?php } ?>
                    </div>
                <?php } ?>
            </div>

            <div class="col-md-12" style="padding-left: 0;"><br>
                <h2 id="appH2"><?=$app = ($applicationnumber<=1)?lang('btn_text_1'):lang('btn_text_2');?></h2>
            </div>
            <?php if($applicationnumber==1) {
                $loc = FXPP::loc_url('profile/upload-verification-documents');
                $btn_label = lang('btn_text_3');
            }else {
                $loc = FXPP::loc_url('profile/upload-verification-documents/1');
                $btn_label = lang('btn_text_4');
            } ?>
            <?php if($applicationnumber>1 || $files_read_only){?>
                <div class="col-md-12 options" style="padding-left: 0;"><br><a id="" href="<?=$loc?>" target="_blank" style="background: #29a643; border-radius: 0; transition: all ease 0.3s; border: none; padding: 7px 10px; color: #fff; margin-top: 10px; margin-right: 15px;"><?=$btn_label;?></a></div>
            <?php } ?>
            <div id="frstapp" class="col-md-12 options" style="padding-left: 0;"></div>
            <div class="options">
                <div class="col-sm-0"><h1 class="one">1</h1></div>
                <div class="col-sm-6">
                    <p class="up-text"><cite class="req">*</cite><?=lang('accver_00');?><br><span style="margin-left:15%;"><?=lang('tooltip_07_10');?></span><i style="color: blue;" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                    <div id="front-id" class="docs-id" style="display: <?php echo $checkUserDocsIDfront ? 'block' : 'none' ;?>;">
                        <?php if(isset($up0)){ ?>
                            <div class="alert alert-success">
                                <?=lang('accver_01');?>.<a href="<?=site_url().'assets/user_docs/'.$up0->file_name;?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a><br/><?=lang('accver_02');?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if( $account_status!=1){ $docId0 = count($reupload0)>0?$reupload0->id:'';  if(!isset($files_read_only)){ ?>
                        <form method="POST" id="front-id" enctype="multipart/form-data" class="uploadimage" data-docid="<?=$docId0?>" data-reupload="<?=count($reupload0);?>" data-status="<?=$checkUserDocsIDfront->status;?>">
                            <label></label>
                            <input type="hidden" value="0" name="doc_type"/>
                            <input type="hidden" value="<?=count($reupload0);?>" name="reupload"/>
                            <div class="form-group arabic-form-parent-group">
                                <label class="col-sm-3 <?= FXPP::html_url() == 'sa' ? 'col-lg-3 col-md-3 col-xs-12' : '' ?> arabic-account-ver-child frm-grp"><?=lang('accver_03');?>:</label>
                                <div class="col-sm-8 custom-span"><input type="file" data-classButton="btn btn-primary" data-buttonName="btn-primary" name="filename" id="filename-front" data-buttonText="<?=lang('boo_str_01')?>"></div>
                            </div>
                            <div class="btn-up-file-holder col-sm-9 pull-right"><button class="btn-up-file" ><i class="fa fa-upload"></i><span id="front-id-btn-up"><?=$desc=count($reupload0)>0?lang('btn_replace'):lang('accver_04');?></span></button></div>
                            <div class="clearfix fix"></div>
                        </form>
                    <?php }     } ?>
                </div>


                <div class="col-sm-6">
                    <p class="up-text"><cite class="req">*</cite><?=lang('accver_05');?><br><span style="margin-left:15%;"><?=lang('tooltip_07_11');?></span><i style="color: blue;" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                    <div id="back-id" class="docs-id-back" style="display: <?php echo $checkUserDocsIDback ? 'block' : 'none' ;?>;">
                        <?php if(isset($up1)){ ?>
                            <div class="alert alert-success">
                                <?=lang('accver_06');?>.<a href="<?=site_url().'/assets/user_docs/'.$up1->file_name;?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a><br/><?=lang('accver_07');?>.
                            </div>
                        <?php } ?>

                    </div>
                    <?php if($account_status!=1){  $docId1 =  count($reupload1)>0?$reupload1->id:''; if(!isset($files_read_only)){ ?>
                        <form method="POST" id="back-id" enctype="multipart/form-data" class="uploadimage" data-status="<?=$checkUserDocsIDback->status;?>">
                            <label></label>
                            <input type="hidden" value="1" name="doc_type"/>
                            <input type="hidden" value="<?=count($reupload1);?>" name="reupload"/>
                            <div class="form-group">
                                <label class="col-sm-3 frm-grp"><?=lang('accver_08');?>:</label>
                                <div class="col-sm-8 custom-span"><input type="file" class="filestyle" data-buttonName="btn-primary" name="filename" id="filename-back" data-buttonText="<?=lang('boo_str_01')?>"></div>
                            </div>
                            <div class="btn-up-file-holder col-sm-9 pull-right">
                                <button class="btn-up-file"><i class="fa fa-upload"></i>
                                    <span id="back-id-btn-up"><?=$desc=count($reupload1)>0?lang('btn_replace'):lang('accver_04');;?></span>
                                </button>
                            </div>
                            <div class="clearfix fix"></div>
                        </form>
                    <?php } }?>
                </div><div class="clearfix"></div>





                <div class="alert alert-success note1">
                    <p class="one-text"><?=lang('accver_10');?></p>
                    <div class="col-sm-3">
                        <ul class="requires">
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i><?=lang('accver_11');?></li>
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i><?=lang('accver_12');?></li>
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i><?=lang('accver_13');?></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="requires">
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i><?=lang('accver_14');?></li>
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i><?=lang('accver_15');?></li>
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i><?=lang('accver_16');?></li>
                        </ul>
                    </div><div class="clearfix"></div>
                </div>
            </div>
            <div class="options">
                <div class="col-sm-1"><h1 class="one two">2</h1></div>
                <div class="col-sm-6 col-centered">
                    <p class="up-text"><cite class="req">*</cite><?=lang('accver_17');?><i style="color: blue;" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                    <div id="proof-residence" class="docs-proof" style="display: <?php echo $checkUserDocsResidence ? 'block' : 'none' ;?>;">
                        <?php if(isset($up2)){ ?>
                            <div class="alert alert-success">
                                <?=lang('accver_18');?>.<a href="<?=site_url().'/assets/user_docs/'.$up2->file_name;?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a><br/><?=lang('accver_19');?>.
                            </div>
                        <?php } ?>
                    </div>
                    <?php if($account_status!=1){ $docId2 =  count($reupload2)>0?$reupload2->id:''; if(!isset($files_read_only)){ ?>
                        <form method="POST" id="proof-residence" enctype="multipart/form-data" class="uploadimage" data-status="<?=$checkUserDocsResidence->status;?>">
                            <label></label>
                            <input type="hidden" value="2" name="doc_type"/>
                            <input type="hidden" value="<?=count($reupload2);?>" name="reupload"/>
                            <div class="form-group">
                                <label class="col-sm-3 frm-grp"><?=lang('accver_20');?>:</label>
                                <div class="col-sm-9 custom-span"><input id="fileupload" type="file" name="filename"  multiple data-buttonText="<?=lang('boo_str_01')?>"></div>
                            </div>
                            <div class="btn-up-file-holder col-sm-9 pull-right">
                                <button class="btn-up-file"><i class="fa fa-upload"></i><span id="proof-residence-btn-up"><?=$desc=count($reupload2)>0?lang('btn_replace'):lang('accver_21');?></span></button>
                            </div>
                            <div class="clearfix fix"></div>
                        </form>
                    <?php   } }?>
                </div><div class="clearfix"></div>





                <div class="alert alert-success note1">
                    <p class="one-text"><?=lang('accver_22');?><br><br><?=lang('accver_23');?></p>
                    <div class="col-sm-12">
                        <ul class="requires">
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i><?=lang('accver_24');?></li>
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i><?=lang('accver_25');?></li>
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i><?=lang('accver_26');?></li>
                        </ul>
                    </div><div class="clearfix"></div>
                </div>

            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .tooltip-inner {  max-width: 200px;width: 200px;} .blue{font-size: 12px;color: #337AB7;}
</style>
<script src="<?=$this->template->js()?>custom-jquery-input-file-text.js" ></script>
<script type="text/javascript">
    $('#fileupload').inputFileText({  text: "<?=lang('boo_str_01')?>" }); //FXPP-7251
    $('#filename-back').inputFileText({  text: "<?=lang('boo_str_01')?>" }); //FXPP-7251
    $('#filename-front').inputFileText({  text: "<?=lang('boo_str_01')?>" }); //FXPP-7251
    $('.custom-span span').text('<?=lang('boo_str_02')?>'); //FXPP-7251
    $(document).ready(function(){
        var forexmart = "<?php echo FXPP::ajax_url();?>";
        var formid = '';
        var form_submit = '';
        $(".uploadimage").on('submit',(function(e) {
            e.preventDefault();
            var id = this.id;
            formid = id;
            form_submit = this;
            var status =  $(this).data('status');
//            console.log(status);
            if(status!=1){
                $('div#'+id).show();
                $('div#'+id).html('<div class="alert alert-info">Uploading file. Please wait...</div>');
                $.ajax({
                    type: 'POST',
                    url: forexmart+'profile/uploadVerificationDocuments/'+$.now(),
                    dataType: 'json',
                    data: new FormData(this),
                    contentType: false,       // The content type used when sending data to the server.
                    cache: false,             // To unable request pages to be cached
                    processData:false        // To send DOMDocument or non processed data file it is set to false
                }).done(function(response){
                    if(response.error){
                        if( response.msgError === '<p>The filetype you are attempting to upload is not allowed.</p>' && response.msgError_ext===false){
                            var rtnError = 'The file type you are attempting to upload is not allowed. The format should be in <strong>pdf</strong> ,<strong>gif</strong>, <strong>jpg</strong>, or <strong>png</strong>.';
                        }else{
                            var rtnError = response.msgError;
                        }
                        $('div#'+id).html('<div class="alert alert-danger">'+rtnError+'</div>');
                    }else{
                        $('div#'+id).html('<div class="alert alert-success"><?=lang('accver_29');?></div>');
                        var upid = '#'+id+'-btn-up';
                        $(upid).text('<?=lang("btn_replace");?>');
                    }
                });
            }else{
                $("#confirm-replace").modal("show");
            }
        }));







        $('.yes-confirm').click(function(){
            var id = formid;
            console.log('yes-confirm');
            $('div#'+id).show();
            $('div#'+id).html('<div class="alert alert-info">Uploading file. Please wait...</div>');
            $.ajax({
                type: 'POST',
                url: forexmart+'profile/uploadVerificationDocuments/'+$.now(),
                dataType: 'json',
                data: new FormData(form_submit),
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false        // To send DOMDocument or non processed data file it is set to false
            }).done(function(response){
                if(response.error){
                    if( response.msgError === '<p>The filetype you are attempting to upload is not allowed.</p>' && response.msgError_ext===false){
                        var rtnError = 'The file type you are attempting to upload is not allowed. The format should be in <strong>pdf</strong> ,<strong>gif</strong>, <strong>jpg</strong>, or <strong>png</strong>.';
                    }else{
                        var rtnError = response.msgError;
                    }
                    $('div#'+id).html('<div class="alert alert-danger">'+rtnError+'</div>');
                }else{
                    $('div#'+id).html('<div class="alert alert-success"><?=lang('accver_29');?></div>');
                    var upid = '#'+id+'-btn-up';
                    $(upid).text('<?=lang("btn_replace");?>');
                    $("#confirm-replace").modal("hide");
                }
            });
        });

        $('.no-confirm').click(function(){
            $('#confirm-replace').modal('hide');
            console.log('no-confirm');
        });
    });
    $(document).on("click","#reapply_personalverification",function(){
        $.ajax({
            type: 'POST',
            url:'<?=FXPP::ajax_url('profile/reApplyForPAC')?>',
            dataType: 'json',
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false        // To send DOMDocument or non processed data file it is set to false
        }).done(function(response){
            if(response.updateApplication){
                $('.re-apply-div').hide();
                $('.contact-support').hide();
                $(".upload-verification-documents-page button.btn-up-file").attr("disabled",false);
                $(".upload-verification-documents-page input.filestyle").attr("disabled",false);
                $(".upload-verification-documents-page button").css({ 'background':'#29a643'});
                $("button").css({ 'background':'#29a643'});
                $('#appH2').html('Current Application');
                $('#frstapp').html('<br><a id="" href="<?=FXPP::loc_url('profile/upload-verification-documents/1')?>" target="_blank" style="background: #29a643; border-radius: 0; transition: all ease 0.3s; border: none; padding: 7px 10px; color: #fff; margin-top: 10px; margin-right: 15px;"><?=lang("btn_text_4");?></a>');
                $('#required-field-pac').modal('show');
                $('#quick-error-msg-pac').html('Please upload files to apply again for verification.');
            }else{
                $('#required-field-pac').modal('show');
                $('#quick-error-msg-pac').html('Failed to re-apply. You have reached the maximum count for account verification application. Please contact support for further information.');
            }
        });
    });
    $(document).on('click','#view-reason-of-decline',function(){
        $('#table-decline').html('<?=$reason_for_decline;?>');
        $('#decline-reason').modal('show');

    });
</script>
<div class="modal fade" id="confirm-replace" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog modal-lg round-0" style="width: 25%;">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin-top: -9px;"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input id="id-form" style="display: none;" value="">
                The uploaded file you're going to change is already approved.<br>
                Are you sure you want to replace the file?
                <button class="btn-up-file yes-confirm" style="width: 50px;">Yes</button>
                <button class="btn-up-file no-confirm" style="width: 50px;">No</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="required-field" tabindex="-1" role="dialog" aria-labelledby="" style="width: 100%;">
    <div class="modal-dialog round-0 mod1">
        <div class="modal-content round-0">
            <div class="modal-header round-0 mod2">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p id="quick-error-msg"></p>
            </div>
        </div>
        <div class="arrow-left"></div>
    </div>
</div>
<div class="modal fade" id="required-field-pac" tabindex="-1" role="dialog" aria-labelledby="" style="width: 100%;">
    <div class="modal-dialog round-0 mod1">
        <div class="modal-content round-0">
            <div class="modal-header round-0 mod2">
                <button type="button" class="close pac-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p id="quick-error-msg-pac"></p>
            </div>
        </div>
        <div class="arrow-left"></div>
    </div>
</div>
<div class="modal fade" id="decline-reason" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog modal-lg round-0" style="width: 50%;">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin-top: -9px;"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h4>Decline Note</h4>
                <table id="tbl_decline_reason"><tr><th style="width:15%">Document #</th><th style="width:35%">File</th><th style="width:35%">Decline Reason</th><th style="width:15%">Explanation</th></tr>
                    <tbody id="table-decline"></tbody>
                </table>

            </div>
        </div>
    </div>