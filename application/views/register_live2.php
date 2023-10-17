<style type="text/css">
    @media only screen and (max-width: 320px){
        /* Force table to not be like tables anymore */
        #tb_dshbrd{
            display: block!important;
        }
        .table-responsive>.table>tbody>tr>td, .table-responsive>.table>tbody>tr>th, .table-responsive>.table>tfoot>tr>td, .table-responsive>.table>tfoot>tr>th, .table-responsive>.table>thead>tr>td, .table-responsive>.table>thead>tr>th{
            white-space: inherit;
        }
    }

    @media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
        /* Force table to not be like tables anymore */
        #tb_dshbrd table, #tb_dshbrd  thead,  #tb_dshbrd  tbody, #tb_dshbrd  th, #tb_dshbrd td, #tb_dshbrd tr {
            display: block;
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        #tb_dshbrd thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        #tb_dshbrd tr { border: 1px solid #ccc; }

        #tb_dshbrd td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%;
        }

        #tb_dshbrd td:before {
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;
            padding-right: 10px;
            /*padding-left: 10px;*/
            white-space: nowrap;
        }

        /*
        Label the data
        */
        #tb_dshbrd td:nth-of-type(1):before { content: "Account(s)/Actions"; }
        #tb_dshbrd td:nth-of-type(2):before { content: "Leverage"; }
        #tb_dshbrd td:nth-of-type(3):before { content: "Currency"; }
        #tb_dshbrd td:nth-of-type(4):before { content: "Balance"; }
        #tb_dshbrd td:nth-of-type(5):before { content: "Status"; }
        #tb_dshbrd td:nth-of-type(6):before { content: "Account Type"; }
        #tb_dshbrd td:nth-of-type(7):before { content: "Swap-Free"; }
    }

    @media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
        /* Force table to not be like tables anymore */
        #tb_dshbrd2 table, #tb_dshbrd2  thead,  #tb_dshbrd2  tbody, #tb_dshbrd2  th, #tb_dshbrd2 td, #tb_dshbrd2 tr {
            display: block;
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        #tb_dshbrd2 thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        #tb_dshbrd2 tr { border: 1px solid #ccc; }

        #tb_dshbrd2 td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%;
        }

        #tb_dshbrd2 td:before {
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
        }

        /*
        Label the data
        */
        #tb_dshbrd2 td:nth-of-type(1):before { content: "Account(s)/Actions"; }
        #tb_dshbrd2 td:nth-of-type(2):before { content: "Leverage"; }
        #tb_dshbrd2 td:nth-of-type(3):before { content: "Currency"; }
        #tb_dshbrd2 td:nth-of-type(4):before { content: "Balance"; }
        #tb_dshbrd2 td:nth-of-type(5):before { content: "Status"; }
        #tb_dshbrd2 td:nth-of-type(6):before { content: "Account Type"; }
        #tb_dshbrd2 td:nth-of-type(7):before { content: "Swap-Free"; }
    }

    .dashboard > thead > tr > th {
        text-align: center;
    }

    .dashboard > tbody > tr > td {
        text-align: center;
        line-height: 30px;
    }

    .tab-my-acct > tbody > tr > td {
        line-height: 30px;
    }

    .tab-partner-acc > thead > tr > th {
        text-align: center;
    }
    @-moz-document url-prefix() {
        .open-demo_custom{
            padding: 7px 56px!important;
        }
        /*.open-demo_custom:lang(ru){*/
            /*padding: 7px 65px!important;*/
        /*}*/
        .open-demo_custom:lang(jp){
            padding: 7px 56px!important;
        }
        .open-demo_custom:lang(id){
            padding: 7px 56px!important;
        }
        .open-demo_custom:lang(de){
            padding: 7px 56px!important;
        }
        .open-demo_custom:lang(fr){
            padding: 7px 56px!important;
        }
        .open-demo_custom:lang(it){
            padding: 7px 56px!important;
        }
        .open-demo_custom:lang(sa){
            padding: 7px 49px!important;
        }
        .open-demo_custom:lang(es){
            padding: 7px 56px!important;
        }
        .open-demo_custom:lang(pt){
            padding: 7px 56px!important;
        }
        .open-demo_custom:lang(bg){
            padding: 7px 56px!important;
        }
        .open-demo_custom:lang(my){
            padding: 7px 56px!important;
        }
    }
    @media screen and (-webkit-min-device-pixel-ratio:0) {
        .open-demo_custom{
            padding: 7px 0px!important;
        }
        /*.open-demo_custom:lang(ru){*/
            /*padding: 7px 65px!important;*/
        /*}*/
        .open-demo_custom:lang(jp){
            padding: 7px 55px!important;
        }
        .open-demo_custom:lang(id){
            padding: 7px 55px!important;
        }
        .open-demo_custom:lang(de){
            padding: 7px 55px!important;
        }
        .open-demo_custom:lang(fr){
            padding: 7px 55px!important;
        }
        .open-demo_custom:lang(it){
            padding: 7px 55px!important;
        }
        .open-demo_custom:lang(sa){
            padding: 7px 49px!important;
        }
        .open-demo_custom:lang(es){
            padding: 7px 55px!important;
        }
        .open-demo_custom:lang(pt){
            padding: 7px 55px!important;
        }
        .open-demo_custom:lang(bg){
            padding: 7px 55px!important;
        }
        .open-demo_custom:lang(my){
            padding: 7px 55px!important;
        }
    }

    .acct-cont{
        border: 0px!important;
    }


    .btns-open-acc {
        margin-top: 15px;
        margin-right: 10px;
        /*float: left;*/
        display: inline-block;
    }
    .btn-trading-demo-holder{
        text-align: center;
    }
    .trading-x:lang(zh){
      display: inline-block; margin-left: 17px;font-size:13px; margin-top:2%;
    }
    .trading-x{
        margin-left: 225px;
    }
    @media only screen and (max-width: 760px){
        .btns-open-acc {
            margin-top: 15px;
            margin-right: 0px;
            float: none;
            width: 100%;
        }

        .btns-open-wid-acc {
            width: 100% !important;
        }
    }


