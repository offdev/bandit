# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) 
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]
### Changed
- Updated dependencies to latest stable version
- Lever and Machine are now immutable
- Class properties are now typed (requires PHP 7.4)
- Changes parameter order for `EpsilonGreedy` strategy, so the random number generator can be omitted.

### Removed
- Removed useless class (Tester)
- Removed useless Exceptions

## [1.0.0] - 2017-02-17
### Added
- Change log itself
- Support for [PHPUnit 6.x](https://github.com/sebastianbergmann/phpunit)
- Travis now tests on PHP 7.1 too
- PHP-CS-Fixer now also checks the unit tests. I have principles too!
- Missing "Hook" functionality in the lats release. A shame no one uses my stuff and told me.. Locally everything was fine though :)

### Fixed
- Unit test for the hooking stuff

[Unreleased]: https://github.com/offdev/bandit/compare/1.0.0...master
[1.0.0]: https://github.com/offdev/bandit/compare/0.1.1...1.0.0