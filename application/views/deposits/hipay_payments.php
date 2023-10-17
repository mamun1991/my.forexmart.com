<html lang="en">
<body onload='reloadForm()'>
<form action="<?=$link?>" method="post" id="sub">
    <input type="hidden" name="id" value="<?=$id?>" />
    <input type="hidden" name="amount" value="<?=$amount?>">
    <input type="submit" name="hipay_payment_button" style="display: none" />
</form>
</body>
</html>

<script>
    function reloadForm(){
        document.getElementById("sub").submit();
    }
</script>
