
<?php
	include('includes/config.php');
	session_start();
	error_reporting(0);

	if(strlen($_SESSION['alogin'])==""){  
		$dbh = null;
		header("Location: index.php"); 
	}else{
		if(isset($_POST['back'])){
			$dbh = null;
			header("Location: manage-user.php"); 
		}


if(isset($_POST['submit'])){
	$product_name=$_POST['product_name'];
	$product_note=$_POST['product_note'];
	$id_product_cat=$_POST['id_product_cat'];
	$id_product_sub=$_POST['id_product_sub']; 
	$product_id=$_POST['product_id'];
	$status=$_POST['status'];
	$status_notrenew=$_POST['status_notrenew'];

	if(is_null($active)){
		$active=0;
	}

	$sql = "SELECT TOP 1 MAX(product_id) AS id,pc.first_letters FROM product pd ".
	" RIGHT JOIN product_categories pc ON pc.id = pd.id_product_categories ".
	" WHERE pc.id = '".$id_product_cat."' ".
	" group BY pc.first_letters";
	echo '<script>alert("sql: '.$sql.'")</script>'; 
	// echo '<script>alert("sql product : '.$sql.'")</script>'; 
	$query = $dbh->prepare($sql);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);

	// if(count($results)>0){
		foreach($results as $result){
			// $product_id = $result->id;
			$number_product = 0;
			$number = intval(substr($result->id, 3)) + 1;

			if($result->id){
				if (strlen(strval($number)) == 1) {
				    $number_product = "0000" . strval($number);
				} elseif (strlen(strval($number)) == 2) {
				    $number_product = "000" . strval($number);
				} elseif (strlen(strval($number)) == 3) {
				    $number_product = "00" . strval($number);
				} elseif (strlen(strval($number)) == 4) {
				    $number_product = "0" . strval($number);
				} elseif (strlen(strval($number)) == 5) {
				    $number_product = strval($number);
				}
				$product_id = "P".$result->first_letters."-".$number_product;
			}else{
				$product_id = "P".$result->first_letters."-"."00001";
			}
		}
	// }else{

	// 	$product_id = "P".$result->first_letters."-"."00001";
	// }

	echo '<script>alert("product_id: '.$product_id.'")</script>'; 

	$sql="INSERT INTO  product(product_name,product_note,id_product_categories,id_product_sub,status,status_notrenew,cdate,create_by,product_id) VALUES(:product_name_p,:product_note_p,:id_product_categories_p,:id_product_sub_p,:status_p,:status_notrenew_p,GETDATE(),:create_by_p,:product_id_p)";

	// $sql="INSERT INTO  product(name_title,name,username,password,role_id,active) VALUES(:name_title_p,:name_p,:username_p,:password_p,:id_role_p,:active_p)";
	$query = $dbh->prepare($sql);

	$query->bindParam(':product_name_p',$product_name,PDO::PARAM_STR);
	$query->bindParam(':product_note_p',$product_note,PDO::PARAM_STR);
	$query->bindParam(':id_product_categories_p',$id_product_cat,PDO::PARAM_STR);
	$query->bindParam(':id_product_sub_p',$id_product_sub,PDO::PARAM_STR);

	if($status==""){
		$status="0";
	}else{
		$status="1";
	}

	if($status_notrenew==""){
		$status_notrenew="0";
	}else{
		$status_notrenew="1";
	}

	$query->bindParam(':status_p',$status,PDO::PARAM_STR);
	$query->bindParam(':status_notrenew_p',$status_notrenew,PDO::PARAM_STR);
	$query->bindParam(':create_by_p',$_SESSION['id'],PDO::PARAM_STR);

	$query->bindParam(':product_id_p',$product_id,PDO::PARAM_STR);

	$query->execute();

	// print_r($query->errorInfo());
	// echo '<script>alert("sql: '.$sql.'")</script>'; 
	$lastInsertId = $dbh->lastInsertId();

	if($lastInsertId){
		// echo '<script>alert("Successfully added information.")</script>';
		$dbh = null;
		echo "<script>window.location.href ='product-management.php'</script>";
		$msg="Class Created successfully";

		$name_title="";
		$name=""; 
		$username="";
		$password="";
		$id_role="";
		$active=1;
	}else {
		$error="Something went wrong. Please try again";
	}

	}else{
		$active=1;
		$id_role=3;
		$name_title="Mr.";
	}

	$sql_categories = " SELECT * from product_categories WHERE status = 1 order by id asc ";
	$query_categories = $dbh->prepare($sql_categories);
	$query_categories->execute();
	$results_categories = $query_categories->fetchAll(PDO::FETCH_OBJ);

	$start ="true";
	$first_order="0";
	foreach($results_categories as $result){
		if($start=="true"){
			$first_order = $result->id;
			$start = "false";
		}
	}

	$sql_sub = " SELECT * from product_subcategories WHERE status = 1 AND id_product_categorie = '".$first_order."'";
	$query_sub = $dbh->prepare($sql_sub);
	$query_sub->execute();
	$results_sub = $query_sub->fetchAll(PDO::FETCH_OBJ);


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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>

        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
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
	@media (min-width: 1340px){
		.label_left{
			max-width: 130px;
		}
		.label_right{
			max-width: 150px;
		}
	}
	textarea {
	  max-height: 4.5em; /* 3 บรรทัด * 1.5em (ความสูงของแต่ละบรรทัด) */
	  overflow-y: auto; /* ให้มีการเกิด scroll bar เมื่อเกินขนาดที่กำหนด */
	}
	
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

        <div class="container-fluid " >
			<div class="row breadcrumb-div" style="background-color:#ffffff">
				<div class="col-md-12" >
					<ul class="breadcrumb">
						<li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
						<li class="active"  ><a href="product-management.php">Product</a></li>
						<li class="active">Add Product</li>
					</ul>
				</div>
			</div>
        </div>

		<form method="post" onSubmit="return valid();">
		<br>

		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 ">
					<div class="panel">
					   <!-- <div class="panel-heading">
							<div class="panel-title" style="color: #102958;" >
								<h2 class="title">Add Product</h2>
							</div>
						</div> -->
						<div class="panel-heading">
							<div class="form-group row col-md-10 col-md-offset-1">
								<div class="col">
									<div class="panel-title" style="color: #102958;" >
										<h2 class="title">Add Product</h2>
										<br>
									</div>

								</div>
								<div class="col-sm-2 ">
									<!-- style="background-color: #0275d8;color: #F9FAFA;" -->
								</div>
							</div>
						</div> 
						<div class="panel-body">
							<div class="form-group row col-md-10 col-md-offset-1" >
								<div class="col-sm-2 label_left" >
									<label style="color: #102958;" >Prod. ID:</label>
								</div>
								<div class="col ">
									<input id="product_id" name="product_id" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="" readonly>
								</div>
								
								<div class="col-sm-2 label_left ">
									<input id="status" name="status"  class="form-check-input" type="checkbox" value="true" checked>
									<label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
										&nbsp;&nbsp;&nbsp;&nbsp; Active
									</label>
								</div>
								<div class="col">
								   
								</div>
							</div>

							<div class="form-group row col-md-10 col-md-offset-1" >
								<div class="col-sm-2  label_left" >
									<label style="color: #102958;" ><small><font color="red">*</font></small>Prod. Categories:</label>
								</div>
								<div class="col ">
									<select id="id_product_cat" name="id_product_cat" style="color: #000;border-color:#102958;"class="form-control" id="default" required  >
										<option value="" selected>Select Product Categories</option>
										<?php  foreach($results_categories as $result){ ?>
											<option value="<?php echo $result->id; ?>"><?php echo $result->categorie; ?></option>
										<? } ?>
									   <!--  <option value="Life">Life</option>
										<option value="Non Life">Non Life</option> -->
									</select>
								</div>

								<div class="col-sm-2 label_left" >
									<label style="color: #102958;" ><small><font color="red">*</font></small>Prod. Sub Categories:</label>
								</div>
								<div class="col">
									<select id="id_product_sub" name="id_product_sub" style="color: #000;border-color:#102958;"class="form-control" id="default"  value="" required>
										 <option value="" selected>Select Sub Categories</option>
										 <?php  foreach($results_sub as $result){ ?>
											<option value="<?php echo $result->id; ?>"><?php echo $result->subcategorie; ?></option>
										<? } ?>
									<!-- <option value="">Life insurance</option>
									<option value="">Health Insurance</option> -->
									</select>
								</div>
							</div>
							
							<div class="form-group row col-md-10 col-md-offset-1" >
								<div class="col-sm-2  label_left" >
								   <label style="color: #102958;" ><small><font color="red">*</font></small>Prod. Name:</label>
								</div>
								<div class="col ">
									<input  name="product_name" minlength="1" maxlength="255" style="color: #000;border-color:#102958;" type="text" required="required" class="form-control" value="" required>
								</div>
							</div>
							
							<div class="form-group row col-md-10 col-md-offset-1" >
								<div class="col-sm-2  label_left" >
									<label style="color: #102958;" >Automatic Not Renew:</label>
								</div>
								<div class="col ">
									<input id="status_notrenew" name="status_notrenew"  class="form-check-input" type="checkbox" value="true" >
									<label style="color: red; font-size: 12px;">
										<i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Upon selecting this option, the system will automatically calculate by the end date of policy and subsequently change the status to "Not Renew."</i>
									</label>
								</div>
							</div>

							<div class="form-group row col-md-10 col-md-offset-1" >
								<div class="col-sm-2  label_left" >
									<label style="color: #102958;" >Prod. Note:</label>
								</div>
								<div class="col ">
									<!-- <input  name="product_name" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" required="required" class="form-control" value="" required> -->
									<textarea name="product_note" class="form-control" style="color: #000;border-color:#102958;" id="product_name" rows="3" ></textarea>
								</div>
								<!-- 
								<div class="col-sm-2 label_right" >
									
								</div>
								<div class="col">
									<input name="product_note"  minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" value="" required>
									 <textarea name="product_note" class="form-control" style="color: #0C1830;border-color:#102958;" id="product_note" rows="3" required></textarea>
								</div> -->
							</div>
							
							<div class="form-group row col-md-10 col-md-offset-1">
								<div class="col-md-10">
										<button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
										</button>
										&nbsp;&nbsp;
									<a href="product-management.php" class="btn btn-primary" style="background-color: #0275d8;color: #F9FAFA;" >
										<span class="text">Cancel</span>
									</a>
								</div>
							</div>
						  </div></div>
						</div>
					</div>                             
				</div>
			</div>
		</form>

    

    <script type="text/javascript">
    $(function(){
        var product_cat_object = $('#id_product_cat');
        var product_sub_object = $('#id_product_sub');
        product_cat_object.on('change', function(){
            var product_cat_id = $(this).val();
            // product_sub_object.html('<option value="" >Choose a district</option>');
            product_sub_object.html('');
            
            $.get('get_product_subcategories.php?id=' + product_cat_id, function(data){
            var result = JSON.parse(data);
                $.each(result, function(index, item){
                    product_sub_object.append(
                        $('<option></option>').val(item.id).html(item.subcategorie)
                    );
                    // $('.selectpicker').selectpicker('amphure');
                });
            $("#id_product_sub").selectpicker('refresh');
            });


            $.get('get_product_id.php?id=' + product_cat_id, function(data){
            var result = JSON.parse(data);
                $.each(result, function(index, item){
                    // document.getElementById('product_id').value = item.id;
                    // first_letters
                    if(item.id){
                        // +substr(item.id, 0, 5)
                        var number_product=0;
                        var number = parseInt(item.id.slice(3))+1;
                        // alert("test:"+number.toString().length);
                        if(number.toString().length=="1"){
                            number_product = "0000"+number.toString();
                        }else if(number.toString().length=="2"){
                            number_product = "000"+number.toString();
                        }else if(number.toString().length=="3"){
                            number_product = "00"+number.toString();
                        }else if(number.toString().length=="4"){
                            number_product = "0"+number.toString();
                        }else if(number.toString().length=="5"){
                            number_product = number.toString();
                        }
                        document.getElementById('product_id').value = "P"+item.first_letters+"-"+number_product;
                    }else{
                        document.getElementById('product_id').value = "P"+item.first_letters+"-"+"00001";
                    }
                });    
            });

        });
    });
</script>

    <br><br><br>


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

<div id="loading-overlay">
    <img src="loading.gif" alt="Loading...">
</div>


<?php $dbh = null;?>