<script src="<?= $this->template->Js()?>jquery.js"></script>
<body onLoad="document.form.submit();">
<form id="form" name="form" method="post" action="<?php echo $gateway_url?>">
    <input type="hidden" name="items" value="<?php echo $items?>"/>
    <input type="hidden" name="quantity" value="<?php echo $quantity?>"/>
    <input type="hidden" name="amount" value="<?php echo $amount?>"/>
    <input type="hidden" name="currency" value="<?php echo $currency?>"/>
    <input type="hidden" name="total_amount" value="<?php echo $total_amount?>"/>
    <input type="hidden" name="merchant_id" value="<?php echo $merchant_id?>"/>
    <input type="hidden" name="order_id" value="<?php echo $order_id?>"/>
    <input type="hidden" name="client_name" value="<?php echo $client_name?>"/>
    <input type="hidden" name="client_country" value="<?php echo $client_country?>"/>
    <input type="hidden" name="client_city" value="<?php echo $client_city?>"/>
    <input type="hidden" name="client_email" value="<?php echo $client_email?>"/>
    <input type="hidden" name="client_regdate" value="<?php echo $reg_date?>"/>
    <input type="hidden" name="url" value="<?php echo $url?>"/>
    <input type="hidden" name="signature" value="<?php echo $signature?>"/>

    <input type="hidden" name="gateway_id" value="<?php echo "1"?>"/>

    <input type="hidden" name="payment_method" value="<?php echo $payment_method?>"/>
    <input type="hidden" name="success_url" value="<?php echo $success_url?>"/>
    <input type="hidden" name="fail_url" value="<?php echo $fail_url?>"/>
    <input type="hidden" name="callback_url" value="<?php echo $callback_url?>"/>

</form>

<p> Sending data... Please wait...</p>

</body>