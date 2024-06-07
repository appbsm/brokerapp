<?php

function update_policy_status($dbh,$_POST) {

	$sql_reason = "";
	if($_POST['inputData'] == "Not renew"){
		$sql_reason = ",reason='".$_POST['textarea']."'";
	}

	$sql ="UPDATE insurance_info set udate='".date('Y-m-d H:i:s')."',modify_by='".$_SESSION['id']."',status='".$_POST['inputData']."'".$sql_reason." where id IN (";
	$ids = implode(", ", $_POST['selectedCheckboxes']);
    $sql .= $ids . ")";
	$query = $dbh->prepare($sql); 
	$query->execute();
	// return $sql;
}

function update_policy($dbh,$_POST,$_FILES,$new_file_name,$lastInsertId_customer,$i) {


	// ,premium_rate=:premium_rate_p
	$sql_policy_primary ="";

	// if($_POST['payment_status'][$i] == "Renew" && ($_POST['policy'][$i] == $_POST['policy_old'][$i]) ){
	// 	echo '<script>alert("lastInsertId: '.$lastInsertId_customer.'")</script>'; 
	// 	$sql_policy_primary =",policy_type=:policy_type_p,policy_primary=:policy_primary_p";
	// }

	// policy_old[]

	//////////// upload ////////////
	if($_FILES['file_d']['name'][$i]!=""){
		$sql_upload_file = ",file_name=:file_name_p,file_name_uniqid=:file_name_uniqid_p";
	}

	$sql ="UPDATE insurance_info set insurance_company=:insurance_company_p
				,policy_no =:policy_no_p
				,status=:status_p,product_category=:product_category_p,sub_categories=:sub_categories_p
				,insurance_company_id=:insurance_company_id_p,product_id=:product_id_p
				,period=:period_p,period_type=:period_type_p,period_day=:period_day_p
				,start_date=:start_date_p,end_date=:end_date_p
				,premium_rate=:premium_rate_p
				,convertion_value=:convertion_value_p
				,percent_trade=:percent_trade_p
				,commission_rate=:commission_rate_p
				,agent_id=:agent_id_p
				,default_insurance=:default_insurance_p
						,calculate_type=:calculate_type_p,payment_status=:payment_status_p,paid_date=:paid_date_p
						,udate=GETDATE(),modify_by=:modify_by_p,reason=:reason_p,remark=:remark_p
				 ".$sql_upload_file.
						" where id ='".$_POST['id_insurance_info'][$i]."'";
				$query = $dbh->prepare($sql); 

				$query->bindParam(':insurance_company_p',$_POST['insurance_company'][$i],PDO::PARAM_STR);
				$query->bindParam(':policy_no_p',$_POST['policy'][$i],PDO::PARAM_STR);
				$query->bindParam(':status_p',$_POST['status'][$i],PDO::PARAM_STR);
				$query->bindParam(':product_category_p',$_POST['product_cat'][$i],PDO::PARAM_STR);
				$query->bindParam(':sub_categories_p',$_POST['sub_cat'][$i],PDO::PARAM_STR);

				$query->bindParam(':insurance_company_id_p',$_POST['insurance_com'][$i],PDO::PARAM_STR);
				$query->bindParam(':product_id_p',$_POST['product_name'][$i],PDO::PARAM_STR);

				$null_value;
				if($_POST['period_type'][$i]=='Month'){
					$query->bindParam(':period_type_p',$_POST['period_type'][$i],PDO::PARAM_STR);
					$query->bindParam(':period_p',$_POST['period_month'][$i],PDO::PARAM_STR);
					$query->bindParam(':period_day_p',$null_value,PDO::PARAM_STR);
				}else{
					$query->bindParam(':period_type_p',$_POST['period_type'][$i],PDO::PARAM_STR);
					$query->bindParam(':period_p',$null_value,PDO::PARAM_STR);
					$query->bindParam(':period_day_p',$_POST['period_day'][$i],PDO::PARAM_STR);
				}

				$query->bindParam(':start_date_p',date("Y-m-d", strtotime($_POST['start_date'][$i])),PDO::PARAM_STR);
				$query->bindParam(':end_date_p',date("Y-m-d", strtotime($_POST['end_date'][$i])),PDO::PARAM_STR);

				$per = substr($_POST['percent_trade'][$i],0,-1);

				$premium_rate_p = (float) str_replace(',', '', $_POST['convertion_value'][$i]);
				$query->bindParam(':premium_rate_p',$premium_rate_p,PDO::PARAM_STR);

				$convertion_value_p = (float) str_replace(',', '', $_POST['premium_rate'][$i]);
				$query->bindParam(':convertion_value_p',$convertion_value_p,PDO::PARAM_STR);

				$percent_trade_p = (float) str_replace(',', '', $per);
				$query->bindParam(':percent_trade_p',$percent_trade_p,PDO::PARAM_STR);

				$commission_rate_p = (float) str_replace(',', '',$_POST['commission'][$i]);
				$query->bindParam(':commission_rate_p',$commission_rate_p,PDO::PARAM_STR);
					

				$query->bindParam(':agent_id_p',$_POST['agent'][$i],PDO::PARAM_STR);
				$query->bindParam(':payment_status_p',$_POST['payment_status'][$i],PDO::PARAM_STR);

				$query->bindParam(':calculate_type_p',$_POST['calculate'][$i],PDO::PARAM_STR);

				if($_POST['status'][$i]=="Follow up" || $_POST['status'][$i]=="Wait" || $_POST['status'][$i]=="Not renew"){

					if (empty($_POST['paid_date_old'][$i])) {
						$value_null = null;
						$query->bindParam(':paid_date_p',$value_null,PDO::PARAM_NULL);
					}else{
						$query->bindParam(':paid_date_p',date("Y-m-d", strtotime($_POST['paid_date_old'][$i])),PDO::PARAM_STR);
					}
					
				}else{
					$query->bindParam(':paid_date_p',date("Y-m-d", strtotime($_POST['paid_date'][$i])),PDO::PARAM_STR);
				}

				$query->bindParam(':reason_p',$_POST['textarea_detail'][$i],PDO::PARAM_STR);

				$query->bindParam(':modify_by_p',$_SESSION['id'],PDO::PARAM_STR);

				$query->bindParam(':remark_p',$_POST['remark'][$i],PDO::PARAM_STR);
				 
				if($start_policy=="true"){
					$value=1;
					$query->bindParam(':default_insurance_p',$value,PDO::PARAM_STR);
					$start_policy="false";
				}else{
					$value=0;
					$query->bindParam(':default_insurance_p',$value,PDO::PARAM_STR);
				}

				
				//////////// upload ////////////
				if($_FILES['file_d']['name'][$i]!=""){
						$query->bindParam(':file_name_p',$_FILES['file_d']['name'][$i],PDO::PARAM_STR);
						$query->bindParam(':file_name_uniqid_p',$new_file_name,PDO::PARAM_STR);
				}
				////////////////////////////////////
				
				$query->execute();


				$sql_update = "update rela_customer_to_insurance set id_customer=:id_customer_p,id_default_contact=:id_default_contact_p".
				" where id_insurance_info=".$_POST['id_insurance_info'][$i];

				$query = $dbh->prepare($sql_update); 
				$query->bindParam(':id_customer_p',$lastInsertId_customer,PDO::PARAM_STR);
				$query->bindParam(':id_default_contact_p',$_POST['id_co'][0],PDO::PARAM_STR);

				$query->execute();
}

