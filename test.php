<?php

echo "=== Test de la Movies API ===\n\n";

// Test 1: Vérifier que les fichiers existent
echo "Test 1: Vérification des fichiers\n";
$files = [
    'config/config.php',
    'controllers/MovieController.php',
    'services/TMDBService.php',
    'public/index.html',
    'public/app.js',
    'public/style.css'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "  ✓ $file\n";
    } else {
        echo "  ✗ $file - MANQUANT\n";
    }
}

// Test 2: Vérifier que les classes existent
echo "\nTest 2: Vérification des classes\n";
require_once 'controllers/MovieController.php';
require_once 'services/TMDBService.php';

$classes = ['MovieController', 'TMDBService'];
foreach ($classes as $class) {
    if (class_exists($class)) {
        echo "  ✓ Classe $class trouvée\n";
    } else {
        echo "  ✗ Classe $class - MANQUANTE\n";
    }
}

// Test 3: Vérifier que les méthodes existent
echo "\nTest 3: Vérification des méthodes\n";
$methods = [
    'MovieController::list',
    'MovieController::search', 
    'MovieController::details',
    'TMDBService::GetMovies',
    'TMDBService::SearchMovies',
    'TMDBService::GetMovieDetails'
];

foreach ($methods as $method) {
    [$class, $methodName] = explode('::', $method);
    if (method_exists($class, $methodName)) {
        echo "  ✓ $method existe\n";
    } else {
        echo "  ✗ $method - MANQUANTE\n";
    }
}

// Test 4: Vérifier les fichiers HTML/JS
echo "\nTest 4: Vérification des fichiers HTML/JS\n";
$html = file_get_contents('public/index.html');
$checks = [
    'search-input' => preg_match('/id="search-input"/', $html),
    'search-btn' => preg_match('/id="search-btn"/', $html),
    'movie-modal' => preg_match('/id="movie-modal"/', $html),
    'filter-buttons' => preg_match('/class="filter-buttons"/', $html)
];

foreach ($checks as $element => $found) {
    echo $found ? "  ✓ Élément '$element' trouvé\n" : "  ✗ Élément '$element' - MANQUANT\n";
}

// Test 5: Vérifier que le CSS est correct
echo "\nTest 5: Vérification du CSS\n";
$css = file_get_contents('public/style.css');
$cssChecks = [
    'search-input styles' => preg_match('/.search-input/', $css),
    'modal styles' => preg_match('/.modal/', $css),
    'modal-content' => preg_match('/.modal-content/', $css)
];

foreach ($cssChecks as $check => $found) {
    echo $found ? "  ✓ $check\n" : "  ✗ $check - MANQUANT\n";
}

// Test 6: Vérifier que le JavaScript est correct
echo "\nTest 6: Vérification du JavaScript\n";
$js = file_get_contents('public/app.js');
$jsChecks = [
    'searchMovies function' => preg_match('/async function searchMovies/', $js),
    'openMovieModal function' => preg_match('/async function openMovieModal/', $js),
    'handleSearch function' => preg_match('/async function handleSearch/', $js),
    'search-btn listener' => preg_match('/search-btn.*addEventListener/', $js)
];

foreach ($jsChecks as $check => $found) {
    echo $found ? "  ✓ $check\n" : "  ✗ $check - MANQUANT\n";
}

// Test 7: Vérifier la clé API
echo "\nTest 7: Vérification de la configuration API\n";
$config = require 'config/config.php';
if (isset($config['API_KEY']) && !empty($config['API_KEY'])) {
    echo "  ✓ Clé API configurée\n";
} else {
    echo "  ✗ Clé API manquante ou vide\n";
}

if (isset($config['API_URL']) && !empty($config['API_URL'])) {
    echo "  ✓ URL API configurée\n";
} else {
    echo "  ✗ URL API manquante ou vide\n";
}

echo "\n=== Test terminé ===\n";

?>
