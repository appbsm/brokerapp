<?php
// include_once('connect_sql.php');
include_once('fx_crud_db.php');

function get_customers_sales_start($conn) {
    $result = array();
    $sql ="SELECT 
    CASE WHEN cu.customer_type = 'Personal'
          THEN CONCAT(cu.first_name,' ',cu.last_name)
          ELSE cu.company_name
          END as full_name
,info.policy_no
,FORMAT(info.start_date, 'dd-MM-yyyy') AS in_start_date,FORMAT(info.end_date, 'dd-MM-yyyy') AS in_end_date
,info.premium_rate,info.status as in_status
,con.first_name as first_name_con,con.last_name as last_name_con,con.position
,info.paid_date AS paid_date_insurance
,info.convertion_value 
,cc.currency_value,cc.currency_value_convert
,(SELECT currency from currency_list WHERE id =cc.id_currency_list ) AS id_currency_list_v
,(SELECT currency from currency_list WHERE id =cc.id_currency_list_convert ) AS id_currency_list_convert_v
,cl.currency,cc.id_currency_list,cc.id_currency_list_convert
,ip.insurance_company,ip.insurance_id
,con_p.first_name AS first_name_p,con_p.last_name AS last_name_p
,con_p.email AS email_p,con_p.mobile AS mobile_p,con_p.remark AS remark_p,con_p.department AS department_p
,pcat.categorie,psup.subcategorie,cu.* FROM customer cu
LEFT JOIN rela_customer_to_insurance  recu ON cu.id = recu.id_customer
 JOIN insurance_info info ON info.id = recu.id_insurance_info
LEFT JOIN contact con ON con.id =

 ( SELECT con_t.id  FROM rela_customer_to_contact rec 
 JOIN contact con_t ON con_t.id = rec.id_contact AND con_t.default_contact = 1
 WHERE rec.id_customer = cu.id)

LEFT JOIN product_categories pcat ON pcat.id = info.product_category
LEFT JOIN product_subcategories psup ON psup.id = info.sub_categories
LEFT JOIN insurance_partner ip ON ip.id = info.insurance_company_id
LEFT JOIN contact con_p ON con_p.id =
 ( SELECT con_t.id  FROM rela_partner_to_contact rec 
 JOIN contact con_t ON con_t.id = rec.id_contact AND con_t.default_contact = 1
 WHERE rec.id_insurance_partner = ip.id)
LEFT JOIN currency_list cl ON cl.id = ip.id_currency_list
LEFT JOIN currency_convertion cc ON  cc.id = 
  (SELECT TOP 1 c_c.id FROM currency_convertion c_c WHERE  c_c.id_currency_list = ip.id_currency_list
 AND  info.start_date >= c_c.start_date and info.start_date <= c_c.stop_date and c_c.status='1')

ORDER BY full_name ASC";

//   INNER JOIN (
//     SELECT 
//         policy_primary, MAX(cdate) AS max_cdate
//     FROM 
//         insurance_info where policy_no != ''
//     GROUP BY 
//         policy_primary
// ) latest ON info.policy_primary = latest.policy_primary AND info.cdate = latest.max_cdate

 // AND  info.paid_date >= c_c.start_date and info.paid_date <= c_c.stop_date)

// (SELECT TOP 1 c_c.id FROM currency_convertion c_c WHERE  c_c.id = ip.id_currency_list
//   OR cc.id_currency_list_convert    = cl.id
    // $sql = $sql." order by LTRIM(ct.first_name) asc ";
    $stmt = sqlsrv_query( $conn, $sql);  
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))    
    {    
        $result[] = $row;
    } 

    return $result;
}    

