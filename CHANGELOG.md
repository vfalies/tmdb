# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## Unreleased
### Changed
- Update guzzlehttp/guzzle from 6.3.2 to 6.3.3
- Update guzzlehttp/guzzle from 6.3.1 to 6.3.2
- Update PHPUnit version to 7.0+

## [1.6.4] - 2018-03-27
### Changed
- Update guzzlehttp/guzzle from 6.3.0 to 6.3.1

## [1.6.3] - 2017-12-11
### Changed
- Fix return type if null in result company
- Add PHP 7.2 support in Travis & Scrutinizer configuration

## [1.6.2] - 2017-10-20
### Changed
- Upgrade PHPUnit to version 6.4.x
- Fix Guzzle call

## [1.6.1] - 2017-10-19
### Changed
- Fix PHP Version in composer.json

## [1.6.0] - 2017-10-16
### Added
- Add authentification methods
- Add account methods (favorite, watchlist, rated)
- Add postRequest & deleteRequest method
- Add PHP-CS-Fixer tool in composer and git-hook to use PSR-2 standard
- Add return method types and params types for compatibility PHP 7.1
- Add tests to check API url
- Active PHP strict mode

### Changed
- Refactoring code for simplification
- Correct docblocks params
- Fix API version
- Refactoring sendRequest method
- Fix all code in PSR-2 standard
- Upgrade to PHPUnit 6.2.4
- Change namespace from vfalies\tmdb to VfacTmdb
- Fix minor bugs

### Removed
- Remove compatibility PHP 5.6 & 7.0
