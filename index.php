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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Broker System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }
        .login-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-box img {
            width: 200px;
        }
        .login-box h1 {
            margin: 20px 0;
            font-size: 24px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .form-group {
            position: relative;
        }
        .form-control-feedback {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }
        .btn-login {
            background-color: #0275d8;
            color: white;
            padding: 10px 24px;
            border-radius: 5px;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-login:hover {
            background-color: #025aa5;
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
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <img src="images/logo_small.png" alt="Logo">
            <h1>Smart Broker System</h1>
            <form method="post" onSubmit="return validateForm();">
                <div class="form-group has-feedback">
                    <input type="text" id="code_company" name="code_company" class="form-control" placeholder="CompanyCode"  required>
                    <span class="form-control-feedback"><i class="fas fa-building"></i></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" id="username" name="username" class="form-control" id="inputEmail3" placeholder="Username" required>
                    <span class="form-control-feedback"><i class="fas fa-user"></i></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" id="password" name="password" class="form-control" id="inputPassword3" placeholder="Password" required>
                    <span class="form-control-feedback"><i class="fas fa-lock"></i></span>
                </div>
                <div class="form-group">
                    <input type="text" id="company" name="company" class="form-control" readOnly>
                </div>
                <div class="form-group" style="display: flex; justify-content: space-between;">
                    <a href="forgot_password.php" style="color: #4590B8;">Forget Password</a>
                
                    <button type="submit" name="login" class="btn btn-login">Login</button>
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
    <script>
        function validateForm() {
            // Add form validation logic here if needed
            return true;
        }
    </script>
</body>
</html>
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