function update_rela_customer_to_insurance($dbh,$_POST,$lastInsertId_customer,$i) {
	$sql = "update rela_customer_to_insurance set id_customer=:id_customer_p,id_default_contact=:id_default_contact_p
		 where id_insurance_info=".$_POST['id_insurance_info'][$i];
	$query = $dbh->prepare($sql); 
	$query->bindParam(':id_customer_p',$lastInsertId_customer,PDO::PARAM_STR);
	$query->bindParam(':id_default_contact_p',$_POST['id_co'][0],PDO::PARAM_STR);
	$query->execute();

}

function insert_policy_renew($dbh,$_POST,$_FILES,$new_file_name,$lastInsertId_customer,$i) {

	if($_POST['policy_type'][$i]==""){
		$sql_update = "update insurance_info set policy_type=:policy_type_p,policy_primary=:policy_primary_p 
				where id ='".$_POST['id_insurance_info'][$i]."'";
		$query = $dbh->prepare($sql_update);
		$policy_type = "primary";
		$query->bindParam(':policy_type_p',$policy_type,PDO::PARAM_STR);
		$query->bindParam(':policy_primary_p',$_POST['id_insurance_info'][$i],PDO::PARAM_STR);
		$query->execute();
	}

	$sql = "INSERT INTO insurance_info".
				"(insurance_company,policy_no,status,product_category,sub_categories".
				",insurance_company_id,product_id,period,period_type,period_day,start_date,end_date".
				",premium_rate".
				",convertion_value".
				",percent_trade,commission_rate,agent_id,file_name".
				",file_name_uniqid,default_insurance,calculate_type,payment_status,paid_date,commission_status,cdate,create_by,reason,remark,policy_type,policy_primary)";
			$sql=$sql." VALUES (:insurance_company_p,:policy_no_p,:status_p,:product_category_p,:sub_categories_p".
					",:insurance_company_id_p,:product_id_p,:period_p,:period_type_p,:period_day_p,:start_date_p,:end_date_p".
					",:premium_rate_p".
					",:convertion_value_p".
					",:percent_trade_p,:commission_rate_p,:agent_id_p,:file_name_p".
					",:file_name_uniqid_p,:default_insurance_p,:calculate_type_p,:payment_status_p,:paid_date_p,:commission_status_p,GETDATE(),:create_by_p,:reason_p,:remark_p,:policy_type_p,:policy_primary_p)";

				$query = $dbh->prepare($sql); 

				$query->bindParam(':insurance_company_p',$_POST['insurance_company'][$i],PDO::PARAM_STR);
				$query->bindParam(':policy_no_p',$_POST['policy'][$i],PDO::PARAM_STR);
				$query->bindParam(':status_p',$_POST['status'][$i],PDO::PARAM_STR);
				$query->bindParam(':product_category_p',$_POST['product_cat'][$i],PDO::PARAM_STR);
				$query->bindParam(':sub_categories_p',$_POST['sub_cat'][$i],PDO::PARAM_STR);

				$query->bindParam(':insurance_company_id_p',$_POST['insurance_com'][$i],PDO::PARAM_STR);
				$query->bindParam(':product_id_p',$_POST['product_name'][$i],PDO::PARAM_STR);

				$null_value;
				if($_POST['period_type'][$i]=='Month'){
					$query->bindParam(':period_type_p',$_POST['period_type'][$i],PDO::PARAM_STR);
					$query->bindParam(':period_p',$_POST['period_month'][$i],PDO::PARAM_STR);
					$query->bindParam(':period_day_p',$null_value,PDO::PARAM_STR);
				}else{
					$query->bindParam(':period_type_p',$_POST['period_type'][$i],PDO::PARAM_STR);
					$query->bindParam(':period_p',$null_value,PDO::PARAM_STR);
					$query->bindParam(':period_day_p',$_POST['period_day'][$i],PDO::PARAM_STR);
				}
				// $query->bindParam(':period_p',$_POST['period'][$i],PDO::PARAM_STR);

				$query->bindParam(':start_date_p',date("Y-m-d", strtotime($_POST['start_date'][$i])),PDO::PARAM_STR);
				$query->bindParam(':end_date_p',date("Y-m-d", strtotime($_POST['end_date'][$i])),PDO::PARAM_STR);

				$premium_rate_p = (float) str_replace(',','',$_POST['convertion_value'][$i]);
				$query->bindParam(':premium_rate_p',$premium_rate_p,PDO::PARAM_STR);

				$convertion_value_p = (float) str_replace(',','',$_POST['premium_rate'][0]);
				$query->bindParam(':convertion_value_p',$convertion_value_p,PDO::PARAM_STR);

				// $per = substr($_POST['percent_trade'][$i],0,-1);
				$percent_trade_p = (float) str_replace(',','',substr($_POST['percent_trade'][0],0,-1));
				$query->bindParam(':percent_trade_p',$percent_trade_p,PDO::PARAM_STR);

				$commission_rate_p = (float) str_replace(',','',$_POST['commission'][$i]);
				$query->bindParam(':commission_rate_p',$commission_rate_p,PDO::PARAM_STR);

				$query->bindParam(':agent_id_p',$_POST['agent'][$i],PDO::PARAM_STR);
				$query->bindParam(':payment_status_p',$_POST['payment_status'][$i],PDO::PARAM_STR);

				$query->bindParam(':calculate_type_p',$_POST['calculate'][$i],PDO::PARAM_STR);

				$query->bindParam(':paid_date_p',date("Y-m-d", strtotime($_POST['paid_date'][$i])),PDO::PARAM_STR);

				$commission_status = "Not Paid";
				$query->bindParam(':commission_status_p',$commission_status,PDO::PARAM_STR);

				$query->bindParam(':reason_p',$_POST['textarea_detail'][$i],PDO::PARAM_STR);

				$query->bindParam(':create_by_p',$_SESSION['id'],PDO::PARAM_STR);
				// $query->bindParam(':modify_by_p',$_SESSION['id'],PDO::PARAM_STR);

				$query->bindParam(':remark_p',$_POST['remark'][$i],PDO::PARAM_STR);

				$value=1;
				$query->bindParam(':default_insurance_p',$value,PDO::PARAM_STR);

				$policy_type = "sub";
				$query->bindParam(':policy_type_p',$policy_type,PDO::PARAM_STR);

				if($_POST['policy_type'][$i]==""){
					$query->bindParam(':policy_primary_p',$_POST['id_insurance_info'][$i],PDO::PARAM_STR);
				}else{
					$query->bindParam(':policy_primary_p',$_POST['policy_primary'][$i],PDO::PARAM_STR);
				}


		// //////////// upload ////////////
		// $new_file_name="";
		// // echo '<script>alert("post file_d : '.$_FILES['file_d']['name'][$i].'")</script>'; 
		// if($_FILES['file_d']['name'][$i]!=""){
		// 	try {
		// 		$file = $_FILES['file_d']['name'][$i];
		// 		$file_loc = $_FILES['file_d']['tmp_name'][$i];
		// 		// $image=$_POST['file_d'];
		// 		$folder=$sourceFilePath;
		// 		$ext = pathinfo($file, PATHINFO_EXTENSION);
		// 		$new_file_name = uniqid().".".$ext;
		// 		$path_file = $folder."/".$new_file_name;
		// 		$final_file=str_replace(' ','-',$new_file_name);
		// 		move_uploaded_file($file_loc,$folder.$final_file);    
		// 	}catch(Exception $e) {
		// 		// echo '<script>alert("Error : '.$e.'")</script>'; 
		// 	}
		// }

		// ////////////////////////////////////
				
				$query->bindParam(':file_name_p',$_FILES['file_d']['name'][$i],PDO::PARAM_STR);
				$query->bindParam(':file_name_uniqid_p',$new_file_name,PDO::PARAM_STR);
				////////////
				$query->execute();
				// print_r($query->errorInfo());
				$lastInsertId_insurance = $dbh->lastInsertId();

				// echo '<script>alert("lastInsertId_insurance: '.$lastInsertId_insurance.'")</script>'; 

				// $query = $dbh->prepare($sql_update); 
				// $query->bindParam(':id_customer_p',$lastInsertId_customer,PDO::PARAM_STR);
				// $query->bindParam(':id_insurance_info_p',$lastInsertId_insurance,PDO::PARAM_STR);
				// $query->bindParam(':id_default_insurance_p',$lastInsertId_customer,PDO::PARAM_STR);
				// $query->bindParam(':id_default_contact_p',$_POST['id_co'][0],PDO::PARAM_STR);
				// $query->execute();

				$sql = "INSERT INTO rela_customer_to_insurance".
					"(id_customer,id_insurance_info,id_default_insurance,id_default_contact)";
				$sql=$sql." VALUES (:id_customer_p,:id_insurance_info_p,:id_default_insurance_p,:id_default_contact_p)";
				$query = $dbh->prepare($sql); 
				$query->bindParam(':id_customer_p',$lastInsertId_customer,PDO::PARAM_STR);
				$query->bindParam(':id_insurance_info_p',$lastInsertId_insurance,PDO::PARAM_STR);
				$query->bindParam(':id_default_insurance_p',$lastInsertId_insurance,PDO::PARAM_STR);
				// $query->bindParam(':id_default_insurance_p',$_POST['id_insurance_info'][0],PDO::PARAM_STR);
				$query->bindParam(':id_default_contact_p',$_POST['id_co'][0],PDO::PARAM_STR);
				$query->execute();

				// print_r($query->errorInfo());

}

