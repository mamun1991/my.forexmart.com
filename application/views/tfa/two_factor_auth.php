<style>
    .modal-backdrop:lang(sa) {
        position: initial !important;
    }
    .modal-backdrop:lang(pk) {
        position: initial !important;
    }
</style>


<?php $this->lang->load('tfa'); ?>


<h1>
   <?=lang('xnv_MyAcc');?>
</h1>

<?php $this->load->view('account_nav.php');?>

<div class="tab-content acct-cont">
    <div class="row">
        <div class="col-md-12">
            <?php if($isTFASet){ ?>
                <p><?=lang('tfa_0');?></p>
                <a href="javascript:void(0);" id="tfa-verify"><?=lang('tfa_off');?></a>
            <?php }else{ ?>
                <a href="javascript:void(0);" id="tfa-setup"><?=lang('tfa_on');?></a>

 
            <?php } ?>
        </div>
    </div>
</div>

<script>

    function initTFAValidator(){

        var validator =
            $('#tfa-setup-form').validate({
                errorContainer: $('#error-container'),
                errorLabelContainer: $('#error-container'),
                wrapper: 'p',
                errorPlacement: function(error, element){
                    return true;
                },
                onfocusout: false,
                onkeyup: false,
                onclick: false,
                rules:{
                    tfa_setup_code: {
                        required: true
                    }
                },
                submitHandler: function(form){
                    $.ajax({
                        type: 'post',
                        url: 'TFASetupVerify',
                        data: $(form).serialize(),
                        dataType: 'json'
                    }).done(function(response){

                        if(response.HasError){
                            validator.showErrors({
                                'tfa_setup_code': response.Message
                            });
                        }else{
                            window.location = "two-factor-authentication";
                        }

                    });
                }
            });

    }

    $(document).ready(function() {

        $('#tfa-setup').on('click', function () {



            var ajax_url = "<?=FXPP::ajax_url('profile/TFASetup')?>";
          //  console.log(ajax_url+'---Taariq');


            $('#loader-holder').show();
            $.ajax({
                type: 'post',
                url: ajax_url,
                dataType: 'html'
            }).done(function(response){

//                console.log(response);
//                return false;


                $(response).modal();
                $('#loader-holder').hide();
            });
        });

        $('#tfa-verify').on('click', function () {
            $('#loader-holder').show();
            $.ajax({
                type: 'post',
                url: 'TFASetup',
                dataType: 'html'
            }).done(function(response){
                $(response).modal();
                $('#loader-holder').hide();
            });
        });

        $('body').on('shown.bs.modal', 'div#step1', function () {
            initTFAValidator();
        });

        $('body').on('hidden.bs.modal', 'div#step1', function () {
            $('#step1').remove();
        });

        $('body').on('click', 'button#tfa-setup-close', function(){
            $('#step1').modal('hide');
        });

    });







</script>