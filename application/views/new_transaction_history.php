<style>
    @media screen and (max-width: 767px){
        .crTradesMob{   display: none; }
        .crTradesWeb{  display: ;}
        .showDetailsMob,.crTradesWebStyle{  color: #337AB7; }
    }
    @media screen and (min-width: 767px){
        .crTradesMob{ display:;}
        .crTradesWeb{  display:none ; }
    }
    tbody#result{
        font-size:10px;
    }
    .hist-tab-nav ul li button{
        display: block;
        /*padding: 7px 15px;*/
        padding: 7px 10px;
        background: #EEE;
        color: #333;
        transition: all ease 0.3s;
        border: none;
    }
    .hist-tab-nav ul li button.active{
        background: #C0C0C0!important;
    }
    .hist-tab-nav ul{
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .hist-tab-nav ul li{
        float: left;
    }
    .history-form-holder{
        text-align: center;
    }
    .dataTables_length{
        display: inline-block;
        float: left;
    }
    div.dataTables_wrapper div.dataTables_filter input{
        border: 1px solid #cec9c9;
    }
    div.dataTables_wrapper{
        padding: 10px;
    }
    div#trans-history .table>tbody>tr>td, .table>tfoot>tr>td,  .table>thead>tr>td{
        font-size: 11px;
    }
    div#trans-history .table>tbody>tr>th,.table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        font-size: 12px;
        text-align: center;
    }
    div.dataTables_wrapper div.dataTables_paginate{
        text-align: center;
        /*margin-top: 10px;*/
    }

    div.dataTables_wrapper div.dataTables_paginate .paginate_button:hover{
        /*color: #fff;*/
        /*background-color: #337ab7;*/
        /*border-color: #337ab7;*/
    }
    div.dataTables_wrapper div.dataTables_paginate .paginate_button{
        margin: 0px;
        padding: 0px;
        /*position: relative;*/
        /*padding: 6px 12px;*/
        /*margin-left: -1px;*/
        /*line-height: 1.42857143;*/
        /*color: #337ab7;*/
        /*text-decoration: none;*/
        /*background-color: #fff;*/
        /*border: 1px solid #ddd;*/
    }
    div#trans-history label.hdr{
        font-size: 15px;
        font-weight: 600;
        display: block;
        background: #EEE;
        color: #777777;
        padding: 2px;
        text-align: left;
        margin-left: 5px;
    }
    ul.pagination{




        margin:0px;
    }
    ul.pagination>li>a, .pagination>li>span{
        margin:0px;
    }
    table.dataTable.no-footer {
        border-bottom: 1px solid #ddd!important;
    }
    table.dataTable thead th, table.dataTable thead td{
        border: 1px solid #ddd!important;
    }
    .control-label, .input-daterange{
        padding: 8px 0;
    }
    .left-padding{
        padding: 0 10px;
    }
    .left-margin{
        margin: 0 10px;
    }
    #btn-search-trade-history{
        width: 80%;
        padding: 5px;
        background: #85c7f3;
        color: #fff;
        margin-left: 10%;
        border: 1px solid #85c7f3;
        border-radius: 2px;
        font-weight: bold;
        line-height: 20px;
        margin-top: 25px;
    }
    #btn-search-trade-history:hover{
        background: #106baa;
    }
    button.btn-view-trans-details {
        background: #106baa;
        color: #fff;
        border: none;
        padding: 4px;
    }
    button.btn-view-trans-details:hover {
        background: #85c7f3;
        color: #000;
    }
    button.btn-view-recall {
        background: #29a643;
        color: #fff;
        border: none;
        padding: 4px;
    }
    button.btn-view-recall:hover {
        background: #29a643;
        color: #000;
    }
    .tab-content>.tab-pane{
        margin-top: 30px;
    }
    li.us-acc-li {
        margin-left: 76%;
        font-size: 18px;
        font-weight: bold;
        margin-top: -4%;
    }
    .us-acc{
        color: red!important;
    }
	div.dataTables_wrapper div.dataTables_info {
    padding-top: 8px;
    white-space: nowrap;
    float: left;
    }

    /*@media screen and (max-width: 414px){*/
        /*body#page-top {*/
            /*width: 170%!important;*/
        /*}*/
        /*li.us-acc-li {*/
            /*margin-left: 70%!important;*/
            /*margin-top: -6%!important;*/
        /*}*/
    /*}*/




