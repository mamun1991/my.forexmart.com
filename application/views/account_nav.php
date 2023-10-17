<style type="text/css">
    .info-box-holder
    {
        margin-top: 15px;
    }
    .panel-blue {
        border-color: #2988ca;
        /*margin-bottom: 0!important;*/
        border-radius: 0px!important;
    }
    .panel-blue > .panel-heading {
        color: #fff;
        background-color: #2988ca;
        border-color: #2988ca;
        /*font-family: Open Sans;*/
        border-radius: 0px!important;
    }
    .panel-blue > .panel-heading:lang(ru) {
        min-height: 100px!important;
    }
    .panel-blue > .panel-heading + .panel-collapse > .panel-body {
        border-top-color: #2988ca;
    }
    .panel-blue > .panel-heading .badge {
        color: #2988ca;
        background-color: #fff;
    }
    .panel-blue > .panel-footer + .panel-collapse > .panel-body {
        border-bottom-color: #2988ca;
    }
    .panel-blue a
    {
        color: #2988ca;
    }
    .huge
    {
        font-size: 26px;
    }
    .partnership-text
    {
        /*font-family: Open Sans;*/
        font-size: 14px;
        color: #333;
    }

    .main-tab li a{
        padding: 5px;
        padding-top: 14px;
    }

    .main-tab li{
        width: calc(100% / 5) !important;
        text-align: center;
    }

    .acct-tab-holder{
        width: 100% !important;
    }
	.info-padding{
        padding: 0 15px;
    }
	.box-gap {
        border-right: 3px solid #fff;
    }
	.panel.panel-blue .fa-5x {
		font-size: 68px;
	}
	.text-padding{    
		padding-right: 5px;
		padding-left: -15px;
	}
	.box-gap-1 {
		width: 30%;
		border-right: 3px solid #fff;
	}
  .box-gap-2 {
	width: 45%;
	border-right: 3px solid #fff;
  }
  .box-gap-3 {
	width: 25%;
  }
  .box-fix {
	float: left;
  }
	@media screen and (max-width: 1120px) and (min-width: 990px)  {
	.huge {
		font-size: 20px;
	} 
	.text-padding {
		font-size: 11px;
	}
  }
  @media screen and (max-width: 860px) and (min-width: 667px)  {
	.huge {
		font-size: 20px;
	} 
	.text-padding {
		font-size: 12px;
	}
  }
  
	@media screen and (max-width: 667px) {
	.box-fix {
		float: none;
	}
	.box-gap-1, .box-gap-2, .box-gap-3 {
		width: 100%;
	}
  }
  
</style>

    <?php $logtype = $this->session->userdata('login_type');
    
    $account_status_data=FXPP::getAccountStatus($this->session->userdata('user_id'),true);
    
    if($logtype ==1){

        //  echo $this->session->userdata('user_id').'<br>'.$this->session->userdata('login_type');?>
        <div class="info-box-holder row">
			<div class="info-padding">
				<div class="box-gap-1 box-fix">
					<div class="panel panel-blue">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-suitcase fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="row">
										<div class="text-padding">
											<div class="huge total-commission">0.00</div>
											<span><?=lang('mya_34');?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="box-gap-2 box-fix">
					<div class="panel panel-blue">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-line-chart fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="row">
										<div class="text-padding">
									<div class="huge total-traded-lots">0.00</div>
									<span><?=lang('mya_35');?></span>
									</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="box-gap-3 box-fix">
					<div class="panel panel-blue">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-user fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="row">
										<div class="text-padding">
									<div class="huge total-referrals">0</div>
									<span><?=lang('mya_36');?></span>
									</div>
								</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>

    <?php } ?>

