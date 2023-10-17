<?php $method = $this->router->method; ?>
<?php $class = $this->router->class; ?>
<style type="text/css">
    .dashboard > thead > tr > th {
        text-align: center;
    }
    .dashboard > tbody > tr > td {
        text-align: center;
    }
    .display-n{
        display:none;
    }
</style>
<?= $this->load->ext_view('modal', 'preloader', '', TRUE); ?>
    <h1>My Accounts</h1>
    <?php $this->load->view('account_nav.php');?>
    <div class="tab-content acct-cont">
        <div role="tabpanel" class="row tab-pane active">
            <div class="col-sm-12">
                <p class="cur-trades-text">
                    View all closed and canceled deals for a particular time period by providing the necessary details below.
                </p>
                <div class="row history-form-holder">
                    <div class="col-sm-12">
                        <h2>Trades history for period</h2>
                    </div>
                    <div class="col-sm-5 col-centered">
                        <form>
                            <div class="form-group">
                                <label for=""><?= lang('hot_03'); ?></label>
                                <input type="text" class="form-control round-0" id="date_start" name="start_date"  placeholder="">
                            </div>
                            <div class="form-group">
                                <label for=""><?= lang('hot_04'); ?></label>
                                <input type="text" class="form-control round-0"  id="date_end" name="start_end" placeholder="">
                            </div>
