<?php
include_once('connect_sql.php');
include_once('fx_crud_db.php');

if ($_GET['action'] == 'del') {
	$policy_list = check_policy($conn,$_GET['id']);
	if(count($policy_list)==0){
		$data['id'] = $_GET['id'];
		$data['table'] = 'customer';
		delete_table($conn, $data);
		echo '<script>alert("Success deleted.")</script>';
		echo "<script>window.location.href ='../customer-information.php'</script>";
		// header('Location: ../customer-information.php');
	}else{
        // echo '<script>alert("There is already information in the Entry Policy. The information cannot be deleted.")</script>';
        echo '<script>alert("This data cannot be deleted due to its usage history in the system, but it can only be marked as inactive.")</script>';
        echo "<script>window.location.href ='../customer-information.php'</script>";
    }
}

function check_policy($conn,$id) {
	$result = array();
	$tsql = "SELECT TOP 1 * from rela_customer_to_insurance WHERE id_customer = '".$id."'";
	// echo '<script>alert("check_policy tsql: '.$tsql.'")</script>';
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
      THEN CONCAT(first_name,' ',last_name)
      ELSE company_name
      END as full_name
	,customer.*,cl.level_name FROM customer 
	LEFT JOIN customer_level cl ON cl.id = customer.customer_level
	order by LTRIM(first_name) asc";
	
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

function get_customers_search_start($conn) {
	$result = array();
// 	$sql = "SELECT pr.name_th AS name_th_province,di.name_th AS name_th_district,su.name_th AS name_th_sub
// 	,CONCAT(ct.first_name,' ',ct.last_name) AS full_name,con.first_name as con_first_name ,con.last_name as con_last_name,con.position,cl.level_name,ct.* FROM customer ct 
// 	LEFT JOIN customer_level cl ON ct.customer_level = cl.id
// 	LEFT JOIN rela_customer_to_contact re ON re.id_customer = ct.id
 // 	JOIN contact con ON con.id = re.id_contact
 // 	LEFT JOIN provinces pr ON ct.province = pr.code
 // LEFT JOIN district di ON ct.district = di.code
 // LEFT JOIN subdistrict su ON ct.sub_district = su.code
 // 	WHERE con.default_contact =1 ";

		// ,CONCAT(ct.first_name,' ',ct.last_name) AS full_name,con.first_name as con_first_name ,con.last_name as con_last_name
	$sql = "SELECT pr.name_en AS name_en_province,di.name_en AS name_en_district,su.name_en AS name_en_sub
	,con.email AS con_email,con.mobile AS con_mobile
	,CASE WHEN ct.customer_type = 'Personal'
      THEN CONCAT(ct.first_name,' ',ct.last_name)
      ELSE ct.company_name
      END as full_name
	,con.position,cl.level_name,ct.* FROM customer ct 
	LEFT JOIN customer_level cl ON ct.customer_level = cl.id
	LEFT JOIN rela_customer_to_contact re ON re.id_customer = ct.id
 	 JOIN contact con ON con.id = re.id_contact
 	LEFT JOIN provinces pr ON ct.province = pr.code
 LEFT JOIN district di ON ct.district = di.code
 LEFT JOIN subdistrict su ON ct.sub_district = su.code
 	WHERE con.default_contact =1 ";
	$sql = $sql." order by LTRIM(ct.first_name) asc ";
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

function get_customers_search($conn,$post_data) {
	$result = array();

	// echo '<script>alert("Sql : '.$post_data['status']." : ".$post_data['customer'].'")</script>'; 
	// CONCAT(ct.first_name,' ',ct.last_name) AS full_name,
	$sql = "SELECT pr.name_en AS name_en_province,di.name_en AS name_en_district,su.name_en AS name_en_sub
	,con.email AS con_email,con.mobile AS con_mobile
	,CASE WHEN ct.customer_type = 'Personal'
      THEN CONCAT(ct.first_name,' ',ct.last_name)
      ELSE ct.company_name
      END as full_name
	,con.position,cl.level_name,ct.* FROM customer ct 
	LEFT JOIN customer_level cl ON ct.customer_level = cl.id
	LEFT JOIN rela_customer_to_contact re ON re.id_customer = ct.id
 	 JOIN contact con ON con.id = re.id_contact
 	 LEFT JOIN provinces pr ON ct.province = pr.code
 LEFT JOIN district di ON ct.district = di.code
 LEFT JOIN subdistrict su ON ct.sub_district = su.code
 	 WHERE con.default_contact =1 ";
			// echo '<script>alert("Sql : '.$sql.'")</script>'; 
	if($post_data['status']!="all"){
		$sql = $sql." and ct.status = '".$post_data['status']."'";
	}

	if($post_data['customer']!="all"){
		// $sql = $sql." and CONCAT(ct.first_name,' ',ct.last_name) = '".$post_data['customer']."'";
		$sql = $sql." and ct.id = '".$post_data['customer']."'";
	}

	$sql = $sql." order by LTRIM(ct.first_name) asc ";
	echo '<script>alert("Sql : '.$sql.'")</script>'; 
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

function get_customer_by_id($conn, $id) {
	$result = array();
	$tsql = "SELECT * FROM customer "
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

function get_product($conn, $company_id) {
	$result = array();
	// $tsql = "SELECT * FROM customer "
	// 	. "WHERE id = ".$id;

	$tsql = " SELECT pr.* FROM product pr
	JOIN rela_partner_to_product rp ON rp.id_product = pr.id
	WHERE rp.id_partner = ".$company_id;
	
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

function get_customer_ctr($conn) {
	$result = array();
	$tsql = "SELECT MAX(customer_ctr) FROM customer";
	
	$stmt = sqlsrv_query( $conn, $tsql);  
	if( $stmt === false) {
		die( print_r( sqlsrv_errors(), true) );
	}
	// Make the first (and in this case, only) row of the result set available for reading.
	if( sqlsrv_fetch( $stmt ) === false) {
		 die( print_r( sqlsrv_errors(), true));
	}
	$last_customer = sqlsrv_get_field( $stmt, 0);
	if ($last_customer == '') {
		$last_customer = 0;
	}
	return $last_customer;
}

function generate_customer_id($conn) {
	$result = '';
	$last_customer = get_customer_ctr($conn);
	//echo $last_customer;
	$customer_id = 'C-'. str_pad($last_customer + 1, 6, '0', STR_PAD_LEFT);
	
	return $customer_id;
}

function save_customer ($conn, $post_data,$path) {
    $customer_id = '';
    $contact_id = '';
	$data['table'] = 'customer';
	$data['columns'] = array(
	'customer_ctr',
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
	'customer_type',
	'sub_district',
	'district',
	'province',
	'post_code',
	'cdate',
	//'create_by',
	//'id_rela_contact',
	//'id_rela_insurance_info',
	
	'personal_id',
	'customer_level',
	'status',
	'tax_id'
	);
	$last_customer = get_customer_ctr($conn);

	$data['values'] = array(
	$last_customer+1,
	$post_data['first_name'].' '.$post_data['last_name'],
	$post_data['customer_id'], 
	$post_data['title_name'], 
	$post_data['first_name'], 
	$post_data['last_name'], 
	$post_data['nick_name'], 
	$post_data['company_name'], 
	$post_data['tel'], 
	$post_data['mobile'], 
	$post_data['email'], 
	$post_data['address_number'],
	$post_data['building_name'],
	$post_data['soi'], 
	$post_data['road'], 
	$post_data['customer_type'],
	$post_data['sub_district'],
	$post_data['district'],
	$post_data['province'],
	$post_data['post_code'],
	date('Y-m-d H:i:s'),
	//$post_data['create_by'],
	//$post_data['id_rela_contact'],
	//$post_data['id_rela_insurance_info'],	
	$post_data['personal_id'],
	$post_data['customer_level'],
	1,
	$post_data['tax_id']
	);
	$customer_id = insert_table ($conn, $data);
	//print_r($post_data);
	//echo "<br><br>";
	//print_r($post_data['contact_first_name']);
	
	if (isset($post_data['contact_first_name'])) {
	    //$data_contact = array();
		$ctr = 0;
		$contact_name = $post_data['contact_first_name'];
		$data_contact['table'] = 'contact';
		$data_rel['table'] = 'rela_customer_to_contact';
		do {
		    $data_contact['columns'] = array(
		        'title_name',
		        'first_name',
		        'last_name',
		        'nick_name',
		        'tel',
		        'mobile',
		        'email',
		        'line_id',
		        'position',
		        'remark',
		        'department',
		        'default_contact'
		    );

		    $check_default = 0;
	        if($post_data['default_contact'][0]==$post_data['hid_default'][$ctr]){
	        	$check_default =1;
	        }
		    $data_contact['values'] = array(
		        (isset($post_data['contact_title_name'][$ctr])) ? $post_data['contact_title_name'][$ctr] : '',
		        (isset($post_data['contact_first_name'][$ctr])) ? $post_data['contact_first_name'][$ctr] : '',
		        (isset($post_data['contact_last_name'][$ctr])) ? $post_data['contact_last_name'][$ctr] : '',
		        (isset($post_data['contact_nick_name'][$ctr])) ? $post_data['contact_nick_name'][$ctr] : '',
		        (isset($post_data['contact_tel'][$ctr])) ?  $post_data['contact_tel'][$ctr] : '',
		        (isset($post_data['contact_mobile'][$ctr])) ? $post_data['contact_mobile'][$ctr] : '',
		        (isset($post_data['contact_email'][$ctr])) ? $post_data['contact_email'][$ctr] : '',
		        (isset($post_data['contact_line_id'][$ctr])) ? $post_data['contact_line_id'][$ctr] : '',
		        (isset($post_data['contact_position'][$ctr])) ? $post_data['contact_position'][$ctr] : '',
		        (isset($post_data['contact_remark'][$ctr])) ? $post_data['contact_remark'][$ctr] : '',
		        (isset($post_data['department'][$ctr])) ? $post_data['department'][$ctr] : '',
		        $check_default
		    );
		    $contact_id = insert_table ($conn, $data_contact);
		    
		    // INSERT RELATIONSHIP
		    
		    $data_rel['columns'] = array(
		        'id_customer',
		        'id_contact'
		    );
		    
		    $data_rel['values'] = array(
		        $customer_id,
		        $contact_id
		    );
		    $contact_id = insert_table ($conn, $data_rel);
		    $ctr++;
		}while($ctr < count($contact_name));
	} // END OF IF CONTACTS

	// echo '<script>alert("Start policy_no: '.$lastInsertId_customer.'")</script>'; 

	$start_check="true";
	$start_insurance_id="";

	$ctr1 = 0;
	if ($post_data['policy_no'][$ctr1]!="") {
	// if (isset($post_data['policy_no'])) {
	    //$data_contact = array();
	    $data_insurance['table'] = 'insurance_info';
	    $data_rel['table'] = 'rela_customer_to_insurance';
	    do {
	        $data_insurance['columns'] = array(
	            'policy_no',
	            'insurance_company_id',
	            'product_category',
	            'sub_categories',
	            'product_id',
	            'period',
	            'start_date',
	            'end_date',
	            'premium_rate',
	            'status',
	            'agent_id',
	            'default_insurance',
	            'file_name',
	            'file_name_uniqid'
	        );
	        
	        //////////// upload ////////////
	        $new_file_name="";
	        if($_FILES['file_d']['name'][$ctr1]!=""){
	            try {
	                $file = $_FILES['file_d']['name'][$ctr1];
	                $file_loc = $_FILES['file_d']['tmp_name'][$ctr1];
	                $folder=$path;
	                $ext = pathinfo($file, PATHINFO_EXTENSION);
	                $new_file_name = uniqid().".".$ext;
	                $path_file = $folder."/".$new_file_name;
	                $final_file = str_replace(' ','-',$new_file_name);
	                move_uploaded_file($file_loc,$folder.$final_file);
	            }catch(Exception $e) {
	                // echo '<script>alert("Error : '.$e.'")</script>';
	            }
	        }
	        ////////////////////////////////////
	        $default_insurance=0;
	        if($start_check=="true"){
	        	$default_insurance =1;
	        }
	        
	        $data_insurance['values'] = array(
	            (isset($post_data['policy_no'][$ctr1])) ? $post_data['policy_no'][$ctr1] : '',
	            (isset($post_data['insurance_company'][$ctr1])) ? $post_data['insurance_company'][$ctr1] : '',
	            (isset($post_data['product_category'][$ctr1])) ? $post_data['product_category'][$ctr1] : '',
	            (isset($post_data['sub_cat'][$ctr1])) ? $post_data['sub_cat'][$ctr1] : '',
	            (isset($post_data['product_name'][$ctr1])) ? $post_data['product_name'][$ctr1] : '',
	            (isset($post_data['period'][$ctr1])) ?  $post_data['period'][$ctr1] : '',
	            (isset($post_data['start_date'][$ctr1])) ? date("Y-m-d", strtotime($post_data['start_date'][$ctr1])) : '',
	            (isset($post_data['end_date'][$ctr1])) ? date("Y-m-d", strtotime($post_data['end_date'][$ctr1])) : '',
	            // (isset($post_data['premium_rate'][$ctr1])) ? $post_data['premium_rate'][$ctr1] : '',
	            $post_data['premium_rate'][$ctr1],
	            (isset($post_data['insurance_status'][$ctr1])) ? $post_data['insurance_status'][$ctr1] : '',
	            (isset($post_data['agent_name'][$ctr1])) ? $post_data['agent_name'][$ctr1] : '1',
	            (isset($default_insurance)) ? $default_insurance : '',
	            (isset($_FILES['file_d']['name'][$ctr1])) ? $_FILES['file_d']['name'][$ctr1] : '',
	            (isset($new_file_name)) ? $new_file_name : ''
	        );
		
	        $insurance_id = insert_table ($conn, $data_insurance);
	        //$id_default_insurance = 0
	        // INSERT RELATIONSHIP

	        if($start_check=="true"){
	        	$start_insurance_id=$insurance_id;
	        	$start_check="false";
			}
	        
	        $data_rel['columns'] = array(
	            'id_customer',
	            'id_insurance_info',
                'id_default_insurance'
	        );
	        
	        $data_rel['values'] = array(
	            $customer_id,
	            $insurance_id, 
	            $start_insurance_id
	        );

	        $contact_id = insert_table ($conn, $data_rel);
	        $ctr1++;
	    }while($ctr1 < count($post_data['policy_no']));
	} // END OF IF INDURANCE    
	
	// header('Location: customer-information.php');
}

function delete_contact_list($conn, $post_data,$contacts) {
	// echo '<script>alert("Run delete_contact_list")</script>'; 
	$array_delete=array();
	foreach ($contacts as $data) {
		if (!in_array($data['id'],$post_data['id_contact'])) { 
        	array_push($array_delete,$data['id']);
    	}
	}
	foreach($array_delete as $value) {
		// $data['id'] = $_GET['id'];
		$data['id'] = $value;
		$data['table'] = 'contact';	
		delete_table ($conn, $data);
	}
}

function delete_insurance_list($conn, $post_data,$insurance) {
	$array_delete=array();
	foreach ($insurance as $data) {
		if (!in_array($data['id'],$post_data['id_insurance_info'])) { 
        	array_push($array_delete,$data['id']);
    	}
	}
	foreach($array_delete as $value) {
		$data['id'] = $value;
		$data['table'] = 'insurance_info';	
		delete_table ($conn, $data);
	}
}

function update_customer ($conn, $post_data,$path) {
	
    $data['id'] = $post_data['id'];
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
	'customer_type',
	'sub_district',
	'district',
	'province',
	'post_code',

	//'id_rela_contact',
	//'id_rela_insurance_info',
	
	'personal_id',
	'customer_level',
	'status',
	'tax_id'
	);
	
	$data['values'] = array(
	trim($post_data['first_name'].' '.$post_data['last_name']),
	trim($post_data['customer_id']), 
	trim($post_data['title_name']), 
	trim($post_data['first_name']), 
	trim($post_data['last_name']), 
	trim($post_data['nick_name']), 
	trim($post_data['company_name']), 
	trim($post_data['tel']), 
	trim($post_data['mobile']), 
	trim($post_data['email']), 
	trim($post_data['address_number']),
	$post_data['building_name'],
	$post_data['soi'], 
	$post_data['road'], 
	$post_data['customer_type'],
	$post_data['sub_district'],
	$post_data['district'],
	$post_data['province'],
	$post_data['post_code'],
	/*
	$post_data['id_rela_contact'],
	$post_data['id_rela_insurance_info'],
	*/
	$post_data['personal_id'],
	$post_data['customer_level'],
	isset($post_data['check_active']) ? 1 : 0,
	$post_data['tax_id']
	);
	update_table ($conn, $data);
	

	if (isset($post_data['contact_title_name'])) {
	    for ($ctr=0;$ctr<count($post_data['id_contact']);$ctr++) {
	    	if ($post_data['id_contact'][$ctr] != '') {
	    		$data_contact['id'] = $post_data['id_contact'][$ctr];
	    		$data_contact['table'] = 'contact';
	    		$data_contact['columns'] = array(
	                'title_name',
	                'first_name',
	                'last_name',
	                'nick_name',
	                'tel',
	                'mobile',
	                'email',
	                'line_id',
	                'position',
	                'remark',
	                'department',
	                'default_contact'
	    		);

	    		$default_status="0";
	    		if($post_data['default_contact'][0]==$post_data['hid_default'][$ctr]){
                    $default_status="1";
                }
	            $data_contact['values'] = array(
	            	trim($post_data['contact_title_name'][$ctr]),
	                trim($post_data['contact_first_name'][$ctr]),
	                trim($post_data['contact_last_name'][$ctr]),
	                trim($post_data['contact_nick_name'][$ctr]),
	                trim($post_data['contact_tel'][$ctr]),
	                trim($post_data['contact_mobile'][$ctr]),
	                trim($post_data['contact_email'][$ctr]),
	                trim($post_data['contact_line_id'][$ctr]),
	                trim($post_data['contact_position'][$ctr]),
	                trim($post_data['contact_remark'][$ctr]),
					trim($post_data['department'][$ctr]),
	                $default_status
	                
	            );
	            //$last_id =  insert_table($conn, $data_contact);
	            update_table($conn, $data_contact);
	    	}else{
	    		$data_contact['table'] = 'contact';
	    		$data_contact['columns'] = array(
	                'title_name',
	                'first_name',
	                'last_name',
	                'nick_name',
	                'tel',
	                'mobile',
	                'email',
	                'line_id',
	                'position',
	                'remark',
	                'department',
	                'default_contact'
	    		);
	    		$default_status="0";
	    		if($post_data['default_contact'][0]==$post_data['hid_default'][$ctr]){
                    $default_status="1";
                }
	            $data_contact['values'] = array(
	            	trim($post_data['contact_title_name'][$ctr]),
	                trim($post_data['contact_first_name'][$ctr]),
	                trim($post_data['contact_last_name'][$ctr]),
	                trim($post_data['contact_nick_name'][$ctr]),
	                trim($post_data['contact_tel'][$ctr]),
	                trim($post_data['contact_mobile'][$ctr]),
	                trim($post_data['contact_email'][$ctr]),
	                trim($post_data['contact_line_id'][$ctr]),
	                trim($post_data['contact_position'][$ctr]),
	                trim($post_data['contact_remark'][$ctr]),
	                trim($post_data['department'][$ctr]),
	                $default_status
	                
	            );
	            $last_id =  insert_table($conn, $data_contact);

	            $data_rel['table'] = 'rela_customer_to_contact';
	            $data_rel['columns'] = array(
		        'id_customer',
		        'id_contact'
		    	);
		    
		    	$data_rel['values'] = array(
		        	$post_data['id'],
		        	$last_id
		    	);
		    	$contact_id = insert_table ($conn, $data_rel);
	    	}
	    }
	}
	   
	// if (isset($post_data['policy_no'])) {
	if ($post_data['policy_no'][0]!="") {
		for ($ctr=0;$ctr<count($post_data['id_insurance_info']);$ctr++) {
			if ($post_data['id_insurance_info'][$ctr] != '') {
				$data_insurance['id'] = $post_data['id_insurance_info'][$ctr];
				$data_insurance['table'] = 'insurance_info';
				$data_insurance['columns'] = array(
	            'policy_no',
	            'insurance_company_id',
	            'product_category',
	            'sub_categories',
	            'product_id',
	            'period',
	            'start_date',
	            'end_date',
	            'premium_rate',
	            'status',
	            'agent_id',
	            'default_insurance'
	        	);
	        	// 'file_name',
	            // 'file_name_uniqid'
			// echo '<script>alert("id_insurance_info: '.$post_data['id_insurance_info'][$ctr].'")</script>'; 
	       
	        $default_insurance=0;
	        if($start_check=="true"){
	        	$default_insurance =1;
	        }
	        // echo '<script>alert("premium_rate: '.floatval($post_data['premium_rate'][$ctr]).'")</script>'; 
	        
	        	$data_insurance['values'] = array(
	            (isset($post_data['policy_no'][$ctr])) ? $post_data['policy_no'][$ctr] : '',
	            (isset($post_data['insurance_company'][$ctr])) ? $post_data['insurance_company'][$ctr] : '',
	            (isset($post_data['product_category'][$ctr])) ? $post_data['product_category'][$ctr] : '',
	            (isset($post_data['sub_cat'][$ctr])) ? $post_data['sub_cat'][$ctr] : '',
	            (isset($post_data['product_name'][$ctr])) ? $post_data['product_name'][$ctr] : '',
	            (isset($post_data['period'][$ctr])) ?  $post_data['period'][$ctr] : '',
	            (isset($post_data['start_date'][$ctr])) ? date("Y-m-d", strtotime($post_data['start_date'][$ctr])) : '',
	            (isset($post_data['end_date'][$ctr])) ? date("Y-m-d", strtotime($post_data['end_date'][$ctr])) : '',
	            // (isset($post_data['premium_rate'][$ctr])) ? $post_data['premium_rate'][$ctr] : '',
	            $post_data['premium_rate'][$ctr],
	            (isset($post_data['insurance_status'][$ctr])) ? $post_data['insurance_status'][$ctr] : '',
	            (isset($post_data['agent_name'][$ctr])) ? $post_data['agent_name'][$ctr] : '1',
	            (isset($default_insurance)) ? $default_insurance : ''
	        	);
	        	// (isset($_FILES['file_d']['name'][$ctr])) ? $_FILES['file_d']['name'][$ctr] : '',
	            // (isset($new_file_name)) ? $new_file_name : ''

	        	 //////////// upload ////////////
	        	// echo '<script>alert("post file_d : '.$_FILES['file_d']['name'][$ctr].'")</script>';
	        	$new_file_name="";
	        	if($_FILES['file_d']['name'][$ctr]!=""){
	        		try {
	                $file = $_FILES['file_d']['name'][$ctr];
	                $file_loc = $_FILES['file_d']['tmp_name'][$ctr];
	                // $image=$_POST['file_d'];
	                $folder=$path;
	                $ext = pathinfo($file, PATHINFO_EXTENSION);
	                $new_file_name = uniqid().".".$ext;
	                $path_file = $folder."/".$new_file_name;
	                $final_file = str_replace(' ','-',$new_file_name);
	                move_uploaded_file($file_loc,$folder.$final_file);
	            	}catch(Exception $e) {
	                	// echo '<script>alert("Error : '.$e.'")</script>';
	            	}
	        		array_push($data_insurance['columns'],'file_name');
	        		array_push($data_insurance['columns'],'file_name_uniqid');
	        		array_push($data_insurance['values'],$_FILES['file_d']['name'][$ctr]);
	        		array_push($data_insurance['values'],$new_file_name);
	        	}
	        	update_table($conn, $data_insurance);

			}else{
				if ($post_data['policy_no'][$ctr]!="") { //check policy_no null no insert
				$data_insurance['table'] = 'insurance_info';
				$data_insurance['columns'] = array(
	            'policy_no',
	            'insurance_company_id',
	            'product_category',
	            'sub_categories',
	            'product_id',
	            'period',
	            'start_date',
	            'end_date',
	            'premium_rate',
	            'status',
	            'agent_id',
	            'default_insurance',
	            'file_name',
	            'file_name_uniqid'
	        	);
				//////////// upload ////////////
	        $new_file_name="";
	        // echo '<script>alert("post file_d : '.$_FILES['file_d']['name'][$i].'")</script>';
	        	if($_FILES['file_d']['name'][$i]!=""){
	            	try {
	                $file = $_FILES['file_d']['name'][$i];
	                // $_FILES['picture']['tmp_name'][$i]
	                $file_loc = $_FILES['file_d']['tmp_name'][$i];
	                // $image=$_POST['file_d'];
	                $folder=$path;
	                $ext = pathinfo($file, PATHINFO_EXTENSION);
	                $new_file_name = uniqid().".".$ext;
	                $path_file = $folder."/".$new_file_name;
	                $final_file = str_replace(' ','-',$new_file_name);
	                move_uploaded_file($file_loc,$folder.$final_file);
	            	}catch(Exception $e) {
	                // echo '<script>alert("Error : '.$e.'")</script>';
	            	}
	        	}
	        	////////////////////////////////////
	        	$default_insurance=0;
	        	if($start_check=="true"){
	        		$default_insurance =1;
	        	}
	        	$data_insurance['values'] = array(
	            (isset($post_data['policy_no'][$ctr])) ? $post_data['policy_no'][$ctr] : '',
	            (isset($post_data['insurance_company'][$ctr])) ? $post_data['insurance_company'][$ctr] : '',
	            (isset($post_data['product_category'][$ctr])) ? $post_data['product_category'][$ctr] : '',
	            (isset($post_data['sub_cat'][$ctr])) ? $post_data['sub_cat'][$ctr] : '',
	            (isset($post_data['product_name'][$ctr])) ? $post_data['product_name'][$ctr] : '',
	            (isset($post_data['period'][$ctr])) ?  $post_data['period'][$ctr] : '',
	            (isset($post_data['start_date'][$ctr])) ? date("Y-m-d", strtotime($post_data['start_date'][$ctr])) : '',
	            (isset($post_data['end_date'][$ctr])) ? date("Y-m-d", strtotime($post_data['end_date'][$ctr])) : '',
	            (isset($post_data['premium_rate'][$ctr])) ? $post_data['premium_rate'][$ctr] : '',
	            // '123',
	            (isset($post_data['insurance_status'][$ctr])) ? $post_data['insurance_status'][$ctr] : '',
	            (isset($post_data['agent_name'][$ctr])) ? $post_data['agent_name'][$ctr] : '1',
	            (isset($default_insurance)) ? $default_insurance : '',
	            (isset($_FILES['file_d']['name'][$ctr])) ? $_FILES['file_d']['name'][$ctr] : '',
	            (isset($final_file)) ? $final_file : ''
	        	);
	        	$insurance_id = insert_table ($conn, $data_insurance);

	        	$data_rel['table'] = 'rela_customer_to_insurance';
	        	$data_rel['columns'] = array(
	            	'id_customer',
	            	'id_insurance_info',
                	'id_default_insurance'
	        	);

	        	$data_rel['values'] = array(
	            	$post_data['id'],
	            	$insurance_id, 
	            	$post_data['id_insurance_info'][0]
	        	);
	        	insert_table ($conn, $data_rel);
	        	}//End check policy_no null no insert
			}
		}
	}
	    

}

function get_customer_contact ($conn, $id) {
    $result = array();
    $tsql = "select c.*,rc.id_customer
         from contact c "
            . "left join rela_customer_to_contact rc on rc.id_contact = c.id "
            . "where rc.id_customer = ".$id;
        
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
