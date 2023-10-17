<body onLoad="document.form.submit();">
    <form id="form" name="form" action="<?php echo $form_url ?>" method="post">
        <input type="hidden" name="button_type_id" value="1"/>
        <input type="hidden" name="variables" value="<?php echo $variables ?>"/>
        <input type="hidden" name="item_name" value="<?php echo $item_name ?>"/>
        <input type="hidden" name="item_id" value="<?php echo $item_id ?>"/>
        <input type="hidden" name="currency" value="<?php echo $currency ?>"/>
        <input type="hidden" name="amount" value="<?php echo $amount ?>"/>
        <input type="hidden" name="cancel_url" value="<?php echo $cancel_url ?>" />
        <input type="hidden" name="finish_url" value="<?php echo $finish_url ?>" />
        <input type="hidden" name="business_email" value="<?php echo $business_email ?>"/>
    </form>
</body>