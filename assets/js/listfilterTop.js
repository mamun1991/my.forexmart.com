(function ($) {
    // custom css expression for a case-insensitive contains()
    jQuery.expr[':'].Contains = function(a,i,m){
        return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
    };


    function listFilter(header, list) {
        // header is any element, list is an unordered list
        // create and add the filter form to the header
        var form = $("<form>").attr({"class":"filterformset","action":"#"}),
            input = $("<input>").attr({"id":"mysearchfieldt","class":"form-control hidden-search-form-control round-0 filterinput","type":"text", "placeholder":"Search..."});
        $(form).append(input).appendTo(header);

        $(input)
            .change( function () {
                var filter = $(this).val();
                if(filter) {
                    // this finds all links in a list that contain the input,
                    // and hide the ones not containing the input while showing the ones that do
                    $(list).find("a:not(:Contains(" + filter + "))").parent().slideUp();
                    $(list).find("a:Contains(" + filter + ")").parent().slideDown();
                } else {
                    $(list).find("li").slideDown();
                }
                return false;
            })
            .keyup( function () {

                if (!$("#mysearchfieldt").val().length == 0){
                    $(".searchscope").css('display','none');
                    $("#searchloc").css('display','block');
                }else{
                    $(".searchscope").css('display','block');
                    $("#searchloc").css('display','none');
                }
                // fire the above change event after every letter
                $(this).change();
            })
//            .mouseout( function () {
//                    $(this).change();
//                })
//            .next( function () {
//                    $(this).change();
//             });
            .focus( function () {
                    $(this).change();
                });

    }


    //ondomready
    $(function () {
        listFilter($("#searchtop"), $(".list"));
    });
}(jQuery));