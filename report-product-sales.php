<?php
session_start();
error_reporting(0);
include_once('includes/connect_sql.php');
// include_once('includes/fx_reports.php');
include_once('includes/fx_reports-sales-product.php');

if(strlen($_SESSION['alogin'])==""){   
    header("Location: index.php"); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)) {
        $sales  = get_sales_by_product_search($conn,$_POST);
        $data['date_from']  =($_POST['date_from'] != '') ? date('Y-m-d', strtotime($_POST['date_from'])) : '';
        $data['date_to']    =($_POST['date_to'] != '') ? date('Y-m-d', strtotime($_POST['date_to'])) : '';
        $data['customer']   =$_POST['customer'];
        $data['policy_no']  =$_POST['policy_no'];
        $data['subcategory']=$_POST['subcategory'];
        $data['category']   =$_POST['category'];
        $data['partner']    =$_POST['partner'];
        $data['status']     =$_POST['status'];
    }
}else{
    $sales  = get_sales_by_product_start ($conn);
    $data = array();
    $data['date_from'] = '';
    $data['date_to'] = '';
    $data['customer'] ='';
    $data['policy_no']='';
    $data['subcategory']='';
    $data['category']='';
    $data['partner']='';
    $data['status']='';
    
    // $_POST['currency_conversion']= "true";
    $_POST['currency_conversion'] = "false";
    // echo '<script>alert("currency_conversion: '.$_POST['currency_conversion'].'")</script>';
}

    $customers = get_customers ($conn);
    // $products = get_products ($conn);
    $insurance_policy = get_policy_no($conn);
    $categories = get_product_category($conn);
    $subcategories = get_product_subcategory($conn);
    $partners = get_partners($conn);
    
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
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

</head>

