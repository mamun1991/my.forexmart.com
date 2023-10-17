<script>

    $(document).on("click","#save_language",function(){
        var base_url= "<?=site_url()?>";

        var name = $("#name").val();

        if(name.length>0){

                $.post(base_url+"settings/languageSave",{name:name},function(results){

                    if(results.respons == "error"){
                        $("#error").html(results.msg);

                    }else{
                        $("#error").html('');
                        var insert_row = '<tr><td>'+results.name+'</td><td><a id="'+results.id+'" href="#"><i class="fa fa-pencil action"></i></a><a id="'+results.id+'" href="#"><i class="fa fa-times-circle action"></i></a></td></tr>';
                        $(".table").append(insert_row);
                    }



                },'json')
         }else{
            $("#error").html('This language field is required.');
        }

     })

</script>
<style>
    .red{color: red;}
</style>


<div class="acct-tab-holder">
    <ul role="tablist" class="main-tab">
        <li><a href="<?php echo base_url();?>settings" class="<?php echo $active_sub_tab == 'reply-to' ? 'acct-active' : '' ?>">Reply-to</a></li>
        <li><a href="<?php echo base_url();?>settings/language" class="<?php echo $active_sub_tab == 'language' ? 'acct-active' : '' ?>">Language</a></li>
        <li><a href="<?php echo base_url();?>settings/scheme" class="<?php echo $active_sub_tab == 'scheme' ? 'acct-active' : '' ?>">Scheme</a></li>
    </ul><div class="clearfix"></div>
</div>
<div class="tab-content acct-cont admin-tab-cont">
    <div role="tabpanel" class="row tab-pane active">
        <div class="table-responsive col-md-12">
            <table class="table table-striped reply-to-tab">
                <thead>
                <tr>
                    <th class="th-email">Language</th>
                    <th class="th-action">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input id="name" type="text" class="form-control round-0 email-txt" name="name"> <span class="red" id="error"></span></td>
                    <td>
                        <a href="Javascript:;" id="save_language"><i class="fa fa-check-circle action"></i></a>
                        <a href="#"><i class="fa fa-times-circle action"></i></a>
                    </td>
                </tr>
                <?php
                if(sizeof($language)>0){
                 foreach( $language as $d){
                ?>
                <tr>
                    <td><?=$d->name?></td>
                    <td>
                        <a id="e<?=$d->id?>" href="#"><i class="fa fa-pencil action"></i></a>
                        <a id="d<?=$d->id?>" href="#"><i class="fa fa-times-circle action"></i></a>
                    </td>
                </tr>
                <?php }} else{ echo "<tr><td colspan='2'>No record found </td></tr>";}?>
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