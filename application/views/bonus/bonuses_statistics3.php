<?php include_once('bonus_nav.php') ?>
<?php $this->lang->load('bonus_statics_lang'); ?>

<style>
    .border_line{
        border: 0.5px solid;
        padding: 10px;
    }
    .left{
        float: left;
    }
    .right{
        float: right;
    }
    @media screen and (max-width: 520px) {
        .border_line{
            max-height: 55px;
        }
    }
    @media screen and (max-width: 480px) {
        .acct-sum2{
           font-size: 12px;
        }
    }
	
</style>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="bonuses_statistic">
        <div class="row">
            <div class="col-md-12">
                <p class="bonus-text">
                    <?=lang('bo_st_00');?>  <?php echo $account_number?>. <?=lang('bo_st_01');?>
                </p>
                <p class="bonus-text">
                    <?=lang('bo_st_02');?>
                </p>
                <p class="bonus-text">
                    <?=lang('bo_st_03');?>
                </p>
                <h3 class="acct-sum-title"><?=lang('bo_st_1');?></h3>
                <div class="row acct-sum-holder acct-sum2">
                    <div class="col-sm-12 col-xs-12">
                        <div class="row border_line">
                            <div class="col-sm-10 col-xs-10 left"><p><?=lang('bo_st_22');?></p></div>
                            <div class="col-sm-2 col-xs-2 right"><p><?php echo round($accountSummaryDetails['Acct_Balance'],2).' '.$currency;?></p></div>
                        </div>
<!--                        <div class="col-sm-12">-->
                            <!-- <p class="balance"><?//=lang('bo_st_2');?></p> -->
                            <!-- <p class="val_balance"><?php //echo round($accountSummaryDetails['Balance'],2).' '.$currency;?></p> -->
<!--                        </div>-->
                        <div class="row border_line" id="bonus-funds">
                            <div class="col-sm-10 col-xs-10 left"><p><?=lang('bo_st_20');?></p></div>
                            <div class="col-sm-2 col-xs-2 right"><p id="bonus-funds-val"><?= $accountSummaryDetails['bonusFund'].' '.$currency?></p></div>
                        </div>
                        <div class="row border_line" id="avlbl-withdraw">
                            <div class="col-sm-10 col-xs-10 left"><p><?=lang('bo_st_5');?></p></div>
                            <div class="col-sm-2 col-xs-2 right"><p id="avlbl-withdraw-val"><?php echo $accountSummaryDetails['Withdrawable_RealFund'].' '.$currency;?></p></div>
                        </div>

                        <?php

                        $checkBal = '';
//                            if(IPLoc::Office()){

                                if($accountSummaryDetails['Withdrawable_BonusSafe'] == '0.00'){
                                    $checkBal = 0;
                                } else {
                                    $checkBal = $accountSummaryDetails['Withdrawable_BonusSafe'];
                                }
