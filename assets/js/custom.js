// =============  Data Table - (Start) ================= //

$(document).ready(function(){
    
    // { extend: 'copy', className: 'btn-primary',charset: 'UTF-8',bom: true },

    var table = $('#example').DataTable({
        scrollX: true,
        "bDestroy": true,
        "paging": true,
        "aLengthMenu": [[25,50,100,200,-1],[25,50,100,200,"ALL"]],
        "scrollCollapse": true,
        "paging":         true,
        buttons: [
            { extend: 'csv',class: 'buttons-csv',className: 'btn-primary',charset: 'UTF-8',filename: 'file_csv',bom: true
            ,init : function(api,node,config){ $(node).hide();} },
            { extend: 'excel',class: 'buttons-excel', className: 'btn-primary',charset: 'UTF-8',filename: 'file_excel',bom: true 
            ,init : function(api,node,config){ $(node).hide();} },
            { extend: 'pdf',class: 'buttons-pdf',className: 'btn-primary',charset: 'UTF-8',filename: 'file_pdf',bom: true 
            ,init : function(api,node,config){ $(node).hide();} },
            { extend: 'print',class: 'buttons-print',className: 'btn-primary',charset: 'UTF-8',bom: true 
            ,init : function(api,node,config){ $(node).hide();} }
            ]
    });

     $('#btnCsv').on('click',function(){
        table.button('.buttons-csv').trigger();
    });

    $('#btnExcel').on('click',function(){
        table.button('.buttons-excel').trigger();
    });

    $('#btnPdf').on('click',function(){
        table.button('.buttons-pdf').trigger();
    });

    $('#btnPrint').on('click',function(){
        table.button('.buttons-print').trigger();
    });

    // $('#btnExcel').on('click',function(){
    //     table.button('.buttons-excel').trigger();
    // });


    // var table = $('#example').DataTable({
    //     scrollX: true,
    //     "scrollCollapse": true,
    //     "paging":         true,
    //     buttons: [
            
    //         { extend: 'csv', className: 'btn-primary',charset: 'UTF-8',filename: 'file_csv',bom: true},
    //         { extend: 'excel', className: 'btn-primary',charset: 'UTF-8',filename: 'file_excel',bom: true },
    //         { extend: 'pdf', className: 'btn-primary',charset: 'UTF-8',filename: 'file_pdf',bom: true },
    //         { extend: 'print', className: 'btn-primary',charset: 'UTF-8',bom: true }
    //         ]
    // });



    //  var table = $('#example2').DataTable({
    //     scrollX: true,
    //     "scrollCollapse": true,
    //     "paging":         true
    // });

    //   var table = $('#example').DataTable({
    //     scrollX: true,
    //     "scrollCollapse": true,
    //     "paging":         true,
    //         buttons: [
    //             {
    //                 extend: 'pdf',
    //                 split: ['pdf', 'excel']
    //             }
    //         ]
    // });
    
    // var table = $('#example').DataTable({
    //     scrollX: true,
    //     "scrollCollapse": true,
    //     "paging":         true
        
    // });
    
    
    
    table.buttons().container()
    .appendTo('#example_wrapper .col-md-6:eq(0)');

});

// =============  Data Table - (End) ================= //
