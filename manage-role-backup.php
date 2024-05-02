<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{

if(isset($_POST['submit']) || isset($_POST['save']))
{
$id_role=$_POST['id_role'];
$subject=$_POST['subject']; 
$status=1;

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
                <li class="active">User Role</li>
            </ul>
        </div>
    </div>
</div> 

<form id="id_member" name="id_member" action="manage-role.php" class="form-horizontal" method="post">
    <div class="col-md-5">
        <div class="form-group">
            <label for="default" class="col-sm-2 control-label">Role</label>
            <div class="col-sm-10">


<select id="id_role"  name="id_role" class="form-control" value="<?php echo $id_role; ?>"  >
    <!-- <option value="">Select Role</option> -->
<?php 
$start_value_role=0;
$start="true";
$sql_role = "SELECT * from role_name 
 where status='1' ";
$query_role = $dbh->prepare($sql_role);
$query_role->execute();
$results_role=$query_role->fetchAll(PDO::FETCH_OBJ);

if($query_role->rowCount() > 0){
foreach($results_role as $result){
    if($start=="true"){
        $start_value_role = $result->id;
        $start="false";
    }

    ?>
    <?php if($id_role==$result->id){ ?>
    <option value="<?php echo $result->id; ?>" selected><?php echo $result->role_name; ?>&nbsp; </option>
    <?php }else{ ?>
    <option value="<?php echo $result->id; ?>" ><?php echo $result->role_name; ?>&nbsp; </option>
    <?php } ?>
}
<?php }}
// $('#id_role').selectpicker('val', '3');
// $('#id_role').val(,$id_role);
 ?>
        </select>

        </div>
    </div>
</div>

                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </div>
   </form>
<!--  -->

    
    <!-- /.col-md-12 -->

<?php 
if(isset($_POST['submit']) || isset($_POST['save'])){  

 $sql_table = "SELECT rn.id,rn.role_name,ur.id,ur.page_view ".
    " ,ur.page_add,ur.page_edit,ur.page_delete ".
    " ,ap.application_name ".
    " from role_name rn ".
    " join user_role ur on rn.id = ur.id_role_name ".
    " JOIN application_page ap ON ap.id = ur.id_application ".
    " WHERE ur.status = 1 AND rn.id = ".$id_role." ORDER BY ap.sort asc";
// echo '<script>alert("sql_table: '.$sql_table.'")</script>'; 
// echo 'sql se'.$sql_table;
$query_table = $dbh->prepare($sql_table);
$query_table->execute();
$results_table=$query_table->fetchAll(PDO::FETCH_OBJ);

if(isset($_POST['save'])){
if(count($_POST["chkColor"])>0){
    foreach($results_table as $result){
        // if($result->id_role==$id_role){}
        $sql_update="update  user_role set ";
        
        if (in_array("page_view:".$result->id,$_POST["chkColor"])) { 
            // echo "Yes"."<br>";
            $sql_update.=" page_view=1";
        }else{
            // echo "No"."<br>";
            $sql_update.=" page_view=0";
        }
        if (in_array("page_add:".$result->id,$_POST["chkColor"])) { 
            $sql_update.=",page_add=1";
        }else{
            $sql_update.=",page_add=0";
        }
        if (in_array("page_edit:".$result->id,$_POST["chkColor"])) { 
            $sql_update.=",page_edit=1";
        }else{
            $sql_update.=",page_edit=0";
        }
        if (in_array("page_delete:".$result->id,$_POST["chkColor"])) { 
            $sql_update.=",page_delete=1";
        }else{
            $sql_update.=",page_delete=0";
        }

        $sql_update.=" where id=".$result->id;
        // echo "SQL : ".$sql_update."<br>";

        $query_update = $dbh->prepare($sql_update);
        // $query_update->bindParam(':classname',$classname,PDO::PARAM_STR);
        $query_update->execute();

    }

    $sql_table = "SELECT rn.id,rn.role_name,ur.id,ur.page_view
    ,ur.page_add,ur.page_edit,ur.page_delete
    ,ap.application_name 
    from role_name rn 
    join user_role ur on rn.id = ur.id_role_name
    JOIN application_page ap ON ap.id = ur.id_application 
    WHERE ur.status = 1 AND rn.id = ".$id_role." ORDER BY ap.sort asc";

        $query_table = $dbh->prepare($sql_table);
        $query_table->execute();
        $results_table=$query_table->fetchAll(PDO::FETCH_OBJ);

        $msg="Data has been updated successfully";
    }
    }
}else{
     // echo '<script>alert("start_value_role: '.$start_value_role.'")</script>'; 
    $sql_table = "SELECT rn.id,rn.role_name,ur.id,ur.page_view ".
    " ,ur.page_add,ur.page_edit,ur.page_delete ".
    " ,ap.application_name ".
    " from role_name rn ".
    " join user_role ur on rn.id = ur.id_role_name ".
    " JOIN application_page ap ON ap.id = ur.id_application ".
    " WHERE ur.status = 1 AND rn.id = ".$start_value_role." ORDER BY ap.sort asc";
    $query_table = $dbh->prepare($sql_table);
    $query_table->execute();
    $results_table=$query_table->fetchAll(PDO::FETCH_OBJ);
}
//////////////////////////////////////////////////////////////
?>

<form class="form-horizontal" method="post">
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
            <h5>View Role</h5>
        </div>
        <div class="card-header py-3">
            <br>
            <div class="row pull-right">

                            <div class="text-right">
                                <!-- background-color:#102958; -->
                                <a href="add-policy.php" class="btn btn-primary" style="color:#F9FAFA;" >
                                    <svg  width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
  <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                    </svg>
                                    <span class="text">Add Role</span>
                                </a>               
                            </div>
                            &nbsp;&nbsp;&nbsp;

                        </div>
           </div> 
         

    </div>
    <div class="col-md-5">

    </div>  


    <div class="panel-body p-20">
        <div class="table-responsive">
            <table id="example" class="table table-bordered "  width="100%"  >
                <thead>
                    <tr>
                        <th>#</th>
                        <th >Role Name</th>
                        <th >Manu</th>
                        <th width="30px">View</th>
                        <th width="30px">Add</th>
                        <th width="30px">Edit</th>
                        <th width="30px">Delete</th>
                     </tr>
                </thead>
                <tbody>
<?php 
$cnt=1;
if($query_table->rowCount() > 0)
{
foreach($results_table as $result)
{   ?>
<tr>
                <td><?php echo $cnt;?></td>
                <td><?php echo $result->role_name;?></td>
                <td><?php echo $result->application_name;?></td>
                <td width="30px"> 
            <div class="form-check">
               <input data-toggle="toggle" name="chkColor[]" class="form-check-input" type="checkbox" value="<?php echo "page_view:".htmlentities($result->id) ?>" id="flexCheckDefault" 
                    <?php if($result->page_view==1){ ?>
                            checked
                                <?php } ?>
                    >
            <!-- <input type="hidden" name="id_member[<?= $row['id_member']?>]" value="0" > -->
                </div>  
            </td>

                <td width="30px">
                    <div class="form-check">
                <input data-toggle="toggle" name="chkColor[]" class="form-check-input" type="checkbox" value="<?php echo "page_add:".htmlentities($result->id) ?>" id="flexCheckDefault" 
                    <?php if($result->page_add==1){ ?>
                        checked
                    <?php } ?>
                    >
                    </div>
                </td>

                <td width="30px">
                    <div class="form-check">
               <input data-toggle="toggle" name="chkColor[]" class="form-check-input" type="checkbox" value="<?php echo "page_edit:".htmlentities($result->id) ?>" id="flexCheckDefault" 
                    <?php if($result->page_edit==1){ ?>
                        checked
                    <?php } ?>
                    >
                    </div>
                </td>

                <td width="30px">
                    <div class="form-check">
                        <input data-toggle="toggle" name="chkColor[]" class="form-check-input" type="checkbox" value="<?php echo "page_delete:".htmlentities($result->id) ?>" id="flexCheckDefault" 
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
                <button type="submit" name="save" class="btn btn-primary">Update</button>
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
