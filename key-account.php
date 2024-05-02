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

            <div class="container-fluid">

                    <!-- <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Key Account</h6>
                           <!--  <div class="text-right">
                                <a href="add-policy.php" class="btn btn-primary btn-icon-split">
                                    <svg  width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
  <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                    </svg>
                                    <span class="text">Add New Policy</span>
                                </a>               
                            </div> -->
                        </div>

                        <div class="container-fluid">
            <div class="panel">
                <br>
                    <div class="form-group row">
                    
                    <label style="color: #102958;"  class="col-sm-2 col-form-label">From Date:</label>

                        <div class="col-sm-2">
                        <input  style="color: #0C1830;border-color:#102958;" type="date" name="name" required="required" class="form-control" id="success" value" >
                        </div>

                         <label style="color: #102958;" for="staticEmail" class="col-sm-2 ">To Date:</label>
                        <div class="col-sm-2">
                        <input  style="color: #0C1830;border-color:#102958;" type="date" name="name" required="required" class="form-control" id="success" value" >
                        </div>


                    </div>
                    <div class="form-group row">
                    
            <label style="color: #102958;" for="staticEmail" class="col-sm-2 ">Policy no:</label>
                        <div class="col-sm-2">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
                        </div>

                         <label style="color: #102958;" for="staticEmail" class="col-sm-2 ">Customer name:</label>
                        <div class="col-sm-2">
                            <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
                        </div>

                    <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Product:</label>
                    
                        <div class="col-sm-2">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name" required="required" class="form-control" id="success" value" >
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                        </div> 
                        <div class="col-md-4">

                            <a href="add-policy.php" style="background-color: #0275d8;" class="btn btn-primary ">
                                    <span class="text">Search</span>
                                </a>   
                        </div>
                        <div class="col-md-4">
                            <div class="text-right">
                            <a href="add-policy.php" style="background-color: #0275d8;" class="btn btn-primary ">
                                    <span class="text">Export Data</span>
                                </a>  
                            </div> 
                        </div>
                    </div>
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

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example"  cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Policy no.</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Customer name</th>
                                            <th class="text-center">Start Date</th>
                                            <th class="text-center">End Date</th>
                                            <th class="text-center">Amount of premium</th>
                                            <th class="text-center">Insurance company</th>
                                            <th class="text-center">Agent/Customer</th>
                                            <th class="text-center">Customer Tel</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Status</th>
                                            <!-- <th class="text-center">Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>10-AV3-0003479-00000-2022-12</td>
                                            <td>ข้อมูลประกันรถยนต์ของลูกค้า</td>
                                            <td>บ.แสงอุดม (1985) จำกัด1ท-4095 กท) เจ้ก้อย</td>
                                            <td>12/01/2023</td>
                                            <td>12/01/2024</td>
                                            <td>4226.5</td>
                                            <td>LMG ชั้น3</td>
                                            <td>Jae koi</td>
                                            <td>092-6517-418</td>
                                            <td>jane_jane2525@hotmail.com</td>
                                            <td class="text-center">New</td>
                                            
                                            <tr>
                                            <td class="text-center">2</td>
                                            <td>10-SAB-0001593-2022-12</td>
                                            <td>ประกันอัคคีภัย</td>
                                            <td>บริษัทแสงอุดม (1985) จำกัด (113)</td>
                                            <td>01/01/2023</td>
                                            <td>01/01/2024</td>
                                            <td>3975.05</td>
                                            <td>Lmg</td>
                                            <td>Jae koi</td>
                                            <td>083-8249355</td>
                                            <td>cheriectl@gmail.com</td>
                                            <td class="text-center">New</td>
                                           
                                        </tr>  

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

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

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

</body>

</html>
<?php } ?>
