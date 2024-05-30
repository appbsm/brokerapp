<?php

include_once('includes/connect_sql.php');
session_start();
error_reporting(0);
include_once('includes/fx_alert_date.php');

if(strlen($_SESSION['alogin'])==""){  
    sqlsrv_close($conn);
    header("Location: index.php"); 
}
    
    $list = near_to_due_list($conn);
    
    $status_view ='0';
    $status_add ='0';
    $status_edit ='0';
    $status_delete ='0';
    foreach ($_SESSION["application_page_status"] as $page_id) {
        if($page_id["page_id"]=="2"){
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
                        <li class="active" >Policies Near to Due</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="panel-title" style="display: inline-block;" >
                        <h2 class="title m-5" style="color: #102958;">Policies Near to Due</h2>
                    </div>
                        
                    <div class="row pull-right">

                        <div class="text-right">
                            <div class="row">

                                <?php if($status_edit==1){ ?>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inputModal" id="openPopupStatus" disabled>
                                            Update Status Entry Policy
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

                                <!-- background-color:#102958; -->
                                <!-- <a href="add-policy.php" class="btn btn-primary" style="color:#F9FAFA;" >
                                    <svg  width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
  <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                    </svg>
                                    <span class="text">Add New Policy</span>
                                </a> -->  
                                </div>
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
                                <table id="example"  class="table table-bordered "  style="color: #969FA7;" >
                                    <thead >
                                        <tr style="color: #102958;" >
                                            <th width="20px" style="color: #102958;">
                                                <input type="checkbox" id="select-all">
                                            </th>
                                            <th width="20px" style="color: #102958;">#</th>
                                            <th hidden="tue" >ID</th>
                                            <th width="150px" style="color: #102958;">Policy no.</th>
                                            <th width="200px" style="color: #102958;">Cust. name</th>
                                            <th width="200px" style="color: #102958;">Partner company</th>
                                            <th width="250px" style="color: #102958;">Prod.</th>
                                            
                                           <!--  <th width="110px" style="color: #102958;" >Cust. Mobile</th>
                                            <th width="200px" style="color: #102958;">Cust. Email</th> -->
                                            <th width="50px" style="color: #102958;">Status</th>

                                            <th width="70px" style="color: #102958;" data-field="date" data-sortable="true" data-sorter="dateSorter">Start Date</th>
                                            <th width="70px" style="color: #102958;" data-field="date" data-sortable="true" data-sorter="dateSorter">End Date</th>

                                            <th width="50px" style="color: #102958;">Symbol</th>
                                            <th width="100px" style="color: #102958;">Amount of premium</th>
                                            <th width="100px" style="color: #102958;">Premium Conv.(฿THB)</th>

                                            <th width="70px" style="color: #102958;">Paid Date</th>
                                            <th width="150px" style="color: #102958;" >Agent/Customer</th>
                                            
                                            <?php if($status_edit==1){ ?>
                                            <th width="50px" style="color: #102958;">Action</th>
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
        <td class="text-center">
            <input type="checkbox" class="row-checkbox">
        </td>
        <td class="text-center"><?php echo $cnt;?></td>
        <td hidden="tue" class="policy-id" ><?php echo $result['id_policy'];?></td>
        <td><?php echo $result['policy_no'];?></td>
        <td><?php echo ($result['customer_type']=="Corporate") ? $result['company_name'] : $result['customer_name']; ?></td>
        <td><?php echo $result['insurance_company'];?></td>
        <td><?php echo $result['product_name_in'];?></td>
        <td class="text-center"><?php echo $result['insurance_status'];?></td>

        <td class="text-center"><?php echo $start_date;?></td>
        <td class="text-center"><?php echo $end_date;?></td>

        <td class="text-center"><?php echo $result['currency'];?></td>
        <td class="text-right" >
            <?php   
                echo number_format((float)$result['convertion_value'], 2, '.', ',');
                    // if($result['currency'] !="฿THB" && $result['currency'] !="THB"){
                    //     echo number_format((float)$result['convertion_value'], 2, '.', ',');
                    // }else{
                    //     echo "0.00";
                    // }
            ?>
        </td>
        <td class="text-right" ><?php echo number_format((float)$result['premium_rate'], 2, '.', ',');?></td>
        
       <!--  <td class="text-center"><?php echo $result['mobile'];?></td>
        <td><?php echo $result['email_cus'];?></td> -->
        
        <td class="text-center"><?php echo $alert_date;?></td>
        <td><?php echo trim($result['agent_name']);?></td>
        
        <?php  if($status_edit==1){ ?>
        <td class="text-center">
        <i title="Edit Record"><a href="edit-policy.php?id=<?php echo $result['id_insurance'];?>">
 <svg width="20" height="20" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
</svg>
                                                </a></i> &nbsp;&nbsp;
                                                 <!-- <i class="fa " title="Delete this Record" ><a href="entry-policy.php?id=<?php echo $result['id_insurance'];?>" onclick="return confirm('Do you really want to delete the notice?');">
    <svg width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
</svg>
    </i>  -->

        </td>
        <?php }else{ ?>
        <td hidden="true">
        <?php } ?>   

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
                if (selectedCheckboxes.length > 0 && inputData) {
                    $.ajax({
                        type: 'POST',
                        url: 'edit_status_policy.php', // Replace with the path to your PHP file
                        data: {
                            selectedCheckboxes: selectedCheckboxes,
                            inputData: inputData
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                alert('Submitted Successfully edited status.');
                                // alert('Data submitted successfully! Selected IDs: ' + response.selectedIds.join(', '));
                                // $('#inputModal').modal('hide');
                                window.location.href = 'entry-policy-due.php';
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
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    <!-- <script src="assets/js/custom.js"></script> -->
       
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

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
                leftColumns: 1 // จำนวนคอลัมน์ที่คุณต้องการให้แถวแรก freeze
            },
        // scrollX: true,
        lengthMenu: [[10, 25, 50, 100, -1], [10,25, 50, 100, "All"]],
        "scrollCollapse": true,
        "paging":         true,
        buttons: [
            { extend: 'csv',class: 'buttons-csv',className: 'btn-primary',charset: 'UTF-8',filename: 'Policies Near to Due',bom: true
            ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
            { extend: 'excel',class: 'buttons-excel', className: 'btn-primary',charset: 'UTF-8',filename: 'Policies Near to Due',bom: true 
            ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
            { extend: 'pdf',class: 'buttons-pdf',className: 'btn-primary',charset: 'UTF-8',filename: 'Policies Near to Due',bom: true 
            ,exportOptions: {columns: ':not(:last-child)'},orientation: 'landscape',init : function(api,node,config){ $(node).hide();},
			customize: function(doc) {
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
            ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} }
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