<?php
    include_once('includes/connect_sql.php');
    session_start();
    error_reporting(0);
    include_once('includes/fx_paid_date_db.php');

	if(strlen($_SESSION['alogin'])=="") {
		header('Location: logout.php');
	}

	// $provinces = get_provinces($conn);
	// $districts = get_district_by_province($conn, $provinces[0]['code']);
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!empty($_POST)) {

			// $contacts = get_customer_contact ($conn,$_POST['id']);
			// delete_contact_list($conn,$_POST,$contacts);
			// $insurance_info = get_customer_insurance ($conn,$_POST['id']);
			// delete_insurance_list_data($conn,$_POST,$insurance_info);
			// update_customer($conn, $_POST,$sourceFilePath); 
            update_insurance_info($conn, $_POST);         
			
		}
		// echo '<script>alert("Successfully edited information.")</script>';
		echo "<script>window.location.href ='paid_date_commission.php'</script>";
		// header('Location: customer-information.php');
	}

	if (isset($_GET)) {
		$id = $_GET['id'];

        $policy_id = check_policy($conn,$_GET['id']);
        if(count($policy_id)<=0){
            header("Location: paid_date_commission.php"); 
        }

        $results_insurance = get_insurance_info($conn,$_GET['id']);

        // $results_categories = get_categories($conn);
        // $results_sub = get_sub($conn);
        // $results_company = get_company($conn);

		// $customer_details = get_customer_by_id($conn, $id);

		// $customer_value = $customer_details[0];
	   
		// $contacts = get_customer_contact ($conn, $id);

		// $insurance_info = get_customer_insurance ($conn, $id);
		// $agents = get_agents($conn);
		// $customer_level_list = get_customer_level($conn);
		// $period_list = get_period($conn);
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
                    <li class="active"  ><a href="paid_date_commission.php">Commission List</a></li>
                    <li class="active">Edit Commission</li>
                </ul>
            </div>
        </div>
    </div>

<form method="post" action="edit-paid-date.php" enctype="multipart/form-data" onSubmit="return valid();" >
<input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
<br>
<!-- <section class="section"> -->

<div class="container-fluid">
        <div class="row">

            <div class="col-md-12 ">
                <div class="panel">

                <div class="panel-heading">
                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Insurance information</h2>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                            <!-- style="background-color: #0275d8;color: #F9FAFA;" -->
                        </div>
                         <div class="col-sm-4 text-right ">
                            <br>
                            <!-- href="#"  -->
                            <!-- <a  name="add" id="add" class="btn" style="background-color: #0275d8;color: #F9FAFA;"><i
                                class="fas  fa-sm text-white-50"></i>+ Add More Insurance</a> -->
                        </div>&nbsp;&nbsp;

                        <!-- <button type="button" name="add" id="add">Add Test</button> -->

                        <!-- <div id="dynamic_field"></div> -->
                    </div>
                </div> 

        <div class="panel-body">
            <?php foreach($results_insurance as $result){ ?>
            <div class="form-group row col-md-10 col-md-offset-1" >
                <!-- &nbsp; <p class="pull-right"> -->
                <input hidden="true" id="id_insurance_info" name="id_insurance_info" value="<?php echo $result['id']; ?>" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" id="success" >
                </input>
                <div class="col-sm-2  label_left"  >
                    <label style="color: #102958;" for="staticEmail" >Policy No:</label>
                </div>
                <!-- col-xs-auto -->
                <div class="col ">
                    <input id="policy" name="policy[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text" value="<?php echo $result['policy_no']; ?>" readOnly>
                </div>
                <div class="col-sm-2  label_left" >
                </div>
                <div class="col">
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Status:</label>
                </div>
                <div class="col-2">
                <input id="payment_status" name="payment_status[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text" value="<?php echo $result['status']; ?>" readOnly>
                </div>
                <!-- <div class="col-2">
                    <select id="status_i_input" name="status[]" onchange="ClickChange()" style="border-color:#102958;" class="form-control" readOnly >
                        <option value="New"  <?php if ("New"==$result['status']) { echo 'selected="selected"'; } ?> >New</option>
                        <option value="Follow up" <?php if ("Follow up"==$result['status']) { echo 'selected="selected"'; } ?> >Follow up</option>
                        <option value="Renew" <?php if ("Renew"==$result['status']) { echo 'selected="selected"'; } ?> >Renew</option>
                        <option value="Wait" <?php if ("Wait"==$result['status']) { echo 'selected="selected"'; } ?> >Wait</option>
                        <option value="Not renew" <?php if ("Not renew"==$result['status']) { echo 'selected="selected"'; } ?> >Not renew</option>
                    </select>
                </div> -->

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Payment Status:</label>
                </div> 
                <div class="col-2 " >
                     <input id="payment_status" name="payment_status[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text" value="<?php echo $result['commission_status']; ?>" readOnly>
                     <!-- <select <?php //if($status!="Renew"){ echo 'disabled="true"'; } ?> id="payment_status" name="payment_status[]" style="color: #0C1830;border-color:#102958;" class="form-control"   >
                        <option value="Paid" <?php //if ("Paid"==$result['commission_status']) { echo ' selected="selected"'; } ?> >Paid</option>
                        <option value="Not Paid" <?php //if ("Not Paid"==$result['commission_status']) { //echo ' selected="selected"'; } ?> >Not Paid</option>
                    </select> -->
                </div>
                <div class="col-sm-2" >
                </div>
            </div>

            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Prod.Category:</label>
                </div>
                <div class="col">
                     <input id="product_cat" name="product_cat[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text" value="<?php echo $result['categorie']; ?>" readOnly>
                    <!-- <select id="product_cat" name="product_cat[]" style="color: #0C1830;border-color:#102958;" class="form-control" value="" readOnly >
                         <?php  foreach($results_categories as $result_cat){ ?>
                            <option value="<?php //echo $result_cat['id']; ?>"
                            <?php //if ($result_cat['id']==$result['product_category']) { echo 'selected="selected"'; } ?>
                            ><?php //echo $result_cat['categorie']; ?></option>
                        <? } ?>
                    </select> -->
                </div>

                <div class="col-sm-2  label_left" >
                    <label style="color: #102958;" for="staticEmail" >Sub Categories:</label>
                </div>
                <div class="col"  >
                     <input id="sub_cat" name="sub_cat[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text" value="<?php echo $result['subcategorie']; ?>" readOnly>
                <!-- <select id="sub_cat" name="sub_cat[]"  style="color: #0C1830;border-color:#102958;"class="form-control" value="0"  readOnly>
                    <?php  //foreach($results_sub as $result_sub){ ?>
                            <option value="<?php //echo $result_sub['id']; ?>"
                                 <?php //if ($result_sub['id']==$result['sub_categories']) { echo 'selected="selected"'; } ?>
                                ><?php //echo $result_sub['subcategorie']; ?></option>
                    <? //} ?>
                </select> -->
                </div>
            </div>

            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <div class="col-sm-2  label_left" >
                    <label style="color: #102958;" for="staticEmail" >Partner Company:</label>
                </div>
                
                <div class="col ">
                    <input id="insurance_com" name="insurance_com[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text" value="<?php echo $result['insurance_company_in']; ?>" readOnly>
                </div>

               <!--  <div class="col-sm-2  label_left" >
                </div>
                <div class="col"  >
                </div> -->
            </div>

            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Prod. Name:</label>
                </div> 
                <div class="col">
                     <input id="product_name" name="product_name[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text" value="<?php echo $result['product_name_in']; ?>" readOnly>
                    <!-- <input name="product_name[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" > -->
                    <!-- <select id="product_name" name="product_name[]"  style="color: #0C1830;border-color:#102958;"class="form-control" value="0"  >
                      <?php  //foreach($results_product as $result){ ?>
                        <option value="<?php //echo $result->id; ?>" ><?php //echo $result->product_name; ?></option>
                        <? //} ?>
                    </select> -->
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2  label_left" >
                    <label style="color: #102958;"  >Currency:</label>
                </div>
                <div class="col-2">
                    <input type="text" id="currency" name="currency[]" style="border-color:#102958; text-align: center;" class="form-control"
                     value="<?php echo $result['currency']; ?>" readOnly  />
                </div>
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Period type:</label>
                </div>
                <div class="col-2">
                     <input id="period_type" name="period_type[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text" value="<?php echo $result['period_type']; ?>" readOnly>
                    <!-- <select id="period_type" name="period_type[]"  style="color: #0C1830;border-color:#102958;"class="form-control" >
                        <option value="Day" <?php //if($period_type=="Day"){ echo "selected";} ?> >Day</option>
                        <option value="Month" <?php //if($period_type=="Month"){ echo "selected";} ?> >Month</option>
                    </select> -->
                </div>  

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Period:</label>
                </div>
                <div class="col-2">
                   <!--  <select <?php //if($period_type=="Day"){echo 'hidden="true"';} ?>  id="period_month" name="period_month[]"  style="color: #0C1830;border-color:#102958;"class="form-control" value="0"  >
                        <option value="" selected>Select Period</option>
                        <?php  //foreach($results_period as $result){ ?>
                        <option value="<?php //echo $result->id; ?>" 
                            <?php //if ($result->id==$period_id) { echo 'selected="selected"'; } ?>
                            ><?php //echo $result->period; ?></option>
                        <? //} ?>
                    </select> -->
                    <input <?php if($result['period_type']=="Day"){echo 'hidden="true"';} ?> id="period_month" name="period_month[]" minlength="1" maxlength="3" value="<?php echo $result['period_name']; ?>" style="color: #0C1830;border-color:#102958;" type="number" class="form-control input_text" readOnly>
                    <input <?php if($result['period_type']=="Month"){echo 'hidden="true"';} ?> id="period_day" name="period_day[]" minlength="1" maxlength="3" value="<?php echo $result['period_day']; ?>" style="color: #0C1830;border-color:#102958;" type="number" class="form-control input_text" readOnly>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" id="datepicker" >Start Date:</label>
                </div> 

                <div class="col-2">
                    <input id="start_date" name="start_date[]" style="color: #0C1830;border-color:#102958; text-align: center;" type="text" class="form-control" value="<?php echo $result['start_date_day']; ?>" placeholder="dd-mm-yyyy" readOnly>
                </div>
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >End Date:</label>
                </div> 
                <div class="col-2">
                    <input id="end_date" name="end_date[]" style="color: #0C1830;border-color:#102958; text-align: center;" type="text"  class="form-control" 
                    value="<?php echo $result['end_date_day']; ?>" placeholder="dd-mm-yyyy" readOnly>
                </div>
            </div>

            <?php } ?>


            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Premium Rate:</label>
                </div>
                <div class="col-2">
                    <input id="premium_rate" name="premium_rate[]" type="number" value="<?php echo number_format((float)$result['premium_rate'], 2, '.', ''); ?>" style="border-color:#102958;text-align: right;" step="0.01" min="0" class="form-control" 
                        onchange="
                        var premium = parseFloat(this.value).toFixed(2);
                        var percent = parseFloat(document.getElementById('percent_trade').value).toFixed(2);
                        if(document.getElementById('calculate').value=='Percentage'){
                        if(Number.isInteger(parseFloat(this.value).toFixed(2))){
                            this.value=this.value+'.00';
                        }else{
                            this.value=parseFloat(this.value).toFixed(2);
                        }
                            var commission = ((percent / 100) * premium);
                        }else{
                        document.getElementById('percent_trade').value = parseFloat(document.getElementById('percent_trade').value).toFixed(2);
                            var commission = percent;
                        }
                        document.getElementById('commission').value =parseFloat(commission).toFixed(2);
                        " readOnly />
                </div>
                
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Paid Date:</label>
                </div> 
                <div class="col-2">
                    <input id="paid_date" name="paid_date[]" style="color: #0C1830;border-color:#102958; text-align: center;" type="text"  class="form-control" 
                    value="<?php echo $result['paid_date_day']; ?>" placeholder="dd-mm-yyyy" readOnly>
                </div>
        </div>

        <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                     <label style="color: #102958;" for="staticEmail" >Comm. Type:</label>
                </div>
                <div class="col-4 " >
                     <!-- <input id="calculate" name="calculate[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text" value="<?php //echo $result['calculate_type']; ?>" > -->
                    <select id="calculate" name="calculate"  style="color: #0C1830;border-color:#102958;" class="form-control" 
                        onchange="
                        if(document.getElementById('percent_trade').value!=''){
                        var premium = parseFloat(document.getElementById('premium_rate').value).toFixed(2);
                        var percent = parseFloat(document.getElementById('percent_trade').value).toFixed(2);
                        if(document.getElementById('calculate').value=='Percentage'){
                            if (parseFloat(percent)>100){
                                document.getElementById('percent_trade').value=parseFloat(100.00).toFixed(2)+'%';
                            }else{
                                document.getElementById('percent_trade').value=parseFloat(percent).toFixed(2)+'%';
                            } 
                            var percent = parseFloat(document.getElementById('percent_trade').value).toFixed(2);
                            var commission = ((percent / 100) * premium);
                        }else{
                            document.getElementById('percent_trade').value = percent;
                            var commission = percent;
                        }
                        document.getElementById('commission').value =parseFloat(commission).toFixed(2);
                        }
                        "  />
                        <option value="Percentage" <?php if ("Percentage"==$result['calculate_type']) { echo ' selected="selected"'; } ?> >Percentage</option>
                        <option value="Net Value" <?php if ("Net Value"==$result['calculate_type']) { echo ' selected="selected"'; } ?> >Net Value</option>
                    </select>
                </div>

        </div>

        <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Comm. Value:</label>
                </div> 
                <div class="col-2 " >

                    <input id="percent_trade" name="percent_trade" value="<?php echo number_format((float)$result['percent_trade'], 2, '.', ''); ?>" type="text" class="form-control" style="border-color:#102958;text-align: right;" onchange="
                        var num = parseInt(parseFloat(this.value).toFixed(0));
                        if(Number.isInteger(num)){
                        var premium = parseFloat(document.getElementById('premium_rate').value).toFixed(2);
                        var percent = parseFloat(this.value).toFixed(2);
                        if(document.getElementById('calculate').value=='Percentage'){
                            if (parseFloat(this.value)>100){
                                this.value=parseFloat(100.00).toFixed(2)+'%';
                            }else{
                                this.value=parseFloat(this.value).toFixed(2)+'%';
                            } 
                            var percent = parseFloat(this.value).toFixed(2);
                            var commission = ((percent / 100) * premium);
                        }else{
                            document.getElementById('percent_trade').value = this.value;
                            var commission = percent;
                        }
                        document.getElementById('commission').value =parseFloat(commission).toFixed(2);
                        }else{
                            this.value='';
                        }
                        "  />
                </div> 
                 <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Comm. Rate:</label>
                </div> 
                <div class="col-2 " >
                    <input type="number" id="commission" name="commission[]" value="<?php echo number_format((float)$result['commission_rate'], 2, '.', ''); ?>" style="border-color:#102958;text-align: right;" class="form-control" readOnly/>
                </div>

                

        </div>

        <div class="form-group row col-md-10 col-md-offset-1" >
            <div class="col-sm-2 label_left" >
                <label style="color: #102958;" for="staticEmail" >Comm. Status:</label>
            </div> 
            <div class="col-2 " >
                <input id="commission_status" name="commission_status[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text" value="<?php echo $result['commission_status']; ?>" readOnly>
            </div>

            <div class="col-sm-2 label_left" >
                <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Comm. Receive Date:</label>
            </div>
            <div class="col-2">
                <input id="commission_paid_date" name="commission_paid_date" style="color: #0C1830;border-color:#102958; text-align: center;" type="text"  class="form-control" 
                    value="<?php echo $result['commission_paid_date_day']; ?>" placeholder="dd-mm-yyyy" required>
            </div>

            <div class="col label_left" >
                <label style="color: red; font-size: 12px;" >
                    <I>Please input paid date only then submit, system will automatically change status to paid.</I>
                </label>
            </div>

        </div>

        <div class="form-group row col-md-10 col-md-offset-1">
            <div class="col-sm-2 label_left" >
                <label style="color: #102958; " for="staticEmail" >Agent Name:</label>
            </div>

            <div class="col-4">
                <input id="commission_status" name="commission_status[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text" value="<?php echo $result['agent_name']; ?>" readOnly>

               <!--  <select id="agent_name" name="agent[]" style="color:#0C1830;border-color:#102958;" class="form-control selectpicker" data-live-search="true"  >
                    <?php  //foreach($results_agent as $result){ ?>
                        <option value="<?php //echo $result->id; ?>" <?php //if ($result->id==$agent_id) { //echo ' selected="selected"'; } ?>
                            ><?php //echo $result->title_name." ".$result->first_name." ".$result->last_name."(".$result->nick_name.")"; ?></option>
                    <? //} ?>
                </select> -->
            </div>

            <!-- <label style="color: #102958;" class="col-sm-12" >Upload Image File Size width:994 height:634</label> -->

            <div class="col-sm-2 label_left" >
                <label style="color: #102958;" for="staticEmail" accept="application/pdf" >Upload Documents:</label>
            </div>
            <div class="col">
                <div >
                    <!-- <input name="file_d[]" id="imgInp" type="file" style="width: 100%;" accept="application/pdf" > -->
                </div>
                <!-- <a href="upload/<?php echo $file_name_uniqid; ?>" download="<?php echo $file_name; ?>"><?php echo $file_name; ?></a> -->
                <?php if($result['file_name_uniqid']){ ?>
                <div class="columns download">
                    <p>
                        <a href="image.php?filename=<?php echo $result['file_name_uniqid']; ?>" class="button" download="<?php echo $result['file_name']; ?>" download><i class="fa fa-download"></i>Download <?php echo $result['file_name']; ?></a>
                    </p>
                </div>
                <?php } ?>
            </div>
             
        </div>

        <div  class="form-group row col-md-10 col-md-offset-1" >
            <div id="area_not_label" <?php if($status!="Not renew"){ echo 'hidden="true"'; } ?> class="col-sm-2 label_left" >  
                <label style="color: #102958;"  >Reason:</label>
            </div>
            <div id="area_not" <?php if($status!="Not renew"){ echo 'hidden="true"'; } ?> class="col">
                <textarea id="textarea_detail" name="textarea_detail[]" class="form-control" rows="5" placeholder="Cancellation reason" value="" ><? echo $reason; ?></textarea>
            </div>
             <div class="col-sm-2 label_left" >
                
            </div>
            <div class="col">
                <img  <?php if($file_logo_uuid==""){ ?> hidden="true" <?php } ?>
                <?php if(isset($file_logo_uuid) and $file_logo_uuid!="" ){ ?> src="image.php?filename=<?php $file_logo_uuid; ?>" <?php } ?> id='img-upload' style="height: 200px;" />
            </div> 
        </div> 

         
        </div>
    </div>                             
    </div>
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
                $('#paid_date').datepicker({
                  format: 'dd-mm-yyyy',
                  language: 'en'
                });
                $('#commission_paid_date').datepicker({
                  format: 'dd-mm-yyyy',
                  language: 'en'
                });
              });
            </script>


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
					<a href="paid_date_commission.php" class="btn btn-primary" style="background-color: #0275d8;color: #F9FAFA;" >
						<span class="text">Cancel</span>
					</a>
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

    <?php include('includes/footer.php'); ?>
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