</style>
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
<!--<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>-->

<?php $method = $this->router->method; ?>
<?php $class = $this->router->class; ?>
<?php $this->lang->load('datatable');?>
<?= $this->load->ext_view('modal', 'preloader', '', TRUE); ?>
<?php
//echo '<pre>';
//print_r($_SESSION);
?>
<?php $this->load->view('finance_nav.php');?>

<h1>
    <?=lang('finav_04');?>
</h1>
<div class="tab-content acct-cont">
    <?php if($active_sub_tab=='transaction-history'){ ?>
        <div style="display: none;">
            <div class="col-md-12" style="margin-bottom: 10px;">
				<div class="row">
					<div class="input-daterange col-md-5">
						<label for="date_from_history" class="control-label left-padding" style="float:left;display:inline-block;"><span class="translate"><?=lang('trans_00')?></span></label>
						<input type="date" id="date_from_history" class="form-control hx-date left-margin" name="date_from_history" value="<?php echo date('Y-m-d',strtotime('-1 month'));?>" style="width:96%!important; display:inline-block;">
					</div>
					<div class="input-daterange col-md-5">
						<label for="date_to_history" class="control-label left-padding" style="float:left;display:inline-block;"><span class='translate'><?=lang('trans_01')?></span></label>
						<input type="date" id="date_to_history" class="form-control hx-date left-margin" name="date_to_history" value="<?php echo date('Y-m-d',strtotime('now'));?>" style="width:96%!important; display:inline-block;">
					</div>
					<div class="input-daterange col-md-2">
						<button id="btn-search-trade-history accessoperationtab" type="button"><?=lang('trans_03')?></button>
					</div>
				</div>
            </div>
        </div>


        <div class="hist-tab-nav">
            <ul>
                <li><button class="hist-nav active accessoperationtab" data-tog="pending-transactions"><?=lang('trans_04')?></button></li>
                <li><button class="hist-nav accessoperationtab" data-tog="transaction-history"><?=lang('trans_05')?></button></li>
                <li class="us-acc-li"><button class="us-acc accessoperationtab"><?=lang('trans_05')?> <?php echo $_SESSION['account_number']; ?></button></li>
            </ul>
        </div>


        <div role="tabpanel" class="row tab-pane active pending-transactions" >
            <div class="col-sm-12 table-responsive">
                <p class="cur-trades-text arabic-cur-trades-text"></p>
                <div class="row history-form-holder">
                    <div class="col-sm-12 col-centered">
                        <table id="tbl-pending-transactions " class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table pending-transactions">
                            <thead style=" font-weight: bold; ">

                                    <td>#</td>
                                    <td><?=lang('trans_06')?></td>
                                    <td><?=lang('trans_07')?></td>
                                    <td><?=lang('trans_08')?></td>
                                    <td><?=lang('trans_09')?></td>
                                    <td><?=lang('trans_10')?></td>
                                    <td><?=lang('trans_11')?></td>
                                </tr>


                            </thead>
                            <tbody id="result"></tbody>
                        </table>
                    </div>
                    <div style='text-align: center;' id='showing' class="col-md-12"></div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="row tab-pane transaction-history">
            <div class="col-sm-12 ">
                <p class="cur-trades-text arabic-cur-trades-text"></p>
                <a href="<?php echo base_url()?>transaction-history/newDownloadExcel"><?=lang('download_excel');?></a> | <a href="<?php echo base_url()?>transaction-history/newDownloadPdf"><?=lang('download_PDF');?></a>
                <div class="row history-form-holder">

                    <div class="col-sm-12 col-centered table-responsive" id="trans-history">
                        <table id="tbl-transaction-history" class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table transaction-history click-table">
                            <thead style=" font-weight: bold; ">
                            <tr>
								<td>#</td>
								<td><?=lang('trans_06')?></td>
								<td><?=lang('trans_07')?></td>
								<td><?=lang('trans_08')?></td>
								<td><?=lang('trans_09')?></td>
								<td><?=lang('trans_10')?></td>
								<td><?=lang('trans_11')?></td>
                            </tr>
                            </thead>
                            <tbody id="result">

                            </tbody>
                        </table>
                    </div>
					<div class="row">
						<div class="col-md-6"  id='transaction-history-showing'></div>
						<div class="col-md-6" id='transaction-history-pagination' class="pagination"></div>
					</div>
                </div>
            </div>
        </div>
    <?php } ?>

