
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
</style>
<?php $this->load->view('finance_nav.php');?>
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
                        <table id="Incomplete" class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table">
                            <thead>
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
                                    <?=lang('frahis_06');?>
                                </th>
                                 <th class="n_w_">
                                    <?=lang('frahis_07');?>
                                </th>
                                 <th class="n_w_">
                                    Recall
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php echo $withdrawFinance; ?>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane table-responsive" id="pend">
                   <?php if(isset($holder0)){ ?>
                        <?php if($holder0=''){ ?>
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
                            <tbody id="balancebonus">
                            <?= $holder0?>
                            </tbody>
                        </table>
                       <?php } ?>
                   <?php } ?>
                    <?php if(isset($holder1)){ ?>
                        <?php if($holder1!=''){ ?>

                            <a href="<?php echo base_url()?>transaction-history/excel/BONUS">Download Excel</a> | <a href="<?php echo base_url()?>transaction-history/word/BONUS">Download Doc</a> | <a href="<?php echo base_url()?>transaction-history/pdf/BONUS">Download PDF</a>
                            <table id="BalanceOperationBonus"  class="table table-striped tab-my-acct" >
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
                                <tbody id="balancebonus">
                                    <?= $holder1?>
                                </tbody>
                            </table>

                         <?php } ?>
                    <?php } ?>
                    <?php if(isset($holder2)){ ?>
                        <?php if($holder2!=''){ ?>
                            <a href="<?php echo base_url()?>transaction-history/excel/REAL_FUND_DEPOSIT">Download Excel</a> | <a href="<?php echo base_url()?>transaction-history/word/REAL_FUND_DEPOSIT">Download Doc</a> | <a href="<?php echo base_url()?>transaction-history/pdf/REAL_FUND_DEPOSIT">Download PDF</a>
                            <table id="BalanceOperationDeposit"  class="table table-striped tab-my-acct">
                                <thead>
                                <tr>
                                    <th colspan="6">
                                        <?=lang('frahis_09');?>
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
                                        <?=lang('frahis_06');?>
                                    </th>
                                     <th class="n_w_">
                                        <?=lang('frahis_07');?>
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="balancedeposit">
                                <?= $holder2?>
                                </tbody>
                            </table>
                        <?php } ?>
                    <?php } ?>
                    <?php if(isset($holder3)){ ?>
                        <?php if($holder3!=''){ ?>
                            <a href="<?php echo base_url()?>transaction-history/excel/REAL_FUND_WITHDRAW">Download Excel</a> | <a href="<?php echo base_url()?>transaction-history/word/REAL_FUND_WITHDRAW">Download Doc</a> | <a href="<?php echo base_url()?>transaction-history/pdf/REAL_FUND_WITHDRAW">Download PDF</a>
                            <table id="BalanceOperationWithdraw" class="table table-striped tab-my-acct">
                                <thead>
                                <tr>
                                    <th colspan="7">
                                        <?=lang('frahis_10');?>
                                    </th>
                                </tr>
                                <tr>
                                     <th class="n_w_">
                                        <?=lang('frahis_02');?>
                                    </th>
                                     <th class="n_w_">
                                        <?=lang('frahis_04');?>
                                    </th>
                                     <th class="n_w_">
                                        <?=lang('frahis_05');?>
                                    </th>
                                     <th class="n_w_">
                                        <?=lang('frahis_06');?>
                                    </th>
                                     <th class="n_w_">
                                        <?=lang('frahis_07');?>
                                    </th>
                                     <th class="n_w_">
                                        Status
                                    </th>
                                     <th class="n_w_">
                                        Comment
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="balancewithdraw">
                                <?= $holder3?>
                                </tbody>
                            </table>
                        <?php } ?>
                    <?php } ?>
                    <?php if(isset($holder4)){ ?>
                        <?php if($holder4!=''){ ?>
                            <a href="<?php echo base_url()?>transaction-history/excel/REAL_FUND_TRANSFER">Download Excel</a> | <a href="<?php echo base_url()?>transaction-history/word/REAL_FUND_TRANSFER">Download Doc</a> | <a href="<?php echo base_url()?>transaction-history/pdf/REAL_FUND_TRANSFER">Download PDF</a>
                            <table id="BalanceOperationTransfer" class="table table-striped tab-my-acct">
                                <thead>
                                <tr>
                                    <th colspan="7">
                                        <?=lang('frahis_11');?>
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
                                        <?=lang('transfer_from');?>
                                    </th>
                                     <th class="n_w_">
                                        <?=lang('transfer_to');?>
                                    </th>
                                     <th class="n_w_">
                                        <?=lang('frahis_04');?>
                                    </th>
                                     <th class="">
                                        <?=lang('frahis_07');?>
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="balancetransfer">
                                <?= $holder4?>
                                </tbody>
                            </table>
                        <?php } ?>
                    <?php } ?>
                    </div>
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
    $.fn.dataTable.moment( 'YYYY-MMM-DD HH:mm:ss' );
    var url = '<?php echo FXPP::loc_url()?>';

    $('body').on('click', '.view-comment', function(){
        var comment = $(this).data('wcomment');
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
            "order": [[ 5, "desc" ]]
        });

        $('body').on('click', '.recall-action', function(){
            var ticket = $(this).data('ticket');    
       
            $.ajax({
                type:"POST",
                url: url+"transaction_history/updateWithdrawTransaction",
                data: { ticket: ticket },
                dataType: 'json',
                beforeSend: function(){
                    $('#loader-holder').show();
                },
                success: function(x){
                    $('#loader-holder').hide();
                    bootbox.alert({
                        title: 'Recall Withdraw',
                        message: 'Your recall withdrawal request has now been sent to our support manager.',
                        show: true
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#loader-holder').hide();
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        })

    });

</script>

<?php if(isset($holder0)){ ?>
    <?php if($holder0=''){ ?>
        Incomplete
    <?php } ?>
<?php } ?>
<?php if(isset($holder1)){ ?>
    <?php if($holder1!=''){ ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#BalanceOperationBonus').DataTable({
                    "order": [[ 4, "desc" ]]
                });
            });
        </script>
    <?php } ?>
<?php } ?>
<?php if(isset($holder2)){ ?>
    <?php if($holder2!=''){ ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#BalanceOperationDeposit').DataTable({
                    "order": [[ 5, "desc" ]]
                });
            });
        </script>
    <?php } ?>
<?php } ?>
<?php if(isset($holder3)){ ?>
    <?php if($holder3!=''){ ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#BalanceOperationWithdraw').DataTable({
            "order": [[ 4, "desc" ]]
        });
    });
</script>
    <?php } ?>
<?php } ?>
<?php if(isset($holder4)){ ?>
    <?php if($holder4!=''){ ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#BalanceOperationTransfer').DataTable({
            "order": [[ 5, "desc" ]]
        })
    });
</script>
    <?php } ?>
<?php } ?>