function insert_history_policy($dbh,$_POST,$lastInsertId_customer,$type_insert) {
	$lastInsertId_contact_default=0;

	$sql = "INSERT INTO report_history_policy
					(id_insurance_info,policy_no,start_date,end_date
			   ,premium_rate
			   ,convertion_value
			   ,percent_trade,commission_rate,payment_status
			   ,insurance_company_id,insurance_company_name,status,agent_id
			   ,customer_id,customer_name,tel,mobile,email,paid_date,type,contact_id_default,modify_by,cdate)  VALUES  
				(:id_insurance_info_p,:policy_no_p,:start_date_p,:end_date_p
			   ,:premium_rate_p
			   ,:convertion_value_p
			   ,:percent_trade_p,:commission_rate_p,:payment_status_p
			   ,:insurance_company_id_p,:insurance_company_name_p,:status_p,:agent_id_p
			   ,:customer_id_p,:customer_name_p,:tel_p,:mobile_p,:email_p,:paid_date_p,:type_p,:contact_id_default_p,:modify_by_p,GETDATE()) ";

				$query = $dbh->prepare($sql); 
				$query->bindParam(':id_insurance_info_p',$_POST['id_insurance_info'][0],PDO::PARAM_STR);
				$query->bindParam(':policy_no_p',$_POST['policy'][0],PDO::PARAM_STR);
				
				$query->bindParam(':start_date_p',date("Y-m-d", strtotime($_POST['start_date'][0])),PDO::PARAM_STR);
				$query->bindParam(':end_date_p',date("Y-m-d", strtotime($_POST['end_date'][0])),PDO::PARAM_STR);

				$premium_rate_p = (float) str_replace(',','',$_POST['convertion_value'][0]);
				$query->bindParam(':premium_rate_p',$premium_rate_p,PDO::PARAM_STR);

				$convertion_value_p = (float) str_replace(',','',$_POST['premium_rate'][0]);
				$query->bindParam(':convertion_value_p',$convertion_value_p,PDO::PARAM_STR);

				$percent_trade_p = (float) str_replace(',','',substr($_POST['percent_trade'][0],0,-1));
				$query->bindParam(':percent_trade_p',$percent_trade_p,PDO::PARAM_STR);

				$commission_rate_p = (float) str_replace(',','',$_POST['commission'][0]);
				$query->bindParam(':commission_rate_p',$commission_rate_p,PDO::PARAM_STR);


				$query->bindParam(':payment_status_p',$_POST['payment_status'][0],PDO::PARAM_STR);

				$query->bindParam(':insurance_company_id_p',$_POST['insurance_com'][0],PDO::PARAM_STR);
				$query->bindParam(':insurance_company_name_p',$_POST['product_name'][0],PDO::PARAM_STR);
				$query->bindParam(':status_p',$_POST['status'][0],PDO::PARAM_STR);
				$query->bindParam(':agent_id_p',$_POST['agent'][0],PDO::PARAM_STR);

				$query->bindParam(':customer_id_p',$lastInsertId_customer,PDO::PARAM_STR);
				$query->bindParam(':customer_name_p',$_POST['name_c_input'],PDO::PARAM_STR);
				$query->bindParam(':tel_p',$_POST['tel_c_input'],PDO::PARAM_STR);
				$query->bindParam(':mobile_p',$_POST['mobile_c_input'],PDO::PARAM_STR);
				$query->bindParam(':email_p',$_POST['email_c_input'],PDO::PARAM_STR);
				$query->bindParam(':paid_date_p',date("Y-m-d", strtotime($_POST['paid_date'][0])),PDO::PARAM_STR);
				
				$query->bindParam(':type_p',$type_insert,PDO::PARAM_STR);
				$query->bindParam(':contact_id_default_p',$lastInsertId_contact_default,PDO::PARAM_STR);
				$query->bindParam(':modify_by_p',$_SESSION['id'],PDO::PARAM_STR);

				$query->execute();
}

