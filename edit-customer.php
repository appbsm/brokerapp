<?php
	session_start();
	error_reporting(0);

	include_once('includes/connect_sql.php');

	include_once('includes/fx_customer_db.php');
	include_once('includes/fx_address.php');
	include_once('includes/fx_agent_db.php');
	include_once('includes/fx_insurance_products.php');
	include('includes/config_path.php');

	if(strlen($_SESSION['alogin'])=="") {
		header('Location: logout.php');
	}

	$provinces = get_provinces($conn);
	$districts = get_district_by_province($conn, $provinces[0]['code']);
	$subdistricts = get_subdistrict_by_district($conn, $districts[0]['code']);
	$insurance_company = get_insurance_company ($conn);
	$product_categories = get_product_category($conn);
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!empty($_POST)) {

			$contacts = get_customer_contact ($conn,$_POST['id']);
			delete_contact_list($conn,$_POST,$contacts);
			$insurance_info = get_customer_insurance ($conn,$_POST['id']);
			delete_insurance_list_data($conn,$_POST,$insurance_info);
			update_customer($conn, $_POST,$sourceFilePath);     
			
		}
		// echo '<script>alert("Successfully edited information.")</script>';
		echo "<script>window.location.href ='customer-information.php'</script>";
		// header('Location: customer-information.php');
	}

	if (isset($_GET)) {
		$id = $_GET['id'];

		$customer_details = get_customer_by_id($conn, $id);

		$customer_value = $customer_details[0];
	   
		$contacts = get_customer_contact ($conn, $id);

		$insurance_info = get_customer_insurance ($conn, $id);
		$agents = get_agents($conn);
		$customer_level_list = get_customer_level($conn);
		$period_list = get_period($conn);
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

<style>
	@media (min-width: 1340px){
		.label_left{
			max-width: 180px;
		}
		.label_right{
			max-width: 190px;
		}
	}
	.btn-default {
		color: #0C1830 !important;
		border-color: #102958 !important;
	}
	.bootstrap-select.btn-group .dropdown-toggle .caret {
		margin-top: -4px !important;
	}
</style>

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
                    <li class="active">Edit Customer</li>
                </ul>
            </div>
        </div>
    </div>

<form method="post" action="edit-customer.php" enctype="multipart/form-data" onSubmit="return validateForm();" >
<input type="hidden" id="id" name="id" value="<?php echo $_GET['id'];?>">
<br>
<!-- <section class="section"> -->

<script>
var tax_id_check = "true";
var mobile_check = "true";

$(function(){
    var tax_id_object = $('#tax_id');

    var id = document.getElementById("id").value;

    tax_id_object.on('change', function(){
        var tax_id_value = $(this).val();
            $.get('get_customer_tax.php?tax_id=' + tax_id_value + '&id=' + id, function(data){
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
            // alert('get_customer_mobile.php?mobile=' + mobile_value + '&id=' + id);
            $.get('get_customer_mobile.php?mobile=' + mobile_value + '&id=' + id, function(data){
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

});

function validateForm() {
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
                            <div class="col">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Edit Customer</h2>
                            </div>
                            </div>
                        </div>
                        </div>
                    <!-- <div class="form-group row">
                            <div class="col-md-12 text-right">
                            <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                            </div>
                        </div> -->
    <div class="panel-body">
    <div class="form-group row col-md-10 col-md-offset-1">
        <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Cust. Type:</label>
            <div class="col-3">
            <select style="border-color:#102958;" id="customer_type" name="customer_type" class="form-control" id="default" readonly required>
                                <option value="Personal" <?php echo (trim($customer_value['customer_type']) == 'Personal') ? 'selected' : '';?> >Personal</option>
                                <option value="Corporate"<?php echo (trim($customer_value['customer_type']) == 'Corporate') ? 'selected' : '';?>  >Corporate</option>
            </select>
            </div>

            <div class="col-sm-2 label_left" >
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" <?php echo ($customer_value['status'] == 1) ? 'checked="checked"' : '' ?> name="check_active">
            <label style="color: #0C1830;" class="form-check-label" for="flexCheckDefault">
            &nbsp;&nbsp;&nbsp;&nbsp; Active    </label>
            </div>
            <div class="col-4 ">
            </div>

    </div>  

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Cust. ID:</label>
                <div class="col-3">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="customer_id" required="required" class="form-control" id="success" value="<?php echo $customer_value['customer_id'];?>" readOnly>               
                </div>

                <div class="col-sm-1 " >
                        <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Cust. Level:</label>
                </div>
                <div class="col-2 ">
                        <select id="customer_level" name="customer_level" style="border-color:#102958;"  class="form-control" required>
                            <?php foreach ($customer_level_list as $pc) {?>
                                <option value="<?php echo $pc['id'];?>" data-description="<?php echo $pc['description'];?>"
                                    <?php if ($pc['id']==$customer_value['customer_level']) { echo 'selected="selected"'; } ?>
                                    ><?php echo $pc['level_name'];?></option>
                            <?php }?>
                        </select>
                </div> 

                 <div class="col-4 ">
                    <input id="customer_de" name="customer_de" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  readOnly> 
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
                    <div class="col-sm-2   corporate"  >
                        <label  style="color: #102958;" ><small><font color="red">*</font></small>Company name:</label>
                    </div>
                    <div class="col corporate">
                        <input id="company_c_input" name="company_name" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" value="<?php echo $customer_value['company_name'];?>" required>    
                    </div>
                </div>

            <div class="form-group row col-md-10 col-md-offset-1 personal">
                <div id="label_title" class="col-sm-2 personal"  >
                    <label style="color: #102958;" >Title:</label>
                </div>
                <div id="col_title" class="col-3 personal">
                <select style="border-color:#102958;" id="title_name" name="title_name" class="form-control personal"  >
                        <option value="Mr." <?php echo (trim($customer_value['title_name'])=="Mr.") ? 'selected' : '';?>>Mr.</option>
                        <option value="Ms." <?php echo (trim($customer_value['title_name'])=="Ms.") ? 'selected' : '';?>>Ms.</option>
                        <option value="Mrs." <?php echo (trim($customer_value['title_name'])=="Mrs.") ? 'selected' : '';?>>Mrs.</option>
                    </select>    
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1 personal">
                <div id="label_fname" class="col-sm-2   personal"  >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>First name:</label>
                </div>
                <div class="col-4 personal">
                    <input id="first_name" name="first_name" minlength="1" maxlength="100" style="color: #0C1830;border-color:#102958;" type="text"  class="form-control" value="<?php echo $customer_value['first_name'];?>" required>
                </div>
				<div class="col-sm-2   personal"  >
                    <label id="label_lname" style="color: #102958;" >Last name:</label>
                </div>
                <div id="col_lname" class="col-4 personal">
                    <input id="last_name" minlength="1" maxlength="100" style="color: #0C1830;border-color:#102958;" type="text" name="last_name" class="form-control" value="<?php echo $customer_value['last_name'];?>" >
                </div>
            </div>
			
			<div class="form-group row col-md-10 col-md-offset-1 personal">
                <div class="col-sm-2   personal"  >
                    <label style="color: #102958;" >Nickname:</label>
                </div>
                <div class="col-4 personal">
                    <input name="nick_name" id="nick_name" minlength="1" maxlength="100" style="color: #0C1830;border-color:#102958;" type="text"  class="form-control"  value="<?php echo $customer_value['nick_name'];?>">
                </div>
			</div>
			
			<div class="form-group row col-md-10 col-md-offset-1">
				<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Tax ID / Passport ID:</label>
                <div class="col-4">
                    <!--<input minlength="13" maxlength="13" style="color: #0C1830;border-color:#102958;" type="text" name="tax_id" class="form-control" id="success" value="<?php echo $customer_value['tax_id'];?>" required pattern="\d{13}" >-->
					<input id="tax_id" name="tax_id" minlength="1" maxlength="13" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" id="success" value="<?php echo $customer_value['tax_id'];?>" >               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
                <div class="col-4">
                    <input name="email" id="email" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="email"  class="form-control"  value="<?php echo $customer_value['email'];?>" >
                </div>
            </div>
    
            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Mobile:</label>
                <div class="col-4">
                    <input id="mobile" name="mobile" minlength="10" maxlength="12" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" id="success" value="<?php echo $customer_value['mobile'];?>" pattern="\d{3}-\d{3}-\d{4}" >
                </div>
				<script>
					document.getElementById('mobile').addEventListener('input', function (e) {
						var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
						e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
					});
				</script>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Tel:</label>
                <div class="col-4">
                    <input name="tel" id="tel" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text"  class="form-control"  value="<?php echo $customer_value['tel'];?>">
               
                </div>
            </div>
			
            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col">
                    <div class="panel-title" style="color: #102958;" >
                        <h2 class="title">Address</h2>
                    </div>
                </div>
            </div>
			
            <!--
             <div class="form-group row col-md-10 col-md-offset-1">
               <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Address No:</label>
                <div class="col-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="address_number"  class="form-control"  value="<?php echo $customer_value['address_number'];?>" required>
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Building Name:</label>
                <div class="col-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="building_name"  class="form-control"  value="<?php echo $customer_value['building_name'];?>">
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Soi:</label>
                <div class="col-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="soi"  class="form-control"  value="<?php echo $customer_value['soi'];?>">
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Road:</label>
                <div class="col-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="road" class="form-control"  value="<?php echo $customer_value['road'];?>">
                </div>
            </div>
			-->
			            
             <div class="form-group row col-md-10 col-md-offset-1">
               <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Address No:</label>
                <div class="col-2">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="address_number"  class="form-control"  value="<?php echo $customer_value['address_number'];?>" required>
               
                </div>
                
				 <label style="color: #102958;" for="staticEmail" class="col-sm-1 col-form-label">Soi:</label>
                <div class="col-3">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="soi"  class="form-control"  value="<?php echo $customer_value['soi'];?>">
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-1 col-form-label">Road:</label>
                <div class="col-3">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="road" class="form-control"  value="<?php echo $customer_value['road'];?>">
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
               <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Building Name:</label>
                <div class="col">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="building_name"  class="form-control"  value="<?php echo $customer_value['building_name'];?>">
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Province:</label>
                <div class="col-4">
                    <select style="border-color:#102958;" name="province" class="form-control selectpicker" id="province" data-live-search="true" required >
                        <?php foreach ($provinces as $province) { ?>
                        <option value="<?php echo $province['code']?>" <?php echo ($province['code'] == $customer_value['province']) ? 'selected' : '';?>><?php echo $province['name_en'];?></option>
                        <?php } ?>
                    </select>
               
                </div>
                
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>District:</label>
                <div class="col-4">
                     <select style="border-color:#102958;" name="district"  class="form-control selectpicker" id="district" data-live-search="true" required >
                    <?php 
                        if(trim($customer_value['province'])!=""){
                           $districts = get_district_by_province($conn, $customer_value['province']);
                        }
                    foreach ($districts as $district) { ?>
                        <option value="<?php echo $district['code']?>" <?php echo ($district['code'] == $customer_value['district']) ? 'selected' : '';?>><?php echo $district['name_en'];?></option>
                        <?php } ?>                  
                    </select>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Sub-district:</label>
                <div class="col-4">
                    <!-- <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" > -->

                    <select style="border-color:#102958;" name="sub_district" class="form-control selectpicker" id="subdistrict" data-live-search="true" required >   
                    <?php 
                    $subdistricts = get_subdistrict_by_district($conn, $customer_value['district']);
                 //print_r($subdistricts);
                    foreach ($subdistricts as $sub) { ?>
                        <option value="<?php echo $sub['code']?>"<?php echo ($sub['code'] == $customer_value['sub_district']) ? 'selected' : '';?>><?php echo $sub['name_en'];?></option>
                        <?php } ?>                  
                    </select>
                </div>
                
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Post Code:</label>
                <div class="col-4">
                     <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="post_code" id="post_code" class="form-control" value="<?php echo $customer_value['post_code'];?>" required>
                </div>
            </div>   

        </div>
    </div>                             
    </div>
</div>
</div>

<!-- Container Start -->
<div class="container-fluid">
        <!-- 1 Start -->
        <div class="row">
        <div  class="col-sm-12 text-right  ">
            <div style="padding-top: 10px;">
             
             <button style="background-color: #0275d8;color: #F9FAFA;" type="button" name="add_more_contacts" class="btn  btn-labeled" id="add-con">+ Add More Contact<span class="btn-label btn-label-right"><i class="fa "></i></span></button>
            </div>
        </div>
        </div>
        <!-- 1 End -->
        
        <!-- Contact Section Start -->
        <?php 
        $start_contact = "true";
        $x = 0;
        foreach ($contacts as $c) { $x++;
        //print_r($c);
        ?>

        <?php if($start_contact=="false"){  ?>
            <div class="col text-right">
                <button id="<?php echo $x; ?>"  type="button" class="btn btn_remove_con" name="remove" style="background-color: #0275d8;color: #F9FAFA;"  >X</button>
            </div>&nbsp;&nbsp;

            <script type="text/javascript">
                $(document).on('click', '.btn_remove_con', function() {
                var button_id = $(this).attr("id");
                    $('#contact-section_' + button_id + '').remove();
                    $('#' + button_id + '').remove();
                });
            </script>
        <? } ?>


        <div class="row" id="contact-section_<?php echo $x; ?>">
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

                            <?php if($start_contact=="true"){ $start_contact = "false"; ?>
                            <div class="col  "  >           
                                <div  class="form-check " style="top:15px;">
                                    <input id="same_customer" name="same_customer" class="form-check-input same_customer" type="checkbox" id="">
                                    <label style="color: #0C1830;" class="form-check-label" for="SameCheck">
                                        &nbsp;&nbsp;&nbsp;&nbsp; Same Customer Name
                                    </label>
                                </div>
                            </div>  
                            <? } ?>

                            </div>
                        </div>
                    </div>
   
        <div class="panel-body">
            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Title:</label>
                <!-- hidden="ture" -->
                <input hidden="ture" id="id_contact<? echo $x; ?>" name="id_contact[]" value="<?php echo $c['id'];?>" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" id="success"  >
                </input>
                <div class="col-3">
                     <select name="contact_title_name[]" id="contact_title_name<?php echo $x; ?>" style="border-color:#102958;"  class="form-control" >
                            <option value="Mr." <?php echo (trim($c['title_name'])=="Mr.") ? 'selected' : '';?>>Mr.</option>
                                <option value="Ms." <?php echo (trim($c['title_name'])=="Ms.") ? 'selected' : '';?>>Ms.</option>
                                <option value="Mrs." <?php echo (trim($c['title_name'])=="Mrs.") ? 'selected' : '';?>>Mrs.</option>       
                        </select>    
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>First name:</label>
                <div class="col-4">
                    <input name="contact_first_name[]" id="contact_first_name<?php echo $x; ?>" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" value="<?php echo $c['first_name'];?>" required>
                </div>
				<label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Last name:</label>
                <div class="col-4">
                    <input name="contact_last_name[]" id="contact_last_name<?php echo $x; ?>" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" value="<?php echo $c['last_name'];?>" >
                </div>
            </div>
			
			<div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" class="col-sm-2 col-form-label">Nickname:</label>
                <div class="col-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="contact_nick_name[]" id="contact_nick_name<?php echo $x; ?>" class="form-control" value="<?php echo $c['nick_name'];?>">
                </div>
			</div>
			
			<div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Mobile:</label>
                <div class="col-4">
                    <input name="contact_mobile[]" id="contact_mobile<?php echo $x; ?>" minlength="10" maxlength="12" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" value="<?php echo $c['mobile'];?>" pattern="\d{3}-\d{3}-\d{4}" >
                </div>
				<script>
					document.getElementById('contact_mobile<?php echo $x; ?>').addEventListener('input', function (e) {
						var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
						e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
					});
				</script>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Tel:</label>
                <div class="col-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="contact_tel[]" id="contact_tel<?php echo $x; ?>" class="form-control" value="<?php echo $c['tel']?>">
                </div>
            </div>
			
			<div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
                <div class="col-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="email" name="contact_email[]" id="contact_email<?php echo $x; ?>" class="form-control" value="<?php echo $c['email']?>" >
                </div>
				<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Line ID:</label>
                <div class="col-4">
                    <input id="contact_line_id<?php echo $x; ?>" name="contact_line_id[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" value="<?php echo $c['line_id']?>" >
                </div>
            </div>
            
            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Position:</label>
                <div class="col-4">
                    <input id="contact_position<?php echo $x; ?>" name="contact_position[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" value="<?php echo $c['position'];?>" >
                </div>
                <label style="color: #102958;" class="col-sm-2 ">Department:</label>
                <div class="col-4">
                    <input id="department<?php echo $x; ?>" name="department[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" value="<?php echo $c['department'];?>" >
                </div>
            </div>

			<div class="form-group row col-md-10 col-md-offset-1">
				<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label label-right">Remark:</label>
				<div class="col-10">
					<textarea id="contact_remark<?php echo $x; ?>" name="contact_remark[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" class="form-control" rows="2"><?php echo $c['remark'];?></textarea>
				</div>  
			</div>

        <div class="form-group row col-md-10 col-md-offset-1">
            <div class="col-sm-2">
            </div>  
            <div class="col-4">
                <div class="form-check" style="top:5px">
                    <!-- hidden="true" -->
                <input id="hid_default<? echo $x; ?>" name="hid_default[]" hidden="true" type="text" value="<? echo $x; ?>" >
                <input id="id_default<? echo $x; ?>" name="default_contact[]" class="form-check-input" type="radio" value="<? echo $x; ?>" <?php if($c['default_contact']=='1' ){ echo "checked";} ?> >
                        <label style="color: #0C1830;" class="form-check-label" for="flexCheckDefault">
                    &nbsp;&nbsp;&nbsp;&nbsp; Default Contact
                    </label>
                  </div>
            </div>  
        </div>

          
            </div>
        </div>
        
        
    </div> 
    
</div> 
<?php } ?>
<!-- Contact Section End -->

<div id="contact-section-clone" class="contact-section-clone"></div>

</div> 

<!-- Insurance Info Start -->
<div class="container-fluid">
    <!-- 1 Start -->
        <div class="row">
        <div  class="col-sm-12 text-right  ">
            <div style="padding-top: 10px;">
             
             <button style="background-color: #0275d8;color: #F9FAFA;" type="button" name="add_more_insurance" class="btn  btn-labeled" id="add-insur">+ Add More Policy<span class="btn-label btn-label-right"><i class="fa "></i></span></button>
            </div>
        </div>
        </div>
        <!-- 1 End -->
    
        <?php 
        $int_insu =0;
        $start_insurance = "true";
        foreach ($insurance_info as $i) { $int_insu++
        ?>

        <?php if($start_insurance!="true"){  ?>
            <div class="col text-right">
                <button id="<?php echo $int_insu; ?>"  type="button" class="btn btn_remove_con" name="remove" style="background-color: #0275d8;color: #F9FAFA;"  >X</button>
            </div>&nbsp;&nbsp;

            <script type="text/javascript">
                $(document).on('click', '.btn_remove_con', function() {
                var button_id = $(this).attr("id");
                    $('#insurance-section_' + button_id + '').remove();
                    $('#' + button_id + '').remove();
                });
            </script>
        <? }else{ $start_insurance="false"; } ?>


        <div class="row" id="insurance-section_<?php echo $int_insu; ?>">

            <div class="col-md-12 ">
                <div class="panel">
                   <div class="panel-heading">
                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col-sm-12">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Policy information</h2>
                            </div>
                        </div>
                        </div>
                    </div>

        <div class="panel-body">
            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Policy No:</label>
                <div class="col-4">
                    <!-- hidden="true"  -->
                <input hidden="true" id="id_insurance_info<? echo $int_insu; ?>" name="id_insurance_info[]" value="<?php echo $i['id'];?>" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" id="success" >
                </input>
                    <input id="policy_no" name="policy_no[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text"  class="form-control"  value="<?php echo $i['policy_no'];?>">
                </div>
                 <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Period:</label>
                <div class="col-4">
                    <select name="period[]" id="period" style="color: #0C1830;border-color:#102958;" class="form-control" value="" >
                     <?php foreach ($period_list as $pc) { ?>
                        <option value="<?php echo $pc['id'];?>"
                            <?php if ($pc['id']==$i['period']) { echo 'selected="selected"'; } ?>
                        ><?php echo $pc['period'];?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Product Category:</label>
                <div class="col-4">
                    <select name="product_category[]" id="product_category<?php echo $int_insu; ?>" style="color: #0C1830;border-color:#102958;"class="form-control" >
                    <option value="">Select Category</option>
                    <?php foreach ($product_categories as $pc) {?>
                    <option value="<?php echo $pc['id'];?>" <?php if($i['product_category'] == $pc['id']){ echo "selected"; }
                    ?>><?php echo $pc['categorie'];?></option>
                    <?php }?>
                </select>
                </div>

                <label style="color: #102958;"  class="col-sm-2 label_right">Sub Categories:</label>
                <div class="col-4">
                    <select name="sub_cat[]" id="sub_cat<?php echo $int_insu; ?>" style="color: #0C1830;border-color:#102958;"class="form-control" >
                    <option value="">Select Sub Categories</option>                    
                    </select>
                </div>
            </div>

        <?php if($i['product_category']!=""){ ?>
            <script type="text/javascript">
                $.ajax({
                        type:"post", 
                        url: "includes/fx_insurance_products.php", 
                        data: {
                            action: 'get_sub_cat',
                            id_product_categories: <?php echo $i['product_category']; ?>
                    },
                    success: function(result) {
                        var obj = eval("(" + result + ")");
                        console.log(result);
                        $("#sub_cat<?php echo $int_insu; ?> option").remove();
                        var options = $("#sub_cat<?php echo $int_insu; ?>");
                        $.each(obj, function(item) {
                            options.append($("<option />").val(obj[item].id).text(obj[item].subcategorie));
                        }); 
                    document.getElementById('sub_cat<?php echo $int_insu; ?>').value = "<?php echo $i['sub_categories']; ?>";
                    }                 
                });
            </script>
        <?php } ?>

            <script type="text/javascript">
                $('#product_category<?php echo $int_insu; ?>').change(function(){
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
                        $("#sub_cat<?php echo $int_insu; ?> option").remove();
                        var options = $("#sub_cat<?php echo $int_insu; ?>");
                        //don't forget error handling!
                        
                        $.each(obj, function(item) {
                            options.append($("<option />").val(obj[item].id).text(obj[item].subcategorie));
                        });                 
                    }                 
                    });
                });
            </script>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Partner Company:</label>
                <div class="col-4">
                <select name="insurance_company[]" id="insurance_company<?php echo $int_insu; ?>" style="color: #0C1830;border-color:#102958;"class="form-control" value="<?php echo $i['insurance_company'];?>">
                    <option value="">Select Partner</option>
                    <?php foreach ($insurance_company as $insurance) {?>
                    <option value="<?php echo $insurance['id'];?>" <?php echo ($insurance['id'] == $i['insurance_company_id'] ) ? 'selected' : '';?>><?php echo $insurance['insurance_company'];?></option>
                    <?php }?>
                </select>
                </div>

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Product Name:</label>
                <div class="col-4">
                    <select name="product_name[]" id="product_name<?php echo $int_insu; ?>" style="color: #0C1830;border-color:#102958;"class="form-control"   >
                    <option value="">Select Product</option>                    
                    </select>
               
                </div>
            </div>

             <script type="text/javascript">
                $.ajax({
                        type:"post", 
                        url: "includes/fx_insurance_products.php", 
                        data: {
                            action: 'get_product',
                            id_product_categories: <?php echo $i['insurance_company_id']; ?>
                    },
                    success: function(result) {
                        var obj = eval("(" + result + ")");
                        console.log(result);
                        $("#product_name<?php echo $int_insu; ?> option").remove();
                        var options = $("#product_name<?php echo $int_insu; ?>");
                        //don't forget error handling!
                        $.each(obj, function(item) {
                            //console.log(item);
                            options.append($("<option />").val(obj[item].id).text(obj[item].product_name));
                        }); 
                    document.getElementById('product_name<?php echo $int_insu; ?>').value = "<?php echo $i['product_id']; ?>";
                    }                 
                });

                $.ajax({
                        type:"post", 
                        url: "includes/fx_insurance_products.php", 
                        data: {
                            action: 'get_agent',
                            id_product_categories: <?php echo $i['insurance_company_id']; ?>
                    },
                    success: function(result) {
                        var obj = eval("(" + result + ")");
                        console.log(result);
                        $("#agent_name<?php echo $int_insu; ?> option").remove();
                        var options = $("#agent_name<?php echo $int_insu; ?>");
                        //don't forget error handling!
                        $.each(obj, function(item) {
                            //console.log(item);
                            options.append($("<option />").val(obj[item].id).text(obj[item].agent_namefull));
                        }); 
                    document.getElementById('agent_name<?php echo $int_insu; ?>').value = "<?php echo $i['agent_id']; ?>";
                    }                 
                });
                 
                $('#insurance_company<?php echo $int_insu; ?>').change(function(){
                    $.ajax({
                        type:"post", 
                        url: "includes/fx_insurance_products.php", 
                        data: {
                            action: 'get_product',
                            id_product_categories: $(this).val()
                    },
                    success: function(result) {
                        var obj = eval("(" + result + ")");
                        $("#product_name<?php echo $int_insu; ?> option").remove();
                        var options = $("#product_name<?php echo $int_insu; ?>");
                        $.each(obj, function(item) {
                            //console.log(item);
                            options.append($("<option />").val(obj[item].id).text(obj[item].product_name));
                        });                 
                    }                 
                    });

                    $.ajax({
                        type:"post", 
                        url: "includes/fx_insurance_products.php", 
                        data: {
                            action: 'get_agent',
                            id_product_categories: $(this).val()
                    },
                    success: function(result) {
                        var obj = eval("(" + result + ")");
                        console.log(result);
                        $("#agent_name<?php echo $int_insu; ?> option").remove();
                        var options = $("#agent_name<?php echo $int_insu; ?>");
                        $.each(obj, function(item) {
                            //console.log(item);
                            options.append($("<option />").val(obj[item].id).text(obj[item].agent_namefull));
                        }); 
                    }                 
                    });

                });
            </script>

<script>
  $(document).ready(function(){
    $('#start_date<?php echo $int_insu; ?>').datepicker({
      format: 'dd-mm-yyyy',
      language: 'en'
    });
    $('#end_date<?php echo $int_insu; ?>').datepicker({
      format: 'dd-mm-yyyy',
      language: 'en'
    });
  });
</script>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Start date:</label>
                <div class="col-4">
                <?php 
               $s_date = '';
               $e_date = '';              
                ?>
                    <input id="start_date<?php echo $int_insu; ?>" name="start_date[]" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  value="<?php echo $i['start_date_f']; ?>" placeholder="dd-mm-yyyy">
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">End date:</label>
                <div class="col-4">
                    <input id="end_date<?php echo $int_insu; ?>" name="end_date[]" style="color: #0C1830;border-color:#102958;" type="text"  class="form-control"  value="<?php echo $i['end_date_f']; ?>" placeholder="dd-mm-yyyy">
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Premium Rate:</label>
                <div class="col-4">
                    <input id="premium_rate" name="premium_rate[]" step="0.01" min="0" style="color: #0C1830;border-color:#102958;" type="number" class="form-control"  value="<?php echo $i['premium_rate']?>">
               
                </div>

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Status:</label>
                <div class="col-4">
                <select id="insurance_status" name="insurance_status[]" onchange="ClickChange()" style="border-color:#102958;" class="form-control" >
                    <option value="New" <?php echo ($i['status'] == 'New') ? 'selected' : ''; ?>>New</option>
                    <option value="Follow up" <?php echo ($i['status'] == 'Follow up') ? 'selected' : ''; ?>>Follow up</option>
                    <option value="Renew" <?php echo ($i['status'] == 'Renew') ? 'selected' : ''; ?>>Renew</option>
                    <option value="Wait" <?php echo ($i['status'] == 'Wait') ? 'selected' : ''; ?>>Wait</option>
                    <option value="Not renew" <?php echo ($i['status'] == 'Not renew') ? 'selected' : ''; ?>>Not renew</option>
                </select>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Agent Name:</label>
                
				<div class="col-4">
					<select id="agent_name<?php echo $int_insu; ?>" name="agent_name[]" style="color: #0C1830;border-color:#102958;"class="form-control" value="" >
					   <option value="">Select Agent</option>
						<?php //foreach ($agents  as $a) { ?>
							<!-- <option value="<?php //echo $a['id']?>" <?php //echo ($i['agent_id'] == $a['id']) ? 'selected' :' ';?>><?php //echo $a['first_name'].' '.$a['last_name'];?></option> -->
						<?php //} ?>      
					</select>
				</div>

				<label style="color: #102958;" class="col-sm-2 col-form-label">Upload Documents :</label>                
				<div class="col-4">
					<input id="imgInp<?php echo $int_insu; ?>" name="file_d[]" type="file" style="width: 100%;" accept="application/pdf" >
					<?php if(trim($i['file_name_uniqid'])!=""){ ?>
					<div id="download_clone" class="columns download">
						<p>
							<a  href="image.php?filename=<?php echo trim($i['file_name_uniqid']); ?>"  class="button" download="<?php echo trim($i['file_name']); ?>" download><i class="fa fa-download" ></i>Download <?php echo trim($i['file_name']); ?></a>
						</p>
					</div>
					<?php } ?>
				
				</div>                     
            </div>


			<script>
				$(document).ready(function () {
					function checkFileSize() {
						var fileInput = document.getElementById('imgInp<?php echo $int_insu; ?>');
						var fileSize = fileInput.files[0].size; // ขนาดของไฟล์ใน bytes
						var maxSize = 5 * 1024 * 1024; // ขนาดสูงสุดที่อนุญาตให้อัพโหลดเป็น bytes (5 MB)

						if (fileSize > maxSize) {
							alert('File size exceeds 5MB. Please choose a file smaller than 5MB.');
							// ล้างค่าไฟล์ที่เลือก
							document.getElementById('imgInp<?php echo $int_insu; ?>').value = "";
						}
					}

					function readURL(input) {
						var fileName = document.getElementById("imgInp<?php echo $int_insu; ?>").value;
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
							document.getElementById("imgInp<?php echo $int_insu; ?>").value = null;
							// alert("เฉพาะไฟล์ PDF เท่านั้นที่อนุญาต!");
                            alert("Only PDF files are allowed!");
						}
					}

					$("#imgInp<?php echo $int_insu; ?>").change(function () {

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
<?php } ?>

<?php $int_insu =0; if(count($insurance_info)==0){ $int_insu++ ?>

<div class="row" id="insurance-section_<?php echo $int_insu; ?>">

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
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Policy No:</label>
                <div class="col-4">
                    <!-- hidden="true"  -->
                <input hidden="true" id="id_insurance_info<? echo $int_insu; ?>" name="id_insurance_info[]" value="" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" id="success" >
                </input>
                    <input id="policy_no" name="policy_no[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text"  class="form-control"  value="<?php echo $i['policy_no'];?>">
                </div>
                 <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Period:</label>
                <div class="col-2">
                    <select name="period[]" id="period" style="color: #0C1830;border-color:#102958;" class="form-control" value="" >
                     <?php foreach ($period_list as $pc) { ?>
                        <option value="<?php echo $pc['id'];?>"
                            <?php if ($pc['id']==$i['period']) { echo 'selected="selected"'; } ?>
                        ><?php echo $pc['period'];?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Prod. Category:</label>
                <div class="col-4">
                    <select name="product_category[]" id="product_category<?php echo $int_insu; ?>" style="color: #0C1830;border-color:#102958;"class="form-control" >
                    <option value="">Select Category</option>
                    <?php foreach ($product_categories as $pc) {?>
                    <option value="<?php echo $pc['id'];?>" <?php if($i['product_category'] == $pc['id']){ echo "selected"; }
                    ?>><?php echo $pc['categorie'];?></option>
                    <?php }?>
                </select>
                </div>

                <label style="color: #102958;"  class="col-sm-2 col-form-label">Sub Categories:</label>
                <div class="col-4">
                    <select name="sub_cat[]" id="sub_cat<?php echo $int_insu; ?>" style="color: #0C1830;border-color:#102958;"class="form-control" >
                    <option value="">Select Sub Categories</option>                    
                    </select>
                </div>
            </div>
        <?php if($i['product_category']!=""){ ?>
            <script type="text/javascript">
                $.ajax({
                        type:"post", 
                        url: "includes/fx_insurance_products.php", 
                        data: {
                            action: 'get_sub_cat',
                            id_product_categories: <?php echo $i['product_category']; ?>
                    },
                    success: function(result) {
                        var obj = eval("(" + result + ")");
                        console.log(result);
                        $("#sub_cat<?php echo $int_insu; ?> option").remove();
                        var options = $("#sub_cat<?php echo $int_insu; ?>");
                        $.each(obj, function(item) {
                            options.append($("<option />").val(obj[item].id).text(obj[item].subcategorie));
                        }); 
                    document.getElementById('sub_cat<?php echo $int_insu; ?>').value = "<?php echo $i['sub_categories']; ?>";
                    }                 
                });
            </script>
        <?php } ?>
            <script type="text/javascript">
                $('#product_category<?php echo $int_insu; ?>').change(function(){
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
                        $("#sub_cat<?php echo $int_insu; ?> option").remove();
                        var options = $("#sub_cat<?php echo $int_insu; ?>");
                        //don't forget error handling!
                        
                        $.each(obj, function(item) {
                            options.append($("<option />").val(obj[item].id).text(obj[item].subcategorie));
                        });                 
                    }               
                    });
                });
            </script>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Policy Company:</label>
                <div class="col-4">
                <select name="insurance_company[]" id="insurance_company<?php echo $int_insu; ?>" style="color: #0C1830;border-color:#102958;"class="form-control" value="<?php echo $i['insurance_company'];?>">
                    <option value="">Select Partner</option>
                    <?php foreach ($insurance_company as $insurance) {?>
                    <option value="<?php echo $insurance['id'];?>" <?php echo ($insurance['id'] == $i['insurance_company_id'] ) ? 'selected' : '';?>><?php echo $insurance['insurance_company'];?></option>
                    <?php }?>
                </select>
                </div>

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Prod. Name:</label>
                <div class="col-4">
                    <select name="product_name[]" id="product_name<?php echo $int_insu; ?>" style="color: #0C1830;border-color:#102958;"class="form-control"   >
                    <option value="">Select Product</option>                    
                    </select>
               
                </div>
            </div>

            <script type="text/javascript">

                $('#insurance_company<?php echo $int_insu; ?>').change(function(){
                    // alert('not checked');
                    $.ajax({
                        type:"post", 
                        url: "includes/fx_insurance_products.php", 
                        data: {
                            action: 'get_product',
                            id_product_categories: $(this).val()
                    },
                    success: function(result) {
                        var obj = eval("(" + result + ")");
                        console.log(result);
                        $("#product_name<?php echo $int_insu; ?> option").remove();
                        var options = $("#product_name<?php echo $int_insu; ?>");
                        //don't forget error handling!
                        $.each(obj, function(item) {
                            //console.log(item);
                            options.append($("<option />").val(obj[item].id).text(obj[item].product_name));
                        });                 
                    }                 
                    });

                    $.ajax({
                        type:"post", 
                        url: "includes/fx_insurance_products.php", 
                        data: {
                            action: 'get_agent',
                            id_product_categories: $(this).val()
                        },
                        success: function(result) {
                            var obj = eval("(" + result + ")");
                            console.log(result);
                            $("#agent_name<?php echo $int_insu; ?> option").remove();
                            var options = $("#agent_name<?php echo $int_insu; ?>");
                            $.each(obj, function(item) {
                                options.append($("<option />").val(obj[item].id).text(obj[item].agent_namefull));
                            });
                        }                 
                    });

                });
            </script>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Start date:</label>
                <div class="col-2">
                <?php 
               $s_date = '';
               $e_date = '';              
                ?>
                    <input id="start_date" name="start_date[]" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  value="<?php echo $i['start_date_f']; ?>" placeholder="dd-mm-yyyy">
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">End date:</label>
                <div class="col-2">
                    <input id="end_date" name="end_date[]" style="color: #0C1830;border-color:#102958;" type="text"  class="form-control"  value="<?php echo $i['end_date_f']; ?>" placeholder="dd-mm-yyyy">
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Premium Rate:</label>
                <div class="col-2">
                    <input id="premium_rate" name="premium_rate[]" step="0.01" min="0" style="color: #0C1830;border-color:#102958;" type="number" class="form-control"  value="<?php echo $i['premium_rate']?>">
               
                </div>

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Status:</label>
                <div class="col-2">
                <select id="insurance_status" name="insurance_status[]" onchange="ClickChange()" style="border-color:#102958;" class="form-control" >
                    <option value="New" <?php echo ($i['status'] == 'New') ? 'selected' : ''; ?>>New</option>
                    <option value="Follow up" <?php echo ($i['status'] == 'Follow up') ? 'selected' : ''; ?>>Follow up</option>
                    <option value="Renew" <?php echo ($i['status'] == 'Renew') ? 'selected' : ''; ?>>Renew</option>
                    <option value="Wait" <?php echo ($i['status'] == 'Wait') ? 'selected' : ''; ?>>Wait</option>
                    <option value="Not renew" <?php echo ($i['status'] == 'Not renew') ? 'selected' : ''; ?>>Not renew</option>
                </select>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Agent Name:</label>
                
            <div class="col-4">
                <select id="agent_name<?php echo $int_insu; ?>" name="agent_name[]" style="color: #0C1830;border-color:#102958;"class="form-control" value="" >
                   <option value="">Select Agent</option>
                        <?php //foreach ($agents  as $a) { ?>
                        <!-- <option value="<?php //echo $a['id']?>" <?php //echo ($i['agent_id'] == $a['id']) ? 'selected' :' ';?>><?php //echo $a['first_name'].' '.$a['last_name'];?></option> -->
                        <?php //} ?>      
                </select>
            </div>

            <label style="color: #102958;" class="col-sm-2 col-form-label">Upload Documents:</label>                
            <div class="col-4">
                
                <input name="file_d[]" type="file" style="width: 100%;"  id="imgInp" accept="application/pdf" >
                 <?php if(trim($i['file_name_uniqid'])!=""){ ?>
                <div class="columns download">
                    <p>
                        <a href="image.php?filename="<?php echo trim($i['file_name_uniqid']); ?>" class="button" download="<?php echo trim($i['file_name']); ?>" download><i class="fa fa-download"></i>Download <?php echo trim($i['file_name']); ?></a>
                    </p>
                </div>
            <?php } ?>

            
            </div>                     

            </div>
           
        </div>
    </div>                             
    </div> <!--  -->
    
</div> <!-- INSURANCE SECTION END -->

<?php } ?>

<div id="insurance-section-clone" class="insurance-section-clone"></div>    
</div>
<!-- Insurance Info End -->

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel">
                <div class="panel-body">

                <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-md-12">
                    <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                    </button>
                </div>
                </div>
 
                </div>
            </div> 
        </div>  
    </div>  
</div> 

<!-- Container  End-->

    <br><br><br>
</form>
  
        <?php 
            if(trim($customer_value['customer_type']) == 'Personal'){
                echo '<script>$(".corporate").hide();';
                echo "document.getElementById('company_c_input').removeAttribute('required');";
                echo "document.getElementById('title_name').setAttribute('required','required');";
                echo "document.getElementById('first_name').setAttribute('required','required');";
                echo "document.getElementById('last_name').setAttribute('required','required');";
                echo '</script>';
            }else{
                echo '<script>$(".personal").hide();';
                echo "document.getElementById('company_c_input').setAttribute('required','required');";
                echo "document.getElementById('title_name').removeAttribute('required');";
                echo "document.getElementById('first_name').removeAttribute('required');";
                echo "document.getElementById('last_name').removeAttribute('required');";
                echo '</script>';
            }  
        ?>
        <script>
            $(function($) {
                
                $('#province').change(function(){
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
                        console.log(subdistrict);
                        $("#district option").remove();
                        $("#subdistrict option").remove();
                        var options = $("#district");
                        options.append($("<option />").val("").text("Select District"));

                        $.each(obj, function(item) {
                            //console.log(item);
                            options.append($("<option />").val(obj[item].code).text(obj[item].name_en));
                        });
                        $("#district").selectpicker('refresh');                
                    }                 
                    });
                });
                
                $('#district').change(function(){
                    // alert($(this).val())
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
                        options.append($("<option />").val("").text("Select Sub-district"));
                        
                        var zipcodes_tmp = [];
                        $.each(obj, function(item) {
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
                    var body_add ='';
                    body_add +='<div class="col text-right">';
                    body_add +='<button type="button" class="btn btn_remove_con" name="remove" style="background-color: #0275d8;color: #F9FAFA;" id="new'+ contact_ct +'">X</button>';
                    body_add +='</div>&nbsp;&nbsp;';
                    $("#contact-section-clone").append(body_add);

                    clone = $('#contact-section_1').clone();
                    clone.find("#id_default1").attr('checked', false);
                    clone.attr('id', 'contact-section_new'+contact_ct);
                    clone.find("#id_contact1").attr('id','id_contact_new'+contact_ct);

                    clone.find("#contact_mobile1").val("");
                    clone.find("#contact_mobile1").attr('id','contact_mobile_new'+contact_ct);

                    clone.find("#contact_title_name1").val("Mr.");
                    clone.find("#contact_first_name1").val("");
                    clone.find("#contact_last_name1").val("");
                    clone.find("#contact_nick_name1").val("");
                    clone.find("#contact_tel1").val("");
                    
                    clone.find("#contact_email1").val("");
                    clone.find("#contact_line_id1").val("");
                    clone.find("#contact_position1").val("");
                    clone.find("#contact_remark1").val("");
                    clone.find("#department1").val("");

                    clone.find("#id_default1").attr('id','id_default_new'+contact_ct).val("new"+contact_ct);
                    clone.find("#hid_default1").attr('id','hid_default_new'+contact_ct).val("new"+contact_ct);

                    clone.appendTo(".contact-section-clone");
                    document.getElementById("id_contact_new"+contact_ct).value = "";

                    var body_add ='<script>';
                    body_add +='document.getElementById("contact_mobile_new'+contact_ct+'").addEventListener("input", function (e) {';
                    body_add +='    var x = e.target.value.replace(/'+'\\D/'+'g,'+"''"+').match(/'+'(\\d{0,3})(\\d{0,3})(\\d{0,4})/'+');';
                    body_add +='    e.target.value = !x[2] ? x[1] : x[1] + '+"'-'"+' + x[2] + (x[3] ? '+"'-'"+' + x[3] : '+"''"+');';
                    body_add +='});';
                    body_add +='</'+'script>';
                    $("#contact-section-clone").append(body_add);

                    contact_ct++;

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
                    body_add +='<button type="button" class="btn btn_remove_insur" name="remove" style="background-color: #0275d8;color: #F9FAFA;" id="new'+ insur_ct +'">X</button>';
                    body_add +='</div>&nbsp;&nbsp;';
                    $("#insurance-section-clone").append(body_add);
                    ///////////////////////////////////////////////////////////
                    // $("#insurance-section_"+insur_ct).clone().attr('id', 'insurance-section_new'+insur_ct).appendTo(".insurance-section-clone");

                    clone = $('#insurance-section_'+'1').clone();
                    clone.attr('id', 'insurance-section_new'+insur_ct);
                    
                    clone.find("#policy_no").val("");
                    clone.find("#sub_cat").val("");
                    clone.find("#product_name").val("");
                    clone.find("#start_date").val(Date.now());
                    clone.find("#end_date").val(Date.now());
                    clone.find("#premium_rate").val("");
                    clone.find("#insurance_status").val("New");
                    clone.find("#agent_name").val("");
                    clone.find("#imgInp1").val("");

                    clone.find("#start_date1").attr('id','start_date_new'+insur_ct).val("");
                    clone.find("#end_date1").attr('id','end_date_new'+insur_ct).val("");

                    clone.find("#product_category1").attr('id','product_category_'+insur_ct);
                    clone.find("#sub_cat1").attr('id','sub_cat_'+insur_ct);
                    clone.find("#insurance_company1").attr('id','insurance_company_'+insur_ct);
                    clone.find("#product_name1").attr('id','product_name_'+insur_ct);
                    clone.find("#id_insurance_info1").attr('id','id_insurance_info_new'+insur_ct);
                    clone.find("#agent_name1").attr('id','agent_name_'+insur_ct);
                    clone.find("#imgInp1").attr('id','imgInp_new'+insur_ct).val("");
                    clone.find("#download_clone").attr('id','download_clone'+insur_ct).val("");
                    clone.appendTo(".insurance-section-clone");
                    document.getElementById("id_insurance_info_new"+insur_ct).value = "";
                    $("#agent_name_"+insur_ct+" option").remove();
                    $("#product_name_"+insur_ct+" option").remove();
                    $("#insurance_company_"+insur_ct).val("");
                    $("#imgInp_new"+insur_ct).val("");
                    $("#download_clone"+insur_ct).hide();

                    var body_add ='';
                    body_add +='<script>';
                    body_add +='$(document).ready(function(){';
                    body_add +='$('+"'#start_date_new"+insur_ct+"'"+').datepicker({';
                    body_add +='  format: '+"'dd-mm-yyyy'"+',';
                    body_add +='  language: '+"'en'"+'';
                    body_add +='});';
                    body_add +='$('+"'#end_date_new"+insur_ct+"'"+').datepicker({';
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
                    body_add +='$.ajax({';
                    body_add +='    type:"post", ';
                    body_add +='    url: "includes/fx_insurance_products.php", ';
                    body_add +='    data: {';
                    body_add +='        action: "get_sub_cat",';
                    body_add +='        id_product_categories: $(this).val()';
                    body_add +='},';
                    body_add +='success: function(result) {';
                    body_add +='    var obj = eval("(" + result + ")");';
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
                    // body_add +='    console.log(result);';
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
                    body_add +='            var fileInput = document.getElementById("imgInp_new'+contact_ct+'");';
                    body_add +='            var fileSize = fileInput.files[0].size;';
                    body_add +='            var maxSize = 5 * 1024 * 1024;';
                    body_add +='            if (fileSize > maxSize) {';
                    body_add +='                alert("File size exceeds 5MB. Please choose a file smaller than 5MB.");';
                    body_add +='                document.getElementById("imgInp_new'+contact_ct+'").value = "";';
                    body_add +='            }';
                    body_add +='        }';

                    body_add +='function readURL(input) {';

                    body_add +='    var fileName = document.getElementById("imgInp_new'+contact_ct+'").value;';
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
                    body_add +='        document.getElementById("imgInp_new'+contact_ct+'").value=null;';
                    body_add +='        alert("Only pdf files are allowed!");';
                    body_add +='    }}';
                    body_add +='$("#imgInp_new'+contact_ct+'").change(function(){';

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
                    /////////////////////////////////////////////////////////
                    
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
                    $.ajax({
                        type:"post", 
                        url: "includes/fx_insurance_products.php", 
                        data: {
                            action: 'get_product',
                            id_product_categories: $(this).val()
                    },
                    success: function(result) {
                        var obj = eval("(" + result + ")");
                        console.log(result);
                        $("#product_name option").remove();
                        var options = $("#product_name");
                        //don't forget error handling!
                        $.each(obj, function(item) {
                            //console.log(item);
                            options.append($("<option />").val(obj[item].id).text(obj[item].product_name));
                        });                 
                    }                 
                    });
                });


                $('#customer_type').change(function(){
                
                    var val = $(this).val();
                    // alert (val)
                    if (val == 'Personal') {
                        $('.corporate').hide();
                        $('.personal').show();
                        document.getElementById('company_c_input').removeAttribute('required');
                        document.getElementById('title_name').setAttribute("required","required");
                        document.getElementById('first_name').setAttribute("required","required");
                        document.getElementById('last_name').setAttribute("required","required");
                        
                    }
                    if (val == 'Corporate') {
                        $('.corporate').show();
                        $('.personal').hide();
                        document.getElementById('company_c_input').setAttribute("required","required");
                        document.getElementById('title_name').removeAttribute('required');
                        document.getElementById('first_name').removeAttribute('required');
                        document.getElementById('last_name').removeAttribute('required');
                        
                    }
                });
                
                $('.same_customer').click(function(){
                    // alert('clicked')
                });

                $('#same_customer').click(function(){
                //alert($('#title_name').val())
                    $('#contact_title_name1').val($('#title_name').val());
                    $('#contact_first_name1').val($('#first_name').val());
                    $('#contact_last_name1').val($('#last_name').val());
                    $('#contact_nick_name1').val($('#nick_name').val());
                    $('#contact_mobile1').val($('#mobile').val());
                    $('#contact_tel1').val($('#tel').val());
                    $('#contact_email1').val($('#email').val());
                });

            });
        </script>

    <?php include('includes/footer.php');?>
</body>

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