
<?php
session_start();
error_reporting(0);
include_once('includes/connect_sql.php');
include_once('includes/fx_reports-sales.php');

if(strlen($_SESSION['alogin'])=="") {
    header('Location: logout.php');
}


$contacts=null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)) {
        // $customers = get_customers_search($conn,$_POST);
        // $customers = get_customers_search_start($conn);

        $customer = $_POST['customer'];
        $status = $_POST['status'];

        $start_date = date('Y-m-d', strtotime($_POST['start_date']));
        $end_date = date('Y-m-d', strtotime($_POST['end_date']));

        $customers = get_customers_sales_search($conn,$_POST);
        $policy=$_POST['policy_no'];
        $customer=$_POST['customer'];
        $partner=$_POST['partner'];
        $pro_categorie=$_POST['product_cat'];
        $categorie=$_POST['sub_cat'];
        // $product=$_POST['product'];
        $status=$_POST['status'];
        $status_currency=$_POST['status_currency'];
    }
}else{
    $customers = get_customers_sales_start($conn);
    $start_date = date('Y-m-d');
    $end_date   = date('Y-m-d');
    $policy="all";
    $customer="all";
    $partner="all";
    $pro_categorie="all";
    $categorie="all";
    // $product="all";
    $status="all";
    $status_currency="true";
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

<form method="post" action="report-customer-sales-total.php" >
<div class="container-fluid">
            <div >
                <br>
                    <div class="form-group row col-md-12 ">
                        <label style="color: #102958;"  class="col-sm-2 label_left">From Date:</label>
                        <div class="col-sm-2">
                            <?php //echo ($_GET['date_from'] != '') ? date('Y-m-d', strtotime($_GET['date_from'])) : '';?>
                            <input  style="color: #0C1830;border-color:#102958;" type="date" name="start_date" class="form-control" id="start_date" value="<?php echo $start_date; ?>" placeholder="dd-mm-yyyy">
                        </div>

                        <label style="color: #102958;"  class="col-sm-2 label_right">End Date:</label>
                        <div class="col-sm-2">
                            <input  style="color: #0C1830;border-color:#102958;" type="date" name="end_date" class="form-control" id="end_date" value="<?php echo $end_date; ?>" >
                        </div>


                    </div>

                    <div class="form-group row col-md-12 ">
                        <label style="color: #102958;" class="col-md-2 label_left">Policy no:</label>
                        <div class="col-md-2">
                            <select id="policy_no" name="policy_no" value="<?php echo $policy; ?>" style="border-color:#102958;" class="form-control selectpicker" data-live-search="true" >
                                 <option value="all">All</option>
                                <?php foreach ($insurance_policy as $p) { ?>
                                <option value="<?php echo $p['id'];?>" <?php echo  ($policy == $p['id']) ? 'selected' : '';?>><?php echo $p['policy_no'];?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <label style="color: #102958;" class="col-md-2 label_right">Customer name:</label>
                        <div class="col-md-2">
                           
                            <select id="customer" name="customer" value="<?php echo $customer; ?>" style="border-color:#102958;" class="remove-example form-control selectpicker" data-live-search="true" value="<?php echo $customer; ?>" >
                                <option value="all">All</option>
                                <?php //echo $value['id']; ?>
                                <?php foreach ($customers_list as $value) { ?>
                                    <option value="<?php echo $value['id']; ?>" 
                                        <?php if ($value['id']==$customer) { echo 'selected="selected"'; } ?>
                                        ><?php echo trim($value['customer_name']); ?>
                                    </option>
                                <?php } ?>    
                            </select>                        
                        </div>
                        
                        
                        <label style="color: #102958;"  class="col-md-2 label_left">Partners:</label>
                        <div class="col-md-2">
                            <select  id="partner" name="partner" value="<?php echo $partner; ?>" style="border-color:#102958;" class="form-control selectpicker" data-live-search="true" >
                                 <option value="all">All</option>
                                <?php foreach ($partners as $p) { ?>
                                <option value="<?php echo $p['id'];?>" <?php echo  ($partner == $p['id']) ? 'selected' : '';?>><?php echo $p['insurance_company'];?></option>
                                <?php } ?>
                            </select>
                            
                        </div>
                    </div>

                    <div class="form-group row col-md-12 ">
                        
                        <label style="color: #102958;"  class="col-sm-2 label_left">Product Categories:</label>
                        <div class="col-sm-2">                     
                        <select id="product_cat" name="product_cat" value="<?php echo $pro_categorie; ?>" style="border-color:#102958;" onchange="" class="form-control">
                             <option value="all">All</option>
                            <?php foreach ($product_categorie as $p) { ?>
                            <option value="<?php echo $p['id'];?>" <?php echo  ($pro_categorie == $p['id']) ? 'selected' : '';?>><?php echo $p['categorie'];?></option>
                            <?php } ?>
                        </select> 
                        </div>

                         <label style="color: #102958;" for="staticEmail" class="col-sm-2 label_right">Sub Categories:</label>                    
                        <div class="col-sm-2">                      
                            <select id="sub_cat" name="sub_cat" style="border-color:#102958;" value="<?php echo $product; ?>" class="form-control">
                                 <option value="all">All</option>
                            <?php foreach ($subcategories as $p) { ?>
                            <option value="<?php echo $p['id'];?>" <?php echo  ($categorie== $p['id']) ? 'selected' : '';?>><?php echo $p['subcategorie'];?></option>
                            <?php } ?>
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
                        <select id="status" name="status" value="<?php echo $status; ?>" style="border-color:#102958;" class="form-control" >
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
                            <label style="color: #102958;" >Currency Convertion:</label>
                        </div>
                    <div class="col-sm-2 " >
                        <input id="status_currency" name="status_currency" class="form-check-input" value="true" type="checkbox" id="flexCheckDefault"  <?php if($status_currency=="true"){ echo "checked"; }?> >
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
                                <table class="table table-bordered" id="example"  >
                                    <thead>
                                        <tr>
                                            <!-- <th class="text-center" width="20px" hidden="true" >No run</th> -->
                                            <th class="text-center" width="20px" >No</th>
                                            <th class="text-center" width="200px">Customer name</th>
                                            <th class="text-center" width="200px">Contact person</th>
                                            <th class="text-center" width="180px">Position</th>
                                            <th class="text-center" width="200px">Email</th>

                                            <th class="text-center" width="250px">Mobile phone</th>
                                            <th class="text-center" width="250px">Policy No</th>
                                            <th class="text-center" width="250px">Product/Sub Categories</th>
                                            <!-- <th>Tel</th> -->
                                            <th class="text-center" width="110px">Start Date</th>
                                            <th class="text-center" width="110px">End Date</th>
                                            <th class="text-center" width="">Premium Rate(THB)</th>
                                            <?php if($status_currency=="true"){ ?>
                                            <th class="text-center" >Convert Value</th>
                                            <?php } ?>
                                            <th class="text-center">Status</th>
                                            <th class="text-center" width="350px" >Insurance company</th>
                                            <th class="text-center" width="200px">Contact insurance Company</th>
                                            <th class="text-center" width="200px">Underwriter department:-</th>
                                            <th class="text-center" width="150px">Email</th>
                                            <th class="text-center" width="150px">Phone</th>
                                            <th class="text-center" width="150px">Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 
										$ctr = 1; 
                                        $id_customer ="";
                                        $start="true";
                                        $premium_rate;
                                        $premium_rate_convert;
                                        $total_premium_rate=0;
                                        $total_premium_rate_convert=0;
										foreach ($customers as $value) {
										?>
                                        <?php if($id_customer!=$value['id']){  ?>
                                        <?php if($start=="false"){ ?>
                                        <tr>
                                            <!-- <td class="text-center" hidden="true" ><?php //echo $ctr; ?></td> -->
                                            <td class="text-center" ><?php echo $ctr; ?></td>
                                            <!-- colspan="8" -->
                                            <td ></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="font-weight: bold;" class="text-right" >Total</td>
                                            <td style="font-weight: bold;" class="text-right" ><?php echo number_format((float)$premium_rate, 2, '.', ','); ?></td>

                                            <?php if($status_currency=="true"){ ?>
                                            <td style="font-weight: bold;" class="text-right" ><?php echo number_format((float)$premium_rate_convert, 2, '.', ','); ?></td>
                                            <?php } ?>

                                            <td></td>
                                            <td></td>
                                            <td><?php echo "";?></td>
                                            <td><?php echo "";?></td>
                                            <td><?php echo "";?></td>
                                            <td><?php echo "";?></td>
                                            <td><?php echo "";?></td>
                                        </tr>
                                        <?php $ctr++; }else{ $start="false"; } ?>
                                        <?php $id_customer=$value['id']; $premium_rate=0; $premium_rate_convert=0;  ?>
										<tr>
                                            <!-- <td class="text-center" hidden="true" ><?php //echo $ctr; ?></td> -->
                                            <td class="text-center"><?php echo $ctr; ?></td>
                                            <!-- <td class="text-center"><?php //echo $value['id'];  echo $ctr; ?></td> -->
                                            <!-- <td><?php //echo $value['insurance_company'];?></td> -->
                                            <td><?php echo $value['first_name'].' '.$value['last_name'];?></td>
                                            <td><?php echo $value['first_name_con'].' '.$value['last_name_con'];?></td>
                                            <td><?php echo $value['position'];?></td>
                                            <td><?php echo $value['email'];?></td>
                                            <td><?php echo $value['mobile'];?></td>
                                            
                                            <td><?php echo $value['policy_no'];?></td>
                                            <td><?php echo $value['categorie']; if($value['subcategorie']!=""){ echo "/".$value['subcategorie'];} ?></td>
                                            
                                            <td class="text-center"><?php echo $value['in_start_date'];?></td>
                                            <td class="text-center"><?php echo $value['in_end_date'];?></td>
                                            <td class="text-right"><?php if($value['premium_rate']!=""){ echo $value['premium_rate']; }else{ echo "0.00"; } 
                                            $premium_rate=$premium_rate+$value['premium_rate'];
                                            $total_premium_rate+=$value['premium_rate']; ?></td>

                                            <?php if($status_currency=="true"){ ?>
                                            <td class="text-right"><?php if($value['premium_rate']!=""){ 
                                            $convert = number_format((float)($value['premium_rate']/$value['currency_value']), 2, '.', ',');
                                            $premium_rate_convert =$premium_rate_convert+$convert;
                                            $total_premium_rate_convert+=$convert;
                                                echo $convert; 
                                                }else{ echo "0.00"; }; 
                                                if($value['currency']!=""){ echo "(".$value['currency'].")"; } ?></td>
                                            <?php } ?>

                                            <td class="text-center" ><?php echo $value['in_status'];?></td>
                                            <td><?php echo $value['insurance_company'];?></td>
                                            <td><?php echo $value['first_name_p']." ".$value['last_name_p'];?></td>
                                            <td><?php echo $value['email_p'];?></td>
                                            <td><?php echo $value['mobile_p'];?></td>
                                            <td><?php echo $value['remark_p'];?></td>
                                            <td><?php echo $value['department_p'];?></td>
										</tr>
                                        <? }else{ ?>
                                        <tr>
                                            <!-- <td class="text-center" hidden="true" ><?php //echo $ctr; ?></td> -->
                                            <td class="text-center" ><?php echo $ctr; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            
                                            <td><?php echo $value['policy_no'];?></td>
                                            <td><?php echo $value['categorie']; if($value['subcategorie']!=""){ echo "/".$value['subcategorie'];} ?></td>
                                            <td class="text-center"><?php echo $value['in_start_date'];?></td>
                                            <td class="text-center"><?php echo $value['in_end_date'];?></td>
                                            <td class="text-right"><?php if($value['premium_rate']!=""){ echo $value['premium_rate']; }else{ echo "0.00"; }
                                            $premium_rate=$premium_rate+$value['premium_rate']; 
                                            $total_premium_rate+=$value['premium_rate']; ?></td>

                                            <?php if($status_currency=="true"){ ?>
                                            <td class="text-right"><?php if($value['premium_rate']!=""){ 
                                            $convert = number_format((float)($value['premium_rate']/$value['currency_value']), 2, '.', ',');
                                            $premium_rate_convert =$premium_rate_convert+$convert;
                                            $total_premium_rate_convert+=$convert;
                                                echo $convert; 
                                            }else{ echo "0.00"; }; 
                                            if($value['currency']!=""){ echo "(".$value['currency'].")"; } ?></td>
                                            <?php } ?>

                                            <td class="text-center" ><?php echo $value['in_status'];?></td>
                                            <td><?php echo $value['insurance_company'];?></td>
                                            <td><?php echo $value['first_name_p']." ".$value['last_name_p'];?></td>
                                            <td><?php echo $value['email_p'];?></td>
                                            <td><?php echo $value['mobile_p'];?></td>
                                            <td><?php echo $value['remark_p'];?></td>
                                            <td><?php echo $value['department_p'];?></td>
                                        </tr>

                                        <?php } ?>
										<?php $ctr++; } ?>  

                                        <!-- end value -->
                                        <?php if(count($customers) > 0){  ?>
                                        <tr>
                                            <!-- <td class="text-center" hidden="true" ><?php //echo $ctr; ?></td> -->
                                            <td class="text-center" ><?php echo $ctr; ?></td>
                                            <!-- colspan="8" -->
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="font-weight: bold;" class="text-right" >Total</td>
                                            <td style="font-weight: bold;" class="text-right" ><?php echo $premium_rate;?></td>
                                            <?php if($status_currency=="true"){ ?>
                                            <td style="font-weight: bold;" class="text-right" ><?php echo $premium_rate_convert;?></td>
                                            <?php } ?>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo "";?></td>
                                            <td><?php echo "";?></td>
                                            <td><?php echo "";?></td>
                                            <td><?php echo "";?></td>
                                            <td><?php echo "";?></td>
                                        </tr>
                                        <tr>
                                            <!-- <td class="text-center" hidden="true" ><?php //echo $ctr; ?></td> -->
                                            <td class="text-center" ><?php echo $ctr; ?></td>
                                            <!-- colspan="8" -->
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="font-weight: bold;" class="text-right" >Total All</td>
                                        <td style="font-weight: bold;" class="text-right" ><?php echo number_format((float)$total_premium_rate, 2, '.', ','); ?></td>

                                        <?php if($status_currency=="true"){ ?>
                                        <td style="font-weight: bold;" class="text-right" ><?php echo number_format((float)$total_premium_rate_convert, 2, '.', ','); ?></td>
                                        <?php } ?>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo "";?></td>
                                            <td><?php echo "";?></td>
                                            <td><?php echo "";?></td>
                                            <td><?php echo "";?></td>
                                            <td><?php echo "";?></td>
                                        </tr>
                                        <?php }  ?>
                                        <!-- end value -->

                                    </tbody>
                                </table>
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
    <!--<script src="assets/js/custom.js"></script>-->

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
                //$('#example').DataTable();
				$('#example').DataTable({
               		"order": [], //Initial no order.
         			"aaSorting": [],
         			//Set column definition initialisation properties.
                    "columnDefs": [
                    { 
                        "targets": [ ], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
               });

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

