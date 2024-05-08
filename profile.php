<?php
session_start();
error_reporting(0);
include_once('includes/connect_sql.php');
include_once('includes/fx_profile.php');

if(strlen($_SESSION['alogin'])=="") {
    header("Location: index.php"); 
}

// if(isset($_POST['submit']) || isset($_POST['save'])){
//     $type=$_POST['type'];
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)) {

        // $password=$_POST['password'];
        $newpassword=$_POST['newpassword'];
        $confirmpassword=$_POST['confirmpassword'];

        // $password=md5($_POST['password']);
        // $newpassword=md5($_POST['newpassword']);
        // $confirmpassword=md5($_POST['confirmpassword']);
        if($newpassword=="" && $confirmpassword==""){
            update_userinfo($conn,$_POST,$sourceFilePath);
            $msg="Your successfully changed";
        }else if($newpassword!="" && $confirmpassword!=""){
            if($newpassword==$confirmpassword){
            // $user_old = get_userinfo_old($conn,$_SESSION['alogin'],$_POST['password']);
            // if(count($user_old)>0){
                update_userinfo($conn,$_POST);
                $msg="Your successfully changed";
            // }else{
            //     $error="Your current password is wrong";
            // }
            }else{
                $error="Your new password and confirm password do not match.";
            }
        }else{
            $error="Incomplete power information was entered in all fields.";
        }
        
    }
}

$user_info = get_userinfo($conn,$_SESSION['alogin'],$_SESSION['pass']);

if(count($user_info)>0){
    foreach ($user_info as $data) {
        // echo '<script>alert("lastInsertId: '.$data['username'].'")</script>'; 
        $id = $data['id'];
        $name_title = $data['name_title'];
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $nick_name = $data['nick_name'];

        $mobile = $data['mobile'];
        $email = $data['email'];
        $position = $data['position'];
        $department = $data['department'];

        $username = $data['username'];
        $password = $data['password'];
        $path_file = $data['file_name_uniqid'];
        $path_file_name = $data['file_name'];

        $role_name = $data['role_name'];
        
    }
}else{
    // header("Location: index.php");  
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

			/*@media (min-width: 1340px){*/
			#img-upload{
			/*    width: 250px;*/

			}
			/*}*/
			/*    height: 128px;*/
			.as-console-wrapper {
			display: none !important;
			}
        </style>

</head>

<body id="page-top" >

    <!-- Page Wrapper -->
    <div id="wrapper" >
        <?php include('includes/leftbar2.php');?>   
        <?php include('includes/topbar2.php');?>  

<div class="container-fluid mb-4" >
    <div class="row breadcrumb-div" style="background-color:#ffffff">
        <div class="col-lg-6" >
            <ul class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="active">Profile</li>
            </ul>
        </div>
    </div>
</div>

<?php if($msg){?>
    <!-- <div class="form-group row col-lg-10 col-lg-offset-1"> -->
    <div class="alert alert-success left-icon-alert" role="alert">
        <strong>Well done!</strong><?php echo htmlentities($msg); ?>
    </div><?php }else if($error){?>

    <div class="alert alert-danger left-icon-alert" role="alert">
        <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
    </div>
    <!-- </div> -->
<?php } ?>

