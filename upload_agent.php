<?php
session_start();
error_reporting(0);

include('includes/config.php');

if (empty($_SESSION['alogin'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['submit'])) {
    $file = $_FILES['file']['tmp_name'];

    require 'PHPExcel2/Classes/PHPExcel.php';
    require 'PHPExcel2/Classes/PHPExcel/IOFactory.php';

    $inputFileType = PHPExcel_IOFactory::identify($file);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($file);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

    // Prepare the SQL statement for inserting data
    $sql = "INSERT INTO agent (agent_ctr, agent_id, title_name, first_name, last_name, nick_name, agent_type, tax_id, address_number, building_name, soi, road, sub_district, district, province, post_code, tel, mobile, email, id_rela_agent_insurance, status, cdate, udate, create_by, modify_by) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $dbh->prepare($sql);

    foreach ($sheetData as $row) {
        // Bind parameters to the prepared statement
        $stmt->bind_param("ssssssssssssssssssssssss", 
            $row['agent_ctr'],
            $row['agent_id'],
            $row['title_name'],
            $row['first_name'],
            $row['last_name'],
            $row['nick_name'],
            $row['agent_type'],
            $row['tax_id'],
            $row['address_number'],
            $row['building_name'],
            $row['soi'],
            $row['road'],
            $row['sub_district'],
            $row['district'],
            $row['province'],
            $row['post_code'],
            $row['tel'],
            $row['mobile'],
            $row['email'],
            $row['id_rela_agent_insurance'],
            $row['status'],
            $row['cdate'],
            $row['udate'],
            $row['create_by'],
            $row['modify_by']
        );

        // Execute the prepared statement
        $stmt->execute();
    }

    // Close the statement
    $stmt->close();

    // Redirect to the appropriate page after data import
    echo '<script>alert("Data imported successfully.");</script>';
    echo "<script>window.location.href ='https://www.brokerapp.asia/agent-import.php'</script>"; 
}

?>