function get_rela_insurance($dbh,$id) {
	$results = array();
	$sql = "SELECT * FROM rela_customer_to_insurance WHERE id_insurance_info ='".$id."'";
	$query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	return $results;
}

function get_insurance($dbh,$id_policy) {
	$results = array();
	// $sql = "SELECT * FROM rela_customer_to_insurance WHERE id_insurance_info ='".$id."'";
	$sql = " SELECT ip.id_currency_list,cl.currency,cc.currency_value,cc.currency_value_convert,
	FORMAT(insurance_info.start_date, 'dd-MM-yyyy') as start_date_f,FORMAT(end_date, 'dd-MM-yyyy') as end_date_f 
	,FORMAT(insurance_info.paid_date, 'dd-MM-yyyy') as paid_date_f
					 ,cl.currency,ct.id AS customer_id_ct,ct.customer_name AS customer_name_ct,ct.customer_type 
					 ,ct.customer_id AS customer_id_ct,re_ci.id_customer,insurance_info.id as id_insurance_info,insurance_info.*
					  from insurance_info 
					 JOIN rela_customer_to_insurance re_ci ON re_ci.id_insurance_info = insurance_info.id 
					 LEFT JOIN customer ct ON ct.id = re_ci.id_customer 
					 LEFT JOIN insurance_partner ip ON ip.id = insurance_info.insurance_company_id 
					 LEFT JOIN currency_list cl ON ip.id_currency_list = cl.id 
					 LEFT JOIN currency_convertion cc ON  cc.id = 
				(SELECT TOP 1 c_c.id FROM currency_convertion c_c WHERE  c_c.id_currency_list = ip.id_currency_list
 				AND  insurance_info.start_date >= c_c.start_date and insurance_info.start_date <= c_c.stop_date and c_c.status='1')
					 WHERE   insurance_info.id =".$id_policy;
					 // insurance_info.default_insurance = 1 and
	$query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	return $results;
}

