<?php
include('includes/config.php');

// $sql = "SELECT pr.* FROM product pr
// JOIN rela_partner_to_product rp ON rp.id_product = pr.id
// WHERE rp.id_partner != '{$_GET['id']}'";

$sql = "SELECT 'true' AS status_id,pr.* FROM product pr 
JOIN rela_partner_to_product rp ON rp.id_product = pr.id
WHERE rp.id_partner = '{$_GET['id']}'
UNION ALL
SELECT 'false' AS status_id,pr.* FROM product pr WHERE ID NOT IN(SELECT pr_i.id FROM product pr_i 
JOIN rela_partner_to_product rp ON rp.id_product = pr_i.id 
WHERE rp.id_partner = '{$_GET['id']}'); ";


$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
echo json_encode($json);
$dbh = null;