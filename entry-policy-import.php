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
   <!--  <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
 -->
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

         <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <!-- <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>   -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

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
                                        <li class="active"  ><a href="entry-policy.php">View Entry Policy</a></li>
                                        <li class="active" >Import Entry Policy</li>
                                    </ul>
                                </div>
                            </div>
        </div>

            <div class="container-fluid">

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                   

<?php 
// $sql = "SELECT *,ri.role_name AS role_name_user,ui.active AS active_user from user_info ui 
//  JOIN role_info ri ON ui.role_id = ri.id_role ";
// $query = $dbh->prepare($sql);
// $query->execute();
// $results=$query->fetchAll(PDO::FETCH_OBJ);
// $cnt=1;  
?>
                <div class="panel-heading">
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Import Entry Policy</h2>
                            </div>
                        </div>
                        <div class="col-sm-4 ">
                        </div>
                        <div class="col-sm-4 text-right">
                            <br>
                           <!--  <a href="#" class="d-none d-sm-inline-block btn  btn-primary "><i
                                class="fas  fa-sm text-white-50"></i>+ Add More Insurance</a> -->
                        </div>
                        </div>
                    </div>

                        <div class="card-body" >
                            <div class="table-responsive">
                                <!-- width="2000px"  -->
                                <!-- style="width:300%;" table-striped width="2500px-->


        <form id="upload_csv" method="post" enctype="multipart/form-data">
            <div class="col-md-3">
                 <br />
     <!-- <label>Add More Data</label> -->
    </div>  
                <div class="col-md-4">  
                   <input type="file" name="csv_file" id="csv_file" accept=".csv" style="margin-top:15px;" />
                </div>  
                <div class="col-md-5">  
                    <input type="submit" name="upload" id="upload" value="Upload" style="margin-top:10px;" class="btn btn-info" />
                </div>  
                <div style="clear:both"></div>
        </form>

   <br />
   <br />
   <div class="table-responsive">
    
    <table class="table table-striped table-bordered" id="data-table">
     <thead>
      <tr>
       <th>Student ID</th>
       <th>Student Name</th>
       <th>Phone Number</th>
      </tr>
     </thead>
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
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
     <script src="js/sb-admin-2.min.js"></script>

     <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <!-- <script src="js/bootstrap/bootstrap.min.js"></script> -->
        <script src="js/pace/pace.min.js"></script>

        <!--ตัวช่องค้นหา-->
        <script src="js/lobipanel/lobipanel.min.js"></script>

        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <!-- <script src="js/DataTables/datatables.min.js"></script> -->

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>

    <!-- ========== EXPORT DATA TABLE ========== -->
    
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/custom.js"></script>

        <script>


            $(function($) {
                $('#example1').DataTable();
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



//              new DataTable('#example', {
//     columnDefs: [{ width: 200, targets: 0 }],
//     fixedColumns: true,
//     paging: false,
//     scrollCollapse: true,
//     scrollX: true,
//     scrollY: 300
// });

        </script>

        <script>

$(document).ready(function(){
 $('#upload_csv').on('submit', function(event){
  event.preventDefault();
  $.ajax({
   url:"import.php",
   method:"POST",
   data:new FormData(this),
   dataType:'json',
   contentType:false,
   cache:false,
   processData:false,
   success:function(jsonData)
   {
    $('#csv_file').val('');
    $('#data-table').DataTable({
     data  :  jsonData,
     columns :  [
      { data : "student_id" },
      { data : "student_name" },
      { data : "student_phone" }
     ]
    });
   }
  });
 });
});

</script>
        
        

</body>

</html>
<?php } ?>
