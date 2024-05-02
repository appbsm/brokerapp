<?php
include('includes/config.php');

$sql = "SELECT cl.id,cl.currency FROM insurance_partner ip
 JOIN currency_list cl ON ip.id_currency_list = cl.id
 WHERE ip.id = '{$_GET['id']}'";



$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
echo json_encode($json);