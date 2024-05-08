<?php
session_start();
error_reporting(0);
include_once('includes/connect_sql.php');
include_once('includes/fx_reports.php');


if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    $customers = get_customers ($conn);
    $products = get_products ($conn);
    $insurance_policy = get_policy_no($conn);
    $partners = get_partners($conn);
    $subcategories = get_product_subcategory($conn);
    $data = array();
    $data['date_from'] ='';
    $data['date_to'] ='';
    $data['customer'] ='';
    $data['policy_no']='';
    $data['product']='';
    $data['category']='';
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
        $data['partner']=$_GET['partner'];
        $data['status']=$_GET['status'];
        //print_r($_GET);
        $cus = isset($_GET['customer']) ? $_GET['customer'] : '';
        $insurance_customer = get_customer_insurance ($conn, $cus);        
    }
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
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>
        
    <script>
        /*new DataTable('#example', {
    layout: {
        topStart: {
            buttons: ['copy', 'excel', 'pdf', 'colvis']
        }
    }
        });*/
    </script>

<style>
    .converted {
       /*width: 5%;*/
    }
	
	.btn-group>.btn:first-child {
		border-color: #102958;
	}
</style>

</head>

<body id="page-top" >

    <!-- Page Wrapper -->
    <div id="wrapper" >
        <?php include('includes/leftbar2.php');?>   
        <?php include('includes/topbar2.php');?>  

            <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Report: Sales By Customer</h6>                                 
                            </div>
                        </div>

         <div class="container-fluid">
            <div class="panel">
            <form method="get" >
                <br>
                    <div class="form-group row">
                    
                    <label style="color: #102958;"  class="col-sm-2 col-form-label">From Date:</label>

                       <div class="col-sm-2">
                       <!-- <input type='text' style="color: #0C1830;border-color:#102958;" class=" form-control datepicker search_input" name="date_from" id="date_from" value="" /> -->                                               
                        <input  style="color: #0C1830;border-color:#102958;" type="date" name="date_from" class="form-control" id="date_from" value="<?php echo ($_GET['date_from'] != '') ? date('Y-m-d', strtotime($_GET['date_from'])) : '';?>" placeholder="dd-mm-yyyy">
                        </div>

                         <label style="color: #102958;" for="staticEmail" class="col-sm-2 ">To Date:</label>
                        <div class="col-sm-2">
                        <input  style="color: #0C1830;border-color:#102958;" type="date" name="date_to" class="form-control" id="date_to" value="<?php echo  ($_GET['date_to'] != '') ? date('Y-m-d', strtotime($_GET['date_to'])) : '';?>" >
                        </div>
                        
                       <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Currency Convertion:</label>                    
                        <div class="col-sm-2">                		
                    		<input type='checkbox' id="convert" style="color: #0C1830;border-color:#102958;" class=" form-control" name="currency_conversion" value="" <?php echo (isset($_GET['currency_conversion'])) ? 'checked="checked"' : '';?> /> 
                        </div>
                    </div>
                    
                    <div class="form-group row">
                    	<label style="color: #102958;" for="policy_no" class="col-sm-2 ">Policy no:</label>
                        <div class="col-sm-2">
                        	<select name="policy_no" style="border-color:#102958;" id="policy_no" onchange="" class="form-control">
                                <option value="">Select Policy</option>
                                <?php foreach ($insurance_policy as $p) { ?>
                                <option value="<?php echo $p['policy_no'];?>" <?php echo  ($_GET['policy_no'] == $p['policy_no']) ? 'selected' : '';?>><?php echo $p['policy_no'];?></option>
                                <?php } ?>
                            </select>
                    		
                        </div>
                        
                         <label style="color: #102958;" for="customer_name" class="col-sm-2 ">Customer name:</label>
                        <div class="col-sm-2">
                            <select name="customer" style="border-color:#102958;" id="customer" onchange="" class="form-control" >
                                <option value="">Select Customer</option>
                                <?php foreach ($customers as $c) { ?>
                                <option value="<?php echo $c['id'];?>" <?php echo  ($_GET['customer'] == $c['id']) ? 'selected' : '';?>><?php echo $c['customer_name'];?></option>
                                <?php } ?>
                            </select>                            
                        </div>
                        
                        
                        <label style="color: #102958;" for="partner" class="col-sm-2 ">Partners:</label>
                        <div class="col-sm-2">
                        	<select name="partner" style="border-color:#102958;" id="partner" onchange="" class="form-control">
                                <option value="">Select Policy</option>
                                <?php foreach ($partners as $p) { ?>
                                <option value="<?php echo $p['id'];?>" <?php echo  ($_GET['partner'] == $p['id']) ? 'selected' : '';?>><?php echo $p['insurance_company'];?></option>
                                <?php } ?>
                            </select>
                    		
                        </div>
                    </div>

                    
                    <div class="form-group row">
                    	<label style="color: #102958;" for="category" class="col-sm-2 col-form-label">Product Category:</label>                    
                        <div class="col-sm-2">                		
                    		<select name="category" style="border-color:#102958;" id="category" onchange="" class="form-control">
                                <option value="">Select Category</option>
                                <?php foreach ($subcategories as $p) { ?>
                                <option value="<?php echo $p['id'];?>" <?php echo  ($_GET['category'] == $p['id']) ? 'selected' : '';?>><?php echo $p['subcategorie'];?></option>
                                <?php } ?>
                            </select> 
                        </div>
                        
                        <label style="color: #102958;" for="product" class="col-sm-2 col-form-label">Product:</label>                    
                        <div class="col-sm-2">                		
                    		<select name="product" style="border-color:#102958;" id="product" onchange="" class="form-control">
                                <option value="">Select Product</option>
                                <?php foreach ($products as $p) { ?>
                                <option value="<?php echo $p['id'];?>" <?php echo  ($_GET['product_id'] == $p['id']) ? 'selected' : '';?>><?php echo $p['product_name'];?></option>
                                <?php } ?>
                            </select> 
                        </div>
                        
                        <label style="color: #102958;" for="status" class="col-sm-2 col-form-label">Status:</label>
                        <div class="col-sm-2">   
                         <select id="status_i_input" name="status" onchange="" style="border-color:#102958;" class="form-control" >
                            <option value="New">New</option>
                            <option value="Follow up">Follow up</option>
                            <option value="Renew">Renew</option>
                            <option value="Wait">Wait</option>
                            <option value="Not renew">Not renew</option>
                        </select>
                        </div>
                    
                    </div>
                    
					<div class="form-group row">
						<div class="col-md-12 text-center">
							<button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-primary">Search</button>
							</div>
					</div>

					
						
                    <div class="form-group row">                        
                        <div class="col-md-12">
                            <div class="text-right">
                                <div class="dropdown">
                                      <button class="btn btn-primary mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Export
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
                                        <a class="dropdown-item" id="btnCsv" style="font-size: 15px;" >CSV</a>
                                        <a class="dropdown-item" id="btnExcel" style="font-size: 15px;" >Excel</a>
                                        <a class="dropdown-item" id="btnPdf" style="font-size: 15px;" >PDF</a>
                                        <a class="dropdown-item" id="btnPrint" style="font-size: 15px;" >Print</a>
                                      </div>
                                </div> <!-- dropdown -->                                
                            </div> <!-- text right -->
                        </div> <!-- col-md-12 -->
                    </div> <!-- form group -->
                    </form>
            </div>
            </div>
						
						
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example"  cellspacing="0">
                                 <thead>   
                                    <tr>
                                            <th class="text-center"  style="width: 2%;">#</td>
                                            <th class="text-center"  style="width: 10%;">Company Name</th>
                                            <th class="text-center"  style="width: 5%;">Contact Person</th>
                                            <th class="text-center"  style="width: 5%;">Position</th>
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
                                <tbody>
                                    <?php 
                                    
    						//print_r($insurance_customer);
    						if (count($insurance_customer) > 0) {
    						    $ctr = 1;
    						foreach ($insurance_customer as $cus) {
    						    $total_premium_rate = 0;
    						    $total_converted_value = 0;
    						    $sales  = get_sales_by_customer ($conn, $data, $cus['id_customer']);
    						    //print_r($sales);
    						    if (count(sales) > 0 && $sales[0]['customer_name']) {
    						    //if (count(sales) > 0 ) {
						    ?>
						    		
						    		    
                                    <?php 
                                    foreach ($sales as $s) {
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
                                            <td class="text-center" style="width: 2%;"><?php echo $ctr;?></td>
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
                                    
                                    ?>      	                      
                                    <tr style="font-weight: bold;">
                                            <td ></td>
                                            <td></td>
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
                                    } // foreach (sales)
                                    $ctr++;
    						    }// if count(sales)
    						} // foreach (insurance_customer)
    						
    						} // if count(insurance_customer)
                                 ?>   
                                 </tbody>
                                 <!-- <tfoot>
                                 	<tr style="font-weight: bold;">
                                        <th colspan="17"></th>                                                                              
                                    </tr>  
                                 </tfoot> -->
                                </table>
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
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

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
        
        <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <!-- <script src="assets/js/custom.js"></script> -->
        
        <script>
        
               /*$('#example').DataTable({
               		"order": [], //Initial no order.
         			"aaSorting": [],
         			//Set column definition initialisation properties.
                    "columnDefs": [
                    { 
                        "targets": [ ], //first column / numbering column
                        "orderable": false, //set not orderable
                    }]
               });*/

                $('#example2').DataTable( {
                    "scrollY":        "300px",
                    "scrollCollapse": true,
                    "paging":         false,
                    "ordering": false
                } );

                $('#example3').DataTable({
               		"ordering": false               		
               });
                
                $('#convert_').click(function(){
					if ($(this).is(':checked')) {
					
						$('.converted').show();
						//$('.converted').css('display', 'block');
					}
					else {
						//$('.converted').remove();
						
						//var _class = 'converted';
						//removeElementsByClass(_class);
						//console.log($('#example'));
						$('.converted').hide();
						//$('.converted').css('display', 'none');
        			}
				});
				
		var table = $('#example').DataTable({
        scrollX: true,
        "scrollCollapse": true,
        "paging":         true,
        "ordering": false,
        "order": [],
        "columnDefs": [
                    { 
                        "targets": [ ], //first column / numbering column
                        "orderable": false, //set not orderable
                    }],
        buttons: [
            
            { extend: 'csv', className: 'btn-primary',charset: 'UTF-8',filename: 'file_csv',bom: true},
            { extend: 'excel', className: 'btn-primary',charset: 'UTF-8',filename: 'file_excel',bom: true },
            { extend: 'pdf', className: 'btn-primary',charset: 'UTF-8',filename: 'file_pdf',bom: true },
            { extend: 'print', className: 'btn-primary',charset: 'UTF-8',bom: true }
            ]
    });

    table.buttons().container()
    .appendTo('#example_wrapper .col-md-6:eq(0)');
				
				function removeElementsByClass(className){
                    const elements = document.getElementsByClassName(className);
                    while(elements.length > 0){
                        elements[0].parentNode.removeChild(elements[0]);
                    }
                }

            
        </script>
      <!-- 
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
  $( function() {
    $('#date_from').datepicker({
    		showOn: 'button', 
    		buttonImageOnly: true, 
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			minDate: new Date(), // = today
			onSelect: function(dateText, inst) {
				//change_date_calc();
				redraw_summary_table();
				get_form_fields();
			}		
		}).next('button').button({
        icons: {
            primary: 'ui-icon-calendar'
        }, text:false
    });
  } );
  </script> -->  

</body>

</html>

