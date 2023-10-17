
        <div role="tabpanel" class="tab-pane active" id="tab1">
            <div class="row">
                <div class="col-sm-12 rebate-child-container">
                   <!-- <a href="" data-toggle="modal" data-target="#successful-registration-bonus" class="login-external" id="create_affiliate"><button class="btn-login">Create Project</button></a>-->
                </div>
            </div>
            <div class="rebate-system-table table-responsive">
                <form action="" method="post">
                <table class="table table-striped part-table">
                    <thead>
                    <tr>
                        <th><?= lang('reb_txt_9'); ?></th>
                        <th><?= lang('reb_txt_15'); ?></th>
                        <!--<th>New Value</th>
                       <th><?= lang('reb_txt_20'); ?></th>-->
                        <th><?= lang('reb_txt_14'); ?></th>
                        <th><?= lang('reb_txt_13'); ?></th>

                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= lang('reb_txt_16'); ?></td>
                            <td><select class="form-control" id="rebate" name="spread" style="width: 300px;">
                                    <?=$spread;?>
                                </select></td>
                            <td><?php
                                $spared = $project->spread?"&g=".$project->spread:'&g=251';
                                echo FXPP::www_url('register?id='.$affiliate_code).$spared;?></td>
                            <td><button type="submit" class="btn  btn-login"><?= lang('reb_txt_17'); ?></button></td>

                        </tr>

                    </tbody>
                </table>
                </form>
            </div>
        </div>

        <script>
            $(".affiliate-code span").text('<?=FXPP::www_url('register?id='.$affiliate_code).$spared;?>');
        </script>


        <div class="modal fade" id="successful-registration-bonus" tabindex="-1" role="dialog" aria-labelledby="">
            <div class="modal-dialog round-0">
                <div class="modal-content bonus-modal-container ex-modal-content round-0">
                    <div class="modal-header ex-modal-header round-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title-sub ex-modal-title"><?= lang('reb_txt_18'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" class="form-horizontal">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?= lang('reb_txt_9'); ?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="project_name" name="project_name" placeholder="<?= lang('reb_txt_9'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?= lang('reb_txt_15'); ?></label>
                                <div class="col-sm-9">

                                    <select class="form-control" id="rebate" name="spread" >
                                        <?=$spread;?>
                                    </select>

                                </div>
                            </div>
                            <!--<div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">New value</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="new_value" name="new_value" placeholder="New value">
                                </div>
                            </div>-->
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn  btn-login"><?= lang('reb_txt_17'); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script>

            function update(id){
                var base_url = '<?=FXPP::ajax_url('spread_projects/update')?>';

                $("#loader-holder").show();
                var st =    $('#status'+id).val();
                var periodicity = $('#p'+id).val();

                $.post(base_url,{id:id,periodicity:periodicity,st:st},function(data){
                    if(st==0){
                        $("#row"+id).remove();
                    }
                    $("#loader-holder").hide();
                })
            }
        </script>



