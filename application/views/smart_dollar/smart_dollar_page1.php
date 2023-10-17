
<div class="col-sm-12 full">
        <div class="col-sm-3 full">

        </div>

        <div class="col-sm-12 smart-dollars">
            <h3>Smart Dollars</h3>
            <div class="smart-dollars-title">
                <div class="smart-dollars-big-title box shadow-effect">
                    <h1>Smart Dollars by <b>ForexMart</b></h1>
                </div>
                <p>Trade 2 lots to start getting ForexMart Smart Dollar to your account</p><br>
                <h3>You have closed <b><span class="lots-traded">0</span></b> lots</h3>
                <h3>You are only  <b><span class="value total-lots">0</span></b> lots left to trade</h3><br>
                <button class="activate" disabled ><h5> A C T I V A T E</h5></button><br>
                <?php switch(strtolower(FXPP::html_url())){
                    case 'my':
                        $link = 'https://my.forexmart.com/assets/pdf/Loyalty Program Smart Dollars MY.pdf';break;
                    case 'id':
                        $link = 'https://my.forexmart.com/assets/pdf/Loyalty Program Smart Dollars ID.pdf';break;
                    default:
                        $link = 'https://s-my.forexmart.com//assets/pdf/Loyalty Program Smart Dollars.pdf';break;

                } ?>
                <p class="terms-condition">by clicking Activate button I agree with the  <a href="<?= $link ?>" class="agreement" target="_blank">Terms and conditions.</a></p>
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
<div id="confirmModal" class="modal fade">
    <div class="modal-dialog confirm-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title conf-modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <p class="conf-modal-desc"> I agree with the <a href="<?= $link ?>" class="agreement" target="_blank">Terms and conditions.</a></p>
            </div>

            <div class="modal-footer">
                <input type="button" class="btn btn-danger" id ='confirm' value="Confirm">
            </div>

        </div>
    </div>
</div>

<script type ="text/javascript">
    var base_url = "<?=FXPP::ajax_url();?>";

    $(document).ready(function() {
        $('.badge-smart-dollar').css('display', 'none');

        jQuery.ajax({
            type: "POST",
            url: base_url + "smartdollar/getTotalLots",
            dataType: 'json',
            beforeSend: function () {
                $('#loader-holder').show();
            },
            success: function (x) {
                $('#loader-holder').hide();
                $('.total-lots').html(x.lots_left);
                $('.lots-traded').html(x.total_traded_lots);
                if(x.enable){
                    $('.activate').attr('disabled',false);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#loader-holder').hide();
                console.log(xhr.status);
                console.log(thrownError);
            }
        });


    });

    $(document).on('click', '.activate', function(){
        $('#confirmModal')
            .modal({ backdrop: 'static', keyboard: false })
            .on('click', '#confirm', function (e) {
                jQuery.ajax({
                    type: "POST",
                    url: base_url + "smartdollar/activateSmartDollar",
                    dataType: 'json',
                    beforeSend: function () {
                        $('#loader-holder').show();
                    },
                    success: function (x) {
                        $('#loader-holder').hide();
                        if (x.success) {
                            window.location.reload(true);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('#loader-holder').hide();
                        console.log(xhr.status);
                        console.log(thrownError);
                    }
                });
            });

    });



</script>