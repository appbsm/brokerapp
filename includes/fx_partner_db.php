<?php
// include_once('connect_sql.php');
include_once('fx_crud_db.php');

function check_insurance($conn,$id) {
	$result = array();
	$tsql = "SELECT TOP 1 * from insurance_info WHERE insurance_company_id = '".$id."'";
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

function get_partners($conn) {
	$result = array();
	$tsql = "SELECT * FROM insurance_partner order by LTRIM(insurance_company) asc ";
	
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

function get_partners_contact_search_start($conn) {
	$result = array();

	$sql = $sql."SELECT pr.name_en AS name_en_province,di.name_en AS name_en_district,su.name_en AS name_en_sub
		,con.email as email_con,con.mobile as mobile_con,con.position
		,con.first_name,con.last_name,ip.* FROM  insurance_partner ip
		left JOIN rela_partner_to_contact re_ct ON ip.id = re_ct.id_insurance_partner
		left JOIN contact con ON con.id = re_ct.id_contact
		LEFT JOIN provinces pr ON ip.province = pr.code
		LEFT JOIN district di ON ip.district = di.code
		LEFT JOIN subdistrict su ON ip.sub_district = su.code
		";
		// WHERE con.default_contact = 1
	$sql = $sql." order by ip.insurance_id asc ";
	// $sql = $sql." order by LTRIM(ip.insurance_company) asc ";
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

function get_partners_contact_search($conn,$post_data) {
	$result = array();
	$sql = $sql."SELECT pr.name_en AS name_en_province,di.name_en AS name_en_district,su.name_en AS name_en_sub
		,con.email as email_con,con.mobile,con.position,con.first_name,con.last_name,ip.* 
		FROM  insurance_partner ip
		left JOIN rela_partner_to_contact re_ct ON ip.id = re_ct.id_insurance_partner
		left JOIN contact con ON con.id = re_ct.id_contact
		LEFT JOIN provinces pr ON ip.province = pr.code
		LEFT JOIN district di ON ip.district = di.code
		LEFT JOIN subdistrict su ON ip.sub_district = su.code
		WHERE ip.insurance_id != ''  ";

	if($post_data['status']!="all"){
		$sql = $sql." and ip.status = '".$post_data['status']."'";
	}

	if($post_data['partner']!="all"){
		$sql = $sql." and ip.insurance_company = '".$post_data['partner']."'";
	}
	$sql = $sql." order by ip.insurance_id asc ";

	// $sql = $sql." order by LTRIM(ip.insurance_company) asc ";
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

function get_partners_search_start($conn) {
	$result = array();

	$sql = $sql."SELECT pr.name_en AS name_en_province,di.name_en AS name_en_district,su.name_en AS name_en_sub
		,con.email as email_con,con.mobile as mobile_con,con.position
		,con.first_name,con.last_name,ip.* FROM  insurance_partner ip
		left JOIN rela_partner_to_contact re_ct ON ip.id = re_ct.id_insurance_partner
		left JOIN contact con ON con.id = re_ct.id_contact
		LEFT JOIN provinces pr ON ip.province = pr.code
		LEFT JOIN district di ON ip.district = di.code
		LEFT JOIN subdistrict su ON ip.sub_district = su.code
		WHERE con.default_contact = 1";
	$sql = $sql." order by ip.insurance_id asc ";
	// $sql = $sql." order by LTRIM(ip.insurance_company) asc ";
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

function get_partners_search($conn,$post_data) {
	$result = array();
	$sql = $sql."SELECT pr.name_en AS name_en_province,di.name_en AS name_en_district,su.name_en AS name_en_sub
		,con.email as email_con,con.mobile,con.position,con.first_name,con.last_name,ip.* FROM  insurance_partner ip
		left JOIN rela_partner_to_contact re_ct ON ip.id = re_ct.id_insurance_partner
		left JOIN contact con ON con.id = re_ct.id_contact
		LEFT JOIN provinces pr ON ip.province = pr.code
		LEFT JOIN district di ON ip.district = di.code
		LEFT JOIN subdistrict su ON ip.sub_district = su.code
		WHERE con.default_contact = 1";

	if($post_data['status']!="all"){
		$sql = $sql." and ip.status = '".$post_data['status']."'";
	}

	if($post_data['partner']!="all"){
		$sql = $sql." and ip.insurance_company = '".$post_data['partner']."'";
	}
	$sql = $sql." order by ip.insurance_id asc ";
	// $sql = $sql." order by LTRIM(ip.insurance_company) asc ";
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

function get_partner_ctr($conn) {
	$result = array();
	$tsql = "SELECT MAX(insurance_id) FROM insurance_partner";
	// $tsql = "SELECT MAX(partner_ctr) FROM insurance_partner";
	
	$stmt = sqlsrv_query( $conn, $tsql);  
	if($stmt === false) {
		die( print_r( sqlsrv_errors(), true) );
	}
	// Make the first (and in this case, only) row of the result set available for reading.
	if( sqlsrv_fetch( $stmt ) === false) {
		 die( print_r( sqlsrv_errors(), true));
	}

	$last_customer = sqlsrv_get_field($stmt, 0);
	if ($last_customer == '') {
		$last_customer = "P-000000";
	}
	return $last_customer;
}

function generate_partner_id($conn) {
	$result = '';
	$last_partner = get_partner_ctr($conn);

	$prefix = substr($last_partner, 0, strrpos($last_partner, '-') + 1);
	$number = (int)substr($last_partner, strrpos($last_partner, '-') + 1);

	// เพิ่มเลขเข้าไป
	$number += 1;

	// จัดรูปแบบตัวเลขใหม่ให้อยู่ในรูปแบบที่มี 6 หลัก (000013)
	$new_number = str_pad($number, 6, '0', STR_PAD_LEFT);

	// รวมส่วนของ prefix และตัวเลขเข้าด้วยกัน
	$last_partner = $prefix . $new_number;

	// $partner_id = 'P-'. str_pad($last_partner + 1, 6, '0', STR_PAD_LEFT);
	
	return $last_partner;
}

function get_partner_bank($conn, $id) {
    $result = array();
    $tsql = "SELECT * FROM bank "
        . "WHERE id_partner = ".$id;
        
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

function save_partner($conn, $post_data) {
    $id_partner = '';
	$data['table'] = 'insurance_partner';
	$data['columns'] = array(
	'partner_ctr',
	'insurance_id', 
	'address_number',
	'building_name',
	'soi',
	'road',
	'sub_district',
	'district',
	'province',
	'post_code',
	'cdate',
	'create_by',
	'modify_by',
	'id_rela_product',
	'id_rela_contact',
	'status',
	'website',
	'insurance_company',
	'email',
	'phone',
	'tel',
	'fax',
	'tax_id',
	'short_name_partner',
	'web_company',
	'id_currency_list'
	);

	$status = $post_data['status'];
	if($post_data['status']==''){
		$status=0;
	}else{
		$status=1;
	}

	$insurance_id = generate_partner_id($conn);

	$last_partner = get_partner_ctr($conn);
	$data['values'] = array(
	$last_partner+1,
	// $post_data['insurance_id'], 
	$insurance_id,
	$post_data['address_number'],
	$post_data['building_name'],
	$post_data['soi'],
	$post_data['road'],
	$post_data['sub_district'],
	$post_data['district'],
	$post_data['province'],
	$post_data['post_code'],
	date('Y-m-d H:i:s'),
	$_SESSION['id'],
	'',
	$post_data['id_rela_product'],
	$post_data['id_rela_contact'],
	$status,
	$post_data['website'],
	$post_data['insurance_company'],
	$post_data['email'],
	$post_data['phone'],
	$post_data['tel'],
	$post_data['fax'],
	$post_data['tax_id'],
	$post_data['short_name_partner'],
	$post_data['web_company'],
	$post_data['id_currency_list']
	);
	$id_partner = insert_table ($conn, $data);

	if (isset($post_data['product_id'])) {
		$ctr = 0;
		$product_id = $post_data['product_id'];
		$data_rel_product['table'] = 'rela_partner_to_product';
		do {
			$data_rel_product['columns'] = array(
	            'id_partner',
	            'id_product'
	        );
	        
	        $data_rel_product['values'] = array(
	            $id_partner,
	            $post_data['product_id'][$ctr]
	        );
	        insert_table ($conn, $data_rel_product);
	    $ctr++;
		}while($ctr < count($product_id));
	}

	// if (isset($post_data['agent_under'])) {

		$ctr = 0;
		$agent_id = $post_data['agent_under'];
		$data_under['table'] = 'under';
		do {
			if ($post_data['agent_under'][$ctr]!="") {


				$data_under['columns'] = array(
		            'under_code',
		            'id_agent',
		            'percen_value',
		            'net_value',
		            'type_default',
		            'id_partner'
		        );

				$percen = substr($_POST['agent_percent'][$ctr],0,-1);
		        $data_under['values'] = array(
		            $post_data['agent_code'][$ctr],
		            $post_data['agent_under'][$ctr],
		            $percen,
		            $post_data['agent_net'][$ctr],
		            $post_data["default_type".($ctr+1)],
		            $id_partner
		        );
		        insert_table($conn, $data_under);
		    }
		$ctr++;
		}while($ctr < count($agent_id));

	// }

	// if (isset($post_data['contact_first_name'])) {
	    //$data_contact = array();
	    $ctr = 0;
	    $contact_name = $post_data['contact_first_name'];
	    $data_contact['table'] = 'contact';
	    $data_rel['table'] = 'rela_partner_to_contact';

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

	        // if (!in_array($data['id'],$post_data['id_contact'])) { 

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
	            'id_insurance_partner',
	            'id_contact'
	        );
	        
	        $data_rel['values'] = array(
	            $id_partner,
	            $contact_id
	        );
	        $contact_id = insert_table ($conn, $data_rel);
	        $ctr++;
	    }while($ctr < count($contact_name));
	// } // END OF IF CONTACTS
	
	// if (isset($post_data['bank_name'])) {
	    //$data_contact = array();
	    $ctr = 0;
	    $data_bank['table'] = 'bank';	   
	    do{
	    	if($post_data['bank_name'][$ctr]!=="" || $post_data['bank_account'][$ctr]!=="" 
	    		|| $post_data['bank_type'][$ctr]!=="" || $post_data['bank_account_name'][$ctr]!==""){

		        $data_bank['columns'] = array(
		            'bank_name',
		            'bank_account',
		            'bank_type',
		            'bank_account_name',
		            'cdate',
		            'id_partner'
		           //'create_by'
		        );
		        
		        $data_bank['values'] = array(
		            (isset($post_data['bank_name'][$ctr])) ? $post_data['bank_name'][$ctr] : '',
		            (isset($post_data['bank_account'][$ctr])) ? $post_data['bank_account'][$ctr] : '',
		            (isset($post_data['bank_type'][$ctr])) ? $post_data['bank_type'][$ctr] : '',
		            (isset($post_data['bank_account_name'][$ctr])) ? $post_data['bank_account_name'][$ctr] : '',	            
		            date('Y-m-d H:i:s'),
		            $id_partner
		        );
		        $bankt_id = insert_table ($conn, $data_bank);
	        }

	        $ctr++;
	    }while($ctr < count($post_data['bank_name']));
	// } // END OF IF CONTACTS
	
}

function update_partner ($conn, $post_data) {
	$id_partner = $post_data['id'];
    $data['id'] = $post_data['id'];
	$data['table'] = 'insurance_partner';
	$data['columns'] = array(
	'insurance_id',
	'address_number',
	'building_name',
	'soi',
	'road',
	'sub_district',
	'district',
	'province',
	'post_code',
	'modify_by',
	'udate',
	'status',
	'website',
	'insurance_company',
	'email',
	'phone',
	'tel',
	'tax_id',
	'short_name_partner',
	'web_company',
	'id_currency_list'
	);
	// alert("test");
	// echo '<script >alert("test:'.$post_data['phone'].'");</script>';
	$data['values'] = array(	
	$post_data['insurance_id'],
	$post_data['address_number'],
	$post_data['building_name'],
	$post_data['soi'],
	$post_data['road'],
	$post_data['sub_district'],
	$post_data['district'],
	$post_data['province'],
	$post_data['post_code'],
	$_SESSION['id'],
	date('Y-m-d H:i:s'),
	$post_data['status'],
	$post_data['website'],
	$post_data['insurance_company'],
	$post_data['email'],
	$post_data['phone'],
	$post_data['tel'],
	$post_data['tax_id'],
	$post_data['short_name_partner'],
	$post_data['web_company'],
	$post_data['id_currency_list']
	);
	//'modify_by',
	//'id_rela_product',
	//'id_rela_contact',

	update_table ($conn, $data);

	// echo '<script>alert("id_bank: '.count($post_data['id_bank']).'")</script>'; 
	for ($ctr=0;$ctr<count($post_data['id_bank']);$ctr++) {
		$id_bank = $post_data['id_bank'];

	    if($post_data['id_bank'][$ctr]!=""){
	    	$data_bank=null;
	    	$data_bank['id'] = $post_data['id_bank'][$ctr];
	    	$data_bank['table'] = 'bank';
	        $data_bank['columns'] = array(
	            'bank_name',
	            'bank_account',
	            'bank_type',
	            'bank_account_name',
	            // 'cdate',
	            'id_partner'
	        );
	        $data_bank['values'] = array(
	            (isset($post_data['bank_name'][$ctr])) ? $post_data['bank_name'][$ctr] : '',
	            (isset($post_data['bank_account'][$ctr])) ? $post_data['bank_account'][$ctr] : '',
	            (isset($post_data['bank_type'][$ctr])) ? $post_data['bank_type'][$ctr] : '',
	            (isset($post_data['bank_account_name'][$ctr])) ? $post_data['bank_account_name'][$ctr] : '',	            
	            // date('Y-m-d H:i:s'),
	            $id_partner
	        );
	        update_table($conn, $data_bank);
	    }else{
	    	if($post_data['bank_name'][$ctr]!=="" || $post_data['bank_account'][$ctr]!=="" 
	    		|| $post_data['bank_type'][$ctr]!=="" || $post_data['bank_account_name'][$ctr]!==""){

		    	$data_bank=null;
		    	$data_bank['table'] = 'bank';
		    	$data_bank['columns'] = array(
		            'bank_name',
		            'bank_account',
		            'bank_type',
		            'bank_account_name',
		            'cdate',
		            'id_partner'
		        );
		        
		        $data_bank['values'] = array(
		            (isset($post_data['bank_name'][$ctr])) ? $post_data['bank_name'][$ctr] : '',
		            (isset($post_data['bank_account'][$ctr])) ? $post_data['bank_account'][$ctr] : '',
		            (isset($post_data['bank_type'][$ctr])) ? $post_data['bank_type'][$ctr] : '',
		            (isset($post_data['bank_account_name'][$ctr])) ? $post_data['bank_account_name'][$ctr] : '',	            
		            date('Y-m-d H:i:s'),
		            $id_partner
		        );
		        $bankt_id = insert_table ($conn,$data_bank);
	    	}
	    }

	}

	// echo '<script>alert("id_under: '.count($post_data['id_under']).'")</script>'; 
	
	for ($ctr=0;$ctr<count($post_data['id_under']);$ctr++) {
		if($post_data['id_under'][$ctr]!=""){
			if ($post_data['agent_under'][$ctr]!="") {
				$data_under=null;
				$data_under['id'] = $post_data['id_under'][$ctr];
				$data_under['table'] = 'under';
				$data_under['columns'] = array(
		            'under_code',
		            'id_agent',
		            'percen_value',
		            'net_value',
		            'type_default',
		            'id_partner'
		        );

		        // $agent_percent_p = (float) str_replace(',', '', $_POST['convertion_value'][$i]);
				$percen = substr($_POST['agent_percent'][$ctr],0,-1);

		        $data_under['values'] = array(
		            $post_data['agent_code'][$ctr],
		            $post_data['agent_under'][$ctr],
		            $percen,
		            $post_data['agent_net'][$ctr],
		            $post_data["default_type".($ctr+1)],
		            $id_partner
		        );
		        update_table($conn, $data_under);
		    }
		}else{

			if ($post_data['agent_under'][$ctr]!="") {
				$data_under=null;
				$data_under['table'] = 'under';
				$data_under['columns'] = array(
		            'under_code',
		            'id_agent',
		            'percen_value',
		            'net_value',
		            'type_default',
		            'id_partner'
		        );

		        $percen = substr($_POST['agent_percent'][$ctr],0,-1);

		        $data_under['values'] = array(
		            $post_data['agent_code'][$ctr],
		            $post_data['agent_under'][$ctr],
		            $percen,
		            $post_data['agent_net'][$ctr],
		            $post_data["default_type".($ctr+1)],
		            $id_partner
		        );
		        insert_table($conn, $data_under);
	        }
	    }
	}

	$rela_products = get_rela_partner_to_product($conn,$_POST['id']);

	// $array_insert=array();
	// foreach ($rela_products as $rela){ 
		// if (!in_array($data['id'],$post_data['id_bank'])) { 
	if (isset($post_data['product_id'])) {
		$ctr = 0;
		$product_id = $post_data['product_id'];
		$data_rel_product['table'] = 'rela_partner_to_product';
		do {
			$duplicate_information = "false";
			// Duplicate information
			foreach ($rela_products as $rela){
				if($post_data['product_id'][$ctr]==$rela['id_product']){
					$duplicate_information = "true";
				}
			}

			if($duplicate_information=="false"){
				$data_rel_product['columns'] = array(
	            'id_partner',
	            'id_product'
	       		);
	        	$data_rel_product['values'] = array(
	            	$id_partner,
	            	$post_data['product_id'][$ctr]
	        	);
	      		insert_table ($conn, $data_rel_product);
	      	}

	    $ctr++;
		}while($ctr < count($product_id));
	}else{

	}

	for ($ctr=0;$ctr<count($post_data['id_contact']);$ctr++) {
		if($post_data['id_contact'][$ctr]!=""){
		$data_contact=null;
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
	        update_table($conn,$data_contact);
		}else{
	    $data_contact=null;
	    $contact_name = $post_data['contact_first_name'];
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

	        $data_rel=null;
	        $data_rel['table'] = 'rela_partner_to_contact';
	        $data_rel['columns'] = array(
	            'id_insurance_partner',
	            'id_contact'
	        );
	        
	        $data_rel['values'] = array(
	            $id_partner,
	            $contact_id
	        );
	        $contact_id = insert_table ($conn, $data_rel);
	    }
	 }
	// sqlsrv_close($conn);
}

function get_partner_contact ($conn, $id) {
    $result = array();
    $tsql = "select c.*,rc.id_insurance_partner as id_insurance_partner from contact c 
        left join rela_partner_to_contact rc on rc.id_contact = c.id
        where rc.id_insurance_partner = ".$id;
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

function get_rela_partner_to_product($conn, $id) {
	$result = array();
	$sql = "SELECT * FROM rela_partner_to_product WHERE id_partner = '".$id."'";
        $stmt = sqlsrv_query( $conn, $sql);
        if($stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
            $result[] = $row;
        }
	return $result;
}

function get_under($conn, $id) {
	$result = array();
	$sql = "SELECT * FROM under WHERE id_partner = '".$id."'";
        $stmt = sqlsrv_query( $conn, $sql);
        if($stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
            $result[] = $row;
        }
	return $result;
}


function delete_bank_list($conn, $post_data,$bank) {
	$array_delete=array();
	foreach ($bank as $data) {
		if (!in_array($data['id'],$post_data['id_bank'])) { 
        	array_push($array_delete,$data['id']);
    	}
	}
	foreach($array_delete as $value) {
		// echo '<script>alert("value: '.$value.'")</script>'; 
	// 	// $data['id'] = $_GET['id'];
		$data['id'] = $value;
		$data['table'] = 'bank';	
		delete_table ($conn, $data);
	}
	// sqlsrv_close($conn);
}

function delete_under_list($conn, $post_data,$under) {
	$array_delete=array();
	foreach ($under as $data) {
		if (!in_array($data['id'],$post_data['id_under'])) { 
        	array_push($array_delete,$data['id']);
    	}
	}
	foreach($array_delete as $value) {
		// echo '<script>alert("value: '.$value.'")</script>'; 
	// 	// $data['id'] = $_GET['id'];
		$data['id'] = $value;
		$data['table'] = 'under';	
		delete_table ($conn, $data);
	}
	// sqlsrv_close($conn);
}

function delete_contact_list($conn, $post_data,$contact) {
	$array_delete=array();
	foreach ($contact as $data) {
		if (!in_array($data['id'],$post_data['id_contact'])) { 
        	array_push($array_delete,$data['id']);
    	}
	}
	foreach($array_delete as $value) {
		// echo '<script>alert("value: '.$value.'")</script>';
		$data['id'] = $value;
		$data['table'] = 'contact';	
		delete_table ($conn, $data);
	}
}

function delete_rela_product_list($conn, $post_data,$rela_product) {
	// echo '<script>alert("start'.$rela_product[0]['id'].'")</script>'; 
	$array_delete=array();
	foreach($rela_product as $data) {
		if (!in_array($data['id_product'],$post_data['product_id'])) { 
        	array_push($array_delete,$data['id']);
    	}
	}
	foreach($array_delete as $value) {
		$data['id'] = $value;
		$data['table'] = 'rela_partner_to_product';	
		delete_table ($conn, $data);
	}

	// sqlsrv_close($conn);
}

?>
