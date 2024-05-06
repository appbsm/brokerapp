<?php

function insert_table ($conn, $data) {	
	$last_insert = '';
	// print_r($conn);
	//$table = 'customer';
	$columns = implode("   ,   ",$data['columns']);
	$values  = implode('   ,   ', array_fill_keys($data['columns'], '?'));
	/* Set up the parameterized query. */  
	$tsql = 'SET NOCOUNT ON; ';
	$tsql .= "INSERT INTO ".$data['table']." (".$columns.") "
			. "VALUES " 
			. "(".$values.") ";  
	$tsql .= "SELECT SCOPE_IDENTITY() AS NewID;";
	 // echo "<br>".$tsql;
	/* Set parameter values. */  
	$params_ = $data['values'];
	$params = implode("   ,   ",$params_); 
	// echo "<br>COLUMNS:<br>";
	// print_r($data['columns']);	
	// echo "<br>";
	// echo "<br>PARAMS:<br>";
	// print_r(explode(',', $params) );
	/* Prepare and execute the query. */  
	$stmt = sqlsrv_query( $conn, $tsql, explode('   ,   ',$params) );	
	if ( $stmt ) {  
	    //$last_insert = $conn->insert_id;
	    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {	        
	        $last_insert  = $row['NewID'];	        
	    }
	    //$last_insert = $row['id'];
	    sqlsrv_commit( $conn );
		// echo "Row successfully inserted.\n";  
	} else {  
		// echo "Row insertion failed.\n";  
		// die(print_r(sqlsrv_errors(), true));  
	}  	
	// sqlsrv_close($conn);
	
	return $last_insert;
} 

function update_table ($conn, $data) {
	// echo '<script>alert("start")</script>'; 
	foreach ($data['columns'] as $col) {
		$str = $col.' = ?';
		$field_update[] = $str;
	}
	$fields = implode("   ,   ", $field_update);
	$tsql = "UPDATE ".$data['table']." SET "
		. $fields
		. ' where id = ? ';	
	$params_ = $data['values'];
	$params_[] = $data['id'];
	$params = implode("   ,   ",$params_);
	// alert('222');
	// echo $tsql;
	// print_r($params);
	// echo "ID".$data['id'];
	// $sql_test = "UPDATE ".$data['table']." SET ". $params_. ' where id =  '.$data['id'];	
	// echo '<script>alert("tsql: '.$sql_test.'")</script>'; 
	$stmt = sqlsrv_query( $conn, $tsql, explode('   ,   ', $params) );
	// alert('333');
	if( $stmt ) {
		//echo "Worked";
		sqlsrv_commit( $conn );
	}
	else {
		die( print_r( sqlsrv_errors(), true));
	}
	// sqlsrv_close($conn);	
}

function delete_table ($conn, $data) {
	$tsql = "DELETE FROM ".$data['table']
		. ' where id = ? ';	
	$params_[] = $data['id'];
	$params = implode(",", $params_);
	$stmt = sqlsrv_query( $conn, $tsql, explode(',', $params) );
	if( $stmt ) {
		// echo "Worked";
		sqlsrv_commit( $conn );
	}
	else {
		// die( print_r( sqlsrv_errors(), true));
	}
	// sqlsrv_close($conn);
}



// TEST
function update_table_working ($conn, $data) {
	//$name = 'My';
	//$id = 141;
	foreach ($data['columns'] as $col) {
		$str = $col.' = ?';
		$field_update[] = $str;
	}
	$fields = implode(",", $field_update);
	$tsql = "UPDATE ".$data['table']." SET "
		. $fields
		. ' where id = ? ';
	//print_r($tsql);
	/*
	$tsql = "UPDATE ".$data['table']." SET first_name = ? "
			. "Where id = ?";*/
	$params_ = $data['values'];
	$params_[] = $data['id'];
	$params = implode(",", $params_);
	//$params2 = array($name, $id);
	$stmt2 = sqlsrv_query( $conn, $tsql, explode(',', $params) );
	if( $stmt2 ) {
		// echo "Worked";
		sqlsrv_commit( $conn );
	}
	else {
		// die( print_r( sqlsrv_errors(), true));
	}
}

function update_table_bk ($conm, $data) {
	$field_update = array();
	
	foreach ($data['columns'] as $col) {
		$str = $col.' = ( ?)';
		$field_update[] = $str;
	}
	$fields = implode(",", $field_update);
	$tsql = "UPDATE ".$data['table']." SET "
		//. "(".$fields.") "
		. $fields
		. ' where id = ? ';
	/*$tsql = "UPDATE ".$data['table']." SET first_name = 'My' "
			. "Where id = 141";*/
	/* Set parameter values. */ 
	
	$params = array();
	$params[] = $data['id'];
	$params_ = array();
	$temp    = array();
	$i       = 0;
	foreach ( $data['values'] as $param) {
		$temp[$i]  = array(&$param);
		$params_[] = $temp[$i];
		$i++;
	}
	$params_[] = array(&$data['id']);
	$params = $params_;
	
	
	// Execute the statement for each order.
	
	//$params = $data['values'];   
	//$params[] = &$data['id'];   
	
	// print_r($tsql);
	// echo "<br>";
	// print_r($params);
	//print_r( $params );
	/* Prepare and execute the query. */  
	//$params = array();
	$stmt = sqlsrv_prepare($conn, $tsql, $params); 
	if( !$stmt ) {
		// die( print_r( sqlsrv_errors(), true));
	}
	( sqlsrv_execute( $stmt ));
	if( sqlsrv_execute( $stmt ) === false ) {
          // die( print_r( sqlsrv_errors(), true));
    }
	
	
	/*
	if( sqlsrv_execute( $stmt ) === false ) {
		die( print_r( sqlsrv_errors(), true));
	}*/
	/*
	$rows_affected = sqlsrv_rows_affected( $stmt);
	if( $rows_affected === false) {
		 die( print_r( sqlsrv_errors(), true));
	} elseif( $rows_affected == -1) {
		  echo "No information available.<br />";
	} else {
		  echo $rows_affected." rows were updated.<br />";
	}
	*/
	 /*
	if ($stmt) {  
		echo "Row successfully update.\n";  
	} else {  
		echo "Row update failed.\n";  
		die(print_r(sqlsrv_errors(), true));  
	}  	
	*/
	sqlsrv_close($conn);
}
 ?>
