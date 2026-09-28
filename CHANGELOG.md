# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.1.0] - 2026-09-28

### Added
- Laravel 12 support
- `MissingApiKeyException` with a clear message when `APICHECK_API_KEY` is not configured

### Fixed
- Resolving the client without an API key no longer fails with an unclear `TypeError`
- Package config is now merged during `register()` so it is available to other providers before boot
- README no longer lists Laravel 9 as supported

### Changed
- Tests use PHPUnit attributes instead of doc-comment annotations (PHPUnit 12 compatible)
- CI no longer runs PHP 8.4 against Laravel 10 (unsupported combination)

### Removed
- Unused `provides()` method on the service provider (the provider was never deferred)
- Accidentally committed `.DS_Store` file

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
