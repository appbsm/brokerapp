<?
include_once('connect_sql.php');
include_once('fx_crud_db.php');
include('config_path.php');

function update_userinfo($conn, $post_data,$path) {
	// echo '<script>alert("id: '.$post_data['id'].'")</script>'; 
	$data['id'] = $post_data['id'];
	$data['table'] = 'user_info';
	$data['columns'] = array(
	'name_title',
	'first_name', 
	'last_name', 
	'nick_name', 
	'mobile', 
	'email', 
	'position', 
	'department'
	);
	$data['values'] = array(
	$post_data['title_name'],
	trim($post_data['first_name']),
	trim($post_data['last_name']),
	trim($post_data['nick_name']),
	trim($post_data['mobile']),
	trim($post_data['email']),
	trim($post_data['position']),
	trim($post_data['department'])
	);


	//////////// upload ////////////
	// echo '<script>alert("post file_d : '.$_FILES['file']['name'].'")</script>';
	$new_file_name="";
	if($_FILES['file']['name']!=""){
		try {
	                $file = $_FILES['file']['name'];
	                $file_loc = $_FILES['file']['tmp_name'];
	                // $image=$_POST['file_d'];
	                $folder=$path;
	                $ext = pathinfo($file, PATHINFO_EXTENSION);
	                $new_file_name = uniqid().".".$ext;
	                $path_file = $folder."/".$new_file_name;
	                $final_file = str_replace(' ','-',$new_file_name);
	                move_uploaded_file($file_loc,$folder.$final_file);
	    }catch(Exception $e) {
	        echo '<script>alert("Error : '.$e.'")</script>';
	    }
	    array_push($data['columns'],'file_name');
	    array_push($data['columns'],'file_name_uniqid');
	    array_push($data['values'],$_FILES['file']['name']);
	    array_push($data['values'],$new_file_name);
	    $_SESSION['image']= $new_file_name;
	}
	//////////// upload ////////////

	// $password=$post_data['password'];
    $newpassword=$post_data['newpassword'];
    $confirmpassword=$post_data['confirmpassword'];
    if($newpassword!="" && $confirmpassword!=""){
    	$pass_md5 = md5($newpassword);
    	// echo '<script>alert("$post_data[]: '.md5($post_data['password']).'")</script>'; 
    	array_push($data['columns'],'username');
	    array_push($data['values'],$post_data['username']);
    	array_push($data['columns'],'password');
	    array_push($data['values'],$pass_md5);

	    array_push($data['columns'],'password_decode');
	    array_push($data['values'],$newpassword);

	    $_SESSION['pass'] = $pass_md5;
    }
	update_table ($conn,$data);
}

function get_userinfo_old($conn,$user,$pass) {
	$password_md5=md5($pass);
	$result = array();
	$tsql ="SELECT Password FROM user_info WHERE username='".$user."' and password='".$password_md5."'";
 	// print_r($tsql);
        $stmt = sqlsrv_query( $conn, $tsql);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
        {
            $result[] = $row;
        }
     return $result;
}

function get_userinfo($conn,$user,$pass) {
    $result = array();
    $tsql ="SELECT role_name.role_name,user_info.* ".
 " FROM user_info ".
 " left JOIN role_name ON user_info.role_name_id = role_name.id  ".
 " WHERE username='".$user."' and password='".$pass."' and user_info.status = '1'";
 	// print_r($tsql);
        $stmt = sqlsrv_query( $conn, $tsql);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
        {
            $result[] = $row;
        }
        return $result;
}


?>