
<style>
   

    @media screen and (max-width: 767px){
        .crTradesMob{
            display: none;
        }
        .crTradesWeb{
            display: ;
        }
        .showDetailsMob,.crTradesWebStyle{
            color: #337AB7;
        }


    }

    @media screen and (min-width: 767px){

       
        .crTradesWeb{
            display:none ;
        }
    }


    
@media only screen and (min-width: 768px){
  #ClosedTrades thead tr th{padding-right: 25px !important;}
  
}    
    

    
</style>




<?php $method = $this->router->method; ?>
<?php $class = $this->router->class; ?>
<?php $this->lang->load('datatable');?>
<?= $this->load->ext_view('modal', 'preloader', '', TRUE); ?>

<script>
    $("#date_start").attr("disabled",false);
    $("#date_end").attr("disabled",false);
</script>

<?php if(IPLoc::IPOnlyForVenus()){ ?>
    <h1>
        My Trading
    </h1>
<?php $this->load->view('trading_nav.php');?>

<?php }else{ ?>

    <h1>
        <?=lang('hot_00');?>
    </h1>

    <?php $this->load->view('account_nav.php');?>
<?php } ?>

<div class="tab-content acct-cont">
    <div role="tabpanel" class="row tab-pane active">
        <div class="col-sm-12">
            <p class="cur-trades-text arabic-cur-trades-text">
                <?=lang('hot_01');?>
            </p>
            <div class="row history-form-holder">
                <div class="col-sm-12">
                    <h2>
                        <?=lang('hot_02');?>
                    </h2>
                </div>
                <div class="col-sm-5 col-centered">
                    <form>
                        <div class="form-group arabic-form-group-container">
                            <label for="">
                                <?=lang('hot_03');?>
                            </label>
                            <input  type="text" class="form-control round-0" id="date_start" name="start_date"  placeholder="">
                        </div>
                        <div class="form-group arabic-form-group-container">
                            <label for="">
                                <?=lang('hot_04');?>
                            </label>
                            <input type="text" class="form-control round-0"  id="date_end" name="start_end" placeholder="">
                        </div>
                        <div class="btn-ok-holder arabic-btn-ok-holder">
                            <a href="javascript:void(0)" class="btnsearch btn-calc hit hitW">
                                <?=lang('hot_05');?>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="cur-trades-tab arabic-cur-trades-tab arabic-my-account-trades-tab">
                <ul>
                    <li><a id="tclose" href="#close" aria-controls="close" role="tab" data-toggle="tab" class="cur-active">
                            <?=lang('hot_06');?>
                        </a></li>
                    <?php if(IPLoc::ForexCalc()){ ?>
                        <li><a id="tcancel" href="#cancel" aria-controls="cancel" role="tab" data-toggle="tab">
                                <?=lang('hot_07');?>
                            </a></li>
                    <?php } ?>
                    <li><a id="tbal" href="#bal" aria-controls="bal" role="tab" data-toggle="tab">
                            <?=lang('hot_08');?>
                        </a></li>
                </ul>
            </div>





            <div class="clearfix">
                <div class="tab-content cur-tab-cont">
                    <div role="tabpanel" class="tab-pane table-responsive active" id="close">
                        <table id="ClosedTrades" name="ClosedTrades" class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table">
                            <thead>
                            <tr>
                                <th>
                                    <?=lang('hot_09');?>
                                </th>
                                <th class="typeclosetradeth">
                                    <?=lang('hot_10');?>
                                </th>
                                <th>
                                    <?=lang('hot_11');?>
                                </th>

                                <th class="crTradesMob">
                                    <?=lang('hot_12');?>
                                </th>

                                <th class="crTradesMob">
                                    <?=lang('hot_13');?>
                                </th>
                                <th class="crTradesMob">
                                    <?=lang('hot_14');?>
                                </th>
                                <th class="crTradesMob">
                                    <?=lang('hot_15');?>
                                </th>
                                <th class="crTradesMob">
                                    <?=lang('hot_16');?>
                                </th>
                                <th class="crTradesMob">
                                    <?=lang('hot_17');?>
                                </th>
                                <th class="crTradesMob">
                                    <?=lang('hot_18');?>
                                </th>

                                <th class="crTradesWeb">
                                    <?='Action';?>
                                </th>





                            </tr>
                            </thead>
                            <tbody id="closed">

                            </tbody>
                        </table>
                    </div>







                    <div role="tabpanel" class="tab-pane table-responsive" id="cancel">
                        <table name="CancelledPendingOrder" id="CancelledPendingOrder" class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table">
                            <thead>
                            <tr>

                                <th>
                                    <?=lang('hot_09');?>
                                </th>

                                <th>
                                    <?=lang('hot_10');?>
                                </th>

                                <th>
                                    <?=lang('hot_11');?>
                                </th>

                                <th>
                                    <?=lang('hot_12');?>
                                </th>



                                <th>
                                    <?=lang('hot_13');?>
                                </th>

                                <th>
                                    <?=lang('hot_14');?>
                                </th>

                                <th>
                                    <?=lang('hot_15');?>
                                </th>

                                <th>
                                    <?=lang('hot_16');?>
                                </th>

                                <th>
                                    <?=lang('hot_17');?>
                                </th>

                                <th>
                                    <?=lang('hot_18');?>
                                </th>
                            </tr>
                            </thead>
                            <tbody id="cancel_pen_order">
                            <tr>
                                <td colspan="10" align="center">
                                    <?=lang('hot_19');?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>






                    <div role="tabpanel" class="tab-pane table-responsive" id="bal">
                        <table class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table " id="BalanceOperation" name="BalanceOperation" >
                            <thead>
                            <tr>
                                <th>
                                    <?=lang('hot_09');?>
                                </th>
                                <th>
                                    <?=lang('hot_10');?>
                                </th>
                                <th>
                                    <?=lang('hot_11');?>
                                </th>



                                <th class="crTradesMob">
                                    <?=lang('hot_12');?>
                                </th>

                                <th class="crTradesMob">
                                    <?=lang('hot_13');?>
                                </th>

                                <th class="crTradesMob">
                                    <?=lang('hot_14');?>
                                </th>

                                <th class="crTradesMob">
                                    <?=lang('hot_15');?>
                                </th>

                                <th class="crTradesMob">
                                    <?=lang('hot_16');?>
                                </th>

                                <th class="crTradesMob">
                                    <?=lang('hot_17');?>
                                </th>

                                <th class="crTradesMob">
                                    <?=lang('hot_18');?>
                                </th>
                            </tr>
                            </thead>
                            <tbody id="showoff">
                            <tr>
                                <td class="showupTableColspan" colspan="10" align="center">
                                    <?=lang('hot_19');?>
                                </td>
                            </tr>
                            </tbody>
                        </table>







                        <table class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table display-n" id="BalanceOperationBonus"   >
                            <thead>
                            <tr>
                                <th colspan="6">
                                    <?=lang('hot_20');?>
                                </th>
                            </tr>

                            <tr>
                                <th>
                                    <?=lang('hot_24');?>
                                </th>

                                <th class="crTradesMob">
                                    <?=lang('hot_25');?>
                                </th>

                                <th>
                                    <?=lang('hot_26');?>
                                </th>


                                <th class="crTradesMob">
                                    <?=lang('hot_27');?>
                                </th class="crTradesMob">

                                <th class="crTradesMob">
                                    <?=lang('hot_28');?>
                                </th>

                                <th class="crTradesMob">
                                    <?=lang('hot_29');?>
                                </th>

                                <th class="crTradesWeb">
                                    <?='Action';?>
                                </th>


                            </tr>
                            </thead>
                            <tbody id="balancebonus">
                            <tr>
                                <td colspan="10" align="center">
                                    <?=lang('hot_19');?>
                                </td>
                            </tr>
                            </tbody>
                        </table>




                        <table class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table display-n" id="BalanceOperationDeposit" >
                            <thead>
                            <tr>
                                <th colspan="6">
                                    <?=lang('hot_21');?>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <?=lang('hot_24');?>
                                </th>

                                <th class="crTradesMob">
                                    <nobr><?=lang('hot_25');?></nobr>
                                </th>

                                <th>
                                    <?=lang('hot_26');?>
                                </th>



                                <th  class="crTradesMob">
                                    <?=lang('hot_27');?>
                                </th>

                                <th  class="crTradesMob">
                                    <?=lang('hot_28');?>
                                </th>
                                <th  class="crTradesMob">
                                    <?=lang('hot_29');?>
                                </th>

                                <th class="crTradesWeb">
                                    <?='Action';?>
                                </th>


                            </tr>
                            </thead>
                            <tbody id="balancedeposit">
                            </tbody>
                        </table>




                        <table class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table display-n" id="BalanceOperationWithdraw" >
                            <thead>
                            <tr>
                                <th colspan="6">
                                    <?=lang('hot_22');?>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <?=lang('hot_24');?>
                                </th>

                                <th class="crTradesMob">
                                    <nobr><?=lang('hot_25');?></nobr>
                                </th>

                                <th>
                                    <?=lang('hot_26');?>
                                </th>


                                <th class="crTradesMob">
                                    <?=lang('hot_27');?>
                                </th>
                                <th class="crTradesMob">
                                    <?=lang('hot_28');?>
                                </th>
                                <th class="crTradesMob">
                                    <?=lang('hot_29');?>
                                </th>

                                <th class="crTradesWeb">
                                    <?='Action';?>
                                </th>




                            </tr>


                            </thead>
                            <tbody id="balancewithdraw">
                            <tr>
                                <td colspan="10" align="center">
                                    <?=lang('hot_19');?>
                                </td>
                            </tr>
                            </tbody>
                        </table>





                        <table class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table display-n" id="BalanceOperationTransfer" >
                            <thead>
                            <tr>
                                <th colspan="6">
                                    <?=lang('hot_23');?>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <?=lang('hot_24');?>
                                </th>

                                <th class="crTradesMob">
                                    <nobr> <?=lang('hot_25');?></nobr>
                                </th>

                                <th>
                                    <?=lang('hot_26');?>
                                </th>

                                <th class="crTradesMob">
                                    <?=lang('hot_27');?>
                                </th>
                                <th class="crTradesMob">
                                    <?=lang('hot_28');?>
                                </th>
                                <th class="crTradesMob">
                                    <?=lang('hot_29');?>
                                </th>

                                <th class="crTradesWeb">
                                    <?='Action';?>
                                </th>





                            </tr>
                            </thead>
                            <tbody id="balancetransfer">
                            <tr>
                                <td colspan="10" align="center">
                                    <?=lang('hot_19');?>
                                </td>
                            </tr>
                            </tbody>
                        </table>




                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
    @media screen and (max-width: 609px) {
        .cur-trades-tab ul li{
            float: none!important;
        }
    }
    @media screen and (max-width: 665px) {
        .cur-trades-tab ul li:lang(es){
            float: none!important;
        }
    }
    @media screen and (max-width: 665px) {
        .cur-trades-tab ul li:lang(de){
            float: none!important;
        }
    }
    @media screen and (max-width: 665px) {
        .cur-trades-tab ul li:lang(ru){
            float: none!important;
        }
    }
