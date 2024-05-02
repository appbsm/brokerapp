<?php
include_once('connect_sql.php');
include_once('fx_crud_db.php');


if (isset($_POST['action']) && $_POST['action'] == 'get_product') {
    $id = $_POST['id_product_categories'];
    $result = get_product_for_insurance($conn, $id);
    echo json_encode($result);
}

if (isset($_POST['action']) && $_POST['action'] == 'get_sub_cat') {
    $id = $_POST['id_product_categories'];
    $result = get_product_by_category($conn, $id);
    echo json_encode($result);
}

if (isset($_POST['action']) && $_POST['action'] == 'get_agent') {
    $id = $_POST['id_product_categories'];
    $result = get_agent_for_insurance($conn, $id);
    echo json_encode($result);
}

function get_agent_for_insurance($conn, $id) {
    $result = array();
    $tsql = "SELECT ag.id,ag.title_name,ag.first_name,ag.last_name,CONCAT(ag.title_name,' ',ag.first_name,' ',ag.last_name) as agent_namefull FROM rela_agent_to_insurance reag
JOIN agent ag ON ag.id = reag.id_agent
WHERE reag.id_insurance =  '{$id}' and ag.status = '1' "
." GROUP BY ag.id,ag.title_name,ag.first_name,ag.last_name ";
//     $tsql ="SELECT product.* FROM product
// join rela_partner_to_product ON product.id = rela_partner_to_product.id_product
// WHERE id_partner = ".$id;
    
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
	$tsql = "SELECT * FROM product ";
	
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

function get_currency($conn) {
    $result = array();
    $tsql = "SELECT * FROM currency_list where status = 1 ";
    
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

function get_insurance_company ($conn) {
    $result = array();
    $tsql = "SELECT * FROM insurance_partner ";
    
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

function get_customer_level ($conn) {
    $result = array();
    $tsql = "SELECT * FROM customer_level where status ='1' ";
    
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

function get_period ($conn) {
$result = array();
    $tsql = "SELECT * FROM period where status ='1' ";
    
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

function get_product_for_insurance($conn, $id) {
    $result = array();
    
    // $tsql = "SELECT * FROM product "
    //     . "WHERE id_product_categories = ".$id;
    
    $tsql ="SELECT product.* FROM product
join rela_partner_to_product ON product.id = rela_partner_to_product.id_product
WHERE id_partner = ".$id;

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

function get_product_by_category($conn, $id) {
    $result = array();
    
    $tsql = " SELECT * FROM product_subcategories"
        . " WHERE id_product_categorie = ".$id;
        
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

function get_customer_insurance ($conn, $id) {
    $result = array();
    $tsql = "select FORMAT(i.start_date, 'dd-MM-yyyy') as start_date_f,FORMAT(i.end_date, 'dd-MM-yyyy') as end_date_f,i.* from insurance_info i  "
        . "left join rela_customer_to_insurance ri on ri.id_insurance_info = i.id "
            . "where ri.id_customer = ".$id;
            
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
