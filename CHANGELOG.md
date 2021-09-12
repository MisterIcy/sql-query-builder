# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
 - Added tests for OptionTrait in order to increase coverage.
 - Added support for simple LEFT / RIGHT / INNER JOINs

### Fixed
 - Fixed wrong behavior in OptionTrait's `unsetOption`.

### Changed
 - Operations now use the expression array of the parent class in order to reduce complexity.
 - Expression's `__toString` function is now abstract, meaning that all child classes must implement it.

## [0.1.0] - 2021-09-11
### Added
- The QueryBuilder is able to perform pretty complex Select operations.

[Unreleased]: https://github.com/MisterIcy/sql-query-builder/compare/0.1.0...HEAD
[0.1.0]: https://github.com/MisterIcy/sql-query-builder/releases/tag/0.1.0
