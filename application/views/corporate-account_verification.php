
<?php $this->lang->load('bootstrap');
//print_r($account_type_status->corporate_acc_status);exit;
?>
<!--<style type="text/css">-->
<!--    .tooltip-inner {-->
<!--        max-width: 200px;-->
<!--        /* If max-width does not work, try using width instead */-->
<!--        width: 200px;-->
<!--    }-->
<!--    .alert-custome{-->
<!--        background-color: #ffffff;-->
<!--        border: 0px;-->
<!--    }-->
<!--    .custome-button{-->
<!--        margin-top: -16px;-->
<!--    }-->
<!--    .up-sub-text>span{-->
<!--        font-size: 10px;-->
<!--    }-->
<!---->
<!--</style>-->
<style>
    .mgtop{
        margin-top:-12px;
    }
</style>



<h1>
    My Account
</h1>

<?php $this->load->view('account_nav.php');?>

<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="tab4">
        <div class="row">
            <div class="col-md-12 upload-docs-holder">
                <div class="options">
                    <div class="col-sm-0">
                        <h1 class="one">1 <small><cite class="req"><sup>*</sup></cite> <?=lang('crp_acvr_item_1');?></small></h1>
                        <p class="account-sub-title"><?=lang('crp_acvr_item_desc_1');?></p>
                    </div>

                    <div class="col-sm-6">
                        <p class="up-text">
                            <cite class="req">*</cite><?=lang('crp_acvr_item_desc_2');?><i style="color: blue;" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>

                        <div id="front-id" class="docs-proof" style="display:<?php echo ($corporate_doc_1->file_name !='')?'block':'none'?>" ><div class="alert alert-success">

                                <?=lang('accver_18');?>.

                                <?php
                                if($corporate_doc_1 !=false){ ?>
                                    <a href="<?=site_url().'/assets/user_docs/'.$corporate_doc_1->file_name;?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a>
                                <?php }   ?>

                                <br/>
                                <?=lang('accver_19');?>.
                            </div>
                        </div>
                        <?php if($account_type_status->corporate_acc_status!=2) {?>
                            <form method="POST" id="front-id" enctype="multipart/form-data" class="uploadimage">
                                <input type="hidden" value="3" name="doc_type"/>
                                <div class="form-group">
                                    <label class="col-sm-3 frm-grp"><?=lang('crp_acvr_item_desc_4');?>:</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="filestyle" data-buttonName="btn-primary" name="filename" data-buttonText="Browse">
                                    </div>
                                </div>
                                <div class="btn-up-file-holder col-sm-9 pull-right">
                                    <button class="btn-up-file"><i class="fa fa-upload"></i><?=lang('accver_04');?> </button>
                                </div>
                                <div class="clearfix fix"></div>
                            </form>
                        <?php }?>
                    </div>
                    
                    
                    
                    

                    <div class="col-sm-6">
                        <p class="up-text"><cite class="req">*</cite>
                            <?=lang('crp_acvr_item_desc_3');?> <i style="color: blue;" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>

                        <div id="back-id" class="docs-proof" style="display:<?php echo ($corporate_doc_2->file_name !='')?'block':'none'?>"><div class="alert alert-success">
                                <?=lang('accver_18');?>.
                                <?php
                                if($corporate_doc_2 !=false){ ?>
                                    <a href="<?=site_url().'/assets/user_docs/'.$corporate_doc_2->file_name;?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a>
                                <?php }   ?>
                                <br/>
                                <?=lang('accver_19');?>.
                            </div>
                        </div>

                        <?php if($account_type_status->corporate_acc_status!=2) {?>
                            <form method="POST" id="back-id" enctype="multipart/form-data" class="uploadimage">
                                <input type="hidden" value="4" name="doc_type"/>
                                <div class="form-group">
                                    <label class="col-sm-3 frm-grp"><?=lang('crp_acvr_item_desc_4');?>:</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="filestyle" data-buttonName="btn-primary" name="filename" data-buttonText="Browse">
                                    </div>
                                </div>
                                <div class="btn-up-file-holder col-sm-9 pull-right">
                                    <button class="btn-up-file"><i class="fa fa-upload"></i><?=lang('accver_04');?></button>
                                </div>
                                <div class="clearfix fix"></div>
                            </form>
                        <?php } ?>
                    </div>

                    <div class="clearfix"></div>
                    
                    
                    
                    

                    <div class="alert alert-success note1">
                        <p class="one-text">
                            <?=lang('accver_10');?> </p>
                        <div class="col-sm-6">
                            <ul class="icon-list">
                                <li></i> <?=lang('accver_11');?></li>
                                <li></i><?=lang('accver_12');?></li>
                                <li></i><?=lang('accver_13');?></li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="icon-list">
                                <li></i> <?=lang('accver_14');?></li>
                                <li></i><?=lang('accver_15');?></li>
                                <li></i><?=lang('accver_16');?></li>

                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                </div>
                <div class="options">
                    <div class="col-sm-0">
                        <h1 class="one two">2 <small><cite class="req"><sup>*</sup></cite><?=lang('crp_acvr_item_2');?> </small></h1>
                        <p class="account-sub-title"><?=lang('crp_acvr_item_2_desc_1');?> </p>
                    </div>
                    <div class="col-sm-6 col-centered">


                        <div id="proof-residence" class="docs-proof" style="display:<?php echo ($corporate_doc_3->file_name !='')?'block':'none'?>"><div class="alert alert-success">
                                <?=lang('accver_18');?>.
                                <?php
                                if($corporate_doc_3 !=false){ ?>
                                    <a href="<?=site_url().'/assets/user_docs/'.$corporate_doc_3->file_name;?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a>
                                <?php }   ?>

                                <br/>
                                <?=lang('accver_19');?>.
                            </div>
                        </div>
                        <?php if($account_type_status->corporate_acc_status!=2) {?>
                            <form method="POST" id="proof-residence" enctype="multipart/form-data" class="uploadimage">
                                <input type="hidden" value="5" name="doc_type"/>
                                <div class="form-group">
                                    <label class="col-sm-3 frm-grp"><?=lang('crp_acvr_item_desc_4');?>:</label>
                                    <div class="col-sm-9">
                                        <input id="fileupload" type="file" name="filename" multiple data-buttonText="Browse">
                                    </div>
                                </div>
                                <div class="btn-up-file-holder col-sm-9 pull-right">
                                    <button class="btn-up-file"><i class="fa fa-upload"></i><?=lang('accver_04');?></button>
                                </div>
                                <div class="clearfix fix"></div>
                            </form>
                        <?php } ?>
                    </div>

                    <div class="clearfix"></div>

                    <div class="alert alert-success note1">
                        <p class="one-text">
                            <?=lang('crp_acvr_item_2_desc_2');?>  </p>
                        <div class="col-sm-12">
                            <ul class="icon-list">
                                <li><?=lang('perdet_02')?></li>
                                <li><?=lang('accver_25')?></li>
                                <li><?=lang('accver_26');?></li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="options">
                        <div class="col-sm-0">
                            <h1 class="one two">3 <small><?=lang('crp_acvr_item_3');?></small></h1>
                        </div>
                        <div class="clearfix fix"></div>

                        <form method="POST" id="incorporation" enctype="multipart/form-data" class="uploadimage">
                            <input type="hidden" value="6" name="doc_type"/>
                            <div class="col-sm-6 gaps">
                                <ul class="req-list">
                                    <li><?=lang('crp_acvr_doc_1');?></li>
                                </ul>
                            </div>
                            <?php if($account_type_status->corporate_acc_status!=2) {?>
                                <div class="col-sm-3 gaps" style="vertical-align:top;">
                                    <input id="fileupload" type="file" name="filename" multiple data-buttonText="Browse">
                                </div>
                                <div class="col-sm-6 gaps"></div>
                                <div class="col-sm-3 gaps">
                                    <button class="btn-up-file2"><i class="fa fa-upload"></i><?=lang('accver_04');?></button>
                                </div>
                            <?php } ?>
                        </form>

                        <div class="clearfix"></div>

                        <div id="incorporation" class="docs-proof" style="display:<?php echo ($corporate_doc_4->file_name !='')?'block':'none'?>"><div class="alert alert-success">
                                <?=lang('accver_18');?>.
                                <?php
                                if($corporate_doc_4 !=false){ ?>
                                    <a href="<?=site_url().'/assets/user_docs/'.$corporate_doc_4->file_name;?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a>
                                <?php }   ?>

                                <?=lang('accver_19');?>.
                            </div>
                        </div>

                        <div class="clearfix fix"></div>

                        <form method="POST" id="good-standing" enctype="multipart/form-data" class="uploadimage">
                            <input type="hidden" value="7" name="doc_type"/>

                            <div class="col-sm-6 gaps">
                                <ul class="req-list">
                                    <li><?=lang('crp_acvr_doc_2')?></li>
                                </ul>
                            </div>
                            <?php if($account_type_status->corporate_acc_status!=2) {?>
                                <div class="col-sm-3 gaps" style="vertical-align:top;">
                                    <input id="fileupload" type="file" name="filename" multiple data-buttonText="Browse">
                                </div>
                                <div class="col-sm-6 gaps"></div>
                                <div class="col-sm-3 gaps">
                                    <button class="btn-up-file2"><i class="fa fa-upload"></i><?=lang('accver_04');?></button>
                                </div>
                            <?php } ?>
                        </form>

                        <div class="clearfix fix"></div>
                        <div id="good-standing" class="docs-proof" style="display:<?php echo ($corporate_doc_5->file_name !='')?'block':'none'?>"><div class="alert alert-success">
                                <?=lang('accver_18');?>.
                                <?php
                                if($corporate_doc_5 !=false){ ?>
                                    <a href="<?=site_url().'/assets/user_docs/'.$corporate_doc_5->file_name;?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a>
                                <?php }   ?>

                                <?=lang('accver_19');?>.
                            </div>
                        </div>

                        <div class="clearfix fix"></div>

                        <form method="POST" id="cirtificate-incumbency-director" enctype="multipart/form-data" class="uploadimage">
                            <input type="hidden" value="8" name="doc_type"/>
                            <div class="col-sm-6 gaps">
                                <ul class="req-list">
                                    <li><?=lang('crp_acvr_doc_3')?></li>
                                </ul>
                            </div>
                            <?php if($account_type_status->corporate_acc_status!=2) {?>
                                <div class="col-sm-3 gaps" style="vertical-align:top;">
                                    <input id="fileupload" type="file" name="filename" multiple data-buttonText="Browse">
                                </div>
                                <div class="col-sm-6 gaps"></div>
                                <div class="col-sm-offset-6 col-sm-3 gaps mgtop">
                                    <button class="btn-up-file2"><i class="fa fa-upload"></i><?=lang('accver_04');?></button>
                                </div>
                            <?php } ?>
                        </form>

                        <div class="clearfix fix"></div>

                        <div id="cirtificate-incumbency-director" class="docs-proof" style="display:<?php echo ($corporate_doc_6->file_name !='')?'block':'none'?>"><div class="alert alert-success">
                                <?=lang('accver_18');?>.
                                <?php
                                if($corporate_doc_6 !=false){ ?>
                                    <a href="<?=site_url().'/assets/user_docs/'.$corporate_doc_6->file_name;?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a>
                                <?php }   ?>
                                <?=lang('accver_19');?>.
                            </div>
                        </div>

                        <div class="clearfix fix"></div>

                        <form method="POST" id="cirtificate-incumbency-shareholder" enctype="multipart/form-data" class="uploadimage">
                            <input type="hidden" value="9" name="doc_type"/>
                            <div class="col-sm-6 gaps">
                                <ul class="req-list">
                                    <li><?=lang('crp_acvr_doc_4')?></li>
                                </ul>
                            </div>
                            <?php if($account_type_status->corporate_acc_status!=2) {?>
                                <div class="col-sm-3 gaps" style="vertical-align:top;">
                                    <input id="fileupload" type="file" name="filename" multiple data-buttonText="Browse">
                                </div>
                                <div class="col-sm-6 gaps"></div>
                                <div class="col-sm-offset-6 col-sm-3 gaps mgtop">
                                    <button class="btn-up-file2"><i class="fa fa-upload"></i><?=lang('accver_04');?></button>
                                </div>
                            <?php } ?>
                        </form>



                        <div class="clearfix fix"></div>

                        <div id="cirtificate-incumbency-shareholder" class="docs-proof" style="display:<?php echo ($corporate_doc_7->file_name !='')?'block':'none'?>"><div class="alert alert-success">
                                <?=lang('accver_18');?>.
                                <?php
                                if($corporate_doc_7 !=false){ ?>
                                    <a href="<?=site_url().'/assets/user_docs/'.$corporate_doc_7->file_name;?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a>
                                <?php }   ?>

                                <?=lang('accver_19');?>.
                            </div>
                        </div>

                        <div class="clearfix"></div>


                        <form method="POST" id="audit-financial" enctype="multipart/form-data" class="uploadimage">
                            <input type="hidden" value="10" name="doc_type"/>

                            <div class="col-sm-6 gaps">
                                <ul class="req-list">
                                    <li><?=lang('crp_acvr_doc_5')?></li>
                                </ul>
                            </div>
                            <?php if($account_type_status->corporate_acc_status!=2) {?>
                                <div class="col-sm-3 gaps" style="vertical-align:top;">
                                    <input id="fileupload" type="file" name="filename" multiple data-buttonText="Browse">
                                </div>
                                <div class="col-sm-6 gaps"></div>
                                <div class="col-sm-3 gaps">
                                    <button class="btn-up-file2"><i class="fa fa-upload"></i><?=lang('accver_04');?></button>
                                </div>
                            <?php } ?>
                        </form>

                        <div class="clearfix fix"></div>
                        <div id="audit-financial" class="docs-proof" style="display:<?php echo ($corporate_doc_8->file_name !='')?'block':'none'?>"><div class="alert alert-success">
                                <?=lang('accver_18');?>.
                                <?php
                                if($corporate_doc_8 !=false){ ?>
                                    <a href="<?=site_url().'/assets/user_docs/'.$corporate_doc_8->file_name;?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a>
                                <?php }   ?>

                                <?=lang('accver_19');?>.
                            </div>
                        </div>

                        <div class="clearfix fix"></div>

                        <form method="POST" id="association-memorandum" enctype="multipart/form-data" class="uploadimage">
                            <input type="hidden" value="11" name="doc_type"/>
                            <div class="col-sm-6 gaps">
                                <ul class="req-list">
                                    <li><?=lang('crp_acvr_doc_6')?></li>
                                </ul>
                            </div>
                            <?php if($account_type_status->corporate_acc_status!=2) {?>
                                <div class="col-sm-3 gaps" style="vertical-align:top;">
                                    <input id="fileupload" type="file" name="filename" multiple data-buttonText="Browse">
                                </div>
                                <div class="col-sm-6 gaps"></div>
                                <div class="col-sm-3 gaps">
                                    <button class="btn-up-file2"><i class="fa fa-upload"></i><?=lang('accver_04');?></button>
                                </div>
                            <?php } ?>
                        </form>

                        <div class="clearfix fix"></div>

                        <div id="association-memorandum" class="docs-proof" style="display:<?php echo ($corporate_doc_9->file_name !='')?'block':'none'?>"><div class="alert alert-success">
                                <?=lang('accver_18');?>.
                                <?php
                                if($corporate_doc_9 !=false){ ?>
                                    <a href="<?=site_url().'/assets/user_docs/'.$corporate_doc_9->file_name;?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a>
                                    <a href="<?=site_url().'/assets/user_docs/'.$corporate_doc_9->file_name;?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a>
                                <?php }   ?>

                                <?=lang('accver_19');?>.
                            </div>
                        </div>
                        <div class="clearfix"></div>
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
//            console.log(id);
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
                        var rtnError = 'The file type you are attempting to upload is not allowed. The format should be in <strong>pdf</strong>, <strong>gif</strong>, <strong>jpg</strong>, or <strong>png</strong>.';
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
            $('.tooltip-upload-docs').tooltip({title: "<p align='left' style='padding: 5px !important;'>Accepted file format are png, jpg, gif and bmp</p>", html: true, placement: "right"});
        });

    });
</script>
