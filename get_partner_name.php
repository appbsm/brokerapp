<?php
include('includes/config.php');

$sql = "SELECT top 1 * FROM insurance_partner WHERE insurance_company = '{$_GET['name']}' and insurance_company != '' ";
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