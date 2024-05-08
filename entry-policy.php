<?php
	session_start();
	error_reporting(0);
	include('includes/config.php');
	if(strlen($_SESSION['alogin'])==""){   
		header("Location: index.php"); 
	}else{
	//For Deleting the notice

	// if($_GET['id']){

	//     $sql = "SELECT * FROM rela_customer_to_insurance WHERE id_insurance_info =".$_GET['id']." and id_default_insurance =".$_GET['id'];
	//     // echo '<script>alert("sql: '.$sql.'")</script>'; 
	//     $query = $dbh->prepare($sql);
	//     $query->execute();
	//     $results = $query->fetchAll(PDO::FETCH_OBJ);
	//     foreach($results as $value){
	//         $id = $value->id;
	//     }

	//     $sql="delete from rela_customer_to_insurance where id_insurance_info=:id";
	//     $query = $dbh->prepare($sql);
	//     $query->bindParam(':id',$_GET['id'],PDO::PARAM_STR);
	//     $query->execute();

	//     if($id!=""){
	//         $sql = "SELECT MIN(id_insurance_info) as id_min FROM rela_customer_to_insurance WHERE id_default_insurance =".$_GET['id'];
	//         // echo '<script>alert("sql MIN: '.$sql.'")</script>';
	//         $query = $dbh->prepare($sql);
	//         $query->execute();
	//         $results = $query->fetchAll(PDO::FETCH_OBJ);
	//         foreach($results as $value){
	//             $id_min = $value->id_min;
	//         }

	//         if($id_min!=""){
	//             $sql="update rela_customer_to_insurance set id_default_insurance=".$id_min." where id_default_insurance =".$_GET['id'];
	//             // echo '<script>alert("sql rela_customer_to_insurance: '.$sql.'")</script>';
	//             $query = $dbh->prepare($sql);
	//             $query->execute();
	//         }

	//         $sql="delete from insurance_info where id=".$_GET['id'];
	//         echo '<script>alert("sql delete: '.$sql.'")</script>';
	//         $query = $dbh->prepare($sql);
	//         // $query->bindParam(':id',$_GET['id'],PDO::PARAM_STR);
	//         $query->execute();
	//     }else{
	//         $sql="delete from insurance_info where id=".$_GET['id'];
	//         $query = $dbh->prepare($sql);
	//         $query->execute();
	//     }


	// echo '<script>alert("Success deleted.")</script>';
	// echo "<script>window.location.href ='entry-policy.php'</script>";

	// }

	$sql = " SELECT cl.currency,ip.insurance_company AS insurance_company_in,pr.product_name AS product_name_in,cu.mobile AS mobile_customer,cu.tel AS tel_customer,cu.email AS email_customer,insu.status AS status_insurance 
		 ,CASE WHEN cu.customer_type = 'Personal'
		  THEN CONCAT(cu.first_name,' ',cu.last_name)
		  ELSE cu.company_name
		  END as full_name

		 ,ag.title_name AS title_name_agent,ag.first_name AS first_name_agent,ag.last_name AS last_name_agent 
		 ,insu.id AS id_insurance,FORMAT(start_date, 'dd-MM-yyyy') AS start_date_day 
		 ,FORMAT(end_date, 'dd-MM-yyyy') AS end_date_day,insu.* 
		  from insurance_info insu 
		 left JOIN  rela_customer_to_insurance re_ci ON re_ci.id_insurance_info = insu.id 
		 left JOIN customer cu ON cu.id = re_ci.id_customer 
		 left JOIN agent ag ON ag.id = insu.agent_id 
		 LEFT JOIN product pr ON pr.id = insu.product_id
		 LEFT JOIN insurance_partner ip ON ip.id = insu.insurance_company_id
         LEFT JOIN currency_list cl ON cl.id = ip.id_currency_list
		 ORDER BY insu.cdate desc ";

        // ORDER BY LTRIM(insu.policy_no) asc ";
		   // WHERE insu.default_insurance = 1
	$query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
	<link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
	<link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
	<link rel="stylesheet" href="css/prism/prism.css" media="screen" >
	
	<link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
	<link rel="stylesheet" href="css/main.css" media="screen" >
	<script src="js/modernizr/modernizr.min.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<link   href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	<script src="js/DataTables/datatables.min.js"></script>

</head>

<style>
	.table th {
        vertical-align: middle !important;
		text-align: center !important;
    }
	
	.table thead th.sorting:after,
	.table thead th.sorting_asc:after,
	.table thead th.sorting_desc:after {
		top: 20px;
	}
</style>

<body id="page-top" >

    <!-- Page Wrapper -->
    <div id="wrapper" >
        <?php include('includes/leftbar2.php');?>   
        <?php include('includes/topbar2.php');?>  
        <!-- container-fluid -->
        <div class="container-fluid mb-4" >
            <div class="row breadcrumb-div" style="background-color:#ffffff">
                <div class="col-md-6" >
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                        <!-- <li> Classes</li> -->
                        <li class="active" >Entry Policy</li>
                    </ul>
                </div>
            </div>
        </div>

            <div class="container-fluid">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <div class="panel-title" style="display: inline-block;" >
                             <h2 class="title m-5" style="color: #102958;">Entry Policy</h2>
                        </div>
                        
                        <div class="row pull-right" style="display: inline-block;">
                            <div class="text-right" style="margin: 5px;">

                                <div class="row">
                                    <a href="add-policy.php" class="btn btn-primary" style="color:#F9FAFA;" >
                                        <svg  width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
      <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
      <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                        </svg>
                                        <span class="text">Add New Policy</span>
                                    </a>  
                                     &nbsp;&nbsp;

                                    <div class="dropdown pl-1 pr-3">
                                      <button class="btn btn-primary mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Export
                                      </button>

                                      <div class="dropdown-menu col-xs-1" style="width: 300px !important;" aria-labelledby="dropdownMenuButton" >
                                        <a href="#" class="dropdown-item" id="btnCsv" style="font-size: 15px;" >CSV</a>
                                        <a href="#" class="dropdown-item" id="btnExcel" style="font-size: 15px;" >Excel</a>
                                        <a href="#" class="dropdown-item" id="btnPdf" style="font-size: 15px;" >PDF</a>
                                        <a href="#" class="dropdown-item" id="btnPrint" style="font-size: 15px;" >Print</a>
                                      </div>
                                    </div>

                                   <!--  <div class="pl-1 pr-3">
                                    <a href="entry-policy-import-backup.php" class="btn btn-primary" style="color:#F9FAFA;" >
                                    <svg width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                                      <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5"/>
                                      <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
                                    </svg>
                                    <span class="text">Import File</span>
                                    </a>
                                    </div> -->

                                </div>

                            </div>
                        </div>
                    </div>

                        <div class="card-body" >
                            <div class="table-responsive" style="font-size: 13px;">
                                <!-- width="2000px"  -->
                                <!-- style="width:300%;" table-striped width="2500px-->
                                <table id="example"  class="table table-bordered "  style="color: #969FA7;" >
                                    <thead >
                                        <tr style="color: #102958;" >
                                            <th width="20px" style="color: #102958;">#</th>
                                            <th width="150px" style="color: #102958;">Policy no.</th>
                                            <th width="200px" style="color: #102958;">Cust. name</th>
                                            <th width="200px" style="color: #102958;">Partner company</th>
                                            <th width="250px" style="color: #102958;">Prod.</th>
                                            
                                           <!--  <th width="110px" style="color: #102958;" >Cust. Mobile</th>
                                            <th width="200px" style="color: #102958;">Cust. Email</th> -->
                                            <th width="50px" style="color: #102958;">Status</th>
                                            <th width="70px" style="color: #102958;">Start Date</th>
                                            <th width="70px" style="color: #102958;">End Date</th>
                                            <th width="100px" style="color: #102958;">Amount of premium</th>
                                            <th width="100px" style="color: #102958;">Convert Value</th>
                                            <th width="50px" style="color: #102958;">Symbol</th>
                                            
                                            <th width="150px" style="color: #102958;" >Agent/Customer</th>
                                            
                                            <th width="50px" style="color: #102958;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="color: #494949; font-size: 13px;" >
<?php 
    $cnt=1;
    if($query->rowCount() > 0){
       foreach($results as $result){ 
?> 
    <tr>
        <td class="text-center"><?php echo $cnt;?></td>
        <td><?php echo $result->policy_no;?></td>

         <td><?php echo $result->full_name;?></td>
         <td><?php echo $result->insurance_company_in;?></td>
        <td><?php echo $result->product_name_in;?></td>

        <!-- <td class="text-center"><?php echo $result->mobile_customer;?></td>
        <td><?php echo $result->email_customer;?></td> -->

        <!-- <td><?php //echo date('Y-m-d',$result->start_date);?></td> -->
        <td class="text-center"><?php echo $result->status_insurance;?></td>
        <td class="text-center"><?php echo $result->start_date_day;?></td>
        <td class="text-center"><?php echo $result->end_date_day;?></td>
        <td class="text-right" ><?php echo number_format((float)$result->premium_rate, 2, '.', ',');?></td>
        <td class="text-right" >
            <?php   if($result->currency !="฿THB" && $result->currency !="THB"){
                        echo number_format((float)$result->convertion_value, 2, '.', ',');
                    }else{
                        echo "0.00";
                    }
            ?>
        </td>
        <td class="text-center"><?php echo $result->currency;?></td>
        <!-- $result->title_name_agent." ". -->
        <td><?php echo $result->first_name_agent." ".$result->last_name_agent;?></td>
        
        
        <td class="text-center">
        <i title="Edit Record"><a href="edit-policy.php?id=<?php echo $result->id_insurance;?>">
 <svg width="20" height="20" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
</svg>
                                                <!-- </a></i> &nbsp;&nbsp;
                                                 <i class="fa " title="Delete this Record" ><a href="entry-policy.php?id=<?php echo $result->id_insurance;?>" onclick="return confirm('Do you really want to delete the notice?');">
    <svg width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
</svg>
    </i> </a> -->
                                        </td>
<?php $cnt++;}} ?>                       


            <?php //for($x = 0; $x <= 100; $x++){ ?>
               <!--  <tr>
                <td class="text-center"><?php //echo $x;?></td>
                </tr> -->
            <?php //}  ?>

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

	<script>
		$(document).ready(function(){
		var table = $('#example').DataTable({
			scrollX: true,
			lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			"scrollCollapse": true,
			"paging": true,
				buttons: [
					{ 
						extend: 'csv',
						class: 'buttons-csv',
						className: 'btn-primary',
						charset: 'UTF-8',
						filename: 'Entry Policy',
						bom: true,
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude the first column from export
                        }, 
						init: function(api, node, config) { $(node).hide(); }
					},
					{ 
						extend: 'excel',
						class: 'buttons-excel',
						className: 'btn-primary',
						charset: 'UTF-8',
						filename: 'Entry Policy',
						bom: true,
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude the first column from export
                        },
						init: function(api, node, config) { $(node).hide(); }
					},
					{ 
						extend: 'pdf',
						class: 'buttons-pdf',
						className: 'btn-primary',
						charset: 'UTF-8',
						filename: 'Entry Policy',
						bom: true,
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude the first column from export
                        },
						orientation: 'landscape', // เพิ่มคุณสมบัติ orientation เป็น 'landscape'
						init: function(api, node, config) { $(node).hide(); },
						customize: function(doc) {
							// Loop through all rows and cells to align text to the right
							doc.content.forEach(function(item) {
								if (item.table) {
									item.table.body.forEach(function(row) {
										row.forEach(function(cell, i) {
											if (typeof cell === 'object' && cell.text !== undefined) {
												if (i > 0) { // Skip first column (index 0)
													cell.alignment = 'right';
												}
											}
										});
									});
								}
							});
						}
					},
					{ 
						extend: 'print',
						class: 'buttons-print',
						className: 'btn-primary',
						charset: 'UTF-8',
						bom: true,
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude the first column from export
                        },
						init: function(api, node, config) { $(node).hide(); }
					}
				]
			});

			$('#btnCsv').on('click', function(){
				table.button('.buttons-csv').trigger();
			});

			$('#btnExcel').on('click', function(){
				table.button('.buttons-excel').trigger();
			});

			$('#btnPdf').on('click', function(){
				table.button('.buttons-pdf').trigger();
			});

			$('#btnPrint').on('click', function(){
				table.button('.buttons-print').trigger();
			});

			table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
		});

	</script>
	

	<?php include('includes/footer.php');?>
</body>

</html>
<?php } ?>
