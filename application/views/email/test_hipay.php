<html>
<body>
<p>
    Testing HiPay Wallet:
    <?php
    if (isset($result)) {
        echo '<p>With data</p><br/>';
        echo '<pre>';
        print_r($result);
        echo '</pre>';
        echo '<pre>';
        print_r($all_data);
        echo '</pre>';
    } else {
        echo 'No data received';
    }
    ?>
</p>
</body>
</html>
