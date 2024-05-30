<?php
	include_once('includes/connect_sql.php');
    session_start();
    error_reporting(0);
	include_once('includes/fx_agent_db.php');

	if(strlen($_SESSION['alogin'])==""){   
        sqlsrv_close($conn);
		header("Location: index.php"); 
	}else{

	}

    $status_view ='0';
    $status_add ='0';
    $status_edit ='0';
    $status_delete ='0';
    foreach ($_SESSION["application_page_status"] as $page_id) {
        if($page_id["page_id"]=="7"){
            $status_view =$page_id["page_view"];
            $status_add =$page_id["page_add"];
            $status_edit =$page_id["page_edit"];
            $status_delete =$page_id["page_delete"];
        }
    }
    if($status_view==0) {
        $dbh = null;
        header('Location: logout.php');
    }

    if ($_GET['action'] == 'del') {
        $insurance_list = check_insurance_agent($conn,$_GET['id']);
        if(count($insurance_list)==0){
            
            $under = get_partner_under($conn,$_GET['id']);
            foreach ($under as $value) {
                $data['id'] = $value['id'];
                $data['table'] = 'under';   
                delete_table ($conn, $data);
            }

            $data['id'] = $_GET['id'];
            $data['table'] = 'agent';   
            delete_table ($conn, $data);

            echo '<script>alert("Deleted Success.")</script>';
            sqlsrv_close($conn);
            echo "<script>window.location.href ='../agent-management.php'</script>";
            // header('Location: ../agent-management.php');
        }else{
            echo '<script>alert("This data cannot be deleted due to its usage history in the system, but it can only be marked as inactive.")</script>';
            sqlsrv_close($conn);
            echo "<script>window.location.href ='../agent-management.php'</script>";
        }
    }

	 
		$agents = get_agents($conn);
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
	/*.table thead th.sorting:after,
	.table thead th.sorting_asc:after,
	.table thead th.sorting_desc:after {
		top: 20px;
	}*/
	
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
						<li class="active" >Agent List</li>
					</ul>
				</div>
			</div>
        </div>

		<div class="container-fluid">
			<div class="card shadow mb-4">
				<div class="card-header ">
					<div class="panel-title" style="display: inline-block;">
						<h2 class="title m-5" style="color: #102958;">Agent List</h2>
					</div> 
					<div class="row pull-right" style="display: inline-block;">
						<div class="text-right m-5">
							<div class="row">

                                <?php if($status_add==1){ ?>
								<a href="add-agent.php" class="btn btn-primary ">
									<svg  width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
										<path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
										<path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
									</svg>
									<span class="text">Add Agent</span>
								</a>
                                <?php } ?>

								<div class="dropdown pl-3 ">
									<button class="btn btn-primary mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Export
									</button>
									<div class="dropdown-menu col-xs-1" style="width: 300px !important;" aria-labelledby="dropdownMenuButton" >
										<a href="#" class="dropdown-item" id="btnCsv" style="font-size: 15px;" >CSV</a>
										<a href="#" class="dropdown-item" id="btnExcel" style="font-size: 15px;" >Excel</a>
										<a href="#" class="dropdown-item" id="btnPdf" style="font-size: 15px;" >PDF</a>
									</div>
								</div>
								
								
                                <div class="pl-1 pr-3">
                                    <!--<a href="agent-import.php" class="btn btn-primary" style="color:#F9FAFA;" >
                                    <svg width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                                      <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5"/>
                                      <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
                                    </svg>
                                    <span class="text">Import File</span>
                                    </a>-->
                                </div>
								

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
											<th>Agent ID</th>
                                            <th>Agent Name</th>
                                            <th>Nickname</th>	                                                          
                                            <th >Email</th>
                                            <!-- <th>Tel</th> -->
                                            <th>Mobile</th>
                                            <th>Status</th>

                                            <?php if($status_edit==1 or $status_delete ==1){ ?>
                                            <th>Action</th>
                                            <?php }else{ ?>
                                            <th hidden="true" ></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 13px;">
                                    <?php $cnt=1; foreach ($agents as $agent) { ?>
                                        <tr>
                                            <!--<td class="text-center"><?php echo $cnt;?></td>-->
											<td class="text-center"><?php echo $agent['agent_id']?></td>
                                            <td><?php echo $agent['first_name'].' '.$agent['last_name'];?></td>
                                            <td class="text-center"><?php echo $agent['nick_name'];?></td>
                                            <td><?php echo $agent['email']?></td>
                                            <td class="text-center"><?php echo $agent['mobile']?></td>
                                            <td class="text-center"><?php echo ($agent['status'] == 1) ? 'Active' : 'Inactive';?></td>
                                            
                                            <?php if($status_edit==1 or $status_delete ==1){ ?>
                                            <td class="text-center">
                                                <?php if($status_edit==1){ ?>
                                                <a href="edit-agent.php?id=<?php echo $agent['id'];?>"><i class="fa " title="Edit Record"></i>
 <svg width="20" height="20" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
</svg>
                                                </a> &nbsp;&nbsp;
                                                <?php } ?>

                                                <?php if($status_delete==1){ ?>
                                                 <a href="agent-management.php?action=del&id=<?php echo $agent['id'];?>" onclick="return confirm('Do you really want to delete the partner?');">
    <svg width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
</svg>
    <i class="fa " title="Delete this Record" ></i> </a>
                                                <?php } ?>

                                            </td>
                                            <?php }else{ ?>
                                            <td hidden="true" ></td>
                                            <?php } ?>

                                        </tr>
                                            <?php $cnt++;} ?>

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
        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        
        <script src="js/DataTables/datatables.min.js"></script>
        <!-- <script src="assets/js/custom.js"></script> -->

    <script>
    $(document).ready(function(){
    var table = $('#example').DataTable({
        scrollY: 400, // ตั้งค่าความสูงที่คุณต้องการให้แถวแรก freeze
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            fixedColumns: {
                leftColumns: 1 // จำนวนคอลัมน์ที่คุณต้องการให้แถวแรก freeze
            },
        // scrollX: true,
        lengthMenu: [[10, 25, 50, 100, -1], [10,25, 50, 100, "All"]],
        "scrollCollapse": true,
        "paging":         true,
        buttons: [
            { extend: 'csv',class: 'buttons-csv',className: 'btn-primary',charset: 'UTF-8',filename: 'Agent List',bom: true
            ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
            { extend: 'excel',class: 'buttons-excel', className: 'btn-primary',charset: 'UTF-8',filename: 'Agent List',bom: true 
            ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
            { extend: 'pdf',class: 'buttons-pdf',className: 'btn-primary',charset: 'UTF-8',filename: 'Agent List',bom: true 
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

    table.buttons().container()
    .appendTo('#example_wrapper .col-md-6:eq(0)');

    });
    </script>

    <?php include('includes/footer.php'); ?>
</body>
</html>
<?php sqlsrv_close($conn); ?>
