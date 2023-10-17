<div  id="account_verification_modal" class="modal fade account_verification_modal in" data-keyboard="false" data-backdrop="static" style="display: none;" aria-hidden="false"><div class="modal-backdrop fade in" style="height: 770px; "></div>
     
    <div class="modal-dialog center">
        <div class="modal-content">
            <div class="modal-header" id="account_verification_modal_header">
                <img src="https://www.forexmart.com/assets/images/fxmart_white_logo.png" class="white-logo">
                
                <b title="Close the modal"  id="account_verification_modal_cloese"> 
                       <img src="<?= base_url('/assets/images/close-red.png')?>" >
                </b>
                
            </div>			
            <div class="modal-body modal_main_body_place">
                <h3 class="top-h3" style="text-align: center;"><span style="color: #2f8cc7; font-weight: bold;"> <b style='color:red' id="account_verification_modal_status_text"> loading....</b></span></h3>
               
                <p class="cls-p account_verification_modal_mgs" id="account_verification_modal_mgs_paragraph">
                     loading....
                </p>
                 
                 <button class="btn-continue leftsite account_verification_modal_button account_verification_modal_mgs_btn"  id="account_verification_modal_mgs_btn_veri"> loading....</button>                         
                
                 <div style="clear: both; float: none; min-height: 1px;"></div>
             </div>            
			
        </div>
    </div>
</div>

<style>

<?php if(in_array(FXPP::html_url(), array('sa', 'pk'))){ //FXMAIN-69?>
.modal-backdrop {
    z-index: 0;
}
<?php } ?>
 
#account_verification_modal{ font-family: Open Sans !important;} 
.account_verification_modal p {
    font-size: 16px;
   /* text-align: center !important;*/
    color: #333;
    font-weight: normal;
    margin: 0px;
    padding: 20px;
 font-family: Open Sans !important;
}

.account_verification_modal .leftsite{ cursor: pointer; float: left !important;}
.account_verification_modal .rightsite{ cursor: pointer !important;     float: right !important;}

/*------------------------------*/
.account_verification_modal {
  text-align: center;
  padding: 0!important;

}

.account_verification_modal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -4px;
}
.account_verification_modal .modal-content {
    position: relative;
    background-color: #fff;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 0px solid rgba(0,0,0,.3);
    border-radius: 20px;
    outline: 0;
    -webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5);
    box-shadow: 0 3px 9px rgba(0,0,0,.5);
}

.account_verification_modal .modal-dialog {
  display: inline-block;
  text-align: center;
  vertical-align: middle;
  max-width: 515px;

}
.account_verification_modal .modal-header {
  background-color: #0098da;
  text-align: center;
  padding-left: 20px;
  padding-right: 20px;
  padding-top: 20px;
  padding-bottom: 20px;
  border-top-right-radius: 20px;
  border-top-left-radius: 20px;
}

.account_verification_modal .modal-body{
    padding: 0;
    padding-right: 20px;
    padding-left: 20px;
    padding-bottom: 15px;
    text-align: justify;
font-family: Open Sans !important;
}

.account_verification_modal .modal-body h2,  
.account_verification_modal .modal-body h3{
  color:#222;
}
.account_verification_modal .modal-footer{
  border-top: none;
  
}
.account_verification_modal .modal-backdrop.in {
  background:#fff;
  opacity: 0.6;
}
.account_verification_modal .btn-continue{
    background-color: #0098da;
font-family: Open Sans !important;
    font-size: 16px;
    font-weight: lighter;
    color: #fff;
    padding: 10px 8px;
    text-align: center;
    margin: 0 auto;
    border-radius: 5px;
    margin-top: 10px;
    border: 2px solid #0098da;
    margin: 0px 34.5%;
}

.account_verification_modal .btn-continue:hover{
  border:2px solid #0098da;
/*font-weight: initial;*/
  color:white;
}

.account_verification_modal .btn-takeout{
  background-color: #0098da;
  border:2px solid #0098da;
font-family: Open Sans !important;
  font-size: 16px;
  font-weight: lighter;
  color:#fff;
  padding: 7px 40px;
  text-align: center;
  border-radius: 5px;
 
}

.account_verification_modal .btn-takeout:hover{
  border:2px solid #0098da;
  background-color: #fff;
  color:#0098da;
}

