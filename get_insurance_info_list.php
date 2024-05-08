<?php
include('includes/config.php');

// $sql = "SELECT * from company_list cl ".
// " JOIN rela_company_to_contact rela_c ON cl.id = rela_c.id_company ".
// " JOIN contact con ON con.id = rela_c.id_contact ".
// " WHERE cl.id={$_GET['id']}";

$sql = "SELECT cc.currency_value,cc.currency_value_convert
,FORMAT(insu.start_date, 'dd-MM-yyyy') as start_date_f,FORMAT(insu.end_date, 'dd-MM-yyyy') as end_date_f 
,FORMAT(paid_date, 'dd-MM-yyyy') as paid_date_f
,cl.id AS currency_id,cl.currency as currency_name,insu.* FROM rela_customer_to_insurance rela
JOIN insurance_info insu ON  rela.id_insurance_info = insu.id
LEFT JOIN insurance_partner ip ON ip.id = insu.insurance_company_id 
LEFT JOIN currency_list cl ON ip.id_currency_list = cl.id
LEFT JOIN currency_convertion cc ON  cc.id = 
(SELECT TOP 1 c_c.id FROM currency_convertion c_c WHERE  c_c.id_currency_list = ip.id_currency_list
 AND  insu.start_date >= c_c.start_date and insu.start_date <= c_c.stop_date and c_c.status='1')
WHERE rela.id_default_insurance ={$_GET['id']}"." and rela.id_insurance_info != {$_GET['id']}";

// " order by default_contact desc ";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
echo json_encode($json);