</style>
<style type="text/css">
    ul.registration-ul{
        margin-top:10px;
        padding-left:0px;
    }
    ul.registration-ul li{
        color: #6d6d6d;
        list-style-type: none;
        display: inline-block;
    }
    ul.registration-ul li:lang(ru){
        font-size: 13px;
        text-align: center;
        float: none;
        padding:0;
    }
    ul.registration-ul li:hover{
        text-decoration: underline;
    }
    ul.registration-ul li.active{
        color: #29a643;
        font-weight:bold;
    }
    .circle-icon {
        background: #29a643;
        padding:10px;
        border-radius: 50%;
    }
    #myNavbar:lang(ru){
        padding:0;
    }
    ul.registration-ul li .fa-flag{
        font-size: 16px;
        color: #fff;
    }
    ul.registration-ul li.active .fa-flag{
        font-size: 16px;
        color: #29a643;
    }
    ul.registration-ul li.active .circle-icon{
        background: #fff;
        border:1px solid #29a643;
    }
    .div-reg{
        padding: 0px;
        /*overflow-y: scroll;*/
        /*max-height:800px;*/
        max-height: 1500px;
        margin-bottom:2%;
    }
    .div-reg > form > div:last-child{
        text-align:center;
    }
    .odd{
        background-color: #b7d9ea;
    }
    .even{
        background-color: #d9edf7;
    }
    /*label {*/
        /*width: 30% !important;*/
        /*float: left;*/
        /*margin: 5px;*/
        /*!* display: inline-block; *!*/
        /*padding: 7px;*/
    /*}*/
    .form-label {
        width: 30% !important;
        float: left;
        margin: 5px;
        /* display: inline-block; */
        padding: 7px;
    }
   .maincont input[type=text], .maincont select{
        float: right;
        width: 65%!important;
        margin: 5px;
    }
    .checkbox1{
        margin-left: 34%!important;
        margin-right: 2px !important;
    }
    .btn_complete,.btn_next,.btn_back{
        padding: 10px;
        margin-right: 40%;
        float: right;
        margin-top: 2%;
        margin-bottom: 2%;
        background: #29a643;
        color: #fff;
        border: none;
        display: block;
        text-align: center;
    }
    .personal , .trading ,.next-trading, .employment,.next-employment,.complete,.success-registration{
        display: none;
    }
    #success-div h4 {
        font-size: 18px;
        text-align: center;
        font-weight: bold;
        color: #2988ca;
    }
    #success-div span{
        text-align: center;
        display: block;
    }
        .btns-open-acc{
            width:33.2%
        }
        .mid-btn{
            width:31%
        }
        .btns-open-acc button ,.mid-btn button {
            width:100%
        }
        .reg-btn{
            margin-right:0px;
        }
    @media screen (max-width: 991px){
        .reg-main-div{
            display:inline-block;
        }
    }


    @media screen and (max-width:760px){
        .open-demo .open-trading {
            width: 100% !important;
            padding: 7px 50px;
        }
        .btns-open-acc {
            width: 100%!important;
        }
    }
    .addAcc {
        background-color: #b7d9ea;
        display: inline-block;
        width: 100%;
    }

    .form-margin {
        padding-bottom: 2%;
        margin-left: 1%;
    }
    .button-margin {
        margin-left: -2%;
    }
    .clickable-label {
        float: none!important;
        font-weight: unset!important;
        display: block!important;
    }
    .clickable-radio {
        width: 12%;
        margin-top: 10px;
        font-weight: unset!important;
    }
    </style>

