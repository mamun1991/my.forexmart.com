
    <div class="section">
        <h1 class=""><?= lang('b_t_td_8');?></h1>
        <div class="acct-tab-holder">
            <ul role="tablist" class="main-tab">
                <li role="presentation"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab" id="active-tab"><i class="fa fa-user"></i><?= lang('b_t_td_9');?> </a></li>
                <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"><i class="fa fa-check"></i> <?= lang('b_t_td_10');?></a></li>
            </ul><div class="clearfix"></div>
        </div>
        <div class="tab-content acct-cont">
            <div role="tabpanel" class="row tab-pane active" id="tab1">
                <div class="col-md-12">
                    <p class="pro-text">
                        <?= lang('b_t_td_11');?>
                    </p>
                    <p class="pro-text">
                        <?= lang('b_t_td_12');?>
                    </p>
                    <select class="form-control round-0 period-option" id="affiliate_link">
                        <?php
                        if(is_array($affiliate_codes)){
                            foreach($affiliate_codes as $d){
                                echo "<option value='" . $d['affiliate_code'] . "'>".$d['affiliate_code']."</option>";
                            }
                        }else{
                            echo "<option>Choose</option>";
                        }
                        ?>

                    </select>
                    <label><?= lang('b_t_td_9');?></label>
                    <div class="table-responsive">
                        <table class="table table-bordered promotional-tab" id="bannerTable">
                            <thead>
                            <tr class="banner-table-header">
                                <th  class="rowspan">#</th>
                                <th ><?= lang('b_p_2');?>
                                </th>
                                <th  class="rowspan">
                                    <?= lang('b_t_td_1');?>
                                </th>
                                <th  class="rowspan">
                                    <?= lang('b_t_td_2');?>
                                </th>
                                <th  class="rowspan">
                                    <?= lang('b_t_td_3');?>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?= $bannerList; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="forex-banners-container" id="ShowBannerPage" style="margin-top: 20px;">
                </div>

            </div>  <!-- row -->
            </div>
            <div role="tabpanel" class="row tab-pane" id="tab2">
                <div class="col-md-12">

                    <div class="table-responsive">
                        <table class="table table-stripped table-hover logos-tab ext-arabic-logos-tab">
                            <thead>
                            <tr>
                                <th class="logos"><?=lang('ext-logo');?></th>
                                <th class="logo-dl"><?=lang('ext-downas');?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <img src="<?= FXPP::www_url('assets/images/')?>logo2.svg" class="fx-logo">
                                </td>
                                <td>
                                    <a href="<?= FXPP::www_url('assets/images/')?>ForexMart-logo2.png" download><?=lang('ext-png');?></a>,
                                    <a href="<?= FXPP::www_url('assets/pdf/')?>ForexMart-logo2.pdf" download><?=lang('ext-pdf');?></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="<?= FXPP::www_url('assets/images/')?>/logo1.svg" class="fx-logo">
                                </td>
                                <td>
                                    <a href="<?= FXPP::www_url('assets/images/')?>ForexMart-logo1.png" download><?=lang('ext-png');?></a>,
                                    <a href="<?= FXPP::www_url('assets/pdf/')?>ForexMart-logo1.pdf" download><?=lang('ext-pdf');?></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="<?= FXPP::www_url('assets/images/')?>logo6.svg" class="fx-logo">
                                </td>
                                <td>
                                    <a href="<?= FXPP::www_url('assets/images/')?>ForexMart-logo6.png" download><?=lang('ext-png');?></a>,
                                    <a href="<?= FXPP::www_url('assets/pdf/')?>ForexMart-logo6.pdf" download><?=lang('ext-pdf');?></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="<?= FXPP::www_url('assets/images/')?>logo4.svg" class="">
                                </td>
                                <td>
                                    <a href="<?= FXPP::www_url('assets/images/')?>ForexMart-logo4.png" download><?=lang('ext-png');?></a>,
                                    <a href="<?= FXPP::www_url('assets/pdf/')?>ForexMart-logo4.pdf" download><?=lang('ext-pdf');?></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="<?= FXPP::www_url('assets/images/')?>logo5.svg" class="fx-logo">
                                </td>
                                <td>
                                    <a href="<?= FXPP::www_url('assets/images/')?>ForexMart-logo5.png" download><?=lang('ext-png');?></a>,
                                    <a href="<?= FXPP::www_url('assets/pdf/')?>ForexMart-logo5.pdf" download><?=lang('ext-pdf');?></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="<?=FXPP::www_url('assets/images/')?>logo3.svg" class="fx-logo">
                                </td>
                                <td>
                                    <a href="<?= FXPP::www_url('assets/images/')?>ForexMart-logo3.png" download ><?=lang('ext-png');?></a>,
                                    <a href="<?= FXPP::www_url('assets/pdf/')?>ForexMart-logo3.pdf" download ><?=lang('ext-pdf');?></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

    </div><!-- add -->
        </div>



    <script type="text/javascript">

        $(document).on("click",".btn-show-banner",function(){
            $('#popupd').modal('show');
            var pagename=$(this).attr("id");
            var af = $(this).attr("af");
            var lang='<?=FXPP::html_url()?>';
            $("#loader-holder").show();
            var base_url = "<?=FXPP::ajax_url();?>";

            $.post(base_url+'promotional_materials/BannersShow',{pagename:pagename,lang:lang,af:af},function(view){

                $("#ShowBannerPage").html(view);
                $('#popupd').modal('hide');
                // scroll position
                var Heigh=$("html").height();
                var scrolled=Heigh+320//(Heigh-((Heigh/2)/2));
                $("body, html").animate({  scrollTop:  scrolled});
                $("#loader-holder").hide();
            });
        });

        $(document).on("click","#ShowBannerPage textarea",function(){
            $(this).select();
        });


        var table;
        $(document).ready( function () {
             table = $('#bannerTable').DataTable({
				 "language":{
						search:'<?=lang('curtra_s')?>',
						lengthMenu: '<?=lang('dta_tbl_07')?>',
						info: '<?=lang('dta_tbl_02')?>',
						zeroRecords: '<?=lang('dta_tbl_01')?>',
						paginate: {
							next:       '<?=lang('dta_tbl_14')?>',
							previous:   '<?=lang('dta_tbl_15')?>'
						}
					}
			 });
        });

        $(document).on("change","#affiliate_link",function(){

                $(".btn-show-banner").attr("af",$(this).val());
        })

    </script>

<style>
    .promotional-tab thead tr th
    {
        background: #bbb;
        color: #fff;
        border-bottom: none;
        text-align: center;
    }
    .promotional-tab tbody tr td
    {
        vertical-align: middle;
        text-align: center;
    }
    .promotional-tab tbody tr td button
    {
        font-family: Open Sans;
        font-size: 13px;
        padding: 5px 15px;
        color: #fff;
        background: #29a643;
        border: 0;
    }
    .pro-text
    {
        font-family: Open Sans;
        font-size: 14px;
        color: #333;
        margin: 10px 0!important;
        margin-bottom: 15px!important;
        text-align: justify;
    }
</style>