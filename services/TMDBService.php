<?php

class TMDBService {
	public static function GetMovies($type) {
    $config = require __DIR__.'/../config/config.php';
    $url = $config['API_URL'] . "/movie/{$type}?api_key=" . $config['API_KEY'] . "&language=fr-FR";
    return self::makeRequest($url);
	}

	public static function SearchMovies($query) {
    $config = require __DIR__.'/../config/config.php';
    $encodedQuery = urlencode($query);
    $url = $config['API_URL'] . "/search/movie?api_key=" . $config['API_KEY'] . "&language=fr-FR&query={$encodedQuery}";
    return self::makeRequest($url);
	}

	public static function GetMovieDetails($id) {
    $config = require __DIR__.'/../config/config.php';
    $url = $config['API_URL'] . "/movie/{$id}?api_key=" . $config['API_KEY'] . "&language=fr-FR";
    return self::makeRequest($url);
	}

	private static function makeRequest($url) {
    try {
        $response = @file_get_contents($url);
        if ($response === false) {
            return ['error' => 'Impossible de se connecter à l\'API TMDB'];
        }
        return json_decode($response, true);
    } catch (Exception $e) {
        return ['error' => 'Erreur de connexion: ' . $e->getMessage()];
    }
	}
}
?>