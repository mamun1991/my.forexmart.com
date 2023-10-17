<?php include_once('partnership_nav.php') ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!--<script src="<?/*=base_url()*/?>assets/js/highstock.js"></script>-->
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="<?=base_url()?>assets/js/exporting.js"></script>
<style type="text/css">
    .left-button-group {
        display: table;
        float: left;
    }

    .left-button-group ul {
        margin: 0;
        padding: 0;
    }

    .left-button-group ul li {
        float: left;
        background: #2988CA;
        padding: 7px 10px;
        list-style-type: none;
        margin: 0 2px;
        cursor: pointer;
        transition: all ease 0.3s;
    }

    .left-button-group ul li a {
        color: #fff;
        display: block;
        text-decoration: none;
    }
</style>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="commission">
        <?php  if(!FXPP::isEUUrl()) { ?>
            <div class="row">
                <div class="col-sm-12">
                    <p class="part-text">
                        <?= lang('cpa_00') ?>.
                    </p>
                </div>
                <div class="col-md-12 period-txt-holder">
                    <?php /*
                <div class="left-button-group">
                    <ul>
                        <li class="<?= $active==1?"acct-active":''?>"><a href="<?=site_url('partnership/cpa')?>?cpa=1" >Approved</a></li>
                        <li class="<?= $active==0?"acct-active":''?>"><a href="<?=site_url('partnership/cpa')?>?cpa=0"  >Pending</a></li>
                        <li class="<?= $active==2?"acct-active":''?>"><a href="<?=site_url('partnership/cpa')?>?cpa=2"  >Declined</a></li>
                    </ul>
                </div>
                */ ?>
                    <form class="form-inline">
                        <?php /*
                    <div class="form-group">
                        <a href="<?=site_url('withdraw')?>" class="btn btn-success col-md-12"> Withdraw all CPA Commissions</a>
                    </div>
 */ ?>
                    </form>

                </div>
                <?php
                /*
                <div class="col-sm-12">
                    <p style="margin-top: 5px;" class="">
                        <b>Total Registered Referrals:&nbsp; <?=$no_of_registered_acc;?></b>
                    </p>
                </div>
                */ ?>
            </div>
            <?php if ($data['active'] == 1) {?>
                <div class="row">
                    <div class="col-md-12 col-centered">
                        <div class="graph-holder" id="container" style="min-height: 400px;">
                            <p><?= lang('cpa_01') ?></p>
                        </div>
                    </div>
                </div>
            <?php }
        }?>
        <div class="table-responsive">
            <table class="commission-table-container table table-striped part-table">
                <thead>
                <tr>
                    <th><?=lang('cpa_02')?> <?=$data['type']?> <?=lang('cpa_03')?></th>
                    <th><?=lang('cpa_04')?></th>
                    <th><?=lang('cpa_05')?></th>
                    <th><?=lang('cpa_06')?></th>
                    <th>Currency</th>
                    <?php  if(!FXPP::isEUUrl()){ ?>
                    <th><?=lang('cpa_07')?></th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php
                $data = array();
                $val=0;
                $ctr = 1;
                    if($cpa){
                    $val = 0;
                    foreach($cpa as $d){

                    if(IPLoc::Office()){

                        if ($d->micro == 1) {
                            $amount = $d->amount / 100;
                        } else {
                            $amount = $d->amount;
                        }
                    }else{
                        $amount = $d->amount;
                    }

                    $val=$val + $d->cpa_amount;
                    $data[]="[".strtotime($d->registration_time)*1000 .",".$val."]";
                    ?>
                    <tr>
                       <td><?=$ctr?></td>
                       <td><?=$d->registration_time?></td>
                       <td><?=number_format($amount,2)?></td>
                       <td><?=$d->account_number?></td>
                        <td><?=$d->mt_currency_base?></td>
                       <?php  if(!FXPP::isEUUrl()){ ?>
                        <td><?=number_format($d->cpa_amount,2)?></td>
                        <?php } ?>
                    </tr>
                        <?php
                            $ctr++;
                        }
                        ?>
                     <?php  if(!FXPP::isEUUrl()){ ?>
                    <tr>
                        <th colspan="5"><?=lang('cpa_08')?></th>
                        <th><?php echo $val ?></th>
                    </tr>
                    <?php } ?>
                        <?php
                    }else{
                ?>
                <tr>
                    <td colspan="5" class="center"><?=lang('cpa_09')?>.</td>
                </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>

<?php if($data['active']==1){?>

    $(function () {
        // Create the chart
        window.chart = new Highcharts.StockChart({
            chart: {
                renderTo: 'container'
            },

            rangeSelector: {
                allButtonsEnabled: true,


                buttons: [{
                    type: 'day',
                    count: 1,
                    text: 'Daily'
                }, {
                    type: 'week',
                    count: 1,
                    text: 'Weekly'
                }, {
                    type: 'month',
                    count: 1,
                    text: 'Monthly'
                }, {
                    type: 'month',
                    count: 3,
                    text: 'Quarterly'
                }, {
                    type: 'year',
                    count: 1,
                    text: 'Yearly'
                }, {
                    type: 'all',
                    text: 'All'
                }],
                buttonTheme: {
                    width: 70
                },
                selected: 5,

                inputDateFormat: '%d-%m-%Y',
                inputDateParser: function (value) {
                    value = value.split('-');
                    return Date.UTC(
                        parseInt(value[2]),
                        parseInt(value[1]) - 1,
                        parseInt(value[0])
                    );
                }
            },

            title: {
                text: '<?=lang('cpa_10')?>'
            },

            series: [{
                name: 'Click',
                data: [<?php echo join(",",$data);?>],
                tooltip: {
                    valueDecimals: 2
                }
            }]

        }, function (chart) {

            // apply the date pickers
            setTimeout(function () {
                $('input.highcharts-range-selector', $('#' + chart.options.chart.renderTo)).datepicker()
            }, 0)
        });



        // Set the datepicker's date format
        $.datepicker.setDefaults({
            dateFormat: 'dd-mm-yy',
            onSelect: function (dateText) {
                this.onchange();
                this.onblur();
            }
        });
//        $('#container').StockChart({
//            chart: {
//                type: 'spline'
//            },
//            title: {
//                text: '<?=lang('cpa_10')?>'
//            },
//            rangeSelector: {
//                allButtonsEnabled: true,
//                buttons: [{
//                    type: 'day',
//                    count: 1,
//                    text: 'Daily'
//                }, {
//                    type: 'week',
//                    count: 1,
//                    text: 'Weekly'
//                }, {
//                    type: 'month',
//                    count: 1,
//                    text: 'Monthly'
//                }, {
//                    type: 'month',
//                    count: 3,
//                    text: 'Quarterly'
//                }, {
//                    type: 'year',
//                    count: 1,
//                    text: 'Yearly'
//                }, {
//                    type: 'all',
//                    text: 'All'
//                }],
//                buttonTheme: {
//                    width: 70
//                },
//                selected: 5,
//
//                inputDateFormat: '%d-%m-%Y',
//                inputDateParser: function (value) {
//                    value = value.split('-');
//                    return Date.UTC(
//                        parseInt(value[2]),
//                        parseInt(value[1]) - 1,
//                        parseInt(value[0])
//                    );
//                }
//            },
//            subtitle: {
//                text: ' '
//            },
//            xAxis: {
//                type: 'datetime',
//                dateTimeLabelFormats: { // don't display the dummy year
//                    month: '%e. %b',
//                    year: '%b'
//                },
//                title: {
//                    text: 'Date'
//                }
//            },
//            yAxis: {
//                title: {
//                    text: ' '
//                },
//                min: 0
//            },
//            tooltip: {
//                headerFormat: '<b>{series.name}</b><br>',
//                pointFormat: '{point.x:%e. %b}: {point.y:.2f}'
//            },
//
//            plotOptions: {
//                spline: {
//                    marker: {
//                        enabled: true
//                    }
//                }
//            },
//
//            series: [{
//                name: '<?=lang('cpa_10')?>',
//                data: [<?php //echo join(",",$data);?>//]
//            }]
//        });
    });
    <?php } ?>

</script>