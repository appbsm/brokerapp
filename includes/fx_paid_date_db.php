<?php
include_once('connect_sql.php');
include_once('fx_crud_db.php');

function get_paid_policy($conn,$status) {
	$result = array();
	// $tsql = "SELECT TOP 1 * from rela_customer_to_insurance WHERE id_customer = '".$id."'";

	$sql = " SELECT ip.insurance_company AS insurance_company_in,pr.product_name AS product_name_in,cu.mobile AS mobile_customer,cu.tel AS tel_customer,cu.email AS email_customer,insu.status AS status_insurance 
     ,CASE WHEN cu.customer_type = 'Personal'
      THEN CONCAT(cu.title_name,' ',cu.first_name,' ',cu.last_name)
      ELSE cu.company_name
      END as full_name
     ,ag.title_name AS title_name_agent,ag.first_name AS first_name_agent,ag.last_name AS last_name_agent 
     ,insu.id AS id_insurance,FORMAT(start_date, 'dd-MM-yyyy') AS start_date_day 
     ,FORMAT(paid_date, 'dd-MM-yyyy') AS paid_date_day 
     ,FORMAT(end_date, 'dd-MM-yyyy') AS end_date_day
     ,FORMAT(commission_paid_date, 'dd-MM-yyyy') AS commission_paid_date_day
     ,insu.* 
      from insurance_info insu 
     left JOIN rela_customer_to_insurance re_ci ON re_ci.id_insurance_info = insu.id 
     left JOIN customer cu ON cu.id = re_ci.id_customer 
     left JOIN agent ag ON ag.id = insu.agent_id 
     LEFT JOIN product pr ON pr.id = insu.product_id
     LEFT JOIN insurance_partner ip ON ip.id = insu.insurance_company_id";
    if($status!="Show All" && $status!=""){
    	$sql = $sql." WHERE insu.commission_status = '".$status."' ";
    }else if($status==""){
    	$sql = $sql." WHERE insu.commission_status = 'Not Paid' ";
    }
    $sql = $sql." ORDER BY LTRIM(insu.policy_no) asc ";
    // print_r($sql);
	// echo '<script>alert("get_paid_policy sql: '.$sql.'")</script>';
	$stmt = sqlsrv_query( $conn, $sql);  
	if( $stmt === false) {
		// die( print_r( sqlsrv_errors(),true));
	}
	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){    
		$result[] = $row;
	}
	return $result;
}

function update_insurance_info($conn, $post_data) {
	$data['id'] = $post_data['id_insurance_info'];
	$data['table'] = 'insurance_info';
	$data['columns'] = array(
	'commission_status',
	'commission_paid_date',
	'paid_by'
	);

	$data['values'] = array(
		'Paid',
		$post_data['commission_paid_date'],
		$_SESSION['id']
	);
	update_table ($conn, $data);

}

function check_policy($conn,$id) {
	$result = array();
	// $sql = "SELECT TOP 1 * from rela_customer_to_insurance WHERE id_customer = '".$id."'";
	$sql = "SELECT * FROM insurance_info WHERE id ='".$id."'";
	// echo '<script>alert("sql: '.$sql.'")</script>'; 
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

function get_insurance_info($conn,$id) {
	$result = array();
	$sql = " SELECT pe.period AS period_name,cl.currency,pc.categorie,ps.subcategorie
	 ,ip.insurance_company AS insurance_company_in,pr.product_name AS product_name_in,cu.mobile AS mobile_customer
	 ,cu.tel AS tel_customer,cu.email AS email_customer,insu.status AS status_insurance 
     ,CASE WHEN cu.customer_type = 'Personal'
      THEN CONCAT(cu.title_name,' ',cu.first_name,' ',cu.last_name)
      ELSE cu.company_name
      END as full_name
     ,ag.title_name AS title_name_agent,ag.first_name AS first_name_agent,ag.last_name AS last_name_agent 
     ,insu.id AS id_insurance,FORMAT(start_date, 'dd-MM-yyyy') AS start_date_day 
     ,FORMAT(paid_date, 'dd-MM-yyyy') AS paid_date_day 
     ,FORMAT(end_date, 'dd-MM-yyyy') AS end_date_day
     ,FORMAT(commission_paid_date, 'dd-MM-yyyy') AS commission_paid_date_day
     ,insu.* 
      from insurance_info insu 
     left JOIN rela_customer_to_insurance re_ci ON re_ci.id_insurance_info = insu.id 
     left JOIN customer cu ON cu.id = re_ci.id_customer 
     left JOIN agent ag ON ag.id = insu.agent_id 
     LEFT JOIN product pr ON pr.id = insu.product_id
     LEFT JOIN insurance_partner ip ON ip.id = insu.insurance_company_id
     LEFT JOIN product_categories pc ON pc.id = insu.product_category
     LEFT JOIN product_subcategories ps ON ps.id = insu.sub_categories 
     LEFT JOIN currency_list cl ON cl.id = ip.id_currency_list
     LEFT JOIN period pe ON pe.id = insu.period ";
     $sql = $sql." WHERE insu.id = '".$id."' ";

    if($status!="" && $status!="Show All"){
    	$sql = $sql." WHERE insu.commission_status = '".$status."' ";
    }
    $sql = $sql." ORDER BY LTRIM(insu.policy_no) asc ";
    // print_r($sql);
	// echo '<script>alert("get_paid_policy sql: '.$sql.'")</script>';
	$stmt = sqlsrv_query( $conn, $sql);  
	if( $stmt === false) {
		// die( print_r( sqlsrv_errors(),true));
	}
	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){    
		$result[] = $row;
	} 
	return $result;
}

function get_categories($conn) {
	$result = array();
	$tsql = "SELECT * from product_categories WHERE status = 1 order by id asc";
	
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

function get_sub($conn) {
	$result = array();
	$tsql = " SELECT * from product_subcategories WHERE status = 1 ";
	
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

function get_company($conn) {
	$result = array();
	$tsql = " SELECT ip.id AS id_partner,*,cl.currency from insurance_partner ip
	JOIN currency_list cl ON ip.id_currency_list = cl.id
	WHERE ip.status = 1 ";
	
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

function get_customers($conn) {
	$result = array();
	$tsql = "SELECT CASE WHEN customer_type = 'Personal'
      THEN CONCAT(title_name,' ',first_name,' ',last_name)
      ELSE company_name
      END as full_name
	,* FROM customer order by LTRIM(first_name) asc";
	
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
