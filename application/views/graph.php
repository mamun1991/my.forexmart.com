
<?php include_once('partnership/partnership_nav.php') ?>
<style>
    @media screen and (max-width:991px){
       .btngraph{
           margin-top: 10px;
           margin-left: -4px;
       }
    }

    @media (min-width: 992px){
        .col-md-9 {
            width: 75%;
            overflow-x: hidden !important;
        }
    }
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active {
    text-align: center;
}
</style>
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9 int-main-cont" >
                    <div class="section">
                        <div class="tab-content acct-cont">
                            <div role="tabpanel" class="row tab-pane active" id="tab1">
                                <div class="col-lg-12" style="margin-bottom:5px;padding:0px; z-index: 1;">
                                    <input type="hidden" id="affcode-list" value="<?=$affiliate_code?>">
                                    <div class="col-md-5">
                                        <label><?= lang('from'); ?></label>
                                        <div class="input-group">
                                          <div class="input-group-addon round-0"><i class="fa fa-calendar"></i></div>
                                          <input type="text" class="form-control round-0" placeholder="from" id="from" value="<?=date("m-d-Y",strtotime("-1 month"));?>">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <label><?= lang('to'); ?></label>
                                        <div class="input-group">
                                          <div class="input-group-addon round-0"><i class="fa fa-calendar"></i></div>
                                          <input type="text" class="form-control round-0" placeholder="to" id="to">
                                        </div>
                                    </div>
                                     <div class="col-md-1">
                                     <label></label>
                                        <button type="button" class="btn btn-primary btnapply btngraph" id="btn-apply"><?=lang('com_11');?></button>
                                     </div>
                                </div>
                                <div class="col-lg-12">

                                    <div class="panel panel-default round-0" id="commission-wrapper" >
                                        <div class="panel-heading round-0">
                                            <?= lang('parnav_04'); ?>
                                        </div>
                                        <div class="panel-body">
                                            <div id="samplegraph"></div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default round-0" id="clicks-wrapper" >
                                        <div class="panel-heading round-0">
                                            <?=lang('parnav_05');?>
                                        </div>
                                        <div class="panel-body">
                                            <div id="samplegraph1"></div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default round-0" id="referrals-wrapper" >
                                        <div class="panel-heading round-0">
                                            <?=lang('parnav_06');?>
                                        </div>
                                        <div class="panel-body">
                                            <div id="samplegraph2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- add -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12/">
                </div>
            </div>
        </div>
    </div>

    <script src="<?= $this->template->Js()?>jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?= $this->template->Js()?>bootstrap.min.js"></script>
    <!-- Scrolling Nav JavaScript -->
    <script src="<?= $this->template->Js()?>jquery.easing.min.js"></script>
    <script src="<?= $this->template->Js()?>scrolling-nav.js"></script>
    <script src="<?= $this->template->Js()?>owl.carousel.js"></script>
    <script src="<?= $this->template->Js()?>owl.transitions.js"></script>
    <script src="<?= $this->template->Js()?>morris.min.js"></script>
    <script src="<?= $this->template->Js()?>morris-data.js"></script>
    <script src="<?= $this->template->Js()?>raphael-min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    
    <!-- Demo -->
    <style>
    #owl-demo .item{
        margin: 3px;
    }
    #owl-demo .item img{
        display: block;
        width: 100%;
        height: auto;
    }



    @media screen and (max-width: 990px){

        div#samplegraph svg {
            /*width: 100%;*/

        }

        div#samplegraph1 svg {
            /*width: 100%;*/

        }
        div#samplegraph2 svg {
            /*width: 100%;*/

        }
    }


    svg {
        overflow: visible !important;
    }

    .morris-hover-row-label {
        /*margin-top: 20px;*/
    }








    </style>

    <script>
    $(document).ready(function() {
      $("#owl-demo").owlCarousel({
        items : 4,
        lazyLoad : true,
        navigation : true
      });
    }); 

    var overall_date = [];
    </script>
    <script type="text/javascript">

