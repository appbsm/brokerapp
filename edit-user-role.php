<?php
	
	include('includes/config.php');
	session_start();
	error_reporting(0);
	include('includes/config_path.php');
	if(strlen($_SESSION['alogin'])==""){  
		$dbh = null;
		header("Location: index.php"); 
	}
		else{

			if(isset($_POST['back'])){
				$dbh = null;
				header("Location: manage-user.php"); 
			}

	if(isset($_POST['submit']) && $_GET['id'] != ""){

	$name_title=$_POST['name_title'];
	$first_name=$_POST['first_name']; 
	$last_name=$_POST['last_name'];
	$nick_name=$_POST['nick_name'];

	$username=$_POST['username'];
	$password=$_POST['password'];
	$password_old=$_POST['password_old'];
	$id_role=$_POST['id_role'];
	$active=$_POST['active'];
	$position=$_POST['position'];

	$mobile=$_POST['mobile'];
	$tel=$_POST['tel'];
	$email=$_POST['email'];
	$department=$_POST['department'];

	$sql_file_colume="";
	$sql_file_insert="";
	$new_file_name="";

	// echo '<script>alert("id_role: '.$id_role.'")</script>'; 
	if(is_null($active)){
		 $active=0;
	}

	if($_FILES['file']['name']!=""){
			try {
				$file = $_FILES['file']['name'];
				$file_loc = $_FILES['file']['tmp_name'];
				// $image=$_POST['file_d'];
				$folder=$sourceFilePath;
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				$new_file_name = uniqid().".".$ext;
				$path_file = $folder."/".$new_file_name;
				$final_file = str_replace(' ','-',$new_file_name);
				move_uploaded_file($file_loc,$folder.$final_file);
			}catch(Exception $e) {
			}
			$sql_file_insert.=",file_name=:file_name_p,file_name_uniqid=:file_name_uniqid_p";
	}

	$sql="update user_info set name_title=:name_title_p,username=:username_p,password=:password_p,password_decode=:password_decode_p,role_name_id=:id_role_p,status=:status_p
		,first_name=:first_name_p,last_name=:last_name_p,nick_name=:nick_name_p,status_delete=:status_delete_p
		,udate=GETDATE(),modify_by=:modify_by_p,position=:position_p,mobile=:mobile_p,tel=:tel_p,email=:email_p,department=:department_p".$sql_file_insert." where id=:id";

	$query = $dbh->prepare($sql);
	$query->bindParam(':name_title_p',$name_title,PDO::PARAM_STR);
	$query->bindParam(':first_name_p',$first_name,PDO::PARAM_STR);
	$query->bindParam(':last_name_p',$last_name,PDO::PARAM_STR);
	$query->bindParam(':nick_name_p',$nick_name,PDO::PARAM_STR);
	$query->bindParam(':username_p',$username,PDO::PARAM_STR);

	// if($password==$password_old){
	// 	$query->bindParam(':password_p',$password,PDO::PARAM_STR);
	// }else{
		$query->bindParam(':password_p',md5($password),PDO::PARAM_STR);
		$query->bindParam(':password_decode_p',$password,PDO::PARAM_STR);
	// }

	$query->bindParam(':id_role_p',$id_role,PDO::PARAM_STR);

	if($active==""){
		$active="0";
	}else{
		$active="1";
	}
	$query->bindParam(':status_p',$active,PDO::PARAM_STR);
	$status_delete = 0;
	$query->bindParam(':status_delete_p',$status_delete,PDO::PARAM_STR);
	$query->bindParam(':modify_by_p',$_SESSION['id'],PDO::PARAM_STR);
	$query->bindParam(':position_p',$position,PDO::PARAM_STR);
	$query->bindParam(':mobile_p',$mobile,PDO::PARAM_STR);
	$query->bindParam(':tel_p',$tel,PDO::PARAM_STR);
	$query->bindParam(':email_p',$email,PDO::PARAM_STR);
	$query->bindParam(':department_p',$department,PDO::PARAM_STR);

	if($_FILES['file']['name']!=""){
		$query->bindParam(':file_name_p',$_FILES['file']['name'],PDO::PARAM_STR);
		$query->bindParam(':file_name_uniqid_p',$new_file_name,PDO::PARAM_STR);
	}

	$query->bindParam(':id',$_GET['id'],PDO::PARAM_STR);
	$query->execute();
	// print_r($query->errorInfo());
	$lastInsertId = 1;

	if($lastInsertId){

		// echo '<script>alert("Successfully edited information.")</script>';
		// echo "<script>window.location.href ='manage-user.php'</script>";
		$msg="Class Created successfully";
		$name_title="";
		$first_name=""; 
		$last_name="";
		$nick_name="";

		$username="";
		$password="";
		$position="";
		$active=1;

	}else{
		$error="Something went wrong. Please try again";
	}

	}else{
		$active=1;
		// $id_role=3;
		$name_title="Mr.";
	}

	if($_GET['id']){
		$sql_user = " SELECT * from user_info WHERE status_delete = 0 and id=".$_GET['id'];
		$query_user = $dbh->prepare($sql_user);
		$query_user->execute();
		$results_user = $query_user->fetchAll(PDO::FETCH_OBJ);
		foreach($results_user as $result){ 
			$name_title = $result->name_title;
			$first_name = $result->first_name;
			$last_name  = $result->last_name;
			$nick_name  = $result->nick_name;
			$username   = $result->username;
			$password   = $result->password;
			$password_decode= $result->password_decode;

			$id_role    = $result->role_name_id;
			$status     = $result->password;
			$active     = $result->status;
			$position   = $result->position;

			$mobile     = $result->mobile;
			$email      = $result->email;
			$department = $result->department;
			$path_file  = $result->file_name_uniqid;
			$path_file_show  = $result->file_name;
			$tel = $result->tel;
		}
		
	}

	$company_code ='';
	$sql = "SELECT TOP(1) * FROM company_list order BY id desc ";
	$query = $dbh->prepare($sql);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	if(count($results)>0){
	 	foreach($results as $result){
	 		 $company_code =  $result->company_code;
	 	}
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

   

</head>

 <style>
    .btn-file {
		position: relative;
		overflow: hidden;
	}

	.btn-file input[type=file] {
		position: absolute;
		top: 0;
		right: 0;
		min-width: 100%;
		min-height: 100%;
		font-size: 100px;
		text-align: right;
		filter: alpha(opacity=0);
		opacity: 0;
		outline: none;
		background: white;
		cursor: inherit;
		display: block;
	}
	.input-group {
		margin-bottom: 30px;
	}

	#img-upload{
		width: 200px;
		height: 128px;
	}

	.as-console-wrapper {
		display: none !important;
	}

	h1, h2, h3, h4, h5, h6, b, span, p, table, a, div, label, ul, li, div,
	button {
		font-family: Manrope, 'IBM Plex Sans Thai';
	}
	
	.field-icon {
        position: absolute;
        right: 15px;
        top: calc(50% - 12px);
        cursor: pointer;
    }
</style>

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
						<li class="active"><a href="manage-user.php">User Management</a></li>
						<li class="active">Edit User</li>
					</ul>
				</div>
			</div>
		</div>

		<?php if($msg){ ?>
		<div class="alert alert-success left-icon-alert" role="alert">
			<strong>Well done!</strong><?php echo htmlentities($msg); ?>
		</div>
		<?php }else if($error){?>
		<div class="alert alert-danger left-icon-alert" role="alert">
			<strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
		</div>
		<?php } ?>

		<section class="section">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="panel">
							<div class="panel-heading">
								<div class="form-group row col-md-10 col-md-offset-1">
									<div class="col">
										<div class="panel-title" style="color: #102958;" >
											<h2 class="title">Edit User</h2>
										</div>
									</div>
									<div class="col-sm-2 ">
									</div>
									<div class="col-sm-4 text-right ">
									</div>&nbsp;&nbsp;
								</div>
							</div> 

							<div class="panel-body">
								<form method="post" enctype="multipart/form-data" onSubmit="return valid();">
									<div class="form-group row col-md-10 col-md-offset-1">
											<input hidden="true" id="id" name="id" type="text" value="<?php echo $id; ?>" >
										<div class="col-sm-2  label_left" >
											<label style="color: #102958;" for="success" class="control-label">Title:</label>
										</div> 
										<div  class="col-2">
											<select id="name_title" name="name_title" style="border-color:#102958; color: #000;" class="form-control personal"  >
											<option value="Mr." <?php echo ($name_title=="Mr.") ? 'selected' : '';?>>Mr.</option>
											<option value="Ms." <?php echo ($name_title=="Ms.") ? 'selected' : '';?>>Ms.</option>
											<option value="Mrs." <?php echo ($name_title=="Mrs.") ? 'selected' : '';?>>Mrs.</option>
											</select>    
										</div>										
									</div>
									
									<div class="form-group row col-md-10 col-md-offset-1">
										<div class="col-sm-2  label_left" >
											<label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>First name:</label>
										</div> 
										<div class="col ">
											 <input id="first_name" name="first_name" minlength="1" maxlength="50" style="border-color:#102958; color: #000;" type="text" class="form-control" value="<?php echo $first_name; ?>" >
										</div>
										<div class="col-sm-2  label_left" >
											<label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Last name:</label>
										</div> 
										<div class="col ">
											 <input id="last_name" name="last_name" minlength="1" maxlength="50" style="border-color:#102958; color: #000;" type="text" class="form-control" value="<?php echo $last_name; ?>" >
										</div>
									</div>

									<div class="form-group row col-md-10 col-md-offset-1">
										<div class="col-sm-2  label_left" >
											<label style="color: #102958;" for="success" class="control-label">Nickname:</label>
										</div> 
										<div class="col ">
											 <input name="nick_name" id="nick_name" minlength="1" maxlength="50" style="border-color:#102958; color: #000;" type="text" class="form-control" value="<?php echo $nick_name; ?>" >
										</div>
										<div class="col-sm-2  label_right" >
											<label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Email:</label>
										</div> 
										<div class="col ">
											 <input id="email" name="email" minlength="1" maxlength="50" style="border-color:#102958; color: #000;" type="text" class="form-control" value="<?php echo $email; ?>" >
										</div>
									</div>
									
									<div class="form-group row col-md-10 col-md-offset-1">
										<div class="col-sm-2  label_right" >
											<label style="color: #102958;" for="success" class="control-label">Mobile:</label>
										</div> 
										<div class="col ">
											 <input id="mobile" name="mobile" minlength="1" maxlength="50" style="border-color:#102958; color: #000;" type="text" class="form-control" value="<?php echo $mobile; ?>" >
										</div>
										<div class="col-sm-2  label_left" >
											<label style="color: #102958;" for="success" class="control-label">Tel:</label>
										</div> 
										<div class="col ">
											<input name="tel" id="tel" minlength="1" maxlength="50" style="border-color:#102958; color: #000;" type="text" class="form-control" value="<?php echo $tel; ?>">
										</div>
									</div>

									<div class="form-group row col-md-10 col-md-offset-1">
										<div class="col-sm-2  label_right" >
											<label style="color: #102958;" for="success" class="control-label">Position:</label>
										</div> 
										<div class="col ">
											 <input id="position" name="position" minlength="1" maxlength="50" style="border-color:#102958; color: #000;" type="text" class="form-control" value="<?php echo $position; ?>" >
										</div>
										<div class="col-sm-2  label_right" >
											<label style="color: #102958;" for="success" class="control-label">Department:</label>
										</div> 
										<div class="col ">
											 <input name="department" id="department" minlength="1" maxlength="50" style="border-color:#102958; color: #000;" type="text" class="form-control" value="<?php echo $department; ?>" >
										</div>
									</div>

									<div class="form-group row col-md-10 col-md-offset-1">
										<div class="col">
											<div class="panel-title" style="color: #102958;" >
												<br>
												<h2 class="title">User ID</h2>
											</div>
										</div>
									</div>

									
									<div class="form-group row col-md-10 col-md-offset-1">
										<div class="col-sm-2  label_left" >
											<label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Role User:</label>
										</div> 
										<div class="col ">
											<select style="border-color:#102958; color: #000;" id="id_role" name="id_role" class="form-control" >
												<?php $sql = "SELECT * from role_name where status=1 ";
													if($_SESSION["system_admin"]!=1){
														$sql = $sql." AND system_admin is null ";
													}
													$query = $dbh->prepare($sql);
													$query->execute();
													$results=$query->fetchAll(PDO::FETCH_OBJ);
													if($query->rowCount() > 0){
														foreach($results as $result)
													{   
												?>
												<?php if($result->id==$id_role){ ?>
													<option value="<?php echo $result->id; ?>" selected><?php echo $result->role_name; ?>&nbsp
												<?php }else{ ?>
													<option value="<?php echo $result->id; ?>" ><?php echo $result->role_name; ?>&nbsp
												<?php } ?>
												<?php }} ?>
											</select>
										</div>
										<div class="col-sm-2  label_left" >
													
										</div>
										<div class="col ">
											<div class="form-group has-success">
												<div class="">
													<input  name="active" data-size="medium"  id="active" value="1" class="form-check-input" type="checkbox" id="flexCheckDefault" <?php if($active==1){ ?>
												checked
													<?php } ?>
												>
													<label style="color: #102958;" for="success" class="control-label">&nbsp;&nbsp;&nbsp;&nbsp; Active</label>
												</div>
											</div>
										</div>
									</div>

									<div class="form-group row col-md-10 col-md-offset-1">
										<div class="col-sm-2  label_left" >
											<label style="color: #102958;" for="success" class="control-label">Code Company:</label>
										</div> 
										<div class="col ">
											 <input id="username" name="username" minlength="1" maxlength="50" style="border-color:#102958;" type="text" class="form-control" value="<?php echo $company_code;
											 //$username; ?>" readonly>
										</div>
										<div class="col ">
										</div>
										<div class="col-sm-2  label_left" >
										</div> 
									</div>

									<div class="form-group row col-md-10 col-md-offset-1">
										<div class="col-sm-2  label_left" >
											<label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Username:</label>
										</div> 
										<div class="col ">
											 <input id="username" name="username" minlength="1" maxlength="50" style="border-color:#102958; color: #000;" type="text" class="form-control" value="<?php echo $username; ?>" >
										</div> 
										<div class="col-sm-2  label_right" >
											<label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Password:</label>
										</div> 
										<!--
										<div class="col ">
											<input minlength="4" maxlength="12" style="border-color:#102958; color: #000;" type="password" name="password_old" class="form-control" required="required" id="success" value="<?php echo $password; ?>" hidden="true" >
											<input minlength="4" maxlength="12" style="border-color:#102958;" type="password" name="password" class="form-control" required="required" id="success" value="<?php echo $password; ?>">
											<span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
										</div>
										<script>
											document.querySelectorAll('.toggle-password').forEach(function(icon) {
												icon.addEventListener('click', function() {
													var target = document.querySelector(this.getAttribute('toggle'));
													if (target.type === 'password') {
														target.type = 'text';
														this.classList.remove('fa-eye-slash');
														this.classList.add('fa-eye');
													} else {
														target.type = 'password';
														this.classList.remove('fa-eye');
														this.classList.add('fa-eye-slash');
													}
												});
											});

											function valid() {
												var password = document.getElementById("password").value;
												// ตรวจสอบรหัสผ่านตามเงื่อนไข
												var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

												if (!regex.test(password)) {
													alert("Password must contain at least one lowercase letter, one uppercase letter, one numeric digit, one special character, and be at least 8 characters long.");
													return false;
												}

												var confirmPassword = document.forms["chngpwd"]["confirmpassword"].value;
												if (password !== confirmPassword) {
													alert("Your Password do not match.");
													return false;
												}
											}
										</script>
										-->
<div class="col ">
    <input minlength="4" maxlength="12" style="border-color:#102958; color: #000;" type="password" name="password_old" class="form-control" required="required" id="success" value="<?php echo $password_decode; ?>" hidden="true" >
    
    <input minlength="4" maxlength="12" style="border-color:#102958;" type="password" name="password" class="form-control" required="required" id="password" value="<?php echo $password_decode; ?>">
    <span toggle="#password" class="fa fa-fw  field-icon toggle-password" onclick="togglePassword()"></span>
    <!-- fa-eye-slash -->
</div>
<script>
    function togglePassword() {
        var passwordInput = document.getElementById("password");
        var icon = document.querySelector('.toggle-password');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }

    function valid() {
        var password = document.getElementById("password").value;
        // ตรวจสอบรหัสผ่านตามเงื่อนไข
        var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        if (!regex.test(password)) {
        //     alert("Password must contain at least one lowercase letter, one uppercase letter, one numeric digit, one special character, and be at least 8 characters long.");
            var text = "Your password is not strong, please using the following criteria:\n"+
				"1.The password must have a minimum of 8 characters.\n"+
				"2.It must include at least 1 uppercase letter.\n"+
				"3.It must include at least 1 lowercase letter.\n"+
				"4.It must include at least 1 digit.\n"+
				"5.It must include at least 1 special character (e.g., @, !, #, $).";
			alert(text);
            return false;
        }
        	var confirmPassword = document.forms["chngpwd"]["confirmpassword"].value;
	        if (password !== confirmPassword) {
	            alert("Your Password do not match.");
	            return false;
	        }
        

        
    }
</script>

									</div>

									

									<div class="form-group row col-md-10 col-md-offset-1">
										<div class="col">
											<div class="panel-title" style="color: #102958;" >
												<br>
												<h2 class="title">Profile Image</h2>
											</div>
										</div>
									</div>

									<div class="form-group row col-md-10 col-md-offset-1">
										<!-- File Size width:994 height:634 -->
										<!-- <label style="color: #102958;" class="col-sm-12" >Upload Profile Image </label> -->
										<div class="col-sm-6">
										<div class="input-group">
											<span  class="input-group-btn">
												<span style="color: #F9FAFA;background-color: #102958;" class="btn btn-default btn-file ">
													Browse… 
													<input name="file" id="imgInp" type="file" src="<?php echo "image.php?filename=".trim($path_file) ?>"  accept="image/png, image/jpg, image/jpeg" >
												</span>
											</span>
											<input style="color: #102958;border-color:#102958;" type="text" name="img" id="img_label" class="form-control" src="" value="<?php echo trim($path_file_show); ?>" readonly>
										</div>
										</div>

										<!-- <div class="col-sm-6"></div> -->
										 <?php if(trim($path_file)!=""){ ?>
										<div class="col-sm-12">
										<img  <?php //if(isset($path_file)){ ?> src="<?php echo "image.php?filename=".trim($path_file); ?>" <?php //} ?> id='img-upload'/>
												<!-- <img src="<?php //echo "upload/65fa4319e2a1a.jpg"; ?>" id='img-upload'/> -->
										</div>
										 <?php } ?>
									</div> 
									<script>
										$(document).ready(function () {
											function readURL(input) {
												var fileName = input.value;
												var idxDot = fileName.lastIndexOf(".") + 1;
												var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
												if (extFile == "jpg" || extFile == "jpeg" || extFile == "png") {
													var fileSize = input.files[0].size; // in bytes
													if (fileSize > 800 * 1024) {
														alert("File size exceeds 800kb. Please choose a file smaller than 800kb.");
														input.value = null;
														document.getElementById("img-upload").hidden = true;
														$('#img-upload').attr('src', null);
														return;
													}
													if (input.files && input.files[0]) {

														var reader = new FileReader();
														reader.onload = function (e) {
															$('#img-upload').attr('src', e.target.result);
														}
														reader.readAsDataURL(input.files[0]);

													}
												} else {
													input.value = null;
													$('#img-upload').attr('src', null);
													alert("Only jpg and png files are allowed!");
												}
											}

											$("#imgInp").change(function () {
												readURL(this);
											});
										});
									</script>

									<div class="form-group row col-md-10 col-md-offset-1">
										<div class="col-md-10">
											<button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
											</button>
											&nbsp;&nbsp;
											<a href="manage-user.php" class="btn btn-primary" style="background-color: #0275d8;color: #F9FAFA;" >
												<span class="text">Cancel</span>
											</a>
										</div>
									</div>
								</form>  
							</div>
						</div>
					</div>
					<!-- /.col-md-8 col-md-offset-2 -->

					<!-- </div> <div class="col-md-12 "> --> 
				</div><!-- /.row -->
				</div>
			</div>
			<!-- /.container-fluid -->
		</section>

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
                $('#example').DataTable();

                $('#example2').DataTable( {
                    "scrollY":        "300px",
                    "scrollCollapse": true,
                    "paging":         false
                } );

                $('#example3').DataTable();
            });
        </script>

        <script>
            $(document).ready( function() {
        $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {
            
            var input = $(this).parents('.input-group').find(':text'),
                log = label;
            
            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }
        
        });

        function readURL(input) {
            var fileName = document.getElementById("imgInp").value;
            var idxDot = fileName.lastIndexOf(".") + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();

            if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            // document.getElementById("img-upload").hidden = false;
            if (input.files && input.files[0]) {
                                ////////////////////////
                                $.ajax({
                                    url: 'check_folder_size_json.php',
                                    type: 'GET',
                                    success: function(response) {
                                        data = JSON.parse(response);
                                        if (data.alert) {
                                            var message = "The folder at " + data.folderPath + " is nearly full. Remaining space: " + data.remainingSizeGB + " GB.";
                                            alert(message);
                                            document.getElementById('imgInp').value = "";
                                            document.getElementById('img_label').value = "";
                                            document.getElementById("img-upload").hidden = true;
                                            $('#img-upload').attr('src', null);
                                        }else{
                                            var reader = new FileReader();
                                            reader.onload = function (e) {
                                                $('#img-upload').attr('src', e.target.result);
                                            }
                                            reader.readAsDataURL(input.files[0]);
                                            document.getElementById("img-upload").hidden = false;
                                        }
                                    }
                                });
                                ///////////////////////
            }
            }else{
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img-upload').attr('src',null);
                }
                reader.readAsDataURL(input.files[0]);
                document.getElementById("imgInp").value=null;
                document.getElementById("img-upload").hidden = true;
                alert("Only jpg and png files are allowed!");
            }  
        }
        $("#imgInp").change(function(){
            readURL(this);
            });     
        });

        </script>
        
    <?php include('includes/footer.php'); ?>
</body>

</html>
<?php } ?>

<div id="loading-overlay">
    <img src="loading.gif" alt="Loading...">
</div>

<?php $dbh = null; ?>