<h1>
    <?=lang('mya_01');?>
</h1>

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>  
 

<?php $this->load->view('account_nav.php');?>

<div class="tab-content acct-cont">
    <div role="tabpanel" class="row tab-pane active" id="tab1">
        <div class="col-md-12 col-sm-12 btn-trading-demo-holder">
            <div class="btns btns-open-acc mid-btn" style="">
                <form action="<?= FXPP::www_url('register/demo/step2')?>" method="post">
                    <input type="hidden" name="email" value="<?php echo $this->session->userdata('email') ?>">
                    <input type="hidden" name="full_name" value="<?php echo $this->session->userdata('full_name') ?>">
                    <button type="submit" class="open-demo open-demo_custom btns-open-wid-acc">
                        <?=lang('mya_03');?>
                    </button>
                </form>
            </div>
            <div class="btns btns-open-acc reg-btn" style="">
                <form action="<?= FXPP::loc_url('registration');?>" method="post">
                    <input type="hidden" name="email" value="<?php echo $this->session->userdata('email') ?>">
                    <input type="hidden" name="full_name" value="<?php echo $this->session->userdata('full_name') ?>">
                    <input type="hidden" name="success_reg" value="<?php isset($success)?'done':'';?>">
                    <button type="submit" class="open-trading btns-open-wid-acc"><?=lang('reg_in_02');?></button>
                </form>
            </div><div class="clearfix"></div>
        </div>

        <div class="col-md-12 col-sm-12" id="myNavbar" style="text-align:center;">
            <ul class="registration-ul nav navbar-nav" style="    float: none!important; display: inline-block;">
                <li id="personal" class="active"><i class="fa fa-flag circle-icon" aria-hidden="true"></i>  <?=lang('x_regl_0');?></li>
                <li><img src="<?=$this->template->Images()?>nxt.png" class="img-reponsive" width="50"></li>
                <li id="trading" class="active"><i class="fa fa-flag circle-icon" aria-hidden="true"></i><?=lang('x_regl_1');?></li>
                <li><img src="<?=$this->template->Images()?>nxt.png" class="img-reponsive" width="50"></li>
                <li id="employment"><i class="fa fa-flag circle-icon" aria-hidden="true"></i> <?=lang('x_regl_2');?></li>
                <?php if(isset($success)){ ?>
                    <li id="arr-success"><img src="<?=$this->template->Images()?>nxt.png" class="img-reponsive" width="50"></li>
                    <li id="success"><i class="fa fa-flag circle-icon" aria-hidden="true"></i> <?=lang('reg_in_03');?></li>
                <?php } ?>
            </ul>
        </div>

        <body data-spy="scroll" data-target=".navbar" data-offset="50">

        <div class="col-md-10 col-sm-10 div-reg" style="margin-left: 10%;">
            <?php if(isset($success) && !$success){?>
                <div class="alert alert-danger">
                    <?php echo $errors; ?>
                </div>
            <?php } ?>

            <?= form_open(FXPP::loc_url('registration'),array('id' => 'addAccount','class'=> 'addAcc', 'enctype'=>"multipart/form-data"),''); ?>
            <div class="col-md-12  personal ">
                <h4><?=lang('x_regl_0');?></h4>
                <div id="personal-div form-margin" class="col-md-12">
                    <div id="error-validation" style="padding:5px;text-align: center;color: red;display: none;">
                        <span>All fields are required. </span>
                    </div>
                    <label class="form-label"><?=lang('reli_01');?>:</label>
                    <input type="text" class="form-control round-0 required" maxlength="90" placeholder="<?=lang('reli_01_1');?>" name="street" value="<?php echo isset($api_details_emailname['Address']) ? $api_details_emailname['Address'] : '' ?>" <?= isset($api_details_emailname['Address'])?'readonly':'';?>>
                    <label class="form-label"><?=lang('reli_02');?>:</label>
                    <input type="text" class="form-control round-0 required" maxlength="30" placeholder="<?=lang('reli_02');?>" name="city" value="<?php echo isset($api_details_emailname['City']) ? $api_details_emailname['City'] : '' ?>" <?= isset($api_details_emailname['City'])?'readonly':'';?>>
                    <label class="form-label"><?=lang('reli_03');?>:</label>
                    <input type="text" class="form-control round-0 required" maxlength="30" placeholder="<?=lang('reli_03');?>" name="state" value="<?php echo isset($api_details_emailname['State']) ? $api_details_emailname['State'] : '' ?>" <?= isset($api_details_emailname['State'])?'readonly':'';?>>
                    <label class="form-label"><?=lang('reli_04');?>:</label>
                    <select class="form-control round-0 required" id="country" name="country"  <?= isset($api_details_emailname['LogIn'])?'readonly':'';?>><?php echo  $countries;?></select>
                    <label class="form-label"><?=lang('reli_05');?>:</label>
                    <input type="text" class="form-control round-0 required" maxlength="15" placeholder="<?=lang('reli_05');?>" name="zip" value="<?= $zip = isset($api_details_emailname['ZipCode']) ? $api_details_emailname['ZipCode']:'';?>" <?= isset($api_details_emailname['ZipCode'])?'readonly':'';?>>
                    <label class="form-label"><?=lang('reli_06');?>:</label>
                    <input type="text" class="form-control round-0 required" maxlength="16" placeholder="<?=lang('reli_06');?>" name="phone" value="<?php echo isset($api_details_emailname['PhoneNumber']) ? $api_details_emailname['PhoneNumber'] : '+'.$calling_code ?>" <?= isset($api_details_emailname['PhoneNumber']) && strlen($api_details_emailname['PhoneNumber'])>1 ?'readonly':'';?>>
                    <label class="form-label"><?=lang('reli_07');?>:</label>
                    <input type="text" class="form-control round-0 required" autocomplete="off" id="registread_account_dob" placeholder="<?=lang('reli_07');?>" name="dob" value="<?php echo isset($user_details_emailname['dob']) ? date('Y-m-d', strtotime($user_details_emailname['dob'])) : '' ?>" >
                </div>
            </div>
            <div class="col-md-12  next-trading button-margin">
                <button class="btn_next" type="button" style="margin-right:5px!important;"><?=lang('reg_in_04');?></button>
                <button class="btn_back" type="button" style="margin-right:5px!important;" onclick="window.location.href='<?=FXPP::my_url('my-account')?>'"><?=lang('reg_in_05');?></button>
            </div>

            <div class="col-md-12  trading form-margin">
                <h4><?=lang('reli_h2');?></h4>
                <div id="trading-div form-margin" style="padding-top: 2%;" class="col-md-12">
                    <label class="form-label"><?=lang('x_regl_15');?></label>
                    <select class="form-control round-0 required" name="mt_account_set_id" id="mt_account_set_id"><?php echo $account_type;?></select>
                    <label class="form-label"><?=lang('x_regl_16');?></label>
                    <select class="form-control round-0 required" name="mt_currency_base" id="mt_currency_base"><?php echo $account_currency_base;?></select>
                    <label class="form-label"><?=lang('x_regl_17');?></label>
                    <select class="form-control round-0 required" name="leverage" id="xleverage"><?php echo $leverage;?></select>

                    <label class="clickable-label">
                        <input name="swap_free" class="checkbox1" <?php echo isset($user_details['swap_free']) ? $user_details['swap_free'] ? ' checked' : '' : '' ?> value="1" type="checkbox"/><?=lang('reli_15');?>
                    </label>

                    <label class="form-label"><?=lang('x_regl_19');?></label>
                    <p class="trading-x"><?=lang('x_regl_20');?></p>
                    <div style="clear: both"></div>

                    <label class="clickable-label">
                        <input id="agree-1" class="checkbox1"  type="checkbox" name="experience" <?php echo isset($user_details_emailname['trading_experience_value'][0]) ? $user_details_emailname['trading_experience_value'][0] ? ' checked' : '' : '' ?> value="1"/><span><?=lang('reli_18');?></span>
                    </label>
                    <label class="clickable-label">
                        <input id="agree-2" class="checkbox1"  type="checkbox" name="experience" <?php echo isset($user_details_emailname['trading_experience_value'][0]) ? $user_details_emailname['trading_experience_value'][1] ? ' checked' : '' : '' ?> value="2"/><span><?=lang('reli_19');?></span>
                    </label>
                    <label class="clickable-label">
                        <input id="agree-3" class="checkbox1"  type="checkbox" name="experience"<?php echo isset($user_details_emailname['trading_experience_value'][0]) ? $user_details_emailname['trading_experience_value'][2] ? ' checked' : '' : '' ?> value="3"/><span><?=lang('reli_20');?></span>
                    </label>

                    <label class="form-label"><?=lang('x_regl_24');?></label>
                    <p style="display: inline-block; margin-left: 17px;font-size:13px; margin-top:2%;"><?=lang('x_regl_25');?></p>
                    <select class="form-control round-0 required" name="investment_knowledge" id="investment_knowledge"><?php echo $investment_knowledge;?></select>

                    <label class="form-label" style="margin-top:7%;"><?=lang('x_regl_26');?></label>
                    <select class="form-control round-0 required" name="trade_duration" id="trade_duration"><?php echo $trade_duration;?></select>
                    <div style="clear: both"></div>
                    <label class="form-label" style="margin-right: 3%;padding-bottom: 0px!important;margin-bottom: 0px!important;"><?=lang('x_regl_27');?></label>
                    <label class="clickable-radio">
                        <input style="margin-right: 25%; margin-left: 2%;margin-bottom: 30px;margin-top: 10px;" value="1"<?php echo isset($user_details['politically_exposed_person']) ? $user_details_emailname['politically_exposed_person'] ? ' checked' : '' : '' ?> id="politically_exposed_person1" type="radio" class="rdo-btn-required" name="politically_exposed_person" /><span><?=lang('reli_ye');?></span>
                    </label>
                    <label class="clickable-radio">
                        <input style="margin-right: 25%; margin-left: 17px;!important;"value="0"<?php echo isset($user_details['politically_exposed_person']) ? $user_details_emailname['politically_exposed_person'] ? '' : ' checked' : ' checked' ?> id="politically_exposed_person" type="radio" class="rdo-btn-required" name="politically_exposed_person" /><span><?=lang('reli_no');?></span>
                    </label>
                    <div style="clear: both"></div>
                    <label class="form-label" style="margin-right: 3%;"><?=lang('x_regl_28');?></label>
                    <label class="clickable-radio">
                        <input  style="margin-right: 25%; margin-left: 2%;" value="1"<?php echo isset($user_details['risk']) ? $user_details_emailname['risk'] ? ' checked' : '' : ' checked' ?> id="risk1" type="radio" class="rdo-btn-required" name="risk" /><span><?=lang('reli_ye');?></span>
                    </label>
                    <label class="clickable-radio">
                        <input style="margin-right: 25%; margin-left: 17px;!important;" value="0"<?php echo isset($user_details['risk']) ? $user_details_emailname['risk'] ? '' : ' checked' : '' ?> id="risk" type="radio" class="rdo-btn-required" name="risk" /><span><?=lang('reli_no');?></span>
                    </label>
                   <div style="clear: both"></div>
                    <label class="form-label" style="margin-right: 2%;"><?=lang('x_regl_41');?></label>
                    <input type="text" class="form-control round-0 required" maxlength="32" value="<?php echo !empty($aff_code) ? $aff_code: '' ;?>" name="affiliate_code">
                    <div id="error-validation1" style="padding:5px;text-align: center;color: red;display: none;">
                        <span id="error-msg"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 trading button-margin" style="font-weight: bold; font-size: 15px; text-align: center;">
                <a href="<?= $this->template->pdf() . rawurlencode('Terms and Conditions.pdf') ?>" target="_blank">Terms and Condition</a>
                <span style="margin-left: 8%; margin-right: 8%;">|</span>
                <a href="<?= $this->template->pdf() . rawurlencode('Risk Disclosure.pdf') ?>" target="_blank">Risk Disclosure</a>
            </div>
            <div class="col-md-12  next-employment button-margin">
                <button class="btn_next" type="button" style="margin-right:5px!important;"><?=lang('reg_in_06');?></button>
                <button class="btn_back" type="button" style="margin-right:5px!important;"><?=lang('x_regl_31');?></button>
            </div>

            <div class="col-md-12  employment">
                <h4><?=lang('x_regl_33');?></h4>
                <div id="employment-div form-margin" style="padding-top: 2%;" class="col-md-12">

                    <label class="form-label"><?=lang('x_regl_34');?></label>
                    <select id="employment_status1" class="form-control round-0 required" name="employment_status1" <?= isset($employment_status)?'disabled':'';?>><?php echo $employment_status;?></select>
                    <input id="employment_status" type="hidden" name="employment_status" value="<?php echo $user_details_emailname['employment_status'];?>"/>

                    <label class="form-label"><?=lang('x_regl_35');?></label>
                    <select id="industry1" class="form-control round-0 emp-stat-cat" name="industry1" <?= isset($industry)?'disabled':'';?>><?php echo $industry;?></select>
                    <input id="industry" type="hidden" name="industry" value="<?php echo $user_details_emailname['industry'];?>"/>

                    <label class="form-label"><?=lang('x_regl_36');?></label>
                    <select class="form-control round-0 required" name="estimated_annual_income1" id="estimated_annual_income1" <?= isset($estimated_annual_income)?'disabled':'';?>><?php echo $estimated_annual_income;?></select>
                    <input id="estimated_annual_income" type="hidden" name="estimated_annual_income"value="<?php echo $user_details_emailname['estimated_annual_income'];?>"/>

                    <label class="form-label"><?=lang('x_regl_37');?></label>
                    <select class="form-control round-0 required" name="estimated_net_worth1" id="estimated_net_worth1" <?= isset($estimated_net_worth)?'disabled':'';?>><?php echo $estimated_net_worth;?></select>
                    <input id="estimated_net_worth" type="hidden" name="estimated_net_worth" value="<?php echo $user_details_emailname['estimated_net_worth'];?>"/>

                    <label class="form-label"><?=lang('x_regl_38');?></label>
                    <select class="form-control round-0 required" name="education_level1" id="education_level1" <?= isset($education_level)?'disabled':'';?>><?php echo $education_level;?></select>
                    <input id="education_level" type="hidden" name="education_level" value="<?php echo $user_details_emailname['education_level'];?>"/>

                    <label class="form-label" style="margin-right: 2%;margin-bottom:0px;padding-bottom: 0px;width: 60% !important;"><?=lang('x_regl_39');?> <?php echo isset($user_details_emailname['us_resident']) ? $user_details_emailname['us_resident'] ? 'Yes' : ' No' : '' ?></label>
                    <input id="us_resident" type="hidden" name="us_resident" value="<?php echo $user_details_emailname['us_resident'];?>"/>
                    <br>
                    <label class="form-label" style="margin-right: 2%;width: 60% !important;"><?=lang('x_regl_40');?> <?php echo isset($user_details_emailname['us_resident']) ? $user_details_emailname['us_resident'] ? 'Yes' : ' No' : '' ?></label>
                    <input id="us_citizen" type="hidden" name="us_citizen" value="<?php echo $user_details_emailname['us_resident'];?>"/>
                </div>
            </div>
            <div class="col-md-12  complete button-margin">
                <button class="btn_complete" type="button" style="margin-right:5px!important;"><?=lang('reg_in_07');?></button>
                <button class="btn_back" type="button" style="margin-right:5px!important;"><?=lang('x_regl_31');?></button>
            </div>
            <?php if(isset($success)){ ?>
                <div class="col-md-12 ">
                    <div id="success-div" style="padding-bottom: 2%;padding-top: 2%;" class="col-md-12">
                        <h4><?= $suc = (isset($success) && $success)? lang('reg_in_10'):lang('reg_in_11');?></h4>
                        <span><?=lang('reg_in_12');?> <?=$this->session->userdata('email')?> .</span>
                        <span><strong><?=lang('reg_in_08');?>:</strong> <?=$info['account_number']?></span>
                        <span><strong><?=lang('reg_in_09');?>:</strong> <?=$info['trader_password']?></span>
                    </div>
                </div>
            <?php } ?>
            <?=form_close();?>
        </div>
    </div>
