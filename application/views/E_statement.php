<style>
    .btn-con {
        text-align: right;
        padding: 16px;
    }
    .btn-con:lang(sa) {
        text-align: left !important;
    }
@media only screen and (max-width:1000px){
	.btn-con {
        text-align: center;
    }
}
</style>

<h1>
    E-statement
</h1>

<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active">
        <div class="row">
            <div class="col-sm-9 col-centered trns-holder">
                <form class="form-horizontal" method="POST" id="frm-epayments">

                    <div class="form-group">
                        <label class="col-sm-4 lbl-txt arabic-form-finance"> From: </label>
                        <div class="col-sm-6">
                            <input type="text" name="from" class="form-control round-0 required-field" id="from">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 lbl-txt arabic-form-finance"> To: </label>
                        <div class="col-sm-6">
                            <input type="text" name="to" class="form-control round-0 required-field" id="to">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 lbl-txt arabic-form-finance"> File type: </label>
                        <div class="col-sm-6">
                            <select class="form-control round-0" name="file_type" id="file_type">
                                <option value="csv">CSV</option>
                                <option value="pdf">PDF</option>
<!--                                <option value="word">WORD</option>-->
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 lbl-txt arabic-form-finance"> Transaction type: </label>
                        <div class="col-sm-6">
                            <select class="form-control round-0" name="transaction_type">
                                <option value="">All</option>
                                <option value="Deposits">Deposit</option>
                                <option value="Withdraws">Withdrawal</option>
                                <option value="Transfers">Transfer</option>
                                <option value="Bonuses">Bonus</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-6 btn-con">
                            <a class="btn-withdraw-option" id="btn_search">Search</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">

    var base_url = "<?php echo base_url();?>";

    $("#from").datetimepicker({
        format: "YYYY/MM/DD"
    });
    $("#to").datetimepicker({
        format: "YYYY/MM/DD"
    });


    $(document).ready(function(){

        $('a#btn_search').click(function(){
            jQuery.ajax({
                type: "POST",
                url: base_url + "e-statement/generate-epayments",
                data: jQuery('#frm-epayments').serialize(),
                dataType: 'json',
                beforeSend: function () {
                    $('#loader-holder').show();
                },
                success: function (x) {
                    var file_type = $('#file_type').val();
                    if(file_type == 'pdf'){
                        window.location= base_url+"e-statement/pdf/";
                    }else{
                        window.location= base_url+"e-statement/download_file/";
                    }

                    $('#loader-holder').hide();

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#loader-holder').hide();
                }
            });
        });

    });
</script>