<?php
include('includes/config.php');



// $sql = "SELECT ag.id,ag.title_name,ag.first_name,ag.last_name,CONCAT(ag.title_name,' ',ag.first_name,' ',ag.last_name) as agent_namefull FROM rela_agent_to_insurance reag
// JOIN agent ag ON ag.id = reag.id_agent
// WHERE reag.id_insurance =  '{$_GET['id']}' and ag.status = '1' "
// ." GROUP BY ag.id,ag.title_name,ag.first_name,ag.last_name ";

// if (isset($_POST['action']) && $_POST['action'] == 'get_agen_fopage_partner') {
    $sql = "SELECT a.id AS id_agent,first_name,last_name,un.* from agent a 
     left join under un on un.id_agent = a.id 
     where a.id = '{$_GET['id']}'";

    $query = $dbh->prepare($sql);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    $json = array();
    foreach($results as $result){
        array_push($json, $result);
    }
    echo json_encode($json);
// }

// if (isset($_POST['action']) && $_POST['action'] == 'get_agen_fopage_agent') {
//     $sql = "SELECT a.id AS id_agent,first_name,last_name,un.* from agent a 
//      left join under un on un.id_agent = a.id 
//      where un.id_agent = '{$_GET['id']}'";

//     $query = $dbh->prepare($sql);
//     $query->execute();
//     $results=$query->fetchAll(PDO::FETCH_OBJ);
//     $json = array();
//     foreach($results as $result){
//         array_push($json, $result);
//     }
//     echo json_encode($json);
// }