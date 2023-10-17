<style>

    .avatar{

        float: left!important;
    }
    #fc-offer {
        border: 1px solid #e6e6e6;
        height: auto !important;
        max-height: 280px;
        overflow: auto;
        padding: 10px;
        font-size: 12px;
        width: 100%;
    }
    .content-head-block{
        background-color: #136fd7;
        color: #FFF;
        padding-left: 15px;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .content-head-block-dark {
        /*background-color: #373739;*/
        background-color: #373739;
        color: #FFF;
        padding-left: 20px;
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: left;
    }
    #fc-offer p{
        font-style: normal;
    }
    #fc-offer li{
        font-size: 15px;
    }

    #top-trader-table>thead {
        color: #fff;
        background-color: #373739;
    }
    .cpy-account{
        display: inline-block;
        float: left;
        width: 50%;
        padding: 5px;
    }
    .table-responsive{
        overflow-x: hidden;
    }


    /*@media only screen and (min-width: 0px)  and (max-width: 767px) {*/
    /*.nav-tabs>li>a {*/
    /*margin-top: 20px!important;*/
    /*}*/
    /*}*/

.tab-content{
    padding-top: 0px;
}


    /*Modal*/
    .modal-custom{
        /*min-height: 100%;*/
        /*position: absolute;*/
        /*top: 0;*/
        /*width: 100%;*/
        /*left: 0;*/
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
    }
    .modal-custom .modal-content{
        padding: 15px;
        line-height: 1.5;
    }
    .modal-custom .modal-header, .modal-custom .modal-footer{
        border:0;
        padding:0;
    }
    .modal-custom .close{
        /*position: absolute;*/
        top: 10px;
        right: 10px;
        color: red;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 1px solid red;
    }
    .modal-custom .modal-footer{
        text-align:center;
    }
    .img-center{
        display: block;
        margin:0 auto;
    }
    .img-info-modal{
        width:auto;
        height: 86px;
    }
    .btn-form{
        min-width: 150px;
        height:40px;
        letter-spacing: 1px;
    }
    
@media only screen and (min-width: 1001px) and (max-width: 1015px)  {
 .main-tab li a{font-size:16px !important }

}
</style>
<div id="exTab" class="col-lg-12 col-md-12 int-main-cont">
    <div class="section">

        <div class="acct-tab-holder">
            <ul role="tablist" class="main-tab">
				<li>
                    <a  href="<?=FXPP::my_url('copytrade')?>" id = "tab1"><?= lang('sb_li_12'); ?></a>
                </li>
  
                <li>
                    <a href="<?=FXPP::my_url('copytrade/my_subscription')?>" id = "tab2" ><?= lang('trd_74'); ?></a>
                </li>
                
            
                <li>
                        <a href="<?=FXPP::my_url('copytrade/rollover-commission')?>" id = "tab6" ><?= lang('trd_277'); ?></a>
                    </li>

                
                <?php if(FXPP::getCopytradeType() == 1){ ?>
                <li>
                    <a href="<?=FXPP::my_url('copytrade/my_project')?>" id = "tab3" ><?= lang('trd_75'); ?></a>
                </li>
                <?php } ?>
                <li>
                    <a  href="<?=FXPP::my_url('copytrade/profile')?>" id = "tab4" ><?= lang('trd_76'); ?></a>
                </li>
                <li  class="active">
                    <a  href="<?=FXPP::my_url('copytrade/recommended-accounts')?>" id = "tab5" ><?= lang('trd_77'); ?></a>
                </li>
                <div class="clearfix"></div>
        </div>

        <div class="tab-content clearfix">
            <div class="tab-pane table-responsive active" id="1">
                <?php
                $display = $this->session->flashdata('display');
                $msg = $display == 1? 'The registration as a Copytrading Follower has been successfully completed.' : 'Please try again.';

                if(isset($display)){
                    ?>
                    <div class="form-group" style=" margin-top: 15px;display: table;width: 100%;">
                        <div class="col-sm-10">
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" style="margin-top: 0px">&times;</button>
                                <?= $msg ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>


                    <div class="row">
                        <div class="col-lg-2 col-md-1 col-sm-1"></div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="content-delimetr"></div>
                            <div class="padding-bottom"><h4><?= lang('trd_170'); ?></h4></div>
							
                            <div class="content-delimetr-mini"></div>
                            <table class="table  table-striped table_main text-center" id="top-trader-table" >
                                <thead>
                                <tr>
                                    <th class="text-center"><?= lang('trd_80'); ?></th>
                                    <th class="text-center"><?= lang('reb_txt_9'); ?></th>
                                    <th class="text-center"><?= lang('trd_130'); ?></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id = "top-trader-body">
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-2 col-md-1 col-sm-1"></div>

                    </div>
                <p><i><?= lang('trd_172'); ?></i></p>

            </div>
        </div>
    </div>
</div>

    <div id="cpy_modal"  tabindex="-1" class="modal-custom modal-center modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document" style="
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title">Modal title</h5> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <img src="<?= $this->template->Images()?>img-info-modal.png" class="img-center img-info-modal">
                </div>
                <div class="modal-body">
                    <p id="m_message" class="text-center"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-form" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script type="text/javascript">
    var url = '<?php // echo base_url();?>';
    var url = '<?php echo FXPP::ajax_url();?>';
    $(document).ready(function(){

        $('[data-toggle="tooltip"]').tooltip();

        <?php if($IsSubscribe){ ?>
        runMyCopytradingRecommened();
        <?php } ?>
    });





    function runMyCopytradingRecommened(){
        var per_page = $('#per_page').val();
        $.ajax({
            type: 'POST',
            url: url + 'copytrade/recommended_request',
            dataType: 'json',
            beforeSend: function () {
               $('#top-trader-table tbody').html('<div id ="loading_rec" style="text-align:center;"><tr><td colspan="5"><?= lang("trd_173"); ?><img src="<?=$this->template->Images()?>loading.gif" /></td></tr></div>');

            },
            success: function (data) {
                $('#top-trader-body').html(data.top_trader_data);
                $("#loading_rec").hide();

            }
        });
    }


    $(document).on("click","#tab5",function(){
        runMyCopytradingRecommened();
    });

    $(document).on("click",".btnsubscribe",function(){
        var master = $(this).attr("data-id");
        console.log(master);
        window.location.href = url+ 'copytrade/monitor_user/' + master;

    });


</script>