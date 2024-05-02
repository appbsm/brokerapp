
<?php
session_start();
error_reporting(0);

include('includes/config.php');
require_once('PHPMailer/PHPMailerAutoload.php');

if($_SESSION['alogin']!=''){
    $_SESSION['alogin']='';
}

if(isset($_GET['key']) && isset($_GET['email'])) {
    $key=$_GET['key'];
    $email=$_GET['email'];

    $sql = "SELECT * from forget_password WHERE email = '".$email."' and temp_key = '".$key."'";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    // echo '<script>alert("results: '.count($results).'")</script>'; 
    if(count($results)==0){
        echo '<script>alert("This url is invalid or already been used. Please verify and try again.")</script>';
        echo "<script>window.location.href ='customer-information.php'</script>";
    }
}else{
  header('location:index.php');
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $password=$_POST['password'];
    $confirm_password=$_POST['confirm_password'];
    if ($password==$confirm_password) {

    $sql="DELETE FROM forget_password where email='$email' and temp_key='$key'";
    $query = $dbh->prepare($sql);
    $query->execute();

    $sql_update = "update user_info set password=:password_p where email='".$email."'";
            $query = $dbh->prepare($sql_update); 
            $query->bindParam(':password_p',md5($password),PDO::PARAM_STR);
            $query->execute();
            $message_success="Your Password succesfully changed ";
    }else{
        $message="Your new password and confirm password do not match.";
    }
}

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
    </head>
    <body class="">
        <div class="main-wrapper">

            <div class="">
                <div class="row">
                    
                    <!-- <h1 align="center">Insurance Broker Management System</h1> -->
                        
                         <div class="col-lg-3">
                         </div>
                            <div class="col-lg-6">
                                <section class="section">
                                    <div class="text-center">
                                <img src="images/logo_small.png" width="200" class="logo">
                            </a>
                            <h1 align="center">Smart Broker System</h1>
                            <div class="row mt-1">
                                <!-- <div class="col-md-10 col-md-offset-1 pt-50"> -->
                                <div class="col-md-10 col-md-offset-1 pt-1">

                                    <div class="row mt-30 "  >
                                        <div class="col-md-11" >
                                            <div class="panel" >
                                                <div class="panel-heading">
                                                    <div class="panel-title text-center">
                                                        <!-- <h4>Admin Login</h4> -->
                                                    </div>
                                                </div>
                                                <div class="panel-body p-20" >

                                                    <form class="form-horizontal" method="post">
                                                          <div class="col-sm-12 text-center"  >
                                             <label>Please enter your new password</label><br>
                                            </div> 
                                                    	<div class="form-group">
                                                    		<label class="col-sm-3 control-label">New Password</label>
                                                    		<div class="col-sm-9">
                                                    			<input id="password" name="password" type="text" class="form-control"  placeholder="Password" required="required" minlength="4" maxlength="12" >
                                                    		</div>
                                                            <label class="col-sm-3 control-label">Confirm Password</label>
                                                            <div class="col-sm-9">
                                                                <input id="confirm_password" name="confirm_password" type="text" class="form-control"  placeholder="Confirm Password" required="required" minlength="4" maxlength="12" >
                                                            </div>
                                                    	</div>

                                    <?php if (isset($error)) {
                      echo"<div class='alert alert-danger' role='alert'>
                      <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                      <span class='sr-only'>Error:</span>".$error."</div>";
                 } ?>
            <?php if ($message<>"") {
                      echo"<div class='alert alert-danger' role='alert'>
                      <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                      <span class='sr-only'>Error:</span>".$message."</div>";
                } ?>
            <?php if (isset($message_success)) {
                      echo"<div class='alert alert-success' role='alert'>
                      <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                      <span class='sr-only'>Error:</span>".$message_success."</div>";
                  } ?>

                            <div class="form-group mt-20 ">
                                <div class="col-sm-6 text-left"  >
                                    <a href="index.php" style="color: #4590B8;">
                                         Back to Login
                                    </a>
                                </div> 
            
                                <div class="col-sm-6 text-right"  >
                                    <button type="submit" style="background-color: #0275d8;color: #F9FAFA;text-left" name="login" class="btn">Save Password<span class="btn-label btn-label-right"><i class="fa "></i></span></button>
                                </div>

                                                        </div> 
                                                    	</div>

                                                    </form>

                                            

                                                 
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
        <script>
            $(function(){

            });
        </script>

        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
    </body>
</html>
