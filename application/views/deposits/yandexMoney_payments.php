<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
</head>
<body onload='reloadForm()'>
<code>
    
    
<form id="form" action="https://money.yandex.ru/eshop.xml" method="post">
    <!-- Required fields -->
    <input type="hidden" value="<?php echo $scid?>" name="scid">
    <input type="hidden" value="<?php echo $shopId?>" name="shopId">
    <input type="hidden" value="<?php echo $customerNumber?>" name="customerNumber">
    <input type="hidden" value="<?php echo $sum?>" name="sum">
    <input type="hidden" value="<?php echo $paymentType?>" name="paymentType">
    <input type="hidden" value="<?php echo $shn?>" name="shn">
    <input type="hidden" value="<?php echo $cancel_url?>" name="shopFailURL">
</form>
  
</code>
</body>
</html>
 

 
<script>
    function reloadForm(){
        document.getElementById("form").submit();
    }
</script>
<script src="http://code.jquery.com/jquery-latest.min.js"type="text/javascript"></script>

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