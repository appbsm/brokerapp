<?php
session_start();
error_reporting(0);
include_once('includes/connect_sql.php');
include_once('includes/fx_alert.php');

if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    
    $list = overdue_list ($conn);
    
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
                                        <li class="active" >Overdue Policies</li>
                                    </ul>
                                </div>
                            </div>
        </div>

            <div class="container-fluid">

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                             <div class="panel-title"  >
                                <h2 class="title" style="color: #102958;">Overdue Policies</h2>
                            </div>
                        
                        <div class="row pull-right">

                            <div class="text-right">
                                <div class="dropdown">
  <button class="btn btn-primary mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Export
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
    <a class="dropdown-item" id="btnCsv" style="font-size: 15px;" >CSV</a>
    <a class="dropdown-item" id="btnExcel" style="font-size: 15px;" >Excel</a>
    <a class="dropdown-item" id="btnPdf" style="font-size: 15px;" >PDF</a>
    <a class="dropdown-item" id="btnPrint" style="font-size: 15px;" >Print</a>
  </div>
</div>
                                <!-- background-color:#102958; -->
                                <!-- <a href="add-policy.php" class="btn btn-primary" style="color:#F9FAFA;" >
                                    <svg  width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
  <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                    </svg>
                                    <span class="text">Add New Policy</span>
                                </a> -->               
                            </div>
                            <!-- &nbsp;&nbsp;&nbsp;
                            <div class="text-right">
                                
                                <a href="entry-policy-import.php" class="btn btn-primary" style="color:#F9FAFA;" >
<svg width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
  <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5"/>
  <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
</svg>
                                    <span class="text">Import File</span>
                                </a>               
                            </div> -->
                            <!-- &nbsp;&nbsp; -->
                        </div>
                    </div>

                        <div class="card-body" >
                            <div class="table-responsive">
                                <!-- width="2000px"  -->
                                <!-- style="width:300%;" table-striped width="2500px-->
                                <table id="example"  class="table table-bordered "  style="color: #969FA7;" >
                                    <thead >
                                        <tr style="color: #102958;" >
                                            <th class="text-center" width="20px" style="color: #102958;">#</th>
                                            
                                            <th class="text-center" width="250px" style="color: #102958;">Policy no.</th>
                                            <th class="text-center" width="200px" style="color: #102958;">Product</th>
                                            <th class="text-center" width="300px" style="color: #102958;">Customer name</th>
                                            <th class="text-center" width="100px" style="color: #102958;" >Tel</th>
                                            <th class="text-center" width="240px" style="color: #102958;">Email</th>
                                            <th class="text-center" width="80px" style="color: #102958;">Alert Date</th>
                                            <th class="text-center" width="80px" style="color: #102958;">Start Date</th>
                                            <th class="text-center" width="80px" style="color: #102958;">End Date</th>
                                            <th class="text-center" width="170px" style="color: #102958;">Amount of premium</th>
                                            <th class="text-center" width="200px" style="color: #102958;">Insurance company</th>
                                            <th class="text-center" width="100px" style="color: #102958;" >Agent/Customer</th>
                                            <th class="text-center" width="70px" style="color: #102958;">Status</th>
                                            <th class="text-center" width="50px" style="color: #102958;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="color: #0C1830;" >
<?php 
    $cnt=1;
    if($list > 0){
       foreach($list as $result){ 
           $s_date = $result['start_date'];
           $start_date = $s_date->format('d/m/Y');
           $e_date = $result['end_date'];
           $end_date = $e_date->format('d/m/Y');
           $a_date = $result['alert_date'];
           $alert_date = $e_date->format('d/m/Y');
?> 
    <tr>
        <td class="text-center"><?php echo $cnt;?></td>
        <td><?php echo $result['policy_no'];?></td>
        <td><?php echo $result['product_name'];?></td>
        <td><?php echo ($result['customer_type']=="Corporate") ? $result['company_name'] : $result['title_name']." ".$result['first_name']." ".$result['last_name']; ?></td>
        <td><?php echo $result['tel'];?></td>
        <td><?php echo $result['email'];?></td>
        <td><?php echo $alert_date;?></td>
        <td><?php echo $start_date;?></td>
        <td><?php echo $end_date;?></td>
        <td class="text-right" ><?php echo number_format($result['premium_rate'], 2);?></td>
        <td><?php echo $result['insurance_company'];?></td>
        <td><?php echo trim($result['agent_name'])." ".$result->first_name_agent." ".$result->last_name_agent;?></td>
        
        <td class="text-center"><?php echo $result['insurance_status'];?></td>
        <td class="text-center">
        <i title="Edit Record"><a href="edit-policy.php?id=<?php echo $result['id_insurance'];?>">
 <svg width="20" height="20" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
</svg>
                                                </a></i> &nbsp;&nbsp;                                                 
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
     <!-- //////////////// เอาออกเพราะมีปัญหาเรื่อง popup -->
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <!-- /////////////////// -->

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

     <!-- <script src="js/jquery/jquery-2.2.4.min.js"></script> -->
        <!-- <script src="js/bootstrap/bootstrap.min.js"></script> -->

        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <!-- <script src="js/DataTables/datatables.min.js"></script> -->

        <!-- ========== THEME JS ========== -->
        <!-- <script src="js/main.js"></script> -->

        <!-- ========== Address Search ========== -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" /> -->


    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/custom.js"></script>
       
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

