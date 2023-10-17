<?php include_once('partnership/partnership_nav.php') ?>


<div class="section rebate-system-container">
    <h1><?= lang('reb_txt_1'); ?></h1>
    <p><?= lang('reb_txt_2'); ?></p>
    <p><?= lang('reb_txt_3'); ?></p>
    <p><?= lang('reb_txt_4'); ?></p>
    </p>
    <div class="acct-tab-holder">
        <ul role="tablist" class="main-tab">
            <li class="part-li <?= $nav=='default'?'active':""?>" role="presentation"><a href="<?= FXPP::loc_url('rebate-system');?>"  <?= $nav=='default'?'class="acct-active"':""?> ><i class="fa fa-check-circle"></i><?= lang('reb_txt_5'); ?> </a></li>
            <li class="part-li <?= $nav=='personal_rebate'?'active':""?>" role="presentation"><a href="<?= FXPP::loc_url('rebate-system/personal-rebate');?>"  <?= $nav=='personal_rebate'?'class="acct-active"':""?>><i class="fa fa-user"></i><?= lang('reb_txt_6'); ?> </a></li>

            <li class="part-li <?= $nav=='statistics'?'active':""?>" role="presentation"><a href="<?= FXPP::loc_url('rebate-system/statistics');?>" <?= $nav=='statistics'?'class="acct-active"':""?>><i class="fa fa-bar-chart"></i><?= lang('reb_txt_7'); ?> </a></li>
           
            <div class="clearfix"></div>
        </ul>
    </div>
    <div class="tab-content acct-cont">
        <?php $this->load->view( $page)?>

    </div>
</div>

<script src="<?= $this->template->Js()?>bootstrap-datepicker.js"></script>
<script src="<?= $this->template->Js()?>bootstrap-datepicker.en-GB.js"></script>
<script>

    $(document).ready(function() {



    });
    $('#sandbox-container input').datepicker({
    });

    $(document).ready(function () {
        var mySelect = $('#first-disabled2');

        // $('#special').on('click', function () {
        //     mySelect.find('option:selected').prop('disabled', true);
        //     mySelect.selectpicker('refresh');
        // });

        // $('#special2').on('click', function () {
        //     mySelect.find('option:disabled').prop('disabled', false);
        //     mySelect.selectpicker('refresh');
        // });

        // $('#basic2').selectpicker({
        //     liveSearch: true,
        //     maxOptions: 1
        // });
    });
</script>

<style>
    /*----- ADDITIONAL STYLES -----*/
    .partners-input {
        margin:15px 0!important;
    }

    .rebate-system-container p {
        margin-top:10px;
    }

    .select-action {
        display:table;
        margin:0 auto;
    }

    .select-action select {
        padding:7px 5px;
        outline:none;
        border:1px solid #dadada;
    }

    .rebate-system-table table {
        border-collapse:separate!important;
    }

    .rebate-system-table table thead th {
        border-bottom:0;
    }

    .rebate-system-table table thead th {
        text-align:center;
    }

    .rebate-system-table table tr td {
        vertical-align:middle;
        border:1px solid #dadada;
    }

    .btn-rebate-update , .btn-rebate-add {
        display:block;
        outline:none;
        padding: 8.5px;
    }

    .btn-rebate-update {
        margin:0 auto!important;
    }

    .btn-rebate-add {
        float:right!important;
        margin-top:0!important;
        max-width:30%!important;
    }

    .btn-rebate-add-min {
        display:none;
        margin-top:0!important;
        max-width:30%!important;
        float:right!important;
        padding:9px 0!important;
    }

    .btn-rebate-add-min span {
        width:16px;
        height:16px;
        display:block;
        margin:0 auto;
        background:url(../images/add-icon.png);
    }

    .rebate-system-textbox , .rebate-system-searchbar {
        display:inline-block!important;
    }

    .rebate-system-textbox {
        width:68%;
    }

    .rebate-system-searchbar {
        width:30%!important;
    }

    .dropdown-account-numbers {
        padding:7px;
        width:auto!important;
        margin-right:10px;
        border:1px solid #dadada;
    }

    .rebate-searchbutton button , .rebate-showbutton button {
        padding:5.5px 25px!important;
    }

    .rebate-label , .date-statistics label {
        line-height:34px;
        margin-right:5px;
    }

    .dropdown-account-numbers , .rebate-label , .rebate-system-checkbox input[type=checkbox] , .date-statistics , .date-statistics label ,
    .rebate-datepicker input[type=text] {
        float:left;
    }

    .rebate-system-checkbox input[type=checkbox] {
        margin:12px 0;
    }

    .rebate-system-checkbox p {
        display:inline-block;
        text-indent:5px;
        margin:8px 0;
    }

    .rebate-datepicker input[type=text] {
        width:76%;
        border-radius:0!important;
    }

    .date-statistics {
        display:table;
    }

    .rebate-child-container {
        margin-top:20px!important;
    }

    @media screen and (max-width: 991px) {
        .calc-margin
        {
            border-top: 1px solid #ececec;
        }

        .left-button-group , .right-form-group {
            float:none!important;
            margin:20px auto!important;
            display:table!important;
        }

        .btn-rebate-add-min {
            display:block;
        }

        /*.btn-rebate-add {*/
            /*display:none;*/
        /*}*/

    }

    @media screen and (max-width: 767px) {

        .period-txt-holder {
            text-align:left!important;
        }

        .rebate-system-table {
            border:none!important;
        }

    }

    @media screen and (max-width: 558px) {

        .rebate-system-checkbox , .rebate-accountnumbers {
            display:table!important;
        }

    }

    @media screen and (max-width: 370px) {

        .period-option {
            width:100%!important;
        }

    }
</style>