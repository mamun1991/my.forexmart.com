

<html lang="en">
<body onload='reloadForm()'>
<form id="sub" action="<?=$action_link?>" method="post">
    <input type="hidden" name="apiversion" value="<?= $all_data['apiversion' ]?>">
    <input type="hidden" name="version" value="<?= $all_data['version']?>">
    <input type="hidden" name="merchant_account" value="<?= $all_data['merchant_account']?>">
    <input type="hidden" name="merchant_order" value="<?= $all_data['merchant_order']?>">
    <input type="hidden" name="merchant_product_desc" value="<?= $all_data['merchant_product_desc']?>">
    <input type="hidden" name="first_name" value="<?=$all_data['first_name']?>">
    <input type="hidden" name="last_name" value="<?=$all_data['last_name']?>">
    <input type="hidden" name="address1" value="<?=$all_data['address1']?>">
    <input type="hidden" name="city" value="<?=$all_data['city']?>">
    <input type="hidden" name="zip_code" value="<?= $all_data['zip_code']?>">
    <input type="hidden" name="country" value="<?= $all_data['country']?>">
    <input type="hidden" name="phone" value="<?= $all_data['phone']?>">
    <input type="hidden" name="email" value="<?= $all_data['email']?>">
    <input type="hidden" name="amount" value="<?=$all_data['amount']?>">
    <input type="hidden" name="currency" value="<?= $all_data['currency']?>">
    <input type="hidden" name="bankcode" value="<?= $all_data['bankcode']?>">
    <input type="hidden" name="ipaddress" value="<?= $all_data['ipaddress']?>">
    <input type="hidden" name="return_url" value="<?= $all_data['return_url'] ?>">
    <input type="hidden" name="server_return_url" value="<?= $all_data['server_return_url'] ?>">
    <input type="hidden" name="control" value="<?= $checksum ?>">
    <input style="display: none"  type="submit" value="Pay!">
</form>
</body>
</html>



<script>
    function reloadForm(){
        document.getElementById("sub").submit();
    }
</script>
