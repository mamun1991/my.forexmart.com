
<?php $this->lang->load('bootstrap');?>
<style>

    .antherImgClass{
        width:auto;
    }

    @media (max-width: 768px){
        .antherImgClass {
            width: 87%;
            margin-left: 13px;
        }

    }

    @media only screen and (min-width: 768px)  and (max-width: 1100px) {
        .antherImgClass {
            width: 21%;
            margin-left: 5px;
        }
    }







    @media (min-width: 768px)
        .col-sm-4 {
            width: 25%!important;
        }


        .custom-span span {
            font-size: 12px;
        }

</style>


<h1>
    <?=lang('xnv_MyAcc');?>
</h1>

<?php $this->load->view('account_nav.php');?>

<div role="tabpanel" class="tab-pane tab-up tab-panes" id="tab3">
    <div class="row">
        <div class="col-md-12 upload-docs-holder">
            <div class="options">
                <div class="col-sm-0">
                    <h1 class="one">1</h1>
                </div>
                <div class="col-sm-6">
                    <p class="up-text"><cite class="req">*</cite>
                        <?=lang('accver_00');?>

                        <i style="color: blue;" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                    <div id="front-id" class="docs-id" style="display: <?php echo $checkUserDocsIDfront ? 'block' : 'none' ;?>;"><div class="alert alert-success">
                            <?php
                                if((FXPP::html_url() == 'cs' || FXPP::html_url() == 'cs')) {
                                    echo lang('accver_18');
                                } else { ?>
                                    <?=lang('x_accv_03');?>
                                <?php } ?>
                                <a href="<?=site_url().'/assets/user_docs/'.$up0['file_name'];?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a>
                            <br/>
                            <?=lang('accver_02');?>.
                        </div></div>
                    <form method="POST" id="front-id" enctype="multipart/form-data" class="uploadimage">
                        <input type="hidden" value="0" name="doc_type"/>
                        <div class="form-group arabic-form-parent-group">
                            <label class="col-sm-3 <?= FXPP::html_url() == 'sa' ? 'col-lg-3 col-md-3 col-xs-12' : '' ?> arabic-account-ver-child frm-grp">
                                <?=lang('accver_03');?>:
                            </label>
                            <div class="col-sm-8 custom-span">

                                <input type="file" class="filestyle" data-buttonName="btn-primary" name="filename" id="filename-front" data-buttonText="<?=lang('boo_str_01')?>"  onchange="previewFile(this,'docs-id')">

                            </div>
                        </div>
                        <div class="btn-up-file-holder col-sm-9 pull-right">
                            <button class="btn-up-file btn-docs-id"><i class="fa fa-upload"></i>
                                <?=lang('accver_04');?>
                            </button>
                        </div>
                        <div class="clearfix fix"></div>
                    </form>
                </div>
                <div class="col-sm-6">
                    <p class="up-text"><cite class="req">*</cite>
                        <?=lang('accver_05');?>
                        <i style="color: blue;" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                    <div id="back-id" class="docs-id-back" style="display: <?php echo $checkUserDocsIDback ? 'block' : 'none' ;?>;"><div class="alert alert-success">
                            <?php  if((FXPP::html_url() == 'cs' || FXPP::html_url() == 'cs')) {
                                    echo lang('accver_18');
                                } else { ?>
                                <?=lang('x_accv_03');?>
                                <?php } ?>
                                <a href="<?=site_url().'/assets/user_docs/'.$up1['file_name'];?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a>
                            <br/>
                            <?=lang('accver_07');?>.
                        </div></div>
                    <form method="POST" id="back-id" enctype="multipart/form-data" class="uploadimage">
                        <input type="hidden" value="1" name="doc_type"/>
                        <div class="form-group">
                            <label class="col-sm-3 frm-grp">
                                <?=lang('accver_08');?>:
                            </label>
                            <div class="col-sm-8 custom-span">
                                <input type="file" class="filestyle" data-buttonName="btn-primary" name="filename" id="filename-back" data-buttonText="<?=lang('boo_str_01')?>"  onchange="previewFile(this,'docs-id-back')">
                            </div>
                        </div>
                        <div class="btn-up-file-holder col-sm-9 pull-right">
                            <button class="btn-up-file btn-docs-id-back"><i class="fa fa-upload"></i>
                                <?=lang('accver_09');?>
                            </button>
                        </div>
                        <div class="clearfix fix"></div>
                    </form>
                </div><div class="clearfix"></div>
                <div class="alert alert-success note1">
                    <p class="one-text">
                        <?=lang('accver_10');?>
                    </p>
                    <div class="col-sm-3">
                        <ul class="requires">
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i>
                                <?=lang('accver_11');?>
                            </li>
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i>
                                <?=lang('accver_12');?>
                            </li>
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i>
                                <?=lang('accver_13');?>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="requires">
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i>
                                <?=lang('accver_14');?>
                            </li>
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i>
                                <?=lang('accver_15');?>
                            </li>
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i>
                                <?=lang('accver_16');?>
                            </li>
                        </ul>
                    </div><div class="clearfix"></div>
                </div>
            </div>
            
            
            
            <div class="options">
                <div class="col-sm-1">
                    <h1 class="one two">2</h1>
                </div>
                
                
                <div class="col-sm-6 col-centered">
                    <p class="up-text"><cite class="req">*</cite>
                        <?=lang('accver_17');?>
                        <i style="color: blue;" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                    <div id="proof-residence" class="docs-proof" style="display: <?php echo $checkUserDocsResidence ? 'block' : 'none' ;?>;"><div class="alert alert-success">
                            <?php if((FXPP::html_url() == 'cs' || FXPP::html_url() == 'cs')) {
                                       echo lang('accver_18');
                                    } else { ?>
                                      <?=lang('x_accv_03');?>
                              <?php } ?>
                                <a href="<?=site_url().'/assets/user_docs/'.$up2['file_name'];?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a>
                            <br/>
                            <?=lang('accver_19');?>.
                        </div></div>
                    <form method="POST" id="proof-residence" enctype="multipart/form-data" class="uploadimage">
                        <input type="hidden" value="2" name="doc_type"/>
                        <div class="form-group">
                            <label class="col-sm-3 frm-grp">
                                <?=lang('accver_20');?>:
                            </label>
                            <div class="col-sm-9 custom-span">
                                <input id="fileupload" type="file" name="filename" multiple data-buttonText="<?=lang('boo_str_01')?>" onchange="previewFile(this,'docs-proof')">
                            </div>
                        </div>
                        <div class="btn-up-file-holder col-sm-9 pull-right">
                            <button class="btn-up-file btn-docs-proof"><i class="fa fa-upload"></i>
                                <?=lang('accver_21');?>
                            </button>
                        </div>
                        <div class="clearfix fix"></div>
                    </form>
                </div><div class="clearfix"></div>
                <div class="alert alert-success note1">
                    <p class="one-text">
                        <?=lang('accver_22');?>
                        <br><br>
                        <?=lang('accver_23');?>
                    </p>
                    
        
                    
                    <div class="col-sm-12">
                        <ul class="requires">
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i>
                                <?=lang('accver_24');?>
                            </li>
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i>
                                <?=lang('accver_25');?>
                            </li>
                            <li><i class="fa fa-caret-<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>" style="color: #ff0000;"></i>
                                <?=lang('accver_26');?>
                            </li>
                        </ul>
                    </div><div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    
 
    
    

	            
               
        <div class="row">
        
            <div class="span4" id="image-div" >
         
                    <div class="input-append">
           

		 	<div class="options">
                <div class="col-sm-1">
                    <h1 class="one two">3</h1>
                </div>
                
                 
                <div class="col-sm-6 appendId">
                    <p class="up-text"><cite class="" style="font-style:normal">1.</cite>
                        <?=lang('additional_17');?>
                        <i style="color: blue;" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                    <div id="additional3" class=" additional-div-1 uploadimage-main-div" style="display: <?php echo $checkUserDocsIDback ? 'block' : 'none' ;?>;"><div class="alert alert-success">
                            <?php  if((FXPP::html_url() == 'cs' || FXPP::html_url() == 'cs')) {
                                    echo lang('accver_18');
                                } else { 
								
								if($up3['file_name']){
								?>
                                <?=lang('x_accv_03');?>
                                 <a href="<?=site_url().'/assets/user_docs/'.$up3['file_name'];?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a>
                                <?php 
								
								}
								
								
								
								} ?>
                               
                            <br/>
                            <?=lang('accver_07');?>.
                        </div></div>
                        
                        
                    <form method="POST" id="additional3" enctype="multipart/form-data" class="uploadimage">
                        <input type="hidden" value="3" name="doc_type" class="additional-hidden"/>
                        <div class="form-group">
                            <label class="col-sm-3 frm-grp">
                                <?=lang('accver_08');?>:
                            </label>
                            <div class="col-sm-8 custom-span">
                                <input type="hidden" id="3" class="imaget"> </span><input type="file" class="filestyle " data-buttonName="btn-primary" name="filename" id="filename-additional" data-buttonText="<?=lang('boo_str_01')?>" onchange="previewFile(this,'additional-div-1')">
                            </div>
                        </div>
                        <div class="btn-up-file-holder col-sm-9 pull-right">
                            <button class="btn-up-file btn-additional-div-1"><i class="fa fa-upload"></i>
                                <?=lang('accver_09');?>
                            </button>
                        </div>
                        
                        <div class="clearfix fix"></div>
                    </form>
                    
                    <div class="clearfix fix"></div>
                </div>
            
               
