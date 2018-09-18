<?php
$url = "http://localhost/challenge/lalamove/solution/updateorder.php?id=1";
$data = array(
	'status'=>'taken' 	
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
