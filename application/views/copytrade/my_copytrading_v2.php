<style>
    .no-sort::after { display: none!important; }

    .no-sort { pointer-events: none!important; cursor: default!important; }

    @media only screen and (min-width: 0px)  and (max-width: 400px) {
        .copyTradBtn{
            width: 158px!important;
        }
    }


    @media only screen and (min-width: 1001px) and (max-width: 1015px)  {
 .main-tab li a{font-size:16px !important }

}
</style>

<div id="exTab" class="col-lg-12 col-md-12 int-main-cont">
    <div class="section">

        <div class="acct-tab-holder">
            <ul role="tablist" class="main-tab">
                <li class="active">
                    <a  href="<?=FXPP::my_url('copytrade')?>" id = "tab1"><?= lang('sb_li_12'); ?></a>
                </li>

                   
                <li>
                    <a href="<?=FXPP::my_url('copytrade/my_subscription')?>" id = "tab2" ><?= lang('trd_74'); ?></a>
                </li>
                 
                
                <?php if(FXPP::getCopytradeType() == 1){ ?>
                <li>
                    <a href="<?=FXPP::my_url('copytrade/my_project')?>" id = "tab3" ><?= lang('trd_75'); ?></a>
                </li>
                <?php } ?>
           
                <li>
                    <a  href="<?=FXPP::my_url('copytrade/profile')?>" id = "tab4" ><?= lang('trd_76'); ?></a>
                </li>
                <li>
                    <a  href="<?=FXPP::my_url('copytrade/recommended-accounts')?>" id = "tab5" ><?= lang('trd_77'); ?></a>
                </li>
                <div class="clearfix"></div>
        </div>

        <div class="tab-content clearfix">
            <div class="tab-pane active" id="1">
                <p><?= lang('trd_78'); ?></p>
                <?php if($IsSubscribe){ ?>


                    <div class="content-delimetr"></div>
                    <div class="content-head-block"><?= lang('trd_79'); ?> </div>
                    <div class="table-responsive fc-trader-list copytrading" style="overflow:initial; width:100%">
                        <!-- Custom Filter -->
                        <table style="margin-bottom: 15px;">
                            <tr>
                                <td colspan="2">
                                    <div class="input-group">
                                        <input id="search" type="text" class="form-control" placeholder="<?= lang('account_project'); ?>"> <span class="input-group-addon btn-search"><i class="glyphicon glyphicon-search"></i></span>
                                    </div>
                                </td>
                                

                                <td colspan="2">
                                    <div class="input-group" style="margin-left:5px;">
                                        <select class="form-control sort" id="sort_desc">
                                            <option value="1" class="sort-select"> Sort by profit Low first</option>
                                            <option value="2" class="sort-select" selected="">Sort by profit High first</option>
                                            <option value="3" class="sort-select">Sort by date Old first</option>
                                            <option value="4" class="sort-select">Sort by date New first</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        <table class="table" id="copytrade-table" style="width:100%">
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
                <?php }else{ ?>
                    <div class="fc-welcome">
                        <h1 style="margin-bottom: 10px"><?= lang('trd_88'); ?></h1>
                        <div class="content-head-block"><?= lang('trd_89'); ?></div>
                        <div></div><br>
                        <div class="fc-agrr-body">
                            <?php include("forexcopy_agreement.php")?>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div class="content-delimetr"></div>
                                    <input id="offer_agree" type="checkbox" > <span><?= lang('trd_90'); ?></span>
                                    <div class="content-delimetr"></div>
                                </div>
                            </div>
                            <div class="content-head-block"><?= lang('trd_91'); ?></div><br>
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

<div id="confirmModal"  tabindex="-1" class="modal-custom modal-center modal fade" role="dialog">
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


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script type="text/javascript">
    var url = '<?php echo FXPP::ajax_url();?>';
	console.log(url);
    var copytrade_table;

    $(document).ready(function(){

        $('[data-toggle="tooltip"]').tooltip();

        $("#offer_agree").on('change', function() {
            if ($(this).is(':checked')) {
                $('#i-be-copier').removeAttr("disabled")
                $('#i-be-trader').removeAttr("disabled");
            } else {
                $('#i-be-copier').attr("disabled",true);
                $('#i-be-trader').attr("disabled",true);
            }
        });

        <?php if($IsSubscribe){ ?>
        runMyCopytrading();
        <?php } ?>
    });


    function runMyCopytrading() {
        $('#copytrade-table').DataTable().destroy();
        jQuery('#copytrade-table').on('preXhr.dt', function (e, settings, data) {
            $('#copytrade-table tbody').html('<div id ="loading_rec" style="text-align:center;"><tr><td colspan="5">Loading records<img src="<?=$this->template->Images()?>loading.gif" /></td></tr></div>');
        }).on('xhr.dt', function (e, settings, json, xhr) {
            $("#loading_rec").hide();
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
                { "orderable": false, "targets": 0 }
            ],
            "order": [],  // not set any order rule for any column.
            "ajax": {
                "url": '/copytrade/my_copytrade_request',
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
            window.location.href = url+ 'copytrade/monitor_user/' + master;
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
        runMyCopytrading();
    });

    $('#sort_desc').on('change', function(e) {
        e.preventDefault();
        e.stopPropagation();
        runMyCopytrading();
    });
    
    function runSearch(){
        var search = $('#search').val();
        $.ajax({
            type: 'POST',
            url: url + 'copytrade/monitoring_request_search',
            data: {search:search},
            dataType: 'json',
            beforeSend: function () {

                $('#copytrade-table tbody').html('<div id ="loading_rec" style="text-align:center;"><tr><td colspan="5">Loading records<img src="<?=$this->template->Images()?>loading.gif" /></td></tr></div>');
            },
            success: function (data) {
                console.log(data);
                $('#tab1-body').html(data.copytrade_data);
                $("#loading_rec").hide();

            }
        });

    }
</script>