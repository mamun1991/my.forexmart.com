<style>

    a.advrt:hover{
        color: #FFF;
        text-decoration: none;
    }
    a.advrt:link{
        color: #FFF;
        text-decoration: none;
    }
    a.advrt:visited{
        color: #FFF;
        text-decoration: none;
    }
    a.advrt:active{
        color: #FFF;
        text-decoration: none;
    }
    @media only screen and (max-device-width: 767px) {
        .ribbon {
            display: none;
        }
    }

    @media only screen and (max-device-width: 480px) {
        .ribbon {
            display: none;
        }
    }

    @media only screen  and (max-device-width: 381px){
        .ribbon {
            display: none;
        }
    }
    @media screen and (max-width: 329px) {
        .ribbon {
            display: none;
        }
    }

    @media screen and (min-width: 0px) and (max-width: 500px) {
        .ribbon {
            display: none;
        }
    }
    @media screen and (min-width: 100px) and (max-width: 300px){
        .cgrts{
            font-size: 12px!important;
        }
    }
    @media screen and (min-width: 0px) and (max-width: 99px){
        .cgrts{
            font-size: 8px!important;
        }
        .up-to{
            font-size: 8px!important;
        }
    }
    .c-pad{
        padding: 0px 10px;
    }

</style>

 <?php $this->lang->load('advertising_lang'); ?>
<div class="modal fade" id="popup" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close supresscookies" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modal-show-title cgrts"><?=lang('adv_01');?></h4>
            </div>
            <div class="modal-body modal-show-body">
                <div class="row">
                    <div class="no-deposit-image-holder">
                        <img src="<?= $this->template->Images()?>modal-show-img.png" class="img-responsive ribbon">
                        <img src="<?= $this->template->Images()?>logo-prev.png" width="219" height="48" class="img-responsive hidden-image-deposit c-pad"/>
                    </div>
                    <div class="sign-back">
                        <p class="modal-show-text"><?=lang('adv_02');?>
                        <p class="no-deposit-needed">
                        <?php /*echo lang('adv_03');*/ ?>
                        </p>
                        <div class="btn-modal-show-holder">
                            <a href="<?= $this->config->item('domain-www');?>/account-type" class="btn-modal-show advrt"><?=lang('adv_04');?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>