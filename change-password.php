<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==""){   
header("Location: index.php"); 
}else{

// $password=md5($_POST['password']);
$newpassword=md5($_POST['newpassword']);
$confirmpassword=md5($_POST['confirmpassword']);
$username=$_SESSION['alogin'];

if(isset($_POST['submit'])){

    if($newpassword==$confirmpassword){

// $sql ="SELECT Password FROM user_info WHERE username=:username and password=:password";
$sql ="SELECT Password FROM user_info WHERE username=:username";
$query= $dbh -> prepare($sql);
$query-> bindParam(':username', $username, PDO::PARAM_STR);
$query-> bindParam(':password', $newpassword, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);

    // if($query -> rowCount() > 0){
        $con="update user_info set password=:newpassword where username=:username";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1-> bindParam(':username', $username, PDO::PARAM_STR);
        $chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $chngpwd1->execute();
        $msg="Your Password succesfully changed";
    // }else {
    //     $error="Your current password is wrong";    
    // }
    }else{
        $error="Your new password and confirm password do not match.";
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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />


    <script>
        new DataTable('#example', {
    layout: {
        topStart: {
            buttons: ['copy', 'excel', 'pdf', 'colvis']
        }
    }
        });
    </script>

</head>

<style>
    h1, h2, h3, h4, h5, h6, b, span, p, table, a, div, label, ul, li, div,
    button {
        font-family: Manrope, 'IBM Plex Sans Thai';
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
                        <li class="active" >Change Password</li>
                    </ul>
                </div>
            </div>
        </div>

        <section class="section ">
             <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 ">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title" style="color: #102958;">
                                    <h5 style="font-weight: 700;">Change Password</h5>
                                </div>
                            </div>
                            <?php if($msg){?>
                            <div class="alert alert-success left-icon-alert" role="alert">
                                <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                            </div>
                            <?php } else if($error){?>
                            <div class="alert alert-danger left-icon-alert" role="alert">
                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                            </div>
                            <?php } ?>
  
                            <div class="panel-body">
                                <form  name="chngpwd" method="post" onSubmit="return valid();">
                                <!-- <div class="form-group has-success">
                                    <label style="color: #102958;" for="success" class="control-label">Current Password</label>
                                    <div class="">
                                <input style="color: #0C1830;border-color:#102958;" minlength="4" maxlength="12" type="password" name="password" class="form-control" required="required" id="success">
                                    </div>
                                </div> -->
                                <div class="form-group has-success row">
                                    <label style="color: #102958;" for="success" class="control-label col-sm-3 col-form-label"><small><font color="red">*</font></small>New Password</label>
                                    <div class="col-sm-9">
                                        <input style="color: #0C1830;border-color:#102958;" minlength="4" maxlength="20" type="password" name="newpassword" required="required" class="form-control" id="success">
                                    </div>
                                </div>
                                <div class="form-group has-success row">
                                    <label style="color: #102958;" for="success" class="control-label col-sm-3 col-form-label"><small><font color="red">*</font></small>Confirm Password</label>
                                    <div class="col-sm-9">
                                        <input style="color: #0C1830;border-color:#102958;" minlength="4" maxlength="20" type="password" name="confirmpassword" class="form-control" required="required" id="success">
                                    </div>
                                </div>
                                <div class="form-group has-success row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Change<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                    </div>
                                </div>

                                </form>          
                            </div>
                        </div>
                                    <!-- /.col-md-8 col-md-offset-2 -->
                    </div>
                                <!-- /.row -->

                    </div>         
                       </div>        

                </div>
                            <!-- /.container-fluid -->
        </section>

  



    <!-- Scroll to Top Button-->
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
        </script>
    <?php include('includes/footer.php'); ?>
</body>

</html>
<?php } ?>
     
<div id="loading-overlay">
    <img src="loading.gif" alt="Loading...">
</div>  
        