
<?php
	session_start();
	error_reporting(0);

	include('includes/config_company.php');

	// include('includes/config.php');
	// if($_SESSION['alogin']!=''){
	// $_SESSION['alogin']='';
	// }


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Broker Install Direct</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" > <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>
	<style>
		h1, h2, h3, h4, h5, h6, b, span, p, table, a, div, label, ul, li,
		button {
			font-family: Manrope, 'IBM Plex Sans Thai';
		}
		
		.my-confirm-button {
            background-color: #0275d8 !important; /* สีพื้นหลังของปุ่มยืนยัน */
            color: white !important; /* สีข้อความของปุ่มยืนยัน */
        }
		
		/* Default for larger screens */
        .control-label {
            text-align: left;
        }

        /* Center text for small screens */
/*        575.98*/
        @media (max-width: 991px) {
            
            .control-label {
                text-align: center;
            }
        }
		
	
		.container {
			width: 100%;
			border-radius: 10px;
		 
		}

		h1 {
			text-align: center;
			margin-bottom: 20px;
		}

		label {
			display: block;
			margin-bottom: 5px;
		}

		input[type="text"],
		input[type="password"] {
			width: 100%;
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 5px;
			/*margin-bottom: 20px;*/
			height: 100%;
		}

		button {
			background-color: #4CAF50;
			color: white;
			padding: 10px 20px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
		}

		button:hover {
			background-color: #45a049;
		}

		a {
			color: #4CAF50;
			text-decoration: none;
		}

		.img-center {
			display: flex;
			justify-content: center;
			align-items: center;
		}
</style>

    <script>
        function showAlert(text) {
            Swal.fire({
                // title: 'Hello!',
                // text: 'This is a custom alert without URL',
                text: text,
                icon: 'info',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'my-confirm-button'
                }
            });
        }
    </script>
    <body class="">
        <div class="main-wrapper ">
            <div class="container-body">
                <div class="row">                    
                    <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <section class="section">
                                <div class="text-center">
									<div class="row mt-1">
										<div class="col-md-10 col-md-offset-1 pt-1">
											<div class="row mt-30 "  >
												<div class="col-md-11" >
													<div class="panel" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
														<form class="form-horizontal" method="post" onSubmit="return validateForm();" >
															<div class="col-md-12 ">    
																<div class="panel-heading">
																	<div class="panel-title text-center row img-center " style="margin: 20px;">
																		<img src="images/logo_small.png" width="200" class="logo">
																	</div>
																	<div class="panel-title text-center ">
																		<h1 align="center" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">Smart Broker System</h1>
																	</div><br/>
																</div>	
																<!--
																<div class="form-group row col-md-12 ">
																	<label for="code_company" class="col-md-3 control-label text-left">CompanyCode</label>

																	<div class="col-md-9">
																		<input type="text" id="code_company" name="code_company" class="form-control" placeholder="CompanyCode"  required>
																	</div>
																</div>
																-->
																<div class="form-group row col-md-12 has-feedback">
																	<label for="code_company" class="col-md-3 control-label text-left">CompanyCode</label>
																	<div class="col-md-9">
																		<input type="text" id="code_company" name="code_company" class="form-control" placeholder="CompanyCode"  required>
																		<span class="form-control-feedback">
																			<i class="form-control-feedback fa fa-building" id="icon"></i>
																		</span>
																	</div>
																</div>
																<!--
																<div class="form-group row col-md-12 ">
																	<label for="inputEmail3" class="col-md-3 control-label text-left">Username</label>
																	<div class="col-md-9">
																		<input type="text" id="username" name="username" class="form-control" id="inputEmail3" placeholder="Username"  required>
																	</div>
																</div>
																-->
																<div class="form-group row col-md-12 has-feedback">
																	<label for="inputEmail3" class="col-md-3 control-label text-left">Username</label>
																	<div class="col-md-9">
																		<input type="text" id="username" name="username" class="form-control" id="inputEmail3" placeholder="Username" required>
																		<span class="form-control-feedback">
																			<i class="form-control-feedback glyphicon glyphicon-user" id="icon"></i>
																		</span>
																	</div>
																</div>
																<!--
																<div class="form-group row col-md-12 ">
																	<label for="inputPassword3" class="col-md-3 control-label text-left">Password</label>
																	<div class="col-md-9">
																		<input type="password" id="password" name="password" class="form-control" id="inputPassword3" placeholder="Password" required>
																	</div>
																</div>
																-->
																<div class="form-group row col-md-12 has-feedback">
																	<label for="inputPassword3" class="col-md-3 control-label text-left">Password</label>
																	<div class="col-md-9">
																		<input type="password" id="password" name="password" class="form-control" id="inputPassword3" placeholder="Password" required>
																		<span class="form-control-feedback">
																			<i class="form-control-feedback glyphicon glyphicon-lock" id="icon"></i>
																		</span>
																	</div>
																</div>
																<div class="form-group row col-md-12 ">
																	<div class="col-md-3">
																	</div>
																	<div class="col-md-9">
																		<input type="text" id="company" name="company" class="form-control" readOnly>
																	</div>
																</div>
																
																<div class="form-group row col-md-12 ">
																	<div class="col-sm-6 text-left"  >
																			<a href="forgot_password.php" style="color: #4590B8;">
																				 Forget Password
																			</a>
																		</div> 
																		<div class="col-sm-6 text-right"  >
																			<button style="background-color: #0275d8;color: #F9FAFA; padding: 8px 24px;" type="submit" name="login" class="btn  btn-labeled">login
																			</button>
																		</div>
																</div>
															 </div>
															 
															 

															
															<div class="form-horizontal" >
																<div class="panel-body p-20" >
																	<!--<div class="form-group mt-20 ">
																		<div class="col-sm-6 text-left"  >
																			<a href="forgot_password.php" style="color: #4590B8;">
																				 Forget Password
																			</a>
																		</div> 
																		<div class="col-sm-6 text-right"  >
																			<button style="background-color: #0275d8;color: #F9FAFA; padding: 3px 16px 3px 16px;" type="submit" name="login" class="btn  btn-labeled">login
																			</button>
																		</div>
																	</div> -->

																</div>
															</div>
															
														</form>

															<script>
																function validateForm() {
																	var company_value = document.getElementById("company").value;
																	if (company_value!="") {
																		// document.getElementById("loading-overlay").style.display = "flex";
																		return true;
																	}else{
																		// alert("Please enter the correct company code.");
																		showAlert("Your company code incorrect.");
																		return false;
																	}
																}
															</script>

																	<script>
																		var company_object = document.getElementById("code_company");
																		company_object.addEventListener("change", function() {
																			document.getElementById("company").value = '';
																			$.get('get_company_name.php?code_company=' + $(this).val().toUpperCase(), function(data){
																				var result = JSON.parse(data);
																				$.each(result, function(index, item){
																					document.getElementById("company").value = item.company_name;
																				});
																			});
																		});
																	</script>                     

                                                 

                                                </div>
                                            </div>
                                            <!-- /.panel -->
                                            <!-- <p class="text-muted text-center"><small>Student Result Management System</small></p> -->
                                        </div>
                                        <!-- /.col-md-11 -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                            <!-- /.row -->
                        </section>

                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /. -->

        </div>
        <!-- /.main-wrapper -->

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>

        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
    </body>
