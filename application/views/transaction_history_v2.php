
<style>
    .n_w_{
        white-space: nowrap!important;
    }
    .section:lang(sa) {
        min-height: 400px !important;
    }
    .btn-withdraw-option{
        padding:6px 16px !important;
    }

    .tabRecall {
        color: #337ab7;
        cursor: pointer;
    }




    /*@media screen and (max-width: 767px) {*/
    /*table#request-table th:nth-of-type(1), td:nth-of-type(1) ,th:nth-of-type(2), td:nth-of-type(2),th:nth-of-type(4), td:nth-of-type(4) {*/
    /*display: none;*/
    /*}*/

    /*table#request-table th:nth-of-type(6), td:nth-of-type(6) ,th:nth-of-type(7), td:nth-of-type(7),th:nth-of-type(8), td:nth-of-type(8) {*/
    /*display: none;*/
    /*}*/




    /*}*/


    /*@media screen and (min-width: 768px) {*/
    /*table#request-table th:nth-of-type(1), td:nth-of-type(1), th:nth-of-type(2), td:nth-of-type(2), th:nth-of-type(4), td:nth-of-type(4) {*/
    /*display:;*/
    /*}*/

    /*table#request-table th:nth-of-type(6), td:nth-of-type(6), th:nth-of-type(7), td:nth-of-type(7), th:nth-of-type(8), td:nth-of-type(9) {*/
    /*display:;*/
    /*}*/
    /*}*/







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


        .btn-withdraw-option {
            padding: 6px 12px !important;
        }

    }

    @media screen and (min-width: 767px){

        .crTradesMob{
            display:;
        }
        .crTradesWeb{
            display:none ;
        }
    }




    @media screen and (min-width: 768px) {
        table.CuRecTbl th:nth-of-type(1),
        table.CuRecTbl td:nth-of-type(1) {
            display: ;
        }

        table.CuRecTbl th:nth-of-type(3),
        table.CuRecTbl td:nth-of-type(3) {
            display: ;
        }

        table.CuRecTbl th:nth-of-type(4),
        table.CuRecTbl td:nth-of-type(4) {
            display: ;
        }

        table.CuRecTbl th:nth-of-type(6),
        table.CuRecTbl td:nth-of-type(6) {
            display: ;
        }

        table.CuRecTbl th:nth-of-type(7),
        table.CuRecTbl td:nth-of-type(7) {
            display: ;
        }

        /*table.CuRecTbl th:nth-of-type(8),*/
        /*table.CuRecTbl td:nth-of-type(8) {*/
        /*display: ;*/
        /*}*/

        table.CuRecTbl th:nth-of-type(9),
        table.CuRecTbl td:nth-of-type(9) {
            display: none ;
        }
    }


    @media screen and (max-width: 767px) {
        table.CuRecTbl th:nth-of-type(1),
        table.CuRecTbl td:nth-of-type(1) {
            display: none;
        }

        table.CuRecTbl th:nth-of-type(3),
        table.CuRecTbl td:nth-of-type(3) {
            display: none;
        }

        table.CuRecTbl th:nth-of-type(4),
        table.CuRecTbl td:nth-of-type(4) {
            display: none;
        }

        table.CuRecTbl th:nth-of-type(6),
        table.CuRecTbl td:nth-of-type(6) {
            display: none;
        }

        table.CuRecTbl th:nth-of-type(7),
        table.CuRecTbl td:nth-of-type(7) {
            display: none;
        }

        /*table.CuRecTbl th:nth-of-type(8),*/
        /*table.CuRecTbl td:nth-of-type(8) {*/
        /*display: none;*/
        /*}*/

        table.CuRecTbl th:nth-of-type(9),
        table.CuRecTbl td:nth-of-type(9) {
            display: ;
        }



    }



</style>
<?php $this->load->view('finance_nav.php');?>

<h1>
    <?=lang('finav_04');?>
