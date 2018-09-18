<?php
$url = "http://localhost/solution/orders.php?page=1&limit=10";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
echo "<pre>$result</pre>";
?>
