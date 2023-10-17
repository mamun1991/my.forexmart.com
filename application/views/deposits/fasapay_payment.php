<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

</head>
<body onload='reloadForm()' style="margin: 0 auto;width: 900px;">


<h2 style="margin-top: 20%; text-align: center">You are now being redirected to Fasapay payment gateway, please wait.</h2>

<div style="    margin: 0 auto;" class="loader"></div>


<form id="sub" method="post" action="<?=$link?>">
    <input type="hidden" name="fp_acc" value="<?=$fp_acc?>">
    <input  type="hidden" name="fp_store"  value="Forex Mart">
    <input type="hidden" name="fp_acc_from" value="<?=$fp_acc_from?>">
    <input type="hidden" name="fp_item" value="ForexMart Deposit">
    <input type="hidden" name="fp_amnt" value="<?=$fp_amnt?>">
    <input type="hidden" name="fp_currency" value="<?=$fp_currency?>">
    <input type="hidden" name="fp_comments" value="<?=$fp_comments?>">
    <input type="hidden" name="fp_success_url" value="<?=$fp_success_url?>" />
    <input type="hidden" name="fp_success_method" value="POST" />
    <input type="hidden" name="fp_fail_url" value="<?=$fp_fail_url?>" />
    <input type="hidden" name="fp_fail_method" value="POST" />
    <input type="hidden" name="fp_status_url" value="<?=$fp_status_url?>" />
    <input type="hidden" name="fp_status_method" value="POST" />
    <input type="hidden" name="fp_status_form_url" value="<?=$fp_status_from?>" />
    <input type="hidden" name="fp_status_form_method" value="POST" />
    <!-- additional fields -->
    <input type="hidden" name="track_id" value="<?=$track_id?>">
    <input type="hidden" name="order_id" value="<?=$order_id?>">
    <input type="hidden" name="bonus" value="<?=$bonus?>">
    <input style="display: none" type="submit">
</form>

<script>

    history.pushState(null, null, '/deposit/fasapay/redirect');
    function reloadForm(){
        document.getElementById("sub").submit();
    }
</script>


</body>
</html>



