<?php
include('includes/config.php');

$sql = "SELECT * FROM product_categories WHERE type='{$_GET['type']}'";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
echo json_encode($json);