</div>
<div class="modal fade" id="recallModalButton" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close accessoperationtab" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center bonus-alert-title"><?=lang('trans_12')?></h4>
            </div>
            <div class="modal-body modal-show-body">
                <div class="text-center bonus-alert-message">
                    <p><strong><?=lang('trans_13')?></strong></p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="center-block">
                    <button type="button" class="modalButton accessoperationtab" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><?=lang('trans_14')?></span></button>
                    <button type="button" class="tabRecallNo accessoperationtab" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><?=lang('trans_15')?></span></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRecallAlert" tabindex="=-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog round-0">
        <div  class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close accessoperationtab" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center modal-show-title" id="modalBonusDelayTitle"><?=lang('trans_16')?></h4>
            </div>
            <div class="modal-body modal-show-body">
                <div class="text-center recall-msg">
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="openTransectionModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content withdraw-->
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
                <strong style="font-size: 20px"> <?=lang('trans_03')?>  </strong>
                <button id="modalOPenTransaction" type="button" class="close accessoperationtab" data-dismiss="modal" data-toggle="tooltip" ><span aria-hidden="true">&times;</span></button>


            </div>
            <div class="modal-body">

                <p id="m_message">
                </p>

                <table id="transDetails" class="table table-striped tab-my-acct">

                    <tr>
                        <th><?=lang('trans_17')?></th>
                        <td class="cRef"> </td>
                    </tr>

                    <tr>
                        <th><?=lang('trans_18')?></th>
                        <td class="cType"> </td>
                    </tr>
                    <tr>
                        <th><?=lang('trans_19')?> </th>
                        <td class="cTrns"> </td>
                    </tr>

                    <tr  >
                        <th><?=lang('trans_20')?></th>
                        <td class="cAcc"> </td>
                    </tr>

                    <tr >
                        <th><?=lang('trans_08')?></th>
                        <td class="cAmnt"> </td>
                    </tr>


                    <tr>
                        <th><?=lang('trans_21')?></th>
                        <td class="cPay"> </td>
                    </tr>

                    <tr>
                        <th><?=lang('trans_10')?></th>
                        <td class="cdate"> </td>
                    </tr>


                </table>







            </div>

        </div>

    </div>
</div>
<script>
    
