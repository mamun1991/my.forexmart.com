<?php $class = $this->router->class; ?>
<!DOCTYPE html>
<html lang="en">

<head>


  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <meta name="author" content="">   
    
    <meta name="description" content="<?=(isset($metadata_description))? $metadata_description: '';?>">
    <meta name="keywords" content="<?=(isset($metadata_keyword))? $metadata_keyword: '';?>">
    <link rel="icon" type="image/gif" href="<?= $this->template->Images()?>icon.ico" />

      <title><?php echo $template['title']; ?></title>
    
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400' rel='stylesheet' type='text/css'>
    <link href="<?= $this->template->Fonts()?>css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core CSS -->
    <link href="<?= $this->template->Css()?>bootstrap.min.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>internal-style.css" rel="stylesheet">
    <script src="<?= $this->template->Js()?>jquery-1.11.3.min.js"></script>
    <!-- Custom CSS -->
    <link href="<?= $this->template->Css()?>inscrolling-nav.css" rel="stylesheet">

    <!-- Owl Carousel Assets -->
    <link href="<?= $this->template->Css()?>owl.carousel.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>owl.theme.css" rel="stylesheet">

    <!-- Prettify -->
    <link rel="stylesheet" href="<?= $this->template->Css()?>jquery.switchButton.css">
    <link rel="stylesheet" href="<?= $this->template->Css()?>jquery.fileupload.css">
   
    
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
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <style>
        .nav-fix
        {
            position: fixed;
            top: 0;
            z-index: 9999;
            width: 100%;
            transition: all ease 0.3s;
        }
    </style>
    <script type="text/javascript">
        $( document ).ready(function() {   
            $(".compose").click(function(){
                $("#compose-form").show();
            });
        });
    </script>
    
</head>

 




<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<?php include_once('nav.php') ?>
    
    <div class="internal-nav-holder">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 int-col-12">
                    <div class="internal-nav">
                        <ul>
                            <li><a href="#">Mailer</a></li>
                            <li><a href="#">Manage Bonus</a></li>
                            <li><a href="#">Account Verification</a></li>
                            <li><a href="#" class="active-int-nav">Manage Access</a></li>
                            <li><a href="#">Withdrawal Queue</a></li>
                            <div class="clearfix"></div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        
        <?=(isset($template['body']))?$template['body']: ''; ?>
        
    </div>
    <?php include_once('bottom_nav.php') ?>
    <!-- modal -->

    <!-- end modal -->

    <!-- footer -->
<?php include_once('footer.php') ?>

    <!-- end footer -->

    <!-- modal -->
    <div class="modal fade" id="addmanager" tabindex="-1" role="dialog" aria-labelledby="">
        <div class="modal-dialog round-0">
            <div class="modal-content round-0">
                <div class="modal-header round-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title-sub">Add New Manager</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10 col-centered">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">Email</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control round-0">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">Full Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control round-0">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">Password</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control round-0">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">Re-enter Password</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control round-0">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="slideThree">
                                            <input type="checkbox" value="None" id="slideThree" name="slidebox" onclick="exefunction()" style="display: none;"/>
                                            <label for="slideThree"></label>
                                        </div>
                                        <label>Auto-generated password.</label>
                                    </div>
                                </div>
                                <label>Set Permission</label>
                                <p class="manage-text">Set which admin pages are accessible for the Manager</p>
                                <div class="chk-permission-holder">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Mailer
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Account Verification
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Manage Access
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Withdrawal Queue
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Manage Accounts
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Manage News
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer round-0">
                    <button type="button" class="btn btn-primary round-0"><?= lang('reb_txt_17'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="manageedit" tabindex="-1" role="dialog" aria-labelledby="">
        <div class="modal-dialog round-0">
            <div class="modal-content round-0">
                <div class="modal-header round-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title-sub">Edit Manager</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10 col-centered">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">Email</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control round-0">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">Full Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control round-0">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">Password</label>
                                    <div class="col-sm-6">
                                        <a href="#" class="manage-reset-password">Reset Password</a>
                                    </div>
                                </div>
                                <label>Set Permission</label>
                                <p class="manage-text">Set which pages are accessible for this Manager.</p>
                                <div class="chk-permission-holder">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Mailer
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Account Verification
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Manage Access
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Withdrawal Queue
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Manage Accounts
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Manage News
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer round-0">
                    <button type="button" class="btn btn-primary round-0">Update</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="managepermisssion" tabindex="-1" role="dialog" aria-labelledby="">
        <div class="modal-dialog round-0">
            <div class="modal-content round-0">
                <div class="modal-header round-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title-sub">Manage Permission</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10 col-centered">
                            <form class="form-horizontal">
                                <p class="manage-text">Set which pages can be accessed by <span>John Smith</span></p>
                                <div class="chk-permission-holder">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Mailer
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Account Verification
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Manage Access
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Withdrawal Queue
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Manage Accounts
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Manage News
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer round-0">
                    <button type="button" class="btn btn-primary round-0">Update</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editbonus" tabindex="-1" role="dialog" aria-labelledby="">
        <div class="modal-dialog round-0">
            <div class="modal-content round-0">
                <div class="modal-header round-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Bonus</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-centered">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">Account Number:</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control round-0">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">Sum:</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control round-0">
                                    </div>
                                    <label for="" class="col-sm-1 control-label">USD</label>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">30% bonus:</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control round-0">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="" class="control-label">USD</label>
                                        <a href="#" class="cancel-bonus">Cancel Bonus</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer round-0">
                    <button type="button" class="btn btn-primary round-0">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->
    
    
    
    
    
    <!-- jQuery -->
    <script src="<?= $this->template->Js()?>jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= $this->template->Js()?>bootstrap.min.js"></script>

    <!-- Scrolling Nav JavaScript -->
    <script src="<?= $this->template->Js()?>jquery.easing.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <script src="<?= $this->template->Js()?>jquery.switchButton.js"></script>
    <script src="<?= $this->template->Js()?>jquery.ui.widget.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="<?= $this->template->Js()?>jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="<?= $this->template->Js()?>jquery.fileupload.js"></script>

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
    </style>


    <script>
    $(document).ready(function() {

      $("#owl-demo").owlCarousel({
        items : 4,
        lazyLoad : true,
        navigation : true
      });

    });
    </script>
     <script>
      $(function() {
        $('#basic.demo input').switchButton();

        $('#basic2.demo input').switchButton();

        $("#labels.demo input").switchButton({
          on_label: 'YES',
          off_label: 'NO'
        });

        $("#default.demo input").switchButton({
          checked: false
        });

        $("#labels2-1.demo input").switchButton({
          show_labels: false
        });

        $("#labels2-2.demo input").switchButton({
          labels_placement: "right"
        });

        $("#labels2-3.demo input").switchButton({
          labels_placement: "left"
        });

        $("#slider-1.demo input").switchButton({
          width: 100,
          height: 40,
          button_width: 50
        });

        $("#slider-2.demo input").switchButton({
          width: 100,
          height: 40,
          button_width: 70
        });
      })
    </script>
</body>













</html>
