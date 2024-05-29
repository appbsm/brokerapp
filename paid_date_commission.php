<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<?php
	include_once('includes/connect_sql.php');
	session_start();
	error_reporting(0);
	include_once('includes/fx_paid_date_db.php');

	// alert('not checked');

	if(strlen($_SESSION['alogin'])=="") {
		$dbh = null;
		header('Location: logout.php');
	}

	$status_view ='0';
	$status_add ='0';
    $status_edit ='0';
    $status_delete ='0';
    foreach ($_SESSION["application_page_status"] as $page_id) {
        if($page_id["page_id"]=="26"){
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
	
	// else{

	// if($_GET['id']){
	// 	$sql="delete from currency_convertion where id=:id";
	// 	$query = $dbh->prepare($sql);
	// 	$query->bindParam(':id',$_GET['id'],PDO::PARAM_STR);
	// 	$query->execute();
	// 	echo '<script>alert("Deleted Success.")</script>';
	// 	echo "<script>window.location.href ='currency_convertion.php'</script>";
	// }

	$paid_policy = get_paid_policy($conn,$_GET['status']);
	
	

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
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
						<li class="active" >Commission List</li>
					</ul>
				</div>
			</div>
        </div>

		<div class="container-fluid">
			<!-- DataTales Example -->
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<div class="panel-title" style="display: inline-block;">
						<h2 class="title m-5" style="color: #102958;">Commission List</h2>
					</div>
					<div class="row pull-right" style="display: inline-block;">
						<div class="text-right m-5">
							<div class="row">
								<!-- <a href="add-currency_convertion.php" class="btn btn-primary" style="color:#F9FAFA;" >
									<span class="text">Add Currency Conversion</span>
								</a>  -->
								<div class="dropdown pl-3 pr-3">
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
							</div>
						</div> 
					</div>
                 </div>
  
<!-----------------------------Add Currency List-------------------------------------->
<form method="post">
<!-- hidden="true" -->
<div id="area_add" hidden="true" >
        <div class="panel-heading">
            <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col">
                            <div class="panel-title" style="color: #102958;" >
                                <h2  style="color: #102958;" class="title">Add Currency Convertion</h2>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                        </div>
                        <div class="col-sm-4 text-right ">
                        </div>&nbsp;&nbsp;
            </div>
        </div> 

        <div class="panel-body">
                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left" >
                        <label style="color: #102958;" for="success" class="control-label">Currency</label>
                    </div> 
                    <div class="col ">
                         <input minlength="1" maxlength="50" style="border-color:#102958;" type="text"  required="required" class="form-control" id="currency" name="currency" value="<?php echo $currency; ?>" >
                    </select>
                    </div> 
                    <div class="col ">
                        <input id="status_add" name="status"  class="form-check-input" type="checkbox" value="true" checked>
                        <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Active
                    </div> 
                    <div class="col-sm-2 ">
                    </div>  
                </div> 

                <div class="form-group row col-md-10 col-md-offset-1" >
                     <div class="col-sm-2  label_left" >
                        <label style="color: #102958;" for="success" class="control-label">Description</label>
                    </div> 
                    <div class="col ">
                         <input minlength="1" maxlength="50" style="border-color:#102958;" type="text" class="form-control" id="description" name="description" value="<?php echo $description; ?>" >
                    </select>
                    </div>
                    <div class="col-sm-2 label_right" >
                        <!-- <label style="color: #102958;" for="success" class="control-label">Due Date</label> -->
                    </div> 
                    <div class="col ">
                         <!-- <input minlength="1" maxlength="3" style="border-color:#102958;" type="number" name="due_date" required="required" class="form-control" id="success"  > -->
                    </div>  
                </div> 

                <br>
                <div class="form-group row col-md-10 col-md-offset-1">
                  <!--   <div class="col-md-2">
                    </div>  -->
                    <div class="col-md-10">
                        <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                        </button>
                    </div>
                </div>
                
            </div> 
            <br>

</div>
</form>

<!------------------------------------------------------------------------------->

<!-----------------------------Edit Period-------------------------------------->
<form method="post">
<!-- hidden="true" -->
<div id="area_edit" hidden="true"  >
        <div class="panel-heading">
            <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 style="color: #102958;" class="title">Edit Currency Convertion</h2>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                        </div>
                        <div class="col-sm-4 text-right ">
                        </div>&nbsp;&nbsp;
            </div>
        </div> 
        <div class="panel-body">
                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left" >
                        <label style="color: #102958;" for="success" class="control-label">Currency</label>
                    </div> 
                    <div class="col ">
                         <input hidden="ture" minlength="1" maxlength="50" style="border-color:#102958;" type="text"  required="required" class="form-control" id="id_edit" name="id_edit" value="<?php echo $period; ?>" >

                        <input  minlength="1" maxlength="50" style="border-color:#102958;" type="text"  required="required" class="form-control" id="currency_edit" name="currency_edit" value="<?php echo $id_edit; ?>" >
                    </select>
                    </div> 
                    <div class="col ">
                        <input id="status_edit" name="status_edit"  class="form-check-input" type="checkbox" value="true" checked>
                        <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Active
                    </div> 
                    <div class="col-sm-2 ">
                    </div> 
                   <!--  <div class="col-sm-2 label_right" >
                        <label style="color: #102958;" for="success" class="control-label">Due Date</label>
                    </div> 
                    <div class="col ">
                         <input minlength="1" maxlength="3" style="border-color:#102958;" type="number" name="due_date" required="required" class="form-control" id="success" value="<?php echo $due_date; ?>" >
                    </div>  -->  
                </div> 
                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left" >
                        <label style="color: #102958;" for="success" class="control-label">Description</label>
                    </div> 
                    <div class="col ">
                         <input minlength="1" maxlength="50" style="border-color:#102958;" type="text" class="form-control" id="description_edit" name="description_edit" value="<?php echo $description; ?>" >
                    </select>
                    </div>
                    <div class="col-sm-2 label_right" >
                        <!-- <label style="color: #102958;" for="success" class="control-label">Due Date</label> -->
                    </div> 
                    <div class="col ">
                         <!-- <input minlength="1" maxlength="3" style="border-color:#102958;" type="number" name="due_date" required="required" class="form-control" id="success"  > -->
                    </div> 
                </div> 

                <br>

                <div class="form-group row col-md-10 col-md-offset-1">
                  <!--   <div class="col-md-2">
                    </div>  -->
                    <div class="col-md-10">
                        <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit_edit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                        </button>
                    </div>
                </div>
                
            </div> 
            <br>

</div>
</form>

<!------------------------------------------------------------------------------->
		
<?php if($_GET['status']=='Paid'){ echo "select"; } ?> 
		<div class="card-body" >

			<div class="table-responsive" style="font-size: 13px;" width="100%">

				<div class="pull-right" >
					&nbsp;&nbsp;
						<select class="form-select form-select-sm" id="status" name="status" onchange="handleChange(this)" style="border-color:#767676; border-radius: 2px;"  >
							<option value="Show All" <?php if($_GET['status']=='Show All'){ echo "selected"; } ?> >Show All</option>
		                    <option value="Not Paid" <?php if($_GET['status']=='Not Paid'){ echo "selected"; } ?> >Not Paid</option>
		                    <option value="Paid" <?php if($_GET['status']=='Paid'){ echo "selected"; } ?> >Paid</option> 
		                </select>
				</div>

				<script>
					function handleChange(select) {
						var status = select.value;
						$dbh = null;
				        window.location.href = 'paid_date_commission.php?status=' + encodeURIComponent(status);
					}

				</script>
<!-- width="100%" -->
				<!-- </div> -->
				<table id="example" class="table table-bordered" width="100%" cellspacing="0" style="font-size: 13px;">
				
					<thead >
						<tr style="color: #102958;" >
							<th style="color: #102958;" width="20px" >#</th>
							<th style="color: #102958;" width="100px" >Policy no.</th>
							<th style="color: #102958;" width="70px">Policy Status</th>
							<th style="color: #102958;" width="280px">Partner Name:</th>
							<th style="color: #102958;" width="150px">Cust. Name:</th>

							<th style="color: #102958;" width="70px">Premium Rate:</th>

							<th style="color: #102958;" width="70px">Collected</th><!--Paid Date-->
							<th style="color: #102958;" width="70px">Comm. Rate:</th>

							<th style="color: #102958;" width="70px">Comm. Receive Date</th>
							<th style="color: #102958;" width="70px">Comm. Status</th>
							
							<!-- <th style="color: #102958;" width="100px">End Date</th> -->
							<?php if($status_edit==1){ ?>
							<th style="color: #102958;" width="40px">Action</th>
							<?php }else{ ?>
							<th hidden="true" ></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody style="color: #0C1830; font-size: 13px;" >
					<?php 
						$cnt=1;
						// echo '<script>alert("paid_policy count: '.count($paid_policy).'")</script>'; 
						if(count($paid_policy) > 0){
						foreach($paid_policy as $result){ 
					?> 
					<tr>
						<td class="text-center"><?php echo $cnt;?></td>
						<td class="id_table"  ><?php echo $result['policy_no']; ?></td>
						<td class="text-center" ><?php echo $result['status'];?></td>
						<td class="text-left" class="currency_value" ><?php echo $result['insurance_company_in']; ?></td>
						<td class="text-left" class="currency_code" ><?php echo $result['full_name'];?></td>

						<td class="text-right" ><?php echo number_format((float)$result['premium_rate'], 2,'.', ','); ?></td>
						<td class="text-center" ><?php echo $result['paid_date_day']; ?></td>
						

					<td class="text-right"  ><?php echo number_format((float)$result['commission_rate'],2, '.', ',');?></td>
					
						<td class="text-center" ><?php echo $result['commission_paid_date_day'];?></td>
						<td class="text-center" ><?php echo $result['commission_status'];?></td>
						
						<!-- <td class="text-center" class="stauts_table" ><?php if($result->status==1){ echo "Active"; }else{ echo "InActive"; } ?></td> -->

						<?php if($status_edit==1){ ?>
						<td class="text-center">

							<a href="edit-paid-date.php?id=<?php echo $result['id']; ?>"><i class="fa " title="Edit Record"></i>
								<svg width="20" height="20" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
								  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
								</svg>
							</a>

							<!-- <i class="fa " title="Delete this Record" >
								<a href="currency_convertion.php?id=<?php echo $result->id; ?>" onclick="return confirm('Do you really want to delete data?');">
									<svg width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
										<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
										<path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
									</svg>
								</a>
							</i>  -->
						</td>
						<?php }else{ ?>
						<td hidden="true" ></td>
						<?php } ?>

					</tr> 
					<?php $cnt++;}} ?>  

						</tbody>
				</table>
			</div>
		</div>
		</div>
	</div>
 </div>
<script>
    //  function makeOrder(rowId) {
    //     alert('Click makeOrder');
    //     // var value=document.getElementById(rowId).childNodes[9].value;

    //     var value=document.getElementById(rowId).value;
    //     alert('rowId:'+rowId); 

    //     // var value = $(this).closest("tr").find(".period1").text();

    //     var value = document.getElementById("description1").value;
    //     alert('value:'+value); 
    // }

    // $(document).on('click','.editAction', function () {
    //     alert('not editAction');
    // }
</script>   

<!-- <?php //include('includes_php/popup_table_customer.php');?> -->

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

   <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
    $(document).ready(function(){
    	jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "date-dd-mmm-yyyy-pre": function(a) {
                return moment(a, 'DD-MM-YYYY').unix();
            },
            "date-dd-mmm-yyyy-asc": function(a, b) {
                return a - b;
            },
            "date-dd-mmm-yyyy-desc": function(a, b) {
                return b - a;
            }
        });

    var table = $('#example').DataTable({
    	"columnDefs": [
                { 
                    "targets": [6],
                    "type": "date-dd-mmm-yyyy"
                }
            ],
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
            { extend: 'csv',class: 'buttons-csv',className: 'btn-primary',charset: 'UTF-8',filename: 'Currency Convertion',bom: true
            ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
            { extend: 'excel',class: 'buttons-excel', className: 'btn-primary',charset: 'UTF-8',filename: 'Currency Convertion',bom: true 
            ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
            { extend: 'pdf',class: 'buttons-pdf',className: 'btn-primary',charset: 'UTF-8',filename: 'Currency Convertion',bom: true 
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
<?php //} ?>

<?php $dbh = null;?>
