<?php

require_once 'controllers/MovieController.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Servir les fichiers statiques du dossier public
if ($path === '/' || $path === '/index.html') {
    header("Content-Type: text/html");
    readfile(__DIR__ . '/public/index.html');
    exit;
}

if ($path === '/style.css') {
    header("Content-Type: text/css");
    readfile(__DIR__ . '/public/style.css');
    exit;
}

if ($path === '/app.js') {
    header("Content-Type: application/javascript");
    readfile(__DIR__ . '/public/app.js');
    exit;
}

if ($path === '/favicon.ico') {
    http_response_code(204);
    exit;
}

// API Routes
header("Content-Type: application/json");
if (str_starts_with($path, '/movies')) {
    $type = $_GET['type'] ?? 'popular';
    MovieController::list($type);
} else if (str_starts_with($path, '/search')) {
    $query = $_GET['query'] ?? '';
    if (empty($query)) {
        http_response_code(400);
        echo json_encode(["error" => "Le paramètre 'query' est requis"]);
    } else {
        MovieController::search($query);
    }
} else if (str_starts_with($path, '/movie')) {
    if (preg_match('/\/movie\/(\d+)/', $path, $matches)) {
        $id = $matches[1];
        MovieController::details($id);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "ID de film invalide"]);
    }
} else {
    http_response_code(404);
    echo json_encode(["error" => "Route inconnue"]);
}
?>
