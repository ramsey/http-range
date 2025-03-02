# ramsey/http-range Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## 2.0.0 - 2025-03-02

### Added

- Nothing.

### Changed

- Update the minimum PHP version to 8.2
- Add type declarations to all properties, method parameters, and method returns
- The `$totalSize` parameters and `getTotalSize()` methods are now typed as
  `float | int | string` instead of `mixed`
- The `getStart()`, `getEnd()`, and `getLength()` methods on `UnitRangeInterface`
  now return `float | int | string` instead of `mixed`

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 1.2.1 - 2025-03-01

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Accept and properly parse spaces within ranges ([#7](https://github.com/ramsey/http-range/issues/7))

## 1.2.0 - 2025-03-01

### Added

- Support the use of psr/http-message, version 2 ([#9](https://github.com/ramsey/http-range/pull/9))

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 1.1.0 - 2021-08-08

### Added

- Support PHP 8

### Changed

- Bump minimum PHP version to 7.4

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 1.0.0 - 2018-12-31

ramsey/http-range provides functionality for parsing HTTP range headers for a
variety of range units. Out-of-the-box, ramsey/http-range supports
[bytes ranges as defined in RFC 7233 § 2.1](https://tools.ietf.org/html/rfc7233#section-2.1),
as well as basic support for generic
[range units](https://tools.ietf.org/html/rfc7233#section-2). The library
provides interfaces, abstract classes, and factories, allowing creation of
[other range units](https://tools.ietf.org/html/rfc7233#section-2.2).
