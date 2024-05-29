<?php
include('includes/config.php');

$sql = "SELECT * from customer ";
// " order by default_contact desc ";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$json = array();
foreach($results as $result){
    array_push($json, $result);
}
// header('Content-Type: application/vnd.ms-excel');
// header('Content-Disposition: attachment;filename="customer_list.xls"');
// header('Cache-Control: max-age=0');
header('Content-Type: application/json');
echo json_encode($json);
// $data = json_decode($_POST['data'], true);
// require 'PHPExcel2/Classes/PHPExcel.php';
// $objPHPExcel = new PHPExcel();

// $objPHPExcel->getActiveSheet()->fromArray($data, null, 'A1');

// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

// // สร้างชื่อไฟล์ที่เป็นไปได้และเก็บลงในตัวแปร $fileName

// // บันทึกไฟล์ Excel ลงในเซิร์ฟเวอร์
// $filePath = 'D:/web test/' . $fileName;
// $objWriter->save($filePath);

// // ส่งข้อมูลกลับไปยัง JavaScript ด้วย URL ของไฟล์ Excel ที่สร้างขึ้น
// echo json_encode(array('fileUrl' => $filePath, 'fileName' => $fileName));
$dbh = null;
?>

