<?php $class = $this->router->class; ?>
<?php $method = $this->router->method; ?>
<?php $this->lang->load('register');
header("Content-Type: text/html");
?>
<!DOCTYPE html>
<html lang="<?= FXPP::html_url() ?>" dir="<?= FXPP::lang_dir(); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
<!--    <meta http-equiv="Content-Type" content="text/html";  charset="windows-1252">-->
<!--    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta name="author" content="Ildar Sharipov">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="verify-paysera" content="e4253864f1648dfca5e848eab6854897">
    <meta name="description" content="<?=(isset($metadata_description))? $metadata_description: '';?>">
    <meta name="keywords" content="<?=(isset($metadata_keyword))? $metadata_keyword: '';?>">

    <link rel="icon" type="image/gif" href="<?= $this->template->Images()?>icon.ico" />

    <title><?php echo $template['title']; ?></title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400' rel='stylesheet' type='text/css'>
    <link href="<?= $this->template->Fonts()?>css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core CSS -->

    <?php switch(FXPP::html_url()){
    case 'sa': case 'pk': ?>
            <link type="text/css" href="<?= $this->template->Css()?>arabic/bootstrap-arabic.min.css" rel="stylesheet">
    <?php break;default:?>
            <link type="text/css" href="<?= $this->template->Css()?>bootstrap.min.css" rel="stylesheet">
    <?php } ?>

    <link type="text/css"  href="<?= $this->template->Css()?>internal-style.css" rel="stylesheet">
    <link type="text/css"  href="<?= $this->template->Css()?>custom.css" rel="stylesheet">
    <link type="text/css" href="<?= $this->template->Css()?>custom-internal.min.css" rel="stylesheet">
    <link type="text/css" href="<?= $this->template->Css()?>carousel.css" rel="stylesheet">
    <link type="text/css" href="<?= $this->template->Css()?>mainstyle.css" rel="stylesheet">
    <link type="text/css"  href="<?= $this->template->Css()?>inscrolling-nav.css" rel="stylesheet">
     <?php //if(IPloc::RolloverTest()){ ?>
         <link type="text/css"  href="<?= $this->template->Css()?>notif.css" rel="stylesheet">
         <link type="text/css"  href="<?= $this->template->Css()?>notif-mobile.css" rel="stylesheet">
  
     <?php //} ?>


    <link href="<?= $this->template->Css()?>chat-widget.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>internal-side-nav.css" rel="stylesheet">
    <?=(isset($template['metadata_css']))? $template['metadata_css']: '';?>
    <!-- jQuery -->
    <script type="application/javascript" src="<?= $this->template->Js()?>jquery.js"></script>
    <!-- Owl Carousel Assets -->
    <link type="text/css" href="<?= $this->template->Css()?>owl.carousel.css" rel="stylesheet">
    <link type="text/css" href="<?= $this->template->Css()?>owl.theme.css" rel="stylesheet">
    <link type="text/css" href="<?= $this->template->Css()?>owl.transitions.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>chat-widget.css" rel="stylesheet">


    <?php switch(FXPP::html_url()){ case 'sa': case 'pk': ?>
        <link type="text/css" href="<?= $this->template->Css()?>arabic-style.css" rel="stylesheet">
        <link type="text/css" href="<?= $this->template->Css()?>arabic/custom-arabic-style.css" rel="stylesheet">
        <link type="text/css" href="<?= $this->template->Css()?>arabic/internal-modified-style.css" rel="stylesheet">
    <?php break;default:?>

    <?php } ?>
    <!-- Prettify -->

    <!-- Preloader -->
    <link type="text/css" rel="stylesheet" href="<?= $this->template->Css()?>loaders.css"/>
    <script type="text/javascript">
        $(window).bind('scroll', function() {
            if ($(window).scrollTop() > 95) {
                $('#nav').addClass('nav-fix');
            }
            else {
                $('#nav').removeClass('nav-fix');
            }
        });
    </script>
    <style type="text/css">
        .nav-fix
        {
            position: fixed;
            top: 0;
            z-index: 9999;
            width: 100%;
            transition: all ease 0.3s;
        }
        @media screen and (max-width: 1199px){
            .main-border {
                border-bottom: 1px solid #ccc;
            }
        }
        @media screen and (min-width: 992px){
            .maincont{
                min-height: 755px;
                border-left:1px solid #ccc;
            }
        }
    </style>
    <?=(isset($template['metadata_js']))? $template['metadata_js']: '';?>
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <?php if ( ! FXPP::isEUUrl()) { ?>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-KFS2LSK');</script>
        <!-- End Google Tag Manager -->
    <?php } ?>

            <link type="text/css" href="<?= $this->template->Css()?>language-dropdown.css" rel="stylesheet">

</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">