function get_customers_sales_search($conn,$post_data) {

    $sql_join_date = "";

    if (isset($post_data['start_date']) && $post_data['start_date'] != '') {
        $sql_join_date = " and start_date >= '".date("Y-m-d", strtotime($post_data['start_date']))."' ";
    }
    if (isset($post_data['end_date']) && $post_data['end_date'] != '') {
        $sql_join_date = " and start_date <= '".date("Y-m-d", strtotime($post_data['end_date']))."' ";
    }

    $result = array();
     $sql ="SELECT CASE WHEN cu.customer_type = 'Personal'
          THEN CONCAT(cu.first_name,' ',cu.last_name)
          ELSE cu.company_name
          END as full_name ,info.policy_no ".
",FORMAT(info.start_date, 'dd-MM-yyyy') AS in_start_date,FORMAT(info.end_date, 'dd-MM-yyyy') AS in_end_date".
",info.premium_rate,info.status as in_status".
",con.first_name as first_name_con,con.last_name as last_name_con,con.position".
",info.paid_date AS paid_date_insurance".
",info.convertion_value".
",cc.currency_value,cc.currency_value_convert".
",(SELECT currency from currency_list WHERE id =cc.id_currency_list ) AS id_currency_list_v".
",(SELECT currency from currency_list WHERE id =cc.id_currency_list_convert ) AS id_currency_list_convert_v".
",cl.currency,cc.id_currency_list,cc.id_currency_list_convert".
",ip.insurance_company,ip.insurance_id".
",con_p.first_name AS first_name_p,con_p.last_name AS last_name_p".
",con_p.email AS email_p,con_p.mobile AS mobile_p,con_p.remark AS remark_p,con_p.department AS department_p".
",pcat.categorie,psup.subcategorie,cu.* FROM customer cu".
" LEFT JOIN rela_customer_to_insurance  recu ON cu.id = recu.id_customer".
" JOIN insurance_info info ON info.id = recu.id_insurance_info".
" LEFT JOIN contact con ON con.id = ".
' ( SELECT con_t.id  FROM rela_customer_to_contact rec '.
' JOIN contact con_t ON con_t.id = rec.id_contact AND con_t.default_contact = 1'.
' WHERE rec.id_customer = cu.id) '.
" LEFT JOIN product_categories pcat ON pcat.id = info.product_category".
" LEFT JOIN product_subcategories psup ON psup.id = info.sub_categories".
" LEFT JOIN insurance_partner ip ON ip.id = info.insurance_company_id".
" LEFT JOIN contact con_p ON con_p.id =".
" ( SELECT con_t.id  FROM rela_partner_to_contact rec ".
" JOIN contact con_t ON con_t.id = rec.id_contact AND con_t.default_contact = 1".
" WHERE rec.id_insurance_partner = ip.id)".
" LEFT JOIN currency_list cl ON cl.id = ip.id_currency_list".
" LEFT JOIN currency_convertion cc ON  cc.id = ".
" (SELECT TOP 1 c_c.id FROM currency_convertion c_c WHERE  c_c.id_currency_list = ip.id_currency_list ".
" AND  info.start_date >= c_c.start_date and info.start_date <= c_c.stop_date and c_c.status='1') ".
" where info.policy_no != '' " ;

//  INNER JOIN (
//     SELECT 
//         policy_primary, MAX(cdate) AS max_cdate
//     FROM 
//         insurance_info where policy_no != '' ".$sql_join_date.
//    " GROUP BY 
//         policy_primary
// ) latest ON info.policy_primary = latest.policy_primary AND info.cdate = latest.max_cdate 

// AND  info.start_date >= c_c.start_date and info.start_date <= c_c.stop_date and c_c.status='1'

// " (SELECT TOP 1 c_c.id FROM currency_convertion c_c WHERE  c_c.id = ip.id_currency_list ".
// " OR cc.id_currency_list_convert    = cl.id ".

    if (isset($post_data['start_date']) && $post_data['start_date'] != '') {
        $sql .= " and info.start_date >= '".date("Y-m-d", strtotime($post_data['start_date']))."' ";
    }
    if (isset($post_data['end_date']) && $post_data['end_date'] != '') {
        $sql .= " and info.start_date <= '".date("Y-m-d", strtotime($post_data['end_date']))."' ";
    }

        if ($post_data['customer'] != 'all' ) {
            $sql .= " and cu.id = ".$post_data['customer'];
        }
        if ($post_data['partner']!="all") {
            $sql .= " and ip.id = ".$post_data['partner'];
        }
        if ($post_data['policy_no'] != 'all') {
            $sql .= " and info.policy_no = '".$post_data['policy_no']."' ";
        }
        if ($post_data['status'] != 'all') {
            $sql .= " and info.status = '".$post_data['status']."' ";
        }
        if ($post_data['product_cat'] != 'all' ) {
            $sql .= " and info.product_category = ".$post_data['product_cat'];
        }
        if ($post_data['sub_cat'] != 'all') {
            $sql .= " and info.sub_categories = ".$post_data['sub_cat'];
        }

$sql .= " ORDER BY full_name ASC ";
// print_r($sql);
// echo '<script>alert("sql search: '.$sql.'")</script>'; 
    $stmt = sqlsrv_query( $conn, $sql);  
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))    
    {    
        $result[] = $row;
    } 
    return $result;
}

