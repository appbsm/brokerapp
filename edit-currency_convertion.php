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

	$currency=$_POST['currency'];
	$currency_list=$_POST['currency_list'];

	$currency_to=$_POST['currency_to'];
	$currency_list_to=$_POST['currency_list_to'];

	// $description=$_POST['description'];
	$start_date=$_POST['start_date'];
	$stop_date=$_POST['stop_date'];
	$status=$_POST['status'];

	// $sql = "SELECT * from currency_convertion where currency='".$currency."'";   
	// $query = $dbh->prepare($sql);
	// $query->execute();
	// $results = $query->fetchAll(PDO::FETCH_OBJ);

	// if($query->rowCount() <= 0){

	// echo '<script>alert("id_role: '.$id_role.'")</script>';

	if($currency_list != $currency_list_to){ 
	if(is_null($active)){
		 $active=0;
	}
	// $sql="INSERT INTO  currency_convertion(id_currency_list,start_date,stop_date,status,cdate,create_by)
	//      VALUES(:id_currency_list_p,:start_date_p,:stop_date_p,:status_p,GETDATE(),:create_by_p)";

	$sql="update currency_convertion set id_currency_list=:id_currency_list_p,currency_value=:currency_value_p,id_currency_list_convert=:id_currency_list_convert_p,currency_value_convert=:currency_value_convert_p,start_date=:start_date_p,stop_date=:stop_date_p,status=:status_p,udate=GETDATE(),modify_by=:modify_by_p where id=:id";

	$query = $dbh->prepare($sql); 

	$query->bindParam(':id_currency_list_p',$currency_list,PDO::PARAM_STR);
	$query->bindParam(':currency_value_p',floatval($currency),PDO::PARAM_STR);

	$query->bindParam(':id_currency_list_convert_p',$currency_list_to,PDO::PARAM_STR);
	$query->bindParam(':currency_value_convert_p',floatval($currency_to),PDO::PARAM_STR);

	$query->bindParam(':start_date_p',date("Y-m-d",strtotime($start_date)),PDO::PARAM_STR);
	$query->bindParam(':stop_date_p',date("Y-m-d",strtotime($stop_date)),PDO::PARAM_STR);
	$query->bindParam(':id',$_GET['id'],PDO::PARAM_STR);

	// $query->bindParam(':due_date_p',$due_date,PDO::PARAM_STR);
	if($status==""){
		$status="0";
	}else{
		$status="1";
	}
	$query->bindParam(':status_p',$status,PDO::PARAM_STR);
	$query->bindParam(':modify_by_p',$_SESSION['id'],PDO::PARAM_STR);
	$query->execute();
	// print_r($query->errorInfo());
	// $lastInsertId = $dbh->lastInsertId();
	// if($lastInsertId)
	// {
	// echo '<script>alert("Successfully edited information.")</script>';
	echo "<script>window.location.href ='currency_convertion.php'</script>";
	$msg="Class Created successfully";

	$level_name="";
	$active=1;

	}else{
		$error="Duplicate currency code";
	}

	// }else {
	//     $error="Something went wrong. Please try again";
	// }

	// }else{
	//     $error=" Repeated period data. Please try again";
	// }

	}else{
		$active=1;
	}

	$sql_currency = " SELECT * from currency_list WHERE status = 1 ";
	$query_currency = $dbh->prepare($sql_currency);
	$query_currency->execute();
	$results_currency = $query_currency->fetchAll(PDO::FETCH_OBJ);

	// $start_date = date('Y-m-d');
	// $stop_date = date('Y-m-d');

	if($_GET['id']){
		$sql_user = " SELECT *,FORMAT(start_date, 'dd-MM-yyyy') as start_date_f,FORMAT(stop_date, 'dd-MM-yyyy') as stop_date_f from currency_convertion WHERE id=".$_GET['id'];
		
		$query_user = $dbh->prepare($sql_user);
		$query_user->execute();
		$results_user = $query_user->fetchAll(PDO::FETCH_OBJ);
		foreach($results_user as $result){

			$currency_list = $result->id_currency_list;
			$currency = $result->currency_value;
			
			$currency_list_to = $result->id_currency_list_convert;
			$currency_to = $result->currency_value_convert;


			// echo '<script>alert("currency: '.$currency.'")</script>'; 
			$start_date = $result->start_date_f;
			$stop_date = $result->stop_date_f;
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

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
						<li class="active"><a href="currency_convertion.php">Currency Conversions</a></li>
						<li class="active">Edit Currency Conversion</li>
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
                                <h2 class="title">Edit Currency Convertion</h2>
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
                    <div class="col-sm-2 label_left" >
                        <label style="color: #102958;" for="success" class="control-label"><small><font color="red">*</font></small>Currency</label>
                    </div> 
					<div class="col-sm-3 pb-4">
                        <select name="currency_list" id="currency_list" style="color: #0C1830;border-color:#102958;"class="form-control" required >
							<?php  foreach($results_currency as $result){ ?>
                                <option value="<?php echo $result->id; ?>" 
                                <?php if ($result->id==$currency_list) { echo ' selected="selected"'; } ?>
                                    ><?php echo $result->currency; ?></option>
                            <? } ?>
                        </select>
                        
                    </div> 
                    <div class="col-sm-2 pb-4">
                         <input step="0.01" min="0" style="border-color:#102958;text-align: right;" type="number" class="form-control text-end" name="currency" id="currency" value="<?php echo number_format((float)$currency, 2, '.', ''); ?>" onchange="
                        if(Number.isInteger(parseFloat(this.value).toFixed(2))){
                            this.value=this.value+'.00';
                        }else{
                            this.value=parseFloat(this.value).toFixed(2);
                        }" required >
                    </div>
					<div class="col-sm-2">
                         <input id="status" name="status"  class="form-check-input" type="checkbox" value="true" 
                         <?php if($active==1){ ?>
                            checked
                        <?php } ?>
                         >
                        <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Active
                    </div>
				</div>
				<div class="form-group row col-md-10 col-md-offset-1" >
                     <div class="col-sm-2 label_right">
                       <label style="color: #102958;" for="success" class="control-label" ><small><font color="red">*</font></small>Convert to</label>
                    </div> 
					<div class="col-sm-3">
                        <select name="currency_list_to" id="currency_list_to" style="color: #0C1830;border-color:#102958;"class="form-control" required >
                            <?php  foreach($results_currency as $result){ ?>
                                <option value="<?php echo $result->id; ?>" 
                                <?php if ($result->id==$currency_list_to) { echo ' selected="selected"'; } ?>
                                ><?php echo $result->currency; ?></option>
                            <? } ?>
                        </select>
                    </div>
                    <div class="col-sm-2 pb-4 ">
                       <input step="0.01" min="0" style="border-color:#102958;text-align: right;" type="number" class="form-control" name="currency_to" id="currency_to" value="<?php echo number_format((float)$currency_to, 2, '.', ''); ?>" onchange="
                        if(Number.isInteger(parseFloat(this.value).toFixed(2))){
                            this.value=this.value+'.00';
                        }else{
                            this.value=parseFloat(this.value).toFixed(2);
                        }" required>
                    </div> 
                </div> 

                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left">
                        <label style="color: #102958;" required="required" class="control-label"><small><font color="red">*</font></small>Start Date</label>
                    </div>
                    <div class="col-sm-3 ">
                        <input id="start_date" name="start_date" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" value="<?php echo $start_date; ?>" >
                        <!-- <input minlength="1" maxlength="50" style="border-color:#102958;" type="text" class="form-control" name="description" id="description" value="<?php echo $description; ?>" > -->
                    </div> 
                    <div class="col-sm-2 label_right">
                        <label style="color: #102958;" required="required" class="control-label"><small><font color="red">*</font></small>Stop Date</label>
                    </div> 
                    <div class="col-sm-3 ">
                         <input id="stop_date" name="stop_date" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" value="<?php echo $stop_date; ?>" >
                    </div>   
                </div>

				<script>
				  $(document).ready(function(){
					$('#start_date').datepicker({
					  format: 'dd-mm-yyyy',
					  language: 'en'
					});
					$('#stop_date').datepicker({
					  format: 'dd-mm-yyyy',
					  language: 'en'
					});
				  });
				</script>

                <br>

                <div class="form-group row col-md-10 col-md-offset-1">
                  <!--   <div class="col-md-2">
                    </div>  -->
                    <div class="col-md-10">
                        <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                        </button>
                        &nbsp;&nbsp;
                        <a href="currency_convertion.php" class="btn btn-primary" style="background-color: #0275d8;color: #F9FAFA;" >
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
