<?php /** Start Temporary CSS - Joms*/?>
    <style type="text/css">
        a.btn-deposit:hover
        {
            text-decoration: none;
        }
        a.btn-withdraw:hover
        {
            text-decoration: none;
        }
        .btn-deposit-holder a:hover{
            color: #fff;
        }
        .btn-withdraw-holder a:hover{
            color: #fff;
        }
        .btn-deposit
        {
            display: table;
            margin-top: 10px;
            background: #29a643;
            color: #fff;
            border: none;
            padding: 7px 75px !important;
            font-size: 16px !important;
            font-family: Open Sans;
            text-decoration: none;
        }
        .btn-withdraw
        {
            display: table;
            margin-top: 10px;
            background: #2988CA;
            color: #fff;
            border: none;
            padding: 7px 68px !important;
            font-size: 16px !important;
            font-family: Open Sans;
            text-decoration: none;
        }

    </style>
<?php /** End Temporary CSS - Joms*/?>
    <div class="col-lg-3 col-md-3 col-sm-3">
        <div class="dl-holder">

            <div class="side-nav-holder">
                <ul class="side-nav">
                    <li><a href="<?php echo base_url();?>mailer" class="<?=($active_tab == 'mailer') ? 'active-sidenav' : '';?>"> <i class="fa fa-user"></i><cite>Mailer</cite></a></li>
                    <li><a href="<?php echo base_url();?>mailer/setting" class="<?=($active_tab == 'setting') ? 'active-sidenav' : '';?>"><i class="fa fa-cog"></i><cite>Settings</cite></a></li>
                    <li><a href="<?php echo base_url();?>mailer/email" class="<?=($active_tab == 'email_tab') ? 'active-sidenav' : '';?>"><i class="fa fa-envelope"></i><cite>Email</cite></a></li>
                </ul><div class="clearfix"></div>
            </div>
        </div>
    </div>