</div>
<script type="text/javascript">
var successTrading = false, successPersonal = false;
    $(document).ready(function() {
        var success_reg = "<?php echo (isset($success) && $success)?"done":'';?>";
        console.log(success_reg);
        if(success_reg=='done'){
            $("#error-validation").hide();
            $("#error-validation1").hide();
            $(".next-employment").hide();
            $(".next-trading").hide();
            $(".complete").hide();
            $("#success").addClass("active");
            $("#personal").removeClass("active");
            $("#employment").removeClass("active");
            $("#trading").removeClass("active");
            $(".employment").hide();
            $(".trading").hide();
            $(".complete").hide();

        }else{
           // $("#trading").click();
            $("#personal").click();
           // $(".next-employment").show();
        }
		
 
		
    });
	
	

	
	
    $("#personal").click(function(){
        $("#error-validation").hide();
        $("#error-validation1").hide();

       $(".personal").show();
        $(".next-trading").show();
        $("#personal").addClass("active");

        $("#employment").removeClass("active");
        $("#trading").removeClass("active");
        $("#success").removeClass("active");

        $(".trading").hide();
        $(".next-employment").hide();
            $(".employment").hide();
            $(".complete").hide();
        $("#success-div").hide();
        $("#arr-success").hide();
        $("#success").hide();
    });
    $("#trading").click(function(){
        $("#error-validation").hide();
        $("#error-validation1").hide();
        $("#trading").addClass("active");
        $("#employment").removeClass("active");
        $("#personal").removeClass("active");
        $(".personal").hide();
        $(".employment").hide();
        $(".trading").show();
        $(".complete").hide();
        $(".next-trading").hide();
        $(".next-employment").show();

        $("#success-div").hide();
        $("#success-div").hide();
        $("#arr-success").hide();
        $("#success").hide();
    });
    $("#employment").click(function(){
        $("#error-validation").hide();
        $("#error-validation1").hide();
        $("#employment").addClass("active");
        $("#personal").removeClass("active");
        $("#trading").removeClass("active");
        $(".personal").hide();
        $(".employment").show();
        $(".next-trading").hide();
        $(".next-employment").hide();
        $(".trading").hide();
        $(".complete").show();

        $("#success-div").hide();
        $("#arr-success").hide();
        $("#success").hide();
    });

    $("div.next-trading button.btn_next").click(function(){


        $("#error-validation").hide();
        $("#error-validation1").hide();
       var f1 = $("input[name='street']").val();
       var f2 = $("input[name='city']").val();
       var f3 = $("input[name='state']").val();
        var f4 = $("select[name='country']").val();
        var f5 = $("input[name='zip']").val();
        var f6 = $("input[name='phone']").val();
       var f7 = $("input[name='dob']").val();
        console.log(f1);
        console.log(f2);
        console.log(f3);
        console.log(f4);
        console.log(f5);
        console.log(f6);
        console.log(f7);
        if(f1!='' && f2!='' && f3!='' && f4!='' && f5!='' && f6!='' && f7!=''){
            $("#trading").click();
            console.log("valid");
            successPersonal = true;
        }else{
            successPersonal = false;
            $("#error-validation").show();
            console.log("prevent");
        }
        

      //  $("#trading").click();



    });
    $("div.complete button.btn_back").click(function(){
        $("#error-validation").hide();
        $("#error-validation1").hide();
        $("#trading").click();
    });
    $("div.next-employment button.btn_back").click(function(){
        $("#error-validation").hide();
        $("#error-validation1").hide();
        $("#personal").click();
    });
    $("div.next-employment button.btn_next").click(function(){
        $("#error-validation").hide();
        $("#error-validation1").hide();
        var agent = $("input[name='affiliate_code']").val();
        if(agent!=''){
            $.ajax({
                type: 'POST',
                url: '<?=FXPP::my_url('registration/checkAgent')?>',
                data: {code:agent},
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $("#employment").click();
                    }else{
                        $("#error-validation1").show();
                        $("#error-msg").text(response.error);
                    }
                },
                error: function (jqXHR, textStatus) { }
            });
        }else{
            $("#employment").click();
        }
    });
    $(".btn_complete").click(function () {
        document.getElementById("addAccount").submit();// Form submission
    });
    $(document).ready(function(){
        if ($('#mt_account_set_id').val() == 5 || $('#mt_account_set_id').val() == 6) {
            $('#mt_currency_base').append("<option>GBP</option>");
        }
        $('#mt_account_set_id').on('change', function () {
            var list = ["USD", "EUR"];
            var original = ["EUR", "USD", "RUR"];
            if ($('#mt_account_set_id').val() == 4 || $('#mt_account_set_id').val() == 7) {
                //$('#mt_account_set_id option[value=2]').remove();
                $('#mt_currency_base option').filter(function () {
                    return $.inArray(this.value, list) == -1
                }).hide()
            } else {
                $('#mt_currency_base').find('option').remove();
                for (var i = 0; i < original.length; i++) {
                    $('#mt_currency_base').append("<option>" + original[i] + "</option>");
                }
               // $('#mt_currency_base').val(selected);
            }
            if ($('#mt_account_set_id').val() == 5 || $('#mt_account_set_id').val() == 6) {
            $('#mt_currency_base').append("<option>GBP</option>");
        }
        });

        $("#risk").click(function(){ //FXMAIN-681
            if($(this).is(":checked")){
                bootbox.confirm({
                    title: "Understand Investment Risk",
                    message: "Selecting NO means cancellation of registration.",
                    buttons: {
                        confirm: {
                            label: 'Confirm',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'Cancel',
                            className: 'btn-danger'
                        }
                    },
                    callback: function(result){
                        if(result){
                            window.location.href = '<?=FXPP::my_url('my-account')?>';
                            $(".btn_next").prop("disabled", true);
                        }else{
                            $("#risk1").prop('checked', true);
                            $(".btn_next").prop("disabled", true);
                        }
                    }
                });
            }
        });

    });

