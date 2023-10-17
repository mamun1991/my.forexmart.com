<style>
    .no-sort::after { display: none!important; }

    .no-sort { pointer-events: none!important; cursor: default!important; }

    @media only screen and (min-width: 0px)  and (max-width: 400px) {
        .copyTradBtn{
            width: 144px!important;
        }
        .btn-main{
            padding: 11px 13px!important;
            font-size: 11px;
        }
        .wel_come{
            font-size: 16px!important;
        }
    }

    .modal {
        display: none;
        position: fixed;
        /*z-index: 1;*/
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
    }

    @media (max-width: 768px){
        .modal-content{
            width: 90%;
            margin: 20% auto;
        }
    }


    .close {
        margin: 0;
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .tradeDiv {
        width: 100%;
    }

    .table-responsive {
        overflow: hidden !important;
    }

    @media only screen and (min-width: 1001px) and (max-width: 1015px)  {
         .main-tab li a{
             font-size:16px !important;
         }

    }
    .main-tab li{
        margin-bottom: 1px!important;
    }




    .input-group {
        z-index: 1;
    }

    .modal-content {
        height: 70% !important;;
        background-color: #fefefe;
        margin: 9% auto;
        padding: 20px !important;;
        border: 1px solid #888;
        width: 50% !important;
    }

    .modal-header {
        padding: 20px !important;
    }

    .modal-footer {
        padding-bottom: 20px !important;
    }

    .close {
        font-size: 20px !important;
    }

#copytrade-table_length{
    margin-top: 25px;
    margin-bottom: -10px;
}

    .modal-header .close {
        margin-top: 0px;
    }

    .modal-body {
        padding: 10px;
    }
table.dataTable thead th,
table.dataTable thead td {
        padding: 0 3px !important;
}
.row-fix{
	margin-left: -15px;
	margin-right: -15px;
}

    
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    font-size: 12px!important;
    padding: 0px 5px !important;
}

</style>






<div class="modal fade" id="session_expire_modal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Session Timeout</h4>
            </div>
            <div class="modal-body">
                <p>You were inactive in your personal account for 30 minutes, do you want to continue working?</p>
                <p>Otherwise, you will be logged out in <span class="timeoutT" id="timeout">(0)</span>.</p>

            </div>
            <div class="modal-footer">
                <!--                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeModal()">YES</button>-->
                <button type="button" class="btn btn-primary" onclick="closeModal()">YES</button>
                <button type="button" class="btn btn-default" onclick="sessionLogout()">NO</button>
            </div>
        </div>
    </div>
</div>