<?php 
 
if($adCounts >0){
$j=-1; 
$k=1;
for ($x = 4; $x < $adCounts+4; $x++) {  
$j++;
$k++;
$number= $adCount[$j]['doc_type'];
$showUp=$adCount[$j]['doc_type'];
?>

   <div class="col-sm-6 appendId" style="margin-left: 8%;" >
                    <p class="up-text"><cite style="font-style:normal" class="newSliD" id="<?=$k;?>"> <?=$k.'.';?></cite>
                        <?=lang('additional_17');?>
                        <i style="color: blue;" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                    <div id="additional<?=$number;?>" class="docs-additional uploadimage-main-div" style="display: <?php echo $checkUserDocsIDback ? 'block' : 'none' ;?>;"><div class="alert alert-success">
                            <?php  if((FXPP::html_url() == 'cs' || FXPP::html_url() == 'cs')) {
                                    echo lang('accver_18');
                                } else { ?>
                                <?=lang('x_accv_03');?>
                                <?php } ?>
                                <a href="<?=site_url().'/assets/user_docs/'.$adCount[$j]['file_name'];?>" class="blue" target="_blank" >[<?=lang('accver_001');?>]</a>
                            <br/>
                            <?=lang('accver_07');?>.
                        </div></div>
                        
                        
                    <form method="POST" id="additional<?=$number;?>" enctype="multipart/form-data" class="uploadimage">
                        <input type="hidden" value="<?=$number;?>" name="doc_type" class="additional-hidden"/>
                        <div class="form-group">
                            <label class="col-sm-3 frm-grp">
                                <?=lang('accver_08');?>:
                            </label>
                            <div class="col-sm-8 custom-span">
							
								<input type="hidden" id="<?=$showUp;?>" class="imaget imaget">
								<input type="button" id="ShowFile<?=$showUp;?>" value="<?=lang('boo_str_01');?>" onclick="preview('show-filename-additional<?=$showUp;?>')" />&nbsp;<span><?=lang('boo_str_02');?></span><input type="file" class="filestyle imaget te" style="display:none;" data-buttonName="btn-primary" name="filename" id="show-filename-additional<?=$showUp;?>" data-buttonText="">

                            </div>
                        </div>
                        <div class="btn-up-file-holder col-sm-9 pull-right">
                            <button class="btn-up-file btn-docs-additional"><i class="fa fa-upload"></i>
                                <?=lang('accver_09');?>
                            </button>
                        </div>
                        
                        <div class="clearfix fix"></div>
                    </form>
                    
                    <div class="clearfix fix"></div>
                </div>
      
 
 <?php
}
}
?> 
          
                    </div>

                </div>
  
 		 </div>
  
 
 
 
 <div class="btn-up-file-holder col-sm-9 pull-right" style="margin-right: 30px;">
  <button id="another_image" class="btn-up-file antherImgClass"  ><i class="fa fa-plus"></i>
     <?=lang('accver_add_more');?></button></div><div class="clearfix"></div>
                
     

                    

    
    