</h1>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="tab1">
        <div class="row">
            <div class="col-sm-12">
                <div class="cur-trades-tab arabic-cur-trades-tab">
                    <ul class="tra_his">
                        <li>
                            <a id="t_incomplete" href="#cur" aria-controls="cur" role="tab" data-toggle="tab" class="cur-active">
                                <?=lang('frahis_00');?>
                            </a>
                        </li>
                        <li>
                            <a id="t_complete" href="#pend" aria-controls="pend" role="tab" data-toggle="tab">
                                <?=lang('frahis_01');?>
                            </a>
                        </li>
                    </ul>

                </div><div class="clearfix"></div>
                <div class="tab-content cur-tab-cont">
                    <div role="tabpanel" class="tab-pane table-responsive active" id="cur">
                        <table id="request-table" class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table CuRecTbl" style="width: 100% !important;" >
                            <thead>
                            <tr>
                                <th class="n_w_"><?=lang('frahis_13');?></th>
                                <th class="n_w_"><?=lang('frahis_02');?></th>
                                <th class="n_w_"><?=lang('frahis_03');?></th>
                                <th class="n_w_"><?=lang('frahis_04');?></th>
                                <th class="n_w_"><?=lang('frahis_05');?></th>
                                <th class="n_w_"><?=lang('frahis_06');?></th>
                                <th class="n_w_"><?=lang('frahis_07');?></th>
                                <th class="n_w_"><?=lang('frahis_12');?></th>

                                <th>Details</th>




                            </tr>
                            </thead>
                            <tbody id="all-Request-tbody">
                            </tbody>
                        </table>

                    </div>
                    <div role="tabpanel" class="tab-pane table-responsive" id="pend">
                        <table id="BalanceOperation"  class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table" >
                                    <thead>
                                    <tr>
                                        <th colspan="6">
                                            <?=lang('frahis_08');?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="n_w_">
                                            <?=lang('frahis_02');?>
                                        </th>
                                        <th class="n_w_">
                                            <?=lang('frahis_03');?>
                                        </th>
                                        <th class="n_w_">
                                            <?=lang('frahis_04');?>
                                        </th>
                                        <th class="n_w_">
                                            <?=lang('frahis_05');?>
                                        </th>
                                        <th class="n_w_">
                                            <?=lang('frahis_07');?>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="balanceopt-tbody">
                                    </tbody>
                                </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="recallModalButton" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center bonus-alert-title">Recall Withdraw</h4>
            </div>
            <div class="modal-body modal-show-body">
                <div class="text-center bonus-alert-message">
                    <p><strong>Are you sure you want to recall your withdrawal request ?</strong></p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="center-block">
                    <button type="button" class="modalButton" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Yes</span></button>
                    <button type="button" class="tabRecallNo" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">No</span></button>
                </div>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
    @media screen and (max-width:700px) {
        ul.tra_his li{
            width: 100%;
            float: none;
            margin: 1px;

        }
        ul.tra_his li a{
            text-align: center;
        }
    }
</style>
<script type="text/javascript">
    var datatable = $("#BalanceOperationWithdraw").DataTable();
    var url = '<?php echo FXPP::loc_url()?>';
    var ajax_url="<?php echo FXPP::ajax_url()?>";

    $(document).on("click", ".tabRecall", function(){
        $("#recallModalButton").modal('show');
        $(this).parents('tr').addClass('currentRemove');
    });


    $(document).on("click", ".tabRecallNo", function(){
        //$("#recallModalButton").modal('show');
        $("#BalanceOperationWithdraw").find('tr.currentRemove').removeClass('currentRemove');
    });

    $(document).on("click", ".modalButton", function(){
        var ticket = $(".tabRecall").attr('rel');
        console.log("ticket " + ticket);

        $.post(ajax_url+"Transaction_history/recallUpdateStatus",{ticket:ticket},function(view){
            if(view == 'done'){
                datatable.row('.currentRemove').remove().draw( false );
            }
        });
    });



    $('body').on('click', '.view-comment', function(){
        var comment = $(this).data('wcomment');
        console.log(comment);
        bootbox.alert({
            title: 'Transaction Comment',
            message: comment,
            show: true
        });
    });


    $("#t_incomplete").click(function(){
        $("#t_complete").removeClass("cur-active");
        $("#t_incomplete").addClass("cur-active");

    });
    $("#t_complete").click(function(){
        $("#t_incomplete").removeClass("cur-active");
        $("#t_complete").addClass("cur-active");

    });

    $(document).ready(function(){
        //    Incomplete
        $('#Incomplete').DataTable({
            "order": [[5, "desc"]],
            language: {
                sInfo: '<?=lang('dta_tbl_02')?>',
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
            }
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
                        url: ajax_url + "transaction_history/updateWithdrawTransaction",
                        data: {ticket: ticket},
                        dataType: 'json',
                        beforeSend: function () {
                            $('#loader-holder').show();
                            $("tr#" + transId).hide();
                            $("tr#" + transId).css("display", 'none');
                        },
                        success: function (x) {
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
        })


    });

</script>


<script>
    var site_url="<?=base_url()?>";
    var tblAccounts = jQuery('#request-table').on('preXhr.dt', function ( e, settings, data ) {
        jQuery('#loader-holder').show();
    }).on('xhr.dt', function ( e, settings, json, xhr ) {
        jQuery('#loader-holder').hide();
    }).DataTable({
        "processing": false,
        "serverSide": true,
        "bFilter": true,
        "bSort": true,
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
            "url": site_url+'transaction_history/getPendingWithdrawalsV2',
            "type": "POST",
            "data": function ( d ) {
                d.tab="Request";
                //console.log('test123');
            }
        }
    });

</script>


