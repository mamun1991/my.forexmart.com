

<div role="tabpanel" class="tab-pane active" id="tab2">
    <div class="row">
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
                <a class="rebate-searchbutton"><button class="btn-login"><?= lang('search_btn'); ?></button></a>
            </div>
        </div>
    </div>

    <div class="rebate-system-table table-responsive">
        <table class="table table-striped part-table">
            <thead>
            <tr>
                <th><?=lang('mya_19');?></th>
                <th><?= lang('reb_txt_20'); ?></th>
                <th><?= lang('reb_txt_19'); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <form action="" method="post">


                    <!-- <td class="center"><?= lang('no_records_found'); ?></td>-->
                    <td>
                        <select name="account" class="dropdown-account-numbers form-control round-0">
                            <option value="" >Select</option>
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
                                <option value="1">Daily</option>
                                <option value="2">Weekly</option>
                                <option value="3">Monthly</option>
                            </select>
                        </div>

                    </td>
                    <td>
                        <input type="text" name="rebate" class="form-control round-0 rebate-system-textbox">
                        <button type="submit" class="btn-remove-avatar btn-rebate-add"><?= lang('reb_txt_21'); ?></button>
                        <button class="btn-remove-avatar btn-rebate-add-min"><span></span></button>
                    </td>


                </form>
            </tr>

            <?php

            if($rebate){

                foreach($rebate as $d){ ?>


                    <tr>
                        <td><?=$d->account_number?></td>
                        <td><?=isset($periodicity[$d->periodicity])?$periodicity[$d->periodicity]:""?></td>
                        <td><?=$d->rebate?></td>

                    </tr>

                <?php   }
            }

            ?>
            </tbody>
        </table>
    </div>
</div>
