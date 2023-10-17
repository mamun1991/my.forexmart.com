<style>
    @media screen and (max-width: 767px){
        .crTradesMob{   display: none; }
        .crTradesWeb{  display: ;}
        .showDetailsMob,.crTradesWebStyle{  color: #337AB7; }
        .table-responsive{
            border: none !important;
        }
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
        padding: 7px 15px;
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
    div#bal-ops .table>tbody>tr>td, .table>tfoot>tr>td,  .table>thead>tr>td{
        font-size: 11px;
    }
    div#bal-ops .table>tbody>tr>th,.table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
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
    div#bal-ops label.hdr{
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

    #btn-search-trade-history:lang(sa){
        margin-top: unset!important;
    }
    #btn-search-trade-history:lang(cs){
        margin-top: unset!important;
    }
    .label-date-end:lang(sa){
        width: unset!important;
    }
    .label-date-end:lang(bd){
        width: unset!important;
    }
    .label-date-end:lang(bg){
        width: unset!important;
    }
    .label-date-end:lang(cs){
        width: unset!important;
    }
    .label-date-end:lang(es){
        width: unset!important;
    }
    .label-date-end:lang(de){
        width: unset!important;
    }
    .label-date-end:lang(id){
        width: unset!important;
    }
    .label-date-end:lang(my){
        width: unset!important;
    }
    .label-date-end:lang(pl){
        width: unset!important;
    }
    .label-date-end:lang(ru){
        width: unset!important;
    }
	.form-control {
		border: 1px solid #ccc;
	}

</style>
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
<!--<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>-->
<?php $method = $this->router->method; ?>
<?php $class = $this->router->class; ?>
<?php $this->lang->load('datatable');?>
<?= $this->load->ext_view('modal', 'preloader', '', TRUE); ?>


    <h1>
        <?=lang('curtra_03');?>
    </h1>

  <?php if(IPloc::IPOnlyForVenus() || $_SERVER['REMOTE_ADDR']=='49.12.5.139'){ ?>
      Test Browser Session Inactivity Clock <span id="timer1">(0)</span>

  <?php } ?>

    <?php $this->load->view('trading_nav.php');?>


