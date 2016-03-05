<?php

//get the price from ISX market and store as $iskaur
$url = 'https://beta.isx.is/api/stats';
$json = file_get_contents($url);
$json = json_decode($json);
$iskaur = $json->stats->last_price;

?>