</html>

<?php   
    if(isset($_POST['login'])){

    $uname=$_POST['username'];
    $password=md5($_POST['password']);

    $sql_com ="SELECT user_info.* 
     FROM user_info 
     left join company_list cl ON cl.id = user_info.id_company
     WHERE username = '".$_POST['username']."' and user_info.status = '1' and  cl.company_code = '".$_POST['code_company']."'  ";

    // echo '<script>alert("sql: '.$sql_com.'")</script>'; 
    $queryl_com = $dbh -> prepare($sql_com);
    $queryl_com-> execute();
    $results=$queryl_com->fetchAll(PDO::FETCH_OBJ);
    // echo '<script>alert("rowCount: '.$queryl_com->rowCount().'")</script>'; 

    if($queryl_com->rowCount() > 0){

        $sql ="SELECT user_info.* 
         FROM user_info WHERE username=:uname and user_info.status = '1' ";
        $query= $dbh -> prepare($sql);
        $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
        $query-> execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);

        if($query->rowCount() > 0){

            // $sql ="SELECT role_name.role_name,role_name.id AS role_name_id,user_info.* 
            //  FROM user_info
            //  left JOIN role_name ON user_info.role_name_id = role_name.id 
            //  WHERE username=:uname and password=:password and user_info.status = '1'";

            $sql ="SELECT cl.id as id_company,cl.path_web,user_info.* 
             FROM user_info
             LEFT JOIN company_list cl ON cl.id = user_info.id_company
             WHERE username=:uname and password=:password and user_info.status = '1' ";
            $query= $dbh -> prepare($sql);
            $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
            $query-> bindParam(':password', $password, PDO::PARAM_STR);
            $query-> execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);

            // echo '<script>alert("Run company_list:'.$query->rowCount().'")</script>'; 
            if($query->rowCount() > 0){
                
                // $_SESSION['alogin']=$_POST['username'];
                // $_SESSION['pass']=md5($_POST['password']);
                // alert('checked:'.$result->first_name);
                foreach($results as $result){
                    $id = $result->id;
                    $id_company = $result->id_company;
                    // $_SESSION['id']= $result->id;
                    // $_SESSION['name']= $result->first_name." ".$result->last_name;
                    // $_SESSION['role_name']= $result->role_name;
                    // $_SESSION['image']= $result->file_name_uniqid;
                    // $_SESSION['role_name_id']= $result->role_name_id;
                    // $id_user = $result->role_name_id;
                    $path_web = $result->path_web;
                }

                //////////////////////////////////////

                $sql_insert="INSERT INTO  login_history(user_id,company_id,login_time) VALUES(".$id.",".$id_company.",GETDATE())";
                // echo '<script>alert("sql_insert: '.$sql_insert.'")</script>'; 
                $query_insert = $dbh->prepare($sql_insert); 
                $query_insert->execute();
                //////////////////////////////////////

                $dbh = null;
                echo "<script>window.location.href ='".$path_web."?username=".$uname."&password=".$password."'</script>";
                // echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
            }else{
                // echo "<script>alert('Your username or password invalid.');</script>";
                $text ='Your username or password invalid.';
                echo '<script>',
                'showAlert("'.$text.'");',
                '</script>';
            }

        }else{
            // echo "<script>alert('Your username or password invalid.');</script>";
            $text ='Your username or password invalid.';
            echo '<script>',
            'showAlert("'.$text.'");',
            '</script>';
        }

    }else{
        // echo "<script>alert('The company code and the username do not match.');</script>";
        $text = 'The company code and username do not match.';
        echo '<script>',
             'showAlert("'.$text.'");',
             '</script>';
    }   

}

?>



<?php $dbh = null; ?>