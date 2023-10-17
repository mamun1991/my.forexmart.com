
<style>
    .rebate-system-textbox {
        width: 50%!important;
    }
    .btn-rebate-add {
        max-width: 100%!important;
        margin-right: 6px!important;
   
    }
    
    .error_msg{display: none;color: red; float: left;}
    #msg_body{     text-align: center;
        font-weight: bold;
        margin-right: 8px;
    }
    .part-table td {
        text-align: center;
        vertical-align: middle;
    }
</style>

<div role="tabpanel" class="tab-pane active" id="tab2">
    <div class="row" style="display: none">
        <div class="col-sm-12 rebate-child-container">
            <select class="dropdown-account-numbers form-control round-0">
                <option value="" >Select</option>
                <?php if($referrals){
                    foreach($referrals as $d){
                        ?>
                        <option value="<?=$d['account_number']?>"><?=$d['account_number']?></option>
                    <?php } }?>
            </select>
            <div class="rebate-system-search">
                <input type="text" class="form-control round-0 rebate-system-searchbar"/>
                <a class="rebate-searchbutton"><button class="btn-login">Search</button></a>
            </div>
        </div>
    </div>

    <div class="rebate-system-table table-responsive">
        <?php if(!empty($errorMsg)){ ?>
            <div class="alert <?= $hasError ? "alert-danger" : "alert-success"; ?>" role="alert" style="margin-top: 10px;text-align:center;">
                <?= $errorMsg; ?>
            </div>
        <?php } ?>
        <table class="table table-striped part-table" id="personal_rebate_tbl">
            <thead><tr><th>#</th><th>Client</th><th><?= lang('reb_txt_19'); ?> (%)</th><th><?= lang('reb_txt_13'); ?></th></tr></thead>
            <tbody>
            <tr>
                <form action="" method="post">
                    <td>--</td>
                    <td>
                        <select required="true" id="ref_num" name="account" class="dropdown-account-numbers form-control round-0" style="margin-left:50px;">
                            <option value="" >Select</option>
                            <?php  if($referrals){
                                foreach($referrals as $d){
                                    ?>
                                    <option value="<?=$d['account_number']?>"><?=$d['account_number']?></option>

                                <?php } }?>
                        </select>
                    </td>

                    <td>
                        <input required="true" type="number" name="rebate"  min ="1" max=" <?= $max_value; ?>" onkeyup='this.value = rebateChange(this.value, 0, <?= $max_value; ?>)' class=" form-control round-0 rebate-system-textbox new_value">
                    </td>
<!--                    <td></td>-->

                    <td colspan="2">
                        <button type="submit" class="btn-remove-avatar btn-rebate-add">Add</button>
                        <span class="error_msg"> <?=  $rebate_msg; ?>   </span>
                    </td>


                </form>
            </tr>
            <?php

            if($rebate){
               echo $rebate;
            }
            ?>
            </tbody>
        </table>
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


<script>
    var max_rebate = '<?= $max_value; ?>';
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    function update(id,acct){
        var base_url = '<?=FXPP::ajax_url('rebate_systems_new/update_personal')?>';
        var pip =    $('#pip'+id).val();
        pip = pip * 0.01;
        console.log(pip); //test
        var periodicity = $('#p'+id).val();
        $.post(base_url,{id:id,recType:"update-project", rType:"PERSONAL",periodicity:periodicity,pip:pip, account: acct },function(data){
            $("#msg_body").text("Updated successfully");
            $("#msg").modal('show');
        });


    }

    function deleteAcc(id,acct){
        var base_url = '<?=FXPP::ajax_url('rebate_systems_new/delete_personal')?>';
        $.post(base_url,{id:id, recType:"update-project",rType:"PERSONAL", account: acct },function(data){
            $("#tr-"+id).remove();
            // alert('Delete successfully');
            $("#msg_body").text("Deleted successfully")
            $("#msg").modal('show');
        });


    }

    $(document).on("blur",".new_value",function(){

        var account_number = <?=$account_number; ?>;
        var new_rebate = $(this).val();
        if (new_rebate > 0 && new_rebate <= max_rebate) {
            $(this).closest('.error_msg').hide();
        } else {
            $("#error_msg").show();
            $(this).closest('.error_msg').show();
            $(this).val('');

        }


    });


    $(document).on('change','#ref_num',function(){

        var ref_num = $(this).val();

        $(".acc").each(function(){
            var acc = $(this).text();

            if( parseInt(ref_num) == parseInt(acc) ){
                  alert(acc+" is already exist.");
                $("#msg_body").html(acc+" already exists.")
                $("#msg").modal('show');
                $("#ref_num").val('');
            }

        })
    });


    function rebateChange(value, min, max) {
        if (parseInt(value) < 0 || isNaN(value))
            return 0;
        else if (parseInt(value) > max)
            return "Max value is " + max;
        else return value;
    }


</script>