<div id="exTab" class="col-lg-12 col-md-12 col-sm-12 int-main-cont tradeDiv">
    <div class="row-fix">
    <div class="section">

        <div class="acct-tab-holder">
            <ul role="tablist" class="main-tab">
                <li class="active">
                    <a  href="<?=FXPP::my_url('copytrade')?>" id = "tab1" ><?= lang('sb_li_12'); ?></a>
                </li>


                <li>
                    <a   href="<?=FXPP::my_url('copytrade/my_subscription')?>" class="btn" id = "tab2"  ><?= lang('trd_74'); ?></a>
                </li>

               
     
                 
                <li>
                    <a href="<?=FXPP::my_url('copytrade/rollover-commission')?>" id = "tab6" ><?= lang('trd_277'); ?></a>
                 </li>

               



                <?php if(FXPP::getCopytradeType() == 1){ ?>
                    <li>
                        <a href="<?=FXPP::my_url('copytrade/my_project')?>" class="btn" id = "tab3" ><?= lang('trd_75'); ?></a>
                    </li>
                <?php } ?>

                <li>
                    <a  href="<?=FXPP::my_url('copytrade/profile')?>" class="btn" id = "tab4"  ><?= lang('trd_76'); ?></a>
                </li>
                <li>
                    <a  href="<?=FXPP::my_url('copytrade/recommended-accounts')?>" class="btn" id = "tab5"  ><?= lang('trd_77'); ?></a>
                </li>
                <div class="clearfix"></div>
        </div>

        <div class="tab-content clearfix">
            <div class="tab-pane active" id="1">
                <p class="p_content"><?= lang('trd_78'); ?></p>
                <?php if($IsSubscribe){ ?>


                    <div class="content-delimetr"></div>
                    <div class="content-head-block"><?= lang('trd_79'); ?> </div>
                    <div role="tabpanel" class="tab-pane active fc-trader-list copytrading" style="overflow:initial; width:100%">
                        <!-- Custom Filter -->
                        <div style="margin-bottom: 15px;">
                            <tr>
                                <td colspan="2">
                                    
                                     <div class="input-group" style="float:left">
                                        <select class="form-control sort" id="sort_desc">
                                            <option value="1" class="sort-select"><?= lang('sort_text_1'); ?></option>
                                            <option value="2" class="sort-select" selected=""><?= lang('sort_text_2'); ?></option>
                                            <option value="3" class="sort-select"><?= lang('sort_text_3'); ?></option>
                                            <option value="4" class="sort-select"><?= lang('sort_text_4'); ?></option>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <input style="width:70%; float:right" id="search" type="text" class="form-control" placeholder="<?= lang('account_project'); ?>"> <span class="input-group-addon btn-search"><i class="glyphicon glyphicon-search"></i></span>
                                    </div>
                                </td>


<!--                                <td colspan="2">
                                    <div class="input-group" style="margin-left:5px;">
                                        <select class="form-control sort" id="sort_desc">
                                            <option value="1" class="sort-select"> Sort by profit Low first</option>
                                            <option value="2" class="sort-select" selected="">Sort by profit High first</option>
                                            <option value="3" class="sort-select">Sort by date Old first</option>
                                            <option value="4" class="sort-select">Sort by date New first</option>
                                        </select>
                                    </div>
                                </td>-->
                            </tr>
                            <div class="table-responsive active">
                                <table class="table table-striped" id="copytrade-table" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th class="tbl-copytrade-col-1 ac no-sort"><?= lang('trd_80'); ?></th>
                                        <th class="tbl-copytrade-col-2 no-sort" ><?= lang('reb_txt_9'); ?></th>
                                        <th class="tbl-copytrade-col-3 no-sort"><?= lang('trd_81'); ?></th>
                                        <th class="tbl-copytrade-col-4 no-sort"><?= lang('trd_82'); ?></th>
                                        <th class="tbl-copytrade-col-5 no-sort"><?= lang('trd_83'); ?></th>
                                        <th class="tbl-copytrade-col-6 no-sort"><?= lang('trd_84'); ?></th>
                                        <th class="tbl-copytrade-col-7 no-sort"><?= lang('trd_85'); ?></th>
                                        <th class="tbl-copytrade-col-8 no-sort"><?= lang('trd_86'); ?></th>
                                        <th class="tbl-copytrade-col-9 no-sort"><?= lang('trd_87'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody id = "tab1-body">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php }else{ ?>
                    <div class="fc-welcome">
                        <h1 class="wel_come" style="margin-bottom: 10px"><?= lang('trd_88'); ?></h1>
                        <?php
                        if(FXPP::html_url() == 'ru'){
                            ?>
                                <div class="content-head-block"><a target="_blank" href="<?= $this->template->Pdf()?>Copytrading-guide-ru.pdf"><?= lang('cpy_trd_agrmnt0'); ?></a> </div>
                            <?php
                        } else {
                            ?>
                                <div class="content-head-block"><a target="_blank" href="<?= $this->template->Pdf()?>Copytrading-guide.pdf"><?= lang('cpy_trd_agrmnt0'); ?></a> </div>
                            <?php
                        }
                        ?>

                        <div></div>
                        <div class="fc-agrr-body">

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                   <p style="font-size: 14px !important;"> <input id="offer_agree" type="checkbox" > <?= lang('trd_90'); ?> <a href="#" id="myBtn"><span><?= lang('trd_89'); ?></span></a><br><div class="content-head-block"></div><?= lang('trd_91'); ?>
								   </p>
                                </div>
                            </div>
                            <div id="myModal" class="modal">

                                <!-- Modal content -->
                                <div class="modal-content" id="modal-content">
                                    <span class="close" id="close">&times;</span>
                                    <?php include("forexcopy_agreement.php")?>
                                </div>

                            </div>
                            <div class="content-head-block"></div>
                            <a href="#" id="i-be-copier" class="btn btn-main copyTradBtn" disabled=""><?= lang('trd_93'); ?></a>
                            <a href="<?= base_url('copytrade/register_trader') ?>" id="i-be-trader" class="btn btn-main copyTradBtn2" disabled=""><?= lang('trd_94'); ?></a>
                            <br><br>
                        </div>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>
    </div>
</div>
<div id="cpy_modal"  tabindex="-1" class="modal-custom modal-center modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document" style="
    position: absolute;
    top: 20%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
     min-width: 260px;
     margin-left: 0px;
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

<div id="confirmModal"  tabindex="-1" class="modal-custom modal-center modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document" style="
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
     min-width: 260px;
     margin-left: 0px;
">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title conf-modal-title text-center"></h4>
                <img src="<?= $this->template->Images()?>img-info-modal.png" class="img-center img-info-modal">
            </div>
            <div class="modal-body">
                <p id="m_message" class="text-center conf-modal-desc"></p>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-success" id ='confirm' value="Continue">
            </div>
        </div>
    </div>
</div>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script type="text/javascript">

    var url = '<?php echo FXPP::ajax_url();?>';
    console.log(url);
    var copytrade_table;
    <?php if(!$IsSubscribe){ ?>

            var modal = document.getElementById("myModal");

            var btn = document.getElementById("myBtn");

            var span = document.getElementById("close");
            btn.onclick = function() {
                document.body.style.overflow = 'hidden';
                document.getElementById('modal-content').style.overflow = 'scroll';
                modal.style.display = "block";
            }

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    document.body.style.overflow = 'unset';
                    modal.style.display = "none";
                }
            }



    <?php } ?>





    $(document).ready(function(){

        $('[data-toggle="tooltip"]').tooltip();

        $("#offer_agree").on('change', function() {
            if ($(this).is(':checked')) {
                $('#i-be-copier').removeAttr("disabled");
                $('#i-be-trader').removeAttr("disabled");

                console.log('disable false');

            } else {
                $('#i-be-copier').attr("disabled",true);
                $('#i-be-trader').attr("disabled",true);

                console.log('disable true');


            }
        });

        <?php if($IsSubscribe){ ?>
        runMyCopytrading();
        <?php } ?>
    });


    function runMyCopytrading() {
        $(".sorting_disabled").removeClass("sorting_asc");
        $('#copytrade-table').DataTable().destroy();
        jQuery('#copytrade-table').on('preXhr.dt', function (e, settings, data) {
            $(".sorting_disabled").removeClass("sorting_asc");
            $('#copytrade-table tbody').html('<div id ="loading_rec" style="text-align:center;"><tr><td colspan="9" style="text-align: center;padding:10px">Loading records<img src="<?=$this->template->Images()?>loading.gif" /></td></tr></div>');
        }).on('xhr.dt', function (e, settings, json, xhr) {
            $("#loading_rec").hide();
            $(".sorting_disabled").removeClass("sorting_asc");
        }).DataTable({
            "bJQueryUI": true,
            "destroy": true,
            "processing": false,
            "serverSide": true,
             "ordering": false,
            "searching": false,
            "language":{
                search:'<?=lang('curtra_s')?>',
                lengthMenu: '<?=lang('dta_tbl_07')?>',
                info: '<?=lang('dta_tbl_02')?>',
                zeroRecords: '<?=lang('dta_tbl_01')?>',
                paginate: {
                    next:       '<?=lang('dta_tbl_14')?>',
                    previous:   '<?=lang('dta_tbl_15')?>'
                }
            },
            "columnDefs": [
                { "ordering": false, "targets": 0 }
            ],
            "order": [],  // not set any order rule for any column.
            "ajax": {
                "url": url + 'copytrade/my_copytrade_request',
                "type": "POST",
                "data": function (d) {
                    return $.extend( {}, d, {
                        "extra_search": $('#search').val(),
                        "sort": $('#sort_desc').val(),
                    } );
                }
            }
        });
    }

    $(document).on("click","#i-be-copier",function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: url + 'copytrade/register_follower',
            dataType: 'json',
            beforeSend: function () {
                $('#loader-holder').show();
            },
            success: function (data) {
                $('#loader-holder').hide();
                console.log(data);
                if (data.isSuccess) {
                    $('.conf-modal-title').html('Register Account');
                    $('.conf-modal-desc').html('Your account has been successful registered as CopyTrade Investor.');
                    $('#confirmModal')
                        .modal({ backdrop: 'static', keyboard: false })
                        .on('click', '#confirm', function (e) {
                            location.reload();
                            return false;
                        });
                } else {
                    $('#m_message').html(data.errorMsg);
                    $('#cpy_modal').modal('show');
                }
            }

        });

    });

    $(document).on("click","#tab1",function(){
        runMyCopytrading();
    });

    $(document).on("click",".btnsubscribe",function(){



        var master = $(this).attr("data-id");
        var status = $(this).attr("data-type");
        if(status == 0){
            window.location.href = url+'copytrade/monitor_user/' + master;
        }
        if(status == 1){
            window.location.href = url+ 'copytrade/my_subscription';
        }
        if(status == 2){
            window.location.href = url+ 'copytrade/my_subscription';
        }

    });


    jQuery(".btn-search").on("click",function (e) {
        runMyCopytrading();
    });


    jQuery("#search").on("keypress",function (event) {
        if (event.which == 13 || event.keyCode == 13) {
            runMyCopytrading();
        }
    });

    jQuery("#search").on("keyup blur",function (event) {
        if($('#search').val().length > 2){ // minimum 2 char
            runMyCopytrading();
        }

    });

    $('#sort_desc').on('change', function(e) {
        e.preventDefault();
        e.stopPropagation();
        runMyCopytrading();
    });


    var url = '<?php echo FXPP::ajax_url();?>';
    console.log(url+'--oook');




    var IsSubscribeChk='<?php echo $IsSubscribe?>';

    if(IsSubscribeChk){


        $('#tab2').removeAttr("disabled");
        $('#tab4').removeAttr("disabled");
        $('#tab5').removeAttr("disabled");

        console.log(IsSubscribeChk+'disabled false');



    }else{

        $('#tab2').attr("disabled",true);
        $('#tab4').attr("disabled",true);
        $('#tab5').attr("disabled",true);
        console.log(IsSubscribeChk+'disable true');






    }






</script>


















