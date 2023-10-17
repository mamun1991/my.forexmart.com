<div  id="smart_dollar_not_allow_modal" class="modal fade smart_dollar_not_allow_modal in" data-keyboard="false" data-backdrop="static" style="display: none;" aria-hidden="false"><div class="modal-backdrop fade in" style="height: 770px; "></div>
     
    <div class="modal-dialog center">
        <div class="modal-content">
            <div class="modal-header" id="smart_dollar_not_allow_modal_header">
                <img src="https://www.forexmart.com/assets/images/fxmart_white_logo.png" class="white-logo">
                
                <b title="Close the modal"  id="smart_dollar_not_allow_modal_cloese"> 
                       <img src="<?= base_url('/assets/images/close-red.png')?>" >
                </b>
                
            </div>			
            <div class="modal-body modal_main_body_place">
                <h3 class="top-h3" style="text-align: center;"><span style="color: #2f8cc7; font-weight: bold;">
                        <b style='color:red' id="smart_dollar_not_allow_modal_status_text"> Smart Dollars by ForexMart </b></span></h3>
               
                <p class="cls-p smart_dollar_not_allow_modal_mgs" id="smart_dollar_not_allow_modal_mgs_paragraph">
                    Smart Dollar is not available for accounts-participants of Promotion campaigns.
                </p>
                  <p class="cls-p smart_dollar_not_allow_modal_mgs" id="smart_dollar_not_allow_modal_mgs_paragraph_list">
                   Please register new Classic or Cent account.
                </p>
                <div class="action_bution_box">
                 <button class="btn-continue leftsite smart_dollar_not_allow_modal_button smart_dollar_not_allow_modal_mgs_btn btn-gray-smart"  id="smart_dollar_not_allow_modal_mgs_btn_veri"> Close </button>                         
                 <button class="btn-continue leftsite smart_dollar_not_allow_modal_button smart_dollar_not_allow_modal_mgs_btn"  id="smart_dollar_not_allow_modal_mgs_btn_regis"> Register</button>                         
                 </div>
                
                 <div style="clear: both; float: none; min-height: 1px;"></div>
             </div>            
		
        </div>
    </div>
</div>

<style>
 
 
#smart_dollar_not_allow_modal{ font-family: Open Sans !important;} 
.smart_dollar_not_allow_modal p {
    font-size: 16px;
 text-align: center !important; 
    color: #333;
    font-weight: normal;
    margin: 0px;
    padding: 12px;
 font-family: Open Sans !important;
}

.smart_dollar_not_allow_modal .leftsite{ cursor: pointer; float: left !important;}
.smart_dollar_not_allow_modal .rightsite{ cursor: pointer !important;     float: right !important;}

/*------------------------------*/
.smart_dollar_not_allow_modal {
  text-align: center;
  padding: 0!important;

}

