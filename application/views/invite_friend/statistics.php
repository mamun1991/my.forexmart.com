<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>

<?php $this->view('invite_friend/nav'); ?>

<script src="<?= $this->template->Js() ?>highcharts.js"></script>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="pass" style="min-height: 320px;">
        <div class="row">

            <div class="col-md-12 tab-res-holder">
                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto;direction: ltr;"></div>
                <br>
                <h3 class="stat-title">My referrals</h3>

                <div class="table-responsive">
                    <table class="table table-striped ref-table center" id="refferalTbl">
                        <thead>
                        <tr>
                            <th rowspan="2">Name </th>
                            <th rowspan="2">Email</th>
                            <th rowspan="2">Language</th>
                            <th rowspan="2">Date</th>
                            <th rowspan="2">Status </th>
                            <th colspan="3">
                                Bonus
                                <i id="referral" class="fa fa-question-circle caret-right" data-toggle="tooltip"
                                   data-placement="left"
                                   title="The bonus sum is equal to the half of friend's initial deposit (but doesn't exceed $100)."></i>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Virtual
                                <i id="referral" class="fa fa-question-circle caret-right" data-toggle="tooltip"
                                   data-placement="right"
                                   title="For each $3 of bonus credited virtually, friend must trade 0.1 lots. Bonus can be traded-out partially. "></i>
                                </a>
                            </th>
                            <th>
                                Real
                                <i id="referral" class="fa fa-question-circle caret-right" data-toggle="tooltip"
                                   data-placement="left"
                                   title="Friend already met the condition, real bonus can be done in two ways: Credit: Real Bonus will be added to trading funds, Withdraw: Withdraw the funds."></i>
                                </a>
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php

                        if ($ref) {
                            foreach ($ref as $d) {
                                ?>
                                <tr class="inv<?= $d->inv_id ?>">
                                    <td> <?= $d->name ?></td>
                                    <td> <?= $d->email ?></td>
                                    <td> <?= isset($language_array[$d->language]) ? $language_array[$d->language] : '' ?></td>
                                    <td> <?= $d->date ?></td>
                                    <td>
                                        <?php
                                        if (strlen($d->user_id_after_registration) > 0) {
                                            ?>
                                            Referral
                                            <i id="referral" class="fa fa-question-circle caret-right"
                                               data-toggle="tooltip" data-placement="right"
                                               title="Friend opens account by following user’s link."></i>

                                        <?php } else { ?>
                                            Invited
                                            <i id="invited" class="fa fa-question-circle caret-right"
                                               data-toggle="tooltip" data-placement="right"
                                               title="Friend got the message, but hasn’t opened account yet."></i>
                                        <?php } ?>
                                    </td>


                                    <td class="vartual"
                                        data-volumeAmount="<?= isset($bonus[$d->user_id_after_registration]) ? $bonus[$d->user_id_after_registration]['volume_amount'] : "0"; ?>"><?php
                                        if (strlen($d->user_id_after_registration) > 0) {
                                            echo isset($bonus[$d->user_id_after_registration]) ? $bonus[$d->user_id_after_registration]['virtual'] : "0";
                                        } else {
                                            echo "-";
                                        }
                                        ?></td>
                                    <td class="real"><?php
                                        if (strlen($d->user_id_after_registration) > 0) {
                                            echo isset($bonus[$d->user_id_after_registration]) ? $bonus[$d->user_id_after_registration]['cash'] : "0";
                                        } else {
                                            echo "-";
                                        }
                                        ?></td>
                                    <td>
                                        <button onclick="credit('<?= $d->inv_id ?>')" class="bonus-real-btn">Credit
                                        </button>
                                        <button onclick="withdraw('<?= $d->inv_id ?>')" class="bonus-real-btn">
                                            Withdraw
                                        </button>
                                    </td>
                                </tr>

                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="8" class="center">
                                    <?= lang('ibe_10'); ?>
                                </td>
                            </tr>
                        <?php } ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Invite friend</h4>
            </div>
            <div class="modal-body">
                <div class="amount">
                    <div class="text-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> You have
                        credited <span class="credit_amount"></span> in to your balance
                    </div>
                </div>
                <div class="zeroAmount">
                    <div class="text-success"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                        <span class="message"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>


<script>


    function credit(id) {
        $(".amount").hide();
        $(".zeroAmount").hide();
        var url = "<?=FXPP::ajax_url('invite-friend/credit')?>";

        var vartual = $(".inv" + id).closest('tr').find('.vartual').text();
        var real = $(".inv" + id).closest('tr').find('.real').text();
        var volumeAmount = $(".inv" + id).closest('tr').find('.vartual').data('volumeamount');

        $(".credit_amount").text(real);

        if (parseFloat(volumeAmount) > 0 && parseFloat(real) == 0 && parseInt(parseFloat) == 0) {

            $(".zeroAmount").show();
            $(".message").text("You already earn the bonus from your friend.");
            $("#myModal").modal('show');

            return false;
        }

        if (parseFloat(real) == 0 && parseFloat(vartual) > 0) {
            $(".zeroAmount").show();
            $(".message").text("Your friend need to trade specific lots to convert the virtual bonus to real bonus.");
            $("#myModal").modal('show');

            return false;
        }
        if (vartual == '-') {
            $(".zeroAmount").show();
            $(".message").text("Friend got the message, but hasn’t opened account yet.");
            $("#myModal").modal('show');

            return false;
        }
        if (vartual == 0) {
            $(".zeroAmount").show();
            $(".message").text("Your friend need to deposit to earn virtual bonus.");
            $("#myModal").modal('show');

            return false;
        }
        $("#loader-holder").show();
        $.post(url, {id: id}, function (data) {

            if (data == 'done') {
                $(".credit_amount").text(real);
                $("#myModal").modal('show');
                $(".amount").show();

                $(".inv" + id).closest('tr').find('.vartual').text(parseInt(vartual) - parseInt(real));
                $(".inv" + id).closest('tr').find('.real').text(0)

            }
            $("#loader-holder").hide();
        })
    }
    function withdraw(id) {

        var vartual = $(".inv" + id).closest('tr').find('.vartual').text();
        var real = $(".inv" + id).closest('tr').find('.real').text();
        var volumeAmount = $(".inv" + id).closest('tr').find('.vartual').data('volumeamount');

        $(".credit_amount").text(real);

        if (parseFloat(volumeAmount) > 0 && parseFloat(real) == 0 && parseFloat(vartual) == 0) {

            $(".zeroAmount").show();
            $(".message").text("You already earn the bonus from your friend.");
            $("#myModal").modal('show');

            return false;
        }

        if (parseFloat(real) == 0 && parseFloat(vartual) > 0) {
            $(".zeroAmount").show();
            $(".message").text("Your friend need to trade specific lots to convert the virtual bonus to real bonus");
            $("#myModal").modal('show');

            return false;
        }
        if (vartual == '-') {
            $(".zeroAmount").show();
            $(".message").text("Friend got the message, but hasn’t opened account yet.");
            $("#myModal").modal('show');

            return false;
        }
        if (vartual == 0) {
            $(".zeroAmount").show();
            $(".message").text("Your friend need to deposit to earn virtual bonus.");
            $("#myModal").modal('show');

            return false;
        }

        window.location.href = "<?=FXPP::ajax_url('withdraw/invite_friend')."?id="?>" + id;
    }
    $(function () {
        $('#container').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'Monthly Average Statistics of Partners Account.'
            },
            subtitle: {
                text: 'Partners Account'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Person'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [
                {
                    name: 'Sent via email',
                    data: [<?=$invite?>]
                },
                {
                    name: 'Using the referral link',
                    data: [<?=$referal?>]
                }
            ]
        });
    });
