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

                                        <table id ="first-level-tab" class="table table-bordered table-compress">
                                            <thead>
                                            <tr>
                                                <?php if($sub_permission){ ?>
                                                <?php if(isset($sub_permission[3])){ ?><th><?=lang('oth_com_20_1');?> </th><?php } ?>
                                                <th><?=lang('oth_com_20_2');?></th>
                                                <?php if(isset($sub_permission[4])){ ?><th><?=lang('oth_com_20_3');?></th><?php } ?>
                                                <?php if ($_SESSION['user_id'] == 363966 || $_SESSION['user_id'] == 358928){ ?>
                                                <?php if(isset($sub_permission[0])){ ?><th>Name</th><?php } ?>
                                                <?php if(isset($sub_permission[1])){ ?><th>Email</th><?php } ?>
                                                <?php if(isset($sub_permission[2])){ ?><th>Phone No</th><?php } ?>
                                                <?php } ?>

                                                <?php }else{ ?>
                                                    <th><?=lang('oth_com_20_1');?> </th>
                                                    <th><?=lang('oth_com_20_2');?></th>
                                                    <th><?=lang('oth_com_20_3');?></th>

                                                <?php  }?>
                                                <th></th>
                                            </tr>
                                            </thead>

                                            <tbody>

                                            <?php if(count($info_sub_ib) > 0) { ?>
                                                <?php foreach ($info_sub_ib as $key => $value) {
                                                    if($sub_permission){
                                                        ?>
                                                    <tr>
                                                        <?php if(isset($sub_permission[3])){ ?><td><?= $value['registration_date']; ?></td><?php } ?>
                                                        <td><?= $value['account_number']; ?></td>
                                                        <?php if(isset($sub_permission[4])){ ?><td><?= $value['total_referral']; ?></td><?php } ?>

                                                        <?php if ($_SESSION['user_id'] == 363966 || $_SESSION['user_id'] == 358928){ ?>

                                                        <?php if(isset($sub_permission[0])){ ?><td><?= $value['name']; ?></td><?php } ?>
                                                        <?php if(isset($sub_permission[1])){ ?><td><?= $value['email']; ?></td><?php } ?>
                                                        <?php if(isset($sub_permission[2])){ ?><td><?= $value['phone_no']; ?></td><?php } ?>
                                                        <?php } ?>
                                                        <td><button class="affiliates" style="color: #fff!important;margin: 0 auto;transition: all ease 0.3s;background: #29a643;border: none;width: 50px;padding: 5px;" data-code="<?= $value['affiliate_code']; ?>"><?=lang('oth_com_20_4');?></button></td>
                                                    </tr>
                                                        <?php
                                                    } else {
                                                        ?>
                                                    <tr>
                                                        <td><?= $value['registration_date']; ?></td>
                                                        <td><?= $value['account_number']; ?></td>
                                                        <td><?= $value['total_referral']; ?></td>

                                                        <td><button class="affiliates" style="color: #fff!important;margin: 0 auto;transition: all ease 0.3s;background: #29a643;border: none;width: 50px;padding: 5px;" data-code="<?= $value['affiliate_code']; ?>"><?=lang('oth_com_20_4');?></button></td>
                                                    </tr>
                                                        <?php
                                                    }
                                                    ?>


                                                    <?php } } ?>

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
                <h4 class="modal-title text-center modal-show-title"><?=lang('oth_com_20_5');?> <span id="code_num"></span></h4>
            </div>
            <div class="modal-body">
                <div class="row table-responsive table-data">
                    <table class="table table-bordered table-striped dataTable style-form-table" id="tblAccountReferrals">
                        <thead>
                        <tr role="row">
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 115px;"><?=lang('oth_com_20_6');?></th>
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 115px;"><?=lang('oth_com_20_7');?></th>
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 115px;"><?=lang('oth_com_20_8');?></th>
                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 115px;"><?=lang('oth_com_20_9');?></th>
                        </tr>
                        </thead>
                        <tbody id="tblRows">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
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

            cpa_table = $('#first-level-tab').DataTable({
                "order": [[ 0, "desc" ]], "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            });

        });

    $(document).on('click', '.affiliates', function(){
        var code = $(this).data('code');
        $.ajax({
            type: 'POST',
            url: "<?php echo FXPP::ajax_url('partnership/GetLevelThreeRef')?>",
            dataType: 'json',
            data: {  code:code },
            beforeSend: function(){  showloader();  },
            success: function(data) {
                table.destroy();
                $('#tblRows').html(data.referrals);
                table = $('#tblAccountReferrals').DataTable({
                    "bSort": false,
                    "ordering": false,
                    "info":     true,
					"language": {
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
                hideloader();
                $("#code_num").text(code);
                $('#accountreferrals').modal('show');
            },
            error: function (xhr, ajaxOptions, thrownError) {
              //  hideloader();
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    });

    function showloader(){
        $('#loader-holder').removeClass('holder-hide');
        $('#loader-holder').addClass('holder-show');
    }
    function hideloader(){
        $('#loader-holder').addClass('holder-hide');
        $('#loader-holder').removeClass('holder-show');
    }


</script>
