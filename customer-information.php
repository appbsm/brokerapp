<?php
    include_once('includes/connect_sql.php');
    session_start();
    error_reporting(0);
    include_once('includes/fx_customer_db.php');

    if(strlen($_SESSION['alogin'])=="") {
        header('Location: logout.php');
    }
    
    $customers = get_customers($conn);
    
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" > -->
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>

</head>

<style>
	.table th {
        vertical-align: middle !important;
		text-align: center !important;
    }
	.table thead th.sorting:after,
	.table thead th.sorting_asc:after,
	.table thead th.sorting_desc:after {
		top: 10px;
	}
	
</style>

<body id="page-top" >

    <!-- Page Wrapper -->
    <div id="wrapper" >
        <?php include('includes/leftbar2.php');?>   
        <?php include('includes/topbar2.php');?>  

        <div class="container-fluid mb-4" >
                            <div class="row breadcrumb-div" style="background-color:#ffffff">
                                <div class="col-md-6" >
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <!-- <li> Classes</li> -->
                                        <li class="active" >Customer List</li>
                                    </ul>
                                </div>
                            </div>
        </div>

            <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <!-- <h6 class="m-0 font-weight-bold text-primary">Customer List</h6> -->
                             <div class="panel-title" >
                                <h2 class="title m-5" style="color: #102958;">Customer List
                            </div>  

                        <div class="row pull-right">
                            <div class="text-right">
                                <a href="add-customer.php" class="btn btn-primary ">
                                    <svg  width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
										<path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
										<path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                    </svg>
                                    <span class="text">Add Customer</span>
                                </a>               
                            </div>
							&nbsp;&nbsp;
							<div class="dropdown">
							  <button class="btn btn-primary mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Export
							  </button>
							  <div class="dropdown-menu col-xs-1" style="width: 300px !important;" aria-labelledby="dropdownMenuButton" >
								<a href="#" class="dropdown-item" id="btnCsv" style="font-size: 15px;" >CSV</a>
								<a href="#" class="dropdown-item" id="btnExcel" style="font-size: 15px;" >Excel</a>
								<a href="#" class="dropdown-item" id="btnPdf" style="font-size: 15px;" >PDF</a>
								<a href="#" class="dropdown-item" id="btnPrint" style="font-size: 15px;" >Print</a>
                                <!-- <a href="#" class="dropdown-item" id="btnAll" style="font-size: 15px;" >All</a> -->
							  </div>
							</div>

                        </div>  
                        </div>

                        <div class="card-body">
                            <div class="table-responsive" style="font-size: 13px;">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <!--<th>#</th>-->
											<th>Cust. ID</th>
                                            <th>Cust. Name</th>
											<th>Cust. Level</th>
                                            <!--<th>Nickname</th>-->
                                            <th>Contact Name</th>
                                            <th>Cust. Type</th>
                                            <!-- <th>Email</th> -->
                                            <th>Tel</th>
                                            <!-- <th>Mobile</th> -->
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 13px;">
										<?php 
										$ctr = 1; 
										foreach ($customers as $c) {
										$contact = get_customer_contact ($conn, $c['id']);
										    ?>
										<tr>
                                            <!--<td class="text-center"><?php echo $ctr;?></td>-->
											<td class="text-center"><?php echo $c['customer_id'];?></td>
                                            <td><?php echo $c['full_name'];?></td>
											<td class="text-center"><?php echo $c['level_name'];?></td>
                                            <!--<td><?php echo $c['nick_name'];?></td>-->
                                            <td> <?php echo $contact[0]['first_name'].' '.$contact[0]['last_name'];?></td>
                                            <td class="text-center"><?php echo $c['customer_type'];?></td>
                                            <!-- <td><?php //echo $c['email'];?></td> -->
                                            <td class="text-center"><?php echo $c['tel'];?></td>
                                            <!-- <td class="text-center"><?php echo $c['mobile'];?></td> -->
                                            <td class="text-center"><?php echo ($c['status'] == 1) ? 'Active' : 'Inactive';?></td>
                                            <td class="text-center">
                                            <a href="edit-customer.php?id=<?php echo $c['id'];?>"><i class="fa " title="Edit Record"></i>
 <svg width="20" height="20" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
</svg>
                                                </a> &nbsp;&nbsp;
                                                <!-- includes/fx_customer_db -->
                                                 <a href="includes/fx_customer_db.php?action=del&id=<?php echo $c['id'];?>" onclick="return confirm('Do you really want to delete the customer?');">
    <svg width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
</svg>
    <i class="fa " title="Delete this Record" ></i> </a>
                                            </td>
										</tr>
										<?php 
										$ctr++;
										} ?>                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>


  



    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <!-- <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

     <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <!-- <script src="js/bootstrap/bootstrap.min.js"></script> -->
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        
        <!-- <script src="assets/js/custom.js"></script> -->

    <script>

    // $(document).ready(function(){
    // var table = $('#example').DataTable({
    //     scrollX: true,
        
    //     lengthMenu: [[10, 25, 50, 100, -1], [10,25, 50, 100, "All"]],
    //     "scrollCollapse": true,
    //     "paging":         true,
    //     buttons: [
    //         { 
    //             extend: 'excel',
    //             class: 'buttons-all',
    //             className: 'btn-primary',
    //             charset: 'UTF-8',
    //             filename: 'Customer_List',
    //             bom: true,
    //             exportOptions: { 
    //                 columns: ':not(:last-child)',
    //                 modifier: {
    //                     selected: null
    //                 }
    //             },
    //             action: function (e, dt, button, config) {
    //                 $.ajax({
    //                     url: 'get_customer_all.php',
    //                     dataType: 'json',
    //                     success: function(data) {
    //                         var xlsx = new $.fn.dataTable.Buttons.Api(dt).inst.buttons.excelHtml5;
    //                         xlsx.customize(function (xlsx) {
    //                             for (var i = 0; i < data.length; i++) {
    //                                 xlsx['sheet1'].data.push(data[i]);
    //                             }
    //                         });
    //                         xlsx.action(e, dt, button, config);
    //                     }
    //                 });
    //             }
    //         },
    //         { extend: 'csv',class: 'buttons-csv',className: 'btn-primary',charset: 'UTF-8',filename: 'Customer List',bom: true
    //         ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
    //         { extend: 'excel',class: 'buttons-excel', className: 'btn-primary',charset: 'UTF-8',filename: 'Customer List',bom: true 
    //         ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
    //         { extend: 'pdf',class: 'buttons-pdf',className: 'btn-primary',charset: 'UTF-8',filename: 'Customer List',bom: true 
    //         ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
    //         { extend: 'print',class: 'buttons-print',className: 'btn-primary',charset: 'UTF-8',bom: true 
    //         ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} }
    //         ]
    // });

    // $('#btnCsv').on('click',function(){
    //     table.button('.buttons-csv').trigger();
    // });

    // $('#btnExcel').on('click',function(){
    //     table.button('.buttons-excel').trigger();
    // });

    // $('#btnPdf').on('click',function(){
    //     table.button('.buttons-pdf').trigger();
    // });

    // $('#btnPrint').on('click',function(){
    //     table.button('.buttons-print').trigger();
    // });


    // $('#btnAll').on('click', function(){
    //     table.button('.buttons-all').trigger();
    // });

    //        // $.ajax({
    //     //     url: 'get_customer_all.php', // แก้ไขเป็นชื่อไฟล์ PHP ที่ใช้สำหรับดึงข้อมูล
    //     //     type: 'GET',
    //     //     dataType: 'json',
    //     //     success: function(data) {
    //     //         // หลังจากได้ข้อมูลมาแล้ว
    //     //         // ให้ทำการใส่ข้อมูลลงในตาราง DataTable โดยใช้ข้อมูลที่ได้รับมา
    //     //         // table.clear().rows.add(data).draw();
    //     //     },
    //     //     error: function(xhr, status, error) {
    //     //         // หากเกิดข้อผิดพลาดในการดึงข้อมูล
    //     //         console.error(xhr.responseText);
    //     //     }
    //     // });

    // table.buttons().container()
    // .appendTo('#example_wrapper .col-md-6:eq(0)');

    // });

    //  { extend: 'csv',class: 'buttons-csv',className: 'btn-primary',charset: 'UTF-8',filename: 'Customer List',bom: true
    //  ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
