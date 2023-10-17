<!DOCTYPE html>
<html>
<body onLoad="reloadForm()">
<form id="cashu" action="<?=$link?>" method="post">
    <input type="hidden" name="merchant_id" value="<?=$merchant_id?>">
    <input type="hidden" name="token" value="<?=$token?>">
    <input type="hidden" name="display_text" value="<?=$display_text?>">
    <input type="hidden" name="currency" value="<?=$currency?>">
    <input type="hidden" name="amount" value="<?=$amount?>">
    <input type="hidden" name="language" value="<?=$language?>">
    <input type="hidden" name="session_id" value="<?=$session_id?>">
    <input type="hidden" name="txt1" value="<?=$txt1?>">
    <input style="display: none" type="submit" value="Pay with cashU!">
</form>

</body>
<script>
    function reloadForm(){
        document.getElementById("cashu").submit();
    }
</script>
</html>

