<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
//dependent files
include_once 'objects/db.php';
include_once 'objects/order.php';
 
$database = new Db();
$db = $database->doConnection();
 
$order = new Order($db);
 
$error = null;
$id = (int)$_GET['id'];
// get client data
$data = json_decode(file_get_contents("php://input"));
//check availability
$order->id = $id;
if($order->getStatus() == 'taken'){
	http_response_code(500);
    echo '{';
        echo '"error": "order has been taken"';
    echo '}';
} else {
	// set property of order to be edited
	$order->status = $data->status;
	// update
	if($order->update()){
		http_response_code(200);
		echo '{';
			echo '"status": "SUCCESS"';
		echo '}';
	}
	 
	// if unable to update
	else{
		http_response_code(500);
		echo '{';
			echo '"error": "Unable to update order."';
		echo '}';
	}
}
?>