<div class="acct-tab-holder">
    <ul role="tablist" class="main-tab">
        <li><a href="<?php echo base_url();?>settings" class="<?php echo $active_sub_tab == 'reply-to' ? 'acct-active' : '' ?>">Reply-to</a></li>
        <li><a href="<?php echo base_url();?>settings/language" class="<?php echo $active_sub_tab == 'language' ? 'acct-active' : '' ?>">Language</a></li>
        <li><a href="<?php echo base_url();?>settings/scheme" class="<?php echo $active_sub_tab == 'scheme' ? 'acct-active' : '' ?>">Scheme</a></li>
    </ul><div class="clearfix"></div>
</div>
<div class="tab-content acct-cont admin-tab-cont">
    <div role="tabpanel" class="row tab-pane active" id="tab3">
        <div class="col-md-8 add-scheme-form" id="add-scheme-form">
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Name of Scheme :</label>
                    <div class="col-sm-8">
                        <input type="type" class="form-control round-0" id="" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Repeats :</label>
                    <div class="col-sm-8">
                        <select class="form-control round-0">
                            <option>Weekly</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Repeats every :</label>
                    <div class="col-sm-8">
                        <select class="form-control round-0 short-text">
                            <option>1</option>
                        </select>
                        weeks
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <button class="btn-add">Add</button>
                        <button class="btn-cancel-add" data-dismiss="add-scheme-form" aria-label="Close">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="add-scheme-holder col-md-12">
            <button class="btn-add" id="btn-add">Add</button>
        </div>
        <div class="table-responsive col-md-12">
            <table class="table table-striped reply-to-tab">
                <thead>
                <tr>
                    <th class="th-email">Scheme</th>
                    <th class="th-action">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Scheme A</td>
                    <td>
                        <a href="#"><i class="fa fa-pencil action"></i></a>
                        <a href="#"><i class="fa fa-times-circle action"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>Scheme B</td>
                    <td>
                        <a href="#"><i class="fa fa-pencil action"></i></a>
                        <a href="#"><i class="fa fa-times-circle action"></i></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            <div class="tab-line"></div>
        </div>
        <div class="col-md-6">
            <form class="form-inline">
                <div class="form-group">
                    <label for="" class="number">Number of records shown per page</label>
                    <input type="text" class="form-control round-0 number-text" id="" placeholder="">
                </div>
                <button type="submit" class="btn btn-default round-0">Go</button>
            </form>
        </div>
        <div class="col-md-6 settings-pagination">
            <nav>
                <ul class="pagination">
                    <li class=""><a href="#" aria-label=""><span aria-hidden="true">&laquo;</span></a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li class=""><a href="#">2</a></li>
                    <li class=""><a href="#">3</a></li>
                    <li class=""><a href="#">4</a></li>
                    <li class=""><a href="#" aria-label=""><span aria-hidden="true">&raquo;</span></a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script type="text/javascript">
    $( document ).ready(function() {
        $("#btn-add").click(function(){
            $("#add-scheme-form").show();
        });
    });
</script>
