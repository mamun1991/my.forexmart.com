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
        border-bottom: 1px solid #ddd!important;
    }
    .control-label, .input-daterange{
        padding: 0px;
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
    .tab-content>.tab-pane{
        margin-top: 30px;
    }
</style>
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
<!--<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>-->
<?php $method = $this->router->method; ?>
<?php $class = $this->router->class; ?>
<?php $this->lang->load('datatable');?>
<?= $this->load->ext_view('modal', 'preloader', '', TRUE); ?>
<div id="exTab" class="col-lg-12 col-md-12 int-main-cont">
    <div class="section">

        <div class="acct-tab-holder">
            <ul role="tablist" class="main-tab">
				<li>
                    <a  href="<?=FXPP::my_url('copytrade')?>" id = "tab1"><?= lang('sb_li_12'); ?></a>
                </li>
  
                <li>
                    <a href="<?=FXPP::my_url('copytrade/my_subscription')?>" id = "tab2" ><?= lang('trd_74'); ?></a>
                </li>
                
         
                    
                <li class="active">
                    <a href="<?=FXPP::my_url('copytrade/rollover-commission')?>" id = "tab6" ><?= lang('trd_277'); ?></a>
                </li>


                <?php if(FXPP::getCopytradeType() == 1){ ?>
                <li>
                    <a href="<?=FXPP::my_url('copytrade/my_project')?>" id = "tab3" ><?= lang('trd_75'); ?></a>
                </li>
                <?php } ?>
                <li>
                    <a  href="<?=FXPP::my_url('copytrade/profile')?>" id = "tab4" ><?= lang('trd_76'); ?></a>
                </li>
                <li>
                    <a  href="<?=FXPP::my_url('copytrade/recommended-accounts')?>" id = "tab5" ><?= lang('trd_77'); ?></a>
                </li>
                <div class="clearfix"></div>
        </div>
<div class="tab-content acct-cont">
   

        <div class="hist-tab-nav">
            <ul>
                <li><button class="hist-nav active" data-tog="received-commission">Received Commission</button></li>
                <li><button class="hist-nav" data-tog="paid-commission">Paid Commission</button></li>
            </ul>
        </div>


        <div role="tabpanel" class="row tab-pane active received-commission" >
            <div class="col-sm-12">
                <p class="cur-trades-text arabic-cur-trades-text"></p>
                <div class="row history-form-holder">
                    <div class="col-sm-12 col-centered">
                        <table id="tbl-receive" class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table received-commission">
                            <thead style=" font-weight: bold; ">
                            <tr>
                               
                                <td>Ticket</td>
                                <td>Process Date</td>
                                <td>From Investor</td>
                                <td>Amount</td>
                                <td>Comment</td>
                                <td>From Connection</td>
                            </tr>
                            </thead>
                            <tbody id="result"></tbody>
                        </table>
                    </div>
                  
                </div>
            </div>
        </div>
        <div role="tabpanel" class="row tab-pane paid-commission">
            <div class="col-sm-12">
                <p class="cur-trades-text arabic-cur-trades-text"></p>
                 <div class="row history-form-holder">

                    <div class="col-sm-12 col-centered" id="trans-history">
                        <table id="tbl-paid" class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table paid-commission">
                            <thead style=" font-weight: bold; ">
                            <tr>
                               <td>Ticket</td>
                                <td>Process Date</td>
                                <td>To Trader</td>
                                <td>Amount</td>
                                <td>Comment</td>
                                <td>From Connection</td>
                            </tr>
                            </thead>
                            <tbody id="result">

                            </tbody>
                        </table>
                    </div>
                  
                </div>
            </div>
        </div>


</div>


<script>

    $(document).ready(function () {

        getTnx(1);

        $('.hist-nav').click(function () {
            var navType = $(this).data('tog');
            console.log(navType);

            if(navType == 'received-commission'){
                getTnx(1);
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

    });
     
    function getTnx(type) {
        var tbl = (type == 1) ? 'tbl-receive' : 'tbl-paid';
        console.log(tbl);
        var requestURL =  '/copytrade/getCommissionOpt';
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

    </script>



