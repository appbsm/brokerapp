<?php
// include_once('connect_sql.php');
include_once('fx_crud_db.php');

function near_to_due_list($conn) {
    $list = array();
    // . "DATEADD(day,+".$num_of_days.",end_date) as alert_date, "
    $sql = "select cl.currency,*, 
            end_date as policy_end_date,  ip.insurance_company, ii.status as insurance_status
            , CONCAT(a.first_name, '  ' , a.last_name) as agent_name, 
            CONCAT(c.first_name, '  ' , c.last_name) as customer_name,c.tel,c.email as email_cus,c.mobile, 
            ii.status as insurance_status, ii.id as insurance_id,pr.product_name AS product_name_in,ii.id as id_insurance
            ,ii.paid_date as paid_date_policy
            from insurance_info ii 
            left join rela_customer_to_insurance ci on ci.id_insurance_info = ii.id 
            left join customer c on c.id = ci.id_customer 
            left join insurance_partner ip on ip.id = ii.insurance_company_id 
            left join agent a on a.id = ii.agent_id 
            LEFT JOIN product pr ON pr.id = ii.product_id
            LEFT JOIN currency_list cl ON cl.id = ip.id_currency_list 

            where ii.status = 'Follow up' 
            AND end_date > DATEADD(DAY,-(SELECT due_date FROM alert_date WHERE type = 'near_due'),GETDATE()) 
            AND end_date < DATEADD(DAY,+(SELECT due_date FROM alert_date WHERE type = 'near_due'),GETDATE()) 
            AND end_date >= GETDATE() ";

            // INNER JOIN (
            // SELECT 
            //     policy_primary, MAX(cdate) AS max_cdate
            // FROM 
            //     insurance_info
            //     where status = 'Follow up' 
            //         AND end_date > DATEADD(DAY,-(SELECT due_date FROM alert_date WHERE type = 'near_due'),GETDATE()) 
            //         AND end_date < DATEADD(DAY,+(SELECT due_date FROM alert_date WHERE type = 'near_due'),GETDATE()) 
            //         AND end_date >= GETDATE() 
            // GROUP BY 
            //     policy_primary
            // ) latest ON ii.policy_primary = latest.policy_primary AND ii.cdate = latest.max_cdate   

    // print_r($sql);
    $stmt = sqlsrv_query( $conn, $sql);  
    if( $stmt === false) {
        
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))    
    {    
        $result[] = $row;
    } 
    return $result;
}

function near_to_overdue_list($conn) {
    $list = array();
    $sql = "select cl.currency,*, 
            end_date as policy_end_date,  ip.insurance_company, ii.status as insurance_status, CONCAT(a.first_name, '  ' , a.last_name) as agent_name, 
            CONCAT(c.title_name,' ',c.first_name, '  ' , c.last_name) as customer_name,c.tel,c.email as email_cus,c.mobile, 
            ii.status as insurance_status, ii.id as insurance_id,pr.product_name AS product_name_in,ii.id as id_insurance 
            ,ii.paid_date as paid_date_policy
            from insurance_info ii 
            left join rela_customer_to_insurance ci on ci.id_insurance_info = ii.id 
            left join customer c on c.id = ci.id_customer 
            left join insurance_partner ip on ip.id = ii.insurance_company_id 
            left join agent a on a.id = ii.agent_id 
            LEFT JOIN product pr ON pr.id = ii.product_id 
            LEFT JOIN currency_list cl ON cl.id = ip.id_currency_list
            where ii.status = 'Wait'
            AND end_date < GETDATE() ";

            //  INNER JOIN (
            // SELECT 
            //     policy_primary, MAX(cdate) AS max_cdate
            // FROM 
            //     insurance_info
            //     where status = 'Wait' 
            //         AND end_date < GETDATE() 
            // GROUP BY 
            //     policy_primary
            // ) latest ON ii.policy_primary = latest.policy_primary AND ii.cdate = latest.max_cdate   

    // print_r($sql);
    $stmt = sqlsrv_query( $conn, $sql);  
    if( $stmt === false) {
        
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))    
    {    
        $result[] = $row;
    } 
    return $result;
}

