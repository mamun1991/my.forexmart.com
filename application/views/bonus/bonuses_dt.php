
<?php include_once('bonus_nav.php') ?>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="tab1">
        <div class="row">
            <div class="col-md-12">
                <p class="bonus-text">
                    <?= lang('bon_desc');?>
                </p>
                <div class="cur-trades-tab arabic-cur-trades-tab">
                    <ul>
                        <li id="tpdb" class="active"><a id="atab-sub1" aria-expanded="false" href="#tab-sub1" aria-controls="cur" role="tab" data-toggle="tab" class="cur-active" >
                                <?= lang('bon_00');?>
                            </a>
                        </li>
                        <?php // 50% bonus ?>
                        <li id="fpdb" class="a">
                            <a id="atab-sub2" aria-expanded="false" href="#tab-sub2" aria-controls="pend" role="tab" data-toggle="tab" >
                                <?= lang('bon_14');?>
                            </a>
                        </li>
                        <?php if($IsAcquiredFromOtherAccount==false){?>
                            <?php if($nodeposit!=1){?>
                                <?php if($has_rqstd_ndb==false){?>
                                    <li id="ndb" class="">
                                        <a id="atab-sub3" aria-expanded="false" href="#tab-sub3" aria-controls="pend" role="tab" data-toggle="tab" >
                                            <?= lang('bon_01');?>
                                        </a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div><div class="clearfix"></div>
                <div class="tab-content cur-tab-cont">
                    <div role="tabpanel" class="tab-pane table-responsive active" id="tab-sub1">
                        <div class="col-sm-12 arabic-bonus-tab-pane">
                            <?php if($nodeposit!=1){?>
                                <h3 class="bonus-tab-sub">
                                    <?= lang('bon_02');?>
                                </h3>
                                <h3 class="bonus-tab-sub">
                                    <?= lang('bon_03');?>
                                </h3>
                                <p class="bonus-text-tab">
                                    <?= lang('bon_04');?>
                                </p>
                                <?= form_open('bonus/thirtypercentbonus',array('id' => 'form_TPB','class'=> ''),''); ?>
                                <input id="agree-checkbox" name="tpdba" type="checkbox">
                                <?= lang('bon_05');?>
                                <a href="<?= $this->template->pdfviewer()?>?file=<?= $this->template->pdf()?>Bonus thirty percent Agreement.pdf#zoom=page-width" class="agreement"  target="_blank" >
                                    <?= lang('bon_06');?>
                                </a>
                                <div class="btn-get-bonus-holder arabic-btn-get-bonus-holder">
                                    <button id="btn1" name="btn1" class="btn-get-bonus dsbld" disabled>
                                        <?= lang('bon_07');?>
                                    </button>
                                </div>
                                <?= form_close()?>
                            <?php }else if($IsAcquiredFromOtherAccount==true){?>
                                <p class="bonus-text-tab">
                                    You can no longer request for 30% bonus because you have already been accepted for no deposit bonus in your other account.
                                </p>
                            <?php }else{?>
                                <p class="bonus-text-tab">
                                    You can no longer request for 30% bonus because you have already been accepted for no deposit bonus in this account.
                                </p>
                            <?php }?>
                        </div>
                    </div>
                    <?php
                    // 50% bonus
                    ?>
                    <div role="tabpanel" class="tab-pane table-responsive" id="tab-sub2">
                        <div class="col-sm-12 arabic-bonus-tab-pane">
                            <h3 class="bonus-tab-sub">
                                <?= lang('bon_15');?>
                            </h3>
                            <h3 class="bonus-tab-sub">
                                <?= lang('bon_03');?>
                            </h3>
                            <p class="bonus-text-tab">
                                <?= lang('bon_04');?>
                            </p>
                            <?= form_open('bonus/fiftypercentbonus',array('id' => 'form_FPB','class'=> ''),''); ?>
                            <input id="agree-checkbox" name="fpdba" type="checkbox">
                            <?= lang('bon_05');?>
                            <a href="#" class="agreement"  target="_blank" >
                                <?= lang('bon_16');?>
                            </a>
                            <div class="btn-get-bonus-holder arabic-btn-get-bonus-holder">
                                <button id="btn3" name="btn3" class="btn-get-bonus dsbld" disabled>
                                    <?= lang('bon_07');?>
                                </button>
                            </div>
                            <?= form_close()?>
                        </div>
                    </div>
                    <?php if($IsAcquiredFromOtherAccount==false){?>
                        <?php if($nodeposit!=1){?>
                        <?php if($has_rqstd_ndb==false){?>
                            <div role="tabpanel" class="tab-pane table-responsive " id="tab-sub3" >
                                <div class="col-sm-12 expireNoDeposit">
                                    <h3 class="bonus-tab-sub">
                                        <?= lang('bon_08');?>
                                    </h3>
                                    <p class="bonus-text-tab">
                                        <?= lang('bon_09');?>
                                    </p>
                                    <p class="bonus-text-tab">
                                        <?= lang('bon_10');?>
                                        <b><?=$bonus;?> <?=$default_currency;?></b>
                                    </p>


                                    <input id="agree-checkbox" name="ndba" type="checkbox">
                                    <?= lang('bon_11');?>
                                    <a href="<?= $this->template->pdfviewer()?>?file=<?= $this->template->pdf()?>No Deposit Bonus.pdf#zoom=page-width" class="agreement" target="_blank" >
                                        <?= lang('bon_12');?>
                                    </a>
                                    <span class="ndba">
                                    </span>
                                    <?php if (isset($expireNoDeposit)){?>
                                        <?php if ($expireNoDeposit==true){?>
                                            <div class="btn-get-bonus-holder">
                                                <button id="btn22" name="btn2" class="btn-get-bonus dsbld" disabled>
                                                    <?= lang('bon_13');?>
                                                </button>
                                            </div>
                                        <?php }else{  ?>
                                            <div class="btn-get-bonus-holder">
                                                <button id="btn2" name="btn2" class="btn-get-bonus dsbld" disabled>
                                                    <?= lang('bon_13');?>
                                                </button>
                                            </div>

                                        <?php } ?>
                                    <?php }  ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab2">
        <div class="row">
            <div class="col-md-12">
                <p class="bonus-text">
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                </p>
                <h3 class="acct-sum-title arabic-acct-sum-title">
                    Account Summary
                </h3>
                <div class="row acct-sum-holder">
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-10 col-md-10 col-xs-12' : '' ?> col-sm-10 arabic-bonus-statistics">
                        <p>Balance</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-2 col-md-2 col-xs-12' : '' ?> col-sm-2 arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-10 col-md-10 col-xs-12' : '' ?> col-sm-10 arabic-bonus-statistics">
                        <p>Equity</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-2 col-md-2 col-xs-12' : '' ?> col-sm-2 arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-10 col-md-10 col-xs-12' : '' ?> col-sm-10 arabic-bonus-statistics">
                        <p>Margin Free</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-2 col-md-2 col-xs-12' : '' ?> col-sm-2 arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-10 col-md-10 col-xs-12' : '' ?> col-sm-10 arabic-bonus-statistics">
                        <p>Available for withdrawal (without bonus)</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-2 col-md-2 col-xs-12' : '' ?> col-sm-2 arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-10 col-md-10 col-xs-12' : '' ?> col-sm-10 arabic-bonus-statistics">
                        <p>Available for withdrawal (with bonus safe)</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-2 col-md-2 col-xs-12' : '' ?> col-sm-2 arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-10 col-md-10 col-xs-12' : '' ?> col-sm-10 arabic-bonus-statistics">
                        <p class="calc-bonus">Calculate bonus amount to be cancelled</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-2 col-md-2 col-xs-12' : '' ?> col-sm-2 arabic-bonus-statistics arabic-bonus-bottom">
                        <p></p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-10 col-md-10 col-xs-12' : '' ?> col-sm-10 arabic-bonus-statistics">
                        <p>Withdrawal amount:</p>
                    </div>
                    <div class="<?= FXPP::html_url() == 'sa' ? 'col-lg-2 col-md-2 col-xs-12' : '' ?> col-sm-2 arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00 USD</p>
                    </div>
                </div>
                <div class="btn-text-holder row arabic-btn-text-holder">
                    <div class="col-sm-5 <?= FXPP::html_url() == 'sa' ? 'col-lg-5 col-md-5 col-xs-12' : '' ?> arabic-bonus-statistics">
                        <input class="form-control round-0" placeholder="Amount (USD)" type="text">
                    </div>
                    <div class="col-sm-3 <?= FXPP::html_url() == 'sa' ? 'col-lg-3 col-md-3 col-xs-12' : '' ?> arabic-bonus-statistics">
                        <button class="btn-acct-calc">Calculate</button>
                    </div>
                </div>
                <h3 class="acct-sum-title arabic-acct-sum-title">Your Bonus Statistics</h3>
                <p class="bonus-text bonus-text-sub">
                    There's no bonus on the account
                </p>
                <h3 class="acct-sum-title arabic-acct-sum-title">Your Bonus Statistics</h3>
                <div class="row acct-sum-holder">
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-bonus-statistics">
                        <p>Necessary number of lots for bonus withdrawal</p>
                    </div>
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00</p>
                    </div>
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-bonus-statistics">
                        <p>Number of lots traded</p>
                    </div>
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00</p>
                    </div>
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-bonus-statistics">
                        <p>Number of lots to trade</p>
                    </div>
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-bonus-statistics arabic-bonus-bottom">
                        <p>0.00</p>
                    </div>
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-bonus-statistics">
                        <p>Current bonus status</p>
                    </div>
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-bonus-statistics">
                        <p class="txt-strong">No bonuses available for withdrawal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="successful-registration-bonus" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content bonus-modal-container-two ex-modal-content round-0">
            <div class="modal-header ex-modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title-sub ex-modal-title">No Deposit Bonus</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!--<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 bonus-modal-img">
                        <img src="images/bonus-modal-icon-2.png" class="img-responsive"/>
                    </div>-->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-deposit-bonus-col-centered">
                        <p>
                            Please enter your login details on <strong>Facebook</strong> or <strong>VK</strong> to claim No Deposit Bonus
                            </br>Expect a contact from one of our ForexMart regional managers to complete the verification process.
                        </p>
                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 no-deposit-bonus-input">
                            <label>Phone or Email</label>
                            <input id="phone" type="text" class="form-control round-0" placeholder="Phone or Email">
                        </div>

                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 no-deposit-bonus-input">
                            <button type="button" id="reg-btn">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="successful-registration-bonus-no-deposite-bonus" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content bonus-modal-container-two ex-modal-content round-0">
            <div class="modal-header ex-modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title-sub ex-modal-title">No Deposit Bonus</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!--<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 bonus-modal-img">
                        <img src="images/bonus-modal-icon-2.png" class="img-responsive"/>
                    </div>-->





                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-deposit-bonus-col-centered">
                        <p>
                            Please enter your login details on <strong>Facebook</strong> or <strong>VK</strong> to claim No Deposit Bonus
                            </br>Expect a contact from one of our ForexMart regional managers to complete the verification process.
                        </p>
                        <?php if(IPLoc::Office()){ ?>
                            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 no-deposit-bonus-input">
                                <div class="form-inline">
                                    <label>Social Media Type</label><br>
                                    <label class="sr"><input type="radio" name="socialradio" value="Facebook">Facebook</label>
                                    <label class="sr"><input type="radio" name="socialradio" value="Vk">Vk</label>
                                    <!-- <label class="sr"><input type="radio" name="socialradio" value="Phone Number">Phone Number</label> -->
                                </div>


                            </div>
                        <?php } ?>

                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 no-deposit-bonus-input">
                            <label>Phone or Email</label>
                            <input id="phone2" type="text" class="form-control round-0" placeholder="Phone or Email">
                        </div>

                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 no-deposit-bonus-input">
                            <button type="button" id="reg-btn2">Confirm</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?=$check?>
<?=$modal_bonus_thirty_percent?>
<?php if(IPLoc::Office()){ ?>
    <?=$modal_bonus_fifty_percent?>
<?php } ?>
<?=$modal_bonus_alert?>
<?=$modal_bonus_no_deposit_alert?>
<?=$modal_bonus_thirty_percent_alert?>
<?php if(IPLoc::Office()){ ?>
    <?=$modal_bonus_fifty_percent_alert?>
<?php } ?>

<style type="text/css">

    .main-tab li a {
        background: #85C7F3 none repeat scroll 0% 0%;
        color: #333;
        display: block;
        padding: 10px;
        transition: all 0.3s ease 0s;
    }
    .btn-get-bonus-holder {
        text-align: left!important;
    }
    /* arabic start */
    .btn-get-bonus-holder:lang(sa) {
        text-align: right!important;
    }
    #form_TPB:lang(sa) {
        text-align: right!important;
    }
    .error{
        color:red;
        font-weight: normal!important;
    }

    .agreement:hover{
        color: #2988CA;
        text-decoration: none;
    }
    .agreement:link{
        color: #2988CA;
        text-decoration: none;
    }
    .agreement:visited{
        color: #2988CA;
        text-decoration: none;
    }
    .agreement:active{
        color: #2988CA;
        text-decoration: none;
    }
    .btn-get-bonus-holder {
        margin-top: 0px!important;
    }

    .dsbld{
        background-color: gray!important;
    }
    .dsbld:hover{
        background-color: gray!important;
        text-decoration: none;
    }
    .dsbld:link{
        background-color: gray!important;
        text-decoration: none;
    }
    .dsbld:visited{
        background-color: gray!important;
        text-decoration: none;
    }
    .dsbld:active{
        background-color: gray!important;
        text-decoration: none;
    }
    .btn-explore {
        padding: 15px 20px;
        font-size: 17px;
        font-family: Open Sans;
        font-weight: 600;
        margin-top: 100px;
        border: 1px solid #1B8E33;
        background: #29A643 none repeat scroll 0% 0%;
        color: #FFF;
        transition: all 0.3s ease 0s;
    }
    .sr{
        margin-right: 7px;
    }
</style>
<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js" ></script>
<link rel="stylesheet" src="https://cdn.datatables.net/1.10.9/css/dataTables.bootstrap.min.css"/>
<link type="text/css"  href="<?= $this->template->Css()?>ndb-registration-style.css" rel="stylesheet">
<script type='text/javascript'>
    console.log("<?=$test?>");

    $(document).on("click","#fpdb,#tpdb",function(){
        $('a#atab-sub3').removeClass('cur-active');
    })

    $(document).on("click","#btn2",function(){
        $("#successful-registration-bonus-no-deposite-bonus").modal('show');
    })

    $(document).on("click","#ndb",function(){
        $('a#atab-sub3').addClass('cur-active');
        $('a#atab-sub1').removeClass('cur-active');
        $('a#atab-sub2').removeClass('cur-active');
    })

    $(document).on("click","#reg-btn",function(){
        $('#loader-holder').show();
        var id = $("#phone").val();
        var site_url="<?=FXPP::ajax_url('bonus/updatedFB')?>";

        $.post(site_url,{id:id},function(){
            $("#successful-registration-bonus").modal('hide');
            $('#loader-holder').hide();
        })
    })

    $(document).on("click","#reg-btn2",function(){
        $('#loader-holder').show();

        var id = $("#phone2").val();

//            var socialradio = document.getElementById('socialradio');

        <?php if(IPLoc::Office()){ ?>
        var social_media_type = $("input[name='socialradio']:checked").val();
        console.log(social_media_type);
        var site_url="<?=FXPP::ajax_url('bonus/updatedFBtest')?>";
        $.post(site_url,{id:id,social_media_type:social_media_type},function(){
            $("#successful-registration-bonus-no-deposite-bonus").modal('hide');
            nodepositbonus();
        })
        <?php }else{?>
        var site_url="<?=FXPP::ajax_url('bonus/updatedFB')?>";
        $.post(site_url,{id:id},function(){
            $("#successful-registration-bonus-no-deposite-bonus").modal('hide');
            nodepositbonus();
        })
        <?php } ?>




    })

    function nodepositbonus() {
//         var id = "test";
//         var site_url="<?//=FXPP::ajax_url('bonus/nodepositbonus')?>//";
//         $.post(site_url,{id:id},function(){
//             $('#loader-holder').hide();
//         })

        var prvt = [];
        prvt["data"] = {
        };
        var site_url="<?=FXPP::ajax_url('')?>";
        pblc['request'] = $.ajax({
            dataType: 'json',
            url:site_url+"bonus/nodepositbonus",
            method: 'POST',
            data: prvt["data"]
        });
        pblc['request'].done(function( data ) {
            if (data.request==true){
                $('li#ndb').css('display','none');
                $('div#tab-sub3').css('display','none');
                $('a#atab-sub1').removeClass('cur-active');
                $('a#atab-sub1').addClass('cur-active');
                $('a#atab-sub2').removeClass('cur-active');
                $('a#atab-sub3').removeClass('cur-active');
                $('div#tab-sub1').addClass('active');
            }
            $('#loader-holder').hide();
        });
    }

    function UpdateRequest(){
        setTimeout(
            function(){
                $('#ndbsuccess').hide();
            }, 10000);
    }
    var pblc = [];
    var site_url="<?=FXPP::ajax_url('')?>";
    var tblBonus = $('#tblBonusThirtyPercentDeposit').DataTable(
        {"order": [[ 0, "desc" ]]}
    );
    pblc['request'] = null;
    pblc['form_NDB'] = null;
    pblc['form_TPB'] = null;

    $().ready(function() {
        
        $("input[name='tpdba']").change(function() {
            if(this.checked) {
                // $("#successful-registration-bonus").modal('show');
                $("#btn1").prop("disabled", false);
                $("#btn1").removeClass("dsbld");
            }else{
                $("#btn1").prop("disabled", true);
                $("#btn1").addClass("dsbld");
            }
        });

        $("input[name='fpdba']").change(function() {
            if(this.checked) {
                // $("#successful-registration-bonus").modal('show');
                $("#btn3").prop("disabled", false);
                $("#btn3").removeClass("dsbld");
            }else{
                $("#btn3").prop("disabled", true);
                $("#btn3").addClass("dsbld");
            }
        });
        $("input[name='ndba']").change(function() {
            if(this.checked) {
                $("#btn2").prop("disabled", false);
                $("#btn2").removeClass("dsbld");
            }else{
                $("#btn2").prop("disabled", true);
                $("#btn2").addClass("dsbld");
            }
        });
        pblc['form_NDB'] = $('#form_NDB').validate({
            errorPlacement: function(error, element) {
                error.insertAfter(".ndba");
            },
            rules:{
                ndba: { required: true }
            },
            messages: {
            }, submitHandler: function(form) {

                var prvt = [];
                prvt["data"] = {
                };
                $('#loader-holder').show();
                pblc['request'] = $.ajax({
                    dataType: 'json',
                    url:form.action,
                    method: 'POST',
                    data: prvt["data"]
                });

                pblc['request'].done(function( data ) {
                    if (data.IsAcquiredFromOtherAccount) {

                        $('#OneAccountOnly').modal('show');

                    } else {

                        if (data.Implemented){
                            $('#NDBdone').modal('show');

                        }else {


                            if (data.IsStandardAccount == false) {

                                $('#NDBstandardaccountOnly').modal('show');

                            } else {

                                if (data.IsVerified && data.IsStandardAccount == true) {
                                    $('#NDBsuccess').modal('show');
                                    $('li#ndb').removeClass('active');
                                    $('a#atab-sub2').removeClass('cur-active');
                                    $('li#tpdb').addClass('active');
                                    $('a#atab-sub1').addClass('cur-active');
                                    $('div#tab-sub1').addClass('active');
                                    $('.expireNoDeposit').css('display', 'none');
                                } else {
                                    $('#NDBfailed').modal('show')
                                }

                            }
                        }

                    }
                    $('#loader-holder').hide();
                });

                pblc['request'].fail(function( jqXHR, textStatus ) {
                    $('#loader-holder').hide();
                });

                pblc['request'].always(function( jqXHR, textStatus ) {
                    $('#loader-holder').hide();
                    UpdateRequest();
                });
            }
        });

        pblc['form_TPB'] = $('#form_TPB').validate({
            errorPlacement: function(error, element) {
                error.insertAfter(".tpdba");
            },
            rules:{
                tpdba: {required: true}
            },
            messages: {
            }, submitHandler: function(form) {

                var prvt = [];
                prvt["data"] = {
                };
                pblc['request'] = $.ajax({
                    dataType: 'json',
                    url:form.action,
                    method: 'POST',
                    data: prvt["data"],
                    beforeSend: function(){
                        $('#loader-holder').show();
                    }
                });

                pblc['request'].done(function( data ) {
                    $('span.account-number').html(data.account_number);
                    if(data.has_deposit){
                        tblBonus.destroy();
                        $('#tblBonusThirtyPercentDepositRows').html(data.bonus_data);
                        tblBonus = $('#tblBonusThirtyPercentDeposit').DataTable({
                            "order": [[ 0, "desc" ]],
//                            "bSort": false,
//                            "ordering": false,
                            "info":     false,
                            dom: 'rtp<"clear">'
                        });
                        $('#loader-holder').hide();
                        $('#bonusThirtyPercent').modal('show');
                    }else{
                        $('#loader-holder').hide();
                        $('#modalBonusNoDepositAlert').modal('show');
                    }
                });

                pblc['request'].fail(function( jqXHR, textStatus ) {
                    $('#loader-holder').hide();
                });
            }
        });



        $('#btnGetBonus').on('click', function(){
            pblc['request'] = $.ajax({
                dataType: 'json',
                url: site_url+"bonus/getBonusThirtyPercent",
                method: 'POST',
                beforeSend: function(){
                    $('#loader-holder').show();
                }
            });

            pblc['request'].done(function( data ) {
                if(data.success){
                    $('#bonusThirtyPercent').modal('hide');
                    $('.bonus-alert-title').html('ForexMart 30% Bonus');
                    $('.bonus-alert-message').html(data.message);
                    $('#modalBonusAlert').modal('show');
                }else{
                    $('#bonusThirtyPercent').modal('hide');
                    if(data.has_no_deposit_bonus){
                        $('#modalBonusThirtyPercentAlert').modal('show');
                    }else{
                        if(data.has_deposit){
                            $('.bonus-alert-title').html('ForexMart 30% Bonus');
                            $('.bonus-alert-message').html(data.message);
                            $('#modalBonusAlert').modal('show');
                        }else{
                            $('#modalBonusNoDepositAlert').modal('show');
                        }
                    }
                }
                $('#loader-holder').hide();
            });

            pblc['request'].fail(function( jqXHR, textStatus ) {
                $('#loader-holder').hide();
            });
        });


        <?php
        // 50% bonus
        ?>


        pblc['form_FPB'] = $('#form_FPB').validate({
            errorPlacement: function(error, element) {
                error.insertAfter(".fpdba");
            },
            rules:{
                fpdba: {required: true}
            },
            messages: {
            }, submitHandler: function(form) {

                var prvt = [];
                prvt["data"] = {
                };
                pblc['request'] = $.ajax({
                    dataType: 'json',
                    url:form.action,
                    method: 'POST',
                    data: prvt["data"],
                    beforeSend: function(){
                        $('#loader-holder').show();
                    }
                });

                pblc['request'].done(function( data ) {
                    $('span.account-number').html(data.account_number);
                    if(data.has_deposit){
                        tblBonus.destroy();
                        $('#tblBonusFiftyPercentDepositRows').html(data.bonus_data);
                        tblBonus = $('#tblBonusFiftyPercentDeposit').DataTable({
                            "order": [[ 0, "desc" ]],
//                            "bSort": false,
//                            "ordering": false,
                            "info":     false,
                            dom: 'rtp<"clear">'
                        });
                        $('#loader-holder').hide();
                        $('#bonusFiftyPercent').modal('show');
                    }else{
                        $('#loader-holder').hide();
                        $('#modalBonusNoDepositAlert').modal('show');
                    }
                });

                pblc['request'].fail(function( jqXHR, textStatus ) {
                    $('#loader-holder').hide();
                });
            }
        });



        $('#btnGetFBonus').on('click', function(){
            pblc['request'] = $.ajax({
                dataType: 'json',
                url: site_url+"bonus/getBonusFiftyPercent",
                method: 'POST',
                beforeSend: function(){
                    $('#loader-holder').show();
                }
            });

            pblc['request'].done(function( data ) {
                if(data.success){
                    $('#bonusFiftyPercent').modal('hide');
                    $('.bonus-alert-title').html('ForexMart 50% Bonus');
                    $('.bonus-alert-message').html(data.message);
                    $('#modalBonusAlert').modal('show');
                }else{
                    $('#bonusFiftyPercent').modal('hide');
                    if(data.has_no_deposit_bonus){
                        $('#modalBonusFiftyPercentAlert').modal('show');
                    }else{
                        if(data.has_deposit){
                            $('.bonus-alert-title').html('ForexMart 50% Bonus');
                            $('.bonus-alert-message').html(data.message);
                            $('#modalBonusAlert').modal('show');
                        }else{
                            $('#modalBonusNoDepositAlert').modal('show');
                        }
                    }
                }
                $('#loader-holder').hide();
            });

            pblc['request'].fail(function( jqXHR, textStatus ) {
                $('#loader-holder').hide();
            });
        });
    });
</script>
<?= $this->load->ext_view('modal', 'nodepositbonus', $bonus, TRUE); ?>
<?php /** Preloader Modal Start */ ?>
<div id="loader-holder" class="loader-holder">
    <div class="loader">
        <div class="loader-inner ball-pulse">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>
<?php /** Preloader Modal End */ ?>
