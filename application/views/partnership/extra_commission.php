<?php include_once('partnership_nav.php') ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!--<script src="<?/*=base_url()*/?>assets/js/highstock.js"></script>-->
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="<?=base_url()?>assets/js/exporting.js"></script>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="commission">
        <div class="row">
            <div class="col-sm-12">
                <p class="part-text">
                    Monitor the commission credited into your account for a specific period of time.
                </p>
            </div>
            <div class="col-md-12 period-txt-holder">

                <div class="left-button-group ">
                    <!--<a href="<?/*=site_url('withdraw')*/?>" class="float-right btn-withdraw"> Withdraw all Extra Commissions</a>-->
                    <ul style="display: none">
                        <li><a href="<?=site_url('partnership/extra-commission')?>?ext=1">Approved</a></li>
                        <li><a href="<?=site_url('partnership/extra-commission')?>?ext=0">Pending</a></li>
                        <li><a href="<?=site_url('partnership/extra-commission')?>?ext=2">Declined</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-12">
                <p style="margin-top: 5px;" class="">
                    <b>Total Registered Referrals:&nbsp; <?=$no_of_registered_acc;?></b>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-centered">
                <div class="graph-holder" id="container" style="min-height: 400px;">
                    <p>Graph stats of Extra commissions</p>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="commission-table-container table table-striped part-table">
                <thead>
                <tr>
                    <th>No. of <?=$type?> Deposits</th>
                    <th>Date of Registration</th>
                    <th>Client's first deposit</th>
                    <th>Account Number</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $data = array();
                $val=0;
                $i=1;
                if($extra_commission_list){
                    foreach($extra_commission_list as $d){

                        if($d->extra == $extra){
                        $val=$val + $d->amount;
                        $data[]="[".strtotime($d->registration_time)*1000 .",".$val."]";
                        ?>
                        <tr>
                        <td><?=$i++;?></td>
                        <td><?=$d->registration_time?></td>
                        <td><?=$d->amount?></td>
                        <td><?=$d->account_number?></td>
                        </tr>
                    <?php } }
                }else{
                    ?>
                    <tr>
                        <td colspan="4" class="center"><?= lang('no_records_found'); ?></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<style>
    .btn-withdraw{width: 280px;
        float: right;}
</style>
<script>

    $(function () {
        $('#container').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Statistics of the Extra commission'
            },
            subtitle: {
                text: ' '
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                },
                title: {
                    text: 'Date'
                }
            },
            yAxis: {
                title: {
                    text: ' '
                },
                min: 0
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x:%e. %b}: {point.y:.2f} m'
            },

            plotOptions: {
                spline: {
                    marker: {
                        enabled: true
                    }
                }
            },

            series: [{
                name: 'Statistics of the Extra commission',
                data: [<?php echo join(",",$data);?>]
            }]
        });
    });

</script>