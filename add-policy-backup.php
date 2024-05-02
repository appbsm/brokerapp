

<!-- ========== Address Search ========== -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>



<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{

        if(isset($_POST['back'])){
            header("Location: manage-user.php"); 
        }


if(isset($_POST['submit']) || isset($_POST['save']))
{
    $type=$_POST['type'];
}



if(isset($_POST['submit']))
{   
    // echo '<script>alert("button submit ")</script>'; 
    if(count($_POST["policy"])>0){
        

        

        for ($i=0;$i<count($_POST['policy']);$i++) {
            echo "<p>".$_POST['policy'][$i]."</p>";
            echo "<p>".$_POST['status'][$i]."</p>";
            echo "<hr />";
        }



    // echo '<script>alert("button submit ")</script>'; 
    //     alert('policy :'+ count($_POST["policy"]));
    }


// $name_title=$_POST['name_title'];
// $name=$_POST['name']; 
// $username=$_POST['username'];
// $password=$_POST['password'];
// $id_role=$_POST['id_role'];
// $active=$_POST['active'];

// if(is_null($active)){
//      $active=0;
// }

// $sql="INSERT INTO  user_info(name_title,name,username,password,role_id,active) VALUES(:name_title_p,:name_p,:username_p,:password_p,:id_role_p,:active_p)";
// $query = $dbh->prepare($sql); 
// $query->bindParam(':name_title_p',$name_title,PDO::PARAM_STR);
// $query->bindParam(':name_p',$name,PDO::PARAM_STR);
// $query->bindParam(':username_p',$username,PDO::PARAM_STR);
// $query->bindParam(':password_p',md5($password),PDO::PARAM_STR);
// $query->bindParam(':id_role_p',$id_role,PDO::PARAM_STR);
// $query->bindParam(':active_p',$active,PDO::PARAM_STR);
// $query->execute();
// $lastInsertId = $dbh->lastInsertId();
// if($lastInsertId)
// {
// $msg="Class Created successfully";

// $name_title="";
// $name=""; 
// $username="";
// $password="";
// $id_role="";
// $active=1;

// }
// else 
// {
// $error="Something went wrong. Please try again";
// }

}else{
    // $active=1;
    // $id_role=3;
    // $name_title="Mr.";
}

$sql_company = " SELECT * from insurance_company WHERE status = 1 ";
$query_company = $dbh->prepare($sql_company);
$query_company->execute();
$results_company = $query_company->fetchAll(PDO::FETCH_OBJ);

$sql_period = " SELECT * from period WHERE status = 1 order by LEN(period) ";
$query_period = $dbh->prepare($sql_period);
$query_period->execute();
$results_period = $query_period->fetchAll(PDO::FETCH_OBJ);

$sql_agent = " SELECT * from agent WHERE status = 1 ";
$query_agent = $dbh->prepare($sql_agent);
$query_agent->execute();
$results_agent=$query_agent->fetchAll(PDO::FETCH_OBJ);



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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script> -->
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>
</head>

<body id="page-top" >

    <!-- Page Wrapper -->
    <div id="wrapper" >
        <?php include('includes/leftbar2.php');?>   
        <?php include('includes/topbar2.php');?>  

        <div class="container-fluid mb-4" >
                            <div class="row breadcrumb-div" style="background-color:#ffffff">
                                <div class="col-md-12" >
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li class="active"  ><a href="entry-policy.php">View Entry Policy</a></li>
                                        <li class="active">Insurance information</li>
                                    </ul>
                                </div>
                            </div>
        </div>

<form method="post" onSubmit="return valid();" >
<!-- <section class="section"> -->
<div class="container-fluid">
        <div class="row">

            <div class="col-md-12 ">
                <div class="panel">

                <div class="panel-heading">
                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col">
                            <div class="panel-title" style="color: #102958;" >
                                <h2 class="title">Insurance information</h2>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                            <!-- style="background-color: #0275d8;color: #F9FAFA;" -->
                        </div>
                        <div class="col-sm-4 text-right ">
                            <br>
                            <!-- href="#"  -->
                            <a  name="add" id="add" class="btn" style="background-color: #0275d8;color: #F9FAFA;"><i
                                class="fas  fa-sm text-white-50"></i>+ Add More Insurance</a>
                        </div>&nbsp;&nbsp;

                        <!-- <button type="button" name="add" id="add">Add Test</button> -->

                        <!-- <div id="dynamic_field"></div> -->
                    </div>
                </div> 

        <div class="panel-body">

            <div class="form-group row col-md-10 col-md-offset-1" >
                <!-- &nbsp; <p class="pull-right"> -->
                <div class="col-sm-2  label_left"  >
                    <label style="color: #102958;" for="staticEmail" >Policy No:</label>
                </div>
                <!-- col-xs-auto -->
                <div class="col ">
                    <input id="policy" name="policy[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text"  required="required" class="form-control input_text"  >
                </div>
               
                <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" for="staticEmail" >Status:</label>
                </div>

                <div class="col">
                <select id="status_i_input" name="status" onchange="ClickChange()" style="border-color:#102958;" class="form-control" >
                    <option value="New">New</option>
                    <option value="Follow up">Follow up</option>
                    <option value="Renew">Renew</option>
                    <option value="Wait">Wait</option>
                    <option value="Not renew">Not renew</option>
                </select>
                </div>
                <!-- <div class="col-sm-1 ">
                </div> -->
            </div>

           <!--  onchange="
            var product_type = this.value;
            var subObject = $('#sub_cat');
            subObject.html('');
        $.get('get_product_categories.php?type='+product_type, function(data){
            // var result_type = JSON.parse(data);
            alert('result_type:'+result_type);
                $.each(result_type, function(index, item){
                subObject.append(
                    $('<option></option>').val(item.sub_categories).html(''+item.sub_categories+'')
                );
            });
        }); " -->
            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Product Category:</label>
                </div>
                <div class="col">
                    <select id="product_cat" name="product_cat[]" style="color: #0C1830;border-color:#102958;" class="form-control" value=""  >
                        <option value="Life">Life</option>
                        <option value="Non Life">Non Life</option>
                    </select>
                </div>

                <div class="col-sm-2  label_right" >
                    <label style="color: #102958;" for="staticEmail" >Sub Categories:</label>
                </div>
                <div class="col"  >
                <select id="sub_cat" name="sub_cat[]"  style="color: #0C1830;border-color:#102958;"class="form-control" value="0" >
                    <?php  foreach($results_product as $result){ ?>
                        <option value="<?php echo $result->sub_categories; ?>" ><?php echo $result->sub_categories; ?></option>
                    <? } ?>
                    <!-- <option value="" selected>Life insurance</option>
                    <option value="" >Health Insurance</option>
                    <option value="" >Travel Insurance</option> -->
                </select>
                </div>

              
                <!-- <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Period:</label>
                <div class="col">
                    <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name"  class="form-control"  >
                </div> -->
            </div>

            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <div class="col-sm-2  label_left" >
                    <label style="color: #102958;" for="staticEmail" >Insurance Company:</label>
                </div>
                <div class="col"  >
                <select name="insurance_com[]"  style="color: #0C1830;border-color:#102958;"class="form-control"  >
                     <?php  foreach($results_company as $result){ ?>
                        <option value="<?php echo $result->id; ?>" ><?php echo $result->insurance_name; ?></option>
                    <? } ?>
                    <!-- <option value="" selected>บริษัทเอไอเอ จำกัด (มหาชน)</option>
                    <option value="" >LMG Insurance.</option>
                     <option value="" >PACIFIC CROSS</option>
                     <option value="" >AIG</option>
                    <option value="">กรุงเทพประกันชีวิต จำกัด (มหาชน)</option>
                    <option value="">กรุงเทพประกันภัย จำกัด (มหาชน)</option>
                    <option value="">กรุงไทย-แอกซ่า ประกันชีวิต จำกัด (มหาชน)</option>
                    <option value="">คุ้มภัยโตเกียวมารีน ประกันภัย (ประเทศไทย) จำกัด (มหาชน)  </option>
                    <option value="">ชับบ์สามัคคี ประกันภัย จำกัด (มหาชน)</option>
                    <option value="">ทิพยประกันชีวิต จำกัด (มหาชน)</option> -->
                </select>
                </div>

                <div class="col-sm-2  label_right" >
                </div>
                <div class="col">
                </div>

            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Product Name:</label>
                </div> 
                <div class="col">
                    <input name="product_name[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" >
                </div>

                <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" for="staticEmail" >Period:</label>
                </div>
                <div class="col">
                    <select name="period[]"  style="color: #0C1830;border-color:#102958;"class="form-control" value="0" >
                        <?php  foreach($results_period as $result){ ?>
                        <option value="<?php echo $result->id; ?>" ><?php echo $result->period; ?></option>
                        <!-- <option value="6" >6</option>
                        <option value="12" >12</option> -->
                        <? } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" id="datepicker" >Start date:</label>
                </div> 
                <div class="col">
                    <input name="start_date[]" style="color: #0C1830;border-color:#102958;" type="date" class="form-control">
                </div>
                <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" for="staticEmail" >End date:</label>
                </div> 
                <div class="col">
                    <input name="end_date[]" style="color: #0C1830;border-color:#102958;" type="date" name="name"  class="form-control" id="success" >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Premium Rate:</label>
                </div>
                <div class="col-sm-2">
                    <!-- <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name"  class="form-control" > -->
                    <input id="premium_rate" name="premium_rate[]" type="number" style="border-color:#102958;" step="0.01" min="0" class="form-control" 
                        onchange="
                        if(Number.isInteger(parseFloat(this.value).toFixed(2))){
                            this.value=this.value+'.00';
                        }else{
                            this.value=parseFloat(this.value).toFixed(2);
                        }
                            var premium = parseFloat(this.value).toFixed(2);
                            var percent = parseFloat(document.getElementById('percent').value).toFixed(2);
                            var commission = premium - ((percent / 100) * premium);
                            document.getElementById('commission').value =parseFloat(commission).toFixed(2);
                        " />
                </div>

                <div class="col-sm-2 " >
                     <label style="color: #102958;" for="staticEmail" >Percent Trade:</label>
                </div>
                <div class="col-sm-2 " >
                    <input id="percent_trade" name="percent_trade[]" type="text" class="form-control" style="border-color:#102958;" onchange="
                        var num = parseInt(parseFloat(this.value).toFixed(0));
                        if(Number.isInteger(num)){
                            if (parseFloat(this.value)>100){
                            this.value=100+'%';
                            }else{
                                this.value=parseFloat(this.value).toFixed(2)+'%';
                            } 
                            var premium = parseFloat(document.getElementById('premium_rate').value).toFixed(2);
                            var percent = parseFloat(this.value).toFixed(2);
                            var commission = premium - ((percent / 100) * premium);
                            // document.getElementById('commission').value =parseFloat(commission).toFixed(2);
                            document.getElementById('commission').value =100;
                        }else{
                            this.value='';
                        }
                        " />
                </div> 
                <div class="col-sm-2 " >
                    <label style="color: #102958;" for="staticEmail" >Commission rate:</label>
                </div> 
                <div class="col-sm-2 " >
                    <input type="number" id="commission" name="commission[]" style="border-color:#102958;" disabled="true" class="form-control" />
                </div> 

            </div>



        <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Agent Name:</label>
                </div>

            <div class="col">
                <select name="agent[]" style="color:#0C1830;border-color:#102958;" class="form-control selectpicker" data-live-search="true" >
                    <?php  foreach($results_agent as $result){ ?>
                        <option value="<?php echo $result->id; ?>" ><?php echo $result->title_name." ".$result->first_name." ".$result->last_name."(".$result->nick_name.")"; ?></option>
                    <? } ?>
                </select>
            </div>

            <div class="col-sm-2 label_right" >
                <label style="color: #102958;" for="staticEmail" >Upload Documents:</label>
            </div>
                
            <div class="col">
                
                <input name="file_d[]" type="file" style="width: 100%;" src="<?php echo htmlentities($path_file) ?>" id="imgInp">
               
                
                <!-- <select name="id_role" style="color: #0C1830;border-color:#102958;"class="form-control" id="default"  value="" >
                    <option value="">New</option>
                    <option value="">Renew</option>
                    <option value="">Not </option>
                </select> -->
            </div>

        </div>

        <div id="area_not" class="form-group row col-md-10 col-md-offset-1" hidden="true" >
            <div class="col-sm-2 label_left" >  
            </div>
            <div class="col">
            </div>
             <div class="col-sm-2 label_right" >
                <label style="color: #102958;" for="staticEmail" >Reason:</label>
            </div>
            <div class="col">
                <textarea id="textarea_detail" name="textarea_detail[]" class="form-control" rows="5" placeholder="Cancellation reason"  ></textarea>
            </div>
        </div> 


            <!-- <div class="form-group row">
             <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Status:</label>
                <div class="col">
                    <input  name="active" data-size="big" data-toggle="toggle" id="active" class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" <?php if($active==1){ ?>
                            checked
                                <?php } ?>
                            >
                 </div>
            </div> -->

        </div>
    </div>                             
    </div>
