<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<?php
	include_once('includes/connect_sql.php');
    session_start();
    error_reporting(0);
	include_once('includes/fx_customer_db.php');
	// include_once('includes/fx_address.php');
    include_once('includes/fx_address_function.php');
	include_once('includes/fx_agent_db.php');
	include_once('includes/fx_insurance_products.php');
	include('includes/config_path.php');

	if(strlen($_SESSION['alogin'])=="") {
        sqlsrv_close($conn);
		header('Location: logout.php');
	}

	$provinces = get_provinces($conn);
	// $districts = get_district_by_province($conn, $provinces[0]['code']);
	// $subdistricts = get_subdistrict_by_district($conn, $districts[0]['code']);

	$customer_id = generate_customer_id($conn);
	$insurance_company = get_insurance_company ($conn);
	$product_categories = get_product_category($conn);

	$customer_level_list = get_customer_level($conn);
	$period_list = get_period($conn);
	$agents = get_agents($conn);

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!empty($_POST)) {
			// echo '<script>alert("save_customer")</script>'; 
			save_customer($conn, $_POST,$sourceFilePath);	
			// echo '<script>alert("End save_customer")</script>'; 	
			// print_r($_POST);
			
			// echo '<script>alert("Successfully added information.")</script>';
            sqlsrv_close($conn);
			echo "<script>window.location.href ='customer-information.php'</script>";
		}
		// header('Location: customer-information.php');
	}

	$start_date = date('d-m-Y');
	$stop_date = date('d-m-Y');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Buttons</title>

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

    <div class="container-fluid " >
        <div class="row breadcrumb-div" style="background-color:#ffffff">
            <div class="col-md-12" >
                <ul class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                    <li class="active"  ><a href="customer-information.php">Customer List</a></li>
                    <li class="active">Add Customer</li>
                </ul>
            </div>
        </div>
    </div>

<!-- onsubmit="return validateForm()" -->
<!-- onSubmit="return valid();" -->
<form method="post" action="add-customer.php" enctype="multipart/form-data" onSubmit="return validateForm();" >
<br>

<script>
var tax_id_check = "true";
var mobile_check = "true";

$(function(){
    var tax_id_object = $('#tax_id');
    tax_id_object.on('change', function(){
        var tax_id_value = $(this).val();
            $.get('get_customer_tax.php?tax_id=' + tax_id_value, function(data){
                var result = JSON.parse(data);
                tax_id_check = "true";
                $.each(result, function(index,item){
                    if(item.id!=""){
                        alert("This customer already exist.");
                        // tax_id_check="false";
                    }
                });
            });
    });

    var mobile_object = $('#mobile');
    mobile_object.on('change', function(){
        var mobile_value = $(this).val();
            $.get('get_customer_mobile.php?mobile=' + mobile_value, function(data){
                var result = JSON.parse(data);
                mobile_check = "true";
                $.each(result, function(index,item){
                    if(item.id!=""){
                        alert("This customer already exist.");
                        // mobile_check="false";
                    }
                });
            });
    });

    var name_object = $('#first_name');
    name_object.on('change', function(){
        var name_value = $(this).val();
            $.get('get_customer_first_name.php?name=' + name_value, function(data){
                var result = JSON.parse(data);
                $.each(result, function(index,item){
                    if(item.id!=""){
                        alert("This customer already exist.");
                    }
                });
            });
    });

});

