<?php
require 'PHPExcel/Classes/PHPExcel/IOFactory.php';

// Load Excel file
$objPHPExcel = PHPExcel_IOFactory::load('test_file_excel/Report_Sales_By_Customer.xlsx');

// Get worksheet dimensions
$sheet = $objPHPExcel->getActiveSheet();
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();

// Loop through each row of the worksheet
$data = array();
for ($row = 1; $row <= $highestRow; $row++) {
    // Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
    $data[] = $rowData[0];
}

// Output data in JSON format
echo json_encode($data);
?>
