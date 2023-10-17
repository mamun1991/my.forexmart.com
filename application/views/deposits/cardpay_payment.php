<html>
<body onLoad="reloadForm()">
<?php
$test_users = unserialize(TEST_USERS_DEPOSIT);
if(in_array($this->session->userdata('user_id'), $test_users)){
    ?>
    <form class="form-horizontal"  style="display: none;" id="sub" action="https://sandbox.cardpay.com/MI/cardpayment.html" method="POST">
        <input type="hidden" name="orderXML" id="order_xml" VALUE="<?=$order_xml?>"/>
        <input type="hidden" name="sha512" id="sha512" VALUE="<?=$sha512?>"/>
        <input style="display: none" type="submit" value="Cardpay">
    </form>
<?php }else{ ?>
    <form class="form-horizontal"  style="display: none;" id="sub" action="https://cardpay.com/MI/cardpayment.html" method="POST">
        <input type="hidden" name="orderXML" id="order_xml" VALUE="<?=$order_xml?>"/>
        <input type="hidden" name="sha512" id="sha512" VALUE="<?=$sha512?>"/>
        <input style="display: none" type="submit" value="Cardpay">
    </form>
<?php } ?>
</body>
<script>
    function reloadForm(){
        document.getElementById("sub").submit();
    }
</script>

</html>