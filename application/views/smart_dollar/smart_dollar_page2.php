<style>
    .cash-holder h1 {
    font-size: 30px !important;
    }
    .tbl-title{
        text-align: center;
    background: #1baef0;
    padding: 10px 0px;
    margin-top: 10px;
    margin-bottom: 0px;
    color: white;
    margin-right: 4px;
    margin-left: 3px;
    }
    .tbl-smart-dollars-activity {
        margin-top: 5px!important;
        margin-bottom: 30px;
    }
    .tooltip {
    position: fixed;
}

.sorting, .sorting_asc, .sorting_desc {
    background : none;
}

.avatar img{
    object-fit: cover;
}

</style>



<div class="col-sm-12 full">

        <div class="col-sm-3 full">

        </div>

        <div class="col-sm-12 smart-dollars">
            <div class="alert alert-success alert-msg" role="alert" style="display: none"></div>
            <h3>Smart Dollars</h3>
            <div class="col-sm-12 full">
                <div class="btn-holder">
                    <div class= "col-sm-3 btn-holder">
                        <a href="#regular" type="button" class="btn btn-regular"><p>REGULAR</p></a>
                    </div>
                    <div class=" col-sm-3 btn-holder">
                        <a href="#pro" type="button" class="btn btn-pro"><p> PRO</p></a>
                    </div>
                    <div class="col-sm-3 btn-holder">
                        <a href="#expert" type="button" class="btn btn-expert"><p>EXPERT</p></a>
                    </div>
                    <div class="col-sm-3 btn-holder">
                        <a href="#vip" type="button" class="btn btn-vip"><p>VIP</p></a>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 full smart-dollars-desc equalheight-holder">

                <div class="col-md-2 col-sm-3 full avatar">
                    <img src="<?php echo $image ? base_url('assets/user_images/' . $image) : $this->template->Images() . 'avatar_smart_dollar.png' ?>" class="img-responsive">
                </div>

                <div class="col-md-7 col-sm-6 lots">
                    <h3>Total lots - <span class="total-lots"> 0 </span></h3>
                    <h4><span class="cur-level">Regular</span> <span class="cur-level-pips">0.05</span> pips </h4>
                    <p>Your current level is <span class="cur-level"> Regular </span><span class="vip">, trade <span class="x-lots-to-trade"> 50 </span> more for <span class="next-level"> Pro </span> level to get <span class="next-level-pip"> 0.06 </span> pips from each deal.</span></p>
                </div>

                <div class="col-md-3 col-sm-3 full cash-holder">
                    <h1>$<span class="cash-fund">0</span></h1>
                    <a href="#"><div id = "cash-button" class="cash" data-toggle="tooltip" data-placement="top" title="Clicking  &#34 REQUEST &#34, you will reset your Smart Dollars balance and create a new Entry with appropriate amounts in the Registry."><h4> REQUEST</h4></div></a>
                </div>

            </div>

            <div id="exTab" class="smart-dollars-activity-section">

                <ul class="nav nav-tabs smart-dollars-activity-block">