//                            } else {
//                                $checkBal = $accountSummaryDetails['Withdrawable_BonusSafe'];
//                            }
                        ?>
                        <div class="row border_line">
                            <div class="col-sm-10 col-xs-10 left"><p class="test"><?=lang('bo_st_6');?></p></div>
                            <div class="col-sm-2 col-xs-2 right"><p><?php echo $checkBal.' '.$currency;?></p></div>
                        </div>
                        <div class="row border_line">
                            <div class="col-sm-10 col-xs-10 left"><p><?=lang('bo_st_3');?></p></div>
                            <div class="col-sm-2 col-xs-2 right"><p><?php echo round($accountSummaryDetails['Equity'],2).' '.$currency;?></p></div>
                        </div>
                        <div class="row border_line">
                            <div class="col-sm-10 col-xs-10 left"><p><?=lang('bo_st_4');?></p></div>
                            <div class="col-sm-2 col-xs-2 right"><p><?php echo round($accountSummaryDetails['FreeMargin'],2).' '.$currency;?></p></div>
                        </div>
                    </div>
                </div>
                <div class="btn-text-holder row">
                    <div class="col-sm-12"><p class="calc-bonus"><?=lang('bo_st_7');?></p></div>
                    <div class="col-sm-5">
                        <input id="inp-amount" type="text" maxlength="20" class="form-control round-0 numeric" placeholder="<?=lang('bo_st_19');?> (<?php echo $currency; ?>)">
                    </div>
                    <div class="col-sm-3 cal">
                        <button id='btn-acct-calc' class="btn-acct-calc"><?=lang('bo_st_8');?></button>
                    </div>
                </div>
                <div class="btn-text-holder row">
                    <div class="col-sm-5">
                        <input id="inp-bonus-cancelled" type="text" class="form-control round-0" placeholder="<?=lang('bo_st_21');?> " disabled>
                    </div>
                </div>
                <h3 class="acct-sum-title"><?=lang('bo_st_9');?></h3>
                <!--                <p class="bonus-text bonus-text-sub">-->
                <!--                    There's no bonus on the account-->
                <!--                </p>-->

                <div class="col-md-12 " style="background: white;">
                    <div class="input-daterange col-md-4" style="padding:0px;">
                        <label for="date_from_statistic" class="control-label" style="float:left;display:inline-block;"><span class="translate">Date From</span></label>
                        <input type="date" id="date_from_statistic" class="form-control hx-date" name="date_from_statistic" value="<?php echo date('Y-m-d',strtotime('yesterday'));?>" style="width:98%!important; display:inline-block;">
                    </div>
                    <div class="input-daterange col-md-4" style="padding:0px;">
                        <label for="date_to_statistic" class="control-label" style="float:left;display:inline-block;width:80px;"><span class='translate'>Date To</span></label>
                        <input type="date" id="date_to_statistic" class="form-control hx-date" name="date_to_statistic" value="<?php echo date('Y-m-d',strtotime('now'));?>" style="width:98%!important; display:inline-block;">
                    </div>
                    <div class="input-daterange col-md-2" style="padding:25px;">
                        <button id="btn-apply" type="button">Apply</button>
                    </div>                    
                </div>

                <div class="graph-holder" id="container" style="min-height: 400px;direction: ltr;">
                    <!--<p>Bonus Graph statistics</p>-->
                </div>
                <h3 class="acct-sum-title"><?=lang('bo_st_9');?></h3>
                <div class="row acct-sum-holder">
                    <div class="col-sm-6">
                        <p><?=lang('bo_st_10');?></p>
                    </div>
                    <div class="col-sm-6">
                        <p><?php echo $necessaryNumberofLots; ?></p>
                    </div>
                    <div class="col-sm-6">
                        <p><?=lang('bo_st_11');?></p>
                    </div>
                    <div class="col-sm-6">
                        <p><?php echo $lotsTradeData; ?></p>
                    </div>
                    <div class="col-sm-6">
                        <p><?=lang('bo_st_12');?></p>
                    </div>
                    <div class="col-sm-6">
                        <p><?php echo $lotstoTradeData; ?></p>
                    </div>
                    <div class="col-sm-6">
                        <p><?=lang('bo_st_13');?></p>
                    </div>
                    <div class="col-sm-6">
                        <p class="txt-strong"><?php echo $bonus_status;?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- formula on how to calculate bonus amount to be cancelled-->
<!-- find X, where Y is equal to amount, z is the total 30% bonus received-->
<!-- x = (z / 0.30) - (y * 0.30)-->


<?php if (FXPP::html_url() == 'sa') { ?>
    <script src="https://code.highcharts.com/stock/2.1.9/highstock.js"></script>
<?php } else { ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="https://code.highcharts.com/stock/2.1.9/highstock.js"></script>
<?php } ?>

