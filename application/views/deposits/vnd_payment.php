<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<body onload="document.forms['payment'].submit();">
<form method="POST" action="https://payment.pa-sys.com/app/page/52574773-a2bc-4fa5-bd1f-2208f8f5faa4" name="payment" accept-charset="utf-8">
    <?php foreach($fields as $_k => $_v) { ?>
        <input type="hidden" name="<?=$_k;?>" value="<?=htmlentities($_v);?>" />
    <?php } ?>
</form>
</body>
</html>

