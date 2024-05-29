<?php
include('includes/config.php');

$sql = "SELECT * from company_list cl ".
" JOIN rela_company_to_contact rela_c ON cl.id = rela_c.id_company ".
" JOIN contact con ON con.id = rela_c.id_contact ".
" WHERE cl.id={$_GET['id']}";
// " order by default_contact desc ";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
echo json_encode($json);
$dbh = null;