<?php if ( ! FXPP::isEUUrl()) { ?>
    <!-- Google Tag Manager -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KFS2LSK" height="0" width="0"
                style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->

<?php } ?>

<?php if(!IPLoc::isChinaIP()){ ?>

    <?php if(isset($_SESSION['user_id'])){ $ga_user_id =(string) $_SESSION['user_id']; ?>

    <script type="text/javascript">
        var usrid ='<?=$ga_user_id;?>';
        usrid='88'.concat(usrid).concat('88');
        dataLayer = [{'userID': usrid.toString()}];
    </script>

        <?php }else if(isset($_COOKIE['forexmart_gtm_id'])){ ?>

    <script type="text/javascript">
        var usrid ='<?=$_COOKIE['forexmart_gtm_id'];?>';
        usrid='88'.concat(usrid).concat('88');
        dataLayer = [{'userID': usrid.toString()}];
    </script>

        <?php } ?>
    <?php } ?>

<div >
<?php include_once('nav.php'); ?>

<?php
$getLoginType = $this->session->userdata('login_type');
$incomplete_reg = FXPP::incomplete_reg_pop($this->session->userdata('user_id'));
    if(!$getLoginType){
        if($class != 'accounts' || $method != 'register'){
            if(!$incomplete_reg){ ?>
                <div class="bs-example">
                    <div class="alert alert-info fade in info-container-message">
                        <div class="container info-container-child">
                            <p><span class="info-icon"></span> <strong><?=lang('int_reg_37');?> ForexMart.</strong> <?=lang('int_reg_38');?>

                                   <?=lang('int_reg_57');?><a href="<?php echo  FXPP::loc_url('my-account/register');?>" ><?=lang('int_reg_58');?></a>.
                            </p>
                        </div>
                    </div>
                </div>
<?php }}} ?>

<div class="main-content">
    <div class="container container1">

<!--        internal content-->
        <div class="main-border">
<!--            internal sidebar-->
            <?php include_once('sidebar.php') ?>
<!--            end internal sidebar-->
            <div class="maincont col-lg-9 col-md-9 col-sm-9 arabic-int-main-cont arabic-main-container arabic-secondary-container" style="">
                <div class="section arabic-section arabic-section-title" style="min-height: 500px;">

<!--                    content navigation-->
<!--                    --><?php //include_once('content_nav.php') ?>
<!--                    end content navigation-->

<!--                    dynamic content-->
                    <?=(isset($template['body']))?$template['body']: ''; ?>
<!--                    end dynamic content-->

                </div>
            </div>
            <div class="clearfix">
            </div>
        </div>
<!--        end internal content-->

<!--        bottom nav-->
        
        
        
<!--        end bottom nav-->

    </div>
</div>
</div>
<!--  start modal -->
<?php include_once('modal_feedback.php') ?>
<!--  end modal -->

<!--  session modal -->
<?= $this->load->ext_view('modal', 'session_expire_modal', '', TRUE); ?>
<!--  session modal -->




<!-- footer -->
<?php 

    
  include_once('footer_v2.php');  
    
    

?>

<!-- end footer -->
<a href="#" class="cd-top cd-fade-out ">Top</a>
<!-- mainright -->
<?php include_once('mainright.php') ?>
<!-- mainright -->

<!-- Bootstrap Core JavaScript -->
<?php switch(FXPP::html_url()){
case 'sa':
case 'pk': ?>
        <script type="application/javascript" src="<?= $this->template->Js()?>arabic/bootstrap-arabic.js"></script>
<?php break;default:?>
    <script type="application/javascript" src="<?= $this->template->Js()?>bootstrap.min.js"></script>
<?php } ?>

<script type="application/javascript" src="<?= $this->template->Js()?>session_timeout.js"></script>


<!-- Scrolling Nav JavaScript -->
<script type="text/javascript" src="<?= $this->template->Js()?>jquery.easing.min.js"></script>
<script type="text/javascript" src="<?= $this->template->Js()?>scrolling-nav.js"></script>
<script type="text/javascript" src="<?= $this->template->Js()?>owl.carousel.js"></script>

<!--scroll button at right bottom corner-->
<script type="text/javascript" src="<?= $this->template->Js()?>scrolltotop.min.js"></script>
<!--scroll button at right bottom corner-->
<!-- Demo -->

<?php //if(IPloc::RolloverTest()){ ?>

<script src="<?= $this->template->Js(); ?>jquery.signalR.min.js"></script>
<script src="https://qsvc.forexmart.com:4433/signalr/hubs" ></script> 

<?php //} ?>




<style type="text/css">
    @media screen and (max-width: 991px) {
        .maincont{
            width: 100%;
        }
    }
    #owl-demo .item{
        margin: 3px;
    }
    #owl-demo .item img{
        display: block;
        /*width: 100%;*/
        /*height: auto;*/
    }