@media screen and (max-width:767px){
 
 .account_verification_modal .modal-header {
  padding-left: 10px;
  padding-right: 10px;
  padding-top: 5px;
  padding-bottom: 5px;
}
.account_verification_modal .modal-body{
  padding: 0;
  padding-right: 15px;
  padding-left: 15px;
  padding-bottom: 15px;
} 
.account_verification_modal .white-logo{
   width:55%;
}
.account_verification_modal .modal-body h2{
  font-size: 18px;
}
.account_verification_modal .modal-body h3{
  font-size: 16px;
}
.account_verification_modal .modal-body p{
  font-size: 12px;
   font-family: Open Sans !important;
}
.account_verification_modal .btn-continue{
  font-size: 12px;
  /*padding: 5px 50px;*/
  border-radius: 5px;
  margin-top: 0px;
   font-family: Open Sans !important;
}

.account_verification_modal .btn-takeout{
  font-size: 12px;
  padding: 5px 20px;;
  margin-top: 0px;
}
.account_verification_modal hr{
  margin-top: 5px;
  margin-bottom: 5px;
}
}
    






#account_verification_modal_cloese{cursor: pointer; float:right;}  
.modal_main_body_place{     padding-bottom: 55px;}    
    
</style>
 
 
<script type="text/javascript">
    
var secret_key ="<?=FXPP::getCiSessionId()?>"; 
var allow_veri_modal_open="<?=(isset($active_sub_tab))?($active_sub_tab=="account-verification")?false:true:true;?>";  
    
var upload_document_url="<?= FXPP::loc_url('profile/upload-documents');?>";    
var user_id="<?=$this->session->userdata('user_id')?>";
  

var account_status_data='<?=json_encode(FXPP::getAccountStatus($this->session->userdata('user_id'),true));?>';
var acc_very_status="doc-veri-"+user_id;   


fxpp_fv=JSON.parse(account_status_data);

//console.log(fxpp_fv);
 
  
$(document).on("click","#account_verification_modal_cloese",function(){
 $("#account_verification_modal").modal('hide');      
});



$(document).on("click","#account_verification_modal_mgs_btn_veri",function(){
    setSecretKeyLocal();
    
    
 window.open(upload_document_url,"_self");   
 $("#account_verification_modal").modal('hide');    

 
});


$(document).ready(function() {
  
  var stored_secret_key=getSecretKeyLocal();
   
   setTimeout(function(){ 
       
   $(".account_verification_modal_button").removeAttr("disabled");
   $(".sidebar_verification_button").removeAttr("disabled");
    
    
    }, 600);

 
 
 
// console.log(stored_secret_key,"==========="+acc_very_status+"==============>",secret_key);

if(stored_secret_key!=secret_key)
{
         setSecretKeyLocal();
 
         
            if(fxpp_fv.accountstatus!=1) 
            { 
                  $("#account_verification_modal_status_text").html(fxpp_fv.accountstatustext);
                
                if(fxpp_fv.accountstatus==2)
                {
                    // declined
                  
                  $("#account_verification_modal_mgs_paragraph").html(fxpp_fv.declined_mgs);
                    $("#account_verification_modal_mgs_btn_veri").html(fxpp_fv.declined_button_text);
                    
                    $("#account_verification_modal").modal('show');   // modal show



                }                
                else if(fxpp_fv.accountstatus==4)
                {
                   // pending and no documenst
                    
                    $("#account_verification_modal_mgs_paragraph").html(fxpp_fv.default_mgs);
                    $("#account_verification_modal_mgs_btn_veri").html(fxpp_fv.default_button_text);
                    
                    $("#account_verification_modal").modal('show');   // modal show



                }
                
//                else if(fxpp_fv.accountstatus==3)
//                {
//                    $("#account_verification_modal_mgs_paragraph").html(fxpp_fv.level_one_mgs);
//                       $("#account_verification_modal_mgs_btn_veri").html(fxpp_fv.level_one_button_text);
//                       
//                      $("#account_verification_modal").modal('show');   // modal show
//
//                }
                



           }
         
          



     }
   



    });


function setSecretKeyLocal(){
    localStorage.setItem(acc_very_status, secret_key);
    
}
function getSecretKeyLocal(){
  return   localStorage.getItem(acc_very_status);    
}


</script> 