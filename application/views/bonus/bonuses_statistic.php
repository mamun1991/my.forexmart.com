<?php include_once('bonus_nav.php') ?>
<?php $this->lang->load('bonus_statics_lang'); ?>
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
                <div class="row acct-sum-holder">
                    <div class="col-sm-10">
                        <p><?=lang('bo_st_2');?></p>
                    </div>
                    <div class="col-sm-2">
                        <p><?php echo $accountSummaryDetails['Balance'].' '.$currency;?></p>
                    </div>
                    <div class="col-sm-10">
                        <p><?=lang('bo_st_3');?></p>
                    </div>
                    <div class="col-sm-2">
                        <p><?php echo $accountSummaryDetails['Equity'].' '.$currency;?></p>
                    </div>
                    <div class="col-sm-10">
                        <p><?=lang('bo_st_4');?></p>
                    </div>
                    <div class="col-sm-2">
                        <p><?php echo $accountSummaryDetails['FreeMargin'].' '.$currency;?></p>
                    </div>
                    <div class="col-sm-10">
                        <p><?=lang('bo_st_5');?></p>
                    </div>
                    <div class="col-sm-2">
                        <p><?php echo $accountSummaryDetails['Withdrawable_RealFund'].' '.$currency;?></p>
                    </div>
                    <div class="col-sm-10">
                        <p><?=lang('bo_st_6');?></p>
                    </div>
                    <div class="col-sm-2">
                        <p><?php echo $accountSummaryDetails['Withdrawable_BonusSafe'].' '.$currency;?></p>
                    </div>
                    <div class="col-sm-10">
                        <p class="calc-bonus"><?=lang('bo_st_7');?></p>
                    </div>
                    <div class="col-sm-2">
                        <p></p>
                    </div>
                </div>
                <div class="btn-text-holder row">
                    <div class="col-sm-5">
                        <input id="inp-amount" type="text" class="form-control round-0" placeholder="<?=lang('bo_st_19').' ('.$currency.')';?>">
                    </div>
                    <div class="col-sm-3">
                        <button id='btn-acct-calc' class="btn-acct-calc"><?=lang('bo_st_8');?></button>
                    </div>
                </div>
                <div class="btn-text-holder row">
                    <div class="col-sm-5">
                        <input id="inp-bonus-cancelled" type="text" class="form-control round-0" placeholder="<?=lang('bo_st_15');?>">
                    </div>
                </div>
                <h3 class="acct-sum-title"><?=lang('bo_st_9');?></h3>
                <!--                <p class="bonus-text bonus-text-sub">-->
                <!--                    There's no bonus on the account-->
                <!--                </p>-->
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
                            title: '<?=lang('bo_st_16');?>',
                            message: '<?=lang('bo_st_17');?>',
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
        });
    });

    function roundtoTwo( value ){
        return +(Math.round(value + "e+2") + "e-2");
    }


</script>