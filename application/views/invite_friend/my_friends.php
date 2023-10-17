<style>
    .one1 {
        margin: 5px 0;
    }

    .two2 {
        margin: 5px 0;
    }

    @-moz-document url-prefix() {
        @media screen and (max-width: 390px) {
            .two2:lang(en) {
                padding: 6px 89px !important;
            }

            .two2:lang(ru) {
                padding: 6px 98px !important;
            }

            .two2:lang(jp) {
                padding: 6px 63px !important;
            }

            .two2:lang(id) {
                padding: 6px 55px !important;
            }

            .two2:lang(de) {
                padding: 6px 91px !important;
            }

            .two2:lang(fr) {
                padding: 6px 79px !important;
            }

            .two2:lang(it) {
                padding: 6px 92px !important;
            }

            .two2:lang(sa) {
                padding: 6px 84px !important;
            }

            .two2:lang(es) {
                padding: 6px 105px !important;
            }

            .two2:lang(pt) {
                padding: 6px 68px !important;
            }

            .two2:lang(bg) {
                padding: 6px 97px !important;
            }

            .two2:lang(my) {
                padding: 6px 84px !important;
            }
        }
    }

    @media screen and (-webkit-min-device-pixel-ratio: 0) and (max-width: 390px) {
        .two2:lang(en) {
            padding: 6px 85px !important;
        }

        .two2:lang(ru) {
            padding: 6px 98px !important;
        }

        .two2:lang(jp) {
            padding: 6px 60px !important;
        }

        .two2:lang(id) {
            padding: 6px 55px !important;
        }

        .two2:lang(de) {
            padding: 6px 88px !important;
        }

        .two2:lang(fr) {
            padding: 6px 75px !important;
        }

        .two2:lang(it) {
            padding: 6px 87px !important;
        }

        .two2:lang(sa) {
            padding: 6px 80px !important;
        }

        .two2:lang(es) {
            padding: 6px 100px !important;
        }

        .two2:lang(pt) {
            padding: 6px 64px !important;
        }

        .two2:lang(bg) {
            padding: 6px 97px !important;
        }

        .two2:lang(my) {
            padding: 6px 81px !important;
        }
    }

    .ref-table {
    }

    .ref-table thead tr {
        background: #a0a0a0 none repeat scroll 0 0;
        color: #fff;
        font-family: Open sans;
        font-weight: 600 !important;
    }

    .ref-table thead tr th {
        border: 1px solid #bbb;
    }

    .ref-table thead tr th, .ref-table tbody tr td {
        padding-left: 3px;
        padding-right: 3px;
        text-align: center;
        vertical-align: middle;
    }

    .caret-right {
        color: #2988ca;
        float: right;
        margin-left: 3px;
        margin-top: 3px;
    }

    .bonus-real-btn {
        background: #2988ca none repeat scroll 0 0;
        border: medium none;
        color: #fff;
        font-size: 13px;
        padding: 4px 8px;
    }

    .stat-title {
        color: #333;
        font-family: Open Sans;
        font-size: 17px;
        font-weight: 600;
        margin-top: 0;
        padding: 0;
    }
    .red{color: red;}

</style>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>

<?php $this->view('invite_friend/nav'); ?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Send Invite</h4>
            </div>
            <div class="modal-body">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Invite friend email has been sent to
                <span class="invite_email"></span>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="pass" style="min-height: 320px;">
        <div class="row">
            <div class="col-md-12 btn-sync-holder tab-res-holder">
                <a href="<?= $url ?>" class="btn-sync"><?= lang('mf_00'); ?></a>
                <!-- <a href="#" class="btn-sync">Send</a> -->
                <?php ?>


                <br><br>
                <div class="table-responsive">
                    <table id="my_friends" class="table table-striped part-table">
                        <thead>
                        <tr>
                            <th>Email</th>
                            <th>Full Name</th>
                            <th><?= lang('reb_txt_13'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($email) {
                            foreach ($email as $d) {
                                ?>
                                <tr>
                                    <td><?php echo $d->email; ?></td>
                                    <td>
                                        <input  <?php if ($d->invited == 1) {
                                            echo "readonly";
                                        } ?> id="inv-<?= $d->id; ?>" type="text" class="form-control round-0"
                                             value="<?= $d->name ?>">
                                        <span class="red"></span>
                                    </td>
                                    <td>
                                        <?php if ($d->invited == 0) {

                                            ?>
                                            <button <?php echo $d->ex_email == 1 ?"disabled":"";?> onclick="sendInvite(<?= $d->id; ?>,'<?= $d->email ?>')"
                                                    class="bonus-real-btn <?= $d->id; ?>">Send Invite
                                            </button>
                                        <?php } else { ?>
                                            <button class="bonus-real-btn" disabled >Already Invited</button>
                                        <?php }; ?>
                                    </td>
                                </tr>


                            <?php

                            }
                        } else {
                            echo "<tr> <td colspan='3'>" . lang('ibe_10') . "</td></tr>";
                        }

                        ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    var base_url = "<?=FXPP::ajax_url()?>";

    function sendInvite(id, email) {


        var name = $("#inv-" + id).val();
        if(name.length<1){
            $("#inv-" + id).closest('td').find(".red").text('This field is required');
            return false;
        }else{
            $("#inv-" + id).closest('td').find(".red").text('');
        }

        $(".loader-holder").show();
        $.post(base_url + "invite_friend/sendInviteUsingSyncEmail", {id: id, name: name}, function (data) {
            $(".invite_email").text(email);
            $(".loader-holder").hide();
            $("." + id).text("Already Invited");
            $("." + id).attr("onclick", '');
            $("#inv-" + id).attr("readonly", true);
            $("#myModal").modal('show');


        })
    }

    $("#my_friends").DataTable();

</script>


