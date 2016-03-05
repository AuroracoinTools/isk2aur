<?php



$url = 'https://beta.isx.is/api/stats';
$json = file_get_contents($url);

$results = json_decode($json);

print_r($results->stats->last_price);


?>
