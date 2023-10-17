<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Maintenance {

    public function offline()
    {
//        if($_SERVER['REMOTE_ADDR'] === '210.213.232.26'){
            if (file_exists(APPPATH . 'config/config.php')) {
                include(APPPATH . 'config/config.php');

                if (isset($config['is_offline']) && $config['is_offline'] === TRUE) {
                    $this->show_site_offline();
                    exit;
                }
            }
//        }
    }

    private function show_site_offline() {

        header ("Content-type: text/html; charset=utf-8");

        $arChats	= array("chat_fm","chat_m");
        $ind		= rand(0,1);
        $chat		= $arChats[$ind];

        echo   '

            <!DOCTYPE html>
            <html>
              <head>
                <title>ForexMart under Maintenance</title>
                <link rel="stylesheet" href="https://my.forexmart.com/assets/css/bootstrap.min.css" type=text/css/>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <style>
                    html, body {
                        width:100%;
                        height:100%;
                    }

                    .header {
                        width:100%;
                        border-bottom:1px solid #2988ca;
                    }

                    .maintenance-information {
                        margin:150px auto;
                        display:table;
                        padding:100px 20px;
                        background:#d3edff;
                        border:1px solid #b8dffa;
                    }

                    .maintenance-information p {
                        text-align:center;
                        font-size:18px;
                    }

                    .maintenance-information span {
                        font-size:30px;
                        font-weight:bold;
                        color:#004c81;
                        text-shadow:0 1px #eaf6ff;
                    }

                    @media only screen and (max-width: 767px) {

                        .maintenance-information span {
                            font-size:20px;
                        }

                        .maintenance-information p {
                            font-size:15px;
                        }

                        .maintenance-information {
                            padding:50px 20px;
                        }

                    }

                </style>
              </head>
              <body>
                <div class="header">
                    <div class="container">
                        <div class="row">
                            <div class="header-logo">
                                <img src="https://my.forexmart.com/assets/images/logo.svg" class="img-responsive">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="maintenance-information">
                        <p><span>We apologize ForexMart is currently under maintenance.</span> </br>
                           For any issues, you may reach us at <strong><a href="javascript:;">support@forexmart.com</a></strong></p>
                    </div>
                </div>
              </body>
            </html>';
    }
}