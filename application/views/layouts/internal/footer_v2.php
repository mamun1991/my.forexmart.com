
<style>

.grp-list {
    padding: 0;
    margin: 0;
}

.grp-list li {
    list-style: none;
    margin-bottom: 8px;
}


.footer-section{
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif !important;
    font-size: 14px !important;
    line-height: 1.42857143 !important;
    color: #333 !important;
    background-color: #fff !important;
	overflow: hidden;
}

.ftr-logo {
    color: #000;
    font-weight: 700;
}

.footer-desc{text-align: justify;}

.feeadback-footer-link{
    width: 200px !important;
    height:auto;
}
    .footer-section{
    padding: 80px 150px;
    background: #fff;
}
.footer-section .footer-link{
    font-size: 16px;
    display: block;
    color: #707070;
    margin-bottom: 8px;
}

.footer-section .footer-link:hover, .footer-section .footer-link:focus{
    color:#2988CA;
}
.grp-links, .grp-inline{
    list-style: none;
    padding: 0;
    margin: 0;
}
.grp-links li{
    display: block;
}
.grp-links li{
    margin-bottom: 15px;
}

.grp-inline li{
    display: inline-block;
     float: right;
}
.footer-row .footer-block:not(:last-child), .footer-center:not(:last-child){
    border-right:1px solid #70707069;
}
.footer-other-links{
    margin-bottom: 15px;
    float: right;
}
.footer-other-links::after{
    content: '';
    clear: both;
    display: table;
}
.footer-other-links li a{
    color: #707070;
    font-weight: 600;
}
.footer-other-links li a:hover, .footer-other-links li a:focus{
    color:#2988CA;
}
.copyright{
    margin-bottom: 15px;
}
.h-divider{
  /*  margin: 30px 0;*/
    border-top: 1px solid #70707069;
}
.txt-divider{
    padding: 0 15px;
    font-weight: 600;
}
.footer-desc{
    margin-top: 40px;
}
.footer-desc p{
    font-size: 13px;
}
.footer-center{
    display: block;
    text-align: center;
}

    .footer-center:lang(ru){
        height: 60px;
    }
/*.footer-block{
    height:60px;
}*/
.btn-social{
    display: inline-block;
    border: 2px solid #707070;
    border-radius:10px;
    padding: 8px;
    transition: all ease 0.2s;
   
}

 
.social-media-links{
    display: table;
    width: 223px;
    max-width: 100%;
    margin: 0 auto;
   float: right !important;

}
.social-media-links .btn-social:last-child{
    margin-right: 4px;
}
.btn-social:hover{
    background: #707070;
}
.icon-sm{
    width: 26px;
    height: 26px;
    background-size: cover!important;
    display: block;
}
.icon-feedback{
    background: url('<?= $this->template->Images('footer')?>footer/icon-feedback.svg') no-repeat;
}
.icon-callback{
    background: url('<?= $this->template->Images('footer')?>footer/icon-callback.svg') no-repeat;
}
.icon-facebook{
    background: url('<?= $this->template->Images('footer')?>footer/sm-fb.svg') no-repeat;
}
.icon-twitter{
    background: url('<?= $this->template->Images('footer')?>footer/sm-twitter.svg') no-repeat;
}
.icon-gplus{
    background: url('<?= $this->template->Images('footer')?>footer/sm-gplus.svg') no-repeat;
}
.icon-linkedin{
    background: url('<?= $this->template->Images('footer')?>footer/sm-linkedin.svg') no-repeat;
}
.icon-vk{
    background: url('<?= $this->template->Images('footer')?>footer/sm-vk.svg') no-repeat;
}
.icon-tg{
    background: url('<?= $this->template->Images('cabinet')?>cabinet/icon-telegram1.svg') no-repeat;
}

