<?php

include_once('includes/connect_sql.php');
session_start();
error_reporting(0);
include_once('includes/fx_reports_history.php');

if(strlen($_SESSION['alogin'])=="") {
	$dbh = null;
    header('Location: logout.php');
}

    $status_view ='0';
    $status_add ='0';
    $status_edit ='0';
    $status_delete ='0';
    foreach ($_SESSION["application_page_status"] as $page_id) {
        if($page_id["page_id"]=="15"){
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

$contacts=null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)) {
        $start_date = date('Y-m-d', strtotime($_POST['start_date']));
        $end_date = date('Y-m-d', strtotime($_POST['end_date']));

        $customers = get_reports_history_search($conn,$_POST);
        $policy=$_POST['policy_no'];
        $customer_select=$_POST['customer'];
        $partner=$_POST['partner'];
        $pro_categorie=$_POST['product_cat'];
        $categorie=$_POST['sub_cat'];
        // $product=$_POST['product'];
        $status=$_POST['status'];
        $status_currency=$_POST['status_currency'];
    }
}else{
    $customers = get_reports_history_start($conn);
    // $start_date = date('Y-m-d');
    // $end_date   = date('Y-m-d');
    $policy="all";
    $customer_select="all";
    $partner="all";
    $pro_categorie="all";
    $categorie="all";
    // $product="all";
    $status="all";
    // $status_currency="true";
    $status_currency="false";
}
// $customers_list = get_customers_search_start($conn);

$customers_list = get_customers_list ($conn);
$products = get_products ($conn);
$insurance_policy = get_policy_no($conn);
$partners = get_partners($conn);

$product_categorie = get_product_categories($conn);
$subcategories = get_product_subcategory($conn);

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
        
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/css/bootstrap-datetimepicker.min.css">
		

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
                                        <li class="active" >History Report</li>
                                    </ul>
                                </div>
                            </div>
        </div>

            <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header">
 
                            <div class="panel-title" >
                                <h2 class="title m-5" style="color: #102958;">Report: History Report
                            </div>
                        </div>
						
						