</div>
</div>

<div id="dynamic_field"></div>

<div id="dynamic_field2"></div>

<div class="container-fluid">
        <div class="row">

            <div class="col-md-12 ">
                <div class="panel">

                    <div class="panel-heading">
                        <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="panel-title" style="color: #102958;" >
                            <h2 class="title">Customer</h2>
                        </div>
                        </div>
                    </div>
   
        <div class="panel-body">

            

    <div class="form-group row col-md-10 col-md-offset-1">

         <input hidden="true" id="id_customer_input" name="id_customer_input" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" id="success" value="" >
         </input>

        <div class="col-sm-2 label_left" >
            <label style="color: #102958;" for="staticEmail" >Customer name:</label>
        </div>

                <div class="col-sm-4">
                    <input id="name_c_input" name="name_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" id="success" value="" >
                        <!-- <span class="btn-label btn-label-right"><i class="fa fa-check"></i></span> -->
                    </input>
                </div>

                <!-- <div class="col-sm-1">
                    <div class="row">

                     </div>
                </div> -->

                <div class="col-sm-3">
                    <button style="background-color: #0275d8;color: #F9FAFA;" type="button" class="btn " data-toggle="modal" data-target="#ModalCustomer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>&nbsp;
                    </button>
                    <button style="background-color: #0275d8;color: #F9FAFA;" type="button" class="btn" onclick="clear_customer()" >Clear</button>
                </div>    
            <div class="col-sm-3">
            </div>  
    </div>

    <div class="form-group row col-md-10 col-md-offset-1">
        <div class="col-sm-2 label_left mb-20" >
            <label style="color: #102958;" for="staticEmail" >Customer Type:</label>
        </div>

        <div class="col">
            <select id="type_c_input"  name="type_c_input" style="border-color:#102958;" class="form-control" id="default" >
                                <option value="personal" selected>Personal</option>
                                <option value="corporate" >Corporate</option>
            </select>

        </div>

        <div class="col-sm-2 label_right" >
            <input id="status_c_input" name="status_c_input" class="form-check-input" type="checkbox" value=""  checked>
            <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Active
            </label>
        </div>  
        <div class="col" >
        </div>  

       <!--  <div class="col-sm-2 label_right" >
        </div>
        <div class="col" >
        </div> -->
    </div>  

    <div class="form-group row col-md-10 col-md-offset-1">
        <div class="col-sm-2 label_left" >
            <label style="color: #102958;" >Customer ID:</label>
        </div>

                <div class="col">
                    <input id="customer_c_input" name="customer_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" value="" checked>
                </div>

        <label style="color: #102958;"  class="col-sm-2 col-form-label">Customer Level:</label>
                <div class="col-sm-4">
                <select id="level_c_input" style="border-color:#102958;"   class="form-control">
                    <option value="0" selected>Choose a Customer Level</option>
                    <option value="A" >A</option>
                    <option value="B" >B</option>
                </select>
                </div>

                <!-- <div class="col-sm-2 label_right" >
                    <input id="status_c_input" name="status_c_input" class="form-check-input" type="checkbox" value=""  checked>
                    <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Active
                    </label>
                </div>  

        <div class="col" >
        </div>   -->
    </div>

    <div class="form-group row col-md-10 col-md-offset-1">
        <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Title Name:</label>
                <div class="col">
                     <select id="title_c_input" name="title_c_input" style="color: #4590B8;border-color:#102958;"  class="form-control"  >
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
                    <label style="color: #102958;" for="staticEmail" >Tax ID</label>
            </div>
            <div class="col">
                    <input id="personal_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name"  class="form-control"  >
            </div>
               <!--  <div class="col-sm-2 label_right" >
                </div>
                <div class="col" >
            </div> -->
    </div>

    <div class="form-group row col-md-10 col-md-offset-1">
        <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >First name:</label>
                </div>
                <div class="col">
                    <input id="first_c_input" name="first_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>
                <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" for="staticEmail" >Mobile:</label>
                </div>
                <div class="col">
                    <input id="mobile_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name"  class="form-control"  >
                </div>
        </div>  

        <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Last name:</label>
                </div>
                <div class="col">
                    <input id="last__c_input" name="last__c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>

                 <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" for="staticEmail" >Tel:</label>
                </div>
                <div class="col">
                    <input id="tel_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name"  class="form-control"  >
               
                </div>
        </div> 
            <div class="form-group row col-md-10 col-md-offset-1">
                
                <div class="col-sm-2 label_left" >
                    <label  style="color: #102958;" for="staticEmail" >Nickname:</label>
                </div>

                <div class="col">
                    <input id="nick_c_input" name="nick_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Email:</label>
                </div> 
                <div class="col">
                    <input id="email_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name"  class="form-control"  >
                </div>

            </div>
            <!-- Tax ID/Personal ID: Mobile:-->
            <!-- <div class="form-group row col-md-10 col-md-offset-1">

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Tax ID/Personal ID:</label>
                </div>
                <div class="col">
                    <input id="personal_c_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name"  class="form-control"  >
               
                </div>

               
            </div> -->

           <!--  <div class="form-group row col-md-10 col-md-offset-1">
                

                <div class="col-sm-2 label_right" >
                </div>
                <div class="col" >
                </div> 
            </div> -->

             <div class="panel-heading">
                <div class="form-group row col-md-10 col-md-offset-1">
                <div class="panel-title" style="color: #102958;" >
                    <h2 class="title" >Address</h2>
                </div>
                </div>
            </div> 

