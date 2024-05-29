<?php
include('includes/config_company.php');

$sql = "SELECT top(1) cl.company_name FROM user_info us
left join company_list cl ON cl.id = us.id_company
WHERE company_code = '{$_GET['code_company']}'";

$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
echo json_encode($json);
$dbh = null;