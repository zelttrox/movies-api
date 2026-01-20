<?php

class TMDBService {
	public static function GetMovies($type) {
    $config = require __DIR__.'/../config/config.php';
    $url = $config['API_URL']."/movie/$type?api_key=".$config['API_KEY']."&language=fr-FR";
        $response = file_get_contents($url);
        return json_decode($response,true);
	}
}
?>