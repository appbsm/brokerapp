<?php
include('includes/config.php');

$sql = "SELECT cl.id,ip.id AS id_partner,cl.currency,cc.currency_value,cc.currency_value_convert
 FROM insurance_partner ip
 JOIN currency_list cl ON ip.id_currency_list = cl.id
 LEFT JOIN currency_convertion cc ON  cc.id = 
  (SELECT TOP 1 c_c.id FROM currency_convertion c_c WHERE  c_c.id_currency_list = ip.id_currency_list
 AND  GETDATE() >= c_c.start_date and GETDATE() <= c_c.stop_date and c_c.status='1')
 WHERE ip.id= '{$_GET['id']}'";

$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
echo json_encode($json);
$dbh = null;