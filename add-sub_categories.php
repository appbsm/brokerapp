<?php
	
	include('includes/config.php');
	session_start();
	error_reporting(0);
	if(strlen($_SESSION['alogin'])=="")
		{   
		$dbh = null;
		header("Location: index.php"); 
		}
		else{

			if(isset($_POST['back'])){
				$dbh = null;
				header("Location: manage-user.php"); 
			}


	if(isset($_POST['submit'])){

	$categorie=$_POST['categorie'];
	$sub_categorie=$_POST['sub_categorie'];
	$status=$_POST['status'];
	$sql = "SELECT * from product_subcategories where subcategorie='".$sub_categorie."'  ";   
	// $sql = "SELECT * from product_categories pc
	//         JOIN product_subcategories ps ON ps.id_product_categorie = pc.id 
	//         where subcategorie='".$sub_categorie."'"." and categorie='".$categorie."'";   
	// echo '<script>alert("sql: '.$sql.'")</script>';
	$query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);

	if($query->rowCount() <= 0){

	// echo '<script>alert("id_role: '.$id_role.'")</script>'; 
	if(is_null($active)){
		 $active=0;
	}
	$sql="INSERT INTO  product_subcategories(subcategorie,id_product_categorie,status,cdate,create_by)
		 VALUES(:subcategorie_p,:id_product_categorie_p,:status_p,GETDATE(),:create_by_p)";

	$query = $dbh->prepare($sql); 
	$query->bindParam(':subcategorie_p',$sub_categorie,PDO::PARAM_STR);
	$query->bindParam(':id_product_categorie_p',$categorie,PDO::PARAM_STR);

	// $query->bindParam(':due_date_p',$due_date,PDO::PARAM_STR);
	if($status==""){
		$status="0";
	}else{
		$status="1";
	}
	$query->bindParam(':status_p',$status,PDO::PARAM_STR);
	$query->bindParam(':create_by_p',$_SESSION['id'],PDO::PARAM_STR);
	$query->execute();
	//print_r($query->errorInfo());
	$lastInsertId = $dbh->lastInsertId();
	if($lastInsertId)
	{
	// echo '<script>alert("Successfully added information.")</script>';
	$dbh = null;
	echo "<script>window.location.href ='sub_categories.php'</script>";
	$msg="Class Created successfully";

	$level_name="";
	$active=1;

	}else {
		$error="Something went wrong. Please try again";
	}

	}else{
		// $error="This products categories and sub categories already exit";
		$error="This sub categories already exit";
	}

	}else{
		$active=1;
	}

	$sql_currency = " SELECT * from product_categories WHERE status = 1 ";
	$query_currency = $dbh->prepare($sql_currency);
	$query_currency->execute();
	$results_currency = $query_currency->fetchAll(PDO::FETCH_OBJ);


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
						<li class="active"><a href="sub_categories.php">Sub Categories</a></li>
						<li class="active">Add Sub Categories</li>
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
                                <h2 class="title">Add Sub Categories</h2>
                            </div>
                        </div>
                        <div class="col-sm-2 label_left">
                        </div>
                        <div class="col label_left ">
                        </div>&nbsp;&nbsp;
                    </div>
                </div> 
            <div class="panel-body">
                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left" >
                        <label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Prod. categories</label>
                    </div> 
                    <div class="col  ">
                         <!-- <input minlength="1" maxlength="50" style="border-color:#102958;" type="text" required="required" class="form-control" name="currency" id="currency" value="<?php echo $currency; ?>" > -->
                        <select name="categorie" style="color: #000;border-color:#102958;"class="form-control"  required>
							<option value="" selected>Select Products categories</option>
                            <?php  foreach($results_currency as $result){ ?>
                                <option value="<?php echo $result->id; ?>" ><?php echo $result->categorie; ?></option>
                            <? } ?>
                        </select>
                    </div> 
                    <div class="col label_left ">
                        <input id="status" name="status"  class="form-check-input" type="checkbox" value="true" checked>
                        <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Active
                    </div> 
                    <div class="col-sm-2 label_left ">
                    </div> 
                   <!--  <div class="col-sm-2 label_right" >
                        <label style="color: #102958;" for="success" class="control-label">Due Date</label>
                    </div> 
                    <div class="col ">
                         <input minlength="1" maxlength="3" style="border-color:#102958;" type="number" name="due_date" required="required" class="form-control" id="success" value="<?php echo $due_date; ?>" >
                    </div>  -->  
                </div> 

                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left">
                        <label style="color: #102958;" required="required" class="control-label"><small><font color="red">*</font></small>Sub Categories
</label>
                    </div>
                    <div class="col ">
                        <input minlength="1" maxlength="50" style="border-color:#102958;" type="text" class="form-control" name="sub_categorie" id="sub_categorie" value="<?php echo $sub_categorie; ?>" required>
                    </div> 
                    <div class="col-sm-2 label_left">
                        <!-- <label style="color: #102958;" required="required" class="control-label">Stop Date</label> -->
                    </div> 
                    <div class="col label_left ">

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
                        <a href="sub_categories.php" class="btn btn-primary" style="background-color: #0275d8;color: #F9FAFA;" >
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

<?php $dbh = null;?>