</style>
<script type="text/javascript">
    var pblc = [];
    var prvt = [];
    var site_url="<?=FXPP::ajax_url('')?>";
    pblc['request'] = null;
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

        $("#ClosedTrades").DataTable({
            language: {
                emptyTable:'<?=lang('dta_tbl_01')?>',
                infoEmpty:'<?=lang('dta_tbl_03')?>',
                lengthMenu: '<?=lang('dta_tbl_07')?>',
                search: '<?=lang('dta_tbl_10')?>:',
                "paginate": {
                    "first":     '<?=lang('dta_tbl_12')?>',
                    "last":      '<?=lang('dta_tbl_13')?>',
                    "next":      '<?=lang('dta_tbl_14')?>',
                    "previous":   '<?=lang('dta_tbl_15')?>'
                },
            }
        });

    });
    $(document).on("click", ".btnsearch", function () {

        $('#loader-holder').show();
        var prvt = [];
        prvt["data"] = {
            from: $('#date_start').val(),
            to: $('#date_end').val()
        };


// var idi="tclose";
//$(".cur-trades-tab ul li").each(function(){if($(this).find("a").hasClass("cur-active")){idi=$(this).find("a").attr("id");}})
//if(idi=="tclose") {

        pblc['request'] = $.ajax({
            dataType: 'json',
            url: site_url+"my-account/HistoryOfTrades",
            method: 'POST',
            data: prvt["data"]
        });

        pblc['request'].done(function( data ) {

            if (data.bonus==false && data.withdraw==false && data.deposit==false ){
                $('#BalanceOperationBonus').removeClass('display-n');
                $("#BalanceOperation").DataTable({
                    sorting:true,
                    language: {
                        emptyTable:'<?=lang('dta_tbl_01')?>',
                        infoEmpty:'<?=lang('dta_tbl_03')?>',
                        lengthMenu: '<?=lang('dta_tbl_07')?>',
                        search: '<?=lang('dta_tbl_10')?>:',
                        "paginate": {
                            "first":     '<?=lang('dta_tbl_12')?>',
                            "last":      '<?=lang('dta_tbl_13')?>',
                            "next":      '<?=lang('dta_tbl_14')?>',
                            "previous":   '<?=lang('dta_tbl_15')?>'
                        },
                    }
                });
            }else{
                $("#BalanceOperation").DataTable({
                    sorting:true,
                    language: {
                        emptyTable:'<?=lang('dta_tbl_01')?>',
                        infoEmpty:'<?=lang('dta_tbl_03')?>',
                        lengthMenu: '<?=lang('dta_tbl_07')?>',
                        search: '<?=lang('dta_tbl_10')?>:',
                        "paginate": {
                            "first":     '<?=lang('dta_tbl_12')?>',
                            "last":      '<?=lang('dta_tbl_13')?>',
                            "next":      '<?=lang('dta_tbl_14')?>',
                            "previous":   '<?=lang('dta_tbl_15')?>'
                        },
                    }
                });
                $('#BalanceOperation').removeClass('display-n');
            }
            if(data.bonus==true){
                $('#BalanceOperationBonus').DataTable().destroy();
                $('#BalanceOperationBonus').removeClass('display-n');
                $('tbody#balancebonus').html(data.BalOpe_bonus);
                $("#BalanceOperation").DataTable({
                    sorting:true,
                    language: {
                        emptyTable:'<?=lang('dta_tbl_01')?>',
                        infoEmpty:'<?=lang('dta_tbl_03')?>',
                        lengthMenu: '<?=lang('dta_tbl_07')?>',
                        search: '<?=lang('dta_tbl_10')?>:',
                        "paginate": {
                            "first":     '<?=lang('dta_tbl_12')?>',
                            "last":      '<?=lang('dta_tbl_13')?>',
                            "next":      '<?=lang('dta_tbl_14')?>',
                            "previous":   '<?=lang('dta_tbl_15')?>'
                        },
                    }
                });
            }else{
                $("#BalanceOperation").DataTable({
                    sorting:true,
                    language: {
                        emptyTable:'<?=lang('dta_tbl_01')?>',
                        infoEmpty:'<?=lang('dta_tbl_03')?>',
                        lengthMenu: '<?=lang('dta_tbl_07')?>',
                        search: '<?=lang('dta_tbl_10')?>:',
                        "paginate": {
                            "first":     '<?=lang('dta_tbl_12')?>',
                            "last":      '<?=lang('dta_tbl_13')?>',
                            "next":      '<?=lang('dta_tbl_14')?>',
                            "previous":   '<?=lang('dta_tbl_15')?>'
                        },
                    }
                });
                $('#BalanceOperationBonus').removeClass('display-n');
                $('#BalanceOperationBonus').addClass('display-n');
            }

            if(data.deposit==true){
                $('#BalanceOperationDeposit').DataTable().destroy();
                $('#BalanceOperationDeposit').removeClass('display-n');
                $('tbody#balancedeposit').html(data.BalOpe_deposit);
                $("#BalanceOperationDeposit").DataTable({
                    language: {
                        emptyTable:'<?=lang('dta_tbl_01')?>',
                        infoEmpty:'<?=lang('dta_tbl_03')?>',
                        lengthMenu: '<?=lang('dta_tbl_07')?>',
                        search: '<?=lang('dta_tbl_10')?>:',
                        "paginate": {
                            "first":     '<?=lang('dta_tbl_12')?>',
                            "last":      '<?=lang('dta_tbl_13')?>',
                            "next":      '<?=lang('dta_tbl_14')?>',
                            "previous":   '<?=lang('dta_tbl_15')?>'
                        },
                    }
                });
            }else{
                $("#BalanceOperationDeposit").DataTable({
                    language: {
                        emptyTable:'<?=lang('dta_tbl_01')?>',
                        infoEmpty:'<?=lang('dta_tbl_03')?>',
                        lengthMenu: '<?=lang('dta_tbl_07')?>',
                        search: '<?=lang('dta_tbl_10')?>:',
                        "paginate": {
                            "first":     '<?=lang('dta_tbl_12')?>',
                            "last":      '<?=lang('dta_tbl_13')?>',
                            "next":      '<?=lang('dta_tbl_14')?>',
                            "previous":   '<?=lang('dta_tbl_15')?>'
                        },
                    }
                });
                $('#BalanceOperationDeposit').removeClass('display-n');
            }

            if(data.withdraw==true){
                $('#BalanceOperationWithdraw').DataTable().destroy();
                $('#BalanceOperationWithdraw').removeClass('display-n');
                $('tbody#balancewithdraw').html(data.BalOpe_withdraw);
                $("#BalanceOperationWithdraw").DataTable({
                    language: {
                        emptyTable:'<?=lang('dta_tbl_01')?>',
                        infoEmpty:'<?=lang('dta_tbl_03')?>',
                        lengthMenu: '<?=lang('dta_tbl_07')?>',
                        search: '<?=lang('dta_tbl_10')?>:',
                        "paginate": {
                            "first":     '<?=lang('dta_tbl_12')?>',
                            "last":      '<?=lang('dta_tbl_13')?>',
                            "next":      '<?=lang('dta_tbl_14')?>',
                            "previous":   '<?=lang('dta_tbl_15')?>'
                        },
                    }
                });
            }else{
                $("#BalanceOperationWithdraw").DataTable({
                    language: {
                        emptyTable:'<?=lang('dta_tbl_01')?>',
                        infoEmpty:'<?=lang('dta_tbl_03')?>',
                        lengthMenu: '<?=lang('dta_tbl_07')?>',
                        search: '<?=lang('dta_tbl_10')?>:',
                        "paginate": {
                            "first":     '<?=lang('dta_tbl_12')?>',
                            "last":      '<?=lang('dta_tbl_13')?>',
                            "next":      '<?=lang('dta_tbl_14')?>',
                            "previous":   '<?=lang('dta_tbl_15')?>'
                        },
                    }
                });
//                $('#BalanceOperationWithdraw').DataTable().destroy();
                $('#BalanceOperationWithdraw').removeClass('display-n');
//                $('#BalanceOperationWithdraw').addClass('display-n');
            }

            if(data.transfer==true){
                $('#BalanceOperationTransfer').DataTable().destroy();
                $('#BalanceOperationTransfer').removeClass('display-n');
                $('tbody#balancetransfer').html(data.BalOpe_transfer);
                $("#BalanceOperationTransfer").DataTable({
                    language: {
                        emptyTable:'<?=lang('dta_tbl_01')?>',
                        infoEmpty:'<?=lang('dta_tbl_03')?>',
                        lengthMenu: '<?=lang('dta_tbl_07')?>',
                        search: '<?=lang('dta_tbl_10')?>:',
                        "paginate": {
                            "first":     '<?=lang('dta_tbl_12')?>',
                            "last":      '<?=lang('dta_tbl_13')?>',
                            "next":      '<?=lang('dta_tbl_14')?>',
                            "previous":   '<?=lang('dta_tbl_15')?>'
                        },
                    }
                });
            }else{
                $("#BalanceOperationTransfer").DataTable({
                    language: {
                        emptyTable:'<?=lang('dta_tbl_01')?>',
                        infoEmpty:'<?=lang('dta_tbl_03')?>',
                        lengthMenu: '<?=lang('dta_tbl_07')?>',
                        search: '<?=lang('dta_tbl_10')?>:',
                        "paginate": {
                            "first":     '<?=lang('dta_tbl_12')?>',
                            "last":      '<?=lang('dta_tbl_13')?>',
                            "next":      '<?=lang('dta_tbl_14')?>',
                            "previous":   '<?=lang('dta_tbl_15')?>'
                        },
                    }
                });
//                $('#BalanceOperationTransfer').DataTable().destroy();
                $('#BalanceOperationTransfer').removeClass('display-n');
//                $('#BalanceOperationTransfer').addClass('display-n');
            }

            var table1 =    $("#ClosedTrades").DataTable({
                language: {
                    emptyTable:'<?=lang('dta_tbl_01')?>',
                    infoEmpty:'<?=lang('dta_tbl_03')?>',
                    lengthMenu: '<?=lang('dta_tbl_07')?>',
                    search: '<?=lang('dta_tbl_10')?>:',
                    "paginate": {
                        "first":     '<?=lang('dta_tbl_12')?>',
                        "last":      '<?=lang('dta_tbl_13')?>',
                        "next":      '<?=lang('dta_tbl_14')?>',
                        "previous":   '<?=lang('dta_tbl_15')?>'
                    },
                }
            });
            table1.destroy();
            $('#closed').html(data.Closed);
            $("#ClosedTrades").DataTable({
                language: {
                    emptyTable:'<?=lang('dta_tbl_01')?>',
                    infoEmpty:'<?=lang('dta_tbl_03')?>',
                    lengthMenu: '<?=lang('dta_tbl_07')?>',
                    search: '<?=lang('dta_tbl_10')?>:',
                    "paginate": {
                        "first":     '<?=lang('dta_tbl_12')?>',
                        "last":      '<?=lang('dta_tbl_13')?>',
                        "next":      '<?=lang('dta_tbl_14')?>',
                        "previous":   '<?=lang('dta_tbl_15')?>'
                    },
                }
            });
            $('#loader-holder').hide();
        });
        pblc['request'].fail(function( jqXHR, textStatus ) {
            $('#loader-holder').hide();
        });

        pblc['request'].always(function( jqXHR, textStatus ) {
            $('#loader-holder').hide();
        });

//} else if(idi=="tcancel") {

        $('#CancelledPendingOrder').DataTable();

        pblc['request'] = $.ajax({
            dataType: 'json',
            url: site_url+"my-account/CancelledPendingOrders",
            method: 'POST',
            data: prvt["data"]
        });

        pblc['request'].done(function( data ) {

            var table1 =  $('#CancelledPendingOrder').DataTable();
            table1.destroy();
            $('#cancel_pen_order').html(data.Closed);
            $('#CancelledPendingOrder').DataTable();

            $('#loader-holder').hide();
        });

        pblc['request'].fail(function( jqXHR, textStatus ) {
            $('#loader-holder').hide();
        });

        pblc['request'].always(function( jqXHR, textStatus ) {
            $('#loader-holder').hide();
        });

//}


    });
    $(window).resize(function () {
        $(".sorting").width("");
        $("#ClosedTrades").width("100%");
        $("#CancelledPendingOrder").width("100%");
        $("#BalanceOperation").width("100%");
        $("#BalanceOperationBonus").width("100%");
        $("#BalanceOperationDeposit").width("100%");
        $("#BalanceOperationWithdraw").width("100%");
        $("#BalanceOperationTransfer").width("100%");
        $(".dataTables_scrollHeadInner").width("100%");
    });

