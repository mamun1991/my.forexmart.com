
<div role="tabpanel" class="tab-pane active" id="tab1">
    <div class="row">
        <div class="col-sm-12 rebate-child-container">
            <?php  if(validation_errors()){ ?>
            <div class="form-group">
                <div class="col-sm-10">
                    <div class="alert alert-danger center" role="alert">
                        <p> <?php echo validation_errors();?></p>
                    </div>
                </div>
            </div>

            <?php } ?>

            <a href="" data-toggle="modal" data-target="#successful-registration-bonus" class="login-external" id="create_affiliate"><button class="btn-login"><?= lang('reb_txt_8'); ?></button></a>
        </div>
    </div>
    <div class="rebate-system-table table-responsive">
        <table class="table table-striped part-table">
            <thead>
                <tr>
                    <th><?= lang('reb_txt_9'); ?></th>
                    <th><?= lang('reb_txt_10'); ?></th>
                    <th><?= lang('reb_txt_11'); ?></th>
                    <th><?= lang('reb_txt_12'); ?></th>
                    <th colspan="2"><?= lang('reb_txt_13'); ?></th>
                </tr>
            </thead>
            <tbody>

                <?php
                $rebate = 0.0;
                if (sizeof($project) > 0) {
                    foreach ($project as $d) {
                        if ($d->status == 1) {
                            $rebate = $d->new_value;
                        }
                        if ($d->status != 0) {
                            ?>
                            <tr id="<?= $d->id; ?>">
                                <td><?= $d->project_name; ?></td>
                                <td><?= number_format($rebate_amount, 2); //$d->rebate;  ?></td>
                                <td  id="new_rebate<?= $d->id; ?>"><?= $d->new_value; ?></td>
                                <td>
                                    <div class="select-action">
                                        <select id="p<?= $d->id; ?>" class="form-control round-0">
                                            <option value=""> <?= lang('txt_select'); ?></option>
                                            <option value="1" <?= ($d->periodicity == 1) ? "selected" : "" ?>><?= lang('txt_Daily'); ?></option>
                                            <option value="2" <?= ($d->periodicity == 2) ? "selected" : "" ?> ><?= lang('txt_Weekly'); ?></option>

                                            <option value="3" <?= ($d->periodicity == 3) ? "selected" : "" ?>><?= lang('txt_Monthly'); ?></option>


                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="select-action">
                                        <select id="status<?= $d->id; ?>" class="form-control round-0 project_status">
                                            <option value="1" <?= ($d->status == 1) ? "selected" : "" ?>><?= lang('txt_Active'); ?></option>
                                            <option value="2" <?= ($d->status == 2) ? "selected" : "" ?> ><?= lang('txt_Deactivated'); ?></option>
                                            <option value="0" <?= ($d->status == 0) ? "selected" : "" ?>><?= lang('txt_Deleted'); ?></option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <button onclick="update('<?= $d->id; ?>')" type="button" class="btn-remove-avatar btn-rebate-update"><?= lang('update'); ?></button>
                                </td>
                            </tr>

                        <?php
                        }
                    }
                } else {
                    ?>
                <td colspan="4" class="center"><?= lang('no_records_found'); ?></td>
                <td>
                    <div class="select-action">
                        <select class="form-control round-0">
                            <option><?= lang('txt_Active'); ?></option>
                            <option><?= lang('txt_Deactivated'); ?></option>
                            <option><?= lang('txt_Deleted'); ?></option>
                        </select>
                    </div>
                </td>
                <td>
                    <button class="btn-remove-avatar btn-rebate-update"><?= lang('update'); ?></button>
                </td>
                </tr>
<?php } ?>
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="successful-registration-bonus" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content bonus-modal-container ex-modal-content round-0">
            <div class="modal-header ex-modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title-sub ex-modal-title"><?= lang('reb_txt_18'); ?></h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="form-horizontal rebate_form">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label"><?= lang('reb_txt_9'); ?></label>
                        <div class="col-sm-9 project_name_error">
                            <input type="text" class="form-control project_name" id="project_name" name="project_name" placeholder="<?= lang('reb_txt_9'); ?>">
                            <span class="red"><?php echo form_error('project_name'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label"><?= lang('reb_txt_19'); ?></label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control rebate" id="rebate" name="rebate" value="<?= number_format($rebate_amount, 2); ?>">
                            <span class="red"><?php echo form_error('rebate'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">New Value (%)</label>
                        <div class="col-sm-9 new_value_error">
                            

                                <input type="number" class="form-control new_value" id="new_value" name="new_value" min ="1" max=" <?= $max_value; ?>" placeholder="New value" list="numbers" required>
                                <datalist id="numbers">
                                   <?= $list_option; ?>
                                </datalist>
                      
                            <span class="red" id="error_msg"> <?php echo form_error('new_value'); ?> <?=  $rebate_msg; ?>  </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" id="submit_rebate_system" class="btn  btn-login"><?= lang('reb_txt_17'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="msg" class="modal fade" id="successful-registration-bonus" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content bonus-modal-container ex-modal-content round-0">
            <div class="modal-header ex-modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title-sub ex-modal-title"><?= lang('reb_txt_18'); ?></h4>
            </div>
            <div class="modal-body">
                <div id="msg_body"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var max_rebate = '<?= $max_value; ?>';
    $(document).ready(function () {
        $(document).on('click', '#submit_rebate_system', function (e) {
            e.preventDefault();
            //alert('dsfdf');
            var rebate_submit = false;
            var project_name = $('.project_name').val();
            var new_value = $('.new_value').val();
            
            if (project_name != '') {
                $('.pull_name').hide();
                rebate_submit = true;

            } else {
                $('.pull_name').hide();
                $('.project_name_error').append('<span class="red pull_name">Please fill in.</span>');
                rebate_submit = false;
                return false;
            }
            if (new_value != '') {
                $('.pull_name').hide();
                rebate_submit = true;

            } else {
                $('.pull_name').hide();
                $('.new_value_error').append('<span class="red pull-r pull_name">Please fill in.</span>');
                rebate_submit = false;
                return false;
            }
            if ($('.new_value').hasClass('not-valid')) {
                $("#error_msg").show();
                rebate_submit = false;
                return false;
            }
            if (rebate_submit == true) {
                $(".rebate_form").submit();
            }

        });
    });
</script>

<script>

    function update(id) {
        var base_url = '<?= FXPP::ajax_url('rebate_system/update') ?>';


        var st = $('#status' + id).val();
        var periodicity = $('#p' + id).val();
        var active = 0;
        $(".project_status").each(function () {


            if ($(this).val() == 1) {
                active++;
            }
        })

        if (active > 1) {
            //alert("Only one project can be active");
            $("#msg_body").html("Only one project can be active")
            $("#msg").modal('show');
            $('#status' + id).val(0);
        } else {

            $.post(base_url, {id: id, periodicity: periodicity, st: st}, function (data) {
                $("#rebate").val($('#new_rebate' + id).text());
                //alert(data);
                $("#msg_body").html(data)
                $("#msg").modal('show');
                if (st == 0) {
                    $("#" + id).remove();
                }
            })
        }

        active = 0;

    }

//    $("#new_value").attr({
//        "max" : 3,
//        "min" : 3
//    });

    $(document).on("keyup", "#new_value", function () {

        /* var new_rebate =$(this).val();
         
         if( new_rebate<=0.8 ){
         $("#error_msg").hide();
         }else{
         $("#error_msg").show();
         $(this).val('');
         }*/

    })
    $(document).on("blur", "#new_value", function () {


        var new_rebate = $(this).val();
        if (new_rebate > 0 && new_rebate <= max_rebate) {
            $("#error_msg").hide();
            $(this).removeClass('not-valid');
            console.log('check');
        } else {
            $("#error_msg").show();
           // $(this).val('');
            $(this).addClass('not-valid');
            console.log('not check');

        }



      /*

       var account_number = <?//= $account_number; ?>;
      if (account_number == '264409' || account_number == '109369') {
            var new_rebate = $(this).val();

//            if (new_rebate > 0 && new_rebate <= 1)
            if (new_rebate > 0 && new_rebate <= 100) {
                $("#error_msg").hide();
            } else {
                $("#error_msg").show();
               // $(this).val('');
            }
        } else if(account_number == '209874' || account_number == '231902') {
            var new_rebate = $(this).val();
            console.log(new_rebate);
//            if (new_rebate > 0 && new_rebate <= 0.9)
            if (new_rebate > 0 && new_rebate <= 90) {
                $("#error_msg").hide();
            } else {
                $("#error_msg").show();
                $(this).val('');
            }
        }else{
            var new_rebate = $(this).val();
//            if (new_rebate > 0 && new_rebate <= 0.8)
            if (new_rebate > 0 && new_rebate <= 80) {
                $("#error_msg").hide();
            } else {
                $("#error_msg").show();
                $(this).val('Max Value is 80%');
            }
        }*/





    })

    $(document).on('change', '.project_status', function () {

        var id = $(this).val();
        var active = 0;
        $(".project_status").each(function () {


            if ($(this).val() == 1) {
                active++;
            }
        })

        if (active > 1) {
            // alert("Only one project can be active");
            $("#msg_body").html("Only one project can be active")
            $("#msg").modal('show');
            $(this).val(0);
        }
    })
</script>
<style>
    #error_msg{display: none;color: red;}
    #msg_body{ 
        text-align: center;
        font-weight: bold;
        margin-right: 8px;
    }
    .red{
        color: red;
    }
</style>
