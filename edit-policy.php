
<!-- ========== Address Search ========== -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<?php
	include('includes/config.php');
	include('includes/fx_policy_db.php');
	session_start();
	error_reporting(0);
	include('includes/config_path.php');

	if(strlen($_SESSION['alogin'])==""){  
	 	$dbh = null;
		header("Location: index.php"); 
	}else{
		if(isset($_POST['back'])){
			$dbh = null;
			header("Location: manage-user.php"); 
		}

	if(isset($_POST['submit'])){ 

		$id_customer_input  = $_POST['id_customer_input'];
		$name_c_input       = $_POST['name_c_input'];
		// $name_c_input      = "";
		$customer_c_input  = $_POST['customer_c_input'];

		$title_c_input      = $_POST['title_c_input'];
		$first_c_input      = $_POST['first_c_input'];
		$last_c_input       = $_POST['last_c_input'];  
		$nick_c_input       = $_POST['nick_c_input'];   

		$company_n_c_input  = $_POST['company_c_input'];
		$tel_c_input        = $_POST['tel_c_input'];
		$mobile_c_input     = $_POST['mobile_c_input'];
		$email_c_input      = $_POST['email_c_input'];

		$address_number_input= $_POST['address_number_input'];
		$building_input     = $_POST['building_input'];
		$soi_input          = $_POST['soi_input'];
		$road_input         = $_POST['road_input'];

		$sub_district_id    = $_POST['sub_district_id'];
		$district_id        = $_POST['district_id'];
		$province_id        = $_POST['province_id'];
		$postcode_id        = $_POST['postcode_id'];

		$type_c_input       = $_POST['type_c_input'];
		$personal_c_input   = $_POST['personal_c_input'];
		$level_c_input      = $_POST['level_c_input'];   

		$status_c_input     = $_POST['status_c_input'];
		$payment_status     = $_POST['payment_status'];



		// echo "_SESSION id :".$_SESSION['id'];
		
if(count($_POST["policy"])>0){
			
	$array_delete=array();
	$sql_rela = "SELECT * from rela_customer_to_insurance WHERE id_default_insurance = ".$_POST['id_insurance_info'][0];
	$query_rela = $dbh->prepare($sql_rela);
	$query_rela->execute();
	$results_rela=$query_rela->fetchAll(PDO::FETCH_OBJ);
	foreach($results_rela as $result_add){
		
		if (!in_array($result_add->id_insurance_info,$_POST['id_insurance_info'])) {
			array_push($array_delete,$result_add->id_insurance_info);
		}
	}

	foreach($array_delete as $value) {
		$sql="delete from rela_customer_to_insurance where id_insurance_info=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':id',$value,PDO::PARAM_STR);
		$query->execute();

		$sql="delete from insurance_info where id=:id";
		$query = $dbh->prepare($sql);
		// echo '<script>alert("value: '.$value.'")</script>'; 
		$query->bindParam(':id',$value,PDO::PARAM_STR);
		$query->execute();
	}

	$lastInsertId_customer="";
	$lastInsertId_contact_default=0;

	// if($id_customer_input==""){ // insert sql customer
	// 			$sql="INSERT INTO customer (customer_name,customer_id,title_name,first_name,last_name".
	// 		   ",nick_name,company_name,tel,mobile,email".
	// 		   ",address_number,building_name,soi,road,sub_district".
	// 		   ",district,province,post_code,status,cdate".
	// 		   ",udate,create_by".
	// 		   ",customer_type,tax_id,customer_level)";
	// 			// ,[modify_by],[id_rela_contact],[id_rela_insurance_info]

	// $sql=$sql." VALUES(:customer_name_p,:customer_id_p,:title_name_p,:first_name_p,:last_name_p".
	// 		   ",:nick_name_p,:company_name_p,:tel_p,:mobile_p,:email_p".
	// 		   ",:address_number_p,:building_name_p,:soi_p,:road_p,:sub_district_p".
	// 		   ",:district_p,:province_p,:post_code_p,:status_p,GETDATE()".
	// 		   ",GETDATE(),:create_by_p".
	// 		   ",:customer_type_p,:tax_id_p,:customer_level_p) ";

	// 	$query = $dbh->prepare($sql); 
	// 	$query->bindParam(':customer_name_p',$name_c_input,PDO::PARAM_STR);
	// 	$query->bindParam(':customer_id_p',$customer_c_input,PDO::PARAM_STR);

	// 	$query->bindParam(':title_name_p',$title_c_input,PDO::PARAM_STR);
	// 	$query->bindParam(':first_name_p',$first_c_input,PDO::PARAM_STR);
	// 	$query->bindParam(':last_name_p',$last_c_input,PDO::PARAM_STR);
	// 	$query->bindParam(':nick_name_p',$nick_c_input,PDO::PARAM_STR);

	// 	$query->bindParam(':company_name_p',$company_n_c_input,PDO::PARAM_STR);
	// 	$query->bindParam(':tel_p',$tel_c_input,PDO::PARAM_STR);
	// 	$query->bindParam(':mobile_p',$mobile_c_input,PDO::PARAM_STR);
	// 	$query->bindParam(':email_p',$email_c_input,PDO::PARAM_STR);

	// 	$query->bindParam(':address_number_p',$address_number_input,PDO::PARAM_STR);
	// 	$query->bindParam(':building_name_p',$building_input,PDO::PARAM_STR);
	// 	$query->bindParam(':soi_p',$soi_input,PDO::PARAM_STR);
	// 	$query->bindParam(':road_p',$road_input,PDO::PARAM_STR);

	// 	$query->bindParam(':sub_district_p',$sub_district_id,PDO::PARAM_STR);
	// 	$query->bindParam(':district_p',$district_id,PDO::PARAM_STR);
	// 	$query->bindParam(':province_p',$province_id,PDO::PARAM_STR);
	// 	$query->bindParam(':post_code_p',$postcode_id,PDO::PARAM_STR);
	// 	if($status_c_input==""){
	// 		$status_c_input="0";
	// 	}else{
	// 		$status_c_input="1";
	// 	}
	// 	$query->bindParam(':status_p',$status_c_input,PDO::PARAM_STR);
	// 	$query->bindParam(':create_by_p',$_SESSION['id'],PDO::PARAM_STR);

	// 	// $query->bindParam(':modify_by_p','1',PDO::PARAM_STR);

	// 	// $query->bindParam(':id_rela_contact_p',"",PDO::PARAM_STR);
	// 	// $query->bindParam(':id_rela_insurance_info_p',"",PDO::PARAM_STR);

	// 	$query->bindParam(':customer_type_p',$type_c_input,PDO::PARAM_STR);
	// 	$query->bindParam(':tax_id_p',$personal_c_input,PDO::PARAM_STR);
	// 	$query->bindParam(':customer_level_p',$level_c_input,PDO::PARAM_STR);

	// 	$query->execute();
	// 	// print_r($query->errorInfo());


	// 	$lastInsertId_customer = $dbh->lastInsertId();
	// }else{ //update contact
	// 	$lastInsertId_customer = $id_customer_input;
	// }///////////////////////// end contact

	$lastInsertId_customer = $id_customer_input;

	if($lastInsertId_customer){ //// insert insurance

			$start_policy="true";
			$start_id_insurance="true";
			$start_lastInsertId_insurance="";

		for ($i=0;$i<count($_POST['policy']);$i++) {

			// echo '<script>alert("id_insurance_info: '.$_POST['id_insurance_info'][$i].'")</script>'; 
			if($_POST['id_insurance_info'][$i]!=""){

				$new_file_name="";
				if($_FILES['file_d']['name'][$i]!=""){
					try {
						$file = $_FILES['file_d']['name'][$i];
						$file_loc = $_FILES['file_d']['tmp_name'][$i];
						$folder=$sourceFilePath;
						$ext = pathinfo($file, PATHINFO_EXTENSION);
						$new_file_name = uniqid().".".$ext;
						$path_file = $folder."/".$new_file_name;
						$final_file=str_replace(' ','-',$new_file_name);
						move_uploaded_file($file_loc,$folder.$final_file);    
						$sql_upload_file =" ,file_name=:file_name_p,file_name_uniqid=:file_name_uniqid_p ";
					}catch(Exception $e) {
						// echo '<script>alert("Error : '.$e.'")</script>'; 
					}
				}	
				// echo '<script>alert("insert_policy_renew: '.$_POST['status'][$i].'")</script>'; 
				// echo '<script>alert("policy: '.$_POST['policy'][$i].':'.$_POST['policy_old'][$i].'")</script>'; 

				// if($_POST['status'][$i] == "Renew" && ($_POST['policy'][$i] != $_POST['policy_old'][$i])){

				// ($_POST['status'][$i] == "Renew" && ($_POST['status'][$i] != $_POST['status_old'][$i])) ||

			
				if(
					($_POST['status'][$i] == "Renew" && ($_POST['policy'][$i] != $_POST['policy_old'][$i]))
				){
					insert_policy_renew($dbh,$_POST,$_FILES,$new_file_name,$lastInsertId_customer,$i,$_FILES['file_d']);
				}else if(
					($_POST['status'][$i] == "Renew" && ($_POST['start_date'][$i] != $_POST['start_date_old'] && $_POST['end_date'][$i] != $_POST['end_date_old']) )
				){
					insert_policy_renew($dbh,$_POST,$_FILES,$new_file_name,$lastInsertId_customer,$i,$_FILES['file_d']);

				}else{

					update_policy($dbh,$_POST,$_FILES,$new_file_name,$lastInsertId_customer,$i,$_FILES['file_d']);

				}
				insert_history_policy($dbh,$_POST,$lastInsertId_customer,"update");

				// update_rela_customer_to_insurance($dbh,$_POST,$lastInsertId_customer,$i);


				$sql_policy_primary ="";

			}else{////// else null id Insurance
			  
	///////////////-------------------------------------------------------------------

		// 		$sql = "INSERT INTO insurance_info".
		// 		"(insurance_company,policy_no,status,product_category,sub_categories".
		// 		",insurance_company_id,product_id,period,period_type,period_day,start_date,end_date".
		// 		",premium_rate".
		// 		",convertion_value".
		// 		",percent_trade,commission_rate,agent_id,file_name".
		// 		",file_name_uniqid,default_insurance,calculate_type,payment_status,paid_date,commission_status,cdate,create_by,reason,remark)";
		// 	$sql=$sql." VALUES (:insurance_company_p,:policy_no_p,:status_p,:product_category_p,:sub_categories_p".
		// 			",:insurance_company_id_p,:product_id_p,:period_p,:period_type_p,:period_day_p,:start_date_p,:end_date_p".
		// 			",:premium_rate_p".
		// 			",:convertion_value_p".
		// 			",:percent_trade_p,:commission_rate_p,:agent_id_p,:file_name_p".
		// 			",:file_name_uniqid_p,:default_insurance_p,:calculate_type_p,:payment_status_p,:paid_date_p,:commission_status_p,GETDATE(),:create_by_p,:reason_p,:remark_p)";

		// 		$query = $dbh->prepare($sql); 

		// 		$query->bindParam(':insurance_company_p',$_POST['insurance_company'][$i],PDO::PARAM_STR);
		// 		$query->bindParam(':policy_no_p',$_POST['policy'][$i],PDO::PARAM_STR);
		// 		$query->bindParam(':status_p',$_POST['status'][$i],PDO::PARAM_STR);
		// 		$query->bindParam(':product_category_p',$_POST['product_cat'][$i],PDO::PARAM_STR);
		// 		$query->bindParam(':sub_categories_p',$_POST['sub_cat'][$i],PDO::PARAM_STR);

		// 		$query->bindParam(':insurance_company_id_p',$_POST['insurance_com'][$i],PDO::PARAM_STR);
		// 		$query->bindParam(':product_id_p',$_POST['product_name'][$i],PDO::PARAM_STR);

		// 		$null_value;
		// 		if($_POST['period_type'][$i]=='Month'){
		// 			$query->bindParam(':period_type_p',$_POST['period_type'][$i],PDO::PARAM_STR);
		// 			$query->bindParam(':period_p',$_POST['period_month'][$i],PDO::PARAM_STR);
		// 			$query->bindParam(':period_day_p',$null_value,PDO::PARAM_STR);
		// 		}else{
		// 			$query->bindParam(':period_type_p',$_POST['period_type'][$i],PDO::PARAM_STR);
		// 			$query->bindParam(':period_p',$null_value,PDO::PARAM_STR);
		// 			$query->bindParam(':period_day_p',$_POST['period_day'][$i],PDO::PARAM_STR);
		// 		}
		// 		// $query->bindParam(':period_p',$_POST['period'][$i],PDO::PARAM_STR);

		// 		$query->bindParam(':start_date_p',date("Y-m-d", strtotime($_POST['start_date'][$i])),PDO::PARAM_STR);
		// 		$query->bindParam(':end_date_p',date("Y-m-d", strtotime($_POST['end_date'][$i])),PDO::PARAM_STR);

		// 		$per = substr($_POST['percent_trade'][$i],0,-1);

		// 		$query->bindParam(':premium_rate_p',$_POST['convertion_value'][$i],PDO::PARAM_STR);
		// 		$query->bindParam(':convertion_value_p',$_POST['premium_rate'][$i],PDO::PARAM_STR);

		// 		$query->bindParam(':percent_trade_p',$per,PDO::PARAM_STR);
		// 		$query->bindParam(':commission_rate_p',$_POST['commission'][$i],PDO::PARAM_STR);
		// 		$query->bindParam(':agent_id_p',$_POST['agent'][$i],PDO::PARAM_STR);
		// 		$query->bindParam(':payment_status_p',$_POST['payment_status'][$i],PDO::PARAM_STR);

		// 		$query->bindParam(':calculate_type_p',$_POST['calculate'][$i],PDO::PARAM_STR);
				
		// 		$query->bindParam(':paid_date_p',date("Y-m-d", strtotime($_POST['paid_date'][$i])),PDO::PARAM_STR);

		// 		$commission_status = "Not Paid";
		// 		$query->bindParam(':commission_status_p',$commission_status,PDO::PARAM_STR);

		// 		$query->bindParam(':reason_p',$_POST['textarea_detail'][$i],PDO::PARAM_STR);
		// 		$query->bindParam(':create_by_p',$_SESSION['id'],PDO::PARAM_STR);

		// 		$query->bindParam(':remark_p',$_POST['remark'][$i],PDO::PARAM_STR);
				 
		// 		if($start_policy=="true"){
		// 			$value=1;
		// 			$query->bindParam(':default_insurance_p',$value,PDO::PARAM_STR);
		// 			$start_policy="false";
		// 		}else{
		// 			$value=0;
		// 			$query->bindParam(':default_insurance_p',$value,PDO::PARAM_STR);
		// 		}
		// //////////// upload ////////////
		// $new_file_name="";
		// // echo '<script>alert("post file_d : '.$_FILES['file_d']['name'][$i].'")</script>'; 
		// if($_FILES['file_d']['name'][$i]!=""){
		// 	try {
		// 		$file = $_FILES['file_d']['name'][$i];
		// 		$file_loc = $_FILES['file_d']['tmp_name'][$i];
		// 		// $image=$_POST['file_d'];
		// 		$folder=$sourceFilePath;
		// 		$ext = pathinfo($file, PATHINFO_EXTENSION);
		// 		$new_file_name = uniqid().".".$ext;
		// 		$path_file = $folder."/".$new_file_name;
		// 		$final_file=str_replace(' ','-',$new_file_name);
		// 		move_uploaded_file($file_loc,$folder.$final_file);    
		// 	}catch(Exception $e) {
		// 		// echo '<script>alert("Error : '.$e.'")</script>'; 
		// 	}
		// }
		// ////////////////////////////////////

		// 		$query->bindParam(':file_name_p',$_FILES['file_d']['name'][$i],PDO::PARAM_STR);
		// 		$query->bindParam(':file_name_uniqid_p',$new_file_name,PDO::PARAM_STR);
		// 		////////////
		// 		$query->execute();

		// 		$lastInsertId_insurance = $dbh->lastInsertId();
		// 		// if($start_id_insurance=="true"){
		// 		//     $start_lastInsertId_insurance = $dbh->lastInsertId();
		// 		//     $start_id_insurance="false";
		// 		// }

		// 		// $lastInsertId_customer
		// 		$sql = "INSERT INTO rela_customer_to_insurance".
		// 			"(id_customer,id_insurance_info,id_default_insurance)";
		// 		$sql=$sql." VALUES (:id_customer_p,:id_insurance_info_p,:id_default_insurance,:id_default_contact)";
		// 		$query = $dbh->prepare($sql); 
		// 		$query->bindParam(':id_customer_p',$lastInsertId_customer,PDO::PARAM_STR);
		// 		$query->bindParam(':id_insurance_info_p',$lastInsertId_insurance,PDO::PARAM_STR);
		// 		$query->bindParam(':id_default_insurance',$_POST['id_insurance_info'][0],PDO::PARAM_STR);
		// 		$query->bindParam(':id_default_contact',$_POST['id_co'][0],PDO::PARAM_STR);
		// 		$query->execute();
				// print_r($query->errorInfo());
	///////////////-------------------------------------------------------------------

			}
		}//loop for Insurance information
		

	}

}
			// echo '<script>alert("Successfully edited information.")</script>';
			$dbh = null;
			echo "<script>window.location.href ='entry-policy.php'</script>";
		}else{

		}

	$start_date= date('d-m-Y');
	$stop_date = date('d-m-Y');
	$paid_date = date('d-m-Y');


	if($_GET['id']){
		$results = get_rela_insurance($dbh,$_GET['id']);
		
		if(count($results)==0){
			$dbh = null;
			header("Location: entry-policy.php"); 
		}
		
		foreach($results as $value){
			$id_policy = $value->id_default_insurance;
			$id_default_contact = $value->id_default_contact;
		}
		if($id_policy==""){
			// header("Location: entry-policy.php");
		}

		$results_insurance = get_insurance($dbh,$id_policy);
		$start = "true";
	}

	foreach($results_insurance as $result){
		$id_insurance = $result->id;
		$product_cat = $result->product_category;
		$sub_cat = $result->sub_categories;
		$insurance_company_id = $result->insurance_company_id;
		$currency_id = $result->id_currency_list;
		$currency_name = $result->currency; 

		$currency_value = $result->currency_value;
		$currency_value_convert = $result->currency_value_convert;

		$start_date = $result->start_date_f;
		$stop_date = $result->end_date_f;
		$paid_date = $result->paid_date_f;
		$agent_id = $result->agent_id;

		$policy_no = $result->policy_no;
		$policy_type = $result->policy_type;
		$policy_primary = $result->policy_primary;

		$status = $result->status;
		$product_id = $result->product_id;
		$period_id = $result->period;

		// $premium_rate   = $result->premium_rate;
		// $convertion_value 	= $result->convertion_value;

		$premium_rate   = $result->convertion_value;
		$convertion_value 	= $result->premium_rate;

		$calculate_type = $result->calculate_type;
		$percent_trade  = $result->percent_trade;
		$commission_rate= $result->commission_rate;
		$payment_status = $result->payment_status;
		$agent_id       = $result->agent_id;
		$file_name      = $result->file_name;
		$file_name_uniqid= $result->file_name_uniqid;
		$id_customer    = $result->id_customer;

		$customer_type = $result->customer_type;

		$period_type    = $result->period_type;
		$period_day    = $result->period_day;

		$commission_status = $result->commission_status;

		$reason    = $result->reason;
		$remark      = $result->remark;
	// echo '<script>alert("id_customer: '.$policy_no.'")</script>'; 
	}

	
	$results_company = get_company($dbh);
	$results_product = get_product($dbh,$insurance_company_id);
	$results_period  = get_period($dbh);
	$results_agent	 = get_agent_old($dbh,$insurance_company_id);
	$results_c_level = get_customer_level($dbh);

	$results_categories = get_categories($dbh);
	$results_sub 	 = get_sub($dbh,$product_cat);

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

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/css/bootstrap-datetimepicker.min.css">

</head>

<body id="page-top" >

    <!-- Page Wrapper -->
    <div id="wrapper" >
        <?php include('includes/leftbar2.php');?>   
        <?php include('includes/topbar2.php');?>  
        <div class="container-fluid mb-4" >
			<div class="row breadcrumb-div" style="background-color:#ffffff">
				<div class="col-md-12" >
					<ul class="breadcrumb">
						<li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
						<li class="active"  ><a href="entry-policy.php">Entry Policy</a></li>
						<li class="active">Insurance information</li>
					</ul>
				</div>
			</div>
		</div>

<script>
	function validateForm() {
		if (policy_check=="false") {
	        alert("This policy already exist.");
	        return false;
	    }else{
	    	document.getElementById("loading-overlay").style.display = "flex";
	        return true;
	    }
	}
</script>

<!-- <form method="post" onSubmit="return valid();" action = "validate.php" > -->
<form method="post" action = "edit-policy.php" enctype="multipart/form-data" onsubmit="
return validateForm();
$(this).find('select').prop('disabled', false);
$(this).find('input').prop('disabled', false);
" >
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

                        <!-- <div class="col-sm-4 text-right ">
                            <br>
                            <a  name="add" id="add" class="btn" style="background-color: #0275d8;color: #F9FAFA;"><i
                                class="fas  fa-sm text-white-50"></i>+ Add More Insurance</a>
                        </div>&nbsp;&nbsp; -->

                        <!-- <button type="button" name="add" id="add">Add Test</button> -->

                        <!-- <div id="dynamic_field"></div> -->
                    </div>
                </div>

<script>
var policy_check = "true";
$(function(){
    var policy_object = $('#policy');
    var id = document.getElementById("id_insurance_info").value;
    policy_object.on('change', function(){
        var policy_value = $(this).val();
            $.get('get_policy.php?policy=' + policy_value.trim()+"&id="+id, function(data){
                var result = JSON.parse(data);
                policy_check = "true";
                $.each(result, function(index,item){
                    if(item.id!=""){
                        alert("This policy already exist.");
                        policy_check="false";
                    }
                });
            });
    });
});
</script>                   

        <div class="panel-body">

            <div class="form-group row col-md-10 col-md-offset-1" >
                <!-- &nbsp; <p class="pull-right"> -->
                <input hidden="true" id="id_insurance_info" name="id_insurance_info[]" value="<?php echo $id_insurance; ?>" style="color: #000;border-color:#102958;" type="text" class="form-control" id="success" >
                </input>
                <div class="col-sm-2  label_left"  >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Policy No:</label>
                </div>
                <!-- col-xs-auto -->
                <div class="col ">
                	<input hidden="true" name="status_old[]" value="<?php echo $status; ?>" >
                	<input hidden="true" name="policy_old[]" value="<?php echo $policy_no; ?>" >
                	<input hidden="true" name="policy_type[]" value="<?php echo $policy_type; ?>" >
                	<input hidden="true" name="policy_primary[]" value="<?php echo $policy_primary; ?>" >

                    <input id="policy" name="policy[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control input_text" value="<?php echo $policy_no; ?>" required>
                </div>
                <div class="col-sm-2  label_left" >
                </div>
                <div class="col">
                </div>
            </div>

            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <div class="col-sm-2  label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Partner Name:</label>
                </div>
                <div class="col"  >

                <input hidden="true" type="text" id="currency_id" name="currency_id[]" style="border-color:#102958; color: #000;" class="form-control" value="<?php echo $insurance_company_id; ?>"  required/>

                <select id="insurance_com" name="insurance_com[]"  style="color: #000;border-color:#102958;"class="form-control"  >
                	<option value="" selected>Select Partner Name</option>
                     <?php  foreach($results_company as $result){ ?>
                        <option value="<?php echo $result->id_partner; ?>" 
                            <?php if ($result->id_partner==$insurance_company_id) { echo 'selected="selected"'; } ?>
                            ><?php echo $result->insurance_company; ?></option>
                    <? } ?>
                </select>
                </div>
            </div>


            <!-- <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Prod.Category:</label>
                </div>
                <div class="col">
                    <select id="product_cat" name="product_cat[]" style="color: #0C1830;border-color:#102958;" class="form-control" value="" required >
                         <?php // foreach($results_categories as $result){ ?>
                            <option value="<?php echo $result->id; ?>"
                            <?php //if ($result->id==$product_cat) { echo 'selected="selected"'; } ?>
                            ><?php //echo $result->categorie; ?></option>
                        <? //} ?>
                    </select>
                </div>

                <div class="col-sm-2  label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Sub Categories:</label>
                </div>
                <div class="col"  >
                <select id="sub_cat" name="sub_cat[]"  style="color: #0C1830;border-color:#102958;"class="form-control" value="0"  required>
                    <?php  //foreach($results_sub as $result){ ?>
                            <option value="<?php //echo $result->id; ?>"
                                 <?php //if ($result->id==$sub_cat) { echo 'selected="selected"'; } ?>
                                ><?php //echo $result->subcategorie; ?></option>
                    <? //} ?>
                </select>
                </div>
            </div> -->

            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Product Name:</label>
                </div> 
                <div class="col">
                    <!-- <input name="product_name[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" > -->
                    <select id="product_name" name="product_name[]"  style="color: #000;border-color:#102958;"class="form-control" value="0"  required>
                    	<option value="" selected>Select Product Name</option>
                      <?php  foreach($results_product as $result){ ?>
                        <option value="<?php echo $result->id; ?>" 
                        	<?php if ($result->id==$product_id) { echo 'selected="selected"'; } ?>
                        	><?php echo $result->product_name; ?></option>
                        <? } ?>
                    </select>
                </div>

                <div class="col-sm-1">
                	<button style="background-color: #0275d8;color: #F9FAFA;" type="button" class="btn " data-toggle="modal"  onclick="checkProductName();" >
                        <svg enable-background="new 0 0 512 512" height="20px" id="Layer_1" version="1.1" viewBox="0 0 512 512" width="20px" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M256,512C114.625,512,0,397.391,0,256C0,114.609,114.625,0,256,0c141.391,0,256,114.609,256,256  C512,397.391,397.391,512,256,512z M256,64C149.969,64,64,149.969,64,256s85.969,192,192,192c106.047,0,192-85.969,192-192  S362.047,64,256,64z M288,384h-64v-96h-96v-64h96v-96h64v96h96v64h-96V384z" fill="#ffffff" /></svg>
                        &nbsp;
                    </button>
                </div>
            </div>

            <script>
				function checkProductName() {
				    var productName = document.getElementById("insurance_com").value;
				    if (productName === "") {
				        alert("Please select a partner name");
				        return false;
				    }else{
				    	$('#ModalProduct').modal('show');
				    }
				    // $('#ModalProduct').modal('show');
				}
			</script>

			<script>
				$(function(){
					var percen_value = '';
					var net_value = '';

					var agent_name = $('#agent_name');
					agent_name.on('change', function(){

					    var id_agent = $(this).val();
					    // alert('id_agent' + id_agent);
					    var id_partner = document.getElementById("insurance_com").value;
					    percen_value = '';
						net_value = '';
						document.getElementById("calculate").value = "";
						document.getElementById("percent_trade").value = "";
						document.getElementById("commission").value = "";

						document.getElementById("calculate_popup").value = "";
						document.getElementById("percent_trade_popup").value = "";
						document.getElementById("commission_popup").value = "";

						// alert('get_under.php?id_agent=' + id_agent + '&id_partner=' + id_partner);
						$.get('get_under.php?id_agent=' + id_agent + '&id_partner=' + id_partner, function(data){
						    var result = JSON.parse(data);
						    $.each(result, function(index, item){
						    	percen_value = item.percen_value;
						    	net_value = item.net_value;
						    	if(item.type_default=="Percentage"){
						    	  document.getElementById("calculate").value = item.type_default;
						          document.getElementById("percent_trade").value = parseFloat(item.percen_value).toFixed(2)+'%';
						        	
						          document.getElementById("calculate_popup").value = item.type_default;
						          document.getElementById("percent_trade_popup").value = parseFloat(item.percen_value).toFixed(2)+'%';
						          chang_commission_type();
							    }else{
							    	document.getElementById("calculate").value = item.type_default;
						        	document.getElementById("percent_trade").value = parseFloat(item.net_value).toFixed(2);

						        	document.getElementById("calculate_popup").value = item.type_default;
						        	document.getElementById("percent_trade_popup").value = parseFloat(item.net_value).toFixed(2);
						        	chang_commission_type();
							    } 
						    });
						    
						});

					});

					var calculate = $('#calculate');
					calculate.on('change', function(){
						if($(this).val()=="Percentage"){
							document.getElementById("calculate").value = 'Percentage';
							document.getElementById("calculate_popup").value = 'Percentage';
							if(percen_value!=''){
						    	document.getElementById("percent_trade").value = parseFloat(percen_value).toFixed(2)+'%';
						    	document.getElementById("percent_trade_popup").value = parseFloat(percen_value).toFixed(2)+'%';
						    }
						    chang_commission_type();
						}else{
							document.getElementById("calculate").value = 'Net Value';
							document.getElementById("calculate_popup").value = 'Net Value';
							if(net_value!=''){
						    	document.getElementById("percent_trade").value = parseFloat(net_value).toFixed(2);
						    	document.getElementById("percent_trade_popup").value = parseFloat(net_value).toFixed(2);
						    }
						    chang_commission_type();
						}
					}); 

					function chang_commission_type() {
						var commission = '';
	                    if(document.getElementById('percent_trade').value!=''){
	                    	var premiumInput = document.getElementById('convertion_value').value.replace(/,/g,'');
	                        var premium = parseFloat(premiumInput).toFixed(2);

	                        var percent = parseFloat(document.getElementById('percent_trade').value).toFixed(2);

	                        if(document.getElementById('calculate').value=='Percentage'){

	                        	if(document.getElementById('premium_rate').value!=''){
		                            if (parseFloat(percent)>100){
		                                document.getElementById('percent_trade').value=parseFloat(100.00).toFixed(2)+'%';
		                            }else{
		                                document.getElementById('percent_trade').value=parseFloat(percent).toFixed(2)+'%';
		                            } 
		                            var percent = parseFloat(document.getElementById('percent_trade').value).toFixed(2);
		                            commission = ((percent / 100) * premium);
	                        	}

	                        }else if(document.getElementById('calculate').value=='Net Value'){
	                            document.getElementById('percent_trade').value = percent;
	                            // var commission = premium-percent;
	                            commission = percent;
	                        }
	                        if(commission != ''){
		                        var commissionNumber  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(commission);
		                        document.getElementById('commission').value =commissionNumber;
	                    	}else{
	                    		document.getElementById('commission').value ='';
	                    	}

	                    }
					}

					var calculate = $('#calculate_popup');
					calculate.on('change', function(){
						if($(this).val()=="Percentage"){
							document.getElementById("calculate").value = 'Percentage';
						    document.getElementById("calculate_popup").value = 'Percentage';

						    if(percen_value!=''){
						    	document.getElementById("percent_trade").value = parseFloat(percen_value).toFixed(2)+'%';
						    	document.getElementById("percent_trade_popup").value = parseFloat(percen_value).toFixed(2)+'%';
							}
						    chang_commission_type_popup();
						}else{
							document.getElementById("calculate").value = 'Net Value';
						    document.getElementById("calculate_popup").value = 'Net Value';
						    
						    if(net_value!=''){
						    	document.getElementById("percent_trade").value = parseFloat(net_value).toFixed(2);
						    	document.getElementById("percent_trade_popup").value = parseFloat(net_value).toFixed(2);
							}
						    chang_commission_type_popup();
						}

					}); 

					function chang_commission_type_popup() {
						if(document.getElementById('percent_trade_popup').value!=''){
                        var premiumInput = document.getElementById('convertion_value_popup').value.replace(/,/g,'');
                        var premium = parseFloat(premiumInput).toFixed(2);

                        var percent = parseFloat(document.getElementById('percent_trade_popup').value).toFixed(2);

                        if(document.getElementById('calculate_popup').value=='Percentage'){
                            if (parseFloat(percent)>100){
                                document.getElementById('percent_trade_popup').value=parseFloat(100.00).toFixed(2)+'%';
                            }else{
                                document.getElementById('percent_trade_popup').value=parseFloat(percent).toFixed(2)+'%';
                            } 
                            var percent = parseFloat(document.getElementById('percent_trade_popup').value).toFixed(2);
                            var commission = ((percent / 100) * premium);

                        }else if(document.getElementById('calculate_popup').value=='Net Value'){
                            document.getElementById('percent_trade_popup').value = percent;
                            var commission = percent;
                        }
                        if(commission!='NaN'){
                            var commissionNumber  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(commission);
                            document.getElementById('commission_popup').value =commissionNumber;
                        }
                    	}
					}

				}); 
			</script>
            
            <div hidden="true" class="form-group row mb-20 col-md-10 col-md-offset-1">
            	<div class="col-6">
            		<input hidden="true" id="product_cat" name="product_cat[]" style="color: #000;border-color:#102958;" type="text" class="form-control input_text" value="<?php echo $product_cat; ?>" >
            	</div>
            	<div class="col-6">
            		<input hidden="true" id="sub_cat" name="sub_cat[]" style="color: #000;border-color:#102958;" type="text" class="form-control input_text" value="<?php echo $sub_cat; ?>" >
            	</div>
            </div> 

            <div class="form-group row col-md-10 col-md-offset-1">
	            <div class="col-sm-2 label_left" >
	                <label style="color: #102958; " for="staticEmail" >Agent Name:</label>
	            </div>

	            <div class="col-sm-4">
	                <select id="agent_name" name="agent[]" style="color:#000;border-color:#102958;" class="form-control selectpicker" data-live-search="true" >
	                    <?php  foreach($results_agent as $result){ ?>
	                        <option value="<?php echo $result->id; ?>" <?php if ($result->id==$agent_id) { echo ' selected="selected"'; } ?>
	                            ><?php echo $result->title_name." ".$result->first_name." ".$result->last_name;
	                            	// if (!is_null(trim($result->nick_name)) && trim($result->nick_name) != null && trim($result->nick_name) != "") {
	                            	// 	echo " (".$result->nick_name.")";
	                            	// }
	                             ?>
	                        </option>
	                    <? } ?>
	                </select>
	            </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;"  ><small><font color="red">*</font></small>Policy Status:</label>
                </div>
                <div class="col-sm-2">
                    <select id="status_i_input" name="status[]" onchange="ClickChange()" style="border-color:#102958; color: #000;" class="form-control" required >
                        <option value="New"  <?php if ("New"==$status) { echo 'selected="selected"'; } ?> >New</option>
                        <option value="Follow up" <?php if ("Follow up"==$status) { echo 'selected="selected"'; } ?> >Follow up</option>
                        <option value="Renew" <?php if ("Renew"==$status) { echo 'selected="selected"'; } ?> >Renew</option>
                        <option value="Wait" <?php if ("Wait"==$status) { echo 'selected="selected"'; } ?> >Wait</option>
                        <option value="Not renew" <?php if ("Not renew"==$status) { echo 'selected="selected"'; } ?> >Not renew</option>
                    </select>
                </div>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Payment Status:</label>
                </div> 
                <div class="col-sm-2" >
                     <select <?php if($status!="Renew"){ echo 'disabled="true"'; } ?> id="payment_status" name="payment_status[]" style="color: #000;border-color:#102958;" class="form-control"   >
                        <option value="Paid" <?php if ("Paid"==$payment_status) { echo ' selected="selected"'; } ?> >Paid</option>
                        <option value="Not Paid" <?php if ("Not Paid"==$payment_status) { echo ' selected="selected"'; } ?> >Not Paid</option>
                    </select>
                </div>

                <input type="hidden" name="payment_status[]" id="hidden_payment_status" value="<?php echo $payment_status; ?>">
				<script>
				    document.getElementById('status_i_input').addEventListener('change', function(event) {
				        // document.getElementById('hidden_payment_status').value = this.value;
				        document.getElementById('hidden_payment_status').value = document.getElementById('payment_status').value;
				    });
				    document.getElementById('payment_status').addEventListener('change', function(event) {
				    	document.getElementById('hidden_payment_status').value = document.getElementById('payment_status').value;
				    });	
				</script>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2  label_left" >
                    <label style="color: #102958;"  ><small><font color="red">*</font></small>Currency:</label>
                </div>
                <div class="col-sm-2">
                    <input type="text" id="currency" name="currency[]" style="border-color:#102958; text-align: center; color: #000;" class="form-control"
                     value="<?php echo $currency_name; ?>" readOnly  required/>
                </div>
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Period type:</label>
                </div>
                <div class="col-sm-2">
                    <select id="period_type" name="period_type[]"  style="color: #000;border-color:#102958;"class="form-control" required>
                        <!-- <option value="" selected>Select Period type</option> -->
                        <option value="Day" <?php if($period_type=="Day"){ echo "selected";} ?> >Day</option>
                        <option value="Month" <?php if($period_type=="Month"){ echo "selected";} ?> >Month</option>
                    </select>
                </div>  

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Period:</label>
                </div>
                <div class="col-sm-2">
                    <select <?php if($period_type=="Day"){echo 'hidden="true"';} ?>  id="period_month" name="period_month[]"  style="color: #000;border-color:#102958;"class="form-control" value="0"  >
                        <option value="" selected>Select Period</option>
                        <?php  foreach($results_period as $result){ ?>
                        <option value="<?php echo $result->id; ?>" 
                            <?php if ($result->id==$period_id) { echo 'selected="selected"'; } ?>
                            ><?php echo $result->period; ?></option>
                        <? } ?>
                    </select>
                    <input <?php if($period_type=="Month"){echo 'hidden="true"';} ?> id="period_day" name="period_day[]" minlength="1" maxlength="3" value="<?php echo $period_day; ?>" style="color: #000;border-color:#102958;" type="number" class="form-control input_text" >
                </div>
            </div>

<script>

		var currency_id = document.getElementById("insurance_com").value;
		// alert('currency_id:'+currency_id);
		$.get('get_currency_list.php?id=' + currency_id, function(data){
                var result = JSON.parse(data);
                document.getElementById("partner_currency").value = "";
                document.getElementById("partner_currency_value").value = "";
                $.each(result, function(index, item){

                	if(item.currency!="฿THB"&& item.currency!="THB" ){
	                    	if(item.currency_value==null || item.currency_value_convert==null ){
	                    		$dbh = null;
	                    		alert('Your currency conversion rate has expired. Kindly assess and update it accordingly.');
	        					window.location.href ='currency_convertion.php';
	                    	}
	                    	// return false;
	                }
                    // document.getElementById("currency_id").value = item.id;
                    // document.getElementById("currency").value = item.currency;

                    document.getElementById("partner_currency").value = item.currency_value;
                	document.getElementById("partner_currency_value").value = item.currency_value_convert;

                    // document.getElementById("premium_rate").value = '';
                    // document.getElementById("convertion_value").value = '';

                });
            });
</script>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" id="datepicker" ><small><font color="red">*</font></small>Start Date:</label>
                </div> 

                <div class="col-sm-2">
                    <input id="start_date" name="start_date[]" style="color: #000;border-color:#102958; text-align: center;" type="text" class="form-control" value="<?php echo $start_date; ?>" placeholder="dd-mm-yyyy" required>
                </div>
                <input hidden="ture" name="start_date_old" type="text" value="<?php echo $start_date; ?>" >

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>End Date:</label>
                </div>
                <div class="col-sm-2">
                    <input id="end_date" name="end_date[]" style="color: #000;border-color:#102958; text-align: center;" type="text"  class="form-control" 
                    value="<?php echo $stop_date; ?>" placeholder="dd-mm-yyyy" required>
                </div>
                <input hidden="ture" name="end_date_old" type="text" value="<?php echo $stop_date; ?>" >

            </div>

			<script>
			  $(document).ready(function(){
				$('#start_date').datepicker({
				  format: 'dd-mm-yyyy',
				  language: 'en'
				}).on('changeDate', function(e) {
                	updateEndDate();
            	});

				$('#end_date').datepicker({
				  format: 'dd-mm-yyyy',
				  language: 'en'
				});
				$('#paid_date').datepicker({
				  format: 'dd-mm-yyyy',
				  language: 'en'
				});
			  
			
                $('#period_type').change(function(){
                    // var value_period = document.getElementById("period_type").value;
                    var value_period = $(this).val();
                    // alert("value_period:"+value_period);
                    if(value_period == 'Day'){
                        document.getElementById("period_day").hidden = false;
                        document.getElementById("period_day").readOnly = false;
                        document.getElementById('period_day').setAttribute("required","required");
                        document.getElementById("period_month").hidden = true;
                        document.getElementById('period_month').removeAttribute('required');
                    }else if(value_period == 'Month'){
                        document.getElementById("period_day").hidden = true;
                        document.getElementById('period_day').removeAttribute('required');
                        document.getElementById("period_month").hidden = false;
                        document.getElementById('period_month').setAttribute("required","required");

                    }else{
                        document.getElementById("period_day").hidden = false;
                        document.getElementById("period_day").readOnly = true;
                        document.getElementById("period_month").hidden = true;
                    }
                });

			  document.getElementById('period_day').addEventListener('input', updateEndDate);
			  document.getElementById('period_month').addEventListener('input', updateEndDate);
			  $('#start_date').on('change', function() { updateEndDate(); });

			function updateEndDate() {
				var periodDayInput = document.getElementById('period_day');
				var periodMonthInput = document.getElementById('period_month');
				var startDateInput = document.getElementById('start_date');
				var endDateInput = document.getElementById('end_date');
				// var periodDayInput.html;
				var period_type = document.getElementById('period_type');
				// alert("periodMonthInput.html:"+periodMonthInput.options[periodMonthInput.selectedIndex].text);

				var parts = startDateInput.value.split('-');
				var startDate = new Date(parts[2], parts[1] - 1, parts[0]); 

				if(period_type.value == 'Day'){
					var periodDay = parseInt(periodDayInput.value);
					// ตรวจสอบว่า period_day และ start_date มีค่าหรือไม่
					if (!isNaN(periodDay) && startDate instanceof Date && !isNaN(startDate.getTime())) {
					  // สร้างวัตถุ Date จาก start_date
					  var endDate = new Date(startDate.getTime());

					  // เพิ่มจำนวนวันตาม period_day
					  endDate.setDate(endDate.getDate() + periodDay);

					  // แสดงวันที่ใน input end_date
					  var formattedEndDate = endDate.getDate().toString().padStart(2, '0') + '-' + (endDate.getMonth() + 1).toString().padStart(2, '0') + '-' + endDate.getFullYear();
					  endDateInput.value = formattedEndDate;
					  $('#end_date').datepicker('update', formattedEndDate);
					} else {
					  // หากไม่มีค่าใน period_day หรือ start_date ก็เคลียร์ค่าใน input end_date
					  endDateInput.value = '';
					}
				}else if(period_type.value == 'Month'){
					var periodDay = parseInt(periodMonthInput.options[periodMonthInput.selectedIndex].text);
					if (!isNaN(periodDay) && startDate instanceof Date && !isNaN(startDate.getTime())) {
						var endDate = new Date(addMonths(startDate, periodDay));
						// alert("endDate:"+endDate);
						var formattedEndDate = endDate.getDate().toString().padStart(2, '0') + '-' + (endDate.getMonth() + 1).toString().padStart(2, '0') + '-' + endDate.getFullYear();
						// endDateInput.value = addMonths(startDate, periodMonthInput.value);
						endDateInput.value = formattedEndDate;
						$('#end_date').datepicker('update', formattedEndDate);
					}else {
					  // หากไม่มีค่าใน period_day หรือ start_date ก็เคลียร์ค่าใน input end_date
					  endDateInput.value = '';
					}
				}
			  }
			   // ฟังก์ชันสำหรับการเพิ่มเดือนให้กับวันที่
				  function addMonths(date, months) {
					var d = new Date(date);
					d.setMonth(d.getMonth() + parseInt(months));
					// var currentDate = new Date(); // ดึงวันที่ปัจจุบัน
					// currentDate.setMonth(currentDate.getMonth() + 3); // เพิ่ม 3 เดือน
					return d;
				  }

			});	  
			</script>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Premium Rate:</label>
                </div>
                <div class="col-sm-2">
                    <input id="premium_rate" name="premium_rate[]" type="text" value="<?php echo number_format((float)$premium_rate, 2, '.', ','); ?>" style="border-color:#102958;text-align: right; color: #000;" step="0.01" min="0" class="form-control" 
                        onchange="
                        // var premium = parseFloat(this.value).toFixed(2);
                        // var percent = parseFloat(document.getElementById('percent_trade').value).toFixed(2);
                        // if(document.getElementById('calculate').value=='Percentage'){
                        // if(Number.isInteger(parseFloat(this.value).toFixed(2))){
                        //     this.value=this.value+'.00';
                        // }else{
                        //     this.value=parseFloat(this.value).toFixed(2);
                        // }
                        //     var commission = ((percent / 100) * premium);
                        // }else{
                        // document.getElementById('percent_trade').value = parseFloat(document.getElementById('percent_trade').value).toFixed(2);
                        //     var commission = percent;
                        // }
                        // document.getElementById('commission').value =parseFloat(commission).toFixed(2);
                        "  required/>
                </div>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Conversion Value:</label>
                </div>
                <div class="col-sm-2">
                    <input id="convertion_value" name="convertion_value[]"  style="color: #000;border-color:#102958; text-align: center;" type="test"  class="form-control" 
                    value="<?php echo number_format((float)$convertion_value, 2, '.',','); ?>"  readOnly>
                </div>
				
				<div class="col-sm-sm-2 label_left" >
                    <label style="color: #102958;"  ><small><font color="red">*</font></small>Collected Date:</label>
                </div> 
                <div class="col-sm-2">
                    <input id="paid_date" name="paid_date[]" <?php echo $paid_date; ?> style="color: #000;border-color:#102958; text-align: center;" type="text"  class="form-control" 
                    value="<?php echo $paid_date; ?>" placeholder="dd-mm-yyyy" required>

                     <input hidden="" id="paid_date_old" name="paid_date_old[]" <?php echo $paid_date; ?>  type="text"  class="form-control" 
                    value="<?php echo $paid_date; ?>" placeholder="dd-mm-yyyy" >

                </div>
        </div>

        <script>
        	var value_status = document.getElementById("status_i_input").value;
	        if(value_status=="New" || value_status=="Renew"){
	        	document.getElementById("paid_date").removeAttribute("disabled");
	            // document.getElementById("paid_date").removeAttribute("readOnly");
	        }else{
	        	 document.getElementById("paid_date").setAttribute("disabled","disabled");
	            // document.getElementById("paid_date").value=new Date();
	            // document.getElementById("paid_date").setAttribute("readOnly", true);
	            // $('#paid_date').datepicker({
                // format: 'dd-mm-yyyy',
                // language: 'en'
            	// }).attr('readonly', true);
	        }
	    </script>

        <!-- hidden="true" -->
        <input hidden="true" id="partner_currency"  type="text" value="<?php echo $currency_value; ?>" >
        <input hidden="true" id="partner_currency_value"  type="text" value="<?php echo $currency_value_convert; ?>" >

        <script>

        	$(function(){
	            var premium_rate_object = $('#premium_rate');
	            var convertion_value_object = $('#convertion_value');
	            var currency_object = $('#currency');

	            

	            premium_rate_object.on('change', function(){

	            	// if (isNaN(parseFloat(premium_value))) {

	            var premium_value = $(this).val().replace(/,/g,'');

	            if (parseFloat(premium_value)) {
	            	var partner_currency = document.getElementById("partner_currency").value;
        			var partner_currency_value = document.getElementById("partner_currency_value").value;
	            	if(currency_object.val()=='฿THB'){
	            		var formattedResult  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(premium_value);
	            		convertion_value_object.val(formattedResult);
	            	}else{
	            		// alert('partner_currency:');
	            		if(partner_currency!=''){
	            			if(parseInt(partner_currency)>parseInt(partner_currency_value)){
	            				var value = (premium_value/partner_currency_value);
	            				var formattedResult = value.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
	            				convertion_value_object.val(formattedResult);
	            			}else{
	            				var value = (premium_value*partner_currency_value);
	            				var formattedResult = value.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
	            				convertion_value_object.val(formattedResult);
	            			}
	            		}else{
	            			var formattedResult = premium_value.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
	            			convertion_value_object.val(formattedResult);
	            		}
	            		
	            	}
	            		var commission=0;
	            		var premiumInput = document.getElementById('premium_rate').value.replace(/,/g,'');
                        var premium = parseFloat(premiumInput).toFixed(2);
                        var con_vaInput = document.getElementById('convertion_value').value.replace(/,/g,'');
                        var con_va = parseFloat(con_vaInput).toFixed(2);
                        var percentInput = document.getElementById('percent_trade').value.replace(/,/g,'');
                        var percent = parseFloat(percentInput).toFixed(2);

                        // if(Number.isInteger(parseFloat(premium))){
                        	if(document.getElementById('calculate').value=='Percentage'){
                        		var commission = ((percent / 100) * con_va);
                        	}else{

                        		var commission = percent;
                        	}
                        // }else{
                        // 	document.getElementById('premium_rate').value=parseFloat(con_va);
                        // }
                        if(commission!='NaN'){
	                        var commissionNumber  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(commission);
	                        document.getElementById('commission').value =commissionNumber;
	                    }

                        var value_pre  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format($(this).val().replace(/,/g,''));
                        this.value=value_pre;
                 }else{
                 	this.value='';
                 	document.getElementById('commission').value ='';
                 	convertion_value_object.val('');
                 }

	            });
	        });
            </script>

        <div class="form-group row col-md-10 col-md-offset-1">
            	<div class="col-sm-2 label_left" >
                     <label style="color: #102958;" for="staticEmail" >Commission Type:</label>
                </div>
                <div class="col-sm-4 " >
                    <select id="calculate" name="calculate[]"  style="color: #000;border-color:#102958;" class="form-control" 
                        onchange="

                        // if(document.getElementById('percent_trade').value!=''){
                        // // var premium = parseFloat(document.getElementById('premium_rate').value).toFixed(2);
                       	// var premiumInput = document.getElementById('convertion_value').value.replace(/,/g,'');
						// var premium = parseFloat(premiumInput).toFixed(2);
                        // var percent = parseFloat(document.getElementById('percent_trade').value).toFixed(2);
                        // if(document.getElementById('calculate').value=='Percentage'){
                        //     if (parseFloat(percent)>100){
                        //         document.getElementById('percent_trade').value=parseFloat(100.00).toFixed(2)+'%';
                        //     }else{
                        //         document.getElementById('percent_trade').value=parseFloat(percent).toFixed(2)+'%';
                        //     } 
                        //     var percent = parseFloat(document.getElementById('percent_trade').value).toFixed(2);
                        //     var commission = ((percent / 100) * premium);
                        // }else{
                        //     document.getElementById('percent_trade').value = percent;
                        //     var commission = percent;
                        // }else{
                        // 	var commissionNumber  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(commission);
	                    //     document.getElementById('commission').value =commissionNumber;
                        // }

                        // 	// if(commission!='NaN'){
	                    //     var commissionNumber  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(commission);
	                    //     document.getElementById('commission').value =commissionNumber;
	                    // 	// }
	                    	
                        // }
                        "  />
                        <option value="Percentage" <?php if ("Percentage"==$calculate_type) { echo ' selected="selected"'; } ?> >Percentage</option>
                        <option value="Net Value" <?php if ("Net Value"==$calculate_type) { echo ' selected="selected"'; } ?> >Net Value</option>
                    </select>
                </div>

        </div>

        <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Commission Value:</label>
                </div> 
                <div class="col-sm-2 " >
                    <input id="percent_trade" name="percent_trade[]" value="<?php echo number_format((float)$percent_trade, 2, '.', ','); ?>" type="text" class="form-control" style="border-color:#102958;text-align: right; color: #000;" onchange="
                        // var num = parseInt(parseFloat(this.value).toFixed(0));

                    var num = $(this).val().replace(/,/g,'');
                    var commission ='';
                        // if(Number.isInteger(num)){
  					if (parseFloat(num)) {
                        var premiumInput = document.getElementById('convertion_value').value.replace(/,/g,'');
						var premium = parseFloat(premiumInput).toFixed(2);
                        // var premium = parseFloat(document.getElementById('premium_rate').value).toFixed(2);

                        if(document.getElementById('calculate').value=='Percentage'){

                        	if(document.getElementById('premium_rate').value!=''){
	                            if (parseFloat(num)>100){
	                                this.value=parseFloat(100.00).toFixed(2)+'%';
	                            }else{
	                                this.value=parseFloat(num).toFixed(2)+'%';
	                            } 
	                            var percent = parseFloat(this.value).toFixed(2);
	                             commission = ((percent / 100) * premium);
	                        }else{
	                        	this.value=parseFloat(num).toFixed(2)+'%';
	                        }

                        }else{
                        	num = num.replace('%', '');
                            document.getElementById('percent_trade').value = num;
                            var value_con  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(num);
                        	this.value=value_con;
                             commission = num;
                        }

                        	if(commission != ''){
	                        	var commissionNumber  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(commission);
	                        	document.getElementById('commission').value =commissionNumber;
                        	}
                    }else{
                            this.value='';
                            document.getElementById('commission').value ='';
                   	}
                    "  />
                </div> 
                 <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Commission Rate:</label>
                </div> 
                <div class="col-sm-2 " >
                    <input type="text" id="commission" name="commission[]" value="<?php echo number_format((float)$commission_rate, 2, '.',','); ?>" style="border-color:#102958;text-align: right;  color: #000;" class="form-control" readOnly/>
                </div>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Commission Status:</label>
                </div> 
                <div class="col-sm-2 " >
                     <select disabled="true" id="commission_status" name="commission_status[]" style="color: #000;border-color:#102958;" class="form-control"   >
                        <option value="<?php echo $commission_status; ?>" ><?php echo $commission_status; ?></option>
                    </select>
                </div>

            </div>

        <div class="form-group row col-md-10 col-md-offset-1">
            <!-- <label style="color: #102958;" class="col-sm-12" >Upload Image File Size width:994 height:634</label> -->

            <div class="col-sm-2 label_left" >
                <label style="color: #102958;" for="staticEmail" accept="application/pdf" >Upload Documents:</label>
            </div>
            <div class="col">
                <div >
                    <!-- accept="image/png, image/jpg, image/jpeg"  -->
					<input name="file_d[]" id="imgInp" type="file" style="width: 100%;" accept="application/pdf" >
                </div>
                <!-- <a href="upload/<?php echo $file_name_uniqid; ?>" download="<?php echo $file_name; ?>"><?php echo $file_name; ?></a> -->
                <?php if($file_name_uniqid){ ?>
                <div class="columns download">
                    <p>
                        <a href="image.php?filename=<?php echo $file_name_uniqid; ?>" class="button" download="<?php echo $file_name; ?>" download><i class="fa fa-download"></i>Download <?php echo $file_name; ?></a>
                    </p>
                </div>
                <?php } ?>
            </div>
             
        </div>

        <div  class="form-group row col-md-10 col-md-offset-1"  >
        	<div class="col-sm-2 label_left" >
                <label style="color: #102958;" >Remark:</label>
            </div>
            <div class="col " class="form-control" >
                <textarea id="remark" name="remark[]" minlength="1"  style="color: #000;border-color:#102958;" rows="3" class="form-control" ><?php echo $remark; ?></textarea>
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

		<!--
		<script>
			$(document).ready( function() {
				function readURL(input) {
					var fileName = document.getElementById("imgInp").value;
					var idxDot = fileName.lastIndexOf(".") + 1;
					var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
					if (extFile=="pdf"){
						if (input.files && input.files[0]) {
							var reader = new FileReader();
							reader.readAsDataURL(input.files[0]);
						}
					}else{
						var reader = new FileReader();
						reader.readAsDataURL(input.files[0]);
						document.getElementById("imgInp").value=null;
						// document.getElementById("img-upload").hidden = true;
						alert("Only pdf files are allowed!");
					}  
				}
				$("#imgInp").change(function(){
					readURL(this);
					});     
				});
		</script>
		-->
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
						var reader = new FileReader();
						reader.readAsDataURL(input.files[0]);
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
                                document.getElementById("imgInp").value = null;
                                var message = "The folder at " + data.folderPath + " is nearly full. Remaining space: " + data.remainingSizeGB + " GB.";
                                alert(message);
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
    </div>
</div>
</div>

<div id="dynamic_field"></div>

<div id="dynamic_field2"></div>

<div class="container-fluid">
        <div class="row">

            <div class="col-md-12 ">
                <div class="panel">

                    <div class="panel-heading">
                        <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="panel-title" style="color: #102958;" >
                            <h2 class="title">Customer</h2>
                        </div>
                        </div>
                    </div>
        <div class="panel-body">

    <input hidden="true" id="id_customer_input" name="id_customer_input" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $id_customer; ?>" >
    </input>
    <!-- hidden="true" -->
    <input hidden="true" id="id_default_contact" name="id_default_contact" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $id_default_contact; ?>" >
    </input>

    <?php //if($customer_type=='Personal'){ ?>
   

    <?php //}else{ ?>
     <!-- <div class="form-group row col-md-10 col-md-offset-1">
        <div class="col-sm-2 label_left" >
            <label hidden="true" style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Cust.name:</label>
        </div>
            <div class="col-3">
                <input hidden="true" id="name_c_input" name="name_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  required >
                </input>
            </div>
			 <div class="col-sm-3">
                    <button style="background-color: #0275d8;color: #F9FAFA;" type="button" class="btn " data-toggle="modal" data-target="#ModalCustomer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>&nbsp;
                    </button>
                   <button style="background-color: #0275d8;color: #F9FAFA;" type="button" class="btn" onclick="clear_customer()" >Clear</button>
                </div>    
            <div class="col-sm-3">
            </div>  
    </div>    --> 
    <?php //} ?>
   

    <div class="form-group row col-md-10 col-md-offset-1">
        <div class="col-sm-2 label_left mb-20" >
            <label style="color: #102958;" for="staticEmail" >Cust. Type:</label>
        </div>

        <div class="col-sm-3">
            <select id="type_c_input" name="type_c_input" type="hidden" onchange="ClickChange_personal()" style="border-color:#102958; color: #000;" class="form-control" >
                <option value="Personal" selected>Personal</option>
                <option value="Corporate" >Corporate</option>
            </select>
        </div>
        <!-- <input type="hidden" for="type_c_input"   /> -->

        <div class="col-sm-2 label_left" >
            <input id="status_c_input" name="status_c_input"  class="form-check-input" type="checkbox" value="true" checked>
            <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Active
            </label>
        </div>  
        <div class="col ">
			<label style="color: red; font-size: 12px;" >
				<I>Please select the search icon to locate your customer.</I>
			</label>
		</div>
       <!--  <div class="col-sm-2 label_right" >
        </div>
        <div class="col" >
        </div> -->
    </div>  

     <div class="form-group row col-md-10 col-md-offset-1">
        <div class="col-sm-2 label_left " >
            <label style="color: #102958;" for="staticEmail" >Cust. name:</label>
        </div>

        <div class="col ">
            <input id="name_c_input" name="name_c_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
            </input>
        </div>

        	<!-- <div class="col-sm-2 ">
        	</div>
        	<div class="col-sm-3 ">
        	</div>	 -->

                <div class="col-sm-3">
                    <button style="background-color: #0275d8;color: #F9FAFA;" type="button" class="btn " data-toggle="modal" data-target="#ModalCustomer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>&nbsp;
                    </button>
                    <!-- <button style="background-color: #0275d8;color: #F9FAFA;" type="button" class="btn" onclick="clear_customer()" >Clear</button> -->
                </div>    
            <!-- <div class="col-sm-3">
            </div>  --> 
    </div>

    <div class="form-group row col-md-10 col-md-offset-1">
        <div class="col-sm-2 label_left" >
            <label style="color: #102958;" >Cust. ID:</label>
        </div>
        <div class="col-sm-3">
            <input id="customer_c_input" name="customer_c_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="" >
            
        </div>
        <div class="col-sm-1 label_left">
            <label style="color: #102958;" >Cust. Level:</label>
        </div>   

            <div class="col-sm-2">
                <select id="level_c_input" name="level_c_input" style="border-color:#102958; color: #000;"   class="form-control" >
                    <option value="0" selected>Select Customer Level</option>
                    <?php  foreach($results_c_level as $result){ ?>
                        <option value="<?php echo $result->id; ?>" data-description="<?php echo $result->description; ?>" ><?php echo $result->level_name; ?></option>
                    <? } ?>
                </select>
            </div>

            <div class="col-sm-4 ">
                <input id="customer_de" name="customer_de" style="color: #000;border-color:#102958;" type="text" class="form-control"  readOnly> 
            </div>

                <!-- <div class="col-sm-2 label_right" >
                    <input id="status_c_input" name="status_c_input" class="form-check-input" type="checkbox" value=""  checked>
                    <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Active
                    </label>
                </div>  

        <div class="col" >
        </div>   -->
    </div>

                <script>
                    // รับ element ของ dropdown
                    var customerLevelDropdown = document.getElementById("level_c_input");
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

    <div class="form-group row col-md-10 col-md-offset-1 personal">
    	<div class="col-sm-2 label_left" id="title_c_label" >
                <label  style="color: #102958;" for="staticEmail" >Title:</label>
            </div>
            <div id="title_input" class="col-sm-3"   >
                <select id="title_c_input" name="title_c_input" style="border-color:#102958; color: #000;"  class="form-control" >
                            <?php  if($name_title=="Mr."){ ?>
                                <option value="Mr." selected>Mr.</option>
                            <?php }else{ ?>
                                <option value="Mr." >Mr.</option>
                            <?php } ?>
                            <?php  if($name_title=="Ms."){ ?>
                                <option value="Ms." selected>Ms.</option>
                            <?php }else{ ?>
                                <option value="Ms." >Ms.</option>
                            <?php } ?>

                            <?php  if($name_title=="Mrs."){ ?>
                                <option value="Mrs." selected>Mrs.</option>
                            <?php }else{ ?>
                                <option value="Mrs." >Mrs.</option>
                            <?php } ?>
                </select>    
            </div>
    </div>

    <div hidden="true" class="form-group row col-md-10 col-md-offset-1 ">
            
            <div class="col-sm-2 label_left corporate" id="company_c_label" >
                    <label hidden="true" style="color: #102958;" >Company name:</label>
            </div>
            <div hidden="true" class="col corporate" id="company_input" >
                    <input id="company_c_input" name="company_c_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
            </div>
	</div>


			<div class="form-group row col-md-10 col-md-offset-1 personal">
                <div id="first_c_label" class="col-sm-2 label_left" >
                    <label  style="color: #102958;" >First name:</label>
                </div>
                <div id="first_input" class="col">
                    <input id="first_c_input"  minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
                </div>

                <div id="last_c_label" class="col-sm-2 label_left" >
                    <label  style="color: #102958;" >Last name:</label>
                </div>
                <div id="last_input" class="col">
                    <input id="last_c_input" name="last_c_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
                </div>

			</div>  

			<div class="form-group row col-md-10 col-md-offset-1 personal">
                <div id="nick_c_label" class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Nickname:</label>
                </div>
                <div id="nick_input" class="col">
                    <input id="nick_c_input" name="nick_c_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  >
                </div>

                <div  class="col-sm-2 label_left" >
	            </div> 
	            <div class="col">
	            </div>
			</div>
			
			<div class="form-group row col-md-10 col-md-offset-1 ">
				<div  class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Tax ID / Passport ID:</label>
				</div>
				<div class="col">
						<!--<input id="personal_c_input" name="personal_c_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"   class="form-control" >-->
					<input id="personal_c_input" name="personal_c_input" minlength="1" maxlength="13" style="color: #000;border-color:#102958;" type="text"  class="form-control" >
				</div>
			
                <div id="div_personal_e_per" class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Email:</label>
                </div> 
                <div id="div_personal_e_cor" hidden="true" class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Email:</label>
                </div> 
                <div class="col">
                    <input id="email_c_input" name="email_c_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="email"   class="form-control" >
                </div>

                
                <div id="div_r_email_label " class="col-sm-2 personal" hidden="true" >
                </div>
                <div id="div_r_email_input" class="col personal" hidden="true" >
                </div>  

                <!-- <div id="div_r_email" hidden="true" > -->
                <!-- </div>     -->

            </div>

			<div  class="form-group row col-md-10 col-md-offset-1">
                <div id="div_personal" class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Mobile:</label>
                </div>
                <div id="div_corporate" hidden="true" class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Mobile:</label>
                </div>
                <div class="col">
                    <input id="mobile_c_input" name="mobile_c_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"   class="form-control"  pattern="\d{3}-\d{3}-\d{4}">
                </div>
                <script>
                    document.getElementById('mobile_c_input').addEventListener('input', function (e) {
                        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                        e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
                    });
                </script>

                <div id="div_personal_tel_la" hidden="true" class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Tel:</label>
                </div>
                <div id="div_personal_tel_in" hidden="true" class="col">
                    <input id="tel_c_input" name="tel_c_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  >
                </div>

                 <div  class="col-sm-2 label_left personal" >
                    <label style="color: #102958;" for="staticEmail" >Tel:</label>
                </div>
                <div class="col personal">
                    <input id="tel_c_input2" name="tel_c_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  >
                </div>
        </div> 
            
             <div class="panel-heading">
                <div class="form-group row col-md-10 col-md-offset-1">
                <div class="panel-title" style="color: #102958;" >
                    <h2 class="title" >Address</h2>
                </div>
                </div>
            </div> 

<?php
$sql_2 = "SELECT * FROM provinces";
$query_2 = $dbh->prepare($sql_2);
$query_2->execute();
$results_2=$query_2->fetchAll(PDO::FETCH_OBJ);
// $query = mysqli_query($conn, $sql);

?>

             <div class="form-group row col-md-10 col-md-offset-1">

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Address No:</label>
                </div>  
                <div class="col">
                    <input id="address_input" name="address_number_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"   class="form-control" >
                </div>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Building Name:</label>
                </div>

                <div class="col">
                    <input id="building_input" name="building_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Soi:</label>
                </div>
                <div class="col">
                    <input id="soi_input" name="soi_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  >
                </div>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Road:</label>
                </div>
                <div class="col">
                    <input id="road_input" name="road_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  >
                </div>
            </div>      
        
            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left"  >
                    <label for="province" style="color: #102958;" >Province:</label>
                </div>
                <div class="col">
                    <div id="row_province" >
                     <select id="province" name="province_id" style="border-color:#102958; color: #000;" class="remove-example form-control selectpicker" data-live-search="true" >
                            <div id="row_option" >
                            <option  value="0" selected>Select province</option>
                            <?php foreach($results_2 as $result_add){  ?>
                                <option value="<?php echo $result_add->code;?>" ><?php echo $result_add->name_en;?></option>
                            <?php } ?>
                            <div>
                    </select>
                    </div>
                </div>

                <div class="col-sm-2 label_left">
                    <label for="district" style="color: #102958;" >District:</label>
                </div>
                <div class="col">
                    <select id="district" name="district_id" style="border-color:#102958; color: #000;" class="form-control selectpicker" data-live-search="true" >
                        <option value="0" >Select district</option>
                    </select>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left"  >
                    <label for="sub_district" style="color: #102958;" >Sub-district:</label>
                </div>
                <div class="col">
                    <select id="sub_district" name="sub_district_id" style="border-color:#102958; color: #000;" class="form-control selectpicker" data-live-search="true" >
                        <option value="0" selected>Select sub-district</option>
                    </select>
                </div>

                <div class="col-sm-2 label_left"  >
                    <label style="color: #102958;" >Post Code:</label>
                </div> 
                <div class="col">
                    <select id="postcode" name="postcode_id" style="border-color:#102958; color: #000;" class="form-control selectpicker" data-live-search="true" >
                        <option value="0" selected>Select post code</option>
                    </select>
                </div>
            </div>


        </div>
    </div>                             
    </div>
</div>
</div>

<div class="container-fluid">
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel">
                    <div class="panel-heading">
                    <div class="form-group row col-md-10 col-md-offset-1">
                    <div class="col">
                    <div class="panel-title" style="color: #102958;" >
                        <h2 class="title">Contact Person</h2>
                    </div>
                </div>
        <div class="col">     

            <div class="form-check" style="top:20px;">
                <!-- disabled="true" -->
                <input hidden="true" id="same_co" name="same_co[]" class="form-check-input" type="checkbox" value="false" onclick="same_customer()" >
               <!--  <label  style="color: #000;" class="form-check-label" >
                    &nbsp;&nbsp;&nbsp;&nbsp; Same Customer Name
                </label> -->
            </div>
        </div>  
                        <!-- <div class="col text-right">
                            <br>
                                <a  name="add-con" id="add-con" class="btn" style="background-color: #0275d8;color: #F9FAFA;"><i
                                class="fas  fa-sm text-white-50"></i>+ Add More Contact</a>
                        </div>&nbsp;&nbsp; -->
                        </div>
                    </div>

        <div class="panel-body">
            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
            	<!-- hidden="true" -->
                <input hidden="true" id="id_co" name="id_co[]" type="text"  >
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Title:</label>
                </div>
                <div  class="col-sm-3">
                     <select id="title_co" name="title_co[]" style="border-color:#102958; color: #000;" class="form-control" >
                            <?php  if($name_title=="Mr."){ ?>
                                <option value="Mr." selected>Mr.</option>
                            <?php }else{ ?>
                                <option value="Mr." >Mr.</option>
                            <?php } ?>

                            <?php  if($name_title=="Ms."){ ?>
                                <option value="Ms." selected>Ms.</option>
                            <?php }else{ ?>
                                <option value="Ms." >Ms.</option>
                            <?php } ?>

                            <?php  if($name_title=="Mrs."){ ?>
                                <option value="Mrs." selected>Mrs.</option>
                            <?php }else{ ?>
                                <option value="Mrs." >Mrs.</option>
                            <?php } ?>
                        </select>    
                </div>
              

                <div class="col-sm-1">
                    <button style="background-color: #0275d8;color: #F9FAFA;" type="button" class="btn " data-toggle="modal" data-target="#ModalContact">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>&nbsp;
                    </button>
                    
                    <!-- <button style="background-color: #0275d8;color: #F9FAFA;" type="button" class="btn" onclick="clear_customer()" >Clear</button> -->
                </div>
				
				<div class="col ">
					<label style="color: red; font-size: 12px;" >
						<I>Please utilize the search icon if you wish to modify other contacts associated with this customer.</I>
					</label>
				</div>

            </div>
            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >First name:</label>
                </div>
                <div class="col">
                    <input id="first_co" name="first_co[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
                </div>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Last name:</label>
                </div>
                <div class="col">
                    <input id="last_co" name="last_co[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Nickname:</label>
                </div>
                <div class="col">
                    <input id="nick_co" name="nick_co[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  >
                </div>
            </div>

             <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Mobile:</label>
                </div>
                <div class="col">
                    <input id="mobile_co" name="mobile_co[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" pattern="\d{3}-\d{3}-\d{4}" >
                </div>
                <script>
                    document.getElementById('mobile_co').addEventListener('input', function (e) {
                        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                        e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
                    });
                </script>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Tel:</label>
                </div>  
                <div class="col">
                    <input id="tel_co" name="tel_co[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
				<div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Email:</label>
                </div>
                <div class="col">
                    <input id="email_co" name="email_co[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="email" class="form-control" >
                </div>
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Line ID:</label>
                </div>
                <div class="col">
                    <input id="line_co" name="line_co[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
                </div>
                <!-- <div class="col-sm-2 label_left" >
                </div>
                <div class="col">
                </div> -->
            </div>
            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Position:</label>
                </div>
                <div class="col">
                    <input id="position_co" name="position_co[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
                </div>

				<div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Department:</label>
                </div>
                <div class="col " class="form-control" >
                    <input id="department" name="department[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
                </div>
				
                
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Remark:</label>
                </div>
                <div class="col " class="form-control" >
                    <textarea id="remark_co" name="remark_co[]" minlength="1" maxlength="255" style="color: #000;border-color:#102958;"  class="form-control" rows="2"></textarea>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                </div>
                <div class="col " >
                    <input id="default_co" name="default_co[]" class="form-check-input" type="radio" id="flexCheckDefault" checked>
                    <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Default Contact
                    </label>
                </div>
                <div class="col-sm-2 label_left" >
                </div>
                <div class="col" >
                </div>
            </div>  

        </div>

        </div>
    </div>                             
    </div>
</div>

<div id="field_contact"></div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel">
                <div class="panel-body">

                <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-md-12">
                    <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn btn-primary">Submit <span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                    </button>
                     &nbsp;&nbsp;
                   	<a href="entry-policy.php" class="btn btn-primary" style="background-color: #0275d8;color: #F9FAFA;" >
                        <span class="text">Cancel</span>
                    </a> 
                </div>
                </div>
 
                </div>
            </div> 
        </div>  
    </div>  
</div>   

    <br><br><br>
</form>

<!------------------------------------------------------------------------------>
<script type="text/javascript" src="includes_php/same_customer.js"></script>
<!-- <script type="text/javascript" src="includes_php/product_categery.js"></script> -->
<script type="text/javascript" src="includes_php/select_customer.js"></script>
<script type="text/javascript" src="includes_php/address.js"></script>

<?php //include('includes_php/add_insurance.php');?>
<?php include('includes_php/add_contact.php');?>
<?php include('includes_php/popup_table_customer.php');?>
<?php include('includes_php/popup_table_contact.php');?>
<?php include('includes_php/popup_add_product.php');?>
<?php include('includes_php/popup_reason.php');?>
<?php include('includes_php/popup_renew.php');?>

<?php //include('includes_php/control_insurance.php');?>
<!------------------------------------------------------------------------------>

		<script >
            var product_object_popup = $('#popup_product');

			product_object_popup.html('');
            productsArray = [];
            $.get('get_product_not.php?id=' + <?php echo $insurance_company_id; ?>,function(data){
                    var result = JSON.parse(data);        
                    $.each(result, function(index, item){

                        productsArray.push({id: item.id, name: item.product_name,status : item.status_id});
                    });
                doSomethingWithProducts(productsArray);
            });

            function doSomethingWithProducts(products) {
                products.forEach(function(product) {
                    if(product.status === "true"){
                        product_object_popup.append('<option value="' + product.id + '" selected>' + product.name + '</option>');
                    }else{
                        product_object_popup.append('<option value="' + product.id + '" >' + product.name + '</option>');
                    }
                });
                $("#popup_product").selectpicker('refresh');

                var selectedOptions = Array.from(document.getElementById("popup_product").selectedOptions).map(option => option.textContent);
                    var selectedOptionsText = selectedOptions.join("\n");
                    document.getElementById("popup_product_all").value = selectedOptionsText;
                    var lineCount = (selectedOptionsText.match(/\n/g) || []).length + 1;
                    document.getElementById("popup_product_all").rows = lineCount;
                    document.getElementById("popup_product").addEventListener("change", function() {
                        var selectedOptions = Array.from(this.selectedOptions).map(option => option.textContent);
                        var selectedOptionsText = selectedOptions.join("\n");
                        document.getElementById("popup_product_all").value = selectedOptionsText;
                        var lineCount = (selectedOptionsText.match(/\n/g) || []).length + 1;
                        document.getElementById("popup_product_all").rows = lineCount;
                	});
            }

        </script>


<style>
	@media (min-width: 1340px){
		.label_left{
			max-width: 180px;
		}
		.label_right{
			max-width: 190px;
		}
	}
	
	.bootstrap-select.btn-group .dropdown-toggle .caret {
		margin-top: -4px !important;
	}
	
	.btn-group>.btn:first-child {
		border-color: #102958;
	}
	
	.bootstrap-select.btn-group.disabled, .bootstrap-select.btn-group>.disabled {
		background-color: #eee !important;
		color: #0C1830 !important;
		border-color: #102958 !important;
	}
</style>

 </div>
 
 	<?php include('includes/footer.php');?>
</body>

</html>
<?php } ?>

 <script type="text/javascript">
 	$(function(){

        var insurance_com_object = $('#insurance_com');
        var currency_object = $('#currency');
        var product_object = $('#product_name');
        var agent_name = $('#agent_name');
        // var partner_currency="";
        // var partner_currency_value="";

        var selectedOptions = Array.from(document.getElementById("popup_product").selectedOptions);
        var product_object_popup = $('#popup_product');
        var productsArray = [];

        insurance_com_object.on('change', function(){
            var currency_id = $(this).val();
            

            $.get('get_currency_list.php?id=' + currency_id, function(data){
                var result = JSON.parse(data);
                document.getElementById("partner_currency").value = "";
                document.getElementById("partner_currency_value").value = "";
                $.each(result, function(index, item){

                	if(item.currency!="฿THB"&& item.currency!="THB" ){
	                    	if(item.currency_value==null || item.currency_value_convert==null ){
	                    		$dbh = null;
	                    		alert('Your currency conversion rate has expired. Kindly assess and update it accordingly.');
	        					window.location.href ='currency_convertion.php';
	                    	}
	                    	// return false;
	                }
                    document.getElementById("currency_id").value = item.id;
                    document.getElementById("currency").value = item.currency;

                    document.getElementById("partner_currency").value = item.currency_value;
                	document.getElementById("partner_currency_value").value = item.currency_value_convert;

                    document.getElementById("premium_rate").value = '';
                    document.getElementById("convertion_value").value = '';


                });
            });



            // alert('test:');
            product_object.html('');
            $.get('get_product.php?id=' + currency_id,function(data){
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


            agent_name.html('');
            $.get('get_agent.php?id=' + currency_id, function(data){
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

            product_object_popup.html('');
            productsArray = [];
            $.get('get_product_not.php?id=' + currency_id,function(data){
                    var result = JSON.parse(data);        
                    $.each(result, function(index, item){

                        productsArray.push({id: item.id, name: item.product_name,status : item.status_id});
                    });
                doSomethingWithProducts(productsArray);
            });

            function doSomethingWithProducts(products) {
                products.forEach(function(product) {
                    if(product.status === "true"){
                        product_object_popup.append('<option value="' + product.id + '" selected>' + product.name + '</option>');
                    }else{
                        product_object_popup.append('<option value="' + product.id + '" >' + product.name + '</option>');
                    }
                });
                $("#popup_product").selectpicker('refresh');

                var selectedOptions = Array.from(document.getElementById("popup_product").selectedOptions).map(option => option.textContent);
                    var selectedOptionsText = selectedOptions.join("\n");
                    document.getElementById("popup_product_all").value = selectedOptionsText;
                    var lineCount = (selectedOptionsText.match(/\n/g) || []).length + 1;
                    document.getElementById("popup_product_all").rows = lineCount;
                    document.getElementById("popup_product").addEventListener("change", function() {
                        var selectedOptions = Array.from(this.selectedOptions).map(option => option.textContent);
                        var selectedOptionsText = selectedOptions.join("\n");
                        document.getElementById("popup_product_all").value = selectedOptionsText;
                        var lineCount = (selectedOptionsText.match(/\n/g) || []).length + 1;
                        document.getElementById("popup_product_all").rows = lineCount;
                	});
            }

        });  

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
    });
</script>

 <script type="text/javascript">
    // $(function(){
        var product_cat_object = $('#product_cat');
        var product_sub_object = $('#sub_cat');
        product_cat_object.on('change', function(){
            var product_cat_id = $(this).val();
            // product_sub_object.html('<option value="" >Choose a district</option>');
            product_sub_object.html('');
            
            $.get('get_product_subcategories.php?id=' + product_cat_id, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                product_sub_object.append(
                    $('<option></option>').val(item.id).html(item.subcategorie)
                );
            });
            $("#sub_cat").selectpicker('refresh');
            });
        });
    // });
</script>




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
    <script src="assets/js/custom2.js"></script>

    <script >
    // var table = $('#example').DataTable({
    //     scrollX: true,
    //     "scrollCollapse": true,
    //     "paging":         true

    // });

    // var table = $('#example2').DataTable({
    //     scrollX: true,
    //     "scrollCollapse": true,
    //     "paging":         true

    // });



    // table.buttons().container()
    // .appendTo('#example_wrapper .col-md-6:eq(0)');

    // });

    </script>
       
<div id="loading-overlay">
    <img src="loading.gif" alt="Loading...">
</div>

<script type="text/javascript">
    $('.corporate').hide();
    $('.personal').show();
</script>

<script type="text/javascript">
     var input_value=0;
     function ClickChange() {
        var value_status = document.getElementById("status_i_input").value;
        if(value_status=="Not renew"){
            $('#ModalNotrenew').modal('show');
            document.getElementById("area_not").hidden = false;
            document.getElementById("area_not_label").hidden = false;
        }else{
            document.getElementById("area_not").hidden = true;
            document.getElementById("area_not_label").hidden = true;
        }

        if(value_status=="New" || value_status=="Renew"){
        	// document.getElementById("paid_date").removeAttribute("readOnly");
            document.getElementById("paid_date").removeAttribute("disabled");
          
        }else{
        	// document.getElementById("paid_date").setAttribute("readOnly", true);
            document.getElementById("paid_date").setAttribute("disabled","disabled");
            // document.getElementById("paid_date").value=new Date();

        }

        var payment_object = $('#payment_status');
        payment_object.html('');
        if(value_status=="New" || value_status=="Follow up"){
            document.getElementById("payment_status").setAttribute("disabled","disabled");
            payment_object.append($('<option></option>').val("Paid").html("Paid"));
        }else if(value_status=="Wait" || value_status=="Not renew"){
            document.getElementById("payment_status").setAttribute("disabled","disabled");
            payment_object.append($('<option></option>').val("Not Paid").html("Not Paid"));
        }else if(value_status=="Renew"){
            document.getElementById('payment_status').removeAttribute("disabled");
            payment_object.append($('<option></option>').val("Paid").html("Paid"));
            payment_object.append($('<option></option>').val("Not Paid").html("Not Paid"));
            $('#ModalRenew').modal('show');
        }

    }
</script> 

<?php $dbh = null; ?>