
<?php
session_start();
error_reporting(0);
include_once('includes/connect_sql.php');
include_once('includes/fx_reports.php');

if(strlen($_SESSION['alogin'])=="") {
    header('Location: logout.php');
}


if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
	
    $customers = get_customers ($conn);
    $products = get_products ($conn);
    $insurance_policy = get_policy_no($conn);
    $partners = get_partners($conn);
	$categories = get_product_category($conn);
    $subcategories = get_product_subcategory($conn);
    $data = array();
    $data['date_from'] ='';
    $data['date_to'] ='';
    $data['customer'] ='';
    $data['policy_no']='';
    $data['product']='';
    $data['category']='';
	$data['subcategory']='';
    $data['partner']='';
    $data['status']='';
    $data['currency_conversion']='';
    
    //$sales =  get_sales_by_customer ($conn, $data);
    
    //print_r($sales);
    if (isset($_GET)) {       
        $data['date_from'] = ($_GET['date_from'] != '') ? date('Y-m-d', strtotime($_GET['date_from'])) : '';
        $data['date_to'] = ($_GET['date_to'] != '') ? date('Y-m-d', strtotime($_GET['date_to'])) : '';
        $data['customer'] =$_GET['customer'];
        $data['policy_no']=$_GET['policy_no'];
        $data['product']=$_GET['product'];
        $data['category']=$_GET['category'];
		$data['subcategory']=$_GET['subcategory'];
        $data['partner']=$_GET['partner'];
        $data['status']=$_GET['status'];
        //print_r($_GET);
          
    }
	
	$cus = isset($_GET['customer']) ? $_GET['customer'] : '';
    $insurance_customer = get_insurance_customer ($conn, $cus);      
	//print_r($insurance_customer);
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
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
                                        <li class="active" >Sales By Customer</li>
                                    </ul>
                                </div>
                            </div>
        </div>

            <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header">
 
                             <div class="panel-title" >
                                <h2 class="title m-5" style="color: #102958;">Report: Sales By Customer
                            </div>  

                         
                        </div>

<form method="get">
<div class="container-fluid">
            <div >
                <br>
                    <div class="form-group row col-md-12 ">
                        <label style="color: #102958;"  class="col-sm-2 label_left">From Date:</label>
                        <div class="col-sm-2">
                            <?php //echo ($_GET['date_from'] != '') ? date('Y-m-d', strtotime($_GET['date_from'])) : '';?>
                            <input  style="color: #0C1830;border-color:#102958;" type="text" name="start_date" class="form-control" id="start_date" value="<?php echo ($_GET['start_date'] != '') ? date('Y-m-d', strtotime($_GET['start_date'])) : '';?>" placeholder="yyyy-mm-dd">
                        </div>

                        <label style="color: #102958;"  class="col-sm-2 label_right">End Date:</label>
                        <div class="col-sm-2">
                            <input  style="color: #0C1830;border-color:#102958;" type="test" name="end_date" class="form-control" id="end_date" value="<?php echo ($_GET['end_date'] != '') ? date('Y-m-d', strtotime($_GET['end_date'])) : '';?>" placeholder="yyyy-mm-dd" >
                        </div>
                    </div>


<script>
  $(document).ready(function(){
    $('#start_date').datepicker({
      format: 'yyyy-mm-dd',
      language: 'en'
    });
    $('#end_date').datepicker({
      format: 'yyyy-mm-dd',
      language: 'en'
    });
  });
