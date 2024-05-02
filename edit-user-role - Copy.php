<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{
        if(strlen($_GET['id'])==""){
             header("Location: manage-user.php"); 
        }
        if(isset($_POST['back'])){
            header("Location: manage-user.php"); 
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

  
<?php 
if(isset($_POST['update']))
{
$name_title=$_POST['name_title'];
$name=$_POST['name']; 
$username=$_POST['username'];
$id_role=$_POST['id_role'];
$active=$_POST['active'];

$password=$_POST['password'];
$password_old=$_POST['password_old'];
// echo '<script>alert("Pass:'.$password_old.'")</script>'; 
if($password == $password_old){
    $password_new=$_POST['password'];
}else{
    $password_new=md5($_POST['password']);
}


if(is_null($active)){
     $active=0;
}

$cid=intval($_GET['id']);
// $sql="update  tblclasses set ClassName=:classname,ClassNameNumeric=:classnamenumeric,Section=:section where id=:cid ";
$sql="update user_info set name_title=:name_title_p,name=:name_p,username=:username_p,password=:password_p,role_id=:id_role_p,active=:active_p where  id=:cid ";
// $sql="update user_info set name_title='".$name_title."',name='".$name."',username='".$username."',role_id='".$id_role."',active='".$active."'  where id= ".$cid;
$query = $dbh->prepare($sql);
$query->bindParam(':name_title_p',$name_title,PDO::PARAM_STR);
$query->bindParam(':name_p',$name,PDO::PARAM_STR);
$query->bindParam(':username_p',$username,PDO::PARAM_STR);
$query->bindParam(':password_p',$password_new,PDO::PARAM_STR);
$query->bindParam(':id_role_p',$id_role,PDO::PARAM_STR);
$query->bindParam(':active_p',$active,PDO::PARAM_STR);
$query->bindParam(':cid',$cid,PDO::PARAM_STR);
$query->execute();
$msg="Data has been updated successfully";
}

?>



<section class="section">
    <div class="container-fluid">
                          
<?php 
if(isset($_POST['update']))
{
$name_title=$_POST['name_title'];
$name=$_POST['name']; 
$username=$_POST['username'];
$id_role=$_POST['id_role'];

$active=$_POST['active'];
if(is_null($active)){
     $active=0;
}

$cid=intval($_GET['id']);
// $sql="update  tblclasses set ClassName=:classname,ClassNameNumeric=:classnamenumeric,Section=:section where id=:cid ";
$sql="update user_info set name_title=:name_title_p,name=:name_p,username=:username_p,role_id=:id_role_p,active=:active_p where  id=:cid ";
// $sql="update user_info set name_title='".$name_title."',name='".$name."',username='".$username."',role_id='".$id_role."',active='".$active."'  where id= ".$cid;
$query = $dbh->prepare($sql);
$query->bindParam(':name_title_p',$name_title,PDO::PARAM_STR);
$query->bindParam(':name_p',$name,PDO::PARAM_STR);
$query->bindParam(':username_p',$username,PDO::PARAM_STR);
$query->bindParam(':id_role_p',$id_role,PDO::PARAM_STR);
$query->bindParam(':active_p',$active,PDO::PARAM_STR);
$query->bindParam(':cid',$cid,PDO::PARAM_STR);
$query->execute();
$msg="Data has been updated successfully";
}

?>
                              

                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title" style="color: #102958;">
                                                    <h5>Edit User</h5>
                                                </div>
                                            </div>
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>

<?php
    $cid=intval($_GET['id']);
// $sql = "SELECT * from tblclasses where id=:cid";
$sql = "SELECT *,ri.role_name AS role_name_user,ui.active as active_user from user_info ui 
 JOIN role_info ri ON ui.role_id = ri.id_role
 WHERE id=:cid ";
$query = $dbh->prepare($sql);
$query->bindParam(':cid',$cid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;

$sql2 = "SELECT * from role_info";
$query2 = $dbh->prepare($sql2);
$query2->execute();
$results2=$query2->fetchAll(PDO::FETCH_OBJ);

?>

<form method="post" id="myCoolForm" >
    <div class="panel-body">
<?php 
    if($query->rowCount() > 0){
    foreach($results as $result){   
?>
                <!-- has-success -->
                <div class="form-group ">
                    <label style="color: #102958;" for="success" class="control-label">Title Name</label>
                        <select style="color: #4590B8;border-color:#102958;" name="name_title" class="form-control" id="default"  value="" >
                            <?php  if($result->name_title=="Mr."){ ?>
                                <option value="Mr." selected>Mr.</option>
                            <?php }else{ ?>
                                <option value="Mr." >Mr.</option>
                            <?php } ?>

                            <?php  if($result->name_title=="Ms."){ ?>
                                <option value="Ms." selected>Ms.</option>
                            <?php }else{ ?>
                                <option value="Ms." >Ms.</option>
                            <?php } ?>

                            <?php  if($result->name_title=="Mrs."){ ?>
                                <option value="Mrs." selected>Mrs.</option>
                            <?php }else{ ?>
                                <option value="Mrs." >Mrs.</option>
                            <?php } ?>
                        </select>
                    </div>
                                                    <div class="form-group has-success">
                                                        <label style="color: #102958;" for="success" class="control-label">Name</label>
                                                        <div class="">
                                                            <input style="color: #4590B8;border-color:#102958;" type="text" name="name" value="<?php echo $result->name;?>" required="required" class="form-control" id="success">
                                                            <!-- <span class="help-block">Eg- Third, Fouth,Sixth etc</span> -->
                                                        </div>
                                                    </div>
                                                    <div class="form-group has-success">
                                                        <label style="color: #102958;" for="success" class="control-label">User</label>
                                                        <div class="">
                                                            <input style="color: #4590B8;border-color:#102958;" type="text" name="username" value="<?php echo $result->username;?>" required="required" class="form-control" id="success">
                                                            <!-- <span class="help-block">Eg- Third, Fouth,Sixth etc</span> -->
                                                        </div>
                                                    </div>

<div class="form-group has-success">
        <label style="color: #102958;" for="success" class="control-label">Password</label>
    <div class="">
        <input style="color: #0C1830;border-color:#102958;" hidden="true" minlength="4" maxlength="12" type="password" name="password_old" class="form-control" required="required" id="success" value="<?php echo $result->password;?>" >
        <input style="color: #0C1830;border-color:#102958;" minlength="4" maxlength="12" type="password" name="password" class="form-control" required="required" id="success" value="<?php echo $result->password;?>" >
    </div>
</div>

        <div class="form-group has-success">
            <label style="color: #102958;" for="success" class="control-label">Role User</label>
            <select style="color: #4590B8;border-color:#102958;" name="id_role" class="form-control" id="default"  value=""  >

<?php 
if($query2->rowCount() > 0){
foreach($results as $result_select)
{   ?>
    <?php if($result->id_role==$result_select->id_role){ ?>
    <option value="<?php echo $result_select->id_role; ?>" selected><?php echo $result_select->role_name; ?>&nbsp; </option>
    <?php }else{ ?>
    <option value="<?php echo $result_select->id_role; ?>" ><?php echo $result_select->role_name; ?>&nbsp; </option>
    <?php } ?>
}
<?php }} ?>

            </select>
        </div>

                                                    <div class="form-group has-success">
                                                        <label style="color: #102958;" for="success" class="control-label">Active</label>
                                                        <div class="">
                    <input  name="active" data-size="big" data-toggle="toggle" onclick="fonctionTest()" id="active" class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" 
                    <?php if($result->active_user==1){ ?>
                            checked
                                <?php } ?>
                    >
                                                        </div>
                                                    </div><br><br>
                                                    <?php }} ?>
                    <div class="form-group has-success">
                                                        <div class="">
                                                             <!-- <button onclick="relocate_home()" style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="back" class="btn" href="manage-user.php" >Back<span class="btn-label btn-label-right"></span>
                                                            </button> -->

        <button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="update" data-toggle="modal" class="btn btn-labeled">Update<span class="btn-label btn-label-right"><i class="fa fa-check" ></i></span></button>

                                                    </div> 
                                                </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-8 col-md-offset-2 -->
                                </div>
                                <!-- /.row -->

                            </div>
                            <!-- /.container-fluid -->
                        </section>


    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

     <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <!-- <script src="js/bootstrap/bootstrap.min.js"></script> -->
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
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

    <script>
        // var el = document.getElementById('myCoolForm');
        // el.addEventListener('submit', function(){
        // return confirm('Are you sure you want to submit this form?');
        // }, false);

        $('#modal-dialog').on('show', function() {
    var link = $(this).data('link'),
        confirmBtn = $(this).find('.confirm');
})


$('#btnYes').click(function() {
  
    // handle form processing here
    
    alert('submit form');
    $('form').submit();
  
});

$(document).ready(function() {
    // ดักปุ่มให้แสดง popup
    $('#myCoolForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission
        $('#user-info-edit').modal('show'); // Display the modal

    });


    // Submit the form when the user clicks the confirm button
    $('#submit').on('click', function() {
        $('#myCoolForm').off('submit').submit(); // Unbind the event handler and submit the form


    });

     $('#close').on('click', function() {
        alert('Check Button');
        $('#myCoolForm').off('close').submit(); // Unbind the event handler and submit the form
        
    });
});

    </script>

</body>

<div id="modal-dialog" class="modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <a href="#" data-dismiss="modal" aria-hidden="true" class="close">×</a>
             <h3>Are you sure</h3>
        </div>
        <div class="modal-body">
             <p>Do you want to submit the form?</p>
        </div>
        <div class="modal-footer">
          <a href="#" id="btnYes" class="btn confirm">Yes</a>
          <a href="#" data-dismiss="modal" aria-hidden="true" class="btn secondary">No</a>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="user-info-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Please confirm</h5>
        <button id="close" value="close" type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="" id="">Are you sure you want to submit changes? </p>
      </div>
      <div class="modal-footer">
        <button type="button" id="close" value="close" name="close" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="submit" value="submit" name="update" class="btn bg-gradient-success">Submit</button>
      </div>
    </div>
  </div>
</div>




</html>
<?php } ?>
