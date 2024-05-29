<?php

function get_payment_start($dbh) {
	$results = array();
	$sql = " SELECT cl.currency,ip.insurance_company AS insurance_company_in,pr.product_name AS product_name_in,cu.mobile AS mobile_customer,cu.tel AS tel_customer,cu.email AS email_customer,insu.status AS status_insurance 
		 ,CASE WHEN cu.customer_type = 'Personal'
		  THEN CONCAT(cu.first_name,' ',cu.last_name)
		  ELSE cu.company_name
		  END as full_name
		 ,ag.title_name AS title_name_agent,ag.first_name AS first_name_agent,ag.last_name AS last_name_agent 
		 ,insu.id AS id_insurance,FORMAT(start_date, 'dd-MM-yyyy') AS start_date_day 
		 ,FORMAT(end_date, 'dd-MM-yyyy') AS end_date_day
         ,FORMAT(paid_date, 'dd-MM-yyyy') AS paid_date_day
         ,insu.* 
		  from insurance_info insu 
		 left JOIN  rela_customer_to_insurance re_ci ON re_ci.id_insurance_info = insu.id 
		 left JOIN customer cu ON cu.id = re_ci.id_customer 
		 left JOIN agent ag ON ag.id = insu.agent_id 
		 LEFT JOIN product pr ON pr.id = insu.product_id
		 LEFT JOIN insurance_partner ip ON ip.id = insu.insurance_company_id
         LEFT JOIN currency_list cl ON cl.id = ip.id_currency_list
		 ORDER BY insu.cdate desc ";

        // ORDER BY LTRIM(insu.policy_no) asc ";
		   // WHERE insu.default_insurance = 1
	echo '<script>alert("sql: '.$sql.'")</script>'; 
	$query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	return $results;
}

function get_payment_search($dbh,$post_data) {
	$results = array();
	$sql = " SELECT cl.currency,ip.insurance_company AS insurance_company_in,pr.product_name AS product_name_in,cu.mobile AS mobile_customer,cu.tel AS tel_customer,cu.email AS email_customer,insu.status AS status_insurance 
		 ,CASE WHEN cu.customer_type = 'Personal'
		  THEN CONCAT(cu.first_name,' ',cu.last_name)
		  ELSE cu.company_name
		  END as full_name
		 ,ag.title_name AS title_name_agent,ag.first_name AS first_name_agent,ag.last_name AS last_name_agent 
		 ,insu.id AS id_insurance,FORMAT(start_date, 'dd-MM-yyyy') AS start_date_day 
		 ,FORMAT(end_date, 'dd-MM-yyyy') AS end_date_day
         ,FORMAT(paid_date, 'dd-MM-yyyy') AS paid_date_day
         ,insu.* 
		  from insurance_info insu 
		 left JOIN  rela_customer_to_insurance re_ci ON re_ci.id_insurance_info = insu.id 
		 left JOIN customer cu ON cu.id = re_ci.id_customer 
		 left JOIN agent ag ON ag.id = insu.agent_id 
		 LEFT JOIN product pr ON pr.id = insu.product_id
		 LEFT JOIN insurance_partner ip ON ip.id = insu.insurance_company_id
         LEFT JOIN currency_list cl ON cl.id = ip.id_currency_list 
         WHERE insu.policy_no !='' ";

    if (isset($post_data['start_date']) && $post_data['start_date'] != '') {
        $sql .= " and insu.start_date >= '".date("Y-m-d", strtotime($post_data['start_date']))."' ";
    }
    if (isset($post_data['end_date']) && $post_data['end_date'] != '') {
        $sql .= " and insu.start_date <= '".date("Y-m-d", strtotime($post_data['end_date']))."' ";
    }

        if ($post_data['customer'] != 'all' ) {
            $sql .= " and cu.id = ".$post_data['customer'];
        }
        if ($post_data['partner']!="all") {
            $sql .= " and ip.id = ".$post_data['partner'];
        }
        if ($post_data['policy_no'] != 'all') {
            $sql .= " and insu.policy_no = '".$post_data['policy_no']."' ";
        }
        if ($post_data['status'] != 'all') {
            $sql .= " and insu.status = '".$post_data['status']."' ";
        }
        if ($post_data['product_cat'] != 'all' ) {
            $sql .= " and insu.product_category = ".$post_data['product_cat'];
        }
        if ($post_data['sub_cat'] != 'all') {
            $sql .= " and insu.sub_categories = ".$post_data['sub_cat'];
        }

    $sql = $sql." ORDER BY insu.cdate desc ";

        // ORDER BY LTRIM(insu.policy_no) asc ";
		   // WHERE insu.default_insurance = 1
	// echo '<script>alert("sql: '.$sql.'")</script>'; 
	// print_r($sql);
	$query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	return $results;
}

function get_customers_list ($dbh) {
	$results = array();
	$sql = "select DISTINCT(c.id),c.customer_type "
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
    $query = $dbh->prepare($sql);
	$query->execute();

	$results = $query->fetchAll(PDO::FETCH_OBJ);
    return $results;
}

function get_products($dbh){
	$results = array();
    $sql = "SELECT * FROM product ";
    $query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
    return $results;
}

function get_policy_no($dbh){
	$results = array();

    $sql = "SELECT max(ii.id) as max_id, ii.policy_no 
        from insurance_info ii 
        where policy_no IS NOT NULL AND  policy_no != ''
        GROUP BY policy_no
        order by policy_no ";

    $query = $dbh->prepare($sql);
	$query->execute();

	$results = $query->fetchAll(PDO::FETCH_OBJ);
    return $results;
}

function get_partners($dbh){
	$results = array();
    $sql = "select * from insurance_partner where status = 1 order by insurance_company ASC ";
    $query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
    return $results;
}

function get_product_categories($dbh){
	$results = array();
    $sql = "SELECT * FROM product_categories ";
    $query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
    return $results;
}

function get_product_subcategory($dbh){
	$results = array();
    $sql = "SELECT * FROM product_subcategories ";
    $query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
    return $results;
}

?>
