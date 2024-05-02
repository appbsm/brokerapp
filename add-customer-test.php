<?php
session_start();
error_reporting(0);
include_once('includes/connect_sql.php');
include_once('includes/fx_crud_db.php');

$data['table'] = 'customer';
$data['columns'] = array(
'customer_name',
'customer_id', 
'title_name', 
'first_name', 
'last_name', 
'nick_name', 
'company_name', 
'tel', 
'mobile', 
'email', 
'address_number',
'building_name',
'soi', 
'road', 
'sub_district',
'district',
'province',
'post_code',
'cdate',
'create_by',
'id_rela_contact',
'id_rela_insurance_info',
'customer_type',
'personal_id',
'customer_level',
'status'
);

$data['values'] = array(
'Mychelle Taawan',
'ABC-123', 
'Ms. ', 
'Mychelle A', 
'Taawan', 
'My', 
'Buildersmart', 
'1111', 
'1234', 
'mychelle@buildersmasrt.com', 
'302',
'Taawan',
'Camp Dangwa', 
' ', 
'Alapang',
'La Trinidad',
'Benguet',
'2600',
date('Y-m-d H:i:s'),
1,
20,
102,
'Company',
'ABC-123',
1,
0
);

$data['id'] = 141;
$last_id = update_table ($conn, $data);

?>