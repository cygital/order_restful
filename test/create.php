<?php
$url = "http://localhost/solution/order.php";
$data = array(
	'origin'=>array(40.6655101, -73.67098),
	'destination'=>array(40.6905615, -73.976592), 	
);

$ch = curl_init($url);
$jsondata = json_encode($data);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsondata);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
echo "<pre>$result</pre>";
?>
