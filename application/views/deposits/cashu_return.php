<!DOCTYPE html>
<html>
<body onLoad="reloadForm()">
    <form id="cashu" method="post" action="<?php echo base_url('deposit/cashu') ?>">
        <input type="hidden" name="payment_success" value="1">
    </form>
</body>
<script>
    function reloadForm(){
        document.getElementById("cashu").submit();
    }
</script>