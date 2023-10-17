<?php include_once('partnership_nav.php') ?>
<?php $this->lang->load('datatable');?>
<style>
    .period-option {
        width: 100%!important;
    }
    .part-table:lang(sa) {
        margin-top: 20px !important;
    }
    .click-table td { text-align: center; }

    .center-data{
        text-align: center;
    }
    @media screen and (max-width: 991px) and (-webkit-min-device-pixel-ratio:0){
        .btnapply{
            float: right;
        }
     }
      @media screen and (max-width: 463px)and (min-width: 344px) and (-webkit-min-device-pixel-ratio:0){
        .ulday{
            margin-top:5px;
        }
        .nav-pills li{
            width: 32.5%!important;
        }
     }
      @media screen and (max-width: 343px) and (-webkit-min-device-pixel-ratio:0){
         .ulday{
            margin-top:5px;
        }
        .nav-pills li{
            width: 100%!important;
        }
     }
.highcharts-container{
	width: auto !important;
}
.table-padding {
	padding: 10px 0;
}
th {
    width: min-content !important;
}
</style>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="clicks">
       <div class="table-padding">
        <div class="table-responsive">
            <table class="table table-striped part-table click-table arabic-part-table" id="tab-clicks-table" cellspacing="0" width="100%"  cellspacing="0" border="0">
                <thead>
                <tr>
                    <th class="center-data">
                        <?=lang('cli_02');?>
                    </th>
                    <th class="center-data">
                        <?=lang('cli_03');?>
                    </th>
                    <th class="center-data">
                        <?=lang('cli_04');?>
                    </th>
                    <th class="center-data">
                        <?=lang('cli_04');?>
                    </th>
                    <th class="center-data">
                        <?=lang('cli_04');?>
                    </th>
                    <th class="center-data">
                        <?=lang('cli_04');?>
                    </th>
                </tr>
                </thead>
                <tbody>
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
    $(function () {

        $('.click-table').DataTable({
            dom: 'ltip',
            processing : true,
            serverSide: true,
            responsive: true,
            ordering: false,
            deferLoading: 5,
            language:{
                search:'<?=lang('curtra_s')?>',
                lengthMenu: '<?=lang('dta_tbl_07')?>',
                info: '<?=lang('dta_tbl_02')?>',
                zeroRecords: '<?=lang('dta_tbl_01')?>',
                paginate: {
                    next:       '<?=lang('dta_tbl_14')?>',
                    previous:   '<?=lang('dta_tbl_15')?>'
                }
            },
            ajax:{
                type: 'post',
                url: '/partnership_test/getTrades',
				data: {from:getDateFrom, to:getDateTo},
                dataType: 'json',
                data: function(d){
                    $('#loader-holder').show();
                    return d;

                }
            },
            drawCallback : function (oSettings) {

                if(oSettings.fnRecordsDisplay() == 0){
                    $(oSettings.nTableWrapper)
                        .find('.dataTables_paginate, .dataTables_filter, .dataTables_length, .dataTables_info')
                        .hide();
                }else{

                    $(oSettings.nTableWrapper)
                        .find('.dataTables_paginate, .dataTables_filter, .dataTables_length, .dataTables_info')
                        .show();
                }
                $('#loader-holder').hide();
            }
        });

        $('#tab-clicks-table').DataTable().draw();


    });

   
</script>