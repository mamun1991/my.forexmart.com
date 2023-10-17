<!DOCTYPE html>
<html>
<body>
<script src="<?= $this->template->Js()?>jquery-1.11.3.min.js"></script>
<h1>My First Heading</h1>

<p>My first paragraph.</p>
</body>
</html>

<script type="text/javascript">
    var pblc = [];
    var prvt = [];
    var site_url = "<?=FXPP::ajax_url('')?>";

    $(document).ready(function () {

        console.log('test');
        var ajax_verify = function() {
            prvt["data"] = {instance:2};
            pblc['request'] = $.ajax({
                async: false,
                dataType: 'json',
//                url: site_url + 'query/removeagentaccounts',
//                url: site_url + 'query/gettotal_commission',
//                url: site_url + 'query/gettotal_commission2',
                url: site_url + 'query/gettotal_commission_data2',
                method: 'POST',
                data:prvt["data"]
            });
            pblc['request'].done(function( data ) {
                console.log(data);
//                ajax_verify();

            });
            pblc['request'].fail(function( jqXHR, textStatus ) {

            });

        }
//        ajax_verify();
        var x=.2; //.15 9sec .1 6sec .3 18sec
        var interval2 = 1000 * 60 * x; // where X is your every X minutes
        setInterval(ajax_verify, interval2);
    });
</script>