
<!-- ========== Address Search ========== -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<?php
	session_start();
	error_reporting(0);
	include('includes/config.php');
	include('includes/config_path.php');
	if(strlen($_SESSION['alogin'])==""){
		header("Location: index.php"); 
	}else{
		if(isset($_POST['back'])){
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

		if(count($_POST["policy"])>0){
			$lastInsertId_customer="";
			$lastInsertId_contact_default=0;
		
	if($id_customer_input==""){ // insert sql customer
		// echo '<script>alert("submit id_customer_input: '.$id_customer_input.'")</script>'; 
				$sql="INSERT INTO customer (customer_name,customer_id,title_name,first_name,last_name".
			   ",nick_name,company_name,tel,mobile,email".
			   ",address_number,building_name,soi,road,sub_district".
			   ",district,province,post_code,status,cdate".
			   ",udate,create_by".
			   ",customer_type,tax_id,customer_level)";
				// ,[modify_by],[id_rela_contact],[id_rela_insurance_info]
	$sql=$sql." VALUES(:customer_name_p,:customer_id_p,:title_name_p,:first_name_p,:last_name_p".
			   ",:nick_name_p,:company_name_p,:tel_p,:mobile_p,:email_p".
			   ",:address_number_p,:building_name_p,:soi_p,:road_p,:sub_district_p".
			   ",:district_p,:province_p,:post_code_p,:status_p,GETDATE()".
			   ",GETDATE(),:create_by_p".
			   ",:customer_type_p,:tax_id_p,:customer_level_p) ";

		$query = $dbh->prepare($sql); 
		$query->bindParam(':customer_name_p',$name_c_input,PDO::PARAM_STR);
		$query->bindParam(':customer_id_p',$customer_c_input,PDO::PARAM_STR);

		$query->bindParam(':title_name_p',$title_c_input,PDO::PARAM_STR);
		$query->bindParam(':first_name_p',$first_c_input,PDO::PARAM_STR);
		$query->bindParam(':last_name_p',$last_c_input,PDO::PARAM_STR);
		$query->bindParam(':nick_name_p',$nick_c_input,PDO::PARAM_STR);

		$query->bindParam(':company_name_p',$company_n_c_input,PDO::PARAM_STR);
		$query->bindParam(':tel_p',$tel_c_input,PDO::PARAM_STR);
		$query->bindParam(':mobile_p',$mobile_c_input,PDO::PARAM_STR);
		$query->bindParam(':email_p',$email_c_input,PDO::PARAM_STR);

		$query->bindParam(':address_number_p',$address_number_input,PDO::PARAM_STR);
		$query->bindParam(':building_name_p',$building_input,PDO::PARAM_STR);
		$query->bindParam(':soi_p',$soi_input,PDO::PARAM_STR);
		$query->bindParam(':road_p',$road_input,PDO::PARAM_STR);

		$query->bindParam(':sub_district_p',$sub_district_id,PDO::PARAM_STR);
		$query->bindParam(':district_p',$district_id,PDO::PARAM_STR);
		$query->bindParam(':province_p',$province_id,PDO::PARAM_STR);
		$query->bindParam(':post_code_p',$postcode_id,PDO::PARAM_STR);
		if($status_c_input==""){
			$status_c_input="0";
		}else{
			$status_c_input="1";
		}
		$query->bindParam(':status_p',$status_c_input,PDO::PARAM_STR);
		$query->bindParam(':create_by_p',$_SESSION['id'],PDO::PARAM_STR);

		// $query->bindParam(':modify_by_p','1',PDO::PARAM_STR);

		// $query->bindParam(':id_rela_contact_p',"",PDO::PARAM_STR);
		// $query->bindParam(':id_rela_insurance_info_p',"",PDO::PARAM_STR);

		$query->bindParam(':customer_type_p',$type_c_input,PDO::PARAM_STR);
		$query->bindParam(':tax_id_p',$personal_c_input,PDO::PARAM_STR);
		$query->bindParam(':customer_level_p',$level_c_input,PDO::PARAM_STR);

		$query->execute();
		// print_r($query->errorInfo());
		$lastInsertId_customer = $dbh->lastInsertId();
	}else{ //update contact
		$lastInsertId_customer = $id_customer_input;
	}///////////////////////// end contact
		 
		if($lastInsertId_customer){ //// insert insurance
			$start_policy="true";
			$start_id_insurance="true";
			$start_lastInsertId_insurance="";
			for ($i=0;$i<count($_POST['policy']);$i++) {
				$sql = "INSERT INTO insurance_info".
				"(insurance_company,policy_no,status,product_category,sub_categories".
				",insurance_company_id,product_id,period,period_type,period_day,start_date,end_date".
				",premium_rate".
				",convertion_value".
				",percent_trade,commission_rate,agent_id,file_name".
				",file_name_uniqid,default_insurance,calculate_type,payment_status,paid_date,commission_status,cdate,create_by,reason)";
			$sql=$sql." VALUES (:insurance_company_p,:policy_no_p,:status_p,:product_category_p,:sub_categories_p".
					",:insurance_company_id_p,:product_id_p,:period_p,:period_type_p,:period_day_p,:start_date_p,:end_date_p".
					",:premium_rate_p".
					",:convertion_value_p".
					",:percent_trade_p,:commission_rate_p,:agent_id_p,:file_name_p".
					",:file_name_uniqid_p,:default_insurance_p,:calculate_type_p,:payment_status_p,:paid_date_p,:commission_status_p,GETDATE(),:create_by_p,:reason_p)";
				$query = $dbh->prepare($sql); 

				$query->bindParam(':insurance_company_p',$_POST['insurance_company'][$i],PDO::PARAM_STR);
				$query->bindParam(':policy_no_p',$_POST['policy'][$i],PDO::PARAM_STR);
				$query->bindParam(':status_p',$_POST['status'][$i],PDO::PARAM_STR);
				$query->bindParam(':product_category_p',$_POST['product_cat'][$i],PDO::PARAM_STR);
				$query->bindParam(':sub_categories_p',$_POST['sub_cat'][$i],PDO::PARAM_STR);

				$query->bindParam(':insurance_company_id_p',$_POST['insurance_com'][$i],PDO::PARAM_STR);
				$query->bindParam(':product_id_p',$_POST['product_name'][$i],PDO::PARAM_STR);

				$null_value;
				if($_POST['period_type'][$i]=='Month'){
					$query->bindParam(':period_type_p',$_POST['period_type'][$i],PDO::PARAM_STR);
					$query->bindParam(':period_p',$_POST['period_month'][$i],PDO::PARAM_STR);
					$query->bindParam(':period_day_p',$null_value,PDO::PARAM_STR);
				}else{
					$query->bindParam(':period_type_p',$_POST['period_type'][$i],PDO::PARAM_STR);
					$query->bindParam(':period_p',$null_value,PDO::PARAM_STR);
					$query->bindParam(':period_day_p',$_POST['period_day'][$i],PDO::PARAM_STR);
				}

				$query->bindParam(':start_date_p',date("Y-m-d", strtotime($_POST['start_date'][$i])),PDO::PARAM_STR);
				$query->bindParam(':end_date_p',date("Y-m-d", strtotime($_POST['end_date'][$i])),PDO::PARAM_STR);

				$per = substr($_POST['percent_trade'][$i],0,-1);

				$query->bindParam(':premium_rate_p',$_POST['convertion_value'][$i],PDO::PARAM_STR);
				$query->bindParam(':convertion_value_p',$_POST['premium_rate'][$i],PDO::PARAM_STR);

				$query->bindParam(':percent_trade_p',$per,PDO::PARAM_STR);
				$query->bindParam(':commission_rate_p',$_POST['commission'][$i],PDO::PARAM_STR);
				$query->bindParam(':agent_id_p',$_POST['agent'][$i],PDO::PARAM_STR);
				$query->bindParam(':payment_status_p',$_POST['payment_status'][$i],PDO::PARAM_STR);

				$query->bindParam(':calculate_type_p',$_POST['calculate'][$i],PDO::PARAM_STR);
				
				$query->bindParam(':paid_date_p',date("Y-m-d", strtotime($_POST['paid_date'][$i])),PDO::PARAM_STR);

				$commission_status = "Not Paid";
				$query->bindParam(':commission_status_p',$commission_status,PDO::PARAM_STR);

				$query->bindParam(':reason_p',$_POST['textarea_detail'][$i],PDO::PARAM_STR);
				$query->bindParam(':create_by_p',$_SESSION['id'],PDO::PARAM_STR);
				 
				if($start_policy=="true"){
					$value=1;
					$query->bindParam(':default_insurance_p',$value,PDO::PARAM_STR);
					$start_policy="false";
				}else{
					$value=0;
					$query->bindParam(':default_insurance_p',$value,PDO::PARAM_STR);
				}
		//////////// upload ////////////
		$new_file_name="";
		// echo '<script>alert("post file_d : '.$_FILES['file_d']['name'][$i].'")</script>'; 
		if($_FILES['file_d']['name'][$i]!=""){
			try {
				$file = $_FILES['file_d']['name'][$i];
				$file_loc = $_FILES['file_d']['tmp_name'][$i];
				// $image=$_POST['file_d'];
				$folder=$sourceFilePath;
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				$new_file_name = uniqid().".".$ext;
				$path_file = $folder."/".$new_file_name;
				$final_file=str_replace(' ','-',$new_file_name);
				move_uploaded_file($file_loc,$folder.$final_file);    
			}catch(Exception $e) {
				// echo '<script>alert("Error : '.$e.'")</script>'; 
			}
		}
		////////////////////////////////////

				$query->bindParam(':file_name_p',$_FILES['file_d']['name'][$i],PDO::PARAM_STR);
				$query->bindParam(':file_name_uniqid_p',$new_file_name,PDO::PARAM_STR);
				////////////
				$query->execute();
				// print_r($query->errorInfo());

				$lastInsertId_insurance = $dbh->lastInsertId();
				if($start_id_insurance=="true"){
					$start_lastInsertId_insurance = $dbh->lastInsertId();
					$start_id_insurance="false";
				}

				// $lastInsertId_customer
				$sql = "INSERT INTO rela_customer_to_insurance".
					"(id_customer,id_insurance_info,id_default_insurance)";
				$sql=$sql." VALUES (:id_customer_p,:id_insurance_info_p,:id_default_insurance)";
				$query = $dbh->prepare($sql); 
				$query->bindParam(':id_customer_p',$lastInsertId_customer,PDO::PARAM_STR);
				$query->bindParam(':id_insurance_info_p',$lastInsertId_insurance,PDO::PARAM_STR);
				$query->bindParam(':id_default_insurance',$start_lastInsertId_insurance,PDO::PARAM_STR);
				$query->execute();
				// print_r($query->errorInfo());
			}//loop for Insurance information

			// echo '<script>alert("count title_co:'.count($_POST['title_co']).'")</script>'; 
			for ($i=0;$i<count($_POST['title_co']);$i++) {
				// echo '<script>alert("value id_co:'.$_POST['id_co'][$i].'")</script>'; 
				if($_POST['id_co'][$i]==""){ /// insert
					$sql = "INSERT INTO contact ".
					"(title_name,first_name,last_name,nick_name,tel".
					",mobile,email,line_id,position,remark".
					",default_contact,department)";
					$sql=$sql." VALUES (:title_name_p,:first_name_p,:last_name_p,:nick_name_p,:tel_p".
						 ",:mobile_p,:email_p,:line_id_p,:position_p,:remark_p".
						 ",:default_contact_p,:department_p)";
					$query = $dbh->prepare($sql); 
					$query->bindParam(':title_name_p',$_POST['title_co'][$i],PDO::PARAM_STR);
					$query->bindParam(':first_name_p',$_POST['first_co'][$i],PDO::PARAM_STR);
					$query->bindParam(':last_name_p',$_POST['last_co'][$i],PDO::PARAM_STR);
					$query->bindParam(':nick_name_p',$_POST['nick_co'][$i],PDO::PARAM_STR);
					$query->bindParam(':tel_p',$_POST['tel_co'][$i],PDO::PARAM_STR);

					$query->bindParam(':mobile_p',$_POST['mobile_co'][$i],PDO::PARAM_STR);
					$query->bindParam(':email_p',$_POST['email_co'][$i],PDO::PARAM_STR);
					$query->bindParam(':line_id_p',$_POST['line_co'][$i],PDO::PARAM_STR);
					$query->bindParam(':position_p',$_POST['position_co'][$i],PDO::PARAM_STR);
					$query->bindParam(':remark_p',$_POST['remark_co'][$i],PDO::PARAM_STR);
					$query->bindParam(':department_p',$_POST['department'][$i],PDO::PARAM_STR);

					$default_status = $_POST['default_co'][$i];
					if($default_status==""){
						$default_status="0";
					}else{
						$default_status="1";
					}
					$query->bindParam(':default_contact_p',$default_status,PDO::PARAM_STR);
					
					$query->execute();
					// print_r($query->errorInfo());
					$lastInsertId_contact = $dbh->lastInsertId();

					$sql = "INSERT INTO rela_customer_to_contact".
					"(id_customer,id_contact)";
					$sql=$sql." VALUES (:id_customer_p,:id_contact_p)";
					$query = $dbh->prepare($sql); 
					$query->bindParam(':id_customer_p',$lastInsertId_customer,PDO::PARAM_STR);
					$query->bindParam(':id_contact_p',$lastInsertId_contact,PDO::PARAM_STR);
					if($default_status==""){
						// $default_status="0";
					}else{
						$lastInsertId_contact_default = $lastInsertId_contact;
					}

					$query->execute();
					// print_r($query->errorInfo());
				}

			}//loop for Contact Person

			/////////////////////// insert history
			  $sql = "INSERT INTO report_history_policy
					(id_insurance_info,policy_no,start_date,end_date
			   ,premium_rate
			   ,convertion_value
			   ,percent_trade,commission_rate,payment_status
			   ,insurance_company_id,insurance_company_name,status,agent_id
			   ,customer_id,customer_name,tel,mobile,email,paid_date,type,contact_id_default,create_by,cdate)  VALUES  
				(:id_insurance_info_p,:policy_no_p,:start_date_p,:end_date_p
			   ,:premium_rate_p
			   ,:convertion_value_p
			   ,:percent_trade_p,:commission_rate_p,:payment_status_p
			   ,:insurance_company_id_p,:insurance_company_name_p,:status_p,:agent_id_p
			   ,:customer_id_p,:customer_name_p,:tel_p,:mobile_p,:email_p,:paid_date_p,:type_p,:contact_id_default_p,create_by_p,GETDATE()) ";
				$query = $dbh->prepare($sql); 
				$query->bindParam(':id_insurance_info_p',$lastInsertId_insurance,PDO::PARAM_STR);
				$query->bindParam(':policy_no_p',$_POST['policy'][0],PDO::PARAM_STR);
				$query->bindParam(':start_date_p',date("Y-m-d", strtotime($_POST['start_date'][0])),PDO::PARAM_STR);
				$query->bindParam(':end_date_p',date("Y-m-d", strtotime($_POST['end_date'][0])),PDO::PARAM_STR);


				$query->bindParam(':premium_rate_p',$_POST['convertion_value'][0],PDO::PARAM_STR);
				$query->bindParam(':convertion_value_p',$_POST['premium_rate'][0],PDO::PARAM_STR);

				$query->bindParam(':percent_trade_p',substr($_POST['percent_trade'][0],0,-1),PDO::PARAM_STR);
				$query->bindParam(':commission_rate_p',$_POST['commission'][0],PDO::PARAM_STR);
				$query->bindParam(':payment_status_p',$_POST['payment_status'][0],PDO::PARAM_STR);

				$query->bindParam(':insurance_company_id_p',$_POST['insurance_com'][0],PDO::PARAM_STR);
				$query->bindParam(':insurance_company_name_p',$_POST['product_name'][0],PDO::PARAM_STR);
				$query->bindParam(':status_p',$_POST['status'][0],PDO::PARAM_STR);
				$query->bindParam(':agent_id_p',$_POST['agent'][0],PDO::PARAM_STR);

				$query->bindParam(':customer_id_p',$lastInsertId_customer,PDO::PARAM_STR);
				$query->bindParam(':customer_name_p',$name_c_input,PDO::PARAM_STR);
				$query->bindParam(':tel_p',$tel_c_input,PDO::PARAM_STR);
				$query->bindParam(':mobile_p',$mobile_c_input,PDO::PARAM_STR);
				$query->bindParam(':email_p',$email_c_input,PDO::PARAM_STR);
				$query->bindParam(':paid_date_p',date("Y-m-d", strtotime($_POST['paid_date'][0])),PDO::PARAM_STR);
				$type_insert = "insert";
				$query->bindParam(':type_p',$type_insert,PDO::PARAM_STR);
				// echo '<script>alert("lastInsertId_contact_default: '.$lastInsertId_contact_default.'")</script>'; 
				$query->bindParam(':contact_id_default_p',$lastInsertId_contact_default,PDO::PARAM_STR);
				$query->bindParam(':create_by_p',$_SESSION['id'],PDO::PARAM_STR);

				// $query->bindParam(':contact_id_p',$contact_id,PDO::PARAM_STR);

				$query->execute();
			// print_r($query->errorInfo());
		}

		}
		// echo '<script>alert("Successfully added information.")</script>';
		echo "<script>window.location.href ='entry-policy.php'</script>";

		}else{

		}

	// if($lastInsertId)
	// {
	// $msg="Class Created successfully";
	// }
	// else 
	// {
	// $error="Something went wrong. Please try again";
	// }


	$sql_company = " SELECT ip.id AS id_partner,*,cl.currency from insurance_partner ip
	JOIN currency_list cl ON ip.id_currency_list = cl.id
	WHERE ip.status = 1 ";
	$query_company = $dbh->prepare($sql_company);
	$query_company->execute();
	$results_company = $query_company->fetchAll(PDO::FETCH_OBJ);
	$start = "true";
	foreach($results_company as $result){
		if($start=="true"){
			$id_partner = $result->id_partner;
			$currency_id = $result->id_currency_list;
			$currency_name = $result->currency;
			$start="false";

			$paid_date = $result->paid_date;
		}
	}

	$sql_product = " SELECT pr.* FROM product pr
	JOIN rela_partner_to_product rp ON rp.id_product = pr.id
	WHERE rp.id_partner = ".$id_partner;
	$query_product = $dbh->prepare($sql_product);
	$query_product->execute();
	$results_product = $query_product->fetchAll(PDO::FETCH_OBJ);


	$sql_period = " SELECT * from period WHERE status = 1 order by LEN(period) ";
	$query_period = $dbh->prepare($sql_period);
	$query_period->execute();
	$results_period = $query_period->fetchAll(PDO::FETCH_OBJ);

	$sql_agent = " SELECT * from agent WHERE status = 1 ";
	$query_agent = $dbh->prepare($sql_agent);
	$query_agent->execute();
	$results_agent=$query_agent->fetchAll(PDO::FETCH_OBJ);

	$sql_c_level = " SELECT * from customer_level WHERE status = 1 ";
	$query_c_level = $dbh->prepare($sql_c_level);
	$query_c_level->execute();
	$results_c_level=$query_c_level->fetchAll(PDO::FETCH_OBJ);

	$sql_categories = " SELECT * from product_categories WHERE status = 1 order by id asc ";
	$query_categories = $dbh->prepare($sql_categories);
	$query_categories->execute();
	$results_categories = $query_categories->fetchAll(PDO::FETCH_OBJ);

	$start ="true";
	$first_order="0";
	foreach($results_categories as $result){
		if($start=="true"){
			$first_order = $result->id;
			$start = "false";
		}
	}

	$sql_sub = " SELECT * from product_subcategories WHERE status = 1 AND id_product_categorie = '".$first_order."'";
	$query_sub = $dbh->prepare($sql_sub);
	$query_sub->execute();
	$results_sub = $query_sub->fetchAll(PDO::FETCH_OBJ);

	$start_date= date('d-m-Y');
	$stop_date = date('d-m-Y');
	$paid_date = date('d-m-Y');

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

<!-- <form method="post" onSubmit="return valid();" action = "validate.php" > -->
<form method="post" action = "add-policy.php" enctype="multipart/form-data" onsubmit="
$(this).find('select').prop('disabled', false);
$(this).find('input').prop('disabled', false);
return valid();
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
                         <div class="col-sm-4 text-right ">
                            <br>
                            <!-- href="#"  -->
                            <a  name="add" id="add" class="btn" style="background-color: #0275d8;color: #F9FAFA;"><i
                                class="fas  fa-sm text-white-50"></i>+ Add More Insurance</a>
                        </div>&nbsp;&nbsp;

                    </div>
                </div> 

        <div class="panel-body">

            <div class="form-group row col-md-10 col-md-offset-1" >
                <!-- &nbsp; <p class="pull-right"> -->
                <input hidden="true" id="id_insurance_info" name="id_insurance_info[]" value="<?php echo $result->id_customer; ?>" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" id="success" >
                </input>
                <div class="col-sm-2  label_left"  >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Policy No:</label>
                </div>
                <!-- col-xs-auto -->
                <div class="col">
                    <input id="policy" name="policy[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text"  required>
                </div>
                <div class="col-sm-2  label_left" >
                </div>
                <div class="col">
                </div>
            </div>

            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Policy Status:</label>
                </div>
                <div class="col-2">
					<select id="status_i_input" name="status[]" onchange="ClickChange()" style="border-color:#102958;" class="form-control" required>
						<!-- <option value="" selected>Select Status</option> -->
						<option value="New">New</option>
						<option value="Follow up">Follow up</option>
						<option value="Renew">Renew</option>
						<option value="Wait">Wait</option>
						<option value="Not renew">Not renew</option>
					</select>
                </div>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Payment Status:</label>
                </div> 
                <div class="col-2 " >
                     <select disabled="true" id="payment_status" name="payment_status[]" style="color: #0C1830;border-color:#102958;" class="form-control"   >
                        <option value="Paid" >Paid</option>
                        <option value="Not Paid" >Not Paid</option>
                    </select>
                </div>
                <div class="col-2" >
                </div>
            </div> 

            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <div class="col-sm-2  label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Partner Name:</label>
                </div>
                <div class="col"  >
                <input hidden="true" type="text" id="currency_id" name="currency_id[]" style="border-color:#102958;" class="form-control" value="<?php echo $currency_id; ?>" required/>
                <select id="insurance_com" name="insurance_com[]"  style="color: #0C1830;border-color:#102958;"class="form-control"  required>
                    <option value="" selected>Select Partner Name</option>
                    <?php  foreach($results_company as $result){ ?>
                        <option value="<?php echo $result->id_partner; ?>" ><?php echo $result->insurance_company; ?></option>
                    <? } ?>
                </select>
                </div>
            </div>

           <!--  <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Prod. Category:</label>
                </div>
            <div class="col">
                <select id="product_cat" name="product_cat[]" style="color: #0C1830;border-color:#102958;" class="form-control" value="" required>
                    <option value="" selected>Select Product Category</option>
                         <?php  foreach($results_categories as $result){ ?>
                            <option value="<?php echo $result->id; ?>"><?php echo $result->categorie; ?></option>
                        <? } ?>
                       
                    </select>
                </div>

                <div class="col-sm-2  " >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Sub Categories:</label>
                </div>
                <div class="col"  >
                <select id="sub_cat" name="sub_cat[]"  style="color: #0C1830;border-color:#102958;"class="form-control" value="0" required>
                    <option value="" selected>Select Sub Categories</option>
                    <?php  foreach($results_sub as $result){ ?>
                            <option value="<?php echo $result->id; ?>"><?php echo $result->subcategorie; ?></option>
                    <? } ?>
                </select>
                </div>
            </div> -->

            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Product Name:</label>
                </div> 
                <div class="col">
                    <select id="product_name" name="product_name[]"  style="color: #0C1830;border-color:#102958;"class="form-control" value="0" required>
                        <option value="" selected>Select Product Name</option>
                        <?php  //foreach($results_product as $result){ ?>
                            <!-- <option value="<?php //echo $result->id; ?>" ><?php //echo $result->product_name; ?></option> -->
                        <? //} ?>
                    </select>
                </div>

                <!-- data-target="#ModalProduct" -->
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
				}
			</script>

            <!-- hidden="true" -->
            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
            	<div class="col-6">
            		<input hidden="true" id="product_cat" name="product_cat[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text" >
            	</div>
            	<div class="col-6">
            		<input hidden="true" id="sub_cat" name="sub_cat[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text" >
            	</div>
            </div> 

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2  label_left" >
                    <label style="color: #102958;" >Currency:</label>
                </div>
                <div class="col-2">
                    <input type="text" id="currency" name="currency[]" style="border-color:#102958;  text-align: center;" class="form-control"
                     value="<?php echo $currency_name; ?>" readOnly/>
                </div>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Period type:</label>
                </div>
                <div class="col-2">
                    <select id="period_type" name="period_type[]"  style="color: #0C1830;border-color:#102958;"class="form-control" required>
                        <option value="" selected>Select Period type</option>
                        <option value="Day" >Day</option>
                        <option value="Month" >Month</option>
                    </select>
                </div>       

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Period:</label>
                </div>
                <div class="col-2">
                    <select hidden="true" id="period_month" name="period_month[]"  style="color: #0C1830;border-color:#102958;"class="form-control" value="" required>
                        <option value="" selected>Select Period</option>
                        <?php  foreach($results_period as $result){ ?>
                        <option value="<?php echo $result->id; 
                        //echo $result->period; ?>" ><?php echo $result->period; ?></option>
                        <? } ?>
                    </select>
                    <input  id="period_day" name="period_day[]" minlength="1" maxlength="3" style="color: #0C1830;border-color:#102958;" type="number" class="form-control input_text" required readOnly>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" id="datepicker" ><small><font color="red">*</font></small>Start Date:</label>
                </div> 
                <div class="col-2">
                    <input id="start_date" name="start_date[]" style="color: #0C1830;border-color:#102958; text-align: center;" type="text" class="form-control" value="<?php echo $start_date; ?>" placeholder="dd-mm-yyyy" required>
                </div>
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>End Date:</label>
                </div> 
                <div class="col-2">
                    <input id="end_date" name="end_date[]" style="color: #0C1830;border-color:#102958; text-align: center;" type="text"  class="form-control" 
                    value="<?php echo $start_date; ?>" placeholder="dd-mm-yyyy" required>
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
			  });
			</script>

			<script>
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
			</script>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Premium Rate:</label>
                </div>
                <div class="col-2">
                    <input id="premium_rate" name="premium_rate[]" type="number"  style="border-color:#102958;text-align: right;" step="0.01" min="0" class="form-control text-end" 
                        onchange="
            //             var premium = parseFloat(this.value).toFixed(2);
            //             // parseFloat(document.getElementById('convertion_value').value).toFixed(2);
            //             var premium = document.getElementById('convertion_value').value;
            //             alert('premium:'+premium);
            //             var percent = parseFloat(document.getElementById('percent_trade').value).toFixed(2);
            //             if(document.getElementById('calculate').value=='Percentage'){
            //                 if(Number.isInteger(parseFloat(this.value).toFixed(2))){
            //                     this.value=this.value+'.00';
            //                 }else{
            //                     this.value=parseFloat(this.value).toFixed(2);
            //                 }
            //                 var commission = ((percent / 100) * premium);
            //             }else if(document.getElementById('calculate').value=='Net Value'){
            // document.getElementById('percent_trade').value = parseFloat(document.getElementById('percent_trade').value).toFixed(2);
            //                 // var commission = premium - percent;
            //                 var commission = percent;
            //             }else{
            //                 if(Number.isInteger(parseFloat(this.value).toFixed(2))){
            //                      this.value=this.value+'.00';
            //                      // this.value=this.value.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
            //                 }else{
            //                      this.value=parseFloat(this.value).toFixed(2);
            //                 }
            //             }
            //             document.getElementById('commission').value =parseFloat(commission).toFixed(2);
                        " required/>
                </div>

                <script type="text/javascript">
                    easyNumberSeparator({
                      selector: '.number-separator',
                      separator: ',',
                      resultInput: '#result_input',
                    });
                </script>
                
           		<div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Convertion Value:</label>
                </div> 
                <div class="col-2">
                    <input id="convertion_value" name="convertion_value[]"  style="color: #0C1830;border-color:#102958; text-align: center;" type="test"  class="form-control" 
                    value="<?php //echo $paid_date; ?>"  readOnly>
                </div>

                 <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Paid Date:</label>
                </div>
                <div class="col-2">
                    <input id="paid_date" name="paid_date[]"  style="color: #0C1830;border-color:#102958; text-align: center;" type="test"  class="form-control" 
                    value="<?php echo $paid_date; ?>" placeholder="dd-mm-yyyy" required>
                </div>
            </div>

            <script>
        	$(function(){
	            var premium_rate_object = $('#premium_rate');
	            var convertion_value_object = $('#convertion_value');
	            var currency_object = $('#currency');

	            premium_rate_object.on('change', function(){
	            	var premium_value = $(this).val();
	            	if(currency_object.val()=='฿THB'){
	            		var formattedResult = premium_value.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
	            		convertion_value_object.val(formattedResult);
	            	}else{
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
                        if(Number.isInteger(parseFloat(premium))){
                        	if(document.getElementById('calculate').value=='Percentage'){
                        		var commission = ((percent / 100) * con_va);
                        	}else{

                        		var commission = percent;
                        	}
                        }else{
                        	document.getElementById('premium_rate').value=parseFloat(con_va);
                        }
                        var commissionNumber = parseFloat(commission).toFixed(2);
                        document.getElementById('commission').value =parseFloat(commission).toFixed(2);

	            });
	        });
            </script>

            <div class="form-group row col-md-10 col-md-offset-1">    

                <div class="col-sm-2 label_left" >
                     <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Commission Type:</label>
                </div>
                <div class="col-4 " >
                    <select id="calculate" name="calculate[]" value="<?php echo $result->product_category; ?>" style="color: #0C1830;border-color:#102958;" class="form-control" 
                        onchange="
                    if(document.getElementById('percent_trade').value!=''){
                    	var premiumInput = document.getElementById('convertion_value').value.replace(/,/g,'');
                        var premium = parseFloat(premiumInput).toFixed(2);

                        var percent = parseFloat(document.getElementById('percent_trade').value).toFixed(2);

                        if(document.getElementById('calculate').value=='Percentage'){
                            if (parseFloat(percent)>100){
                                document.getElementById('percent_trade').value=parseFloat(100.00).toFixed(2)+'%';
                            }else{
                                document.getElementById('percent_trade').value=parseFloat(percent).toFixed(2)+'%';
                            } 
                            var percent = parseFloat(document.getElementById('percent_trade').value).toFixed(2);
                            var commission = ((percent / 100) * premium);

                        }else if(document.getElementById('calculate').value=='Net Value'){
                            document.getElementById('percent_trade').value = percent;
                            // var commission = premium-percent;
                            var commission = percent;
                        }
                        document.getElementById('commission').value =parseFloat(commission).toFixed(2);
                    }

                        " required/>
                        <option value="" selected>Select Calculate by</option>
                        <option value="Percentage" >Percentage</option>
                        <option value="Net Value" >Net Value</option>
                    </select>
                </div>

                
            </div>

        <div class="form-group row col-md-10 col-md-offset-1">
            <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Commission Value:</label>
                </div> 
                <div class="col-2 " >
                    <input id="percent_trade" name="percent_trade[]" type="text" class="form-control" style="border-color:#102958;text-align: right;" onchange="
                        var num = parseInt(parseFloat(this.value).toFixed(0));
                        if(Number.isInteger(num)){
                        	var premiumInput = document.getElementById('convertion_value').value.replace(/,/g,'');
							var premium = parseFloat(premiumInput).toFixed(2);
                        // var premium = parseFloat(document.getElementById('convertion_value').value).toFixed(2);
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
                            // document.getElementById('percent_trade').value = this.value;
                            // var commission = percent.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                        }
                            document.getElementById('commission').value =parseFloat(commission).toFixed(2);
                        }else{
                            this.value='';
                        }
                        " required/>
                </div> 
                 <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Commission Rate:</label>
                </div> 
                <div class="col-2 " >
                    <input type="number" id="commission" name="commission[]" style="border-color:#102958;text-align: right;" class="form-control" readOnly/>
                </div>

                <div class="col-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Commission Status:</label>
                </div> 
                <div class="col-2 " >
                     <select disabled="true" id="commission_status" name="commission_status[]" style="color: #0C1830;border-color:#102958;" class="form-control"   >
                        <!-- <option value="Paid" >Paid</option> -->
                        <option value="Not Paid" >Not Paid</option>
                    </select>
                </div>
        </div>

       
        <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Agent Name:</label>
                </div>

            <div class="col-4">
                <select id="agent_name" name="agent[]" style="color:#0C1830;border-color:#102958;" class="form-control selectpicker" data-live-search="true" >
                    <option value="" selected>Select Agent Name</option>
                    <?php  //foreach($results_agent as $result){ ?>
                        <!-- <option value="<?php //echo $result->id; ?>" ><?php //echo $result->title_name." ".$result->first_name." ".$result->last_name."(".$result->nick_name.")"; ?></option> -->
                    <? //} ?>
                </select>
            </div>

            <!-- <label style="color: #102958;" class="col-sm-12" >Upload Image File Size width:994 height:634</label> -->

            <div class="col-sm-2 label_left" >

                <label style="color: #102958;" for="staticEmail"  >Upload Documents:</label>
            </div>
            <div class="col">
                <div > 
                	<!-- required -->
                    <input name="file_d[]" id="imgInp" type="file" style="width: 100%;" accept="application/pdf" >
                </div>
            </div>
        </div>

        <div  class="form-group row col-md-10 col-md-offset-1"  >
            <div id="area_not_label" hidden="true" class="col-sm-2 label_left" >  
                <label style="color: #102958;"  >Reason:</label>
            </div>
            <div id="area_not" hidden="true" class="col">
                <textarea id="textarea_detail" name="textarea_detail[]" class="form-control" rows="5" placeholder="Cancellation reason" ></textarea>
            </div>

             <div class="col-sm-2 label_left" >
                
            </div>
            <div class="col">
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

    <div class="form-group row col-md-10 col-md-offset-1">

         <input hidden="true" id="id_customer_input" name="id_customer_input" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" id="success" >
         </input>

        <div class="col-sm-2 label_left" >
            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Cust. name:</label>
        </div>
                <div class="col-3">
                    <input id="name_c_input" name="name_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" id="success" value="" required>
                        <!-- <span class="btn-label btn-label-right"><i class="fa fa-check"></i></span> -->
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
            <div class="col-3">
            </div>  
    </div>

    <div class="form-group row col-md-10 col-md-offset-1">
        <div class="col-sm-2 label_left mb-20" >
            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Cust. Type:</label>
        </div>

        <div class="col-3">
            <select id="type_c_input" name="type_c_input" type="hidden" onchange="ClickChange_personal()" style="border-color:#102958;" class="form-control" required>
                <option value="" selected>Select Customer Type</option>
                <option value="Personal">Personal</option>
                <option value="Corporate" >Corporate</option>
            </select>
        </div>
        <!-- <input type="hidden" for="type_c_input"   /> -->

        <div class="col-2 label_left" >
            <input id="status_c_input" name="status_c_input"  class="form-check-input" type="checkbox" value="true" checked>
            <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Active
            </label>
        </div>  
        <div class="col" >
        </div>  

       <!--  <div class="col-sm-2 label_right" >
        </div>
        <div class="col" >
        </div> -->
    </div>  

    <div class="form-group row col-md-10 col-md-offset-1">
        <div class="col-sm-2 label_left" >
            <label style="color: #102958;" ><small><font color="red">*</font></small>Cust. ID:</label>
        </div>
        <div class="col-3">
            <input id="customer_c_input" name="customer_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" value="" required>
            
        </div>
            <div class="col-sm-1 label_left">
                <label style="color: #102958;"  ><small><font color="red">*</font></small>Cust. Level:</label>
            </div>   
            <div class="col">
                <select id="level_c_input" name="level_c_input" style="border-color:#102958;" class="form-control" data-description="<?php echo $result->description;?>" required>
                    <option value="0" selected>Select Cust. Level</option>
                    <?php  foreach($results_c_level as $result){ ?>
                        <option value="<?php echo $result->id; ?>" data-description="<?php echo $result->description; ?>" ><?php echo $result->level_name; ?></option>
                    <? } ?>
                </select>
            </div>

            <div class="col-4 ">
                <input id="customer_de" name="customer_de" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  readOnly> 
            </div>

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


    <div class="form-group row col-md-10 col-md-offset-1">
            <div class="col-sm-2 label_left personal" id="title_c_label" >
                <label  style="color: #102958;" for="staticEmail" >Title:</label>
            </div>
            <div id="title_input" class="col-3 personal"  >
                <select id="title_c_input" name="title_c_input" style="border-color:#102958;"  class="form-control" >
                    <option value="" selected>Select Title</option>
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

            <div class="col-sm-2 label_left corporate" style="margin-top: 0 !important;" >
                    <label id="company_c_label" style="color: #102958;" ><small><font color="red">*</font></small>Company name:</label>
            </div>
            <div class="col corporate" id="company_input"  >
                    <input id="company_c_input" name="company_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  required>
            </div>
  
    </div>

        <div class="form-group row col-md-10 col-md-offset-1 personal">

                <div id="first_c_label" class="col-sm-2 label_left personal" >
                    <label  style="color: #102958;" ><small><font color="red">*</font></small>First name:</label>
                </div>
                <div id="first_input" class="col personal">
                    <input id="first_c_input"  minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  required>
                </div>

                <div id="last_c_label" class="col-sm-2 label_left personal" >
                    <label  style="color: #102958;" >Last name:</label>
                </div>
                <div id="last_input" class="col personal">
                    <input id="last_c_input" name="last_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" >
                </div>
        </div>


        <div class="form-group row col-md-10 col-md-offset-1">    
			<div id="nick_c_label" class="col-sm-2 label_left" >
				<label style="color: #102958;" for="staticEmail" >Nickname:</label>
			</div>
			<div id="nick_input" class="col">
				<input id="nick_c_input" name="nick_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
			</div>
            <div  class="col-sm-2 label_left" >
            </div> 
            <div class="col">
            </div> 
		</div>
		
		<div class="form-group row col-md-10 col-md-offset-1"> 
			<div  class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Tax ID / Passport ID:</label>
            </div>
            <div class="col">
                    <!--<input id="personal_c_input" name="personal_c_input" minlength="13" maxlength="13" style="color: #0C1830;border-color:#102958;" type="text"  class="form-control"  required  pattern="\d{13}">-->
                <input id="personal_c_input" name="personal_c_input" minlength="1" maxlength="13" style="color: #0C1830;border-color:#102958;" type="text"  class="form-control" >
            </div>
			
			<div id="div_personal_e_per" class="col-sm-2 label_left" >
				<label style="color: #102958;" >Email:</label>
			</div> 
			<div id="div_personal_e_cor" hidden="true" class="col-sm-2 label_left" >
				<label style="color: #102958;" >Email:</label>
			</div> 
			<div class="col">
				<input id="email_c_input" name="email_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="email"   class="form-control" >
			</div>

			<div id="div_r_email_label" class="col-sm-2 personal" hidden="true" >
			</div>
			<div id="div_r_email_input" class="col personal" hidden="true" >
			</div>  

		</div>

        <div class="form-group row col-md-10 col-md-offset-1">
                <div id="div_personal" class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Mobile:</label>
                </div>
                <div id="div_corporate" hidden="true" class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Mobile:</label>
                </div>
                <div class="col">
                    <input id="mobile_c_input" name="mobile_c_input" minlength="10" maxlength="12" style="color: #0C1830;border-color:#102958;" type="text"   class="form-control" pattern="\d{3}-\d{3}-\d{4}">
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
                    <input id="tel_c_input" name="tel_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>

                <div  class="col-sm-2 label_left personal" >
                    <label style="color: #102958;" for="staticEmail" >Tel:</label>
                </div>
                <div class="col personal">
                    <input id="tel_c_input2" name="tel_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>

        </div>  

        <div id="div_personal_tel" class="form-group row col-md-10 col-md-offset-1">
                
               
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
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Address No:</label>
                </div>  
                <div class="col">
                    <input id="address_input" name="address_number_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text"   class="form-control"  required>
                </div>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Building Name:</label>
                </div>

                <div class="col">
                    <input id="building_input" name="building_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Soi:</label>
                </div>
                <div class="col">
                    <input id="soi_input" name="soi_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Road:</label>
                </div>
                <div class="col">
                    <input id="road_input" name="road_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>
            </div>      
        
            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left"  >
                    <label for="province" style="color: #102958;" ><small><font color="red">*</font></small>Province:</label>
                </div>
                <div class="col">
                    <select id="province" name="province_id" style="border-color:#102958;" class="remove-example form-control selectpicker" data-live-search="true" required>
                            <div id="row_option" >
                            <option value="" selected>Select Province</option>
                            <?php foreach($results_2 as $result_add){  ?>
                                <option value="<?php echo $result_add->code;?>" ><?php echo $result_add->name_en;?></option>
                            <?php } ?>
                            <div>
                    </select>
                    <!-- </div> -->
                </div>

                <div class="col-sm-2 label_left">
                    <label for="district" style="color: #102958;" ><small><font color="red">*</font></small>District:</label>
                </div>
                <div class="col">
                    <select id="district" name="district_id" style="border-color:#102958;" class="form-control selectpicker" data-live-search="true" required>
                        <option value="0" >Select district</option>
                    </select>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left"  >
                    <label for="sub_district" style="color: #102958;" ><small><font color="red">*</font></small>Sub-district:</label>
                </div>
                <div class="col">
                    <select id="sub_district" name="sub_district_id" style="border-color:#102958;" class="form-control selectpicker" data-live-search="true" required>
                        <option value="0" selected>Select sub-district</option>
                    </select>
                </div>

                <div class="col-sm-2 label_left"  >
                    <label style="color: #102958;" ><small><font color="red">*</font></small>Post Code:</label>
                </div> 
                <div class="col">
                    <select id="postcode" name="postcode_id" style="border-color:#102958;" class="form-control selectpicker" data-live-search="true" required>
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
                <input  id="same_co" name="same_co[]" class="form-check-input" type="checkbox" value="false" onclick="same_customer()" >
                <label  style="color: #0C1830;" class="form-check-label" >
                    &nbsp;&nbsp;&nbsp;&nbsp; Same Customer Name
                </label>
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
                <input id="id_co" name="id_co[]" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  hidden="true">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Title:</label>
                </div>
                <div  class="col-2 label_left">
                     <select id="title_co" name="title_co[]" style="border-color:#102958;" class="form-control" >
                        <option value="" selected>Select Title </option>
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
                <div class="col-sm-2 label_left" >
                </div>
                <div class="col" >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" ><small><font color="red">*</font></small>First name:</label>
                </div>
                <div class="col">
                    <input id="first_co" name="first_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  required>
                </div>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Last name:</label>
                </div>
                <div class="col">
                    <input id="last_co" name="last_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" >
                </div>

            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Nickname:</label>
                </div>
                <div class="col">
                    <input id="nick_co" name="nick_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>

                <div class="col-sm-2 label_left" >
                </div>
                <div class="col">
                </div>    
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Mobile:</label>
                </div>
                <div class="col">
                    <input id="mobile_co" name="mobile_co[]" minlength="10" maxlength="12" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" pattern="\d{3}-\d{3}-\d{4}">
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
                    <input id="tel_co" name="tel_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
				<div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Email:</label>
                </div>
                <div class="col">
                    <input id="email_co" name="email_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="email" class="form-control" >
                </div>
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Line ID:</label>
                </div>
                <div class="col">
                    <input id="line_co" name="line_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" >
                </div>
               <!--  <div class="col-sm-2 label_left" >
                </div>
                <div class="col" class="form-control" >
                </div> -->
            </div>
            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Position:</label>
                </div>
                <div class="col">
                    <input id="position_co" name="position_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" >
                </div>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Department:</label>
                </div>
                <div class="col" class="form-control" >
                    <input id="department" name="department[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" >
                </div>
                
                
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Remark:</label>
                </div>
                <div class="col " class="form-control" >
                    <textarea id="remark_co" name="remark_co[]" minlength="1"  style="color: #0C1830;border-color:#102958;" rows="2" class="form-control"  ></textarea>
                </div>
            </div> 

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    </div> 
                <div class="col" >
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
                    <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                    </button>
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

<?php include('includes_php/add_insurance.php');?>
<?php include('includes_php/add_contact.php');?>
<?php include('includes_php/popup_table_customer.php');?>
<?php include('includes_php/popup_add_product.php');?>
<?php include('includes_php/popup_reason.php');?>
<?php include('includes_php/popup_renew.php');?>
<!------------------------------------------------------------------------------>

   

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

 </div>
 	<?php include('includes/footer.php');?>
</body>



</html>
<?php } ?>

 <script type="text/javascript">
        var insurance_com_object = $('#insurance_com');
        var currency_object = $('#currency');
        var product_object = $('#product_name');
        var agent_name = $('#agent_name');
        var partner_currency="";
        var partner_currency_value="";

        var selectedOptions = Array.from(document.getElementById("popup_product").selectedOptions);
        var product_object_popup = $('#popup_product');
        var productsArray = [];

        insurance_com_object.on('change', function(){
            var currency_id = $(this).val();
            partner_currency="";
         	partner_currency_value="";
            $.get('get_currency_list.php?id=' + currency_id, function(data){
                var result = JSON.parse(data);
                $.each(result, function(index, item){
                    document.getElementById("currency_id").value = item.id;
                    document.getElementById("currency").value = item.currency;
                    partner_currency = item.currency_value;
                    partner_currency_value = item.currency_value_convert;
                    document.getElementById("premium_rate").value = '';
                    document.getElementById("convertion_value").value = '';
                });
            });

            product_object.html('');
            $.get('get_product.php?id=' + currency_id,function(data){
                var result = JSON.parse(data);
                product_object.append($('<option></option>').val("").html("Select Product Name"));
                document.getElementById("product_cat").value = "";
        		document.getElementById("sub_cat").value = "";
                $.each(result, function(index, item){
                    product_object.append(
                    $('<option></option>').val(item.id).html(item.product_name));
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
       
<div id="loading-overlay">
    <img src="loading.gif" alt="Loading...">
</div>  

<script type="text/javascript">
    $('.corporate').hide();
    $('.personal').show();
</script>