.smart_dollar_not_allow_modal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -4px;
}
.smart_dollar_not_allow_modal .modal-content {
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

.smart_dollar_not_allow_modal .modal-dialog {
  display: inline-block;
  text-align: center;
  vertical-align: middle;
  max-width: 515px;

}
.smart_dollar_not_allow_modal .modal-header {
  background-color: #0098da;
  text-align: center;
  padding-left: 20px;
  padding-right: 20px;
  padding-top: 20px;
  padding-bottom: 20px;
  border-top-right-radius: 20px;
  border-top-left-radius: 20px;
}

.smart_dollar_not_allow_modal .modal-body{
    padding: 0;
    padding-right: 20px;
    padding-left: 20px;
    padding-bottom: 15px;
    text-align: justify;
font-family: Open Sans !important;
}

.smart_dollar_not_allow_modal .modal-body h2,  
.smart_dollar_not_allow_modal .modal-body h3{
  color:#222;
}
.smart_dollar_not_allow_modal .modal-footer{
  border-top: none;
  
}
.smart_dollar_not_allow_modal .modal-backdrop.in {
  background:#fff;
  opacity: 0.6;
}

.buttonRed{
    background: red !important;
    border: 1px solid red !important;
}
.smart_dollar_not_allow_modal .action_bution_box{
    text-align: center;
    float: left;
    width: 100%;
}
.smart_dollar_not_allow_modal .btn-continue {

    background-color: #0098da;
    font-family: Open Sans !important;
    font-size: 16px;
    font-weight: lighter;
    color: #fff;
    padding: 10px 8px;
    text-align: center;
    border-radius: 5px;
    margin-top: 10px;
    border: 2px solid #0098da;
    margin: 10px 12% -5px 17%;
}

.smart_dollar_not_allow_modal .btn-continue:hover{
  border:2px solid #0098da;
/*font-weight: initial;*/
  color:white;
}

.smart_dollar_not_allow_modal .btn-takeout{
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

.smart_dollar_not_allow_modal .btn-takeout:hover{
  border:2px solid #0098da;
  background-color: #fff;
  color:#0098da;
}

@media screen and (max-width:767px){
 
 .smart_dollar_not_allow_modal .modal-header {
  padding-left: 10px;
  padding-right: 10px;
  padding-top: 5px;
  padding-bottom: 5px;
}
.smart_dollar_not_allow_modal .modal-body{
  padding: 0;
  padding-right: 15px;
  padding-left: 15px;
  padding-bottom: 15px;
} 
.smart_dollar_not_allow_modal .white-logo{
   width:55%;
}
.smart_dollar_not_allow_modal .modal-body h2{
  font-size: 18px;
}
.smart_dollar_not_allow_modal .modal-body h3{
  font-size: 16px;
}
.smart_dollar_not_allow_modal .modal-body p{
  font-size: 12px;
   font-family: Open Sans !important;
}
.smart_dollar_not_allow_modal .btn-continue{
  font-size: 12px;
  /*padding: 5px 50px;*/
  border-radius: 5px;
  margin-top: 0px;
   font-family: Open Sans !important;
}

.smart_dollar_not_allow_modal .btn-takeout{
  font-size: 12px;
  padding: 5px 20px;;
  margin-top: 0px;
}
.smart_dollar_not_allow_modal hr{
  margin-top: 5px;
  margin-bottom: 5px;
}
}
    


.btn-gray-smart{background: gray !important;
    border: 1px solid gray !important;
    color: white;
    padding: 12px 18px !important;}



#smart_dollar_not_allow_modal_cloese{cursor: pointer; float:right;}  
.modal_main_body_place{     padding-bottom: 55px;}    
    
</style>
 
 
<script type="text/javascript">
var smart_dollar_not_allow="<?=$smart_dollar_not_allow?>";
var secret_key ="<?=FXPP::getCiSessionId()?>"; 
var user_id="<?=$this->session->userdata('user_id')?>";


var account_verification_url="<?= FXPP::loc_url('profile/upload-documents');?>";  
var account_registration_url="<?= FXPP::loc_url('profile/registration');?>"; 
var account_status="<?= FXPP::check_accountstatus();?>"; 



var count_key=0;
var acc_very_status="smart-doller-"+user_id;
var acc_very_status_count="smart-doller-"+user_id+"_count";
secret_key=secret_key+"_"+user_id;

$(document).ready(function() {

  var stored_secret_key=getSecretKeyLocal();

    if(smart_dollar_not_allow){
      //  console.log(stored_secret_key,"===>",secret_key);
        
            if(stored_secret_key==secret_key)
            {
                var stored_secret_key=getSecretKeyLocal(true);
               if(stored_secret_key==0)
               {
                       count_key=count_key+1;
                       setSecretKeyLocal();                  
                       $("#smart_dollar_not_allow_modal").modal('show');    
               }    
               
            }else{
                  count_key=count_key+1;
                  setSecretKeyLocal();                  
                 $("#smart_dollar_not_allow_modal").modal('show');    

            }   
    }
 
})
    
$(document).on("click","#smart_dollar_not_allow_modal_cloese",function(){
 $("#smart_dollar_not_allow_modal").modal('hide');      
});


$(document).on("click","#smart_dollar_not_allow_modal_mgs_btn_veri",function(){
 
 $("#smart_dollar_not_allow_modal").modal('hide');     
 
 
 
});



function setSecretKeyLocal(){
     
    localStorage.setItem(acc_very_status, secret_key);
    localStorage.setItem(acc_very_status_count, count_key);
    
}
function getSecretKeyLocal(count=false){
    if(count){
        return   localStorage.getItem(acc_very_status_count);    
    }else{
    return   localStorage.getItem(acc_very_status);    
    }
}


$(document).on("click","#smart_dollar_not_allow_modal_mgs_btn_regis",function(){
 
 if(account_status){
    window.open(account_registration_url,"_self");  
 }else{
     window.open(account_verification_url,"_self"); 
 }
    
    
}); 
</script> 

