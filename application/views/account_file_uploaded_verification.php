
<?php $this->lang->load('bootstrap');?>


<h1>
    <?=lang('xnv_MyAcc');?>
</h1>

<?php $this->load->view('account_nav.php');?>


<style>
.stepHeader{
    margin-left:0!important;
    width: 100%!important;
}
.stepHeader .pull_r{
    margin:0 auto;
}
.panel-block{
    width: 100%;
    display: block;
    margin: 0 auto;
    /*box-shadow: 0 3px 6px #33333340;*/
    margin-bottom: 15px;
}
.panel-block-title{
    padding: 15.5px;
    font-size: 18px;
    text-transform: uppercase;
    color: #ffffff;
    background:#2986C8;
    letter-spacing: 2px;
    font-weight: 600;
    margin-top: 0px;
}
.panel-block-body{
    padding: 15px 0;
}
.panel-block-label{
    text-align: left;
    position: relative;
    display: block;
    width: 100%;
    margin-bottom: 15px;
}
.panel-heading-italic{
    font-weight: 500;
    font-style: italic;
    margin-bottom: 15px;
    border-bottom: 1px solid #33333340;
    width: 100%;
    padding-bottom: 15px;
    text-align: left;
}
.panel-block-row, .file-uploader{
    padding: 15px;
    padding-left: 0;
}
.file-uploader{
    display: table;
    width: 102%;
    background: #33333340;
    margin-bottom: 15px;
}
.file-uploader input, .file-uploader button{
    display: inline-block;
    float: left;
    height: 40px;
}
.file-uploader input{
    width:75%;
    padding: 9px;
}
.file-uploader button{
    width: 25%;
}
.form-checkbox{
    text-align: left;
    width: 100%;
}
.btn{
    height: 40px;
    font-weight: 600;
    border-radius: 0;
}
.btn-blue{
    background: #2986C8;
    color: #ffffff;
}
.btn-rd-green{
    height: 50px;
    width: 50px;
    min-width: 0;
    background: #2986C8;
    color: #ffffff;
    border-radius: 50%;
}
.btn-holder-inline{
    text-align: left;
}
.btn-holder-inline button{
    display: inline-block;
}
.grp-float-right{
    display: inline-block;
    float: right;
    padding: 0 15px;
}
.icon{
    height:16px;
    width: 16px;
    display: inline-block;
    background-size: cover!important;
    margin-right: 8px;
}
.icon-only{
    height:22px;
    width: 22px;
    display: inline-block;
    background-size: cover!important;
}
.icon-plus{
    background: url(<?= $this->template->Images() ?>registration/icon-plus.svg);
}
.icon-arrow-back{
    background: url(<?= $this->template->Images() ?>registration/icon-arrow-back.svg);
}
.icon-check{
    background: url(<?= $this->template->Images() ?>registration/icon-check.svg);
}
.icon-file-upload{
    background: url(<?= $this->template->Images() ?>registration/icon-upload.svg);
}
@media screen and (max-width:1199px){
    .panel-block{
        width:100%;
    }

    .panel-block-title{
        margin-left:1px;
        width: 100% !important;
    }
}
@media screen and (max-width:991px){
    .file-uploader input{
        width:60%;
    }
    .file-uploader button{
        width: 40%;
    }
    .buttom-panel{
        width: 99.75% !important;
    }
}
@media screen and (max-width:767px){
    .file-uploader input{
        width:102%;
    }
    .file-uploader button{
        width: 91%;
    }

    .panel-block-row, .file-uploader{
        padding: 15px;
    }

}

.showRiskDiscloser{font-weight: 600;
    color: #2988ca;}

.error_not_checked{border: 2px solid red;
    padding: 2px 25px}

#tab_account_file_registraion_box{
  /* border: 1px solid #2986C8;*/
    margin-bottom: 10px;
    width: 100%;}