<div class="modal fade" id="modalRecallAlert" tabindex="=-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog round-0">
        <div  class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center modal-show-title" id="modalBonusDelayTitle">Withdrawal Recall</h4>
            </div>
            <div class="modal-body modal-show-body">
                <div class="text-center recall-msg">
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</div>






<div id="transection_history_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
                <strong style="font-size: 20px"> Transaction History </strong>
                <button id="modalDisabledbtn" type="button" class="close" data-dismiss="modal" data-toggle="tooltip" ><span aria-hidden="true">&times;</span></button>


            </div>
            <div class="modal-body">

                <p id="m_message">
                </p>

                <table class="table table-striped tab-my-acct">

                    <tr>
                        <th>Type</th>
                        <td class="dttype"> </td>
                    </tr>
                    <tr>
                        <th>Transection</th>
                        <td class="dtTransection"> </td>
                    </tr>
                    <tr>
                        <th>Account</th>
                        <td class="dtAccount"> </td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td class="dtAmount"> </td>
                    </tr>

                    <tr class="paySysTr" style="display: none">
                        <th>Pay System</th>
                        <td class="dtPaySystem"> </td>
                    </tr>

                    <tr>
                        <th>Date</th>
                        <td class="dtDate"> </td>
                    </tr>



                </table>




            </div>

        </div>

    </div>
</div>










<div id="transection_history_modal_withdraw" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content withdraw-->
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
                <strong style="font-size: 20px"> Transaction History </strong>
                <button id="modalDisabledbtnWithdraw" type="button" class="close" data-dismiss="modal" data-toggle="tooltip" ><span aria-hidden="true">&times;</span></button>


            </div>
            <div class="modal-body">

                <p id="m_message">
                </p>

                <table class="table table-striped tab-my-acct">

                    <tr>
                        <th>Type</th>
                        <td class="wtTyp"> </td>
                    </tr>

                    <tr>
                        <th>Account</th>
                        <td class="wtAcc"> </td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td class="wtAmnt"> </td>
                    </tr>

                    <tr  >
                        <th>Pay System</th>
                        <td class="wtTrans"> </td>
                    </tr>

                    <tr>
                        <th>Date</th>
                        <td class="wtDte"> </td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td class="wtStatus"> </td>
                    </tr>

                    <tr>
                        <th>Comments</th>
                        <td class="wtCmnts"> </td>
                    </tr>

                    <tr>
                        <th>Recall</th>
                        <td class="call"> </td>
                    </tr>



                </table>






            </div>

        </div>

    </div>
</div>











<div id="penTransectionModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content withdraw-->
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
                <strong style="font-size: 20px"> Pending Transaction  </strong>
                <button id="modalPenTransection" type="button" class="close" data-dismiss="modal" data-toggle="tooltip" ><span aria-hidden="true">&times;</span></button>


            </div>
            <div class="modal-body">

                <p id="m_message">
                </p>

                <table id="transDetails" class="table table-striped tab-my-acct">

                    <tr>
                        <th>Ref</th>
                        <td class="cRef"> </td>
                    </tr>

                    <tr>
                        <th>Type</th>
                        <td class="cType"> </td>
                    </tr>
                    <tr>
                        <th>Transection </th>
                        <td class="cTrns"> </td>
                    </tr>

                    <tr  >
                        <th>Account</th>
                        <td class="cAcc"> </td>
                    </tr>

                    <tr >
                        <th>Amount</th>
                        <td class="cAmnt"> </td>
                    </tr>


                    <tr>
                        <th>pay System</th>
                        <td class="cPay"> </td>
                    </tr>

                    <tr>
                        <th>Date</th>
                        <td class="cdate"> </td>
                    </tr>


                </table>







            </div>

        </div>

    </div>
</div>




<div id="transferTransectionModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content withdraw-->
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
                <strong style="font-size: 20px"> Transfer Transaction  </strong>
                <button id="modalTransferTransection" type="button" class="close" data-dismiss="modal" data-toggle="tooltip" ><span aria-hidden="true">&times;</span></button>


            </div>
            <div class="modal-body">

                <p id="m_message">
                </p>
                <table id="transDetails" class="table table-striped tab-my-acct">
                    <tr>
                        <th>Type</th>
                        <td class="tType"> </td>
                    </tr>
                    <tr>
                        <th>Transection </th>
                        <td class="tTrans"> </td>
                    </tr>
                    <tr  >
                        <th>Transection From</th>
                        <td class="trnsFrm"> </td>
                    </tr>
                    <tr >
                        <th>Transection To</th>
                        <td class="trnsTo"> </td>
                    </tr>
                    <tr>
                        <th> Amount</th>
                        <td class="trnsAmnt"> </td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td class="trnsDate"> </td>
                    </tr>
                </table>
            </div>

        </div>

    </div>
</div>












