<html>
<body onLoad="reloadForm()">
<form id="sub" action="<?=$link;?>" method="post">
    <input type="hidden" name="merchantid" value="<?=$merchantid?>">
    <input type="hidden" name="amount" value="<?=$amount?>">
    <input type="hidden" name="currency" value="<?=$currency?>">
    <input type="hidden" name="language" value="<?=$language?>">
    <input type="hidden" name="Description" value="<?=$Description?>">
    <input type="hidden" name="trxRefNumber" value="<?=$trxRefNumber?>">
    <input type="hidden" name="hashCode" value="<?=$hashCode?>">
    <input type="hidden" name="txt1" value="<?=$txt1?>">
    <input type="hidden" name="session_id" value="<?=$session_id?>">
    <input type="hidden" name="SiteId" value="<?=$SiteId?>">
    <input style="display: none" type="submit" value="Pay with FilsPay!">
</form>
</body>
<script>
    function reloadForm(){
        document.getElementById("sub").submit();
    }
</script>

</html>