function get_company($dbh) {
	$results = array();
	$sql = " SELECT ip.id AS id_partner,*,cl.currency from insurance_partner ip
	JOIN currency_list cl ON ip.id_currency_list = cl.id
	WHERE ip.status = 1 ";
	$query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	return $results;
}

function get_product($dbh,$insurance_company_id) {
	$results = array();
	$sql = " SELECT pr.* FROM product pr
	JOIN rela_partner_to_product rp ON rp.id_product = pr.id
	WHERE rp.id_partner = ".$insurance_company_id;
	$query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	return $results;
}

function get_period($dbh) {
	$results = array();
	$sql = " SELECT * from period WHERE status = 1 order by LEN(period) ";
	$query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	return $results;
}

function get_agent_old($dbh,$insurance_company_id) {
		$results = array();
	$sql = " SELECT CONCAT(ag.title_name,' ',ag.first_name,' ',ag.last_name) as agent_namefull,MIN(ag.id) id
 		,ag.title_name,ag.first_name,ag.last_name 
 		FROM under un 
 		LEFT JOIN agent ag ON ag.id = un.id_agent 
 		WHERE ag.status = '1' and id_partner = '".$insurance_company_id."' GROUP BY ag.first_name,ag.last_name,ag.title_name";
	$query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	return $results;
}

function get_customer_level($dbh) {
	$results = array();
	$sql = " SELECT * from customer_level WHERE status = 1 ";
	$query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	return $results;
}

function get_categories($dbh) {
	$results = array();
	$sql = " SELECT * from product_categories WHERE status = 1 order by id asc ";
	$query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	return $results;
}

function get_sub($dbh,$product_cat) {
	$results = array();
	$sql_sub = " SELECT * from product_subcategories WHERE status = 1 AND id_product_categorie = '".$product_cat."'";
	$query = $dbh->prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	return $results;
}

?>