</style>


<script type="text/javascript">
    $(document).ready(function() {

        $("#owl-demo").owlCarousel({
            items : 4,
            lazyLoad : true,
            navigation : true
        });

    });
</script>

<?=(isset($template['metadata']))?$template['metadata']: ''; ?>



<script type="application/javascript">

<?php //if(IPloc::RolloverTest()){ ?>

    var notifCount = 0;
        var loadMore = 0;
        var startnotif = 0;
        var isRead = 3;



$(document).ready(function () {

       $('ul.notification-list').on('click', function(event){
           // The event won't be propagated up to the document NODE and
           // therefore delegated events won't be fired
           event.stopPropagation();
       });


       $('#setAllRead').click(function(){
           $(this).addClass('btn-disabled');
           $.ajax({
               type: 'POST',
               url: '/notification/updateNotification',
               data: {type:3},
               dataType: 'json',
               beforeSend: function(){},
               success: function(data) {
                   $('.notification-dot').removeClass('mark-active');
                   $('.notification-alert').text("You haven’t new notifications");

                   $('ul.notification-action li.li-icon-read div.mark-active').attr('data-tempstatus',1);

                   $('ul.notification-action li.li-icon-read div.mark-active').removeClass('mark-active');
         
                   $('.icon-new').removeClass('icons-notification-active').addClass('icons-notification');
               }
           });

       });

       $('ul.notification-list').on('scroll', checkScroll);



       $('[data-toggle="tooltip"]').tooltip();

       $.ajax({
           type: 'POST',
           url: '/notification/getCurrentNotificationCount',
           dataType: 'json',
           beforeSend: function(){},
           success: function(data) {
               notifCount = data.count;
               if(notifCount > 0){
                   $('.icon-new').removeClass('icons-notification').addClass('icons-notification-active');
                   $('.notification-alert').text("Your notifications for the last 30 days")

               }else{
                    $('.icon-new').removeClass('icons-notification-active').addClass('icons-notification');
                    $('.notification-alert').text("You haven’t new notifications");
            


               }


           }
       });



       // for mobile notification
       $(window).on('resize', function(){
           var width = $(window).width();
           if(width < 767){
               $('.drp-notification').appendTo($('#notifMobile'));
           }
           else{
               $('.drp-notification').prependTo($('.secondary-level-menu'));
           }
       }).resize();




       $('.drp-dwn-notif').click(function(){


           $.ajax({
               type: 'POST',
               url: '/notification/getCurrentNotification',
               dataType: 'json',
               data: {start:0},
               beforeSend: function(){
                   $('.notification-loader').show();
               },
               success: function(data) {
                   $('.notification-loader').hide();

                   loadMore = data.loadMore;
                   notifCount = data.unseenNotif;
                   startnotif = data.lastId;

                   $('li.notif-list').remove();
                   $('ul.notification-list').append(data.notifs);

                   countUnreadNotifs();

               }
           });


   });


   });

      var nCount = 1;
        
         
        $.connection.hub.url = "https://qsvc.forexmart.com:4433/signalr";
        var connectionNotification = $.connection.NotificationServiceHub;
        var connectionQoutes = $.connection.QuotesServer;

        // connectionQoutes.client.onServerTime= function(time){
        //     // receive server time
        //    // console.log(time);
        // };

        connectionNotification.client.onFailedToRegisterSession = function () {
            console.log('Failed to register session.');

        };

        connectionNotification.client.onNewNotification = function (data){
            console.log(data);
            // receive live notification (array)

            $('.icon-new').removeClass('icons-notification').addClass('icons-notification-active');
            $('.notification-alert').text("Your notifications for the last 30 days");


           // debugger;
        };

        $.connection.hub.starting(function() {

        });

        $.connection.hub.disconnected(function() {

        });

        $.connection.hub.start().done(function () {
           
            // Subscribe to server time
            connectionQoutes.server.subscribeServerTime();

            if(true){ // call if there is session
               // debugger;
                // use this if there is session for live stream notification
                // params: login, origin, session_id
                connectionNotification.server.registerSession('<?=$_SESSION['account_number'] ?>',0,'<?=$_SESSION['session_id'] ?>');
            }

        });


        function checkScroll(e) {
            var elem = $(e.currentTarget);
            if (elem[0].scrollHeight - elem.scrollTop() == elem.outerHeight())
            {


                if(loadMore > 0){

                    $.ajax({
                        type: 'POST',
                        url: '/notification/getCurrentNotification',
                        dataType: 'json',
                        data: {start:startnotif},
                        beforeSend: function(){
                            $('.notification-loader').show();
                        },
                        success: function(data) {
                            $('.notification-loader').hide();
                            loadMore = data.loadMore;
                            notifCount = data.unseenNotif;
                            startnotif = data.lastId;

                            $('ul.notification-list').append(data.notifs);

                            countUnreadNotifs();

                        }
                    });
                }
            }

        }



        function updateNotification(id,status,type){ //0 unread , 1 read
             //status = (isRead == 3) ?  status : isRead;

            var tempstatus = $('#notif-read-'+id).attr('data-tempstatus');
          
            if(type == 2){
                var status = (tempstatus == '1') ? false : true;
                var notifURL = (tempstatus == '1') ? '/notification/setUnread' : '/notification/setRead';

            }else{
                var notifURL = '/notification/updateNotification';
            }


           // if true the notification will mark as read, if false will mark as unread.
            $.ajax({
                type: 'POST',
                url: notifURL,
                
                
                dataType: 'json',
                data: {id: id, status: status, type: type},
                beforeSend: function () {
                    //  $('.icon-container').show();
                },
                success: function (data) {
                    // $('.icon-container').hide();
                    if(type == 1){
                        $('.notif-item-'+id).hide();
                    }else{
                        if(data.success){
                         
                            var attrval = status ? 1 : 0;
                            $('#notif-read-'+id).attr('data-tempstatus',attrval);

                            if($('#notif-read-'+id).hasClass('mark-active')){
                                $('#notif-read-'+id).removeClass('mark-active');
                                $('#notif-read-'+id).tooltip('hide').attr('data-original-title', 'set as unread').tooltip('show');
                             } else{
                                $('#notif-read-'+id).addClass('mark-active');
                                $('#notif-read-'+id).tooltip('hide').attr('data-original-title', 'set as read').tooltip('show');
                            }     

                        
                            countUnreadNotifs();
                        }

                    }


                }
            });
        }// end func

        function countUnreadNotifs(){
            var unreadCount =   parseInt($('ul.notification-action li.li-icon-read div.mark-active ').length);
            if(unreadCount > 0){
            notifExist();
            }else{
            setAllRead();
            }
    
            console.log(unreadCount);

        }

      
     // functions for setAllRead
     function setAllRead(){
        $('.icon-new').removeClass('icons-notification-active').addClass('icons-notification');
        $('.notification-alert').text("You haven’t new notifications");
    }

    // function for notification exist
    function notifExist(){
        $('.icon-new').removeClass('icons-notification').addClass('icons-notification-active');
        $('.notification-alert').text("Your notifications for the last 30 days");;
    }



