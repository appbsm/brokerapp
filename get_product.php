<?php
include('includes/config.php');

$sql = "SELECT pr.* FROM product pr
JOIN rela_partner_to_product rp ON rp.id_product = pr.id
WHERE rp.id_partner = '{$_GET['id']}'";

$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
echo json_encode($json);