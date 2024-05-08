<?php
include('includes/config.php');
// เชื่อมต่อฐานข้อมูล หรือเรียกใช้งานตามความเหมาะสมกับโปรแกรมของคุณ
// require_once("database_connection.php");

// รับค่า $id_customer จาก URL parameters
$id_customer = $_GET['id_customer'];

// เขียนคำสั่ง SQL สำหรับดึงข้อมูลลูกค้าที่เกี่ยวข้องกับ $id_customer
$sql_c = "SELECT con.* FROM customer ct
        LEFT JOIN rela_customer_to_contact re_c ON ct.id = re_c.id_customer
        LEFT JOIN contact con ON con.id = re_c.id_contact
        WHERE re_c.id_customer ='".$id_customer."'";
// เรียกใช้งานฐานข้อมูล เช่น PDO หรือ MySQLi
$query_c = $dbh->prepare($sql_c);
$query_c->execute();
$results_c = $query_c->fetchAll(PDO::FETCH_OBJ);

// สร้างตัวแปร $results_c เพื่อจำลองข้อมูลที่ได้จากการ query จากฐานข้อมูล
// ถ้าใช้งานฐานข้อมูลจริง ให้เปลี่ยนข้อมูลนี้ตามลักษณะของข้อมูลจริง
// $results_c = [
//     [
//         'title_name' => 'Mr.',
//         'first_name' => 'John',
//         'last_name' => 'Doe',
//         'nick_name' => 'JD',
//         'tel' => '123456789',
//         'mobile' => '987654321',
//         'email' => 'john@example.com'
//     ],
//     // ข้อมูลลูกค้าเพิ่มเติมที่ต้องการแสดง
// ];

// ตรวจสอบว่ามีข้อมูลหรือไม่

if(count($results_c) > 0) {
    // แสดงข้อมูลลูกค้าในรูปแบบ HTML
    foreach($results_c as $result) {
        echo "<tr>";
        // echo "<td class='text-center'></td>"; // สร้างเฉพาะตามลำดับของคอลัมน์ในตาราง
        // echo "<td class='title_name_c text-center'>".$result->title_name."</td>";
        // echo "<td class='first_name_c'>".$result->first_name."</td>";

        echo "<td hidden='true' ></td>";
        echo "        <td class='text-center'>";
        echo "        <i title='Select Record' class='editAction_contact'>";
        echo "            <a >";
        echo "                <svg height='20' viewBox='0 0 256 256' width='20' ><g fill='none' stroke='#000' stroke-linecap='round' stroke-linejoin='round' stroke-width='16'><path d='m16.000736 48.000563a31.999783 31.999783 0 0 1 31.999783-31.999781'/><path d='m-239.99926 48.000563a31.999783 31.999783 0 0 1 31.99978-31.999781' transform='scale(-1 1)'/><path d='m-239.99926-207.99947a31.999783 31.999783 0 0 1 31.99978-31.99978' transform='scale(-1)'/><path d='m16.000736-207.99947a31.999783 31.999783 0 0 1 31.999783-31.99978' transform='scale(1 -1)'/><path d='m239.99923 143.99987v31.9998'/><path d='m239.99923 80.000312v31.999798'/><path d='m16.000747 143.99991v31.99976'/><path d='m16.000751 80.000312v31.999798'/><path d='m112.00008 16.000744h-31.999796'/><path d='m175.99964 16.000748h-31.99976'/><path d='m112.00008 239.99922h-31.999796'/><path d='m175.99964 239.99922h-31.99976'/><path d='m96.000202 127.99999h63.999558'/><path d='m128 96.000192v63.999598'/></g></svg>";
        echo "            </a>";
        echo "        </i>";
        echo "        </td>";

        echo "        <td class='title_name_c text-center'>".$result->title_name."</td>";
        echo "        <td class='first_name_c'>".$result->first_name."</td>";
        echo "        <td class='last_name_c text-center' >".$result->last_name."</td>";
        echo "        <td class='nick_name_c' >".$result->nick_name."</td>";
        echo "        <td class='tel_c text-center'>".$result->tel."</td>";
        echo "        <td class='mobile_c text-center'>".$result->mobile."</td>";
        echo "        <td class='email_c text-center'>".$result->email."</td>";

        echo "        <td class='id_c' hidden='true' >".$result->id."</td>";
        echo "        <td class='line_id_c' hidden='true' >".$result->line_id."</td>";
        echo "        <td class='position_c' hidden='true' >".$result->position."</td>";
        echo "        <td class='remark_c' hidden='true' >".$result->remark."</td>";
        echo "        <td class='default_contact_c' hidden='true' >".$result->default_contact."</td>";
        echo "        <td class='department_c' hidden='true' >".$result->department."</td>";
        
        echo "</tr>";
    }

    
} else {
    // ถ้าไม่มีข้อมูลลูกค้า
    echo "<tr><td colspan='8'>No data found</td></tr>";
}

?>
