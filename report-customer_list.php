
<?php
session_start();
error_reporting(0);
include_once('includes/connect_sql.php');
include_once('includes/fx_customer_db.php');

if(strlen($_SESSION['alogin'])=="") {
    header('Location: logout.php');
}
$customer="all";
$status="all";
$contacts=null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)) {
        $customers = get_customers_search($conn,$_POST);

        $customer = $_POST['customer'];
        $status = $_POST['status'];
    }
}else{
    $customers = get_customers_search_start($conn);
}
$customers_list = get_customers_search_start($conn);
// $customers_list = get_customers($conn);


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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script> -->
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        <script src="js/DataTables/datatables.min.js"></script> 

</head>

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
                                        <li class="active" >Report Customer List</li>
                                    </ul>
                                </div>
                            </div>
        </div>

            <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header">
 
                             <div class="panel-title" >
                                <h2 class="title m-5" style="color: #102958;">Report: Customer List
                            </div>  

                         
                        </div>

<form method="post" action = "report-customer_list.php" >
<div class="container-fluid">
            <div >
                <br>
                    <div class="form-group row col-md-12 ">
                        
                        <label style="color: #102958;"  class="col-sm-3 label_left">Cust. Name:</label>

                        <div class="col-sm-3">
                  
                            <select id="customer" name="customer" style="border-color:#102958; color: #000;" class="remove-example form-control selectpicker" data-live-search="true" value="<?php echo $customer; ?>" >
                                <option value="all">All</option>
                                <?php //echo $value['id']; ?>
                                <?php foreach ($customers_list as $value) { ?>
                                    <option value="<?php echo trim($value['id']); ?>" 
                                    <?php if ($value['full_name']==$customer) { echo 'selected="selected"'; } ?>
                                        ><?php echo $value['full_name']; ?>
                                    </option>
                                <?php } ?>    
                            </select>
                        </div>

                        <label style="color: #102958;" class="col-sm-3 label_right">Cust. Status:</label>
                        <div class="col-sm-3">
                             <select id="status" name="status" style="border-color:#102958; color: #000;" class="remove-example form-control" value="<?php echo $status; ?>"  >
                                <option value="all" <?php if ($status=="all") { echo 'selected="selected"'; } ?> >All</option>
                                <option value="1" <?php if ($status=="1") { echo 'selected="selected"'; } ?> >Active</option>
                                <option value="0" <?php if ($status=="0") { echo 'selected="selected"'; } ?>>InActive</option>
                                
                            </select>
                        </div>


                    </div>

<div class="row pull-right">                    
                <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  ">Search<span class="btn-label btn-label-right"><i class="fa "></i></span>
                </button>  
&nbsp;&nbsp;
<div class="dropdown">
  <button style="background-color: #0275d8;color: #F9FAFA;" class="btn btn-primary mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Export
  </button>
  <div class="dropdown-menu col-xs-1" style="width: 300px !important;" aria-labelledby="dropdownMenuButton" >
    <a href="#" class="dropdown-item" id="btnCsv" style="font-size: 15px;" >CSV</a>
    <a href="#" class="dropdown-item" id="btnExcel" style="font-size: 15px;" >Excel</a>
    <a href="#" class="dropdown-item" id="btnPdf" style="font-size: 15px;" >PDF</a>
    <a href="#" class="dropdown-item" id="btnPrint" style="font-size: 15px;" >Print</a>
  </div>
</div>&nbsp;&nbsp;
</div> 

            </div>
    </div>