<?php
$sql_2 = "SELECT * FROM provinces";
$query_2 = $dbh->prepare($sql_2);
$query_2->execute();
$results_2=$query_2->fetchAll(PDO::FETCH_OBJ);
// $query = mysqli_query($conn, $sql);

?>

             <div class="form-group row col-md-10 col-md-offset-1">

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Address Number:</label>
                </div>  
                <div class="col">
                    <input id="address_input" name="address_number_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text"   class="form-control"  >
                </div>

                <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" for="staticEmail" >Building Name:</label>
                </div>

                <div class="col">
                    <input id="building_input" name="building_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Soi:</label>
                </div>
                <div class="col">
                    <input id="soi_input" name="soi_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>

                <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" for="staticEmail" >Road:</label>
                </div>
                <div class="col">
                    <input id="road_input" name="road_input" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>
            </div>      
        
            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left"  >
                    <label for="province" style="color: #102958;" >Province:</label>
                </div>
                <div id="div_province" class="col">
                    <div id="row_province" >
                    <!-- <select name="province_id" id="province" style="border-color:#102958;" class="remove-example form-control selectpicker" data-live-search="true" > -->
                     <select name="province_id" id="province" style="border-color:#102958;" class="remove-example form-control selectpicker" data-live-search="true"  >
                            <div id="row_option" >
                            <option  value="0" selected>Choose a province</option>
                            <?php foreach($results_2 as $result_add){  ?>
                                <option value="<?php echo $result_add->code;?>" ><?php echo $result_add->name_th;?></option>
                            <?php } ?>
                            <div>
                    </select>
                    </div>
                </div>

                <div class="col-sm-2 label_right">
                    <label for="district" style="color: #102958;" >District:</label>
                </div>
                <div class="col">
                    <select name="district_id" id="district" style="border-color:#102958;" class="form-control selectpicker" data-live-search="true" >
                        <option value="" >Choose a district</option>
                    </select>
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left"  >
                    <label for="sub_district" style="color: #102958;" >Sub-district:</label>
                </div>
                <div class="col">
                    <select name="sub_district_id" id="sub_district" style="border-color:#102958;" class="form-control selectpicker" data-live-search="true" >
                        <option value="0" selected>Choose a sub-district</option>
                    </select>
                </div>

                 <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" for="staticEmail" >Post Code:</label>
                </div> 
                <div class="col">
                    <select name="postcode_id" id="postcode" style="border-color:#102958;" class="form-control selectpicker" data-live-search="true" >
                        <option value="0" selected>Choose a post code</option>
                    </select>
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
        <div class="col">     
            <div class="form-check" style="top:20px;">
                <input disabled="true" id="same_co" name="same_co[]" class="form-check-input" type="checkbox" value="false" onclick="same_customer()" >
                <label  style="color: #0C1830;" class="form-check-label" >
                    &nbsp;&nbsp;&nbsp;&nbsp; Same Customer Name
                </label>
            </div>
        </div>  
                        <div class="col text-right">
                            <br>
                                <a  name="add-con" id="add-con" class="btn" style="background-color: #0275d8;color: #F9FAFA;"><i
                                class="fas  fa-sm text-white-50"></i>+ Add More Contact</a>
                        </div>&nbsp;&nbsp;
                        </div>
                    </div>
        <div class="panel-body">
            <div class="form-group row mb-20 col-md-10 col-md-offset-1">
                <input disabled="true" id="id_co" name="id_co[]" class="form-check-input" type="checkbox" value="false" hidden="true" >
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Title Name:</label>
                </div>
                <div class="col">
                     <select id="title_co" name="title_co[]" style="color: #4590B8;border-color:#102958;" class="form-control" >
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
                    <input id="first_co" name="first_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>
                <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" >Mobile:</label>
                </div>
                <div class="col">
                    <input id="mobile_co" name="mobile_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>
            </div>
            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Last name:</label>
                </div>
                <div class="col">
                    <input id="last_co" name="last_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>
                <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" >Tel:</label>
                </div>  
                <div class="col">
                    <input id="tel_co" name="tel_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>
            </div>

            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Nickname:</label>
                </div>
                <div class="col">
                    <input id="nick_co" name="nick_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>

                <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" >Email:</label>
                </div>
                <div class="col">
                    <input id="email_co" name="email_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>
            </div>
            <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Position:</label>
                </div>
                <div class="col">
                    <input id="position_co" name="position_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>

                <div class="col-sm-2 label_right" >
                    <label style="color: #102958;" >Line ID:</label>
                </div>
                <div class="col">
                    <input id="line_co" name="line_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>
            </div>
             <div class="form-group row col-md-10 col-md-offset-1">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" >Remark:</label>
                </div>
                <div class="col-sm-4">
                    <input id="remark_co" name="remark_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >
                </div>
                <div class="col-sm-6 label_right" >
                    <input id="default_co" name="default_co[]" class="form-check-input" type="radio" id="flexCheckDefault" checked>
                    <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">
                        &nbsp;&nbsp;&nbsp;&nbsp; Default Contact
                    </label>
                </div> 

              <!--   <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
  <label class="form-check-label" for="inlineRadio1">1</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
  <label class="form-check-label" for="inlineRadio2">2</label>
</div> -->

            </div>
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
                    <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                    </button>
                </div>
                </div>

                </div>
            </div>  
        </div>  
    </div>  
</div>   

    <br><br><br>
</form>

<!------------------------------------------------------------------------------>
<script type="text/javascript" src="includes_php/same_customer.js"></script>
<script type="text/javascript" src="includes_php/product_categery.js"></script>
<script type="text/javascript" src="includes_php/select_customer.js"></script>
<script type="text/javascript" src="includes_php/address.js"></script>

<?php include('includes_php/add_insurance.php');?>
<?php include('includes_php/add_contact.php');?>
<?php include('includes_php/popup_table_customer.php');?>
<?php include('includes_php/popup_reason.php');?>
<!------------------------------------------------------------------------------>

   

<style>
@media (min-width: 1340px){
    .label_left{
        max-width: 180px;
    }
    .label_right{
        max-width: 190px;
    }
}

</style>

 </div>
</body>





</html>
<?php } ?>


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
    <script src="assets/js/custom2.js"></script>
       