</script>

<script type="text/javascript">
    function mobDetailsCloseTrades(cTic,cTrd,cVol,cSym,OpPrc,stLos,tkPrf,clPrc,swps,prf) {
        if($(window).width() < 768) {
            $('#close_trades_modal').modal('show');
            $("#modalDisabledbtnCloseTrades").removeAttr('disabled');
            $('.cTic').html(cTic);
            $('.cTrd').html(cTrd);
            $('.cVol').html(cVol);
            $('.cSym').html(cSym);
            $('.OpPrc').html(OpPrc);
            $('.stLos').html(stLos);
            $('.tkPrf').html(tkPrf);
            $('.clPrc').html(clPrc);
            $('.swps').html(swps);
            $('.prf').html(prf);
        }
    }

    function mobDetailsBalOperation(balTckt,balFund,balAmount,balSystem,balDate,balOper,tableCap) {
        if($(window).width() < 768) {
            $('#balance_operation_modal').modal('show');
            $("#modalDisabledbtnBalance").removeAttr('disabled');
            $('.balTckt').html(balTckt);
            $('.balFund').html(balFund);
            $('.balAmount').html(balAmount);
            $('.balSystem').html(balSystem);
            $('.balDate').html(balDate);
            $('.balOper').html(balOper);
            $('.balOpCaption').html(tableCap);
        }
    }
