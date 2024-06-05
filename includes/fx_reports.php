<?php
// include_once('connect_sql.php');
include_once('fx_crud_db.php');


//$agent_currency = get_conversion ($conn, 21, date('Y-m-d'));
//print_r($agent_currency);


function get_customer_insurance ($conn, $id_customer = '') {
    $result = array();
    $tsql = "select c.id as id_customer, ii.id as id_insurance, "
            . "CONCAT(c.title_name, ' ', c.first_name, ' ', c.last_name) as customer_name, c.company_name, c.customer_type "
             . "from insurance_info ii "
             . "left join rela_customer_to_insurance rci on rci.id_insurance_info = ii.id "
             . "right join customer c on c.id = rci.id_customer "
             . "where ii.id IS NOT NULL and c.first_name != '' ";
             if ($id_customer != '') {
                 $tsql .= "and c.id =".$id_customer;
             }
             $tsql .= "order by c.last_name, c.first_name ";
    //echo $tslq;
     // print_r($tslq);
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

function get_insurance_customer ($conn, $id_customer = '') {
	$result = array();
    $tsql = "SELECT * FROM customer where id IN (select DISTINCT(r.id_customer) from insurance_info i
			left join rela_customer_to_insurance r on r.id_insurance_info = i.id) ";
             if ($id_customer != '') {
                 $tsql .= "and id = ".$id_customer;
             }
             $tsql .= " order by last_name, first_name ";
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

function get_sales_by_customer ($conn, $data, $id_customer) {
  
   $result = array();
   $where = '';
   $tsql = "select "
            . "CASE WHEN c.customer_type = 'Personal' "
            . "THEN CONCAT(c.title_name, ' ', c.first_name, ' ', c.last_name) "
            . "ELSE company_name "
            . "END as customer_name, "
           // . "CONCAT(c.title_name, ' ', c.first_name, ' ', c.last_name) as customer_name "
           . "c.id as customer_id,"
           . "CONCAT(co.title_name, ' ', co.first_name, ' ', co.last_name) as insurance_contact, "
           . "co.position,co.remark, "
           . "c.email, "
           . "c.mobile, "
           . "ii.policy_no, "
           . "p.product_name, p.id as product_id, "
           . "ii.start_date, "
           . "ii.end_date, "
           . "ii.premium_rate, "
           . "ii.status, "
           . "ip.insurance_company, "
           . "ip.id as partner_id, ip.id_currency_list as id_currency "
           . "from insurance_info ii "
           . "left join rela_customer_to_insurance rci on rci.id_insurance_info = ii.id "
           . "left join customer c on c.id = rci.id_customer "
           . "left join rela_insurance_to_contact ric on ric.id_insurance = ii.id "
           . "left join contact co on co.id = ric.id_contact "
           . "left join product p on p.id = ii.product_id "
           . "left join agent a on a.id = ii.agent_id "
           . "left join rela_agent_to_insurance rai on (rai.id_agent = a.id and rai.id_insurance = ii.id) "
           . "left join rela_partner_to_product rpp on (rpp.id_product = p.id and rpp.id_product = ii.product_id) "
           . "right join insurance_partner ip on (ip.id = rpp.id_partner and ip.id = ii.insurance_company_id) "
           . "where ii.agent_id IS NOT NULL "
           . "and c.id = ".$id_customer;
          
           if (isset($data) && count($data) > 0) {
               if (isset($data['date_from']) && $data['date_from'] != '') {
                   //$where = ($where != '') ? 'and' : 'where';
                   $where .= " and start_date >= '".date("Y-m-d", strtotime($data['date_from']))."' ";
               }
               if (isset($data['date_to']) && $data['date_to'] != '') {
                   //$where = ($where != '') ? 'and' : 'where';
                   $where .= " and start_date <= '".date("Y-m-d", strtotime($data['date_to']))."' ";
               }
			   
			   if (isset($data['customer']) && $data['customer'] != '') {
                   //$where = ($where != '') ? 'and' : 'where';
                   $where .= " and c.id = ".$data['customer'];
               }
               if (isset($data['partner']) && $data['partner'] != '') {
                   //$where = ($where != '') ? 'and' : 'where';
                   $where .= " and ip.id = ".$data['partner'];
               }
               if (isset($data['policy_no']) && $data['policy_no'] != '') {
                   //$where = ($where != '') ? 'and' : 'where';
                   $where .= " and ii.policy_no = '".$data['policy_no']."' ";
               }
               if (isset($data['status']) && $data['status'] != '') {
                   //$where = ($where != '') ? 'and' : 'where';
                   $where .= " and ii.status = '".$data['status']."' ";
               }
               if (isset($data['category']) && $data['category'] != '' ) {
                   //$where = ($where != '') ? 'and' : 'where';
                   $where .= " and ii.product_category = ".$data['category'];
               }
			   if (isset($data['subcategory']) && $data['subcategory'] != '' ) {
                   //$where = ($where != '') ? 'and' : 'where';
                   $where .= " and ii.sub_categories = ".$data['subcategory'];
               }
               if (isset($data['product']) && $data['product'] != '') {
                   //$where = ($where != '') ? 'and' : 'where';
                   $where .= " and p.product_name = ".$data['product'];
               }
           }
           $tsql .= $where;
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
    
function get_sales_by_product ($conn, $data, $id_product) {
    
    $result = array();
    $where = '';
    $tsql = "select "
        . "CONCAT(c.title_name, ' ', c.first_name, ' ', c.last_name) as customer_name, c.id as customer_id, "
        . "co.first_name as insurance_contact, "
        . "co.position, "
        . "c.email, "
        . "c.mobile, "
        . "ii.policy_no, "
        . "p.product_name, p.id as product_id, "
        . "ii.start_date, "
        . "ii.end_date, "
        . "ii.premium_rate, "
        . "ii.status, "
        . "ip.insurance_company, "
        . "ii.agent_id, "
        . "ip.id as partner_id, ip.id_currency_list as id_currency "
        . "from insurance_info ii "
        . "left join rela_customer_to_insurance rci on rci.id_insurance_info = ii.id "
        . "left join customer c on c.id = rci.id_customer "
        . "left join rela_insurance_to_contact ric on ric.id_insurance = ii.id "
        . "left join contact co on co.id = ric.id_contact "
        . "left join product p on p.id = ii.product_id "
        .  "left join agent a on a.id = ii.agent_id "
        . "left join rela_agent_to_insurance rai on (rai.id_agent = a.id and rai.id_insurance = ii.id) "
        . "left join rela_partner_to_product rpp on (rpp.id_product = p.id and rpp.id_product = ii.product_id) "
        . "right join insurance_partner ip on (ip.id = rpp.id_partner and ip.id = ii.insurance_company_id) "
        . " where ii.agent_id IS NOT NULL "
        . "and p.id = ".$id_product;
    //echo $tsql;
        if (isset($data) && count($data) > 0) {
            if (isset($data['date_from']) && $data['date_from'] != '') {
                //$where = ($where != '') ? 'and' : 'where';
                $where .= " and start_date >= '".date("Y-m-d", strtotime($data['date_from']))."' ";
            }
            if (isset($data['date_to']) && $data['date_to'] != '') {
                //$where = ($where != '') ? 'and' : 'where';
                $where .= " and start_date <= '".date("Y-m-d", strtotime($data['date_to']))."' ";
            }
            if (isset($data['partner']) && $data['partner'] != '') {
                //$where = ($where != '') ? 'and' : 'where';
                $where .= " and ip.id = ".$data['partner'];
            }
            if (isset($data['policy_no']) && $data['policy_no'] != '') {
                //$where = ($where != '') ? 'and' : 'where';
                $where .= " and ii.policy_no = '".$data['policy_no']."' ";
            }
            if (isset($data['status']) && $data['status'] != '') {
                //$where = ($where != '') ? 'and' : 'where';
                $where .= " and ii.status = '".$data['status']."' ";
            }
            if (isset($data['category']) && $data['category'] != '' ) {
                //$where = ($where != '') ? 'and' : 'where';
                $where .= " and c.id = ".$data['customer'];
            }
            if (isset($data['product']) && $data['product'] != '') {
                //$where = ($where != '') ? 'and' : 'where';
                $where .= " and p.product_name = ".$data['product'];
            }
        }
            $tsql .= $where;
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

function get_sales_monthly_new ($conn, $data, $month,  $year) {
    // echo '<script>alert("year: '.$year.'")</script>'; 
    $result = array();
    $where = '';
    $tsql = "select "
        . "SUM(premium_rate) as total_sales "
        . "from insurance_info ii "
        . "left join rela_customer_to_insurance rci on rci.id_insurance_info = ii.id "
        . "left join customer c on c.id = rci.id_customer "
        . "left join rela_insurance_to_contact ric on ric.id_insurance = ii.id "
        . "left join contact co on co.id = ric.id_contact "
        . "left join product p on p.id = ii.product_id "
        .  "left join agent a on a.id = ii.agent_id "
        . "left join rela_agent_to_insurance rai on (rai.id_agent = a.id and rai.id_insurance = ii.id) "

        // . "  INNER JOIN (
        //     SELECT 
        //         policy_primary, MAX(cdate) AS max_cdate
        //     FROM 
        //         insurance_info
        //     GROUP BY 
        //         policy_primary
        //     ) latest ON ii.policy_primary = latest.policy_primary AND ii.cdate = latest.max_cdate "

       // . "left join rela_partner_to_product rpp on (rpp.id_product = p.id and rpp.id_product = ii.product_id) "
        //. "right join insurance_partner ip on (ip.id = rpp.id_partner and ip.id = ii.insurance_company_id) "
        . " where ii.id IS NOT NULL "
        . "and Month(start_date) = '".$month. "' " 
       // . "and Month(start_date) <= '".$month_to. "' " 
        . "and Year(start_date) = '".$year. "' " 
        . " and (ii.status = 'New') ";
    
    // and (ii.status = 'New' OR ii.status = 'Renew')

    // print_r($tsql);
    if (isset($data) && count($data) > 0) {
        if (isset($data['date_from']) && $data['date_from'] != '') {
            $where .= " and start_date >= '".$data['date_from']."' ";
        }
        if (isset($data['date_to']) && $data['date_to'] != '') {
            $where .= " and start_date <= '".$data['date_to']."' ";
        }

        if (isset($data['agent']) && $data['agent'] != '') {
            //$where = ($where != '') ? 'and' : 'where';
            $where .= " and ii.agent_id = ".$data['agent_id'];
        }
        if (isset($data['policy_no']) && $data['policy_no'] != '') {
            //$where = ($where != '') ? 'and' : 'where';
            $where .= " and ii.policy_no = '".$data['policy_no']."' ";
        }
        if (isset($data['customer']) && $data['customer'] != '' ) {
            //$where = ($where != '') ? 'and' : 'where';
            $where .= " and c.id = ".$data['customer'];
        }
        if (isset($data['product']) && $data['product'] != '') {
            //$where = ($where != '') ? 'and' : 'where';
            $where .= " and ii.product_id = ".$data['product'];
        }
    }
    $tsql .= $where;
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

function get_sales_monthly ($conn, $data, $month,  $year) {
    // echo '<script>alert("year: '.$year.'")</script>'; 
    $result = array();
    $where = '';
    $tsql = "select "
        . "SUM(premium_rate) as total_sales "
        . "from insurance_info ii "
        . "left join rela_customer_to_insurance rci on rci.id_insurance_info = ii.id "
        . "left join customer c on c.id = rci.id_customer "
        . "left join rela_insurance_to_contact ric on ric.id_insurance = ii.id "
        . "left join contact co on co.id = ric.id_contact "
        . "left join product p on p.id = ii.product_id "
        .  "left join agent a on a.id = ii.agent_id "
        . "left join rela_agent_to_insurance rai on (rai.id_agent = a.id and rai.id_insurance = ii.id) "

        // . "  INNER JOIN (
        //     SELECT 
        //         policy_primary, MAX(cdate) AS max_cdate
        //     FROM 
        //         insurance_info
        //     GROUP BY 
        //         policy_primary
        //     ) latest ON ii.policy_primary = latest.policy_primary AND ii.cdate = latest.max_cdate "

       // . "left join rela_partner_to_product rpp on (rpp.id_product = p.id and rpp.id_product = ii.product_id) "
        //. "right join insurance_partner ip on (ip.id = rpp.id_partner and ip.id = ii.insurance_company_id) "
        . " where ii.id IS NOT NULL "
        . "and Month(start_date) = '".$month. "' " 
       // . "and Month(start_date) <= '".$month_to. "' " 
        . "and Year(start_date) = '".$year. "' " 
        . " and (ii.status = 'Renew') ";
    
    // and (ii.status = 'New' OR ii.status = 'Renew')

    // print_r($tsql);
    if (isset($data) && count($data) > 0) {
        if (isset($data['date_from']) && $data['date_from'] != '') {
            $where .= " and start_date >= '".$data['date_from']."' ";
        }
        if (isset($data['date_to']) && $data['date_to'] != '') {
            $where .= " and start_date <= '".$data['date_to']."' ";
        }

        if (isset($data['agent']) && $data['agent'] != '') {
            //$where = ($where != '') ? 'and' : 'where';
            $where .= " and ii.agent_id = ".$data['agent_id'];
        }
        if (isset($data['policy_no']) && $data['policy_no'] != '') {
            //$where = ($where != '') ? 'and' : 'where';
            $where .= " and ii.policy_no = '".$data['policy_no']."' ";
        }
        if (isset($data['customer']) && $data['customer'] != '' ) {
            //$where = ($where != '') ? 'and' : 'where';
            $where .= " and c.id = ".$data['customer'];
        }
        if (isset($data['product']) && $data['product'] != '') {
            //$where = ($where != '') ? 'and' : 'where';
            $where .= " and ii.product_id = ".$data['product'];
        }
    }
    $tsql .= $where;
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

function get_not_renew_monthly ($conn, $data, $month, $year) {
    $result = array();
    $where = '';
    $tsql = "select "
        . "SUM(premium_rate) as total_sales "
            . "from insurance_info ii "
                . "left join rela_customer_to_insurance rci on rci.id_insurance_info = ii.id "
                    . "left join customer c on c.id = rci.id_customer "
                        . "left join rela_insurance_to_contact ric on ric.id_insurance = ii.id "
                            . "left join contact co on co.id = ric.id_contact "
                                . "left join product p on p.id = ii.product_id "
                                    .  "left join agent a on a.id = ii.agent_id "
                                    .  "left join rela_agent_to_insurance rai on (rai.id_agent = a.id and rai.id_insurance = ii.id) "

    // ."  INNER JOIN (
    //         SELECT 
    //             policy_primary, MAX(cdate) AS max_cdate
    //         FROM 
    //             insurance_info
    //         GROUP BY 
    //             policy_primary
    //         ) latest ON ii.policy_primary = latest.policy_primary AND ii.cdate = latest.max_cdate "

                                            // . "left join rela_partner_to_product rpp on (rpp.id_product = p.id and rpp.id_product = ii.product_id) "
    //. "right join insurance_partner ip on (ip.id = rpp.id_partner and ip.id = ii.insurance_company_id) "
    . " where ii.id IS NOT NULL "
        . "and Month(start_date) = '".$month. "' "
            . "and Year(start_date) = '".$year. "' "
                . "and ii.status = 'Not Renew' "
                    ;
                    if (isset($data) && count($data) > 0) {
                        if (isset($data['date_from']) && $data['date_from'] != '') {
                            //$where = ($where != '') ? 'and' : 'where';
                            $where .= " and start_date >= '".$data['date_from']."' ";
                        }
                        if (isset($data['date_to']) && $data['date_to'] != '') {
                            //$where = ($where != '') ? 'and' : 'where';
                            $where .= " and start_date <= '".$data['date_to']."' ";
                        }
                        if (isset($data['agent']) && $data['agent'] != '') {
                            //$where = ($where != '') ? 'and' : 'where';
                            $where .= " and ii.agent_id = ".$data['agent_id'];
                        }
                        if (isset($data['policy_no']) && $data['policy_no'] != '') {
                            //$where = ($where != '') ? 'and' : 'where';
                            $where .= " and ii.policy_no = '".$data['policy_no']."' ";
                        }
                        if (isset($data['customer']) && $data['customer'] != '' ) {
                            //$where = ($where != '') ? 'and' : 'where';
                            $where .= " and c.id = ".$data['customer'];
                        }
                        if (isset($data['partner']) && $data['partner'] != '') {
                            //$where = ($where != '') ? 'and' : 'where';
                            $where .= " and ip.id = ".$data['partner'];
                        }
                    }
                    $tsql .= $where;
                    //echo $tsql;
                    // print_r($tsql);
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

function get_subagent_monthly ($conn, $data, $month, $year) {
    $result = array();
    $where = '';
    $tsql = "select "
        . "SUM(premium_rate) as total_sales "
            . "from insurance_info ii "
                . "left join rela_customer_to_insurance rci on rci.id_insurance_info = ii.id "
                    . "left join customer c on c.id = rci.id_customer "
                        . "left join rela_insurance_to_contact ric on ric.id_insurance = ii.id "
                            . "left join contact co on co.id = ric.id_contact "
                                . "left join product p on p.id = ii.product_id "
                                    .  "left join agent a on a.id = ii.agent_id "
                                        . "left join rela_agent_to_insurance rai on (rai.id_agent = a.id and rai.id_insurance = ii.id) "

        // ."  INNER JOIN (
        //     SELECT 
        //         policy_primary, MAX(cdate) AS max_cdate
        //     FROM 
        //         insurance_info
        //     GROUP BY 
        //         policy_primary
        //     ) latest ON ii.policy_primary = latest.policy_primary AND ii.cdate = latest.max_cdate "

                                            // . "left join rela_partner_to_product rpp on (rpp.id_product = p.id and rpp.id_product = ii.product_id) "
    //. "right join insurance_partner ip on (ip.id = rpp.id_partner and ip.id = ii.insurance_company_id) "

    . " where ii.id IS NOT NULL "
        . "and Month(start_date) = '".$month. "' "
            . "and Year(start_date) = '".$year. "' "
                // . "and ii.status = 'Not Renew' "
                    . "and a.agent_type ='Sub-agent' "
                    ;
                    if (isset($data) && count($data) > 0) {
                        if (isset($data['date_from']) && $data['date_from'] != '') {
                            //$where = ($where != '') ? 'and' : 'where';
                            $where .= " and start_date >= '".$data['date_from']."' ";
                        }
                        if (isset($data['date_to']) && $data['date_to'] != '') {
                            //$where = ($where != '') ? 'and' : 'where';
                            $where .= " and start_date <= '".$data['date_to']."' ";
                        }
                        if (isset($data['agent']) && $data['agent'] != '') {
                            //$where = ($where != '') ? 'and' : 'where';
                            $where .= " and ii.agent_id = ".$data['agent_id'];
                        }
                        if (isset($data['policy_no']) && $data['policy_no'] != '') {
                            //$where = ($where != '') ? 'and' : 'where';
                            $where .= " and ii.policy_no = '".$data['policy_no']."' ";
                        }
                        if (isset($data['customer']) && $data['customer'] != '' ) {
                            //$where = ($where != '') ? 'and' : 'where';
                            $where .= " and c.id = ".$data['customer'];
                        }
                        if (isset($data['partner']) && $data['partner'] != '') {
                            //$where = ($where != '') ? 'and' : 'where';
                            $where .= " and ip.id = ".$data['partner'];
                        }
                    }
                    $tsql .= $where;
                    //echo $tsql;
                    // print_r($tsql);
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

function convert_currency ($from_currency, $to_currency) {
    $result = '';
    
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

function get_policy_no_group($conn) {
    $result = array();
    $tsql = "select max(ii.id),ii.policy_no "
        . "from insurance_info ii "
        . "where policy_no IS NOT NULL AND  policy_no != '' GROUP BY ii.policy_no "
            . "order by policy_no "
                        ;
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

function get_partner_by_id($conn, $id) {
    $result = array();
    $tsql = "SELECT * FROM insurance_partner "
        . "WHERE id = ".$id;
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

function get_conversion($conn,$currency, $today) {
     // AND  info.paid_date >= c_c.start_date and info.paid_date <= c_c.stop_date)
    $result = array();
    $tsql = "select cl.currency, cc.* from currency_list cl "
    . "left join currency_convertion cc on cc.id_currency_list = cl.id "
    . "where '".$today."' >= start_date and '".$today."' <= stop_date "
    . "and cc.id_currency_list = ".$currency;
    ;
    // echo $tsql;
    // echo '<script>alert("get_conversion: '.$tsql.'")</script>'; 
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

function get_commission_report ($conn, $data, $agent) {
    //echo "ID".$agent;

            $sql_join_date = "";
            if (isset($data['date_from']) && $data['date_from'] != '') {
                $where .= " and start_date >= '".date("Y-m-d", strtotime($data['date_from']))."' ";
            }
            if (isset($data['date_to']) && $data['date_to'] != '') {
                $where .= " and start_date <= '".date("Y-m-d", strtotime($data['date_to']))."' ";
            }
    
    $result = array();
    $where = '';
    $tsql = "select "
            . "ip.insurance_company, "
            . "CASE WHEN c.customer_type = 'Personal'
      THEN CONCAT(c.first_name,' ',c.last_name)
      ELSE c.company_name
      END as customer_name, "
            . "CONCAT(a.first_name, ' ', a.last_name) as agent_name, "
            . "p.product_name, "
            . "ii.policy_no, "
            . "ii.premium_rate, "
            . "ii.commission_rate, "
            . "ii.paid_date, "
            . "ii.status, "
            . "ii.start_date, "
            . "ii.end_date, "
            . "ii.convertion_value, "
            . "ip.insurance_company, "
            . "ip.id as partner_id, "
            . "ip.id_currency_list as id_currency "
        . "from insurance_info ii "
        . "left join rela_customer_to_insurance rci on rci.id_insurance_info = ii.id "
        . "left join customer c on c.id = rci.id_customer "
        . "left join rela_insurance_to_contact ric on ric.id_insurance = ii.id "
        . "left join contact co on co.id = ric.id_contact "
        . "left join product p on p.id = ii.product_id "
        .  "left join agent a on a.id = ii.agent_id "
        . "left join rela_agent_to_insurance rai on (rai.id_agent = a.id and rai.id_insurance = ii.id) "
        . "left join rela_partner_to_product rpp on (rpp.id_product = p.id and rpp.id_product = ii.product_id) "
        . "right join insurance_partner ip on (ip.id = rpp.id_partner and ip.id = ii.insurance_company_id) "

        . " where ii.agent_id IS NOT NULL "
        . " and ii.agent_id = ".$agent;

        // . " INNER JOIN (
        //     SELECT 
        //         policy_primary, MAX(cdate) AS max_cdate
        //     FROM 
        //         insurance_info where policy_no != '' ".$sql_join_date."
        //     GROUP BY 
        //         policy_primary
        //     ) latest ON ii.policy_primary = latest.policy_primary AND ii.cdate = latest.max_cdate "


        // echo $tsql;
        if (isset($data) && count($data) > 0) {
            if (isset($data['date_from']) && $data['date_from'] != '') {
                $where .= " and start_date >= '".date("Y-m-d", strtotime($data['date_from']))."' ";
            }
            if (isset($data['date_to']) && $data['date_to'] != '') {
                $where .= " and start_date <= '".date("Y-m-d", strtotime($data['date_to']))."' ";
            }
            /*
            if (isset($data['agent']) && $data['agent'] != '') {
                //$where = ($where != '') ? 'and' : 'where';
                $where .= " and ii.agent_id = ".$data['agent_id'];
            }*/
            if (isset($data['customer']) && $data['customer'] != '') {
                $where .= " and c.id = ".$data['customer'];
            }
            if (isset($data['policy_no']) && $data['policy_no'] != '') {
                $where .= " and ii.policy_no = '".$data['policy_no']."' ";
            }
            if (isset($data['product']) && $data['product'] != '') {
                $where .= " and ii.product_id = ".$data['product'];
            }

            // echo '<script>alert("lastInsertId: '.$data['partner'].'")</script>'; 

            if (isset($data['partner']) && $data['partner'] != '') {
                $where .= " and ip.id = ".$data['partner'];
            }
        }
        $tsql .= $where." order by ii.start_date desc ";



        // print_r($tsql);
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

function agents_paid ($conn) {
    $result = array();
    $tsql = "select DISTINCT(i.agent_id) as id_agent from insurance_info i
            left join agent a on a.id = i.agent_id
            where i.agent_id IS NOT NULL
            and i.agent_id IN (select id from agent)
            and paid_date IS NOT NULL
            and payment_status = 'Paid' ";
    //echo $tsql;
    // print_r($tsql);
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
    $tsql = "select * from insurance_partner order by insurance_company ASC ";
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

function get_agent_by_id($conn, $id) {
    $result = array();
    $tsql = "SELECT * FROM agent "
        . "WHERE id = ".$id;
        
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
