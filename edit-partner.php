<?php
include_once('includes/connect_sql.php');
session_start();
error_reporting(0);
include_once('includes/fx_partner_db.php');
include_once('includes/fx_insurance_products.php');
include_once('includes/fx_address_function.php');
include_once('includes/fx_agent_db.php');

if(strlen($_SESSION['alogin'])=="") {
	$dbh = null;
    header('Location: logout.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     // echo '<script>alert("count bank_name:'.count($_POST['bank_name']).'")</script>';
    if (!empty($_POST)) {

        $banks = get_partner_bank($conn,$_POST['id']);
        delete_bank_list($conn,$_POST,$banks);

        $under = get_under($conn,$_POST['id']);
        delete_under_list($conn,$_POST,$under);

        $contacts = get_partner_contact($conn,$_POST['id']);
        delete_contact_list($conn,$_POST,$contacts);

        // echo '<script>alert("product_id")</script>'; 
        // if (!isset($_POST['product_id'])) {
        $rela_products = get_rela_partner_to_product($conn,$_POST['id']);
        delete_rela_product_list($conn,$_POST,$rela_products);
        // }

        update_partner($conn, $_POST);
        // print_r($_POST);
    }
    // echo '<script>alert("Successfully edited information.")</script>';
    $dbh = null;
	echo "<script>window.location.href ='insurance-partner.php'</script>";
    // header('Location: insurance-partner.php');
}

if($_GET[id]){
    $id_partner = $_GET[id];
    $pr = get_partner_by_id($conn, $id_partner);
    $partner = $pr[0];
    // print_r($partner);

    $provinces = get_provinces($conn);
    $districts = get_district_by_province($conn, $provinces[0]['code']);
    $subdistricts = get_subdistrict_by_district($conn, $districts[0]['code']);

    $insurance_id = generate_partner_id($conn);
    $products = get_products($conn);

    // $agents = get_agents_under($conn);
    $agents = get_agents($conn);

    $banks = get_partner_bank($conn, $id_partner);
    $contacts = get_partner_contact($conn, $id_partner);

    $rela_products = get_rela_partner_to_product($conn, $id_partner);
    $under = get_under($conn, $id_partner);

    $currency = get_currency($conn);
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
                    <li class="active">Edit Partner</li>
                </ul>
            </div>
        </div>
</div>


<form method="post" onSubmit="return valid();">
<input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
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
                                <h2 class="title">Edit Partner</h2>
                            </div>
                        </div>

                        </div>
                    </div>
   
        <div class="panel-body">
            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Partner ID:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="insurance_id" class="form-control" id="insurance_id" value="<?php echo $partner['insurance_id'];?>" readOnly>
                </div>

                <div class="col-sm-6">
                    <input id="status" name="status"  class="form-check-input" type="checkbox" value="true" 
                    <?php if($partner['status']=='1'){ echo "checked"; } ?> >
                    <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Active
                    </label>
                </div> 
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Partner Name:</label>
                <div class="col-sm-10">
                    <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="insurance_company"  class="form-control" id="insurance_company" value="<?php echo $partner['insurance_company'];?>" required>
                </div>

                 
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Short Partner Name:</label>
                <div class="col-sm-4">
                    <input id="short_name_partner" name="short_name_partner" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $partner['short_name_partner'];?>" >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
               
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Tax ID / Passport ID:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="13" style="color: #000;border-color:#102958;" type="text" name="tax_id" class="form-control" id="tax_id" value="<?php echo $partner['tax_id'];?>" >
                </div>

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Currency:</label>
                <div class="col-sm-4">
                    <select style="border-color:#102958; color: #000;" name="id_currency_list" class="form-control" id="id_currency_list"  >
                        <?php foreach ($currency  as $value_currency) { ?>
                        <option value="<?php echo $value_currency['id']?>"
                            <?php echo ($partner['id_currency_list'] == $value_currency['id']) ? 'selected' : ''; ?>
                            ><?php echo $value_currency['currency'];?></option>
                        <?php } ?>
                            <!-- <option value="1" <?php echo ($partner['id_currency_list'] == 1) ? 'selected' : ''; ?>>THB(ไทย)</option>
                            <option value="2" <?php echo ($partner['id_currency_list'] == 2) ? 'selected' : ''; ?>>USD(ดอลลาร์สหรัฐ)</option>
                            <option value="3" <?php echo ($partner['id_currency_list'] == 3) ? 'selected' : ''; ?>>EUR(ยูโร)</option> -->
                    </select>
                </div>
                 
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Mobile:</label>
                <div class="col-sm-4">
                    <input minlength="10" maxlength="12" style="color: #000;border-color:#102958;" type="text" name="phone" class="form-control" id="phone" value="<?php echo $partner['phone'];?>" pattern="\d{3}-\d{3}-\d{4}">
                </div>   
				<script>
					document.getElementById('phone').addEventListener('input', function (e) {
						var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
						e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
					});
				</script>

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Tel:</label>
                <div class="col-sm-4">
                    <input id="tel" name="tel" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $partner['tel'];?>" >
                </div>

            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="email" name="email" class="form-control" id="email" value="<?php echo $partner['email'];?>" >
                </div>

                <label style="color: #102958;"  class="col-sm-2 col-form-label">Web Company:</label>
                <div class="col-sm-4">
                    <input id="web_company" name="web_company" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $partner['web_company'];?>" >
                </div>
               
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">

                 <label style="color: #102958;" class="col-sm-2 col-form-label">Fax:</label>
                <div class="col-sm-4">
                    <input id="fax" name="fax" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $partner['fax'];?>" >
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

			<div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Address No:</label>
                <div class="col-2">
                    <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="address_number"  class="form-control" id="address_number" value="<?php echo $partner['address_number'];?>"  >
                </div>
				<label style="color: #102958;" for="staticEmail" class="col-sm-1 col-form-label">Soi:</label>
                <div class="col">
                    <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="soi"  class="form-control" id="soi" value="<?php echo $partner['soi'];?>"  >
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-1 col-form-label">Road:</label>
                <div class="col">
                    <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="road"  class="form-control" id="road" value="<?php echo $partner['road'];?>"  >
                </div> 
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Building Name:</label>
                <div class="col">
                    <input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="building_name" class="form-control" id="building_name" value="<?php echo $partner['building_name'];?>"  >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
				<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Province:</label>
                <div class="col-sm-4">
                     <select style="color: #000;border-color:#102958;" name="province" class="form-control selectpicker" id="province" data-live-search="true" >
                                <option value="" selected>Select Province</option>
								<?php foreach($provinces as $province) { ?>
						<option value="<?php echo $province['code']?>" <?php echo ($partner['province'] == $province['code']) ? 'selected' : ''; ?>><?php echo $province['name_en'];?></option>
								<?php }?>
                        </select>
               
                </div>
                
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">District:</label>
                <div class="col-sm-4">
                     <select style="color: #000;border-color:#102958;" name="district" class="form-control selectpicker" id="district" data-live-search="true" >
                                <option value="" selected>Select District</option>
								<?php 
                                if($partner['province']!=""){
								    $districts = get_district_by_province($conn, $partner['province']);
                                } 
                                ?>
						<?php foreach($districts as $district) { ?>
						<option value="<?php echo $district['code']?>" <?php echo ($partner['district'] == $district['code']) ? 'selected' : '';?>><?php echo $district['name_en'];?></option>
						<?php } ?>
                        </select>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Sub-district:</label>
                <div class="col-sm-4">
                    <select id="sub_district" name="sub_district" style="color: #000;border-color:#102958;"
                     class="form-control selectpicker" data-live-search="true" >
                        
                       <option value="" selected>Select Subdistrict</option>
                                <?php 
                                $subdistricts = get_subdistrict_by_district($conn, $partner['district']);
                                foreach ($subdistricts as $sub) { ?>
                        <option value="<?php echo $sub['code']?>" <?php echo ($partner['sub_district'] == $sub['code']) ? 'selected' : '';?>><?php echo $sub['name_en'];?></option>
                        <?php } ?>  
                    </select>
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Post Code:</label>
                <div class="col-sm-4">
					<input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="post_code" id="post_code" class="form-control" value="<?php echo $partner['post_code'];?>" >
                </div>
            </div>

            <br>
        </div>
    </div>
</div>

<div class="container-fluid">
		
    <?php 
    $start_bank = "true";
    $x = 0;
    foreach ($banks as $bank) { $x++; ?>  

   
    <div  id="bank_section_bank<? echo $x; ?>">
        <div class="panel">


			<div class="panel-heading">
                    <div class="form-group  col-md-10 col-md-offset-1">
                        <div class="col-sm-5">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Partner Bank Details</h2>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                            <!-- style="background-color: #0275d8;color: #F9FAFA;" -->
                        </div>
                    </div>

    <?php if($start_bank=="false"){ ?>
        <div class="col text-right">
            <button id="bank<?php echo $x; ?>"  type="button" class="btn btn_remove_bank" name="remove" style="background-color: #0275d8;color: #F9FAFA;"  >X</button>
        </div>&nbsp;&nbsp;

        <script type="text/javascript">
                $(document).on('click', '.btn_remove_bank', function() {
                var button_id = $(this).attr("id");
                    $('#bank_section_' + button_id + '').remove();
                    $('#' + button_id + '').remove();
                });
        </script>
    <? }else{ $start_bank = "false"; } ?>

                <div class=" text-right">
                    <div class="bank-clone-cancel<? echo $x; ?>" id="bank-clone-cancel<? echo $x; ?>" ></div>
                </div>
            </div>

            <div class="panel-body">

    			<div class="form-group row col-md-10 col-md-offset-1" >

                    <input hidden="true" id="id_bank<? echo $x; ?>" name="id_bank[]" type="text" class="form-control" value="<? echo $bank['id']; ?>"  >
                    <label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Bank Name:</label>
                    <div class="col-sm-4">
                    <input id="bank_name" name="bank_name[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $bank['bank_name'];?>" >                    
                    </div>
                    
                    <label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Bank Account:</label>
                    <div class="col-sm-4">
                    <input id="bank_account" name="bank_account[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $bank['bank_account'];?>" >
        			</div>  
        		</div>  
        		
        		<div class="form-group row col-md-10 col-md-offset-1" >
                    <label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Bank Type:</label>
                    <div class="col-sm-4">
                    <input id="bank_type" name="bank_type[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"  class="form-control" value="<?php echo $bank['bank_type'];?>" >                   
                    </div>
                    
                    <label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Bank Account Name:</label>
                    <div class="col-sm-4">
                    <input id="bank_account_name" name="bank_account_name[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"  class="form-control" value="<?php echo $bank['bank_account_name'];?>">  
        			</div>  
        	
        		</div>  
        	</div> <!-- BANK SECTION -->
        </div>
        
		
    </div>
    <?php } ?>

    <?php if(count($banks)==0){ $x++; ?>  

    <div  id="bank_section_bank<? echo $x; ?>">
        <div class="panel">

                <div class="panel-heading">
                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col-sm-5">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Partner Bank Details</h2>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                        </div>
                    </div>
                    <div class="bank-clone-cancel<? echo $x; ?>" id="bank-clone-cancel<? echo $x; ?>" ></div>
                </div>

            <div class="panel-body">

                <div class="form-group row col-md-10 col-md-offset-1" >
                    <!-- hidden="true" -->
                    <input hidden="true" id="id_bank<? echo $x; ?>" name="id_bank[]" type="text" class="form-control" value="" >
                    <label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Bank Name:</label>
                    <div class="col-sm-4">
                    <input id="bank_name" name="bank_name[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $bank['bank_name'];?>"  >                    
                    </div>
                    
                    <label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Bank Account:</label>
                    <div class="col-sm-4">
                    <input id="bank_account" name="bank_account[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $bank['bank_account'];?>" >
                    </div>  
                </div>  
                
                <div class="form-group row col-md-10 col-md-offset-1" >
                    <label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Bank Type:</label>
                    <div class="col-sm-4">
                    <input id="bank_type" name="bank_type[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"  class="form-control" value="<?php echo $bank['bank_type'];?>" >                   
                    </div>
                    
                    <label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Bank Account Name:</label>
                    <div class="col-sm-4">
                    <input id="bank_account_name" name="bank_account_name[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"  class="form-control" value="<?php echo $bank['bank_account_name'];?>" >  
                    </div>  
            
                </div>  
            </div> <!-- BANK SECTION -->
        </div>
        
        
    </div>
    <?php } ?>

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
                            <select id="product_id" name="product_id[]" style="color: #000;border-color:#102958;" class="form-control selectpicker" data-live-search="true" multiple="multiple" title="Search Products" required>
                                <?php foreach ($products as $p) { ?>
                                    <option value="<?php echo $p['id'];?>" 
                                        <?php foreach ($rela_products as $rela){ if($p['id']==$rela['id_product']){ echo "selected"; }  } ?>
                                    ><?php echo $p['product_name'];?></option>
                                <?php } ?> 
                            </select>
                        </div>
                    </div>

                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">
                            <textarea id="product_name_all" name="product_name_all" class="form-control" style="color: #000;border-color:#102958;" rows="1" readonly>
                            </textarea>
                        </div>
                    </div>

                    <script>
                        var selectedOptions = Array.from(document.getElementById("product_id").selectedOptions).map(option => option.textContent);
                        var selectedOptionsText = selectedOptions.join("\n");
                        document.getElementById("product_name_all").value = selectedOptionsText;
                        var lineCount = (selectedOptionsText.match(/\n/g) || []).length + 1;
                        document.getElementById("product_name_all").rows = lineCount;

                        document.getElementById("product_id").addEventListener("change", function() {
                            var selectedOptions = Array.from(this.selectedOptions).map(option => option.textContent);
                            var selectedOptionsText = selectedOptions.join("\n");
                            // var selectedOptionsText = selectedOptions.join(", ");
    
                            // ใส่ค่าที่เลือกทั้งหมดลงใน textarea ที่มี id เป็น product_name_all
                            document.getElementById("product_name_all").value = selectedOptionsText;
                            var lineCount = (selectedOptionsText.match(/\n/g) || []).length + 1;
                            document.getElementById("product_name_all").rows = lineCount;
                        });
                    </script>

                    <!-- <div class="form-group row col-md-10 col-md-offset-1">
                        <textarea name="product_note" class="form-control" style="color: #0C1830;border-color:#102958;" id="product_name" rows="3" readonly>
                        <?php //foreach ($products as $p) { 
                                //foreach ($rela_products as $rela){
                                    //if($p['id']==$rela['id_product']){  ?>
                                <?php //echo $p['product_name'];?>
                        <?php //}}} ?>
                        </textarea>
                    </div> -->

                    <!-- <div class="form-group row col-md-10 col-md-offset-1">
                        <?php //foreach ($products as $p) { ?>
                        <div class="col-sm-4">
                                <input class="form-check-input" type="checkbox" value="<?php //echo $p['id'];?>" name="product_id[]" id="<?php //echo $p['product_name'];?>"  
                                <?php //foreach ($rela_products as $rela){ if($p['id']==$rela['id_product']){ echo "checked"; }  } ?>
                                >
                                <label class="form-check-label" for="<?php //echo $p['product_name'];?>" >
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $p['product_name'];?>
                                </label>
                		</div>
                		<?php //} ?>
                    </div> -->

                </div>

            </div>
        </div>
    </div>
</div>       

<div class="container-fluid">		
	
    <?php 
    $start_under = "true";
    $index_under = 0;
    foreach ($under as $data_under) { $index_under++; ?>

		<div id="under_section_under<? echo $index_under; ?>">
            <div class="panel">
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

    <?php if($start_under=="false"){ ?>
        <div class="col text-right">
            <button id="under<?php echo $index_under; ?>"  type="button" class="btn btn_remove_under" name="remove" style="background-color: #0275d8;color: #F9FAFA;"  >X</button>
        </div>&nbsp;&nbsp;

        <script type="text/javascript">
                $(document).on('click', '.btn_remove_under', function() {
                var button_id = $(this).attr("id");
                    $('#under_section_' + button_id + '').remove();
                    $('#' + button_id + '').remove();
                });
        </script>
    <? }else{ $start_under = "false"; } ?>    

                    <div class=" text-right">
                        <div class="under-clone-cancel<? echo $index_under; ?>" id="under-clone-cancel<? echo $index_under; ?>" ></div>
                    </div>
                </div>


            <div class="panel-body"> 

                <div class="form-group row col-md-10 col-md-offset-1">
                    <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Under Code:</label>
                    <div class="col-sm-4">
                        <input id="agent_code<?php echo $index_under; ?>" name="agent_code[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $data_under['under_code']; ?>" readonly>
                    </div>


                    <input hidden="true" id="id_under<? echo $index_under; ?>" name="id_under[]" type="text" class="form-control" value="<? echo $data_under['id']; ?>" >
                    <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Under Name:</label>
                    <div class="col-sm-4">
                        <!-- data-live-search="true" selectpicker -->

                        <select id="agent_under<?php echo $index_under; ?>" name="agent_under[]" style="color: #000;border-color:#102958;"  class="form-control " >
                            <option value="" selected>Select Agent</option>
                            <?php foreach ($agents as $a) { ?>
                            <option value="<?php echo $a['id']?>" 
                              <?php if($a['id']==$data_under['id_agent']){ echo "selected"; } ?>
                                ><?php echo $a['first_name'].' '.$a['last_name'];?></option>
                            <?php } ?>  
                        </select> 

                    </div>
                </div>

                <div class="form-group row col-md-10 col-md-offset-1">
                    <div class="col-sm-2 " >
                         <label style="color: #102958;" for="staticEmail" >Percentage Value:</label>
                    </div>

                    <div class="col-sm-4">
                    <input id="agent_percent1" name="agent_percent[]" type="text" value="<?php echo number_format((float)$data_under['percen_value'], 2, '.', ',').'%'; ?>" class="form-control" style="border-color:#102958;" onchange="
                        var num = $(this).val().replace(/,/g,'');
                        // if (/^\d*\.?\d+$/.test(num)) {
                        if (parseFloat(num)) {
                            if (parseFloat(num)>100){
                                this.value=parseFloat(100.00).toFixed(2)+'%';
                            }else{
                                this.value=parseFloat(num).toFixed(2)+'%';
                            } 
                        }else{
                            this.value='';
                        }
                    " />
                    </div>

                    <div class="col-sm-4">
                        <input id="default_type_per1" name="default_type<? echo $index_under; ?>" value="Percentage" class="form-check-input" type="radio" 
                        <?php if($data_under['type_default']=='Percentage'){ echo "checked"; } ?> >
                        <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                            &nbsp;&nbsp;&nbsp;&nbsp; Default Percentage
                        </label>
                    </div>
                </div>

                <div class="form-group row col-md-10 col-md-offset-1">
                    <div class="col-sm-2 " >
                         <label style="color: #102958;" for="staticEmail" >Net Value:</label>
                    </div>

                    <div class="col-sm-4">
                        <input id="agent_net1" name="agent_net[]" type="text" value="<?php echo number_format((float)$data_under['net_value'], 2, '.', ','); ?>" class="form-control" style="border-color:#102958;" onchange="
                            var num = $(this).val().replace(/,/g,'');
                            // if (parseFloat(num)) {
                            if (/^\d*\.?\d+$/.test(num)) {
                                 var value_con  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(num);
                                this.value=value_con;
                            }else{
                                this.value='';
                            }
                        "/>
                    </div>
                    <div class="col-sm-4">
                        <input id="default_type_net1" name="default_type<? echo $index_under; ?>" value="Net Value" class="form-check-input" type="radio"
                        <?php if($data_under['type_default']=='Net Value'){ echo "checked"; } ?> >
                        <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                            &nbsp;&nbsp;&nbsp;&nbsp; Default Net Value
                        </label>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php } ?>

	<?php if($check_null=="true"){ ?>

		<div class="row " id="under_section_clone">
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
				</div>

				<div class="panel-body">
					<div class="form-group row col-md-10 col-md-offset-1">
						
						<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Under Code:</label>
						<div class="col-sm-4">
							<input minlength="1" maxlength="50" name="agent_code[]" id="agent_code" style="color: #000;border-color:#102958;" type="text"  class="form-control" value="" readonly>
						</div>

						<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Under Name:</label>
						<div class="col-sm-4">
							<!-- data-live-search="true" selectpicker -->
							<select style="color: #000;border-color:#102958;" name="agent_under[]" id="agent_under"  class="form-control " >
								<option value="" selected>Select Agent</option>
								<?php foreach ($agents  as $a) { ?>
									<option value="<?php echo $a['id']?>"><?php echo $a['first_name'].' '.$a['last_name'];?></option>
								<?php } ?>  
							</select>                    

						</div>
						
					</div>



			</div>

		   </div> 

		   </div>
		</div>
		</div>

	<?php } ?>

    <?php if(count($under)==0){ $x=1; ?> 
        <div id="under_section_under<? echo $x; ?>">
            <div class="panel">
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
            </div>

            <div class="panel-body">   
                <div class="form-group row col-md-10 col-md-offset-1">

                    <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Under Code:</label>
                    <div class="col-sm-4">
                         <input id="agent_code" name="agent_code[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" id="success" value="<?php echo $data_under['under_code']; ?>" readonly>
                    </div>

                    <input hidden="true" id="id_under<? echo $x; ?>" name="id_under[]" type="text" class="form-control" value="" >
                    <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Under Name:</label>
                    <div class="col-sm-4">
                         <select id="agent_under" name="agent_under[]" style="color: #000;border-color:#102958;" data-live-search="true"  class="form-control selectpicker" >
                            <option value="" selected>Select Agent</option>
                            <?php foreach ($agents  as $a) { ?>
                            <option value="<?php echo $a['id']?>"
                              <?php if($a['id']==$data_under['id_agent']){ echo "selected"; } ?>
                                ><?php echo $a['first_name'].' '.$a['last_name'];?></option>
                            <?php } ?>  
                        </select>
                    </div>

                </div>

                <div class="form-group row col-md-10 col-md-offset-1">
                    <div class="col-sm-2 " >
                         <label style="color: #102958;" for="staticEmail" >Percentage Value:</label>
                    </div>

                    <div class="col-sm-4">
                    <input id="agent_percent1" name="agent_percent[]" type="text" value="<?php echo number_format((float)$data_under['percen_value'], 2, '.', ',').'%'; ?>" class="form-control" style="border-color:#102958;" onchange="
                        var num = $(this).val().replace(/,/g,'');
                        // if (/^\d*\.?\d+$/.test(num)) {
                        if (parseFloat(num)) {
                            if (parseFloat(num)>100){
                                this.value=parseFloat(100.00).toFixed(2)+'%';
                            }else{
                                this.value=parseFloat(num).toFixed(2)+'%';
                            } 
                        }else{
                            this.value='';
                        }
                    " />
                    </div>

                    <div class="col-sm-4">
                        <input id="default_type_per1" name="default_type<? echo $x; ?>" value="Percentage" class="form-check-input" type="radio" checked>
                        <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                            &nbsp;&nbsp;&nbsp;&nbsp; Default Percentage
                        </label>
                    </div>
                </div>

                <div class="form-group row col-md-10 col-md-offset-1">
                    <div class="col-sm-2 " >
                         <label style="color: #102958;" for="staticEmail" >Net Value:</label>
                    </div>

                    <div class="col-sm-4">
                        <input id="agent_net1" name="agent_net[]" type="text" value="<?php echo number_format((float)$data_under['net_value'], 2, '.', ','); ?>" class="form-control" style="border-color:#102958;" onchange="
                            var num = $(this).val().replace(/,/g,'');
                            // if (parseFloat(num)) {
                            if (/^\d*\.?\d+$/.test(num)) {
                                 var value_con  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(num);
                                this.value=value_con;
                            }else{
                                this.value='';
                            }
                        "/>
                    </div>
                    <div class="col-sm-4">
                        <input id="default_type_net1" name="default_type<? echo $x; ?>" value="Net Value" class="form-check-input" type="radio"
                        <?php if($data_under['type_default']=='Net Value'){ echo "checked"; } ?> >
                        <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                            &nbsp;&nbsp;&nbsp;&nbsp; Default Net Value
                        </label>
                    </div>
                </div>


            </div>

        </div>
    </div>
    <?php } ?>

	<div class="under-section-clone" id="under-section-clone" ></div>

    <div class="row">
        <div  class="col-sm-12 text-right  ">
            <div style="padding-top: 10px;">
             <button style="background-color: #0275d8;color: #F9FAFA;" type="button" name="add_more_under" class="btn" id="add-under">+ Add More Under Code<span class="btn-label btn-label-right"><i class="fa "></i></span></button>
            </div>
        </div>
    </div>
    <br/>

</div>

	<?php $x=0; foreach ($under as $data_under) { $x++; ?>
			<script>
				// var selectElement = document.getElementById("agent_under<?php echo $x; ?>");
				// selectElement.setAttribute("data-live-search", "true");
				// selectElement.classList.add("selectpicker");
				// $('.selectpicker').selectpicker();

				// selectElement.setAttribute("data-live-search", "true");
				$('#agent_under<?php echo $x; ?>').change(function(){
					$.get('get_agent_under.php?id=' + $(this).val()+"&partner_id="+"<? echo $_GET[id]; ?>", function(data){
						var result = JSON.parse(data);
						$("#agent_code<?php echo $x; ?>").val("");
						$.each(result, function(index, item){
							$("#agent_code<?php echo $x; ?>").val(item.under_code);
						});
					});
				});
			</script>
	<? } ?>

       
<div class="container-fluid">            
		
	<?php 
    $start_contact = "true";
    $x = 0;
    if (count($contacts) > 0) {?>
        <?php foreach ($contacts as $contact) { $x++; ?>
    
       <div class="row " id="contact-section_con<? echo $x; ?>">
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

    <?php if($start_contact=="false"){ ?>
        <div class="col text-right">
            <button id="con<?php echo $x; ?>"  type="button" class="btn btn_remove_con" name="remove" style="background-color: #0275d8;color: #F9FAFA;"  >X</button>
        </div>&nbsp;&nbsp;

        <script type="text/javascript">
                $(document).on('click', '.btn_remove_con', function() {
                var button_id = $(this).attr("id");
                    $('#contact-section_' + button_id + '').remove();
                    $('#' + button_id + '').remove();
                });
        </script>
    <? }else{ $start_contact = "false"; } ?>

                        <div class=" text-right">
                             <div class="contact-clone-cancel<? echo $x; ?>" id="contact-clone-cancel<? echo $x; ?>" ></div>
                        </div>
                    </div>
   
        <div class="panel-body">
            <div class="form-group row col-md-10 col-md-offset-1" >
                <!-- hidden="true" -->
                <input hidden="true" id="id_contact<? echo $x; ?>" name="id_contact[]" type="text" class="form-control" value="<? echo $contact['id']; ?>" >
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Title:</label>
                <div class="col-2">                   
                     <select id="contact_title_name" name="contact_title_name[]" id="input_title_contact" style="border-color:#102958; color: #000;" class="form-control"   required>
                            <option value="Mr." <?php echo (trim($contact['title_name'])=="Mr.") ? 'selected' : '';?>>Mr.</option>
                            <option value="Ms." <?php echo (trim($contact['title_name'])=="Ms.") ? 'selected' : '';?>>Ms.</option>
                            <option value="Mrs." <?php echo (trim($contact['title_name'])=="Mrs.") ? 'selected' : '';?>>Mrs.</option>       
                    </select>    
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">First name:</label>
                <div class="col-4">
                    <input id="contact_first_name" name="contact_first_name[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"  class="form-control" value="<?php echo $contact['first_name']; ?>" >
                </div>

                <label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Last name:</label>
                <div class="col-4">
                    <input id="contact_last_name" name="contact_last_name[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $contact['last_name']; ?>" >
                </div>
            </div>
			
			<div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Nickname:</label>
                <div class="col-4">
                    <input id="contact_nick_name" name="contact_nick_name[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $contact['nick_name']; ?>">
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                
                 <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Mobile:</label>
                <div class="col-4">
                    <input id="contact_mobile<?php echo $x; ?>" name="contact_mobile[]" minlength="10" maxlength="12" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $contact['mobile']; ?>" pattern="\d{3}-\d{3}-\d{4}">
                </div>
                <script>
                    document.getElementById('contact_mobile<?php echo $x; ?>').addEventListener('input', function (e) {
                        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                        e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
                    });
                </script>

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Tel:</label>
                <div class="col-4">
                    <input id="contact_tel" name="contact_tel[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $contact['tel']; ?>">
                </div>
            </div>


            <div class="form-group row col-md-10 col-md-offset-1" >
                
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Line ID:</label>
                <div class="col-4">
                    <input id="contact_line_id" name="contact_line_id[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $contact['line_id']; ?>" >
                </div>
				
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
                <div class="col-4">
                    <input id="contact_email" name="contact_email[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="email" class="form-control"  value="<?php echo $contact['email']; ?>" >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Position:</label>
                <div class="col-4">
                    <input id="contact_position" name="contact_position[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $contact['position']; ?>" >
               
                </div>

				<label style="color: #102958;" class="col-sm-2 col-form-label">Department:</label>
                <div class="col-4">
                    <input id="department" name="department[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $contact['department']; ?>" >
                </div>
                
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;" class="col-sm-2 col-form-label">Remark:</label>
                <div class="col-10">
                    <textarea id="contact_remark" name="contact_remark[]" minlength="1" maxlength="255" rows="2" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $contact['remark']; ?>"></textarea>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <div class="col-sm-2">
                </div>  
                <div class="col-sm-4">
                <div class="form-check" style="top:5px">
                    <input id="hid_default<? echo $x; ?>" name="hid_default[]" hidden="true" type="text" value="<? echo $x; ?>" >
                    <input id="id_default<? echo $x; ?>" name="default_contact[]" class="form-check-input" type="radio" value="<? echo $x; ?>"  
                    <?php if($contact['default_contact']=='1'){ echo "checked";} ?> >
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
<?php }} ?>
<?php if(count($contacts)==0){ $x=1; ?> 

    <div class="row " id="contact-section_con<? echo $x; ?>">
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
                    </div>
   
        <div class="panel-body">
            <div class="form-group row col-md-10 col-md-offset-1" >
                <!-- hidden="true" -->
                 <input hidden="true" id="id_contact<? echo $x; ?>" name="id_contact[]" type="text" class="form-control" value="" >
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Title:</label>
                <div class="col-2">
                     
                     <select id="contact_title_name" name="contact_title_name[]" id="input_title_contact" style="border-color:#102958; color: #000;" class="form-control"   >
                            <option value="Mr." <?php echo (trim($contact['title_name'])=="Mr.") ? 'selected' : '';?>>Mr.</option>
                            <option value="Ms." <?php echo (trim($contact['title_name'])=="Ms.") ? 'selected' : '';?>>Ms.</option>
                            <option value="Mrs." <?php echo (trim($contact['title_name'])=="Mrs.") ? 'selected' : '';?>>Mrs.</option>       
                    </select>    
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>First name:</label>
                <div class="col-4">
                    <input id="contact_first_name" name="contact_first_name[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"  class="form-control" value="<?php echo $contact['first_name']; ?>" required>
                </div>

                <label  style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Last name:</label>
                <div class="col-4">
                    <input id="contact_last_name" name="contact_last_name[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $contact['last_name']; ?>" required>
                </div>
            </div>
			
			<div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Nickname:</label>
                <div class="col-4">
                    <input id="contact_nick_name" name="contact_nick_name[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $contact['nick_name']; ?>">
                </div> 
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Mobile:</label>
                <div class="col-4">
                    <input id="contact_mobile" name="contact_mobile[]" minlength="10" maxlength="12" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $contact['mobile']; ?>" required pattern="\d{3}-\d{3}-\d{4}">
                </div>
                <script>
                    document.getElementById('contact_mobile').addEventListener('input', function (e) {
                        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                        e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
                    });
                </script>

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Tel:</label>
                <div class="col-4">
                    <input id="contact_tel" name="contact_tel[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $contact['tel']; ?>">
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Line ID:</label>
                <div class="col-4">
                    <input id="contact_line_id" name="contact_line_id[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $contact['line_id']; ?>" >
                </div>
				
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
                <div class="col-4">
                    <input id="contact_email" name="contact_email[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="email" class="form-control"  value="<?php echo $contact['email']; ?>" >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Position:</label>
                <div class="col-4">
                    <input id="contact_position" name="contact_position[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $contact['position']; ?>" >
               
                </div>

				<label style="color: #102958;" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Department:</label>
                <div class="col-4">
                    <input id="department" name="department[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  value="<?php echo $contact['department']; ?>" required>
                </div>
				
               
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <label style="color: #102958;" class="col-sm-2 col-form-label">Remark:</label>
                <div class="col-10">
                    <textarea id="contact_remark" name="contact_remark[]" minlength="1" maxlength="255" rows="2" style="color: #000;border-color:#102958;"  class="form-control"  value="<?php echo $contact['remark']; ?>"></textarea>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <div class="col-sm-2">
                </div>  
                <div class="col-sm-4">
                <div class="form-check" style="top:5px">
                    <input id="hid_default<? echo $x; ?>" name="hid_default[]" hidden="true" type="text" value="<? echo $x; ?>" >
                    <input id="id_default<? echo $x; ?>" name="default_contact[]" class="form-check-input" type="radio" value="<? echo $x; ?>"  
                     checked>
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

<?php } ?>

    <div class="contact-section-clone" id="contact-section-clone" ></div>	

    <div class="row">
        <div  class="col-sm-12 text-right  ">
            <div style="padding-top: 10px;">
             
             <button style="background-color: #0275d8;color: #F9FAFA;" type="button" name="add_more_contacts" class="btn" id="add-con">+ Add More Contact<span class="btn-label btn-label-right"><i class="fa "></i></span></button>
            </div>
        </div>
    </div>
    <br/>
</div>
 

    <div class="container-fluid">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel">
                <div class="panel-body">

                <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-md-12">
                    <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
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

    <br><br><br>
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
                $('#example').DataTable();

                $('#example2').DataTable( {
                    "scrollY":        "300px",
                    "scrollCollapse": true,
                    "paging":         false
                } );

                $('#example3').DataTable();
            });
            
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
						var options = $("#district");
                        options.append($("<option />").val("").text("Select District"));
						//don't forget error handling!
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
						var options = $("#sub_district");
                        options.append($("<option />").val("").text("Select Sub-district"));
						//don't forget error handling!
						 var zipcodes_tmp = [];
						$.each(obj, function(item) {
						  
							console.log(item);
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
				
				var contact_ct = 1;
				$('#add-con').click(function(){	
                  
					// $("#contact-section_con1").clone().attr('id', 'contact-section_'+contact_ct).appendTo(".contact-section-clone");
                    clone = $('#contact-section_con1').clone();
                    clone.attr('id', 'contact-section_'+contact_ct);

                    clone.find("#id_default1").attr('checked', false);
                    clone.find("#id_contact1").attr('id','id_contact_new'+contact_ct);

                    clone.find("#id_default1").attr('id','id_default_new'+contact_ct).val("new"+contact_ct);
                    clone.find("#hid_default1").attr('id','hid_default_new'+contact_ct).val("new"+contact_ct);

                    clone.find("#contact_title_name").val("Mr.");
                    clone.find("#contact_first_name").val("");
                    clone.find("#contact_last_name").val("");
                    clone.find("#contact_nick_name").val("");
                    clone.find("#contact_tel").val("");

                    clone.find("#contact_mobile1").val("");
                    clone.find("#contact_mobile1").attr('id','contact_mobile_new'+contact_ct);

                    clone.find("#contact_email").val("");
                    clone.find("#contact_line_id").val("");
                    clone.find("#contact_position").val("");
                    clone.find("#contact_remark").val("");
                    clone.find("#department").val("");

                    clone.find("#contact-clone-cancel1").attr('id','contact-clone-cancel-new'+contact_ct);

                    clone.appendTo(".contact-section-clone");
                    document.getElementById("id_contact_new"+contact_ct).value = "";

                    var body_add ='<script>';
                    body_add +='document.getElementById("contact_mobile_new'+contact_ct+'").addEventListener("input", function (e) {';
                    body_add +='    var x = e.target.value.replace(/'+'\\D/'+'g,'+"''"+').match(/'+'(\\d{0,3})(\\d{0,3})(\\d{0,4})/'+');';
                    body_add +='    e.target.value = !x[2] ? x[1] : x[1] + '+"'-'"+' + x[2] + (x[3] ? '+"'-'"+' + x[3] : '+"''"+');';
                    body_add +='});';
                    body_add +='</'+'script>';
                    $("#contact-section-clone").append(body_add);

                      var body_add ='<div id="'+ contact_ct +'" >';
                    body_add +='<div class="col text-right">';
                    body_add +='<button type="button" class="btn btn_remove_con_new" name="remove" style="background-color: #0275d8;color: #F9FAFA;" id="'+ contact_ct +'">X</button>';
                    body_add +='</div>&nbsp;&nbsp;';
                    $("#contact-clone-cancel-new"+contact_ct).append(body_add);

					contact_ct++;
				});
                $(document).on('click', '.btn_remove_con_new', function() {
                    var button_id = $(this).attr("id");
                    $('#contact-section_' + button_id + '').remove();
                    $('#' + button_id + '').remove();
                });


				var bank_ct = 1;
				$('#add-bank').click(function(){
                    
					// $("#bank_section_bank1").clone().attr('id', 'bank-section_new'+bank_ct).appendTo(".bank-section-clone");
                    clone = $('#bank_section_bank1').clone();
                    clone.attr('id', 'bank-section_new'+bank_ct);
                    clone.find("#id_bank1").attr('id','id_bank_new'+bank_ct);

                    clone.find("#bank_name").val("");
                    clone.find("#bank_account").val("");
                    clone.find("#bank_type").val("");
                    clone.find("#bank_account_name").val("");

                    clone.find("#bank-clone-cancel1").attr('id','bank-clone-cancel-new'+bank_ct);

                    clone.appendTo(".bank-section-clone");
                    document.getElementById("id_bank_new"+bank_ct).value = "";

                    var body_add ='<div id="new'+ bank_ct +'" >';
                    body_add +='<div class="col text-right">';
                    body_add +='<button type="button" class="btn btn_remove_bank_new" name="remove" style="background-color: #0275d8;color: #F9FAFA;" id="new'+ bank_ct +'">X</button>';
                    body_add +='</div>&nbsp;&nbsp;';
                    $("#bank-clone-cancel-new"+bank_ct).append(body_add);  

					bank_ct++;
				});
                $(document).on('click', '.btn_remove_bank_new', function() {
                    var button_id = $(this).attr("id");
                    $('#bank-section_' + button_id + '').remove();
                    $('#' + button_id + '').remove();
                });
				
				// var under_ct = 1;
                var under_ct = <?php echo $index_under; ?>;
                if(under_ct==''){
                    under_ct = 1;
                }
                // alert('under_ct:'+under_ct);
				$('#add-under').click(function(){	
					// $("#under_section_under1").clone().attr('id', 'under-section_new'+under_ct).appendTo(".under-section-clone");
                    clone = $('#under_section_under1').clone();


                    clone.attr('id', 'under-section_new'+under_ct);
                    clone.find("#id_under1").attr('id','id_under_new'+under_ct);

                    clone.find("#agent_under1").attr('id','agent_under_new'+under_ct).val("");
                    clone.find("#agent_code1").attr('id','agent_code_new'+under_ct).val("");

                    clone.find("#default_type_per1").prop('checked', true).attr('name','default_type'+(under_ct+1));
                    clone.find("#default_type_net1").removeAttr('checked').attr('name','default_type'+(under_ct+1));
                    // clone.find("#default_type1").attr('name','default_type'+(under_ct+1));

                    clone.find("#agent_percent1").attr('id','agent_percent_new'+under_ct).val("");
                    clone.find("#agent_net1").attr('id','agent_net_new'+under_ct).val("");

                    clone.appendTo(".under-section-clone");

                    document.getElementById("id_under_new"+under_ct).value = "";
                    document.getElementById("agent_under_new"+under_ct).value = "";
                    // $("agent_under_new"+ under_ct).selectpicker('refresh');

                    var body_add ='';
                    body_add +='<script>';

                    body_add +='var selectElement = document.getElementById('+"'agent_under_new"+under_ct+"'"+');';

                    // body_add +='selectElement.removeAttribute("data-live-search");';
                    // body_add +='selectElement.classList.remove("selectpicker");';
                    // body_add +='$(".selectpicker").selectpicker("destroy");';

                    // body_add +='selectElement.setAttribute("data-live-search", "true");';
                    // body_add +='selectElement.classList.add("selectpicker");';
                    // body_add +='$(".selectpicker").selectpicker();';

                    body_add +='    $('+"'#agent_under_new"+under_ct+"'"+').change(function(){';
                    // body_add +='        $.get("get_agent_under.php?id=" + $(this).val(), function(data){';
                    body_add +='        $.get("get_agent_under.php?id=" + $(this).val()+"&partner_id="+"<? echo $_GET[id]; ?>", function(data){';
                    body_add +='            var result = JSON.parse(data);';
                    body_add +='            $('+"'#agent_code_new"+under_ct+"'"+').val("");';
                    body_add +='            $.each(result, function(index, item){';
                    body_add +='                $('+"'#agent_code_new"+under_ct+"'"+').val(item.under_code);';
                    body_add +='            });';
                    body_add +='        });';
                    body_add +='    });';
                    body_add +='</'+'script>';

                    clone.find("#under-clone-cancel1").attr('id','under-clone-cancel-new'+under_ct);

                    $("#under-section-clone").append(body_add);

                    var body_add ='<div id="new'+ under_ct +'" >';
                    body_add +='<div class="col text-right">';
                    body_add +='<button type="button" class="btn btn_remove_under_new" name="remove" style="background-color: #0275d8;color: #F9FAFA;" id="new'+ under_ct +'">X</button>';
                    body_add +='</div>&nbsp;&nbsp;';
                    $("#under-clone-cancel-new"+under_ct).append(body_add);

                    // alert('not checked');
					under_ct++;
				});
                $(document).on('click', '.btn_remove_under_new', function() {
                    var button_id = $(this).attr("id");
                    $('#under-section_' + button_id + '').remove();
                    $('#' + button_id + '').remove();
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

