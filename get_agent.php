<?php
include('includes/config.php');

// $sql = "SELECT ag.id,ag.title_name,ag.first_name,ag.last_name,CONCAT(ag.title_name,' ',ag.first_name,' ',ag.last_name) as agent_namefull FROM rela_agent_to_insurance reag
// JOIN agent ag ON ag.id = reag.id_agent
// WHERE reag.id_insurance =  '{$_GET['id']}' and ag.status = '1' "$results_agent
// ." GROUP BY ag.id,ag.title_name,ag.first_name,ag.last_name ";

$sql =" SELECT CONCAT(ag.title_name,' ',ag.first_name,' ',ag.last_name) as agent_namefull,MIN(ag.id) id
 ,ag.title_name,ag.first_name,ag.last_name 
 FROM under un 
 LEFT JOIN agent ag ON ag.id = un.id_agent 
 WHERE ag.status = '1' and id_partner = '{$_GET['id']}' GROUP BY ag.first_name,ag.last_name,ag.title_name";

$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
echo json_encode($json);