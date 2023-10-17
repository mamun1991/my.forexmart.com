<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>

        <div role="tabpanel" class="tab-pane active" id="tab2">
            <!--<div class="row">
                <div class="col-sm-12 rebate-child-container">
                    <select class="dropdown-account-numbers form-control round-0">
                        <option value="" >Select</option>
                        <?php /*if($referrals){
                                foreach($referrals as $d){
                            */?>
                        <option value="<?/*=$d['account_number']*/?>"><?/*=$d['account_number']*/?></option>

                        <?php /*} }*/?>
                    </select>
                    <div class="rebate-system-search">
                        <input type="text" class="form-control round-0 rebate-system-searchbar"/>
                        <a class="rebate-searchbutton"><button class="btn-login">Search</button></a>
                    </div>
                </div>
            </div>-->

            <div class="rebate-system-table table-responsive">
                <table id="spread_project" class="table table-striped part-table">
                    <thead>
                    <tr>
                        <th><?= lang('reb_txt_9'); ?></th>
                        <th class="val-spread"><?= lang('reb_txt_15'); ?></th>
                        <th><?= lang('reb_txt_22'); ?></th>
                        <th><?= lang('reb_txt_13'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                     <form action="" method="post">


                       <!-- <td class="center"><?= lang('no_records_found'); ?></td>-->
                        <td>
                            <!--<select name="account" class="dropdown-account-numbers form-control round-0">
                                <option value="" >Select</option>
                                <?php /* if($referrals){
                                    foreach($referrals as $d){
                                        */?>
                                        <option value="<?/*=$d['account_number']*/?>"><?/*=$d['account_number']*/?></option>

                                    <?php /*} }*/?>
                            </select>-->
                            <input type="text" name="project_name" class="form-control round-0 rebate-system-textbox">
                            <span class="red"><?php echo form_error('project_name'); ?></span>
                        </td>
                        <td>

                            <div class="select-action">
                                <select name="spread" class="form-control round-0 spread_value" >
                                    <?=$spread;?>
                                </select>
                            </div>

                        </td>
                        <td>
                           <!-- <input required type="text" name="affiliate_code" class="form-control round-0 rebate-system-textbox" placeholder="Affiliate code">-->
                            <select required name="affiliate_code" class="form-control round-0 rebate-system-textbox">
                                <?php
                                    if($affiliate_code_all){
                                        foreach($affiliate_code_all as $d){
                                            ?>

                                            <option value="<?=$d->affiliate_code?>"><?=$d->affiliate_code?></option>
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                            <span class="red"><?php echo form_error('affiliate_code'); ?></span>

                        </td>
                         <td>
                             <button type="submit" class="btn-remove-avatar "><?= lang('reb_txt_21'); ?></button>
                             <button class="btn-remove-avatar btn-rebate-add-min"><span></span></button>
                         </td>


                     </form>
                    </tr>

                    <?php

                            if($rebate){

                                foreach($rebate as $d){ ?>


                                    <tr>
                                        <td><?=$d->project_name?></td>
                                        <td><?=$spread_list[$d->spread];?></td>
                                        <td><?=FXPP::www_url()."register?id=".$d->affiliate_code."&g=".$d->spread?>
                                            </td>
                                        <td><a href="<?=FXPP::ajax_url()."spread-projects/separate_spread_delete?id=".$d->id?>" ><button class="btn-remove-avatar"><?= lang('delete'); ?></button> </a></td>

                                    </tr>

                             <?php   }
                            }

                    ?>
                    </tbody>
                </table>
            </div>
        </div>
<style>
    .red{color: red;}
    .spread_value{width: 100px;}
    .val-spread{width: 110px!important;}
</style>
<script>
    $(document).ready(function() {


        $('#spread_project').dataTable({
            "aLengthMenu": [[4, 10, 20,30, -1], [4, 10, 20,30, "All"]],
            "iDisplayLength": 4,
            "oSearch": false,
            "bSort" : false,
            "bLengthChange": false,
            bFilter: false, bInfo: false
        });

    } );
</script>