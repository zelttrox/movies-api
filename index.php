<?php
$config = json_decode(file_get_contents('config.json'), true);
$apiKey = $config['API_KEY'];

echo $apiKey;
?>
