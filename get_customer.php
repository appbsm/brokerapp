<?php
include('includes/config.php');

$sql = "SELECT cl.description,ct.* FROM customer ct 
 left JOIN rela_customer_to_contact rc ON ct.id = rc.id_customer 
 left JOIN contact con ON con.id = rc.id_contact 
 LEFT JOIN customer_level cl ON ct.customer_level = cl.id
 WHERE ct.id={$_GET['id']}";
// " order by default_contact desc ";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}

// $sql = "SELECT * FROM districts WHERE amphure_id={$_GET['amphure_id']}";
// $query = mysqli_query($conn, $sql);

// $json = array();
// while($result = mysqli_fetch_assoc($query)) {    
//     array_push($json, $result);
// }

echo json_encode($json);
$dbh = null;