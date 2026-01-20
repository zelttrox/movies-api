<?php
$config = json_decode(file_get_contents('config'), true);
$apiKey = $config['API_KEY'];

echo $apiKey;
?>
