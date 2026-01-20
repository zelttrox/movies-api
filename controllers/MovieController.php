<?php
require_once__DIR__.'/../services/TMDBService.php';

class MovieController {
    public static function list($type) {
        $movies = TMDB::getMovies($type);
        echo json_encode($movies);
    }
}