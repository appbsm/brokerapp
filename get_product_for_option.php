<?php
include('includes/config.php');

// $sql = "SELECT TOP 1 MAX(product_id) AS id FROM product WHERE id_product_categories ='{$_GET['id']}'";
$sql = "SELECT TOP 1 MAX(product_id) AS id,pc.first_letters FROM product pd
 RIGHT JOIN product_categories pc ON pc.id = pd.id_product_categories
WHERE pc.id = '{$_GET['id']}'
group BY pc.first_letters";


// echo $sql;
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
echo json_encode($json);