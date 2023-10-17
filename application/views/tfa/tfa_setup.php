<?php $this->lang->load('tfa'); ?>
<style type="text/css">
    .txtcode{
        color: #5a5a5a !important;
    }
.manually_title{ text-align: center;
    font-weight: bold;
    color: red;}   
.SecretKey_box{ text-align: centetr}
.manually_setup_box{ display: none}
.barcode_setup_box{display: block}                                    
#manually_setup_box_ctl{ cursor: pointer; color: white;}

.manual-holder{padding: 10px}
.manual-holder p b{margin-right: 20px;}


@media (max-width: 767px){
.modal-dialog {
    width: 600px !important;
    margin: 30px auto !important;
}    
}

@media (max-width: 550px){
.modal-dialog {
    width: 380px !important;
    margin: 15% !important;
}    
}


@media (max-width: 500px){
.modal-dialog {
    width: 330px !important;
    margin: 15% !important;
}    
}

@media (max-width: 450px){
.modal-dialog {
    width: 315px !important;
    margin: 13% !important;
}    
}


@media (max-width: 400px){
.modal-dialog {
    width: 275px !important;
    margin: 10% !important;
}    
}

 

.secratemanulaboxtable{ width: 100%;}
.secratemanulaboxtable thead th.namebox{
    width: 30%;
        text-align: left;
}
.secratemanulaboxtable thead th.signbox{
    width: 5%;
        text-align: center;
}
.secratemanulaboxtable thead th.fieldbox{
    width: 45%;
       text-align: left;
       font-weight: normal
}


</style>

<?php 
$lan_code=array("sa","SA","pk","PK");
$cur_lan_code=FXPP::html_url();

if(in_array($cur_lan_code, $lan_code)){
?>
<style>
    .secratemanulaboxtable thead th.fieldbox{ 
       text-align: right !important; 
}

    .secratemanulaboxtable thead th.namebox{ 
       text-align: right !important; 
}
</style>

<?php }?>

<div class="modal fade" id="step1" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0 step1-dialog">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modal-show-title">
                        <?=lang('tfa_h4');?>
                </h4>
            </div>
            <form id="tfa-setup-form" method="POST" autocomplete="off">
                <div class="modal-body modal-show-body">
                    <div class="row">
                        <div class="col-md-12 step1-cont">
                                <h3><?=lang('tfa_1');?></h3>
                                <p><?=lang('tfa_1_1');?></p>
                                <p><?=lang('tfa_1_2');?></p>
                                <p><?=lang('tfa_1_3');?></p>
                                <h3><?=lang('tfa_2');?></h3>
                      <div class="barcode_setup_box">
                                <p><?=lang('tfa_2_1');?></p>
                                <p><?=lang('tfa_2_2');?></p>
<!--                                 <p><?lang('tfa_2_3');?></p>-->
                            <div class="barcode-holder ">
                                <img src="<?=$QRCodeSrc;?>" />
                            </div>
                      </div>   
                                
                            <p class="manually_title">
                                <button type="button" class="btn btn-primary round-0" id="manually_setup_box_ctl"><?=lang('tfa_2_manul_title');?></button>     
                            </p>
                            <div class="manually_setup_box">
                                    <p> <?=lang('tfa_2_manual_1');?></p>
                                    <p> <?=lang('tfa_2_manual_2');?></p>
                                    <p> <?=lang('tfa_2_manual_3');?></p> 

                                    <div class="manual-holder SecretKey_box">
                                       
                                        <table class="secratemanulaboxtable">
                                            <thead>
                                                <tr>
                                                    <th class="namebox"><?=lang('tfa_2_manual_4');?></th>
                                                    <th  class="signbox">:</th>
                                                    <th class="fieldbox"><?=$_SESSION['account_number']?></th>
                                                </tr>
                                                <tr>
                                                    <th class="namebox"><?=lang('tfa_2_manual_5');?></th>
                                                    <th class="signbox">:</th>
                                                    <th  class="fieldbox"><?=($_SESSION['account_number'])?$QRSecrateCode:'';?></th>
                                                </tr>
                                            </thead>
                                        </table>
                                        
                                   </div>
                            </div>
                            
                            
                             
                                
                            <p id="entercode_message_box">  <?=lang('tfa_2_manual_p');?>   </p>
                            
                            <div class="code-input-holder">
                                <div id="error-container" class="error" style="display: none;"></div>
                                <input onkeyup="this.value=this.value.replace(/[^\d]/,'')" type="text" placeholder="<?=lang('tfa_code');?>" id="tfa_setup_code" name="tfa_setup_code" class="txtcode onlynumberfield">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer round-0">
                        <button type="button" id='tfa-setup-close' class="btn btn-default round-0"><?=lang('tfa_cancel');?></button>
                        <button type="submit" class="btn btn-primary round-0"><?=lang('tfa_vns');?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--<form id="tfa-setup-form" method="POST" action="--><?php //site_url('test/TFASetupVerify'); ?><!--" autocomplete="off">-->
<!--    <input type="text" id="tfa_setup_code" name="tfa_setup_code" class="form-01" autofocus />-->
<!--    <button type="submit" id="tfa-setup-submit">Verify</button>-->
<!--</form>-->



<script>

var show_manual="<?=lang('tfa_2_manul_title');?>";
var show_bar_code="<?=lang('tfa_2_manul_title_2');?>";
var on_qr_code_time="<?=lang('tfa_p');?>";
var on_manual_time="<?=lang('tfa_2_manual_p');?>";

$(document).on("click touch","#manually_setup_box_ctl",function(){
    
    if($(".manually_setup_box").is(":hidden"))
    {
        
        $(".manually_setup_box").show();
        $(".barcode_setup_box").hide();
        $("#manually_setup_box_ctl").html(show_bar_code);
        $("#entercode_message_box").html(on_manual_time);
        
    }else{
        
        $(".manually_setup_box").hide();
        $(".barcode_setup_box").show();
        $("#manually_setup_box_ctl").html(show_manual);
      //  $("#entercode_message_box").html(on_qr_code_time);
      $("#entercode_message_box").html(on_manual_time);
    }
    
    
}) ;   
</script>    


 

            