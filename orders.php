<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include object files
include_once 'objects/db.php';
include_once 'objects/order.php';
 
// instantiate database and product object
$database = new Db();
$db = $database->doConnection();
 
// initialize object
$order = new Order($db);
 
// query orders
$page = (int)$_GET['page'];
$limit = (int)$_GET['limit'];
$stmt = $order->read($page, $limit);
$num = $stmt->rowCount();
// check if more than 0 record found
if($num>0){
 
    // orders array
    $orders_arr=array();
 
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        extract($row);
 
        $order_item=array(
            "id" => $id,
            "distance" => $distance,
            "status" => $status
        );
 
        array_push($orders_arr, $order_item);
    }
	http_response_code(200);
    echo json_encode($orders_arr);
}
 
else{
	http_response_code(500);
    echo json_encode(
        array("error" => "No order(s) found.")
    );
}
?>