var isReadOnlyRemoveFromMWP ="<?= FXPP::isReadOnlyRemoveFromMWP()?>";    
    
    $(document).ready(function () {
        reomveReadOnlyAccess(); // remove readonly;
        getPendingWD();

        $('div.active div.pagination').on('click','a',function(e){
            e.preventDefault();
            var pageNo = $(this).attr('data-ci-pagination-page');
            getTradeRecords(recordType,pageNo);
        });
        $('#transaction-history-pagination').on('click','a',function(e){
            e.preventDefault();
            var pageNo = $(this).attr('data-ci-pagination-page');
            getTradeRecords(recordType,pageNo);
        });

        $('.hist-nav').click(function () {
            var navType = $(this).data('tog');
            console.log(navType);

            if(navType == 'pending-transactions'){
                getPendingWD();
            }else{
                getTnx(2);
            }
            $('.'+navType).addClass('active');

            $(".tab-pane").each(function(){
                $(this).removeClass('active');
                if( $(this).hasClass(navType) ){    $(this).addClass('active');  }
            });

            $(".hist-nav").each(function(){$(this).removeClass('active');  });
            $(this).addClass('active');

        });


       /* $('.hist-nav').click(function () {
            recordType = $(this).data('tog');

            if(recordType == 'pending-transactions'){
                getPendingWD();
            } else if(recordType == 'transaction-history'){


                getTransactionHistoryRecords(recordType);

            }else{
                getTradeRecords(recordType,0);
            }



            $(".tab-pane").each(function(){
                $(this).removeClass('active');
                if( $(this).hasClass(recordType) ){    $(this).addClass('active');  }
            });

            $(".hist-nav").each(function(){$(this).removeClass('active');  });
            $(this).addClass('active');
        });*/









        $("#btn-search-trade-history").click(function () {
            getTradeRecords(recordType,0);
        });
        $('body').on('click', '.btn-view-trans-details', function(){
            var dt = $(this).data('info');
            bootbox.alert({
                title: 'Transaction Details',
                message: dt,
                show: true
            });
        });




        $('body').on('click', '.recall-action', function(){
            var ticket = $(this).data('ticket');
            var transId = $(this).data('transid');
            // console.log('recall');
            //console.log(ticket);

            bootbox.confirm("Are you sure you want to proceed?" , function(result) {
                if (result == true) {
                    $.ajax({
                        type: "POST",
                        url: "/transaction_history/updateWithdrawTransaction",
                        data: {ticket: ticket},
                        dataType: 'json',
                        beforeSend: function () {
                            $('#loader-holder').show();
                            $("tr#" + transId).hide();
                            $("tr#" + transId).css("display", 'none');
                        },
                        success: function (x) {
                            console.log(transId);
                            console.log(x);
                            $('#loader-holder').hide();
                            $("tr#" + transId).hide();
                            $("tr#" + transId).css("display", 'none');
                            $("#modalBonusDelayTitle").html('<?=lang('recall_title')?>');
                            $("div.recall-msg p").html('<?=lang('recall_msg')?>');


                            $('#modalRecallAlert').modal('show');
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#loader-holder').hide();
                            console.log(xhr.status);
                            console.log(thrownError);
                        }
                    });
                }
            });//bootbox
        });


        function openTransectionDetails(cRef,cType,cTrns,cAcc,cAmnt,cPay,cdate) {

            if($(window).width() < 768) {

                $('#openTransectionModal').modal('show');
                $("#modalOPenTransaction").removeAttr('disabled');
                $('.cRef').html(cRef);
                $('.cType').html(cType);
                $('.cTrns').html(cTrns);
                $('.cAcc').html(cAcc);
                $('.cAmnt').html(cAmnt);
                $('.cPay').html(cPay);
                $('.cdate').html(cdate);

            }
        }


// setTimeout(function(){ $(".hist-nav").removeAttr('disabled'); }, 10000);

        function getPendingWD(){
            
         
        $('.pending-transactions').DataTable().destroy();
    
                        
            var tblAccounts = jQuery('.pending-transactions').on('preXhr.dt', function ( e, settings, data ) {
                jQuery('#loader-holder').show();
            }).on('xhr.dt', function ( e, settings, json, xhr ) {
                jQuery('#loader-holder').hide();
            }).DataTable({
                "processing": false,
                "serverSide": true,
                "bFilter": false,
                "bSort": false,
                "ordering": false,
                "searching": false,
                language: {
                    emptyTable: '<?=lang('dta_tbl_01')?>',
                    infoEmpty: '<?=lang('dta_tbl_03')?>',
                    lengthMenu: '<?=lang('dta_tbl_07')?>',
                    search: '<?=lang('dta_tbl_10')?>:',
                    "paginate": {
                        "first": '<?=lang('dta_tbl_12')?>',
                        "last": '<?=lang('dta_tbl_13')?>',
                        "next": '<?=lang('dta_tbl_14')?>',
                        "previous": '<?=lang('dta_tbl_15')?>'
                    },
                },
                "ajax": {
                    "url": "/transaction_history/requestPendingTnx",
                    "type": "POST",
                    "data": function ( d ) {
                        d.tab="Request";
                    }
                }
            });
        }

        function getTransactionHistoryRecords(recordType){
	 $('#loader-holder').show();
        
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
                url: '/my_account/getTransactionHistoryRecords',
                //url: '/partnership_test/getTrades',
                dataType: 'json',
                data: function(d){                  
                    d.recordType = recordType;                   
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
               
                setTimeout(function(){ $('#loader-holder').hide(); }, 1000);
            }
        });

        $('#tbl-transaction-history').DataTable().draw();




        }
		
        function getTradeRecords(recordType, pageNum){


                var data = {
                    recType:recordType,
                    page:pageNum,
                    from: $('#date_from_history').val(),
                    to: $('#date_to_history').val()
                };
            console.log(recordType);
            var container = "table."+recordType+" tbody#result",
                pgCont = "div#"+recordType+"-pagination";
			var ajax_url = "<?= FXPP::ajax_url('')?>";
            $.ajax({
                type: "post",
                url: ajax_url+"get-trades",
                data: 'recType='+recordType+'&page='+pageNum,
                dataType: 'json',
                beforeSend: function () {
                    $('#loader-holder').show();
                },
                success: function(x) {
                    if(x.hasError){
                        $(container).html("<tr><td colspan='7' style='text-align: center;'>Internal Error. Please contact support.</td></tr>");
                    }else{
                        $(container).html(x.result['result']);

                        $('.pagination').each(function () {
                            $(this).html("");
                        });
                        switch (recordType){
                            case 'pending-transactions':
                                break;
                            case 'transaction-history':
                                $('#transaction-history-showing').html(x.result['showing']);
                                $('#transaction-history-pagination').html(x.result['pagination']);
                                break;
                        }
                        var pg = pageNum<=1? 1 : pageNum;

                        $('ul.tab-pagination li.latest-page').each(function(){        $(this).removeClass('active');   });
                        $("ul.tab-pagination").find("[data-ci-pagination-page='" + pg + "']").closest('li').addClass('active');



                    }
                    $('#loader-holder').hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#loader-holder').hide();
                    // console.log(xhr.status);
                    // console.log(thrownError);
                }
            });
        }


    });
    


    function getTnx(type) {
        var tbl = (type == 1) ? 'tbl-pending-transactions' : 'tbl-transaction-history';
        console.log(tbl);
        var requestURL = (type == 1) ? '<?=FXPP::ajax_url('transaction-history/requestPendingTnx')?>' : '<?=FXPP::ajax_url('transaction-history/requestBalanceTnx')?>';
        //  $('#'+ tbl).DataTable().destroy();
        $('#'+ tbl).on('preXhr.dt', function (e, settings, data) {
            $('#' + tbl + ' tbody').html('<div class ="loading_rec" style="text-align:center;"><tr><td colspan="8">Loading records<img src="<?=$this->template->Images()?>loading.gif" /></td></tr></div>');
        }).on('xhr.dt', function (e, settings, json, xhr) {
            $('#' + tbl + ' tbody').html('');


        }).DataTable({
            "bJQueryUI": true,
            "destroy": true,
            "processing": false,
            "serverSide": true,
            "ordering": false,
            "searching": false,
            "language":{
                search:'<?=lang('curtra_s')?>',
                lengthMenu: '<?=lang('dta_tbl_07')?>',
                info: '<?=lang('dta_tbl_02')?>',
                zeroRecords: '<?=lang('dta_tbl_01')?>',
                paginate: {
                    next:       '<?=lang('dta_tbl_14')?>',
                    previous:   '<?=lang('dta_tbl_15')?>'
                }
            },
            "columnDefs": [
                { "orderable": false, "targets": 0 }
            ],
            "order": [],  // not set any order rule for any column.
            "ajax": {
                "url": requestURL,
                "type": "POST",
                "data": function (d) {


                    return $.extend( {}, d, {
                        "type":type,
                    } );
                }
            },
            "drawCallback" : function (oSettings) {

                if(oSettings.fnRecordsDisplay() == 0){
                    $(oSettings.nTableWrapper)
                        .find('.dataTables_paginate, .dataTables_filter, .dataTables_length, .dataTables_info')
                        .hide();
                }else{

                    $(oSettings.nTableWrapper)
                        .find('.dataTables_paginate, .dataTables_filter, .dataTables_length, .dataTables_info')
                        .show();
                }

                setTimeout(function(){ $('#loader-holder').hide(); }, 1000);
            }
        });
    }

function reomveReadOnlyAccess(){

    if(isReadOnlyRemoveFromMWP){ 
         setTimeout(function(){ $(".accessoperationtab").removeAttr('disabled'); }, 1000);
       
    }
}

</script>


