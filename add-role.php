<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{

// if(isset($_POST['submit']) || isset($_POST['save']))
// {
// $id_role=$_POST['id_role'];
// $subject=$_POST['subject']; 
// $status=1;

// } 

if(isset($_POST['submit'])){
    $role_name=$_POST['role_name'];
    $role_status=$_POST['role_status'];
    if($role_status==""){
        $role_status="0";
    }else{
        $role_status="1";
    }
    

    $sql="INSERT INTO role_name (role_name,status) 
        VALUES  (:role_name_p,:status_p) ";
    $query = $dbh->prepare($sql); 
    $query->bindParam(':role_name_p',$role_name,PDO::PARAM_STR);
    $query->bindParam(':status_p',$role_status,PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();

    // echo '<script>alert("lastInsertId: '.$lastInsertId.'")</script>'; 

    $sql = "insert user_role (id_role_name,id_application
            ,page_view,page_add,page_edit,page_delete,status)
            VALUES ";

    for ($i=0;$i<count($_POST['id_app']);$i++) {
        $sql.="(".$lastInsertId.",".$_POST['id_app'][$i].",";
        if (in_array("page_view:".$_POST['id_app'][$i],$_POST["chk_view"])) { 
            $sql.="1,";
        }else{
            $sql.="0,";
        }
        if (in_array("page_add:".$_POST['id_app'][$i],$_POST["chk_add"])) { 
            $sql.="1,";
        }else{
            $sql.="0,";
        }
        if (in_array("page_edit:".$_POST['id_app'][$i],$_POST["chk_edit"])) { 
           $sql.="1,";
        }else{
            $sql.="0,";
        }
        if (in_array("page_delete:".$_POST['id_app'][$i],$_POST["chk_delete"])) { 
            $sql.="1,";
        }else{
            $sql.="0,";
        }
        $sql.="1)";
        $num=1+$i;
        if($num<count($_POST['id_app'])){
            $sql = $sql." , ";
        }
    }

    // for ($i=0;$i<count($_POST['id_app']);$i++) {
    //     $chk_view = $_POST['chk_view'][$i];
    //     if($chk_view==""){$chk_view=0;}else{$chk_view=1;}
    //     $chk_add = $_POST['chk_add'][$i];
    //     if($chk_add==""){$chk_add=0;}else{$chk_add=1;}
    //     $chk_edit = $_POST['chk_edit'][$i];
    //     if($chk_edit==""){$chk_edit=0;}else{$chk_edit=1;}
    //     $chk_delete = $_POST['chk_delete'][$i];
    //     if($chk_delete==""){$chk_delete=0;}else{$chk_delete=1;}
    //     $sql = $sql." (".$lastInsertId.",".$_POST['id_app'][$i].",".$chk_view.",".$chk_add.",".$chk_edit.",".$chk_delete.","."1) ";
    //     $num=1+$i;
    //     if($num<count($_POST['id_app'])){
    //         $sql = $sql.", ";
    //     }
    // }
    // echo $sql;
    // echo '<script>alert("sql: '.$sql.'")</script>'; 
    $query = $dbh->prepare($sql); 
    $query->execute();
    $msg="Your Password succesfully changed";
    // echo '<script>alert("End")</script>'; 
}

     // echo '<script>alert("start_value_role: '.$start_value_role.'")</script>'; 
    $sql_table = "SELECT 1 AS page_view,1 AS page_add,1 AS page_edit,1 AS page_delete,
        * from application_page ORDER BY sort asc ";
    $query_table = $dbh->prepare($sql_table);
    $query_table->execute();
    $results_table=$query_table->fetchAll(PDO::FETCH_OBJ);

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
	.table th {
        vertical-align: middle !important;
		text-align: center !important;
    }
	/*.table thead th.sorting:after,
	.table thead th.sorting_asc:after,
	.table thead th.sorting_desc:after {
		top: 20px;
	}*/
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
				<div class="col-md-12" >
					<ul class="breadcrumb">
						<li>
							<a href="dashboard.php"><i class="fa fa-home"></i> Home</a>
						</li>
						<li class="active"  >
							<a href="manage-role.php">View Role</a>
						</li>
						<li class="active">Add Role</li>
					</ul>
				</div>
			</div>
        </div>

		<form class="form-horizontal" method="post" onSubmit="return valid();">
			<div class="col-md-12 ">
				<div class="panel">
					<div class="panel-body">
						<div class="form-group row col-md-10 col-md-offset-1" >
							<!-- &nbsp; <p class="pull-right"> -->
							<div class="col-sm-2  label_left"  >
								<label style="color: #102958;"  >Role Name:</label>
							</div>
							<!-- col-xs-auto -->
							<div class="col ">
								<input id="role_name" name="role_name" minlength="1" maxlength="25" style="color: #0C1830;border-color:#102958;" type="text" required="required" class="form-control input_text"  >
							</div>
						   
							<div class="col-sm-2 label_right" >
								<input id="role_status" name="role_status"  class="form-check-input" type="checkbox" value="true" checked>
								<label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
											&nbsp;&nbsp;&nbsp;&nbsp; Active
								</label>
							</div>  
							<div class="col" >
							</div>  
						</div>
					</div>
				</div>
			</div>

			<section class="section">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="panel">
								<?php if($msg){ ?>   
									<div class="alert alert-success left-icon-alert" role="alert">
										<strong>Well done!</strong><?php echo htmlentities($msg); ?>
									</div><?php 
									} else if($error){?>
									<div class="alert alert-danger left-icon-alert" role="alert">
										<strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
									</div>
									<br>
								<?php } ?>

								<div class="panel-heading">
									<div class="panel-title">
										<h5>Role Management</h5>
									</div>
									<div >

									<!-- <br> -->
									<!-- <div class="row pull-right">

											<div class="text-right">
													   
												<a href="add-policy.php" class="btn btn-primary" style="color:#F9FAFA;" >
													<svg  width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
													  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
													  <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
													</svg>
													<span class="text">Add Role</span>
												</a>               
											</div>
												&nbsp;&nbsp;&nbsp;

												</div> -->
									</div> 
								</div>
								<div class="col-md-5">

								</div>  


								<div class="panel-body p-20">
									<div class="table-responsive" style="font-size: 13px;">
										<table id="example_new" class="table table-bordered "  width="100%"  >
											<thead>
												<tr>
													<th>#</th>
													<!-- <th >Role Name</th> -->
													<th >Manu</th>
													<th width="30px">View</th>
													<th width="30px">Add</th>
													<th width="30px">Edit</th>
													<th width="30px">Delete</th>
												 </tr>
											</thead>
											<tbody style="font-size: 13px;">
												<?php 
													$cnt=1;
													if($query_table->rowCount() > 0){
														foreach($results_table as $result)
													{   
												?>
											<tr>
												<td class="text-center"><?php echo $cnt;?></td>
												<!-- <td><?php echo $result->role_name;?></td> -->
												<td><?php echo $result->application_name;?>
													<input type="hidden" name="id_app[]" value="<?php echo $result->id;?>" > 
												</td>
												<td width="30px"> 
												<div class="form-check">
												   <input data-toggle="toggle" name="chk_view[]" class="form-check-input" type="checkbox" value="<?php echo "page_view:".$result->id ?>" id="flexCheckDefault" 
														<?php if($result->page_view==1){ ?>
																checked
																	<?php } ?>
														>
												<!-- <input type="hidden" name="id_member[<?= $row['id_member']?>]" value="0" > -->
													</div>  
												</td>

												<td width="30px">
													<div class="form-check">
														<input data-toggle="toggle" name="chk_add[]" class="form-check-input" type="checkbox" value="<?php echo "page_add:".htmlentities($result->id) ?>" id="flexCheckDefault" 
														<?php if($result->page_add==1){ ?>
															checked
														<?php } ?>
														>
													</div>
												</td>

												<td width="30px">
													<div class="form-check">
														<input data-toggle="toggle" name="chk_edit[]" class="form-check-input" type="checkbox" value="<?php echo "page_edit:".htmlentities($result->id) ?>" id="flexCheckDefault" 
														<?php if($result->page_edit==1){ ?>
															checked
														<?php } ?>
														>
													</div>
												</td>

												<td width="30px">
													<div class="form-check">
														<input data-toggle="toggle" name="chk_delete[]" class="form-check-input" type="checkbox" value="<?php echo "page_delete:".htmlentities($result->id) ?>" id="flexCheckDefault" 
															<?php if($result->page_delete==1){ ?>
																checked
															<?php } ?>
														>
													</div> 
												</td>
												<?php $cnt=$cnt+1;}} ?>
											</tbody>
										</table>
									</div> 

									<div class="form-group">
										<div class="col-sm-offset-1 col-sm-7">
											<input type="hidden" name="id_role" value="<?php echo $id_role; ?>" > 
											<button type="submit" name="submit" class="btn btn-primary">Submit</button>
										</div>
									</div>

								</div>
							</div>
						</div>
		<!-- /.col-md-6 -->          
					</div>
					<!-- /.col-md-12 -->
				</div>
			</div>
			<!-- /.panel -->

			<?php include('includes/footer.php'); ?>
			
		</div>
		<!-- /.col-md-6 -->

	</div>
                                <!-- /.row -->

                            </div>
                            <!-- /.container-fluid -->
                        </section>
                        </form>
                    <?php } ?>
</div>
                                        </div>

                                    </div>
  



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
<?php //} ?>

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

<div id="loading-overlay">
    <img src="loading.gif" alt="Loading...">
</div>
