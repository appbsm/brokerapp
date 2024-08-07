<?php
	include('includes/config.php');
    
	if(strlen($_SESSION['alogin'])==""){
        $dbh = null;
		header("Location: index.php"); 
	}else{
	//For Deleting the notice

    $status_view ='0';
    $status_add ='0';
    $status_edit ='0';
    $status_delete ='0';
    foreach ($_SESSION["application_page_status"] as $page_id) {
        // echo "page_view:".$page_id["page_id"]."page_view:".$page_id["page_add"]. "<br>";
        if($page_id["page_id"]=="1"){
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

	$sql = " SELECT cl.currency,ip.insurance_company AS insurance_company_in,pr.product_name AS product_name_in,cu.mobile AS mobile_customer,cu.tel AS tel_customer,cu.email AS email_customer,insu.status AS status_insurance 
		 ,CASE WHEN cu.customer_type = 'Personal'
		  THEN CONCAT(cu.first_name,' ',cu.last_name)
		  ELSE cu.company_name
		  END as full_name

		 ,ag.title_name AS title_name_agent,ag.first_name AS first_name_agent,ag.last_name AS last_name_agent 
		 ,insu.id AS id_insurance,FORMAT(start_date, 'dd-MM-yyyy') AS start_date_day 
		 ,FORMAT(end_date, 'dd-MM-yyyy') AS end_date_day
         ,FORMAT(paid_date, 'dd-MM-yyyy') AS paid_date_day
         ,insu.* 
		  from insurance_info insu 
		 left JOIN rela_customer_to_insurance re_ci ON re_ci.id_insurance_info = insu.id 
		 left JOIN customer cu ON cu.id = re_ci.id_customer 
		 left JOIN agent ag ON ag.id = insu.agent_id 
		 LEFT JOIN product pr ON pr.id = insu.product_id
		 LEFT JOIN insurance_partner ip ON ip.id = insu.insurance_company_id
         LEFT JOIN currency_list cl ON cl.id = ip.id_currency_list

          INNER JOIN (
    SELECT 
        policy_no, MAX(insurance_info.cdate) AS max_cdate
    FROM 
        insurance_info
    GROUP BY 
        policy_no
    ) latest ON insu.policy_no = latest.policy_no AND insu.cdate = latest.max_cdate
    where insu.policy_no != ''";

    if (isset($_POST['start_date']) && $_POST['start_date'] != '') {
        $sql = $sql." and insu.start_date >= '".date("Y-m-d", strtotime($_POST['start_date']))."' ";

        if (isset($_POST['end_date']) && $_POST['end_date'] != '') {
            $sql = $sql." and insu.start_date <= '".date("Y-m-d", strtotime($_POST['end_date']))."' ";
        }
    }

    if (isset($_POST['status']) && $_POST['status'] != '') {
        $sql = $sql." and insu.status = '".$_POST['status']."' ";
    }
    if (isset($_POST['customer']) && $_POST['customer'] != '') {
        $sql = $sql." and cu.id = '".$_POST['customer']."' ";
    }
    if (isset($_POST['partner']) && $_POST['partner'] != '') {
        $sql = $sql." and ip.id = '".$_POST['partner']."' ";
    }
    if (isset($_POST['product']) && $_POST['product'] != '') {
        $sql = $sql." and pr.id = '".$_POST['product']."' ";
    }
    

	$sql = $sql." ORDER BY insu.cdate desc ";

    // print($sql);
    // INNER JOIN (
    // SELECT 
    //     policy_primary, MAX(cdate) AS max_cdate
    // FROM 
    //     insurance_info
    // GROUP BY 
    //     policy_primary
    // ) latest ON insu.policy_primary = latest.policy_primary AND insu.cdate = latest.max_cdate

        // ORDER BY LTRIM(insu.policy_no) asc ";
		   // WHERE insu.default_insurance = 1
	$query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);

    $sql = "select DISTINCT(c.id),c.customer_type "
        . ",CASE WHEN c.customer_type = 'Personal' "
        . " THEN CONCAT(c.title_name, ' ', c.first_name, ' ', c.last_name) "
        . " ELSE company_name "
        . " END as customer_name "
        . ", c.last_name, c.first_name "
        . "from insurance_info ii "
        . "left join rela_customer_to_insurance rci on rci.id_insurance_info = ii.id "
        . "left join customer c on c.id = rci.id_customer "
        . "where c.id IS NOT NULL "
        . "order by c.last_name, c.first_name ";
    $query = $dbh->prepare($sql);
    $query->execute();
    $customers_list = $query->fetchAll(PDO::FETCH_OBJ);

    $sql = "select * from insurance_partner where status = 1 order by insurance_company ASC ";
    $query = $dbh->prepare($sql);
    $query->execute();
    $partners_list = $query->fetchAll(PDO::FETCH_OBJ);

    $sql = "select * from product order by id ASC ";
    $query = $dbh->prepare($sql);
    $query->execute();
    $products_list = $query->fetchAll(PDO::FETCH_OBJ);
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

	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
	<link   href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	<script src="js/DataTables/datatables.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/css/bootstrap-datetimepicker.min.css">

</head>

<style>
	.table th {
        vertical-align: middle !important;
		text-align: center !important;
    }
	
	.table thead th.sorting:after,
	.table thead th.sorting_asc:after,
	.table thead th.sorting_desc:after {
		top: 20px;
	}
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
                        <li class="active" >Entry Policy</li>
                    </ul>
                </div>
            </div>
        </div>
            <div class="container-fluid">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <div class="panel-title" style="display: inline-block;" >
                             <h2 class="title m-5" style="color: #102958;">Entry Policy</h2>
                        </div>
                        
                        <div class="row pull-right" style="display: inline-block;">
                            <div class="text-right" style="margin: 5px;">

                                <div class="row">
                                    
                                    <?php if($status_add==1){ ?>
                                    <a href="add-policy.php" class="btn btn-primary" style="color:#F9FAFA;" >
                                        <svg  width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
      <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
      <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                        </svg>
                                        <span class="text">Add New Policy</span>
                                    </a>  
                                     &nbsp;&nbsp;

                                    <?php } ?>

                                    <?php if($status_edit==1){ ?>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inputModal" id="openPopupStatus" disabled>
                                            Update Policy Status
                                        </button>
                                        &nbsp;&nbsp;
                                    <?php } ?>

                                    <div class="dropdown pl-1 pr-3">
                                      <button class="btn btn-primary mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Export
                                      </button>

                                      <div class="dropdown-menu col-xs-1" style="width: 300px !important;" aria-labelledby="dropdownMenuButton" >
                                        <a href="#" class="dropdown-item" id="btnCsv" style="font-size: 15px;" >CSV</a>
                                        <a href="#" class="dropdown-item" id="btnExcel" style="font-size: 15px;" >Excel</a>
                                        <a href="#" class="dropdown-item" id="btnPdf" style="font-size: 15px;" >PDF</a>
                                        <a href="#" class="dropdown-item" id="btnPrint" style="font-size: 15px;" >Print</a>
                                      </div>
                                    </div>

                                   <!--  <div class="pl-1 pr-3">
                                    <a href="entry-policy-import-backup.php" class="btn btn-primary" style="color:#F9FAFA;" >
                                    <svg width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                                      <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5"/>
                                      <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
                                    </svg>
                                    <span class="text">Import File</span>
                                    </a>
                                    </div> -->

                                </div>

                            </div>
                        </div>


                    <form method="post" action="entry-policy.php"  >
                        <div class="form-group row col-md-12 mb-4 mt-4">
                            <label style="color: #102958;"  class="col-md-2 label_left">From Date:</label>
                            <div class="col-md-2">
                                <?php //echo ($_GET['date_from'] != '') ? date('Y-m-d', strtotime($_GET['date_from'])) : '';?>
                                <input  style="color: #000;border-color:#102958; text-align: center;" type="test" name="start_date" class="form-control" id="start_date" value="<?php 
                                    if($_POST['start_date'] != ''){
                                        echo date('d-m-Y', strtotime($_POST['start_date']));
                                    }
                                ?>" placeholder="dd-mm-yyyy">
                            </div>

                            <label style="color: #102958;"  class="col-md-2 label_left">End Date:</label>
                            <div class="col-md-2">
                                <input  style="color: #000;border-color:#102958; text-align: center;" type="test" name="end_date" class="form-control" id="end_date" value="<?php echo ($_POST['end_date'] != '') ? date('d-m-Y', strtotime($_POST['end_date'])) : '';?>" placeholder="dd-mm-yyyy">
                            </div>

                            <label style="color: #102958;" class="col-md-2 label_left">Status:</label>
                            <div class="col-md-2">
                <select id="status" name="status" style="border-color:#102958; color: #000;" class="remove-example form-control selectpicker" data-live-search="true" >
                    <option value="" >All</option>
                    <option value="New" <?php echo  ($_POST['status']== "New") ? 'selected' : '';?>>New</option>
                    <option value="Follow up" <?php echo  ($_POST['status']== "Follow up") ? 'selected' : '';?>>Follow up</option>
                    <option value="Renew" <?php echo  ($_POST['status']== "Renew") ? 'selected' : '';?>>Renew</option>
                    <option value="Wait" <?php echo  ($_POST['status']== "Wait") ? 'selected' : '';?>>Wait</option>
                    <option value="Not renew" <?php echo  ($_POST['status']== "Not renew") ? 'selected' : '';?>>Not renew</option>  
                </select>                        
                            </div>

                        </div>

                        <div class="form-group row col-md-12 mb-4 ">
                            <label style="color: #102958;" class="col-md-2 label_right">Cust. name:</label>
                            <div class="col-md-2">
                               
                                <select id="customer" name="customer" style="border-color:#102958; color: #000;" class="remove-example form-control selectpicker" data-live-search="true" >
                                    <option value="">All</option>
                                    <?php foreach ($customers_list as $value) { ?>
                                        <option value="<?php echo $value->id; ?>" 
                                            <?php if ($value->id==$_POST['customer']) { echo 'selected="selected"'; } ?>
                                            ><?php echo trim($value->customer_name); ?>
                                        </option>
                                    <?php } ?>    
                                </select>                        
                            </div>

                            <label style="color: #102958;"  class="col-md-2 label_left">Partners:</label>
                            <div class="col-md-2">
                                <select  id="partner" name="partner" style="border-color:#102958; color: #000;" class="form-control selectpicker" data-live-search="true" >
                                    <option value="">All</option>
                                    <?php foreach ($partners_list as $value) { ?>
                                    <option value="<?php echo $value->id;?>" <?php echo  ($_POST['partner'] == $value->id) ? 'selected' : '';?>><?php echo $value->insurance_company;?></option>
                                    <?php } ?>
                                </select>
                                
                            </div>

                            <label style="color: #102958;" class="col-md-2 label_left">Prod.:</label>
                            <div class="col-md-2">
                               
                                <select id="product" name="product" value="<?php echo $customer; ?>" style="border-color:#102958; color: #000;" class="remove-example form-control selectpicker" data-live-search="true" >
                                    <option value="">All</option>
                                    <?php //echo $value['id']; ?>
                                    <?php foreach ($products_list as $value) { ?>
                                        <option value="<?php echo $value->id; ?>" 
                                            <?php if ($value->id==$_POST['product']) { echo 'selected="selected"'; } ?>
                                            ><?php echo trim($value->product_name); ?>
                                        </option>
                                    <?php } ?>    
                                </select>                        
                            </div>
                        </div>

                        <div class="row pull-left">                    
                            &nbsp;&nbsp;<button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  ">Search<span class="btn-label btn-label-right"><i class="fa "></i></span>
                            </button>  
                        </div>


                    </form>

                </div>

<script>
    var emptyPost = "<?php echo (empty($_POST) ? 'true' : 'false'); ?>";
    if (emptyPost === 'false') {
        var startDate = "<?php echo $_POST['start_date']; ?>";
        if(startDate === ""){
            var currentDate = new Date();
            var formattedDate = (currentDate.getDate() < 10 ? '0' : '') + currentDate.getDate() + '-' + ((currentDate.getMonth() + 1) < 10 ? '0' : '') + (currentDate.getMonth() + 1) + '-' + currentDate.getFullYear();
            $('#start_date').val(formattedDate);
        }
        var endDate = "<?php echo $_POST['end_date']; ?>";
        if(endDate === ""){
            var currentDate = new Date();
            var formattedDate = (currentDate.getDate() < 10 ? '0' : '') + currentDate.getDate() + '-' + ((currentDate.getMonth() + 1) < 10 ? '0' : '') + (currentDate.getMonth() + 1) + '-' + currentDate.getFullYear();
            $('#end_date').val(formattedDate);
        }
    }else{
        // var currentDate = new Date();
        //     var formattedDate = (currentDate.getDate() < 10 ? '0' : '') + currentDate.getDate() + '-' + ((currentDate.getMonth() + 1) < 10 ? '0' : '') + (currentDate.getMonth() + 1) + '-' + currentDate.getFullYear();
        //     $('#start_date, #end_date').val(formattedDate);
        var currentDate = new Date();
        var startOfYear = new Date(currentDate.getFullYear(), 0, 1); // วันแรกของปีปัจจุบัน
        var endOfYear = new Date(currentDate.getFullYear(), 11, 31); // วันสุดท้ายของปีปัจจุบัน

        function formatDate(date) {
            return (date.getDate() < 10 ? '0' : '') + date.getDate() + '-' + ((date.getMonth() + 1) < 10 ? '0' : '') + (date.getMonth() + 1) + '-' + date.getFullYear();
        }

        $('#start_date').val(formatDate(startOfYear));
        $('#end_date').val(formatDate(endOfYear));
    }

  $(document).ready(function(){
    $('#start_date').datepicker({
      format: 'dd-mm-yyyy',
      language: 'en'
    });
    $('#end_date').datepicker({
      format: 'dd-mm-yyyy',
      language: 'en'
    });
  });
</script>

                        <div class="card-body" >
                            <div class="table-responsive" style="font-size: 13px;">
                                <table id="example"  class="table table-bordered "  style="color: #969FA7;"  >
                                    <thead >
                                        <tr style="color: #102958;" >
                                            <th width="20px" style="color: #102958;">
                                                <input type="checkbox" id="select-all">
                                            </th>
                                            <th width="20px" style="color: #102958;">#</th>
                                            <th width="150px" style="color: #102958;">Policy no.</th>
                                            <th hidden="tue" >ID</th>
                                            <th width="200px" style="color: #102958;">Cust. name</th>
                                            <th width="200px" style="color: #102958;">Partner company</th>
                                            <th width="250px" style="color: #102958;">Prod.</th>
                                            <th width="100px" style="color: #102958;">Remark</th>
                                            
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
    if($query->rowCount() > 0){
       foreach($results as $result){ 
?> 
    <tr>

        <td class="text-center">
            <input type="checkbox" class="row-checkbox">
        </td>
       
        <td class="text-center"><?php echo $cnt;?></td>
        <td><?php echo $result->policy_no;?></td>
         <td hidden="tue" class="policy-id" ><?php echo $result->id;?></td>

        <td><?php echo $result->full_name;?></td>
        <td><?php echo $result->insurance_company_in;?></td>
        <td><?php echo $result->product_name_in;?></td>
        <td><?php echo $result->remark;?></td>

        <td class="text-center"><?php echo $result->status_insurance;?></td>
        <td class="text-center"><?php echo $result->start_date_day;?></td>
        <td class="text-center"><?php echo $result->end_date_day;?></td>
        
        <td class="text-center"><?php echo $result->currency;?></td>
        <td class="text-right" >
            <?php   
            // if($result->currency !="฿THB" && $result->currency !="THB"){
                echo number_format((float)$result->convertion_value, 2, '.', ',');
                    // }else{
                    //     echo "0.00";
                    // }
            ?>
        </td>
        <td class="text-right" ><?php echo number_format((float)$result->premium_rate, 2, '.', ',');?></td>
        <td class="text-center"><?php echo $result->paid_date_day;?></td>

    
        <td><?php echo $result->first_name_agent." ".$result->last_name_agent;?></td>
        
        <?php if($status_edit==1){ ?>
            <td class="text-center">
            <i title="Edit Record"><a href="edit-policy.php?id=<?php echo $result->id_insurance;?>">
                 <svg width="20" height="20" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
                </svg>                                
            </td>
        <?php }else{ ?>
            <th hidden="true" ></th>
        <?php } ?>

<?php $cnt++;}} ?>                       


            <?php //for($x = 0; $x <= 100; $x++){ ?>
               <!--  <tr>
                <td class="text-center"><?php //echo $x;?></td>
                </tr> -->
            <?php //}  ?>

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
                                // alert('Data submitted successfully! Selected IDs: ' + response.test);
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

<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel" aria-hidden="true">
    <div class="modal-dialog d-flex align-items-center justify-content-center" role="document">
        <div class="modal-content" style="width: 500px;">
            <div class="modal-header">
                <div class="col-sm-12 px-3 text-left">
                    Edit Policy Status
                </div>
            </div>
            <div class="modal-body">
                <form id="popupForm">
                    <div class="form-group">
                        <label for="status">Status Policy:</label>
                        <select id="status" name="status" onchange="ClickChange()" style="border-color:#102958; color: #000;" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="New">New</option>
                            <option value="Follow up">Follow up</option>
                            <option value="Renew">Renew</option>
                            <option value="Wait">Wait</option>
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

    <!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script> -->

    <style>
    /*@media (min-width: 1340px){*/
        .label_left{
            max-width: 140px;
        }
        .label_right{
            max-width: 140px;
        }
    /*}*/
    </style>

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

			lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			"scrollCollapse": true,
			"paging": true,
				buttons: [
					{ 
						extend: 'csv',
						class: 'buttons-csv',
						className: 'btn-primary',
						charset: 'UTF-8',
						filename: 'Entry Policy',
						bom: true,
                        exportOptions: {
                           // columns: ':not(:first-child):not(:last-child)'
                            columns: function ( idx, data, node ) {
                                var numColumns = table.columns().header().length;
                                return (idx > 1 && idx < numColumns - 1) ? true : false; // Exclude the first and last columns from export
                            }
                        }, 
						init: function(api, node, config) { $(node).hide(); }
					},
					{ 
						extend: 'excel',
						class: 'buttons-excel',
						className: 'btn-primary',
						charset: 'UTF-8',
						filename: 'Entry Policy',
						bom: true,
                        exportOptions: {
                           // columns: ':not(:first-child):not(:last-child)'
                            columns: function ( idx, data, node ) {
                                var numColumns = table.columns().header().length;
                                return (idx > 1 && idx < numColumns - 1) ? true : false; // Exclude the first and last columns from export
                            }
                        },
						init: function(api, node, config) { $(node).hide(); }
					},
					{ 
						extend: 'pdf',
						class: 'buttons-pdf',
						className: 'btn-primary',
						charset: 'UTF-8',
						filename: 'Entry Policy',
						bom: true,
                        exportOptions: {
                            columns: function ( idx, data, node ) {
                                var numColumns = table.columns().header().length;
                                return (idx > 1 && idx < numColumns - 1) ? true : false; // Exclude the first and last columns from export
                            }
                        },
						orientation: 'landscape', // เพิ่มคุณสมบัติ orientation เป็น 'landscape'
						init: function(api, node, config) { $(node).hide(); },
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
						}
					},
					{ 
						extend: 'print',
						class: 'buttons-print',
						className: 'btn-primary',
						charset: 'UTF-8',
						bom: true,
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
						init: function(api, node, config) { $(node).hide(); }
					}
				]
			});

			$('#btnCsv').on('click', function(){
				table.button('.buttons-csv').trigger();
			});

			$('#btnExcel').on('click', function(){
				table.button('.buttons-excel').trigger();
			});

			$('#btnPdf').on('click', function(){
				table.button('.buttons-pdf').trigger();
			});

			$('#btnPrint').on('click', function(){
				table.button('.buttons-print').trigger();
			});

			table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
		});

	</script>
	

	<?php include('includes/footer.php');?>
</body>

</html>
<?php } ?>

<div id="loading-overlay">
    <img src="loading.gif" alt="Loading...">
</div>

<?php $dbh = null; ?>
