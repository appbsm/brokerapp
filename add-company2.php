
<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{

        if(isset($_POST['back'])){
            header("Location: manage-user.php"); 
        }


if(isset($_POST['submit'])){

$name_title=$_POST['name_title'];
$name=$_POST['name']; 
$username=$_POST['username'];
$password=$_POST['password'];
$id_role=$_POST['id_role'];
$active=$_POST['active'];
if(is_null($active)){
     $active=0;
}
$sql="INSERT INTO  user_info(name_title,name,username,password,role_id,active) VALUES(:name_title_p,:name_p,:username_p,:password_p,:id_role_p,:active_p)";
$query = $dbh->prepare($sql); 
$query->bindParam(':name_title_p',$name_title,PDO::PARAM_STR);
$query->bindParam(':name_p',$name,PDO::PARAM_STR);
$query->bindParam(':username_p',$username,PDO::PARAM_STR);
$query->bindParam(':password_p',md5($password),PDO::PARAM_STR);
$query->bindParam(':id_role_p',$id_role,PDO::PARAM_STR);
$query->bindParam(':active_p',$active,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Class Created successfully";

$name_title="";
$name=""; 
$username="";
$password="";
$id_role="";
$active=1;

}
else 
{
$error="Something went wrong. Please try again";
}

}else{
    $active=1;
    $id_role=3;
    $name_title="Mr.";
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

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

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
                                        <li class="active"  ><a href="companylist.php">View Company List</a></li>
                                        <li class="active">Add Company Detail</li>
                                    </ul>
                                </div>
                            </div>
    </div>

<form method="post">
<br>
<!-- <section class="section"> -->

<div class="container-fluid">
        <div class="row">

            <div class="col-md-12 ">
                <div class="panel">

                   <div class="panel-heading">
                        <div class="panel-title" style="color: #102958;" >
                            <h2 class="title">Add Company Detail</h2>
                        </div>
                    </div>
   
        <div class="panel-body">
            
            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Company ID:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
               
                </div>

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Company name:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
                </div>
            </div>


            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Tax ID:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
                </div>
                
            </div>

            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Tel:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Mobile:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
                </div>
            </div>

            <div class="form-group row">
               <!--  <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Mobile:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
               
                </div> -->
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
                </div>

                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Company Logo:</label>
                
            <div class="col-sm-4">
                <input type="file" name="img" src="<?php echo htmlentities($path_file) ?>" id="imgInp">
            </div>
            </div>



             <div class="panel-heading">
                <div class="panel-title" style="color: #102958;" >
                    <h2 class="title" >Address</h2>
                </div>
            </div> 
            
            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">ID:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Village:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
                </div>
            </div>

            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Soi:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Road name:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
                </div>
            </div>

            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Sub-district:</label>
                <div class="col-sm-4">
                    <!-- <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" > -->

                    <select style="color: #4590B8;border-color:#102958;" name="name_title" class="form-control" id="default" >
                                <option value="Mr." selected></option>
                        </select>
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">District:</label>
                <div class="col-sm-4">
                     <select style="color: #4590B8;border-color:#102958;" name="name_title" class="form-control" id="default" >
                                <option value="Mr." selected></option>
                        </select>
                </div>
            </div>

            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Province:</label>
                <div class="col-sm-4">
                     <select style="color: #4590B8;border-color:#102958;" name="name_title" class="form-control" id="default" >
                                <option value="Mr." selected></option>
                        </select>
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Post Code:</label>
                <div class="col-sm-4">
                     <select style="color: #4590B8;border-color:#102958;" name="name_title" class="form-control" id="default" >
                                <option value="Mr." selected></option>
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

                 <!--   <div class="panel-heading">
                        <div class="panel-title" style="color: #102958;" >
                            <h2 class="title">Contact Person</h2>
                        </div>
                    </div> -->

                    <div class="panel-heading">
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Master Email</h2>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                     <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Email name:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
               
                </div>
                
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

                 <!--   <div class="panel-heading">
                        <div class="panel-title" style="color: #102958;" >
                            <h2 class="title">Contact Person</h2>
                        </div>
                    </div> -->

                    <div class="panel-heading">
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Brach Code & Descrition</h2>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                     <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Brach Code:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
                    
                </div>
                
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Brach Descrition:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
                </div>

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

                 <!--   <div class="panel-heading">
                        <div class="panel-title" style="color: #102958;" >
                            <h2 class="title">Contact Person</h2>
                        </div>
                    </div> -->

                    <div class="panel-heading">
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Contact Person</h2>
                            </div>
                        </div>
                        <div class="col-sm-4 ">
                        </div>
                        <div class="col-sm-4 text-right">
                            <br>
                            <a href="#" class="d-none d-sm-inline-block btn  btn-primary "><i
                                class="fas  fa-sm text-white-50"></i>+ Add More Contact</a>
                        </div>
                        </div>
                    </div>
   
        <div class="panel-body">
            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Title Name:</label>
                <div class="col-sm-4">
                     <select style="color: #4590B8;border-color:#102958;" name="name_title" class="form-control" id="default" >
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

            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">First name:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Last name:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
                </div>
            </div>

            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Nickname:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Position:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
                </div>
            </div>

            

            <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Tel:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
                </div>
            </div>

             <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Mobile:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
               
                </div>
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Line ID:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
                </div>
            </div>

             <div class="form-group row">
                <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Remark:</label>
                <div class="col-sm-4">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
               
                </div>
               
                </div>
            </div>

          <!--   <div class="form-group row">
                <div class="col-md-12">
                <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                                                           </button>
                </div>
            </div> -->
          

        </div>
    </div>                             
    </div>
</div>

    <br><br><br>
</form>
  



    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->

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
        <style>
@media (min-width: 1340px){
    .label_left{
        max-width: 180px;
    }
    .label_right{
        max-width: 190px;
    }
}

</style>

</body>

</html>
<?php } ?>


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

