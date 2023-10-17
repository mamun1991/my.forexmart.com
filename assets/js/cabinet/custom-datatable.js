$(document).ready(function(){
    $('#example').DataTable({
        "ordering": false,
        responsive: true,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 8 },
            { responsivePriority: 3, targets: 7 }
        ]
    });
    

    // solution for the datatable inside the tab
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust()
            .fixedColumns().relayout();
    });
});