</div>
<style type="text/css">
    .tooltip-inner {
        max-width: 200px;
        /* If max-width does not work, try using width instead */
        width: 200px;
    }
.blue{
    font-size: 12px;
    color: #337AB7;
}
</style>
<script src="<?=$this->template->js()?>custom-jquery-input-file-text.js" ></script>
<script type="text/javascript">

var fileTypeError='<?= lang('reg_wr_02'); ?>';    
function preview(id){
 var id = id;
 $("#"+id).trigger('click');
}
$(document).ready(function(){
        var count = 2;
        var inid = 0;
        $('#another_image').click (function(){
			
         if(count < 50){
			 
			var additional =  "'filename-additional"+count+"'";
			
			var aht = '<div class="input-append" style="clear:left">  <div class="col-sm-1 "> <h1 class="one two"> </h1></div> <div class="col-sm-6 "> <p class="up-text"><cite style="font-style:normal" class="newSliD"></cite><?=lang('additional_17');?><i style="color: blue;" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p><div id="additional" class="docs-id-back   uploadimage-main-div" style="display: <?php echo $checkUserDocsIDback ? 'block' : 'none' ;?>;"><div class="alert alert-success"> <br/><?=lang('accver_07');?>. </div></div><form method="POST" id="additional" enctype="multipart/form-data" class="uploadimage"> <input type="hidden" class="additional-hidden" value="3" name="doc_type"/><div class="form-group"><label class="col-sm-3 frm-grp"> <?=lang('accver_08');?>:</label><div class="col-sm-8 custom-span"><input type="button" id="loadFile'+count+'" value="<?=lang('boo_str_01');?>" onclick="preview('+additional+')" />&nbsp;<span><?=lang('boo_str_02');?></span><input type="file" class="filestyle imaget te" style="display:none;" data-buttonName="btn-primary" name="filename" id="filename-additional'+count+'" data-buttonText=""></div></div> <div class="btn-up-file-holder col-sm-9 pull-right"><button class="btn-up-file"><i class="fa fa-upload"></i> <?=lang('accver_09');?></button></div> <div class="clearfix fix"></div> </form> </div> <div class="clearfix"></div> </div> ';
			   
			  	 
                 if($(".input-append:first-child").hasClass('cl')){
                 
                 } else {
                 var newId;
                 inid++;
				 var id = $(".appendId:last-child").find('.imaget').attr('id');
                 newId = parseInt(id)+parseInt(inid);
				 
				 var SlId = $(".appendId:last-child").find('.newSliD').attr('id');
				
 					if (typeof SlId === "undefined") {
						var newSl=inid+1;	
					}else{
						var newSl=parseInt(inid)+parseInt(SlId);	
						}
					 		  
                 $("#image-div").append(aht);
                 $(".input-append:last-child").find('.additional-hidden').val(newId);
                 $(".input-append:last-child").find('.uploadimage').attr('id', 'additional'+newId);
				 $(".input-append:last-child").find('.uploadimage-main-div').attr('id', 'additional'+newId);
				 
				  $(".input-append:last-child").find('.newSliD').html(newSl+'. ');;
				 
                 $('.input-append:last-child').addClass('cl');
                 
                 tooltipCall();
                  
                  }
                 
           count++;
            }
        });
        });

 
    $('#fileupload').inputFileText({  text: "<?=lang('boo_str_01')?>" }); //FXPP-7251
    $('#filename-back').inputFileText({  text: "<?=lang('boo_str_01')?>" }); //FXPP-7251
    $('#filename-front').inputFileText({  text: "<?=lang('boo_str_01')?>" }); //FXPP-7251
	
	$('#filename-additional').inputFileText({  text: "<?=lang('boo_str_01')?>" }); 
	
	
	
    $('.custom-span span').text('<?=lang('boo_str_02')?>'); //FXPP-7251
    //$(document).ready(function(){
        var forexmart = "<?php echo FXPP::ajax_url();?>";
        $(document).on('submit', '.uploadimage', (function(e) {

            e.preventDefault();
		    var id = this.id;
            $('div#'+id).show();
            $('div#'+id).html('<div class="alert alert-info">  <?=lang('reg_wr_04');?></div>');
            $.ajax({
                type: 'POST',
                url: forexmart+'profile/uploadDocuments/'+$.now(),
                dataType: 'json',
                data: new FormData(this),
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false        // To send DOMDocument or non processed data file it is set to false
            }).done(function(response){
				
			console.log('res: '+response);
				
                if(response.error){
                    if( response.msgError === '<p>The filetype you are attempting to upload is not allowed.</p>' && response.msgError_ext===false){
                        var rtnError = '<?=lang('reg_wr_02');?>';
                    }else{
                        var rtnError = response.msgError;
                    }
                    $('div#'+id).html('<div class="alert alert-danger">'+rtnError+'</div>');
                }else{
                    $('div#'+id).html('<div class="alert alert-success"><?=lang('accver_29');?></div>');
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
           tooltipCall();
        });

   // });


function tooltipCall()
{
    
    $('.tooltip-upload-docs').tooltip({title: "<p align='left' style='padding: 5px !important;'><?=lang('x_accv_04');?></p>", html: true, placement: "right"}); 
}


function previewFile(input,id) {
    if (input.files && input.files[0]) {
        var file_data = input.files[0];

        var fileType = file_data["type"];
        var validImageTypes = ["image/jpg", "image/jpeg", "image/png", "image/gif","application/pdf"];
        if ($.inArray(fileType, validImageTypes) < 0) {
            // invalid file type code goes here.
            $('div.'+id).show();
            
            
            $('div.'+id).html('<div class="alert alert-danger">'+fileTypeError+'</div>');

            $('.btn-'+id).attr("disabled", true);
            console.log('invalid');

        }else{
            $('.btn-'+id).attr("disabled", false);

        }

    }
}
	
</script>