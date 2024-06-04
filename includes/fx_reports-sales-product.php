<?php
// include_once('connect_sql.php');
include_once('fx_crud_db.php');

function get_sales_by_product_start($conn){
	$result = array();
	$sql ="SELECT 
cc.currency_value,cc.currency_value_convert
,(SELECT currency from currency_list WHERE id =cc.id_currency_list ) AS id_currency_list_v
,(SELECT currency from currency_list WHERE id =cc.id_currency_list_convert ) AS id_currency_list_convert_v
,cl.currency,cc.id_currency_list,cc.id_currency_list_convert
,CONCAT(ag.first_name,' ',ag.last_name) AS agent_name,ag.agent_type,ag.nick_name
,CASE WHEN cu.customer_type = 'Personal'
THEN CONCAT(cu.first_name,' ',cu.last_name)
      ELSE cu.company_name
      END as customer_name
,cu.customer_type
,FORMAT(info.start_date, 'dd-MM-yyyy') AS in_start_date,FORMAT(info.end_date, 'dd-MM-yyyy') AS in_end_date
,info.policy_no,info.start_date,info.end_date,info.premium_rate
,info.convertion_value 
,ip.insurance_company,ip.phone,ip.email
,co.first_name as first_name_co,ag.mobile as mobile_co,co.remark as remark_co,ag.email as email_co
,pr.* FROM product pr
JOIN insurance_info info ON info.product_id = pr.id
left join rela_customer_to_insurance rci on rci.id_insurance_info = info.id
left join customer cu on cu.id = rci.id_customer
left join insurance_partner ip ON ip.id = info.insurance_company_id
left join rela_customer_to_contact recon on recon.id_customer = cu.id
join contact co on co.id = recon.id_contact AND co.default_contact=1
LEFT JOIN agent ag ON ag.id = info.agent_id
LEFT JOIN currency_list cl ON cl.id = ip.id_currency_list

 LEFT JOIN currency_convertion cc ON  cc.id = 
 (SELECT TOP 1 c_c.id FROM currency_convertion c_c WHERE  c_c.id_currency_list = ip.id_currency_list 
 AND  info.start_date >= c_c.start_date and info.start_date <= c_c.stop_date and c_c.status='1')
ORDER BY pr.id,info.start_date DESC";

// INNER JOIN (
//     SELECT 
//         policy_primary, MAX(cdate) AS max_cdate
//     FROM 
//         insurance_info where policy_no != ''
//     GROUP BY 
//         policy_primary
// ) latest ON info.policy_primary = latest.policy_primary AND info.cdate = latest.max_cdate

 // (SELECT TOP 1 c_c.id FROM currency_convertion c_c WHERE  c_c.id = ip.id_currency_list 
 // OR cc.id_currency_list_convert    = cl.id 
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

function get_sales_by_product_search($conn,$post_data){


    $sql_join_date = "";
    if (isset($post_data['date_from']) && $post_data['date_from'] != '') {
        $sql_join_date = " and start_date >= '".date("Y-m-d", strtotime($post_data['date_from']))."' ";
    }
    if (isset($post_data['date_to']) && $post_data['date_to'] != '') {
        $sql_join_date = " and start_date <= '".date("Y-m-d", strtotime($post_data['date_to']))."' ";
    }


    $result = array();
    $sql ="SELECT 
cc.currency_value,cc.currency_value_convert
,(SELECT currency from currency_list WHERE id =cc.id_currency_list ) AS id_currency_list_v
,(SELECT currency from currency_list WHERE id =cc.id_currency_list_convert ) AS id_currency_list_convert_v
,cl.currency,cc.id_currency_list,cc.id_currency_list_convert
,CONCAT(ag.first_name,' ',ag.last_name) AS agent_name,ag.agent_type,ag.nick_name
,CASE WHEN cu.customer_type = 'Personal'
THEN CONCAT(cu.first_name,' ',cu.last_name)
      ELSE cu.company_name
      END as customer_name
,cu.customer_type
,FORMAT(info.start_date, 'dd-MM-yyyy') AS in_start_date,FORMAT(info.end_date, 'dd-MM-yyyy') AS in_end_date
,info.policy_no,info.start_date,info.end_date,info.premium_rate
,info.convertion_value 
,ip.insurance_company,ip.phone,ip.email
,co.first_name as first_name_co,ag.mobile as mobile_co,co.remark as remark_co,ag.email as email_co
,pr.* FROM product pr
JOIN insurance_info info ON info.product_id = pr.id
left join rela_customer_to_insurance rci on rci.id_insurance_info = info.id
left join customer cu on cu.id = rci.id_customer
left join insurance_partner ip ON ip.id = info.insurance_company_id
left join rela_customer_to_contact recon on recon.id_customer = cu.id
join contact co on co.id = recon.id_contact AND co.default_contact=1
LEFT JOIN agent ag ON ag.id = info.agent_id
LEFT JOIN currency_list cl ON cl.id = ip.id_currency_list

 LEFT JOIN currency_convertion cc ON  cc.id = 
 (SELECT TOP 1 c_c.id FROM currency_convertion c_c WHERE  c_c.id_currency_list = ip.id_currency_list 
 AND  info.start_date >= c_c.start_date and info.start_date <= c_c.stop_date and c_c.status='1')
 WHERE info.policy_no !='' ";

//  INNER JOIN (
//     SELECT 
//         policy_primary, MAX(cdate) AS max_cdate
//     FROM 
//         insurance_info where policy_no != '' ".$sql_join_date."
//     GROUP BY 
//         policy_primary
// ) latest ON info.policy_primary = latest.policy_primary AND info.cdate = latest.max_cdate


 // AND  info.paid_date >= c_c.start_date and info.paid_date <= c_c.stop_date)


    // echo '<script>alert("customer: '.$post_data['customer'].'")</script>'; 
    if (isset($post_data['date_from']) && $post_data['date_from'] != '') {
        $sql .= " and info.start_date >= '".date("Y-m-d", strtotime($post_data['date_from']))."' ";
    }
    if (isset($post_data['date_to']) && $post_data['date_to'] != '') {
        $sql .= " and info.start_date <= '".date("Y-m-d", strtotime($post_data['date_to']))."' ";
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
        if ($post_data['category'] != 'all' ) {
            $sql .= " and info.product_category = ".$post_data['category'];
        }
        if ($post_data['subcategory'] != 'all') {
            $sql .= " and info.sub_categories = ".$post_data['subcategory'];
        }
    $sql .= " ORDER BY pr.id,info.start_date DESC ";
    // print_r($sql);
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

function get_customers ($conn) {
    $result = array();
    // $tsql = "select DISTINCT(c.id), CONCAT(c.title_name, ' ', c.first_name, ' ', c.last_name) as customer_name, c.last_name, c.first_name "
    //     . "from insurance_info ii "
	// 	. "left join rela_customer_to_insurance rci on rci.id_insurance_info = ii.id "
	// 	. "left join customer c on c.id = rci.id_customer "
	// 	. "where c.id IS NOT NULL "
	// 	. "order by c.last_name, c.first_name ";
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

		// echo $tsql;
		$stmt = sqlsrv_query( $conn, $tsql);
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
		{
			$result[] = $row;
		}
		return $result;
}

function get_products($conn) {
    $result = array();
    $tsql = "SELECT * FROM product where id IN (select distinct (product_id) from insurance_info)";
    
    $stmt = sqlsrv_query( $conn, $tsql);
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
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


function get_policy_no ($conn) {
    $result = array();
    $tsql = "select max(ii.id), ii.policy_no 
        from insurance_info ii 
        where policy_no IS NOT NULL AND  policy_no != '' 
        GROUP BY ii.policy_no 
            order by policy_no ";
    //echo $tsql;
    $stmt = sqlsrv_query( $conn, $tsql);
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
    {
        $result[] = $row;
    }
    return $result;
}

function get_product_category ($conn) {
    $result = array();
    $tsql = "SELECT * FROM product_categories ";
    
    $stmt = sqlsrv_query( $conn, $tsql);
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
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
        die( print_r( sqlsrv_errors(), true) );
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
    {
        $result[] = $row;
    }
    return $result;
}

?>