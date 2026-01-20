<?php

$type = $_GET['type']??null;

if (!$type) {
    http_response_code(400);
    echo json_encode(['error' => 'Type manquant']);
    exit;

} 
?>
