# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]
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