function near_to_overdue_list_topbar($conn) {
    $list = array();
    $sql = "select *, 
            end_date as policy_end_date,  ip.insurance_company, ii.status as insurance_status, CONCAT(a.first_name, '  ' , a.last_name) as agent_name, 
            CONCAT(c.title_name,' ',c.first_name, '  ' , c.last_name) as customer_name,c.tel,c.email as email_cus,c.mobile, 
            ii.status as insurance_status, ii.id as insurance_id,pr.product_name AS product_name_in,ii.id as id_insurance 
            from insurance_info ii 
            left join rela_customer_to_insurance ci on ci.id_insurance_info = ii.id 
            left join customer c on c.id = ci.id_customer 
            left join insurance_partner ip on ip.id = ii.insurance_company_id 
            left join agent a on a.id = ii.agent_id 
            LEFT JOIN product pr ON pr.id = ii.product_id 
            where ii.status = 'Wait' 
            AND end_date < GETDATE() 
            AND end_date > DATEADD(DAY,-((SELECT due_date FROM alert_date WHERE type = 'overdue')+(SELECT due_date FROM alert_date WHERE type = 'near_due')),GETDATE()) ";

    // print_r($sql);
    $stmt = sqlsrv_query( $conn, $sql);  
    if( $stmt === false) {
        
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))    
    {    
        $result[] = $row;
    } 
    return $result;
}


// status New,Renew -> Follow up
// status Follow up -> Wait
// status Not renew -> null

function check_due_policy ($conn) {
    $result = array();
    // $sql = "SELECT * from insurance_info ii
    //     WHERE end_date > DATEADD(DAY,-(SELECT due_date FROM alert_date WHERE type = 'near_due'),GETDATE()) 
    //     AND end_date <= GETDATE()
    //     AND (status = 'New' OR status = 'Renew')";
    $sql = "SELECT * from insurance_info ii
        WHERE end_date > DATEADD(DAY,-(SELECT due_date FROM alert_date WHERE type = 'near_due'),GETDATE()) 
        AND end_date < DATEADD(DAY,+(SELECT due_date FROM alert_date WHERE type = 'near_due'),GETDATE()) 
        AND end_date >= GETDATE()
        AND (status = 'New' OR status = 'Renew')";
    $stmt = sqlsrv_query( $conn, $sql);
    if( $stmt === false) {
            // die( print_r( sqlsrv_errors(), true) );
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
            $result[] = $row;
    }
    return $result;   
}

function check_overdue_policy($conn) {
    $result = array();
    // end_date < DATEADD(DAY,-(SELECT due_date FROM alert_date WHERE type = 'near_due'),GETDATE())   
    $sql = "SELECT * from insurance_info ii
        WHERE  end_date <= GETDATE()
        AND (status = 'Follow up' OR status = 'New' OR status = 'Renew')";
    $stmt = sqlsrv_query( $conn, $sql);
    if( $stmt === false) {
            // die( print_r( sqlsrv_errors(), true) );
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
            $result[] = $row;
    }
    return $result;   
}

function update_follow($list, $conn) {
    $data = array();
    foreach ($list as $value) {
        $data['id'] = $value['id'];
        $data['table'] = 'insurance_info';
        $data['columns'] = array(
            'status'
        );
        
        $data['values'] = array(
            'Follow up'
         );
        update_table ($conn, $data);
    }
}

function update_wait($list, $conn) {
    $data = array();
    foreach ($list as $value) {
        $data['id'] = $value['id'];
        $data['table'] = 'insurance_info';
        $data['columns'] = array(
            'status'
        );
        
        $data['values'] = array(
            'Wait'
        );
        update_table ($conn, $data);
    }
}

?>
