<?php

include_once('fx_crud_db.php');

function get_provinces($conn) {
	$result = array();
	$tsql = "SELECT * FROM provinces ";
	
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

function get_district_by_province($conn, $id_province) {
	$result = array();
	$tsql = "SELECT * FROM district "
		. "WHERE province_code = ".$id_province;
	
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

function get_district_by_province_name($conn, $p_name) {
	$result = array();
	$tsql = "SELECT * FROM district "
		. "WHERE name_en = '".$p_name."'";
	
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

function get_subdistrict_by_district($conn, $district_code) {
	$result = array();
	$tsql = "SELECT * FROM subdistrict "
		. "WHERE district_code = '".$district_code."'";
	
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
