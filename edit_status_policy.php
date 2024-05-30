<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['selectedCheckboxes']) && isset($_POST['inputData'])) {
        $selectedIds = $_POST['selectedCheckboxes'];
        $inputData = $_POST['inputData'];

        include('includes/config.php');
        include('includes/fx_policy_db.php');
        update_policy_status($dbh,$_POST);
        $dbh = null;

        $response = array(
            'test' => 'test',
            'status' => 'success',
            'selectedIds' => $selectedIds,
            'inputData' => $inputData
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // If required POST data is missing, return an error response
        $response = array(
            'status' => 'error',
            'message' => 'Required data missing'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    // If not a POST request, return an error response
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request method'
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