.btn-social:hover .icon-facebook{
    background: url('<?= $this->template->Images('footer')?>footer/sm-fb-active.svg') no-repeat;
}
.btn-social:hover .icon-twitter{
    background: url('<?= $this->template->Images('footer')?>footer/sm-twitter-active.svg') no-repeat;
}
.btn-social:hover .icon-gplus{
    background: url('<?= $this->template->Images('footer')?>footer/sm-gplus-active.svg') no-repeat;
}
.btn-social:hover .icon-linkedin{
    background: url('<?= $this->template->Images('footer')?>footer/sm-linkedin-active.svg') no-repeat;
}
.btn-social:hover .icon-vk{
    background: url('<?= $this->template->Images('footer')?>footer/smvk.png') no-repeat;
    background: url('<?= $this->template->Images('footer')?>footer/sm_vk.png') no-repeat;
}
.btn-social:hover .icon-tg{
    background: url('<?= $this->template->Images('cabinet')?>cabinet/icon-telegram2.svg') no-repeat;
}
.btn-fb{
    border-color:#38529a!important;
}
.btn-fb:hover{
    background-color:#38529a!important;
}
.btn-twitter{
    border-color:#3396e6!important;
}
.btn-twitter:hover{
    background-color:#3396e6!important;
}
.btn-gplus{
    border-color:#d54c3f!important;
}
.btn-gplus:hover{
    background-color:#d54c3f!important; 
}
.btn-linkedin{
    border-color:#0073b1!important;
}
.btn-linkedin:hover{
    background-color:#0073b1!important;
}
.btn-vk {
    border: 2px solid #5c82b0;
    color: #5c82b0;
}
.btn-vk:hover{
    background-color:#5c82b0!important;
    color: #ffffff!important;
}
.btn-tg:hover {
    background-color: #26A6F5!important;
}
.btn-tg{
    border-color:#26A6F5!important;
}
.icon-b4-text{
    display: flex!important;
    align-items: center;
    /*justify-content: center;*/
}
.icon-b4-text span{
    margin-right: 8px;
    display: inline-block;
}
.icon-b4-text:hover .icon-callback{
    background: url('<?= $this->template->Images('footer')?>footer/icon-callback-active.svg') no-repeat;
}
.icon-b4-text:hover .icon-feedback{
    background: url('<?= $this->template->Images('footer')?>footer/icon-feedback-active.svg') no-repeat;
}

    @media screen and (max-width:768px){

        .footer-section {
            padding: 10px 30px;
            background: #fff;
        }

    }

        @media screen and (max-width:1499px){
    .footer-col{
        width: 50%;
    }
    .footer-block {
         height: 125px;
        width: 60%;
    }
    .footer-block:first-child{
         height: 125px;
        width: 40%;
    }
    .social-media-links{
        float: none;
    }
    
    .footer-row .footer-block:not(:last-child), .footer-center:not(:last-child){
          height: 125px;
    }
    
}  

@media screen and (max-width:1212px){
     .footer-col{
        width: 50%;
    }
    .footer-block {
        height: 125px;
        width: 45%;
    }
    .footer-block:first-child{
       height: 125px;
        width: 55%;
    }
    .social-media-links{
        float: none;
    }
    
    .footer-row .footer-block:not(:last-child), .footer-center:not(:last-child){
           height: 125px;
    }
    
    
    .footer-feedback{
            width: 45%;
    }  
    
    .footer-social{
            width: 55%;
    }
    .grp-inline li a{
        width: 35px;
    height: 35px;
    } 
    
    .grp-inline li a span{    width: 16px;
    height: 16px;
    background-size: cover!important;
    display: block;
}
  


.copyright{
        float: left;
    width: 100%;
    text-align: left
}

ul.footer-other-links{
        width: 100%;
    float: left;
    text-align: left;
}

ul.footer-other-links li{    float: left;}


}



@media screen and (max-width:1000px){
     .footer-col{
        width: 50%;
    }
    .footer-block {
        height: 140px;
        width: 40%;
    }
    .footer-block:first-child{
       height: 140px;
        width: 60%;
    }
    .social-media-links{
        float: none;
    }
    
    .footer-row .footer-block:not(:last-child), .footer-center:not(:last-child){
          height: 140px;
    }
    
    
    .footer-feedback{
            width: 60%;
             margin:0px !important;
    }  
    
    .footer-social{
            width: 40%;
            margin:0px !important; 
             padding: 0px !important;
    }
    .grp-inline li a{
        width: 35px;
    height: 35px;
    } 
    
    .grp-inline li a span{    width: 16px;
    height: 16px;
    background-size: cover!important;
    display: block;
}
  
.social-media-links{float: right !important;
    width: 100%;}

.social-media-links li{
   display: inline-block;
    float: right;
    text-align: right;
    width: 35%;
    margin-left:10px;
}
 





.copyright{
        float: left;
    width: 100%;
    text-align: left
}

ul.footer-other-links{
        width: 100%;
    float: left;
    text-align: left;
}

ul.footer-other-links li{    float: left;}

}


    @media screen and (min-width:860px) and (max-width:1140px){
        .footer-section{
            padding: 80px 40px;
        }
        .feeadback-footer-link {
            /*font-size: 14px !important;*/
        }
		.footer-section .container_fluid .row{
			margin-left: 0;
			margin-right: 0;
		}
    }

    @media screen and (min-width:1141px) and (max-width:1212px){
        .footer-section .footer-link{
            font-size: 14px !important;
        }
    }

    @media screen and (min-width:1500px) and (max-width:1610px){
        .footer-section .footer-link{
            font-size: 14px !important;
        }
    }


