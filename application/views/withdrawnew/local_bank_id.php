<div class="col-lg-12 col-md-12 col-sm-12 int-main-cont">
    <div class="section">
        <div class="deposit-cards-holder">
            <h1><?= lang('trd_47'); ?></h1>
            <ol class="breadcrumb internal-breadcrumb">
                <li><a href="<?= FXPP::loc_url('deposit') ?>"><?= lang('trd_22'); ?></a></li>
                <li><a href="<?= FXPP::loc_url('withdraw') ?>"><?= lang('trd_23'); ?></a></li>
                <li class="active"><?= lang('trd_47'); ?></li>
            </ol>
            <div class="card-row">
                <div class="card-col">
                    <a href="#"><img src="<?= $this->template->Images() ?>cbca.png" class="img-responsive"></a>
                </div>
                <div class="card-col">
                    <a href="#"><img src="<?= $this->template->Images() ?>cbri.png" class="img-responsive"></a>
                </div>
                <div class="card-col">
                    <a href="#"><img src="<?= $this->template->Images() ?>cmandiri.png" class="img-responsive"></a>
                </div>
                <div class="card-col">
                    <a href="#"><img src="<?= $this->template->Images() ?>cdanamon.png" class="img-responsive"></a>
                </div>
                <div class="card-col">
                    <a href="#"><img src="<?= $this->template->Images() ?>cbni.png" class="img-responsive"></a>
                </div>
            </div><div class="clearfix"></div>
            <p class="card-text">
                <?= lang('trd_48'); ?>
            </p>
            <p class="card-text card-cont-text">
                <?= lang('trd_49'); ?>
            </p>
            <div class="card-cont-holder">
                <p><img src="<?= $this->template->Images() ?>contact-email.png" width="24"> : <span>deposit-indonesia@forexmart.com</span></p>

                <?php if(IPLoc::for_id_only()  || FXPP::html_url()== 'id'){ ?>

                <?php }else{ ?>
                    <!-- <p style="font-size: 15px"><b>Depositor 1</b></p>
                <p><img src="<?//= $this->template->Images() ?>contact-yahoo.png" width="24"> :  forexmart.id@yahoo.com — +6285216287577</p>
                <p><img src="<?//= $this->template->Images() ?>contact-whatsapp.png" width="24"> : +6285216287577</p>-->
                <?php } ?>
                <p style="font-size: 15px"><b><?= lang('trd_42'); ?> 1</b></p>
                <p><img src="<?= $this->template->Images() ?>contact-yahoo.png" width="24"> :  forexmartbdg@gmail.com — +62 858 7149 6934</p>
                <p><img src="<?= $this->template->Images() ?>contact-whatsapp.png" width="24"> : +62 858 7149 6934</p>

                <p style="font-size: 15px"><b><?= lang('trd_42'); ?> 2 </b></p>
<!--                admin@ibsyariah.com 62 815 7113 33746   +62 815 7113 33746 -->
                <p><img src="<?= $this->template->Images() ?>contact-yahoo.png" width="24"> :  copycashin@gmail.com — +62 857 1133 3746  </p>
                <p><img src="<?= $this->template->Images() ?>contact-whatsapp.png" width="24"> : +62 857 1133 3746  </p>
                <!-- <p><img src="<?= $this->template->Images() ?>contact-skype.png" width="24"> : fxmart.indo</p> -->
                <!-- <p><img src="<?= $this->template->Images() ?>contact-phone.png" width="24"> : 813 1133 6995</p> -->



                <!-- <p><img src="<?= $this->template->Images() ?>contact-skype.png" width="24"> : fxmart.indo</p> -->
                <!-- <p><img src="<?= $this->template->Images() ?>contact-phone.png" width="24"> : 813 1133 6995</p> -->




            </div>
        </div>
    </div>
</div>
<div class="col-lg-12" style="border-top: 1px solid #ccc;">
</div>

