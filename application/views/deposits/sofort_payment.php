<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
</head>
<body onload='reloadForm()'>
<code>
  
  
    
<form id="form"  method="post" action="https://www.sofort.com/payment/start">
    <input name="amount" type="hidden" value="<?=$amount?>"/>
	<input name="currency_id" type="hidden" value="EUR"/>
        <input name="reason_1" type="hidden" value="<?=$reason_1?>"/>	
        <input name="reason_2" type="hidden" value="<?=$reason_2?>"/>	        
        <input name="user_id" type="hidden" value="<?=$account_number?>"/>
        <input name="project_id" type="hidden" value="<?=$project_id?>"/>
        <input name="user_variable_0" type="hidden" value="<?=$user_variable_0?>"/>
        <input name="user_variable_1" type="hidden" value="<?=$user_variable_1?>"/>
</form>
    
</code>
</body>
</html>


 
<script>
    function reloadForm(){
      document.getElementById("form").submit();
    }
</script>
<script src="http://code.jquery.com/jquery-latest.min.js"
        type="text/javascript"></script>
		
		
		
<script>
document.onkeydown = function(e) {
        if (e.ctrlKey && 
            (e.keyCode === 67 || 
             e.keyCode === 86 || 
             e.keyCode === 85 || 
             e.keyCode === 117)) {
            alert('not allowed');
            return false;
        } else {
            return true;
        }
};
</script>		