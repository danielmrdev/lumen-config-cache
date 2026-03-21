# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

---

## Project Overview

**lumen-config-cache** is a Lumen package that adds `config:cache`-like functionality (via a custom Artisan command `lumen-config:cache`) to Lumen applications. It stores config values in the cache to reduce repeated filesystem access.

**Package Details:**
- Namespace: `Danielmrdev\ConfigCache` (v2.0.0+)
- Previous namespace: `Orumad\ConfigCache` (v1.x)
- PHP: ^8.1
- Lumen/Laravel (illuminate): ^9.0 | ^10.0 | ^11.0 | ^12.0
- Package Manager: Composer
- Current version: 2.0.0 (namespace/modernization rewrite)

---

## Important Notes

### v2.0.0 Breaking Changes

**This is a major version with breaking changes.**

- Namespace changed: `Orumad\ConfigCache` → `Danielmrdev\ConfigCache`
- Package name: `orumad/lumen-config-cache` → `danielmrdev/lumen-config-cache`
- PHP requirement raised to `^8.1`
- illuminate packages updated to `^9.0|^10.0|^11.0|^12.0`
- Migrated to GitHub Actions for CI/CD

Users on v1.x should update:
1. `composer require danielmrdev/lumen-config-cache:^2.0`
2. Update service provider registration: `Orumad\ConfigCache\...` → `Danielmrdev\ConfigCache\...`

---

## Development Commands

```bash
# Run all tests
composer test

# Run tests with coverage report (HTML in ./coverage)
composer test-coverage

# Install dependencies
composer install

# Update dependencies
composer update
```

---

## Continuous Integration & Automation

### GitHub Actions Workflows

**Tests** (`.github/workflows/tests.yml`)
- Runs on push/PR to main
- Matrix: PHP 8.1–8.4 × Laravel 9–12 × composer flags
- PHP 8.1 excluded from Laravel 11/12 (minimum is 8.2)
- Uploads coverage to Codecov

**Quality** (`.github/workflows/quality.yml`)
- Runs on push/PR to main
- PHPUnit with coverage reports
- PSR-2 code style checks via phpcs
- PHPStan static analysis (level 5)

**Release** (`.github/workflows/release.yml`)
- Triggers on git tag push (pattern: `v*`)
- Automatically updates `composer.json` version and `CHANGELOG.md`
- Creates GitHub Release page

**How to release:**
```bash
git tag v2.1.0
git push origin v2.1.0
# Workflow runs automatically and creates the GitHub Release
# Packagist picks up the tag within minutes
```

---

## Code Architecture

### Service Provider (`src/ServiceProviders/ConfigCacheServiceProvider.php`)

- Publishes the package config file (`config/config-cache.php`)
- Registers the `lumen-config:cache` Artisan command
- Binds `ConfigCache` class to the IoC container under `lumen-config-cache`

### Core Class (`src/ConfigCache.php`)

- Accepts config array, cache key, and expiration time in constructor
- `Cache::add()` stores config on first instantiation
- `get($key)` retrieves a dotted config key from cache
- `refresh()` clears the cache entry (called by the Artisan command)

### Artisan Command (`src/Commands/ConfigCacheCommand.php`)

- Signature: `lumen-config:cache`
- Calls `ConfigCache::refresh()` via the facade to clear and reload cache

### Facade (`src/Facades/ConfigCache.php`)

- Resolves `lumen-config-cache` from the IoC container
- Allows static-style usage: `ConfigCache::refresh()`

### Exception (`src/Exceptions/InvalidConfiguration.php`)

- `configFilesNotSpecified()`: thrown when `config_files` is empty in config

### Config File (`src/config/config-cache.php`)

- `cache_key`: string key used in the cache store
- `cache_expiration_time`: TTL in minutes
- `config_files`: array of config file names to cache (e.g., `['app', 'database']`)

---

## Key Files

| File | Purpose |
|------|---------|
| `src/ServiceProviders/ConfigCacheServiceProvider.php` | Package bootstrap & IoC bindings |
| `src/ConfigCache.php` | Core cache logic |
| `src/Commands/ConfigCacheCommand.php` | `lumen-config:cache` Artisan command |
| `src/Facades/ConfigCache.php` | Facade for static access |
| `src/Exceptions/InvalidConfiguration.php` | Config validation exceptions |
| `src/config/config-cache.php` | Package config file |
| `composer.json` | Dependencies and package metadata |
| `phpunit.xml.dist` | Test configuration |

---

## Code Style

- **Standard**: PSR-2 / Laravel
- **Indentation**: 4 spaces
- **Line Ending**: LF
- **Charset**: UTF-8
- **Tools**: GitHub Actions validates on push/PR
  - PSR-2 checks via phpcs
  - Static analysis via phpstan
  - Coverage reports via Codecov
