<?php

include('includes/config_non_session_name.php');
session_name("broker");
session_start();

$uname=$_GET['username'];
// $password=md5($_GET['password']);
$password=$_GET['password'];

if($uname!="" and $password!=""){

// $_GET['id']  $_GET['companay']

// $sql = "SELECT ag.id,ag.title_name,ag.first_name,ag.last_name,CONCAT(ag.title_name,' ',ag.first_name,' ',ag.last_name) as agent_namefull FROM rela_agent_to_insurance reag
// JOIN agent ag ON ag.id = reag.id_agent
// WHERE reag.id_insurance =  '{$_GET['id']}' and ag.status = '1' "$results_agent
// ." GROUP BY ag.id,ag.title_name,ag.first_name,ag.last_name ";

    $sql ="SELECT top(1) role_name.role_name,role_name.id AS role_name_id,user_info.* 
     FROM user_info
     left JOIN role_name ON user_info.role_name_id = role_name.id 
     WHERE username=:uname and password=:password and user_info.status = '1' ";
     $query= $dbh -> prepare($sql);
    $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    foreach($results as $result){
        $_SESSION['id']= $result->id;
        $_SESSION['name']= $result->first_name." ".$result->last_name;
        $_SESSION['role_name']= $result->role_name;
        $_SESSION['image']= $result->file_name_uniqid;
        $_SESSION['role_name_id']= $result->role_name_id;
        $id_user = $result->role_name_id;
        $path_web = $result->path_web;
       $_SESSION["system_admin"] = $result->system_admin;
    }
   
    if($query->rowCount() > 0){

        $_SESSION['alogin']=$uname;
        $_SESSION['pass']=$password;

        $id_user = $result->role_name_id;
        // echo '<script>alert("alogin: '.$_SESSION['alogin'].'")</script>'; 
        if($id_user != ""){

        $sql_table = "SELECT ap.id AS page_id,rn.id,rn.role_name,rn.status,ur.id,ur.page_view ".
        " ,ur.page_add,ur.page_edit,ur.page_delete ".
        " ,ap.application_name,ap.type ".
        " from role_name rn ".
        " join user_role ur on rn.id = ur.id_role_name ".
        " JOIN application_page ap ON ap.id = ur.id_application ".
        " WHERE ur.status = 1 and ur.page_view = 1  AND rn.id = ".$id_user." ORDER BY ap.sort asc";
        
        // print($sql_table);
        $query_table = $dbh->prepare($sql_table);
        $query_table->execute();
        $results_table=$query_table->fetchAll(PDO::FETCH_OBJ);
        $role_name ="";
            $_SESSION["application_page"] = null;
            $id_page = 0;
            foreach($results_table as $result){ 

                $page_data = array(
                    "page_id" => $result->page_id,
                    "page_view" => $result->page_view,
                    "page_add" => $result->page_add,
                    "page_edit" => $result->page_edit,
                    "page_delete" => $result->page_delete,
                    "status" => $result->status
                );
                $_SESSION["application_page_status"][$id_page] = $page_data;

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

                $id_page++;
            }
            $dbh = null; 
        }
        echo "<script>window.location.href ='Dashboard.php'</script>";
    }else{
        $dbh = null; 
        echo "<script>window.location.href ='index.php'</script>";
    }

}else{
    $dbh = null; 
    echo "<script>window.location.href ='index.php'</script>";
}
  $dbh = null; 
?>