<!--                    <li class="active">-->
<!--                        <a  href="#1" id = "pending_tab" data-toggle="tab">Pending</a>-->
<!--                    </li>-->
<!--                    <li class="active">-->
<!--                        <a href="#2" id = "completed_tab" data-toggle="tab">Completed</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="#3" id = "history_tab" data-toggle="tab">History</a>-->
<!--                    </li>-->
                </ul>

                <div class="tab-content clearfix">

                   <!-- <div class="tab-pane active" id="1">
                        <div class="table-responsive">
                            <table class="table tbl-smart-dollars-activity text-center">
                                <thead>
                                <tr>
                                    <th>Date <i class="date-tip fa fa-question-circle"></i></th>
                                    <th>Amount <i class="amount-tip fa fa-question-circle"></i></th>
                                    <th>Lots to trade <i class="lots-trade-tip fa fa-question-circle"></i></th>
                                    <th>Remaining <i class="lots-remain-tip fa fa-question-circle"></i></th>
                                    <th>Accounting <i class="accounting-tip fa fa-question-circle"></i></th>
                                </tr>
                                </thead>
                                <tbody id="tbody_pending" class="tbody_hist_pending">

                                </tbody>
                            </table>
                        </div>

                    </div>-->

                    <div class="tab-pane active" id="2">
                        <div class="table-responsive">
                            <table class="table tbl-smart-dollars-activity text-center" style="table-layout: fixed;">
                                <thead>
                                        <th>Amount <i class="amount-tip fa fa-question-circle"></i></th>
                                        <th>Date of Withdrawing <i class="withdrawn-tip fa fa-question-circle"></i></th>
                                   
                                </thead>
                            <tbody id="tbody_complete" class="tbody_hist_complete">

                            </tbody>
                            <tfoot id="tbl_foot">
                            <tr>

                                    <th><span style="float:left;margin-right:10px">Total</span><span id="comp-total" style="margin-left:130px;"></span></th>
                                    <th></th>
                            </tr>
                            </tfoot>
                        </table>
                        </div>
                    </div>

                    <!--<div class="tab-pane" id="3">
                    <p class="tbl-title" >Completed</p>
                        <div class="table-responsive">
                       
                            <table class="table tbl-smart-dollars-activity text-center">
                                <thead>
                                
                                    <th>Date <i class="date-tip fa fa-question-circle"></i></th>
                                    <th>Amount <i class="amount-tip fa fa-question-circle"></i></th>
                                    <th>Lots to trade <i class="lots-trade-tip fa fa-question-circle"></i></th>
                                    <th>Withdrawn <i class="withdrawn-tip fa fa-question-circle"></i></th>
                                
                                </thead>
                                <tbody id="tbody_hist_complete" class="tbody_hist_complete">

                                </tbody>
                            </table>
                        </div>
                        <p class="tbl-title" >Pending</p>
                        <div class="table-responsive">

                                 
                            <table class="table tbl-smart-dollars-activity text-center">
                                <thead>
                               
                                    <th>Date <i class="date-tip fa fa-question-circle"></i></th>
                                    <th>Amount <i class="amount-tip fa fa-question-circle"></i></th>
                                    <th>Lots to trade <i class="lots-trade-tip fa fa-question-circle"></i></th>
                                    <th>Remaining <i class="lots-remain-tip fa fa-question-circle"></i></th>
                                    <th>Accounting <i class="accounting-tip fa fa-question-circle"></i></th>
                               
                                </thead>
                                <tbody id="tbody_hist_pending" class="tbody_hist_pending">


                                </tbody>
                            </table>
                        </div>
                        <p class="tbl-title" > Cancelled</p>
                        <div class="table-responsive">
                          
                            <table class="table tbl-smart-dollars-activity text-center">
                                <thead>
                                    <th>Date <i class="date-tip fa fa-question-circle"></i></th>
                                    <th>Amount <i class="amount-tip fa fa-question-circle"></i></th>
                                    <th>Lots to trade <i class="lots-trade-tip fa fa-question-circle"></i></th>
                                    <th>Expired <i class="expired-tip fa fa-question-circle"></i></th>
                               
                                </thead>
                                <tbody id="tbody_hist_cancel" class="tbody_hist_cancel">

                                </tbody>
                            </table>
                        </div>
                    </div>-->

                </div>
            </div>

        </div>
<!--    --><?php //if(IPLoc::IPOnlyForG){ ?>
        <span class="account_number" style="display: none"></span>
<!--    --><?php //} ?>
    </div>
<?php /** Preloader Modal Start */ ?>
<div id="loader-holder" class="loader-holder">
    <div class="loader">
        <div class="loader-inner ball-pulse">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>
<?php /** Preloader Modal End */ ?>

