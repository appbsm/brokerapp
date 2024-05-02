<?php
include_once('connect_sql.php');
include_once('fx_crud_db.php');


if ($_GET['action'] == 'del') {
    $data['id'] = $_GET['id'];
    $data['table'] = 'alert_date';
    delete_table ($conn, $data);
    header('Location: ../alert-date-settings.php');
}

function update_alert ($conn, $post_data) {
    $data['id'] = $post_data['id'];
    $data['table'] = 'alert_date';
    $data['columns'] = array(
        'subject',
        'due_date',
        'status'
    );
    //$last_agent_ctr = get_agent_ctr($conn);
    $data['values'] = array(
        $post_data['subject'],
        $post_data['due_date'],
        isset($post_data['status']) ? 1 : 0,
       );
       
    update_table ($conn, $data);
}

function get_alert_date($conn, $str_subject) {
    $result = array();
    $tsql = "SELECT * FROM alert_date "
        . "WHERE subject = '".$str_subject."'";
        
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

function get_alert_to_due ($conn, $num_of_days) {
    $result = array();
    //$tsql = "select DATEADD(day,-30,end_date) as alert_date, end_date,  * from insurance_info where status = 'New' or status = 'Renew'";
    $tsql = "select *, "
            . "DATEADD(day,+".$num_of_days.",end_date) as alert_date, "
            . "end_date as policy_end_date,  ip.insurance_company, ii.status as insurance_status, CONCAT(a.first_name, '  ' , a.last_name) as agent_name, "
            . "CONCAT(c.title_name,' ',c.first_name, '  ' , c.last_name) as customer_name,c.tel,c.email as email_cus,c.mobile, "
			. "ii.status as insurance_status, ii.id as insurance_id,pr.product_name AS product_name_in,ii.id as id_insurance "
            . "from insurance_info ii "
            . "left join rela_customer_to_insurance ci on ci.id_insurance_info = ii.id "
            . "left join customer c on c.id = ci.id_customer "
            . "left join insurance_partner ip on ip.id = ii.insurance_company_id "
            . "left join agent a on a.id = ii.agent_id "
            . "LEFT JOIN product pr ON pr.id = ii.product_id "
            . "where ii.status = 'New' or ii.status = 'Renew' "
                ;
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

function get_alert_overdue ($conn, $num_of_days) {
    $result = array();
    //$tsql = "select DATEADD(day,+30,end_date) as alert_date, end_date,  * from insurance_info where status = 'New' or status = 'Renew'";
    $tsql = "select *, "
        . "DATEADD(day,+".$num_of_days.",end_date) as alert_date, "
        . "end_date as policy_end_date,  ip.insurance_company, ii.status as insurance_status, ii.id as insurance_id, "
        . "CONCAT(a.first_name, '  ' , a.last_name) as agent_name,c.tel,c.email as email_cus,c.mobile, "
        . "CONCAT(c.first_name, '  ' , c.last_name) as customer_name,pr.product_name AS product_name_in,ii.id as id_insurance "
        . "from insurance_info ii "
        . "left join rela_customer_to_insurance ci on ci.id_insurance_info = ii.id "
		. "left join customer c on c.id = ci.id_customer "
		. "left join insurance_partner ip on ip.id = ii.insurance_company_id "
		. "left join agent a on a.id = ii.agent_id "
        . "LEFT JOIN product pr ON pr.id = ii.product_id "
		. "where ii.status = 'New' or ii.status = 'Renew' "
	;
	
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

function get_alert_setting($conn,$id) {
    $result = array();
    $tsql = "SELECT * FROM alert_date "
        . " WHERE id = ".$id;
        // print_r($tsql);
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

function count_due ($conn) {
    $result = near_to_due_list ($conn);
    return count($result);    
}

function count_overdue ($conn) {
	$result = overdue_list ($conn);
    return count($result);
}

// function near_to_due_list ($conn) {
   
//     $near_to_due = "Policy Near To Due"; // FROM alert_date table
//     $num_days = get_alert_date($conn, $near_to_due);
//     $rec = get_alert_to_due ($conn, $num_days[0]['due_date']);
//     $list = array();
//     //print_r($rec);
    
//     foreach ($rec as $r) {
//         $today = date('d-m-Y');
// 		$alert_date = convert_objdate_to_strdate($r['alert_date']);
// 		$end_date = convert_objdate_to_strdate($r['end_date']);
//         //if (strtotime($r['alert_date']) < strtotime($today)) { // For Test
// 		//echo $alert_date;
// 		//(strtotime($alert_date) <  strtotime($end_date) && strtotime($end_date) >  strtotime($today)) 
		
// 		//echo $r['insurance_id'].' - ',$r['policy_no'].' - '.$alert_date." - ".$r['insurance_status']."<br>";			
// 		//echo "<br>";
// 		//echo strtotime($alert_date) . " <= ". strtotime($today). ' && '. strtotime($end_date) . ' > '.strtotime($today);
//         if (strtotime($alert_date) <=  strtotime($today) && strtotime($end_date) >  strtotime($today)) { // For the Production
// 			//echo $r['insurance_id'].' - ',$r['policy_no'].' - '.$alert_date." - ".$r['insurance_status']."<br>";			
// 			//echo "<br>";
//             $list[] = $r;
//         }
//     }
   
//     return $list;
// }

function overdue_list ($conn) {    
    $result = array();
    $near_to_due = "Policy Overdue"; // FROM alert_date table
    $num_days = get_alert_date($conn, $near_to_due);
    //print_r($num_days);
    $result = get_alert_overdue ($conn, $num_days[0]['due_date']);
    $list = array();
    foreach ($result as $r) {
		//print_r($r);
        $today = date('d-m-Y');
		$alert_date = convert_objdate_to_strdate($r['alert_date']);
		$end_date = convert_objdate_to_strdate($r['end_date']);
		
        //if (strtotime($alert_date) < strtotime($today)) { // For Test
        if (strtotime($alert_date) > strtotime($today) && strtotime($end_date) < strtotime($today)) { // For the Production
            //echo $r['insurance_id'].' - ',$r['policy_no'].' - '.$alert_date." - ".$r['insurance_status']."<br>";			
			//echo "<br>";
			$list[] = $r;			
		}
    }
    return $list;    
}

function new_to_follow_up ($list, $conn) {
    $data = array();
    foreach ($list as $l) {
        $data['id'] = $l['insurance_id'];
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

function follow_up_to_wait ($list, $conn) {
    $data = array();
    foreach ($list as $l) {
        $data['id'] = $l['insurance_id'];
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

function convert_objdate_to_strdate ($obj_date) {
	$str_date = $obj_date;
    $string_date = $str_date->format('d-m-Y');
	return $string_date;
} 
?>