<div class="tab-content acct-cont dddd">
    <?php if($active_sub_tab=='history-of-trades'){ ?>

        <p class="cur-trades-text arabic-cur-trades-text"><?=lang('hot_01');?></p>

        <div>
            <div class="col-md-12" style="margin-bottom: 10px;">
            <div class="row">
				<div class="input-daterange col-md-5">
					<label for="date_from_history" class="control-label left-padding" style="float:left;display:inline-block;"><span class="translate"><?=lang('hot_03');?></span></label>
					<input type="date" id="date_from_history" class="form-control hx-date left-margin" min='2014-01-01'  max='<?php echo date("Y-m-d");?>' name="date_from_history" value="<?php echo date('Y-m-d',strtotime('-1 month'));?>" style="width:96%!important; display:inline-block;">
				</div>
				<div class="input-daterange col-md-5">
					<label for="date_to_history" class="control-label label-date-end left-padding" style="float:left;display:inline-block;"><span class='translate'><?=lang('hot_04');?></span></label>
					<input type="date" id="date_to_history" class="form-control hx-date left-margin" name="date_to_history"  max='<?php echo date("Y-m-d");?>' value="<?php echo date('Y-m-d',strtotime('now'));?>" style="width:96%!important; display:inline-block;">
				</div>
				<div class="input-daterange col-md-2">
					<button id="btn-search-trade-history" type="button"><?=lang('curtra_s');?></button>
				</div>
			</div>
            </div>
        </div>


        <div class="hist-tab-nav">
            <ul>
              <!--  <li><button class="hist-nav active" data-tog="history-of-trades">Cancelled Orders</button></li>-->
<!--                <li><button class="hist-nav" data-tog="balance-operations">Balance Operations</button></li>-->
            </ul>
        </div>


    <div role="tabpanel" class="row tab-pane active history-of-trades" >
        <div class="col-sm-12">
            <p class="cur-trades-text "> </p>
            <div class="row history-form-holder">

                <div class="col-sm-12 col-centered table-responsive">
                    <table id="tbl-history-of-trades-tbl" class="table table-bordered tab-my-acct arabic-part-table arabic-trans-history-table history-of-trades click-table">

                        <thead>
                            <th>#</th>
                            <th><?=lang('curtra_04');?></th>
                            <th><?=lang('curtra_05');?></th>
                            <th><?=lang('curtra_06');?></th>
                            <th><?=lang('curtra_07');?></th>
                            <th><?=lang('curtra_08');?></th>
                            <th><?=lang('curtra_11');?></th>
                            <th><?=lang('curtra_16');?></th>
                            <th><?=lang('curtra_17');?></th>
                            <th><?=lang('curtra_09');?></th>
                            <th><?=lang('curtra_10');?></th>
                            <?php if(IPLoc::VPN_IP_Jenalie()){ ?>
                                <th><?=lang('curtra_swap');?></th>
                            <?php } ?>
                            <th><?=lang('curtra_13');?></th>

                          <?php if(IPLoc::IPOnlyForTq()){ ?>
<!--                              <th>Swaps</th>-->
                        <?php } ?>


                        </thead>
                        <tbody id="result">

                        </tbody>
                    </table>
                </div>
                <div style='text-align: center;' id='showing' class="col-md-12"></div>
                <div style='margin-top: 10px;text-align: center;' id='history-of-trades-pagination' class="pagination"></div>

            </div>
        </div>
    </div>
    <div role="tabpanel" class="row tab-pane balance-operations">
            <div class="col-sm-12">
                <p class="cur-trades-text arabic-cur-trades-text"></p>
                <div class="row history-form-holder">

                    <div class="col-sm-12 col-centered table-responsive" id="bal-ops">
                        <table id="tbl-history-trades" class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table balance-operations">
                            <thead>
                            <tr>
                                <td>#</td>
                                <td><?=lang('curtra_04');?></td>
                                <td><?=lang('hot_25');?></td>
                                <td><?=lang('hot_26');?></td>
                                <td><?=lang('hot_27');?></td>
                                <td><?=lang('hot_28');?></td>
                                <td><?=lang('hot_29');?></td>
                            </tr>
                            </thead>
                            <tbody id="result">

                            </tbody>
                        </table>
                    </div>
                    <div style='text-align: center;' id='showing' class="col-md-12"></div>
                    <div style='margin-top: 10px;text-align: center;' id='balance-operations-pagination' class="pagination"></div>

                </div>
            </div>
    </div>
    <?php }else if($active_sub_tab=='current-trades'){ ?>
    <div role="tabpanel" class="row tab-pane active current-trades">
        <div class="col-sm-12">
<!--            <p class="cur-trades-text arabic-cur-trades-text">--><?//=lang('hot_01');?><!--</p>-->
            <p class="cur-trades-text arabic-cur-trades-text"><?=lang('curtra_curtrd_010');?></p>
            <div class="row history-form-holder">

                <div class="col-sm-12 col-centered table-responsive">
                    <table id="tbl-current-trades" class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table current-trades">
                        
                            
                            
                              <thead>
                                <th>#</th>
                                <th><?=lang('curtra_04');?></th>
                                <th><?=lang('curtra_16');?></th>                                
                                <th><?=lang('curtra_05');?></th>
                                <th><?=lang('curtra_06');?></th>
                                <th><?=lang('curtra_07');?></th>
                                <th><?=lang('curtra_08');?></th>
                                <th><?=lang('curtra_09');?></th>
                               <th><?=lang('curtra_10');?></th>
                                <?php if(IPLoc::VPN_IP_Jenalie()){ ?>
                                    <th><?=lang('curtra_swap');?></th>
                                <?php }else{ ?>
                                    <th><?=lang('curtra_11');?></th>
                                <?php } ?>
                               <th><?=lang('curtra_13');?></th>
                            </thead>
                                                         
                             

                        <tbody id="result">

                        </tbody>
                    </table>
                </div>
                <div style='margin-top: 10px;' id='current-trades-pagination' class="pagination"></div>

            </div>
        </div>
    </div>

    <?php }?>

</div>





<?= $this->load->ext_view('modal', 'PaymentSystemCarousel', '', TRUE); ?>