@media screen and (max-width:859px){
    
    
    .footer-col{
        width: 50%;
    }
    .footer-block {
        height: 270px;
        width: 40%;
    }
    .footer-block:first-child{ 
        width: 60%;
    }
    .social-media-links{
        float: none;
    }
    
 
    
.footer-block-profile{ height:240px !important;     float: left;}
.footer-block-social{ height:240px !important;     float: left;}
.footer-block-profile .footer-col{
    width: 100%; 
}
    
 .footer-feedback {
    width: 100%;
    margin: 0px !important;
    padding: 0px;
    border: none !important;
    float: left;
    height: 120px !important;
}  
.footer-social {
    float: left;
    width: 100%;
}

.social-media-links{
        float: left !important;
    width: 100%;
    padding: 0px !important;
    margin: 0px !important;
}

.social-media-links li{
      display: inline-block;
    float: left;
    width: 18%;
    margin-left: 10px;
}



    .grp-inline li a{
        width: 35px;
    height: 35px;
    } 
    
    .grp-inline li a span{    width: 16px;
    height: 16px;
    background-size: cover!important;
    display: block;
}
  




.copyright{
        float: left;
    width: 100%;
    text-align: left
}

ul.footer-other-links{
        width: 100%;
    float: left;
    text-align: left;
}

ul.footer-other-links li{
    float: left;
}

    .icon-b4-text{
        padding-left: 20px;
    }

 

}
 


@media screen and (max-width:655px){


    .icon-b4-text{
        justify-content: left !important;
        padding-left: 20px;
    }
    
    .footer-col{
        width: 50%;
    }
    .footer-block {
        height: 270px;
        width: 40%;
    }
    .footer-block:first-child{ 
        width: 60%;
    }
    .social-media-links{
        float: none;
    }
    
 
    
.footer-block-profile{ height:220px !important;}
.footer-block-social{ height:220px !important;}
.footer-block-profile .footer-col{
    width: 100%; 
}
    
 .footer-feedback {
    width: 100%;
    margin: 0px !important;
    padding: 0px;
    border: none !important;
    float: left;
    height: 120px !important;
}  
.footer-social {
    float: left;
    width: 100%;
}

.social-media-links{
        float: left !important;
    width: 100%;
    padding: 0px !important;
    margin: 0px !important;
}

 

.social-media-links li{
   display: inline-block;
    float: left;
    text-align: right;
    width: 35%;
    margin-left:10px;
}



    .grp-inline li a{
        width: 35px;
    height: 35px;
    } 
    
    .grp-inline li a span{    width: 16px;
    height: 16px;
    background-size: cover!important;
    display: block;
}
  




.copyright{
        float: left;
    width: 100%;
    text-align: left
}

ul.footer-other-links{
        width: 100%;
    float: left;
    text-align: left;
}

ul.footer-other-links li{    float: left;}

  
}


@media screen and (max-width:559px){


    .footer-col{
        width: 50%;
    }
    .footer-block { 
        width: 40%;
    }
    .footer-block:first-child{ 
        width: 60%;
    }
    .social-media-links{
        float: none;
    }
    
 
    
/*.footer-block-profile{ height:335px !important;}    */
/*.footer-block-social{ height:335px !important;}    */
.footer-block-profile .footer-col{
    width: 100%; 
     word-break: break-all;
}
    
 .footer-feedback {
    width: 100%;
    margin: 0px !important;
    padding: 0px;
    border: none !important;
    float: left;
    height: 120px !important;
}  
.footer-social {
    float: left;
    width: 100%;
}

.social-media-links{
        float: left !important;
    width: 100%;
    padding: 0px !important;
    margin: 0px !important;
}

 

.social-media-links li{
   display: inline-block;
    float: left;
    text-align: right;
    width: 35%;
    margin-left:10px;
}



    .grp-inline li a{
        width: 35px;
    height: 35px;
    } 
    
    .grp-inline li a span{    width: 16px;
    height: 16px;
    background-size: cover!important;
    display: block;
}
  




.copyright{
        float: left;
    width: 100%;
    text-align: left
}

ul.footer-other-links{
        width: 100%;
    float: left;
    text-align: left;
}

ul.footer-other-links li{
    float: left;
}



.footer-menu-text{ font-size: 13px !important;}
  
}
@media screen and (min-width:380px) and (max-width:514px) {
    .txt-divider:lang(ru) {
        margin-right: 50px;
    }
}

