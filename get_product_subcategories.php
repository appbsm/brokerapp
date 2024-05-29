<?php
include('includes/config.php');

$sql = "SELECT * FROM product_subcategories WHERE id_product_categorie='{$_GET['id']}' and status =1 ";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
echo json_encode($json);
$dbh = null;