</script> 

                    <div class="form-group row col-md-12 ">
                        <label style="color: #102958;" class="col-md-2 label_left">Policy no:</label>
                        <div class="col-md-2">
                            <select name="policy_no" style="border-color:#102958;" id="policy_no" onchange="" class="form-control selectpicker" data-live-search="true">
                                <option value="">All</option>
                                <?php foreach ($insurance_policy as $p) { ?>
                                <option value="<?php echo $p['policy_no'];?>" <?php echo  ($_GET['policy_no'] == $p['policy_no']) ? 'selected' : '';?>><?php echo $p['policy_no'];?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <label style="color: #102958;"  class="col-md-2 label_left">Partners:</label>
                        <div class="col-md-2">
                            <select name="partner" style="border-color:#102958;" id="partner" onchange="" class="form-control selectpicker" data-live-search="true">
                                <option value="">All</option>
                                <?php foreach ($partners as $p) { ?>
                                <option value="<?php echo $p['id'];?>" <?php echo  ($_GET['partner'] == $p['id']) ? 'selected' : '';?>><?php echo $p['insurance_company'];?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <label style="color: #102958;" class="col-md-2 label_right">Customer Name:</label>
                        <div class="col-md-2">
                           
                            <select name="customer" style="border-color:#102958;" id="customer" onchange="" class="form-control selectpicker" data-live-search="true" >
                                <option value="">All</option>
                                <?php foreach ($customers as $c) { ?>
                                <option value="<?php echo $c['id'];?>" <?php echo  ($_GET['customer'] == $c['id']) ? 'selected' : '';?>><?php echo $c['customer_name'];?></option>
                                <?php } ?>
                            </select>                      
                        </div>
                        
                    </div>

                    <div class="form-group row col-md-12 ">
                        
                        <label style="color: #102958;"  class="col-sm-2 label_left">Product Categories:</label>
                        <div class="col-sm-2">                     
							<select name="category" style="border-color:#102958;" id="category" onchange="" class="form-control selectpicker" data-live-search="true">
                                <option value="">All</option>
                                <?php foreach ($categories as $p) { ?>
                                <option value="<?php echo $p['id'];?>" <?php echo  ($_GET['category'] == $p['id']) ? 'selected' : '';?>><?php echo $p['categorie'];?></option>
                                <?php } ?>
                            </select> 
                        </div>

                         <label style="color: #102958;" for="staticEmail" class="col-sm-2 label_right">Sub Categories:</label>                    
                        <div class="col-sm-2">                      
                            <select name="subcategory" style="border-color:#102958;" id="subcategory" onchange="" class="form-control selectpicker" data-live-search="true">
                                <option value="">All</option>
                                <?php foreach ($subcategories as $p) { ?>
                                <option value="<?php echo $p['id'];?>" <?php echo  ($_GET['subcategory'] == $p['id']) ? 'selected' : '';?>><?php echo $p['subcategorie'];?></option>
                                <?php } ?>
                            </select> 
                            </select> 

                           <!--  <select id="product" name="product" style="border-color:#102958;" value="<?php //echo $product; ?>" class="form-control">
                                 <option value="all">All</option>
                                <?php //foreach ($products as $p) { ?>
                                <option value="<?php //echo $p['id'];?>" <?php //echo  ($product == $p['id']) ? 'selected' : '';?>><?php //echo $p['product_name'];?></option>
                                <?php //} ?>
                            </select>  -->
                        </div>

                        <label style="color: #102958;" for="staticEmail" class="col-sm-2 label_left">Status:</label>
                        <div class="col-sm-2">   
                        <select id="status" name="status" style="border-color:#102958;" class="form-control" >
                            <option value="">All</option>
							<option value="New" <?php echo ($_GET['status'] == 'New') ? 'selected' : '';?>>New</option>
                            <option value="Follow up" <?php echo ($_GET['status'] == 'Follow up') ? 'selected' : '';?>>Follow up</option>
                            <option value="Renew" <?php echo ($_GET['status'] == 'Renew') ? 'selected' : '';?>>Renew</option>
                            <option value="Wait" <?php echo ($_GET['status'] == 'Wait') ? 'selected' : '';?>>Wait</option>
                            <option value="Not renew" <?php echo ($_GET['status'] == 'Not renew') ? 'selected' : '';?>>Not renew</option>
                        </select>                   </select>
                        </div>

                    </div>

                    <div class="form-group row col-md-12 ">
                        <div class="col-sm-2 label_left" >
                            <label style="color: #102958;" >Currency Convertion:</label>
                        </div>
                    <div class="col-sm-2 " >
                        <input type='checkbox' id="convert"  name="currency_conversion" value="" <?php echo (isset($_GET['currency_conversion'])) ? 'checked="checked"' : '';?> /> 
                        <label style="color: #0C1830;" class="form-check-label" for="flexCheckDefault">
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
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example"  cellspacing="0" >
                                 <thead>   
                                    <tr>
                                            <th class="text-center" style="width: 2%;" >#</td>
                                            <th class="text-center" style="width: 10%;">Company Name</th>
                                            <th class="text-center" style="width: 5%;">Contact Person</th>
                                            <th class="text-center" style="width: 5%;">Position</th>
                                            <th class="text-center" style="width: 5%;">Email</th>
                                            <th class="text-center" style="width: 5%;">Mobile Phone</th>
                                            <th class="text-center" style="width: 5%;">Policy No</th>
                                            <th class="text-center" style="width: 5%;">SubCategory / Product</th>
                                            <th class="text-center" style="width: 5%;">Start Date</th>
                                            <th class="text-center" style="width: 5%;">End Date</th>
                                            <th class="text-center" style="width: 5%;">Premium Rate</th>
                                            <?php if (isset($_GET['currency_conversion'])) { ?>
                                            <th class="text-center converted" >Converted Value</th>
                                            <th class="text-center converted">Currency Unit</th>
                                            <?php } ?>
                                            <th class="text-center" style="width: 5%;">Status</th>
                                            <th class="text-center" style="width: 5%;">Insurance Co.</th>
                                            <th class="text-center" style="width: 5%;">Underwriter Department</th>
                                            <th class="text-center"style="width: 5%;">Insurance Co Email</th>
                                            <th class="text-center" style="width: 5%;">Insurance Co Phone</th>
                                            <th class="text-center" style="width: 5%;">Remarks</th>                                            
                                        </tr>
                                 </thead>
								 <?php 
							$displayed_row = 0;							
								 ?>
                                <tbody>
                                    <?php 
							$grand_total_premium_rate = 0;
    						$grand_total_converted_value = 0;        
    						//print_r($insurance_customer);
    						if (count($insurance_customer) > 0) {
    						    $ctr = 1;
    						foreach ($insurance_customer as $cus) {
    						    $total_premium_rate = 0;
    						    $total_converted_value = 0;
    						    $sales  = get_sales_by_customer ($conn, $data, $cus['id']);
    						    //print_r($sales);
    						    if (count(sales) > 0 && $sales[0]['customer_name']) {
    						    //if (count(sales) > 0 ) {
						    ?>
						    		
						    		    
                                    <?php 
                                    foreach ($sales as $sub_ctr => $s) {
                                        $partner = get_partner_by_id($conn, $s['partner_id']);
                                        $p = $partner[0];
                                       // print_r($p);
                                        $s_date = $s['start_date'];
                                        $start_date = $s_date->format('d-m-Y');
                                        $e_date = $s['end_date'];
                                        $end_date = $e_date->format('d-m-Y');
                                        $agent_currency = get_conversion ($conn, $s['id_currency'], date('Y-m-d', strtotime($start_date)));
                                        $acurrency = $agent_currency[0];
                                        //print_r($agent_currency);
                                        $converted_value = floatval($s['premium_rate']) / floatval($acurrency['currency_value_convert']);
                                        ?>
                                        <tr>
                                            <td class="text-center" style="width: 2%;"><?php echo ($sub_ctr == 0) ? $ctr : '';?></td>
                                             <td style="width: 10%;"><?php echo $sales[0]['customer_name'];?></td>
                                            <td style="width: 5%;"><?php echo $s['insurance_contact'];?></td>
                                            <td style="width: 5%;"><?php echo $s['position'];?></td>     
                                            <td style="width: 5%;"><?php echo $s['email'];?></td>  
                                            <td style="width: 5%;"><?php echo $s['mobile_phone'];?></td>   
                                             <td style="width: 5%;"><?php echo $s['policy_no'];?></td>     
                                             <td style="width: 5%;"><?php echo $s['product'];?></td>       
                                             <td style="width: 5%;"><?php echo $start_date;?></td> 
                                             <td style="width: 5%;"><?php echo $end_date;?></td> 
                                             
                                             <td style="width: 5%;"><?php echo number_format( $s['premium_rate'], 2);?></td>    
                                             <?php if (isset($_GET['currency_conversion'])) { ?>
                                             <td class="converted"><?php echo number_format($converted_value, 2);?></td>                                             
                                            <td class="converted"><?php echo $acurrency['currency'];?></td>    
                                             <?php } ?>
                                              <td style="width: 5%;"><?php echo $s['status'];?></td>
                                              <td style="width: 5%;"><?php echo $s['insurance_company'];?></td>
                                              <td style="width: 5%;"></td> 
                                              <td style="width: 5%;"><?php echo $p['email'];?></td>                                                    
                                              <td style="width: 5%;"><?php echo $p['phone'];?></td>
                                              <td style="width: 5%;"><?php echo $p['remark'];?></td>                                                              
                                        </tr>  
									<?php 
										$total_premium_rate += $s['premium_rate'];
										$total_converted_value += $converted_value;
										$displayed_row++;
										} // foreach (sales)
									 
                                    
                                    ?>      	                      
                                    <tr style="font-weight: bold;">
                                            <td ></td>
                                            <td>Total</td>
                                            <td></td>     
                                            <td></td>  
                                            <td></td>   
                                             <td></td>     
                                             <td></td>       
                                             <td></td> 
                                             <td></td> 
                                             <td></td> 
                                             <td ><?php echo number_format( $total_premium_rate, 2);?></td>        
                                             <?php if (isset($_GET['currency_conversion'])) { ?>
                                              <td class="converted"><?php echo number_format($total_converted_value, 2)?></td>   
                                              <td class="converted"></td>                                  
                                              <?php } ?>            
                                              <td></td> 
                                              <td></td>                                                    
                                              <td></td>
                                              <td></td>
                                              <td></td>   
                                               <td></td>                                                           
                                        </tr>  
                                            
                                 <?php 
									}// if count(sales)
                                $grand_total_premium_rate += $total_premium_rate;
								$grand_total_converted_value += $total_converted_value;   
								$ctr++;
								
    						} // foreach (insurance_customer)
							} // if count(insurance_customer)
                                 ?>   
                                 </tbody>
								 <?php 
								 //echo $displayed_row;
								 if ($displayed_row > 0) {?>
                                 <tfoot>
                                 	<tr style="font-weight: bold;">
										<th></th>
										<th>Grand Total</th>
										<th></th>     
										<th></th>  
										<th></th>
										<th></th>   
										<th></th>  
										<th></th>
										<th></th>
										<th></th>
										 <th ><?php echo number_format( $grand_total_premium_rate, 2);?></th>        
										 <?php if (isset($_GET['currency_conversion'])) { ?>
										  <th class="converted"><?php echo number_format($grand_total_converted_value, 2)?></th>   
										  <th class="converted"></th>                                  
										  <?php } ?>            
										<th></th>
										<th></th>                                                  
										<th></th>
										<th></th>
										<th></th> 
										<th></th>                                                   
									</tr>          
                                 </tfoot>
								 <?php }
								 else {
								 ?>
								 
								<tfoot>
                                 	<tr style="font-weight: bold;">
										<th>&nbsp;</th>
										<th>&nbsp;</th>
										<th>&nbsp;</th>     
										<th>&nbsp;</th>  
										<th>&nbsp;</th>
										<th></th>   
										<th></th>  
										<th></th>
										<th></th>
										<th></th>
										 <th ></th>        
										 <?php if (isset($_GET['currency_conversion'])) { ?>
										  <th class="converted"></th>   
										  <th class="converted"></th>                                  
										  <?php } ?>            
										<th></th>
										<th></th>                                                  
										<th></th>
										<th></th>
										<th></th> 
										<th></th>                                                   
									</tr>          
                                 </tfoot>
								 <?php } ?>
                                </table>
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

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/custom3.js"></script>

    <style>
/*@media (min-width: 1340px){*/
    .label_left{
        max-width: 140px;
    }
    .label_right{
        max-width: 140px;
    }
/*}*/
    </style> 

    <script>
            $(function($) {
                // $('#example').DataTable();
			// 	$('#example').DataTable({
               // 		"order": [], //Initial no order.
         	// 		"aaSorting": [],
         	// 		//Set column definition initialisation properties.
               //      "columnDefs": [
               //      { 
               //          "targets": [ ], //first column / numbering column
               //          "orderable": false, //set not orderable
               //      },

               // });

                $('#example2').DataTable( {
                    "scrollY":        "300px",
                    "scrollCollapse": true,
                    "paging":         false
                } );

                $('#example3').DataTable();
            });
        </script>

</body>

</html>

