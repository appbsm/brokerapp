<?php
// include_once('connect_sql.php');
include_once('fx_crud_db.php');

function get_reports_history_start($conn) {
    // ,(SELECT TOP 1  re.modify_by FROM report_history_policy re WHERE re.policy_no = hist.policy_no ORDER BY id desc) AS modify_by_user
	$result = array();
	$sql ="SELECT 
    CASE WHEN cu.customer_type = 'Personal'
          THEN CONCAT(cu.first_name,' ',cu.last_name)
          ELSE cu.company_name
          END as full_name
 ,CONCAT(u_up.name_title,' ',u_up.first_name,' ',u_up.last_name) AS modify_by_user
,hist.convertion_value
 ,(SELECT TOP 1 CONCAT(ui.name_title,' ',ui.first_name,' ',ui.last_name) FROM report_history_policy re
  LEFT JOIN user_info ui ON re.create_by = ui.id WHERE re.policy_no = hist.policy_no AND re.type ='insert' ) AS create_by_user
 ,(SELECT FORMAT(MIN(re.cdate),'dd-MM-yyyy') FROM report_history_policy re WHERE re.policy_no = hist.policy_no ) AS mindate
 ,(SELECT FORMAT(MAX(re.cdate),'dd-MM-yyyy') FROM report_history_policy re WHERE re.policy_no = hist.policy_no ) AS maxdate
 ,FORMAT(hist.cdate, 'dd-MM-yyyy') AS cdate_his
 ,cc.currency_value,cc.currency_value_convert
 ,(SELECT currency from currency_list WHERE id =cc.id_currency_list ) AS id_currency_list_v
 ,(SELECT currency from currency_list WHERE id =cc.id_currency_list_convert ) AS id_currency_list_convert_v
 ,cl.currency,cc.id_currency_list,cc.id_currency_list_convert
 ,pc.categorie,ps.subcategorie,ip.insurance_company
 ,FORMAT(hist.start_date, 'dd-MM-yyyy') AS in_start_date,FORMAT(hist.end_date, 'dd-MM-yyyy') AS in_end_date
 ,FORMAT(hist.paid_date, 'dd-MM-yyyy') AS in_paid_date
 ,cu.first_name,cu.last_name
 ,con.first_name AS first_name_con,con.last_name AS last_name_con,con.position,con.remark
 ,con.email AS email_con,con.mobile AS mobile_con
 ,info.remark
 ,hist.* FROM report_history_policy hist
 JOIN (SELECT MAX(rehi.id) AS id_last,rehi.id_insurance_info,rehi.status
 ,MAX(rehi.start_date) AS start_date
 FROM report_history_policy rehi 
 GROUP BY rehi.policy_no,rehi.start_date,rehi.end_date
 ,rehi.id_insurance_info,rehi.status) rea ON hist.id = rea.id_last
 LEFT JOIN customer cu ON cu.id = hist.customer_id

 LEFT JOIN contact con ON con.id = 

 ( SELECT con_t.id  FROM rela_customer_to_contact rec 
 JOIN contact con_t ON con_t.id = rec.id_contact AND con_t.default_contact = 1
 WHERE rec.id_customer = cu.id)

 LEFT JOIN insurance_partner ip ON ip.id = hist.insurance_company_id
 LEFT JOIN insurance_info info ON info.id = hist.id_insurance_info
 LEFT JOIN product_categories pc ON pc.id = info.product_category
 LEFT JOIN product_subcategories ps ON ps.id = info.sub_categories
 LEFT JOIN currency_list cl ON cl.id = ip.id_currency_list
 LEFT JOIN user_info u_up ON u_up.id = hist.modify_by
 LEFT JOIN currency_convertion cc ON  cc.id = 
  (SELECT TOP 1 c_c.id FROM currency_convertion c_c WHERE  c_c.id_currency_list = ip.id_currency_list
 AND  info.start_date >= c_c.start_date and info.start_date <= c_c.stop_date and c_c.status='1')
 ";
 // hist.contact_id_default
  // ,FORMAT(hist.paid_date, 'dd-MM-yyyy') AS in_paid_date  

	$stmt = sqlsrv_query($conn,$sql);  
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    while( $row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC))    
    {    
        $result[] = $row;
    } 
    return $result;
}

