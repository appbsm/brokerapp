<?php
include('includes/config.php');

$sql = "SELECT * FROM subdistrict WHERE code={$_GET['code_id']}";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}

echo json_encode($json);