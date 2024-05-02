
<?php
session_start();
error_reporting(0);

include('includes/config.php');
if($_SESSION['alogin']!=''){
$_SESSION['alogin']='';
}

if(isset($_POST['login']))
{
$uname=$_POST['username'];
$password=md5($_POST['password']);
// $sql ="SELECT username,password,user_role.role_name,name,user_info.id FROM user_info
//  join user_role ON user_info.role_id = user_role.id_role WHERE username=:uname and password=:password";
$sql ="SELECT role_name.role_name,user_info.* 
 FROM user_info
 left join user_role ON user_info.id = user_role.id
 left JOIN role_name ON user_role.id_role_name = role_name.id  
 WHERE username=:uname and user_info.status = '1'";
$query= $dbh -> prepare($sql);
$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
// $query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0){

$sql ="SELECT role_name.role_name,role_name.id AS role_name_id,user_info.* 
 FROM user_info
 left JOIN role_name ON user_info.role_name_id = role_name.id 
 WHERE username=:uname and password=:password and user_info.status = '1'";

$query= $dbh -> prepare($sql);
$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() > 0){
$_SESSION['alogin']=$_POST['username'];
$_SESSION['pass']=md5($_POST['password']);
// alert('checked:'.$result->first_name);
    foreach($results as $result){
        $_SESSION['id']= $result->id;
        $_SESSION['name']= $result->first_name." ".$result->last_name;
        $_SESSION['role_name']= $result->role_name;
        $_SESSION['image']= $result->file_name_uniqid;
        $_SESSION['role_name_id']= $result->role_name_id;
        $id_user = $result->role_name_id;
    }

    ////////////////////////////////////////////////////////

    if($id_user != ""){
    $sql_table = "SELECT ap.id AS page_id,rn.id,rn.role_name,rn.status,ur.id,ur.page_view ".
    " ,ur.page_add,ur.page_edit,ur.page_delete ".
    " ,ap.application_name,ap.type ".
    " from role_name rn ".
    " join user_role ur on rn.id = ur.id_role_name ".
    " JOIN application_page ap ON ap.id = ur.id_application ".
    " WHERE ur.status = 1 and ur.page_view = 1  AND rn.id = ".$id_user." ORDER BY ap.sort asc";
    // echo '<script>alert("sql role: '.$sql_table.'")</script>'; 
    // print($sql_table);
    $query_table = $dbh->prepare($sql_table);
    $query_table->execute();
    $results_table=$query_table->fetchAll(PDO::FETCH_OBJ);
    $role_name ="";
    $_SESSION["application_page"] = null;
    $id_page = 0;
        foreach($results_table as $result){ 
            $_SESSION["application_page"][$id_page] = $result->page_id;

            if($result->type == "entry"){
                $_SESSION["entry"] = 1;
            //     $_SESSION["entry_policy"][$id_page][0] = $result->page_id;
            }
            if($result->type == "report"){
                 $_SESSION["report"] = 1;
            }
            if($result->type == "user"){
                 $_SESSION["user"] = 1;
            }
            if($result->type == "setting"){
                 $_SESSION["setting"] = 1;
            }

            // if($result->page_id == 1){
            //     echo '<script>alert("run: '.$result->page_id.'")</script>'; 
            // }
            // $_SESSION["application_page"][$id_page][0] = $result->application_html;
            // $_SESSION["application_page"][$id_page][1] = $result->page_view;
            // $_SESSION["application_page"][$id_page][2] = $result->page_add;
            // $_SESSION["application_page"][$id_page][3] = $result->page_edit;
            // $_SESSION["application_page"][$id_page][4] = $result->page_delete;
            $id_page++;
        }
    }

    ////////////////////////////////////////////////////////

    echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";

}else{
    echo "<script>alert('Your username or password invalid.');</script>";
}

}else{
    echo "<script>alert('Your username or password invalid.');</script>";
}

}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Broker Install Direct</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" > <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body class="">
        <div class="main-wrapper">

            <div class="">
                <div class="row">
                    
                    <!-- <h1 align="center">Insurance Broker Management System</h1> -->
                        
                         <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <section class="section">
                                    <div class="text-center">
                                <img src="images/logo_small.png" width="200" class="logo">
                            </a>
                            <h1 align="center">Smart Broker System</h1>
                            <div class="row mt-1">
                                <!-- <div class="col-md-10 col-md-offset-1 pt-50"> -->
                                <div class="col-md-10 col-md-offset-1 pt-1">

                                    <div class="row mt-30 "  >
                                        <div class="col-md-11" >
                                            <div class="panel" >
                                                <div class="panel-heading">
                                                    <div class="panel-title text-center">
                                                        <!-- <h4>Admin Login</h4> -->
                                                    </div>
                                                </div>
                                                <div class="panel-body p-20" >

                                                    <form class="form-horizontal" method="post">
                                                    	<div class="form-group">
                                                    		<label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                                                    		<div class="col-sm-10">
                                                    			<input type="text" name="username" class="form-control" id="inputEmail3" placeholder="UserName"  >
                                                    		</div>
                                                    	</div>
                                                    	<div class="form-group">
                                                    		<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                                                    		<div class="col-sm-10">
                                                    			<input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password" >
                                                    		</div>
                                                    	</div>

                                                        <div class="form-group mt-20 ">
                                <div class="col-sm-6 text-left"  >
                                    <a href="forgot_password.php" style="color: #4590B8;">
                                         Forget Password
                                    </a>
                                </div> 
            
                                <div class="col-sm-6 text-right"  >
                                    <button type="submit" style="background-color: #0275d8;color: #F9FAFA;text-left" name="login" class="btn">Login<span class="btn-label btn-label-right"><i class="fa "></i></span></button>
                                </div>

                                                            <!-- pull-right -->
                                                        </div> 
                                                           <!--  <div class="col-sm-1">
                                                            </div>  -->

                                                    	</div>

                                                    </form>

                                            

                                                 
                                                </div>
                                            </div>
                                            <!-- /.panel -->
                                            <!-- <p class="text-muted text-center"><small>Student Result Management System</small></p> -->
                                        </div>
                                        <!-- /.col-md-11 -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                            <!-- /.row -->
                        </section>

                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /. -->

        </div>
        <!-- /.main-wrapper -->

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function(){

            });
        </script>

        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
    </body>
</html>
