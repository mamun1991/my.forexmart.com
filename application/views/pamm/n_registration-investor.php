<style type="text/css">
    .page{
        display:none;
    }
</style>
<div class="pamm-onclick-page destination-class page" id="pamm-div-investor">
    <?=$nav?>
    <div id="my-tab-content" class="tab-content pamm-tab-content">
        <div class="tab-pane active" id="pamm-profile">

            <?php if(isset($_SESSION['investor_update'])){?>
                <div id="investor_registration_prompt" style="text-align: center;">
                    <?php if($_SESSION['investor_success']==True){?>
                        <div class="alert alert-success"><strong>Investor Update:</strong>  Update is successful.</div>
                    <?php }else{?>
                        <div class="alert alert-warning"><strong>Investor Update:</strong>  Update failed.</div>
                    <?php }?>
                </div>
                <?php unset($_SESSION['investor_update']);?>
            <?php }else{?>

            <?php } ?>
            <?php if(isset($_SESSION['investor_register'])){?>

                <div id="investor_registration_prompt" style="text-align: center;">

                    <?php if($_SESSION['investor_success']==True){?>
                        <div class="alert alert-success"><strong>Registration Update:</strong>  Registration is successful.</div>
                    <?php }else{?>
                        <div class="alert alert-warning"><strong>Registration Update:</strong>  Registration failed.</div>
                    <?php }?>
                </div>

                <?php unset($_SESSION['investor_register']);?>
            <?php }else{?>

            <?php } ?>

                <form action="<?=FXPP::my_url('pamm')?>" method="post"  id="investor_registration" accept-charset="UTF-8" autocomplete="off">
                    <input type="hidden" value="investor" name="type" />
                    <div class="pamm-content-input deact">
                        <style type="text/css">
                            body{color: #333!important;}
                            .custom_h1{font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 18px;color: #333;}
                            .custom_h1_uline{border-bottom: 1px solid rgb(41, 136, 202);}
                        </style>

                        <div class="custom_h1_uline">
                            <label class="custom_h1">
                                <?= lang('pamm_30'); ?>
                            </label>
                        </div>
                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <label for="investorname" data-toggle="tooltip" data-placement="top"  title="<?=(lang('pamm_31_title')!='')?lang('pamm_31_title'):'Short name of your PAMM project to be displayed in Monitoring.'; ?>" ><?= lang('pamm_31'); ?></label>
                            <input type="text" class="form-control round-0" placeholder="Name" name="investorname" id="investorname" value="<?= set_value('investorname') == false ? $investor_name : set_value('investorname') ?>" />
                            <span class="red"><?php echo  form_error('investorname')?> </span>
                        </div>
                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <label for="investorskype"><?= lang('pamm_32'); ?></label>

                                    <input type="text" class="form-control round-0" name="investorskype" id="investorskype" placeholder="Skype" value="<?= set_value('investorskype') == false ?  (isset($infor['skype'])?$infor['skype']:"") : set_value('investorskype') ?>"/>
                                    <span class="red"><?php echo  form_error('investorskype')?> </span>

                        </div>

                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <label for="investoricq"><?= lang('pamm_33'); ?></label>

                                    <input maxlength="9" type="text" class="form-control round-0" name="investoricq" id="investoricq" placeholder="ICQ" value="<?= set_value('investoricq') == false ? (isset($infor['icq'])?$infor['icq']:"") : set_value('investoricq') ?>" />
                                    <span class="red"><?php echo  form_error('investoricq')?> </span>

                        </div>

                    </div>
                    <div class="pamm-content-input deact">
                        <div class="custom_h1_uline">
                            <label class="custom_h1">
                                <?= lang('pamm_34'); ?>
                            </label>
                        </div>

                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">

                            <?php  if (isset($infor['confirminvestmentrefund']) && ($infor['confirminvestmentrefund']==1 )){
                                $check0='checked';
                            }else{
                                $check0='';
                            }  ?>

                            <input type="checkbox" name="investorciw" id="investorciw"  value="<?= set_value('investorciw', 1 ,TRUE);?>" <?= set_value('investorciw') == false ? $check0 :  (set_value('investorciw')==1)?'checked':''  ?> />
                            <label id="lbl_ciw" data-toggle="tooltip" data-placement="top"  title="<?=(lang('invstr_reg_01')!='')?lang('invstr_reg_01'):'It is designed to protect every investment from accidental withdrawal. If the option is enabled, you will have to confirm every withdrawal of the investment from PAMM trader account'; ?>">
                                <!--Confirm investment withdrawal-->
                                <?= lang('pamm_35'); ?>
                            </label>
                        </div>
                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <label for="investorlangauge" id="lbl_investorlangauge"><?= lang('pamm_36'); ?></label>
                            <select class="form-control round-0 margin-ref select-box" name="investorlangauge" id="investorlangauge">
                                <option default="" selected="" value="en">
                                    <!--English-->
                                    <?= (lang('pamm_en')!='')?lang('pamm_en'):'English' ;?>
                                </option>
                                <option value="ru">
                                    <!--Русский-->
                                    <?= (lang('pamm_ru')!='')?lang('pamm_ru'):'Русский' ;?>
                                </option>
                            </select>
                        </div>
                        <script type="text/javascript">
                            $().ready(function(){
                                $('select[name=investorlangauge]').val('<?= set_value('investorlangauge') == false ? (isset($infor['cfglang'])?$infor['cfglang']:"en") : set_value('investorlangauge') ?>');
                                $('select[name=investorlangauge]').select2({});
                            });
                        </script>
                    </div>
                    <div class="pamm-content-input ">
                        <?php if($investor_registration==true){?>
                        <div class="custom_h1_uline">
                            <label class="custom_h1">
                                <?= lang('pamm_37'); ?>
                            </label>
                        </div>
                        <?php }?>
                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">

                            <?php if($investor_registration==true){?>

                                <?php  if (isset($infor['deactivatepamm']) && ($infor['deactivatepamm']==1 )){
                                    $check1='checked';
                                }else{
                                    $check1='';
                                } ?>

                            <input type="checkbox" name="investor_checkbox_deactivate" id="investor_checkbox_deactivate" class="custom_a"  value="1" <?= set_value('investor_checkbox_deactivate') == false ? $check1 :  (set_value('investor_checkbox_deactivate')==1)?'checked':''  ?> />

                            <label id="lbl_dps" data-toggle="tooltip" data-placement="top"  title="<?=(lang('invstr_reg_03')!='')?lang('invstr_reg_03'):'This operation is transient, so you need to return all investments.'; ?>">
                                <!--Deactivate  PAMM System-->
                                <?= lang('pamm_37'); ?>
                            </label>

                            <?php }?>

                            <style type="text/css">
                                .custom_a{
                                    margin: 10px auto;
                                    display: table;
                                    background: rgb(41, 136, 202) none repeat scroll 0% 0%;
                                    color: rgb(255, 255, 255);
                                    padding: 8px 20px;
                                    border: medium none;
                                    transition: all 0.3s ease 0s;
                                    cursor: pointer;
                                    text-decoration: none;
                                }
                                #investor_deactivate:hover {
                                    color: rgb(255, 255, 255);
                                    text-decoration: none;
                                }
                            </style>

                            <?php if($investor_registration==true){?>
                                <button type="submit" name="formbutton" value="update">
                                    <!--Update-->
                                    <?= lang('pamm_38'); ?>
                                </button>
                            <?php }else{?>
                                <button type="submit" name="formbutton" value="register">
                                    <!--Register-->
                                    <?= (lang('pamm_132')!="")?lang('pamm_132'):'Register'; ?>
                                </button>
                            <?php }?>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
<style type="text/css">
    /*custom*/
    .select2-container{  width:100%;height: auto;  }
    .select2-container .select2-choice{  border-radius: 0px!important;  height: 32px!important;  }
    .select2-container ,.select2-choice  ,.select2-arrow{  border-radius: 0px!important;  }
    .select2-drop-active{  border-width: medium 2px 2px!important;  }
    /*custom*/
    .red{color:red}
    /*custom*/
</style>
<style type="text/css">
    .a-reg-btn{
        margin: 10px auto;
        display: table;
        background: rgb(41, 136, 202) none repeat scroll 0% 0%;
        color: rgb(255, 255, 255);
        padding: 8px 20px;
        border: medium none;
        transition: all 0.3s ease 0s;
    }
    .check{cursor: pointer;}
    .fa {
        padding-right: 0;
    }

    a {
        color: #5874BF;
        text-decoration: none;
    }
    a:hover {
        color: #112763;
    }

    .pamm-landing-page {
        display:table;
        margin-bottom:20px;
    }

    .pamm-landing-intro p {
        padding:10px 0;
        text-align:justify;
    }

    .pamm-landing-intro p , .pamm-landing-intro ul {
        margin-bottom:0!important;
    }

    .pamm-landing-agreement h1 {
        text-align:center;
        font-size:20px;
        color:#2988CA;
    }

    .pamm-agreement-content {
        width:90%;
        margin:20px auto;
        padding:10px;
        height:300px;
        overflow-y:scroll;
        border:1px solid #cacaca;
    }

    .pamm-agreement-content p {
        font-weight:600;
    }

    .pamm-agreement-list-parent , .pamm-agreement-list-child {
        padding:0 15px!important;
    }

    .pamm-agreement-list-parent li {
        padding:5px 0;
    }

    .pamm-agreement-list-parent li span {
        font-weight:600;
        color:#ff0000;
    }

    .pamm-agreement-list-child li {
        padding:0;
    }

    .pamm-agreement-checkbox {
        display:table;
        margin:0 auto;
    }

    .pamm-agreement-checkbox input[type=checkbox] {
        float:left;
        margin-right:5px;
    }

    .pamm-select-account {
        margin:20px 0;
        width:100%;
        display:table;
    }

    .pamm-select-account-child {
        width:100%;
        display:table;
    }

    .pamm-select-account-child img {
        margin:0 auto!important;
        display:table;
    }

    .pamm-select-account-child a {
        background:#2988ca;
        color:#fff;
        text-align:center;
        padding:10px 20px;
        font-size:15px;
        margin:0 auto;
        margin-top:-15px;
        display:table;
        text-decoration:none;
        transition: all ease 0.3s;
    }

    .pamm-select-account-child p {
        margin-top:10px;
        text-align:center;
    }

    .pamm-onclick-page {
        width:100%;
        margin:20px 0;
        display:none;
    }

    .pamm-tab-content {
        border:1px solid #ddd;
    }

    .pamm-btn {
        padding:0;
        background:none;
        color: #333;
        font-size: 15px;
        margin:0!important;
        line-height:12px!important;
    }

    .pamm-btn-secondary {
        padding-right:0!important;
    }

    .pamm-btn-group.open .dropdown-toggle , .pamm-btn:focus , .pamm-btn:hover {
        box-shadow:none;
    }

    .pamm-dropdown-menu {
        margin-top:5px!important;
        border-radius:0!important;
        padding:0!important;
    }

    .pamm-dropdown-menu ul {
        position:relative;
        padding:0!important;
    }

    .pamm-dropdown-menu ul li {
        list-style-type:none;
        padding:5px;
        cursor:pointer;
    }

    .pamm-dropdown-menu ul li:hover {
        background:#f0f0f0;
    }

    .navbar-brand-internal{
        margin-top: 4px!important;
    }

    /*----- PAMM ONCLICK PAGE -----*/
    .pamm-nav-tabs {
        background:#eee;
        border:1px solid #ddd;
    }

    .pamm-nav-tabs li a {
        color:#333;
        font-size:15px;
    }

    .pamm-nav-tabs .active a {
        border-radius:0;
        border:none!important;
        border-bottom:2px solid #fff!important;
        font-weight:600;
    }
    .pamm-tab-content {
        margin-top:-1px;
        padding:10px;
        /*display:table;*/
        width:100%;
    }

    /*----- PAMM PROFILE TAB -----*/

    .pamm-content-input {
        width:90%;
        margin:0 auto;
    }

    .pamm-content-input h1 {
        border-bottom:1px solid #2988CA;
        color:#333;
        text-align:left;
        font-size:18px;
        font-weight:600;
        padding:5px;
    }

    .pamm-content-input-box {
        margin:10px auto!important;
        display:table;
        float:none!important;
    }

    .pamm-content-input-box textarea {
        resize:vertical;
    }

    .pamm-content-input-box label {
        margin-bottom:0;
    }

    .pamm-content-input-box input[type=checkbox] {
        float:left;
        margin-right:5px;
    }

    .pamm-content-input-box button , .pamm-investment-parent button , .pamm-investment-secondary button {
        margin:10px auto;
        display:table;
        background: #2988CA;
        color: #fff;
        padding:8px 20px;
        border:none;
        transition: all ease 0.3s;
    }

    .pamm-content-input-box button:hover , .pamm-investment-parent button:hover , .pamm-investment-secondary button:hover {
        background:#319ae3;
    }

    .required-field {
        font-size:12px;
        font-weight:normal;
        color:#ff0000;
    }

    .hide-unhide-input-box {
        display:table;
        float:right;
    }

    .show-button , .hide-button {
        display:block;
        width:20px;
        height:20px;
        float:left;
        margin:0 1px;
        transition: all ease 0.3s;
    }

    .show-button {
        background:url(../assets/images/show-eye-button.png);
    }

    .show-button:hover {
        background:url(../assets/images/show-eye-button-hover.png);
    }

    .hide-button {
        background:url(../assets/images/hide-eye-button.png);
    }

    .hide-button:hover {
        background:url(../assets/images/hide-eye-button-hover.png);
    }

    .pamm-trader-list ul {
        padding:0;
    }

    .pamm-trader-list ul li {
        list-style-type:none;
        margin:5px 0;
    }

    .pamm-trader-list ul li label {
        font-weight:normal;
    }

    /*----- PAMM MY INVESTMENTS TAB -----*/
    .pamm-investment-container  {
        width:90%;
        margin:0 auto;
        display:table;
    }

    .pamm-investment-container h5 {
        font-size:15px;
        padding:5px 0;
        border-bottom:1px solid #2988CA;
    }

    .pamm-investment-content ul {
        padding:0;
    }

    .pamm-investment-content ul li {
        list-style-type:none;
    }

    .pamm-investment-content ul li i {
        font-style:normal;
        color:#2988CA;
    }

    .pamm-investment-parent {
        display:table;
        width:100%;
    }

    .pamm-investment-parent button , .pamm-investment-secondary button {
        display:block;
        clear:both;
    }

    .pamm-investment-secondary {
        width:100%;
        margin:0 auto;
        display:table;
    }

    .pamm-investment-table {
        width:100%;
    }

    .pamm-investment-table table thead {
        background:#eee;
    }

    .pamm-investment-table table thead th {
        text-align:center;
        color:#707071;
        font-weight:600;
        padding:7px 5px;
    }

    .pamm-investment-table table tr td {
        text-align:center;
        padding:5px;
        border-bottom:1px solid #ddd;
    }

    .pamm-trader-condition-child {
        margin:0 0 20px 0;
    }

    .pamm-trader-condition-child label {
        margin-bottom:0;
        display:block;
    }

    .pamm-trader-condition-child input[type=text] {
        width:80%!important;
        float:left;
        margin-right:5px;
    }

    .pamm-trader-condition-child span {
        display:inline-block;
        line-height:34px;
    }

    .max-investment-amount {
        line-height:32px!important;
        display:table;
        background: #eee;
        border: 1px solid #ddd;
        padding:0 10px;
    }

    /*----- PAMM MONITORING TAB -----*/

    .pamm-monitoring-landing h1 , .pamm-monitoring-live-feed h1 {
        padding:0;
        font-size:18px;
        margin:0!important;
        display:table;
        font-weight:600;
    }

    .pamm-monitoring-landing h1 {
        float:left;
        line-height:31px;
    }

    .pamm-monitoring-info {
        clear:both!important;
        padding:20px 0;
    }

    .pamm-monitoring-live-feed {
        display:none;
    }

    .pamm-monitoring-live-feed p {
        margin-top:20px;
    }

    .live-feed-child-content {
        display:table;
        width:100%;
        padding:10px;
        margin:10px auto;
    }

    .live-feed-child-content:nth-child(odd) {
        background:#fcfcfc;
        border:1px solid #dadada;
    }

    .live-feed-child-content:nth-child(even) {
        background:#f3f2f2;
        border:1px solid #dadada;
    }


    .live-feed-child-content h2 {
        font-size:14px;
        font-weight:600;
        margin:0 0 3px 0;
    }

    .live-feed-child-content img {
        float:left;
    }

    .live-feed-child-content span {
        color: #707071;
        float:left;
        margin-left:5px;
        margin-top:3px;
    }

    .live-feed-child-content ul {
        padding:0;
        margin-bottom:0;
        display:table;
        width:100%;
    }

    .live-feed-child-content ul li {
        list-style-type:none;
        float:left;
        border-right:1px solid #dadada;
    }

    .live-feed-child-content ul li a {
        padding:0 10px;
    }

    .live-feed-child-content ul li:first-child a {
        padding-left:0;
    }

    .live-feed-child-content ul li:last-child {
        border-right:0;
    }

    .monitoring-btn-default {
        padding:6px!important;
    }

    .secondary-monitoring-text-center {
        margin-top:3px;
    }

    .btn-demo1 {
        background: none;
        border: 1px solid #2988ca;
        color: #2988ca;
        padding: 7px;
        margin-top: 5px;
        transition: all ease 0.3s;
    }

    .btn-demo1:hover {
        background:#2988ca;
        color:#fff;
    }

    .trades-tab-holder {
        max-width:824px;
    }

    .conditions-input-holder {
        display:table;
        width:100%;
    }

    .conditions-slider {
        width:80%;
        float:left;
        margin:12px 0;
    }

    .conditions-slider span {
        outline:none!important;
    }

    .conditions-input {
        width:15%;
        border-radius:0;
        float:right;
    }

    .conditions-slider .ui-state-hover , .conditions-slider .ui-state-focus {
        background:#98d1f9!important;
        border:1px solid #52aae7!important;
    }

    .conditions-mid-content {
        text-align:center;
    }

    .conditions-mid-reward {
        margin-top: 13px;
        text-align:justify;
    }

    @media screen and (max-width: 1168px) {

        .monitoring-text-center {
            text-align:start!important;
        }

        .monitoring-btn-default {
            font-size:12px;
            padding:6px 4px!important;
        }

    }

    @media screen and (max-width: 1066px) {

        .monitoring-btn-default {
            margin-top:2px;
        }

    }

    @media screen and (max-width: 991px) {

        .pamm-side-nav li {
            width: calc(100% / 7)!important;
        }

    }

    @media screen and (max-width: 928px) {

        .pamm-side-nav li a {
            width:100%;
            display:table!important;
        }

        .pamm-side-nav li i , .pamm-side-nav li cite {
            float:left;
        }

        .pamm-side-nav li cite {
            font-size:11px!important;
        }

    }

    @media screen and (max-width: 767px) {

        .pamm-side-nav li {
            width:100%!important;
        }

        .pamm-side-nav li cite {
            font-size:14px!important;
            margin-left:5px;
        }

        .pamm-side-nav li i {
            margin-top:2px;
        }

        .pamm-investment-content {
            padding:0!important;
            float:none!important;
        }

        .pamm-investment-content ul {
            margin-bottom:0!important;
        }

        .pamm-investment-parent button {
            margin-top:10px!important;
        }

    }

    @media screen and (max-width: 670px) {

        .pamm-investment-table {
            max-width:500px;
            margin:0 auto!important;
        }

    }

    @media screen and (max-width: 570px) {

        .pamm-investment-table {
            max-width:400px;
            margin:0 auto!important;
        }

    }

    @media screen and (max-width: 558px) {

        .finance-payment-methods select {
            width:100%;
        }

        .finance-method-amount .input-group {
            width:100%;
        }

        .finance-method-amount label {
            line-height:16px;
        }

        .finance-method-table button {
            margin:0 auto;
            display:table;
            float:none;
        }

    }

    @media screen and (max-width: 550px) {

        .pamm-agreement-checkbox {
            width:80%;
        }

    }

    @media screen and (max-width: 475px) {

        .pamm-investment-table {
            max-width:300px;
            margin:0 auto!important;
        }

    }

    @media screen and (max-width: 465px) {

        .pamm-monitoring-landing h1 , .pamm-monitoring-landing button {
            float:none!important;
        }

        .pamm-monitoring-landing h1 {
            display:block;
            text-align:left;
        }

        .pamm-monitoring-landing button {
            display:block;
            margin:10px auto;
        }

        .pamm-monitoring-info {
            padding:10px 0;
        }

    }

    @media screen and (max-width: 430px) {

        .pamm-nav-tabs li {
            width:100%!important;
        }

        .pamm-nav-tabs li a {
            border:none!important;
            margin-right:0!important;
        }

        .pamm-content-input-box {
            padding:0!important;
        }

        .live-feed-child-content ul li {
            float:none;
            display:block;
            border-right:0;
        }

        .live-feed-child-content ul li a {
            padding:0;
        }

    }

    @media screen and (max-width: 370px) {

        .pamm-investment-table {
            max-width:200px;
            margin:0 auto!important;
        }

    }
    @media screen and (max-width: 315px) {

        .finance-deposit-container {
            margin:0 auto;
            position:relative;
            padding:10px 0!important;
        }

        .finance-deposit-container, .finance-payment-methods, .finance-method-content {
            display:block;
        }

        .finance-table-holder {
            border:1px solid #ddd;
            overflow-x:scroll;
        }

        .finance-table-holder table {
            margin-top:0;
            border:none;
        }

    }

    .slider {
        width: 100px;
    }

    .slider > .dragger {
        background: #2eb94b;
        background: -webkit-linear-gradient(top, #2eb94b, #29a643);
        background: -moz-linear-gradient(top, #2eb94b, #29a643);
        background: linear-gradient(top, #2eb94b, #29a643);

        -webkit-box-shadow: inset 0 2px 2px rgba(255,255,255,0.5), 0 2px 8px rgba(0,0,0,0.2);
        -moz-box-shadow: inset 0 2px 2px rgba(255,255,255,0.5), 0 2px 8px rgba(0,0,0,0.2);
        box-shadow: inset 0 2px 2px rgba(255,255,255,0.5), 0 2px 8px rgba(0,0,0,0.2);

        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;

        border: 1px solid #18872f;
        width: 16px;
        height: 16px;
    }

    .slider > .dragger:hover {
        background: -webkit-linear-gradient(top, #2eb94b, #29a643);
    }


    .slider > .track, .slider > .highlight-track {
        background: #ccc;
        background: -webkit-linear-gradient(top, #bbb, #ddd);
        background: -moz-linear-gradient(top, #bbb, #ddd);
        background: linear-gradient(top, #bbb, #ddd);

        -webkit-box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        -moz-box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);

        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;

        border: 1px solid #aaa;
        height: 4px;
    }

    .slider > .highlight-track {
        background-color: #8DCA09;
        background: -webkit-linear-gradient(top, #2eb94b, #29a643);
        background: -moz-linear-gradient(top, #2eb94b, #29a643);
        background: linear-gradient(top, #2eb94b, #29a643);

        border-color: #496805;
    }

    .slider-volume {
        width: 300px;
    }

    .slider-volume > .dragger {
        width: 16px;
        height: 16px;
        margin: 0 auto;
        border: 1px solid rgba(255,255,255,0.6);

        -moz-box-shadow: 0 0px 2px 1px rgba(0,0,0,0.5), 0 2px 5px 2px rgba(0,0,0,0.2);
        -webkit-box-shadow: 0 0px 2px 1px rgba(0,0,0,0.5), 0 2px 5px 2px rgba(0,0,0,0.2);
        box-shadow: 0 0px 2px 1px rgba(0,0,0,0.5), 0 2px 5px 2px rgba(0,0,0,0.2);

        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        border-radius: 10px;

        background: #c5c5c5;
        background: -moz-linear-gradient(90deg, rgba(180,180,180,1) 20%, rgba(230,230,230,1) 50%, rgba(180,180,180,1) 80%);
        background:	-webkit-radial-gradient(  50%   0%,  12% 50%, hsla(0,0%,100%,1) 0%, hsla(0,0%,100%,0) 100%),
        -webkit-radial-gradient(  50% 100%, 12% 50%, hsla(0,0%,100%,.6) 0%, hsla(0,0%,100%,0) 100%),
        -webkit-radial-gradient(	50% 50%, 200% 50%, hsla(0,0%,90%,1) 5%, hsla(0,0%,85%,1) 30%, hsla(0,0%,60%,1) 100%);
    }

    .slider-volume > .track, .slider-volume > .highlight-track {
        height: 11px;

        background: #787878;
        background: -moz-linear-gradient(top, #787878, #a2a2a2);
        background: -webkit-linear-gradient(top, #787878, #a2a2a2);
        background: linear-gradient(top, #787878, #a2a2a2);

        -moz-box-shadow: inset 0 2px 5px 1px rgba(0,0,0,0.15), 0 1px 0px 0px rgba(230,230,230,0.9), inset 0 0 1px 1px rgba(0,0,0,0.2);
        -webkit-box-shadow: inset 0 2px 5px 1px rgba(0,0,0,0.15), 0 1px 0px 0px rgba(230,230,230,0.9), inset 0 0 1px 1px rgba(0,0,0,0.2);
        box-shadow: inset 0 2px 5px 1px rgba(0,0,0,0.15), 0 1px 0px 0px rgba(230,230,230,0.9), inset 0 0 1px 1px rgba(0,0,0,0.2);

        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
    }

    .slider-volume > .highlight-track {
        background-color: #c5c5c5;
        background: -moz-linear-gradient(top, #c5c5c5, #a2a2a2);
        background: -webkit-linear-gradient(top, #c5c5c5, #a2a2a2);
        background: linear-gradient(top, #c5c5c5, #a2a2a2);
    }

</style>
<script type="text/javascript">
    var destination ='#pamm-div-investor';
    $('.destination-class').hide();
    $(destination).show();
</script>
<script type="application/javascript">
    var deactivated='<?=$deactivated?>';
    console.log('deactivated account is'+deactivated);
    if (deactivated==1){
        $('.deact').css('display','none');
    }

    $('#investor_registration').validate({ // initialize the plugin
        rules: {
            investorname:  "required",
            investoricq:  {
                number: true,
//                maxlength: 9,
            },
        },
        messages: {
            investorname:  "Please enter your Full name",

        },
        submitHandler: function (form) {
            form.submit();

        }
    });

    $(document).on("click", "#lbl_ciw", function () {
        $('input[name=investorciw]').trigger('click');
    });
    $(document).on("click", "#lbl_dps", function () {
        $('input[name=investor_checkbox_deactivate]').trigger('click');
    });
    $(document).on("click", "#lbl_investorlangauge", function () {
        $('#investorlangauge').select2('focus');
        $('#investorlangauge').select2('open');
    });
    $( window ).load(function() {
        $('#pamm-div-investor').removeClass('page');
    });
</script>