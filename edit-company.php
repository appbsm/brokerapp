<!-- ========== Address Search ========== -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<?php

include('includes/config.php');
session_start();
error_reporting(0);
include('includes/config_path.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{

        if(isset($_POST['back'])){
            header("Location: manage-user.php"); 
        }

if(isset($_POST['submit']) && isset($_POST['id_company'])){

// echo '<script>alert("id_company: '.$_POST['id_company'].'")</script>'; 
$status  = $_POST['status'];

$company_id  = $_POST['company_id'];
$company_name  = $_POST['company_name'];

$tax_id  = $_POST['tax_id'];
$tel  = $_POST['tel'];
$mobile  = $_POST['mobile'];
$email  = $_POST['email'];

$address_number_input= $_POST['address_number_input'];
$building_input     = $_POST['building_input'];
$soi_input          = $_POST['soi_input'];
$road_input         = $_POST['road_input'];

$sub_district_id    = $_POST['sub_district_id'];
$district_id        = $_POST['district_id'];
$province_id        = $_POST['province_id'];
$postcode_id        = $_POST['postcode_id'];

$email_master   = $_POST['email_master'];
$brach_code     = $_POST['brach_code'];
$brach_des      = $_POST['brach_des'];



//////////// upload file ////////////
$sql_file ="";
    $new_file_name="";
    if($_FILES['file']['name']!=""){
        try {
            $file = $_FILES['file']['name'];
            // $_FILES['picture']['tmp_name'][$i]
            $file_loc = $_FILES['file']['tmp_name'];
            // $image=$_POST['file'];
            $folder=$sourceFilePath;
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $new_file_name = uniqid().".".$ext;
            $path_file = $folder."/".$new_file_name;
            $final_file=str_replace(' ','-',$new_file_name);
            move_uploaded_file($file_loc,$folder.$final_file);    
        }catch(Exception $e) {
            // echo '<script>alert("Error : '.$e.'")</script>'; 
        }
        $sql_file = ",company_logo=:company_logo_p,file_namelogo_uniqid=:file_namelogo_uniqid_p ";
    }
    ////////////////////////////////////

$sql="update company_list set 
company_id=:company_id_p,company_name=:company_name_p,tax_id=:tax_id_p,tel=:tel_p,mobile=:mobile_p
,email=:email_p,email_master=:email_master_p,address_number=:address_number_p,building_name=:building_name_p
,soi=:soi_p,road=:road_p,sub_district=:sub_district_p,district=:district_p,province=:province_p
,post_code=:post_code_p,status=:status_p,brach_code=:brach_code_p,brach_descrition=:brach_descrition_p".$sql_file." 
where id =".$_POST['id_company'];

$query = $dbh->prepare($sql); 

    $query->bindParam(':company_id_p',$company_id,PDO::PARAM_STR);
    $query->bindParam(':company_name_p',$company_name,PDO::PARAM_STR);

    $query->bindParam(':tax_id_p',$tax_id,PDO::PARAM_STR);
    $query->bindParam(':tel_p',$tel,PDO::PARAM_STR);
    $query->bindParam(':mobile_p',$mobile,PDO::PARAM_STR);

    $query->bindParam(':email_p',$email,PDO::PARAM_STR);

    $query->bindParam(':address_number_p',$address_number_input,PDO::PARAM_STR);
    $query->bindParam(':building_name_p',$building_input,PDO::PARAM_STR);
    $query->bindParam(':soi_p',$soi_input,PDO::PARAM_STR);
    $query->bindParam(':road_p',$road_input,PDO::PARAM_STR);

    $query->bindParam(':sub_district_p',$sub_district_id,PDO::PARAM_STR);
    $query->bindParam(':district_p',$district_id,PDO::PARAM_STR);
    $query->bindParam(':province_p',$province_id,PDO::PARAM_STR);
    $query->bindParam(':post_code_p',$postcode_id,PDO::PARAM_STR);

    $query->bindParam(':email_master_p',$email_master,PDO::PARAM_STR);
    $query->bindParam(':brach_code_p',$brach_code,PDO::PARAM_STR);
    $query->bindParam(':brach_descrition_p',$brach_des,PDO::PARAM_STR);

    if($status==""){
        $status="0";
    }else{
        $status="1";
    }
    $query->bindParam(':status_p',$status,PDO::PARAM_STR);

    
    if($_FILES['file']['name']!=""){
        $query->bindParam(':company_logo_p',$_FILES['file']['name'],PDO::PARAM_STR);
        $query->bindParam(':file_namelogo_uniqid_p',$new_file_name,PDO::PARAM_STR);
    }

$query->execute();
// print_r($query->errorInfo());

// $lastInsertId_company = $dbh->lastInsertId();

$array_delete=array();
$sql_rela = "SELECT * from rela_company_to_contact WHERE id_company = ".$_POST['id_company'];
$query_rela = $dbh->prepare($sql_rela);
$query_rela->execute();
$results_rela=$query_rela->fetchAll(PDO::FETCH_OBJ);
foreach($results_rela as $result_add){
    if (!in_array($result_add->id_contact,$_POST['rela_contact'])) { 
        array_push($array_delete,$result_add->id);
    }
}
foreach($array_delete as $value) {
    // echo '<script>alert("array_delete : '.$value.'")</script>'; 
    $sql="delete from rela_company_to_contact where id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id',$value,PDO::PARAM_STR);
    $query->execute();
}

for ($i=0;$i<count($_POST['title_co']);$i++) {

            if($_POST['id_co'][$i]==""){ /// insert
                // echo '<script>alert("Run insert : '.$_POST['id_co'][$i].'")</script>'; 
                $sql = "INSERT INTO contact ".
                "(title_name,first_name,last_name,nick_name,tel".
                ",mobile,email,line_id,position,remark,department".
                ",default_contact)";
                $sql=$sql." VALUES (:title_name_p,:first_name_p,:last_name_p,:nick_name_p,:tel_p".
                     ",:mobile_p,:email_p,:line_id_p,:position_p,:remark_p,:department_p".
                     ",:default_contact_p)";
                $query = $dbh->prepare($sql); 
                $query->bindParam(':title_name_p',$_POST['title_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':first_name_p',$_POST['first_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':last_name_p',$_POST['last_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':nick_name_p',$_POST['nick_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':tel_p',$_POST['tel_co'][$i],PDO::PARAM_STR);

                $query->bindParam(':mobile_p',$_POST['mobile_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':email_p',$_POST['email_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':line_id_p',$_POST['line_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':position_p',$_POST['position_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':remark_p',$_POST['remark_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':department_p',$_POST['department'][$i],PDO::PARAM_STR);

                $default_status="0";
                if($_POST['default_co'][0]==$_POST['default_co_id'][$i]){
                    $default_status="1";
                }else{
                    $default_status="0";
                }
                $query->bindParam(':default_contact_p',$default_status,PDO::PARAM_STR);
                $query->execute();
                $lastInsertId_contact = $dbh->lastInsertId();

                $sql = "INSERT INTO rela_company_to_contact".
                "(id_company,id_contact)";
                $sql=$sql." VALUES (:id_company_p,:id_contact_p)";
                $query = $dbh->prepare($sql); 
                // $_GET['id']
                $query->bindParam(':id_company_p',$_POST['id_company'],PDO::PARAM_STR);
                $query->bindParam(':id_contact_p',$lastInsertId_contact,PDO::PARAM_STR);
                $query->execute();
                // print_r($query->errorInfo());
                // echo '<script>alert("End insert : '.$_POST['id_co'][$i].'")</script>'; 
            }else{

                 $sql = "update contact set 
                 title_name=:title_name_p,first_name=:first_name_p,last_name=:last_name_p,nick_name=:nick_name_p,tel=:tel_p
                ,mobile=:mobile_p,email=:email_p,line_id=:line_id_p,position=:position_p,remark=:remark_p,department=:department_p
                ,default_contact=:default_contact_p where id =:id";

                $query = $dbh->prepare($sql); 
                $query->bindParam(':title_name_p',$_POST['title_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':first_name_p',$_POST['first_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':last_name_p',$_POST['last_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':nick_name_p',$_POST['nick_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':tel_p',$_POST['tel_co'][$i],PDO::PARAM_STR);

                $query->bindParam(':mobile_p',$_POST['mobile_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':email_p',$_POST['email_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':line_id_p',$_POST['line_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':position_p',$_POST['position_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':remark_p',$_POST['remark_co'][$i],PDO::PARAM_STR);
                $query->bindParam(':department_p',$_POST['department'][$i],PDO::PARAM_STR);

                // echo '<script>alert("value: '.$_POST['default_co_id'][$i]." :: ".$_POST['default_co'][0].'")</script>'; 
                // if($_POST['default_co'][0]=="default_id:".$_POST['id_co'][$i]){
                $default_status="0";
                if($_POST['default_co'][0]==$_POST['default_co_id'][$i]){
                    $default_status="1";
                }else{
                    $default_status="0";
                }

                $query->bindParam(':default_contact_p',$default_status,PDO::PARAM_STR);
                $query->bindParam(':id',$_POST['id_co'][$i],PDO::PARAM_STR);
                $query->execute();
            

            }
        }//loop for Contact Person

// $lastInsertId = $dbh->lastInsertId();

// if($lastInsertId){

// echo '<script>alert("Successfully edited information.")</script>';
echo "<script>window.location.href ='companylist.php'</script>";
$msg="Class Created successfully";

// }else{
//     $error="Something went wrong. Please try again";
// }

}else{
    // $active=1;
    // $id_role=3;
    // $name_title="Mr.";
}


$sql_company = " SELECT * from company_list WHERE id ='".$_GET['id']."' ";
$query_company = $dbh->prepare($sql_company);
$query_company->execute();
$results_company=$query_company->fetchAll(PDO::FETCH_OBJ);
foreach($results_company as $result){
    $id_company=$result->id;
    $status = $result->status;
    $company_id = $result->company_id;
    $company_name = $result->company_name;

$tax_id = $result->tax_id;
$tel = $result->tel;
$mobile = $result->mobile;
$email = $result->email;

$address_number_input = $result->address_number;
$building_input = $result->building_name;
$soi_input = $result->soi;
$road_input = $result->road;

$province_id = $result->province;
$district_id = $result->district;
$sub_district_id = $result->sub_district;
$postcode_id = $result->post_code;

$email_master = $result->email_master;
$brach_code = $result->brach_code;
$brach_des = $result->brach_descrition;

$file_logo = $result->company_logo;
$file_logo_uuid = $result->file_namelogo_uniqid;

}

// -----------------------------Address-----------------------------
$sql_2 = "SELECT * FROM provinces";
$query_2 = $dbh->prepare($sql_2);
$query_2->execute();
$results_2=$query_2->fetchAll(PDO::FETCH_OBJ);

$sql_dis = "SELECT * FROM district where province_code = ".$province_id;
$query_dis = $dbh->prepare($sql_dis);
$query_dis->execute();
$results_dis=$query_dis->fetchAll(PDO::FETCH_OBJ);

$sql_sub_dis = "SELECT * FROM subdistrict where district_code = ".$district_id;
$query_sub_dis = $dbh->prepare($sql_sub_dis);
$query_sub_dis->execute();
$results_sub_dis=$query_sub_dis->fetchAll(PDO::FETCH_OBJ);

$sql_zip_code = "SELECT * FROM subdistrict where code = ".$sub_district_id;
$query_zip_code = $dbh->prepare($sql_zip_code);
$query_zip_code->execute();
$results_zip_code=$query_zip_code->fetchAll(PDO::FETCH_OBJ);

// ---------------------------------------------------------------------

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

    <!-- mb-4 -->
    <div class="container-fluid " >
                            <div class="row breadcrumb-div" style="background-color:#ffffff">
                                <div class="col-md-12" >
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li class="active"  ><a href="companylist.php">Company Information</a></li>
                                        <li class="active">Edit Company Detail</li>
                                    </ul>
                                </div>
                            </div>
    </div>

<form  method="post" action="edit-company.php" enctype="multipart/form-data" onsubmit="
$(this).find('select').prop('disabled', false);
$(this).find('input').prop('disabled', false);
return valid();
" >
<br>
<!-- <section class="section"> -->

<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php }else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
        <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
    </div>
<?php } ?>

<div class="container-fluid">
        <div class="row">

            <div class="col-md-12 ">
                <div class="panel">

                <div class="panel-heading">
                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Edit Company Detail</h2>
                                <br>
                            </div>

                        </div>
                        <div class="col-sm-2 ">

                            <!-- style="background-color: #0275d8;color: #F9FAFA;" -->
                        </div>
                    </div>
                </div> 
   
        <div class="panel-body">

            <div class="form-group row col-md-10 col-md-offset-1" >
                <!-- $_POST['id_company'] -->
                <input hidden="true" id="id_company" name="id_company" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" value="<?php if($id_company==""){ echo $_POST['id_company']; }else{ echo $id_company; } ?>" >
                </input>

                <div class="col-sm-2  label_left" >
                    <label style="color: #102958;" for="staticEmail" >Company ID:</label>
                </div>
                <!-- readOnly -->
                <div class="col ">
                    <input id="company_id" name="company_id" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" required="required" class="form-control" value="<?php echo $company_id; ?>" readOnly>
                </div>

                <div class="col-sm-2 label_right" >
                     <input id="status" name="status"  class="form-check-input" type="checkbox" value="true" 
                      <?php if($status==1){ ?>
                            checked
                                <?php } ?>
                     >
                    <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Active
                    </label>
                </div>
                <div class="col">
                   
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <div class="col-sm-2  label_left"  >
                    <label style="color: #102958;" for="staticEmail" >Company name:</label>
                    
                </div>
                <div class="col ">
                    <input id="company_name" name="company_name" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $company_name; ?>" required >
                </div>
                
                <div class="col-sm-2  label_right"  >
                    <label style="color: #102958;" for="staticEmail" >Tax ID / Passport ID:</label>
                </div>
                <div class="col ">
                     <!--<input id="tax_id" name="tax_id" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text"   class="form-control" value="<?php echo $tax_id; ?>"  required>-->
					 <input id="tax_id" name="tax_id" minlength="1" maxlength="13" style="color: #000;border-color:#102958;" type="text"   class="form-control" value="<?php echo $tax_id; ?>"  required>
                </div>    
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <div class="col-sm-2  label_left"  >
                    <label style="color: #102958;" for="staticEmail" >Tel:</label>
                </div>
                <div class="col">
                    <input id="tel" name="tel" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"   class="form-control" value="<?php echo $tel; ?>" >
                </div>
                <div class="col-sm-2  label_right" >
                    <label style="color: #102958;" for="staticEmail" >Mobile:</label>
                </div>
                <div class="col">
                    <input id="mobile" name="mobile" minlength="10" maxlength="12" style="color: #000;border-color:#102958;" type="text"   class="form-control" value="<?php echo $mobile; ?>"  required pattern="\d{3}-\d{3}-\d{4}">
                </div>
				<script>
					document.getElementById('mobile').addEventListener('input', function (e) {
						var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
						e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
					});
				</script>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <div class="col-sm-2  label_left"  >
                    <label style="color: #102958;" >Email:</label>
                </div>   
                <div class="col">
                    <input id="email" name="email" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="email" class="form-control" value="<?php echo $email; ?>" required>
                </div>
                <div class="col-sm-2  label_right" >
                    <label style="color: #102958;"  for="staticEmail" >Company Logo:</label>
                </div>
                <div class="col">
                    <input name="file" id="imgInp" type="file" style="width: 100%;" src="<?php echo $file_logo_uuid; ?>" accept="image/png, image/jpg, image/jpeg" >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <div class="col-sm-2  label_left"  >
                     <!-- <input type="file" name="img" src="<?php //echo $path_file; ?>" id="imgInp"> -->
                </div>   
                <div class="col">
                </div>   
                <div class="col-sm-2  label_right" >
                </div>   
                <div class="col">
                <!-- height: 128px; -->
        <img  <?php if($file_logo_uuid==""){ ?> hidden="true" <?php } ?>
        <?php if(isset($file_logo_uuid) and $file_logo_uuid!="" ){ ?> src="<?php echo "image.php?filename=".$file_logo_uuid; ?>" <?php } ?> id='img-upload' style="height: 200px;" />
                </div>  
            </div>  
		<!--
        <script>
        $(document).ready( function() {
        $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {
            
            var input = $(this).parents('.input-group').find(':text'),
                log = label;
            
            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }
        
        });
        function readURL(input) {
            var fileName = document.getElementById("imgInp").value;
            var idxDot = fileName.lastIndexOf(".") + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            
            document.getElementById("img-upload").hidden = false;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
            }else{
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img-upload').attr('src',null);
                }
                reader.readAsDataURL(input.files[0]);
                document.getElementById("imgInp").value=null;
                document.getElementById("img-upload").hidden = true;
                alert("Only jpg and png files are allowed!");
            }  

        }

        $("#imgInp").change(function(){
            readURL(this);
            });     
        });
        </script>
		-->
		<script>
			$(document).ready(function () {
				$(document).on('change', '.btn-file :file', function () {
					var input = $(this),
						label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
					input.trigger('fileselect', [label]);
				});

				$('.btn-file :file').on('fileselect', function (event, label) {

					var input = $(this).parents('.input-group').find(':text'),
						log = label;

					if (input.length) {
						input.val(log);
					} else {
						if (log) alert(log);
					}

				});

				function readURL(input) {
					var fileName = document.getElementById("imgInp").value;
					var idxDot = fileName.lastIndexOf(".") + 1;
					var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
					if (extFile == "jpg" || extFile == "jpeg" || extFile == "png") {
						var fileSize = input.files[0].size; // in bytes
						if (fileSize > 800 * 1024) {
							alert("File size exceeds 800kb. Please choose a file smaller than 800kb.");
							document.getElementById("imgInp").value = null;
							document.getElementById("img-upload").hidden = true;
                            $('#img-upload').attr('src', null);
							return;
						}
						// document.getElementById("img-upload").hidden = false;
						if (input.files && input.files[0]) {
							////////////////////////
                                $.ajax({
                                    url: 'check_folder_size_json.php',
                                    type: 'GET',
                                    success: function(response) {
                                        data = JSON.parse(response);
                                        if (data.alert) {
                                            var message = "The folder at " + data.folderPath + " is nearly full. Remaining space: " + data.remainingSizeGB + " GB.";
                                            alert(message);
                                            document.getElementById("imgInp").value = null;
                                            $('#img-upload').attr('src', null);
                                            document.getElementById("img-upload").hidden = true;
                                        }else{
                                            var reader = new FileReader();
                                            reader.onload = function (e) {
                                                $('#img-upload').attr('src', e.target.result);
                                            }
                                            reader.readAsDataURL(input.files[0]);
                                            document.getElementById("img-upload").hidden = false;
                                        }
                                    }
                                });
                            ///////////////////////
						}
					} else {
						var reader = new FileReader();
						reader.onload = function (e) {
							$('#img-upload').attr('src', null);
						}
						reader.readAsDataURL(input.files[0]);
						document.getElementById("imgInp").value = null;
						document.getElementById("img-upload").hidden = true;
						alert("Only jpg and png files are allowed!");
					}

				}

				$("#imgInp").change(function () {
                    readURL(this);
				});
			});
		</script>
		


            <div class="panel-heading">
                <div class="form-group row col-md-10 col-md-offset-1">
                    <div class="panel-title" style="color: #102958;" >
                        <h2 class="title">Address</h2>
                    </div>
                </div>
            </div>
            
            <div class="form-group row col-md-10 col-md-offset-1" >
                <div class="col-sm-2  label_left" >
                    <label style="color: #102958;" for="staticEmail" >Address Number:</label>
                </div>
                <div class="col">
                    <input id="address_input" name="address_number_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $address_number_input; ?>"  required>
                </div>

                <div class="col-sm-2  label_right" >
                    <label style="color: #102958;" for="staticEmail" >Building Name:</label>
                </div>
                <div class="col">
                    <input id="building_input" name="building_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $building_input; ?>" >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <div class="col-sm-2  label_left" >
                    <label style="color: #102958;" for="staticEmail" >Soi:</label>
                </div>
                <div class="col">
                    <input id="soi_input" name="soi_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $soi_input; ?>" >
                </div>

                <div class="col-sm-2  label_right" >
                    <label style="color: #102958;" for="staticEmail" >Road name:</label>
                </div>
                <div class="col">
                    <input id="road_input" name="road_input" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $road_input; ?>" >
                </div>
            </div>
            
            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left"  >
                    <label for="province" style="color: #102958;" >Province:</label>
                </div>
                <div class="col">
                    <!-- class="remove-example form-control selectpicker"  style="width: 100%;"-->
                     <select id="province" name="province_id" style="border-color:#102958; color: #000;" class="form-control selectpicker" data-live-search="true"  required >
                            <div id="row_option" >
                            <option  value="" >Select province</option>
                            <?php foreach($results_2 as $result_add){  ?>
                                <option value="<?php echo $result_add->code;?>" <? if($province_id==$result_add->code){ echo "selected";} ?>><?php echo $result_add->name_en;?></option>
                            <?php } ?>
                            <div>
                    </select>
                    
                </div>

                <div class="col-sm-2 label_right">
                    <label for="district" style="color: #102958;" >District:</label>
                </div>
                <div class="col">
                    <select id="district" name="district_id" style="border-color:#102958;" class="form-control selectpicker" data-live-search="true"  required>
                        <option value="" >Select district</option>
                        <?php foreach($results_dis as $result_add){  ?>
                                <option value="<?php echo $result_add->code;?>" <? if($district_id==$result_add->code){ echo "selected";} ?>><?php echo $result_add->name_en;?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left"  >
                    <label for="sub_district" style="color: #102958;" >Sub-district:</label>
                </div>
                <div class="col">
                    <select id="sub_district" name="sub_district_id" style="border-color:#102958; color: #000;" class="form-control selectpicker" data-live-search="true"  required>
                        <option value="" selected>Select sub-district</option>
                        <?php foreach($results_sub_dis as $result_add){  ?>
                                <option value="<?php echo $result_add->code;?>" <? if($sub_district_id==$result_add->code){ echo "selected";} ?>><?php echo $result_add->name_en;?></option>
                        <?php } ?>
                    </select>
                </div>

                 <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" for="staticEmail" >Post Code:</label>
                </div> 
                <div class="col">
                    <select id="postcode" name="postcode_id" style="border-color:#102958; color: #000;" class="form-control selectpicker" data-live-search="true"  required>
                        <option value="" selected>Select post code</option>
                        <?php foreach($results_zip_code as $result_add){  ?>
                                <option value="<?php echo $result_add->code;?>" <? if($postcode_id==$result_add->code){ echo "selected";} ?>><?php echo $result_add->zip_code;?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="panel-heading">
                <div class="form-group row col-md-10 col-md-offset-1">
                    <div class="panel-title" style="color: #102958;" >
                        <br>
                        <h2 class="title">Master Email</h2>
                    </div>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <div class="col-sm-2  label_left" >
                    <label style="color: #102958;" for="staticEmail" >Email name:</label>
                </div>
                <div class="col">
                    <input name="email_master" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="<?php echo $email_master; ?>"  required>
               
                </div>

                <div class="col-sm-2  label_right" >
                </div>
                <div class="col">
                </div>
            </div>

            <div class="panel-heading">
                <div class="form-group row col-md-10 col-md-offset-1">
                    <div class="panel-title" style="color: #102958;" >
                        <br>
                        <h2 class="title">Brach Code & Descrition</h2>
                    </div>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1" >
                <div class="col-sm-2  label_left" >
                    <label style="color: #102958;" for="staticEmail" >Brach Code:</label>
                </div>
                <div class="col">
                    <input name="brach_code" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"  class="form-control" value="<?php echo $brach_code; ?>"  required>
               
                </div>
                <div class="col-sm-2  label_right" >
                    <label style="color: #102958;" for="staticEmail" >Brach Descrition:</label>
                </div>
                <div class="col">
                    <input name="brach_des" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text"  class="form-control" value="<?php echo $brach_des; ?>"  required>
                </div>
            </div>

        </div>
    </div>                             
    </div>
</div>
</div>

<div class="container-fluid">
        <div class="row">

            <div class="col-md-12 ">
                <div class="panel">

                <div class="panel-heading">
                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Contact Person</h2>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                            <!-- style="background-color: #0275d8;color: #F9FAFA;" -->
                        </div>
                         <div class="col text-right ">
                            <br>
                            <!-- href="#"  -->
                            <a  name="add-con" id="add-con" class="btn" style="background-color: #0275d8;color: #F9FAFA;"><i
                                class="fas  fa-sm text-white-50"></i>+ Add More Contact</a>
                        </div>&nbsp;&nbsp;
                    </div>
                </div> 

        <div class="panel-body">
            <div class="form-group row mb-20 col-md-10 col-md-offset-1">

                <input id="rela_contact" name="rela_contact[]" value="" style="color: #000;border-color:#102958;" 
                type="text" class="form-control"  hidden="true">

                <input id="id_co" name="id_co[]" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  hidden="true" >
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Title :</label>
                </div>
                <div  class="col">
                     <select id="title_co" name="title_co[]" style="border-color:#102958; color: #000;" class="form-control"  required>
						<option value="" selected>Select Title</option>
						<?php  if($name_title=="Mr."){ ?>
							<option value="Mr." selected>Mr.</option>
						<?php }else{ ?>
							<option value="Mr." >Mr.</option>
						<?php } ?>

						<?php  if($name_title=="Ms."){ ?>
							<option value="Ms." selected>Ms.</option>
						<?php }else{ ?>
							<option value="Ms." >Ms.</option>
						<?php } ?>

						<?php  if($name_title=="Mrs."){ ?>
							<option value="Mrs." selected>Mrs.</option>
						<?php }else{ ?>
							<option value="Mrs." >Mrs.</option>
						<?php } ?>
					</select>    
                </div>
                <div class="col-sm-2 label_right" >
                </div>
                <div class="col" >
                </div>
            </div>
            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >First name:</label>
                </div>
                <div class="col">
                    <input id="first_co" name="first_co[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  required >
                </div>
                <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" >Mobile:</label>
                </div>
                <div class="col">
                    <input id="mobile_co" name="mobile_co[]" minlength="10" maxlength="12" style="color: #000;border-color:#102958;" type="text" class="form-control"  required pattern="\d{3}-\d{3}-\d{4}" >
                </div>
				<script>
					document.getElementById('mobile_co').addEventListener('input', function (e) {
						var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
						e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
					});
				</script>
            </div>
            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Last name:</label>
                </div>
                <div class="col">
                    <input id="last_co" name="last_co[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  required >
                </div>
                <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" >Tel:</label>
                </div>  
                <div class="col">
                    <input id="tel_co" name="tel_co[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Nickname:</label>
                </div>
                <div class="col">
                    <input id="nick_co" name="nick_co[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  >
                </div>

                <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" >Email:</label>
                </div>
                <div class="col">
                    <input id="email_co" name="email_co[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="email" class="form-control" required  >
                </div>
            </div>
            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Position:</label>
                </div>
                <div class="col">
                    <input id="position_co" name="position_co[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  required >
                </div>

                <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" >Line ID:</label>
                </div>
                <div class="col">
                    <input id="line_co" name="line_co[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"   >
                </div>
            </div>
            <div class="form-group row col-md-10 col-md-offset-1">
				<div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Department:</label>
                </div>
                <div class="col " class="form-control" >
                    <input id="department" name="department[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control"  required >
                </div>
                <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" >Remark:</label>
                </div>
                <div class="col " class="form-control" >
                    <input id="remark_co" name="remark_co[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" >
                </div>
                
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                </div>  
                <div class="col-sm-4 " >
                    <input hidden="true" id="default_co_id" name="default_co_id[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" value="default_id:0" >

                    <input id="default_co" name="default_co[]" class="form-check-input" type="radio" checked>
                    <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Default Contact
                    </label>
                </div>
            </div>  

        </div>
    </div>                             
    </div>
    <div id="field_contact"></div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel">
                <div class="panel-body">

                <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-md-12">
                    <button style="background-color: #0275d8;color: #F9FAFA; padding: 3px 16px 3px 16px;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                    </button>
                    &nbsp;&nbsp;
					<a href="companylist.php" class="btn btn-primary" style="background-color: #0275d8;color: #F9FAFA;" >
						<span class="text">Cancel</span>
					</a>
                </div>
                </div>
 
                </div>
            </div> 
        </div>  
    </div>  
</div>   

</div><br><br>
</form>
  
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

<style>
@media (min-width: 1340px){
    .label_left{
        max-width: 130px;
    }
    .label_right{
        max-width: 150px;
    }
}
.btn-default {
	color: #0C1830 !important;
	border-color: #102958 !important;
}
.caret {
	border-top: 2px dashed !important;
    border-right: 2px solid transparent !important;
    border-left: 2px solid transparent !important;
}
</style>
    
    <?php include('includes/footer.php'); ?>
</body>

</html>
<?php } ?>

<!------------------------------------------------------------------------------>

<script type="text/javascript" src="includes_php/address.js"></script>
<!-- _page_company -->
<?php include('includes_php/add_contact_page_company.php');?>
<!------------------------------------------------------------------------------>

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
    <script src="assets/js/custom2.js"></script>
    
<div id="loading-overlay">
    <img src="loading.gif" alt="Loading...">
</div>   