</script>

<script>
    $(document).ready(function(){
        var table = $('#example').DataTable({
            scrollX: true,
            
            lengthMenu: [[10, 25, 50, 100, -1], [10,25, 50, 100, "All"]],
            "scrollCollapse": true,
            "paging":         true,
            buttons: [
                { extend: 'csv',class: 'buttons-csv',className: 'btn-primary',charset: 'UTF-8',filename: 'Customer List',bom: true
                ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
                { extend: 'excel',class: 'buttons-excel', className: 'btn-primary',charset: 'UTF-8',filename: 'Customer List',bom: true 
                ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
                { extend: 'pdf',class: 'buttons-pdf',className: 'btn-primary',charset: 'UTF-8',filename: 'Customer List',bom: true 
                ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
                { extend: 'print',class: 'buttons-print',className: 'btn-primary',charset: 'UTF-8',bom: true 
                ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} }
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

        // { 
        //             extend: 'excel',
        //             class: 'buttons-excel',
        //             className: 'btn-primary',
        //             charset: 'UTF-8',
        //             filename: 'Customer_List',
        //             bom: true,
        //             exportOptions: {columns: ':not(:last-child)'},
        //             customize: function(xlsx) {
        //                 $.ajax({
        //                     url: 'get_customer_all.php',
        //                     type: 'GET',
        //                     dataType: 'json',
        //                     success: function(data) {
        //                         for (var i = 0; i < data.length; i++) {
        //                             xlsx['sheet1'].data.push(data[i]);
        //                         }
        //                     }
        //                 });
        //             },
        //             init : function(api,node,config){ $(node).hide();}
        //         },

        // $('#btnAll').on('click', function(){
        //     alert('btnAll Run:');
        //     table.button('.buttons-all').trigger();
        // });

    });
    </script>

    <?php include('includes/footer.php');?>
</body>

</html>



