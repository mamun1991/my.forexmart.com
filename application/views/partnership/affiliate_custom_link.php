<?php include_once('partnership_nav.php') ?>

<style type="text/css">
    ul#ul_affiliate {
        list-style: none;
        margin: 0 !important;
        padding: 0 !important;
    }
    i.fa-minus{
        color: red;
    }
    div.margin-ref{
        margin-top: 15px;
        width: 100%;
    }
    a.cursor{
        cursor: pointer;
    }
    input.red-border{
        border-color: red;
    }
    p.err-affiliate{
        color: red;
    }
    .validation-error p {
        color: firebrick;
        font-size: 14px;
        text-align: center;
        background-color: #f2dede;
        padding: 10px;
    }

</style>

<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="clicks">
        <div class="row">
            <div class="col-sm-12">
                <p class="part-text">
                    <?=lang('acl_00')?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <a class="login-external" id="create_affiliate"><button class="btn-login"><?=lang('acl_01')?></button></a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped part-table">
                <thead>
                    <tr>
                        <th style="text-align: center;"><?=lang('acl_02')?></th>
                        <th style="text-align: center;"><?=lang('acl_03')?></th>
                    </tr>
                </thead>
                <tbody id="tb-affiliate">
                    <?php echo $partners_affiliate; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div id="show-create-affiliate-modal" class="modal fade">
    <div class="modal-dialog modal_dialog_AS">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?=lang('acl_01')?></h4>
            </div>
            <form action="" id="create-affiliate-link" method="post" >
                <div class="modal-body">

<!--                    <div class="validation-result validation-error bg-error" id="validation-result"></div>-->

                    <div class="input-group margin-ref ig">
                        <input type="text" class="affiliate_link form-control round-0" name="affiliate_link" placeholder="Enter affiliate code" maxlength="10">
                    </div>
                    <p class="err-affiliate"></p>
                    <div id="affiliate-link-holder"> </div>
<!--                    <ul id="ul_affiliate"></ul>-->


                    <div class="input-group ig col-centered">
                        <button type="button" class="btn-submit" id="btn-submit-affiliate"><?=lang('perdet_11')?></button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<?php /** Preloader Modal Start */ ?>
<div id="loader-holder" class="loader-holder">
    <div class="loader">
        <div class="loader-inner ball-pulse">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>
<?php /** Preloader Modal End */ ?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#create_affiliate').click(function(){
            $('#show-create-affiliate-modal').modal('toggle');
        });

//        jQuery('#add_affiliate').click(function(){
//            var website_html = '<li class="li-affiliate"><div class="input-group margin-ref"><input type="text" placeholder="Custom Affiliate Link" class="affiliate_link form-control round-0" name="affiliate_link[]"/><div class="input-group-addon round-0"><a class="cursor" id="remove_affiliate"><i class="fa fa-minus"></i></a></div></p></div><p class="err-affiliate"></li>';
//            jQuery("#ul_affiliate").append(website_html);
//        });
//
//
//        jQuery('#ul_affiliate').on('click', 'a#remove_affiliate', function(){
//            jQuery(this).closest("li").remove();
//        });


        $('#show-create-affiliate-modal').on('hidden.bs.modal', function () {
            $('.li-affiliate').remove();
            $('input.affiliate_link').removeClass('red-border');
            $('input.affiliate_link').val('');
            $('div.validation-error').find('p').remove();
            $('div.affiliate_link_app').remove();
            $('p.err-affiliate').html('');
        });

        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });

        $('form#create-affiliate-link').on('click', '#btn-submit-affiliate', function(){
            var submit = true;
            $('input.affiliate_link').each(function(){

                if('' == jQuery(this).val()){
                    $(this).addClass('red-border');
                    submit = false;
                }

                if(checkString($(this).val(), ["forum", "bonus", "monitoring", "admin", "forexmart", "advertising", "promotion"])){
                    $(this).addClass('red-border');
                    $(this).parent().next('p.err-affiliate').html('Affiliate Code contains invalid word.');
                    submit = false;
                }


            });

            if(submit){
                var url = "<?php echo FXPP::ajax_url();?>";
                $.ajax({
                    type: "POST",
                    url: url+'partnership/create_affiliate_link',
                    data: $('form#create-affiliate-link').serialize(),
                    dataType: 'json',
                    beforeSend: function(){
                        $('#loader-holder').show();
                    },
                    success: function(response){
                        if(!response.error){
                            var readonly_html = '<div class="input-group margin-ref affiliate_link_app" style="margin-bottom: 10px;"><input type="text" placeholder="Custom Affiliate Link" readonly value="https://www.forexmart.com/register?id='+response.affiliate+'" class="affiliate_link form-control round-0"/></div>';
                            $("div#affiliate-link-holder").append(readonly_html);
                            $('tbody#tb-affiliate').html(response.result);
                            $('#show-create-affiliate-modal').hide();
                        }else{
                            $('p.err-affiliate').html(response.message);
                            $('input.affiliate_link').addClass('red-border');

                        }
                        $('#loader-holder').hide();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('#loader-holder').hide();
                    }
                })
            }

        });

    });

    function checkString(str, items){
        for(var i in items){
            var item = items[i];
            if (str.indexOf(item) > -1){
                return true;
            }

        }
        return false;
    }
</script>