</script>

<!-- Start tag Criteo OneTag -->

<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
<script type="text/javascript">
    window.criteo_q = window.criteo_q || [];
    var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
    window.criteo_q.push(
        { event: "setAccount", account: 82147},
        { event: "setEmail", email: "##User's email address##" }, // Can be an empty string
        { event: "setSiteType", type: deviceType},
        { event: "viewBasket", user_segment: "1", item: [
            {id: "1", price: 1, quantity: 1 }
//add a new entry for each product in your cart
        ]}
    );
</script>

<!-- End of tag Criteo OneTag -->



 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
   
        $("#registread_account_dob").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'yy-mm-dd',
           yearRange: getRangeYear(), 
        });
		
		 	
  } );
  $(document).on("blur","#registread_account_dob",function(){
		var data=$(this).val();
		if(data){
			
				 var res_date = data.split("-");

				 
				 
				var year =parseInt(res_date[0]); //(new Date(data)).getFullYear();
				var months =parseInt(res_date[1]);// (new Date(data)).getMonth();
				var days = parseInt(res_date[2]);//(new Date(data)).getDay();
				
					
					
					var d = new Date();
					var max_year = d.getFullYear()-10;
					 var min_year = d.getFullYear()-80;
					
					console.log(isNaN(days),"min year===>",min_year,"max year==>",max_year,"year=====>",year,"month=========>",months,"day========>",days);
					
					if((year>max_year) || (months>12) || (days>31) || (year<min_year) || (isNaN(year)==true) || (isNaN(months)==true) || (isNaN(days)==true) ){
						
						$(this).val("");
						alert("Wrong Date of Birth !");
						return false;
					}
					
					
				
			
		}
	 
  });
  
  
function getRangeYear(){
	
	var d = new Date();
  var max_year = d.getFullYear()-10;
  var min_year = d.getFullYear()-80;
  
  return min_year+':'+max_year;
	
}	  
  
  function isValidDate(s) {
  var separators = ['\\.', '\\-', '\\/'];
  var bits = s.split(new RegExp(separators.join('|'), 'g'));
  var d = new Date(bits[2], bits[1] - 1, bits[0]);
  return d.getFullYear() == bits[2] && d.getMonth() + 1 == bits[1];
} 
  
  
  </script>