.alert-success-blue{ background-color:#85C7F3;}

.btn-input{
	height: auto;
	padding: 0px 12px;
	border-radius: 0px;
	margin-right: 7px;
}

.alert-success{
    width: 102%;
}

.alert{
    border-radius: 0;
}

 
	button:focus { outline: none !important; }
 

</style>    

<?php 
$level_one=0;
$level_two=0;

?>
 
            <div class="form-horizontal personal" id="tab_account_file_registraion_box">
                <div class="panel-block">
                    <h2 class="panel-block-title"><?=lang('pro_up_doc_1');?> </h2>


                    <div class="panel-block-body obligatorypanelbody">
                        
                        
                        <div class="panel-block-row row_file_upload_box">
                            <label for="" class="panel-block-label"><?=lang('pro_up_doc_2');?> <span class="icon icon-help"></span></label>
                            
                            
                                
                            
                            <div class="succs_error_mgs succs_error_mgs_obligator_file_1_1">
                                
                                <?php 
                                 
                                $user_doc_files="";
                                
                                if(!empty($user_doocument_data['level_one_first']))
                                {
                                    $user_doc_files=$user_doocument_data['level_one_first']->file_name;
                                    
                                ?>
                                     <div class="alert alert-success"><?=lang('pro_up_doc_3');?>
                                         <a href="https://my.forexmart.com//assets/user_docs/<?=$user_doc_files?>" 
                                 target="_blank"><?=lang('pro_up_doc_4');?></a> <?=lang('pro_up_doc_5');?></div>
                            
                                
                                
                                <?php } ?>
                               
                                
                                
                            </div>
                            <div class="file-uploader">
                                <label class="btn"><span class="btn-default btn-input"><?= lang('boo_str_01'); ?></span><span class="showFileName"><?= $user_doc_files ? 'The file was Uploaded' : lang('boo_str_02'); ?></span>
								<input type="hidden"  class="uploaded_file"  name="uploaded_file[]" value="<?=$user_doc_files?>"/>
                                <input type="file" class="fileupload pull-left"  name="font_side_copy" doc_number="1" level="1" mgs="succs_error_mgs_obligator" style="display: none;"></label>
                                <button  type="button" class="btn btn-blue uploadbuttonbox pull-right"><span class="icon icon-file-upload"></span><?=lang('pro_up_doc_6');?></button>
                            </div>
                            <p><?=lang('pro_up_doc_7');?></p>
                        </div>
                        
                        
                        
                        
                        
                        <div class="panel-block-row row_file_upload_box">
                            <label for="" class="panel-block-label"><?=lang('pro_up_doc_8');?> <span class="icon icon-help"></span></label>
                            <div class="succs_error_mgs succs_error_mgs_obligator_file_1_2" >
                                
                                <?php 
                                 
                                $user_doc_files="";
                                
                                if(!empty($user_doocument_data['level_one_second']))
                                {
                                    $user_doc_files=$user_doocument_data['level_one_second']->file_name;
                                    
                                ?>
                                     <div class="alert alert-success"> <?=lang('pro_up_doc_9');?>
                                         <a href="https://my.forexmart.com//assets/user_docs/<?=$user_doc_files?>" 
                                 target="_blank"><?=lang('pro_up_doc_4');?></a><?=lang('pro_up_doc_10');?> </div>
                            
                                
                                
                                <?php } ?>
                                
                                
                            </div>
                            <div class="file-uploader">
                                <label class="btn"><span class="btn-default btn-input"><?= lang('boo_str_01'); ?></span><span class="showFileName"><?= $user_doc_files ? 'The file was Uploaded' : lang('boo_str_02'); ?></span>
                                <input type="hidden"  class="uploaded_file"  name="uploaded_file[]" value="<?=$user_doc_files?>"/>
                                <input type="file" class="fileupload pull-left"  name="back_side_copy"  doc_number="2" level="1" mgs="succs_error_mgs_obligator" style="display: none;"></label>
                                <button  type="button" class="btn btn-blue uploadbuttonbox pull-right"><span class="icon icon-file-upload"></span><?=lang('pro_up_doc_6');?></button>
                            </div>
                        </div>
                        
                        <div class="additional_obligatory">
                            
                             <?php 
                                 
                                $user_doc_files="";
                                
                                if(!empty($user_doocument_data['level_one_additional']))
                                {
                                    $inc=1;
                                    $doc_number=3;
                                    
                                    foreach($user_doocument_data['level_one_additional'] as $key=>$val)
                                    {
                                         
                                     $level_one=$inc;   
                                 ?>
                                    
                                        <div class="panel-block-row additional row_file_upload_box">
                                            <label for="" class="panel-block-label"> <?=$inc;?>. <?=lang('pro_up_doc_11');?>
                                                <span class="icon icon-help"></span>
                                            </label>
                                            <div class="succs_error_mgs succs_error_mgs_obligator_file_1_<?=$doc_number?>">
                                            
                                            
                                              <div class="alert alert-success"> <?=lang('pro_up_doc_3');?>
                                                        <a href="https://my.forexmart.com//assets/user_docs/<?=$val->file_name?>" 
                                                target="_blank"><?=lang('pro_up_doc_4');?></a> <?=lang('pro_up_doc_5');?></div>

                                
                                            
                                            </div> 
                                            <div class="file-uploader">
												<label class="btn"><span class="btn-default btn-input"><?= lang('boo_str_01'); ?></span><span class="showFileName"><?= $val->file_name ? 'The file was Uploaded' : lang('boo_str_02'); ?></span>
                                                <input type="hidden" class="uploaded_file" name="uploaded_file[]" value="<?=$val->file_name?>">
                                                <input class="fileupload pull-left"  type="file" name="additional_copy" doc_number="<?=$doc_number?>" level="1" mgs="succs_error_mgs_obligator" style="display: none;"></label>
                                                <button type="button" class="btn btn-blue uploadbuttonbox pull-right">
                                                    <span class="icon icon-file-upload"></span><?=lang('pro_up_doc_6');?>
                                                </button>
                                            </div> 
                                        </div>
                            
                            
                            
                            
                            
                                    <?php 
                                    
                                     $inc++;
                                    $doc_number++;
                                    
                                    
                                    } }  ?>
                        </div>
                        
                        
                        <?php 
                        if($level_one<10)
                        {
                        ?>
                        <div class="grp-float-right">
                            <label for=""><?=lang('pro_up_doc_12');?></label>
                            <button type="button" id="additional_obligatory" class="btn btn-rd-green"><span class="icon-only icon-plus"></span></button>
                        </div>
                       
                        <?php } ?>
                        
                        <div class="clearfix"></div>
                    </div>
                    
                    
                    
                    
                  <div class="alert alert-success-blue note1">
                    <p class="one-text">
                        <?=lang('pro_up_doc_13');?>  </p>
                    <div class="col-sm-3">
                        <ul class="requires">
                            <li><i class="fa fa-caret-right" style="color: #ff0000;"></i>
                                <?=lang('pro_up_doc_14');?>                            </li>
                            <li><i class="fa fa-caret-right" style="color: #ff0000;"></i>
                                <?=lang('pro_up_doc_15');?>                         </li>
                            <li><i class="fa fa-caret-right" style="color: #ff0000;"></i>
                                <?=lang('pro_up_doc_16');?>                           </li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="requires">
                            <li><i class="fa fa-caret-right" style="color: #ff0000;"></i>
                                 <?=lang('pro_up_doc_17');?>                          </li>
                            <li><i class="fa fa-caret-right" style="color: #ff0000;"></i>
                                  <?=lang('pro_up_doc_18');?>                          </li>
                            <li><i class="fa fa-caret-right" style="color: #ff0000;"></i>
                                   <?=lang('pro_up_doc_19');?>                         </li>
                        </ul>
                    </div><div class="clearfix"></div>
                </div>  
                    
                    
                </div>
                
                
                
                
                
                
                
                
                <div class="panel-block">
                    <h2 class="panel-block-title buttom-panel"><?=lang('pro_up_doc_21');?> </h2>
                    
                    <div class="panel-block-body residencepanelbody">
                        <div class="panel-block-row row_file_upload_box">
                            <label for="" class="panel-block-label"><?=lang('pro_up_doc_22');?>  <span class="icon icon-help"></span></label>
                            <div class="succs_error_mgs succs_error_mgs_residence_file_2_1">
                                
                                     <?php 
                                 
                                $user_doc_files="";
                                
                                if(!empty($user_doocument_data['level_two_first']))
                                {
                                    $user_doc_files=$user_doocument_data['level_two_first']->file_name;
                                    
                                ?>
                                     <div class="alert alert-success"><?=lang('pro_up_doc_23');?>
                                         <a href="https://my.forexmart.com//assets/user_docs/<?=$user_doc_files?>" 
                                 target="_blank"><?=lang('pro_up_doc_4');?> </a><?=lang('pro_up_doc_5');?> </div>
                            
                                
                                
                                <?php } ?>
                                                               
                                
                            </div>                            
                            
                            <div class="file-uploader">
                                <label class="btn"><span class="btn-default btn-input"><?= lang('boo_str_01'); ?></span><span class="showFileName"><?= $user_doc_files ? 'The file was Uploaded' : lang('boo_str_02'); ?></span>
                                <input type="hidden"  class="uploaded_file"  name="uploaded_file[]" value="<?=$user_doc_files?>"/>
                                <input class="fileupload pull-left"  type="file" name="residence_side_copy"  doc_number="1" level="2" mgs="succs_error_mgs_residence" style="display: none;"></label>
                                <button  type="button" class="btn btn-blue uploadbuttonbox pull-right"><span class="icon icon-file-upload"></span><?=lang('pro_up_doc_6');?></button>
                            </div>
                            <p><?=lang('pro_up_doc_24');?> </p>
                        </div>
                         <div class="additional_residence">
                            
                              
                              <?php 
                                 
                                $user_doc_files="";
                                
                                if(!empty($user_doocument_data['level_two_additional']))
                                {
                                    $inc=1;
                                    $doc_number=2;
                                    
                                    foreach($user_doocument_data['level_two_additional'] as $key=>$val)
                                    {
                                         
                                      $level_two=$inc;  
                                 ?>
                                    
                                     <div class="panel-block-row additional row_file_upload_box">
                                         <label for="" class="panel-block-label"><?=$inc;?>. <?=lang('pro_up_doc_11');?>
                                             <span class="icon icon-help"></span>
                                         </label>
                                         <div class="succs_error_mgs succs_error_mgs_residence_file_2_<?=$doc_number?>">
                                         
                                         
                                              <div class="alert alert-success"> <?=lang('pro_up_doc_9');?>
                                                        <a href="https://my.forexmart.com//assets/user_docs/<?=$val->file_name?>" 
                                                target="_blank"><?=lang('pro_up_doc_4');?> </a> <?=lang('pro_up_doc_5');?> </div>

                                
                                         
                                         
                                         </div> 
                                         <div class="file-uploader">
											<label class="btn"><span class="btn-default btn-input"><?= lang('boo_str_01'); ?></span><span class="showFileName"><?= $val->file_name ? 'The file was Uploaded' : lang('boo_str_02'); ?></span>
                                             <input type="hidden" class="uploaded_file" name="uploaded_file[]" value="<?=$val->file_name?>">
                                             <input class="fileupload pull-left"  type="file" name="additional_copy" doc_number="<?=$doc_number?>" level="2" mgs="succs_error_mgs_residence" style="display: none;"></label>
                                             <button type="button" class="btn btn-blue uploadbuttonbox pull-right">
                                                 <span class="icon icon-file-upload"></span><?=lang('pro_up_doc_6');?>
                                             </button> 
                                         </div> 
                                     </div>
                            
                            
                            
                                    <?php 
                                    
                                     $inc++;
                                    $doc_number++;
                                    
                                    
                                    } }  ?>
                             
                             
                             
                             
                             
                             
                             
                            
                          </div>
                            
                            
                            
                             <?php 
                            
                              if($level_two<10)
                              {
                             ?>
                        
                            <div class="grp-float-right">
                                <label for=""><?=lang('pro_up_doc_12');?></label>
                                <button class="btn btn-rd-green" type="button" id="additional_residence"  ><span class="icon-only icon-plus"></span></button>
                            </div>
                        
                              <?php } ?>
                        
                            <div class="clearfix"></div>
                        
                     
                    </div>
                    
                    
                    
                    <div class="alert alert-success-blue note1">
                    <p class="one-text">
                        <?=lang('pro_up_doc_25');?>  <br><br>
                        <?=lang('pro_up_doc_26');?>    </p>
                    
        
                    
                    <div class="col-sm-12">
                        <ul class="requires">
                            <li><i class="fa fa-caret-right" style="color: #ff0000;"></i>
                                 <?=lang('pro_up_doc_27');?>                            </li>
                            <li><i class="fa fa-caret-right" style="color: #ff0000;"></i>
                                 <?=lang('pro_up_doc_28');?>                            </li>
                            <li><i class="fa fa-caret-right" style="color: #ff0000;"></i>
                                <?=lang('pro_up_doc_29');?>                           </li>
                        </ul>
                    </div><div class="clearfix"></div>
                </div>
                    
                    
                    
                    
                </div>
                
            </div>
 

<script>
    
    
var empty_file_mgs='<div class="alert alert-danger"> <?= lang('pro_up_doc_30');?> </div>';
var wrong_file_mgs='<div class="alert alert-danger"> <?= lang('pro_up_doc_31');?> </div>';
var large_file_mgs='<div class="alert alert-danger"> <?= lang('pro_up_doc_32');?>  <strong> <?= lang('pro_up_doc_33');?> </strong></div>';

var upload_loading_file_mgs='<div class="alert alert-info"><img src="<?= $this->template->Images() ?>t_loading.gif"/><br><?= lang('pro_up_doc_34');?> </div>';

var forexmart = "<?php echo FXPP::ajax_url(); ?>";      
var pblc = [];    
    
    
    
    
$(document).on("click", ".showRiskDiscloser", function () {
        $("#myModal").modal('show');
});   
    
   
    
$(document).on("click","#additional_obligatory",function(){    
  var number_addtional=($(".additional_obligatory").find(".additional").length)+1;  
  var doc_number=(number_addtional+2);
  addmoreObligatory(number_addtional,doc_number);
  
  checkMoreButtton(this,number_addtional);
}) ;
    

  $(document).on("click","#additional_residence",function(){    
    var number_addtional=($(".additional_residence").find(".additional").length)+1;  
    var doc_number=(number_addtional+1);
    addmoreResidence(number_addtional,doc_number);
    
      checkMoreButtton(this,number_addtional);
}) ;
      
  
function checkMoreButtton(obj,number_addtional)
{
    if(number_addtional>=10){
    $(obj).parents(".grp-float-right").remove();
    }
}  
  
   
    
 function addmoreObligatory(number_addtional,doc_number)
{
      
    
    var additional_obligatory='<div class="panel-block-row additional row_file_upload_box">'+
                                '<label for="" class="panel-block-label">'+number_addtional+'.  <?= lang('pro_up_doc_11');?>  <span class="icon icon-help"></span></label>'+
                                '<div class="succs_error_mgs succs_error_mgs_obligator_file_1_'+doc_number+'" ></div>'+
                               ' <div class="file-uploader"><label class="btn"><span class="btn-default btn-input"><?= lang('boo_str_01'); ?></span><span class="showFileName"><?= $user_doc_files ? 'The file was Uploaded' : lang('boo_str_02'); ?></span>'+
                                    '<input type="hidden"  class="uploaded_file"  name="uploaded_file[]" value=""/>'+
                                    '<input class="fileupload pull-left"  type="file" name="additional_copy"  doc_number="'+doc_number+'" level="1" mgs="succs_error_mgs_obligator" style="display: none;"></label>'+
                                    '<button  type="button" class="btn btn-blue uploadbuttonbox pull-right"><span class="icon icon-file-upload"></span><?= lang('pro_up_doc_6');?></button>'+
                               ' </div>'+                              
                           ' </div>'; 
        
    $(".additional_obligatory").append(additional_obligatory); 
    
}   
    



     
    
function addmoreResidence(number_addtional,doc_number)
{
    
    
    
        var additional_obligatory='<div class="panel-block-row additional row_file_upload_box">'+
                                '<label for="" class="panel-block-label">'+number_addtional+'. <?= lang('pro_up_doc_11');?> <span class="icon icon-help"></span></label>'+
                                '<div class="succs_error_mgs succs_error_mgs_residence_file_2_'+doc_number+'" ></div>'+
                               ' <div class="file-uploader"><label class="btn"><span class="btn-default btn-input"><?= lang('boo_str_01'); ?></span><span class="showFileName"><?= $user_doc_files ? 'The file was Uploaded' : lang('boo_str_02'); ?></span>'+
                               '<input type="hidden" class="uploaded_file" name="uploaded_file[]" value=""/>'+
                                    '<input class="fileupload pull-left"  type="file" name="additional_copy"  doc_number="'+doc_number+'" level="2"  mgs="succs_error_mgs_residence" style="display: none;"></label>'+
                                    '<button type="button" class="btn btn-blue uploadbuttonbox pull-right"><span class="icon icon-file-upload"></span><?= lang('pro_up_doc_6');?></button>'+
                               ' </div>'+                              
                           ' </div>'; 
        
        
        
    $(".additional_residence").append(additional_obligatory);   
    
    
}   
    
    
 

$(document).on('change', ".fileupload", function (e) 
{
    
    
    var file_obj=this.files[0];
    var name=file_obj.name;
    var file_size= this.files[0].size/1024/1024 ;//file_obj.size;
    var type=file_obj.type;
    var validImageTypes = ["image/jpg", "image/jpeg", "image/png", "image/gif","application/pdf"]; 
    
     $(this).parents(".row_file_upload_box").find(".succs_error_mgs").html("");
    
        if(type){
     type=type.toLowerCase();
 }
          
    
   if(validImageTypes.indexOf(type)<0)
   {       
       
          $(this).val("");
          $(this).parents(".row_file_upload_box").find(".succs_error_mgs").html(wrong_file_mgs);    
          e.preventDefault();    
          return false;
       
   }
   
  
  if(file_size>5)
  {
      $(this).val("");
       $(this).parents(".row_file_upload_box").find(".succs_error_mgs").html(large_file_mgs);    
          e.preventDefault();    
          return false;
      
  }

        
        $(this).parent('label').find('.showFileName').html(name);

   
});   
  


 function getExtension(filename) {
  var parts = filename.split('.');
  return parts[parts.length - 1];
}






$(document).on('click', ".uploadbuttonbox", function (e) 
{
    
    var file_val=$(this).parents(".file-uploader").find(".fileupload").val();
 
    var type=getExtension(file_val);
    var validImageTypes = ["jpg", "jpeg", "png", "gif","pdf"]; 
    var error_obj= $(this).parents(".row_file_upload_box").find(".succs_error_mgs");
    
    error_obj.html("");   
     
    if(file_val.length<1)
    {          
        
          error_obj.html(empty_file_mgs);    
          e.preventDefault();    
          return false;
    }
     
        if(type){
            type=type.toLowerCase();
        }
        
 
   
    if(validImageTypes.indexOf(type)<0) 
    {
           $(this).parents(".file-uploader").find(".fileupload").val("");
            error_obj.html(wrong_file_mgs);    
            e.preventDefault();    
            return false;

    }



    
   
   
/*-------------------- if all validation okay then go to save image----------------------------*/   

var uploaded_file_obj=$(this).parents(".file-uploader").find(".uploaded_file");

var file_get_obj=$(this).parents(".file-uploader").find(".fileupload");

var file_name=file_get_obj.attr("name");
var doc_number=file_get_obj.attr("doc_number");
var file_level=file_get_obj.attr("level");
var title_name=file_get_obj.attr("mgs");


 error_obj.html(upload_loading_file_mgs);



var temp_file_identy=title_name+"_file_"+file_level+"_"+doc_number;

            
        var file_data = file_get_obj.prop("files")[0];
        var fileType = file_data["type"];

            var myFormData = new FormData();
            myFormData.append('file', file_data);
            myFormData.append('doc_type', doc_number);
            myFormData.append('level', file_level);
            pblc['request'] = $.ajax({
                url: forexmart + 'profile/upload_user_documents/' + $.now(),
                type: 'POST',
                processData: false, // important
                contentType: false, // important
                cache: false,
                dataType: 'json',
                data: myFormData
            });
            pblc['request'].done(function (response) {
                if (response.error) {
                    if (response.msgError === '<p><?= lang('pro_up_doc_35');?></p>' && response.msgError_ext === false) {
                        var rtnError = '<?= lang('reg_wr_02'); ?>';
                    } else {
                        var rtnError = response.msgError;
                    }
                   error_obj.html('<div class="alert alert-danger">' + rtnError + '</div>');
                    
                    
                    
                } else {


                  //  $('input[name=document_1]').val(response.doc_filename);
                    error_obj.html('<div class="alert alert-success"><?= lang('reg_wr_03'); ?> <a href="https://my.forexmart.com/assets/user_docs/'+response.showsinglevalue+'" target="_blank"><?=lang("pro_up_doc_4");?></a></div>');
                    

                    uploaded_file_obj.val(response.doc_filename);                    

                 
          
                }
            });
            pblc['request'].fail(function (jqXHR, textStatus) {

            });
   

});



 
    
    
</script>    







