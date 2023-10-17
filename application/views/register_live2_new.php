<?php if(IPLoc::StatusTask()){
/**<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">*/
} ?>

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
        /*float: right;*/
        margin: 5px;
    }
    .checkbox1{
        margin-right: 2px !important;
        margin-left: 5px!important;
    }
    .btn_complete,.btn_next,.btn_back{
        padding: 10px;
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
        padding: 15px;
    }
    .clickable-label {
        /*float: right!important;*/
        font-weight: unset!important;
        display: block!important;
    }
    .clickable-radio {
        width: 25%;
        margin-top: 10px;
        font-weight: unset!important;
    }
    .col-sm-4 {
        margin-top: 10px;
    }
    .remove-padding {
        padding-right: 0px;
        padding-left: 0px;
    }
    @media screen and (max-width:767px){
        .arrow-small-window {
            display: inline-block!important;
        }
        .arrow-big-window {
            display: none;
        }
        .col-responsive{
            width: 100%!important;
            text-align: left!important;
        }
        .personal-div {
            margin-bottom: -10px;
        }
        .trading-div {
            margin-bottom: -5px;
        }
        .arrow-margin-personal-1{
            margin-left: 38px!important;
            margin-bottom: -10px;
        }
        .arrow-margin-personal-2{
            margin-left: 48px!important;
            margin-bottom: -5px;
        }
        .arrow-margin-personal-3{
            margin-left: 42px!important;
        }
        .arrow-margin-personal-4{
            margin-left: 32px!important;
        }
        .control-label{
            margin-top: 3px!important;
        }
        .span-non-responsive{
            display: none!important;
        }
        .span-responsive{
            display: block!important;
            margin-top: -10px!important;
        }
        .terms-disclosure-container{
            text-align: center;
        }
        .terms, .disclosure, .sa-pk-terms, .sa-pk-disclosure, .span-divider{
            float: none!important;
        }
        .radio-responsive{
            margin-right: 10%!important;
        }
    }
<?php if(isset($success)){ ?>
    .col-width {
        width: 24%;
    }
    .col-trading-width{
        width: 28%;
    }
    .arrow-margin{
        margin-top: -5px;
        margin-bottom: 5px;
    }
<?php }else{ ?>
    .col-width {
        width: 31.5%;
    }
    .col-trading-width{
        width: 37%;
    }
    .arrow-margin{
        margin-top: -5px;
        margin-bottom: 5px;
        margin-left: -10px;
    }
<?php } ?>

    .terms{
        margin-top: 10px;
        float: right;
    }
    .disclosure{
        margin-top: 12px;
        float: left;
        margin-bottom: 10px;
    }
<?php if(FXPP::html_url() === 'sa' || FXPP::html_url() === 'pk'){?>
    .sa-pk-terms{
        float: left;
    }
    .sa-pk-disclosure{
        float: right;
    }
    .span-divider{
        float: left;
    }
<?php } ?>

<?php if(FXPP::html_url() === 'my' || FXPP::html_url() === 'id'){?>
    @media screen and (max-width:357px){
        .clickable-radio{
            width: 100%!important;
        }
    }
<?php }else{ ?>
    @media screen and (max-width:290px){
        .clickable-radio{
            width: 100%!important;
        }
    }
<?php } ?>
    .control-label{
        margin-top: 12px;
    }
    .span-divider{
        text-align: center;
        margin-top: 10px;
    }
    .radio-responsive{
        margin-left: 6%!important;
    }
    .disabled-tab {
        pointer-events:none;
        opacity:0.6;
    }
    .tab-hover:hover {
        cursor: pointer;
        text-decoration: none!important;
    }
    .red-border {
        border: 1px solid red;
    }
    .arrow-margin-personal-unresponsive-1{
        margin-left: -20px!important;
    }
    .arrow-margin-personal-unresponsive-2{
        margin-left: -10px!important;
    }
    .arrow-margin-personal-unresponsive-3{
        margin-left: -15px!important;
    }
    .arrow-margin-trading-unresponsive-1{
        margin-left: -25px!important;
    }
    .arrow-margin-trading-unresponsive-2{
        margin-left: -10px!important;
    }
    .arrow-margin-trading-unresponsive-3{
        margin-left: -12px!important;
    }
    .arrow-margin-success-unreponsive-1{
        margin-left: -15px!important;
    }
