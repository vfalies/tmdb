# VfacTmdb - PHP Wrapper for The Movie Database API V3

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
$responses = $tmdb->searchMovie('star wars');

// Get title of the first result in API response
echo $responses[0]->getTitle();
```

## Documentation

## About

### Requirements

- VfacTmdb works with PHP 5.6 (5.3 ?) and above
- Curl extension is mandatory

### Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/vfac/tmdb/issues)

### Author

Vincent Faliès - <vincent.falies@gmail.com>

### License

VfacTmdb is licensed under the MIT License - see the `LICENSE` file for details