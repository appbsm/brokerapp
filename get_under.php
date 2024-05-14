<?php
include('includes/config.php');
// $sql = "SELECT TOP 1 MAX(product_id) AS id FROM product WHERE id_product_categories ='{$_GET['id']}'";
$sql ="SELECT * FROM under WHERE id_agent = '{$_GET['id_agent']}' AND id_partner = '{$_GET['id_partner']}' ";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
echo json_encode($json);