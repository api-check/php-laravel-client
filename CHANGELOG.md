# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2026-04-01

### Changed
- **BREAKING**: Simplified architecture - now a thin wrapper around `api-check/php-client`
- All API methods are now accessed directly via the facade (e.g., `ApiCheck::verifyEmail()`)
- Removed `ApiClientAdapter` and `Manager` classes (no longer needed)
- Updated to require `api-check/php-client: ^2.0`

### Added
- Full IDE autocompletion support via facade PHPDoc
- `referer` config option for API keys with "Allowed Hosts"
- Helper function `apicheck()` as alternative to facade
- Comprehensive test suite
- Proper Laravel auto-discovery

### Fixed
- Bug where `search()` was calling `lookup()` internally
- Namespace consistency across all files

### Removed
- `ApiClientAdapter` class (functionality moved to underlying php-client)
- `Manager` class (no longer needed)
- Duplicate method definitions (all logic in php-client now)

## [1.0.0] - 2022-10-09

### Added
- Initial release
- Basic Laravel wrapper for ApiCheck API
- Facade support
- ServiceProvider with config publishing
