# Movies API

## Installation

1. Configurez votre clé API TMDB dans `config/config.php` :

```php
define('API_KEY', 'votre_clé_api');
```

2. Démarrez le serveur PHP :

```bash
php -S localhost:8000
```

3. Ouvrez votre navigateur sur `http://localhost:8000`

## Routes disponibles

GET /movies?type=popular - Films populaires
GET /movies?type=top_rated - Meilleurs films
GET /movies?type=upcoming - Films à venir
GET /search?query=terme - Rechercher des films
GET /movie/{id} - Détails d'un film

## Exemples de requêtes

Avec cURL :

```bash
curl "http://localhost:8000/movies?type=popular"
```

```bash
curl "http://localhost:8000/search?query=batman"
```

```bash
curl "http://localhost:8000/movie/268"
```

Avec JavaScript :

```javascript
fetch('http://localhost:8000/movies?type=popular')
  .then(response => response.json())
  .then(data => console.log(data));
```

```javascript
fetch('http://localhost:8000/search?query=batman')
  .then(response => response.json())
  .then(data => console.log(data));
```

```javascript
fetch('http://localhost:8000/movie/268')
  .then(response => response.json())
  .then(data => console.log(data));
```
