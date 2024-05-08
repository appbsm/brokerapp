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
// $classname=$_POST['classname'];
// $classnamenumeric=$_POST['classnamenumeric']; 
// $section=$_POST['section'];
// $sql="INSERT INTO  tblclasses(ClassName,ClassNameNumeric,Section) VALUES(:classname,:classnamenumeric,:section)";
// $query = $dbh->prepare($sql);
// $query->bindParam(':classname',$classname,PDO::PARAM_STR);
// $query->bindParam(':classnamenumeric',$classnamenumeric,PDO::PARAM_STR);
// $query->bindParam(':section',$section,PDO::PARAM_STR);

$subject=$_POST['subject'];
$due_date=$_POST['due_date']; 
$status=$_POST['status'];

// echo '<script>alert("id_role: '.$id_role.'")</script>'; 
if(is_null($active)){
     $active=0;
}
$sql="INSERT INTO  alert_date(subject,due_date,status,cdate,create_by)
     VALUES(:subject_p,:due_date_p,:status_p,GETDATE(),:create_by_p)";

$query = $dbh->prepare($sql); 
$query->bindParam(':subject_p',$subject,PDO::PARAM_STR);
$query->bindParam(':due_date_p',$due_date,PDO::PARAM_STR);

if($status==""){
    $status="0";
}else{
    $status="1";
}
$query->bindParam(':status_p',$status,PDO::PARAM_STR);
$query->bindParam(':status_delete_p',$status_delete,PDO::PARAM_STR);
$query->bindParam(':create_by_p',$_SESSION['id'],PDO::PARAM_STR);
$query->execute();
// print_r($query->errorInfo());
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Class Created successfully";

$subject="";
$due_date=""; 
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
                <li class="active"><a href="alert-date-settings.php">View Alert Setting</a></li>
                <li class="active">Add Alert</li>
            </ul>
        </div>
    </div>
</div>


<?php if($msg){
echo "<script>
window.location.href='alert-date-settings.php';
</script>";
// alert('Added alert successfully!');
?>
<!--
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php }else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
        <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
    </div>-->
<?php } ?>

<form method="post">
<div class="container-fluid">
<div class="row">
    <div class="col-md-12 ">
        <div class="panel">
                <div class="panel-heading">
                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Add Alert</h2>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                        </div>
                        <div class="col-sm-4 text-right ">
                        </div>&nbsp;&nbsp;
                    </div>
                </div> 
            <div class="panel-body">
                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left" >
                        <label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Subject</label>
                    </div> 
                    <div class="col ">
                         <input minlength="1" maxlength="50" style="border-color:#102958; color: #000;" type="text" name="subject" required="required" class="form-control" id="subject" value="<?php //echo $subject; ?>" > 
                       <!--  <select id="subject" name="subject" style="color: #0C1830;border-color:#102958;" class="form-control" value="<?php echo $subject; ?>" required="required" >
                        <option value="">Select Subject</option>
                        <option value="Policy Date">Policy Date</option>
                        
                    </select> -->
                    </div> 
                    <div class="col-sm-2 label_right" >
                        <label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Due Date</label>
                    </div> 
                    <div class="col ">
                         <input minlength="1" maxlength="3" style="border-color:#102958; color: #000;" type="number" name="due_date" required="required" class="form-control" id="success" value="<?php echo $due_date; ?>" >
                    </div>   
                </div> 

                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left">
                        
                    </div>
                    <div class="col ">
                        <input id="status" name="status"  class="form-check-input" type="checkbox" value="true" checked>
                        <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Active
                    </div> 
                    <div class="col-sm-2 label_right">
                    </div> 
                </div>
                <br>

                <div class="form-group row col-md-10 col-md-offset-1">
                  <!--   <div class="col-md-2">
                    </div>  -->
                    <div class="col-md-10">
                        <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                        </button>
						&nbsp;&nbsp;
						<a href="alert-date-settings.php" class="btn btn-primary" style="background-color: #0275d8;color: #F9FAFA;" >
							<span class="text">Cancel</span>
						</a>
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
