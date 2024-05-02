<?php
session_start();
error_reporting(0);
include_once('includes/connect_sql.php');
include_once('includes/fx_customer_db.php');
include_once('includes/fx_address.php');
include_once('includes/fx_agent_db.php');
include_once('includes/fx_insurance_products.php');

if(strlen($_SESSION['alogin'])=="") {
    header('Location: logout.php');
}

$provinces = get_provinces($conn);
//$district_1 = "'".$provinces[0]['name_en']."'";
//echo $district_1;
$districts = get_district_by_province($conn, $provinces[0]['code']);
//print_r($districts);
$subdistricts = get_subdistrict_by_district($conn, $districts[0]['code']);
$customer_id = generate_customer_id($conn);
$insurance_company = get_insurance_company ($conn);
$product_categories = get_product_category($conn);
$agents = get_agents($conn);
//echo $customer_id;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (!empty($_POST)) {
		save_customer($conn, $_POST);		
		//print_r($_POST);
	}
	header('Location: customer-information.php');
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

    <title>SB Admin 2 - Buttons</title>

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


    <script>
        /*new DataTable('#example', {
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


<form method="post" action = "add-customer.php" enctype="multipart/form-data">
<br>
<!-- <section class="section"> -->

<div class="container-fluid">
	<div class="row mt-3">
		<div class="panel-heading col-md-6">
                        <div class="panel-title" style="color: #102958;" >
                            <h2 class="title">Add Customer</h2>
                        </div>
						
						<div class="form-group row">
							<div class="col-md-12 text-right">
							<button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
							</div>
						</div>
                </div>
	</div>

	<div class="row">
		<div class="panel">
			<div class="col-md-12 mb-3 mt-3">
				<input name="status" class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked="checked">
                    <label style="color: #0C1830;" class="form-check-label" for="flexCheckDefault">
                    &nbsp;&nbsp;&nbsp;&nbsp; Active
                    </label>
			</div>
			
			<div class="col-md-6 mb-3 mt-3">
				 <label  style="color: #102958;" for="staticEmail" class="col-sm-4 col-form-label">Customer Type:</label>
				 <div class="col-sm-8">
        			<select name="customer_type" style="border-color:#102958;" id="customer_type" onchange="" class="form-control">
                        <option value="Personal" selected>Personal</option>
                        <option value="Corporate" >Corporate</option>
                    </select>
				 </div>
			</div>
			
			
			
			<div class="col-md-6 mb-2">
				<label style="color: #102958;" for="staticEmail" class="col-sm-4 col-form-label">Customer ID:</label>
                <div class="col-sm-8">
                    <input name="customer_id" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" value="<?php echo $customer_id;?>" >               
                </div>
			</div>
			
			<div class="col-md-6 mb-3">
				<label style="color: #102958;" for="staticEmail" class="col-sm-4 col-form-label">Customer Level:</label>
                <div class="col-sm-8">
                    <select name="customer_level" style="border-color:#102958;"   class="form-control">
                        <option value="1" selected>A</option>
                        <option value="2" >B</option>
                    </select>
                </div>  
			</div>
			
			<div class="col-md-6 mb-3 company">
				<label  style="color: #102958;"  class="col-sm-4 col-form-label">Company name:</label>
    				<div id="" class="col-sm-8">
    				<input id="company_c_input" name="company_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >    
               		</div>
			</div>
			
			<div class="col-md-6 mb-3 personal">
				<label id="label_title" style="color: #102958;" for="staticEmail" class="col-sm-4 col-form-label personal">Title Name:</label>
                <div id="col_title" class="col-sm-8 ">
                     <select id="title_name" style="border-color:#102958;" name="title_name" class="form-control" id="title_name" >
                            <option value="Mr." <?php echo (trim($customer['title_name'])=="Mr.") ? 'selected' : '';?>>Mr.</option>
							<option value="Ms." <?php echo (trim($customer['title_name'])=="Ms.") ? 'selected' : '';?>>Ms.</option>
							<option value="Mrs." <?php echo (trim($customer['title_name'])=="Mrs.") ? 'selected' : '';?>>Mrs.</option>       
                        </select>    
                </div>
			</div>
			
			
			
			<div class="col-md-6 mb-3 personal">
				<label id="label_fname" style="color: #102958;" for="staticEmail" class="col-sm-4 col-form-label">First name:</label>
                <div id="col_fname" class="col-sm-8">
                    <input id="first_name" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="first_name" required="required" class="form-control" id="success"  >
                </div>
			</div>
			<div class="col-md-6 mb-3 personal">
				 <label id="label_lname" style="color: #102958;" for="staticEmail" class="col-sm-4 col-form-label ">Last name:</label>
                <div id="col_lname" class="col-sm-8 persona">
                    <input id="last_name" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="last_name" required="required" class="form-control " >
                </div>
			</div>
			
			<div class="col-md-6 mb-3 personal ">
				<label style="color: #102958;" for="staticEmail" class="col-sm-4 col-form-label ">Nickname:</label>
                <div class="col-sm-8">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="nick_name" id="nick_name" class="form-control personal" >
               
                </div>
			</div>
			
			<div class="col-md-6 mb-3">
				<label style="color: #102958;" for="staticEmail" class="col-sm-4 col-form-label">Mobile:</label>
                <div class="col-sm-8">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="mobile" required="required" class="form-control" id="mobile" >               
                </div>
			</div>
			
			<div class="col-md-6 mb-3">
				<label style="color: #102958;" for="staticEmail" class="col-sm-4 col-form-label">Tel:</label>
                <div class="col-sm-8">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="tel" id="tel" required="required" class="form-control"  >               
                </div>
			</div>
			
			<div class="col-md-6 mb-3">
				<label style="color: #102958;" for="staticEmail" class="col-sm-4 col-form-label">Tax ID:</label>
                <div class="col-sm-8">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="tax_id" required="required" class="form-control" id="success"  >               
                </div>
			</div>
			
			<div class="col-md-6 mb-3">
				<label style="color: #102958;" for="staticEmail" class="col-sm-4 col-form-label">Email:</label>
                <div class="col-sm-8">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="email" required="required" class="form-control" >
                </div>
			</div>
		</div>
	</div>





        <div class="row">
			
		
            <div class="col-md-12 ">
                <div class="panel">

        
             <div class="panel-heading">
                <div class="panel-title" style="color: #102958;" >
                    <h2 class="title" >Address</h2>
                </div>
            </div> 
            
             <div class="form-group row">
               <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Address Number:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="address_number" required="required" class="form-control" >
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Building Name:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="building_name" required="required" class="form-control" >
                </div>
            </div>

            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Soi:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="soi"  class="form-control" >
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Road:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="road" class="form-control" >
                </div>
            </div>
			
			<div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Province:</label>
                <div class="col-sm-4">
                    <select style="border-color:#102958;" name="province" class="form-control" id="province" >
						<?php foreach ($provinces as $province) { ?>
						<option value="<?php echo $province['code']?>"><?php echo $province['name_en'];?></option>
						<?php } ?>
					</select>
               
                </div>
				
				<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">District:</label>
                <div class="col-sm-4">
                     <select style="border-color:#102958;" name="district"  class="form-control" id="district" >
					<?php foreach ($districts as $district) { ?>
						<option value="<?php echo $district['code']?>"><?php echo $district['name_en'];?></option>
						<?php } ?>					
					</select>
                </div>
            </div>

            <div class="form-group row">
                
                
				<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Sub-district:</label>
                <div class="col-sm-4">
                    <!-- <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" > -->

                    <select style="border-color:#102958;" name="sub_district" class="form-control" id="subdistrict" >	
					<?php foreach ($subdistricts as $sub) { ?>
						<option value="<?php echo $sub['code']?>"><?php echo $sub['name_en'];?></option>
						<?php } ?>					
					</select>
                </div>
				
				
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Post Code:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="post_code" id="post_code" class="form-control" >
					<!--<select style="border-color:#102958;" name="post_code" class="form-control" id="default" >
							<option value="Mr." selected></option>
					</select>-->               
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
        <div class="row " id="contact-section">
            <div class="col-md-12 ">
                <div class="panel">
                    <div class="panel-heading">

                    <div class="form-group row">
                        <div class="col-sm-3 ">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Contact Person</h2>
                            </div>
                        </div>
                       
            <div class="col-sm-4  "  >           
                <div  class="form-check " style="top:15px;">
                    <input name="same_customer" id="same_customer" class="form-check-input same_customer" type="checkbox" >
                    <label style="color: #0C1830;" class="form-check-label" for="SameCheck">
                        &nbsp;&nbsp;&nbsp;&nbsp; Same Customer Name
                    </label>
                </div>
            </div>  

 
                        
                        </div>
                    </div>
   
        <div class="panel-body">
            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Title Name:</label>
                <div class="col-sm-4">
                     <select name="contact_title_name[]" id="contact_title_name" style="border-color:#102958;"  class="form-control" id="default" >
                            <option value="Mr." <?php echo (trim($customer['title_name'])=="Mr.") ? 'selected' : '';?>>Mr.</option>
                                <option value="Ms." <?php echo (trim($customer['title_name'])=="Ms.") ? 'selected' : '';?>>Ms.</option>
                                <option value="Mrs." <?php echo (trim($customer['title_name'])=="Mrs.") ? 'selected' : '';?>>Mrs.</option>       
                        </select>    
                </div>
            </div>

            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">First name:</label>
                <div class="col-sm-4">
                    <input id="contact_first_name" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="contact_first_name[]" class="form-control" >
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Mobile:</label>
                <div class="col-sm-4">
                    <input  minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="contact_mobile[]" id="contact_mobile" class="form-control" >
                </div>
            </div>
<!-- Last name: Nickname: Email:-->
            <div class="form-group row">
                <label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Last name:</label>
                <div class="col-sm-4">
                    <input id="contact_last_name" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="contact_last_name[]" class="form-control" >
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Tel:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="contact_tel[]" id="contact_tel" class="form-control" >
                </div>
            </div>

            

            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Nickname:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="contact_nick_name[]" id="contact_nick_name" class="form-control" >
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="contact_email[]" id="ontact_email" class="form-control" >
                </div>
            </div>

             <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Position:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="contact_position[]" class="form-control" >
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Line ID:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="contact_line_id[]" class="form-control" >
                </div>
            </div>

             <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Remark:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="contact_remark[]" class="form-control" >
               
                </div>
                

                <div class="col-sm-6">
                <div class="form-check" style="top:5px">
  <input name="contact_default[]" class="form-check-input" type="radio" value="" id="flexCheckDefault">
        <label style="color: #0C1830;" class="form-check-label" for="flexCheckDefault">
    &nbsp;&nbsp;&nbsp;&nbsp; Default Contact
    </label>
            </div>
            </div>  

        </div>
          <!--   <div class="form-group row">
                <div class="col-md-12">
                <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                                                           </button>
                </div>
            </div> -->
          
			
			</div>
        </div>
		
		
    </div> 
	
</div> 
<!-- Contact Section End -->

<div class="contact-section-clone"></div>	

<!-- Insurance Info Start -->
<div class="container-fluid">
	<!-- 1 Start -->
		<div class="row">
		<div  class="col-sm-12 text-right  ">
			<div style="padding-top: 10px;">
			 
			 <button style="background-color: #0275d8;color: #F9FAFA;" type="button" name="add_more_insurance" class="btn  btn-labeled" id="add-insur">+ Add More Insurance<span class="btn-label btn-label-right"><i class="fa "></i></span></button>
			</div>
		</div>
		</div>
		<!-- 1 End -->

        <div class="row" id="insurance-section">

            <div class="col-md-12 ">
                <div class="panel">

                   <div class="panel-heading">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Insurance information</h2>
                            </div>
                        </div>
                       
                        
                        </div>
                    </div>
   
        <div class="panel-body">
            <div class="form-group row">

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Policy No:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="policy_no[]" class="form-control" id="policy_no">
               
                </div>

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Insurance Company:</label>
                <div class="col-sm-4">
                <select name="insurance_company[]" style="color: #0C1830;border-color:#102958;"class="form-control" id="insurance_company"  value="" >
                    <option value="">Select Insurance</option>
                    <?php foreach ($insurance_company as $insurance) {?>
                   <option value="<?php echo $insurance['id'];?>" ><?php echo $insurance['insurance_company'];?></option>
                    <?php }?>
                </select>
                </div>

               

            </div>

            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Product Category:</label>
                <div class="col-sm-4">
                    <select name="product_category[]" style="color: #0C1830;border-color:#102958;"class="form-control" id="product_category"  value="" >
                    <option value="">Select Category</option>
                    <?php foreach ($product_categories as $pc) {?>
                    <option value="<?php echo $pc['id'];?>"><?php echo $pc['categorie'];?></option>
                    <?php }?>
                </select>
               
                </div>

                <!-- <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Period:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
                </div> -->
            </div>
            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Product Name:</label>
                <div class="col-sm-4">
                	<select name="product_name[]" style="color: #0C1830;border-color:#102958;"class="form-control" id="product_name"  value="" >
                    <option value="">Select Product</option>                    
                    </select>
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Period:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="period[]" class="form-control" id="period" >
                </div>
            </div>

            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Start date:</label>
                <div class="col-sm-4">
                    <input id="start_date" name="start_date[]" style="color: #0C1830;border-color:#102958;" type="date" class="form-control"  >
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">End date:</label>
                <div class="col-sm-4">
                    <input id="end_date" name="end_date[]" style="color: #0C1830;border-color:#102958;" type="date"  class="form-control"  >
                </div>
            </div>


            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Premium Rate:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="premium_rate[]" class="form-control" id="premium_rate" >
               
                </div>

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Status:</label>
                <div class="col-sm-4">
                <select id="insurance_status" name="insurance_status[]" onchange="ClickChange()" style="border-color:#102958;" class="form-control" >
                    <option value="New">New</option>
                    <option value="Follow up">Follow up</option>
                    <option value="Renew">Renew</option>
                    <option value="Wait">Wait</option>
                    <option value="Not renew">Not renew</option>
                </select>
                </div>
            </div>

            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Agent Name:</label>
                
            <div class="col-sm-4">
                <select name="agent_name[]" style="color: #0C1830;border-color:#102958;"class="form-control" id="agent_name"  value="" >
                    <option value="">Select Agent</option>
                    <?php foreach ($agents  as $a) { ?>
						<option value="<?php echo $a['id']?>"><?php echo $a['first_name'].' '.$a['last_name'];?></option>
						<?php } ?>	
                </select>
            </div>

            <label style="color: #102958;" class="col-sm-2 col-form-label">Upload Documents:</label>                
            <div class="col-sm-4">
                <input name="file_d[]" type="file" style="width: 100%;"  id="imgInp">
            </div>                     

            </div>
            <!-- <div class="form-group row">
             <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Status:</label>
                <div class="col-sm-4">
                    <input  name="active" data-size="big" data-toggle="toggle" id="active" class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" <?php if($active==1){ ?>
                            checked
                                <?php } ?>
                            >
                 </div>
            </div> -->
			
			<!-- 
            <div class="form-group row">
                <div class="col-md-12 text-center">
                <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                </div>
            </div> -->

        </div>
    </div>                             
    </div> <!--  -->
    
</div> <!-- INSURANCE SECTION END -->

<div class="insurance-section-clone"></div>	
</div>
<!-- Insurance Info End -->

</div> 
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

        // function myFunction() {
        //     document.getElementById("myText").disabled = true;
        // }

	/*
    const checkbox = document.getElementById('input_same')
    checkbox.addEventListener('change', (event) => {
    if (event.currentTarget.checked) {
    // alert('checked');
        document.getElementById("input_title_contact").value = document.getElementById("input_title").value;
        document.getElementById("input_fname_contact").value = document.getElementById("input_fname").value;
        document.getElementById("input_lname_contact").value = document.getElementById("input_lname").value;   
    } else {
        document.getElementById("input_title_contact").value ="Mr.";
        document.getElementById("input_fname_contact").value ="";
        document.getElementById("input_lname_contact").value ="";
    }
    })
	*/
    </script>


    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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
        <script>
            $(function($) {
				var subdistrict = [];
				var zipcodes = [];
                //$('#example').DataTable();

                /*$('#example2').DataTable( {
                    "scrollY":        "300px",
                    "scrollCollapse": true,
                    "paging":         false
                } );*/

                //$('#example3').DataTable();
				
				
				
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
						//don't forget error handling!
						$.each(obj, function(item) {
							//console.log(item);
							
							options.append($("<option />").val(obj[item].code).text(obj[item].name_en));
						});					
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
						//don't forget error handling!
						
						$.each(obj, function(item) {
							//console.log(item);
							zipcodes[obj[item].code] = obj[item].zip_code;
							options.append($("<option />").val(obj[item].code).text(obj[item].name_en));
						});					
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
					$("#contact-section").clone().attr('id', 'contact-section_'+contact_ct).appendTo(".contact-section-clone");
					contact_ct++
					$('.same_customer').each(function( index ) {                  
                          console.log( index + ": " + $( this ).text() );
                          if (index > 0) {
                          	$(this).hide();
                          	$( this ).next().hide();
                          }
                     });
				});
				
				var insur_ct = 1;
				$('#add-insur').click(function(){					
					$("#insurance-section").clone().attr('id', 'insurance-section_'+insur_ct).appendTo(".insurance-section-clone");
					insur_ct++;
				});
				
				$('#product_category').change(function(){
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
				
				
				$('.corporate').hide();
				$('#customer_type').change(function(){
				
					var val = $(this).val();
					//alert (val)
					if (val == 'Personal') {
						$('.corporate').hide();
						$('.personal').show();
					}
					if (val == 'Corporate') {
						$('.corporate').show();
						$('.personal').hide();
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
				});
				
            });
        </script>

</body>

</html>