</form> 

                        <div class="card-body">



                            <div class="table-responsive" style="font-size: 13px;">
                                <table class="table table-bordered" id="example"  cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th width="200px">Cust. name</th>
                                            <th width="100px">Status</th>
                                            <th>Level</th>
                                            <th width="400px">Address</th>
                                            <th width="200px">Cust. email</th>
                                            <th width="100px">Cust. mobile</th>

                                            <th width="150px">Contact person</th>
                                            <th width="130px">Position</th>
                                            
                                            <th width="200px">Email</th>
                                            <th width="100px">Mobile</th>
                                           
                                            
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 13px;">
										<?php 
										$ctr = 1; 
										foreach ($customers as $c) {
										$contact = get_customer_contact($conn, $c['id']);
										    ?>
										<tr>
                                            <td class="text-center"><?php echo $ctr;?></td>
                                            <td><?php echo $c['full_name']; ?></td>
                                            <td class="text-center"><?php echo ($c['status'] == 1) ? 'Active' : 'Inactive';?></td>

<!-- .$c['sub_district']." ".$c['district']." ".$c['name_th_province']." ".$c['name_th_district']." ".$c['name_th_sub']." " -->

                                            <td class="text-center"><?php echo $c['level_name'];?></td>
                                            <td><?php echo $c['address_number']." ".$c['building_name']." ".$c['soi']." ".$c['road']." ".$c['name_en_province']." ".$c['name_en_district']." ".$c['name_en_sub']." "." ".$c['post_code'];?></td>
                                            <td><?php echo $c['email'];?></td>
                                            <td class="text-center"><?php echo $c['mobile'];?></td>
                                            <td><?php echo $c['con_first_name'].' '.$c['con_last_name'];?></td>
                                            <td><?php echo $c['position'];?></td>
                                            
                                            <td><?php echo $c['con_email'];?></td>
                                            <td class="text-center"><?php echo $c['con_mobile'];?></td>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
     <!-- //////////////// เอาออกเพราะมีปัญหาเรื่อง popup -->
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <!-- /////////////////// -->

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

     <!-- <script src="js/jquery/jquery-2.2.4.min.js"></script> -->
        <!-- <script src="js/bootstrap/bootstrap.min.js"></script> -->

        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <!-- <script src="js/DataTables/datatables.min.js"></script> -->

        <!-- ========== THEME JS ========== -->
        <!-- <script src="js/main.js"></script> -->

        <!-- ========== Address Search ========== -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" /> -->


    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <!-- <script src="assets/js/custom.js"></script> -->

    <style>
	/*@media (min-width: 1340px){*/
		.label_left{
			max-width: 180px;
		}
		.label_right{
			max-width: 190px;
		}
	/*}*/

	.table th {
        vertical-align: middle !important;
		text-align: center !important;
    }
	.table thead th.sorting:after,
	.table thead th.sorting_asc:after,
	.table thead th.sorting_desc:after {
		top: 10px;
	}
	
	.caret {
		right: 10px !important;
	}
	
	.btn-group>.btn:first-child {
		border-color: #102958;
	}
	
	div.dataTables_wrapper div.dataTables_filter input {
		//border-color: #102958;
	}

    </style> 

    <script>
    $(document).ready(function(){
    // { extend: 'copy', className: 'btn-primary',charset: 'UTF-8',bom: true },
    // "bDestroy": true,
    // "aLengthMenu": [[25,50,100,200,-1],[25,50,100,200,"ALL"]],
    
    var table = $('#example').DataTable({
        scrollX: true,
        "scrollCollapse": true,
        "paging":         true,
        buttons: [
            { extend: 'csv',class: 'buttons-csv',className: 'btn-primary',charset: 'UTF-8',filename: 'Report customer list',bom: true
            ,init : function(api,node,config){ $(node).hide();} },
            { extend: 'excel',class: 'buttons-excel', className: 'btn-primary',charset: 'UTF-8',filename: 'Report customer list',bom: true 
            ,init : function(api,node,config){ $(node).hide();} },
            { extend: 'pdf',class: 'buttons-pdf',className: 'btn-primary',charset: 'UTF-8',filename: 'Report customer list',bom: true 
            ,orientation: 'landscape',init : function(api,node,config){ $(node).hide();} },
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

    table.buttons().container()
    .appendTo('#example_wrapper .col-md-6:eq(0)');

    });
    </script>

    <?php include('includes/footer.php'); ?>
</body>

</html>