$(document).ready(function() {
  $(window).resize(function() {
    window.redraw();
  });
});


    function updateGraph(){
    overall_date = [];
    var site_url ="<?=site_url('')?>";
    var affiliate_code = $('#affcode-list').val();
    var from = $('#from').val();
    var to = $('#to').val();
  
      if(affiliate_code === 'null'){
        return false;
      }



        <?php  if(IPLoc::APIUpgradeDevIP()){ ?>

        var ajax_url = 'graph/requestCommission_v2';

        <?php }else{ ?>
        var ajax_url = 'graph/requestCommission';
        <?php } ?>
        
      $.ajax({
          type: 'POST',
          url: site_url+ajax_url,
          data: {
                affiliate_code:affiliate_code,
                from:from,
                to:to
          },
          beforeSend:function(){
            $('#samplegraph').empty();
            $('#commission-wrapper').hide();
          },

      }).done(function(response){
            $('#loader-holder').hide();
            $('#commission-wrapper').show();
           var obj = jQuery.parseJSON ( response );

            $.each(obj, function(i,value){
            	overall_date.push(value.month);
            });   
              new Morris.Line({
                // ID of the element in which to draw the chart.
                element: 'samplegraph',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data: obj,
                // The name of the data record attribute that contains x-values.
                xkey: 'month',
                // A list of names of data record attributes that contain y-values.
                ykeys: ['value'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['<?= lang('trd_262');?>'],
			    resize: true
//			    ,redraw: true
//                  ,resize: true

              });
      });

        $.ajax({
            type: 'POST',
            url: site_url+'graph/getClicksData',
            data: {
                affiliate_code:affiliate_code,
                from:from,
                to:to
            },
            beforeSend:function(){
              $('#samplegraph1').empty();
              $('#loader-holder').show();
              $('#clicks-wrapper').hide();
            },
        }).done(function(response){
            $('#clicks-wrapper').show();
            var obj = jQuery.parseJSON ( response );
            $.each(obj, function(i,value){
            		overall_date.push(value.month);
            });
			
              new Morris.Line({
              // ID of the element in which to draw the chart.
              element: 'samplegraph1',
              // Chart data records -- each entry in this array corresponds to a point on
              // the chart.
              data: obj,
              // The name of the data record attribute that contains x-values.
              xkey: 'month',
              // A list of names of data record attributes that contain y-values.
              ykeys: ['value'],
              // Labels for the ykeys -- will be displayed when you hover over the
              // chart.
              labels: ['<?= lang('trd_263');?>'],
			  resize: true
//			  ,redraw: true
            });
        });

        $.ajax({
            type: 'POST',
            url: '<?= $url = (IPLoc::Office())?(FXPP::ajax_url('graph/getref1')):(FXPP::ajax_url('graph/getref')); ?>',
//            url:site_url+'graph/getref',
            data: {
                affiliate_code:affiliate_code,
                from:from,
                to:to
            },
            beforeSend:function(){
              $('#samplegraph2').empty();
              $('#referrals-wrapper').hide();
            },
        }).done(function(response){
            $('#referrals-wrapper').show();
            var obj = jQuery.parseJSON ( response );
            $.each(obj, function(i,value){
            		overall_date.push(value.month);
            });
              new Morris.Line({
              // ID of the element in which to draw the chart.
              element: 'samplegraph2',
              // Chart data records -- each entry in this array corresponds to a point on
              // the chart.
              data: obj,
              // The name of the data record attribute that contains x-values.
              xkey: 'month',
              // A list of names of data record attributes that contain y-values.
              ykeys: ['value'],
              // Labels for the ykeys -- will be displayed when you hover over the
              // chart.
              labels: ['<?= lang('trd_264');?>'],
			  resize: true
//			  ,redraw: true
            });
        });
    }

    $('#btn-apply').click(function(){
        updateGraph();
    });

    $(window).load(function(){
        $('#affcode-list').attr('disabled',false);
        updateGraph();
    });



    $(window).resize(function () {

//        var width = $(window).width();
//        if (width < 769) {
//            updateGraph();
//        }

    });




$('#area-chart').resize(function () {
  bar.redraw();
});



    </script>
        <script type="text/javascript">
        new Morris.Line({
          // ID of the element in which to draw the chart.
          element: 'samplegraph',
          // Chart data records -- each entry in this array corresponds to a point on
          // the chart.
          data: [
            { year: '2016', value: 0 }
          ],
          // The name of the data record attribute that contains x-values.
          xkey: 'year',
          // A list of names of data record attributes that contain y-values.
          ykeys: ['value'],
          // Labels for the ykeys -- will be displayed when you hover over the
          // chart
          labels: ['Value'],
          resize: true
        });
    </script>
        <script type="text/javascript">
        new Morris.Line({
          // ID of the element in which to draw the chart.
          element: 'samplegraph1',
          // Chart data records -- each entry in this array corresponds to a point on
          // the chart.
          data: [
            { year: '2016', value: 0 }
          ],
          // The name of the data record attribute that contains x-values.
          xkey: 'year',
          // A list of names of data record attributes that contain y-values.
          ykeys: ['value'],
          // Labels for the ykeys -- will be displayed when you hover over the
          // chart.
          labels: ['Value'],
          resize: true
        });
    </script>
        <script type="text/javascript">
        new Morris.Line({
          // ID of the element in which to draw the chart.
          element: 'samplegraph2',
          // Chart data records -- each entry in this array corresponds to a point on
          // the chart.
          data: [
            { year: '2016', value: 0 }
          ],
          // The name of the data record attribute that contains x-values.
          xkey: 'year',
          // A list of names of data record attributes that contain y-values.
          ykeys: ['value'],
          // Labels for the ykeys -- will be displayed when you hover over the
          // chart.
          labels: ['Value'],
          resize: true
        });
    </script>

    <script type="text/javascript">
      $('.dropdown,.flag_pad').click(function(){
      var li = $(this);
        if(li.hasClass('open')){
          li.removeClass('open');
        }else{
          li.addClass('open');
        }
      });




      $(window).on('resize', function() {
              setTimeout(function(){
//                $(".morris-hover-row-label").attr("style", "margin-top: 80px");
                  }, 500);

      });





    </script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
 
  <script>
  $( function() {
    $( "#from" ).datepicker();
  } );
  $( function() {
    $( "#to" ).datepicker();
  } );
  </script>
 
 