<?php
session_start();
error_reporting(0);
include_once('includes/connect_sql.php');
include_once('includes/fx_reports.php');


if(strlen($_SESSION['alogin'])==""){   
    header("Location: index.php"); 
}
    $customers = get_customers ($conn);
    $products = get_products ($conn);
    $insurance_policy = get_policy_no($conn);
    $categories = get_product_category($conn);
    $subcategories = get_product_subcategory($conn);
    $data = array();
    $data['date_from'] = '';
    $data['date_to'] = '';
    $data['customer'] ='';
    $data['policy_no']='';
    $data['subcategory']='';
    $data['category']='';
    $data['partner']='';
    $data['status']='';
    
    //$sales =  get_sales_by_customer ($conn, $data);
    
    if (isset($_GET)) {       
        $data['date_from'] = ($_GET['date_from'] != '') ? date('Y-m-d', strtotime($_GET['date_from'])) : '';
        $data['date_to'] = ($_GET['date_to'] != '') ? date('Y-m-d', strtotime($_GET['date_to'])) : '';
        $data['customer'] =$_GET['customer'];
        $data['policy_no']=$_GET['policy_no'];
        $data['subcategory']=$_GET['subcategory'];
        $data['category']=$_GET['category'];
        $data['partner']=$_GET['partner'];
        $data['status']=$_GET['status'];
        //print_r($_GET);
        //$insurance_customer = get_customer_insurance ($conn);
        
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
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        /*new dataTable('#example', {
    layout: {
        topStart: {
            buttons: ['copy', 'excel', 'pdf', 'colvis']
        }
    }
        });*/
    </script>

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
                                        <li class="active" >Report: Sales By Product</li>
                                    </ul>
                                </div>
                            </div>
            </div>

    <div class="container-fluid">
        <div class="card shadow mb-4">
                        <div class="card-header">
                             <div class="panel-title" >
                                <h2 class="title m-5" style="color: #102958;">Report: Sales By Product
                            </div>  
                                                   
                        </div>
    <script>
  $(document).ready(function(){
    $('#date_from').datepicker({
      format: 'yyyy-mm-dd',
      language: 'en'
    });
    $('#date_to').datepicker({
      format: 'yyyy-mm-dd',
      language: 'en'
    });
  });
</script> 

        <div class="panel">
            <form method="get" >
                <br>
                    <div class="form-group row col-md-12 ">
                    
                        <label style="color: #102958;"  class="col-sm-2 label_left">From Date:</label>

                       <div class="col-sm-2">                                             
                        <input  style="color: #0C1830;border-color:#102958;" type="text" name="date_from" class="form-control" id="date_from" value="<?php echo ($_GET['date_from'] != '') ? date('Y-m-d', strtotime($_GET['date_from'])) : '';?>" placeholder="yyyy-mm-dd">
                        </div>

                         <label style="color: #102958;" for="staticEmail" class="col-sm-2 label_right">To Date:</label>
                        <div class="col-sm-2">
                        <input  style="color: #0C1830;border-color:#102958;" type="text" name="date_to" class="form-control" id="date_to" value="<?php echo  ($_GET['date_to'] != '') ? date('Y-m-d', strtotime($_GET['date_to'])) : '';?>" placeholder="yyyy-mm-dd" >
                        </div>
                    </div>
                    
                    <div class="form-group row col-md-12 ">
                    	<label style="color: #102958;" for="policy_no" class="col-sm-2 label_left">Policy no:</label>
                        <div class="col-sm-2">
                        	<select name="policy_no" style="border-color:#102958;" id="policy_no" onchange="" class="form-control">
                                <option value="">Select Policy</option>
                                <?php foreach ($insurance_policy as $p) { ?>
                                <option value="<?php echo $p['id'];?>" <?php echo  ($_GET['policy_no'] == $p['id']) ? 'selected' : '';?>><?php echo $p['policy_no'];?></option>
                                <?php } ?>
                            </select>
                    		
                        </div>
                        
                         <label style="color: #102958;" for="customer_name" class="col-sm-2 label_right">Customer name:</label>
                        <div class="col-sm-2">
                            <select name="customer" style="border-color:#102958;" id="customer" onchange="" class="form-control" >
                                <option value="">Select Customer</option>
                                <?php foreach ($customers as $c) { ?>
                                <option value="<?php echo $c['id'];?>" <?php echo  ($_GET['customer'] == $c['id']) ? 'selected' : '';?>><?php echo $c['customer_name'];?></option>
                                <?php } ?>
                            </select>                            
                        </div>
                        
                        
                        <label style="color: #102958;" for="partner" class="col-sm-2 label_left">Partners:</label>
                        <div class="col-sm-2">
                        	<select name="partner" style="border-color:#102958;" id="partner" onchange="" class="form-control">
                                <option value="">Select Policy</option>
                                <?php foreach ($partners as $p) { ?>
                                <option value="<?php echo $p['id'];?>" <?php echo  ($_GET['partner'] == $p['id']) ? 'selected' : '';?>><?php echo $p['insurance_company'];?></option>
                                <?php } ?>
                            </select>
                    		
                        </div>
                    </div>

                    
                    <div class="form-group row col-md-12 ">
                    	<label style="color: #102958;" for="category" class="col-sm-2 label_left">Product Category:</label>                    
                        <div class="col-sm-2">                		
                    		<select name="category" style="border-color:#102958;" id="category" onchange="" class="form-control">
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $p) { ?>
                                <option value="<?php echo $p['id'];?>" <?php echo  ($_GET['category'] == $p['id']) ? 'selected' : '';?>><?php echo $p['categorie'];?></option>
                                <?php } ?>
                            </select> 
                        </div>
                        
                        <label style="color: #102958;" for="product" class="col-sm-2 label_right">Subcategory:</label>                    
                        <div class="col-sm-2">                		
                    		<select name="subcategory" style="border-color:#102958;" id="subcategory" onchange="" class="form-control">
                                <option value="">Select Subcategory</option>
                                <?php foreach ($subcategories as $p) { ?>
                                <option value="<?php echo $p['id'];?>" <?php echo  ($_GET['subcategory'] == $p['id']) ? 'selected' : '';?>><?php echo $p['subcategorie'];?></option>
                                <?php } ?>
                            </select> 
                        </div>
                        
                        <label style="color: #102958;" for="status" class="col-sm-2 label_left">Status:</label>
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
                    
                    <div class="form-group row col-md-12 ">
                    	<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Currency Convertion:</label>                    
                        <div class="col-sm-2">                		
                    		<input type='checkbox' id="convert"  name="currency_conversion" value="" <?php echo (isset($_GET['currency_conversion'])) ? 'checked="checked"' : '';?> /> 
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
                            <div class="table-responsive">
                            <table id="example"  class="table table-bordered"   >
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center" width="200px" >Product</th>
                                            <th class="text-center" width="100px" >Policy No.</th>
                                            <th class="text-center" width="200px" >Customer Name</th>
                                            <th class="text-center" width="100px" >Start Date</th>
                                            <th class="text-center" width="100px" >End Date</th>
                                            <th class="text-center" width="150px" >Premium Amount</th>
                                            <?php if (isset($_GET['currency_conversion'])) { ?>
                                            <th class="text-center converted">Converted Value</th>
                                            <th class="text-center converted">Convert Unit</th>
                                            <?php }?>
                                            <th class="text-center">Insurance Company</th>
                                            <th class="text-center">Agent</th>
                                            <th class="text-center">Subagent</th>
                                            <th class="text-center">Phone</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Remark</th>                                      
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php 
                                    if (count($products) > 0) {
                                    $ctr = 1;
                                    $grand_total_converted_value = 0;
                                    $grand_total_primary_premium_rate = 0;
                                    $grand_total_subagent_premium_rate = 0;
                                    
                                    $prev_count = $ctr;
                                    foreach ($products as $prod) {
                                        $total_converted_value = 0;
                                        $total_primary_premium_rate = 0;
                                        $total_subagent_premium_rate = 0;
                                    ?>                                                                     
                                    
                                    
                                    <?php 
                                    $sales  = get_sales_by_product ($conn, $data, $prod['id']);
                                    
                                    
                                    if (count($sales) > 0) {
                                        //$sub_ctr = 1;
                                        
                                    foreach ($sales as $sub_ctr => $s) {
                                        $agent = get_agent_by_id($conn, $s['agent_id']);
                                        $agent_name = $agent[0]['title_name'].' '.$agent[0]['first_name'].' '.$agent[0]['last_name'];
                                        $partner = get_partner_by_id($conn, $s['partner_id']);
                                        $agent_type =  trim($agent[0]['agent_type']);
                                        $p = $partner[0];
                                        $s_date = $s['start_date'];
                                        $start_date = $s_date->format('d-m-Y');
                                        $e_date = $s['end_date'];
                                        $end_date = $e_date->format('d-m-Y');
                                        $agent_currency = get_conversion ($conn, $s['id_currency'], date('Y-m-d', strtotime($start_date)));
                                        $acurrency = $agent_currency[0];
                                        $converted_value = floatval($s['premium_rate']) / floatval($acurrency['currency_value_convert']);
                                        //$converted_value = floatval($acurrency['currency_value_convert']);
                                        ?>
                                        <tr>
                                    		<td class="text-center"><?php echo ($sub_ctr == 0) ? $ctr : '';?></td>
                                            <td><?php echo ($sub_ctr == 0) ? $prod['product_name'] : '';?></td>                                                  
                                            <td><?php echo $s['policy_no'];?></td>
                                            <td><?php echo $s['customer_name'];?></td>
                                            <td><?php echo $start_date;?></td> 
                                             <td><?php echo $end_date;?></td>
                                             <td><?php echo ($agent_type != 'Sub-agent') ? number_format( $s['premium_rate'], 2) : '';?></td> 
                                             <?php if (isset($_GET['currency_conversion'])) { ?>
                                            <td class="converted"><?php echo number_format($converted_value, 2);?></td>
                                            <td class="converted"><?php echo $acurrency['currency'];?></td>
                                            <?php }?>
                                            <td><?php echo $s['insurance_company'];?></td>
                                            <td><?php echo $agent_name;?></td>
                                             <td><?php echo ($agent_type == 'Sub-agent') ? number_format( $s['premium_rate'], 2) : '';?></td>
                                             <td><?php echo $s['mobile_phone'];?></td>
                                             <td><?php echo $s['email'];?></td>                                              
                                            <td><?php echo $p['remark'];?></td>                                                                                                     
                                        </tr>  
                                        <?php 
                                        $total_primary_premium_rate += ($agent_type != 'Sub-agent')  ? $s['premium_rate'] : 0;
                                        $total_subagent_premium_rate += ($agent_type == 'Sub-agent')  ? $s['premium_rate'] : 0;
                                        $total_converted_value += $converted_value;
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
                                             <?php if (isset($_GET['currency_conversion'])) { ?>
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
                                             <td ><?php echo number_format($total_primary_premium_rate, 2)?></td>     
                                             <?php if (isset($_GET['currency_conversion'])) { ?>
                                             <td class="converted"><?php echo number_format($total_converted_value, 2)?></td>       
                                             <td class="converted"></td> 
                                             <?php }?>
                                             <td></td> 
                                             <td></td>        
                                             <td ><?php echo number_format($total_subagent_premium_rate, 2)?></td>     
                                              <td></td>
                                              <td></td> 
                                              <td></td>                                                 
                                        </tr>                                          
                                    <?php     
                                    $grand_total_primary_premium_rate += $total_primary_premium_rate;
                                    $grand_total_subagent_premium_rate += $total_subagent_premium_rate;
                                    $grand_total_converted_value += $total_converted_valuee;
                                    $prev_count = $ctr;
                                    $ctr++;
                                    } // foreach ($products)
                                   
                                    } // if count($products)
                                       ?>
                                       
                                    </tbody>
                                    <tfoot>
                                    	<tr style="font-weight: bold;">                                            
                                             <th></th>
                                             <th>GRAND TOTAL</th>
                                            <th></th>
                                            <th></th>     
                                            <th></th>  
                                            <th></th>   
                                             <th ><?php echo number_format($grand_total_primary_premium_rate, 2)?></th>     
                                             <?php if (isset($_GET['currency_conversion'])) { ?>
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

   
</body>

</html>

