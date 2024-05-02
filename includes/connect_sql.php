<?php
    ini_set('mssql.charset', 'UTF-8');
	$serverName = "192.168.20.211,1433"; //serverName ???? Server
	$connectionInfo = array( "Database"=>"brokerapp", "UID"=>"sa", "PWD"=>"bsm@2015", "CharacterSet" => "UTF-8");

	$conn = sqlsrv_connect( $serverName, $connectionInfo);
	
	if( $conn ) {		
		//echo "Connection established.<br />";
	}else{
		echo "Connection could not be established.<br />";
		die( print_r( sqlsrv_errors(), true));
	}