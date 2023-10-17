<html lang="en">
<body onload='reloadForm()'>
<form id="sub" action="<?=$link?>" method="post">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="<?=$business?>">

    <input type="hidden" name="return" value="<?=$return_url?>">
    <input type="hidden" name="cancel_return" value="<?=$cancel_url?>">
    <input type="hidden" name="notify_url" value="<?=$notify_url?>">
    <input type="hidden" name="amount" value="<?=$amount?>">

    <input type="hidden" name="item_name" value="<?=$item_name?>">
    <input type="hidden" name="item_number" value="<?=$item_number?>">
    <input type="hidden" name="custom" value="<?=$custom?>">

    <input style="display: none" type="submit" value="Pay!">
</form>
</body>
</html>

<script>
    function reloadForm(){
        document.getElementById("sub").submit();
    }
</script>

