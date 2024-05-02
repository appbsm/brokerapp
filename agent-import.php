<?php
session_start();
error_reporting(0);

// require_once "excel/PHPExcel.php";

include('includes/config.php');
if(strlen($_SESSION['alogin'])==""){   
    header("Location: index.php"); 
}else{

//For Deleting the notice
if($_GET['id']){
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

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
                                        <li class="active"  ><a href="entry-policy.php">Agent List</a></li>
                                        <li class="active" >Import Agent</li>
                                    </ul>
                                </div>
                            </div>
        </div>

            <div class="container-fluid">

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                   

                <div class="panel-heading">
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Import Agent</h2>
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

        <form action="" method="post" enctype="multipart/form-data">
                <div class="col-md-3">
                <br />
                </div>  
                <div class="col-md-4">  
                   <input type="file" name="file" id="file"  style="margin-top:15px;" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required/>
                </div>  
                <div class="col-md-5">  
                    <input type="submit" name="submit" id="submit" value="Upload" style="margin-top:10px;" class="btn btn-info" />
                </div>  
                <div style="clear:both"></div>
        </form>

   <br />
   <br />
    <div class="table-responsive">

    <?php
    // Include PHPExcel library
    // require_once 'phpexcel/Classes/PHPExcel.php';
    // require_once 'PHPExcel2/Classes/PHPExcel.php';
    require 'PHPExcel2/Classes/PHPExcel.php';
    require 'PHPExcel2/Classes/PHPExcel/IOFactory.php';

    if(isset($_POST['submit'])) {
        $file = $_FILES['file']['tmp_name'];

        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

         $inputFileName = $_FILES['file']['name'];
    // กำหนด path สำหรับ upload ไฟล์
    $inputFileType = PHPExcel_IOFactory::identify($_FILES['file']['tmp_name']);
    // เรียกใช้งานฟังก์ชัน load เพื่อโหลดไฟล์ Excel
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    // กำหนดค่าให้โปรแกรมเริ่มที่แถวที่ 1
    $objReader->setReadDataOnly(true);
    // โหลดข้อมูลจากไฟล์ Excel
    $objPHPExcel = $objReader->load($_FILES['file']['tmp_name']);
    // ดึงข้อมูลจากชีทแรกในไฟล์ Excel
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
    echo '<table border="1">';
    // วนลูปเพื่อแสดงข้อมูลในแต่ละเซลล์ของตาราง
    foreach ($sheetData as $row) {
        echo '<tr>';
        foreach ($row as $cell) {
            echo '<td>' . $cell . '</td>';
        }
        echo '</tr>';
    }
    // ปิดตาราง HTML
    echo '</table>';


        // echo '<table id="example" class="table table-striped table-bordered" style="width:100%">';
        // echo '<thead>';
        // echo '<tr>';
        // for ($col = 'A'; $col <= $highestColumn; $col++) {
        //     echo '<th>' . $sheet->getCell($col . '1')->getValue() . '</th>';
        // }
        // echo '</tr>';
        // echo '</thead>';
        // echo '<tbody>';
        // for ($row = 2; $row <= $highestRow; $row++) {
        //     echo '<tr>';
        //     for ($col = 'A'; $col <= $highestColumn; $col++) {
        //         echo '<td>' . $sheet->getCell($col . $row)->getValue() . '</td>';
        //     }
        //     echo '</tr>';
        // }
        // echo '</tbody>';
        // echo '</table>';
    }
    ?>

            </div>

        </div>
    </div>
</div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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
        </script>
  
</body>

</html>
<?php } ?>
