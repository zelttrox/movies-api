<?php
require_once __DIR__.'/../services/TMDBService.php';

class MovieController {
    public static function list($type) {
        $movies = TMDBService::GetMovies($type);
        echo json_encode($movies);
    }
}