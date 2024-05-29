<?php 

// define('DB_HOST','BUILDER-LOGIS\SQLEXPRESS');
define('DB_HOST','192.168.20.211');
define('DB_USER','sa');
define('DB_PASS','bsm@2015');
define('DB_NAME','broker_company');

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