<?php
include('includes/config.php');

$sql = "SELECT top 1 * FROM customer WHERE tax_id='{$_GET['tax_id']}' and tax_id!='' ";
if($_GET['id']!=""){
    $sql =$sql." and id != '{$_GET['id']}'";
}
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
echo json_encode($json);
$dbh = null;