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


?>