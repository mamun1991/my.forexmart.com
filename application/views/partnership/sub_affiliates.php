<?php include_once('partnership_nav.php') ?>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="commission">
        <div class="row">
            <div class="col-sm-12">
                <p class="part-text"></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="section">
                    <div class="tab-content acct-cont admin-tab-cont">
                        <div role="tabpanel" class="row tab-pane active" id="tab1">
                            <h3 class="sub-IB-title"><?=lang('oth_com_20');?></h3>
                            <div class="sub-IB-wrapper">
                                <div class="table-responsive text-center" style="overflow-x: hidden">

                                    <table id ="sub_affiliates" class="table table-bordered table-compress">
                                        <thead>
                                        <tr>
                                            <?php

                                            foreach($ref_table as $d){

                                                echo "<th>".$d."</th>";
                                                
                                            }
                                            ?>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>




                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12"></div>
    </div>
</div>

<div class="modal fade" id="accountreferrals" tabindex="-1"  data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog round-0 " style="width: 870px;">
        <div  class="modal-content round-0 ">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center modal-show-title">Referrals of account <span id="code_num"></span></h4>
            </div>
            <div class="modal-body">
                <div class="row table-responsive table-data">
                    <table class="table table-bordered table-striped dataTable style-form-table" id="tblAccountReferrals">
                        <thead>
                        <tr role="row">
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 115px;"><?=lang('oth_com_20_6');?></th>
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 115px;"><?=lang('oth_com_20_7');?></th>
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 115px;"><?=lang('oth_com_20_8');?></th>
<!--                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 115px;">--><?//=lang('oth_com_20_9');?><!--</th>-->
                        </tr>
                        </thead>
                        <tbody id="tblRows">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>


<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js" ></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/dataTables.bootstrap.min.css"/>


<script>
    var site_url="<?=site_url('')?>";
    var table = $('#tblAccountReferrals').DataTable();

    $(document).ready(function() {
        var ajax_url = '/partnership/getSubAffiliates';

            $('#sub_affiliates').DataTable().destroy();
            jQuery('#sub_affiliates').on('preXhr.dt', function (e, settings, data) {
                $('#sub_affiliates tbody').html('<div id ="loading_rec" style="text-align:center;"><tr><td colspan="6">Loading records<img src="<?=$this->template->Images()?>loading.gif" /></td></tr></div>');
            }).on('xhr.dt', function (e, settings, json, xhr) {
                $("#loading_rec").hide();
            }).DataTable({
                "bJQueryUI": true,
                "destroy": true,
                "processing": false,
                "serverSide": true,
                "bFilter": true,
                "bSort": true,
                "searching": false,
                "order": [[0, "desc"]],
                "columnDefs": [{
                    "targets": 0,
                    "className": 'account'
                }],
                "ajax": {
                    "url": ajax_url,
                    "type": "POST",
                    "data": function (d) {
                        return $.extend( {}, d, {
                            "extra_search": $('#search').val()
                        } );
                    }
                }
            });


    });

    $(document).on('click', '.affiliates', function(){
        var ajax_url = '/partnership/getlevelTwoReferrals';
        var account = $(this).data('code');
        $.ajax({
            type: 'POST',
            url: ajax_url,
            dataType: 'json',
            data: {  account:account },
            beforeSend: function(){   $('#tblAccountReferrals tbody').html('<div id ="loading_rec" style="text-align:center;"><tr><td colspan="4">Loading records<img src="<?=$this->template->Images()?>loading.gif" /></td></tr></div>');  },
            success: function(data) {
                table.destroy();
                $('#tblRows').html(data.referrals);
                table = $('#tblAccountReferrals').DataTable({
                    "bSort": false,
                    "ordering": false,
                    "info":     true
                });
                $("#code_num").text(account);
                $('#accountreferrals').modal('show');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //  hideloader();
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    });


</script>
