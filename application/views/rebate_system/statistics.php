<style>
    .ui-datepicker-trigger{cursor:pointer;}
</style>
        <div role="tabpanel" class="tab-pane active" id="tab3">
            <div class="row">
                <div class="col-md-12 rebate-child-container">
                    <div class="row">
                        <div class='col-md-4'>
                            <div class="form-group">
                                <div class='input-group' id='dtimpicker-from'>
                                    <input type='text' class="form-control" id="inp-dtimpicker-from"/>
                        <span class="input-group-addon" id="sp-dtimpicker-from">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class="form-group">
                                <div class='input-group' id='dtimpicker-to'>
                                    <input type='text' class="form-control" id="inp-dtimpicker-to"/>
                                    <span class="input-group-addon" id="sp-dtimpicker-to">
                                    <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mbl-right">

                            <button type="button" class="btn btn-primary btn-secondary  btn-login btn-md" id="show"><?= lang('show'); ?></button>

                        </div>
                    </div>
                </div>
                <div class="col-sm-12 rebate-child-container">
                    <div class="rebate-accountnumbers">
                        <label class="rebate-label"><?= lang('accounts'); ?></label>
                        <select id="account_number" class="dropdown-account-numbers form-control round-0">
                            <option><?= lang('accounts'); ?></option>
                            <?php  if($referrals){

                                foreach($referrals as $d){

                                    ?>
                                    <option value="<?=$d['account_number']?>"><?=$d['account_number']?></option>

                                <?php } }?>
                        </select>
                    </div>
                    <div class="rebate-system-checkbox">
                       <!-- <input type="checkbox"/>
                        <p>Include trades details checkbox</p>-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-centered">
                    <div class="graph-holder" id="container">
                        <p><?= lang('reb_statistics'); ?></p>
                    </div>
                </div>
            </div>
        </div>
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
            var base_url = "<?=FXPP::ajax_url();?>";

            $(document).ready(function () {
                var date_from = "<?php echo date("Y-m-d",strtotime("- 1 month"));?>";
                var date_to = "<?php echo date("Y-m-d");?>";


                ajaxView("All",date_to,date_from);

                $('#inp-dtimpicker-from').click(function(){
                    $('span#sp-dtimpicker-from').click();
                });

                $('#inp-dtimpicker-to').click(function(){
                    $('span#sp-dtimpicker-to').click();
                });

                $('#dtimpicker-from').datetimepicker({
                    format: 'YYYY-MM-DD',
                    defaultDate: date_from
                });

                $('#dtimpicker-to').datetimepicker({
                    format: 'YYYY-MM-DD',
                    defaultDate: date_to,
                });

                $("#dtimpicker-from").on("dp.change", function (e) {
                    $('#dtimpicker-to').data("DateTimePicker").minDate(e.date);
                });

                $("#dtimpicker-to").on("dp.change", function (ev) {
                    $('#dtimpicker-from').data("DateTimePicker").maxDate(ev.date);
                });
            });





            $(document).on("click","#show",function(){
                $("#loader-holder").show();
                var account_number = $("#account_number").val();
                var from = $("#dtimpicker-from").data('date');
                var to = $("#dtimpicker-to").data('date');

                ajaxView(account_number,to,from);


            });

            function ajaxView(account_number,to,from){
                $.post(base_url+"rebate_system/statisticsData",{account_number:account_number,to:to,from:from},function(data){
                    console.log(data);
                    viewGrap(data);
                    $("#loader-holder").hide();
                })
            }
            


            function viewGrap(datas){
                $('#container').highcharts({
                    chart: {
                        type: 'spline'
                    },
                    title: {
                        text: '<?= lang("reb_sys_statistics"); ?>'
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        type: 'datetime',
                        dateTimeLabelFormats: { // don't display the dummy year
                            month: '%e. %b',
                            year: '%b'
                        },
                        title: {
                            text: '<?= lang("oth_com_20_15"); ?>'
                        }
                    },
                    yAxis: {
                        title: {
                            text: '<?= lang("reb_amount"); ?>'
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
                        name: '<?= lang("reb_statistics"); ?>',
                        data: eval(datas)
                    } ]
                });
            }
        </script>