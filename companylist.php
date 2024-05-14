<?php
	
	include('includes/config.php');
	session_start();
	error_reporting(0);
	if(strlen($_SESSION['alogin'])=="")
		{   
		header("Location: index.php"); 
		}
		else{

	//For Deleting the notice

	if($_GET['id']){

	// $sql = "SELECT TOP 1 * from insurance_info WHERE product_id = '".$id."'"; 
	// $query = $dbh->prepare($sql);
	// $query->execute();
	// $results_insurance = $query->fetchAll(PDO::FETCH_OBJ);
		
	$id=$_GET['id'];
	$sql="delete from company_list where id=:id";
	// $sql="update role_name set status=0 where id=:id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':id',$id,PDO::PARAM_STR);
	$query->execute();

	$sql="delete from rela_company_to_contact where id_company=:id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':id',$id,PDO::PARAM_STR);
	$query->execute();

	echo '<script>alert("Deleted Success.")</script>';
	echo "<script>window.location.href ='companylist.php'</script>";

	}

	// $sql = "SELECT * from company_list ";
	$sql = "SELECT cl.*,pr.name_en AS province_name,di.name_en AS district_name,su.name_en AS sub_district_name
	 from company_list cl
	LEFT JOIN provinces pr ON cl.province = pr.code
	LEFT JOIN district di ON cl.district = di.code
	LEFT JOIN subdistrict su ON cl.sub_district = su.code
	 ORDER BY LTRIM(company_name) asc ";   
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
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
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
		top: 10px;
	}
	h1, h2, h3, h4, h5, h6, b, span, p, table, a, div, label, ul, li, div,
	button {
		font-family: Manrope, 'IBM Plex Sans Thai';
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
						<li class="active" >Company Information</li>
					</ul>
				</div>
			</div>
        </div>

		<div class="container-fluid">
			<!-- DataTales Example -->
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<div class="panel-title" style="display: inline-block;">
						<h2 class="title m-5" style="color: #102958;">Company Information</h2>
					</div>
					<div class="row pull-right" style="display: inline-block;">
						<div class="text-right" style="margin: 5px;">

							<div class="row">
								<!-- <a href="add-company.php" class="btn btn-primary" style="color:#F9FAFA;" >
									<svg  width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
										<path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
										<path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
									</svg>
									<span class="text">Add Company</span>
								</a>  
							&nbsp;&nbsp; -->

							<div class="dropdown">
							<!--<button class="btn btn-primary mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Export
							</button>-->
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
				</div>

				
				<div class="card-body" >
					<div class="table-responsive" style="font-size: 13px;">
						<!-- width="2000px"  -->
						<!-- style="width:300%;" table-striped width="2500px-->
						<table id="example" class="table table-bordered "  style="color: #969FA7;" width="100%" >
							<thead >
								<th class="text-center">#</th>
									<th>Company name</th>
									<th>Address</th>
									<th>Email</th>
									<!-- <th>Tel</th> -->
									<th>Phone</th>
									<th>Status</th>
									<th>Action</th>
							</thead>
							<tbody style="color: #0C1830; font-size: 13px;" >
								<?php 
									$cnt=1;
									if($query->rowCount() > 0){
									   foreach($results as $result){ 
										
								?> 
									<tr>
										<td class="text-center"><?php echo $cnt;?></td>
										<td ><?php echo $result->company_name; ?></td>
										<td><?php  $address= $result->address_number." ".$result->building_name." ".$result->soi." ".$result->road; 
											 $address=$address." ".$result->province_name." ".$result->district_name." ".$result->sub_district_name." ".$result->post_code;
											echo $address;
										?></td>
										<td><?php echo $result->email;?></td>
										<td><?php echo $result->mobile;?></td>
										<td class="text-center"><?php if($result->status==1){ echo "Active"; }else{ echo "InActive"; } ?></td>
										<td class="text-center">
										<i title="Edit Record"><a href="edit-company.php?id=<?php echo $result->id;?>">
								 <svg width="20" height="20" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
								  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
								</svg>
									</a></i> &nbsp;&nbsp;
										
								<!-- <i class="fa " title="Delete this Record" ><a href="companylist.php?id=<?php echo $result->id;?>" onclick="return confirm('Do you really want to delete data?');">
								<svg width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
								  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
								  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
								</svg>
								</i>  -->
								</a>

							</td>

								<?php $cnt++;}} ?>                       
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
    
    // { extend: 'copy', className: 'btn-primary',charset: 'UTF-8',bom: true },
    // "bDestroy": true,
    // "aLengthMenu": [[25,50,100,200,-1],[25,50,100,200,"ALL"]],
    
    var table = $('#example').DataTable({
        scrollX: true,
       
        "scrollCollapse": true,
        "paging":         true,
        buttons: [
            { extend: 'csv',class: 'buttons-csv',className: 'btn-primary',charset: 'UTF-8',filename: 'Company Information',bom: true
            ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
            { extend: 'excel',class: 'buttons-excel', className: 'btn-primary',charset: 'UTF-8',filename: 'Company Information',bom: true 
            ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
            { extend: 'pdf',class: 'buttons-pdf',className: 'btn-primary',charset: 'UTF-8',filename: 'Company Information',bom: true 
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
<?php } ?>
