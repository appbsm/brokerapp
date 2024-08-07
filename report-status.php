<?php
include_once('includes/connect_sql.php');
session_start();
error_reporting(0);
include_once('includes/fx_reports.php');


if(strlen($_SESSION['alogin'])==""){   
    $dbh = null;
    header("Location: index.php"); 
}

    $status_view ='0';
    $status_add ='0';
    $status_edit ='0';
    $status_delete ='0';
    foreach ($_SESSION["application_page_status"] as $page_id) {
        if($page_id["page_id"]=="32"){
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

    $customers = get_customers($conn);
    $insurance_policy = get_policy_no($conn);
    $products = get_products($conn);

    $agent_list = get_agent($conn);
    
    $data = array();
    $data['year']='';
    $data['customer'] = '';
    $data['month_from']='';
    $data['month_to']='';
    $data['policy_no']='';
    $data['product']='';
    $def_months = array(
        '1' => 'January',
        '2' => 'February',
        '3' => 'March',
        '4' => 'April',
        '5' => 'May',
        '6' => 'June',
        '7' => 'July',
        '8' => 'August',
        '9' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
    );
    $months = array();
    if ($_GET['month_from'] != '' && $_GET['month_to'] != '' && $_GET['month_from'] <= $_GET['month_to']) {
        $start = $_GET['month_from'];
        $end = $_GET['month_to'];
        do{            
            $months[] = $def_months[$start];
            $start++;
        } while($start <= $end);
    }
    else {
        $months = $def_months;
    }
    
    //$sales =  get_sales_by_customer ($conn, $data);
    
    //print_r($sales);
    $default_year = ($_GET['year'] != '') ? $_GET['year'] : date('Y') ;
    $default_month_from =($_GET['month_from'] != '') ? $_GET['month_from'] : 1 ;
    $default_month_to =($_GET['month_to'] != '') ? $_GET['month_to'] : 12 ;
    if (isset($_GET)) {       
        $data['year'] = ($_GET['year'] != '') ? date('Y-m-d', strtotime($_GET['year'])) : '';
        $data['month_from'] = ($_GET['month_from'] != '') ? $_GET['month_from'] : '';
        $data['month_to'] = ($_GET['month_to'] != '') ? $_GET['month_to'] : '';
        $data['customer'] =$_GET['customer'];
        $data['policy_no']=$_GET['policy_no'];
        $data['product']=$_GET['product'];

        $data['agent']=$_GET['agent'];
        $data['agent_type']=$_GET['agent_type'];
        //print_r($_GET);
        //$insurance_customer = get_customer_insurance ($conn);
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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
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
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>



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
                                        <!-- <li> Classes</li> -->
                                        <li class="active" >Sales By Status</li>
                                    </ul>
                                </div>
                            </div>
        </div>

            <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header">
 
                             <div class="panel-title" >
                                <h2 class="title m-5" style="color: #102958;">Report: Sales By Status
                            </div>
                        </div>

   
        <div class="panel">
            <form method="get" >
                <br>
                    <div class="form-group row col-md-12 ">
                        
                        <label style="color: #102958;" for="year" class="col-sm-2 label_left">Year:</label>
                        <div class="col-sm-2">
                            <select name="year" style="border-color:#102958; color: #000; text-align:center;" id="year" onchange="" class="form-control" >
                                <option value="all">Select Year</option>
                                <?php 
                                $today = date('Y-m-d');
                                // $start_year = date('Y', strtotime('-2 years', strtotime($today)));
                                $start_year = '2022';
                                // $end_year = date('Y', strtotime('+10 years', strtotime($today)));
                                $end_year = date('Y',strtotime($today));
                                $curr_year = $start_year;
                                $selected = '';
                               
                                do{
                                    $selected = ($default_year == $curr_year) ? 'selected' : ''; 
                                    echo '<option value="'.$curr_year.'" '.$selected.'>'.$curr_year.'</option>';
                                    $curr_year++;
                                }while($curr_year <= $end_year);
                               ?>
                            </select>                            
                        </div>
                        
                        <label style="color: #102958;" for="month" class="col-sm-2 label_left">Month From:</label>
                        <div class="col-sm-2">
                            <select name="month_from" style="border-color:#102958; color: #000;" id="month_from" onchange="" class="form-control" >
                                <option value="">Select Month</option>
                                <?php 
                                $ctr = 1;
                                $selected = '';
                                foreach ($def_months as $m) {
                                    $selected = ($default_month_from == $ctr) ? 'selected' : ''; 
                                ?>
                                <option value="<?php echo $ctr;?>" <?php echo  $selected;?>><?php echo $m;?></option>
                                <?php $ctr++; } ?>
                            </select>                            
                        </div>
                        
                        <label style="color: #102958;" for="month" class="col-sm-2 label_left">Month To:</label>
                        <div class="col-sm-2">
                            <select name="month_to" style="border-color:#102958; color: #000;" id="month_to" onchange="" class="form-control" >
                                <option value="">Select Month</option>
                                <?php 
                                $ctr = 1;
                                $selected = '';
                                foreach ($def_months as $m) {
                                    $selected = ($default_month_to == $ctr) ? 'selected' : ''; ?>
                                <option value="<?php echo $ctr;?>" <?php echo  $selected;?>><?php echo $m;?></option>
                                <?php $ctr++; } ?>
                            </select>                            
                        </div>
                        
                        
                    </div>
                    
                    
                <div class="form-group row col-md-12 ">
                    
                    <label style="color: #102958;" for="customer" class="col-sm-2 label_left">Cust. name:</label>
                        <div class="col-sm-2">
                            <select name="customer" style="border-color:#102958; color: #000;" id="customer" class="form-control selectpicker" data-live-search="true" >
                                <option value="">Select Cust.</option>
                                <?php foreach ($customers as $c) { ?>
                                <option value="<?php echo $c['id'];?>" <?php echo  ($_GET['customer'] == $c['id']) ? 'selected' : '';?>><?php echo $c['customer_name'];?></option>
                                <?php } ?>
                            </select>                            
                        </div>
                    
                    <label style="color: #102958;" for="staticEmail" class="col-sm-2 label_left">Policy no:</label>
                    <div class="col-sm-2">
                        <select name="policy_no" style="border-color:#102958; color: #000;" id="policy_no" class="form-control selectpicker" data-live-search="true">
                            <option value="">Select Policy</option>
                            <?php foreach ($insurance_policy as $p) { ?>
                            <option value="<?php echo $p['policy_no'];?>" <?php echo  ($_GET['policy_no'] == $p['policy_no']) ? 'selected' : '';?>><?php echo $p['policy_no'];?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <label style="color: #102958;" for="staticEmail" class="col-sm-2 label_left">Prod.:</label>                    
                    <div class="col-sm-2">                      
                        <select name="product" style="border-color:#102958; color: #000;" id="product" class="form-control selectpicker" data-live-search="true">
                            <option value="">Select Product</option>
                            <?php foreach ($products as $p) { ?>
                            <option value="<?php echo $p['id'];?>" <?php echo  ($_GET['product'] == $p['id']) ? 'selected' : '';?>><?php echo $p['product_name'];?></option>
                            <?php } ?>
                        </select> 
                    </div>

                </div>

                <div class="form-group row col-md-12 ">
                    <label style="color: #102958;" for="staticEmail" class="col-sm-2 label_left">Agent:</label>                    
                    <div class="col-sm-2">                      
                        <select id="agent" name="agent" style="border-color:#102958; color: #000;"  class="form-control selectpicker" data-live-search="true">
                            <option value="">Select Product</option>
                            <?php foreach ($agent_list as $value) { ?>
                            <option value="<?php echo $value['id'];?>" <?php echo  ($_GET['agent'] == $value['id']) ? 'selected' : '';?>><?php echo $value['first_name']." ".$value['last_name'];?></option>
                            <?php } ?>
                        </select> 
                    </div>
                      <label style="color: #102958;" for="staticEmail" class="col-sm-2 label_left">Agent Type:</label>                    
                    <div class="col-sm-2">
                        <select id="agent_type" name="agent_type" style="border-color:#102958; color: #000;"  class="form-control selectpicker" data-live-search="true">
                            <option value="">Select Product</option>
                            <option value="Primary" <?php echo  ($_GET['agent_type'] == "Primary") ? 'selected' : '';?> >Primary</option>
                            <option value="Sub-agent" <?php echo  ($_GET['agent_type'] == "Sub-agent") ? 'selected' : '';?> >Sub-agent</option>
                        </select> 
                    </div>
                </div>


<div class="row pull-right">                    
   
<div class="dropdown">
     <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn">Search<span class="btn-label btn-label-right"><i class="fa "></i></span>
    </button>  &nbsp;&nbsp;
  <button style="background-color: #0275d8;color: #F9FAFA;" class="btn btn-primary mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Export
  </button>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.6/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/TableExport/5.2.0/js/tableexport.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>

<!-- <button id="export-excel" class="btn btn-primary my-3">Excel</button>
<button id="export-csv" class="btn btn-primary my-3">CSV</button>
<button id="export-pdf" class="btn btn-primary my-3">PDF</button>
<button id="export-print" class="btn btn-primary my-3">Print</button> -->

  <div class="dropdown-menu col-xs-1 my-3" style="width: 50px !important;"  aria-labelledby="dropdownMenuButton" >
    <a href="#" class="dropdown-item export-csv" id="btnCsv" style="width: 50px !important;"  style="font-size: 15px;" >CSV</a>
    <a href="#" class="dropdown-item export-excel" id="btnExcel" style="width: 50px !important;"  style="font-size: 15px;" >Excel</a>
    <!-- <a href="#" class="dropdown-item export-pdf" id="btnPdf" style="font-size: 15px;" >PDF</a> -->
    <!-- <a href="#" class="dropdown-item export-print" id="btnPrint" style="font-size: 15px;" >Print</a> -->
  </div>&nbsp;&nbsp;&nbsp;

</div>
</div> 

</form> 

<script>
        document.getElementById('btnCsv').addEventListener('click', function() {
            let table = document.getElementById('example');
            let exportInstance = new TableExport(table, {
                formats: ['csv'],
                exportButtons: false
            });
            // Report sales by status
            let exportData = exportInstance.getExportData()['example']['csv'];
            // exportInstance.export2file(exportData.data, exportData.mimeType, exportData.filename, exportData.fileExtension);
            exportInstance.export2file(exportData.data, exportData.mimeType,'Report sales by status', exportData.fileExtension);
        });

// document.getElementById('btnExcel').addEventListener('click', function() {
//     // Create a new workbook
//     let wb = XLSX.utils.book_new();
 
//     // Convert the table to a worksheet
//     let ws = XLSX.utils.table_to_sheet(document.getElementById('example'));
 
//     // Define the cell style for right alignment and number format
//     const numberStyle = {
//         alignment: {
//             horizontal: "right"
//         }
//     };
 
//     // Iterate through all cells to set the type and style
//     for (const cell in ws) {
//         if (ws.hasOwnProperty(cell) && cell[0] !== '!') {
//             if (typeof ws[cell].v === 'number') {
//                 ws[cell].t = 'n'; // Set type to number
//                 if (ws[cell].v % 1 !== 0) {
//                     // Check if the number has decimals
//                     ws[cell].z = "0,000,000.00"; // Apply number format if it has decimals
//                 }
//             }
//         }
//     }
 
//     // Add the worksheet to the workbook
//     XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
 
//     // Save the workbook as an Excel file
//     XLSX.writeFile(wb, 'example.xlsx');
// });


document.getElementById('btnExcel').addEventListener('click', function() {
    // Create a new workbook
    let wb = XLSX.utils.book_new();
 
    // Convert the table to a worksheet
    let ws = XLSX.utils.table_to_sheet(document.getElementById('example'));
 
    // Define the cell style for right alignment and number format
    const numberStyle = {
        alignment: {
            horizontal: "right"
        },
        numFmt: "#,###,##0.00" // Format for comma-separated thousands and two decimal places
    };

    var check_type = "0";
    for (const cell in ws) {
        if (ws.hasOwnProperty(cell) && cell[0] !== '!') {

            if(ws[cell].v === "Amt. Premium"){
                check_type ="1";
            }

            if(ws[cell].v === "Amt. Policy"){
                check_type ="0";
            }

            if(check_type == "1"){
                if (typeof ws[cell].v === 'number') {
                    // if (ws[cell].v % 1 !== 0) {
                        ws[cell].t = 'n'; // Set type to number
                        ws[cell].z = numberStyle.numFmt; // Apply number format
                    // }
                }
            }

        }
    }

    //  for (const row in ws) {
    //     if (ws.hasOwnProperty(row) && row[0] !== '!') {
    //         const rowData = ws[row];
    //         // Check if the first cell in the row is "Amt. Premium"
    //         if (rowData && rowData.length > 0 && rowData[0] && rowData[0].v === 'Amt. Premium') {
                
    //             for (let i = 1; i < rowData.length; i++) {
    //                 const cell = rowData[i];
    //                 ws[cell].t = 'n';
    //                 ws[cell].z = numberStyle.numFmt;
    //                 // if (!isNaN(parseFloat(cell.v)) && cell.v.toString().indexOf('.') !== -1) {
    //                 //     cell.t = 'n'; // Set type to number
    //                 //     cell.z = numberStyle.numFmt; // Apply number format
    //                 // }
    //             }
    //         }
    //     }
    // }
 
    // Add the worksheet to the workbook
    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
 
    // Save the workbook as an Excel file
    XLSX.writeFile(wb, 'Report sales by status.xlsx');
});


        document.getElementById('btnPdf').addEventListener('click', function() {
            let { jsPDF } = window.jspdf;
            let doc = new jsPDF('landscape');
            let table = document.getElementById('example');
            let tableData = [];

            // Loop through table rows and push to tableData array
            let rows = table.querySelectorAll('tr');
            rows.forEach(row => {
                let rowData = [];
                let cells = row.querySelectorAll('th, td');
                cells.forEach(cell => {
                    rowData.push(cell.innerText);
                });
                tableData.push(rowData);
            });

            // Add the table to PDF with autoTable
            doc.autoTable({
                head: [tableData[0], tableData[1]],
                body: tableData.slice(2),
                styles: { halign: 'center' },
                theme: 'grid',
                didDrawPage: function (data) {
                    // Header
                    doc.setFontSize(18);
                    doc.setTextColor(40);
                    doc.text("Table Export Example", data.settings.margin.left, 10);

                    // Footer
                    let pageSize = doc.internal.pageSize;
                    let pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
                    doc.setFontSize(10);
                    doc.text('Page ' + doc.internal.getNumberOfPages(), data.settings.margin.left, pageHeight - 10);
                },
                margin: { top: 20 },
                startY: 20,
                pageBreak: 'auto', // Automatically handle page breaks
            });

            doc.save('table.pdf');
        });

        document.getElementById('btnPrint').addEventListener('click', function() {
            let printContent = document.getElementById('example').outerHTML;
            let printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title>Print Table</title>');
            printWindow.document.write('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">'); // Optional CSS
            printWindow.document.write('</head><body>');
            printWindow.document.write(printContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
</script>

        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="font-size: 13px;">
                                <!-- width="100%" -->
                                <table class="table table-bordered " id="example"  cellspacing="0" >
                                    <thead >
                                        <tr>
                                            <th rowspan="2" width="30px" >#</th>
                                            <th rowspan="2">Month</th>
                                            <th rowspan="2">Description</th>
                                            <th colspan="2" >New</th>
                                            <th colspan="2">Renew</th>
                                            <th colspan="2">Follow Up</th>
                                            <th colspan="2">Wait</th>
                                            <th colspan="3">Total Agent</th>
                                            <th colspan="3">Accumulate</th>
                                            <th colspan="3">Not Renew</th>   
                                        </tr>
                                        <tr>
                                            <th width="90px">Primary Agent</th>
                                            <th width="90px">Sub Agent</th>
                                            <th width="90px">Primary Agent</th>
                                            <th width="90px">Sub Agent</th>
                                            <th width="90px">Primary Agent</th>
                                            <th width="90px">Sub Agent</th>
                                            <th width="90px">Primary Agent</th>
                                            <th width="90px">Sub Agent</th>

                                            <th width="90px">Primary Agent</th>
                                            <th width="90px">Sub Agent</th>
                                            <th width="90px">Total Agent</th>

                                            <th width="90px">Primary Agent</th>
                                            <th width="90px">Sub Agent</th>
                                            <th width="90px">Total Accumulate</th>

                                            <th width="90px">Primary Agent</th>
                                            <th width="90px">Sub Agent</th>
                                            <th width="90px">Total Not Renew</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 13px;">
                                    

                    <?php 
                                   
                        $ctr = 1;
                        // $year = 2024;

                        $year = date('Y');
                        // echo "_POST".$_GET['year'];
                        if ($_GET['year'] == 'all' or $_GET['year']=="" ) {
                           $year = date('Y');  
                        }else{
                           $year = $_GET['year']; 
                        }
                        // echo ":year:".$year;
                        // $total_new = 0;
                        // $total_renew = 0;
                        // $total_not_renew = 0;
                        // $total_subagent = 0;
                        // $total_total = 0;
                        $total_acc_pri = 0;
                        $total_acc_sub = 0;
                        $total_acc = 0;

                        $total_acc_policy_pri = 0;
                        $total_acc_policy_sub = 0;
                        $total_acc_policy = 0;

                        $total_all_new_pri = 0;
                        $total_all_new_sub = 0;
                        $total_all_renew_pri = 0;
                        $total_all_renew_sub = 0;
                        $total_all_follow_pri = 0;
                        $total_all_follow_sub = 0;
                        $total_all_wait_pri = 0;
                        $total_all_wait_sub = 0;
                        $total_all_agent_pri = 0;
                        $total_all_agent_sub = 0;
                        $total_all_agent = 0;

                        $total_all_acc_pri = 0;
                        $total_all_acc_sub = 0;
                        $total_all_acc = 0;
                        $total_all_not_pri = 0;
                        $total_all_not_sub = 0;
                        $total_all_sub = 0;

                        foreach ($months as $m) {
                            $total_agent =0;
                            $total_agent_policy =0;
                            $total_not =0;
                            $total_not_policy =0;

                            $pos = array_search($m, $def_months);
                            $value_s = get_sales_monthly_status($conn, $data, $pos, $year);
                            // $renew = get_sales_monthly ($conn, $data, $pos, $year);
                            // $not_renew = get_not_renew_monthly ($conn, $data, $ctr, $year);
                            // $subagent = get_subagent_monthly($conn, $data, $ctr, $year);
                            // $total = $new[0]['total_sales'] + $renew[0]['total_sales'] ;
                            // $accumurate += $new[0]['total_sales'] + $renew[0]['total_sales'];
                            // + $subagent[0]['total_sales']
                            $total_agent = $value_s[0]['total_pri'] + $value_s[0]['total_sub'];
                            $total_agent_policy = $value_s[0]['total_policy_pri'] + $value_s[0]['total_policy_sub'];

                            $total_not = $value_s[0]['total_not_pri'] + $value_s[0]['total_not_sub'];
                            $total_not_policy = $value_s[0]['total_not_policy_pri'] + $value_s[0]['total_not_policy_sub'];

                            $total_acc_pri = $total_acc_pri + $value_s[0]['total_pri'];
                            $total_acc_sub = $total_acc_sub + $value_s[0]['total_sub'];
                            $total_acc = $total_acc_pri + $total_acc_sub;

                            $total_acc_policy_pri = $total_acc_policy_pri + $value_s[0]['total_policy_pri'];
                            $total_acc_policy_sub = $total_acc_policy_sub + $value_s[0]['total_policy_sub'];
                            $total_acc_policy = $total_acc_policy_pri + $total_acc_policy_sub;

                            $total_all_new_pri = $total_all_new_pri + $value_s[0]['total_new_pri'];
                            $total_all_new_sub = $total_all_new_sub + $value_s[0]['total_new_sub'];
                            $total_all_renew_pri = $total_all_renew_pri + $value_s[0]['total_renew_pri'];
                            $total_all_renew_sub = $total_all_renew_sub + $value_s[0]['total_renew_sub'];
                            $total_all_follow_pri = $total_all_follow_pri + $value_s[0]['total_follow_pri'];
                            $total_all_follow_sub = $total_all_follow_sub + $value_s[0]['total_follow_sub'];
                            $total_all_wait_pri = $total_all_wait_pri + $value_s[0]['total_wait_pri'];
                            $total_all_wait_sub = $total_all_wait_sub + $value_s[0]['total_wait_sub'];
                            $total_all_agent_pri = $total_all_agent_pri + $value_s[0]['total_pri'];
                            $total_all_agent_sub = $total_all_agent_sub + $value_s[0]['total_sub'];
                            $total_all_agent = $total_all_agent + $total_agent;
                            $total_all_not_pri = $total_all_not_pri + $value_s[0]['total_not_pri'];
                            $total_all_not_sub = $total_all_not_sub + $value_s[0]['total_not_sub'];
                            $total_all_sub = $total_all_sub + $total_not;
                            ?> 

                        <tr>
                            <td class="text-center"><?php echo $ctr;?></td>
                            <td><?php echo $m;?></td>
                            <td>Amt. Policy</td>
                            <td class="text-right"><?php echo $value_s[0]['total_new_policy_pri']; ?></td>
                            <td class="text-right"><?php echo $value_s[0]['total_new_policy_sub'];?></td>
                            <td class="text-right"><?php echo $value_s[0]['total_renew_policy_pri'];?></td>     
                            <td class="text-right"><?php echo $value_s[0]['total_renew_policy_sub'];?></td>  
                            <td class="text-right"><?php echo $value_s[0]['total_follow_policy_pri'];?></td>   
                            <td class="text-right"><?php echo $value_s[0]['total_follow_policy_sub'];?></td>     
                            <td class="text-right"><?php echo $value_s[0]['total_wait_policy_pri'];?></td>
                            <td class="text-right"><?php echo $value_s[0]['total_wait_policy_sub'];?></td>
                            <td class="text-right"><?php echo $value_s[0]['total_policy_pri'];?></td>
                            <td class="text-right"><?php echo $value_s[0]['total_policy_sub'];?></td>
                            <td class="text-right"><?php echo $total_agent_policy;?></td>

                            <td class="text-right"><?php echo $total_acc_policy_pri;?></td>
                            <td class="text-right"><?php echo $total_acc_policy_sub;?></td>
                            <td class="text-right"><?php echo $total_acc_policy;?></td>
                            
                            <td class="text-right"><?php echo $value_s[0]['total_not_policy_pri'];?></td>
                            <td class="text-right"><?php echo $value_s[0]['total_not_policy_sub'];?></td>
                            <td class="text-right"><?php echo $total_not_policy;?></td>
                        </tr>        

                        <tr>
                            <td class="text-center"><?php //echo $ctr;?></td>
                            <td><?php //echo $m;?></td>
                            <td>Amt. Premium</td>
                            <?php 
                            
                             ?>
                            <td class="text-right"><?php echo number_format($value_s[0]['total_new_pri'], 2);?></td>
                            <td class="text-right"><?php echo number_format($value_s[0]['total_new_sub'], 2);?></td>
                            <td class="text-right"><?php echo number_format($value_s[0]['total_renew_pri'], 2);?></td>     
                            <td class="text-right"><?php echo number_format($value_s[0]['total_renew_sub'], 2);?></td>  
                            <td class="text-right"><?php echo number_format($value_s[0]['total_follow_pri'], 2);?></td>   
                            <td class="text-right"><?php echo number_format($value_s[0]['total_follow_sub'], 2);?></td>     
                            <td class="text-right"><?php echo number_format($value_s[0]['total_wait_pri'], 2);?></td>
                            <td class="text-right"><?php echo number_format($value_s[0]['total_wait_sub'], 2);?></td>
                            <td class="text-right"><?php echo number_format($value_s[0]['total_pri'], 2);?></td>
                            <td class="text-right"><?php echo number_format($value_s[0]['total_sub'], 2);?></td>
                            <td class="text-right"><?php echo number_format($total_agent, 2);?></td>

                            <td class="text-right"><?php echo number_format($total_acc_pri, 2);?></td>
                            <td class="text-right"><?php echo number_format($total_acc_sub, 2);?></td>
                            <td class="text-right"><?php echo number_format($total_acc, 2);?></td>

                            <td class="text-right"><?php echo number_format($value_s[0]['total_not_pri'], 2);?></td>
                            <td class="text-right"><?php echo number_format($value_s[0]['total_not_sub'], 2);?></td>
                            <td class="text-right"><?php echo number_format($total_not, 2);?></td>
                        </tr>  
                            <?php
                                $total_new += $new[0]['total_sales'];
                                $total_renew += $renew[0]['total_sales'];
                                $total_not_renew += $not_renew[0]['total_sales'];
                                $total_subagent += $subagent[0]['total_sales'];
                                $total_total += $total; 
                                $ctr++;
                            } ?>
                                    <tr style="font-weight: bold;">
                                        
                                        <td class="text-center" >TOTAL</td>
                                        <td ></td>
                                        <td ></td>
                                        <td class="text-right"><?php echo number_format($total_all_new_pri, 2);?></td>
                                        <td class="text-right"><?php echo number_format($total_all_new_sub, 2);?></td>
                                        <td class="text-right"><?php echo number_format($total_all_renew_pri, 2);?></td>     
                                        <td class="text-right"><?php echo number_format($total_all_renew_sub, 2);?></td>  
                                        <td class="text-right"><?php echo number_format($total_all_follow_pri, 2);?></td>
                                        <td class="text-right"><?php echo number_format($total_all_follow_sub, 2);?></td>
                                        <td class="text-right"><?php echo number_format($total_all_wait_pri, 2);?></td>
                                        <td class="text-right"><?php echo number_format($total_all_wait_sub, 2);?></td>
                                        <td class="text-right"><?php echo number_format($total_all_agent_pri, 2);?></td>
                                        <td class="text-right"><?php echo number_format($total_all_agent_sub, 2);?></td>
                                        <td class="text-right"><?php echo number_format($total_all_agent, 2);?></td>

                                        <td class="text-right"><?php echo number_format($total_acc_pri, 2);?></td>
                                        <td class="text-right"><?php echo number_format($total_acc_sub, 2);?></td>
                                        <td class="text-right"><?php echo number_format($total_acc, 2);?></td>

                                        <td class="text-right"><?php echo number_format($total_all_not_pri, 2);?></td>
                                        <td class="text-right"><?php echo number_format($total_all_not_sub, 2);?></td>
                                        <td class="text-right"><?php echo number_format($total_all_sub, 2);?></td>
                                    </tr>  
                                </tbody>                                    
                            </table>
                        </div>
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

    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="js/sb-admin-2.min.js"></script>

    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <script src="js/prism/prism.js"></script>

    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>

        
    <style>
        /*@media (min-width: 1340px){*/
            .label_left{
                max-width: 140px;
            }
            .label_right{
                max-width: 140px;
            }
        /*}*/
        
        .table th {
            vertical-align: middle !important;
            text-align: center !important;
        }
        /*.table thead th.sorting:after,
        .table thead th.sorting_asc:after,
        .table thead th.sorting_desc:after {
            top: 10px;
        }*/
        
        .caret {
            right: 10px !important;
        }
        
        .btn-group>.btn:first-child {
            border-color: #102958;
        }
    </style>

<script>
$(document).ready(function(){

    var table = $('#example').DataTable({
        lengthMenu: [[100, -1], [100, "All"]],
        scrollY: 800, // ตั้งค่าความสูงที่คุณต้องการให้แถวแรก freeze
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        fixedColumns: {
            leftColumns: 2 // จำนวนคอลัมน์ที่คุณต้องการให้แถวแรก freeze
        },
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        
        "lengthChange": false,
        // "pageLength": 20,
        "order": [], //Initial no order.
        "aaSorting": [], 
        "ordering": false,
        "columnDefs": [{ 
            "targets": [ ], //first column / numbering column
            // "targets": [0, 1, 2],
            "orderable": false, //set not orderable
        }],     
        scrollX: true,
        "scrollCollapse": true,
        "paging":         true,
        
        buttons: [
            { extend: 'csv',class: 'buttons-csv',className: 'btn-primary',charset: 'UTF-8',filename: 'Report Monthly Sales',footer: true,bom: true
            ,init : function(api,node,config){ $(node).hide();} },
            { extend: 'excel',class: 'buttons-excel', className: 'btn-primary',charset: 'UTF-8',filename: 'Report Monthly Sales',footer: true,bom: true
            ,init : function(api,node,config){ $(node).hide();} },
            { extend: 'pdf',class: 'buttons-pdf',className: 'btn-primary',charset: 'UTF-8',filename: 'Report Monthly Sales',footer: true,bom: true 
            ,init : function(api,node,config){ $(node).hide();},
            customize: function(doc) {
                // Loop through all rows and cells to align text to the right
                doc.content.forEach(function(item) {
                    if (item.table) {
                        item.table.body.forEach(function(row) {
                            row.forEach(function(cell, i) {
                                if (typeof cell === 'object' && cell.text !== undefined) {
                                    if (i === 1) { // Check if it's the second column (index 1)
                                        cell.alignment = 'left'; // Align left for the second column (month)
                                    } else if (!isNaN(parseFloat(cell.text))) { // Check if it's a number
                                        cell.alignment = 'right'; // Align right for numeric columns
                                    }
                                }
                            });
                        });
                    }
                });
            }           },
            { extend: 'print',class: 'buttons-print',className: 'btn-primary',charset: 'UTF-8',footer: true,bom: true 
            ,init : function(api,node,config){ $(node).hide();} }
            ]
    });

       

    // $('#btnCsv').on('click',function(){
    //     table.button('.buttons-csv').trigger();
    // });

    // $('#btnExcel').on('click',function(){
    //     table.button('.buttons-excel').trigger();
    // });

    // $('#btnPdf').on('click',function(){
    //     table.button('.buttons-pdf').trigger();
    // });

    // $('#btnPrint').on('click',function(){
    //     table.button('.buttons-print').trigger();
    // });


    table.buttons().container()
    .appendTo('#example_wrapper .col-md-6:eq(0)');

    });    
</script>

    <?php include('includes/footer.php'); ?>
</body>

</html>

<?php sqlsrv_close($conn); ?>
<?php $dbh = null;?>