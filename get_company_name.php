<?php
include('includes/config_company.php');

$sql = "SELECT top(1) cl.company_name FROM company_list cl WHERE company_code = '{$_GET['code_company']}'";

$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
echo json_encode($json);
$dbh = null;