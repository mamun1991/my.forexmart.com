$(function() {
    $("[data-slider]")
        .each(function () {
            var input = $(this);
            $("<span>")
                .addClass("output")
                .insertAfter($(this));
        })
        .bind("slider:ready slider:changed", function (event, data) {
            $(this)
                .nextAll(".output:first")
                .html(data.value.toFixed(3));
        });
});

/* START SHOW AND HIDE DIV */
$(function(){
    $('body').on('click','.pamm-link',function(e){
        e.preventDefault();
        var destination = $(this).attr('data-destination');
        $('.destination-class').hide();
        $(destination).show();
    });
});
/* END SHOW AND HIDE DIV */

/* START DROPDOWN SHOW AND HIDE DIV */
$(function(){
    $('body').on('click','.live-feed-link',function(e){
        e.preventDefault();
        var destination = $(this).attr('data-destination');
        $('.live-feed-class').hide();
        $(destination).show();
    });
});
$(function(){
    $('body').on('click','.monitoring-link',function(e){
        e.preventDefault();
        var destination = $(this).attr('data-destination');
        $('.monitoring-class').hide();
        $(destination).show();
    });
});
/* END DROPDOWN SHOW AND HIDE DIV */

/* INVESTOR REGISTRATION */
$(document).ready(function () {

    $('#submit-investor').click(function (e) {

        var total_input = $('#form-investor :input').length;

        e.preventDefault();
        $('#form-investor :input').each(function(index, item) {
            if (!(item.id == 'submit-investor') && !(item.name == 'confirm-invest-refund') && !(item.name == 'config-lang')) {
                console.log(index);
                if(!$(this).val().length){
                    $(this).closest('div.col-sm-12').children('div.reqs').html('<p class="field-req">This field is required.</p>');
                } else {
                    $(this).closest('div.col-sm-12').children('div.reqs').html('');

                    if (total_input - 4 == index) {
                        if (!$('#form-investor p.field-req').length) {
                            $('#form-investor').submit();
                        }
                    }


                }
            }
        });

    });
});