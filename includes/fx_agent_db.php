<?php
include_once('connect_sql.php');
include_once('fx_crud_db.php');

if ($_GET['action'] == 'del') {

	$insurance_list = check_insurance_agent($conn,$_GET['id']);
	if(count($insurance_list)==0){
		$data['id'] = $_GET['id'];
		$data['table'] = 'agent';	
		delete_table ($conn, $data);
		echo '<script>alert("Deleted Success.")</script>';
		echo "<script>window.location.href ='../agent-management.php'</script>";
		// header('Location: ../agent-management.php');
	}else{
		echo '<script>alert("This data cannot be deleted due to its usage history in the system, but it can only be marked as inactive.")</script>';
        echo "<script>window.location.href ='../agent-management.php'</script>";
	}
}

function check_insurance_agent($conn,$id) {
	$result = array();
	$tsql = "SELECT TOP 1 * from insurance_info WHERE agent_id = '".$id."'";
	// echo '<script>alert("check_policy tsql: '.$tsql.'")</script>';
	$stmt = sqlsrv_query( $conn, $tsql);  
	if( $stmt === false) {
		die( print_r( sqlsrv_errors(), true) );
	}
	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){    
		$result[] = $row;
	} 
	return $result;
}

function get_agents($conn) {
	$result = array();
	$tsql = "SELECT * FROM agent order by LTRIM(first_name) asc ";
	
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

function get_agents_under($conn,$id) {
	$result = array();
	$tsql = " SELECT a.id AS id_agent,first_name,last_name,un.* from agent a 
		 left join under un on un.id_agent = a.id 
		 where un.id_partner = '".$id."'";
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

function get_agent_ctr($conn) {
	$result = array();
	$tsql = "SELECT MAX(agent_ctr) FROM agent";
	
	$stmt = sqlsrv_query( $conn, $tsql);  
	if( $stmt === false) {
		die( print_r( sqlsrv_errors(), true) );
	}
	// Make the first (and in this case, only) row of the result set available for reading.
	if( sqlsrv_fetch( $stmt ) === false) {
		 die( print_r( sqlsrv_errors(), true));
	}
	$last_agent = sqlsrv_get_field( $stmt, 0);
	if ($last_agent == '') {
		$last_agent = 0;
	}
	return $last_agent;
}

function generate_agent_id($conn) {
	$result = '';
	$last_agent = get_agent_ctr($conn);
	$agent_id = 'A-'. str_pad($last_agent + 1, 8, '0', STR_PAD_LEFT);
	
	return $agent_id;
}

function save_agent ($conn, $post_data) {
	$data['table'] = 'agent';
	$data['columns'] = array(
	    'agent_ctr',
	    'agent_id',	    
	    'title_name',
	    'first_name',
	    'last_name',
	    'nick_name',
	    'tax_id',
	    'address_number',
	    'building_name',
	    'soi',
	    'road',
	    'sub_district',
	    'district',
	    'province',
	    'post_code',
	    'tel',
	    'mobile',
	    'email',
	   // 'id_rela_agent_insurance',
	    'agent_type',
	    'status',
	    'cdate',
	    'udate',
	    'create_by',
	    'modify_by'
	);
	$last_agent_ctr = get_agent_ctr($conn);
	$data['values'] = array(
	$last_agent_ctr+1,
	$post_data['agent_id'], 
	$post_data['title_name'],
	$post_data['first_name'],
	$post_data['last_name'],
	$post_data['nick_name'],
	$post_data['tax_id'],
	$post_data['address_number'],
	$post_data['building_name'],
	$post_data['soi'],
	$post_data['road'],
	$post_data['sub_district'],
	$post_data['district'],
	$post_data['province'],
	$post_data['post_code'],
	$post_data['tel'],
	$post_data['mobile'],
	$post_data['email'],
	//$post_data['id_rela_agent_insurance'],
	$post_data['agent_type'],
	1,
	date('Y-m-d H:i:s'),
	$post_data['udate'],
	$post_data['create_by'],
	$post_data['modify_by']
	);
	$agent_id = insert_table ($conn, $data);
	
	if (isset($post_data['insurance_company'])) {
		$ctr = 0;
		do {
    		// INSERT RELATIONSHIP
    		
    		// $data_rel['columns'] = array(
    		//     'id_agent',
    		//     'id_insurance', 
    		//     'agent_code'
    		// );
    		// $data_rel['table'] = 'rela_agent_to_insurance';
    		// $data_rel['values'] = array(
    		//     $agent_id,
    		//     $post_data['insurance_company'][$ctr],
    		//     $post_data['agent_code'][$ctr]
    		// );
    		// insert_table ($conn, $data_rel);

			if($post_data['insurance_company'][$ctr]!=""){
	    		$data_rel['columns'] = array(
	    		    'id_agent',
	    		    'id_partner', 
	    		    'under_code'
	    		);
	    		$data_rel['table'] = 'under';
	    		$data_rel['values'] = array(
	    		    $agent_id,
	    		    $post_data['insurance_company'][$ctr],
	    		    $post_data['agent_code'][$ctr]
	    		);
	    		insert_table ($conn, $data_rel);
    		}
    		$ctr++;
		}while($ctr < count($post_data['insurance_company']));
	}
	
}

function update_agent ($conn, $post_data) {
	$data['id'] = $post_data['id'];
    $data['table'] = 'agent';
    $data['columns'] = array(

        'title_name',
        'first_name',
        'last_name',
        'nick_name',
        'tax_id',
        'address_number',
        'building_name',
        'soi',
        'road',
        'sub_district',
        'district',
        'province',
        'post_code',
        'tel',
        'mobile',
        'email',
        // 'id_rela_agent_insurance',
        'agent_type',
        'status',
        'udate'
        //'create_by',
        //'modify_by'
    );
    //$last_agent_ctr = get_agent_ctr($conn);
    $data['values'] = array(
        $post_data['title_name'],
        $post_data['first_name'],
        $post_data['last_name'],
        $post_data['nick_name'],
        $post_data['tax_id'],
        $post_data['address_number'],
        $post_data['building_name'],
        $post_data['soi'],
        $post_data['road'],
        $post_data['sub_district'],
        $post_data['district'],
        $post_data['province'],
        $post_data['post_code'],
        $post_data['tel'],
        $post_data['mobile'],
        $post_data['email'],
        //$post_data['id_rela_agent_insurance'],
        $post_data['agent_type'],
        isset($post_data['check_active']) ? 1 : 0,
        date('Y-m-d H:i:s')
        //$post_data['create_by'],
        //$post_data['modify_by']
    );
	$last_id = update_table ($conn, $data);	

	$agent_id = $post_data['id'];
	for ($ctr=0;$ctr<count($post_data['id_insurance']);$ctr++) {
		if($post_data['id_insurance'][$ctr]!=""){
			
			$data_rel=null;
			$data_rel['id'] = $post_data['id_insurance'][$ctr];
			// $data_rel['table'] = 'rela_agent_to_insurance';

			// $data_rel['columns'] = array(
    		//     'id_insurance', 
    		//     'agent_code'
    		// );
    		// $data_rel['values'] = array(
    		//     $post_data['insurance_company'][$ctr],
    		//     $post_data['agent_code'][$ctr]
    		// );

    		if($post_data['insurance_company'][$ctr]!=""){
	    		$data_rel['table'] = 'under';

				$data_rel['columns'] = array(
	    		    'id_partner', 
	    		    'under_code'
	    		);
	    		$data_rel['values'] = array(
	    		    $post_data['insurance_company'][$ctr],
	    		    $post_data['agent_code'][$ctr]
	    		);
    		}

    		update_table($conn, $data_rel);
		}else{
			$data_rel=null;
			// $data_rel['table'] = 'rela_agent_to_insurance';

			// $data_rel['columns'] = array(
    		//     'id_agent',
    		//     'id_insurance', 
    		//     'agent_code'
    		// );
    		// $data_rel['values'] = array(
    		//     $agent_id,
    		//     $post_data['insurance_company'][$ctr],
    		//     $post_data['agent_code'][$ctr]
    		// );

			if($post_data['insurance_company'][$ctr]!=""){
	    		$data_rel['table'] = 'under';

				$data_rel['columns'] = array(
	    		    'id_agent',
	    		    'id_partner', 
	    		    'under_code'
	    		);
	    		$data_rel['values'] = array(
	    		    $agent_id,
	    		    $post_data['insurance_company'][$ctr],
	    		    $post_data['agent_code'][$ctr]
	    		);
    		}

    		insert_table ($conn, $data_rel);
		}
	}

}

function get_agent_insurance ($conn, $id) {
    $result = array();
    $tsql = " select a.id AS id_agent,under_code,un.* from agent a 
			 left join under un on un.id_agent = a.id 
			 where un.id_agent = ".$id;
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

function delete_insurance_list_data($conn, $post_data,$insu) {

	$array_delete=array();
	foreach ($insu as $data) {
		if (!in_array($data['id'],$post_data['id_insurance'])) { 
        	array_push($array_delete,$data['id']);
    	}
	}
	foreach($array_delete as $value) {
		// echo '<script>alert("value: '.$value.'")</script>'; 
		$data['id'] = $value;
		$data['table'] = 'rela_agent_to_insurance';	
		delete_table ($conn, $data);
	}
}


?>
