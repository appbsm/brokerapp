<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<?php
include_once('includes/connect_sql.php');
session_start();
error_reporting(0);
include_once('includes/fx_partner_db.php');
include_once('includes/fx_insurance_products.php');
// include_once('includes/fx_address.php');
include_once('includes/fx_address_function.php');
include_once('includes/fx_agent_db.php');

if(strlen($_SESSION['alogin'])=="") {
	$dbh = null;
    header('Location: logout.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (!empty($_POST)) {
		save_partner($conn, $_POST);	
	}
    // echo '<script>alert("Successfully added information.")</script>';
	$dbh = null;
    echo "<script>window.location.href ='insurance-partner.php'</script>";
	// header('Location: insurance-partner.php');
}

$provinces = get_provinces($conn);
$districts = get_district_by_province($conn, $provinces[0]['code']);
$subdistricts = get_subdistrict_by_district($conn, $districts[0]['code']);
$insurance_id = generate_partner_id($conn);
$products = get_products($conn);
$agents = get_agents($conn);
$currency = get_currency($conn);

// $agents = get_agents_under($conn);
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

</head>

<style>
	.btn-default {
		color: #0C1830 !important;
		border-color: #102958 !important;
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
                    <li class="active"  ><a href="insurance-partner.php">Partner List</a></li>
                    <li class="active">Add Partner</li>
                </ul>
            </div>
        </div>
</div>


<form method="post" onSubmit="return validateForm();" >
<br>
<!-- <section class="section"> -->


<div class="container-fluid">
        <div class="row">

            <div class="col-md-12 ">
                <div class="panel">     
                   <div class="panel-heading">
                        <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col-sm-4">

                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Add Partner</h2>
                            </div>
                        </div>

                        </div>
                    </div>
   
        <div class="panel-body">
			<div class="form-group row col-md-10 col-md-offset-1">
				<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Partner ID:</label>
				<div class="col-sm-4">
					<input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="insurance_id" class="form-control" id="insurance_id" value="<?php echo $insurance_id; ?>" readOnly>
				</div>
 
                <!-- Status: -->
                <!-- <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"></label> -->
                <div class="col-sm-6">
                    <input id="status" name="status"  class="form-check-input" type="checkbox" value="true" checked>
                    <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                         &nbsp;&nbsp;&nbsp;&nbsp; Active
                    </label>
                </div>
				
			</div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Partner Name:</label>
                <div class="col-sm-10">
                    <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="insurance_company" id="insurance_company" class="form-control" required>
                </div>
            </div>

<script>

var partner_check = "true";

$(function(){

    var partner_object = $('#insurance_company');
    partner_object.on('change', function(){
        var partner_value = $(this).val().trim();
        $.get('get_partner_name.php?name=' + partner_value, function(data){
            var result = JSON.parse(data);
            partner_check = "true";
            $.each(result, function(index,item){
                if(item.id!=""){
                    alert("This partner already exist.");
                    partner_check="false";
                }
            });
        });
    });

});

function validateForm() {

    if (partner_check=="true") {
        document.getElementById("loading-overlay").style.display = "flex";
        return true;
    }else{
        alert("This partner already exist.");
        return false;
    }
}

</script>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Short Partner Name:</label>
                <div class="col-sm-4">
                    <input id="short_name_partner" name="short_name_partner" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
				<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Tax ID / Passport ID:</label>
				<div class="col-sm-4">
					<input minlength="13" maxlength="13" style="color: #000;border-color:#102958;" type="text" name="tax_id" class="form-control" id="tax_id"  pattern="\d{13}">
					<!-- <input minlength="1" maxlength="13" style="color: #0C1830;border-color:#102958;" type="text" name="tax_id" class="form-control" id="tax_id"  > -->
				</div>

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Currency:</label>
                <div class="col-sm-4">
                    <select style="color: #000; border-color:#102958;" name="id_currency_list" class="form-control" id="id_currency_list" >
                        <!-- <option value="" selected>Select Currency</option> -->
                        <?php foreach ($currency  as $value_currency) { ?>
                        <option value="<?php echo $value_currency['id']?>" <?php if($value_currency['currency']=="฿THB"){ echo "selected";} ?> ><?php echo $value_currency['currency'];?></option>
                        <?php } ?>
                            <!-- <option value="1" selected>THB(ไทย)</option>
                            <option value="2" >USD(ดอลลาร์สหรัฐ)</option>
                            <option value="3" >EUR(ยูโร)</option> -->
                        </select>
                </div>    
			</div>
<!-- 
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="email" name="email" class="form-control" id="email" >
                </div> -->

        <div class="form-group row col-md-10 col-md-offset-1"> 
                

				<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Mobile:</label>
				<div class="col-sm-4">
					<input style="color: #000;border-color:#102958;" type="text" name="phone" class="form-control" id="phone" pattern="\d{3}-\d{3}-\d{4}">
				</div>
				<script>
					document.getElementById('phone').addEventListener('input', function (e) {
						var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
						e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
					});
				</script>

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Tel:</label>
                <div class="col-sm-4">
                    <input id="tel" name="tel" style="color: #000;border-color:#102958;" type="text" class="form-control"  >
                </div>
        </div>

        <div class="form-group row col-md-10 col-md-offset-1">

            <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-4">
                <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="email" name="email" class="form-control" id="email" >
            </div>

            <label style="color: #102958;"  class="col-sm-2 col-form-label">Web Company:</label>
            <div class="col-sm-4">
                <input id="web_company" name="web_company" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  >
            </div>
        </div> 

        <div class="form-group row col-md-10 col-md-offset-1">
            <label style="color: #102958;" class="col-sm-2 col-form-label">Fax:</label>
            <div class="col-sm-4">
                <input id="fax" name="fax" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  >
            </div>
        </div>

            <div class="panel-heading">
                <div class="form-group row col-md-10 col-md-offset-1">
                    <div class="col-sm-4">
                        <div class="panel-title" style="color: #102958;" >
                            <h2 class="title" >Address</h2>
                        </div>
                    </div>
                </div>
            </div> 
			
			<!--
            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Address No:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="address_number"  class="form-control" id="address_number" value="" >
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Building Name:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="building_name"  class="form-control" id="building_name" value="" >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Soi:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="soi" class="form-control" id="soi" value="" >
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Road:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="road" class="form-control" id="road" value="" >
                </div>
            </div>
			-->
			
			<div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Address No:</label>
                <div class="col-2">
                    <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="address_number"  class="form-control" id="address_number" value="" >
                </div>
				<label style="color: #102958;" for="staticEmail" class="col-sm-1 col-form-label">Soi:</label>
                <div class="col pl-0">
                    <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="soi" class="form-control" id="soi" value="" >
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-1 col-form-label">Road:</label>
                <div class="col pl-0">
                    <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="road" class="form-control" id="road" value="" >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Building Name:</label>
                <div class="col">
                    <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="building_name"  class="form-control" id="building_name" value="" >
                </div>
            </div>

			
            <div class="form-group row col-md-10 col-md-offset-1">
				<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Province:</label>
                <div class="col-sm-4">
                    <select style="color: #000;border-color:#102958;" name="province" class="form-control selectpicker" id="province" data-live-search="true" >
                        <option value="" selected>Select Province</option>
								<?php foreach ($provinces as $province) { ?>
						<option value="<?php echo $province['code']?>"><?php echo $province['name_en'];?></option>
								<?php }?>
                    </select>
               
                </div>
                
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">District:</label>
                <div class="col-sm-4">
                     <select style="color: #000;border-color:#102958;" name="district" class="form-control selectpicker" id="district" data-live-search="true" >
                                <option value="" selected>Select District</option>
								<?php //foreach ($districts as $district) { ?>
						<!-- <option value="<?php //echo $district['code']?>"><?php //echo $district['name_en'];?></option> -->
						<?php //} ?>
                        </select>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Sub-district:</label>
                <div class="col-sm-4">
                    <!-- <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="name" class="form-control" id="success" value" > -->

                    <select style="color: #000;border-color:#102958;" name="sub_district" class="form-control selectpicker" id="sub_district" data-live-search="true" >
                                <option value="" selected>Select Sub-district</option>
								<?php foreach ($subdistricts as $sub) { ?>
						<option value="<?php echo $sub['code']?>"><?php echo $sub['name_en'];?></option>
						<?php } ?>	
                        </select>
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Post Code:</label>
				<div class="col-sm-4">
					<input minlength="5" maxlength="5" style="color: #000;border-color:#102958;" type="text" name="post_code" id="post_code" class="form-control"  pattern="\d{5}">
				</div>
            </div>

            <br>
        </div>
    </div>
</div>

<div class="container-fluid">       
    <div  id="bank_section">
        <div class="panel">  

                <div class="panel-heading">
                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col-sm-5">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Partner Bank Details</h2>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                            <!-- style="background-color: #0275d8;color: #F9FAFA;" -->
                        </div>
                    </div>
                </div>

                <div class="bank-clone-cancel1" id="bank-clone-cancel1" ></div>

                <div class="panel-body">
    			 <div class="form-group row col-md-10 col-md-offset-1" >
                    <label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Bank Name:</label>
                    <div class="col-sm-4">
                    <input id="bank_name" name="bank_name[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $customer_id;?>" >                    
                    </div>
                    
                    <label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Bank Account:</label>
                    <div class="col-sm-4">
                    <input id="bank_account" name="bank_account[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $customer_id;?>" >
                    
        			</div>  
        	
        		</div>  

        		<div class="form-group row col-md-10 col-md-offset-1" >
                    <label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Bank Type:</label>
                    <div class="col-sm-4">
                    <input id="bank_type" name="bank_type[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $customer_id;?>" >                    
                    </div>
                    
                    <label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Bank Account Name:</label>
                    <div class="col-sm-4">
                    <input id="bank_account_name" name="bank_account_name[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $customer_id;?>" >
                    
        			</div>  
        	
        		</div>  
        	</div> <!-- BANK SECTION --> 

            </div>
    </div>

    <div class="bank-section-clone" id="bank-section-clone" ></div>

    <div class="row">
        <div  class="col-sm-12 text-right  ">
            <div style="padding-top: 10px;">
                <button style="background-color: #0275d8;color: #F9FAFA;" type="button" name="add_more_banks" class="btn" id="add-bank">+ Add More Bank<span class="btn-label btn-label-right"><i class="fa "></i></span></button>
            </div>
        </div>
    </div>
    <br/>

</div>

</div>
</div>


    

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel"> 
                <div class="panel-heading">
                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col-sm-4">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Products</h2>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                            <!-- style="background-color: #0275d8;color: #F9FAFA;" -->
                        </div>
                    </div>
                </div>
				<div class="panel-body">

                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col-sm-2">
                            <label style="color: #102958;" for="staticEmail" class="col-form-label"><small><font color="red">*</font></small>Products Name:</label>
                        </div>
                        <div class="col-sm-10">
                            <!-- placeholder="dd-mm-yyyy"  Search -->
                            <select id="product_id" name="product_id[]" style="color: #000;border-color:#102958;" class="form-control selectpicker" data-none-selected-text="Select Products" data-search-text="Search" title="Search Products" data-live-search="true" multiple="multiple" required>
                                <!-- <option value="All">Select All</option> -->
                                <?php foreach ($products as $p) { ?>
                                    <option value="<?php echo $p['id'];?>"><?php echo $p['product_name'];?></option>
                                <?php } ?>

                            </select>
                        </div>
                    </div>

                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">
                            <textarea id="product_name_all" name="product_name_all" class="form-control overflow-auto" style="color: #000;border-color:#102958;"  rows="1" readonly>
                            </textarea>
                        </div>
                    </div>

                    <script>
                        document.getElementById("product_id").addEventListener("change", function() {
                            var value_period = $(this).val();
                            var selectedOptions = Array.from(this.selectedOptions).map(option => option.textContent);
                            var selectedOptionsText = selectedOptions.join("\n");
                            // var selectedOptionsText = selectedOptions.join(", ");
                            
                            // ถ้ามี "Select All" ถูกเลือก
                            // if (selectedOptions.some(option => option.value === "All")) {
                            //     // เลือกทุกรายการอื่นๆ
                            //     selectedOptions = Array.from(this.options).slice(1);
                            // }
                            
                            // ใส่ค่าที่เลือกทั้งหมดลงใน textarea ที่มี id เป็น product_name_all
                            document.getElementById("product_name_all").value = selectedOptionsText;
                            var lineCount = (selectedOptionsText.match(/\n/g) || []).length + 1;
                            document.getElementById("product_name_all").rows = lineCount;

                            // alert('value_period:'+value_period);
                        });
                    </script>

					<!-- <div class="form-group row col-md-10 col-md-offset-1">
						<?php //foreach ($products as $p) { ?>
						 <div class="col-sm-4">
							<input class="form-check-input" type="checkbox" value="<?php //echo $p['id'];?>" name="product_id[]" id="<?php //echo $p['product_name'];?>" >
							<label class="form-check-label" for="<?php //echo $p['product_name'];?>" >
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $p['product_name'];?>
							</label>
						  </div> 
						<?php //} ?>
					</div>-->

				</div>

			</div>
		</div>
    </div>
</div>      


<div class="container-fluid">
     
    <div class="row " id="under_section">
    <div class="col-md-12 ">
        <div class="panel">
		<div >
            <div class="panel-heading">
                <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col-sm-4">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Under Code</h2>
                            </div>
                        </div>
                        <div class="col-sm-4 ">
                        </div>
                        
                </div>

                <div class=" text-right">
                     <div class="under-clone-cancel1" id="under-clone-cancel1" ></div>
                </div>

            </div>

            <div class="panel-body">
				<div class="form-group row col-md-10 col-md-offset-1">
					
                    <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Under Code:</label>
                    <div class="col-sm-4">
                        <input minlength="1" maxlength="50" name="agent_code[]" id="agent_code" style="color: #000;border-color:#102958;" type="text"  class="form-control" value="" readonly>
                    </div>

					<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Under Name:</label>
					<div class="col-sm-4">
						<select style="color: #000;border-color:#102958;" name="agent_under[]" id="agent_under" class="form-control " >
							<option value="" selected>Select Agent</option>
    						<?php foreach ($agents  as $a) { ?>
    							<option value="<?php echo $a['id']?>"><?php echo $a['first_name'].' '.$a['last_name'];?></option>
    						<?php } ?>
						</select>
					</div>
					
				</div>


                <div class="form-group row col-md-10 col-md-offset-1">
                    <div class="col-sm-2 " >
                         <label style="color: #102958;" for="staticEmail" >Percentage Value:</label>
                    </div>

                    <div class="col-sm-4">
                    <input id="agent_percent1" name="agent_percent[]" type="text" class="form-control" style="border-color:#102958;" />
                    </div>

                    <div class="col-sm-4">
                        <input id="default_type_per1" name="default_type1" value="Percentage" class="form-check-input" type="radio" checked>
                        <label style="color: #102958;" class="form-check-label" >
                            &nbsp;&nbsp;&nbsp;&nbsp; Default Percentage
                        </label>
                    </div>
                </div>

                <div class="form-group row col-md-10 col-md-offset-1">
                    <div class="col-sm-2 " >
                         <label style="color: #102958;" for="staticEmail" >Net Value:</label>
                    </div>

                    <div class="col-sm-4">
                        <input id="agent_net1" name="agent_net[]" type="text" class="form-control" style="border-color:#102958;" checked/>
                    </div>

                    <div class="col-sm-4">
                        <input id="default_type_net1" name="default_type1" value="Net Value" class="form-check-input" type="radio" >
                        <label style="color: #102958;" class="form-check-label" >
                            &nbsp;&nbsp;&nbsp;&nbsp; Default Net Value
                        </label>
                    </div>
                </div>
        </div>
       </div> 

       </div>
    </div>
    </div>

    <div class="under-section-clone" id="under-section-clone" ></div> 

    <div class="row">
            <div  class="col-sm-12 text-right  ">
                <div style="padding-top: 10px;">
                 
                 <button style="background-color: #0275d8;color: #F9FAFA;" type="button" name="add_more_under" class="btn " id="add-under">+ Add More Under Code<span class="btn-label btn-label-right"><i class="fa "></i></span></button>
                </div>
            </div>
    </div> 
    <br/>
</div>


        <script>
            // var selectElement = document.getElementById("agent_under");
            // selectElement.setAttribute("data-live-search", "true");
            // selectElement.classList.add("selectpicker");
            // $('.selectpicker').selectpicker();

            // $('#agent_under').change(function(){
            //     $.get('get_agent_under.php?id=' + $(this).val()+"&partner_id="+"<? echo $_GET[id]; ?>", function(data){
            //         var result = JSON.parse(data);
            //         $("#agent_code").val("");
            //         $.each(result, function(index, item){
            //             $("#agent_code<?php echo $x; ?>").val(item.under_code);
            //         });
            //     });
            // });
        </script>



<div class="container-fluid">            

        <div class="row " id="contact-section">
            <div class="col-md-12 ">
                <div class="panel">
                    <div class="panel-heading">

                        <div class="form-group row col-md-10 col-md-offset-1" >
                            <div class="col-sm-5 ">
                                <div class="panel-title" style="color: #102958;" >
                                    <h2 class="title">Contact Person</h2>
                                </div>
                            </div>
                        </div>

                        <div class=" text-right">
                             <div class="contact-clone-cancel1" id="contact-clone-cancel1" ></div>
                        </div>

                    </div>
   
        <div class="panel-body">
            <div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Title:</label>
                <div class="col-2">
                     <select id="contact_title_name" name="contact_title_name[]" style="color: #000; border-color:#102958;" class="form-control" >
						<option value="" selected>Select Title</option>
						<option value="Mr." <?php echo (trim($customer['title_name'])=="Mr.") ? 'selected' : '';?>>Mr.</option>
						<option value="Ms." <?php echo (trim($customer['title_name'])=="Ms.") ? 'selected' : '';?>>Ms.</option>
						<option value="Mrs." <?php echo (trim($customer['title_name'])=="Mrs.") ? 'selected' : '';?>>Mrs.</option>       
					</select>    
                </div>
                <div class="col-sm-2 " >
                </div>
                <div class="col" >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">First name:</label>
                <div class="col-4">
                    <input id="contact_first_name" name="contact_first_name[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"  class="form-control" >
                </div>

                <label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Last name:</label>
                <div class="col-4">
                    <input id="contact_last_name" name="contact_last_name[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"  class="form-control" >
                </div>
            </div>
			
			<div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Nickname:</label>
                <div class="col-4">
                    <input id="contact_nick_name" name="contact_nick_name[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
                </div>               
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Mobile:</label>
                <div class="col-4">
                    <!--<input id="contact_mobile" name="contact_mobile[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" >-->
                    <input style="color: #000;border-color:#102958;" type="text" name="contact_mobile[]" class="form-control" id="contact_mobile"  pattern="\d{3}-\d{3}-\d{4}">
                </div>

                <script >
                    document.getElementById('contact_mobile').addEventListener('input', function (e) {
                        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                        e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
                    });
                </script>

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Tel:</label>
                <div class="col-4">
                    <input id="contact_tel" name="contact_tel[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Line ID:</label>
                <div class="col-4">
                    <input id="contact_line_id" name="contact_line_id[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
                </div>
				
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
                <div class="col-4">
                    <input id="contact_email" name="contact_email[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
                </div>
            </div>

        <div class="form-group row col-md-10 col-md-offset-1" >

            <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Position:</label>
            <div class="col-4">
                <input id="contact_position" name="contact_position[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
               
            </div>

			<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Department:</label>
			<div class="col-4">
                <input id="department" name="department[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
            </div> 
               
        </div>

        <div class="form-group row col-md-10 col-md-offset-1" >
            <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Remark:</label>
            <div class="col-10">
                <textarea id="contact_remark" name="contact_remark[]" minlength="1" maxlength="255" rows="2" style="color: #000;border-color:#102958;" type="text" class="form-control" ></textarea>
               
            </div>
        </div>    

        <div class="form-group row col-md-10 col-md-offset-1" >
            <div class="col-sm-2">
            </div>  
            <div class="col-4">
                <div class="form-check" style="top:5px">
                <input hidden="true" id="hid_default1" name="hid_default[]" type="text" value="1" >
                <input id="id_default1" name="default_contact[]" class="form-check-input" type="radio" value="1" checked>
                <label style="color: #000;" class="form-check-label" for="flexCheckDefault">
                &nbsp;&nbsp;&nbsp;&nbsp; Default Contact
                </label>
            </div>
		</div>

			</div>
        </div>
		
		</div> 
    </div> 
	
</div> 
<!-- Contact Section Start -->

<div class="contact-section-clone" id="contact-section-clone" ></div>	
    
    <div class="row">
        <div  class="col-sm-12 text-right  ">
            <div style="padding-top: 10px;">
            <button style="background-color: #0275d8;color: #F9FAFA;" type="button" name="add_more_contacts" class="btn  " id="add-con">+ Add More Contact<span class="btn-label btn-label-right"><i class="fa "></i></span></button>
            </div>
        </div>
    </div>
    <br/>

</div>
           <!--  <div class="form-group row">
                <div class="col-md-12">
                <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                </button>
                </div>
            </div> -->
        
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel">
                <div class="panel-body">

                <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-md-12">
                    <button style="background-color: #0275d8;color: #F9FAFA; padding: 3px 16px 3px 16px;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                    </button>
					&nbsp;&nbsp;
					<a href="insurance-partner.php" class="btn btn-primary" style="background-color: #0275d8;color: #F9FAFA;" >
						<span class="text">Cancel</span>
					</a>
                </div>
                </div>
 
                </div>
            </div> 
        </div>  
    </div>  
    </div> 

</div>
</form>
  
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

     <!-- <script src="js/jquery/jquery-2.2.4.min.js"></script> -->
        <!-- <script src="js/bootstrap/bootstrap.min.js"></script> -->

        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>

    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/custom2.js"></script>


        <script>
            $(function($) {
				var subdistrict = [];
				var zipcodes = [];
                $('#example').DataTable();

                $('#example2').DataTable( {
                    "scrollY":        "300px",
                    "scrollCollapse": true,
                    "paging":         false
                } );

                $('#example3').DataTable();
				
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
						$("#sub_district option").remove();
                        $('#post_code').val("");
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
						$("#sub_district option").remove();
                        $('#post_code').val("");

						var options = $("#sub_district");
                        options.append($("<option />").val("").text("Select Sub-district"));
						 var zipcodes_tmp = [];
						$.each(obj, function(item) {
						  
							// console.log(item);
							zipcodes_tmp[obj[item].code] = obj[item].zip_code;
							
							options.append($("<option />").val(obj[item].code).text(obj[item].name_en));
						});		
						zipcodes = zipcodes_tmp;			
						// console.log(zipcodes);
                        $("#sub_district").selectpicker('refresh');
					}				  
					});
				});
				
				$('#sub_district').change(function(){
					var id = $(this).val();

					//alert(id)
					// console.log(id);
					var selected = zipcodes[id];
					// console.log(selected);
					$('#post_code').val(selected);
				});
				
				
				var bank_ct = 1;
				$('#add-bank').click(function(){
                    // clone.find("#contact_title_name").val("Mr.");
                    // clone.find("#contact_first_name").val("");

					// $("#bank_section").clone().attr('id', 'bank-section_'+bank_ct).appendTo(".bank-section-clone");
                    clone = $('#bank_section').clone();
                    clone.attr('id','bank-section_'+bank_ct);

                    clone.find("#bank_name").val("");
                    clone.find("#bank_account").val("");
                    clone.find("#bank_type").val("");
                    clone.find("#bank_account_name").val("");

                    clone.find("#bank-clone-cancel1").attr('id','bank-clone-cancel-new'+bank_ct);
                    clone.appendTo(".bank-section-clone");

                    var body_add ='<div id="'+ bank_ct +'" >';
                    body_add +='<div class="col text-right">';
                    body_add +='<button type="button" class="btn btn_remove_bank" name="remove" style="background-color: #0275d8;color: #F9FAFA;" id="'+ bank_ct +'">X</button>';
                    body_add +='</div></div>&nbsp;&nbsp;';
                    $("#bank-clone-cancel-new"+bank_ct).append(body_add);

					bank_ct++;
				});
                $(document).on('click', '.btn_remove_bank', function() {
                    var button_id = $(this).attr("id");
                    $('#bank-section_' + button_id + '').remove();
                    $('#' + button_id + '').remove();
                });
				
				var under_ct = 1;
				$('#add-under').click(function(){	
                   
                    clone = $('#under_section').clone();
                    clone.attr('id','under-section_'+under_ct);
                    clone.find("#id_under").attr('id','id_under'+under_ct);
                    clone.find("#agent_code").attr('id','agent_code'+under_ct);

                    // clone.find("#default_type1").attr('name','default_type'+(under_ct+1));
                    clone.find("#default_type_per1").prop('checked', true).attr('name','default_type'+(under_ct+1));
                    clone.find("#default_type_net1").removeAttr('checked').attr('name','default_type'+(under_ct+1));

                    clone.find("#agent_percent1").attr('id','agent_percent_new'+under_ct).val("");
                    clone.find("#agent_net1").attr('id','agent_net_new'+under_ct).val("");

                    clone.find("#under-clone-cancel1").attr('id','under-clone-cancel-new'+under_ct);
                    clone.appendTo(".under-section-clone");

                    // document.getElementById("id_under"+under_ct).value = "";
                    document.getElementById("agent_code"+under_ct).value = "";

                    var body_add ='<div id="'+ under_ct +'" >';
                    body_add +='<div class="col text-right">';
                    body_add +='<button type="button" class="btn btn_remove_under" name="remove" style="background-color: #0275d8;color: #F9FAFA;" id="'+ under_ct +'">X</button>';
                    body_add +='</div></div>&nbsp;&nbsp;';
                    $("#under-clone-cancel-new"+under_ct).append(body_add);

					under_ct++;
				});
                $(document).on('click', '.btn_remove_under', function() {
                    var button_id = $(this).attr("id");
                    $('#under-section_' + button_id + '').remove();
                    $('#' + button_id + '').remove();
                });

                var contact_ct = 1;
                $('#add-con').click(function(){  
                    // $("#contact-section").clone().attr('id', 'contact-section_'+contact_ct).appendTo(".contact-section-clone");

                    clone = $('#contact-section').clone();
                    clone.attr('id', 'contact-section_'+contact_ct);
                    
                    // clone.find("#input_title_contact").val("Mr.");
                    // clone.find("#input_fname_contact").val("");
                    // clone.find("#department").val("");
                    // clone.find("#id_default1").checked = true;
                    clone.find("#id_default1").attr('checked', false);
                    clone.find("#id_default1").attr('id','id_default'+(contact_ct+1));
                    clone.find("#hid_default1").attr('id','hid_default'+(contact_ct+1));

                    clone.find("#contact_mobile").val("");
                    clone.find("#contact_mobile").attr('id','contact_mobile'+contact_ct);

                    clone.find("#contact_title_name").val("Mr.");
                    clone.find("#contact_first_name").val("");
                    clone.find("#contact_last_name").val("");
                    clone.find("#contact_nick_name").val("");
                    clone.find("#contact_tel").val("");
                    
                    clone.find("#contact_email").val("");
                    clone.find("#contact_line_id").val("");
                    clone.find("#contact_position").val("");
                    clone.find("#contact_remark").val("");
                    clone.find("#department").val("");

                    clone.find("#contact-clone-cancel1").attr('id','contact-clone-cancel-new'+contact_ct);

                    clone.appendTo(".contact-section-clone");

                    var body_add ='<script>';
                    body_add +='document.getElementById("contact_mobile'+contact_ct+'").addEventListener("input", function (e) {';
                    body_add +='    var x = e.target.value.replace(/'+'\\D/'+'g,'+"''"+').match(/'+'(\\d{0,3})(\\d{0,3})(\\d{0,4})/'+');';
                    body_add +='    e.target.value = !x[2] ? x[1] : x[1] + '+"'-'"+' + x[2] + (x[3] ? '+"'-'"+' + x[3] : '+"''"+');';
                    body_add +='});';
                    body_add +='</'+'script>';
                    $("#contact-section-clone").append(body_add);

                    var body_add ='<div id="'+ contact_ct +'" >';
                    body_add +='<div class="col text-right">';
                    body_add +='<button type="button" class="btn btn_remove_con" name="remove" style="background-color: #0275d8;color: #F9FAFA;" id="'+ contact_ct +'">X</button>';
                    body_add +='</div></div>&nbsp;&nbsp;';
                    $("#contact-clone-cancel-new"+contact_ct).append(body_add);



                    // document.getElementById("id_default"+(contact_ct+1)).checked = false;
                    // document.getElementById("id_default1").checked = true;

                    document.getElementById("id_default"+(contact_ct+1)).value = (contact_ct+1);
                    document.getElementById("hid_default"+(contact_ct+1)).value = (contact_ct+1);

                    // document.getElementById("id_default"+(contact_ct+1)).value = "";

                    contact_ct++;
                });
                $(document).on('click', '.btn_remove_con', function() {
                    var button_id = $(this).attr("id");
                    $('#contact-section_' + button_id + '').remove();
                    $('#' + button_id + '').remove();
                });


            });
        </script>

    <?php include('includes/footer.php'); ?>
</body>

</html>

<div id="loading-overlay">
    <img src="loading.gif" alt="Loading...">
</div>
<?php sqlsrv_close($conn); ?>
<?php $dbh = null;?>
