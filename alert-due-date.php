<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{

//For Deleting the notice

if($_GET['id'])
{
// $id=$_GET['id'];
// $sql="delete from user_info where id=:id";
// $query = $dbh->prepare($sql);
// $query->bindParam(':id',$id,PDO::PARAM_STR);
// $query->execute();
echo '<script>alert("Success deleted.")</script>';
echo "<script>window.location.href ='customer-information.php'</script>";

}

$sql = "SELECT * from alert_date   ";   
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
   <!--  <link
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

</head>

<body id="page-top" >

    <!-- Page Wrapper -->
    <div id="wrapper" >
        <?php include('includes/leftbar2.php');?>   
        <?php include('includes/topbar2.php');?>  
        <!-- container-fluid -->
        <div class="container-fluid mb-4" >
                            <div class="row breadcrumb-div" style="background-color:#ffffff">
                                <div class="col-md-6" >
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <!-- <li> Classes</li> -->
                                        <li class="active" >View Alert Setting</li>
                                    </ul>
                                </div>
                            </div>
        </div>

            <div class="container-fluid">

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">

                            <!-- <h6 class="m-0 font-weight-bold text-primary">View Entry Policy</h6> -->
                             <div class="panel-title"  >
                                <h2 class="title" style="color: #102958;">View Alert Setting</h2>
                            </div>
                        
                        <div class="row pull-right">

                            <div class="text-right">
                                <!-- background-color:#102958; -->
                                <a href="add-alert-due-date.php" class="btn btn-primary" style="color:#F9FAFA;" >
                                    <svg  width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
  <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                    </svg>
                                    <span class="text">Add New Alert</span>
                                </a>               
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            
                            
                             
                            &nbsp;&nbsp;
                        </div>
                    </div>

<?php 
// $sql = "SELECT *,ri.role_name AS role_name_user,ui.active AS active_user from user_info ui 
//  JOIN role_info ri ON ui.role_id = ri.id_role ";
// $query = $dbh->prepare($sql);
// $query->execute();
// $results=$query->fetchAll(PDO::FETCH_OBJ);
// $cnt=1;  
?>
                        <div class="card-body" >
                            <div class="table-responsive">
                                <!-- width="2000px"  -->
                                <!-- style="width:300%;" table-striped width="2500px-->
                                <table id="example"  class="table table-bordered "  style="color: #969FA7;" width="100%" >
                                    <thead >
                                        <tr style="color: #102958;" >
                                            <th class="text-center"  style="color: #102958;">#</th>
                                            <th class="text-center"  style="color: #102958;">Subject</th>
                                            <th class="text-center"  style="color: #102958;">Due date</th>
                                            <th class="text-center" width="70px" style="color: #102958;">Status</th>
                                            <th class="text-center" width="70px" style="color: #102958;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="color: #0C1830;" >
                                    <?php 
                                        $cnt=1;
                                        if($query->rowCount() > 0){
                                        foreach($results as $result){ 
                                    ?> 
                                        <tr>
                                            <td class="text-center"><?php echo $cnt;?></td>
                                            <td><?php echo $result->subject;?></td>
                                            <td>15</td>
                                            <!-- <td class="text-center">Active</td> -->
                                            <td class="text-center"><?php if($result->status==1){ echo "Active"; }else{ echo "InActive"; } ?></td>
                                            <td class="text-center">
                                                <a href="#?id=1"><i class="fa " title="Edit Record"></i>
 <svg width="20" height="20" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
</svg>
                                                </a> &nbsp;&nbsp;
                                                 <a href="#?id=1" onclick="return confirm('Do you really want to delete the notice?');">
    <svg width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
</svg>
    <i class="fa " title="Delete this Record" ></i> </a>
                                            </td>
                                        </tr> 
                                <?php $cnt++;}} ?>  

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <!-- <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div> -->

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>

    <!-- ========== EXPORT DATA TABLE ========== -->
    
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <!-- <script src="assets/js/custom2.js"></script> -->

        <script>
            $(function($) {
                $('#example').DataTable();
                $('#example2').DataTable( {
                    "scrollY":        "300px",
                    "scrollCollapse": true,
                    "paging":         false
                } );

                // $('#example').DataTable( {
                //     scrollX: true,
                //     "scrollCollapse": true,
                //     "paging":         true
                // });

            });
        </script>
        
        

</body>

</html>
<?php } ?>
