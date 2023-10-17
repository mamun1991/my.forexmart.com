
<style>
    .rebate-system-textbox {
        width: 50%!important;
    }
    .btn-rebate-add {
        margin-right: 6px!important;
    }
    .error_msg{display: none;color: red; float: left;}
    #msg_body{    text-align: center;
        font-weight: bold;
        margin-right: 8px;}
</style>

        <div role="tabpanel" class="tab-pane active" id="tab2">
            <div class="row" style="display: none">
                <div class="col-sm-12 rebate-child-container">
                    <select class="dropdown-account-numbers form-control round-0">
                        <option value="" ><?= lang('txt_select'); ?></option>
                        <?php if($referrals){
                                foreach($referrals as $d){
                            ?>
                        <option value="<?=$d['account_number']?>"><?=$d['account_number']?></option>

                        <?php } }?>
                    </select>
                    <div class="rebate-system-search">
                        <input type="text" class="form-control round-0 rebate-system-searchbar"/>
                        <a class="rebate-searchbutton"><button class="btn-login"><?= lang('txt_search'); ?></button></a>
                    </div>
                </div>
            </div>

            <div class="rebate-system-table table-responsive">
                <table class="table table-striped part-table">
                    <thead>
                    <tr>
                        <th><?= lang('reb_txt_23'); ?></th>
                        <th><?= lang('reb_txt_20'); ?></th>
                        <th><?= lang('reb_txt_19'); ?> (%)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                     <form action="" method="post">


                       <!-- <td class="center"><?= lang('no_records_found'); ?></td>-->
                        <td>
                            <select required="true" id="ref_num" name="account" class="dropdown-account-numbers form-control round-0">
                                <option value="" ><?= lang('txt_select'); ?></option>
                                <?php  if($referrals){
                                    foreach($referrals as $d){
                                        ?>
                                        <option value="<?=$d['account_number']?>"><?=$d['account_number']?></option>

                                    <?php } }?>
                            </select>
                        </td>
                        <td>

                            <div class="select-action">
                                <select name="periodicity" class="form-control round-0">
                                    <option value="1"><?= lang('txt_Daily'); ?></option>
                                    <option value="2"><?= lang('txt_Weekly'); ?></option>

                                        <option value="3"><?= lang('txt_Monthly'); ?></option>

                                   <!-- <option value="3"><?= lang('txt_Monthly'); ?></option>-->
                                </select>
                            </div>

                        </td>
                        <td>

                                <input required="true" type="number" name="rebate"  min ="1" max=" <?= $max_value; ?>" class="form-control round-0 rebate-system-textbox new_value" list="percent">
                                <datalist id="percent">
                                    <?= $list_option; ?>
                                </datalist>


                            <button type="submit" class="btn-remove-avatar btn-rebate-add"><?= lang('add_button'); ?></button>
                            <span class="error_msg"> <?=  $rebate_msg; ?>   </span>
                        </td>


                     </form>
                    </tr>

                    <?php

                            if($rebate){

                                foreach($rebate as $d){ ?>


                                    <tr id="r<?=$d->id;?>">
                                        <td class="acc" id="acc<?=$d->id;?>"><?=$d->account_number?></td>
                                        <td>
                                            <select id="p<?=$d->id;?>" class="form-control round-0">
                                                <option value=""> <?= lang('txt_select'); ?></option>
                                                <option value="1" <?= ($d->periodicity==1)?"selected":"" ?>><?= lang('txt_Daily'); ?></option>
                                                <option value="2" <?= ($d->periodicity==2)?"selected":"" ?> ><?= lang('txt_Weekly'); ?></option>

                                                <option value="3" <?= ($d->periodicity==3)?"selected":"" ?>><?= lang('txt_Monthly'); ?></option>

                                            </select>

                                        </td>
                                        <td>
                                        <input id="pip<?=$d->id;?>"  type="number" value="<?=($d->rebate)*100?>" name="rebate" class="form-control round-0 rebate-system-textbox new_value" list="percent">

                                        <datalist id="percent">
                                            <?= $list_option; ?>
                                        </datalist>

                                            <button onclick="deleteAcc(<?=$d->id;?>)" type="button" class="btn-remove-avatar btn-rebate-add"><span><?= lang('delete'); ?></span></button>
                                            <button onclick="update(<?=$d->id;?>)" type="button" class="btn-remove-avatar btn-rebate-add"><?= lang('update'); ?></button>
                                            <span class="error_msg"> <?=  $rebate_msg; ?>  </span>
                                        </td>

                                    </tr>

                             <?php   }
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
    function update(id){
        var base_url = '<?=FXPP::ajax_url('rebate_system/update_personal')?>';


        var pip =    $('#pip'+id).val();
        pip = pip * 0.01;
        console.log(pip); //test
        var periodicity = $('#p'+id).val();


            $.post(base_url,{id:id,periodicity:periodicity,pip:pip},function(data){

                //alert('Update successfully');
                $("#msg_body").html("Updated successfully")
                $("#msg").modal('show');
            })


    }

    function deleteAcc(id){

            var base_url = '<?=FXPP::ajax_url('rebate_system/delete_personal')?>';
            $.post(base_url,{id:id},function(data){

                $("#r"+id).remove();
               // alert('Delete successfully');
                $("#msg_body").html("Deleted successfully")
                $("#msg").modal('show');
            })


    }

    $(document).on("keyup",".new_value",function(){

       /* var new_rebate =$(this).val();

        if( new_rebate<=0.8 ){
          $(this).closest('.error_msg').hide();
        }else{

            $(this).closest('.error_msg').show();
            $(this).val('');
        }*/

    })
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



        /*if(account_number == '264409') {
            var new_rebate = $(this).val();
//            if (new_rebate > 0 && new_rebate <= 1) {
            if (new_rebate > 0 && new_rebate <= 100) {
                $(this).closest('.error_msg').hide();
            } else {
                $(this).closest('.error_msg').show();
                $(this).val('');
            }
        }else if(account_number == '209874' || account_number == '231902') {
                var new_rebate = $(this).val();
//                console.log(new_rebate);
//                if (new_rebate > 0 && new_rebate <= 0.9) {
                if (new_rebate > 0 && new_rebate <= 90) {
                    $("#error_msg").hide();
                } else {
                    $("#error_msg").show();
                    $(this).val('');
                }
        }else{
            var new_rebate =$(this).val();
//            if(new_rebate>0 && new_rebate<=0.8 ){
            if(new_rebate>0 && new_rebate<=80 ){
                $(this).closest('.error_msg').hide();
            }else{
                $(this).closest('.error_msg').show();
                $(this).val('');
            }
        }*/


    })

    $(document).on('change','#ref_num',function(){

        var ref_num = $(this).val();

        $(".acc").each(function(){
            var acc = $(this).text();

            if( parseInt(ref_num) == parseInt(acc) ){
              //  alert(acc+" is already exist.");
                $("#msg_body").html(acc+" already exists.")
                $("#msg").modal('show');
                $("#ref_num").val('');
            }

        })
    })
</script>