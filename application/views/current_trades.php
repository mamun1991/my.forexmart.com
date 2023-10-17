<?php $method = $this->router->method; ?>
<?php $class = $this->router->class; ?>
<?php $this->lang->load('datatable');?>

<link href="https://cdn.datatables.net/1.10.9/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.bootstrap.min.css" rel="stylesheet">

<style type="text/css">



    .dashboard > thead > tr > th {
        text-align: center;
    }
    .dashboard > tbody > tr > td {
        text-align: center;
    }
    #OpenedTrades > thead > tr > th:lang(jp) {
        white-space: nowrap;
    }

    @media screen and (max-width: 767px){
        .table-responsive {
            padding-top: 5px;
        }

    }


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

        .crTradesMob{
            display:;
        }
        .crTradesWeb{
            display:none ;
        }
    }












</style>
  

<?php if(IPLoc::IPOnlyForVenus()){ ?>
    <h1>
       My Trading
    </h1>



    <?php $this->load->view('trading_nav.php');?>
<?php }else{ ?>
    <h1>
        <?=lang('curtra_03');?>
    </h1>



    <?php $this->load->view('account_nav.php');?>
<?php } ?>



<div id="crTrades_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Current Trades <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <p id="m_message">
                </p>

                <table class="table table-striped tab-my-acct">

                    <tr>
                        <th>Ticket</th>
                        <td class="ticketData"> test 1</td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td> test 2</td>
                    </tr>
                    <tr>
                        <th>Volumn</th>
                        <td> test 3</td>
                    </tr>
                    <tr>
                        <th>Symbol</th>
                        <td> test 4</td>
                    </tr>



                    <tr>
                        <th>Open Price</th>
                        <td> test 5</td>
                    </tr>
                    <tr>
                        <th>S/L</th>
                        <td> test 6</td>
                    </tr>
                    <tr>
                        <th>T/P</th>
                        <td> test 7</td>
                    </tr>

                    <tr>
                        <th>Current Price</th>
                        <td> test 8</td>
                    </tr>

                    <tr>
                        <th>Swaps</th>
                        <td> test 9</td>
                    </tr>

                    <tr>
                        <th>Profit</th>
                        <td> test 10</td>
                    </tr>


                </table>




            </div>

        </div>

    </div>
</div>





    <div class="tab-content acct-cont">
        <div role="tabpanel" class="row tab-pane active" >

            <div class="col-sm-12">
              
            <?php $this->load->view('account_current_trades_nav');?>


                 
                <div class="clearfix">
                    <div class="tab-content cur-tab-cont">
                        <div role="tabpanel" class="table-responsive cur_tra_cont" id="tab_current_trades">
                            <table id="OpenedTrades" class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table">
                               <thead>
                                <tr>

                                    <th>
                                        <?=lang('curtra_04');?>
                                    </th>

                                    <th >
                                        <?=lang('curtra_05');?>
                                    </th>

                                    <th>
                                        <?=lang('curtra_06');?>
                                    </th>

                                    <th class="crTradesMob">
                                        <?=lang('curtra_07');?>
                                    </th>




                                    <th class="crTradesMob">
                                        <?=lang('curtra_08');?>
                                    </th>
                                    <th class="crTradesMob">
                                        <?=lang('curtra_09');?>
                                    </th>
                                    <th class="crTradesMob">
                                        <?=lang('curtra_10');?>
                                    </th>
                                    <th class="crTradesMob">
                                        <?php if(IPLoc::Office()){ echo "Current price"; }
                                        else{
                                            echo lang('curtra_11');
                                        }?>
                                       <?/*=lang('curtra_11');*/?>

                                    </th>
                                    <th class="crTradesMob">
                                        <?=lang('curtra_12');?>
                                    </th>
                                    <th class="crTradesMob">
                                        <?=lang('curtra_13');?>
                                    </th>


                                    <th class="crTradesWeb">
                                        <?='Action';?>
                                    </th>




                                </tr>
                                </thead>
                                <tbody>

                                    <?= $Opened?>

                                    <?php  if(IPLoc::Office()){
                                       // echo '<tr onclick="viewDetails(10);"> <td>test</td></tr>';
                                      // echo $Opened2;
                                    } ?>


                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="row">
    <?= $this->load->ext_view('modal', 'PaymentSystemCarousel', '', TRUE); ?>
</div>

<script type="text/javascript">
    $(function() {
        $('#OpenedTrades').DataTable({
           
            language: {
                emptyTable:'<?=lang('dta_tbl_01')?>',
                infoEmpty:'<?=lang('dta_tbl_03')?>',
                lengthMenu: '<?=lang('dta_tbl_07')?>',
				info: '<?=lang('dta_tbl_02')?>',
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
    $(window).resize(function () {
        $(".sorting").width("");
        $(".OpenedTrades").width("100%");
        $("#OpenedTrades").width("100%");
        $(".dataTables_scrollHeadInner").width("100%");
    });


</script>



<script type="text/javascript">

    function mobDetailsCloseTrades(crTic,crTrd,crVol,crSym,crOprc,crStls,crTkprft,crClprc,crSwps,crPrf) {
        if($(window).width() < 768) {
            $('#current_trades_modal').modal('show');
            $("#modalDisabledbtnCurrent").removeAttr('disabled');
            $('.crTic').html(crTic);
            $('.crTrd').html(crTrd);
            $('.crVol').html(crVol);
            $('.crSym').html(crSym);
            $('.crOprc').html(crOprc);
            $('.crStls').html(crStls);
            $('.crTkprft').html(crTkprft);
            $('.crClprc').html(crClprc);
            $('.crSwps').html(crSwps);
            $('.crPrf').html(crPrf);
        }
    }


</script>




<div id="current_trades_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content withdraw-->
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
                <strong style="font-size: 20px"> Current Trades </strong>
                <button id="modalDisabledbtnCurrent" type="button" class="close" data-dismiss="modal" data-toggle="tooltip" ><span aria-hidden="true">&times;</span></button>


            </div>
            <div class="modal-body">

                <p id="m_message">
                </p>

                <table class="table table-striped tab-my-acct">

                    <tr>
                        <th>Ticket</th>
                        <td class="crTic"> </td>
                    </tr>

                    <tr>
                        <th>Type</th>
                        <td class="crTrd"> </td>
                    </tr>
                    <tr>
                        <th>volume</th>
                        <td class="crVol"> </td>
                    </tr>

                    <tr  >
                        <th>Symbol</th>
                        <td class="crSym"> </td>
                    </tr>

                    <tr>
                        <th>Open Price</th>
                        <td class="crOprc"> </td>
                    </tr>

                    <tr>
                        <th>S/L</th>
                        <td class="crStls"> </td>
                    </tr>

                    <tr>
                        <th>T/P</th>
                        <td class="crTkprft"> </td>
                    </tr>

                    <tr>
                        <th>Close Price</th>
                        <td class="crClprc"> </td>
                    </tr>

                    <tr>
                        <th>Swaps</th>
                        <td class="crSwps"> </td>
                    </tr>

                    <tr>
                        <th>Profit</th>
                        <td class="crPrf"> </td>
                    </tr>



                </table>




            </div>

        </div>

    </div>
</div>
<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>