<script src='https://my.forexmart.com/assets/js/jquery.dataTables.js'></script>    
<script src='https://my.forexmart.com/assets/js/dataTables.bootstrap.js'></script>                  
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css'>


<script type ="text/javascript">
    var base_url = "<?=FXPP::ajax_url();?>";
    var test_field="<?=$test_field?>";


   // $('.tbl-smart-dollars-activity').dataTable();
    $(document).ready(function() {
        $('.badge-smart-dollar').css('display', 'none');
        $('[data-toggle="tooltip"]').tooltip();

        $('.date-tip').tooltip({
            title: "The date of creation an Entry.",
            html: true,
            placement: "top"
        });
        $('.amount-tip').tooltip({
            title: "Amount of Smart Dollars of the Entry.",
            html: true,
            placement: "top"
        });
        $('.lots-trade-tip').tooltip({
            title: "The total lots to trade within a month in order to receive Smart Dollars to your balance.",
            html: true,
            placement: "top"
        });
        $('.lots-remain-tip').tooltip({
            title: "Lots left to trade before the accounting date for this Entry comes.",
            html: true,
            placement: "top"
        });
        $('.accounting-tip').tooltip({
            title: "The date of the settlement. Any unfulfilled Entry will be expired",
            html: true,
            placement: "top"
        });

        $('.withdrawn-tip').tooltip({
            title: "The date of the withdrawn.",
            html: true,
            placement: "top"
        });

        $('.expired-tip').tooltip({
            title: "The date of the expiry.",
            html: true,
            placement: "top"
        });


        jQuery.ajax({
            type: "POST",
            url: base_url + "smartdollar/getSmartInfo",
            dataType: 'json',
            beforeSend: function () {
                $('#loader-holder').show();
                
            },
            success: function (x) {
                $('#loader-holder').hide();
                if (x.success) {
                    $('.total-lots').html(x.totalLots);
                    $('.x-lots-to-trade').html(x.lotsX);
                    $('.cur-level').html(x.curlevel);
                    $('.cur-level-pips').html(x.curlevelPip);
                    $('.next-level').html(x.nextLevel);
                    $('.next-level-pip').html(x.nextlevelPip);
                    var cash = x.cashFund;
                    $('.cash-fund').html(parseFloat(cash).toFixed(2));
                   // $('#tbody_pending').append(x.pending);
                   getTableData(1);
                    $('.account_number').html(x.accountNumb);
                    //$('#ex13').attr('data-slider-value',x.totalLots);

                   var txt = 'Clicking "REQUEST", you will reset your Smart Dollars balance and create a new Entry with appropriate amounts in the Registry.';


                 

                $("#cash-button").attr('data-original-title', txt);
                


                    if(x.curlevel == 'VIP'){
                        $(".vip").hide();
                    }else{
                        $(".vip").show();
                    }

                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#loader-holder').hide();
                console.log(xhr.status);
                console.log(thrownError);
            }
        });

    });
    $(document).on('click', '#cash-button', function(event){
        event.preventDefault();
        var cash_amount = $('.cash-fund').html();
        var account = $('.account_number').html();
        
//        if(test_field){
//            cash_amount=1000; /// just teting purpose
//        }
        
        if(cash_amount > 0 || account == '58039610' || account == 58039610) {
            jQuery.ajax({
                type: "POST",
                url: base_url + "smartdollar/processCashed",
                data: 'amount=' + cash_amount,
                dataType: 'json',
                beforeSend: function () {
                    $('#loader-holder').show();
                },
                success: function (x) {
                    $('#loader-holder').hide();
                    if (x.success) {
                        window.location.reload(true);
                        $('.cash-fund').val(0);

                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#loader-holder').hide();
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        } else {
            console.log("Nothing to process here.");
        }



    });
    $(document).on('click', '.btn-withdraw', function(){
        var cash_amount = $(this).attr('data-amount');
        var id = $(this).attr('data-id');
        if(cash_amount > 0) {
            jQuery.ajax({
                type: "POST",
                url: base_url + "smartdollar/processWithdraw",
                data: 'amount=' + cash_amount+'&id=' + id,
                dataType: 'json',
                beforeSend: function () {
                    $('#loader-holder').show();
                },
                success: function (x) {
                    $('#loader-holder').hide();
                    if (x.success) {
                        window.location.reload(true);
                        $('.alert-msg').html('Amount has been successfully credited to your account.');
                        $('.alert-msg').show();
                        $('.tr_ ' + id).hide();

                       
                    }else{
                        $('.alert-msg').html('Webservice Failed. Please try again!');
                        $('.alert-msg').show();
                    }
                    setTimeout(function(){ $('.alert-msg').hide() }, 5000);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#loader-holder').hide();
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }
    });


    $(document).on('click', '.btn-withdraw_amt', function(){
        var FromTicket = $(this).attr('data-FromTicket');
        var ToTicket = $(this).attr('data-ToTicket');
        var cash_amount = $(this).attr('data-amount');
        if(cash_amount > 0) {
            jQuery.ajax({
                type: "POST",
                url: base_url + "smartdollar/processWithdrawAPI",
                data: 'ToTicket=' + ToTicket+'&FromTicket=' + FromTicket,
                dataType: 'json',
                beforeSend: function () {
                    $('#loader-holder').show();
                },
                success: function (x) {
                    $('#loader-holder').hide();
                    if (x.success) {                        
                        $('.alert-msg').html('Amount has been successfully credited to your account.');
                        $('.alert-msg').show();
                        $('.tr_'+ToTicket).hide();
                    }else{
                        $('.alert-msg').html('Webservice Failed. Please try again!');
                        $('.alert-msg').show();
                    }
                    setTimeout(function(){ $('.alert-msg').hide() }, 5000);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#loader-holder').hide();
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }
    });

    $(document).on('click', '#completed_tab', function(event){
        event.preventDefault();
        var tab = 1;
        getTableData(tab);

    });
    $(document).on('click', '#pending_tab', function(event){
        event.preventDefault();
        var tab = 0;
        getTableData(tab);

    });
    $(document).on('click', '#history_tab', function(event){
        event.preventDefault();
        var tab = 2;
        getTableData(tab);

    });

    function getTableData (tab) {
        jQuery.ajax({
            type: "POST",
            url: base_url + "smartdollar/getTableRecords",
            data: 'tab=' + tab,
            dataType: 'json',
            beforeSend: function () {
                $('#loader-holder').show();
                $('.tbl-smart-dollars-activity').DataTable().destroy();
               
            },
            success: function (x) {
                $('#loader-holder').hide();
                if (x.success) {
//                    if(tab == 0){
//                        $('.tbody_hist_pending').html('');
//                        $('.tbody_hist_pending').append(x.htmlData);
//                    }
                    if(tab == 1){
                        $('.tbody_hist_complete').html('');
                        $('.tbody_hist_complete').append(x.htmlData);
                        $('#comp-total').html(parseFloat(x.total).toFixed(2));
                    }
//                    if(tab == 2){
//                        $('.tbody_hist_complete').html('');
//                        $('.tbody_hist_complete').append(x.htmlDataComplete);
//                        $('.tbody_hist_pending').html('');
//                        $('.tbody_hist_pending').append(x.htmlDataPending);
//                        $('.tbody_hist_cancel').html('');
//                        $('.tbody_hist_cancel').append(x.htmlDataCancel);
//                    }

                   
                     $('.tbl-smart-dollars-activity').dataTable({"searching": false,"lengthChange": false,"ordering": false });
                     $('.sorting_asc').removeClass('sorting_asc');                     
                     $("th").removeAttr("tabindex");
                    

                     
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#loader-holder').hide();
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    }

   

</script>