<body id="page-top" >

    <!-- Page Wrapper -->
    <div id="wrapper" >
        <?php include('includes/leftbar2.php');?>   
        <?php include('includes/topbar2.php');?>  

            <div class="container-fluid  mb-4">
                            <div class="row breadcrumb-div" style="background-color:#ffffff">
                                <div class="col-md-6" >
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <!-- <li> Classes</li> -->
                                        <li class="active" >Report: Sales By Products</li>
                                    </ul>
                                </div>
                            </div>
            </div>

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="panel-title" >
                    <h2 class="title m-5" style="color: #102958;">Report: Sales By Products
                 </div>
            </div>

        <div class="panel">
            <form method="post" >
                <br>
                    <div class="form-group row col-md-12 ">
                    
                        <label style="color: #102958;"  class="col-sm-2 label_left">From Date:</label>

                       <div class="col-sm-2">                                             
                        <input  style="color: #0C1830;border-color:#102958;" type="text" name="date_from" class="form-control" id="date_from" value="<?php echo ($_POST['date_from'] != '') ? date('d-m-Y', strtotime($_POST['date_from'])) : '';?>" placeholder="dd-mm-yyyy">
                        </div>

                         <label style="color: #102958;" for="staticEmail" class="col-sm-2 label_right">To Date:</label>
                        <div class="col-sm-2">
                        <input  style="color: #0C1830;border-color:#102958;" type="text" name="date_to" class="form-control" id="date_to" value="<?php echo  ($_POST['date_to'] != '') ? date('d-m-Y', strtotime($_POST['date_to'])) : '';?>" placeholder="dd-mm-yyyy" >
                        </div>
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
        
                    <div class="form-group row col-md-12 ">
                    	<label style="color: #102958;" for="policy_no" class="col-sm-2 label_left">Policy no:</label>
                        <div class="col-sm-2">
                        	<select name="policy_no" style="border-color:#102958;" id="policy_no" class="form-control selectpicker" data-live-search="true" >
                                <option value="all">Select Policy</option>
                                <?php foreach ($insurance_policy as $p) { ?>
                                <option value="<?php echo $p['policy_no'];?>" <?php echo  ($_POST['policy_no'] == $p['policy_no']) ? 'selected' : '';?>><?php echo $p['policy_no'];?></option>
                                <?php } ?>
                            </select>
                    		
                        </div>

                        <label style="color: #102958;" for="partner" class="col-sm-2 label_left">Partners:</label>
                        <div class="col-sm-2">
                            <select name="partner" style="border-color:#102958;" id="partner" class="form-control selectpicker" data-live-search="true">
                                <option value="all">Select Policy</option>
                                <?php foreach ($partners as $p) { ?>
                                <option value="<?php echo $p['id'];?>" <?php echo  ($_POST['partner'] == $p['id']) ? 'selected' : '';?>><?php echo $p['insurance_company'];?></option>
                                <?php } ?>
                            </select>
                            
                        </div>
                        
                        <label style="color: #102958;" for="customer_name" class="col-sm-2 label_right">Customer name:</label>
                        <div class="col-sm-2">
                            <select name="customer" style="border-color:#102958;" id="customer" class="form-control selectpicker" data-live-search="true">
                                <option value="all">Select Customer</option>
                                <?php foreach ($customers as $c) { ?>
                                <option value="<?php echo $c['id'];?>" <?php echo  ($_POST['customer'] == $c['id']) ? 'selected' : '';?>><?php echo $c['customer_name'];?></option>
                                <?php } ?>
                            </select>                            
                        </div>
                        
                    </div>

                    
                    <div class="form-group row col-md-12 ">
                    	<label style="color: #102958;" for="category" class="col-sm-2 label_left">Product Category:</label>                    
                        <div class="col-sm-2">                		
                    		<select name="category" style="border-color:#102958;" id="category"class="form-control selectpicker" data-live-search="true">
                                <option value="all" >Select Category</option>
                                <?php foreach ($categories as $p) { ?>
                                <option value="<?php echo $p['id'];?>" <?php echo  ($_POST['category'] == $p['id']) ? 'selected' : '';?>><?php echo $p['categorie'];?></option>
                                <?php } ?>
                            </select> 
                        </div>
                        
                        <label style="color: #102958;" for="product" class="col-sm-2 label_right">Subcategory:</label>                    
                        <div class="col-sm-2">                		
                    		<select name="subcategory" style="border-color:#102958;" id="subcategory" class="form-control selectpicker" data-live-search="true">
                                <option value="all" >Select Subcategory</option>
                                <?php foreach ($subcategories as $p) { ?>
                                <option value="<?php echo $p['id'];?>" <?php echo  ($_POST['subcategory'] == $p['id']) ? 'selected' : '';?> ><?php echo $p['subcategorie'];?></option>
                                <?php } ?>
                            </select> 
                        </div>
                        
                        <label style="color: #102958;" for="status" class="col-sm-2 label_left">Status:</label>
                        <div class="col-sm-2">   
                         <select id="status_i_input" name="status" onchange="" style="border-color:#102958;" class="form-control" >
                            <option value="all" <?php echo  ($_POST['status'] == "all") ? 'selected' : '';?> >Select status</option>
                            <option value="New" <?php echo  ($_POST['status'] == "New") ? 'selected' : '';?>>New</option>
                            <option value="Follow up" <?php echo  ($_POST['status'] == "Follow up") ? 'selected' : '';?>>Follow up</option>
                            <option value="Renew" <?php echo  ($_POST['status'] == "Renew") ? 'selected' : '';?>>Renew</option>
                            <option value="Wait" <?php echo  ($_POST['status'] == "Wait") ? 'selected' : '';?>>Wait</option>
                            <option value="Not renew" <?php echo  ($_POST['status'] == "Not renew") ? 'selected' : '';?>>Not renew</option>
                        </select>
                        </div>                    
                    </div>
                    
                    <div class="form-group row col-md-12 ">
                    	<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Currency Convertion:</label>                    
                        <div class="col-sm-2">                		
                    		<input type='checkbox' id="convert"  name="currency_conversion" value="true" <?php 
                            if($_POST['currency_conversion']=="true"){ echo 'checked="checked"'; }
                            //echo (isset($_POST['currency_conversion'])) ? 'checked="checked"' : '';?> /> 
                        </div>                    
                    </div>
                    
					<div class="row pull-right">
						
							<button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-primary">Search</button>
							&nbsp;&nbsp;
                                <div class="dropdown">
                                      <button style="background-color: #0275d8;color: #F9FAFA;" class="btn btn-primary mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Export

                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
                                        <a class="dropdown-item" id="btnCsv" style="font-size: 15px;" >CSV</a>
                                        <a class="dropdown-item" id="btnExcel" style="font-size: 15px;" >Excel</a>
                                        <a class="dropdown-item" id="btnPdf" style="font-size: 15px;" >PDF</a>
                                        <a class="dropdown-item" id="btnPrint" style="font-size: 15px;" >Print</a>
                                      </div>
                                </div>&nbsp;&nbsp;&nbsp;
                    </div>

                </form>
            </div>
						
                    <div class="card-body">
                            <div class="table-responsive" style="font-size: 13px;">
                            <table id="example"  class="table table-bordered"   >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th width="250px">Product</th>
                                            <th width="100px">Policy No.</th>
                                            <th width="200px">Customer Name</th>
                                            <th width="90px">Start Date</th>
                                            <th width="90px">End Date</th>
                                            <th width="100px">Premium Amount</th>
                                            <?php if($_POST['currency_conversion']=="true"){ ?>
                                            <th class="converted" width="100px">Converted Value</th>
                                            <th class="converted" width="100px">Convert Unit</th>
                                            <?php }?>
                                            <th width="300px">Partner Company</th>
                                            <th width="200px">Agent</th>
                                            <th width="100px">Subagent</th>
                                            <th width="110px">Mobile</th>
                                            <th width="200px">Email</th>
                                            <th width="150px">Remark</th>                                      
                                        </tr>
                                    </thead>

                                    <?php if (count($sales) > 0) {   ?>
                                    <tbody style="font-size: 13px;">
                                    <?php 

                                    $ctr = 1;
                                    $grand_total_converted_value = 0;
                                    $grand_total_primary_premium_rate = 0;
                                    $grand_total_subagent_premium_rate = 0;
                                    
                                    $prev_count = $ctr;
                                        $total_converted_value = 0;
                                        $total_primary_premium_rate = 0;
                                        $total_subagent_premium_rate = 0;

                                        $premium_rate_convert =0;
                                        $total_premium_rate_convert=0;
                                    ?>                                                                     
                                    <?php 
                                    
                                    if (count($sales) > 0) {
                                        //$sub_ctr = 1;
                                        $start="true";
                                        $start_product="true";
                                        $id_product ="";
                                    foreach ($sales as $sub_ctr => $s) {
                                        ?>
                                        <?php if($id_product!=$s['product_name']){ ?>
                                        <?php if($start=="false"){  ?>
                                            <tr style="font-weight: bold;">                                            
                                             <td></td>
                                             <td>TOTAL</td>
                                            <td></td>
                                            <td></td>     
                                            <td></td>  
                                            <td></td>   
                                             <td class="converted text-right"><?php echo number_format($total_primary_premium_rate, 2)?></td>     
                                             <?php if($_POST['currency_conversion']=="true"){ ?>
                                             <td class="converted text-right"><?php echo number_format($total_converted_value, 2)?></td>       
                                             <td ></td> 
                                             <?php }?>
                                             <td></td> 
                                             <td></td>        
                                             <td class="text-right"><?php echo number_format($total_subagent_premium_rate, 2)?></td>     
                                              <td></td>
                                              <td></td> 
                                              <td></td>                                                 
                                            </tr> 

                                        <?php 
                                            $grand_total_primary_premium_rate += $total_primary_premium_rate;
                                            $grand_total_subagent_premium_rate += $total_subagent_premium_rate;
                                            $grand_total_converted_value += $total_converted_value;
                                            $total_primary_premium_rate=0;
                                            $total_subagent_premium_rate=0;
                                            $total_converted_value=0;
                                         }else{ $start="false"; $id_product=$s['product_name'];  } ?>
                                        <?php }    ?>
                                        <tr>

                                        <?php if($start_product=="true"){ $start_product="false"; ?>
                                                <td class="text-center"><?php echo $ctr; $ctr++; ?></td>
                                             <td><?php echo $s['product_name'];  ?></td> 
                                        <?php }else{ ?> 
                                        <?php if($id_product!=$s['product_name']){ ?>   
                                            <td><?php echo $ctr; $ctr++; ?></td>
                                            <td><?php echo $s['product_name']; ?></td> 
                                        <?php }else{ ?>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php }//else start product ?> 
                                            <td><?php echo $s['policy_no']; ?></td>
                                            <td><?php echo $s['customer_name']; ?></td>
                                            <td class="text-center"><?php echo $s['in_start_date']; ?></td> 
                                            <td class="text-center"><?php echo $s['in_end_date']; ?></td>
                                            <td class="text-right"><?php echo ($s['agent_type']!= 'Sub-agent') ? number_format( $s['premium_rate'], 2) : '';?></td> 
                                             <?php if($_POST['currency_conversion']=="true"){ ?>
                                        
                                            <td class="converted text-right"><?php if($s['premium_rate']!=""){ 
                                            $convert_f = number_format((float)($s['premium_rate']/$s['currency_value_convert']), 2, '.', ',');
                                            $premium_rate_convert =$premium_rate_convert+((float)str_replace(',', '', $convert_f));
                                            // $total_premium_rate_convert+=$convert_f;
                                                echo $convert_f; 
                                                }else{ echo "0.00"; }; 
                                             ?></td>
                                            <td class="converted text-center"><?php echo $s['currency'];?></td>
                                            <?php }?>
                                            <td><?php echo $s['insurance_company'];?></td>
                                            <td><?php echo $s['agent_name']; ?></td>
                                            <td class="text-right"><?php echo ($s['agent_type']=='Sub-agent') ? number_format( $s['premium_rate'], 2) : '';?></td>
                                             <td><?php echo $s['mobile_co'];?></td>
                                             <td><?php echo $s['email_co'];?></td>                                              
                                            <td><?php echo $s['remark_co'];?></td>                                                                                                     
                                        </tr> 

                                        <?php $id_product=$s['product_name'];
                                        $total_primary_premium_rate += ($s['agent_type'] != 'Sub-agent')  ? $s['premium_rate'] : 0;
                                        $total_subagent_premium_rate += ($s['agent_type'] == 'Sub-agent')  ? $s['premium_rate'] : 0;
                                        $total_converted_value += ((float)str_replace(',', '', $convert_f));
                                        ?>
                                        
										<?php 
                                    } // foreach sales
                                    
                                    } // if count(sales)
                                    else {
                                    ?>
                                    <tr>
                                    		<td class="text-center"><?php echo $ctr;?></td>
                                            <td><?php echo $prod['product_name'];?></td>                                                  
                                            <td></td>
                                            <td></td>
                                            <td></td> 
                                             <td></td>
                                             <td></td> 
                                             <?php if($_POST['currency_conversion']=="true"){ ?>
                                            <td class="converted"></td>
                                            <td class="converted"></td>
                                            <?php }?>
                                            <td></td>
                                            <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>                                              
                                            <td></td>                                                                                                     
                                        </tr>  
                                    <?php }?>                                    
                                        <tr style="font-weight: bold;">                                            
                                             <td></td>
                                             <td>TOTAL</td>
                                            <td></td>
                                            <td></td>     
                                            <td></td>  
                                            <td></td>   
                                             <td class="text-right"><?php echo number_format($total_primary_premium_rate, 2)?></td>     
                                             <?php if($_POST['currency_conversion']=="true"){ ?>
                                             <td class="converted text-right"><?php echo number_format($total_converted_value, 2)?></td>       
                                             <td class="converted"></td> 
                                             <?php }?>
                                             <td></td> 
                                             <td></td>        
                                             <td class="text-right"><?php echo number_format($total_subagent_premium_rate, 2)?></td>     
                                              <td></td>
                                              <td></td> 
                                              <td></td>                                                 
                                        </tr>                                          
                                    <?php     
                                    $grand_total_primary_premium_rate += $total_primary_premium_rate;
                                    $grand_total_subagent_premium_rate += $total_subagent_premium_rate;
                                    $grand_total_converted_value += $total_converted_value;
                                    $prev_count = $ctr;
                                    $ctr++;

                                       ?>
                                       
                                    </tbody>
                                    <tfoot>
                                    	<tr style="font-weight: bold;">                                            
                                            <th></th>
                                            <th >GRAND TOTAL</th>
                                            <th></th>
                                            <th></th>     
                                            <th></th>  
                                            <th></th>   
                                            <th ><?php echo number_format($grand_total_primary_premium_rate, 2)?></th>     
                                            <?php if($_POST['currency_conversion']=="true"){ ?>
                                            <th class="converted"><?php echo number_format($grand_total_converted_value, 2)?></th>       
                                            <th class="converted"></th> 
                                            <?php }?>
                                            <th></th> 
                                            <th></th>        
                                            <th><?php echo number_format($grand_total_subagent_premium_rate, 2)?></th>     
                                            <th></th>
                                            <th></th> 
                                            <th></th>                                                 
                                        </tr>                   
                                    </tfoot>
                                <?php }//check value data sale ?>
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
    <!-- <script src="assets/js/custom3.js"></script> -->
        
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
        "columnDefs": [{ 
                        "targets": [ ], //first column / numbering column
                        "orderable": false, //set not orderable
                    }] ,     
        scrollX: true,
        "scrollCollapse": true,
        "paging":         true,
        "footerCallback": function(data, row, start, end, display) {
                var api = this.api();
                var numberRenderer = $.fn.dataTable.render.number(',', '.', 2, '').display;
                var textRenderer = $.fn.dataTable.render.text().display;
                var val_6 = $(api.column(6).footer().innerHTML);    
                $(api.column(6)).addClass("cell-right-text");
                // $(api.column(6).footer()).addClass('cell-right-text');
                $(api.column(6).footer()).html(
                    textRenderer('\u200C' + val_6.selector)
                );

                var val_10 = $(api.column(10).footer().innerHTML);    
                $(api.column(10)).addClass("cell-right-text");
                // $(api.column(10).footer()).addClass('cell-right-text');
                $(api.column(10).footer()).html(
                    textRenderer('\u200C' + val_10.selector)
                );
                api.columns().footer().to$().addClass('text-right');
            },
        buttons: [
            { extend: 'csv',class: 'buttons-csv',className: 'btn-primary',charset: 'UTF-8',filename: 'Report: Sales By Product',footer: true,bom: true
            ,init : function(api,node,config){ $(node).hide();} },
            { extend: 'excel',class: 'buttons-excel', className: 'btn-primary',charset: 'UTF-8',filename: 'Report: Sales By Product',footer: true,bom: true 
            ,init : function(api,node,config){ $(node).hide();} },
            { extend: 'pdf',class: 'buttons-pdf',className: 'btn-primary',charset: 'UTF-8',filename: 'Report: Sales By Product',footer: true,bom: true 
            ,orientation: 'landscape',init : function(api,node,config){ $(node).hide();},
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
			}			},
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


    table.buttons().container()
    .appendTo('#example_wrapper .col-md-6:eq(0)');

    });
    </script>

    <?php include('includes/footer.php'); ?>
</body>

</html>

