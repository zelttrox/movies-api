<?php
require_once __DIR__.'/../services/TMDBService.php';

class MovieController {
    public static function list($type) {
        $movies = TMDBService::GetMovies($type);
        echo json_encode($movies);
    }

    public static function search($query) {
        $movies = TMDBService::SearchMovies($query);
        echo json_encode($movies);
    }

    public static function details($id) {
        $movie = TMDBService::GetMovieDetails($id);
        echo json_encode($movie);
    }
}