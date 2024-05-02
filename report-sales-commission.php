<?php
session_start();
error_reporting(0);
include_once('includes/connect_sql.php');
include_once('includes/fx_reports.php');


if(strlen($_SESSION['alogin'])==""){   
    header("Location: index.php"); 
}

    $customers = get_customers ($conn);
    $products = get_products($conn);
    $insurance_policy = get_policy_no($conn);
    $agents_paid = agents_paid($conn);
    $data = array();
    $data['customer'] = '';
    $data['date_from']='';
    $data['date_to']='';
    $data['policy_no']='';
    $data['product']='';
    
    //$sales =  get_sales_by_customer ($conn, $data);
    
    //print_r($sales);
    if (isset($_GET)) {       
        $data['date_from'] = ($_GET['date_from'] != '') ? date('d-m-Y', strtotime($_GET['date_from'])) : '';
        $data['date_to'] = ($_GET['date_to'] != '') ? date('d-m-Y', strtotime($_GET['date_to'])) : '';
        $data['customer'] =$_GET['customer'];
        $data['policy_no']=$_GET['policy_no'];
        $data['product']=$_GET['product'];
        //print_r($_GET);
        //$insurance_customer = get_customer_insurance ($conn);
        
    }


    if (!empty($_GET)) {
        // $_GET['currency_conversion'] = "false";
    }else{
        // $_GET['currency_conversion'] = "true";
        $_GET['currency_conversion'] = "false";
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
    
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
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
                                        <li class="active" >Sales Commission</li>
                                    </ul>
                                </div>
                            </div>
        </div>

 <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <div class="panel-title" >
                                <h2 class="title m-5" style="color: #102958;">Report: Sales Commission
                            </div>
                        </div>

    <div class="container-fluid">
        <div >
            <form method="get" >
                <br>
                    <div class="form-group row col-md-12 ">
                    
                    <label style="color: #102958;"  class="col-sm-2 label_left">From Date:</label>

                    <div class="col-sm-2">
                       <!-- <input type='text' style="color: #0C1830;border-color:#102958;" class=" form-control datepicker search_input" name="date_from" id="date_from" value="" /> -->                                               
                        <input  style="color: #0C1830;border-color:#102958;" type="text" name="date_from" class="form-control" id="date_from" value="<?php echo ($_GET['date_from'] != '') ? date('d-m-Y', strtotime($_GET['date_from'])) : '';?>" placeholder="dd-mm-yyyy" >
                    </div>

                    <label style="color: #102958;" for="staticEmail" class="col-sm-2 label_left">To Date:</label>
                    <div class="col-sm-2">
                        <input  style="color: #0C1830;border-color:#102958;" type="text" name="date_to" class="form-control" id="date_to" value="<?php echo  ($_GET['date_to'] != '') ? date('d-m-Y', strtotime($_GET['date_to'])) : '';?>" placeholder="dd-mm-yyyy" >
                    </div>

<script>
  $(document).ready(function(){
    $('#date_from').datepicker({
      format: 'dd-mm-yyyy',
      language: 'en'
    });
    $('#date_to').datepicker({
      format: 'dd-mm-yyyy',
      language: 'en'
    });
  });
</script>
                        
                    <label style="color: #102958;" for="staticEmail" class="col-sm-2 label_left">Customer name:</label>
                        <div class="col-sm-2">
                            <select name="customer" style="border-color:#102958;" id="customer" class="form-control selectpicker" data-live-search="true" >
                                <option value="">Select Customer</option>
                                <?php foreach ($customers as $c) { ?>
                                <option value="<?php echo $c['id'];?>" <?php echo  ($_GET['customer'] == $c['id']) ? 'selected' : '';?>><?php echo $c['customer_name'];?></option>
                                <?php } ?>
                            </select>                            
                        </div>
                    </div>
                    
                    <div class="form-group row col-md-12 ">
                    
						<label style="color: #102958;" for="staticEmail" class="col-sm-2 label_left">Policy no:</label>
						<div class="col-sm-2">
							<select name="policy_no" style="border-color:#102958;" id="policy_no" class="form-control selectpicker" data-live-search="true" >
								<option value="">Select Policy</option>
								<?php foreach ($insurance_policy as $p) { ?>
								<option value="<?php echo $p['policy_no'];?>" <?php echo  ($_GET['policy_no'] == $p['policy_no']) ? 'selected' : '';?>><?php echo $p['policy_no'];?></option>
								<?php } ?>
							</select>
							
						</div>

						<label style="color: #102958;" for="staticEmail" class="col-sm-2 label_left">Product:</label>                    
						<div class="col-sm-2">                		
							<select name="product" style="border-color:#102958;" id="product" class="form-control selectpicker" data-live-search="true">
								<option value="">Select Product</option>
								<?php foreach ($products as $p) { ?>
								<option value="<?php echo $p['id'];?>" <?php echo  ($_GET['product'] == $p['id']) ? 'selected' : '';?>><?php echo $p['product_name'];?></option>
								<?php } ?>
							</select> 
						</div>

                    </div>
					
					<div class="form-group row col-md-12 ">
						<label style="color: #102958;" for="staticEmail" class="col-sm-2 label_left">Currency Convertion:</label>                    
						<div class="col-sm-2">                		
							<input type='checkbox' id="convert" class="form-check-input" name="currency_conversion" id="currency_conversion" value="true"  <?php if($_GET['currency_conversion']=="true"){ echo 'checked="checked"'; }
                            //echo (isset($_GET['currency_conversion'])) ? 'checked="checked"' : '';?> /> 
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

                </form>
            </div>
            </div>

                        <div class="card-body">
                            <div class="table-responsive" style="font-size: 13px;">
                            <table id="example"  class="table table-bordered " width="100%"  >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name of Agent</th>
                                            <th>Product Name</th>
                                            <th>Policy No.</th>
                                            <th>Premium Amount</th>
                                            <?php if($_GET['currency_conversion']=="true"){ ?>
                                            <th class="text-center converted">Converted Value</th>
                                            <th class="text-center converted">Convert Unit</th>
                                            <?php } ?>
                                            <th>Paid Date</th>
                                            <th>Commission Paid</th>                                
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 13px;">
                                    <?php 
                                    if (count($agents_paid) > 0) {
                                    $ctr = 1;
                                    $total_premium_rate = 0;
									$total_commission = 0;
                                    $total_converted_value = 0;
                                    foreach ($agents_paid as $agent) {
                                        //print_r($agent['id_agent']);
                                    ?>
                                    
                                    <?php 
                                    $sales  = get_commission_report($conn, $data, $agent['id_agent']);
                                   // echo $agent['id_agent'];
                                   // print_r($sales);
                                    if (count($sales) > 0) {
                                    foreach ($sales as $s) {
                                        $s_date = $s['start_date'];
                                        $start_date = $s_date->format('d-m-Y');
                                        $e_date = $s['end_date'];
                                        $end_date = $e_date->format('d-m-Y');
                                        $p_date = $s['paid_date'];
                                        $paid_date = $p_date->format('d-m-Y');
                                         // echo $s['id_currency'];
                                        $agent_currency = get_conversion ($conn,$s['id_currency'], date('Y-m-d', strtotime($paid_date)));
                                        // echo count($agent_currency);
                                        $acurrency = (count($agent_currency)) ? $agent_currency[0] : array();
                                        //print_r($agent_currency);
                                        
                                        $converted_value = (isset($acurrency['currency_value_convert'])) ? floatval($s['premium_rate']) / floatval($acurrency['currency_value_convert']) : 0;
                                        //print_r($converted_value);
                                        //$converted_value = floatval($acurrency['currency_value_convert']);
                                        ?>
                                        <tr>
                                    		<td class="text-center"><?php echo $ctr;?></td>
                                            <td><?php echo $s['agent_name'];?></td>                                                                                           
                                            <td><?php echo $s['product_name'];?></td>
                                            <td><?php echo $s['policy_no'];?></td>
                                            <td class="text-right"><?php echo number_format( $s['premium_rate'], 2);?></td> 

                                            <?php if($_GET['currency_conversion']=="true"){ ?>
                                            <td class="converted text-right"><?php echo number_format($converted_value, 2);?></td>
                                            <td class="converted text-center"><?php echo (isset($acurrency['currency_value_convert'])) ? $acurrency['currency'] : '';?></td>
                                            <?php } ?>

                                            <td class="text-center"><?php echo $paid_date; ?></td>
                                            <td class="text-right">
												<?php echo number_format( $s['commission_rate'], 2);?>
											</td>                                                                                                     
                                        </tr>  
										<?php 
										$total_premium_rate += $s['premium_rate'];
										$total_converted_value += $converted_value;
										$total_commission += $s['commission_rate'];
										$ctr++; 
                                    } // foreach 
                                    } // if
                                    ?>
                                       <?php                                      
                                    } // foreach agents                                    
                                    } // if count agents
                                       ?>
									   </tbody>
									   <tfoot>
                                       <tr style="font-weight: bold;">                                            
                                            <th>TOTAL</th>
                                            <th></th>
											<th></th>
                                            <th></th>                                                   
                                            <th style="text-align: right !important;"><?php echo number_format($total_premium_rate, 2)?></th> 

                                            <?php if($_GET['currency_conversion']=="true"){ ?>
                                            <th class="converted" style="text-align: right !important;"><?php echo number_format($total_converted_value, 2)?></th>       
                                            <th class="converted"></td> 
                                            <?php } ?>

											<th></th> 
											<th style="text-align: right !important;"><?php echo number_format($total_commission, 2)?></th>                                                   
                                        </tr>  
                                      </tfoot>                                  
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

    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>

    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>

    <style>
		@media (min-width: 1340px){
			.label_left{
				max-width: 140px;
			}
			.label_right{
				max-width: 140px;
			}
		}
		
		.table th {
			vertical-align: middle !important;
			text-align: center !important;
		}
		/*.table thead th.sorting:after,
		.table thead th.sorting_asc:after,
		.table thead th.sorting_desc:after {
			top: 20px;
		}*/
		
		.caret {
			right: 10px !important;
		}
    </style> 

	<script>
		$(document).ready(function(){
			var table = $('#example').DataTable({
				"order": [], //Initial no order.
				"aaSorting": [], 
				"ordering": false,
				scrollX: true,
                "columnDefs": [{ 
                        "targets": [ ], //first column / numbering column
                        "orderable": false, //set not orderable
                    }] , 
				"scrollCollapse": true,
				"paging": true,
				"footerCallback": function ( data, row, start, end, display){
					var api = this.api();
					var numberRenderer = $.fn.dataTable.render.number( ',', '.', 2, ''  ).display;
					var textRenderer = $.fn.dataTable.render.text().display;
					var val_4 =  $(api.column(4).footer().innerHTML);             
					$(api.column(4)).addClass("text-right");
                    $( api.column(4).footer()).html(
                        textRenderer('\u200C' + val_4.selector)
                    );

					var val_6 =  $(api.column(6).footer().innerHTML);    
					//$( api.column(10)).addClass("cell-right-text");
					$(api.column(6)).addClass("text-right");
					$( api.column(6).footer()).html(
						textRenderer('\u200C' + val_6.selector)
					);
				} ,
				buttons: [
					{ extend: 'csv',class: 'buttons-csv',className: 'btn-primary',charset: 'UTF-8',filename: 'Report Sales Commission',footer: true,bom: true,init : function(api,node,config){ $(node).hide();} },
					{ extend: 'excel',class: 'buttons-excel', className: 'btn-primary',charset: 'UTF-8',filename: 'Report Sales Commission',footer: true,bom: true,init : function(api,node,config){ $(node).hide();},
					},
					{ extend: 'pdf',class: 'buttons-pdf',className: 'btn-primary',charset: 'UTF-8'
                    ,filename: 'Report Sales Commission',footer: true,bom: true
                    ,init : function(api,node,config){ $(node).hide();},
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
						}
					},
					{ extend: 'print',class: 'buttons-print',className: 'btn-primary',charset: 'UTF-8',footer: true,bom: true
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

			table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
		});
	</script>

    <?php include('includes/footer.php'); ?>
</body>

</html>