.btn-tel {
    width: 46px;
    height: 46px;
}

@media screen and (max-width:1212px) {
    .btn-tel {
        width: 35px;
        height: 35px;
    }
}

/*
@media screen and (max-width:767px){
    .footer-desc{
        margin-top: 0;
    }
    .footer-col{
        width: 100%;
    }
    .footer-block{
        border-right: 0!important;
        float: left;
        width: 50%;
    }
    .footer-block:first-child {
        width: 50%;
        height: auto;
    }
}
@media screen and (max-width:576px){
    .btn-social{
        padding: 4px;
    }
    .footer-block{
        width: 100%;
    }
    .footer-block:first-child {
        width: 100%;
    }
    .footer-section .footer-link {
        text-align: center;
    }
    .icon-b4-text {
        justify-content: center;
    }
    .social-media-links {
        margin: 0 auto;
        width: auto;
    }
    .footer-other-links, .copyright,
    .footer-desc p{
        text-align: center;
    }
    .copyright{
        display: block;
    }
    .footer-other-links li {
        margin-bottom: 15px;
    }
    .txt-divider {
        padding: 0 8px;
    }
    .footer-section {
        padding: 15px;
    }
}
*/



    </style>
<!-- new footer -->
<div class="footer-section">
	<div class="container_fluid">
		<div class="row footer-row">
			<div class="col-lg-8 col-md-7 col-sm-5 footer-block footer-block-profile">
				<div class="row">
					<div class="footer-col col-lg-3 col-md-6 col-sm-12"><a href="<?= FXPP::loc_url('profile/edit') ?>" class="footer-link footer-menu-text"><?= lang('botnav_06'); ?></a></div>
					<div class="footer-col col-lg-3 col-md-6 col-sm-12"><a href="<?= FXPP::loc_url('my-account') ?>" class="footer-link footer-menu-text"><?= lang('botnav_05'); ?></a></div>
					<div class="footer-col col-lg-3 col-md-6 col-sm-12"><a href="<?= FXPP::loc_url('withdraw') ?>" class="footer-link footer-menu-text"><?= lang('botnav_08'); ?></a></div>
					<div class="footer-col col-lg-3 col-md-6 col-sm-12"><a href="<?= FXPP::loc_url('deposit') ?>" class="footer-link footer-menu-text"><?= lang('botnav_07'); ?></a></div>
					<div class="footer-col col-lg-3 col-md-6 col-sm-12"><a href="<?= FXPP::www_url('metatrader4'); ?>" class="footer-link footer-menu-text"><?= lang('botnav_09'); ?></a></div>
					<div class="footer-col col-lg-3 col-md-6 col-sm-12"><a href="<?= FXPP::www_url('account-verification'); ?>" class="footer-link footer-menu-text"><?= lang('botnav_03'); ?></a></div>
					<div class="footer-col col-lg-3 col-md-6 col-sm-12"><a href="<?= FXPP::www_url('deposit-withdraw-page'); ?>" class="footer-link footer-menu-text"><?= lang('botnav_01'); ?></a></div>
					<div class="footer-col col-lg-3 col-md-6 col-sm-12"><a href="<?= FXPP::www_url('about-us'); ?>" class="footer-link footer-menu-text"><?= lang('botnav_00'); ?></a></div>
				</div>
			</div>
			<div class="col-lg-4 col-md-5 col-sm-5 footer-block footer-block-social">
				<div class="row">
					<div class="col-lg-5 col-md-7 col-sm-12 footer-center footer-feedback">
						<ul class="grp-list">
						 
							<li><a  href="#popfeedback" data-toggle="modal" data-target="#popfeedback" class="footer-link icon-b4-text footer-menu-text feeadback-footer-link"><span class="icon-sm icon-feedback footer-menu-text"></span><?= lang('botnav_11'); ?></a></li>
							<li><a  href="<?= FXPP::www_url('call-back'); ?>" class="footer-link icon-b4-text footer-menu-text  feeadback-footer-link"><span class="icon-sm icon-callback footer-menu-text"></span><?= lang('botnav_18'); ?></a></li>
						</ul>
					</div>
					<div class="col-lg-7 col-md-5 col-sm-12 footer-center footer-social">

                    <?php
                        $telegram = array(
                            'ru' => 'forexmartru',
                            'my' => 'forexmartmalaysia',
                            'id' => 'forexmartindonesia'
                        );
                    ?>
					
					 <?php if(FXPP::html_url()=='ru'){ ?>
					
						<ul class="grp-inline social-media-links">
							<li><a  href="https://www.facebook.com/forexmartru" target="_blank" class="btn-social btn-fb"><span class="icon-sm icon-facebook"></span></a></li>
							<li><a href="https://twitter.com/ForexMartRu" target="_blank" class="btn-social btn-twitter"><span class="icon-sm icon-twitter"></span></a></li>
<!--							<li><a href="https://plus.google.com/communities/111804080179853814370" target="_blank" class="btn-social btn-gplus"><span class="icon-sm icon-gplus"></span></a></li>-->
							<li><a href="https://vk.com/forexmart" target="_blank" class="btn-social btn-vk"><span class="icon-sm icon-vk"></span></a></li>
							<li><a href="https://t.me/<?=$telegram[FXPP::html_url()]?>" target="_blank" class="btn-social btn-tg"><span class="icon-sm icon-tg"></span></a></li>

						</ul>
					 <?php }else{ ?>

				        <ul class="grp-inline social-media-links">
							<li><a  href="<?= $this->config->item('domain-facebook');?>" target="_blank" class="btn-social btn-fb"><span class="icon-sm icon-facebook"></span></a></li>
							<li><a href="<?= $this->config->item('domain-twitter');?>" target="_blank" class="btn-social btn-twitter"><span class="icon-sm icon-twitter"></span></a></li>
							<?php /**<li><a href="<?= $this->config->item('domain-googleplus');?>" target="_blank" class="btn-social btn-gplus"><span class="icon-sm icon-gplus"></span></a></li>*/?>
							<li><a href="https://www.linkedin.com/" target="_blank" class="btn-social btn-linkedin"><span class="icon-sm icon-linkedin"></span></a></li>
                            <?php if(array_key_exists(FXPP::html_url(), $telegram)){ ?>
                                <li><a href="https://t.me/<?=$telegram[FXPP::html_url()]?>" target="_blank" class="btn-social btn-tg"><span class="icon-sm icon-tg"></span></a></li>
                            <?php } ?>
                        </ul>
					 <?php } ?>
						
					</div>
				</div>
			</div>
		</div>
		 
		
		<hr class="h-divider">
		<span class="copyright">© 2015-<?= date('Y'); ?> <span class="ftr-logo"><?php echo FXPP::companyName(); ?></span> </span>
		<ul class="grp-inline footer-other-links">
			<li><a href="<?= FXPP::www_url('legal-documentation') ?>" target="_blank"><?= lang('botnav_14'); ?></a></li>
			<li class="txt-divider">|</li>
			<li><a href="<?= $this->template->Pdf() ?>Privacy Policy.pdf" target="_blank"><?= lang('botnav_15'); ?></a></li>
			<li class="txt-divider">|</li>
			<li><a href="<?= $this->template->Pdf() ?>Risk Disclosure.pdf" target="_blank"><?= lang('botnav_16'); ?></a></li>
			<li class="txt-divider">|</li>
			
			<?php if(IPLoc::isChinaIP() || $this->country_code == 'CN' || FXPP::html_url() == 'zh' ){ ?>
			
			<li><a href="<?= $this->template->Pdf() ?>Terms and Conditions for ChineseV2.pdf" target="_blank"><?= lang('botnav_17'); ?></a></li>
			
			  <?php } else { ?>
			
			
			<li><a href="<?= $this->template->Pdf() ?>Terms and Conditions.pdf" target="_blank"><?= lang('botnav_17'); ?></a></li>
			
			<?php } ?>
			
		 
			
			
		</ul>
		<div class="footer-desc">
			<p><?php echo FXPP::companyName(); ?> <?= lang('new_with_foo_04'); ?></p>
			<p><?= lang('new_with_foo_02'); ?> <span class="ftr-logo"><?php echo FXPP::companyName(); ?></span> <?= lang('new_with_foo_04'); ?>. <?= lang('new_with_foo_05'); ?> <span class="ftr-logo"><?php echo FXPP::companyName(); ?></span> <?= lang('new_with_foo_06'); ?></p>
			<p><?= lang('gen-rw'); ?> <?= lang('footer-gen-risk'); ?></p>
		</div>
	</div>
</div>
<!-- end footer -->