<style type="text/css">
    .acc-num-holder
    {
        margin-bottom: 30px;
        margin-top: 30px;
    }
    .up-file-text
    {
        font-family: Open Sans;
        font-size: 14px;
        /*text-align: right;*/
    }
    .up-file-text span
    {
        color: #ff0000;
    }
    .up-file-step
    {
        font-family: Open Sans;
        font-size: 50px;
        font-weight: 600;
        color: #2988ca;
        margin-top: 0;
    }
    .step2-2
    {
    }
    .file-up-holder
    {
        padding: 15px;
    }
    .btn-uploadsave-holder
    {
        margin-top: 15px;
    }
    .btn-uploadsave
    {
        border: none;
        color: #fff;
        background: #2988ca;
        padding: 7px 40px;
        font-family: Open Sans;
        font-size: 14px;
        transition: all ease 0.3s;
    }
    .btn-uploadsave:hover
    {
        transition: all ease 0.3s;
        background: #319ae3;
    }
    .center-int-tab thead tr th, .anti-fraud-tab thead tr th
    {
        background: #bbb;
        color: #fff;
        border-bottom: none;
        text-align: center;
    }
    .center-int-tab
    {
        margin-bottom: 0!important;
    }
    .center-int-tab tbody tr td
    {
        text-align: center;
    }
    .center-int-tab tbody tr td a
    {
        margin-right: 10px;
    }
    .tab-pagination-holder
    {
        margin-top: 15px;
    }
    .hidden-tr
    {
        display: none;
    }
    .show-tr
    {
        display: table-row!important;
    }
    .no-referral
    {
        text-align: center;
    }
    footer
    {
        background: #fbfafa;
    }
    .btn-get-afflink
    {
        border-radius: 0px;
        background: #29a643;
        width: 200px;
        color: #fff;
    }
    .btn-get-afflink:hover
    {
        background: #50DF6E;
        transition: all ease 0.3s;
        color: #fff;
    }
    .afflink-holder
    {
        display: none;
    }
    .calculate-form-holder
    {
        margin-top: 30px;
    }
    .saldo
    {
        width: 10%;
        text-align: right;
    }
    .total-saldo
    {
        text-align: right;
        font-weight: 600;
    }
    .saldo-tab tbody tr td:last-child
    {
        text-align: right;
    }
    .border-right
    {
        border-right: 1px solid #ccc;
    }
    .separator-note
    {
        margin-top: 0!important;
        font-family: Open Sans;
        font-style: italic;
        font-size: 13px!important;
        font-weight: 400!important;
    }
    .btn-calculate
    {
        padding: 8px 15px;
        border: none;
        color: #fff;
        background: #29a643;
        width: 120px;
        transition: all ease 0.3s;
    }
    .btn-calculate:hover
    {
        background: #50DF6E;
        transition: all ease 0.3s;
    }
    .flag-drp-holder
    {
        display: none;
    }
    .col-search
    {
        padding-left: 0px;
    }
    .flag-img
    {
        margin-top: 5px;
    }
    .mob-flag-holder
    {
        float: right;
    }
    .frm-opendeal-holder
    {
        width: 100%;
    }
    .frm-opendeal-title h3
    {
        font-size: 17px;
        font-family: Georgia;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    .m-top
    {
        margin-top: 10px;
    }
    .market-execution-type, .pending-order-type
    {
        display: none;
        padding: 10px;
        border: 1px solid #ddd;
        margin-top: 33px;
    }
    .market-execution-type h3, .pending-order-type h3
    {
        font-size: 17px;
        font-family: Georgia;
        margin: 0!important;
    }
    .type-active
    {
        display: block!important;
    }
    .market-execution-type p
    {
        text-align: center;
        margin-top: 15px;
        font-size: 35px;
        font-family: Open Sans;
        margin-bottom: 15px;
    }
    .market-execution-type p span small
    {
        font-size: 20px;
    }
    .btn-market-sell
    {
        font-family: Open Sans;
        font-size: 14px;
        padding: 7px;
        border: 1px solid #ff0000;
        background: #fff;
        color: #ff0000;
        width: 100%;
        transition: all ease 0.3s;
    }
    .btn-market-sell:hover
    {
        background: #ff0000;
        color: #fff;
        transition: all ease 0.3s;
    }
    .btn-market-buy
    {
        font-family: Open Sans;
        font-size: 14px;
        padding: 7px;
        border: 1px solid #2988ca;
        background: #fff;
        color: #2988ca;
        width: 100%;
    }
    .btn-market-buy:hover
    {
        background: #2988ca;
        color: #fff;
        transition: all ease 0.3s;
    }
    .btn-pend-place
    {
        margin-top: 3px;
    }
    .pend-note
    {
        margin-top: 10px;
        font-family: Open Sans;
        font-size: 13px;
    }
    .flag-img
    {
        width: 40px;
    }
    .btn-getbonus
    {
        background: #29a643;
        color: #fff;
        border: none;
        width: 200px;
        padding: 7px 10px;
        font-size: 17px;
        font-family: Open Sans;
        text-align: center;
    }
    .btn-getbonus:hover
    {
        color: #fff;
        text-decoration: none;
        background: #50DF6E;
        transition: all ease 0.3s;
    }
    /*new css 05-17-16*/
    .admin-email-tab
    {
        margin: 0;
        letter-spacing: none;
        margin-top: 15px!important;
        list-style: none;
        padding: 0;
        margin-bottom: 10px;
        border-bottom: 1px solid #ccc;
    }
    .admin-email-tab li
    {
        float: left;
    }
    .admin-email-tab li a
    {
        padding: 7px 15px;
        display: block;
        transition: all ease 0.3s;
        color: #333;
        font-family: Open Sans;
    }
    .admin-email-tab li a:focus, .admin-email-tab li a:hover
    {
        background: #2988ca;
        color: #fff;
        text-decoration: none;
        transition: all ease 0.3s;
    }
    .upload-email-form
    {
        margin-top: 20px;
    }
    .admin-email-active
    {
        background: #2988ca;
        color: #fff!important;
        text-decoration: none;
    }
    .set-form
    {
        margin-right: 50px;
    }
    .card-row
    {
        width: 100%;
    }
    .card-row .card-col
    {
        /*width: calc(100% / 5);*/
        padding-right: 10px;
        float: left;
    }
    .card-col a
    {
        transition: all ease 0.3s;
        opacity: 0.5;
    }
    .card-col a:hover
    {
        transition: all ease 0.3s;
        opacity: 1;
    }
    .card-text
    {
        font-family: Open Sans;
        margin-left: 4px;
        margin-top: 10px;
    }
    .card-text span
    {
        font-weight: 600;
        color: #2988ca;
    }
    .card-cont-text
    {
        color: #6a6a6a;
        margin-top: 20px;
    }
    .card-cont-holder
    {
        margin-left: 4px;
    }
    .card-cont-holder p
    {
        font-family: Open Sans;
        font-size: 14px;
        color: #6a6a6a;
    }
    .card-cont-holder p span
    {
        font-weight: 600;
        color: #2988ca;
    }
    .deposit-cards-holder
    {
        /*margin-top: 15px;*/
        padding: 0 30px;
        /*width: 80%;*/
    }
    .internal-breadcrumb
    {
        margin-top: 15px;
        border-radius: 0px;
    }

    @media screen and (min-width: 1024px) {
        /* footer design*/
        .footer-section{
        padding: 80px 0px!important;
        }
        .footer-block-profile{
        width: 58%!important;
        }
        .footer-block-social{
        width: 42%!important;
        }
        .footer-feedback{
        width: 38%!important;
        }
        .grp-list{
        margin-bottom: 44px!important;
        }
        .footer-social{
        width: 62%!important;
        margin-top: 10px!important;
        }
        /* footer design*/
    }
    @media screen and (max-width: 767px) {
        .side-nav-holder .side-nav li a
        {
            border-left: none;
        }
        .int-logo
        {
            width: 250px;
            transition: all ease 0.3s;
        }
        .navbar-right-internal li a
        {
            padding-bottom: 10px!important;
            padding-top: 10px!important;
        }
        .flag-desk
        {
            display: none!important;
        }
        .flag-drp-holder
        {
            display: block;
        }
        .flag-drp
        {
            position: fixed!important;
            z-index: 9;
            left: 10px;
            top: 155px;
            width: 150px;
            float: right;
        }
        .int-logo
        {
            margin-left: 10px;
        }
        .btn-getbonus
        {
            margin-bottom: 15px;
        }
        .btn-acct-calc
        {
            margin-top: 10px;
        }
        .acct-sum-holder, .btn-text-holder
        {
            padding-right: 3px;
            padding-left: 3px;
        }
        .bonus-text
        {
            padding: 0px;
        }
    }
    @media screen and (max-width: 639px) {
        .card-col
        {
            padding-right: 3px!important;
        }
    }
    @media screen and (max-width: 405px) {
        .other-link li
        {
            float: none!important;
        }
        .other-link li a
        {
            padding-left: 0!important;
        }
    }
    @media screen and (max-width: 725px){
        .deposit-cards-holder {
            padding: 0;
        }
    }
    @media screen and (max-width: 694px){
        .card-row .card-col {
            width: calc(100% / 5);
        }
    }
    <style>