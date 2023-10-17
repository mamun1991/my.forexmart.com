<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta content="width=device-width, initial-scale=1" name="viewport">
    </head>
    <body onload='reloadForm()'>
    <code>
        <form id="form"  method="post" action="https://www.payanyway.ru/assistant.htm">
            <input type="hidden" name="MNT_ID" value="<?=$MNT_ID?>">
            <input type="hidden" name="MNT_TRANSACTION_ID" value="<?=$MNT_TRANSACTION_ID?>">
            <input type="hidden" name="MNT_CURRENCY_CODE" value="RUB">
            <input type="hidden" name="MNT_AMOUNT" value="<?=$MNT_AMOUNT?>">
            <input type="hidden" name="MNT_TEST_MODE" value="0">
            <input type="hidden" name="MNT_SUCCESS_URL" value="<?=$MNT_SUCCESS_URL?>">
            <input type="hidden" name="MNT_FAIL_URL"  value="<?=$MNT_FAIL_URL?>">
            <input type="hidden" name="MNT_RETURN_URL"  value="<?=$MNT_RETURN_URL?>">
            <input type="hidden" name="MNT_CUSTOM1" value="<?=$MNT_CUSTOM1?>">
            <input type="hidden" name="MNT_CUSTOM2" value="<?=$MNT_CUSTOM2?>">
        </form>
    </code>
    </body>
</html>
 
<script>
    function reloadForm(){
        document.getElementById("form").submit();
    }
</script>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>


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