<script>

    var options = {
        chart: {
            renderTo: 'container'
        },
        rangeSelector: {
            enabled: false
        },
        navigator: {
            enabled: false
        },
        title: {
            text: '<?=lang('bo_st_18');?>'
        },
        series: [
            {
                name: 'Bonus',
                data: [],
                color: '#00FF00'
            }
//            {
//                name: 'Balance',
//                data: [],
//                color: '#003399'
//            }
        ]
    };

    $(function () {

        options.series[0].data = [<?=join($accountSummaryDetails['bonusChart'],",");?>];
//        options.series[1].data = [<?//=join($accountSummaryDetails['balanceChart'],",");?>//];

        window.chart = new Highcharts.StockChart(options, function (chart) {});

        $('#btn-acct-calc').on('click', function(){

            var amount =  $('#inp-amount').val().trim();
            if(amount > 0){

                $('#inp-amount').css('border-color','');

                jQuery.ajax({
                    type:"POST",
                    url: "/bonus/calculateBonusLeft",
                    data: {
                        'amount':amount
                    },
                    dataType: 'json',
                    beforeSend: function(){
                        $('#loader-holder').show();
                    },
                    success: function(bonusLeft){
                        $('#loader-holder').hide();
                        jQuery('[id^="bt-tab"]').removeClass('active');
                        if(bonusLeft < 0){
                            bootbox.alert({
                                title: '<?= lang('trd_252');?>',
                                message: '<?= lang('trd_253');?>',
                                show: true
                            });

                            $('#inp-bonus-cancelled').val(0);
                        }else{
                            $('#inp-bonus-cancelled').val(roundtoTwo(bonusLeft));
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('#loader-holder').hide();
                    }
                });
            }else{
                $('#inp-amount').css('border-color','red');
            }


        });
    });

    function roundtoTwo( value ){
        return +(Math.round(value + "e+2") + "e-2");
    }

   

$(document).ready(function(){


    jQuery(".numeric").on("keypress keyup blur",function (event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    jQuery(".numeric").on("cut copy paste",function (event) {
        //if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
       // }
    });


    jQuery(".numeric").on("blur",function (event) {
        var value=$(this).val().replace(/[^0-9.,]*/g, '');
        value=value.replace(/\.{2,}/g, '.');
        value=value.replace(/\.,/g, ',');
        value=value.replace(/\,\./g, ',');
        value=value.replace(/\,{2,}/g, ',');
        value=value.replace(/\.[0-9]+\./g, '.');
        $(this).val(value)
    });
   
   ///  noBonusCheckBox();  // [FXPP-13199][noBonusCheckBox is not defined ==> if you need active this method you should write a definition for this function otherwise call the reference method with the file.]
   var url = '<?= base_url(); ?>';
   $(document).on("click","#btn-apply",function(){


    var data = {            
        from: $('#date_from_statistic').val(),
        to: $('#date_to_statistic').val(),
        
    }; 

  
    $.ajax({
            type: 'POST',
            url: url+'/bonus/bonuses_statistic_byDate',
            data: data,
            dataType: 'json',                
            success: function(response){         
        

                            var options = {
                                chart: {
                                    renderTo: 'container'
                                },
                                rangeSelector: {
                                    enabled: false
                                },
                                navigator: {
                                    enabled: false
                                },
                                title: {
                                    text: '<?=lang('bo_st_18');?>'
                                },
                                series: [
                                    {
                                        name: 'Bonus',
                                        data: response,
                                        color: '#00FF00'
                                    }
                                ]
                            };


                            window.chart = new Highcharts.StockChart(options, function (chart) {});

                                    
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(err);
            }
        });   


    });

}) ;
    



</script>

<script type="text/javascript">

    $(function(){
        var res_balance = $('.val_balance').height();
        var real_fund = $('#real-funds-val').height();
        var bonus_funds = $('#bonus-funds-val').height();
        var avlbl_withdraw = $('#avlbl-withdraw-val').height();
        $('.balance').css('height',res_balance);
        $('#real-funds p').css('height',real_fund);
        $('#bonus-funds p').css('height',bonus_funds);
        $('#avlbl-withdraw p').css('height',avlbl_withdraw);
    });
</script>