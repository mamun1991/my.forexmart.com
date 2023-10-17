<?php include_once('partnership_nav.php') ?>
<?php $this->lang->load('datatable'); ?>
<style>
    .period-option {
        width: 411px !important;
    }

    .part-table:lang(sa) {
        margin-top: 20px !important;
    }

    .referral-table td {
        text-align: center;
    }

    .center-data {
        text-align: center;
    }

    @media screen and (max-width: 991px) and (-webkit-min-device-pixel-ratio:0) {
        .btnapply {
            float: right;
        }
    }

    @media screen and (max-width: 463px)and (min-width: 344px) and (-webkit-min-device-pixel-ratio:0) {
        .ulday {
            margin-top: 5px;
        }

        .nav-pills li {
            width: 32.5% !important;
        }
    }

    @media screen and (max-width: 343px) and (-webkit-min-device-pixel-ratio:0) {
        .ulday {
            margin-top: 5px;
        }

        .nav-pills li {
            width: 100% !important;
        }
    }

    .highcharts-container {
        width: auto !important;
    }

    .table-padding {
        padding: 10px 0;
    }

    .table>thead:first-child>tr:first-child>th {
        border-top: 0;
        text-align: center;
    }
</style>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="referrals">

      

          

            <form class="form-inline" action="" method="post">
                <div class="form-group">
                    <label for="email">From:</label>
                    <input id="from" name="from" type="text" class="form-control" value="<?php echo $from;?>" >
                </div>
                <div class="form-group">
                    <label for="pwd">To:</label>
                    <input id="to" name="to" type="text" class="form-control" value="<?php echo $to;?>">
                </div>
               
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        

        <div class="table-padding">
            <div class="table-responsive">
                <table class="table table-striped part-table referral-table arabic-part-table" id="tab-referrals-table" cellspacing="0" width="100%" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <th><?=lang('oth_com_20_15');?></th>
                            <th><?=lang('oth_com_20_16');?></th>
                            <th><?=lang('oth_com_20_17');?> </th>
                            <th><?=lang('oth_com_20_18');?></th>


                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($trading_history as $d) {

                        ?>
                            <tr>
                                <td><?php echo $d->OpenTIme ?></td>
                                <td><?php echo $d->Login ?></td>
                                <td><?php echo $d->Volume ?></td>
                                <td><?php echo $d->Symbol ?></td>

                            </tr>


                        <?php } ?>




                    </tbody>
                </table>
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
    $('#tab-referrals-table').dataTable({
        "order": [
            [0, "desc"]
        ], //or asc 

    });


    $('#from').datepicker({ dateFormat: 'yy-mm-dd',changeYear:true, });
    $('#to').datepicker({ dateFormat: 'yy-mm-dd',changeYear:true, });
</script>