# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [1.12] - 2021-08-20

### Updated
- Remove PHPUnit result cache file during tests
### Added

- Add getCast() / getCrew() methods to TVShow / TVSeason / TVEpisode object

## [1.11] - 2021-04-29
### Updated
- Compatibility code & tests from PHP 7.1 to PHP 8.0

### Added

- Add log to change items

## [1.10] - 2021-04-24
### Updated

Implementing Item Changes: Thanks to Steve Richter for implementation

- Implement checkOptionDate and checkOptionDateRange in Tmdb & Tests
- Implement Change and Change Result, Implement itemChangeGenerator
- Add Tests for Change endpoint
- PHPCSFixer changes, Fix comments in various files
- Add Tests for Change Result
- Refactor date option validation
- Add Tests for Exceptions in Change class
- Fix getAdult() in Change Result
- Refactor Change class to better describe its purpose …
- Add support for retrieving changes to an item …
- Implement getChangeKeys method on ItemChanges Item Abstract
- Clean up code/comments, Rename TVItemChanges -> TVShowItemChanges
- Implement getItemChanges and getChanges methods on Items …
- Add Tests
- Apply Scrutinizer Fixes
- Update tests

## [1.9] - 2020-09-27
### Added

- Add find feature to find a movie / people / tv shows / tv episodes / tv seasons from external ID
  (IMDb, TVDb, TVRage, Faceboo, Twitter, Instagram)
- Add all documentations in [README.md](README.md)

### Changed

- Replace deprecated phpunit methods assertInternalType in all tests
- Fix Bug#49 https://github.com/vfalies/tmdb/issues/49#issue-706742315

## [1.8.2] - 2020-06-14
### Changed

- Update Guzzle version dependence in Composer

## [1.8.1] - 2020-03-28
### Changed

- Fix http response

## [1.8] - 2020-03-07
### Added

- Add Logo Result, Name Result, and TVNetwork item (SRichter contributor)

## [1.7.1] - 2020-03-07
### Added

- Add missing unit tests

## [1.7] - 2020-01-17
### Added

- Add get videos movie method

## [1.6.6] - 2020-01-16
### Changed

- Bug fix: TMdb blocking GET requests with post body

## [1.6.5] - 2019-09-28
### Changed

Updates for PHP 7.3 compatibility

- Update Monolog to 2.0
- Update PHP-CS to 2.15.3
- Add PHP 7.3 support in Travis & Scrutinizer configuration

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
- Correct docblo7cks params
- Fix API version
- Refactoring sendRequest method
- Fix all code in PSR-2 standard
- Upgrade to PHPUnit 6.2.4
- Change namespace from vfalies\tmdb to VfacTmdb
- Fix minor bugs

### Removed
- Remove compatibility PHP 5.6 & 7.0