</style>

<h1>
    <?=lang('mya_01');?>
</h1>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<?php $this->load->view('account_nav.php');?>
<?php
$tab_col      = (isset($success)) ? 'col-sm-12' : 'col-sm-11';
$tab_margin   = (isset($success)) ? '20px' : '10px';
$col          = (isset($success)) ? 'col-sm-3' : 'col-sm-4';
//$form_col     = (isset($success)) ? 'col-md-10 col-sm-10' : 'col-md-12 col-sm-12';
?>
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

        <div class="row">
            <div class="form-group">
                <div class="col-md-10 col-sm-10" style="text-align:center; margin-left:10%;">
                    <ul class="registration-ul nav navbar-nav <?=$tab_col?>" style="float: none!important; display: inline-block;">
                        <div id='personal-div' class="<?=$col?> col-width remove-padding col-responsive">
                            <div class="form-group">
                                <div class="col-sm-11 remove-padding">
                                    <li id="personal" class="active"><i class="fa fa-flag circle-icon" aria-hidden="true"></i> <?=lang('x_regl_0');?>
                                        <img src="<?=$this->template->Images()?>nxt.png" id="personal-arrow" class="img-reponsive arrow-margin arrow-small-window arrow-margin-personal" width="50" style="display:none;">
                                    </li>
                                </div>
                                <div class="col-sm-1 remove-padding arrow-big-window">
                                    <li><img src="<?=$this->template->Images()?>nxt.png" id='personal-unresponsive' class="img-reponsive arrow-margin" width="50"></li>
                                </div>
                            </div>
                        </div>
                        <div id='trading-div' class="<?=$col?> col-trading-width remove-padding col-responsive">
                            <div class="form-group">
                                <div class="col-sm-11 remove-padding">
                                    <li id="trading" class="active"><i class="fa fa-flag circle-icon" aria-hidden="true"></i> <?=lang('x_regl_1');?>
                                        <img src="<?=$this->template->Images()?>nxt.png" class="img-reponsive arrow-margin arrow-small-window" width="50" style="display:none;">
                                    </li>
                                </div>
                                <div class="col-sm-1 remove-padding arrow-big-window">
                                    <li><img src="<?=$this->template->Images()?>nxt.png" id='trading-unresponsive' class="img-reponsive arrow-margin" width="50"></li>
                                </div>
                            </div>
                        </div>
                        <div class="<?=$col?> col-width remove-padding col-responsive">
                            <div class="form-group">
                                <div class="col-sm-12 remove-padding">
                                    <li id="employment"><i class="fa fa-flag circle-icon" aria-hidden="true"></i> <?=lang('x_regl_2');?>
                                        <?php if(isset($success)){ ?>
                                            <img src="<?=$this->template->Images()?>nxt.png" class="img-reponsive arrow-margin arrow-small-window" width="50" style="display:none; margin-left: 4px!important;">
                                        <?php } ?>
                                    </li>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($success)){ ?>
                            <div class="<?=$col?> col-width remove-padding col-responsive">
                                <div class="form-group">
                                    <div class="col-sm-1 remove-padding arrow-big-window">
                                        <li><img src="<?=$this->template->Images()?>nxt.png" id='success-unresponsive' class="img-reponsive arrow-margin" width="50"></li>
                                    </div>
                                    <div class="col-sm-11 remove-padding">
                                        <li id="success"><i class="fa fa-flag circle-icon" aria-hidden="true"></i> <?=lang('reg_in_03');?></li>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        <body data-spy="scroll" data-target=".navbar" data-offset="50">

        <div class="row">

            <div class="form-group">

                <div class="col-md-10 col-sm-10 div-reg" style="margin-left: 10%; margin-right:8%">
                    <?php if(isset($success) && !$success){?>
                        <div class="alert alert-danger">
                            <?php echo $errors; ?>
                        </div>
                    <?php } ?>

                    <?= form_open(FXPP::loc_url('registration'),array('id' => 'addAccount','class'=> "addAcc $form_col", 'enctype'=>"multipart/form-data"),''); ?>

                    <div id="personal-div" class="personal form-container">
                        <h4><?=lang('x_regl_0');?></h4>
                        <div id="error-validation" style="padding:5px;text-align: center;color: red;display: none;">
                            <span id="span-error">All fields are required. </span>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('reli_01');?>:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control round-0 required" maxlength="90" placeholder="<?=lang('reli_01_1');?>" name="street" value="<?php echo isset($api_details_emailname['Address']) ? $api_details_emailname['Address'] : '' ?>" <?= isset($api_details_emailname['Address'])?'readonly':'';?>>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('reli_02');?>:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control round-0 required" maxlength="30" placeholder="<?=lang('reli_02');?>" name="city" value="<?php echo isset($api_details_emailname['City']) ? $api_details_emailname['City'] : '' ?>" <?= isset($api_details_emailname['City'])?'readonly':'';?>>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('reli_03');?>:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control round-0 required" maxlength="30" placeholder="<?=lang('reli_03');?>" name="state" value="<?php echo isset($api_details_emailname['State']) ? $api_details_emailname['State'] : '' ?>" <?= isset($api_details_emailname['State'])?'readonly':'';?>>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('reli_04');?>:</label>
                            <div class="col-sm-8">
                                <select class="form-control round-0 required" id="country" name="country"  <?= isset($api_details_emailname['LogIn'])?'readonly':'';?>><?php echo  $countries;?></select>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('reli_05');?>:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control round-0 required" maxlength="15" placeholder="<?=lang('reli_05');?>" name="zip" value="<?= $zip = isset($api_details_emailname['ZipCode']) ? $api_details_emailname['ZipCode']:'';?>" <?= isset($api_details_emailname['ZipCode'])?'readonly':'';?>>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('reli_06');?>:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control round-0 required" maxlength="16" placeholder="<?=lang('reli_06');?>" id="phone" name="phone" value="<?php echo isset($api_details_emailname['PhoneNumber']) ? $api_details_emailname['PhoneNumber'] : '+'.$calling_code ?>" <?= isset($api_details_emailname['PhoneNumber']) && strlen($api_details_emailname['PhoneNumber'])>1 ?'readonly':'';?>>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('reli_07');?>:</label>
                            <div class="col-sm-8">
                                <?php if(IPLoc::StatusTask()) { ?>
<!--                                    <div class="input-group date" data-provide="datepicker">-->
<!--                                        <input type="text" class="form-control required"-->
<!--                                               name="dob"-->
<!--                                               value="--><?php //echo isset($user_details_emailname['dob']) ? date('Y-m-d', strtotime($user_details_emailname['dob'])) : '' ?><!--"-->
<!--                                               readonly="readonly"-->
<!--                                               placeholder="--><?//=lang('reli_07');?><!--">-->
<!--                                        <div class="input-group-addon">-->
<!--                                            <span class="glyphicon glyphicon-th"></span>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                <div class="input-group datetimepick" style="width: 100%">
                                    <input id="contattaci"
                                           type="text"
                                           class="dob-input form-control round-0 datepicker  birthdate age-input date-input mendetoryField required"
                                           name="dob"
                                           value="<?php echo isset($user_details_emailname['dob']) ? date('Y-m-d', strtotime($user_details_emailname['dob'])) : '' ?>"
                                           readonly
                                           placeholder="<?=lang('reli_07');?>"
                                    >
                                </div>
                                <?php }else{ ?>
                                <input type="text" class="form-control round-0 datepicker required" placeholder="<?=lang('reli_07');?>" name="dob" value="<?php echo isset($user_details_emailname['dob']) ? date('Y-m-d', strtotime($user_details_emailname['dob'])) : '' ?>" readonly>
                                <?php } ?>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group next-trading">
                            <div class="col-sm-12" style="margin-left: 5px;">
                                <button class="btn_next" type="button"><?=lang('reg_in_04');?></button>
                                <button class="btn_back" type="button" style="margin-right:5px!important;" onclick="window.location.href='<?=FXPP::my_url('my-account')?>'"><?=lang('reg_in_05');?></button>
                            </div>
                        </div>
                    </div>

                    <div id="trading-div" class="trading form-container">
                        <h4><?=lang('reli_h2');?></h4>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('x_regl_15');?>:</label>
                            <div class="col-sm-8">
                                <select class="form-control round-0 required" name="mt_account_set_id" id="mt_account_set_id"><?php echo $account_type;?></select>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('x_regl_16');?>:</label>
                            <div class="col-sm-8">
                                <select class="form-control round-0 required" name="mt_currency_base" id="mt_currency_base"><?php echo $account_currency_base;?></select>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('x_regl_17');?></label>
                            <div class="col-sm-8">
                                <select class="form-control round-0 required" name="leverage" id="xleverage"><?php echo $leverage;?></select>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <div class="col-sm-4"></div>
                            <label class="col-sm-8 clickable-label" style="margin-top: 10px;">
                                <input name="swap_free" class="checkbox1" <?php echo isset($user_details['swap_free']) ? $user_details['swap_free'] ? ' checked' : '' : '' ?> value="1" type="checkbox"/><?=lang('reli_15');?>
                            </label>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8">
                                <p style="margin-top:2%;margin-left:5px;">I declare that I have carefully read and fully understood the entire text of the <a href="<?= $this->template->pdf() . rawurlencode('Swap-Free Trading Account Agreement.pdf') ?>" target="_blank" style="font-weight:bold;">Swap-Free Trading Account Agreement</a> with which I fully understand, accept, and agree.</p>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" style="margin-top: 20px;"><?=lang('x_regl_19');?>:</label>
                            <div class="col-sm-8">
                                <p style="margin-top:2%;margin-left:5px;"><?=lang('x_regl_20');?></p>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <div class="col-sm-4"></div>
                            <label class="col-sm-8 clickable-label">
                                <input id="agree-1" class="checkbox1"  type="checkbox" name="experience" <?php echo isset($user_details_emailname['trading_experience_value'][0]) ? $user_details_emailname['trading_experience_value'][0] ? ' checked' : '' : '' ?> value="1"/><span><?=lang('reli_18');?></span>
                            </label>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <div class="col-sm-4"></div>
                            <label class="col-sm-8 clickable-label">
                                <input id="agree-2" class="checkbox1"  type="checkbox" name="experience" <?php echo isset($user_details_emailname['trading_experience_value'][0]) ? $user_details_emailname['trading_experience_value'][1] ? ' checked' : '' : '' ?> value="2"/><span><?=lang('reli_19');?></span>
                            </label>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <div class="col-sm-4"></div>
                            <label class="col-sm-8 clickable-label">
                                <input id="agree-3" class="checkbox1"  type="checkbox" name="experience"<?php echo isset($user_details_emailname['trading_experience_value'][0]) ? $user_details_emailname['trading_experience_value'][2] ? ' checked' : '' : '' ?> value="3"/><span><?=lang('reli_20');?></span>
                            </label>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" style="margin-top: 20px;"><?=lang('x_regl_24');?>:</label>
                            <div class="col-sm-8">
                                <p style="margin-top:2%;margin-left:5px;"><?=lang('x_regl_25');?></p>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8">
                                <select class="form-control round-0 required" name="investment_knowledge" id="investment_knowledge"><?php echo $investment_knowledge;?></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('x_regl_26');?>:</label>
                            <div class="col-sm-8">
                                <select class="form-control round-0 required" name="trade_duration" id="trade_duration"><?php echo $trade_duration;?></select>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('x_regl_27');?>:</label>
                            <div class="col-sm-8">
                                <label class="clickable-radio" style="margin-right: 15px;">
                                    <input style="margin-right: 25%;" value="1"<?php echo isset($user_details['politically_exposed_person']) ? $user_details_emailname['politically_exposed_person'] ? ' checked' : '' : '' ?> id="politically_exposed_person1" type="radio" class="rdo-btn-required radio-responsive" name="politically_exposed_person" /><span><?=lang('reli_ye');?></span>
                                </label>
                                <label class="clickable-radio">
                                    <input style="margin-right: 25%;" value="0"<?php echo isset($user_details['politically_exposed_person']) ? $user_details_emailname['politically_exposed_person'] ? '' : ' checked' : ' checked' ?> id="politically_exposed_person" type="radio" class="rdo-btn-required radio-responsive" name="politically_exposed_person" /><span><?=lang('reli_no');?></span>
                                </label>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('x_regl_28');?>:</label>
                            <div class="col-sm-8">
                                <label class="clickable-radio" style="margin-right: 15px;">
                                    <input style="margin-right: 25%;" value="1"<?php echo isset($user_details['risk']) ? $user_details_emailname['risk'] ? ' checked' : '' : ' checked' ?> id="risk1" type="radio" class="rdo-btn-required radio-responsive" name="risk" /><span><?=lang('reli_ye');?></span>
                                </label>
                                <label class="clickable-radio">
                                    <input style="margin-right: 25%;" value="0"<?php echo isset($user_details['risk']) ? $user_details_emailname['risk'] ? '' : ' checked' : '' ?> id="risk" type="radio" class="rdo-btn-required radio-responsive" name="risk" /><span><?=lang('reli_no');?></span>
                                </label>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('x_regl_41');?>:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control round-0 required" maxlength="32" value="<?php echo !empty($aff_code) ? $aff_code: '' ;?>" name="affiliate_code">
                            </div>
                        </div>
                        <div class="form-group terms-disclosure-container" style="font-weight: bold;">
                            <div class="col-sm-5 sa-pk-terms">
                                <a href="<?= $this->template->pdf() . rawurlencode('Terms and Conditions.pdf') ?>" target="_blank" class="terms">Terms and Conditions</a>
                            </div>
                            <div class="col-sm-2 span-divider">
                                <span class="span-non-responsive">|</span>
                                <span class="span-responsive" style="display: none;"><hr style="width: 150px; border-top: 1px solid #555!important; margin-bottom: 8px;"></span>
                            </div>
                            <div class="col-sm-5 sa-pk-disclosure">
                                <a href="<?= $this->template->pdf() . rawurlencode('Risk Disclosure.pdf') ?>" target="_blank" class="disclosure">Risk Disclosure</a>
                            </div>
                            <?php /**
                            <div class="col-sm-12" style="text-align: center!important; font-weight: bold; font-size: 15px; margin-top:15px; margin-bottom:15px;">
                                <a href="<?= $this->template->pdf() . rawurlencode('Terms and Conditions.pdf') ?>" target="_blank">Terms and Condition</a>
                                <span style="margin-left: 8%; margin-right: 8%;">|</span>
                                <a href="<?= $this->template->pdf() . rawurlencode('Risk Disclosure.pdf') ?>" target="_blank">Risk Disclosure</a>
                            </div>
                            */?>
                        </div>
                        <div id="error-validation1" style="padding:5px;text-align: center;color: red;display: none;">
                            <span id="error-msg"></span>
                        </div>
                        <div class="form-group next-employment">
                            <div class="col-sm-12" style="margin-left: 5px;">
                                <button class="btn_next" type="button"><?=lang('reg_in_06');?></button>
                                <button class="btn_back" type="button" style="margin-right:5px!important;"><?=lang('x_regl_31');?></button>
                            </div>
                        </div>
                    </div>

                    <div id="employment-div" class="employment form-container" style="text-align: left;">
                        <h4><?=lang('x_regl_33');?></h4>
                        <div id="error-validation" style="padding:5px;text-align: center;color: red;display: none;">
                            <span>All fields are required. </span>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('x_regl_34');?>:</label>
                            <div class="col-sm-8">
                                <select id="employment_status1" class="form-control round-0 required" name="employment_status1" <?= isset($employment_status)?'disabled':'';?>><?php echo $employment_status;?></select>
                                <input id="employment_status" type="hidden" name="employment_status" value="<?php echo $user_details_emailname['employment_status'];?>"/>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('x_regl_35');?>:</label>
                            <div class="col-sm-8">
                                <select class="form-control round-0 required" name="estimated_annual_income1" id="estimated_annual_income1" <?= isset($estimated_annual_income)?'disabled':'';?>><?php echo $estimated_annual_income;?></select>
                                <input id="estimated_annual_income" type="hidden" name="estimated_annual_income"value="<?php echo $user_details_emailname['estimated_annual_income'];?>"/>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('x_regl_36');?>:</label>
                            <div class="col-sm-8">
                                <select class="form-control round-0 required" name="estimated_annual_income1" id="estimated_annual_income1" <?= isset($estimated_annual_income)?'disabled':'';?>><?php echo $estimated_annual_income;?></select>
                                <input id="estimated_annual_income" type="hidden" name="estimated_annual_income"value="<?php echo $user_details_emailname['estimated_annual_income'];?>"/>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('x_regl_37');?>:</label>
                            <div class="col-sm-8">
                                <select class="form-control round-0 required" name="estimated_net_worth1" id="estimated_net_worth1" <?= isset($estimated_net_worth)?'disabled':'';?>><?php echo $estimated_net_worth;?></select>
                                <input id="estimated_net_worth" type="hidden" name="estimated_net_worth" value="<?php echo $user_details_emailname['estimated_net_worth'];?>"/>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('x_regl_38');?>:</label>
                            <div class="col-sm-8">
                                <select class="form-control round-0 required" name="education_level1" id="education_level1" <?= isset($education_level)?'disabled':'';?>><?php echo $education_level;?></select>
                                <input id="education_level" type="hidden" name="education_level" value="<?php echo $user_details_emailname['education_level'];?>"/>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label style="margin-bottom:5px; margin-top:5px;"><?=lang('x_regl_39');?> <?php echo isset($user_details_emailname['us_resident']) ? $user_details_emailname['us_resident'] ? 'Yes' : ' No' : '' ?></label>
                                <input id="us_resident" type="hidden" name="us_resident" value="<?php echo $user_details_emailname['us_resident'];?>"/>
                                <br>
                                <label style="margin-right: 2%;"><?=lang('x_regl_40');?> <?php echo isset($user_details_emailname['us_resident']) ? $user_details_emailname['us_resident'] ? 'Yes' : ' No' : '' ?></label>
                                <input id="us_citizen" type="hidden" name="us_citizen" value="<?php echo $user_details_emailname['us_resident'];?>"/>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="form-group complete">
                            <div class="col-sm-12" style="margin-left: 5px;">
                                <button class="btn_complete" type="button"><?=lang('reg_in_07');?></button>
                                <button class="btn_back" type="button" style="margin-right:5px!important;"><?=lang('x_regl_31');?></button>
                            </div>
                        </div>
                    </div>

                    <?php if(isset($success)){ ?>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div id="success-div" class="col-md-12" style="padding-bottom: 2%;padding-top: 2%;">
                                <h4><?= $suc = (isset($success) && $success)? lang('reg_in_10'):lang('reg_in_11');?></h4>
                                <span><?=lang('reg_in_12');?> <?=$this->session->userdata('email')?></span>
                                <span><strong><?=lang('reg_in_08');?>:</strong> <?=$info['account_number']?></span>
                                <span><strong><?=lang('reg_in_09');?>:</strong> <?=$info['trader_password']?></span>
                                <?php if(IPLoc::Office()){  if(isset($save_hash) && $save_hash['auto_verified']){ ?>
                                    <h5><i>The automatic verification is available only within 6 months after your first verified account is opened.  Please, remember to verify this newly-registered account.</i></h5>
                                <?php } } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?=form_close();?>

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        var success_reg = "<?php echo (isset($success) && $success)?"done":'';?>";
        // console.log(success_reg);

        var getWidth = 0;
        $(window).resize(function() {

            getWidth = $(window).width();

            if(success_reg === 'done'){

                $('#success-unresponsive').addClass('arrow-margin-success-unresponsive-1');
                $('#personal-unresponsive').addClass('arrow-margin-personal-unresponsive-3');
                $('#trading-unresponsive').addClass('arrow-margin-trading-unresponsive-3');

            }else{

                if(getWidth > 991 && getWidth < 1095){

                    $('#personal-unresponsive').addClass('arrow-margin-personal-unresponsive-2');
                    $('#personal-unresponsive').removeClass('arrow-margin-personal-unresponsive-1');
                    $('#trading-unresponsive').addClass('arrow-margin-trading-unresponsive-1');
                    $('#trading-unresponsive').removeClass('arrow-margin-trading-unresponsive-2');

                    if(getWidth < 1030){
                        $('#trading-unresponsive').addClass('arrow-margin-trading-unresponsive-2');
                        $('#trading-unresponsive').removeClass('arrow-margin-trading-unresponsive-1');
                    }

                }else if(getWidth > 778 && getWidth < 828){

                    $('#personal-unresponsive').addClass('arrow-margin-personal-unresponsive-2');
                    $('#personal-unresponsive').removeClass('arrow-margin-personal-unresponsive-1');
                    $('#trading-unresponsive').addClass('arrow-margin-trading-unresponsive-1');
                    $('#trading-unresponsive').removeClass('arrow-margin-trading-unresponsive-2');

                }else if(getWidth > 678 && getWidth < 779){

                    $('#personal-unresponsive').addClass('arrow-margin-personal-unresponsive-2');
                    $('#personal-unresponsive').removeClass('arrow-margin-personal-unresponsive-1');
                    $('#trading-unresponsive').addClass('arrow-margin-trading-unresponsive-2');
                    $('#trading-unresponsive').removeClass('arrow-margin-trading-unresponsive-1');

                } else{
                    $('#personal-unresponsive').addClass('arrow-margin-personal-unresponsive-1');
                    $('#personal-unresponsive').removeClass('arrow-margin-personal-unresponsive-2');
                    $('#trading-unresponsive').addClass('arrow-margin-trading-unresponsive-2');
                    $('#trading-unresponsive').removeClass('arrow-margin-trading-unresponsive-1');
                }

            }

        });

        if(success_reg === 'done'){
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

            $("#success").addClass("active");
            $("#personal").removeClass("active");
            $("#employment").removeClass("active");
            $("#trading").removeClass("active");
            $("#personal").addClass("disabled-tab");

            if(getWidth <= 767){
                personalArrow('success');
            }

        }else{
            // $("#trading").click();
            $("#personal").click();
            // $(".next-employment").show();
        }

        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'yy-mm-dd',
            yearRange: "-95:+0"
            //  defaultDate: '1920-01-01'
        });

        // $('.datepicker').datepicker({
        //     format: 'mm/dd/yyyy',
        //     startDate: '-3d'
        // });
    });

    var getWidth = 0;
    $(window).resize(function() {
        getWidth = $(window).width();
    });

    $("#trading").addClass("disabled-tab");
    $("#employment").addClass("disabled-tab");

    $("#xleverage option[value='1:66']").remove();
    $("#xleverage option[value='1:88']").remove();

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

        if(getWidth <= 767){
            personalArrow('personal');
        }
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

        if(getWidth <= 767){
            personalArrow('trading');
        }
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

        if(getWidth <= 767){
            personalArrow('employment');
        }
    });

    $("div.next-trading button.btn_next").click(function(){

        $("#trading").removeClass("active");
        $("#trading").addClass("active");
        $("#trading").removeClass("disabled-tab");

        $("#error-validation").hide();
        $("#error-validation1").hide();
        var f1 = $("input[name='street']").val();
        var f2 = $("input[name='city']").val();
        var f3 = $("input[name='state']").val();
        var f4 = $("select[name='country']").val();
        var f5 = $("input[name='zip']").val();
        var f6 = $("input[name='phone']").val();
        var f7 = $("input[name='dob']").val();

        if(f1!='' && f2!='' && f3!='' && f4!='' && f5!='' && f6!='' && f7!=''){

            $("#error_phone_number").css("display","none");
            $("#phone").removeClass("red-border");
            if (f6.indexOf('+') > -1) {
                if(f6.indexOf('+') === 0 && (f6.split("+").length - 1) === 1){
                    $("#trading").click();
                    console.log("valid");
                }else{
                    $("#error_phone_number").css("display","block");
                    $("#phone").addClass("red-border");
                    $("#error_phone_number").text("+ sign should be placed at the beginning of Phone Number field.");
                    console.log("prevent");
                }
            }else{
                $("#trading").click();
                console.log("valid");
            }

        }else{
            $("#span-error").text("All fields are required.");
            $("#error-validation").show();
            console.log("prevent");
        }
        // $("#trading").click();
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

        $("#trading").removeClass("active");
        $("#employment").addClass("active");
        $("#employment").removeClass("disabled-tab");

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

        $("#politically_exposed_person1").click(function(){
            if($(this).is(":checked")){
                bootbox.confirm({
                    title: "Politically Exposed Person",
                    message: "Selecting YES means cancellation of registration.",
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
                            $("#politically_exposed_person").prop('checked', true);
                            $(".btn_next").prop("disabled", true);
                        }
                    }
                });
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

        $("#phone").keypress(function (e){ //FXMAIN-673
            console.log(e.keyCode);
            validatePhoneNumber(e);
        });
        $('#phone').on("paste", function(e) {
            // $("#d2").text('paste. not allowed!');
            e.preventDefault();
        });

        $("#personal").hover(function(){
            $(this).addClass("tab-hover");
            $("#trading").removeClass("tab-hover");
            $("#employment").removeClass("tab-hover");
            $("#success").removeClass("tab-hover");
        }, function(){
            $(this).removeClass("tab-hover");
        });

        $("#trading").hover(function(){
            $(this).addClass("tab-hover");
            $("#personal").removeClass("tab-hover");
            $("#employment").removeClass("tab-hover");
            $("#success").removeClass("tab-hover");
        }, function(){
            $(this).removeClass("tab-hover");
        });

        $("#employment").hover(function(){
            $(this).addClass("tab-hover");
            $("#personal").removeClass("tab-hover");
            $("#trading").removeClass("tab-hover");
            $("#success").removeClass("tab-hover");
        }, function(){
            $(this).removeClass("tab-hover");
        });

        $("#success").hover(function(){
            $(this).addClass("tab-hover");
            $("#personal").removeClass("tab-hover");
            $("#trading").removeClass("tab-hover");
            $("#employment").removeClass("tab-hover");
        }, function(){
            $(this).removeClass("tab-hover");
        });

    });

    function validatePhoneNumber(e){
        // console.log(e);
        // Allow: backspace, delete, tab, escape, enter, plus sign and .
        if ($.inArray(e.keyCode, [43, 8, 9, 27, 13]) !== -1 ||
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            (e.keyCode === 43 && e.shiftKey === true)){ //Plus sign
            return;
        }
        if(isNaN(String.fromCharCode(e.which))){
            e.preventDefault();
        }
    }
</script>
<script>
    $(document).ready(function(){

    <?php if(IPLoc::StatusTask()){ ?>

        // $( ".datepicker" ).datepicker({
        //     changeMonth: true,
        //     changeYear: true,
        //     dateFormat:'yy-mm-dd',
        //     yearRange: "-95:-18",
        //     minDate: '-95Y',
        //     maxDate: '-18Y'
        // });
        //
        // $('.dob-input').on('change', function(e) {
        //     // e.preventDefault();
        //     if ($('.dob-input').val().length > 0) {
        //         var age  = getAge($(this).val());
        //         $('input[name=age]').val(age);
        //         console.log(age);
        //     }
        // });
        //
        // $(".birthdate").on("keypress keyup blur",function (event) { /**FXPP-9793*/
        //     if ((event.which != 46 || $(this).val().indexOf('.') != -1) || (event.which < 48 || event.which > 57)) {
        //         event.preventDefault();
        //     }
        // });

    <?php }else { ?>
        // $(".datepicker").datepicker({
        //     changeMonth: true,
        //     changeYear: true,
        //     dateFormat:'yy-mm-dd',
        //     yearRange: "-95:+0"
        //     //  defaultDate: '1920-01-01'
        // });
    <?php } ?>

    });

    function getAge(dateString) {
        var today = new Date();
        var birthDate = new Date(dateString);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }

    function personalArrow(tab) {

        $('#personal-div').addClass('personal-div');
        $('#trading-div').addClass('trading-div');

        switch (tab) {
            case 'personal':
                $('#personal-arrow').addClass("arrow-margin-personal-1");
                $('#personal-arrow').removeClass("arrow-margin-personal-2");
                $('#personal-arrow').removeClass("arrow-margin-personal-3");
                $('#personal-arrow').removeClass("arrow-margin-personal-4");
                break;
            case 'trading':
                $('#personal-arrow').addClass("arrow-margin-personal-2");
                $('#personal-arrow').removeClass("arrow-margin-personal-1");
                $('#personal-arrow').removeClass("arrow-margin-personal-3");
                $('#personal-arrow').removeClass("arrow-margin-personal-4");
                break;
            case 'employment':
                $('#personal-arrow').addClass("arrow-margin-personal-3");
                $('#personal-arrow').removeClass("arrow-margin-personal-1");
                $('#personal-arrow').removeClass("arrow-margin-personal-2");
                $('#personal-arrow').removeClass("arrow-margin-personal-4");
                break;
            case 'success':
                $('#personal-arrow').addClass("arrow-margin-personal-4");
                $('#personal-arrow').removeClass("arrow-margin-personal-1");
                $('#personal-arrow').removeClass("arrow-margin-personal-2");
                $('#personal-arrow').removeClass("arrow-margin-personal-3");
                break;
        }
    }
</script>