<form method="post" action="report-history.php" >
    <div class="container-fluid">
            <div >
                <br>
                    <div class="form-group row col-md-12 " >
                        <label style="color: #102958;"  class="col-sm-2 label_left">From Date:</label>
                        <div class="col-sm-2">
                            <!-- <input  style="color: #0C1830;border-color:#102958;" type="date" name="start_date" class="form-control" id="start_date" value="<?php echo ($_POST['start_date'] != '') ? date('d-m-Y', strtotime($_POST['start_date'])) : '';?>" placeholder="dd-mm-yyyy"> -->
                            <input id="start_date" name="start_date" style="color: #000;border-color:#102958; text-align: center;" type="text" class="form-control" value="<?php echo ($_POST['start_date'] != '') ? $_POST['start_date'] : '';?>" placeholder="dd-mm-yyyy" >
                        </div>

                        <label style="color: #102958;"  class="col-sm-2 label_right">End Date:</label>
                        <div class="col-sm-2">
                            <input  style="color: #000;border-color:#102958; text-align: center;" type="text" name="end_date" class="form-control" id="end_date" value="<?php echo ($_POST['end_date'] != '') ? date('d-m-Y', strtotime($_POST['end_date'])) : '';?>" placeholder="dd-mm-yyyy" >
                        </div>
                    </div>
						
					<script>
						/*AA add */
						// var currentDate = new Date();
						// var formattedDate = (currentDate.getDate() < 10 ? '0' : '') + currentDate.getDate() + '-' + ((currentDate.getMonth() + 1) < 10 ? '0' : '') + (currentDate.getMonth() + 1) + '-' + currentDate.getFullYear();
						// $('#start_date, #end_date').val(formattedDate);
						/*AA add */

                        var emptyPost = "<?php echo (empty($_POST) ? 'true' : 'false'); ?>";
                        if (emptyPost === 'false') {
                            var startDate = "<?php echo $_POST['start_date']; ?>";
                            if(startDate === ""){
                                var currentDate = new Date();
                                var formattedDate = (currentDate.getDate() < 10 ? '0' : '') + currentDate.getDate() + '-' + ((currentDate.getMonth() + 1) < 10 ? '0' : '') + (currentDate.getMonth() + 1) + '-' + currentDate.getFullYear();
                                $('#start_date').val(formattedDate);
                            }
                            var endDate = "<?php echo $_POST['end_date']; ?>";
                            if(endDate === ""){
                                var currentDate = new Date();
                                var formattedDate = (currentDate.getDate() < 10 ? '0' : '') + currentDate.getDate() + '-' + ((currentDate.getMonth() + 1) < 10 ? '0' : '') + (currentDate.getMonth() + 1) + '-' + currentDate.getFullYear();
                                $('#end_date').val(formattedDate);
                            }
                        }else{
                            var currentDate = new Date();
                                var formattedDate = (currentDate.getDate() < 10 ? '0' : '') + currentDate.getDate() + '-' + ((currentDate.getMonth() + 1) < 10 ? '0' : '') + (currentDate.getMonth() + 1) + '-' + currentDate.getFullYear();
                                $('#start_date, #end_date').val(formattedDate);
                        }
						
						$(document).ready(function(){
							$('#start_date').datepicker({
							  format: 'dd-mm-yyyy',
							  language: 'en'
							});
							$('#end_date').datepicker({
							  format: 'dd-mm-yyyy',
							  language: 'en'
							});
					  });
					</script>

                    <div class="form-group row col-md-12 ">
                        <label style="color: #102958;" class="col-md-2 label_left">Policy no:</label>
                        <div class="col-md-2">
                            <select id="policy_no" name="policy_no" value="<?php echo $policy; ?>" style="border-color:#102958; color: #000;" class="form-control selectpicker" data-live-search="true" >
                                 <option value="all">All</option>
                                <?php foreach ($insurance_policy as $p) { ?>
                                <option value="<?php echo $p['policy_no'];?>" <?php echo  ($policy == $p['policy_no']) ? 'selected' : '';?>><?php echo $p['policy_no'];?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <label style="color: #102958;" class="col-md-2 label_right">Cust. name:</label>
                        <div class="col-md-2">
                           
                            <select id="customer" name="customer" value="<?php echo $customer_select; ?>" style="border-color:#102958; color: #000;" class="remove-example form-control selectpicker" data-live-search="true" >
                                <option value="all">All</option>
                                <?php //echo $value['id']; ?>
                                <?php foreach ($customers_list as $value) { ?>
                                    <option value="<?php echo $value['id']; ?>" 
                                        <?php if ($value['id']==$customer_select) { echo 'selected="selected"'; } ?>
                                        ><?php echo trim($value['customer_name']); ?>
                                    </option>
                                <?php } ?>    
                            </select>                        
                        </div>
                        
                        
                        <label style="color: #102958;"  class="col-md-2 label_left">Partners:</label>
                        <div class="col-md-2">
                            <select  id="partner" name="partner" value="<?php echo $partner; ?>" style="border-color:#102958; color: #000;" class="form-control selectpicker" data-live-search="true" >
                                 <option value="all">All</option>
                                <?php foreach ($partners as $p) { ?>
                                <option value="<?php echo $p['id'];?>" <?php echo  ($partner == $p['id']) ? 'selected' : '';?>><?php echo $p['insurance_company'];?></option>
                                <?php } ?>
                            </select>
                            
                        </div>
                    </div>

                    <div class="form-group row col-md-12 ">
                        
                        <label style="color: #102958;"  class="col-sm-2 label_left">Produ. Categories:</label>
                        <div class="col-sm-2">                     
                        <select id="product_cat" name="product_cat" value="<?php echo $pro_categorie; ?>" style="border-color:#102958; color: #000;" onchange="" class="form-control selectpicker" data-live-search="true">
                             <option value="all">All</option>
                            <?php foreach ($product_categorie as $p) { ?>
                            <option value="<?php echo $p['id'];?>" <?php echo  ($pro_categorie == $p['id']) ? 'selected' : '';?>><?php echo $p['categorie'];?></option>
                            <?php } ?>
                        </select> 
                        </div>

                         <label style="color: #102958;" for="staticEmail" class="col-sm-2 label_right">Sub Categories:</label>                    
                        <div class="col-sm-2">                      
                            <select id="sub_cat" name="sub_cat" style="border-color:#102958; color: #000;" value="<?php echo $product; ?>" class="form-control selectpicker" data-live-search="true">
                                 <option value="all">All</option>
                            <?php foreach ($subcategories as $p) { ?>
                            <option value="<?php echo $p['id'];?>" <?php echo  ($categorie== $p['id']) ? 'selected' : '';?>><?php echo $p['subcategorie'];?></option>
                            <?php } ?>
                            </select> 
                        </div>

                        <label style="color: #102958;" for="staticEmail" class="col-sm-2 label_left">Status:</label>
                        <div class="col-sm-2">   
                        <select id="status" name="status" value="<?php echo $status; ?>" style="border-color:#102958; color: #000;" class="form-control" >
                            <option value="all">All</option>
                    <option value="New"  <?php if ("New"==$status) { echo 'selected="selected"'; } ?> >New</option>
                    <option value="Follow up" <?php if ("Follow up"==$status) { echo 'selected="selected"'; } ?> >Follow up</option>
                    <option value="Renew" <?php if ("Renew"==$status) { echo 'selected="selected"'; } ?> >Renew</option>
                    <option value="Wait" <?php if ("Wait"==$status) { echo 'selected="selected"'; } ?> >Wait</option>
                    <option value="Not renew" <?php if ("Not renew"==$status) { echo 'selected="selected"'; } ?> >Not renew</option>
                        </select>
                        </div>

                    </div>

                    <div class="form-group row col-md-12 ">
                        <div class="col-sm-2 label_left" >
                            <label style="color: #102958;" >Currency Conversion:</label>
                        </div>
                    <div class="col-sm-2 " >
                        <input id="status_currency" name="status_currency" class="form-check-input" value="true" type="checkbox" id="flexCheckDefault"  <?php if($status_currency=="true"){ echo "checked"; }?> >
                        <label style="color: #000;" class="form-check-label" for="flexCheckDefault">
                        <!-- &nbsp;&nbsp;&nbsp;&nbsp; Active -->
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
                                <table class="table table-bordered" id="example" cellspacing="0" >
                                    <thead style="font-size: 13px;">
                                        <tr>
                                            <!-- <th class="text-center" width="20px" hidden="true" >No run</th> -->
                                            <th>No</th>
                                            <th width="200px">Cust. Name</th>
                                            <th width="200px">Contact Person</th>
                                            <th width="130px">Position</th>
                                            <th width="200px">Email</th>

                                            <th width="100px">Mobile Phone</th>
                                            <th width="100px">Policy No</th>
                                            <th width="250px">Prod./Sub Categories</th>
                                            <!-- <th>Tel</th> -->
                                            <th width="90px">Start Date</th>
                                            <th width="90px">End Date</th>
                                            

                                            <?php if($status_currency=="true"){ ?>
                                            <th width="70px">Symbol</th>
                                            <th width="100px">Premium Rate</th>
                                            <?php } ?>

                                            <th width="100px">Premium Conv.(฿THB)</th>

                                            <th width="100px" >Status</th>
                                            <th width="90px">Payment Date</th>
                                            <th width="300px" >Partner Company</th>
                                            <th width="150px">Remark</th>
                                            <th width="100px">Created Date</th>
                                            <th width="100px">Created By</th>
                                            <th width="100px">Modify Date</th>
                                            <th width="100px">Modify By</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 13px;">
										<?php $ctr = 1; foreach ($customers as $value) { ?>
										<tr>
                                            <td class="text-center"><?php echo $ctr; ?></td>
                                            <!-- <td><?php //echo $value['insurance_company'];?></td> -->
                                            <td><?php echo $value['full_name'];?></td>
                                            <td><?php echo $value['first_name_con'].' '.$value['last_name_con'];?></td>
                                            <td><?php echo $value['position'];?></td>
                                            <td><?php echo $value['email'];?></td>
                                            <td><?php echo $value['mobile'];?></td>
                                            
                                            <td><?php echo $value['policy_no'];?></td>
                                            <td><?php echo $value['categorie']; if($value['subcategorie']!=""){ echo "/".$value['subcategorie'];} ?></td>
                                            
                                            <td class="text-center"><?php echo $value['in_start_date'];?></td>
                                            <td class="text-center"><?php echo $value['in_end_date'];?></td>

                                            <?php if($status_currency=="true"){ ?>
                                            <td class="text-center"><?php  echo $value['currency']; ?> </td>

                                            <td class="text-right"> 
                                            <?php 
                                              
                                                // if($value['premium_rate']!="" && $value['currency'] !="฿THB" ){ 

                                                // if($value['currency_value']<$value['currency_value_convert']){
                                                //     $convert = number_format((float)($value['premium_rate']/$value['currency_value_convert']), 2, '.', ',');
                                                //     $premium_rate_convert =$premium_rate_convert+((float)str_replace(',', '', $convert));
                                                //     $total_premium_rate_convert+=((float)str_replace(',', '', $convert));
                                                //     echo $convert;
                                                // }else{
                                                //     $convert = number_format((float)($value['premium_rate']*$value['currency_value_convert']), 2, '.', ',');
                                                //     $premium_rate_convert =$premium_rate_convert+((float)str_replace(',', '', $convert));
                                                //     $total_premium_rate_convert+=((float)str_replace(',', '', $convert));
                                                //     echo $convert;
                                                // }

                                                // }else{ echo "0.00"; $convert=0; }; 
                                                echo $value['convertion_value'];
                                            ?>
                                            </td>

                                           

                                            <?php 
                                            //     if($value['premium_rate']!=""){ 
                                            // $convert = number_format((float)($value['premium_rate']/$value['currency_value']), 2, '.', ',');
                                            // $premium_rate_convert =$premium_rate_convert+$convert;
                                            // $total_premium_rate_convert+=$convert;
                                            //     echo $convert; 
                                            // }else{ echo "0.00"; }; 
                                            // if($value['currency']!=""){ echo "(".$value['currency'].")"; } 
                                            ?>
                                            
                                            <?php } ?>

                                             <td class="text-right">
                                            <?php 
                                            if($value['premium_rate']!=""){ echo number_format((float)$value['premium_rate'], 2, '.', ','); }else{ echo "0.00"; } 
                                            $premium_rate=$premium_rate+$value['premium_rate'];
                                            $total_premium_rate+=$value['premium_rate']; 
                                            ?>
                                            </td>

                                            <td class="text-center" ><?php echo $value['status'];?></td>
                                            <td class="text-center"><?php echo $value['in_paid_date'];?></td>
                                            <td><?php echo $value['insurance_company'];?></td>
                                            <td><?php echo $value['remark'];?></td>
                                            <td class="text-center"><?php echo $value['mindate'];?></td>
                                            <td><?php echo $value['create_by_user'];?></td>
                                            <td class="text-center"><?php echo $value['maxdate'];?></td>

                                            <td><?php echo $value['modify_by_user'];?></td>

										</tr>
										<?php $ctr++; } ?>  

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
				max-width: 140px;
			}
			.label_right{
				max-width: 140px;
			}
		/*}*/
		
		.table th {
			vertical-align: middle !important;
			text-align: center !important;
		}
		.table thead th.sorting:after,
		.table thead th.sorting_asc:after,
		.table thead th.sorting_desc:after {
			top: 20px;
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
    var table = $('#example').DataTable({
        scrollY: 400, // ตั้งค่าความสูงที่คุณต้องการให้แถวแรก freeze
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            fixedColumns: {
                leftColumns: 1 // จำนวนคอลัมน์ที่คุณต้องการให้แถวแรก freeze
            },
        // scrollX: true,
        "scrollCollapse": true,
        "paging":         true,
        buttons: [
            { extend: 'csv',class: 'buttons-csv',className: 'btn-primary',charset: 'UTF-8',filename: 'Report History Report',bom: true
            ,init : function(api,node,config){ $(node).hide();} },
            { extend: 'excel',class: 'buttons-excel', className: 'btn-primary',charset: 'UTF-8',filename: 'Report History Report',bom: true 
            ,init : function(api,node,config){ $(node).hide();} },
            { extend: 'pdf',class: 'buttons-pdf',className: 'btn-primary',charset: 'UTF-8',filename: 'Report History Report',bom: true 
            ,orientation: 'landscape',init : function(api,node,config){ $(node).hide();},
			customize: function(doc) {
				// Loop through all rows and cells to align text to the right
				doc.content.forEach(function(item) {
					if (item.table) {
						item.table.body.forEach(function(row) {
							row.forEach(function(cell, i) {
								if (typeof cell === 'object' && cell.text !== undefined) {
									if (i === 1) { // Check if it's the second column (index 1)
										cell.alignment = 'left'; // Align left for the second column (month)
									} else if (!isNaN(parseFloat(cell.text))) { // Check if it's a number
										cell.alignment = 'right'; // Align right for numeric columns
									}
								}
							});
						});
					}
				});
			}			},
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

<?php $dbh = null;?>