<?php //} ?>


// deposit page visitor get
$(document).ready(function(){
   setTimeout(function(){
    var str ="<?=current_url()?>";
    var nview = str.search("deposit");
    if(nview!=-1){
        var res = str.split("deposit/");         
        if (typeof res[1]== 'undefined'){
          depositPageVisitorDataSend(str);
        }
    }
    },(5*60*1000));
 });
function depositPageVisitorDataSend(url) {
     var base_url='<?=  base_url()?>';
   $.post(base_url+'deposit/depositPageVisitorInformatin',{current_url:url},function(view){
    //   alert(view);
       console.log(view);
   });
}








$(function(){
    $("#SearchInInternal").attr("placeholder","<?=lang('search');?>");
    $("#SearchInInternal").attr("placeholder","<?=lang('search');?>");
    $("#SearchInInternal").attr("placeholder","<?=lang('search');?>");
    <?php if($this->session->userdata('readOnly')){?>
	$("input,button").attr("disabled",true);
    $("#live-client-status").text("Read Only");

    $("#date_start").attr("disabled",false);
    $("#date_end").attr("disabled",false);
    <?php }?>
	
    $("#navbar-menu-1").attr("disabled",false);
    $("#navbar-menu-2").attr("disabled",false);
	$("#tab3 :input").attr("disabled", false);
	$("#tab3 :button").attr("disabled", false);
});
</script>
    
<?php if ($this->uri->segment(1) == 'zh') { ?>
    <!--Start of Tawk.to Script (Chinese)-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/5945fcbbe9c6d324a4735f4e/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
<?php } else { ?>
<!--Start of Tawk.to Script (All)-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function () {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/5917fdcd64f23d19a89b20c2/default';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<?php } ?>

<?php /**if(IPLoc::VPN_IP_Jenalie()){ //FXMAIN-804?>
    <script>
        var startTime = (new Date()).getTime();
    </script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script>
        $(window).load(function () {
            var endTime = (new Date()).getTime();
            var millisecondsLoading = endTime - startTime;
            console.log("Loading time: "+millisecondsLoading);
        });
    </script>
<?php } */?>

<?php 
if(!IPLoc::Office()){
    exit();
}


if(IPLoc::IPOnlyForTq()){ ?>

    <script type="text/javascript">

       // initSession();
        // $('#session_expire_modal').modal('show');
    </script>



<?php }





?>