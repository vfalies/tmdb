# Tmdb - PHP Wrapper for The Movie Database API V3

[![Latest Stable Version](https://poser.pugx.org/vfalies/tmdb/version)](https://packagist.org/packages/vfalies/tmdb) [![Build Status](https://scrutinizer-ci.com/g/vfalies/tmdb/badges/build.png?b=master)](https://scrutinizer-ci.com/g/vfalies/tmdb/build-status/master) [![Code Coverage](https://scrutinizer-ci.com/g/vfalies/tmdb/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/vfalies/tmdb/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/vfalies/tmdb/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/vfalies/tmdb/?branch=master) [![License](https://poser.pugx.org/vfalies/tmdb/license)](https://packagist.org/packages/vfalies/tmdb)

![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/vfalies/tmdb)
[![Tested on PHP 7.1 to 8.0](https://img.shields.io/badge/tested%20on-PHP%207.1%20|%207.2%20|%207.3%20|%207.4%20|%208.0%20-brightgreen.svg?maxAge=2419200)](https://github.com/vfalies/tmdb/actions/workflows/php.yml)

Tmdb is a PHP wrapper for [The Movie Database](https://www.themoviedb.org/) API [V3](https://developers.themoviedb.org).

## Table of contents

1. [Features](#features)
2. [Installation](#installation)
3. [Basic usage](#basic-usage)
4. [Usage](#usage)
    1. [Getting a TMDB instance](#getting-a-tmdb-instance)
    2. [Movie](#movie)
    3. [TV Show](#tv-show)
    4. [Collection](#collection)
    5. [People](#people)
    6. [Company](#company)
    7. [Find by an external ID](#find)
    8. [Authentication](#authentication)
    9. [Media Helper](#media-helper)
5. [Unit tests](#unit-tests)
6. [About](#about)

## Features<a name="features"></a>

Features actualy supported :

- Search
  - Movie
  - TV Show
  - Collection
  - Company
- Getting informations
  - Movie
  - TV Show
  - Collection
  - Company
  - Genres
  - TV Network
- Account
  - Authentification
  - Movies / TV Shows rating
  - Movies / TV Shows favorites
  - Movies / TV Shows watchlist
- Media
- Genres
- Jobs
- Find
  - IMDb
  - TheTVDb
  - TVRage
  - Facebook
  - Twitter
  - Instagram

## Installation<a name="installation"></a>

### Requirements

- Tmdb works with PHP 7.1 and higher
- TheMovieDatabase API key

### Composer

Install the lastest version with

```bash
$ composer require vfalies/tmdb
```

## Basic Usage<a name="basic-usage"></a>

```php
<?php

require 'vendor/autoload.php';

use VfacTmdb\Factory;
use VfacTmdb\Search;
use VfacTmdb\Item;

// Initialize Wrapper
$tmdb = Factory::create()->getTmdb('your_api_key');

// Search a movie
$search    = new Search($tmdb);
$responses = $search->movie('star wars');

// Get all results
foreach ($responses as $response)
{
    echo $response->getTitle();
}

// Get movie information
$item  = new Item($tmdb);
$infos = $item->getMovie(11, array('language' => 'fr-FR'));

echo $infos->getTitle();
```

## Usage

### Getting a TMDB instance<a name="getting-a-tmdb-instance"></a>

`TMDB` is the main class of the library.
It has two dependencies :
- a API key from [The Movie DataBase website](https://www.themoviedb.org/)
- a `Psr\Log\LoggerInterface` instance to write logs

#### Using the Factory

It is the easiest way to load TMDB

```php
<?php
require 'vendor/autoload.php';

use VfacTmdb\Factory;

$tmdb = Factory::create()->getTmdb('your_api_key');
```

#### In a Slim application

If your application is built with [Slim](https://www.slimframework.com/), you can add TMDB in your dependencies and inject Slim's [Monolog](https://seldaek.github.io/monolog/) instance into it.
Just add this in `dependencies.php`

```php
$container['tmdb'] = function ($c) {
    $api_key = $c->get('settings')['tmdb']['api_key'];
    $tmdb = new \vfalies\tmdb\Tmdb($api_key, $c->logger);
}
```

In this example, API key is declared in `settings.php`

```php
return [
    'settings' = [
        'tmdb' = [
            'api_key' = 'your_api_key';
        ]
    ]
];
```

#### Do it yourself

Convenient if you need too inject your own dependencies. In the example below, we inject [Monolog](https://seldaek.github.io/monolog/) configured to write logs on standards output.

```php
<?php
require 'vendor/autoload.php';

use VfacTmdb\Tmdb;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('default', [new StreamHandler('php://stdout')])

$tmdb = Tmdb('your_api_key', $logger);
```

### Movie<a name="movie"></a>

#### Search a movie

```php
$search    = new Search($tmdb);
$responses = $search->movie('star wars');
```

The search returns [`Generator`](http://php.net/manual/en/class.generator.php) object of [`Result\Movie`](/public/docs/tmdb/class-VfacTmdb.Results.Movie.html) object.

[See demo](https://vfac.fr/projects/tmdb/demo/search-movie)

#### Get a movie

```php
$item  = new Item($tmdb);
$movie = $item->getMovie($movie_id);

echo $movie->getTitle();
```

The getter returns a [`Movie`](/public/docs/tmdb/class-VfacTmdb.Items.Movie.html) object.

[See demo](https://vfac.fr/projects/tmdb/demo/get-movie-details)

### TV Show<a name="tv-show"></a>

#### Search a TV Show

```php
$search    = new Search($tmdb);
$responses = $search->tvshow('game of thrones');
```

The search returns [`Generator`](http://php.net/manual/en/class.generator.php) object of [`Result\TVShow`](/public/docs/tmdb/class-VfacTmdb.Results.TVShow.html) object.

[See demo](https://vfac.fr/projects/tmdb/demo/search-tvshow)

#### Get a TV Show

```php
$item   = new Item($tmdb);
$tvshow = $item->getTVShow($tvshow_id);

echo $tvshow->getTitle();
```

The getter returns a [`TVShow`](/public/docs/tmdb/class-VfacTmdb.Items.TVShow.html) object.

[See demo](https://vfac.fr/projects/tmdb/demo/search-tvshow_details)

#### Get a TV Season

```php
$item     = new Item($tmdb);
$tvseason = $item->getTVSeason($tvshow_id, $season_number);

echo $tvseason->getName();
```

The getter returns a [`TVSeason`](/public/docs/tmdb/class-VfacTmdb.Items.TVSeason.html) object.

#### Get a TV Episode

```php
$item      = new Item($tmdb);
$tvepisode = $item->getTVEpisode($tvshow_id, $season_number, $episode_number);

echo $tvepisode->getName();
```

The getter returns a [`TVEpisode`](/public/docs/tmdb/class-VfacTmdb.Items.TVEpisode.html) object.

### Collection<a name="collection"></a>

#### Search a Collection

```php
$search    = new Search($tmdb);
$responses = $search->collection('alien');
```

The search returns [`Generator`](http://php.net/manual/en/class.generator.php) object of [`Result\Collection`](/public/docs/tmdb/class-VfacTmdb.Results.Collection.html) object.

[See demo](https://vfac.fr/projects/tmdb/demo/search-collection)

#### Get a Collection

```php
$item       = new Item($tmdb);
$collection = $item->getCollection($collection_id);

echo $collection->getName();
```

The getter returns a [`Collection`](/public/docs/tmdb/class-VfacTmdb.Items.Collection.html) object.

[See demo](https://vfac.fr/projects/tmdb/demo/get-collection-details)

### People<a name="people"></a>

#### Search a People

```php
$search    = new Search($tmdb);
$responses = $search->people('alec baldwin');
```

The search returns [`Generator`](http://php.net/manual/en/class.generator.php) object of [`Result\People`](/public/docs/tmdb/class-VfacTmdb.Results.People.html) object.

[See demo](https://vfac.fr/projects/tmdb/demo/search-people)

#### Get a People

```php
$item   = new Item($tmdb);
$people = $item->getPeople($people_id);

echo $people->getName();
```

The getter returns a [`People`](/public/docs/tmdb/class-VfacTmdb.Items.People.html) object.

[See demo](https://vfac.fr/projects/tmdb/demo/get-people-details)

### Company<a name="company"></a>

#### Search a company

```php
$search    = new Search($tmdb);
$responses = $search->company('lucasfilms');
```

The search returns [`Generator`](http://php.net/manual/en/class.generator.php) object of `Result\Company` object.

[See demo](https://vfac.fr/projects/tmdb/demo/search-company)

#### Get a Company

```php
$item   = new Item($tmdb);
$company = $item->getCompany($company_id);

echo $company->getName();
```

The getter returns a [`Company`](/public/docs/tmdb/class-VfacTmdb.Results.Company.html) object.

[See demo](https://vfac.fr/projects/tmdb/demo/get-company-details)

### Find by an external ID<a name="find"></a>

```php
$find = new Find($tmdb);
$responses = $find->imdb('tt0076759');
```

The find method makes it easy to search for objects in TMDb database by an external id.

Each sources has his proper methods: `imdb`, `tvdb`, `tvrage`, `facebook`, `twitter`, `instagram`.

The find returns a `Result\Find` object. Each types of objects can be getted by a specific method. The returns is a [`Generator`](http://php.net/manual/en/class.generator.php) object of `Result\[expected type]` object.

```php
$movies = $responses->getMovies();
$title  = $movies->current()->getTitle();
```

| Object types | Methods | Generator of |
|--------------|---------|--------------|
| movies | getMovies() | Result\Movie |
| peoples | getPeoples() | Result\People |
| TV shows | getTVShows() | Result\TVShow |
| TV episodes | getTVEpisodes() | Result\TVEpisode |
| TV Seasons | getTVSeasons() | Result\TVSeason |

The supported external sources for each object are as follows.

| | Movies | TV Shows | TV Seasons | TV Episodes | People |
|-|--------|----------|------------|-------------|--------|
| IMDb ID | &#10003; |&#10003; |&#10005; | &#10003; | &#10003; |
| TVDb ID | | &#10003; | &#10003; | &#10003; |&#10005; |
| Freebase MID | not implemented | | | | |
| Freebase ID  | not implemented | | | | |
| TVRage |&#10005; | &#10003; | &#10003; | &#10003; | &#10003; |
| Facebook | &#10003; | &#10003;  |&#10005; |&#10005; | &#10003; |
| Twitter | &#10003; | &#10003; |&#10005; |&#10005; | &#10003; |
| Instagram | &#10003; |&#10003; |&#10005; |&#10005; |&#10003; |

### Authentication<a name="authentication"></a>

The connection to your account is in 3 steps:

- Getting a request token
- Connection to TMDb website
- Create a session

#### Getting a request token

```php
$tmdb = Factory::create()->getTmdb('your_api_key');

$Auth = new Auth($tmdb);
echo $Auth->getRequestToken();
```

#### Connect to TMDb website

```php
$tmdb = Factory::create()->getTmdb('your_api_key');

$Auth = new Auth($tmdb);
$Auth->connect($_POST['request_token']);
```

This call redirect the page to TMDb website login page for identification and authorisations. By default, after the connection, the user stay on TMDb website. To redirect to your website after the connection, use the following code:

```php
$tmdb = Factory::create()->getTmdb('your_api_key');

$Auth = new Auth($tmdb);
$Auth->connect($_POST['request_token'], 'http://your_url');
```

#### Create a session

To use all account methods, we must use a valid session.

```php
$tmdb = Factory::create()->getTmdb('62dfe9839b8937e595e325a4144702ad');

$Auth = new Auth($tmdb);
echo $Auth->createSession($_POST['request_token']);
```

### Media Helper<a name="media-helper"></a>

All media informations delivered by the library are relative pathfile.

To get a valid media URL, use the `Media` class to generate the URL and check the media size

```php
$media = new Media($tmdb);
$url = $media->getPosterUrl('/AbJBXaVPrdXROwb8KmgWUPU2XJX.jpg');
```

The following type of media are supported :
- Backdrop
- Poster
- Logo
- Profile
- Still

## Unit Testing<a name="unit-tests"></a>

You can run the unit test suites using the following command in the library's source directory:

```
$ make test
```

## About<a name="about"></a>

### Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/vfalies/tmdb/issues)

### Author

Vincent Faliès - <vincent@vfac.fr>

### License

VfacTmdb is licensed under the MIT License - see the `LICENSE` file for details