function get_reports_history_search($conn,$post_data) {
	$result = array();

	$sql ="SELECT 
     CASE WHEN cu.customer_type = 'Personal'
          THEN CONCAT(cu.first_name,' ',cu.last_name)
          ELSE cu.company_name
          END as full_name
 ,CONCAT(u_up.name_title,' ',u_up.first_name,' ',u_up.last_name) AS modify_by_user
 ,hist.convertion_value
 ,(SELECT TOP 1 CONCAT(ui.name_title,' ',ui.first_name,' ',ui.last_name) FROM report_history_policy re
  LEFT JOIN user_info ui ON re.create_by = ui.id WHERE re.policy_no = hist.policy_no AND re.type ='insert' ) AS create_by_user
 ,(SELECT FORMAT(MIN(re.cdate),'dd-MM-yyyy') FROM report_history_policy re WHERE re.policy_no = hist.policy_no ) AS mindate
 ,(SELECT FORMAT(MAX(re.cdate),'dd-MM-yyyy') FROM report_history_policy re WHERE re.policy_no = hist.policy_no ) AS maxdate
 ,FORMAT(hist.cdate, 'dd-MM-yyyy') AS cdate_his
 ,cc.currency_value,cc.currency_value_convert
 ,(SELECT currency from currency_list WHERE id =cc.id_currency_list ) AS id_currency_list_v
 ,(SELECT currency from currency_list WHERE id =cc.id_currency_list_convert ) AS id_currency_list_convert_v
 ,cl.currency,cc.id_currency_list,cc.id_currency_list_convert
 ,pc.categorie,ps.subcategorie,ip.insurance_company
 ,FORMAT(hist.start_date, 'dd-MM-yyyy') AS in_start_date,FORMAT(hist.end_date, 'dd-MM-yyyy') AS in_end_date
 ,FORMAT(hist.paid_date, 'dd-MM-yyyy') AS in_paid_date
 ,cu.first_name,cu.last_name
 ,con.first_name AS first_name_con,con.last_name AS last_name_con,con.position,con.remark
 ,con.email AS email_con,con.mobile AS mobile_con
 ,hist.* FROM report_history_policy hist
 JOIN (SELECT MAX(rehi.id) AS id_last,rehi.id_insurance_info,rehi.status
 ,MAX(rehi.start_date) AS start_date
 FROM report_history_policy rehi 
 GROUP BY rehi.policy_no,rehi.start_date,rehi.end_date
 ,rehi.id_insurance_info,rehi.status) rea ON hist.id = rea.id_last
 LEFT JOIN customer cu ON cu.id = hist.customer_id
 LEFT JOIN contact con ON con.id = 

  ( SELECT con_t.id  FROM rela_customer_to_contact rec 
 JOIN contact con_t ON con_t.id = rec.id_contact AND con_t.default_contact = 1
 WHERE rec.id_customer = cu.id)
  
 LEFT JOIN insurance_partner ip ON ip.id = hist.insurance_company_id
 LEFT JOIN insurance_info info ON info.id = hist.id_insurance_info
 LEFT JOIN product_categories pc ON pc.id = info.product_category
 LEFT JOIN product_subcategories ps ON ps.id = info.sub_categories
 LEFT JOIN currency_list cl ON cl.id = ip.id_currency_list
 LEFT JOIN user_info u_up ON u_up.id = hist.modify_by
 LEFT JOIN currency_convertion cc ON  cc.id = 
  (SELECT TOP 1 c_c.id FROM currency_convertion c_c WHERE  c_c.id_currency_list = ip.id_currency_list
 AND  info.start_date >= c_c.start_date and info.start_date <= c_c.stop_date and c_c.status='1')
  where hist.id IS NOT NULL ";

 	// $sql .= " where hist.start_date >= '".$post_data['start_date']."' ";
 	// $sql .= " and hist.start_date <= '".$post_data['end_date']."' ";

    if (isset($post_data['start_date']) && $post_data['start_date'] != '') {
                $sql .= " and hist.start_date >= '".date("Y-m-d", strtotime($post_data['start_date']))."' ";
    }
    if (isset($post_data['end_date']) && $post_data['end_date'] != '') {
                $sql .= " and hist.start_date <= '".date("Y-m-d", strtotime($post_data['end_date']))."' ";
    }

 	if ($post_data['customer'] != 'all' ) {
            $sql .= " and cu.id = ".$post_data['customer'];
        }
        if ($post_data['partner']!="all") {
            $sql .= " and ip.id = ".$post_data['partner'];
        }
        if ($post_data['policy_no'] != 'all') {
            // $sql .= " and hist.id_insurance_info = '".$post_data['policy_no']."' ";
            $sql .= " and hist.policy_no = '".$post_data['policy_no']."' ";
        }
        if ($post_data['status'] != 'all') {
            $sql .= " and hist.status = '".$post_data['status']."' ";
        }
        if ($post_data['product_cat'] != 'all' ) {
            $sql .= " and info.product_category = ".$post_data['product_cat'];
        }
        if ($post_data['sub_cat'] != 'all') {
            $sql .= " and info.sub_categories = ".$post_data['sub_cat'];
        }
	$stmt = sqlsrv_query($conn,$sql);  
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    while( $row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC))    
    {    
        $result[] = $row;
    } 
    return $result;
}

        // CASE WHEN c.customer_type = 'Personal' 
        // THEN CONCAT(c.title_name, ' ', c.first_name, ' ', c.last_name) 
        //    ELSE company_name "
        //    END as customer_name, 
// ,CASE WHEN CONCAT(c.first_name, ' ', c.last_name) as customer_name
function get_customers_list ($conn) {
    $result = array();
    $tsql = "select c.id
    ,CASE WHEN c.customer_type = 'Personal' 
        THEN CONCAT(c.first_name, ' ', c.last_name) 
        ELSE c.company_name
        END as customer_name
 from insurance_info ii
 left join rela_customer_to_insurance rci on rci.id_insurance_info = ii.id
 left join customer c on c.id = rci.id_customer
 where c.id IS NOT NULL 
 GROUP BY c.id,c.customer_type,c.first_name,c.last_name,c.company_name
 order by c.company_name ";
                        //echo $tsql;
                        echo '<script>alert("sql: '.$tsql.'")</script>'; 
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
    // $tsql = "select ii.id, ii.policy_no "
    //     . " from insurance_info ii "
    //     . " where policy_no IS NOT NULL AND  policy_no != ''"
    //     . "order by policy_no ";
    $tsql = "SELECT policy_no from report_history_policy 
where policy_no IS NOT NULL AND  policy_no != ''
GROUP BY policy_no
ORDER BY policy_no asc";
    // echo $tsql;
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