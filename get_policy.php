<?php
include('includes/config.php');

$sql = "SELECT top 1 id FROM insurance_info WHERE policy_no ='{$_GET['policy']}' and policy_no !='' ";
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