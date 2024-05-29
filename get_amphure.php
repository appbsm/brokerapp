<?php
include('includes/config.php');

$sql = "SELECT * FROM district WHERE province_code={$_GET['province_id']}";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
// $sql = "SELECT * FROM amphures WHERE province_id={$_GET['province_id']}";
// $query = mysqli_query($conn, $sql);

// $json = array();
// while($result = mysqli_fetch_assoc($query)) {    
//     array_push($json, $result);
// }

echo json_encode($json);
$dbh = null;