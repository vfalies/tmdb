# Tmdb - PHP Wrapper for The Movie Database API V3

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/6bf2cf4c-4b74-4a06-a5ca-afcc259df86e/big.png)](https://insight.sensiolabs.com/projects/6bf2cf4c-4b74-4a06-a5ca-afcc259df86e)

Tmdb is a PHP wrapper for [The Movie Database](https://www.themoviedb.org/) API [V3](https://developers.themoviedb.org).

Features actualy supported :

- Search
  - Movie
  - TV Show
  - Collection
- Getting informations
  - Movie
  - TV Show
  - Collection
  - Genres



## Installation

Install the lastest version with

```bash
$ composer require vfac/tmdb
```

## Basic Usage

```php
<?php

use Vfac\Tmdb;

// Initialize Wrapper
$tmdb = new Tmdb('your_api_key');

// Search a movie
$search    = new Search($tmdb);
$responses = $search->movie('star wars');

// Get title of the first result in API response
echo $search->getMovie($responses->current()->id)->getTitle();

// Get all results
foreach ($responses as $response)
{
    echo $search->getMovie($response->id)->getTitle();
}


```

## Documentation

## About

### Requirements

- Tmdb works with PHP 7.1 and higher
- Curl extension
- TheMovieDatabase API key

### Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/vfalies/tmdb/issues)

### Author

Vincent Faliès - <vincent.falies@gmail.com>

### License

VfacTmdb is licensed under the MIT License - see the `LICENSE` file for details
