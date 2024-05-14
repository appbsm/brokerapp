<?php 

// define('DB_HOST','BUILDER-LOGIS\SQLEXPRESS');
define('DB_HOST','192.168.20.211');
define('DB_USER','sa');
define('DB_PASS','bsm@2015');
define('DB_NAME','brokerapp');

//ad,om
//Test@123


try{
// $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
	$dbh = new PDO("sqlsrv:Server=".DB_HOST.";Database=".DB_NAME,DB_USER,DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
	$dbh->exec("SET CHARACTER SET utf8"); 
}catch (PDOException $e){
	echo "<br>"."Error ".$e."<br>";
exit("Error: " . $e->getMessage());
}


// $sql ="SELECT top(1) role_name.role_name,role_name.id AS role_name_id,user_info.* 
//  FROM user_info
//  left JOIN role_name ON user_info.role_name_id = role_name.id 
//  WHERE username=:uname and password=:password and user_info.status = '1'  ";

session_name("broker");
session_start();


// $uname=$_POST['username'];
// $password=md5($_POST['password']);

// $query= $dbh -> prepare($sql);
// $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
// $query-> bindParam(':password', $password, PDO::PARAM_STR);
// $query-> execute();
// $results=$query->fetchAll(PDO::FETCH_OBJ);
// if($query->rowCount() == 0){
// 	header("Location: index.php"); 
// }

// echo '<script>alert("alogin: '.$_SESSION['alogin'].'")</script>'; 

// if(strlen($_SESSION['alogin'])==""){   
// 		header("Location: index.php"); 
// }


// function decrypt_pass($input) {
// 	// $input = "SmackFactory";
// 	try{
// 		// $encrypted = encryptIt( $input );
// 		// $decrypted = decryptIt( $encrypted );

// 		// echo $encrypted . '<br />' . $decrypted;

// 		// function encryptIt( $q ) {
// 		//     $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
// 		//     $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
// 		//     return( $qEncoded );
// 		// }

// 		// function decryptIt( $q ) {
// 		//     $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
// 		//     $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
// 		//     return( $qDecoded );
// 		// }
// 	}catch (Exception $e){
// 	// 	// echo "<br>"."Error ".$e."<br>";
// 	// 	// exit("Error: " . $e->getMessage());
// 		return('');
// 	}
	
// }

// session_name("broker");

// ini_set('display_errors', 1);
// 	error_reporting(~0);

//    $serverName = "localhost";
//    $userName = "sa";
//    $userPassword = "bsm@2015";
//    $dbName = "eco_dashboard";
  
//    $connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "MultipleActiveResultSets"=>true);

//    $dbh = sqlsrv_connect( $serverName, $connectionInfo);

// 	if($dbh)
// 	{
// 		echo "Database Connected.";
// 	}
// 	else
// 	{
// 		die( print_r( sqlsrv_errors(), true));
// 	}

// 	sqlsrv_close($dbh);

?>