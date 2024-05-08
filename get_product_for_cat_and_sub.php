<?php
include('includes/config.php');

$sql = "SELECT pc.id AS id_product_categories,ps.id AS product_subcategories,pr.* FROM product pr
LEFT JOIN product_categories pc ON pc.id = pr.id_product_categories
LEFT JOIN product_subcategories ps ON ps.id = pr.id_product_sub WHERE pr.id='{$_GET['id']}'";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
echo json_encode($json);