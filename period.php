<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<?php

include('includes/config.php');
session_start();
error_reporting(0);
if(strlen($_SESSION['alogin'])==""){   
	$dbh = null;
    header("Location: index.php"); 
}else{

    $status_view ='0';
    $status_add ='0';
    $status_edit ='0';
    $status_delete ='0';
    foreach ($_SESSION["application_page_status"] as $page_id) {
        if($page_id["page_id"]=="22"){
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

if($_GET['id']){
    $sql = "SELECT TOP 1 * from insurance_info WHERE period = '".$_GET['id']."'"; 
    $query = $dbh->prepare($sql);
    $query->execute();
    $results_insurance = $query->fetchAll(PDO::FETCH_OBJ);

    if(count($results_insurance)==0){
        $sql="delete from period where id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id',$_GET['id'],PDO::PARAM_STR);
        $query->execute();
		$dbh = null;
        echo '<script>alert("Deleted Success.")</script>';
        echo "<script>window.location.href ='period.php'</script>";
    }else{
		$dbh = null;
        echo '<script>alert("There is already information in the Entry Policy. The information cannot be deleted.")</script>';
        echo "<script>window.location.href ='period.php'</script>";
    }
}

 // if($_SERVER['HTTP_REFERER']){
 //    echo '<script>alert("HTTP_REFERER: '.$_SERVER['HTTP_REFERER'].'")</script>'; 
 // }
// <----------------------Add Period-------------------->

if($_SERVER['HTTP_REFERER']){

if(isset($_POST['submit'])){

$period=$_POST['period'];
$description=$_POST['description'];
$status=$_POST['status'];

$sql_check = "SELECT * from period where period='".$period."'";   
$query_check = $dbh->prepare($sql_check);
$query_check->execute();
$results_check = $query_check->fetchAll(PDO::FETCH_OBJ);

// echo '<script>alert("rowCount: '.$query_check->rowCount().'")</script>'; 
    if(is_null($active)){
        $active=0;
    }

if($query_check->rowCount() <= 0){
$sql="INSERT INTO period (period,description,status,cdate,create_by)
     VALUES(:period_p,:description_p,:status_p,GETDATE(),:create_by_p)";

$query = $dbh->prepare($sql); 
$query->bindParam(':period_p',$period,PDO::PARAM_STR);
$query->bindParam(':description_p',$description,PDO::PARAM_STR);

if($status==""){
    $status="0";
}else{
    $status="1";
}

    $query->bindParam(':status_p',$status,PDO::PARAM_STR);
    $query->bindParam(':create_by_p',$_SESSION['id'],PDO::PARAM_STR);
    $query->execute();
    // print_r($query->errorInfo());
    $lastInsertId = $dbh->lastInsertId();

if($lastInsertId){
    $msg="Period Created successfully";
    $period="";
    $active=1;
}else {
    $error="Something went wrong. Please try again";
}

}else{
    $error="Repeated period data. Please try again";
}

    $period="";
    $description="";
    // <----------------------Add Period-------------------->

}else if(isset($_POST['submit_edit'])){
    // <----------------------Edit Period-------------------->
    $id_edit=$_POST['id_edit'];
    $period_edit=$_POST['period_edit'];
    $description_table=$_POST['description_edit'];
    $stauts_table=$_POST['status_edit'];
    // echo '<script>alert("period_edit: '.$period_edit.'")</script>'; 

$sql = "SELECT * from period where period=".$period." and id!=:id";   
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

// echo '<script>alert("rowCount: '.$query->rowCount().'")</script>';
  // echo '<script>alert("rowCount: '.$query->rowCount().'")</script>';
if($query->rowCount() <= 0){
$sql="update period set period=:period_p,description=:description_p,status=:status_p,udate=GETDATE(),modify_by=:modify_by_p where id=:id";
// echo '<script>alert("sql: '.$sql.'")</script>'; 
 // echo '<script>alert("rowCount: '.$query->rowCount().'")</script>';
$query = $dbh->prepare($sql); 

$query->bindParam(':period_p',$period_edit,PDO::PARAM_STR);
$query->bindParam(':description_p',$description_table,PDO::PARAM_STR);
if($stauts_table==""){
    $stauts_table="0";
}else{
    $stauts_table="1";
}
$query->bindParam(':status_p',$stauts_table,PDO::PARAM_STR);
$query->bindParam(':modify_by_p',$_SESSION['id'],PDO::PARAM_STR);
$query->bindParam(':id',$id_edit,PDO::PARAM_STR);
$query->execute();
// print_r($query->errorInfo());
// $lastInsertId = $dbh->lastInsertId();
// if($lastInsertId){
$msg="Period Created successfully";
}else{
    $error="Repeated period data. Please try again";
}
    // <----------------------Edit Period-------------------->

}else{
    $active=1;
}

}else{
    $msg="";
}
// <-------------------------------------------------->

$sql = "SELECT * from period ORDER BY LTRIM(period) ASC ";   
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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script> -->
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>

</head>

<style>
	.table th {
        vertical-align: middle !important;
		text-align: center !important;
    }
	.table thead th.sorting:after,
	.table thead th.sorting_asc:after,
	.table thead th.sorting_desc:after {
		top: 10px;
	}
	
	div.dataTables_wrapper div.dataTables_filter input {
		//border-color: #102958;
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
                                        <li class="active" >Payment Term</li>
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
                                <h2 class="title" style="color: #102958;">Payment Term</h2>
                            </div>
                        
                        <div class="row pull-right">

                            <div class="text-right">
                                <?php if($status_add==1){ ?>
                                <a href="add-period.php" class="btn btn-primary" style="color:#F9FAFA;" >
                                    <svg  width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
  <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                    </svg>
                                    <span class="text">Add Term</span>
                                </a>  
                                <?php } ?>
                            </div>
                            &nbsp;&nbsp;

<div class="dropdown">
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
                             
                            &nbsp;&nbsp;
                        </div>
                    </div>

<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php }else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
        <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
    </div>
<?php } ?>

<script type="text/javascript">
    // $(document).on('click','.editAction', function () {
    //     alert('Click editAction');
    // });


     function ClickAdd() {
        // alert('ClickAdd');
        document.getElementById("area_add").hidden = false;
        document.getElementById("area_edit").hidden = true;
        // var value_status = document.getElementById("status_i_input").value;
        // if(value_status=="Not renew"){
        //     $('#ModalNotrenew').modal('show');
        //     document.getElementById("area_not").hidden = false;
        // }else{
        //     document.getElementById("area_not").hidden = true;
        // }
    }
    function ClickEdit() {
        document.getElementById("area_edit").hidden = false;
        document.getElementById("area_add").hidden = true;
        var name = $(this).closest("tr").find(".period").text();
        document.getElementById("period_edit").value = name;
        alert('End ClickEdit');
    }
    // $(document).ready(function(){ 

    $(document).on('click','.editAction', function () {
        document.getElementById("area_edit").hidden = false;
        document.getElementById("area_add").hidden = true;


        var id_table = $(this).closest("tr").find(".id_table").text();
        var period_table = $(this).closest("tr").find(".period_table").text();
        var description_table = $(this).closest("tr").find(".description_table").text();
        var stauts_table = $(this).closest("tr").find(".stauts_table").text();
        document.getElementById("id_edit").value = id_table;
        document.getElementById("period_edit").value = period_table;
        document.getElementById("description_edit").value = description_table;
        if(stauts_table=="Active"){
             document.getElementById("status_edit").checked=true;
        }else{
            document.getElementById("status_edit").checked=false;
        }
    });

</script>    

<!-----------------------------Add Period-------------------------------------->
<form method="post">
<!-- hidden="true" -->
<div id="area_add" hidden="true"  >
        <div class="panel-heading">
            <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col">
                            <div class="panel-title" style="color: #102958;" >
                                <h2  style="color: #102958;" class="title">Add Term</h2>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                        </div>
                        <div class="col-sm-4 text-right ">
                        </div>&nbsp;&nbsp;
            </div>
        </div> 
        <div class="panel-body">
                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left" >
                        <label style="color: #102958;" for="success" class="control-label">Payment Term</label>
                    </div> 
                    <div class="col ">
                         <input minlength="1" maxlength="50" style="border-color:#102958;" type="text"  required="required" class="form-control" id="period" name="period" value="<?php echo $period; ?>" >
                    </select>
                    </div> 
                    <div class="col ">
                        <input id="status" name="status"  class="form-check-input" type="checkbox" value="true" checked>
                        <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Active
                    </div> 
                    <div class="col-sm-2 ">
                    </div> 
                   <!--  <div class="col-sm-2 label_right" >
                        <label style="color: #102958;" for="success" class="control-label">Due Date</label>
                    </div> 
                    <div class="col ">
                         <input minlength="1" maxlength="3" style="border-color:#102958;" type="number" name="due_date" required="required" class="form-control" id="success" value="<?php echo $due_date; ?>" >
                    </div>  -->  
                </div> 
                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left" >
                        <label style="color: #102958;" for="success" class="control-label">Description</label>
                    </div> 
                    <div class="col ">
                         <input minlength="1" maxlength="50" style="border-color:#102958;" type="text" class="form-control" id="description" name="description" value="<?php echo $description; ?>" >
                    </select>
                    </div>
                    <div class="col-sm-2 label_right" >
                        <!-- <label style="color: #102958;" for="success" class="control-label">Due Date</label> -->
                    </div> 
                    <div class="col ">
                         <!-- <input minlength="1" maxlength="3" style="border-color:#102958;" type="number" name="due_date" required="required" class="form-control" id="success"  > -->
                    </div> 
                </div> 

                <br>

                <div class="form-group row col-md-10 col-md-offset-1">
                  <!--   <div class="col-md-2">
                    </div>  -->
                    <div class="col-md-10">
                        <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                        </button>
                    </div>
                </div>
                
            </div> 
            <br>

</div>
</form>

<!------------------------------------------------------------------------------->

<!-----------------------------Edit Period-------------------------------------->
<form method="post">
<!-- hidden="true" -->
<div id="area_edit" hidden="true"  >
        <div class="panel-heading">
            <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 style="color: #102958;" class="title">Edit Payment</h2>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                        </div>
                        <div class="col-sm-4 text-right ">
                        </div>&nbsp;&nbsp;
            </div>
        </div> 
        <div class="panel-body">
                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left" >
                        <label style="color: #102958;" for="success" class="control-label">Payment</label>
                    </div> 
                    <div class="col ">
                         <input hidden="ture" minlength="1" maxlength="50" style="border-color:#102958;" type="text"  required="required" class="form-control" id="id_edit" name="id_edit" value="<?php echo $period; ?>" >

                        <input  minlength="1" maxlength="50" style="border-color:#102958;" type="text"  required="required" class="form-control" id="period_edit" name="period_edit" value="<?php echo $id_edit; ?>" >
                    </select>
                    </div> 
                    <div class="col ">
                        <input id="status_edit" name="status_edit"  class="form-check-input" type="checkbox" value="true" checked>
                        <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Active
                    </div> 
                    <div class="col-sm-2 ">
                    </div> 
                   <!--  <div class="col-sm-2 label_right" >
                        <label style="color: #102958;" for="success" class="control-label">Due Date</label>
                    </div> 
                    <div class="col ">
                         <input minlength="1" maxlength="3" style="border-color:#102958;" type="number" name="due_date" required="required" class="form-control" id="success" value="<?php echo $due_date; ?>" >
                    </div>  -->  
                </div> 
                <div class="form-group row col-md-10 col-md-offset-1" >
                    <div class="col-sm-2  label_left" >
                        <label style="color: #102958;" for="success" class="control-label">Description</label>
                    </div> 
                    <div class="col ">
                         <input minlength="1" maxlength="50" style="border-color:#102958;" type="text" class="form-control" id="description_edit" name="description_edit" value="<?php echo $description; ?>" >
                    </select>
                    </div>
                    <div class="col-sm-2 label_right" >
                        <!-- <label style="color: #102958;" for="success" class="control-label">Due Date</label> -->
                    </div> 
                    <div class="col ">
                         <!-- <input minlength="1" maxlength="3" style="border-color:#102958;" type="number" name="due_date" required="required" class="form-control" id="success"  > -->
                    </div> 
                </div> 

                <br>

                <div class="form-group row col-md-10 col-md-offset-1">
                  <!--   <div class="col-md-2">
                    </div>  -->
                    <div class="col-md-10">
                        <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit_edit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                        </button>
                    </div>
                </div>
                
            </div> 
            <br>

</div>
</form>

<!------------------------------------------------------------------------------->


                        <div class="card-body" >
                            <div class="table-responsive" style="font-size: 13px;">
                                <!-- width="2000px"  -->
                                <!-- style="width:300%;" table-striped width="2500px-->
                                <table id="example"  class="table table-bordered"  style="color: #969FA7; font-size: 13px;" width="100%" >
                                    <thead >
                                        <tr style="color: #102958;" >
                                            <th style="color: #102958;">#</th>
                                            <th hidden="true" style="color: #102958;">Id</th>
                                            <th style="color: #102958;">Payment Code</th>
                                            <th style="color: #102958;">Payment Description</th>
                                            <th style="color: #102958;">Status</th>
                                            <?php if($status_edit==1 or $status_delete ==1){ ?>
                                            <th style="color: #102958;">Action</th>
                                            <?php }else{ ?>
                                            <th hidden="true" ></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody style="color: #0C1830; font-size: 13px;" >
                                    <?php 
                                        $cnt=1;
                                        if($query->rowCount() > 0){
                                        foreach($results as $result){ 
                                    ?> 
                                        <tr id="row<?php echo $result->id;?>" >
                                            <form>
                    <td class="text-center"><?php echo $cnt;?></td>
                    <td class="text-center" class="id_table" hidden="true" ><?php echo $result->id;?></td>
                    <td class="text-center" class="period_table" ><?php echo $result->period;?></td>
                    <td class="text-center" class="description_table" ><?php echo $result->description;?></td>
                                            <td class="text-center" class="stauts_table" ><?php if($result->status==1){ echo "Active"; }else{ echo "InActive"; } ?></td>

<?php if($status_edit==1 or $status_delete ==1){ ?>
                                            <td class="text-center">
<?php if($status_edit==1){ ?>
<a href="edit-period.php?id=<?php echo $result->id; ?>"><i class="fa " title="Edit Record"></i>
 <svg width="20" height="20" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
</svg></a>&nbsp;&nbsp;&nbsp;&nbsp;
<?php } ?>
<?php if($status_delete==1){ ?>
    <i class="fa " title="Delete this Record" >
    <a href="period.php?id=<?php echo $result->id; ?>" onclick="return confirm('Do you really want to delete data?');">
    <svg width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
</svg>
    </a></i> 
<?php } ?>
        
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
    //  function makeOrder(rowId) {
    //     alert('Click makeOrder');
    //     // var value=document.getElementById(rowId).childNodes[9].value;

    //     var value=document.getElementById(rowId).value;
    //     alert('rowId:'+rowId); 

    //     // var value = $(this).closest("tr").find(".period1").text();

    //     var value = document.getElementById("description1").value;
    //     alert('value:'+value); 
    // }

    // $(document).on('click','.editAction', function () {
    //     alert('not editAction');
    // }
</script>   

<!-- <?php //include('includes_php/popup_table_customer.php');?> -->

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
       
    <script>
        $(document).ready(function(){
    var table = $('#example').DataTable({
        scrollY: 400, // ตั้งค่าความสูงที่คุณต้องการให้แถวแรก freeze
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            fixedColumns: {
                leftColumns: 1 // จำนวนคอลัมน์ที่คุณต้องการให้แถวแรก freeze
            },
        // scrollX: true,
        lengthMenu: [[10, 25, 50, 100, -1], [10,25, 50, 100, "All"]],
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        "scrollCollapse": true,
        "paging":         true,
        buttons: [
            { extend: 'csv',class: 'buttons-csv',className: 'btn-primary',charset: 'UTF-8',filename: 'Period',bom: true
            ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
            { extend: 'excel',class: 'buttons-excel', className: 'btn-primary',charset: 'UTF-8',filename: 'Period',bom: true 
            ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
            { extend: 'pdf',class: 'buttons-pdf',className: 'btn-primary',charset: 'UTF-8',filename: 'Period',bom: true 
            ,exportOptions: {columns: ':not(:last-child)'},init : function(api,node,config){ $(node).hide();} },
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
       
    <?php include('includes/footer.php'); ?>
</body>
</html>
<?php } ?>

<?php $dbh = null;?>
