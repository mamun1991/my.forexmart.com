<?php $this->lang->load('datatable');?>
<style type="text/css">
@media screen and (max-width: 370px) {
    .cur-trades-tab ul li {
        float: none!important;
    }
}
.modal-open {
    overflow: scroll;
}
th.sorting_asc::after,
th.sorting_desc::after {
   content:"" !important;
}
.sorting_asc {
    content: ""!important;
    padding-right: 0px!important;
    cursor: auto!important;
}
.btnInvestment {
    text-decoration: none;
    background: #2988ca!important;
    color: #fff!important;
    border-radius: 3px;
    padding: 5px !important;
    margin-bottom: 5px!important;
    width: 100%;
    opacity: 0.85;
    text-shadow: 0 0 3px #0b3e61;
}
.btnInvestment:hover, .btnInvestment:focus{
    text-decoration: none!important;
    opacity: 1;
}
</style>
<div class="pamm-onclick-page destination-class" id="pamm-div-trader">
    <?=$nav;?>
    <div id="my-tab-content" class="tab-content pamm-tab-content">


        <div class="modal fade" id="AcceptInvestmentModal" tabindex="-1" role="dialog" aria-labelledby="">
            <div class="modal-dialog crm-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title crm-modal-title">Accept Investment</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                        Do you accept investment ? 
                                        <input type="hidden" class="form-control" id="accountid">
                                        <input type="hidden" class="form-control" id="investmentamount">
                                        <input type="hidden" class="form-control" id="investmentid">
                                        <input type="hidden" class="form-control" id="ownerid">
                                        <input type="hidden" class="form-control" id="profit">
                                        <input type="hidden" class="form-control" id="return">
                                        <input type="hidden" class="form-control" id="share">
                                        <input type="hidden" class="form-control" id="status">
                                        <input type="hidden" class="form-control" id="statusdescription">
                                        <input type="hidden" class="form-control" id="date">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btns-plain" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btns btns-info show-loader" id="AcceptInvestment">Ok</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" id="RefundInvestmentModalTrader" tabindex="-1" role="dialog" aria-labelledby="">
            <div class="modal-dialog crm-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title crm-modal-title" id="RefundInvestmentModalTraderH">Refund Investment</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                                        <p id="RefundInvestmentModalTraderP"> Are you sure you want to refund investment ? </p>
                                        <input type="hidden" class="form-control" id="RefundisReturnedByTrader">
                                        <input type="hidden" class="form-control" id="Refundaccountid">
                                        <input type="hidden" class="form-control" id="Refundinvestmentamount">
                                        <input type="hidden" class="form-control" id="Refundinvestmentid">
                                        <input type="hidden" class="form-control" id="Refundownerid">
                                        <input type="hidden" class="form-control" id="Refundprofit">
                                        <input type="hidden" class="form-control" id="Refundreturn">
                                        <input type="hidden" class="form-control" id="Refundshare">
                                        <input type="hidden" class="form-control" id="Refundstatus">
                                        <input type="hidden" class="form-control" id="Refundstatusdescription">
                                        <input type="hidden" class="form-control" id="Refunddate">
                                        <input type="hidden" class="form-control" id="typeofinvestment">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btns-plain" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btns btns-info show-loader" id="AcceptRefundTrader">Ok</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" id="RolloverInvestmentModal" tabindex="-1" role="dialog" aria-labelledby="">
            <div class="modal-dialog crm-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title crm-modal-title">Withdraw Investment</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                                        Are you sure you want to Withdraw Investment ? 
                                        <input type="hidden" class="form-control" id="rolloverTraderInvestmentId">
                                        <input type="hidden" class="form-control" id="rolloverTraderPammTrader">
                                        <!-- <input type="hidden" class="form-control" id="rolloverTraderbrokerId"> -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btns-plain" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btns btns-info show-loader" id="traderRollover">Ok</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

       <div class="modal fade" id="RolloverInvestmentModalInvestor" tabindex="-1" role="dialog" aria-labelledby="">
            <div class="modal-dialog crm-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title crm-modal-title">Refund Investment</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                                        Are you sure you want to Refund Investment ? 
                                        <input type="hidden" class="form-control" id="rolloverInvestorInvestmentId">
                                        <input type="hidden" class="form-control" id="rolloverInvestoriPammInvestor">
                                        <!-- <input type="hidden" class="form-control" id="rolloverTraderbrokerId"> -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btns-plain" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btns btns-info show-loader" id="investorRollover">Ok</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

  

        <div id="inv_prompt_success" class="alert alert-success " style="display: none !important">
            <strong>Investment Message:</strong>
            <label class="showmessage"></label>
        </div>

            <div class="pamm-investment-container">

                <div class="pamm-investment-parent">
                    <h5>
                        Current Investments
                    </h5>
                    <div class="pamm-investment-table">
                        <div class="pamm-investment-table">
                            <div class="table-responsive">
                                <table id="CurrentInvestments" class="table table-stripped  trades-table" style="width:  100%;">
                                    <thead>
                                        <th id='accountTh' style=" width: 7%;"><?php echo ($accountType == 'trader') ? 'Account' : 'Account Owner';  ?></th>
                                        <th style="width: 7%;  text-align: center; ">Share</th>
                                        <th style="width: 5%;  text-align: center; ">Investment amount</th>
                                        <th style="width: 11%; text-align: center;">Return</th>
                                        <th style="width: 10%; text-align: center;">Profit</th>
                                        <th style="width: 31%; text-align: center;">Time</th>
                                        <th style="width: 11%; text-align: center;">Status</th>
                                        <th style="width: 2%;  text-align: center;">Operations</th>
                                    </thead>
                                    <tbody>
                                       <!-- $current_investment -->
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                    </div>
                </div>



                <div class="pamm-investment-secondary">

                    <div class="cur-trades-tab">
                        <ul>
                            <li>
                                <a id="curtab1" href="#cur1" aria-controls="cur" role="tab" data-toggle="tab" class="cu-active ctrades">
                                    Past Investments
                                </a>
                            </li>
                            <?php if(isset($trader_registration) and $trader_registration==True){?>
                                <li><a id="pendtab1" href="#pend1" aria-controls="pend" role="tab" data-toggle="tab"  class=" potrades">
                                        Traders activity log
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>

                    <div class="clearfix"></div>

                    <div class="tab-content cur-tab-cont">

                        <div role="tabpanel" class="tab-pane table-responsive active" id="cur1">
                            <div class="pamm-investment-table">
                                <div class="table-responsive">
                                    <table id="PastInvestments" class="table table-stripped  trades-table" style="width:  100%;">
                                        <thead>
                                            <th style=" width: 7%; text-align: center;"><?php echo ($accountType == 'trader') ? 'Account' : 'Account Owner';  ?></th>
                                            <th style="width: 6%;  text-align: center;">Share</th>
                                            <th style="width: 5%;  text-align: center;">Investment amount</th>
                                            <th style="width: 11%; text-align: center;">Return</th>
                                            <th style="width: 10%; text-align: center;">Profit</th>
                                            <th style="width: 23%; text-align: center;">Time</th>
                                            <th style="width: 13%; text-align: center;">Status</th>
                                            <th style="width: 2%;  text-align: center;">Operations</th>
                                        </thead>
                                        <tbody style="">
                                         <!-- $past_investment -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <?php if(isset($trader_registration) and $trader_registration==True){ ?>
                            <div role="tabpanel" class="tab-pane table-responsive" id="pend1">
                                <div class="pamm-investment-table">
                                    <div class="table-responsive">
                                        <table id="TraderLogs"  class="table table-stripped  trades-table">
                                            <thead>
                                                <th>Amount</th>
                                                <th>Time</th>
                                                <th>Share before:</th>
                                                <th>Share after</th>
                                                <th>Description:</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="5" class="txt-L">N/A</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="txt-L">The total amount commission received by the PAMM is : 0.00 USD</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="txt-L">The total amount of agent commission paid by the PAMM trader is 0.00 USD</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="txt-L">The net profit of the PAMM trader excluding agent commission is 0.00 USD</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        <?php } ?>
                    </div>

<!--                    <div class="pamm-investment-table">-->
<!--                        <div class="table-responsive">-->
<!--                        </div>-->
<!--                    </div>-->
                </div>

            </div>



    </div>
</div>
<script type="text/javascript">

    $(document).on("click", "#btnDecline", function () {
        
    });

    $(document).on("click", "#btnAccept", function () {

    });

   

  $(document).on("click", "#btnAccept", function () {
    $("#accountid").val($(this).data('accountid'));
    $("#investmentamount").val($(this).data('investmentamount'));
    $("#investmentid").val($(this).data('investmentid'));
    $("#ownerid").val($(this).data('ownerid'));
    $("#profit").val($(this).data('profit'));
    $("#return").val($(this).data('return'));
    $("#share").val($(this).data('share'));
    $("#status").val($(this).data('status'));
    $("#statusdescription").val($(this).data('statusdescription'));
    $("#date").val($(this).data('date'));
  });

    $(document).on("click", ".btnWithdrawInvestment", function () {
        $("#RefundisReturnedByTrader").val($(this).data('isreturnedbytrader'));
        $("#Refundaccountid").val($(this).data('accountid'));
        $("#Refundinvestmentamount").val($(this).data('investmentamount'));
        $("#Refundinvestmentid").val($(this).data('investmentid'));
        $("#Refundownerid").val($(this).data('ownerid'));
        $("#Refundprofit").val($(this).data('profit'));
        $("#Refundreturn").val($(this).data('return'));
        $("#Refundshare").val($(this).data('share'));
        $("#Refundstatus").val($(this).data('status'));
        $("#Refundstatusdescription").val($(this).data('statusdescription'));
        $("#Refunddate").val($(this).data('date'));
        $("#typeofinvestment").val($(this).data('typeofinvestment'));

        console.log($(this).data('typeofinvestment'));
        switch ($(this).data('typeofinvestment')) {
            case 'Refund Investment':
                $('#RefundInvestmentModalTraderH').text('Refund Investment');
                $('#RefundInvestmentModalTraderP').text('Are you sure you want to refund investment ?');
                break;
            case 'Decline':
                $('#RefundInvestmentModalTraderH').text('Decline Investment');
                $('#RefundInvestmentModalTraderP').text('Are you sure you want to decline investment ?');
                break;
            case 'Withdraw Investment':
                $('#RefundInvestmentModalTraderH').text('Withdraw Investment');
                $('#RefundInvestmentModalTraderP').text('Are you sure you want to withdraw investment ?');
                break;
        }



        console.log($(this).data('isreturnedbytrader'));
    });

    $(document).on("click", ".btnWithdrawInvestmentInst", function () {
        // $("#RefundisReturnedByTrader").val($(this).data('isreturnedbytrader'));
        // $("#Refundaccountid").val($(this).data('accountid'));
        // $("#Refundinvestmentamount").val($(this).data('investmentamount'));
        // $("#Refundinvestmentid").val($(this).data('investmentid'));
        // $("#Refundownerid").val($(this).data('ownerid'));
        // $("#Refundprofit").val($(this).data('profit'));
        // $("#Refundreturn").val($(this).data('return'));
        // $("#Refundshare").val($(this).data('share'));
        // $("#Refundstatus").val($(this).data('status'));
        // $("#Refundstatusdescription").val($(this).data('statusdescription'));
        // $("#Refunddate").val($(this).data('date'));
        console.log($(this).data());


        var form1 = new FormData();
        $('.loader-holder').show();
                form1.append('isReturnedByTrader', $(this).data('isreturnedbytrader') );
                form1.append('AccountBrokerId', 0);
                form1.append('AccountId', $(this).data('accountid') );
                form1.append('InvestmentAmount', $(this).data('investmentamount') );
                form1.append('InvestmentId', $(this).data('investmentid') );
                form1.append('OwnerBrokerId', 0);
                form1.append('OwnerId', $(this).data('ownerid') );
                form1.append('Profit', $(this).data('profit') );
                form1.append('Return', $(this).data('return') );
                form1.append('Share', $(this).data('share') );
                form1.append('Status', $(this).data('status') );
                form1.append('StatusDescription', $(this).data('statusdescription') );
                form1.append('Time', $(this).data('date') );
        var msg ='';
        switch ($(this).data('typeofinvestment') ) {
            case 'Refund Investment':
                msg = 'Refund';
                break;
            case 'Decline':
                msg = 'Decline';
                break;
            case 'Withdraw Investment':
                msg = 'Withdraw';
                break;
        }
        $.ajax({
            type: 'POST',
            url: 'returnInvestmentPost',
            data: form1,
            dataType: 'json',
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false        // To send DOMDocument or non processed data file it is set to false
        }).done(function (response) {
            console.log(response);
                $(".modal").hide();
                $('.loader-holder').hide();
                $("#inv_prompt_success").attr("style", "display: block !important");
            if (response.Message == 'RET_OK') {
                $('.showmessage').html(msg + ' Success');
            }else{
                $('.showmessage').html(msg + ' Failed');
            }
            currentAndPastInvestment(true,false);
        });

    });

    $(document).on("click", "#btnRolloverTrader", function () {
        $("#rolloverTraderInvestmentId").val($(this).data('investmentid'));
        $("#rolloverTraderPammTrader").val($(this).data('ipammtrader'));
    });

    $(document).on("click", "#btnRolloverInvestor", function () {
        $("#rolloverInvestorInvestmentId").val($(this).data('investmentid'));
        $("#rolloverInvestoriPammInvestor").val($(this).data('ipamminvestor'));
    });

var base_url = "<?php echo base_url();?>";

  $(document).on("click", "#AcceptInvestment", function () {
        var form1 = new FormData();
        $('.loader-holder').show();
                form1.append('AccountBrokerId', 0);
                form1.append('AccountId', $("#accountid").val());
                form1.append('InvestmentAmount', $("#investmentamount").val());
                form1.append('InvestmentId', $("#investmentid").val());
                form1.append('OwnerBrokerId', 0);
                form1.append('OwnerId', $("#ownerid").val());
                form1.append('Profit', $("#profit").val());
                form1.append('Return', $("#return").val());
                form1.append('Share', $("#share").val());
                form1.append('Status', $("#status").val());
                form1.append('StatusDescription', $("#statusdescription").val());
                form1.append('Time', $("#date").val());
        $.ajax({
            type: 'POST',
            url: 'agreeInvestmentPost',
            data: form1,
            dataType: 'json',
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false        // To send DOMDocument or non processed data file it is set to false
        }).done(function (response) {
            console.log(response);
                $("#AcceptInvestmentModal").hide();
                $('.loader-holder').hide();
                $("#inv_prompt_success").attr("style", "display: block !important");
            if (response.Message == 'RET_OK') {
                $('.showmessage').html('Accepting Success');
            }else{
                $('.showmessage').html('Accepting Failed');
            }
            currentAndPastInvestment(true,false);
        });
  });

    $(document).on("click", "#traderRollover", function () {
        var form1 = new FormData();
        $('.loader-holder').show();
                form1.append('investmentId', $("#rolloverTraderInvestmentId").val());
                form1.append('iPammTrader', $("#rolloverTraderiPammTrader").val());
        $.ajax({
            type: 'POST',
            url: 'rollOverByTraderPost',
            data: form1,
            dataType: 'json',
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false        // To send DOMDocument or non processed data file it is set to false
        }).done(function (response) {
            console.log(response);
                $("#RefundInvestmentModalTrader").hide();
                $('.loader-holder').hide();
                $("#inv_prompt_success").attr("style", "display: block !important");
            if (response.Message == 'RET_OK') {
                $('.showmessage').html('Rollover Success');
            }else{
                $('.showmessage').html('Rollover Failed');
            }
            currentAndPastInvestment(true,false);
        });
  });

    $(document).on("click", "#investorRollover", function () {
        var form1 = new FormData();
        $('.loader-holder').show();
                form1.append('investmentId', $("#rolloverInvestorInvestmentId").val());
                form1.append('iPammInvestor', $("#rolloverInvestoriPammInvestor").val());
        $.ajax({
            type: 'POST',
            url: 'rollOverByInvestorPost',
            data: form1,
            dataType: 'json',
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false        // To send DOMDocument or non processed data file it is set to false
        }).done(function (response) {
            console.log(form1);
            console.log(response);
                $("#RefundInvestmentModalTrader").hide();
                $('.loader-holder').hide();
                $("#inv_prompt_success").attr("style", "display: block !important");

            if (response.Message == 'RET_OK') {
                $('.showmessage').html('Rollover Success');
            }else{
                $('.showmessage').html('Rollover Failed');
            }
            
            currentAndPastInvestment(true,false);
        });
  });


  $(document).on("click", "#AcceptRefundTrader", function () {
        var form1 = new FormData();
        $('.loader-holder').show();
                form1.append('isReturnedByTrader', $("#RefundisReturnedByTrader").val());
                form1.append('AccountBrokerId', 0);
                form1.append('AccountId', $("#Refundaccountid").val());
                form1.append('InvestmentAmount', $("#Refundinvestmentamount").val());
                form1.append('InvestmentId', $("#Refundinvestmentid").val());
                form1.append('OwnerBrokerId', 0);
                form1.append('OwnerId', $("#Refundownerid").val());
                form1.append('Profit', $("#Refundprofit").val());
                form1.append('Return', $("#Refundreturn").val());
                form1.append('Share', $("#Refundshare").val());
                form1.append('Status', $("#Refundstatus").val());
                form1.append('StatusDescription', $("#Refundstatusdescription").val());
                form1.append('Time', $("#Refunddate").val());
        var msg ='';
        switch ($("#typeofinvestment").val()) {
            case 'Refund Investment':
                msg = 'Refund';
                break;
            case 'Decline':
                msg = 'Decline';
                break;
            case 'Withdraw Investment':
                msg = 'Withdraw';
                break;
        }

        $.ajax({
            type: 'POST',
            url: 'returnInvestmentPost',
            data: form1,
            dataType: 'json',
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false        // To send DOMDocument or non processed data file it is set to false
        }).done(function (response) {
            console.log(response);
                $(".modal").hide();
                $('.loader-holder').hide();
                $("#inv_prompt_success").attr("style", "display: block !important");
            if (response.Message == 'RET_OK') {
                $('.showmessage').html(msg + ' Success');
            }else{
                $('.showmessage').html(msg + ' Failed');
            }
            currentAndPastInvestment(true,false);
        });
  });

    $(document).ready(function(){
        currentAndPastInvestment(true,true);
    });

    function currentAndPastInvestment(getTradersCurrentInvestment,getTradersPastInvestment){
        $('.loader-holder').show();
        var form1 = new FormData();
        form1.append('getTradersCurrentInvestment',getTradersCurrentInvestment);
        form1.append('getTradersPastInvestment',getTradersPastInvestment);
        $.ajax({
            type: 'POST',
            url: 'getCurrentInvestment',
            data: form1,
            dataType: 'json',
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false        // To send DOMDocument or non processed data file it is set to false
        }).done(function (response) {
            console.log(response);
            $('.loader-holder').hide();
             $(".modal").hide();
            var table = $('#CurrentInvestments').DataTable();
            table.clear().draw();

            $('#CurrentInvestments').DataTable({
                "data": response.getTradersCurrentInvestment.table,
                "destroy": true,
                "bInfo": false,
                "bLengthChange": false,
                "paging":   false,
                "ordering": false,
                "columns": [
                    { "data": "AccountId" },
                    { "data": "Share" },
                    { "data": "InvestmentAmount" },
                    { "data": "Return" },
                    { "data": "Profit" },
                    { "data": "Time" },
                    { "data": "StatusDescription" },
                    { "data": "Operations" }
                ]
            });

            $("#CurrentInvestments").append( response.getTradersCurrentInvestment.total_investments);
            $("#CurrentInvestments").append( response.getTradersCurrentInvestment.total_return     );
            $("#CurrentInvestments").append( response.getTradersCurrentInvestment.total_profit     );

            $('#PastInvestments').DataTable({
                "data": response.getTradersPastInvestment,
                "destroy": true,
                "bInfo": false,
                "bLengthChange": false,
                "paging":   true,
                "ordering": false,
                "columns": [
                    { "data": "AccountId" },
                    { "data": "Share" },
                    { "data": "InvestmentAmount" },
                    { "data": "Return" },
                    { "data": "Profit" },
                    { "data": "Time" },
                    { "data": "StatusDescription" },
                    { "data": "Operations" }
                ]
            });

        });
    }



  
</script>