</script>

<?= $this->load->ext_view('modal', 'PaymentSystemCarousel', '', TRUE); ?>

<div id="close_trades_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content withdraw-->
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
                <strong style="font-size: 20px"> Closed Trades </strong>
                <button id="modalDisabledbtnCloseTrades" type="button" class="close" data-dismiss="modal" data-toggle="tooltip" ><span aria-hidden="true">&times;</span></button>


            </div>
            <div class="modal-body">

                <p id="m_message">
                </p>

                <table class="table table-striped tab-my-acct">

                    <tr>
                        <th>Ticket</th>
                        <td class="cTic"> </td>
                    </tr>

                    <tr>
                        <th>Type</th>
                        <td class="cTrd"> </td>
                    </tr>
                    <tr>
                        <th>volume</th>
                        <td class="cVol"> </td>
                    </tr>

                    <tr  >
                        <th>Symbol</th>
                        <td class="cSym"> </td>
                    </tr>

                    <tr>
                        <th>Open Price</th>
                        <td class="OpPrc"> </td>
                    </tr>

                    <tr>
                        <th>S/L</th>
                        <td class="stLos"> </td>
                    </tr>

                    <tr>
                        <th>T/P</th>
                        <td class="tkPrf"> </td>
                    </tr>

                    <tr>
                        <th>Close Price</th>
                        <td class="clPrc"> </td>
                    </tr>

                    <tr>
                        <th>Swaps</th>
                        <td class="swps"> </td>
                    </tr>

                    <tr>
                        <th>Profit</th>
                        <td class="prf"> </td>
                    </tr>

                </table>

            </div>

        </div>

    </div>
</div>




<div id="balance_operation_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
                <strong style="font-size: 20px"> Balance Operation (<span class="balOpCaption"> </span>)</strong>
                <button id="modalDisabledbtnBalance" type="button" class="close" data-dismiss="modal" data-toggle="tooltip" ><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <table class="table table-striped tab-my-acct">
                    <tr>
                        <th>Ticket</th>
                        <td class="balTckt"> </td>
                    </tr>
                    <tr>
                        <th>Type of Fund</th>
                        <td class="balFund"> </td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td class="balAmount"> </td>
                    </tr>
                    <tr  >
                        <th>Status</th>
                        <td class="balSystem"> </td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td class="balDate"> </td>
                    </tr>
                    <tr>
                        <th>Operation</th>
                        <td class="balOper"> </td>
                    </tr>
                </table>
            </div>

        </div>

    </div>
</div>