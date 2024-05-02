<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==""){   
    header("Location: index.php"); 
}else{
    if(isset($_POST['back'])){
        header("Location: manage-user.php"); 
    }


if(isset($_POST['submit'])){
$currency=$_POST['currency'];
$description=$_POST['description'];
$status=$_POST['status'];

$sql = "SELECT * from currency_list where currency='".$currency."' and id!=:id";   
$query = $dbh->prepare($sql);
$query->bindParam(':id',$_GET['id'],PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() <= 0){
$sql="update currency_list set currency=:currency_p,description=:description_p,status=:status_p,udate=GETDATE(),modify_by=:modify_by_p where id=:id";
// echo '<script>alert("sql: '.$sql.'")</script>'; 
// echo "sql:".$sql;
$query = $dbh->prepare($sql); 
$query->bindParam(':currency_p',$currency,PDO::PARAM_STR);
$query->bindParam(':description_p',$description,PDO::PARAM_STR);
if($status==""){
    $status="0";
}else{
    $status="1";
}
$query->bindParam(':status_p',$status,PDO::PARAM_STR);
$query->bindParam(':modify_by_p',$_SESSION['id'],PDO::PARAM_STR);
$query->bindParam(':id',$_GET['id'],PDO::PARAM_STR);

$query->execute();
// print_r($query->errorInfo());
// $lastInsertId = $dbh->lastInsertId();
// if($lastInsertId){
$msg="Class Created successfully";
echo '<script>alert("Successfully edited information.")</script>';
echo "<script>window.location.href ='currency_list.php'</script>";
}else{
    $error="This currency already exit";
}

$period="";
$active=1;

// }else {
//     $error="Something went wrong. Please try again";
// }



}else{
    $active=1;
}

if($_GET['id']){
    $sql_user = " SELECT * from currency_list WHERE id=".$_GET['id'];
    $query_user = $dbh->prepare($sql_user);
    $query_user->execute();
    $results_user = $query_user->fetchAll(PDO::FETCH_OBJ);
    foreach($results_user as $result){ 
        $currency = $result->currency;
        $description = $result->description;
        $active = $result->status;
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
                <li class="active"><a href="currency_list.php">Currency List</a></li>
                <li class="active">Edit Currency</li>
            </ul>
        </div>
    </div>
</div>

<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php }else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
        <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
    </div>
<?php } ?>

<form method="post" onSubmit="return valid();">
<div class="container-fluid">
<div class="row">
    <div class="col-md-12 ">
        <div class="panel">
                <div class="panel-heading">
                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Edit Currency</h2>
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
                        <label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Currency Code</label>
                    </div> 
                    <div class="col ">
                         <input minlength="1" maxlength="50" style="border-color:#102958;" type="text" required="required" class="form-control" name="currency" id="currency" value="<?php echo $currency; ?>" >
                    </select>
                    </div> 
                    <div class="col ">
                        <input id="status" name="status"  class="form-check-input" type="checkbox" value="true" 
                        <?php if($active==1){ ?>
                            checked
                        <?php } ?>
                        >
                        <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Active
                    </div> 
                    <div class="col-sm-2 ">
                    </div> 
                </div> 

                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left" >
                        <label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Description</label>
                    </div> 
                    <div class="col ">
                         <input minlength="1" maxlength="50" style="border-color:#102958;" type="text" class="form-control" name="description" id="description" value="<?php echo $description; ?>" required>
                    </div> 
                    <div class="col ">
                    </div> 
                    <div class="col-sm-2 ">
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
                        <a href="currency_list.php" class="btn btn-primary" style="background-color: #0275d8;color: #F9FAFA;" >
                            <span class="text">Clear</span>
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

<div id="loading-overlay">
    <img src="loading.gif" alt="Loading...">
</div>