<?php $method = $this->router->method; ?>
<?php $class = $this->router->class; ?>
<?php $this->lang->load('datatable');?>
<style type="text/css">
    .dashboard > thead > tr > th {
        text-align: center;
    }
    .dashboard > tbody > tr > td {
        text-align: center;
    }
</style>
    <h1>My Accounts</h1>
    <?php $this->load->view('account_nav.php');?>
    <div class="tab-content acct-cont">
        <div role="tabpanel" class="row tab-pane active" >
            <div class="col-sm-12">
              
            <?php $this->load->view('account_current_trades_nav');?>
                 
                <div class="clearfix">
                    <div class="tab-content cur-tab-cont">
                        <div role="tabpanel" class="table-responsive cur_tra_cont" id="tab_current_trades">
                            <table id="OpenedTrades" class="table table-striped tab-my-acct">
                               <thead>
                                <tr>
                                    <th><?=lang('curtra_04')?></th>
                                    <th><?=lang('curtra_05')?></th>
                                    <th><?=lang('curtra_06')?></th>
                                    <th><?=lang('curtra_07')?></th>
                                    <th><?=lang('curtra_08')?></th>
                                    <th><?=lang('curtra_09')?></th>
                                    <th><?=lang('curtra_10')?></th>
                                    <th><?=lang('curtra_11')?></th>
                                    <th><?=lang('curtra_12')?></th>
                                    <th><?=lang('curtra_13')?></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?= $Opened?>
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
            responsive: true,
            language: {
                emptyTable:'<?=lang('dta_tbl_01')?>',
                infoEmpty:'<?=lang('dta_tbl_03')?>',
                lengthMenu: '<?=lang('dta_tbl_07')?>',
                search: '<?=lang('dta_tbl_10')?>:',
                "paginate": {
                    "first":     '<?=lang('dta_tbl_12')?>:',
                    "last":      '<?=lang('dta_tbl_13')?>:',
                    "next":      '<?=lang('dta_tbl_14')?>:',
                    "previous":   '<?=lang('dta_tbl_15')?>:'
                },
            }
        });
    });
    $(window).resize(function() {
        $('#OpenedTrades').DataTable({
            language: {
                emptyTable:'<?=lang('dta_tbl_01')?>',
                infoEmpty:'<?=lang('dta_tbl_03')?>',
                lengthMenu: '<?=lang('dta_tbl_07')?>',
                search: '<?=lang('dta_tbl_10')?>:',
                "paginate": {
                    "first":     '<?=lang('dta_tbl_12')?>:',
                    "last":      '<?=lang('dta_tbl_13')?>:',
                    "next":      '<?=lang('dta_tbl_14')?>:',
                    "previous":   '<?=lang('dta_tbl_15')?>:'
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