<div class="acct-tab-holder">

    <ul role="tablist" class="main-tab ul-tab acc_nav arabic-main-tab arabic-my-account-main-tab">

        
            <li style="width: 20%;"><a id="an1" style="height: 50px;" href="<?= FXPP::loc_url('my-account');?>" class="<?=($active_sub_tab == 'accounts') ? 'acct-active' : '';?>"><i class="fa fa-user"></i>
                    <?=lang('mfn_01');?>
                </a></li>


            <?php
            if(FXPP::isCorpDocumentDeclined()){ ?>
                <li role="">
                    <a id="an2"  style="height: 50px;" href="<?= FXPP::loc_url('profile/company-details');?>" class="<?=($active_sub_tab == 'company-details') ? 'acct-active' : '';?>"><i class="fa fa-user"></i>
                        <?=lang('cmp_dtls_01');?>
                    </a>
                </li>
            <?php }
            ?>


            <li style="width: 20%;"><a id="an3" style="height: 50px;" href="<?= FXPP::loc_url('profile/change-password');?>" class="<?=($active_sub_tab == 'change-password') ? 'acct-active' : '';?>"><i class="fa fa-lock"></i>
                    <?=lang('mfn_02');?>
                </a></li>

                
                
                
            <?php if(!FXPP::auto_verified()){ ?>
                <li><a id="an4" style="height: 50px;" href="<?=FXPP::loc_url('profile/upload-documents');?>" class="<?=($active_sub_tab == 'account-verification') ? 'acct-active' : '';?>"><i class="fa fa-check"></i>
                        <?=lang('mfn_03');?>
                    </a></li>
            <?php }?>
                
               
                
                
         

            <?php //$this->load->library('IPLoc', null); if(IPLoc::Office()){ ?>
            <li role="presentation" style="display:<?php echo ($this->session->userdata('corporate_acc_status') !=0)?'block;':'none;'?> width: 20% !important;" >
                <a id="an5" style="height: 50px;" href="<?=FXPP::loc_url('profile/upload-documents-for-corporate-account');?>" class="<?=($active_sub_tab == 'corporate-account-verification') ? 'acct-active' : '';?> " ><i class="fa fa-check"></i>
                    <?=lang('mfn_05');?>
                </a>
            </li>
            <?php // }?>
            <?php if(IPLoc::Office_and_Vpn()){ ?>
                <li style="width: 20%;"><a id="an6" style="height: 50px;" href="<?=FXPP::loc_url('profile/sms_security');?>" class="<?=($active_sub_tab == 'sms-security') ? 'acct-active' : '';?>"><i class="fa fa-check"></i>
                        <?=lang('mfn_006');?>
                    </a></li>
            <?php }?>
                    
           
                    
                    
            <li role="presentation" id="last-c" class="last-c" style="width: 20%;">
                <a id="an7" style="height: 50px;" href="<?=FXPP::loc_url('profile/two-factor-authentication')?>" class="<?=($active_sub_tab == 'tfa-security') ? 'acct-active' : '';?>">
                    <i class="fa fa-shield"></i> <?=lang('mfn_08');?>
                </a>
            </li>

                    
                    

            <!-- FXMAIN-46: Temporary hide
            <li role="presentation" class="last-c" style="width: 20%;">
                <a id="an7" style="height: 50px;" href="<?//=FXPP::loc_url('profile/two-factor-authentication');?>" class="<?//=($active_sub_tab == 'tfa-security') ? 'acct-active' : '';?>">
                    <i class="fa fa-shield"></i> <?//=lang('mfn_08');?>
                </a>
            </li>
            -->



        <?php if(!$this->session->userdata('login_type')){?>


              <!--  <li role="presentation" class="account-sub-tab">
                    <a id="an1" href="<?//= FXPP::loc_url('my-account');?>" class="<?//=($active_sub_tab == 'accounts') ? 'acct-active' : '';?>"><i class="fa fa-user"></i>
                        <?//=lang('man_00');?>
                    </a>
                </li>
                <li role="presentation">
                    <a id="an2" href="<?//= FXPP::loc_url('my-account/current-trades');?>" class=" <?//=($active_sub_tab == 'current-trades') ? 'acct-active' : '';?>"><i class="fa fa-check"></i>
                        <?//=lang('man_01');?>
                    </a>
                </li>
                <li role="presentation">
                    <a  id="an3" href="<?//= FXPP::loc_url('my-account/history-of-trades');?>" class="<?//=($active_sub_tab == 'history-of-trades') ? 'acct-active' : '';?>"><i class="fa fa-history"></i>
                        <?//=lang('man_02');?>
                    </a>
                </li>-->
               <!-- <li role="presentation">
                    <a  id="an4" href="<?/*= FXPP::loc_url('my-account/forex-calculator');*/?>" class="<?/*=($active_sub_tab == 'forex-calculator') ? 'acct-active' : '';*/?>"><i class="fa fa-calculator"></i>
                        <?/*=lang('man_03');*/?>
                    </a>
                </li>-->
                <?php  if(IPLoc::Office_and_Vpn_Trading()){ ?>
                    <!--<li role="presentation" class="">

                        <a  id="an5" href="<?//= FXPP::loc_url('my-account/trading');?>" class="<?//=($active_sub_tab == '') ? 'acct-active' : '';?>"><i class="fa fa-line-chart"></i>
                          Trading
                        </a>
                    </li>-->
                <?php } ?>





        <?php }else{ ?>
           <!-- <li role="presentation" class="account-sub-tab">
                <a   id="an5" href="<?//= FXPP::loc_url('my-account')?>" class="<?//=($active_sub_tab == 'accounts') ? 'acct-active' : '';?>"><i class="fa fa-user"></i>
                    <?//=lang('man_04');?>
                </a></li>-->
        <?php } ?>

        <div class="clearfix"></div>
    </ul>

