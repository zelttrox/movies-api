<?php
$config = json_decode(file_get_contents('config'), true);
class TMDBService {
	public static function GetMovies() {
        $url = $config['API_URL']."/movie/$type?api_key=".$config['API_KEY']."&language=fr-FR";
        $response = file_get_contents($url);
        return json_decode($response,true);
	}
}
?>