<?php

//import.php

if(!empty($_FILES['csv_file']['name']))
{
 $file_data = fopen($_FILES['csv_file']['name'], 'r');
 fgetcsv($file_data);
 // while($row = fgetcsv($file_data))
 // {
 //  $data[] = array(
 //   'student_id'  => $row[0],
 //   'student_name'  => $row[1],
 //   'student_phone'  => $row[2]
 //  );
 // }
 while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
    $data[] = array(
        $objArr[0]  => $row[0],
        $objArr[1]  => $row[1],
        $objArr[1]  => $row[2]
        );
    }
 echo json_encode($data);
}

?>