</div>
 

<style type="text/css">
    ul.main-tab li {
        width: auto !important;
    }
@media screen and (max-width: 1000px) {
    #last-c{
        margin-right: 5px !important;
        width: 100% !important;
    }

    ul.main-tab li {
        width: 100% !important;
    }


	ul.acc_nav li{
        width: 100%;
        float: none;
        margin: 1px;
        margin-right: 12px;

    }
    ul.acc_nav li a{
        text-align: center;
        }


}
    .arabic-main-tab li {
        width: 20%;
    }
@media screen and (max-width: 767px) {
	 #last-c{
        margin-right: 0px !important;
    }
}

</style>
<script type="text/javascript">

    var anhighheight=0;
    var an1=0;
    var an2=0;
    var an3=0;
    var an4=0;
    var an5=0;

    $(window).load(function() {
        an1 = parseFloat($('#an1').height());
        an2 = parseFloat($('#an2').height());
        an3 = parseFloat($('#an3').height());
        an4 = parseFloat($('#an4').height());
        an5 = parseFloat($('#an5').height());
        if(isNaN(an5)){
            an5=0;
        }
        anhighheight=parseFloat(Math.round(Math.max(an1,an2,an3,an4,an5)));
        $('#an1').height(anhighheight);
        $('#an2').height(anhighheight);
        $('#an3').height(anhighheight);
        $('#an4').height(anhighheight);
        $('#an5').height(anhighheight);

    });
    $(window).resize(function() {
        an1 = parseFloat($('#an1').height());
        an2 = parseFloat($('#an2').height());
        an3 = parseFloat($('#an3').height());
        an4 = parseFloat($('#an4').height());
        an5 = parseFloat($('#an5').height());
        if(isNaN(an5)){
            an5=0;
        }
        anhighheight=parseFloat(Math.round(Math.max(an1,an2,an3,an4,an5)));
        $('#an1').height(anhighheight);
        $('#an2').height(anhighheight);
        $('#an3').height(anhighheight);
        $('#an4').height(anhighheight);
        $('#an5').height(anhighheight);
    });
</script>