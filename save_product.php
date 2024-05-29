<?php
// include('includes/config.php');
include_once('includes/connect_sql.php');
include_once('includes/fx_crud_db.php');


if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$json = file_get_contents('php://input');

    // แปลง JSON เป็นอาร์เรย์
    $selectedValues = json_decode($json, true);

    // ตรวจสอบว่ามีข้อมูลหรือไม่ก่อนที่จะดำเนินการต่อ
    if (!empty($selectedValues)) {
        // ทำการประมวลผลข้อมูลที่รับเข้ามา
        // ในที่นี้เราจะแสดงค่าที่ได้รับเพื่อตรวจสอบว่าได้รับข้อมูลถูกต้องหรือไม่

        $rela_products = get_rela_partner_to_product($conn,$_GET['id']);
        delete_rela_product_list($conn,$selectedValues,$rela_products);
        update_partner($conn,$selectedValues,$rela_products,$_GET['id']);
        // foreach ($selectedValues as $values) {
        //     print_r("value:".$values[0]);
        // }
        print_r($selectedValues."testtest:".$_GET['id']."count".count($selectedValues));
    } else {
        // ถ้าไม่มีข้อมูลถูกส่งมา
        echo "No data received.";
    }
}else {
	echo "Invalid request method.";
}

function delete_rela_product_list($conn,$selectedValues,$rela_product) {
    // echo '<script>alert("start'.$rela_product[0]['id'].'")</script>'; 
    $array_delete=array();
    foreach($rela_product as $data) {
        if (!in_array($data['id_product'],$selectedValues)) { 
            array_push($array_delete,$data['id']);
        }
    }
    foreach($array_delete as $value) {
        $data['id'] = $value;
        $data['table'] = 'rela_partner_to_product'; 
        delete_table ($conn, $data);
    }
}

function get_rela_partner_to_product($conn, $id) {
    $result = array();
    $sql = "SELECT * FROM rela_partner_to_product WHERE id_partner = '".$id."'";
        $stmt = sqlsrv_query( $conn, $sql);
        if($stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
            $result[] = $row;
        }
    return $result;
}

function update_partner ($conn, $selectedValues,$rela_products,$id) {
    $data_rel_product['table'] = 'rela_partner_to_product';
    $data_rel_product['columns'] = array(
        'id_partner',
        'id_product'
    );

    foreach ($selectedValues as $values) {
        $duplicate_information = "false";
        foreach ($rela_products as $rela){
            if($values[0]==$rela['id_product']){
                $duplicate_information = "true";
            }
        }

        if($duplicate_information=="false"){
            $data_rel_product['values'] = array(
                $id,
                $values[0]
            );
            insert_table ($conn, $data_rel_product);
        }
    }
}

?>

<?php sqlsrv_close($conn); ?>