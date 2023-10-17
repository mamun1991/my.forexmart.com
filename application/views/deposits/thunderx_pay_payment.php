<html lang="en">
<body onload='reloadForm()'>
<form id="sub" action="<?=$api_url?>" method="post">   
        <input type="hidden" name="transaction_code" value="<?=$transaction_code?>">
	<input type="hidden" name="auth_username" value="<?=$auth_username?>">
	<input type="hidden" name="auth_password" value="<?=$auth_password?>">
	<input type="hidden" name="txpay_id" value="<?=$txpay_id?>">
        
	<input type="hidden" name="account_number" value="<?=$account_number?>">
	<input type="hidden" name="person_name" value="<?=$person_name?>">
	<input type="hidden" name="person_email" value="<?=$person_email?>">
	<input type="hidden" name="person_phone" value="<?=$person_phone?>">
	<input type="hidden" name="deposit_amount" value="<?=$deposit_amount?>"> 
	<input type="hidden" name="currency" value="<?=$currency?>"><!-- LAK=Laos , MMK = myanmar, THB=Thai Bath, KHR=Cambodia -->
	<input type="hidden" name="bank_code" value="<?=$bank_code?>">
	<input type="hidden" name="bank_account_number" value="<?=$bank_account_number?>"> 
	<input type="hidden" name="card_image" value="<?=$base_card_image?>" placeholder="card image">
	<input type="hidden" name="idcard_number" value="<?=$idcard_number?>">
        
	<input type="hidden" name="callback_url" value="<?=$callback_url?>">   
    
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
