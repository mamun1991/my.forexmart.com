 <?php  
   $this->load->library('Social');





// if(IPLoc::IPOnlyForTq()) {
//     print_r($social_data);
//     echo 'test';
//
// }
          
  $fb_login_url =FXPP::fbLoginUrl($social_data);   
   $google_login_url = FXPP::googleLoginUrl($social_data);



                                                
?>
<span class="orsighuptext"><?=lang("auth_part_client_mesg_07");?></span>
<div class="social_login_button_box">
    <a title="Click facebook button" href="<?=isset($fb_login_url)?$fb_login_url:'#'?>" class="social_login_button_fb etest">
<img src="<?= $this->template->Images()?>facebook_login.png" class="img-responsive forFirefox">
</a>
    
  
<a title="Click google button"  href="<?=isset($google_login_url)?$google_login_url:'#'?>" class="social_login_button_google">
<img src="<?= $this->template->Images()?>google_login.png" class="img-responsive forFirefox"></a>
   
</div>
<style>

    .forFirefox {
        margin: 0px auto;
    }
.social_login_button_box{width: 100%; float: left; text-align: center; padding: 10px; }
.social_login_button_fb{width: 48%; float:left;text-align: -webkit-center;} 
.social_login_button_google{width: 48%; float:right;text-align: -webkit-center;} 
.orsighuptext{    text-align: center; width: 100%;  font-weight: bold; font-size: 15px;  float: left;  padding-top: 10px; color: white}
.social_login_button_box a:hover img{opacity: 0.5;}

</style>
