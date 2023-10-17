<?php $uri = $this->uri->segment(2);?>
<style type="text/css">
    .arabic-my-profile-main-tab>li{
        margin-bottom: 5px;
    }
</style>
<link href="<?= $this->template->Css()?>jquery.fileupload.css" rel="stylesheet">
<h1>
    <?=lang('mfn_00');?>
</h1>
<div class="acct-tab-holder">
    <ul role="tablist" class="main-tab arabic-main-tab arabic-my-profile-main-tab">
        <li><a id="pnav1" style="height: 50px;" href="<?= FXPP::loc_url('my-account');?>" class="<?=($active_sub_tab == 'personal-details') ? 'acct-active' : '';?>"><i class="fa fa-user"></i>
                <?=lang('mfn_01');?>
            </a></li>

        <?php
          if( isset($data['account_type_status']->corporate_acc_status) && $data['account_type_status']->corporate_acc_status==2 ){ ?>
              <li role="">
                  <a id="pnav1"  style="height: 50px;" href="<?= FXPP::loc_url('profile/company-details');?>" class="<?=($active_sub_tab == 'company-details') ? 'acct-active' : '';?>"><i class="fa fa-user"></i>
                      <?=lang('cmp_dtls_01');?>
                  </a>
              </li>
          <?php }
        ?>


        <li><a id="pnav2" style="height: 50px;" href="<?= FXPP::loc_url('profile/change-password');?>" class="<?=($active_sub_tab == 'change-password') ? 'acct-active' : '';?>"><i class="fa fa-lock"></i>
                <?=lang('mfn_02');?>
            </a></li>
        
        <?php if(!FXPP::auto_verified()){ ?>
             <li><a id="pnav3" style="height: 50px;" href="<?=FXPP::loc_url('profile/upload-documents');?>" class="<?=($active_sub_tab == 'account-verification') ? 'acct-active' : '';?>"><i class="fa fa-check"></i>
                <?=lang('mfn_03');?>
            </a></li>
        <?php }?>

        <?php //$this->load->library('IPLoc', null); if(IPLoc::Office()){ ?>
            <li role="presentation" style="display:<?php echo ($this->session->userdata('corporate_acc_status') !=0)?'block':'none'?>" >
                <a id="pnav5" style="height: 50px;" href="<?=FXPP::loc_url('profile/upload-documents-for-corporate-account');?>" class="<?=($active_sub_tab == 'corporate-account-verification') ? 'acct-active' : '';?> " ><i class="fa fa-check"></i>
                    <?=lang('mfn_05');?>
                </a>
            </li>
        <?php // }?>
            <?php if(IPLoc::Office_and_Vpn()){ ?>
            <li><a id="pnav4" style="height: 50px;" href="<?=FXPP::loc_url('profile/sms_security');?>" class="<?=($active_sub_tab == 'sms-security') ? 'acct-active' : '';?>"><i class="fa fa-check"></i>
                    <?=lang('mfn_006');?>
                </a></li>
        <?php }?>

        <li role="presentation" class="last-c">
            <a style="height: 50px;" href="#" class="<?=($active_sub_tab == 'tfa-security') ? 'acct-active' : '';?>">
                <i class="fa fa-shield"></i> <?=lang('mfn_08');?>
            </a>
        </li>

        <!-- //FXMAIN-46: Temporary Hide
        <li role="presentation" class="last-c">
            <a style="height: 50px;" href="<?//=FXPP::loc_url('profile/two-factor-authentication');?>" class="<?//=($active_sub_tab == 'tfa-security') ? 'acct-active' : '';?>">
                <i class="fa fa-shield"></i> <?//=lang('mfn_08');?>
            </a>
        </li>
        -->

<!--        <li><a href="--><?php //echo base_url();?><!--profile/vps" class="--><?//=($active_sub_tab == 'vps') ? 'acct-active' : '';?><!--"><i class="fa fa-share-alt"></i> VPS</a></li>-->
    </ul><div class="clearfix"></div>
</div>

<style type="text/css">
.main-tab li a{
    align-items: center;
    display: flex;
}
    ul.main-tab li {
        width: auto;
    }
    @media screen and (max-width: 1200px) {
        ul.main-tab li{
            width: 100%;
            float: none;
            margin: 1px;

        }
        ul.main-tab li a{
            text-align: center;
        }
    }
    @media screen and (max-width: 1200px) {
        ul.main-tab li:lang(es){
            width: 100%;
            float: none;
            margin: 1px;

        }
        ul.main-tab li a:lang(es){
            text-align: center;
        }
    }
</style>
<script type="text/javascript">

    var pnavhighheight=0;
    var pnav1=0;
    var pnav2=0;
    var pnav3=0;
    var pnav4=0;


    $(window).load(function() {
        pnav1 = parseFloat($('#pnav1').height());
        pnav2 = parseFloat($('#pnav2').height());
        pnav3 = parseFloat($('#pnav3').height());
        pnav4 = parseFloat($('#pnav4').height());

        if(isNaN(pnav4)){
            pnav4=0;
        }
        pnavhighheight=parseFloat(Math.round(Math.max(pnav1,pnav2,pnav3,pnav4)));
        $('#pnav1').height(pnavhighheight);
        $('#pnav2').height(pnavhighheight);
        $('#pnav3').height(pnavhighheight);
        $('#pnav4').height(pnavhighheight);


    });
    $(window).resize(function() {
        pnav1 = parseFloat($('#pnav1').height());
        pnav2 = parseFloat($('#pnav2').height());
        pnav3 = parseFloat($('#pnav3').height());
        pnav4 = parseFloat($('#pnav4').height());

        if(isNaN(pnav4)){
            pnav4=0;
        }
        pnavhighheight=parseFloat(Math.round(Math.max(pnav1,pnav2,pnav3,pnav4)));
        $('#pnav1').height(pnavhighheight);
        $('#pnav2').height(pnavhighheight);
        $('#pnav3').height(pnavhighheight);
        $('#pnav4').height(pnavhighheight);

    });
</script>