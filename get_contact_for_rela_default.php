<?php
include('includes/config.php');

// $sql = "SELECT con.* FROM customer ct 
//  INNER JOIN rela_customer_to_contact rc ON ct.id = rc.id_customer 
//  INNER JOIN contact con ON con.id = rc.id_contact 
//  WHERE ct.id={$_GET['id']}";

$sql = "SELECT con.* FROM contact con 
 WHERE con.id={$_GET['id']}";
// " order by default_contact desc ";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}

echo json_encode($json);
$dbh = null;