function get_customers_list ($conn) {
    $result = array();
 //    $tsql = "select c.id,CASE WHEN c.customer_type = 'Personal' 
 // THEN CONCAT(c.title_name, ' ', c.first_name, ' ', c.last_name) 
 // ELSE company_name 
 //  END as customer_name
 // from insurance_info ii
 // left join rela_customer_to_insurance rci on rci.id_insurance_info = ii.id
 // left join customer c on c.id = rci.id_customer
 // where c.id IS NOT NULL order by c.last_name, c.first_name ";
    $tsql = "select DISTINCT(c.id),c.customer_type "
        . ",CASE WHEN c.customer_type = 'Personal' "
        . " THEN CONCAT(c.title_name, ' ', c.first_name, ' ', c.last_name) "
        . " ELSE company_name "
        . " END as customer_name "
        . ", c.last_name, c.first_name "
        . "from insurance_info ii "
        . "left join rela_customer_to_insurance rci on rci.id_insurance_info = ii.id "
        . "left join customer c on c.id = rci.id_customer "
        . "where c.id IS NOT NULL "
        . "order by c.last_name, c.first_name ";
                        //echo $tsql;
                        // echo '<script>alert("sql: '.$tsql.'")</script>'; 
                        $stmt = sqlsrv_query( $conn, $tsql);
                        if( $stmt === false) {
                            // die( print_r( sqlsrv_errors(), true) );
                        }
                        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
                        {
                            $result[] = $row;
                        }
                        return $result;
}

function get_products($conn) {
    $result = array();
    $tsql = "SELECT * FROM product ";
    
    $stmt = sqlsrv_query( $conn, $tsql);
    if( $stmt === false) {
        // die( print_r( sqlsrv_errors(), true) );
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
    {
        $result[] = $row;
    }
    return $result;
}

function get_policy_no ($conn) {
    $result = array();
    $tsql = "SELECT max(ii.id), ii.policy_no 
        from insurance_info ii 
        where policy_no IS NOT NULL AND  policy_no != ''
        GROUP BY policy_no
        order by policy_no ";
    //echo $tsql;
    $stmt = sqlsrv_query( $conn, $tsql);
    if( $stmt === false) {
        // die( print_r( sqlsrv_errors(), true) );
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
    {
        $result[] = $row;
    }
    return $result;
}

function get_partners ($conn) {
    $result = array();
    $tsql = "select * from insurance_partner where status = 1 order by insurance_company ASC ";
    $stmt = sqlsrv_query( $conn, $tsql);
    if( $stmt === false) {
        // die( print_r( sqlsrv_errors(), true) );
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
    {
        $result[] = $row;
    }
    return $result;
}

function get_product_categories ($conn) {
    $result = array();
    $tsql = "SELECT * FROM product_categories ";
    
    $stmt = sqlsrv_query( $conn, $tsql);
    if( $stmt === false) {
        // die( print_r( sqlsrv_errors(), true) );
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
    {
        $result[] = $row;
    }
    return $result;
}

function get_product_subcategory ($conn) {
    $result = array();
    $tsql = "SELECT * FROM product_subcategories ";
    
    $stmt = sqlsrv_query( $conn, $tsql);
    if( $stmt === false) {
        // die( print_r( sqlsrv_errors(), true) );
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
    {
        $result[] = $row;
    }
    return $result;
}

?>