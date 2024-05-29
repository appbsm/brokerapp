<?php
	include('includes/config.php');
    include('includes/fx_payment_db.php');
    
	if(strlen($_SESSION['alogin'])==""){   
        $dbh = null;
		header("Location: index.php"); 
	}else{

    }

    $status_view ='0';
    $status_add ='0';
    $status_edit ='0';
    $status_delete ='0';
    foreach ($_SESSION["application_page_status"] as $page_id) {
        if($page_id["page_id"]=="29"){
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


    if(isset($_POST['submit'])){
        $results = get_payment_search($dbh,$_POST);
    }else{
        $results = get_payment_start($dbh);
    }
    
    // echo '<script>alert("results: '.count($results).'")</script>'; 

    $customers_list = get_customers_list($dbh);
    // $products = get_products($dbh);

    $insurance_policy = get_policy_no($dbh);
    $partners = get_partners($dbh);
    $product_categorie = get_product_categories($dbh);
    $subcategories = get_product_subcategory($dbh);


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

      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/css/bootstrap-datetimepicker.min.css">

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
                        <li class="active" >Payment received</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid">
                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <div class="panel-title" style="display: inline-block;" >
                             <h2 class="title m-5" style="color: #102958;">Report: Payment received</h2>
                        </div>
                    </div>   

                    <!-- ///////////////////////////////////////////////////////// -->

<script>
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
                        /*AA add */

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
    /*.table thead th.sorting:after,
    .table thead th.sorting_asc:after,
    .table thead th.sorting_desc:after {
        top: 20px;
    }*/
    
    .caret {
        right: 10px !important;
    }
    
    .btn-group>.btn:first-child {
        border-color: #102958;
    }

    .text-right {
        text-align: right !important;
    }
</style>


<form method="post" action="report-payment_received.php" >
    <div class="container-fluid">
            <div >
                <br>
                    <div class="form-group row col-md-12 ">
                        <label style="color: #102958;"  class="col-sm-2 label_left">From Date:</label>
                        <div class="col-sm-2">
                            <?php //echo ($_GET['date_from'] != '') ? date('Y-m-d', strtotime($_GET['date_from'])) : '';?>
                            <input  style="color: #000;border-color:#102958; text-align: center;" type="test" name="start_date" class="form-control" id="start_date" value="<?php 
                                if($_POST['start_date'] != ''){
                                    echo date('d-m-Y', strtotime($_POST['start_date']));
                                }
                            //echo ($_POST['start_date'] != '') ? date('d-m-Y', strtotime($_POST['start_date'])) : '';?>" placeholder="dd-mm-yyyy">
                        </div>

                        <label style="color: #102958;"  class="col-sm-2 label_right">End Date:</label>
                        <div class="col-sm-2">
                            <input  style="color: #000;border-color:#102958; text-align: center;" type="test" name="end_date" class="form-control" id="end_date" value="<?php echo ($_POST['end_date'] != '') ? date('d-m-Y', strtotime($_POST['end_date'])) : '';?>" placeholder="dd-mm-yyyy">
                        </div>


                    </div>
                    
<script>
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
                        /*AA add */

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
                            <select id="policy_no" name="policy_no" value="<?php echo $_POST['policy_no']; ?>" style="border-color:#102958; color: #000;" class="form-control selectpicker" data-live-search="true" >
                                 <option value="all">All</option>
                                <?php foreach ($insurance_policy as $p) { ?>
                                <option value="<?php echo $p->policy_no;?>" <?php echo  ($_POST['policy_no'] == $p->policy_no) ? 'selected' : '';?>><?php echo $p->policy_no;?></option>
                                <?php } ?>
                            </select>
                        </div>

                         <label style="color: #102958;"  class="col-md-2 label_left">Partners:</label>
                        <div class="col-md-2">
                            <select  id="partner" name="partner" value="<?php echo $_POST['partner']; ?>" style="border-color:#102958; color: #000;" class="form-control selectpicker" data-live-search="true" >
                                 <option value="all">All</option>
                                <?php foreach ($partners as $p) { ?>
                                <option value="<?php echo $p->id;?>" <?php echo  ($_POST['partner'] == $p->id) ? 'selected' : '';?>><?php echo $p->insurance_company;?></option>
                                <?php } ?>
                            </select>
                            
                        </div>

                        <label style="color: #102958;" class="col-md-2 label_right">Cust. name:</label>
                        <div class="col-md-2">
                           
                            <select id="customer" name="customer" value="<?php echo $_POST['customer']; ?>" style="border-color:#102958; color: #000;" class="remove-example form-control selectpicker" data-live-search="true" value="<?php echo $customer; ?>" >
                                <option value="all">All</option>
                                <?php //echo $value['id']; ?>
                                <?php foreach ($customers_list as $value) { ?>
                                    <option value="<?php echo $value->id; ?>" 
                                        <?php if ($value->id==$_POST['customer']) { echo 'selected="selected"'; } ?>
                                        ><?php echo trim($value->customer_name); ?>
                                    </option>
                                <?php } ?>    
                            </select>                        
                        </div>
                        
                    </div>

                    <div class="form-group row col-md-12 ">
                        
                        <label style="color: #102958;"  class="col-sm-2 label_left">Prod. Categories:</label>
                        <div class="col-sm-2">                     
                        <select id="product_cat" name="product_cat" value="<?php echo $_POST['product_cat']; ?>" style="border-color:#102958; color: #000;" onchange="" class="form-control selectpicker" data-live-search="true" >
                             <option value="all">All</option>
                            <?php foreach ($product_categorie as $p) { ?>
                            <option value="<?php echo $p->id;?>" <?php echo  ($_POST['product_cat'] == $p->id) ? 'selected' : '';?>><?php echo $p->categorie;?></option>
                            <?php } ?>
                        </select> 
                        </div>

                         <label style="color: #102958;" for="staticEmail" class="col-sm-2 label_right">Sub Categories:</label>                    
                        <div class="col-sm-2">                      
                            <select id="sub_cat" name="sub_cat" style="border-color:#102958; color: #000;" value="<?php echo $_POST['sub_cat']; ?>" class="form-control selectpicker" data-live-search="true" >
                                 <option value="all">All</option>
                            <?php foreach ($subcategories as $p) { ?>
                            <option value="<?php echo $p->id;?>" <?php echo  ($_POST['sub_cat']== $p->id) ? 'selected' : '';?>><?php echo $p->subcategorie;?></option>
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
                        <select id="status" name="status" value="<?php echo $_POST['status']; ?>" style="border-color:#102958; color: #000;" class="form-control" >
                            <option value="all">All</option>
                    <option value="New"  <?php if ("New"==$_POST['status']) { echo 'selected="selected"'; } ?> >New</option>
                    <option value="Follow up" <?php if ("Follow up"==$_POST['status']) { echo 'selected="selected"'; } ?> >Follow up</option>
                    <option value="Renew" <?php if ("Renew"==$_POST['status']) { echo 'selected="selected"'; } ?> >Renew</option>
                    <option value="Wait" <?php if ("Wait"==$_POST['status']) { echo 'selected="selected"'; } ?> >Wait</option>
                    <option value="Not renew" <?php if ("Not renew"==$_POST['status']) { echo 'selected="selected"'; } ?> >Not renew</option>
                        </select>
                        </div>

                    </div>

               <!--  <div class="form-group row col-md-12 ">

                    <div class="col-sm-2 label_left" >
                        <label style="color: #102958;" >Currency Convertion:</label>
                    </div>
                    <div class="col-sm-2 " >
                        <input id="status_currency" name="status_currency" class="form-check-input" value="true" type="checkbox" id="flexCheckDefault"  <?php if($status_currency=="true"){ echo "checked"; } ?> >
                        <label style="color: #000;" class="form-check-label" for="flexCheckDefault">
                    </div>

                </div> -->

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



<!-- ///////////////////////////////////////////////////////////// -->

                  

                        <div class="card-body" >
                            <div class="table-responsive" style="font-size: 13px;">
                                <!-- width="2000px"  -->
                                <!-- style="width:300%;" table-striped width="2500px-->
                                <table id="example"  class="table table-bordered "  style="color: #969FA7;font-size: 13px;"  >
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

                                            <th width="70px" style="color: #102958;" data-field="date" data-sortable="true" data-sorter="dateSorter">Start Date</th>
                                            <th width="70px" style="color: #102958;" data-field="date" data-sortable="true" data-sorter="dateSorter">End Date</th>

                                            <th width="50px" style="color: #102958;">Symbol</th>
                                            <th width="100px" style="color: #102958;">Amount of premium</th>
                                            <th width="100px" style="color: #102958;">Premium Conv.(฿THB)</th>

                                            <th width="70px" style="color: #102958;">Paid Date</th>
                                            <th width="150px" style="color: #102958;" >Agent/Customer</th>

                                        </tr>
                                    </thead>
                                    <tbody style="color: #494949; font-size: 13px;" >
<?php 
    $cnt=1;
    $total_premium_rate = 0;
    if(count($results) > 0){
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
        
        <td class="text-center"><?php echo $result->currency;?></td>
        <td class="text-right" >
            <?php   
            // if($result->currency !="฿THB" && $result->currency !="THB"){
                echo number_format((float)$result->convertion_value, 2, '.', ',');
                    // }else{
                    //     echo "0.00";
                    // }
            ?>
        </td>
        <td class="text-right" ><?php echo number_format((float)$result->premium_rate, 2, '.', ',');?></td>
        <?php $total_premium_rate = $total_premium_rate + $result->premium_rate;  ?>
        <td class="text-center"><?php echo $result->paid_date_day;?></td>

        <!-- $result->title_name_agent." ". -->
        <td><?php echo $result->first_name_agent." ".$result->last_name_agent;?></td>

    <?php $cnt++;}} ?>                       

                                    </tbody>

                                    <tfoot>
                                        <tr style="font-weight: bold;"> 
                                            <td class="text-center" ></td>
                                            <td style="font-weight: bold;color: black;" class="text-right" >GRAND TOTAL</td>
                                            
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                            <td style="font-weight: bold;color: black;" class="text-right" >
                                                <?php echo number_format((float)$total_premium_rate, 2, '.', ','); ?>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>

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
                    "targets": [6,7,11],
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
			lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			"scrollCollapse": true,
			"paging": true,
				buttons: [
					{ 
						extend: 'csv',
						class: 'buttons-csv',
						className: 'btn-primary',
						charset: 'UTF-8',
						filename: 'Payment received',
						bom: true,
                        // exportOptions: {
                        //     columns: ':not(:last-child)' // Exclude the first column from export
                        // }, 
						init: function(api, node, config) { $(node).hide(); }
					},
					{ 
						extend: 'excel',
						class: 'buttons-excel',
						className: 'btn-primary',
						charset: 'UTF-8',
						filename: 'Payment received',
						bom: true,
                        // exportOptions: {
                        //     columns: ':not(:last-child)' // Exclude the first column from export
                        // },
						init: function(api, node, config) { $(node).hide(); }
					},
					{ 
						extend: 'pdf',
						class: 'buttons-pdf',
						className: 'btn-primary',
						charset: 'UTF-8',
						filename: 'Payment received',
						bom: true,
                        // exportOptions: {
                        //     columns: ':not(:last-child)' // Exclude the first column from export
                        // },
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
                        // exportOptions: {
                        //     columns: ':not(:last-child)' // Exclude the first column from export
                        // },
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
<?php  ?>

<?php $dbh = null; ?>
