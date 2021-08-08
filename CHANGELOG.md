# ramsey/http-range Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## Unreleased

### Added

* Nothing.

### Changed

* Nothing.

### Deprecated

* Nothing.

### Removed

* Nothing.

### Fixed

* Nothing.

## 1.0.0 - 2018-12-31

ramsey/http-range provides functionality for parsing HTTP range headers for a
variety of range units. Out-of-the-box, ramsey/http-range supports
[bytes ranges as defined in RFC 7233 § 2.1](https://tools.ietf.org/html/rfc7233#section-2.1),
as well as basic support for generic
[range units](https://tools.ietf.org/html/rfc7233#section-2). The library
provides interfaces, abstract classes, and factories, allowing creation of
[other range units](https://tools.ietf.org/html/rfc7233#section-2.2).
