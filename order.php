<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include object files
include_once 'objects/db.php';
include_once 'objects/order.php';
 
$database = new Db();
$db = $database->doConnection();
 
$order = new Order($db);
 
$error = null;
$distance = null;

// get client data
$data = json_decode(file_get_contents("php://input"));

//get distance from google
$response = @file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$data->origin[0].",".$data->origin[1]."&destinations=".$data->destination[0].",".$data->destination[1]."&key=".$order->google_key);

if($response){
	$result = json_decode($response);
	if(isset($result->rows[0]->elements[0]->distance->value)){
		$distance = $result->rows[0]->elements[0]->distance->value;
	}
}

if($distance){
	// set order property values
	$order->start_latitude = $data->origin[0];
	$order->start_longitude = $data->origin[1];
	$order->end_latitude = $data->destination[0];
	$order->end_longitude = $data->destination[1];
	$order->distance = $distance;
	$order->created = date('Y-m-d H:i:s');
	 
	// create the order
	if($id = $order->create()){
		http_response_code(200);
		echo '{';
			echo '"id": '.$id.',';
			echo '"distance": '.$distance.',';
			echo '"status": "UNASSIGN"';
		echo '}';
	} else {
		$error = 'Unable to create order.';
	}
} else {
	$error = 'Unable to get distance';
}
 
// Something went wrong
if($error != null){
	http_response_code(500);
    echo '{';
        echo '"error": "'.$error.'"';
    echo '}';
}
?>