function validateForm() {
    // var deferred = $.Deferred();
    // var tax_id_value = document.getElementById("tax_id").value;
    // var mobile_value = document.getElementById("mobile").value;
    // $.get('get_customer_tax.php?tax_id=' + tax_id_value, function(data){
    //     alert("value:"+tax_id_value);
    //     var result = JSON.parse(data);
    //     var tax_id_check = true;
    //     $.each(result, function(index, item){
    //         tax_id_check ="false";
    //     });
    // });
    if (tax_id_check=="true" && mobile_check == "true") {
        document.getElementById("loading-overlay").style.display = "flex";
        return true;
    }else{
        alert("This customer already exist.");
        return false;
    }
}
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel">
                
                <div class="panel-heading">
                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col-sm-4">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Add Customer</h2>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                            <!-- style="background-color: #0275d8;color: #F9FAFA;" -->
                        </div>
                    </div>
                </div> 

            <div class="panel-body">
                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left"  >
                        <label  style="color: #102958;"  ><small><font color="red">*</font></small>Cust. Type:</label>
                    </div>
                    <div class="col-3 ">
                        <select name="customer_type" style="border-color:#102958; color: #000;" id="customer_type" onchange="" class="form-control" required>
							<option value="">Select Cust. Type</option>
							<option value="Personal" >Personal</option>
							<option value="Corporate" >Corporate</option>
                    </select>
                    </div>
                    <div class="col-sm-2 label_left" >
                         <input name="status" class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked="checked">
                        <label style="color: #000;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Active
                    </div>
                    <div class="col-4 ">
                         
                    </div>
                </div> 

                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left"  >
                        <label style="color: #102958;"  >Cust. ID:</label>
                    </div>
                    <div class="col-3 ">
                        <input name="customer_id" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"  class="form-control" value="<?php echo $customer_id;?>"  readOnly> 
                    </div>
                    <div class="col-1 label_left" >
                        <label style="color: #102958;"  ><small><font color="red">*</font></small>Cust. Level:</label>
                    </div>
                    <div class="col-sm-2 ">
                        <select id="customer_level" name="customer_level" style="border-color:#102958; color: #000;"  class="form-control" required>
                            <option value="" selected>Select Cust. Level</option>
                            <?php foreach ($customer_level_list as $pc) {?>
                                <option value="<?php echo $pc['id'];?>" data-description="<?php echo $pc['description'];?>" ><?php echo $pc['level_name'];?></option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="col-4 ">
                        <input id="customer_de" name="customer_de" style="color: #000;border-color:#102958;" type="text" class="form-control"  readOnly> 
                    </div>

                </div> 

                <script>
                    // รับ element ของ dropdown
                    var customerLevelDropdown = document.getElementById("customer_level");
                    // เมื่อมีการเปลี่ยนค่าใน dropdown
                    customerLevelDropdown.addEventListener("change", function() {
                        // รับค่าที่ถูกเลือก
                        var selectedOption = customerLevelDropdown.options[customerLevelDropdown.selectedIndex];
                        // รับค่า description จาก data-attribute
                        var description = selectedOption.getAttribute("data-description");
                        // ใส่ค่า description ลงใน input field
                        document.getElementById("customer_de").value = description;
                    });

                    // เมื่อโหลดหน้าเว็บครั้งแรก
                    window.addEventListener("load", function() {
                        // รับค่าตั้งต้นของ dropdown และเรียกใช้งานฟังก์ชัน change
                        var initialOption = customerLevelDropdown.options[customerLevelDropdown.selectedIndex];
                        var initialDescription = initialOption.getAttribute("data-description");
                        document.getElementById("customer_de").value = initialDescription;
                    });
                </script>

                <div class="form-group row col-md-10 col-md-offset-1 corporate" style="margin-top: 0px !important;">
                    <div class="col-sm-2  label_left corporate"  >
                        <label  style="color: #102958;" ><small><font color="red">*</font></small>Company name:</label>
                    </div>
                    <div class="col corporate">
                        <input id="company_c_input" name="company_name" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" required>    
                    </div>
                    <!--<div class="col-sm-2 label_left" >
                    </div>
                    <div class="col ">
                    </div>-->
                </div>

                <div class="form-group row col-md-10 col-md-offset-1 personal" >
                    <div id="label_title" class="col-sm-2   personal"  >
                        <label id="label_title" style="color: #102958;"  >Title:</label>
                    </div>
                    <div id="col_title" class="col-3 personal">
                        <select id="title_name" style="border-color:#102958; color: #000;" name="title_name" class="form-control" id="title_name"  >
                            <option value="" selected>Select Title</option>
                            <option value="Mr." <?php echo (trim($customer['title_name'])=="Mr.") ? 'selected' : '';?>>Mr.</option>
                            <option value="Ms." <?php echo (trim($customer['title_name'])=="Ms.") ? 'selected' : '';?>>Ms.</option>
                            <option value="Mrs." <?php echo (trim($customer['title_name'])=="Mrs.") ? 'selected' : '';?>>Mrs.</option>       
                        </select>     
                    </div>
                </div>

                <div class="form-group row col-md-10 col-md-offset-1 personal" >
                    <div id="label_fname" class="col-sm-2  label_left personal"  >
                        <label style="color: #102958;" ><small><font color="red">*</font></small>First name:</label>
                    </div>
                    <div  class="col-4 personal">
                        <input id="first_name" name="first_name" minlength="1" maxlength="100" style="color: #000;border-color:#102958;" type="text"  class="form-control" >
                    </div>
					<div class="col-2  label_left personal"  >
                        <label  style="color: #102958;" >Last name:</label>
                    </div>
                    <div class="col-4 personal">
                        <input id="last_name" name="last_name" minlength="1" maxlength="100" style="color: #000;border-color:#102958;" type="text"  class="form-control"  >
                    </div>
                </div>
				
				<div class="form-group row col-md-10 col-md-offset-1 personal" >
                    <div class="col-sm-2  label_left personal"  >
                        <label style="color: #102958;"  >Nickname:</label>
                    </div>
                    <div class="col-4 personal ">
                        <input id="nick_name" name="nick_name"  minlength="1" maxlength="100" style="color: #000;border-color:#102958;" type="text" class="form-control" >
                    </div>
				</div>
				
				<div class="form-group row col-md-10 col-md-offset-1 " >
					<div class="col-sm-2 label_left" >
                        <label style="color: #102958;" >Tax ID / Passport ID:</label>
                    </div>
                    <div class="col-4 ">
                        <input id="tax_id" name="tax_id"  minlength="1" maxlength="13" style="color: #000;border-color:#102958;" type="text" class="form-control" > 
					</div>
                    <div class="col-sm-2 label_left" >
                        <label style="color: #102958;" >Email:</label>
                    </div>
                    <div class="col-4 ">
                        <input name="email" id="email" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="email" class="form-control"  >
                    </div>
                </div>

                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2 label_left" >
                        <label style="color: #102958;" >Mobile:</label>
                    </div>
                    <div class="col-4 ">
                        <input id="mobile" name="mobile" minlength="10" maxlength="12" style="color: #000;border-color:#102958;" type="text" class="form-control"  pattern="\d{3}-\d{3}-\d{4}" >    
                    </div>
					<script>
						document.getElementById('mobile').addEventListener('input', function (e) {
							var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
							e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
						});
					</script>
                    <div class="col-sm-2 label_left" >
                        <label style="color: #102958;" >Tel:</label>
                    </div>
                    <div class="col-4 ">
                        <input id="tel" name="tel" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
                    </div>
                </div>

                <script type="text/javascript">
                    var tax_id_object = $('#tax_id');
                    var mobile_object = $('#mobile');

                </script>

                <div class="panel-heading">
                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="panel-title" style="color: #102958;" >
                            <h2 class="title" >Address</h2>
                        </div>
                    </div>
                </div>
				<!--
                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left"  >
                        <label style="color: #102958;" ><small><font color="red">*</font></small>Address No:</label>
                    </div>
                    <div class="col-4 ">
                        <input name="address_number" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" required>
                    </div>
                    <div class="col-sm-2 label_left" >
                        <label style="color: #102958;" >Building Name:</label>
                    </div>
                    <div class="col-4 ">
                        <input name="building_name" minlength="1" maxlength="100" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" >
                    </div>
                </div>
                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left"  >
                        <label style="color: #102958;" >Soi:</label>
                    </div>
                    <div class="col-4 ">
                        <input name="soi" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" >
                    </div>
                    <div class="col-sm-2 label_left" >
                        <label style="color: #102958;"  >Road:</label>
                    </div>
                    <div class="col-4 ">
                        <input name="road" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" >
                    </div>
                </div>
				-->
				<div class="form-group row col-md-10 col-md-offset-1">
					<div class="col-sm-2 label_left">
						<label style="color: #102958;">Address No:</label>
					</div>
					<div class="col-2">
						<input name="address_number" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
					</div>
				<div class="col-sm-1 label_left">
						<label style="color: #102958;">Soi:</label>
					</div>
					<div class="col pl-0">
						<input name="soi" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control">
					</div>
					<div class="col-sm-1 label_left">
						<label style="color: #102958;">Road:</label>
					</div>
					<div class="col pl-0">
						<input name="road" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control">
					</div>
				</div>
				<div class="form-group row col-md-10 col-md-offset-1">
					<div class="col-sm-2 label_left">
						<label style="color: #102958;">Building Name:</label>
					</div>
					<div class="col">
						<input name="building_name" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control">
					</div>
				</div>

                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left"  >
                        <label style="color: #102958;" >Province:</label>
                    </div>
                    <div class="col-4 ">
                        <!-- class="remove-example form-control selectpicker" data-live-search="true" -->
                         <select style="border-color:#102958; color: #000;" name="province" class="form-control selectpicker" id="province" data-live-search="true"  >
                            <option value="" selected>Select Province</option>
                        <?php foreach ($provinces as $province) { ?>
                        <option value="<?php echo $province['code']?>"><?php echo $province['name_en'];?></option>
                        <?php } ?>
                    </select>
                    </div>
                    <div class="col-sm-2 label_left" >
                        <label style="color: #102958;" >District:</label>
                    </div>
                    <div class="col-4 ">
                        <select style="border-color:#102958; color: #000;" name="district" class="form-control selectpicker" id="district" data-live-search="true"  >
                            <option value="" selected>Select District</option>
                    <?php foreach ($districts as $district) { ?>
                        <option value="<?php echo $district['code']?>"><?php echo $district['name_en'];?></option>
                        <?php } ?>                  
                    </select>
                    </div>
                </div>
                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left"  >
                        <label style="color: #102958;" >Sub-district:</label>
                    </div>
                    <div class="col-4 ">
                        <select id="subdistrict" name="sub_district" style="border-color:#102958; color: #000;" class="form-control selectpicker" data-live-search="true"  >  
                        <option value="" selected>Select Subdistrict</option> 
                    <?php foreach ($subdistricts as $sub) { ?>
                        <option value="<?php echo $sub['code']?>"><?php echo $sub['name_en'];?></option>
                        <?php } ?>                  
                    </select>
                    </div>
                    <div class="col-sm-2 label_left" >
                        <label style="color: #102958;" >Post Code:</label>
                    </div>
                    <div class="col-4 ">
                        <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="post_code" id="post_code" class="form-control"  >
                    </div>
                </div>

            </div> 

            </div> 
        </div> 
    </div> 
</div> 


<div class="container-fluid">
	
		<!-- 1 End -->
		
<!-- Contact Section Start -->
<div class="row " id="contact-section">

            <div class="col-md-12 ">

                <div class="panel">
                    <div class="panel-heading">

                    <div class="form-group row">
                        <div class="form-group row col-md-10 col-md-offset-1">

                <div class="col">
                    <div class="panel-title" style="color: #102958;" >
                        <h2 class="title">Contact Person</h2>
                    </div>
                </div>

            <div class="col">     
                <div class="form-check" style="top:20px;">
                    <!-- disabled="true" -->
                    <input name="same_customer" id="same_customer" class="form-check-input same_customer" type="checkbox" >
                    <label style="color: #000;" class="form-check-label" for="SameCheck">
                            &nbsp;&nbsp;&nbsp;&nbsp; Same Customer Name
                    </label>
                </div>
            </div>  

                   

            <!-- <div class="col text-right"> -->
                <!-- <button id="button_remove" hidden="true" type="button" class="btn btn_remove_con button_remove" style="background-color: #0275d8;color: #F9FAFA;" >X</button>
            </div>&nbsp;&nbsp; -->

                        <!-- </div> -->
                    </div>
                     <div class="col text-right">
                        <div class="contact-clone-cancel1" id="contact-clone-cancel1" ></div>
                    </div>
                </div>
   
        <div class="panel-body">
            <div class="form-group row col-md-10 col-md-offset-1" >
                <div class="col-sm-2  label_left"  >
                    <label style="color: #102958;" >Title:</label>
                </div>
                <div class="col-3">
                    <select name="contact_title_name[]" id="contact_title_name" style="border-color:#102958; color: #000;"  class="form-control" id="default"  >
                        <option value="" selected>Select Title </option>
                        <option value="Mr." <?php echo (trim($customer['title_name'])=="Mr.") ? 'selected' : '';?>>Mr.</option>
                        <option value="Ms." <?php echo (trim($customer['title_name'])=="Ms.") ? 'selected' : '';?>>Ms.</option>
                        <option value="Mrs." <?php echo (trim($customer['title_name'])=="Mrs.") ? 'selected' : '';?>>Mrs.</option>       
                    </select>    
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;" class="col-sm-2 label_left">First name:</label>
                <div class="col-4">
                    <input id="contact_first_name" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="contact_first_name[]" class="form-control" >
                </div>
				<label  style="color: #102958;" class="col-sm-2 label_left">Last name:</label>
                <div class="col-4">
                    <input id="contact_last_name" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="contact_last_name[]" class="form-control"  >
               
                </div>
            </div>
			
			<div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;" class="col-sm-2 label_left">Nickname:</label>
                <div class="col-4">
                    <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="contact_nick_name[]" id="contact_nick_name" class="form-control" >
                </div>
               
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;" class="col-sm-2 label_left">Mobile:</label>
                <div class="col-4">
                    <input  minlength="10" maxlength="12" style="color: #000;border-color:#102958;" type="text" name="contact_mobile[]" id="contact_mobile" class="form-control" pattern="\d{3}-\d{3}-\d{4}" >
                </div>
				<script>
					document.getElementById('contact_mobile').addEventListener('input', function (e) {
						var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
						e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
					});
				</script>
                <label style="color: #102958;" class="col-sm-2 label_left">Tel:</label>
                <div class="col-4">
                    <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="contact_tel[]" id="contact_tel" class="form-control" >
                </div>
            </div>

             <div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;" class="col-sm-2 label_left">Email:</label>
                <div class="col-4">
                    <input id="contact_email" name="contact_email[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="email" class="form-control" >
                </div>
                <label style="color: #102958;" class="col-sm-2 label_left">Line ID:</label>
                <div class="col-4">
                    <input id="contact_line_id" name="contact_line_id[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"  class="form-control" >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
				<label style="color: #102958;" class="col-sm-2 label_left">Position:</label>
                <div class="col-4">
                    <input id="contact_position" name="contact_position[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
               
                </div>
				<label style="color: #102958;" class="col-sm-2 label_left">Department:</label>
                <div class="col-4">
                    <input id="department" name="department[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
                </div> 
            </div> 
						
			<div class="form-group row col-md-10 col-md-offset-1">
				<label style="color: #102958;" class="col-sm-2 label_left" for="contact_remark">Remark:</label>
				<div class="col-10 ">
					<textarea id="contact_remark" name="contact_remark[]" minlength="1" maxlength="255" style="color: #000;border-color:#102958;" class="form-control" rows="2"></textarea>
				</div>
			</div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <div class="col-sm-2 label_left">

                </div>    
                <div class="col-4">
                    <!-- hidden="true" -->
                    <input id="hid_default1" name="hid_default[]" hidden="true" type="text" value="1" >
                    <input id="id_default1"  name="default_contact[]" class="form-check-input" type="radio" value="1" checked>
                    <label style="color: #000;" class="form-check-label" >
                    &nbsp;&nbsp;&nbsp;&nbsp; Default Contact
                    </label>
                </div>
            </div>   
                
			</div>
        </div>
    </div> 
</div>

</div> 
<!-- Contact Section End -->

<div id="contact-section-clone" class="contact-section-clone"></div>	

    <div class="row">
        <div  class="col-sm-12 text-right  ">
            <div style="padding-top: 10px;">
             
            <button style="background-color: #0275d8;color: #F9FAFA;" type="button" name="add_more_contacts" class="btn" id="add-con">+ Add More Contact<span class="btn-label btn-label-right"><i class="fa "></i></span></button>
            </div>
        </div>
    </div>
    <br>

<!-- Insurance Info Start -->
<!-- class="container-fluid" -->

<div >
    <!-- 1 Start -->
    <!-- <div class="row">
        <div  class="col-sm-12 text-right  ">

            <div style="padding-top: 10px;">
             
             <button style="background-color: #0275d8;color: #F9FAFA;" type="button" name="add_more_insurance" class="btn  btn-labeled" id="add-insur">+ Add More Policy<span class="btn-label btn-label-right"><i class="fa "></i></span></button>
            </div>
        </div>
    </div> -->
        <!-- 1 End -->

    <div class="row" id="insurance-section">
            <div class="col-md-12 ">
                <div class="panel">
                   <div class="panel-heading">
                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col-12">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Policy information</h2>
                            </div>
                        </div>
                        </div>
                    </div>
   
        <div class="panel-body">
            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;"  class="col-sm-2 label_left">Policy No:</label>
                <div class="col-4">
                    <input name="policy_no[]" id="policy_no" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"  class="form-control" >
                </div>
                <label style="color: #102958;"  class="col-sm-2 label_right">Period:</label>
                <div class="col-2">
                    <select name="period[]" id="period" style="color: #000;border-color:#102958;" class="form-control" value="" >
						<option value="">Select Period</option>
						<?php foreach ($period_list as $pc) { ?>
							<option value="<?php echo $pc['id'];?>"><?php echo $pc['period'];?></option>
						<?php } ?>
                    </select>
                </div>
            </div>

            <div hidden="" class="form-group row col-md-10 col-md-offset-1" >
                <!-- <label style="color: #102958;"  class="col-sm-2 label_left">Prod.Category:</label>
                <div class="col-4">
                    <select name="product_category[]" id="product_category" style="color: #000;border-color:#102958;"class="form-control" >
						<option value="">Select Category</option>
						<?php foreach ($product_categories as $pc){ ?>
							<option value="<?php echo $pc['id'];?>" ><?php echo $pc['categorie'];?></option>
						<?php }?>
                    </select>
                </div>
                <label style="color: #102958;"  class="col-sm-2 label_right">Sub Categories:</label>
                <div class="col-4">
                    <select name="sub_cat[]" id="sub_cat" style="color: #000;border-color:#102958;"class="form-control sub_cat" >
                    <option value="">Select Sub Categories</option>                    
                    </select>
                </div> -->

                <div class="col-6">
                    <input  id="product_cat" name="product_category[]" style="color: #000;border-color:#102958;" type="text" class="form-control input_text" value="<?php echo $i['product_category']; ?>" >
                </div>
                <div class="col-6">
                    <input  id="sub_cat" name="sub_cat[]" style="color: #000;border-color:#102958;" type="text" class="form-control input_text" value="<?php echo $i['sub_categories']; ?>" >
                </div>

            </div>
			
			<div class="form-group row col-md-10 col-md-offset-1" >
				<div class="col-sm-2 label_left">
                    <label style="color: #102958;" >Partner Company:</label>
                </div>  
                <div class="col">
                    <select name="insurance_company[]" id="insurance_company" style="color: #000;border-color:#102958;"class="form-control" >
                    <option value="">Select Partner</option>
                    <?php foreach ($insurance_company as $insurance) {?>
                        <option value="<?php echo $insurance['id'];?>" ><?php echo $insurance['insurance_company'];?></option>
                    <?php }?>
                    </select>
                </div>
			</div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;"  class="col-sm-2 label_left">Prod. Name:</label>
                <div class="col">
                    <select name="product_name[]" id="product_name" style="color: #000;border-color:#102958;"class="form-control" >
                    <option value="">Select Product</option>                    
                    </select>
                </div>
            </div>

			<script>
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

            <div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;"  class="col-sm-2 label_left">Start date:</label>
                <div class="col-2">
                    <input id="start_date" name="start_date[]" style="color: #000;border-color:#102958; text-align: center;" type="text" class="form-control" value="<?php echo $start_date; ?>" placeholder="dd-mm-yyyy">
               
                </div>
                <label style="color: #102958;"  class="col-sm-2 label_left">End date:</label>
                <div class="col-2">
                    <input id="end_date" name="end_date[]" style="color: #000;border-color:#102958; text-align: center;" type="text"  class="form-control" value="<?php echo $stop_date; ?>" placeholder="dd-mm-yyyy">
                </div>
            </div>


            <div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;"  class="col-sm-2 label_left">Premium Rate:</label>
                <div class="col-2">
                    <input id="premium_rate" name="premium_rate[]" step="0.01" min="0" style="color: #000;border-color:#102958;" type="number" class="form-control"  >
                    
                </div>

                <label style="color: #102958;"  class="col-sm-2 label_left">Status:</label>
                <div class="col-2">
					<select id="insurance_status" name="insurance_status[]" onchange="ClickChange()" style="border-color:#102958; color: #000;" class="form-control" >
						<option value="">Select Status</option>
						<option value="New">New</option>
						<option value="Follow up">Follow up</option>
						<option value="Renew">Renew</option>
						<option value="Wait">Wait</option>
						<option value="Not renew">Not renew</option>
					</select>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;"  class="col-sm-2 label_left">Agent Name:</label>
				<div class="col-4">
					<select id="agent_name" name="agent_name[]" style="color: #000;border-color:#102958;"class="form-control" value="" >
						<option value="">Select Agent</option>
						<?php //foreach ($agents  as $a) { ?>
							<!-- <option value="<?php //echo $a['id']?>"><?php //echo $a['first_name'].' '.$a['last_name'];?></option> -->
					    <?php //} ?>  
					</select>
				</div>

				<label style="color: #102958;" class="col-sm-2 label_left">Upload Documents:</label>                
				<div class="col-4">
					<input id="imgInp" name="file_d[]" type="file" style="width: 100%;" accept="application/pdf" >
				</div>                     
            </div>
			<script>
				$(document).ready(function () {
					function checkFileSize() {
						var fileInput = document.getElementById('imgInp');
						var fileSize = fileInput.files[0].size; // ขนาดของไฟล์ใน bytes
						var maxSize = 5 * 1024 * 1024; // ขนาดสูงสุดที่อนุญาตให้อัพโหลดเป็น bytes (5 MB)

						if (fileSize > maxSize) {
							alert('File size exceeds 5MB. Please choose a file smaller than 5MB.');
							// ล้างค่าไฟล์ที่เลือก
							document.getElementById('imgInp').value = "";
						}
					}

					function readURL(input) {
						var fileName = document.getElementById("imgInp").value;
						var idxDot = fileName.lastIndexOf(".") + 1;
						var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
						if (extFile == "pdf") {
							if (input.files && input.files[0]) {
								var reader = new FileReader();
								reader.readAsDataURL(input.files[0]);
							}
						} else {
							// var reader = new FileReader();
							// reader.readAsDataURL(input.files[0]);
							document.getElementById("imgInp").value = null;
							// alert("เฉพาะไฟล์ PDF เท่านั้นที่อนุญาต!");
                            alert("Only PDF files are allowed!");
						}
					}

					$("#imgInp").change(function () {
                        $.ajax({
                        url: 'check_folder_size_json.php',
                        type: 'GET',
                            success: function(response) {
                                data = JSON.parse(response);
                                if (data.alert) {
                                    var message = "The folder at " + data.folderPath + " is nearly full. Remaining space: " + data.remainingSizeGB + " GB.";
                                    alert(message);
                                    document.getElementById("imgInp").value = null;
                                }else{
            						  checkFileSize();
            						  readURL(this);
                                }
                            }
                        });

					});
				});
			</script>
        </div>
    </div>                             
    </div> <!--  -->
    
</div> <!-- INSURANCE SECTION END -->

<div id="insurance-section-clone" class="insurance-section-clone">
</div>
</div>
<!-- Insurance Info End -->

<!-- <div class="container-fluid"> -->
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel">
                <div class="panel-body">

                <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-md-12">
                    <button style="background-color: #0275d8;color: #F9FAFA; padding: 3px 16px 3px 16px;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                    </button>
					&nbsp;&nbsp;
					<a href="customer-information.php" class="btn btn-primary" style="background-color: #0275d8;color: #F9FAFA;" >
						<span class="text">Cancel</span>
					</a>
                </div>
                </div>
 
                </div>
            </div> 
        </div>  
    </div>  
<!-- </div>  -->



<!-- Container  End-->
    <br><br><br>
</form>
</div>

    <script>
        function ClickChange() {
            var x = document.getElementById("type_c_input").value;
            if(x=="Corporate"){
                document.getElementById("label_title").readOnly = true;
                document.getElementById("col_title").readOnly = true;
                document.getElementById("input_title").readOnly = true;

                document.getElementById("label_fname").readOnly = true;
                document.getElementById("col_fname").readOnly = true;
                document.getElementById("input_fname").readOnly = true;

                document.getElementById("label_lname").readOnly = true;
                document.getElementById("col_lname").readOnly = true;
                document.getElementById("input_lname").readOnly = true;
            }else if(x=="Personal"){
                document.getElementById("label_title").readOnly = false;
                document.getElementById("col_title").readOnly = false;
                document.getElementById("input_title").readOnly = false;

                document.getElementById("label_fname").readOnly = false;
                document.getElementById("col_fname").readOnly = false;
                document.getElementById("input_fname").readOnly = false;

                document.getElementById("label_lname").readOnly = false;
                document.getElementById("col_lname").readOnly = false;
                document.getElementById("input_lname").readOnly = false;
            }
            document.getElementById("demo").innerHTML = "You selected: " + x;
        }

    </script>
        <script>
            $(function($) {
				var subdistrict = [];
				var zipcodes = [];

				$('#province').change(function(){
                    // alert('district refresh');
					//alert($(this).val())
					$.ajax({
					type:"post", 
					url: "includes/fx_address.php", 
					data: {
						action: 'get_district',
						id_province: $(this).val()
					},
					success: function(result) {
						
						var obj = eval("(" + result + ")");
						subdistrict = obj;
						// console.log(subdistrict);
						$("#district option").remove();
                        $("#subdistrict option").remove();

						// $("#subdistrict option").remove();
						var options_d = $("#district");
                        options_d.append($("<option />").val("").text("Select District"));

                        var options_s = $("#subdistrict");
                        options_s.append($("<option />").val("").text("Select Subdistrict"));

						//don't forget error handling!
						$.each(obj, function(item) {
							//console.log(item);
							options_d.append($("<option />").val(obj[item].code).text(obj[item].name_en));
						});
                        $("#district").selectpicker('refresh');

					}				  
					});
				});
				
				$('#district').change(function(){
					//alert($(this).val())
					$.ajax({
					type:"post", 
					url: "includes/fx_address.php", 
					data: {
						action: 'get_subdistrict',
						id_district: $(this).val()
					},
					success: function(result) {
						
						var obj = eval("(" + result + ")");
						$("#subdistrict option").remove();
						var options = $("#subdistrict");
						options.append($("<option />").val("").text("Select Subdistrict"));


						
                        var zipcodes_tmp = [];
						$.each(obj, function(item) {
							//console.log(item);
							// zipcodes[obj[item].code] = obj[item].zip_code;
                            zipcodes_tmp[obj[item].code] = obj[item].zip_code;
							options.append($("<option />").val(obj[item].code).text(obj[item].name_en));
						});
                        zipcodes = zipcodes_tmp;
                        $("#subdistrict").selectpicker('refresh');
					}				  
					});
				});
				
				$('#subdistrict').change(function(){
					var id = $(this).val();
					console.log(id);
					var selected = zipcodes[id];
					console.log(selected);
					$('#post_code').val(selected);
				});
				
				var contact_ct = 1;
				$('#add-con').click(function(){		
                   
					// $("#contact-section").clone().attr('id', 'contact-section_'+contact_ct).appendTo(".contact-section-clone");

                    clone = $('#contact-section').clone();
                    clone.attr('id', 'contact-section_'+contact_ct);
                    clone.find("#id_default1").attr('checked', false);
                    clone.find("#id_default1").attr('id','id_default'+(contact_ct+1));
                    clone.find("#hid_default1").attr('id','hid_default'+(contact_ct+1));

                    clone.find("#contact_mobile").attr('id','contact_mobile'+contact_ct);

                    clone.find("#contact_title_name").val("Mr.");
                    clone.find("#contact_first_name").val("");
                    clone.find("#contact_last_name").val("");
                    clone.find("#contact_nick_name").val("");
                    clone.find("#contact_tel").val("");
                    clone.find("#contact_mobile").val("");
                    clone.find("#contact_email").val("");
                    clone.find("#contact_line_id").val("");
                    clone.find("#contact_position").val("");
                    clone.find("#contact_remark").val("");
                    clone.find("#department").val("");

                    clone.find("#contact-clone-cancel1").attr('id','contact-clone-cancel-new'+contact_ct);

                    clone.appendTo(".contact-section-clone");

                    document.getElementById("id_default"+(contact_ct+1)).value = (contact_ct+1);
                    document.getElementById("hid_default"+(contact_ct+1)).value = (contact_ct+1);

                    var body_add ='<script>';
                    body_add +='document.getElementById("contact_mobile'+contact_ct+'").addEventListener("input", function (e) {';
                    body_add +='    var x = e.target.value.replace(/'+'\\D/'+'g,'+"''"+').match(/'+'(\\d{0,3})(\\d{0,3})(\\d{0,4})/'+');';
                    body_add +='    e.target.value = !x[2] ? x[1] : x[1] + '+"'-'"+' + x[2] + (x[3] ? '+"'-'"+' + x[3] : '+"''"+');';
                    body_add +='});';
                    body_add +='</'+'script>';
                    $("#contact-section-clone").append(body_add);

                    var body_add ='';
                    body_add +='<div class="col text-right">';
                    body_add +='<button type="button" class="btn btn_remove_con" name="remove" style="background-color: #0275d8;color: #F9FAFA;" id="'+ contact_ct +'">X</button>';
                    body_add +='</div>&nbsp;&nbsp;';
                    $("#contact-clone-cancel-new"+contact_ct).append(body_add);

					contact_ct++
					$('.same_customer').each(function( index ) {                  
                          console.log( index + ": " + $( this ).text() );
                          if (index > 0) {
                          	$(this).hide();
                          	$( this ).next().hide();
                          }
                    });
				});

            $(document).on('click', '.btn_remove_con', function() {
                var button_id = $(this).attr("id");
                $('#contact-section_' + button_id + '').remove();
                $('#' + button_id + '').remove();
            });

				var insur_ct = 1;
				$('#add-insur').click(function(){
                    var body_add ='';
                    body_add +='<div class="col text-right">';
                    body_add +='<button type="button" class="btn btn_remove_insur" name="remove" style="background-color: #0275d8;color: #F9FAFA;" id="'+ insur_ct +'">X</button>';
                    body_add +='</div>&nbsp;&nbsp;';
                    $("#insurance-section-clone").append(body_add);
                    ///////////////////////////////////////////////////////////
                   
			// $("#insurance-section").clone().attr('id','insurance-section_'+insur_ct).appendTo(".insurance-section-clone");
                    clone = $("#insurance-section").clone();
                    clone.attr('id', 'insurance-section_'+insur_ct);
                    clone.find("#product_category").attr('id','product_category_'+insur_ct);
                   
                    clone.find("#policy_no").val("");
                    clone.find("#sub_cat").val("");
                    clone.find("#product_name").val("");
                    clone.find("#start_date").val(Date.now());
                    clone.find("#end_date").val(Date.now());
                    clone.find("#premium_rate").val("");
                    clone.find("#insurance_status").val("New");
                    clone.find("#agent_name").val("");
                    clone.find("#imgInp").val("");

                    clone.find("#start_date").attr('id','start_date'+insur_ct).val("");
                    clone.find("#end_date").attr('id','end_date'+insur_ct).val("");

                    clone.find("#sub_cat").attr('id','sub_cat_'+insur_ct);
                    clone.find("#insurance_company").attr('id','insurance_company_'+insur_ct);
                    clone.find("#product_name").attr('id','product_name_'+insur_ct);
                    clone.find("#agent_name").attr('id','agent_name_'+insur_ct);
                    clone.find("#imgInp").attr('id','imgInp'+insur_ct).val("");
                    clone.appendTo(".insurance-section-clone");
                    $("#agent_name_"+insur_ct+" option").remove();

                    var body_add ='';
                    body_add +='<script>';
                    body_add +='$(document).ready(function(){';
                    body_add +='$('+"'#start_date"+insur_ct+"'"+').datepicker({';
                    body_add +='  format: '+"'dd-mm-yyyy'"+',';
                    body_add +='  language: '+"'en'"+'';
                    body_add +='});';
                    body_add +='$('+"'#end_date"+insur_ct+"'"+').datepicker({';
                    body_add +='  format: '+"'dd-mm-yyyy'"+',';
                    body_add +='  language: '+"'en'"+'';
                    body_add +='});';
                    body_add +='});';
                    body_add +='</'+'script>';
                    $("#insurance-section-clone").append(body_add);

                    var body_add ='';
                    body_add +='<script type="text/javascript">';
                    body_add +='$(function(){';
                    body_add +='$('+"'#product_category_"+insur_ct+"'"+').change(function(){';

                    ///////////////////////// start get_list 
                    body_add +='$.ajax({';
                    body_add +='    type:"post", ';
                    body_add +='    url: "includes/fx_insurance_products.php", ';
                    body_add +='    data: {';
                    body_add +='        action: "get_sub_cat",';
                    body_add +='        id_product_categories: $(this).val()';
                    body_add +='},';
                    body_add +='success: function(result) {';
                    body_add +='    var obj = eval("(" + result + ")");';
                    // body_add +='    console.log(result);';
                    body_add +='    $('+"'#sub_cat_"+insur_ct+" "+"option'"+').remove();';
                    body_add +='    var options = $('+"'#sub_cat_"+insur_ct+"'"+');';
                    body_add +='    $.each(obj, function(item) {';
                    body_add +='        options.append($("<option />").val(obj[item].id).text(obj[item].subcategorie));';
                    body_add +='    });';
                    body_add +='    }';
                    body_add +='  });';
                    body_add +='});';

                    body_add +='$('+"'#insurance_company_"+insur_ct+"'"+').change(function(){';
                    
                    body_add +='$.ajax({';
                    body_add +='    type:"post", ';
                    body_add +='    url: "includes/fx_insurance_products.php", ';
                    body_add +='    data: {';
                    body_add +='        action: "get_product",';
                    body_add +='        id_product_categories: $(this).val()';
                    body_add +='},';
                    body_add +='success: function(result) {';
                    body_add +='    var obj = eval("(" + result + ")");';
                    body_add +='    $('+"'#product_name_"+insur_ct+" "+" option'"+').remove();';
                    body_add +='    var options = $('+"'#product_name_"+insur_ct+"'"+');';
                    body_add +='    $.each(obj, function(item) {';
                    body_add +='        options.append($("<option />").val(obj[item].id).text(obj[item].product_name));';
                    body_add +='    });';                 
                    body_add +='}';                 
                    body_add +='});';

                    body_add +='$.ajax({';
                    body_add +='    type:"post", ';
                    body_add +='    url: "includes/fx_insurance_products.php", ';
                    body_add +='    data: {';
                    body_add +='        action: "get_agent",';
                    body_add +='        id_product_categories: $(this).val()';
                    body_add +='},';
                    body_add +='success: function(result) {';
                    body_add +='    var obj = eval("(" + result + ")");';
                    body_add +='    $('+"'#agent_name_"+insur_ct+" "+" option'"+').remove();';
                    body_add +='    var options = $('+"'#agent_name_"+insur_ct+"'"+');';
                    body_add +='    $.each(obj, function(item) {';
                    body_add +='        options.append($("<option />").val(obj[item].id).text(obj[item].agent_namefull));';
                    body_add +='    });';                 
                    body_add +='}';                 
                    body_add +='});';
                    ///////////////////////// End get_list 

                    body_add +='});';
                    body_add +='});';
                    body_add +='</'+'script>';
                    $("#insurance-section-clone").append(body_add);

                    var body_add ='';
                    body_add +='<script>';
                    body_add +='$(document).ready( function() {';
                    
                    body_add +='        function checkFileSize() {';
                    body_add +='            var fileInput = document.getElementById("imgInp'+contact_ct+'");';
                    body_add +='            var fileSize = fileInput.files[0].size;';
                    body_add +='            var maxSize = 5 * 1024 * 1024;';
                    body_add +='            if (fileSize > maxSize) {';
                    body_add +='                alert("File size exceeds 5MB. Please choose a file smaller than 5MB.");';
                    body_add +='                document.getElementById("imgInp'+contact_ct+'").value = "";';
                    body_add +='            }';
                    body_add +='        }';

                    body_add +='function readURL(input) {';
                    body_add +='    var fileName = document.getElementById("imgInp'+contact_ct+'").value;';
                    body_add +='    var idxDot = fileName.lastIndexOf(".") + 1;';
                    body_add +='    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();';
                    body_add +='    if (extFile=="pdf"){';
                    body_add +='        if (input.files && input.files[0]) {';
                    body_add +='            var reader = new FileReader();';
                    body_add +='            reader.readAsDataURL(input.files[0]);';
                    body_add +='        }';
                    body_add +='    }else{';
                    // body_add +='        var reader = new FileReader();';
                    // body_add +='       reader.readAsDataURL(input.files[0]);';
                    body_add +='        document.getElementById("imgInp'+contact_ct+'").value=null;';
                    body_add +='        alert("Only pdf files are allowed!");';
                    body_add +='    }}';
                    body_add +='$("#imgInp'+contact_ct+'").change(function(){';

                    body_add +='            $.ajax({';
                    body_add +='                url: "check_folder_size_json.php",';
                    body_add +='               type: "GET",';
                    body_add +='                success: function(response) {';
                    body_add +='                    data = JSON.parse(response);';

                    body_add +='                    if (data.alert) {';
                    body_add +='                        document.getElementById("imgInp'+contact_ct+'").value = null;';
                    body_add +='                        var message = "The folder at " + data.folderPath + " is nearly full. Remaining space: " + data.remainingSizeGB + " GB.";';
                    body_add +='                        alert(message);';
                    body_add +='                    }else{';

                    body_add +='        checkFileSize();';
                    body_add +='        readURL(this);';

                    body_add +='                    }';
                    body_add +='               }';
                    body_add +='            });';

                    body_add +='    });';
                    body_add +='});';
                    body_add +='</'+'script>';
                    $("#insurance-section-clone").append(body_add);

                    ///////////////////////////////////////////////////////////

					insur_ct++;
                });

                $(document).on('click', '.btn_remove_insur', function() {
                    var button_id = $(this).attr("id");
                    $('#insurance-section_' + button_id + '').remove();
                    $('#' + button_id + '').remove();
                });

				$('#product_category').change(function(){
    				$.ajax({
    					type:"post", 
    					url: "includes/fx_insurance_products.php", 
    					data: {
    						action: 'get_sub_cat',
    						id_product_categories: $(this).val()
    				},
					success: function(result) {
						
						var obj = eval("(" + result + ")");
						console.log(result);
						$("#sub_cat option").remove();
                        var options = $("#sub_cat");
						//don't forget error handling!
						
						$.each(obj, function(item) {
							//console.log(item);
							options.append($("<option />").val(obj[item].id).text(obj[item].subcategorie));
						});					
					}				  
					});
				});

                $('#insurance_company').change(function(){

                    product_object.html('');
                    $.get('get_product.php?id=' + $(this).val(),function(data){
                        var result = JSON.parse(data);
                        product_object.append($('<option></option>').val("").html("Select Product Name"));
                        document.getElementById("product_cat").value = "";
                        document.getElementById("sub_cat").value = "";
                        $.each(result, function(index, item){
                            product_object.append(
                            $('<option></option>').val(item.id).html(item.product_name)
                            );
                        });
                    });

                    var agent_name = $('#agent_name');
                    agent_name.html('');
                    $.get('get_agent.php?id=' + $(this).val(), function(data){
                        var result = JSON.parse(data);
                        agent_name.append($('<option></option>').val("").html("Select Agent Name"));
                        $.each(result, function(index, item){
                            agent_name.append(
                                // $('<option></option>').val(item.id).html(item.title_name+" "+item.first_name+" "+item.last_name)
                                $('<option></option>').val(item.id).html(item.agent_namefull)
                            );
                        });
                        $("#agent_name").selectpicker('refresh');
                    });
                });

                var product_object = $('#product_name');
                product_object.on('change', function(){
                    var  product_id = $(this).val();
                        document.getElementById("product_cat").value = "";
                        document.getElementById("sub_cat").value = "";
                        $.get('get_product_for_cat_and_sub.php?id=' + product_id, function(data){
                            var result = JSON.parse(data);
                            $.each(result, function(index, item){
                                document.getElementById("product_cat").value = item.id_product_categories;
                                document.getElementById("sub_cat").value = item.product_subcategories;
                            });
                        });
                });

                // $('#insurance_company').change(function(){
                //     $.ajax({
                //         type:"post", 
                //         url: "includes/fx_insurance_products.php", 
                //         data: {
                //             action: 'get_product',
                //             id_product_categories: $(this).val()
                //     },
                //     success: function(result) {
                //         var obj = eval("(" + result + ")");
                //         $("#product_name option").remove();
                //         var options = $("#product_name");
                //         //don't forget error handling!
                //         $.each(obj, function(item) {
                //             options.append($("<option />").val(obj[item].id).text(obj[item].product_name));
                //         });                 
                //     }                 
                //     });

                //     $.ajax({
                //         type:"post", 
                //         url: "includes/fx_insurance_products.php", 
                //         data: {
                //             action: 'get_agent',
                //             id_product_categories: $(this).val()
                //     },
                //     success: function(result) {
                //         var obj = eval("(" + result + ")");
                //         $("#agent_name option").remove();
                //         var options = $("#agent_name");
                //         //don't forget error handling!
                //         $.each(obj, function(item) {
                //             options.append($("<option />").val(obj[item].id).text(obj[item].agent_namefull));
                //         });                 
                //     }                 
                //     });

                // });

				
				$('.corporate').hide();
				$('#customer_type').change(function(){
				
					var val = $(this).val();
					//alert (val)
					if (val == 'Personal') {
						$('.corporate').hide();
						$('.personal').show();
                        document.getElementById('company_c_input').removeAttribute('required');
                        // document.getElementById('title_name').setAttribute("required","required");
                        document.getElementById('first_name').setAttribute("required","required");
                        // document.getElementById('last_name').setAttribute("required","required");
                        
					}
					if (val == 'Corporate') {
						$('.corporate').show();
						$('.personal').hide();
                        document.getElementById('company_c_input').setAttribute("required","required");
                        // document.getElementById('title_name').removeAttribute('required');
                        document.getElementById('first_name').removeAttribute('required');
                        // document.getElementById('last_name').removeAttribute('required');
                        
					}
				});
				
				$('#same_customer').click(function(){
				//alert($('#title_name').val())
					$('#contact_title_name').val($('#title_name').val());
					$('#contact_first_name').val($('#first_name').val());
                    $('#contact_last_name').val($('#last_name').val());
                    $('#contact_nick_name').val($('#nick_name').val());
                    $('#contact_mobile').val($('#mobile').val());
                    $('#contact_tel').val($('#tel').val());
                    $('#contact_email').val($('#email').val());
				});
				
            });
        </script>

<style>
	/*@media (min-width: 1340px){
		.label_left{
			max-width: 180px;
		}
		.label_right{
			max-width: 190px;
		}
	}*/
	.btn-default {
		color: #0C1830 !important;
		border-color: #102958 !important;
	}
	.bootstrap-select.btn-group .dropdown-toggle .caret {
		margin-top: -4px !important;
	}
</style>

</body>

    <?php include('includes/footer.php');?>
</html>

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
    <script src="assets/js/custom.js"></script>

<div id="loading-overlay">
    <img src="loading.gif" alt="Loading...">
</div>

<?php sqlsrv_close($conn); ?>