</script>
<script>

    $(document).ready(function() {
        $('#refferalTbl').DataTable();
    } );

</script>
<style>

    th:last-child  {
       background-image: none!important;
    }
    .amount {
        display: none;
    }

    .zeroAmount {
        display: none;
    }

    #refferalTbl th {
        vertical-align: top !important;
    }

    .bonusMore {
        border: 1px solid #000000 !important;
        font-size: 11px !important;
        padding: 3px !important;
    }

    .ref-table {
        /*margin-top: 20px;*/
    }

    .ref-table thead tr {
        background: #A0A0A0;
        color: #fff;
        font-family: Open sans;
        font-weight: 600 !important;
    }

    .ref-table thead tr th {
        border: 1px solid #bbb;
    }

    .ref-table thead tr th, .ref-table tbody tr td {
        text-align: center;
        vertical-align: middle;
        padding-right: 3px;
        padding-left: 3px;
    }

    .caret-right {
        float: right;
        margin-top: 3px;
        margin-left: 3px;
        color: #2988ca;
    }

    .bonus-real-btn {
        border: none;
        font-size: 13px;
        background: #2988ca;
        color: #fff;
        padding: 4px 8px;
    }

    .stat-title {
        font-family: Open Sans;
        font-size: 17px;
        font-weight: 600;
        color: #333;
        padding: 0;
        margin-top: 0;
    }
</style>