<!--                            <div class="form-group">-->
<!--                                <label for="">Format Output</label>-->
<!--                                <select class="form-control round-0">-->
<!--                                    <option>Sample</option>-->
<!--                                </select>-->
<!--                            </div>-->
<!--                            <div class="radio">-->
<!--                                <label>-->
<!--                                    <input type="radio" name="optionsRadios" id="" value="">-->
<!--                                    Sort by opening date-->
<!--                                </label>-->
<!--                            </div>-->
<!--                            <div class="radio">-->
<!--                                <label>-->
<!--                                    <input type="radio" name="optionsRadios" id="" value="">-->
<!--                                    Sort by closing date-->
<!--                                </label>-->
<!--                            </div>-->
                            <div class="btn-ok-holder">
                                <a href="javascript:void(0)" class="btnsearch btn-calc hit hitW">Ok</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="cur-trades-tab">
                    <ul>
                        <li><a id="tclose" href="#close" aria-controls="close" role="tab" data-toggle="tab" class="cur-active">Closed Trades</a></li>
                        <?php if(IPLoc::ForexCalc()){ ?>
                        <li><a id="tcancel" href="#cancel" aria-controls="cancel" role="tab" data-toggle="tab">Cancelled Pending Order</a></li>
                        <?php } ?>
                        <li><a id="tbal" href="#bal" aria-controls="bal" role="tab" data-toggle="tab">Balance Operations</a></li>
                    </ul>
                </div>
                <div class="clearfix">
                    <div class="tab-content cur-tab-cont">
                        <div role="tabpanel" class="tab-pane table-responsive active" id="close">
                            <table id="ClosedTrades" name="ClosedTrades" class="table table-striped tab-my-acct">
                                <thead>
                                    <tr>
                                        <th>Ticket</th>
                                        <th>Type</th>
                                        <th>Volume</th>
                                        <th>Symbol</th>
                                        <th>Open Price</th>
                                        <th>S/L</th>
                                        <th>T/P</th>
                                        <th>Close Price</th>
                                        <th>Swaps</th>
                                        <th>Profit</th>
                                    </tr>
                                </thead>
                                <tbody id="closed">

                                </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane table-responsive" id="cancel">
                            <table name="CancelledPendingOrder" class="table table-striped tab-my-acct">
                                <thead>
                                    <tr>
                                        <th>Ticket</th>
                                        <th>Type</th>
                                        <th>Volume</th>
                                        <th>Symbol</th>
                                        <th>Open Price</th>
                                        <th>S/L</th>
                                        <th>T/P</th>
                                        <th>Close Price</th>
                                        <th>Swaps</th>
                                        <th>Profit</th>
                                    </tr>
                                </thead>
                                <tbody id="cancel">
                                    <tr>
                                        <td colspan="10" align="center">You currently have no open positions.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane table-responsive" id="bal">
                            <table id="BalanceOperation" name="BalanceOperation" class="table table-striped tab-my-acct " >
                                <thead>
                                    <tr>
                                        <th>Ticket</th>
                                        <th>Type</th>
                                        <th>Volume</th>
                                        <th>Symbol</th>
                                        <th>Open Price</th>
                                        <th>S/L</th>
                                        <th>T/P</th>
                                        <th>Close Price</th>
                                        <th>Swaps</th>
                                        <th>Profit</th>
                                    </tr>
                                </thead>
                                <tbody id="showoff">
                                </tbody>
                            </table>

                            <table id="BalanceOperationBonus"  class="table table-striped tab-my-acct display-n" >
                                <thead>
                                    <tr>
                                        <th colspan="6">Bonus</th>
                                    </tr>
                                    <tr>
                                        <th>Ticket</th>
                                        <th>Type of Fund</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody id="balancebonus">
                                </tbody>
                            </table>

                            <table id="BalanceOperationDeposit"  class="table table-striped tab-my-acct display-n">
                                <thead>
                                <tr>
                                    <th colspan="6">Deposit</th>
                                </tr>
                                <tr>
                                    <th>Ticket</th>
                                    <th>Type of Fund</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Operation</th>
                                </tr>
                                </thead>
                                <tbody id="balancedeposit">
                                </tbody>
                            </table>

                            <table id="BalanceOperationWithdraw" class="table table-striped tab-my-acct display-n">
                                <thead>
                                    <tr>
                                        <th colspan="6">Withdraw</th>
                                    </tr>
                                    <tr>
                                        <th>Ticket</th>
                                        <th>Type of Fund</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody id="balancewithdraw">
                                </tbody>
                            </table>


                            <table id="BalanceOperationTransfer" class="table table-striped tab-my-acct display-n">
                                <thead>
                                <tr>
                                    <th colspan="6">Transfer</th>
                                </tr>
                                <tr>
                                    <th>Ticket</th>
                                    <th>Type of Fund</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Operation</th>
                                </tr>
                                </thead>
                                <tbody id="balancetransfer">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    var pblc = [];
    var prvt = [];
    var site_url="<?=ajax_url('')?>";
    pblc['request']=null;
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();

    var output = d.getFullYear() + '/' +
        (day<10 ? '0' : '') + day + '/'+
        (month<10 ? '0' : '') + month;

    $("#date_end").val(output);

    $(document).ready(function(){

        $("#tclose").click(function(){
            $("#tcancel").removeClass("cur-active");
            $("#tbal").removeClass("cur-active");
            $("#tclose").addClass("cur-active");
        });
        $("#tbal").click(function(){
            $("#tcancel").removeClass("cur-active");
            $("#tclose").removeClass("cur-active");
            $("#tbal").addClass("cur-active");
        });
        $("#tcancel").click(function(){
            $("#tclose").removeClass("cur-active");
            $("#tbal").removeClass("cur-active");
            $("#tcancel").addClass("cur-active");
        });

        $("#date_start").datetimepicker({
            format: "YYYY/DD/MM",
            disabledDates: []
        });
        $("#date_end").datetimepicker({
            format: "YYYY/DD/MM",
            disabledDates: []
        });

        $('#BalanceOperation').DataTable();
        $('#ClosedTrades').DataTable();

    });
    $(document).on("click", ".btnsearch", function () {
        $('#loader-holder').show();
        var prvt = [];
        prvt["data"] = {
            from: $('#date_start').val(),
            to: $('#date_end').val()
        };
        pblc['request'] = $.ajax({
            dataType: 'json',
            url: site_url+"accounts/HistoryOfTrades",
            method: 'POST',
            data: prvt["data"]
        });

        pblc['request'].done(function( data ) {

            if (data.bonus==false && data.withdraw==false && data.deposit==false ){
                $('#BalanceOperationBonus').removeClass('display-n');
                $('#BalanceOperation').DataTable();
            }else{
                $('#BalanceOperation').DataTable().destroy();
                $('#BalanceOperation').removeClass('display-n');
                $('#BalanceOperation').addClass('display-n');
            }
            if(data.bonus==true){
                $('#BalanceOperationBonus').DataTable().destroy();
                $('#BalanceOperationBonus').removeClass('display-n');
                $('tbody#balancebonus').html(data.BalOpe_bonus);
                $('#BalanceOperationBonus').DataTable();
            }else{
                $('#BalanceOperationBonus').DataTable().destroy();
                $('#BalanceOperationBonus').removeClass('display-n');
                $('#BalanceOperationBonus').addClass('display-n');
            }

            if(data.deposit==true){
                $('#BalanceOperationDeposit').DataTable().destroy();
                $('#BalanceOperationDeposit').removeClass('display-n');
                $('tbody#balancedeposit').html(data.BalOpe_deposit);
                $('#BalanceOperationDeposit').DataTable();
            }else{
                $('#BalanceOperationDeposit').DataTable().destroy();
                $('#BalanceOperationDeposit').removeClass('display-n');
                $('#BalanceOperationDeposit').addClass('display-n');
            }

            if(data.withdraw==true){
                $('#BalanceOperationWithdraw').DataTable().destroy();
                $('#BalanceOperationWithdraw').removeClass('display-n');
                $('tbody#balancewithdraw').html(data.BalOpe_withdraw);
                $('#BalanceOperationWithdraw').DataTable();
            }else{
                $('#BalanceOperationWithdraw').DataTable().destroy();
                $('#BalanceOperationWithdraw').removeClass('display-n');
                $('#BalanceOperationWithdraw').addClass('display-n');
            }

            if(data.transfer==true){
                $('#BalanceOperationTransfer').DataTable().destroy();
                $('#BalanceOperationTransfer').removeClass('display-n');
                $('tbody#balancetransfer').html(data.BalOpe_transfer);
                $('#BalanceOperationTransfer').DataTable();
            }else{
                $('#BalanceOperationTransfer').DataTable().destroy();
                $('#BalanceOperationTransfer').removeClass('display-n');
                $('#BalanceOperationTransfer').addClass('display-n');
            }


            var table1 =  $('#ClosedTrades').DataTable();
            table1.destroy();
            $('#closed').html(data.Closed);
            $('#ClosedTrades').DataTable();

            $('#loader-holder').hide();
        });

        pblc['request'].fail(function( jqXHR, textStatus ) {
            $('#loader-holder').hide();
        });

        pblc['request'].always(function( jqXHR, textStatus ) {
            $('#loader-holder').hide();
        });

    });
</script>

<?= $this->load->ext_view('modal', 'PaymentSystemCarousel', '', TRUE); ?>
