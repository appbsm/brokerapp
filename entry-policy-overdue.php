<?php

include_once('includes/connect_sql.php');
session_start();
error_reporting(0);
// include_once('includes/fx_alert.php');
include_once('includes/fx_alert_date.php');

if(strlen($_SESSION['alogin'])==""){
    sqlsrv_close($conn);
    header("Location: index.php"); 
}
    
    $list = near_to_overdue_list($conn);
    
    $status_view ='0';
    $status_add ='0';
    $status_edit ='0';
    $status_delete ='0';
    foreach ($_SESSION["application_page_status"] as $page_id) {
        if($page_id["page_id"]=="3"){
            $status_view =$page_id["page_view"];
            $status_add =$page_id["page_add"];
            $status_edit =$page_id["page_edit"];
            $status_delete =$page_id["page_delete"];
        }
    }
    
    if($status_view==0) {
        $dbh = null;
        header('Location: logout.php');
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

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
	.table thead th:first-child.sorting:after {
      content: "";
    }
    .table thead th:first-child, .table tbody td:first-child {
      text-align: center;
    }
    table.dataTable thead>tr>th:first-child.sorting_asc,
    table.dataTable thead>tr>th:first-child.sorting_desc,
    table.dataTable thead>tr>th:first-child.sorting,
    table.dataTable thead>tr>td:first-child.sorting_asc,
    table.dataTable thead>tr>td:first-child.sorting_desc,
    table.dataTable thead>tr>td:first-child.sorting {
        padding: 0 4px;
    }

    .btn-primary:disabled {
        color: #fff;
        background-color: #999ba3;
        border-color: #999ba3;
    }
    .btn-primary:disabled:hover {
        color: #fff;
        background-color: #999ba3;
        border-color: #999ba3;
        cursor: not-allowed; 
    }


    th.freeze-col, td.freeze-col {
        position: -webkit-sticky; /* Safari */
        position: sticky;
        left: 0;
        background-color: #ffffff; /* พื้นหลังเป็นสีขาว */
        z-index: 1000; /* ใช้ค่า z-index สูงเพื่อให้แน่ใจว่าคอลัมน์ที่ตรึงอยู่ด้านบน */
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* เพิ่มเงาเพื่อแยกคอลัมน์ */
    }

    th.freeze-col, td.freeze-col {
    width: 150px; /* กำหนดความกว้างที่ชัดเจน */
    }

    table thead th.freeze-col, table tbody td.freeze-col {
        background-color: #ffffff; /* พื้นหลังเป็นสีขาว */
        position: -webkit-sticky; /* Safari */
        position: sticky;
        left: 0;
        z-index: 1000; /* ใช้ค่า z-index สูงเพื่อให้แน่ใจว่าคอลัมน์ที่ตรึงอยู่ด้านบน */
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* เพิ่มเงาเพื่อแยกคอลัมน์ */
    }

    table.dataTable {
        border-collapse: collapse; /* ทำให้ตารางแสดงผลดีขึ้น */
    }

    thead th, tbody td {
        background-color: transparent; /* ตั้งค่าเป็นโปร่งใส */
    }
</style>

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
                        <div class="panel-title" style="display: inline-block;" >
                            <h2 class="title m-5" style="color: #102958;">Overdue Policies</h2>
                        </div>
                        
                        <div class="row pull-right">
                            <div class="text-right">
                                <div class="row">
                                <?php if($status_edit==1){ ?>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inputModal" id="openPopupStatus" disabled>
                                            Update Policy Status
                                        </button>
                                        &nbsp;&nbsp;
                                <?php } ?>

    <div class="dropdown pl-1 mr-3">
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
                            <div class="table-responsive" style="font-size: 13px;">
                                <!-- width="2000px"  -->
                                <!-- style="width:300%;" table-striped width="2500px-->
                                <table id="example"  class="table table-bordered "  style="color: #969FA7;" >
                                    <thead >
                                        <tr style="color: #102958;" >
                                            <th width="20px" style="background-color: #ffffff !important;" style="color: #102958;" style="color: #102958;" class="freeze-col">
                                                <input type="checkbox" id="select-all">
                                            </th>
                                            <th width="20px" style="background-color: #ffffff !important;" style="color: #102958;" style="color: #102958;" class="freeze-col">#</th>
                                            <th width="250px" style="background-color: #ffffff !important;" style="color: #102958;" style="color: #102958;" class="freeze-col">Policy no.</th>

                                            <th hidden="tue" >ID</th>
                                            <th width="300px" style="color: #102958;">Cust. name</th>
                                            <th width="200px" style="color: #102958;">Partner company</th>

                                            <th width="200px" style="color: #102958;">Prod.</th>
                                            <th width="50px" style="color: #102958;">Status</th>
                                            
                                           <!--  <th width="100px" style="color: #102958;" >Cust. Mobile</th>
                                            <th width="240px" style="color: #102958;">Cust. Email</th> -->

                                            <!-- <th width="80px" style="color: #102958;">Alert Date</th> -->
                                            <th width="80px" style="color: #102958;">Start Date</th>
                                            <th width="80px" style="color: #102958;">End Date</th>

                                            <th width="50px" style="color: #102958;">Symbol</th>
                                            <th width="100px" style="color: #102958;">Amount of premium</th>
                                            <th width="100px" style="color: #102958;">Premium Conv.(฿THB)</th>
                                            <th width="70px" style="color: #102958;">Paid Date</th>

                                            <th width="100px" style="color: #102958;" >Agent/Customer</th>

                                            <?php if($status_edit==1){ ?>
                                            <th width="70px" style="color: #102958;">Action</th>
                                            <?php }else{ ?>
                                            <th hidden="true" ></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody style="color: #494949; font-size: 13px;" >
<?php 
    $cnt=1;
    if($list > 0){
       foreach($list as $result){ 
           $s_date = $result['start_date'];
           $start_date = $s_date->format('d-m-Y');
           $e_date = $result['end_date'];
           $end_date = $e_date->format('d-m-Y');
           $a_date = $result['paid_date_policy'];
           $alert_date = $a_date->format('d-m-Y');
?>
    <tr>
        <td style="background-color: #ffffff !important;" class="text-center">
            <input type="checkbox" class="row-checkbox">
        </td>
        <td style="background-color: #ffffff !important;" class="text-center"><?php echo $cnt;?></td>
        <td style="background-color: #ffffff !important;"><?php echo $result['policy_no'];?></td>
        <td hidden="tue" class="policy-id" ><?php echo $result['id_policy'];?></td>

        <td><?php echo ($result['customer_type']=="Corporate") ? $result['company_name'] : $result['customer_name']; ?></td>
        <td><?php echo $result['insurance_company'];?></td>

        <td><?php echo $result['product_name_in'];?></td>
        <td class="text-center"><?php echo $result['insurance_status'];?></td>
        
       <!--  <td class="text-center"><?php echo $result['mobile'];?></td>
        <td><?php echo $result['email_cus'];?></td> -->

        <!-- <td class="text-center"><?php echo $alert_date;?></td> -->
        <td class="text-center"><?php echo $start_date;?></td>
        <td class="text-center"><?php echo $end_date;?></td>

        <td class="text-center"><?php echo $result['currency'];?></td>
        <td class="text-right" >
            <?php   
            // if($result['currency'] !="฿THB" && $result['currency'] !="THB"){
                        echo number_format((float)$result['convertion_value'], 2, '.', ',');
            //         }else{
            //             echo "0.00";
            //         }
            ?>
        </td>
        <td class="text-right" ><?php echo number_format((float)$result['premium_rate'], 2, '.', ',');?></td>
        
        <td class="text-center"><?php echo $alert_date;?></td>
        <td><?php echo trim($result['agent_name'])." ".$result->first_name_agent." ".$result->last_name_agent;?></td>
        
        <?php if($status_edit==1){ ?>
        <td class="text-center">
        <i title="Edit Record"><a href="edit-policy.php?id=<?php echo $result['id_insurance'];?>">
 <svg width="20" height="20" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
</svg>
                                                </a></i> &nbsp;&nbsp;                                                 
        </td>
        <?php }else{ ?>
        <td hidden="true" ></td>
        <?php } ?>

                                        </tr>
<?php $cnt++;}} ?>     
                  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

<script>
        $(document).ready(function() {
            const selectAllCheckbox = $('#select-all');
            const rowCheckboxes = $('.row-checkbox');
            const openPopupStatus = $('#openPopupStatus');

            selectAllCheckbox.on('change', function() {
                rowCheckboxes.prop('checked', this.checked);
                togglePopupButton();
            });

            rowCheckboxes.on('change', function() {
                if (!this.checked) {
                    selectAllCheckbox.prop('checked', false);
                } else if (rowCheckboxes.length === rowCheckboxes.filter(':checked').length) {
                    selectAllCheckbox.prop('checked', true);
                }
                togglePopupButton();
            });

            $('#submitPopup').on('click', function() {
                // document.getElementById("loading-overlay").style.display = "flex";
                const selectedCheckboxes = rowCheckboxes.filter(':checked').map(function() {
                    return $(this).closest('tr').find('.policy-id').text();
                }).get();

                const inputData = $('#status').val();
                const textarea = $('#textarea').val();
                if (selectedCheckboxes.length > 0 && inputData) {
                    $.ajax({
                        type: 'POST',
                        url: 'edit_status_policy.php', // Replace with the path to your PHP file
                        data: {
                            selectedCheckboxes: selectedCheckboxes,
                            inputData: inputData,
                            textarea: textarea
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                alert('Submitted Successfully edited status.');
                                // alert('Data submitted successfully! Selected IDs: ' + response.selectedIds.join(', '));
                                // $('#inputModal').modal('hide');
                                window.location.href = 'entry-policy.php';
                            } else {
                                alert('Error: ' + response.message);
                                $('#inputModal').modal('hide');
                            }
                        },
                        error: function() {
                            alert('Error submitting data.');
                        }
                    });
                } else {
                    alert('Please select status.');
                }
            });

            function togglePopupButton() {
                if (rowCheckboxes.filter(':checked').length > 0) {
                    openPopupStatus.prop('disabled', false);
                } else {
                    openPopupStatus.prop('disabled', true);
                }
            }

        });

        function ClickChange() {
            var status = document.getElementById('status').value;
            var reasonContainer = document.getElementById('reasonContainer');
            
            if (status === 'Not renew') {
                reasonContainer.style.display = 'block';
            } else {
                reasonContainer.style.display = 'none';
            }
        }
    </script>

<div class="modal fade"  id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel" aria-hidden="true">
            <div class="modal-dialog d-flex align-items-center justify-content-center" role="document">
                <div class="modal-content" style="width: 500px;" >
                    <div class="modal-header" >
                        <div class="col-sm-12 px-3" class="text-left" >
                            Edit Policy Status 
                        </div>
                    </div>
                    <div class="modal-body" >
                        <form id="popupForm">
                            <div class="form-group">
                                <label for="inputData">Status Policy:</label>
                                <select id="status" name="status" onchange="ClickChange()" style="border-color:#102958; color: #000;" class="form-control" required >
                                    <option value="">Select Status</option>
                                    <option value="New">New</option>
                                    <option value="Follow up">Follow up</option>
                                    <option value="Renew">Renew</option>
                                    <option value="Wait" >Wait</option>
                                    <option value="Not renew">Not renew</option>
                                </select>
                            </div>
                             <div id="reasonContainer" style="display: none;">
                                <label style="color: #102958;" for="textarea" id="reasonLabel">Reason:</label>
                                <textarea class="form-control" id="textarea" name="textarea" rows="5" placeholder="Cancellation reason"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="submitPopup">Submit</button>
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
    <!-- <script src="assets/js/custom.js"></script> -->
       
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>


    <script>
    $(document).ready(function(){

        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "date-dd-mmm-yyyy-pre": function(a) {
                return moment(a, 'DD-MM-YYYY').unix();
            },
            "date-dd-mmm-yyyy-asc": function(a, b) {
                return a - b;
            },
            "date-dd-mmm-yyyy-desc": function(a, b) {
                return b - a;
            }
        });

    var table = $('#example').DataTable({
         "columnDefs": [
                { 
                    "targets": [6,7,11],
                    "type": "date-dd-mmm-yyyy"
                }
            ],
        scrollY: 400, // ตั้งค่าความสูงที่คุณต้องการให้แถวแรก freeze
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            fixedColumns: {
                leftColumns: 3 // จำนวนคอลัมน์ที่คุณต้องการให้แถวแรก freeze
            },
        // scrollX: true,
        lengthMenu: [[10, 25, 50, 100, -1], [10,25, 50, 100, "All"]],
        "scrollCollapse": true,
        "paging":         true,
        buttons: [
            { extend: 'csv',class: 'buttons-csv',className: 'btn-primary',charset: 'UTF-8',filename: 'Overdue Policies',bom: true
            ,
            exportOptions: {
                columns: function ( idx, data, node ) {
                    var numColumns = table.columns().header().length;
                    return (idx > 1 && idx < numColumns - 1) ? true : false; // Exclude the first and last columns from export
                }
            },
            init : function(api,node,config){ $(node).hide();} },
            { extend: 'excel',class: 'buttons-excel', className: 'btn-primary',charset: 'UTF-8',filename: 'Overdue Policies',bom: true 
            ,
            exportOptions: {
                columns: function ( idx, data, node ) {
                    var numColumns = table.columns().header().length;
                    return (idx > 1 && idx < numColumns - 1) ? true : false; // Exclude the first and last columns from export
                }
            },
            init : function(api,node,config){ $(node).hide();} },
            { extend: 'pdf',class: 'buttons-pdf',className: 'btn-primary',charset: 'UTF-8',filename: 'Overdue Policies',bom: true 
            ,
            exportOptions: {
                columns: function ( idx, data, node ) {
                    var numColumns = table.columns().header().length;
                    return (idx > 1 && idx < numColumns - 1) ? true : false; // Exclude the first and last columns from export
                }
            },
            orientation: 'landscape',init : function(api,node,config){ $(node).hide();},
			customize: function(doc) {
                doc.content[1].table.widths = [
                    '3%',
                    '10%',
                    '10%',
                    '15%',
                    '15%',
                    '5%',
                    '5%',
                    '5%',
                    '5%',
                    '7%',
                    '7%',
                    '5%',
                    '10%'
                ];

				// Loop through all rows and cells to align text to the right
				doc.content.forEach(function(item) {
					if (item.table) {
						item.table.body.forEach(function(row) {
							row.forEach(function(cell, i) {
								if (typeof cell === 'object' && cell.text !== undefined) {
									if (i > 0) { // Skip first column (index 0)
										cell.alignment = 'right';
									}
								}
							});
						});
					}
				});
			}},
            { extend: 'print',class: 'buttons-print',className: 'btn-primary',charset: 'UTF-8',bom: true 
            ,
            exportOptions: {
                columns: function ( idx, data, node ) {
                    var numColumns = table.columns().header().length;
                    return (idx > 1 && idx < numColumns - 1) ? true : false; // Exclude the first and last columns from export
                }
            },
            customize: function (win) {
                var css = `
                    @page { size: landscape; }
                    table { width: 100%; table-layout: fixed; }
                    th, td { word-wrap: break-word; white-space: normal; }
                    th:nth-child(1), td:nth-child(1) { width: 3%; }
                    th:nth-child(2), td:nth-child(2) { width: 10%; }
                    th:nth-child(3), td:nth-child(3) { width: 10%; }
                    th:nth-child(4), td:nth-child(4) { width: 15%; }
                    th:nth-child(5), td:nth-child(5) { width: 15%; }
                    th:nth-child(6), td:nth-child(6) { width: 5%; }
                    th:nth-child(7), td:nth-child(7) { width: 5%; }
                    th:nth-child(8), td:nth-child(8) { width: 5%; }
                    th:nth-child(9), td:nth-child(9) { width: 5%; }
                    th:nth-child(10), td:nth-child(10) { width: 7%; }
                    th:nth-child(11), td:nth-child(11) { width: 7%; }
                    th:nth-child(12), td:nth-child(12) { width: 5%; }
                    th:nth-child(13), td:nth-child(13) { width: 10%; }
                `,
                head = win.document.head || win.document.getElementsByTagName('head')[0],
                style = win.document.createElement('style');

                style.type = 'text/css';
                style.media = 'print';
                if (style.styleSheet) {
                  style.styleSheet.cssText = css;
                } else {
                  style.appendChild(win.document.createTextNode(css));
                }

                head.appendChild(style);

                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
            },
            init : function(api,node,config){ $(node).hide();} }
            ]
    });

     $('#btnCsv').on('click',function(){
        table.button('.buttons-csv').trigger();
    });

    $('#btnExcel').on('click',function(){
        table.button('.buttons-excel').trigger();
    });

    $('#btnPdf').on('click',function(){
        table.button('.buttons-pdf').trigger();
    });

    $('#btnPrint').on('click',function(){
        table.button('.buttons-print').trigger();
    });

    table.buttons().container()
    .appendTo('#example_wrapper .col-md-6:eq(0)');

    });
    </script>
        
    <?php include('includes/footer.php');?>
</body>

</html>

<?php sqlsrv_close($conn); ?>
