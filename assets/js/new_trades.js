$(document).ready(function () {

    if(recordType=="history-of-trades"){

        getHistoryTradeRecords(recordType);

    }else {
        getTradeRecords(recordType,0);
    }



    $('div.active div.pagination').on('click','a',function(e){
        e.preventDefault();
        var pageNo = $(this).attr('data-ci-pagination-page');
        getTradeRecords(recordType,pageNo);
    });
    $('div#balance-operations-pagination').on('click','a',function(e){
        e.preventDefault();
        var pageNo = $(this).attr('data-ci-pagination-page');
        getTradeRecords(recordType,pageNo);
    });

    $('.hist-nav').click(function () {
        recordType = $(this).data('tog');
            getTradeRecords(recordType,0);

        $(".tab-pane").each(function(){
            $(this).removeClass('active');
            if( $(this).hasClass(recordType) ){    $(this).addClass('active');  }
        });

        $(".hist-nav").each(function(){    $(this).removeClass('active');  });
        $(this).addClass('active');
    });
    $("#btn-search-trade-history").click(function () {

            getTradeRecords(recordType,0);
    });

    function getTradeRecords(recordType, pageNum){



        if(recordType=='current-trades'){
            var data = { recType:recordType, page:pageNum};
        }else{
            var data = {
                recType:recordType,
                page:pageNum,
                from: $('#date_from_history').val(),
                to: $('#date_to_history').val()
            };
        }

            //console.log(base_url+"get-trades");

        var container = "table."+recordType+" tbody#result",
            pgCont = "div#"+recordType+"-pagination";
        $.ajax({
            type: "post",
            url: base_url+"get-trades",
            data: data,
            //data: 'recType='+recordType+'&page='+pageNum,
            dataType: 'json',
            beforeSend: function () {
                $('#loader-holder').show();
            },
            success: function(x) {
               if(x.hasError){

                   $(container).html("<tr><td colspan='11' style='text-align: center;'>Internal Error. Please contact support.</td></tr>");
               }else{

                       $(container).html(x.result['result']);

                       $('.pagination').each(function () {
                          $(this).html("");
                       });
                       switch (recordType){
                           case 'balance-operations':
                               $('#showing').html(x.result['showing']);
                               $('#balance-operations-pagination').html(x.result['pagination']);
                               break;
                           case 'history-of-trades':
                               $('#showing').html(x.result['showing']);
                               $('#history-of-trades-pagination').html(x.result['pagination']);
                               break;
                           case 'current-trades':
                               $('#current-trades-pagination').html(x.result['pagination']);
                               break;
                       }
                       var pg = pageNum<=1? 1 : pageNum;

                   $('ul.tab-pagination li.latest-page').each(function(){        $(this).removeClass('active');   });
                   $("ul.tab-pagination").find("[data-ci-pagination-page='" + pg + "']").closest('li').addClass('active');



               }
                $('#loader-holder').hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#loader-holder').hide();
                // console.log(xhr.status);
                // console.log(thrownError);
            }
        });
    }


    function getHistoryTradeRecords(recordType,dta_tbl_07,dta_tbl_02,dta_tbl_01,dta_tbl_14,dta_tbl_15) {

        $('.click-table').DataTable({
            dom: 'ltip',
            processing : true,
            serverSide: true,
            responsive: true,
            ordering: false,
            deferLoading: 5,
            language:{
                search:"Search",
                lengthMenu: dta_tbl_07,
                info: dta_tbl_02,
                zeroRecords: dta_tbl_01,
                paginate: {
                    next: dta_tbl_14,
                    previous: dta_tbl_15
                }
            },
            ajax:{
                type: 'post',
                url: '/my-trading/getHistoryTradeRecord',
                //url: '/partnership_test/getTrades',
                dataType: 'json',
                data: function(d){
                    d.recordType = recordType;
                    $('#loader-holder').show();
                   // console.log(d +"test this");
                    return d;

                }
            },
            drawCallback : function (oSettings) {

                if(oSettings.fnRecordsDisplay() == 0){
                    $(oSettings.nTableWrapper)
                        .find('.dataTables_paginate, .dataTables_filter, .dataTables_length, .dataTables_info')
                        .hide();
                }else{

                    $(oSettings.nTableWrapper)
                        .find('.dataTables_paginate, .dataTables_filter, .dataTables_length, .dataTables_info')
                        .show();
                }
                $('#loader-holder').hide();
            }
        });

        $('#tbl-history-of-trades-tbl').DataTable().draw();
    }

});


