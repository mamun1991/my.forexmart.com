<html lang="en">
<body onload='reloadForm()'>
<form id="sub" action="<?=$link?>" method="post">
    <input type="hidden" name="pay_to_email" value="<?=$pay_to_email?>">
    <input type="hidden" name="transaction_id" value="<?=$transaction_id?>">
    <input type="hidden" name="return_url" value="<?=$return_url?>">
    <input type="hidden" name="cancel_url" value="<?=$cancel_url?>">
    <input type="hidden" name="status_url" value="<?=$status_url?>">
    <input type="hidden" name="language" value="<?=$language?>">
    <input type="hidden" name="amount" value="<?=$amount?>">
    <input type="hidden" name="currency" value="<?=$currency?>">
    <input type="hidden" name="detail1_description" value="<?=$detail1_description?>">
    <input type="hidden" name="detail1_text" value="<?=$detail1_text?>">
    <input type="hidden" name="merchant_fields" value="<?=$merchant_fields?>">
    <input type="hidden" name="user_id" value="<?=$user_id?>">
    <input style="display: none" type="submit" value="Pay!">
</form>
</body>
</html>

  
<script>
    function reloadForm(){
      document.getElementById("sub").submit();
    }
</script>

 