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


if(isset($_POST['submit']))
{
// $classname=$_POST['classname'];
// $classnamenumeric=$_POST['classnamenumeric']; 
// $section=$_POST['section'];
// $sql="INSERT INTO  tblclasses(ClassName,ClassNameNumeric,Section) VALUES(:classname,:classnamenumeric,:section)";
// $query = $dbh->prepare($sql);
// $query->bindParam(':classname',$classname,PDO::PARAM_STR);
// $query->bindParam(':classnamenumeric',$classnamenumeric,PDO::PARAM_STR);
// $query->bindParam(':section',$section,PDO::PARAM_STR);

$name_title=$_POST['name_title'];
$first_name=$_POST['first_name']; 
$last_name=$_POST['last_name'];
$nick_name=$_POST['nick_name'];

$username=$_POST['username'];
$password=$_POST['password'];
$id_role=$_POST['id_role'];
$active=$_POST['active'];
// echo '<script>alert("id_role: '.$id_role.'")</script>'; 
if(is_null($active)){
     $active=0;
}
$sql="INSERT INTO  user_info(name_title,username,password,role_name_id,status
    ,first_name,last_name,nick_name,status_delete
    ,cdate,udate,create_by)
     VALUES(:name_title_p,:username_p,:password_p,:id_role_p,:status_p
    ,:first_name_p,:last_name_p,:nick_name_p,:status_delete_p
    ,GETDATE(),GETDATE(),:create_by_p)";

$query = $dbh->prepare($sql); 
$query->bindParam(':name_title_p',$name_title,PDO::PARAM_STR);
$query->bindParam(':first_name_p',$first_name,PDO::PARAM_STR);
$query->bindParam(':last_name_p',$last_name,PDO::PARAM_STR);
$query->bindParam(':nick_name_p',$nick_name,PDO::PARAM_STR);
$query->bindParam(':username_p',$username,PDO::PARAM_STR);
$query->bindParam(':password_p',md5($password),PDO::PARAM_STR);
$query->bindParam(':id_role_p',$id_role,PDO::PARAM_STR);

if($active==""){
    $active="0";
}else{
    $active="1";
}
$query->bindParam(':status_p',$active,PDO::PARAM_STR);
$status_delete = 0;
$query->bindParam(':status_delete_p',$status_delete,PDO::PARAM_STR);
$query->bindParam(':create_by_p',$_SESSION['id'],PDO::PARAM_STR);
$query->execute();
// print_r($query->errorInfo());
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
    // $id_role=3;
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
                <li class="active">Add User</li>
            </ul>
        </div>
    </div>
</div>

  
   <section class="section">
                            <div class="container-fluid">
                                <div class="row">
                                   <!-- <div class="col-md-12 ">  -->
                                    <!-- <div class="form-group row col-md-10 col-md-offset-1"> -->
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div style="color: #102958;" class="panel-title">
                                                    <h5>Add User</h5>
                                                </div>
                                            </div>
           <?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
  
                                        <div class="panel-body">

                                            <form method="post">
                                                <div class="form-group has-success">
                                                    <!-- <div class="col-sm-2  label_left"  > -->
                                                    <label style="color: #102958;" for="success" class="control-label">Title Name</label>
                                                        <div class="">
                        <select style="border-color:#102958;" name="name_title" class="form-control" id="default" >
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


        <div class="form-group has-success">
            <label style="color: #102958;" for="success" class="control-label">First name</label>
            <div class="">
                <input minlength="1" maxlength="50" style="border-color:#102958;" type="text" name="first_name" required="required" class="form-control" id="success" value="<?php echo $first_name; ?>" >
            </div>
        </div>

        <div class="form-group has-success">
            <label style="color: #102958;" for="success" class="control-label">Last name</label>
            <div class="">
                <input minlength="1" maxlength="50" style="border-color:#102958;" type="text" name="last_name"  class="form-control" id="success" value="<?php echo $last_name; ?>" >
            </div>
        </div>

        <div class="form-group has-success">
            <label style="color: #102958;" for="success" class="control-label">Nick name</label>
            <div class="">
                <input minlength="1" maxlength="50" style="border-color:#102958;" type="text" name="nick_name"  class="form-control" id="success" value="<?php echo $nick_name; ?>" >
            </div>
       </div>

                                                    <div class="form-group has-success">
                                                        <label style="color: #102958;" for="success" class="control-label">User Name</label>
                                                        <div class="">
                                                            <input minlength="4" maxlength="12" style="border-color:#102958;" type="text" name="username" class="form-control" required="required" id="success" value="<?php echo $username; ?>" >
                                                        </div>
                                                    </div>

                                                    <div class="form-group has-success">
                                                        <label style="color: #102958;" for="success" class="control-label">Password</label>
                                                        <div class="">
                                                            <input minlength="4" maxlength="12" style="border-color:#102958;" type="password" name="password" class="form-control" required="required" id="success" value="<?php echo $password; ?>" >
                                                        </div>
                                                    </div>
                                                    
                                                     <div class="form-group has-success">
                                                        <label style="color: #102958;" for="success" class="control-label">Role User</label>
                                                        <select style="border-color:#102958;" id="id_role" name="id_role" class="form-control" >
                                                            <?php $sql = "SELECT * from role_name";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
    <?php if($result->id==$id_role){ ?>
        <option value="<?php echo $result->id; ?>" selected><?php echo $result->role_name; ?>&nbsp
    <?php }else{ ?>
        <option value="<?php echo $result->id; ?>" ><?php echo $result->role_name; ?>&nbsp
    <?php } ?>
<?php }} ?>
                                                        </select>
                                                    </div>
        <!-- <input type="hidden" readonly="" name="entry" value="111"> -->
        <div class="form-group has-success">
            <label style="color: #102958;" for="success" class="control-label">Active</label>
                <div class="">
                        <input  name="active" data-size="medium" data-toggle="toggle" id="active" value="1" class="form-check-input" type="checkbox" id="flexCheckDefault" <?php if($active==1){ ?>
                            checked
                                <?php } ?>
                            >
                                                        </div>
                                                    </div><br><br>
                                                   

                                                    <div class="form-group has-success">

                                                    <div class="">
                                                            <!-- <button onclick="relocate_home()" style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="back" class="btn" href="manage-user.php" >Back<span class="btn-label btn-label-right"></span>
                                                            </button> -->
                                                           <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                                                           </button>

                                                    </div>

                                                </form>

                                              
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-8 col-md-offset-2 -->

                                    <!-- </div> <div class="col-md-12 "> --> 
                                </div><!-- /.row -->

                            </div>
                            <!-- /.container-fluid -->
                        </section>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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
</body>

</html>
<?php } ?>