<form method="post" action="profile.php" enctype="multipart/form-data" onSubmit="return valid();">
<div class="container-fluid">
<div class="row">
    <div class="col-lg-6 ">
        <div class="panel">

                <!-- <div class="panel-heading"> -->
                    <br>
                    <div class="form-group row col-lg-12 text-center">
                        <div class="col-lg-12">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Profile image</h2>
                            </div>
                        </div>
                        <!-- <div class="col-sm-2 ">
                        </div>
                        <div class="col-sm-4 text-right ">
                        </div>&nbsp;&nbsp; -->
                    </div>
                <!-- </div>  -->

			<div class="panel-body">
				<script type="text/javascript">
					function checkFileSize() {
						var fileInput = document.getElementById('imgInp');
						var fileSize = fileInput.files[0].size; // ขนาดของไฟล์ใน bytes
						var maxSize = 800 * 1024; // ขนาดสูงสุดที่อนุญาตให้อัพโหลดเป็น bytes (800kb)

						if (fileSize > maxSize) {
							alert('File size exceeds 800kb. Please choose a file smaller than 800kb.');
							// ล้างค่าไฟล์ที่เลือก
							document.getElementById('imgInp').value = "";
						}
					}
				</script>

				<div class="form-group row col-lg-12">
					<!-- File Size width:994 height:634 -->
					<label style="color: #102958;" class="col-sm-12">Upload Profile Image</label>
					<div class="col-sm-12">
						<div class="input-group">
							<span class="input-group-btn">
								<span style="color: #F9FAFA;background-color: #102958;" class="btn btn-default btn-file">
									Browse…
									<input name="file" id="imgInp" type="file" onchange="checkFileSize()" accept="image/png, image/jpg, image/jpeg">
								</span>
							</span>
							<input style="color: #102958;border-color:#102958;" type="text" name="img" class="form-control" src="" value="<?php echo trim($path_file_name); ?>" readonly>
						</div>
					</div>
					<?php if (trim($path_file) != "") { ?>
						<div class="col-sm-12 text-center">
							<img <?php //if(isset($path_file)){ ?> width="75%" src="image.php?filename=<?php echo trim($path_file); ?>" <?php //} ?> id='img-upload' />
						</div>
					<?php } ?>
				</div>

            </div>
        </div>
    </div>

    <div class="col-lg-6 ">
        <div class="panel">
            <br>
            
                <!-- <div class="panel-heading"> -->
                    <div class="form-group row col-lg-10 col-lg-offset-1" >
                        <div class="col-lg-12 text-center">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Profile User</h2>
                            </div>
                        </div>
                    </div>
                <!-- </div>  -->

            <div class="panel-body">
                <div class="form-group row col-lg-10 col-lg-offset-1" >
                    <input hidden="true" id="id" name="id" type="text" value="<?php echo $id; ?>" >
                    <div class="col-sm-4  label_left" >
                        <label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Title Name:</label>
                    </div> 
                    <div  class="col">
                        <select id="title_name" name="title_name" required="required" style="border-color:#102958;" class="form-control personal" required  >
							<option value="Mr." <?php echo ($name_title=="Mr.") ? 'selected' : '';?>>Mr.</option>
							<option value="Ms." <?php echo ($name_title=="Ms.") ? 'selected' : '';?>>Ms.</option>
							<option value="Mrs." <?php echo ($name_title=="Mrs.") ? 'selected' : '';?>>Mrs.</option>
                        </select>    
                    </div>
                </div>
                <div class="form-group row col-lg-10 col-lg-offset-1" >
                    <div class="col-sm-4  label_left" >
                        <label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>First name:</label>
                    </div> 
                    <div class="col ">
                         <input id="first_name" name="first_name" minlength="1" maxlength="50" style="border-color:#102958;" type="text" class="form-control" value="<?php echo $first_name; ?>" required >
                    </div> 
                </div>
                <div class="form-group row col-lg-10 col-lg-offset-1" >
                     <div class="col-sm-4  label_left" >
                        <label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Last name:</label>
                    </div> 
                    <div class="col ">
                         <input id="last_name" name="last_name" minlength="1" maxlength="50" style="border-color:#102958;" type="text" class="form-control" value="<?php echo $last_name; ?>" required >
                    </div>
                </div>
				<div class="form-group row col-lg-10 col-lg-offset-1" >
                    <div class="col-sm-4  label_left" >
                        <label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Nickname:</label>
                    </div> 
                    <div class="col ">
                         <input name="nick_name" id="nick_name" minlength="1" maxlength="50" style="border-color:#102958;" type="text" class="form-control" value="<?php echo $nick_name; ?>" required >
                    </div>
                </div>
				<div class="form-group row col-lg-10 col-lg-offset-1" >
                    <div class="col-sm-4  label_left" >
                        <label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Email:</label>
                    </div> 
                    <div class="col ">
                         <input id="email" name="email" minlength="1" maxlength="50" style="border-color:#102958;" type="email" class="form-control" value="<?php echo $email; ?>" required >
                    </div>
                </div>
				<div class="form-group row col-lg-10 col-lg-offset-1" >
                     <div class="col-sm-4  label_left" >
                        <label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Mobile:</label>
                    </div> 
                    <div class="col ">
                         <input id="mobile" name="mobile" minlength="10" maxlength="12" style="border-color:#102958;" type="text" class="form-control" value="<?php echo $mobile; ?>" pattern="\d{3}-\d{3}-\d{4}" required>

                    </div> 

                    <script>
                    document.getElementById('mobile').addEventListener('input', function (e) {
                        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                        e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
                    });
                    </script>

                </div>
                <div class="form-group row col-lg-10 col-lg-offset-1" >
                     <div class="col-sm-4  label_left" >
                        <label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Position:</label>
                    </div> 
                    <div class="col ">
                         <input id="position" name="position" minlength="1" maxlength="50" style="border-color:#102958;" type="text" class="form-control" value="<?php echo $position; ?>" required >
                    </div>
                </div>
                
                <div class="form-group row col-lg-10 col-lg-offset-1" >
                    <div class="col-sm-4  label_left" >
                        <label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Department:</label>
                    </div> 
                    <div class="col ">
                         <input name="department" id="department" minlength="1" maxlength="50" style="border-color:#102958;" type="text" class="form-control" value="<?php echo $department; ?>" required >
                    </div>
                </div>

                <div class="form-group row col-lg-10 col-lg-offset-1" >
                    <div class="col-lg-12 text-center">
                        <div class="panel-title" style="color: #102958;" >
                            <br>
                            <h2 class="title">User ID</h2>
                        </div>
                    </div>
                </div>

                <div class="form-group row col-lg-10 col-lg-offset-1" >
                     <div class="col-sm-4  label_left" >
                        <label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Role name:</label>
                    </div> 
                    <div class="col ">
                         <input id="role_name" name="role_name" minlength="1" maxlength="50" style="border-color:#102958;" type="text" class="form-control" value="<?php echo $role_name; ?>" readOnly required>
                    </div>
                </div>

                <div class="form-group row col-lg-10 col-lg-offset-1" >
                     <div class="col-sm-4  label_left" >
                        <label style="color: #102958;" for="success" class="control-label" ><small><font color="red">*</font></small>Username:</label>
                    </div> 
                    <div class="col ">
                         <input id="username" name="username" minlength="4" maxlength="20" style="border-color:#102958;" type="text" class="form-control" value="<?php echo $username; ?>" required>
                    </div>
                </div>
                <div class="form-group row col-lg-10 col-lg-offset-1" >
                    <div class="col-sm-4  label_left" >
                        <label style="color: #102958;" for="success" class="control-label">New Password:</label>
                    </div> 
                    <div class="col ">
                         <input name="newpassword" minlength="4" maxlength="20" style="border-color:#102958;" type="password" class="form-control" value="<?php echo $period; ?>" >
                    </div>
                </div>
                <div class="form-group row col-lg-10 col-lg-offset-1" >
                     <div class="col-sm-4  label_left" >
                        <label style="color: #102958;" for="success" class="control-label">Confirm Password:</label>
                    </div> 
                    <div class="col ">
                         <input name="confirmpassword" minlength="4" maxlength="20" style="border-color:#102958;" type="password" class="form-control" value="<?php echo $period; ?>" >
                    </div>
                </div> 

                <div class="form-group row col-lg-12">
                    <div class="col-lg-12 text-center">
                        <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                        </button>
                         &nbsp;&nbsp;
                        <a href="Dashboard.php" class="btn btn-primary" style="background-color: #0275d8;color: #F9FAFA;" >
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

            $.ajax({
                url: 'check_folder_size_json.php', // Path to your server-side script
                type: 'GET',
                success: function(response) {
                    data = JSON.parse(response);

                    if (data.alert) {
                        var message = "The folder at " + data.folderPath + " is nearly full. Remaining space: " + data.remainingSizeGB + " GB.";
                        alert(message);
                    }else{
                        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
                            document.getElementById("img-upload").hidden = false;
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    $('#img-upload').attr('src', e.target.result);
                                }
                                reader.readAsDataURL(input.files[0]);
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
                }
            });

        }
        $("#imgInp").change(function(){
            readURL(this);
            });     
        });

        </script>

        <style>
            @media (min-width: 1340px){
                .label_left{
                    max-width: 130px;
                }
                .label_right{
                    max-width: 130px;
                }
            }
        </style>
    
    <?php include('includes/footer.php');?>
</body>

</html>



<div id="loading-overlay">
    <img src="loading.gif" alt="Loading...">
</div>

